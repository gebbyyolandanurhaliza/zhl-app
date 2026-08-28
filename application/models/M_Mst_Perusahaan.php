<?php

/**
 * Created by PhpStorm.
 * User: rezai
 * Date: 4/15/2017
 * Time: 10:10 AM
 */
class M_Mst_Perusahaan extends CI_Model
{
    var $tbl_perusahaan = 'zhl_gen_tbl_mst_perusahaan';

    function select_perusahaan() {
        $this->db->select('*');
        $this->db->order_by('IDPerusahaan');
        $sql_product = $this->db->get($this->tbl_perusahaan);
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


    function cek_perusahaan($id){
        $this->db->select('*');
        $this->db->where('IDPerusahaan', $id);
        $sql_group = $this->db->get($this->tbl_perusahaan);
        if ($sql_group->num_rows() > 0) {
            foreach ($sql_group->result() as $value) {
                $result[] = $value;
            }
            return $result;
        }
    }

    function input_kodeperusahaan($data) {
        $this->db->insert($this->tbl_perusahaan, $data);
    }

    function update_kodeperusahaan($id, $data) {
        $this->db->where('IDPerusahaan', $id);
        $this->db->update($this->tbl_perusahaan, $data);
    }

    function list_perusahaan() {
        $this->db->select('IDPerusahaan, NamaPerusahaan');
        $sql_group = $this->db->get('zhl_gen_tbl_mst_perusahaan');
        if ($sql_group->num_rows() > 0) {
            $result[""] = "Select";
            foreach ($sql_group->result_array() as $row) {
                $result[$row['IDPerusahaan']] = ucwords(strtoupper($row['NamaPerusahaan']));
            }
            return $result;
        }
    }
}