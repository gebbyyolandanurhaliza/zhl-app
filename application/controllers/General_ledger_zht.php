<?php
//update date : 28 November
defined('BASEPATH') OR exit('No direct script access allowed');

class General_ledger_zht extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model(array('M_General_Ledger_zht'));

        if (!$this->session->userdata('userid_1')) {
            redirect('login');
        }
    }

    function index() {
        $company   = strtoupper($this->session->userdata('company_id'));
        $data['jenis_trans'] = $this->M_General_Ledger_zht->get_jenis_trans();
        $data['CurrencyID'] = $this->M_General_Ledger_zht->get_currency();
        $data['new_coa'] = $this->M_General_Ledger_zht->get_coa_new();
        $this->template->display('accounting/Laporan/zht_general_ledger/General_ledger_zht', $data);
    }

    function search() {
       $company   = strtoupper($this->session->userdata('company_id'));
        $dari = str_replace('/', '-', $this->input->get('dari'));
        $p_dari = date('Y-m-d', strtotime($dari));

        $sampai = str_replace('/', '-', $this->input->get("sampai"));
        $p_sampai = date('Y-m-d', strtotime($sampai));
        $coa_new = $this->input->get("new_coa");


        $data['jenis_trans'] = $this->M_General_Ledger_zht->get_jenis_trans();
        $data['CurrencyID'] = $this->M_General_Ledger_zht->get_currency();
        
        $noCOA = explode('-', $coa_new)[0];
        $dept = explode('-', $coa_new)[1];

        $data['new_coa'] = $this->M_General_Ledger_zht->get_coa_new();

        $data['_tampil_item'] = $this->M_General_Ledger_zht->call_gl_summary($p_dari, $p_sampai, $noCOA, $dept);
        $data['akun_gl'] = $this->M_General_Ledger_zht->call_account_gl();
        $this->template->display('accounting/Laporan/zht_general_ledger/General_ledger_zht', $data);
    }

    function detail_transaction() {
        $company   = strtoupper($this->session->userdata('company_id'));
        $dari = str_replace('/', '-', $this->input->get('dari'));
        $p_dari = date('Y-m-d', strtotime($dari));

        $sampai = str_replace('/', '-', $this->input->get("sampai"));
        $p_sampai = date('Y-m-d', strtotime($sampai));

        $coa_new = $this->input->get("new_coa");


        $data['jenis_trans'] = $this->M_General_Ledger_zht->get_jenis_trans();
        $data['new_coa'] = $this->M_General_Ledger_zht->get_coa_new();
        $data['CurrencyID'] = $this->M_General_Ledger_zht->get_currency();
        $data['akun_gl'] = $this->M_General_Ledger_zht->call_account_gl();

        $noCOA = explode('-', $coa_new)[0];
        $dept = explode('-', $coa_new)[1];
        $data['detail_trans'] = $this->M_General_Ledger_zht->get_detail_gl($p_dari, $p_sampai, $noCOA, $dept);
        $this->template->display('accounting/Laporan/zht_general_ledger/detail_general_ledger_zht', $data);
    }

    function search_detail(){
        $dari = str_replace('/', '-', $this->input->get('dari'));
        $p_dari = date('Y-m-d', strtotime($dari));

        $sampai = str_replace('/', '-', $this->input->get("sampai"));
        $p_sampai = date('Y-m-d', strtotime($sampai));


        $data['jenis_trans'] = $this->M_General_Ledger_zht->get_jenis_trans();
        $data['jenis_coa'] = $this->M_General_Ledger_zht->get_coa();
        $data['CurrencyID'] = $this->M_General_Ledger_zht->get_currency();
        $data['_tampil_item'] = $this->M_General_Ledger_zht->call_gl_detail($p_dari, $p_sampai);
        $data['nojurnal'] = $this->M_General_Ledger_zht->pilih_jurnal($p_dari, $p_sampai);
        $data['akun_gl'] = $this->M_General_Ledger_zht->call_account_gl();
        $this->template->display('accounting/Laporan/zht_general_ledger/General_ledger_detail', $data);
    }

    function print_report(){
         $this->load->library(array('fpdf'));
        $company   = strtoupper($this->session->userdata('company_id'));
        $dari = str_replace('/', '-', $this->input->get('dari'));
        $p_dari = date('Y-m-d', strtotime($dari));

        $sampai = str_replace('/', '-', $this->input->get("sampai"));
        $p_sampai = date('Y-m-d', strtotime($sampai));

        $coa = $this->input->get("no_coa");
        $dept_code = $this->input->get("dept_code");
        $parts = explode("-", $coa);

        $part1 = isset($parts[0]) ? $parts[0] : ''; 
        $part2 = isset($parts[1]) ? $parts[1] : '';

        /*$data['jenis_trans'] = $this->M_General_Ledger_zht->get_jenis_trans();
        $data['jenis_coa'] = $this->M_General_Ledger_zht->get_coa();

        $data['CurrencyID'] = $this->M_General_Ledger_zht->get_currency();
        $data['akun_gl'] = $this->M_General_Ledger_zht->call_account_gl();
       
        $data['detail_trans'] = $this->M_General_Ledger_zht->get_detail_gl($p_dari, $p_sampai, $coa);
        */
        //$data['detail_transs'] = $this->M_General_Ledger_zht->get_detail_gl($p_dari, $p_sampai, $coa);
        $get_coa =$this->M_General_Ledger_zht->get_coa2($coa);
        $detail_trans = $this->M_General_Ledger_zht->get_detail_gl($p_dari, $p_sampai, $part1, $part2);
        $tes=json_encode($get_coa);


        $name_coa = array(
            'string' => $get_coa
        );
        $data=array(
            '_dataHeader'=> $name_coa,
            '_dataContent'=>$detail_trans
        );

        $this->load->view('accounting/rpt/rpt_detail_general_ledger_zht', $data);
    }

    public function get_total_gst($dari, $sampai) {
    $this->db->select('IFNULL(SUM(gst_value), 0) AS total_gst');
    $this->db->from('zht_acc_tbl_trn_jurnal_tims');
    $this->db->where("tanggal >=", $dari);
    $this->db->where("tanggal <=", $sampai);
    $query = $this->db->get();
    $row = $query->row();
    return $row->total_gst;
}


}