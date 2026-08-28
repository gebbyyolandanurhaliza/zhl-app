<?php if (!defined('BASEPATH'))  exit('No direct script access allowed');

class M_mar_product extends CI_Model
{
	private $product_table			= 'mar_tblmst_product';
	private $product_view			= 'zhl_pur_vw_mst_item';
	private $product_view_active	= 'mar_vw_mst_product_active';
	private $product_id				= 'product_id';
	private $factory_access_tbl		= 'gen_tbl_utl_factory_access';

	private $product_category_table = 'mar_tblmst_product_category';
	private $product_category_view	= 'mar_vw_mst_product_category';
	private $product_category_id	= 'product_category_id';

	private $order = 'ASC';

	function __construct()
	{
		parent::__construct();
	}

	function usergroupid()
	{
		return $this->session->userdata('groupid');
	}

	//==================================================================================================
	// Product Section
	//==================================================================================================
	// get all
	function product_get_all()
	{
		$ugi = $this->usergroupid();

		$this->db->where('inactive', 0);
		$this->db->where("factory_id in (select factory_id from gen_tbl_utl_factory_access where user_group_id=$ugi)");
		$this->db->order_by('product_name', $this->order);
		return $this->db->get($this->product_view)->result();
	}

	// get data by id
	function product_get_by_id($id)
	{
		$ugi = $this->usergroupid();

		$this->db->where($this->product_id, $id);
		$this->db->where('inactive', 0);
		$this->db->where("factory_id in (select factory_id from gen_tbl_utl_factory_access where user_group_id=$ugi)");
		return $this->db->get($this->product_table)->row();
	}

	//get data with filter
	function product_get_by_filter($filter)
	{
		$ugi = $this->usergroupid();
		$this->db->where("factory_id in (select factory_id from $this->factory_access_tbl where user_group_id=$ugi) ");

		$this->db->group_start();
		$this->db->like('product_code', trim_all($filter));
		$this->db->or_like('product_name', trim_all($filter));
		$this->db->or_like('brand_name', trim_all($filter));
		$this->db->or_like('factory_abbr', trim_all($filter));
		$this->db->or_like('factory_name', trim_all($filter));
		$this->db->group_end();

		$this->db->order_by('inactive', 'desc');
		$this->db->order_by('product_name');

		return $this->db->get($this->product_view_active)->result();
	}

	// get data by search
	function product_get_by_search($param, $not = '', $f_id = '')
	{
		$sql = $this->db->select('*')->from($this->product_view_active)
			->where('inactive', 0)
			->group_start()
			->like('product_code', $param)
			->or_like('product_name', $param)
			->or_like('factory_abbr', $param)
			->or_like('factory_name', $param)
			->group_end()
			//			->where_in('factory_id', $f_id)
			//			->where_not_in('product_id', $not)
			->get();
		return $sql->result();
	}


	//fungsi dibawah tanpa parameter not in, jadi semua produk yg sudah di add bisa di add lagi
	//fungsi where in juga dihilangkan, karena product bisa mixed
	function product_get_by_search2($param, $f_id)
	{
		//		$sql = $this->db->select('*')->from($this->product_view)
		$sql = $this->db->select('*')->from($this->product_view_active)
			->where('inactive', 0)
			->group_start()
			->like('product_code', $param)
			->or_like('product_name', $param)
			->or_like('factory_abbr', $param)
			->or_like('factory_name', $param)
			->group_end()
			->where_in('factory_id', $f_id)
			->get();
		return $sql->result();
	}

	// get data by search
	function product_get_by_search3($param, $not)
	{
		$sql = $this->db->select('*')->from($this->product_view)
			// ->where('inactive', 0)
			// ->group_start()
			// ->like('product_code', $param)
			// ->or_like('product_name', $param)
			// ->or_like('factory_abbr', $param)
			// ->or_like('factory_name', $param)
			// ->group_end()
			// //			->where_in('factory_id', $f_id)
			// ->where_not_in('product_id', $not)
			->get();
		return $sql->result();
	}

