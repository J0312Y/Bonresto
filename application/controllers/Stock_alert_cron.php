<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Stock Alert Cron Controller
 *
 * Called daily via cron job to send email + push notifications
 * for ingredients that are below their minimum stock level.
 *
 * Usage (cron):
 *   curl -s "https://yourdomain.com/stock_alert_cron/run?key=YOUR_CRON_KEY"
 *
 * Or via CLI:
 *   php index.php stock_alert_cron run YOUR_CRON_KEY
 */
class Stock_alert_cron extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->db->query('SET SESSION sql_mode = ""');
    }

    public function run($cli_key = null)
    {
        // Protect with cron key
        $key = $cli_key ?: $this->input->get('key');
        $this->config->load('saas_email', true);
        $valid_key = $this->config->item('saas_cron_key', 'saas_email');

        if (empty($key) || $key !== $valid_key) {
            http_response_code(403);
            echo json_encode(['error' => 'Invalid cron key']);
            return;
        }

        // Check if stock alert is enabled and if it's the right time
        $setting = $this->db->select('stock_alert_enabled, stock_alert_time, timezone')->get('setting')->row();
        if (empty($setting) || $setting->stock_alert_enabled != 1) {
            echo json_encode(['status' => 'ok', 'message' => 'Stock alert is disabled']);
            return;
        }

        // Set timezone from settings
        if (!empty($setting->timezone)) {
            date_default_timezone_set($setting->timezone);
        }

        // Check if current time matches alert time (allow force with &force=1)
        $force = $this->input->get('force');
        $alert_time = !empty($setting->stock_alert_time) ? $setting->stock_alert_time : '08:00';
        $current_time = date('H:i');
        if ($force != '1' && $current_time !== $alert_time) {
            echo json_encode(['status' => 'ok', 'message' => 'Not alert time. Current: ' . $current_time . ', Alert: ' . $alert_time]);
            return;
        }

        // Get low stock ingredients
        $items = $this->db->query("
            SELECT i.id, i.ingredient_name, i.stock_qty, i.min_stock, u.uom_short_code AS unit
            FROM ingredients i
            LEFT JOIN unit_of_measurement u ON u.id = i.uom_id
            WHERE i.stock_qty < i.min_stock AND i.min_stock > 0
            ORDER BY (i.stock_qty / i.min_stock) ASC
        ")->result();

        if (empty($items)) {
            echo json_encode(['status' => 'ok', 'message' => 'No low stock items']);
            return;
        }

        $email_sent = $this->_send_email($items);
        $push_sent  = $this->_send_push($items);

        echo json_encode([
            'status'     => 'ok',
            'low_stock'  => count($items),
            'email_sent' => $email_sent,
            'push_sent'  => $push_sent,
        ]);
    }

    /**
     * Send email to all admin users
     */
    private function _send_email($items)
    {
        // Get email config from DB
        $email_config = $this->db->get('email_config')->row();
        if (empty($email_config) || empty($email_config->sender)) {
            log_message('error', 'Stock Alert: No email config found');
            return false;
        }

        // Get admin emails
        $admins = $this->db->select('email, firstname, lastname')
            ->where('is_admin', 1)
            ->where('status', 1)
            ->get('user')
            ->result();

        if (empty($admins)) {
            log_message('error', 'Stock Alert: No admin users found');
            return false;
        }

        // Get restaurant name
        $setting = $this->db->select('title')->get('setting')->row();
        $restaurant_name = !empty($setting->title) ? $setting->title : 'Bonresto';

        // Build email body
        $html = $this->_build_email_html($items, $restaurant_name);

        // Configure email
        $config = [
            'protocol'  => $email_config->protocol,
            'smtp_host' => $email_config->smtp_host,
            'smtp_port' => $email_config->smtp_port,
            'smtp_user' => !empty($email_config->smtp_user) ? $email_config->smtp_user : $email_config->sender,
            'smtp_pass' => $email_config->smtp_password,
            'smtp_crypto' => !empty($email_config->smtp_crypto) ? $email_config->smtp_crypto : 'tls',
            'mailtype'  => 'html',
            'charset'   => 'utf-8',
        ];

        $this->load->library('email');
        $this->email->initialize($config);
        $this->email->set_newline("\r\n");
        $this->email->set_mailtype("html");

        $sent = false;
        foreach ($admins as $admin) {
            $this->email->clear();
            $this->email->from($email_config->sender, $restaurant_name);
            $this->email->to($admin->email);
            $this->email->subject('Alerte Stock Bas - ' . count($items) . ' ingredient(s) - ' . $restaurant_name);
            $this->email->message($html);

            if ($this->email->send()) {
                $sent = true;
                log_message('info', 'Stock Alert: Email sent to ' . $admin->email);
            } else {
                log_message('error', 'Stock Alert: Failed to send email to ' . $admin->email);
            }
        }

        return $sent;
    }

    /**
     * Send FCM push notification to admin/staff
     */
    private function _send_push($items)
    {
        $this->load->library('notification');

        $out_of_stock = 0;
        $low_stock = 0;
        foreach ($items as $item) {
            if ($item->stock_qty <= 0) {
                $out_of_stock++;
            } else {
                $low_stock++;
            }
        }

        $title = 'Alerte Stock Bas';
        $parts = [];
        if ($out_of_stock > 0) {
            $parts[] = $out_of_stock . ' en rupture';
        }
        if ($low_stock > 0) {
            $parts[] = $low_stock . ' stock bas';
        }
        $message = implode(', ', $parts) . '. ';

        // Top 3 most critical items
        $top = array_slice($items, 0, 3);
        $names = [];
        foreach ($top as $item) {
            $names[] = $item->ingredient_name . ' (' . number_format($item->stock_qty, 0) . '/' . number_format($item->min_stock, 0) . ')';
        }
        $message .= implode(', ', $names);

        // Get admin FCM tokens
        $tokens = $this->db->select('waiter_kitchenToken')
            ->where('is_admin', 1)
            ->where('status', 1)
            ->where("waiter_kitchenToken != ''")
            ->where('waiter_kitchenToken IS NOT NULL')
            ->get('user')
            ->result();

        $token_list = [];
        foreach ($tokens as $t) {
            if (!empty($t->waiter_kitchenToken)) {
                $token_list[] = $t->waiter_kitchenToken;
            }
        }

        // Also get staff tokens
        $staff_tokens = $this->db->select('user.waiter_kitchenToken')
            ->from('user')
            ->join('employee_history', 'employee_history.emp_his_id = user.id', 'left')
            ->where("user.waiter_kitchenToken != ''")
            ->where('user.waiter_kitchenToken IS NOT NULL')
            ->get()
            ->result();

        foreach ($staff_tokens as $t) {
            if (!empty($t->waiter_kitchenToken) && !in_array($t->waiter_kitchenToken, $token_list)) {
                $token_list[] = $t->waiter_kitchenToken;
            }
        }

        if (empty($token_list)) {
            log_message('info', 'Stock Alert: No FCM tokens found for push notification');
            return false;
        }

        // Send via FCM
        $this->config->load('notification', true);
        $api_key = $this->config->item('fcm_key_staff', 'notification');

        if (empty($api_key)) {
            log_message('error', 'Stock Alert: No FCM API key configured');
            return false;
        }

        $fields = [
            'registration_ids' => $token_list,
            'data' => [
                'message'    => $message,
                'title'      => $title,
                'vibrate'    => 1,
                'sound'      => 1,
            ],
            'notification' => [
                'sound' => 'default',
                'title' => $title,
                'body'  => $message,
            ],
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: key=' . $api_key,
            'Content-Type: application/json',
        ]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        curl_close($ch);

        log_message('info', 'Stock Alert: Push sent to ' . count($token_list) . ' devices. Result: ' . $result);
        return true;
    }

    /**
     * Build HTML email body
     */
    private function _build_email_html($items, $restaurant_name)
    {
        $date = date('d/m/Y');
        $count = count($items);

        $html = '
        <!DOCTYPE html>
        <html>
        <head><meta charset="utf-8"></head>
        <body style="font-family:Arial,sans-serif;background:#f5f5f5;padding:20px;">
            <div style="max-width:600px;margin:0 auto;background:#fff;border-radius:10px;overflow:hidden;box-shadow:0 2px 10px rgba(0,0,0,0.1);">
                <div style="background:#c0392b;color:#fff;padding:20px;text-align:center;">
                    <h2 style="margin:0;">Alerte Stock Bas</h2>
                    <p style="margin:5px 0 0;opacity:0.9;">' . htmlspecialchars($restaurant_name) . ' - ' . $date . '</p>
                </div>
                <div style="padding:20px;">
                    <p style="font-size:15px;color:#333;">
                        <strong>' . $count . ' ingredient' . ($count > 1 ? 's' : '') . '</strong>
                        ' . ($count > 1 ? 'sont' : 'est') . ' en dessous du seuil minimum de stock.
                    </p>
                    <table style="width:100%;border-collapse:collapse;margin:15px 0;">
                        <thead>
                            <tr style="background:#f8f8f8;">
                                <th style="padding:10px;border:1px solid #ddd;text-align:left;">Ingredient</th>
                                <th style="padding:10px;border:1px solid #ddd;text-align:right;">Stock actuel</th>
                                <th style="padding:10px;border:1px solid #ddd;text-align:right;">Stock min.</th>
                                <th style="padding:10px;border:1px solid #ddd;text-align:center;">Statut</th>
                            </tr>
                        </thead>
                        <tbody>';

        foreach ($items as $item) {
            $status_color = ($item->stock_qty <= 0) ? '#c0392b' : '#e67e22';
            $status_label = ($item->stock_qty <= 0) ? 'RUPTURE' : 'BAS';
            $unit = !empty($item->unit) ? ' ' . htmlspecialchars($item->unit) : '';

            $html .= '
                            <tr>
                                <td style="padding:8px 10px;border:1px solid #ddd;">' . htmlspecialchars($item->ingredient_name) . '</td>
                                <td style="padding:8px 10px;border:1px solid #ddd;text-align:right;color:' . $status_color . ';font-weight:bold;">' . number_format($item->stock_qty, 2) . $unit . '</td>
                                <td style="padding:8px 10px;border:1px solid #ddd;text-align:right;">' . number_format($item->min_stock, 2) . $unit . '</td>
                                <td style="padding:8px 10px;border:1px solid #ddd;text-align:center;">
                                    <span style="background:' . $status_color . ';color:#fff;padding:3px 8px;border-radius:3px;font-size:11px;font-weight:bold;">' . $status_label . '</span>
                                </td>
                            </tr>';
        }

        $html .= '
                        </tbody>
                    </table>
                    <p style="font-size:13px;color:#888;margin-top:15px;text-align:center;">
                        Cet email est envoy&eacute; automatiquement chaque jour. Connectez-vous pour g&eacute;rer votre stock.
                    </p>
                </div>
            </div>
        </body>
        </html>';

        return $html;
    }
}
