<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Master_freight_new_new extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
		if (!$this->session->userdata('userid_1')) {
            redirect('login');
        }

        $this->load->model(array(
            'M_master_freight_new_new'
        ));
    }

    function index()
    {

        $data['dest']        = $this->M_master_freight_new_new->get_port_destination();
        $data['cont']        = $this->M_master_freight_new_new->get_container_type();
        $data['ship']        = $this->M_master_freight_new_new->tradingterm_get_fob();
        $data['con']         = $this->M_master_freight_new_new->get_consignee();
        $data['freight_hdr'] = $this->M_master_freight_new_new->get_customer_name();
        $data['freight_dtl'] = $this->M_master_freight_new_new->get_data();
        // $data['freight']  = $this->M_master_freight_new_new->tampil_mst_freight();
        $this->template->display('shipping/master_freight/freight_charges_new_new/freight_list', $data);
    }

    function json()
    {
        header('Content-Type: application/json');
        echo $this->M_master_freight_new_new->json();
    }

    function add()
    {
        $cbo_container_type = $this->M_master_freight_new_new->get_container_type();
        $cbo_port           = $this->M_master_freight_new_new->get_port();
        $cbo_country        = $this->M_master_freight_new_new->get_country();
        $cbo_consignee      = $this->M_master_freight_new_new->get_consignee();
        $cbo_shipping_line  = $this->M_master_freight_new_new->get_shipping_line();


        $cbo_fob            = $this->M_master_freight_new_new->tradingterm_get_fob(); //=========== Versi penambahan FOB utk Marketing

        $data = array(
            'header_title'          => 'Freight Charges 3.0',
            'act'                   => set_value('act', 'add'),
            'action'                => site_url('Master_freight_new_new/submit'),
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
            'validity_from'         => set_value('validity_from'),
            'validity_till'         => set_value('validity_till'),
            'comfirm'               => set_value('comfirm',0),

            //tambahan detail eva
            'freight_detail'       =>'',
        );

        $this->template->display('shipping/master_freight/freight_charges_new_new/freight_form', $data);

    }
     function submit() {
        $act = $this->input->post('act');
        if ($act == 'add') {
            $submit_result = $this->M_master_freight_new_new->insert();
            $perintah = 'Saving';
        } else {
        //     echo json_encode($act);
        // die;
            $submit_result = $this->M_master_freight_new_new->update();
            $perintah = 'Updating';
        }

         if ($submit_result > 0) {
            $hdr        = $this->M_master_freight_new_new->get_freight_hdr($submit_result);
           // $edit_link  = site_url('Master_freight_new_new/edit/?id='.$hdr->freight_charges_id);
            //$this->session->set_flashdata('message',pesan($perintah.' Master Freight <strong>'.$hdr->freight_charges_id.'</strong>', pesan_sukses(), $edit_link));
            $this->session->set_flashdata('message',pesan($perintah.' Master Freight <strong>', pesan_sukses()));
            // $this->session->set_flashdata('message', pesan($perintah.' Master Freight <strong>', pesan_sukses()));
            // redirect(site_url('Master_freight_new_new'));
            // redirect(site_url('Master_freight_new_new/edit/?id='.encode_str($hdr->freight_charges_id)));
             redirect(site_url('Master_freight_new_new/edit/?id='.$hdr->freight_charges_id));
         } else {
            $this->session->set_flashdata('message', pesan('FAILED', pesan_error())); 
            redirect(site_url('Master_freight_new_new'));
        }
         
    }

    function edit(){
        
        $id                 = $this->input->get('id');
        $cbo_container_type = $this->M_master_freight_new_new->get_container_type();
        $cbo_port           = $this->M_master_freight_new_new->get_port();
        $cbo_country        = $this->M_master_freight_new_new->get_country();
        $cbo_consignee      = $this->M_master_freight_new_new->get_consignee();
        $cbo_shipping_line  = $this->M_master_freight_new_new->get_shipping_line();
        $cbo_fob            = $this->M_master_freight_new_new->tradingterm_get_fob(); //=========== Versi penambahan FOB utk Marketing
       
        $hdr                = $this->M_master_freight_new_new->get_freight_hdr($id);
        $freight_detail     = $this->M_master_freight_new_new->get_freight_dtl($id);

        $data = array(
            'header_title'          => 'Freight Charges',
            'button'                => '<i class="fa fa-save"></i> Update',
            'action'                => site_url('Master_freight_new_new/submit'),
            'act'                   => set_value('act', 'edit', true),
            'cbo_container_type'    => $cbo_container_type,
            'cbo_port'              => $cbo_port,
            'cbo_country'           => $cbo_country,
            'cbo_consignee'         => $cbo_consignee,
            'cbo_shipping_line'     => $cbo_shipping_line,
            'cbo_fob'               => $cbo_fob,
            'current_date'          => date('d/m/Y'),
            'freight_charges_id'    => set_value('freight_charges_id', $hdr->freight_charges_id),
            'freight_charges_id2'   => set_value('freight_charges_id2', $hdr->id_cif_cfr),
            'consignee'             => set_value('consignee', $hdr->consignee),
            'container_size'        => set_value('container_size', $hdr->container_size),
            'container_id'          => set_value('container_id', $hdr->container_id),
            'port_id'               => set_value('port_id', $hdr->port_id),
            'country_id'            => set_value('country_id', $hdr->country_id),
            'fob_id'                => set_value('fob_id', $hdr->shipping_term_id),
            'validity_from'         => set_value('validity_from', tgl_ind($hdr->validity_from)),
            'validity_till'         => set_value('validity_till', tgl_ind($hdr->validity_till)),
            'comfirm'               => set_value('comfirm', $hdr->comfirm),
            'freight_detail'        => $freight_detail

        );
        $this->template->display('shipping/master_freight/freight_charges_new_new/freight_form', $data);
    }
    
    function remove()
    {
        //$this->input->get('id');
        $this->M_master_freight_new_new->remove_detail();
    }

    function delete($id){
       $row = $this->M_master_freight_new_new->freight_get_by_id($id);

        if ($row) {
            $this->M_master_freight_new_new->freight_delete($id);
            $this->M_master_freight_new_new->freight_dtl_delete($id);
            $this->session->set_flashdata('message', pesan('Delete Record Success', pesan_sukses()));
            redirect(site_url('Master_freight_new_new'));
        } else {
            $this->session->set_flashdata('message', pesan('Record Not Found', pesan_peringatan()));
            redirect(site_url('Master_freight_new_new'));
        }

    }
        function container_stock_filter(){
        $dest = $this->input->get('dest');
        $cont = $this->input->get('cont');
        $ship = $this->input->get('ship');
        $con  = $this->input->get('con');

        $data['freight']=$this->M_master_freight_new_new->filter_freight($dest,$cont,$ship,$con);
        $this->load->view('shipping/master_freight/freight_charges_new_new/freight_filter',$data);
    }

 
}
