
<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Ccdn extends CI_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model(array('M_vcdn', 'M_ccdn','M_login'));
        $this->load->library(array('template', 'user_agent', 'fpdf'));

        if (!$this->session->userdata('userid_1')) {
            redirect('login');
        }
    }

    //======== pakai ===========
    public function index() {
        $data['title'] = "List of Payable Recognition";
        $data['SupplierID'] = $this->M_ccdn->get_purchasing();
        $data['List_ccdn'] = $this->M_ccdn->list_ccdn();
        $this->template->display('accounting/ccdn/ccdn_list', $data);
    }

    function search() { 
        $company   = strtoupper($this->session->userdata('company_id'));
        $invoice = $this->input->get("invoice");
        $dari = str_replace('/', '-', $this->input->get('dari'));
        $p_dari = date('Y-m-d', strtotime($dari));
        $sampai = str_replace('/', '-', $this->input->get("sampai"));
        $p_sampai = date('Y-m-d', strtotime($sampai));
        $supplier = $this->input->get("supplier");

        $data['List_coa'] = $this->M_vcdn->get_coa($company);
        $data['List_ccdn'] = $this->M_ccdn->list_ccdn2($invoice, $supplier, $p_dari, $p_sampai);

       // $data['List_piutang'] = $this->M_ccdn->list_piutang2($invoice, $supplier, $p_dari, $p_sampai);

       $this->template->display('accounting/ccdn/ccdn_list', $data);
    }

    function add_new() {
        $company   = strtoupper($this->session->userdata('company_id'));
        $data['SupplierID'] = $this->M_ccdn->get_supplier();
        $data['Currency'] = $this->M_ccdn->get_currency();
        // $data['List_coa'] = $this->M_ccdn->get_coa();
        $data['List_coa'] = $this->M_vcdn->get_coa($company);
        $data['message'] = $this->session->flashdata('message');
        $data['List_hutang'] = $this->M_ccdn->list_piutang();
        $data['Currency'] = $this->M_ccdn->get_currency();
        $data['List_piutang'] = $this->M_ccdn->list_piutang();
        $data['bank'] = $this->M_vcdn->tampil_bank();
        $close_date         = $this->M_login->ambil_tgl()->row();
        $data['closing']    = date_format(date_create($close_date->tanggal), "d/m/Y");
        $this->template->display('accounting/ccdn/ccdn_form', $data);
        // $this->template->display('error/error.html', $data);
    }

    function edit() {
        $id = $this->input->get("id");
        $company   = strtoupper($this->session->userdata('company_id'));
        $data['SupplierID'] = $this->M_ccdn->get_purchasing();
        $data['Currency'] = $this->M_ccdn->get_currency();
        $data['List_coa'] = $this->M_vcdn->get_coa($company);
        $data['message'] = $this->session->flashdata('message');

        //cari data nota kredit
        $data['select_ccdn'] = $this->M_ccdn->select_ccdn($id);
        $data['select_ccdn2'] = $this->M_ccdn->select_ccdn2($id);
        $data['select_hutang'] = $this->M_ccdn->select_piutang($id);
        $data['select_bulanan'] = $this->M_ccdn->select_bulanan($id);
        $data['select_jurnal'] = $this->M_ccdn->select_jurnal($id);
        $data['select_nota'] = $this->M_ccdn->select_nota($id);
         $data['bank'] = $this->M_vcdn->tampil_bank();
        $close_date         = $this->M_login->ambil_tgl()->row();
        $data['closing']    = date_format(date_create($close_date->tanggal), "d/m/Y");

        // print_r($data['select_bulanan']);
        // die;
        $this->template->display('accounting/ccdn/ccdn_form', $data);
    }

     function print_ccdn() {
         $id = $this->input->get("id");
         $jenis = $this->input->get("jenis");
         $st = $this->input->get('st');
         $company   = strtoupper($this->session->userdata('company_id'));
         $data['SupplierID'] = $this->M_ccdn->get_purchasing();
         $data['Currency'] = $this->M_ccdn->get_curs();
         $data['get_currency'] = $this->M_ccdn->bank_get_all();
         $data['List_coa'] = $this->M_vcdn->get_coa($company);

         //cari data nota kredi
         $data['select_ccdn'] = $this->M_ccdn->select_ccdn($id);
         $data['select_hutang'] = $this->M_ccdn->select_piutang($id);
         $data['select_bulanan'] = $this->M_ccdn->select_bulanan($id);
         $data['get_gst'] = $this->M_ccdn->select_gst($id);
         $data['nota'] = $this->M_ccdn->select_nota_print($id);
         $data['detail_print'] = $this->M_ccdn->select_detail_print($id, $jenis);
         $data['detail_sgd'] = $this->M_ccdn->select_rate_sgd($id);


        //  echo json_encode($data['detail_print']);
        //  die;

         if($st == 3){
            $this->load->view('accounting/rpt/rpt_ccdn_2', $data);
         }
         else
         {
            $this->load->view('accounting/rpt/rpt_ccdn', $data);
         }
         
     }
	 
	 function print_ccdn_old() { 
        $company   = strtoupper($this->session->userdata('company_id'));
        $invoice = $this->input->get("invoice");
        $dari = str_replace('/', '-', $this->input->get('dari'));
        $p_dari = date('Y-m-d', strtotime($dari));
        $sampai = str_replace('/', '-', $this->input->get("sampai"));
        $p_sampai = date('Y-m-d', strtotime($sampai));
        $supplier = $this->input->get("supplier");

        $data['List_coa'] = $this->M_vcdn->get_coa($company);
        $data['List_ccdn'] = $this->M_ccdn->list_ccdn3($invoice, $supplier, $p_dari, $p_sampai);

       // $data['List_piutang'] = $this->M_ccdn->list_piutang2($invoice, $supplier, $p_dari, $p_sampai);

       $this->load->view('accounting/rpt/rpt_ccdn_old', $data);
    }

    function hapus(){
        $id = $this->input->get('id');
        $created = $this->session->userdata('userid_1');
        $created_date = date('Y-m-d');

        $cek_ccdn = $this->M_ccdn->cek_ccdn($id);

        if ($id != $cek_ccdn->no_reff){
            $ccdn = array('total' => 0,
                'gst_value' => 0,
                'keterangan' => 'Cancelled',
                'updated_by' => $created,
                'updated_date' => $created_date

            );

            $this->M_ccdn->update_ccdn($id,$ccdn);


            $ccdn2 = array('Debet' => 0,
                'Kredit' => 0,
                'Debet_SGD'=>0,
                'Kredit_SGD'=>0,
                'Total'=>0,
                'keterangan' => 'Cancelled',
                'last_update_by' => $created,
                'last_update_date' => $created_date
            );

             $this->M_ccdn->update_jurnal($id,$ccdn2);
        } else {
            $this->M_ccdn->delete_ccdn($id);
            $this->M_ccdn->delete_jurnal($id);
        }
        
       
        
        $this->M_ccdn->delete_gst($id);
        $this->M_ccdn->delete_piutang($id);
        $this->M_ccdn->delete_piutang_bulanan($id);
        
        redirect('Ccdn');
    }

    function cek_tabel() {
        $id = $this->input->get("id");
        $data['select_hutang'] = $this->M_ccdn->select_piutang($id);
        $this->load->view('accounting/validasi', $data);
    }

    function cek_noref() {
        $jenis = $this->input->get("jenis");
        // $tahun = $this->input->get("tahun");
        // $data['jenis'] = $this->input->get("jenis");
        // $data['bulan'] = $this->input->get("bln");
        // $data['tahun'] = $this->input->get("tahun");
        $data['select_hutang'] = $this->M_ccdn->list_ccdn_top($jenis);
        $this->load->view('accounting/ajax/noref_ccdn', $data);
    }

    function cek_noref_credit() {
        $jenis = $this->input->get("jenis");
        $tahun = $this->input->get("tahun");
        $data['jenis'] = $this->input->get("jenis");
        $data['bulan'] = $this->input->get("bln");
        $data['tahun'] = $this->input->get("tahun");
        $data['select_hutang'] = $this->M_ccdn->list_ccdn_credit($jenis, $tahun);
        $this->load->view('accounting/ajax/noref_ccdn', $data);
    }

    function list_detail() {
        $data['tabel_detail'] = $this->M_ccdn->list_jurnal($id);
        //$date['nota'] = $this->M_ccdn->nota_debet_kredit($id);

        $this->load->view('accounting/ccdn/table_list', $data);
    }

    function action() {
        //variable 
        $jenis          = $this->input->post('JenisJurnal');
        $noref          = $this->input->post('refno');
        $tgl_jurnal     = str_replace('/', '-', $this->input->post('tanggal'));
        $tanggal        = date('Y-m-d', strtotime($tgl_jurnal));
        $Periode        = date('mY', strtotime($tgl_jurnal));

        $tanggal_invoice = str_replace('/', '-', $this->input->post('tgl_invoice'));
        $tgl_invoice     = date('Y-m-d', strtotime($tgl_jurnal));


        $invoice_number = $this->input->post('invoice_number');
        $rate           = $this->input->post('rate');
        $total          = $this->input->post('total');
        $description    = $this->input->post('description');
        //$term = date_diff($tanggal, $tgl_invoice);
        $bayar          = number_format(str_replace(",", "", $this->input->post('amount')), 2, ".", "");
        $hutang         = $this->input->post('hutang');
        $kode_sup       = $this->input->post('kode_sup');
        $nama_sup       = $this->input->post('nama_sup');
        //variable user
        $created = $this->session->userdata('userid_1');
        if ($created == 'deki') {
            $created_by = 'System';
        } else {
            $created_by = $created;
        }
        $created_date = date('Y-m-d');
        $last_update_by     = $this->session->userdata('userid_1');
        $last_update_date   = date('Y-m-d');
        $ip_address         = $_SERVER['REMOTE_ADDR'];

        //situasi nota
        $nota_debet         = $this->input->post('nota_debet');
        $nota_credit        = $this->input->post('nota_credit');

        //variable jurnal 
        $txtAccountNo       = $this->input->post('txtAccountNo');
        $txtDeptCode        = $this->input->post('txtDeptCode');
        $txtAccountName     = $this->input->post('txtAccountName');
        $gst_type           = $this->input->post('txtGST');
        $gst_value          = $this->input->post('txtGSTValue');
        $p_gst_value        = $this->input->post('GstValue');
        $txtDesc            = $this->input->post('txtDesc');
        $txtTotal           = $this->input->post('txtTotal');
        $txtRate            = $this->input->post('txtRate');
        $rate_sgd           = $this->input->post('rate_sgd');
        $txtDebt            = $this->input->post('txtDebt');
        $txtCredit          = $this->input->post('txtCredit');
        $nomor_coa          = $this->input->post('nomor_coa');
        $submit_value       = $this->input->post('sbt');
        $prepared_by = $this->input->post('prepared_by');
        $paymentto = $this->input->post('paymentto');
        
        //$this->M_ccdn->delete_ccdn($noref);
        $this->M_ccdn->delete_jurnal($noref);
        $this->M_ccdn->delete_gst($noref);
        $this->M_ccdn->delete_piutang($noref);
        $this->M_ccdn->delete_piutang_bulanan($noref);

        //tentukan no reff
        $bln    = date('m', strtotime($tgl_jurnal));
        $no     = $this->M_ccdn->list_ccdn_top($bln);

        $refno = $noref;

        //CARI NILAI RATE AKHIR
        //$rate_akhir = $this->M_ccdn->get_rate($currency);
        //=========== input to acc_tbl_trn_debit_kredit_note =======

        $currency  = $this->input->post('Currency');
        $txtNoUrut = $this->input->post('txtNoUrut');

        $debet      =0;
        $debet_sgd  =0;
        $credit     =0;
        $credit_sgd =0;
        $sum_debet  =0;
        $sum_credit =0;
        $sum_debet_sgd=0;
        $sum_credit_sgd=0;

        $dk ='';

        //input to acc_tbl_trn_jurnal
        for ($i = 0; $i < count($this->input->post('txtAccountNo')); $i++) {
            //echo $txtDebt[$i];

            if ($i < 1) {
                $sub_account_id = $kode_sup;
                $sub_account_type = 'PIU';
            } else {
                $sub_account_id = '';
                $sub_account_type = '';
            }

            if($txtDebt[$i] <> 0 ){
                $dk = 'D';
            } else {
                $dk = 'C';
            }

            $total = number_format((float)str_replace(",", "", $txtTotal[$i]), 0, ".", "");

            if ($dk == 'D') {
                $debet          = number_format((float)str_replace(",", "", $txtDebt[$i]), 2, ".", "");
                $debet_sgd      = number_format((float)str_replace(",", "", $txtTotal[$i]) * $rate_sgd, 2, ".", "");
                $credit         = '0';
                $credit_sgd     = '0';
                $sum_debet      += $debet;
                $sum_debet_sgd  += $debet_sgd;
            } elseif ($dk == 'C') {
                $debet          = '0';
                $debet_sgd      = '0';
                $credit         = number_format((float)str_replace(",", "", $txtCredit[$i]), 2, ".", "");
                $credit_sgd     = number_format((float)str_replace(",", "", $txtTotal[$i]) * $rate_sgd, 2, ".", "");
                $sum_credit     +=  $credit;
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
                'JenisJurnalID'     => $jenis,
                'NoUrut'            => $txtNoUrut[$i],
                'CompanyID'         => 'ZHL',
                'jenis_trans'       => 'CCDN',
                'Tanggal'           => $tanggal,
                'NoJurnalDtl'       => $invoice_number,
                'Periode'           => $Periode,
                'NoJurnal'          => $refno,
                'chk'               => $dk,
                'NoCOA'             => $txtAccountNo[$i],
                'sub_account_type'  => $sub_account_type,
                'sub_account_id'    => $sub_account_id,
                'gst_type'          => $gst_type[$i],
                'gst_value'         => $gst_value[$i],
                'Uraian'            => $txtDesc[$i],
                'Debet'             => number_format($debet, 2, ".", ""),
                'Kredit'            => number_format($credit, 2, ".", ""),
                'Debet_SGD'         => number_format($debet_sgd, 2, ".", ""),
                'Kredit_SGD'        => number_format($credit_sgd, 2, ".", ""),
                'Total'             => number_format((float)str_replace(",", "", $txtTotal[$i]), 2, ".", ""),
                'Currency'          => $currency,
                'Rate'              => $txtRate[$i],
                'rate_sgd'          => $rate_sgd,
                'TotalAsal'         => number_format((float)str_replace(",", "", $hutang), 4, ".", ""),
                'CurrencyAsal'      => $currency,
                'RateAsal'          => $txtRate[$i],
                'Keterangan'        => $txtAccountName[$i],
                'created_by'        => $created_by,
                'created_date'      => $created_date,
                'ip_address'        => $ip_address,
                'dept_code'        => $txtDeptCode[$i],
            );

            if ($total <> 0) {
                $this->M_ccdn->simpan_jurnal($det_jur);
            }

            if($jenis == 'CCN'){
                $gst_value[$i]= 0 - number_format((float)str_replace(",", "", $gst_value[$i]), 2, ".", "");
            } else {
                $gst_value[$i]=number_format((float)str_replace(",", "", $gst_value[$i]), 2, ".", "");
            }

            $gst_item = array(
                'ref_nomor'     => $refno,
                'jenis_trans'   => $jenis,
                'item'          => $txtDesc[$i],
                'po_no'         => '',
                'qty'           => 1,
                'gst_type'      => $gst_type[$i],
                'gst_value'     => $gst_value[$i],
                'unit'          => '',
                'price'         => number_format((float)str_replace(",", "", $txtTotal[$i]), 4, ".", ""),
                'currency'      => $currency,
                'rate'          => $txtRate[$i],
                'rate_sgd'      => $rate_sgd,
                'created_by'    => $created_by,
                'created_date'  => $created_date,
                'ip_address'    => $ip_address,
            );

            if ($gst_type[$i] <> "") {
                $this->M_ccdn->simpan_gst_payable($gst_item);
            }
        }
        $total_akhir = number_format(str_replace(",", "", $bayar), 2, ".", "");


        if ($submit_value == 'Save') {
            $p_perintah = 'add';
        } else {
            $p_perintah = 'edit';
        }

        $data = array('p_perintah' => $p_perintah,
            'p_no_reff'         => $refno,
            'p_tanggal'         => $tanggal,
            'p_no_nota'         => $invoice_number,
            'p_total'           => number_format(str_replace(",", "", $bayar), 2, ".", ""),
            'p_jenis_debit_kredit' => $jenis,
            'p_keterangan'      => $description,
            'p_created_by'      => $created_by,
            'p_ip_address'      => $ip_address,
            'p_currency'        => $currency,
            'p_rate'            => $rate,
            'p_kode_sup'        => $kode_sup,
            'p_nama_sup'        => $nama_sup,
            'p_nocoa'           => $nomor_coa,
            'p_rate_sgd'        => $rate_sgd,
            'p_gst_value'       => $p_gst_value,
            'prepared_by' => $prepared_by,
            'p_payment_to' => $paymentto
        );
        $this->M_ccdn->call_sp_acc_tbl_trn_debit_kredit_note($data);
        $this->session->set_flashdata('message', pesan("The transaction has been successfully saved with the Reference Number : $refno", pesan_info()));


        redirect("Ccdn/edit?id=" . $refno . "&jenis=" . $jenis . "&cur=" . $currency);
    }

    function get_ref_cn() {
        $data['_tmp'] = $this->M_ccdn->select_ref_ccn();
        $this->load->view('accounting/ccdn/ccn_refnumber', $data);
    }

    function get_ref_dn() {
        $data['_tmp'] = $this->M_ccdn->select_ref_cdn();
        $this->load->view('accounting/ccdn/cdn_refnumber', $data);
    }

    function delete_detail() {
        $id = $this->input->get('id');
        $nofak = $this->input->get('nofak');
        $this->M_ccdn->delete_dtl($id);
        redirect('Ccdn/edit?id=' . $nofak . '');
    }

    //======== end pakai ===========

    function selectInvoiceCCDN(){
        $data   = array(
            '_selectHeader' => $this->M_ccdn->selectInvoiceforFindCCDN()->result()
        );
        $this->load->view('accounting/ccdn/FindICCDN/selectICCDN',$data);
    }
}
