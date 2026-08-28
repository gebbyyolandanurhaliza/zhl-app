
<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Receivable_mutation extends CI_Controller {

function __construct(){
        parent::__construct();
        $this->load->model(array('M_Receivable_mutation'));
        $this->load->model(array('M_Aged_Receivable_Summary'));
        $this->load->library(array('user_agent'));

        if (!$this->session->userdata('userid_1')) {
            redirect('login');
        }
    }

    public function index() {

        $data['CustomerID'] = $this->M_Receivable_mutation->get_customer();
        $data['CurrencyID'] = $this->M_Receivable_mutation->get_currency();
        
        $this->template->display('accounting/Receivable_mutation', $data);
    }

    
    function search(){
        $cust = $this->input->get('customer');
        $curreny = $this->input->get('currency');

        $period = $this->input->get('periode');
        $periode = date('Y-m-d', strtotime($period));

        //  if($curreny == ''){
        //     $cur = 'ALL';
        // }else{
        //     $cur = $curreny;
        // }

       
        $data['CustomerID'] = $this->M_Receivable_mutation->get_customer();

        // $data['curr']  = $cur;

        
        $data['GroupSupplierID'] = $this->M_Aged_Receivable_Summary->get_group_supp($periode, $cust,$curreny);
        $data['CurrencyID'] = $this->M_Aged_Receivable_Summary->get_currency();
        $data['Get_aging']  = $this->M_Aged_Receivable_Summary->call_data($cust, $curreny, $periode);

        $this->template->display('accounting/Receivable_mutation', $data);
    }

    function print_report(){
        $cust = $this->input->get('customer');
        $tgl = $this->input->get('periode');
        $curreny = $this->input->get('currency');

        $periode = date('Y-m-d', strtotime($tgl));

        // if($curreny == ''){
        //     $cur = 'ALL';
        // }else{
        //     $cur = $curreny;
        // }

        $curTemp = $curreny;

        if ($curTemp == ''){
            $curTemp ='USD';
        }

        $data['cur']  = $curTemp ;
        $data['periode']  = $periode ;
        $data['GroupSupplierID'] = $this->M_Aged_Receivable_Summary->get_group_supp($periode, $cust,$curreny);
        $data['Get_aging']  = $this->M_Aged_Receivable_Summary->call_data($cust, $curreny, $periode);

      
        $this->load->view('accounting/rpt/rpt_receivable_mutation', $data);
    }


}
