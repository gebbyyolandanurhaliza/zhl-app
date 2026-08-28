<?php

class M_Receivable_recognition extends CI_Model {

    var $mst_supplier = 'zhl_mar_vw_mst_customer';
    var $mst_currency = 'zhl_gen_tbl_mst_currency';
    var $acc_tbl_trn_piutang = 'zhl_acc_tbl_trn_piutang';
    var $acc_tbl_trn_jurnal = 'zhl_acc_tbl_trn_jurnal';
    var $acc_tbl_trn_piutang_bulanan = 'zhl_acc_tbl_trn_piutang_bulanan';

    function __construct() {
        parent::__construct();
    }

    function call_sp_rec_piutang($data) {
        $qry = 'call zhl_sp_acc_tbl_trn_piutang_rec(?, ?, ?,?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
        $this->db->query($qry, $data);
    }

    function call_sp_rec_piutang_new($data) {
        $qry = 'call zhl_sp_acc_tbl_trn_piutang_rec_new(?, ?, ?,?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?,?)';
        $this->db->query($qry, $data);
    }

    function simpan_tbl_trn_hutang($data) {
        $this->db->insert($this->acc_tbl_trn_piutang, $data);
    }

    function update_tbl_trn_hutang($id, $data) {
        $this->db->where('nofaktur', $id);
        $this->db->update($this->acc_tbl_trn_piutang, $data);
    }
    
    function cari_nofaktur($tahun){
        $sql = $this->db->query("select MID(nofaktur, 4, 3) + 1 as nofaktur from zhl_acc_tbl_trn_piutang where nofaktur like '%INV%' and year(tanggal) = '$tahun' order by nofaktur desc limit 1");
        if ($sql->num_rows() > 0) {
            foreach ($sql->result() as $data) {
                $hasil[] = $data;
            }
            return $hasil;
        }
    }
    function simpan_hutang_bulanan($bulan) {
        $this->db->insert($this->acc_tbl_trn_piutang_bulanan, $bulan);
    }

    function update_hutang_bulanan($nofaktur, $data) {
        $this->db->where('nofaktur', $nofaktur);
        $this->db->update($this->acc_tbl_trn_piutang_bulanan, $data);
    }

    function simpan_pr($det_item) {
        $this->db->insert('zhl_acc_tbl_trn_receivable_recognition', $det_item);
    }

    function update_pr($id, $data) {
        $this->db->where('DetailID', $id);
        $this->db->update('zhl_acc_tbl_trn_receivable_recognition', $data);
    }

    function simpan_jurnal($footer_purc) {
        $this->db->insert('zhl_acc_tbl_trn_jurnal', $footer_purc);
    }

    function update_jurnal($DetailID1, $footer_purc) {
        $this->db->where('DetailID', $DetailID1);
        $this->db->update('zhl_acc_tbl_trn_jurnal', $footer_purc);
    }

    function delete_item($id) {
        $this->db->where('DetailID', $id);
        $this->db->delete('zhl_acc_tbl_trn_receivable_recognition');
    }

    function delete_jurnal($id) {
        $this->db->where('DetailID', $id);
        $this->db->delete('zhl_acc_tbl_trn_jurnal');
    }

    function get_list_piutang() {
        $bulan = date("m");
        $this->db->where('jenis_trans', 'RRG');
        
        //$this->db->where('MONTH(tanggal)', $bulan);
        //$this->db->order_by('tanggal', 'Desc');
        $sql_product = $this->db->get('zhl_vw_acc_tbl_trn_piutang');

        if ($sql_product->num_rows() > 0) {
            foreach ($sql_product->result() as $data) {
                $hasil[] = $data;
            }
            return $hasil;
        }
    }
    
//    function advance_list_piutang($invoice,$dari,$sampai,$supplier) {
//        //$this->db->limit('50');
//        $p_dari = date('Y-m-d', strtotime($dari));
//        $p_sampai = date('Y-m-d', strtotime($sampai));
//        $this->db->where('jenis_trans', 'RRG');
//        $this->db->like('nofaktur', $invoice);
//        $this->db->like('kode_sup', $supplier);
//        $this->db->where('tanggal >=', $p_dari);
//        $this->db->where('tanggal <=', $p_sampai);
//        $this->db->order_by('tanggal', 'DEsc');
//        $sql_product = $this->db->get('vw_acc_tbl_trn_piutang');
//
//        if ($sql_product->num_rows() > 0) {
//            foreach ($sql_product->result() as $data) {
//                $hasil[] = $data;
//            }
//            return $hasil;
//        }
//    }

