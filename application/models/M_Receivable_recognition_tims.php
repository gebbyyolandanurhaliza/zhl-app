<?php

class M_Receivable_recognition_tims extends CI_Model {

    var $mst_supplier = 'zht_mar_vw_mst_customer';
    var $mst_currency = 'zhl_gen_tbl_mst_currency';
    var $acc_tbl_trn_piutang = 'zhl_acc_tbl_trn_piutang_tims';
    var $acc_tbl_trn_jurnal = 'zht_acc_tbl_trn_jurnal_tims';
    var $acc_tbl_trn_piutang_bulanan = 'zhl_acc_tbl_trn_piutang_bulanan_tims';

    function __construct() {
        parent::__construct();
    }

    function call_sp_rec_piutang($data) {
        $qry = 'call zhl_sp_acc_tbl_trn_piutang_rec_tims(?, ?, ?,?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
        $this->db->query($qry, $data);
    }

    function call_sp_rec_piutang_new($data) {
        $qry = 'call zhl_sp_acc_tbl_trn_piutang_rec_new_tims(?,?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
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
        $sql = $this->db->query("select MID(nofaktur, 4, 3) + 1 as nofaktur from zhl_acc_tbl_trn_piutang_tims where nofaktur like '%INV%' and year(tanggal) = '$tahun' order by nofaktur desc limit 1");
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
        $this->db->insert('zhl_acc_tbl_trn_receivable_recognition_tims', $det_item);
    }

    function update_pr($id, $data) {
        $this->db->where('DetailID', $id);
        $this->db->update('zhl_acc_tbl_trn_receivable_recognition_tims', $data);
    }

    function simpan_jurnal($footer_purc) {
        $this->db->insert('zht_acc_tbl_trn_jurnal_tims', $footer_purc);
    }

    function update_jurnal($DetailID1, $footer_purc) {
        $this->db->where('DetailID', $DetailID1);
        $this->db->update('zht_acc_tbl_trn_jurnal_tims', $footer_purc);
    }

    function delete_item($id) {
        $this->db->where('DetailID', $id);
        $this->db->delete('zhl_acc_tbl_trn_receivable_recognition_tims');
    }

    function delete_jurnal($id) {
        $this->db->where('DetailID', $id);
        $this->db->delete('zht_acc_tbl_trn_jurnal_tims');
    }

    function get_list_piutang() {
        $bulan = date("m");
        $this->db->where('jenis_trans', 'RRGT');
        
        //$this->db->where('MONTH(tanggal)', $bulan);
        //$this->db->order_by('tanggal', 'Desc');
        $sql_product = $this->db->get('zhl_vw_acc_tbl_trn_piutang_tims');

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
//        $this->db->where('jenis_trans', 'RRGT');
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
       $sql_product = $this->db->query("select * from zhl_vw_acc_tbl_trn_piutang_tims WHERE jenis_trans='RRGT' and kode_sup like '%$supplier%' and nofaktur like '%$invoice%'");

        if ($sql_product->num_rows() > 0) {
            foreach ($sql_product->result() as $data) {
                $hasil[] = $data;
            }
            return $hasil;
        }
    }

    function advance_list_piutang($dari, $sampai, $invoice, $supplier) {
        $sql_product = $this->db->query("select * from zhl_vw_acc_tbl_trn_piutang_tims WHERE jenis_trans = 'RRGT' and tanggal >= '$dari' and tanggal <= '$sampai' AND kode_sup like '%$supplier%' and nofaktur like '%$invoice%' ");
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
        $sql_product = $this->db->get('zhl_vw_acc_tbl_trn_piutang_tims');

        if ($sql_product->num_rows() > 0) {
            foreach ($sql_product->result() as $data) {
                $hasil[] = $data;
            }
            return $hasil;
        }
    }

