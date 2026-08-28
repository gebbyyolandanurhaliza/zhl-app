
<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Payable_invoice extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model(array('M_Payable_invoice'));
        $this->load->library(array('user_agent', 'Template'));
        $this->load->helper('mysqli');
        if (!$this->session->userdata('userid_1')) {
            redirect('login');
        }
    }

    public function index() {

        $data['SupplierID'] = $this->M_Payable_invoice->get_supplier();
        $data['CurrencyID'] = $this->M_Payable_invoice->get_currency();

        $this->template->display('accounting/payable_invoice', $data);
    }

    function search() {
        $sup = $this->input->get('supplier');
        $tgl = $this->input->get('periode')."/".date("t");
        $currency = $this->input->get('currency');
        $data['SupplierID'] = $this->M_Payable_invoice->get_supplier();
        $data['CurrencyID'] = $this->M_Payable_invoice->get_currency();
        $data['GroupSupplierID'] = $this->M_Payable_invoice->get_group_supp($tgl, $sup, $currency);
        // $data['get_data'] = $this->M_Payable_invoice->get_data($bln, $thn, $sup, $currency);

        $data['get_invoice'] = $this->M_Payable_invoice->call_data($sup, $currency, $tgl);
        //$data['get_invoice'] = $this->M_Payable_invoice->call_data('AIA', 'SGD', '2016-03-23');



        $this->template->display('accounting/payable_invoice', $data);
    }

    function print_report() {
        $sup = $this->input->get('supplier');
        $dari= $this->input->get('dari') . "/" . date("t");
        $currency = $this->input->get('currency');

        $curTemp = $currency;
        if ($curTemp == ''){
            $curTemp = 'USD';
        }

        $title = 'Payable Invoice';

        $data['cur'] = $curTemp;
        $data['periode'] = $dari;
        $data['get_data_detail'] = $this->M_Payable_invoice->call_data($sup, $currency, $dari);
        $data['get_supply'] = $this->M_Payable_invoice->get_supply($sup, $currency, $dari);
        $this->load->view('accounting/rpt/rpt_payable_invoice', $data);
    }

}
