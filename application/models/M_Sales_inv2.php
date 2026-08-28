<?php

/**
 * author : ITD16 ( F. Chaniago )
 */
class M_Sales_inv2 extends CI_Model
{
  function __construct()
  {
    parent::__construct();
    $this->db2 = $this->load->database('db2', TRUE);
  }

  function get_cust()
  {
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
  
  function get_piutang()
  {
    $tahuN = date("Y");
    $this->db->where('jenis_trans', 'SIJV');

    $this->db->where('YEAR(tanggal)', $tahuN);
    $this->db->order_by('tanggal', 'Desc');
    $sql_product = $this->db->get('zhl_vw_acc_tbl_trn_piutang');

    if ($sql_product->num_rows() > 0) {
      foreach ($sql_product->result() as $data) {
        $hasil[] = $data;
      }
      return $hasil;
    }
  }

  function advance_list_piutang1($invoice, $supplier) {
        $sql_product = $this->db->query("select * from zhl_vw_acc_tbl_trn_piutang WHERE jenis_trans='SIJV' and kode_sup like '%$supplier%' and nofaktur like '%$invoice%'");
 
         if ($sql_product->num_rows() > 0) {
             foreach ($sql_product->result() as $data) {
                 $hasil[] = $data;
             }
             return $hasil;
         }
     }
 
     function advance_list_piutang($dari, $sampai, $invoice, $supplier) {
         $sql_product = $this->db->query("select * from zhl_vw_acc_tbl_trn_piutang WHERE jenis_trans='SIJV' and tanggal >= '$dari' and tanggal <= '$sampai' AND kode_sup like '%$supplier%' and nofaktur like '%$invoice%'");
         if ($sql_product->num_rows() > 0) {
             foreach ($sql_product->result() as $data) {
                 $hasil[] = $data;
             }
             return $hasil;
         }
     }

  function get_total($id)
  {
    return $this->db->query("SELECT rate,rate_sgd, SUM(amount) AS JUMLAH FROM zhl_acc_tbl_trn_si_fac_dtl_new WHERE HeaderID='$id'")->result();
  }

  //===================== MODEL Untuk view ni ===================
  function get_data_header($id)
  {
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


  function nota($id)
  {
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

  // function get_data_detail($id)
  // {
  //   $this->db->select('*');
  //   $this->db->from('zhl_acc_tbl_trn_si_fac_dtl_new as a');
  //   $this->db->join('zhl_vw_new_coa_dept_code as b', 'b.NoCOA = a.NoCOA and a.dept_code=b.kode_department');
  //   $this->db->where('HeaderID', $id);
  //   return $this->db->get()->result();
  // }
  

//gebby
  function get_data_detail($id)
{
    $this->db->select('*');
    $this->db->from('zhl_acc_tbl_trn_si_fac_dtl_new as a');
    $this->db->join('zhl_vw_new_coa_dept_code as b', 'b.NoCOA = a.NoCOA AND a.dept_code=b.kode_department');
    $this->db->where('HeaderID', $id);

    // 🔹 Pastikan urut berdasarkan DetailID ASC
    $this->db->order_by('a.DetailID', 'ASC');

    return $this->db->get()->result();
}

  function get_data_detail_old($id)
  {
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

  //kode lama
  // public function get_data_detail_bargefreight($id)
  // {
  //   $this->db->select('*');
  //   $this->db->from('zhl_acc_tbl_trn_si_fac_dtl_new as a');
  //   $this->db->join('zhl_shp_bargefreight_dtl as b', 'b.bargefreight_dtl_id = a.ItemID');
  //   $this->db->where('HeaderID', $id);
  //   return $this->db->get()->result();
  // }


  //gebby
  // public function get_data_detail_bargefreight($id)
  // {
  //     $sql = "
  //         SELECT a.*, b.*
  //         FROM zhl_shp_bargefreight_dtl b
  //         JOIN zhl_acc_tbl_trn_si_fac_dtl_new a
  //             ON a.ItemID = b.bargefreight_dtl_id
  //         WHERE a.HeaderID = ?
  //         ORDER BY

  //         CASE
  //             WHEN a.type_barge = 'Export Laden' THEN 1
  //             WHEN a.type_barge = 'Local Laden' THEN 2
  //             WHEN a.type_barge = 'Export Empty' THEN 3
  //             ELSE 4
  //         END ASC,

  //         CASE
  //             WHEN b.description LIKE '%Freight T/S%' THEN 1
  //             WHEN b.description LIKE '%Freight Laden%' THEN 2
  //             WHEN b.description LIKE '%Freight MT%' THEN 3
  //             WHEN b.description LIKE '%EBS%' THEN 4
  //             WHEN b.description LIKE '%Stevedorage%' THEN 5
  //             WHEN b.description LIKE '%Trucking%' THEN 6
  //             WHEN b.description LIKE '%TFS%' THEN 7
  //             WHEN b.description LIKE '%DFS%' THEN 8
  //             ELSE 9
  //         END ASC,

  //         CASE
  //             WHEN b.pod LIKE '%SINGAPORE%' THEN 1
  //             WHEN b.pod LIKE '%GUNTUNG%' THEN 2
  //             WHEN b.pod LIKE '%PULAU BURUNG%' THEN 3
  //             ELSE 4
  //         END ASC,

  //        b.bargefreight_dtl_id ASC
  //     ";

  //     return $this->db->query($sql, array($id))->result();
  // }

public function get_data_detail_bargefreight($id)
{
    $sql = "
        SELECT a.*, b.*
        FROM zhl_shp_bargefreight_dtl b
        JOIN zhl_acc_tbl_trn_si_fac_dtl_new a
            ON a.ItemID = b.bargefreight_dtl_id
        WHERE a.HeaderID = ?
        ORDER BY

        /* grouping type barge */
        CASE
            WHEN a.type_barge = 'Export Laden' THEN 1
            WHEN a.type_barge = 'Local Laden'  THEN 2
            WHEN a.type_barge = 'Export Empty' THEN 3
            ELSE 4
        END ASC,

        /* sorting description per type barge */
        CASE
            /* EXPORT LADEN */
            WHEN a.type_barge = 'Export Laden'
                 AND b.description LIKE '%Freight T/S%'    THEN 1
            WHEN a.type_barge = 'Export Laden'
                 AND b.description LIKE '%Freight Laden%'  THEN 2
            WHEN a.type_barge = 'Export Laden'
                 AND b.description LIKE '%Freight MT%'     THEN 3
            WHEN a.type_barge = 'Export Laden'
                 AND b.description LIKE '%EBS%'            THEN 4

            /* LOCAL LADEN */
            WHEN a.type_barge = 'Local Laden'
                 AND b.description LIKE '%Stevedorage%'    THEN 1
            WHEN a.type_barge = 'Local Laden'
                 AND b.description LIKE '%Freight Laden%'  THEN 2
            WHEN a.type_barge = 'Local Laden'
                 AND b.description LIKE '%EBS%'            THEN 3
            WHEN a.type_barge = 'Local Laden'
                 AND b.description LIKE '%Freight MT%'     THEN 4

            /* EXPORT EMPTY */
            WHEN a.type_barge = 'Export Empty'
                 AND b.description LIKE '%Freight MT%'     THEN 1
            WHEN a.type_barge = 'Export Empty'
                 AND b.description LIKE '%Freight T/S%'    THEN 2
            WHEN a.type_barge = 'Export Empty'
                 AND b.description LIKE '%EBS%'            THEN 3

            /* lainnya (berlaku untuk semua type) */
            WHEN b.description LIKE '%Trucking%' THEN 5
            WHEN b.description LIKE '%TFS%'      THEN 6
            WHEN b.description LIKE '%DFS%'      THEN 7

            ELSE 99
        END ASC,

        /* sorting pod */
        CASE
            WHEN b.pod LIKE '%SINGAPORE%'    THEN 1
            WHEN b.pod LIKE '%GUNTUNG%'      THEN 2
            WHEN b.pod LIKE '%PULAU BURUNG%' THEN 3
            ELSE 4
        END ASC,

        b.bargefreight_dtl_id ASC
    ";

    return $this->db->query($sql, array($id))->result();
}
  ///end gebby

  function get_data_detail2($id)
  {
    $sql = $this->db->query("SELECT A.ItemName as invno, A.amount, zhl_productinv(A.ItemName) as prod, ponumberinv(A.ItemName) as po_num, A.description FROM zhl_acc_tbl_trn_si_fac_dtl_new A where A.HeaderID = '" . $id . "' ");
    $fre = $sql->result();
    return $fre;
  }
  function get_data_detailtet($id)
  {
    $sql = $this->db->query("SELECT A.ItemName as invno, A.amount, zhl_productinv(A.ItemName) as prod, ponumberinv(A.ItemName) as po_num, A.description FROM zhl_acc_tbl_trn_si_fac_dtl_new A where A.HeaderID = '" . $id . "' ");
    $fre = $sql->result();
    return $fre;
  }

  function get_dtlctr($id)
  {
    $this->db->where('Jenis_trans', 'SIJV');
    $this->db->where('NoJurnal', $id);
    $this->db->where('localcont', 0);
    return $this->db->get('zhl_vw_acc_tbl_dtl_container')->result();
  }

  function get_dtlctrtruck($id)
  {
    $this->db->where('Jenis_trans', 'SIJV');
    $this->db->where('NoJurnal', $id);
    $this->db->where('localcont', 0);
    return $this->db->get('zhl_vw_acc_tbl_dtl_container_trucking')->result();
  }

  function get_dtlctr_new($id)
  {
    $this->db->where('Jenis_trans', 'SIJV');
    $this->db->where('NoJurnal', $id);

    return $this->db->get('zhl_vw_acc_tbl_dtl_container')->result();
  }

  function get_dtlctr2($id)
  {
    $this->db->where('Jenis_trans', 'SIJV');
    $this->db->where('NoJurnal', $id);
    $this->db->where('localcont', 1);
    return $this->db->get('zhl_vw_acc_tbl_dtl_container')->result();
  }
  function get_dtlctr2truck($id)
  {
    $this->db->where('Jenis_trans', 'SIJV');
    $this->db->where('NoJurnal', $id);
    $this->db->where('localcont', 1);
    return $this->db->get('zhl_vw_acc_tbl_dtl_container_trucking')->result();
  }
  //---------------------      END view       -------------------

  // ================== MODEL CRUD DISINI YA ========================
  function get_nofaktur($tahun, $bulan)
  {
    // $sql = "SELECT nofaktur FROM zhl_acc_tbl_trn_piutang where jenis_trans = 'SIJV' AND YEAR(tanggal) = '$tahun' orde";
    // in ('SIJV', 'RRG')//
    $sql = "SELECT CAST(SUBSTR(nofaktur, 3, 4) AS UNSIGNED) as urut
                FROM zhl_acc_tbl_trn_piutang
                where YEAR(tanggal) = '$tahun' and jenis_trans in ('SIJV', 'RRG') ORDER BY CAST(SUBSTR(nofaktur, 3, 4) as UNSIGNED) DESC LIMIT 1";
    // echo $sql;
    $query = $this->db->query($sql)->row();
    if (empty($query)) {
      $no = "ZH0001/" . $bulan . "/" . $tahun;
    } else {
      $n = $query->urut;
      $n = $n + 1;
      $n = str_pad($n, 4, '0', STR_PAD_LEFT);
      $no = "ZH" . $n . "/" . $bulan . "/" . $tahun;
    }

    return $no;
  }

  function hapus($nofaktur)
  {
    $this->db->query("DELETE FROM zhl_acc_tbl_trn_jurnal where NoJurnal = '" . $nofaktur . "' AND jenis_trans = 'SIJV' ");
    $this->db->query("DELETE FROM zhl_acc_tbl_trn_si_fac_dtl_new where HeaderID = '" . $nofaktur . "'");
    $this->db->query("DELETE FROM zhl_acc_tbl_trn_gst WHERE ref_nomor = '" . $nofaktur . "' AND jenis_trans = 'SIJV' ");
    $this->db->query("DELETE FROM zhl_acc_tbl_trn_dtl_container WHERE NoJurnal = '" . $nofaktur . "' AND jenis_trans = 'SIJV' ");
    $this->db->query("DELETE FROM zhl_acc_tbl_trn_dtl_container_trucking WHERE NoJurnal = '" . $nofaktur . "' AND jenis_trans = 'SIJV' ");
  }

  function delete_all($nofaktur)
  {
    $sql = $this->db->query("SELECT * FROM zhl_acc_tbl_trn_arpaymentdtl where NoInvoice = '" . $nofaktur . "'")->result();
    if (empty($sql)) {
      echo "1";
      $this->db->trans_start();
      $this->db->query("UPDATE zhl_acc_tbl_trn_piutang SET piutang = '0', Keterangan = 'cancel' WHERE nofaktur = '" . $nofaktur . "' AND jenis_trans = 'SIJV' ");
      $this->db->query("UPDATE ship_tbl_trn_cont_dtl SET jurnal_barge_sales = NULL WHERE jurnal_barge_sales = '" . $nofaktur . "'");
      $this->db->query("UPDATE ship_tbl_trn_cont_dtl SET jurnal_chinashipment_sales = NULL WHERE jurnal_chinashipment_sales = '" . $nofaktur . "'");
      $this->db->query("UPDATE ship_tbl_trn_cont_local_dtl SET bargejurnal = NULL WHERE bargejurnal = '" . $nofaktur . "'");
      $this->db->query("UPDATE ship_tbl_trn_cont_dtl SET jurnal_trucking = NULL WHERE jurnal_trucking = '" . $nofaktur . "'");
      $this->db->query("UPDATE ship_tbl_trn_cont_local_dtl SET jurnal_trucking = NULL WHERE jurnal_trucking = '" . $nofaktur . "'");
      $this->db->query("DELETE FROM zhl_acc_tbl_trn_jurnal where NoJurnal = '" . $nofaktur . "' AND jenis_trans = 'SIJV' ");
      $this->db->query("DELETE FROM zhl_acc_tbl_trn_si_fac_dtl_new where HeaderID = '" . $nofaktur . "'");
      $this->db->query("DELETE FROM zhl_acc_tbl_trn_gst WHERE ref_nomor = '" . $nofaktur . "' AND jenis_trans = 'SIJV' ");
      $this->db->query("DELETE FROM zhl_acc_tbl_trn_dtl_container WHERE NoJurnal = '" . $nofaktur . "' AND jenis_trans = 'SIJV' ");
      $this->db->query("DELETE FROM zhl_acc_tbl_trn_dtl_container_trucking WHERE NoJurnal = '" . $nofaktur . "' AND jenis_trans = 'SIJV' ");
      $this->db->query("DELETE FROM zhl_acc_tbl_trn_piutang_bulanan WHERE nofaktur = '" . $nofaktur . "' AND jenis_trans = 'SIJV' ");
      $this->db->trans_complete();
    } else {
      echo "2";
    }
  }

  function call_save_dtl($data)
  {
    $qry = 'call zhl_spSaveSalesInvDtl(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
    $sql = $this->db->query($qry, $data);

    $sql->next_result();
    $sql->free_result();
  }

  function call_sp_rec_piutang($data)
  {
    $qry = 'call zhl_sp_acc_tbl_trn_piutang_new_new(?, ?, ?,?,?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?, ?, ?, ?,?,?)';
    $sql = $this->db->query($qry, $data);
  }

  function call_save_container_dtl($data)
  {
    $query  = 'call zhl_acc_cont_dtl(?, ?, ?, ?, ?, ?, ?)';
    $sql = $this->db->query($query, $data);
    $sql->next_result();
    $sql->free_result();
  }

  function call_save_container_dtl2($data)
  {
    $query  = 'call zhl_acc_cont_dtl2(?, ?, ?, ?, ?, ?, ?)';
    $sql = $this->db->query($query, $data);

    $sql->next_result();
    $sql->free_result();
  }

  function call_save_container_dtl_truck($data)
  {
    $query  = 'call zhl_acc_cont_dtl_truck(?, ?, ?, ?, ?, ?, ?)';
    $sql = $this->db->query($query, $data);

    $sql->next_result();
    $sql->free_result();
  }

  function call_save_container_dtl2_truck($data)
  {
    $query  = 'call zhl_acc_cont_dtl2_truck(?, ?, ?, ?, ?, ?, ?)';
    $sql = $this->db->query($query, $data);

    $sql->next_result();
    $sql->free_result();
  }
  //==================        END CRUD      =========================


  // =================== MODEL AJAX DISINI YA =============================================

  // function get_tanggal_barge_charges($id, $bargedest)
  // {
  //     if (empty($id)) {
  //         $sql_prov = $this->db2->query("SELECT DISTINCT shipmentdate FROM ship_vw_trn_cont Where shipmentdate < '2010-01-01'");
  //     } else {


  //         $this->db->distinct();
  //         $this->db->select('shipmentdate');
  //         $this->db->from('ship_tbl_trn_cont_hdr as a');
  //         $this->db->join('ship_tbl_trn_cont_dtl as b', 'b.contid = a.contid');



  //         if ($id == 'bar') {
  //             $etda = '';
  //             $sql = " AND (jurnal_barge_sales IS NULL OR jurnal_barge_sales = '') ";
  //             if ($bargedest == 'idn' || $bargedest == 'idn2') {
  //                 $sql = $sql . " AND (stuffing IN ('EE', 'IT')) ";
  //                 if ($bargedest == 'idn') {
  //                     $sql = $sql . " AND etd = 'PSG' ";
  //                     $etda = " AND etd = 'PSG' ";
  //                 } else {
  //                     $sql = $sql . " AND etd = 'RSUP' ";
  //                     $etda = " AND etd = 'RSUP' ";
  //                 }
  //             } else if ($bargedest == 'sin' || $bargedest == 'sin2') {
  //                 $sql = $sql . " AND (stuffing IN ('EL', 'IL') ) ";
  //                 if ($bargedest == 'sin') {
  //                     $sql = $sql . " AND etd = 'PSG' ";
  //                     $etda = " AND eta = 'PSG' ";
  //                 } else {
  //                     $sql = $sql . " AND etd = 'RSUP' ";
  //                     $etda = " AND eta = 'RSUP' ";
  //                 }
  //             } else {
  //                 $sql = '';
  //             }
  //         }
  //         // else if($id == 'fre') { $sql = " AND jurnal_freight_sales IS NULL ";}
  //         // else if($id == 'trn') { $sql = " AND jurnal_transport_sales IS NULL ";}else{$sql="";}
  //         $a = "SELECT DISTINCT shipmentdate FROM ship_vw_trn_cont Where tipe = 2 " . $sql . " AND shipmentdate > '2022-01-01'
  //                 UNION
  //               SELECT DISTINCT shipmentdate FROM ship_vw_container_local2 where shipmentdate > '2022-01-01' AND bargejurnal IS NULL AND stuffing = 'LL' " . $etda;
  //         // echo $a;
  //         $sql_prov = $this->db2->query("SELECT DISTINCT shipmentdate FROM ship_vw_trn_cont Where tipe = 2 " . $sql . " AND shipmentdate > '2022-01-01'
  //                 UNION
  //               SELECT DISTINCT shipmentdate FROM ship_vw_container_local2 where shipmentdate > '2022-01-01' AND bargejurnal IS NULL AND stuffing IN ('LL','LO') " . $etda);
  //     }

  //     if ($sql_prov->num_rows() > 0) {

  //         $result[''] = 'Select';
  //         foreach ($sql_prov->result_array() as $s) {
  //             // echo $s['shipmentdate'];
  //             $sdate = new DateTime($s['shipmentdate']);
  //             $date_of_journal = date_format($sdate, 'd/m/Y');
  //             $result[$date_of_journal] = $date_of_journal;
  //         }
  //         return $result;
  //     } else {
  //         echo "";
  //     }
  // }



  function getAjaxTanggal($id, $bargedest)
  {
    if (empty($id)) {
      $sql_prov = $this->db2->query("SELECT DISTINCT shipmentdate FROM ship_vw_trn_cont_get_tanggal Where shipmentdate < '2010-01-01'");
    } else {

      if ($id == 'bar') {
        $etda = '';
        $sql = " AND (jurnal_barge_sales IS NULL OR jurnal_barge_sales = '') ";
        if ($bargedest == 'idn' || $bargedest == 'idn2') {
          $sql = $sql . " AND (stuffing IN ('EE', 'IT', 'ITDP')) ";
          if ($bargedest == 'idn') {
            $sql = $sql . " AND etd = 'PSG' ";
            $etda = " AND etd = 'PSG' ";
          } else {
            $sql = $sql . " AND etd = 'RSUP' ";
            $etda = " AND etd = 'RSUP' ";
          }
        } else if ($bargedest == 'sin' || $bargedest == 'sin2') {
          $sql = $sql . " AND (stuffing IN ('EL', 'IL','LE') ) ";
          if ($bargedest == 'sin') {
            $sql = $sql . " AND etd = 'PSG' ";
            $etda = " AND eta = 'PSG' ";
          } else {
            $sql = $sql . " AND etd = 'RSUP' ";
            $etda = " AND eta = 'RSUP' ";
          }
        } else {
          $sql = '';
        }
      }
      // else if($id == 'fre') { $sql = " AND jurnal_freight_sales IS NULL ";}
      // else if($id == 'trn') { $sql = " AND jurnal_transport_sales IS NULL ";}else{$sql="";}
      $a = "SELECT DISTINCT shipmentdate FROM ship_vw_trn_cont_get_tanggal Where tipe = 2 " . $sql . " AND shipmentdate > '2022-01-01'
                    UNION
                  SELECT DISTINCT shipmentdate FROM ship_vw_container_local2 where shipmentdate > '2022-01-01' AND bargejurnal IS NULL AND stuffing = 'LL' " . $etda;
      // echo $a;
      $sql_prov = $this->db2->query("SELECT DISTINCT shipmentdate FROM ship_vw_trn_cont_get_tanggal Where tipe = 2 " . $sql . " AND shipmentdate > '2022-01-01'
                    UNION
                  SELECT DISTINCT shipmentdate FROM ship_vw_container_local2 where shipmentdate > '2022-01-01' AND bargejurnal IS NULL AND stuffing IN ('LL','LO') " . $etda);
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

  function getVoyage($tgl_shipment, $vessel)
  {
    $this->db->select('voyage_no');
    $this->db->from('zhl_shp_bargefreight_hdr');
    $this->db->where('ship_board_date', $tgl_shipment);
    $this->db->where('vesel', $vessel);
    $this->db->where('deleted_at', NULL);
    $this->db->group_by('voyage_no');

    return $this->db->get()->result();
  }

  function getAjaxTanggal2($id, $bargedest)
  {
    $cari = 0;
    $sql = '';
    if (empty($id)) {
      $sql_prov = $this->db2->query("SELECT DISTINCT shipmentdate FROM ship_vw_trn_cont_get_tanggal Where shipmentdate < '2010-01-01'");
    } else {
      if ($id == 'lem') {
        $sql = " AND bargejurnal IS NULL ";
        if ($bargedest == 'idn' || $bargedest == 'idn2') {
          $cari = 1;
          $sql = $sql . " AND stuffing = 'LE' ";
          if ($bargedest == 'idn') {
            $sql = $sql . " AND etd = 'PSG' ";
          } else {
            $sql = $sql . " AND etd = 'RSUP' ";
          }
        } else {
          $sql = '';
        }
      } else if ($id == 'eim') {
        $sql = " AND bargejurnal IS NULL ";
        if ($bargedest == 'idn' || $bargedest == 'idn2') {
          $cari = 1;
          $sql = $sql . " AND stuffing = 'EI' ";
          if ($bargedest == 'idn') {
            $sql = $sql . " AND etd = 'PSG' ";
          } else {
            $sql = $sql . " AND etd = 'RSUP' ";
          }
        } else {
          $sql = '';
        }
      }


      $a = "SELECT DISTINCT shipmentdate FROM ship_vw_container_local2 Where shipmentdate > '2022-01-01' " . $sql;
      if ($cari == 1) {
        $sql_prov = $this->db2->query("SELECT DISTINCT shipmentdate FROM ship_vw_container_local2 Where shipmentdate > '2022-01-01' " . $sql);
      } else {
        $sql_prov = $this->db2->query("SELECT DISTINCT shipmentdate FROM ship_vw_trn_cont_get_tanggal Where shipmentdate < '2010-01-01'");
      }
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


  // function getAjaxTanggaltet($id, $bargedest){
  //     $cari = 0;
  //     $sql = '';
  //     if(empty($id)){
  //         $sql_prov = $this->db2->query("SELECT DISTINCT shipmentdate FROM ship_vw_trn_cont Where shipmentdate < '2010-01-01'");
  //     }
  //     else
  //     {
  //         if ($id == 'tet'){
  //             $sql = " AND bargejurnal IS NULL ";
  //             if($bargedest == 'idn' || $bargedest == 'idn2'){
  //                 $cari = 1;
  //                 $sql = $sql." AND stuffing = 'ELTP' ";
  //                 if($bargedest == 'idn'){
  //                     $sql = $sql." AND etd = 'PSG' ";
  //                 }else{
  //                     $sql = $sql." AND etd = 'RSUP' ";
  //                 }
  //             }
  //             else{
  //                 $sql = '';
  //             }
  //         }

  //         $a = "SELECT DISTINCT shipmentdate FROM ship_vw_container_local2 Where shipmentdate > '2018-01-01' ".$sql;
  //         if($cari == 1){
  //             $sql_prov = $this->db2->query("SELECT DISTINCT shipmentdate FROM ship_vw_container_local2 Where shipmentdate > '2018-01-01' ".$sql);
  //         }else{
  //             $sql_prov = $this->db2->query("SELECT DISTINCT shipmentdate FROM ship_vw_trn_cont Where shipmentdate < '2010-01-01'");
  //         }
  //     }
  //     if ($sql_prov->num_rows() > 0) {

  //         $result[''] = 'Select';
  //         foreach ($sql_prov->result_array() as $s) {
  //             // echo $s['shipmentdate'];
  //             $sdate = new DateTime($s['shipmentdate']);
  //             $date_of_journal = date_format($sdate, 'd/m/Y');
  //             $result[$date_of_journal] = $date_of_journal;
  //         }
  //         return $result;
  //     } else {
  //         echo "";
  //     }
  // }

  function getAjaxTanggaltet($id, $bargedest)
  {
    if (empty($id)) {
      $sql_prov = $this->db2->query("SELECT DISTINCT shipmentdate FROM ship_vw_trn_cont_get_tanggal Where shipmentdate < '2010-01-01'");
    } else {

      if ($id == 'chinaShipment') {
        $etda = '';
        $sql = " AND (jurnal_chinaShipment_sales IS NULL OR jurnal_chinaShipment_sales = '') ";
        if ($bargedest == 'idn' || $bargedest == 'idn2') {
          $sql = $sql . " AND (stuffing IN ('ELCN','EECN', 'ITCN', 'ITCNDP')) ";
          if ($bargedest == 'idn') {
            $sql = $sql . " AND etd = 'PSG' ";
            $etda = " AND etd = 'PSG' ";
          } else {
            $sql = $sql . " AND etd = 'RSUP' ";
            $etda = " AND etd = 'RSUP' ";
          }
        } else if ($bargedest == 'sin' || $bargedest == 'sin2') {
          $sql = $sql . " AND (stuffing IN ('ELCN','EECN', 'ITCN', 'ITCNDP') ) ";
          if ($bargedest == 'sin') {
            $sql = $sql . " AND etd = 'PSG' ";
            $etda = " AND eta = 'PSG' ";
          } else {
            $sql = $sql . " AND etd = 'RSUP' ";
            $etda = " AND eta = 'RSUP' ";
          }
        } else {
          $sql = '';
        }
      } 
      // else if($id == 'fre') { $sql = " AND jurnal_freight_sales IS NULL ";}
      // else if($id == 'trn') { $sql = " AND jurnal_transport_sales IS NULL ";}else{$sql="";}
      $a = "SELECT DISTINCT shipmentdate FROM ship_vw_trn_cont_get_tanggal Where tipe = 2 " . $sql . " AND shipmentdate > '2022-01-01'
                    UNION
                  SELECT DISTINCT shipmentdate FROM ship_vw_container_local2 where shipmentdate > '2022-01-01' AND bargejurnal IS NULL AND stuffing = 'LLTP' " . $etda;
      // echo $a;
      $sql_prov = $this->db2->query("SELECT DISTINCT shipmentdate FROM ship_vw_trn_cont_get_tanggal Where tipe = 2 " . $sql . " AND shipmentdate > '2022-01-01'
                    UNION
                  SELECT DISTINCT shipmentdate FROM ship_vw_container_local2 where shipmentdate > '2022-01-01' AND bargejurnal IS NULL AND stuffing IN ('LLTP') " . $etda);
                  // var_dump($sql_prov);
                  // die;
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

  public function get_shipmentdate_barge()
  {
    $this->db->select('ship_board_date');
    $this->db->from('zhl_shp_bargefreight_hdr');
    $this->db->where('deleted_at', null);
    $this->db->where('deleted_by', null);
    $this->db->group_by('ship_board_date');

    $data = $this->db->get();

    if ($data->num_rows() > 0) {

      $result[''] = 'Select';
      foreach ($data->result_array() as $s) {
        $sdate = new DateTime($s['ship_board_date']);
        $date_of_journal = date_format($sdate, 'd/m/Y');
        $result[$date_of_journal] = $date_of_journal;
      }
      return $result;
    } else {
      echo "";
    }
  }

  public function get_dtl_bargefreight($shp_date, $sup, $vessel, $voyage_no)
  {
    $this->db->select('*');
    $this->db->from('zhl_shp_vw_detail_bargefreight_new');
    $this->db->where('ship_board_date', $shp_date);
    $this->db->where('vesel', $vessel);
    $this->db->where('voyage_no', $voyage_no);
    $this->db->where('deleted_at', null);

    if ($sup != '') {
      $this->db->where('customer_code', $sup);
    }
    return $this->db->get()->result();
  }

  function get_isidetail($tgl, $supp, $inv, $port, $vessel)
  {
    // $sql = " AND "
    if ($inv == 'fre') {
      $sql_inv = " AND jurnal_freight_sales IS NULL ";
    } else if ($inv == 'trn') {
      $sql_inv = " AND jurnal_transport_sales IS NULL";
    } else {
      $sql_inv = "";
    }

    $sql = "SELECT A.container_id, A.vessel, A.port, A.container_name, count(A.seal) AS jumlah_container FROM  ( SELECT DISTINCT container_id, vessel, port_name as port, container_name, seal from ship_vw_trn_cont where proses = 1 AND tipe = 2 AND port_id = " . $port . " AND customer_id = " . $supp . " AND shipmentdate = '" . $tgl . "' AND vessel = '" . $vessel . "' " . $sql_inv . " ) A GROUP BY A.container_id";

    // echo $sql;

    return $this->db2->query($sql)->result();
  }

  function get_isidetail_new($tgl, $supp, $inv, $port, $vessel)
  {
    if ($inv == 'fre') {
      $sql_inv = " AND jurnal_freight_sales IS NULL ";
    } else if ($inv == 'trn') {
      $sql_inv = " AND jurnal_transport_sales IS NULL";
    } else {
      $sql_inv = "";
    }

    $sql = "SELECT DISTINCT contid, container_id, container_name, seal, container from ship_vw_trn_cont where proses = 1 AND tipe = 2 AND port_id = " . $port . " AND customer_id = " . $supp . " AND shipmentdate = '" . $tgl . "' AND vessel = '" . $vessel . "' " . $sql_inv . " ";

    // echo $sql;

    return $this->db2->query($sql)->result();
  }

  function get_2ft($tgl, $bargedest, $sup)
  {
    $tbl_pss = (strtoupper(trim($sup)) === 'G00178') ? 'ship_vw_trn_cont_ggfs' : 'ship_vw_trn_cont';
    if ($bargedest == 'sin' || $bargedest == 'sin2') {
      $sql = " AND (jurnal_barge_sales IS NULL OR jurnal_barge_sales = '') AND (jurnal_chinaShipment_sales IS NULL OR jurnal_chinaShipment_sales = '') AND jurnal_trucking IS NULL ";
      $sql = $sql . " AND (stuffing IN ('EL','ELCN','IL')) ";
      $stf = 'A.stuffing,';
      if ($bargedest == 'sin') {
        $sql = $sql . " AND etd = 'PSG' ";
      } else {
        $sql = $sql . " AND etd = 'RSUP' ";
      }

      $sql1 = "SELECT container_size, count(container) AS Jumlah_container FROM (
                SELECT DISTINCT container_id as contid, TRIM(barge) AS barge, actual_seal, container_size, container
                FROM ". $tbl_pss . " where container != '' AND container_size in (20, 40, '20 reefer', '40 reefer') AND shipmentdate = '" . $tgl . "' AND tipe = 2 " . $sql . " ) A
                GROUP BY container_size";

      return $this->db2->query($sql1)->result();
    } else {
      $sql = " AND (jurnal_barge_sales IS NULL OR jurnal_barge_sales = '') AND (jurnal_chinaShipment_sales IS NULL OR jurnal_chinaShipment_sales = '') AND jurnal_trucking IS NULL ";
      $sql = $sql . " AND (stuffing IN ('EE','EECN')) ";
      $stf = 'A.stuffing,';
      if ($bargedest == 'idn') {
        $sql = $sql . " AND etd = 'PSG' ";
      } else {
        $sql = $sql . " AND etd = 'RSUP' ";
      }

      $sql1 = "SELECT container_size, count(container) AS Jumlah_container FROM (
                SELECT DISTINCT container_id as contid, TRIM(barge) AS barge, actual_seal, container_size, container
                FROM ". $tbl_pss . " where container != '' AND container_size in (20, 40, '20 reefer', '40 reefer') AND shipmentdate = '" . $tgl . "' AND tipe = 2 " . $sql . " ) A
                GROUP BY container_size";

      return $this->db2->query($sql1)->result();
    }
  }

  function get_2ftTET($tgl, $bargedest)
  {
    if ($bargedest == 'sin' || $bargedest == 'sin2') {
      $sql = " AND (jurnal_chinaShipment_sales IS NULL OR jurnal_chinaShipment_sales = '') AND jurnal_trucking IS NULL ";
      $sql = $sql . " AND (stuffing IN ('EECN')) ";
      $stf = 'A.stuffing,';
      if ($bargedest == 'sin') {
        $sql = $sql . " AND eta = 'PSG' ";
      } else {
        $sql = $sql . " AND eta = 'RSUP' ";
      }
      $sql1 = "SELECT container_size, count(po_number) AS Jumlah_container FROM (
                SELECT DISTINCT container_id as contid, TRIM(barge) AS barge, actual_seal,po_number, container_size, container
                FROM ship_vw_trn_cont where  container_size in (20, 40, '20 reefer', '40 reefer') AND shipmentdate = '" . $tgl . "'  " . $sql . " ) A
                GROUP BY container_size";

      return $this->db2->query($sql1)->result();
    } else {
      $sql = " AND (jurnal_chinaShipment_sales IS NULL OR jurnal_chinaShipment_sales = '') AND jurnal_trucking IS NULL ";
      $sql = $sql . " AND (stuffing IN ('EECN')) ";
      $stf = 'A.stuffing,';
      if ($bargedest == 'idn') {
        $sql = $sql . " AND etd = 'PSG' ";
      } else {
        $sql = $sql . " AND etd = 'RSUP' ";
      }
      $sql1 = "SELECT container_size, count(po_number) AS Jumlah_container FROM (
                SELECT DISTINCT container_id as contid, TRIM(barge) AS barge, actual_seal,po_number, container_size, container
                FROM ship_vw_trn_cont where container_size in (20, 40, '20 reefer', '40 reefer') AND shipmentdate = '" . $tgl . "'" . $sql . " ) A
                GROUP BY container_size";

      return $this->db2->query($sql1)->result();
    }
  }

  function get_2ftTET2($tgl, $bargedest)
  {
    $sql = " AND bargejurnal IS NULL AND jurnal_trucking IS NULL ";
    if ($bargedest == 'idn' || $bargedest == 'idn2') {
      $sql = $sql . " AND (stuffing IN ('LLTP')) ";
      $stf = '';
      if ($bargedest == 'idn') {
        $sql = $sql . " AND etd = 'PSG' ";
      } else {
        $sql = $sql . " AND etd = 'RSUP' ";
      }
    } else if ($bargedest == 'sin' || $bargedest == 'sin2') {
      $sql = $sql . " AND (stuffing IN ('LLTP')) ";
      $stf = 'A.stuffing,';
      if ($bargedest == 'sin') {
        $sql = $sql . " AND eta = 'PSG' ";
      } else {
        $sql = $sql . " AND eta = 'RSUP' ";
      }
    }
    $sqlit = " SELECT  count(A.contid) AS Jumlah_container, A.container_size
             FROM (
        SELECT container_id as contid, container_size FROM ship_vw_container_local2
        where container_number != '' AND container_size in (20, 40, '20 reefer', '40 reefer')  AND shipmentdate = '" . $tgl . "' " . $sql . " ) A
        GROUP BY A.container_size ";
    // echo $sqlit;
    return $this->db2->query($sqlit)->result();
  }

  function get_isidetail2($tgl, $bargedest, $sup)
  {
    $tbl_pss = (strtoupper(trim($sup)) === 'G00178') ? 'ship_vw_trn_cont_ggfs' : 'ship_vw_trn_cont';
    $sql = " AND (jurnal_barge_sales IS NULL OR jurnal_barge_sales = '') AND (jurnal_chinaShipment_sales IS NULL OR jurnal_chinaShipment_sales = '') ";
    if ($bargedest == 'idn' || $bargedest == 'idn2') {
      $sql = $sql . " AND (stuffing IN ('EE','IT','IL','RE','ELTP','ITCN','EECN', 'ITCNDP', 'ITDP')) ";
      $stf = '';
      if ($bargedest == 'idn') {
        $sql = $sql . " AND etd = 'PSG' ";
      } else {
        $sql = $sql . " AND etd = 'RSUP' "; 
      }
      // antara etd dan eta masih ada kebingungan, karena ada yang isi etd PSG dan eta RSUP
    } else if ($bargedest == 'sin' || $bargedest == 'sin2') {
      $sql = $sql . " AND (stuffing IN ('EL', 'IL', 'ELCN')) ";
      $stf = 'A.stuffing,';
      if ($bargedest == 'sin') {
        $sql = $sql . " AND etd = 'PSG' ";
      } else {
        $sql = $sql . " AND etd = 'RSUP' ";
      }
    } else {
      $sql = '';
      $stf = '';
    }

    if ($sql != '') {
      $sql1 = "SELECT A.contid, A.barge,A.container_id,  A.container_name, count(seal) AS Jumlah_container, A.eta, A.etd, A.etadate, A.etddate, A.stuffing  FROM (
                SELECT DISTINCT container_id as contid, TRIM(barge) AS barge, voyage, container as container_id, container_name, seal, etd, eta, etadate, etddate,
                CASE WHEN stuffing = 'EE_TP' THEN 'EE' ELSE stuffing END as stuffing
                FROM " . $tbl_pss . " where container != '' AND shipmentdate = '" . $tgl . "' AND tipe = 2 " . $sql . " ) A
                GROUP BY A.container_name, A.stuffing";
      return $this->db2->query($sql1)->result();
    }
  }

  function get_isidetailTET($tgl, $bargedest, $sup)
  {
    $tbl_pss = (strtoupper(trim($sup)) === 'G00178') ? 'ship_vw_trn_cont_ggfs' : 'ship_vw_trn_cont';
    $sql = " AND (jurnal_barge_sales IS NULL OR jurnal_barge_sales = '') AND (jurnal_chinaShipment_sales IS NULL OR jurnal_chinaShipment_sales = '') ";
    if ($bargedest == 'idn' || $bargedest == 'idn2') {
      $sql = $sql . " AND (stuffing IN ('EECN','ITCN', 'ITCNDP')) ";
      $stf = '';
      if ($bargedest == 'idn') { //  || $bargedest == 'idn2'
        // $sql = $sql . " AND etd = 'PSG' "; dibalik, karena etd PSG / RSUP tidak ada, adanya ETD Singapore
        $sql = $sql . " AND etd = 'PSG' ";
      } else {
        $sql = $sql . " AND etd = 'RSUP' ";
      }
    } else if ($bargedest == 'sin' || $bargedest == 'sin2') { // di outward tidak memerlukan itcn. cc : ms Jannah
      $sql = $sql . " AND (stuffing IN ('EECN','ITCN', 'ITCNDP')) ";
      $stf = 'A.stuffing,';
      if ($bargedest == 'sin') {
        $sql = $sql . " AND eta = 'PSG' ";
      } else {
        $sql = $sql . " AND eta = 'RSUP' ";
      }
    } else {
      $sql = '';
      $stf = '';
    }
    
    if ($sql != '') {
      $sql1 = "SELECT A.contid, A.barge,A.container_id,  A.container_name, count(po_number) AS Jumlah_container, A.eta, A.etd, A.etadate, A.etddate, A.stuffing  FROM (
                SELECT DISTINCT container_id as contid, TRIM(barge) AS barge, voyage, container as container_id, container_name, seal,po_number, etd, eta, etadate, etddate,
                -- CASE WHEN stuffing = 'EE_TP' THEN 'EE' ELSE stuffing END as
                stuffing
                FROM " . $tbl_pss . " where  shipmentdate = '" . $tgl . "'" . $sql . " ) A
                GROUP BY A.container_name, A.stuffing";
                
      //  echo $sql1;
      //   FROM ship_vw_trn_cont where container != '' AND shipmentdate = '" . $tgl . "' AND tipe = 2 " . $sql . " ) A
      return $this->db2->query($sql1)->result();
    }

  }

  function get_isidetailTET2($tgl, $bargedest, $sup)
  {
    $tbl_pss = (strtoupper(trim($sup)) === 'G00178') ? 'ship_vw_container_local2_ggfs' : 'ship_vw_container_local2';
    $invtype = $this->input->get('invtype');
    $sql = "";
    $sql = " AND bargejurnal IS NULL ";
    $sql = $sql . " AND stuffing in ('LLTP') ";
    if ($bargedest == 'idn' || $bargedest == 'idn2') {
      $stf = '';
      if ($bargedest == 'idn') {
        // $sql = $sql . " AND etd = 'PSG' "; dibalik, karena etd PSG / RSUP tidak ada, adanya ETD Singapore
        $sql = $sql . " AND etd = 'PSG' ";
      } else {
        $sql = $sql . " AND etd = 'RSUP' ";
      }
    } else if ($bargedest == 'sin' || $bargedest == 'sin2') {
      $stf = '';
      if ($bargedest == 'sin') {
        $sql = $sql . " AND eta = 'PSG' ";
      } else {
        $sql = $sql . " AND eta = 'RSUP' ";
      }
    } else {
      $sql = '';
    }
    if ($sql != "") {
      $sqlit = " SELECT A.contid, A.container_id, A.container_name, count(A.container_name) AS Jumlah_container, A.eta, A.etd, A.etadate, A.etddate, A.stuffing    FROM (
            SELECT container_id as contid, container_number as container_id, container_type as container_name, etd, eta, etadate, etddate, stuffing FROM " . $tbl_pss . "
            where container_number != '' AND shipmentdate = '" . $tgl . "' " . $sql . " ) A
            GROUP BY A.container_name, A.stuffing ";
      // echo $sqlit;
      return $this->db2->query($sqlit)->result();
    }
  }


  function get_2ftdetail($tgl, $bargedest)
  {
    // echo 1;
    if ($bargedest == 'sin' || $bargedest == 'sin2') {
      $sql = " AND (jurnal_barge_sales IS NULL OR jurnal_barge_sales = '') AND jurnal_trucking IS NULL ";
      $sql = $sql . " AND (stuffing IN ('EL', 'IL')) ";
      $stf = 'A.stuffing,';
      if ($bargedest == 'sin') {
        $sql = $sql . " AND etd = 'PSG' ";
      } else {
        $sql = $sql . " AND etd = 'RSUP' ";
      }
      $sqlite = "SELECT DISTINCT contid, container_id, container_name, seal, container, stuffing
                FROM ship_vw_trn_cont where container != '' AND container_size in (20, 40, '20 reefer', '40 reefer') AND shipmentdate = '" . $tgl . "' AND tipe = 2 " . $sql;

      // echo $sql1;
      return $this->db2->query($sqlite)->result();
    } else {
      $sql = " AND (jurnal_barge_sales IS NULL OR jurnal_barge_sales = '') AND jurnal_trucking IS NULL ";
      // $sql = $sql." AND (stuffing IN ('EL', 'IL')) ";
      $sql = $sql . " AND (stuffing IN ('EE','EE_TP')) ";
      $stf = 'A.stuffing,';
      if ($bargedest == 'idn') {
        $sql = $sql . " AND etd = 'PSG' ";
      } else {
        $sql = $sql . " AND etd = 'RSUP' ";
      }
      
      $sqlite = "SELECT DISTINCT contid, container_id, container_name, seal, container, stuffing
                FROM ship_vw_trn_cont where container != '' AND container_size in (20, 40, '20 reefer', '40 reefer') AND shipmentdate = '" . $tgl . "' AND tipe = 2 " . $sql;
      // echo $sqlite;
      return $this->db2->query($sqlite)->result();
    }
  }

  function get_isidetail3($tgl, $bargedest)
  {
    $sql = " AND (jurnal_barge_sales IS NULL OR jurnal_barge_sales = '') ";
    if ($bargedest == 'idn' || $bargedest == 'idn2') {
      $sql = $sql . " AND (stuffing IN ('EE','IL','IT','LC','RE','ELTP','EECN','ELCN','ITCN', 'ITCNDP', 'ITDP')) ";
      $stf = '';
      if ($bargedest == 'idn') {
        $sql = $sql . " AND etd = 'PSG' ";
      } else {
        $sql = $sql . " AND etd = 'RSUP' ";
      }
    } else if ($bargedest == 'sin' || $bargedest == 'sin2') {
      $sql = $sql . " AND (stuffing IN ('EL', 'IL')) ";
      $stf = 'A.stuffing,';
      if ($bargedest == 'sin') {
        $sql = $sql . " AND eta = 'PSG' ";
      } else {
        $sql = $sql . " AND eta = 'RSUP' ";
      }
    } else {
      $sql = '';
      $stf = '';
    }
    if ($sql != '') {
      $sqlite = "SELECT DISTINCT contid, container_id, container_name, seal, container, stuffing
                FROM ship_vw_trn_cont where container != '' AND shipmentdate = '" . $tgl . "' AND tipe = 2 " . $sql;

      return $this->db2->query($sqlite)->result();
    }
  }
  function get_isilclcontdtltet($tgl, $bargedest)
  {
    $sql = " AND (jurnal_barge_sales IS NULL OR jurnal_barge_sales = '') ";
    if ($bargedest == 'idn' || $bargedest == 'idn2') {
      $sql = $sql . " AND (stuffing IN ('EECN','ITCN', 'ITCNDP')) ";
      $stf = '';
      if ($bargedest == 'idn') {
        $sql = $sql . " AND etd = 'PSG' ";
      } else {
        $sql = $sql . " AND etd = 'RSUP' ";
      }
    } else if ($bargedest == 'sin' || $bargedest == 'sin2') {
      $sql = $sql . " AND (stuffing IN ('EECN','ITCN', 'ITCNDP')) ";
      $stf = 'A.stuffing,';
      if ($bargedest == 'sin') {
        $sql = $sql . " AND eta = 'PSG' ";
      } else {
        $sql = $sql . " AND eta = 'RSUP' ";
      }
    } else {
      $sql = '';
      $stf = '';
    }
    if ($sql != '') {
      $sqlite = "SELECT DISTINCT contid, container_id, container_name, seal, container, stuffing
                FROM ship_vw_trn_cont where container != '' AND shipmentdate = '" . $tgl . "' AND tipe = 2 " . $sql;

      return $this->db2->query($sqlite)->result();
    }
  }


  function get_2ft2($tgl, $bargedest, $sup)
  {
    $sql = " AND bargejurnal IS NULL AND jurnal_trucking IS NULL ";
    if ($bargedest == 'idn' || $bargedest == 'idn2') {
      $sql = $sql . " AND (stuffing IN ('LL')) ";
      $stf = '';
      if ($bargedest == 'idn') {
        $sql = $sql . " AND etd = 'PSG' ";
      } else {
        $sql = $sql . " AND etd = 'RSUP' ";
      }
    } else if ($bargedest == 'sin' || $bargedest == 'sin2') {
      $sql = $sql . " AND (stuffing IN ('LL')) ";
      $stf = 'A.stuffing,';
      if ($bargedest == 'sin') {
        $sql = $sql . " AND eta = 'PSG' ";
      } else {
        $sql = $sql . " AND eta = 'RSUP' ";
      }
    }
    
    $sqlit = " SELECT  count(A.contid) AS Jumlah_container, A.container_size
             FROM (
        SELECT container_id as contid, container_size FROM ship_vw_container_local2
        where container_number != '' AND container_size in (20, 40, '20 reefer', '40 reefer') AND customer = '" . $sup . "' AND shipmentdate = '" . $tgl . "' " . $sql . " ) A
        GROUP BY A.container_size ";
    // echo $sqlit;
    return $this->db2->query($sqlit)->result();
  }

  function get_isilclcont($tgl, $bargedest, $sup)
  {
    $sql = " AND bargejurnal IS NULL ";
    if ($bargedest == 'idn' || $bargedest == 'idn2') {
      $sql = $sql . " AND (stuffing IN ('LL','LO')) ";
      $stf = '';
      if ($bargedest == 'idn') {
        $sql = $sql . " AND etd = 'PSG' ";
      } else {
        $sql = $sql . " AND etd = 'RSUP' ";
      }
    } else if ($bargedest == 'sin' || $bargedest == 'sin2') {
      $sql = $sql . " AND (stuffing IN ('LL','LO', 'LE')) ";
      $stf = 'A.stuffing,';
      if ($bargedest == 'sin') {
        $sql = $sql . " AND eta = 'PSG' ";
      } else {
        $sql = $sql . " AND eta = 'RSUP' ";
      }
    } else {
      $sql = '';
      $stf = '';
    }

    if ($sql != "") {
      $sqlit = " SELECT A.contid, A.container_id, A.container_name, count(A.container_name) AS Jumlah_container, A.eta, A.etd, A.etadate, A.etddate, A.stuffing    FROM (
                SELECT container_id as contid, container_number as container_id, container_type as container_name, etd, eta, etadate, etddate, stuffing FROM ship_vw_container_local2
                where container_number != '' AND customer = '" . $sup . "' AND shipmentdate = '" . $tgl . "' " . $sql . " ) A
                GROUP BY A.container_name, A.stuffing ";
      // echo $sqlit;
      return $this->db2->query($sqlit)->result();
    }
  }

  function get_2ft3($tgl, $bargedest)
  {
    $invtype = $this->input->get('invtype');
    $sql = "";
    if ($bargedest == 'idn' || $bargedest == 'idn2') {
      $sql = " AND bargejurnal IS NULL AND jurnal_trucking IS NULL ";
      $sql = $sql . " AND stuffing = 'EI' ";
      $stf = '';
      if ($bargedest == 'idn') {
        $sql = $sql . " AND etd = 'PSG' ";
      } else {
        $sql = $sql . " AND etd = 'RSUP' ";
      }
    } else {
      $sql = '';
      $stf = '';
    }


    if ($sql != "") {
      $sqlit = " SELECT count(A.contid) AS Jumlah_container, A.container_size    FROM (
            SELECT container_id as contid, container_size FROM ship_vw_container_local2
            where container_number != '' AND container_size in (20,40, '20 reefer', '40 reefer') AND shipmentdate = '" . $tgl . "' " . $sql . " ) A
            GROUP BY A.container_size ";
      // echo $sqlit;
      return $this->db2->query($sqlit)->result();
    }
  }



  function get_isilclcont2($tgl, $bargedest)
  {
    $invtype = $this->input->get('invtype');
    $sql = "";
    $sql = " AND bargejurnal IS NULL ";
    $sql = $sql . " AND stuffing in ('EI') ";
    // $sql = $sql . " AND stuffing in ('LE','EI') ";
    if ($bargedest == 'idn' || $bargedest == 'idn2') { // ini
      $stf = '';
      if ($bargedest == 'idn') {
        $sql = $sql . " AND etd = 'PSG' ";
      } else {
        $sql = $sql . " AND etd = 'RSUP' ";
      }
    } else if ($bargedest == 'sin' || $bargedest == 'sin2') {
      $stf = '';
      if ($bargedest == 'sin') {
        $sql = $sql . " AND eta = 'PSG' ";
      } else {
        $sql = $sql . " AND eta = 'RSUP' ";
      }
    } else {
      $sql = '';
    }
    if ($sql != "") {
      $sqlit = " SELECT A.contid, A.container_id, A.container_name, count(A.container_name) AS Jumlah_container, A.eta, A.etd, A.etadate, A.etddate, A.stuffing    FROM (
            SELECT container_id as contid, container_number as container_id, container_type as container_name, etd, eta, etadate, etddate, stuffing FROM ship_vw_container_local2
            where container_number != '' AND shipmentdate = '" . $tgl . "' " . $sql . " ) A
            GROUP BY A.container_name, A.stuffing ";
      // echo $sqlit;
      return $this->db2->query($sqlit)->result();
    }
  }

  function get_isilclcont2_1($tgl, $bargedest, $sup)
  {
    $tbl_pss = (strtoupper(trim($sup)) === 'G00178') ? 'ship_vw_container_local2_ggfs' : 'ship_vw_container_local2';
    $invtype = $this->input->get('invtype');
    $sql = "";
    $sql = " AND bargejurnal IS NULL ";
    $sql = $sql . " AND stuffing in ('EI') ";
    if ($bargedest == 'idn' || $bargedest == 'idn2') {
      $stf = '';
      if ($bargedest == 'idn') {
        $sql = $sql . " AND etd = 'PSG' ";
      } else {
        $sql = $sql . " AND etd = 'RSUP' ";
      }
    } else if ($bargedest == 'sin' || $bargedest == 'sin2') {
      $stf = '';
      if ($bargedest == 'sin') {
        $sql = $sql . " AND eta = 'PSG' ";
      } else {
        $sql = $sql . " AND eta = 'RSUP' ";
      }
    } else {
      $sql = '';
    }
    if ($sql != "") {
      $sqlit = " SELECT A.contid, A.container_id, A.container_name, count(A.container_name) AS Jumlah_container, A.eta, A.etd, A.etadate, A.etddate, A.stuffing    FROM (
            SELECT container_id as contid, container_number as container_id, container_type as container_name, etd, eta, etadate, etddate, stuffing FROM " . $tbl_pss . "
            where container_number != '' AND shipmentdate = '" . $tgl . "' " . $sql . " ) A
            GROUP BY A.container_name, A.stuffing ";
      // echo $sqlit;
      return $this->db2->query($sqlit)->result();
    }
  }





  function get_2ft2detail($tgl, $bargedest, $sup)
  {
    $sql = " AND bargejurnal IS NULL AND jurnal_trucking IS NULL ";
    if ($bargedest == 'idn' || $bargedest == 'idn2') {
      $sql = $sql . " AND (stuffing IN ('LL')) ";
      $stf = '';
      if ($bargedest == 'idn') {
        $sql = $sql . " AND etd = 'PSG' ";
      } else {
        $sql = $sql . " AND etd = 'RSUP' ";
      }
    } else if ($bargedest == 'sin' || $bargedest == 'sin2') {

      $sql = $sql . " AND (stuffing IN ('LL')) ";
      $stf = 'A.stuffing,';
      if ($bargedest == 'sin') {
        $sql = $sql . " AND eta = 'PSG' ";
      } else {
        $sql = $sql . " AND eta = 'RSUP' ";
      }
    }

    $sqlit = "SELECT contid, container_id, container_type as container_name, ' ' as seal, container_number as container, stuffing
                    FROM ship_vw_container_local2  where container_number != '' AND container_size in (20, 40, '20 reefer', '40 reefer') AND customer = '" . $sup . "' AND shipmentdate = '" . $tgl . "' " . $sql . "";

    return $this->db2->query($sqlit)->result();
  }

  function get_isilclcontdtl($tgl, $bargedest, $sup)
  {
    $sql = " AND bargejurnal IS NULL ";
    if ($bargedest == 'idn' || $bargedest == 'idn2') {
      $sql = $sql . " AND (stuffing IN ('LL','LO')) ";
      $stf = '';
      if ($bargedest == 'idn') {
        $sql = $sql . " AND etd = 'PSG' ";
      } else {
        $sql = $sql . " AND etd = 'RSUP' ";
      }
    } else if ($bargedest == 'sin' || $bargedest == 'sin2') {
      $sql = $sql . " AND (stuffing IN ('LL','LO')) ";
      $stf = 'A.stuffing,';
      if ($bargedest == 'sin') {
        $sql = $sql . " AND eta = 'PSG' ";
      } else {
        $sql = $sql . " AND eta = 'RSUP' ";
      }
    } else {
      $sql = '';
      $stf = '';
    }

    if ($sql != '') {
      $sqlit = "SELECT contid, container_id, container_type as container_name, ' ' as seal, container_number as container, stuffing
            FROM ship_vw_container_local2  where container_number != '' AND customer = '" . $sup . "' AND shipmentdate = '" . $tgl . "' " . $sql . "";

      return $this->db2->query($sqlit)->result();
    }
  }


  function get_2ft3detail($tgl, $bargedest)
  {
    $invtype = $this->input->get('invtype');
    $sql = "";

    $sql = " AND bargejurnal IS NULL AND jurnal_trucking IS NULL ";


    if ($bargedest == 'idn' || $bargedest == 'idn2') {
      $sql = $sql . " AND stuffing = 'EI' ";
      $stf = '';
      if ($bargedest == 'idn') {
        $sql = $sql . " AND etd = 'PSG' ";
      } else {
        $sql = $sql . " AND etd = 'RSUP' ";
      }
    } else {
      $sql = "";
    }

    if ($sql != "") {
      $sqlit = "SELECT contid, container_id, container_type as container_name, ' ' as seal, container_number as container, stuffing
                        FROM ship_vw_container_local2  where container_number != '' AND container_size in (20,40) AND shipmentdate = '" . $tgl . "' " . $sql . "";
      // echo $sqlit;
      return $this->db2->query($sqlit)->result();
    }
  }
  function get_2ft3detailtet($tgl, $bargedest)
  {
    if ($bargedest == 'sin' || $bargedest == 'sin2') {
      $sql = " AND (jurnal_barge_sales IS NULL OR jurnal_barge_sales = '') AND jurnal_trucking IS NULL ";
      $sql = $sql . " AND (stuffing IN ('EECN','ITCN', 'ITCNDP')) ";
      $stf = 'A.stuffing,';
      if ($bargedest == 'sin') {
        $sql = $sql . " AND eta = 'PSG' ";
      } else {
        $sql = $sql . " AND eta = 'RSUP' ";
      }
      $sqlite = "SELECT DISTINCT contid, container_id, container_name, seal, container, stuffing
                FROM ship_vw_trn_cont where container != '' AND container_size in (20, 40) AND shipmentdate = '" . $tgl . "' AND tipe = 2 " . $sql;

      // echo $sql1;
      return $this->db2->query($sqlite)->result();
    } else {
      $sql = " AND (jurnal_barge_sales IS NULL OR jurnal_barge_sales = '') AND jurnal_trucking IS NULL ";
      // $sql = $sql." AND (stuffing IN ('EL', 'IL')) ";
      $sql = $sql . " AND (stuffing IN ('EECN','ITCN', 'ITCNDP')) ";
      $stf = 'A.stuffing,';
      if ($bargedest == 'idn') {
        $sql = $sql . " AND etd = 'PSG' ";
      } else {
        $sql = $sql . " AND etd = 'RSUP' ";
      }
      $sqlite = "SELECT DISTINCT contid, container_id, container_name, seal, container, stuffing
                FROM ship_vw_trn_cont where container != '' AND container_size in (20, 40) AND shipmentdate = '" . $tgl . "' AND tipe = 2 " . $sql;
      // echo $sqlite;
      return $this->db2->query($sqlite)->result();
    }




    // $invtype = $this->input->get('invtype');
    // $sql = "";

    // $sql = " AND bargejurnal IS NULL AND jurnal_trucking IS NULL ";


    // if($bargedest == 'idn' || $bargedest == 'idn2'){
    //     $sql = $sql." AND stuffing = 'LLTP' ";
    //     $stf = '';
    //     if($bargedest == 'idn'){
    //         $sql = $sql." AND etd = 'PSG' ";
    //     }else{
    //         $sql = $sql." AND etd = 'RSUP' ";
    //     }
    // }else{
    //     $sql = "";
    // }

    // if($sql != ""){
    //     $sqlit = "SELECT contid, container_id, container_type as container_name, ' ' as seal, container_number as container, stuffing
    //                 FROM ship_vw_container_local2  where container_number != '' AND container_size in (20,40) AND shipmentdate = '".$tgl."' ".$sql."";
    //     // echo $sqlit;
    //     return $this->db2->query($sqlit)->result();
    // }
  }

  function get_isilclcontdtl2($tgl, $bargedest)
  {
    $invtype = $this->input->get('invtype');
    $sql = " AND bargejurnal IS NULL ";
    $sql = $sql . " AND (stuffing IN ('LE','EI')) ";
    if ($bargedest == 'idn' || $bargedest == 'idn2') {
      $stf = '';
      if ($bargedest == 'idn') {
        $sql = $sql . " AND etd = 'PSG' ";
      } else {
        $sql = $sql . " AND etd = 'RSUP' ";
      }
    } else if ($bargedest == 'sin' || $bargedest == 'sin2') {
      $stf = '';
      if ($bargedest == 'sin') {
        $sql = $sql . " AND eta = 'PSG' ";
      } else {
        $sql = $sql . " AND eta = 'RSUP' ";
      }
    } else {
      $sql = "";
    }

    if ($sql != "") {
      $sqlit = "SELECT contid, container_id, container_type as container_name, ' ' as seal, container_number as container, stuffing
            FROM ship_vw_container_local2  where container_number != '' AND shipmentdate = '" . $tgl . "' " . $sql . "";
      // echo $sqlit;
      return $this->db2->query($sqlit)->result();
    }
  }

  function get_isilclcontdtl2_1($tgl, $bargedest)
  {
    $invtype = $this->input->get('invtype');
    $sql = " AND bargejurnal IS NULL ";
    $sql = $sql . " AND (stuffing IN ('EI')) ";
    if ($bargedest == 'idn' || $bargedest == 'idn2') {
      $stf = '';
      if ($bargedest == 'idn') {
        $sql = $sql . " AND etd = 'PSG' ";
      } else {
        $sql = $sql . " AND etd = 'RSUP' ";
      }
    } else if ($bargedest == 'sin' || $bargedest == 'sin2') {
      $stf = '';
      if ($bargedest == 'sin') {
        $sql = $sql . " AND eta = 'PSG' ";
      } else {
        $sql = $sql . " AND eta = 'RSUP' ";
      }
    } else {
      $sql = "";
    }

    if ($sql != "") {
      $sqlit = "SELECT contid, container_id, container_type as container_name, ' ' as seal, container_number as container, stuffing
            FROM ship_vw_container_local2  where container_number != '' AND shipmentdate = '" . $tgl . "' " . $sql . "";
      // echo $sqlit;
      return $this->db2->query($sqlit)->result();
    }
  }






  function get_sup($tgl, $id)
  {
    if ($id == 'bar') {
      $sql = " AND (jurnal_barge_sales IS NULL OR jurnal_barge_sales = '') ";
    } else if ($id == 'fre') {
      $sql = " AND jurnal_freight_sales IS NULL ";
    } else if ($id == 'trn') {
      $sql = " AND jurnal_transport_sales IS NULL ";
    } else if ($id == 'chinaShipment') {
      $sql = " AND jurnal_chinaShipment_sales IS NULL ";
    } else {
      $sql = "";
    }
    $sql_prov =  $this->db2->query("SELECT customer_id, customer_name, shipmentdate,barge  FROM ship_vw_trn_cont where tipe = 2 AND shipmentdate = '" . $tgl . "' " . $sql . " GROUP BY customer_id");
    if ($sql_prov->num_rows() > 0) {
      $result[''] = 'Select';
      foreach ($sql_prov->result_array() as $row) {
        $result[$row['customer_id'] . "|" . $row['barge'] . "|" . $row['customer_name']] = ucwords(strtoupper($row['customer_name']));
        //$result[$row['customer_code']] = ucwords(strtoupper($row['customer_name']));
      }
      return $result;
    } else {
      echo "";
    }
  }

  function get_port($tgl, $id, $buyer)
  {
    if ($id == 'bar') {
      $sql = " AND (jurnal_barge_sales IS NULL OR jurnal_barge_sales = '') ";
    } else if ($id == 'fre') {
      $sql = " AND jurnal_freight_sales IS NULL ";
    } else if ($id == 'trn') {
      $sql = " AND jurnal_transport_sales IS NULL ";
    } else if ($id == 'chinaShipment') {
      $sql = " AND jurnal_chinaShipment_sales IS NULL ";
    }else {
      $sql = "";
    }
    $sql_prov =  $this->db2->query("SELECT port_id, port_name
        	FROM ship_vw_trn_cont where tipe = 2 AND shipmentdate = '" . $tgl . "' AND customer_id = " . $buyer . " " . $sql . " GROUP BY port_id ");
    if ($sql_prov->num_rows() > 0) {
      $result[''] = 'Select';
      foreach ($sql_prov->result_array() as $row) {
        $result[$row['port_id']] = ucwords(strtoupper($row['port_name']));
        //$result[$row['customer_code']] = ucwords(strtoupper($row['customer_name']));
      }
      return $result;
    } else {
      echo "";
    }
  }

  function get_harga($idcon, $jenisinv, $sup)
  {
    // var_dump($jenisinv);
    $tbl_pss = (strtoupper(trim($sup)) === 'G00178') ? 'zhl_shp_tblmst_bargecharges_ggfs' : 'zhl_shp_tblmst_bargecharges';
    $tbl_trck = (strtoupper(trim($sup)) === 'G00178') ? 'zhl_tbl_mst_trucking_ggfs' : 'zhl_tbl_mst_trucking';

    if ($jenisinv == 'trucking20ft' || $jenisinv == 'trucking40ft' || $jenisinv == 'trucking20ftreefer' || $jenisinv == 'trucking40ftreefer') {
      if ($jenisinv == 'trucking20ft') {
        $ctr = 20;
      }elseif ($jenisinv == 'trucking40ft'){
        $ctr = 40;
      }elseif ($jenisinv == 'trucking20ftreefer'){
        $ctr = "20 reefer";
      } else {
        $ctr = "40 reefer";
      } 
      $query = "SELECT cust_trucking_price FROM " . $tbl_trck . " where container_size = '$ctr' order by validity_until DESC LIMIT 1 ";
      $resi = $this->db->query($query)->row();
      if (!empty($resi)) {
        return $resi->cust_trucking_price;
      } else {
        return 0;
      }
    } else if ($jenisinv == 'ELTP') {

      $sql = "cust_export_laden";

      $query = "SELECT " . $sql . " FROM " . $tbl_pss . " WHERE container_id = '28' order by validity desc LIMIT 1 ";
      if ($jenisinv == 'ELTP') {
        $res = $this->db->query($query)->row();
        if (!empty($res)) {
          return $res->$sql;
        } else {
          return 0;
        }
      } else {
        return 0;
      }
    } elseif ($jenisinv == 'LLTP') {

      $sql = "cust_local_laden";

      $query = "SELECT " . $sql . " FROM " . $tbl_pss . " WHERE container_id = '29' order by validity desc LIMIT 1 ";
      if ($jenisinv == 'LLTP') {
        $res = $this->db->query($query)->row();
        if (!empty($res)) {
          return $res->$sql;
        } else {
          return 0;
        }
      } else {
        return 0;
      }
    } else {
      if ($jenisinv == 'EE') {
        $sql = "cust_export_empty";
      } else if ($jenisinv == 'EL') {
        $sql = "cust_export_laden";
      } else if ($jenisinv == 'IT') {
        $sql = "cust_import_transhipment";
      } else if ($jenisinv == 'LE') {
        $sql = "cust_local_empty";
      } else if ($jenisinv == 'LL' &&  in_array($idcon, ['29', '30'])) {
        $sql = 'cust_special';
      } else if ($jenisinv == 'LL') {
        $sql = "cust_local_laden";
      } else if ($jenisinv == 'RE') {
        $sql = "cust_recall";
      } else if ($jenisinv == 'EI') {
        $sql = "cust_empty_import";
      } else if ($jenisinv == 'LO') {
        $sql = "cust_loose";
      } else if ($jenisinv == 'IL') {
        $sql = "cust_import_transhipment";
      } else if ($jenisinv == 'EECN') {
        $sql = "cust_export_empty_cn";
      }else if ($jenisinv == 'ITCN') {
        $sql = "cust_import_transhipment_cn";
      }else if ($jenisinv == 'ELCN') {
        $sql = "cust_export_laden_cn";
      }else if ($jenisinv == 'ITCNDP') {
        $sql = "cust_import_transhipment_cndp";
      }else if ($jenisinv == 'ITDP') {
        $sql = "cust_import_transhipment_dp";
      } else {
        $sql = "0";
      }

      $query = "SELECT " . $sql . " FROM " . $tbl_pss . " WHERE container_id = '" . $idcon . "' order by validity_till desc LIMIT 1 ";

      // echo $query;

      if ($jenisinv == 'EE' || $jenisinv == 'EL' || $jenisinv == 'IT' || $jenisinv == 'IL' || $jenisinv == 'LL' || $jenisinv == 'LE' || $jenisinv == 'RE' || $jenisinv == 'EI' || $jenisinv == 'LO' || $jenisinv == 'EECN' || $jenisinv == 'ITCN' || $jenisinv == 'ITCNDP' || $jenisinv == 'ITDP' || $jenisinv == 'ELCN') {
        $res = $this->db->query($query)->row();
        if (!empty($res)) {
          return $res->$sql;
        } else {
          return 0;
        }
      } else {
        return 0;
      }
    }
  }

  function get_vessel($tgl, $supp, $inv, $port)
  {
    if ($inv == 'fre') {
      $sql_inv = " AND jurnal_freight_sales IS NULL ";
    } else if ($inv == 'trn') {
      $sql_inv = " AND jurnal_transport_sales IS NULL";
    } else {
      $sql_inv = "";
    }

    $sql = "SELECT DISTINCT vessel from ship_vw_trn_cont where proses = 1 AND tipe = 2 AND port_id = " . $port . " AND customer_id = " . $supp . " AND shipmentdate = '" . $tgl . "' " . $sql_inv . " ";

    // echo $sql_prov;
    $sql_prov = $this->db->query($sql);
    if ($sql_prov->num_rows() > 0) {
      $result[''] = 'Select';
      foreach ($sql_prov->result_array() as $row) {
        $result[$row['vessel']] = ucwords(strtoupper($row['vessel']));
      }
      return $result;
    } else {
      echo "";
    }
  }

  function geteta($barge, $shipdate)
  {
    if ($barge == 'idn') {
      $sql = "SELECT etadate FROM ship_tbl_trn_cont_hdr where etd = 'PSG' AND shipmentdate = '$shipdate' LIMIT 1";
    } else if ($barge == 'idn2') {
      $sql = "SELECT etadate FROM ship_tbl_trn_cont_hdr where etd = 'RSUP' AND shipmentdate = '$shipdate' LIMIT 1";
    } else if ($barge == 'sin') {
      $sql = "SELECT etadate FROM ship_tbl_trn_cont_hdr where eta = 'PSG' AND shipmentdate = '$shipdate' LIMIT 1";
    } else if ($barge == 'sin2') {
      $sql = "SELECT etadate FROM ship_tbl_trn_cont_hdr where eta = 'RSUP' AND shipmentdate = '$shipdate' LIMIT 1";
    }

    return $this->db->query($sql)->row();
  }

  function geteta_old($barge, $shipdate)
  {
    if ($barge == 'idn') {
      $sql = "SELECT etadate FROM ship_tbl_trn_cont_hdr where etd = 'PSG' AND shipmentdate = '$shipdate' LIMIT 1";
    } else if ($barge == 'idn2') {
      $sql = "SELECT etadate FROM ship_tbl_trn_cont_hdr where etd = 'RSUP' AND shipmentdate = '$shipdate' LIMIT 1";
    } else if ($barge == 'sin') {
      $sql = "SELECT etadate FROM ship_tbl_trn_cont_hdr where eta = 'PSG' AND shipmentdate = '$shipdate' LIMIT 1";
    } else if ($barge == 'sin2') {
      $sql = "SELECT etadate FROM ship_tbl_trn_cont_hdr where eta = 'RSUP' AND shipmentdate = '$shipdate' LIMIT 1";
    }

    $query = $this->db->query($sql)->row();
    $sdate = new DateTime($query->etadate);
    $dateeta = date_format($sdate, 'd/m/Y');
    return $dateeta;
  }

  function getetd_old($barge, $shipdate)
  {
    if ($barge == 'idn') {
      $sql = "SELECT etddate FROM ship_tbl_trn_cont_hdr where etd = 'PSG' AND shipmentdate = '$shipdate' LIMIT 1";
    } else if ($barge == 'idn2') {
      $sql = "SELECT etddate FROM ship_tbl_trn_cont_hdr where etd = 'RSUP' AND shipmentdate = '$shipdate' LIMIT 1";
    } else if ($barge == 'sin') {
      $sql = "SELECT etddate FROM ship_tbl_trn_cont_hdr where eta = 'PSG' AND shipmentdate = '$shipdate' LIMIT 1";
    } else if ($barge == 'sin2') {
      $sql = "SELECT etddate FROM ship_tbl_trn_cont_hdr where eta = 'RSUP' AND shipmentdate = '$shipdate' LIMIT 1";
    }

    $query = $this->db->query($sql)->row();
    $sdate = new DateTime($query->etddate);
    $dateeta = date_format($sdate, 'd/m/Y');
    return $dateeta;
  }

  function getetd($barge, $shipdate)
  {
    if ($barge == 'idn') {
      $sql = "SELECT etddate FROM ship_tbl_trn_cont_hdr where etd = 'PSG' AND shipmentdate = '$shipdate' LIMIT 1";
    } else if ($barge == 'idn2') {
      $sql = "SELECT etddate FROM ship_tbl_trn_cont_hdr where etd = 'RSUP' AND shipmentdate = '$shipdate' LIMIT 1";
    } else if ($barge == 'sin') {
      $sql = "SELECT etddate FROM ship_tbl_trn_cont_hdr where eta = 'PSG' AND shipmentdate = '$shipdate' LIMIT 1";
    } else if ($barge == 'sin2') {
      $sql = "SELECT etddate FROM ship_tbl_trn_cont_hdr where eta = 'RSUP' AND shipmentdate = '$shipdate' LIMIT 1";
    }

    return $this->db->query($sql)->row();
  }

  function getbarge($barge, $shipdate)
  {
    if ($barge == 'idn') {
      $sql = "SELECT CONCAT(barge,' / ',voyage) as barge FROM ship_tbl_trn_cont_hdr where etd = 'PSG' AND shipmentdate = '$shipdate' LIMIT 1";
    } else if ($barge == 'idn2') {
      $sql = "SELECT CONCAT(barge,' / ',voyage) as barge FROM ship_tbl_trn_cont_hdr where etd = 'RSUP' AND shipmentdate = '$shipdate' LIMIT 1";
    } else if ($barge == 'sin') {
      $sql = "SELECT CONCAT(barge,' / ',voyage) as barge FROM ship_tbl_trn_cont_hdr where eta = 'PSG' AND shipmentdate = '$shipdate' LIMIT 1";
    } else if ($barge == 'sin2') {
      $sql = "SELECT CONCAT(barge,' / ',voyage) as barge FROM ship_tbl_trn_cont_hdr where eta = 'RSUP' AND shipmentdate = '$shipdate' LIMIT 1";
    }

    return $this->db->query($sql)->row();
  }

  function getbarge_old($barge, $shipdate)
  {
    if ($barge == 'idn') {
      $sql = "SELECT CONCAT(barge,' / ',voyage) as barge FROM ship_tbl_trn_cont_hdr where etd = 'PSG' AND shipmentdate = '$shipdate' LIMIT 1";
    } else if ($barge == 'idn2') {
      $sql = "SELECT CONCAT(barge,' / ',voyage) as barge FROM ship_tbl_trn_cont_hdr where etd = 'RSUP' AND shipmentdate = '$shipdate' LIMIT 1";
    } else if ($barge == 'sin') {
      $sql = "SELECT CONCAT(barge,' / ',voyage) as barge FROM ship_tbl_trn_cont_hdr where eta = 'PSG' AND shipmentdate = '$shipdate' LIMIT 1";
    } else if ($barge == 'sin2') {
      $sql = "SELECT CONCAT(barge,' / ',voyage) as barge FROM ship_tbl_trn_cont_hdr where eta = 'RSUP' AND shipmentdate = '$shipdate' LIMIT 1";
    }

    $query = $this->db->query($sql)->row();
    // $sdate = new DateTime( $query->etddate);
    // $dateeta = date_format($sdate, 'd/m/Y');
    return $query->barge;
  }

  function geteta2($barge, $shipdate)
  {
    if ($barge == 'idn') {
      $sql = "SELECT etadate FROM ship_tbl_trn_cont_hdr where etd = 'PSG' AND shipmentdate = '$shipdate' LIMIT 1";
    } else if ($barge == 'idn2') {
      $sql = "SELECT etadate FROM ship_tbl_trn_cont_hdr where etd = 'RSUP' AND shipmentdate = '$shipdate' LIMIT 1";
    } else if ($barge == 'sin') {
      $sql = "SELECT etadate FROM ship_tbl_trn_cont_hdr where eta = 'PSG' AND shipmentdate = '$shipdate' LIMIT 1";
    } else if ($barge == 'sin2') {
      $sql = "SELECT etadate FROM ship_tbl_trn_cont_hdr where eta = 'RSUP' AND shipmentdate = '$shipdate' LIMIT 1";
    }

    return $this->db->query($sql)->row();
  }

  function geteta2_old($barge, $shipdate)
  {
    // if($barge == 'idn'){
    //     $sql = "SELECT etadate FROM ship_tbl_trn_cont_local_hdr where etd = 'PSG' AND shipmentdate = '$shipdate' LIMIT 1";
    // }else if($barge == 'idn2'){
    //     $sql = "SELECT etadate FROM ship_tbl_trn_cont_local_hdr where etd = 'RSUP' AND shipmentdate = '$shipdate' LIMIT 1";
    // }else if($barge == 'sin'){
    //     $sql = "SELECT etadate FROM ship_tbl_trn_cont_local_hdr where eta = 'PSG' AND shipmentdate = '$shipdate' LIMIT 1";
    // }else if($barge == 'sin2'){
    //     $sql = "SELECT etadate FROM ship_tbl_trn_cont_local_hdr where eta = 'RSUP' AND shipmentdate = '$shipdate' LIMIT 1";
    // }
    // $query = $this->db->query($sql)->row();
    // $sdate = new DateTime( $query->etadate);
    // $dateeta = date_format($sdate, 'd/m/Y');
    // return $dateeta;
    if ($barge == 'idn') {
      $sql = "SELECT etadate FROM ship_tbl_trn_cont_hdr where etd = 'PSG' AND shipmentdate = '$shipdate' LIMIT 1";
    } else if ($barge == 'idn2') {
      $sql = "SELECT etadate FROM ship_tbl_trn_cont_hdr where etd = 'RSUP' AND shipmentdate = '$shipdate' LIMIT 1";
    } else if ($barge == 'sin') {
      $sql = "SELECT etadate FROM ship_tbl_trn_cont_hdr where eta = 'PSG' AND shipmentdate = '$shipdate' LIMIT 1";
    } else if ($barge == 'sin2') {
      $sql = "SELECT etadate FROM ship_tbl_trn_cont_hdr where eta = 'RSUP' AND shipmentdate = '$shipdate' LIMIT 1";
    }

    $query = $this->db->query($sql)->row();
    $sdate = new DateTime($query->etadate);
    $dateeta = date_format($sdate, 'd/m/Y');
    return $dateeta;
  }

  function getetd2($barge, $shipdate)
  {
    if ($barge == 'idn') {
      $sql = "SELECT etddate FROM ship_tbl_trn_cont_hdr where etd = 'PSG' AND shipmentdate = '$shipdate' LIMIT 1";
    } else if ($barge == 'idn2') {
      $sql = "SELECT etddate FROM ship_tbl_trn_cont_hdr where etd = 'RSUP' AND shipmentdate = '$shipdate' LIMIT 1";
    } else if ($barge == 'sin') {
      $sql = "SELECT etddate FROM ship_tbl_trn_cont_hdr where eta = 'PSG' AND shipmentdate = '$shipdate' LIMIT 1";
    } else if ($barge == 'sin2') {
      $sql = "SELECT etddate FROM ship_tbl_trn_cont_hdr where eta = 'RSUP' AND shipmentdate = '$shipdate' LIMIT 1";
    }

    return $this->db->query($sql)->row();
  }


  function getetd2_old($barge, $shipdate)
  {
    // if($barge == 'idn'){
    //     $sql = "SELECT etddate FROM ship_tbl_trn_cont_local_hdr where etd = 'PSG' AND shipmentdate = '$shipdate' LIMIT 1";
    // }else if($barge == 'idn2'){
    //     $sql = "SELECT etddate FROM ship_tbl_trn_cont_local_hdr where etd = 'RSUP' AND shipmentdate = '$shipdate' LIMIT 1";
    // }else if($barge == 'sin'){
    //     $sql = "SELECT etddate FROM ship_tbl_trn_cont_local_hdr where eta = 'PSG' AND shipmentdate = '$shipdate' LIMIT 1";
    // }else if($barge == 'sin2'){
    //     $sql = "SELECT etddate FROM ship_tbl_trn_cont_local_hdr where eta = 'RSUP' AND shipmentdate = '$shipdate' LIMIT 1";
    // }
    // $query = $this->db->query($sql)->row();
    // $sdate = new DateTime( $query->etddate);
    // $dateeta = date_format($sdate, 'd/m/Y');
    // return $dateeta;
    if ($barge == 'idn') {
      $sql = "SELECT etddate FROM ship_tbl_trn_cont_hdr where etd = 'PSG' AND shipmentdate = '$shipdate' LIMIT 1";
    } else if ($barge == 'idn2') {
      $sql = "SELECT etddate FROM ship_tbl_trn_cont_hdr where etd = 'RSUP' AND shipmentdate = '$shipdate' LIMIT 1";
    } else if ($barge == 'sin') {
      $sql = "SELECT etddate FROM ship_tbl_trn_cont_hdr where eta = 'PSG' AND shipmentdate = '$shipdate' LIMIT 1";
    } else if ($barge == 'sin2') {
      $sql = "SELECT etddate FROM ship_tbl_trn_cont_hdr where eta = 'RSUP' AND shipmentdate = '$shipdate' LIMIT 1";
    }

    $query = $this->db->query($sql)->row();
    $sdate = new DateTime($query->etddate);
    $dateeta = date_format($sdate, 'd/m/Y');
    return $dateeta;
  }

  function getbarge2($barge, $shipdate)
  {
    if ($barge == 'idn') {
      $sql = "SELECT CONCAT(barge,' / ',voyage) as barge FROM ship_tbl_trn_cont_hdr where etd = 'PSG' AND shipmentdate = '$shipdate' LIMIT 1";
    } else if ($barge == 'idn2') {
      $sql = "SELECT CONCAT(barge,' / ',voyage) as barge FROM ship_tbl_trn_cont_hdr where etd = 'RSUP' AND shipmentdate = '$shipdate' LIMIT 1";
    } else if ($barge == 'sin') {
      $sql = "SELECT CONCAT(barge,' / ',voyage) as barge FROM ship_tbl_trn_cont_hdr where eta = 'PSG' AND shipmentdate = '$shipdate' LIMIT 1";
    } else if ($barge == 'sin2') {
      $sql = "SELECT CONCAT(barge,' / ',voyage) as barge FROM ship_tbl_trn_cont_hdr where eta = 'RSUP' AND shipmentdate = '$shipdate' LIMIT 1";
    }

    return $this->db->query($sql)->row();
  }

  function getbarge2_old($barge, $shipdate)
  {
    // if($barge == 'idn'){
    //     $sql = "SELECT CONCAT(barge,' / ',voyage) as barge FROM ship_tbl_trn_cont_local_hdr where etd = 'PSG' AND shipmentdate = '$shipdate' LIMIT 1";
    // }else if($barge == 'idn2'){
    //     $sql = "SELECT CONCAT(barge,' / ',voyage) as barge FROM ship_tbl_trn_cont_local_hdr where etd = 'RSUP' AND shipmentdate = '$shipdate' LIMIT 1";
    // }else if($barge == 'sin'){
    //     $sql = "SELECT CONCAT(barge,' / ',voyage) as barge FROM ship_tbl_trn_cont_local_hdr where eta = 'PSG' AND shipmentdate = '$shipdate' LIMIT 1";
    // }else if($barge == 'sin2'){
    //     $sql = "SELECT CONCAT(barge,' / ',voyage) as barge FROM ship_tbl_trn_cont_local_hdr where eta = 'RSUP' AND shipmentdate = '$shipdate' LIMIT 1";
    // }
    // $query = $this->db->query($sql)->row();
    // return $query->barge;
    if ($barge == 'idn') {
      $sql = "SELECT CONCAT(barge,' / ',voyage) as barge FROM ship_tbl_trn_cont_hdr where etd = 'PSG' AND shipmentdate = '$shipdate' LIMIT 1";
    } else if ($barge == 'idn2') {
      $sql = "SELECT CONCAT(barge,' / ',voyage) as barge FROM ship_tbl_trn_cont_hdr where etd = 'RSUP' AND shipmentdate = '$shipdate' LIMIT 1";
    } else if ($barge == 'sin') {
      $sql = "SELECT CONCAT(barge,' / ',voyage) as barge FROM ship_tbl_trn_cont_hdr where eta = 'PSG' AND shipmentdate = '$shipdate' LIMIT 1";
    } else if ($barge == 'sin2') {
      $sql = "SELECT CONCAT(barge,' / ',voyage) as barge FROM ship_tbl_trn_cont_hdr where eta = 'RSUP' AND shipmentdate = '$shipdate' LIMIT 1";
    }

    $query = $this->db->query($sql)->row();
    // $sdate = new DateTime( $query->etddate);
    // $dateeta = date_format($sdate, 'd/m/Y');
    return $query->barge;
  }

  function get_detail_freigth($awal, $akhir)
  {
    // $qry = "call zhl_get_data_freigth($awal,$akhir)";
    $sql = $this->db->query("call zhl_get_data_freight_group('$awal','$akhir')");
    $res = $sql->result();
    $sql->next_result();
    $sql->free_result();

    return $res;
  }

  function get_detail_freigth2($awal, $akhir)
  {
    // $qry = "call zhl_get_data_freigth($awal,$akhir)";
    $sql = $this->db->query("call zhl_get_data_freight_group('$awal','$akhir')");
    // $sql = $this->db->query("call zhl_get_data_freigth('$awal','$akhir')");
    $res = $sql->result();
    $sql->next_result();
    $sql->free_result();

    return $res;
  }

  function get_detail_freigthcont($awal, $akhir)
  {
    $sql = $this->db->query("SELECT DISTINCT  A.invno, F.container,F.contid, C.container_id, D.container_name, F.seal , '' as stuffing
                                FROM ship_tbl_trn_inv_hdr A LEFT JOIN ship_tbl_trn_inv_dtl B ON A.invno = B.invno LEFT JOIN
                                mar_tbltrn_purchase_order C ON B.ponumberid = C.po_hdr_id LEFT JOIN mar_tblmst_container D ON
                                C.container_id = D.container_id LEFT JOIN mar_tbltrn_shipping_instruction_po E ON B.ponumberid = E.po_hdr_id
                                LEFT JOIN ship_tbl_trn_cont_dtl F ON E.ship_id = F.shipid LEFT JOIN ship_tbl_trn_cont_hdr G ON F.contid = G.contid
                                LEFT JOIN mar_tbltrn_shipping_instruction I ON F.shipid = I.ship_id
                                where G.tipe = 2  AND (I.trading_term_id in (2,3) OR I.ocean_freight in (15,16)) AND A.docdate BETWEEN '$awal' AND '$akhir' AND F.jurnal_freight_sales IS NULL AND C.container_id not in (6,9)");
    return $sql->result();
  }


  function vessel_list()
  {
    $this->db->select('*');
    $this->db->from('zhl_shp_tblmst_vessel');
    return $this->db->get()->result();
  }

  // ===================    END MODEL AJAX   (E.trading_term_id IN (2,3) OR E.ocean_freight in (15,16))  =============================================

  public function get_shipmentdate_invexcel($io)
  {
    $this->db->select('shipmentdate');
    $this->db->from('zhl_ship_tbl_trn_cont_hdr_import');
    $this->db->where('tipe', $io);
    // $this->db->where('deleted_by', null);
    // $this->db->group_by('tipe');

    $data = $this->db->get();

    if ($data->num_rows() > 0) {

      $result[''] = 'Select';
      foreach ($data->result_array() as $s) {
        $sdate = new DateTime($s['shipmentdate']);
        $date_of_journal = date_format($sdate, 'd/m/Y');
        $result[$date_of_journal] = $date_of_journal;
      }
      return $result;
    } else {
      echo "";
    }
  }
  public function get_dtl_invexcel($shp_date, $sup, $oi)
  {
    $this->db->select('*');
    $this->db->from('zhl_vw_import_excel');
    $this->db->where('shipmentdate', $shp_date);
    $this->db->where('customer_code', $sup);
    $this->db->where('tipe', $oi);

    // $this->db->where('deleted_at', null);

    // if ($sup != '') {
    //     $this->db->where('customer_code', $sup);
    // }
    return $this->db->get()->result();
  }
  // SAVE Dsini
  // function save_inv(){
  //     $nofaktur = $this->input->post('nofaktur'); //hedaerID
  //     $tgl_jurnal = str_replace('/', '-', $this->input->post('tgl_jurnal'));
  //     $p_tanggal = date('Y-m-d', strtotime($tgl_jurnal)); //tanggal jurnal
  //     $tgl_tempo = str_replace('/', '-', $this->input->post('tgl_tempo'));
  //     $p_tanggal_tempo = date('Y-m-d', strtotime($tgl_tempo)); // tanggal tempo
  //     $tgl_invoice = str_replace('/', '-', $this->input->post('tgl_invoice'));
  //     $p_tanggal_invoice = date('Y-m-d', strtotime($tgl_invoice)); // tanggal shipment
  //     $supplier = $this->input->post('supplier');
  //     $rate = $this->input->post('rate_header');
  //     $rate_sgd = $this->input->post('rate_sgd');
  //     $currency = $this->input->post('Currency');
  //     $term = $this->input->post('term');
  //     $totalinv = $this->input->post('totalinv');
  //     $totalinvusd = $this->input->post('totalinvusd');
  //     $total_gst = $this->input->post('totalgst');
  //     $totalamount = $this->input->post('stotalinv');
  //     $bargename = $this->input->post('barge');
  //     $typeinv = $this->input->post('invtype');
  //     $buyer = $this->input->post('buyername');
  //     $barge_dest = $this->input->post('dest_barge');
  //     $ports = $this->input->post('portes');

  //     $etddate= str_replace('/', '-', $this->input->post('tgl_etd'));
  //     $etd_date = date('Y-m-d', strtotime($etddate));
  //     $etadate = str_replace('/', '-', $this->input->post('tgl_eta'));
  //     $eta_date = date('Y-m-d', strtotime($etadate));
  //     $shipmentdate = str_replace('/', '-', $this->input->post('tgl_shipment'));
  //     $ship_date = date('Y-m-d', strtotime($shipmentdate));


  //     $dtlcont = $this->input->post('detailidcont');
  //     $accountid = $this->input->post('accNum');
  //     $itemname = $this->input->post('det_items');
  //     $desc = $this->input->post('descr');
  //     $unit = $this->input->post('unit');
  //     $jenis_barge = $this->input->post('jenisbarge');
  //     $txtHarga = $this->input->post('txtHarga');
  //     $txtHargaUsd = $this->input->post('txtUSD');
  //     $txtgst = $this->input->post('txtGST');
  //     $txtgstvalue = $this->input->post('txtGSTValue');
  //     $submit_value = $this->input->post('sbt');

  //     $created_by = $this->session->userdata('userid_1');
  //     $ip_address = $_SERVER['REMOTE_ADDR'];

  //     if($nofaktur==''){
  //         $p_tahun = date('Y', strtotime($tgl_jurnal));
  //         $p_bulan = date('m', strtotime($tgl_jurnal));
  //         // $sql_faktur = $this->M_Sales_inv2->get_nofaktur($p_tahun, $p_bulan);
  //         $sql_faktur = $this->get_nofaktur($p_tahun, $p_bulan);
  //         $nofaktur = $sql_faktur;
  //     }
  //     // echo $nofaktur;

  //     //  tambahan 19-04-2018
  //     $id_cointaner = $this->input->post('idcontainer');
  //     //tambahan 27-04-2018
  //     $txtTotal = $this->input->post('txtTotal');

  //     //input detai_container
  //     // $container_name = $this->input->post('container_name');
  //     $container_id = $this->input->post('container_id');
  //     $contid = $this->input->post('contid');
  //     $container_number = $this->input->post('container_number');
  //     $seal_number = $this->input->post('seal_number');

  //     $container_id2 = $this->input->post('container_id2');
  //     $contid2 = $this->input->post('contid2');
  //     $container_number2 = $this->input->post('container_number2');
  //     $seal_number2 = $this->input->post('seal_number2');

  //     $container_id_truck = $this->input->post('container_id_truck');
  //     $contid_truck = $this->input->post('contid_truck');
  //     $container_number_truck = $this->input->post('container_number_truck');
  //     $seal_number_truck = $this->input->post('seal_number_truck');

  //     $container_id2_truck = $this->input->post('container_id2_truck');
  //     $contid2_truck = $this->input->post('contid2_truck');
  //     $container_number2_truck = $this->input->post('container_number2_truck');
  //     $seal_number2_truck = $this->input->post('seal_number2_truck');


  //     if($submit_value == 'Save'){
  //          $perintah = 'add';
  //     }else{
  //         $perintah = 'edit';
  //         // $this->M_Sales_inv2->hapus($nofaktur);
  //     }
  //     // insert detail
  //     for($i = 0; $i < count($dtlcont); $i++){
  //         $data_detail = array(
  //             'p_headerid' => $nofaktur,
  //             'p_itemid' => $id_cointaner[$i],
  //             'p_itemname' => $itemname[$i],
  //             'p_qty' => 1,
  //             'p_unit' => $unit[$i],
  //             'p_price' => round(str_replace(",", "", $txtHarga[$i]),  2),
  //             'p_amount' =>  round(str_replace(",", "",$txtTotal[$i]),  2),
  //             'p_currency' => $currency,
  //             'p_rate' => $rate,
  //             'p_usdequivalen' => round(str_replace(",", "",$txtHargaUsd[$i]),  2),
  //             'p_npbb' => $dtlcont[$i],
  //             'p_user' => $created_by,
  //             'p_ip' => $ip_address,
  //             'p_NoCOA' => $accountid[$i],
  //             'p_ratesgd' => $rate_sgd,
  //             'p_gst' => $txtgst[$i],
  //             'p_gst_value' => round(str_replace(",", "",$txtgstvalue[$i]),  2),
  //             'p_detcont' => $dtlcont[$i],
  //             'p_typebarge' => $jenis_barge[$i],
  //             'p_decript' => $desc[$i],
  //             'p_tanggal' => $p_tanggal,
  //             'p_cust' => $supplier,
  //             'p_jenin' => $typeinv
  //         );

  //         // $this->M_Sales_inv2->call_save_dtl($data_detail);
  //     }
  //     // $this->M_Sales_inv2->call_save_dtl($data_detail);

  //     for($ii = 0; $ii < count($container_id); $ii++){
  //         $data_container_dtl = array(
  //             'p_jurnal' => $nofaktur,
  //             'p_cont_type' =>  $container_id[$ii],
  //             'p_cont_number' => $container_number[$ii],
  //             'p_seal' => $seal_number[$ii],
  //             'p_contid' => $contid[$ii],
  //             'p_jenis_trans' => 'SIJV',
  //             'p_jenis_jurnal' => $typeinv
  //         );

  //         // $this->M_Sales_inv2->call_save_container_dtl($data_container_dtl);
  //     }
  //      // $this->M_Sales_inv2->call_save_container_dtl($data_container_dtl);

  //     for($iii = 0; $iii < count($container_id2); $iii++){
  //         $data_container_dtl2 = array(
  //             'p_jurnal' => $nofaktur,
  //             'p_cont_type' =>  $container_id2[$iii],
  //             'p_cont_number' => $container_number2[$iii],
  //             'p_seal' => $seal_number2[$iii],
  //             'p_contid' => $contid2[$iii],
  //             'p_jenis_trans' => 'SIJV',
  //             'p_jenis_jurnal' => $typeinv
  //         );
  //         // $this->M_Sales_inv2->call_save_container_dtl2($data_container_dtl2);
  //     }
  //     // $this->M_Sales_inv2->call_save_container_dtl2($data_container_dtl2);

  //     for($ii = 0; $ii < count($container_id_truck); $ii++){
  //         $data_container_dtl = array(
  //             'p_jurnal' => $nofaktur,
  //             'p_cont_type' =>  $container_id_truck[$ii],
  //             'p_cont_number' => $container_number_truck[$ii],
  //             'p_seal' => $seal_number_truck[$ii],
  //             'p_contid' => $contid_truck[$ii],
  //             'p_jenis_trans' => 'SIJV',
  //             'p_jenis_jurnal' => $typeinv
  //         );

  //         // $this->M_Sales_inv2->call_save_container_dtl_truck($data_container_dtl);
  //     }
  //     // $this->M_Sales_inv2->call_save_container_dtl_truck($data_container_dtl);

  //     for($iii = 0; $iii < count($container_id2_truck); $iii++){
  //         $data_container_dtl2 = array(
  //             'p_jurnal' => $nofaktur,
  //             'p_cont_type' =>  $container_id2_truck[$iii],
  //             'p_cont_number' => $container_number2_truck[$iii],
  //             'p_seal' => $seal_number2_truck[$iii],
  //             'p_contid' => $contid2_truck[$iii],
  //             'p_jenis_trans' => 'SIJV',
  //             'p_jenis_jurnal' => $typeinv
  //         );
  //         // $this->M_Sales_inv2->call_save_container_dtl2_truck($data_container_dtl2);
  //     }
  //     // $this->M_Sales_inv2->call_save_container_dtl2_truck($data_container_dtl2);


  //     // insert header
  //     $data_header = array(
  //         'p_perintah' => $perintah,
  //         'p_nofaktur' => $nofaktur,
  //         'p_company_id' => 'ZHL',
  //         'p_tanggal' => $p_tanggal,
  //         'p_tanggal_tempo' => $p_tanggal_tempo,
  //         'p_tanggal_invoice' => $p_tanggal_invoice,
  //         'p_kode_sup' => $supplier,
  //         'p_jenis_trans' => 'SIJV',
  //         'p_currency_id' => $this->input->post('Currency'),
  //         'p_term' => $term,
  //         'p_rate' => $rate,
  //         'p_rate_sgd' => $rate_sgd,
  //         'p_pajak' => round(str_replace(",", "",$total_gst),2),
  //         'p_diskon' => 0,
  //         'p_biaya_lain' => 0,
  //         'p_uang_muka' => 0,
  //         'p_hutang' => round(str_replace(",", "",$totalamount),2),
  //         'p_status' => '0',
  //         'p_created_by' => $created_by,
  //         'p_ip_address' => $ip_address,
  //         'p_nocoa' => 0,
  //         'p_status_dp' => 0,
  //         'p_jenin' => $typeinv,
  //         'p_voyage' => $bargename,
  //         'p_buyer' => $buyer,
  //         'p_bargedest' => $barge_dest,
  //         'p_shipmentdate' => $ship_date,
  //         'p_etadate' => $eta_date,
  //         'p_etddate' => $etd_date
  //     );
  //     // $this->M_Sales_inv2->call_sp_rec_piutang($data_header);

  //     echo $nofaktur;
  //     // $this->db->trans_begin();
  //         if($perintah = 'edit'){
  //             $this->hapus($nofaktur);
  //         }

  //         for($i = 0; $i < count($dtlcont); $i++){
  //             $this->call_save_dtl($data_detail);
  //         }

  //         for($ii = 0; $ii < count($container_id); $ii++){
  //             $this->call_save_container_dtl($data_container_dtl);
  //         }

  //         for($iii = 0; $iii < count($container_id2); $iii++){
  //             $this->call_save_container_dtl2($data_container_dtl2);
  //         }

  //         for($ii = 0; $ii < count($container_id_truck); $ii++){
  //             $this->call_save_container_dtl_truck($data_container_dtl);
  //         }

  //         for($iii = 0; $iii < count($container_id2_truck); $iii++){
  //             $this->call_save_container_dtl2_truck($data_container_dtl2);
  //         }

  //         $this->call_sp_rec_piutang($data_header);

  //     // if ($this->db->trans_status() === FALSE)
  //     // {
  //     //     $this->db->trans_rollback();
  //     // }
  //     // else
  //     // {
  //     //     $this->db->trans_commit();
  //     // }

  //     return $nofaktur;


  // }
}
