<?php ('BASEPATH') OR exit('No direct script access allowed');

/* 
 * Author : Ismo
 */

class M_Fin_AR_zht extends CI_Model{
    private $tblTran    = array(
    'CashBankHeader'    => 'zht_fin_tbltrn_cashbank_journal_header',
    'CashBankDetail'    => 'zht_fin_tbltrn_cashbank_journal_detail',

    'PaymentAPheader'   => 'zht_fin_tbltrn_payment_hdr',
    'PaymentAPdetail'   => 'zht_fin_tbltrn_payment_dtl'
    );

    public function __construct() {
        parent::__construct();
    }
    // == this period
    function getPeriod_mar(){
        return $this->session->userdata('periode_1').'/01';
    }
    
    function selectARfromAccounting(){
        $select = $this->db->query("SELECT zhl_fin_vw_trn_select_arheader.*, zhl_tims_mst_customer.customer_company_name, zhl_tims_mst_customer.coa as nocoa "
                . "FROM zhl_fin_vw_trn_select_arheader JOIN zhl_tims_mst_customer "
                . "ON zhl_fin_vw_trn_select_arheader.SupplierID = zhl_tims_mst_customer.customer_code "
                . "WHERE zhl_fin_vw_trn_select_arheader.NomorAR NOT IN (SELECT no_voucher FROM zht_fin_tbltrn_payment_hdr)");
        return $select;
    }
    function selectCOAforARtrans($company){
        return $this->db->query("SELECT * FROM zhl_fin_vw_mst_coa_balance_tims WHERE company_id='$company' ORDER BY AccountName");
    }
    function selectCOAforARtrans_zht(){
        return $this->db->query("SELECT * FROM zhl_fin_vw_mst_coa_balance_tims WHERE company_id='2' ORDER BY AccountName");
    }
    function selectCustomerforARtrans($tgl){
        $getPeriod  = $this->getPeriod_mar();
        $blnPeriod  = date('m',  strtotime($tgl));
        $thnPeriod  = date('Y',  strtotime($tgl));
        $idDate     = date('Y-m-d', strtotime($tgl));
        return $this->db->query("SELECT customer_code, customer_name as customer_company_name, 'Local' as customer_group_name,  coa as coa FROM `zht_mar_vw_mst_customer` WHERE customer_code IN (SELECT zhl_acc_tbl_trn_piutang_tims.kode_sup "
                . "FROM zhl_acc_tbl_trn_piutang_tims WHERE piutang-bayar <> 0 AND zhl_acc_tbl_trn_piutang_tims.tanggal <= '".$idDate."')");
    }
    function selectInvoiceWhereForARtrans($idSupp, $idDate){
        return $this->db->query("SELECT *, (SELECT zhl_acc_tbl_trn_piutang_bulanan_tims.rate_akhir FROM zhl_acc_tbl_trn_piutang_bulanan_tims WHERE "
                . "zhl_acc_tbl_trn_piutang_bulanan_tims.nofaktur = zhl_acc_tbl_trn_piutang_tims.nofaktur "
                . "ORDER BY zhl_acc_tbl_trn_piutang_bulanan_tims.created_date DESC LIMIT 1) AS rate_akhir_bulanan, "
            ."(SELECT trans_description from zht_fin_tbltrn_cashbank_journal_header where zht_fin_tbltrn_cashbank_journal_header.no_reff=zhl_acc_tbl_trn_piutang_tims.nofaktur) as remarks,"
            . "(SELECT rate_usd FROM zhl_acc_tbl_trn_kurs WHERE periode <= '".$idDate."' AND currency_id = zhl_acc_tbl_trn_piutang_tims.currency_id ORDER BY periode DESC LIMIT 1) AS rate_invc, "
            . "(SELECT rate_sgd FROM acc_tbl_trn_kurs WHERE periode <= '".$idDate."' AND currency_id = zhl_acc_tbl_trn_piutang_tims.currency_id ORDER BY periode DESC LIMIT 1) AS rate_invc_sgd "
                . " FROM zhl_acc_tbl_trn_piutang_tims WHERE kode_sup = '".$idSupp."' "
                . "AND tanggal <= '".$idDate."' AND piutang-bayar != 0 ORDER BY tanggal_invoice desc");
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
        $this->db->insert('zhl_acc_tbl_trn_arpaymentdtl_tims', $data);
    }
    // ================================== VVV ================================
    function insertDetailARjurnal($data){
        $this->db->insert('zht_fin_tbltrn_payment_jurnal_dtl', $data);
    }
    
