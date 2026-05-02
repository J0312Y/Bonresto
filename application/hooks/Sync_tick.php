<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Sync_tick — Déclencheur automatique de sync post-requête
 *
 * Se déclenche à la fin de chaque requête web (hook post_system).
 * Vérifie si le délai minimum est écoulé depuis le dernier cycle.
 * Si oui, exécute push + pull en arrière-plan APRÈS que la réponse
 * a été envoyée au navigateur (l'utilisateur ne ressent aucun délai).
 *
 * Aucune configuration cron système requise.
 */
class Sync_tick {

    const MIN_INTERVAL = 60; // secondes entre deux cycles

    public function tick(): void {
        try {
            $CI =& get_instance();

            // Ne pas tourner sur les routes sync/cron elles-mêmes
            $uri = trim($CI->uri->uri_string(), '/');
            if (strpos($uri, 'sync_') === 0) return;

            // Vérifier si sync_config existe et est activé
            if (!$CI->db->table_exists('sync_config')) return;

            $cfg = $CI->db->where('enabled', 1)->limit(1)->get('sync_config')->row();
            if (!$cfg) return;

            // Rate-limit : vérifier si assez de temps s'est écoulé
            $last = max(
                strtotime($cfg->last_push ?? '1970-01-01'),
                strtotime($cfg->last_pull ?? '1970-01-01')
            );
            if ((time() - $last) < self::MIN_INTERVAL) return;

            // Envoyer la réponse au client AVANT de lancer la sync
            $this->_flush_response();

            // Lancer le cycle sync
            $CI->load->library('Sync_manager');
            $CI->sync_manager->run();

        } catch (Throwable $e) {
            log_message('error', '[Sync_tick] ' . $e->getMessage());
        }
    }

    /**
     * Envoie la réponse HTTP au navigateur immédiatement,
     * puis continue l'exécution PHP en arrière-plan.
     */
    private function _flush_response(): void {
        // PHP-FPM (méthode optimale)
        if (function_exists('fastcgi_finish_request')) {
            fastcgi_finish_request();
            return;
        }

        // Fallback Apache/mod_php
        ignore_user_abort(true);
        set_time_limit(60);

        if (!headers_sent()) {
            header('Connection: close');
            header('Content-Encoding: none');
            $size = ob_get_length();
            if ($size !== false) {
                header('Content-Length: ' . $size);
            }
        }

        if (ob_get_level() > 0) {
            ob_end_flush();
        }
        flush();
    }
}
