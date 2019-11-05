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

        
        
        // ------------ End of Create Tables ---------------
    }


	
}