<?php

class M_vcdn extends CI_Model {

    var $mst_supplier = 'zhl_mar_tblmst_customer';
    var $mst_currency = 'zhl_gen_tbl_mst_currency';
    var $acc_tbl_trn_faktur_jual = 'zhl_acc_tbl_trn_jurnal';
    var $acc_tbl_trn_jurnal = 'zhl_acc_tbl_trn_jurnal';
    var $acc_tbl_trn_faktur_jual_bulanan = 'zhl_acc_tbl_trn_hutang_bulanan';

    function __construct() {
        parent::__construct();
    }

    function get_supplier() {
        $this->db->order_by('suppliercompany', 'ASC');
        $sql_prov = $this->db->get('zhl_pur_vw_mst_supplier');
        if ($sql_prov->num_rows() > 0) {
            $result[''] = 'Select';
            foreach ($sql_prov->result_array() as $row) {
                $result[$row['supplierid'] . "|" . $row['newcoa']] = ucwords(strtoupper($row['suppliercompany']));
            }
            return $result;
        } else {
            echo "";
        }
    }

    function tampil_bank()
    {
        $this->db->where('inactive = 0');
        $result =  $this->db->get('zhl_mar_tblmst_bank');
        return $result->result();
    }


    function get_sup() {
        $this->db->order_by('suppliercompany', 'ASC');
        $sql_prov = $this->db->get('zhl_pur_vw_mst_supplier');
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

    function ambil_currency_date($kurs, $bln, $thn) {
        $bulan = $thn . "-". $bln .'-'. "01";
        //$sql_product = $this->db->query("SELECT DISTINCT * FROM `acc_tbl_trn_kurs` WHERE periode <= '$bulan' and currency_id = '$kurs'");
        $sql_product = $this->db->query("SELECT * FROM zhl_acc_tbl_trn_kurs WHERE periode=(SELECT DISTINCT periode FROM zhl_acc_tbl_trn_kurs WHERE periode<='$bulan' ORDER BY periode DESC LIMIT 1) AND currency_id = '$kurs'");
        if ($sql_product->num_rows() > 0) {
            foreach ($sql_product->result() as $data) {
                $hasil[] = $data;
            }
            return $hasil;
        }
    }
    
    function simpan_gst_payable($gst_item) {
        $this->db->insert('zhl_acc_tbl_trn_gst', $gst_item);
    }

    
    function delete_gst($gst_item) {
        $trans = array('VCN','VDN');
        $this->db->where('ref_nomor', $gst_item);
        $this->db->where_in('jenis_trans', $trans);
        $this->db->delete('zhl_acc_tbl_trn_gst');
    }
    
    function select_coa($id) {
        $this->db->select('*');
        $this->db->where('NoCoa', $id);
        $sql = $this->db->get('zhl_acc_master_new_coa');
        if ($sql->num_rows() > 0) {
            foreach ($sql->result() as $data) {
                $hasil[] = $data;
            }
            return $hasil;
        }
    }

    function list_vcdn() {
        $jenis = array('VDN', 'VCN');
        $this->db->select('*');
        $this->db->where_in('jenis_debit_kredit', $jenis);        
        $sql_product = $this->db->get('zhl_acc_tbl_trn_debit_kredit_note');

        if ($sql_product->num_rows() > 0) {
            foreach ($sql_product->result() as $data) {
                $hasil[] = $data;
            }
            return $hasil;
        } 
    }

     function list_vcdn2($invoice, $supplier, $p_dari, $p_sampai) {
        $jenis = array('VDN', 'VCN');
        $this->db->select('*');
        $this->db->where('kode_sup', $supplier);
        $this->db->where ('no_reff LIKE', '%'.$invoice);
        $this->db->where ('tanggal >=', $p_dari);
        $this->db->where ('tanggal <=', $p_sampai);
        $this->db->where_in('jenis_debit_kredit', $jenis);        
        $sql_product = $this->db->get('zhl_acc_tbl_trn_debit_kredit_note');

        if ($sql_product->num_rows() > 0) {
            foreach ($sql_product->result() as $data) {
                $hasil[] = $data;
            }
            return $hasil;
        } 
    }

    function list_hutang() {
        $this->db->select('*');
        $this->db->where('jenis_trans', 'PRG');
        $sql_product = $this->db->get('zhl_vw_acc_tbl_trn_hutang');

        if ($sql_product->num_rows() > 0) {
            foreach ($sql_product->result() as $data) {
                $hasil[] = $data;
            }
            return $hasil;
        }
    }

    function list_piutang() {
        $this->db->select('*');
        $this->db->where('jenis_trans', 'RRG');
        $sql_product = $this->db->get('zhl_vw_acc_tbl_trn_hutang');

        if ($sql_product->num_rows() > 0) {
            foreach ($sql_product->result() as $data) {
                $hasil[] = $data;
            }
            return $hasil;
        }
    }

    function get_currency() {
        // $sql_prov = $this->db->query("SELECT DISTINCT currency_id FROM zhl_acc_tbl_trn_kurs ORDER BY currency_id");
        $sql_prov = $this->db->query("SELECT DISTINCT kurs.currency_id FROM zhl_acc_tbl_trn_kurs as kurs JOIN zhl_gen_tbl_mst_currency as cur ON kurs.currency_id=cur.currency_id where cur.not_active=0 ORDER BY currency_id");
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

    function list_jurnal($id) {
        $this->db->select('*');
        $this->db->where('NoJurnal', $id);
        $sql_product = $this->db->get('zhl_acc_tbl_trn_jurnal');

        if ($sql_product->num_rows() > 0) {
            foreach ($sql_product->result() as $data) {
                $hasil[] = $data;
            }
            return $hasil;
        }
    }

    function get_coa($company_id) {
        $this->db->where('company_id', $company_id);
        $this->db->select('*');
        $sql = $this->db->get('zhl_vw_new_coa_dept_code');
        if ($sql->num_rows() > 0) {
            foreach ($sql->result() as $data) {
                $hasil[] = $data;
            }
            return $hasil;
        }
    }

    function get_coa_zht() {
        $this->db->where('company_id', '2');
        $this->db->select('*');
        $sql = $this->db->get('zhl_vw_new_coa_dept_code');
        if ($sql->num_rows() > 0) {
            foreach ($sql->result() as $data) {
                $hasil[] = $data;
            }
            return $hasil;
        }
    }

    function get_coa_old() {
        $this->db->select('*');
        $sql = $this->db->get('zhl_vw_new_coa_dept_code');
        if ($sql->num_rows() > 0) {
            foreach ($sql->result() as $data) {
                $hasil[] = $data;
            }
            return $hasil;
        }
    }

    function get_coa_tims($company_id) {
        $this->db->where('company_id', $company_id);
        $this->db->select('*');
        $sql = $this->db->get('zhl_vw_new_coa_dept_code');
        if ($sql->num_rows() > 0) {
            foreach ($sql->result() as $data) {
                $hasil[] = $data;
            }
            return $hasil;
        }
    }

    function get_rate($id) {
        $this->db->select('*');
        $this->db->where('currency_symbol', $id);
        $sql = $this->db->get('zhl_acc_tbl_trn_kurs');
        if ($sql->num_rows() > 0) {
            foreach ($sql->result() as $data) {
                $hasil[] = $data;
            }
            return $hasil;
        }
    }

    function nota_debet_kredit($id) {
        $sql_product = $this->db->get("SELECT SUM(Debet) as debet, SUM(Kredit) as Kredit FROM `zhl_acc_tbl_trn_jurnal` where `NoJurnal` = '$id'");

        if ($sql_product->num_rows() > 0) {
            foreach ($sql_product->result() as $data) {
                $hasil[] = $data;
            }
            return $hasil;
        }
    }

    function get_purchasing() {
        $sql_prov = $this->db->get("zhl_pur_vw_mst_supplier");
        if ($sql_prov->num_rows() > 0) {
            foreach ($sql_prov->result_array() as $row) {
                $result[$row['supplierid']] = ucwords(strtoupper($row['suppliercompany']));
            }
            return $result;
        } 
    }

    function get_curs() {
        $sql_prov = $this->db->get($this->mst_currency);
        if ($sql_prov->num_rows() > 0) {
            $result[''] = 'Select';
            foreach ($sql_prov->result_array() as $row) {
                $result[$row['currency_symbol']] = ucwords(strtoupper($row['currency_symbol']));
            }
            return $result;
        } else {
            echo "Not data avaible";
        }
    }

    // ============================ CRUD START =================================
    //----------------- acc_tbl_trn_debit_kredit_note start --------------------
    function select_vcdn($id) {
        $this->db->select('*');
        $this->db->where('no_reff', $id);
        $sql_product = $this->db->get('zhl_vw_acc_trn_credit_debit_note');
        if ($sql_product->num_rows() > 0) {
            foreach ($sql_product->result() as $data) {
                $hasil[] = $data;
            }
            return $hasil;
        }
    }

    function select_vcdn2($id) {
        $this->db->select('*');
        $this->db->where('no_reff', $id);
        $sql_product = $this->db->get('zhl_acc_tbl_trn_debit_kredit_note');
        if ($sql_product->num_rows() > 0) {
            foreach ($sql_product->result() as $data) {
                $hasil[] = $data;
            }
            return $hasil;
        }
    }

    function simpan_vcdn($vcdn) {
        $this->db->insert('zhl_acc_tbl_trn_debit_kredit_note', $vcdn);
    }

    function update_vcdn($id, $vcdn) {
        $this->db->where('no_reff', $id);
        $this->db->update('zhl_acc_tbl_trn_debit_kredit_note', $vcdn);
    }

    function delete_vcdn($id) {
        $this->db->where('no_reff', $id);
        $this->db->delete('zhl_acc_tbl_trn_debit_kredit_note');
    }

    //----------------- acc_tbl_trn_debit_kredit_note end ----------------------
    //----------------- acc_tbl_trn_hutang start -------------------------------
    function select_hutang($id) {
        $this->db->select('*');
        $this->db->where('nofaktur', $id);
        $sql_product = $this->db->get('zhl_acc_tbl_trn_hutang');
        if ($sql_product->num_rows() > 0) {
            foreach ($sql_product->result() as $data) {
                $hasil[] = $data;
            }
            return $hasil;
        }
    }

    function simpan_hutang($data) {
        $this->db->insert('zhl_acc_tbl_trn_hutang', $data);
    }

    function update_hutang($id, $vcdn) {
        $this->db->where('nofaktur', $id);
        $this->db->update('zhl_acc_tbl_trn_hutang', $vcdn);
    }

    function update_sebelumnya($id, $vcdn) {
        $this->db->where('nofaktur', $id);
        $this->db->update('zhl_acc_tbl_trn_hutang', $vcdn);
    }

    function update_bulanan($id, $vcdn) {
        $this->db->where('nofaktur', $id);
        $this->db->update('zhl_acc_tbl_trn_hutang_bulanan', $vcdn);
    }

    function delete_hutang($id) {
        $trans = array('VCN','VDN');

        $this->db->where('nofaktur', $id);
        $this->db->where_in('jenis_trans', $trans);
        $this->db->delete('zhl_acc_tbl_trn_hutang');
    }

    //----------------- acc_tbl_trn_hutang end ---------------------------------
    //----------------- acc_tbl_trn_hutang_bulanan start -----------------------
    function select_bulanan($id) {
        $this->db->select('*');
        $this->db->where('nofaktur', $id);
        $sql_product = $this->db->get('zhl_acc_tbl_trn_hutang_bulanan');
        if ($sql_product->num_rows() > 0) {
            foreach ($sql_product->result() as $data) {
                $hasil[] = $data;
            }
            return $hasil;
        }
    }

    function simpan_hutang_bulanan($data) {
        $this->db->insert('zhl_acc_tbl_trn_hutang_bulanan', $data);
    }

    function update_hutang_bulanan($id, $vcdn) {
        $this->db->where('nofaktur', $id);
        $this->db->update('zhl_acc_tbl_trn_hutang_bulanan', $vcdn);
    }

    function delete_hutang_bulanan($id) {
        $this->db->where('nofaktur', $id);
        $this->db->delete('zhl_acc_tbl_trn_hutang_bulanan');
    }

    //----------------- acc_tbl_trn_hutang_bulanan end -------------------------
    //----------------- acc_tbl_trn_hutang_bulanan start -----------------------
    function select_jurnal($id) {
        $this->db->select('*');
        $this->db->where('NoJurnal', $id);
        $sql_product = $this->db->get('zhl_vw_acc_trn_credit_debit_note');
        if ($sql_product->num_rows() > 0) {
            foreach ($sql_product->result() as $data) {
                $hasil[] = $data;
            }
            return $hasil;
        }
    }
    
    function select_nota($id) {
        $this->db->select('NoJurnal, SUM(Debet) as Debet, SUM(Kredit) as Kredit');
        $this->db->group_by('NoJurnal, jenis_debit_kredit');
        $this->db->where('NoJurnal', $id);
        $sql_product = $this->db->get('zhl_vw_acc_trn_credit_debit_note');
        if ($sql_product->num_rows() > 0) {
            foreach ($sql_product->result() as $data) {
                $hasil[] = $data;
            }
            return $hasil;
        } 
    }

    function simpan_jurnal($data) {
        $this->db->insert('zhl_acc_tbl_trn_jurnal', $data);
    }

    function update_jurnal($id, $vcdn) {
        $this->db->where('DetailID', $id);
        $this->db->update('zhl_acc_tbl_trn_jurnal', $vcdn);
    }

    function delete_jurnal($id) {
        $this->db->where('NoJurnal', $id);
        $this->db->where('jenis_trans', 'VCDN');
        $this->db->delete('zhl_acc_tbl_trn_jurnal');
    }

    function call_sp_vcdn1($data) {
        $qry = 'call zhl_sp_acc_tbl_trn_hutang (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
        $this->db->query($qry, $data);
    }
     function call_sp_acc_tbl_trn_debit_kredit_note($data) {
        $qry = 'call zhl_sp_acc_tbl_trn_debit_kredit_note(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)';
        $this->db->query($qry, $data);
    }

    //----------------- acc_tbl_trn_hutang_bulanan end -------------------------
    // ============================ CRUD END ===================================

    function tampil_po_rate($cur,$date){

        $newdate = date('Y-m-d', strtotime("-1 months", strtotime($date)));

        //$query=" currency_id = '".$cur."' and periode <= '".$newdate."'";
        $query=" currency_id = '".$cur."' and periode BETWEEN '".$newdate."' AND '".$date."'";
        $this->db->select('rate_usd');
        $this->db->select('rate_kurs');
        $this->db->where($query);
        $this->db->order_by('periode desc');
        $this->db->limit(1);


        $result=$this->db->get('zhl_acc_tbl_trn_kurs');
        if ($result->num_rows() > 0) {
            foreach ($result->result() as $data) {
                $hasil[] = $data;
            }
            return $hasil;
        }
    }

    function selectInvoiceforFindVCDN(){
        $jenis = array('VDN', 'VCN');
        $this->db->select('*');
        $this->db->where_in('jenis_debit_kredit', $jenis);
        $sql_product = $this->db->get('zhl_acc_tbl_trn_debit_kredit_note');

        return $sql_product;
    }
}
