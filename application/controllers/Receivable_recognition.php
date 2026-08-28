
<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Receivable_recognition extends CI_Controller
{

    function __construct()
    {
        parent::__construct();

        $this->load->model(array('M_mar_master', 'M_Receivable_recognition','M_login', 'M_vcdn', 'M_Sales_inv','M_General_Journal'));
        $this->load->library(array('template', 'user_agent'));

        if (!$this->session->userdata('userid_1')) {
            redirect('login');
        }
    }

    public function index()
    {
        $data['SupplierID']     = $this->M_Receivable_recognition->get_sup();
        $data['title']          = "List of Receivable Recognition";
        $data['List_payable']   = $this->M_Receivable_recognition->get_list_piutang();
        $this->template->display('accounting/Receivable_recognition/Receivable_recognition_list', $data);
    }

    function buat_nofak()
    {
        $tahun = $this->input->get("tahun");
        $data['nofak'] = $this->M_Receivable_recognition->cari_nofaktur($tahun);
        $this->load->view('accounting/ajax/cek_nofak', $data);
    }

    function search()
    {
        $data['SupplierID'] = $this->M_Receivable_recognition->get_sup();
        $invoice            = $this->input->get("invoice");
        $dari               = str_replace('/', '-', $this->input->get('dari'));
        $p_dari             = date('Y-m-d', strtotime($dari));
        $sampai             = str_replace('/', '-', $this->input->get("sampai"));
        $p_sampai           = date('Y-m-d', strtotime($sampai));
        $supplier           = $this->input->get("supplier");

        $data['tgl'] = $dari;
        if ($dari != '') {
            $data['List_payable'] = $this->M_Receivable_recognition->advance_list_piutang($p_dari, $p_sampai, $invoice, $supplier);
        } else {
            $data['List_payable'] = $this->M_Receivable_recognition->advance_list_piutang1($invoice, $supplier);
        }
        $this->template->display('accounting/Receivable_recognition/Receivable_recognition_list', $data);
    }

    function add_new()
    {
        $company   = strtoupper($this->session->userdata('company_id'));
        $data['SupplierID'] = $this->M_Receivable_recognition->get_customer();
        $data['SupplierIDNew'] = $this->M_Receivable_recognition->get_customernew();
        $data['Currency']   = $this->M_Receivable_recognition->get_currency();
        $data['List_coa']   = $this->M_vcdn->get_coa($company);
        $data['message']    = $this->session->flashdata('message');
        $data['bank']       = $this->M_vcdn->tampil_bank();
        $data['dept_code'] = $this->M_General_Journal->get_departmentcode();
        $close_date         = $this->M_login->ambil_tgl()->row();
        $data['closing']    = date_format(date_create($close_date->tanggal), "d/m/Y");
        $data['dept_code_json'] = json_encode($data['dept_code']);
        $this->template->display('accounting/Receivable_recognition/Receivable_recognition_form', $data);
    }

    function get_supp_piu(){
        $supp = $this->input->get('supp');
        $tanggal = $this->input->get('periode');
        $periode = date('Y-m-d', strtotime($tanggal));
        $currency = "";
        
        $cekPiutang = $this->M_Receivable_recognition->call_cek_sp_rec_piutang($supp, $currency, $periode); 
        if ($cekPiutang) {
            $tmp_kodesup = $cekPiutang[0]->tmp_kodesup;
            $response = $tmp_kodesup;

            echo json_encode($response);
        
        } else {
            echo json_encode(['error' => 'Data tidak ditemukan']);
        }
        
    }

    function getTerm(){
        $id = $_GET['supplier'];
        $data['term'] = $this->M_Receivable_recognition->get_term($id);
        echo json_encode($data);
    }

    function get_coa()
    {
        // tangkap variabel keyword dari URL
        $keyword = $this->uri->segment(3);

        // cari di database
        // $data = $this->db->from('acc_master_coa')->like('NoCOA', $keyword)->get(); -> old
        $data = $this->db->from('zhl_vw_new_coa_dept_code')->like('NoCOA', $keyword)->get();

        // format keluaran di dalam array
        foreach ($data->result() as $row) {
            $arr['query'] = $keyword;
            $arr['suggestions'][] = array(
                'value' => $row->NoCOA . " | " . $row->AccountName,
                'NoCOA' => $row->NoCOA,
                'AccountName' => $row->AccountName
            );
        }
        // minimal PHP 5.2
        echo json_encode($arr);
    }

    function data_dp()
    {
        $id = $this->input->get("id");
        $currency = $this->input->get("currency");

        $data['pilih_dp'] = $this->M_Receivable_recognition->pilih_dp($id, $currency);
        $this->load->view('accounting/list_dp', $data);
    }

    function edit()
    {
        $company   = strtoupper($this->session->userdata('company_id'));
        $data['SupplierID']     = $this->M_Receivable_recognition->get_customer();
        $data['SupplierIDNew'] = $this->M_Receivable_recognition->get_customernew();
        $data['Currency']       = $this->M_Receivable_recognition->get_currency();
        $data['message']        = $this->session->flashdata('message');
        $data['CurrencyID']     = $this->M_Receivable_recognition->get_currency_detail();
        $data['List_coa']       = $this->M_vcdn->get_coa($company);
        $data['bank']       = $this->M_vcdn->tampil_bank();
        $id = $this->input->get("id");

        //variable invoice number header
        $data['HeaderID']        = $id;
        $data['get_data_header'] = $this->M_Receivable_recognition->get_data_header($id);
        $data['nota']            = $this->M_Receivable_recognition->nota($id);
        //variable invoice number detail
        $data['get_data_detail'] = $this->M_Receivable_recognition->get_data_detail($id);
        //variable invoice number footer
        $data['get_data_footer'] = $this->M_Receivable_recognition->get_data_footer($id);

        $data['get_data_jurnal1'] = $this->M_Receivable_recognition->get_data_awal($id, 'AR/GL');
        $data['get_data_jurnal2'] = $this->M_Receivable_recognition->get_data_jurnal(2, $id, 'RRG');
        $data['get_data_jurnal3'] = $this->M_Receivable_recognition->get_data_jurnal(3, $id, 'RRG');
        $data['get_data_jurnal4'] = $this->M_Receivable_recognition->get_data_jurnal(4, $id, 'RRG');
        $data['get_data_jurnal5'] = $this->M_Receivable_recognition->get_data_jurnal(5, $id, 'RRG');
        $data['get_data_jurnal6'] = $this->M_Receivable_recognition->get_data_jurnal(6, $id, 'RRG');
        $data['dept_code'] = $this->M_General_Journal->get_departmentcode();
        $data['dept_code_json'] = json_encode($data['dept_code']);
        $data['data_bawah']       = $this->M_Receivable_recognition->data_paling_bawah($id);
        $close_date         = $this->M_login->ambil_tgl()->row();
        $data['closing']    = date_format(date_create($close_date->tanggal), "d/m/Y");

        if (!empty($data['data_bawah'])) {
            $this->template->display('accounting/Receivable_recognition/Receivable_recognition_form', $data);
        } else {
            $data['SupplierID'] = $this->M_Receivable_recognition->get_sup();
            $data['title']      = "List of Receivable Recognition";
            $data['List_payable'] = $this->M_Receivable_recognition->get_list_piutang();
            $this->template->display('accounting/Receivable_recognition/Receivable_recognition_list', $data);
        }
    }

    function print_report()
    {
        // $data['SupplierID'] = $this->M_Receivable_recognition->get_customer();
        // $data['Currency'] = $this->M_Receivable_recognition->get_currency();
        // $data['CurrencyID'] = $this->M_Receivable_recognition->get_currency_detail();
        //cari nota debet, berdasarkan total seluruh transaksi "Bayar"
        $id = $this->input->get("id");

        //variable invoice number header
        $data['HeaderID'] = $id;
        $data['titel']      = 'Payable Recognition';
        $data['nota']       = $this->M_Receivable_recognition->nota($id);
        $data['get_data_header'] = $this->M_Receivable_recognition->get_data_header($id);
        //variable invoice number detail
        $data['get_data_detail'] = $this->M_Receivable_recognition->get_data_detail($id);
        $data['get_currency'] = $this->M_mar_master->bank_get_all();

        $a = $this->M_Receivable_recognition->get_data_detail($id);
        $i = "TAX INVOICE";
        $totalgst = 0;
        if (!empty($a)) {
            foreach ($a as $r) {
                $totalgst += $r->gst_value;
            }
        }
        if ($totalgst != 0) {
            $i = "TAX INVOICE";
        }
        //variable invoice number footer
        $data["judul"] = $i;
        $data['get_data_footer'] = $this->M_Receivable_recognition->get_data_footer($id);

        $this->load->view('accounting/rpt/rpt_receivable_recognition', $data);
    }

    function list_currency()
    {
        $data['Currency'] = $this->M_Receivable_recognition->get_currency_detail();
        $this->load->view('accounting/list_currency', $data);
    }

    function list_payable()
    {
        $id = $this->input->get("id");

        //variable invoice number header
        $this->M_Receivable_recognition->get_data_header($id);
    }

    function update_po()
    {

        $po_number = $this->input->post("no_po");
        $bayar = $this->input->post("bayar");

        for ($e = 0; $e < count($bayar); $e++) {
            $data = array('bayar' => $this->input->post("bayar")[$e]);
            $this->M_Receivable_recogniton->update_dp($po_number[$e], $data);
        }
    }

    function save_receivable_rec()
    {
        $nofaktur       = $this->input->post('nofaktur');
        $company_id     = 'ZHL';
        $tgl_jurnal     = str_replace('/', '-', $this->input->post('tgl_jurnal'));
        $p_tanggal      = date('Y-m-d', strtotime($tgl_jurnal));
        $tgl_tempo      = str_replace('/', '-', $this->input->post('tgl_tempo'));
        $p_tanggal_tempo = date('Y-m-d', strtotime($tgl_tempo));
        $tgl_invoice    = str_replace('/', '-', $this->input->post('tgl_invoice'));
        $p_tanggal_invoice = date('Y-m-d', strtotime($tgl_invoice));

        $supplier       = $this->input->post('supplier');
        $jenis_trans    = 'RRG';
        $currencyid     = $this->input->post('symbol_currency');
        $currency       = $this->input->post('Currency');
        $rate           = $this->input->post('rate_header');
        $rate_awal      = $this->input->post('rate_header');
        $prepared_by    = $this->input->post('prepared_by');
        $rate_akhir     = $this->input->post('rate_header');
        $blnum          = $this->input->post('blnnum');
        $ctrnum         = $this->input->post('ctrnum');
        $paymentto      = $this->input->post('paymentto');
        $bargenum       = $this->input->post('bargenum');
        $tgl_ship       = str_replace('/', '-', $this->input->post('shipdate'));
        $shipdate       = date('Y-m-d', strtotime($tgl_ship));
        $typeinv        = $this->input->post('invtype');
        $etddate        = str_replace('/', '-', $this->input->post('etddate'));
        $etd_date       = date('Y-m-d', strtotime($etddate));
        $etadate        = str_replace('/', '-', $this->input->post('etadate'));
        $eta_date       = date('Y-m-d', strtotime($etadate));

        $term           = $this->input->post('term');
        $total          = $this->input->post('total_jr');
        $p_pajak        = $total[2];
        $p_diskon       = $total[1];
        $p_biaya_lain   = $total[3];
        $p_uang_muka    = $total[4];
        $p_hutang       = $total[5];
        $created_by     = $this->session->userdata('userid_1');
        $created_date   = date('Y-m-d');
        $last_update_by = $this->session->userdata('userid_1');
        $last_update_date = date('Y-m-d');
        $ip_address     = $_SERVER['REMOTE_ADDR'];
        $submit_value   = $this->input->post('sbt');
        $NoCOA          = $this->input->post('NoCOA');

        $id             = $this->input->post('Detail_ID');
        $Periode        = date('mY', strtotime($tgl_jurnal));
        $status         = '2';
        $rate_sgd       = $this->input->post('rate_sgd');
        $jr_nocoa       = $this->input->post('no_coa');
        $jr_jenisjurnal = $this->input->post('JenisJurnal');
        $jr_dept_code   = $this->input->post('dept_code');
        $jr_desc        = $this->input->post('desc');

        $jr_NoUrut = $this->input->post('NoUrut');
        $dk = $this->input->post('dk');



        if ($nofaktur == '') {
            $p_tahun = date('Y', strtotime($tgl_jurnal));
            $p_bulan = date('m', strtotime($tgl_jurnal));
            $sql_faktur = $this->M_Sales_inv->get_nofaktur($p_tahun, $p_bulan);
            $nofaktur = $sql_faktur;
        }

        $this->M_Receivable_recognition->delete_piutang($nofaktur);

        $sum_debet = 0;
        $sum_credit = 0;
        $sum_debet_sgd = 0;
        $sum_credit_sgd = 0;

        // if ($submit_value == 'Save') {
        $rate_jr    = $this->input->post('rate_jr');
        $jr_total   = $this->input->post('total_jr');
        $txtItem    = $this->input->post('txtItem');
        $txtQty     = $this->input->post('txtQty');
        $txtCOA     = $this->input->post('txtCOA');
        $txtDept    = $this->input->post('txtdept');
        $txtUnit    = $this->input->post('txtUnit');
        $txtPrice   = $this->input->post('txtPrice');
        $txtRate    = $this->input->post('txtRate');
        $txtNoPO    = $this->input->post('Detail_po');
        $txtGST     = $this->input->post('txtGST');
        $txtGSTValue = $this->input->post('txtGSTValue');
        $SubAccountId = $this->input->post('SubAccountId');
        $nota_debet = $this->input->post('nota_debet');
        $txtAmountR = $this->input->post('txtAmountR');
        $txtBlCode  = $this->input->post('txtBlCode');
        $Uraian     = $txtItem[0];

        for ($i = 0; $i < count($this->input->post('Detail_item_id')); $i++) {
            $det_item = array(
                'HeaderID'  => $nofaktur,
                'Jenis'     => 'RRG',
                'NoCOA'     => $txtCOA[$i],
                'no_po'     => $txtNoPO[$i],
                'Items'     => $txtItem[$i],
                'Qty'       => number_format(str_replace(",", "", $txtQty[$i]), 2, ".", ""),
                'currency'  => $this->input->post('Currency'),
                'rate'      => $rate,
                'Unit'      => $txtUnit[$i],
                'Harga'     => number_format(str_replace(",", "", $txtPrice[$i]), 4, ".", ""),
                'total_inv' => number_format(str_replace(",", "", $nota_debet), 2, ".", ""),
                'gst_type'  => $txtGST[$i],
                'gst_value' => number_format(str_replace(",", "", $txtGSTValue[$i]), 2, ".", ""),
                'created_by' => $created_by,
                'created_date' => $created_date,
                'ip_address' => $ip_address,
                'dept_code'    => $txtDept[$i],
                'blCode'    => $txtBlCode[$i],
                'amountR'   => $txtAmountR[$i],

            );
            $this->M_Receivable_recognition->simpan_pr($det_item);


            $gst_item = array(
                'ref_nomor'     => $nofaktur,
                'jenis_trans'   => 'RRG',
                'item'          => $txtItem[$i],
                'qty'           => number_format(str_replace(",", "", $txtQty[$i]), 2, ".", ""),
                'gst_type'      => $txtGST[$i],
                'gst_value'     => number_format(str_replace(",", "", $txtGSTValue[$i]), 2, ".", ""),
                'unit'          => $txtUnit[$i],
                'price'         => number_format(str_replace(",", "", $txtPrice[$i]), 4, ".", ""),
                'currency'      => $this->input->post('Currency'),
                'rate'          => $rate,
                'rate_sgd'      => $rate_sgd,
                'created_by'    => $created_by,
                'created_date'  => $created_date,
                'ip_address'    => $ip_address,
            );
            if ($txtGST[$i] <> "") {
                $this->M_Receivable_recognition->simpan_gst_payable($gst_item);
            }
        }

        //array footer jurnal
        for ($a = 1; $a < count($this->input->post('DetailID')); $a++) {

            $sub_account_id = $supplier;
            $jr_total[$a]   = str_replace(",", "", $jr_total[$a]);

            if ($dk[$a] == 'D') {
                $debet      = $jr_total[$a] * $rate_jr[$a];
                $debet_sgd  = $jr_total[$a] * $rate_sgd;
                $credit     = '0';
                $credit_sgd = '0';
                $sum_debet  += number_format(str_replace(",", "", $debet), 2, ".", "");
                $sum_debet_sgd += number_format(str_replace(",", "", $debet_sgd), 2, ".", "");
            } elseif ($dk[$a] == 'C') {
                $debet      = '0';
                $debet_sgd  = '0';
                $credit     = $jr_total[$a] * $rate_jr[$a];
                $credit_sgd = $jr_total[$a] * $rate_sgd;
                $sum_credit += number_format(str_replace(",", "", $credit), 2, ".", "");
                $sum_credit_sgd += number_format(str_replace(",", "", $credit_sgd), 2, ".", "");
            }

            $det_jur = array(
                'JenisJurnalID'     => $jr_jenisjurnal[$a],
                'NoUrut'            => $jr_NoUrut[$a],
                'CompanyID'         => 'ZHL',
                'jenis_trans'       => 'RRG',
                'Tanggal'           => $p_tanggal,
                'Periode'           => $Periode,
                'NoJurnal'          => $nofaktur,
                'chk'               => $dk[$a],
                'NoCOA'             => substr($jr_nocoa[$a], 0, 6),
                'sub_account_id'    => $sub_account_id,
                'sub_account_type'  => $SubAccountId[$a],
                'Uraian'            => $Uraian,
                'Debet'             => number_format(str_replace(",", "", $debet), 2, ".", ""),
                'Kredit'            => number_format(str_replace(",", "", $credit), 2, ".", ""),
                'Debet_SGD'         => number_format(str_replace(",", "", $debet_sgd), 2, ".", ""),
                'Kredit_SGD'        => number_format(str_replace(",", "", $credit_sgd), 2, ".", ""),
                'Total'             => number_format(str_replace(",", "", $jr_total[$a]), 2, ".", ""),
                'Currency'          => $this->input->post('Currency'),
                'Rate'              => $rate_jr[$a],
                'rate_sgd'          => $rate_sgd,
                'TotalAsal'         => number_format(str_replace(",", "", $jr_total[$a]), 4, ".", ""),
                'CurrencyAsal'      => $this->input->post('Currency'),
                'RateAsal'          => $rate_awal,
                'Keterangan'        => '-',
                'created_by'        => $created_by,
                'created_date'      => $created_date,
                'last_update_by'    => $last_update_by,
                'last_update_date'  => $last_update_date,
                'ip_address'        => $ip_address,
                'dept_code'         => $jr_dept_code[$a],
            );

            if ($jr_total[$a] <> 0) {
                $this->M_Receivable_recognition->simpan_jurnal($det_jur);
            }
        }


        for ($i = 0; $i < count($this->input->post('Detail_item_id')); $i++) {
            if ($jr_nocoa[$i] <> "") {
                $sub_account_id = $supplier;
            } else {
                $sub_account_id = "";
            }

            $txtQty[$i]     = str_replace(",", "", $txtQty[$i]);
            $txtPrice[$i]   = str_replace(",", "", $txtPrice[$i]);
            $credit2        = ($txtQty[$i] * $txtPrice[$i]) * $rate;
            $credit_sgd2    = ($txtQty[$i] * $txtPrice[$i]) * $rate_sgd;
            $sum_credit     += number_format(str_replace(",", "", $credit2), 2, ".", "");
            $sum_credit_sgd += number_format(str_replace(",", "", $credit_sgd2), 2, ".", "");

            if ((count($this->input->post('Detail_item_id')) - 1) == $i) {
                $selisih = $sum_debet - $sum_credit;

                if ($selisih != 0) {
                    $credit2 = $credit2 + $selisih;
                }

                $selisih_sgd = $sum_debet_sgd - $sum_credit_sgd;

                if ($selisih_sgd != 0) {
                    $credit_sgd2 = $credit_sgd2 + $selisih_sgd;
                }
            }

            $detail_jur = array(
                'JenisJurnalID'     => 'AR/GL',
                'NoUrut'            => '0',
                'CompanyID'         => 'ZHL',
                'jenis_trans'       => 'RRG',
                'Tanggal'           => $p_tanggal,
                'Periode'           => $Periode,
                'NoJurnal'          => $nofaktur,
                'chk'               => 'C',
                'NoCOA'             => $txtCOA[$i],
                'sub_account_id'    => $sub_account_id,
                'sub_account_type'  => '',
                'gst_type'          => $txtGST[$i],
                'gst_value'         => number_format(str_replace(",", "", $txtGSTValue[$i]), 2, ".", ""),
                'Uraian'            => $txtItem[$i],
                'Debet'             => '0',
                'Kredit'            => number_format(str_replace(",", "", $credit2), 2, ".", ""),
                'Debet_SGD'         => '0',
                'Kredit_SGD'        => number_format(str_replace(",", "", $credit_sgd2), 2, ".", ""),
                'Total'             => number_format(str_replace(",", "", $txtQty[$i] * $txtPrice[$i]), 2, ".", ""),
                'Currency'          => $this->input->post('Currency'),
                'Rate'              => $rate,
                'rate_sgd'          => $rate_sgd,
                'TotalAsal'         => number_format(str_replace(",", "", $p_hutang), 2, ".", ""),
                'CurrencyAsal'      => $this->input->post('Currency'),
                'RateAsal'          => $rate_awal,
                'Keterangan'        => '-',
                'created_by'        => $created_by,
                'created_date'      => $created_date,
                'last_update_by'    => $last_update_by,
                'last_update_date'  => $last_update_date,
                'ip_address'        => $ip_address,
                'dept_code'         => $txtDept[$i],
                'blCode'            => $txtBlCode[$i],
                'amountPR'           => $txtAmountR[$i],
            );

            $this->M_Receivable_recognition->simpan_jurnal($detail_jur);
        }
        // $this->M_Receivable_recognition->hapus_COA_kosong();


        $stsDP = $this->input->post("stsDP");
        if ($stsDP == "DP") {
            // ========== ## Insert Cash Bank Transaction ## ==========
            $data = array(
                'no_reff'       => $nofaktur,
                'trans_type'    => "I",
                'date1'         => $tgl_invoice,
                'cashbank_code' => "",
                'from_to'       => $supplier,
                'trans_description' => "Deposit from Customer",
                'prepaid'       => "0",
                'suplier'       => $supplier,
                'coa_suplier'   => $this->input->post('no_coa[5]'),
                'currency_id'   => $this->input->post('Currency'),
                'currency_rate' => $rate,
                'rate_awal'     => $rate_awal,
                'rate_akhir'    => $rate_akhir,
                'created_by'    => $this->session->userdata('userid_1'),
                'created_date'  => date('Y-m-d H:i:s')
            );
            $headerID = $this->M_Receivable_recognition->insertCashBankHeaderx($data);


            $txtNoCOA   = $this->input->post("no_coa");
            $txtNameCOA = $this->input->post('JenisJurnal');
            $txtDebit   = $this->input->post('debt_jr');
            $txtCredit  = $this->input->post('credit_jr');
            $txtRemark  = $this->input->post('desc');
            $txtDeptCode = $this->input->post('dept_code');
            $txtGSTname = "";
            $txtGSTvalue = "0";
            //$txtCashFlow  = $this->input->post('txtCashFlowKey');
            for ($x = 0; $x < count($txtNoCOA); $x++) :
                $detail = array(
                    'header_id'     => $headerID,
                    'no_reff'       => $nofaktur,
                    'coa'           => $txtNoCOA[$x],
                    'coa_description' => $txtNameCOA[$x],
                    'debit'         => str_replace(',', '', $txtDebit[$x]),
                    'credit'        => str_replace(',', '', $txtCredit[$x]),
                    'remark'        => "",
                    'gst_type'      => "",
                    'gst_value'     => str_replace(',', '', $txtGSTvalue[$x]),
                    'created_by'    => $this->session->userdata('userid_1'),
                    'created_date'  => date('Y-m-d H:i:s'),
                    'dept_code'     => $txtDeptCode[$x]
                );
                $this->M_Receivable_recognition->insertCashBankDetailx($detail);
            endfor;

            // ## INSERT TO HISTORY ================================================
            for ($i = 0; $i < count($txtNoCOA); $i++) :

                $history = array(
                    'header_id'     => $headerID,
                    'no_facture'    => $nofaktur,
                    'trans_type'    => "AR",
                    'date1'         => $p_tanggal,
                    'cb_code'       => "I",
                    'from_to'       => $supplier,
                    'trans_description' => $txtRemark[$i],
                    'prepaid'       => "0",
                    'supplier'      => $supplier,
                    'coa_supplier'  => $this->input->post('no_coa[5]'),
                    'currency_id'   => $this->input->post('Currency'),
                    'currency_rate' => $rate,
                    'coa_code'      => $txtNoCOA[$i],
                    'coa_description' => "",
                    'debit_credit'  => $dk[$i],
                    'jumlah'        => $jr_total[$i],
                    'debit'         => str_replace(',', '', $txtDebit[$i]),
                    'credit'        => str_replace(',', '', $txtCredit[$i]),
                    'remark'        => $txtRemark[$i],
                    //'key_cf'            => $txtCashFlow[$i],
                    'created_by'    => $this->session->userdata('userid_1'),
                    'created_date'  => date('Y-m-d H:i:s')
                );
                $this->M_Receivable_recognition->insertCBhistoryx($history);
            endfor;
            $txtCustID = $supplier;

            //$this->insertDetailPOinCashBankx($headerID, $txtCustID, 'MAR');

            $noPO = $this->input->post('nofaktur');
            $dpPO = $this->input->post('total_jr[5]');
            $cnLoop = count($noPO);
            for ($z = 0; $z < $cnLoop; $z++) {
                $data = array(
                    'header_id'     => $headerID,
                    'po_id'         => $noPO,
                    'sup_cust_id'   => $supplier,
                    'type_detail'   => "DP",
                    'currency_id'   => $this->input->post('Currency'),
                    'uang_muka'     => str_replace(',', '', $dpPO),
                    'created_by'    => $this->session->userdata('userid_1'),
                    'created_date'  => date('Y-m-d H:i:s')
                );
                $this->M_Receivable_recognition->insertDetailPOcbTransactionx($data);
            }
        }

        if ($stsDP == "DP") {
            $status_dp = 1;
        } else {
            $status_dp = 0;
        }

        $data = array(
            'p_perintah'    => 'add',
            'p_nofaktur'    => $nofaktur,
            'p_tanggal'     => $p_tanggal,
            'p_tanggal_tempo' => $p_tanggal_tempo,
            'p_tanggal_invoice' => $p_tanggal_invoice,
            'p_term'        => $term,
            'p_kode_sup'    => $supplier,
            'p_jenis_trans' => $jenis_trans,
            'p_currency_id' => $this->input->post('Currency'),
            'p_rate'        => $rate,
            'p_pajak'       => number_format(str_replace(",", "", $p_pajak), 2, ".", ""),
            'p_diskon'      => number_format(str_replace(",", "", $p_diskon), 2, ".", ""),
            'p_biaya_lain'  => number_format(str_replace(",", "", $p_biaya_lain), 2, ".", ""),
            'p_uang_muka'   => number_format(str_replace(",", "", $p_uang_muka), 2, ".", ""),
            'p_piutang'     => number_format(str_replace(",", "", $p_hutang), 2, ".", ""),
            'p_created_by'  => $created_by,
            'p_ip_address'  => $ip_address,
            'p_rate_sgd'    => $rate_sgd,
            'p_nocoa'       => $NoCOA,
            'p_status_dp'   => $status_dp,
            'p_jenin'       => $typeinv,
            'p_etadate'     => $eta_date,
            'p_etddate'     => $etd_date,
            'p_blnum'       => $blnum,
            'p_ctrnum'      => $ctrnum,
            'p_bargenum'    => $bargenum,
            'p_shipdate'    => $shipdate,
            'p_paymentto'   => $paymentto,
            'p_prepared_by' => $prepared_by
        );

        $this->M_Receivable_recognition->call_sp_rec_piutang_new($data);


        $this->session->set_flashdata('message', pesan("The transaction has been successfully saved with the Invoice Number : $nofaktur", pesan_info()));
        redirect("Receivable_recognition/edit?id=$nofaktur");
        // } elseif ($submit_value == 'Update') {

        //     $z = $this->input->post('DetailID');
        //     $w = $this->input->post('Detail_item_id');

        //     $g = $this->input->post('Detail_item_id');
        //     $m = $this->input->post('Detail_jurnal_id');
        //     $jr_nocoa1 = $this->input->post('no_coa');
        //     $jr_desc1 = $this->input->post('desc');
        //     $rate_jr1 = $this->input->post('rate_jr');
        //     $jr_debt1 = $this->input->post('debt_jr');
        //     $credit_jr1 = $this->input->post('credit_jr');
        //     $jr_total1 = $this->input->post('total_jr');
        //     $dk1 = $this->input->post('dk');
        //     $txtItem1 = $this->input->post('txtItem');
        //     $txtQty1 = $this->input->post('txtQty');
        //     $txtCOA1 = $this->input->post('txtCOA');
        //     $txtUnit1 = $this->input->post('txtUnit');
        //     $txtPrice1 = $this->input->post('txtPrice');
        //     $txtCurrency1 = $this->input->post('txtCurrency');
        //     $txtRate1 = $this->input->post('rate_header');
        //     $SubAccountId = $this->input->post('SubAccountId');

        //     $nota_debet1 = $this->input->post('nota_debet');

        //     $txtNoPO1 = $this->input->post('Detail_po');

        //     $txtGST1 = $this->input->post('txtGST');
        //     $txtGSTValue1 = $this->input->post('txtGSTValue');
        //     $jr_total = $this->input->post('total_jr');

        //     $id = $this->input->post("nofaktur");
        //     $total = $this->input->post('total');
        //     $txtCOA1 = $this->input->post('txtCOA');
        //     $stsDP = $this->input->post("stsDP");
        //     if ($stsDP == "DP") {
        //         $status_dp = 1;
        //     } else {
        //         $status_dp = 0;
        //     }
        //     $this->M_Receivable_recognition->delete_gst_lama($nofaktur);
        //     $this->M_Receivable_recognition->delete_jurnal_lama($nofaktur);
        //     $x = $this->input->post('DetailID');
        //     //update data detail

        //     $Uraian1= $txtItem1[0];

        //     for ($x = 0; $x < count($this->input->post('Detail_item_id')); $x++) {
        //         $det_item1 = array(
        //             'HeaderID' => $nofaktur,
        //             'Jenis' => '1',
        //             'NoCOA' => $txtCOA1[$x],
        //             'no_po' => $txtNoPO1[$x],
        //             'Items' => $txtItem1[$x],
        //             'Qty' => number_format(str_replace(",", "", $txtQty1[$x]), 2, ".", ""),
        //             'currency' => $this->input->post('Currency'),
        //             'rate' => $txtRate1,
        //             'unit' => $txtUnit1[$x],
        //             'Harga' => number_format(str_replace(",", "", $txtPrice1[$x]), 4, ".", ""),
        //             'total_inv' => number_format(str_replace(",", "",$nota_debet1), 2, ".", ""),
        //             'gst_type' => $txtGST1[$x],
        //             'gst_value' => number_format(str_replace(",", "", $txtGSTValue1[$x]), 2, ".", ""),
        //             'created_by' => $created_by,
        //             'created_date' => $created_date,
        //             'ip_address' => $ip_address,
        //         );
        //         if ($g[$x] > 0) {
        //             $this->M_Receivable_recognition->update_pr($g[$x], $det_item1);
        //         } else {

        //             $this->M_Receivable_recognition->simpan_pr($det_item1);
        //         }

        //         $gst_item = array(
        //             'ref_nomor' => $nofaktur,
        //             'jenis_trans' => 'RRG',
        //             'item' => $txtItem1[$x],
        //             'qty' => number_format(str_replace(",", "", $txtQty1[$x]), 2, ".", ""),
        //             'gst_type' => $txtGST1[$x],
        //             'gst_value' => number_format(str_replace(",", "", $txtGSTValue1[$x]), 2, ".", ""),
        //             'unit' => $txtUnit1[$x],
        //             'price' => number_format(str_replace(",", "", $txtPrice1[$x]), 4, ".", ""),
        //             'currency' => $this->input->post('Currency'),
        //             'rate' => $txtRate1,
        //             'rate_sgd' => $rate_sgd,
        //             'created_by' => $created_by,
        //             'created_date' => $created_date,
        //             'ip_address' => $ip_address,
        //         );

        //         if ($txtGST1[$x] <> "") {
        //             $this->M_Receivable_recognition->simpan_gst_payable($gst_item);
        //         }
        //     }

        //     // Jurnal Footer
        //     for ($d = 1; $d < count($this->input->post('DetailID')); $d++) {
        //         if ($jr_nocoa[$d] <> "") {
        //             $sub_account_id = $supplier;
        //         } else {
        //             $sub_account_id = "";
        //         }

        //         $jr_total[$d]=str_replace(",", "",$jr_total[$d]);

        //         if ($dk[$d] == 'D') {
        //             $debet = $jr_total[$d] * $rate_jr1[$d];
        //             $debet_sgd = $jr_total[$d] * $rate_sgd;
        //             $credit = '0';
        //             $credit_sgd = '0';
        //             $sum_debet += number_format(str_replace(",", "", $debet),2, ".", "");
        //             $sum_debet_sgd += number_format(str_replace(",", "", $debet_sgd),2, ".", "");
        //         } elseif ($dk[$d] == 'C') {
        //             $debet = '0';
        //             $debet_sgd = '0';
        //             $credit = $jr_total[$d] * $rate_jr1[$d];
        //             $credit_sgd = $jr_total[$d] * $rate_sgd;
        //             $sum_credit += number_format(str_replace(",", "", $credit),2, ".", "");
        //             $sum_credit_sgd += number_format(str_replace(",", "", $credit_sgd),2, ".", "");
        //         }

        //         $det_jur1 = array(
        //             'JenisJurnalID' => $jr_jenisjurnal[$d],
        //             'NoUrut' => $jr_NoUrut[$d],
        //             'CompanyID' => 'PSS',
        //             'jenis_trans' => 'RRG',
        //             'Tanggal' => $p_tanggal,
        //             'Periode' => $Periode,
        //             'NoJurnal' => $nofaktur,
        //             'chk' => $dk1[$d],
        //             'NoCOA' => substr($jr_nocoa1[$d], 0, 6),
        //             'sub_account_id' => $sub_account_id,
        //             'sub_account_type' => $SubAccountId[$d],
        //             'Uraian' => $Uraian1,
        //             'Debet' => number_format(str_replace(",", "", $debet), 2, ".", ""),
        //             'Kredit' => number_format(str_replace(",", "", $credit), 2, ".", ""),
        //             'Debet_SGD' => number_format(str_replace(",", "", $debet_sgd), 2, ".", ""),
        //             'Kredit_SGD' => number_format(str_replace(",", "", $credit_sgd), 2, ".", ""),
        //             'Total' => number_format(str_replace(",", "", $jr_total[$d]), 2, ".", ""),
        //             'Currency' => $this->input->post('Currency'),
        //             'Rate' => $rate_jr1[$d],
        //             'rate_sgd' => $rate_sgd,
        //             'TotalAsal' => number_format(str_replace(",", "", $jr_total[$d]), 4, ".", ""),
        //             'CurrencyAsal' => $this->input->post('Currency'),
        //             'RateAsal' => $rate_awal,
        //             'Keterangan' => '-',
        //             'created_by' => $this->session->userdata('userid_1'),
        //             'created_date' => date('Y-m-d H:i:s'),
        //             'last_update_by' => $last_update_by,
        //             'last_update_date' => $last_update_date,
        //             'ip_address' => $ip_address,
        //         );

        //         if ($jr_total[$d] <> 0){
        //          $this->M_Receivable_recognition->simpan_jurnal($det_jur1);
        //      }
        //     }

        //     //$this->M_Receivable_recognition->hapus_COA_kosong();


        //     for ($p = 0; $p < count($this->input->post('Detail_item_id')); $p++) {
        //         $txtQty1[$p]=str_replace(",", "",$txtQty1[$p]);
        //         $txtPrice1[$p]=str_replace(",", "",$txtPrice1[$p]);

        //         $credit2 = ($txtQty1[$p] * $txtPrice1[$p]) * $rate;
        //         $credit_sgd2 = ($txtQty1[$p] * $txtPrice1[$p]) * $rate_sgd;

        //         $sum_credit += number_format(str_replace(",", "", $credit2), 2, ".", "");
        //         $sum_credit_sgd += number_format(str_replace(",", "", $credit_sgd2), 2, ".", "");

        //         if ((count($this->input->post('Detail_item_id')) - 1) == $p){
        //             $selisih = $sum_debet - $sum_credit;

        //             if ($selisih != 0){
        //                 $credit2 = $credit2 + $selisih;
        //             }

        //             $selisih_sgd = $sum_debet_sgd - $sum_credit_sgd;

        //             if ($selisih_sgd != 0){
        //                 $credit_sgd2 = $credit_sgd2 + $selisih_sgd;
        //             }
        //         }

        //         $detail_jur1 = array(
        //             'JenisJurnalID' => 'AR/GL',
        //             'NoUrut' => $jr_NoUrut[$p],
        //             'CompanyID' => 'PSS',
        //             'jenis_trans' => 'RRG',
        //             'Tanggal' => $p_tanggal,
        //             'Periode' => $Periode,
        //             'NoJurnal' => $nofaktur,
        //             'chk' => 'C',
        //             'NoCOA' => $txtCOA1[$p],
        //             'sub_account_id' => '',
        //             'sub_account_type' => '',
        //             'gst_type' => $txtGST1[$p],
        //             'gst_value' => number_format(str_replace(",", "", $txtGSTValue1[$p]), 2, ".", ""),
        //             'Uraian' => $txtItem1[$p],
        //             'Debet' => '0',
        //             'Kredit' => number_format(str_replace(",", "", $credit2), 2, ".", ""),
        //             'Debet_SGD' => '0',
        //             'Kredit_SGD' => number_format(str_replace(",", "", $credit_sgd2), 2, ".", ""),
        //             'Total' => number_format(str_replace(",", "",$txtQty1[$p] * $txtPrice1[$p]), 2, ".", ""),
        //             'Currency' => $this->input->post('Currency'),
        //             'Rate' => $rate,
        //             'rate_sgd' => $rate_sgd,
        //             'TotalAsal' => number_format(str_replace(",", "",$p_hutang), 4, ".", ""),
        //             'CurrencyAsal' => $this->input->post('Currency'),
        //             'RateAsal' => $rate_awal,
        //             'Keterangan' => '-',
        //             'created_by' => $this->session->userdata('userid_1'),
        //             'created_date' => date('Y-m-d H:i:s'),
        //             'last_update_by' => $last_update_by,
        //             'last_update_date' => $last_update_date,
        //             'ip_address' => $ip_address,
        //         );
        //         $this->M_Receivable_recognition->simpan_jurnal($detail_jur1);
        //     }
        //     //deposit
        //     $txtNoCOA = $this->input->post("no_coa");
        //     $txtNameCOA = $this->input->post('JenisJurnal');
        //     $txtDebit = $this->input->post('debt_jr');
        //     $txtCredit = $this->input->post('credit_jr');
        //     $txtRemark = $this->input->post('desc');
        //     $txtGSTname = "";
        //     $txtGSTvalue = "0";

        //     // update tabel dp
        //     $detail_dp_id = $this->input->post("detail_dp_id");
        //     $header_dp = $this->input->post("header_dp_id");
        //     $bayar_dp = $this->input->post("bayar_dp");
        //     $po_dp_id = $this->input->post("po_dp_id");

        //     for ($f = 0; $f < count($this->input->post('detail_dp_id')); $f++) {
        //         $this->M_Receivable_recognition->update_dp_ar($detail_dp_id[$f], $bayar_dp[$f]);
        //     }

        //     //insert tbl dp history
        //     for ($g = 0; $g < count($this->input->post('detail_dp_id')); $g++) {
        //         $data_his = array(
        //             "header_id" => $header_dp[$g],
        //             "no_facture" => $po_dp_id[$g],
        //             "trans_type" => "AR",
        //             "date1" => $tgl_jurnal,
        //             "cb_code" => "I",
        //             "no_voucher" => $nofaktur,
        //             "from_to" => $supplier,
        //             "trans_description" => "Withdrawal of deposits from AP Transactions.",
        //             "prepaid" => 1,
        //             "supplier" => $supplier,
        //             "coa_supplier" => $this->input->post('no_coa[5]'),
        //             "currency_id" => $this->input->post('Currency'),
        //             "currency_rate" => $rate,
        //             "coa_code" => '140401',
        //             "coa_description" => "Deposit vor Vendor",
        //             "debit_credit" => "C",
        //             "jumlah" => $bayar_dp[$g],
        //             "debit" => 0,
        //             "credit" => $bayar_dp[$g],
        //             "remark" => "-",
        //             "key_cf" => "0",
        //             "created_by" => $this->session->userdata('userid_1')
        //         );
        //         $this->M_Receivable_recognition->insertCBhistoryx($data_his);
        //     }

        //     // $this->M_Receivable_recognition->hapus_COA_kosong();

        //     $rate_sgd1 = $this->input->post('rate_sgd');
        //     $total1 = $this->input->post('total_jr');
        //     $p_pajak = $total1[2];
        //     $p_diskon = $total1[1];
        //     $p_biaya_lain = $total1[3];
        //     $p_uang_muka = $total1[4];
        //     $p_hutang = $total1[5];
        //     $data = array('p_perintah' => 'edit',
        //         'p_nofaktur' => $nofaktur,
        //         'p_tanggal' => $p_tanggal,
        //         'p_tanggal_tempo' => $p_tanggal_tempo,
        //         'p_tanggal_invoice' => $p_tanggal_invoice,
        //         'p_term' => $term,
        //         'p_kode_sup' => $supplier,
        //         'p_jenis_trans' => 'RRG',
        //         'p_currency_id' => $this->input->post('Currency'),
        //         'p_rate' => $rate,
        //         'p_pajak' => number_format(str_replace(",", "",$p_pajak),2, ".", ""),
        //         'p_diskon' => number_format(str_replace(",", "",$p_diskon),2, ".", ""),
        //         'p_biaya_lain' => number_format(str_replace(",", "", $p_biaya_lain), 2, ".", ""),
        //         'p_uang_muka' => number_format(str_replace(",", "", $p_uang_muka), 2, ".", ""),
        //         'p_piutang' => number_format(str_replace(",", "", $p_hutang), 2, ".", ""),
        //         'p_created_by' => $created_by,
        //         'p_ip_address' => $ip_address,
        //         'p_rate_sgd' => $rate_sgd,
        //         'p_nocoa' => $NoCOA,
        //         'p_status_dp' => $status_dp
        //     );
        //     $this->M_Receivable_recognition->call_sp_rec_piutang($data);
        // }

        // $this->session->set_flashdata('message', pesan("The transaction has been successfully saved with the Invoice Number : $nofaktur", pesan_info()));
        // redirect("Receivable_recognition/edit?id=$nofaktur");
    }

    function delete()
    {
        $id         = $this->input->get("id");
        $idj        = $this->input->get("idjurnal");
        $nofaktur   = $this->input->get("nofaktur");
        $this->M_Receivable_recognition->delete_item($id);
        $this->M_Receivable_recognition->delete_jurnal($idj);
        redirect("Receivable_recognition/edit?id=$nofaktur");
    }

    function cek_tabel_ar()
    {
        $id = $this->input->get("id");
        $data['select_hutang'] = $this->M_Receivable_recognition->nota($id);
        $this->load->view('accounting/validasi', $data);
    }

    function hapus()
    {
        $id = $this->input->get("id");
        $nofaktur = $this->input->get("nofaktur");
        $this->M_Receivable_recognition->delete_jurnal($id);
        redirect("Receivable_recognition/edit?id=$nofaktur");
    }

    function delete_transaction()
    {
        $id = $this->input->get("id");
        $this->M_Receivable_recognition->delete_piutang($id);
        redirect("Receivable_recognition");
    }

    function selectInvoiceReceivable()
    {
        $data   = array(
            '_selectHeader' => $this->M_Receivable_recognition->selectInvoiceforFindRR()->result()
        );
        $this->load->view('accounting/Receivable_recognition/FindRR/selectIRR', $data);
    }
}
