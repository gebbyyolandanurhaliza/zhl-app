<?php

defined('BASEPATH') or exit('No direct script access allowed');

class M_Monitoring_journal extends CI_Model
{

    function get_jenis_trans()
    {
        $sql = $this->db->query("SELECT * FROM zhl_acc_tbl_jenistrans");
        if ($sql->num_rows() > 0) {
            $result[''] = 'Select';
            foreach ($sql->result_array() as $value) {
                $result[$value['TransID']] = ucwords(strtoupper($value['TransName']));
            }
            return $result;
        }
    }

    function get_coa()
    {
        $sql = $this->db->query("SELECT * FROM zhl_acc_master_coa");
        if ($sql->num_rows() > 0) {
            $result[''] = 'Select';
            foreach ($sql->result_array() as $value) {
                $result[$value['NoCOA']] = ucwords(strtoupper($value['NoCOA'] . " - " . $value['AccountName']));
            }
            return $result;
        }
    }

    function hasil($dari, $sampai, $coa, $reference, $jenis)
    {
        $this->db->select('*');
        //$query = "(Debet != 0 OR Kredit != 0)";
        if (!empty($reference)) {
            $this->db->where('NoJurnal', $reference);
            $this->db->where('Tanggal BETWEEN "' . date('Y-m-d', strtotime($dari)) . '" and "' . date('Y-m-d', strtotime($sampai)) . '"');
        } else {
            $this->db->where('Tanggal BETWEEN "' . date('Y-m-d', strtotime($dari)) . '" and "' . date('Y-m-d', strtotime($sampai)) . '"');
        }

        //$this->db->where($query);
        if ($coa != "") {
            $this->db->like('NoCOA', $coa);
        }
        // if ($reference != "") {
        //     $this->db->LIKE('NoJurnal', $reference);
        // }
        if ($jenis == 'CO') {
            $this->db->where('jenis_trans = "CO" OR jenis_trans = "BI"');
        }  if ($jenis == 'BO') {
            $this->db->where('jenis_trans = "BO"');
        } 
        elseif ($jenis != "") {
            $this->db->like('jenis_trans', $jenis);
        }
        // $sql = $this->db->get('acc_tbl_trn_jurnal');
        $sql = $this->db->get('zhl_vw_acc_tbl_trn_jurnal');

        if ($sql->num_rows() > 0) {
            foreach ($sql->result() as $data) {
                $hasil[] = $data;
            }
            return $hasil;
        }
    }

    function select_journal($dari, $sampai)
    {
        //$this->db->select('*');
        //$this->db->where("(Debet != 0 OR Kredit != 0)");
        //$this->db->where('Tanggal >= "' . date('Y-m-d', strtotime($dari)) . '" and Tanggal <="' . date('Y-m-d', strtotime($sampai)) . '"');
        $sql = $this->db->query('select * from zhl_vw_acc_tbl_trn_jurnal where (Debet != 0 OR Kredit != 0) and Tanggal >= "' . date('Y-m-d', strtotime($dari)) . '" and Tanggal <= "' . date('Y-m-d', strtotime($sampai)) . '"');

        // $this->db->select('*');
        // $query = "(Debet != 0 OR Kredit != 0)";

        // $this->db->where('');
        // $this->db->where($query);
        // if ($coa != "") {
        //     $this->db->where('NoCOA', $coa);
        // }
        // if ($reference != "") {
        //     $this->db->where('NoJurnal', $reference);
        // }
        // if ($jenis != "") {
        //     $this->db->like('jenis_trans', $jenis);
        // }
        // // $sql = $this->db->get('acc_tbl_trn_jurnal');
        // $sql = $this->db->get('vw_acc_tbl_trn_jurnal');

        if ($sql->num_rows() > 0) {
            foreach ($sql->result() as $data) {
                $hasil[] = $data;
            }
            return $hasil;
        }
    }
}
