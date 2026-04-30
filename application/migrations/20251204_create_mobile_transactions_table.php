<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_mobile_transactions_table extends CI_Migration {

    public function up() {
        $this->dbforge->add_field(array(
            'id' => array('type' => 'INT','constraint' => 11,'unsigned' => TRUE,'auto_increment' => TRUE),
            'order_id' => array('type' => 'INT','constraint' => 11,'null' => TRUE),
            'transaction_id' => array('type' => 'VARCHAR','constraint' => '255','null' => TRUE),
            'provider' => array('type' => 'VARCHAR','constraint' => '50','null' => TRUE),
            'amount' => array('type' => 'DECIMAL','constraint' => '10,2','null' => TRUE),
            'status' => array('type' => 'VARCHAR','constraint' => '50','null' => TRUE),
            'created_at' => array('type' => 'DATETIME','null' => TRUE),
            'updated_at' => array('type' => 'DATETIME','null' => TRUE),
        ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('mobile_transactions');
    }

    public function down() {
        $this->dbforge->drop_table('mobile_transactions');
    }
}
