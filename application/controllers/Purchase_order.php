<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Purchase_order extends CI_Controller {
	
	 function __construct() {
		parent::__construct();
        if (!$this->session->userdata('userid_1')) {
            redirect('login');
        }
        $this->load->model(array('M_mar_product', 'M_mar_misc','m_purchasing'));
	 }

	public function index (){
        $data['cur']=  $this->m_purchasing->tampil_cur();
        $data['rate']=  $this->m_purchasing->tampil_po_rate('SGD',date("Y-m-d"));
        $data['whs']=  $this->m_purchasing->tampil_whs('');
        $data['term']=  $this->m_purchasing->tampil_trade();
        $data['cust']=  $this->m_purchasing->tampil_cust('');
        $data['country']=$this->m_purchasing->tampil_country();
        $this->template->display('purchasing/purchase_order',$data);
    }
    public function purchase_order_Show(){
        $data['po']=  $this->m_purchasing_po->tampil_po_where($this->input->get('po'));
        $data['cur']=  $this->m_purchasing->tampil_cur();
        $data['whs']=  $this->m_purchasing->tampil_whs('');
        $data['term']=  $this->m_purchasing->tampil_trade();
        $data['cust']=  $this->m_purchasing->tampil_cust('');
        $data['country']=$this->m_purchasing->tampil_country();
        $this->template->display('purchasing/purchase_order_show',$data);
    }
    
    public function purchase_order_supp(){
        $data['supp']=  $this->m_purchasing->tampil_supp($this->input->get('vendor'));
        $this->load->view('purchasing/purchase_order_filter_supp',$data);
    }
    
    public function purchase_order_cust(){
        $data['cust']=  $this->m_purchasing->tampil_cust($this->input->get('cust'));
        $this->load->view('purchasing/purchase_order_filter_cust',$data);
    }
    
    public function purchase_order_rate(){
        $data['rate']= $this->m_purchasing->tampil_po_rate($this->input->get('cur'),$this->convert($this->input->get('date')));
        $this->load->view('purchasing/purchase_order_filter_rate',$data);
    }

    public function purchase_order_rate2(){
        $data['rate']= $this->m_purchasing->tampil_po_rate($this->input->get('cur'),$this->convert($this->input->get('date')));
        $data['date2']= $this->convert($this->input->get('date'));
        $data['date'] = date('Y/m', strtotime("-1 days", strtotime($this->convert($this->input->get('date')))));
        $data['newdate'] = date('Y/m', strtotime("-1 months", strtotime($this->convert($this->input->get('date')))));
        $this->load->view('purchasing/purchase_order_filter_rate2',$data);
    }
    
    public function purchase_order_npbb(){
        $cek=$this->input->get('cek');
        $cust=trim($this->input->get('cust'));
        $npbb=$this->input->get('item');
        $vendor = $this->input->get('vendor');
        $cur = $this->input->get('cur');
        
        $data['cek']=$cek;
        
        if($cek != 'true'){
            $data['npbb']=  $this->m_purchasing_po->tampil_po_npbb($npbb);
        } else {
            $data['npbb']=  $this->m_purchasing_po->tampil_po_item($npbb,$vendor,$cur);
        }
        $this->load->view('purchasing/purchase_order_filter_npbb',$data);
    }
    
    public function purchase_order_po(){
        $data['po']=  $this->m_purchasing_po->tampil_po($this->input->get('po'));
        $this->load->view('purchasing/purchase_order_po_all',$data);
    }
    
    public function purchase_order_remark(){
        $data['po']=  $this->m_purchasing_po->tampil_po_hdr($this->input->get('remark'));
        $this->load->view('purchasing/purchase_order_filter_remark',$data);
    }
    
    public function purchase_order_modal_delete(){
        $data['po']=  $this->m_purchasing_po->tampil_po_where($this->input->get('delete'));
        $this->load->view('purchasing/purchase_order_filter_modal_delete',$data);
    }
    
    public function purchase_order_edit(){
        $data['po']=  $this->m_purchasing_po->tampil_po_where($this->input->get('po'));
        $data['cur']=  $this->m_purchasing->tampil_cur();
        $data['whs']=  $this->m_purchasing->tampil_whs('');
        $data['term']=  $this->m_purchasing->tampil_trade();
        $data['cust']=  $this->m_purchasing->tampil_cust('');
        $data['country']=$this->m_purchasing->tampil_country();
        $this->template->display('purchasing/purchase_order_show',$data);
    }
    
    public function purchase_order_edit_copy(){
        $data['po']=  $this->m_purchasing_po->tampil_po_where($this->input->get('po'));
        $data['rate']=  $this->m_purchasing->tampil_po_rate('SGD',date("Y-m-d"));
        $data['cur']=  $this->m_purchasing->tampil_cur();
        $data['whs']=  $this->m_purchasing->tampil_whs('');
        $data['term']=  $this->m_purchasing->tampil_trade();
        $data['cust']=  $this->m_purchasing->tampil_cust('');
        $data['country']=$this->m_purchasing->tampil_country();
        $this->template->display('purchasing/purchase_order_show_copy',$data);
    }
    
    public function purchase_order_delete(){
        $result = $this->m_purchasing_po->delete_po_sp($this->input->get('po'),0);
        
        if($result['flag'] == 1){
            $this->session->set_flashdata("message", "<div class=\"alert alert-danger\" id=\"alert\">Delete Data Success</div>"); 
            redirect('purchasing_po/index');
        } else {
            $this->session->set_flashdata("message", "<div class=\"alert alert-warning\" id=\"alert\">Sorry, This Data used in Another Transaction</div>"); 
            redirect('purchasing_po/index');
        }
        
    }

    public function purchase_order_cancel(){
    	$result = $this->m_purchasing_po->delete_po_sp($this->input->get('po'),1);
        
        if($result['flag'] == 1){
            $this->session->set_flashdata("message", "<div class=\"alert alert-danger\" id=\"alert\">Cancel Data Success</div>"); 
            redirect('purchasing_po/index');
        } else {
            $this->session->set_flashdata("message", "<div class=\"alert alert-warning\" id=\"alert\">Sorry, This Data used in Another Transaction</div>"); 
            redirect('purchasing_po/index');
        }
    }
    
    public function purchase_order_save($trans){
        $vendor=  $this->input->post('vendor');
        $name=  $this->input->post('name');
        $contact=  $this->input->post('contact');
        $vendorref=  $this->input->post('vendorref');
        $cur=  $this->input->post('cur');
        $rate=  $this->input->post('rate');
        $status=  $this->input->post('status');
        $mainpo=  $this->input->post('mainpo');
        $postdate= $this->convert($this->input->post('postdate'));
        $deliverdate=   $this->convert($this->input->post('deliverdate'));
        $docdate=   $this->convert($this->input->post('docdate'));
        $remark=  $this->input->post('remark');
        $remarks=  nl2br($this->input->post('remarks'));
        $totalbefore=  $this->input->post('totalbefore');
        $discount=  $this->input->post('totaldis');
        $freight=  $this->input->post('freight');
        $tax=  $this->input->post('taxprice');
        $totaldue=  $this->input->post('totaldue');
        $cust=  $this->input->post('cust');
        $custname=  $this->input->post('custname');
        $from=  $this->input->post('from');
        $to=  $this->input->post('to');
        $term=  $this->input->post('term');
        $whs=  $this->input->post('whs');
        $more=  $this->input->post('more');
        $include=  $this->input->post('include');
        $remark_country= $this->input->post('remark_country');
        
        $shipdateTemp=$this->input->post('shipdate');
        if ($shipdateTemp != ''){
            $shipdate= $this->convert($shipdateTemp);
        } else {
            $shipdate= '';
        }
        
        $arriveddate='';
        
        $amendmentdateTemp=$this->input->post('amendmentdate');
        if ($amendmentdateTemp != ''){
            $amendmentdate= $this->convert($amendmentdateTemp);
        } else {
            $amendmentdate= '';
        }
        
        $datahdr=array('trans'=>$trans,'mainpo'=>$mainpo,'vendorid'=>$vendor,'vendorcompany'=>$name,'vendorcontact'=>$contact,'vendorref'=>$vendorref,'currency'=>$cur,'rate'=>$rate,'status'=>$status,
                        'postdate'=>$postdate,'deliverdate'=>$deliverdate,'docdate'=>$docdate,'remark'=>$remark,'remarks'=>$remarks,'total'=>$totalbefore,'discount'=>$discount,'freight'=>$freight,'tax'=>$tax,
                        'totaldue'=>$totaldue,'custid'=>$cust,'custcompany'=>$custname,'shipdate'=>$shipdate,'custfrom'=>$from,'custto'=>$to,'arriveddate'=>$arriveddate,'amendmentdate'=>$amendmentdate,'tradeterm'=>$term,'whsid'=>$whs,'more'=>$more,'include'=>$include,
                        'createdby'=> strtoupper($this->session->userdata('userid')),'remark_country'=>$remark_country);
        $query = $this->m_purchasing_po->simpan_po_sp($datahdr);
        
        
//        if ($trans != 'update'){
//            $getNo=  $this->m_purchasing_po->getDocNo_po($docdate);
//            $getdoc='PSV/'.date("y",  strtotime($docdate)).'-'.date("m",  strtotime($docdate)).'-'.$getNo;
//            $datahdr=array('mainpo'=>$getdoc,'vendorid'=>$vendor,'vendorcompany'=>$name,'vendorcontact'=>$contact,'vendorref'=>$vendorref,'currency'=>$cur,'rate'=>$rate,'status'=>$status,
//                            'postdate'=>$postdate,'deliverdate'=>$deliverdate,'docdate'=>$docdate,'remark'=>$remark,'remarks'=>$remarks,'total'=>$totalbefore,'discount'=>$discount,'freight'=>$freight,'tax'=>$tax,
//                            'totaldue'=>$totaldue,'custid'=>$cust,'custcompany'=>$custname,'shipdate'=>$shipdate,'custfrom'=>$from,'custto'=>$to,'arriveddate'=>$arriveddate,'tradeterm'=>$term,'whsid'=>$whs,'more'=>$more,
//                            'createdby'=> strtoupper($this->session->userdata('userid')),'createddate'=> date('Y-m-d H:i:s'));
//            $query = $this->m_purchasing_po->simpan_po($datahdr);
//            $message="Save Transaction Success";
//        } else {
//            $datahdr=array('currency'=>$cur,'rate'=>$rate,'status'=>$status,
//                            'postdate'=>$postdate,'deliverdate'=>$deliverdate,'docdate'=>$docdate,'remark'=>$remark,'remarks'=>$remarks,'total'=>$totalbefore,'discount'=>$discount,'freight'=>$freight,'tax'=>$tax,
//                            'totaldue'=>$totaldue,'custid'=>$cust,'shipdate'=>$shipdate,'custfrom'=>$from,'custto'=>$to,'arriveddate'=>$arriveddate,'tradeterm'=>$term,'whsid'=>$whs,'more'=>$more,
//                            'lastupdatedby'=> strtoupper($this->session->userdata('userid')),'lastupdateddate'=> date('Y-m-d H:i:s'));
//            $query = $this->m_purchasing_po->update_po($mainpo,$datahdr);
//            $getdoc=$mainpo;
//            $message="Update Transaction Success";
//        }
        
        if($query['flag'] == 1){
            $this->session->set_flashdata("message", "<div class=\"alert alert-success\" id=\"alert\">Transaction Success</div>"); 
            redirect('purchasing_po/purchase_order_show?po='.$query['mainpo']);
        }else{
            $this->session->set_flashdata("message", "<div class=\"alert alert-danger\" id=\"alert\">Save Transaction Broken.</div>"); 
            redirect('purchasing_po/index');
        }
    }
    
    public function purchase_order_print(){
        $mainpo=$this->input->get('po');
        $PO= $this->m_purchasing_po->tampil_po_where($mainpo);
        $data['_getPO']=$PO;
        
        foreach ($PO as $r){
            $vendorid=$r->vendorid;
            $whsid=$r->whsid;
            $country_id=$r->country_id;

        }

        if (!empty($country_id)) {
            $data['country']=$this->m_purchasing->tampil_country_where($country_id);
        }else{
             $data['country']='';
        }
        
        $data['vendor']=$this->m_purchasing->tampil_supp_where($vendorid);
        $data['whs']=$this->m_purchasing->tampil_whs_where($whsid);
        
        
        
//        Versi FPDF
//------------------------------------------------------------------------------       
        $this->load->view('purchasing/printout/purchase_order_fpdf',$data);
//------------------------------------------------------------------------------
        
//        Versi HTML2PDF
//------------------------------------------------------------------------------
//        ob_start(); 
//        $this->load->view('purchasing/printout/purchase_order_print', $data);
//        $html   = ob_get_contents();
//        ob_end_clean();
//        
//        require_once ('./assets/global/html2pdf/html2pdf.class.php');
//        $pdf    = new HTML2PDF('P','A4','en');
//        $pdf->writeHTML($html);
//        $pdf->Output($mainpo.'.pdf');
//------------------------------------------------------------------------------------

    }
//---------------------------------------------------------------------EXTRA-----------------------------------------------------
    public function convert($date){
        $explode=explode("-", $date);
        
        $time=$explode[2].'/'.$explode[1].'/'.$explode[0];
        
        return $time;
    }
	 
	function cancel_po()
	{
		$record = $this->M_mar_purchase_order->get_open_po();
		
		$data = array(
			'action'		=> site_url('purchase_order/do_cancel'),
			'message'		=> $this->session->flashdata('message'),
			'record'		=> $record,
		);
		
		$this->template->display('marketing/transactions/purchase_order/cancel_po', $data);
	}
	
	function do_cancel()
	{
		$total_cancel = $this->M_mar_purchase_order->cancel_po();
		
		if ($total_cancel == 0){
			$msg	= pesan('No PO Canceled.', pesan_info());
		} else {
			$msg	= pesan("Cancel $total_cancel PO(s).", pesan_sukses());
		}
		
		$this->session->set_flashdata('message', $msg);
		redirect('purchase_order/cancel_po');
	}

	 
}