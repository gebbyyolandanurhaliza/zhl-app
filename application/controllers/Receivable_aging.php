
<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Receivable_aging extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model(array('M_Receivable_aging'));
        $this->load->library(array('user_agent'));

        if (!$this->session->userdata('userid_1')) {
            redirect('login');
        }
    }

    public function index()
    {
        $companyid = $this->session->userdata('company_id');

        if ($companyid == 2) {
            $data['SupplierID'] = $this->M_Receivable_aging->get_customer_zht();
        }else{
            $data['SupplierID'] = $this->M_Receivable_aging->get_customer();
        }
        
        $data['CurrencyID'] = $this->M_Receivable_aging->get_currency();


        $this->template->display('accounting/Laporan/Receivable_aging', $data);
    }

    function search()
    {
        $sup = $this->input->get('supplier');
        $curreny = $this->input->get('currency');

        $period = str_replace('-', '-', $this->input->get('period'));
        $periode = date('Y-m-d', strtotime($period));

        $companyid = $this->session->userdata('company_id');

        if ($companyid == 2) {
            $data['SupplierID'] = $this->M_Receivable_aging->get_customer_zht();
            $data['Get_aging']       = $this->M_Receivable_aging->call_data_zht($sup, $curreny, $periode);
            $data['GroupSupplierID'] = $this->M_Receivable_aging->get_group_supp_zht($periode, $sup, $curreny);
        }else{
            $data['SupplierID'] = $this->M_Receivable_aging->get_customer();
            $data['Get_aging']       = $this->M_Receivable_aging->call_data($sup, $curreny, $periode);
            $data['GroupSupplierID'] = $this->M_Receivable_aging->get_group_supp($periode, $sup, $curreny);
        }

        
        $data['CurrencyID']      = $this->M_Receivable_aging->get_currency();
        

        $this->template->display('accounting/Laporan/Receivable_aging', $data);
    }

    function print_report()
    {
        $sup = $this->input->get('supplier');
        $curreny = $this->input->get('currency');

        $period = str_replace('-', '-', $this->input->get('period'));
        $periode = date('Y-m-d', strtotime($period));
        $companyid = $this->session->userdata('company_id');

        $data['periode']            = $periode;
        if ($companyid == 2) {
            $data['SupplierID'] = $this->M_Receivable_aging->get_customer_zht();
            $data['get_data']       = $this->M_Receivable_aging->call_data_zht($sup, $curreny, $periode);
            $data['GroupSupplierID'] = $this->M_Receivable_aging->get_group_supp_zht($periode, $sup, $curreny);
        }else{
            $data['SupplierID'] = $this->M_Receivable_aging->get_customer();
            $data['get_data']       = $this->M_Receivable_aging->call_data($sup, $curreny, $periode);
            $data['GroupSupplierID'] = $this->M_Receivable_aging->get_group_supp($periode, $sup, $curreny);
        }

        $this->load->view('accounting/rpt/rpt_receivable_aging', $data);
    }
}
