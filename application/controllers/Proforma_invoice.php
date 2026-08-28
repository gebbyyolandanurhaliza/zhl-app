<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Proforma_invoice extends CI_Controller {
	
	function __construct(){
		parent::__construct();
		
		if (!$this->session->userdata('userid_1')) {
            redirect('login');
        }
		
		$this->load->model(array('M_gen_master', 'M_mar_master', 'M_mar_product', 'M_mar_sales_contract', 'M_mar_proforma_invoice'));
        
	}
	
	function index()
	{
		$this->issue();
//		$cbo_sc = $this->M_mar_sales_contract->get_all('header');
//		$data = array(
//			'message'			=> '',
//			'action'			=> site_url('proforma-invoice/issue'),
//			'cbo_sc'			=> $cbo_sc,
//			'contract_hdr_id'	=> set_value('contract_hdr_id', '', true),
//		);
//		
//		$this->template->display('marketing/proforma_invoice/index', $data);
	}
	
	function issue()
	{
		$cbo_customer		= $this->M_mar_master->cust_get_all();
		$cbo_contract		= $this->M_mar_proforma_invoice->get_contract();
		$cbo_port			= $this->M_mar_master->port_get_all();
		$cbo_tradingterm	= $this->M_mar_master->tradingterm_get_all();
		$cbo_sales_marketing = $this->M_mar_master->sales_marketing_get_all();
		$cbo_bank			= $this->M_mar_master->bank_get_all();
		
		$data = array(
			'message'			=> $this->session->flashdata('message'),
			'action'			=> site_url('proforma-invoice/submit'),			
			'current_date'		=> date('d/m/Y'),
			'cbo_customer'		=> $cbo_customer,
			'cbo_contract'		=> $cbo_contract,
			'cbo_port'			=> $cbo_port,
			'cbo_tradingterm'	=> $cbo_tradingterm,
			'cbo_sales_marketing' => $cbo_sales_marketing,
			'cbo_payterm'		=> '',
			'cbo_bank'			=> $cbo_bank,
			'act'				=> set_value('act', 'add', true),
			'pi_hdr_id'			=> set_value('pi_hdr_id', '', true),
			'pi_number'			=> set_value('pi_number', '', true),
			'pi_date'			=> set_value('pi_date', date('d/m/Y'), true),
			'contract_hdr_id'	=> set_value('contract_hdr_id', '', true),
			'customer_id'		=> set_value('customer_id', '', true),
			'attn'				=> set_value('attn', '', true),
			'contract_hdr_id'	=> set_value('contract_hdr_id', '', true),
			'shipment_from'		=> set_value('shipment_from', '', true),
			'shipment_to'		=> set_value('shipment_to', '', true),
			'port_id'			=> set_value('port_id', '', true),
			'destination_id'	=> set_value('destination_id', '', true),
			'trading_term_id'	=> set_value('trading_term_id', '', true),
			'etdsin'			=> set_value('etdsin', '', true),
			'payment_term'		=> set_value('payment_term', '', true),
			'sales_marketing_id'=> set_value('sales_marketing_id', '', true),
			'bank_id'			=> set_value('bank_id', '', true),
			'remark'			=> set_value('remark', '', true),
			
			'btn_print'			=> '<a href="#" class="btn btn-warning" id="btn_print" disabled><i class="fa fa-print"></i> Print ...</a>',
			'btn_delete'		=> '<input type="button" class="btn btn-danger fontawesome-font" value="&#xf014 Delete" id="btn_delete" headerid="0" disabled>',
			'submit_caption'	=> 'Save',
		);
		
		$this->template->display('marketing/proforma_invoice/issue', $data);
	}
	
	
	function load_contract()
	{
		$customer_id	= $this->input->post('customer_id');
		$cbo_contract	= $this->M_mar_proforma_invoice->get_contract_by_customer($customer_id);
		
		$data = array(
			'cbo_contract'		=> $cbo_contract,
			'contract_hdr_id'	=> set_value('contract_hdr_id', '', true),
		);
		
		$this->load->view('marketing/proforma_invoice/output_contract', $data);
	}
	
	function load_right_top()
	{
		$contract_hdr_id	= $this->input->post('contract_hdr_id');
		
		$row	= $this->M_mar_proforma_invoice->get_contract_by_id($contract_hdr_id);
		
		$cbo_port			= $this->M_mar_master->port_get_all();
		$cbo_tradingterm	= $this->M_mar_master->tradingterm_get_all();
		
		if ($row){
			$shipment_from		= ($row->shipment_from) ? $row->shipment_from : '';
			$trading_term_id	= ($row->trading_term_id) ? $row->trading_term_id : '';
			$port_id			= ($row->port_id) ? $row->port_id : '';
			$destination_id		= ($row->destination_id) ? $row->destination_id : '';
			$etdsin				= ($row->shipment_schedule) ? $row->shipment_schedule : '';
		} else {
			$shipment_from		= '';
			$trading_term_id	= '';
			$port_id			= '';
			$destination_id		= '';
			$etdsin				= '';
		}
		
		$data = array(
			'cbo_port'			=> $cbo_port,
			'cbo_tradingterm'	=> $cbo_tradingterm,
			'shipment_from'		=> set_value('shipment_from', $shipment_from, true),
			'port_id'			=> $port_id,
			'destination_id'	=> $destination_id,
			'trading_term_id'	=> set_value('trading_term_id', $trading_term_id, true),
			'etdsin'			=> set_value('etdsin', $etdsin, true),
		);
		
		$this->load->view('marketing/proforma_invoice/output_right_top', $data);
	}
	
	function load_detail()
	{
		$contract_hdr_id	= $this->input->post('contract_hdr_id');
		
		$row				= $this->M_mar_proforma_invoice->get_contract_by_id($contract_hdr_id);
		$rec_detail			= $this->M_mar_sales_contract->get_detail($contract_hdr_id);
				
		$cbo_sales_marketing	= $this->M_mar_master->sales_marketing_get_all();
		$cbo_bank				= $this->M_mar_master->bank_get_all();
		
		if ($row){
			$cbo_payterm			= $this->M_mar_master->cust_payterm_get_by_customer($row->customer_id);
			$payment_term			= ($row->payment_terms) ? $row->payment_terms : '';
			$sales_marketing_id		= ($row->sales_marketing_id) ? $row->sales_marketing_id : '';
			$bank_id				= ($row->bank_id) ? $row->bank_id : '';
		} else {
			$cbo_payterm			= '';
			$payment_term			= '';
			$sales_marketing_id		= '';
			$bank_id				= '';
		}
		
		$data = array(
			'rec_detail'			=> $rec_detail,
			'cbo_payterm'			=> $cbo_payterm,
			'cbo_sales_marketing'	=> $cbo_sales_marketing,
			'cbo_bank'				=> $cbo_bank,
			'payment_term'			=> set_value('payment_term', $payment_term, true),
			'sales_marketing_id'	=> set_value('sales_marketing_id', $sales_marketing_id, true),
			'bank_id'				=> set_value('bank_id', $bank_id, true),
		);
		
		$this->load->view('marketing/proforma_invoice/output_detail', $data);
	}
	
	
	function submit()
	{
		$act = $this->input->post('act');
		if ($act == 'add'){
			$submit_result = $this->M_mar_proforma_invoice->insert();
			$perintah = 'Saving';
		} else {
			$submit_result = $this->M_mar_proforma_invoice->update();
			$perintah = 'Updating';
		}
		
		if ($submit_result > 0){
			$row = $this->M_mar_proforma_invoice->get_header_by_id($submit_result);
			$pdf_link = site_url('proforma-invoice/generate-pdf/?id='.encode_str($row->pi_hdr_id));
			$this->session->set_flashdata('message',pesan($perintah.' Proforma Invoice <strong>'.$row->pi_number.'</strong>', pesan_sukses(), $pdf_link));
			redirect(site_url('proforma-invoice'));
		} else {
			$this->session->set_flashdata('message',pesan('FAILED', pesan_error()));
			redirect(site_url('proforma-invoice'));
		}
		
	}
	
	function generate_pdf()
	{
		$pi_hdr_id	= decode_str($this->input->get('id'));
		
		$data = array(
			'record_header'		=> $this->M_mar_proforma_invoice->get_header_by_id($pi_hdr_id),
			'record_detail'		=> $this->M_mar_proforma_invoice->get_detail($pi_hdr_id),
		);

		$this->load->view('marketing/proforma_invoice/print', $data);
	}
}