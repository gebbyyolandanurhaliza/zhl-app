<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class M_Trial_balance extends CI_Model {

    var $mst_supplier = 'zhl_pur_tbl_mst_supplier';
    var $mst_currency = 'zhl_gen_tbl_mst_currency';

    function coa_number() {
        $this->db->select('NoCOA, AccountName');
        $this->db->from('zhl_acc_master_coa');
        $sql = $this->db->get();
        if ($sql->num_rows() > 0) {
            $result[''] = 'Select';
            foreach ($sql->result_array() as $row) {
                $result[$row['NoCOA']] = ucwords(strtolower($row['NoCOA']) . " | " . strtoupper($row['AccountName']));
            }
            return $result;
        } else {
            echo "Not data avaible";
        }
    }

    function select_group() {
        //select group first
        $this->db->select('GroupName, id_group');
        $sql_group = $this->db->get('zhl_acc_group_coa');
        if ($sql_group->num_rows() > 0) {
            foreach ($sql_group->result() as $value) {
                $result[] = $value;
            }
            return $result;
        }
    }

    function get_currency() {
        $sql_prov = $this->db->get($this->mst_currency);
        if ($sql_prov->num_rows() > 0) {
            $result[''] = 'Select';
            foreach ($sql_prov->result_array() as $row) {
                $result[$row['currency_id']] = ucwords(strtoupper($row['currency_id']));
            }
            return $result;
        } else {
            echo "Not data avaible";
        }
    }

    function call_data($p_dari, $p_sampai) {
        $sql = $this->db->query("call zhl_sp_acc_rpt_trial_balance('$p_dari', '$p_sampai')");
        $res = $sql->result();
        $sql->next_result();
        $sql->free_result();
        return $res;
    }

    function call_data_zht($p_dari, $p_sampai) {
        $sql = $this->db->query("call zht_sp_acc_rpt_trial_balance_final('$p_dari', '$p_sampai')");
        $res = $sql->result();
        $sql->next_result();
        $sql->free_result();
        return $res;
    }

    function call_data_zht_sgd($p_dari, $p_sampai) {
        $sql = $this->db->query("call zht_sp_acc_rpt_trial_balance_final_sgd('$p_dari', '$p_sampai')");
        $res = $sql->result();
        $sql->next_result();
        $sql->free_result();
        return $res;
    }

    function call_data_baruuuuuuuuuuuuuuuu($p_dari, $p_sampai) {
        $sql = $this->db->query("call zhl_sp_acc_rpt_trial_balance_final('$p_dari', '$p_sampai')");
        $res = $sql->result();
        $sql->next_result();
        $sql->free_result();
        return $res;
    }

    function call_trialbalance($periode) {
        $sql = $this->db->query("call zhl_sp_acc_rpt_trial_balance('$periode')");
        $res = $sql->result();
        $sql->next_result();
        $sql->free_result();
        return $res;
    }

}
