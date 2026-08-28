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
        $this->load->library('form_validation');
    }

	function index($nama_master)
    {
		$get_all = $this->M_gen_master->get_all($nama_master);
		
		switch ($nama_master) {
			case 'country':
				$data = array(
					'country_data' => $get_all
				);
				$data['message'] = $this->session->flashdata('message');
				$this->template->display('general/master/country/list', $data);
				break;
			
			case 'currency':
				$data = array(
					'currency_data' => $get_all
				);
				$data['message'] = $this->session->flashdata('message');
				$this->template->display('general/master/currency/list', $data);
				break;

			default:
				break;
		}        
    }
	
	function country()
	{
		$this->index('country');
	}
	
	function currency()
	{
		$this->index('currency');
	}
	
	function create_master($nama_master) 
    {
		switch ($nama_master) {
			case 'country':
				$this-> do_create_country();
				break;
			
			case 'currency':
				$this-> do_create_currency();
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
            redirect(site_url('master/'.$nama_master));
        } else {
            $this->session->set_flashdata('message', pesan('Record Not Found', pesan_peringatan()));
            redirect(site_url('master/'.$nama_master));
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
			'country_idn'	=> set_value('country_idn')
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
	
	function save_country() 
    {
        $this->_rules_country();

        if ($this->form_validation->run() == FALSE) {
            $this->create_master('country');
        } else {
            $data = array(
				'country_name'	=> $this->input->post('country_name',TRUE),
				'country_ids'	=> $this->input->post('country_ids',TRUE),
				'country_idn'	=> $this->input->post('country_idn',TRUE),
				'created_by'	=> strtoupper($this->session->userdata('userid_1')),
				'created_date'	=> date('Y-m-d H:i:s')
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
				'currency_name'			 => $this->input->post('currency_name',TRUE),
				'currency_symbol'		 => strtoupper($this->input->post('currency_symbol',TRUE)),
				'currency_say_in_words'	 => $this->input->post('currency_say_in_words',TRUE),
				'currency_say_in_words2' => $this->input->post('currency_say_in_words2',TRUE),
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
				'country_idn'	=> set_value('country_idn', $row->country_idn)				
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
				'country_name'	=> $this->input->post('country_name',TRUE),
				'country_ids'	=> $this->input->post('country_ids',TRUE),
				'country_idn'	=> $this->input->post('country_idn',TRUE),
				'updated_by'	=> strtoupper($this->session->userdata('userid_1')),
				'updated_date'	=> date('Y-m-d H:i:s')
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
				'currency_id'			 => strtoupper($this->input->post('currency_id',TRUE)),
				'currency_name'			 => $this->input->post('currency_name',TRUE),
				'currency_symbol'		 => strtoupper($this->input->post('currency_symbol',TRUE)),
				'currency_say_in_words'	 => $this->input->post('currency_say_in_words',TRUE),
				'currency_say_in_words2' => $this->input->post('currency_say_in_words2',TRUE),
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
	
}