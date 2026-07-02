<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Notification Library
 *
 * Librairie centralisée pour l'envoi de notifications push
 * via FCM (Firebase Cloud Messaging) et OneSignal.
 */
class Notification
{
    private $CI;

    public function __construct()
    {
        $this->CI =& get_instance();
        $this->CI->config->load('notification', true);
    }

    // =========================================================================
    //  COMMANDES
    // =========================================================================

    /**
     * Commande passée — notifie le client + le staff cuisine/serveurs
     */
    public function order_placed($order_id, $amount, $customer_token = null)
    {
        $title   = 'Nouvelle commande passée';
        $message = 'Numéro de commande: ' . $order_id . ' Montant de la commande: ' . number_format($amount, 2);

        // Notification client (OneSignal)
        if ($customer_token) {
            $this->_send_onesignal(
                $this->_config('onesignal_customer_app_id'),
                [$customer_token],
                $title,
                $message,
                ['type' => 'order place']
            );
        }

        // Notification staff cuisine/serveurs (FCM)
        $staff_tokens = $this->_get_staff_tokens();
        if (!empty($staff_tokens)) {
            $this->_send_fcm(
                $this->_config('fcm_key_staff'),
                $staff_tokens,
                $title,
                'Numéro de commande: ' . $order_id . ', Montant: ' . number_format($amount, 2)
            );
        }

        // Notification serveurs iOS (OneSignal broadcast)
        $this->_send_onesignal_broadcast(
            $this->_config('onesignal_waiter_ios_app_id'),
            $title,
            $message,
            ['type' => 'order place']
        );
    }

    /**
     * Commande acceptée — notifie le client
     */
    public function order_accepted($order_id, $amount, $customer_token)
    {
        if (!$customer_token) return;

        $title = 'Votre commande est acceptée';
        $body  = 'Numéro de commande: ' . $order_id . ' Montant: ' . number_format($amount, 2);

        $this->_send_fcm_single(
            $this->_config('fcm_key_customer'),
            $customer_token,
            $title,
            $body
        );
    }

    /**
     * Commande en cours de préparation — notifie le serveur assigné + optionnellement le client
     */
    public function order_preparing($order_id, $item_name, $amount, $waiter_token, $customer_token = null)
    {
        $title = 'En cours de préparation';
        $body  = 'Numéro de commande : ' . $order_id . ', Nom de l\'article : ' . $item_name . ' Montant: ' . number_format($amount, 2);

        if ($waiter_token) {
            $this->_send_fcm(
                $this->_config('fcm_key_staff'),
                [$waiter_token],
                $title,
                $body
            );
        }

        if ($customer_token) {
            $this->_send_fcm_single(
                $this->_config('fcm_key_customer'),
                $customer_token,
                $title,
                $body
            );
        }
    }

    /**
     * La nourriture est prête — notifie le serveur assigné + optionnellement le client
     */
    public function food_ready($order_id, $item_name, $amount, $waiter_token, $customer_token = null)
    {
        $title = 'La nourriture est prête';
        $body  = 'Numéro de commande : ' . $order_id . ', Nom de l\'article : ' . $item_name . ' Montant: ' . number_format($amount, 2);

        if ($waiter_token) {
            $this->_send_fcm(
                $this->_config('fcm_key_staff'),
                [$waiter_token],
                $title,
                $body
            );
        }

        if ($customer_token) {
            $this->_send_fcm_single(
                $this->_config('fcm_key_customer'),
                $customer_token,
                $title,
                $body
            );
        }
    }

    /**
     * Commande terminée — notifie le client
     */
    public function order_completed($order_id, $customer_token)
    {
        if (!$customer_token) return;

        $title = 'Commande terminée';
        $body  = 'Votre commande #' . $order_id . ' est terminée. Merci pour votre confiance !';

        $this->_send_fcm_single(
            $this->_config('fcm_key_customer'),
            $customer_token,
            $title,
            $body
        );
    }

    /**
     * Commande passée avec succès (Hungry/QR) — notifie le client
     */
    public function order_confirmed($order_id, $customer_token)
    {
        if (!$customer_token) return;

        $title = 'Commande passée avec succès !!';
        $body  = 'Votre identifiant de commande: ' . $order_id . ' Placé avec succès. Veuillez attendre servi';

        $this->_send_fcm_single(
            $this->_config('fcm_key_hungry'),
            $customer_token,
            $title,
            $body
        );
    }

