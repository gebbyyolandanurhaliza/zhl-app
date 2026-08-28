<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_shipping_mon extends CI_Model{
//-----------------------------------------------------------ABOUT Mon Shipping Line-------------------------------------------------------------------
    function tampil_shipping_liner_filter($tipe,$shipdate,$factory,$ref,$cont,$seal,$ves, $shipmonth){
        $sql="tipe = '".$tipe."'";
    
        if(trim($shipdate) != ''){$sql=$sql." and shipmentdate= '".$shipdate."' ";}
        if(trim($shipmonth) != ''){
            $date1 =date("Y-m-01", strtotime($shipmonth));
            $date2 =date("Y-m-t", strtotime($shipmonth));
            $sql=$sql." and shipmentdate between  '".$date1."' and '".$date2."'";
        }
        if(trim($factory) != ''){$sql=$sql." and factory_id= '".$factory."'";}
        if(trim($ref) != '') {$sql=$sql." and reff like '%".$ref."%'";}
        if(trim($cont) != ''){$sql=$sql." and container like '%".$cont."%'";}
        if(trim($seal) != ''){$sql=$sql." and actual_seal like '%".$seal."%'";}
        if(trim($ves) !='' ){$sql=$sql." and  vessel like '%".$ves."%'";} 

        $this->db->where($sql);
        $this->db->order_by('shipmentdate');
        $this->db->order_by('urut');
        
        $result=$this->db->get('zhl_ship_vw_trn_cont');
        return $result->result();
    }

     function tampil_shipping_liner_filter_ggfs($tipe,$shipdate,$factory,$ref,$cont,$seal,$ves, $shipmonth){
        $sql="tipe = '".$tipe."'";
    
        if(trim($shipdate) != ''){$sql=$sql." and shipmentdate= '".$shipdate."' ";}
        if(trim($shipmonth) != ''){
            $date1 =date("Y-m-01", strtotime($shipmonth));
            $date2 =date("Y-m-t", strtotime($shipmonth));
            $sql=$sql." and shipmentdate between  '".$date1."' and '".$date2."'";
        }
        if(trim($factory) != ''){$sql=$sql." and factory_id= '".$factory."'";}
        if(trim($ref) != '') {$sql=$sql." and reff like '%".$ref."%'";}
        if(trim($cont) != ''){$sql=$sql." and container like '%".$cont."%'";}
        if(trim($seal) != ''){$sql=$sql." and actual_seal like '%".$seal."%'";}
        if(trim($ves) !='' ){$sql=$sql." and  vessel like '%".$ves."%'";} 

        $this->db->where($sql);
        $this->db->order_by('shipmentdate');
        $this->db->order_by('urut');
        
        $result=$this->db->get('zhl_ship_vw_trn_cont_ggfs');
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
        $result=$this->db->get('zhl_ship_vw_trn_cont_stock_mon');
        return $result->result();
    }
    

    function tampil_cont_where_brand($shipdate,$factory,$ves, $shipmonth){
        $sql="factory_id = '".$factory."'";
        if(trim($shipdate) != ''){$sql=$sql." and shipmentdate= '".$shipdate."' ";}
        if(trim($shipmonth) != ''){
            $date1 =date("Y-m-01", strtotime($shipmonth));
            $date2 =date("Y-m-t", strtotime($shipmonth));
            $sql=$sql." and shipmentdate between  '".$date1."' and '".$date2."'";
        }
        $this->db->where($sql);
        $this->db->like('vessel',$ves);
        $this->db->order_by('shipmentdate');
        $this->db->order_by('urut');
        
        $result=$this->db->get('zhl_ship_vw_summary_report');
        
        return $result;
    }

    function tampil_cont_where_brand_ggfs($shipdate,$factory,$ves, $shipmonth){
        $sql="factory_id = '".$factory."'";
        if(trim($shipdate) != ''){$sql=$sql." and shipmentdate= '".$shipdate."' ";}
        if(trim($shipmonth) != ''){
            $date1 =date("Y-m-01", strtotime($shipmonth));
            $date2 =date("Y-m-t", strtotime($shipmonth));
            $sql=$sql." and shipmentdate between  '".$date1."' and '".$date2."'";
        }
        $this->db->where($sql);
        $this->db->like('vessel',$ves);
        $this->db->order_by('shipmentdate');
        $this->db->order_by('urut');
        
        $result=$this->db->get('zhl_ship_vw_summary_report_ggfs');
        
        return $result;
    }

    function tampil_cont_where_inward($shipdate,$factory, $shipmonth){
        $sql="factory_id = '".$factory."' and tipe=2";
        if(trim($shipdate) != ''){$sql=$sql." and shipmentdate= '".$shipdate."' ";}
        if(trim($shipmonth) != ''){
            $date1 =date("Y-m-01", strtotime($shipmonth));
            $date2 =date("Y-m-t", strtotime($shipmonth));
            $sql=$sql." and shipmentdate between  '".$date1."' and '".$date2."'";
        }
        $this->db->where($sql);
        $this->db->order_by('shipmentdate');
        $this->db->order_by('urut');
        
        $result=$this->db->get('zhl_ship_vw_trn_cont');
        
        return $result;
    }

    function tampil_cont_where_inward_ggfs($shipdate,$factory, $shipmonth){
        $sql="factory_id = '".$factory."' and tipe=2";
        if(trim($shipdate) != ''){$sql=$sql." and shipmentdate= '".$shipdate."' ";}
        if(trim($shipmonth) != ''){
            $date1 =date("Y-m-01", strtotime($shipmonth));
            $date2 =date("Y-m-t", strtotime($shipmonth));
            $sql=$sql." and shipmentdate between  '".$date1."' and '".$date2."'";
        }
        $this->db->where($sql);
        $this->db->order_by('shipmentdate');
        $this->db->order_by('urut');
        
        $result=$this->db->get('zhl_ship_vw_trn_cont_ggfs');
        
        return $result;
    }

    function tampil_cont($shipdate,$factory,$ves,$shipmonth){
        $sql="factory_id = '".$factory."' ";
        if(trim($shipdate) != ''){$sql=$sql." and shipmentdate= '".$shipdate."' ";}
        if(trim($shipmonth) != ''){
            $date1 =date("Y-m-01", strtotime($shipmonth));
            $date2 =date("Y-m-t", strtotime($shipmonth));
            $sql=$sql." and shipmentdate between  '".$date1."' and '".$date2."'";
        }
        $this->db->where($sql);
        $this->db->like('vessel',$ves);
        $this->db->order_by('shipmentdate');
        $this->db->order_by('urut');
        
        $result=$this->db->get('zhl_ship_vw_trn_cont');
        
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

    function get_year_lifting(){
        $result=$this->db->query('select DISTINCT year(shipmentdate) as tahun from ship_vw_trn_cont ORDER BY shipmentdate DESC');
        return $result->result();
    }
    
    function tampil_lifting_volume($tahun,$cont){
        if($cont == '20ft'){
            $sql = $this->db->query("call lifting_20ft_standard ('".$tahun."')");
        }elseif($cont == '20ftrf'){
            $sql = $this->db->query("call lifting_20ft_reefer ('".$tahun."')");
        }elseif($cont == '40ft'){
            $sql = $this->db->query("call lifting_40ft_standard ('".$tahun."')");
        }elseif($cont == '40ftrf'){
            $sql = $this->db->query("call lifting_40ft_reefer ('".$tahun."')");
        }elseif($cont == '40fthq'){
            $sql = $this->db->query("call lifting_40ft_high_cube ('".$tahun."')");
        }elseif ($cont == '40fthqrf'){
            $sql = $this->db->query("call lifting_40ft_high_cube_reefer ('".$tahun."')");
        }

        $result=$sql->result();
        $sql->next_result();
        $sql->free_result();
        return $result;
    }

    function tampil_lifting_volume_new($tahun, $cont, $fact){
        $sql = $this->db->query("call zhl_lifting_volume_new($tahun, $cont, $fact)");
        $result=$sql->result();
        $sql->next_result();
        $sql->free_result();
        return $result;
    }    
    
    function tampil_container($cont){
        $this->db->where('container_id',$cont);
        return $this->db->get('mar_tblmst_container')->result();
    }

    function tampil_expired_license($coe_expiry, $lifespan_expiry, $vpc_expiry)
    {
        $this->db->select('*');
        $this->db->from('zhl_tims_mst_vehicle');
        if($coe_expiry !== "1970-01-01"){
            $this->db->where('coe_expiry_date >=', $coe_expiry);
        }

        if($lifespan_expiry !== "1970-01-01"){
            $this->db->where('lifespan_expiry_date >=', $lifespan_expiry);
        }

        if($vpc_expiry !== "1970-01-01"){
            $this->db->where('vpc_end_date >=', $vpc_expiry);
        }
        $this->db->order_by('vpc_end_date', 'DESC');
        $this->db->order_by('coe_expiry_date', 'DESC');
        $result = $this->db->get();
        return $result->result();
    }

    
}

