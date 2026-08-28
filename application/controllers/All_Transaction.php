<?php

defined('BASEPATH') or exit('No direct script access allowed');

class All_Transaction extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model(array('M_All_Transaction'));

        if (!$this->session->userdata('userid_1')) {
            redirect('login');
        }
    }

    function index()
    {
        $data['jenis_trans'] = $this->M_All_Transaction->get_jenis_trans();
        $data['jenis_coa']   = $this->M_All_Transaction->get_coa();
        $this->template->display('accounting/All_transaction_form', $data);
    }

    function search()
    {
        //jenis_trans=&noreference=&jenis_coa=
        //($dari, $sampai, $coa, $reference, $jenis)
        $dari        = $this->input->get('dari');
        $sampai      = $this->input->get('sampai');
        $jenis_trans = $this->input->get('jenis_trans');
        $noreference = $this->input->get('noreference');
        $jenis_coa   = $this->input->get('jenis_coa');
        // echo $jenis_trans.'<br>'.$noreference.'<br>'.$jenis_coa;
        $data['jenis_trans'] = $this->M_All_Transaction->get_jenis_trans();
        $data['jenis_coa'] = $this->M_All_Transaction->get_coa();
        $data['Get_supplier'] = $this->M_All_Transaction->hasil_vendor($dari, $sampai, $jenis_trans);
        $data['_tampil_item'] = $this->M_All_Transaction->hasil($dari, $sampai, $jenis_trans);
        $this->template->display('accounting/All_transaction_form', $data);
    }

    function print_report()
    {
        $dari = $this->input->get('dari');
        $sampai = $this->input->get('sampai');
        $jenis_trans = $this->input->get('jenis_trans');

        $data['dari'] = $dari;
        $data['sampai'] = $sampai;
        $data['jenis_trans'] = $jenis_trans;
        $data['Get_supplier'] = $this->M_All_Transaction->hasil_vendor($dari, $sampai, $jenis_trans);
        $data['_tampil_item'] = $this->M_All_Transaction->hasil($dari, $sampai, $jenis_trans);
        $this->load->view('accounting/rpt/rpt_all_transaction', $data);
    }
}
