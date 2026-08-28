<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Shipping_depot extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('userid_1')) {
            redirect('login');
        }

        $this->load->model(array(
            'M_shipping_depot'
        ));

    }

    // BEGIN BARGE CHARGES

    function json()
    {
        header('Content-Type: application/json');
        echo $this->M_shipping_depot->json();
    }

    function index()
    {
        $data = array(
            'message'       => $this->session->flashdata('message'),
        );

        $this->template->display('shipping/Depot/depot_list', $data);
    }

    function add()
    {

        $data = array(
            'header_title'          => 'Depot Master Input',
            'action'                => site_url('shipping_depot/save'),
            'button'                => '<i class="fa fa-save"></i> Save',

            'depot_id'              => '',
            'depot_name'            => '',
            'depot_address'         => '',
        );

        $this->template->display('shipping/Depot/depot_form', $data);

    }

    function edit($barge_charges_id)
    {
        $row = $this->M_shipping_depot->get_by_id($barge_charges_id);

        $data = array(
            'header_title'          => 'Depot Master Edit',
            'action'                => site_url('shipping_depot/update'),
            'button'                => '<i class="fa fa-save"></i> Update',

            'depot_id'              => set_value('depot_id', $row->depot_id),
            'depot_name'            => set_value('depot_name', $row->depot_name),
            'depot_address'         => set_value('depot_address', $row->depot_address)
        );

        $this->template->display('shipping/Depot/depot_form', $data);
    }

    function save()
    {
        $this->db->trans_off();
        $this->db->trans_start();

        $insertid = $this->M_shipping_depot->insert();

        $this->db->trans_complete();

        //generate error
        if ($this->db->trans_status() === FALSE)
        {
            $this->session->set_flashdata('message', pesan('Depot Master Saving Error.', pesan_error()));
        } else {
            $this->session->set_flashdata('message', pesan('Depot Master Succesfully Saved.', pesan_sukses()));
        }

        redirect(site_url('Shipping_depot'));
    }

    function update()
    {
        $this->db->trans_off();
        $this->db->trans_start();

        $this->M_shipping_depot->update();

        $this->db->trans_complete();

        //generate error
        if ($this->db->trans_status() === FALSE)
        {
            $this->session->set_flashdata('message', pesan('Depot Master Update Error.', pesan_error()));
        } else {
            $this->session->set_flashdata('message', pesan('Depot Master Succesfully Update.', pesan_sukses()));
        }

        redirect(site_url('shipping_depot'));
    }

    function delete($id)
    {
        $this->db->trans_off();
        $this->db->trans_start();

        $this->M_shipping_depot->delete($id);

        $this->db->trans_complete();

        //generate error
        if ($this->db->trans_status() === FALSE)
        {
            $this->session->set_flashdata('message', pesan('Depot Master Delete Error.', pesan_error()));
        } else {
            $this->session->set_flashdata('message', pesan('Depot Master Succesfully Deleted.', pesan_sukses()));
        }

        redirect(site_url('Shipping_depot'));

    }

}
