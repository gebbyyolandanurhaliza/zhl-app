<?php ('BASEPATH') OR exit('No direct script access allowed');

/* 
 * Author : Ismo
 */

class M_Fin_AR extends CI_Model{
    public function __construct() {
        parent::__construct();
    }
    // == this period
    function getPeriod_mar(){
        return $this->session->userdata('periode_1').'/01';
    }
    
    function selectARfromAccounting(){
        $select = $this->db->query("SELECT zhl_fin_vw_trn_select_arheader.*, zhl_fin_vw_mst_customer.customer_company_name, zhl_fin_vw_mst_customer.coa as nocoa "
                . "FROM zhl_fin_vw_trn_select_arheader JOIN zhl_fin_vw_mst_customer "
                . "ON zhl_fin_vw_trn_select_arheader.SupplierID = zhl_fin_vw_mst_customer.customer_code "
                . "WHERE zhl_fin_vw_trn_select_arheader.NomorAR NOT IN (SELECT no_voucher FROM zhl_fin_tbltrn_payment_hdr)");
        return $select;
    }
    function selectCOAforARtrans($company){
        // return $this->db->query("SELECT * FROM zhl_fin_vw_mst_coa_balance ORDER BY AccountName");
        return $this->db->query("SELECT * FROM zhl_fin_vw_mst_coa_balance_tims WHERE company_id='$company' ORDER BY AccountName");
    }
    function selectCustomerforARtrans($tgl){
        $getPeriod  = $this->getPeriod_mar();
        $blnPeriod  = date('m',  strtotime($tgl));
        $thnPeriod  = date('Y',  strtotime($tgl));
        $idDate     = date('Y-m-d', strtotime($tgl));
        return $this->db->query("SELECT * FROM `zhl_fin_vw_mst_customer` WHERE customer_code IN (SELECT zhl_acc_tbl_trn_piutang.kode_sup "
                . "FROM zhl_acc_tbl_trn_piutang WHERE piutang-bayar <> 0 AND zhl_acc_tbl_trn_piutang.tanggal <= '".$idDate."') AND zhl_fin_vw_mst_customer.status_customer = 1");
        /*return $this->db->query("SELECT * FROM `fin_vw_mst_customer` WHERE customer_code IN (SELECT acc_tbl_trn_piutang.kode_sup "
                . "FROM acc_tbl_trn_piutang WHERE piutang-bayar > 0 AND acc_tbl_trn_piutang.tanggal <= '".$idDate."')");*/
        /*return $this->db->query("SELECT * FROM `fin_vw_mst_customer` WHERE customer_code IN (SELECT acc_tbl_trn_piutang.kode_sup "
                . "FROM acc_tbl_trn_piutang WHERE piutang-bayar > 0 AND acc_tbl_trn_piutang.nofaktur IN (SELECT acc_tbl_trn_piutang_bulanan.nofaktur "
                . "FROM acc_tbl_trn_piutang_bulanan WHERE acc_tbl_trn_piutang_bulanan.periode_bulan = '".$blnPeriod."' "
                . "AND acc_tbl_trn_piutang_bulanan.periode_tahun = '".$thnPeriod."'))");*/
        /*return $this->db->query("SELECT * FROM `fin_vw_mst_customer` WHERE customer_code IN (SELECT acc_tbl_trn_piutang.kode_sup "
                . "FROM acc_tbl_trn_piutang )");*/
    }
    function selectInvoiceWhereForARtrans($idSupp, $idDate){
        /*return $this->db->query("SELECT * FROM acc_tbl_trn_piutang WHERE kode_sup = '".$idSupp."' AND "
                . "currency_id = '".$idCurr."' AND tanggal <= '".$idDate."' AND piutang-bayar != 0");*/
        return $this->db->query("SELECT *, (SELECT zhl_acc_tbl_trn_piutang_bulanan.rate_akhir FROM zhl_acc_tbl_trn_piutang_bulanan WHERE "
                . "zhl_acc_tbl_trn_piutang_bulanan.nofaktur = zhl_acc_tbl_trn_piutang.nofaktur "
                . "ORDER BY zhl_acc_tbl_trn_piutang_bulanan.created_date DESC LIMIT 1) AS rate_akhir_bulanan, "
            ."(SELECT trans_description from zhl_fin_tbltrn_cashbank_journal_header where zhl_fin_tbltrn_cashbank_journal_header.no_reff=zhl_acc_tbl_trn_piutang.nofaktur) as remarks,"
            . "(SELECT rate_usd FROM zhl_acc_tbl_trn_kurs WHERE periode <= '".$idDate."' AND currency_id = zhl_acc_tbl_trn_piutang.currency_id ORDER BY periode DESC LIMIT 1) AS rate_invc, "
            . "(SELECT rate_sgd FROM acc_tbl_trn_kurs WHERE periode <= '".$idDate."' AND currency_id = zhl_acc_tbl_trn_piutang.currency_id ORDER BY periode DESC LIMIT 1) AS rate_invc_sgd "
                . " FROM zhl_acc_tbl_trn_piutang WHERE kode_sup = '".$idSupp."' "
                . "AND tanggal <= '".$idDate."' AND piutang-bayar != 0 ORDER by tanggal_invoice asc");
    }
    function getKursByIDonAR($id,$tglInvoice){
        $tgl    = date('Y-m-d', strtotime($tglInvoice));
        return $query = $this->db->query("SELECT * FROM zhl_acc_tbl_trn_kurs WHERE periode <= '".$tgl."' AND currency_id = '".$id."' ORDER BY periode DESC LIMIT 1");
    }
    
