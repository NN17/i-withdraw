<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migrate extends CI_Model {
   
    function table_migrate(){

       $this->load->dbforge();

       $this->dbforge->add_field(array(
           'accId' => array(
               'type' => 'INT',
               'constraint' => 8,
               'auto_increment' => TRUE
           ),
           'username' => array(
               'type' => 'VARCHAR',
               'constraint' => 128
           ),
           'secret' => array(
               'type' => 'VARCHAR',
               'constraint' => 128
           ),
           'role' => array(
               'type' => 'INT',
               'constraint' => 8
           ),
           'accountState' => array(
               'type' => 'BOOLEAN'
           ),
       ));

       $this->dbforge->add_key('accId', TRUE);
       $this->dbforge->create_table('accounts_tbl', TRUE);

       $num_row = $this->db->count_all_results('accounts_tbl');
        if($num_row < 1){
            $this->load->library('libigniter');
            $this->load->library('auth');
            $insert = array(
                'username' => 'system',
                'secret' => $this->auth->hash_password('Professional87'),
                'accountState' => 1,
                'role' => 0,
                );
            $this->db->insert('accounts_tbl',$insert);
        }

        // Create rates_tbl
        $this->dbforge->add_field(array(
            'rateId' => array(
                'type' => 'INT',
                'constraint' => 8,
                'auto_increment' => TRUE
            ),
            'cashType' => array(
                'type' => 'CHAR',
                'constraint' => 8
            ),
            'cashInRate' => array(
                'type' => 'FLOAT',
            ),
            'cashOutRate' => array(
                'type' => 'FLOAT',
            ),
            'remark' => array(
                'type' => 'TEXT'
            ),
        ));

        $this->dbforge->add_key('rateId', TRUE);
        $this->dbforge->create_table('rates_tbl', TRUE);

        // Create cash_in_tbl
        $this->dbforge->add_field(array(
            'cashIn_id' => array(
                'type' => 'INT',
                'constraint' => 8,
                'auto_increment' => TRUE
            ),
            'cashType' => array(
                'type' => 'CHAR',
                'constraint' => 8
            ),
            'transferType' => array(
                'type' => 'CHAR',
                'constraint' => 3
            ),
            'payBackPercent' => array(
                'type' => 'FLOAT',
            ),
            'senderName' => array(
                'type' => 'VARCHAR',
                'constraint' => 225
            ),
            's_accNum' => array(
                'type' => 'VARCHAR',
                'constraint' => 22
            ),
            'r_accNum' => array(
                'type' => 'VARCHAR',
                'constraint' => 22
            ),
            'password' => array(
                'type' => 'VARCHAR',
                'constraint' => 6
            ),
            'amount' => array(
                'type' => 'INT',
                'constraint' => 11
            ),
            'remark' => array(
                'type' => 'TEXT'
            ),
            'created_date' => array(
                'type' => 'DATETIME'
            ),
        ));

        $this->dbforge->add_key('cashIn_id', TRUE);
        $this->dbforge->create_table('cash_in_tbl', TRUE);

        // Create check_out_tbl
        $this->dbforge->add_field(array(
            'checkOut_id' => array(
                'type' => 'INT',
                'constraint' => 8,
                'auto_increment' => TRUE
            ),
            'serial' => array(
                'type' => 'VARCHAR',
                'constraint' => 255
            ),
            'cashInOut' => array(
                'type' => 'CHAR',
                'constraint' => 3
            ),
            'cashType' => array(
                'type' => 'CHAR',
                'constraint' => 2
            ),
            'transferType' => array(
                'type' => 'CHAR',
                'constraint' => 2
            ),
            'rate' => array(
                'type' => 'FLOAT',
            ),
            'name' => array(
                'type' => 'VARCHAR',
                'constraint' => 255
            ),
            's_acc' => array(
                'type' => 'VARCHAR',
                'constraint' => 25
            ),
            'r_acc' => array(
                'type' => 'VARCHAR',
                'constraint' => 25
            ),
            'password' => array(
                'type' => 'VARCHAR',
                'constraint' => 6
            ),
            'amount' => array(
                'type' => 'INT',
                'constraint' => 15
            ),
            'charges' => array(
                'type' => 'INT',
                'constraint' => 15
            ),
            'discount' => array(
                'type' => 'INT',
                'constraint' => 15
            ),
            'print' => array(
                'type' => 'BOOLEAN'
            ),
            'created_at' => array(
                'type' => 'DATETIME'
            ),
        ));

        $this->dbforge->add_key('checkOut_id', TRUE);
        $this->dbforge->create_table('check_out_tbl', TRUE);

        // Create cash_out_tbl
        $this->dbforge->add_field(array(
            'cashOut_id' => array(
                'type' => 'INT',
                'constraint' => 8,
                'auto_increment' => TRUE
            ),
            'cashType' => array(
                'type' => 'CHAR',
                'constraint' => 3
            ),
            'withdrawType' => array(
                'type' => 'CHAR',
                'constraint' => 3
            ),
            'withdrawID' => array(
                'type' => 'VARCHAR',
                'constraint' => 50
            ),
            'password' => array(
                'type' => 'VARCHAR',
                'constraint' => 6
            ),
            'cashOutRate' => array(
                'type' => 'FLOAT',
            ),
            'withdrawName' => array(
                'type' => 'VARCHAR',
                'constraint' => 255
            ),
            'acc' => array(
                'type' => 'VARCHAR',
                'constraint' => 22
            ),
            'amount' => array(
                'type' => 'INT',
                'constraint' => 10
            ),
            'remark' => array(
                'type' => 'TEXT'
            ),
            'created_at' => array(
                'type' => 'DATETIME'
            ),
        ));

        $this->dbforge->add_key('cashOut_id', TRUE);
        $this->dbforge->create_table('cash_out_tbl', TRUE);

        // ------------ End of Create Tables ---------------
    }


	
}