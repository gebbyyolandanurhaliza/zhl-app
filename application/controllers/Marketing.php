<?php defined('BASEPATH') or exit('No direct script access allowed');

class Marketing extends CI_Controller
{

	function __construct()
	{
		parent::__construct();

		if (!$this->session->userdata('userid_1')) {
			redirect('login');
		}

		$this->load->model(array('M_gen_master', 'M_mar_master', 'M_mar_product', 'M_mar_sales_quotation'));
		$this->load->library('form_validation');
		error_reporting(1);
	}

	function master($nama_master)
	{
		switch ($nama_master) {
			case 'marketing':
				$master = $this->M_mar_master->mark_get_all();

				$data = array(
					'master_data' => $master
				);

				$data['message'] = $this->session->flashdata('message');

				$this->template->display('marketing/master/marketing/list', $data);

				break;

			case 'customer':
				//				$this->do_find_customer();

				$master = $this->M_mar_master->cust_get_all();

				$data = array(
					'master_data' => $master
				);

				$data['message'] = $this->session->flashdata('message');

				$this->template->display('marketing/master/customer/list', $data);

				break;

			case 'group_customer':
				$master = $this->M_gen_master->get_all('group_customer');

				$data = array(
					'master_data' => $master
				);

				$data['message'] = $this->session->flashdata('message');

				$this->template->display('marketing/master/customer_group/list', $data);
				break;

			case 'agent':
				$master = $this->M_mar_master->agent_get_all();

				$data = array(
					'master_data' => $master
				);

				$data['message'] = $this->session->flashdata('message');

				$this->template->display('marketing/master/agent/list', $data);
				break;

			case 'factory':
				$master = $this->M_gen_master->get_all('factory');

				$data = array(
					'master_data' => $master
				);

				$data['message'] = $this->session->flashdata('message');

				$this->template->display('marketing/master/factory/list', $data);
				break;

			case 'product':
				//				$master = $this->M_mar_product->product_get_all();
				$data['master_data'] = '';

				if ($this->input->server('REQUEST_METHOD') == 'POST') {
					$filter = $this->input->post('input_filter');
					$master = $this->M_mar_product->product_get_by_filter($filter);
					$data['master_data'] = $master;
				}

				$data['input_filter'] = $this->input->post('input_filter');
				$data['action']		= site_url('marketing/master/product');
				$data['message']	= $this->session->flashdata('message');

				$this->template->display('marketing/master/product/index', $data);
				break;

			case 'product_category':
				$master = $this->M_mar_product->product_category_get_all();

				$data = array(
					'master_data' => $master
				);

				$data['message'] = $this->session->flashdata('message');

				$this->template->display('marketing/master/product_category/list', $data);
				break;

			case 'product_packing_list':
				$master = $this->M_mar_product->product_get_all();
				$data = array(
					'message'		=> $this->session->flashdata('message'),
					'master_data'	=> $master,
				);
				$this->template->display('marketing/master/product/packing_list', $data);
				break;

			case 'brand':
				$master = $this->M_mar_master->brand_get_all();

				$data = array(
					'master_data' => $master
				);

				$data['message'] = $this->session->flashdata('message');

				$this->template->display('marketing/master/brand/list', $data);
				break;

			case 'shelf_life':
				$master = $this->M_mar_master->shelf_get_all();

				$data = array(
					'master_data' => $master
				);

				$data['message'] = $this->session->flashdata('message');

				$this->template->display('marketing/master/shelf_life/index', $data);
				break;

			case 'container':
				$master = $this->M_mar_master->container_get_all();

				$data = array(
					'master_data' => $master
				);

				$data['message'] = $this->session->flashdata('message');

				$this->template->display('marketing/master/container/list', $data);
				break;

			case 'container-zhl':

				$listContainerZhl = $this->M_mar_master->container_zhl_get_all();
				$containerMaster = $this->M_mar_master->container_get_all();

				$data = array(
					'master_data' => $listContainerZhl,
					'listContainerType' => $containerMaster
				);
				// echo "<pre>";
				// print_r($data);
				// die;

				$this->template->display('marketing/master/container_zhl/list', $data);
				break;


			case 'packing-size':
				$master = $this->M_mar_master->packing_size_get_all();

				$data = array(
					'master_data' => $master
				);

				$data['message'] = $this->session->flashdata('message');

				$this->template->display('marketing/master/packing_size/list', $data);
				break;

			case 'packing-type':
				$master = $this->M_mar_master->packing_type_get_all();

				$data = array(
					'master_data' => $master
				);

				$data['message'] = $this->session->flashdata('message');

				$this->template->display('marketing/master/packing_type/list', $data);
				break;

			case 'bank':
				$master = $this->M_mar_master->bank_get_all();

				$data = array(
					'master_data' => $master
				);

				$data['message'] = $this->session->flashdata('message');

				$this->template->display('marketing/master/bank/list', $data);
				break;

			case 'trading_term':
				$master = $this->M_mar_master->tradingterm_get_all();

				$data = array(
					'master_data'			=> $master,
					'button'				=> 'Save',
					'action'				=> 'marketing/save_master_trading_term',
					'trading_term_id'		=> set_value('trading_term_id', '', true),
					'trading_term_name'		=> set_value('trading_term_name', '', true),
					'trading_term_remark'	=> set_value('trading_term_remark', '', true),
				);

				$data['message'] = $this->session->flashdata('message');

				$this->template->display('marketing/master/trading_term/index', $data);
				break;

			case 'document':
				$master			= $this->M_mar_master->document_get_all(9);	// angka 9 untuk menampilkan semua data

				$data = array(
					'master_data'	=> $master,
				);

				$data['message'] = $this->session->flashdata('message');

				$this->template->display('marketing/master/document/list', $data);
				break;

			case 'payment_term':
				$master			= $this->M_mar_master->payterm_get_all();

				$data = array(
					'master_data'	=> $master,
					'position_id'	=> $this->session->userdata('position_id'),
				);

				$data['message'] = $this->session->flashdata('message');

				$this->template->display('marketing/master/payment_term/list', $data);
				break;

			case 'main_category':
				$master = $this->M_mar_master->maincate_get_all();

				$data = array(
					'master_data' => $master
				);

				$data['message'] = $this->session->flashdata('message');

				$this->template->display('marketing/master/main_category/list', $data);
				break;

			default:
				break;
		}
	}

	function search_product($page = '')
	{

		switch ($page) {
			case 'quotation':
				$param = $this->input->post('param');
				$not_in = $this->input->post('product_id');
				$factory = $this->input->post('factory_id');

				$data['record'] = $this->M_mar_product->product_get_by_search($param);
				//				$data['record'] = $this->M_mar_product->product_get_by_search3($param, $not_in);

				$this->load->view('marketing/quotation/add_product', $data);
				break;

			case 'contract':
				$param		= $this->input->post('param');
				$not_in		= $this->input->post('product_id');
				$factory	= $this->input->post('factory_id');

				// di contract bisa add product dari factory yg berbeda
				$data['record'] = $this->M_mar_product->product_get_by_search($param);
				//				$data['record'] = $this->M_mar_product->product_get_by_search2($param, $factory);

				$this->load->view('marketing/contract/add_product', $data);
				break;

			case 'po':
				$param		= $this->input->post('param');
				$not_in		= $this->input->post('product_id');
				$factory	= $this->input->post('factory_id');
				$data['record'] = $this->M_mar_product->product_get_by_search_po($param, $factory);

				$this->load->view('marketing/transactions/purchase_order/add_product', $data);
				break;

			case 'customer':
				$param = $this->input->post('param');
				$not_in = $this->input->post('product_id');
				//				$factory = $this->input->post('factory_id');

				$data['record'] = $this->M_mar_product->product_get_by_search3($param, $not_in);
				$this->load->view('marketing/master/customer/add_product', $data);
				break;

			case 'pi':
				$param = $this->input->post('param');
				$not_in = $this->input->post('product_id');
				//				$factory = $this->input->post('factory_id');

				$data['record'] = $this->M_mar_product->product_get_by_search3($param, $not_in);
				$this->load->view('marketing/master/customer/add_product', $data);
				break;

			default:
				$param = $this->input->post('param');
				$not_in = $this->input->post('product_id');
				//				$factory = $this->input->post('factory_id');

				$data['record'] = $this->M_mar_product->product_get_by_search($param);
				break;
		}
	}

	function create_master($nama_master)
	{
		switch ($nama_master) {
			case 'marketing':
				$this->do_create_marketing();
				break;

			case 'customer':
				$this->do_create_customer();
				break;

			case 'group_customer':
				$this->do_create_customer_group();
				break;

			case 'agent':
				$this->do_create_agent();
				break;

			case 'factory':
				$this->do_create_factory();
				break;

			case 'product':
				$this->do_create_product();
				break;

			case 'product_category':
				$this->do_create_product_category();
				break;

			case 'brand':
				$this->do_create_brand();
				break;

			case 'document':
				$this->do_create_document();
				break;

			case 'payment_term':
				$this->do_create_payment_term();
				break;

			case 'shelf_life':
				$this->do_create_shelf_life();
				break;

			case 'packing-size':
				$this->do_create_packing_size();
				break;

			case 'packing-type':
				$this->do_create_packing_type();
				break;

			case 'container':
				$this->do_create_container();
				break;

			case 'container-zhl':
				$this->do_create_container_zhl();
				break;

			case 'bank':
				$this->do_create_bank();
				break;

			case 'trading_term':
				$this->do_create_trading_term;
				break;

			case 'main_category':
				$this->do_create_main_category();
				break;

			default:
				break;
		}
	}

	function edit_master($nama_master, $id)
	{
		switch ($nama_master) {
			case 'marketing':
				$this->do_edit_marketing($id);
				break;

			case 'customer':
				$this->do_edit_customer($id);
				break;

			case 'group_customer':
				$this->do_edit_customer_group($id);
				break;

			case 'agent':
				$this->do_edit_agent($id);
				break;

			case 'factory':
				$this->do_edit_factory($id);
				break;

			case 'product':
				$this->do_edit_product($id);
				break;

			case 'product_category':
				$this->do_edit_product_category($id);
				break;

			case 'brand':
				$this->do_edit_brand($id);
				break;

			case 'document':
				$this->do_edit_document($id);
				break;

			case 'payment_term':
				$this->do_edit_payment_term($id);
				break;

			case 'shelf_life':
				$this->do_edit_shelf_life($id);
				break;

			case 'container':
				$this->do_edit_container($id);
				break;

			case 'packing-size':
				$this->do_edit_packing_size($id);
				break;

			case 'packing-type':
				$this->do_edit_packing_type($id);
				break;

			case 'bank':
				$this->do_edit_bank($id);
				break;

			case 'trading_term':
				$this->do_edit_trading_term($id);
				break;

			case 'main_category':
				$this->do_edit_main_category($id);
				break;

			default:
				break;
		}
	}

