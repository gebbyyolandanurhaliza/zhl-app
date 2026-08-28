<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_shipping_mon extends CI_Model{
//-----------------------------------------------------------ABOUT Mon Shipping Line-------------------------------------------------------------------
    function tampil_shipping_liner_filter($tipe,$shipdate,$factory,$ref,$cont,$seal){
        $sql="tipe = '".$tipe."'";
    
        if(trim($shipdate) != ''){$sql=$sql." and shipmentdate= '".$shipdate."' ";}
        if(trim($factory) != ''){$sql=$sql." and factory_id= '".$factory."'";}
        if(trim($ref) != ''){$sql=$sql." and reff like '%".$ref."%'";}
        if(trim($cont) != ''){$sql=$sql." and container like '%".$cont."%'";}
        if(trim($seal) != ''){$sql=$sql." and seal like '%".$seal."%'";}
        
        $this->db->where($sql);
        $this->db->order_by('urut');
        
        $result=$this->db->get('zhl_ship_vw_trn_cont');
        return $result->result();
    }

    //function tampil_container_stock_filter($tipe,$shipdate,$factory,$ref,$cont,$seal){
    function tampil_container_stock_filter($factory_tipe,$order_by,$dari,$sampai){        
        $sql="factory like '%".$factory_tipe."%'";
        $order_by="".$order_by."";    
        // // if(trim($shipdate) != ''){$sql=$sql." and shipmentdate= '".$shipdate."' ";}
        // // if(trim($factory) != ''){$sql=$sql." and factory_id= '".$factory."'";}
        // // if(trim($ref) != ''){$sql=$sql." and reff like '%".$ref."%'";}
        // // if(trim($cont) != ''){$sql=$sql." and container like '%".$cont."%'";}
        // // if(trim($seal) != ''){$sql=$sql." and seal like '%".$seal."%'";}
        $this->db->where('arrival_date between "' . date('Y-m-d', strtotime($dari)) . '" and "' . date('Y-m-d', strtotime($sampai)) . '"');
        $this->db->where($sql);
        // $this->db->order_by('arrival_date');
        
        // $result=$this->db->get('zhl_ship_vw_trn_cont_stock');
        // return $result->result();
        // $this->db->where('stock_id_hdr',$contid);
        $this->db->order_by($order_by, 'DESC');
        $result=$this->db->get('zhl_ship_vw_trn_cont_stock');
        return $result->result();
    }
    
    function tampil_cont_where_brand($shipdate,$factory){
        $this->db->where('shipmentdate',$shipdate);
        $this->db->where('factory_id',$factory);
        $this->db->order_by('urut');
        
        $result=$this->db->get('zhl_ship_vw_summary_report');
        
        return $result;
    }
    
//---------------------------------------------------------ABOUT Mon Sales Invoice-----------------------------------------------------------------------
    function tampil_inv_filter($from,$to,$cust,$invno,$po,$product){
        $query="docdate between '".$from."' and '".$to."'";
        if (trim($cust) != ""){$query= $query." and custid ='".$cust."'";}
        if (trim($invno) != ""){$query= $query." and invno like '%".$invno."%'";}
        if (trim($po) != ""){$query= $query." and ponumber like '%".$po."%'";}
        if (trim($product) != ""){$query= $query." and (productcode like '%".$product."%' or productname like '%".$product."%')";}
        
        $this->db->where($query);
        $this->db->order_by('invno');
        $result=  $this->db->get('zhl_ship_vw_trn_inv');
        return $result->result();
    }

    function print_inv_filter($from,$to,$cust,$invno,$po,$product){
        $query="docdate between '".$from."' and '".$to."' and status <> 3";
        if (trim($cust) != ""){$query= $query." and custid ='".$cust."'";}
        if (trim($invno) != ""){$query= $query." and invno like '%".$invno."%'";}
        if (trim($po) != ""){$query= $query." and ponumber like '%".$po."%'";}
        if (trim($product) != ""){$query= $query." and (productcode like '%".$product."%' or productname like '%".$product."%')";}
        
        $this->db->where($query);
        $this->db->order_by('invno');
        $result=  $this->db->get('zhl_ship_vw_trn_inv_mainpo');
        return $result->result();
    }
    
    function tampil_sales_list($date){
        $explode=explode("-", $date);
        $query="month(docdate) = '".$explode[0]."' and year(docdate)='".$explode[1]."'";
        $this->db->where($query);
        
        $result=$this->db->get('zhl_ship_vw_trn_inv_hdr_mainpo');
        return $result->result();
    }
    
    function tampil_total_sales($year){
        $sql = $this->db->query("call zhl_sp_ship_mon_total_sales ('".$year."')");
        $result=$sql->result();
        $sql->next_result();
        $sql->free_result();
        return $result;
    }
    
    function get_year(){
        $this->db->select('year(docdate) as year');
        $this->db->order_by('docdate');
        $this->db->limit(1);
        
        $result = $this->db->get('zhl_ship_tbl_trn_inv_hdr');
        
        return $result->row();
        
    }

    
}