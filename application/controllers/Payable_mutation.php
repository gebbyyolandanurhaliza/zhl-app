
<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Payable_mutation extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model(array('M_Payable_mutation'));
        $this->load->model(array('M_Aged_Payable_Summary'));
        $this->load->library(array('user_agent', 'Template'));
        $this->load->helper('mysqli');
        if (!$this->session->userdata('userid_1')) {
            redirect('login');
        }
    }

    public function index() {

        $data['SupplierID'] = $this->M_Payable_mutation->get_supplier();
        $data['CurrencyID'] = $this->M_Payable_mutation->get_currency();

        $this->template->display('accounting/payable_mutation', $data);
    }

    function search() {
        $sup = $this->input->get('supplier');
        $tgl = $this->input->get('periode');
        $curreny = $this->input->get('currency');

        $periode = date('Y-m-d', strtotime($tgl));

        // if($curreny == ''){
        //     $cur = 'ALL';
        // }else{
        //     $cur = $curreny;
        // }


        $data['SupplierID'] = $this->M_Aged_Payable_Summary->get_supplier();
        $data['GroupSupplierID'] = $this->M_Aged_Payable_Summary->get_group_supp($periode, $sup,$curreny);
        $data['CurrencyID'] = $this->M_Aged_Payable_Summary->get_currency();
        $data['Get_aging']  = $this->M_Aged_Payable_Summary->call_data($sup, $curreny, $periode);

        $this->template->display('accounting/payable_mutation', $data);
    }

     function print_report() {
        $sup = $this->input->get('supplier');
        $tgl = $this->input->get('periode');
        $periode = date('Y-m-d',strtotime($tgl));
        

        $curreny = $this->input->get('currency');

        // if($curreny == ''){
        //     $cur = 'ALL';
        // }else{
        //     $cur = $curreny;
        // }

        $curTemp = $curreny;

        if ($curTemp == ''){
            $curTemp ='USD';
        }

        $title = 'Payable Mutation';

        $data['cur'] = $curTemp; 
        $data['periode'] = $periode;
        $data['GroupSupplierID'] = $this->M_Aged_Payable_Summary->get_group_supp( $periode, $sup,$curreny);
        $data['Get_aging']  = $this->M_Aged_Payable_Summary->call_data($sup, $currency,  $periode);
      
        $this->load->view('accounting/rpt/rpt_payable_mutation', $data);
    }


}
