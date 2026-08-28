<?php

/**
 * Created by PhpStorm.
 * User: Reza Irhami
 * Date: 11/11/2016
 * Time: 2:34 PM
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class M_Sales_Report extends CI_Model
{
  //   function call_Sales_Report($p_dari, $p_sampai, $customer){
		// $this->db->select('custcompany,custid, product_category_id'); 
  //       $this->db->where("docdate between '$p_dari' and '$p_sampai' and custid like '%$customer%'");
  //       $this->db->group_by("custcompany");
  //       $sql_product = $this->db->get('ship_vw_trn_sales_report_tes');

  //       if($sql_product->num_rows() >0){
  //           foreach ($sql_product->result() as $data) {
  //               $hasil[] = $data;
  //           }
  //           return $hasil;
  //       }
  //   }

    function call_Sales_Report($p_dari, $p_sampai, $customer){
        $this->db->select('custcompany,custid, product_category_id, sales_id'); 
        $this->db->where("docdate between '$p_dari' and '$p_sampai' and custid like '%$customer%'");
        $this->db->group_by("custcompany");
        $sql_product = $this->db->get('zhl_vw_customer_sales_report2');

        if($sql_product->num_rows() >0){
            foreach ($sql_product->result() as $data) {
                $hasil[] = $data;
            }
            return $hasil;
        }
    }

     function call_by_product_id($productid, $customerid){
        $dari = str_replace('/', '-', $this->input->get('dari'));
        $p_dari = date('Y-m-d', strtotime($dari));

        $sampai     = str_replace('/', '-', $this->input->get("sampai"));
        $p_sampai   = date('Y-m-d', strtotime($sampai));

        $this->db->select('sum(tot_qty) as tot_qty,sum(tot_usd) as tot_usd,sum(tot_usd)/sum(tot_qty) as tot_unitprice,product_category_id'); 
        $this->db->where("docdate between '$p_dari' and '$p_sampai' and  custid = '$customerid' and product_category_id = '$productid'");
        $this->db->group_by("custid,product_category_id");
        $sql_product = $this->db->get('zhl_ship_vw_trn_sales_report_tes');
        return $sql_product->row();
    }


    function call_by_product_total($customerid){
        $this->db->select('sum(tot_qty) as qty_total, sum(tot_usd) as usd_total , sum(tot_usd)/sum(tot_qty) as unitprice_total, custid'); 
        $this->db->where("custid = '$customerid'");
        $this->db->group_by("custid");
        $sql_product = $this->db->get('zhl_ship_vw_trn_sales_report_tes');
        return $sql_product->row();
    }

    function call_by_product_grand_total($p_dari, $p_sampai, $product){
        $this->db->select('sum(tot_qty) as qty_total, sum(tot_usd) as usd_total , sum(tot_usd)/sum(tot_qty) as unitprice_total, product_category_id'); 
        $this->db->where("docdate between '$p_dari' and '$p_sampai' and product_category_id = '$product'");
        $this->db->group_by("product_category_id");
        $sql_product = $this->db->get('zhl_ship_vw_trn_sales_report_tes');
        return $sql_product->row();
    }

    function call_Sales_Report_detail($p_dari, $p_sampai, $customer){
        if(!empty($customer)){
            $c = " and custid = '$customer' ";
        }
        else
        {
            $c = "";
        }
        $this->db->select('invno,custcompany,product_category_name,tot_qty,tot_usd,(tot_usd) / (tot_qty) as tot_unitprice'); 
        $this->db->where("docdate between '$p_dari' and '$p_sampai' $c ");
        $sql_product = $this->db->get('zhl_ship_vw_trn_sales_report_tes');

        if($sql_product->num_rows() >0){
            foreach ($sql_product->result() as $data) {
                $hasil[] = $data;
            }
            return $hasil;
        }
    }


    function product_category(){
    	$this->db->select('product_category_id ,product_category_name'); 
        $sql_product = $this->db->get('zhl_mar_tblmst_product_category');
        if($sql_product->num_rows() >0){
            foreach ($sql_product->result() as $data) {
                $hasil[] = $data;
            }
            return $hasil;
        }
    }

    function get_customer(){
        $this->db->select('customer_id, customer_code, customer_name');
        $this->db->from('zhl_mar_tblmst_customer');
       $sql = $this->db->get();
        if ($sql->num_rows() > 0) {
            $result[''] = "Select";
            foreach ($sql->result_array() as $row) {
                $result[$row['customer_code']] = ucwords(strtolower($row['customer_name']));
            }
            return $result;
        }
        else{
            echo "";
        }
    }

    function get_group_cust($p_dari, $p_sampai, $customer) {
        if(!empty($customer)){
            $c = " and custid = '$customer' ";
        }
        else
        {
            $c = "";
        }
        $sql = $this->db->query("SELECT DISTINCT custcompany FROM zhl_ship_vw_trn_inv where createddate between '$p_dari' and '$p_sampai' $c ");
        return $sql->result();
    } 


}