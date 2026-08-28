<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_gen_menu extends CI_Model{
	
	private $tblmenuhdr;
	private $tblmenudtl;
	private $tblmenudtlsub;
	
	function __construct(){
		parent::__construct();
		
		$this->tblmenuhdr = 'zhl_gen_tbl_utl_menu_hdr';
		$this->tblmenudtl = 'zhl_gen_tbl_utl_menu_dtl';
		$this->tblmenudtlsub = 'zhl_gen_tbl_utl_menu_dtlsub';
	}
		
	function combo_app_list(){
		
		$this->db->order_by('app_sort');
		return $this->db->get('zhl_gen_tbl_applications');
	}
	
	function combo_menu_header(){
		$this->db->order_by('menuhdr_id');
		return $this->db->get($this->tblmenuhdr);
	}
	
	function combo_menu_detail(){
		$this->db->order_by('menudtl_id');
		return $this->db->get('zhl_gen_vw_utl_menu_dtl');
	}
	
	function save($menutable, $info){
//		$this->db->protect_identifiers('gen_tbl_utl_menu_hdr');
		
		$this->db->trans_start();
		switch ($menutable) {
			case 'header':
				$success = $this->db->insert($this->tblmenuhdr, $info);
				break;

			case 'detail':
				$success = $this->db->insert($this->tblmenudtl, $info);
				break;
			
			case 'detailsub':
				$success = $this->db->insert($this->tblmenudtlsub, $info);
				break;
			
			default:
				break;
		}
		$this->db->trans_complete();
		return $success;
		
	}
	
	function update($menutable, $menuid, $info){
		$this->db->trans_start();
		switch ($menutable) {
			case 'header':
				$this->db->where('menuhdr_id', $menuid);
				$this->db->update($this->tblmenuhdr, $info);
				break;
			
			case 'detail':
				$this->db->where('menudtl_id', $menuid);
				$this->db->update($this->tblmenudtl, $info);
				break;
			
			case 'detailsub':
				$this->db->where('menudtlsub_id', $menuid);
				$this->db->update($this->tblmenudtlsub, $info);
				break;

			default:
				break;
		}
		$this->db->trans_complete();
		return true;
	}
	
	function record_menu_header(){
		$this->db->order_by('menuhdr_id');
		return $this->db->get('zhl_gen_vw_utl_menu_hdr');
	}
	
	function record_menu_detail(){
		$this->db->order_by('menudtl_id');
		return $this->db->get('zhl_gen_vw_utl_menu_dtl');
	}
	
	function record_menu_detailsub(){
		$this->db->order_by('menudtlsub_id');
		return $this->db->get('zhl_gen_vw_utl_menu_dtlsub');
	}
	
	function delete($menutable, $menuid){
		switch ($menutable) {
			case 'header':
				$sql = 'delete from zhl_gen_tbl_utl_menu_dtlsub where menudtlsub_id in (select menudtlsub_id from zhl_gen_vw_utl_menu where menuhdr_id = '.$menuid.') ';
				$this->db->query($sql);
				
				$sql = 'delete from zhl_gen_tbl_utl_menu_dtl where menudtl_id in (select menudtl_id from zhl_gen_vw_utl_menu where menuhdr_id = '.$menuid.') ';
				$this->db->query($sql);
				
				$this->db->delete($this->tblmenuhdr, array('menuhdr_id' => $menuid));
				break;
			
			case 'detail':
				$sql = 'delete from zhl_gen_tbl_utl_menu_dtlsub where menudtlsub_id in (select menudtlsub_id from zhl_gen_vw_utl_menu where menudtl_id = '.$menuid.') ';
				$this->db->query($sql);
				
				$this->db->delete($this->tblmenudtl, array('menudtl_id' => $menuid));
				break;
			
			case 'detailsub':
				$this->db->delete($this->tblmenudtlsub, array('menudtlsub_id' => $menuid));
				break;

			default:
				break;
		}
		
	}
	
	function get_menu_detail($menutable, $id){
		switch ($menutable) {
			case 'header':
				$hasil = $this->db->get_where($this->tblmenuhdr, array('menuhdr_id' => $id));
				break;
			
			case 'detail':
				$hasil = $this->db->get_where($this->tblmenudtl, array('menudtl_id' => $id));				
				break;
			
			case 'detailsub':
				$hasil = $this->db->get_where($this->tblmenudtlsub, array('menudtlsub_id' => $id));
				break;

			default:
				break;
		}
		
		return $hasil;
	}
	
	function get_menu_by_id($menutable, $id){
		switch ($menutable) {
			case 'header':
				$field_id = 'menuhdr_id';
				$table = $this->tblmenuhdr;
				break;
			case 'detail':
				$field_id = 'menudtl_id';
				$table = $this->tblmenudtl;
				break;
			case 'detailsub':
				$field_id = 'menudtlsub_id';
				$table = $this->tblmenudtlsub;
				break;

			default:
				break;
		}
		
		$this->db->where($field_id, $id);
		return $this->db->get($table)->row();
	}
			
}