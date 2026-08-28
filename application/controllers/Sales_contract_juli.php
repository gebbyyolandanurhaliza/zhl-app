<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Sales_contract extends CI_Controller {
	
	function __construct(){
		parent::__construct();
		if (!$this->session->userdata('userid_1')) {
            redirect('login');
        }
		$this->load->model(array('M_gen_master', 'M_mar_master', 'M_mar_product', 
			'M_mar_sales_contract', 'M_mar_purchase_order', 'M_mar_sales_quotation', 'M_mar_misc', 'M_mar_sales_confirmation',
			'M_mar_shipping_instruction'
			));
	}
	
	function index()
	{
		$this->quotation();
	}
	
	function quotation()
	{
		$cbo_sales		= $this->M_mar_master->sales_person_get_all();
				
		$param_customer = '';
		$param_sales = $this->session->userdata('userid_1');
		$param_docdate1 = date('01/m/Y');
		$param_docdate2 = date('t/m/Y');
		$search_result	= '';

		if ($this->input->server('REQUEST_METHOD') == 'POST'){
			$param_customer = $this->input->post('customer');
			$param_sales = $this->input->post('sales_id');
			$param_docdate1 = $this->input->post('document_date1');
			$param_docdate2 = $this->input->post('document_date2');
			$search_result = $this->M_mar_sales_contract->filter_quotation();					
		}

		$data = array(
			'message'			=> $this->session->flashdata('message'),
			'action'			=> site_url('sales-contract/quotation'),
			'header_title'		=> 'Sales Contract',
			'submit_caption'	=> 'Search',
			'current_date'		=> date('d/m/Y'),
			'cbo_sales'			=> $cbo_sales,
			'search_result'		=> $search_result,
			'customer'			=> set_value('customer', $param_customer, true),
			'sales_id'			=> set_value('sales_id', $param_sales, true),
			'document_date1'	=> set_value('document_date1', date($param_docdate1), true),
			'document_date2'	=> set_value('document_date2', date($param_docdate2), true),
		);

		$this->template->display('marketing/contract/quotation', $data);
	}
	
	function create()
	{
		$this->creating_sales_contract(1);
	}
	
	function create_no_quote()
	{
		$this->creating_sales_contract(0);
	}
	
	function creating_sales_contract($with_quotation)
	{
		if ($with_quotation == 0){
			$quotation_hdr_id = '';
			$q_hdr		= '';
			$q_dtl		= '';
			$agent_list	= '';
			
			$btn_add_product = '<a href="#modal_product" class="btn btn-primary btn-large" data-toggle="modal" >
									<i class="fa fa-plus"></i> Add Product ...
								</a>';	
			$cbo_payterm		= $this->M_mar_master->cust_payterm_get_all();
			
			$factory_id			= '';
			$quotation_number	= '';
			$partial_shipment	= '';
			$tradingterm_id		= '';
			$destination_id		= '';
			$port_id			= '';
			$container_id		= '';
			$container_size		= '';
			$marine_insurance	= '';
			$shipping_id		= '';
			$shipment_schedule	= '';
			$shipment_from		= '';
			$local_currency		= '';
			$rate_usd			= '';
			$rate_sgd			= '';
			$customer_reference	= '';
			$customer_id		= '';
			$customer_name		= '';
			$country_id			= '';
			$idd_no				= '';
			$customer_address	= '';
			$customer_phone		= '';
			$customer_fax		= '';
			$customer_email		= '';
			$payment_terms		= '';
			$sales_person_id	= '';
			$total_before_disc	= '';
			$discount			= '';
			$total_disc			= '';
			$freight			= '';
			$tax				= '';
			$total_fcl			= '';
			$grand_total		= '';
			$product_shelf_life_id = '';
			$remark				= '';
			
			
		} else {
			$quotation_hdr_id	= $this->input->get('id');
			$q_hdr				= $this->M_mar_sales_quotation->get_by_id(decode_str($quotation_hdr_id, 'contract'));
			$q_dtl				= $this->M_mar_sales_quotation->get_detail(decode_str($quotation_hdr_id, 'contract'));
			$agent_list			= $this->M_mar_sales_quotation->get_agent(decode_str($quotation_hdr_id, 'contract'));
			
			$btn_add_product	= '';
			$cbo_payterm		= $this->M_mar_master->cust_payterm_get_by_customer($q_hdr->customer_id);
			
			$factory_id			= $q_hdr->factory_id;
			$quotation_number	= $q_hdr->quotation_number;
			$partial_shipment	= $q_hdr->partial_shipment;
			$tradingterm_id		= $q_hdr->trading_term_id;
			$destination_id		= $q_hdr->destination_id;
			$port_id			= $q_hdr->port_id;
			$container_id		= $q_hdr->container_id;
			$container_size		= $q_hdr->container_size;
			$marine_insurance	= $q_hdr->marine_insurance;
			$shipping_id		= $q_hdr->shipping_id;
			$shipment_schedule	= $q_hdr->shipment_schedule;
			$shipment_from		= $q_hdr->shipment_from;
			$local_currency		= $q_hdr->currency_id;
			$rate_usd			= $q_hdr->rate_usd;
			$rate_sgd			= $q_hdr->rate_sgd;
			$customer_reference	= $q_hdr->customer_reference;
			$customer_id		= $q_hdr->customer_id;
			$customer_name		= $q_hdr->customer_name;
			$country_id			= $q_hdr->customer_country_id;
			$idd_no				= $this->M_mar_misc->get_idd($q_hdr->customer_country_id);
			$customer_address	= $q_hdr->customer_address;
			$customer_phone		= $q_hdr->customer_phone;
			$customer_fax		= $q_hdr->customer_fax;
			$customer_email		= $q_hdr->customer_email;
			$payment_terms		= $q_hdr->payment_terms;
			$sales_person_id	= $q_hdr->sales_id;
			$total_before_disc	= number_format($q_hdr->total_before_disc, 2, '.', ',');
			$discount			= $q_hdr->discount;
			$total_disc			= number_format($q_hdr->total_disc, 2, '.', ',');
			$freight			= $q_hdr->freight;
			$tax				= $q_hdr->tax;
			$total_fcl			= 0;
			$grand_total		= number_format($q_hdr->final_total, 2, '.', ',');
			$product_shelf_life_id = $q_hdr->product_shelf_life_id;
			$remark				= $q_hdr->quotation_remark;
		}
		
		$cbo_country		= $this->M_gen_master->get_all('country');
		$cbo_port			= $this->M_mar_master->port_get_all();
		$cbo_container		= $this->M_mar_master->container_get_all();
		$cbo_tradingterm	= $this->M_mar_master->tradingterm_get_all();
		$cbo_company		= $this->M_mar_master->cust_get_all();
		$cbo_uom			= $this->M_gen_master->get_all('uom');
		$cbo_brand			= $this->M_mar_master->brand_get_all();
		
		$cbo_shelf			= $this->M_mar_master->shelf_get_all();
		$cbo_currency		= $this->M_gen_master->get_all('currency');
		$cbo_bank			= $this->M_mar_master->bank_get_all();
		$cbo_shipping_line	= $this->M_gen_master->get_all('shipping_line');
		$cbo_agent			= $this->M_mar_master->agent_get_all_active();
		$list_document		= $this->M_mar_master->document_get_all();
		
		$cbo_sales_person	= $this->M_mar_master->sales_person_get_all();
		$cbo_sales_marketing = $this->M_mar_master->sales_marketing_get_all();
		$cbo_product_manager= $this->M_mar_master->product_manager_get_all();
				
		$data = array(
			'message'			=> $this->session->flashdata('message'),
			'action'			=> site_url('sales-contract/submit'),
			'act'				=> set_value('act', 'add'),
			'header_title'		=> 'Sales Contract',
			'submit_caption'	=> 'Save',
			'current_date'		=> date('d/m/Y'),
			'cbo_country'		=> $cbo_country,
			'cbo_port'			=> $cbo_port,
			'cbo_container'		=> $cbo_container,
			'cbo_tradingterm'	=> $cbo_tradingterm,
			'cbo_company'		=> $cbo_company,
			'cbo_destination'	=> $cbo_country,
			'cbo_uom'			=> $cbo_uom,
			'cbo_brand'			=> $cbo_brand,
			'cbo_payterm'		=> $cbo_payterm,
			'cbo_shelf'			=> $cbo_shelf,
			'cbo_currency'		=> $cbo_currency,
			'cbo_bank'			=> $cbo_bank,
			'cbo_shipping_line'	=> $cbo_shipping_line,
			'cbo_agent'			=> $cbo_agent,
			'cbo_sales_person'	=> $cbo_sales_person,
			'cbo_sales_marketing' => $cbo_sales_marketing,
			'cbo_product_manager' => $cbo_product_manager,
			'list_document'		=> $list_document,
			'selected_document'	=> '',
			'agent_list'		=> $agent_list,
			'detail'			=> $q_dtl,
			'contract_detail'	=> '',
			'factory_id'		=> $factory_id,
			'btn_add_product'	=> $btn_add_product,
			'btn_print'			=> '<a href="#" class="btn btn-warning" id="btn_print" disabled><i class="fa fa-print"></i> Print ...</a>',
			'btn_delete'		=> '<input type="button" class="btn btn-danger fontawesome-font" value="&#xf014 Delete" id="btn_delete" headerid="0" disabled>',
			'quotation_hdr_id'	=> $quotation_hdr_id,	
			'quotation_number'	=> $quotation_number,
			'contract_hdr_id'	=> set_value('contract_hdr_id', '0', true),
			'sales_contract_no'	=> set_value('sales_contract_no', '', true),
			'contract_date'		=> set_value('contract_date', date('d/m/Y'), true),
			'tradingterm_id'	=> set_value('tradingterm_id', $tradingterm_id, true),
			'destination_id'	=> set_value('destination_id', $destination_id, true),
			'shipment_from'		=> set_value('shipment_from', $shipment_from, true),
			'port_id'			=> set_value('port_id', $port_id, true),
			'container_id'		=> set_value('container_id', $container_id, true),
			'container_size'	=> set_value('container_size', $container_size, true),
			'partial_shipment'	=> set_value('partial_shipment', $partial_shipment, true),
			'marine_insurance'	=> set_value('marine_insurance', $marine_insurance, true),
			'shipping_id'		=> set_value('shipping_id', $shipping_id, true),
			'shipment_schedule'	=> set_value('shipment_schedule', $shipment_schedule, true),
			'local_currency'	=> set_value('local_currency', $local_currency, true),
			'rate_usd'			=> set_value('rate_usd', $rate_usd, true),
			'rate_sgd'			=> set_value('rate_sgd', $rate_sgd, true),
			'customer_reference'=> set_value('customer_reference', $customer_reference, true),
			'customer_id'		=> set_value('cuctomer_id', $customer_id, true),
			'customer_name'		=> set_value('customer_name', $customer_name, true),			
			'country_id'		=> set_value('country_id', $country_id, true),
			'country_idd'		=> set_value('country_idd', ($idd_no == '' ? '' : $idd_no), true),
			'customer_address'	=> set_value('customer_address', $customer_address, true),
			'customer_phone'	=> set_value('customer_phone', $customer_phone, true),
			'customer_fax'		=> set_value('customer_fax', $customer_fax, true),
			'customer_email'	=> set_value('customer_email', $customer_email, true),
			'payment_term'		=> set_value('payment_term', $payment_terms, true),
			'bank_id'			=> set_value('bank_id', '', true),
			'bank_account_number'=> set_value('bank_account_number', '', true),
			'bank_name'			=> set_value('bank_name', '', true),
			'bank_city'			=> set_value('bank_city', '', true),
			'bank_address'		=> set_value('bank_address', '', true),
			'bank_country_name' => set_value('bank_country_name', '', true),
			'sales_marketing_id'=> set_value('sales_marketing_id', '', true),
			'sales_person_id'	=> set_value('sales_person_id', $sales_person_id, true),
			'product_manager'	=> set_value('product_manager', '', true),
			'total_before_disc' => set_value('total_before_disc', $total_before_disc, true),
			'discount'			=> set_value('discount', $discount, true),
			'total_disc'		=> set_value('total_disc', $total_disc, true),
			'freight'			=> set_value('freight', $freight, true),
			'tax'				=> set_value('tax', $tax, true),
			'total_fcl'			=> set_value('total_fcl', $total_fcl, true),
			'grand_total'		=> set_value('grand_total', $grand_total, true),
			'product_shelf_life_id' => set_value('product_shelf_life_id', $product_shelf_life_id, true),
			'remark'			=> set_value('remark', $remark, true),		
			
		);

		$this->template->display('marketing/contract/create_contract', $data);
	}
	
	function submit()
	{
		$act = $this->input->post('act');
		if ($act == 'add'){
			$submit_result = $this->M_mar_sales_contract->insert();
			$perintah = 'Saving';
		} else {
			$submit_result = $this->M_mar_sales_contract->update();
			$perintah = 'Updating';
		}
		
		if ($submit_result > 0){
			$row = $this->M_mar_sales_contract->get_by_id($submit_result);
			$pdf_link = site_url('sales-contract/generate-pdf/?id='.encode_str($row->contract_hdr_id).'&no='.encode_str($row->contract_no).'&dt='.encode_str(date('d-M-Y', strtotime($row->contract_date))));
			$extra = "<a href='".site_url('marketing-transaction/purchase-order')."' class='btn btn-success'><i class='fa fa-arrow-right'></i> Go To Purchase Order</a>";
			$this->session->set_flashdata('message',pesan($perintah.' Sales Contract <strong>'.$row->contract_no.'</strong>', pesan_sukses(), $pdf_link, $extra));
			redirect(site_url('sales-contract'));
		} else {
			$this->session->set_flashdata('message',pesan('FAILED', pesan_error()));
			redirect(site_url('sales-contract'));
		}
		
	}
	
	function delete()
	{
		$this->M_mar_sales_contract->delete();
	}
	
	function add_agent_row()
	{
		$cbo_agent		= $this->M_mar_master->agent_get_all_active();
		
		$data = array(
			'cbo_agent'		=> $cbo_agent,
			'agent_id'		=> '',
		);
		
		$this->load->view('marketing/contract/agent_row_output', $data);
	}
	
	
	function find()
	{
		$find_record = $this->M_mar_sales_contract->find_contract();
		if ($find_record){
			$data = array(
				'find_record'	=> $find_record,
			);
			$this->load->view('marketing/contract/find', $data);
		}
	}
	
	
	function show_find()
	{
		$id					= decode_str($this->input->get('id'), 'contract');
		$row				= $this->M_mar_sales_contract->get_by_id($id);
		$contract_detail	= $this->M_mar_sales_contract->get_detail($id);
		$agent_list			= $this->M_mar_sales_contract->get_agent($id);
		
		$tot_disc			= ($row->total_before_disc * $row->discount)/100 ;
		
		$cbo_country		= $this->M_gen_master->get_all('country');
		$cbo_port			= $this->M_mar_master->port_get_all();
		$cbo_container		= $this->M_mar_master->container_get_all();
		$cbo_tradingterm	= $this->M_mar_master->tradingterm_get_all();
		$cbo_company		= $this->M_mar_master->cust_get_all();
		$cbo_uom			= $this->M_gen_master->get_all('uom');
		$cbo_brand			= $this->M_mar_master->brand_get_all();
		$cbo_payterm		= $this->M_mar_master->cust_payterm_get_all();
		$cbo_shelf			= $this->M_mar_master->shelf_get_all();
		$cbo_currency		= $this->M_gen_master->get_all('currency');
		$cbo_bank			= $this->M_mar_master->bank_get_all();
		$cbo_shipping_line	= $this->M_gen_master->get_all('shipping_line');
		$cbo_agent			= $this->M_mar_master->agent_get_all_active();
		$list_document		= $this->M_mar_master->document_get_all();
		$selected_document	= $this->M_mar_sales_contract->get_selected_document($id);
		
		$cbo_sales_person	= $this->M_mar_master->sales_person_get_all();
		$cbo_sales_marketing = $this->M_mar_master->sales_marketing_get_all();
		$cbo_product_manager = $this->M_mar_master->product_manager_get_all();
		
		$btn_add_product	= '<a href="#modal_product" class="btn btn-primary btn-large" data-toggle="modal" >
									<i class="fa fa-plus"></i> Add Product ...
								</a>';	
		
		$data = array(
			'message'			=> $this->session->flashdata('message'),
			'action'			=> site_url('sales-contract/submit'),
			'act'				=> set_value('act', 'edit',true),
			'header_title'		=> 'Sales Contract',
			'submit_caption'	=> 'Update',
			'current_date'		=> date('d/m/Y'),
			'cbo_country'		=> $cbo_country,
			'cbo_port'			=> $cbo_port,
			'cbo_container'		=> $cbo_container,
			'cbo_tradingterm'	=> $cbo_tradingterm,
			'cbo_company'		=> $cbo_company,
			'cbo_destination'	=> $cbo_country,
			'cbo_uom'			=> $cbo_uom,
			'cbo_brand'			=> $cbo_brand,
			'cbo_payterm'		=> $cbo_payterm,
			'cbo_shelf'			=> $cbo_shelf,
			'cbo_currency'		=> $cbo_currency,
			'cbo_bank'			=> $cbo_bank,
			'cbo_shipping_line'	=> $cbo_shipping_line,
			'cbo_agent'			=> $cbo_agent,
			'cbo_sales_person'	=> $cbo_sales_person,
			'cbo_sales_marketing' => $cbo_sales_marketing,
			'cbo_product_manager' => $cbo_product_manager,
			'list_document'		=> $list_document,
			'selected_document'	=> $selected_document,
			'agent_list'		=> $agent_list,
			'detail'			=> '',
			'contract_detail'	=> $contract_detail,
			'factory_id'		=> $row->factory_id,
			'btn_add_product'	=> $btn_add_product,
			'btn_print'			=> '<a href="'.site_url('sales-contract/generate-pdf/?id='.encode_str($row->contract_hdr_id)).'&no='.encode_str($row->contract_no).'&dt='.encode_str(date('d-M-Y', strtotime($row->contract_date))).'" class="btn btn-warning" id="btn_print" target="_blank"><i class="fa fa-print"></i> Print ...</a>',
			'btn_delete'		=> '<input type="button" class="btn btn-danger fontawesome-font" value="&#xf014 Delete" id="btn_delete" headerid="'.encode_str($id, 'contract').'">',
			'quotation_hdr_id'	=> set_value('quotation_hdr_id',encode_str($row->quotation_hdr_id, 'contract'),true),	
			'quotation_number'	=> set_value('quotation_number',$row->quotation_number,true),
			'contract_hdr_id'	=> set_value('contract_hdr_id', encode_str($row->contract_hdr_id, 'contract'), true),
			'sales_contract_no'	=> set_value('sales_contract_no', $row->contract_no, true),
			'contract_date'		=> set_value('contract_date', tgl_ind($row->contract_date), true),
			'tradingterm_id'	=> set_value('tradingterm_id', $row->trading_term_id, true),
			'destination_id'	=> set_value('destination_id', $row->destination_id, true),
			'shipment_from'		=> set_value('shipment_from', $row->shipment_from, true),
			'port_id'			=> set_value('port_id', $row->port_id, true),
			'container_id'		=> set_value('container_id', $row->container_id, true),
			'container_size'	=> set_value('container_size', $row->container_size, true),
			'partial_shipment'	=> set_value('partial_shipment', $row->partial_shipment, true),
			'marine_insurance'	=> set_value('marine_insurance', $row->marine_insurance, true),
			'shipping_id'		=> set_value('shipping_id', $row->shipping_id, true),
			'shipment_schedule'	=> set_value('shipment_schedule', $row->shipment_schedule, true),
			'local_currency'	=> set_value('local_currency', $row->currency_id, true),
			'rate_usd'			=> set_value('rate_usd', $row->rate_usd, true),
			'rate_sgd'			=> set_value('rate_sgd', $row->rate_sgd, true),
			'customer_reference'=> set_value('customer_reference', $row->customer_reference, true),
			'customer_id'		=> set_value('cuctomer_id', $row->customer_id, true),
			'payment_term'		=> set_value('payment_term', $row->payment_terms, true),
			'bank_id'			=> set_value('bank_id', $row->bank_id, true),
			'total_before_disc' => set_value('total_before_disc', number_format($row->total_before_disc, 2, '.', ','), true),
			'sales_marketing_id'=> set_value('sales_marketing_id', $row->sales_marketing_id, true),
			'sales_person_id'	=> set_value('sales_person_id', $row->sales_person_id, true),
			'product_manager'	=> set_value('product_manager', $row->product_manager, true),
			'discount'			=> set_value('discount', $row->discount, true),
			'total_disc'		=> set_value('total_disc', number_format($tot_disc, 2, '.', ','), true),
			'freight'			=> set_value('freight', $row->freight, true),
			'tax'				=> set_value('tax', $row->tax, true),
			'total_fcl'			=> set_value('total_fcl', number_format($row->total_fcl, 2, '.', ','), true),
			'grand_total'		=> set_value('grand_total', number_format($row->grand_total, 2, '.', ','), true),
			'product_shelf_life_id' => set_value('product_shelf_life_id', $row->product_shelf_life_id, true),
			'remark'			=> set_value('remark', $row->remark, true),
		);

		$this->template->display('marketing/contract/create_contract', $data);
	}
	
	function previous_remark()
	{
		$customer_id = $this->input->post('customer_id');
		$data_contract = $this->M_mar_sales_contract->get_previous_remark($customer_id);
		
		$data = array(
			'rec_prev'	=> $data_contract,
		);
		
//		$sql = $this->M_mar_sales_contract->get_data_sebelum($customer_id)->result();
//		
//		$data = array(
//			'pre_remark'	=> '',
//		);
//		
//		foreach ($sql as $pre) {
//			if ($pre->remark){
//				$data = array(
//					'pre_remark'	=> $pre->remark,
//				);
//			}
//		}
		
		$this->load->view('marketing/contract/pre_find', $data);
	}
	
//	function get_previous_data()
//	{
//		$customer_id = $this->input->post('customer_id');
//		$pre = $this->M_mar_sales_contract->get_data_sebelum($customer_id);
//		
//		$this->session->set_flashdata('pre_remark', $pre->remark);
//	}
	
	function generate_pdf()
	{
		$header_id = decode_str($this->input->get('id'));
		$data = array(
			'record_header'		=> $this->M_mar_sales_contract->get_by_id($header_id),
			'record_detail'		=> $this->M_mar_sales_contract->get_detail($header_id),
			'record_document'	=> $this->M_mar_sales_contract->get_view_document($header_id),
			'record_agent'		=> $this->M_mar_sales_contract->get_agent_invoice($header_id),
		);

		$this->load->view('marketing/contract/print', $data);
	}
	
	function print_preview()
	{
//		$header_id = decode_str($this->input->get('id'), 'contract');
		$data = array(
			'contract_no'		=> 'PSS-001',
//			'record_header'		=> $this->M_mar_sales_contract->get_by_id($header_id),
//			'record_detail'		=> $this->M_mar_sales_contract->get_detail($header_id),
//			'record_document'	=> $this->M_mar_sales_contract->get_view_document($header_id),
		);

		$this->template->display('marketing/contract/print_preview', $data);
		
	}

}