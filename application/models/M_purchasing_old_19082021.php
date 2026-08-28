<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_purchasing extends CI_Model{
//-------------------------------------------------------ABOUT COMPANY----------------------------------------------------------------
    function tampil_company(){
        $result=  $this->db->get('zhl_gen_tbl_company');
        return $result->result();
    }
//--------------------------------------------------------ABOUT SUPPLIER---------------------------------------------------------------
    function tampil_supp($data){
        $query=" (supplierid like '%".$data."%' or suppliercompany like '%".$data."%') ";
        $this->db->where($query);
        $this->db->where('notactive','0');
        $result=  $this->db->get('zhl_pur_tbl_mst_supplier');
        return $result->result();
    }
    
    function tampil_supp_limit(){
        $this->db->where('notactive','0');
        $this->db->order_by('createddate desc');
        $this->db->limit(50);
        
        $result=  $this->db->get('zhl_pur_tbl_mst_supplier');
        return $result->result();
    }
    
    function tampil_supp_where($data){
        $this->db->where('supplierid',$data);
        $result=  $this->db->get('zhl_pur_tbl_mst_supplier');
        return $result->row();
    }
    
    function simpan_vendor($data){
        $this->db->insert('zhl_pur_tbl_mst_supplier',$data);
        return true;
    }
    
    function update_vendor($vendorid,$data){
        $this->db->where('supplierid',$vendorid);
        
        $sql = $this->db->get('zhl_pur_tbl_mst_supplier');
        
        if ($sql->num_rows() > 0) {
            $this->db->where('supplierid',$vendorid);
            
            $this->db->update('zhl_pur_tbl_mst_supplier',$data);
            return true;
        } else {
            return false;
        }
        
    }
    
    function delete_vendor($vendorid,$user){
        $this->db->where('supplierid',$vendorid);
        $this->db->where('createdby',$user);
        $sql = $this->db->get('zhl_pur_tbl_mst_supplier');
        
        if ($sql->num_rows() > 0) {
            $this->db->where('supplierid',$vendorid);
            $this->db->update('zhl_pur_tbl_mst_supplier',array('notactive'=>'1'));
            return true;
        } else {
            return false;
        }
    }
    
    function tampil_supp_group(){
        $this->db->select('a.*,b.AccountName');
        $this->db->from('zhl_gen_tbl_mst_vendor_group a');
        $this->db->join('zhl_acc_master_coa b','b.NoCOA=a.nocoa','left outer');
        $this->db->where('a.notactive = 0');
        $result=  $this->db->get();
        return $result->result();
    }
    
    function simpan_vendor_group($data){
        $this->db->insert('zhl_gen_tbl_mst_vendor_group',$data);
        return true;
    }
    
    function update_vendor_group($id,$data){
        $this->db->where('id',$id);
        $this->db->update('zhl_gen_tbl_mst_vendor_group',$data);
        return true;
    }
    
    function delete_vendor_group($id){
        $this->db->where('id',$id);
        $this->db->update('zhl_gen_tbl_mst_vendor_group',array('notactive'=>'1'));
        return true;
    }
//-------------------------------------------------------ABOUT CUSTOMER------------------------------------------------------------------
    function tampil_cust($data){
        $query="(customer_code like '%".$data."%' or customer_company_name like '%".$data."%')";
        $this->db->where($query);
        $this->db->where('status_customer','1');
        $this->db->where('group_customer','4');
        $result=  $this->db->get('zhl_mar_tblmst_customer');
        return $result->result();
    }
    
    function tampil_cust_mar($data){
        $query="(a.customer_code like '%".$data."%' or a.customer_company_name like '%".$data."%')";
        $this->db->select('customer_code,customer_company_name,customer_contact_name,payment_term');
        $this->db->where($query);
        $this->db->where('a.status_customer','1');
        $this->db->where('a.group_customer','0');
        $this->db->from('zhl_mar_tblmst_customer a');
        $this->db->join('zhl_mar_tblmst_customer_payterm b','b.customer_id=a.customer_id','left');
        $result=  $this->db->get();
        return $result->result();
    }
    
    function tampil_cust_limit(){
        $this->db->where('status_customer','1');
        $this->db->where('group_customer','4');
        $this->db->order_bby('createddate desc');
        $this->db->limit(50);
        
        $result=  $this->db->get('zhl_mar_tblmst_customer');
        return $result->result();
    }
    
    function tampil_cust_where($data){
        $this->db->where('customer_code',$data);
        $result=  $this->db->get('zhl_mar_tblmst_customer');
        return $result->row();
    }
    
    function simpan_customer($data){
        $this->db->insert('zhl_mar_tblmst_customer',$data);
        return true;
    }
    
    function update_customer($customerid,$data){
        $this->db->where('customer_code',$customerid);
        $this->db->update('zhl_mar_tblmst_customer',$data);
        return true;
    }
    
    function delete_customer($customerid){
        $this->db->where('customer_code',$customerid);
        $this->db->update('zhl_mar_tblmst_customer',array('status_customer'=>'0'));
        return true;
    }

//-------------------------------------------------------ABOUT WHS------------------------------------------------------------------
    function tampil_whs($data){
        $query="(name like '%".$data."%')";
        $this->db->where($query);
        $this->db->where('notactive','0');
        $result=  $this->db->get('zhl_gen_tbl_mst_whs');
        return $result->result();
    }
    
    function tampil_whs_where($data){
        $this->db->where('id',$data);
        $result=  $this->db->get('zhl_gen_tbl_mst_whs');
        return $result->row();
        
    }
    
    function simpan_whs($data){
        $this->db->insert('zhl_gen_tbl_mst_whs',$data);
        return true;
    }
    
    function update_whs($customerid,$data){
        $this->db->where('id',$customerid);
        $this->db->update('zhl_gen_tbl_mst_whs',$data);
        return true;
    }
    
    function delete_whs($customerid){
        $this->db->where('id',$customerid);
        $this->db->update('zhl_gen_tbl_mst_whs',array('notactive'=>'1'));
        return true;
    }
//--------------------------------------------------------ABOUT CURRENCY-----------------------------------------------------------------
    function tampil_cur(){
        $result=  $this->db->get('zhl_gen_tbl_mst_currency');
        return $result->result();
    }
//--------------------------------------------------------ABOUT ITEM---------------------------------------------------------------------
    function tampil_item($data){
        $query="(itemid like '%".$data."%' or itemname like '%".$data."%')";
        $this->db->where($query);
        $this->db->where('notactive=0');
        
        $result=  $this->db->get('zhl_gen_vw_mst_item');
        return $result->result();
    }
    
    function tampil_item_search($item,$category,$categorysub){
        $query="(itemid like '%".$item."%' or itemname like '%".$item."%')";
        
        if($category != ''){
            $query=$query." and categoryid = '".$category."'";
            
            if(trim($categorysub) != ''){
                $query=$query." and categorysubid = '".$categorysub."'";
            }
        }
        
        $this->db->where($query);
        $this->db->where('notactive=0');
        
        $result=  $this->db->get('zhl_gen_vw_mst_item');
        return $result->result();
    }
    
    function tampil_item_limit(){
        $this->db->where('notactive=0');
        $this->db->order_by('createddate desc');
        $this->db->limit(50);
        
        $result=  $this->db->get('zhl_gen_vw_mst_item');
        return $result->result();
    }
    
    function tampil_item_where($data){
        $this->db->where('itemid',$data);
        
        $result=  $this->db->get('zhl_gen_vw_mst_item');
        return $result->result();
    }
    
    function simpan_item($data){
        $this->db->insert('zhl_gen_tbl_mst_item',$data);
        return true;
    }
    function update_item($itemid,$data,$user){
        $this->db->where('itemid',$itemid);
        $this->db->where('createdby',$user);
        $sql = $this->db->get('zhl_gen_tbl_mst_item');
        
        if ($sql->num_rows() > 0) {
            $this->db->where('itemid',$itemid);
            $sql2 = $this->db->get('zhl_pur_tbl_trn_po_dtl');
            
            if ($sql2->num_rows() < 1) {
                $this->db->where('itemid',$itemid);
                $this->db->where('createdby',$user);
                $this->db->update('zhl_gen_tbl_mst_item',$data);
            } else {
                $data=array('itemname'=>$data['itemname'],'itemremark'=>$data['itemremark'],'country_id'=>$data['country_id'],
                    'pmcode'=>$data['pmcode'],'hscode'=>$data['hscode'],'idcwp1'=>$data['idcwp1'],'idcwp2'=>$data['idcwp2'],'idcwp3'=>$data['idcwp3']);
                
                $this->db->where('itemid',$itemid);
                $this->db->where('createdby',$user);
                $this->db->update('zhl_gen_tbl_mst_item',$data);
            }
            return true;
        } else {
            return false;
        }
        
    }
    
    function delete_item($data,$user){
        $this->db->where('createdby',$user);
        $sql = $this->db->get('zhl_gen_tbl_mst_item');
        
        if ($sql->num_rows() > 0) {
            $this->db->where('itemid',$data);
            $this->db->update('zhl_gen_tbl_mst_item',array('notactive'=>'1'));
            return true;
        } else {
            return false;
        }
    }

    function update_item_factory($itemid,$data){
        $this->db->where('itemid',$itemid);
        $this->db->update('zhl_gen_tbl_mst_item',$data);
        return true;
        
    }
//--------------------------------------------------------ABOUT UOM-----------------------------------------------------------------------
    function tampil_item_uom(){
        $this->db->where('notactive = 0');
        $result=  $this->db->get('zhl_gen_tbl_mst_item_uom');
        return $result->result();
    }
    
    function simpan_item_uom($data){
        $this->db->insert('zhl_gen_tbl_mst_item_uom',$data);
        return true;
    }
    function update_item_uom($uomid,$data){
        $this->db->where('uomid',$uomid);
        $this->db->update('zhl_gen_tbl_mst_item_uom',$data);
        return true;
    }
    function delete_item_uom($uomid){
        $data=array('notactive'=>'1');
        
        $this->db->where('uomid',$uomid);
        $this->db->update('zhl_gen_tbl_mst_item_uom',$data);
        return true;
    }
//--------------------------------------------------------ABOUT GROUP-----------------------------------------------------------------------
    function tampil_item_group(){
        $this->db->select('a.*,b.AccountName as AccountNameinv,c.AccountName as AccountNamegs,d.AccountName as AccountNameSales');
        $this->db->from('zhl_gen_tbl_mst_item_category a');
        $this->db->where('a.notactive = 0');
        $this->db->join('zhl_acc_master_coa b','b.NoCOA=a.nocoainv','left outer');
        $this->db->join('zhl_acc_master_coa c','c.NoCOA=a.nocoags','left outer');
        $this->db->join('zhl_acc_master_coa d','d.NoCOA=a.nocoasales','left outer');
        $this->db->order_by('a.categoryid');
        $result=  $this->db->get();
        return $result->result();
    }
    
    function tampil_item_group_where($categoryid){
        $this->db->select('a.*,b.AccountName as AccountNameinv,c.AccountName as AccountNamegs,d.AccountName as AccountNameSales');
        $this->db->from('zhl_gen_tbl_mst_item_category a');
        $this->db->join('zhl_acc_master_coa b','b.NoCOA=a.nocoainv','left outer');
        $this->db->join('zhl_acc_master_coa c','c.NoCOA=a.nocoags','left outer');
        $this->db->join('zhl_acc_master_coa d','d.NoCOA=a.nocoasales','left outer');
        $this->db->where('a.categoryid',$categoryid);
        $result=  $this->db->get();
        return $result->row();
    }
    
    function simpan_item_group($data){
        $this->db->insert('zhl_gen_tbl_mst_item_category',$data);
        return true;
    }
    function update_item_group($groupid,$data){
        $this->db->where('categoryid',$groupid);
        $this->db->update('zhl_gen_tbl_mst_item_category',$data);
        return true;
    }
    function delete_item_group($categoryid){
        $data=array('notactive'=>'1');
        
        $this->db->where('categoryid',$categoryid);
        $this->db->update('zhl_gen_tbl_mst_item_category',$data);
        return true;
    }
//--------------------------------------------------------ABOUT GROUP SUB-----------------------------------------------------------------------
    function tampil_item_group_sub(){
        $this->db->select('a.categorysubid,a.categorysubname,a.categoryid,b.categoryname,a.createdby,a.createddate,a.lastupdatedby,a.lastupdateddate');
        $this->db->from('zhl_gen_tbl_mst_item_category_sub a');
        $this->db->where('a.notactive = 0');
        $this->db->join('zhl_gen_tbl_mst_item_category b','b.categoryid=a.categoryid');
        $this->db->order_by('categorysubid');
        $result=  $this->db->get();
        return $result->result();
    }
    
    function tampil_item_group_sub_where($categoryid){
        $this->db->where('categoryid',$categoryid);
        $this->db->order_by('categorysubid');
        
        $result=  $this->db->get('zhl_gen_tbl_mst_item_category_sub');
        return $result->result();
    }
    
    function simpan_item_group_sub($data){
        $this->db->insert('zhl_gen_tbl_mst_item_category_sub',$data);
        return true;
    }
    function update_item_group_sub($groupid,$data){
        $this->db->where('categorysubid',$groupid);
        $this->db->update('zhl_gen_tbl_mst_item_category_sub',$data);
        return true;
    }
    function delete_item_group_sub($categorysubid){
        $data=array('notactive'=>'1');
        
        $this->db->where('categorysubid',$categorysubid);
        $this->db->update('zhl_gen_tbl_mst_item_category_sub',$data);
        return true;
    }
//--------------------------------------------------------ABOUT ITEM PRICE-----------------------------------------------------------------------
    function tampil_item_price($data){
        $query="supplierid like '%".$data."%' or suppliercompany like '%".$data."%' or itemid like '%".$data."%' or itemname like '%".$data."%'";
        
        $this->db->where($query);
        $this->db->order_by('supplierid');
        
        $result=  $this->db->get('zhl_gen_vw_mst_item_price');
        return $result->result();
    }
    
    function tampil_item_price_limit(){
        $this->db->order_by('supplierid');
        $this->db->limit(50);
        
        $result=  $this->db->get('zhl_gen_vw_mst_item_price');
        return $result->result();
    }
    
    function tampil_item_price_where($supp,$item){
        $this->db->where('supplierid',$supp);
        $this->db->where('itemid',$item);
        
        $result=  $this->db->get('zhl_gen_vw_mst_item_price');
        return $result->result();
    }
    
    function simpan_item_price($datahdr){
        $this->db->trans_begin();
            $cur=  $this->input->post('cur');
            $item=$this->input->post('ItemID');
            $itemname=$this->input->post('ItemName');
            $qty=$this->input->post('Qty');
            $unitprice=$this->input->post('UnitPrice');
            $jml=count($item);

            $this->db->where('supplierid',$datahdr['supplierid']);
            $sql = $this->db->get('zhl_gen_tbl_mst_item_price_hdr');
            
            if ($sql->num_rows() == 0) {
                $this->db->insert('zhl_gen_tbl_mst_item_price_hdr', $datahdr);
            }
            
            for($i = 0;$i < $jml;$i++){
                $this->db->where('supplierid',$datahdr['supplierid']);
                $this->db->where('itemid',$item[$i]);
                $sql = $this->db->get('zhl_gen_tbl_mst_item_price_dtl');
                
                if ($sql->num_rows() == 0) {
                    $datadtl=array('supplierid'=>$datahdr['supplierid'],'itemid'=>$item[$i],'itemname'=>$itemname[$i],
                                'qnty'=>$qty[$i],'unitprice'=>$unitprice[$i],'currencyid'=>$cur,
                                'createdby'=> strtoupper($this->session->userdata('userid')),'createddate'=> date('Y-m-d H:i:s'));
                    $this->db->insert('zhl_gen_tbl_mst_item_price_dtl',$datadtl);
                }
            }
        
        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        }else {
            $this->db->trans_commit();
            return TRUE;
        }
    }
    
    function update_item_price(){
        $this->db->trans_begin();
            $vendorid=  trim($this->input->post('vendorid'));
            $cur=  $this->input->post('cur');
            $item=$this->input->post('ItemID');
            $itemname=$this->input->post('ItemName');
            $qty=$this->input->post('Qty');
            $unitprice=$this->input->post('UnitPrice');
            $jml=count($item);
            
            for($i = 0;$i < $jml;$i++){
                $datadtl=array('itemname'=>$itemname[$i],'qnty'=>$qty[$i],'unitprice'=>$unitprice[$i],'currencyid'=>$cur,
                            'createdby'=> strtoupper($this->session->userdata('userid')),'createddate'=> date('Y-m-d H:i:s'));
                $this->db->where('supplierid',$vendorid);
                $this->db->where('itemid',$item[$i]);
                $this->db->update('zhl_gen_tbl_mst_item_price_dtl',$datadtl);
            }
        
        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        }else {
            $this->db->trans_commit();
            return TRUE;
        }
    }
    
    function delete_item_price($supp,$item){
        $this->db->where('supplierid',$supp);
        $sql = $this->db->get('zhl_gen_tbl_mst_item_price_dtl');

        if ($sql->num_rows() <= 1) {
            $this->db->where('supplierid',$supp);
            $this->db->delete('zhl_gen_tbl_mst_item_price_hdr');
        }
            
        $this->db->where('supplierid',$supp);
        $this->db->where('itemid',$item);
        $this->db->delete('zhl_gen_tbl_mst_item_price_dtl');
        
        return true;
    }
