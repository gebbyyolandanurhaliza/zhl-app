<?php

class m_receivable_aging extends CI_Model {

    var $mst_supplier = 'pur_tbl_mst_supplier';
    var $mst_currency = 'gen_tbl_mst_currency';

    function get_customer(){
        $this->db->select('customer_id, customer_code, customer_name');
        $this->db->from('mar_tblmst_customer');
       $sql = $this->db->get();
        if ($sql->num_rows() > 0) {
            $result[''] = "Select";
            foreach ($sql->result_array() as $row) {
                $result[$row['customer_code']] = ucwords(strtolower($row['customer_name']));
            }
            return $result;
        }
        else{
            echo "";
        }
    }
    
    function get_currency(){
        $sql_prov = $this->db->get($this->mst_currency);
        if ($sql_prov->num_rows() > 0) {
            $result[''] = "Select";
            foreach ($sql_prov->result_array() as $row) {
                $result[$row['currency_id']] = ucwords(strtoupper($row['currency_id']));
            }
            return $result;
        }
        else{
            echo "";
        }
    }
    
    function get_group_supp($dari, $sampai, $sup) {
        $d = explode("-", $dari);
        $thn_1 = $d[0];
        $bln_1 = $d[1];
        
        $r = explode("-", $sampai);
        $thn_2 = $r[0];
        $bln_2 = $r[1];
        
        $sql = $this->db->query("SELECT a.`kode_sup`,  a.`tanggal`, b.`customer_name` AS `suppliercompany` FROM `acc_tbl_trn_piutang` as a INNER JOIN `mar_tblmst_customer` as b on a.`kode_sup`= b.`customer_code` where  MONTH(a.`tanggal`) BETWEEN $bln_1 and $bln_2 and YEAR(a.`tanggal`)  BETWEEN $thn_1 and $thn_2 and a.`kode_sup` like '%$sup%' GROUP by a.kode_sup");
        return $sql->result();
    }
    
    function call_data_aging($sup, $curreny, $p_dari, $p_sampai) {
        $sql = $this->db->query("call sp_acc_rpt_receivable_aging('$sup', '$curreny', '$p_dari', '$p_sampai')");
        //$sql = $this->db->query("CALL `sp_acc_rpt_payable_aging`('AIA', 'SGD', '2016-03-23')");
        $res = $sql->result();
        $sql->next_result();
        $sql->free_result();
        return $res;
    }

}
