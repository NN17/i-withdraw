<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ignite extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */

    function __construct(){
        parent::__construct();
        $this->load->model('migrate');
        $this->migrate->table_migrate();

        date_default_timezone_set('Asia/Rangoon');
    }

	public function index()
	{
		$this->load->view('layouts/auth');
    }

    public function login(){
        $username = $this->input->post('username', TRUE);
        $password = $this->input->post('psw', TRUE);

        $login = $this->ignite_model->loginState($username, $password);
        if($login['status']){
            redirect('home');
            // echo 'true';
        }else{
            $this->load->view('layouts/auth');
            // echo 'false';
        }
    }
    
    public function home(){
        $data['content'] = 'pages/home';
        $this->load->view('layouts/template', $data);
    }
}
