<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Permission
{    
    protected $permission;
    protected $module; 
    protected $label; 
    protected $redirect = "login";
    protected $ci;

    public function __construct()
    {
        $this->module = '';
        $this->label = '';
        $this->ci =& get_instance();
    }

    /* ------------------------------------------
     * Utilitaire de décodage JSON sécurisé
     * ------------------------------------------ */
    private function safe_decode($json)
    {
        $decoded = json_decode($json, true);
        return (is_array($decoded)) ? $decoded : [];
    }

    public function access()
    { 
        return $this->permission;
    }

    public function redirect()
    {  
        if ($this->permission) { 
            return $this->permission;
        } else {
            $this->ci->session->set_flashdata('exception', "You do not have permission to access. Please contact the administrator.");
            redirect($this->redirect);
        }
    }

    public function module($module = null)
    {
        $module = (($module!=null)?strtolower($module):$this->ci->uri->segment(1));
        $this->module = $module;

        $this->permission = $this->checkModule($module);
        return $this; 
    }

    public function check_label($label = null)
    {
        $label = (($label!=null)?strtolower($label):$this->ci->uri->segment(1));
        $this->label = $label;

        $this->permission = $this->check_label_to_Permission($label);
        return $this; 
    }

    public function method($module = null, $method = null)
    {
        $module = (($module!=null)?strtolower($module):$this->ci->uri->segment(1));
        $method = strtolower($method);

        $this->permission = $this->checkMethod($module, $method);
        return $this;
    }   

    public function create()
    {   
        $this->permission = $this->checkLebel_permission_type($this->label, 'create');
        return $this;
    }

    public function read()
    {   
        $this->permission = $this->checkLebel_permission_type($this->label, 'read');
        return $this;
    }

    public function update()
    {   
        $this->permission = $this->checkLebel_permission_type($this->label, 'update');
        return $this;
    }

    public function delete()
    {   
        $this->permission = $this->checkLebel_permission_type($this->label, 'delete');
        return $this;
    }

    /* ----------------------------------------------------------------
     * Vérifie si un module est autorisé
     * ---------------------------------------------------------------- */
    protected function checkModule($module = NULL)
    { 
        $permission = $this->ci->session->userdata('permission');
        $isAdmin    = $this->ci->session->userdata('isAdmin');
        $isLogIn    = $this->ci->session->userdata('isLogIn');

        if ($isLogIn && $isAdmin) { 
            return true;
        } else if ($isLogIn) { 

            $permission = $this->safe_decode($permission);
            $modules = array_keys($permission);

            //check current module permission
            return in_array($module, $modules);
        }

        return false;
    }

    /* ----------------------------------------------------------------
     * Vérifie le label dans la permission de label
     * ---------------------------------------------------------------- */
    protected function check_label_to_Permission($label = null)
    { 
        $permission = $this->ci->session->userdata('label_permission');
        $isAdmin    = $this->ci->session->userdata('isAdmin');
        $isLogIn    = $this->ci->session->userdata('isLogIn');

        if ($isLogIn && $isAdmin) { 
            return true;
        } else if ($isLogIn) {
            $permission = $this->safe_decode($permission);
            $labels = array_keys($permission);

            return in_array($label, $labels);
        }

        return false;
    }

    /* ----------------------------------------------------------------
     * Vérifie si une méthode est autorisée pour un module
     * ---------------------------------------------------------------- */
    protected function checkMethod($module = null, $method = null)
    { 
        $permission = $this->ci->session->userdata('permission');
        $isAdmin    = $this->ci->session->userdata('isAdmin');
        $isLogIn    = $this->ci->session->userdata('isLogIn');

        if ($isLogIn && $isAdmin) {
            return true;
        } else if ($isLogIn) {
            $permission = $this->safe_decode($permission);
            $modules = array_keys($permission);

            if (in_array($module, $modules)) {
                $methodList = $permission[$module]; 
                if (!is_array($methodList)) return false;

                $methods = array_keys($methodList);
                if (in_array(strtolower($method), $methods)) {
                    return ($methodList[$method] == 1);
                }
            }
        }

        return false;
    }

    /* ----------------------------------------------------------------
     * Vérifie le type d’action autorisé sur un label
     * ---------------------------------------------------------------- */
    protected function checkLebel_permission_type($label = null, $method = null)
    { 
        $permission = $this->ci->session->userdata('label_permission');
        $isAdmin    = $this->ci->session->userdata('isAdmin');
        $isLogIn    = $this->ci->session->userdata('isLogIn');

        if ($isLogIn && $isAdmin) {
            return true;
        } else if ($isLogIn) {
            $permission = $this->safe_decode($permission);
            $labels = array_keys($permission);

            if (in_array($label, $labels)) {
                $labelList = $permission[$label]; 
                if (!is_array($labelList)) return false;

                $methods = array_keys($labelList);
                if (in_array(strtolower($method), $methods)) {
                    return ($labelList[$method] == 1);
                }
            }
        }

        return false;
    }

    /* ----------------------------------------------------------------
     * 🔹 Ajout de la fonction manquante : check_admin_auth()
     * ---------------------------------------------------------------- */
    public function check_admin_auth()
    {
        $isLogIn = $this->ci->session->userdata('isLogIn');
        if (!$isLogIn) {
            redirect('login');
        }
    }
}
