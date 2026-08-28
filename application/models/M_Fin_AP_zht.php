<?php defined('BASEPATH') or exit('No direct script access allowed');

/* 
 * Author : ITD16 ( F-CHAN )
 */

class M_Fin_AP_zht extends CI_Model
{
    private $tblTran    = array(
    'CashBankHeader'    => 'zht_fin_tbltrn_cashbank_journal_header',
    'CashBankDetail'    => 'zht_fin_tbltrn_cashbank_journal_detail',

    'PaymentAPheader'   => 'zht_fin_tbltrn_payment_hdr',
    'PaymentAPdetail'   => 'zht_fin_tbltrn_payment_dtl'
    );

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
        $get    = $this->db->query("SELECT header_id FROM zht_fin_tbltrn_payment_hdr WHERE "
            . "EXTRACT(YEAR FROM created_date) = YEAR(CURRENT_DATE()) AND "
            . "EXTRACT(MONTH FROM created_date) = MONTH(CURRENT_DATE())");
        return $get->num_rows() + 1;
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
        // return $this->db->query("SELECT customer_code as supplierid, customer_name as suppliercompany, 'Local' as `group`, coa as nocoa FROM zht_mar_vw_mst_customer WHERE customer_code IN (SELECT zht_acc_tbl_trn_hutang.kode_sup "
        //     . "FROM zht_acc_tbl_trn_hutang WHERE tanggal <= '" . $idDate . "' AND hutang-bayar <> 0 )");
        return $this->db->query("SELECT * FROM zht_pur_vw_mst_supplier_tims WHERE supplierid IN (SELECT zht_acc_tbl_trn_hutang.kode_sup "
                . "FROM zht_acc_tbl_trn_hutang WHERE tanggal <= '".$idDate."' AND hutang-bayar <> 0 )");
            
    }
    function selectInvoiceWhereForAPtrans($idSupp, $date)
    {
        $getPeriod  = $this->getPeriod_map();
        $blnPeriod  = date('m',  strtotime($getPeriod));
        $thnPeriod  = date('Y',  strtotime($getPeriod));

        return $this->db->query("SELECT *, '0' AS in_draft, "
            . "(SELECT zht_acc_tbl_trn_hutang_bulanan.rate_akhir FROM zht_acc_tbl_trn_hutang_bulanan "
            . "WHERE zht_acc_tbl_trn_hutang_bulanan.nofaktur = zht_acc_tbl_trn_hutang.nofaktur "
            . "ORDER BY zht_acc_tbl_trn_hutang_bulanan.created_date DESC LIMIT 1) AS rate_akhir_bulanan, "
            . "(SELECT trans_description from zht_fin_tbltrn_cashbank_journal_header where zht_fin_tbltrn_cashbank_journal_header.no_reff=zht_acc_tbl_trn_hutang.nofaktur) as remarks, "
            . "(SELECT rate_usd FROM zhl_acc_tbl_trn_kurs WHERE periode <= '" . $date . "' AND currency_id = zht_acc_tbl_trn_hutang.currency_id ORDER BY periode DESC LIMIT 1) AS rate_invc, "
            . "(SELECT rate_sgd FROM zhl_acc_tbl_trn_kurs WHERE periode <= '" . $date . "' AND currency_id = zht_acc_tbl_trn_hutang.currency_id ORDER BY periode DESC LIMIT 1) AS rate_invc_sgd "
            . "FROM zht_acc_tbl_trn_hutang WHERE "
            . "kode_sup = '" . $idSupp . "' AND tanggal <= '" . $date . "' AND hutang-bayar != 0 order by tanggal asc");
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
    function getKursByID($id, $tglInvoice = '')
    {
        $tgl    = date('Y-m-d', strtotime($tglInvoice));
        return $query = $this->db->query("SELECT * FROM zhl_acc_tbl_trn_kurs WHERE periode <= '" . $tgl . "' AND currency_id = '" . $id . "' ORDER BY periode DESC LIMIT 1");
    }

    function getListAPNumber($keyword)
    {
        $this->db->order_by('NomorAP', 'DESC');
        $this->db->like("NomorAP", $keyword);
        $this->db->where("NomorAP NOT IN (SELECT no_voucher FROM zht_fin_tbltrn_payment_hdr)");
        return $this->db->get('zht_acc_tbl_trn_appaymenthdr')->result_array();
    }
    
    // ############# = Insert Detail AP Accounting = #############
    function insertDetailAPaccountingFromPayment($data)
    {
        $this->db->insert('zht_acc_tbl_trn_appaymentdtl', $data);
    }
    // ================================== VVV ================================
    function insertDetailAPjurnal($data)
    {
        $this->db->insert('zht_fin_tbltrn_payment_jurnal_dtl', $data);
    }
    // ############################################################################## //
    // ############################################################################## //
    function selectAPforFindAP()
    {
        //$this->db->where('trans_type', 'AP');
        $select = $this->db->get('zht_fin_vw_trn_selectap_for_find');
        return $select;
    }
    function selectHeaderAPforReview($headerID)
    {
        $this->db->where('header_id', $headerID);
        $get    = $this->db->get('zht_fin_vw_trn_selectap_header_review');
        return $get->row();
    }
    function selectHeaderAPforReviewByNoReff($headerID)
    {
        $this->db->where('no_facture', $headerID);
        $get    = $this->db->get('zht_fin_vw_trn_selectap_header_review');
        return $get->row();
    }
    function selectHeaderAPforPrint($noFaktur)
    {
        $this->db->where('no_facture', $noFaktur);
        $get    = $this->db->get('zht_fin_vw_trn_selectap_header_review');
        return $get->row();
    }
    function selectInvoiceAPforReview($noReff)
    {
        $this->db->where('NomorAP', $noReff);
        $get    = $this->db->get('zht_fin_vw_trn_selectap_invoice_review');
        return $get->result();
    }
    function selectSupplierForAPbyCode($code)
    {
        $this->db->select('customer_name as suppliercompany, account as nocoa');
        $this->db->where('customer_code', $code);
        $get    = $this->db->get('zhl_tims_mst_customer');
        return $get->row();
    }

    function getSupplierCOA($idSupp)
    {
        $this->db->limit(1);
        $this->db->where('supplierid', $idSupp);
        $get =  $this->db->get('zht_pur_vw_mst_supplier_tims');
        if ($get->num_rows() > 0) {
          return $get->row()->nocoa;
        } else {
          return NULL;
        }
    }
    function selectDetailJurnalAPforReview($headerID)
    {
        $this->db->where('header_id', $headerID);
        $select = $this->db->get('zht_fin_tbltrn_payment_jurnal_dtl');
        return $select;
    }

    // ############ RETURN BACK AP PAYMENT ############
    function resetPaymentHutang($noInvoice, $jenis)
    {
        $this->db->query("UPDATE zht_acc_tbl_trn_hutang SET bayar = (SELECT SUM(Total) FROM zht_acc_tbl_trn_appaymentdtl "
            . "WHERE zht_acc_tbl_trn_appaymentdtl.NoInvoice = '" . $noInvoice . "' and zht_acc_tbl_trn_hutang.jenis_trans = '" . $jenis . "') WHERE zht_acc_tbl_trn_hutang.nofaktur = '" . $noInvoice . "' and zht_acc_tbl_trn_hutang.jenis_trans = '" . $jenis . "'");
    }
    function resetPaymentHutangSaldo($noInvoice, $jenis)
    {
        $this->db->query("UPDATE zht_acc_tbl_trn_hutang SET saldo_hutang = hutang-bayar WHERE "
            . "zht_acc_tbl_trn_hutang.nofaktur = '" . $noInvoice . "' and zht_acc_tbl_trn_hutang.jenis_trans = '" . $jenis . "'");
    }
    function deleteDetailAPaccountingFromPayment($nomorAP)
    {
        $this->db->where('NomorAP', $nomorAP);
        $this->db->delete('zht_acc_tbl_trn_appaymentdtl');
    }
    // ===================================================== 03/01/2018 ( F. Chan ) ========================
    function deleteAPfromJurnalAcc($nomorAP)
    {
        $this->db->where(array('NoJurnal' => $nomorAP, "jenis_trans in ('AP','AR') "));
        $this->db->delete('zht_acc_tbl_trn_jurnal_tims');
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
        $this->db->delete('zht_fin_tbltrn_cashbank_journal_history');
    }
    function deleteHeaderAPpayment($primary)
    {
        $this->db->where('header_id', $primary);
        $this->db->delete('zht_fin_tbltrn_payment_hdr');
    }
    function deleteDetailAPjurnal($nomorAP, $primary)
    {
        $this->db->where(array('header_id' => $primary, 'no_reff' => $nomorAP));
        $this->db->delete('zht_fin_tbltrn_payment_jurnal_dtl');
    }

    function deleteDetailAPGST($nomorAP)
    {
        $this->db->where(array('ref_nomor' => $nomorAP, 'jenis_trans' => 'AP'));
        $this->db->delete('zht_acc_tbl_trn_gst');
    }

    // ##########======================================================#################
    function getCurrOnDateInvoiceByCurrencyID($noInvoice, $currency)
    {
        $get = $this->db->query("SELECT * FROM zhl_acc_tbl_trn_kurs WHERE periode < (SELECT tanggal FROM zht_acc_tbl_trn_hutang "
            . "WHERE nofaktur = '" . $noInvoice . "') AND currency_id = '" . $currency . "' ORDER BY periode DESC LIMIT 1");
        $row = $get->row();
        return $row->rate_usd;
    }

    //====================================================
    function selectInvoiceForPaymentAdvice($noAP)
    {
        $this->db->where('NomorAP', $noAP);
        return $this->db->get('zht_fin_vw_trn_for_payment_advice_ap')->result();
    }

    // ######################## Update Header Payment ======================================
    function updateHeaderAPpayment($headerID, $data)
    {
        $this->db->where('header_id', $headerID);
        $this->db->update('zht_fin_tbltrn_payment_hdr', $data);
    }

    function updateAPfromJurnalAcc($nomorAP, $data)
    {
        $this->db->where(array('NoJurnal' => $nomorAP, 'jenis_trans' => 'AP'));
        $this->db->update('zht_acc_tbl_trn_jurnal_tims', $data);
    }

    // ##== Update Deposit
    function updateDepositAPinHeaderByInv($noInv, $payment)
    {
        $this->db->query("UPDATE zht_fin_tbltrn_cashbank_journal_header SET total_bayar = total_bayar + '" . $payment . "' WHERE no_reff = '" . $noInv . "'");
    }

    // =========================================== 03/01/2018 ( F.Chan ) =================================================
    function insertdtlexcRt($dtl)
    {
        $this->db->insert('zhl_fin_tbl_dtl_excRt_ApAR', $dtl);
    }

    function insertjurnalnya($data)
    {
        $this->db->insert('zht_acc_tbl_trn_jurnal_tims', $data);
    }


    function newCheckReffNumber2($type, $tanggal, $currency)
    {
        $tgl    = date("Y", strtotime($tanggal));
        $bln    = date("m", strtotime($tanggal));
        $inJurnal   = $this->db->query("SELECT substring(reff_number,15,4) AS GEN FROM zht_fin_vw_auto_reff_number WHERE "
                . "type IN ('AP') AND tanggal = '" . $tgl . "'  AND bulan = '" . $bln . "' ORDER BY GEN DESC LIMIT 1");

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

    function cek_reff($type, $tgl, $currency, $blnPeriod)
    {
        $sql   = $this->db->query("SELECT reff_number AS GEN FROM zht_fin_vw_auto_reff_number WHERE "
                . "type IN ('AP') AND tanggal = '" . $tgl . "'  AND bulan = '" . $blnPeriod . "' AND currency = 'IDR' ORDER BY GEN DESC LIMIT 1");
        return $sql->row();
    }
    //============================================         END           =================================================

    function insertHeaderAPpayment($data)
    {
        $this->db->trans_start();
        $this->db->insert($this->tblTran['PaymentAPheader'], $data);
        $hdrID  = $this->db->insert_id();
        $this->db->trans_complete();

        return $hdrID;
    }

    function insertCBhistory($data)
    {
        $this->db->insert('zht_fin_tbltrn_cashbank_journal_history', $data);
    }

    function insertToJurnalAcc($data)
    {
        $this->db->insert('zht_acc_tbl_trn_jurnal_tims', $data);
    }

    function insertDetailAPpayment($data)
    {
        $this->db->insert($this->tblTran['PaymentAPdetail'], $data);
    }

    function getBayarFromUtang($noInvoice, $jenis)
    {
        $get = $this->db->query("SELECT nofaktur, bayar FROM zht_acc_tbl_trn_hutang WHERE nofaktur = '" . $noInvoice . "' AND jenis_trans ='" . $jenis . "'");
        $row = $get->row();
        return $row->bayar;
    }

    function getHutangFromUtang($noInvoice, $jenis)
    {
        $get = $this->db->query("SELECT nofaktur, saldo_hutang FROM zht_acc_tbl_trn_hutang WHERE nofaktur = '" . $noInvoice . "' AND jenis_trans ='" . $jenis . "' ");
        $row = $get->row();
        return $row->saldo_hutang;
    }

    function updateUtangByNoInvoiceInOneAPnumber($noInvoice, $jenis, $data)
    {
        $this->db->where('nofaktur', $noInvoice);
        $this->db->where('jenis_trans', $jenis);
        $this->db->update('zht_acc_tbl_trn_hutang', $data);
    }

    function updateUtangBulananByNoInvoiceInOneAPnumberQuery($noInvoice, $jenis, $blnPeriod, $thnPeriod, $payment)
    {
        $this->db->query("UPDATE zht_acc_tbl_trn_hutang_bulanan SET `bayar` = `bayar` + '" . $payment . "', `saldo_hutang` = `saldo_hutang` - '" . $payment . "' "
          . "WHERE nofaktur = '" . $noInvoice . "' AND jenis_trans ='" . $jenis . "' AND periode_bulan = '" . $blnPeriod . "' AND periode_tahun = '" . $thnPeriod . "' ");
    }

    function updateUtangBulananByNoInvoiceInOneAPnumberQueryReturn($noInvoice, $jenis, $blnPeriod, $thnPeriod, $payment)
    {
        $this->db->query("UPDATE zhl_acc_tbl_trn_hutang_bulanan SET `bayar` = `bayar` - '" . $payment . "', `saldo_hutang` = `saldo_hutang` + '" . $payment . "' "
          . "WHERE nofaktur = '" . $noInvoice . "' AND jenis_trans ='" . $jenis . "' AND periode_bulan = '" . $blnPeriod . "' AND periode_tahun = '" . $thnPeriod . "' ");
    }
}
