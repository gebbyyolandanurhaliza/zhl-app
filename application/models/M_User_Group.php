<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class M_User_Group extends CI_Model
{
	private $table = 'zhl_gen_tbl_utl_user_group';	
    private $id = 'user_group_id';
    private $order = 'DESC';
	
	private $tblmenu_header		= 'zhl_gen_tbl_utl_menu_hdr';
	private $tblmenu_detail		= 'zhl_gen_tbl_utl_menu_dtl';
	private $tblmenu_detailsub	= 'zhl_gen_tbl_utl_menu_dtlsub';
	private $tblmenu_access		= 'zhl_gen_tbl_utl_menu_access';
	private $tblfact_access		= 'zhl_gen_tbl_utl_factory_access';

	private $tblcomp_access		= 'zhl_gen_tbl_utl_company_acc_access';
	
	private $vw_menu_all		= 'zhl_gen_vw_utl_menu';
	private $vw_menu_access		= 'zhl_gen_vw_utl_menu_access';

    function __construct()
    {
        parent::__construct();
    }

    // get all
    function get_all()
    {
		$this->db->where('not_active', 0);
		$this->db->order_by('user_group_name', 'ASC');
		return $this->db->get($this->table)->result();		
    }
	
	// get data by id
    function get_by_id($id)
    {		
		$table = $this->table;
		$this->db->where($this->id, $id);
		
        return $this->db->get($table)->row();
    }
	
	// get total rows
    function total_rows($q = NULL) {
		$this->db->where('not_active', 0);
        $this->db->like('user_group_id', $q);
		$this->db->or_like('user_group_name', $q);
		$this->db->from($this->table);
        return $this->db->count_all_results();
    }
	
	 // get data with limit and search
    function get_limit_data($limit, $start = 0, $q = NULL) {
        $this->db->order_by($this->id, $this->order);
        $this->db->like('user_group_id', $q);
		$this->db->or_like('user_group_name', $q);
		$this->db->or_like('created_by', $q);
		$this->db->or_like('created_date', $q);
		$this->db->or_like('updated_by', $q);
		$this->db->or_like('updated_date', $q);
		$this->db->limit($limit, $start);
        return $this->db->get($this->table)->result();
    }
	
	// insert data
    function insert($data)
    {
		$this->db->insert($this->table, $data);
    }
	
	// update data
    function update($id, $data)
    {
		$this->db->where($this->id, $id);
        $this->db->update($this->table, $data);
    }
	
	// delete data
    function delete($id)
    {
		$this->db->where($this->id, $id);
		$this->db->update($this->table, array('not_active' => 1));
    }
	
	// get data menu header
	function get_menu_header(){
		return $this->db->get($this->tblmenu_header)->result();
	}
	
	// get data menu detail
	function get_menu_detail($parent_id = 0){
		if ($parent_id != 0){
			$this->db->where('menuhdr_id');
		}
		return $this->db->get($this->tblmenu_detail)->result();
	}
	
	// get data menu detailsub
	function get_menu_detailsub($parent_id = 0){
		if ($parent_id != 0){
			$this->db->where('menudtl_id');
		}
		return $this->db->get($this->tblmenu_detailsub)->result();
	}
		
	// get data menu union
	function get_menu_union(){
		$this->db->order_by('menu_id');
		return $this->db->get('zhl_gen_vw_utl_menu_union')->result();
	}
	
	// delete user access by id
	function delete_access_by_id($user_group_id)
	{
		$this->db->delete($this->tblmenu_access, array('user_group_id' => $user_group_id));
	}
	
	// save user access
	function save_access($user_group_id, $menu_id)
	{
		$row = $this->get_menu_access_by_id($user_group_id, $menu_id);
		
		if (!$row){
			$data = array(
				'user_group_id'	=> $user_group_id,
				'menu_id'		=> $menu_id,
			);

			$this->db->insert($this->tblmenu_access, $data);
		}
		
	}
	
	// delete factory access by id
	function delete_factory_access_by_id($user_group_id)
	{
		$this->db->delete($this->tblfact_access, array('user_group_id' => $user_group_id));
	}

	function delete_company_access_by_id($user_group_id)
	{
		$this->db->delete($this->tblcomp_access, array('user_group_id' => $user_group_id));
	}
	
	// save factory access
	function save_factory_access($user_group_id, $factory_id)
	{
		$frow = $this->get_factory_access_by_id($user_group_id, $factory_id);
		
		if (!$frow){
			$data = array(
				'user_group_id'	=> $user_group_id,
				'factory_id'	=> $factory_id,
			);

			$this->db->insert($this->tblfact_access, $data);
		}
	}

	function save_company_access($user_group_id, $factory_id)
	{
		$frow = $this->get_company_access_by_id($user_group_id, $factory_id);
		
		if (!$frow){
			$data = array(
				'user_group_id'	=> $user_group_id,
				'company_id'	=> $factory_id,
			);

			$this->db->insert($this->tblcomp_access, $data);
		}
	}
	
	function get_user_access($user_group_id)
	{
		$this->db->where('user_group_id', $user_group_id);
		return $this->db->get($this->tblmenu_access);
	}
	
	function get_parent_menu_by_id($menu_id)
	{
		$this->db->where('menudtlsub_id', $menu_id);
		$this->db->or_where('menudtl_id', $menu_id);
        return $this->db->get($this->vw_menu_all)->row();
	}
	
	function get_menu_access_by_id($user_group_id, $menu_id)
	{
		$this->db->where('user_group_id', $user_group_id);
		$this->db->where('menu_id', $menu_id);
		return $this->db->get('zhl_gen_tbl_utl_menu_access')->row();
	}
	
	// get menu level 1
	function get_menu_by_level($user_group_id, $level)
	{
		$param = array(
			'user_group_id'	=> $user_group_id,
			'menu_level'	=> $level,
		);
		return $this->db->get_where($this->vw_menu_access, $param)->row();
	}
	
	// 2016-12-05
	// get factory access
	function get_factory_access($user_group_id)
	{
		$this->db->where('user_group_id', $user_group_id);
		return $this->db->get($this->tblfact_access)->result();
	}
	
	function get_factory_access_by_id($user_group_id, $factory_id)
	{
		$this->db->where('user_group_id', $user_group_id);
		$this->db->where('factory_id', $factory_id);
		return $this->db->get($this->tblfact_access)->row();
	}

	function get_company_access_by_id($user_group_id, $factory_id)
	{
		$this->db->where('user_group_id', $user_group_id);
		$this->db->where('company_id', $factory_id);
		return $this->db->get($this->tblcomp_access)->row();
	}
}