//--------------------------------------------------------ABOUT PPH----------------------------------------------------------------------
    function tampil_pph_temp(){
        $result=$this->db->get('zhl_pur_tbl_trn_pph');
        return $result->result();
    }
    
    function tampil_pph_temp_search($from,$to,$pph,$item){
        $result=$this->db->get('zhl_pur_tbl_trn_pph');
        return $result->result();
    }
    
    function cek_pph($pphno,$Item){
        $this->db->where('pphno',$pphno);
        $this->db->where('itemid',$Item);
        
        $sql=  $this->db->get('zhl_pur_tbl_trn_pph');
        if($sql->num_rows() > 0){$result=1;}
        else{$result=0;}
        return $result;
    }
    function simpan_pph(){
        $this->db->trans_begin();
            $chk = $this->input->post('chk');
            $TransDate = $this->input->post('TransDate');
            $PPHNo = $this->input->post('PPHNo');
            $ItemID = $this->input->post('ItemID');
            $ItemName = $this->input->post('ItemName');
            $Qnty = $this->input->post('Qnty');
            $PurchaseUOM = $this->input->post('PurchaseUOM');
            $Remark = $this->input->post('Remark');

            foreach ($chk as $i){
                $data=array('pphno'=>$PPHNo[$i],'transdate'=>date("Y-m-d",  strtotime($TransDate[$i])),'itemid'=>$ItemID[$i],
                        'itemname'=>$ItemName[$i],'qnty'=>$Qnty[$i],'uom'=>$PurchaseUOM[$i],
                        'remark'=>$Remark[$i],'companyid'=>1,
                        'createdby'=> strtoupper($this->session->userdata('userid')),'createddate'=> date('Y-m-d H:i:s'));

                $this->db->insert('zhl_pur_tbl_trn_pph',$data);
            }
        
        $this->db->trans_complete();
        
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        }else {
            $this->db->trans_commit();
            return TRUE;
        }
    }

