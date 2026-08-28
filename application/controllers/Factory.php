<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Factory extends CI_Controller {
	function __construct(){
		parent::__construct();

		if (!$this->session->userdata('userid_1')) {
            redirect('login');
        }

		$this->load->model(array('M_factory', 'M_mar_master', 'M_gen_master', 'M_mar_purchase_order', 'M_mar_sales_quotation', 'M_mar_sales_confirmation', 'M_mar_product'));
	}

	function marketing_po()
	{
		$param_search	= '';
		$shipdate1		= date('01/m/Y');
		$shipdate2		= date('t/m/Y');
		$rec_count		= 0;

		if ($this->input->server('REQUEST_METHOD') == 'POST'){
			$q				= $this->M_factory->product_po();
			$rec_count		= $q->num_rows();
			$record			= $q->result();
			$param_search	= $this->input->post('param_search');
			$shipdate1		= $this->input->post('ship_date1');
			$shipdate2		= $this->input->post('ship_date2');
		}

		$data = array(
			'message'		=> $this->session->flashdata('no_po_msg'),
			'rec_count'		=> $rec_count,
			'record_mon'	=> isset($record) ? $record : '',
			'current_date'	=> date('d/m/Y'),
			'param_search'	=> set_value('param_search', $param_search),
			'ship_date1'	=> set_value('ship_date1', $shipdate1),
			'ship_date2'	=> set_value('ship_date2', $shipdate2),
		);

		$this->template->display('factory/marketing_po', $data);
	}

	function marketing_po_filter()
	{
		$param_search	= '';
		$shipdate1		= date('01/m/Y');
		$shipdate2		= date('t/m/Y');
		$rec_count		= 0;

		if ($this->input->server('REQUEST_METHOD') == 'POST'){
			$q				= $this->M_factory->product_po();
			$rec_count		= $q->num_rows();
			$record			= $q->result();
			$param_search	= $this->input->post('param_search');
			$shipdate1		= $this->input->post('ship_date1');
			$shipdate2		= $this->input->post('ship_date2');
		}

		$data = array(
			'message'		=> $this->session->flashdata('no_po_msg'),
			'rec_count'		=> $rec_count,
			'record_mon'	=> isset($record) ? $record : '',
			'current_date'	=> date('d/m/Y'),
			'param_search'	=> set_value('param_search', $param_search),
			'ship_date1'	=> set_value('ship_date1', $shipdate1),
			'ship_date2'	=> set_value('ship_date2', $shipdate2),
		);

		$this->load->view('factory/marketing_po_filter', $data);
	}

//    HASIL MEETING 07/08/2017 : Menampilkan Sales Quotation yg sudah di konfirmasi
    function sales_quotation()
    {
        $cbo_sales			= $this->M_mar_master->sales_get_all();

        $param_cbostatus	= array('sales_confirmation' => 1);
        $cbo_status			= $this->M_gen_master->get_all_with_param('status', $param_cbostatus);

        $param_customer		= '';
        $param_sales		= $this->session->userdata('userid_1');
        $param_status		= '1';
        $param_postdate1	= date('01/m/Y');
        $param_postdate2	= date('t/m/Y');
        $search_result		= '';

        if ($this->input->server('REQUEST_METHOD') == 'POST'){
            $param_customer		= $this->input->post('customer');
            $param_sales		= $this->input->post('sales_id');
            $param_status		= $this->input->post('status_id');
            $param_postdate1	= $this->input->post('posting_date1');
            $param_postdate2	= $this->input->post('posting_date2');
            $search_result		= $this->M_factory->sales_quotation_filter();
        }

        $data = array(
            'message'			=> $this->session->flashdata('message'),
            'action'			=> site_url('factory/sales-quotation'),
            'header_title'		=> 'Confirmed Sales Quotation',
            'submit_caption'	=> 'Search',
            'current_date'		=> date('d/m/Y'),
            'cbo_sales'			=> $cbo_sales,
            'cbo_status'		=> $cbo_status,
            'search_result'		=> $search_result,
            'customer'			=> set_value('customer', $param_customer, true),
            'sales_id'			=> set_value('sales_id', $param_sales, true),
            'status_id'			=> set_value('status_id', $param_status, true),
            'posting_date1'		=> set_value('posting_date1', date($param_postdate1), true),
            'posting_date2'		=> set_value('posting_date2', date($param_postdate2), true),
        );

        $this->template->display('factory/sales_quotation', $data);

    }

    function sales_quotation_view() {
        $id = decode_str($this->input->get('id'));
		$fid = $this->input->get('fid');

		$this->updatesales($id);

        $row = $this->M_mar_sales_quotation->get_by_id($id);
        $detail = $this->M_factory->sales_quotation_detail($id, $fid);
        $agent_list = $this->M_mar_sales_quotation->get_agent($id);

        $cbo_customer = $this->M_mar_master->cust_get_all_active();
        $cbo_currency = $this->M_gen_master->get_all('currency');
        $cbo_marketing = $this->M_mar_master->mark_get_all();
        $cbo_sales = $this->M_mar_master->sales_get_all();
        $cbo_status = $this->M_gen_master->get_all('status');
//        $cbo_payterm = $this->M_mar_master->cust_payterm_get_all();
		$cbo_payterm = $this->M_mar_master->cust_payterm_get_by_customer($row->customer_id);
        $cbo_shelf = $this->M_mar_master->shelf_get_all();
        $record_product = $this->M_mar_product->product_get_all();

        $cbo_tradingterm = $this->M_mar_master->tradingterm_get_all();
        $cbo_country = $this->M_gen_master->get_all('country');
        $cbo_port = $this->M_mar_master->port_get_all();
        $cbo_container = $this->M_mar_master->container_get_all();
        $cbo_shipping_line = $this->M_gen_master->get_all('shipping_line');
        $cbo_brand = $this->M_mar_master->brand_get_all();

        $cbo_agent = $this->M_mar_master->agent_get_all_active();

        $data = array(
            'message'					=> $this->session->flashdata('message'),
            'act'						=> set_value('act', 'edit'),
            'action'					=> site_url('sales-quotation/submit'),
            'header_title'				=> 'Sales Quotation',
            'submit_caption'			=> 'Update',
            'current_date'				=> date('m-d-Y'),
            'cbo_customer'				=> $cbo_customer,
            'cbo_currency'				=> $cbo_currency,
            'cbo_marketing'				=> $cbo_marketing,
            'cbo_sales'					=> $cbo_sales,
            'cbo_agent'					=> $cbo_agent,
            'cbo_status'				=> $cbo_status,
            'cbo_payterm'				=> $cbo_payterm,
            'cbo_shelf'					=> $cbo_shelf,
            'cbo_brand'					=> $cbo_brand,
            'record_product'			=> $record_product,
            'detail'					=> $detail,
            'agent_list'				=> $agent_list,
            'btn_print'					=> '<a href="' . site_url('sales-quotation/generate-pdf/?id=' . encode_str($row->quotation_hdr_id)) . '&no=' . encode_str($row->quotation_number) . '&dt=' . encode_str(date('d-M-Y', strtotime($row->document_date))) . '" class="btn btn-warning pull-right" id="btn_print" target="_blank"><i class="fa fa-print"></i> Print ...</a>',
            'btn_delete'				=> '<input type="button" class="btn btn-danger fontawesome-font" value="&#xf014 Delete" id="btn_delete" headerid="' . encode_str($id) . '" data-number="' . $row->quotation_number . '">',
            'factory_id'				=> $row->factory_id,
            'quotation_hdr_id'			=> set_value('quotation_hdr_id', encode_str($id), true),
            'quotation_number'			=> set_value('quotation_number', $row->quotation_number, true),
            'customer_id'				=> set_value('customer_id', $row->customer_id, true),
            'customer_code'             => set_value('customer_code', $row->customer_code, true),
            'customer_name'				=> set_value('customer_name', $row->customer_name, true),
            'customer_contact_name'		=> set_value('customer_contact_name', $row->customer_contact_name, true),
            'customer_reference'		=> set_value('customer_reference', $row->customer_reference, true),
            'local_currency'			=> set_value('local_currency', $row->currency_id, true),
            'rate_usd'					=> set_value('rate_usd', $row->rate_usd, true),
            'rate_sgd'					=> set_value('rate_sgd', $row->rate_sgd, true),
            'sales_id'					=> set_value('sales_id', $row->sales_id, true),
            'status_id'					=> set_value('status_id', $row->status_id, true),
			'payment_term_id'			=> set_value('payment_term_id', $row->payment_term_id, true),
            'payment_term'				=> set_value('payment_term', $row->payment_terms, true),
            'product_shelf_life_id'		=> set_value('product_shelf_life_id', $row->product_shelf_life_id, true),
            'document_date'				=> set_value('document_date', tgl_ind($row->document_date), true),
            'validity_date'				=> set_value('validity_date', tgl_ind($row->validity_date), true),
            'shipping_period1'			=> set_value('shipping_period1', $row->shipping_period1, true),
            'shipping_period2'			=> set_value('shipping_period2', $row->shipping_period2, true),
            'total_before_disc'			=> set_value('total_before_disc', number_format($row->total_before_disc, 2, '.', ','), true),
            'discount'					=> set_value('dicount', $row->discount, true),
            'total_disc'				=> set_value('total_disc', number_format($row->total_disc, 2, '.', ','), true),
            'freight'					=> set_value('freight', $row->freight, true),
            'tax'						=> set_value('tax', $row->tax, true),
            'final_total'				=> set_value('final_total', number_format($row->final_total, 2, '.', ','), true),
            'quotation_remark'			=> set_value('quotation_remark', $row->quotation_remark, true),
            //Additional Info
            'cbo_tradingterm'			=> $cbo_tradingterm,
            'trading_term_id'			=> set_value('trading_term_id', $row->trading_term_id, true),
            'trading_term_name'         => set_value('trading_term_name', $row->trading_term_name, true),
            'shipment_from'				=> set_value('shipment_from', $row->shipment_from, true),
            'shipping_mode'				=> set_value('shipping_mode', $row->shipping_mode, true),
            'cbo_destination'			=> $cbo_country,
            'cbo_port'					=> $cbo_port,
            'cbo_container'				=> $cbo_container,
            'cbo_shipping_line'			=> $cbo_shipping_line,
            'destination_id'			=> set_value('destination_id', $row->destination_id, true),
            'port_id'					=> set_value('port_id', $row->port_id, true),
            'container_id'				=> set_value('container_id', $row->container_id, true),
            'partial_shipment'			=> set_value('partial_shipment', $row->partial_shipment, true),
            'marine_insurance'			=> set_value('marine_insurance', $row->marine_insurance, true),
            'shipping_id'				=> set_value('shipping_id', $row->shipping_id, true),
            'shipment_schedule'			=> set_value('shipment_schedule', $row->shipment_schedule, true),
        );

        $this->template->display('factory/sales_quotation_view', $data);
    }

    function confirmation_sales_quotation()
    {
        $param_search	= '';
		$shipdate1		= date('01/m/Y');
		$shipdate2		= date('t/m/Y');
		$rec_count		= 0;

        if ($this->input->server('REQUEST_METHOD') == 'POST'){
			$q				= $this->M_factory->product_po();
			$rec_count		= $q->num_rows();
			$record			= $q->result();
			$param_search	= $this->input->post('param_search');
			$shipdate1		= $this->input->post('ship_date1');
			$shipdate2		= $this->input->post('ship_date2');
		}
    }

    function updatesales($id)
    {
        //$id = $this->input->get('id');
        $by = $this->session->userdata('userid_1');
        $dateby = date('Y-m-d H:i:s');

        $data = array(
                'factoryview' => 1,
                'downloadedby' => $by,
                'downloadeddate' => $dateby
            );

        $this->M_factory->updatestatussales($id,$data);

        // echo $id;
    }

    function view_product_bulanan(){
        $cbo_product = $this->M_factory->getProduct();
        $id = $this->input->get('idp');
        $tgl1 = $this->input->get('posting_date1');
        $tgl2 = $this->input->get('posting_date2');
        // echo $tgl1;
        if(!empty($tgl1)){
            $param_postdate1 = $tgl1;
            $param_postdate2 = $tgl2;
            $tgl_1 = dmy_to_ymd($param_postdate1);
            $tgl_2 = dmy_to_ymd($param_postdate2);
            $ini = $this->M_factory->getDataPro($id, $tgl_1, $tgl_2);
        }
        else
        {
            $param_postdate1    = date('01/m/Y');
            $param_postdate2    = date('t/m/Y');
            $ini = "";
        }
        $data = array(
            'cbo_product' => $cbo_product,
            'current_date'  => date('d/m/Y'),
            'prod' => $id,
            'tampilprod' => $ini,
            'posting_date1'     => set_value('posting_date1', date($param_postdate1), true),
            'posting_date2'     => set_value('posting_date2', date($param_postdate2), true),
            );

        $this->template->display('factory/sales_quotation_produk', $data);

    }

    
    function generate_pdf() {
        $header_id = decode_str($this->input->get('id'));
        $factory_id = $this->input->get('fid');
        $by = $this->session->userdata('userid_1');
        $dateby = date('Y-m-d H:i:s');
        // echo $header_id;
       

        if($factory_id == 3)
        {
            $data1 = array(
                'factoryview' => 1,
                'downloadedby' => $by,
                'downloadeddate' => $dateby
            );
        }
        else
        {
            $data1 = array(
                'factoryview' => 1,
                'downloadedbypsg' => $by,
                'downloadeddatepsg' => $dateby
            );

        }
        $this->M_factory->updatestatussales($header_id, $data1);


        $data = array(
            'record_header' => $this->M_mar_sales_quotation->get_by_id($header_id),
            'record_detail' => $this->M_factory->sales_quotation_detail($header_id, $factory_id),
        );
        // $this->load->view('marketing/quotation/print', $data);
		
		// update 22 Desember 2017, menghilangkan unit price (tambah file print.php di modul factory)
		$this->load->view('factory/print', $data);
    }

}
