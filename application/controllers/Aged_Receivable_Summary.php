
<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Aged_Receivable_Summary extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model(array('M_Aged_Receivable_Summary'));
        $this->load->library(array('user_agent','Excelen/PHPExcel'));
        $this->load->helper('mysqli');
        if (!$this->session->userdata('userid_1')) {
            redirect('login');
        }
    }

    public function index() {

        $data['SupplierID'] = $this->M_Aged_Receivable_Summary->get_supplier();
        $data['CurrencyID'] = $this->M_Aged_Receivable_Summary->get_currency();

        $this->template->display('accounting/aged_receivable_summary', $data);
    }

    function search() {
        $sup = $this->input->get('supplier');
        $curreny = $this->input->get('currency');
        
        $period = str_replace('-', '-', $this->input->get('period'));
        $periode = date('Y-m-d', strtotime($period));
        
        $data['SupplierID'] = $this->M_Aged_Receivable_Summary->get_customer();
        $data['GroupSupplierID'] = $this->M_Aged_Receivable_Summary->get_group_supp($periode, $sup,$curreny);
        $data['CurrencyID'] = $this->M_Aged_Receivable_Summary->get_currency();
        $data['Get_aging']  = $this->M_Aged_Receivable_Summary->call_data($sup, $curreny, $periode);
       


        $this->template->display('accounting/aged_receivable_summary', $data);
    }

      function print_report() {
        $sup = $this->input->get('supplier');
        $currency = $this->input->get('currency');
        $curTemp = $currency;

        // if ($curTemp == ''){
        // 	$curTemp = 'USD';
        // }

        $period = str_replace('-', '-', $this->input->get('period'));
        $periode = date('Y-m-d', strtotime($period));

        $data['periode'] = $periode;
        $data['cur'] = $curTemp;
        $data['GroupSupplierID'] = $this->M_Aged_Receivable_Summary->get_group_supp($periode, $sup, $curTemp);
        $data['get_data_detail'] = $this->M_Aged_Receivable_Summary->call_data($sup, $currency, $periode);
        
        $this->load->view('accounting/rpt/rpt_aged_receivable_summary', $data);
    }
}
