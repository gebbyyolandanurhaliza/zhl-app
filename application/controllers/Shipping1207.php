<?php
defined('BASEPATH') OR exit ('No direct script access allowed');

class shipping extends CI_Controller{


    function __construct() {
        parent::__construct();
        $this->load->model(array('m_shipping','m_purchasing'));
        define('FPDF_FONTPATH',  $this->config->item('fonts_path'));
        $this->load->library(array('Fpdf','PHPExcel'));
        
        if (!$this->session->userdata('userid_1')) {
            redirect('login');
        }
    }

//=============================About Comeback Epic
    public function comeback_container_stock(){
        $data['container_number']=$this->m_shipping->tampil_factory_stock_container_comeback();
        $this->template->display('shipping/container_stock_comeback_list',$data);   
    }
//    ------------------------------------------------------------------About Shipping Line--------------------------------------------------------
    public function shipping_liner(){
        $data['shipping_liner']=  $this->m_shipping->tampil_shipping_liner();
        
        $this->template->display('shipping/mstshipping_line',$data);
    }
    
    public function shipping_liner_show(){
        $data['shipping_liner']=  $this->m_shipping->tampil_shipping_liner_where($this->input->get('line'));
        
        $this->template->display('shipping/mstshipping_line_show',$data);
    }
    
    public function shipping_liner_save (){
        $shippingid=  $this->input->post('shippingid');
        $shippingname=  $this->input->post('shippingname');
        $shippingtipe=  $this->input->post('shippingtipe');
        
        if ($shippingid == ''){
            $data=array('shipping_name'=>$shippingname,'shipping_tipe'=>$shippingtipe,'createdby'=> strtoupper($this->session->userdata('userid_1')),'createddate'=> date('Y-m-d H:i:s'));
            $this->m_shipping->simpan_shipping_liner($data);
            $message='Save Data Success';
        } else{
            $data=array('shipping_name'=>$shippingname,'shipping_tipe'=>$shippingtipe,'lastupdatedby'=> strtoupper($this->session->userdata('userid_1')),'lastupdateddate'=> date('Y-m-d H:i:s'));
            $this->m_shipping->update_shipping_liner($shippingid,$data);
            $message='Update Data Success';
        }
        
        $this->session->set_flashdata("message", "<div class=\"alert alert-success\" id=\"alert\">$message</div>"); 
        redirect('shipping/shipping_liner');
    }
    
     public function shipping_liner_delete (){
        $this->m_shipping->delete_shipping_liner($this->input->get('line'));
      
        $this->session->set_flashdata("message", "<div class=\"alert alert-danger\" id=\"alert\">Delete Data Success</div>"); 
        redirect('shipping/shipping_liner');
    }
//    ------------------------------------------------------------------About Port--------------------------------------------------------
    public function port(){
        $data['port']=  $this->m_shipping->tampil_port();
        $data['country']=  $this->m_purchasing->tampil_country();
        
        $this->template->display('shipping/mstport',$data);
    }
    
    public function port_show(){
        $data['port']=  $this->m_shipping->tampil_port_where($this->input->get('port'));
        $data['country']=  $this->m_purchasing->tampil_country();
        
        $this->template->display('shipping/mstport_show',$data);
    }
    
    public function port_save (){
        $portid=  $this->input->post('portid');
        $portcode=  $this->input->post('code');
        $portname=  $this->input->post('name');
        $country=  $this->input->post('country');
        
        if ($portid == ''){
            $data=array('port_code'=>$portcode,'port_name'=>$portname,'country_ids'=>$country,'created_by'=> strtoupper($this->session->userdata('userid_1')),'created_date'=> date('Y-m-d H:i:s'));
            $this->m_shipping->simpan_port($data);
            $message='Save Data Success';
        } else{
            $data=array('port_code'=>$portcode,'port_name'=>$portname,'country_ids'=>$country,'updated_by'=> strtoupper($this->session->userdata('userid_1')),'updated_date'=> date('Y-m-d H:i:s'));
            $this->m_shipping->update_port($portid,$data);
            $message='Update Data Success';
        }
        
        $this->session->set_flashdata("message", "<div class=\"alert alert-success\" id=\"alert\">$message</div>"); 
        redirect('shipping/port');
    }
    
     public function port_delete (){
        $this->m_shipping->delete_port($this->input->get('port'));
      
        $this->session->set_flashdata("message", "<div class=\"alert alert-danger\" id=\"alert\">Delete Data Success</div>"); 
        redirect('shipping/port');
    }
 
//    ------------------------------------------------------------------ABOUT Container Outward--------------------------------------------------------
    public function container (){
        $data['factory']=$this->m_shipping->tampil_factory();
        $this->template->display('shipping/container_list',$data);
    }
    
    public function container_po (){
        $data['po']= $this->m_shipping->tampil_po($this->input->get('fac'),$this->input->get('schedule'),$this->input->get('po'));
        $this->load->view('shipping/container_list_po',$data);
    }
    
    public function container_po_outward (){
        $data['po']= $this->m_shipping->tampil_po_outward($this->input->get('po_cout'));
        $this->load->view('shipping/container_list_po_outward',$data);
    }
    
    public function container_stock_choice (){
        $data['stock']= $this->m_shipping->tampil_factory_stock_container($this->input->get('stock_id'));
        $this->load->view('shipping/container_stock_list_edit',$data);
    }

    public function container_modal_delete (){
        $data['cont']=  $this->m_shipping->tampil_cont_where($this->input->get('delete'));
        $this->load->view('shipping/container_list_modal_delete',$data);
    }
    
    public function container_containeroutward(){
        $data['cont']=  $this->m_shipping->tampil_cont_outward($this->input->get('cout'));
        $this->load->view('shipping/container_list_outward',$data);
    }
    
    public function container_containerall(){
        $data['cont']=  $this->m_shipping->tampil_cont($date=$this->input->get('dt'),$this->input->get('call'));
        $this->load->view('shipping/container_list_all',$data);
    }
    
    public function container_show(){
        $getID =$this->input->get('cont');
        $tipe = $this->input->get('tipe');
        
        $data['factory']=$this->m_shipping->tampil_factory();
        $data['cont']=  $this->m_shipping->tampil_cont_where($getID);
        
        if($tipe == 1){
            $this->template->display('shipping/container_list_show',$data);
        } else {
            $this->template->display('shipping/container_list_show1',$data);
        }
    }
    
    public function container_show_copy(){
        $data['cont']=  $this->m_shipping->tampil_cont_where_outward($this->input->get('cont'));
        $this->template->display('shipping/container_list_show_copy',$data);
    }
    
