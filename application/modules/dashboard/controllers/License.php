<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Dashboard / License
 *
 * Handles license activation, status display, manual refresh, and the
 * "subscription expired" blocking page.
 */
class License extends MX_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('License_manager');
    }

    /**
     * GET  dashboard/license
     * Show current license status + activation form.
     */
    public function index() {
        // Trigger a refresh check even though this page is in the hook bypass list
        $this->license_manager->check_refresh();

        $payload = $this->license_manager->load();
        $status  = $this->license_manager->status($payload);
        $raw     = $this->license_manager->raw();

        $data = [
            'title'      => 'Licence',
            'module'     => 'dashboard',
            'page'       => 'license/index',
            'status'     => $status,
            'payload'    => $payload,
            'cached_at'  => $raw['cached_at'] ?? null,
            'client_key' => $raw['client_key'] ?? '',
            'error'      => $this->session->flashdata('license_error'),
            'success'    => $this->session->flashdata('license_success'),
        ];

        // Standalone wrapper when not logged in (no dashboard layout needed)
        if ($this->session->userdata('isLogIn')) {
            echo Modules::run('template/layout', $data);
        } else {
            $this->_standalone($data, 'license/index');
        }
    }

    /**
     * POST dashboard/license/activate
     * Receive the key from the form and call the SaaS activation endpoint.
     */
    public function activate() {
        $key = strtoupper(trim($this->input->post('client_key', true) ?? ''));

        if (!$key) {
            $this->session->set_flashdata('license_error', 'Veuillez saisir une clé de licence.');
            redirect('dashboard/license');
            return;
        }

        $payload = $this->license_manager->activate($key, base_url());

        if (!$payload) {
            $this->session->set_flashdata('license_error',
                'Clé invalide ou serveur SaaS inaccessible. Vérifiez la clé et réessayez.');
            redirect('dashboard/license');
            return;
        }

        $this->session->set_flashdata('license_success',
            'Licence activée avec succès ! Plan : ' . ($payload['plan'] ?? '—'));
        redirect('dashboard/license');
    }

    /**
     * GET dashboard/license/refresh
     * Manually trigger a refresh from the SaaS server.
     */
    public function refresh() {
        $payload = $this->license_manager->refresh();

        if ($payload) {
            $this->session->set_flashdata('license_success', 'Licence mise à jour depuis le serveur cloud.');
        } else {
            $this->session->set_flashdata('license_error',
                'Impossible de contacter le serveur cloud. La licence en cache reste active.');
        }

        redirect('dashboard/license');
    }

    /**
     * GET dashboard/license/expired
     * Blocking page shown when the subscription is fully expired.
     */
    public function expired() {
        $raw    = $this->license_manager->raw();
        $data   = [
            'title'   => 'Abonnement expiré',
            'payload' => $raw['payload'] ?? null,
        ];
        $data['module'] = 'dashboard';
        $data['page']   = 'license/expired';
        $this->_standalone($data, 'license/expired');
    }

    /**
     * GET dashboard/license/module_locked?module=reservation
     * Shown when a user tries to access a module not included in their plan.
     */
    public function module_locked() {
        $module_name = $this->input->get('module', true) ?? '';
        $raw = $this->license_manager->raw();

        $catalog = $this->_module_catalog();
        $info = $catalog[$module_name] ?? [
            'label' => ucfirst($module_name),
            'icon'  => 'fa-cube',
            'desc'  => 'Ce module offre des fonctionnalites supplementaires pour votre restaurant.',
            'features' => [],
        ];

        $data = [
            'title'        => 'Module non disponible',
            'module_name'  => $module_name,
            'module_label' => $info['label'],
            'module_icon'  => $info['icon'],
            'module_desc'  => $info['desc'],
            'module_features' => $info['features'],
            'current_plan' => $raw['payload']['plan'] ?? null,
        ];

        if ($this->session->userdata('isLogIn')) {
            $data['module'] = 'dashboard';
            $data['page']   = 'license/module_locked';
            echo Modules::run('template/layout', $data);
        } else {
            $this->_standalone($data, 'license/module_locked');
        }
    }

    /**
     * Catalogue marketing de chaque module vendable.
     */
    private function _module_catalog(): array {
        return [
            'reservation' => [
                'label' => 'Reservations',
                'icon'  => 'fa-calendar-check-o',
                'desc'  => 'Gerez vos reservations en ligne et sur place. Vos clients reservent directement depuis un formulaire QR ou votre site, et vous gerez tout depuis un tableau de bord centralisé.',
                'features' => [
                    'Reservation en ligne via QR code ou lien web',
                    'Calendrier interactif avec vue jour/semaine',
                    'Confirmation et modification par e-mail automatique',
                    'Gestion des tables et capacite en temps reel',
                    'Historique complet de chaque reservation',
                    'Pre-commande avant arrivee du client',
                ],
            ],
            'qrapp' => [
                'label' => 'Commande QR / App',
                'icon'  => 'fa-qrcode',
                'desc'  => 'Offrez a vos clients la possibilite de consulter le menu et commander directement depuis leur telephone, sans attendre le serveur. Moins d\'attente, plus de commandes.',
                'features' => [
                    'Menu digital accessible via QR code sur table',
                    'Commande directe depuis le telephone du client',
                    'Paiement en ligne integre',
                    'Mise a jour du menu en temps reel',
                    'Personnalisation visuelle (couleurs, logo)',
                    'Suivi de commande en direct pour le client',
                ],
            ],
            'hrm' => [
                'label' => 'Ressources humaines',
                'icon'  => 'fa-users',
                'desc'  => 'Gerez l\'ensemble de votre personnel : fiches employes, contrats, conges, paie et performance. Tout ce qu\'il faut pour piloter votre equipe efficacement.',
                'features' => [
                    'Fiches employes completes avec documents',
                    'Gestion des conges et absences',
                    'Calcul de paie et bulletins de salaire',
                    'Suivi des heures travaillees',
                    'Gestion des contrats et avenants',
                    'Tableau de bord RH avec indicateurs cles',
                ],
            ],
            'purchase' => [
                'label' => 'Achats & fournisseurs',
                'icon'  => 'fa-truck',
                'desc'  => 'Optimisez vos approvisionnements. Gerez vos fournisseurs, passez vos bons de commande et suivez vos stocks d\'ingredients avec precision.',
                'features' => [
                    'Repertoire fournisseurs avec contacts',
                    'Creation de bons de commande',
                    'Suivi des livraisons et receptions',
                    'Historique des prix d\'achat',
                    'Alertes de stock bas automatiques',
                    'Rapports d\'achat par periode et fournisseur',
                ],
            ],
            'production' => [
                'label' => 'Production cuisine',
                'icon'  => 'fa-cutlery',
                'desc'  => 'Maitrisez vos couts matieres avec les fiches recettes. Calculez le cout reel de chaque plat et planifiez votre production pour reduire le gaspillage.',
                'features' => [
                    'Fiches recettes avec ingredients et quantites',
                    'Calcul automatique du cout matiere par plat',
                    'Planification de production quotidienne',
                    'Deduction automatique des stocks a la production',
                    'Historique de production avec traçabilite',
                    'Analyse de marge par plat',
                ],
            ],
            'wastemangment' => [
                'label' => 'Suivi des dechets',
                'icon'  => 'fa-trash',
                'desc'  => 'Tracez et reduisez vos pertes alimentaires. Identifiez les sources de gaspillage pour economiser et respecter les normes d\'hygiene.',
                'features' => [
                    'Enregistrement des pertes par ingredient',
                    'Categorisation des causes (perime, casse, surproduction)',
                    'Rapports de gaspillage par periode',
                    'Alertes sur les ingredients a forte perte',
                    'Suivi de l\'evolution des pertes dans le temps',
                    'Conformite aux normes HACCP',
                ],
            ],
            'accounts' => [
                'label' => 'Comptabilite',
                'icon'  => 'fa-calculator',
                'desc'  => 'Tenez votre comptabilite a jour sans effort. Journal des ecritures, bilan, compte de resultat et suivi financier complet de votre activite.',
                'features' => [
                    'Plan comptable personnalisable',
                    'Saisie des ecritures comptables',
                    'Grand livre et balance generale',
                    'Bilan et compte de resultat',
                    'Rapprochement des paiements',
                    'Export comptable pour votre expert',
                ],
            ],
            'report' => [
                'label' => 'Rapports & analytics',
                'icon'  => 'fa-bar-chart',
                'desc'  => 'Prenez des decisions eclairees avec des tableaux de bord complets. Analysez vos ventes, vos meilleurs plats, vos heures de pointe et bien plus.',
                'features' => [
                    'Rapport de ventes journalier, hebdomadaire, mensuel',
                    'Top des plats les plus vendus',
                    'Analyse des heures de pointe',
                    'Suivi du chiffre d\'affaires et des marges',
                    'Rapports par serveur et par mode de paiement',
                    'Export PDF et Excel',
                ],
            ],
            'whatsapp' => [
                'label' => 'Notifications WhatsApp',
                'icon'  => 'fa-whatsapp',
                'desc'  => 'Envoyez des notifications automatiques a vos clients via WhatsApp : confirmations de commande, statut de livraison, rappels de reservation.',
                'features' => [
                    'Confirmation de commande automatique',
                    'Notification de commande prete',
                    'Rappel de reservation',
                    'Messages personnalisables avec variables',
                    'Historique des messages envoyes',
                    'Integration avec l\'API WhatsApp Business',
                ],
            ],
            'loyalty' => [
                'label' => 'Programme de fidelite',
                'icon'  => 'fa-gift',
                'desc'  => 'Fidelisez vos clients avec un systeme de points et recompenses. Augmentez la frequence de visite et le panier moyen de vos clients reguliers.',
                'features' => [
                    'Systeme de points configurable',
                    'Cartes de fidelite avec code-barres',
                    'Recompenses et promotions personnalisees',
                    'Programme de parrainage',
                    'Historique des points par client',
                    'Niveaux de fidelite (Bronze, Silver, Gold)',
                ],
            ],
            'shiftmangment' => [
                'label' => 'Gestion des quarts',
                'icon'  => 'fa-clock-o',
                'desc'  => 'Planifiez les shifts de votre equipe facilement. Affectez le bon nombre de personnes aux bons horaires et suivez la presence en temps reel.',
                'features' => [
                    'Planning hebdomadaire drag & drop',
                    'Affectation des employes par poste',
                    'Suivi de presence et pointage',
                    'Gestion des echanges de shifts',
                    'Alertes de sous-effectif',
                    'Historique des plannings passes',
                ],
            ],
            'tax' => [
                'label' => 'Gestion des taxes',
                'icon'  => 'fa-percent',
                'desc'  => 'Configurez et appliquez vos taxes automatiquement. TVA, taxe de service, taxes speciales — tout est calcule et affiche correctement sur vos tickets.',
                'features' => [
                    'Configuration multi-taxes (TVA, service, etc.)',
                    'Application automatique par article ou categorie',
                    'Affichage detaille sur les tickets et factures',
                    'Rapports fiscaux par periode',
                    'Gestion des exonerations',
                    'Conformite avec la reglementation locale',
                ],
            ],
        ];
    }

    /** Render a standalone page (no dashboard layout required) */
    private function _standalone(array $data, string $view): void {
        // Render inner view to string first so the module context is preserved
        $content = $this->load->view($view, $data, true);
        $this->load->view('license/standalone_wrap', ['title' => $data['title'], 'content' => $content]);
    }
}
