<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ignite_model extends CI_Model {
    // **************** Login State Function ****************

	function loginState($username,$password)
	{
		$row = $this->db->query("SELECT * FROM accounts_tbl WHERE username = '$username'")->row_array();
		
        // Check Username or Email
        if (!empty($row['username'])){
            $hash = $row['secret'];
        //     // Check Password
            if ($this->auth->verify_password($password, $hash) == true){
        //         // Check Account State
                if($row['accountState'] == true){
                    $this->session->set_userdata('loginState',true);
                    $this->session->set_userdata('username',$username);
                    $this->session->set_userdata('Id',$row['accId']);
                    $this->session->set_userdata('roleId', $row['role']);

                    $loginState = array(
                        'status' => true,
                        'msg' => $row['accId']
                        );
        //             break;
                }
        //             // Account State false
                    else{
                        $loginState = array(
                            'status' => false,
                            'errCode' => 1003
                        );
                    }
            }
        //         // If Password False
                else {
                    $loginState = array(
                        'status' => false,
                        'errCode' => 1002
                        );
                }
        }
        //     // If Username False
            else {
                $loginState = array(
                        'status' => false,
                        'errCode' => 1001
                        );
            }
        return $loginState;

    }

    function login_mobile($username, $psw, $imei){
        $row = $this->db->query("SELECT * FROM accounts_tbl WHERE username = '$username'")->row_array();

        // Check Username or Email
        if (!empty($row['username'])){
            $hash = $row['secret'];
            // Check Password
            if ($this->auth->verify_password($psw, $hash) == true){
                // Check Account State
                if($row['accountState'] == true){
                    // Check Device
                    if($row['role'] === 2){
                        $imeiHash = $row['deviceID'];
                        if($this->auth->verify_password($imei, $imeiHash)){
                            $loginState = array(
                                'status' => true,
                                'username' => $username,
                                'accId' => $row['accId'],
                                'accStatus' => $row['accountState'],
                                'err' => false
                            );
                        }
                        // IMEI false
                        else{
                            $loginState = array(
                                'status' => false,
                                'username' => NULL,
                                'accId' => NULL,
                                'accStatus' => NULL,
                                'err' => 'Invalid IMEI'
                            );
                        }
                    }
                    else{
                        $loginState = array(
                            'status' => true,
                            'username' => $username,
                            'accId' => $row['accId'],
                            'accStatus' => $row['accountState'],
                            'err' => false
                        );
                    }
                }
                    // Account State false
                    else{
                        $loginState = array(
                            'status' => false,
                            'username' => NULL,
                            'accId' => NULL,
                            'accStatus' => NULL,
                            'err' => 'Access Denied'
                        );
                    }
            }
                // If Password False
                else {
                    $loginState = array(
                        'status' => false,
                        'username' => NULL,
                        'accId' => NULL,
                        'accStatus' => NULL,
                        'err' => 'Wrong Password'
                        );
                }
        }
            // If Username False
            else {
                $loginState = array(
                        'status' => false,
                        'username' => NULL,
                        'accId' => NULL,
                        'accStatus' => NULL,
                        'err' => 'Invalid Username'
                        );
            }
        return $loginState;
    }
    
    function get_data($table){
        $query = $this->db->get($table);
        return $query;
    }

    function get_limit_data($table, $field, $value){
        $this->db->where($field, $value);
        $query = $this->db->get($table);
        return $query;
    }

    function get_limit_datas($table, $parms){
        foreach($parms as $key => $value){
            $this->db->where($key, $value);
        }
        $query = $this->db->get($table);
        return $query;
    }

    function get_link_name($id){
        $this->db->where('linkId', $id);
        $query = $this->db->get('link_structure_tbl')->row_array();
        return $query['name'];
    }

    /* 
    * Calculate Remaining Day 
    * Date format must be (Y-m-d)
    //////////////////////////////////////////////////////////////////////
    //PARA: Date Should In YYYY-MM-DD Format
    //RESULT FORMAT:
    // '%y Year %m Month %d Day %h Hours %i Minute %s Seconds'        =>  1 Year 3 Month 14 Day 11 Hours 49 Minute 36 Seconds
    // '%y Year %m Month %d Day'                                    =>  1 Year 3 Month 14 Days
    // '%m Month %d Day'                                            =>  3 Month 14 Day
    // '%d Day %h Hours'                                            =>  14 Day 11 Hours
    // '%d Day'                                                        =>  14 Days
    // '%h Hours %i Minute %s Seconds'                                =>  11 Hours 49 Minute 36 Seconds
    // '%i Minute %s Seconds'                                        =>  49 Minute 36 Seconds
    // '%h Hours                                                    =>  11 Hours
    // '%a Days                                                        =>  468 Days
    //////////////////////////////////////////////////////////////////////
    */

    function remainingDay($startDate, $endDate){
        $startDate = date_create($startDate);
        $endDate = date_create($endDate);

        $diff = date_diff($startDate, $endDate, TRUE);
        return $diff->format('%a');
    }

    /* 
    * Select Max Value From Database
    */
    function max($table, $field){
        $this->db->select_max($field);
        $query = $this->db->get($table)->row_array();
        return $query[$field];
    }

    function emailCheck($email){
        $this->db->where('email', $email);
        $query = $this->db->get('users_tbl')->row_array();
        if(empty($query['email'])){
            if(filter_var($email, FILTER_VALIDATE_EMAIL)){
                return array('status' => true, 'msg' => 'success');
            }
                else{
                    return array('status' => false, 'msg' => 'Invalid Email Address');
                }
        }
            else{
                return array('status' => false, 'msg' => 'Email Already taken');
            }
    }

    // Check Password Strength method
    function valid_password($password)
	{
		$password = trim($password);
		$regex_lowercase = '/[a-z]/';
		$regex_uppercase = '/[A-Z]/';
		$regex_number = '/[0-9]/';
		$regex_special = '/[!@#$%^&*()\-_=+{};:,<.>§~]/';
		if (empty($password))
		{
            $data = array('status' => false, 'msg' => 'Password must not be empty.');
			return $data;
		}
		if (preg_match_all($regex_uppercase, $password) < 1)
		{
            $data = array('status' => false, 'msg' => 'Password must include at least one Uppercase letter.');
			return $data;
		}
		if (preg_match_all($regex_number, $password) < 1)
		{
            $data = array('status' => false, 'msg' => 'Password must include at least one number.');
			return $data;
		}
		
		if (strlen($password) < 5)
		{
            $data = array('status' => false, 'msg' => 'Password must be at least 5 character in length.');
			return $data;
		}
		if (strlen($password) > 32)
		{
			$data = array('status' => false, 'msg' => 'Password must be exceed 32 character in length.');
			return $data;
		}
		return $data = array('status' => true);
	}

    // Error Return Function

    // 1001 : return Invalid username or Email Address
    // 1002 : return Invalid Password
    // 1003 : return Account is not Activated

    function error($errorNum){
        switch($errorNum){
            case 1001:
                return 'Invalid Username or Email Address';
                break;
            case 1002:
                return 'Invalid Password !';
                break;
            case 1003:
                return 'Your Account is not Activate !';
                break;
        }
    }

    /* 
    * Image Upload Function
    */
    function upload_img($file,$path)
    {
        $config['upload_path'] = $path;
        $config['allowed_types'] = 'gif|jpg|jpeg|png';
        $config['max_size']     = '1024';
        $config['file_name'] = 'upload_'.time();
        $this->upload->initialize($config);
        
        if ($this->upload->do_upload($file))
        {
            $file_name = $this->upload->data('file_name');
            return array('status' => true, 'path' => $path.'/'.$file_name);

        }
            else
            {
                return array('status' => false, 'err' => $this->upload->display_errors());
            }

    }

    /* 
    * Image Resize Function
    */
    function resize_img($path){
        $config['image_library'] = 'gd2';
        $config['source_image'] = $path;
        // $config['create_thumb'] = TRUE;
        $config['maintain_ratio'] = TRUE;
        $config['width'] = 1080;
        $config['height'] = 480;

        $this->load->library('image_lib', $config);

        if($this->image_lib->resize()){
            return true;
        }
            else{
                return $this->image_lib->display_errors();
            }
    }

    function getMonth($month){
        switch($month){
            case 1:
                return 'January';
                break;
            case 2:
                return 'February';
                break;
            case 3:
                return 'March';
                break;
            case 4:
                return 'April';
                break;
            case 5:
                return 'May';
                break;
            case 6:
                return 'June';
                break;
            case 7:
                return 'July';
                break;
            case 8:
                return 'August';
                break;
            case 9:
                return 'September';
                break;
            case 10:
                return 'October';
                break;
            case 11:
                return 'November';
                break;
            case 12:
                return 'December';
                break;
        }
    }

    // Custom Functions

    function get_cashType(){
        $query = $this->db->query("SELECT cashType FROM rates_tbl");
        return $query->result();
    }

    function get_cashType_name($val){
        switch($val){
            case 'KP':
                return 'K-Pay';
                break;
            case 'WP':
                return 'Wave Pay';
                break;
            case 'CP':
                return 'CB-Pay';
                break;
            case 'MP':
                return 'Mytel Pay';
                break;
            case 'AP':
                return 'AYA Pay';
                break;
            case 'OK':
                return 'OK Dollar';
                break;
        }
    }

    // Return Wave Money Transfer Rate
    function waveTransferRate($val){
        if($val <= 10000){
            return 400;
        }
            elseif ($val <= 25000) {
                return 700;
            }
                elseif ($val <= 50000){
                    return 1000;
                }
                    elseif ($val <= 100000){
                        return 1500;
                    }
                        elseif ($val <= 150000){
                            return 2000;
                        }
                            elseif ($val <= 200000){
                                return 2500;
                            }
                                elseif ($val <= 300000){
                                    return 3000;
                                }
                                    elseif ($val <= 400000){
                                        return 4000;
                                    }
                                        elseif ($val <= 500000){
                                            return 4500;
                                        }
                                            elseif ($val <= 600000){
                                                return 5400;
                                            }
                                                elseif ($val <= 700000){
                                                    return 6000;
                                                }
                                                    elseif ($val <= 800000){
                                                        return 6700;
                                                    }
                                                        elseif ($val <= 900000){
                                                            return 7400;
                                                        }
                                                            elseif ($val <= 1000000){
                                                                return 8000;
                                                            }
    }

    

}