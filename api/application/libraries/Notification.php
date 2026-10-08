<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Notification Library
 *
 * Librairie centralisée pour l'envoi de notifications push via OneSignal.
 *
 * MIGRATION : L'ancienne API FCM Legacy a été désactivée par Google le 20 juin 2024.
 * Toutes les notifications passent désormais par OneSignal.
 */
class Notification
{
    private $CI;

    public function __construct()
    {
        $this->CI =& get_instance();
        $this->CI->config->load('notification', true);
    }

    /**
     * Associer un external_user_id à un device OneSignal (appelé au login)
     *
     * @param string $player_id  Le OneSignal player_id (token) envoyé par l'app
     * @param string $role       'staff' pour waiter/kitchen, 'customer' pour client
     * @param int    $user_id    L'ID en base (user.id ou customer_info.customer_id)
     */
    public function set_external_user_id($player_id, $role, $user_id)
    {
        if (empty($player_id) || empty($user_id)) return false;

        $external_user_id = $role . '_' . $user_id;
        $app_id  = $this->_config('onesignal_staff_app_id'); // même App ID pour tous
        $api_key = $this->_config('onesignal_api_key');

        $fields  = ['app_id' => $app_id, 'external_user_id' => $external_user_id];
        $headers = ['Content-Type: application/json; charset=utf-8'];
        if ($api_key) {
            $headers[] = 'Authorization: Basic ' . $api_key;
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://onesignal.com/api/v1/players/' . $player_id);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
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

        $this->_log_notification($order_id, $title, $message, 'order place');

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

        // Notification staff (ciblé par external_user_id — évite le broadcast à tous)
        $this->_send_onesignal_to_all_staff(
            $title,
            'Numéro de commande: ' . $order_id . ', Montant: ' . number_format($amount, 2),
            ['type' => 'order place']
        );
    }

    /**
     * Commande acceptée — notifie le client
     */
    public function order_accepted($order_id, $amount, $customer_token)
    {
        $title = 'Votre commande est acceptée';
        $body  = 'Numéro de commande: ' . $order_id . ' Montant: ' . number_format($amount, 2);

        $this->_log_notification($order_id, $title, $body, 'order accepted');

        if (!$customer_token) return;

        $this->_send_onesignal(
            $this->_config('onesignal_customer_app_id'),
            [$customer_token],
            $title,
            $body,
            ['type' => 'order accepted']
        );
    }

    /**
     * Commande en cours de préparation — notifie le serveur assigné + optionnellement le client
     */
    public function order_preparing($order_id, $item_name, $amount, $waiter_token, $customer_token = null)
    {
        $title = 'En cours de préparation';
        $body  = 'Numéro de commande : ' . $order_id . ', Nom de l\'article : ' . $item_name . ' Montant: ' . number_format($amount, 2);

        $this->_log_notification($order_id, $title, $body, 'order preparing');

        // Notification staff (ciblé par external_user_id)
        $this->_send_onesignal_to_all_staff($title, $body, ['type' => 'order preparing']);

        if ($customer_token) {
            $this->_send_onesignal(
                $this->_config('onesignal_customer_app_id'),
                [$customer_token],
                $title,
                $body,
                ['type' => 'order preparing']
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

        $this->_log_notification($order_id, $title, $body, 'food ready');

        // Notification staff (ciblé par external_user_id)
        $this->_send_onesignal_to_all_staff($title, $body, ['type' => 'food ready']);

        if ($customer_token) {
            $this->_send_onesignal(
                $this->_config('onesignal_customer_app_id'),
                [$customer_token],
                $title,
                $body,
                ['type' => 'food ready']
            );
        }
    }

    /**
     * Commande terminée — notifie le client
     */
    public function order_completed($order_id, $customer_token)
    {
        $title = 'Commande terminée';
        $body  = 'Votre commande #' . $order_id . ' est terminée. Merci pour votre confiance !';

        $this->_log_notification($order_id, $title, $body, 'order completed');

        if (!$customer_token) return;

        $this->_send_onesignal(
            $this->_config('onesignal_customer_app_id'),
            [$customer_token],
            $title,
            $body,
            ['type' => 'order completed']
        );
    }

    /**
     * Commande passée avec succès (Hungry/QR) — notifie le client
     */
    public function order_confirmed($order_id, $customer_token)
    {
        $title = 'Commande passée avec succès !!';
        $body  = 'Votre identifiant de commande: ' . $order_id . ' Placé avec succès. Veuillez attendre servi';

        $this->_log_notification($order_id, $title, $body, 'order confirmed');

        if (!$customer_token) return;

        $this->_send_onesignal(
            $this->_config('onesignal_hungry_app_id'),
            [$customer_token],
            $title,
            $body,
            ['type' => 'order confirmed']
        );
    }

    /**
     * Commande rejetée — notifie le client
     */
    public function order_rejected($order_id, $item_name, $reason, $customer_token)
    {
        $title = 'Votre commande est rejetée';
        $body  = 'Numéro de commande : ' . $order_id . ', Nom de l\'article : ' . $item_name . ' Raison: ' . $reason;

        $this->_log_notification($order_id, $title, $body, 'order rejected');

        if (!$customer_token) return;

        $this->_send_onesignal(
            $this->_config('onesignal_customer_app_id'),
            [$customer_token],
            $title,
            $body,
            ['type' => 'order rejected']
        );
    }

    /**
     * Mise à jour de commande QR réussie — notifie le client
     */
    public function order_updated($order_id, $customer_token)
    {
        $title = 'Mise à jour de la commande réussie !!';
        $body  = 'Votre identifiant de commande: ' . $order_id . ' Mise à jour avec succès.';

        $this->_log_notification($order_id, $title, $body, 'order updated');

        if (!$customer_token) return;

        $this->_send_onesignal(
            $this->_config('onesignal_hungry_app_id'),
            [$customer_token],
            $title,
            $body,
            ['type' => 'order updated']
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
     * Notifier uniquement le staff d'une nouvelle commande (OneSignal broadcast)
     */
    public function notify_staff_new_order($order_id, $amount)
    {
        $title   = 'Nouvelle commande passée';
        $message = 'Numéro de commande: ' . $order_id . ', Montant: ' . number_format($amount, 2);

        $this->_log_notification($order_id, $title, $message, 'order place');

        // Notification staff (ciblé par external_user_id)
        $this->_send_onesignal_to_all_staff($title, $message, ['type' => 'order place']);
    }

    /**
     * Commande en cours de traitement — notifie le staff
     */
    public function notify_staff_order_processing($order_id, $amount)
    {
        $title   = 'Commande en cours de traitement';
        $message = 'Numéro de commande: ' . $order_id . ', Montant: ' . number_format($amount, 2);

        $this->_log_notification($order_id, $title, $message, 'order processing');

        $this->_send_onesignal_to_all_staff($title, $message, ['type' => 'order processing']);
    }

    /**
     * Tous les items sont prêts — notifie le staff
     */
    public function notify_staff_order_ready($order_id, $amount)
    {
        $title   = 'Commande prête';
        $message = 'Numéro de commande: ' . $order_id . ', Montant: ' . number_format($amount, 2) . ' - Tous les articles sont prêts !';

        $this->_log_notification($order_id, $title, $message, 'order ready');

        $this->_send_onesignal_to_all_staff($title, $message, ['type' => 'order ready']);
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

        // Notification staff (ciblé par external_user_id)
        $this->_send_onesignal_to_all_staff(
            $title,
            $message,
            ['type' => 'waiter_call', 'table_id' => (string)$table_id, 'call_type' => $call_type]
        );
    }

    // =========================================================================
    //  MÉTHODES PRIVÉES — OneSignal
    // =========================================================================

    /**
     * Récupérer tous les external_user_id du staff ayant un device enregistré
     */
    private function _get_all_staff_external_ids()
    {
        $rows = $this->CI->db
            ->select('id')
            ->from('user')
            ->where('waiter_kitchenToken IS NOT NULL')
            ->where('waiter_kitchenToken !=', '')
            ->get()
            ->result();

        return array_map(function ($r) { return 'staff_' . $r->id; }, $rows);
    }

    /**
     * Envoyer à tous les membres du staff via leur external_user_id
     */
    private function _send_onesignal_to_all_staff($title, $message, $data = [])
    {
        $external_ids = $this->_get_all_staff_external_ids();
        if (empty($external_ids)) return false;

        return $this->_send_onesignal_by_alias(
            $this->_config('onesignal_staff_app_id'),
            $external_ids,
            $title,
            $message,
            $data
        );
    }

    /**
     * Envoyer via OneSignal en ciblant par external_user_id (include_aliases)
     */
    private function _send_onesignal_by_alias($app_id, array $external_ids, $title, $message, $data = [])
    {
        if (empty($external_ids) || empty($app_id)) return false;

        $fields = [
            'app_id'          => $app_id,
            'include_aliases' => ['external_id' => $external_ids],
            'target_channel'  => 'push',
            'contents'        => ['en' => $message],
            'headings'        => ['en' => $title],
            'data'            => $data,
        ];

        $api_key = $this->_config('onesignal_api_key');
        $headers = ['Content-Type: application/json; charset=utf-8'];
        if ($api_key) {
            $headers[] = 'Authorization: Basic ' . $api_key;
        }

        return $this->_curl_post('https://onesignal.com/api/v1/notifications', $fields, $headers);
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
    //  LOGGING
    // =========================================================================

    /**
     * Enregistrer une notification dans la table notification_log
     */
    private function _log_notification($order_id, $title, $message, $type = '')
    {
        if (empty($order_id)) return;

        $this->CI->db->insert('notification_log', [
            'order_id'   => $order_id,
            'title'      => $title,
            'message'    => $message,
            'type'       => $type,
            'created_at' => date('Y-m-d H:i:s'),
        ]);
    }

    // =========================================================================
    //  HELPERS
    // =========================================================================

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
