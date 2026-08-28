<?php

class M_ccdn extends CI_Model {

    var $bank_view = 'zhl_mar_vw_mst_bank';
    var $mst_supplier = 'zhl_mar_tblmst_customer';
    var $mst_currency = 'zhl_gen_tbl_mst_currency';
    var $acc_tbl_trn_faktur_jual = 'zhl_acc_tbl_trn_jurnal';
    var $acc_tbl_trn_jurnal = 'zhl_acc_tbl_trn_jurnal';
    var $acc_tbl_trn_faktur_jual_bulanan = 'zhl_acc_tbl_trn_piutang_bulanan';

    function __construct() {
        parent::__construct();
    }

    function get_supplier() {
        $this->db->select('customer_code, customer_name, new_coa');
        $this->db->where('status_customer', 1);
        $this->db->from('zhl_mar_vw_mst_customer');
        $sql = $this->db->get();
        if ($sql->num_rows() > 0) {
            $result[''] = "Select";
            foreach ($sql->result_array() as $row) {
                $result[$row['customer_code'] . "|" . $row['new_coa']] = ucwords(strtoupper($row['customer_name']));
            }
            return $result;
        } else {
            echo "";
        }
    }

    function get_refnum() {
        $this->db->limit(1);
        $this->db->order_by('created_date', 'desc');
        $this->db->like('no_reff', 'GV');
        $sql = $this->db->get('zhl_acc_tbl_trn_general');
        return $sql->row();
    }

