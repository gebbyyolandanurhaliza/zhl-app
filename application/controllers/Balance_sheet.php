
<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Balance_sheet extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model(array('M_Balance_sheet'));
        $this->load->library(array('user_agent', 'Template'));
        $this->load->helper('mysqli');
        if (!$this->session->userdata('userid_1')) {
            redirect('login');
        }
    }

    public function index() {

        $companyid = $this->session->userdata('company_id');
        $data['CurrencyID'] = $this->M_Balance_sheet->get_currency();

        if ($companyid == 2) {
            $data['coa_number'] = $this->M_Balance_sheet->coa_number_zht();
        } else {
            $data['coa_number'] = $this->M_Balance_sheet->coa_number();
        }

        $this->template->display('accounting/Laporan/Balance_sheet_model1', $data);
    }

    function search() {
        
        $companyid = $this->session->userdata('company_id');
        $data['companyid'] = $companyid;
        $dari = $this->input->get('dari');
        $p_dari = date('Y-m-d', strtotime($dari));

        $sampai = $this->input->get("sampai");
        $p_sampai = date('Y-m-d', strtotime($sampai));
        $year = date('Y', strtotime($sampai));

        $data["p_dari"] = $p_dari;
        $data["p_sampai"] = $p_sampai;
        $data["year"] = $year;

        if ($companyid == 2) {
            $data['_balance'] = $this->M_Balance_sheet->getdata_zht($p_sampai);
            // $data["GroupCOA"] = $this->M_Balance_sheet->select_group_zht();
            // $data['get_profit'] = $this->M_Balance_sheet->call_data_zht($p_dari, $p_sampai);
        } else {
            if ($year >=2025) {
                $data['_balance'] = $this->M_Balance_sheet->getdata_2025($p_sampai);
            }else{
                $data['_balance'] = $this->M_Balance_sheet->getdata($p_sampai);
            }
            
        }

        // $data["GroupCOA"] = $this->M_Balance_sheet->select_group();
        // $data['get_profit'] = $this->M_Balance_sheet->call_data($p_dari, $p_sampai);
        // $data["_balance"] = $this->M_Balance_sheet->getdata($p_sampai);

        // $this->template->display('accounting/Laporan/Balance_sheet_model1', $data);
        $this->template->display('accounting/Laporan/Balance_sheet_zhl', $data);
    }

    function print_report() {
        $companyid = $this->session->userdata('company_id');
        $dari = $this->input->get('dari');
        $p_dari = date('Y-m-d', strtotime($dari));
        $p_dari2['dari'] = date('Y-m-d', strtotime($dari));

        $sampai = $this->input->get("sampai");
        $p_sampai = date('Y-m-d', strtotime($sampai));
        $p_sampai2['sampai'] = date('Y-m-d', strtotime($sampai));

        $data["p_dari"] = $p_dari;
        $data["p_sampai"] = $p_sampai;
        
        if($companyid == 2) {
            $data['_balance'] = $this->M_Balance_sheet->getdata_zht($p_sampai);
            $this->load->view('accounting/rpt/rpt_balance_sheet_zht', $data);
        } else {
            $data["GroupCOA"] = $this->M_Balance_sheet->select_group();
            $data['get_profit'] = $this->M_Balance_sheet->call_data($p_dari, $p_sampai);
            $data['get_data'] = $this->M_Balance_sheet->call_data2($p_dari, $p_sampai);
            $data['get_data2'] = $this->M_Balance_sheet->call_data3($p_dari, $p_sampai);
            $this->load->view('accounting/rpt/rpt_balance_sheet', $data);
        }

            
    }

    function search_detail() {
        $dari = $this->input->get('dari');
        $p_dari = date('Y-m-d', strtotime($dari));

        $sampai = $this->input->get("sampai");
        $p_sampai = date('Y-m-d', strtotime($sampai));

        $data["p_dari"] = $p_dari;
        $data["p_sampai"] = $p_sampai;

        // $data["GroupCOA"] = $this->M_Balance_sheet->select_group();
        $data['data_balance'] = $this->M_Balance_sheet->call_data_detail($p_dari, $p_sampai);

        $this->template->display('accounting/Laporan/Balance_sheet_model2', $data);
    }

    function print_report_detail() {
        $dari = $this->input->get('dari');
        $p_dari = date('Y-m-d', strtotime($dari));
        $p_dari2['dari'] = date('Y-m-d', strtotime($dari));

        $sampai = $this->input->get("sampai");
        $p_sampai = date('Y-m-d', strtotime($sampai));
        $p_sampai2['sampai'] = date('Y-m-d', strtotime($sampai));

        $data["p_dari"] = $p_dari;
        $data["p_sampai"] = $p_sampai;

        // $data["GroupCOA"] = $this->M_Balance_sheet->select_group();
        // $data['get_profit'] = $this->M_Balance_sheet->call_data($p_dari, $p_sampai);
        // $data['get_data'] = $this->M_Balance_sheet->call_data2($p_dari, $p_sampai);
        // $data['get_data2'] = $this->M_Balance_sheet->call_data3($p_dari, $p_sampai);
        $data['data_balance'] = $this->M_Balance_sheet->call_data_detail($p_dari, $p_sampai);
        
        $this->load->view('accounting/rpt/rpt_balance_sheet_detail', $data);
    }

}
