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

        $cbo_fob            = $this->M_master_freight->tradingterm_get_fob(); //=========== Versi penambahan FOB utk Marketing

        $data = array(
            'header_title'          => 'Freight Charges',
            'action'                => site_url('master_freight/save'),
            'button'			    => '<i class="fa fa-save"></i> Save',
            'current_date'          => date('d/m/Y'),
            'cbo_container_type'    => $cbo_container_type,
            'cbo_port'              => $cbo_port,
            'cbo_country'           => $cbo_country,

            'cbo_fob'               => $cbo_fob,  //=========== Versi penambahan FOB utk Marketing
            'trading_term_id'       => set_value('trading_term_id'),   //=========== Versi penambahan FOB utk Marketing
            'fob_id'                => set_value('fob_id'),   //=========== Versi penambahan FOB utk Marketing

            'freight_charges_id'    => set_value('freight_charges_id'),
            'container_id'          => set_value('container_id'),
            'container_size'        => set_value('container_size'),

            'port_id'               => set_value('port_id'),
            'country_id'            => set_value('country_id'),
            'vendor_rates'          => set_value('vendor_rates'),
            'cust_rates'            => set_value('cust_rates'),
            'vendor_misc'           => set_value('vendor_misc'),
            'cust_misc'             => set_value('cust_misc'),
            'validity_from'         => set_value('validity_from'),
            'validity_till'         => set_value('validity_till'),
            'vendor_rates2'         => set_value('vendor_rates2'),
            'vendor_rates3'         => set_value('vendor_rates3'),
            'shipping_line1'        => set_value('shipping_line1'),
            'shipping_line2'        => set_value('shipping_line2'),
            'shipping_line3'        => set_value('shipping_line3'),
            'cust_rates2'           => set_value('cust_rates2'),
            'cust_rates3'           => set_value('cust_rates3'),
            'consignee1'            => set_value('consignee1'),
            'consignee2'            => set_value('consignee2'),
            'consignee3'            => set_value('consignee3'),
        );

        $this->template->display('shipping/master_freight/freight_charges/freight_form', $data);

    }

    function edit($freight_charges_id)
    {
        $cbo_container_type = $this->M_master_freight->get_container_type();
        $cbo_port           = $this->M_master_freight->get_port();
        $cbo_country        = $this->M_master_freight->get_country();

        $cbo_fob            = $this->M_master_freight->tradingterm_get_fob(); //=========== Versi penambahan FOB utk Marketing

        $row = $this->M_master_freight->get_by_id($freight_charges_id);

        $data = array(
            'header_title'          => 'Freight Charges',
            'action'                => site_url('master_freight/update'),
            'button'			    => '<i class="fa fa-save"></i> Update',
            'current_date'          => date('d/m/Y'),
            'cbo_container_type'    => $cbo_container_type,
            'cbo_port'              => $cbo_port,
            'cbo_country'           => $cbo_country,

            'cbo_fob'               => $cbo_fob,  //=========== Versi penambahan FOB utk Marketing
            'trading_term_id'       => set_value('trading_term_id'),   //=========== Versi penambahan FOB utk Marketing
            'fob_id'                => set_value('fob_id', $row->shipping_term_id),   //=========== Versi penambahan FOB utk Marketing

            'freight_charges_id'    => set_value('freight_charges_id', $freight_charges_id),
            'container_id'          => set_value('container_id', $row->container_id),
            'container_size'        => set_value('container_size', $row->container_size),

            'port_id'               => set_value('port_id', $row->port_id),
            'country_id'            => set_value('country_id', $row->country_id),
            'vendor_rates'          => set_value('vendor_rates', $row->vendor_rates),
            'cust_rates'            => set_value('cust_rates', $row->cust_rates),
            'vendor_misc'           => set_value('vendor_misc', $row->vendor_misc),
            'cust_misc'             => set_value('cust_misc', $row->cust_misc),
            'validity_from'         => set_value('validity_from', tgl_ind($row->validity_from)),
            'validity_till'         => set_value('validity_till', tgl_ind($row->validity_till)),
            'vendor_rates2'          => set_value('vendor_rates2', $row->vendor_rates2),
            'vendor_rates3'          => set_value('vendor_rates3', $row->vendor_rates3),
            'shipping_line1'          => set_value('shipping_line1', $row->shipping_line1),
            'shipping_line2'          => set_value('shipping_line2', $row->shipping_line2),
            'shipping_line3'          => set_value('shipping_line3', $row->shipping_line3),
            'cust_rates2'          => set_value('cust_rates2', $row->cust_rates2),
            'cust_rates3'          => set_value('cust_rates3', $row->cust_rates3),
            'consignee1'          => set_value('consignee1', $row->consignee1),
            'consignee2'          => set_value('consignee2', $row->consignee2),
            'consignee3'          => set_value('consignee3', $row->consignee3),
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


}
