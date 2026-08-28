<?php

class M_Aged_Payable_Summary_zht extends CI_Model {

    var $mst_supplier = 'zht_pur_tbl_mst_supplier_tims';
    var $mst_currency = 'zhl_gen_tbl_mst_currency';

    function get_supplier() {
        $this->db->where('notactive', 0);
        $this->db->select('supplierid, suppliercompany');
        $this->db->from('zht_pur_tbl_mst_supplier_tims');
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

    function get_group_supp($dari, $sup, $currency) {
        $sql = $this->db->query("SELECT a.kode_sup,b.suppliercompany FROM zht_acc_tbl_trn_hutang as a JOIN zht_pur_tbl_mst_supplier_tims as b on a.kode_sup = b.supplierid LEFT JOIN
        (select NoInvoice,sum(Total) as Total from zht_acc_tbl_trn_appaymentdtl where realisasi_date <= '".$dari."' group by NoInvoice) 
        d on a.nofaktur=d.NoInvoice where (a.hutang - IFNULL(d.Total,0)) <> 0 and a.tanggal_invoice <= '".$dari."' and a.kode_sup like '%".$sup."%' and a.currency_id like '%".$currency."%' GROUP by a.kode_sup,b.suppliercompany");
        return $sql->result();
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

    function call_data($sup, $currency, $dari) {
        $sql = $this->db->query("call zhl_sp_acc_rpt_aged_payable_summary_tims('$sup', '$currency', '$dari')");
        //$sql = $this->db->query("call sp_acc_rpt_payable_aging('ALT', 'SGD', '2016-08-01', '2016-11-01')");
        //$sql = $this->db->query("CALL `sp_acc_rpt_payable_aging`('AIA', 'SGD', '2016-03-23')");
        $res = $sql->result();
        $sql->next_result();
        $sql->free_result();
        return $res;
    }

    


}
