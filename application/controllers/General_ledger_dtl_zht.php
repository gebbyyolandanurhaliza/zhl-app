<?php
    //update date : 28 November
    defined('BASEPATH') or exit('No direct script access allowed');

    class General_ledger_dtl_zht extends CI_Controller
    {

        function __construct()
        {
            parent::__construct();
            $this->load->model(array('M_General_Ledger_zht'));

            if (!$this->session->userdata('userid_1')) {
                redirect('login');
            }
        }

        function index()
        {
            $data['jenis_trans'] = $this->M_General_Ledger_zht->get_jenis_trans();
            $data['jenis_coa'] = $this->M_General_Ledger_zht->get_coa();
            $data['CurrencyID'] = $this->M_General_Ledger_zht->get_currency();
            //$this->template->display('accounting/Laporan/General_ledger_detail_dtl_zht', $data);
            $this->template->display('accounting/Laporan/GeneralLedgerdtl_new_zht', $data);
        }

        function search()
        {
            //jenis_trans=&noreference=&jenis_coa=
            //($dari, $sampai, $coa, $reference, $jenis)
            $dari = str_replace('/', '-', $this->input->get('dari'));
            $p_dari = date('Y-m-d', strtotime($dari));

            $sampai = str_replace('/', '-', $this->input->get("sampai"));
            $p_sampai = date('Y-m-d', strtotime($sampai));

            $coa = $this->input->get("jenis_coa");




            //$data['jenis_trans'] = $this->M_General_Ledger_zht->get_jenis_trans();
            $data['jenis_coa'] = $this->M_General_Ledger_zht->get_coa();
            //$data['CurrencyID'] = $this->M_General_Ledger_zht->get_currency();
            $data['detail_trans'] = $this->M_General_Ledger_zht->call_gl_all_detail($p_dari, $p_sampai, $coa);
            //$data['akun_gl'] = $this->M_General_Ledger_zht->call_account_gl();
            $this->template->display('accounting/Laporan/General_ledger_detail_dtl_zht', $data);
        }

        function search_new()
        {
            //jenis_trans=&noreference=&jenis_coa=
            //($dari, $sampai, $coa, $reference, $jenis)
            $dari = str_replace('/', '-', $this->input->get('dari'));
            $p_dari = date('Y-m-d', strtotime($dari));

            $sampai = str_replace('/', '-', $this->input->get("sampai"));
            $p_sampai = date('Y-m-d', strtotime($sampai));

            $coa = $this->input->get("jenis_coa");
            $coa2 = $this->input->get("jenis_coa_2");


            //$data['jenis_trans'] = $this->M_General_Ledger_zht->get_jenis_trans();
            $data['jenis_coa'] = $this->M_General_Ledger_zht->get_coa();
            //$data['CurrencyID'] = $this->M_General_Ledger_zht->get_currency();
            // $data['detail_trans'] = $this->M_General_Ledger_zht->call_gl_all_detail($p_dari, $p_sampai, $coa);
            $data['detail_trans'] = $this->M_General_Ledger_zht->call_gl_all_detail_2($p_dari, $p_sampai, $coa, $coa2);
            //$data['akun_gl'] = $this->M_General_Ledger_zht->call_account_gl();
            $this->template->display('accounting/Laporan/GeneralLedgerdtl_new_zht', $data);
        }




        /*
    function detail_transaction() {
        $dari = str_replace('/', '-', $this->input->get('dari'));
        $p_dari = date('Y-m-d', strtotime($dari));

        $sampai = str_replace('/', '-', $this->input->get("sampai"));
        $p_sampai = date('Y-m-d', strtotime($sampai));

        $coa = $this->input->get("jenis_coa");


        $data['jenis_trans'] = $this->M_General_Ledger_zht->get_jenis_trans();
        $data['jenis_coa'] = $this->M_General_Ledger_zht->get_coa();
        $data['CurrencyID'] = $this->M_General_Ledger_zht->get_currency();
        $data['akun_gl'] = $this->M_General_Ledger_zht->call_account_gl();

        $data['detail_trans'] = $this->M_General_Ledger_zht->get_detail_gl($p_dari, $p_sampai, $coa);
        $this->template->display('accounting/Laporan/detail_general_ledger', $data);
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
        $this->template->display('accounting/Laporan/General_ledger_detail', $data);
    }

    */
        function print_report()
        {
            $this->load->library(array('fpdf'));
            $dari = str_replace('/', '-', $this->input->get('dari'));
            $p_dari = date('Y-m-d', strtotime($dari));

            $sampai = str_replace('/', '-', $this->input->get("sampai"));
            $p_sampai = date('Y-m-d', strtotime($sampai));

            $coa = $this->input->get("jenis_coa");
            $coa2 = $this->input->get("jenis_coa2");


            $data['jenis_trans'] = $this->M_General_Ledger_zht->get_jenis_trans();
            $data['jenis_coa'] = $this->M_General_Ledger_zht->get_coa();

            $data['CurrencyID'] = $this->M_General_Ledger_zht->get_currency();
            $data['akun_gl'] = $this->M_General_Ledger_zht->call_account_gl();

            $data['detail_trans'] = $this->M_General_Ledger_zht->get_detail_gl($p_dari, $p_sampai, $coa);

            $data['detail_transs'] = $this->M_General_Ledger_zht->get_detail_gl($p_dari, $p_sampai, $coa);
            $get_coa = $this->M_General_Ledger_zht->get_coa2($coa);
            $detail_trans = $this->M_General_Ledger_zht->call_gl_all_detail($p_dari, $p_sampai, $coa, $coa2);
            $tes = json_encode($get_coa);


            $name_coa = array(
                'string' => $get_coa
            );
            $data = array(
                '_dataHeader' => $name_coa,
                '_dataContent' => $detail_trans
            );


            // echo "<pre>";
            // print_r($data);
            // echo "</pre>";
            // die;

            $this->load->view('accounting/rpt/rpt_detail_general_ledger_ALL_zht', $data);
        }

        function print_reportpdf()
        {
            $this->load->library(array('fpdf'));
            $dari = str_replace('/', '-', $this->input->get('dari'));
            $p_dari = date('Y-m-d', strtotime($dari));

            $sampai = str_replace('/', '-', $this->input->get("sampai"));
            $p_sampai = date('Y-m-d', strtotime($sampai));

            $coa = $this->input->get("jenis_coa");
            $coa2 = $this->input->get("jenis_coa_2");


            $data['jenis_trans'] = $this->M_General_Ledger_zht->get_jenis_trans();
            $data['jenis_coa'] = $this->M_General_Ledger_zht->get_coa();

            $data['CurrencyID'] = $this->M_General_Ledger_zht->get_currency();
            $data['akun_gl'] = $this->M_General_Ledger_zht->call_account_gl();

            $data['detail_trans'] = $this->M_General_Ledger_zht->call_gl_all_detail_2($p_dari, $p_sampai, $coa, $coa2);

            $data['detail_transs'] = $this->M_General_Ledger_zht->call_gl_all_detail_2($p_dari, $p_sampai, $coa, $coa2);
            $get_coa = $this->M_General_Ledger_zht->get_coa2($coa);
            $detail_trans = $this->M_General_Ledger_zht->call_gl_all_detail_2($p_dari, $p_sampai, $coa, $coa2);
            $tes = json_encode($get_coa);


            $name_coa = array(
                'string' => $get_coa
            );
            $data = array(
                '_dataHeader' => $name_coa,
                '_dataContent' => $detail_trans
            );
            $this->load->view('accounting/rpt/rpt_detail_general_ledger_ALL_zht', $data);
        }
    }
