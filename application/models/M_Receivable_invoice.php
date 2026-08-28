<?php

class M_Receivable_invoice extends CI_Model {

    var $mst_supplier = 'zhl_pur_tbl_mst_supplier';
    var $mst_currency = 'zhl_gen_tbl_mst_currency';

    function get_customer() {
        $this->db->select('customer_id, customer_code, customer_name');
        $this->db->from('zhl_mar_tblmst_customer');
        $sql = $this->db->get();
        if ($sql->num_rows() > 0) {
            $result[''] = "Select";
            foreach ($sql->result_array() as $row) {
                $result[$row['customer_code']] = ucwords(strtoupper($row['customer_name']));
            }
            return $result;
        } else {
            echo "";
        }
    }
    function tampil_customer($data){
        $this->db->where('customer_code', $data);
        $this->db->where('status_customer','1');
        $result=  $this->db->get('zhl_mar_tblmst_customer');
        return $result->result();
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
            echo "";
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
    // function call_data($sup, $curreny, $tgl) {
    //     $sql = $this->db->query("call zhl_sp_acc_rpt_receivable_invoice('$sup', '$curreny', '$tgl')");
    //     $res = $sql->result();
    //     $sql->next_result();
    //     $sql->free_result();
    //     return $res;
    // }
      function call_data($sup, $curreny, $p_dari, $p_sampai) {
        $sql = $this->db->query("call zhl_sp_acc_rpt_receivable_invoice1('$sup', '$curreny', '$p_dari', '$p_sampai')");
        $res = $sql->result();
        $sql->next_result();
        $sql->free_result();
        return $res;
    }
    
    
    function get_data_rrg($id) {
        $this->db->select('*');
        $this->db->where('HeaderID', $id);
        $sql_product = $this->db->get('zhl_acc_tbl_trn_receivable_recognition');

        if ($sql_product->num_rows() > 0) {
            foreach ($sql_product->result() as $data) {
                $hasil[] = $data;
            }
            return $hasil;
        } else {
            $hasil[] = '';
        }
    }
    
    function get_data_ccn($id) {
        $this->db->select('*');
        $this->db->where('NoJurnal', $id);
        $this->db->where('NoUrut', '1');
        $sql_product = $this->db->get('zhl_acc_tbl_trn_jurnal');

        if ($sql_product->num_rows() > 0) {
            foreach ($sql_product->result() as $data) {
                $hasil[] = $data;
            }
            return $hasil;
        } else {
            $hasil[] = '';
        }
    }
    
    
    function get_data_umum($id) {
        $this->db->select('Total_usd, Uraian');
        $this->db->where('nofaktur', $id);
        $this->db->group_by('Total_usd');
        $this->db->order_by('Uraian', 'ASC');
        $sql_product = $this->db->get('zhl_vw_acc_rpt_receivable_invoice');

        if ($sql_product->num_rows() > 0) {
            foreach ($sql_product->result() as $data) {
                $hasil[] = $data;
            }
            return $hasil;
        } else {
            $hasil[] = '';
        }
    }


    function get_supply($sup, $curreny, $tgl){
        $sql = $this->db->query("
            SELECT a.kode_sup,c.customer_code,c.customer_name,c.customer_address
                FROM zhl_acc_tbl_trn_piutang AS a INNER JOIN
                     zhl_mar_tblmst_customer AS c on a.kode_sup=c.customer_code
                WHERE MONTH(a.tanggal)=MONTH('".$tgl."') AND YEAR(a.tanggal)=YEAR('".$tgl."') and 
                    a.currency_id LIKE '%".$curreny."%' AND
                    a.kode_sup LIKE '%".$sup."%' and a.jenis_trans not in ('RDP')
                GROUP by a.kode_sup");
        return $sql->result();
    }
    
}
