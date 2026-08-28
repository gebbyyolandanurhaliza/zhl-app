<?php defined('BASEPATH') OR exit('No direct script access allowed');

/* 
 * Author : Ismo Broto
 */

class M_Fin_APList extends CI_Model{
    public function __construct() {
        parent::__construct();
    }
    
    function selectAPforListAP(){
        $select = $this->db->get('zhl_fin_vw_trn_selectap_for_find');
        return $select;
    }
    function selectAPheaderforListAPbyHeaderID($headerID){
        $this->db->where('header_id', $headerID);
        $select = $this->db->get('zhl_fin_tbltrn_payment_hdr');
        return $select->row();
    }
    function selectDetailAPbyHeaderID($headerID){
        $this->db->where('header_id', $headerID);
        $select = $this->db->get('zhl_fin_tbltrn_payment_dtl');
        return $select;
    }
    function selectDetailJurnalAPbyHeaderID($headerID){
        $this->db->where('header_id', $headerID);
        $select = $this->db->get('zhl_fin_tbltrn_payment_jurnal_dtl');
        return $select;
    }
    function selectDetailAPinAccByHeaderID($noAP){
        $this->db->where('NomorAP', $noAP);
        $select = $this->db->get('zhl_acc_tbl_trn_appaymentdtl');
        return $select;
    }
}