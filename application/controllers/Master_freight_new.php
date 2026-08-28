<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Master_freight_new extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
		if (!$this->session->userdata('userid_1')) {
            redirect('login');
        }

        $this->load->model(array(
            'M_master_freight_new'
        ));
    }

    function index()
    {
        $data['dest']       = $this->M_master_freight_new->get_port_destination();
        $data['cont']       = $this->M_master_freight_new->get_container_type();
        $data['ship']       = $this->M_master_freight_new->tradingterm_get_fob();
        $data['con']        = $this->M_master_freight_new->get_consignee();
        $data['freight']    = $this->M_master_freight_new->tampil_mst_freight();
        $this->template->display('shipping/master_freight/freight_charges_new/freight_list', $data);
    }

    function json()
    {
        header('Content-Type: application/json');
        echo $this->M_master_freight_new->json();
    }

    function add()
    {
        $cbo_container_type = $this->M_master_freight_new->get_container_type();
        $cbo_port           = $this->M_master_freight_new->get_port();
        $cbo_country        = $this->M_master_freight_new->get_country();
        $cbo_consignee      = $this->M_master_freight_new->get_consignee();
        $cbo_shipping_line  = $this->M_master_freight_new->get_shipping_line();


        $cbo_fob            = $this->M_master_freight_new->tradingterm_get_fob(); //=========== Versi penambahan FOB utk Marketing

        $data = array(
            'header_title'          => 'Freight Charges',
            'action'                => site_url('master_freight_new/save'),
            'button'			    => '<i class="fa fa-save"></i> Save',
            'current_date'          => date('d/m/Y'),
            'cbo_container_type'    => $cbo_container_type,
            'cbo_port'              => $cbo_port,
            'cbo_country'           => $cbo_country,
            'cbo_consignee'         => $cbo_consignee, //====== Tambahan filter price pada Marketing
            'cbo_shipping_line'     => $cbo_shipping_line,

            'cbo_fob'               => $cbo_fob,  //=========== Versi penambahan FOB utk Marketing
            'trading_term_id'       => set_value('trading_term_id'),   //=========== Versi penambahan FOB utk Marketing
            'fob_id'                => set_value('fob_id'),   //=========== Versi penambahan FOB utk Marketing

            'freight_charges_id'    => set_value('freight_charges_id'),
            'freight_charges_id2'   => set_value('freight_charges_id2'),
            'container_id'          => set_value('container_id'),
            'container_size'        => set_value('container_size'),

            'port_id'               => set_value('port_id'),
            'country_id'            => set_value('country_id'),
            'consignee'             => set_value('consignee'),
            'shipping_line'         => set_value('shipping_line'),
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
            'comfirm'               => set_value('comfirm',0)
        );

        $this->template->display('shipping/master_freight/freight_charges_new/freight_form', $data);

    }

    function edit($freight_charges_id)
    {
        $cbo_container_type = $this->M_master_freight_new->get_container_type();
        $cbo_port           = $this->M_master_freight_new->get_port();
        $cbo_country        = $this->M_master_freight_new->get_country();
        $cbo_consignee      = $this->M_master_freight_new->get_consignee();
        $cbo_shipping_line  = $this->M_master_freight_new->get_shipping_line();

        $cbo_fob            = $this->M_master_freight_new->tradingterm_get_fob(); //=========== Versi penambahan FOB utk Marketing

        $row = $this->M_master_freight_new->get_by_id($freight_charges_id);

        $data = array(
            'header_title'          => 'Freight Charges',
            'action'                => site_url('master_freight_new/update'),
            'button'			    => '<i class="fa fa-save"></i> Update',
            'current_date'          => date('d/m/Y'),
            'cbo_container_type'    => $cbo_container_type,
            'cbo_port'              => $cbo_port,
            'cbo_country'           => $cbo_country,
            'cbo_consignee'         => $cbo_consignee,
            'cbo_shipping_line'     => $cbo_shipping_line,

            'cbo_fob'               => $cbo_fob,  //=========== Versi penambahan FOB utk Marketing
            'trading_term_id'       => set_value('trading_term_id'),   //=========== Versi penambahan FOB utk Marketing
            'fob_id'                => set_value('fob_id', $row->shipping_term_id),   //=========== Versi penambahan FOB utk Marketing

            'freight_charges_id'    => set_value('freight_charges_id', $freight_charges_id),
            'freight_charges_id2'   => set_value('freight_charges_id2', $row->id_cif_cfr),
            'container_id'          => set_value('container_id', $row->container_id),
            'container_size'        => set_value('container_size', $row->container_size),

            'port_id'               => set_value('port_id', $row->port_id),
            'country_id'            => set_value('country_id', $row->country_id),
            'consignee'             => set_value('consignee', $row->consignee),
            'shipping_line'         => set_value('shipping_line', $row->shipping_line),
            'vendor_rates'          => set_value('vendor_rates', $row->vendor_rates),
            'cust_rates'            => set_value('cust_rates', $row->cust_rates),
            'vendor_misc'           => set_value('vendor_misc', $row->vendor_misc),
            'cust_misc'             => set_value('cust_misc', $row->cust_misc),
            'validity_from'         => set_value('validity_from', tgl_ind($row->validity_from)),
            'validity_till'         => set_value('validity_till', tgl_ind($row->validity_till)),
            'vendor_rates2'         => set_value('vendor_rates2', $row->vendor_rates2),
            'vendor_rates3'         => set_value('vendor_rates3', $row->vendor_rates3),
            'shipping_line1'        => set_value('shipping_line1', $row->shipping_line1),
            'shipping_line2'        => set_value('shipping_line2', $row->shipping_line2),
            'shipping_line3'        => set_value('shipping_line3', $row->shipping_line3),
            'cust_rates2'           => set_value('cust_rates2', $row->cust_rates2),
            'cust_rates3'           => set_value('cust_rates3', $row->cust_rates3),
            'consignee1'            => set_value('consignee1', $row->consignee1),
            'consignee2'            => set_value('consignee2', $row->consignee2),
            'consignee3'            => set_value('consignee3', $row->consignee3),
            'comfirm'               => set_value('comfirm', $row->comfirm),
        );

        $this->template->display('shipping/master_freight/freight_charges_new/freight_form', $data);

    }

    function save()
    {
        $this->db->trans_off();
		$this->db->trans_start();

		$insertid = $this->M_master_freight_new->insert();

		$this->db->trans_complete();

		//generate error
		if ($this->db->trans_status() === FALSE)
		{
			$this->session->set_flashdata('message', pesan('Freight Charge Saving Error.', pesan_error()));
		} else {
			$this->session->set_flashdata('message', pesan('Freight Charge Succesfully Saved.', pesan_sukses()));
		}

        if($insertid != ''){
        $this->session->set_flashdata('message', pesan('Freight Charge Succesfully Saved.', pesan_sukses()));        
        redirect(site_url('master-freight-new/edit/'.$insertid));
        }else{
        $this->session->set_flashdata('message', pesan('Freight Charge Saving Error.', pesan_error()));        
        redirect(site_url('master-freight-new/add/'));            
        }
    }

    function update()
    {
        $id = $this->input->post('freight_charges_id');
        $this->db->trans_off();
		$this->db->trans_start();

		$this->M_master_freight_new->update();

		$this->db->trans_complete();

		//generate error
		if ($this->db->trans_status() === FALSE)
		{
			$this->session->set_flashdata('message', pesan('Freight Charge Update Error.', pesan_error()));
		} else {
			$this->session->set_flashdata('message', pesan('Freight Charge Succesfully Updated.', pesan_sukses()));
		}

        redirect(site_url('master-freight-new/edit/'.$id));
    }

    function delete($id)
    {
        $this->db->trans_off();
		$this->db->trans_start();

		$this->M_master_freight_new->delete($id);

		$this->db->trans_complete();

		//generate error
		if ($this->db->trans_status() === FALSE)
		{
			$this->session->set_flashdata('message', pesan('Freight Charge Delete Error.', pesan_error()));
		} else {
			$this->session->set_flashdata('message', pesan('Freight Charge Succesfully Deleted.', pesan_sukses()));
		}

        redirect(site_url('master-freight-new'));
    }

    function ajax_country_by_port()
    {
        $port_id        = $this->input->post('port_id');
        $cbo_country    = $this->M_master_freight_new->get_country();
        $row            = $this->M_master_freight_new->get_port_by_id($port_id);

        $data = array(
            'cbo_country'     => $cbo_country,
            'country_id'      => $row->country_id,
        );

        $this->load->view('shipping/master_freight/freight_charges_new/combo_country', $data);
    }

    function container_stock_filter(){
        $dest = $this->input->get('dest');
        $cont = $this->input->get('cont');
        $ship = $this->input->get('ship');
        $con  = $this->input->get('con');

        $data['freight']=$this->M_master_freight_new->filter_freight($dest,$cont,$ship,$con);
        $this->load->view('shipping/master_freight/freight_charges_new/freight_filter',$data);
    }

    function get_new_save(){
        $data['action']               = site_url('master_freight_new/save_new');
        $data['container_type']       = $this->input->post('container_type');
        $data['container_id']         = $this->input->post('container_id');
        $data['container_size']       = $this->input->post('container_size');
        $data['freight_charges_id']   = $this->input->post('freight_charges_id');
        $data['port_id']              = $this->input->post('port_id');
        $data['country_id']           = $this->input->post('country_id');
        $data['fob_id']               = $this->input->post('fob_id');
        $data['validity_from']        = $this->input->post('validity_from');
        $data['current_date']         = date('d-m-Y');
        $data['validity_till']        = $this->input->post('validity_till');
        $data['shipping_line']        = $this->input->post('shipping_line');
        $data['vendor_rates']         = $this->input->post('vendor_rates');
        $data['vendor_rates2']        = $this->input->post('vendor_rates2');
        $data['vendor_rates3']        = $this->input->post('vendor_rates3');
        $data['shipping_line1']       = $this->input->post('shipping_line1');
        $data['shipping_line2']       = $this->input->post('shipping_line2');
        $data['shipping_line3']       = $this->input->post('shipping_line3');
        $data['vendor_misc']          = $this->input->post('vendor_misc');
        $data['consignee']            = $this->input->post('consignee');
        $data['cust_rates']           = $this->input->post('cust_rates');
        $data['cust_misc']            = $this->input->post('cust_misc');
        $data['comfirm_yes']          = $this->input->post('comfirm_yes');
        $data['comfirm_no']           = $this->input->post('comfirm_no');


        $data['cbo_container_type'] = $this->M_master_freight_new->get_container_type();
        $data['cbo_port']           = $this->M_master_freight_new->get_port();
        $data['cbo_country']        = $this->M_master_freight_new->get_country();
        $data['cbo_consignee']      = $this->M_master_freight_new->get_consignee();
        $data['cbo_shipping_line']  = $this->M_master_freight_new->get_shipping_line();
        $data['cbo_fob']            = $this->M_master_freight_new->tradingterm_get_fob();

        $this->load->view('shipping/master_freight/freight_charges_new/freight_form_new_save',$data);        
    }

    function save_new()
    {
        $this->db->trans_off();
        $this->db->trans_start();

        $insertid = $this->M_master_freight_new->insert();
        $id_old   = $this->input->post('freight_charges_id');

        $this->db->trans_complete();

        //generate error
        if ($this->db->trans_status() === FALSE)
        {
            $this->session->set_flashdata('message', pesan('Freight Charge Saving Error.', pesan_error()));
        } else {
            $this->session->set_flashdata('message', pesan('Freight Charge Succesfully Saved.', pesan_sukses()));
        }

        if($insertid != ''){
        $this->session->set_flashdata('message', pesan('Freight Charge Succesfully Saved.', pesan_sukses()));        
        redirect(site_url('master-freight-new/edit/'.$insertid));
        }else{
        $this->session->set_flashdata('message', pesan('Freight Charge As New Saving Error.', pesan_error()));        
        redirect(site_url('master-freight-new/edit/'.$id_old));            
        }
    }
}
