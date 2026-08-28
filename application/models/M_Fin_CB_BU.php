<?php ('BASEPATH') OR exit('No direct script access allowed');

/* 
 * Author : Ismo
 */

class M_Fin_CB extends CI_Model{
    public function __construct() {
        parent::__construct();
    }

    function newCheckReffNumber($type, $tanggal, $currency){
        $tgl    = date("Y", strtotime($tanggal));
        if ($type == 'OUT' && $currency == 'USD') {
            $inJurnal   = $this->db->query("SELECT substring(reff_number,7,4) AS GEN FROM zhl_fin_vw_auto_reff_number WHERE type NOT IN('I', 'O') "
                . "AND type IN ('BO', 'CO', 'AP', 'PDP') AND tanggal = '".$tgl."' AND currency = 'USD' ORDER BY GEN DESC LIMIT 1");
        }else if ($type == 'OUT' && $currency == 'SGD') {
            $inJurnal   = $this->db->query("SELECT substring(reff_number,6,4) AS GEN FROM zhl_fin_vw_auto_reff_number WHERE type NOT IN('I', 'O') "
                . "AND type IN ('BO', 'CO', 'AP', 'PDP') AND tanggal = '".$tgl."' AND currency = 'SGD' ORDER BY GEN DESC LIMIT 1");
        }else if($type == 'IN' && $currency == 'USD'){
            $inJurnal   = $this->db->query("SELECT substring(reff_number,7,4) AS GEN FROM zhl_fin_vw_auto_reff_number WHERE type NOT IN('I', 'O') "
                . "AND type IN ('BI', 'CI', 'AR', 'RDP') AND tanggal = '".$tgl."' AND currency = 'USD' ORDER BY GEN DESC LIMIT 1");
        }else if($type == 'IN' && $currency == 'SGD'){
            $inJurnal   = $this->db->query("SELECT substring(reff_number,6,4) AS GEN FROM zhl_fin_vw_auto_reff_number WHERE type NOT IN('I', 'O') "
                . "AND type IN ('BI', 'CI', 'AR', 'RDP') AND tanggal = '".$tgl."' AND currency = 'SGD' ORDER BY GEN DESC LIMIT 1");
        }

        if($inJurnal->num_rows() > 0){
            $get    = $inJurnal->row();
            $set    = $get->GEN;
        }else{
            $set    = 0;
        }

        $num    = intval($set);
        return $num+1;
    }
    
    function countReffCB($tgl,$type){
        $get    = $this->db->query("SELECT header_id FROM zhl_fin_tbltrn_cashbank_journal_header WHERE "
                . "EXTRACT(YEAR FROM created_date) = YEAR('".$tgl."') AND "
                . "EXTRACT(MONTH FROM created_date) = MONTH('".$tgl."') AND "
                . "trans_type = '".$type."'");
        return $get->num_rows()+1;
    }
    function selectCOAforCBtrans(){
        return $this->db->query("SELECT * FROM zhl_fin_vw_mst_coa_balance ORDER BY AccountName");
    }
    function selectMasterCOAforCB(){
        return $this->db->query("SELECT * FROM zhl_acc_master_coa ORDER BY AccountName");
    }
    function selectMasterCOAforAddCost(){
        return $this->db->query("SELECT * FROM zhl_fin_vw_mst_coa_add_cost ORDER BY AccountName");
    }
    function selectEmployeeForCashBank(){
        return $this->db->query("SELECT * FROM zhl_fin_tblmst_karyawan ORDER BY department");
    }
    function selectIOtypeForCB(){
        $select = $this->db->get('zhl_fin_tblmst_io_type');
        return $select->result();
    }
    function getKursByIDforCB($id,$tglInvoice){
        $tgl    = date('Y-m-d', strtotime($tglInvoice));
        return $query = $this->db->query("SELECT * FROM zhl_acc_tbl_trn_kurs WHERE periode < '".$tgl."' AND currency_id = '".$id."' ORDER BY periode DESC LIMIT 1");
    }
    function getTransTypeIObyCode($code){
        return $this->db->query("SELECT * FROM zhl_fin_tblmst_io_type WHERE io_code = '".$code."'");
    }
    function selectSupplierforCBtrans(){
        return $this->db->query("SELECT * FROM zhl_fin_vw_mst_supplier WHERE supplierid IN (SELECT vendorid FROM zhl_pur_tbl_trn_po_hdr "
                . "WHERE status != 2 AND mainpo NOT IN (SELECT po_id FROM zhl_fin_tbltrn_cashbank_journal_detail_po))");
    }
    function selectCustomerforCBtrans(){
        return $this->db->query("SELECT * FROM zhl_fin_vw_mst_customer WHERE customer_id IN (SELECT factory_id FROM zhl_mar_tbltrn_purchase_order "
                . "WHERE status_id = 0 AND po_number NOT IN (SELECT po_id FROM zhl_fin_tbltrn_cashbank_journal_detail_po))");
    }
    function selectPObySupplierForCBtrans($idSupp){
        return $this->db->query("SELECT * FROM zhl_pur_tbl_trn_po_hdr WHERE vendorid = '".$idSupp."' "
                . "AND status != 2 AND mainpo NOT IN (SELECT po_id FROM zhl_fin_tbltrn_cashbank_journal_detail_po)");
    }
    function selectPObyCustomerForCBtrans($idCust){
        return $this->db->query("SELECT * FROM zhl_mar_tbltrn_purchase_order WHERE factory_id = '".$idCust."' "
                . "AND status_id = 0 AND po_number NOT IN (SELECT po_id FROM zhl_fin_tbltrn_cashbank_journal_detail_po)");
    }
    function getCOAforDPcashBank($type){
        return $this->db->query("SELECT * FROM zhl_fin_tblmst_coa_dp WHERE type_dp = '".$type."'");
    }
    function getEmployeeByHeaderIDforNui($headerID){
        $this->db->where('header_id', $headerID);
        $get = $this->db->get('zhl_fin_tblmst_karyawan');
        return $get->row();
    }
    function getMasterCOAbyNumberforNui($coa){
        $this->db->where('NoCOA', $coa);
        $get = $this->db->get('zhl_acc_master_coa');
        return $get->row();
    }

