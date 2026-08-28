
<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Aged_Payable_Summary extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model(array('M_Aged_Payable_Summary'));
        $this->load->library(array('user_agent','Excelen/PHPExcel'));
        $this->load->helper('mysqli');
        if (!$this->session->userdata('userid_1')) {
            redirect('login');
        }
    }

    public function index() {

        $data['SupplierID'] = $this->M_Aged_Payable_Summary->get_supplier();
        $data['CurrencyID'] = $this->M_Aged_Payable_Summary->get_currency();

        $this->template->display('accounting/aged_payable_summary', $data);
    }

    function search() {
        $sup = $this->input->get('supplier');
        $periode = date('Y-m-d', strtotime($this->input->get('period')));
        // $sampai = $this->input->get('sampai') . "-" . date("d");
        $curreny = $this->input->get('currency');

       

        $data['SupplierID'] = $this->M_Aged_Payable_Summary->get_supplier();
        $data['GroupSupplierID'] = $this->M_Aged_Payable_Summary->get_group_supp($periode, $sup,$curreny);
        $data['CurrencyID'] = $this->M_Aged_Payable_Summary->get_currency();
        $data['Get_aging']  = $this->M_Aged_Payable_Summary->call_data($sup, $curreny, $periode);
       


        $this->template->display('accounting/aged_payable_summary', $data);
    }

    function print_report() {
        $sup = $this->input->get('supplier');
        $periode = date('Y-m-d', strtotime($this->input->get('period')));
        $currency = $this->input->get('currency');

        $curTemp = $currency;

        // if ($curTemp == ''){
        //     $curTemp = 'USD';
        // }
        $data['periode'] = $periode;
        $data['cur'] = $curTemp;
        $data['GroupSupplierID'] = $this->M_Aged_Payable_Summary->get_group_supp($periode, $sup, $curTemp);
        $data['get_data_detail'] = $this->M_Aged_Payable_Summary->call_data($sup, $currency, $periode);
        
        $this->load->view('accounting/rpt/rpt_aged_payable_summary', $data);
    }

}
