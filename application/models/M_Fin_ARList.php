<?php defined('BASEPATH') OR exit('No direct script access allowed');

/* 
 * Author : Ismo Broto
 */

class M_Fin_ARList extends CI_Model{
    public function __construct() {
        parent::__construct();
    }
    
    function selectARforListAR(){
        $select = $this->db->get('zhl_fin_vw_trn_selectar_for_find');
        return $select;
    }
    function selectARheaderforListARbyHeaderID($headerID){
        $this->db->where('header_id', $headerID);
        $select = $this->db->get('zhl_fin_tbltrn_payment_hdr');
        return $select->row();
    }
    function selectDetailARbyHeaderID($headerID){
        $this->db->where('header_id', $headerID);
        $select = $this->db->get('zhl_fin_tbltrn_payment_dtl');
        return $select;
    }
    function selectDetailJurnalARbyHeaderID($headerID){
        $this->db->where('header_id', $headerID);
        $select = $this->db->get('zhl_fin_tbltrn_payment_jurnal_dtl');
        return $select;
    }
    function selectDetailARinAccByHeaderID($noAP){
        $this->db->where('NomorAR', $noAP);
        $select = $this->db->get('zhl_acc_tbl_trn_arpaymentdtl');
        return $select;
    }
}