//----------------------------------------------------------ABOUT SAVE----------------------------------------------------------
     function cek($table,$where){
        $this->db->where($where);
        
        $sql=  $this->db->get($table);
        if($sql->num_rows() > 0){$result=1;}
        else{$result=0;}
        return $result;     
    }
    
    function simpan_hdr($table,$data){
        $this->db->trans_start();
        $this->db->insert($table,$data);
        $this->db->trans_complete();
        
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        }else {
            $this->db->trans_commit();
            return TRUE;
        }
    }
    
    function simpan_dtl($table,$field,$key,$data){
        $this->db->trans_start();
        $this->db->insert($table,$data);
        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            $this->delete_hdr($table,$field,$key);
            $this->db->trans_rollback();
            return FALSE;
        }else {
            $this->db->trans_commit();
            return TRUE;
        }
    }
    
    function simpan_dtl_ver2($table,$data){
        $this->db->trans_start();
        $this->db->insert($table,$data);
        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        }else {
            $this->db->trans_commit();
            return TRUE;
        }
    }
    
    function update_dtl_ver2($table,$field1,$field2,$key1,$key2,$data){
        $this->db->trans_start();
        $this->db->where($field1,$key1);
        $this->db->where($field2,$key2);
        $this->db->update($table,$data);
        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        }else {
            $this->db->trans_commit();
            return TRUE;
        }
    }
    
    function delete_hdr($table,$field,$key){
        $this->db->where($field, $key);
        $this->db->delete($table);
    }
