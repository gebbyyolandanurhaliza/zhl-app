<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_purchasing extends CI_Model
{
    //-------------------------------------------------------ABOUT COMPANY----------------------------------------------------------------
    function tampil_company()
    {
        $result =  $this->db->get('gen_tbl_company');
        return $result->result();
    }



    //--------------------------------------------------------ABOUT VENDOR PURCHASING---------------------------------------------------------------
    /* Used for master vendor purchasing */

    function tampil_vendor_limit_pur()
    {
        $this->db->where('notactive', '0');
        $this->db->order_by('createddate desc');
        $this->db->limit(50);

        $result =  $this->db->get('zhl_pur_vw_mst_vendor');
        return $result->result();
    }

    function tampil_vendor_pur($data)
    {
        $query = " (vendorid like '%" . $data . "%' or vendorcompany like '%" . $data . "%') ";
        $this->db->where($query);
        $this->db->where('notactive', '0');
        $result =  $this->db->get('zhl_pur_vw_mst_vendor');
        return $result->result();
    }

    function tampil_vendor_where($data)
    {
        $this->db->where('vendorid', $data);
        $result =  $this->db->get('zhl_pur_tbl_mst_vendor');
        return $result->row();
    }

    function tampil_vendor_pur_where($data)
    {
        $this->db->where('vendorid', $data);
        $result =  $this->db->get('zhl_pur_tbl_mst_vendor');
        return $result->row();
    }

    function simpan_vendor_pur($data)
    {
        $this->db->insert('zhl_pur_tbl_mst_vendor', $data);
        return true;
    }

    function update_vendor_pur($vendorid, $data, $user)
    {
        if ($user == 'WINNIE-YAU' || $user == 'IKBAL' || $user == 'PETER' || $user == 'DAVEN-SAW') {
            $this->db->where('vendorid', $vendorid);
            $sql = $this->db->get('zhl_pur_tbl_mst_vendor');
        } else {
            $this->db->where('createdby', $user);
            $this->db->where('vendorid', $vendorid);
            $sql = $this->db->get('zhl_pur_tbl_mst_vendor');
        }

        if ($sql->num_rows() > 0) {
            if ($user == 'WINNIE-YAU' || $user == 'IKBAL' || $user == 'PETER' || $user == 'DAVEN-SAW') {
                $this->db->where('vendorid', $vendorid);
                $this->db->update('zhl_pur_tbl_mst_vendor', $data);
            } else {
                $this->db->where('vendorid', $vendorid);
                $this->db->where('createdby', $user);
                $this->db->update('zhl_pur_tbl_mst_vendor', $data);
            }
            return true;
        } else {
            return false;
        }
    }

    function delete_vendor_pur($vendorid, $user)
    {
        $this->db->where('vendorid', $vendorid);
        $this->db->where('createdby', $user);
        $sql = $this->db->get('zhl_pur_tbl_mst_vendor');

        if ($sql->num_rows() > 0) {
            $this->db->where('vendorid', $vendorid);
            $this->db->update('zhl_pur_tbl_mst_vendor', array('notactive' => '1'));
            return true;
        } else {
            return false;
        }
    }

    //--------------------------------------------------------ABOUT VENDOR GROUP PURCHASING---------------------------------------------------------------
    /* Used for master vendor group purchasing */

    function tampil_vendor_group_pur()
    {
        $this->db->select('a.*,b.AccountName');
        $this->db->from('zhl_gen_tbl_mst_vendor_group a');
        $this->db->join('zhl_acc_master_coa b', 'b.NoCOA=a.nocoa', 'left outer');
        $this->db->where('a.notactive = 0');
        $result =  $this->db->get();
        return $result->result();
    }

    function simpan_vendor_group_pur($data)
    {
        $this->db->insert('zhl_pur_tbl_mst_vendor_group', $data);
        return true;
    }

    function update_vendor_group_pur($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update('zhl_pur_tbl_mst_vendor_group', $data);
        return true;
    }

    function delete_vendor_group_pur($id)
    {
        $this->db->where('id', $id);
        $this->db->update('zhl_pur_tbl_mst_vendor_group', array('notactive' => '1'));
        return true;
    }



    //--------------------------------------------------------ABOUT SUPPLIER---------------------------------------------------------------
    /* used for vendor in master */
    function tampil_supp($data)
    {
        $query = " (supplierid like '%" . $data . "%' or suppliercompany like '%" . $data . "%') ";
        $this->db->where($query);
        $this->db->where('notactive', '0');
        $result =  $this->db->get('zhl_pur_tbl_mst_supplier');
        return $result->result();
    }

    function tampil_supp_purchasing($data)
    {
        $query = " (supplierid like '%" . $data . "%' or suppliercompany like '%" . $data . "%') ";
        $this->db->where($query);
        $this->db->where('notactive', '0');
        $result =  $this->db->get('zhl_pur_tbl_mst_supplier');
        return $result->result();
    }

    function tampil_vendor_purchasing($data)
    {
        $query = " (vendorid like '%" . $data . "%' or vendorcompany like '%" . $data . "%') ";
        $this->db->where($query);
        $this->db->where('notactive', '0');
        $result =  $this->db->get('zhl_pur_tbl_mst_vendor');
        return $result->result();
    }

    function tampil_supp_limit()
    {
        $this->db->where('notactive', '0');
        $this->db->order_by('createddate desc');
        $this->db->limit(50);

        $result =  $this->db->get('zhl_pur_tbl_mst_supplier');
        return $result->result();
    }


    function tampil_supp_where($data)
    {
        $this->db->where('supplierid', $data);
        $result =  $this->db->get('zhl_pur_tbl_mst_supplier');
        return $result->row();
    }


    function simpan_vendor($data)
    {
        $this->db->insert('zhl_pur_tbl_mst_supplier', $data);
        return true;
    }

    function update_vendor($vendorid, $data, $user)
    {
        if ($user == 'WINNIE-YAU' || $user == 'IKBAL' || $user == 'PETER' || $user == 'DAVEN-SAW') {
            $this->db->where('supplierid', $vendorid);
            $sql = $this->db->get('zhl_pur_tbl_mst_supplier');
        } else {
            $this->db->where('createdby', $user);
            $this->db->where('supplierid', $vendorid);
            $sql = $this->db->get('zhl_pur_tbl_mst_supplier');
        }

        if ($sql->num_rows() > 0) {
            if ($user == 'WINNIE-YAU' || $user == 'IKBAL' || $user == 'PETER' || $user == 'DAVEN-SAW') {
                $this->db->where('supplierid', $vendorid);
                $this->db->update('zhl_pur_tbl_mst_supplier', $data);
            } else {
                $this->db->where('supplierid', $vendorid);
                $this->db->where('createdby', $user);
                $this->db->update('zhl_pur_tbl_mst_supplier', $data);
            }
            return true;
        } else {
            return false;
        }
    }

    function delete_vendor($vendorid, $user)
    {
        $this->db->where('supplierid', $vendorid);
        $this->db->where('createdby', $user);
        $sql = $this->db->get('zhl_pur_tbl_mst_supplier');

        if ($sql->num_rows() > 0) {
            $this->db->where('supplierid', $vendorid);
            $this->db->update('zhl_pur_tbl_mst_supplier', array('notactive' => '1'));
            return true;
        } else {
            return false;
        }
    }

    //--------------------------------------------------------ABOUT VENDOR ACOUNTING---------------------------------------------------------------
    /* used for vendor in master */

    function tampil_supp_group()
    {
        $this->db->select('a.*,b.AccountName');
        $this->db->from('zhl_gen_tbl_mst_vendor_group a');
        $this->db->join('acc_master_coa b', 'b.NoCOA=a.nocoa', 'left outer');
        $this->db->where('a.notactive = 0');
        $result =  $this->db->get();
        return $result->result();
    }

    function simpan_vendor_group($data)
    {
        $this->db->insert('zhl_gen_tbl_mst_vendor_group', $data);
        return true;
    }

    function update_vendor_group($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update('zhl_gen_tbl_mst_vendor_group', $data);
        return true;
    }

    function delete_vendor_group($id)
    {
        $this->db->where('id', $id);
        $this->db->update('zhl_gen_tbl_mst_vendor_group', array('notactive' => '1'));
        return true;
    }
    //-------------------------------------------------------ABOUT CUSTOMER------------------------------------------------------------------
    function tampil_cust($data)
    {
        $query = "(customer_code like '%" . $data . "%' or customer_company_name like '%" . $data . "%')";
        $this->db->where($query);
        $this->db->where('status_customer', '1');
        $this->db->where('group_customer', '4');
        $result =  $this->db->get('zhl_mar_tblmst_customer');
        return $result->result();
    }

    function tampil_cust_mar($data)
    {
        $query = "(a.customer_code like '%" . $data . "%' or a.customer_company_name like '%" . $data . "%')";
        $this->db->select('customer_code,customer_company_name,customer_contact_name,payment_term');
        $this->db->where($query);
        $this->db->where('a.status_customer', '1');
        $this->db->where('a.group_customer', '0');
        $this->db->from('zhl_mar_tblmst_customer a');
        $this->db->join('zhl_mar_tblmst_customer_payterm b', 'b.customer_id=a.customer_id', 'left');
        $result =  $this->db->get();
        return $result->result();
    }

    function tampil_cust_limit()
    {
        $this->db->where('status_customer', '1');
        $this->db->where('group_customer', '4');
        $this->db->order_bby('createddate desc');
        $this->db->limit(50);

        $result =  $this->db->get('zhl_mar_tblmst_customer');
        return $result->result();
    }

    function tampil_cust_where($data)
    {
        $this->db->where('customer_code', $data);
        $result =  $this->db->get('zhl_mar_tblmst_customer');
        return $result->row();
    }

    function simpan_customer($data)
    {
        $this->db->insert('zhl_mar_tblmst_customer', $data);
        return true;
    }

    function update_customer($customerid, $data)
    {
        $this->db->where('customer_code', $customerid);
        $this->db->update('zhl_mar_tblmst_customer', $data);
        return true;
    }

    function delete_customer($customerid)
    {
        $this->db->where('customer_code', $customerid);
        $this->db->update('zhl_mar_tblmst_customer', array('status_customer' => '0'));
        return true;
    }

    //-------------------------------------------------------ABOUT CUSTOMER PUR------------------------------------------------------------------

    function tampil_cust_pur($data)
    {
        $query = "(customer_code like '%" . $data . "%' or customer_company_name like '%" . $data . "%')";
        $this->db->where($query);
        $this->db->where('status_customer', '1');
        $result =  $this->db->get('zhl_mar_tblmst_customer');
        return $result->result();
    }


    function simpan_customer_pur($data)
    {
        $this->db->insert('zhl_pur_tblmst_customer', $data);
        return true;
    }

    function tampil_cust_where_pur($data)
    {
        $this->db->where('customer_id', $data);
        $result = $this->db->get('zhl_pur_tblmst_customer');
        return $result->row();
    }

    function update_customer_pur($customerid, $data)
    {
        $this->db->where('customer_code', $customerid);
        $this->db->update('zhl_pur_tblmst_customer', $data);
        return true;
    }

    function delete_customer_pur($customerid)
    {
        $this->db->where('customer_id', $customerid);
        $this->db->update('zhl_pur_tblmst_customer', array('status_customer' => '0'));
        return true;
    }

    //-------------------------------------------------------ABOUT WHS------------------------------------------------------------------
    function tampil_whs($data)
    {
        $query = "(name like '%" . $data . "%')";
        $this->db->where($query);
        $this->db->where('notactive', '0');
        $result =  $this->db->get('zhl_pur_tbl_mst_whs');
        return $result->result();
    }

    function tampil_whs_where($data)
    {
        $this->db->where('id', $data);
        $result =  $this->db->get('zhl_pur_tbl_mst_whs');
        return $result->row();
    }

    function simpan_whs($data)
    {
        $this->db->insert('zhl_gen_tbl_mst_whs', $data);
        return true;
    }

    function update_whs($customerid, $data)
    {
        $this->db->where('id', $customerid);
        $this->db->update('zhl_gen_tbl_mst_whs', $data);
        return true;
    }

    function delete_whs($customerid)
    {
        $this->db->where('id', $customerid);
        $this->db->update('zhl_gen_tbl_mst_whs', array('notactive' => '1'));
        return true;
    }

    //-------------------------------------------------------ABOUT WHS PUR------------------------------------------------------------------
    function tampil_whs_pur($data)
    {
        $query = "(name like '%" . $data . "%')";
        $this->db->where($query);
        $this->db->where('notactive', '0');
        $result =  $this->db->get('zhl_pur_tbl_mst_whs');
        return $result->result();
    }

    function tampil_whs_where_pur($data)
    {
        $this->db->where('id', $data);
        $result =  $this->db->get('zhl_pur_tbl_mst_whs');
        return $result->row();
    }

    function simpan_whs_pur($data)
    {
        $this->db->insert('zhl_pur_tbl_mst_whs', $data);
        return true;
    }

    function update_whs_pur($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update('zhl_pur_tbl_mst_whs', $data);
        return true;
    }

    function delete_whs_pur($id)
    {
        $this->db->where('id', $id);
        $this->db->update('zhl_pur_tbl_mst_whs', array('notactive' => '1'));
        return true;
    }
    //--------------------------------------------------------ABOUT CURRENCY-----------------------------------------------------------------
    function tampil_cur()
    {
        $result =  $this->db->get('zhl_gen_tbl_mst_currency');
        return $result->result();
    }
    //--------------------------------------------------------ABOUT ITEM---------------------------------------------------------------------
    function tampil_item($data)
    {
        $query = "(itemid like '%" . $data . "%' or itemname like '%" . $data . "%')";
        $this->db->where($query);
        $this->db->where('notactive=0');

        $result =  $this->db->get('zhl_gen_vw_mst_item');
        return $result->result();
    }

    function tampil_item_search($item, $category, $categorysub)
    {
        $query = "(itemid like '%" . $item . "%' or itemname like '%" . $item . "%')";

        if ($category != '') {
            $query = $query . " and categoryid = '" . $category . "'";

            if (trim($categorysub) != '') {
                $query = $query . " and categorysubid = '" . $categorysub . "'";
            }
        }

        $this->db->where($query);
        $this->db->where('notactive=0');

        $result =  $this->db->get('zhl_gen_vw_mst_item');
        return $result->result();
    }

    function tampil_vendor_by_category($item, $category, $categorysub)
    {
        $sql2 = "SELECT DISTINCT A.vendorid, E.* FROM
                pur_tbl_trn_po_hdr A
                INNER JOIN pur_tbl_trn_po_dtl B ON A.mainpo = B.mainpo
                INNER JOIN gen_tbl_mst_item C ON B.itemid = C.itemid
                INNER JOIN zhl_gen_tbl_mst_item_category_sub D ON C.categorysubid = D.categoryid
                INNER JOIN pur_tbl_mst_supplier E ON A.vendorid = E.supplierid
                WHERE D.categoryid = '$category' AND D.categorysubid = '$categorysub' AND C.itemid like '%$item%'";
        return $this->db->query($sql2)->result();
    }

    function tampil_item_limit()
    {
        $this->db->where('notactive=0');
        $this->db->order_by('createddate desc');
        $this->db->limit(50);
        $result = $this->db->get('zhl_gen_vw_mst_item');
        return $result->result();
    }


    function tampil_item_where($data)
    {
        $this->db->where('itemid', $data);

        $result =  $this->db->get('zhl_gen_vw_mst_item');
        return $result->result();
    }

    function simpan_item($data)
    {
        $this->db->insert('zhl_gen_tbl_mst_item', $data);
        return true;
    }

    function update_item($itemid, $data, $user)
    {
        if ($user == 'ROBERTSON' || $user == 'ERIC-TEO' || $user == 'rachel-lim' || $user = 'winnie-yau') {
            $this->db->where('itemid', $itemid);
            $sql = $this->db->get('zhl_gen_tbl_mst_item');
        } else {
            $this->db->where('itemid', $itemid);
            $this->db->where('createdby', $user);
            $sql = $this->db->get('zhl_gen_tbl_mst_item');
        }


        if ($sql->num_rows() > 0) {
            $this->db->where('itemid', $itemid);
            $sql2 = $this->db->get('zhl_pur_tbl_trn_po_dtl');

            if ($sql2->num_rows() < 1) {
                if ($user == 'ROBERTSON' || $user == 'ERIC-TEO' || $user == 'rachel-lim' || $user = 'winnie-yau') {
                    $this->db->where('itemid', $itemid);
                    $this->db->update('zhl_gen_tbl_mst_item', $data);
                } else {
                    $this->db->where('itemid', $itemid);
                    $this->db->where('createdby', $user);
                    $this->db->update('zhl_gen_tbl_mst_item', $data);
                }
            } else {
                $data = array(
                    'itemname' => $data['itemname'], 'itemremark' => $data['itemremark'], 'country_id' => $data['country_id'],
                    'pmcode' => $data['pmcode'], 'hscode' => $data['hscode'], 'idcwp1' => $data['idcwp1'], 'idcwp2' => $data['idcwp2'], 'idcwp3' => $data['idcwp3']
                );

                if ($user == 'ROBERTSON' || $user == 'ERIC-TEO' || $user == 'rachel-lim' || $user = 'winnie-yau') {
                    $this->db->where('itemid', $itemid);
                    $this->db->update('zhl_gen_tbl_mst_item', $data);
                } else {
                    $this->db->where('createdby', $user);
                    $this->db->where('itemid', $itemid);
                    $this->db->update('zhl_gen_tbl_mst_item', $data);
                }
            }
            return true;
        } else {
            return false;
        }
    }

    function delete_item($data, $user)
    {
        $this->db->where('createdby', $user);
        $sql = $this->db->get('zhl_gen_tbl_mst_item');

        if ($sql->num_rows() > 0) {
            $this->db->where('itemid', $data);
            $this->db->update('zhl_gen_tbl_mst_item', array('notactive' => '1'));
            return true;
        } else {
            return false;
        }
    }

    function update_item_factory($itemid, $data)
    {
        $this->db->where('itemid', $itemid);
        $this->db->update('zhl_gen_tbl_mst_item', $data);
        return true;
    }

    //--------------------------------------------------------ABOUT ITEM PUR-----------------------------------------------------------------------

    function tampil_item_pur($data)
    {
        $query = "(itemid like '%" . $data . "%' or itemname like '%" . $data . "%')";
        $this->db->where($query);
        $this->db->where('notactive=0');

        $result =  $this->db->get('zhl_pur_vw_mst_item');
        return $result->result();
    }

    function tampil_item_limit_pur()
    {
        $this->db->where('notactive=0');
        $this->db->order_by('createddate desc');
        $this->db->limit(50);
        $result = $this->db->get('zhl_pur_vw_mst_item');
        return $result->result();
    }

    function tampil_item_search_pur($item, $category, $categorysub)
    {
        $query = "(itemid like '%" . $item . "%' or itemname like '%" . $item . "%')";

        if ($category != '') {
            $query = $query . " and categoryid = '" . $category . "'";

            if (trim($categorysub) != '') {
                $query = $query . " and categorysubid = '" . $categorysub . "'";
            }
        }

        $this->db->where($query);
        $this->db->where('notactive=0');

        $result =  $this->db->get('zhl_pur_vw_mst_item');
        return $result->result();
    }

    function tampil_item_where_pur($data)
    {
        $this->db->where('itemid', $data);
        $result =  $this->db->get('zhl_pur_vw_mst_item');
        return $result->result();
    }

    function delete_item_pur($data, $user)
    {
        $this->db->where('createdby', $user);
        $sql = $this->db->get('zhl_pur_tbl_mst_item');

        if ($sql->num_rows() > 0) {
            $this->db->where('itemid', $data);
            $this->db->update('zhl_pur_tbl_mst_item', array('notactive' => '1'));
            return true;
        } else {
            return false;
        }
    }

    function simpan_item_pur($data)
    {
        $this->db->insert('zhl_pur_tbl_mst_item', $data);
        return true;
    }

    function update_item_pur($itemid, $data)
    {
        $this->db->where('itemid', $itemid);
        $this->db->update('zhl_pur_tbl_mst_item', $data);
        return true;
    }

    function update_item_factory_pur($itemid, $data)
    {
        $this->db->where('itemid', $itemid);
        $this->db->update('zhl_pur_tbl_mst_item', $data);
        return true;
    }

    //--------------------------------------------------------ABOUT UOM-----------------------------------------------------------------------
    function tampil_item_uom()
    {
        $this->db->where('notactive = 0');
        $result =  $this->db->get('zhl_gen_tbl_mst_item_uom');
        return $result->result();
    }

    function simpan_item_uom($data)
    {
        $this->db->insert('zhl_gen_tbl_mst_item_uom', $data);
        return true;
    }
    function update_item_uom($uomid, $data)
    {
        $this->db->where('uomid', $uomid);
        $this->db->update('zhl_gen_tbl_mst_item_uom', $data);
        return true;
    }
    function delete_item_uom($uomid)
    {
        $data = array('notactive' => '1');

        $this->db->where('uomid', $uomid);
        $this->db->update('zhl_gen_tbl_mst_item_uom', $data);
        return true;
    }
    //--------------------------------------------------------ABOUT UOM PUR-----------------------------------------------------------------------

    function tampil_item_uom_pur()
    {
        $this->db->where('notactive = 0');
        $result =  $this->db->get('zhl_pur_tbl_mst_item_uom');
        return $result->result();
    }

    function simpan_item_uom_pur($data)
    {
        $this->db->insert('zhl_pur_tbl_mst_item_uom', $data);
        return true;
    }
    function update_item_uom_pur($uomid, $data)
    {
        $this->db->where('uomid', $uomid);
        $this->db->update('zhl_pur_tbl_mst_item_uom', $data);
        return true;
    }

    function delete_item_uom_pur($uomid)
    {
        $data = array('notactive' => '1');

        $this->db->where('uomid', $uomid);
        $this->db->update('zhl_pur_tbl_mst_item_uom', $data);
        return true;
    }
    //--------------------------------------------------------ABOUT GROUP-----------------------------------------------------------------------
    function tampil_item_group()
    {
        $this->db->select('a.*,b.AccountName as AccountNameinv,c.AccountName as AccountNamegs,d.AccountName as AccountNameSales');
        $this->db->from('zhl_gen_tbl_mst_item_category a');
        $this->db->where('a.notactive = 0');
        $this->db->join('zhl_acc_master_coa b', 'b.NoCOA=a.nocoainv', 'left outer');
        $this->db->join('zhl_acc_master_coa c', 'c.NoCOA=a.nocoags', 'left outer');
        $this->db->join('zhl_acc_master_coa d', 'd.NoCOA=a.nocoasales', 'left outer');
        $this->db->order_by('a.categoryid');
        $result =  $this->db->get();
        return $result->result();
    }

    function tampil_item_group_where($categoryid)
    {
        $this->db->select('a.*,b.AccountName as AccountNameinv,c.AccountName as AccountNamegs,d.AccountName as AccountNameSales');
        $this->db->from('zhl_gen_tbl_mst_item_category a');
        $this->db->join('zhl_acc_master_coa b', 'b.NoCOA=a.nocoainv', 'left outer');
        $this->db->join('zhl_acc_master_coa c', 'c.NoCOA=a.nocoags', 'left outer');
        $this->db->join('zhl_acc_master_coa d', 'd.NoCOA=a.nocoasales', 'left outer');
        $this->db->where('a.categoryid', $categoryid);
        $result =  $this->db->get();
        return $result->row();
    }

    function simpan_item_group($data)
    {
        $this->db->insert('zhl_gen_tbl_mst_item_category', $data);
        return true;
    }

    function update_item_group($groupid, $data)
    {
        $this->db->where('categoryid', $groupid);
        $this->db->update('zhl_gen_tbl_mst_item_category', $data);
        return true;
    }

    function delete_item_group($categoryid)
    {
        $data = array('notactive' => '1');

        $this->db->where('categoryid', $categoryid);
        $this->db->update('zhl_gen_tbl_mst_item_category', $data);
        return true;
    }

    //--------------------------------------------------------ABOUT GROUP PUR-----------------------------------------------------------------------

    function tampil_item_group_pur()
    {
        $this->db->select('a.*,b.AccountName as AccountNameinv,c.AccountName as AccountNamegs,d.AccountName as AccountNameSales');
        $this->db->from('zhl_pur_tbl_mst_item_category a');
        $this->db->where('a.notactive = 0');
        $this->db->join('zhl_acc_master_coa b', 'b.NoCOA=a.nocoainv', 'left outer');
        $this->db->join('zhl_acc_master_coa c', 'c.NoCOA=a.nocoags', 'left outer');
        $this->db->join('zhl_acc_master_coa d', 'd.NoCOA=a.nocoasales', 'left outer');
        $this->db->order_by('a.categoryid');
        $result =  $this->db->get();
        return $result->result();
    }

    function tampil_item_group_pur_where($categoryid)
    {
        $this->db->select('a.*,b.AccountName as AccountNameinv,c.AccountName as AccountNamegs,d.AccountName as AccountNameSales');
        $this->db->from('zhl_pur_tbl_mst_item_category a');
        $this->db->join('zhl_acc_master_coa b', 'b.NoCOA=a.nocoainv', 'left outer');
        $this->db->join('zhl_acc_master_coa c', 'c.NoCOA=a.nocoags', 'left outer');
        $this->db->join('zhl_acc_master_coa d', 'd.NoCOA=a.nocoasales', 'left outer');
        $this->db->where('a.categoryid', $categoryid);
        $result =  $this->db->get();
        return $result->row();
    }

    function simpan_item_group_pur($data)
    {
        $this->db->insert('zhl_pur_tbl_mst_item_category', $data);
        return true;
    }

    function update_item_group_pur($groupid, $data)
    {
        $this->db->where('categoryid', $groupid);
        $this->db->update('zhl_pur_tbl_mst_item_category', $data);
        return true;
    }

    function delete_item_group_pur($categoryid)
    {
        $data = array('notactive' => '1');

        $this->db->where('categoryid', $categoryid);
        $this->db->update('zhl_pur_tbl_mst_item_category', $data);
        return true;
    }

    //--------------------------------------------------------ABOUT GROUP SUB-----------------------------------------------------------------------
    function tampil_item_group_sub()
    {
        $this->db->select('a.categorysubid,a.categorysubname,a.categoryid,b.categoryname,a.createdby,a.createddate,a.lastupdatedby,a.lastupdateddate');
        $this->db->from('zhl_gen_tbl_mst_item_category_sub a');
        $this->db->where('a.notactive = 0');
        $this->db->join('zhl_gen_tbl_mst_item_category b', 'b.categoryid=a.categoryid');
        $this->db->order_by('categorysubid');
        $result =  $this->db->get();
        return $result->result();
    }

    function tampil_item_group_sub_where($categoryid)
    {
        $this->db->where('categoryid', $categoryid);
        $this->db->order_by('categorysubid');

        $result =  $this->db->get('zhl_gen_tbl_mst_item_category_sub');
        return $result->result();
    }

    function simpan_item_group_sub($data)
    {
        $this->db->insert('zhl_gen_tbl_mst_item_category_sub', $data);
        return true;
    }

    function update_item_group_sub($groupid, $data)
    {
        $this->db->where('categorysubid', $groupid);
        $this->db->update('zhl_gen_tbl_mst_item_category_sub', $data);
        return true;
    }
    function delete_item_group_sub($categorysubid)
    {
        $data = array('notactive' => '1');

        $this->db->where('categorysubid', $categorysubid);
        $this->db->update('zhl_gen_tbl_mst_item_category_sub', $data);
        return true;
    }

    //--------------------------------------------------------ABOUT GROUP SUB PUR-----------------------------------------------------------------------
    function tampil_item_group_sub_pur()
    {
        $this->db->select('a.categorysubid,a.categorysubname,a.categoryid,b.categoryname,a.createdby,a.createddate,a.lastupdatedby,a.lastupdateddate');
        $this->db->from('zhl_pur_tbl_mst_item_category_sub a');
        $this->db->where('a.notactive = 0');
        $this->db->join('zhl_pur_tbl_mst_item_category b', 'b.categoryid=a.categoryid');
        $this->db->order_by('categorysubid');
        $result =  $this->db->get();
        return $result->result();
    }

    function tampil_item_group_sub_pur_where($categoryid)
    {
        $this->db->where('categoryid', $categoryid);
        $this->db->order_by('categorysubid');

        $result =  $this->db->get('zhl_pur_tbl_mst_item_category_sub');
        return $result->result();
    }

    function simpan_item_group_sub_pur($data)
    {
        $this->db->insert('zhl_pur_tbl_mst_item_category_sub', $data);
        return true;
    }

    function update_item_group_sub_pur($groupid, $data)
    {
        $this->db->where('categorysubid', $groupid);
        $this->db->update('zhl_pur_tbl_mst_item_category_sub', $data);
        return true;
    }

    function delete_item_group_sub_pur($categorysubid)
    {
        $data = array('notactive' => '1');

        $this->db->where('categorysubid', $categorysubid);
        $this->db->update('zhl_pur_tbl_mst_item_category_sub', $data);
        return true;
    }


    //--------------------------------------------------------ABOUT ITEM PRICE-----------------------------------------------------------------------
    function tampil_item_price($data)
    {
        $query = "supplierid like '%" . $data . "%' or suppliercompany like '%" . $data . "%' or itemid like '%" . $data . "%' or itemname like '%" . $data . "%'";

        $this->db->where($query);
        $this->db->order_by('supplierid');

        $result =  $this->db->get('zhl_gen_vw_mst_item_price');
        return $result->result();
    }

    function tampil_item_price_limit()
    {
        $this->db->order_by('supplierid');
        $this->db->limit(50);

        $result =  $this->db->get('zhl_gen_vw_mst_item_price');
        return $result->result();
    }

    function tampil_item_price_where($supp, $item)
    {
        $this->db->where('supplierid', $supp);
        $this->db->where('itemid', $item);

        $result =  $this->db->get('zhl_gen_vw_mst_item_price');
        return $result->result();
    }

    function simpan_item_price($datahdr)
    {
        $this->db->trans_begin();
        $cur       = $this->input->post('cur');
        $item      = $this->input->post('ItemID');
        $itemname  = $this->input->post('ItemName');
        $qty       = $this->input->post('Qty');
        $unitprice = $this->input->post('UnitPrice');
        $jml       = count($item);

        $this->db->where('supplierid', $datahdr['supplierid']);
        $sql = $this->db->get('zhl_gen_tbl_mst_item_price_hdr');

        if ($sql->num_rows() == 0) {
            $this->db->insert('zhl_gen_tbl_mst_item_price_hdr', $datahdr);
        }

        for ($i = 0; $i < $jml; $i++) {
            $this->db->where('supplierid', $datahdr['supplierid']);
            $this->db->where('itemid', $item[$i]);
            $sql = $this->db->get('zhl_gen_tbl_mst_item_price_dtl');

            if ($sql->num_rows() == 0) {
                $datadtl = array(
                    'supplierid'  => $datahdr['supplierid'],
                    'itemid'      => $item[$i],
                    'itemname'    => $itemname[$i],
                    'qnty'        => $qty[$i],
                    'unitprice'   => $unitprice[$i],
                    'currencyid'  => $cur,
                    'createdby'   => strtoupper($this->session->userdata('userid_1')),
                    'createddate' => date('Y-m-d H:i:s')
                );
                $this->db->insert('zhl_gen_tbl_mst_item_price_dtl', $datadtl);
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

    function update_item_price()
    {
        $this->db->trans_begin();
        $vendorid  = trim($this->input->post('vendorid'));
        $cur       = $this->input->post('cur');
        $item      = $this->input->post('ItemID');
        $itemname  = $this->input->post('ItemName');
        $qty       = $this->input->post('Qty');
        $unitprice = $this->input->post('UnitPrice');
        $jml       = count($item);

        for ($i = 0; $i < $jml; $i++) {
            $datadtl = array(
                'itemname'    => $itemname[$i],
                'qnty'        => $qty[$i],
                'unitprice'   => $unitprice[$i],
                'currencyid'  => $cur,
                'createdby'   => strtoupper($this->session->userdata('userid_1')),
                'createddate' => date('Y-m-d H:i:s')
            );
            $this->db->where('supplierid', $vendorid);
            $this->db->where('itemid', $item[$i]);
            $this->db->update('zhl_gen_tbl_mst_item_price_dtl', $datadtl);
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

    function delete_item_price($supp, $item)
    {
        $this->db->where('supplierid', $supp);
        $sql = $this->db->get('zhl_gen_tbl_mst_item_price_dtl');

        if ($sql->num_rows() <= 1) {
            $this->db->where('supplierid', $supp);
            $this->db->delete('zhl_gen_tbl_mst_item_price_hdr');
        }

        $this->db->where('supplierid', $supp);
        $this->db->where('itemid', $item);
        $this->db->delete('zhl_gen_tbl_mst_item_price_dtl');

        return true;
    }

    //--------------------------------------------------------ABOUT ITEM PRICE PUR-----------------------------------------------------------------------
    function tampil_item_price_limit_pur()
    {
        $this->db->order_by('vendorid');
        $this->db->limit(50);
        $result =  $this->db->get('zhl_pur_vw_mst_item_price');
        return $result->result();
    }

    function tampil_item_price_pur($data)
    {
        $query = "vendorid like '%" . $data . "%' or vendorcompany like '%" . $data . "%' or itemid like '%" . $data . "%' or itemname like '%" . $data . "%'";

        $this->db->where($query);
        $this->db->order_by('vendorid');

        $result =  $this->db->get('zhl_gen_vw_mst_item_price');
        return $result->result();
    }

    function simpan_item_price_pur($datahdr)
    {
        $this->db->trans_begin();
        $cur       = $this->input->post('cur');
        $item      = $this->input->post('ItemID');
        $itemname  = $this->input->post('ItemName');
        $qty       = $this->input->post('Qty');
        $unitprice = $this->input->post('UnitPrice');
        $jml       = count($item);

        $this->db->where('vendorid', $datahdr['vendorid']);
        $sql = $this->db->get('zhl_pur_tbl_mst_item_price_hdr');

        if ($sql->num_rows() == 0) {
            $this->db->insert('zhl_pur_tbl_mst_item_price_hdr', $datahdr);
            $pricehdrid = $this->db->insert_id();
        }

        for ($i = 0; $i < $jml; $i++) {
            $this->db->where('vendorid', $datahdr['vendorid']);
            $this->db->where('itemid', $item[$i]);
            $sql = $this->db->get('zhl_pur_tbl_mst_item_price_dtl');

            if ($sql->num_rows() == 0) {
                $datadtl = array(
                    'vendorid'  => $datahdr['vendorid'],
                    'pricehdrid'  => $pricehdrid,
                    'itemid'      => $item[$i],
                    'itemname'    => $itemname[$i],
                    'qnty'        => $qty[$i],
                    'unitprice'   => $unitprice[$i],
                    'currencyid'  => $cur,
                    'createdby'   => strtoupper($this->session->userdata('userid_1')),
                    'createddate' => date('Y-m-d H:i:s')
                );
                $this->db->insert('zhl_pur_tbl_mst_item_price_dtl', $datadtl);
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

    function update_item_price_pur()
    {
        $this->db->trans_begin();
        $vendorid  = trim($this->input->post('vendorid'));
        $cur       = $this->input->post('cur');
        $item      = $this->input->post('ItemID');
        $itemname  = $this->input->post('ItemName');
        $qty       = $this->input->post('Qty');
        $unitprice = $this->input->post('UnitPrice');
        $jml       = count($item);

        for ($i = 0; $i < $jml; $i++) {
            $datadtl = array(
                'itemname'    => $itemname[$i],
                'qnty'        => $qty[$i],
                'unitprice'   => $unitprice[$i],
                'currencyid'  => $cur,
                'createdby'   => strtoupper($this->session->userdata('userid_1')),
                'createddate' => date('Y-m-d H:i:s')
            );
            $this->db->where('vendorid', $vendorid);
            $this->db->where('itemid', $item[$i]);
            $this->db->update('zhl_pur_tbl_mst_item_price_dtl', $datadtl);
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

    function tampil_item_price_pur_where($pricehdrid, $item)
    {
        $this->db->where('pricehdrid', $pricehdrid);
        $this->db->where('itemid', $item);

        $result =  $this->db->get('zhl_pur_vw_mst_item_price');
        return $result->result();
    }

    function delete_item_price_pur($price, $item)
    {
        $this->db->where('pricehdrid', $price);
        $sql = $this->db->get('zhl_pur_tbl_mst_item_price_dtl');

        if ($sql->num_rows() <= 1) {
            $this->db->where('pricehdrid', $price);
            $this->db->delete('zhl_pur_tbl_mst_item_price_hdr');
        }

        $this->db->where('pricehdrid', $price);
        $this->db->where('itemid', $item);
        $this->db->delete('zhl_pur_tbl_mst_item_price_dtl');

        return true;
    }




    //--------------------------------------------------------ABOUT PPH----------------------------------------------------------------------
    function tampil_pph_temp()
    {
        $result = $this->db->get('zhl_pur_tbl_trn_pph');
        return $result->result();
    }

    function tampil_pph_temp_search($from, $to, $pph, $item)
    {
        $result = $this->db->get('zhl_pur_tbl_trn_pph');
        return $result->result();
    }

    function cek_pph($pphno, $Item)
    {
        $this->db->where('pphno', $pphno);
        $this->db->where('itemid', $Item);

        $sql =  $this->db->get('zhl_pur_tbl_trn_pph');
        if ($sql->num_rows() > 0) {
            $result = 1;
        } else {
            $result = 0;
        }
        return $result;
    }
    function simpan_pph()
    {
        $this->db->trans_begin();
        $chk         = $this->input->post('chk');
        $TransDate   = $this->input->post('TransDate');
        $PPHNo       = $this->input->post('PPHNo');
        $ItemID      = $this->input->post('ItemID');
        $ItemName    = $this->input->post('ItemName');
        $Qnty        = $this->input->post('Qnty');
        $PurchaseUOM = $this->input->post('PurchaseUOM');
        $Remark      = $this->input->post('Remark');

        foreach ($chk as $i) {
            $data = array(
                'pphno'       => $PPHNo[$i],
                'transdate'   => date("Y-m-d", strtotime($TransDate[$i])),
                'itemid'      => $ItemID[$i],
                'itemname'    => $ItemName[$i],
                'qnty'        => $Qnty[$i],
                'uom'         => $PurchaseUOM[$i],
                'remark'      => $Remark[$i],
                'companyid'   => 1,
                'createdby'   => strtoupper($this->session->userdata('userid')),
                'createddate' => date('Y-m-d H:i:s')
            );

            $this->db->insert('zhl_pur_tbl_trn_pph', $data);
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

    //----------------------------------------------------------ABOUT SAVE----------------------------------------------------------
    function cek($table, $where)
    {
        $this->db->where($where);

        $sql =  $this->db->get($table);
        if ($sql->num_rows() > 0) {
            $result = 1;
        } else {
            $result = 0;
        }
        return $result;
    }
    function cek_pur($table, $where)
    {
        $this->db->where($where);

        $sql =  $this->db->get($table);
        if ($sql->num_rows() > 0) {
            $result = 1;
        } else {
            $result = 0;
        }
        return $result;
    }

    function simpan_hdr($table, $data)
    {
        $this->db->trans_start();
        $this->db->insert($table, $data);
        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }

    function simpan_dtl($table, $field, $key, $data)
    {
        $this->db->trans_start();
        $this->db->insert($table, $data);
        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            $this->delete_hdr($table, $field, $key);
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }

    function simpan_dtl_ver2($table, $data)
    {
        $this->db->trans_start();
        $this->db->insert($table, $data);
        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }

    function update_dtl_ver2($table, $field1, $field2, $key1, $key2, $data)
    {
        $this->db->trans_start();
        $this->db->where($field1, $key1);
        $this->db->where($field2, $key2);
        $this->db->update($table, $data);
        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }

    function delete_hdr($table, $field, $key)
    {
        $this->db->where($field, $key);
        $this->db->delete($table);
    }
    //-----------------------------------------------EXTRA----------------------------------------------------------------

    function tampil_po_rate($cur, $date)
    {
        $awalTanggal = date('d', strtotime($date));
        $awalAkhir   = date('01', strtotime($date));
        $tempdate    = date('Y-m-01', strtotime($date));
        // $newdate = date('Y-m-01', strtotime("-1 months", strtotime($tempdate)));
        $newdate = $tempdate;

        if ($awalTanggal == $awalAkhir) {
            $query = " currency_id = '" . $cur . "' and periode = '" . $date . "'";
        } else {
            $query = " currency_id = '" . $cur . "' and periode BETWEEN '" . $newdate . "' AND '" . $date . "'";
        }

        $this->db->select('rate_usd');
        $this->db->select('rate_kurs');
        $this->db->where($query);
        $this->db->order_by('periode desc');
        $this->db->limit(1);

        $result = $this->db->get('zhl_acc_tbl_trn_kurs');
        return $result->row();
    }

    function tampil_country()
    {
        $result =  $this->db->get('zhl_gen_tbl_mst_country');
        return $result->result();
    }

    function tampil_country_where($data)
    {
        $this->db->where('country_id', $data);
        $result =  $this->db->get('zhl_gen_tbl_mst_country');
        return $result->row();
    }

    function tampil_trade()
    {
        $this->db->where('not_active', 0);
        $result =  $this->db->get('zhl_pur_tblmst_trading_term');
        return $result->result();
    }

    function tampil_coa($data)
    {
        if ($data == 'Sales') {
            $query = "AccountName like '" . $data . "%' or AccountName like 'Service%'";
        } else {
            $query = "AccountName like '" . $data . "%'";
        }
        $this->db->where($query);
        $result =  $this->db->get('zhl_acc_master_coa');
        return $result->result();
    }

    function tampil_user()
    {
        $this->db->where('approval = 1');
        $result =  $this->db->get('gen_tbl_user');
        return $result->result();
    }

    //=================== Tambahan Ikbal
    function update_item_banyak($data_dtl, $itemid)
    {
        $this->db->where('itemid', $itemid);
        $this->db->update('gen_tbl_mst_item', $data_dtl);
        return true;
    }

    // Purchasing NPBB
    function get_items($id)
    {
        $this->db->where('itemid', $id);
        $sql = $this->db->get('zhl_gen_vw_mst_item');
        return $sql->row();
    }

    // tambahan Fandy
    function get_itemsall()
    {
        return $this->db->query("SELECT itemid FROM gen_tbl_mst_item where notactive = 0 order by itemid ")->result();
    }

    function get_item_peruser($id)
    {
        $sql = "SELECT D.itemid, D.itemname, D.pmcode, D.per1000, D.hscode, D.country_id, E.country_name, F.uomname FROM gen_tbl_mst_item_user AS A 
                                    LEFT JOIN zhl_gen_tbl_mst_item_category AS B ON A.CategoryItem = B.categoryid
                                    LEFT JOIN zhl_gen_tbl_mst_item_category_sub AS  C ON B.categoryid = C.categoryid
                                    LEFT JOIN gen_tbl_mst_item AS D ON C.categorysubid = D.Categorysubid
                                    LEFT JOIN zhl_gen_tbl_mst_country AS E ON D.country_id = E.country_id
                                    LEFT JOIN zhl_gen_tbl_mst_item_uom As F ON D.uomid = F.uomid
                                    WHERE A.UserId = '$id' AND D.notactive = 0";
        // echo $sql;
        return $this->db->query($sql)->result();
    }

    // tambahan Fandy 29052019
    function get_po($po, $items)
    {
        if (empty($po)) {
            $query = "";
        } else {
            $query = " AND a.mainpo like '%$po%' ";
        }

        if (empty($items)) {
            $query2 = "";
        } else {
            $query2 = " AND b.itemid like '%$items%' OR b.itemname like '%$items%' ";
        }
        $sql = "SELECT a.mainpo, a.vendorcompany, a.custcompany, b.itemid, b.itemname, IFNULL(c.jumlah_doc,0) as jlh_doc  FROM pur_tbl_trn_po_hdr a 
                LEFT JOIN pur_tbl_trn_po_dtl b ON a.mainpo = b.mainpo
                LEFT JOIN (SELECT count(id) as jumlah_doc, po, product FROM pur_tbl_trn_document_share GROUP BY po, product) c ON (a.mainpo = c.po AND b.itemid = c.product)
                where docdate > '2019-01-01' " . $query . " " . $query2 . "
                GROUP BY mainpo, itemid 
                ORDER BY mainpo DESC LIMIT 20";

        echo $sql;

        return $this->db->query($sql)->result();
    }

    function get_factory($id)
    {
        // echo "SELECT factory_id FROM gen_tbl_utl_factory_access where user_group_id = $id";
        return $this->db->query("SELECT factory_id FROM gen_tbl_utl_factory_access where user_group_id = $id")->result();
    }


    // tambhan 15062019

    function save_file($data)
    {
        $this->db->insert('pur_tbl_trn_document_share', $data);
    }

    function save_file_item($data)
    {
        $this->db->insert('pur_tbl_trn_document_item', $data);
    }

    function get_docs($po, $item)
    {
        $sql = "SELECT * FROM pur_tbl_trn_document_share WHERE po = '$po' AND product = '$item'";
        return $this->db->query($sql)->result();
    }

    function get_itemssub($id)
    {
        $sql = "SELECT * FROM zhl_gen_tbl_mst_item where categorysubid = '$id'";
        return $this->db->query($sql)->result();
    }

    function get_itemupload($id)
    {
        $sql = "SELECT * FROM pur_tbl_trn_document_item WHERE itemid = '$id' ORDER BY RevisiKe DESC";
        return $this->db->query($sql)->result();
    }

    function document_monitor($query)
    {
        $id = $this->session->userdata('userid');
        $sql = " SELECT * FROM vw_pur_document_share WHERE custid in (SELECT C.factory_abbr FROM gen_tbl_user A LEFT JOIN gen_tbl_utl_factory_access B ON A.groupid = B.user_group_id LEFT JOIN gen_tbl_mst_factory C on B.factory_id = C.factory_id WHERE A.userid =  '$id') " . $query;
        // echo $sql;
        return $this->db->query($sql)->result();
    }

    function document_item_monitor($item, $cat, $subcat)
    {
        $query1 = "";
        if ($cat != "" || $cat != null)
            $query1 = " categoryid = $cat ";

        if ($subcat != "" || $subcat != null) {
            if ($query1 == "")
                $query1 = " categorysubid = $subcat ";
            else
                $query1 = $query1 . " AND categorysubid = $subcat ";
        }

        if ($item != "" || $item != null) {
            if ($query1 == "")
                $query1 = " itemid like '%$item%' OR itemname like '%item%' ";
            else
                $query1 = $query1 . " AND itemid like '%$item%' OR itemname like '%item%' ";
        }

        if ($query1 != "")
            $query1 = " WHERE " . $query1;

        $query = " SELECT * FROM vw_pur_document_item $query1 ORDER BY itemname, RevisiKe DESC";

        // echo $query;
        return $this->db->query($query)->result();
    }

    // tambahan 02082019
    function cariitem($id)
    {
        if (!empty($id)) {
            $query = "SELECT * FROM zhl_gen_tbl_mst_item where categorysubid = 7 AND itemid like '%$id%' or itemname like '%$id%' ";
        } else {
            $query = "SELECT * FROM zhl_gen_tbl_mst_item where categorysubid = 7  limit 100";
        }

        return $this->db->query($query)->result();
    }

    function save_header_share($data)
    {
        $this->db->insert('pur_tbl_trn_document_share_hdr', $data);
        $insert_id = $this->db->insert_id();

        return  $insert_id;
    }

    function save_header_share2($id, $data)
    {
        $this->db->where('maker', $id);
        $q = $this->db->get('pur_tbl_trn_document_share_hdr');

        if ($q->num_rows() == 0) {
            $this->db->insert('pur_tbl_trn_document_share_hdr', $data);
        }
    }

    function update_header_share($data, $id)
    {
        $this->db->where('id', $id);
        $this->db->update('pur_tbl_trn_document_share_hdr', $data);
    }

    function save_detail_share_maker($data)
    {
        $this->db->insert('pur_tbl_trn_document_share_dtl_maker', $data);
    }

    function save_detail_share_item($data)
    {
        $this->db->insert('pur_tbl_trn_document_share_dtl_item', $data);
    }

    function get_datashare()
    {
        return $this->db->query("SELECT * FROM pur_tbl_trn_document_share_hdr ")->result();
    }

    function get_dataitem()
    {
        return $this->db->query("SELECT DISTINCT(itemid), itemname from pur_tbl_trn_document_share_dtl_item")->result();
    }

    function get_datashare_hdr($id)
    {
        return $this->db->query("SELECT * FROM pur_tbl_trn_document_share_hdr WHERE id = $id")->row();
    }

    function get_datashare_dtlitem($id)
    {
        return $this->db->query("SELECT * FROM pur_tbl_trn_document_share_dtl_item where hdr_id = '$id'")->result();
    }

    function get_datashare_dtlitem_mon($id)
    {
        if ($id != '') {
            return $this->db->query("SELECT * FROM pur_tbl_trn_document_share_dtl_item where itemid = '$id'")->result();
        } else {
            return $this->db->query("SELECT * FROM pur_tbl_trn_document_share_dtl_item")->result();
        }
    }

    function get_datashare_id_dtlitem($id)
    {
        return $this->db->query("SELECT * FROM pur_tbl_trn_document_share_dtl_item where id = '$id'")->result();
    }

    function get_datashare_dtlmaker($id)
    {
        return $this->db->query("SELECT * FROM pur_tbl_trn_document_share_dtl_maker where hdr_id = '$id' ")->result();
    }

    function get_datashare_dtlmaker_mon($id)
    {
        if ($id != '') {
            return $this->db->query("SELECT * FROM pur_tbl_trn_document_share_dtl_maker where hdr_id = '$id' ")->result();
        } else {
            return $this->db->query("SELECT * FROM pur_tbl_trn_document_share_dtl_maker")->result();
        }
    }

    function get_datashare_id_dtlmaker($id)
    {
        return $this->db->query("SELECT * FROM pur_tbl_trn_document_share_dtl_maker where id = '$id' ")->result();
    }

    function deletemakershare($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('pur_tbl_trn_document_share_dtl_maker');
    }

    function deleteitemshare($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('pur_tbl_trn_document_share_dtl_item');
    }

    function editname($id, $name, $data)
    {
        $query = "UPDATE pur_tbl_trn_document_share_hdr SET maker = '$name' WHERE id = $id";
        $this->db->query($query);

        $this->db->insert('pur_tbl_trn_document_share_hdr_history_name', $data);
    }

    // 07082019
    function hapusitemartwork($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('pur_tbl_trn_document_item');
    }

    function Update_remark_maker($data, $id)
    {
        $this->db->where('id', $id);
        $this->db->update('pur_tbl_trn_document_share_dtl_maker', $data);
        return true;
    }

    function Update_remark_item($data, $id)
    {
        $this->db->where('id', $id);
        $this->db->update('pur_tbl_trn_document_share_dtl_item', $data);
        return true;
    }
}