    // ############################################################################## //
    // ############################################################################## //
    function selectARforFindAR(){
        $select = $this->db->get('zht_fin_vw_trn_selectar_for_find');
        return $select;
    }
    function selectHeaderARforReview($headerID){
        $this->db->where('header_id', $headerID);
        $get    = $this->db->get('zht_fin_vw_trn_selectar_header_review');
        return $get->row();
    }
    function selectHeaderARforReviewByNoReff($headerID){
        $this->db->where('no_facture', $headerID);
        $get    = $this->db->get('zht_fin_vw_trn_selectar_header_review');
        return $get->row();
    }
    
    function selectInvoiceARforReview($noReff){
        $this->db->where('NomorAR', $noReff);
        $get    = $this->db->get('zht_fin_vw_trn_selectar_invoice_review');
        return $get->result();
    }
    function selectDetailARforReview($headerID){
        $this->db->where('header_id', $headerID);
        $select = $this->db->get('zht_fin_tbltrn_payment_dtl');
        return $select;
    }
    function selectCustomerForARbyCode($code){
        $this->db->select("customer_code, customer_name as customer_company_name, 'Local' as customer_group_name, account as coa");
        $this->db->where('customer_code', $code);
        $get    = $this->db->get('zhl_tims_mst_customer');
        return $get->row();
    }
    function selectDetailJurnalARforReview($headerID){
        $this->db->where('header_id', $headerID);
        $select = $this->db->get('zht_fin_tbltrn_payment_jurnal_dtl');
        return $select;
    }
    
    // ############ RETURN BACK AR PAYMENT ############
    function resetPaymentPiutang($noInvoice,$jenis){
        $this->db->query("UPDATE zhl_acc_tbl_trn_piutang_tims SET bayar = (SELECT SUM(Total) FROM zhl_acc_tbl_trn_arpaymentdtl_tims "
                . "WHERE zhl_acc_tbl_trn_arpaymentdtl_tims.NoInvoice = '".$noInvoice."' and zhl_acc_tbl_trn_arpaymentdtl_tims.jenis_trans = '".$jenis."') WHERE zhl_acc_tbl_trn_piutang_tims.nofaktur = '".$noInvoice."' and zhl_acc_tbl_trn_piutang_tims.jenis_trans = '".$jenis."' ");
    }
    function deleteDetailARaccountingFromPayment($nomorAR){
        $this->db->where('NomorAR',$nomorAR);
        $this->db->delete('zhl_acc_tbl_trn_arpaymentdtl_tims');
    }
    function deleteARfromJurnalAcc($nomorAR){
        $this->db->where(array('NoJurnal' => $nomorAR, 'jenis_trans' => 'AR'));
        $this->db->delete('zht_acc_tbl_trn_jurnal_tims');
    }
    function deleteARfromCBhistory($nomorAR,$primary){
        $this->db->where(array('header_id' => $primary, 'no_facture' => $nomorAR, 'trans_type' => 'AR'));
        $this->db->delete('zht_fin_tbltrn_cashbank_journal_history');
    }
    function deleteDetailARpayment($nomorAR,$primary){
        $this->db->where(array('header_id' => $primary, 'no_facture' => $nomorAR));
        $this->db->delete('zht_fin_tbltrn_payment_dtl');
    }
    function deleteHeaderARpayment($primary){
        $this->db->where('header_id', $primary);
        $this->db->delete('zht_fin_tbltrn_payment_hdr');//OK
    }

    function deleteDetailARjurnal($nomorAP,$primary){
        $this->db->where(array('header_id' => $primary, 'no_reff' => $nomorAP));
        $this->db->delete('zht_fin_tbltrn_payment_jurnal_dtl');
    }

    function updateHeaderARpayment($primary,$data){
        $this->db->where('header_id', $primary);
        $this->db->update('zht_fin_tbltrn_payment_hdr',$data);//OK
    }

