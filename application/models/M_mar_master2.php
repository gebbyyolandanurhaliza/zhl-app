<?php if (!defined('BASEPATH'))  exit('No direct script access allowed');

class M_mar_master extends CI_Model
{

    private $mark_table			= 'zhl_mar_tblmst_marketing';
	private $mark_view			= 'zhl_mar_vw_mst_marketing';
    private $mark_id			= 'marketing_id';

	private $sales_view			= 'zhl_mar_vw_mst_sales_marketing';
	private $sales_id			= 'userid';

	private $cust_table			= 'zhl_mar_tblmst_customer';
	private $cust_view			= 'zhl_mar_vw_mst_customer';
    private $cust_id			= 'customer_id';

	private $cust_doc_table		= 'zhl_mar_tblmst_customer_document';
	private $cust_product_table	= 'zhl_mar_tblmst_customer_product_purchase';

	private $cust_payterm_table = 'zhl_mar_tblmst_customer_payterm';
	private $cust_payterm_view	= 'zhl_mar_vw_mst_customer_payterm';

    private $cust_bank_table    = 'zhl_mar_tblmst_customer_bank';
    private $cust_bank_view     = 'zhl_mar_vw_mst_customer_bank';

	private $agent_table		= 'zhl_mar_tblmst_agent';
	private $agent_view			= 'zhl_mar_vw_mst_agent';

	private $brand_table		= 'zhl_mar_tblmst_brand';
	private $brand_id			= 'brand_id';

	private $document_table		= 'zhl_mar_tblmst_document';
	private $document_id		= 'document_id';

	private $bank_table			= 'zhl_mar_tblmst_bank';
	private $bank_view			= 'zhl_mar_vw_mst_bank';

	private $uom_volume_table	= 'zhl_mar_tblmst_uom_volume';

	private $uom_quantity_table = 'zhl_mar_tblmst_uom_quantity';

	private $uom_price_table	= 'zhl_mar_tblmst_uom_price';

	private $pack_size_table	= 'zhl_mar_tblmst_packing_size';
	private $packing_size_id	= 'packing_size_id';

	private $packing_type_table = 'zhl_mar_tblmst_packing_type';
	private $packing_type_id	= 'packing_type_id';

	private $container_table	= 'zhl_mar_tblmst_container';
	private $container_id		= 'container_id';

	private $port_table			= 'zhl_mar_tblmst_port';
	private $port_view			= 'zhl_mar_vw_mst_port';
	private $port_id			= 'port_id';

	private $tradingterm_table	= 'zhl_mar_tblmst_trading_term';
	private $tradingterm_id		= 'trading_term_id';

	private $paymentterm_table	= 'zhl_mar_tblmst_payment_term';
	private $paymentterm_id		= 'payment_term_id';

	private $shelf_table		= 'zhl_mar_tblmst_product_shelf_life';
	private $shelf_id			= 'product_shelf_life_id';

	private $maincate_table		= 'zhl_mar_tblmst_main_category';
	private $maincate_id		= 'main_category_id';

	private $sup_table			= 'zhl_pur_tbl_mst_supplier';

    private $order = 'ASC';

    function __construct()
    {
        parent::__construct();
    }

//==================================================================================================
// Sales Person Section
//==================================================================================================
	// get all
	function sales_get_all()
	{
        $this->db->order_by($this->sales_id, $this->order);
        return $this->db->get($this->sales_view)->result();
    }

	// get data by id
    function sales_get_by_id($id)
	{
        $this->db->where($this->sales_id, $id);
        return $this->db->get($this->sales_view)->row();
    }

	function sales_person_get_all()
	{
		$this->db->where('position_id', 3);
		$this->db->order_by($this->sales_id, $this->order);
        return $this->db->get($this->sales_view)->result();
	}

	function sales_marketing_get_all()
	{
		$this->db->where('position_id', 7);
		$this->db->order_by($this->sales_id, $this->order);
        return $this->db->get($this->sales_view)->result();
	}

