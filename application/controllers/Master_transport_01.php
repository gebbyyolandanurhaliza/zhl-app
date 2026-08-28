<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Master_transport extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
		if (!$this->session->userdata('userid_1')) {
            redirect('login');
        }

        $this->load->model(array(
            'M_master_transport'
        ));

    }

    // BEGIN TRANSPORT CHARGES

    function json()
    {
        header('Content-Type: application/json');
        echo $this->M_master_transport->json();
    }

    function index()
    {
        $data = array(
            'message'       => $this->session->flashdata('message'),
        );

        $this->template->display('shipping/master_freight/transport_charges/transport_list', $data);
    }

    function add()
    {
        $cbo_container_type = $this->M_master_transport->get_container_type();

        $data = array(
            'header_title'          => 'Transport Charges',
            'action'                => site_url('master-transport/save'),
            'button'			    => '<i class="fa fa-save"></i> Save',
            'current_date'          => date('d/m/Y'),
            'cbo_container_type'    => $cbo_container_type,

            'transport_charges_id'  => '',
            'container_id'          => '',
            'container_size'        => '',
            'validity'              => '',

            'vendor_empty'          => set_value('vendor_empty'),
            'vendor_laden'          => set_value('vendor_laden'),
            'vendor_loose_cargo'    => set_value('vendor_loose_cargo'),
            'vendor_misc'           => set_value('vendor_misc'),

            'cust_empty'            => set_value('cust_empty'),
            'cust_laden'            => set_value('cust_laden'),
            'cust_loose_cargo'      => set_value('cust_loose_cargo'),
            'cust_misc'             => set_value('cust_misc'),
        );

        $this->template->display('shipping/master_freight/transport_charges/transport_form', $data);

    }

    function edit($transport_charges_id)
    {
        $cbo_container_type = $this->M_master_transport->get_container_type();

        $row = $this->M_master_transport->get_by_id($transport_charges_id);

        $data = array(
            'header_title'          => 'Transport Charges',
            'action'                => site_url('master-transport/update'),
            'button'			    => '<i class="fa fa-save"></i> Update',
            'current_date'          => date('d/m/Y'),
            'cbo_container_type'    => $cbo_container_type,

            'transport_charges_id'  => set_value('transport_charges_id', $transport_charges_id),
            'container_id'          => set_value('container_id', $row->container_id),
            'container_size'        => set_value('container_size', $row->container_size),
            'validity'              => set_value('validity', tgl_ind($row->validity)),

            'vendor_empty'          => set_value('vendor_export_empty', $row->vendor_empty),
            'vendor_laden'          => set_value('vendor_export_laden', $row->vendor_laden),
            'vendor_loose_cargo'    => set_value('vendor_import_transhipment', $row->vendor_loose_cargo),
            'vendor_misc'           => set_value('vendor_misc', $row->vendor_misc),

            'cust_empty'            => set_value('cust_export_empty', $row->cust_empty),
            'cust_laden'            => set_value('cust_export_laden', $row->cust_laden),
            'cust_loose_cargo'      => set_value('cust_import_transhipment', $row->cust_loose_cargo),
            'cust_misc'             => set_value('cust_misc', $row->cust_misc),
        );

        $this->template->display('shipping/master_freight/transport_charges/transport_form', $data);
    }

    function save()
    {
        $this->db->trans_off();
		$this->db->trans_start();

		$insertid = $this->M_master_transport->insert();

		$this->db->trans_complete();

		//generate error
		if ($this->db->trans_status() === FALSE)
		{
			$this->session->set_flashdata('message', pesan('Transport Charge Saving Error.', pesan_error()));
		} else {
			$this->session->set_flashdata('message', pesan('Transport Charge Succesfully Saved.', pesan_sukses()));
		}

        redirect(site_url('master-transport'));
    }

    function update()
    {
        $this->db->trans_off();
		$this->db->trans_start();

		$this->M_master_transport->update();

		$this->db->trans_complete();

		//generate error
		if ($this->db->trans_status() === FALSE)
		{
			$this->session->set_flashdata('message', pesan('Transport Charge Update Error.', pesan_error()));
		} else {
			$this->session->set_flashdata('message', pesan('Transport Charge Succesfully Update.', pesan_sukses()));
		}

        redirect(site_url('master-transport'));
    }

    function delete($id)
    {
        $this->db->trans_off();
		$this->db->trans_start();

        $this->M_master_transport->delete($id);

        $this->db->trans_complete();

		//generate error
		if ($this->db->trans_status() === FALSE)
		{
			$this->session->set_flashdata('message', pesan('Transport Charge Delete Error.', pesan_error()));
		} else {
			$this->session->set_flashdata('message', pesan('Transport Charge Succesfully Deleted.', pesan_sukses()));
		}

        redirect(site_url('master-transport'));

    }

}
