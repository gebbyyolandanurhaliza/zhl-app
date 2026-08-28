<?php defined('BASEPATH') or exit('No direct script access allowed');

/* 
 * Author : ITD16 ( F-CHAN )
 */

class M_Fin_APNew extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    // == this period & generade reff. number
    function getPeriod_map()
    {
        return $this->session->userdata('periode_1') . '/01';
    }
    function generateReffAP()
    {
        $get    = $this->db->query("SELECT header_id FROM zhl_fin_tbltrn_payment_hdr WHERE "
            . "EXTRACT(YEAR FROM created_date) = YEAR(CURRENT_DATE()) AND "
            . "EXTRACT(MONTH FROM created_date) = MONTH(CURRENT_DATE())");
        return $get->num_rows() + 1;
    }
    // get ap from accounting
    function selectAPfromAccounting()
    {
        $select = $this->db->query("SELECT zhl_fin_vw_trn_select_apheader.*,zhl_fin_vw_mst_supplier.suppliercompany,zhl_fin_vw_mst_supplier.nocoa "
            . "FROM zhl_fin_vw_trn_select_apheader JOIN zhl_fin_vw_mst_supplier "
            . "ON zhl_fin_vw_trn_select_apheader.SupplierID = zhl_fin_vw_mst_supplier.supplierid "
            . "WHERE zhl_fin_vw_trn_select_apheader.NomorAP NOT IN (SELECT no_voucher FROM zhl_fin_tbltrn_payment_hdr)");
        return $select;
    }
    function selectCOAforAPtrans($company)
    {
        return $this->db->query("SELECT * FROM zhl_fin_vw_mst_coa_balance_tims WHERE company_id='$company' ORDER BY AccountName");
    }
    function selectSupplierforAPtrans($tgl)
    {
        $getPeriod  = $this->getPeriod_map();
        $blnPeriod  = date('m',  strtotime($tgl));
        $thnPeriod  = date('Y',  strtotime($tgl));
        $idDate     = date('Y-m-d', strtotime($tgl));
        return $this->db->query("SELECT * FROM zhl_fin_vw_mst_supplier WHERE supplierid IN (SELECT zhl_acc_tbl_trn_hutang.kode_sup "
            . "FROM zhl_acc_tbl_trn_hutang WHERE tanggal <= '" . $idDate . "' AND hutang-bayar <> 0 )");
        /*return $this->db->query("SELECT * FROM fin_vw_mst_supplier WHERE supplierid IN (SELECT acc_tbl_trn_hutang.kode_sup "
                . "FROM acc_tbl_trn_hutang WHERE acc_tbl_trn_hutang.nofaktur IN (SELECT acc_tbl_trn_hutang_bulanan.nofaktur "
                . "FROM acc_tbl_trn_hutang_bulanan WHERE hutang-bayar > 0 AND acc_tbl_trn_hutang_bulanan.periode_bulan = '".$blnPeriod."' "
                . "AND acc_tbl_trn_hutang_bulanan.periode_tahun = '".$thnPeriod."'))");*/
        /*return $this->db->query("SELECT * FROM fin_vw_mst_supplier WHERE supplierid IN (SELECT acc_tbl_trn_hutang.kode_sup "
                . "FROM acc_tbl_trn_hutang)");*/
    }
    function selectInvoiceWhereForAPtrans($idSupp, $date)
    {
        $getPeriod  = $this->getPeriod_map();
        $blnPeriod  = date('m',  strtotime($getPeriod));
        $thnPeriod  = date('Y',  strtotime($getPeriod));

        /*return $this->db->query("SELECT *, '0' AS in_draft, "
                . "(SELECT acc_tbl_trn_hutang_bulanan.rate_akhir FROM acc_tbl_trn_hutang_bulanan "
                . "WHERE acc_tbl_trn_hutang_bulanan.nofaktur = acc_tbl_trn_hutang.nofaktur "
                . "ORDER BY acc_tbl_trn_hutang_bulanan.created_date DESC LIMIT 1) AS rate_akhir_bulanan "
                . "FROM acc_tbl_trn_hutang WHERE "
                . "kode_sup = '".$idSupp."' AND tanggal <= '".$date."' AND hutang-bayar != 0 ");*/

        // return $this->db->query("SELECT *, '0' AS in_draft, "
        //     . "(SELECT zhl_acc_tbl_trn_hutang_bulanan.rate_akhir FROM zhl_acc_tbl_trn_hutang_bulanan "
        //     . "WHERE zhl_acc_tbl_trn_hutang_bulanan.nofaktur = zhl_acc_tbl_trn_hutang.nofaktur "
        //     . "ORDER BY zhl_acc_tbl_trn_hutang_bulanan.created_date DESC LIMIT 1) AS rate_akhir_bulanan, "
        //     . "(SELECT trans_description from zhl_fin_tbltrn_cashbank_journal_header where zhl_fin_tbltrn_cashbank_journal_header.no_reff=zhl_acc_tbl_trn_hutang.nofaktur) as remarks, "
        //     . "(SELECT rate_usd FROM zhl_acc_tbl_trn_kurs WHERE periode <= '" . $date . "' AND currency_id = zhl_acc_tbl_trn_hutang.currency_id ORDER BY periode DESC LIMIT 1) AS rate_invc, "
        //     . "(SELECT rate_sgd FROM zhl_acc_tbl_trn_kurs WHERE periode <= '" . $date . "' AND currency_id = zhl_acc_tbl_trn_hutang.currency_id ORDER BY periode DESC LIMIT 1) AS rate_invc_sgd "
        //     . "FROM zhl_acc_tbl_trn_hutang LEFT JOIN "
        //     . "(select NoInvoice,sum(Total_pay) as total_dtl from zhl_acc_tbl_trn_appaymentdtl where DATE(realisasi_date) <= '" . $date . "' group by NoInvoice) AS B on zhl_acc_tbl_trn_hutang.nofaktur=B.NoInvoice WHERE "
        //     . "kode_sup = '" . $idSupp . "' AND tanggal <= '" . $date . "' AND hutang - IFNULL(B.total_dtl,0) != 0 ");

        $sql = "SELECT *, '0' AS in_draft, "
            . "(SELECT zhl_acc_tbl_trn_hutang_bulanan.rate_akhir FROM zhl_acc_tbl_trn_hutang_bulanan "
            . "WHERE zhl_acc_tbl_trn_hutang_bulanan.nofaktur = zhl_acc_tbl_trn_hutang.nofaktur "
            . "ORDER BY zhl_acc_tbl_trn_hutang_bulanan.created_date DESC LIMIT 1) AS rate_akhir_bulanan, "
            . "(SELECT trans_description from zhl_fin_tbltrn_cashbank_journal_header where zhl_fin_tbltrn_cashbank_journal_header.no_reff=zhl_acc_tbl_trn_hutang.nofaktur) as remarks, "
            . "(SELECT rate_usd FROM zhl_acc_tbl_trn_kurs WHERE periode <= '" . $date . "' AND currency_id = zhl_acc_tbl_trn_hutang.currency_id ORDER BY periode DESC LIMIT 1) AS rate_invc, "
            . "(SELECT rate_sgd FROM zhl_acc_tbl_trn_kurs WHERE periode <= '" . $date . "' AND currency_id = zhl_acc_tbl_trn_hutang.currency_id ORDER BY periode DESC LIMIT 1) AS rate_invc_sgd "
            . "FROM zhl_acc_tbl_trn_hutang LEFT JOIN "
            . "(select NoInvoice, sum(Total_pay) as total_dtl from zhl_acc_tbl_trn_appaymentdtl where DATE(realisasi_date) <= '" . $date . "' group by NoInvoice) AS B "
            . "ON zhl_acc_tbl_trn_hutang.nofaktur=B.NoInvoice "
            . "WHERE kode_sup = '" . $idSupp . "' AND tanggal <= '" . $date . "' AND hutang - IFNULL(B.total_dtl,0) != 0 AND bayar = 0";

        // if ($idSupp == "EVERGREEN") {
        //     $sql .= " AND bayar = 0";
        // }

        return $this->db->query($sql);
    }
    function getKursByID($id,$tglInvoice)
    {
        $tgl    = date('Y-m-d', strtotime($tglInvoice));
        return $query = $this->db->query("SELECT * FROM zhl_acc_tbl_trn_kurs WHERE periode <= '".$tgl."' AND currency_id = '" . $id . "' ORDER BY periode DESC LIMIT 1");
    }

    function getListAPNumber($keyword)
    {
        $this->db->order_by('NomorAP', 'DESC');
        $this->db->like("NomorAP", $keyword);
        $this->db->where("NomorAP NOT IN (SELECT no_voucher FROM zhl_fin_tbltrn_payment_hdr)");
        return $this->db->get('zhl_acc_tbl_trn_appaymenthdr')->result_array();
    }
    function getUtangAPHeaderByCode($id)
    {
        $this->db->where('NomorAP', $id);
        $query = $this->db->get('zhl_fin_vw_trn_select_apheader');
        return $query->row();
    }
    function generateNumReffAP($type)
    {
        $thisMonth  = date('m');
        $this->db->order_by('header_id', 'DESC');
        $this->db->limit(1);
        $this->db->select('no_facture');
        $this->db->where("no_facture LIKE '%" . $type . "%' AND MONTH(trans_date) ='" . $thisMonth . "'");
        $get = $this->db->get($this->tblTran['PaymentAPheader']);
        $row = $get->row();
        if ($get->num_rows() > 0) {
            return substr($row->no_facture, 0, 4);
        } else {
            return 0000;
        }
    }
    function selectInvoiceInDrafArray()
    {
        $get = $this->db->get('zhl_fin_vw_trn_is_invoice_in_draft');
        if ($get->num_rows() > 0) {
            foreach ($get->result() as $data) {
                $hasil[] = $data->NoInvoice;
            }
            return $hasil;
        } else {
            return $hasil = array('');
        }
    }
    // ############# = Insert Detail AP Accounting = #############
    function insertDetailAPaccountingFromPayment($data)
    {
        $this->db->insert('zhl_acc_tbl_trn_appaymentdtl', $data);
    }
    // ================================== VVV ================================
    function insertDetailAPjurnal($data)
    {
        $this->db->insert('zhl_fin_tbltrn_payment_jurnal_dtl', $data);
    }
    // ############################################################################## //
    // ############################################################################## //
    function selectAPforFindAP()
    {
        //$this->db->where('trans_type', 'AP');
        $select = $this->db->get('zhl_fin_vw_trn_selectap_for_find');
        return $select;
    }
    function selectHeaderAPforReview($headerID)
    {
        $this->db->where('header_id', $headerID);
        $get    = $this->db->get('zhl_fin_vw_trn_selectap_header_review');
        return $get->row();
    }
    function selectHeaderAPforReviewByNoReff($headerID)
    {
        $this->db->where('no_facture', $headerID);
        $get    = $this->db->get('zhl_fin_vw_trn_selectap_header_review');
        return $get->row();
    }
    function selectHeaderAPforPrint($noFaktur)
    {
        $this->db->where('no_facture', $noFaktur);
        $get    = $this->db->get('zhl_fin_vw_trn_selectap_header_review');
        return $get->row();
    }
    function selectInvoiceAPforReview($noReff)
    {
        $this->db->where('NomorAP', $noReff);
        $get    = $this->db->get('zhl_fin_vw_trn_selectap_invoice_review');
        return $get->result();
    }
    function selectDetailAPforReview($headerID)
    {
        $this->db->where('header_id', $headerID);
        $select = $this->db->get('zhl_fin_tbltrn_payment_dtl');
        return $select;
    }
    function selectSupplierForAPbyCode($code)
    {
        $this->db->where('supplierid', $code);
        $get    = $this->db->get('zhl_fin_vw_mst_supplier');
        return $get->row();
    }
    function selectDetailJurnalAPforReview($headerID)
    {
        $this->db->where('header_id', $headerID);
        $select = $this->db->get('zhl_fin_tbltrn_payment_jurnal_dtl');
        return $select;
    }

    // ############ RETURN BACK AP PAYMENT ############
    function resetPaymentHutang($noInvoice, $jenis)
    {
        $this->db->query("UPDATE zhl_acc_tbl_trn_hutang SET bayar = (SELECT SUM(Total) FROM zhl_acc_tbl_trn_appaymentdtl "
            . "WHERE zhl_acc_tbl_trn_appaymentdtl.NoInvoice = '" . $noInvoice . "' and zhl_acc_tbl_trn_hutang.jenis_trans = '" . $jenis . "') WHERE zhl_acc_tbl_trn_hutang.nofaktur = '" . $noInvoice . "' and zhl_acc_tbl_trn_hutang.jenis_trans = '" . $jenis . "'");
    }
    function resetPaymentHutangSaldo($noInvoice, $jenis)
    {
        $this->db->query("UPDATE zhl_acc_tbl_trn_hutang SET saldo_hutang = hutang-bayar WHERE "
            . "zhl_acc_tbl_trn_hutang.nofaktur = '" . $noInvoice . "' and zhl_acc_tbl_trn_hutang.jenis_trans = '" . $jenis . "'");
    }
    function deleteDetailAPaccountingFromPayment($nomorAP)
    {
        $this->db->where('NomorAP', $nomorAP);
        $this->db->delete('zhl_acc_tbl_trn_appaymentdtl');
    }
    // ===================================================== 03/01/2018 ( F. Chan ) ========================
    function deleteAPfromJurnalAcc($nomorAP)
    {
        $this->db->where(array('NoJurnal' => $nomorAP, "jenis_trans in ('AP','AR') "));
        $this->db->delete('zhl_acc_tbl_trn_jurnal');
    }

    function deletedtlexc($a)
    {
        $this->db->where('noApAr', $a);
        $this->db->delete('zhl_fin_tbl_dtl_excRt_ApAR');
    }
    // ======================================== end =====================================================
    function deleteAPfronCBhistory($nomorAP, $primary)
    {
        $this->db->where(array('header_id' => $primary, 'no_facture' => $nomorAP, 'trans_type' => 'AP'));
        $this->db->delete('zhl_fin_tbltrn_cashbank_journal_history');
    }
    function deleteDetailAPpayment($nomorAP, $primary)
    {
        $this->db->where(array('header_id' => $primary, 'no_facture' => $nomorAP));
        $this->db->delete('zhl_fin_tbltrn_payment_dtl');
    }
    function deleteHeaderAPpayment($primary)
    {
        $this->db->where('header_id', $primary);
        $this->db->delete('zhl_fin_tbltrn_payment_hdr');
    }
    function deleteDetailAPjurnal($nomorAP, $primary)
    {
        $this->db->where(array('header_id' => $primary, 'no_reff' => $nomorAP));
        $this->db->delete('zhl_fin_tbltrn_payment_jurnal_dtl');
    }

    function deleteDetailAPGST($nomorAP)
    {
        $this->db->where(array('ref_nomor' => $nomorAP, 'jenis_trans' => 'AP'));
        $this->db->delete('zhl_acc_tbl_trn_gst');
    }

    // ##########======================================================#################
    function getCurrOnDateInvoiceByCurrencyID($noInvoice, $currency)
    {
        $get = $this->db->query("SELECT * FROM zhl_acc_tbl_trn_kurs WHERE periode < (SELECT tanggal FROM zhl_acc_tbl_trn_hutang "
            . "WHERE nofaktur = '" . $noInvoice . "') AND currency_id = '" . $currency . "' ORDER BY periode DESC LIMIT 1");
        $row = $get->row();
        return $row->rate_usd;
    }

    //====================================================
    function selectInvoiceForPaymentAdvice($noAP)
    {
        $this->db->where('NomorAP', $noAP);
        return $this->db->get('zhl_fin_vw_trn_for_payment_advice_ap')->result();
    }

    // ######################## Update Header Payment ======================================
    function updateHeaderAPpayment($headerID, $data)
    {
        $this->db->where('header_id', $headerID);
        $this->db->update('zhl_fin_tbltrn_payment_hdr', $data);
    }

    function updateAPfromJurnalAcc($nomorAP, $data)
    {
        $this->db->where(array('NoJurnal' => $nomorAP, 'jenis_trans' => 'AP'));
        $this->db->update('zhl_acc_tbl_trn_jurnal', $data);
    }

    // ######################## Update Detail in Purchase ======================================
    function updateDetailPOinPurchaseByInvoice($noInvoice)
    {
        $this->db->query("UPDATE pur_tbl_trn_inv_dtl SET proses = '1' WHERE mainpo IN (SELECT no_po FROM zhl_acc_tbl_trn_payable_recognition "
            . "WHERE HeaderId = '" . $noInvoice . "')");
    }
    // ##== Update Deposit
    function updateDepositAPinHeaderByInv($noInv, $payment)
    {
        $this->db->query("UPDATE zhl_fin_tbltrn_cashbank_journal_header SET total_bayar = total_bayar + '" . $payment . "' WHERE no_reff = '" . $noInv . "'");
    }

    // =========================================== 03/01/2018 ( F.Chan ) =================================================
    function insertdtlexcRt($dtl)
    {
        $this->db->insert('zhl_fin_tbl_dtl_excRt_ApAR', $dtl);
    }

    function insertjurnalnya($data)
    {
        $this->db->insert('zhl_acc_tbl_trn_jurnal', $data);
    }


    function newCheckReffNumber($type, $tanggal, $currency)
    {
        $tgl    = date("Y", strtotime($tanggal));
        // echo $tgl; , ,
        // delete AP di where type
        if ($type == 'OUT' && $currency == 'USD') {
            $inJurnal   = $this->db->query("SELECT substring(reff_number,8,4) AS GEN FROM zhl_fin_vw_auto_reff_number WHERE "
                . "type IN ('PDP') AND tanggal = '" . $tgl . "' AND currency = 'USD' ORDER BY GEN DESC LIMIT 1");
        } else if ($type == 'OUT' && $currency == 'SGD') {
            $inJurnal   = $this->db->query("SELECT substring(reff_number,7,4) AS GEN FROM zhl_fin_vw_auto_reff_number WHERE "
                . "type IN ('PDP') AND tanggal = '" . $tgl . "' AND currency = 'SGD' ORDER BY GEN DESC LIMIT 1");
        } else if ($type == 'IN' && $currency == 'USD') {
            $inJurnal   = $this->db->query("SELECT substring(reff_number,8,4) AS GEN FROM zhl_fin_vw_auto_reff_number WHERE "
                . "type IN ('RDP') AND tanggal = '" . $tgl . "' AND currency = 'USD' ORDER BY GEN DESC LIMIT 1");
        } else if ($type == 'IN' && $currency == 'SGD') {
            $inJurnal   = $this->db->query("SELECT substring(reff_number,7,4) AS GEN FROM zhl_fin_vw_auto_reff_number WHERE "
                . "type IN ('RDP') AND tanggal = '" . $tgl . "' AND currency = 'SGD' ORDER BY GEN DESC LIMIT 1");
        }

        if ($inJurnal->num_rows() > 0) {
            $get    = $inJurnal->row();
            $set    = $get->GEN;
        } else {
            $set    = 0;
        }

        $num    = intval($set);
        // echo $num;
        return $num + 1;
    }

    function newCheckReffNumber2($type, $tanggal, $currency)
    {
        $tgl    = date("Y", strtotime($tanggal));
        // echo $tgl; , ,
        // delete AP di where type
        if ($type == 'OUT' && $currency == 'USD') {
            $inJurnal   = $this->db->query("SELECT substring(reff_number,10,4) AS GEN FROM zhl_fin_vw_auto_reff_number WHERE "
                . "type IN ('AP') AND tanggal = '" . $tgl . "' AND currency = 'USD' ORDER BY GEN DESC LIMIT 1");
        } else if ($type == 'OUT' && $currency == 'SGD') {
            $inJurnal   = $this->db->query("SELECT substring(reff_number,9,4) AS GEN FROM zhl_fin_vw_auto_reff_number WHERE "
                . "type IN ('AP') AND tanggal = '" . $tgl . "' AND currency = 'SGD' ORDER BY GEN DESC LIMIT 1");
        } else if ($type == 'IN' && $currency == 'USD') {
            $inJurnal   = $this->db->query("SELECT substring(reff_number,10,4) AS GEN FROM zhl_fin_vw_auto_reff_number WHERE "
                . "type IN ('AR') AND tanggal = '" . $tgl . "' AND currency = 'USD' ORDER BY GEN DESC LIMIT 1");
        } else if ($type == 'IN' && $currency == 'SGD') {
            $inJurnal   = $this->db->query("SELECT substring(reff_number,9,4) AS GEN FROM zhl_fin_vw_auto_reff_number WHERE "
                . "type IN ('AR') AND tanggal = '" . $tgl . "' AND currency = 'SGD' ORDER BY GEN DESC LIMIT 1");
        }

        if ($inJurnal->num_rows() > 0) {
            $get    = $inJurnal->row();
            $set    = $get->GEN;
        } else {
            $set    = 0;
        }

        $num    = intval($set);
        // echo $num;
        return $num + 1;
    }
    //============================================         END           =================================================
}
