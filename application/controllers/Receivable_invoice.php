
<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Receivable_invoice extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model(array('M_Receivable_invoice'));
        $this->load->library(array('user_agent'));

        if (!$this->session->userdata('userid_1')) {
            redirect('login');
        }
    }

    public function index() {

        $data['SupplierID'] = $this->M_Receivable_invoice->get_customer();
        $data['CurrencyID'] = $this->M_Receivable_invoice->get_currency();
        
        $this->template->display('accounting/Laporan/Receivable_invoice', $data);
    }
    
    function search() {
        $sup        = $this->input->get('supplier');
        // $tgl = $this->input->get('periode'). "-" . date("t");
        $curreny    = $this->input->get('currency');

        $p_dari     = $this->input->get('dari');
        $p_sampai   = $this->input->get('sampai');
        $data['SupplierID'] = $this->M_Receivable_invoice->get_customer();
       // // $data['GroupSupplierID'] = $this->M_Receivable_invoice->get_supply($sup, $curreny, $tgl);
         $data['CurrencyID'] = $this->M_Receivable_invoice->get_currency();
        $data['get_invoice'] = $this->M_Receivable_invoice->call_data($sup, $curreny, $p_dari, $p_sampai);

        // print_r($data);
        // die;
       $this->template->display('accounting/Laporan/Receivable_invoice', $data);
    }
    
    function print_report() {
        $sup = $this->input->get('supplier');
        $dari= $this->input->get('dari'). "-" . date("t");
        $currency = $this->input->get('currency');

        $curTemp = $currency;
        if($curTemp == ''){
            $curTemp = 'USD';
        }

        $data['cur']        = $curTemp;
        $data['periode']    = $dari;
        $data['get_data_detail'] = $this->M_Receivable_invoice->call_data($sup, $currency, $dari);
        $data['supu']       = $this->M_Receivable_invoice->get_supply($sup, $currency, $dari);
        
        $this->load->view('accounting/rpt/rpt_receivable_invoice2', $data);
    }

    
    


}
