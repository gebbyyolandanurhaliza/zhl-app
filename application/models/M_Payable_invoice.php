<?php

class M_Payable_invoice extends CI_Model {

    var $mst_supplier = 'zhl_pur_tbl_mst_supplier';
    var $mst_currency = 'zhl_gen_tbl_mst_currency';

    function get_supplier() {
        $this->db->select('supplierid, suppliercompany');
        $this->db->from('zhl_pur_tbl_mst_supplier');
        $this->db->where('notactive', '0');
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

    function call_data($sup, $curreny, $tgl) {
        $sql = $this->db->query("call zhl_sp_acc_rpt_payable_invoice('$sup', '$curreny', '$tgl')");
        $res = $sql->result();
        $sql->next_result();
        $sql->free_result();
        return $res;
    }

    function get_supply($sup, $curreny, $tgl){
        $sql = $this->db->query("
                    SELECT a.kode_sup,c.suppliercompany
                    FROM zhl_acc_tbl_trn_hutang AS a INNER JOIN
                    zhl_pur_tbl_mst_supplier AS c on a.kode_sup=c.supplierid
                    WHERE MONTH(a.tanggal)=MONTH('".$tgl."') AND YEAR(a.tanggal)=YEAR('".$tgl."') and
                    a.currency_id LIKE '%".$curreny."%' AND
                    a.kode_sup LIKE '%".$sup."%' and a.jenis_trans not in ('PDP')
                    GROUP BY a.kode_sup,c.suppliercompany
                    ORDER BY c.suppliercompany
                ");
        return $sql->result();
    }

    // fungsi group supplier
    function get_group_supp($tgl, $sup, $currency) {
        $sql = $this->db->query("SELECT DISTINCT(a.kode_sup),b.suppliercompany,b.address,b.postalcode FROM zhl_acc_tbl_trn_hutang as a JOIN zhl_pur_tbl_mst_supplier as b on a.kode_sup = b.supplierid LEFT JOIN
        (select NoInvoice,sum(Total) as Total from zhl_acc_tbl_trn_appaymentdtl where realisasi_date <= '".$tgl."' group by NoInvoice) 
        d on a.nofaktur=d.NoInvoice where (a.hutang - IFNULL(d.Total,0)) <> 0 and a.tanggal_invoice <= '".$tgl."' and a.kode_sup like '%".$sup."%' and a.currency_id like '%".$currency."%' GROUP by a.kode_sup,b.suppliercompany,b.address,b.postalcode");
        return $sql->result();
    }
    
}
