<?php

//update date : 29 Nov 16 3.21 AM
//Update By : Deki

class M_purchase_inv_vendor extends CI_Model
{

    var $mst_supplier = 'zhl_mar_vw_mst_customer';
    var $mst_currency = 'zhl_gen_tbl_mst_currency';
    var $acc_tbl_trn_hutang = 'zhl_acc_tbl_trn_hutang';
    var $acc_tbl_trn_jurnal = 'zhl_acc_tbl_trn_jurnal';
    var $acc_tbl_trn_hutang_bulanan = 'zhl_acc_tbl_trn_hutang_bulanan';

    function __construct()
    {
        parent::__construct();
    }

    function call_sp_rec_hutang($data)
    {
        $qry = 'call zhl_sp_acc_tbl_trn_hutang(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
        $this->db->query($qry, $data);
    }
    function call_sp_rec_hutang_tes($data)
    {
        $qry = 'call zhl_sp_acc_tbl_trn_hutang_tes(?, ?, ?,?,?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?, ?, ?, ?, ?, ?, ?, ?)';
        $this->db->query($qry, $data);
    }
    function delete_all_item($id)
    {
        $this->db->where('HeaderID', $id);
        $this->db->delete('zhl_acc_tbl_trn_pi_dtl');
    }

    function simpan_tbl_trn_hutang($data)
    {
        $this->db->insert($this->acc_tbl_trn_hutang, $data);
    }

    function update_tbl_trn_hutang($id, $data)
    {
        $this->db->where('nofaktur', $id);
        $this->db->update($this->acc_tbl_trn_hutang, $data);
    }

    function simpan_hutang_bulanan($bulan)
    {
        $this->db->insert($this->acc_tbl_trn_hutang_bulanan, $bulan);
    }

    function update_hutang_bulanan($nofaktur, $data)
    {
        $this->db->where('nofaktur', $nofaktur);
        $this->db->update($this->acc_tbl_trn_hutang_bulanan, $data);
    }

    function save_acc_tbl_trn_pi_dtl($det_item)
    {
        $this->db->insert('zhl_acc_tbl_trn_pi_dtl', $det_item);
    }


    function simpan_jurnal($footer_purc)
    {
        $this->db->insert('zhl_acc_tbl_trn_jurnal', $footer_purc);
    }

    function simpan_jurnal_tes_pur($footer_purc)
    {
        $this->db->insert('zhl_acc_tbl_trn_jurnal_test_pur', $footer_purc);
    }

    function update_jurnal($DetailID1, $footer_purc)
    {
        $this->db->where('DetailID', $DetailID1);
        $this->db->update('zhl_acc_tbl_trn_jurnal', $footer_purc);
    }

    function delete_item($id)
    {
        $this->db->where('DetailID', $id);
        $this->db->delete('zhl_acc_tbl_trn_pi_dtl');
    }

    function delete_jurnal($id)
    {
        $this->db->where('DetailID', $id);
        $this->db->delete('zhl_acc_tbl_trn_jurnal');
    }

    function get_list_hutang()
    {
        $this->db->limit('50');
        $this->db->where('jenis_trans', 'PIJP');
        $this->db->order_by('tanggal', 'Desc');
        $sql_product = $this->db->get('zhl_vw_acc_tbl_trn_hutang');

        if ($sql_product->num_rows() > 0) {
            foreach ($sql_product->result() as $data) {
                $hasil[] = $data;
            }
            return $hasil;
        }
    }

    //    function advance_list_hutang($invoice,$dari,$sampai,$supplier) {
    //        //$this->db->limit('50');
    //        $p_dari = date('Y-m-d', strtotime($dari));
    //        $p_sampai = date('Y-m-d', strtotime($sampai));
    //        $this->db->where('jenis_trans', 'RRG');
    //        $this->db->like('nofaktur', $invoice);
    //        $this->db->like('kode_sup', $supplier);
    //        $this->db->where('tanggal >=', $p_dari);
    //        $this->db->where('tanggal <=', $p_sampai);
    //        $this->db->order_by('tanggal', 'DEsc');
    //        $sql_product = $this->db->get('vw_acc_tbl_trn_hutang');
    //
    //        if ($sql_product->num_rows() > 0) {
    //            foreach ($sql_product->result() as $data) {
    //                $hasil[] = $data;
    //            }
    //            return $hasil;
    //        }
    //    }

