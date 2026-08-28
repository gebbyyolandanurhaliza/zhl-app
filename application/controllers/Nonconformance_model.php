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
        // Ambil data dari tabel 'ship_tbl_trn_cont_non_conformance'
        $this->db->select('*, id as conformance_id');
        $this->db->from('ship_tbl_trn_cont_non_conformance');
        // $this->db->join('zhl_ship_vw_summary_report b', 'a.container_number = b.container');
        if (strlen($param['shipment_date']) > 0) {
            $this->db->where('shipment_date', $param['shipment_date']);
        }
        if (!empty($param['qad_verification'])) {
            $this->db->where('qad_verification', $param['qad_verification']);
        }
        if ($param['factory_abbr'] != NULL || $param['factory_abbr'] != "") {
            $this->db->where('factory_abbr', $param['factory_abbr']);
        }
        $this->db->limit(1000);
        $this->db->group_by('container_number, factory_abbr');
        $sql = $this->db->get()->result();

        // Ambil data dari 'zhl_ship_vw_summary_report' yang memiliki 'container_number'
        // yang ada di tabel 'ship_tbl_trn_cont_non_conformance'
        $this->db->select('a.container, a.po_number, a.description, a.shipid, a.contid, a.barge, a.factory_abbr, a.shipmentdate, a.shipping, b.customer_name');
        $this->db->from('zhl_ship_vw_summary_report a');
        $this->db->join('mar_tblmst_customer b', 'a.customer_id = b.customer_id');
        $this->db->where("a.container IN (SELECT container_number FROM ship_tbl_trn_cont_non_conformance)", NULL, FALSE);
        $this->db->limit(1000);



        $contExport = $this->db->get()->result();

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

        $data = [
            'containerNonConformance' => $sql,
            'contExport' => $contExportDictionary,
            'conformanceFile' => $conformnaceFile
        ];

        return $data;
    }

    function verifikasi($param)
    {
        // Start the database transaction
        $this->db->trans_begin();

        try {
            if ($param['status'] == 'Hold' || $param['status'] == 'Reject') {
                $complete = 2;
            } else {
                $complete = 5;
            }
            $this->db->where("id", $param['cont_detailid']);
            $updateConformance = $this->db->update('ship_tbl_trn_cont_dtl', [
                'complete_non_conformance' => $complete,
                'complete_by' => $this->session->userdata("userid_1"),
                'complete_date' => date("Y-m-d H:i:s")
            ]);

            if ($updateConformance) {
                $this->db->where('id', $param['conformance_id']);
                $updateRemarks = $this->db->update('ship_tbl_trn_cont_non_conformance', [
                    'zhl_remarks' => $param['zhl_remarks'],
                    'complete_by_zhl' => $this->session->userdata("userid_1"),
                    'complete_date_zhl' => date("Y-m-d H:i:s")

                ]);

                if ($updateRemarks) {
                    $this->db->trans_commit();
                    return true;
                } else {
                    $this->db->trans_rollback();
                    return false;
                }
            } else {
                $this->db->trans_rollback();
                return false;
            }
        } catch (Exception $e) {
            $this->db->trans_rollback();
            return false;
        }
    }
}