//-----------------------------------------------EXTRA----------------------------------------------------------------
    
    function tampil_po_rate($cur,$date){
        $awalTanggal = date('d', strtotime($date));
        $awalAkhir = date('01', strtotime($date));
        $tempdate = date('Y-m-01', strtotime($date));
        // $newdate = date('Y-m-01', strtotime("-1 months", strtotime($tempdate)));
        $newdate = $tempdate;
        
        if ($awalTanggal == $awalAkhir) {
            $query=" currency_id = '".$cur."' and periode = '".$date."'";
            
        }else{
            $query=" currency_id = '".$cur."' and periode BETWEEN '".$newdate."' AND '".$date."'";
        }

        $this->db->select('rate_usd');
        $this->db->select('rate_kurs');
        $this->db->where($query);
        $this->db->order_by('periode desc');
        $this->db->limit(1);
        
        $result=$this->db->get('zhl_acc_tbl_trn_kurs');
        return $result->row();
    }
    
    function tampil_country(){
        $result=  $this->db->get('zhl_gen_tbl_mst_country');
        return $result->result();
    }
    
    function tampil_trade(){
        $this->db->where('not_active',0);
        $result=  $this->db->get('zhl_mar_tblmst_trading_term');
        return $result->result();
    }
    
    function tampil_coa($data){
        if ($data == 'Sales'){
            $query = "AccountName like '".$data."%' or AccountName like 'Service%'";
        } else {
            $query = "AccountName like '".$data."%'";
        }
        $this->db->where($query);
        $result=  $this->db->get('zhl_acc_master_coa');
        return $result->result();
    }
    
    function tampil_user(){
        $this->db->where('approval = 1');
        $result=  $this->db->get('zhl_gen_tbl_user');
        return $result->result();
    }
    
}