    public function container_save($trans){
        $contid=  $this->input->post('contid');
        $tipe=  $this->input->post('tipe');
        $shipment=  $this->convert($this->input->post('shipdate'));
        $barge=  $this->input->post('barge');
        $voyage=  $this->input->post('voyage');
        $etd=  $this->input->post('etd');
        $eta=  $this->input->post('eta');
        $etddateTemp= $this->input->post('etddate');
        $etadateTemp=  $this->input->post('etadate');
        $amendmentdateTemp=$this->input->post('amendmentdate');
        $to= $this->input->post('to');
        $from=  $this->input->post('from');
        $remarks=  nl2br($this->input->post('remarks'));

        //----------Inisiasi Field pada Container Stock
        $stock_id_dtl= $this->input->post('stock_id_dtl');
        $container_number=  $this->input->post('container_number');
        $container_id= $this->input->post('container_id');
        $container_name= $this->input->post('container_name');
        $status= $this->input->post('status');
        //--------------------------------------------
        
        if ($etddateTemp != ''){
            $etddate= $this->convert($etddateTemp);
        } else {
            $etddate= '';
        }
        
        if ($etadateTemp != ''){
            $etadate= $this->convert($etadateTemp);
        } else {
            $etadate= '';
        }
        
        if ($amendmentdateTemp != ''){
            $amendmentdate= $this->convert($amendmentdateTemp);
        } else {
            $amendmentdate= '';
        }
        
        $datahdr=array('trans'=>$trans,'contid'=>$contid,'tipe'=>$tipe,
            'barge'=>$barge,'voyage'=>$voyage,'etd'=>$etd,'etddate'=>$etddate,'eta'=>$eta,
                        'etadate'=>$etadate,'shipmentdate'=>$shipment,'from'=>$from,'to'=>$to,'amendmentdate'=>$amendmentdate,'remarks'=>$remarks,
                        'createdby'=> strtoupper($this->session->userdata('userid_1')));
        $query = $this->m_shipping->simpan_cont_sp($datahdr);
        
        if($query['flag'] == 1){
            $this->session->set_flashdata("message", "<div class=\"alert alert-success\" id=\"alert\">Transaction Success</div>"); 
            redirect('shipping/container_show?cont='.$query['contid'].'&tipe='.$tipe);
        }else{
            $this->session->set_flashdata("message", "<div class=\"alert alert-danger\" id=\"alert\">Save Transaction Broken.</div>"); 
            redirect('shipping/container');
        }
    }
    
    public function container_delete(){
        $result = $this->m_shipping->delete_cont_sp($this->input->get('cont'));
        
        if($result['flag'] == 1){
            $this->session->set_flashdata("message", "<div class=\"alert alert-danger\" id=\"alert\">Delete Data Success</div>"); 
            redirect('shipping/container');
        } else {
            $this->session->set_flashdata("message", "<div class=\"alert alert-warning\" id=\"alert\">Sorry, This Data used in Another Transaction</div>"); 
            redirect('shipping/container');
        }
        
    }


    public function container_inward_edit(){
        $cont=$this->input->get('container');
        $id=$this->input->get('id');
        $tipe=$this->input->get('tipe');
        $contid=$this->input->get('contid');
        $idold      = $this->input->get('id');
        $idnew      = $this->input->get('idnew');
        $contstock=$this->input->get('container');

        // // //===========Membuat Note status==================
        // // $this->m_shipping->container_stock_noted($contstock);


        // //==========Change Container pada Invoice=========
        // $data = array(
        //     'p_contid_old' => $idold,
        //     'p_contid_new' => $idnew
        // );
        // $hasil = $this->m_shipping->container_inward_changestock($id, $data);


        //==========change Container pada Container========
        $dataedit = array(
            'container' => $cont
        );
        $returndata = $this->m_shipping->containerinward_update($id,$dataedit);

        echo "<input type='hidden' id='hasilchange' value='$returndata->container' >";
        echo "<script>get_change($id);</script>";

    }

    function container_inward_changestock(){
        $cont=$this->input->get('container');
        $id=$this->input->get('id');
        $tipe=$this->input->get('tipe');
        $contid=$this->input->get('contid');
        $idold      = $this->input->get('id');
        $idnew      = $this->input->get('idnew');
        $contstock=$this->input->get('container');
        // $container  = $_GET['container'];
        // $idold      = $_GET['idold'];
        // $idnew      = $_GET['idnew'];
        $container  = $this->input->get('container');
        $idold      = $this->input->get('idold');
        $idnew      = $this->input->get('idnew');

        $data = array(
            'p_contid_old' => $idold,
            'p_contid_new' => $idnew
        );

        $hasil = $this->m_shipping->container_inward_changestock($data);
        //echo $hasil->v_hasil;
        
        echo "<input type='hidden' id='hasilchange' value='$hasil->v_hasil' >";
        echo "<script>alert('$hasil->v_pesan'); get_change($idold);</script>";
    //    echo "<script>get_change($id);</script>";
    }

    function container_inward_changestock2(){
        $cont=$this->input->get('container');
        $id=$this->input->get('id');
        $tipe=$this->input->get('tipe');
        $contid=$this->input->get('contid');
        $idold      = $this->input->get('id');
        $idnew      = $this->input->get('idnew');
        $contstock=$this->input->get('container');
        // $container  = $_GET['container'];
        // $idold      = $_GET['idold'];
        // $idnew      = $_GET['idnew'];
        $container  = $this->input->get('container');
        $idold      = $this->input->get('idold');
        $idnew      = $this->input->get('idnew');

        $data = array(
            'p_contid_old' => $idold,
            'p_contid_new' => $idnew
        );

        $hasil = $this->m_shipping->container_inward_changestock2($data);
        echo $hasil->v_hasil;
        
        echo "<input type='hidden' id='hasilchange' value='$hasil->v_hasil' >";
    //    echo "<script>alert('$hasil->v_pesan'); get_change($idold);</script>";
        echo "<script>get_change($id);</script>";
    }

//-------------------------------Modul Container Stock-------------------------------//
    public function container_stock_modal (){
        $data['container_name']= $this->m_shipping->tampil_container_stock_modal($this->input->get('container_name'));
        $this->load->view('shipping/container_list_stock_modal',$data);
    }


    public function cek_tabel() {
        $id = $this->input->get("id");
        $data['select_container'] = $this->m_shipping->select_container($id);
        $this->load->view('shipping/validasi_reff', $data);
    }

    function get_refnumber1(){
        $tgl = $this->input->get('tgl');
        $data['_reff'] = $this->get_refnumber($tgl);

        $this->load->view('shipping/stock_reff', $data);
    }


    function get_refnumber($tgli){
        $date = $tgli;
        $tahun = substr($tgli,0,6);
        // echo $date;
        $ini = $this->m_shipping->get_refnum(substr($tgli,2,6));

        if(empty($ini)){
            $ref = '0001'.'/'.$tahun;
            // echo $ref;
        }
        else{
             $no1 = $ini->no_reff;
             // echo $no1;
             $no2 = substr($no1,8,6);
             // echo $no2;
             $no3 = intval($no2) + 1;
             $no4 = str_pad($no3,4,0, STR_PAD_LEFT);
             $ref = $no4.'/'.$tahun;
        }
        return $ref;
        // echo $ref;
    }


    public function container_stock(){
        $data['container_number']=$this->m_shipping->tampil_factory_stock_container_list();
        $this->template->display('shipping/container_stock_list',$data);   
    }


    public function container_stock_create(){
        $data['gettype'] = $this->m_shipping->gettype();
        $this->template->display('shipping/container_stock_view',$data);   

    }

    public function container_stock_edit(){
        $id=$this->input->get('stock');
        $data['gettype'] = $this->m_shipping->gettype();
        $data['tampildatahdr'] = $this->m_shipping->get_container_stock_hdr($id);
        $data['tampildatadtl'] = $this->m_shipping->get_container_stock_dtl($id);

        $datareturn = array (

        );
        
        $this->template->display('shipping/container_stock_edit',$data);   

    }

    public function container_stock_view(){
        $id=$this->input->get('stock');
        $data['gettype'] = $this->m_shipping->gettype();
        $data['tampildatahdr'] = $this->m_shipping->get_container_stock_hdr($id);
        $data['tampildatadtl'] = $this->m_shipping->get_container_stock_dtl($id);

        $datareturn = array (

        );
        
        $this->template->display('shipping/container_stock_view_look',$data);   

    }

