<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class All_Transaction_Receivable extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model(array('M_All_Transaction_rec'));

        if (!$this->session->userdata('userid_1')) {
            redirect('login');
        }
    }

    function index() {
        $company_id = $this->session->userdata('company_id');
        $data['jenis_trans'] = $this->M_All_Transaction_rec->get_jenis_trans();
        $data['jenis_coa'] = $this->M_All_Transaction_rec->get_coa($company_id);
        $this->template->display('accounting/All_transaction_form_rec', $data);

        
    }

    // function search() {
    //     $dari = $this->input->get('dari');
    //     $sampai = $this->input->get('sampai');
    //     $jenis_trans = $this->input->get('jenis_trans');
    //     $noreference = $this->input->get('noreference');
    //     $jenis_coa = $this->input->get('jenis_coa');
    //     $data['jenis_trans'] = $this->M_All_Transaction_rec->get_jenis_trans();
    //     $data['jenis_coa'] = $this->M_All_Transaction_rec->get_coa();
    //     $data['Get_vendor'] = $this->M_All_Transaction_rec->hasil_vendor($dari, $sampai, $jenis_trans); // tambahan baru
    //     $data['_tampil_item'] = $this->M_All_Transaction_rec->hasil($dari, $sampai, $jenis_trans);
    //     $this->template->display('accounting/All_transaction_form_rec', $data);
    // }

    function search() {
    $company_id   = strtoupper($this->session->userdata('company_id'));
    $dari = $this->input->get('dari');
    $sampai = $this->input->get('sampai');
    $jenis_trans = $this->input->get('jenis_trans');
    $orderby = $this->input->get('orderby') ?: 'tanggal'; // default
    $orderdir = ($this->input->get('orderdir') === 'desc') ? 'desc' : 'asc';

    $data['jenis_trans'] = $this->M_All_Transaction_rec->get_jenis_trans();
    $data['jenis_coa'] = $this->M_All_Transaction_rec->get_coa($company_id);
    if($company_id == 1){
        $data['Get_vendor'] = $this->M_All_Transaction_rec->hasil_vendor($dari, $sampai, $jenis_trans);
        $data['_tampil_item'] = $this->M_All_Transaction_rec->hasil($dari, $sampai, $jenis_trans, $orderby, $orderdir);
    }else{
        $data['Get_vendor'] = $this->M_All_Transaction_rec->hasil_vendor_zht($dari, $sampai, $jenis_trans);
        $data['_tampil_item'] = $this->M_All_Transaction_rec->hasil_zht($dari, $sampai, $jenis_trans, $orderby, $orderdir);
    }
    $this->template->display('accounting/All_transaction_form_rec', $data);
}

    function print_report() {
        $dari = $this->input->get('dari');
        $sampai = $this->input->get('sampai');
        $jenis_trans = $this->input->get('jenis_trans');

        $data['dari'] = $dari;
        $data['sampai'] = $sampai;
        $data['jenis_trans'] = $jenis_trans;
        $data['Get_vendor'] = $this->M_All_Transaction_rec->hasil_vendor($dari, $sampai, $jenis_trans);
        $data['_tampil_item'] = $this->M_All_Transaction_rec->hasil($dari, $sampai, $jenis_trans);
        $this->load->view('accounting/rpt/rpt_all_transaction_receivable', $data);
    }

}

?>