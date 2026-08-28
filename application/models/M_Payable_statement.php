<?php

class M_Payable_statement extends CI_Model {

    var $mst_supplier = 'zhl_pur_tbl_mst_supplier';
    var $mst_currency = 'zhl_gen_tbl_mst_currency';

    function get_supplier() {
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

    function call_data_ps($sup, $curreny, $periode) {
        $sql = $this->db->query("call zhl_sp_acc_rpt_payable_aging_dtl('$sup', '$curreny', '$periode')");
        $res = $sql->result();
        $sql->next_result();
        $sql->free_result();
        return $res;
    }

    function call_data_agings($sup, $curreny, $periode) {
        $sql = $this->db->query("call zhl_sp_acc_rpt_payable_aging_dtl('$sup', '$curreny',  '$periode')");
        $res = $sql->result();
        $sql->next_result();
        $sql->free_result();
        return $res;
    }

    function get_mutation($sup, $curreny, $thn, $bulan) {
        $this->db->select('*');
        $this->db->where('kode_sup', $sup);
        $this->db->where('currency_id', $curreny);
        $this->db->where('YEAR(tanggal)', $thn);
        $this->db->where('MONTH(tanggal)', $bulan);
        $sql_product = $this->db->get('zhl_vw_acc_rpt_statement');

        if ($sql_product->num_rows() > 0) {
            foreach ($sql_product->result() as $data) {
                $hasil[] = $data;
            }
            return $hasil;
        }
    }
    
    function get_total($sup, $curreny, $thn, $bulan) {
        $this->db->select('SUM(hutang*rate_awal) as hutang, currency_id');
        $this->db->where('kode_sup', $sup);
        $this->db->where('currency_id', $curreny);
        $this->db->where('YEAR(tanggal)', $thn);
        $this->db->where('MONTH(tanggal)', $bulan);
        $sql_product = $this->db->get('zhl_vw_acc_rpt_statement');

        if ($sql_product->num_rows() > 0) {
            foreach ($sql_product->result() as $data) {
                $hasil[] = $data;
            }
            return $hasil;
        }
    }
    
    function get_data_header($id) {
        $this->db->select('*');
        $this->db->where('nofaktur', $id);
        $sql_product = $this->db->get('zhl_acc_tbl_trn_piutang');

        if ($sql_product->num_rows() > 0) {
            foreach ($sql_product->result() as $data) {
                $hasil[] = $data;
            }
            return $hasil;
        } else {
            $hasil[] = '';
        }
    }
    
    function get_data_footer($id) {
        $this->db->select('*');
        $this->db->where('NoJurnal', $id);
        $this->db->where_not_in('NoUrut', '0');
        $sql_product = $this->db->get('zhl_acc_tbl_trn_jurnal');

        if ($sql_product->num_rows() > 0) {
            foreach ($sql_product->result() as $data) {
                $hasil[] = $data;
            }
            return $hasil;
        }
    }
    
    function get_data_supplier($sup){
        $this->db->select('*');
        $this->db->where('supplierid', $sup);
         $sql_product = $this->db->get('zhl_pur_tbl_mst_supplier');

        if ($sql_product->num_rows() > 0) {
            foreach ($sql_product->result() as $data) {
                $hasil[] = $data;
            }
            return $hasil;
        }
    }

}
