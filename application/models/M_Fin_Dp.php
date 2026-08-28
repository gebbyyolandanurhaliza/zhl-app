<?php defined('BASEPATH') OR exit('No direct script access allowed');

/* 
 * Author : ITD15
 */

class M_Fin_Dp extends CI_Model{

	function getPeriodInDP(){
        return $this->session->userdata('periode_1').'/01';
    }

	function selectCOAforDp(){
        return $this->db->query("SELECT * FROM zhl_fin_vw_mst_coa_balance ORDER BY AccountName");
    }

    function selectSupplierforDP(){
        return $this->db->query("SELECT supplierid, suppliercompany,`group`, zhl_fin_vw_mst_supplier.nocoa AS nocoa, zhl_acc_master_coa.AccountName AS name_coa FROM zhl_fin_vw_mst_supplier JOIN zhl_acc_master_coa ON zhl_fin_vw_mst_supplier.nocoa = zhl_acc_master_coa.NoCOA");
    }
    function selectCustomerforDP(){
        return $this->db->query("SELECT customer_code, customer_company_name, customer_group_name, coa, zhl_acc_master_coa.AccountName AS name_coa FROM zhl_fin_vw_mst_customer JOIN zhl_acc_master_coa ON zhl_fin_vw_mst_customer.coa = zhl_acc_master_coa.NoCOA AND zhl_fin_vw_mst_customer.status_customer=1");
    }

    function selectHeaderDepositInvoice($headerID){
        $this->db->where('header_id', $headerID);
        $get    = $this->db->get('zhl_fin_vw_select_header_deposit_invoice');
        return $get->row();
    }

    // ========= Cek Deposit
    function cekDepositInJournal($noInv){
    	$hutang	= $this->db->query("SELECT nofaktur FROM zhl_acc_tbl_trn_hutang WHERE nofaktur = '".$noInv."'");
    	$jurnal = $this->db->query("SELECT NoJurnal FROM zhl_acc_tbl_trn_jurnal WHERE NoJurnal = '".$noInv."'");
    	$bank	= $this->db->query("SELECT no_reff FROM zhl_fin_tbltrn_cashbank_journal_header WHERE no_reff = '".$noInv."'");

    	if ($hutang->num_rows() > 0) {
    		return TRUE;
    	} elseif ($jurnal->num_rows() > 0) {
    		return TRUE;
    	} elseif ($bank->num_rows() > 0) {
    		return TRUE;
    	} else {
    		return FALSE;
    	}
    }

    // ========= Select Data
    function selectHeaderDepositAP($headerID){
    	$this->db->where('header_id', $headerID);
        $get    = $this->db->get('zhl_fin_tbltrn_cashbank_journal_header');
        return $get->row();
    }
    function selectDetailDepositAP($headerID){
    	$this->db->where('header_id', $headerID);
        $this->db->order_by('detail_id');
        $get    = $this->db->get('zhl_fin_tbltrn_cashbank_journal_detail');
        return $get;
    }

    function selectDepositAPforFind(){
    	/*$this->db->where('prepaid', '1');
        $this->db->where('trans_type', 'O');
    	$get    = $this->db->get('fin_tbltrn_cashbank_journal_header');*/
        $get    = $this->db->query("SELECT zhl_fin_tbltrn_cashbank_journal_header.*, zhl_fin_vw_mst_supplier.suppliercompany FROM zhl_fin_tbltrn_cashbank_journal_header LEFT JOIN zhl_fin_vw_mst_supplier ON zhl_fin_vw_mst_supplier.supplierid = zhl_fin_tbltrn_cashbank_journal_header.suplier WHERE prepaid = 1 AND trans_type in ('O','PDP')");
        return $get->result();
    }

    function selectDepositARforFind(){
        /*$this->db->where('prepaid IN (1,5)');
        $this->db->where('trans_type', 'I');
        $get    = $this->db->get('fin_tbltrn_cashbank_journal_header');*/
        $get    = $this->db->query("SELECT zhl_fin_tbltrn_cashbank_journal_header.*, zhl_fin_vw_mst_customer.customer_company_name FROM zhl_fin_tbltrn_cashbank_journal_header LEFT JOIN zhl_fin_vw_mst_customer ON zhl_fin_vw_mst_customer.customer_code = zhl_fin_tbltrn_cashbank_journal_header.suplier WHERE prepaid IN (1,5) AND trans_type in ('I','RDP') and not_active=0 ");
        return $get->result();
    }

    // ======== Insert to Journal ======
    function insertToJurnalAccFromDP($data){
        $this->db->insert('zhl_acc_tbl_trn_jurnal', $data);
    }