    function getKursByID($id,$tglInvoice = ''){
        $tgl    = date('Y-m-d', strtotime($tglInvoice));
        return $query = $this->db->query("SELECT * FROM zhl_acc_tbl_trn_kurs WHERE periode <= '".$tgl."' AND currency_id = '".$id."' ORDER BY periode DESC LIMIT 1");
    }

    // ############# = Insert Detail AP Accounting = #############
    function insertDetailARaccountingFromPayment($data){
        $this->db->insert('zhl_acc_tbl_trn_arpaymentdtl', $data);
    }
    // ================================== VVV ================================
    function insertDetailARjurnal($data){
        $this->db->insert('zhl_fin_tbltrn_payment_jurnal_dtl', $data);
    }
    
    // ############################################################################## //
    // ############################################################################## //
    function selectARforFindAR(){
        // $this->db->where('status_customer', 1);
        // $sql_prov = $this->db->get('fin_vw_trn_selectar_for_find');
        // if ($sql_prov->num_rows() > 0) {
        //     $result[''] = 'Select';
        //     foreach ($sql_prov->result_array() as $row) {
        //         $result[$row['customer_code'] . "|" . $row['coa']] = ucwords(strtoupper($row['customer_name']));
        //     }
        //     return $result;
        // } else {
        //     echo "";
        // }

        //$this->db->where('status_customer', 1);
        $select = $this->db->get('zhl_fin_vw_trn_selectar_for_find');
        return $select;
    }
    function selectHeaderARforReview($headerID){
        $this->db->where('header_id', $headerID);
        $get    = $this->db->get('zhl_fin_vw_trn_selectar_header_review_test');
        return $get->row();
    }
    function selectHeaderARforReviewByNoReff($headerID){
        $this->db->where('no_facture', $headerID);
        $get    = $this->db->get('zhl_fin_vw_trn_selectar_header_review_test');
        return $get->row();
    }
    
    function selectInvoiceARforReview($noReff){
        $this->db->where('NomorAR', $noReff);
        $get    = $this->db->get('zhl_fin_vw_trn_selectar_invoice_review');
        return $get->result();
    }
    function selectDetailARforReview($headerID){
        $this->db->where('header_id', $headerID);
        $select = $this->db->get('zhl_fin_tbltrn_payment_dtl');
        return $select;
    }
    function selectCustomerForARbyCode($code){
        $this->db->where('customer_code', $code);
        $this->db->where('status_customer', 1);
        $get    = $this->db->get('zhl_fin_vw_mst_customer');
        return $get->row();
    }
    function selectDetailJurnalARforReview($headerID){
        $this->db->where('header_id', $headerID);
        $select = $this->db->get('zhl_fin_tbltrn_payment_jurnal_dtl');
        return $select;
    }
    
