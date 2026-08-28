<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_menu extends CI_Model{
	private $vw_menu_access = 'zhl_gen_vw_utl_menu_access';
	
	function __construct(){
		parent::__construct();
	}
	
	function get_head_menu()
	{
		$param1 = array(
			'user_group_id'	=> $this->session->userdata('groupid_1'),
			'menu_level'	=> 1,
		);
		$this->db->where($param1);
		$this->db->order_by('menu_id');
		$sql = $this->db->get($this->vw_menu_access);
		$res = $sql->result();
		// $sql->next_result();
		// $sql->free_result();
		
		return $res;
	}
}