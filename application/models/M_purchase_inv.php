<?php

//update date : 2 Dec 16 4,06 PM
//Update By : Ozzy


class M_purchase_inv extends CI_Model {

    var $mst_supplier = 'zhl_mar_vw_mst_customer';
    var $mst_currency = 'zhl_gen_tbl_mst_currency';
    var $acc_tbl_trn_hutang = 'zhl_acc_tbl_trn_hutang';
    var $acc_tbl_trn_jurnal = 'zhl_acc_tbl_trn_jurnal';
    var $acc_tbl_trn_hutang_bulanan = 'zhl_acc_tbl_trn_hutang_bulanan';

    function __construct() {
        parent::__construct();
        $this->db2 = $this->load->database('db2', TRUE);
    }

    function get_sup($tgl, $id) {
        if($id == 'bar'){ $sql = " AND jurnal_barge IS NULL ";} else if($id == 'fre') { $sql = " AND jurnal_freight IS NULL ";} else if($id == 'trn') { $sql = " AND jurnal_transport IS NULL ";}else{$sql="";}
        $sql_prov =  $this->db2->query("SELECT customer_id, customer_name, shipmentdate,barge  FROM ship_vw_trn_cont where tipe = 2 AND shipmentdate = '".$tgl."' ". $sql ." GROUP BY customer_id");
        if ($sql_prov->num_rows() > 0)
        {
            $result[''] = 'Select';
            foreach ($sql_prov->result_array() as $row) {
                $result[$row['customer_id'] . "|" . $row['barge']."|".$row['customer_name']] = ucwords(strtoupper($row['customer_name']));
                //$result[$row['customer_code']] = ucwords(strtoupper($row['customer_name']));
            }    
            return $result;
        } 
        else 
        {
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

    function supplier(){
        $this->db->where('notactive', 0);
        $this->db->select('supplierid, suppliercompany');
        $this->db->from('zhl_pur_tbl_mst_supplier');
        $sql = $this->db->get();
        if ($sql->num_rows() > 0) {
            $result[''] = 'Select';
            foreach ($sql->result_array() as $row) {
                $result[$row['supplierid']] = ucwords(strtoupper($row['suppliercompany']));
            }
            return $result;
        } else {
            echo "Not data avaible";
        }
    }

    function get_isidetail($tgl, $sup, $id){
        if($id == 'bar'){ $sql = " AND jurnal_barge IS NULL ";} else if($id == 'fre') { $sql = " AND jurnal_freight IS NULL ";} else if($id == 'trn') { $sql = " AND jurnal_transport IS NULL ";}else{$sql="";}
        $sql = $this->db2->query("SELECT * FROM ship_vw_trn_cont where tipe = 2 AND shipmentdate = '".$tgl."' AND customer_id = '".$sup."'".$sql);
        return $sql->result();
    }

    function get_isidetail2($tgl){
        $sql = "SELECT A.contid, A.barge,A.container_id,  A.container_name, count(seal) AS Jumlah_container, A.eta, A.etd, A.etadate, A.etddate  FROM (
                SELECT DISTINCT contid, TRIM(barge) AS barge, voyage, container_id, container_name, seal, etd, eta, etadate, etddate  
                FROM ship_vw_trn_cont where shipmentdate = '".$tgl."' AND tipe = 2) A
                GROUP BY A.container_name, A.eta, A.etd, A.contid";

        return $this->db2->query($sql)->result();
    }

    function tampil_po_rate($cur,$date){
        $date1 = date('Y-m-d', strtotime($date));
        $lastdate= date('Y-m-01',strtotime($date));
        $tempdate   = date('Y-m-01', strtotime($date));
        $newdate = date('Y-m-t', strtotime("-1 months", strtotime($tempdate)));
        
        if($date1==$lastdate)
        {
            $query=" currency_id = '".$cur."' and periode = '".$date."'";
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

        else{
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
    }

    function get_cust() {
        $this->db->where('status_customer', '1');
        $this->db->where('group_customer', '4');
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

    function get_list_hutang() {
        $this->db->where('jenis_trans', 'PIJV');
        $this->db->order_by('tanggal', 'Desc');
        $sql_product = $this->db->get('zhl_vw_acc_tbl_hutang_for_purchase');

        if ($sql_product->num_rows() > 0) {
            foreach ($sql_product->result() as $data) {
                $hasil[] = $data;
            }
            return $hasil;
        }
    }

    function getAjaxTanggal($id){
        // if($id == 1){$sql = "WHERE jurnal_barge is NULL ";}else if($id == 2){$sql = "WHERE jurnal_freight is NULL ";}else if($id == 3){$sql = "WHERE jurnal_transport is NULL ";}else{$sql = "";}
        if(empty($id)){
            $sql_prov = $this->db2->query("SELECT DISTINCT shipmentdate FROM ship_vw_trn_cont Where shipmentdate < '2010-01-01'");
        }
        else
        {
            if($id == 1){ $sql = " AND jurnal_barge IS NULL ";} else if($id == 2) { $sql = " AND jurnal_freight IS NULL ";} else if($id == 3) { $sql = " AND jurnal_transport IS NULL ";}else{$sql="";}
            $sql_prov = $this->db2->query("SELECT DISTINCT shipmentdate FROM ship_vw_trn_cont Where tipe = 2 ".$sql." AND shipmentdate > '2018-01-01'");
        }
        if ($sql_prov->num_rows() > 0) {
         
            $result[''] = 'Select';
            foreach ($sql_prov->result_array() as $s) {
                // echo $s['shipmentdate'];
                $sdate = new DateTime($s['shipmentdate']);
                $date_of_journal = date_format($sdate, 'd/m/Y');
                $result[$date_of_journal] = $date_of_journal;
            }
            return $result;
        } else {
            echo "";
        }
    }

    function hapus($nofaktur){
        $this->db->query("DELETE FROM zhl_acc_tbl_trn_jurnal where NoJurnal = '".$nofaktur."'");
        $this->db->query("DELETE FROM zhl_acc_tbl_trn_pi_fac_dtl where HeaderID = '".$nofaktur."'");
        $this->db->query("DELETE FROM zhl_acc_tbl_trn_gst WHERE ref_nomor = '".$nofaktur."'");
    }

    function call_sp_rec_hutang($data) {
        // $this->db->begin();
        $qry = 'call zhl_sp_acc_tbl_trn_hutang_new(?, ?, ?,?,?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
        $sql = $this->db->query($qry, $data);
        
        
        // $sql->next_result();
        // $sql->free_result();
    }

    function call_save_dtl($data){
        $qry = 'call zhl_spSavePurchaseInvDtl(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
        $sql = $this->db->query($qry, $data);

        $sql->next_result();
        $sql->free_result();
    }

    // function update_tlbpss($nofaktur, $dtlcont){
    //     $this->db->where('')
    // }
    // function simpan_inv(){
    //     $nofaktur = $this->input->post('nofaktur');
    //     $itemname_det = $this->input->post('det_items'); // array
    //     $itemid_det = $this->input->post('idcontainer');
    //     $unit_det = $this->input->post('unit');
    //     // $price_det = $this->input->;
    // }

    function get_data_header($id){
        $this->db->select('*');
        $this->db->from('zhl_vw_acc_tbl_hutang_for_purchase');
        $this->db->where('nofaktur', $id);
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

    function nota($id) {
        $this->db->select('*');
        $this->db->where('nofaktur', $id);
        $sql_product = $this->db->get('zhl_vw_acc_tbl_hutang_for_purchase');

        if ($sql_product->num_rows() > 0) {
            foreach ($sql_product->result() as $data) {
                $hasil[] = $data;
            }
            return $hasil;
        }
    }

    function get_data_detail($id) {
        $this->db->select('*');
        $this->db->where('HeaderID', $id);
        $sql_product = $this->db->get('zhl_acc_tbl_trn_pi_fac_dtl');

        if ($sql_product->num_rows() > 0) {
            foreach ($sql_product->result() as $data) {
                $hasil[] = $data;
            }
            return $hasil;
        }
    }

    //Tamabaha 19-04-2018
    function get_harga($idcon, $jenisinv){
        if($jenisinv == 1){ $sql = "vendor_export_empty"; }
        else if($jenisinv == 2){ $sql = "vendor_export_laden"; }
        else if($jenisinv == 3) { $sql = "vendor_import_transhipment"; }
        else{ $sql = "0";}

        $query = "SELECT ".$sql." FROM zhl_shp_tblmst_bargecharges WHERE container_id = '" .$idcon."' order by validity desc LIMIT 1 ";

        if($jenisinv > 0 AND $jenisinv < 4){
            $res = $this->db->query($query)->row();
            if(!empty($res)){
                return $res->$sql;
            }
            else
            {
                return 0;
            }
        }
        else{
            return 0;
        }
    }
}