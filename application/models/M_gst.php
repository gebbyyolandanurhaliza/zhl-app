<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class M_gst extends CI_Model {

    function get_gst() {
        $sql = $this->db->query('SELECT * FROM zhl_gen_tbl_mst_gst');
        if ($sql->num_rows() > 0) {
            $result[''] = 'Select';
            foreach ($sql->result_array() as $value) {
                $result[$value['gst_id']] = ucwords(strtoupper($value['gst_name']));
            }
            return $result;
        }
    }

    function hasil1($dari, $sampai, $gst) {
        $this->db->select('*');
        $this->db->where('gst_type <> ', '');
        $this->db->where('gst_value > ', '0');
        $this->db->where('Tanggal BETWEEN "' . $dari . '" and "' . $sampai . '"');
        if($gst == 'vendor'){
             $sql = $this->db->get('zhl_vw_acc_trn_jurnal');
         }else{
             $sql = $this->db->get('zhl_vw_acc_trn_jurnal_marketing');
         }
       
        if ($sql->num_rows() > 0) {
            foreach ($sql->result() as $data) {
                $hasil[] = $data;
            }
            return $hasil;
        }
    }

    function ambil_gst() {
        $this->db->select('*');
        $this->db->order_by('gst_value DESC');
        $sql_product = $this->db->get('zhl_gen_tbl_mst_gst');

        if ($sql_product->num_rows() > 0) {
            foreach ($sql_product->result() as $data) {
                $hasil[] = $data;
            }
            return $hasil;
        }
    }
    
    function total_gst($dari, $sampai, $gst){
        $blank = '';
        $this->db->select('gst_type, SUM(gst_value) as total_gst, SUM(Total) as total_amount');
        $this->db->where('gst_type <>', $blank);
        $this->db->group_by('gst_type');
        $this->db->where('Tanggal BETWEEN "' . $dari . '" and "' . $sampai . '"');
        if ($gst != "") {
            $this->db->where('gst_type', $gst);
        }
        $sql = $this->db->get('zhl_vw_acc_trn_jurnal');
        if ($sql->num_rows() > 0) {
            foreach ($sql->result() as $data) {
                $hasil[] = $data;
            }
            return $hasil;
        }
    }
    function call_gst_report($dari,$sampai,$gst){
        $sql = $this->db->query("call zhl_sp_acc_gst_report('$dari','$sampai','$gst')");

        //$sql = $this->db->query("CALL `sp_acc_rpt_gl_summary`('2016-06-23')");
        $res = $sql->result();
        $sql->next_result();
        $sql->free_result();
        return $res;
    }

    function call_gst_report_zht($dari,$sampai,$gst){
        // $sql = $this->db->query("call zht_sp_acc_gst_report('$dari','$sampai','$gst')");
        
        // ini fauzi yang ubah, kalau ada kesalahan bisa dikembalikan ke sp diatas. 
        $sql = $this->db->query("call zht_sp_ac_gst_report_2025('$dari','$sampai','$gst')");

        //$sql = $this->db->query("CALL `sp_acc_rpt_gl_summary`('2016-06-23')");
        $res = $sql->result();
        $sql->next_result();
        $sql->free_result();
        return $res;
    }
}
