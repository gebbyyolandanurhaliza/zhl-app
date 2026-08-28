<?php
//update date : 28 November
defined('BASEPATH') or exit('No direct script access allowed');

class General_ledger_detail extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model(array('M_General_Ledger'));

        if (!$this->session->userdata('userid_1')) {
            redirect('login');
        }
    }


    function index()
    {
        $data['jenis_trans'] = $this->M_General_Ledger->get_jenis_trans();
        $data['jenis_coa'] = $this->M_General_Ledger->get_coa();
        $data['CurrencyID'] = $this->M_General_Ledger->get_currency();
        $this->template->display('accounting/Laporan/General_ledger_detail', $data);
    }

    function search2()
    {
        //jenis_trans=&noreference=&jenis_coa=
        //($dari, $sampai, $coa, $reference, $jenis)
        $dari = str_replace('/', '-', $this->input->get('dari'));
        $p_dari = date('Y-m-d', strtotime($dari));

        $sampai = str_replace('/', '-', $this->input->get("sampai"));
        $p_sampai = date('Y-m-d', strtotime($sampai));

        $coa = $this->input->get("jenis_coa");


        //$data['jenis_trans'] = $this->M_General_Ledger->get_jenis_trans();
        $data['jenis_coa'] = $this->M_General_Ledger->get_coa();
        //$data['CurrencyID'] = $this->M_General_Ledger->get_currency();
        $data['detail_trans'] = $this->M_General_Ledger->call_gl_all_detail($p_dari, $p_sampai, $coa);
        
        //$data['akun_gl'] = $this->M_General_Ledger->call_account_gl();



        $this->template->display('accounting/Laporan/General_ledger_detail_dtl', $data);
    }

    function search()
    {
        //jenis_trans=&noreference=&jenis_coa=
        //($dari, $sampai, $coa, $reference, $jenis)
        $dari = str_replace('/', '-', $this->input->get('dari'));
        $p_dari = date('Y-m-d', strtotime($dari));

        $sampai = str_replace('/', '-', $this->input->get("sampai"));
        $p_sampai = date('Y-m-d', strtotime($sampai));

        $start_coa = strlen($this->input->get("jenis_coa")) != 0 ? $this->input->get("jenis_coa") : null;
        $end_coa = strlen($this->input->get("jenis_coa2")) != 0 ? $this->input->get("jenis_coa2") : null;


        //$data['jenis_trans'] = $this->M_General_Ledger->get_jenis_trans();
        $data['jenis_coa'] = $this->M_General_Ledger->get_coa();
        //$data['CurrencyID'] = $this->M_General_Ledger->get_currency();
        $data['detail_trans'] = $this->M_General_Ledger->call_gl_all_detail_dev($p_dari, $p_sampai, $start_coa, $end_coa);
 
        //$data['akun_gl'] = $this->M_General_Ledger->call_account_gl();

        $data['start_coa'] = $this->input->get("jenis_coa");
        $data['end_coa'] = $this->input->get("jenis_coa2");


        // echo "<pre>";
        // print_r($data['detail_trans']);
        // echo "</pre>";
        // die;





        $this->template->display('accounting/Laporan/General_ledger_detail_dtl', $data);
    }
    /*
    function detail_transaction() {
        $dari = str_replace('/', '-', $this->input->get('dari'));
        $p_dari = date('Y-m-d', strtotime($dari));

        $sampai = str_replace('/', '-', $this->input->get("sampai"));
        $p_sampai = date('Y-m-d', strtotime($sampai));

        $coa = $this->input->get("jenis_coa");


        $data['jenis_trans'] = $this->M_General_Ledger->get_jenis_trans();
        $data['jenis_coa'] = $this->M_General_Ledger->get_coa();
        $data['CurrencyID'] = $this->M_General_Ledger->get_currency();
        $data['akun_gl'] = $this->M_General_Ledger->call_account_gl();

        $data['detail_trans'] = $this->M_General_Ledger->get_detail_gl($p_dari, $p_sampai, $coa);
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
        $dari = str_replace('/', '-', $this->input->get('dari'));
        $p_dari = date('Y-m-d', strtotime($dari));

        $sampai = str_replace('/', '-', $this->input->get("sampai"));
        $p_sampai = date('Y-m-d', strtotime($sampai));

        $coa = $this->input->get("jenis_coa");


        $data['jenis_trans'] = $this->M_General_Ledger->get_jenis_trans();
        $data['jenis_coa'] = $this->M_General_Ledger->get_coa();

        $data['CurrencyID'] = $this->M_General_Ledger->get_currency();
        $data['akun_gl'] = $this->M_General_Ledger->call_account_gl();

        $data['detail_trans'] = $this->M_General_Ledger->get_detail_gl($p_dari, $p_sampai, $coa);

        $data['detail_transs'] = $this->M_General_Ledger->get_detail_gl($p_dari, $p_sampai, $coa);
        $get_coa =$this->M_General_Ledger->get_coa2($coa);
        $detail_trans = $this->M_General_Ledger->get_detail_gl($p_dari, $p_sampai, $coa);
$tes=json_encode($get_coa);


        $name_coa = array(
            'string' => $get_coa
        );
        $data=array(
            '_dataHeader'=> $name_coa,
            '_dataContent'=>$detail_trans
        );
        $this->load->view('accounting/rpt/rpt_detail_general_ledger', $data);
    }*/
}
