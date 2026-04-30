<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once __DIR__ . '/Saas_base.php';

class Dashboard extends Saas_base {

    /** GET /saas/dashboard/stats */
    public function stats() {
        $this->require_auth();
        $this->_json($this->Saas_model->dashboard_stats());
    }

    /** GET /saas/dashboard/recent-orders */
    public function recent_orders() {
        $this->require_auth();
        $this->_json($this->Saas_model->get_recent_orders(15));
    }

    /** GET /saas/dashboard/clients-stats */
    public function clients_stats() {
        $this->require_auth();
        $this->_json($this->Saas_model->get_all_clients_stats());
    }

    /** GET /saas/dashboard/clients-revenue */
    public function clients_revenue() {
        $this->require_auth();
        $this->_json($this->Saas_model->get_revenue_by_month_per_client());
    }
}
