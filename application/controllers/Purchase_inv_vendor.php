
<?php

//update date : 3 Dec 16 10.21 PM
//Update By : deki

defined('BASEPATH') or exit('No direct script access allowed');

class Purchase_inv_vendor extends CI_Controller
{

    function __construct()
    {
        parent::__construct();

        $this->load->model(array('M_purchase_inv_vendor', 'M_Payable_recognition', 'M_vcdn', 'M_purchase_inv_factory'));
        $this->load->library(array('template', 'user_agent'));

        if (!$this->session->userdata('userid_1')) {
            redirect('login');
        }
    }

    public function index()
    {
        $data['SupplierID'] = $this->M_purchase_inv_vendor->get_sup();
        $data['title'] = "List of Receivable Recognition";
        $data['List_payable'] = $this->M_purchase_inv_vendor->get_list_hutang();
        $this->template->display('accounting/Purchase_inv_vendor/Purchase_inv_vendor_list', $data);
    }

    function search()
    {
        $data['SupplierID'] = $this->M_purchase_inv_vendor->get_sup();
        $invoice = $this->input->get("invoice");

        $dari = str_replace('/', '-', $this->input->get('dari'));
        $p_dari = date('Y-m-d', strtotime($dari));

        $sampai = str_replace('/', '-', $this->input->get("sampai"));
        $p_sampai = date('Y-m-d', strtotime($sampai));


        $supplier = $this->input->get("supplier");
        $data['tgl'] = $dari;
        if ($dari != '') {
            $data['List_payable'] = $this->M_purchase_inv_vendor->advance_list_hutang($p_dari, $p_sampai, $invoice, $supplier);
        } else {
            $data['List_payable'] = $this->M_purchase_inv_vendor->advance_list_hutang1($invoice, $supplier);
        }
        $this->template->display('accounting/Purchase_inv_vendor/Purchase_inv_vendor_list', $data);
    }

    function add_new()
    {
        $data['SupplierID'] = $this->M_purchase_inv_vendor->get_vendor_pur();
        $data['Currency'] = $this->M_purchase_inv_vendor->get_currency();
        $data['List_coa'] = $this->M_vcdn->get_coa_old();
        $data['message'] = $this->session->flashdata('message');

        $this->template->display('accounting/Purchase_inv_vendor/Purchase_inv_vendor_form', $data);
    }

