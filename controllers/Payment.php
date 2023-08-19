<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Payment extends CI_Controller {


    public function __construct() {
        parent::__construct();

        $this->load->config('settings');        
    }

    // $token = order_id has
    public function bkash(){

        $this->load->library('bkash');

        if( !empty($this->input->get('action')) && $this->input->get('action') == 'create'){
            $payload = ['amount' => 500, 'invoice_no' => time(), 'intent' => 'sale', "currency" => "BDT"];

            $result = $this->bkash->create($payload);

            if($result->status == 'error'){
                //Payment initianlize/create
                // Update order status as Failed
            }
            else{
                //Payment initianlize/create
                // Update order status to pending or initialize
            }

            echo json_encode($result);            
            exit();
        }

        if(!empty($this->input->get('action')) && $this->input->get('action') == 'execute'){

            $payload = ['paymentID' => $this->input->get('paymentID')];

            $result = $this->bkash->execute($payload);

            if( $result->status == 'success' ){
               // Payment Success Update Necessary status
            }
            else{
                // Payment failed Update Neccessary status
            }
            
            echo json_encode($result);
            exit();
        }

        
        // Generate Payment token to start with bkash
        $result = $this->bkash->token();

        $this->keep_log($order_info, $result, 'response', $result->status);

        $data = [
            'bkash_token' => $result->token,
            'create_url'  => base_url('payment/bkash').'?action=create',
            'execute_url' => base_url('payment/bkash').'?action=execute',
        ];

        $this->load->view('bkash', $data);
    }
}