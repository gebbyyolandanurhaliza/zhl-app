<?php

class M_Customer_card extends CI_Model {

    var $mst_supplier = 'zhl_pur_tbl_mst_supplier';
    var $mst_currency = 'zhl_gen_tbl_mst_currency';

   function get_customer() {
        $this->db->select('*');
        $this->db->from('zhl_mar_vw_mst_customer_coa');
        $sql = $this->db->get();
        if ($sql->num_rows() > 0) {
            $result[''] = "Select";
            foreach ($sql->result_array() as $row) {
                $result[$row['customer_code'] . "|" . $row['coa']] = ucwords(strtolower($row['customer_name']));
            }
            return $result;
        } else {
            echo "";
        }
    }
    function get_currency() {
        $this->db->where('not_active', 0);
        $sql_prov = $this->db->get($this->mst_currency);
        if ($sql_prov->num_rows() > 0) {
            $result[''] = 'Select';
            foreach ($sql_prov->result_array() as $row) {
                $result[$row['currency_id']] = ucwords(strtoupper($row['currency_id']));
            }
            return $result;
        } else {
            echo "";
        }
    }

    function call_data($sup,$cur, $from,$to, $coa) {
        $sql = $this->db->query("call zhl_sp_acc_rpt_customer_card('$sup', '$cur', '$from','$to', '$coa')");
        $res = $sql->result();
        $sql->next_result();
        $sql->free_result();
        return $res;
    }

    function call_data2($sup,$cur, $from,$to, $coa) {
        $sql = $this->db->query("call zhl_sp_acc_rpt_cutomer_card_new('$sup', '$cur', '$from','$to', '$coa')");
        $res = $sql->result();
        $sql->next_result();
        $sql->free_result();
        return $res;
    }

    function get_cust($id){
        $this->db->select('customer_name');
        $this->db->where('customer_code',$id);
        $sql = $this->db->get('zhl_mar_vw_mst_customer_coa');

        return $sql->row();
    }
}
