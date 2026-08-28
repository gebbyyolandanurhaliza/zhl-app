<?php

/**
 * Created by PhpStorm.
 * User: rezai
 * Date: 4/17/2017
 * Time: 11:57 AM
 */
class M_Mst_TypeTrn extends CI_Model
{

    var $tbl_tipe_trn = 'zhl_gen_tbl_mst_type_transaksi';

    function select_typetrn() {
        $this->db->select('*');
        $this->db->order_by('IDType');
        $sql_product = $this->db->get('zhl_gen_tbl_mst_type_transaksi');
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

    function input_kodetipetrn($data) {
        $this->db->insert($this->tbl_tipe_trn, $data);
    }

    function update_kodetipetrn($id, $data) {
        $this->db->where('IDType', $id);
        $this->db->update($this->tbl_tipe_trn, $data);
    }


    /*    function cek_bank($id){
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


        function list_bank() {
            $this->db->select('IDBank, NamaBank');
            $sql_group = $this->db->get('gen_tbl_mst_bank');
            if ($sql_group->num_rows() > 0) {
                $result[""] = "Select";
                foreach ($sql_group->result_array() as $row) {
                    $result[$row['IDBank']] = ucwords(strtoupper($row['NamaBank']));
                }
                return $result;
            }
        }*/
}