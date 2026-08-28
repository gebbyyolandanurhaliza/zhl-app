
<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Vcdn extends CI_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model(array('M_vcdn', 'M_login'));
        $this->load->library(array('template', 'user_agent', 'fpdf'));

        if (!$this->session->userdata('userid_1')) {
            redirect('login');
        }
    }

    //======== pakai ===========
    public function index() {
        $data['title'] = "List of Payable Recognition";
        $data['SupplierID'] = $this->M_vcdn->get_sup();
        $data['List_vcdn'] = $this->M_vcdn->list_vcdn();
        $this->template->display('accounting/vcdn/vcdn_list', $data);
    }

    function search() { 
        $data['SupplierID'] = $this->M_vcdn->get_sup();
        $invoice = $this->input->get("invoice");
        $dari = str_replace('/', '-', $this->input->get('dari'));
        $p_dari = date('Y-m-d', strtotime($dari));
        $sampai = str_replace('/', '-', $this->input->get("sampai"));
        $p_sampai = date('Y-m-d', strtotime($sampai));
        $supplier = $this->input->get("supplier");

        $data['List_coa'] = $this->M_vcdn->get_coa_old();
        $data['List_vcdn'] = $this->M_vcdn->list_vcdn2($invoice, $supplier, $p_dari, $p_sampai);

       // $data['List_piutang'] = $this->M_ccdn->list_piutang2($invoice, $supplier, $p_dari, $p_sampai);

       $this->template->display('accounting/vcdn/vcdn_list', $data);
    }

    function ambil_currency() {
        $kurs = $this->input->get('kurs');
        $bln = $this->input->get('bln');
        $thn = $this->input->get('thn');
        $data['currency'] = $this->M_vcdn->ambil_currency_date($kurs, $bln, $thn);
        $this->load->view('accounting/ajax/get_currency', $data);
    }

    function add_new() {
        $company   = strtoupper($this->session->userdata('company_id'));
        $data['SupplierID'] = $this->M_vcdn->get_supplier();
        $data['Currency'] = $this->M_vcdn->get_currency();
        $data['List_coa'] = $this->M_vcdn->get_coa($company);
        $data['message'] = $this->session->flashdata('message');
        $data['List_hutang'] = $this->M_vcdn->list_hutang();
        $data['Currency'] = $this->M_vcdn->get_currency();
        $data['List_piutang'] = $this->M_vcdn->list_piutang();
        $data['bank'] = $this->M_vcdn->tampil_bank();
        $close_date         = $this->M_login->ambil_tgl()->row();
        $data['closing']    = date_format(date_create($close_date->tanggal), "d/m/Y");
        $this->template->display('accounting/vcdn/vcdn_form', $data);
    }

    function edit() {
        $id = $this->input->get("id");
        // var_dump($id);
        // die;
        $company   = strtoupper($this->session->userdata('company_id'));
        $data['SupplierID'] = $this->M_vcdn->get_purchasing();
        $data['Currency'] = $this->M_vcdn->get_currency();
        // $data['List_coa'] = $this->M_vcdn->get_coa_old();
        $data['List_coa'] = $this->M_vcdn->get_coa($company);
        $data['message'] = $this->session->flashdata('message');

        //cari data nota kredit
        $data['select_vcdn'] = $this->M_vcdn->select_vcdn($id);
        $data['select_vcdn2'] = $this->M_vcdn->select_vcdn2($id);
        // echo "<pre>";
        // print_r($data['select_vcdn2']);
        // echo "</pre>";
        // die;
        $data['select_hutang'] = $this->M_vcdn->select_hutang($id);
        $data['select_bulanan'] = $this->M_vcdn->select_bulanan($id);
        $data['select_jurnal'] = $this->M_vcdn->select_jurnal($id);
        $data['select_nota'] = $this->M_vcdn->select_nota($id);
        $data['bank'] = $this->M_vcdn->tampil_bank();
        $close_date         = $this->M_login->ambil_tgl()->row();
        $data['closing']    = date_format(date_create($close_date->tanggal), "d/m/Y");
        $this->template->display('accounting/vcdn/vcdn_form', $data);
    }

    function print_vcdn() {
        $id = $this->input->get("id");
        $data['SupplierID'] = $this->M_vcdn->get_purchasing();
        $data['Currency'] = $this->M_vcdn->get_curs();
        $data['List_coa'] = $this->M_vcdn->get_coa_old();

        //cari data nota kredit
        $data['select_vcdn'] = $this->M_vcdn->select_vcdn($id);
        $data['select_hutang'] = $this->M_vcdn->select_hutang($id);
        $data['select_bulanan'] = $this->M_vcdn->select_bulanan($id);
        $data['select_jurnal'] = $this->M_vcdn->select_jurnal($id);
        $data['nota'] = $this->M_vcdn->select_nota($id);
        $this->template->display('accounting/rpt/rpt_debit_note', $data);
    }

    function hapus() {
        $id = urldecode($this->input->get('id'));
        // echo "<pre>";
        // print_r($id);
        // echo "</pre>";
        // die;
        $this->M_vcdn->delete_vcdn($id);
        $this->M_vcdn->delete_jurnal($id);
        $this->M_vcdn->delete_gst($id);
        $this->M_vcdn->delete_hutang($id);
        $this->M_vcdn->delete_hutang_bulanan($id);
        redirect('Vcdn');
    }

    function cek_tabel() {
        $id = $this->input->get("id");
        $data['select_hutang'] = $this->M_vcdn->select_hutang($id);
        $this->load->view('accounting/validasi', $data);
    }

    function list_detail() {
        $data['tabel_detail'] = $this->M_vcdn->list_jurnal($id);
        //$date['nota'] = $this->M_vcdn->nota_debet_kredit($id);

        $this->load->view('accounting/vcdn/table_list', $data);
    }

    function account_number() {
        $id = $this->input->get("id");
        $data['account_number_select'] = $this->M_vcdn->select_coa($id);
        $this->load->view('accounting/ajax/select_coa', $data);
    }

    function action() {
        //variable 
        $jenis = $this->input->post('JenisJurnal');
        $refno = $this->input->post('refno');
        
        $tgl_jurnal = str_replace('/', '-', $this->input->post('tanggal'));
        $tanggal = date('Y-m-d', strtotime($tgl_jurnal));
        $Periode = date('mY', strtotime($tgl_jurnal));

        $tanggal_invoice = str_replace('/', '-', $this->input->post('tgl_invoice'));
        $tgl_invoice = date('Y-m-d', strtotime($tgl_jurnal));


        $invoice_number = $this->input->post('invoice_number');
        $rate = $this->input->post('rate');
        $total = $this->input->post('total');
        $description = $this->input->post('description');
        //$term = date_diff($tanggal, $tgl_invoice);
        $bayar = $this->input->post('amount');
        $hutang = $this->input->post('hutang');
        $kode_sup = $this->input->post('kode_sup');
        $nama_sup = $this->input->post('nama_sup');
        //variable user
        $created = $this->session->userdata('userid_1');
        if ($created == 'deki') {
            $created_by = 'System';
        } else {
            $created_by = $created;
        }
        $created_date = date('Y-m-d');
        $last_update_by = $this->session->userdata('userid_1');
        $last_update_date = date('Y-m-d');
        $ip_address = $_SERVER['REMOTE_ADDR'];

        //situasi nota
        $nota_debet = $this->input->post('nota_debet');
        $nota_credit = $this->input->post('nota_credit');

        //variable jurnal 
        $txtAccountNo = $this->input->post('txtAccountNo');
        $txtDeptCode = $this->input->post('txtDeptCode');
        $txtAccountName = $this->input->post('txtAccountName');
        $gst_type = $this->input->post('txtGST');
        $gst_value = $this->input->post('txtGSTValue');
        $p_gst_value = $this->input->post('GstValue');
        $txtDesc = $this->input->post('txtDesc');
        $txtTotal = $this->input->post('txtTotal');
        $txtRate = $this->input->post('txtRate');
        $rate_sgd = $this->input->post('rate_sgd');
        $txtDebt = $this->input->post('txtDebt');
        $txtCredit = $this->input->post('txtCredit');
        $nomor_coa = $this->input->post('nomor_coa');
        $submit_value = $this->input->post('sbt');
        $prepared_by = $this->input->post('prepared_by');
        $paymentto = $this->input->post('paymentto');


        //$this->M_ccdn->delete_vcdn($refno);
        $this->M_vcdn->delete_jurnal($refno);
        $this->M_vcdn->delete_gst($refno);
        $this->M_vcdn->delete_hutang($refno);
        $this->M_vcdn->delete_hutang_bulanan($refno);

        $sum_debet=0;
        $sum_credit=0;
        $sum_debet_sgd=0;
        $sum_credit_sgd=0;
        $dk ='';

        //CARI NILAI RATE AKHIR
        //$rate_akhir = $this->M_vcdn->get_rate($currency);
        //=========== input to acc_tbl_trn_debit_kredit_note =======

            $currency = $this->input->post('Currency');
            $txtNoUrut = $this->input->post('txtNoUrut');

            //input to acc_tbl_trn_jurnal
            for ($i = 0; $i < count($this->input->post('txtAccountNo')); $i++) {
                if ($i < 1) {
                    $sub_account_id = $kode_sup;
                    $sub_account_type = 'HUT';
                } else {
                    $sub_account_id = '';
                    $sub_account_type = '';
                }

                if($txtDebt[$i] <> 0 ){
                    $dk = 'D';
                } else {
                    $dk = 'C';
                }

                $total = number_format((float)str_replace(",", "", $txtTotal[$i]), 2, ".", "");
                if ($dk == 'D') {
                    $debet = number_format((float)str_replace(",", "", $txtDebt[$i]), 2, ".", "");
                    $debet_sgd = number_format((float)str_replace(",", "",  $txtTotal[$i]) * $rate_sgd, 2, ".", "");
                    $credit = '0';
                    $credit_sgd = '0';
                    $sum_debet += $debet;
                    $sum_debet_sgd += $debet_sgd;
                } elseif ($dk == 'C') {
                    $debet = '0';
                    $debet_sgd = '0';
                    $credit = number_format((float)str_replace(",", "",$txtCredit[$i]), 2, ".", "");
                    $credit_sgd = number_format((float)str_replace(",", "", $txtTotal[$i]) * $rate_sgd, 2, ".", "");
                    $sum_credit +=  $credit;
                    $sum_credit_sgd += $credit_sgd;
                }

                if ((count($this->input->post('txtAccountNo')) - 1) == $i){
                    $selisih = $sum_debet - $sum_credit;

                    if ($selisih != 0) {
                        if ($dk == 'D') {
                            $debet = $debet - $selisih; 
                        } else {
                            $credit = $credit - $selisih; 
                        }
                    }

                    $selisih_sgd = $sum_debet_sgd - $sum_credit_sgd;

                    if ($selisih_sgd != 0){
                        if ($dk == 'D') {
                            $debet_sgd = $debet_sgd - $selisih_sgd; 
                        } else {
                            $credit_sgd = $credit_sgd - $selisih_sgd; 
                        }
                    }
                }


                $det_jur = array(
                    'JenisJurnalID' => $jenis,
                    'NoUrut' => $txtNoUrut[$i],
                    'CompanyID' => 'PSS',
                    'jenis_trans' => 'VCDN',
                    'Tanggal' => $tanggal,
                    'NoJurnalDtl' => $invoice_number,
                    'Periode' => $Periode,
                    'NoJurnal' => $refno,
                    'chk' => $dk,
                    'NoCOA' => $txtAccountNo[$i],
                    'sub_account_type' => $sub_account_type,
                    'sub_account_id' => $sub_account_id,
                    'gst_type' => $gst_type[$i],
                    'gst_value' => $gst_value[$i],
                    'Uraian' => $txtDesc[$i],
                    'Debet' => $debet,
                    'Kredit' => $credit,
                    'Debet_SGD' => $debet_sgd,
                    'Kredit_SGD' => $credit_sgd,
                    'Total' => number_format((float)str_replace(",", "", $txtTotal[$i]), 2, ".", ""),
                    'Currency' => $currency,
                    'Rate' => $txtRate[$i],
                    'rate_sgd' => $rate_sgd,
                    'TotalAsal' => number_format((float)str_replace(",", "", $hutang), 4, ".", ""),
                    'CurrencyAsal' => $currency,
                    'RateAsal' => $txtRate[$i],
                    'Keterangan' => $txtAccountName[$i],
                    'created_by' => $created_by,
                    'created_date' => $created_date,
                    'ip_address' => $ip_address,
                    'dept_code'        => $txtDeptCode[$i],
                );


                if ($total <> 0){
                    $this->M_vcdn->simpan_jurnal($det_jur);
                }

                if($jenis == 'VCN'){
                    $gst_value[$i] = 0 - number_format((float)str_replace(",", "", $gst_value[$i]), 2, ".", "");
                } else {
                    $gst_value[$i] =number_format((float)str_replace(",", "", $gst_value[$i]), 2, ".", "");
                }

                $gst_item = array(
                    'ref_nomor' => $refno,
                    'jenis_trans' => $jenis,
                    'item' => $txtDesc[$i],
                    'po_no' => '',
                    'qty' => 1,
                    'gst_type' => $gst_type[$i],
                    'gst_value' => $gst_value[$i],
                    'unit' => '',
                    'price' => number_format((float)str_replace(",", "", $txtTotal[$i]), 2, ".", ""),
                    'currency' => $currency,
                    'rate' => $txtRate[$i],
                    'rate_sgd' => $rate_sgd,
                    'created_by' => $created_by,
                    'created_date' => $created_date,
                    'ip_address' => $ip_address,
                );

                if ($gst_type[$i] <> "") {
                    $this->M_vcdn->simpan_gst_payable($gst_item);
                }
            }

            if ($submit_value == 'Save') {
                $p_perintah = 'add';
            } else {
                $p_perintah = 'edit';
            }

            $data = array('p_perintah' => $p_perintah,
                'p_no_reff' => $refno,
                'p_tanggal' => $tanggal,
                'p_no_nota' => $invoice_number,
                'p_total' => number_format(str_replace(",", "", $bayar), 2, ".", ""),
                'p_jenis_debit_kredit' => $jenis,
                'p_keterangan' => $description,
                'p_created_by' => $created_by,
                'p_ip_address' => $ip_address,
                'p_currency' => $currency,
                'p_rate' => $rate,
                'p_kode_sup' => $kode_sup,
                'p_nama_sup' => $nama_sup,
                'p_nocoa' => $nomor_coa,
                'p_rate_sgd' => $rate_sgd,
                'p_gst_value' => $p_gst_value,
                'prepared_by' => $prepared_by,
                'p_payment_to' => $paymentto
            );
            $this->M_vcdn->call_sp_acc_tbl_trn_debit_kredit_note($data);
            $this->session->set_flashdata('message', pesan("The transaction has been successfully saved with the Reference Number : $refno", pesan_info()));


            redirect("Vcdn/edit?id=" . $refno . "&jenis=" . $jenis . "&cur=" . $currency);
    }

    //======== end pakai ===========

    //get cur rate
    public function ambil_cur(){

        $data['currency']= $this->M_purchase_inv_factory->tampil_po_rate($this->input->get('cur'),$this->convert($this->input->get('date')));
        $this->load->view('accounting/ajax/get_currency_cdn', $data);
    }

    public function convert($date){
        $explode=explode("/", $date);

        $time=$explode[2].'/'.$explode[1].'/'.$explode[0];

        return $time;
    }

    function selectInvoiceVCDN(){
        $data   = array(
            '_selectHeader' => $this->M_vcdn->selectInvoiceforFindVCDN()->result()
        );
        $this->load->view('accounting/vcdn/FindIVCDN/selectIVCDN',$data);
    }
}
