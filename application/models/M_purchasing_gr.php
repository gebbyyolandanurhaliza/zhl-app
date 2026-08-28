<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_purchasing_gr extends CI_Model
{
    //----------------------------------------------------------ABOUT GR------------------------------------------------------------
    function tampil_gr($data)
    {
        $this->db->distinct();
        $this->db->like('docno', $data);
        // $this->db->or_like('mainpo', $data);
        // $this->db->or_like('vendorid', $data);
        // $this->db->or_like('vendorcompany', $data);

        $this->db->order_by('docno', 'desc');

        // $result = $this->db->get('zhl_pur_vw_trn_gr');
        $result = $this->db->get('zhl_pur_vw_trn_gr_show');
        return $result->result();
    }

    function tampil_gr_where($data)
    {
        // $field = "a.*";
        $field = "a.*
        ,(select ifnull(sum(qty),0) from zhl_pur_tbl_trn_gr_dtl "
            . "where docno not in ('" . $data . "') and mainpo=a.mainpo and itemid=a.itemid"
            . ") as tqtywhs";

        $this->db->select($field);
        $this->db->from('zhl_pur_vw_trn_gr_show a');
        $this->db->where('a.docno', $data);

        $result = $this->db->get();
        return $result->result();
    }

    function getDocNo_gr()
    {
        $sql =  $this->db->get('zhl_pur_tbl_trn_gr_hdr');
        if ($sql->num_rows() > 0) {
            $this->db->select('max(docno) + 1 as docno');
            $data = $this->db->get('zhl_pur_tbl_trn_gr_hdr')->row();
            $result = $data->docno;
        } else {
            $result = 1;
        }

        return $result;
    }

    function delete_gr($data)
    {
        $row = $this->cek_docno($data);

        if ($row != 0) {
            $this->cek_status_del($data);
            $this->db->where('docno', $data);
            $this->db->delete('zhl_pur_tbl_trn_gr_hdr');

            $this->db->where('docno', $data);
            $this->db->delete('zhl_pur_tbl_trn_gr_dtl');

            $this->db->where('JenisJurnalID', 'GRD');
            $this->db->where('NoJurnal', $data);
            $this->db->delete('zhl_acc_tbl_trn_jurnal');

            $result = 0;
        } else {
            $result = 1;
        }
        return $result;
    }

    function delete_gr_sp($data)
    {
        $this->db->trans_begin();
        $this->db->query("SET @flag = 0");
        $this->db->query("call zhl_sp_pur_tbl_trn_gr_del('" . $data . "',@flag)");
        $query1 =  $this->db->query("Select @flag as flag")->row();

        $flag1 = $query1->flag;

        if ($flag1 == 0) {
            $this->db->trans_rollback();
            $data = array('flag' => $flag1);
            return $data;
        }

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $data = array('flag' => $flag1);
            return $data;
        } else {
            $this->db->trans_commit();
            $data = array('flag' => $flag1);
            return $data;
        }
    }

    function simpan_gr($datahdr)
    {
        $this->db->trans_begin();
        $itemid   = $this->input->post('ItemID');
        $itemname = $this->input->post('ItemName');
        $qty      = $this->input->post('Qty');
        $npbb     = $this->input->post('NPBB');
        $MainPO   = $this->input->post('MainPO');
        $jml      = count($itemid);

        $this->db->insert('zhl_pur_tbl_trn_gr_hdr', $datahdr);

        for ($i = 0; $i < $jml; $i++) {
            $datadtl =  array(
                'docno'       => $datahdr['docno'],
                'itemid'      => $itemid[$i],
                'itemname'    => $itemname[$i],
                'qty'         => $qty[$i],
                'npbbno'      => $npbb[$i],
                'mainpo'      => $MainPO[$i],
                'createdby'   => strtoupper($this->session->userdata('userid_1')),
                'createddate' => date('Y-m-d H:i:s')
            );
            $this->db->insert('zhl_pur_tbl_trn_gr_dtl', $datadtl);

            $this->cek_status_new($MainPO[$i], 1);
        }

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }

    function update_gr($docno, $datahdr)
    {
        $this->db->trans_begin();
        $itemid   = $this->input->post('ItemID');
        $itemname = $this->input->post('ItemName');
        $qty      = $this->input->post('Qty');
        $npbb     = $this->input->post('NPBB');
        $MainPO   = $this->input->post('MainPO');
        $invid    = $this->input->post('invid');
        $jml      = count($itemid);

        $this->db->where('docno', $docno);
        $this->db->update('zhl_pur_tbl_trn_gr_hdr', $datahdr);

        for ($i = 0; $i < $jml; $i++) {
            if ($invid[$i] == '0') {
                $datadtl = array(
                    'docno'           => $docno,
                    'itemid'          => $itemid[$i],
                    'itemname'        => $itemname[$i],
                    'qty'             => $qty[$i],
                    'npbbno'          => $npbb[$i],
                    'mainpo'          => $MainPO[$i],
                    'lastupdatedby'   => strtoupper($this->session->userdata('userid_1')),
                    'lastupdateddate' => date('Y-m-d H:i:s')
                );

                if ($qty[$i] != '0') {
                    $this->db->where('docno', $docno);
                    $this->db->where('mainpo ', $MainPO[$i]);
                    $this->db->where('itemid', $itemid[$i]);
                    $this->db->update('zhl_pur_tbl_trn_gr_dtl', $datadtl);

                    $this->cek_status_new($MainPO[$i], 1);
                }
                //                    else{
                //                        $this->db->where('docno',$docno);
                //                        $this->db->where('mainpo',$MainPO[$i]);
                //                        $this->db->where('itemid',$itemid[$i]);
                //                        $this->db->delete('pur_tbl_trn_gr_dtl');
                //                        
                //                        $this->cek_status_new($MainPO[$i],2);
                //                    }
            }
        }
        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }

    function simpan_gr_sp($datahdr)
    {
        $this->db->trans_begin();
        $itemid   = $this->input->post('ItemID');
        $itemname = $this->input->post('ItemName');
        $qty      = $this->input->post('Qty');
        $shelf     = $this->input->post('Shelf');
        $MainPO   = $this->input->post('MainPO');
        $custid   = $this->input->post('custid');
        $sono     = $this->input->post('sono');
        $ppbid    = $this->input->post('ppbid');
        $uom      = $this->input->post('UOM');
        $vendor   = $this->input->post('Vendor');
        $qtyorder = $this->input->post('QtyPO');
        $jml      = count($itemid);

        $query1 = $this->simpan_gr_sp_hdr($datahdr);
        $docno = $query1->docno;
        $flag1  = $query1->flag;

        if ($flag1 == 0) {
            $this->db->trans_rollback();
            $data = array('flag' => $flag1);
            return $data;
        }

        $query2 = $this->simpan_gr_sp_dtl($docno, $MainPO, $itemid, $itemname, $qty, $shelf, $custid, $sono, $ppbid, $uom, $vendor, $qtyorder, $datahdr['createdby'], $jml, $datahdr['ipaddress']);
        $flag2 = $query2->flag;

        if ($flag2 == 0) {
            $this->db->trans_rollback();
            $data = array('flag' => $flag2);
            return $data;
        }

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $data = array('flag' => $flag2);
            return $data;
        } else {
            $this->db->trans_commit();
            $data = array('flag' => $flag2, 'docno' => $docno);
            return $data;
        }
    }

    function simpan_gr_sp_hdr($datahdr)
    {
        $this->db->query("SET @docno = '" . $datahdr['docno'] . "'");
        $this->db->query("SET @flag = 0");
        $this->db->query("call zhl_sp_pur_tbl_trn_gr_hdr('" . $datahdr['trans'] . "',@docno,'" . $datahdr['docdate'] . "','" . $datahdr['duedate'] . "','" . $datahdr['createdby'] . "',@flag)");
        $row =  $this->db->query("Select @docno as docno, @flag as flag")->row();

        return $row;
    }

    function simpan_gr_sp_dtl($docno, $MainPO, $itemid, $itemname, $qty, $shelf, $custid, $sono, $ppbid, $uom, $vendor, $qtyorder, $user, $jml, $ipadress)
    {

        for ($i = 0; $i < $jml; $i++) {

            if ($MainPO[$i] != '') {
                $this->db->query("UPDATE zhl_pur_tbl_trn_po_hdr set pur_status = 'IN' where MainPO ='" . $MainPO[$i] . "'");
            }

            $this->db->query("SET @flag = 0");
            $this->db->query("call zhl_sp_pur_tbl_trn_gr_dtl('" . $docno . "','" . $MainPO[$i] . "','" . $itemid[$i] . "','" . htmlspecialchars($itemname[$i], ENT_QUOTES) . "','" . $qty[$i] . "','" . $shelf[$i] . "','" . $custid[$i] . "','" . $sono[$i] . "','" . $ppbid[$i] . "','" . $uom[$i] . "','" . $vendor[$i] . "','" . $qtyorder[$i] . "','" . $user . "',@flag,'" . $ipadress . "')");
        }

        $row =  $this->db->query("Select @docno as docno,@flag as flag")->row();

        return $row;
    }


    function cek_docno($docno)
    {
        $this->db->where('docno', $docno);
        $this->db->where('proses', '1');
        $sql =  $this->db->get('zhl_pur_tbl_trn_gr_dtl');
        if ($sql->num_rows() > 0) {
            $result = 0;
        } else {
            $result = 1;
        }

        return $result;
    }

    function cek_status_new($mainpo, $tipe)
    {
        $data = array('status' => '1');

        if ($tipe != 2) {
            $this->db->where('mainpo', $mainpo);
            $sql = $this->db->get('zhl_pur_vw_trn_po_by_gr')->result();

            $i = 1;
            foreach ($sql as $r) {
                if ($r->qtypo == $r->qtywhs) {
                    $x = 1;
                } else {
                    $x = 0;
                }
                $i = $i * $x;
            }

            if ($i > 0) {
                $data = array('status' => '2');
            }
        }

        $this->db->where('mainpo', $mainpo);
        $this->db->update('pur_tbl_trn_po_hdr', $data);
    }

    function cek_status_del($docno)
    {
        $data = array('status' => '1');

        $this->db->where('docno', $docno);
        $this->db->group_by('mainpo');
        $sql = $this->db->get('zhl_pur_tbl_trn_gr_dtl')->result();

        foreach ($sql as $r) {
            $this->db->where('mainpo', $r->mainpo);
            $this->db->update('zhl_pur_tbl_trn_po_hdr', $data);
        }
    }
}
