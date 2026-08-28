<?php

/**
 * author : ITD16 ( F. Chaniago )
 */
class M_Sales_inv extends CI_Model
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

    function get_piutang()
    {
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
        return $this->db->query("SELECT rate, SUM(amount) AS JUMLAH FROM zhl_acc_tbl_trn_si_fac_dtl_new WHERE HeaderID='$id'")->result();
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

    public function get_dtl_bargefreight($shp_date, $sup, $vessel)
    {
        $this->db->select('*');
        $this->db->from('zhl_shp_vw_detail_bargefreight_new');
        $this->db->where('ship_board_date', $shp_date);
        $this->db->where('vesel', $vessel);
        if ($sup != '') {
            $this->db->where('customer_code', $sup);
        }
        return $this->db->get()->result();
    }

    function get_data_detail2($id)
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
            $this->db->query("DELETE FROM zhl_acc_tbl_trn_jurnal where NoJurnal = '" . $nofaktur . "' AND jenis_trans = 'SIJV' ");
            $this->db->query("DELETE FROM zhl_acc_tbl_trn_si_fac_dtl_new where HeaderID = '" . $nofaktur . "'");
            $this->db->query("DELETE FROM zhl_acc_tbl_trn_gst WHERE ref_nomor = '" . $nofaktur . "' AND jenis_trans = 'SIJV' ");
            $this->db->query("DELETE FROM zhl_acc_tbl_trn_dtl_container WHERE NoJurnal = '" . $nofaktur . "' AND jenis_trans = 'SIJV' ");
            $this->db->query("DELETE FROM zhl_acc_tbl_trn_dtl_container_trucking WHERE NoJurnal = '" . $nofaktur . "' AND jenis_trans = 'SIJV' ");
            $this->db->query("UPDATE zhl_acc_tbl_trn_piutang SET piutang = 0, Keterangan = 'cancel' WHERE nofaktur = '" . $nofaktur . "' AND jenis_trans = 'SIJV' ");
            $this->db->query("DELETE FROM zhl_acc_tbl_trn_piutang_bulanan WHERE nofaktur = '" . $nofaktur . "' AND jenis_trans = 'SIJV' ");
            $this->db->query("UPDATE ship_tbl_trn_cont_dtl SET jurnal_barge_sales = NULL WHERE jurnal_barge_sales = '" . $nofaktur . "'");
            $this->db->query("UPDATE ship_tbl_trn_cont_local_dtl SET bargejurnal = NULL WHERE bargejurnal = '" . $nofaktur . "'");
            $this->db->query("UPDATE ship_tbl_trn_cont_dtl SET jurnal_trucking = NULL WHERE jurnal_trucking = '" . $nofaktur . "'");
            $this->db->query("UPDATE ship_tbl_trn_cont_local_dtl SET jurnal_trucking = NULL WHERE jurnal_trucking = '" . $nofaktur . "'");
        }
        echo "2";
    }

    function call_save_dtl($data)
    {
        $qry = 'call zhl_spSaveSalesInvDtl(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
        $sql = $this->db->query($qry, $data);

        $sql->next_result();
        $sql->free_result();
    }

    function call_sp_rec_piutang($data)
    {
        // $this->db->begin();
        $qry = 'call zhl_sp_acc_tbl_trn_piutang_new(?, ?, ?,?,?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?, ?, ?)';
        $sql = $this->db->query($qry, $data);


        // $sql->next_result();
        // $sql->free_result();
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
    function getAjaxTanggal($id, $bargedest)
    {
        if (empty($id)) {
            $sql_prov = $this->db2->query("SELECT DISTINCT shipmentdate FROM ship_vw_trn_cont Where shipmentdate < '2010-01-01'");
        } else {

            if ($id == 'bar') {
                $etda = '';
                $sql = " AND (jurnal_barge_sales IS NULL OR jurnal_barge_sales = '') ";
                if ($bargedest == 'idn' || $bargedest == 'idn2') {
                    $sql = $sql . " AND (stuffing IN ('EE', 'IT', 'EE_TP')) ";
                    if ($bargedest == 'idn') {
                        $sql = $sql . " AND etd = 'PSG' ";
                        $etda = " AND etd = 'PSG' ";
                    } else {
                        $sql = $sql . " AND etd = 'RSUP' ";
                        $etda = " AND etd = 'RSUP' ";
                    }
                } else if ($bargedest == 'sin' || $bargedest == 'sin2') {
                    $sql = $sql . " AND (stuffing IN ('EL', 'IL') ) ";
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
            $a = "SELECT DISTINCT shipmentdate FROM ship_vw_trn_cont Where tipe = 2 " . $sql . " AND shipmentdate > '2018-01-01'
                    UNION
                  SELECT DISTINCT shipmentdate FROM ship_vw_container_local where shipmentdate > '2018-01-01' AND bargejurnal IS NULL AND stuffing = 'LL' " . $etda;
            // echo $a;
            $sql_prov = $this->db2->query("SELECT DISTINCT shipmentdate FROM ship_vw_trn_cont Where tipe = 2 " . $sql . " AND shipmentdate > '2018-01-01'
                    UNION
                  SELECT DISTINCT shipmentdate FROM ship_vw_container_local where shipmentdate > '2018-01-01' AND bargejurnal IS NULL AND stuffing IN ('LL','LO','EI') " . $etda);
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

    function getAjaxTanggal2($id, $bargedest)
    {
        $cari = 0;
        $sql = '';
        if (empty($id)) {
            $sql_prov = $this->db2->query("SELECT DISTINCT shipmentdate FROM ship_vw_trn_cont Where shipmentdate < '2010-01-01'");
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

            $a = "SELECT DISTINCT shipmentdate FROM ship_vw_container_local Where shipmentdate > '2018-01-01' " . $sql;
            if ($cari == 1) {
                $sql_prov = $this->db2->query("SELECT DISTINCT shipmentdate FROM ship_vw_container_local Where shipmentdate > '2018-01-01' " . $sql);
            } else {
                $sql_prov = $this->db2->query("SELECT DISTINCT shipmentdate FROM ship_vw_trn_cont Where shipmentdate < '2010-01-01'");
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

    function get_2ft($tgl, $bargedest)
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
            $sql1 = "SELECT container_size, count(seal) AS Jumlah_container FROM (
                SELECT DISTINCT container_id as contid, TRIM(barge) AS barge, seal, container_size
                FROM ship_vw_trn_cont where container != '' AND container_size in (20, 40) AND shipmentdate = '" . $tgl . "' AND tipe = 2 " . $sql . " ) A
                GROUP BY container_size";
            // echo $sql1;
            return $this->db2->query($sql1)->result();
        } else {
            $sql = " AND (jurnal_barge_sales IS NULL OR jurnal_barge_sales = '') AND jurnal_trucking IS NULL ";
            $sql = $sql . " AND (stuffing IN ('EE')) ";
            $stf = 'A.stuffing,';
            if ($bargedest == 'idn') {
                $sql = $sql . " AND etd = 'PSG' ";
            } else {
                $sql = $sql . " AND etd = 'RSUP' ";
            }
            // $sql = $sql." AND (stuffing IN ('EE', 'IT')) ";
            //         if($bargedest == 'idn'){
            //             $sql = $sql." AND etd = 'PSG' ";
            //             $etda = " AND etd = 'PSG' ";
            //         }else{
            //             $sql = $sql." AND etd = 'RSUP' ";
            //             $etda = " AND etd = 'RSUP' ";
            //         }
            $sql1 = "SELECT container_size, count(seal) AS Jumlah_container FROM (
                SELECT DISTINCT container_id as contid, TRIM(barge) AS barge, seal, container_size
                FROM ship_vw_trn_cont where container != '' AND container_size in (20, 40) AND shipmentdate = '" . $tgl . "' AND tipe = 2 " . $sql . " ) A
                GROUP BY container_size";
            // echo $sql1;
            return $this->db2->query($sql1)->result();
        }
    }

    function get_isidetail2($tgl, $bargedest)
    {
        $sql = " AND (jurnal_barge_sales IS NULL OR jurnal_barge_sales = '') ";
        if ($bargedest == 'idn' || $bargedest == 'idn2') {
            $sql = $sql . " AND (stuffing IN ('EE', 'IT', 'RE')) ";
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
                $sql = $sql . " AND etd = 'PSG' ";
            } else {
                $sql = $sql . " AND etd = 'RSUP' ";
            }
        } else {
            $sql = '';
            $stf = '';
        }

        $sql1 = "SELECT A.contid, A.barge,A.container_id,  A.container_name, count(seal) AS Jumlah_container, A.eta, A.etd, A.etadate, A.etddate, A.stuffing  FROM (
                SELECT DISTINCT container_id as contid, TRIM(barge) AS barge, voyage, container as container_id, container_name, seal, etd, eta, etadate, etddate, stuffing 
                FROM ship_vw_trn_cont where container != '' AND shipmentdate = '" . $tgl . "' AND tipe = 2 " . $sql . " ) A
                GROUP BY A.container_name, A.stuffing";
        // echo $sql1;

        return $this->db2->query($sql1)->result();
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
                FROM ship_vw_trn_cont where container != '' AND container_size in (20, 40) AND shipmentdate = '" . $tgl . "' AND tipe = 2 " . $sql;
            // $sql1 = "SELECT container_size, count(seal) AS Jumlah_container FROM (
            //     SELECT DISTINCT container_id as contid, TRIM(barge) AS barge, seal, container_size
            //     FROM ship_vw_trn_cont where container != '' AND container_size in (20, 40) AND shipmentdate = '".$tgl."' AND tipe = 2 ".$sql." ) A
            //     GROUP BY container_size";
            // echo $sql1;
            return $this->db2->query($sqlite)->result();
        } else {
            $sql = " AND (jurnal_barge_sales IS NULL OR jurnal_barge_sales = '') AND jurnal_trucking IS NULL ";
            // $sql = $sql." AND (stuffing IN ('EL', 'IL')) ";
            $sql = $sql . " AND (stuffing IN ('EE')) ";
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
    }

    function get_isidetail3($tgl, $bargedest)
    {
        $sql = " AND (jurnal_barge_sales IS NULL OR jurnal_barge_sales = '') ";
        if ($bargedest == 'idn' || $bargedest == 'idn2') {
            $sql = $sql . " AND (stuffing IN ('EE', 'IT', 'RE')) ";
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
                $sql = $sql . " AND etd = 'PSG' ";
            } else {
                $sql = $sql . " AND etd = 'RSUP' ";
            }
        } else {
            $sql = '';
            $stf = '';
        }

        $sqlite = "SELECT DISTINCT contid, container_id, container_name, seal, container, stuffing
                FROM ship_vw_trn_cont where container != '' AND shipmentdate = '" . $tgl . "' AND tipe = 2 " . $sql;

        return $this->db2->query($sqlite)->result();
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
        SELECT container_id as contid, container_size FROM ship_vw_container_local  
        where container_number != '' AND container_size in (20, 40) AND customer = '" . $sup . "' AND shipmentdate = '" . $tgl . "' " . $sql . " ) A
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

        $sqlit = " SELECT A.contid, A.container_id, A.container_name, count(A.container_name) AS Jumlah_container, A.eta, A.etd, A.etadate, A.etddate, A.stuffing    FROM (
        SELECT container_id as contid, container_number as container_id, container_type as container_name, etd, eta, etadate, etddate, stuffing FROM ship_vw_container_local  
        where container_number != '' AND customer = '" . $sup . "' AND shipmentdate = '" . $tgl . "' " . $sql . " ) A
        GROUP BY A.container_name, A.stuffing ";
        // echo $sqlit;
        return $this->db2->query($sqlit)->result();
    }

    function get_2ft3($tgl, $bargedest)
    {
        $invtype = $this->input->get('invtype');
        $sql = "";
        if ($invtype == 'lem') {
            // if($bargedest == 'idn' || $bargedest == 'idn2'){ 
            //     $sql = " AND bargejurnal IS NULL AND jurnal_trucking IS NULL "; 
            //     $sql = $sql." AND stuffing = 'LE' ";
            //     $stf = '';
            //     if($bargedest == 'idn'){
            //         $sql = $sql." AND etd = 'PSG' ";
            //     }else{
            //         $sql = $sql." AND etd = 'RSUP' ";
            //     }
            // }else{
            //     $sql = '';
            //     $stf = '';
            // }
            $sql = "";
        } else {
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
        }

        if ($sql != "") {
            $sqlit = " SELECT count(A.contid) AS Jumlah_container, A.container_size    FROM (
            SELECT container_id as contid, container_size FROM ship_vw_container_local  
            where container_number != '' AND container_size in (20,40) AND shipmentdate = '" . $tgl . "' " . $sql . " ) A
            GROUP BY A.container_size ";
            // echo $sqlit;
            return $this->db2->query($sqlit)->result();
        }
    }

    function get_isilclcont2($tgl, $bargedest)
    {
        $invtype = $this->input->get('invtype');
        $sql = "";
        if ($invtype == 'lem') {
            if ($bargedest == 'idn' || $bargedest == 'idn2') {
                $sql = " AND bargejurnal IS NULL ";
                $sql = $sql . " AND stuffing = 'LE' ";
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
        } else {
            if ($bargedest == 'idn' || $bargedest == 'idn2') {
                $sql = " AND bargejurnal IS NULL ";
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
        }

        if ($sql != "") {
            $sqlit = " SELECT A.contid, A.container_id, A.container_name, count(A.container_name) AS Jumlah_container, A.eta, A.etd, A.etadate, A.etddate, A.stuffing    FROM (
            SELECT container_id as contid, container_number as container_id, container_type as container_name, etd, eta, etadate, etddate, stuffing FROM ship_vw_container_local  
            where container_number != '' AND shipmentdate = '" . $tgl . "' " . $sql . " ) A
            GROUP BY A.container_name, A.stuffing ";
            // echo $invtype;
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
                    FROM ship_vw_container_local  where container_number != '' AND container_size in (20, 40) AND customer = '" . $sup . "' AND shipmentdate = '" . $tgl . "' " . $sql . "";

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


        $sqlit = "SELECT contid, container_id, container_type as container_name, ' ' as seal, container_number as container, stuffing
         FROM ship_vw_container_local  where container_number != '' AND customer = '" . $sup . "' AND shipmentdate = '" . $tgl . "' " . $sql . "";

        return $this->db2->query($sqlit)->result();
    }

    function get_2ft3detail($tgl, $bargedest)
    {
        $invtype = $this->input->get('invtype');
        $sql = "";
        if ($invtype == 'lem') {
            // if($bargedest == 'idn' || $bargedest == 'idn2'){ 
            //     $sql = " AND bargejurnal IS NULL AND jurnal_trucking IS NULL "; 
            //     $sql = $sql." AND stuffing = 'LE' ";
            //     $stf = '';
            //     if($bargedest == 'idn'){
            //         $sql = $sql." AND etd = 'PSG' ";
            //     }else{
            //         $sql = $sql." AND etd = 'RSUP' ";
            //     }
            // }else{
            //     $sql = '';
            //     $stf = '';
            // }
            $sql = "";
        } else {
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
        }

        if ($sql != "") {
            $sqlit = "SELECT contid, container_id, container_type as container_name, ' ' as seal, container_number as container, stuffing
                        FROM ship_vw_container_local  where container_number != '' AND container_size in (20,40) AND shipmentdate = '" . $tgl . "' " . $sql . "";
            // $sqlit = " SELECT count(A.contid) AS Jumlah_container, A.container_size    FROM (
            // SELECT container_id as contid, container_size FROM ship_vw_container_local  
            // where container_number != '' AND container_size in (20,40) AND shipmentdate = '".$tgl."' ".$sql." ) A
            // GROUP BY A.container_size ";
            // echo $sqlit;
            return $this->db2->query($sqlit)->result();
        }
    }

    function get_isilclcontdtl2($tgl, $bargedest)
    {
        $invtype = $this->input->get('invtype');
        $sql = " AND bargejurnal IS NULL ";
        if ($invtype == 'lem') {
            if ($bargedest == 'idn' || $bargedest == 'idn2') {
                $sql = $sql . " AND (stuffing IN ('LE')) ";
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
        } else {
            if ($bargedest == 'idn' || $bargedest == 'idn2') {
                $sql = $sql . " AND (stuffing IN ('EI')) ";
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
        }


        $sqlit = "SELECT contid, container_id, container_type as container_name, ' ' as seal, container_number as container, stuffing
         FROM ship_vw_container_local  where container_number != '' AND shipmentdate = '" . $tgl . "' " . $sql . "";
        // echo $sqlit;
        return $this->db2->query($sqlit)->result();
    }



    function get_sup($tgl, $id)
    {
        if ($id == 'bar') {
            $sql = " AND (jurnal_barge_sales IS NULL OR jurnal_barge_sales = '') ";
        } else if ($id == 'fre') {
            $sql = " AND jurnal_freight_sales IS NULL ";
        } else if ($id == 'trn') {
            $sql = " AND jurnal_transport_sales IS NULL ";
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
        } else {
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

    function get_harga($idcon, $jenisinv)
    {
        if ($jenisinv == 'trucking20ft' || $jenisinv == 'trucking40ft') {
            if ($jenisinv == 'trucking20ft') {
                $ctr = 20;
            } else {
                $ctr = 40;
            }
            $query = "SELECT cust_trucking_price FROM zhl_tbl_mst_trucking where container_size = " . $ctr . " order by validity_until DESC LIMIT 1 ";
            $resi = $this->db->query($query)->row();
            if (!empty($resi)) {
                return $resi->cust_trucking_price;
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
            } else {
                $sql = "0";
            }

            $query = "SELECT " . $sql . " FROM zhl_shp_tblmst_bargecharges WHERE container_id = '" . $idcon . "' order by validity desc LIMIT 1 ";
            // echo $query;

            if ($jenisinv == 'EE' || $jenisinv == 'EL' || $jenisinv == 'IT' || $jenisinv == 'IL' || $jenisinv == 'LL' || $jenisinv == 'LE' || $jenisinv == 'RE' || $jenisinv == 'EI' || $jenisinv == 'LO') {
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

        $query = $this->db->query($sql)->row();
        $sdate = new DateTime($query->etadate);
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

        $query = $this->db->query($sql)->row();
        $sdate = new DateTime($query->etddate);
        $dateeta = date_format($sdate, 'd/m/Y');
        return $dateeta;
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

        $query = $this->db->query($sql)->row();
        // $sdate = new DateTime( $query->etddate);
        // $dateeta = date_format($sdate, 'd/m/Y');
        return $query->barge;
    }

    function geteta2($barge, $shipdate)
    {
        if ($barge == 'idn') {
            $sql = "SELECT etadate FROM ship_tbl_trn_cont_local_hdr where etd = 'PSG' AND shipmentdate = '$shipdate' LIMIT 1";
        } else if ($barge == 'idn2') {
            $sql = "SELECT etadate FROM ship_tbl_trn_cont_local_hdr where etd = 'RSUP' AND shipmentdate = '$shipdate' LIMIT 1";
        } else if ($barge == 'sin') {
            $sql = "SELECT etadate FROM ship_tbl_trn_cont_local_hdr where eta = 'PSG' AND shipmentdate = '$shipdate' LIMIT 1";
        } else if ($barge == 'sin2') {
            $sql = "SELECT etadate FROM ship_tbl_trn_cont_local_hdr where eta = 'RSUP' AND shipmentdate = '$shipdate' LIMIT 1";
        }
        $query = $this->db->query($sql)->row();
        $sdate = new DateTime($query->etadate);
        $dateeta = date_format($sdate, 'd/m/Y');
        return $dateeta;
    }

    function getetd2($barge, $shipdate)
    {
        if ($barge == 'idn') {
            $sql = "SELECT etddate FROM ship_tbl_trn_cont_local_hdr where etd = 'PSG' AND shipmentdate = '$shipdate' LIMIT 1";
        } else if ($barge == 'idn2') {
            $sql = "SELECT etddate FROM ship_tbl_trn_cont_local_hdr where etd = 'RSUP' AND shipmentdate = '$shipdate' LIMIT 1";
        } else if ($barge == 'sin') {
            $sql = "SELECT etddate FROM ship_tbl_trn_cont_local_hdr where eta = 'PSG' AND shipmentdate = '$shipdate' LIMIT 1";
        } else if ($barge == 'sin2') {
            $sql = "SELECT etddate FROM ship_tbl_trn_cont_local_hdr where eta = 'RSUP' AND shipmentdate = '$shipdate' LIMIT 1";
        }
        $query = $this->db->query($sql)->row();
        $sdate = new DateTime($query->etddate);
        $dateeta = date_format($sdate, 'd/m/Y');
        return $dateeta;
    }

    function getbarge2($barge, $shipdate)
    {
        if ($barge == 'idn') {
            $sql = "SELECT CONCAT(barge,' / ',voyage) as barge FROM ship_tbl_trn_cont_local_hdr where etd = 'PSG' AND shipmentdate = '$shipdate' LIMIT 1";
        } else if ($barge == 'idn2') {
            $sql = "SELECT CONCAT(barge,' / ',voyage) as barge FROM ship_tbl_trn_cont_local_hdr where etd = 'RSUP' AND shipmentdate = '$shipdate' LIMIT 1";
        } else if ($barge == 'sin') {
            $sql = "SELECT CONCAT(barge,' / ',voyage) as barge FROM ship_tbl_trn_cont_local_hdr where eta = 'PSG' AND shipmentdate = '$shipdate' LIMIT 1";
        } else if ($barge == 'sin2') {
            $sql = "SELECT CONCAT(barge,' / ',voyage) as barge FROM ship_tbl_trn_cont_local_hdr where eta = 'RSUP' AND shipmentdate = '$shipdate' LIMIT 1";
        }
        $query = $this->db->query($sql)->row();
        return $query->barge;
    }

    // function get_detail_freigth($awal, $akhir){
    //     $sql = $this->db->query("SELECT A.invno, A.custcompany,  A.destination_id, A.destination,A.container_name, COUNT(container) as jumlah_container,
    //                 ponumberinv(A.invno) as po_num, A.Harga, A.contid, A.trading_term_name FROM (SELECT DISTINCT  A.invno, A.custcompany, A.docdate, D.container_name, C.destination_id, 
    //                 F.destination, F.container, IFNULL(H.cust_rates,0) AS Harga, C.container_id AS contid, J.trading_term_name  FROM ship_tbl_trn_inv_hdr A LEFT JOIN ship_tbl_trn_inv_dtl B 
    //                 ON A.invno = B.invno LEFT JOIN mar_tbltrn_purchase_order C ON B.ponumberid = C.po_hdr_id LEFT JOIN mar_tblmst_container D 
    //                 ON C.container_id = D.container_id LEFT JOIN mar_tbltrn_shipping_instruction_po E ON B.ponumberid = E.po_hdr_id LEFT JOIN 
    //                 ship_tbl_trn_cont_dtl F ON E.ship_id = F.shipid LEFT JOIN ship_tbl_trn_cont_hdr G ON F.contid = G.contid LEFT JOIN 
    //                 zhl_shp_tblmst_freightcharges H ON (C.destination_id = H.port_id AND C.container_id = H.container_id) 
    //                 LEFT JOIN mar_tbltrn_shipping_instruction I ON F.shipid = I.ship_id LEFT JOIN mar_tblmst_trading_term J ON I.trading_term_id = J.trading_term_id
    //                 where G.tipe = 2  AND (J.trading_term_id in (2,3))
    //                 AND A.docdate BETWEEN '".$awal."' AND '".$akhir."' AND F.jurnal_freight_sales IS NULL AND C.container_id not in (6,9)) 
    //                 A GROUP BY A.invno, A.custcompany, A.destination_id,  A.destination, A.container_name;");
    //     return $sql->result();
    // }

    function get_detail_freigth($awal, $akhir)
    {
        // $qry = "call zhl_get_data_freigth($awal,$akhir)";
        $sql = $this->db->query("call zhl_get_data_freigth('$awal','$akhir')");
        $res = $sql->result();
        $sql->next_result();
        $sql->free_result();

        return $res;
    }

    function get_detail_freigth2($awal, $akhir)
    {
        // $qry = "call zhl_get_data_freigth($awal,$akhir)";
        $sql = $this->db->query("call zhl_get_data_freigth('$awal','$akhir')");
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

    // ===================    END MODEL AJAX   (E.trading_term_id IN (2,3) OR E.ocean_freight in (15,16))  =============================================




}
