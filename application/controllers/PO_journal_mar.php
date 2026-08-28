<?php
	if(!defined('BASEPATH')) exit ('No direct access allowed');

	class PO_journal_mar extends CI_Controller{
		function __construct() {
	        parent::__construct();
	       	$this->load->model(array('M_period'));
	        if (!$this->session->userdata('userid_1')) {
	            redirect('login');
	        }
	         $this->load->model(array('M_po_journal','M_po_journal_mar','M_Receivable_recognition'));
    	}

    	function index(){
    		$data['getList'] = $this->M_po_journal_mar->get_list();
    		$this->template->display('accounting/purchase_jurnal_mar/PO_journal_list', $data);
    	}

    	function addnew(){
    		// $data['cur'] = $this->M_po_journal->tampil_cur();
            $data['cur'] = $this->M_po_journal->get_cur();
    		$data['supp'] = $this->M_po_journal_mar->get_factory();
            $data['coa'] = $this->M_po_journal->tampil_coa();
            $data['_Tax'] = $this->M_po_journal->get_coaTax();
            $data['_Discount'] = $this->M_po_journal->get_coaDiscount();
    		$this->template->display('accounting/purchase_jurnal_mar/PO_journal_form', $data);
    	}

    	function tampilpo(){
    		$get = $this->uri->segment(3);
            $get1 = $this->uri->segment(4);

            $data['tampilpo'] = $this->M_po_journal_mar->tampil_item_jurnal($get, $get1);
            $this->load->view('accounting/purchase_jurnal_mar/tampilpo', $data);
    	}

        function edit(){
            $data['cur'] = $this->M_po_journal->tampil_cur();
            $data['supp'] = $this->M_po_journal_mar->get_factory();
            $data['coa'] = $this->M_po_journal->tampil_coa();
            $id = $this->input->get("id");
            $vendor = $this->input->get("ve");
            $cur = $this->input->get("cur");
            $data['get_data_header'] = $this->M_po_journal->get_data_header($id);
            $data['get_data_footer'] = $this->M_po_journal->get_data_footer($id);
            $data['get_data_item'] = $this->M_po_journal_mar->get_data_item($id);
            $data['tampilpo'] = $this->M_po_journal_mar->tampil_item_jurnal($vendor, $cur);
            $data['_Tax'] = $this->M_po_journal->get_coaTax();
            $data['_Discount'] = $this->M_po_journal->get_coaDiscount();
            $data['get_data_jurnal1'] = $this->M_Receivable_recognition->get_data_awal($id, 'PF/GL');
            $data['get_data_jurnal2'] = $this->M_Receivable_recognition->get_data_jurnal(2, $id, 'PIJF');
            $data['get_data_jurnal3'] = $this->M_Receivable_recognition->get_data_jurnal(3, $id, 'PIJF');
            $data['get_data_jurnal4'] = $this->M_Receivable_recognition->get_data_jurnal(4, $id, 'PIJF');
            $data['get_data_jurnal5'] = $this->M_Receivable_recognition->get_data_jurnal(5, $id, 'PIJF');
            $data['get_data_jurnal6'] = $this->M_Receivable_recognition->get_data_jurnal(6, $id, 'PIJF');
            $this->template->display('accounting/purchase_jurnal_mar/PO_journal_form', $data);
        }

        function print_report(){
            $data['cur'] = $this->M_po_journal->tampil_cur();
            $data['supp'] = $this->M_po_journal_mar->get_factory();
            $id = $this->input->get("id");
            $data['get_header'] = $this->M_po_journal->get_data_header($id);
            $data['get_footer'] = $this->M_po_journal->get_data_footer($id);
            $data['get_item'] = $this->M_po_journal_mar->get_data_item($id);
            $this->load->view('accounting/rpt/rpt_purchase_2', $data);
        }

        function save_jurnal_invoice(){
           //header
            $nojurnalinvoice = $this->input->post('nofaktur');
            $company_id = 'PSS';
            $currency = $this->input->post('cur');
            $currency_id = $this->input->post('curid');
            $rate = $this->input->post('rate');
            $rate_awal = $this->input->post('rate');
            $rate_akhir = $this->input->post('rate');
            $tgl_jurnal = new DateTime($this->input->post('tgl_jurnal'));
            $tanggal_jurnal = date_format($tgl_jurnal,"Y-m-d");
            $tgl_invoice = new DateTime($this->input->post('tgl_invoice'));
            $tanggal_invoice = date_format($tgl_invoice,"Y-m-d");
            $tgl_tempo = new DateTime($this->input->post('tgl_tempo'));
            $tanggal_tempo = date_format($tgl_tempo,"Y-m-d");
            $term = $this->input->post('term');
            $kode_sup = $this->input->post('idsup');
            $symbol_currency = $this->input->post('symbol_currency');
            $totalitem = $this->input->post('nota_debet');
            // $pajak = 0;
            // $diskon = 0;
            // $biaya_lain = 0;
            // $uang_muka = 0;
            // $nota_kredit = 0;
            // $hutang = 0;
            // $saldo_hutang = 0;
            // $bayar = 0;
            $jenistrans = 'PIJF';

            //detail
            $npbbno = $this->input->post('npbbni');
            $poid = $this->input->post('npbbno');
            // echo $poid[0];
            $itemid = $this->input->post('txtidem');
            $productid = $this->input->post('txtprodi');
            // echo $productid[0];
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

            $periode_tanggal =  date('d',strtotime($tanggal_jurnal));
            $periode_bulan =  date('m',strtotime($tanggal_jurnal));
            $periode_tahun =  date('Y',strtotime($tanggal_jurnal));
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

            if($submit_value == 'Save')
            {
                $query = $this->M_po_journal->cek('acc_tbl_trn_hutang', 'nofaktur', $nojurnalinvoice);
                if($query == 1){
                    redirect('PO_journal_mar/addnew');
                    $this->session->set_flashdata("message", "<div class=\"alert alert-warning\" id=\"alert\">Duplicate No PO ".$docno."</div>");
                }
                else{
                    for($i = 0 ;$i < count($itemid); $i++){
                        $qty_pij[$i] = $qty[$i] + $qty_pi1[$i];
                    }
                    $data = array(
                        'nofaktur' => $nojurnalinvoice,
                        'company_id' => $company_id,
                        'tanggal' => $tanggal_jurnal,
                        'tanggal_tempo' => $tanggal_tempo,
                        'tanggal_invoice' => $tanggal_invoice,
                        'kode_sup' => $kode_sup,
                        'jenis_trans' => $jenistrans,
                        'currency_id'=>$currency_id,
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
                        'created_by'=>$created_by,
                        'created_date' => $created_date,
                        'ip_address' => $ip
                    );
                    
                    $data2 = array(
                        'nofaktur'=>$nojurnalinvoice,
                        'company_id'=>$company_id,
                        'periode_bulan' => $bln,
                        'periode_tahun'=> $thn,
                        'rate_awal' => $rate_awal,
                        'rate_akhir' => $rate_akhir,
                        'nota_debet' => 0,
                        'nota_kredit' => 0,
                        'hutang' => $hutang,
                        'saldo_hutang' => $hutang,
                        'bayar' => 0,
                        'created_by' => $created_by,
                        'created_date' => $created_date, 
                        'ip_address' => $ip
                    );
                    $this->M_po_journal->simpan_header($data);
                    $this->M_po_journal->simpan_bulanan($data2);

                    for($i = 1; $i < count($detailid); $i++){
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
                            'chk' => $dk[$i],
                            'Uraian' => $ket[$i],
                            'Debet' => $debetfooter[$i],
                            'Kredit' => $creditfooter[$i],
                            'Total' => $totalfooter[$i],
                            'Currency' => $currency_id,
                            'Rate' => $rate,
                            'rate_sgd'=>$rate_sgd,
                            'TotalAsal' => '0',
                            'CurrencyAsal' => '0',
                            'RateAsal' => '0',
                            'Keterangan' => '-',
                            'created_by' => $created_by,
                            'created_date' => $created_date,
                            'ip_address' => $ip,
                        );
                        if(($debetfooter[$i] > 0 || $creditfooter[$i] > 0)){
                            $this->M_po_journal->simpan_detail($data_jurnal);
                        }
                    }

                    for($i = 0; $i < count($itemid); $i++){
                        $detail_jur = array(
                            'JenisJurnalID' => 'PF/GL',
                            'NoUrut' => $noUrut[$i],
                            'jenis_trans' => $jenistrans,
                            'CompanyID' => 'PSS',
                            'Tanggal' => $tanggal_invoice,
                            'NoJurnal' => $nojurnalinvoice,
                            'chk' => 'D',
                            'NoCOA' => substr($txtcoa[$i], 0, 6),
                            'sub_account_type' => 'HUT',
                            'sub_account_id' => $kode_sup,
                            'uraian' => $itemname[$i],
                            'Debet' => $amount[$i],
                            'Kredit' => 0,
                            'TOtal' => $amount[$i],
                            'CurrencyAsal' => $currency_id,
                            'Rate' => $rate,
                            'rate_sgd'=>$rate_sgd,
                            'RateAsal' => $rate,
                            'keterangan' => '-',
                            'created_by' => $created_by,
                            'created_date' => $created_date,
                            'ip_address' => $ip,
                            'gst_type'=>$gst_name[$i],
                            'gst_value' => $gst_value[$i]
                        );
                            $this->M_po_journal->simpan_detail($detail_jur);
                    }

                    for($i = 0; $i < count($itemid); $i++){
                        $data_item = array(
                        'HeaderID'=> $nojurnalinvoice,
                        'ItemID'=>$itemid[$i],
                        'ItemName'=>$itemname[$i],
                        'Qty'=>$qty[$i],
                        'unit'=>$unit[$i],
                        'price'=>$price[$i],
                        'amount'=>$amount[$i],
                        'rate'=>$ratedetail[$i],
                        'usdequivalent'=>$grandtotal[$i],
                        'npbbitem'=>$npbbno[$i],
                        'created_by'=>$created_by,
                        'created_date'=>$created_date,
                        'IP'=>$ip,
                        'NoCOA'=>$txtcoa[$i],
                        'rate_sgd'=>$rate_sgd,
                        'gst_type'=>$gst_name[$i],
                        'gst_value'=>$gst_value[$i]
                        );
                        $this->M_po_journal_mar->simpan_item($data_item);
                    }

                    for($i = 0; $i <count($itemid); $i++){
                        $data_pi = array(
                            'qty_pi' => $qty_pij[$i]
                        );
                        $this->M_po_journal_mar->update_po($poid[$i], $productid[$i], $data_pi);

                    }
                     redirect("PO_journal_mar/edit?id=$nojurnalinvoice&ve=$kode_sup&cur=$currency_id");

                }

             //Penutup if save
            }
            else
            {
             $qty_awal = $this->input->post('txtqty_awal');
            $data = array(
                'pajak' => $pajak,
                'diskon' => $diskon,
                'biaya_lain' => $biaya_lain,
                'uang_muka' => $uang_muka,
                'nota_debet' => 0,
                'nota_kredit' => 0,
                'hutang' => $hutang,
                'saldo_hutang' => $hutang,
                'last_update_by' => $last_update_by,
                'last_update_date' => $last_update_date,
                'ip_address'=>$ip
            );
            $this->M_po_journal->update_header($nojurnalinvoice, $data);

            $data2 = array(
                'hutang' => $hutang,
                'saldo_hutang' => $hutang,
                'last_update_by' => $last_update_by,
                'last_update_date' => $last_update_date,
                'ip_address'=>$ip
            );
            $this->M_po_journal->update_bulanan($nojurnalinvoice, $data2);

            for($i = 0; $i < count($itemid); $i++){
                $query = $this->M_po_journal->cek_item($nojurnalinvoice, $itemid[$i]);
                if($query == 1){
                    $qty_lain[$i] = $qty_pi1[$i] - $qty_awal[$i];
                    $qty_pij[$i] = $qty_lain[$i] + $qty[$i];
                }
                else{
                    $qty_pij[$i] = $qty[$i] + $qty_pi1[$i];
                }
            }

            $this->M_po_journal_mar->delete_item($nojurnalinvoice);
            for($i = 0; $i < count($itemid); $i++){
                    //echo $detailid[$i];
                    $data_item = array(
                        'HeaderID'=> $nojurnalinvoice,
                        'ItemID'=>$itemid[$i],
                        'ItemName'=>$itemname[$i],
                        'Qty'=>$qty[$i],
                        'unit'=>$unit[$i],
                        'price'=>$price[$i],
                        'amount'=>$amount[$i],
                        'rate'=>$ratedetail[$i],
                        'usdequivalent'=>$grandtotal[$i],
                        'npbbitem'=>$npbbno[$i],
                        'created_by'=>$created_by,
                        'created_date'=>$created_date,
                        'IP'=>$ip,
                        'NoCOA'=>$txtcoa[$i],
                        'rate_sgd'=>$rate_sgd,
                        'gst_type'=>$gst_name[$i],
                        'gst_value'=>$gst_value[$i]
                        );
                        $this->M_po_journal_mar->simpan_item($data_item);
            }

            $kode_supp = $this->input->post('sup');
            $this->M_po_journal->delete_detail($nojurnalinvoice);
             for($i = 1; $i < count($detailid); $i++){
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
                            'chk' => $dk[$i],
                            'Uraian' => $ket[$i],
                            'Debet' => $debetfooter[$i],
                            'Kredit' => $creditfooter[$i],
                            'Total' => $totalfooter[$i],
                            'Currency' => $currency_id,
                            'Rate' => $rate,
                            'rate_sgd'=>$rate_sgd,
                            'TotalAsal' => '0',
                            'CurrencyAsal' => '0',
                            'RateAsal' => '0',
                            'Keterangan' => '-',
                            'created_by' => $created_by,
                            'created_date' => $created_date,
                            'ip_address' => $ip,
                        );
                        if(($debetfooter[$i] > 0 || $creditfooter[$i] > 0)){
                            $this->M_po_journal->simpan_detail($data_jurnal);
                        }
                    }

                    for($i = 0; $i < count($itemid); $i++){
                        $detail_jur = array(
                            'JenisJurnalID' => 'PF/GL',
                            'NoUrut' => $noUrut[$i],
                            'jenis_trans' => $jenistrans,
                            'CompanyID' => 'PSS',
                            'Tanggal' => $tanggal_invoice,
                            'NoJurnal' => $nojurnalinvoice,
                            'chk' => 'D',
                            'NoCOA' => substr($txtcoa[$i], 0, 6),
                            'sub_account_type' => 'HUT',
                            'sub_account_id' => $kode_sup,
                            'uraian' => $itemname[$i],
                            'Debet' => $amount[$i],
                            'Kredit' => 0,
                            'TOtal' => $amount[$i],
                            'CurrencyAsal' => $currency_id,
                            'Rate' => $rate,
                            'rate_sgd'=>$rate_sgd,
                            'RateAsal' => $rate,
                            'keterangan' => '-',
                            'created_by' => $created_by,
                            'created_date' => $created_date,
                            'ip_address' => $ip,
                            'gst_type'=>$gst_name[$i],
                            'gst_value' => $gst_value[$i]
                        );
                            $this->M_po_journal->simpan_detail($detail_jur);
                    }


            for($i=0; $i < count($itemid); $i++){
               $data_pi = array(
                            'qty_pi' => $qty_pij[$i]
                        );
                        $this->M_po_journal_mar->update_po($poid[$i], $productid[$i], $data_pi);
            }
            redirect("PO_journal_mar/edit?id=$nojurnalinvoice&ve=$kode_sup&cur=$currency_id");

             //Penutup else update
            }
         //Penutup Function   
        }


	}
?>