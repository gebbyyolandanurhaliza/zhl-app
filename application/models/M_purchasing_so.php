<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_purchasing_so extends CI_Model
{
    //-----------------------------------------------------------ABOUT PO-------------------------------------------------------------------
    function tampil_so($data)
    {
        $this->db->like('sono', $data);
        $this->db->or_like('custid', $data);
        $this->db->or_like('custcompany', $data);
        $this->db->order_by('createddate', 'Desc');

        $result = $this->db->get('zhl_pur_vw_trn_so_hdr_mainpo');
        return $result->result();
    }

    function tampil_so_where($data)
    {
        $this->db->where('sono', $data);
        
        //$this->db->order_by('duedate desc');

        $result = $this->db->get('zhl_pur_vw_trn_so');
        return $result->result();
    }

    function getDocNo_so($docdate)
    {
        $query = "year(docdate) = year('" . $docdate . "')";
        $this->db->where($query);
        $sql =  $this->db->get('zhl_pur_tbl_trn_so_hdr');
        if ($sql->num_rows() > 0) {
            $this->db->select('max(substring(sono,9, length(sono) -8) ) + 1 as docno');
            $this->db->where($query);
            $data = $this->db->get('zhl_pur_tbl_trn_so_hdr')->row();
            $result = $data->docno;
        } else {
            $result = 1;
        }

        return $result;
    }

    function tampil_so_po($cust, $po)
    {
        $query1 = "proses = 0 and companyid='" . $cust . "'";
        $query2 = "(mainpo like '%" . $po . "%' or itemname like '%" . $po . "%')";

        $this->db->where($query1);
        $this->db->where($query2);
        $this->db->order_by('mainpo');

        $result = $this->db->get('zhl_pur_vw_trn_po');
        return $result->result();
    }

    function tampil_so_gr($item)
    {
        // $query1 = "proses = 0 and companyid='" . $cust . "'";
        $query2 = "(itemid like '%" . $item . "%' or id_gr like '%" . $item . "%')";
        $query1 = "qty_outstanding > 0";
        $this->db->where($query1);
         $this->db->where($query2);
        $this->db->order_by('id_gr');

        $result = $this->db->get('zhl_pur_vw_get_gr');
        // $result = $this->db->get('zhl_pur_vw_get_gr'); 
        return $result->result();
    }

    //     function tampil_gr_where_other($data)
    // {
    //     $query1 = "sisa_qty > 0";
    //     $query2 = "(mainpo like '%" . $data . "%' or itemid like '%" . $data . "%' or itemname like '%" . $data . "%' or vendorid like '%" . $data . "%' or vendorcompany like '%" . $data . "%')";

    //     $this->db->where($query1);
    //     $this->db->where($query2);
    //     $this->db->order_by('createddate');

    //     $result = $this->db->get('zhl_pur_vw_trn_gr');

    //     return $result->result();
    // }


    function delete_so($data)
    {
        $this->db->where('sono', $data);
        $this->db->delete('zhl_pur_tbl_trn_so_hdr');

        $this->update_delete_so($data);
        return true;
    }

    function delete_so_sp1($data)
    {
        $this->db->trans_begin();
        $this->db->query("SET @flag = 0");
        $this->db->query("call zhl_sp_pur_tbl_trn_so_del('" . $data . "',@flag)");
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


    function delete_so_sp($sono)
    {
        $this->db->trans_begin();
        $sono1 = $sono;
        $itemid = $this->input->post('ItemID');
        $MainPO = $this->input->post('MainPO');
        $docno_gr = $this->input->post('Docno_Gr');
        $jml = count($itemid);

        $query = $this->delete_sp_so($sono, $MainPO, $itemid, $docno_gr, $jml);
        // $jml = count($param['ItemID']);
        // $query = $this->delete_sp_so($param['sono'], $param['MainPO'], $param['ItemID'], $param['Docno_Gr'], $jml);

        $flag1 = $query->flag;

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $data = array('flag' => $sono);
            // $data = array('flag' => $param['sono']);
            return $data;
        } else {
            $this->db->trans_commit();
            $data = array('flag' => $flag1);
            return $data;
        }
    }

    function delete_sp_so($sono1, $MainPO, $itemid, $docno_gr, $jml)
    {
        for ($i = 0; $i < $jml; $i++) {
            $this->db->query("SET @flag = 0");
            $this->db->query("call zhl_sp_pur_tbl_trn_so_del('" . $sono1 . "','" . $MainPO[$i] . "','" . $itemid[$i] . "','" . $docno_gr[$i] . "',@flag)");
        }
        $row =  $this->db->query("Select @flag as flag")->row();
        return $row;
    }




    function simpan_so($datahdr)
    {
        $this->db->trans_begin();
        $itemid    = $this->input->post('ItemID');
        $itemname  = $this->input->post('ItemName');
        $qty       = $this->input->post('Qty');
        $quantity  = $this->input->post('Quantity');
        $unitprice = $this->input->post('UnitPrice');
        $taxcode   = $this->input->post('TaxCode');
        $npbb      = $this->input->post('NPBB');
        $pono      = $this->input->post('PONO');
        $total     = $this->input->post('Total');
        $mainpo    = $this->input->post('Mainpo');
        $docno_gr  = $this->input->post('docno_gr');
        $Comission = $this->input->post('Comission');
        $Invoice   = $this->input->post('Invoice');
        $jml       = count($itemid);

        $this->db->insert('zhl_pur_tbl_trn_so_hdr', $datahdr);

        for ($i = 0; $i < $jml; $i++) {
            $datadtl = array(
                'sono'         => $datahdr['sono'],
                'mainpo'       => $mainpo[$i],
                'itemid'       => $itemid[$i],
                'itemname'     => $itemname[$i],
                'qty'          => $qty[$i],
                'quantity'     => $quantity[$i],
                'unitprice'    => $unitprice[$i],
                'taxcode'      => $taxcode[$i],
                'npbbno'       => $npbb[$i],
                'total'        => $total[$i],
                'pono'         => $pono[$i],
                'docno_gr'     => $docno_gr[$i],
                'comission'    => $Comission[$i],
                'invoiceprice' => $Invoice[$i],
                'createdby'    => strtoupper($this->session->userdata('userid_1')),
                'createddate' => date('Y-m-d H:i:s')
            );
            $this->db->insert('zhl_pur_tbl_trn_so_dtl', $datadtl);

            $datagr = array('proses' => '1');
            $this->db->where('docno', $docno_gr[$i]);
            $this->db->where('mainpo', $mainpo[$i]);
            $this->db->where('itemid', $itemid[$i]);
            $this->db->update('zhl_pur_tbl_trn_gr_dtl', $datagr);
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

    function update_so($sono, $datahdr)
    {
        $this->db->trans_begin();
        $itemid    = $this->input->post('ItemID');
        $itemname  = $this->input->post('ItemName');
        $qty       = $this->input->post('Qty');
        $quantity  = $this->input->post('Quantity');
        $unitprice = $this->input->post('UnitPrice');
        $taxcode   = $this->input->post('TaxCode');
        $npbb      = $this->input->post('NPBB');
        $pono      = $this->input->post('PONO');
        $total     = $this->input->post('Total');
        $mainpo    = $this->input->post('Mainpo');
        $docno_gr  = $this->input->post('docno_gr');
        $Comission = $this->input->post('Comission');
        $Invoice   = $this->input->post('Invoice');
        $jml       = count($itemid);

        $this->db->where('sono', $sono);
        $this->db->update('zhl_pur_tbl_trn_so_hdr', $datahdr);

        $this->update_delete_so($sono);

        for ($i = 0; $i < $jml; $i++) {
            $datadtl = array(
                'sono'            => $sono,
                'mainpo'          => $mainpo[$i],
                'itemid'          => $itemid[$i],
                'itemname'        => $itemname[$i],
                'qty'             => $qty[$i],
                'quantity'        => $quantity[$i],
                'unitprice'       => $unitprice[$i],
                'taxcode'         => $taxcode[$i],
                'npbbno'          => $npbb[$i],
                'total'           => $total[$i],
                'pono'            => $pono[$i],
                'docno_gr'        => $docno_gr[$i],
                'comission'       => $Comission[$i],
                'invoiceprice'    => $Invoice[$i],
                'createdby'       => strtoupper($this->session->userdata('userid_1')),
                'createddate'     => date('Y-m-d H:i:s'),
                'lastupdatedby'   => strtoupper($this->session->userdata('userid_1')),
                'lastupdateddate' => date('Y-m-d H:i:s')
            );
            $this->db->insert('zhl_pur_tbl_trn_so_dtl', $datadtl);

            $datagr = array('proses' => '1');
            $this->db->where('docno', $docno_gr[$i]);
            $this->db->where('mainpo', $mainpo[$i]);
            $this->db->where('itemid', $itemid[$i]);
            $this->db->update('zhl_pur_tbl_trn_gr_dtl', $datagr);
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

    function simpan_so_sp($datahdr)
    {
        $this->db->trans_begin();
        $SeqNo     = $this->input->post('SeqNo');
        $itemid    = $this->input->post('ItemID');
        $itemname  = $this->input->post('ItemName');
        $qty       = $this->input->post('Qty');
        $quantity  = $this->input->post('Quantity');
        $unitprice = $this->input->post('UnitPrice');
        $taxcode   = $this->input->post('TaxCode');
        $npbb      = $this->input->post('NPBB');
        $pono      = $this->input->post('PONO');
        $total     = $this->input->post('Total');
        $mainpo    = $this->input->post('Mainpo');
        $docno_gr  = $this->input->post('docno_gr');
        $vendorpo  = $this->input->post('Comission');
        $invoice   = $this->input->post('Invoice');
        $ppbid     = $this->input->post('ppbid');
        $nettweight = $this->input->post('NettWeight');
        $grossweight = $this->input->post('GrossWeight');
        $jml       = count($itemid);

        $query1 = $this->simpan_so_sp_hdr($datahdr);
        $sono   = $query1->sono;
        $flag1  = $query1->flag;

        if ($flag1 == 0) {
            $this->db->trans_rollback();
            $data = array('flag' => $flag1);
            return $data;
        }

        $query2 = $this->simpan_so_sp_dtl($sono, $mainpo, $SeqNo, $itemid, $itemname, $qty, $quantity, $unitprice, $taxcode, $total, $npbb, $pono, $vendorpo, $invoice, $docno_gr, $ppbid, $nettweight, $grossweight, $datahdr['createdby'], $jml);
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
            $data = array('flag' => $flag2, 'sono' => $sono);
            return $data;
        }
    }

    function simpan_so_sp_hdr($datahdr)
    {
        $this->db->query("SET @sono = '" . $datahdr['sono'] . "'");
        $this->db->query("SET @flag = 0");
        $this->db->query("call zhl_sp_pur_tbl_trn_so_hdr('" . $datahdr['trans'] . "',@sono,'" . $datahdr['custid'] . "','" . $datahdr['custcompany'] . "','" . $datahdr['custcontact'] . "','" . $datahdr['custref'] . "',"
            . "'" . $datahdr['currency'] . "','" . $datahdr['rate'] . "','" . $datahdr['status'] . "','" . $datahdr['postdate'] . "','" . $datahdr['duedate'] . "','" . $datahdr['docdate'] . "',"
            . "'" . $datahdr['sofrom'] . "','" . $datahdr['soto'] . "','" . $datahdr['shipdate'] . "',"
            . "'" . $datahdr['remark'] . "','" . $datahdr['via'] . "','" . $datahdr['total'] . "','" . $datahdr['discount'] . "','" . $datahdr['freight'] . "','" . $datahdr['tax'] . "',"
            . "'" . $datahdr['totaldue'] . "','" . $datahdr['term'] . "','" . $datahdr['termdays'] . "','" . $datahdr['createdby'] . "','" . $datahdr['country_id'] . "','" . $datahdr['taxprice'] . "','" . $datahdr['include'] . "',@flag)");
        $row =  $this->db->query("Select @sono as sono, @flag as flag")->row();

        return $row;
    }

    function simpan_so_sp_dtl($sono, $mainpo, $SeqNo, $itemid, $itemname, $qty, $quantity, $unitprice, $taxcode, $total, $npbb, $pono, $vendorpo, $invoice, $docno_gr, $ppbid, $nettweight, $grossweight, $userid_1, $jml)
    {
        for ($i = 0; $i < $jml; $i++) {

            if ($docno_gr[$i] != '') {
                $this->db->query("UPDATE zhl_pur_tbl_trn_gr_hdr set status_gr = 'OUT' where docno ='" . $docno_gr[$i] . "'");
            }

            $this->db->query("SET @flag = 0");
            $this->db->query("call zhl_sp_pur_tbl_trn_so_dtl('" . $sono . "','" . $mainpo[$i] . "','" . $SeqNo[$i] . "','" . $itemid[$i] . "','" . str_replace("'", '`', $itemname[$i]) . "','" . $qty[$i] . "','" . $quantity[$i] . "','" . $unitprice[$i] . "','" . $taxcode[$i] . "',"
                . "'" . $total[$i] . "','" . $npbb[$i] . "','" . $pono[$i] . "','" . $vendorpo[$i] . "','" . $invoice[$i] . "','" . $docno_gr[$i] . "','" . $ppbid[$i] . "','" . $nettweight[$i] . "','" . $grossweight[$i] . "','" . $userid_1 . "',@flag)");
        }

        $row =  $this->db->query("Select @flag as flag")->row();

        return $row;
    }

    function update_delete_so($sono)
    {
        $datagr = array('proses' => '0');

        $this->db->where('sono', $sono);
        $sql = $this->db->get('zhl_pur_tbl_trn_so_dtl')->result();

        foreach ($sql as $r) {
            $this->db->where('docno', $r->docno_gr);
            $this->db->where('mainpo', $r->mainpo);
            $this->db->where('itemid', $r->itemid);
            $this->db->update('zhl_pur_tbl_trn_gr_dtl', $datagr);
        }

        $this->db->where('sono', $sono);
        $this->db->delete('zhl_pur_tbl_trn_so_dtl');
    }
}
