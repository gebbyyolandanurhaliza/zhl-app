<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Payable_recognition extends CI_Controller
{

    function __construct()
    {
        parent::__construct();

        $this->load->model(array('M_Payable_recognition','M_General_Journal', 'M_login', 'M_vcdn'));
        $this->load->library(array('template', 'user_agent'));

        if (!$this->session->userdata('userid_1')) {
            redirect('login');
        }
    }

    public function index()
    {
        $data['SupplierID']     = $this->M_Payable_recognition->get_sup();
        $data['title']          = "List of Receivable Recognition";
        $data['List_payable']   = $this->M_Payable_recognition->get_list_hutang();
        $this->template->display('accounting/payable_recognition/payable_recognition_list', $data);
    }

    function get_currency_date()
    {
        $dari             = str_replace('/', '-', $this->input->get('tgl'));
        $sekarang         = date('Y-m-d', strtotime($dari));
        $data['Currency'] = $this->M_Payable_recognition->get_currency_date($sekarang);
        $this->load->view('accounting/list_currency_date', $data);
    }

    function ambil_currency()
    {
        $kurs = $this->input->get('kurs');
        $bln  = $this->input->get('bln');
        $thn  = $this->input->get('thn');
        $data['currency'] = $this->M_Payable_recognition->ambil_currency_date($kurs, $bln, $thn);
        $this->load->view('accounting/ajax/get_currency', $data);
    }

    function ambil_currency_old()
    {

        $data['currency'] = $this->M_Payable_recognition->tampil_po_rate($this->input->get('kurs'), $this->convert($this->input->get('date')));
        $this->load->view('accounting/ajax/get_currency', $data);
    }

    public function ambil_currency2()
    {
        $data['currency'] = $this->M_Payable_recognition->tampil_po_rate($this->input->get('kurs'), $this->convert($this->input->get('date')));
        $this->load->view('accounting/acc_filter_rate', $data);
    }

    function ambil_currency_cdn2()
    {
        $kurs     = $this->input->get('cur');
        $date1    = date('Y/m/d', strtotime($this->convert($this->input->get('date'))));
        $lastdate = date('Y/m/01', strtotime($this->convert($this->input->get('date'))));

        if ($date1 == $lastdate) {
            $data['date']     = date('Y/m', strtotime("+1 days", strtotime($this->convert($this->input->get('date')))));
            $data['newdate']  = date('Y/m', strtotime("-1 month", strtotime($this->convert($this->input->get('date')))));
            $data['currency'] = $this->M_Payable_recognition->tampil_po_rate($kurs, $this->convert($this->input->get('date')));
            $this->load->view('accounting/ajax/get_currency_cdn', $data);
        } else {
            $data['date']     = date('Y/m', strtotime("+2 days", strtotime($this->convert($this->input->get('date')))));
            $data['newdate']  = date('Y/m', strtotime("-1 months", strtotime($this->convert($this->input->get('date')))));
            $data['currency'] = $this->M_Payable_recognition->tampil_po_rate($kurs, $this->convert($this->input->get('date')));
            $this->load->view('accounting/ajax/get_currency_cdn', $data);
        }
    }

    function ambil_currency_cdn_old()
    {
        $data['currency'] = $this->M_Payable_recognition->tampil_po_rate($this->input->get('cur'), $this->convert($this->input->get('date')));
        $this->load->view('accounting/ajax/get_currency_cdn', $data);
    }
    function ambil_currency_cdn()
    {
        $kurs = $this->input->get('kurs');
        $bln  = $this->input->get('bln');
        $thn  = $this->input->get('thn');
        $data['currency'] = $this->M_Payable_recognition->ambil_currency_date($kurs, $bln, $thn);
        $this->load->view('accounting/ajax/get_currency_cdn', $data);
    }

    public function convert($date)
    {
        $explode = explode("/", $date);

        $time = $explode[2] . '/' . $explode[1] . '/' . $explode[0];

        return $time;
    }

    function search()
    {
        $data['SupplierID'] = $this->M_Payable_recognition->get_sup();
        $invoice            = $this->input->get("invoice");

        $dari   = str_replace('/', '-', $this->input->get('dari'));
        $p_dari = date('Y-m-d', strtotime($dari));

        $sampai   = str_replace('/', '-', $this->input->get("sampai"));
        $p_sampai = date('Y-m-d', strtotime($sampai));
        $supplier = $this->input->get("supplier");
        $data['tgl'] = $dari;
        if ($dari != '') {
            $data['List_payable'] = $this->M_Payable_recognition->advance_list_hutang($p_dari, $p_sampai, $invoice, $supplier);
        } else {
            $data['List_payable'] = $this->M_Payable_recognition->advance_list_hutang1($invoice, $supplier);
        }
        $this->template->display('accounting/payable_recognition/payable_recognition_list', $data);
    }

    function add_new()
    {
        $company   = strtoupper($this->session->userdata('company_id'));
        $data['SupplierID'] = $this->M_Payable_recognition->get_customer();
        $data['SupplierIDNew'] = $this->M_Payable_recognition->get_customernew();
        $data['Currency']   = $this->M_Payable_recognition->get_currency();
        $data['jenisinv']   = $this->M_Payable_recognition->get_jeninv();
        $data['List_coa']   = $this->M_vcdn->get_coa($company);
        $close_date         = $this->M_login->ambil_tgl()->row();
        $data['closing']    = date_format(date_create($close_date->tanggal), "d/m/Y");
        $data['dept_code'] = $this->M_General_Journal->get_departmentcode();
        $data['dept_code_json'] = json_encode($data['dept_code']);
        // $data['listbarge'] = $this->M_Payable_recognition->getbarge();
        // $data['listcarrier'] = $this->M_Payable_recognition->getcarrier();
        $data['message']    = $this->session->flashdata('message');

        $this->template->display('accounting/payable_recognition/payable_recognition_form', $data);
    }

    function edit()
    {
        $company   = strtoupper($this->session->userdata('company_id'));
        $data['SupplierID'] = $this->M_Payable_recognition->get_customer();
        $data['SupplierIDNew'] = $this->M_Payable_recognition->get_customernew();
        $data['Currency']   = $this->M_Payable_recognition->get_currency();
        $data['message']    = $this->session->flashdata('message');
        $data['CurrencyID'] = $this->M_Payable_recognition->get_currency_detail();
        $data['List_coa']   = $this->M_vcdn->get_coa($company);
        // $data['listbarge'] = $this->M_Payable_recognition->getbarge();
        // $data['listcarrier'] = $this->M_Payable_recognition->getcarrier();
        $data['jenisinv']   = $this->M_Payable_recognition->get_jeninv();
        $id                 = $this->input->get("id");

        $close_date         = $this->M_login->ambil_tgl()->row();
        $data['closing']    = date_format(date_create($close_date->tanggal), "d/m/Y");

        //variable invoice number header
        $data['HeaderID']        = $id;
        $data['get_data_header'] = $this->M_Payable_recognition->get_data_header($id);
        $data['nota']            = $this->M_Payable_recognition->nota($id);
        //variable invoice number detail
        $data['get_data_detail'] = $this->M_Payable_recognition->get_data_detail($id);
        // var_dump($data['get_data_detail']);
        // die;
        //variable invoice number footer
        $data['get_data_footer'] = $this->M_Payable_recognition->get_data_footer($id);

        $data['get_data_jurnal1'] = $this->M_Payable_recognition->get_data_awal($id, 'AP/GL');
        $data['get_data_jurnal2'] = $this->M_Payable_recognition->get_data_jurnal(2, $id, 'PRG');
        $data['get_data_jurnal3'] = $this->M_Payable_recognition->get_data_jurnal(3, $id, 'PRG');
        $data['get_data_jurnal4'] = $this->M_Payable_recognition->get_data_jurnal(4, $id, 'PRG');
        $data['get_data_jurnal5'] = $this->M_Payable_recognition->get_data_jurnal(5, $id, 'PRG');
        $data['get_data_jurnal6'] = $this->M_Payable_recognition->get_data_jurnal(6, $id, 'PRG');


        $data['data_bawah'] = $this->M_Payable_recognition->data_paling_bawah($id);

        if (!empty($data['data_bawah'])) {
            $this->template->display('accounting/payable_recognition/payable_recognition_form', $data);
        } else {
            $data['SupplierID']   = $this->M_Payable_recognition->get_sup();
            $data['title']        = "List of Receivable Recognition";
            $data['List_payable'] = $this->M_Payable_recognition->get_list_hutang();
            $this->template->display('accounting/payable_recognition/payable_recognition_list', $data);
        }
    }

    function print_report()
    {
        $data['SupplierID'] = $this->M_Payable_recognition->get_customer();
        $data['Currency']   = $this->M_Payable_recognition->get_currency();
        $data['CurrencyID'] = $this->M_Payable_recognition->get_currency_detail();
        //cari nota debet, berdasarkan total seluruh transaksi "Bayar"
        $id = $this->input->get("id");

        //variable invoice number header
        $data['HeaderID']   = $id;
        $data['titel']      = 'Payable Recognition';
        $data['nota']       = $this->M_Payable_recognition->nota($id);
        $data['get_data_header'] = $this->M_Payable_recognition->get_data_header($id);
        //variable invoice number detail
        $data['get_data_detail'] = $this->M_Payable_recognition->get_data_detail($id);
        //variable invoice number footer
        $data['get_data_footer'] = $this->M_Payable_recognition->get_data_footer($id);

        $this->load->view('accounting/rpt/rpt_receivable_recognition', $data);
    }

    function list_currency()
    {
        $data['Currency'] = $this->M_Payable_recognition->get_currency_detail();
        $this->load->view('accounting/list_currency', $data);
    }

    function list_payable()
    {
        $id = $this->input->get("id");

        //variable invoice number header
        $this->M_Payable_recognition->get_data_header($id);
    }

    function save_payable_rec()
    {
        $nofaktur   = $this->input->post('nofaktur');
        $company_id = 'PSS';

        $tgl_jurnal = str_replace('/', '-', $this->input->post('tgl_jurnal'));
        $p_tanggal  = date('Y-m-d', strtotime($tgl_jurnal));

        $tgl_tempo          = str_replace('/', '-', $this->input->post('tgl_tempo'));
        $p_tanggal_tempo    = date('Y-m-d', strtotime($tgl_tempo));
        $tgl_invoice        = str_replace('/', '-', $this->input->post('tgl_invoice'));
        $p_tanggal_invoice  = date('Y-m-d', strtotime($tgl_invoice));
        $supplier           = $this->input->post('supplier');
        $JenisJurnal        = $this->input->post('txtUnit');
        $jenis_trans        = 'PRG';
        $currencyid         = $this->input->post('Currency');
        $currency           = $this->input->post('Currency');
        $rate               = $this->input->post('rate_header');
        $rate_awal          = $this->input->post('rate_header');
        $rate_akhir         = $this->input->post('rate_header');
        $term               = $this->input->post('term');
        $total              = $this->input->post('total_jr');
        $jenis_inv          = $this->input->post('jeninv');
        $tgl_ship           = str_replace('/', '-', $this->input->post('shipdate'));
        $ship_date          = date('Y-m-d', strtotime($tgl_jurnal));

        $p_pajak            = $total[2];
        $p_diskon           = $total[1];
        $p_biaya_lain       = $total[3];
        $p_uang_muka        = $total[4];
        $p_hutang           = $total[5];
        if ($this->session->userdata('userid_1') == 'ozzy') {
            $created_by     = 'System';
            $last_update_by = 'System';
        } else {
            $created_by     = $this->session->userdata('userid_1');
            $last_update_by = $this->session->userdata('userid_1');
        }

        $created_date       = date('Y-m-d');
        $last_update_date   = date('Y-m-d');
        $ip_address         = $_SERVER['REMOTE_ADDR'];
        $submit_value       = $this->input->post('sbt');
        $NoCOA              = $this->input->post('NoCOA');

        $cek                = $this->input->post('chk');
        $id                 = $this->input->post('Detail_ID');
        $Periode            = date('mY', strtotime($tgl_jurnal));
        $status             = '2';
        $rate_sgd           = $this->input->post('rate_sgd');
        $rate_sgd_nego      = $this->input->post('rate_sgd_nego');
        $jr_nocoa           = $this->input->post('no_coa');
        $jr_jenisjurnal     = $this->input->post('JenisJurnal');
        $jr_desc            = $this->input->post('desc');
        $rate_jr            = $this->input->post('rate_jr');
        $jr_total           = $this->input->post('total_jr');
        $jr_NoUrut          = $this->input->post('NoUrut');
        $txtGSTValue        = $this->input->post('txtGSTValue');
        $jr_deptcode    = $this->input->post('dept_code');

        $this->M_Payable_recognition->delete_hutang($nofaktur);

        $sum_debet      = 0;
        $sum_credit     = 0;
        $sum_debet_sgd  = 0;
        $sum_credit_sgd = 0;

        // if ($submit_value == 'Save') {
        $txtItem        = $this->input->post('txtItem');
        $txtBlCode      = $this->input->post('txtBlCode');
        $txtAmount      = $this->input->post('txtAmount');
        $txtQty         = $this->input->post('txtQty');
        $txtCOA         = $this->input->post('txtCOA');
        $txtUnit        = $this->input->post('txtUnit');
        $txtPrice       = $this->input->post('txtPrice');
        $txtRate        = $this->input->post('txtRate');
        $txtSGD         = $this->input->post('txtSGD');
        $txtNoPO        = $this->input->post('Detail_po');
        $txtGST         = $this->input->post('txtGST');
        $SubAccountId   = $this->input->post('SubAccountId');
        $dk             = $this->input->post('dk');
        $txtdept        = $this->input->post('txtdept');
        $Uraian         = $txtItem[0];
        for ($i = 0; $i < count($this->input->post('Detail_item_id')); $i++) {
            $det_item = array(
                'HeaderID'  => $nofaktur,
                'Jenis'     => 'PRG',
                'NoCOA'     => $txtCOA[$i],
                'no_po'     => $txtNoPO[$i],
                'Items'     => $txtItem[$i],
                'Qty'       => number_format(str_replace(",", "", $txtQty[$i]), 2, ".", ""),
                'currency'  => $currencyid,
                'rate'      => $rate,
                'rate_sgd'  => $rate_sgd,
                'rate_sgd_nego' => $rate_sgd_nego,
                'Unit'      => $txtUnit[$i],
                'Harga'     => number_format(str_replace(",", "", $txtPrice[$i]), 4, ".", ""),
                'gst_type'  => $txtGST[$i],
                'gst_value' => number_format(str_replace(",", "", $this->input->post('txtGSTValue')[$i]), 2, ".", ""),
                'created_by'    => $created_by,
                'created_date'  => $created_date,
                'ip_address'    => $ip_address,
                'dept_code' => trim($txtdept[$i]),
                'blCode'     => trim($txtBlCode[$i]),
                'amountPR'   => $txtAmount[$i],
            );
            $this->M_Payable_recognition->simpan_pr($det_item);


            $gst_item = array(
                'ref_nomor'     => $nofaktur,
                'jenis_trans'   => 'PRG',
                'item'          => $txtItem[$i],
                'qty'           => number_format(str_replace(",", "", $txtQty[$i]), 2, ".", ""),
                'gst_type'      => $txtGST[$i],
                'gst_value'     => number_format(str_replace(",", "", $this->input->post('txtGSTValue')[$i]), 2, ".", ""),
                'unit'          => $txtUnit[$i],
                'price'         => number_format(str_replace(",", "", $txtPrice[$i]), 4, ".", ""),
                'currency'      => $currency,
                'rate'          => $rate,
                'rate_sgd'      => $rate_sgd_nego,
                'created_by'    => $created_by,
                'created_date'  => $created_date,
                'ip_address'    => $ip_address,
            );
            if ($txtGST[$i] <> "") {
                $this->M_Payable_recognition->simpan_gst_payable($gst_item);
            }
        }

        //array footer jurnal
        for ($a = 1; $a < count($this->input->post('dk')); $a++) {
            if ($jr_nocoa[$a] <> "" and $jr_NoUrut[$a] <> 0) {
                $sub_account_id = $supplier;
            } else {
                $sub_account_id = "";
            }
            $jr_total[$a]       = str_replace(",", "", $jr_total[$a]);

            if ($dk[$a] == 'D') {
                $debet          = $jr_total[$a] * $rate_jr[$a];
                $debet_sgd      = $jr_total[$a] * $rate_sgd_nego;
                $credit         = '0';
                $credit_sgd     = '0';
                $sum_debet      += number_format(str_replace(",", "", $debet), 2, ".", "");
                $sum_debet_sgd  += number_format(str_replace(",", "", $debet_sgd), 2, ".", "");
            } elseif ($dk[$a] == 'C') {
                $debet          = '0';
                $debet_sgd      = '0';
                $credit         = $jr_total[$a] * $rate_jr[$a];
                $credit_sgd     = $jr_total[$a] * $rate_sgd_nego;
                $sum_credit     += number_format(str_replace(",", "", $credit), 2, ".", "");
                $sum_credit_sgd += number_format(str_replace(",", "", $credit_sgd), 2, ".", "");
            }

            $det_jur = array(
                'JenisJurnalID' => $jr_jenisjurnal[$a],
                'NoUrut'        => $jr_NoUrut[$a],
                'CompanyID'     => 'ZHL',
                'jenis_trans'   => 'PRG',
                'Tanggal'       => $p_tanggal,
                'Periode'       => $Periode,
                'NoJurnal'      => $nofaktur,
                'chk'           => $dk[$a],
                'NoCOA'         => substr($jr_nocoa[$a], 0, 6),
                'sub_account_id'    => $sub_account_id,
                'sub_account_type'  => $SubAccountId[$a],
                'Uraian'        => $Uraian,
                'Debet'         => number_format(str_replace(",", "", $debet), 2, ".", ""),
                'Kredit'        => number_format(str_replace(",", "", $credit), 2, ".", ""),
                'Debet_SGD'     => number_format(str_replace(",", "", $debet_sgd), 2, ".", ""),
                'Kredit_SGD'    => number_format(str_replace(",", "", $credit_sgd), 2, ".", ""),
                'Total'         => number_format(str_replace(",", "", $jr_total[$a]), 2, ".", ""),
                'Currency'      => $currencyid,
                'Rate'          => $rate_jr[$a],
                'rate_sgd'      => $rate_sgd_nego,
                'TotalAsal'     => number_format(str_replace(",", "", $jr_total[$a]), 4, ".", ""),
                'CurrencyAsal'  => $currencyid,
                'RateAsal'      => $rate_awal,
                'Keterangan'    => '-',
                'created_by'    => $created_by,
                'created_date'  => $created_date,
                'last_update_by'  => $last_update_by,
                'last_update_date'=> $last_update_date,
                'ip_address'    => $ip_address,
                'dept_code'     => $jr_deptcode[$a],
            );
            $this->M_Payable_recognition->simpan_jurnal($det_jur);
        }


        for ($i = 0; $i < count($this->input->post('Detail_item_id')); $i++) {
            $qty    = str_replace(",", "", $txtQty[$i]);
            $price  = str_replace(",", "", $txtPrice[$i]);

            if ($jr_nocoa[$i] <> "") {
                $sub_account_id = $supplier;
            } else {
                $sub_account_id = "";
            }

            $debet2         = ($qty * $price) * $rate;
            $debet_sgd2     = ($qty * $price) * $rate_sgd_nego;
            $sum_debet     += number_format(str_replace(",", "", $debet2), 2, ".", "");
            $sum_debet_sgd += number_format(str_replace(",", "", $debet_sgd2), 2, ".", "");

            if ((count($this->input->post('Detail_item_id')) - 1) == $p) {
                $selisih    = $sum_debet - $sum_credit;
                if ($selisih != 0) {
                    $debet2 = $debet2 - $selisih;
                }

                $selisih_sgd = $sum_debet_sgd - $sum_credit_sgd;
                if ($selisih_sgd != 0) {
                    $debet_sgd2 = $debet_sgd2 - $selisih_sgd;
                }
            }

            $detail_jur = array(
                'JenisJurnalID'     => 'AP/GL',
                'NoUrut'            => '0',
                'CompanyID'         => 'ZHL',
                'jenis_trans'       => 'PRG',
                'Tanggal'           => $p_tanggal,
                'Periode'           => $Periode,
                'NoJurnal'          => $nofaktur,
                'chk'               => 'D',
                'NoCOA'             => $txtCOA[$i],
                'sub_account_id'    => $sub_account_id,
                'sub_account_type'  => '',
                'gst_type'          => $txtGST[$i],
                'gst_value'         => number_format(str_replace(",", "", $this->input->post('txtGSTValue')[$i]), 2, ".", ""),
                'Uraian'            => $txtItem[$i],
                'Debet'             => number_format(str_replace(",", "", $debet2), 2, ".", ""),
                'Kredit'            => '0',
                'Debet_SGD'         => number_format(str_replace(",", "", $debet_sgd2), 2, ".", ""),
                'Kredit_SGD'        => '0',
                'Total'             => number_format(str_replace(",", "", $qty * $price), 2, ".", ""),
                'Currency'          => $currencyid,
                'Rate'              => $rate,
                'rate_sgd'          => $rate_sgd_nego,
                'TotalAsal'         => number_format(str_replace(",", "", $p_hutang), 4, ".", ""),
                'CurrencyAsal'      => $currencyid,
                'RateAsal'          => $rate_awal,
                'Keterangan'        => '-',
                'created_by'        => $created_by,
                'created_date'      => $created_date,
                'last_update_by'    => $last_update_by,
                'last_update_date'  => $last_update_date,
                'ip_address'        => $ip_address,
                'dept_code'         => trim($txtdept[$i]),
                'blCode'            => trim($txtBlCode[$i]),
                'amountPR'         => $txtAmount[$i],
            );
            if ($txtCOA[$i] <> "") {
                $this->M_Payable_recognition->simpan_jurnal($detail_jur);
            }
        }

        $stsDP          = $this->input->post("stsDP");
        // update tabel dp
        $detail_dp_id   = $this->input->post("detail_dp_id");
        $header_dp      = $this->input->post("header_dp_id");
        $bayar_dp       = $this->input->post("bayar_dp");
        $po_dp_id       = $this->input->post("po_dp_id");

        for ($f = 0; $f < count($this->input->post('detail_dp_id')); $f++) {
            $this->M_Payable_recognition->update_dp($detail_dp_id[$f], $bayar_dp[$f]);
        }

        //insert tbl dp history
        for ($g = 0; $g < count($this->input->post('detail_dp_id')); $g++) {
            $data_his = array(
                "header_id"         => $header_dp[$g],
                "no_facture"        => $po_dp_id[$g],
                "trans_type"        => "AP",
                "date1"             => $p_tanggal,
                "cb_code"           => "I",
                "no_voucher"        => $nofaktur,
                "from_to"           => $supplier,
                "trans_description" => "Withdrawal of deposits from AP Transactions.",
                "prepaid"           => 1,
                "supplier"          => $supplier,
                "coa_supplier"      => $this->input->post('no_coa[5]'),
                "currency_id"       => $currencyid,
                "currency_rate"     => $rate,
                "coa_code"          => '140401',
                "coa_description"   => "Deposit vor Vendor",
                "debit_credit"      => "C",
                "jumlah"            => $bayar_dp[$g],
                "debit"             => 0,
                "credit"            => $bayar_dp[$g],
                "remark"            => "-",
                "key_cf"            => "0",
                "created_by"        => $this->session->userdata('userid_1')
            );
            $this->M_Payable_recognition->insertCBhistoryi($data_his);
        }

        if ($stsDP == "DP") {
            $status_dp = 1;
        } else {
            $status_dp = 0;
        }

        $this->M_Payable_recognition->hapus_COA_kosong();
        $data = array(
            'p_perintah'        => 'add',
            'p_nofaktur'        => $nofaktur,
            'p_company_id'      => 'ZHL',
            'p_tanggal'         => $p_tanggal,
            'p_tanggal_tempo'   => $p_tanggal_tempo,
            'p_tanggal_invoice' => $p_tanggal_invoice,
            'p_kode_sup'        => $supplier,
            'p_jenis_trans'     => $jenis_trans,
            'p_currency_id'     => $currencyid,
            'p_term'            => $term,
            'p_rate'            => $rate,
            'p_rate_sgd'        => $rate_sgd_nego,
            'p_pajak'           => number_format(str_replace(",", "", $p_pajak), 2, ".", ""),
            'p_diskon'          => number_format(str_replace(",", "", $p_diskon), 2, ".", ""),
            'p_biaya_lain'      => number_format(str_replace(",", "", $p_biaya_lain), 2, ".", ""),
            'p_uang_muka'       => number_format(str_replace(",", "", $p_uang_muka), 2, ".", ""),
            'p_hutang'          => number_format(str_replace(",", "", $p_hutang), 2, ".", ""),
            'p_status'          => '1',
            'p_created_by'      => $created_by,
            'p_ip_address'      => $ip_address,
            'p_nocoa'           => $NoCOA,
            'p_status_dp'       => $status_dp,
            'p_tglship'         => $ship_date,
            'p_jeninv'          => $jenis_inv
        );
        $this->M_Payable_recognition->call_sp_rec_hutang2($data);
        $this->session->set_flashdata('message', pesan("The transaction has been successfully saved with the Invoice Number : $nofaktur", pesan_info()));
        redirect("Payable_recognition/edit?id=$nofaktur");
        // } elseif ($submit_value == 'Update') {

        //     $z = $this->input->post('DetailID');

        //     $g = $this->input->post('Detail_item_id');
        //     $jr_nocoa1 = $this->input->post('no_coa');
        //     $rate_jr1 = $this->input->post('rate_jr');
        //     $jr_total1 = $this->input->post('total_jr');
        //     $dk1 = $this->input->post('dk');
        //     $txtItem1 = $this->input->post('txtItem');
        //     $txtQty1 = $this->input->post('txtQty');
        //     $txtUnit1 = $this->input->post('txtUnit');
        //     $rate_sgd1 = $this->input->post('rate_sgd');
        //     $txtPrice1 = $this->input->post('txtPrice');
        //     $txtRate1 = $this->input->post('rate_header');
        //     $txtRateSGD1 = $this->input->post('rate_sgd');
        //     $txtNoPO1 = $this->input->post('Detail_po');
        //     $SubAccountType = $this->input->post('SubAccountId');

        //     $txtGST1 = $this->input->post('txtGST');
        //     $txtGSTValue1 = $this->input->post('txtGSTValue');

        //     $id = $this->input->post("nofaktur");
        //     $total = $this->input->post('total');
        //     $txtCOA1 = $this->input->post('txtCOA');

        //     $this->M_Payable_recognition->delete_jurnal_lama($nofaktur);
        //     $this->M_Payable_recognition->delete_gst_lama($nofaktur);
        //     //update data detail
        //     for ($a = 1; $a < count($this->input->post('DetailID')); $a++) {
        //         if ($jr_nocoa[$a] <> "") {
        //             $sub_account_id = $supplier;
        //         } else {
        //             $sub_account_id = "";
        //         }

        //         $jr_total1[$a]=str_replace(",", "",$jr_total1[$a]);

        //         if ($dk1[$a] == 'D') {
        //             $debet1 = $jr_total1[$a] * $rate_jr1[$a];
        //             $debet_sgd1 = $jr_total1[$a] * $rate_sgd;
        //             $credit1 = '0';
        //             $credit_sgd1 = '0';
        //             $sum_debet += number_format(str_replace(",", "", $debet1),2, ".", "");
        //             $sum_debet_sgd += number_format(str_replace(",", "", $debet_sgd1),2, ".", "");
        //         } elseif ($dk1[$a] == 'C') {
        //             $debet1 = '0';
        //             $debet_sgd1 = '0';
        //             $credit1 = $jr_total1[$a] * $rate_jr1[$a]; 
        //             $credit_sgd1 = $jr_total1[$a] * $rate_sgd;
        //             $sum_credit += number_format(str_replace(",", "", $credit1),2, ".", "");
        //             $sum_credit_sgd += number_format(str_replace(",", "", $credit_sgd1),2, ".", "");
        //         }

        //         $det_jur1 = array(
        //             'JenisJurnalID' => $jr_jenisjurnal[$a],
        //             'NoUrut' => $jr_NoUrut[$a],
        //             'CompanyID' => 'PSS',
        //             'jenis_trans' => 'PRG',
        //             'Tanggal' => $p_tanggal,
        //             'Periode' => $Periode,
        //             'NoJurnal' => $nofaktur,
        //             'chk' => $dk1[$a],
        //             'NoCOA' => $jr_nocoa[$a],
        //             'sub_account_id' => $sub_account_id,
        //             'sub_account_type' => $SubAccountType[$a],
        //             'Uraian' => $Uraian,
        //             'Debet' => number_format(str_replace(",", "", $debet1),2, ".", ""),
        //             'Kredit' => number_format(str_replace(",", "", $credit1), 2, ".", ""),
        //             'Debet_SGD' => number_format(str_replace(",", "", $debet_sgd1), 2, ".", ""),
        //             'Kredit_SGD' => number_format(str_replace(",", "", $credit_sgd1), 2, ".", ""),
        //             'Total' => number_format(str_replace(",", "", $jr_total1[$a]), 2, ".", ""),
        //             'Currency' => $currencyid,
        //             'Rate' => $rate_jr1[$a],
        //             'rate_sgd' => $rate_sgd1,
        //             'TotalAsal' => number_format(str_replace(",", "", $jr_total1[$a]), 4, ".", ""),
        //             'CurrencyAsal' => $currencyid,
        //             'RateAsal' => $rate_awal,
        //             'Keterangan' => '-',
        //             'last_update_by' => $last_update_by,
        //             'last_update_date' => $last_update_date,
        //             'ip_address' => $ip_address,
        //         );
        //         if ($jr_total[$a] <> 0){
        //             $this->M_Payable_recognition->simpan_jurnal($det_jur1);
        //         }
        //     }


        //     for ($p = 0; $p < count($this->input->post('Detail_item_id')); $p++) {
        //         $qty = str_replace(",", "", $txtQty1[$p]);
        //         $price = str_replace(",", "", $txtPrice1[$p]);
        //         $debet2 = ($qty * $price) * $rate;
        //         $debet_sgd2 = ($qty * $price) * $rate_sgd;

        //         $sum_debet += number_format(str_replace(",", "", $debet2), 2, ".", "");
        //         $sum_debet_sgd += number_format(str_replace(",", "", $debet_sgd2), 2, ".", "");

        //         if ((count($this->input->post('Detail_item_id')) - 1) == $p){
        //             $selisih = $sum_debet - $sum_credit;

        //             if ($selisih != 0){
        //                 $debet2 = $debet2 - $selisih;
        //             }

        //             $selisih_sgd = $sum_debet_sgd - $sum_credit_sgd;

        //             if ($selisih_sgd != 0){
        //                 $debet_sgd2 = $debet_sgd2 - $selisih_sgd;
        //             }
        //         }

        //         $detail_jur1 = array(
        //             'JenisJurnalID' => 'AP/GL',
        //             'NoUrut' => '0',
        //             'CompanyID' => 'PSS',
        //             'jenis_trans' => 'PRG',
        //             'Tanggal' => $p_tanggal,
        //             'Periode' => $Periode,
        //             'NoJurnal' => $nofaktur,
        //             'chk' => 'D',
        //             'NoCOA' => $txtCOA1[$p],
        //             'sub_account_id' => '',
        //             'sub_account_type' => '',
        //             'gst_type' => $txtGST1[$p],
        //             'gst_value' => number_format(str_replace(",", "", $txtGSTValue1[$p]), 2, ".", ""),
        //             'Uraian' => $txtItem1[$p],
        //             'Debet' =>  number_format(str_replace(",", "", $debet2), 2, ".", ""),
        //             'Kredit' => '0',
        //             'Debet_SGD' =>  number_format(str_replace(",", "", $debet_sgd2), 2, ".", ""),
        //             'Kredit_SGD' => '0',
        //             'Total' => number_format(str_replace(",", "", ($qty * $price)), 2, ".", ""),
        //             'Currency' => $currencyid,
        //             'Rate' => $rate,
        //             'rate_sgd' => $rate_sgd1,
        //             'TotalAsal' => number_format(str_replace(",", "", $p_hutang), 4, ".", ""),
        //             'CurrencyAsal' => $currencyid,
        //             'RateAsal' => $rate_awal,
        //             'Keterangan' => '-',
        //             'last_update_by' => $last_update_by,
        //             'last_update_date' => $last_update_date,
        //             'ip_address' => $ip_address,
        //         );
        //         if ($txtCOA1[$p] <> "") {
        //             $this->M_Payable_recognition->simpan_jurnal($detail_jur1);
        //         }
        //     }
        //     $this->M_Payable_recognition->hapus_COA_kosong();



        //     for ($x = 0; $x < count($this->input->post('Detail_item_id')); $x++) {
        //         $det_item1 = array(
        //             'HeaderID' => $nofaktur,
        //             'Jenis' => '1',
        //             'NoCOA' => $txtCOA1[$x],
        //             'Items' => $txtItem1[$x],
        //             'Qty' => number_format(str_replace(",", "", $txtQty1[$x]), 2, ".", ""),
        //             'currency' => $currencyid,
        //             'rate' => $txtRate1,
        //             'rate_sgd' => $rate_sgd1,
        //             'unit' => $txtUnit1[$x],
        //             'Harga' => number_format(str_replace(",", "", $txtPrice1[$x]), 4, ".", ""),
        //             'gst_type' => $txtGST1[$x],
        //             'gst_value' => number_format(str_replace(",", "", $txtGSTValue1[$x]), 2, ".", ""),
        //             'updated_by' => $last_update_by,
        //             'updated_date' => $last_update_date,
        //             'ip_address' => $ip_address,
        //         );
        //         if ($g[$x] > 0) {
        //             $this->M_Payable_recognition->update_pr($g[$x], $det_item1);
        //         } else {

        //             $this->M_Payable_recognition->simpan_pr($det_item1);
        //         }

        //         $gst_item = array(
        //             'ref_nomor' => $nofaktur,
        //             'jenis_trans' => 'PRG',
        //             'item' => $txtItem1[$x],
        //             'qty' => number_format(str_replace(",", "", $txtQty1[$x]), 2, ".", ""),
        //             'gst_type' => $txtGST1[$x],
        //             'gst_value' => number_format(str_replace(",", "", $txtGSTValue1[$x]), 2, ".", ""),
        //             'unit' => $txtUnit1[$x],
        //             'price' => number_format(str_replace(",", "", $txtPrice1[$x]), 4, ".", ""),
        //             'currency' => $currencyid,
        //             'rate' => $txtRate1,
        //             'rate_sgd' => $rate_sgd1,
        //             'ip_address' => $ip_address,
        //         );

        //         if ($txtGST1[$x] <> "") {
        //             $this->M_Payable_recognition->simpan_gst_payable($gst_item);
        //         }
        //     }
        //     $this->M_Payable_recognition->hapus_COA_kosong();

        //     $total1 = $this->input->post('total_jr');
        //     $p_pajak = $total1[2];
        //     $p_diskon = $total1[1];
        //     $p_biaya_lain = $total1[3];
        //     $p_uang_muka = $total1[4];
        //     $p_hutang = $total1[5];
        //     $data = array('p_perintah' => 'edit',
        //         'p_nofaktur' => $nofaktur,
        //         'p_company_id' => 'PSS',
        //         'p_tanggal' => $p_tanggal,
        //         'p_tanggal_tempo' => $p_tanggal_tempo,
        //         'p_tanggal_invoice' => $p_tanggal_invoice,
        //         'p_kode_sup' => $supplier,
        //         'p_jenis_trans' => $jenis_trans,
        //         'p_currency_id' => $currencyid,
        //         'p_term' => $term,
        //         'p_rate' => $rate,
        //         'p_rate_sgd' => $rate_sgd1,
        //         'p_pajak' => number_format(str_replace(",", "",$p_pajak),2, ".", ""),
        //         'p_diskon' => number_format(str_replace(",", "",$p_diskon),2, ".", ""),
        //         'p_biaya_lain' => number_format(str_replace(",", "", $p_biaya_lain),2, ".", ""),
        //         'p_uang_muka' => number_format(str_replace(",", "", $p_uang_muka), 2, ".", ""),
        //         'p_piutang' => number_format(str_replace(",", "", $p_hutang), 2, ".", ""),
        //         'p_status' => '1',
        //         'p_created_by' => $created_by,
        //         'p_ip_address' => $ip_address,
        //         'p_nocoa' => $NoCOA,
        //         'p_status_dp' => $status_dp
        //     );
        //     $this->M_Payable_recognition->call_sp_rec_hutang($data);
        // }

        // $this->session->set_flashdata('message', pesan("The transaction has been successfully saved with the Invoice Number : $nofaktur", pesan_info()));
        // redirect("Payable_recognition/edit?id=$nofaktur");
    }

    function delete()
    {
        $id         = $this->input->get("id");
        $idj        = $this->input->get("idjurnal");
        $nofaktur   = $this->input->get("nofaktur");
        $this->M_Payable_recognition->delete_item($id);
        $this->M_Payable_recognition->delete_jurnal($idj);
        redirect("Payable_recognition/edit?id=$nofaktur");
    }

    function cek_tabel_ap()
    {
        $id                    = $this->input->get("id");
        $data['select_hutang'] = $this->M_Payable_recognition->nota($id);
        $this->load->view('accounting/validasi', $data);
    }

    function hapus()
    {
        $id       = $this->input->get("id");
        $nofaktur = $this->input->get("nofaktur");
        $this->M_Payable_recognition->delete_jurnal($id);
        redirect("Payable_recognition/edit?id=$nofaktur");
    }

    function delete_transaction()
    {
        $id         = $this->input->get("id");
        $this->M_Payable_recognition->delete_hutang($id);
        redirect("Payable_recognition");
    }

    function data_dp()
    {
        $id = $this->input->get("id");
        $currency = $this->input->get("currency");

        $data['pilih_dp'] = $this->M_Payable_recognition->pilih_dp($id, $currency);
        $this->load->view('accounting/list_dp', $data);
    }

    function peringatan()
    {
        $this->load->view('accounting/peringatan');
    }

    // ################################################################################
    // ################################################################################
    //
    // ########## Select Back Recorded Purchase Invoice Vendor ##########

    function selectInvoicePayable()
    {
        $data   = array(
            '_selectHeader' => $this->M_Payable_recognition->selectInvoiceforFindPR()->result()
        );
        $this->load->view('accounting/payable_recognition/FindPR/selectIPR', $data);
    }
}
