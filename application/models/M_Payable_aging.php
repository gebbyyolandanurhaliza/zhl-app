<?php

class M_Payable_aging extends CI_Model {

    var $mst_supplier = 'zhl_pur_tbl_mst_supplier';
    var $mst_currency = 'zhl_gen_tbl_mst_currency';

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

    function get_supplier_zht()
    {
        $this->db->where('notactive', 0);
        $this->db->select('supplierid, suppliercompany');
        $this->db->from('zht_pur_tbl_mst_supplier_tims');
        $sql_prov = $this->db->get();
        if ($sql_prov->num_rows() > 0) {
            $result[''] = 'Select';
            foreach ($sql_prov->result_array() as $row) {
                $result[$row['supplierid']] = ucwords(strtoupper($row['suppliercompany']));
            }
            return $result;
        } else {
            echo "";
        }
    }

    function get_group_supp($dari, $sup, $currency) {
        $sql = $this->db->query("SELECT a.kode_sup,b.suppliercompany,b.address,b.postalcode FROM zhl_acc_tbl_trn_hutang as a JOIN zhl_pur_tbl_mst_supplier as b on a.kode_sup = b.supplierid LEFT JOIN
        (select NoInvoice,sum(Total) as Total from zhl_acc_tbl_trn_appaymentdtl where realisasi_date <= '".$dari."' group by NoInvoice) 
        d on a.nofaktur=d.NoInvoice where (a.hutang - IFNULL(d.Total,0)) <> 0 and a.tanggal_invoice <= '".$dari."' and a.kode_sup like '".$sup."%' and a.currency_id like '%".$currency."%' GROUP by a.kode_sup,b.suppliercompany,b.address,b.postalcode");
        return $sql->result();
    }
    
    
    function get_group_supp_zht($dari, $sup, $currency) {
        $sql = $this->db->query("SELECT a.kode_sup,b.suppliercompany,b.address,b.postalcode FROM zht_acc_tbl_trn_hutang as a JOIN zht_pur_tbl_mst_supplier_tims as b on a.kode_sup = b.supplierid LEFT JOIN
        (select NoInvoice,sum(Total) as Total from zht_acc_tbl_trn_appaymentdtl where realisasi_date <= '".$dari."' group by NoInvoice) 
        d on a.nofaktur=d.NoInvoice where (a.hutang - IFNULL(d.Total,0)) <> 0 and a.tanggal_invoice <= '".$dari."' and a.kode_sup like '".$sup."%' and a.currency_id like '%".$currency."%' GROUP by a.kode_sup,b.suppliercompany,b.address,b.postalcode");
        return $sql->result();
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
            echo "Not data avaible";
        }
    }

    function call_data_aging($sup, $currency, $dari) {
        $sql = $this->db->query("call zhl_sp_acc_rpt_payable_aging('$sup', '$currency', '$dari')");
        $res = $sql->result();
        $sql->next_result();
        $sql->free_result();
        return $res;
    }

    function call_data_aging_zht($sup, $currency, $dari) {
        $sql = $this->db->query("call zht_sp_acc_rpt_payable_aging('$sup', '$currency', '$dari')");
        $res = $sql->result();
        $sql->next_result();
        $sql->free_result();
        return $res;
    }


}
