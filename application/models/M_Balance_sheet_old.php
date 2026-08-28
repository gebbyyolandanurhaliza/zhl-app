<?php

class M_Balance_sheet extends CI_Model {

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
        $this->db->select('*');
        $sql_group = $this->db->get('zhl_acc_report_sub_group');
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

    function call_data($dari, $sampai) {
        $sql = $this->db->query("call zhl_sp_acc_trn_trialbalance_similar_p2('$dari', '$sampai')");
        $res = $sql->result();
        $sql->next_result();
        $sql->free_result();
        return $res;
    }

    function call_data2($dari, $sampai) {
        $sql = $this->db->query("SELECT IFNULL(SUM(Debet - Kredit),0) as retained FROM zhl_acc_tbl_trn_jurnal where Tanggal >= '2016/01/01' and  Tanggal < '$dari' and NoCOA in (select no_coa from zhl_acc_report_coa where id_group in (1,72,73,224,225))");
        $res = $sql->result();
        //$sql->next_result();
        //$sql->free_result();
        return $res;
    }

    function call_data3($dari, $sampai) {
        $sql = $this->db->query("SELECT IFNULL(SUM(Debet - Kredit),0) as current FROM zhl_acc_tbl_trn_jurnal where Tanggal between '2017/01/01' and  '$sampai' and NoCOA in (select no_coa from zhl_acc_report_coa where id_group in (1,72,73,224,225))");
 	      $res = $sql->result();
        //$sql->next_result();
        //$sql->free_result();
        return $res;
    }

    function call_data_detail($dari, $sampai) {
        $sql = $this->db->query("call zhl_sp_balacesheetdetail('$dari', '$sampai')");
        $res = $sql->result();
        $sql->next_result();
        $sql->free_result();
        return $res;
    }

}
