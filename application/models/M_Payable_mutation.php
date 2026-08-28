<?php

class M_Payable_mutation extends CI_Model {

    var $mst_supplier = 'zhl_pur_tbl_mst_supplier';
    var $mst_currency = 'zhl_gen_tbl_mst_currency';

    function get_supplier() {
        $this->db->select('supplierid, suppliercompany');
        $this->db->from('zhl_pur_tbl_mst_supplier');
        $sql = $this->db->get();
        if ($sql->num_rows() > 0) {
            $result[''] = 'Select';
            foreach ($sql->result_array() as $row) {
                $result[$row['supplierid']] = ucwords(strtolower($row['suppliercompany']));
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

    // function call_data($sup, $curreny, $tgl) {
    //     $sql = $this->db->query("call sp_acc_rpt_payable_mutation('$sup', '$curreny', '$tgl')");
    //     $res = $sql->result();
    //     $sql->next_result();
    //     $sql->free_result();
    //     return $res;
    // }

    function call_data($sup, $curreny) {


        $this->db->select('*');
        if(!empty($sup) && !empty($curreny)){
            $this->db->where("kode_sup like '$sup' and currency_id like '$curreny'");
        }elseif(empty($sup) && !empty($curreny)){
            $this->db->where("currency_id like '$curreny' ");
        }elseif(!empty($sup) && empty($curreny)){
            $this->db->where("kode_sup like '$sup'");
        }else{

        }

        
        $sql_product = $this->db->get('zhl_acc_vw_outstanding_payable');
        if ($sql_product->num_rows() > 0) {
            foreach ($sql_product->result() as $data) {
                $hasil[] = $data;
            }
            return $hasil;
        }
    }
}
