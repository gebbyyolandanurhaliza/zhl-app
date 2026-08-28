
<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Trial_balance extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model(array('M_Trial_balance'));


        $this->load->library(array('user_agent', 'Template'));
        $this->load->helper('mysqli');
        if (!$this->session->userdata('userid_1')) {
            redirect('login');
        }
    }

    public function index() {

        $data['coa_number'] = $this->M_Trial_balance->coa_number();
        $data['CurrencyID'] = $this->M_Trial_balance->get_currency();

        $this->template->display('accounting/Trial_balance', $data);
    }

    function search() {
        $company   = strtoupper($this->session->userdata('company_id'));
        $coa1       = $this->input->get('coa1');
        $coa2       = $this->input->get('coa2');
        $p_dari     = $this->input->get('dari');
        $p_sampai   = $this->input->get('sampai');
	    $p_type     = $this->input->get('type');
        $companyid = $this->session->userdata('company_id');
        $currency           = $this->input->get('type');
        $data["coa1"]   = $this->input->get('coa1');
        $data["coa2"]   = $this->input->get('coa2');
        $data["GroupCOA"]   = $this->M_Trial_balance->select_group();
        $data['coa_number'] = $this->M_Trial_balance->coa_number();
        $data['CurrencyID'] = $this->M_Trial_balance->get_currency();
        if ($companyid == 2) {
            if ($currency=='USD') {
                $data['get_invoice'] = $this->M_Trial_balance->call_data_zht($p_dari, $p_sampai);
            }else{
                $data['get_invoice'] = $this->M_Trial_balance->call_data_zht_sgd($p_dari, $p_sampai);
            }
        }else{
            if (date('Y', strtotime($p_dari)) > 2024) {
                $data['get_invoice'] = $this->M_Trial_balance->call_data_baruuuuuuuuuuuuuuuu($p_dari, $p_sampai);
            } else {
                $data['get_invoice'] = $this->M_Trial_balance->call_data($p_dari, $p_sampai);
            }
        }

        $this->template->display('accounting/Trial_balance', $data);
    }

    function print_trial_balance() {
        $p_dari     = $this->input->get('dari');
	    $p_sampai   = $this->input->get('sampai');
        $companyid = $this->session->userdata('company_id');
        $currency           = $this->input->get('type');
        $data["coa1"]   = $this->input->get('coa1');
        $data["coa2"]   = $this->input->get('coa2');
        $data["GroupCOA"]   = $this->M_Trial_balance->select_group();
        $data['coa_number'] = $this->M_Trial_balance->coa_number();
        $data['CurrencyID'] = $this->M_Trial_balance->get_currency();

        if ($companyid == 2) {
            if ($currency=='USD') {
                $data['get_data_detail'] = $this->M_Trial_balance->call_data_zht($p_dari, $p_sampai);
            }else{
                $data['get_data_detail'] = $this->M_Trial_balance->call_data_zht_sgd($p_dari, $p_sampai);
            }
        }else{
            if (date('Y', strtotime($p_dari)) > 2024) {
                $data['get_data_detail'] = $this->M_Trial_balance->call_data_baruuuuuuuuuuuuuuuu($p_dari, $p_sampai);
            } else {
                $data['get_data_detail'] = $this->M_Trial_balance->call_data($p_dari, $p_sampai);
            }
        }

        $this->load->view('accounting/rpt/rpt_trial_balance', $data);
    }

}
