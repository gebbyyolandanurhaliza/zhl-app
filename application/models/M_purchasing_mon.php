<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_purchasing_mon extends CI_Model
{
    //-----------------------------------------------------------ABOUT Mon-------------------------------------------------------------------
    function tampil_po_filter($from, $to, $vendor, $purchaser, $status, $mainpo, $item, $out)
    {
        $query = "docdate between '" . $from . "' and '" . $to . "'";
        if (trim($vendor) != "") {
            $query = $query . " and vendorid ='" . $vendor . "'";
        }
        if (trim($purchaser) != "") {
            $query = $query . " and createdby ='" . $purchaser . "'";
        }
        if (trim($status) != "") {
            $query = $query . " and status ='" . $status . "'";
        }
        if (trim($mainpo) != "") {
            $query = $query . " and mainpo like '%" . $mainpo . "%'";
        }

        if (trim($item) != "") {
            $query = $query . " and (itemid like '%" . $item . "%' or itemname like '%" . $item . "%')";
        }

        if ($status == '1') {
            if (trim($out) != "") {
                $query = $query . " and qty_outstanding > 0";
            }
        } else {
        }

        $this->db->where($query);
        $this->db->order_by('mainpo');
        //$result=  $this->db->get('pur_vw_trn_po_by_gr');
        $result =  $this->db->get('zhl_pur_vw_trn_po_by_gr');
        return $result->result();
    }



    function tampil_po_filter_purchaser($from, $to, $vendor, $purchaser, $status, $npbb, $mainpo, $item, $out)
    {
        $query = "docdate between '" . $from . "' and '" . $to . "'";
        if (trim($vendor) != "") {
            $query = $query . " and vendorid ='" . $vendor . "'";
        }
        if (trim($purchaser) != "") {
            $query = $query . " and createdby ='" . $purchaser . "'";
        }
        if (trim($status) != "") {
            $query = $query . " and status ='" . $status . "'";
        }
        if (trim($mainpo) != "") {
            $query = $query . " and mainpo like '%" . $mainpo . "%'";
        }
        if (trim($npbb) != "") {
            $query = $query . " and npbbno like '%" . $npbb . "%'";
        }
        if (trim($item) != "") {
            $query = $query . " and (itemid like '%" . $item . "%' or itemname like '%" . $item . "%')";
        }

        if ($status == '1') {
            if (trim($out) != "") {
                $query = $query . " and qty_outstanding > 0";
            }
        } else {
        }

        $this->db->distinct();
        $this->db->select('createdby');
        $this->db->where($query);
        $result =  $this->db->get('zhl_pur_vw_trn_po_by_gr');
        //$result=  $this->db->get('pur_vw_trn_po_by_gr');
        return $result->result();
    }

    function tampil_gr_filter($from, $to, $vendor, $docgr, $item, $mainpo)
    {

        //$result = $this->db->distinct();

        $query = "docdate between '" . $from . "' and '" . $to . "'";
        if (trim($vendor) != "") {
            $query = $query . " and vendorid ='" . $vendor . "'";
        }
        if (trim($docgr) != "") {
            $query = $query . " and docno like '%" . $docgr . "%'";
        }
        if (trim($item) != "") {
            $query = $query . " and (itemid like '%" . $item . "%' or itemname like '%" . $item . "%')";
        }
        if (trim($mainpo) != "") {
            $query = $query . " and mainpo like '%" . $mainpo . "%'";
        }

        $field = "a.*
        ,(select ifnull(sum(qty),0) from zhl_pur_tbl_trn_gr_dtl "
            //  . "where docno in ('" . $docgr . "') and mainpo=a.mainpo and itemid=a.itemid"
            . "where docno not in (a.docno) and mainpo=(a.mainpo) and itemid=(a.itemid)"
            . ") as tqtywhs";

        $this->db->select($field);
        $this->db->from('zhl_pur_vw_trn_gr_show a');
        $this->db->where($query);
        $this->db->order_by('mainpo,itemid');
        $result = $this->db->get();
        return $result->result();
    }



    function tampil_whs_arr($p_dari, $p_sampai, $mainpo, $item, $status)
    {

        $result = $this->db->distinct();

        $query = "docdate between '" . $p_dari . "' and '" . $p_sampai . "'";
        if (trim($mainpo) != "") {
            $query = $query . " and id_gr like '%" . $mainpo . "%'";
        }
        if (trim($item) != "") {
            $query = $query . " and (itemid like '%" . $item . "%' or itemname like '%" . $item . "%')";
        }

        $field = "a.qtypo,mainpo";
        $this->db->select($field);
        $this->db->where($query);
        $this->db->order_by('mainpo,itemid');
        $result =  $this->db->get('zhl_pur_vw_monitoring a')->result();
        $dataArr = $result;

        foreach ($dataArr as $key => $val) {
            $pid = $val->mainpo == ''  ? "%%"  : $val->mainpo;
            $dataArr[$key]->ProductDtl = $this->db->query("SELECT * from zhl_pur_vw_monitoring where (mainpo like '$pid' )")->result();
            //  $dataArr[$key]->kecualiqty = $this->db->query("SELECT ifnull(sum(qty),0) from zhl_pur_tbl_trn_gr_dtl where docno not in ('" . $val->mainpo . "') and mainpo=$val->mainpo ")->result();
        }
        return $dataArr;

        // // $this->db->query("SELECT  DISTINCT qtypo
        // // FROM 
        // // zhl_pur_vw_monitoring
        // // WHERE
        // // id_gr = $mainpo");

        // $result = $this->db->distinct("qtypo")->where("docdate between", $p_dari and $p_sampai)->get('zhl_pur_vw_monitoring')->result();

        // //$result = $this->db->get()->result();
        // // return $result->result();
        // // $dataArr['invDtl'] =  $this->m_shipping_inv->tampil_inv_where_detail_arr($docNo);
        // $dataArr = $result;
        // // foreach ($dataArr as $key => $val) {
        // //     $pid = $val->product_category_id == ''  ? "%%"  : $val->product_category_id;
        // //     $dataArr[$key]->ProductDtl = $this->db->query("SELECT Packing,uom,quantity, gross_weight,net_weight from eform_coo_phyto_health_product where (product_category_id like '$pid' and coo_phyto_health_id=$val->coo_phyto_health_id) ")->result();
        // //     // $dataArr[$key]->poNumberDtl = $this->db->query("SELECT  Packing from eform_coo_phyto_health_product WHERE coo_phyto_health_id=$val->coo_phyto_health_id and product_category_id like '$pid' order by product_category_id asc")->result();
        // // }

        // return $dataArr;
    }


    function tampil_whs_filter($p_dari, $p_sampai, $mainpo, $item, $status)
    {
        $this->db->distinct();

        $query = "docdate between '" . $p_dari . "' and '" . $p_sampai . "'";
        // if (trim($vendor) != ""){$query= $query." and vendorid ='".$vendor."'";}
        if (trim($mainpo) != "") {
            $query = $query . " and id_gr like '%" . $mainpo . "%'";
        }
        if (trim($item) != "") {
            $query = $query . " and (itemid like '%" . $item . "%' or itemname like '%" . $item . "%')";
        }

        $field = "a.*
        ,(select ifnull(sum(qty),0) from zhl_pur_tbl_trn_gr_dtl "
            . "where docno not in (a.id_gr) and mainpo=(a.mainpo) and itemid=(a.itemid)"
            . ") as tqtywhs";



        $this->db->select($field);
        $this->db->from('zhl_pur_vw_monitoring a');
        $this->db->where($query);
        $this->db->order_by('mainpo,itemid');
        $result = $this->db->get();
        return $result->result();
    }


    function tampil_whs_filter_item($tanggal, $item)
    {
        
        return $this->db->query("Select itemid, SUM(qnty) as qty, itemname,uom,whsname, sum(qtyin) as qtywhs FROM
        (
        select B.docno,B.docdate,A.itemid,A.qty as qnty, A.itemname,A.uom,V.whsid,X.name AS whsname,A.qty as qtyin
        From zhl_pur_tbl_trn_gr_dtl as A INNER JOIN 
                 zhl_pur_tbl_trn_gr_hdr	AS B ON A.docno=B.docno
                 LEFT JOIN zhl_pur_tbl_trn_po_hdr V on V.mainpo= A.mainpo
                 LEFT JOIN zhl_pur_tbl_mst_whs X on X.id = V.whsid
        UNION		 
        select D.sono as docno,D.docdate,C.itemid,(C.qty * -1) as qnty, C.itemname,C.mainpo,C.docno_gr,C.mainpo,C.mainpo
        From zhl_pur_tbl_trn_so_dtl as C INNER JOIN 
                 zhl_pur_tbl_trn_so_hdr	AS D ON C.sono=D.sono
        ) as E
        where E.docdate < '" . $tanggal . "' and itemid like '%" . $item . "%' GROUP BY itemid");




        // $this->db->distinct();
        // $query = "docdate < '" . $date . "'";
   
        // if (trim($item) != "") {
        //     $query = $query . " and (itemid like '%" . $item . "%' or itemname like '%" . $item . "%')";
        // }

        // $field = "itemid,itemname,sum(qtywhs) as qtywhs, sum(qtyout) as qtyout,uomname,whsname ";



        // $this->db->select($field);
        // $this->db->from('zhl_pur_vw_trn_gr_show ');
        // $this->db->where($query);
        // $this->db->group_by('itemid,whsid');
        // $this->db->order_by('whsid');
        // $result = $this->db->get();
        // return $result->result();
    }
    function tampil_pi_filter($from, $to, $vendor, $status, $sono, $item, $out)
    {
        $query = "docdate between '" . $from . "' and '" . $to . "'";
        if (trim($vendor) != "") {
            $query = $query . " and vendorid ='" . $vendor . "'";
        }
        if (trim($status) != "") {
            $query = $query . " and status ='" . $status . "'";
        }
        if (trim($sono) != "") {
            $query = $query . " and sono like '%" . $sono . "%'";
        }

        if (trim($item) != "") {
            $query = $query . " and (itemid like '%" . $item . "%' or itemname like '%" . $item . "%')";
        } else {
        }

        $this->db->where($query);
        $this->db->order_by('sono');
        //$result=  $this->db->get('pur_vw_trn_po_by_gr');
        $result =  $this->db->get('zhl_pur_vw_trn_so');
        return $result->result();
    }

    function tampil_pl_filter($from, $to, $vendor, $status, $mainpo, $item, $out)
    {
        $query = "docdate between '" . $from . "' and '" . $to . "'";
        if (trim($vendor) != "") {
            $query = $query . " and vendorid ='" . $vendor . "'";
        }

        if (trim($status) != "") {
            $query = $query . " and status ='" . $status . "'";
        }
        if (trim($mainpo) != "") {
            $query = $query . " and sono like '%" . $mainpo . "%'";
        }

        if (trim($item) != "") {
            $query = $query . " and (itemid like '%" . $item . "%' or itemname like '%" . $item . "%')";
        } else {
        }

        $this->db->where($query);
        $this->db->order_by('sono');
        //$result=  $this->db->get('pur_vw_trn_po_by_gr');
        $result =  $this->db->get('zhl_pur_vw_trn_so');
        return $result->result();
    }

    function tampil_inv_filter($from, $to, $cust, $purchaser, $invno, $mainpo, $item, $sono)
    {
        $query = "docdate between '" . $from . "' and '" . $to . "'";
        if (trim($cust) != "") {
            $query = $query . " and custid ='" . $cust . "'";
        }
        if (trim($purchaser) != "") {
            $query = $query . " and createdby ='" . $purchaser . "'";
        }
        if (trim($invno) != "") {
            $query = $query . " and invno like '%" . $invno . "%'";
        }
        if (trim($mainpo) != "") {
            $query = $query . " and mainpo like '%" . $mainpo . "%'";
        }
        if (trim($item) != "") {
            $query = $query . " and (itemid like '%" . $item . "%' or itemname like '%" . $item . "%')";
        }
        if (trim($sono) != "") {
            $query = $query . " and sono like '%" . $sono . "%'";
        }

        $this->db->where($query);
        $this->db->order_by('invno');
        $result =  $this->db->get('zhl_pur_vw_trn_inv');
        return $result->result();
    }

    function tampil_po_filter_whs($mainpo, $item, $cust)
    {
        $this->db->where('mainpo', $mainpo);
        $this->db->where('itemid', $item);
        $this->db->where('custidbyorder', $cust);
        $result =  $this->db->get('pur_vw_trn_gr');
        return $result->result();
    }

    function tampil_po_filter_vendor($vendor)
    {
        $this->db->where('supplierid', $vendor);
        $result =  $this->db->get('pur_tbl_mst_supplier');
        return $result->result();
    }

    function tampil_monthly_ps($sp, $year, $cur, $cat, $subcat, $filter, $created)
    {
        $sql = $this->db->query("call " . $sp . "('" . $year . "','" . $cur . "','" . $cat . "%','" . $subcat . "%','" . $filter . "%','" . $created . "%')");
        $result = $sql->result();
        $sql->next_result();
        $sql->free_result();
        return $result;
    }

    function tampil_purchaser($table)
    {
        $this->db->select('createdby');
        $this->db->group_by('createdby');

        $result =  $this->db->get($table);
        return $result->result();
    }

    function get_year()
    {
        $this->db->select('year(docdate) as year');
        $this->db->group_by('year(docdate)');
        $this->db->order_by('docdate');
        $result = $this->db->get('zhl_pur_tbl_trn_lr_hdr');

        return $result->result();
    }

    //tambahan 28/11.2017
    function print_inv_filter($from, $to)
    {
        // $sql = $this->db->query("call sp_pur_mon_sales_invoice_report('$from', '$to')"); Ini adalah SP lama pada 250919
        $sql = $this->db->query("call zhl_sp_pur_mon_sales_invoice_report('$from', '$to')");
        $res = $sql->result();
        $sql->next_result();
        $sql->free_result();
        return $res;
    }

    // function print_inv_filter2($from,$to,$cust,$purchaser,$invno,$mainpo,$item){
    //     $query="docdate between '".$from."' and '".$to."'";
    //     if (trim($cust) != ""){$query= $query." and custid ='".$cust."'";}
    //     if (trim($purchaser) != ""){$query= $query." and createdby ='".$purchaser."'";}
    //     if (trim($invno) != ""){$query= $query." and invno like '%".$invno."%'";}
    //     if (trim($mainpo) != ""){$query= $query." and mainpo like '%".$mainpo."%'";}
    //     if (trim($item) != ""){$query= $query." and (itemid like '%".$item."%' or itemname like '%".$item."%')";}

    //     $this->db->where($query);
    //     $this->db->group_by('invno');
    //     $result=  $this->db->get('pur_vw_trn_inv');
    //     return $result->result();
    // }

    // function print_inv_filter($from,$to,$cust,$purchaser,$invno,$mainpo,$item){
    //     $query="docdate between '".$from."' and '".$to."'";
    //     if (trim($cust) != ""){$query= $query." and custid ='".$cust."'";}
    //     if (trim($purchaser) != ""){$query= $query." and createdby ='".$purchaser."'";}
    //     if (trim($invno) != ""){$query= $query." and invno like '%".$invno."%'";}
    //     if (trim($mainpo) != ""){$query= $query." and mainpo like '%".$mainpo."%'";}
    //     if (trim($item) != ""){$query= $query." and (itemid like '%".$item."%' or itemname like '%".$item."%')";}

    //     $this->db->where($query);
    //     $this->db->order_by('invno');
    //     $result=  $this->db->get('pur_vw_trn_inv_mainpo');
    //     return $result->result();
    // }

    function tampil_do_filter($from, $to, $vendor, $purchaser, $mainpo, $item)
    {
        $query = "docdate between '" . $from . "' and '" . $to . "'";
        if (trim($vendor) != "") {
            $query = $query . " and vendorid ='" . $vendor . "'";
        }
        if (trim($purchaser) != "") {
            $query = $query . " and createdby ='" . $purchaser . "'";
        }
        if (trim($mainpo) != "") {
            $query = $query . " and mainpo like '%" . $mainpo . "%'";
        }
        if (trim($item) != "") {
            $query = $query . " and (itemid like '%" . $item . "%' or itemname like '%" . $item . "%')";
        }

        $this->db->where($query);
        $this->db->order_by('docno');
        $result =  $this->db->get('zhl_pur_vw_trn_do');
        return $result->result();
    }
}
