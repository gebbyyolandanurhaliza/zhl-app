<?php

/**
 * Created by PhpStorm.
 * User: rezai
 * Date: 4/13/2017
 * Time: 2:29 PM
 */
class M_Mst_Bank extends CI_Model
{

    var $tbl_bank = 'zhl_gen_tbl_mst_bank';

    function select_bank() {
        $this->db->select('*');
        $this->db->order_by('IDBank');
        $sql_product = $this->db->get('zhl_gen_tbl_mst_bank');
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


    function cek_bank($id){
        $this->db->select('*');
        $this->db->where('IDBank', $id);
        $sql_group = $this->db->get($this->tbl_bank);
        if ($sql_group->num_rows() > 0) {
            foreach ($sql_group->result() as $value) {
                $result[] = $value;
            }
            return $result;
        }
    }

    function input_kodebank($data) {
        $this->db->insert($this->tbl_bank, $data);
    }

    function update_kodebank($id, $data) {
        $this->db->where('IDBank', $id);
        $this->db->update($this->tbl_bank, $data);
    }

    function list_bank() {
        $this->db->select('IDBank, NamaBank');
        $sql_group = $this->db->get('zhl_gen_tbl_mst_bank');
        if ($sql_group->num_rows() > 0) {
            $result[""] = "Select";
            foreach ($sql_group->result_array() as $row) {
                $result[$row['IDBank']] = ucwords(strtoupper($row['NamaBank']));
            }
            return $result;
        }
    }
}