    public function container_stock_return(){
        $id=$this->input->get('stock');
        
        // $datareturn = array(
        //     'stock_id_dtl' => $id 
        // );

        //$this->m_shipping->container_stock_return_status($datareturn);
        $this->m_shipping->container_stock_return_status($id);
        redirect('shipping/container_stock');

    }


    public function container_stock_edit2(){
        $id=$this->input->get('stock');
        $data['gettype2'] = $this->m_shipping->gettype2();
        $data['tampildata'] = $this->m_shipping->get_container_stock($id);
        $this->template->display('shipping/container_stock_edit',$data);   

    }

//--------------------Fungsi Save Modifikasi -------------------

    public function container_stock_save (){
        $stock_id_hdr= $this->input->post('stock_id_hdr');
        $stock_id_dtl= $this->input->post('stock_id_dtl');
        $container_number=  $this->input->post('container_number');
        $container_id= $this->input->post('container_id');
        $container_name= $this->input->post('container_name');
        $loading_port=  $this->input->post('loading_port');
        $arrival_date = str_replace('/', '-', $this->input->post('arrival_date'));        
                $p_tanggal = date('Y-m-d', strtotime($arrival_date)); //tanggal jurnal
        $free_time = $this->input->post('free_time');
        $Remark= $this->input->post('Remark');
        $factory= $this->input->post('factory');
        $supplier= $this->input->post('supplier');
        $import_bl_no=  $this->input->post('import_bl_no');
        $eta = str_replace('/', '-', $this->input->post('eta'));
                $q_tanggal = date('Y-m-d', strtotime($eta)); //tanggal jurnal
        $free_time_expiry = str_replace('/', '-', $this->input->post('free_time_expiry'));
                $r_tanggal = date('Y-m-d', strtotime($free_time_expiry)); //tanggal jurnal
        $status_note='0';

        
        if ($stock_id_hdr == '' && $stock_id_dtl == ''){
            $data_hdr=array(
                'loading_port'      =>$loading_port,
                'free_time'         =>$free_time,
                'arrival_date'      =>$p_tanggal,
//                'Remark'            =>$Remark,
                'factory'           =>$factory,
                'supplier'          =>$supplier,
                'import_bl_no'      =>$import_bl_no,
                'eta'               =>$q_tanggal,
                'free_time_expiry'  =>$r_tanggal);
                $headerid=$this->m_shipping->simpan_container_stock_hdr($data_hdr);
            
            for($i=0;$i<count($container_id);$i++){
            $data_dtl=array(
                'stock_id_hdr'=> $headerid,
                'container_name'=>$container_name[$i],
                'container_number'=>$container_number[$i],
                'container_id'=>$container_id[$i],
                'Remark'=>$Remark[$i],
                'status_note'=>$status_note[$i]
            );
            $this->m_shipping->simpan_container_stock_dtl($data_dtl);
        }
            $message='Save Data Success';             
        } 

        // elseif ($stock_id_hdr != '' && $stock_id_dtl != '') {
        //     $data_hdr=array(
        //         'loading_port'      =>$loading_port,
        //         'free_time'         =>$free_time,
        //         'arrival_date'      =>$p_tanggal, 
        //         'Remark'            =>$Remark, 
        //         'factory'           =>$factory,
        //         'supplier'          =>$supplier,
        //         'import_bl_no'      =>$import_bl_no, 
        //         'eta'               =>$q_tanggal, 
        //         'free_time_expiry'  =>$r_tanggal);
        //         $headerid=$this->m_shipping->update_container_stock_hdr($data_hdr, $stock_id_hdr);

        //     for($i=0;$i<count($container_id);$i++){
        //     $data_dtl=array(
        //         'stock_id_hdr'      => $stock_id_hdr,
        //         'container_name'    => $container_name[$i],
        //         'container_number'  => $container_number[$i],
        //         'container_id'      => $container_id[$i]
        //     );
        //      $this->m_shipping->simpan_container_stock_dtl($data_dtl, $stock_id_dtl[$i]);
        // }
        //     $message='Update Data Success';
        
        // } 

        else {
            $data_hdr=array(
                'loading_port'      =>$loading_port,
                'free_time'         =>$free_time,
                'arrival_date'      =>$p_tanggal, 
//                'Remark'            =>$Remark, 
                'factory'           =>$factory,
                'supplier'          =>$supplier,
                'import_bl_no'      =>$import_bl_no, 
                'eta'               =>$q_tanggal, 
                'free_time_expiry'  =>$r_tanggal);
                $headerid=$this->m_shipping->update_container_stock_hdr($data_hdr, $stock_id_hdr);

                // echo $stock_id_hdr;
            for($i=0;$i<count($container_id);$i++){
                if ($stock_id_dtl[$i] == null){
                        $data_dtl=array(
                           'stock_id_hdr'      => $stock_id_hdr,
                            'container_name'    => $container_name[$i],
                            'container_number'  => $container_number[$i],
                            'container_id'      => $container_id[$i],
                            'Remark'      => $Remark[$i],
                            'status_note'=>$status_note[$i]
                        );
                         $this->m_shipping->simpan_container_stock_dtl($data_dtl);
                        // }
                        $message='Update Data Success';

                }else{
                    // for($i=0;$i<count($container_id);$i++){
                        // check to database 
                        $data_dtl=array(
                            'stock_id_hdr'      => $stock_id_hdr,
                            'container_name'    => $container_name[$i],
                            'container_number'  => $container_number[$i],
                            'container_id'      => $container_id[$i],
                            'Remark'            => $Remark[$i]
                        );
                        // echo $stock_id_dtl[$i];
                         $this->m_shipping->update_container_stock_dtl($data_dtl, $stock_id_dtl[$i]);
                }
                        $message='Update Data Success';
            }      
        }  
         $this->session->set_flashdata("message", "<div class=\"alert alert-success\" id=\"alert\">$message</div>"); 
         redirect('shipping/container_stock');
        //$this->session->set_flashdata("message", "<div class=\"alert alert-success\" id=\"alert\">$message</div>"); 
        //redirect('shipping/container_stock_edit?stock='.$stock_id_hdr);


    }

