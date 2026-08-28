<?php

class M_Aged_Receivable_Summary extends CI_Model {

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

    function get_group_supp($dari, $sup, $currency) {
        $sql = $this->db->query("SELECT a.`kode_sup`, b.`customer_name` AS `suppliercompany` FROM `zhl_acc_tbl_trn_piutang` as a INNER JOIN `zhl_mar_tblmst_customer` as b on a.`kode_sup`= b.`customer_code` LEFT JOIN (select NoInvoice,sum(Total) as Total from zhl_acc_tbl_trn_arpaymentdtl where realisasi_date <= '".$dari."' group by NoInvoice) 
        c on a.nofaktur=c.NoInvoice where (a.piutang - IFNULL(c.Total,0)) <> 0 and a.tanggal_invoice <= '".$dari."' and a.`kode_sup` like '%".$sup."%' and a.currency_id like '%".$currency."%' GROUP by a.kode_sup, b.`customer_name`");
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

    function call_data($sup, $currency, $periode) {
        $sql = $this->db->query("call zhl_sp_acc_rpt_aged_receivable_summary('$sup', '$currency', '$periode')");
        $res = $sql->result();
        $sql->next_result();
        $sql->free_result();
        return $res;
    }

    


}
