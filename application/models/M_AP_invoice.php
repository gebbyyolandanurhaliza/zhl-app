<?php

class M_AP_invoice extends CI_Model {

    var $mst_supplier = 'zhl_pur_tbl_mst_supplier';
    var $mst_currency = 'zhl_acc_tbl_trn_kurs';
    var $acc_tbl_trn_hutang = 'zhl_acc_tbl_trn_hutang';
    var $acc_tbl_trn_jurnal = 'zhl_acc_tbl_trn_jurnal';
    var $acc_tbl_trn_hutang_bulanan = 'zhl_acc_tbl_trn_hutang_bulanan';

    function __construct() {
        parent::__construct();
    }

    function simpan_header($data) {
        $this->db->insert('zhl_acc_tbl_trn_appaymenthdr', $data);
    }

    function update_header($nomorAP, $data) {
        $this->db->where('NomorAP', $nomorAP);
        $this->db->update('zhl_acc_tbl_trn_appaymenthdr', $data);
    }

    function simpan_detail($data) {
        $this->db->insert('zhl_acc_tbl_trn_appaymentdtl', $data);
    }

    function update_detail($DetailID, $data) {
        $this->db->where('DetailID', $DetailID);
        $this->db->update('zhl_acc_tbl_trn_appaymentdtl', $data);
    }

    function select_APPayment($id) {
        $this->db->select('*');
        $this->db->where('NomorAP', $id);
        $sql_product = $this->db->get('zhl_acc_tbl_trn_appaymenthdr');
        if ($sql_product->num_rows() > 0) {
            foreach ($sql_product->result() as $data) {
                $hasil[] = $data;
            }
            return $hasil;
        }
    }

    function delete_all($id) {
        //acc_tbl_trn_hutang
        $this->db->where('NomorAP', $id);
        $this->db->delete('zhl_acc_tbl_trn_appaymenthdr');

        //acc_tbl_trn_jurnal
        $this->db->where('NomorAP', $id);
        $this->db->delete('zhl_acc_tbl_trn_appaymentdtl');
    }

    function get_list_ap() {
        $this->db->select('*');
        $sql_product = $this->db->get('zhl_acc_tbl_trn_appaymenthdr');

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
        $sql_product = $this->db->get('vw_acc_tbl_trn_hutang');

        if ($sql_product->num_rows() > 0) {
            foreach ($sql_product->result() as $data) {
                $hasil[] = $data;
            }
            return $hasil;
        }
    }

    function get_supplier() {
        $sql_prov = $this->db->get($this->mst_supplier);
        if ($sql_prov->num_rows() > 0) {
            $result[''] = 'Select';
            foreach ($sql_prov->result_array() as $row) {
                $result[$row['supplierid']] = ucwords(strtoupper($row['suppliercompany']));
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
        $this->db->where('NomorAP', $id);
        $sql_product = $this->db->get('zhl_acc_vw_trn_appayment', 0, 1);

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
        $this->db->where('NomorAP', $id);
        $sql_product = $this->db->get('zhl_acc_vw_trn_appaymentdtl');

        if ($sql_product->num_rows() > 0) {
            foreach ($sql_product->result() as $data) {
                $hasil[] = $data;
            }
            return $hasil;
        }
    }

    function get_data_footer($id) {
        $this->db->select('SUM(Total) as GrandTotal, SUM(hutang) as GrandHutang');
        $this->db->where('NomorAP', $id);
        $sql_product = $this->db->get('zhl_acc_vw_trn_appaymentdtl');

        if ($sql_product->num_rows() > 0) {
            foreach ($sql_product->result() as $data) {
                $hasil[] = $data;
            }
            return $hasil;
        }
    }
//select * from acc_tbl_trn_hutang where kode_sup = 'AAI' and currency_id = 'SGD' and nofaktur not in (SELECT NomorAP from acc_tbl_trn_APPaymentHdr)
    function get_data_journal($sup, $rate) {
        $this->db->select('*');
        $this->db->where('kode_sup', $sup);
        $this->db->where('currency_id', $rate);
        $sql_rec = $this->db->get('zhl_acc_vw_data_for_appayment');
        
        //$sql_rec = $this->db->query("select * from acc_tbl_trn_hutang WHERE `kode_sup` = '".$sup."' AND currency_id = '".$rate."' AND nofaktur not in (SELECT NoInvoice FROM `acc_tbl_trn_APPaymentDtl`)");
        if ($sql_rec->num_rows() > 0) {
            foreach ($sql_rec->result() as $data) {
                $hasil[] = $data;
            }
            return $hasil;
        }
    }

}