    function advance_list_hutang1($invoice, $supplier)
    {
        $sql_product = $this->db->query("select * from zhl_vw_acc_tbl_trn_hutang WHERE kode_sup like '%$supplier%' and nofaktur like '%$invoice%'");

        if ($sql_product->num_rows() > 0) {
            foreach ($sql_product->result() as $data) {
                $hasil[] = $data;
            }
            return $hasil;
        }
    }

    function advance_list_hutang($dari, $sampai, $invoice, $supplier)
    {
        $sql_product = $this->db->query("select * from zhl_vw_acc_tbl_trn_hutang WHERE tanggal >= '$dari' and tanggal <= '$sampai' AND kode_sup like '%$supplier%' and nofaktur like '%$invoice%'");
        if ($sql_product->num_rows() > 0) {
            foreach ($sql_product->result() as $data) {
                $hasil[] = $data;
            }
            return $hasil;
        }
    }

    function nota($id)
    {
        $this->db->select('*');
        $this->db->where('nofaktur', $id);
        $sql_product = $this->db->get('zhl_vw_acc_tbl_trn_hutang');

        if ($sql_product->num_rows() > 0) {
            foreach ($sql_product->result() as $data) {
                $hasil[] = $data;
            }
            return $hasil;
        }
    }

    function get_customer()
    {
        $this->db->where('factory_id', 0);
        $sql = $this->db->get('zhl_pur_vw_mst_supplier');
        if ($sql->num_rows() > 0) {
            $result[''] = 'Select';
            foreach ($sql->result_array() as $row) {
                $result[$row['supplierid'] . "|" . $row['nocoa']] = ucwords(strtoupper($row['suppliercompany']));
            }
            return $result;
        } else {
            echo "Not data avaible";
        }
    }

    function get_vendor_pur()
    {
        $this->db->where('factory_id', 0);
        $sql = $this->db->get('zhl_pur_vw_mst_vendor');
        if ($sql->num_rows() > 0) {
            $result[''] = 'Select';
            foreach ($sql->result_array() as $row) {
                $result[$row['vendorid'] . "|" . $row['nocoa']] = ucwords(strtoupper($row['vendorcompany']));
            }
            return $result;
        } else {
            echo "Not data avaible";
        }
    }

    //this for list record
    function get_sup()
    {
        $this->db->where('factory_id', 0);
        $sql = $this->db->get('zhl_pur_vw_mst_supplier');
        if ($sql->num_rows() > 0) {
            $result[''] = 'Select';
            foreach ($sql->result_array() as $row) {
                //$result[$row['supplierid']."|".$row['nocoa']] = ucwords(strtoupper($row['suppliercompany']));
                $result[$row['supplierid']] = ucwords(strtoupper($row['suppliercompany']));
            }
            return $result;
        } else {
            echo "Not data avaible";
        }
    }

    function tampil_po_list($supplier, $currency)
    {
        // $sql = $this->db->query("select * from zhl_api_acc_vw_qty_pi where vendorid = '$supplier' and currency = '$currency' and qtywhs - qty_pi <> 0");
        $sql = $this->db->query("select * from zhl_api_acc_vw_qty_pi  where vendorid = '$supplier' and currency = '$currency' and qty - qty_pi <> 0");
        if ($sql->num_rows() > 0) {
            foreach ($sql->result() as $data) {
                $hasil[] = $data;
            }
            return $hasil;
        }
    }

