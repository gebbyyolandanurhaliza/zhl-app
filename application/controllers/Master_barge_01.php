<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Master_barge extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
		if (!$this->session->userdata('userid_1')) {
            redirect('login');
        }

        $this->load->model(array(
            'M_master_barge'
        ));

    }

    // BEGIN BARGE CHARGES

    function json()
    {
        header('Content-Type: application/json');
        echo $this->M_master_barge->json();
    }

    function index()
    {
        $data = array(
            'message'       => $this->session->flashdata('message'),
        );

        $this->template->display('shipping/master_freight/barge_charges/barge_list', $data);
    }

    function add()
    {
        $cbo_container_type = $this->M_master_barge->get_container_type();

        $data = array(
            'header_title'          => 'Barge Charges',
            'action'                => site_url('master-barge/save'),
            'button'			    => '<i class="fa fa-save"></i> Save',
            'current_date'          => date('d/m/Y'),
            'cbo_container_type'    => $cbo_container_type,

            'barge_charges_id'      => '',
            'container_id'          => '',
            'container_size'        => '',
            'validity'              => '',

            'vendor_export_empty'           => set_value('vendor_export_empty'),
            'vendor_export_reefer'          => set_value('vendor_export_reefer'),
            'vendor_export_laden'           => set_value('vendor_export_laden'),
            'vendor_import_transhipment'    => set_value('vendor_import_transhipment'),
            'vendor_misc'                   => set_value('vendor_misc'),

            'cust_export_empty'             => set_value('cust_export_empty'),
            'cust_export_reefer'            => set_value('cust_export_reefer'),
            'cust_export_laden'             => set_value('cust_export_laden'),
            'cust_import_transhipment'      => set_value('cust_import_transhipment'),
            'cust_misc'                     => set_value('cust_misc'),
        );

        $this->template->display('shipping/master_freight/barge_charges/barge_form', $data);

    }

    function edit($barge_charges_id)
    {
        $cbo_container_type = $this->M_master_barge->get_container_type();

        $row = $this->M_master_barge->get_by_id($barge_charges_id);

        $data = array(
            'header_title'          => 'Barge Charges',
            'action'                => site_url('master-barge/update'),
            'button'			    => '<i class="fa fa-save"></i> Update',
            'current_date'          => date('d/m/Y'),
            'cbo_container_type'    => $cbo_container_type,

            'barge_charges_id'      => set_value('barge_charges_id', $barge_charges_id),
            'container_id'          => set_value('container_id', $row->container_id),
            'container_size'        => set_value('container_size', $row->container_size),
            'validity'              => set_value('validity', tgl_ind($row->validity)),

            'vendor_export_empty'           => set_value('vendor_export_empty', $row->vendor_export_empty),
            'vendor_export_reefer'          => set_value('vendor_export_reefer', $row->vendor_export_reefer),
            'vendor_export_laden'           => set_value('vendor_export_laden', $row->vendor_export_laden),
            'vendor_import_transhipment'    => set_value('vendor_import_transhipment', $row->vendor_import_transhipment),
            'vendor_misc'                   => set_value('vendor_misc', $row->vendor_misc),

            'cust_export_empty'             => set_value('cust_export_empty', $row->cust_export_empty),
            'cust_export_reefer'            => set_value('cust_export_reefer', $row->cust_export_reefer),
            'cust_export_laden'             => set_value('cust_export_laden', $row->cust_export_laden),
            'cust_import_transhipment'      => set_value('cust_import_transhipment', $row->cust_import_transhipment),
            'cust_misc'                     => set_value('cust_misc', $row->cust_misc),
        );

        $this->template->display('shipping/master_freight/barge_charges/barge_form', $data);
    }

    function save()
    {
        $this->db->trans_off();
		$this->db->trans_start();

		$insertid = $this->M_master_barge->insert();

		$this->db->trans_complete();

		//generate error
		if ($this->db->trans_status() === FALSE)
		{
			$this->session->set_flashdata('message', pesan('Barge Charge Saving Error.', pesan_error()));
		} else {
			$this->session->set_flashdata('message', pesan('Barge Charge Succesfully Saved.', pesan_sukses()));
		}

        redirect(site_url('master-barge'));
    }

    function update()
    {
        $this->db->trans_off();
		$this->db->trans_start();

		$this->M_master_barge->update();

		$this->db->trans_complete();

		//generate error
		if ($this->db->trans_status() === FALSE)
		{
			$this->session->set_flashdata('message', pesan('Barge Charge Update Error.', pesan_error()));
		} else {
			$this->session->set_flashdata('message', pesan('Barge Charge Succesfully Update.', pesan_sukses()));
		}

        redirect(site_url('master-barge'));
    }

    function delete($id)
    {
        $this->db->trans_off();
		$this->db->trans_start();

        $this->M_master_barge->delete($id);

        $this->db->trans_complete();

		//generate error
		if ($this->db->trans_status() === FALSE)
		{
			$this->session->set_flashdata('message', pesan('Barge Charge Delete Error.', pesan_error()));
		} else {
			$this->session->set_flashdata('message', pesan('Barge Charge Succesfully Deleted.', pesan_sukses()));
		}

        redirect(site_url('master-barge'));

    }

}