    function updateARfromJurnalAcc($nomorAR,$data){
        $this->db->where(array('NoJurnal' => $nomorAR, 'jenis_trans' => 'AR'));
        $this->db->update('zht_acc_tbl_trn_jurnal_tims',$data);
    }
    
    // ##########======================================================#################
    function getCurrOnDateInvoiceByCurrencyIDonAR($noInvoice,$currency){
        $get = $this->db->query("SELECT * FROM zhl_acc_tbl_trn_kurs WHERE periode < (SELECT tanggal FROM zhl_acc_tbl_trn_piutang_tims "
                . "WHERE nofaktur = '".$noInvoice."') AND currency_id = '".$currency."' ORDER BY periode DESC LIMIT 1");
        $row = $get->row();
        return $row->rate_usd;
    }

    
    // ###=============== PUR SHIP =============
    function checkInvoiceInPurShip($noInvoice){
        $get = $this->db->query("SELECT * FROM zhl_acc_tbl_trn_piutang_tims WHERE nofaktur = '".$noInvoice."' AND bayar >= piutang AND jenis_trans = 'PIJF'");
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

    // ##########======================================================#################

    function getCustomerCOA($idCust)
    {
        $this->db->limit(1);
        $this->db->where("customer_code", $idCust);
        $get =  $this->db->get('zhl_tims_mst_customer');
        if ($get->num_rows() > 0) {
          return $get->row()->account;
        } else {
          return NULL;
        }
    }

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

    function getBayarFromPiutang($noInvoice, $jenis)
    {
        $get = $this->db->query("SELECT nofaktur, bayar FROM zhl_acc_tbl_trn_piutang_tims WHERE nofaktur = '" . $noInvoice . "' AND jenis_trans = '" . $jenis . "'");
        $row = $get->row();
        return $row->bayar;
    }

    function updatePiutangByNoInvoiceInOneARnumber($noInvoice, $jenis, $data)
    {
        $this->db->where('nofaktur', $noInvoice);
        $this->db->where('jenis_trans', $jenis);
        $this->db->update('zhl_acc_tbl_trn_piutang_tims', $data);
    }

    function updatepiutangBulananByNoInvoiceInOneARnumberQuery($noInvoice, $jenis, $blnPeriod, $thnPeriod, $payment)
    {
        $this->db->query("UPDATE zhl_acc_tbl_trn_piutang_bulanan_tims SET bayar = bayar + '" . $payment . "' WHERE nofaktur = '" . $noInvoice . "' AND "
          . "periode_bulan = '" . $blnPeriod . "' AND jenis_trans = '" . $jenis . "' AND periode_tahun = '" . $thnPeriod . "'");
    }

    function updatepiutangBulananByNoInvoiceInOneARnumberQueryReturn($noInvoice, $jenis, $blnPeriod, $thnPeriod, $payment)
    {
        $this->db->query("UPDATE zhl_acc_tbl_trn_piutang_bulanan_tims SET bayar = bayar - '" . $payment . "' WHERE nofaktur = '" . $noInvoice . "' AND "
          . "periode_bulan = '" . $blnPeriod . "' AND jenis_trans = '" . $jenis . "' AND periode_tahun = '" . $thnPeriod . "'");
    }

    function cek_reff($type, $tgl, $currency, $blnPeriod)
    {
        $sql   = $this->db->query("SELECT reff_number AS GEN FROM zht_fin_vw_auto_reff_number WHERE "
                . "type IN ('AR') AND tanggal = '" . $tgl . "' AND bulan = '" . $blnPeriod . "' AND currency = 'IDR' ORDER BY GEN DESC LIMIT 1");
        return $sql->row();
    }

    function newCheckReffNumber2($type, $tanggal, $currency)
    {
        $tgl    = date("Y", strtotime($tanggal));
        $bln    = date("m", strtotime($tanggal));
        $inJurnal   = $this->db->query("SELECT substring(reff_number,15,4) AS GEN FROM zht_fin_vw_auto_reff_number WHERE "
                . "type IN ('AR') AND tanggal = '" . $tgl . "'  AND bulan = '" . $bln . "' AND currency = 'SGD' ORDER BY GEN DESC LIMIT 1");

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
}