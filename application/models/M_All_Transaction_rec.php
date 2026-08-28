<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class M_All_Transaction_rec extends CI_Model {

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

    // function get_coa() {
    //     $sql = $this->db->query("SELECT * FROM zhl_acc_master_coa");
    //     if ($sql->num_rows() > 0) {
    //         $result[''] = 'Select';
    //         foreach ($sql->result_array() as $value) {
    //             $result[$value['NoCOA']] = ucwords(strtoupper($value['NoCOA'] . " - " . $value['AccountName']));
    //         }
    //         return $result;
    //     }
    // }

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

    // tambahan baru
    function hasil_vendor($dari, $sampai, $jenis) {
        $this->db->select('DISTINCT(kode_sup), namacustomer, address');
        $this->db->where('tanggal between "' . date('Y-m-d', strtotime($dari)) . '" and "' . date('Y-m-d', strtotime($sampai)) . '"');
        $this->db->where_not_in('jenis_trans','RDP');
        $this->db->where('jenis_trans like "%'.$jenis.'%"');
        $sql = $this->db->get('zhl_vw_acc_tbl_trn_piutang');

        if ($sql->num_rows() > 0) {
            foreach ($sql->result() as $data) {
                $hasil[] = $data;
            }
            return $hasil;
        }
    }

    function hasil_vendor_zht($dari, $sampai, $jenis) {
        $this->db->select('DISTINCT(kode_sup), namacustomer, address');
        $this->db->where('tanggal between "' . date('Y-m-d', strtotime($dari)) . '" and "' . date('Y-m-d', strtotime($sampai)) . '"');
        $this->db->where_not_in('jenis_trans','RDP');
        $this->db->where('jenis_trans like "%'.$jenis.'%"');
        $sql = $this->db->get('zhl_vw_acc_tbl_trn_piutang_tims');

        if ($sql->num_rows() > 0) {
            foreach ($sql->result() as $data) {
                $hasil[] = $data;
            }
            return $hasil;
        }
    }



    // function hasil_zht($dari, $sampai, $jenis) {
    //     $this->db->select('*');
    //     $this->db->where('tanggal between "' . date('Y-m-d', strtotime($dari)) . '" and "' . date('Y-m-d', strtotime($sampai)) . '"');
    //     $this->db->where_not_in('jenis_trans','RDP');
    //     $this->db->where('jenis_trans like "%'.$jenis.'%"');
    //     $sql = $this->db->get('zhl_vw_acc_tbl_trn_piutang_tims');

    //     if ($sql->num_rows() > 0) {
    //         foreach ($sql->result() as $data) {
    //             $hasil[] = $data;
    //         }
    //         return $hasil;
    //     }
    // }

    function hasil_zht($dari, $sampai, $jenis, $orderby = 'nofaktur', $orderdir = 'asc') {
    $this->db->select('*');
    $this->db->from('zhl_vw_acc_tbl_trn_piutang_tims');
    $this->db->where('tanggal >=', date('Y-m-d', strtotime($dari)));
    $this->db->where('tanggal <=', date('Y-m-d', strtotime($sampai)));
    $this->db->where('jenis_trans !=', 'RDP');

    if (!empty($jenis)) {
        $this->db->like('jenis_trans', $jenis);
    }

    // Jika sort berdasarkan nofaktur, urutkan numerik bagian terakhir
    if ($orderby == 'nofaktur') {
        $this->db->order_by('CAST(SUBSTRING_INDEX(nofaktur, "/", -1) AS UNSIGNED)', $orderdir, false);
    } else {
        $this->db->order_by($orderby, $orderdir);
    }

    $query = $this->db->get();
    return $query->num_rows() > 0 ? $query->result() : [];
}



    function hasil($dari, $sampai, $jenis, $orderby = 'tanggal', $orderdir = 'asc') {
    $this->db->select('*');
    $this->db->from('zhl_vw_acc_tbl_trn_piutang');
    $this->db->where('tanggal >=', date('Y-m-d', strtotime($dari)));
    $this->db->where('tanggal <=', date('Y-m-d', strtotime($sampai)));
    $this->db->where_not_in('jenis_trans', 'RDP');

    if (!empty($jenis)) {
        $this->db->like('jenis_trans', $jenis);
    }

    if ($orderby == 'nofaktur') {
        // Urutkan berdasarkan angka setelah ZH
        $this->db->order_by('CAST(SUBSTRING_INDEX(SUBSTRING_INDEX(nofaktur, "/", 1), "ZH", -1) AS UNSIGNED)', $orderdir, false);
    } else {
        $this->db->order_by($orderby, $orderdir);
    }

    $query = $this->db->get();
    return $query->num_rows() > 0 ? $query->result() : [];
}


    function hasil_vendor_2($dari, $sampai, $jenis) {
        $this->db->select("DISTINCT(kode_sup),namacustomer, REPLACE(address,'<br />',' ') as addres");
        $this->db->where('tanggal between "' . date('Y-m-d', strtotime($dari)) . '" and "' . date('Y-m-d', strtotime($sampai)) . '"');
        $this->db->where_not_in('jenis_trans','RDP');
        $this->db->where('jenis_trans like "%'.$jenis.'%"');
        $sql = $this->db->get('zhl_vw_acc_tbl_trn_piutang');

        if ($sql->num_rows() > 0) {
            foreach ($sql->result() as $data) {
                $hasil[] = $data;
            }
            return $hasil;
        }
    }

    function hasil_2($dari, $sampai, $jenis, $kode_sup) {
        $this->db->select('*');
        $this->db->where('tanggal between "' . date('Y-m-d', strtotime($dari)) . '" and "' . date('Y-m-d', strtotime($sampai)) . '"');
        $this->db->where('kode_sup',$kode_sup);
        $this->db->where_not_in('jenis_trans','RDP');
        $this->db->where('jenis_trans like "%'.$jenis.'%"');
        $sql = $this->db->get('zhl_vw_acc_tbl_trn_piutang');

        if ($sql->num_rows() > 0) {
            foreach ($sql->result() as $data) {
                $hasil[] = $data;
            }
            return $hasil;
        }
    }

}

?>