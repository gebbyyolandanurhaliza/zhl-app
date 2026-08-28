    <?php
    //update date : 28 November
    defined('BASEPATH') or exit('No direct script access allowed');

    class General_ledger_dtl extends CI_Controller
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
            $company   = strtoupper($this->session->userdata('company_id'));
            $data['jenis_trans'] = $this->M_General_Ledger->get_jenis_trans();
            $data['jenis_coa'] = $this->M_General_Ledger->get_coa();
            $data['CurrencyID'] = $this->M_General_Ledger->get_currency();
            $data['new_coa'] = $this->M_General_Ledger->get_coa_new($company);
            //$this->template->display('accounting/Laporan/General_ledger_detail_dtl', $data);
            $this->template->display('accounting/Laporan/GeneralLedgerdtl_new', $data);
        }

        function search()
        {
            //jenis_trans=&noreference=&jenis_coa=
            //($dari, $sampai, $coa, $reference, $jenis)
            $company   = strtoupper($this->session->userdata('company_id'));
            $dari = str_replace('/', '-', $this->input->get('dari'));
            $p_dari = date('Y-m-d', strtotime($dari));

            $sampai = str_replace('/', '-', $this->input->get("sampai"));
            $p_sampai = date('Y-m-d', strtotime($sampai));

            $coa = $this->input->get("jenis_coa");
            $coa_new = $this->input->get("new_coa");


            //$data['jenis_trans'] = $this->M_General_Ledger->get_jenis_trans();
            $data['jenis_coa'] = $this->M_General_Ledger->get_coa();
            $data['new_coa'] = $this->M_General_Ledger->get_coa_new($company);
            //$data['CurrencyID'] = $this->M_General_Ledger->get_currency();
            
            $status = $this->input->get("check_coa");
            if($status == 1){
                $data['detail_trans'] = $this->M_General_Ledger->call_gl_all_detail_new($p_dari, $p_sampai, $coa_new);
            } else {
                $data['detail_trans'] = $this->M_General_Ledger->call_gl_all_detail($p_dari, $p_sampai, $coa);
            }
            //$data['akun_gl'] = $this->M_General_Ledger->call_account_gl();
            $this->template->display('accounting/Laporan/General_ledger_detail_dtl', $data);
        }

        function search_new()
        {
            $company   = strtoupper($this->session->userdata('company_id'));
            $dari = str_replace('/', '-', $this->input->get('dari'));
            $p_dari = date('Y-m-d', strtotime($dari));

            $sampai = str_replace('/', '-', $this->input->get("sampai"));
            $p_sampai = date('Y-m-d', strtotime($sampai));

            $coa = $this->input->get("jenis_coa");
            $coa2 = $this->input->get("jenis_coa_2");
            $coa_new = $this->input->get("new_coa");
            $coa_new2 = $this->input->get("new_coa_2");
            $status = $this->input->get("check_coa");
            
            // var_dump($coa_new);
            // die;
            if($status == 1){
                $data['detail_trans'] = $this->M_General_Ledger->call_gl_all_detail_2_new($p_dari, $p_sampai, $coa_new, $coa_new2,$company);
            } else {
                $data['detail_trans'] = $this->M_General_Ledger->call_gl_all_detail_2($p_dari, $p_sampai, $coa, $coa2);
            }

            //$data['jenis_trans'] = $this->M_General_Ledger->get_jenis_trans();
            $data['jenis_coa'] = $this->M_General_Ledger->get_coa();
            $data['new_coa'] = $this->M_General_Ledger->get_coa_new($company);
            //$data['CurrencyID'] = $this->M_General_Ledger->get_currency();
            // $data['detail_trans'] = $this->M_General_Ledger->call_gl_all_detail($p_dari, $p_sampai, $coa);
            
            //$data['akun_gl'] = $this->M_General_Ledger->call_account_gl();
            $this->template->display('accounting/Laporan/GeneralLedgerdtl_new', $data);
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


            $data['jenis_trans'] = $this->M_General_Ledger->get_jenis_trans();
            $data['jenis_coa'] = $this->M_General_Ledger->get_coa();

            $data['CurrencyID'] = $this->M_General_Ledger->get_currency();
            $data['akun_gl'] = $this->M_General_Ledger->call_account_gl();

            $data['detail_trans'] = $this->M_General_Ledger->get_detail_gl($p_dari, $p_sampai, $coa);

            $data['detail_transs'] = $this->M_General_Ledger->get_detail_gl($p_dari, $p_sampai, $coa);
            $get_coa = $this->M_General_Ledger->get_coa2($coa);
            $detail_trans = $this->M_General_Ledger->call_gl_all_detail($p_dari, $p_sampai, $coa, $coa2);
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

            $this->load->view('accounting/rpt/rpt_detail_general_ledger_ALL', $data);
        }

        function print_reportpdf()
        {
            $this->load->library(array('fpdf'));
            $company   = strtoupper($this->session->userdata('company_id'));
            $dari = str_replace('/', '-', $this->input->get('dari'));
            $p_dari = date('Y-m-d', strtotime($dari));

            $sampai = str_replace('/', '-', $this->input->get("sampai"));
            $p_sampai = date('Y-m-d', strtotime($sampai));

            $coa = $this->input->get("jenis_coa");
            $coa2 = $this->input->get("jenis_coa_2");
            $coa_new = $this->input->get("new_coa");
            $coa_new2 = $this->input->get("new_coa_2");
            $status = $this->input->get("check_coa");

            $data['jenis_trans'] = $this->M_General_Ledger->get_jenis_trans();

            

            $data['jenis_coa'] = $this->M_General_Ledger->get_coa();
            $data['new_coa'] = $this->M_General_Ledger->get_coa_new($company);

            $data['CurrencyID'] = $this->M_General_Ledger->get_currency();
            $data['akun_gl'] = $this->M_General_Ledger->call_account_gl();

            // $data['detail_trans'] = $this->M_General_Ledger->call_gl_all_detail_2($p_dari, $p_sampai, $coa, $coa2);

            $data['detail_transs'] = $this->M_General_Ledger->call_gl_all_detail_2($p_dari, $p_sampai, $coa, $coa2);
            $get_coa = $this->M_General_Ledger->get_coa2($coa);
            if($status == 1){
                $detail_trans = $this->M_General_Ledger->call_gl_all_detail_2_new($p_dari, $p_sampai, $coa_new, $coa_new2);
            } else {
                $detail_trans = $this->M_General_Ledger->call_gl_all_detail_2($p_dari, $p_sampai, $coa, $coa2);
            }
            // $detail_trans = $this->M_General_Ledger->call_gl_all_detail_2($p_dari, $p_sampai, $coa, $coa2);
            $tes = json_encode($get_coa);


            $name_coa = array(
                'string' => $get_coa
            );
            $data = array(
                '_dataHeader' => $name_coa,
                '_dataContent' => $detail_trans
            );
            $this->load->view('accounting/rpt/rpt_detail_general_ledger_ALL', $data);
        }
    }
