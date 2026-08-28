<?php

/**
 * Created by PhpStorm.
 * User: rezai
 * Date: 4/13/2017
 * Time: 2:29 PM
 */
class M_Mst_Rekening extends CI_Model
{

    var $tbl_rekening = 'zhl_kk_tbl_mst_rekening';


    function select_rekening() {
        $this->db->select('*');
        $this->db->order_by('NomorRekening');
        $sql_product = $this->db->get('zhl_vw_kk_mst_rekening');
        if ($sql_product->num_rows() > 0) {
            foreach ($sql_product->result() as $row) {
                $result[] = $row;
            }
        }
        else{
            $result=null;
        }
        return $result;
    }

    function input_rekening($data) {
        $this->db->insert($this->tbl_rekening, $data);
    }
    function update_rekening($id, $data) {
        $this->db->where('NoRek', $id);
        $this->db->update($this->tbl_rekening, $data);
    }

    function cek_rek($id){
        $this->db->select('*');
        $this->db->where('NoRek', $id);
        $sql_group = $this->db->get($this->tbl_rekening);
        if ($sql_group->num_rows() > 0) {
            foreach ($sql_group->result() as $value) {
                $result[] = $value;
            }
            return $result;
        }
    }


}