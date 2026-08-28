<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Shipping_trucking extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('userid_1')) {
            redirect('login');
        }

        $this->load->model(array(
            'M_shipping_trucking'
        ));

    }

    // BEGIN BARGE CHARGES

    function json()
    {
        header('Content-Type: application/json');
        echo $this->M_shipping_trucking->json();
    }

    function index()
    {
        $data = array(
            'message'       => $this->session->flashdata('message'),
        );

        $this->template->display('shipping/shipping_trucking/trucking/barge_list', $data);
    }

    function add()
    {
        //$cbo_container_type = $this->M_shipping_trucking->get_container_type();

        $data = array(
            'header_title'          => 'Truck Charges Input',
            'action'                => site_url('shipping_trucking/save'),
            'button'                => '<i class="fa fa-save"></i> Save',
            'current_date'          => date('d/m/Y'),
        //    'cbo_container_type'    => $cbo_container_type,

            'trucking_id'      => '',
            'container_size'        => '',
            'validity_from'         => '',
            'validity_until'         => '',

            'vendor_trucking_price'         => set_value('vendor_trucking_price'),
            'cust_trucking_price'           => set_value('cust_trucking_price'),
        );

        $this->template->display('shipping/shipping_trucking/trucking/barge_form', $data);

    }

    function edit($barge_charges_id)
    {
        //$cbo_container_type = $this->M_shipping_trucking->get_container_type();

        $row = $this->M_shipping_trucking->get_by_id($barge_charges_id);

        $data = array(
            'header_title'          => 'Truck Charges Edit',
            'action'                => site_url('shipping_trucking/update'),
            'button'                => '<i class="fa fa-save"></i> Update',
            'current_date'          => date('d/m/Y'),
            //'cbo_container_type'    => $cbo_container_type,

            'trucking_id'           => set_value('trucking_id', $barge_charges_id),
            'container_size'        => set_value('container_size', $row->container_size),
            'validity_from'         => set_value('validity_from', tgl_ind($row->validity_from)),
            'validity_until'        => set_value('validity_until', tgl_ind($row->validity_until)),

            'vendor_trucking_price'           => set_value('vendor_trucking_price', $row->vendor_trucking_price),
            'cust_trucking_price'             => set_value('cust_trucking_price', $row->cust_trucking_price),
        );

        $this->template->display('shipping/shipping_trucking/trucking/barge_form', $data);
    }

    function save()
    {
        $this->db->trans_off();
        $this->db->trans_start();

        $insertid = $this->M_shipping_trucking->insert();

        $this->db->trans_complete();

        //generate error
        if ($this->db->trans_status() === FALSE)
        {
            $this->session->set_flashdata('message', pesan('Trucking Price Saving Error.', pesan_error()));
        } else {
            $this->session->set_flashdata('message', pesan('Trucking Price Succesfully Saved.', pesan_sukses()));
        }

        redirect(site_url('Shipping_trucking'));
    }

    function update()
    {
        $this->db->trans_off();
        $this->db->trans_start();

        $this->M_shipping_trucking->update();

        $this->db->trans_complete();

        //generate error
        if ($this->db->trans_status() === FALSE)
        {
            $this->session->set_flashdata('message', pesan('Trucking Price Update Error.', pesan_error()));
        } else {
            $this->session->set_flashdata('message', pesan('Trucking Price Succesfully Update.', pesan_sukses()));
        }

        redirect(site_url('shipping_trucking'));
    }

    function delete($id)
    {
        $this->db->trans_off();
        $this->db->trans_start();

        $this->M_shipping_trucking->delete($id);

        $this->db->trans_complete();

        //generate error
        if ($this->db->trans_status() === FALSE)
        {
            $this->session->set_flashdata('message', pesan('Trucking Price Delete Error.', pesan_error()));
        } else {
            $this->session->set_flashdata('message', pesan('Trucking Price Succesfully Deleted.', pesan_sukses()));
        }

        redirect(site_url('Shipping_trucking'));

    }

    // =================================== TRUCKING GGFS ===============================================
    function index_ggfs()
    {
        $data = array(
            'message'       => $this->session->flashdata('message'),
        );

        $this->template->display('shipping/shipping_trucking/trucking_ggfs/barge_list', $data);
    }

    function json_ggfs()
    {
        header('Content-Type: application/json');
        echo $this->M_shipping_trucking->json_ggfs();
    }

    function add_ggfs()
    {
        $data = array(
            'header_title'          => 'Truck Charges Input GGFS',
            'action'                => site_url('shipping_trucking/save_ggfs'),
            'button'                => '<i class="fa fa-save"></i> Save',
            'current_date'          => date('d/m/Y'),

            'trucking_id'      => '',
            'container_size'        => '',
            'validity_from'         => '',
            'validity_until'         => '',

            'vendor_trucking_price'         => set_value('vendor_trucking_price'),
            'cust_trucking_price'           => set_value('cust_trucking_price'),
        );

        $this->template->display('shipping/shipping_trucking/trucking_ggfs/barge_form', $data);

    }

    function save_ggfs()
    {
        $this->db->trans_off();
        $this->db->trans_start();

        $insertid = $this->M_shipping_trucking->insert_ggfs();

        $this->db->trans_complete();

        //generate error
        if ($this->db->trans_status() === FALSE)
        {
            $this->session->set_flashdata('message', pesan('Trucking GGFS Price Saving Error.', pesan_error()));
        } else {
            $this->session->set_flashdata('message', pesan('Trucking GGFS Price Succesfully Saved.', pesan_sukses()));
        }

        redirect(site_url('Shipping_trucking/index_ggfs'));
    }

    function edit_ggfs($barge_charges_id)
    {
        $row = $this->M_shipping_trucking->get_by_id_ggfs($barge_charges_id);

        $data = array(
            'header_title'          => 'Truck Charges Edit',
            'action'                => site_url('shipping_trucking/update_ggfs'),
            'button'                => '<i class="fa fa-save"></i> Update GGFS',
            'current_date'          => date('d/m/Y'),
            //'cbo_container_type'    => $cbo_container_type,

            'trucking_id'           => set_value('trucking_id', $barge_charges_id),
            'container_size'        => set_value('container_size', $row->container_size),
            'validity_from'         => set_value('validity_from', tgl_ind($row->validity_from)),
            'validity_until'        => set_value('validity_until', tgl_ind($row->validity_until)),

            'vendor_trucking_price'           => set_value('vendor_trucking_price', $row->vendor_trucking_price),
            'cust_trucking_price'             => set_value('cust_trucking_price', $row->cust_trucking_price),
        );

        $this->template->display('shipping/shipping_trucking/trucking_ggfs/barge_form', $data);
    }

    function update_ggfs()
    {
        $this->db->trans_off();
        $this->db->trans_start();

        $this->M_shipping_trucking->update_ggfs();

        $this->db->trans_complete();

        //generate error
        if ($this->db->trans_status() === FALSE)
        {
            $this->session->set_flashdata('message', pesan('Trucking Price Update Error.', pesan_error()));
        } else {
            $this->session->set_flashdata('message', pesan('Trucking Price Succesfully Update.', pesan_sukses()));
        }

        redirect(site_url('shipping_trucking/index_ggfs'));
    }

    function delete_ggfs($id)
    {
        $this->db->trans_off();
        $this->db->trans_start();

        $this->M_shipping_trucking->delete_ggfs($id);

        $this->db->trans_complete();

        //generate error
        if ($this->db->trans_status() === FALSE)
        {
            $this->session->set_flashdata('message', pesan('Trucking Price Delete Error.', pesan_error()));
        } else {
            $this->session->set_flashdata('message', pesan('Trucking Price Succesfully Deleted.', pesan_sukses()));
        }

        redirect(site_url('Shipping_trucking/index_ggfs'));

    }

}