    function advance_list_piutang1($invoice, $supplier) {
       $sql_product = $this->db->query("select * from zhl_vw_acc_tbl_trn_piutang WHERE jenis_trans='RRG' and kode_sup like '%$supplier%' and nofaktur like '%$invoice%'");

        if ($sql_product->num_rows() > 0) {
            foreach ($sql_product->result() as $data) {
                $hasil[] = $data;
            }
            return $hasil;
        }
    }

    function advance_list_piutang($dari, $sampai, $invoice, $supplier) {
        $sql_product = $this->db->query("select * from zhl_vw_acc_tbl_trn_piutang WHERE jenis_trans = 'RRG' and tanggal >= '$dari' and tanggal <= '$sampai' AND kode_sup like '%$supplier%' and nofaktur like '%$invoice%' ");
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

    function get_customer() {        
        $this->db->where('status_customer', 1);
        $this->db->order_by('customer_name', 'ASC');
        $sql_prov = $this->db->get('zhl_mar_vw_mst_customer');
        if ($sql_prov->num_rows() > 0) {
            $result[''] = 'Select';
            foreach ($sql_prov->result_array() as $row) {
                $result[$row['customer_code'] . "|" . $row['coa']] = ucwords(strtoupper($row['customer_name']));
            }
            return $result;
        } else {
            echo "";
        }
    }
    function get_customernew()
    {
        $this->db->where('status_customer', 1);
        $this->db->order_by('customer_name', 'ASC');
        $sql_prov = $this->db->get('zhl_mar_vw_mst_customer');
        if ($sql_prov->num_rows() > 0) {
            $result[''] = 'Select';
            foreach ($sql_prov->result_array() as $row) {
                $result[$row['customer_code'] . "|" . $row['new_coa']] = ucwords(strtoupper($row['customer_name']));
            }
            return $result;
        } else {
            echo "";
        }
    }

    function get_term($id){
        $this->db->select('payment_term');
        $this->db->from('zhl_mar_vw_mst_customer_payterm');
        $this->db->where('customer_code', $id);
        $this->db->where('inactive', 0);
        $sql_product = $this->db->get();
    
        if ($sql_product->num_rows() > 0) {
          foreach ($sql_product->result() as $data) {
            $hasil[] = $data;
          }
          return $hasil;
        } else {
          $hasil[] = '';
        }
    }

    function get_customer_new() {        
        $this->db->where('status_customer', 1);
        $this->db->order_by('customer_name', 'ASC');
        $sql_prov = $this->db->get('zhl_mar_vw_mst_customer');
        if ($sql_prov->num_rows() > 0) {
            $result[''] = 'Select';
            foreach ($sql_prov->result_array() as $row) {
                $result[$row['customer_code'] . "|" . $row['new_coa']] = ucwords(strtoupper($row['customer_name']));
            }
            return $result;
        } else {
            echo "";
        }
    }
    
    //this for list record
    function get_sup() {
        $this->db->where('status_customer', 1);
        $this->db->order_by('customer_name', 'ASC');
        $sql_prov = $this->db->get('zhl_mar_vw_mst_customer');
        if ($sql_prov->num_rows() > 0) {
            $result[''] = 'Select';
            foreach ($sql_prov->result_array() as $row) {
                $result[$row['customer_code']] = ucwords(strtoupper($row['customer_name']));
            }
            return $result;
        } else {
            echo "";
        }
    }

    function get_currency() {
         $this->db->where('not_active', 0);
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

    function delete_piutang($id) {
        //acc_tbl_trn_jurnal
        $this->db->where('NoJurnal', $id);
        $this->db->where('jenis_trans', 'RRG');
        $this->db->delete('zhl_acc_tbl_trn_jurnal');

        //acc_tbl_trn_hutang
        $this->db->where('nofaktur', $id);
        $this->db->where('jenis_trans', 'RRG');
        $this->db->delete('zhl_acc_tbl_trn_piutang');

        //acc_tbl_trn_hutang_bulanan
        $this->db->where('nofaktur', $id);
        $this->db->where('jenis_trans', 'RRG');
        $this->db->delete('zhl_acc_tbl_trn_piutang_bulanan');

        //acc_tbl_trn_payable_recognition
        $this->db->where('HeaderID', $id);
        $this->db->delete('zhl_acc_tbl_trn_receivable_recognition');

        // /acc_tbl_trn_gst
        $this->db->where('ref_nomor', $id);
        $this->db->where('jenis_trans', 'RRG');
        $this->db->delete('zhl_acc_tbl_trn_gst');
    }

    function hapus_coa_kosong() {
        $coa = array('0', '');
        $this->db->where_in('NoCOA', $coa);
        $this->db->or_where('Total', '0');
        $this->db->delete('zhl_acc_tbl_trn_jurnal');
    }

    function get_data_detail($id) {
        $this->db->select('*');
        $this->db->where('HeaderID', $id);
        $sql_product = $this->db->get('zhl_acc_tbl_trn_receivable_recognition');

        if ($sql_product->num_rows() > 0) {
            foreach ($sql_product->result() as $data) {
                $hasil[] = $data;
            }
            return $hasil;
        }
    }

    function get_data_footer($id) {
        $this->db->select('*');
        $this->db->where('NoJurnal', $id);
        $this->db->where('jenis_trans', 'RRG');
        $this->db->where_not_in('JenisJurnalID', 'AR/GL');
        $sql_product = $this->db->get('zhl_acc_tbl_trn_jurnal');

        if ($sql_product->num_rows() > 0) {
            foreach ($sql_product->result() as $data) {
                $hasil[] = $data;
            }
            return $hasil;
        }
    }

    function get_data_awal($id, $jenis) {
        $this->db->select('sum(Debet) as Debet,sum(Kredit) as Kredit,,sum(Total) as Total, Uraian, DetailID, NoCOA, chk, Rate ');
        $this->db->where('NoJurnal', $id);
        $this->db->where('JenisJurnalID', $jenis);
        $sql_product = $this->db->get('zhl_acc_tbl_trn_jurnal');

        if ($sql_product->num_rows() > 0) {
            foreach ($sql_product->result() as $data) {
                $hasil[] = $data;
            }
            return $hasil;
        }
    }

    function delete_jurnal_lama($nojurnal) {
        $this->db->where('NoJurnal', $nojurnal);
        $this->db->where('jenis_trans', 'RRG');
        $this->db->delete('zhl_acc_tbl_trn_jurnal');
    }

    function delete_gst_lama($nojurnal) {
        $this->db->where('ref_nomor', $nojurnal);
        $this->db->where('jenis_trans', 'RRG');
        $this->db->delete('zhl_acc_tbl_trn_gst');
    }

    function simpan_gst_payable($gst_item) {
        $this->db->insert('zhl_acc_tbl_trn_gst', $gst_item);
    }

     function get_data_jurnal($no, $id, $jenis) {
        $data = array('AR/GL', 'Sales');
        $this->db->select('*');
        $this->db->where('NoJurnal', $id);
        $this->db->where('NoUrut', $no);
        $this->db->where('jenis_trans', $jenis);
        $this->db->where_not_in('JenisJurnalID', $data);
        $sql_product = $this->db->get('zhl_acc_tbl_trn_jurnal');

        if ($sql_product->num_rows() > 0) {
            foreach ($sql_product->result() as $data) {
                $hasil[] = $data;
            }
            return $hasil;
        }
    }

    function delete_all($id) {
        //acc_tbl_trn_jurnal
        $this->db->where('NoJurnal', $id);
        $this->db->where('jenis_trans', 'RRG');
        $this->db->delete('zhl_acc_tbl_trn_jurnal');

        //acc_tbl_trn_hutang
        $this->db->where('nofaktur', $id);
        $this->db->where('jenis_trans', 'RRG');
        $this->db->delete('zhl_acc_tbl_trn_piutang');

        //acc_tbl_trn_hutang_bulanan
        $this->db->where('nofaktur', $id);
        $this->db->where('jenis_trans', 'RRG');
        $this->db->delete('zhl_acc_tbl_trn_piutang_bulanan');

        //acc_tbl_trn_payable_recognition
        $this->db->where('HeaderID', $id);
        $this->db->delete('zhl_acc_tbl_trn_receivable_recognition');
    }

    function get_gl($id) {
        $this->db->select('*');
        $this->db->where('gl_id', $id);
        $sql_product = $this->db->get('zhl_acc_master_gl');
        if ($sql_product->num_rows() > 0) {
            foreach ($sql_product->result() as $data) {
                $hasil[] = $data;
            }
            return $hasil;
        }
    }

    function data_paling_bawah($nofaktur) {
        // $sql_product = $this->db->query("SELECT DISTINCT Rate as rate,(SELECT SUM(Total) FROM `acc_tbl_trn_jurnal` WHERE NoJurnal = '$nofaktur' and JenisJurnalID = 'AR/GL') as Total, (SELECT SUM(Total * Rate) FROM `acc_tbl_trn_jurnal` WHERE NoJurnal = '$nofaktur' and NoUrut <> 0 and chk = 'D') as TotalDebet,
        //                   (SELECT SUM(Total * Rate) FROM `acc_tbl_trn_jurnal` WHERE NoJurnal = '$nofaktur' and NoUrut <> 0 and chk = 'C') as TotalCredit FROM `acc_tbl_trn_jurnal` WHERE NoJurnal = '$nofaktur' ");

        $sql_product = $this->db->query("SELECT * From zhl_acc_tbl_trn_piutang Where NoFaktur = '$nofaktur' and jenis_trans='RRG' ");


        if ($sql_product->num_rows() > 0) {
            foreach ($sql_product->result() as $data) {
                $hasil[] = $data;
            }
            return $hasil;
        }
    }

    function insertCashBankHeaderx($data) {
        $this->db->trans_start();
        $this->db->insert('zhl_fin_tbltrn_cashbank_journal_header', $data);
        $headerID = $this->db->insert_id();
        $this->db->trans_complete();

        return $headerID;
    }

    function hapusCashBankHeader($id) {
        $this->db->where('no_reff', $id);
        $this->db->delete('zhl_fin_tbltrn_cashbank_journal_header');
    }

    function insertCashBankDetailx($data) {
        $this->db->insert('zhl_fin_tbltrn_cashbank_journal_detail', $data);
    }

    function hapusCashBankDetail($id) {
        $this->db->where('no_reff', $id);
        $this->db->delete('zhl_fin_tbltrn_cashbank_journal_detail');
    }

    function insertCBhistoryx($data) {
        $this->db->insert('zhl_fin_tbltrn_cashbank_journal_history', $data);
    }
    
    function hapusCashBankhistory($id) {
        $this->db->where('no_facture', $id);
        $this->db->delete('zhl_fin_tbltrn_cashbank_journal_history');
    }

    function insertDetailPOcbTransactionx($data) {
        $this->db->insert('zhl_fin_tbltrn_cashbank_journal_detail_po', $data);
    }
    
    function hapusDetailPOcbTransaction($id) {
        $this->db->where('po_id', $id);
        $this->db->delete('zhl_fin_tbltrn_cashbank_journal_detail_po');
    }

    
    function pilih_dp($id, $cur){
        $this->db->select('*');
        $this->db->where('prepaid', '1');
        $this->db->where('suplier', $id);
        $sql_product = $this->db->get('zhl_fin_tbltrn_cashbank_journal_header');

        if ($sql_product->num_rows() > 0) {
            foreach ($sql_product->result() as $data) {
                $hasil[] = $data;
            }
            return $hasil;
        }
    }
    
    function update_dp_ar($id, $bayar_dp) {
        $this->db->query('UPDATE `zhl_fin_tbltrn_cashbank_journal_detail_po` SET `bayar` = `bayar` + ' . $bayar_dp . ' WHERE detail_id =' . $id);
    }

    function selectInvoiceforFindRR(){
        //$this->db->where('trans_type', 'AP');
        $this->db->where('jenis_trans', 'RRG');
        //$this->db->where('MONTH(tanggal)', $bulan);
        //$this->db->order_by('tanggal', 'Desc');
        $sql_product = $this->db->get('zhl_vw_acc_tbl_trn_piutang');

        return $sql_product;
    }

    function call_cek_sp_rec_piutang($supp, $currency, $periode) {
        $sql = $this->db->query("call zhl_sp_acc_rpt_receivable_aging_inv('$supp', '$currency', '$periode')");
        $res = $sql->result();
        $sql->next_result();
        $sql->free_result();
        return $res;
    }

}