	public function delete_master($nama_master, $id)
	{
		switch ($nama_master) {
			case 'marketing':
				$row = $this->M_mar_master->mark_get_by_id($id);

				if ($row) {
					$this->M_mar_master->mark_delete($id);
					$this->session->set_flashdata('message', pesan('Delete Record Success', pesan_sukses()));
					redirect(site_url('marketing/master/marketing'));
				} else {
					$this->session->set_flashdata('message', pesan('Record Not Found', pesan_peringatan()));
					redirect(site_url('marketing/master/marketing'));
				}
				break;

			case 'product':
				$row = $this->M_mar_product->product_get_by_id($id);

				if ($row) {
					$image_filename = $row->image_filename;
					if ($image_filename) {
						unlink('./images/product/' . $image_filename);
					}
					//					$this->M_mar_product->product_delete($id);
					$this->M_mar_product->product_set_inactive($id);
					$this->session->set_flashdata('message', pesan('Delete Record Success', pesan_sukses()));
					redirect(site_url('marketing/master/product'));
				} else {
					$this->session->set_flashdata('message', pesan('Record Not Found', pesan_peringatan()));
					redirect(site_url('marketing/master/product'));
				}
				break;

			case 'main_category':
				$row = $this->M_mar_master->maincate_get_by_id($id);

				if ($row) {
					$this->M_mar_master->maincate_delete($id);
					$this->session->set_flashdata('message', pesan('Delete Record Success', pesan_sukses()));
					redirect(site_url('marketing/master/main_category'));
				} else {
					$this->session->set_flashdata('message', pesan('Record Not Found', pesan_peringatan()));
					redirect(site_url('marketing/master/main_category'));
				}
				break;

			case 'customer':
				$row = $this->M_mar_master->cust_get_by_id($id);

				if ($row) {
					$this->M_mar_master->cust_delete($id);
					$this->M_mar_master->cust_payterm_delete($id);
					$this->session->set_flashdata('message', pesan('Delete Record Success', pesan_sukses()));
					redirect(site_url('marketing/master/customer'));
				} else {
					$this->session->set_flashdata('message', pesan('Record Not Found', pesan_peringatan()));
					redirect(site_url('marketing/master/customer'));
				}
				break;

			case 'group_customer':
				$row = $this->M_gen_master->get_all('group_customer');

				if ($row) {
					$this->M_gen_master->delete('group_customer', $id);
					$this->session->set_flashdata('message', pesan('Delete Record Success', pesan_sukses()));
					redirect(site_url('marketing/master/group_customer'));
				} else {
					$this->session->set_flashdata('message', pesan('Record Not Found', pesan_peringatan()));
					redirect(site_url('marketing/master/group_customer'));
				}
				break;

			case 'agent':
				$row = $this->M_mar_master->agent_get_by_id($id);

				if ($row) {
					$this->M_mar_master->agent_delete($id);
					$this->session->set_flashdata('message', pesan('Delete Record Success', pesan_sukses()));
					redirect(site_url('marketing/master/agent'));
				} else {
					$this->session->set_flashdata('message', pesan('Record Not Found', pesan_peringatan()));
					redirect(site_url('marketing/master/agent'));
				}
				break;

			case 'factory':
				$row = $this->M_gen_master->get_by_id('factory', $id);

				if ($row) {
					$this->M_gen_master->delete('factory', $id);
					$this->session->set_flashdata('message', pesan('Delete Record Success', pesan_sukses()));
					redirect(site_url('marketing/master/factory'));
				} else {
					$this->session->set_flashdata('message', pesan('Record Not Found', pesan_peringatan()));
					redirect(site_url('marketing/master/factory'));
				}
				break;

			case 'product_category':
				$row = $this->M_mar_product->product_category_get_by_id($id);

				if ($row) {
					$this->M_mar_product->product_category_delete($id);
					$this->session->set_flashdata('message', pesan('Delete Record Success', pesan_sukses()));
					redirect(site_url('marketing/master/product_category'));
				} else {
					$this->session->set_flashdata('message', pesan('Record Not Found', pesan_peringatan()));
					redirect(site_url('marketing/master/product_category'));
				}
				break;

			case 'brand':
				$row = $this->M_mar_master->brand_get_by_id($id);

				if ($row) {
					$this->M_mar_master->brand_delete($id);
					$this->session->set_flashdata('message', pesan('Delete Record Success', pesan_sukses()));
					redirect(site_url('marketing/master/brand'));
				} else {
					$this->session->set_flashdata('message', pesan('Record Not Found', pesan_peringatan()));
					redirect(site_url('marketing/master/brand'));
				}
				break;

			case 'payment_term':
				$row = $this->M_mar_master->payterm_get_by_id($id);

				if ($row) {
					$this->M_mar_master->payment_delete($id);
					$this->session->set_flashdata('message', pesan('Delete Record', pesan_sukses()));
					redirect(site_url('marketing/master/payment_term'));
				} else {
					$this->session->set_flashdata('message', pesan('Record Not Found', pesan_peringatan()));
					redirect(site_url('marketing/master/payment_term'));
				}
				break;

			case 'document':
				$row = $this->M_mar_master->document_get_by_id($id);

				if ($row) {
					$this->M_mar_master->document_deactive($id);
					$this->session->set_flashdata('message', pesan('Delete Record Success', pesan_sukses()));
					redirect(site_url('marketing/master/document'));
				} else {
					$this->session->set_flashdata('message', pesan('Record Not Found', pesan_peringatan()));
					redirect(site_url('marketing/master/document'));
				}
				break;

			case 'shelf_life':
				$row = $this->M_mar_master->shelf_get_by_id($id);

				if ($row) {
					$this->M_mar_master->shelf_delete($id);
					$this->session->set_flashdata('message', pesan('Delete Record Success', pesan_sukses()));
					redirect(site_url('marketing/master/shelf_life'));
				} else {
					$this->session->set_flashdata('message', pesan('Record Not Found', pesan_peringatan()));
					redirect(site_url('marketing/master/shelf_life'));
				}
				break;

			case 'packing-size':
				$row = $this->M_mar_master->packing_size_get_by_id($id);

				if ($row) {
					$this->M_mar_master->packing_size_delete($id);
					$this->session->set_flashdata('message', pesan('Delete Record Success', pesan_sukses()));
					redirect(site_url('marketing/master/packing-size'));
				} else {
					$this->session->set_flashdata('message', pesan('Record Not Found', pesan_peringatan()));
					redirect(site_url('marketing/master/packing-size'));
				}
				break;

			case 'packing-type':
				$row = $this->M_mar_master->packing_type_get_by_id($id);

				if ($row) {
					$this->M_mar_master->packing_type_delete($id);
					$this->session->set_flashdata('message', pesan('Delete Record Success', pesan_sukses()));
					redirect(site_url('marketing/master/packing-type'));
				} else {
					$this->session->set_flashdata('message', pesan('Record Not Found', pesan_peringatan()));
					redirect(site_url('marketing/master/packing-type'));
				}
				break;

			case 'container':
				$row = $this->M_mar_master->container_get_by_id($id);

				if ($row) {
					$this->M_mar_master->container_delete($id);
					$this->session->set_flashdata('message', pesan('Delete Record Success', pesan_sukses()));
					redirect(site_url('marketing/master/container'));
				} else {
					$this->session->set_flashdata('message', pesan('Record Not Found', pesan_peringatan()));
					redirect(site_url('marketing/master/container'));
				}
				break;

			case 'trading_term':
				$decoded_id = decode_str($id);
				$row = $this->M_mar_master->tradingterm_get_by_id($decoded_id);

				if ($row) {
					$this->M_mar_master->tradingterm_delete($decoded_id);
					$this->session->set_flashdata('message', pesan('Delete Record Success', pesan_sukses()));
					redirect(site_url('marketing/master/trading_term'));
				} else {
					$this->session->set_flashdata('message', pesan('Record Not Found', pesan_peringatan()));
					redirect(site_url('marketing/master/trading_term'));
				}
				break;

			case 'bank':
				$row = $this->M_mar_master->bank_get_by_id($id);

				if ($row) {
					$this->M_mar_master->bank_delete($id);
					$this->session->set_flashdata('message', pesan('Delete Record Success', pesan_sukses()));
					redirect(site_url('marketing/master/bank'));
				} else {
					$this->session->set_flashdata('message', pesan('Record Not Found', pesan_peringatan()));
					redirect(site_url('marketing/master/bank'));
				}
				break;

			default:
				break;
		}
	}

	public function find_master($nama_master)
	{
		switch ($nama_master) {
			case 'customer':
				//$this->_rules_customer();

				//if ($this->form_validation->run() == FALSE) {
				//	$this->do_find_customer();

				//} else {
				$find_record = $this->M_mar_master->cust_by_search();
				$cbo_country = $this->M_gen_master->get_all('country');

				if ($find_record) {

					$data = array(
						'button'				=> '<i class="fa fa-search"></i> Search ...',
						'action'				=> site_url('marketing/find_master/customer'),
						'header_title'			=> 'Master Customer - Search',
						'cbo_country'			=> $cbo_country,
						'customer_name' 		=> set_value('customer_name', '', true),
						'customer_company_name' => set_value('customer_company_name', '', true),
						'country_id'			=> set_value('country_id', '', true),
						'find_record'			=> $find_record,
					);

					$data['message'] = $this->session->flashdata('message');
					//	$this->load->view('marketing/master/customer/find', $data);
					$this->template->display('marketing/master/customer/find', $data);
				} else {
					$this->session->set_flashdata('message', pesan('Record Not Found', pesan_error()));
					redirect(site_url('marketing/master/customer'));
				}
				//}
				break;
		}
	}

	//==================================================================================================
	// MARKETING
	//==================================================================================================

	private function do_create_marketing()
	{
		$cbo_country = $this->M_gen_master->get_all('country');
		$data = array(
			'button'			=> '<i class="fa fa-save"></i> Save',
			'action'			=> site_url('marketing/save_master_marketing'),
			'header_title'		=> 'Master Marketing - Create New',
			'cbo_country'		=> $cbo_country,
			'marketing_id'		=> set_value('marketing_id'),
			'marketing_code'	=> set_value('marketing_code'),
			'marketing_name'	=> set_value('marketing_name'),
			'marketing_cma'		=> set_value('marketing_cma'),
			'marketing_country' => set_value('marketing_country'),
			'marketing_address' => set_value('marketing_address'),
			'marketing_phone'	=> set_value('marketing_phone'),
			'marketing_fax'		=> set_value('marketing_fax'),
			'marketing_email'	=> set_value('marketing_email'),
			'country_id'		=> set_value('country_id'),
		);

		$this->template->display('marketing/master/marketing/create', $data);
	}

	function save_master_marketing()
	{
		
		$data = array(
			'marketing_code'	=> $this->input->post('marketing_code', TRUE),
			'marketing_name'	=> $this->input->post('marketing_name', TRUE),
			'marketing_cma'		=> $this->input->post('marketing_cma', TRUE),
			'country_id'		=> $this->input->post('country_id', TRUE),
			'marketing_address' => $this->input->post('marketing_address', TRUE),
			'marketing_phone'	=> $this->input->post('marketing_phone', TRUE),
			'marketing_fax'		=> $this->input->post('marketing_fax', TRUE),
			'marketing_email'	=> $this->input->post('marketing_email', TRUE),
			'created_by'		=> strtoupper($this->session->userdata('userid_1')),
			'created_date'		=> date('Y-m-d H:i:s')
		);

		$this->M_mar_master->mark_insert($data);
		$this->session->set_flashdata('message', pesan('Create Record Success', pesan_sukses()));
		redirect(site_url('marketing/master/marketing'));
	}

	function do_edit_marketing($id)
	{
		$row = $this->M_mar_master->mark_get_by_id($id);
		$cbo_country = $this->M_gen_master->get_all('country');

		if ($row) {
			$data = array(
				'button'			=> 'Update',
				'action'			=> site_url('marketing/update_marketing'),
				'header_title'		=> 'Master Marketing - Edit',
				'cbo_country'		=> $cbo_country,
				'marketing_id'		=> set_value('marketing_id', $row->marketing_id),
				'marketing_code'	=> set_value('marketing_code', $row->marketing_code),
				'marketing_name'	=> set_value('marketing_name', $row->marketing_name),
				'marketing_cma'		=> set_value('marketing_cma', $row->marketing_cma),
				'country_id'		=> set_value('country_id', $row->country_id),
				'marketing_address' => set_value('marketing_address', $row->marketing_address),
				'marketing_phone'	=> set_value('marketing_phone', $row->marketing_phone),
				'marketing_fax'		=> set_value('marketing_fax', $row->marketing_fax),
				'marketing_email'	=> set_value('marketing_email', $row->marketing_email),
			);
			$this->template->display('marketing/master/marketing/create', $data);
		} else {
			$this->session->set_flashdata('message', pesan('Record Not Found', pesan_error()));
			redirect(site_url('marketing/master/marketing'));
		}
	}

