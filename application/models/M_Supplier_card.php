<?php

class M_Supplier_card extends CI_Model {

    var $mst_supplier = 'zhl_pur_tbl_mst_supplier';
    var $mst_currency = 'zhl_gen_tbl_mst_currency';

    function get_supplier() {
        $this->db->select('supplierid, suppliercompany, nocoa');
        $this->db->from('zhl_pur_vw_mst_supplier');
        $this->db->where('notactive', '0');
        $sql = $this->db->get();
        if ($sql->num_rows() > 0) {
            $result[''] = 'Select';
            foreach ($sql->result_array() as $row) {
                $result[$row['supplierid'] ."|". $row['nocoa']] = ucwords(strtoupper($row['suppliercompany']));
            }
            return $result;
        } else {
            echo "Not data avaible";
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

    function call_data($sup,$cur, $from,$to, $coa) {
        $sql = $this->db->query("call zhl_sp_acc_rpt_vendor_card_test('$sup','$cur','$from','$to', '$coa')");
        $res = $sql->result();
        $sql->next_result();
        $sql->free_result();
        return $res;
    }

    function get_supp($sup){
        $query = $this->db->query("select suppliercompany from zhl_pur_vw_mst_supplier where supplierid = '".$sup."'");
        return $query->row();
    }
}
