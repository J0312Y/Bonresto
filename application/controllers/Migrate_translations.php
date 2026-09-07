<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Migration: insert all missing translation keys into the language table.
 *
 * Usage (local):  http://localhost/bonresto/migrate_translations/run
 * Usage (VPS):    curl "https://yourdomain.com/migrate_translations/run?key=YOUR_CRON_KEY"
 */
class Migrate_translations extends CI_Controller
{
    public function run()
    {
        // Require cron key unless running on localhost
        $key = $this->input->get('key') ?: ($_SERVER['HTTP_X_CRON_KEY'] ?? null);
        $is_local = in_array($_SERVER['SERVER_NAME'] ?? '', ['localhost', '127.0.0.1']);
        if (!$is_local) {
            $this->config->load('saas_email', true);
            $valid_key = $this->config->item('saas_cron_key', 'saas_email');
            if (!cle_cron_valide($valid_key, $key)) {
                http_response_code(403);
                echo json_encode(['error' => 'Invalid cron key']);
                return;
            }
        }

        // All translation keys to ensure exist
        $translations = [
            // QR Identification
            ['phrase' => 'welcome',                          'english' => 'Welcome',                                                       'french' => 'Bienvenue'],
            ['phrase' => 'identify_for_personalized_experience', 'english' => 'Identify yourself for a personalized experience',           'french' => 'Identifiez-vous pour une experience personnalisee'],
            ['phrase' => 'table_has_active_reservation_msg', 'english' => 'This table has an active reservation. If it is yours, enter the number used during the reservation.', 'french' => 'Cette table a une reservation active. Si c\'est la votre, entrez le numero utilise lors de la reservation.'],
            ['phrase' => 'phone_number',                     'english' => 'Phone number',                                                 'french' => 'Numero de telephone'],
            ['phrase' => 'phone_placeholder',                'english' => 'Ex: 06 XXX XX XX',                                             'french' => 'Ex: 06 XXX XX XX'],
            ['phrase' => 'your_name',                        'english' => 'Your name',                                                    'french' => 'Votre nom'],
            ['phrase' => 'continue',                         'english' => 'Continue',                                                     'french' => 'Continuer'],
            ['phrase' => 'confirm_identity',                 'english' => 'That\'s me, continue',                                         'french' => 'C\'est moi, continuer'],
            ['phrase' => 'not_me',                           'english' => 'That\'s not me',                                               'french' => 'Ce n\'est pas moi'],
            ['phrase' => 'or',                               'english' => 'or',                                                           'french' => 'ou'],
            ['phrase' => 'continue_without_identify',        'english' => 'Continue without identifying',                                 'french' => 'Continuer sans m\'identifier'],
            ['phrase' => 'identification_benefits',          'english' => 'Benefits of identification',                                   'french' => 'Avantages de l\'identification'],
            ['phrase' => 'loyalty_points',                   'english' => 'Loyalty points',                                               'french' => 'Points fidelite'],
            ['phrase' => 'history',                          'english' => 'History',                                                      'french' => 'Historique'],
            ['phrase' => 'quick_order',                      'english' => 'Quick order',                                                  'french' => 'Commande rapide'],
            ['phrase' => 'verifying',                        'english' => 'Verifying...',                                                 'french' => 'Verification...'],
            ['phrase' => 'new_customer_enter_name',          'english' => 'New here! Enter your name to create your account.',             'french' => 'Nouveau chez nous ! Entrez votre nom pour creer votre compte.'],
            ['phrase' => 'server_error',                     'english' => 'Server error',                                                 'french' => 'Erreur serveur'],
            ['phrase' => 'connection_error',                 'english' => 'Connection error',                                             'french' => 'Erreur de connexion'],
            ['phrase' => 'verify_identity',                  'english' => 'Verify my identity',                                           'french' => 'Verifier mon identite'],
            ['phrase' => 'member_since',                     'english' => 'Member since',                                                 'french' => 'Membre depuis'],
            ['phrase' => 'points',                           'english' => 'points',                                                       'french' => 'points'],
            ['phrase' => 'unknown_error',                    'english' => 'Unknown error',                                                'french' => 'Erreur inconnue'],

            // My Account
            ['phrase' => 'client',                           'english' => 'Customer',                                                     'french' => 'Client'],
            ['phrase' => 'loyalty_program',                  'english' => 'Loyalty program',                                              'french' => 'Programme fidelite'],
            ['phrase' => 'points_accumulated',               'english' => 'points accumulated',                                           'french' => 'points accumules'],
            ['phrase' => 'loyalty_earn_points_msg',          'english' => 'Earn points with every order and enjoy exclusive rewards!',     'french' => 'Gagnez des points a chaque commande et profitez de recompenses exclusives !'],
            ['phrase' => 'my_recent_orders',                 'english' => 'My recent orders',                                             'french' => 'Mes dernieres commandes'],
            ['phrase' => 'in_preparation',                   'english' => 'In preparation',                                               'french' => 'En preparation'],
            ['phrase' => 'cancelled',                        'english' => 'Cancelled',                                                    'french' => 'Annule'],
            ['phrase' => 'no_orders_yet',                    'english' => 'No orders yet',                                                'french' => 'Aucune commande pour le moment'],

            // Reservation verify
            ['phrase' => 'table_reserved',                   'english' => 'Table reserved',                                               'french' => 'Table reservee'],
            ['phrase' => 'table_has_reservation',            'english' => 'This table has an active reservation.',                         'french' => 'Cette table a une reservation active.'],
            ['phrase' => 'confirm_identity_to_continue',     'english' => 'Please confirm your identity to continue.',                    'french' => 'Veuillez confirmer votre identite pour continuer.'],
            ['phrase' => 'your_phone_number',                'english' => 'Your phone number',                                            'french' => 'Votre numero de telephone'],
            ['phrase' => 'no_reservation',                   'english' => 'I don\'t have a reservation',                                  'french' => 'Je n\'ai pas de reservation'],
            ['phrase' => 'view_menu',                        'english' => 'View menu',                                                    'french' => 'Voir le menu'],

            // Reservation checkin
            ['phrase' => 'reservation_detected',             'english' => 'Your reservation has been detected.',                           'french' => 'Votre reservation a ete detectee.'],
            ['phrase' => 'waiter_coming',                    'english' => 'A waiter will come to welcome you.',                            'french' => 'Un serveur va venir vous accueillir.'],
            ['phrase' => 'you_are_early',                    'english' => 'You are early',                                                'french' => 'Vous etes en avance'],
            ['phrase' => 'reservation_scheduled_at',         'english' => 'Your reservation is scheduled at',                              'french' => 'Votre reservation est prevue a'],
            ['phrase' => 'please_wait_waiter',               'english' => 'Please wait, a waiter will seat you.',                          'french' => 'Vous pouvez patienter, un serveur viendra vous installer.'],
            ['phrase' => 'reservation_passed',               'english' => 'Reservation passed',                                           'french' => 'Reservation passee'],
            ['phrase' => 'reservation_was_at',               'english' => 'your reservation was scheduled at',                             'french' => 'votre reservation etait prevue a'],
            ['phrase' => 'contact_waiter_availability',      'english' => 'Please contact a waiter to check your table availability.',     'french' => 'Veuillez contacter un serveur pour verifier la disponibilite de votre table.'],
            ['phrase' => 'persons',                          'english' => 'Persons',                                                      'french' => 'Personnes'],
            ['phrase' => 'your_preorder',                    'english' => 'Your pre-order',                                               'french' => 'Votre pre-commande'],
            ['phrase' => 'waiting_for_waiter',               'english' => 'Waiting for waiter...',                                         'french' => 'En attente du serveur...'],
            ['phrase' => 'please_wait_until',                'english' => 'Please wait until',                                             'french' => 'Veuillez patienter jusqu\'a'],
            ['phrase' => 'contact_waiter',                   'english' => 'Contact a waiter',                                              'french' => 'Contactez un serveur'],

            // Theme sidebar / bell
            ['phrase' => 'my_account',                       'english' => 'My account',                                                   'french' => 'Mon compte'],
            ['phrase' => 'call_waiter',                      'english' => 'Call waiter',                                                  'french' => 'Appeler le serveur'],
            ['phrase' => 'request_bill',                     'english' => 'Request the bill',                                             'french' => 'Demander l\'addition'],
            ['phrase' => 'my_orders',                        'english' => 'My orders',                                                    'french' => 'Mes commandes'],

            // Reservation date/time validation
            ['phrase' => 'invalid_date',                     'english' => 'Invalid date',                                                 'french' => 'Date invalide'],
            ['phrase' => 'cannot_reserve_past_date',         'english' => 'You cannot reserve for a past date.',                           'french' => 'Vous ne pouvez pas reserver pour une date deja passee.'],
            ['phrase' => 'invalid_time',                     'english' => 'Invalid time',                                                 'french' => 'Heure invalide'],
            ['phrase' => 'reservation_time_too_soon',        'english' => 'Reservation time must be at least 1 hour from now.',            'french' => 'L\'heure de reservation doit etre au moins 1 heure apres l\'heure actuelle.'],

            // Controller messages
            ['phrase' => 'phone_number_required',            'english' => 'Phone number is required',                                     'french' => 'Numero de telephone requis'],
            ['phrase' => 'table_reserved_for',               'english' => 'This table is reserved for',                                   'french' => 'Cette table est reservee au nom de'],
            ['phrase' => 'can_still_browse_menu',            'english' => 'You can still browse the menu.',                                'french' => 'Vous pouvez tout de meme consulter le menu.'],
            ['phrase' => 'missing_data',                     'english' => 'Missing data',                                                 'french' => 'Donnees manquantes'],
            ['phrase' => 'reservation_not_found',            'english' => 'Reservation not found',                                        'french' => 'Reservation introuvable'],
            ['phrase' => 'phone_does_not_match_reservation', 'english' => 'This number does not match the reservation.',                   'french' => 'Ce numero ne correspond pas a la reservation.'],
        ];

        // For multi-tenant: run on all tenant DBs
        $saas_db = @$this->load->database('saas', true);
        $tenants = [];

        if ($saas_db && method_exists($saas_db, 'get')) {
            try {
                $tenants = $saas_db->select('tenant_id, db_name, business_name')
                                   ->where('db_name IS NOT NULL')
                                   ->where('db_name !=', '')
                                   ->get('saas_tenants')
                                   ->result();
            } catch (Exception $e) {
                // Not a SaaS setup, run on default DB only
            }
        }

        $results = [];

        if (!empty($tenants)) {
            // Multi-tenant: iterate all DBs
            // Use 'default' credentials (not 'saas') — saas_user may not have access to tenant DBs
            $db_config = [];
            require APPPATH . 'config/database.php';
            $base_cfg = $db['default'];

            foreach ($tenants as $tenant) {
                $config = [
                    'hostname' => $base_cfg['hostname'],
                    'username' => $base_cfg['username'],
                    'password' => $base_cfg['password'],
                    'database' => $tenant->db_name,
                    'dbdriver' => 'mysqli',
                    'char_set' => 'utf8',
                    'dbcollat' => 'utf8_general_ci',
                ];

                try {
                    $tenant_db = $this->load->database($config, true);
                    $count = $this->_insert_translations($tenant_db, $translations);
                    $results[] = [
                        'tenant'  => $tenant->business_name,
                        'db'      => $tenant->db_name,
                        'inserted' => $count,
                        'status'  => 'ok',
                    ];
                    $tenant_db->close();
                } catch (Exception $e) {
                    $results[] = [
                        'tenant' => $tenant->business_name,
                        'db'     => $tenant->db_name,
                        'status' => 'error',
                        'error'  => $e->getMessage(),
                    ];
                }
            }
        } else {
            // Single tenant: run on current DB
            $count = $this->_insert_translations($this->db, $translations);
            $results[] = [
                'tenant'   => 'local',
                'db'       => $this->db->database,
                'inserted' => $count,
                'status'   => 'ok',
            ];
        }

        header('Content-Type: application/json');
        echo json_encode(['results' => $results], JSON_PRETTY_PRINT);
    }

    /**
     * Insert translations that don't exist yet (by phrase key).
     * Returns the count of newly inserted rows.
     */
    private function _insert_translations($db, $translations)
    {
        $inserted = 0;

        foreach ($translations as $row) {
            $exists = $db->where('phrase', $row['phrase'])->get('language')->row();
            if (!$exists) {
                $db->insert('language', $row);
                $inserted++;
            }
        }

        return $inserted;
    }
}
