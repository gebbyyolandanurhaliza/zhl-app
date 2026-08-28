<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_shipping_inv extends CI_Model{
//-----------------------------------------------------------ABOUT PO-------------------------------------------------------------------
    function tampil_inv($data){
        $query="(invno like '%".$data."%' or custid like '%".$data."%' or custcompany like '%".$data."%')";
        $this->db->where($query);
        $this->db->order_by('invno','desc');
       
        $result=$this->db->get('zhl_ship_vw_trn_inv_hdr_mainpo');
        return $result->result();
    }
    
    function tampil_inv_hdr($data){
        $query="(invno like '%".$data."%' or custid like '%".$data."%' or custcompany like '%".$data."%')";
        $this->db->where($query);
        
        $result=$this->db->get('zhl_ship_tbl_trn_inv_hdr');
        return $result->result();
    }
    
    function tampil_inv_where($data){
        $this->db->where('invno',$data);
        $this->db->order_by('urut');
        $result=$this->db->get('zhl_ship_vw_trn_inv');
        return $result->result();
    }
    
    function tampil_inv_where_dp($data){
        $this->db->select('b.no_reff,a.detail_id,a.bayar_inv,a.remarks');
        $this->db->from('zhl_ship_tbl_trn_inv_dp a');
        $this->db->join('zhl_fin_tbltrn_cashbank_journal_header b','b.header_id=a.detail_id');
        $this->db->where('a.invno',$data);
        
        $result=$this->db->get();
        return $result->result();
    }
    
    function tampil_inv_where_detail($data){
        $result=$this->db->query("Select shipid,urut,status,client_ref_no,productcode,detail_pack_size,uom_quantity_name,productname,sum(qty) as qty,unitprice,ponumber,sum(total) as total from zhl_ship_vw_trn_inv "
                . "where invno=".$data." group by shipid,urut,status,client_ref_no,productcode,detail_pack_size,uom_quantity_name,productname,unitprice,ponumber");
        return $result->result();
    }
    
    function tampil_inv_where_container($data){
        $this->db->where('invno',$data);
        $this->db->order_by('shipid');
        
        $result=$this->db->get('zhl_ship_vw_trn_inv_cont');
        return $result->result();
    }
    
    function tampil_inv_where_container_group($data){
        $this->db->select('count(container_name) as jml ,container_name');
        $this->db->where('invno',$data);
        $this->db->group_by('container_name');
                
        $result=$this->db->get('zhl_ship_vw_trn_inv_cont');
        return $result->result();
    }
    
    function tampil_inv_cost_where($data){
        $this->db->where('invno',$data);
        $this->db->order_by('id');
        
        $result=$this->db->get('zhl_ship_tbl_trn_inv_dtl_cost');
        return $result->result();
    }
    
    function tampil_inv_po($cust,$po){
        $query1="status_id <> 8 and customer_code='".$cust."' ";
        $query2="(po_number like '%".$po."%' or product_code like '%".$po."%' or product_name like '%".$po."%')";
        
        $this->db->from('zhl_ship_vw_trn_po');
        $this->db->where($query1);
        $this->db->where($query2);
        $this->db->order_by('po_number');

        $result=$this->db->get();
        return $result->result();
    }
   
    function delete_inv_sp($data){
        $this->db->trans_begin();
            $this->db->query("SET @flag = 0");
            $this->db->query("call zhl_sp_ship_tbl_trn_inv_del('".$data."',@flag)");
            $query1=  $this->db->query("Select @flag as flag")->row();

            $flag1=$query1->flag;
            
            if($flag1 == 0) {
                $this->db->trans_rollback();
                $data=array('flag'=>$flag1);
                return $data;
            }
        
        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $data=array('flag'=>$flag1);
            return $data;
        }else {
            $this->db->trans_commit();
            $data=array('flag'=>$flag1);
            return $data;
        }
        
    }
    
    function simpan_inv_sp($datahdr){
        $this->db->trans_begin();
            $contid_dtl=$this->input->post('contid_dtl');
            $poid=$this->input->post('PoID');
            $productid=$this->input->post('ProductID');
            $ProductName=$this->input->post('ProductName');
            $qty=$this->input->post('Qty');
            $unitprice=$this->input->post('UnitPrice');
            $total=$this->input->post('Total');
            $jml=count($contid_dtl);
            
            $detail_id=$this->input->post('detail_id');
            $bayar=$this->input->post('bayar');
            $dpremark=$this->input->post('dpremark');
            $jml2=count($detail_id);
            
            $addcost=$this->input->post('addcost');
            $price=$this->input->post('price');
            $coa=$this->input->post('coa_freight');
            $jml_cost=count($addcost);
            
            if($datahdr['trans'] == 'update'){
                $flag0=$this->cek_acc_piutang($datahdr['invno']);
                
                if($flag0 == 0) {
                    $this->db->trans_rollback();
                    $data=array('flag'=>$flag0);
                    return $data;
                }
            }
            
            $query1= $this->simpan_inv_sp_hdr($datahdr);
            $invno=$query1->invno;
            $flag1=$query1->flag;
            
            if($flag1 == 0) {
                $this->db->trans_rollback();
                $data=array('flag'=>$flag1);
                return $data;
            }
            
            $this->simpan_inv_sp_dtl_cost($invno, $addcost, $price,$coa,$datahdr['ipaddress'], $jml_cost);
             
            $query2=$this->simpan_inv_sp_dtl($invno,$contid_dtl,$poid,$productid,$ProductName,$qty,$unitprice,$total,$jml,$datahdr['createdby'],$datahdr['ipaddress']);
            $flag2=$query2->flag;
            
            if($flag2 == 0) {
                $this->db->trans_rollback();
                $data=array('flag'=>$flag2);
                return $data;
            }
            
            $query3=$this->simpan_inv_sp_dp($invno,$detail_id,$bayar,$dpremark,$jml2);
            $flag3=$query3->flag;
            
            if($flag3 == 0){
                $this->db->trans_rollback();
                $data=array('flag'=>$flag3);
                return $data;
            }
            
            
        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $data=array('flag'=>$flag2);
            return $data;
        }else {
            $this->db->trans_commit();
            $data=array('flag'=>$flag2,'invno'=>$invno);
            return $data;
        }
    }
    
    function simpan_inv_sp_hdr($datahdr){
        $this->db->query("SET @invno = '".$datahdr['invno']."'");
        $this->db->query("SET @flag = 0");
        $this->db->query("call zhl_sp_ship_tbl_trn_inv_hdr('".$datahdr['trans']."',@invno,'".$datahdr['custid']."','".htmlspecialchars($datahdr['custcompany'],ENT_QUOTES)."','".$datahdr['custcontact']."','".htmlspecialchars($$datahdr['custref'],ENT_QUOTES)."',"
        . "'".$datahdr['currency']."','".$datahdr['rate']."','".$datahdr['status']."','".$datahdr['postdate']."','".$datahdr['duedate']."','".$datahdr['docdate']."',"
        . "'".$datahdr['shipdate']."','".htmlspecialchars($datahdr['remark'],ENT_QUOTES)."','".$datahdr['total']."','".$datahdr['discount']."','".$datahdr['freight']."','".$datahdr['tax']."',"
        . "'".$datahdr['totaldue']."','".$datahdr['dp']."','".$datahdr['balance']."','".htmlspecialchars($datahdr['term'],ENT_QUOTES)."','".$datahdr['termdays']."','".htmlspecialchars($datahdr['paymentto'],ENT_QUOTES)."','".$datahdr['approval']."','".$datahdr['gst']."','".$datahdr['createdby']."',@flag,'".$datahdr['ipaddress']."')");
        $row=  $this->db->query("Select @invno as invno, @flag as flag")->row();

        return $row;
    }
    
    function simpan_inv_sp_dtl($invno,$contid_dtl,$poid,$productid,$ProductName,$qty,$unitprice,$total,$jml,$user,$ipaddress){
        for($i = 0;$i < $jml;$i++){
            $this->db->query("SET @flag = 0");
            $this->db->query("call zhl_sp_ship_tbl_trn_inv_dtl('".$invno."','".$contid_dtl[$i]."',"
                    . "'".$poid[$i]."','".$productid[$i]."','".htmlspecialchars($ProductName[$i],ENT_QUOTES)."','".$qty[$i]."','".$unitprice[$i]."',"
                    . "'".$total[$i]."',@flag,'".$user."','".$ipaddress."','".$jml."','".$i."')");
        }
        
        $row=  $this->db->query("Select @flag as flag")->row();

        return $row;
    }
    
    function simpan_inv_sp_dp($invno,$detail_id,$bayar,$dpremark,$jml2){
        for($i = 0;$i < $jml2;$i++){
            $this->db->query("SET @flag = 0");
            $this->db->query("call zhl_sp_ship_tbl_trn_inv_dp('".$invno."','".$detail_id[$i]."','".$bayar[$i]."','".htmlspecialchars($dpremark[$i],ENT_QUOTES)."',@flag)");
        }
        
        $row=  $this->db->query("Select @flag as flag")->row();
        return $row;
    }
    
    function simpan_inv_sp_dtl_cost($invno,$cost,$price,$coa,$ipaddress,$jml_cost){
        for($i = 0;$i < $jml_cost;$i++){
            if($cost[$i] != ''){
                $this->db->query("call zhl_sp_ship_tbl_trn_inv_cost('".$invno."','".htmlspecialchars($cost[$i],ENT_QUOTES)."','".$price[$i]."','".$coa[$i]."','".$ipaddress."')");
            }
        }
        return TRUE;
    }
    
    
    function cek_acc_piutang($invno){
        $flag = 1;
        $query="nofaktur='".$invno."' and jenis_trans='SIJC' and (nota_debet > 0 or nota_kredit > 0 or bayar > 0)";
        $this->db->where($query);
        $sql=$this->db->get('zhl_acc_tbl_trn_piutang');
        
        if($sql->num_rows() > 0){
            $flag=0;
        }
        return $flag;
    }

       //tambahan 08-12-2017
    function get_bank($po){
        $query = $this->db->query("SELECT a.po_number, b.bank_id , c.bank_name, c.bank_swift, c.bank_account_number
                                    FROM zhl_mar_tbltrn_purchase_order a LEFT JOIN 
                                    zhl_mar_tbltrn_sales_contract b on a.contract_hdr_id = b.contract_hdr_id LEFT JOIN
                                    zhl_mar_tblmst_bank c ON b.bank_id = c.bank_id
                                    where a.po_number = '".$po."'");

        return $query->row();
    }
}