    function get_currency()
    {
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

    function get_currency_detail()
    {
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

    function get_data_header($id)
    {
        $this->db->select('a.*,b.rate_sgd as rate_sgd_ori');
        $this->db->from('zhl_acc_tbl_trn_hutang a');
        $this->db->join('zhl_acc_tbl_trn_pi_dtl b', 'b.headerid=a.nofaktur');
        $this->db->where('a.nofaktur', $id);
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

    function delete_hutang($id)
    {

        //acc_tbl_trn_jurnal
        $this->db->where('NoJurnal', $id);
        $this->db->where('jenis_trans', 'PIJV');
        $this->db->delete('zhl_acc_tbl_trn_jurnal');

        //acc_tbl_trn_hutang
        $this->db->where('nofaktur', $id);
        $this->db->where('jenis_trans', 'PIJV');
        $this->db->delete('zhl_acc_tbl_trn_hutang');

        //acc_tbl_trn_gst
        $this->db->where('ref_nomor', $id);
        $this->db->where('jenis_trans', 'PIJV');
        $this->db->delete('zhl_acc_tbl_trn_gst');

        //acc_tbl_trn_hutang_bulanan
        $this->db->where('nofaktur', $id);
        $this->db->delete('zhl_acc_tbl_trn_hutang_bulanan');

        //acc_tbl_trn_payable_recognition
        $this->db->where('HeaderID', $id);
        $this->db->delete('zhl_acc_tbl_trn_pi_dtl');

        $this->db->where('no_facture', $id);
        $this->db->delete('zhl_fin_tbltrn_cashbank_journal_history');
    }

    function hapus_coa_kosong()
    {
        $coa = array('0', '');
        $this->db->where_in('NoCOA', $coa);
        $this->db->or_where('Total', '0');
        $this->db->delete('zhl_acc_tbl_trn_jurnal');
    }

    function get_data_detail($id)
    {
        $this->db->select('*');
        $this->db->where('HeaderID', $id);
        $sql_product = $this->db->get('zhl_acc_tbl_trn_pi_dtl');

        if ($sql_product->num_rows() > 0) {
            foreach ($sql_product->result() as $data) {
                $hasil[] = $data;
            }
            return $hasil;
        }
    }

    function get_data_footer($id)
    {
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

    function get_data_awal($id, $jenis)
    {
        $this->db->select('SUM(Total) as Total, SUM(Debet) as Debet, SUM(Kredit) as Kredit,DetailID, NoCOA, chk, Uraian, Rate');
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

    function delete_jurnal_lama($nojurnal)
    {
        $this->db->where('NoJurnal', $nojurnal);
        $this->db->where('jenis_trans', 'PIJV');
        $this->db->delete('zhl_acc_tbl_trn_jurnal');


        $this->db->where('ref_nomor', $nojurnal);
        $this->db->delete('zhl_acc_tbl_trn_gst');
    }

    function delete_gst_lama($nojurnal)
    {
        $this->db->where('ref_nomor', $nojurnal);
        $this->db->where('jenis_trans', 'PIJV');
        $this->db->delete('zhl_acc_tbl_trn_gst');
    }

    function simpan_gst_payable($gst_item)
    {
        $this->db->insert('zhl_acc_tbl_trn_gst', $gst_item);
    }

    function get_data_jurnal($no, $id, $jenis)
    {
        $this->db->select('*');
        $this->db->where('NoJurnal', $id);
        $this->db->where('NoUrut', $no);
        $this->db->where('jenis_trans', $jenis);
        $sql_product = $this->db->get('zhl_acc_tbl_trn_jurnal');

        if ($sql_product->num_rows() > 0) {
            foreach ($sql_product->result() as $data) {
                $hasil[] = $data;
            }
            return $hasil;
        }
    }

    function delete_all($id)
    {

        //Hapus qty pi
        $this->db->query("update `zhl_pur_tbl_trn_gr_dtl` set `qty_pi`='0', id_jurnal = '' where id_jurnal = '$id'");
        //Hapus value deposit
        $this->db->query("UPDATE `zhl_fin_tbltrn_cashbank_journal_header` SET `total_bayar` = 0, id_jurnal = ''  WHERE header_id ='$id'");

        //acc_tbl_trn_jurnal
        $this->db->where('NoJurnal', $id);
        $this->db->where('jenis_trans', 'PIJP');
        $this->db->delete('zhl_acc_tbl_trn_jurnal');

        //acc_tbl_trn_gst
        $this->db->where('ref_nomor', $id);
        $this->db->where('jenis_trans', 'PIJP');
        $this->db->delete('zhl_acc_tbl_trn_gst');

        //acc_tbl_trn_payable_recognition
        $this->db->where('HeaderID', $id);
        $this->db->delete('zhl_acc_tbl_trn_pi_dtl');

        //acc_tbl_trn_hutang
        $this->db->where('nofaktur', $id);
        $this->db->where('jenis_trans', 'PIJP');
        $this->db->delete('zhl_acc_tbl_trn_hutang');

        //acc_tbl_trn_hutang_bulanan
        $this->db->where('nofaktur', $id);
        $this->db->delete('zhl_acc_tbl_trn_hutang_bulanan');

        //fin_tbltrn_cashbank_journal_history
        $this->db->where('no_facture', $id);
        $this->db->delete('zhl_fin_tbltrn_cashbank_journal_history');
    }

    function get_gl($id)
    {
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

    function data_paling_bawah($nofaktur)
    {
        $sql_product = $this->db->query("SELECT DISTINCT Rate as rate,(SELECT SUM(Total) FROM `zhl_acc_tbl_trn_jurnal` WHERE NoJurnal = '$nofaktur' and JenisJurnalID = 'AR/GL') as Total, (SELECT SUM(Total * Rate) FROM `zhl_acc_tbl_trn_jurnal` WHERE NoJurnal = '$nofaktur' and NoUrut <> 0 and chk = 'D') as TotalDebet,
                          (SELECT SUM(Total * Rate) FROM `zhl_acc_tbl_trn_jurnal` WHERE NoJurnal = '$nofaktur' and NoUrut <> 0 and chk = 'C') as TotalCredit FROM `zhl_acc_tbl_trn_jurnal` WHERE NoJurnal = '$nofaktur' ");

        if ($sql_product->num_rows() > 0) {
            foreach ($sql_product->result() as $data) {
                $hasil[] = $data;
            }
            return $hasil;
        }
    }

    function insertCashBankHeaderx($data)
    {
        $this->db->trans_start();
        $this->db->insert('zhl_fin_tbltrn_cashbank_journal_header', $data);
        $headerID = $this->db->insert_id();
        $this->db->trans_complete();

        return $headerID;
    }

    function hapusCashBankHeader($id)
    {
        $this->db->where('no_reff', $id);
        $this->db->delete('zhl_fin_tbltrn_cashbank_journal_header');
    }

    function insertCashBankDetailx($data)
    {
        $this->db->insert('zhl_fin_tbltrn_cashbank_journal_detail', $data);
    }

    function hapusCashBankDetail($id)
    {
        $this->db->where('no_reff', $id);
        $this->db->delete('zhl_fin_tbltrn_cashbank_journal_detail');
    }

    function insertCBhistoryx($data)
    {
        $this->db->insert('zhl_fin_tbltrn_cashbank_journal_history', $data);
    }

    function hapusCashBankhistory($id)
    {
        $this->db->where('no_facture', $id);
        $this->db->delete('zhl_fin_tbltrn_cashbank_journal_history');
    }

    function insertDetailPOcbTransactionx($data)
    {
        $this->db->insert('zhl_fin_tbltrn_cashbank_journal_detail_po', $data);
    }

    function hapusDetailPOcbTransaction($id)
    {
        $this->db->where('po_id', $id);
        $this->db->delete('zhl_fin_tbltrn_cashbank_journal_detail_po');
    }


    function pilih_dp($id, $cur)
    {
        $this->db->select('*');
        $this->db->where('prepaid', '1');
        $this->db->where('suplier', $id);
        $this->db->where('currency_id', $cur);
        $sql_product = $this->db->get('zhl_fin_tbltrn_cashbank_journal_header');

        if ($sql_product->num_rows() > 0) {
            foreach ($sql_product->result() as $data) {
                $hasil[] = $data;
            }
            return $hasil;
        }
    }

    function update_pur_tbl_trn_gr_dtl($docno, $main, $itemid, $qtypi, $nofaktur)
    {
        $this->db->query("update `zhl_pur_tbl_trn_gr_dtl` set `qty_pi`='$qtypi', `id_jurnal` = '$nofaktur' where `docno`='$docno' and `itemid`='$itemid' and `mainpo`='$main'");
    }

    function update_dp_ar($id, $bayar_dp, $nofaktur)
    {
        $this->db->query('UPDATE `zhl_fin_tbltrn_cashbank_journal_header` SET `total_bayar` = `total_bayar` + ' . $bayar_dp . ', id_jurnal = ' . $nofaktur . ' WHERE header_id =' . $id);
    }


    function selectInvoiceforFindIV()
    {
        //$this->db->where('trans_type', 'AP');

        $this->db->limit('50');
        $this->db->where('jenis_trans', 'PIJP');
        $this->db->order_by('tanggal', 'Desc');
        $sql_product = $this->db->get('zhl_vw_acc_tbl_trn_hutang');

        return $sql_product;
    }
}