    // ======== Update ========
    function updateCashBankHeaderFromDeposit($headerID, $data){
    	$this->db->where('header_id', $headerID);
    	$this->db->update('zhl_fin_tbltrn_cashbank_journal_header', $data);
    }

    // ======== Delete ========
    function deleteHutang($noInv){
    	$this->db->where('nofaktur', $noInv);
    	$this->db->delete('zhl_acc_tbl_trn_hutang');
    }
    function deleteHutangBulanan($noInv){
    	$this->db->where('nofaktur', $noInv);
    	$this->db->delete('zhl_acc_tbl_trn_hutang_bulanan');
    }
    function deleteJurnal($noInv){
    	$this->db->where(array('NoJurnal' => $noInv, 'jenis_trans' => 'PDP'));
    	$this->db->delete('zhl_acc_tbl_trn_jurnal');
    }
    function deleteBank($primary){
    	$this->db->where('header_id', $primary);
    	$this->db->delete('zhl_fin_tbltrn_cashbank_journal_header');
    }
    function deleteBankDetail($primary){
    	$this->db->where('header_id', $primary);
    	$this->db->delete('zhl_fin_tbltrn_cashbank_journal_detail');
    }
    function deleteHistory($primary,$noInv){
    	$this->db->where(array('header_id' => $primary, 'no_facture' => $noInv, 'prepaid' => '1'));
    	$this->db->delete('zhl_fin_tbltrn_cashbank_journal_history');
    }

    function updateBank($primary,$data){
        $this->db->where('header_id', $primary);
        $this->db->update('zhl_fin_tbltrn_cashbank_journal_header',$data);
    }

    function updateJurnalAP($noInv,$data){
        $this->db->where(array('NoJurnal' => $noInv, 'jenis_trans' => 'PDP'));
        $this->db->update('zhl_acc_tbl_trn_jurnal',$data);
    }

    function updateJurnalAR($noInv,$data){
        $this->db->where(array('NoJurnal' => $noInv, 'jenis_trans' => 'RDP'));
        $this->db->update('zhl_acc_tbl_trn_jurnal',$data);
    }

    // function updateJurnalARin($noInv,$data){
    //     $this->db->where(array('NoJurnal' => $noInv, 'jenis_trans' => 'RDP'));
    //     $this->db->update('acc_tbl_trn_jurnal',$data);
    // }

    // ==================
    function deletePiutang($noInv){
        $this->db->where('nofaktur', $noInv);
        $this->db->delete('zhl_acc_tbl_trn_piutang');
    }
    function deletePiutangBulanan($noInv){
        $this->db->where('nofaktur', $noInv);
        $this->db->delete('zhl_acc_tbl_trn_piutang_bulanan');
    }
    function deleteJurnalAR($noInv){
        $this->db->where(array('NoJurnal' => $noInv, 'jenis_trans' => 'RDP'));
        $this->db->delete('zhl_acc_tbl_trn_jurnal');
    }

    function deleteJurnalARin($noInv){
        $this->db->where(array('NoJurnal' => $noInv, 'jenis_trans' => 'I'));
        $this->db->delete('zhl_acc_tbl_trn_jurnal');
    }


    ////
    //===========
    function selectHeaderARforPrintPDF($niInv){
        return $this->db->query("SELECT * FROM zhl_fin_vw_trn_ar_deposit_print_header WHERE no_reff = '".$niInv."'");
    }

    //#########================= Deposit Recieve 
    function updatePiutangByNoInvoiceInOneARnumberRecieveDeposit($noInvoice,$data){
        $this->db->where('nofaktur',$noInvoice);
        $this->db->update('zhl_acc_tbl_trn_piutang', $data);
    }
    function updatepiutangBulananByNoInvoiceInOneARnumberQueryReceiveDeposit($noInvoice,$blnPeriod,$thnPeriod,$payment,$header){
        $this->db->query("UPDATE zhl_acc_tbl_trn_piutang_bulanan SET bayar = bayar + '".$payment."', nofaktur = '".$header."' "
            . "WHERE nofaktur = '".$noInvoice."' AND periode_bulan = '".$blnPeriod."' AND periode_tahun = '".$thnPeriod."'");
    }

    //##+===========
    function selectDetailDepositByNoReff($headerID){
        $this->db->where('no_reff', $headerID);
        $get    = $this->db->get('zhl_fin_tbltrn_cashbank_journal_header');
        return $get;
    }

    function selectCOAforARDP(){
        return $this->db->query("SELECT * FROM zhl_fin_vw_mst_coa_balance ORDER BY AccountName");
    }
}