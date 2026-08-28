<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class M_sales_journal extends CI_Model {

    public function get_list() {
        $this->db->select('*');
        $this->db->where('jenis_trans', 'SIJC');
        $sql_product = $this->db->get('zhl_vw_acc_tbl_trn_piutang');

        if ($sql_product->num_rows() > 0) {
            foreach ($sql_product->result() as $data) {
                $hasil[] = $data;
            }
            return $hasil;
        }
    }

    function get_customer() {
        $this->db->where('group_customer ', 0);
        $sql = $this->db->get('zhl_mar_tblmst_customer');
        if ($sql->num_rows() > 0) {
            $result[''] = 'select';
            foreach ($sql->result_array() as $row) {
                $result[$row['customer_code']] = ucwords(strtoupper($row['customer_company_name']));
            }
            return $result;
        } else {
            echo "Not data avaible";
        }
    }

    function tampil_item_jurnal($id) {
        $this->db->select('*');
        $this->db->where('contract_no', $id);
        //$this->db->where('currency', $ide);
        $sql = $this->db->get('zhl_mar_vw_trn_sales_contract');
        if ($sql->num_rows() > 0) {
            foreach ($sql->result() as $data) {
                $hasil[] = $data;
            }
            return $hasil;
        }
    }
    
    function tampil_header_jurnal(){
        $sql = $this->db->query('SELECT DISTINCT contract_no, contract_date, supplier_id, customer_code, customer_name FROM `zhl_mar_vw_trn_sales_contract`');
        if ($sql->num_rows() > 0) {
            foreach ($sql->result() as $data) {
                $hasil[] = $data;
            }
            return $hasil;
        }
    }
    function get_data_sales($id) {
         $this->db->select('grand_total as total_sales, customer_code, rate_usd, contract_no');
        $this->db->where('contract_no', $id);
        $sql = $this->db->get('zhl_mar_vw_trn_sales_contract');
        if ($sql->num_rows() > 0) {
            foreach ($sql->result() as $data) {
                $hasil[] = $data;
            }
            return $hasil;
        }
    }
    
    function get_data_dp($id){
        $this->db->select('*');
        $this->db->where('contract_no', $id);
        $sql = $this->db->get('zhl_vw_acc_uang_muka_mar');
        if ($sql->num_rows() > 0) {
            foreach ($sql->result() as $data) {
                $hasil[] = $data;
            }
            return $hasil;
        }
    }
    
    function get_data_item($id) {
         $this->db->select('*');
        $this->db->where('contract_no', $id);
        $sql = $this->db->get('zhl_mar_vw_trn_sales_contract');
        if ($sql->num_rows() > 0) {
            foreach ($sql->result() as $data) {
                $hasil[] = $data;
            }
            return $hasil;
        }
    }

    function simpan_header($data) {
        $this->db->insert('zhl_acc_tbl_trn_piutang', $data);
    }

    function update_header($id, $data) {
        $this->db->where('nofaktur', $id);
        $this->db->update('zhl_acc_tbl_trn_piutang', $data);
    }

    function simpan_bulanan($data) {
        $this->db->insert('zhl_acc_tbl_trn_piutang_bulanan', $data);
    }

    function update_bulanan($id, $data) {
        $this->db->where('nofaktur', $id);
        $this->db->update('zhl_acc_tbl_trn_piutang_bulanan', $data);
    }

    function simpan_detail($data) {
        $this->db->insert('zhl_acc_tbl_trn_jurnal', $data);
    }

    function update_detail($detailid, $data) {
        $this->db->where('HeaderID', $detailid);
        $this->db->update('zhl_acc_tbl_trn_jurnal', $data);
    }

    function simpan_item($data) {
        $this->db->insert('zhl_acc_tbl_trn_sim1_dtl', $data);
    }

    function delete_item($noinvo) {
        $this->db->where('HeaderID', $noinvo);
        $this->db->delete('zhl_acc_tbl_trn_sim1_dtl');
    }

    function delete_detail($noinvo) {
        $this->db->where('NoJurnal', $noinvo);
        $this->db->delete('zhl_acc_tbl_trn_jurnal');
    }

    function get_data_header($id) {
        $this->db->select('*');
        $this->db->where('nofaktur', $id);
        $sql = $this->db->get('zhl_vw_acc_tbl_trn_piutang');

        if ($sql->num_rows() > 0) {
            foreach ($sql->result() as $key) {
                $hasil[] = $key;
            }
            return $hasil;
        }
    }

    function get_data_footer($id) {
        $this->db->select('*');
        $this->db->where('NoJurnal', $id);
        $this->db->where_not_in('NoUrut', '0');
        $sql = $this->db->get('zhl_acc_tbl_trn_jurnal');
        if ($sql->num_rows() > 0) {
            foreach ($sql->result() as $data) {
                $hasil[] = $data;
            }
            return $hasil;
        }
    }

    

    function update_sim($id, $id2, $data) {
        $this->db->where("contract_hdr_id", $id);
        $this->db->where("product_id", $id2);
        $this->db->update("zhl_mar_tbltrn_sales_contract_detail", $data);
    }

    function cek_item($headerID, $itemid) {
        $this->db->where('HeaderID', $headerID);
        $this->db->where('ItemID', $itemid);
        $sql = $this->db->get('zhl_acc_tbl_trn_sim1_dtl');
        if ($sql->num_rows() > 0) {
            $result = 1;
        } else {
            $result = 0;
        }
        return $result;
    }

}

?>