<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Master extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('userid_1')) {
			redirect('login');
		}

		$this->load->model('M_gen_master');
		$this->load->model('M_mar_master');

		$this->load->library('form_validation');
	}

	function index($nama_master)
	{
		$get_all = $this->M_gen_master->get_all($nama_master);

		switch ($nama_master) {
			case 'customer':
				$data = array(
					'customer_data' => $get_all
				);
				$data['message'] = $this->session->flashdata('message');
				$this->template->display('general/master/customer/list', $data);
				break;

			case 'group_customer':
				$data = array(
					'group_customer_data' => $get_all
				);
				$data['message'] = $this->session->flashdata('message');
				$this->template->display('general/master/group_customer/list', $data);
				break;

			case '	':
				$data = array(
					'vendor_data' => $get_all
				);
				$data['massage'] = $this->session->flashdata('massage');
				$this->template->display('general/master/vendor/mstvendor', $data);
				break;

			case 'group_vendor':
				$data = array(
					'group_vendor_data' => $get_all
				);
				$data['massage'] = $this->session->flashdata('massage');
				$this->template->display('general/master/vendor_group/mstvendor_group', $data);
				break;
			default:
				break;
		}
	}

	function country()
	{
		$get_all = $this->M_gen_master->get_all('country');
		$data = array(
			'country_data' => $get_all
		);
		$data['message'] = $this->session->flashdata('message');
		$this->template->display('general/master/country/list', $data);
	}

	function currency()
	{
		$get_all = $this->M_gen_master->get_all('currency');
		$data = array(
			'currency_data' => $get_all
		);
		$data['message'] = $this->session->flashdata('message');
		$this->template->display('general/master/currency/list', $data);
	}

	function customer()
	{
		$this->index('customer');
	}

	function group_customer()
	{
		$this->index('group_customer');
	}

	function vendor()
	{
		$this->index('vendor');
	}

	function group_vendor()
	{
		$this->index('group_vendor');
	}


	function create_master($nama_master)
	{
		switch ($nama_master) {
			case 'country':
				$this->do_create_country();
				break;

			case 'currency':
				$this->do_create_currency();
				break;

			case 'customer':
				$this->do_create_customer();
				break;

			case 'group_customer':
				$this->do_create_customer_group();
				break;

			case 'vendor':
				$this->do_create_vendor();
				break;

			case 'group_vendor';
				$this->do_create_group_vendor();
				break;

			default:
				break;
		}
	}

	function edit_master($nama_master, $id)
	{
		switch ($nama_master) {
			case 'country':
				$this->do_edit_country($id);
				break;

			case 'currency':
				$this->do_edit_currency($id);
				break;

			case 'customer':
				$this->do_edit_customer($id);
				break;

			case 'group_customer':
				$this->do_edit_customer_group($id);
				break;
			case 'vendor';
				$this->do_edit_vendor($id);
				break;
			case 'group_vendor';
				$this->do_edit_group_vendor($id);
				break;

			default:
				break;
		}
	}

	function delete($nama_master, $id)
	{
		$row = $this->M_gen_master->get_by_id($nama_master, $id);

		if ($row) {
			$this->M_gen_master->delete($nama_master, $id);
			$this->session->set_flashdata('message', pesan('Delete Record Success', pesan_sukses()));
			redirect(site_url('master/' . $nama_master));
		} else {
			$this->session->set_flashdata('message', pesan('Record Not Found', pesan_peringatan()));
			redirect(site_url('master/' . $nama_master));
		}
	}

	function do_create_country()
	{
		$data = array(
			'button'		=> 'Save',
			'action'		=> site_url('master/save_country'),
			'header_title'	=> 'Master Country - Create New',
			'country_id'	=> set_value('country_id'),
			'country_name'	=> set_value('country_name'),
			'country_ids'	=> set_value('country_ids'),
			'country_idn'	=> set_value('country_idn'),
			'form_id' 		=> set_value('form_id')
		);
		$this->template->display('general/master/country/form', $data);
	}

	function do_create_currency()
	{
		$data = array(
			'button'					=> 'Save',
			'action'					=> site_url('master/save_currency'),
			'header_title'				=> 'Master Currency - Create New',
			'currency_id'				=> set_value('currency_id'),
			'currency_name'				=> set_value('currency_name'),
			'currency_symbol'			=> set_value('currency_symbol'),
			'currency_say_in_words'		=> set_value('currency_say_in_words'),
			'currency_say_in_words2'	=> set_value('currency_say_in_words2'),
		);
		$this->template->display('general/master/currency/form', $data);
	}


	function do_create_customer()
	{
		$cbo_country	= $this->M_gen_master->get_all('country');
		$cbo_group		= $this->M_gen_master->get_all('group_customer');
		$list_document	= $this->M_mar_master->document_get_all();

		//update 2016-07
		$cbo_payterm	= $this->M_mar_master->paymentterm_get_all();
		//update 2018-01-24
		$cbo_bank		= $this->M_mar_master->bank_get_all();

		$data = array(
			'button'				=> '<i class="fa fa-save"></i> Save',
			'action'				=> site_url('master/save_master_customer'),
			'header_title'			=> 'Master Customer - Create New',
			'cbo_country'			=> $cbo_country,
			'cbo_group'				=> $cbo_group,
			'list_document'			=> $list_document,
			'cbo_payterm'			=> $cbo_payterm,
			'cbo_bank'				=> $cbo_bank,
			'selected_document'		=> '',
			'detail_payterm'		=> '',
			'detail_bank'			=> '',
			'product'				=> '',
			'customer_group_id'		=> set_value('customer_group_id', '', true),
			'customer_id'			=> set_value('customer_id', '', true),
			//			'customer_code'			=> set_value('customer_code', '', true),
			'customer_name'			=> set_value('customer_company_name', '', true),
			'customer_company_name'	=> set_value('customer_company_name'), '', true,
			'country_id'			=> set_value('country_id', '', true),
			'customer_reference'	=> set_value('customer_reference', '', true),
			'customer_contract_no'	=> set_value('customer_contract_no', '', true),
			'customer_address'		=> set_value('customer_address', '', true),
			'customer_phone'		=> set_value('customer_phone', '', true),
			'customer_fax'			=> set_value('customer_fax', '', true),
			'customer_email'		=> set_value('customer_email', '', true),
			'customer_contact_name'	=> set_value('customer_contact_name', '', true),
			'customer_contact_phone' => set_value('customer_contact_name', '', true),
			'customer_contact_email' => set_value('customer_contact_name', '', true),
			'po_remark_default'		=> set_value('po_remark_default', '', true),
			'si_consignee_default'	=> set_value('si_consignee_default', '', true),
		);

		$this->template->display('general/master/customer/create', $data);
	}

	function save_master_customer()
	{
		//		$this->_rules_customer();
		//
		//		if ($this->form_validation->run() == FALSE) {
		//            $this->create_master('customer');
		//        } else {

		$data = array(
			//				'customer_code'			=> $this->input->post('customer_code',TRUE),
			'customer_name'			=> $this->input->post('customer_company_name', TRUE),
			'customer_company_name'	=> $this->input->post('customer_company_name', TRUE),
			'customer_group_id'		=> $this->input->post('customer_group_id', TRUE),
			'country_id'			=> $this->input->post('country_id', TRUE),
			'customer_reference'	=> $this->input->post('customer_reference', TRUE),
			'customer_contract_no'	=> $this->input->post('customer_contract_no', TRUE),
			'customer_address'		=> $this->input->post('customer_address', TRUE),
			'customer_phone'		=> $this->input->post('customer_phone', TRUE),
			'customer_fax'			=> $this->input->post('customer_fax', TRUE),
			'customer_email'		=> $this->input->post('customer_email', TRUE),
			'customer_contact_name'	=> $this->input->post('customer_contact_name', TRUE),
			'customer_contact_phone' => $this->input->post('customer_contact_phone', TRUE),
			'customer_contact_email' => $this->input->post('customer_contact_email', TRUE),
			'status_customer'		=> '1',
			'po_remark_default'		=> $this->input->post('po_remark_default', TRUE),
			'si_consignee_default'	=> $this->input->post('si_consignee_default', TRUE),
			'created_by'			=> strtoupper($this->session->userdata('userid_1')),
			'created_date'			=> date('Y-m-d H:i:s')
		);

		$company_name = $this->input->post('customer_company_name', TRUE);
		$param = array(
			'customer_company_name'	=> $company_name,
		);

		if ($this->M_mar_master->cust_exists($param) == false) {
			$customer_id	= $this->M_mar_master->cust_insert($data);
			$customer_code	= $this->M_mar_master->cust_update_code($customer_id, $company_name);
			if ($customer_id != 0) {
				$this->M_mar_master->cust_payterm_insert($customer_id);
				$this->M_mar_master->cust_bank_insert($customer_id);
				$this->M_mar_master->cust_document_insert($customer_id);
				$this->M_mar_master->cust_product_insert($customer_id);
			}
			$this->session->set_flashdata('message', pesan('Success Create Customer <strong>' . $company_name . '</strong> with code <strong>' . $customer_code . '</strong>', pesan_sukses()));
		} else {
			$this->session->set_flashdata('message', pesan('<strong>' . $company_name . '</strong> already exists', pesan_peringatan()));
		}

		redirect(site_url('master/customer'));
		//        }
	}

	function do_find_customer()
	{
		$cbo_country = $this->M_gen_master->get_all('country');

		$data = array(
			'button'				=> '<i class="fa fa-search"></i> Search ...',
			'action'				=> site_url('general/find_master/customer'),
			'header_title'			=> 'Master Customer - Search',
			'cbo_country'			=> $cbo_country,
			//			'customer_name' 		=> set_value('customer_name', '', true),
			'customer_company_name' => set_value('customer_company_name', '', true),
			'country_id'			=> set_value('country_id', '', true),
		);

		$data['message'] = $this->session->flashdata('message');
		$this->template->display('general/master/customer/list', $data);
	}

	function do_edit_customer($id)
	{
		$row			= $this->M_mar_master->cust_get_by_id($id);
		$cbo_country	= $this->M_gen_master->get_all('country');
		$cbo_group		= $this->M_gen_master->get_all('group_customer');
		$detail_payterm = $this->M_mar_master->payterm_get_detail($id);
		$detail_bank	= $this->M_mar_master->bank_get_detail($id);
		$list_document	= $this->M_mar_master->document_get_all();
		$selected_document = $this->M_mar_master->cust_document_get_all($id);
		$product_purchased = $this->M_mar_sales_quotation->get_product_purchase($row->customer_id);

		//update 2016-07
		$cbo_payterm	= $this->M_mar_master->paymentterm_get_all();
		//update 2018-01-24
		$cbo_bank		= $this->M_mar_master->bank_get_all();

		if ($row) {
			$data = array(
				'button'				=> 'Update',
				'action'				=> site_url('master/update_customer'),
				'header_title'			=> 'Master Customer - Edit',
				'cbo_country'			=> $cbo_country,
				'cbo_group'				=> $cbo_group,
				'list_document'			=> $list_document,
				'cbo_payterm'			=> $cbo_payterm,
				'cbo_bank'				=> $cbo_bank,
				'selected_document'		=> $selected_document,
				'detail_payterm'		=> $detail_payterm,
				'detail_bank'			=> $detail_bank,
				'product'				=> $product_purchased,
				'customer_group_id'		=> set_value('customer_group_id', $row->customer_group_id),
				'customer_id'			=> set_value('customer_id', $row->customer_id),
				//				'customer_code'			=> set_value('customer_code', $row->customer_code),
				'customer_name'			=> set_value('customer_company_name', $row->customer_name),
				'customer_company_name'	=> set_value('customer_company_name', $row->customer_company_name),
				'country_id'			=> set_value('country_id', $row->country_id),
				'customer_reference'	=> set_value('customer_reference', $row->customer_reference),
				'customer_contract_no'	=> set_value('customer_contract_no', $row->customer_contract_no),
				'customer_address'		=> set_value('customer_address', $row->customer_address),
				'customer_phone'		=> set_value('customer_phone', $row->customer_phone),
				'customer_fax'			=> set_value('customer_fax', $row->customer_fax),
				'customer_email'		=> set_value('customer_email', $row->customer_email),
				'customer_contact_name'	=> set_value('customer_contact_name', $row->customer_contact_name),
				'customer_contact_phone' => set_value('customer_contact_phone', $row->customer_contact_phone),
				'customer_contact_email' => set_value('customer_contact_email', $row->customer_contact_email),
				'po_remark_default'		=> set_value('po_remark_default', $row->po_remark_default),
				'si_consignee_default'	=> set_value('si_consignee_default', $row->si_consignee_default),
			);

			$this->template->display('general/master/customer/create', $data);
		} else {
			$this->session->set_flashdata('message', pesan('Record Not Found', pesan_error()));
			redirect(site_url('master/customer'));
		}
	}


	function get_product_purchase()
	{
		if ('IS_AJAX') {
			$customer_id		= $this->input->post('customer_id');
			$product_purchase	= $this->M_mar_sales_quotation->get_product_purchase($customer_id);

			$data = array(
				'product'		=> $product_purchase,
			);

			$this->load->view('marketing/master/customer/product_purchase', $data);
		}
	}

	function update_customer()
	{
		//        $this->_rules_customer();
		//
		//        if ($this->form_validation->run() == FALSE) {
		//            $this->do_edit_customer($this->input->post('customer_id', TRUE));
		//        } else {
		$data = array(
			//				'customer_code'			=> $this->input->post('customer_code',TRUE),
			'customer_name'			=> $this->input->post('customer_company_name', TRUE),
			'customer_company_name'	=> $this->input->post('customer_company_name', TRUE),
			'customer_group_id'		=> $this->input->post('customer_group_id', TRUE),
			'country_id'			=> $this->input->post('country_id', TRUE),
			'customer_reference'	=> $this->input->post('customer_reference', TRUE),
			'customer_contract_no'	=> $this->input->post('customer_contract_no', TRUE),
			'customer_address'		=> $this->input->post('customer_address', TRUE),
			'customer_phone'		=> $this->input->post('customer_phone', TRUE),
			'customer_fax'			=> $this->input->post('customer_fax', TRUE),
			'customer_email'		=> $this->input->post('customer_email', TRUE),
			'customer_contact_name'	=> $this->input->post('customer_contact_name', TRUE),
			'customer_contact_phone' => $this->input->post('customer_contact_phone', TRUE),
			'customer_contact_email' => $this->input->post('customer_contact_email', TRUE),
			'po_remark_default'		=> $this->input->post('po_remark_default', TRUE),
			'si_consignee_default'	=> $this->input->post('si_consignee_default', TRUE),
			'updated_by'			=> strtoupper($this->session->userdata('userid_1')),
			'updated_date'			=> date('Y-m-d H:i:s'),
		);

		$customer_id = $this->input->post('customer_id', TRUE);

		$this->M_mar_master->cust_payterm_delete($customer_id);
		$this->M_mar_master->cust_bank_delete($customer_id);
		$this->M_mar_master->cust_document_delete($customer_id);
		$this->M_mar_master->cust_product_delete($customer_id);

		$this->M_mar_master->cust_update($customer_id, $data);

		$this->M_mar_master->cust_payterm_insert($customer_id);
		$this->M_mar_master->cust_bank_insert($customer_id);
		$this->M_mar_master->cust_document_insert($customer_id);
		$this->M_mar_master->cust_product_insert($customer_id);

		$this->session->set_flashdata('message', pesan('Update Record Success', pesan_sukses()));
		redirect(site_url('master/master/customer'));
		//        }
	}





	//---------------------------------Customer Group-------------------------------


	private function do_create_customer_group()
	{
		$data = array(
			'button'				=> '<i class="fa fa-save"></i> Save',
			'action'				=> site_url('master/save_master_customer_group'),
			'header_title'			=> 'Master Customer Group - Create New',
			'customer_group_id'		=> set_value('customer_group_id', '', true),
			'customer_group_name'	=> set_value('customer_group_name', '', true),
			'coa'					=> set_value('coa', '', true),
		);

		$this->template->display('general/master/group_customer/create', $data);
	}

	function save_master_customer_group()
	{
		$this->_rules_customer_group();

		if ($this->form_validation->run() == FALSE) {
			$this->create_master('group_customer');
		} else {
			$data = array(
				'customer_group_name'	=> $this->input->post('customer_group_name', TRUE),
				'coa'					=> $this->input->post('coa', TRUE),
				'created_by'			=> strtoupper($this->session->userdata('userid_1')),
				'created_date'			=> date('Y-m-d H:i:s')
			);

			$this->M_gen_master->insert('group_customer', $data);
			$this->session->set_flashdata('message', pesan('Create Record Success', pesan_sukses()));
			redirect(site_url('master/group_customer'));
		}
	}

	function do_edit_customer_group($id)
	{
		$row			= $this->M_gen_master->get_by_id('group_customer', $id);

		if ($row) {
			$data = array(
				'button'				=> 'Update',
				'action'				=> site_url('master/update_customer_group'),
				'header_title'			=> 'Master Customer - Edit',
				'customer_group_id'		=> set_value('customer_group_id', $row->customer_group_id),
				'customer_group_name'	=> set_value('customer_group_name', $row->customer_group_name),
				'coa'					=> set_value('coa', $row->coa),
			);

			$this->template->display('general/master/customer_group/create', $data);
		} else {
			$this->session->set_flashdata('message', pesan('Record Not Found', pesan_error()));
			redirect(site_url('master/group_customer'));
		}
	}

	function update_customer_group()
	{
		$this->_rules_customer_group();

		if ($this->form_validation->run() == FALSE) {
			$this->do_edit_customer_group($this->input->post('customer_group_id', TRUE));
		} else {
			$data = array(
				//				'customer_group_id'		=> $this->input->post('customer_group_id', TRUE),
				'customer_group_name'	=> $this->input->post('customer_group_name', TRUE),
				'coa'					=> $this->input->post('coa', TRUE),
				'updated_by'			=> strtoupper($this->session->userdata('userid_1')),
				'updated_date'			=> date('Y-m-d H:i:s'),
			);

			$customer_group_id = $this->input->post('customer_group_id', TRUE);

			$this->M_gen_master->update('group_customer', $customer_group_id, $data);

			$this->session->set_flashdata('message', pesan('Update Record Success', pesan_sukses()));
			redirect(site_url('master/group_customer'));
		}
	}

	function _rules_customer_group()
	{
		$this->form_validation->set_rules('customer_group_name', 'customer_group_name code', 'trim|required');
		$this->form_validation->set_rules('coa', 'coa', 'trim|required');

		$this->form_validation->set_rules('customer_group_id', 'customer group id', 'trim');
		$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
	}

	//---------------------------------Customer Group-------------------------------


	//    -------------------------------------------------------------------ABOUT VENDOR---------------------------------------------------
	private function do_create_vendor()
	{
		$data = array(
			'button'				=> '<i class="fa fa-save"></i> Save',
			'action'				=> site_url('master/save_master_vendor'),
			'header_title'			=> 'Master Customer Group - Create New',
			'customer_group_id'		=> set_value('customer_group_id', '', true),
			'customer_group_name'	=> set_value('customer_group_name', '', true),
			'coa'					=> set_value('coa', '', true),
		);

		$this->template->display('general/master/vendor/mstvendor', $data);
	}


	function save_master_vendor()
	{
		$this->_rules_customer_group();

		if ($this->form_validation->run() == FALSE) {
			$this->create_master('group_customer');
		} else {
			$data = array(
				'customer_group_name'	=> $this->input->post('customer_group_name', TRUE),
				'coa'					=> $this->input->post('coa', TRUE),
				'created_by'			=> strtoupper($this->session->userdata('userid_1')),
				'created_date'			=> date('Y-m-d H:i:s')
			);

			$this->M_gen_master->insert('group_customer', $data);
			$this->session->set_flashdata('message', pesan('Create Record Success', pesan_sukses()));
			redirect(site_url('master/group_customer'));
		}
	}

	function do_edit_vendor($id)
	{
		$row			= $this->M_gen_master->get_by_id('group_customer', $id);

		if ($row) {
			$data = array(
				'button'				=> 'Update',
				'action'				=> site_url('master/update_customer_group'),
				'header_title'			=> 'Master Customer - Edit',
				'customer_group_id'		=> set_value('customer_group_id', $row->customer_group_id),
				'customer_group_name'	=> set_value('customer_group_name', $row->customer_group_name),
				'coa'					=> set_value('coa', $row->coa),
			);

			$this->template->display('general/master/customer_group/create', $data);
		} else {
			$this->session->set_flashdata('message', pesan('Record Not Found', pesan_error()));
			redirect(site_url('master/group_customer'));
		}
	}


	function update_vendor()
	{
		$this->_rules_vendor();

		if ($this->form_validation->run() == FALSE) {
			$this->do_edit_customer_group($this->input->post('customer_group_id', TRUE));
		} else {
			$data = array(
				//				'customer_group_id'		=> $this->input->post('customer_group_id', TRUE),
				'customer_group_name'	=> $this->input->post('customer_group_name', TRUE),
				'coa'					=> $this->input->post('coa', TRUE),
				'updated_by'			=> strtoupper($this->session->userdata('userid_1')),
				'updated_date'			=> date('Y-m-d H:i:s'),
			);

			$customer_group_id = $this->input->post('customer_group_id', TRUE);

			$this->M_gen_master->update('group_customer', $customer_group_id, $data);

			$this->session->set_flashdata('message', pesan('Update Record Success', pesan_sukses()));
			redirect(site_url('master/group_customer'));
		}
	}

	function _rules_vendor()
	{
		$this->form_validation->set_rules('customer_group_name', 'customer_group_name code', 'trim|required');
		$this->form_validation->set_rules('coa', 'coa', 'trim|required');

		$this->form_validation->set_rules('customer_group_id', 'customer group id', 'trim');
		$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
	}

	// public function vendor (){
	//     $data['supp']=  $this->m_purchasing->tampil_supp_limit();
	//     $data['group']=  $this->m_purchasing->tampil_supp_group();
	//     $this->template->display('purchasing/mstvendor',$data);
	// }

	public function vendor_search()
	{
		$vendor = $this->input->get('vendor');
		$data['supp'] =  $this->m_purchasing->tampil_supp($vendor);
		$this->load->view('purchasing/mstvendor_edit_dtl', $data);
	}

	public function vendor_edit()
	{
		$vendor = $this->input->get('vendor');
		$data['supp'] =  $this->m_purchasing->tampil_supp_where($vendor);
		$data['group'] =  $this->m_purchasing->tampil_supp_group();
		$this->template->display('purchasing/mstvendor_edit', $data);
	}

	public function vendor_delete()
	{
		$vendor = $this->input->get('vendor');
		$query = $this->M_gen_master->delete_vendor($vendor, strtoupper($this->session->userdata('userid_1')));

		if ($query == 1) {
			$this->session->set_flashdata("message", "<div class=\"alert alert-warning\" id=\"alert\">Delete Data Success</div>");
			redirect('master/vendor');
		} else {
			$this->session->set_flashdata("message", "<div class=\"alert alert-danger\" id=\"alert\">Transaction Broken</div>");
			redirect('master/vendor');
		}
	}

	public function vendor_save($trans)
	{
		$vendorid = trim($this->input->post('vendorid'));
		$vendorcompany = $this->input->post('vendorcompany');
		$address =  nl2br($this->input->post('address'));
		$contact =  $this->input->post('contact');
		$email =  $this->input->post('email');
		$telephone =  $this->input->post('telephone');
		$mobile =  $this->input->post('mobile');
		$did =  $this->input->post('did');
		$fax =  $this->input->post('fax');
		$postal =  $this->input->post('postal');
		$term =  $this->input->post('term');
		$taxcode =  $this->input->post('taxcode');
		$taxprice =  $this->input->post('taxprice');
		$website =  $this->input->post('website');
		$group =  $this->input->post('group');

		if ($trans == 'add') {

			$cek = $this->m_purchasing->cek('pur_tbl_mst_supplier', 'supplierid = "' . $vendorid . '"');

			if ($cek == 1) {
				$this->session->set_flashdata("message", "<div class=\"alert alert-warning\" id=\"alert\">Duplicate Vendor " . $vendorid . "</div>");
				redirect('purchasing/vendor');
			}

			$data = array(
				'supplierid' => $vendorid, 'suppliercompany' => $vendorcompany, 'contactperson' => $contact,
				'address' => $address, 'telephone' => $telephone, 'mobilephone' => $mobile, 'did' => $did, 'fax' => $fax,
				'email' => $email, 'postalcode' => $postal, 'paymentterm' => $term, 'taxcode' => $taxcode, 'taxprice' => $taxprice, 'website' => $website, 'groupid' => $group,
				'createdby' => strtoupper($this->session->userdata('userid_1')), 'createddate' => date('Y-m-d H:i:s')
			);
			$query = $this->m_purchasing->simpan_vendor($data);
			$message = 'Save Data Success';
		} else {
			$data = array(
				'suppliercompany' => $vendorcompany, 'contactperson' => $contact,
				'address' => $address, 'telephone' => $telephone, 'mobilephone' => $mobile, 'did' => $did, 'fax' => $fax,
				'email' => $email, 'postalcode' => $postal, 'paymentterm' => $term, 'taxcode' => $taxcode, 'taxprice' => $taxprice, 'website' => $website, 'groupid' => $group,
				'lastupdatedby' => strtoupper($this->session->userdata('userid_1')), 'lastupdateddate' => date('Y-m-d H:i:s')
			);
			$query = $this->m_purchasing->update_vendor($vendorid, $data, strtoupper($this->session->userdata('userid_1')));
			$message = 'Update Data Success';
		}

		if ($query == 1) {
			$this->session->set_flashdata("message", "<div class=\"alert alert-success\" id=\"alert\">$message</div>");
			redirect('purchasing/vendor');
		} else {
			$this->session->set_flashdata("message", "<div class=\"alert alert-danger\" id=\"alert\">Transaction Broken</div>");
			redirect('purchasing/vendor');
		}
	}

	public function vendor_group()
	{
		$data['group'] =  $this->m_purchasing->tampil_supp_group();
		$data['coa'] =  $this->m_purchasing->tampil_coa('trade accounts pay');
		$this->template->display('purchasing/mstvendor_group', $data);
	}

	public function vendor_group_delete()
	{
		$this->m_purchasing->delete_vendor_group($this->uri->segment(3));
		$this->session->set_flashdata("message", "<div class=\"alert alert-warning\" id=\"alert\">Delete Data Success</div>");
		redirect('purchasing/vendor_group');
	}


	//---------------------------vendor group--------------------------    
	private function do_create_group_vendor()
	{
		$data = array(
			'button'				=> '<i class="fa fa-save"></i> Save',
			'action'				=> site_url('master/vendor_group_save'),
			'header_title'			=> 'Master Vendor Group - Create New',
			'id'					=> set_value('id', '', true),
			'group'					=> set_value('group', '', true),
			'coa'					=> set_value('coa', '', true),
		);

		$this->template->display('general/master/vendor_group/mstvendor_group', $data);
	}

	public function vendor_group_save()
	{
		$id =  $this->input->post('id');
		$group =  $this->input->post('group');
		$coa =  $this->input->post('coa');

		if ($id == '') {
			$data = array('group' => $group, 'nocoa' => $coa, 'createdby' => strtoupper($this->session->userdata('userid_1')), 'createddate' => date('Y-m-d H:i:s'));
			$this->M_gen_master->simpan_vendor_group($data);
			$message = 'Save Data Success';
		} else {
			$data = array('group' => $group, 'nocoa' => $coa, 'lastupdatedby' => strtoupper($this->session->userdata('userid_1')), 'lastupdateddate' => date('Y-m-d H:i:s'));
			$this->M_gen_master->update_vendor_group($id, $data);
			$message = 'Update Data Success';
		}

		$this->session->set_flashdata("message", "<div class=\"alert alert-success\" id=\"alert\">$message</div>");
		redirect('master/group_vendor');
	}


	//---------------------------------Vendor--------------------------------------

	function save_country()
	{
		$this->_rules_country();

		if ($this->form_validation->run() == FALSE) {
			$this->create_master('country');
		} else {
			$data = array(
				'country_name'	=> $this->input->post('country_name', TRUE),
				'country_ids'	=> $this->input->post('country_ids', TRUE),
				'country_idn'	=> $this->input->post('country_idn', TRUE),
				'created_by'	=> strtoupper($this->session->userdata('userid_1')),
				'created_date'	=> date('Y-m-d H:i:s'),
				'form_id' 		=> $this->input->post('form_id', TRUE)
			);

			$this->M_gen_master->insert('country', $data);
			$this->session->set_flashdata('message', pesan('Create Record Success', pesan_sukses()));
			redirect(site_url('master/country'));
		}
	}

	function save_currency()
	{
		$this->_rules_currency();

		if ($this->form_validation->run() == FALSE) {
			$this->create_master('currency');
		} else {
			$data = array(
				'currency_id'			 => strtoupper($this->input->post('currency_id', TRUE)),
				'currency_name'			 => $this->input->post('currency_name', TRUE),
				'currency_symbol'		 => strtoupper($this->input->post('currency_symbol', TRUE)),
				'currency_say_in_words'	 => $this->input->post('currency_say_in_words', TRUE),
				'currency_say_in_words2' => $this->input->post('currency_say_in_words2', TRUE),
				'created_by'			 => strtoupper($this->session->userdata('userid_1')),
				'created_date'			 => date('Y-m-d H:i:s')
			);

			$this->M_gen_master->insert('currency', $data);
			$this->session->set_flashdata('message', pesan('Create Record Success', pesan_sukses()));
			redirect(site_url('master/currency'));
		}
	}

	function do_edit_country($id)
	{
		$row = $this->M_gen_master->get_by_id('country', $id);

		if ($row) {
			$data = array(
				'button'		=> 'Update',
				'action'		=> site_url('master/update_country'),
				'header_title'	=> 'Master Country - Edit',
				'country_id'	=> set_value('country_id', $row->country_id),
				'country_name'	=> set_value('country_name', $row->country_name),
				'country_ids'	=> set_value('country_ids', $row->country_ids),
				'country_idn'	=> set_value('country_idn', $row->country_idn),
				'form_id' 		=> set_value('form_id', $row->form_id)
			);
			$this->template->display('general/master/country/form', $data);
		} else {
			$this->session->set_flashdata('message', pesan('Record Not Found', pesan_peringatan()));
			redirect(site_url('master/country'));
		}
	}

	function do_edit_currency($id)
	{
		$row = $this->M_gen_master->get_by_id('currency', $id);

		if ($row) {
			$data = array(
				'button'				 => 'Update',
				'action'				 => site_url('master/update_currency'),
				'header_title'			 => 'Master Currency - Edit',
				'currency_id'			 => set_value('currency_id', $row->currency_id),
				'currency_name'			 => set_value('currency_name', $row->currency_name),
				'currency_symbol'		 => set_value('currency_symbol', $row->currency_symbol),
				'currency_say_in_words'	 => set_value('currency_say_in_words', $row->currency_say_in_words),
				'currency_say_in_words2' => set_value('currency_say_in_words2', $row->currency_say_in_words)
			);
			$this->template->display('general/master/currency/form', $data);
		} else {
			$this->session->set_flashdata('message', pesan('Record Not Found', pesan_peringatan()));
			redirect(site_url('master/currency'));
		}
	}

	function update_country()
	{
		$this->_rules_country();

		if ($this->form_validation->run() == FALSE) {
			$this->update($this->input->post('country_id', TRUE));
		} else {
			$data = array(
				'country_name'	=> $this->input->post('country_name', TRUE),
				'country_ids'	=> $this->input->post('country_ids', TRUE),
				'country_idn'	=> $this->input->post('country_idn', TRUE),
				'updated_by'	=> strtoupper($this->session->userdata('userid_1')),
				'updated_date'	=> date('Y-m-d H:i:s'),
				'form_id'       => $this->input->post('form_id', TRUE)
			);

			$this->M_gen_master->update('country', $this->input->post('country_id', TRUE), $data);
			$this->session->set_flashdata('message', pesan('Update Record Success', pesan_sukses()));
			redirect(site_url('master/country'));
		}
	}

	function update_currency()
	{
		$this->_rules_currency();

		if ($this->form_validation->run() == FALSE) {
			$this->update($this->input->post('currency_id', TRUE));
		} else {
			$data = array(
				'currency_id'			 => strtoupper($this->input->post('currency_id', TRUE)),
				'currency_name'			 => $this->input->post('currency_name', TRUE),
				'currency_symbol'		 => strtoupper($this->input->post('currency_symbol', TRUE)),
				'currency_say_in_words'	 => $this->input->post('currency_say_in_words', TRUE),
				'currency_say_in_words2' => $this->input->post('currency_say_in_words2', TRUE),
				'updated_by'			 => strtoupper($this->session->userdata('userid_1')),
				'updated_date'			 => date('Y-m-d H:i:s')
			);

			$this->M_gen_master->update('currency', $this->input->post('currency_id', TRUE), $data);
			$this->session->set_flashdata('message', pesan('Update Record Success', pesan_sukses()));
			redirect(site_url('master/currency'));
		}
	}

	function _rules_country()
	{
		$this->form_validation->set_rules('country_name', 'country name', 'trim|required');
		$this->form_validation->set_rules('country_ids', 'country code', 'trim|required');
		$this->form_validation->set_rules('country_idn', 'dialling code', 'trim|required');

		$this->form_validation->set_rules('country_id', 'country_id', 'trim');
		$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
	}

	function _rules_currency()
	{
		$this->form_validation->set_rules('currency_id', 'currency id', 'trim|required');
		$this->form_validation->set_rules('currency_name', 'currency name', 'trim|required');
		$this->form_validation->set_rules('currency_symbol', 'currency symbol', 'trim|required');

		$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
	}


	//==================================================================================================
	// ADDITIONAL FUNCTION
	//==================================================================================================

	function save_payterm_modal()
	{
		$customer_id	= $this->input->post('customer_id');
		$payment_term	= htmlentities($this->input->post('payment_term'), ENT_QUOTES);
		$this->M_mar_master->cust_payterm_insert_modal($customer_id, $payment_term);

		if ($customer_id) {
			$cbo_payterm	= $this->M_mar_master->payterm_get_detail($customer_id);
		} else {
			$cbo_payterm	= $this->M_mar_master->payterm_get_all();
		}

		$data = array(
			'cbo_payterm'	=> $cbo_payterm,
			'payment_term'	=> set_value('payment_term', $payment_term, true),
		);
		$this->load->view('general/reload/reload_payment_term', $data);
	}

	function add_bank_row()
	{
		$cbo_bank = $this->M_mar_master->bank_get_all();

		$data = array(
			'cbo_bank' 	=> $cbo_bank,
			'bank_id'	=> '',
		);

		$this->load->view('general/master/customer/bank_row_output', $data);
	}

	function add_payterm_row()
	{
		$cbo_payterm = $this->M_mar_master->paymentterm_get_all();

		$data = array(
			'cbo_payterm' => $cbo_payterm,
			'payment_term_id'	=> '',
		);

		$this->load->view('general/master/customer/payterm_row_output', $data);
	}
}
