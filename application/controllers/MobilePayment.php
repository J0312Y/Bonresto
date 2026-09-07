<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MobilePayment extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('App_android_model');
    }

    public function process() {
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);

        if (!$data) {
            echo json_encode(array(
                'status' => 'error',
                'message' => 'Données de requête invalides',
                'bgColor' => '2'
            ));
            return;
        }

        // Valider les données requises
        $required_fields = array('order_id', 'payment_method_id', 'phone_number');
        foreach ($required_fields as $field) {
            if (!isset($data[$field])) {
                echo json_encode(array(
                    'status' => 'error',
                    'message' => "Champ requis manquant: $field",
                    'bgColor' => '2'
                ));
                return;
            }
        }

        // Traiter le paiement
        $result = $this->App_android_model->process_mobile_payment(
            $data['order_id'],
            $data
        );

        // Ensure bgColor is set on success/error responses
        if (!isset($result['bgColor'])) {
            $result['bgColor'] = ($result['status'] === 'success') ? '1' : '2';
        }

        echo json_encode($result);
    }

    /**
     * Audit F-08 — verification d'un rappel de fournisseur de paiement.
     *
     * Les deux webhooks ci-dessous n'avaient aucun controle : n'importe qui
     * pouvait poster un JSON et reecrire l'etat de n'importe quelle
     * transaction. Ils exigent desormais un secret partage, transmis par
     * l'en-tete X-Webhook-Secret, compare a temps constant.
     *
     * Ce n'est PAS une verification de signature cryptographique : chaque
     * operateur a la sienne (Airtel, MTN), et l'implementer demande leur
     * documentation. C'est le minimum qui ferme l'acces anonyme ; la signature
     * du fournisseur reste a brancher ici quand le contrat sera disponible.
     */
    private function _rappel_authentifie($operateur)
    {
        $attendu = getenv('WEBHOOK_' . strtoupper($operateur) . '_SECRET')
            ?: getenv('WEBHOOK_SECRET');

        if (empty($attendu)) {
            log_message('error', "Webhook {$operateur} : aucun secret configure, rappel refuse.");
            return false;
        }

        $fourni = $_SERVER['HTTP_X_WEBHOOK_SECRET'] ?? '';
        if (!is_string($fourni) || $fourni === '') {
            return false;
        }

        return hash_equals((string) $attendu, $fourni);
    }

    private function _refuser($operateur)
    {
        log_message('error', "Webhook {$operateur} : rappel non authentifie depuis "
            . ($this->input->ip_address() ?: 'ip inconnue'));
        $this->output->set_status_header(401);
        echo json_encode(['status' => 'error', 'message' => 'Unauthorized']);
    }

    public function webhook_airtel() {
        if (!$this->_rappel_authentifie('airtel')) {
            return $this->_refuser('airtel');
        }

        $json = file_get_contents('php://input');
        $data = json_decode($json, true);

        if (!$data) {
            log_message('error', 'Airtel webhook : JSON invalide');
            $this->output->set_status_header(400);
            echo json_encode(['status' => 'error', 'message' => 'Invalid JSON']);
            return;
        }

        $transactionId = $data['transaction_id'] ?? null;
        $status        = $data['status'] ?? null;

        // Audit F-08 : le statut etait recopie tel quel. On n'accepte plus que
        // des valeurs connues, et seulement pour une transaction qui existe.
        $statuts_admis = ['pending', 'success', 'failed', 'cancelled', 'expired'];

        if (!$transactionId || !in_array(strtolower((string) $status), $statuts_admis, true)) {
            $this->output->set_status_header(400);
            echo json_encode(['status' => 'error', 'message' => 'Invalid payload']);
            return;
        }

        $db = $this->App_android_model->db;

        // Audit F-08 : si la table manque, on ne peut rien enregistrer. Repondre
        // « ok » ferait cesser les reessais de l'operateur et perdrait le
        // paiement en silence — comme le faisait le webhook MTN.
        if (!$db->table_exists('mobile_transactions')) {
            log_message('error', 'Webhook airtel : table mobile_transactions absente.');
            $this->output->set_status_header(500);
            echo json_encode(['status' => 'error', 'message' => 'Storage unavailable']);
            return;
        }

        {
            $existe = $db->where('transaction_id', $transactionId)
                ->count_all_results('mobile_transactions');

            if ($existe === 0) {
                log_message('error', 'Airtel webhook : transaction inconnue');
                $this->output->set_status_header(404);
                echo json_encode(['status' => 'error', 'message' => 'Unknown transaction']);
                return;
            }

            $db->where('transaction_id', $transactionId)->update('mobile_transactions', [
                'status'     => strtolower((string) $status),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }

        echo json_encode(['status' => 'ok']);
    }

    public function webhook_mtn() {
        if (!$this->_rappel_authentifie('mtn')) {
            return $this->_refuser('mtn');
        }

        // Audit F-08 : cette methode se contentait d'un « OK ». Elle indiquait
        // donc a MTN que le rappel avait ete traite, ce qui met fin aux
        // reessais cote operateur — un paiement confirme pouvait ainsi etre
        // perdu sans trace. Tant que le traitement n'est pas ecrit, on
        // repond 501 : MTN reessaiera, et l'absence de traitement se voit.
        log_message('error', 'Webhook MTN appele mais non implemente.');
        $this->output->set_status_header(501);
        echo json_encode([
            'status'  => 'error',
            'message' => 'MTN webhook not implemented',
        ]);
    }
}