    public function container_stock_save_comeback (){
        $stock_id_hdr= $this->input->post('stock_id_hdr');
        $stock_id_dtl= $this->input->post('stock_id_dtl');
        $container_number=  $this->input->post('container_number');
        $container_id= $this->input->post('container_id');
        $container_name= $this->input->post('container_name');
        $loading_port=  $this->input->post('loading_port');
        $arrival_date = str_replace('/', '-', $this->input->post('arrival_date'));        
                $p_tanggal = date('Y-m-d', strtotime($arrival_date)); //tanggal jurnal
        $free_time = $this->input->post('free_time');
        $Remark= $this->input->post('Remark');
        $factory= $this->input->post('factory');
        $supplier= $this->input->post('supplier');
        $import_bl_no=  $this->input->post('import_bl_no');
        $eta = str_replace('/', '-', $this->input->post('eta'));
                $q_tanggal = date('Y-m-d', strtotime($eta)); //tanggal jurnal
        $free_time_expiry = str_replace('/', '-', $this->input->post('free_time_expiry'));
                $r_tanggal = date('Y-m-d', strtotime($free_time_expiry)); //tanggal jurnal
        $status_note='0';

        
        if ($stock_id_hdr == '' && $stock_id_dtl == ''){
            $data_hdr=array(
                'loading_port'      =>$loading_port,
                'free_time'         =>$free_time,
                'arrival_date'      =>$p_tanggal,
//                'Remark'            =>$Remark,
                'factory'           =>$factory,
                'supplier'          =>$supplier,
                'import_bl_no'      =>$import_bl_no,
                'eta'               =>$q_tanggal,
                'free_time_expiry'  =>$r_tanggal);
                $headerid=$this->m_shipping->simpan_container_stock_hdr($data_hdr);
            
            for($i=0;$i<count($container_id);$i++){
            $data_dtl=array(
                'stock_id_hdr'=> $headerid,
                'container_name'=>$container_name[$i],
                'container_number'=>$container_number[$i],
                'container_id'=>$container_id[$i],
                'Remark'=>$Remark[$i],
                'status_note'=>$status_note[$i]
            );
            $this->m_shipping->simpan_container_stock_dtl($data_dtl);
        }
            $message='Save Data Success';             
        } 

        // elseif ($stock_id_hdr != '' && $stock_id_dtl != '') {
        //     $data_hdr=array(
        //         'loading_port'      =>$loading_port,
        //         'free_time'         =>$free_time,
        //         'arrival_date'      =>$p_tanggal, 
        //         'Remark'            =>$Remark, 
        //         'factory'           =>$factory,
        //         'supplier'          =>$supplier,
        //         'import_bl_no'      =>$import_bl_no, 
        //         'eta'               =>$q_tanggal, 
        //         'free_time_expiry'  =>$r_tanggal);
        //         $headerid=$this->m_shipping->update_container_stock_hdr($data_hdr, $stock_id_hdr);

        //     for($i=0;$i<count($container_id);$i++){
        //     $data_dtl=array(
        //         'stock_id_hdr'      => $stock_id_hdr,
        //         'container_name'    => $container_name[$i],
        //         'container_number'  => $container_number[$i],
        //         'container_id'      => $container_id[$i]
        //     );
        //      $this->m_shipping->simpan_container_stock_dtl($data_dtl, $stock_id_dtl[$i]);
        // }
        //     $message='Update Data Success';
        
        // } 

        else {
            $data_hdr=array(
                'loading_port'      =>$loading_port,
                'free_time'         =>$free_time,
                'arrival_date'      =>$p_tanggal, 
//                'Remark'            =>$Remark, 
                'factory'           =>$factory,
                'supplier'          =>$supplier,
                'import_bl_no'      =>$import_bl_no, 
                'eta'               =>$q_tanggal, 
                'free_time_expiry'  =>$r_tanggal);
                $headerid=$this->m_shipping->update_container_stock_hdr($data_hdr, $stock_id_hdr);

                // echo $stock_id_hdr;
            for($i=0;$i<count($container_id);$i++){
                if ($stock_id_dtl[$i] == null){
                        $data_dtl=array(
                           'stock_id_hdr'      => $stock_id_hdr,
                            'container_name'    => $container_name[$i],
                            'container_number'  => $container_number[$i],
                            'container_id'      => $container_id[$i],
                            'Remark'      => $Remark[$i],
                            'status_note'=>$status_note[$i]
                        );
                         $this->m_shipping->simpan_container_stock_dtl($data_dtl);
                        // }
                        $message='Update Data Success';

                }else{
                    // for($i=0;$i<count($container_id);$i++){
                        // check to database 
                        $data_dtl=array(
                            'stock_id_hdr'      => $stock_id_hdr,
                            'container_name'    => $container_name[$i],
                            'container_number'  => $container_number[$i],
                            'container_id'      => $container_id[$i],
                            'Remark'            => $Remark[$i]
                        );
                        // echo $stock_id_dtl[$i];
                         $this->m_shipping->update_container_stock_dtl($data_dtl, $stock_id_dtl[$i]);
                }
                        $message='Update Data Success';
            }      
        }  
         $this->session->set_flashdata("message", "<div class=\"alert alert-success\" id=\"alert\">$message</div>"); 
         redirect('shipping/comeback_container_stock');
        //$this->session->set_flashdata("message", "<div class=\"alert alert-success\" id=\"alert\">$message</div>"); 
        //redirect('shipping/container_stock_edit?stock='.$stock_id_hdr);


    }

//---------------------Fungsi Save---------------


     public function container_stock_delete (){
        $id=$this->input->get('stock');
        // echo $id;
        $this->m_shipping->delete_container_stock($id);
        redirect('shipping/container_stock');
    }

     public function container_stock_delete_modal (){
        $id=$this->input->get('stock');
        // echo $id;
        $this->m_shipping->delete_container_stock($id);
        redirect('shipping/container_stock');
    }



//------------------------------------------------PRINT-----------------------------------------------------------------------------------
     public function container_print(){
        $contid =$this->input->get('cont');
        $tipe = $this->input->get('tipe');
        
        if($tipe == 1){
            $this->container_print_outward($contid);
        } else {
           $this->container_print_inward($contid); 
        }
        
    }
    
    public function container_print_outward(){
        $data['_getcont'] =  $this->m_shipping->tampil_cont_where($this->input->get('cont'));
     
        $this->load->view('shipping/printout/container_print_outward_fpdf',$data);
    }
    
    public function container_print_inward(){
        $data['_getcont'] =  $this->m_shipping->tampil_cont_where($this->input->get('cont'));
     
        $this->load->view('shipping/printout/container_print_inward_fpdf',$data);
    }
 
     public function container_print_stock(){
        $data['getstock'] =  $this->m_shipping->tampil_stock_where($this->input->get('stock'));
     
        //$this->load->view('shipping/printout/container_print_stock_fpdf',$data);
        $this->load->view('shipping/printout/container_print_stock_fpdf',$data);
    }
    
