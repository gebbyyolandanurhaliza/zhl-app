<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Master_vessel_shipping extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
		if (!$this->session->userdata('userid_1')) {
            redirect('login');
        }

        $this->load->model(array(
            'M_master_vessel_shipping'
        ));

    }

    function index()
    {
        $data['vessel'] = $this->M_master_vessel_shipping->get_data_vessel();
        $data['message'] = $this->session->flashdata('message');
        $this->template->display('shipping/mst_vessel/vessel_shipping_list', $data);
    }

    function add()
    {
        $userid = $this->session->userdata('userid');
        $data = array(
            'header_title'          => 'Master Vessel Shipping',
            'action'                => site_url('Master_vessel_shipping/save'),
            'button'			    => '<i class="fa fa-save"></i> Save',
            'current_date'          => date('d/m/Y'),
            'vessel_name'           => set_value('vessel_name'),
            'vessel_id'             => set_value('vessel_id'),
            'created_by'            => $userid
        );

        $this->template->display('shipping/mst_vessel/vessel_shipping_form', $data);

    }

    function edit($vessel_id)
    {
        $row = $this->M_master_vessel_shipping->get_by_id($vessel_id);
        $userid = $this->session->userdata('userid');

        $data = array(
            'header_title'          => 'Master Vessel Shipping',
            'action'                => site_url('Master_vessel_shipping/update'),
            'button'			    => '<i class="fa fa-save"></i> Update',
            'current_date'          => date('d/m/Y'),
            'vessel_id'             => set_value('vessel_id', $vessel_id),
            'vessel_name'           => set_value('vessel_name', $row->vessel_name),
            'updated_by'            => $userid
        );

        $this->template->display('shipping/mst_vessel/vessel_shipping_form', $data);
    }

    function save()
    {
        $this->db->trans_off();
		$this->db->trans_start();

		$insertid = $this->M_master_vessel_shipping->insert();

		$this->db->trans_complete();

		//generate error
		if ($this->db->trans_status() === FALSE)
		{
			$this->session->set_flashdata('message', pesan('Vessel Saving Error.', pesan_error()));
		} else {
			$this->session->set_flashdata('message', pesan('Vessel Succesfully Saved.', pesan_sukses()));
		}

        redirect(site_url('Master_vessel_shipping'));
    }

    function update()
    {
        $this->db->trans_off();
		$this->db->trans_start();

		$this->M_master_vessel_shipping->update();

		$this->db->trans_complete();

		//generate error
		if ($this->db->trans_status() === FALSE)
		{
			$this->session->set_flashdata('message', pesan('Vessel Charge Update Error.', pesan_error()));
		} else {
			$this->session->set_flashdata('message', pesan('Vessel Succesfully Update.', pesan_sukses()));
		}

        redirect(site_url('Master_vessel_shipping'));
    }

    function delete($id)
    {
        $this->db->trans_off();
		$this->db->trans_start();

        $this->M_master_vessel_shipping->delete($id);

        $this->db->trans_complete();

		if ($this->db->trans_status() === FALSE)
		{
			$this->session->set_flashdata('message', pesan('Vessel Shipping Charge Delete Error.', pesan_error()));
		} else {
			$this->session->set_flashdata('message', pesan('Vessel Shipping Charge Succesfully Deleted.', pesan_sukses()));
		}

        redirect(site_url('Master_vessel_shipping'));

    }

}
