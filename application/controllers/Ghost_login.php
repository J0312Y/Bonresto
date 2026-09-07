<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Ghost_login — Authentification fantôme SAAS → POS
 *
 * Flow :
 *   1. Admin SAAS clique "Ghost Login" sur un client
 *   2. SAAS génère un token (64 chars, 5 min, usage unique) → renvoie l'URL
 *   3. Frontend ouvre : https://slug.bonresto.com/ghost-login?token=xxx
 *   4. Ce controller valide le token contre la DB SAAS, crée la session super admin
 *   5. Redirige vers le dashboard
 */
class Ghost_login extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->db->query('SET SESSION sql_mode = "STRICT_TRANS_TABLES,NO_ENGINE_SUBSTITUTION"');
    }

    public function index() {
        $token = $this->input->get('token');

        if (empty($token) || strlen($token) !== 64 || !ctype_xdigit($token)) {
            show_error('Token invalide.', 400);
            return;
        }

        // Connexion à la DB SAAS pour valider le token
        $saas_db = $this->load->database('saas', TRUE);

        $row = $saas_db->where('token', $token)
                       ->where('used', 0)
                       ->where('expires_at >', date('Y-m-d H:i:s'))
                       ->get('saas_ghost_tokens')->row();

        if (!$row) {
            show_error('Token expiré ou déjà utilisé. Veuillez générer un nouveau lien depuis le SAAS admin.', 403);
            return;
        }

        // Audit F-07 : la requete ci-dessus ne filtre que sur le jeton, son
        // usage et son expiration — jamais sur le locataire. Un jeton emis
        // pour le client A, rejoue sur le sous-domaine du client B, ouvrait
        // donc une session super administrateur chez B.
        //
        // CURRENT_TENANT_ID est pose par TenantHook. Il est absent sur une
        // installation mono-locataire (localhost sans sous-domaine) : dans
        // ce cas il n'y a pas d'autre restaurant a proteger.
        if (defined('CURRENT_TENANT_ID') && (int) $row->tenant_id !== (int) CURRENT_TENANT_ID) {
            log_message('error', 'Ghost_login : jeton du tenant ' . (int) $row->tenant_id
                . ' rejoue sur le tenant ' . (int) CURRENT_TENANT_ID);
            show_error('Ce lien de connexion ne correspond pas a ce restaurant.', 403);
            return;
        }
        // Consommer le token (usage unique)
        $saas_db->where('id', $row->id)->update('saas_ghost_tokens', [
            'used'    => 1,
            'used_at' => date('Y-m-d H:i:s'),
        ]);

        // Charger le super admin depuis la DB du POS
        $super = $this->db
            ->select("id, CONCAT_WS(' ', firstname, lastname) AS fullname, email, image, last_login, last_logout, ip_address, is_admin")
            ->where('is_admin', 3)
            ->where('status', 1)
            ->get('user')->row();

        if (!$super) {
            show_error('Compte super admin introuvable dans ce restaurant.', 500);
            return;
        }

        // Mettre à jour last_login
        $this->db->where('id', $super->id)->update('user', [
            'last_login' => date('Y-m-d H:i:s'),
            'ip_address' => $this->input->ip_address(),
        ]);

        // Logger dans la DB SAAS
        $saas_db->insert('saas_activity_log', [
            'tenant_id'   => (int)$row->tenant_id,
            'action'      => 'ghost_login_used',
            'description' => 'Connexion fantôme utilisée',
            // La colonne s'appelle `meta`, pas `metadata` : sous PHP 8, mysqli
            // leve une exception sur colonne inconnue, donc la connexion
            // fantôme repondait 500 avant meme de creer la session.
            'meta'        => json_encode(['ip' => $this->input->ip_address()]),
            'created_at'  => date('Y-m-d H:i:s'),
        ]);

        // Créer la session POS — même structure que Auth.php
        $this->session->set_userdata([
            'isLogIn'     => true,
            'isAdmin'     => true,
            'user_type'   => 3,
            'id'          => $super->id,
            'fullname'    => $super->fullname,
            'user_level'  => 'Super Admin',
            'email'       => $super->email,
            'image'       => $super->image,
            'last_login'  => $super->last_login,
            'last_logout' => $super->last_logout,
            'ip_address'  => $this->input->ip_address(),
            'permission'  => json_encode([]),
            'label_permission' => json_encode([]),
            'ghost_session'    => true, // marqueur pour audit
        ]);

        $this->session->set_flashdata('message', '👻 Connexion fantôme SAAS — Mode Super Admin actif');

        redirect('dashboard/home');
    }
}
