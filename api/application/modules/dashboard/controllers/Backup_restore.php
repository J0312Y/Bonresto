<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Backup_restore extends MX_Controller {

    private $savePath = "assets/data/backup/";

    public function __construct()
    {
        parent::__construct(); 
        $this->db->query('SET SESSION sql_mode = ""');

        if (!$this->session->userdata('isAdmin')) {
            redirect('login');
        }

        // Assure que le dossier existe
        if (!is_dir($this->savePath)) {
            mkdir($this->savePath, 0777, true);
        }
    }

    public function index()
    { 
        $data['title']  = display('backup_and_restore');
        $data['module'] = "dashboard";  
        $data['page']   = "home/backup_and_restore"; 
        $data['backup'] = $this->latestBackup();  
        $data['file']   = $this->checkFileInfo();  

        echo Modules::run('template/layout', $data); 
    }

    public function process()
    {
        $input  = $this->input->post('input', true); 
        $data   = [];

        if ($input == 1) {
            if ($this->manualBackup()) {
                $data['success'] = display('backup_successfully');
            } else {
                $data['error'] = display('please_try_again');
            }
        } elseif ($input == 2) {
            if ($this->restore()) {
                $data['success'] = display('restore_successfully');
            } else {
                $data['error'] = display('please_try_again');
            }
        }

        echo json_encode($data);
    }

    // Récupère le dernier backup
    public function latestBackup()
    {
        $files = glob($this->savePath . "backup_*.sql");
        return !empty($files);
    }

    // Info du dernier fichier
    public function checkFileInfo()
    {
        $files = glob($this->savePath . "backup_*.sql");
        if (empty($files)) return false;

        $lastFile = end($files);
        $info = get_file_info($lastFile);

        return [
            'name' => basename($lastFile),
            'size' => number_format($info['size'] / 1024, 2)." KB",
            'date' => date('d-m-Y H:i', $info['date']) .' ('.$this->timeAgo($info['date']).')'
        ];
    }

    // Génère un backup manuel
    public function manualBackup()
    { 
        $this->load->helper('file');
        $this->load->dbutil();  

        $prefs = [
            'format'     => 'txt',
            'add_drop'   => TRUE,
            'add_insert' => TRUE,
            'newline'    => "\n"
        ]; 

        $backup = $this->dbutil->backup($prefs);

        $date = date('Y_m_d_H_i_s');
        $filePath = $this->savePath . "backup_{$date}.sql";

        return write_file($filePath, $backup);
    }

    public function restore()
    {
        $files = glob($this->savePath . "backup_*.sql");
        if (empty($files)) return false;

        $file = end($files);
        $content = file_get_contents($file);

        $queries = explode(";", $content);

        $this->db->query("SET FOREIGN_KEY_CHECKS = 0");

        foreach ($queries as $query)
        {
            $query = trim($query);
            if (!empty($query)) {
                try {
                    $this->db->query($query);
                } catch (Exception $e) {
                    log_message('error', 'Restore error: ' . $e->getMessage());
                }
            }
        }

        $this->db->query("SET FOREIGN_KEY_CHECKS = 1");
        return true;
    }

    public function download()
    {
        $files = glob($this->savePath . "backup_*.sql");
        if (empty($files)) {
            $this->session->set_flashdata('exception', display('please_try_again'));
            redirect($_SERVER['HTTP_REFERER']);
        }

        $file = end($files);

        $this->load->helper('download');
        force_download($file, null);
    }

    public function delete()
    {
        foreach (glob($this->savePath . "backup_*.sql") as $file) {
            unlink($file);
        }

        $this->session->set_flashdata('message', display('delete_successfully'));
        redirect($_SERVER['HTTP_REFERER']);
    }

    // 🔄 Backup automatique (CRON)
    public function auto_backup()
    {
        $this->load->helper('file');
        $this->load->dbutil();
        
        $prefs = [
            'format'     => 'txt',
            'add_drop'   => TRUE,
            'add_insert' => TRUE,
            'newline'    => "\n"
        ];

        $backup = $this->dbutil->backup($prefs);

        $date = date('Y_m_d_H_i_s');
        $filePath = $this->savePath . "backup_{$date}.sql";

        // Enregistrer le backup
        write_file($filePath, $backup);

        // Supprimer les backups de plus de 7 jours
        foreach (glob($this->savePath . "backup_*.sql") as $file) {
            if (filemtime($file) < time() - (7 * 24 * 60 * 60)) {
                unlink($file);
            }
        }
    }

    // Fonction timeAgo
    public function timeAgo($time)
    {
        $time = time() - $time;

        if ($time < 60) return 'less than a minute ago';
        elseif ($time < 3600) return round($time/60).' minutes ago';
        elseif ($time < 86400) return round($time/3600).' hours ago';
        elseif ($time < 604800) return round($time/86400).' days ago';
        else return date('d-m-Y', $time);
    }

}