    // ############ RETURN BACK AR PAYMENT ############
    function resetPaymentPiutang($noInvoice,$jenis){
        $this->db->query("UPDATE zhl_acc_tbl_trn_piutang SET bayar = (SELECT SUM(Total) FROM zhl_acc_tbl_trn_arpaymentdtl "
                . "WHERE zhl_acc_tbl_trn_arpaymentdtl.NoInvoice = '".$noInvoice."' and zhl_acc_tbl_trn_arpaymentdtl.jenis_trans = '".$jenis."') WHERE zhl_acc_tbl_trn_piutang.nofaktur = '".$noInvoice."' and zhl_acc_tbl_trn_piutang.jenis_trans = '".$jenis."' ");
    }
    function deleteDetailARaccountingFromPayment($nomorAR){
        $this->db->where('NomorAR',$nomorAR);
        $this->db->delete('zhl_acc_tbl_trn_arpaymentdtl');
    }
    function deleteARfromJurnalAcc($nomorAR){
        $this->db->where(array('NoJurnal' => $nomorAR, 'jenis_trans' => 'AR'));
        $this->db->delete('zhl_acc_tbl_trn_jurnal');
    }
    function deleteARfromCBhistory($nomorAR,$primary){
        $this->db->where(array('header_id' => $primary, 'no_facture' => $nomorAR, 'trans_type' => 'AR'));
        $this->db->delete('zhl_fin_tbltrn_cashbank_journal_history');
    }
    function deleteDetailARpayment($nomorAR,$primary){
        $this->db->where(array('header_id' => $primary, 'no_facture' => $nomorAR));
        $this->db->delete('zhl_fin_tbltrn_payment_dtl');
    }
    function deleteHeaderARpayment($primary){
        $this->db->where('header_id', $primary);
        $this->db->delete('zhl_fin_tbltrn_payment_hdr');
    }

    function deleteDetailARjurnal($nomorAP,$primary){
        $this->db->where(array('header_id' => $primary, 'no_reff' => $nomorAP));
        $this->db->delete('zhl_fin_tbltrn_payment_jurnal_dtl');
    }

    function updateHeaderARpayment($primary,$data){
        $this->db->where('header_id', $primary);
        $this->db->update('zhl_fin_tbltrn_payment_hdr',$data);
    }

    function updateARfromJurnalAcc($nomorAR,$data){
        $this->db->where(array('NoJurnal' => $nomorAR, 'jenis_trans' => 'AR'));
        $this->db->update('zhl_acc_tbl_trn_jurnal',$data);
    }
    
    // ##########======================================================#################
    function getCurrOnDateInvoiceByCurrencyIDonAR($noInvoice,$currency){
        $get = $this->db->query("SELECT * FROM zhl_acc_tbl_trn_kurs WHERE periode < (SELECT tanggal FROM zhl_acc_tbl_trn_piutang "
                . "WHERE nofaktur = '".$noInvoice."') AND currency_id = '".$currency."' ORDER BY periode DESC LIMIT 1");
        $row = $get->row();
        return $row->rate_usd;
    }

    
    // ###=============== PUR SHIP =============
    function checkInvoiceInPurShip($noInvoice){
        $get = $this->db->query("SELECT * FROM zhl_acc_tbl_trn_piutang WHERE nofaktur = '".$noInvoice."' AND bayar >= piutang AND jenis_trans = 'PIJF'");
        $set = $get->row();
        if($get->num_rows() > 0){
            return $data = array('status' => TRUE, 'noInvoice' => $set->nofaktur);
        }
        return $data = array('status' => FALSE, 'noInvoice' => 0);
    }

    function updatePurchase($noInvoice){
        $this->db->where('invno', $noInvoice);
        $this->db->update('zhl_pur_tbl_trn_inv_hdr', array('status' => 2));
    }
    function updateShipping($noInvoice){
        $this->db->where('invno', $noInvoice);
        $this->db->update('zhl_ship_tbl_trn_inv_hdr', array('status' => 2));
    }
}