    public function container_outward_excel(){
        error_reporting(E_ALL);
        ini_set('display_errors', TRUE);
        ini_set('display_startup_errors', TRUE);
        date_default_timezone_set('Europe/London');
        
        $data =  $this->m_shipping->tampil_cont_where($this->input->get('cont'));
        
        if (PHP_SAPI == 'cli')
            die('This example should only be run from a Web Browser');
        // require_once dirname(__FILE__) . '/../libraries/PHPExcel.php';
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(10);
        
        $objPHPExcel->getActiveSheet()->getStyle(2)->getFont()->setBold(true)
                ->getActiveSheet()->getStyle('G2')->getFont()->setSize(18)
                ->getActiveSheet()->getStyle(3)->getFont()->setBold(true)
                ->getActiveSheet()->getStyle(4)->getFont()->setBold(true)
                ->getActiveSheet()->getStyle(5)->getFont()->setBold(true)
                ->getActiveSheet()->getStyle(7)->getFont()->setBold(true)
                ->getActiveSheet()->getStyle(7)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
        $objDrawing = new PHPExcel_Worksheet_Drawing();
        $objDrawing->setName('Logo');
        $objDrawing->setDescription('Logo');
        $logo = 'assets/ZHL-Report.png';
        $objDrawing->setPath($logo);
        $objDrawing->setCoordinates('D2');
        $objDrawing->setHeight(80);
        $objDrawing->setWorksheet($objPHPExcel->getActiveSheet()); 

        foreach ($data as $r){
            $shipmentdate=date("dmy",  strtotime($r->shipmentdate));
            $barge=$r->barge;
            $voyage=$r->voyage;
            $etd=$r->etd;
            $etddate=date("d/m/Y",  strtotime($r->etddate));
            $eta=$r->eta;
            $etadate=date("d/m/Y",  strtotime($r->etadate));
            $shipment=date("d M Y",  strtotime($r->shipmentdate));
            $to=$r->to;
            $remark=str_replace("<br />", "",$r->remarks);
            $createdby=$r->createdby;
            $stuffing=$r->stuffing;
        }

        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A2', 'Vessel (Barge) :')
                ->setCellValue('C2', $barge)
                ->setCellValue('A3', 'Voyage :')
                ->setCellValue('C3', $voyage.' ')
                ->setCellValue('A4', 'ETD '.$etd.' :')
                ->setCellValue('C4', $etddate)
                ->setCellValue('A5', 'ETA '.$eta.' :')
                ->setCellValue('C5', $etadate)
                ->setCellValue('G2', 'ZHENGHE LOGISTIC PTE LTD')
                ->setCellValue('G4', 'Container Outward List')
                ->setCellValue('G5', 'Shipment Date : '.$shipment)
                ->setCellValue('J4', 'To : '.$to)
                ->setCellValue('J5', 'From : '.$createdby)
                ->setCellValue('A7', 'No')
                ->setCellValue('B7', 'Shipper/Carrier')
                ->setCellValue('C7', 'Vessel/Voyage')
                ->setCellValue('D7', "20'")
                ->setCellValue('E7', "40'")
                ->setCellValue('F7', 'CT')
                ->setCellValue('G7', 'Booking Ref')
                ->setCellValue('H7', 'Depot')
                ->setCellValue('I7', 'POD')
                ->setCellValue('J7', 'Final Dest')
                ->setCellValue('K7', 'OP Code')
                ->setCellValue('L7', 'ETA Sin')
                ->setCellValue('M7', 'Stuffing');
        
         $no=1;$counter = 8;$C20=0;$C40=0;
         foreach($data as $v):
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A'.$counter, $no++)
                ->setCellValue('B'.$counter, $v->shipping_liner)
                ->setCellValue('C'.$counter, $v->vessel)
                ->setCellValue('D'.$counter, $v->c20)
                ->setCellValue('E'.$counter, $v->c40)
                ->setCellValue('F'.$counter, $v->container_abbr)
                ->setCellValue('G'.$counter, $v->reff)
                ->setCellValue('H'.$counter, $v->depot)
                ->setCellValue('I'.$counter, $v->pod)
                ->setCellValue('J'.$counter, $v->destination)
                ->setCellValue('K'.$counter, $v->opcode)
                ->setCellValue('L'.$counter, $v->etdsin)
                ->setCellValue('M'.$counter, $v->stuffing);
             $counter++;$C20 += $v->c20;$C40 += $v->c40;
         endforeach;
         
         $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('D'.$counter, $C20)
                ->setCellValue('E'.$counter, $C40);
       
        $objPHPExcel->getActiveSheet()->getStyle('A7:M7')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('A7:M7')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('A7:A'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('B7:B'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('C7:C'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('D7:D'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('E7:E'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('F7:F'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('G7:G'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('H7:H'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('I7:I'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('J7:J'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('K7:K'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('L7:L'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('M7:M'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('A'.$counter.':M'.$counter)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('A'.$counter.':M'.$counter)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        
        $counter++;
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A'.$counter, 'REMARKS')
                ->setCellValue('A'.$counter++, $remark);
        
        $objPHPExcel->getActiveSheet()->setTitle('Container Outward');
        $objPHPExcel->setActiveSheetIndex(0);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Container Outward '.$shipmentdate.'.xlsx"');
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');
        header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
        header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header ('Pragma: public'); // HTTP/1.0
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
        exit;
    }
    
    public function container_inward_excel(){
        error_reporting(E_ALL);
        ini_set('display_errors', TRUE);
        ini_set('display_startup_errors', TRUE);
        date_default_timezone_set('Europe/London');
        
        $data =  $this->m_shipping->tampil_cont_where($this->input->get('cont'));
        
        if (PHP_SAPI == 'cli')
            die('This example should only be run from a Web Browser');
        // require_once dirname(__FILE__) . '/../libraries/PHPExcel.php';
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(10);
//        $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(10);
        
        $objPHPExcel->getActiveSheet()->getStyle(2)->getFont()->setBold(true)
                ->getActiveSheet()->getStyle('G2')->getFont()->setSize(18)
                ->getActiveSheet()->getStyle(3)->getFont()->setBold(true)
                ->getActiveSheet()->getStyle(4)->getFont()->setBold(true)
                ->getActiveSheet()->getStyle(5)->getFont()->setBold(true)
                ->getActiveSheet()->getStyle(7)->getFont()->setBold(true)
                ->getActiveSheet()->getStyle(7)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
        $objDrawing = new PHPExcel_Worksheet_Drawing();
        $objDrawing->setName('Logo');
        $objDrawing->setDescription('Logo');
        $logo = 'assets/ZHL-Report.png';
        $objDrawing->setPath($logo);
        $objDrawing->setCoordinates('E2');
        $objDrawing->setHeight(60);
        $objDrawing->setWorksheet($objPHPExcel->getActiveSheet()); 

        foreach ($data as $r){
            $shipmentdate=date("dmy",  strtotime($r->shipmentdate));
            $barge=$r->barge;
            $voyage=$r->voyage;
            $etd=$r->etd;
            $etddate=date("d/m/Y",  strtotime($r->etddate));
            $eta=$r->eta;
            $etadate=date("d/m/Y",  strtotime($r->etadate));
            $shipment=date("d M Y",  strtotime($r->shipmentdate));
            $to=$r->to;
            $from=$r->from;
            $remarks=str_replace("<br />", "",$r->remarks);
//            $stuffing=$r->stuffing;
        }

        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A2', 'Vessel (Barge) :')
                ->setCellValue('C2', $barge)
                ->setCellValue('A3', 'Voyage :')
                ->setCellValue('C3', $voyage.' ')
                ->setCellValue('A4', 'ETD '.$etd.' :')
                ->setCellValue('C4', $etddate)
                ->setCellValue('A5', 'ETA '.$eta.' :')
                ->setCellValue('C5', $etadate)
                ->setCellValue('G2', 'ZHENGHE LOGISTIC PTE LTD')
                ->setCellValue('G4', 'Container Inward List')
                ->setCellValue('G5', 'Shipment Date : '.$shipment)
                ->setCellValue('J4', 'Shipment From : '.$from)
                ->setCellValue('J5', 'To : '.$to)
                ->setCellValue('A7', 'No')
                ->setCellValue('B7', 'Container No')
                ->setCellValue('C7', 'Seal No')
                ->setCellValue('D7', "20'")
                ->setCellValue('E7', "40'")
                ->setCellValue('F7', 'CT')
                ->setCellValue('G7', 'Vessel Voyage')
                ->setCellValue('H7', 'Eta Sin')
                ->setCellValue('I7', 'POD')
                ->setCellValue('J7', 'Destination')
                ->setCellValue('K7', 'OP/SO')
                ->setCellValue('L7', 'Carrier')
                ->setCellValue('M7', 'Weight');
//                ->setCellValue('N7', 'Stuffing');
        
         $no=1;$counter = 8;$C20=0;$C40=0;
         foreach($data as $v):
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A'.$counter, $no++)
                ->setCellValue('B'.$counter, $v->container)
                ->setCellValue('C'.$counter, $v->seal)
                ->setCellValue('D'.$counter, $v->c20)
                ->setCellValue('E'.$counter, $v->c40)
                ->setCellValue('F'.$counter, $v->container_abbr)
                ->setCellValue('G'.$counter, $v->vessel)
                ->setCellValue('H'.$counter, $v->etdsin)
                ->setCellValue('I'.$counter, $v->pod)
                ->setCellValue('J'.$counter, $v->destination)
                ->setCellValue('K'.$counter, $v->opcode)
                ->setCellValue('L'.$counter, $v->shipping_liner)
                ->setCellValue('M'.$counter, number_format($v->weight,3));
//                ->setCellValue('N'.$counter, $v->stuffing);
             $counter++;$C20 += $v->c20;$C40 += $v->c40;
         endforeach;
         
         $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('D'.$counter, $C20)
                ->setCellValue('E'.$counter, $C40);
       
        $objPHPExcel->getActiveSheet()->getStyle('A7:M7')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('A7:M7')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('A7:A'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('B7:B'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('C7:C'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('D7:D'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('E7:E'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('F7:F'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('G7:G'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('H7:H'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('I7:I'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('J7:J'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('K7:K'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('L7:L'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('M7:M'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
//                ->getActiveSheet()->getStyle('N7:N'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('A'.$counter.':M'.$counter)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('A'.$counter.':M'.$counter)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        
        $counter++;
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$counter, $remarks);
        
        $objPHPExcel->getActiveSheet()->setTitle('Container Inward');
        $objPHPExcel->setActiveSheetIndex(0);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Container Inward '.$shipmentdate.'.xlsx"');
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');
        header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
        header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header ('Pragma: public'); // HTTP/1.0
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
        exit;
    }
    
    public function container_stock_excel(){
        error_reporting(E_ALL);
        ini_set('display_errors', TRUE);
        ini_set('display_startup_errors', TRUE);
        date_default_timezone_set('Europe/London');
        
        $data =  $this->m_shipping->tampil_stock_where($this->input->get('stock'));
        //$data['tampildatasemua'] = $this->m_shipping->get_container_stock_semua($id);
        
        if (PHP_SAPI == 'cli')
            die('This example should only be run from a Web Browser');
        // require_once dirname(__FILE__) . '/../libraries/PHPExcel.php';
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(30);
        
        $objPHPExcel->getActiveSheet()->getStyle(2)->getFont()->setBold(true)
                ->getActiveSheet()->getStyle('G2')->getFont()->setSize(18)
                ->getActiveSheet()->getStyle(3)->getFont()->setBold(true)
                ->getActiveSheet()->getStyle(4)->getFont()->setBold(true)
                ->getActiveSheet()->getStyle(5)->getFont()->setBold(true)
                ->getActiveSheet()->getStyle(7)->getFont()->setBold(true)
                ->getActiveSheet()->getStyle(7)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
        $objDrawing = new PHPExcel_Worksheet_Drawing();
        $objDrawing->setName('Logo');
        $objDrawing->setDescription('Logo');
        $logo = 'assets/ZHL-Report.png';
        $objDrawing->setPath($logo);
        $objDrawing->setCoordinates('F2');
        $objDrawing->setHeight(80);
        $objDrawing->setWorksheet($objPHPExcel->getActiveSheet()); 

        foreach ($data as $r){
            // $shipmentdate=date("dmy",  strtotime($r->shipmentdate));
            // $barge=$r->barge;
            // $voyage=$r->voyage;
            // $etd=$r->etd;
            // $etddate=date("d/m/Y",  strtotime($r->etddate));
            // $eta=$r->eta;
            // $etadate=date("d/m/Y",  strtotime($r->etadate));
            // $shipment=date("d M Y",  strtotime($r->shipmentdate));
            // $to=$r->to;
            // $remark=str_replace("<br />", "",$r->remarks);
            // $createdby=$r->createdby;
                $stock_id_hdr      = $r->stock_id_hdr;
                $stock_id_dtl      = $r->stock_id_dtl;
                $container_number  = $r->container_number;
                $container_id      = $r->container_id;
                $container_name    = $r->container_name;
                $loading_port      = $r->loading_port;
                // $arrival_date = str_replace('/', '-', $this->input->post('arrival_date'));        
                //         $p_tanggal = date('Y-m-d', strtotime($arrival_date)); //tanggal jurnal
                $arrival_date      = date('Y-m-d', strtotime($r->arrival_date)); //tanggal jurnal
                $free_time         = $r->free_time;
                $Remark            = $r->Remark;
                $factory           = $r->factory;
                $supplier          = $r->supplier;
                $import_bl_no      = $r->import_bl_no;
                $eta               = date('Y-m-d', strtotime($r->eta)); //tanggal jurnal
                $free_time_expiry  = date('Y-m-d', strtotime($r->free_time_expiry)); //tanggal jurnal
        }

        $objPHPExcel->setActiveSheetIndex(0)
                // ->setCellValue('A2', 'Vessel (Barge) :')
                // ->setCellValue('C2', ' ')
                // ->setCellValue('A3', 'Voyage :')
                // ->setCellValue('C3', ' ')
                // ->setCellValue('A4', 'ETD :')
                // ->setCellValue('C4', ' ')
                // ->setCellValue('A5', 'ETA :')
                // ->setCellValue('C5', ' ')
                ->setCellValue('G2', 'ZHENGHE LOGISTIC PTE LTD')
                ->setCellValue('G4', 'Container Stock List')
                //->setCellValue('G5', 'Shipment Date : ')
                ->setCellValue('J4', 'To : ')
                ->setCellValue('J5', 'From : ')
                ->setCellValue('A7', 'No')
                ->setCellValue('B7', 'Container Type')
                ->setCellValue('C7', 'Container Number')
                ->setCellValue('D7', 'Import BL No')
                ->setCellValue('E7', 'Loading Port')
                ->setCellValue('F7', 'Remark')
                ->setCellValue('G7', 'Factory')
                ->setCellValue('H7', 'Arrival Date')
                ->setCellValue('I7', 'Free Time')
                ->setCellValue('J7', 'Estimation Time Arrival')
                ->setCellValue('K7', 'Expiry Date')
                ->setCellValue('L7', 'Supplier');
        
         $no=1;$counter = 8;
         // //$C20=0;$C40=0;
         foreach($data as $v):
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A'.$counter, $no++)
                ->setCellValue('B'.$counter, $v->container_name)
                ->setCellValue('C'.$counter, $v->container_number)
                ->setCellValue('D'.$counter, $v->import_bl_no)
                ->setCellValue('E'.$counter, $v->loading_port)
                ->setCellValue('F'.$counter, $v->Remark)
                ->setCellValue('G'.$counter, $v->factory)
                ->setCellValue('H'.$counter, $v->arrival_date)
                ->setCellValue('I'.$counter, $v->free_time)
                ->setCellValue('J'.$counter, $v->eta)
                ->setCellValue('K'.$counter, $v->free_time_expiry)
                ->setCellValue('L'.$counter, $v->supplier);
             $counter++;
             //$C20 += $v->c20;$C40 += $v->c40;
         endforeach;
         
         // $objPHPExcel->setActiveSheetIndex(0)
         //        ->setCellValue('D'.$counter, $C20)
         //        ->setCellValue('E'.$counter, $C40);
       
        $objPHPExcel->getActiveSheet()->getStyle('A7:L7')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('A7:l7')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('A7:A'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('B7:B'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('C7:C'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('D7:D'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('E7:E'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('F7:F'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('G7:G'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('H7:H'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('I7:I'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('J7:J'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('K7:K'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('L7:L'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('A'.$counter.':L'.$counter)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('A'.$counter.':L'.$counter)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        
        // $counter++;
        // $objPHPExcel->setActiveSheetIndex(0)
        //         ->setCellValue('A'.$counter, 'REMARKS')
        //         ->setCellValue('A'.$counter++, $remark);
        
        $objPHPExcel->getActiveSheet()->setTitle('Container Stock');
        $objPHPExcel->setActiveSheetIndex(0);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Container Stock.xlsx"');
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');
        header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
        header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header ('Pragma: public'); // HTTP/1.0
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
        exit;
    }

    public function container_stock_all_excel(){
        error_reporting(E_ALL);
        ini_set('display_errors', TRUE);
        ini_set('display_startup_errors', TRUE);
        date_default_timezone_set('Europe/London');

        //$data =  $this->m_shipping->get_container_stock_semua($this->input->get('stock'));
        $data =  $this->m_shipping->tampil_factory_stock_container();

        if (PHP_SAPI == 'cli')
            die('This example should only be run from a Web Browser');
        // require_once dirname(__FILE__) . '/../libraries/PHPExcel.php';
        $objPHPExcel = new PHPExcel();
 
        // // Set Color
        // $objPHPExcel = new PHPExcel_Style_Color();
        // $objPHPExcel->setRGB("FFF443");
        // $objPHPExcel->getStyle('B5:Z5')->getFont()->setColor($objPHPExcel);
        // $objPHPExcel->getStyle('D4')->getFont()->setColor($objPHPExcel);
        // $objPHPExcel->getStyle('B6:C6')->getFont()->setBold(true);
        // $objPHPExcel->getStyle('B2:B3')->getFont()->setBold(true);
        // //=========

        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(30);
        
        $objPHPExcel->getActiveSheet()->getStyle(2)->getFont()->setBold(true)
                ->getActiveSheet()->getStyle('G2')->getFont()->setSize(18)
                ->getActiveSheet()->getStyle(3)->getFont()->setBold(true)
                ->getActiveSheet()->getStyle(4)->getFont()->setBold(true)
                ->getActiveSheet()->getStyle(5)->getFont()->setBold(true)
                ->getActiveSheet()->getStyle(7)->getFont()->setBold(true)
                ->getActiveSheet()->getStyle(7)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
        $objDrawing = new PHPExcel_Worksheet_Drawing();
        $objDrawing->setName('Logo');
        $objDrawing->setDescription('Logo');
        $logo = 'assets/ZHL-Report.png';
        $objDrawing->setPath($logo);
        $objDrawing->setCoordinates('F2');
        $objDrawing->setHeight(80);
        $objDrawing->setWorksheet($objPHPExcel->getActiveSheet()); 

        foreach ($data as $r){
            // $shipmentdate=date("dmy",  strtotime($r->shipmentdate));
            // $barge=$r->barge;
            // $voyage=$r->voyage;
            // $etd=$r->etd;
            // $etddate=date("d/m/Y",  strtotime($r->etddate));
            // $eta=$r->eta;
            // $etadate=date("d/m/Y",  strtotime($r->etadate));
            // $shipment=date("d M Y",  strtotime($r->shipmentdate));
            // $to=$r->to;
            // $remark=str_replace("<br />", "",$r->remarks);
            // $createdby=$r->createdby;
                $stock_id_hdr      = $r->stock_id_hdr;
                $stock_id_dtl      = $r->stock_id_dtl;
                $container_number  = $r->container_number;
                $container_id      = $r->container_id;
                $container_name    = $r->container_name;
                $loading_port      = $r->loading_port;
                // $arrival_date = str_replace('/', '-', $this->input->post('arrival_date'));        
                //         $p_tanggal = date('Y-m-d', strtotime($arrival_date)); //tanggal jurnal
                $arrival_date      = date('Y-m-d', strtotime($r->arrival_date)); //tanggal jurnal
                $free_time         = $r->free_time;
                $Remark            = $r->Remark;
                $factory           = $r->factory;
                $supplier          = $r->supplier;
                $import_bl_no      = $r->import_bl_no;
                $eta               = date('Y-m-d', strtotime($r->eta)); //tanggal jurnal
                $free_time_expiry  = date('Y-m-d', strtotime($r->free_time_expiry)); //tanggal jurnal
        }

        $objPHPExcel->setActiveSheetIndex(0)
                // ->setCellValue('A2', 'Vessel (Barge) :')
                // ->setCellValue('C2', ' ')
                // ->setCellValue('A3', 'Voyage :')
                // ->setCellValue('C3', ' ')
                // ->setCellValue('A4', 'ETD :')
                // ->setCellValue('C4', ' ')
                // ->setCellValue('A5', 'ETA :')
                // ->setCellValue('C5', ' ')
                ->setCellValue('G2', 'ZHENGHE LOGISTIC PTE LTD')
                ->setCellValue('G4', 'Container Stock List :')
                //->setCellValue('G5', 'Shipment Date : ')
                ->setCellValue('J4', 'To : ')
                ->setCellValue('J5', 'From : ')
                ->setCellValue('A7', 'No')
                ->setCellValue('B7', 'Container Type')
                ->setCellValue('C7', 'Container Number')
                ->setCellValue('D7', 'Import BL No')
                ->setCellValue('E7', 'Loading Port')
                ->setCellValue('F7', 'Remark')
                ->setCellValue('G7', 'Factory')
                ->setCellValue('H7', 'Arrival Date')
                ->setCellValue('I7', 'Free Time')
                ->setCellValue('J7', 'Estimation Time Arrival')
                ->setCellValue('K7', 'Expiry Date')
                ->setCellValue('L7', 'Supplier');
        
         $no=1;$counter = 8;
         // //$C20=0;$C40=0;
         foreach($data as $v):
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A'.$counter, $no++)
                ->setCellValue('B'.$counter, $v->container_name)
                ->setCellValue('C'.$counter, $v->container_number)
                ->setCellValue('D'.$counter, $v->import_bl_no)
                ->setCellValue('E'.$counter, $v->loading_port)
                ->setCellValue('F'.$counter, $v->Remark)
                ->setCellValue('G'.$counter, $v->factory)
                ->setCellValue('H'.$counter, $v->arrival_date)
                ->setCellValue('I'.$counter, $v->free_time)
                ->setCellValue('J'.$counter, $v->eta)
                ->setCellValue('K'.$counter, $v->free_time_expiry)
                ->setCellValue('L'.$counter, $v->supplier);
             $counter++;
             //$C20 += $v->c20;$C40 += $v->c40;
         endforeach;
         
         // $objPHPExcel->setActiveSheetIndex(0)
         //        ->setCellValue('D'.$counter, $C20)
         //        ->setCellValue('E'.$counter, $C40);
       
        $objPHPExcel->getActiveSheet()->getStyle('A7:L7')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('A7:l7')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('A7:A'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('B7:B'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('C7:C'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('D7:D'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('E7:E'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('F7:F'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('G7:G'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('H7:H'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('I7:I'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('J7:J'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('K7:K'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('L7:L'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('A'.$counter.':L'.$counter)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('A'.$counter.':L'.$counter)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        
        // $counter++;
        // $objPHPExcel->setActiveSheetIndex(0)
        //         ->setCellValue('A'.$counter, 'REMARKS')
        //         ->setCellValue('A'.$counter++, $remark);
        
        $objPHPExcel->getActiveSheet()->setTitle('Container Stock All');
        $objPHPExcel->setActiveSheetIndex(0);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Container Stock All.xlsx"');
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');
        header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
        header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header ('Pragma: public'); // HTTP/1.0
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
        exit;
    }

    public function container_loading(){
        $this->template->display('shipping/container_loading');
    }
    
    public function container_loading_filter_cont(){
        $data['inward']= $this->m_shipping->tampil_po_inward($this->input->get('filter'));
        $this->load->view('shipping/container_loading_cont',$data);
    }
    
    public function container_loadingall(){
        $data['loading']=  $this->m_shipping->tampil_container_loading($this->input->get('loadall'));
        $this->load->view('shipping/container_loading_all',$data);
    }
    
    public function container_loading_modal_delete(){
        $data['loading']=  $this->m_shipping->tampil_container_loading_where($this->input->get('delete'));
        $this->load->view('shipping/container_loading_modal_delete',$data);
    }
    
    public function container_loading_show(){
        $data['loading']=  $this->m_shipping->tampil_container_loading_where($this->input->get('load'));
        $this->template->display('shipping/container_loading_show',$data);
    }
    
    public function container_loading_save($trans){
        $id=  $this->input->post('id');
        $docdate=  $this->convert($this->input->post('docdate'));
        $barge=  $this->input->post('barge');
        $voyage=  $this->input->post('voyage');
        $etasin=  $this->convert($this->input->post('etasin'));
        $to=  $this->input->post('to');
        $attn=  $this->input->post('attn');
        $from=  $this->input->post('from');
        $remarks=  $this->input->post('remarks');
        
        $dataHdr=array('trans'=>$trans,'id'=>$id,'docdate'=>$docdate,'barge'=>$barge,'voyage'=>$voyage,'etasin'=>$etasin,
                'to'=>$to,'attn'=>$attn,'from'=>$from,'remarks'=>$remarks,'createdby'=>  strtoupper($this->session->userdata('userid_1')));
        
        $query=  $this->m_shipping->simpan_cont_l_sp($dataHdr);
        
        if ($query['flag'] == 1){
            $this->session->set_flashdata("message","<div class=\"alert alert-success\" id=\"alert\">Transaction Success</div>");
            redirect('shipping/container_loading_show?load='.$query['headerid']);
        } else {
            $this->session->set_flashdata("message","<div class=\"alert alert-danger\" id=\"alert\">Save Transaction Broken</div>");
            redirect('shipping/container_loading');
        }
    }
    
    public function container_loading_delete(){
        $query = $this->m_shipping->delete_cont_l_sp($this->input->get('load'));
        
        if($query['flag'] == 1) {
            $this->session->set_flashdata("message","<div class=\"alert alert-danger\" id=\"alert\">Delete Data Success</div>");
            redirect('shipping/container_loading'); 
        } else {
            $this->session->set_flashdata("message","<div class=\"alert alert-warning\" id=\"alert\">Delete Data Broken</div>");
            redirect('shipping/container_loading');
        }
    }
    
    public function container_loading_print(){
        $data['_getcont']=  $this->m_shipping->tampil_container_loading_where($this->input->get('load'));
        
        $this->load->view('shipping/printout/container_print_loading_fpdf.php',$data);
    }
    
    public function container_loading_excel(){
        error_reporting(E_ALL);
        ini_set('display_errors', TRUE);
        ini_set('display_startup_errors', TRUE);
        date_default_timezone_set('Europe/London');
        
        $data =  $this->m_shipping->tampil_container_loading_where($this->input->get('load'));
        
        if (PHP_SAPI == 'cli')
            die('This example should only be run from a Web Browser');
        // require_once dirname(__FILE__) . '/../libraries/PHPExcel.php';
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(35);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(35);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(45);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(35);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(40);
        
        $objPHPExcel->getActiveSheet()->getStyle(2)->getFont()->setBold(true)
                ->getActiveSheet()->getStyle('B2')->getFont()->setSize(18)
                ->getActiveSheet()->getStyle(9)->getFont()->setBold(true)
                ->getActiveSheet()->getStyle(10)->getFont()->setBold(true)
                ->getActiveSheet()->getStyle(10)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
                ->getActiveSheet()->getStyle(11)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
//        $objDrawing = new PHPExcel_Worksheet_Drawing();
//        $objDrawing->setName('Logo');
//        $objDrawing->setDescription('Logo');
//        $logo = 'assets/ps.png';
//        $objDrawing->setPath($logo);
//        $objDrawing->setCoordinates('D2');
//        $objDrawing->setHeight(80);
//        $objDrawing->setWorksheet($objPHPExcel->getActiveSheet()); 

        foreach ($data as $r){
            $date=date("d/m/Y",  strtotime($r->docdate));
            $to=$r->to;
            $attn=$r->attn;
            $from=$r->from;
            $carrier=$r->carrier;
            $voyage=$r->voyage;
            $eta=date("d/m/Y",  strtotime($r->etasin));
        }

        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A4', 'DATE')
                ->setCellValue('C4', ': '.$date)
                ->setCellValue('A5', 'TO')
                ->setCellValue('C5', ': '.$to)
                ->setCellValue('A6', 'ATTN')
                ->setCellValue('C6', ': '.$attn)
                ->setCellValue('A7', 'FROM')
                ->setCellValue('C7', ': '.$from)
                ->setcellvalue('A9','RE :')
                ->setcellvalue('C9','LOADING CONFIRMATION')
                ->setCellValue('D10','PORTNET DECLARATION')
                ->setCellValue('A11', 'CONTAINER NO')
                ->setCellValue('B11', 'BOOKING REFF')
                ->setCellValue('C11', 'VESSEL / VOYAGE')
                ->setCellValue('D11', 'PORT OF DISCH')
                ->setCellValue('E11', 'DESTINATION');
        
         $counter = 12;
         foreach($data as $v):
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A'.$counter, $v->container)
                ->setCellValue('B'.$counter, $v->reff)
                ->setCellValue('C'.$counter, $v->vessel)
                ->setCellValue('D'.$counter, $v->port)
                ->setCellValue('E'.$counter, $v->destination);
             $counter++;
         endforeach;
         
        $objPHPExcel->getActiveSheet()->getStyle('D10:E10')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('A11:E11')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('A11:E11')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('A11:A'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('B11:B'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('C10:C'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('D10:D'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('E10:E'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('A'.$counter.':E'.$counter)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        
        $counter++;
        
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A'.$counter, '1st Carrier')
                ->setCellValue('C'.$counter, ': '.$carrier);$counter++;
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A'.$counter, 'Voyage')
                ->setCellValue('C'.$counter, $voyage);$counter++;
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A'.$counter, 'ETA Sin')
                ->setCellValue('C'.$counter, $eta);$counter++;
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A'.$counter, 'PLS CONFIRM ALL DETAILS ARE CORRECT BEFORE 1ST CARRIER ARRIVAL');$counter++;
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A'.$counter, 'CONTAINER MUST BE STOWE "UNDER DECK AWAY BOILER"');$counter++;
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A'.$counter, 'CONTAINER ARE DECLARED UNDER TRANSSHIPMENT');$counter++;
        $objPHPExcel->setActiveSheetIndex(0)
                ->setcellvalue('A'.$counter, 'PLS INFORM US IMMEDIATELY OF ANY DISCREPANCY BEFORE 1st CARRIER ARRIVAL');
        
        $objPHPExcel->getActiveSheet()->setTitle('Loading Confirmation');
        $objPHPExcel->setActiveSheetIndex(0);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Loading Confirmation '.date("dmy").'.xlsx"');
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');
        header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
        header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header ('Pragma: public'); // HTTP/1.0
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
        exit;
    }

//---------------------------------------------------------------------EXTRA-----------------------------------------------------
    public function convert($date){
        $explode=explode("-", $date);
        
        $time=$explode[2].'/'.$explode[1].'/'.$explode[0];
        
        return $time;
    }
//--------------------------------------------------------------------END----------------------------------------------------------------
}