	function update_marketing()
	{
		$this->_rules_marketing();

		if ($this->form_validation->run() == FALSE) {
			$this->do_edit_marketing($this->input->post('marketing_id', TRUE));
		} else {
			$data = array(
				'marketing_code'	=> $this->input->post('marketing_code', TRUE),
				'marketing_name'	=> $this->input->post('marketing_name', TRUE),
				'marketing_cma'		=> $this->input->post('marketing_cma', TRUE),
				'country_id'		=> $this->input->post('country_id', TRUE),
				'marketing_address' => $this->input->post('marketing_address', TRUE),
				'marketing_phone'	=> $this->input->post('marketing_phone', TRUE),
				'marketing_fax'		=> $this->input->post('marketing_fax', TRUE),
				'marketing_email'	=> $this->input->post('marketing_email', TRUE),
				'updated_by'		=> strtoupper($this->session->userdata('userid_1')),
				'updated_date'		=> date('Y-m-d H:i:s'),
			);

			$this->M_mar_master->mark_update($this->input->post('marketing_id', TRUE), $data);
			$this->session->set_flashdata('message', pesan('Update Record Success', pesan_sukses()));
			redirect(site_url('marketing/master/marketing'));
		}
	}

	function _rules_marketing()
	{
		$this->form_validation->set_rules('marketing_code', 'marketing code', 'trim|required');
		$this->form_validation->set_rules('marketing_name', 'marketing name', 'trim|required');
		$this->form_validation->set_rules('marketing_cma', 'marketing cma', 'trim|required');
		$this->form_validation->set_rules('country_id', 'marketing country', 'trim|required');

		$this->form_validation->set_rules('marketing_id', 'marketing_id', 'trim');
		$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
	}

	//==================================================================================================
	// CUSTOMER
	//==================================================================================================

