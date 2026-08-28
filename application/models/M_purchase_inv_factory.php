<?php

//update date : 2 Dec 16 4,06 PM
//Update By : Ozzy


class M_purchase_inv_factory extends CI_Model {

    var $mst_supplier = 'zhl_mar_vw_mst_customer';
    var $mst_currency = 'zhl_gen_tbl_mst_currency';
    var $acc_tbl_trn_hutang = 'zhl_acc_tbl_trn_hutang';
    var $acc_tbl_trn_jurnal = 'zhl_acc_tbl_trn_jurnal';
    var $acc_tbl_trn_hutang_bulanan = 'zhl_acc_tbl_trn_hutang_bulanan';

    function __construct() {
        parent::__construct();
    }

    function call_sp_rec_hutang_fac($data) {
        $qry = 'call zhl_sp_acc_tbl_trn_hutang(?, ?,?,?, ?,?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?, ?, ?, ?, ?, ?, ?)';
        $this->db->query($qry, $data);
    }

    function simpan_inv(){
            $nofaktur = $this->input->post('nofaktur');
            $company_id = 'PSS';
            $tgl_jurnal = str_replace('/', '-', $this->input->post('tgl_jurnal'));
            $p_tanggal = date('Y-m-d', strtotime($tgl_jurnal));
            $tgl_tempo = str_replace('/', '-', $this->input->post('tgl_tempo'));
            $p_tanggal_tempo = date('Y-m-d', strtotime($tgl_tempo));
            $tgl_invoice = str_replace('/', '-', $this->input->post('tgl_invoice'));
            $p_tanggal_invoice = date('Y-m-d', strtotime($tgl_invoice));
            $supplier = $this->input->post('supplier');
            $jenis_trans = 'PIFF';
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
            $p_hutang = $total[5];
            $created = $this->session->userdata('userid_1');
            if ($created == 'deki') {
                $created_by = 'System Maintanance';
            } else {
                $created_by = $created;
            }
            $created_date = date('Y-m-d');
            $ip_address = $_SERVER['REMOTE_ADDR'];
            $submit_value = $this->input->post('sbt');
            $NoCOA = $this->input->post('NoCOA');
            $NoCOADet = $this->input->post('NoCOADet');
            $id = $this->input->post('Detail_ID');
            $Periode = date('mY', strtotime($tgl_jurnal));
            $status = '2';
            $rate_sgd = $this->input->post('rate_sgd');
            $jr_nocoa = $this->input->post('no_coa');
            $jr_jenisjurnal = $this->input->post('JenisJurnal');
            $jr_desc = $this->input->post('desc');
            $txtRate = $this->input->post('txtRate');
            $jr_NoUrut = $this->input->post('NoUrut');
            $dk = $this->input->post('dk');
            
            $rate_jr = $this->input->post('rate_jr');
            $txtItem = $this->input->post('txtItemId');
            $txtItemName = $this->input->post('txtItemName');
            $txtQty = $this->input->post('txtQty');
            $txtUnit = $this->input->post('txtunit');
            $txtPrice = $this->input->post('txtunitprice');
            $txtAmount = $this->input->post('txtamount');
            $txtusd = $this->input->post('txtusd');
            $ship_product_id = $this->input->post('ship_product_id');
            $txtNoPO = $this->input->post('Detail_po');
            $txtGST = $this->input->post('txtGST');
            $txtGSTValue = $this->input->post('txtGSTValue');
            $SubAccountId = $this->input->post('SubAccountId');
            $disc_per = $this->input->post('dis_per');
            $disc_dol = $this->input->post('dis_dol');
            $txtSono = $this->input->post('txtSono');

            $this->db->trans_off();
            $this->db->trans_start();

            $this->delete_hutang($nofaktur);

            for ($i = 0; $i < count($this->input->post('txtItemId')); $i++) {
                $det_item = array('HeaderID' => $nofaktur,
                    'sono' => $ship_product_id[$i],
                    'po_no' => $txtNoPO[$i],
                    'ItemID' => $txtItem[$i],
                    'ItemName' => $txtItemName[$i],
                    'Qty' => round(str_replace(",", "", $txtQty[$i]), 2),
                    'unit' => $txtUnit[$i],
                    'price' => round(str_replace(",", "", $txtPrice[$i]), 4),
                    'amount' =>     round(str_replace(",", "", $txtAmount[$i]), 2),
                    'currency' =>   $currency,
                    'rate' => $rate,
                    'usdequivalent' => round(str_replace(",", "", $txtusd[$i]), 2),
                    'created_by' => $created_by,
                    'created_date' => $created_date,
                    'IP' => $_SERVER['REMOTE_ADDR'],
                    'NoCOA' => $NoCOADet[$i],
                    'rate_sgd' => $rate_sgd,
                    'gst_type' => $txtGST [$i],
                    'gst_value' => round(str_replace(",", "", $txtGSTValue[$i]), 2));

                $this->save_acc_tbl_trn_pi_fac_dtl($det_item);
            }

            $Uraian = $txtItemName[0];
            $sum_debet=0;
            $sum_credit=0;
            $sum_debet_sgd=0;
            $sum_credit_sgd=0;

            //array footer jurnal
            for ($a = 1; $a < 6 ; $a++) {
                $total[$a]=str_replace(",", "", $total[$a]);
                        
                if ($dk[$a] == 'D') {
                    $debet = $total[$a] * $rate_jr[$a];
                    $debet_sgd = $total[$a] * $rate_sgd;
                    $credit = '0';
                    $credit_sgd = '0';
                    $sum_debet += round(str_replace(",", "", $debet),2);
                    $sum_debet_sgd += round(str_replace(",", "", $debet_sgd),2);
                } else {
                    $debet = '0';
                    $debet_sgd = '0';
                    $credit = $total[$a] * $rate_jr[$a];
                    $credit_sgd = $total[$a] * $rate_sgd;
                    $sum_credit += round(str_replace(",", "", $credit),2);
                    $sum_credit_sgd += round(str_replace(",", "", $credit_sgd),2);
                }

                $det_jur = array(
                    'JenisJurnalID' => $jr_jenisjurnal[$a],
                    'NoUrut' => $jr_NoUrut[$a],
                    'CompanyID' => 'PSS',
                    'jenis_trans' => $jenis_trans,
                    'Tanggal' => $p_tanggal,
                    'Periode' => $Periode,
                    'NoJurnal' => $nofaktur,
                    'chk' => $dk[$a],
                    'NoCOA' => substr($jr_nocoa[$a], 0, 6),
                    'sub_account_id' => $supplier,
                    'sub_account_type' => $SubAccountId[$a],
                    'Uraian' => $Uraian,
                    'Debet' => round(str_replace(",", "", $debet), 2),
                    'Kredit' => round(str_replace(",", "", $credit), 2),
                    'Debet_SGD' => round(str_replace(",", "", $debet_sgd), 2),
                    'Kredit_SGD' => round(str_replace(",", "", $credit_sgd), 2),
                    'Total' => round(str_replace(",", "", $total[$a]), 2),
                    'Currency' => $this->input->post('Currency'),
                    'Rate' => $rate_jr[$a],
                    'rate_sgd' => $rate_sgd,
                    'TotalAsal' => round(str_replace(",", "", $total[$a]), 2),
                    'CurrencyAsal' => $this->input->post('Currency'),
                    'RateAsal' => $rate_awal,
                    'Keterangan' => $jr_desc[$a],
                    'created_by' => $created_by,
                    'created_date' => $created_date,
                    'ip_address' => $ip_address,
                );

                $this->simpan_jurnal($det_jur);
            }

            for ($i = 0; $i < count($this->input->post('txtItemId')); $i++) {
                $txtQty[$i]=str_replace(",", "", $txtQty[$i]);
                $txtPrice[$i]=str_replace(",", "", $txtPrice[$i]);
                
                $debet2 = ($txtQty[$i] * $txtPrice[$i]) * $rate;
                $debet_sgd2 = ($txtQty[$i] * $txtPrice[$i]) * $rate_sgd;

                $sum_debet += round(str_replace(",", "", $debet2), 2);
                $sum_debet_sgd += round(str_replace(",", "", $debet_sgd2), 2);

                if ((count($this->input->post('txtItemId')) - 1) == $i){
                    $selisih = $sum_debet - $sum_credit;

                    if ($selisih != 0){
                        $debet2 = $debet2 - $selisih;
                    }

                    $selisih_sgd = $sum_debet_sgd - $sum_credit_sgd;

                    if ($selisih_sgd != 0){
                        $debet_sgd2 = $debet_sgd2 - $selisih_sgd;
                    }
                }

                $det_jur1 = array(
                    'JenisJurnalID' => 'COGS',
                    'NoUrut' => 0,
                    'CompanyID' => 'PSS',
                    'jenis_trans' => $jenis_trans,
                    'Tanggal' => $p_tanggal,
                    'Periode' => $Periode,
                    'NoJurnal' => $nofaktur,
                    'chk' => 'D',
                    'NoCOA' => $NoCOADet[$i],
                    'sub_account_id' => $supplier,
                    'sub_account_type' => '',
                    'Uraian' => $txtItemName[$i],
                    'Debet' => round(str_replace(",", "", $debet2), 2),
                    'Kredit' => 0,
                    'Debet_SGD' => round(str_replace(",", "", $debet_sgd2), 2),
                    'Kredit_SGD' => '0',
                    'Total' => round(str_replace(",", "", $txtAmount[$i]), 2),
                    'Currency' => $this->input->post('Currency'),
                    'Rate' => $rate,
                    'rate_sgd' => $rate_sgd,
                    'TotalAsal' => round(str_replace(",", "", $txtAmount[$i]), 4),
                    'CurrencyAsal' => $this->input->post('Currency'),
                    'RateAsal' => $rate_awal,
                    'Keterangan' => $txtItemName[$i],
                    'created_by' => $created_by,
                    'created_date' => $created_date,
                    'ip_address' => $ip_address,
                );
                $this->simpan_jurnal($det_jur1);

                $gst_item = array(
                    'ref_nomor' => $nofaktur,
                    'jenis_trans' => $jenis_trans,
                    'item' => $txtItem[$i],
                    'po_no' => $txtNoPO[$i],
                    'qty' => round(str_replace(",", "", $txtQty[$i]), 2),
                    'gst_type' => $txtGST[$i],
                    'gst_value' => round(str_replace(",", "", $txtGSTValue[$i]), 2),
                    'unit' => $txtUnit[$i],
                    'price' => round(str_replace(",", "", $txtPrice[$i]), 4),
                    'currency' => $this->input->post('Currency'),
                    'rate' => $rate,
                    'rate_sgd' => $rate_sgd,
                    'created_by' => $created_by,
                    'created_date' => $created_date,
                    'ip_address' => $ip_address,
                );
                if ($txtGST[$i] <> "") {
                    $this->simpan_gst_payable($gst_item);
                }
                //update pur_tbl_trn_gr_dtl
                $this->update_mar_tbl_trn_shipping_intruction_dtl($nofaktur, $ship_product_id[$i], $txtQty[$i]);
            }

            $this->hapus_COA_kosong();
            
            
            $stsDP = $this->input->post("stsDP");
            // update tabel dp
            $detail_dp_id = $this->input->post("detail_dp_id");
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
             
            if($submit_value == 'Save') {
                $perintah = 'add';
            }  else {
                $perintah = 'edit';
            }

            $data = array('p_perintah' => $perintah,
                'p_nofaktur' => $nofaktur,
                'p_company_id' => 'PSS',
                'p_tanggal' => $p_tanggal,
                'p_tanggal_tempo' => $p_tanggal_tempo,
                'p_tanggal_invoice' => $p_tanggal_invoice,
                'p_kode_sup' => $supplier,
                'p_jenis_trans' => $jenis_trans,
                'p_currency_id' => $this->input->post('Currency'),
                'p_term' => $term,
                'p_rate' => $rate,
                'p_rate_sgd' => $rate_sgd,
                'p_pajak' => round(str_replace(",", "",$p_pajak),2),
                'p_diskon' => round(str_replace(",", "",$p_diskon),2),
                'p_biaya_lain' => round(str_replace(",", "",$p_biaya_lain),2),
                'p_uang_muka' => round(str_replace(",", "",$p_uang_muka),2),
                'p_hutang' => round(str_replace(",", "",$p_hutang),2),
                'p_status' => '0',
                'p_created_by' => $created_by,
                'p_ip_address' => $ip_address,
                'p_nocoa' => $NoCOA,
                'p_status_dp' => $status_dp
            );
            $this->call_sp_rec_hutang_fac($data);

            $this->db->trans_complete();

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $data=array('flag'=>'False');
                return $data;
            }else {
                $this->db->trans_commit();
                $data=array('flag'=>'True');
                return $data;
            }
    }

    function delete_all_item($id) {
        $this->db->where('HeaderID', $id);
        $this->db->delete('zhl_acc_tbl_trn_pi_fac_dtl');
    }

    function simpan_tbl_trn_hutang($data) {
        $this->db->insert($this->acc_tbl_trn_hutang, $data);
    }

    function update_tbl_trn_hutang($id, $data) {
        $this->db->where('nofaktur', $id);
        $this->db->update($this->acc_tbl_trn_hutang, $data);
    }

    function simpan_hutang_bulanan($bulan) {
        $this->db->insert($this->acc_tbl_trn_hutang_bulanan, $bulan);
    }

    function update_hutang_bulanan($nofaktur, $data) {
        $this->db->where('nofaktur', $nofaktur);
        $this->db->update($this->acc_tbl_trn_hutang_bulanan, $data);
    }

    function save_acc_tbl_trn_pi_fac_dtl($det_item) {
        $this->db->insert('zhl_acc_tbl_trn_pi_fac_dtl', $det_item);
    }

    function simpan_jurnal($footer_purc) {
        $this->db->insert('zhl_acc_tbl_trn_jurnal', $footer_purc);
    }

    function update_jurnal($DetailID1, $footer_purc) {
        $this->db->where('DetailID', $DetailID1);
        $this->db->update('zhl_acc_tbl_trn_jurnal', $footer_purc);
    }

    function delete_item($id) {
        $this->db->where('DetailID', $id);
        $this->db->delete('zhl_acc_tbl_trn_pi_fac_dtl');
    }

    function delete_jurnal($id) {
        $this->db->where('DetailID', $id);
        $this->db->delete('zhl_acc_tbl_trn_jurnal');
    }

    function get_list_hutang() {
        $this->db->where('jenis_trans', 'PIFF');
        $this->db->order_by('tanggal', 'Desc');
        $sql_product = $this->db->get('zhl_vw_acc_tbl_trn_hutang');

        if ($sql_product->num_rows() > 0) {
            foreach ($sql_product->result() as $data) {
                $hasil[] = $data;
            }
            return $hasil;
        }
    }

    function advance_list_hutang1($invoice, $supplier) {
        $sql_product = $this->db->query("select * from zhl_vw_acc_tbl_trn_hutang WHERE kode_sup like '%$supplier%' and nofaktur like '%$invoice%'");

        if ($sql_product->num_rows() > 0) {
            foreach ($sql_product->result() as $data) {
                $hasil[] = $data;
            }
            return $hasil;
        }
    }

    function advance_list_hutang($dari, $sampai, $invoice, $supplier) {
        $sql_product = $this->db->query("select * from zhl_vw_acc_tbl_trn_hutang WHERE tanggal >= '$dari' and tanggal <= '$sampai' AND kode_sup like '%$supplier%' and nofaktur like '%$invoice%'");
        if ($sql_product->num_rows() > 0) {
            foreach ($sql_product->result() as $data) {
                $hasil[] = $data;
            }
            return $hasil;
        }
    }

    function nota($id) {
        $this->db->select('*');
        $this->db->where('nofaktur', $id);
        $sql_product = $this->db->get('zhl_vw_acc_tbl_trn_hutang');

        if ($sql_product->num_rows() > 0) {
            foreach ($sql_product->result() as $data) {
                $hasil[] = $data;
            }
            return $hasil;
        }
    }

    function get_sup() {
        $this->db->where('status_customer', '1');
        $this->db->where('group_customer', '4');
        $sql_prov = $this->db->get('zhl_mar_vw_mst_customer_n');
        if ($sql_prov->num_rows() > 0) {
            $result[''] = 'Select';
            foreach ($sql_prov->result_array() as $row) {
                $result[$row['customer_code'] . "|" . $row['coa']] = ucwords(strtoupper($row['customer_name']));
                //$result[$row['customer_code']] = ucwords(strtoupper($row['customer_name']));
            }
            return $result;
        } else {
            echo "";
        }
    }

    function get_cust() {
        $this->db->where('status_customer', '1');
        $this->db->where('group_customer', '4');
        $sql_prov = $this->db->get('zhl_mar_vw_mst_customer');
        if ($sql_prov->num_rows() > 0) {
            $result[''] = 'Select';
            foreach ($sql_prov->result_array() as $row) {
                $result[$row['customer_code']] = ucwords(strtoupper($row['customer_name']));
            }
            return $result;
        } else {
            echo "";
        }
    }

    function tampil_po_list($supplier, $currency) {
        $sql = $this->db->query("SELECT * FROM zhl_vw_acc_tbl_trn_pi_factory WHERE sisa > 0 and currency_id = '$currency' and factory_abbr = '$supplier'");
        if ($sql->num_rows() > 0) {
            foreach ($sql->result() as $data) {
                $hasil[] = $data;
            }
            return $hasil;
        }
    }

    function get_currency() {
        $sql_prov = $this->db->get('zhl_gen_tbl_mst_currency');
        if ($sql_prov->num_rows() > 0) {
            $result[''] = 'Select';
            foreach ($sql_prov->result_array() as $row) {
                $result[$row['currency_id']] = ucwords(strtoupper($row['currency_id']));
            }
            return $result;
        } else {
            echo "Not data avaible";
        }
    }

    function get_currency_detail() {
        $sql_prov = $this->db->get($this->mst_currency);
        if ($sql_prov->num_rows() > 0) {
            $result[''] = 'Select';
            foreach ($sql_prov->result_array() as $row) {
                $result[$row['currency_id']] = ucwords(strtoupper($row['currency_id']));
            }
            return $result;
        } else {
            echo "Not data avaible";
        }
    }

    function get_data_header($id) {
        $this->db->select('*');
        $this->db->from('zhl_acc_tbl_trn_hutang');
        $this->db->where('nofaktur', $id);
        $sql_product = $this->db->get();

        if ($sql_product->num_rows() > 0) {
            foreach ($sql_product->result() as $data) {
                $hasil[] = $data;
            }
            return $hasil;
        } else {
            $hasil[] = '';
        }
    }

    function delete_hutang($id) {
        //apdate deposit
        $this->db->query("UPDATE zhl_fin_tbltrn_cashbank_journal_header SET total_bayar = 0, id_jurnal = NULL  WHERE header_id ='$id'");
        //select * from mar_tbltrn_shipping_instruction_product where ship_id = 17;
         $this->db->query("UPDATE zhl_mar_tbltrn_shipping_instruction_product SET quantity_jurnal = 0, inv_jurnal = NULL  WHERE inv_jurnal ='$id'");
        //acc_tbl_trn_jurnal
        $this->db->where('NoJurnal', $id);
        $this->db->where('jenis_trans', 'PIFF');
        $this->db->delete('zhl_acc_tbl_trn_jurnal');

        //acc_tbl_trn_hutang
        $this->db->where('nofaktur', $id);
        $this->db->where('jenis_trans', 'PIFF');
        $this->db->delete('zhl_acc_tbl_trn_hutang');

        //acc_tbl_trn_gst
        $this->db->where('ref_nomor', $id);
        $this->db->where('jenis_trans', 'PIFF');
        $this->db->delete('zhl_acc_tbl_trn_gst');

        //acc_tbl_trn_hutang_bulanan
        $this->db->where('nofaktur', $id);
        $this->db->delete('zhl_acc_tbl_trn_hutang_bulanan');

        //acc_tbl_trn_payable_recognition
        $this->db->where('HeaderID', $id);
        $this->db->delete('zhl_acc_tbl_trn_pi_fac_dtl');

        //fin_tbltrn_cashbank_journal_history
        $this->db->where('no_facture', $id);
        $this->db->delete('zhl_fin_tbltrn_cashbank_journal_history');
    }

    function hapus_coa_kosong() {
        $coa = array('0', '');
        $this->db->where_in('NoCOA', $coa);
        $this->db->or_where('Total', '0');
        $this->db->delete('zhl_acc_tbl_trn_jurnal');
    }

    function get_data_detail($id) {
        $this->db->select('*');
        $this->db->where('HeaderID', $id);
        $sql_product = $this->db->get('zhl_acc_tbl_trn_pi_fac_dtl');

        if ($sql_product->num_rows() > 0) {
            foreach ($sql_product->result() as $data) {
                $hasil[] = $data;
            }
            return $hasil;
        }
    }

    function get_data_footer($id) {
        $this->db->select('*');
        $this->db->where('NoJurnal', $id);
        $this->db->where('jenis_trans', 'PIFF');
        $this->db->where_not_in('NoUrut', '0');
        $sql_product = $this->db->get('zhl_acc_tbl_trn_jurnal');

        if ($sql_product->num_rows() > 0) {
            foreach ($sql_product->result() as $data) {
                $hasil[] = $data;
            }
            return $hasil;
        }
    }

    function get_data_awal($id, $jenis) {
        //$this->db->select('Total');
        $this->db->select('DetailID, NoCOA, sum(Total) as Total, sum(Debet) as Debet,sum(Kredit) as Kredit, chk, Uraian, Rate');
        $this->db->where('NoJurnal', $id);
        $this->db->where('JenisJurnalID', 'COGS');
        $sql_product = $this->db->get('zhl_acc_tbl_trn_jurnal');

        if ($sql_product->num_rows() > 0) {
            foreach ($sql_product->result() as $data) {
                $hasil[] = $data;
            }
            return $hasil;
        }
    }

    function delete_jurnal_lama($nojurnal) {
        $this->db->where('NoJurnal', $nojurnal);
        $this->db->where('jenis_trans', 'PIFF');
        $this->db->delete('zhl_acc_tbl_trn_jurnal');
    }

    function delete_gst_lama($nojurnal) {
        $this->db->where('ref_nomor', $nojurnal);
        $this->db->where('jenis_trans', 'PIFF');
        $this->db->delete('zhl_acc_tbl_trn_gst');
    }

    function simpan_gst_payable($gst_item) {
        $this->db->insert('zhl_acc_tbl_trn_gst', $gst_item);
    }

    function get_data_jurnal($no, $id, $jenis) {
        $this->db->select('*');
        $this->db->where('NoJurnal', $id);
        $this->db->where('NoUrut', $no);
        $this->db->where('jenis_trans', $jenis);
        $sql_product = $this->db->get('zhl_acc_tbl_trn_jurnal');

        if ($sql_product->num_rows() > 0) {
            foreach ($sql_product->result() as $data) {
                $hasil[] = $data;
            }
            return $hasil;
        }
    }

    function delete_all($id) {
        //acc_tbl_trn_jurnal
        //acc_tbl_trn_payable_recognition
        $this->db->where('HeaderID', $id);
        $this->db->delete('zhl_acc_tbl_trn_pi_fac_dtl');

        $this->db->where('NoJurnal', $id);
        $this->db->where('jenis_trans', 'PIFF');
        $this->db->delete('zhl_acc_tbl_trn_jurnal');

        //acc_tbl_trn_gst
        $this->db->where('ref_nomor', $id);
        $this->db->where('jenis_trans', 'PIFF');
        $this->db->delete('zhl_acc_tbl_trn_gst');

        $this->db->where('no_facture', $id);
        $this->db->delete('zhl_fin_tbltrn_cashbank_journal_history');
        
    }

    function get_gl($id) {
        $this->db->select('*');
        $this->db->where('gl_id', $id);
        $sql_product = $this->db->get('zhl_acc_master_gl');
        if ($sql_product->num_rows() > 0) {
            foreach ($sql_product->result() as $data) {
                $hasil[] = $data;
            }
            return $hasil;
        }
    }

    function data_paling_bawah($nofaktur) {
        $sql_product = $this->db->query("SELECT DISTINCT Rate as rate,(SELECT SUM(Total) FROM `zhl_acc_tbl_trn_jurnal` WHERE NoJurnal = '$nofaktur' and JenisJurnalID = 'AR/GL') as Total, (SELECT SUM(Total * Rate) FROM `zhl_acc_tbl_trn_jurnal` WHERE NoJurnal = '$nofaktur' and NoUrut <> 0 and chk = 'D') as TotalDebet,
                          (SELECT SUM(Total * Rate) FROM `zhl_acc_tbl_trn_jurnal` WHERE NoJurnal = '$nofaktur' and NoUrut <> 0 and chk = 'C') as TotalCredit FROM `zhl_acc_tbl_trn_jurnal` WHERE NoJurnal = '$nofaktur' ");

        if ($sql_product->num_rows() > 0) {
            foreach ($sql_product->result() as $data) {
                $hasil[] = $data;
            }
            return $hasil;
        }
    }

    function insertCashBankHeaderx($data) {
        $this->db->trans_start();
        $this->db->insert('zhl_fin_tbltrn_cashbank_journal_header', $data);
        $headerID = $this->db->insert_id();
        $this->db->trans_complete();

        return $headerID;
    }

    function hapusCashBankHeader($id) {
        $this->db->where('no_reff', $id);
        $this->db->delete('zhl_fin_tbltrn_cashbank_journal_header');
    }

    function insertCashBankDetailx($data) {
        $this->db->insert('zhl_fin_tbltrn_cashbank_journal_detail', $data);
    }

    function hapusCashBankDetail($id) {
        $this->db->where('no_reff', $id);
        $this->db->delete('zhl_fin_tbltrn_cashbank_journal_detail');
    }

    function insertCBhistoryx($data) {
        $this->db->insert('zhl_fin_tbltrn_cashbank_journal_history', $data);
    }

    function hapusCashBankhistory($id) {
        $this->db->where('no_facture', $id);
        $this->db->delete('zhl_fin_tbltrn_cashbank_journal_history');
    }

    function insertDetailPOcbTransactionx($data) {
        $this->db->insert('zhl_fin_tbltrn_cashbank_journal_detail_po', $data);
    }

    function hapusDetailPOcbTransaction($id) {
        $this->db->where('po_id', $id);
        $this->db->delete('zhl_fin_tbltrn_cashbank_journal_detail_po');
    }

    function pilih_dp($id, $cur) {
        $this->db->select('*');
        $this->db->where('prepaid', '1');
        $this->db->where('suplier', $id);
        $this->db->where('currency_id', $cur);
        $sql_product = $this->db->get('zhl_fin_tbltrn_cashbank_journal_header');

        if ($sql_product->num_rows() > 0) {
            foreach ($sql_product->result() as $data) {
                $hasil[] = $data;
            }
            return $hasil;
        }
    }

    function update_mar_tbl_trn_shipping_intruction_dtl($inv_jurnal, $ship_product_id, $quantity_jurnal) {
        $this->db->query("update zhl_mar_tbltrn_shipping_instruction_product set inv_jurnal='$inv_jurnal',quantity_jurnal='$quantity_jurnal' where ship_product_id='$ship_product_id'");
    }

    function update_dp_ar($id, $bayar_dp) {
        $this->db->query('UPDATE zhl_fin_tbltrn_cashbank_journal_detail_po SET bayar = bayar + ' . $bayar_dp . ' WHERE detail_id =' . $id);
    }

    function tampil_po_rate($cur,$date){
        $date1 = date('Y-m-d', strtotime($date));
        $lastdate= date('Y-m-01',strtotime($date));
        $tempdate   = date('Y-m-01', strtotime($date));
        $newdate = date('Y-m-t', strtotime("-1 months", strtotime($tempdate)));
        // $newdate = $tempdate;

        if($date1==$lastdate)
        {

            $query=" currency_id = '".$cur."' and periode = '".$date."'";
            $this->db->select('rate_usd');
            $this->db->select('rate_kurs');
            $this->db->where($query);
            $this->db->order_by('periode desc');
            $this->db->limit(1);


            $result=$this->db->get('zhl_acc_tbl_trn_kurs');
            if ($result->num_rows() > 0) {
                foreach ($result->result() as $data) {
                    $hasil[] = $data;
                }
                return $hasil;
            }
        }

        else{

            $query=" currency_id = '".$cur."' and periode BETWEEN '".$newdate."' AND '".$date."'";
            $this->db->select('rate_usd');
            $this->db->select('rate_kurs');
            $this->db->where($query);
            $this->db->order_by('periode desc');
            $this->db->limit(1);


            $result=$this->db->get('zhl_acc_tbl_trn_kurs');
            if ($result->num_rows() > 0) {
                foreach ($result->result() as $data) {
                    $hasil[] = $data;
                }
                return $hasil;
            }
        }
        //$query=" currency_id = '".$cur."' and periode <= '".$newdate."'";

    }

    function tampil_po_rate2($cur,$date){
        //$cur = 'SGD';
        $newdate = date('Y-m-t', strtotime("-1 months", strtotime($date)));
        $date1 = date('Y-m-d', strtotime($date));
        $lastdate= date('Y-m-t',strtotime($date));

        if($date1==$lastdate)
        {

            $query=" currency_id = '".$cur."' and periode >= '".$date."'";
            $this->db->select('rate_usd');
            $this->db->select('rate_kurs');
            $this->db->where($query);
            $this->db->order_by('periode desc');
            $this->db->limit(1);


            $result=$this->db->get('zhl_acc_tbl_trn_kurs');
            if ($result->num_rows() > 0) {
                foreach ($result->result() as $data) {
                    $hasil[] = $data;
                }
                return $hasil;
            }
        }
        else{

            $query=" currency_id = '".$cur."' and periode BETWEEN '".$newdate."' AND '".$date."'";
            $this->db->select('rate_usd');
            $this->db->select('rate_kurs');
            $this->db->where($query);
            $this->db->order_by('periode desc');
            $this->db->limit(1);


            $result=$this->db->get('zhl_acc_tbl_trn_kurs');
            if ($result->num_rows() > 0) {
                foreach ($result->result() as $data) {
                    $hasil[] = $data;
                }
                return $hasil;
            }
        }
        //$query=" currency_id = '".$cur."' and periode <= '".$newdate."'";

    }

    function tampil_po_rate2old($cur,$date){

        $newdate = date('Y-m-d', strtotime("-1 months", strtotime($date)));
        $newsdate =$newdate;

        //$query=" currency_id = '".$cur."' and periode <= '".$newdate."'";
        $query=" currency_id = '".$cur."' and periode BETWEEN '".$newdate."' AND '".$date."'";
        $this->db->select('rate_usd');
        $this->db->select('rate_kurs');
        $this->db->where($query);
        $this->db->order_by('periode desc');
        $this->db->limit(1);


        $result=$this->db->get('zhl_acc_tbl_trn_kurs');
        return $result->row();
    }


    function selectInvoiceforFindIF(){
        //$this->db->where('trans_type', 'AP');
        $this->db->where('jenis_trans', 'PIFF');
        $this->db->order_by('tanggal', 'Desc');
        $sql_product = $this->db->get('zhl_vw_acc_tbl_trn_hutang');



        return $sql_product;
    }
}
