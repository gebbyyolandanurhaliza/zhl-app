<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class M_Bl_code_ZHL extends CI_Model {

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
  
    function hasil($dari, $sampai, $dept_code = '') {
    $this->db->select('*');
    $this->db->from('bl_code');
    $this->db->where('created_date >=', date('Y-m-d', strtotime($dari)));
    $this->db->where('created_date <=', date('Y-m-d', strtotime($sampai)));

    if (!empty($dept_code)) {
        $this->db->where('dept_code', $dept_code);
    }

    $query = $this->db->get();
    return $query->num_rows() > 0 ? $query->result() : [];
}




public function getDeptCodes()
{
    $this->db->select('blCode, dept_code');
    $this->db->from('zhl_acc_tbl_trn_receivable_recognition');
    $query = $this->db->get();

    $result = [];
    if ($query->num_rows() > 0) {
        foreach ($query->result() as $row) {
            $result[$row->blCode] = $row->dept_code;
        }
    }
    return $result; 
}

public function get_total_sum_amount($blCode) {
    // 1. Ambil total amountPR_num * rate dari vw_amount_per_header
    $sql1 = "
        SELECT SUM(amountPR_num * rate) AS total_amountPR
        FROM (
            SELECT HeaderID, amountPR_num, rate
            FROM vw_amount_per_header
            WHERE blCode = ?
              AND NoCOA = '700071'
              AND dept_code = '002'
            GROUP BY HeaderID
        ) AS v
    ";
    $query1 = $this->db->query($sql1, array($blCode));
    $total_amountPR = 0;
    if ($query1 !== false) {
        $row1 = $query1->row();
        $total_amountPR = $row1 ? floatval($row1->total_amountPR) : 0;
    }

    // 2. Ambil total debit_usd dari cashbank_journal_detail
    $sql2 = "
        SELECT SUM(COALESCE(REPLACE(debit_usd, ',', ''),0) + 0) AS total_debit
        FROM zhl_fin_tbltrn_cashbank_journal_detail
        WHERE blCode = ?
          AND dept_code = '002'
          AND coa = '700071'
    ";
    $query2 = $this->db->query($sql2, array($blCode));
    $total_debit = 0;
    if ($query2 !== false) {
        $row2 = $query2->row();
        $total_debit = $row2 ? floatval($row2->total_debit) : 0;
    }

    // 3. Tampilkan data yang ada saja (tetap dijumlahkan jika dua-duanya ada)
    if ($total_amountPR && $total_debit) {
        // Dua-duanya ada, jumlahkan
        return $total_amountPR + $total_debit;
    } elseif ($total_amountPR) {
        // Hanya amountPR_num yang ada
        return $total_amountPR;
    } elseif ($total_debit) {
        // Hanya debit yang ada
        return $total_debit;
    } else {
        // Tidak ada dua-duanya
        return 0;
    }
}

public function get_total_sum_amount_a($blCode) {
    // 1. Ambil total amountPR_num * rate dari vw_amount_per_header
    $sql1 = "
        SELECT SUM(amountPR_num * rate) AS total_amountPR
        FROM (
            SELECT HeaderID, amountPR_num, rate
            FROM vw_amount_per_header
            WHERE blCode = ?
              AND NoCOA = '700071'
              AND dept_code = '003'
            GROUP BY HeaderID
        ) AS v
    ";
    $query1 = $this->db->query($sql1, array($blCode));
    $total_amountPR = 0;
    if ($query1 !== false) {
        $row1 = $query1->row();
        $total_amountPR = $row1 ? floatval($row1->total_amountPR) : 0;
    }

    // 2. Ambil total debit_usd dari cashbank_journal_detail
    $sql2 = "
        SELECT SUM(COALESCE(REPLACE(debit_usd, ',', ''),0) + 0) AS total_debit
        FROM zhl_fin_tbltrn_cashbank_journal_detail
        WHERE blCode = ?
          AND dept_code = '003'
          AND coa = '700071'
    ";
    $query2 = $this->db->query($sql2, array($blCode));
    $total_debit = 0;
    if ($query2 !== false) {
        $row2 = $query2->row();
        $total_debit = $row2 ? floatval($row2->total_debit) : 0;
    }

    // 3. Tampilkan data yang ada saja (tetap dijumlahkan jika dua-duanya ada)
    if ($total_amountPR && $total_debit) {
        // Dua-duanya ada, jumlahkan
        return $total_amountPR + $total_debit;
    } elseif ($total_amountPR) {
        // Hanya amountPR_num yang ada
        return $total_amountPR;
    } elseif ($total_debit) {
        // Hanya debit yang ada
        return $total_debit;
    } else {
        // Tidak ada dua-duanya
        return 0;
    }
}

}

?>