	function product_manager_get_all()
	{
		$this->db->order_by($this->sales_id, $this->order);
        return $this->db->get($this->sales_view)->result();
	}

//==================================================================================================
// Marketing Section
//==================================================================================================
	// get all
    function mark_get_all()
	{
        $this->db->order_by('marketing_code', $this->order);
        return $this->db->get($this->mark_view)->result();
    }

    // get data by id
    function mark_get_by_id($id)
	{
        $this->db->where($this->mark_id, $id);
        return $this->db->get($this->mark_table)->row();
    }

    // get total rows marketing
    function mark_total_rows($q = NULL) {
        $this->db->like('marketing_id', $q);
		$this->db->or_like('marketing_name', $q);
		$this->db->or_like('marketing_code', $q);
		$this->db->or_like('marketing_cma', $q);
		$this->db->or_like('marketing_country', $q);
		$this->db->or_like('marketing_address', $q);
		$this->db->or_like('marketing_phone', $q);
		$this->db->or_like('marketing_fax', $q);
		$this->db->or_like('marketing_email', $q);
		$this->db->from($this->mark_table);
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function mark_get_limit_data($limit, $start = 0, $q = NULL)
	{
        $this->db->order_by('marketing_code', $this->order);
        $this->db->like('marketing_id', $q);
		$this->db->or_like('marketing_code', $q);
		$this->db->or_like('marketing_name', $q);
		$this->db->or_like('marketing_cma', $q);
		$this->db->or_like('marketing_country', $q);
		$this->db->or_like('marketing_address', $q);
		$this->db->or_like('marketing_phone', $q);
		$this->db->or_like('marketing_fax', $q);
		$this->db->or_like('marketing_email', $q);
		$this->db->limit($limit, $start);
        return $this->db->get($this->mark_table)->result();
    }

    // insert data marketing
    function mark_insert($data)
    {
        $this->db->insert($this->mark_table, $data);
    }

    // update data marketing
    function mark_update($id, $data)
    {
        $this->db->where($this->mark_id, $id);
        $this->db->update($this->mark_table, $data);
    }

    // delete data marketing
    function mark_delete($id)
    {
        $this->db->where($this->mark_id, $id);
        $this->db->delete($this->mark_table);
    }

//==================================================================================================
// Customer Section
//==================================================================================================

	private $sql_cust = 'SELECT a.customer_id,	a.customer_code, a.customer_name,	a.customer_company_name,
				a.country_id,	b.country_name,	b.country_ids, b.country_idn,	a.customer_reference,
				a.customer_contract_no,	a.customer_address,	a.customer_email,	a.customer_contact_name,
				a.customer_contact_phone,	a.customer_contact_email,	a.customer_group_id,	c.customer_group_name,
				c.coa, a.status_customer,	a.created_by,	a.created_date,	a.updated_by,	a.updated_date,
				a.customer_phone,	a.customer_fax,	a.customer_mobilephone,	a.customer_term, a.group_customer,
				a.po_remark_default, a.si_consignee_default
			FROM
				zhl_mar_tblmst_customer a	LEFT JOIN
				zhl_gen_tbl_mst_country b ON b.country_id = a.country_id LEFT JOIN
				zhl_mar_tblmst_customer_group c ON c.customer_group_id = a.customer_group_id
			WHERE 1=1 ';

	// get all
    function cust_get_all()
    {
        $this->db->order_by('customer_company_name', $this->order);
        return $this->db->get($this->cust_view)->result();
    }

	function cust_get_name($cust_id)
	{
		$this->db->select('customer_company_name')
			->from('mar_tblmst_customer')
			->where('customer_id', $cust_id);
		return $this->db->get();
	}

	// get all active customer
	function cust_get_all_active()
    {
		$sql = $this->sql_cust.'And a.status_customer ORDER BY a.customer_company_name;';
		return $this->db->query($sql)->result();

//      $this->db->where('status_customer', '1');
//		$this->db->order_by('customer_company_name', $this->order);
//		return $this->db->get($this->cust_view)->result();
    }

    // get data by id
    function cust_get_by_id($id)
	{
		$sql = $this->sql_cust." and a.customer_id = ".$id.";";
		return $this->db->query($sql)->row();

//        $this->db->where($this->cust_id, $id);
//        return $this->db->get($this->cust_view)->row();
    }

	// get data by search
	function cust_by_search()
    {
//        $this->db->like('customer_name', $this->input->post('customer_name'));
        $this->db->like('customer_company_name', $this->input->post('customer_company_name'));
        $this->db->like('country_id', $this->input->post('country_id'));

        return $this->db->get($this->cust_view)->result();

    }

	// check if exists
	function cust_exists($param)
	{
		$this->db->where($param);
		$query = $this->db->get($this->cust_table);
		if ($query->num_rows() > 0){
			return true;
		} else {
			return false;
		}
	}

	// insert data customer
    function cust_insert($data)
    {
        $this->db->insert($this->cust_table, $data);
        $customer_id = $this->db->insert_id();
        return $customer_id;
    }

	function cust_update_code($cust_id, $company_name)
	{
		$nomor = str_pad($cust_id, 5, '0', STR_PAD_LEFT);
		$huruf = left($company_name, 1);
		$kode = strtoupper($huruf.$nomor);
		$this->db->update($this->cust_table, array('customer_code' => $kode), array('customer_id' => $cust_id));
		return $kode;
	}

    function cust_bank_check($customer_id, $bank_id)
    {
        $this->db->where('customer_id', $customer_id);
        $this->db->where('bank_id', $bank_id);
        return $this->db->get($this->cust_bank_table)->num_rows();
    }

    function cust_bank_insert($customer_id)
    {
        $bank_count = count($this->input->post('bank_id'));
        $bank_id = $this->input->post('bank_id');

        for ($i = 0; $i < $bank_count; $i++){
            if ($bank_id[$i]){
                if ($this->cust_bank_check($customer_id, $bank_id[$i]) == 0) {
                    $info = array(
                        'bank_id'       => $bank_id[$i],
                        'customer_id'   => $customer_id,
                        'created_by'    => strtoupper($this->session->userdata('userid_1')),
    					'created_date'	=> date('Y-m-d H:i:s'),
                    );
                    $this->db->insert($this->cust_bank_table, $info);
                }
            }
        }
    }

	function cust_payterm_insert($customer_id)
	{
		$payterm_count = count($this->input->post('payment_term_id'));
		$payment_term_id = $this->input->post('payment_term_id');
//		$payment_term = $this->input->post('payment_term');

		for ($i = 0; $i < $payterm_count; $i++){
			if ($payment_term_id[$i]){
				$payterm_row = $this->paymentterm_get_by_id($payment_term_id[$i]);
				$info = array(
					'customer_id'		=> $customer_id,
					'payment_term_id'	=> $payment_term_id[$i],
					'payment_term'		=> $payterm_row->payment_term,
//					'payment_term'		=> htmlspecialchars($payment_term[$i], ENT_QUOTES) ,
					'created_by'		=> strtoupper($this->session->userdata('userid_1')),
					'created_date'		=> date('Y-m-d H:i:s'),
				);

				$this->db->insert($this->cust_payterm_table, $info);
			}
		}
	}

	function cust_payterm_insert_modal($customer_id, $payterm)
	{
		$sql = $this->db->get_where($this->cust_payterm_table, array('customer_id'=>$customer_id, 'payment_term'=>$payterm));
		if ($sql->num_rows() == 0){
			$data = array(
				'customer_id'	=>$customer_id,
				'payment_term'	=>$payterm,
				'created_by'	=> strtoupper($this->session->userdata('userid_1')),
				'created_date'	=> date('Y-m-d H:i:s'),
			);
			$this->db->insert($this->cust_payterm_table, $data);
		}
	}

    // update data customer
    function cust_update($id, $data)
    {
        $this->db->where($this->cust_id, $id);
        $this->db->update($this->cust_table, $data);
    }

    // delete data customer
    function cust_delete($id)
    {
        $this->db->where($this->cust_id, $id);
		$this->db->update($this->cust_table, array('status_customer'=>0));
//        $this->db->delete($this->cust_table);
    }

	function cust_payterm_delete($customer_id)
	{
		$this->db->where('customer_id', $customer_id);
        $this->db->delete($this->cust_payterm_table);
	}

	function cust_payterm_get_all()
	{
		return $this->db->get('mar_tblmst_payment_term')->result();

//		$this->db->distinct('payment_term');
//		return $this->db->get('mar_tblmst_customer_payterm')->result();
	}

	function cust_payterm_get_all_filtered($filter)
	{
		$this->db->distinct('payment_term');
		$this->db->like('payment_term', $filter);
		return $this->db->get('mar_tblmst_customer_payterm')->result();
	}

	function cust_payterm_get_by_customer($customer_id)
	{
		$this->db->where('customer_id', $customer_id);
		return $this->db->get($this->cust_payterm_view)->result();
	}

    function cust_bank_get_by_customer($customer_id)
    {
        $this->db->where('customer_id', $customer_id);
		return $this->db->get($this->cust_bank_view)->result();
    }

    function cust_bank_delete($customer_id)
	{
		$this->db->where('customer_id', $customer_id);
        $this->db->delete($this->cust_bank_table);
	}

	function cust_document_get_all($customer_id)
	{
		$this->db->where('customer_id', $customer_id);
		return $this->db->get($this->cust_doc_table)->result();
	}

	function cust_document_insert($customer_id)
	{
		$doc_count	= count($this->input->post('doc'));
		$doc		= $this->input->post('doc');

		if (!empty($doc)){
			for ($i = 0; $i < $doc_count; $i++){
				if (isset($doc[$i])){
					$info = array(
						'customer_id'	=> $customer_id,
						'document_id'	=> $doc[$i],
						'created_by'	=> strtoupper($this->session->userdata('userid_1')),
						'created_date'	=> date('Y-m-d H:i:s'),
					);

					$this->db->insert($this->cust_doc_table, $info);
				}
			}
		}
	}

	function cust_document_delete($customer_id)
	{
		$this->db->where('customer_id', $customer_id);
        $this->db->delete($this->cust_doc_table);
	}

	function cust_product_insert($customer_id)
	{
		$pro_count	= count($this->input->post('product_id'));
		$pro_id		= $this->input->post('product_id');

		if (!empty($pro_id)){
			for ($i = 0; $i < $pro_count; $i++){
				if (isset($pro_id[$i])){
					$info = array(
						'customer_id'	=> $customer_id,
						'product_id'	=> $pro_id[$i],
						'created_by'	=> strtoupper($this->session->userdata('userid_1')),
						'created_date'	=> date('Y-m-d H:i:s'),
					);

					$this->db->insert($this->cust_product_table, $info);
				}
			}
		}
	}

	function cust_product_delete($customer_id)
	{
		$this->db->where('customer_id', $customer_id);
        $this->db->delete($this->cust_product_table);
	}

//==================================================================================================
// Agent Section
//==================================================================================================
	// get all
    function agent_get_all()
    {
//		$this->db->where('inactive', '0');
        $this->db->order_by('agent_name', $this->order);
        return $this->db->get($this->agent_view)->result();
    }

	// get all active agent
	function agent_get_all_active()
    {
        $this->db->where('inactive', '0');
		$this->db->order_by('agent_name', $this->order);
        return $this->db->get($this->agent_view)->result();
    }

    // get data by id
    function agent_get_by_id($id)
	{
        $this->db->where('agent_id', $id);
        return $this->db->get($this->agent_view)->row();
    }

	//get data by customer id
	function agent_by_customer($customer_id)
	{
		$this->db->where('inactive', 0);
		$this->db->where('customer_id', $customer_id);
		return $this->db->get($this->agent_table)->result();
	}

	// get data by search
	function agent_by_search()
    {
        $this->db->like('agent_name', $this->input->post('agent_name'));
        $this->db->like('agent_contact_name', $this->input->post('agent_contact_name'));
        $this->db->like('country_id', $this->input->post('country_id'));

        return $this->db->get($this->agent_view)->result();
    }

	// insert data agent
    function agent_insert($data)
    {
        $this->db->insert($this->agent_table, $data);
        $agent_id = $this->db->insert_id();
        return $agent_id;
    }

	// update data agent
    function agent_update($id, $data)
    {
        $this->db->where('agent_id', $id);
        $this->db->update($this->agent_table, $data);
    }

    // delete data agent
    function agent_delete($id)
    {
        $this->db->where('agent_id', $id);
        $this->db->delete($this->agent_table);
    }

//==================================================================================================
// Payment Term Section
//==================================================================================================
    // get all
    function payterm_get_all()
    {
        $this->db->order_by('payment_term', $this->order);
		return $this->db->get($this->paymentterm_table)->result();
//        return $this->db->get($this->cust_payterm_table)->result();
    }

	// get data by customer id
    function payterm_get_detail($id)
    {
        $this->db->where('customer_id', $id);
        return $this->db->get($this->cust_payterm_view)->result();
    }

	function payterm_get_by_id($payterm_id)
	{
		$this->db->where('payment_term_id', $payterm_id);
        return $this->db->get($this->paymentterm_table)->row();
	}

    // insert data payment
    function payment_insert($data)
    {
        $this->db->insert($this->paymentterm_table, $data);
    }

    // update data payment
    function payment_update($id, $data)
    {
        $this->db->where($this->paymentterm_id, $id);
        $this->db->update($this->paymentterm_table, $data);
    }

    // delete data payment
    function payment_delete($id)
    {
        $this->db->where($this->paymentterm_id, $id);
        $this->db->delete($this->paymentterm_table);
    }


//==================================================================================================
// Brand Section
//==================================================================================================
	// get all
    function brand_get_all()
    {
        $this->db->order_by('brand_name', $this->order);
        return $this->db->get($this->brand_table)->result();
    }

    // get data by id
    function brand_get_by_id($id)
	{
        $this->db->where($this->brand_id, $id);
        return $this->db->get($this->brand_table)->row();
    }

	function brand_get_by_search($param)
	{
		$this->db->like('brand_name', $param);
		$this->db->or_like('brand_cma', $param);
		$this->db->order_by('brand_name', $this->order);
		return $this->db->get($this->brand_table)->result();
	}

	// insert data brand
    function brand_insert($data)
    {
        $this->db->insert($this->brand_table, $data);
    }

    // update data brand
    function brand_update($id, $data)
    {
        $this->db->where($this->brand_id, $id);
        $this->db->update($this->brand_table, $data);
    }

    // delete data brand
    function brand_delete($id)
    {
        $this->db->where($this->brand_id, $id);
        $this->db->delete($this->brand_table);
    }

//==================================================================================================
// Document Section
//==================================================================================================
	// get all
    function document_get_all($special = 0)
    {
		if ($special != 9){
			$this->db->where('special', $special);
		}
		$this->db->where('inactive', 0);
        $this->db->order_by('document_name', $this->order);
        return $this->db->get($this->document_table)->result();
    }

    // get data by id
    function document_get_by_id($id)
	{
        $this->db->where($this->document_id, $id);
        return $this->db->get($this->document_table)->row();
    }

	//check data exist
	function document_exists($param)
	{
		$this->db->where($param);
		$q = $this->db->get($this->document_table)->row();
		if (isset($q->document_id)){
			return $q->document_id;
		} else {
			return 0;
		}

	}

	// insert data document
    function document_insert($data)
    {
        $this->db->insert($this->document_table, $data);
		return $this->db->insert_id();
    }

    // update data document
    function document_update($id, $data)
    {
        $this->db->where($this->document_id, $id);
        $this->db->update($this->document_table, $data);
    }

    // delete data document
    function document_delete($id)
    {
        $this->db->where($this->document_id, $id);
        $this->db->delete($this->document_table);
    }

	//deactive document
	function document_deactive($id)
	{
		$this->db->where($this->document_id, $id);
        $this->db->update($this->document_table, array('inactive' => '1'));
	}

	function document_get_by_customer($cust_id, $special=0)
	{
		if ($special != 9){
			$this->db->where('special', $special);
		}
		$this->db->where('inactive', 0);
		$this->db->where('customer_id', $cust_id);
        $this->db->order_by('document_name', $this->order);
        return $this->db->get('mar_vw_mst_customer_document')->result();
	}

//==================================================================================================
// UOM Volume Section
//==================================================================================================
	// get all
    function uom_volume_get_all()
    {
        $this->db->order_by('uom_volume_name', $this->order);
        return $this->db->get($this->uom_volume_table)->result();
    }

    // get data by id
    function uom_volume_get_by_id($id)
	{
        $this->db->where($this->uom_volume_id, $id);
        return $this->db->get($this->uom_volume_table)->row();
    }

	// insert data uom_volume
    function uom_volume_insert($data)
    {
        $this->db->insert($this->uom_volume_table, $data);
    }

    // update data uom_volume
    function uom_volume_update($id, $data)
    {
        $this->db->where($this->uom_volume_id, $id);
        $this->db->update($this->uom_volume_table, $data);
    }

    // delete data uom_volume
    function uom_volume_delete($id)
    {
        $this->db->where($this->uom_volume_id, $id);
        $this->db->delete($this->uom_volume_table);
    }

//==================================================================================================
// UOM Quantity Section
//==================================================================================================
	// get all
    function uom_quantity_get_all()
    {
        $this->db->order_by('uom_quantity_name', $this->order);
        return $this->db->get($this->uom_quantity_table)->result();
    }

    // get data by id
    function uom_quantity_get_by_id($id)
	{
        $this->db->where($this->uom_quantity_id, $id);
        return $this->db->get($this->uom_quantity_table)->row();
    }

	// insert data uom_quantity
    function uom_quantity_insert($data)
    {
        $this->db->insert($this->uom_quantity_table, $data);
    }

    // update data uom_quantity
    function uom_quantity_update($id, $data)
    {
        $this->db->where($this->uom_quantity_id, $id);
        $this->db->update($this->uom_quantity_table, $data);
    }

    // delete data uom_quantity
    function uom_quantity_delete($id)
    {
        $this->db->where($this->uom_quantity_id, $id);
        $this->db->delete($this->uom_quantity_table);
    }

//==================================================================================================
// UOM Price Section
//==================================================================================================
	// get all
    function uom_price_get_all()
    {
        $this->db->order_by('uom_price_name', $this->order);
        return $this->db->get($this->uom_price_table)->result();
    }

    // get data by id
    function uom_price_get_by_id($id)
	{
        $this->db->where($this->uom_price_id, $id);
        return $this->db->get($this->uom_price_table)->row();
    }

	// insert data uom_price
    function uom_price_insert($data)
    {
        $this->db->insert($this->uom_price_table, $data);
    }

    // update data uom_price
    function uom_price_update($id, $data)
    {
        $this->db->where($this->uom_price_id, $id);
        $this->db->update($this->uom_price_table, $data);
    }

    // delete data uom_price
    function uom_price_delete($id)
    {
        $this->db->where($this->uom_price_id, $id);
        $this->db->delete($this->uom_price_table);
    }

//==================================================================================================
// Packing Size Section
//==================================================================================================
	// get all
    function packing_size_get_all()
    {
        $this->db->order_by('packing_size_name', $this->order);
        return $this->db->get($this->pack_size_table)->result();
    }

    // get data by id
    function packing_size_get_by_id($id)
	{
        $this->db->where($this->packing_size_id, $id);
        return $this->db->get($this->pack_size_table)->row();
    }

	// insert data packing_size
    function packing_size_insert($data)
    {
        $this->db->insert($this->pack_size_table, $data);
    }

    // update data packing_size
    function packing_size_update($id, $data)
    {
        $this->db->where($this->packing_size_id, $id);
        $this->db->update($this->pack_size_table, $data);
    }

    // delete data packing_size
    function packing_size_delete($id)
    {
        $this->db->where($this->packing_size_id, $id);
        $this->db->delete($this->pack_size_table);
    }

//==================================================================================================
// Packing Type Section
//==================================================================================================
	// get all
    function packing_type_get_all()
    {
        $this->db->order_by('packing_type_name', $this->order);
        return $this->db->get($this->packing_type_table)->result();
    }

    // get data by id
    function packing_type_get_by_id($id)
	{
        $this->db->where($this->packing_type_id, $id);
        return $this->db->get($this->packing_type_table)->row();
    }

	// insert data packing_type
    function packing_type_insert($data)
    {
        $this->db->insert($this->packing_type_table, $data);
    }

    // update data packing_type
    function packing_type_update($id, $data)
    {
        $this->db->where($this->packing_type_id, $id);
        $this->db->update($this->packing_type_table, $data);
    }

    // delete data packing_type
    function packing_type_delete($id)
    {
        $this->db->where($this->packing_type_id, $id);
        $this->db->delete($this->packing_type_table);
    }


//==================================================================================================
// Container Section
//==================================================================================================
	// get all
    function container_get_all()
    {
        $this->db->where('not_active', 0);
        $this->db->order_by('container_name', $this->order);
        return $this->db->get($this->container_table)->result();
    }

    // get data by id
    function container_get_by_id($id)
	{
        $this->db->where($this->container_id, $id);
        return $this->db->get($this->container_table)->row();
    }

	// insert data container
    function container_insert($data)
    {
        $this->db->insert($this->container_table, $data);
    }

    // update data container
    function container_update($id, $data)
    {
        $this->db->where($this->container_id, $id);
        $this->db->update($this->container_table, $data);
    }

    // delete data container
    function container_delete($id)
    {
        $this->db->where($this->container_id, $id);
        $this->db->delete($this->container_table);
    }


//==================================================================================================
// Port Section
//==================================================================================================
	// get all
    function port_get_all()
    {
        $this->db->order_by('port_name', $this->order);
        return $this->db->get($this->port_view)->result();
    }

	function destination_get_all()
    {
        $this->db->order_by('country_name', $this->order);
		$this->db->order_by('port_name', $this->order);
        return $this->db->get($this->port_view)->result();
    }

    // get data by id
    function port_get_by_id($id)
	{
        $this->db->where($this->port_id, $id);
        return $this->db->get($this->port_table)->row();
    }

	function port_get_by_ids($ids)
	{
		$this->db->where('country_ids', 'ZZ');
		$this->db->or_where_in('country_ids', $ids);
		return $this->db->get($this->port_table)->result();
	}

	// insert data port
    function port_insert($data)
    {
        $this->db->insert($this->port_table, $data);
    }

    // update data port
    function port_update($id, $data)
    {
        $this->db->where($this->port_id, $id);
        $this->db->update($this->port_table, $data);
    }

    // delete data port
    function port_delete($id)
    {
        $this->db->where($this->port_id, $id);
        $this->db->delete($this->port_table);
    }


//==================================================================================================
// Trading Term Section
//==================================================================================================
	// get all
    function tradingterm_get_all()
    {
        $this->db->where('not_active', 0);
		$this->db->order_by('trading_term_name', $this->order);
        return $this->db->get($this->tradingterm_table)->result();
    }

    // get data by id
    function tradingterm_get_by_id($id)
	{
        $this->db->where($this->tradingterm_id, $id);
        return $this->db->get($this->tradingterm_table)->row();
    }

	// insert data tradingterm
    function tradingterm_insert($data)
    {
        $this->db->insert($this->tradingterm_table, $data);
		return $this->db->insert_id();
    }

    // update data tradingterm
    function tradingterm_update($id, $data)
    {
        $this->db->where($this->tradingterm_id, $id);
        $this->db->update($this->tradingterm_table, $data);
    }

    // delete data tradingterm
    function tradingterm_delete($id)
    {
        $data = array(
				'not_active'	=> 1,
				'updated_by'	=> strtoupper($this->session->userdata('userid_1')),
				'updated_date'	=> date('Y-m-d H:i:s'),
			);

		$this->db->where($this->tradingterm_id, $id);
		$this->db->update($this->tradingterm_table, $data);
//        $this->db->delete($this->tradingterm_table);
    }

//==================================================================================================
// Payment Term Section
//==================================================================================================
	// get all
    function paymentterm_get_all()
    {
        $this->db->order_by('payment_term', $this->order);
        return $this->db->get($this->paymentterm_table)->result();
    }

    // get data by id
    function paymentterm_get_by_id($id)
	{
        $this->db->where($this->paymentterm_id, $id);
        return $this->db->get($this->paymentterm_table)->row();
    }

	// insert data paymentterm
    function paymentterm_insert($data)
    {
        $this->db->insert($this->paymentterm_table, $data);
    }

    // update data paymentterm
    function paymentterm_update($id, $data)
    {
        $this->db->where($this->paymentterm_id, $id);
        $this->db->update($this->paymentterm_table, $data);
    }

	//check data exist
	function paymentterm_exists($param)
	{
		$this->db->where($param);
		$q = $this->db->get($this->paymentterm_table)->row();
		if (isset($q->payment_term_id)){
			return $q->payment_term_id;
		} else {
			return 0;
		}

	}

    // delete data paymentterm
    function paymentterm_delete($id)
    {
        $this->db->where($this->paymentterm_id, $id);
        $this->db->delete($this->paymentterm_table);
    }

//==================================================================================================
// Product Shelf Life Section
//==================================================================================================
	// get all
    function shelf_get_all()
    {
        $this->db->order_by('product_shelf_life', $this->order);
        return $this->db->get($this->shelf_table)->result();
    }

    // get data by id
    function shelf_get_by_id($id)
	{
        $this->db->where($this->shelf_id, $id);
        return $this->db->get($this->shelf_table)->row();
    }

	// insert data shelf
    function shelf_insert($data)
    {
        $this->db->insert($this->shelf_table, $data);
		return $this->db->insert_id();
    }

    // update data shelf
    function shelf_update($id, $data)
    {
        $this->db->where($this->shelf_id, $id);
        $this->db->update($this->shelf_table, $data);
    }

    // delete data shelf
    function shelf_delete($id)
    {
        $this->db->where($this->shelf_id, $id);
        $this->db->delete($this->shelf_table);
    }

//==================================================================================================
// Bank Detail Section
//==================================================================================================
	// get all
    function bank_get_all()
    {
        $this->db->order_by('bank_name', $this->order);
        return $this->db->get($this->bank_view)->result();
    }

    // get data by id
    function bank_get_by_id($id)
	{
        $this->db->where('bank_id', $id);
        return $this->db->get($this->bank_view)->row();
    }

	// insert data bank
    function bank_insert($data)
    {
        $this->db->insert($this->bank_table, $data);
    }

    // update data bank
    function bank_update($id, $data)
    {
        $this->db->where('bank_id', $id);
        $this->db->update($this->bank_table, $data);
    }

    // delete data bank
    function bank_delete($id)
    {
        $this->db->where('bank_id', $id);
        $this->db->delete($this->bank_table);
    }

    // get data by customer id
    function bank_get_detail($id)
    {
        $this->db->where('customer_id', $id);
        return $this->db->get($this->cust_bank_view)->result();
    }

//==================================================================================================
// Main Category Section
//==================================================================================================
	// get all
    function maincate_get_all()
    {
        $this->db->order_by('main_category_name', $this->order);
        return $this->db->get($this->maincate_table)->result();
    }

	// get data by id
    function maincate_get_by_id($id)
	{
        $this->db->where($this->maincate_id, $id);
        return $this->db->get($this->maincate_table)->row();
    }

	// insert data main category
    function maincate_insert($data)
    {
        $this->db->insert($this->maincate_table, $data);
    }

	// update data main category
    function maincate_update($id, $data)
    {
        $this->db->where($this->maincate_id, $id);
        $this->db->update($this->maincate_table, $data);
    }

    // delete data main category
    function maincate_delete($id)
    {
        $this->db->where($this->maincate_id, $id);
        $this->db->delete($this->maincate_table);
    }


//==================================================================================================
// Supplier Section
//==================================================================================================
	// get supplier id from factory id
    function get_sup_id($factory_id)
    {
        $this->db->where('factory_id', $factory_id);
        return $this->db->get($this->sup_table)->row();
    }

	function get_all_sup()
	{
		$this->db->where('factory_id > 0');
		return $this->db->get($this->sup_table)->result();
	}

}