    function get_customer_tims() {        
        $this->db->where('status_customer', 1);
        $this->db->order_by('customer_name', 'ASC');
        $sql_prov = $this->db->get('zht_mar_vw_mst_customer');
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

    function get_customer_tims_list() {        
        $this->db->where('status_customer', 1);
        $this->db->order_by('customer_name', 'ASC');
        $sql_prov = $this->db->get('zht_mar_vw_mst_customer');
        if ($sql_prov->num_rows() > 0) {
            $result[''] = 'Select';
            foreach ($sql_prov->result_array() as $row) {
                $result[$row['customer_code'] ] = ucwords(strtoupper($row['customer_name']));
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
        $sql_prov = $this->db->get('zht_mar_vw_mst_customer');
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
        $sql_product = $this->db->get('zhl_acc_tbl_trn_piutang_tims');

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
        $this->db->where('jenis_trans', 'RRGT');
        $this->db->delete('zht_acc_tbl_trn_jurnal_tims');

        //acc_tbl_trn_hutang
        $this->db->where('nofaktur', $id);
        $this->db->where('jenis_trans', 'RRGT');
        $this->db->delete('zhl_acc_tbl_trn_piutang_tims');

        //acc_tbl_trn_hutang_bulanan
        $this->db->where('nofaktur', $id);
        $this->db->where('jenis_trans', 'RRGT');
        $this->db->delete('zhl_acc_tbl_trn_piutang_bulanan_tims');

        //acc_tbl_trn_payable_recognition
        $this->db->where('HeaderID', $id);
        $this->db->delete('zhl_acc_tbl_trn_receivable_recognition_tims');

        // /acc_tbl_trn_gst
        $this->db->where('ref_nomor', $id);
        $this->db->where('jenis_trans', 'RRGT');
        $this->db->delete('zht_acc_tbl_trn_gst');
    }

    function hapus_coa_kosong() {
        $coa = array('0', '');
        $this->db->where_in('NoCOA', $coa);
        $this->db->or_where('Total', '0');
        $this->db->delete('zht_acc_tbl_trn_jurnal_tims');
    }

    function get_data_detail($id) {
        $this->db->select('*');
        $this->db->where('HeaderID', $id);
        $sql_product = $this->db->get('zhl_acc_tbl_trn_receivable_recognition_tims');

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
        $this->db->where('jenis_trans', 'RRGT');
        $this->db->where_not_in('JenisJurnalID', 'AR/GL');
        $sql_product = $this->db->get('zht_acc_tbl_trn_jurnal_tims');

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
        $sql_product = $this->db->get('zht_acc_tbl_trn_jurnal_tims');

        if ($sql_product->num_rows() > 0) {
            foreach ($sql_product->result() as $data) {
                $hasil[] = $data;
            }
            return $hasil;
        }
    }

    function delete_jurnal_lama($nojurnal) {
        $this->db->where('NoJurnal', $nojurnal);
        $this->db->where('jenis_trans', 'RRGT');
        $this->db->delete('zht_acc_tbl_trn_jurnal_tims');
    }

    function delete_gst_lama($nojurnal) {
        $this->db->where('ref_nomor', $nojurnal);
        $this->db->where('jenis_trans', 'RRGT');
        $this->db->delete('zht_acc_tbl_trn_gst');
    }

    function simpan_gst_payable($gst_item) {
        $this->db->insert('zht_acc_tbl_trn_gst', $gst_item);
    }

     function get_data_jurnal($no, $id, $jenis) {
        $data = array('AR/GL', 'Sales');
        $this->db->select('*');
        $this->db->where('NoJurnal', $id);
        $this->db->where('NoUrut', $no);
        $this->db->where('jenis_trans', $jenis);
        $this->db->where_not_in('JenisJurnalID', $data);
        $sql_product = $this->db->get('zht_acc_tbl_trn_jurnal_tims');

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
        $this->db->where('jenis_trans', 'RRGT');
        $this->db->delete('zht_acc_tbl_trn_jurnal_tims');

        //acc_tbl_trn_hutang
        $this->db->where('nofaktur', $id);
        $this->db->where('jenis_trans', 'RRGT');
        $this->db->delete('zhl_acc_tbl_trn_piutang_tims');

        //acc_tbl_trn_hutang_bulanan
        $this->db->where('nofaktur', $id);
        $this->db->where('jenis_trans', 'RRGT');
        $this->db->delete('zhl_acc_tbl_trn_piutang_bulanan_tims');

        //acc_tbl_trn_payable_recognition
        $this->db->where('HeaderID', $id);
        $this->db->delete('zhl_acc_tbl_trn_receivable_recognition_tims');
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

        $sql_product = $this->db->query("SELECT * From zhl_acc_tbl_trn_piutang_tims Where NoFaktur = '$nofaktur' and jenis_trans='RRGT' ");


        if ($sql_product->num_rows() > 0) {
            foreach ($sql_product->result() as $data) {
                $hasil[] = $data;
            }
            return $hasil;
        }
    }

    function insertCashBankHeaderx($data) {
        $this->db->trans_start();
        $this->db->insert('zht_fin_tbltrn_cashbank_journal_header', $data);
        $headerID = $this->db->insert_id();
        $this->db->trans_complete();

        return $headerID;
    }

    function hapusCashBankHeader($id) {
        $this->db->where('no_reff', $id);
        $this->db->delete('zhT_fin_tbltrn_cashbank_journal_header');
    }

    function insertCashBankDetailx($data) {
        $this->db->insert('zht_fin_tbltrn_cashbank_journal_detail', $data);
    }

    function hapusCashBankDetail($id) {
        $this->db->where('no_reff', $id);
        $this->db->delete('zht_fin_tbltrn_cashbank_journal_detail');
    }

    function insertCBhistoryx($data) {
        $this->db->insert('zht_fin_tbltrn_cashbank_journal_history', $data);
    }
    
    function hapusCashBankhistory($id) {
        $this->db->where('no_facture', $id);
        $this->db->delete('zht_fin_tbltrn_cashbank_journal_history');
    }

    function insertDetailPOcbTransactionx($data) {
        $this->db->insert('zht_fin_tbltrn_cashbank_journal_detail_po', $data);
    }
    
    function hapusDetailPOcbTransaction($id) {
        $this->db->where('po_id', $id);
        $this->db->delete('zht_fin_tbltrn_cashbank_journal_detail_po');
    }

    
    function pilih_dp($id, $cur){
        $this->db->select('*');
        $this->db->where('prepaid', '1');
        $this->db->where('suplier', $id);
        $sql_product = $this->db->get('zht_fin_tbltrn_cashbank_journal_header');

        if ($sql_product->num_rows() > 0) {
            foreach ($sql_product->result() as $data) {
                $hasil[] = $data;
            }
            return $hasil;
        }
    }
    
    function update_dp_ar($id, $bayar_dp) {
        $this->db->query('UPDATE `zht_fin_tbltrn_cashbank_journal_detail_po` SET `bayar` = `bayar` + ' . $bayar_dp . ' WHERE detail_id =' . $id);
    }

    function selectInvoiceforFindRR(){
        $this->db->where('jenis_trans', 'RRGT');
        $sql_product = $this->db->get('zhl_vw_acc_tbl_trn_piutang_tims');

        return $sql_product;
    }

    function call_cek_sp_rec_piutang($supp, $currency, $periode) {
        $sql = $this->db->query("call zhl_sp_acc_rpt_receivable_aging_inv('$supp', '$currency', '$periode')");
        $res = $sql->result();
        $sql->next_result();
        $sql->free_result();
        return $res;
    }

    function get_nofaktur($tahun, $bulan)
    {
       
        $sql = "SELECT CAST(SUBSTR(nofaktur, 14, 4) AS UNSIGNED) as urut
            FROM zhl_acc_tbl_trn_piutang_tims
            WHERE YEAR(tanggal) = '$tahun' AND MONTH(tanggal) = '$bulan'
            ORDER BY CAST(SUBSTR(nofaktur, 14, 4) AS UNSIGNED) DESC
            LIMIT 1";

        $query = $this->db->query($sql)->row();

        if (empty($query)) {
            $no = "ZHT/" . $tahun . "/" . str_pad($bulan, 2, '0', STR_PAD_LEFT) . "/0001";
        } else {
            $n = $query->urut + 1;
            $n = str_pad($n, 4, '0', STR_PAD_LEFT);
            $no = "ZHT/" . $tahun . "/" . str_pad($bulan, 2, '0', STR_PAD_LEFT) . "/" . $n;
        }

        return $no;
    }

    public function save_file($data)
    {
        // $this->db->insert('zht_receivable_recognition_file', $data);
        // return $this->db->affected_rows();
        log_message('debug', 'Data yang akan disimpan: ' . print_r($data, true));
    
        $this->db->insert('zht_receivable_recognition_file', $data);
        return $this->db->affected_rows();
    }

    public function list_attach($nota)
    {
        $this->db->select('*');
        $this->db->from('zht_receivable_recognition_file');
        $this->db->where('no_faktur', $nota);
        return $this->db->get()->result();
    }

    public function delete_file($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('zht_receivable_recognition_file');
    }
//-----------------------------------------------------------ABOUT Mon-------------------------------------------------------------------
    function receivable_recognition_zht_filter($from,$to,$customer,$item,$invtype){
        $cust_array = explode(',', $customer);
        $item_array = explode(',', $item);
        $query="tanggal between '".$from."' and '".$to."'";
        if (!empty($customer)){
            $cust_list = "'" . implode("','", $cust_array) . "'";
            $query= $query." and kode_sup in ($cust_list) ";
        }
        if (trim($invtype) != ""){$query= $query." and jenis_inv ='".$invtype."'";}

        if (!empty($item)){
            $item_list = "'" . implode("','", $item_array) . "'";
            $query= $query." and no_po in ($item_list) ";
        }
        
        $this->db->where($query);
        $this->db->order_by('nofaktur');
        $result=  $this->db->get('zht_vw_acc_tbl_trn_receivable_recognition');
        return $result->result();
    }


    public function item_rrg_customer($id)
    {
        $this->db->select('dtl.price_item,dtl.item_id,dtl.sort_num,item.*');
        $this->db->from('zhl_tims_mst_customer_dtl_item as dtl');
        $this->db->join('zhl_tims_mst_item as item', 'dtl.item_id = item.Id', 'left');
        $this->db->join('zhl_tims_mst_customer as cust', 'dtl.customer_id = cust.customer_id', 'left');
        $this->db->join('zhl_acc_master_new_coa as coa', 'item.Income_coa = coa.NoCOA');
        $this->db->where('cust.customer_code', $id);
        $this->db->order_by('dtl.sort_num', 'asc');
        return $this->db->get()->result();
    }

    public function item_rrg()
    {
        $this->db->select('item.*');
        $this->db->from('zhl_tims_mst_item as item');
        return $this->db->get()->result();
    }

}
