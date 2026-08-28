<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Master_freight extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
		if (!$this->session->userdata('userid_1')) {
            redirect('login');
        }

        $this->load->model(array(
            'M_master_freight'
        ));

    }

    function index()
    {
        $data = array(
            'message'       => $this->session->flashdata('message'),
        );

        $this->template->display('shipping/master_freight/freight_charges/freight_list', $data);
    }

    function json()
    {
        header('Content-Type: application/json');
        echo $this->M_master_freight->json();
    }

    function add()
    {
        $cbo_container_type = $this->M_master_freight->get_container_type();
        $cbo_port           = $this->M_master_freight->get_port();
        $cbo_country        = $this->M_master_freight->get_country();

        $data = array(
            'header_title'          => 'Freight Charges',
            'action'                => site_url('master_freight/save'),
            'button'			    => '<i class="fa fa-save"></i> Save',
            'current_date'          => date('d/m/Y'),
            'cbo_container_type'    => $cbo_container_type,
            'cbo_port'              => $cbo_port,
            'cbo_country'           => $cbo_country,

            'freight_charges_id'    => set_value('freight_charges_id'),
            'container_id'          => set_value('container_id'),
            'container_size'        => set_value('container_size'),

            'port_id'               => set_value('port_id'),
            'country_id'            => set_value('country_id'),
            'vendor_rates'           => set_value('vendor_rates'),
            'cust_rates'            => set_value('cust_rates'),
            'vendor_misc'           => set_value('vendor_misc'),
            'cust_misc'             => set_value('cust_misc'),
            'validity'              => set_value('validity'),
        );

        $this->template->display('shipping/master_freight/freight_charges/freight_form', $data);

    }

    function edit($freight_charges_id)
    {
        $cbo_container_type = $this->M_master_freight->get_container_type();
        $cbo_port           = $this->M_master_freight->get_port();
        $cbo_country        = $this->M_master_freight->get_country();

        $row = $this->M_master_freight->get_by_id($freight_charges_id);

        $data = array(
            'header_title'          => 'Freight Charges',
            'action'                => site_url('master_freight/update'),
            'button'			    => '<i class="fa fa-save"></i> Update',
            'current_date'          => date('d/m/Y'),
            'cbo_container_type'    => $cbo_container_type,
            'cbo_port'              => $cbo_port,
            'cbo_country'           => $cbo_country,

            'freight_charges_id'    => set_value('freight_charges_id', $freight_charges_id),
            'container_id'          => set_value('container_id', $row->container_id),
            'container_size'        => set_value('container_size', $row->container_size),

            'port_id'               => set_value('port_id', $row->port_id),
            'country_id'            => set_value('country_id', $row->country_id),
            'vendor_rates'           => set_value('vendor_rates', $row->vendor_rates),
            'cust_rates'            => set_value('cust_rates', $row->cust_rates),
            'vendor_misc'           => set_value('vendor_misc', $row->vendor_misc),
            'cust_misc'             => set_value('cust_misc', $row->cust_misc),
            'validity'              => set_value('validity', tgl_ind($row->validity)),
        );

        $this->template->display('shipping/master_freight/freight_charges/freight_form', $data);

    }

    function save()
    {
        $this->db->trans_off();
		$this->db->trans_start();

		$insertid = $this->M_master_freight->insert();

		$this->db->trans_complete();

		//generate error
		if ($this->db->trans_status() === FALSE)
		{
			$this->session->set_flashdata('message', pesan('Freight Charge Saving Error.', pesan_error()));
		} else {
			$this->session->set_flashdata('message', pesan('Freight Charge Succesfully Saved.', pesan_sukses()));
		}

        redirect(site_url('master-freight'));
    }

    function update()
    {
        $this->db->trans_off();
		$this->db->trans_start();

		$this->M_master_freight->update();

		$this->db->trans_complete();

		//generate error
		if ($this->db->trans_status() === FALSE)
		{
			$this->session->set_flashdata('message', pesan('Freight Charge Update Error.', pesan_error()));
		} else {
			$this->session->set_flashdata('message', pesan('Freight Charge Succesfully Updated.', pesan_sukses()));
		}

        redirect(site_url('master-freight'));
    }

    function delete($id)
    {
        $this->db->trans_off();
		$this->db->trans_start();

		$this->M_master_freight->delete($id);

		$this->db->trans_complete();

		//generate error
		if ($this->db->trans_status() === FALSE)
		{
			$this->session->set_flashdata('message', pesan('Freight Charge Delete Error.', pesan_error()));
		} else {
			$this->session->set_flashdata('message', pesan('Freight Charge Succesfully Deleted.', pesan_sukses()));
		}

        redirect(site_url('master-freight'));
    }

    function ajax_country_by_port()
    {
        $port_id        = $this->input->post('port_id');
        $cbo_country    = $this->M_master_freight->get_country();
        $row            = $this->M_master_freight->get_port_by_id($port_id);

        $data = array(
            'cbo_country'     => $cbo_country,
            'country_id'      => $row->country_id,
        );

        $this->load->view('shipping/master_freight/freight_charges/combo_country', $data);
    }

    // BEGIN TRANSPORT CHARGES

    function transport_charges()
    {

    }

    function json_transport()
    {
        header('Content-Type: application/json');
        echo $this->M_master_freight->json_transport();
    }

    function transport_charges_add()
    {
        $cbo_container_type = $this->M_master_freight->get_container_type();
        $cbo_port = $this->M_master_freight->get_pss_port();
        $cbo_country = $this->M_master_freight->get_pss_country();

        $data = array(
            'header_title'          => 'Freight Charges',
            'action'                => site_url('master_freight/freight_charges_save'),
            'button'			    => '<i class="fa fa-save"></i> Save',
            'current_date'          => date('d/m/Y'),
            'cbo_container_type'    => $cbo_container_type,
            'cbo_port'              => $cbo_port,
            'cbo_country'           => $cbo_country,

            'container_id'          => set_value('container_id'),
            'container_size'        => set_value('container_size'),

            'port_id'               => set_value('port_id'),
            'country_id'            => set_value('country_id'),
            'rates'                 => set_value('rates'),
            'validity'              => set_value('validity'),
            'misc'                  => set_value('misc')
        );

        $this->template->display('shipping/master_freight/freight_charges/freight_form', $data);
    }

}