    function get_coa()
    {
        // tangkap variabel keyword dari URL
        $keyword = $this->uri->segment(3);

        // cari di database
        $data = $this->db->from('acc_master_coa')->like('NoCOA', $keyword)->get();

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

    public function ambil_currency()
    {

        $data['currency'] = $this->M_purchase_inv_factory->tampil_po_rate($this->input->get('cur'), $this->convert($this->input->get('date')));
        $this->load->view('accounting/ajax/get_currency_gst', $data);
    }

    function tampil_po()
    {
        $supplier = $this->input->get("supplier");
        $currency = $this->input->get("currency");

        $data["list_po"] = $this->M_purchase_inv_vendor->tampil_po_list($supplier, $currency);
        // print_r($data);
        $this->load->view('accounting/ajax/tampil_po_vendor', $data);
    }

    function data_dp()
    {
        $id = $this->input->get("id");
        $currency = $this->input->get("currency");

        $data['pilih_dp'] = $this->M_purchase_inv_vendor->pilih_dp($id, $currency);
        $this->load->view('accounting/list_dp', $data);
    }

    function edit()
    {
        $data['SupplierID'] = $this->M_purchase_inv_vendor->get_customer();
        $data['Currency'] = $this->M_purchase_inv_vendor->get_currency();
        $data['message'] = $this->session->flashdata('message');
        $data['CurrencyID'] = $this->M_purchase_inv_vendor->get_currency_detail();
        $data['List_coa'] = $this->M_vcdn->get_coa();
        $id = $this->input->get("id");

        //variable invoice number header
        $data['HeaderID'] = $id;
        $data['get_data_header'] = $this->M_purchase_inv_vendor->get_data_header($id);
        $data['nota'] = $this->M_purchase_inv_vendor->nota($id);
        //variable invoice number detail
        $data['get_data_detail'] = $this->M_purchase_inv_vendor->get_data_detail($id);
        //variable invoice number footer
        $data['get_data_footer'] = $this->M_purchase_inv_vendor->get_data_footer($id);

        $data['get_data_jurnal1'] = $this->M_purchase_inv_vendor->get_data_jurnal(1, $id, 'PIJP');
        $data['get_data_jurnal2'] = $this->M_purchase_inv_vendor->get_data_jurnal(2, $id, 'PIJP');
        $data['get_data_jurnal3'] = $this->M_purchase_inv_vendor->get_data_jurnal(3, $id, 'PIJP');
        $data['get_data_jurnal4'] = $this->M_purchase_inv_vendor->get_data_jurnal(4, $id, 'PIJP');
        $data['get_data_jurnal5'] = $this->M_purchase_inv_vendor->get_data_jurnal(5, $id, 'PIJP');
        $data['get_data_jurnal6'] = $this->M_purchase_inv_vendor->get_data_jurnal(6, $id, 'PIJP');


        $data['data_bawah'] = $this->M_purchase_inv_vendor->data_paling_bawah($id);

        $this->template->display('accounting/Purchase_inv_vendor/Purchase_inv_vendor_form', $data);
    }

    function print_report()
    {
        $data['SupplierID'] = $this->M_purchase_inv_vendor->get_customer();
        $data['Currency'] = $this->M_purchase_inv_vendor->get_currency();
        $data['CurrencyID'] = $this->M_purchase_inv_vendor->get_currency_detail();
        //cari nota debet, berdasarkan total seluruh transaksi "Bayar"
        $id = $this->input->get("id");

        //variable invoice number header
        $data['HeaderID'] = $id;
        $data['titel'] = 'Payable Recognition';
        $data['nota'] = $this->M_purchase_inv_vendor->nota($id);
        $data['get_data_header'] = $this->M_purchase_inv_vendor->get_data_header($id);
        //variable invoice number detail
        $data['get_data_detail'] = $this->M_purchase_inv_vendor->get_data_detail($id);
        //variable invoice number footer
        $data['get_data_footer'] = $this->M_purchase_inv_vendor->get_data_footer($id);

        $this->load->view('accounting/rpt/rpt_receivable_recognition', $data);
    }

    function list_currency()
    {
        $data['Currency'] = $this->M_purchase_inv_vendor->get_currency_detail();
        $this->load->view('accounting/list_currency', $data);
    }

    function list_payable()
    {
        $id = $this->input->get("id");

        //variable invoice number header
        $this->M_purchase_inv_vendor->get_data_header($id);
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
        $nofaktur = $this->input->post('nofaktur');
        $tgl_jurnal = str_replace('/', '-', $this->input->post('tgl_jurnal'));
        $p_tanggal = date('Y-m-d', strtotime($tgl_jurnal));

        $tgl_tempo = str_replace('/', '-', $this->input->post('tgl_tempo'));
        $p_tanggal_tempo = date('Y-m-d', strtotime($tgl_tempo));
        $tgl_invoice = str_replace('/', '-', $this->input->post('tgl_invoice'));
        $p_tanggal_invoice = date('Y-m-d', strtotime($tgl_invoice));

        $supplier = $this->input->post('supplier');
        $jenis_trans = 'PIJP';
        $currencyid = $this->input->post('symbol_currency');
        $currency = $this->input->post('Currency');
        $rate = $this->input->post('rate_header');
        $rate_awal = $this->input->post('rate_header');

        $term = $this->input->post('term');
        $total = $this->input->post('total_jr');
        $p_pajak = $total[2];
        $p_diskon = $total[1];
        $p_biaya_lain = $total[3];
        $p_uang_muka = $total[4];
        $p_hutang = str_replace(",", "", $total[5]);
        $created = $this->session->userdata('userid_1');
        $created_date = date('Y-m-d h:m:i');
        $last_update_date = date('Y-m-d  h:m:i');

        $Periode = date('mY', strtotime($tgl_jurnal));
        $rate_sgd = $this->input->post('rate_sgd');
        $rate_sgd_nego = $this->input->post('rate_sgd_nego');
        $jr_nocoa = $this->input->post('no_coa');

        $NoCOA = $this->input->post('NoCOA');
        $jr_jenisjurnal = $this->input->post('JenisJurnal');
        $jr_desc = $this->input->post('desc');

        if ($created == 'eva') {
            $created_by = 'System Maintanance';
            $last_update_by = 'System Maintanance';
        } else {
            $created_by = $created;
            $last_update_by = $created;
        }

        $jr_NoUrut = $this->input->post('NoUrut');
        $dk = $this->input->post('dk');


        // if ($submit_value == 'Save') {
        $jr_total = $this->input->post('total_jr');

        $txtItem = $this->input->post('txtItemId');
        $txtItemName = $this->input->post('txtItemName');
        $txtQty1000 = $this->input->post('txtQty1000');
        $txtQty = $this->input->post('txtQty');
        $txtCOA = $this->input->post('txtCOA');
        $txtUnit = $this->input->post('txtunit');
        $txtPrice = $this->input->post('txtunitprice');
        $txtAmount = $this->input->post('txtamount');
        $txtRate = $this->input->post('txtRate');
        $txtSGD = $this->input->post('txtusd');
        $nppbitemid = $this->input->post('txtNppbItemId');
        $txtNoPO = $this->input->post('Detail_po');
        $txtGST = $this->input->post('txtGST');
        $txtGSTValue = $this->input->post('txtGSTValue');
        $SubAccountId = $this->input->post('SubAccountId');
        $disc_per = $this->input->post('dis_per');
        $disc_dol = $this->input->post('dis_dol');
        $txtdocno = $this->input->post('txtdocno');
        $sbt = $this->input->post('sbt');
        $this->M_purchase_inv_vendor->delete_all($nofaktur);

        $Uraian = '';

        for ($i = 0; $i < count($this->input->post('Detail_po')); $i++) {
            //number_format(str_replace(",", "", $txtQty1[$p]), 4, ".", "");
            $Uraian = $txtItemName[$i];

            $det_item = array(
                'HeaderID' => $nofaktur,
                'no_po' => $txtNoPO[$i],
                'docno' => $txtdocno[$i],
                'ItemID' => $txtItem[$i],
                'ItemName' => $txtItemName[$i],
                'per1000' => $txtQty1000[$i],
                'Qty' => number_format(str_replace(",", "", $txtQty[$i]), 2, ".", ""),
                'unit' => $txtUnit[$i],
                'price' => number_format(str_replace(",", "", $txtPrice[$i]), 4, ".", ""),
                'disc_per' => $disc_per[$i],
                'amount' => number_format(str_replace(",", "", $txtAmount[$i]), 2, ".", ""),
                'disc_dol' => number_format(str_replace(",", "", $disc_dol[$i]), 2, ".", ""),
                'currency' => $currency,
                'rate' => $txtRate[$i],
                'usdequivalent' => number_format(str_replace(",", "", $txtSGD[$i]), 2, ".", ""),
                'npbbitem' => $nppbitemid[$i],
                'created_by' => $created_by,
                'created_date' => $created_date,
                'last_update_by' => $last_update_by,
                'last_update_date' => $last_update_date,
                'IP' => $_SERVER['REMOTE_ADDR'],
                'NoCOA' => $NoCOA,
                'rate_sgd' => $rate_sgd,
                'rate_sgd_nego' => $rate_sgd_nego,
                'gst_type' => $txtGST[$i],
                'gst_value' => number_format(str_replace(",", "", $txtGSTValue[$i]), 2, ".", "")
            );

            $this->M_purchase_inv_vendor->save_acc_tbl_trn_pi_dtl($det_item);

            $gst_item = array(
                'ref_nomor' => $nofaktur,
                'jenis_trans' => 'PIJP',
                'item' => $txtItem[$i],
                'po_no' => $txtNoPO[$i],
                'qty' => number_format(str_replace(",", "", $txtQty[$i]), 2, ".", ""),
                'gst_type' => $txtGST[$i],
                'gst_value' => number_format(str_replace(",", "", $txtGSTValue[$i]), 2, ".", ""),
                'unit' => $txtUnit[$i],
                'price' => number_format(str_replace(",", "", $txtPrice[$i]), 4, ".", ""),
                'currency' => $this->input->post('Currency'),
                'rate' => $rate,
                'rate_sgd' => $rate_sgd_nego,
                'created_by' => $created_by,
                'created_date' => $created_date,
                'ip_address' => $_SERVER['REMOTE_ADDR'],
            );
            if ($txtGST[$i] <> "") {
                $this->M_purchase_inv_vendor->simpan_gst_payable($gst_item);
            }
            //update pur_tbl_trn_gr_dtl
            $this->M_purchase_inv_vendor->update_pur_tbl_trn_gr_dtl($txtdocno[$i], $txtNoPO[$i], $txtItem[$i], $this->input->post('txtQty')[$i], $nofaktur);
        }

        $sum_debet = 0;
        $sum_credit = 0;
        $sum_debet_sgd = 0;
        $sum_credit_sgd = 0;

        //array footer jurnal
        for ($a = 1; $a < count($this->input->post('DetailID')); $a++) {

            $sub_account_id = $supplier;
            $jr_total[$a] = str_replace(",", "", $jr_total[$a]);

            if ($dk[$a] == 'D') {
                $debet = $jr_total[$a] * $rate;
                $debet_sgd = $jr_total[$a] * $rate_sgd_nego;
                $credit = '0';
                $credit_sgd = '0';
                $sum_debet += number_format(str_replace(",", "", $debet), 2, ".", "");
                $sum_debet_sgd += number_format(str_replace(",", "", $debet_sgd), 2, ".", "");
            } elseif ($dk[$a] == 'C') {
                $debet = '0';
                $debet_sgd = '0';
                $credit = $jr_total[$a] * $rate;
                $credit_sgd = $jr_total[$a] * $rate_sgd_nego;
                $sum_credit += number_format(str_replace(",", "", $credit), 2, ".", "");
                $sum_credit_sgd += number_format(str_replace(",", "", $credit_sgd), 2, ".", "");
            }

            $det_jur = array(
                'JenisJurnalID' => $jr_jenisjurnal[$a],
                'NoUrut' => $jr_NoUrut[$a],
                'CompanyID' => 'ZHL',
                'jenis_trans' => 'PIJP',
                'Tanggal' => $p_tanggal,
                'Periode' => $Periode,
                'NoJurnal' => $nofaktur,
                'chk' => $dk[$a],
                'NoCOA' => substr($jr_nocoa[$a], 0, 6),
                'sub_account_id' => $sub_account_id,
                'sub_account_type' => $SubAccountId[$a],
                'Uraian' => $Uraian,
                'Debet' => number_format(str_replace(",", "", $debet), 2, ".", ""),
                'Kredit' => number_format(str_replace(",", "", $credit), 2, ".", ""),
                'Debet_SGD' => number_format(str_replace(",", "", $debet_sgd), 2, ".", ""),
                'Kredit_SGD' => number_format(str_replace(",", "", $credit_sgd), 2, ".", ""),
                'Total' => number_format(str_replace(",", "", $jr_total[$a]), 2, ".", ""),
                'Currency' => $this->input->post('Currency'),
                'Rate' => $rate,
                'rate_sgd' => $rate_sgd_nego,
                'TotalAsal' => number_format(str_replace(",", "", $jr_total[$a]), 4, ".", ""),
                'CurrencyAsal' => $this->input->post('Currency'),
                'RateAsal' => $rate_awal,
                'Keterangan' => $jr_desc[$a],
                'created_by' => $created_by,
                'created_date' => $created_date,
                'last_update_by' => $last_update_by,
                'last_update_date' => $last_update_date,
                'ip_address' => $_SERVER['REMOTE_ADDR'],
            );
            $this->M_purchase_inv_vendor->simpan_jurnal($det_jur);
        }

        for ($x = 0; $x < 1; $x++) {
            $jr_total[$x] = str_replace(",", "", $jr_total[$x]);

            $debet2 = $jr_total[$x] * $rate;
            $debet2_sgd = $jr_total[$x] * $rate_sgd_nego;

            $sum_debet += number_format(str_replace(",", "", $debet2), 2, ".", "");
            $sum_debet_sgd += number_format(str_replace(",", "", $debet2_sgd), 2, ".", "");

            $selisih = $sum_debet - $sum_credit;

            if ($selisih != 0) {
                $debet2 = $debet2 - $selisih;
            }

            $selisih_sgd = $sum_debet_sgd - $sum_credit_sgd;

            if ($selisih_sgd != 0) {
                $debet_sgd2 = $debet_sgd2 - $selisih_sgd;
            }

            $det_jur = array(
                'JenisJurnalID' => $jr_jenisjurnal[$x],
                'NoUrut' => $jr_NoUrut[$x],
                'CompanyID' => 'ZHL',
                'jenis_trans' => 'PIJP',
                'Tanggal' => $p_tanggal,
                'Periode' => $Periode,
                'NoJurnal' => $nofaktur,
                'chk' => 'D',
                'NoCOA' => substr($jr_nocoa[$x], 0, 6),
                'sub_account_id' => $sub_account_id,
                'sub_account_type' => '',
                'Uraian' => $Uraian,
                'Debet' => number_format(str_replace(",", "", $debet2), 2, ".", ""),
                'Kredit' => "0",
                'Debet_SGD' => number_format(str_replace(",", "", $debet2_sgd), 2, ".", ""),
                'Kredit_SGD' => "0",
                'Total' => number_format(str_replace(",", "", $jr_total[$x]), 2, ".", ""),
                'Currency' => $this->input->post('Currency'),
                'Rate' => $rate,
                'rate_sgd' => $rate_sgd_nego,
                'TotalAsal' => number_format(str_replace(",", "", $jr_total[$x]), 4, ".", ""),
                'CurrencyAsal' => $this->input->post('Currency'),
                'RateAsal' => $rate_awal,
                'Keterangan' => $jr_desc[$x],
                'created_by' => $created_by,
                'created_date' => $created_date,
                'last_update_by' => $last_update_by,
                'last_update_date' => $last_update_date,
                'ip_address' => $_SERVER['REMOTE_ADDR'],
            );
            $this->M_purchase_inv_vendor->simpan_jurnal($det_jur);
        }

        $this->M_purchase_inv_vendor->hapus_COA_kosong();

        $stsDP = $this->input->post("stsDP");
        // update tabel dp
        $header_dp = $this->input->post("header_dp_id");
        $bayar_dp = $this->input->post("bayar_dp");
        $po_dp_id = $this->input->post("po_dp_id");

        for ($f = 0; $f < count($this->input->post('header_dp_id')); $f++) {
            $this->M_purchase_inv_vendor->update_dp_ar($header_dp[$f], $bayar_dp[$f], $nofaktur);
        }

        //insert tbl dp history
        for ($g = 0; $g < count($this->input->post('detail_dp_id')); $g++) {
            $data_his = array(
                "header_id" => $header_dp[$g],
                "no_facture" => $po_dp_id[$g],
                "trans_type" => "AP",
                "date1" => $p_tanggal,
                "cb_code" => "I",
                "no_voucher" => $nofaktur,
                "from_to" => $supplier,
                "trans_description" => "Withdrawal of deposits from AP Transactions.",
                "prepaid" => 1,
                "supplier" => $supplier,
                "coa_supplier" => $this->input->post('no_coa[5]'),
                "currency_id" => $currencyid,
                "currency_rate" => $rate,
                "coa_code" => '140401',
                "coa_description" => "Deposit vor Vendor",
                "debit_credit" => "C",
                "jumlah" => $bayar_dp[$g],
                "debit" => 0,
                "credit" => $bayar_dp[$g],
                "remark" => "-",
                "key_cf" => "0",
                "created_by" => $this->session->userdata('userid_1')
            );
            $this->M_Payable_recognition->insertCBhistoryi($data_his);
        }

        if ($stsDP == "DP") {
            $status_dp = 1;
        } else {
            $status_dp = 0;
        }

        // if($sbt == "Save") {
        //     $perintah = 'add';
        // }  else {
        //     $perintah = 'edit';
        // }
        $data = array(
            'p_perintah' => 'add',
            'p_nofaktur' => $nofaktur,
            'p_company_id' => 'ZHL',
            'p_tanggal' => $p_tanggal,
            'p_tanggal_tempo' => $p_tanggal_tempo,
            'p_tanggal_invoice' => $p_tanggal_invoice,
            'p_kode_sup' => $supplier,
            'p_jenis_trans' => $jenis_trans,
            'p_currency_id' => $currencyid,
            'p_term' => $term,
            'p_rate' => $rate,
            'p_rate_sgd' => $rate_sgd_nego,
            'p_pajak' => number_format(str_replace(",", "", $p_pajak), 2, ".", ""),
            'p_diskon' => number_format(str_replace(",", "", $p_diskon), 2, ".", ""),
            'p_biaya_lain' => number_format(str_replace(",", "", $p_biaya_lain), 2, ".", ""),
            'p_uang_muka' => number_format(str_replace(",", "", $p_uang_muka), 2, ".", ""),
            'p_hutang' => number_format(str_replace(",", "", $p_hutang), 2, ".", ""),
            'p_status' => '1',
            'p_created_by' => $created_by,
            'p_ip_address' => $_SERVER['REMOTE_ADDR'],
            'p_nocoa' => $NoCOA,
            'p_status_dp' => $status_dp,
        );
        $this->M_purchase_inv_vendor->call_sp_rec_hutang($data);

        $this->session->set_flashdata('message', pesan("The transaction has been successfully saved with the Invoice Number : $nofaktur", pesan_info()));
        redirect("Purchase_inv_vendor/edit?id=$nofaktur");
        //   }
    }

    function delete()
    {
        $id = $this->input->get("id");
        $idj = $this->input->get("idjurnal");
        $nofaktur = $this->input->get("nofaktur");
        // $this->M_purchase_inv_vendor->delete_item($id);
        // $this->M_purchase_inv_vendor->delete_jurnal($idj);
        $this->M_purchase_inv_vendor->delete_hutang($nofaktur);
        redirect("Purchase_inv_vendor/edit?id=$nofaktur");
    }

    function cek_tabel_ar()
    {
        $id = $this->input->get("id");
        $data['select_hutang'] = $this->M_purchase_inv_vendor->nota($id);
        $this->load->view('accounting/validasi', $data);
    }

    function hapus()
    {
        $id = $this->input->get("id");
        $nofaktur = $this->input->get("nofaktur");
        $this->M_purchase_inv_vendor->delete_jurnal($id);
        redirect("Purchase_inv_vendor/edit?id=$nofaktur");
    }

    function delete_transaction()
    {
        $id = $this->input->get("id");
        $this->M_purchase_inv_vendor->delete_all($id);
        redirect("Purchase_inv_vendor");
    }

    // ################################################################################
    // ################################################################################
    //
    // ########## Select Back Recorded Purchase Invoice Vendor ##########

    function selectInvoiceVendor()
    {
        $data   = array(
            '_selectHeader' => $this->M_purchase_inv_vendor->selectInvoiceforFindIV()->result()
        );
        $this->load->view('accounting/Purchase_inv_vendor/FindIV/selectIV', $data);
    }

    public function convert($date)
    {
        $explode = explode("/", $date);

        $time = $explode[2] . '/' . $explode[1] . '/' . $explode[0];

        return $time;
    }
}
