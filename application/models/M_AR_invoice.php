<?php

class M_AR_invoice extends CI_Model {

    var $mst_supplier = 'zhl_mar_tblmst_customer';
    var $mst_currency = 'zhl_acc_tbl_trn_kurs';
    var $acc_tbl_trn_jurnal = 'zhl_acc_tbl_trn_jurnal';

    function __construct() {
        parent::__construct();
    }

    function simpan_header($data) {
        $this->db->insert('zhl_acc_tbl_trn_arpaymenthdr', $data);
    }

    function update_header($nomorAP, $data) {
        $this->db->where('NomorAR', $nomorAP);
        $this->db->update('zhl_acc_tbl_trn_arpaymenthdr', $data);
    }

    function simpan_detail($data) {
        $this->db->insert('zhl_acc_tbl_trn_arpaymentdtl', $data);
    }

    function update_detail($DetailID, $data) {
        $this->db->where('DetailID', $DetailID);
        $this->db->update('zhl_acc_tbl_trn_arpaymentdtl', $data);
    }

    function select_APPayment($id) {
        $this->db->select('*');
        $this->db->where('NomorAR', $id);
        $sql_product = $this->db->get('zhl_acc_tbl_trn_arpaymenthdr');
        if ($sql_product->num_rows() > 0) {
            foreach ($sql_product->result() as $data) {
                $hasil[] = $data;
            }
            return $hasil;
        }
    }

    function delete_all($id) {
        $this->db->where('NomorAR', $id);
        $this->db->delete('zhl_acc_tbl_trn_arpaymenthdr');

        //acc_tbl_trn_jurnal
        $this->db->where('NomorAR', $id);
        $this->db->delete('zhl_acc_tbl_trn_arpaymentdtl');
    }

    function get_list_ap() {
        $this->db->select('*');
        $sql_product = $this->db->get('zhl_acc_tbl_trn_arpaymenthdr');

        if ($sql_product->num_rows() > 0) {
            foreach ($sql_product->result() as $data) {
                $hasil[] = $data;
            }
            return $hasil;
        }
    }

    function nota($id) {
        $this->db->select('*');
        $this->db->where('nofaktur', $id);
        $sql_product = $this->db->get('zhl_vw_acc_tbl_trn_piutang');

        if ($sql_product->num_rows() > 0) {
            foreach ($sql_product->result() as $data) {
                $hasil[] = $data;
            }
            return $hasil;
        }
    }

    function get_supplier() {
        $sql_prov = $this->db->get($this->mst_supplier);
        //$this->db->where('status_customer', 1);
        if ($sql_prov->num_rows() > 0) {
            $result[''] = 'Select';
            foreach ($sql_prov->result_array() as $row) {
                $result[$row['customer_code']] = ucwords(strtoupper($row['customer_name']));
            }
            return $result;
        } else {
            echo "Not data avaible";
        }
    }

    function get_currency() {
        $sekarang = date("Y-m-d");
        $this->db->limit('7');
        $this->db->where('periode <', $sekarang);
        $this->db->order_by('periode', 'DESC');
        $sql_prov = $this->db->get('zhl_acc_tbl_trn_kurs');
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

    function get_currency_date($sekarang) {
        $this->db->limit('7');
        $this->db->where('periode >', $sekarang);
        $this->db->order_by('periode <', 'DESC');
        $sql_prov = $this->db->get('zhl_acc_tbl_trn_kurs');
        if ($sql_prov->num_rows() > 0) {
            $result[''] = 'Select';
            foreach ($sql_prov->result_array() as $row) {
                $result[$row['currency_id']] = ucwords(strtoupper($row['currency_id']));
            }
            return $result;
        }
    }

    function get_currency_detail() {
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

    function get_data_header($id) {
        $this->db->select('*');
        //$this->db->limit(1);
        $this->db->where('NomorAR', $id);
        $sql_product = $this->db->get('zhl_acc_vw_trn_arpayment', 0, 1);

        if ($sql_product->num_rows() > 0) {
            foreach ($sql_product->result() as $data) {
                $hasil[] = $data;
            }
            return $hasil;
        } else {
            $hasil[] = '';
        }
    }

    function get_data_detail($id) {
        $this->db->select('*');
        $this->db->where('NomorAR', $id);
        $sql_product = $this->db->get('zhl_acc_vw_trn_arpaymentdtl');

        if ($sql_product->num_rows() > 0) {
            foreach ($sql_product->result() as $data) {
                $hasil[] = $data;
            }
            return $hasil;
        }
    }

    function get_data_footer($id) {
        $this->db->select('SUM(Total) as GrandTotal, SUM(hutang) as GrandHutang');
        $this->db->where('NomorAR', $id);
        $sql_product = $this->db->get('zhl_acc_vw_trn_arpaymentdtl');

        if ($sql_product->num_rows() > 0) {
            foreach ($sql_product->result() as $data) {
                $hasil[] = $data;
            }
            return $hasil;
        }
    }
    
    function get_data_journal($sup, $rate) {
        $this->db->select('*');
        $this->db->where('kode_sup', $sup);
        $this->db->where('currency_id', $rate);
        $sql_rec = $this->db->get('zhl_acc_vw_data_for_arpayment');
        
        if ($sql_rec->num_rows() > 0) {
            foreach ($sql_rec->result() as $data) {
                $hasil[] = $data;
            }
            return $hasil;
        }
    }

}
