<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_solas extends CI_Model{
//-----------------------------------------------------------ABOUT Mon Shipping Line-------------------------------------------------------------------
    //function tampil_container_stock_filter($tipe,$shipdate,$factory,$ref,$cont,$seal){
    function tampil_data_solas($factory_tipe,$dari,$sampai){        
        $sql="factory like '%".$factory_tipe."%'";
        $this->db->where('arrival_date between "' . date('Y-m-d', strtotime($dari)) . '" and "' . date('Y-m-d', strtotime($sampai)) . '"');
        $this->db->where($sql);

        $result=$this->db->get('zhl_ship_vw_trn_cont_stock_mon');
        return $result->result();
    }
    
}