	private function do_create_customer()
	{
		$cbo_country	= $this->M_gen_master->get_all('country');
		$cbo_group		= $this->M_gen_master->get_all('group_customer');
		$list_document	= $this->M_mar_master->document_get_all();

		//update 2016-07
		$cbo_payterm	= $this->M_mar_master->paymentterm_get_all();
		// var_dump($cbo_payterm);
		// die;
		//update 2018-01-24
		$cbo_bank		= $this->M_mar_master->bank_get_all();

		$data = array(
			'button'				=> '<i class="fa fa-save"></i> Save',
			'action'				=> site_url('marketing/save_master_customer'),
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

		$this->template->display('marketing/master/customer/create', $data);
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

		redirect(site_url('marketing/master/customer'));
		//        }
	}

	function do_find_customer()
	{
		$cbo_country = $this->M_gen_master->get_all('country');

		$data = array(
			'button'				=> '<i class="fa fa-search"></i> Search ...',
			'action'				=> site_url('marketing/find_master/customer'),
			'header_title'			=> 'Master Customer - Search',
			'cbo_country'			=> $cbo_country,
			//			'customer_name' 		=> set_value('customer_name', '', true),
			'customer_company_name' => set_value('customer_company_name', '', true),
			'country_id'			=> set_value('country_id', '', true),
		);

		$data['message'] = $this->session->flashdata('message');
		$this->template->display('marketing/master/customer/list', $data);
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
				'action'				=> site_url('marketing/update_customer'),
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

			$this->template->display('marketing/master/customer/create', $data);
		} else {
			$this->session->set_flashdata('message', pesan('Record Not Found', pesan_error()));
			redirect(site_url('marketing/master/customer'));
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
		redirect(site_url('marketing/master/customer'));
		//        }
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

	function _rules_customer()
	{
		//		$this->form_validation->set_rules('customer_code', 'customer code', 'trim|required');
		//		$this->form_validation->set_rules('customer_name', 'customer name', 'trim|required');
		$this->form_validation->set_rules('customer_company_name', 'customer company name', 'trim|required');
		$this->form_validation->set_rules('country_id', 'customer country', 'trim|required');
		$this->form_validation->set_rules('customer_email', 'email', 'valid_email');
		$this->form_validation->set_rules('customer_contact_email', 'contact email', 'valid_email');

		$this->form_validation->set_rules('customer_id', 'customer_id', 'trim');
		$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
	}

	//==================================================================================================
	// CUSTOMER GROUP
	//==================================================================================================

	private function do_create_customer_group()
	{
		$data = array(
			'button'				=> '<i class="fa fa-save"></i> Save',
			'action'				=> site_url('marketing/save_master_customer_group'),
			'header_title'			=> 'Master Customer Group - Create New',
			'customer_group_id'		=> set_value('customer_group_id', '', true),
			'customer_group_name'	=> set_value('customer_group_name', '', true),
			'coa'					=> set_value('coa', '', true),
		);

		$this->template->display('marketing/master/customer_group/create', $data);
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
			redirect(site_url('marketing/master/group_customer'));
		}
	}

	function do_edit_customer_group($id)
	{
		$row			= $this->M_gen_master->get_by_id('group_customer', $id);

		if ($row) {
			$data = array(
				'button'				=> 'Update',
				'action'				=> site_url('marketing/update_customer_group'),
				'header_title'			=> 'Master Customer - Edit',
				'customer_group_id'		=> set_value('customer_group_id', $row->customer_group_id),
				'customer_group_name'	=> set_value('customer_group_name', $row->customer_group_name),
				'coa'					=> set_value('coa', $row->coa),
			);

			$this->template->display('marketing/master/customer_group/create', $data);
		} else {
			$this->session->set_flashdata('message', pesan('Record Not Found', pesan_error()));
			redirect(site_url('marketing/master/group_customer'));
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
			redirect(site_url('marketing/master/group_customer'));
		}
	}

	function _rules_customer_group()
	{
		$this->form_validation->set_rules('customer_group_name', 'customer_group_name code', 'trim|required');
		$this->form_validation->set_rules('coa', 'coa', 'trim|required');

		$this->form_validation->set_rules('customer_group_id', 'customer group id', 'trim');
		$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
	}

	//==================================================================================================
	// AGENT
	//==================================================================================================

	private function do_create_agent()
	{
		$cbo_country	= $this->M_gen_master->get_all('country');
		$cbo_customer	= $this->M_mar_master->cust_get_all_active();

		$data = array(
			'button'				=> '<i class="fa fa-save"></i> Save',
			'action'				=> site_url('marketing/save_master_agent'),
			'header_title'			=> 'Master Agent - Create New',
			'cbo_country'			=> $cbo_country,
			'cbo_customer'			=> $cbo_customer,
			'agent_id'				=> set_value('agent_id', '', true),
			'agent_name'			=> set_value('agent_name', '', true),
			'customer_id'			=> set_value('customer_id', '', true),
			'agent_address'			=> set_value('agent_address', '', true),
			'agent_country_id'		=> set_value('agent_country_id', '', true),
			'agent_phone'			=> set_value('agent_phone', '', true),
			'agent_fax'				=> set_value('agent_fax', '', true),
			'agent_email'			=> set_value('agent_email', '', true),
			'agent_contact_name'	=> set_value('agent_contact_name', '', true),
			'agent_contact_phone'	=> set_value('agent_contact_phone', '', true),
			'agent_contact_email'	=> set_value('agent_contact_email', '', true),
		);

		$this->template->display('marketing/master/agent/create', $data);
	}

	function save_master_agent()
	{
		//		$this->_rules_agent();
		//
		//		if ($this->form_validation->run() == FALSE) {
		//            $this->create_master('agent');
		//        } else {
		$data = array(
			'agent_name'			=> $this->input->post('agent_name'),
			'agent_address'			=> $this->input->post('agent_address'),
			'agent_country_id'		=> $this->input->post('agent_country_id'),
			'agent_phone'			=> $this->input->post('agent_phone'),
			'agent_fax'				=> $this->input->post('agent_fax'),
			'agent_email'			=> $this->input->post('agent_email'),
			'customer_id'			=> $this->input->post('customer_id'),
			'agent_contact_name'	=> $this->input->post('agent_contact_name'),
			'agent_contact_phone'	=> $this->input->post('agent_contact_phone'),
			'agent_contact_email'	=> $this->input->post('agent_contact_email'),
			'created_by'			=> strtoupper($this->session->userdata('userid_1')),
			'created_date'			=> date('Y-m-d H:i:s')
		);

		$this->M_mar_master->agent_insert($data);
		$this->session->set_flashdata('message', pesan('Create Record Success', pesan_sukses()));
		redirect(site_url('marketing/master/agent'));
		//        }
	}

	function do_find_agent()
	{
		$cbo_country = $this->M_gen_master->get_all('country');

		$data = array(
			'button'				=> '<i class="fa fa-search"></i> Search ...',
			'action'				=> site_url('marketing/find_master/customer'),
			'header_title'			=> 'Master Agent - Search',
			'cbo_country'			=> $cbo_country,
			'agent_name'			=> set_value('agent_name', '', true),
			'agent_contact_name'	=> set_value('agent_contact_name', '', true),
			'country_id'			=> set_value('country_id', '', true),
		);

		$data['message'] = $this->session->flashdata('message');
		$this->template->display('marketing/master/agent/list', $data);
	}

	function do_edit_agent($id)
	{
		$row			= $this->M_mar_master->agent_get_by_id($id);
		$cbo_country	= $this->M_gen_master->get_all('country');
		$cbo_customer	= $this->M_mar_master->cust_get_all();

		if ($row) {
			$data = array(
				'button'				=> '<i class="fa fa-save"></i> Update',
				'action'				=> site_url('marketing/update_agent'),
				'header_title'			=> 'Master Agent - Edit',
				'cbo_country'			=> $cbo_country,
				'cbo_customer'			=> $cbo_customer,
				'agent_id'				=> set_value('agent_id', $row->agent_id),
				'agent_name'			=> set_value('agent_name', $row->agent_name),
				'agent_address'			=> set_value('agent_address', $row->agent_address),
				'agent_country_id'		=> set_value('agent_country_id', $row->agent_country_id),
				'agent_phone'			=> set_value('agent_phone', $row->agent_phone),
				'agent_fax'				=> set_value('agent_fax', $row->agent_fax),
				'agent_email'			=> set_value('agent_email', $row->agent_email),
				'customer_id'			=> set_value('customer_id', $row->customer_id),
				'agent_contact_name'	=> set_value('agent_contact_name', $row->agent_contact_name),
				'agent_contact_phone'	=> set_value('agent_contact_phone', $row->agent_contact_phone),
				'agent_contact_email'	=> set_value('agent_contact_email', $row->agent_contact_email),
			);

			$this->template->display('marketing/master/agent/create', $data);
		} else {
			$this->session->set_flashdata('message', pesan('Record Not Found', pesan_error()));
			redirect(site_url('marketing/master/agent'));
		}
	}

	function update_agent()
	{
		//        $this->_rules_agent();
		//
		//        if ($this->form_validation->run() == FALSE) {
		//            $this->do_edit_agent($this->input->post('agent_id', TRUE));
		//        } else {
		$data = array(
			'agent_name'			=> $this->input->post('agent_name', TRUE),
			'agent_address'			=> $this->input->post('agent_address', TRUE),
			'agent_country_id'		=> $this->input->post('agent_country_id', TRUE),
			'agent_phone'			=> $this->input->post('agent_phone', TRUE),
			'agent_fax'				=> $this->input->post('agent_fax', TRUE),
			'agent_email'			=> $this->input->post('agent_email', TRUE),
			'customer_id'			=> $this->input->post('customer_id', true),
			'agent_contact_name'	=> $this->input->post('agent_contact_name', TRUE),
			'agent_contact_phone'	=> $this->input->post('agent_contact_phone', TRUE),
			'agent_contact_email'	=> $this->input->post('agent_contact_email', TRUE),
			'updated_by'			=> strtoupper($this->session->userdata('userid_1')),
			'updated_date'			=> date('Y-m-d H:i:s'),
		);

		$agent_id = $this->input->post('agent_id', TRUE);

		$this->M_mar_master->agent_update($agent_id, $data);

		$this->session->set_flashdata('message', pesan('Update Record Success', pesan_sukses()));
		redirect(site_url('marketing/master/agent'));
		//        }
	}

	function _rules_agent()
	{
		$this->form_validation->set_rules('agent_name', 'agent name', 'trim|required');
		$this->form_validation->set_rules('agent_email', 'email', 'valid_email');
		$this->form_validation->set_rules('agent_contact_email', 'contact email', 'valid_email');

		$this->form_validation->set_rules('agent_id', 'agent_id', 'trim');
		$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
	}

	//==================================================================================================
	// FACTORY
	//==================================================================================================

	private function do_create_factory()
	{
		$data = array(
			'button'		=> '<i class="fa fa-save"></i> Save',
			'action'		=> site_url('marketing/save_master_factory'),
			'header_title'	=> 'Master Factory - Create New',
			'factory_id'	=> set_value('factory_id'),
			'factory_name'	=> set_value('factory_name'),
			'factory_abbr'	=> set_value('factory_abbr'),
			'factory_location' => set_value('factory_location'),
			'factory_address' => set_value('factory_address'),
			'factory_phone'	=> set_value('factory_phone'),
			'factory_fax'	=> set_value('factory_fax'),
		);

		$this->template->display('marketing/master/factory/create', $data);
	}

	function save_master_factory()
	{
		$this->_rules_factory();

		if ($this->form_validation->run() == FALSE) {
			$this->create_master('factory');
		} else {
			$data = array(
				'factory_name'		=> $this->input->post('factory_name', TRUE),
				'factory_abbr'		=> $this->input->post('factory_abbr', TRUE),
				'factory_location'	=> $this->input->post('factory_location', TRUE),
				'factory_address'	=> $this->input->post('factory_address', TRUE),
				'factory_phone'		=> $this->input->post('factory_phone', TRUE),
				'factory_fax'		=> $this->input->post('factory_fax', TRUE),
				'created_by'		=> strtoupper($this->session->userdata('userid_1')),
				'created_date'		=> date('Y-m-d H:i:s')
			);

			$this->M_gen_master->insert('factory', $data);
			$this->session->set_flashdata('message', pesan('Create Record Success', pesan_sukses()));
			redirect(site_url('marketing/master/factory'));
		}
	}

	function do_edit_factory($id)
	{
		$row = $this->M_gen_master->get_by_id('factory', $id);

		if ($row) {
			$data = array(
				'button'			=> 'Update',
				'action'			=> site_url('marketing/update_factory'),
				'header_title'		=> 'Master Factory - Edit',
				'factory_id'		=> set_value('factory_id', $row->factory_id),
				'factory_name'		=> set_value('factory_name', $row->factory_name),
				'factory_abbr'		=> set_value('factory_abbr', $row->factory_abbr),
				'factory_location'	=> set_value('factory_location', $row->factory_location),
				'factory_address'	=> set_value('factory_address', $row->factory_address),
				'factory_phone'		=> set_value('factory_phone', $row->factory_phone),
				'factory_fax'		=> set_value('factory_fax', $row->factory_fax),
			);
			$this->template->display('marketing/master/factory/create', $data);
		} else {
			$this->session->set_flashdata('message', pesan('Record Not Found', pesan_error()));
			redirect(site_url('marketing/master/factory'));
		}
	}

	function update_factory()
	{
		$this->_rules_factory();

		if ($this->form_validation->run() == FALSE) {
			$this->do_edit_factory($this->input->post('factory_id', TRUE));
		} else {
			$data = array(
				'factory_name'		=> $this->input->post('factory_name', TRUE),
				'factory_abbr'		=> $this->input->post('factory_abbr', TRUE),
				'factory_location'	=> $this->input->post('factory_location', TRUE),
				'factory_address'	=> $this->input->post('factory_address', TRUE),
				'factory_phone'		=> $this->input->post('factory_phone', TRUE),
				'factory_fax'		=> $this->input->post('factory_fax', TRUE),
				'updated_by'		=> strtoupper($this->session->userdata('userid_1')),
				'updated_date'		=> date('Y-m-d H:i:s'),
			);

			$this->M_gen_master->update('factory', $this->input->post('factory_id', TRUE), $data);
			$this->session->set_flashdata('message', pesan('Update Record Success', pesan_sukses()));
			redirect(site_url('marketing/master/factory'));
		}
	}

	function _rules_factory()
	{
		$this->form_validation->set_rules('factory_name', 'factory name', 'trim|required');
		$this->form_validation->set_rules('factory_abbr', 'factory abbreviation', 'trim|required');

		$this->form_validation->set_rules('factory_id', 'brand_id', 'trim');
		$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
	}


	//==================================================================================================
	// PRODUCT
	//==================================================================================================

	private function do_create_product()
	{
		$cbo_factory			= $this->M_gen_master->get_all('factory');
		$cbo_brand				= $this->M_mar_master->brand_get_all();
		$cbo_uom_volume			= $this->M_mar_master->uom_volume_get_all();
		$cbo_uom_quantity		= $this->M_mar_master->uom_quantity_get_all();
		$cbo_packing_size		= $this->M_mar_master->packing_size_get_all();
		$cbo_product_category = $this->M_mar_product->product_category_get_all();

		$data = array(
			'button'			=> '<i class="fa fa-save"></i> Save',
			'action'			=> site_url('marketing/save_master_product'),
			'header_title'		=> 'Master Product - Create New',
			'cbo_factory'		=> $cbo_factory,
			'cbo_brand'			=> $cbo_brand,
			'cbo_uom_volume'	=> $cbo_uom_volume,
			'cbo_uom_quantity'	=> $cbo_uom_quantity,
			'cbo_packing_size'	=> $cbo_packing_size,
			'cbo_product_category' => $cbo_product_category,
			'factory_id'		=> set_value('factory_id'),
			'product_id'		=> set_value('product_id'),
			'product_code'		=> set_value('product_code'),
			'product_name'		=> set_value('product_name'),
			'product_category_id'	=> set_value('product_category_id'),
			'brand_id'			=> set_value('brand_id'),
			'uom_volume'		=> set_value('uom_value'),
			'uom_volume_id'		=> set_value('uom_volume_id'),
			'packing_1'			=> set_value('packing_1'),
			'packing_2'			=> set_value('packing_2'),
			'uom_quantity_id'	=> set_value('uom_quantity'),
			'container_20ft'	=> set_value('container_20ft'),
			'container_40ft'	=> set_value('container_40ft'),
			'gross_weight'		=> set_value('gross_weight', 0),
			'net_weight'		=> set_value('net_weight', 0),
			'drained_weight'	=> set_value('drained_weight'),
			'fat_content'		=> set_value('fat_content'),
			'packing_view'		=> set_value('packing_view'),
			'packing_size'		=> set_value('packing_size'),
			'image_filename'	=> '',
			'product_no_image'	=> '<img src="' . base_url() . 'images/no_product_600x400.jpg" alt=""/>',
		);

		$this->template->display('marketing/master/product/create', $data);
	}

	function save_master_product()
	{
		$this->_rules_product();

		if ($this->form_validation->run() == FALSE) {
			$this->create_master('product');
		} else {
			$data = array(
				'factory_id'		=> $this->input->post('factory_id', TRUE),
				'product_code'		=> $this->input->post('product_code', TRUE),
				'product_name'		=> $this->input->post('product_name', TRUE),
				'brand_id'			=> $this->input->post('brand_id', TRUE),
				'product_category_id'	=> $this->input->post('product_category_id', TRUE),
				'uom_quantity_id'	=> $this->input->post('uom_quantity_id', TRUE),
				'uom_volume'		=> $this->input->post('uom_volume', TRUE),
				'uom_volume_id'		=> $this->input->post('uom_volume_id', TRUE),
				'per_packing_imm'	=> $this->input->post('packing_1', TRUE),
				'per_packing'		=> $this->input->post('packing_2', TRUE),
				'fat_content'		=> $this->input->post('fat_content', TRUE),
				'container_20ft'	=> $this->input->post('container_20ft', TRUE),
				'container_40ft'	=> $this->input->post('container_40ft', TRUE),
				'gross_weight'		=> $this->input->post('gross_weight', TRUE),
				'net_weight'		=> $this->input->post('net_weight', TRUE),
				'drained_weight'	=> $this->input->post('drained_weight', TRUE),
				'packing_view'		=> $this->input->post('packing_view', TRUE),
				'packing_size'		=> $this->input->post('packing_size', TRUE),
				'created_by'		=> strtoupper($this->session->userdata('userid_1')),
				'created_date'		=> date('Y-m-d H:i:s'),
			);

			$upload_msg = '';

			$last_product_id = $this->M_mar_product->product_insert($data);
			if ($last_product_id > 0) {
				$save_msg = pesan('Add product success', pesan_sukses());

				if (isset($_FILES['upload_product']) && !empty($_FILES['upload_product']['name'])) {
					$hasil_upload = $this->do_upload_product($last_product_id);
					if ($hasil_upload == '') {
						$upload_msg = pesan('Upload product image success', pesan_sukses());
					} else {
						$upload_msg = pesan('Upload product image failed <br/>' . $hasil_upload, pesan_error());
					}
				}
			} else {
				$save_msg = pesan('Add product failed', pesan_error());
			}

			$this->session->set_flashdata('message', $save_msg . '<br/>' . $upload_msg);

			redirect(site_url('marketing/master/product'));
		}
	}

	function do_upload_product($product_id)
	{
		$error = '';

		$url = './images/product/';
		$file_product = $product_id;

		$config['upload_path']	 = $url;
		$config['allowed_types'] = 'jpeg|jpg|png|gif';
		$config['allow_scale_up'] = true;
		$config['overwrite']	 = true;
		$config['file_name']	 = $file_product;

		$this->load->library('upload');
		$this->upload->initialize($config);

		if ($this->upload->do_upload('upload_product')) {
			$updata = $this->upload->data();
			$data = array(
				'image_filename'	=> $updata['file_name'],
				'image_path'		=> $updata['full_path'],
			);
			$this->M_mar_product->product_update($product_id, $data);
		} else {
			$error = $this->upload->display_errors();
		}
		return $error;
	}

	function do_edit_product($id)
	{
		$row = $this->M_mar_product->product_get_by_id($id);

		if (isset($row)) {

			$cbo_factory = $this->M_gen_master->get_all('factory');
			$cbo_brand = $this->M_mar_master->brand_get_all();
			$cbo_uom_volume = $this->M_mar_master->uom_volume_get_all();
			$cbo_uom_quantity = $this->M_mar_master->uom_quantity_get_all();
			$cbo_packing_size = $this->M_mar_master->packing_size_get_all();
			$cbo_product_category = $this->M_mar_product->product_category_get_all();

			$data = array(
				'button'			=> 'Update',
				'action'			=> site_url('marketing/update_product'),
				'header_title'		=> 'Master Product - Edit',
				'cbo_factory'		=> $cbo_factory,
				'cbo_brand'			=> $cbo_brand,
				'cbo_uom_volume'	=> $cbo_uom_volume,
				'cbo_uom_quantity'	=> $cbo_uom_quantity,
				'cbo_packing_size'	=> $cbo_packing_size,
				'cbo_product_category' => $cbo_product_category,
				'product_id'		=> set_value('product_id', $row->product_id),
				'factory_id'		=> set_value('factory_id', $row->factory_id),
				'product_code'		=> set_value('product_code', $row->product_code),
				'product_name'		=> set_value('product_name', $row->product_name),
				'brand_id'			=> set_value('brand_id', $row->brand_id),
				'product_category_id'	=> set_value('product_category_id', $row->product_category_id),
				'uom_quantity_id'	=> set_value('uom_quantity_id', $row->uom_quantity_id),
				'uom_volume'		=> set_value('uom_volume', $row->uom_volume),
				'uom_volume_id'		=> set_value('uom_volume_id', $row->uom_volume_id),
				'packing_1'			=> set_value('per_packing_imm', $row->per_packing_imm),
				'packing_2'			=> set_value('per_packing', $row->per_packing),
				'fat_content'		=> set_value('fat_content', $row->fat_content),
				'container_20ft'	=> set_value('container_20ft', $row->container_20ft),
				'container_40ft'	=> set_value('container_40ft', $row->container_40ft),
				'gross_weight'		=> set_value('gross_weight', $row->gross_weight),
				'net_weight'		=> set_value('net_weight', $row->net_weight),
				'drained_weight'	=> set_value('drained_weight', $row->drained_weight),
				'packing_view'		=> set_value('packing_view', $row->packing_view),
				'packing_size'		=> set_value('packing_size', $row->packing_size),
				'image_filename'	=> $row->image_filename,
				'product_no_image'	=> '<img src="' . base_url() . 'images/no_product_600x400.jpg" alt=""/>',
			);
			$this->template->display('marketing/master/product/create', $data);
		} else {
			$this->session->set_flashdata('message', pesan('Record Not Found', pesan_error()));
			redirect(site_url('marketing/master/product'));
		}
	}

	function update_product()
	{
		$this->_rules_product();

		if ($this->form_validation->run() == FALSE) {
			$this->do_edit_product($this->input->post('product_id', TRUE));
		} else {
			$product_id = $this->input->post('product_id', TRUE);
			$data = array(
				'factory_id'		=> $this->input->post('factory_id', TRUE),
				'product_code'		=> $this->input->post('product_code', TRUE),
				'product_name'		=> $this->input->post('product_name', TRUE),
				'brand_id'			=> $this->input->post('brand_id', TRUE),
				'product_category_id'	=> $this->input->post('product_category_id', TRUE),
				'uom_quantity_id'	=> $this->input->post('uom_quantity_id', TRUE),
				'uom_volume'		=> $this->input->post('uom_volume', TRUE),
				'uom_volume_id'		=> $this->input->post('uom_volume_id', TRUE),
				'per_packing_imm'	=> $this->input->post('packing_1', TRUE),
				'per_packing'		=> $this->input->post('packing_2', TRUE),
				'fat_content'		=> $this->input->post('fat_content', TRUE),
				'container_20ft'	=> $this->input->post('container_20ft', TRUE),
				'container_40ft'	=> $this->input->post('container_40ft', TRUE),
				'gross_weight'		=> $this->input->post('gross_weight', TRUE),
				'net_weight'		=> $this->input->post('net_weight', TRUE),
				'drained_weight'	=> $this->input->post('drained_weight', TRUE),
				'packing_view'		=> $this->input->post('packing_view', TRUE),
				'packing_size'		=> $this->input->post('packing_size', TRUE),
				'updated_by'		=> strtoupper($this->session->userdata('userid_1')),
				'updated_date'		=> date('Y-m-d H:i:s'),
			);

			$this->M_mar_product->product_update($product_id, $data);
			$update_msg = pesan('Update product success', pesan_sukses());
			$upload_msg = '';

			$removed_image = $this->input->post('removed');
			$image_filename = $this->input->post('image_filename');
			if ($removed_image == 1 && $image_filename != '') {
				unlink('./images/product/' . $image_filename);
				$this->M_mar_product->product_update($product_id, array('image_filename' => '', 'image_path' => ''));
			}

			if (isset($_FILES['upload_product']) && !empty($_FILES['upload_product']['name'])) {
				$hasil_upload = $this->do_upload_product($product_id);
				if ($hasil_upload == '') {
					$upload_msg = pesan('Upload product image success', pesan_sukses());
				} else {
					$upload_msg = pesan('Upload product image failed <br/>' . $hasil_upload, pesan_error());
				}
			}

			$this->session->set_flashdata('message', $update_msg . $upload_msg);
			redirect(site_url('marketing/master/product'));
		}
	}

	function update_packing_list()
	{
		$total_up = $this->M_mar_product->product_packing_list_update();
		if ($total_up > 0) {
			$this->session->set_flashdata('message', pesan('Update Master Product (' . $total_up . ' Updates)', pesan_sukses()));
		} else {
			$this->session->set_flashdata('message', pesan('Update Master Product', pesan_error()));
		}

		redirect(site_url('marketing/master/product_packing_list'));
	}

	function _rules_product()
	{
		$this->form_validation->set_rules('factory_id', 'Factory of production', 'trim|required');
		$this->form_validation->set_rules('product_code', 'product code', 'trim|required');
		$this->form_validation->set_rules('product_name', 'product name', 'trim|required');
		$this->form_validation->set_rules('product_category_id', 'product category', 'trim|required');

		$this->form_validation->set_rules('uom_volume', 'UOM volume', 'trim|required');
		$this->form_validation->set_rules('packing_view', 'packing size', 'trim|required');

		$this->form_validation->set_rules('product_id', 'product ID', 'trim');
		$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
	}

	//==================================================================================================
	// PRODUCT CATEGORY
	//==================================================================================================
	private function do_create_product_category()
	{
		$cbo_main_category	= $this->M_mar_master->maincate_get_all();
		$cbo_coa_inv		= $this->M_mar_product->get_coa_inv();
		$cbo_coa_cogs		= $this->M_mar_product->get_coa_cogs();
		$cbo_coa_sales		= $this->M_mar_product->get_coa_sales();

		$data = array(
			'button'				=> '<i class="fa fa-save"></i> Save',
			'action'				=> site_url('marketing/save_master_product_category'),
			'header_title'			=> 'Master Product Category - Create New',
			'product_category_id'	=> set_value('product_category_id'),
			'cbo_main_category'		=> $cbo_main_category,
			'cbo_coa_inv'			=> $cbo_coa_inv,
			'cbo_coa_cogs'			=> $cbo_coa_cogs,
			'cbo_coa_sales'			=> $cbo_coa_sales,
			'product_category_id'	=> set_value('product_category_id'),
			'product_category_name'	=> set_value('product_category_name'),
			'main_category_id'		=> set_value('main_category_id'),
			'po_code_prefix_rsup'	=> set_value('po_code_prefix_rsup'),
			'po_code_prefix_psg'	=> set_value('po_code_prefix_psg'),
			'po_code_prefix_psj'	=> set_value('po_code_prefix_psj'),
			'coa_inv'				=> set_value('coa_inv'),
			'coa_cogs'				=> set_value('coa_cogs'),
			'coa_sales'				=> set_value('coa_sales'),
		);

		$this->template->display('marketing/master/product_category/create', $data);
	}

	function save_master_product_category()
	{
		//		$this->_rules_product_category();
		//
		//		if ($this->form_validation->run() == FALSE) {
		//            $this->create_master('product_category');
		//        } else {
		$data = array(
			'product_category_id'	=> $this->input->post('product_category_id', TRUE),
			'product_category_name'	=> strtoupper($this->input->post('product_category_name', TRUE)),
			'main_category_id'		=> $this->input->post('main_category_id', TRUE),
			'po_code_prefix_rsup'	=> $this->input->post('po_code_prefix_rsup', TRUE),
			'po_code_prefix_psg'	=> $this->input->post('po_code_prefix_psg', TRUE),
			'po_code_prefix_psj'	=> $this->input->post('po_code_prefix_psj', TRUE),
			'coa_inv'				=> $this->input->post('coa_inv', TRUE),
			'coa_cogs'				=> $this->input->post('coa_cogs', TRUE),
			'coa_sales'				=> $this->input->post('coa_sales', TRUE),
			'created_by'			=> strtoupper($this->session->userdata('userid_1')),
			'created_date'			=> date('Y-m-d H:i:s')
		);

		$this->M_mar_product->product_category_insert($data);
		$this->session->set_flashdata('message', pesan('Create Record Success', pesan_sukses()));
		redirect(site_url('marketing/master/product_category'));
		//        }
	}

	function do_edit_product_category($id)
	{
		$row				= $this->M_mar_product->product_category_get_by_id($id);
		$cbo_main_category	= $this->M_mar_master->maincate_get_all();
		$cbo_coa_inv		= $this->M_mar_product->get_coa_inv();
		$cbo_coa_cogs		= $this->M_mar_product->get_coa_cogs();
		$cbo_coa_sales		= $this->M_mar_product->get_coa_sales();

		if ($row) {
			$data = array(
				'button'				=> 'Update',
				'action'				=> site_url('marketing/update_product_category'),
				'header_title'			=> 'Master Product Category - Edit',
				'cbo_main_category'		=> $cbo_main_category,
				'cbo_coa_inv'			=> $cbo_coa_inv,
				'cbo_coa_cogs'			=> $cbo_coa_cogs,
				'cbo_coa_sales'			=> $cbo_coa_sales,
				'product_category_id'	=> set_value('product_category_id', $row->product_category_id),
				'product_category_name'	=> set_value('product_category_name', $row->product_category_name),
				'main_category_id'		=> set_value('main_category_id', $row->main_category_id),
				'po_code_prefix_rsup'	=> set_value('po_code_prefix_rsup', $row->po_code_prefix_rsup),
				'po_code_prefix_psg'	=> set_value('po_code_prefix_psg',  $row->po_code_prefix_psg),
				'po_code_prefix_psj'	=> set_value('po_code_prefix_psj',  $row->po_code_prefix_psj),
				'coa_inv'				=> set_value('coa_inv', $row->coa_inv),
				'coa_cogs'				=> set_value('coa_cogs', $row->coa_cogs),
				'coa_sales'				=> set_value('coa_sales', $row->coa_sales),
			);
			$this->template->display('marketing/master/product_category/create', $data);
		} else {
			$this->session->set_flashdata('message', pesan('Record Not Found', pesan_error()));
			redirect(site_url('marketing/master/product_category'));
		}
	}

	function update_product_category()
	{
		//        $this->_rules_product_category();
		//
		//        if ($this->form_validation->run() == FALSE) {
		//            $this->do_edit_product_category($this->input->post('product_category_id', TRUE));
		//        } else {
		$data = array(
			'product_category_name'	=> strtoupper($this->input->post('product_category_name', TRUE)),
			'main_category_id'		=> $this->input->post('main_category_id', TRUE),
			'po_code_prefix_rsup'	=> $this->input->post('po_code_prefix_rsup', TRUE),
			'po_code_prefix_psg'	=> $this->input->post('po_code_prefix_psg', TRUE),
			'po_code_prefix_psj'	=> $this->input->post('po_code_prefix_psj', TRUE),
			'coa_inv'				=> $this->input->post('coa_inv', TRUE),
			'coa_cogs'				=> $this->input->post('coa_cogs', TRUE),
			'coa_sales'				=> $this->input->post('coa_sales', TRUE),
			'updated_by'			=> strtoupper($this->session->userdata('userid_1')),
			'updated_date'			=> date('Y-m-d H:i:s'),
		);

		$this->M_mar_product->product_category_update($this->input->post('product_category_id', TRUE), $data);
		$this->session->set_flashdata('message', pesan('Update Record Success', pesan_sukses()));
		redirect(site_url('marketing/master/product_category'));
		//        }
	}

	function _rules_product_category()
	{
		$this->form_validation->set_rules('product_category_name', 'product category', 'trim|required');
		$this->form_validation->set_rules('main_category_id', 'main category', 'trim|required');

		$this->form_validation->set_rules('product_category_id', 'product_category_id', 'trim');
		$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
	}

	//==================================================================================================
	// BRAND
	//==================================================================================================

	private function do_create_brand()
	{
		$data = array(
			'button'		=> '<i class="fa fa-save"></i> Save',
			'action'		=> site_url('marketing/save_master_brand'),
			'header_title'	=> 'Master Brand - Create New',
			'brand_id'		=> set_value('brand_id'),
			'brand_name'	=> set_value('brand_name'),
			'brand_cma'		=> set_value('brand_cma'),
		);

		$this->template->display('marketing/master/brand/create', $data);
	}

	function save_master_brand()
	{
		$this->_rules_brand();

		if ($this->form_validation->run() == FALSE) {
			$this->create_master('brand');
		} else {
			$data = array(
				'brand_name'	=> $this->input->post('brand_name', TRUE),
				'brand_cma'		=> $this->input->post('brand_cma', TRUE),
				'created_by'	=> strtoupper($this->session->userdata('userid_1')),
				'created_date'	=> date('Y-m-d H:i:s')
			);

			$this->M_mar_master->brand_insert($data);
			$this->session->set_flashdata('message', pesan('Create Record Success', pesan_sukses()));
			redirect(site_url('marketing/master/brand'));
		}
	}

	function do_edit_brand($id)
	{
		$row = $this->M_mar_master->brand_get_by_id($id);

		if ($row) {
			$data = array(
				'button'		=> 'Update',
				'action'		=> site_url('marketing/update_brand'),
				'header_title'	=> 'Master Brand - Edit',
				'brand_id'		=> set_value('brand_id', $row->brand_id),
				'brand_name'	=> set_value('brand_name', $row->brand_name),
				'brand_cma'		=> set_value('brand_cma', $row->brand_cma),
			);
			$this->template->display('marketing/master/brand/create', $data);
		} else {
			$this->session->set_flashdata('message', pesan('Record Not Found', pesan_error()));
			redirect(site_url('marketing/master/brand'));
		}
	}

	function update_brand()
	{
		$this->_rules_brand();

		if ($this->form_validation->run() == FALSE) {
			$this->do_edit_brand($this->input->post('brand_id', TRUE));
		} else {
			$data = array(
				'brand_name'	=> $this->input->post('brand_name', TRUE),
				'brand_cma'		=> $this->input->post('brand_cma', TRUE),
				'updated_by'	=> strtoupper($this->session->userdata('userid_1')),
				'updated_date'	=> date('Y-m-d H:i:s'),
			);

			$this->M_mar_master->brand_update($this->input->post('brand_id', TRUE), $data);
			$this->session->set_flashdata('message', pesan('Update Record Success', pesan_sukses()));
			redirect(site_url('marketing/master/brand'));
		}
	}

	function _rules_brand()
	{
		$this->form_validation->set_rules('brand_name', 'brand name', 'trim|required');
		$this->form_validation->set_rules('brand_cma', 'brand cma', 'trim|required');

		$this->form_validation->set_rules('brand_id', 'brand_id', 'trim');
		$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
	}

	//==================================================================================================
	// DOCUMENT
	//==================================================================================================

	private function do_create_document()
	{
		$data = array(
			'button'			=> '<i class="fa fa-save"></i> Save',
			'action'			=> site_url('marketing/save_master_document'),
			'header_title'		=> 'Master Document - Create New',
			'document_id'		=> set_value('document_id', '', true),
			'document_name'		=> set_value('document_name', '', true),
			'document_remark'	=> set_value('document_remark', '', true),
			'special'			=> set_value('special', 1, true),
			'checked'			=> false,
		);

		$this->template->display('marketing/master/document/create', $data);
	}

	function save_master_document()
	{
		//		$this->_rules_document();
		//
		//		if ($this->form_validation->run() == FALSE) {
		//            $this->create_master('document');
		//        } else {
		$param = array(
			'document_name'		=> strtolower($this->input->post('document_name', TRUE)),
		);
		$id = $this->M_mar_master->document_exists($param);

		if ($id > 0) {
			$this->M_mar_master->document_delete($id);
		}

		$special_val = $this->input->post('special', TRUE);
		$special_doc = (is_null($special_val)) ? 0 : 1;

		$data = array(
			'document_name'		=> $this->input->post('document_name', TRUE),
			'document_remark'	=> $this->input->post('document_cma', TRUE),
			'special'			=> $special_doc,
			'inactive'			=> 0,
			'created_by'		=> strtoupper($this->session->userdata('userid_1')),
			'created_date'		=> date('Y-m-d H:i:s')
		);

		$this->M_mar_master->document_insert($data);

		$this->session->set_flashdata('message', pesan('Create Record Success', pesan_sukses()));
		redirect(site_url('marketing/master/document'));
		//        }
	}

	function save_master_document_modal($special_doc = 0)
	{
		$param = array(
			'document_name'		=> strtolower($this->input->post('document_name', TRUE)),
		);
		$id = $this->M_mar_master->document_exists($param);

		if ($id > 0) {
			return false;
			//			$this->M_mar_master->document_delete($id);
		}

		$data = array(
			'document_name'		=> $this->input->post('document_name', TRUE),
			'document_remark'	=> $this->input->post('document_remark', TRUE),
			'special'			=> $special_doc,
			'inactive'			=> 0,
			'created_by'		=> strtoupper($this->session->userdata('userid_1')),
			'created_date'		=> date('Y-m-d H:i:s')
		);

		$doc_id = $this->M_mar_master->document_insert($data);

		$data_reload = array(
			'doc_id'	=> $doc_id,
			'doc_name'	=> $this->input->post('document_name', TRUE),
			'checked'	=> true,
		);

		$this->load->view('marketing/modal/document_row', $data_reload);

		//		return $doc_id;
	}

	function do_edit_document($id)
	{
		$row = $this->M_mar_master->document_get_by_id($id);

		if ($row) {
			$checked = ($row->special == 1) ? TRUE : FALSE;
			$data = array(
				'button'			=> 'Update',
				'action'			=> site_url('marketing/update_document'),
				'header_title'		=> 'Master Document - Edit',
				'document_id'		=> set_value('document_id', $row->document_id),
				'document_name'		=> set_value('document_name', $row->document_name),
				'document_remark'	=> set_value('document_remark', $row->document_remark),
				'checked'			=> $checked,
			);
			$this->template->display('marketing/master/document/create', $data);
		} else {
			$this->session->set_flashdata('message', pesan('Record Not Found', pesan_error()));
			redirect(site_url('marketing/master/document'));
		}
	}

	function update_document()
	{
		//        $this->_rules_document();
		//
		//        if ($this->form_validation->run() == FALSE) {
		//            $this->do_edit_document($this->input->post('document_id', TRUE));
		//        } else {

		$special = ($this->input->post('special', TRUE) == 1) ? 1 : 0;

		$data = array(
			'document_name'		=> $this->input->post('document_name', TRUE),
			'document_remark'	=> $this->input->post('document_remark', TRUE),
			'special'			=> $special,
			'updated_by'		=> strtoupper($this->session->userdata('userid_1')),
			'updated_date'		=> date('Y-m-d H:i:s'),
		);

		$this->M_mar_master->document_update($this->input->post('document_id', TRUE), $data);
		$this->session->set_flashdata('message', pesan('Update Record Success', pesan_sukses()));
		redirect(site_url('marketing/master/document'));
		//        }
	}

	function _rules_document()
	{
		$this->form_validation->set_rules('document_name', 'document name', 'trim|required');

		$this->form_validation->set_rules('document_id', 'document_id', 'trim');
		$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
	}


	//==================================================================================================
	// PAYMENT TERM
	//==================================================================================================

	private function do_create_payment_term()
	{
		$data = array(
			'button'			=> '<i class="fa fa-save"></i> Save',
			'action'			=> site_url('marketing/save_master_payment_term'),
			'header_title'		=> 'Master Payment Term - Create New',
			'payment_term_id'	=> set_value('payment_term_id', '', true),
			'payment_term'		=> set_value('payment_term', '', true),
		);

		$this->template->display('marketing/master/payment_term/create', $data);
	}

	function do_edit_payment_term($id)
	{
		$row = $this->M_mar_master->paymentterm_get_by_id($id);
		$position_id = $this->session->userdata('position_id');

		if ($row) {
			$data = array(
				'button'			=> 'Update',
				'action'			=> site_url('marketing/update_payment_term'),
				'position_id'		=> $position_id,
				'header_title'		=> 'Master Payment Term - Edit',
				'payment_term_id'	=> set_value('payment_term_id', $row->payment_term_id),
				'payment_term'		=> set_value('payment_term', $row->payment_term),
			);
			$this->template->display('marketing/master/payment_term/create', $data);
		} else {
			$this->session->set_flashdata('message', pesan('Record Not Found', pesan_error()));
			redirect(site_url('marketing/master/payment_term'));
		}
	}

	function save_master_payment_term()
	{
		$param = array(
			'payment_term'		=> strtolower($this->input->post('payment_term', TRUE)),
		);

		$id = $this->M_mar_master->paymentterm_exists($param);

		if ($id > 0) {
			$this->session->set_flashdata('message', pesan('Payment Term Already Exists', pesan_sukses()));
			redirect(site_url('marketing/master/payment_term'));
		}

		$data = array(
			'payment_term'		=> $this->input->post('payment_term', TRUE),
			'inactive'			=> 0,
			'created_by'		=> strtoupper($this->session->userdata('userid_1')),
			'created_date'		=> date('Y-m-d H:i:s')
		);

		$this->M_mar_master->paymentterm_insert($data);

		$this->session->set_flashdata('message', pesan('Create Record Success', pesan_sukses()));
		redirect(site_url('marketing/master/payment_term'));
	}

	function update_payment_term()
	{
		$data = array(
			'payment_term'		=> $this->input->post('payment_term', TRUE),
			'updated_by'		=> strtoupper($this->session->userdata('userid_1')),
			'updated_date'		=> date('Y-m-d H:i:s'),
		);

		$this->M_mar_master->paymentterm_update($this->input->post('payment_term_id', TRUE), $data);
		$this->session->set_flashdata('message', pesan('Update Record Success', pesan_sukses()));
		redirect(site_url('marketing/master/payment_term'));
	}


	//==================================================================================================
	// SHELF LIFE
	//==================================================================================================

	private function do_create_shelf_life()
	{
		$data = array(
			'button'			=> '<i class="fa fa-save"></i> Save',
			'action'			=> site_url('marketing/save_master_shelf_life'),
			'header_title'		=> 'Master Shelf Life - Create New',
			'shelf_life_id'		=> set_value('shelf_life_id'),
			'shelf_life'		=> set_value('shelf_life'),
		);

		$this->template->display('marketing/master/shelf_life/create', $data);
	}

	function save_master_shelf_life()
	{
		$this->_rules_shelf_life();

		if ($this->form_validation->run() == FALSE) {
			$this->create_master('shelf_life');
		} else {
			$data = array(
				'product_shelf_life'	=> $this->input->post('shelf_life', TRUE),
				'created_by'			=> strtoupper($this->session->userdata('userid_1')),
				'created_date'			=> date('Y-m-d H:i:s')
			);

			$this->M_mar_master->shelf_insert($data);
			$this->session->set_flashdata('message', pesan('Create Record Success', pesan_sukses()));
			redirect(site_url('marketing/master/shelf_life'));
		}
	}

	function save_shelf_life_modal()
	{
		$data = array(
			'product_shelf_life'	=> $this->input->post('shelf_life', TRUE),
			'created_by'			=> strtoupper($this->session->userdata('userid_1')),
			'created_date'			=> date('Y-m-d H:i:s')
		);

		$shelf_id = $this->M_mar_master->shelf_insert($data);

		$cbo_shelf			= $this->M_mar_master->shelf_get_all();
		$data1 = array(
			'cbo_shelf'				=> $cbo_shelf,
			'product_shelf_life_id' => set_value('product_shelf_life_id', $shelf_id, true),
		);
		$this->load->view('marketing/reload/reload_shelf_life', $data1);
	}

	function do_edit_shelf_life($id)
	{
		$row = $this->M_mar_master->shelf_get_by_id($id);

		if ($row) {
			$data = array(
				'button'			=> 'Update',
				'action'			=> site_url('marketing/update_shelf_life'),
				'header_title'		=> 'Master Product Shelf Life - Edit',
				'shelf_life_id'		=> set_value('shelf_life_id', $row->product_shelf_life_id),
				'shelf_life'		=> set_value('shelf_life', $row->product_shelf_life),
			);
			$this->template->display('marketing/master/shelf_life/create', $data);
		} else {
			$this->session->set_flashdata('message', pesan('Record Not Found', pesan_error()));
			redirect(site_url('marketing/master/shelf_life'));
		}
	}

	function update_shelf_life()
	{
		$this->_rules_shelf_life();

		if ($this->form_validation->run() == FALSE) {
			$this->do_edit_shelf_life($this->input->post('shelf_life_id', TRUE));
		} else {
			$data = array(
				'product_shelf_life'	=> $this->input->post('shelf_life', TRUE),
				'updated_by'			=> strtoupper($this->session->userdata('userid_1')),
				'updated_date'			=> date('Y-m-d H:i:s'),
			);

			$this->M_mar_master->shelf_update($this->input->post('shelf_life_id', TRUE), $data);
			$this->session->set_flashdata('message', pesan('Update Record Success', pesan_sukses()));
			redirect(site_url('marketing/master/shelf_life'));
		}
	}

	function _rules_shelf_life()
	{
		$this->form_validation->set_rules('shelf_life', 'product shelf life', 'trim|required');

		$this->form_validation->set_rules('shelf_life_id', 'shelf_life_id', 'trim');
		$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
	}

	//==================================================================================================
	// PACKING SIZE
	//==================================================================================================

	private function do_create_packing_size()
	{
		$data = array(
			'button'			=> '<i class="fa fa-save"></i> Save',
			'action'			=> site_url('marketing/save_master_packing_size'),
			'header_title'		=> 'Master Packing Size - Create New',
			'packing_size_id'	=> set_value('packing_size_id'),
			'packing_size_name'	=> set_value('packing_size_name'),
		);

		$this->template->display('marketing/master/packing_size/create', $data);
	}

	function save_master_packing_size()
	{
		$this->_rules_packing_size();

		if ($this->form_validation->run() == FALSE) {
			$this->create_master('packing-size');
		} else {
			$data = array(
				'packing_size_name'	=> $this->input->post('packing_size_name', TRUE),
				'created_by'		=> strtoupper($this->session->userdata('userid_1')),
				'created_date'		=> date('Y-m-d H:i:s')
			);

			$this->M_mar_master->packing_size_insert($data);
			$this->session->set_flashdata('message', pesan('Create Record Success', pesan_sukses()));
			redirect(site_url('marketing/master/packing-size'));
		}
	}

	function do_edit_packing_size($id)
	{
		$row = $this->M_mar_master->packing_size_get_by_id($id);

		if ($row) {
			$data = array(
				'button'			=> 'Update',
				'action'			=> site_url('marketing/update_packing_size'),
				'header_title'		=> 'Master Packing Size - Edit',
				'packing_size_id'	=> set_value('packing_size_id', $row->packing_size_id),
				'packing_size_name'	=> set_value('packing_size_name', $row->packing_size_name),
			);
			$this->template->display('marketing/master/packing_size/create', $data);
		} else {
			$this->session->set_flashdata('message', pesan('Record Not Found', pesan_error()));
			redirect(site_url('marketing/master/packing-size'));
		}
	}

	function update_packing_size()
	{
		$this->_rules_packing_size();

		if ($this->form_validation->run() == FALSE) {
			$this->do_edit_packing_size($this->input->post('packing_size_id', TRUE));
		} else {
			$data = array(
				'packing_size_name'	=> $this->input->post('packing_size_name', TRUE),
				'updated_by'	=> strtoupper($this->session->userdata('userid_1')),
				'updated_date'	=> date('Y-m-d H:i:s'),
			);

			$this->M_mar_master->packing_size_update($this->input->post('packing_size_id', TRUE), $data);
			$this->session->set_flashdata('message', pesan('Update Record Success', pesan_sukses()));
			redirect(site_url('marketing/master/packing-size'));
		}
	}

	function _rules_packing_size()
	{
		$this->form_validation->set_rules('packing_size_name', 'packing size name', 'trim|required');

		$this->form_validation->set_rules('packing_size_id', 'packing_size_id', 'trim');
		$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
	}


	//==================================================================================================
	// PACKING TYPE
	//==================================================================================================

	private function do_create_packing_type()
	{
		$data = array(
			'button'			=> '<i class="fa fa-save"></i> Save',
			'action'			=> site_url('marketing/save_master_packing_type'),
			'header_title'		=> 'Master Packing Type - Create New',
			'packing_type_id'	=> set_value('packing_type_id'),
			'packing_type_name'	=> set_value('packing_type_name'),
		);

		$this->template->display('marketing/master/packing_type/create', $data);
	}

	function save_master_packing_type()
	{
		$this->_rules_packing_type();

		if ($this->form_validation->run() == FALSE) {
			$this->create_master('packing-type');
		} else {
			$data = array(
				'packing_type_name'	=> $this->input->post('packing_type_name', TRUE),
				'created_by'	=> strtoupper($this->session->userdata('userid_1')),
				'created_date'	=> date('Y-m-d H:i:s')
			);

			$this->M_mar_master->packing_type_insert($data);
			$this->session->set_flashdata('message', pesan('Create Record Success', pesan_sukses()));
			redirect(site_url('marketing/master/packing-type'));
		}
	}

	function do_edit_packing_type($id)
	{
		$row = $this->M_mar_master->packing_type_get_by_id($id);

		if ($row) {
			$data = array(
				'button'			=> 'Update',
				'action'			=> site_url('marketing/update_packing_type'),
				'header_title'		=> 'Master Packing Type - Edit',
				'packing_type_id'	=> set_value('packing_type_id', $row->packing_type_id),
				'packing_type_name'	=> set_value('packing_type_name', $row->packing_type_name),
			);
			$this->template->display('marketing/master/packing_type/create', $data);
		} else {
			$this->session->set_flashdata('message', pesan('Record Not Found', pesan_error()));
			redirect(site_url('marketing/master/packing-type'));
		}
	}

	function update_packing_type()
	{
		$this->_rules_packing_type();

		if ($this->form_validation->run() == FALSE) {
			$this->do_edit_packing_type($this->input->post('packing_type_id', TRUE));
		} else {
			$data = array(
				'packing_type_name'	=> $this->input->post('packing_type_name', TRUE),
				'updated_by'	=> strtoupper($this->session->userdata('userid_1')),
				'updated_date'	=> date('Y-m-d H:i:s'),
			);

			$this->M_mar_master->packing_type_update($this->input->post('packing_type_id', TRUE), $data);
			$this->session->set_flashdata('message', pesan('Update Record Success', pesan_sukses()));
			redirect(site_url('marketing/master/packing-type'));
		}
	}

	function _rules_packing_type()
	{
		$this->form_validation->set_rules('packing_type_name', 'packing type name', 'trim|required');

		$this->form_validation->set_rules('packing_type_id', 'packing_type_id', 'trim');
		$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
	}


	//==================================================================================================
	// CONTAINER
	//==================================================================================================

	private function do_create_container()
	{
		$data = array(
			'button'			=> '<i class="fa fa-save"></i> Save',
			'action'			=> site_url('marketing/save_master_container'),
			'header_title'		=> 'Master Container - Create New',
			'container_id'		=> set_value('container_id'),
			'container_name'	=> set_value('container_name'),
			'container_size'	=> set_value('container_size'),
			'container_abbr'	=> set_value('container_abbr'),
			'measurement'		=> set_value('measurement')
		);

		$this->template->display('marketing/master/container/create', $data);
	}

	private function do_create_container_zhl()
	{
		$data = array(
			'button'			=> '<i class="fa fa-save"></i> Save',
			'action'			=> site_url('marketing/save_master_container'),
			'header_title'		=> 'Master Container ZHL - Create New',
			'container_id'		=> set_value('container_zhl_id'),
			'container_name'	=> set_value('container_number'),
		);

		$this->template->display('marketing/master/container_zhl/create', $data);
	}

	function save_master_container()
	{
		$this->_rules_container();

		if ($this->form_validation->run() == FALSE) {
			$this->create_master('container');
		} else {
			$data = array(
				'container_name'	=> $this->input->post('container_name', TRUE),
				'container_size'	=> $this->input->post('container_size', TRUE),
				'container_abbr'	=> $this->input->post('container_abbr', TRUE),
				'measurement'		=> $this->input->post('measurement', TRUE),
				'created_by'		=> strtoupper($this->session->userdata('userid_1')),
				'created_date'		=> date('Y-m-d H:i:s')
			);

			$this->M_mar_master->container_insert($data);
			$this->session->set_flashdata('message', pesan('Create Record Success', pesan_sukses()));
			redirect(site_url('marketing/master/container'));
		}
	}

	function save_master_container_zhl()
	{

		try {
			$data = array(
				'container_number'	=> $this->input->post('container_number', TRUE),
				'container_id'	=> $this->input->post('container_id', TRUE),
				'grade'	=> $this->input->post('greet', TRUE),
				'tare_weight'	=> $this->input->post('tare_weight', TRUE),
				'created_by'		=> strtoupper($this->session->userdata('userid_1')),
				'created_date'		=> date('Y-m-d H:i:s')
			);
			$exec = $this->M_mar_master->container_insert_zhl($data);
			if ($exec) {
				echo json_encode(true);
			} else {
				echo json_encode(false);
			}
		} catch (\Throwable $th) {
			echo json_encode($th->getMessage());
		}
	}

	function update_master_container_zhl()
	{

		try {
			$param = [];
			$param = $this->input->post();
			$param = array_merge($param, [
				'updated_by' => $this->session->userdata("userid_1"),
				"updated_date" => date("Y-m-d H:i:s")
			]);
			$exec = $this->M_mar_master->container_delete_zhl($param);
			echo json_encode($exec);
		} catch (\Throwable $th) {
			echo json_encode($th->getMessage());
		}
	}

	function delete_master_container_zhl()
	{

		try {

			$param = [];

			$param = $this->input->post();

			$param = array_merge($param, [
				'deleted_date' => date("Y-m-d H:i:s"),
				"deleted_by"   => $this->session->userdata('userid_1'),
				"not_active"   => 1
			]);


			$exec = $this->M_mar_master->container_delete_zhl($param);
			echo json_encode($exec);
		} catch (\Throwable $th) {
			echo json_encode($th->getMessage());
		}
	}


	function do_edit_container($id)
	{
		$row = $this->M_mar_master->container_get_by_id($id);

		if ($row) {
			$data = array(
				'button'			=> 'Update',
				'action'			=> site_url('marketing/update_container'),
				'header_title'		=> 'Master Container - Edit',
				'container_id'		=> set_value('container_id', $row->container_id),
				'container_name'	=> set_value('container_name', $row->container_name),
				'container_size'	=> set_value('container_size', $row->container_size),
				'container_abbr'	=> set_value('container_abbr', $row->container_abbr),
				'measurement'       => set_value('measurement', $row->measurement),
				'updated_by'	=> strtoupper($this->session->userdata('userid_1')),
				'updated_date'	=> date('Y-m-d H:i:s')
			);
			$this->template->display('marketing/master/container/create', $data);
		} else {
			$this->session->set_flashdata('message', pesan('Record Not Found', pesan_error()));
			redirect(site_url('marketing/master/container'));
		}
	}

	function update_container()
	{
		$this->_rules_container();

		if ($this->form_validation->run() == FALSE) {
			$this->do_edit_container($this->input->post('container_id', TRUE));
		} else {
			$data = array(
				'container_name'	=> $this->input->post('container_name', TRUE),
				'container_size'	=> $this->input->post('container_size', TRUE),
				'container_abbr'	=> $this->input->post('container_abbr', TRUE),
				'measurement' 		=> $this->input->post('measurement', TRUE),
				'updated_by'	=> strtoupper($this->session->userdata('userid_1')),
				'updated_date'	=> date('Y-m-d H:i:s'),
			);

			$this->M_mar_master->container_update($this->input->post('container_id', TRUE), $data);
			$this->session->set_flashdata('message', pesan('Update Record Success', pesan_sukses()));
			redirect(site_url('marketing/master/container'));
		}
	}

	function _rules_container()
	{
		$this->form_validation->set_rules('container_name', 'container name', 'trim|required');

		$this->form_validation->set_rules('container_id', 'container id', 'trim');
		$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
	}

	function _rules_container_zhl()
	{
		$this->form_validation->set_rules('container_number', 'container number', 'trim|required');

		$this->form_validation->set_rules('container_id', 'container id', 'trim');
		$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
	}

	//==================================================================================================
	// BANK
	//==================================================================================================

	private function do_create_bank()
	{
		$cbo_country = $this->M_gen_master->get_all('country');
		$cbo_currency	= $this->M_gen_master->get_all('currency');

		$data = array(
			'button'			=> '<i class="fa fa-save"></i> Save',
			'action'			=> site_url('marketing/save_master_bank'),
			'header_title'		=> 'Master Bank Detail - Create New',
			'cbo_country'		=> $cbo_country,
			'cbo_currency'		=> $cbo_currency,
			'bank_id'			=> set_value('bank_id', '', true),
			'bank_account_number' => set_value('bank_account_number', '', true),
			'bank_name'			=> set_value('bank_name', '', true),
			'bank_abbreviation' => set_value('bank_abbreviation', '', true),
			'bank_city'			=> set_value('bank_city', '', true),
			'bank_address'		=> set_value('bank_address', '', true),
			'bank_country_id'	=> set_value('bank_country_id', '', true),
			'bank_swift'		=> set_value('bank_swift', '', true),
			'bank_currency_id'	=> set_value('bank_currency_id', '', true),
			'bank_description'	=> set_value('bank_description', '', true),
			'bank_account_number_2' => set_value('bank_account_number_2', '', true),
			'bank_currency_id_2'	=> set_value('bank_currency_id_2', '', true),
		);

		$this->template->display('marketing/master/bank/create', $data);
	}

	function save_master_bank()
	{
		$this->_rules_bank();

		if ($this->form_validation->run() == FALSE) {
			$this->create_master('bank');
		} else {
			$data = array(
				'bank_account_number' => $this->input->post('bank_account_number', true),
				'bank_name'			=> $this->input->post('bank_name', true),
				'bank_abbreviation' => $this->input->post('bank_abbreviation', true),
				'bank_city'			=> $this->input->post('bank_city', true),
				'bank_address'		=> $this->input->post('bank_address', true),
				'bank_country_id'	=> $this->input->post('bank_country_id', true),
				'bank_swift'		=> $this->input->post('bank_swift', true),
				'bank_currency_id'	=> $this->input->post('bank_currency_id', true),
				'bank_description'	=> $this->input->post('bank_description', true),
				'created_by'		=> strtoupper($this->session->userdata('userid_1')),
				'bank_account_number_2' => $this->input->post('bank_account_number_2', true),
				'bank_currency_id_2'	=> $this->input->post('bank_currency_id_2', true),
				'created_date'		=> date('Y-m-d H:i:s')
			);

			$this->M_mar_master->bank_insert($data);
			$this->session->set_flashdata('message', pesan('Create Record Success', pesan_sukses()));
			redirect(site_url('marketing/master/bank'));
		}
	}

	function do_edit_bank($id)
	{
		$row = $this->M_mar_master->bank_get_by_id($id);
		$cbo_country = $this->M_gen_master->get_all('country');
		$cbo_currency	= $this->M_gen_master->get_all('currency');

		if ($row) {
			$data = array(
				'button'			=> 'Update',
				'action'			=> site_url('marketing/update_bank'),
				'header_title'		=> 'Master Bank - Edit',
				'cbo_country'		=> $cbo_country,
				'cbo_currency'		=> $cbo_currency,
				'bank_id'			=> set_value('bank_id', $row->bank_id),
				'bank_account_number' => set_value('bank_account_number', $row->bank_account_number),
				'bank_name'			=> set_value('bank_name', $row->bank_name),
				'bank_abbreviation' => set_value('bank_abbreviation', $row->bank_abbreviation),
				'bank_city'			=> set_value('bank_city', $row->bank_city),
				'bank_address'		=> set_value('bank_address', $row->bank_address),
				'bank_country_id'	=> set_value('bank_country_id', $row->bank_country_id),
				'bank_swift'		=> set_value('bank_swift', $row->bank_swift),
				'bank_currency_id'	=> set_value('bank_currency_id', $row->bank_currency_id),
				'bank_description'	=> set_value('bank_description', $row->bank_description),
				'bank_account_number_2' => set_value('bank_account_number_2', $row->bank_account_number_2),
				'bank_currency_id_2'	=> set_value('bank_currency_id_2', $row->bank_currency_id_2),
				'updated_by'		=> strtoupper($this->session->userdata('userid_1')),
				'updated_date'		=> date('Y-m-d H:i:s'),
			);
			$this->template->display('marketing/master/bank/create', $data);
		} else {
			$this->session->set_flashdata('message', pesan('Record Not Found', pesan_error()));
			redirect(site_url('marketing/master/bank'));
		}
	}

	function update_bank()
	{
		$this->_rules_bank();

		if ($this->form_validation->run() == FALSE) {
			$this->do_edit_bank($this->input->post('bank_id', TRUE));
		} else {
			$data = array(
				'bank_account_number' => $this->input->post('bank_account_number', true),
				'bank_name'			=> $this->input->post('bank_name', true),
				'bank_abbreviation' => $this->input->post('bank_abbreviation', true),
				'bank_city'			=> $this->input->post('bank_city', true),
				'bank_address'		=> $this->input->post('bank_address', true),
				'bank_country_id'	=> $this->input->post('bank_country_id', true),
				'bank_swift'		=> $this->input->post('bank_swift', true),
				'bank_currency_id'	=> $this->input->post('bank_currency_id', true),
				'bank_description'	=> $this->input->post('bank_description', true),
				'updated_by'		=> strtoupper($this->session->userdata('userid_1')),
				'bank_account_number_2' => $this->input->post('bank_account_number_2', true),
				'bank_currency_id_2'	=> $this->input->post('bank_currency_id_2', true),
				'updated_date'		=> date('Y-m-d H:i:s'),
			);

			$this->M_mar_master->bank_update($this->input->post('bank_id', TRUE), $data);
			$this->session->set_flashdata('message', pesan('Update Record Success', pesan_sukses()));
			redirect(site_url('marketing/master/bank'));
		}
	}

	function _rules_bank()
	{
		$this->form_validation->set_rules('bank_account_number', 'account number', 'trim|required');
		$this->form_validation->set_rules('bank_account_number_2', 'account number', 'trim|required');
		$this->form_validation->set_rules('bank_name', 'bank name', 'trim|required');

		$this->form_validation->set_rules('bank_id', 'bank id', 'trim');
		$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
	}

	//==================================================================================================
	// TRADING TERM
	//==================================================================================================

	function save_master_trading_term()
	{
		$this->_rules_trading_term();

		if ($this->form_validation->run() == FALSE) {
			$this->master('trading_term');
		} else {
			$data = array(
				'trading_term_name'		=> $this->input->post('trading_term_name', true),
				'trading_term_remark'	=> $this->input->post('trading_term_remark', true),
				'created_by'			=> strtoupper($this->session->userdata('userid_1')),
				'created_date'			=> date('Y-m-d H:i:s')
			);

			$this->M_mar_master->tradingterm_insert($data);
			$this->session->set_flashdata('message', pesan('Create Record Success', pesan_sukses()));
			redirect(site_url('marketing/master/trading_term'));
		}
	}

	function save_trading_term_modal()
	{
		$data = array(
			'trading_term_name'		=> $this->input->post('trading_term_name', true),
			'trading_term_remark'	=> $this->input->post('trading_term_remark', true),
			'created_by'			=> strtoupper($this->session->userdata('userid_1')),
			'created_date'			=> date('Y-m-d H:i:s')
		);

		$trading_term_id = $this->M_mar_master->tradingterm_insert($data);

		$cbo_tradingterm	= $this->M_mar_master->tradingterm_get_all();
		$data1 = array(
			'cbo_tradingterm'	=> $cbo_tradingterm,
			'trading_term_id'	=> $trading_term_id,
		);
		$this->load->view('marketing/reload/reload_trading_term', $data1);
	}

	function do_edit_trading_term($id)
	{
		$row = $this->M_mar_master->tradingterm_get_by_id(decode_str($id));
		$master = $this->M_mar_master->tradingterm_get_all();

		if ($row) {
			$data = array(
				'master_data'		  => $master,
				'button'			  => 'Update',
				'action'			  => site_url('marketing/update_trading_term'),
				'trading_term_id'	  => set_value('trading_term_id', $id),
				'trading_term_name'	  => set_value('trading_term_name', $row->trading_term_name),
				'trading_term_remark' => set_value('trading_term_remark', $row->trading_term_remark),
			);
			$data['message'] = $this->session->flashdata('message');
			$this->template->display('marketing/master/trading_term/index', $data);
		} else {
			$this->session->set_flashdata('message', pesan('Record Not Found', pesan_error()));
			redirect(site_url('marketing/master/trading_term'));
		}
	}

	function update_trading_term()
	{
		$this->_rules_trading_term();

		$id = $this->input->post('trading_term_id', TRUE);

		if ($this->form_validation->run() == FALSE) {
			$this->do_edit_trading_term($id);
		} else {
			$data = array(
				'trading_term_name'   => $this->input->post('trading_term_name', true),
				'trading_term_remark' => $this->input->post('trading_term_remark', true),
				'updated_by'		  => strtoupper($this->session->userdata('userid_1')),
				'updated_date'		  => date('Y-m-d H:i:s'),
			);

			$this->M_mar_master->tradingterm_update(decode_str($id), $data);
			$this->session->set_flashdata('message', pesan('Update Record Success', pesan_sukses()));
			redirect(site_url('marketing/master/trading_term'));
		}
	}

	function _rules_trading_term()
	{
		$this->form_validation->set_rules('trading_term_name', 'trading term', 'trim|required');
		$this->form_validation->set_rules('trading_term_remark', 'trading remark', 'trim|required');

		$this->form_validation->set_rules('trading_term_id', 'trading_term id', 'trim');
		$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
	}


	//==================================================================================================
	// MAIN CATEGORY
	//==================================================================================================

	private function do_create_main_category()
	{
		$data = array(
			'button'			=> '<i class="fa fa-save"></i> Save',
			'action'			=> site_url('marketing/save_master_main_category'),
			'header_title'		=> 'Master Main Category - Create New',
			'main_category_id'		=> set_value('main_category_id'),
			'main_category_name'	=> set_value('main_category_name'),
		);

		$this->template->display('marketing/master/main_category/create', $data);
	}

	function save_master_main_category()
	{
		$this->_rules_main_category();

		if ($this->form_validation->run() == FALSE) {
			$this->create_master('main_category');
		} else {
			$data = array(
				'main_category_name'	=> $this->input->post('main_category_name', TRUE),
				'created_by'			=> strtoupper($this->session->userdata('userid_1')),
				'created_date'			=> date('Y-m-d H:i:s')
			);

			$this->M_mar_master->maincate_insert($data);
			$this->session->set_flashdata('message', pesan('Create Record Success', pesan_sukses()));
			redirect(site_url('marketing/master/main_category'));
		}
	}

	function do_edit_main_category($id)
	{
		$row = $this->M_mar_master->maincate_get_by_id($id);

		if ($row) {
			$data = array(
				'button'			=> 'Update',
				'action'			=> site_url('marketing/update_main_category'),
				'header_title'		=> 'Master Main Category - Edit',
				'main_category_id'		=> set_value('main_category_id', $row->main_category_id),
				'main_category_name'	=> set_value('main_category_name', $row->main_category_name),
			);
			$this->template->display('marketing/master/main_category/create', $data);
		} else {
			$this->session->set_flashdata('message', pesan('Record Not Found', pesan_error()));
			redirect(site_url('marketing/master/main_category'));
		}
	}

	function update_main_category()
	{
		$this->_rules_main_category();

		if ($this->form_validation->run() == FALSE) {
			$this->do_edit_main_category($this->input->post('main_category_id', TRUE));
		} else {
			$data = array(
				'main_category_name'	=> $this->input->post('main_category_name', TRUE),
				'updated_by'			=> strtoupper($this->session->userdata('userid_1')),
				'updated_date'			=> date('Y-m-d H:i:s'),
			);

			$this->M_mar_master->maincate_update($this->input->post('main_category_id', TRUE), $data);
			$this->session->set_flashdata('message', pesan('Update Record Success', pesan_sukses()));
			redirect(site_url('marketing/master/main_category'));
		}
	}

	function _rules_main_category()
	{
		$this->form_validation->set_rules('main_category_name', 'main category name', 'trim|required');

		$this->form_validation->set_rules('main_category_id', 'main_category_id', 'trim');
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
		$this->load->view('marketing/reload/reload_payment_term', $data);
	}

	function add_bank_row()
	{
		$cbo_bank = $this->M_mar_master->bank_get_all();

		$data = array(
			'cbo_bank' 	=> $cbo_bank,
			'bank_id'	=> '',
		);

		$this->load->view('marketing/master/customer/bank_row_output', $data);
	}

	function add_payterm_row()
	{
		$cbo_payterm = $this->M_mar_master->paymentterm_get_all();

		$data = array(
			'cbo_payterm' => $cbo_payterm,
			'payment_term_id'	=> '',
		);

		$this->load->view('marketing/master/customer/payterm_row_output', $data);
	}
}
