<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Bl_code_ZHL extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model(array('M_Bl_code_ZHL'));

        if (!$this->session->userdata('userid_1')) {
            redirect('login');
        }
    }

    function index() {
        $company_id = $this->session->userdata('company_id');
        $data['jenis_trans'] = $this->M_Bl_code_ZHL->get_jenis_trans();
        $data['jenis_coa'] = $this->M_Bl_code_ZHL->get_coa($company_id);
        $data['dept_code'] = $this->M_Bl_code_ZHL->getDeptCodes();
        $this->template->display('accounting/vcdn/Bl_code_ZHL', $data);
       
    }
function search() {
    $dari = $this->input->get('dari');
    $sampai = $this->input->get('sampai');
    $dept_code = $this->input->get('dept_code');
    $data['dept_code'] = $dept_code;
    $data['_tampil_item'] = $this->M_Bl_code_ZHL->hasil($dari, $sampai, $dept_code);

    // Tambahkan ini:
    foreach ($data['_tampil_item'] as &$item) {
        // $data['item'] = $this->M_Bl_code_ZHL->get_total_sum_amount($blCode);
    $item->total_sum_amount = $this->M_Bl_code_ZHL->get_total_sum_amount($item->blCode);
    $item->total_sum_amount_1 = $this->M_Bl_code_ZHL->get_total_sum_amount_a($item->blCode);

    }

    $this->template->display('accounting/vcdn/Bl_code_ZHL', $data);
}

    // function print_report() {
    //     $dari = $this->input->get('dari');
    //     $sampai = $this->input->get('sampai');
    //     $dept_code = $this->input->get('dept_code');

    //     $data['dari'] = $dari;
    //     $data['sampai'] = $sampai;
    //     $data['dept_code'] = $dept_code;
    //     $this->load->view('accounting/rpt/rpt_bl_code', $data);
    // }

    function print_report() {
    $dari = $this->input->get('dari');
    $sampai = $this->input->get('sampai');
    $dept_code = $this->input->get('dept_code');

    $data['dari'] = $dari;
    $data['sampai'] = $sampai;
    $data['dept_code'] = $dept_code;

    // ambil data utama
    $data['_tampil_item'] = $this->M_Bl_code_ZHL->hasil($dari, $sampai, $dept_code);

    // tambahkan total ke tiap item
    foreach ($data['_tampil_item'] as &$item) {
        $item->total_sum_amount   = $this->M_Bl_code_ZHL->get_total_sum_amount($item->blCode);
        $item->total_sum_amount_1 = $this->M_Bl_code_ZHL->get_total_sum_amount_a($item->blCode);
    }

    $this->load->view('accounting/rpt/rpt_bl_code', $data);
}


}

?>