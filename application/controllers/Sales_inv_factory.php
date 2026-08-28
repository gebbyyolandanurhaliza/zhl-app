
<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Sales_inv_factory extends CI_Controller
{

    function __construct()
    {
        parent::__construct();

        $this->load->model(array('M_sales_inv_factory', 'M_vcdn'));
        $this->load->library(array('template', 'user_agent'));

        if (!$this->session->userdata('userid_1')) {
            redirect('login');
        }
    }

    public function index()
    {
        $data['SupplierID'] = $this->M_sales_inv_factory->get_cust();
        $data['title'] = "List of Receivable Recognition";
        $data['List_payable'] = $this->M_sales_inv_factory->get_list_piutang();
        $this->template->display('accounting/Sales_inv_factory/Sales_inv_factory_list', $data);
    }

    function search()
    {
        $data['SupplierID'] = $this->M_sales_inv_factory->get_sup();
        $invoice = $this->input->get("invoice");

        $dari = str_replace('/', '-', $this->input->get('dari'));
        $p_dari = date('Y-m-d', strtotime($dari));

        $sampai = str_replace('/', '-', $this->input->get("sampai"));
        $p_sampai = date('Y-m-d', strtotime($sampai));


        $supplier = $this->input->get("supplier");
        $data['tgl'] = $dari;
        if ($dari != '') {
            $data['List_payable'] = $this->M_sales_inv_factory->advance_list_piutang($p_dari, $p_sampai, $invoice, $supplier);
        } else {
            $data['List_payable'] = $this->M_sales_inv_factory->advance_list_piutang1($invoice, $supplier);
        }
        $this->template->display('accounting/Sales_inv_factory/Sales_inv_factory_list', $data);
    }

    function add_new()
    {
        $data['SupplierID'] = $this->M_sales_inv_factory->get_sup();
        $data['Currency'] = $this->M_sales_inv_factory->get_currency();
        $data['List_coa'] = $this->M_vcdn->get_coa();
        $data['message'] = $this->session->flashdata('message');

        $this->template->display('accounting/Sales_inv_factory/Sales_inv_factory_form', $data);
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

    function tampil_po()
    {
        $supplier = $this->input->get("supplier");
        $currency = $this->input->get("currency");

        $data["list_po"] = $this->M_sales_inv_factory->tampil_po_list($supplier, $currency);

        $this->load->view('accounting/ajax/tampil_po_factory', $data);
    }

    function data_dp()
    {
        $id = $this->input->get("id");
        $currency = $this->input->get("currency");

        $data['pilih_dp'] = $this->M_sales_inv_factory->pilih_dp($id, $currency);
        $this->load->view('accounting/list_dp', $data);
    }

    function edit()
    {
        $data['SupplierID'] = $this->M_sales_inv_factory->get_sup();
        $data['Currency'] = $this->M_sales_inv_factory->get_currency();
        $data['message'] = $this->session->flashdata('message');
        $data['CurrencyID'] = $this->M_sales_inv_factory->get_currency_detail();
        $data['List_coa'] = $this->M_vcdn->get_coa();
        $id = $this->input->get("id");

        //variable invoice number header
        $data['HeaderID'] = $id;
        $data['get_data_header'] = $this->M_sales_inv_factory->get_data_header($id);
        $data['nota'] = $this->M_sales_inv_factory->nota($id);
        //variable invoice number detail
        $data['get_data_detail'] = $this->M_sales_inv_factory->get_data_detail($id);
        //variable invoice number footer
        $data['get_data_footer'] = $this->M_sales_inv_factory->get_data_footer($id);

        $data['get_data_jurnal1'] = $this->M_sales_inv_factory->get_data_jurnal(1, $id, 'SIJF');
        $data['get_data_jurnal2'] = $this->M_sales_inv_factory->get_data_jurnal(2, $id, 'SIJF');
        $data['get_data_jurnal3'] = $this->M_sales_inv_factory->get_data_jurnal(3, $id, 'SIJF');
        $data['get_data_jurnal4'] = $this->M_sales_inv_factory->get_data_jurnal(4, $id, 'SIJF');
        $data['get_data_jurnal5'] = $this->M_sales_inv_factory->get_data_jurnal(5, $id, 'SIJF');
        $data['get_data_jurnal6'] = $this->M_sales_inv_factory->get_data_jurnal(6, $id, 'SIJF');


        $data['data_bawah'] = $this->M_sales_inv_factory->data_paling_bawah($id);

        $this->template->display('accounting/Sales_inv_factory/Sales_inv_factory_form', $data);
    }

    function print_report()
    {
        $data['SupplierID'] = $this->M_sales_inv_factory->get_customer();
        $data['Currency'] = $this->M_sales_inv_factory->get_currency();
        $data['CurrencyID'] = $this->M_sales_inv_factory->get_currency_detail();
        //cari nota debet, berdasarkan total seluruh transaksi "Bayar"
        $id = $this->input->get("id");

        //variable invoice number header
        $data['HeaderID'] = $id;
        $data['titel'] = 'Payable Recognition';
        $data['nota'] = $this->M_sales_inv_factory->nota($id);
        $data['get_data_header'] = $this->M_sales_inv_factory->get_data_header($id);
        //variable invoice number detail
        $data['get_data_detail'] = $this->M_sales_inv_factory->get_data_detail($id);
        //variable invoice number footer
        $data['get_data_footer'] = $this->M_sales_inv_factory->get_data_footer($id);

        $this->load->view('accounting/rpt/rpt_receivable_recognition', $data);
    }

    function list_currency()
    {
        $data['Currency'] = $this->M_sales_inv_factory->get_currency_detail();
        $this->load->view('accounting/list_currency', $data);
    }

    function list_payable()
    {
        $id = $this->input->get("id");

        //variable invoice number header
        $this->M_sales_inv_factory->get_data_header($id);
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
        $this->M_sales_inv_factory->delete_piutang($nofaktur);
        $company_id = 'PSS';

        $tgl_jurnal = str_replace('/', '-', $this->input->post('tgl_jurnal'));
        $p_tanggal = date('Y-m-d', strtotime($tgl_jurnal));
        $tgl_tempo = str_replace('/', '-', $this->input->post('tgl_tempo'));
        $p_tanggal_tempo = date('Y-m-d', strtotime($tgl_tempo));
        $tgl_invoice = str_replace('/', '-', $this->input->post('tgl_invoice'));
        $p_tanggal_invoice = date('Y-m-d', strtotime($tgl_invoice));

        $supplier = $this->input->post('supplier');
        $JenisJurnal = $this->input->post('txtUnit');
        $jenis_trans = 'SIJF';
        $currencyid = $this->input->post('symbol_currency');
        $currency = $this->input->post('Currency');
        $rate = $this->input->post('rate_header');
        $rate_awal = $this->input->post('rate_header');
        $rate_akhir = $this->input->post('rate_header');

        $term = $this->input->post('term');
        $total = $this->input->post('total_jr');
        $p_pajak = $total[2];
        $p_diskon = $total[1];
        $p_biaya_lain = $total[3];
        $p_uang_muka = $total[4];
        $p_piutang = $total[5];
        $created_by = $this->session->userdata('userid_1');
        $created_date = date('Y-m-d');
        $last_update_by = $this->session->userdata('userid_1');
        $last_update_date = date('Y-m-d');
        $ip_address = $_SERVER['REMOTE_ADDR'];
        $submit_value = $this->input->post('sbt');
        $NoCOA = $this->input->post('NoCOA');

        $cek = $this->input->post('chk');
        $id = $this->input->post('Detail_ID');
        $Periode = date('mY');
        $status = '2';
        $rate_sgd = $this->input->post('rate_sgd');
        $jr_nocoa = $this->input->post('no_coa');
        $jr_jenisjurnal = $this->input->post('JenisJurnal');
        $jr_desc = $this->input->post('desc');



        $jr_NoUrut = $this->input->post('NoUrut');
        $dk = $this->input->post('dk');


        // if ($submit_value == 'Save') {
        $rate_jr = $this->input->post('rate_jr');
        $jr_total = $this->input->post('total_jr');

        $txtItem = $this->input->post('txtItemId');
        $txtItemName = $this->input->post('txtItemName');
        $txtQty = $this->input->post('txtQty');
        $txtUnit = $this->input->post('txtunit');
        $txtPrice = $this->input->post('txtunitprice');
        $txtAmount = $this->input->post('txtamount');
        $txtusd = $this->input->post('txtusd');
        $nppbitemid = $this->input->post('txtnpbbno');
        $txtNoPO = $this->input->post('Detail_po');
        $txtGST = $this->input->post('txtgsttype');
        $txtGSTValue = $this->input->post('txtgstvalue');
        $SubAccountId = $this->input->post('SubAccountId');
        $txtSono = $this->input->post('txtSono');
        $this->M_sales_inv_factory->delete_jurnal_lama($nofaktur);
        for ($i = 0; $i < count($this->input->post('txtItemId')); $i++) {
            //number_format(str_replace(",", "", $txtQty1[$p]), 4, ".", "");
            $det_item = array(
                'HeaderID' => $nofaktur,
                'sono' => $txtSono[$i],
                'po_no' => $txtNoPO[$i],
                'ItemID' => $txtItem[$i],
                'ItemName' => $txtItemName[$i],
                'Qty' => number_format(str_replace(",", "", $txtQty[$i]), 4, ".", ""),
                'unit' => $txtUnit[$i],
                'price' => number_format(str_replace(",", "", $txtPrice[$i]), 4, ".", ""),
                'amount' => number_format(str_replace(",", "", $txtAmount[$i]), 4, ".", ""),
                'currency' => $currency,
                'rate' => $rate,
                'usdequivalent' => $txtusd[$i],
                'npbbitem' => $nppbitemid[$i],
                'created_by' => $created_by,
                'created_date' => $created_date,
                'last_update_by' => $last_update_by,
                'last_update_date' => $last_update_date,
                'IP' => $_SERVER['REMOTE_ADDR'],
                'NoCOA' => $NoCOA,
                'rate_sgd' => $rate_sgd,
                'gst_type' => $txtGST[$i],
                'gst_value' => $txtGSTValue[$i]
            );

            $this->M_sales_inv_factory->save_acc_tbl_trn_si_fac_dtl($det_item);


            $gst_item = array(
                'ref_nomor' => $nofaktur,
                'jenis_trans' => 'SIJF',
                'item' => $txtItem[$i],
                'qty' => number_format(str_replace(",", "", $txtQty[$i]), 4, ".", ""),
                'gst_type' => $txtGST[$i],
                'gst_value' => number_format(str_replace(",", "", $txtGSTValue[$i]), 4, ".", ""),
                'unit' => $txtUnit[$i],
                'price' => number_format(str_replace(",", "", $txtPrice[$i]), 4, ".", ""),
                'currency' => $this->input->post('Currency'),
                'rate' => $rate,
                'created_by' => $created_by,
                'created_date' => $created_date,
                'ip_address' => $ip_address,
            );
            if ($txtGST[$i] <> "") {
                $this->M_sales_inv_factory->simpan_gst_payable($gst_item);
            }
            //update pur_tbl_trn_gr_dtl
            //$this->M_sales_inv_factory->update_pur_tbl_trn_gr_dtl($txtSono[$i], $txtNoPO[$i], $txtItem[$i], $txtQty[$i]);
        }

        //array footer jurnal
        for ($a = 0; $a < count($this->input->post('DetailID')); $a++) {

            $sub_account_id = $supplier;

            if ($dk[$a] == 'D') {
                $debet = $jr_total[$a];
                $credit = '0';
            } elseif ($dk[$a] == 'C') {
                $debet = '0';
                $credit = $jr_total[$a];
            }

            $det_jur = array(
                'JenisJurnalID' => $jr_jenisjurnal[$a],
                'NoUrut' => $jr_NoUrut[$a],
                'CompanyID' => 'PSS',
                'jenis_trans' => 'SIJF',
                'Tanggal' => $p_tanggal_invoice,
                'Periode' => $Periode,
                'NoJurnal' => $nofaktur,
                'chk' => $dk[$a],
                'NoCOA' => substr($jr_nocoa[$a], 0, 6),
                'sub_account_id' => $sub_account_id,
                'sub_account_type' => $SubAccountId[$a],
                'Uraian' => $jr_desc[$a],
                'Debet' => number_format(str_replace(",", "", $debet), 4, ".", ""),
                'Kredit' => number_format(str_replace(",", "", $credit), 4, ".", ""),
                'Total' => number_format(str_replace(",", "", $jr_total[$a]), 4, ".", ""),
                'Currency' => $this->input->post('Currency'),
                'Rate' => $rate_jr[$a],
                'rate_sgd' => $rate_sgd,
                'TotalAsal' => number_format(str_replace(",", "", $jr_total[$a]), 4, ".", ""),
                'CurrencyAsal' => $this->input->post('Currency'),
                'RateAsal' => $rate_awal,
                'Keterangan' => '-',
                'created_by' => $created_by,
                'created_date' => $created_date,
                'last_update_by' => $last_update_by,
                'last_update_date' => $last_update_date,
                'ip_address' => $ip_address,
            );
            $this->M_sales_inv_factory->simpan_jurnal($det_jur);
        }

        $this->M_sales_inv_factory->hapus_COA_kosong();
        $data = array(
            'p_perintah' => 'add',
            'p_nofaktur' => $nofaktur,
            'p_tanggal' => $p_tanggal,
            'p_tanggal_tempo' => $p_tanggal_tempo,
            'p_tanggal_invoice' => $p_tanggal_invoice,
            'p_term' => $term,
            'p_kode_sup' => $supplier,
            'p_jenis_trans' => $jenis_trans,
            'p_currency_id' => $this->input->post('Currency'),
            'p_rate' => $rate,
            'p_pajak' => $p_pajak,
            'p_diskon' => $p_diskon,
            'p_biaya_lain' => $p_biaya_lain,
            'p_uang_muka' => $p_uang_muka,
            'p_piutang' => $p_piutang,
            'p_created_by' => $created_by,
            'p_ip_address' => $ip_address,
            'p_rate_sgd' => $rate_sgd,
            'p_nocoa' => $NoCOA,
            'p_status_dp' => '0'
        );
        $this->M_sales_inv_factory->call_sp_rec_piutang_fac($data);

        $this->session->set_flashdata('message', pesan("The transaction has been successfully saved with the Invoice Number : $nofaktur", pesan_info()));
        redirect("Sales_inv_factory/edit?id=$nofaktur");
        //   }
    }

    function delete()
    {
        $id = $this->input->get("id");
        $idj = $this->input->get("idjurnal");
        $nofaktur = $this->input->get("nofaktur");
        $this->M_sales_inv_factory->delete_item($id);
        $this->M_sales_inv_factory->delete_jurnal($idj);
        redirect("Sales_inv_factory/edit?id=$nofaktur");
    }

    function cek_tabel_ar()
    {
        $id = $this->input->get("id");
        $data['select_piutang'] = $this->M_sales_inv_factory->nota($id);
        $this->load->view('accounting/validasi', $data);
    }

    function hapus()
    {
        $id = $this->input->get("id");
        $nofaktur = $this->input->get("nofaktur");
        $this->M_sales_inv_factory->delete_jurnal($id);
        redirect("Sales_inv_factory/edit?id=$nofaktur");
    }

    function delete_transaction()
    {
        $id = $this->input->get("id");
        $this->M_sales_inv_factory->delete_piutang($id);
        redirect("Sales_inv_factory");
    }
}