	function product_get_by_search_po($param, $f_id)
	{
		$sql = $this->db->select('*')->from($this->product_view_active)
			->where('inactive', 0)
			->group_start()
			->like('product_code', $param)
			->or_like('product_name', $param)
			->or_like('factory_abbr', $param)
			->or_like('factory_name', $param)
			->group_end()
			->where_in('factory_id', $f_id)
			->get();
		return $sql->result();
	}

	//get data by factory
	function product_get_by_factory($factory_id)
	{
		$this->db->where('factory_id', $factory_id);
		return $this->db->get($this->product_table)->row();
	}

	// insert data product
	function product_insert($data)
	{
		$this->db->insert($this->product_table, $data);
		$product_id = $this->db->insert_id();
		return $product_id;
	}

	// update data product
	function product_update($id, $data)
	{
		$this->db->where($this->product_id, $id);
		$this->db->update($this->product_table, $data);
	}

	function product_packing_list_update()
	{
		$pid_count		= count($this->input->post('p_count'));
		$product_id		= $this->input->post('product_id');
		//		$product_name	= $this->input->post('product_name');
		$product_view	= $this->input->post('product_view');
		$packing_view	= $this->input->post('packing_view');
		$gross_weight	= $this->input->post('gross_weight');
		$net_weight		= $this->input->post('net_weight');

		$berhasil = 0;
		for ($i = 0; $i < $pid_count; $i++) {
			$info = array(
				'product_view'	=> $product_view[$i],
				'packing_view'	=> $packing_view[$i],
				'gross_weight'	=> remove_thousand_separator($gross_weight[$i]),
				'net_weight'	=> remove_thousand_separator($net_weight[$i]),
			);
			$this->db->where('product_id', $product_id[$i]);
			$this->db->update($this->product_table, $info);

			$berhasil = $i;
		}
		//		$berhasil = 1;
		return $berhasil;
	}

	// delete data product
	function product_delete($id)
	{
		$this->db->where($this->product_id, $id);
		$this->db->delete($this->product_table);
	}

	// set product inactive
	function product_set_inactive($id)
	{
		$this->db->where($this->product_id, $id);
		$this->db->update($this->product_table, array('inactive' => 1));
	}


	//==================================================================================================
	// Product Category Section
	//==================================================================================================
	// get all
	function product_category_get_all()
	{
		$this->db->order_by('product_category_name', $this->order);
		return $this->db->get($this->product_category_view)->result();
	}

	function product_category_get_active()
	{
		$this->db->where('not_active', 0);
		$this->db->order_by('product_category_name', $this->order);
		return $this->db->get($this->product_category_view)->result();
	}

	// get data by id
	function product_category_get_by_id($id)
	{
		$this->db->where($this->product_category_id, $id);
		return $this->db->get($this->product_category_table)->row();
	}

	// get data by search
	function product_category_get_by_search($param)
	{
		$this->db->like('product_category_name', $param);

		return $this->db->get($this->product_category_view)->result();
	}

	// insert data product category
	function product_category_insert($data)
	{
		$this->db->insert($this->product_category_table, $data);
		$product_category_id = $this->db->insert_id();
		return $product_category_id;
	}

	// update data product category
	function product_category_update($id, $data)
	{
		$this->db->where($this->product_category_id, $id);
		$this->db->update($this->product_category_table, $data);
	}

	// delete data product category
	function product_category_delete($id)
	{
		$this->db->where($this->product_category_id, $id);
		$this->db->delete($this->product_category_table);
	}

	//==================================================================================================
	// COA Section
	//==================================================================================================
	//get COA Inv
	function get_coa_inv()
	{
		$this->db->where('LEFT(NoCOA,4)', '1101');
		return $this->db->get('acc_master_coa')->result();
	}

	//get COA COGS
	function get_coa_cogs()
	{
		$this->db->where('LEFT(NoCOA,4)', '5001');
		return $this->db->get('acc_master_coa')->result();
	}

	//get COA Sales
	function get_coa_sales()
	{
		$this->db->where('LEFT(NoCOA,4)', '4001');
		return $this->db->get('acc_master_coa')->result();
	}
}
