<?php

class M_Payable_recognition extends CI_Model
{

    var $mst_supplier = 'zhl_pur_vw_mst_supplier';
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
        $qry = 'call zhl_sp_acc_tbl_trn_hutang(?, ?, ?,?,?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?, ?, ?, ?, ?, ?, ?, ?)';
        $this->db->query($qry, $data);
    }

    function call_sp_rec_hutang2($data)
    {
        $qry = 'call zhl_sp_acc_tbl_trn_hutang2(?, ?, ?,?,?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
        $this->db->query($qry, $data);
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

    function simpan_pr($det_item)
    {
        $this->db->insert('zhl_acc_tbl_trn_payable_recognition', $det_item);
    }

    function update_pr($id, $data)
    {
        $this->db->where('DetailID', $id);
        $this->db->update('zhl_acc_tbl_trn_payable_recognition', $data);
    }

    function simpan_jurnal($footer_purc)
    {
        $this->db->insert('zhl_acc_tbl_trn_jurnal', $footer_purc);
    }

    function update_jurnal($DetailID1, $footer_purc)
    {
        $this->db->where('DetailID', $DetailID1);
        $this->db->update('zhl_acc_tbl_trn_jurnal', $footer_purc);
    }

    function ambil_currency_date($kurs, $bln, $thn)
    {
        $bulan = $thn . "-" . $bln . '-' . "01";
        //$sql_product = $this->db->query("SELECT DISTINCT * FROM `acc_tbl_trn_kurs` WHERE periode <= '$bulan' and currency_id = '$kurs'");
        $sql_product = $this->db->query("SELECT * FROM zhl_acc_tbl_trn_kurs WHERE periode=(SELECT DISTINCT periode FROM zhl_acc_tbl_trn_kurs WHERE periode<='$bulan' ORDER BY periode DESC LIMIT 1) AND currency_id = '$kurs'");
        //$sql_product = $this->db->query("SELECT * FROM acc_tbl_trn_kurs WHERE  periode BETWEEN (SELECT DISTINCT periode FROM acc_tbl_trn_kurs WHERE periode<='$bulan' ORDER BY periode DESC LIMIT 1) AND '$bulan' AND currency_id = '$kurs'");
        if ($sql_product->num_rows() > 0) {
            foreach ($sql_product->result() as $data) {
                $hasil[] = $data;
            }
            return $hasil;
        }
    }

    function tampil_po_rate($cur, $date)
    {
        $date1 = date('Y-m-d', strtotime($date));
        $lastdate = date('Y-m-01', strtotime($date));
        $tempdate   = date('Y-m-01', strtotime($date1));
        $newdate = date('Y-m-t', strtotime("-1 months", strtotime($tempdate)));
        // $newdate = $tempdate;

        if ($date1 == $lastdate) {

            $query = " currency_id = '" . $cur . "' and periode = '" . $date . "'";
            $this->db->select('rate_usd');
            $this->db->select('rate_kurs');
            $this->db->where($query);
            $this->db->order_by('periode desc');
            $this->db->limit(1);


            $result = $this->db->get('zhl_acc_tbl_trn_kurs');
            if ($result->num_rows() > 0) {
                foreach ($result->result() as $data) {
                    $hasil[] = $data;
                }
                return $hasil;
            }
        } else {

            $query = " currency_id = '" . $cur . "' and periode BETWEEN '" . $newdate . "' AND '" . $date . "'";
            $this->db->select('rate_usd');
            $this->db->select('rate_kurs');
            $this->db->where($query);
            $this->db->order_by('periode desc');
            $this->db->limit(1);


            $result = $this->db->get('zhl_acc_tbl_trn_kurs');
            if ($result->num_rows() > 0) {
                foreach ($result->result() as $data) {
                    $hasil[] = $data;
                }
                return $hasil;
            }
        }
        //$query=" currency_id = '".$cur."' and periode <= '".$newdate."'";

    }

    function delete_item($id)
    {
        $this->db->where('DetailID', $id);
        $this->db->delete('zhl_acc_tbl_trn_payable_recognition');
    }

    function delete_jurnal($id)
    {
        $this->db->where('DetailID', $id);
        $this->db->delete('zhl_acc_tbl_trn_jurnal');
    }

    function get_list_hutang()
    {
        $this->db->where('jenis_trans', 'PRG');
        $this->db->where('YEAR(tanggal) >=', 2024);
        // $this->db->where('YEAR(tanggal)', 2025);
        $this->db->order_by('tanggal', 'DESC');
        // $this->db->limit('500');
        $sql_product = $this->db->get('zhl_vw_acc_tbl_trn_hutang');

        if ($sql_product->num_rows() > 0) {
            foreach ($sql_product->result() as $data) {
                $hasil[] = $data;
            }
            return $hasil;
        }
    }

    function advance_list_hutang1($invoice, $supplier)
    {
        $sql_product = $this->db->query("select * from zhl_vw_acc_tbl_trn_hutang WHERE jenis_trans='PRG' and kode_sup = '$supplier' and nofaktur like '%$invoice%'");

        if ($sql_product->num_rows() > 0) {
            foreach ($sql_product->result() as $data) {
                $hasil[] = $data;
            }
            return $hasil;
        }
    }

    function advance_list_hutang($dari, $sampai, $invoice, $supplier)
    {
        $sql_product = $this->db->query("select * from zhl_vw_acc_tbl_trn_hutang WHERE jenis_trans='PRG' and tanggal >= '$dari' and tanggal <= '$sampai' AND kode_sup like '%$supplier%' and nofaktur like '%$invoice%'");
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
        $sql_product = $this->db->get('zhl_acc_tbl_trn_hutang');

        if ($sql_product->num_rows() > 0) {
            foreach ($sql_product->result() as $data) {
                $hasil[] = $data;
            }
            return $hasil;
        }
    }

    function get_customer()
    {
        $this->db->where('notactive', 0);
        $sql_prov = $this->db->get('zhl_pur_vw_mst_supplier');
        if ($sql_prov->num_rows() > 0) {
            $result[''] = 'Select';
            foreach ($sql_prov->result_array() as $row) {
                $result[$row['supplierid'] . "|" . $row['nocoa']] = ucwords(strtoupper($row['suppliercompany']));
            }
            return $result;
        } else {
            echo "";
        }
    }
    
    function get_customernew()
    {
        $this->db->where('notactive', 0);
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

    function get_jeninv()
    {
        $sql = $this->db->get('zhl_acc_master_invoice');
        if ($sql->num_rows() > 0) {
            $result[''] = 'Select';
            foreach ($sql->result_array() as $row) {
                $result[$row['id_inv']] = ucwords(strtoupper($row['Jenis_inv']));
            }
            return $result;
        } else {
            echo "";
        }
    }

    function getbarge()
    {
        return $this->db->get('zhl_acc_master_barge')->result();
    }

    function getcarrier()
    {
        return $this->db->get('zhl_acc_master_carrier')->result();
    }


    //this for list record
    function get_sup()
    {
        $this->db->order_by('supplierid', 'ASC');
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

    function get_currency()
    {
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

    function get_currency_date($sekarang)
    {
        $this->db->limit('8');
        $this->db->where('periode <', $sekarang);
        $this->db->order_by('periode', 'DESC');
        $sql_prov = $this->db->get('zhl_acc_tbl_trn_kurs');
        if ($sql_prov->num_rows() > 0) {
            $result[''] = 'Select';
            foreach ($sql_prov->result_array() as $row) {
                $result[$row['rate_usd'] . "|" . $row['rate_kurs'] . "|" . $row['currency_id']] = ucwords(strtoupper($row['currency_id']));
            }
            return $result;
        } else {
            echo "";
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
        $this->db->join('zhl_acc_tbl_trn_payable_recognition b', 'b.headerid=a.nofaktur');
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
        $this->db->where('jenis_trans', 'PRG');
        $this->db->delete('zhl_acc_tbl_trn_jurnal');

        //acc_tbl_trn_hutang
        $this->db->where('nofaktur', $id);
        $this->db->where('jenis_trans', 'PRG');
        $this->db->delete('zhl_acc_tbl_trn_hutang');

        //acc_tbl_trn_hutang_bulanan
        $this->db->where('nofaktur', $id);
        $this->db->delete('zhl_acc_tbl_trn_hutang_bulanan');

        //acc_tbl_trn_payable_recognition
        $this->db->where('HeaderID', $id);
        $this->db->delete('zhl_acc_tbl_trn_payable_recognition');

        $this->db->where('ref_nomor', $id);
        $this->db->where('jenis_trans', 'PRG');
        $this->db->delete('zhl_acc_tbl_trn_gst');

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
        $sql_product = $this->db->get('zhl_acc_tbl_trn_payable_recognition');

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
        $this->db->where_not_in('JenisJurnalID', 'AP/GL');
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
        $this->db->select('SUM(Total) Total, SUM(Debet) as Debet, SUM(Kredit) as Kredit, DetailID, NoCOA, chk, Uraian, Rate');
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
        $this->db->where('jenis_trans', 'PRG');
        $this->db->delete('zhl_acc_tbl_trn_jurnal');
    }

    function delete_gst_lama($nojurnal)
    {
        $this->db->where('ref_nomor', $nojurnal);
        $this->db->where('jenis_trans', 'PRG');
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
        $this->db->where('JenisJurnalID <>', 'AP/GL');
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
        //acc_tbl_trn_jurnal
        $this->db->where('NoJurnal', $id);
        $this->db->where('jenis_trans', 'PRG');
        $this->db->delete('zhl_acc_tbl_trn_jurnal');

        //acc_tbl_trn_hutang
        $this->db->where('nofaktur', $id);
        $this->db->where('jenis_trans', 'PRG');
        $this->db->delete('zhl_acc_tbl_trn_hutang');

        //acc_tbl_trn_hutang_bulanan
        $this->db->where('nofaktur', $id);
        $this->db->delete('zhl_acc_tbl_trn_hutang_bulanan');

        //acc_tbl_trn_payable_recognition
        $this->db->where('HeaderID', $id);
        $this->db->delete('zhl_acc_tbl_trn_payable_recognition');
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
        // $sql_product = $this->db->query("SELECT DISTINCT Rate as rate,(SELECT SUM(Total) FROM `acc_tbl_trn_jurnal` WHERE NoJurnal = '$nofaktur' and JenisJurnalID = 'AP/GL') as Total, (SELECT SUM(Total * Rate) FROM `acc_tbl_trn_jurnal` WHERE NoJurnal = '$nofaktur' and NoUrut <> 0 and chk = 'D') as TotalDebet,
        //                   (SELECT SUM(Total * Rate) FROM `acc_tbl_trn_jurnal` WHERE NoJurnal = '$nofaktur' and NoUrut <> 0 and chk = 'C') as TotalCredit FROM `acc_tbl_trn_jurnal` WHERE NoJurnal = '$nofaktur' ");

        $sql_product = $this->db->query("SELECT * From zhl_acc_tbl_trn_hutang Where NoFaktur = '$nofaktur' and jenis_trans='PRG' ");

        if ($sql_product->num_rows() > 0) {
            foreach ($sql_product->result() as $data) {
                $hasil[] = $data;
            }
            return $hasil;
        }
    }

    function insertCashBankHeaderi($data)
    {
        $this->db->trans_start();
        $this->db->insert('fin_tbltrn_cashbank_journal_header', $data);
        $headerID = $this->db->insert_id();
        $this->db->trans_complete();

        return $headerID;
    }

    function hapusCashBankHeaderi($id)
    {
        $this->db->where('no_reff', $id);
        $this->db->delete('zhl_fin_tbltrn_cashbank_journal_header');
    }

    function insertCashBankDetaili($data)
    {
        $this->db->insert('zhl_fin_tbltrn_cashbank_journal_detail', $data);
    }

    function hapusCashBankDetaili($id)
    {
        $this->db->where('no_reff', $id);
        $this->db->delete('zhl_fin_tbltrn_cashbank_journal_detail');
    }

    function insertCBhistoryi($data)
    {
        $this->db->insert('zhl_fin_tbltrn_cashbank_journal_history', $data);
    }

    function insertCBhistoryites($data)
    {
        $this->db->insert('zhl_fin_tbltrn_cashbank_journal_history_test', $data);
    }

    function hapusCashBankhistoryi($id)
    {
        $this->db->where('no_facture', $id);
        $this->db->delete('zhl_fin_tbltrn_cashbank_journal_history');
    }

    function insertDetailPOcbTransactioni($data)
    {
        $this->db->insert('zhl_fin_tbltrn_cashbank_journal_detail_po', $data);
    }

    function hapusDetailPOcbTransactioni($id)
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

    function update_dp($id, $bayar_dp)
    {
        $this->db->query('UPDATE `zhl_fin_tbltrn_cashbank_journal_header` SET `bayar` = `bayar` + ' . $bayar_dp . ' WHERE detail_id =' . $id);
    }

    function selectInvoiceforFindPR()
    {
        $this->db->limit('1000');
        $this->db->where('jenis_trans', 'PRG');
        $this->db->order_by('tanggal', 'Desc');
        $sql_product = $this->db->get('zhl_vw_acc_tbl_trn_hutang');

        return $sql_product;
    }
}
