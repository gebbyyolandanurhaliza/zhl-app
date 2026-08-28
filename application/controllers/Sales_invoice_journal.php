<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Sales_invoice_journal extends CI_Controller {

    function __construct() {
        parent::__construct();
        if (!$this->session->userdata('userid_1')) {
            redirect('login');
        }
        $this->load->model(array('M_sales_journal', 'm_po_journal'));
        $this->load->library(array('template', 'user_agent', 'fpdf'));
        //$this->load->model(array('M_gen_master', 'M_mar_master', 'M_mar_product'));
    }

    public function index() {
        $data['getList'] = $this->M_sales_journal->get_list();

        $this->template->display('accounting/sales_journal/sales_list', $data);
    }

    public function addnew() {
        $data['cur'] = $this->m_po_journal->tampil_cur();
        // $data['po'] = $this->m_po_journal->ambil_PO();
        $data['supp'] = $this->M_sales_journal->get_customer();
        $data['coa'] = $this->m_po_journal->tampil_coa();
        $id = $this->input->get('contract_no');
        $data['tampilpo'] = $this->M_sales_journal->tampil_item_jurnal($id);
        $data['tampil'] = $this->M_sales_journal->tampil_header_jurnal();
        
        $data['get_data_header'] = $this->M_sales_journal->get_data_header($id);
        $data['get_data_footer'] = $this->M_sales_journal->get_data_footer($id);
        $data['get_data_item'] = $this->M_sales_journal->get_data_item($id);
        
       // $data['get_data_dp'] = $this->M_sales_journal->get_data_dp($id);
        $data['get_data_sales'] = $this->M_sales_journal->get_data_sales($id);
        $this->template->display('accounting/sales_journal/sales_form', $data);
    }

    public function edit() {
        $data['cur'] = $this->m_po_journal->tampil_cur();
        $data['po'] = $this->m_po_journal->ambil_PO();
        $data['supp'] = $this->M_sales_journal->get_customer();
        $data['coa'] = $this->m_po_journal->tampil_coa();
        $id = $this->input->get("id");
        $supp = $this->input->get("supp");
        $cur = $this->input->get("cur");
        // echo $supp;
        // echo $cur;

        $data['get_data_header'] = $this->M_sales_journal->get_data_header($id);
        $data['get_data_footer'] = $this->M_sales_journal->get_data_footer($id);
        $data['get_data_item'] = $this->M_sales_journal->get_data_item($id);
        $data['tampilpo'] = $this->M_sales_journal->tampil_item_jurnal($supp, $cur);
        $data['tampil'] = $this->M_sales_journal->tampil_header_jurnal();
        $this->template->display('accounting/sales_journal/sales_form', $data);
        // $data['get_data_header'] = $this->M_sales_journal
    }

    public function print_report() {
        $data['cur'] = $this->m_po_journal->tampil_cur();
        $data['po'] = $this->m_po_journal->ambil_PO();
        $data['supp'] = $this->M_sales_journal->get_customer();
        //$data['chk'] = $this->M_po_journal->get_chk();

        $id = $this->input->get("id");
        // echo $id;
        $data['get_header'] = $this->M_sales_journal->get_data_header($id);
        // $data['get_data_detail'] = $this->M_po_journal->get_data_detail($id);
        $data['get_footer'] = $this->M_sales_journal->get_data_footer($id);
        $data['get_item'] = $this->M_sales_journal->get_data_item($id);
        //$data['tampilpo'] = $this->M_po_journal->tampil_item_jurnal($vendor,$cur);
        //$this->template->display('accounting/purchase_jurnal/PO_Journal_form' , $data);
        $this->load->view('accounting/rpt/rpt_sales_1', $data);
    }

    public function tampilpo() {
        $get = $this->uri->segment(3);
        $get1 = $this->uri->segment(4);
        // echo $get;
        // echo $get1;
        $data['tampilpo'] = $this->M_sales_journal->tampil_item_jurnal($get, $get1);
        $this->load->view('accounting/sales_journal/tampilpo', $data);
    }

    public function save_jurnal() {
        // $submit_value = $this->input->post('');
        $nojurnalinvoice = $this->input->post('nofaktur');
        $company_id = 'PSS';
        $currency = $this->input->post('cur');
        $currency_id = $this->input->post('curid');
        $rate = $this->input->post('rate');
        $rate_awal = $this->input->post('rate');
        $rate_akhir = $this->input->post('rate');
        $tgl_jurnal = new DateTime($this->input->post('tgl_jurnal'));
        $tanggal_jurnal = date_format($tgl_jurnal, "Y-m-d");
        $tgl_invoice = new DateTime($this->input->post('tgl_invoice'));
        $tanggal_invoice = date_format($tgl_invoice, "Y-m-d");
        $tgl_tempo = new DateTime($this->input->post('tgl_tempo'));
        $tanggal_tempo = date_format($tgl_tempo, "Y-m-d");
        $term = $this->input->post('term');
        $kode_cust = $this->input->post('idsup');
        $symbol_currency = $this->input->post('symbol_currency');
        $totalitem = $this->input->post('nota_debet');
        $jenistrans = 'SIJC';
        // echo $kode_cust;
        $npbbno = $this->input->post('npbbno');
        //echo $npbbno[0]."<br>";
        $itemid = $this->input->post('txtidem');
        //echo $itemid[0]."<br>";
        $itemname = $this->input->post('txtinem');
        //echo $itemname[0]."<br>";
        $qty = $this->input->post('txtqty');
        //echo $qty[0]."<br>";
        $qty_pi1 = $this->input->post('txtqty_pi');
        //echo $qty_pi1[0]."<br>";
        //$qty_pij = $qty_pi1+$qty;
        $unit = $this->input->post('txtunit');
        //echo $unit[0]."<br>";
        $price = $this->input->post('txtprice');
        //echo $price[0]."<br>";
        $amount = $this->input->post('txtamount');
        //echo $amount[0]."<br>";
        $currencydetail = $this->input->post('txtcurrency');
        //echo $currencydetail[0]."<br>";
        $ratedetail = $this->input->post('txtrate');
        //echo $ratedetail[0]."<br>";
        $grandtotal = $this->input->post('txtgrand');
        //echo $grandtotal[0]."<br>";
        $npbb = $this->input->post('txtnpbb');
        //echo $npbb[0]."<br>";
        //footer
        $detailid = $this->input->post('DetailID');
        //echo $detailid[0]."<br>";
        $no_coa = $this->input->post('no_coa');
        //echo $no_coa[0]."<br>";
        $dk = $this->input->post('dk');
        //echo $dk[0]."<br>";
        $jurnaljenis = $this->input->post('JenisJurnal');
        //echo $jurnaljenis[0]."<br>";
        $noUrut = $this->input->post('NoUrut');
        //echo $noUrut[0]."<br>";
        $ket = $this->input->post('desc');
        //echo $ket[0]."<br>";

        $totalfooter = $this->input->post('total');
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
        // echo $pajak."<br>";
        $diskon = $totalfooter[1];
        //echo $diskon."<br>";
        $biaya_lain = $totalfooter[3];
        //echo $biaya_lain."<br>";
        $uang_muka = $totalfooter[4];
        //echo $uang_muka."<br>";
        $nota_kredit = 0;
        $hutang = $totalfooter[5];
        //echo $hutang;
        $saldo_hutang = $totalfooter[5];
        //echo $saldo_hutang;
        $bayar = 0;
        $idsupp = $this->input->post('sup');

        $idcontract = $this->input->post('npbbid');
        $productid = $this->input->post('productid');
        // echo $idcontract[0]."<br>".$productid[0]."<br>";
        // echo $idcontract[1]."<br>".$productid[1]."<br>";
        // echo $idcontract[2]."<br>".$productid[2]."<br>";
        // echo $idcontract[3]."<br>".$productid[3];


        if ($submit_value == 'Save') {
            $query = $this->m_po_journal->cek('acc_tbl_trn_piutang', 'nofaktur', $nojurnalinvoice);
            if ($query == 1) {
                redirect('Sales_invoice_journal/addnew');
                $this->session->set_flashdata("message", "<div class=\"alert alert-warning\" id=\"alert\">Duplicate No PO " . $docno . "</div>");
            } else {
                for ($i = 0; $i < count($qty); $i++) {
                    $qty_sim[$i] = $qty[$i] + $qty_pi1[$i];
                }

                $data_piutang = array(
                    'nofaktur' => $nojurnalinvoice,
                    'tanggal' => $tanggal_jurnal,
                    'tanggal_invoice' => $tanggal_invoice,
                    'tanggal_tempo' => $tanggal_tempo,
                    'term' => $term,
                    'kode_sup' => $kode_cust,
                    'jenis_trans' => $jenistrans,
                    'currency_id' => $currency_id,
                    'rate' => $rate,
                    'rate_awal' => $rate_awal,
                    'rate_akhir' => $rate_akhir,
                    'pajak' => $pajak,
                    'diskon' => $diskon,
                    'biaya_lain' => $biaya_lain,
                    'uang_muka' => $uang_muka,
                    'nota_debet' => 0,
                    'nota_kredit' => 0,
                    'piutang' => $saldo_hutang,
                    'created_by' => $created_by,
                    'created_date' => $created_date,
                    'ip_address' => $ip);

                $data_piutang_bulanan = array(
                    'nofaktur' => $nojurnalinvoice,
                    'periode_bulan' => $bln,
                    'periode_tahun' => $thn,
                    'tanggal' => $tanggal_jurnal,
                    'currency_id' => $currency_id,
                    'rate_awal' => $rate_awal,
                    'rate_akhir' => $rate_akhir,
                    'uang_muka' => $uang_muka,
                    'nota_debet' => 0,
                    'nota_kredit' => 0,
                    'piutang' => $saldo_hutang,
                    'saldo_piutang' => $saldo_hutang,
                    'bayar' => 0,
                    'created_by' => $created_by,
                    'created_date' => $created_date,
                    'ip_address' => $ip
                );

                $this->M_sales_journal->simpan_header($data_piutang);
                $this->M_sales_journal->simpan_bulanan($data_piutang_bulanan);

                for ($i = 0; $i < count($itemid); $i++) {
                    $data_item = array(
                        'HeaderID' => $nojurnalinvoice,
                        'ItemID' => $itemid[$i],
                        'ItemName' => $itemname[$i],
                        'Qty' => $qty[$i],
                        'unit' => $unit[$i],
                        'price' => $price[$i],
                        'amount' => $amount[$i],
                        'currency' => $currency_id,
                        'rate' => $rate,
                        'usdequivalent' => $grandtotal[$i],
                        'npbbitem' => $npbbno[$i],
                        'created_by' => $created_by,
                        'created_date' => $created_date,
                        'IP' => $ip
                    );
                    $this->M_sales_journal->simpan_item($data_item);
                }

                for ($i = 0; $i < count($detailid); $i++) {
                    $data_jurnal = array(
                        'JenisJurnalID' => $jurnaljenis[$i],
                        'NoUrut' => $noUrut[$i],
                        'CompanyID' => 'PSS',
                        'Tanggal' => $tanggal_jurnal,
                        'NoJurnal' => $nojurnalinvoice,
                        'NoCOA' => $no_coa[$i],
                        'sub_account_type' => $kode_cust,
                        'sub_account_id' => $jenistrans,
                        'CHK' => $dk[$i],
                        'Uraian' => $ket[$i],
                        'Debet' => $debetfooter[$i],
                        'Kredit' => $creditfooter[$i],
                        'Total' => $totalfooter[$i],
                        'currency' => $currency_id,
                        'Rate' => $ratefooter[$i],
                        'TotalAsal' => 0,
                        'CurrencyAsal' => $currency_id,
                        'RateAsal' => $rate,
                        'Keterangan' => '-',
                        'Created_by' => $created_by,
                        'Created_date' => $created_date,
                        'ip_address' => $ip
                            );
                    $this->M_sales_journal->simpan_detail($data_jurnal);
                }

                for ($i = 0; $i < count($npbb); $i++) {
                    $data_sim = array(
                        'qty_sim' => $qty_sim[$i]
                    );
                    $this->M_sales_journal->update_sim($idcontract[$i], $productid[$i], $data_sim);
                }
                redirect("Sales_invoice_journal/edit?id=$nojurnalinvoice&supp=$kode_cust&cur=$currency_id");
                //Penutup else
            }
            //Penutup IF Value Submit = 'Save'
        } else {
            $qty_awal = $this->input->post('txtqty_awal');
            for ($i = 0; $i < count($itemid); $i++) {
                $query = $this->M_sales_journal->cek_item($nojurnalinvoice, $itemid[$i]);
                // echo $query."<br>";
                if ($query == 1) {
                    $qty_lain[$i] = $qty_pi1[$i] - $qty_awal[$i];
                    $qty_sim[$i] = $qty_lain[$i] + $qty[$i];
                    // echo $qty_lain[$i]." = ".$qty_pi1[$i]." - ".$qty_awal[$i]."<br>";
                    // echo $qty_sim[$i]." = ".$qty_lain[$i]." + ".$qty[$i]."<br>";
                } else {
                    $qty_sim[$i] = $qty[$i] + $qty_pi1[$i];
                    //echo $qty_sim[$i]." = ".$qty[$i]." + ".$qty_pi1[$i]."<br>";
                }
            }

            for ($i = 0; $i < count($itemid); $i++) {
                $data_sim = array(
                    'qty_sim' => $qty_sim[$i]
                );
                //echo $qty_sim[$i]."<br>";
                $this->M_sales_journal->update_sim($idcontract[$i], $productid[$i], $data_sim);
            }

            $data = array(
                'pajak' => $pajak,
                'diskon' => $diskon,
                'biaya_lain' => $biaya_lain,
                'uang_muka' => $uang_muka,
                'nota_debet' => 0,
                'nota_kredit' => 0,
                'piutang' => $saldo_hutang,
                'last_update_by' => $last_update_by,
                'last_update_date' => $last_update_date,
                'ip_address' => $ip
            );
            $this->M_sales_journal->update_header($nojurnalinvoice, $data);

            $data2 = array(
                'piutang' => $hutang,
                'last_update_by' => $last_update_by,
                'last_update_date' => $last_update_date,
                'ip_address' => $ip
            );
            $this->M_sales_journal->update_bulanan($nojurnalinvoice, $data2);

            $this->M_sales_journal->delete_item($nojurnalinvoice);

            for ($i = 0; $i < count($itemid); $i++) {
                $data_item = array(
                    'HeaderID' => $nojurnalinvoice,
                    'ItemID' => $itemid[$i],
                    'ItemName' => $itemname[$i],
                    'Qty' => $qty[$i],
                    'unit' => $unit[$i],
                    'price' => $price[$i],
                    'amount' => $amount[$i],
                    'currency' => $currency_id,
                    'rate' => $rate,
                    'usdequivalent' => $grandtotal[$i],
                    'npbbitem' => $npbbno[$i],
                    'created_by' => $created_by,
                    'created_date' => $created_date,
                    'IP' => $ip
                );
                $this->M_sales_journal->simpan_item($data_item);
            }

            $this->M_sales_journal->delete_detail($nojurnalinvoice);

            for ($i = 0; $i < count($detailid); $i++) {
                $data_jurnal = array(
                    'JenisJurnalID' => $jurnaljenis[$i],
                    'NoUrut' => $noUrut[$i],
                    'CompanyID' => 'PSS',
                    'Tanggal' => $tanggal_jurnal,
                    'NoJurnal' => $nojurnalinvoice,
                    'NoCOA' => $no_coa[$i],
                    'sub_account_type' => $kode_cust,
                    'sub_account_id' => $jenistrans,
                    'CHK' => $dk[$i],
                    'Uraian' => $ket[$i],
                    'Debet' => $debetfooter[$i],
                    'Kredit' => $creditfooter[$i],
                    'Total' => $totalfooter[$i],
                    'currency' => $currency_id,
                    'Rate' => $ratefooter[$i],
                    'TotalAsal' => 0,
                    'CurrencyAsal' => $currency_id,
                    'RateAsal' => $rate,
                    'Keterangan' => '-',
                    'Created_by' => $created_by,
                    'Created_date' => $created_date,
                    'ip_address' => $ip
                        );
                $this->M_sales_journal->simpan_detail($data_jurnal);
            }
            redirect("Sales_invoice_journal/edit?id=$nojurnalinvoice&supp=$idsupp&cur=$currency");
        }


        //penutup function save	
    }

}
