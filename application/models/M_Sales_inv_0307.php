<?php 
	
/**
* author : ITD16 ( F. Chaniago )
*/
class M_Sales_inv extends CI_Model
{
	function __construct() {
        parent::__construct();
        $this->db2 = $this->load->database('db2', TRUE);
    }

	function get_cust(){
		$sql_prov = $this->db->get('zhl_mar_tblmst_customer');
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

	function get_piutang(){
		 $bulan = date("m");
        $this->db->where('jenis_trans', 'SIJV');
        
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

	//===================== MODEL Untuk view ni ===================
	function get_data_header($id){
        $this->db->select('*');
        $this->db->from('zhl_vw_acc_tbl_trn_piutang');
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
        $sql_product = $this->db->get('zhl_vw_acc_tbl_trn_piutang');

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
        $sql_product = $this->db->get('zhl_acc_tbl_trn_si_fac_dtl_new');

        if ($sql_product->num_rows() > 0) {
            foreach ($sql_product->result() as $data) {
                $hasil[] = $data;
            }
            return $hasil;
        }
    }

    function get_dtlctr($id){
        $this->db->where('Jenis_trans', 'SIJV');
        $this->db->where('NoJurnal', $id);
        return $this->db->get('zhl_vw_acc_tbl_dtl_container')->result();
    }
	//---------------------      END view       -------------------

	// ================== MODEL CRUD DISINI YA ========================
	function hapus($nofaktur){
        $this->db->query("DELETE FROM zhl_acc_tbl_trn_jurnal where NoJurnal = '".$nofaktur."' AND jenis_trans = 'SIJV' ");
        $this->db->query("DELETE FROM zhl_acc_tbl_trn_si_fac_dtl_new where HeaderID = '".$nofaktur."'");
        $this->db->query("DELETE FROM zhl_acc_tbl_trn_gst WHERE ref_nomor = '".$nofaktur."' AND jenis_trans = 'SIJV' ");
    }

    function call_save_dtl($data){
        $qry = 'call zhl_spSaveSalesInvDtl(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
        $sql = $this->db->query($qry, $data);

        $sql->next_result();
        $sql->free_result();
    }

    function call_sp_rec_piutang($data) {
        // $this->db->begin();
        $qry = 'call zhl_sp_acc_tbl_trn_piutang_new(?, ?, ?,?,?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?)';
        $sql = $this->db->query($qry, $data);
        
        
        // $sql->next_result();
        // $sql->free_result();
    }

    function call_save_container_dtl($data){
    	$query  = 'call zhl_acc_cont_dtl(?, ?, ?, ?, ?, ?, ?)';
    	$sql = $this->db->query($query, $data);

    	$sql->next_result();
        $sql->free_result();
    }
	//==================        END CRUD      =========================

	
	// =================== MODEL AJAX DISINI YA =============================================
	function getAjaxTanggal($id, $bargedest){
        if(empty($id)){
            $sql_prov = $this->db2->query("SELECT DISTINCT shipmentdate FROM ship_vw_trn_cont Where shipmentdate < '2010-01-01'");
        }
        else
        {
            if($id == 'bar'){ 
            	$sql = " AND jurnal_barge_sales IS NULL "; 
            	if($bargedest == 'idn'){ 
            		$sql = $sql." AND (stuffing IS NULL OR stuffing = '') ";
            	}else if($bargedest == 'sin'){ 
            		$sql = $sql." AND (stuffing IS NOT NULL AND stuffing != '') ";
            	}else{
            		$sql = '';
            	}

            }
            else if($id == 'fre') { $sql = " AND jurnal_freight_sales IS NULL ";} 
            else if($id == 'trn') { $sql = " AND jurnal_transport_sales IS NULL ";}else{$sql="";}
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

    function get_isidetail($tgl, $supp, $inv, $port, $vessel){
        // $sql = " AND "
        if($inv == 'fre'){
            $sql_inv = " AND jurnal_freight_sales IS NULL ";
        }else if($inv == 'trn'){
            $sql_inv = " AND jurnal_transport_sales IS NULL";
        }else{
            $sql_inv = "";
        }

        $sql = "SELECT A.container_id, A.vessel, A.port, A.container_name, count(A.seal) AS jumlah_container FROM  ( SELECT DISTINCT container_id, vessel, port_name as port, container_name, seal from ship_vw_trn_cont where proses = 1 AND tipe = 2 AND port_id = " . $port . " AND customer_id = " . $supp . " AND shipmentdate = '" . $tgl . "' AND vessel = '".$vessel."' " . $sql_inv . " ) A GROUP BY A.container_id";

        // echo $sql;

        return $this->db2->query($sql)->result();


    }

    function get_isidetail_new($tgl, $supp, $inv, $port, $vessel){
        if($inv == 'fre'){
            $sql_inv = " AND jurnal_freight_sales IS NULL ";
        }else if($inv == 'trn'){
            $sql_inv = " AND jurnal_transport_sales IS NULL";
        }else{
            $sql_inv = "";
        }

        $sql = "SELECT DISTINCT contid, container_id, container_name, seal, container from ship_vw_trn_cont where proses = 1 AND tipe = 2 AND port_id = " . $port . " AND customer_id = " . $supp . " AND shipmentdate = '" . $tgl . "' AND vessel = '".$vessel."' " . $sql_inv . " ";

        // echo $sql;

        return $this->db2->query($sql)->result();

    }



    function get_isidetail3($tgl, $bargedest){
    	$sql = " AND jurnal_barge_sales IS NULL "; 
    	if($bargedest == 'idn'){ 
    		$sql = $sql." AND (stuffing IS NULL OR stuffing = '') ";
    		$stf = '';
    	}else if($bargedest == 'sin'){ 
    		$sql = $sql." AND (stuffing IS NOT NULL AND stuffing != '') ";
    		$stf = 'A.stuffing,';
    	}else{
    		$sql = '';
    		$stf = '';
    	}

    	$sqlite = "SELECT DISTINCT contid, container_id, container_name, seal, container
                FROM ship_vw_trn_cont where shipmentdate = '".$tgl."' AND tipe = 2 ".$sql;

        return $this->db2->query($sqlite)->result();
    }

    function get_isidetail2($tgl, $bargedest){

    	$sql = " AND jurnal_barge_sales IS NULL "; 
    	if($bargedest == 'idn'){ 
    		$sql = $sql." AND (stuffing IS NULL OR stuffing = '') ";
    		$stf = '';
    	}else if($bargedest == 'sin'){ 
    		$sql = $sql." AND (stuffing IS NOT NULL AND stuffing != '') ";
    		$stf = 'A.stuffing,';
    	}else{
    		$sql = '';
    		$stf = '';
    	}

        $sql1 = "SELECT A.contid, A.barge,A.container_id,  A.container_name, count(seal) AS Jumlah_container, A.eta, A.etd, A.etadate, A.etddate, A.stuffing  FROM (
                SELECT DISTINCT container_id as contid, TRIM(barge) AS barge, voyage, container_id, container_name, seal, etd, eta, etadate, etddate, stuffing 
                FROM ship_vw_trn_cont where shipmentdate = '".$tgl."' AND tipe = 2 ".$sql." ) A
                GROUP BY A.container_name, ".$stf." A.eta, A.etd";
         // echo $sql1;

        return $this->db2->query($sql1)->result();

        // $sql = " AND jurnal_barge_sales IS NULL "; 
    	// if($bargedest == 'idn'){ 
    	// 	$sql = $sql." AND (stuffing IS NULL OR stuffing = '') ";
    	// }else if($bargedest == 'sin'){ 
    	// 	$sql = $sql." AND (stuffing IS NOT NULL AND stuffing != '') ";
    	// }else{
    	// 	$sql = '';
    	// }

     //    $sql1 = "SELECT A.contid, A.barge,A.container_id,  A.container_name, count(seal) AS Jumlah_container, A.eta, A.etd, A.etadate, A.etddate, A.stuffing  FROM (
     //            SELECT DISTINCT container_id as contid, TRIM(barge) AS barge, voyage, container_id, container_name, seal, etd, eta, etadate, etddate, stuffing 
     //            FROM ship_vw_trn_cont where shipmentdate = '".$tgl."' AND tipe = 2 ".$sql." ) A
     //            GROUP BY A.container_name, A.stuffing, A.eta, A.etd, A.contid";
     //     // echo $sql1;

     //    return $this->db2->query($sql1)->result();
    }

    function get_sup($tgl, $id) {
        if($id == 'bar'){ $sql = " AND jurnal_barge_sales IS NULL ";} else if($id == 'fre') { $sql = " AND jurnal_freight_sales IS NULL ";} else if($id == 'trn') { $sql = " AND jurnal_transport_sales IS NULL ";}else{$sql="";}
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

    function get_port($tgl, $id, $buyer){
    	if($id == 'bar'){ $sql = " AND jurnal_barge_sales IS NULL ";} 
    	else if($id == 'fre') { $sql = " AND jurnal_freight_sales IS NULL ";} 
    	else if($id == 'trn') { $sql = " AND jurnal_transport_sales IS NULL ";}
    	else{$sql="";}
        $sql_prov =  $this->db2->query("SELECT port_id, port_name 
        	FROM ship_vw_trn_cont where tipe = 2 AND shipmentdate = '".$tgl."' AND customer_id = ".$buyer." ". $sql ." GROUP BY port_id ");
        if ($sql_prov->num_rows() > 0)
        {
            $result[''] = 'Select';
            foreach ($sql_prov->result_array() as $row) {
                $result[$row['port_id']] = ucwords(strtoupper($row['port_name']));
                //$result[$row['customer_code']] = ucwords(strtoupper($row['customer_name']));
            }    
            return $result;
        } 
        else 
        {
                echo "";
        }
    }

    function get_harga($idcon, $jenisinv){
        if($jenisinv == 1){ $sql = "cust_export_empty"; }
        else if($jenisinv == 2){ $sql = "cust_export_laden"; }
        else if($jenisinv == 3) { $sql = "cust_import_transhipment"; }
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

    function get_vessel($tgl, $supp, $inv, $port){
        if($inv == 'fre'){
            $sql_inv = " AND jurnal_freight_sales IS NULL ";
        }else if($inv == 'trn'){
            $sql_inv = " AND jurnal_transport_sales IS NULL";
        }else{
            $sql_inv = "";
        }

        $sql = "SELECT DISTINCT vessel from ship_vw_trn_cont where proses = 1 AND tipe = 2 AND port_id = " . $port . " AND customer_id = " . $supp . " AND shipmentdate = '" . $tgl . "' " . $sql_inv . " ";
        
        // echo $sql_prov;
        $sql_prov = $this->db->query($sql);
        if ($sql_prov->num_rows() > 0)
        {
            $result[''] = 'Select';
            foreach ($sql_prov->result_array() as $row) {
                $result[$row['vessel']] = ucwords(strtoupper($row['vessel']));
            }    
            return $result;
        } 
        else 
        {
                echo "";
        }


    }


	// ===================    END MODEL AJAX    =============================================




}
	

?>