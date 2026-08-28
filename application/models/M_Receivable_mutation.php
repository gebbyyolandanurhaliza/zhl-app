<?php

class M_Receivable_mutation extends CI_Model {

    var $mst_supplier = 'zhl_pur_tbl_mst_supplier';
    var $mst_currency = 'zhl_gen_tbl_mst_currency';

    function get_customer(){
        $this->db->select('customer_id, customer_code, customer_name');
        $this->db->from('zhl_mar_tblmst_customer');
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

    function get_group_supp($dari, $sup) {
       $d = explode("-", $dari);
        $thn_1 = $d[0];
        $bln_1 = $d[1];
        
        // $r = explode("-", $sampai);
        // $thn_2 = $r[0];
        // $bln_2 = $r[1];
        
        $sql = $this->db->query("SELECT a.`kode_sup`,  a.`tanggal`, b.`customer_name` AS `suppliercompany` FROM `zhl_acc_tbl_trn_piutang` as a INNER JOIN `zhl_mar_tblmst_customer` as b on a.`kode_sup`= b.`customer_code` where  MONTH(a.`tanggal`) <= $bln_1 and YEAR(a.`tanggal`)  <= $thn_1 and a.`kode_sup` like '%$sup%' GROUP by a.kode_sup");
        return $sql->result();
    }

    function get_supplier() {
        $this->db->where('notactive', 0);
        $this->db->select('supplierid, suppliercompany');
        $this->db->from('zhl_pur_tbl_mst_supplier');
        $sql = $this->db->get();
        if ($sql->num_rows() > 0) {
            $result[''] = 'Select';
            foreach ($sql->result_array() as $row) {
                $result[$row['supplierid']] = ucwords(strtoupper($row['suppliercompany']));
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
    //     $sql = $this->db->query("call sp_acc_rpt_receivable_mutation('$sup', '$curreny', '$tgl')");
    //     $res = $sql->result();
    //     $sql->next_result();
    //     $sql->free_result();
    //     return $res;
    // }

    // function call_data($cust, $curreny) {


    //     $this->db->select('*');
    //     if(!empty($cust) && !empty($curreny)){
    //         $this->db->where("kode_sup like '$cust' and currency_id like '$curreny'");
    //     }elseif(empty($cust) && !empty($curreny)){
    //         $this->db->where("currency_id like '$curreny' ");
    //     }elseif(!empty($cust) && empty($curreny)){
    //         $this->db->where("kode_sup like '$cust'");
    //     }else{

    //     }

        
    //     $sql_product = $this->db->get('acc_vw_outstanding_receivable');
    //     if ($sql_product->num_rows() > 0) {
    //         foreach ($sql_product->result() as $data) {
    //             $hasil[] = $data;
    //         }
    //         return $hasil;
    //     }
    // }
    function call_data($sup, $currency, $periode) {
        $sql = $this->db->query("call zhl_sp_acc_rpt_aged_receivable_summary('$sup', '$currency', '$periode')");
        //$sql = $this->db->query("call sp_acc_rpt_payable_aging('ALT', 'SGD', '2016-08-01', '2016-11-01')");
        //$sql = $this->db->query("CALL `sp_acc_rpt_payable_aging`('AIA', 'SGD', '2016-03-23')");
        $res = $sql->result();
        $sql->next_result();
        $sql->free_result();
        return $res;
    }
}
