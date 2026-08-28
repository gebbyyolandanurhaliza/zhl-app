<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_shipping extends CI_Model{
    private $container_stock = 'zhl_ship_tbl_trn_cont_stock';

    
//    ---------------------------------------------------------About Shipping Liner---------------------------------------------------------------
    function tampil_shipping_liner(){
        $this->db->where('notactive = 0');
        $result=  $this->db->get('ship_tbl_mst_shipping_line');
        
        return $result->result();
    }
    
    function tampil_shipping_liner_where($shippingid){
        $this->db->where('shipping_id',$shippingid);
        $result=  $this->db->get('ship_tbl_mst_shipping_line');
        
        return $result->row();
    }
    
    function simpan_shipping_liner($data){
        $this->db->insert('ship_tbl_mst_shipping_line',$data);
        return true;
    }
    
    function update_shipping_liner($shippingid,$data){
        $this->db->where('shipping_id',$shippingid);
        $this->db->update('ship_tbl_mst_shipping_line',$data);
        return true;
    }
    
    function delete_shipping_liner($shippingid){
        $data=array('notactive'=>'1');
        
        $this->db->where('shipping_id',$shippingid);
        $this->db->update('ship_tbl_mst_shipping_line',$data);
        return true;
    }


//    ---------------------------------------------------------About Port---------------------------------------------------------------
    function tampil_port(){
        $this->db->select('a.*,b.country_name');
        $this->db->from('mar_tblmst_port a');
        $this->db->join('gen_tbl_mst_country b','b.country_ids=a.country_ids');
        $this->db->where('a.notactive = 0');
        $result=  $this->db->get();
        
        return $result->result();
    }
    
    function tampil_port_where($portid){
        $this->db->select('a.*,b.country_name');
        $this->db->from('mar_tblmst_port a');
        $this->db->join('gen_tbl_mst_country b','b.country_ids=a.country_ids');
        $this->db->where('a.port_id',$portid);
        $result=  $this->db->get();
        
        return $result->row();
    }
    
    function simpan_port($data){
        $this->db->insert('mar_tblmst_port',$data);
        return true;
    }
    
    function update_port($portid,$data){
        $this->db->where('port_id',$portid);
        $this->db->update('mar_tblmst_port',$data);
        return true;
    }
    
    function delete_port($portid){
        $data=array('notactive'=>'1');
        
        $this->db->where('port_id',$portid);
        $this->db->update('mar_tblmst_port',$data);
        return true;
    }
    
//    ----------------------------------------------------------------------------------------------------------------------------------
    function tampil_po($fac,$schedule,$po){
        $query="(po_number like '%".$po."%' or shipping_name like '%".$po."%' or container_name like '%".$po."%')";
        if ($fac != ''){
            $query= $query." And Factory_id ='".$fac."'";
        }
        
        if ($schedule !=''){
            $query= $query." And schedule_date ='".$this->convert($schedule)."'";
        }
        $this->db->where('proses','0');
        $this->db->where($query);
        $this->db->group_by('ship_id');
        $this->db->group_by('schedule_date');
        $this->db->group_by('po_number');
        $this->db->group_by('factory_abbr');
        $this->db->group_by('shipping_name');
        $this->db->group_by('container_name');
        $this->db->group_by('port_name');
        $this->db->group_by('destination');
        $this->db->order_by('schedule_date');
        $result=$this->db->get('ship_vw_trn_shipping_instruction');
        return $result->result();
    }
    
    function tampil_po_outward($data){
        $query="(po_number like '%".$data."%' or shipping_liner like '%".$data."%' or voyage like '%".$data."%' or eta like '%".$data."%' or etd  like '%".$data."%' or `from` like '%".$data."%' or `to` like '%".$data."%')";
        $this->db->where($query);
        $this->db->where('tipe','1');
        $this->db->where('proses','0');
        $result=$this->db->get('ship_vw_trn_cont');
        return $result->result();
    }
    
    function tampil_cont($date,$data){
        $query="(barge like '%".$data."%' or voyage like '%".$data."%' or eta like '%".$data."%' or etd  like '%".$data."%' or `from` like '%".$data."%' or `to` like '%".$data."%')";
        
        if ($date !=''){
            $query= $query." And shipmentdate ='".$this->convert($date)."'";
        }
        
        $this->db->where($query);
        $this->db->order_by('shipmentdate');
        $result=$this->db->get('ship_tbl_trn_cont_hdr');
        return $result->result();
    }
    
    function tampil_cont_outward($data){ 
        $query="(barge like '%".$data."%' or voyage like '%".$data."%' or eta like '%".$data."%' or etd  like '%".$data."%' or `from` like '%".$data."%' or `to` like '%".$data."%')";
        $this->db->where('tipe','1');
        $this->db->where('proses','0');
        $this->db->where($query);
        $result=$this->db->get('ship_vw_trn_cont_proses');
        return $result->result();
    }
    
    function tampil_cont_where($contid){
        $this->db->where('contid',$contid);
        $this->db->order_by('urut');
        $result=$this->db->get('ship_vw_trn_cont');
        return $result->result();
    }
    
    function tampil_cont_where_outward($contid){
        $this->db->where('contid',$contid);
        $this->db->where('proses','0');
        $result=$this->db->get('ship_vw_trn_cont');
        return $result->result();
    }
    
    function simpan_cont_sp($datahdr){
        $this->db->trans_begin();
            $id=$this->input->post('id');
            $shipid=$this->input->post('shipid');
            $carrier=$this->input->post('carrier');
            $destination=$this->input->post('final');
            $reff=$this->input->post('reff');
            $vessel=$this->input->post('vessel');
            $convessel=$this->input->post('convessel');
            $depot=$this->input->post('depot');
            $pod=$this->input->post('pod');
            $opcode=$this->input->post('opcode');
            $etd=$this->input->post('etdsin');
            $eta=$this->input->post('etasin');
            $container=$this->input->post('container');
            $seal=$this->input->post('seal');
            $weight=$this->input->post('weight');
            $outward=$this->input->post('outward');
            $urut=$this->input->post('urut');
            $stuffing=$this->input->post('stuffing');
            $actual_seal=$this->input->post('actual_seal');
            $stock_id_dtl=$this->input->post('stock_id_dtl');
            $container_number=$this->input->post('container');

            $jml=count($shipid);
                                            
            $query1= $this->simpan_cont_sp_hdr($datahdr);
            $contid=$query1->contid;
            $flag1=$query1->flag;
            
            if($flag1 == 0) {
                $this->db->trans_rollback();
                $data=array('flag'=>$flag1);
                return $data;
            }
            
            $query2=$this->simpan_cont_sp_dtl($contid,$id,$shipid,$destination,$reff,$vessel,$convessel,$depot,$pod,$opcode,$etd,$eta,$container,$seal,$weight,$outward,$jml,$carrier,$urut,$stuffing,$actual_seal,$stock_id_dtl,$container_number);
            $flag2=$query2->flag;

            if($flag2 == 0) {
                $this->db->trans_rollback();
                $data=array('flag'=>$flag2);
                return $data;
            }
            
        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $data=array('flag'=>$flag2);
            return $data;
        }else {
            $this->db->trans_commit();
            $data=array('flag'=>$flag2,'contid'=>$contid);
            return $data;
        }
    }
    
    function simpan_cont_sp_hdr($datahdr){
        $this->db->query("SET @contid = '".$datahdr['contid']."'");
        $this->db->query("SET @flag = 0");
        $this->db->query("call sp_ship_tbl_trn_cont_hdr('".$datahdr['trans']."',@contid,'".$datahdr['tipe']."','".$datahdr['barge']."','".$datahdr['voyage']."','".$datahdr['etd']."',"
        . "'".$datahdr['etddate']."','".$datahdr['eta']."','".$datahdr['etadate']."','".$datahdr['shipmentdate']."','".$datahdr['from']."','".$datahdr['to']."',"
        . "'".$datahdr['amendmentdate']."','".$datahdr['remarks']."','".$datahdr['createdby']."',@flag)");
        $row=  $this->db->query("Select @contid as contid, @flag as flag")->row();

        return $row;
    }
    
    function simpan_cont_sp_dtl($contid,$id,$shipid,$destination,$reff,$vessel,$convessel,$depot,$pod,$opcode,$etd,$eta,$container, $seal,$weight,$outward,$jml,$carrier,$urut, $stuffing, $actual_seal,$stock_id_dtl,$container_number){
        for($i = 0;$i < $jml;$i++){

            //================Kalau pakai Container Number Bisa Save
            if($container_number[$i] != ''){
            $this->db->query("UPDATE zhl_ship_tbl_trn_cont_stock_dtl set status_note = '1' where container_number ='".$container_number[$i]."'");                
            }



            $this->db->query("SET @flag = 0");
            $this->db->query("call sp_ship_tbl_trn_cont_dtl_new1('".$contid."','".$id[$i]."','".$shipid[$i]."','".$destination[$i]."','".$reff[$i]."','".$vessel[$i]."','".$convessel[$i]."','".htmlspecialchars($depot[$i],ENT_QUOTES)."',"
            . "'".$pod[$i]."','".$opcode[$i]."','".$etd[$i]."','".$eta[$i]."','".$container[$i]."','".$seal[$i]."','".$weight[$i]."','".$outward[$i]."',@flag,'".$carrier[$i]."','".$urut[$i]."','".$stuffing[$i]."','".$actual_seal[$i]."')");
        }
        
        $row=  $this->db->query("Select @flag as flag")->row();

        return $row;
    }
    

    function get_refnum($thn){
        $sql = $this->db->query("SELECT no_reff FROM zhl_ship_tbl_trn_cont_stock_hdr
            WHERE YEAR(arrival_date) = '$thn' AND `no_reff` LIKE '%GV%' 
            ORDER BY RIGHT(no_reff,4)  DESC LIMIT 1");
        return $sql->row();
    }


    function select_container($id) {
        $this->db->select('*');
        $this->db->where('stock_id_hdr', $id);
        $sql_product = $this->db->get('zhl_ship_tbl_trn_cont_stock_hdr');
        if ($sql_product->num_rows() > 0) {
            foreach ($sql_product->result() as $data) {
                $hasil[] = $data;
            }
            return $hasil;
        }
    }


    function get_container_type()
    {
        return $this->db->get('mar_tblmst_container')->result();
    }

    function get_by_id()
    {
                $table = $this->container_stock;
                $this->db->where($this->stock_id, $id);
    }

    function tampil_container_stock($data){
        $query="(stock_id like '%".$data."%')";
        $this->db->where($query);
        $result=$this->db->get('zhl_ship_tbl_trn_cont_stock');
        return $result->result();
    }

 
    function simpan_container_stock_hdr($data){
        $this->db->insert('zhl_ship_tbl_trn_cont_stock_hdr',$data);
        $primary_key=$this->db->insert_id();
        return $primary_key;
    }


    function simpan_container_stock_dtl($data){
        $this->db->insert('zhl_ship_tbl_trn_cont_stock_dtl',$data);
        return true;
    }

    function buat_note_container_stock($datastock){

    }

     function get_container_stock_hdr($id){
       $this->db->where('stock_id_hdr',$id);
       return $this->db->get('zhl_ship_tbl_trn_cont_stock_hdr')->result();
    }

    function get_container_stock_dtl($id){
       $this->db->where('stock_id_hdr',$id);
       return $this->db->get('zhl_ship_tbl_trn_cont_stock_dtl')->result();

    }

    function simpan_cont_stock_sp_dtl($container_number,$container_id,$container_name){
        for($i = 0; $i < count($container_id); $i++){
        $this->db->query("call zhl_shp_cont_dtl_stock('".$container_number[$i]."','".$container_id[$i]."','".$container_name[$i]."')");
        }
        return true;
    }


    function update_container_stock_hdr($data_hdr,$stock_id_hdr){
        $this->db->where('stock_id_hdr',$stock_id_hdr);
        $this->db->update('zhl_ship_tbl_trn_cont_stock_hdr',$data_hdr);
        $primary_key=$this->db->insert_id();
        return $primary_key;
    }

    function update_container_stock_dtl($data_dtl,$stock_id_dtl){
        $this->db->where('stock_id_dtl',$stock_id_dtl);
        $this->db->update('zhl_ship_tbl_trn_cont_stock_dtl',$data_dtl);
        return true;
    }


    function delete_container_stock($id) {
        $this->db->where('stock_id_dtl',$id);
        $this->db->delete('zhl_ship_tbl_trn_cont_stock_dtl');
        return true;
        }

    function tampil_container_stock_modal($container_name){
        $query="(container_name like '%".$container_name."%')";
        $this->db->where($query);
        $result=$this->db->get('zhl_mar_tblmst_container');
        return $result->result();
    }

//-----------------JANGAN GANGGU KODING DIBAWAH-----------------------//
    function tampil_stock_where($contid){
        $this->db->where('stock_id_hdr',$contid);
        $this->db->order_by('stock_id_dtl');
        $result=$this->db->get('zhl_ship_vw_trn_cont_stock');
        return $result->result();
    }
//-----------------JANGAN GANGGU KODING DIATAS------------------------//


    function delete_cont_sp($contid){
        $this->db->trans_begin();
            $this->db->query("SET @flag = 0");
            $this->db->query("call sp_ship_tbl_trn_cont_del('".$contid."',@flag)");
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
    
    function tampil_po_inward($data){
        $query="(po_number like '%".$data."%' or container like '%".$data."%' or reff like '%".$data."%' or vessel  like '%".$data."%' or port_name like '%".$data."%' or destination like '%".$data."%')";
        $this->db->where($query);
        $this->db->where('tipe','2');
        $this->db->order_by('shipmentdate');
        $result=$this->db->get('ship_vw_trn_cont');
        return $result->result();
    }
    
    function tampil_container_loading($data){
        $query="(carrier like '%".$data."%' or voyage like '%".$data."%' or to like '%".$data."%' or attn like '%".$data."%' or from like '%".$data."%')";
        $this->db->where($query);
        $result=$this->db->get('ship_tbl_trn_cont_loading_hdr');
        return $result->result();
    }
    
    function tampil_container_loading_where($id){
        $this->db->where('headerid',$id);
        $result=$this->db->get('ship_vw_trn_cont_loading');
        return $result->result();
    }
    
    function simpan_cont_l_sp($dataHdr){
        $this->db->trans_begin();
            $cont= $this->input->post('cont');
            $reff= $this->input->post('reff');
            $vessel= $this->input->post('vessel');
            $port= $this->input->post('port');
            $destination= $this->input->post('destination');
            $contid= $this->input->post('contid');
            $jml= count($cont);
            
            $query1= $this->simpan_cont_l_sp_hdr($dataHdr);
            $headerid=$query1->headerid;
            $flag1=$query1->flag;
            
            if($flag1 == 0){
                $this->db->trans_rollback();
                $data=array('flag'=>$flag1);
                return $data;
            }
            
            $query2=$this->simpan_cont_l_sp_dtl($headerid, $contid, $cont, $reff, $vessel, $port, $destination, $jml);
            $flag2=$query2->flag;
            
            if($flag2 == 0){
                $this->db->trans_rollback();
                $data=array('flag'=>$flag2);
                return $data;
            }
            
        if($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            $data=array('flag'=>$flag1);
            return $data;
        } else {
            $this->db->trans_commit();
            $data=array('headerid'=>$headerid,'flag'=>$flag1);
            return $data;
        }
        
    }
    
    function simpan_cont_l_sp_hdr($dataHdr){
        $this->db->query("Set @headerid ='".$dataHdr['id']."'");
        $this->db->query("Set @flag = 0");
        $this->db->query("Call sp_ship_tbl_trn_cont_l_hdr ('".$dataHdr['trans']."',@headerid,'".$dataHdr['docdate']."','".$dataHdr['barge']."','".$dataHdr['voyage']."','".$dataHdr['etasin']."','".$dataHdr['to']."','".$dataHdr['attn']."','".$dataHdr['from']."','".$dataHdr['remarks']."','".$dataHdr['createdby']."',@flag)");
        $row = $this->db->query("Select @headerid as headerid, @flag as flag")->row();
        
        return $row; 
    }
    
    function simpan_cont_l_sp_dtl($headerid,$contid,$cont,$reff,$vessel,$port,$destination,$jml){
        for($i = 0;$i < $jml;$i++){
            $this->db->query("Set @flag = 0");
            $this->db->query("Call sp_ship_tbl_trn_cont_l_dtl ('".$headerid."','".$contid[$i]."','".$cont[$i]."','".$reff[$i]."','".$vessel[$i]."','".$port[$i]."','".$destination[$i]."',@flag)");
        }
        
        $row=  $this->db->query("Select @flag as flag")->row();
        return $row;
    }
    
    function delete_cont_l_sp($headerid){
        $this->db->trans_begin();
            $this->db->query("Set @flag=0 ");
            $this->db->query("Call sp_ship_tbl_trn_cont_l_del ('".$headerid."',@flag)");
            $row=$this->db->query('Select @flag as flag')->row();
            
            $flag=$row->flag;
            
            if($flag == 0){
                $this->db->trans_rollback();
                $data = array('flag'=>$flag);
                return $data;
            }
      
        $this->db->trans_complete();
        
        if($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            $data = array('flag'=>$flag);
            return $data;
        } else {
            $this->db->trans_commit();
            $data = array('flag'=>$flag);
            return $data;
        }
    }
            
    function tampil_factory(){
        $result=  $this->db->get('gen_tbl_mst_factory');
        
        return $result->result();
    }

    function tampil_factory_stock_container_inward($stock){
        //$this->db->where('status_exit',0);
        $query = "(container_number like '%".$stock."%')";
        $this->db->where($query);
        $result= $this->db->get('zhl_ship_vw_trn_cont_stock');

        return $result->result();
    }

    function tampil_factory_stock_container(){
        $result= $this->db->get('zhl_ship_vw_trn_cont_stock');

        return $result->result();
    }

    function tampil_factory_stock_container_list(){
        //$this->db->where('status_exit',0);
        $result=  $this->db->get('zhl_ship_vw_trn_cont_stock');

        return $result->result();
    }

    
    function tampil_cust(){
        $this->db->order_by('customer_company_name');
        $result=  $this->db->get('mar_tblmst_customer');
        return $result->result();
    }
    
     function convert($date){
        if (trim($date) != '') {
            $explode=explode("-", $date);

            $time=$explode[2].'/'.$explode[1].'/'.$explode[0];
        
        } else {
            $time;
        }
        
        return $time;
    }
    function gettype(){
        $this->db->order_by('container_id');
        $result=$this->db->get('mar_tblmst_container');
        return $result->result();
    }

    function getshipinward(){
        $this->db->where('tipe','2');
        $this->db->order_by('contid','DESC');
        $result=$this->db->get('ship_tbl_trn_cont_hdr');
        return $result->result();
    }

    function getshipoutward(){
        $this->db->where('tipe','1');
        $this->db->order_by('contid','DESC');
        $result=$this->db->get('ship_tbl_trn_cont_hdr');
        return $result->result();
    }

    function getcontainerinward(){
        $this->db->order_by('contid');
        $result=$this->db->get('ship_tbl_trn_cont_dtl');
        return $result->result();
    }


    function containerinward_move($contid,$inward,$outward){
        $this->db->query("UPDATE ship_tbl_trn_cont_dtl set contid = '".$contid."' WHERE id in (".$inward.",".$outward.")");
    }

    function containeroutward_move($contid,$inward,$outward){
        $this->db->query("UPDATE ship_tbl_trn_cont_dtl set contid = '".$contid."' WHERE id in (".$inward.",".$outward.")");
    }

    function inwardcontainerinward_update2($id,$data){
        $this->db->where('id',$id);
        $this->db->update('ship_tbl_trn_cont_dtl',$data);
        return $this->db->query("SELECT container FROM ship_tbl_trn_cont_dtl where id = '".$id."'")->row();
        //return true;
    }

    function containerinward_update($id,$data){
        $this->db->where('id',$id);
        $this->db->update('zhl_container_stock_temporary',$data);
        return $this->db->query("SELECT container FROM zhl_container_stock_temporary where stock_id_dtl = '".$id."'")->row();
    }

    function container_stock_noted($stock_id_dtl){        
        $this->db->query("UPDATE zhl_ship_tbl_trn_cont_stock_dtl set status_note = '1' where stock_id_dtl ='".$stock_id_dtl."'");
    }

    function container_inward_changestock($data){
        //$this->db->where('id',$id);

        $query = 'call zhl_sp_container_change(?, ?)';
        $sql = $this->db->query($query, $data);

        return $sql->row();
        //return $this->db->query("SELECT container FROM ship_tbl_trn_cont_dtl where id = '".$id."'")->row();
    }

    function container_inward_changestock2($data){
        //$this->db->where('id',$id);

        $query = 'call zhl_sp_container_change_temporary(?, ?)';
        $sql = $this->db->query($query, $data);

        return $sql->row();
        //return $this->db->query("SELECT container FROM ship_tbl_trn_cont_dtl where id = '".$id."'")->row();
    }

//============================Epic Comeback
    function tampil_factory_stock_container_comeback(){
        //$this->db->where('status_exit',0);
        $result=  $this->db->get('zhl_ship_vw_trn_cont_stock_comeback');
        return $result->result();
    }

    function container_stock_return_status($id){        
        $this->db->query("UPDATE zhl_ship_tbl_trn_cont_stock_dtl set status_note = '2', Remark = 'Return To Singapore' where stock_id_dtl ='".$id."'");
    }

    function container_stock_reuse($id){        
        $this->db->query("UPDATE zhl_ship_tbl_trn_cont_stock_dtl set status_note = '0' where stock_id_dtl ='".$id."'");
    }
}