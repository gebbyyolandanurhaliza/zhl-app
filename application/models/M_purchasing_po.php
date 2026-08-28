<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_purchasing_po extends CI_Model
{
    private $tabel_zhl_pur_hdr = 'zhl_pur_tbl_trn_po_hdr';
    private $tabel_zhl_pur_dtl = 'zhl_pur_tbl_trn_po_dtl';

    function tampil_po($data)
    {
        $this->db->like('mainpo', $data);
        $this->db->or_like('vendorid', $data);
        $this->db->or_like('vendorcompany', $data);

        $this->db->order_by('mainpo', 'desc');
        $result = $this->db->get($this->tabel_zhl_pur_hdr);
        return $result->result();
    }

    function tampil_po_hdr($data)
    {
        $this->db->like('mainpo', $data);
        $this->db->or_like('vendorid', $data);
        $this->db->or_like('vendorcompany', $data);
        $this->db->or_like('custid', $data);
        $this->db->or_like('custcompany', $data);

        $result = $this->db->get($this->tabel_zhl_pur_hdr);
        return $result->result();
    }

    function tampil_po_where($data)
    {
        $this->db->where('mainpo', $data);
        $this->db->order_by('nourut');
        $result = $this->db->get('zhl_pur_vw_trn_po');
        return $result->result();
    }

    function tampil_po_where_other($data)
    {
        $query1 = "status = 1 and qtypo > ifnull(qtywhs,0)";
        // $query2 = "(mainpo like '%" . $data . "%' or itemid like '%" . $data . "%' or itemname like '%" . $data . "%' or vendorid like '%" . $data . "%' or vendorcompany like '%" . $data . "%')";

        $this->db->where($query1);
       // $this->db->where($query2);
       // $this->db->order_by('shipdate');

        $result = $this->db->get('zhl_pur_vw_trn_po_by_gr');
        return $result->result();
    }

    function update_po_close($mainpo)
    {
        $status = array('status' => '2', 'Lastupdatedby' => strtoupper($this->session->userdata('userid')), 'Lastupdateddate' => now());

        $this->db->where('mainpo', $mainpo);
        $this->db->update($this->tabel_zhl_pur_hdr, $status);

        return TRUE;
    }

    function getDocNo_po($docdate)
    {
        $query = "year(docdate) = year('" . $docdate . "')";
        $this->db->where($query);
        $sql =  $this->db->get($this->tabel_zhl_pur_hdr);
        if ($sql->num_rows() > 0) {
            $this->db->select('max(substring(mainpo,11, length(mainpo) -10) ) + 1 as docno');
            $this->db->where($query);
            $data = $this->db->get($this->tabel_zhl_pur_hdr)->row();
            $result = $data->docno;
        } else {
            $result = 1;
        }

        return $result;
    }

    function tampil_po_npbb($item)
    {
        $query = "(npbbno like '%" . $item . "%' or itemid like '%" . $item . "%' or itemname like '%" . $item . "%') and proses = 0 ";

        $this->db->where($query);
        $this->db->order_by('npbbno');

        $result = $this->db->get('zhl_pur_vw_trn_npbb');
        return $result->result();
    }

    function tampil_po_item($item, $vendor, $cur)
    {
        $query = "(a.itemid like '%" . $item . "%' or a.itemname like '%" . $item . "%')";

        $this->db->select('a.itemid,a.itemname,a.pmcode,a.uomname,b.unitprice,a.per1000,a.hscode,a.country_id,a.country_name');
        $this->db->from("zhl_pur_vw_mst_item a left outer join (select itemid,unitprice from zhl_pur_vw_mst_item_price where vendorid = '" . $vendor . "' and currencyid = '" . $cur . "') b on b.itemid=a.itemid");
        $this->db->where($query);
        $this->db->where('a.notactive', '0');
        $this->db->order_by('a.ItemID');

        $result = $this->db->get();
        return $result->result();
    }

    function delete_po($data)
    {
        $row = $this->cek_po($data);

        if ($row != 0) {
            $this->db->where('mainpo', $data);
            $this->db->delete($this->tabel_zhl_pur_hdr);

            $this->update_delete_po($data);
            $result = 0;
        } else {
            $result = 1;
        }

        return $result;
    }

    function delete_po_sp($data, $tipe)
    {
        $this->db->trans_begin();
        $this->db->query("SET @flag = 0");
        $this->db->query("call sp_zhl_pur_tbl_trn_po_del('" . $data . "','" . $tipe . "','" . strtoupper($this->session->userdata('userid')) . "',@flag)");
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

    function simpan_po($datahdr)
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
        $vendorpo  = $this->input->post('VendorPO');
        $invoice   = $this->input->post('Invoice');
        $companyid = $this->input->post('Companyid');
        $jml       = count($itemid);

        $this->db->insert($this->tabel_zhl_pur_hdr, $datahdr);

        for ($i = 0; $i < $jml; $i++) {
            $cust = $companyid[$i];

            if ($cust == '') {
                $cust = $datahdr['custid'];
            }

            $datadtl = array(
                'mainpo'       => $datahdr['mainpo'],
                'itemid'       => $itemid[$i],
                'itemname'     => $itemname[$i],
                'qty'          => $qty[$i],
                'quantity'     => $quantity[$i],
                'unitprice'    => $unitprice[$i],
                'taxcode'      => $taxcode[$i],
                'npbbno'       => $npbb[$i],
                'total'        => $total[$i],
                'pono'         => $pono[$i],
                'vendorpo'     => $vendorpo[$i],
                'invoiceprice' => $invoice[$i],
                'companyid'    => $cust,
                'createdby'    => strtoupper($this->session->userdata('userid')),
                'createddate'  => date('Y-m-d H: i: s')
            );
            $this->db->insert($this->tabel_zhl_pur_dtl, $datadtl);

            $datanpbb = array('proses' => '1');
            $this->db->where('npbbno', $npbb[$i]);
            $this->db->where('itemid', $itemid[$i]);
            $this->db->where('companyid', $companyid[$i]);
            $this->db->update('pur_tbl_trn_npbb_dtl', $datanpbb);
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

    function update_po($mainpo, $datahdr)
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
        $vendorpo  = $this->input->post('VendorPO');
        $invoice   = $this->input->post('Invoice');
        $companyid = $this->input->post('Companyid');
        $jml = count($itemid);

        $this->db->where('mainpo', $mainpo);
        $this->db->update($this->tabel_zhl_pur_hdr, $datahdr);

        $this->update_delete_po($mainpo);

        for ($i = 0; $i < $jml; $i++) {
            $cust = $companyid[$i];

            if ($cust == '') {
                $cust = $datahdr['custid'];
            }

            $datadtl = array(
                'mainpo'          => $mainpo,
                'itemid'          => $itemid[$i],
                'itemname'        => $itemname[$i],
                'qty'             => $qty[$i],
                'quantity'        => $quantity[$i],
                'unitprice'       => $unitprice[$i],
                'taxcode'         => $taxcode[$i],
                'npbbno'          => $npbb[$i],
                'total'           => $total[$i],
                'pono'            => $pono[$i],
                'vendorpo'        => $vendorpo[$i],
                'invoiceprice'    => $invoice[$i],
                'companyid'       => $cust,
                'createdby'       => strtoupper($this->session->userdata('userid')),
                'createddate'     => date('Y-m-d H: i: s'),
                'lastupdatedby'   => strtoupper($this->session->userdata('userid')),
                'lastupdateddate' => date('Y-m-d H: i: s')
            );

            $this->db->insert($this->tabel_zhl_pur_dtl, $datadtl);

            $datanpbb = array('proses' => '1');
            $this->db->where('npbbno', $npbb[$i]);
            $this->db->where('itemid', $itemid[$i]);
            $this->db->where('companyid', $companyid[$i]);
            $this->db->update($this->tabel_zhl_pur_dtl, $datanpbb);
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

    function simpan_po_sp($datahdr)
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
        $vendorpo  = $this->input->post('VendorPO');
        $invoice   = $this->input->post('Invoice');
        $companyid = $this->input->post('Companyid');
        $hscode    = $this->input->post('hscode');
        $country   = $this->input->post('country_id');
        $jml       = count($itemid);


        $query1 = $this->simpan_po_sp_hdr($datahdr);
        $mainpo = $query1->mainpo;
        $flag1 = $query1->flag;

        if ($flag1 == 0) {
            $this->db->trans_rollback();
            $data = array('flag' => $flag1);
            return $data;
        }

        $query2 = $this->simpan_po_sp_dtl($mainpo, $datahdr['custid'], $itemid, $itemname, $qty, $quantity, $unitprice, $taxcode, $total, $npbb, $companyid, $pono, $vendorpo, $invoice, $hscode, $country, $jml);
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
            $data = array('flag' => $flag2, 'mainpo' => $mainpo);
            return $data;
        }
    }

    function simpan_po_sp_hdr($datahdr)
    {
        $this->db->query("SET @mainpo = '" . $datahdr['mainpo'] . "'");
        $this->db->query("SET @flag = 0");
        $this->db->query("call sp_zhl_pur_tbl_trn_po_hdr(
            '" . $datahdr['trans'] . "',
            @mainpo,
            '" . $datahdr['vendorid'] . "',
            '" . htmlspecialchars($datahdr['vendorcompany'], ENT_QUOTES) . "',
            '" . $datahdr['vendorcontact'] . "',
            '" . $datahdr['vendorref'] . "',
            '" . $datahdr['currency'] . "',
            '" . $datahdr['rate'] . "',
            '" . $datahdr['status'] . "',
            '" . $datahdr['postdate'] . "',
            '" . $datahdr['deliverdate'] . "',
            '" . $datahdr['docdate'] . "',
            '" . $datahdr['custid'] . "',
            '" . $datahdr['custcompany'] . "',
            '" . $datahdr['shipdate'] . "',
            '" . $datahdr['custfrom'] . "',
            '" . $datahdr['custto'] . "',
            '" . $datahdr['arriveddate'] . "',
            '" . $datahdr['amendmentdate'] . "',
            '" . $datahdr['remark'] . "',
            '" . $datahdr['remarks'] . "',
            '" . $datahdr['total'] . "',
            '" . $datahdr['discount'] . "',
            '" . $datahdr['freight'] . "',
            '" . $datahdr['tax'] . "',
            '" . $datahdr['totaldue'] . "',
            '" . $datahdr['whsid'] . "',
            '" . $datahdr['tradeterm'] . "',
            '" . $datahdr['more'] . "',
            '" . $datahdr['include'] . "',
            '" . $datahdr['createdby'] . "',
            '" . $datahdr['remark_country'] . "',
            @flag)");
        $row =  $this->db->query("Select @mainpo as mainpo, @flag as flag")->row();

        return $row;
    }

    function simpan_po_sp_dtl($mainpo, $custhdr, $itemid, $itemname, $qty, $quantity, $unitprice, $taxcode, $total, $npbb, $companyid, $pono, $vendorpo, $invoice, $hscode, $country, $jml)
    {
        for ($i = 0; $i < $jml; $i++) {
            if ($custhdr != '') {
                $cust = $companyid[$i];

                if ($cust == '') {
                    $cust = $custhdr;
                }
            } else {
                $cust = '';
            }

            $this->db->query("SET @flag = 0");
            $this->db->query("call sp_zhl_pur_tbl_trn_po_dtl(
                '" . $mainpo . "',
                '" . $itemid[$i] . "',
                '" . htmlspecialchars($itemname[$i], ENT_QUOTES) . "',
                '" . $qty[$i] . "',
                '" . $quantity[$i] . "',
                '" . $unitprice[$i] . "',
                '" . $taxcode[$i] . "',
                '" . $total[$i] . "',
                '" . $npbb[$i] . "',
                '" . $cust . "',
                '" . $pono[$i] . "',
                '" . $vendorpo[$i] . "',
                '" . $invoice[$i] . "',
                '" . $hscode[$i] . "',
                '" . $country[$i] . "',
                @flag)");
        }

        $row =  $this->db->query("Select @flag as flag")->row();

        return $row;
    }

    function update_delete_po($mainpo)
    {
        $datanpbb = array('proses' => '0');

        $this->db->where('mainpo', $mainpo);
        $sql = $this->db->get($this->tabel_zhl_pur_dtl)->result();

        foreach ($sql as $r) {
            $this->db->where('npbbno', $r->npbbno);
            $this->db->where('itemid', $r->itemid);
            $this->db->where('companyid', $r->companyid);
            $this->db->update($this->tabel_zhl_pur_dtl, $datanpbb);
        }

        $this->db->where('mainpo', $mainpo);
        $this->db->delete($this->tabel_zhl_pur_dtl);
    }

    function cek_po($mainpo)
    {
        $this->db->where('mainpo', $mainpo);
        $sql =  $this->db->get($this->tabel_zhl_pur_dtl);
        if ($sql->num_rows() > 0) {
            $result = 0;
        } else {
            $result = 1;
        }

        return $result;
    }
}
