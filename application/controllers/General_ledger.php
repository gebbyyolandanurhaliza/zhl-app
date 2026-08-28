<?php
//update date : 28 November
defined('BASEPATH') OR exit('No direct script access allowed');

class General_ledger extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model(array('M_General_Ledger'));

        if (!$this->session->userdata('userid_1')) {
            redirect('login');
        }
    }

    function index() {
        $company   = strtoupper($this->session->userdata('company_id'));
        $data['jenis_trans'] = $this->M_General_Ledger->get_jenis_trans();
        $data['jenis_coa'] = $this->M_General_Ledger->get_coa();
        $data['new_coa'] = $this->M_General_Ledger->get_coa_new($company);
        // echo "<pre>";
        // print_r($data['new_coa']);
        // echo "</pre>";
        // die;
        $data['CurrencyID'] = $this->M_General_Ledger->get_currency();
        $this->template->display('accounting/Laporan/General_ledger', $data);
    }

    function search() {
        $company   = strtoupper($this->session->userdata('company_id'));
        $dari = str_replace('/', '-', $this->input->get('dari'));
        $p_dari = date('Y-m-d', strtotime($dari));

        $sampai = str_replace('/', '-', $this->input->get("sampai"));
        $p_sampai = date('Y-m-d', strtotime($sampai));

        $status = $this->input->get("check_coa");
        $coa = $this->input->get("jenis_coa");
        $coa_new = $this->input->get("new_coa");

        $data['jenis_trans'] = $this->M_General_Ledger->get_jenis_trans();
        $data['jenis_coa'] = $this->M_General_Ledger->get_coa();
        $data['new_coa'] = $this->M_General_Ledger->get_coa_new($company);
        $data['CurrencyID'] = $this->M_General_Ledger->get_currency();

        if($status == 1){
            $noCOA = explode('-', $coa_new)[0];
            $dept = explode('-', $coa_new)[1];
            $data['_tampil_item'] = $this->M_General_Ledger->call_gl_summary_new($p_dari, $p_sampai, $noCOA, $dept);
        } else {
            $data['_tampil_item'] = $this->M_General_Ledger->call_gl_summary($p_dari, $p_sampai, $coa);
        }
        // echo "<pre>";
        // print_r($data['_tampil_item']);
        // echo "</pre>";
        // die;
        $data['akun_gl'] = $this->M_General_Ledger->call_account_gl();
        $this->template->display('accounting/Laporan/General_ledger', $data);
    }

    function detail_transaction() {
        $company   = strtoupper($this->session->userdata('company_id'));
        $dari = str_replace('/', '-', $this->input->get('dari'));
        $p_dari = date('Y-m-d', strtotime($dari));

        $sampai = str_replace('/', '-', $this->input->get("sampai"));
        $p_sampai = date('Y-m-d', strtotime($sampai));

        $coa = $this->input->get("jenis_coa");
        $coa_new = $this->input->get("new_coa");
        // echo "<pre>";
        // print_r($coa_new);
        // print_r($dept);
        // echo "</pre>";
        // die;

        $data['jenis_trans'] = $this->M_General_Ledger->get_jenis_trans();
        $data['jenis_coa'] = $this->M_General_Ledger->get_coa();
        $data['new_coa'] = $this->M_General_Ledger->get_coa_new($company);
        
        $data['CurrencyID'] = $this->M_General_Ledger->get_currency();
        $data['akun_gl'] = $this->M_General_Ledger->call_account_gl();
        $status = $this->input->get("check_coa");

        if($status == 1){
            $noCOA = explode('-', $coa_new)[0];
            $dept = explode('-', $coa_new)[1];
            // var_dump($noCOA . $dept);
            // die;
            $data['detail_trans'] = $this->M_General_Ledger->get_detail_gl_new($p_dari, $p_sampai, $noCOA, $dept);
        } else {
            $data['detail_trans'] = $this->M_General_Ledger->get_detail_gl($p_dari, $p_sampai, $coa);
        }
        // echo "<pre>";
        // print_r($data['detail_trans']);
        // echo "</pre>";
        // die;

        $this->template->display('accounting/Laporan/detail_general_ledger', $data);
    }

    function search_detail(){
        $dari = str_replace('/', '-', $this->input->get('dari'));
        $p_dari = date('Y-m-d', strtotime($dari));

        $sampai = str_replace('/', '-', $this->input->get("sampai"));
        $p_sampai = date('Y-m-d', strtotime($sampai));


        $data['jenis_trans'] = $this->M_General_Ledger->get_jenis_trans();
        $data['jenis_coa'] = $this->M_General_Ledger->get_coa();
        $data['CurrencyID'] = $this->M_General_Ledger->get_currency();
        $data['_tampil_item'] = $this->M_General_Ledger->call_gl_detail($p_dari, $p_sampai);
        $data['nojurnal'] = $this->M_General_Ledger->pilih_jurnal($p_dari, $p_sampai);
        $data['akun_gl'] = $this->M_General_Ledger->call_account_gl();
        $this->template->display('accounting/Laporan/General_ledger_detail', $data);
    }

    function print_report(){
        $this->load->library(array('fpdf'));
        $company   = strtoupper($this->session->userdata('company_id'));
        $dari = str_replace('/', '-', $this->input->get('dari'));
        $p_dari = date('Y-m-d', strtotime($dari));

        $sampai = str_replace('/', '-', $this->input->get("sampai"));
        $p_sampai = date('Y-m-d', strtotime($sampai));

        
        $check_coa = $this->input->get("check_coa");
        $coa = $this->input->get("no_coa");
        $dept_code = $this->input->get("dept_code");
        $parts = explode("-", $coa);

        $part1 = isset($parts[0]) ? $parts[0] : ''; 
        $part2 = isset($parts[1]) ? $parts[1] : '';


        /*$data['jenis_trans'] = $this->M_General_Ledger->get_jenis_trans();
        $data['jenis_coa'] = $this->M_General_Ledger->get_coa();

        $data['CurrencyID'] = $this->M_General_Ledger->get_currency();
        $data['akun_gl'] = $this->M_General_Ledger->call_account_gl();
       
        $data['detail_trans'] = $this->M_General_Ledger->get_detail_gl($p_dari, $p_sampai, $coa);
        */
        //$data['detail_transs'] = $this->M_General_Ledger->get_detail_gl($p_dari, $p_sampai, $coa);
        $get_coa =$this->M_General_Ledger->get_coa2($coa);
        // $detail_trans = $this->M_General_Ledger->get_detail_gl($p_dari, $p_sampai, $coa);
        if($check_coa == 1){
            $detail_trans = $this->M_General_Ledger->get_detail_gl_new($p_dari, $p_sampai, $part1, $part2);
        } else {
            $detail_trans = $this->M_General_Ledger->get_detail_gl($p_dari, $p_sampai, $coa);
        }

        $noCOA = $coa.'-001';


        $name_coa = array(
            'string' => $get_coa
        );
        $data=array(
            'noCOA' => $noCOA,
            '_dataHeader'=> $name_coa,
            '_dataContent'=>$detail_trans
        );
        $this->load->view('accounting/rpt/rpt_detail_general_ledger', $data);
    }

}