    function list_ccdn() {
        $jenis = array('CDN', 'CCN');
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

    function list_ccdn2($invoice, $supplier, $p_dari, $p_sampai) {
        $jenis = array('CDN', 'CCN');
        $this->db->select('*');
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

    function list_ccdn3($invoice, $supplier, $p_dari, $p_sampai) {
        $jenis = array('CDN', 'CCN');
        $this->db->select('*');
        $this->db->where ('no_reff LIKE', '%'.$invoice);
        $this->db->where ('Tanggal >=', $p_dari);
        $this->db->where ('Tanggal <=', $p_sampai);
        $this->db->group_by('no_reff');
        $this->db->where_in('jenis_debit_kredit', $jenis);
        
        $sql_product = $this->db->query("SELECT a.no_reff, a.tanggal, b.hutang, a.gst_value, a.total, a.jenis_debit_kredit, a.currency, b.Rate, b.rate_sgd, a.nama_sup FROM zhl_acc_tbl_trn_debit_kredit_note as a INNER JOIN zhl_vw_acc_trn_credit_debit_note as b on b.no_reff=a.no_reff where a.tanggal between '$p_dari' and '$p_sampai' and a.jenis_debit_kredit IN ('CDN', 'CCN')
            GROUP BY a.no_reff");

        if ($sql_product->num_rows() > 0) {
            foreach ($sql_product->result() as $data) {
                $hasil[] = $data;
            }
            return $hasil;
        }
    }
	
	function list_ccdn_top($jenis) {
        $year = date('Y');
        // $sql_product = $this->db->query("SELECT  SUBSTRING(no_reff, 3,3) as no_reff FROM `zhl_acc_tbl_trn_debit_kredit_note` WHERE SUBSTRING(no_reff, 1,2) IN ('CN', 'DN') and jenis_debit_kredit = '$year' AND YEAR(tanggal)= '$year' ORDER BY SUBSTRING(no_reff, 3,3) DESC LIMIT 1");

        $sql_product = $this->db->query("SELECT SUBSTRING(no_reff, 5,3) as no_reff FROM `zhl_acc_tbl_trn_debit_kredit_note` WHERE SUBSTRING(no_reff, 3,2) 
        IN ('CN', 'DN') ORDER BY SUBSTRING(no_reff, 5,3) DESC LIMIT 1");

        if ($sql_product->num_rows() > 0) {
            foreach ($sql_product->result() as $data) {
                $hasil[] = $data;
            }
            return $hasil;
        }
    }

    function cek_ccdn($inv) {
        $sql_product = $this->db->query("SELECT no_reff as no_reff  FROM zhl_acc_tbl_trn_debit_kredit_note WHERE SUBSTRING(jenis_debit_kredit, 1,1) = 'C' and SUBSTRING(no_reff, 1,2) = SUBSTRING('$inv', 1,2) order by YEAR(tanggal) desc,Left(no_reff,5) desc LIMIT 1");

        return $sql_product->row();
    }

    function list_ccdn_credit($jenis, $tahun) {
        $year = date('Y');
        // $sql_product = $this->db->query("SELECT  SUBSTRING(no_reff, 3,3) as no_reff FROM `zhl_acc_tbl_trn_debit_kredit_note` WHERE SUBSTRING(no_reff, 1,2) IN ('CN', 'DN') and jenis_debit_kredit = '$jenis' AND YEAR(tanggal)='$tahun' ORDER BY SUBSTRING(no_reff, 3,3) DESC LIMIT 1");

        $sql_product = $this->db->query("SELECT SUBSTRING(no_reff, 5,3) as no_reff FROM `zhl_acc_tbl_trn_debit_kredit_note` WHERE SUBSTRING(no_reff, 3,2) 
        IN ('CN', 'DN') ORDER BY SUBSTRING(no_reff, 5,3) DESC LIMIT 1");

        if ($sql_product->num_rows() > 0) {
            foreach ($sql_product->result() as $data) {
                $hasil[] = $data;
            }
            return $hasil;
        }
    }

    function list_ccdn_top_credit($bln) {
        $year = date('Y');
        $sql_product = $this->db->query("SELECT  SUBSTRING(no_reff, 3,3) as no_reff FROM `zhl_acc_tbl_trn_debit_kredit_note` WHERE SUBSTRING(no_reff, 1,2) IN ('CN', 'DN')and jenis_debit_kredit in ('CDN') AND YEAR(tanggal)= '$year' ORDER BY SUBSTRING(no_reff, 3,3) DESC LIMIT 1");

        if ($sql_product->num_rows() > 0) {
            foreach ($sql_product->result() as $data) {
                $hasil[] = $data;
            }
            return $hasil;
        }
    }

    function delete_dtl($id) {
        $this->db->where('DetailID', $id);
        $this->db->delete('zhl_acc_tbl_trn_jurnal');
    }

    function list_hutang() {
        $this->db->select('*');
        $this->db->where('jenis_trans', 'PRG');
        $sql_product = $this->db->get('zhl_vw_acc_tbl_trn_piutang');

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
        $sql_product = $this->db->get('zhl_vw_acc_tbl_trn_piutang');

        if ($sql_product->num_rows() > 0) {
            foreach ($sql_product->result() as $data) {
                $hasil[] = $data;
            }
            return $hasil;
        }
    }

    function list_piutang2($invoice, $supplier, $p_dari, $p_sampai) {
        $this->db->select('*');
        $this->db->where('nofaktur', $invoice);
        $sql_product = $this->db->get('zhl_vw_acc_tbl_trn_piutang');

        if ($sql_product->num_rows() > 0) {
            foreach ($sql_product->result() as $data) {
                $hasil[] = $data;
            }
            return $hasil;
        }
    }

    function get_currency() {
        $this->db->where('not_Active', 0);
        $this->db->select('currency_id');
        $this->db->order_by('currency_id', 'DESC');
        $sql_prov = $this->db->get('zhl_gen_tbl_mst_currency');
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

    function get_coa() {
        $this->db->select('*');
        $sql = $this->db->get('zhl_acc_master_coa');
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
        $this->db->where('status_customer', 1);
        $this->db->order_by('customer_name');
        $sql_prov = $this->db->get($this->mst_supplier);
        if ($sql_prov->num_rows() > 0) {
            foreach ($sql_prov->result_array() as $row) {
                $result[$row['customer_code']] = ucwords(strtoupper($row['customer_name']));
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

    function bank_get_all()
    {
        $this->db->order_by('bank_name', $this->order);
        return $this->db->get($this->bank_view)->result();
    }

    // ============================ CRUD START =================================
    //----------------- acc_tbl_trn_debit_kredit_note start --------------------
    function select_ccdn($id) {
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

    function select_ccdn2($id) {
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

    function simpan_ccdn($ccdn) {
        $this->db->insert('zhl_acc_tbl_trn_debit_kredit_note', $ccdn);
    }

    function update_ccdn($id, $ccdn) {
        $this->db->where('no_reff', $id);
        $this->db->update('zhl_acc_tbl_trn_debit_kredit_note', $ccdn);
    }

    function delete_ccdn($id) {
        $this->db->where('no_reff', $id);
        $this->db->delete('zhl_acc_tbl_trn_debit_kredit_note');
    }

    //----------------- acc_tbl_trn_debit_kredit_note end ----------------------
    //----------------- acc_tbl_trn_piutang start -------------------------------
    function select_piutang($id) {
        $this->db->select('*');
        $this->db->where('nofaktur', $id);
        $sql_product = $this->db->get('zhl_acc_tbl_trn_piutang');
        if ($sql_product->num_rows() > 0) {
            foreach ($sql_product->result() as $data) {
                $hasil[] = $data;
            }
            return $hasil;
        }
    }

    function simpan_piutang($data) {
        $this->db->insert('zhl_acc_tbl_trn_piutang', $data);
    }

    function update_piutang($id, $ccdn) {
        $this->db->where('nofaktur', $id);
        $this->db->update('zhl_acc_tbl_trn_piutang', $ccdn);
    }

    function update_sebelumnya($id, $ccdn) {
        $this->db->where('nofaktur', $id);
        $this->db->update('zhl_acc_tbl_trn_piutang', $ccdn);
    }

    function update_bulanan($id, $ccdn) {
        $this->db->where('nofaktur', $id);
        $this->db->update('zhl_acc_tbl_trn_piutang_bulanan', $ccdn);
    }

    function delete_piutang($id) {
        $trans = array('CCN','CDN');

        $this->db->where('nofaktur', $id);
        $this->db->where_in('jenis_trans', $trans);
        $this->db->delete('zhl_acc_tbl_trn_piutang');
    }

    //----------------- acc_tbl_trn_piutang end ---------------------------------
    //----------------- acc_tbl_trn_piutang_bulanan start -----------------------
    function select_bulanan($id) {
        $this->db->select('*');
        $this->db->where('nofaktur', $id);
        $sql_product = $this->db->get('zhl_acc_tbl_trn_piutang_bulanan');
        if ($sql_product->num_rows() > 0) {
            foreach ($sql_product->result() as $data) {
                $hasil[] = $data;
            }
            return $hasil;
        }
    }

    function simpan_piutang_bulanan($data) {
        $this->db->insert('zhl_acc_tbl_trn_piutang_bulanan', $data);
    }

    function update_piutang_bulanan($id, $ccdn) {
        $this->db->where('nofaktur', $id);
        $this->db->update('zhl_acc_tbl_trn_piutang_bulanan', $ccdn);
    }

    function delete_piutang_bulanan($id) {
        $this->db->where('nofaktur', $id);
        $this->db->delete('zhl_acc_tbl_trn_piutang_bulanan');
    }

    //----------------- acc_tbl_trn_piutang_bulanan end -------------------------
    //----------------- acc_tbl_trn_piutang_bulanan start -----------------------
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

    function select_detail_print($id, $jenis) {
        $this->db->select('*');
        $this->db->where('NoJurnal', $id);
        if ($jenis == 'CDN') {
            $this->db->where_not_in('Kredit', '0');
        } else {
            $this->db->where_not_in('Debet', '0');
        }
        $this->db->where_not_in('NoCOA', '200801');
        $sql_product = $this->db->get('zhl_acc_tbl_trn_jurnal');
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

    function update_jurnal($id, $ccdn) {
        $this->db->where('NoJurnal', $id);
        $this->db->where('jenis_trans', 'CCDN');
        $this->db->update('zhl_acc_tbl_trn_jurnal', $ccdn);
    }

    function delete_jurnal($id) {
        $this->db->where('NoJurnal', $id);
        $this->db->where('jenis_trans', 'CCDN');
        $this->db->delete('zhl_acc_tbl_trn_jurnal');
    }

    function call_sp_ccdn1($data) {
        $qry = 'call zhl_sp_acc_tbl_trn_piutang (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
        $this->db->query($qry, $data);
    }

    function call_sp_acc_tbl_trn_debit_kredit_note($data) {
       
        $qry = 'call zhl_sp_acc_tbl_trn_debit_kredit_note(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)';
        $this->db->query($qry, $data);
    }

    //----------------- acc_tbl_trn_piutang_bulanan end -------------------------
    // ============================ CRUD END ===================================
    function select_nota_print($id) {
        $this->db->select('*');
        $this->db->where('no_reff', $id);
        $sql_product = $this->db->get('zhl_vw_acc_trn_debit_credit');
        if ($sql_product->num_rows() > 0) {
            foreach ($sql_product->result() as $data) {
                $hasil[] = $data;
            }
            return $hasil;
        }
    }

    function select_rate_sgd($id) {
        $sql = $this->db->query("SELECT * from `zhl_acc_tbl_trn_jurnal` WHERE `NoJurnal` = (SELECT no_reff from zhl_acc_tbl_trn_debit_kredit_note WHERE no_reff = '$id') LIMIT 1");
        if ($sql->num_rows() > 0) {
            foreach ($sql->result() as $data) {
                $hasil[] = $data;
            }
            return $hasil;
        }
    }

    function call_sp_Ccdn($data) {
        $qry = 'call zhl_sp_acc_tbl_trn_piutang (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?)';
        $this->db->query($qry, $data);
    }

    function select_gst($id) {
        $this->db->select('NoCOA, gst_type, SUM(gst_value) as gst_value, SUM(Total) as Total');
        $this->db->where('NoJurnal', $id);
        $sql_product = $this->db->get('zhl_vw_acc_trn_credit_debit_note');
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
        $trans = array('CCN','CDN');

        $this->db->where('ref_nomor', $gst_item);
        $this->db->where_in('jenis_trans', $trans);
        $this->db->delete('zhl_acc_tbl_trn_gst');
    }

    function select_ref_ccn() {
        $this->db->limit(1);
        $this->db->where('jenis_debit_kredit', 'CCN');
        $this->db->order_by('created_date', 'DSC');
        $sql = $this->db->get('zhl_acc_tbl_trn_debit_kredit_note');
        return $sql->row();
    }

    function select_ref_cdn() {
        $this->db->limit(1);
        $this->db->where('jenis_debit_kredit', 'CDN');
        $this->db->order_by('created_date', 'DSC');
        $sql = $this->db->get('zhl_acc_tbl_trn_debit_kredit_note');
        return $sql->row();
    }

    function selectInvoiceforFindCCDN(){
        $jenis = array('CDN', 'CCN');
        $this->db->select('*');
        $this->db->where_in('jenis_debit_kredit', $jenis);
        $sql_product = $this->db->get('zhl_acc_tbl_trn_debit_kredit_note');

        return $sql_product;
    }

}
