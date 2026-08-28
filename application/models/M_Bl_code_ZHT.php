<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class M_Bl_code_ZHT extends CI_Model {

    function get_jenis_trans() {
        $sql = $this->db->query("SELECT * FROM zhl_acc_tbl_jenistrans WHERE menu='AR'");
        if ($sql->num_rows() > 0) {
            $result[''] = 'Select';
            foreach ($sql->result_array() as $value) {
                $result[$value['TransID']] = ucwords(strtoupper($value['TransName']));
            }
            return $result;
        }
    }
    function get_coa($company_id) {
        $sql = $this->db->query("SELECT * FROM zhl_vw_new_coa_dept_code where company_id= '$company_id'");
        if ($sql->num_rows() > 0) {
            $result[''] = 'Select';
            foreach ($sql->result_array() as $value) {
                $result[$value['NoCOA']] = ucwords(strtoupper($value['NoCOA'] . " - " . $value['AccountName']));
            }
            return $result;
        }
    }
  
function hasil($dari, $sampai) {
    $this->db->select('*');
    $this->db->from('bl_code_zht');

    $start = date('Y-m-d', strtotime($dari));
    $end   = date('Y-m-d', strtotime($sampai));

    // filter created_date ATAU tanggal
    $this->db->group_start()
        ->where("DATE(created_date) >=", $start)
        ->where("DATE(created_date) <=", $end)
    ->group_end();

    $this->db->or_group_start()
        ->where("DATE(tanggal) >=", $start)
        ->where("DATE(tanggal) <=", $end)
    ->group_end();

    $query = $this->db->get();
    return $query->num_rows() > 0 ? $query->result() : [];
}

function hasil_dua_tanggal($dari, $sampai) {
    $this->db->select('*');
    $this->db->from('bl_code_zht'); // tabel utama

    $this->db->group_start()
        ->where("DATE(tanggal) >=", $dari)
        ->where("DATE(tanggal) <=", $sampai)
    ->group_end();

    $this->db->or_group_start()
        ->where("DATE(created_date) >=", $dari)
        ->where("DATE(created_date) <=", $sampai)
    ->group_end();

    $query = $this->db->get();
    return $query->num_rows() > 0 ? $query->result() : [];
}



}

?>