<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class m_eform extends CI_Model{
    //=========================================E-Form===================================
    function get_document(){
        $this->db->order_by('document_id');
        $result=  $this->db->get('mar_tblmst_document');
        return $result->result();        
    }

    function get_list_po_needed($doc_id){
        $this->db->where('document_id = "'.$doc_id.'"');
        $this->db->order_by('ship_id');
        $result=$this->db->get('eform_vw_document_list');
        return $result->result();        
    }

    function get_product($ship,$po,$custid,$fac){
        $this->db->where('ship_id = "'.$ship.'" and po_hdr_id = "'.$po.'"');
        $this->db->order_by('ship_id');
        $result=$this->db->get('mar_vw_trn_shipping_instruction_product');
        return $result->result();
    }

    function get_po_information($ship){
        $this->db->where('ship_id = "'.$ship.'"');
        $this->db->order_by('ship_id');
        $result=$this->db->get('mar_vw_trn_shipping_instruction');
        return $result->result();        
    }

    function get_product_detail($ship,$po,$custid,$fac,$proid){
        $this->db->where('ship_id = "'.$ship.'" and po_hdr_id = "'.$po.'" and ship_product_id="'.$proid.'"');
        $this->db->order_by('ship_id');
        $result=$this->db->get('mar_vw_trn_shipping_instruction_product');
        return $result->result();        
    }

    function get_factory($fac){
        $this->db->where('id = "'.$fac.'"');
        $this->db->order_by('id');
        $result=$this->db->get('ship_mst_trn_factory_sambu_group');
        return $result->result();        
    }

    function get_cont_shipment($ship){
        $this->db->where('shipid = "'.$ship.'" and tipe = "2"');
        $result=$this->db->get('ship_vw_trn_cont');
        return $result->result();        
    }

    function simpan_coa_gen_hdr($data){
        $this->db->insert('eform_tbl_trn_coa_hdr_general',$data);
        $primary_key=$this->db->insert_id();
        return $primary_key;
    }

    function simpan_coa_gen_dtl_1($data_dtl){
        $this->db->insert('eform_tbl_trn_coa_dtl_1_general',$data_dtl);
        return true;
    }

    function simpan_coa_gen_dtl_2($data){
        $this->db->insert('eform_tbl_trn_coa_dtl_2_general',$data);
        return true;
    }

    function simpan_coa_gen_dtl_3($data){
        $this->db->insert('eform_tbl_trn_coa_dtl_3_general',$data);
        return true;
    }

     function get_coa_gen_hdr($id_coa_gen){
       $this->db->where('id_coa_gen',$id_coa_gen);
       return $this->db->get('eform_tbl_trn_coa_hdr_general')->result();
    }

    function get_coa_gen_dtl_1($id_coa_gen){
       $this->db->where('id_coa_gen',$id_coa_gen);
       return $this->db->get('eform_tbl_trn_coa_dtl_1_general')->result();

    }

    function get_coa_gen_dtl_2($id_coa_gen){
       $this->db->where('id_coa_gen',$id_coa_gen);
       return $this->db->get('eform_tbl_trn_coa_dtl_2_general')->result();

    }

    function get_coa_gen_dtl_3($id_coa_gen){
       $this->db->where('id_coa_gen',$id_coa_gen);
       return $this->db->get('eform_tbl_trn_coa_dtl_3_general')->result();

    }
}
