<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_purchasing_zht extends CI_Model
{
    //--------------------------------------------------------ABOUT SUPPLIER---------------------------------------------------------------
    /* used for vendor in master */
    function tampil_supp($data)
    {
        $query = " (supplierid like '%" . $data . "%' or suppliercompany like '%" . $data . "%') ";
        $this->db->where($query);
        $this->db->where('notactive', '0');
        $result =  $this->db->get('zht_pur_tbl_mst_supplier_tims');
        return $result->result();
    }

    function tampil_supp_purchasing($data)
    {
        $query = " (supplierid like '%" . $data . "%' or suppliercompany like '%" . $data . "%') ";
        $this->db->where($query);
        $this->db->where('notactive', '0');
        $result =  $this->db->get('zht_pur_tbl_mst_supplier_tims');
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
        $this->db->select('supp.*,vengroup.group');
        $this->db->from('zht_pur_tbl_mst_supplier_tims as supp');
        $this->db->join('zht_pur_tbl_mst_vendor_group_tims as vengroup', 'supp.groupid=vengroup.id');
        $this->db->where('supp.notactive', '0');
        $this->db->order_by('createddate desc');
        $this->db->limit(50);
        $result = $this->db->get();
        return $result->result();
    }

    function tampil_supp_where($data)
    {
        $this->db->where('supplierid', $data);
        $result =  $this->db->get('zht_pur_tbl_mst_supplier_tims');
        return $result->row();
    }

    function newCheckSuppCode($vendorName)
    {
        $prefix = strtoupper(substr($vendorName, 0, 1));

        $query = $this->db->query("SELECT SUBSTRING(customer_code, 3) AS GEN FROM zht_mar_tblmst_customer WHERE customer_code LIKE 'S{$prefix}%' ORDER BY customer_code DESC LIMIT 1");

        if ($query->num_rows() > 0) {
            $get    = $query->row();
            $set    = $get->GEN;
        } else {
            $set    = 0;
        }

        $num    = intval($set);
        
        // var_dump($query);
        return $num + 1;
    }


    function simpan_vendor($data)
    {
        $this->db->insert('zht_pur_tbl_mst_supplier_tims', $data);
        return true;
    }

    function update_vendor($vendorid, $data, $user)
    {
        if ($user == 'WINNIE-YAU' || $user == 'FAUZI' || $user == 'PETER' || $user == 'DAVEN-SAW') {
            $this->db->where('supplierid', $vendorid);
            $sql = $this->db->get('zht_pur_tbl_mst_supplier_tims');
        } else {
            $this->db->where('createdby', $user);
            $this->db->where('supplierid', $vendorid);
            $sql = $this->db->get('zht_pur_tbl_mst_supplier_tims');
        }

        if ($sql->num_rows() > 0) {
            if ($user == 'WINNIE-YAU' || $user == 'FAUZI' || $user == 'PETER' || $user == 'DAVEN-SAW') {
                $this->db->where('supplierid', $vendorid);
                $this->db->update('zht_pur_tbl_mst_supplier_tims', $data);
            } else {
                $this->db->where('supplierid', $vendorid);
                $this->db->where('createdby', $user);
                $this->db->update('zht_pur_tbl_mst_supplier_tims', $data);
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
        $sql = $this->db->get('zht_pur_tbl_mst_supplier_tims');

        if ($sql->num_rows() > 0) {
            $this->db->where('supplierid', $vendorid);
            $this->db->update('zht_pur_tbl_mst_supplier_tims', array('notactive' => '1'));
            return true;
        } else {
            return false;
        }
    }

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

    //--------------------------------------------------------ABOUT VENDOR ACOUNTING---------------------------------------------------------------
    /* used for vendor in master */

    function tampil_supp_group()
    {
        $this->db->select('a.*,b.AccountName');
        $this->db->from('zht_pur_tbl_mst_vendor_group_tims a');
        $this->db->join('zhl_acc_master_new_coa b', 'b.NoCOA=a.nocoa', 'left outer');
        $this->db->where('a.notactive = 0');
        $result =  $this->db->get();
        return $result->result();
    }

    function simpan_vendor_group($data)
    {
        $this->db->insert('zht_pur_tbl_mst_vendor_group_tims', $data);
        return true;
    }

    function update_vendor_group($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update('zht_pur_tbl_mst_vendor_group_tims', $data);
        return true;
    }

    function delete_vendor_group($id)
    {
        $this->db->where('id', $id);
        $this->db->update('zht_pur_tbl_mst_vendor_group_tims', array('notactive' => '1'));
        return true;
    }

    function tampil_coa($data)
    {
        if ($data == 'Sales') {
            $query = "AccountName like '" . $data . "%' or AccountName like 'Service%'";
        } else {
            $query = "AccountName like '" . $data . "%'";
        }
        $this->db->where($query);
        $result =  $this->db->get('zhl_acc_master_new_coa');
        return $result->result();
    }
}
