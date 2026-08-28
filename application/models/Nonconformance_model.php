<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Nonconformance_model extends CI_Model
{
    // function getShipment($param)
    // {
    //     $this->db->select("barge, voyage,etd, b.container, shipping");
    //     $this->db->join("ship_tbl_trn_cont_dtl b", "a.contid = b.contid");
    //     $this->db->where("shipmentdate", "2023-07-11");
    //     $this->db->where("etd", "RSUP");
    //     $this->db->where("tipe", 2);
    //     $this->db->group_by("b.container");

    //     return $this->db->get("ship_tbl_trn_cont_hdr a")->result();
    // }

    function getAllShipmentDetailByParam($param)
    {
        $this->db->select("*");
        if (isset($param['shipment_date']) && strlen($param['shipment_date']) > 0) {
            $this->db->where("shipmentdate", $param['shipment_date']);
        }
        if (isset($param['factory_abbr']) && strlen($param['factory_abbr']) > 0) {
            $this->db->where("factory_abbr", $param['factory_abbr']);
        }
        if (isset($param['container_number'])) {
            $this->db->where("container", $param['container_number']);
        }
        $this->db->group_by("container");

        return $this->db->get("zhl_ship_vw_summary_report")->result();
    }

    function getCnByContid($contid)
    {
        $this->db->select('container_number');
        $this->db->where('contid', $contid);
        return $this->db->get('ship_tbl_trn_cont_non_conformance')->result();
    }

    function getShipByContid($contid, $containerNumber)
    {
        $this->db->where('contid', $contid);
        $this->db->where('container', $containerNumber);

        return $this->db->get('zhl_ship_vw_summary_report')->result();
    }

    function store($param, $userId)
    {


        $data = [
            "contid" => $param['contid'],
            "container_number" => $param['container_number'],
            "issue" => $param['contid'],
            "status" => $param['status'],
            "qad_remarks" => $param['qad_remarks'],
            "created_by" => $userId,
            "created_date" => date("Y-m-d H:i:s"),
        ];


        $inserted = $this->db->insert("ship_tbl_trn_cont_non_conformance", $data);

        $id = $this->db->insert_id();

        if ($inserted) {
            // 0: belum dilakukan conformance; 1: menunggu zhl; 2: verifikasi qad; 5: complete
            $this->db->where('id', $param['cont_detailid']);
            $this->db->update('ship_tbl_trn_cont_dtl', ['complete_non_conformance' => 1]);

            return $id;
        }

        return false;
    }




    //////////Monitoring Conformance//////////////////////

    // function getContainerConformance($param)
    // {
    //     // Ambil data dari tabel 'ship_tbl_trn_cont_non_conformance'
    //     $this->db->select('a.*, a.id as conformance_id, a.qad_verification, b.shipping, b.factory_abbr, b.shipmentdate, b.cont_dtl_id, b.complete_non_conformance');
    //     $this->db->from('ship_tbl_trn_cont_non_conformance a');
    //     $this->db->join('zhl_ship_vw_summary_report b', 'a.container_number = b.container', 'left');
    //     // $this->db->join('zhl_ship_vw_summary_report b', 'a.contid = b.contid and a.container_number = b.container_number_factory');
    //     if (strlen($param['shipment_date']) > 0) {
    //         $this->db->where('shipmentdate', $param['shipment_date']);
    //     }
    //     $this->db->where("a.complete_by is not null", false, false);
    //     $this->db->limit(1000);
    //     $this->db->group_by('a.container_number, b.factory_abbr');
    //     $this->db->order_by('b.complete_non_conformance asc');
    //     $sql = $this->db->get()->result();

    //     // Ambil data dari 'zhl_ship_vw_summary_report' yang memiliki 'container_number'
    //     // yang ada di tabel 'ship_tbl_trn_cont_non_conformance'
    //     $this->db->select('a.container, a.po_number, a.description, a.shipid, a.contid, a.barge, a.factory_abbr, a.shipmentdate, a.shipping, b.customer_name');
    //     $this->db->from('zhl_ship_vw_summary_report a');
    //     $this->db->join('mar_tblmst_customer b', 'a.customer_id = b.customer_id');
    //     $this->db->where("a.container IN (SELECT container_number FROM ship_tbl_trn_cont_non_conformance)", NULL, FALSE);
    //     $this->db->limit(1000);

    //     $contExport = $this->db->get()->result();

    //     $contConformanceFile = $this->db->get('ship_tbl_trn_cont_non_conformance_file')->result();

    //     // Buat dictionary dari hasil kueri dengan menggunakan 'container_number' sebagai kunci
    //     $contExportDictionary = array();
    //     foreach ($contExport as $cont) {
    //         $contExportDictionary[$cont->container][] = $cont;
    //     }

    //     $conformnaceFile = array();

    //     foreach ($contConformanceFile as $conf) {
    //         $conformnaceFile[$conf->conformance_id][] = $conf;
    //     }

    //     $data = [
    //         'containerNonConformance' => $sql,
    //         'contExport' => $contExportDictionary,
    //         'conformanceFile' => $conformnaceFile
    //     ];

    //     return $data;
    // }

    function getContainerConformance($param, $startDate = null, $endDate = null)
    {

        $this->db->select('
            *,
            a.id as conformance_id,
            b.complete_non_conformance as complete_non_conformance,
            b.id as cont_dtl_id,
            0 as is_ggfs
        ');
        $this->db->from('ship_tbl_trn_cont_non_conformance a');
        $this->db->join('ship_tbl_trn_cont_dtl b', 'b.container = a.container_number AND b.contid = a.contid');

        if (strlen($param['shipment_date']) > 0) {
            $this->db->where('a.shipment_date', $param['shipment_date']);
        }
        if (!empty($param['qad_verification'])) {
            $this->db->where('a.qad_verification', $param['qad_verification']);
        }
        if (!empty($param['factory_abbr'])) {
            $this->db->where('a.factory_abbr', $param['factory_abbr']);
        }
        $this->db->group_by('a.container_number, a.factory_abbr');

        $sql1 = $this->db->get_compiled_select();

        $this->db->select('
            *,
            a.id as conformance_id,
            b.complete_non_conformance_ggfs as complete_non_conformance,
            b.id_ggfs as cont_dtl_id,
            1 as is_ggfs
        ');
        $this->db->from('ship_tbl_trn_cont_non_conformance a');
        $this->db->join('ship_tbl_trn_cont_dtl_ggfs b', 'b.container_ggfs = a.container_number AND b.contid = a.contid');

        if (strlen($param['shipment_date']) > 0) {
            $this->db->where('a.shipment_date', $param['shipment_date']);
        }
        if (!empty($param['qad_verification'])) {
            $this->db->where('a.qad_verification', $param['qad_verification']);
        }
        if (!empty($param['factory_abbr'])) {
            $this->db->where('a.factory_abbr', $param['factory_abbr']);
        }
        $this->db->group_by('a.container_number, a.factory_abbr');

        $sql2 = $this->db->get_compiled_select();

        // Gabungkan dengan UNION
        $union_sql = $sql1 . ' UNION ' . $sql2 . ' LIMIT 100';

        $sql = $this->db->query($union_sql)->result();

        // Ambil data dari 'zhl_ship_vw_summary_report' yang memiliki 'container_number'
        // yang ada di tabel 'ship_tbl_trn_cont_non_conformance'


        // $this->db->select('a.container, a.po_number, a.description, a.shipid, a.contid, a.barge, a.factory_abbr, a.shipmentdate, a.shipping, b.customer_name');

        #QUERY LAMA, LOAD DATA LAMBAT (26 DETIK) ~FAUZY
        // $this->db->select('a.container, a.po_number, a.description, b.customer_name');
        // $this->db->from('zhl_ship_vw_summary_report a');
        // $this->db->join('mar_tblmst_customer b', 'a.customer_id = b.customer_id');
        // $this->db->where("a.container IN (SELECT container_number, factory_abbr FROM ship_tbl_trn_cont_non_conformance where shipment_date = '$param[shipment_date]')", NULL, FALSE);
        // $this->db->order_by('a.shipmentdate', 'DESC');
        // $this->db->limit(100);

        // LEBIH CEPAT (3 DETIK) ~FAUZY
        $this->db->select('a.container, a.po_number, a.description, b.customer_name, a.shipmentdate');
        $this->db->from('zhl_ship_vw_summary_report a');
        $this->db->join('mar_tblmst_customer b', 'a.customer_id = b.customer_id');
        $this->db->join('ship_tbl_trn_cont_non_conformance c', 'a.container = c.container_number and c.contid = a.contid');
        $this->db->where('c.shipment_date', $param['shipment_date']);
        $sql1 = $this->db->get_compiled_select();

        // Query 2: dari zhl_ship_vw_summary_report_ggfs
        $this->db->select('a.container, a.po_number, a.description, b.customer_name, a.shipmentdate');
        $this->db->from('zhl_ship_vw_summary_report_ggfs a');
        $this->db->join('mar_tblmst_customer b', 'a.customer_id = b.customer_id');
        $this->db->join('ship_tbl_trn_cont_non_conformance c', 'a.container = c.container_number and c.contid = a.contid');
        $this->db->where('c.shipment_date', $param['shipment_date']);
        $sql2 = $this->db->get_compiled_select();

        // Gabungkan dengan UNION ALL, sorting & limit di query luar
        $union_sql = "SELECT * FROM (($sql1) UNION ALL ($sql2)) as combined 
                    ORDER BY shipmentdate DESC 
                    LIMIT 100";

        $contExport = $this->db->query($union_sql)->result();

        $contConformanceFile = $this->db->get('ship_tbl_trn_cont_non_conformance_file')->result();

        // Buat dictionary dari hasil kueri dengan menggunakan 'container_number' sebagai kunci
        $contExportDictionary = array();
        foreach ($contExport as $cont) {
            $contExportDictionary[$cont->container][] = $cont;
        }

        $conformnaceFile = array();
        foreach ($contConformanceFile as $conf) {
            $conformnaceFile[$conf->conformance_id][] = $conf;
        }

        // pastikan semua conformance_id dari $sql punya entry, walau kosong
        foreach ($sql as $row) {
            if (!isset($conformnaceFile[$row->conformance_id])) {
                $conformnaceFile[$row->conformance_id] = [];
            }
        }

        $data = [
            'containerNonConformance' => $sql,
            'contExport' => $contExportDictionary,
            'conformanceFile' => $conformnaceFile
        ];

        return $data;
    }

    // ===================================== ini yang bisa ==============================================================================
    // function getContainerConformance($param, $startDate = null, $endDate = null)
    // {
    //     // Ambil data dari tabel 'ship_tbl_trn_cont_non_conformance'
    //     $this->db->select('*, a.id as conformance_id, b.complete_non_conformance, b.id as cont_dtl_id');
    //     $this->db->from('ship_tbl_trn_cont_non_conformance a');
    //     $this->db->join('ship_tbl_trn_cont_dtl b', 'b.container = a.container_number AND b.contid = a.contid');
        
    //     if (strlen($param['shipment_date']) > 0) {
    //         $this->db->where('a.shipment_date', $param['shipment_date']);
    //     }
    //     if (!empty($param['qad_verification'])) {
    //         $this->db->where('a.qad_verification', $param['qad_verification']);
    //     }
    //     if (!empty($param['factory_abbr'])) {
    //         $this->db->where('a.factory_abbr', $param['factory_abbr']);
    //     }
    //     $this->db->group_by('a.container_number, a.factory_abbr');
    //     $this->db->limit(100);
    //     $sql = $this->db->get()->result();

    //     // Ambil data dari 'zhl_ship_vw_summary_report' yang memiliki 'container_number'
    //     // yang ada di tabel 'ship_tbl_trn_cont_non_conformance'


    //     // $this->db->select('a.container, a.po_number, a.description, a.shipid, a.contid, a.barge, a.factory_abbr, a.shipmentdate, a.shipping, b.customer_name');

    //     #QUERY LAMA, LOAD DATA LAMBAT (26 DETIK) ~FAUZY
    //     // $this->db->select('a.container, a.po_number, a.description, b.customer_name');
    //     // $this->db->from('zhl_ship_vw_summary_report a');
    //     // $this->db->join('mar_tblmst_customer b', 'a.customer_id = b.customer_id');
    //     // $this->db->where("a.container IN (SELECT container_number, factory_abbr FROM ship_tbl_trn_cont_non_conformance where shipment_date = '$param[shipment_date]')", NULL, FALSE);
    //     // $this->db->order_by('a.shipmentdate', 'DESC');
    //     // $this->db->limit(100);

    //     // LEBIH CEPAT (3 DETIK) ~FAUZY
    //     $this->db->select('a.container, a.po_number, a.description, b.customer_name');
    //     $this->db->from('zhl_ship_vw_summary_report a');
    //     $this->db->join('mar_tblmst_customer b', 'a.customer_id = b.customer_id');
    //     $this->db->join('ship_tbl_trn_cont_non_conformance c', 'a.container = c.container_number and c.contid = a.contid'); // Ada tambah join di a.contid
    //     $this->db->where("c.shipment_date", $param['shipment_date']);
    //     $this->db->order_by('a.shipmentdate', 'DESC');
    //     $this->db->limit(100);




    //     $contExport = $this->db->get()->result();

    //     $contConformanceFile = $this->db->get('ship_tbl_trn_cont_non_conformance_file')->result();

    //     // Buat dictionary dari hasil kueri dengan menggunakan 'container_number' sebagai kunci
    //     $contExportDictionary = array();
    //     foreach ($contExport as $cont) {
    //         $contExportDictionary[$cont->container][] = $cont;
    //     }

    //     $conformnaceFile = array();

    //     foreach ($contConformanceFile as $conf) {
    //         $conformnaceFile[$conf->conformance_id][] = $conf;
    //     }

    //     $data = [
    //         'containerNonConformance' => $sql,
    //         'contExport' => $contExportDictionary,
    //         'conformanceFile' => $conformnaceFile
    //     ];

    //     return $data;
    // }

    // function verifikasi($param)
    // {
    //     $this->db->trans_begin();

    //     try {
    //         $detail_ids = array_filter(array_map('trim', explode(',', $param['cont_detailid'])));
    //         $conf_ids   = array_filter(array_map('trim', explode(',', $param['conformance_id'])));
    //         $statusArr  = array_map('trim', explode(',', $param['status']));

    //         if ($param['status'] == 'Hold' || $param['status'] == 'Reject') {
    //             $complete = 2;
    //         } else {
    //             $complete = 5;
    //         }
    //         $this->db->where_in("id", $detail_ids);
    //         $updateConformance = $this->db->update('ship_tbl_trn_cont_dtl', [
    //             'complete_non_conformance' => $complete,
    //             'complete_by' => $this->session->userdata("userid_1"),
    //             'complete_date' => date("Y-m-d H:i:s")
    //         ]);

    //         if ($updateConformance) {
    //             $this->db->where_in('id', $conf_ids);
    //             $updateRemarks = $this->db->update('ship_tbl_trn_cont_non_conformance', [
    //                 'zhl_remarks' => $param['zhl_remarks'],
    //                 'complete_by_zhl' => $this->session->userdata("userid_1"),
    //                 'complete_date_zhl' => date("Y-m-d H:i:s")

    //             ]);

    //             if ($updateRemarks) {
    //                 $this->db->trans_commit();
    //                 return true;
    //             } else {
    //                 $this->db->trans_rollback();
    //                 return false;
    //             }
    //         } else {
    //             $this->db->trans_rollback();
    //             return false;
    //         }
    //     } catch (Exception $e) {
    //         $this->db->trans_rollback();
    //         return false;
    //     }
    // }

    function verifikasi($param) {
        $this->db->trans_begin();
        try {
            $detail_ids = array_filter(array_map('trim', explode(',', $param['cont_detailid'])));
            $conf_ids   = array_filter(array_map('trim', explode(',', $param['conformance_id'])));
            $statusArr  = array_map('trim', explode(',', $param['status']));
            $statusIsGgfs  = array_map('trim', explode(',', $param['is_ggfs']));

            foreach ($detail_ids as $key => $id) {
                $currentStatus = isset($statusArr[$key]) ? $statusArr[$key] : '';
                $currentIsGgfs = isset($statusIsGgfs[$key]) ? $statusIsGgfs[$key] : 0;

                if ($currentStatus == 'Hold' || $currentStatus == 'Reject') {
                    $complete = 2;
                } else {
                    $complete = 5;
                }

                if ($currentIsGgfs == 1) {
                    $this->db->where("id_ggfs", $id);
                    $this->db->update('ship_tbl_trn_cont_dtl_ggfs', [
                        'complete_non_conformance_ggfs' => $complete,
                        'complete_by'   => $this->session->userdata("userid_1"),
                        'complete_date' => date("Y-m-d H:i:s")
                    ]);
                } else {
                    $this->db->where("id", $id);
                    $this->db->update('ship_tbl_trn_cont_dtl', [
                        'complete_non_conformance' => $complete,
                        'complete_by'   => $this->session->userdata("userid_1"),
                        'complete_date' => date("Y-m-d H:i:s")
                    ]);
                }
            }

            $this->db->where_in('id', $conf_ids);
            $updateRemarks = $this->db->update('ship_tbl_trn_cont_non_conformance', [
                'zhl_remarks'       => $param['zhl_remarks'],
                'complete_by_zhl'   => $this->session->userdata("userid_1"),
                'complete_date_zhl' => date("Y-m-d H:i:s")
            ]);

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                return false;
            } else {
                $this->db->trans_commit();
                return true;
            }
        } catch (Exception $e) {
            $this->db->trans_rollback();
            return false;
        }
    }
    
    public function getEmailsByConformanceId($isSent)
    {
        $this->db->select('emailAddress, username');
        $this->db->from('ch_emailcontainerissue');
        $this->db->where('isSent', $isSent);
        $query = $this->db->get();
        
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    function getContainerNumberInfo($conformance_id)
    {
        $this->db->select('container_number, factory_abbr,created_date, status, issue, zhl_remarks');
        $this->db->from('ship_tbl_trn_cont_non_conformance');
        $this->db->where_in('id', $conformance_id);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            // return $query->row()->container_number;
            return $query->result();
        } else {
            return false;
        }
    }

    function logSendSuccess($data){
        $save = [
            "emailReceiver" => $data['emailReceiver'],
            "containerName" => $data['containerName'],
            "dateSent" => $data['dateSent'],
            "statusCode" => $data['statusCode'],
            "message" => $data['message']
        ];

        return $this->db->insert('ch_tbllogemail', $save);
    }
}
