<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Monitoring_journal extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model(array('M_Monitoring_journal'));

        if (!$this->session->userdata('userid_1')) {
            redirect('login');
        }
    }

    function index()
    {
        $data['jenis_trans'] = $this->M_Monitoring_journal->get_jenis_trans();
        $data['jenis_coa'] = $this->M_Monitoring_journal->get_coa();
        $this->template->display('accounting/Monitoring_journal', $data);
    }

    function search()
    {
        //jenis_trans=&noreference=&jenis_coa=
        //($dari, $sampai, $coa, $reference, $jenis)
        $dari = $this->input->get('dari');
        $sampai = $this->input->get('sampai');
        $jenis_trans = $this->input->get('jenis_trans');
        $noreference = $this->input->get('noreference');
        $jenis_coa = $this->input->get('jenis_coa');
        // echo $jenis_trans.'<br>'.$noreference.'<br>'.$jenis_coa;
        $data['jenis_trans'] = $this->M_Monitoring_journal->get_jenis_trans();
        $data['jenis_coa'] = $this->M_Monitoring_journal->get_coa();
        $data['_tampil_item'] = $this->M_Monitoring_journal->hasil($dari, $sampai, $jenis_coa, $noreference, $jenis_trans);
        // echo "<pre>";
        // print_r($data['_tampil_item']);
        // die;
        $this->template->display('accounting/Monitoring_journal', $data);
    }

    function print_re()
    {
        $dari = $this->input->get('dari');
        $sampai = $this->input->get('sampai');
        $jenis_trans = $this->input->get('jenis_trans');
        $noreference = $this->input->get('noreference');
        $jenis_coa = $this->input->get('jenis_coa');
        // echo $jenis_trans.'<br>'.$noreference.'<br>'.$jenis_coa;
        $data['jenis_trans'] = $this->M_Monitoring_journal->get_jenis_trans();
        $data['jenis_coa'] = $this->M_Monitoring_journal->get_coa();
        $data['tampil_item'] = $this->M_Monitoring_journal->hasil($dari, $sampai, $jenis_coa, $noreference, $jenis_trans);

        $this->load->view('accounting/rpt/rpt_monitoring_jurnal', $data);
    }
}
