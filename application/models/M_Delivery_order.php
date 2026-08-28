<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_Delivery_order extends CI_Model
{

    function get_factory()
    {
        $result =  $this->db->get('pur_tbl_mst_customer');
        return $result->result();
    }

    function get_factory_for_loading_report_zhl()
    {
        $result =  $this->db->get('pur_tbl_mst_customer');
        return $result->result();
    }

    function get_gr_do($factory)
    {
        $query = "SELECT * FROM pur_vw_packdo_getgr where companyid >= '$factory' AND sisa_qty > 0 ";
        $sql = $this->db->query($query);

        return $sql->result();
    }

    function get_gr($cust, $po)
    {
        $query1 = "companyid='" . $cust . "'";
        $query2 = "(mainpo like '%" . $po . "%' or itemname like '%" . $po . "%')";

        $this->db->where($query1);
        $this->db->where($query2);
        $this->db->order_by('mainpo');

        $result = $this->db->get('pur_vw_packdo_getgr');
        return $result->result();
    }


    function tampil_PI($factory)
    {
        $query1 = "proses = 0 and custid= '" . $factory . "'";

        $this->db->where($query1);
        $this->db->order_by('sono');

        $result = $this->db->get('pur_vw_trn_so');
        return $result->result();
    }

    function tampil_pl_all($data)
    {
        $this->db->like('sono', $data);
        $this->db->or_like('custid', $data);
        $this->db->or_like('custcompany', $data);
        $this->db->order_by('sono', 'Desc');

        $result = $this->db->get('zhl_pur_vw_trn_pl_hdr');
        return $result->result();
    }

    function tampil_pl_where($data)
    {
        $this->db->where('pl_no', $data);
        $this->db->order_by('nourut');
        $result = $this->db->get('zhl_pur_vw_trn_pl');
        return $result->result();
    }
    //==================================== PACKING LIST PURCHASING =============================
    public function simpan_lr_pur_sp($datahdr)
    {
        $SeqNo    = $this->input->post('SeqNo');
        $id_lr    = $this->input->post('id_lr');
        $itemid   = $this->input->post('txtItemId');
        $itemname = $this->input->post('txtItemName');
        $qty      = $this->input->post('txtItemQty');
        $uom      = $this->input->post('txtItemUom');
        $gweight  = $this->input->post('txtItemGW');
        $nweight  = $this->input->post('txtItemNW');
        $docno    = $this->input->post('txtdocno');
        $mainpo   = $this->input->post('txtmainpo');
        $npbbno   = $this->input->post('txtItemNPBB');
        $jenis    = $this->input->post('txttype');
        $cust     = $this->input->post('cust');
        $pl_no    = $this->input->post('pl_no');
        $ppbid    = $this->input->post('ppbid');
        $jml      = count($itemid);

        $query1 = $this->simpan_lr_pur_sp_hdr($datahdr, $jenis, $pl_no);
        $lrno = $query1->lrno;
        $flag1 = $query1->flag;

        if ($flag1 == 0) {
            $this->db->trans_rollback();
            $data = array('flag' => $flag1);
            return $data;
        }

        $query2 = $this->simpan_lr_pur_sp_dtl($lrno, $SeqNo, $itemid, $itemname, $qty, $uom, $gweight, $nweight, $docno, $mainpo, $npbbno, $cust, $jenis, $datahdr['trans'], $id_lr, $ppbid, $jml);
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
            $data = array('flag' => $flag2, 'lrno' => $lrno);
            return $data;
        }
    }

    function simpan_lr_pur_sp_hdr($datahdr)
    {
        $this->db->query("SET @flag = 0");
        $this->db->query("call zhl_sp_pur_tbl_trn_pl_hdr('" . $datahdr['pl_no'] . "','" . $datahdr['packing'] . "','" . $datahdr['totalpack'] . "','" . $datahdr['shipdate_pl'] . "','" . $datahdr['via'] . "','" . $datahdr['createdby'] . "',@flag)");
        $row =  $this->db->query("Select @flag as flag")->row();
        return $row;
    }

    function simpan_lr_pur_sp_dtl($sono, $descriptions, $item, $qty, $grossweight, $neetweight, $docno, $mainpo, $npbbno, $SeqNo, $jml, $qty_alias, $uom_alias, $ppbid)
    {
        for ($i = 0; $i < $jml; $i++) {
            $this->db->query("SET @flag = 0");
            $this->db->query("call zhl_sp_pur_tbl_trn_pl_dtl('" . $sono[$i] . "','" . $descriptions[$i] . "','" . $item[$i] . "','" . $qty[$i] . "','" . $grossweight[$i] . "','" . $neetweight[$i] . "','" . $docno[$i] . "','" . $mainpo[$i] . "','" . $npbbno[$i] . "','" . $qty_alias[$i] . "','" . $uom_alias[$i] . "','" . $SeqNo[$i] . "','" . $ppbid[$i] . "',@flag)");
        }

        $row =  $this->db->query("Select @flag as flag")->row();

        return $row;
    }

    function tampil_gr_pur_po($cust, $po)
    {
        $query1 = "custid='" . $cust . "'";
        $query2 = "(mainpo like '%" . $po . "%' or pl_no like '%" . $po . "%' or descriptions like '%" . $po . "%')";

        $this->db->where($query1);
        $this->db->where($query2);
        $this->db->order_by('mainpo');

        $result = $this->db->get('zhl_pur_vw_trn_pl_by_lr');
        return $result->result();
    }

    //===========================END===================

    //=================================Packing list Shipping======================================

    function simpan_pl_sp($datahdr)
    {
        $this->db->trans_begin();
        $SeqNo       = $this->input->post('SeqNo');
        $sono        = $this->input->post('txtIdgr');
        $item        = $this->input->post('txtItemId');
        $descriptions = $this->input->post('txtItemName');
        $qty         = $this->input->post('txtItemQty');
        $qty_alias   = $this->input->post('txtItemQty_Alias');
        $uom_alias   = $this->input->post('UOM_Alias');
        $grossweight = $this->input->post('txtItemGW');
        $neetweight  = $this->input->post('txtItemNW');
        $docno       = $this->input->post('txtdocno');
        $mainpo      = $this->input->post('txtmainpo');
        $npbbno      = $this->input->post('txtItemNPBB');
        $ppbid       = $this->input->post('ppbid');
        $jml         = count($item);

        $query1 = $this->simpan_pl_sp_hdr($datahdr);
        $flag1 = $query1->flag;

        if ($flag1 == 0) {
            $this->db->trans_rollback();
            $data = array('flag' => $flag1);
            return $data;
        }

        $query2 = $this->simpan_pl_sp_dtl($sono, $descriptions, $item, $qty, $grossweight, $neetweight, $docno, $mainpo, $npbbno, $SeqNo, $jml, $qty_alias, $uom_alias, $ppbid);
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
            $data = array('flag' => $flag2);
            return $data;
        }
    }

    function simpan_pl_sp_hdr($datahdr)
    {
        $this->db->query("SET @flag = 0");
        $this->db->query("call zhl_sp_pur_tbl_trn_pl_hdr('" . $datahdr['pl_no'] . "','" . $datahdr['packing'] . "','" . $datahdr['totalpack'] . "','" . $datahdr['shipdate_pl'] . "','" . $datahdr['via'] . "','" . $datahdr['createdby'] . "',@flag)");
        $row =  $this->db->query("Select @flag as flag")->row();
        return $row;
    }

    function simpan_pl_sp_dtl($sono, $descriptions, $item, $qty, $grossweight, $neetweight, $docno, $mainpo, $npbbno, $SeqNo, $jml, $qty_alias, $uom_alias, $ppbid)
    {
        for ($i = 0; $i < $jml; $i++) {
            $this->db->query("SET @flag = 0");
            $this->db->query("call zhl_sp_pur_tbl_trn_pl_dtl('" . $sono[$i] . "','" . $descriptions[$i] . "','" . $item[$i] . "','" . $qty[$i] . "','" . $grossweight[$i] . "','" . $neetweight[$i] . "','" . $docno[$i] . "','" . $mainpo[$i] . "','" . $npbbno[$i] . "','" . $qty_alias[$i] . "','" . $uom_alias[$i] . "','" . $SeqNo[$i] . "','" . $ppbid[$i] . "',@flag)");
        }

        $row =  $this->db->query("Select @flag as flag")->row();

        return $row;
    }

    function tampil_gr_po($cust, $po)
    {
        $query1 = "custid='" . $cust . "'";
        $query2 = "(mainpo like '%" . $po . "%' or pl_no like '%" . $po . "%' or descriptions like '%" . $po . "%')";

        $this->db->where($query1);
        $this->db->where($query2);
        $this->db->order_by('mainpo');

        $result = $this->db->get('pur_vw_trn_pl_by_lr');
        return $result->result();
    }

    function delete_detail_do($id)
    {
        $this->db->query("call sp_delete_packdo_dtl('" . $id . "')");
    }

    function cek($hdr_id)
    {
        $this->db->where('hdr_id', $hdr_id);
        $sql =  $this->db->get('pur_tbl_trn_packdo_hdr');
        if ($sql->num_rows() > 0) {
            $result = 1;
        } else {
            $result = 0;
        }

        return $result;
    }

    function tampil_pack_list($data)
    {
        $query1 = "(hdr_id like '%" . $data . "%' or type like '%" . $data . "%' or ship_via like '%" . $data . "%')";

        $this->db->where($query1);
        $this->db->order_by('ship_date');

        $result = $this->db->get('pur_tbl_trn_packdo_hdr');

        return $result->result();
    }

    function tampil_packdo_filter($from, $to, $mainpo, $item, $npbbno, $status)
    {
        $po = "%" . $mainpo . "%";
        $item = "%" . $item . "%";
        $npbb = "%" . $npbbno . "%";
        if ($status == '1') {
            $query = " and (B.qty-IFNULL(B.qty_pd,0)) = 0";
        } else if ($status == '2') {
            $query = " and (B.qty-IFNULL(B.qty_pd,0)) > 0";
        } else {
            $query = "";
        }

        return $this->db->query("
            SELECT A.docno, A.docdate, A.duedate, B.mainpo, B.itemid, B.itemname, E.uomname, B.qty, F.vendorid, F.vendorcompany, F.custcompany, B.npbbno, IFNULL(B.qty_pd,0) AS qty_pd, IFNULL(G.qty_out,0) AS qty_out, B.qty - IFNULL(B.qty_pd,0) as qty_outstanding, G.docno AS reff_do, G.duedate AS do_date
                    FROM pur_tbl_trn_gr_hdr A 
                    LEFT JOIN pur_tbl_trn_gr_dtl B ON A.docno = B.docno
                    JOIN pur_vw_trn_po PO ON  (((PO.mainpo = B.mainpo) AND (PO.itemid = B.itemid) AND (PO.npbbno = B.npbbno) AND (PO.npbbno = B.npbbno) AND (PO.companyid = B.companyid)))
                    LEFT JOIN gen_tbl_mst_item D ON B.itemid = D.itemid
                    LEFT JOIN gen_tbl_mst_item_uom E ON D.uomid = E.uomid
                    LEFT JOIN pur_tbl_trn_po_hdr F ON B.mainpo = F.mainpo
                    LEFT JOIN pur_vw_qty_do G ON    (((G.docno_gr = B.docno) AND (G.mainpo = B.mainpo) AND (G.itemid = B.itemid) AND (G.npbbno = B.npbbno) AND (G.companyid = B.companyid)))
                    WHERE A.docdate BETWEEN '$from' AND '$to' AND B.mainpo like  '$po' AND B.itemname  like '$item' AND B.npbbno like  '$npbb' $query ORDER BY A.docno;
        ")->result();
    }

    public function delete_packing_list($pl_no)
    {
        $this->db->where('pl_no', $pl_no);
        $this->db->delete('pur_tbl_trn_pl_hdr');

        $this->db->where('pl_no', $pl_no);
        $this->db->delete('pur_tbl_trn_pl_dtl');
    }

    public function simpan_lr_sp($datahdr)
    {
        $SeqNo    = $this->input->post('SeqNo');
        $id_lr    = $this->input->post('id_lr');
        $itemid   = $this->input->post('txtItemId');
        $itemname = $this->input->post('txtItemName');
        $qty      = $this->input->post('txtItemQty');
        $uom      = $this->input->post('txtItemUom');
        $gweight  = $this->input->post('txtItemGW');
        $nweight  = $this->input->post('txtItemNW');
        $docno    = $this->input->post('txtdocno');
        $mainpo   = $this->input->post('txtmainpo');
        $npbbno   = $this->input->post('txtItemNPBB');
        $jenis    = $this->input->post('txttype');
        $cust     = $this->input->post('cust');
        $pl_no    = $this->input->post('pl_no');
        $ppbid    = $this->input->post('ppbid');
        $jml      = count($itemid);

        $query1 = $this->simpan_lr_sp_hdr($datahdr, $jenis, $pl_no);
        $lrno = $query1->lrno;
        $flag1 = $query1->flag;

        if ($flag1 == 0) {
            $this->db->trans_rollback();
            $data = array('flag' => $flag1);
            return $data;
        }

        $query2 = $this->simpan_lr_sp_dtl($lrno, $SeqNo, $itemid, $itemname, $qty, $uom, $gweight, $nweight, $docno, $mainpo, $npbbno, $cust, $jenis, $datahdr['trans'], $id_lr, $ppbid, $jml);
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
            $data = array('flag' => $flag2, 'lrno' => $lrno);
            return $data;
        }
    }

    function simpan_lr_sp_hdr($datahdr, $jenis, $pl_no)
    {
        $this->db->query("SET @lrno = '" . $datahdr['lrno'] . "'");
        $this->db->query("SET @trans = '" . $datahdr['trans'] . "'");
        $this->db->query("SET @flag = 0");
        $this->db->query("call zhl_sp_pur_tbl_trn_lr_hdr('" . $datahdr['trans'] . "',@lrno,'" . $datahdr['custid'] . "',"
            . "'" . str_replace("'", '`', $datahdr['remark']) . "','" . $datahdr['via'] . "','" . $datahdr['docdate'] . "','" . $datahdr['shipdate'] . "','" . $datahdr['total_pack'] . "','" . $datahdr['createdby'] . "','" . $jenis . "','" . $pl_no . "',@flag)");
        $row =  $this->db->query("Select @lrno as lrno, @flag as flag")->row();

        return $row;
    }

    function simpan_lr_sp_dtl($lrno, $SeqNo, $itemid, $itemname, $qty, $uom, $gweight, $nweight, $docno, $mainpo, $npbbno, $cust, $jenis, $transaksi, $id_lr, $ppbid, $jml)
    {
        for ($i = 0; $i < $jml; $i++) {
            $this->db->query("SET @flag = 0");
            $this->db->query("call zhl_sp_pur_tbl_trn_lr_dtl('" . $lrno . "','" . $SeqNo[$i] . "','" . $itemid[$i] . "','" . str_replace("'", '`', $itemname[$i]) . "','" . $qty[$i] . "','" . $uom[$i] . "','" . $gweight[$i] . "','" . $nweight[$i] . "',"
                . "'" . $docno[$i] . "','" . $mainpo[$i] . "','" . str_replace("'", '`', $npbbno[$i]) . "','" . $cust . "','" . $jenis . "','" . $transaksi . "','" . $id_lr[$i] . "','" . $ppbid[$i] . "',@flag)");
        }

        $row =  $this->db->query("Select @flag as flag")->row();

        return $row;
    }

    function tampil_lr_where($data)
    {
        $this->db->where('lrno', $data);
        $this->db->order_by('nourut');
        $result = $this->db->get('zhl_pur_vw_trn_lr');
        return $result->result();
    }

    function tampil_lr_all($data)
    {
        $this->db->like('lrno', $data);
        $this->db->or_like('custid', $data);
        $this->db->or_like('customercompany', $data);
        $this->db->order_by('lrno', 'Desc');

        $result = $this->db->get('zhl_pur_vw_trn_lr_hdr');
        return $result->result();
    }

    public function delete_loading_report($lr_no)
    {
        $this->db->query("update pur_tbl_trn_lr_hdr set status=1 where lrno='$lr_no'");

        $this->db->where('lr_no', $lr_no);
        $this->db->delete('pur_tbl_trn_lr_dtl');
    }

    public function loading_report_delete_item_dp($itemid)
    {
        $this->db->where('itemid', $itemid);
        $this->db->delete('pur_tbl_trn_lr_dtl');
    }

    ////////////////////DO\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\

    function tampil_gr_where_other($data)
    {
        $query1 = "sisa_qty > 0";
        $query2 = "(mainpo like '%" . $data . "%' or itemid like '%" . $data . "%' or itemname like '%" . $data . "%' or vendorid like '%" . $data . "%' or vendorcompany like '%" . $data . "%')";

        $this->db->where($query1);
        $this->db->where($query2);
        $this->db->order_by('createddate');

        $result = $this->db->get('zhl_pur_vw_trn_gr');

        return $result->result();
    }

    function simpan_do_sp($datahdr)
    {
        $this->db->trans_begin();
        $itemid   = $this->input->post('ItemID');
        $itemname = $this->input->post('ItemName');
        $qty      = $this->input->post('Qty');
        $npbb     = $this->input->post('NPBB');
        $MainPO   = $this->input->post('MainPO');
        $custid   = $this->input->post('custid');
        $sono     = $this->input->post('sono');
        $docno_gr = $this->input->post('docno_gr');
        $ppbid    = $this->input->post('ppbid');
        $jml      = count($itemid);

        $query1 = $this->simpan_do_sp_hdr($datahdr);
        $docno = $query1->docno;
        $flag1 = $query1->flag;

        if ($flag1 == 0) {
            $this->db->trans_rollback();
            $data = array('flag' => $flag1);
            return $data;
        }

        $query2 = $this->simpan_do_sp_dtl($docno, $MainPO, $itemid, $itemname, $qty, $npbb, $custid, $sono, $docno_gr, $ppbid, $datahdr['createdby'], $jml);
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

    function simpan_do_sp_hdr($datahdr)
    {
        $this->db->query("SET @docno = '" . $datahdr['docno'] . "'");
        $this->db->query("SET @flag = 0");
        $this->db->query("call zhl_sp_pur_tbl_trn_do_hdr('" . $datahdr['trans'] . "',@docno,'" . $datahdr['docdate'] . "','" . $datahdr['duedate'] . "','" . $datahdr['createdby'] . "',@flag)");
        $row =  $this->db->query("Select @docno as docno, @flag as flag")->row();

        return $row;
    }

    function simpan_do_sp_dtl($docno, $MainPO, $itemid, $itemname, $qty, $npbb, $custid, $sono, $docno_gr, $ppbid, $user, $jml)
    {
        for ($i = 0; $i < $jml; $i++) {
            $this->db->query("SET @flag = 0");
            $this->db->query("call zhl_sp_pur_tbl_trn_do_dtl('" . $docno . "','" . $MainPO[$i] . "','" . $itemid[$i] . "','" . htmlspecialchars($itemname[$i], ENT_QUOTES) . "','" . $qty[$i] . "','" . $npbb[$i] . "','" . $custid[$i] . "','" . $sono[$i] . "','" . $docno_gr[$i] . "','" . $ppbid[$i] . "','" . $user . "',@flag)");
        }

        $row =  $this->db->query("Select @flag as flag")->row();

        return $row;
    }

    function tampil_do($data)
    {
        $this->db->like('docno', $data);
        $this->db->or_like('mainpo', $data);
        $this->db->or_like('vendorid', $data);
        $this->db->or_like('vendorcompany', $data);

        $this->db->order_by('docno', 'desc');

        $result = $this->db->get('zhl_pur_vw_trn_do');
        return $result->result();
    }

    function tampil_do_where($data)
    {
        $this->db->where('docno', $data);
        $result = $this->db->get('zhl_pur_vw_trn_do');
        return $result->result();
    }

    function delete_delivery_order($docno)
    {
        $this->db->trans_begin();
        $docno1 = $docno;
        $itemid   = $this->input->post('ItemID');
        $npbb     = $this->input->post('NPBB');
        $MainPO   = $this->input->post('MainPO');
        $custid   = $this->input->post('custid');
        $docno_gr = $this->input->post('docno_gr');
        $jml      = count($itemid);

        $query = $this->delete_do_sp($docno1, $MainPO, $itemid, $npbb, $custid, $docno_gr, $jml);

        $flag1 = $query->flag;

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $data = array('flag' => $docno1);
            return $data;
        } else {
            $this->db->trans_commit();
            $data = array('flag' => $flag1);
            return $data;
        }
    }

    function delete_do_sp($docno1, $MainPO, $itemid, $npbb, $custid, $docno_gr, $jml)
    {
        for ($i = 0; $i < $jml; $i++) {
            $this->db->query("SET @flag = 0");
            $this->db->query("call zhl_sp_pur_tbl_trn_do_del('" . $docno1 . "','" . $MainPO[$i] . "','" . $itemid[$i] . "','" . $npbb[$i] . "','" . $custid[$i] . "','" . $docno_gr[$i] . "',@flag)");
        }
        $row =  $this->db->query("Select @flag as flag")->row();
        return $row;
    }

    ///////////////////simpan_book_ref_sp\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\

    public function simpan_book_ref_sp($datahdr)
    {
        $this->db->trans_begin();
        $mainpo       = $this->input->post('txtmainpo');
        $date_rqd     = $this->input->post('date_rqd');
        $time_rqd     = $this->input->post('time_rqd');
        $sum_20_rqd   = $this->input->post('txtsum_20');
        $sum_40_rqd   = $this->input->post('txtsum_40');
        $sum_40hc_rqd = $this->input->post('txtsum_40hc');
        $desc         = $this->input->post('txtdesc');
        $remark       = $this->input->post('txtremark');
        $nourut       = $this->input->post('SeqNo');
        $address      = $this->input->post('vendor_address');
        $jml          = count($mainpo);

        $query1 = $this->simpan_bookref_hdr($datahdr);
        $bookref_no = $query1->bookref_no;
        $flag1 = $query1->flag;

        if ($flag1 == 0) {
            $this->db->trans_rollback();
            $data = array('flag' => $flag1);
            return $data;
        }

        $query2 = $this->simpan_bookref_dtl($bookref_no, $mainpo, $date_rqd, $time_rqd, $sum_20_rqd, $sum_40_rqd, $sum_40hc_rqd, $desc, $remark, $nourut, $address, $jml);
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
            $data = array('flag' => $flag2, 'bookref_no' => $bookref_no);
            return $data;
        }
    }

    function simpan_bookref_hdr($datahdr)
    {
        $this->db->query("SET @bookref_no = '" . $datahdr['bookref_no'] . "'");
        $this->db->query("SET @flag = 0");
        $this->db->query("call sp_pur_tbl_trn_bookref_hdr('" . $datahdr['trans'] . "',@bookref_no,'" . $datahdr['barge'] . "','" . $datahdr['voyage'] . "','" . $datahdr['etd'] . "','" . $datahdr['date'] . "','" . $datahdr['cust'] . "','" . $datahdr['ammend'] . "','" . $datahdr['createdby'] . "',@flag)");
        $row =  $this->db->query("Select @bookref_no as bookref_no, @flag as flag")->row();
        return $row;
    }

    function simpan_bookref_dtl($bookref_no, $mainpo, $date_rqd, $time_rqd, $sum_20_rqd, $sum_40_rqd, $sum_40hc_rqd, $desc, $remark, $nourut, $address, $jml)
    {
        for ($i = 0; $i < $jml; $i++) {
            $this->db->query("SET @flag = 0");
            $this->db->query("call sp_pur_tbl_trn_bookref_dtl('" . $bookref_no . "','" . $mainpo[$i] . "','" . $date_rqd[$i] . "','" . $time_rqd[$i] . "','" . $sum_20_rqd[$i] . "','" . $sum_40_rqd[$i] . "','" . $sum_40hc_rqd[$i] . "','" . $desc[$i] . "','" . $remark[$i] . "','" . $nourut[$i] . "','" . $address[$i] . "',@flag)");
        }

        $row =  $this->db->query("Select @flag as flag")->row();

        return $row;
    }

    function tampil_bookref_where($data)
    {
        $this->db->where('bookref_no', $data);
        $this->db->order_by('nourut', 'Asc');
        $result = $this->db->get('pur_vw_trn_bookref');
        return $result->result();
    }

    function tampil_bookref_all($data)
    {
        $this->db->like('bookref_no', $data);
        $this->db->or_like('custid', $data);
        $this->db->or_like('barge', $data);
        $this->db->order_by('bookref_no', 'Desc');

        $result = $this->db->get('pur_tbl_trn_bookref_hdr');
        return $result->result();
    }

    function tampil_container_po($cust, $data)
    {
        $query1 = "custid='" . $cust . "'";
        $query2 = "(mainpo like '%" . $data . "%' or vendorid like '%" . $data . "%' or vendorcompany like '%" . $data . "%')";

        $this->db->where($query1);
        $this->db->where($query2);

        $this->db->order_by('mainpo', 'desc');
        $result = $this->db->get('pur_vw_trn_po_book');
        return $result->result();
    }

    function get_bookref_shp($cust, $ship)
    {
        $query1 = "eta='" . $cust . "'";
        $query2 = "shipmentdate='" . $ship . "'";


        $this->db->where($query1);
        $this->db->where($query2);

        $result = $this->db->get('ship_vw_tbl_cont_link_to_pur');
        return $result->result();
    }

    function get_bookref_shp2($cust, $tgl)
    {
        $sql =  $this->db->query("call shp_get_book('" . $tgl . "','" . $cust . "')");
        $res = $sql->result();
        $sql->next_result();
        $sql->free_result();
        return $res;
    }

    function get_bookref_shp3($cust, $tgl, $po)
    {
        $sql =  $this->db->query("call shp_get_book2('" . $tgl . "','" . $cust . "','" . $po . "')");
        $res = $sql->result();
        $sql->next_result();
        $sql->free_result();
        return $res;
    }


    ///////////////////simpan_book_ref_shipping_sp\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\

    public function simpan_book_ref_shp_sp($datahdr)
    {
        $this->db->trans_begin();
        $cont   = $this->input->post('cont');
        $jml    = count($this->input->post('cont'));

        $query1 = $this->simpan_bookref_hdr_shp($datahdr);
        $bookref_no = $query1->bookref_no;
        $flag1 = $query1->flag;

        if ($flag1 == 0) {
            $this->db->trans_rollback();
            $data = array('flag' => $flag1);
            return $data;
        }

        $query2 = $this->simpan_bookref_dtl_shp($bookref_no, $cont, $jml);
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
            $data = array('flag' => $flag2, 'bookref_no' => $bookref_no);
            return $data;
        }
    }

    function simpan_bookref_hdr_shp($datahdr)
    {
        $this->db->query("SET @bookref_no = '" . $datahdr['bookref_no'] . "'");
        $this->db->query("SET @flag = 0");
        $this->db->query("call sp_shp_tbl_trn_bookref_hdr(@bookref_no,'" . $datahdr['createdby'] . "',@flag)");
        $row =  $this->db->query("Select @bookref_no as bookref_no, @flag as flag")->row();
        return $row;
    }

    function simpan_bookref_dtl_shp($bookref_no, $cont, $jml)
    {
        for ($i = 0; $i < $jml; $i++) {
            $explode = explode("/", $cont[$i]);
            $mainpo   =  $explode[2];
            $stuff   =  $explode[1];
            $ship_book   = $explode[0];
            $this->db->query("SET @flag = 0");
            $this->db->query("call sp_shp_tbl_trn_bookref_dtl('" . $bookref_no . "','" . $mainpo . "','" . $stuff . "','" . $ship_book . "',@flag)");
        }

        $row =  $this->db->query("Select @flag as flag")->row();

        return $row;
    }

    function tampil_reff_no($data, $data2)
    {
        $this->db->where('bookref_no', $data);
        $this->db->where('mainpo', $data2);
        $result = $this->db->get('shp_tbl_trn_bookref_dtl');
        return $result->result();
    }

    function tampil_po_hdr($po)
    {
        return $this->db->query("
            SELECT A.bookref_no, A.mainpo, A.reff, B.vendorid, C.container_number, C.stuffing, C.shipmentdate, C.etd
            FROM shp_tbl_trn_bookref_dtl A LEFT JOIN pur_tbl_trn_po_hdr B ON A.mainpo = B.mainpo
            LEFT JOIN ship_vw_tbl_cont_link_to_pur C ON (A.reff = C.booking_reff AND B.vendorid = C.supplier) WHERE B.mainpo='$po';
        ")->result();
    }

    function get_shp_excel($data)
    {
        return $this->db->query("
            SELECT A.bookref_no, A.mainpo, A.reff, B.vendorid, B.whsid, F.name, C.container_number, C.stuffing, C.shipmentdate, C.etd, C.voyage,C.vessel, C.pod, C.destination, E.date_reqd, D.date, E.remarks, C.c20, C.c40, C.shipping_liner, C.etasin, C.etdsin, C.depot
            FROM shp_tbl_trn_bookref_dtl A LEFT JOIN pur_tbl_trn_po_hdr B ON A.mainpo = B.mainpo
            LEFT JOIN ship_vw_tbl_cont_link_to_pur C ON (A.reff = C.booking_reff AND B.vendorid = C.supplier) LEFT JOIN pur_tbl_trn_bookref_hdr D ON A.bookref_no=D.bookref_no LEFT JOIN pur_tbl_trn_bookref_dtl E ON (E.bookref_no = D.bookref_no AND E.mainpo = A.mainpo) LEFT JOIN gen_tbl_mst_whs F ON F.id=B.whsid WHERE A.bookref_no='$data';
        ")->result();
    }

    function get_shp_whs($data)
    {
        return $this->db->query("
            SELECT distinct F.name 
            FROM shp_tbl_trn_bookref_dtl A LEFT JOIN pur_tbl_trn_po_hdr B ON A.mainpo = B.mainpo
            LEFT JOIN ship_vw_tbl_cont_link_to_pur C ON (A.reff = C.booking_reff AND B.vendorid = C.supplier) LEFT JOIN pur_tbl_trn_bookref_hdr D ON A.bookref_no=D.bookref_no LEFT JOIN pur_tbl_trn_bookref_dtl E ON (E.bookref_no = D.bookref_no AND E.mainpo = A.mainpo) LEFT JOIN gen_tbl_mst_whs F ON F.id=B.whsid WHERE A.bookref_no='$data';
        ")->result();
    }
}
