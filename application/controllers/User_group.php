<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class User_group extends CI_Controller
{
	function __construct()
    {
        parent::__construct();
		
		if (!$this->session->userdata('userid_1')) {
            redirect('login');
        }
		
        $this->load->model(array('M_User_Group','M_mar_master'));
        $this->load->library('form_validation');
    }
	
	function index()
    {
		$user_group = $this->M_User_Group->get_all();
		$data = array(
			'user_group_data' => $user_group
		);
		$data['message'] = $this->session->flashdata('message');
		$this->template->display('general/utility/users/group/index', $data);
    }
	
	function create() 
    {
        $data = array(
            'button'			=> 'Save',
            'action'			=> site_url('user_group/save'),
			'header_title'		=> 'Users Group - Create New',
			'user_group_id'		=> set_value('user_group_id'),
			'user_group_name'	=> set_value('user_group_name'),
			'user_group_remark'	=> set_value('user_group_remark')
		);
        $this->template->display('general/utility/users/group/form', $data);
    }
	
	function save() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create;
        } else {
            $data = array(
				'user_group_name'	=> $this->input->post('user_group_name',TRUE),
				'user_group_remark'	=> $this->input->post('user_group_remark',TRUE),
				'created_by'		=> strtoupper($this->session->userdata('userid_1')),
				'created_date'		=> date('Y-m-d H:i:s')
			);

            $this->M_User_Group->insert($data);
            $this->session->set_flashdata('message', pesan('Create Record Success', pesan_sukses()));
            redirect(site_url('user_group'));
        }
    }
	
	function edit($id) 
    {
        $row = $this->M_User_Group->get_by_id($id);

        if ($row) {
            $data = array(
                'button'			=> 'Update',
                'action'			=> site_url('user_group/update'),
				'header_title'		=> 'Users Group - Edit',
				'user_group_id'		=> set_value('user_group_id', $row->user_group_id),
				'user_group_name'	=> set_value('user_group_name', $row->user_group_name),	
				'user_group_remark'	=> set_value('user_group_remark', $row->user_group_remark),
			);
            $this->template->display('general/utility/users/group/form', $data);
        } else {
            $this->session->set_flashdata('message', pesan('Record Not Found', pesan_peringatan()));
            redirect(site_url('user_group'));
        }
    }
	
	function update() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('user_group_id', TRUE));
        } else {
            $data = array(
				'user_group_name'	=> $this->input->post('user_group_name',TRUE),
				'user_group_remark'	=> $this->input->post('user_group_remark',TRUE),
				'updated_by'		=> strtoupper($this->session->userdata('userid_1')),
				'updated_date'		=> date('Y-m-d H:i:s')
	    );

            $this->M_User_Group->update($this->input->post('user_group_id', TRUE), $data);
            $this->session->set_flashdata('message', pesan('Update Record Success', pesan_sukses()));
            redirect(site_url('user_group'));
        }
    }
	
	function delete($id) 
    {
        $row = $this->M_User_Group->get_by_id($id);

        if ($row) {
            $this->M_User_Group->delete($id);
            $this->session->set_flashdata('message', pesan('Delete Record Success', pesan_sukses()));
            redirect(site_url('user_group'));
        } else {
            $this->session->set_flashdata('message', pesan('Record Not Found', pesan_peringatan()));
            redirect(site_url('user_group'));
        }
    }
	
	function _rules() 
    {
		$this->form_validation->set_rules('user_group_name', 'group name', 'trim|required');
		
		$this->form_validation->set_rules('user_group_id', 'user_group_id', 'trim');
		$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }
	
	function access($user_group_id)
	{
		$row		 = $this->M_User_Group->get_by_id($user_group_id);
		$menu		 = $this->M_User_Group->get_menu_union();		
		$user_access = $this->M_User_Group->get_user_access($user_group_id)->result();
		
		$factory	 = $this->M_mar_master->get_all_comp();
		$factory_access = $this->M_mar_master->get_comp_access($user_group_id);
		
		if ($row) {
            $data = array(
                'header_title'		=> 'Users Group - Menu Access',
				'user_group_id'		=> set_value('user_group_id', $row->user_group_id),
				'user_group_name'	=> set_value('user_group_name', $row->user_group_name),					
				'menu'				=> $menu,
				'user_access'		=> $user_access,
				'factory'			=> $factory,
				'factory_access'	=> $factory_access,
			);
            $this->template->display('general/utility/users/group/access', $data);
        } else {
            $this->session->set_flashdata('message', pesan('Record Not Found', pesan_peringatan()));
            redirect(site_url('user_group'));
        }		
	}
	
	function access_save()
	{
		$user_group_id	= $this->input->post('user_group_id');
		$chkid			= $this->input->post('chk');
		$jummenu		= count($this->input->post('menu'));
		
		$msg_menu		= '';
		$msg_factory	= '';
			
		if (!empty($chkid)){
			$this->M_User_Group->delete_access_by_id($user_group_id);
			
			for($i=0; $i < $jummenu; $i++){
				
				if (isset($chkid[$i]))
				{
					$menu_id	= $chkid[$i];
					
					$row = $this->M_User_Group->get_parent_menu_by_id($menu_id);
					
					if ($row)
					{
						// simpan menu level 1 (header)
						$this->M_User_Group->save_access($user_group_id, $row->menuhdr_id);
						
						// simpan menu level 2 (detail)
						$this->M_User_Group->save_access($user_group_id, $row->menudtl_id);
						
						// simpan menu level 3 (sub detail)
						$this->M_User_Group->save_access($user_group_id, $menu_id);
					}					
				}
			}
			$msg_menu	= pesan('Succesfully set up the menu access', pesan_sukses());
//			$this->session->set_flashdata('message', pesan('Create Record Success.', pesan_sukses()));
//			redirect(site_url('user_group'));
		}
		
		$chkfid			= $this->input->post('chkf');
		$jumfactory		= count($this->input->post('factory_id'));
		
		if (!empty($chkfid)){
			$this->M_User_Group->delete_company_access_by_id($user_group_id);
			
			for($j=1; $j <= $jumfactory; $j++){
				
				if (isset($chkfid[$j]))
				{
					$factory_id	= $chkfid[$j];
					
					// simpan factory id
					$this->M_User_Group->save_company_access($user_group_id, $factory_id);
				}
			}
			
			$msg_factory	= pesan('Succesfully set up the factory access', pesan_sukses());
		}
		
		$this->session->set_flashdata('message', $msg_menu.$msg_factory);
		redirect(site_url('user_group'));
		
	}
	
}