    /**
     * Commande rejetée — notifie le client
     */
    public function order_rejected($order_id, $item_name, $reason, $customer_token)
    {
        if (!$customer_token) return;

        $title = 'Votre commande est rejetée';
        $body  = 'Numéro de commande : ' . $order_id . ', Nom de l\'article : ' . $item_name . ' Raison: ' . $reason;

        $this->_send_fcm_single(
            $this->_config('fcm_key_customer'),
            $customer_token,
            $title,
            $body
        );
    }

    /**
     * Mise à jour de commande QR réussie — notifie le client
     */
    public function order_updated($order_id, $customer_token)
    {
        if (!$customer_token) return;

        $title = 'Mise à jour de la commande réussie !!';
        $body  = 'Votre identifiant de commande: ' . $order_id . ' Mise à jour avec succès.';

        $this->_send_fcm_single(
            $this->_config('fcm_key_hungry'),
            $customer_token,
            $title,
            $body
        );
    }

    // =========================================================================
    //  RÉSERVATIONS
    // =========================================================================

    /**
     * Nouvelle réservation — notifie le client
     */
    public function new_reservation($customer_name, $table_name, $customer_token)
    {
        if (!$customer_token) return;

        $title   = 'Nouvelle réservation';
        $message = 'Cher Monsieur / Madame ' . $customer_name . ' Table: ' . $table_name . ' Votre réservation en cours...';

        $this->_send_onesignal(
            $this->_config('onesignal_customer_app_id'),
            [$customer_token],
            $title,
            $message,
            ['type' => 'reservation']
        );
    }

    /**
     * Réservation confirmée — notifie le client
     */
    public function reservation_confirmed($customer_name, $table_name, $customer_token)
    {
        if (!$customer_token) return;

        $title   = 'Réservation confirmée';
        $message = 'Cher Monsieur / Madame ' . $customer_name . ' Table: ' . $table_name . ' Votre réservation a été confirmée.';

        $this->_send_onesignal(
            $this->_config('onesignal_customer_app_id'),
            [$customer_token],
            $title,
            $message,
            ['type' => 'reservation confirmed']
        );
    }

    // =========================================================================
    //  STAFF ONLY (sans client)
    // =========================================================================

    /**
     * Notifier uniquement le staff d'une nouvelle commande (FCM + OneSignal iOS)
     */
    public function notify_staff_new_order($order_id, $amount)
    {
        $title   = 'Nouvelle commande passée';
        $message = 'Numéro de commande: ' . $order_id . ', Montant: ' . number_format($amount, 2);

        $staff_tokens = $this->_get_staff_tokens();
        if (!empty($staff_tokens)) {
            $this->_send_fcm(
                $this->_config('fcm_key_staff'),
                $staff_tokens,
                $title,
                $message
            );
        }

        $this->_send_onesignal_broadcast(
            $this->_config('onesignal_waiter_ios_app_id'),
            $title,
            $message,
            ['type' => 'order place']
        );
    }

    /**
     * Appel serveur / demande d'addition depuis une table QR
     */
    public function waiter_called($table_id, $call_type = 'waiter')
    {
        $CI =& get_instance();
        $table = $CI->db->where('tableid', $table_id)->get('rest_table')->row();
        $tablename = !empty($table) ? $table->tablename : 'Table #' . $table_id;

        if ($call_type === 'bill') {
            $title   = 'Demande d\'addition';
            $message = $tablename . ' demande l\'addition';
        } else {
            $title   = 'Appel serveur';
            $message = $tablename . ' appelle le serveur';
        }

        $staff_tokens = $this->_get_staff_tokens();
        if (!empty($staff_tokens)) {
            $this->_send_fcm(
                $this->_config('fcm_key_staff'),
                $staff_tokens,
                $title,
                $message
            );
        }

        $this->_send_onesignal_broadcast(
            $this->_config('onesignal_waiter_ios_app_id'),
            $title,
            $message,
            ['type' => 'waiter_call', 'table_id' => $table_id, 'call_type' => $call_type]
        );
    }

    // =========================================================================
    //  MÉTHODES PRIVÉES — TRANSPORT
    // =========================================================================

