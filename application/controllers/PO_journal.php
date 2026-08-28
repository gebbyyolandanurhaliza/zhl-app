<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class PO_journal extends CI_Controller {

    function __construct() {
        parent::__construct();
        if (!$this->session->userdata('userid_1')) {
            redirect('login');
        }
        $this->load->model(array('m_po_journal', 'M_Receivable_recognition', 'M_Payable_recognition'));
        $this->load->library(array('template', 'user_agent', 'fpdf'));
    }

//    -----------------------------------------------------------------------ABOUT PO-----------------------------------------------------
    public function index() {

        $data['cur'] = $this->m_po_journal->tampil_cur();
        $data['po'] = $this->m_po_journal->ambil_PO();
        $data['supp'] = $this->m_po_journal->get_supplier();
        $data['getList'] = $this->m_po_journal->get_list();

        //tambahan 02-05-2016
        $data['_Tax'] = $this->m_po_journal->get_coaTax();
        $data['_Discount'] = $this->m_po_journal->get_coaDiscount();

        //$data['get_PO'] = $this->m_po_journal->get_list_po();
        // $this->template->display('accounting/purchasing_jurnal/PO_Journal_list',$data);
        $this->template->display('accounting/purchase_jurnal/PO_Journal_list', $data);
        // $this->template->display('accounting/purchase_jurnal/det');
    }

    public function get_coa() {
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

    public function addnew() {
        $data['cur'] = $this->m_po_journal->get_cur();
        $data['po'] = $this->m_po_journal->ambil_PO();
        $data['supp'] = $this->m_po_journal->get_supplier();
        $data['coa'] = $this->m_po_journal->tampil_coa();
        //tambahan 02-05-2016
        $data['_Tax'] = $this->m_po_journal->get_coaTax();
        $data['_Discount'] = $this->m_po_journal->get_coaDiscount();
        // $data['_gst'] = $this->m_po_journal->get_gst();
        $this->template->display('accounting/purchase_jurnal/PO_Journal_form', $data);
    }

    public function edit() {
        $data['cur'] = $this->m_po_journal->tampil_cur();
        $data['po'] = $this->m_po_journal->ambil_PO();
        $data['supp'] = $this->m_po_journal->get_supplier();
        $data['coa'] = $this->m_po_journal->tampil_coa();
        //$data['chk'] = $this->m_po_journal->get_chk();
        //tambahan 02-05-2016
        $data['_Tax'] = $this->m_po_journal->get_coaTax();
        $data['_Discount'] = $this->m_po_journal->get_coaDiscount();
        // $data['_gst'] = $this->m_po_journal->get_gst();

        $id = $this->input->get("id");
        // echo $id;
        $vendor = $this->input->get("ve");
        $cur = $this->input->get("cur");
        $data['get_data_header'] = $this->m_po_journal->get_data_header($id);
        // $data['get_data_detail'] = $this->m_po_journal->get_data_detail($id);
        $data['get_data_footer'] = $this->m_po_journal->get_data_footer($id);
        $data['get_data_item'] = $this->m_po_journal->get_data_item($id);
        $data['tampilpo'] = $this->m_po_journal->tampil_item_jurnal($vendor, $cur);

        $data['get_data_jurnal1'] = $this->M_Payable_recognition->get_data_awal($id, 'PV/GL');
        $data['get_data_jurnal2'] = $this->M_Payable_recognition->get_data_jurnal(2, $id, 'PIJV');
        $data['get_data_jurnal3'] = $this->M_Payable_recognition->get_data_jurnal(3, $id, 'PIJV');
        $data['get_data_jurnal4'] = $this->M_Payable_recognition->get_data_jurnal(4, $id, 'PIJV');
        $data['get_data_jurnal5'] = $this->M_Payable_recognition->get_data_jurnal(5, $id, 'PIJV');
        $data['get_data_jurnal6'] = $this->M_Payable_recognition->get_data_jurnal(6, $id, 'PIJV');

        $this->template->display('accounting/purchase_jurnal/PO_Journal_form', $data);
    }

    function tampilpo() {
        $get = $this->uri->segment(3);
        $get1 = $this->uri->segment(4);
        // echo $get;
        $data['tampilpo'] = $this->m_po_journal->tampil_item_jurnal($get, $get1);
        // $data['_gst'] = $this->m_po_journal->get_gst();
        $this->load->view('accounting/purchase_jurnal/tampilpo', $data);
    }

    public function print_report() {
        $data['cur'] = $this->m_po_journal->tampil_cur();
        $data['po'] = $this->m_po_journal->ambil_PO();
        $data['supp'] = $this->m_po_journal->get_supplier();
        //$data['chk'] = $this->M_po_journal->get_chk();

        $id = $this->input->get("id");
        // echo $id;
        $data['get_header'] = $this->m_po_journal->get_data_header($id);
        // $data['get_data_detail'] = $this->M_po_journal->get_data_detail($id);
        $data['get_footer'] = $this->m_po_journal->get_data_footer($id);
        $data['get_item'] = $this->m_po_journal->get_data_item($id);
        //$data['tampilpo'] = $this->M_po_journal->tampil_item_jurnal($vendor,$cur);
        //$this->template->display('accounting/purchase_jurnal/PO_Journal_form' , $data);
        $this->load->view('accounting/rpt/rpt_purchase_1', $data);
    }

    function tablekosong() {
        $this->load->view('accounting/purchase_jurnal/tabelkosong');
    }

    function save_jurnal_invoice() {
        //header
        $nojurnalinvoice = $this->input->post('nofaktur');
        $company_id = 'PSS';
        $currency = $this->input->post('cur');
        $currency_id = $this->input->post('cur');
        $rate = $this->input->post('rate_header');
        $rate_awal = $this->input->post('rate_header');
        $rate_akhir = $this->input->post('rate_header');


        $tgl_jurnal = str_replace('/', '-', $this->input->post('tgl_jurnal'));
        $tanggal_jurnal = date('Y-m-d', strtotime($tgl_jurnal));

        $tgl_invoice = str_replace('/', '-', $this->input->post('tgl_invoice'));
        $tanggal_invoice = date('Y-m-d', strtotime($tgl_invoice));

        $tgl_tempo = str_replace('/', '-', $this->input->post('tgl_tempo'));
        $tanggal_tempo = date('Y-m-d', strtotime($tgl_tempo));

        $term = $this->input->post('term');
        $kode_sup = $this->input->post('idsup');
        $symbol_currency = $this->input->post('symbol_currency');
        $totalitem = $this->input->post('nota_debet');
        $jenistrans = 'PIJV';
        $remark = $this->input->post('remark');

        //detail
        $npbbno = $this->input->post('npbbno');
        $itemid = $this->input->post('txtidem');
        $itemname = $this->input->post('txtinem');
        $qty = $this->input->post('txtqty');
        $qty_pi1 = $this->input->post('txtqty_pi');
        //$qty_pij = $qty_pi1+$qty;
        $unit = $this->input->post('txtunit');
        $price = $this->input->post('txtprice');
        $amount = $this->input->post('txtamount');
        $currencydetail = $this->input->post('txtcurrency');
        $ratedetail = $this->input->post('txtrate');
        $grandtotal = $this->input->post('txtgrand');
        $npbb = $this->input->post('txtnpbb');

        //footer
        $detailid = $this->input->post('DetailID');
        $no_coa = $this->input->post('no_coa');
        $dk = $this->input->post('dk');
        $jurnaljenis = $this->input->post('JenisJurnal');
        $noUrut = $this->input->post('NoUrut');
        $ket = $this->input->post('desc');
        $totalfooter = $this->input->post('total_jr');
        $ratefooter = $this->input->post('rate_jr');
        $debetfooter = $this->input->post('debt_jr');
        $creditfooter = $this->input->post('credit_jr');


        //keterangan wajib
        $created_by = $this->session->userdata('userid_1');
        $created_date = date('Y-m-d');
        $last_update_by = $this->session->userdata('userid_1');
        $last_update_date = date('Y-m-d');
        $ip = $_SERVER['REMOTE_ADDR'];

        $periode_tanggal = date('d', strtotime($tanggal_jurnal));
        $periode_bulan = date('m', strtotime($tanggal_jurnal));
        $periode_tahun = date('Y', strtotime($tanggal_jurnal));
        $tgl = $periode_tanggal;
        $bln = $periode_bulan;
        $thn = $periode_tahun;
        $submit_value = $this->input->post('sbt');



        //tambahan 17-02-2016
        $total_debet = $this->input->post('total_debet');
        $total_kredit = $this->input->post('total_kredit');
        $pajak = $totalfooter[2];
        $diskon = $totalfooter[1];
        $biaya_lain = $totalfooter[3];
        $uang_muka = $totalfooter[4];
        $nota_kredit = 0;
        $hutang = $totalfooter[5];
        $saldo_hutang = $totalfooter[5];
        $bayar = 0;
        $idsupp = $this->input->post('sup');
        $gst_name = $this->input->post('txtGST');
        $gst_value = $this->input->post('gst_value');
        $txtcoa = $this->input->post('coa_argl');
        $rate_sgd = $this->input->post('rate_sgd');
        $per1000 = $this->input->post('txtper1000');

        // for($i = 0; $i < count($debetfooter); $i++){
        //     echo $debetfooter[$i]." ".$creditfooter[$i]."<br>";
        // }

        $jr_total = $this->input->post('total_jr');
        $jr_jenisjurnal = $this->input->post('JenisJurnal');
        $jr_NoUrut = $this->input->post('NoUrut');
        $Periode = date('mY');
        $jr_nocoa = $this->input->post('no_coa'); 
        $jr_desc = $this->input->post('desc');
        $ip_address = $_SERVER['REMOTE_ADDR'];

        if ($submit_value == 'Save') {
            $ratefooter = $this->input->post('rate_jr');
            $debetfooter = $this->input->post('debt_jr');
            $creditfooter = $this->input->post('credit_jr');
            $totalfooter = $this->input->post('total_jr');
            $query = $this->m_po_journal->cek('acc_tbl_trn_hutang', 'nofaktur', $nojurnalinvoice);

            for ($i = 0; $i < count($qty); $i++) {
                $qty_pij[$i] = str_replace(',', '', $qty[$i]) + $qty_pi1[$i];
            }
            $data = array(
                'nofaktur' => $nojurnalinvoice,
                'company_id' => $company_id,
                'tanggal' => $tanggal_jurnal,
                'tanggal_tempo' => $tanggal_tempo,
                'tanggal_invoice' => $tanggal_invoice,
                'kode_sup' => $kode_sup,
                'jenis_trans' => $jenistrans,
                'currency_id' => $currency_id,
                'term' => $term,
                'rate' => $rate,
                'rate_awal' => $rate_awal,
                'rate_akhir' => $rate_akhir,
                'rate_sgd' => $rate_sgd,
                'pajak' => $pajak,
                'diskon' => $diskon,
                'biaya_lain' => $biaya_lain,
                'uang_muka' => $uang_muka,
                'nota_debet' => 0,
                'nota_kredit' => 0,
                'hutang' => $hutang,
                'saldo_hutang' => $hutang,
                'bayar' => 0,
                'Keterangan' => $remark,
                'created_by' => $created_by,
                'created_date' => $created_date,
                'ip_address' => $ip
            );
            $this->m_po_journal->simpan_header($data);

            $data2 = array(
                'nofaktur' => $nojurnalinvoice,
                'tanggal' => $tanggal_jurnal,
                'company_id' => $company_id,
                'periode_bulan' => $bln,
                'periode_tahun' => $thn,
                'currency_id' => $currency_id,
                'rate_awal' => $rate_awal,
                'rate_akhir' => $rate_akhir,
                'rate_sgd_awal' => $rate_sgd,
                'rate_sgd_akhir' => $rate_sgd,
                'nota_debet' => 0,
                'nota_kredit' => 0,
                'hutang' => $hutang,
                'saldo_hutang' => $hutang,
                'bayar' => 0,
                'created_by' => $created_by,
                'created_date' => $created_date,
                'ip_address' => $ip
            );
            $this->m_po_journal->simpan_bulanan($data2);

            //jurnal dari tabel total form
            for ($i = 1; $i < count($detailid); $i++) {
                $data_jurnal = array(
                    'JenisJurnalID' => $jurnaljenis[$i],
                    'NoUrut' => $noUrut[$i],
                    'jenis_trans' => $jenistrans,
                    'CompanyID' => 'PSS',
                    'Tanggal' => $tanggal_invoice,
                    'NoJurnal' => $nojurnalinvoice,
                    'NoCOA' => $no_coa[$i],
                    'sub_account_type' => 'HUT',
                    'sub_account_id' => $kode_sup,
                    'CHK' => $dk[$i],
                    'Uraian' => $ket[$i],
                    'Debet' => $debetfooter[$i],
                    'Kredit' => $creditfooter[$i],
                    'Total' => $totalfooter[$i],
                    'Currency' => $currency_id,
                    'Rate' => $rate,
                    'rate_sgd' => $rate_sgd,
                    'TotalAsal' => '0',
                    'CurrencyAsal' => '0',
                    'RateAsal' => $rate,
                    'Keterangan' => $remark,
                    'created_by' => $created_by,
                    'created_date' => $created_date,
                    'ip_address' => $ip
                );
                $this->m_po_journal->simpan_detail($data_jurnal);
            }
            
            //jurnal dari tabel detail form
            for ($i = 0; $i < count($itemname); $i++) {
                $detail_jur = array(
                    'JenisJurnalID' => 'PIJV',
                    'NoUrut' => 0,
                    'CompanyID' => 'PSS',
                    'jenis_trans' => $jenistrans,
                    'Tanggal' => $tanggal_invoice,
                    'NoJurnal' => $nojurnalinvoice,
                    'chk' => 'D',
                    'NoCOA' => substr($txtcoa[$i], 0, 6),
                    'sub_account_type' => 'HUT',
                    'sub_account_id' => $kode_sup,
                    'uraian' => $itemname[$i],
                    'Debet' => $amount[$i],
                    'Kredit' => 0,
                    'Total' => $amount[$i],
                    'currency' => $currency_id,
                    'Rate' => $rate,
                    'rate_sgd' => $rate_sgd,
                    'TotalAsal' => $amount[$i],
                    'CurrencyAsal' => $currency_id,
                    'RateAsal' => $rate,
                    'Keterangan' => '-',
                    'created_by' => $created_by,
                    'created_date' => $created_date,
                    'ip_address' => $ip,
                    'gst_type' => $gst_name[$i],
                    'gst_value' => $gst_value[$i]
                );
                $this->m_po_journal->simpan_detail($detail_jur);
            }

            
            $this->m_po_journal->hapus_COA_kosong_pi();

            for ($i = 0; $i < count($itemname); $i++) {
                //echo $detailid[$i];
                $data_item = array(
                    'HeaderID' => $nojurnalinvoice,
                    'ItemID' => $itemid[$i],
                    'ItemName' => $itemname[$i],
                    'per1000' => $per1000[$i],
                    'Qty' => $qty[$i],
                    'unit' => $unit[$i],
                    'price' => number_format(str_replace(",", "", $price[$i]), 2, ".", ""),
                    'amount' => $amount[$i],
                    'currency' => $currency_id,
                    'rate' => $rate,
                    'usdequivalent' => $grandtotal[$i],
                    'npbbitem' => $npbbno[$i],
                    'created_by' => $created_by,
                    'created_date' => $created_date,
                    'IP' => $ip,
                    'NoCOA' => $txtcoa[$i],
                    'rate_sgd' => $rate_sgd,
                    'gst_type' => $gst_name[$i],
                    'gst_value' => $gst_value[$i]
                );

                $this->m_po_journal->simpan_item($data_item);
            }
            $kode_sup = $this->input->post('idsup');
            for ($i = 0; $i < count($npbb); $i++) {
                $data_pi = array(
                    'qty_pi' => $qty_pij[$i],
                    'no_reff' => $nojurnalinvoice
                );
                $query100 = $this->m_po_journal->update_gr($npbbno[$i], $itemid[$i], $data_pi);
            }
            $this->session->set_flashdata("message", "<div class=\"alert alert-warning\" id=\"alert\">Berhasil Di simpan </div>");
            redirect("PO_journal/edit?id=$nojurnalinvoice&ve=$kode_sup&cur=$currency_id");
            // //penutup else
        } else {
            $totalfooter1 = $this->input->post('total_jr');
            $ratefooter1 = $this->input->post('rate_jr');
            $debetfooter1 = $this->input->post('debt_jr');
            $creditfooter1 = $this->input->post('credit_jr');
            $qty_awal = $this->input->post('txtqty_awal');
            $data = array(
                'tanggal' => $tanggal_jurnal,
                'tanggal_tempo' => $tanggal_tempo,
                'tanggal_invoice' => $tanggal_invoice,
                'term' => $term,
                'pajak' => $pajak,
                'diskon' => $diskon,
                'biaya_lain' => str_replace(',', '', $biaya_lain),
                'uang_muka' => str_replace(',', '', $uang_muka),
                'nota_debet' => 0,
                'nota_kredit' => 0,
                'currency_id' => $currency,
                'rate' => $rate_awal,
                'rate_sgd' => $rate_sgd,
                'hutang' => str_replace(',', '', $hutang),
                'saldo_hutang' => str_replace(',', '', $hutang),
                'Keterangan' => $remark,
                'last_update_by' => $last_update_by,
                'last_update_date' => $last_update_date,
                'ip_address' => $ip
            );
            $this->m_po_journal->update_header($nojurnalinvoice, $data);

            $data2 = array(
                'tanggal' => $tanggal_jurnal,
                'currency_id' => $currency_id,
                'hutang' => str_replace(',', '', $hutang),
                'nota_kredit' => str_replace(',', '', $hutang),
                'saldo_hutang' => str_replace(',', '', $hutang),
                'rate_sgd_awal' => $rate_sgd,
                'rate_sgd_akhir' => $rate_sgd,
                'last_update_by' => $last_update_by,
                'last_update_date' => $last_update_date,
                'ip_address' => $ip
            );
            $this->m_po_journal->update_bulanan($nojurnalinvoice, $data2);

            for ($i = 0; $i < count($itemid); $i++) {
                $query = $this->m_po_journal->cek_item($nojurnalinvoice, $itemid[$i]);
                if ($query == 1) {
                    $qty_lain[$i] = $qty_pi1[$i] - $qty_awal[$i];
                    $qty_pij[$i] = $qty_lain[$i] + str_replace(',', '', $qty[$i]);
                } else {
                    $qty_pij[$i] = str_replace(',', '', $qty[$i]) + $qty_pi1[$i];
                }
            }

            $this->m_po_journal->delete_item($nojurnalinvoice);
            for ($i = 0; $i < count($itemid); $i++) {
                //echo $detailid[$i];
                $data_item = array(
                    'HeaderID' => $nojurnalinvoice,
                    'ItemID' => $itemid[$i],
                    'ItemName' => $itemname[$i],
                    'Qty' => str_replace(',', '', $qty[$i]),
                    'unit' => $unit[$i],
                    'price' => str_replace(',', '', $price[$i]),
                    'amount' => str_replace(',', '', $amount[$i]),
                    'currency' => $currency_id,
                    'rate' => $ratedetail[$i],
                    'usdequivalent' => str_replace(',', '', $grandtotal[$i]),
                    'npbbitem' => $npbbno[$i],
                    'last_update_by' => $created_by,
                    'last_update_date' => $created_date,
                    'IP' => $ip,
                    'NoCOA' => substr($txtcoa[$i], 0, 6),
                    'gst_type' => $gst_name[$i],
                    'gst_value' => str_replace(',', '', $gst_value[$i])
                );

                $this->m_po_journal->simpan_item($data_item);
            }

            $kode_supp = $this->input->post('sup');

            $this->m_po_journal->delete_detail($nojurnalinvoice);
            for ($o = 1; $o < count($detailid); $o++) {
                $data_jurnal = array(
                    'JenisJurnalID' => $jurnaljenis[$o],
                    'NoUrut' => $noUrut[$o],
                    'jenis_trans' => $jenistrans,
                    'CompanyID' => 'PSS',
                    'Tanggal' => $tanggal_invoice,
                    'NoJurnal' => $nojurnalinvoice,
                    'NoCOA' => $no_coa[$o],
                    'sub_account_type' => 'HUT',
                    'sub_account_id' => $kode_sup,
                    'CHK' => $dk[$o],
                    'Uraian' => $ket[$o],
                    'Debet' => str_replace(',', '', $debetfooter1[$o]),
                    'Kredit' => str_replace(',', '', $creditfooter1[$o]),
                    'Total' => str_replace(',', '', $totalfooter1[$o]),
                    'Currency' => $currency_id,
                    'Rate' => $rate,
                    'rate_sgd' => $rate_sgd,
                    'TotalAsal' => '0',
                    'CurrencyAsal' => '0',
                    'RateAsal' => $rate,
                    'Keterangan' => '-',
                    'last_update_by' => $created_by,
                    'last_update_date' => $created_date,
                    'ip_address' => $ip
                );
                // echo $debetfooter1[$o]." ".$creditfooter1[$o]."<br>";
                if ($debetfooter1[$o] != 0 || $creditfooter1[$o] != 0) {
                    // echo $debetfooter1[$o]." ".$creditfooter1[$o]."<br>";
                    $this->m_po_journal->simpan_detail($data_jurnal);
                }
            }

            for ($i = 0; $i < count($itemid); $i++) {
                $detail_jur = array(
                    'JenisJurnalID' => 'PV/GL',
                    'NoUrut' => 0,
                    'CompanyID' => 'PSS',
                    'jenis_trans' => $jenistrans,
                    'Tanggal' => $tanggal_invoice,
                    'NoJurnal' => $nojurnalinvoice,
                    'chk' => 'D',
                    'NoCOA' => substr($txtcoa[$i], 0, 6),
                    'sub_account_type' => 'HUT',
                    'sub_account_id' => $kode_sup,
                    'uraian' => $itemname[$i],
                    'Debet' => str_replace(',', '', $amount[$i]),
                    'Kredit' => 0,
                    'Total' => str_replace(',', '', $amount[$i]),
                    'currency' => $currency_id,
                    'Rate' => $rate,
                    'rate_sgd' => $rate_sgd,
                    'TotalAsal' => str_replace(',', '', $amount[$i]),
                    'CurrencyAsal' => $currency_id,
                    'RateAsal' => $rate,
                    'Keterangan' => '-',
                    'last_update_by' => $created_by,
                    'last_update_date' => $created_date,
                    'ip_address' => $ip,
                    'gst_type' => $gst_name[$i],
                    'gst_value' => str_replace(',', '', $gst_value[$i]),
                    'Keterangan' => $remark
                );
                $this->m_po_journal->simpan_detail($detail_jur);
            }

            for ($i = 0; $i < count($itemid); $i++) {
                // echo $npbbno[$i];
                // echo $itemid[$i];
                // echo $qty[$i];
                $data_pi = array(
                    'qty_pi' => $qty_pij[$i],
                    'no_reff' => $nojurnalinvoice
                );
                $query100 = $this->m_po_journal->update_gr($npbbno[$i], $itemid[$i], $data_pi);
            }
            $this->session->set_flashdata("message", "<div class=\"alert alert-warning\" id=\"alert\">Berhasil Di simpan </div>");
            redirect("PO_journal/edit?id=$nojurnalinvoice&ve=$idsupp&cur=$currency");
            //penutup else if submit value    
        }
        //penutup function
    }

//-----------------------------------------------------------------------CEK-------------------------------------------------------------
//-----------------------------------------------------------------------ABOUT MON PO-----------------------------------------------------
    public function mon_purchase_order() {
        $data['POoutstanding'] = $this->m_po_journal->tampil_po_outstanding();
        $this->template->display('accounting/mon_purchase_order', $data);
    }

//--------------------------------------------------------------------END----------------------------------------------------------------
}
