<?php

/**
 * Created by PhpStorm.
 * User: rezai
 * Date: 4/21/2017
 * Time: 4:10 PM
 */
class M_Kas_Kecil extends CI_Model
{
    var $tbl_rekening = 'zhl_kk_tbl_transaksi';

    function insertTransaksiSetoran($data) {
        $this->db->insert($this->tbl_rekening, $data);
    }

    function insertTransaksiPencairan($data) {
        $this->db->insert($this->tbl_rekening, $data);
    }

    function insertTransaksiTransfer($data) {
        $this->db->insert($this->tbl_rekening, $data);
    }
    function r_setoran(){
        $this->db->select('*');
        $this->db->where('IDType','STR');
        $this->db->order_by('NORecord');
        $sql_product = $this->db->get('vw_record_transaksi');
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

    function r_pencairan(){
        $this->db->select('*');
        $this->db->where('IDType','PNC');
        $this->db->order_by('NORecord');
        $sql_product = $this->db->get('vw_record_transaksi');
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

    function r_transfer(){
        $this->db->select('IDTrans,Tanggal,Currency,Currency_Rate,Amount');
        $this->db->where('IDType','TRF');
        $this->db->order_by('IDTrans');
        $this->db->group_by('IDTrans');
        $sql_product = $this->db->get('kk_tbl_transaksi');
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

    function get_record($id){
        $this->db->select('*');
        $this->db->where('NORecord',$id);

        $sql_product = $this->db->get('vw_record_transaksi');
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

    function call_data($rek, $from,$to) {
        $sql = $this->db->query("call sp_record_rek2('$rek','$from','$to')");
        $res = $sql->result();
        $sql->next_result();
        $sql->free_result();
        return $res;
    }
}