    // ========== ## Insert Detail Down Payment PO in Cash Bank ## ==========
    function insertDetailPOcbTransaction($data){
        $this->db->insert('zhl_fin_tbltrn_cashbank_journal_detail_po', $data);
    }
    
    // ################################################################################################
    function selectHeaderCashBankForFind(){
        $this->db->where("prepaid NOT IN (1,2)");
        return $this->db->get('zhl_fin_tbltrn_cashbank_journal_header');
    }
    function selectHeaderCashBankForFindNui(){
        $this->db->where("prepaid = 2");
        return $this->db->get('zhl_fin_tbltrn_cashbank_journal_header');
    }
    function selectHeaderCashBankForReviewByID($headerID){
        $this->db->where('header_id', $headerID);
        $get = $this->db->get('zhl_fin_vw_trn_select_cb_header_review');
        return $get->row();
    }
    function selectPurchesForReviewByHeaderID($headerID){
        $this->db->where('header_id', $headerID);
        $select = $this->db->get('zhl_fin_vw_trn_select_cb_purch_review');
        return $select->result();
    }
    function checkPurchesForReviewByHeaderID($headerID){
        $this->db->where('header_id', $headerID);
        $select = $this->db->get('zhl_fin_vw_trn_select_cb_purch_review');
        
        if($select->num_rows() > 0){
            return TRUE;
        }  else {
            return FALSE;
        }
    }
    function selectDetailCashBankForReviewByHeaderID($headerID){
        $this->db->where('header_id', $headerID);
        $select = $this->db->get('zhl_fin_tbltrn_cashbank_journal_detail');
        return $select->result();
    }
    // ============ ##Return Cash Bank Transaction## ============
    function deleteDetailPOcbTransaction($headerID){
        $this->db->where('header_id', $headerID);
        $this->db->delete('zhl_fin_tbltrn_cashbank_journal_detail_po');
    }
    function deleteCashBankFromJurnal($hearedID){
        $this->db->where("NoJurnal = '".$hearedID."' AND jenis_trans IN (SELECT io_code FROM zhl_fin_tblmst_io_type)");
        $this->db->delete('zhl_acc_tbl_trn_jurnal');
    }
    function deleteCashBankFromHistory($hearedID){
        $this->db->where("header_id = '".$hearedID."' AND trans_type IN (SELECT io_code FROM zhl_fin_tblmst_io_type)");
        $this->db->delete('zhl_fin_tbltrn_cashbank_journal_history');
    }
    function deleteCashBankDetailByHeaderID($headerID){
        $this->db->where('header_id', $headerID);
        $this->db->delete('zhl_fin_tbltrn_cashbank_journal_detail');
    }
    function deleteCashBankHeaderByHeaderID($headerID){
        $this->db->where('header_id', $headerID);
        $this->db->delete('zhl_fin_tbltrn_cashbank_journal_header');
    }
    
    // =============== Check Saldo ===============
    function chechSaldoAwal($bankCode){
        $get    = $this->db->query("SELECT saldo_awal FROM zhl_fin_tblmst_awal_saldo WHERE no_coa = '".$bankCode."' ");
        $ambil  = $get->row();
        return $ambil->saldo_awal;
    }

    function checkSaldoKini($bankCode){
        $check  = $this->db->query("SELECT saldo_awal + (SELECT IF(SUM(debit) - SUM(credit) IS NULL, 0, SUM(debit) - SUM(credit)) FROM zhl_fin_tbltrn_cashbank_journal_history WHERE coa_code = '".$bankCode."') AS saldo_kini FROM zhl_fin_tblmst_awal_saldo WHERE no_coa = '".$bankCode."' ");
        $result = $check->row();
        return $result->saldo_kini;
    }
}