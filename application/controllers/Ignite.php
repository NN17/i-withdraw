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

    /*
	Rates 
    */

    public function rates(){
    	$data['rates'] = $this->ignite_model->get_data('rates_tbl')->result();
    	$data['content'] = 'pages/rates';
    	$this->load->view('layouts/template', $data);
    }

    public function newRate(){
    	$data['cashType'] = $this->ignite_model->get_cashType();
    	$data['content'] = 'pages/defineRate';
    	$this->load->view('layouts/template', $data);
    }

    public function addRate(){
    	$type = $this->input->post('type');
    	$cashInPercent = $this->input->post('cashInPercent');
    	$cashOutPercent = $this->input->post('cashOutPercent');
    	$remark = $this->input->post('remark');

    	$insert = array(
    		'cashType' => $type,
    		'cashInRate' => $cashInPercent,
    		'cashOutRate' => $cashOutPercent,
    		'remark' => $remark
    	);

    	$this->db->insert('rates_tbl', $insert);
    	redirect('ignite/rates');
    }

    // Cash In

    public function cashIn(){
    	$type = $this->uri->segment(3);

        if($type === "WP"){
            $data['content'] = 'pages/wpCashIn';
        }else{
    	   $data['content'] = 'pages/cashIn';
        }
    	$data['rate'] = $this->ignite_model->get_limit_data('rates_tbl', 'cashType', $type)->row_array();
    	$this->load->view('layouts/template', $data);
    }

    public function addCashIn(){
    	$type = $this->uri->segment(3);

    	$rate = $this->input->post('payBackPercent');
    	$senderName = $this->input->post('senderName');
    	$accNum = $this->input->post('accNum');
    	$amount = $this->input->post('amount');
    	$remark = $this->input->post('remark');
        $tranType = 'A';
        $sAcc = 0;
        $psw = 0;

    	$insert = array(
    		'cashType' => $type,
            'transferType' => $tranType,
    		'payBackPercent' => $rate,
    		'senderName' => $senderName,
    		's_accNum' => $sAcc,
            'r_accNum' => $accNum,
            'password' => $psw,
    		'amount' => $amount,
    		'remark' => $remark,
    		'created_date' => date('Y-m-d h:i:s A')
    	);

    	$this->db->insert('cash_in_tbl', $insert);

    	$dataMax = $this->ignite_model->max('cash_in_tbl', 'cashIn_id');
    	redirect('ignite/cashInPreview/'.$dataMax);
    }

    public function addWavePswCashIn(){
        $type = $this->uri->segment(3);

        $rate = $this->input->post('payBackPercent');
        $senderName = $this->input->post('senderName');
        $sAcc = $this->input->post('s_accNum');
        $accNum = $this->input->post('r_accNum');
        $amount = $this->input->post('amount');
        $remark = $this->input->post('remark');
        $tranType = 'B';
        $psw = $this->input->post('psw');

        $insert = array(
            'cashType' => $type,
            'transferType' => $tranType,
            'payBackPercent' => $rate,
            'senderName' => $senderName,
            's_accNum' => $sAcc,
            'r_accNum' => $accNum,
            'password' => $psw,
            'amount' => $amount,
            'remark' => $remark,
            'created_date' => date('Y-m-d h:i:s A')
        );

        $this->db->insert('cash_in_tbl', $insert);

        $dataMax = $this->ignite_model->max('cash_in_tbl', 'cashIn_id');
        redirect('ignite/cashInPreview/'.$dataMax);
    }

    public function editCashIn(){
        $cashInId = $this->uri->segment(3);

        $data['cashIn'] = $this->ignite_model->get_limit_data('cash_in_tbl', 'cashIn_id', $cashInId)->row_array();

        if($data['cashIn']['cashType'] === "WP"){
            $data['content'] = 'pages/edit_wpCashIn';
        }else{
           $data['content'] = 'pages/edit_cashIn';
        }
        $data['rate'] = $this->ignite_model->get_limit_data('rates_tbl', 'cashType', $data['cashIn']['cashType'])->row_array();
        $this->load->view('layouts/template', $data);
    }

    public function modifyCashIn(){
        $cashInId = $this->uri->segment(3);

        $rate = $this->input->post('payBackPercent');
        $senderName = $this->input->post('senderName');
        $accNum = $this->input->post('accNum');
        $amount = $this->input->post('amount');
        $remark = $this->input->post('remark');

        $insert = array(
            'payBackPercent' => $rate,
            'senderName' => $senderName,
            'r_accNum' => $accNum,
            'amount' => $amount,
            'remark' => $remark,
            'created_date' => date('Y-m-d h:i:s A')
        );

        $this->db->where('cashIn_id', $cashInId);
        $this->db->update('cash_in_tbl', $insert);

        redirect('ignite/cashInPreview/'.$cashInId);
    }

    public function modifyWavePswCashIn(){
        $cashInId = $this->uri->segment(3);

        $rate = $this->input->post('payBackPercent');
        $senderName = $this->input->post('senderName');
        $sAcc = $this->input->post('s_accNum');
        $accNum = $this->input->post('r_accNum');
        $amount = $this->input->post('amount');
        $remark = $this->input->post('remark');
        $psw = $this->input->post('psw');

        $insert = array(
            'payBackPercent' => $rate,
            'senderName' => $senderName,
            's_accNum' => $sAcc,
            'r_accNum' => $accNum,
            'password' => $psw,
            'amount' => $amount,
            'remark' => $remark,
            'created_date' => date('Y-m-d h:i:s A')
        );

        $this->db->where('cashIn_id', $cashInId);
        $this->db->update('cash_in_tbl', $insert);

        redirect('ignite/cashInPreview/'.$cashInId);
    }

    // Preview ..

    public function cashInPreview(){
    	$cashInId = $this->uri->segment(3);

    	$data['cashInData'] = $this->ignite_model->get_limit_data('cash_in_tbl', 'cashIn_id', $cashInId)->row_array();
    	$data['content'] = 'pages/cashInPreview';
    	$this->load->view('layouts/template', $data);
    }

    // Receipt Printing ..

    public function printReceipt(){
        $type = $this->uri->segment(3);
        $id = $this->uri->segment(4);
        $discount = $this->uri->segment(5);

        if($type == "IN"){
            $cap = 'CI';
            $cashInData = $this->ignite_model->get_limit_data('cash_in_tbl', 'cashIn_id', $id)->row_array();
            if($cashInData['transferType'] === 'B' && $cashInData['cashType'] == 'WP'){
                $charges = $this->ignite_model->waveTransferRate($cashInData['amount']);
            }
                else{
                    $charges = 0;
                }

            $insert = array(
                'serial' => $cap.'-'.sprintf('%05d', $id).'-'.date('ydm'),
                'cashInOut' => $type,
                'cashType' => $cashInData['cashType'],
                'transferType' => $cashInData['transferType'],
                'rate' => $cashInData['payBackPercent'],
                'name' => $cashInData['senderName'],
                's_acc' => $cashInData['s_accNum'],
                'r_acc' => $cashInData['r_accNum'],
                'password' => $cashInData['password'],
                'amount' => $cashInData['amount'],
                'charges' => $charges,
                'discount' => $discount,
                'print' => true,
                'created_at' => date('Y-m-d h:i A')
            );

            $this->db->insert('check_out_tbl', $insert);
        }else{
            $cap = 'CO';

            $cashOut = $this->ignite_model->get_limit_data('cash_out_tbl', 'cashOut_id', $id)->row();
            $insert = array(
                'serial' => $cap.'-'.sprintf('%05d', $id).'-'.date('ydm'),
                'cashInOut' => $type,
                'cashType' => $cashOut->cashType,
                'transferType' => 'A',
                'rate' => $cashOut->cashOutRate,
                'name' => $cashOut->withdrawName,
                's_acc' => $cashOut->acc,
                'r_acc' => 0,
                'password' => 0,
                'amount' => $cashOut->amount,
                'charges' => 0,
                'discount' => $discount,
                'print' => true,
                'created_at' => date('Y-m-d h:i A')
            );

            $this->db->insert('check_out_tbl', $insert);
        }
        

        $max = $this->ignite_model->max('check_out_tbl', 'checkOut_id');
        $checkOut = $this->ignite_model->get_limit_data('check_out_tbl','checkOut_id', $max)->row();

        $this->load->library('escpos');
        if($type === "IN"){
            $this->escpos->print_receipt($checkOut);
        }
            elseif($type === "OUT"){
                $this->escpos->print_cashOut($checkOut);
            }
        redirect('ignite/home');
    }

    // Cash Out ..
    public function cashOut(){
        $type = $this->uri->segment(3);
        if($type === "WP"){
            $data['content'] = 'pages/wpCashOut';
        }
            else{
                $data['content'] = 'pages/cashOut';
            }

        $data['rate'] = $this->ignite_model->get_limit_data('rates_tbl', 'cashType', $type)->row_array();
        $this->load->view('layouts/template', $data);
    }

    public function createCashOut(){
        $type = $this->uri->segment(3);

        $rate = $this->input->post('cashOutRate');
        $withdrawName = $this->input->post('withdrawName');
        $accNum = $this->input->post('accNum');
        $amount = $this->input->post('amount');
        $remark = $this->input->post('remark');

        $insert = array(
            'cashType' => $type,
            'withdrawType' => 'A',
            'withdrawID'=> 0,
            'cashOutRate' => $rate,
            'withdrawName' => $withdrawName,
            'acc' => $accNum,
            'amount' => $amount,
            'remark' => $remark,
            'created_at' => date('Y-m-d h:i:s A')
        );

        $this->db->insert('cash_out_tbl', $insert);

        $dataMax = $this->ignite_model->max('cash_out_tbl', 'cashOut_id');
        redirect('ignite/cashOutPreview/'.$dataMax);
    }

    public function createWPCashOut(){
        $type = $this->uri->segment(3);

        $data = $this->input->post();
        print_r($data);
        $insert = array(
            'cashType' => $type,
            'withdrawType' => 'B',
            'withdrawID' => $data['withdrawId'],
            'password' => $data['psw'],
            'cashOutRate' => $data['rate'],
            'withdrawName' => $data['withdrawName'],
            'acc' => $data['acc'],
            'amount' => $data['amount'],
            'remark' => $data['remark'],
            'created_at' => date('Y-m-d h:i A')
        );

        $this->db->insert('cash_out_tbl', $insert);
        $dataMax = $this->ignite_model->max('cash_out_tbl', 'cashOut_id');
        redirect('ignite/cashOutPreview/'.$dataMax);
    }

    public function editCashOut(){
        $cashOutId = $this->uri->segment(3);

        $data['cashOut'] = $this->ignite_model->get_limit_data('cash_out_tbl', 'cashOut_id', $cashOutId)->row();
        if($data['cashOut']->cashType === "WP"){
            $data['content'] = 'pages/edit_wpCashOut';
        }
            else{
                $data['content'] = 'pages/edit_cashOut';
            }

        $this->load->view('layouts/template', $data);
    }

    public function cashOutPreview(){
        $cashOutId = $this->uri->segment(3);

        $data['cashOut'] = $this->ignite_model->get_limit_data('cash_out_tbl', 'cashOut_id', $cashOutId)->row();
        $data['content'] = 'pages/cashOutPreview';
        $this->load->view('layouts/template', $data);
    }

    public function test_print(){
        $this->load->library('escpos');
        $this->escpos->print_receipt();
    }
}
	