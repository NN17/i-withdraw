<?php
use Mike42\Escpos\Printer;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\ImagickEscposImage;
use Mike42\Escpos\PrintConnectors\NetworkPrintConnector;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\PrintBuffers\EscposPrintBuffer;
use Mike42\Escpos\PrintBuffers\ImagePrintBuffer;
defined('BASEPATH') OR exit('No direct script access allowed');

class Escpos
{
    protected $CI;

    public function __construct()
    {
        $this->CI =& get_instance();

        $this->CI->load->library('session');
        $this->CI->load->helper('url');
    }

    public function print_receipt($data){
        $payBackAmt = $data->amount * ($data->rate / 100);
        $total = ($data->amount + $data->charges) - $payBackAmt;
        
        $connector = new WindowsPrintConnector("XP-80C");
        $printer = new Printer($connector);
        $textBuffer = new EscposPrintBuffer();
        $printer->setJustification(Printer::JUSTIFY_CENTER);
        $printer->selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
        $printer->setEmphasis(true);
        $printer->text("Commercial Receipt \n");
        $printer->feed();
        $printer->text($this->CI->ignite_model->get_cashType_name($data->cashType)."\n");
        $printer->setEmphasis(false);
        $printer->selectPrintMode();
        if($data->transferType === "A"){
            $printer->text("( Account )\n");
        }
            else{
                $printer->text("( Password )\n");
            }

        $printer->feed();
        $printer->setJustification(Printer::JUSTIFY_RIGHT);
        $printer->text("ID : ".$data->serial."\n");
        $printer->text("Date : ".$data->created_at."\n");
        $printer->feed();

        $printer->setJustification(Printer::JUSTIFY_LEFT);
        $printer->text("Name : ".$data->name."\n");
        $printer->text("------------------------------------------------\n");
        $printer->feed();

        if($data->transferType === "B"){
            $printer->text($this->printOption('From Account', $data->s_acc));
            $printer->text($this->printOption('To Account', $data->r_acc));
            $printer->text($this->printOption('Password', $data->password));
        }
            else{
                $printer->text($this->printOption('To Account', $data->r_acc));
            }

        $printer->text($this->printOption('Transfer Amount', number_format($data->amount)));
        if($data->transferType === "B"){
            $printer->text($this->printOption('Service Charges', number_format($data->charges)));
        }
        $printer->text($this->printOption('Pay Back amount', number_format($payBackAmt)));
        $printer->feed();
        $printer->text("------------------------------------------------\n");

        $printer->setEmphasis(true);
        $printer->text($this->printOption('Total', number_format($total)));
        $printer->text($this->printOption('Discount', number_format($data->discount)));
        $printer->text($this->printOption('Grand Total', number_format($total - $data->discount)));

        $printer -> cut();
        $printer -> close();
    }

    public function print_cashOut($data){
        $withdrawRate = $data->amount * ($data->rate / 100);
        $total = ($data->amount + $data->charges) - $withdrawRate;
        
        $connector = new WindowsPrintConnector("XP-80C");
        $printer = new Printer($connector);
        $textBuffer = new EscposPrintBuffer();
        $printer->setJustification(Printer::JUSTIFY_CENTER);
        $printer->selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
        $printer->setEmphasis(true);
        $printer->text("Commercial Receipt \n");
        $printer->feed();
        $printer->text($this->CI->ignite_model->get_cashType_name($data->cashType)."\n");
        $printer->setEmphasis(false);
        $printer->selectPrintMode();
        if($data->transferType === "A"){
            $printer->text("( Account )\n");
        }
            else{
                $printer->text("( Password )\n");
            }

        $printer->feed();
        $printer->setJustification(Printer::JUSTIFY_RIGHT);
        $printer->text("ID : ".$data->serial."\n");
        $printer->text("Date : ".$data->created_at."\n");
        $printer->feed();

        $printer->setJustification(Printer::JUSTIFY_LEFT);
        $printer->text("Name : ".$data->name."\n");
        $printer->text("------------------------------------------------\n");
        $printer->feed();

        if($data->transferType === "B"){
            $printer->text($this->printOption('From Account', $data->s_acc));
            $printer->text($this->printOption('To Account', $data->r_acc));
            $printer->text($this->printOption('Password', $data->password));
        }
            else{
                $printer->text($this->printOption('To Account', $data->r_acc));
            }

        $printer->text($this->printOption('Withdraw Amount', number_format($data->amount)));
        if($data->transferType === "B"){
            $printer->text($this->printOption('Service Charges', number_format($data->charges)));
        }
        $printer->text($this->printOption('Withdraw Charges', number_format($withdrawRate)));
        $printer->feed();
        $printer->text("------------------------------------------------\n");

        $printer->setEmphasis(true);
        $printer->text($this->printOption('Total', number_format($total)));
        $printer->text($this->printOption('Discount', number_format($data->discount)));
        $printer->text($this->printOption('Grand Total', number_format($total + $data->discount)));

        $printer -> cut();
        $printer -> close();
    }

    public function printOption($left, $right, $width=48){
        $str_left = str_pad($left, 24, ' ');
        $str_right = str_pad($right, 24, ' ', STR_PAD_LEFT);
        return $str_left.$str_right."\n";
    }


    
}

/* End of file Ignite.php */
/* Location: ./application/libraries/Ignite.php */
