<?php

class M_period extends CI_Model {

    var $aac_tbl_mst_priode = 'zhl_acc_tbl_mst_periode';

    function __construct() {
        parent::__construct();
    }
    
    function simpan($data){
        $this->db->update($this->aac_tbl_mst_priode, $data);
    }

    function get_closing(){
        $sql_product = $this->db->get('zhl_acc_tbl_mst_periode');
        if ($sql_product->num_rows() > 0) {
            foreach ($sql_product->result() as $data) {
                $hasil[] = $data;
            }
            return $hasil;
        }
    }
    
    function exe_post($data){
        $qry = 'call zhl_sp_acc_trn_posting (?, ?, ?)';
        $this->db->query($qry, $data);
    }
    
}
