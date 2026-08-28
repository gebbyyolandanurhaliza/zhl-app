<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_purchasing_inv extends CI_Model
{
    //-----------------------------------------------------------ABOUT PO-------------------------------------------------------------------

    function tampil_inv_po($cust, $po)
    {
        $query1 = "proses = 0 and custidbyorder='" . $cust . "' and IFNULL(sono,'') = '' and qty_pd <> 0";
        $query2 = "(mainpo like '%" . $po . "%' or itemname like '%" . $po . "%')";

        $this->db->where($query1);
        $this->db->where($query2);
        $this->db->order_by('mainpo');

        $result = $this->db->get('zhl_pur_vw_trn_gr');
        return $result->result();
    }


    function tampil_inv($data)
    {
        $query = "(invno like '%" . $data . "%' or custid like '%" . $data . "%' or custcompany like '%" . $data . "%')";
        $this->db->where($query);
        $this->db->where('tipe', '0');

        $this->db->order_by('createddate', 'desc');

        $result = $this->db->get('zhl_pur_vw_trn_inv_hdr_mainpo');
        return $result->result();
    }

    function tampil_inv_direct($data)
    {
        $query = "(invno like '%" . $data . "%' or custid like '%" . $data . "%' or custcompany like '%" . $data . "%')";
        $this->db->where($query);
        $this->db->where('tipe', '1');

        $this->db->order_by('invno', 'desc');

        $result = $this->db->get('pur_tbl_trn_inv_hdr');
        return $result->result();
    }

    function tampil_inv_where($data)
    {
        $this->db->where('invno', $data);
        $this->db->order_by('nourut');

        $result = $this->db->get('zhl_pur_vw_trn_inv');
        return $result->result();
    }

    function tampil_inv_where_dp($data)
    {
        $this->db->select('b.no_reff,a.detail_id,a.bayar_inv');
        $this->db->from('pur_tbl_trn_inv_dp a');
        $this->db->join('fin_tbltrn_cashbank_journal_header b', 'b.header_id=a.detail_id');
        $this->db->where('a.invno', $data);

        $result = $this->db->get();
        return $result->result();
    }

    function getDocNo_inv($docdate)
    {
        $query = "year(docdate) = year('" . $docdate . "')";
        $this->db->where($query);
        $sql =  $this->db->get('pur_tbl_trn_inv_hdr');
        if ($sql->num_rows() > 0) {
            $this->db->select('max(substring(invno,10, length(invno) - 9)) + 1 as docno');
            $this->db->where($query);
            $data = $this->db->get('pur_tbl_trn_inv_hdr')->row();
            $result = $data->docno;
        } else {
            $result = 1;
        }

        return $result;
    }

    function tampil_inv_get_dp($data)
    {
        $query = "po_id in (" . $data . ")";
        $this->db->select_sum('uang_muka');
        $this->db->where($query);

        $result = $this->db->get('fin_tbltrn_cashbank_journal_detail_po');
        return $result->result();
    }

    function tampil_inv_get_dp_new($inv, $filter)
    {
        $query = "suplier ='" . $inv . "' and no_reff like '%" . $filter . "%'";
        $this->db->select('header_id,no_reff,customer_company_name,currency_id,dp_total,total_bayar');
        $this->db->where($query);

        $result = $this->db->get('ship_vw_trn_dp');

        return $result->result();
    }



    function tampil_inv_so($cust, $sono)
    {
        $query1 = "proses = 0 and custid='" . $cust . "' and qty <> 0 and inv_status <> 1";
        //$query2 = "(sono like '%" . $sono . "%' or itemname like '%" . $sono . "%')";

        $this->db->where($query1);
        //  $this->db->where($query2);
        $this->db->order_by('sono');

        $result = $this->db->get('zhl_pur_vw_trn_so');
        return $result->result();
    }
    function tampil_inv_soall($data){
        // $query1="inv_status <> 1" ;
        // $query2="(sono like '%".$data."%' or custid like '%".$data."%' or custcompany like '%".$data."%')";
        $query1 = "proses = 0  and qty <> 0 and inv_status<> 1";
        
        $this->db->where($query1);
        $this->db->order_by('sono');

        $result=$this->db->get('zhl_pur_vw_trn_so');
        return $result->result();
    }

    function delete_inv($data)
    {
        $this->db->where('invno', $data);
        $query =  $this->db->get('pur_tbl_trn_inv_hdr')->row();

        if ($query->invno != '') {
            if ($query->sono != '') {
                $sono = $query->sono;
                $dataso = array('proses' => '0');
                $this->db->where('sono', trim($sono));
                $this->db->update('pur_tbl_trn_so_dtl', $dataso);

                $this->db->where('invno', $data);
                $this->db->delete('pur_tbl_trn_inv_hdr');

                $this->db->where('invno', $data);
                $this->db->delete('pur_tbl_trn_inv_dtl');
            } else if ($query->sono == '') {
                $this->db->where('invno', $data);
                $this->db->delete('pur_tbl_trn_inv_hdr');

                $this->update_delete_inv($data);
            }
        }

        return true;
    }

    function delete_inv_sp($data)
    {
        $this->db->trans_begin();
        $this->db->query("SET @flag = 0");
        $this->db->query("call sp_zhl_pur_tbl_trn_inv_del('" . $data . "',@flag)");
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

    function simpan_inv($datahdr)
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
        $sono      = $datahdr['sono'];

        $this->db->insert('pur_tbl_trn_inv_hdr', $datahdr);

        if ($sono != '') {
            $dataso = array('proses' => '1');
            $this->db->where('sono', $sono);
            $this->db->update('pur_tbl_trn_so_dtl', $dataso);
        }

        for ($i = 0; $i < $jml; $i++) {
            $datadtl = array(
                'invno'        => $datahdr['invno'],
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
                'createdby'    => strtoupper($this->session->userdata('userid')),
                'createddate'  => date('Y-m-d H:i:s')
            );
            $this->db->insert('pur_tbl_trn_inv_dtl', $datadtl);

            if ($sono == '') {
                $datagr = array('proses' => '1');
                $this->db->where('docno', $docno_gr[$i]);
                $this->db->where('mainpo', $mainpo[$i]);
                $this->db->where('itemid', $itemid[$i]);
                $this->db->update('pur_tbl_trn_gr_dtl', $datagr);
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

    function update_inv($invno, $datahdr)
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
        $sono      = $datahdr['sono'];

        $this->db->where('invno', $invno);
        $this->db->update('pur_tbl_trn_inv_hdr', $datahdr);

        $this->update_delete_inv($invno);

        for ($i = 0; $i < $jml; $i++) {
            $datadtl = array(
                'invno' => $invno, 'mainpo' => $mainpo[$i], 'itemid' => $itemid[$i], 'itemname' => $itemname[$i],
                'qty' => $qty[$i], 'quantity' => $quantity[$i], 'unitprice' => $unitprice[$i], 'taxcode' => $taxcode[$i], 'npbbno' => $npbb[$i],
                'total' => $total[$i], 'pono' => $pono[$i], 'docno_gr' => $docno_gr[$i], 'comission' => $Comission[$i], 'invoiceprice' => $Invoice[$i],
                'createdby' => strtoupper($this->session->userdata('userid')), 'createddate' => date('Y-m-d H:i:s'),
                'lastupdatedby' => strtoupper($this->session->userdata('userid')), 'lastupdateddate' => date('Y-m-d H:i:s')
            );
            $this->db->insert('pur_tbl_trn_inv_dtl', $datadtl);

            if ($sono != '') {
                $datagr = array('proses' => '1');
                $this->db->where('docno', $docno_gr[$i]);
                $this->db->where('mainpo', $mainpo[$i]);
                $this->db->where('itemid', $itemid[$i]);
                $this->db->update('pur_tbl_trn_gr_dtl', $datagr);
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

    function simpan_inv_sp($datahdr)
    {
        $this->db->trans_begin();
        $itemid          = $this->input->post('ItemID');
        $itemname        = $this->input->post('ItemName');
        $uom_alias       = $this->input->post('UOM_Alias');
        $qty             = $this->input->post('Qty');
        $qty_alias       = $this->input->post('Qty_Alias');
        $quantity        = $this->input->post('Quantity');
        $quantity_alias  = $this->input->post('Quantity_Alias');
        $unitprice       = $this->input->post('UnitPrice');
        $unitprice_alias = $this->input->post('UnitPrice_Alias');
        $taxcode         = $this->input->post('TaxCode');
        $npbb            = $this->input->post('NPBB');
        $pono            = $this->input->post('pono');
        $total           = $this->input->post('Total');
        $mainpo          = $this->input->post('Mainpo');
        $docno_gr        = $this->input->post('docno_gr');
        $comission       = $this->input->post('Comission');
        $invoice         = $this->input->post('Invoice');
        $jml             = count($itemid);

        $detail_id = $this->input->post('detail_id');
        $bayar     = $this->input->post('bayar');
        $jml2      = count($detail_id);

        if ($datahdr['trans'] == 'update') {
            $flag0 = $this->cek_acc_piutang($datahdr['invno']);

            if ($flag0 == 0) {
                $this->db->trans_rollback();
                $data = array('flag' => $flag0);
                return $data;
            }
        }

        $query1 = $this->simpan_inv_sp_hdr($datahdr);
        $invno = $query1->invno;
        $flag1 = $query1->flag;

        if ($flag1 == 0) {
            $this->db->trans_rollback();
            $data = array('flag' => $flag1);
            return $data;
        }

        $query2 = $this->simpan_inv_sp_dtl($invno, $mainpo, $itemid, $itemname, $qty, $quantity, $unitprice, $taxcode, $total, $npbb, $pono, $comission, $invoice, $docno_gr, $datahdr['createdby'], $jml, $datahdr['ipaddress'], $uom_alias, $qty_alias, $quantity_alias, $unitprice_alias);
        $flag2 = $query2->flag;

        if ($flag2 == 0) {
            $this->db->trans_rollback();
            $data = array('flag' => $flag2);
            return $data;
        }

        $query3 = $this->simpan_inv_sp_dp($invno, $detail_id, $bayar, $jml2);
        $flag3 = $query3->flag;

        if ($flag3 == 0) {
            $this->db->trans_rollback();
            $data = array('flag' => $flag3);
            return $data;
        }

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $data = array('flag' => $flag2);
            return $data;
        } else {
            $this->db->trans_commit();
            $data = array('flag' => $flag2, 'invno' => $invno);
            return $data;
        }
    }

    function simpan_inv_sp_hdr($datahdr)
    {
        $this->db->query("SET @invno = '" . $datahdr['invno'] . "'");
        $this->db->query("SET @flag = 0");
        $this->db->query("call sp_zhl_pur_tbl_trn_inv_hdr(
            '" . $datahdr['trans'] . "',
            @invno,
            '" . $datahdr['sono'] . "',
            '" . $datahdr['custid'] . "',
            '" . htmlspecialchars($datahdr['custcompany'], ENT_QUOTES) . "',
            '" . $datahdr['custcontact'] . "',
            '" . $datahdr['custref'] . "',
            '" . $datahdr['currency'] . "',
            '" . $datahdr['rate'] . "',
            '" . $datahdr['status'] . "',
            '" . $datahdr['postdate'] . "',
            '" . $datahdr['duedate'] . "',
            '" . $datahdr['docdate'] . "',
            '" . $datahdr['invfrom'] . "',
            '" . $datahdr['invto'] . "',
            '" . $datahdr['shipdate'] . "',
            '" . $datahdr['remark'] . "',
            '" . $datahdr['via'] . "',
            '" . $datahdr['total'] . "',
            '" . $datahdr['discount'] . "',
            '" . $datahdr['freight'] . "',
            '" . $datahdr['tax'] . "',
            '" . $datahdr['totaldue'] . "',
            '" . $datahdr['dp'] . "',
            '" . $datahdr['balance'] . "',
            '" . $datahdr['warehouse'] . "',
            '" . $datahdr['term'] . "',
            '" . $datahdr['termdays'] . "',
            '" . $datahdr['gst'] . "',
            '" . $datahdr['include'] . "',
            '" . $datahdr['createdby'] . "',
            @flag,
            '" . $datahdr['ipaddress'] . "')
            ");
        $row =  $this->db->query("Select @invno as invno, @flag as flag")->row();
        return $row;
    }

    function simpan_inv_sp_dtl($invno, $mainpo, $itemid, $itemname, $qty, $quantity, $unitprice, $taxcode, $total, $npbb, $pono, $vendorpo, $invoice, $docno_gr, $user, $jml, $ipaddress, $uom_alias, $qty_alias, $quantity_alias, $unitprice_alias)
    {
        for ($i = 0; $i < $jml; $i++) {

            if ($pono[$i] != '') {
                $this->db->query("UPDATE zhl_pur_tbl_trn_so_hdr set inv_status = '1' where sono ='" . $pono[$i] . "'");
            }
            $this->db->query("SET @flag = 0");
            $this->db->query("call sp_zhl_pur_tbl_trn_inv_dtl(
                '" . $invno . "',
                '" . $mainpo[$i] . "',
                '" . $itemid[$i] . "',
                '" . htmlspecialchars($itemname[$i], ENT_QUOTES) . "',
                '" . $qty[$i] . "',
                '" . $quantity[$i] . "',
                '" . $unitprice[$i] . "',
                '" . $taxcode[$i] . "',
                '" . $total[$i] . "',
                '" . $npbb[$i] . "',
                '" . $pono[$i] . "',
                '" . $vendorpo[$i] . "',
                '" . $invoice[$i] . "',
                '" . $docno_gr[$i] . "',
                '" . $user . "',
                @flag,
                '" . $ipaddress . "',
                '" . $jml . "',
                '" . $i . "',
                '" . $uom_alias[$i] . "',
                '" . $qty_alias[$i] . "',
                '" . $quantity_alias[$i] . "',
                '" . $unitprice_alias[$i] . "')
                ");
        }

        $row =  $this->db->query("Select @flag as flag")->row();

        return $row;
    }

    function simpan_inv_sp_dp($invno, $detail_id, $bayar, $jml2)
    {
        for ($i = 0; $i < $jml2; $i++) {
            $this->db->query("SET @flag = 0");
            $this->db->query("call sp_zhl_pur_tbl_trn_inv_dp(
            '" . $invno . "',
            '" . $detail_id[$i] . "',
            '" . $bayar[$i] . "',
            @flag)
            ");
        }

        $row =  $this->db->query("Select @flag as flag")->row();
        return $row;
    }

    function update_delete_inv($invno)
    {
        $datagr = array('proses' => '0');

        $this->db->where('invno', $invno);
        $sql = $this->db->get('zhl_pur_tbl_trn_inv_dtl')->result();

        foreach ($sql as $r) {
            $this->db->where('docno', $r->docno_gr);
            $this->db->where('mainpo', $r->mainpo);
            $this->db->where('itemid', $r->itemid);
            $this->db->update('zhl_pur_tbl_trn_gr_dtl', $datagr);
        }

        $this->db->where('invno', $invno);
        $this->db->delete('zhl_pur_tbl_trn_inv_dtl');
    }

    function tampil_inv_direct_item($item)
    {
        $query = "(itemid like '%" . $item . "%' or itemname like '%" . $item . "%')";

        $this->db->where($query);
        $this->db->where('notactive = 0');
        $this->db->order_by('itemname');

        $result = $this->db->get('zhl_pur_vw_mst_item');
        return $result->result();
    }

    function simpan_inv_direct_sp($datahdr)
    {
        $this->db->trans_begin();
        $itemid    = $this->input->post('ItemID');
        $itemname  = $this->input->post('ItemName');
        $qty       = $this->input->post('Qty');
        $quantity  = $this->input->post('Quantity');
        $unitprice = $this->input->post('UnitPrice');
        $taxcode   = $this->input->post('TaxCode');
        $npbb      = $this->input->post('NPBB');
        $pono      = $this->input->post('pono');
        $total     = $this->input->post('Total');
        $mainpo    = '';
        $docno_gr  = '0';
        $comission = $this->input->post('Comission');
        $invoice   = $this->input->post('Invoice');
        $jml       = count($itemid);

        if ($datahdr['trans'] == 'update') {
            $flag0 = $this->cek_acc_piutang($datahdr['invno']);

            if ($flag0 == 0) {
                $this->db->trans_rollback();
                $data = array('flag' => $flag0);
                return $data;
            }
        }

        $query1 = $this->simpan_inv_direct_sp_hdr($datahdr);
        $invno = $query1->invno;
        $flag1 = $query1->flag;

        if ($flag1 == 0) {
            $this->db->trans_rollback();
            $data = array('flag' => $flag1);
            return $data;
        }

        $query2 = $this->simpan_inv_direct_sp_dtl($invno, $mainpo, $itemid, $itemname, $qty, $quantity, $unitprice, $taxcode, $total, $npbb, $pono, $comission, $invoice, $docno_gr, $datahdr['createdby'], $jml, $datahdr['ipaddress']);
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
            $data = array('flag' => $flag2, 'invno' => $invno);
            return $data;
        }
    }

    function simpan_inv_direct_sp_hdr($datahdr)
    {
        $this->db->query("SET @invno = '" . $datahdr['invno'] . "'");
        $this->db->query("SET @flag = 0");
        $this->db->query("call sp_zhl_pur_tbl_trn_inv_direct_hdr('" . $datahdr['trans'] . "',
        @invno,
        '" . $datahdr['sono'] . "',
        '" . $datahdr['custid'] . "',
        '" . $datahdr['custcompany'] . "',
        '" . $datahdr['custcontact'] . "',
        '" . $datahdr['custref'] . "',
        '" . $datahdr['currency'] . "',
        '" . $datahdr['rate'] . "',
        '" . $datahdr['status'] . "',
        '" . $datahdr['postdate'] . "',
        '" . $datahdr['duedate'] . "',
        '" . $datahdr['docdate'] . "',
        '" . $datahdr['invfrom'] . "',
        '" . $datahdr['invto'] . "',
        '" . $datahdr['shipdate'] . "',
        '" . $datahdr['remark'] . "',
        '" . $datahdr['via'] . "',
        '" . $datahdr['total'] . "',
        '" . $datahdr['discount'] . "',
        '" . $datahdr['freight'] . "',
        '" . $datahdr['tax'] . "',
        '" . $datahdr['totaldue'] . "',
        '" . $datahdr['warehouse'] . "',
        '" . $datahdr['term'] . "',
        '" . $datahdr['termdays'] . "',
        '" . $datahdr['gst'] . "',
        '" . $datahdr['createdby'] . "',
        @flag,
        '" . $datahdr['ipaddress'] . "')");
        $row =  $this->db->query("Select @invno as invno,
         @flag as flag")->row();
        return $row;
    }

    function simpan_inv_direct_sp_dtl($invno, $mainpo, $itemid, $itemname, $qty, $quantity, $unitprice, $taxcode, $total, $npbb, $pono, $vendorpo, $invoice, $docno_gr, $user, $jml, $ipaddress)
    {
        for ($i = 0; $i < $jml; $i++) {
            $this->db->query("SET @flag = 0");
            $this->db->query("call sp_zhl_pur_tbl_trn_inv_direct_dtl('" . $invno . "',
            '" . $mainpo . "',
            '" . $itemid[$i] . "',
            '" . htmlspecialchars($itemname[$i], ENT_QUOTES) . "',
            '" . $qty[$i] . "',
            '" . $quantity[$i] . "',
            '" . $unitprice[$i] . "',
            '" . $taxcode[$i] . "',
            '" . $total[$i] . "',
            '" . $npbb[$i] . "',
            '" . $pono[$i] . "',
            '" . $vendorpo[$i] . "',
            '" . $invoice[$i] . "',
            '" . $docno_gr . "',
            '" . $user . "',
            @flag,
            '" . $ipaddress . "',
            '" . $jml . "',
            '" . $i . "')
                ");
        }

        $row =  $this->db->query("Select @flag as flag")->row();

        return $row;
    }

    function delete_inv_direct_sp($data)
    {
        $this->db->trans_begin();
        $this->db->query("SET @flag = 0");
        // $this->db->query("call sp_pur_tbl_trn_inv_direct_del('".$data."',@flag)");sp_pur_tbl_trn_inv_del
        $this->db->query("call s('" . $data . "',@flag)");
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

    function cek_acc_piutang($invno)
    {
        $flag = 1;
        $query = "nofaktur='" . $invno . "' and jenis_trans='PIJF' and (nota_debet > 0 or nota_kredit > 0 or bayar > 0)";
        $this->db->where($query);
        $sql = $this->db->get('zhl_acc_tbl_trn_piutang_test');

        if ($sql->num_rows() > 0) {
            $flag = 0;
        }
        return $flag;
    }
}
