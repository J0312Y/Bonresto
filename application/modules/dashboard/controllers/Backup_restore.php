<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Backup_restore extends MX_Controller {

    private $savePath = "assets/data/backup/";
    private $fileName = "backup.sql";

    public function __construct()
    {
        parent::__construct(); 
        $this->db->query('SET SESSION sql_mode = ""');

        // Vérifie si l'utilisateur est admin
        if (!$this->session->userdata('isAdmin')) {
            redirect('login');
        }
    }

    public function index()
    { 
        $data['title']  = display('backup_and_restore');
        $data['module'] = "dashboard";  
        $data['page']   = "home/backup_and_restore"; 
        $data['backup'] = $this->checkBackup();  
        $data['file']   = $this->checkFileInfo();  
        echo Modules::run('template/layout', $data); 
    }

    public function process()
    {
        $input  = $this->input->post('input', true); 
        $data   = [];

        if ($input == 1) {
            if ($this->backup()) {
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

    public function checkBackup()
    {
        return file_exists($this->savePath . $this->fileName);
    }

    public function checkFileInfo()
    {
        if (file_exists($this->savePath . $this->fileName)){
            $info = get_file_info($this->savePath . $this->fileName);
            return [
                'name' => $info['name'],
                'size' => number_format($info['size'] / 1024, 2)." KB (".$info['size']." bytes)",
                'date' => date('d-m-Y H:i', $info['date']) . ' ('.$this->timeAgo($info['date']).')'
            ];
        }
        return false;
    }

    public function backup()
    { 
        $this->load->helper('file');
        $this->load->dbutil();  

        $prefs = [
            'format'     => 'txt',
            'add_drop'   => TRUE,
            'add_insert' => TRUE,
            'add_update' => TRUE,
            'newline'    => "\n"
        ]; 

        $backup = $this->dbutil->backup($prefs);

        if (write_file($this->savePath . $this->fileName, $backup)) {
            return true;
        }
        return false;
    }

    public function restore()
    {
        $isi_file     = file_get_contents($this->savePath . $this->fileName);
        $string_query = rtrim($isi_file, "\n;");
        $array_query  = explode(";", $string_query);

        $this->db->query("SET FOREIGN_KEY_CHECKS = 0");
        foreach ($array_query as $query) {
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

        return @unlink($this->savePath . $this->fileName);
    }

    public function download()
    {
        if (file_exists($this->savePath . $this->fileName)) {
            $this->load->helper('download');
            if (force_download($this->savePath . $this->fileName, null)) {
                $this->session->set_flashdata('message', display('download_successfully'));
            } else {
                $this->session->set_flashdata('exception', display('please_try_again'));
            }
        } else {
            $this->session->set_flashdata('exception', display('please_try_again'));
        }
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function delete()
    {
        if (file_exists($this->savePath . $this->fileName)) {
            if (@unlink($this->savePath . $this->fileName)) {
                $this->session->set_flashdata('message', display('delete_successfully'));
            } else {
                $this->session->set_flashdata('exception', display('please_try_again'));
            }
        } else {
            $this->session->set_flashdata('exception', display('please_try_again'));
        }
        redirect($_SERVER['HTTP_REFERER']);
    }

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
        $logFile = $this->savePath . 'backup_log.txt';

        if ($backup) {
            $date = date('Y_m_d_H_i_s');
            $filePath = $this->savePath . "backup_{$date}.sql";

            if (write_file($filePath, $backup)) {
                // Supprimer les backups plus vieux que 7 jours
                foreach (glob($this->savePath . "backup_*.sql") as $file) {
                    if (filemtime($file) < time() - (7 * 24 * 60 * 60)) {
                        unlink($file);
                    }
                }

                $logMsg = "[" . date('Y-m-d H:i:s') . "] ✅ Backup done: {$filePath}\n";
                file_put_contents($logFile, $logMsg, FILE_APPEND);
                echo $logMsg;

            } else {
                $logMsg = "[" . date('Y-m-d H:i:s') . "] ❌ Backup failed: cannot write backup file\n";
                file_put_contents($logFile, $logMsg, FILE_APPEND);
                echo $logMsg;
            }

        } else {
            $logMsg = "[" . date('Y-m-d H:i:s') . "] ❌ Backup failed: dbutil->backup returned false\n";
            file_put_contents($logFile, $logMsg, FILE_APPEND);
            echo $logMsg;
        }
    }

    public function timeAgo($time_ago)
    {
        $time_ago = strtotime($time_ago) ? strtotime($time_ago) : $time_ago;
        $time = time() - $time_ago;

        if ($time <= 60) return 'less than a minute ago';
        elseif ($time < 3600) return (round($time/60) == 1) ? 'a minute ago' : round($time/60).' minutes ago';
        elseif ($time < 86400) return (round($time/3600) == 1) ? 'an hour ago' : round($time/3600).' hours ago';
        elseif ($time < 604800) return (round($time/86400) == 1) ? 'a day ago' : round($time/86400).' days ago';
        elseif ($time < 2600640) return (round($time/604800) == 1) ? 'a week ago' : round($time/604800).' weeks ago';
        elseif ($time < 31207680) return (round($time/2600640) == 1) ? 'a month ago' : round($time/2600640).' months ago';
        else return (round($time/31207680) == 1) ? 'a year ago' : round($time/31207680).' years ago';
    }
}