    /**
     * Envoyer via FCM à plusieurs tokens (registration_ids)
     */
    private function _send_fcm($api_key, array $tokens, $title, $message)
    {
        if (empty($tokens) || empty($api_key)) return false;

        $fields = [
            'registration_ids' => $tokens,
            'data' => [
                'message'    => $message,
                'title'      => $title,
                'subtitle'   => '',
                'tickerText' => '',
                'vibrate'    => 1,
                'sound'      => 1,
                'largeIcon'  => '',
                'smallIcon'  => '',
            ],
        ];

        return $this->_curl_post('https://fcm.googleapis.com/fcm/send', $fields, [
            'Authorization: key=' . $api_key,
            'Content-Type: application/json',
        ]);
    }

    /**
     * Envoyer via FCM à un seul token (to)
     */
    private function _send_fcm_single($api_key, $token, $title, $body)
    {
        if (empty($token) || empty($api_key)) return false;

        $icon   = base_url('assets/img/applogo.png');
        $fields = [
            'to' => $token,
            'data' => [
                'title'      => $title,
                'body'       => $body,
                'image'      => $icon,
                'media_type' => 'image',
                'message'    => 'notification',
                'action'     => '1',
            ],
            'notification' => [
                'sound' => 'default',
                'title' => $title,
                'body'  => $body,
                'image' => $icon,
            ],
        ];

        return $this->_curl_post('https://fcm.googleapis.com/fcm/send', $fields, [
            'Authorization: Key=' . $api_key,
            'Content-Type: application/json',
        ]);
    }

    /**
     * Envoyer via OneSignal à des player_ids spécifiques
     */
    private function _send_onesignal($app_id, array $player_ids, $title, $message, $data = [])
    {
        if (empty($player_ids) || empty($app_id)) return false;

        $fields = [
            'app_id'             => $app_id,
            'include_player_ids' => $player_ids,
            'contents'           => ['en' => $message],
            'headings'           => ['en' => $title],
            'data'               => $data,
        ];

        $api_key = $this->_config('onesignal_api_key');
        $headers = ['Content-Type: application/json; charset=utf-8'];
        if ($api_key) {
            $headers[] = 'Authorization: Basic ' . $api_key;
        }

        return $this->_curl_post('https://onesignal.com/api/v1/notifications', $fields, $headers);
    }

    /**
     * Envoyer via OneSignal en broadcast (tous les segments)
     */
    private function _send_onesignal_broadcast($app_id, $title, $message, $data = [])
    {
        if (empty($app_id)) return false;

        $fields = [
            'app_id'            => $app_id,
            'included_segments' => ['All'],
            'contents'          => ['en' => $message],
            'headings'          => ['en' => $title],
            'data'              => $data,
        ];

        $api_key = $this->_config('onesignal_api_key');
        $headers = ['Content-Type: application/json; charset=utf-8'];
        if ($api_key) {
            $headers[] = 'Authorization: Basic ' . $api_key;
        }

        return $this->_curl_post('https://onesignal.com/api/v1/notifications', $fields, $headers);
    }

    // =========================================================================
    //  HELPERS
    // =========================================================================

    /**
     * Récupérer les tokens FCM du staff cuisine/serveurs (pos_id=6)
     */
    private function _get_staff_tokens()
    {
        $this->CI->db->select('user.waiter_kitchenToken');
        $this->CI->db->from('user');
        $this->CI->db->join('employee_history', 'employee_history.emp_his_id = user.id', 'left');
        $this->CI->db->where("user.waiter_kitchenToken != ''");
        $this->CI->db->where('employee_history.pos_id', 6);
        $query = $this->CI->db->get();

        $tokens = [];
        foreach ($query->result() as $row) {
            $tokens[] = $row->waiter_kitchenToken;
        }
        return $tokens;
    }

    /**
     * Récupérer le token d'un serveur spécifique
     */
    public function get_waiter_token($waiter_id)
    {
        $waiter = $this->CI->db->select('waiter_kitchenToken')
            ->from('user')
            ->where('id', $waiter_id)
            ->get()
            ->row();

        return $waiter ? $waiter->waiter_kitchenToken : null;
    }

    /**
     * Appel curl générique
     */
    private function _curl_post($url, $fields, $headers)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
    }

    /**
     * Raccourci pour lire la config notification
     */
    private function _config($key)
    {
        return $this->CI->config->item($key, 'notification');
    }
}
