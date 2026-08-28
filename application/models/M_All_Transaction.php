<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class M_All_Transaction extends CI_Model {

    function get_jenis_trans() {
        $sql = $this->db->query("SELECT * FROM zhl_acc_tbl_jenistrans");
        if ($sql->num_rows() > 0) {
            $result[''] = 'Select';
            foreach ($sql->result_array() as $value) {
                $result[$value['TransID']] = ucwords(strtoupper($value['TransName']));
            }
            return $result;
        }
    }

    function get_coa() {
        $sql = $this->db->query("SELECT * FROM zhl_acc_master_coa");
        if ($sql->num_rows() > 0) {
            $result[''] = 'Select';
            foreach ($sql->result_array() as $value) {
                $result[$value['NoCOA']] = ucwords(strtoupper($value['NoCOA'] . " - " . $value['AccountName']));
            }
            return $result;
        }
    }

    function hasil_vendor($dari, $sampai, $jenis) {
        $this->db->select('DISTINCT(kode_sup),namavendor, address');
        $this->db->where('tanggal between "' . date('Y-m-d', strtotime($dari)) . '" and "' . date('Y-m-d', strtotime($sampai)) . '"');
        $this->db->where_not_in('jenis_trans','PDP');
        $this->db->where('jenis_trans like "%'.$jenis.'%"');
        $sql = $this->db->get('zhl_vw_acc_tbl_trn_hutang');

        if ($sql->num_rows() > 0) {
            foreach ($sql->result() as $data) {
                $hasil[] = $data;
            }
            return $hasil;
        }
    }

    function hasil($dari, $sampai, $jenis) {
        $this->db->select('*');
        $this->db->where('tanggal between "' . date('Y-m-d', strtotime($dari)) . '" and "' . date('Y-m-d', strtotime($sampai)) . '"');
        $this->db->where_not_in('jenis_trans','PDP');
        $this->db->where('jenis_trans like "%'.$jenis.'%"');
        $sql = $this->db->get('zhl_vw_acc_tbl_trn_hutang');

        if ($sql->num_rows() > 0) {
            foreach ($sql->result() as $data) {
                $hasil[] = $data;
            }
            return $hasil;
        }
    }
    
    function select_journal($dari, $sampai,$coa, $reference, $jenis) {
        $this->db->select('*');
        $this->db->where('Tanggal >= "' . date('Y-m-d', strtotime($dari)) . '" and Tanggal <="' . date('Y-m-d', strtotime($sampai)) . '"');
        if ($coa != "") {
            $this->db->where('NoCOA', $coa);
        }
        if ($reference != "") {
            $this->db->where('NoJurnal', $reference);
        }
        if ($jenis != "") {
            $this->db->like('jenis_trans', $jenis);
        }
        $this->db->where("(Debet != 0 OR Kredit != 0)");
        // $sql = $this->db->get('acc_tbl_trn_jurnal');
        $sql = $this->db->get('zhl_vw_acc_tbl_trn_jurnal');

        if ($sql->num_rows() > 0) {
            foreach ($sql->result() as $data) {
                $hasil[] = $data;
            }
            return $hasil;
        }
    }

}

?>