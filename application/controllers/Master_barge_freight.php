<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Master_barge_freight extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('userid_1')) {
            redirect('login');
        }

        $this->load->model(array(
            'M_master_barge_freight' => 'barge_freight_model'
        ));
    }

    function index()
    {
        $data_hdr = $this->barge_freight_model->get_hdr();
        $container   = $this->barge_freight_model->container();
        $destination = $this->barge_freight_model->destination();
        $con_type    = $this->barge_freight_model->container_type();
        $data = [
            'header_title' => 'List Freight Charges',
            'data_hdr'     => $data_hdr,
            'container'    => $container,
            'destination'  => $destination,
            'con_type'     => $con_type,
        ];
        $this->template->display('shipping/master_freight/barge_freight/barge_freight_list', $data);
    }

    function add()
    {
        $container   = $this->barge_freight_model->container();
        $destination = $this->barge_freight_model->destination();
        $con_type    = $this->barge_freight_model->container_type();
        $list_desc   = $this->barge_freight_model->list_desc();

        $data = array(
            'header_title' => 'Add Barge Freight Charges',
            'btn_value'    => 'insert',
            'btn_name'     => 'Save',
            'action'       => site_url('Master_barge_freight/submit'),
            'container'    => $container,
            'destination'  => $destination,
            'con_type'     => $con_type,
            'list_desc'     => $list_desc,
        );

        $this->template->display('shipping/master_freight/barge_freight/barge_freight_form', $data);
    }

    function edit($id)
    {
        $container     = $this->barge_freight_model->container();
        $destination   = $this->barge_freight_model->destination();
        $con_type      = $this->barge_freight_model->container_type();
        $list_desc   = $this->barge_freight_model->list_desc();

        $hdr = $this->barge_freight_model->find_hdr($id);
        $data_dtl = $this->barge_freight_model->get_dtl($hdr->barge_freight_hdr_id);

        $data = array(
            'header_title' => 'Edit Freight Charges',
            'btn_value'    => 'update',
            'btn_name'     => 'Update',
            'action'       => site_url('Master_barge_freight/submit/' . $hdr->barge_freight_hdr_id),
            'container'    => $container,
            'destination'  => $destination,
            'con_type'     => $con_type,
            'list_desc'     => $list_desc,
            'hdr'          => $hdr,
            'data_dtl'     => $data_dtl,
        );
        $this->template->display('shipping/master_freight/barge_freight/barge_freight_form', $data);
    }

    function submit($id = null)
    {
        $inputan = $this->input->post(null);

        switch ($inputan['btn_submit']) {
            case 'insert':
                array_pop($inputan);
                $this->_save($inputan);
                break;
            case 'update':
                array_pop($inputan);
                $this->_update($inputan, $id);
                break;
            default:
                # code...
                break;
        }
    }

    function delete($id)
    {
        $deleted_by =  $this->session->userdata('namalengkap_1');
        $field = [
            'deleted_at' => date('Y-m-d'),
            'deleted_by' => $deleted_by
        ];

        $delete = $this->barge_freight_model->update($field, $id);
        if ($delete) {
            $this->session->set_flashdata('message', pesan('Delete data success', pesan_sukses()));
            redirect(site_url('Master_barge_freight'));
        } else {
            $this->session->set_flashdata('message', pesan('Delete data Failed', pesan_error()));
            redirect(site_url('Master_barge_freight'));
        }
    }

    private function _save($inputan)
    {
        $created_by =  $this->session->userdata('namalengkap_1');
        $created_at =  date('Y-m-d');

        $inputan_hdr = [
            'destination_id'        => $inputan['destination_id'],
            'container_id'          => $inputan['container_id'],
            'con_type_id'           => $inputan['con_type_id'],
            'created_at'            => $created_at,
            'created_by'            => $created_by,
            'destination_type_id'   => $inputan['destination_type_id'],
            'destination_type_name' => $inputan['destination_type_name'],
        ];

        $this->barge_freight_model->insert($inputan_hdr);
        $header_id = $this->db->insert_id();

        $inputan_dtl = [];
        for ($i = 0; $i < count($inputan['desc_nama']); $i++) {
            $inputan_dtl[] = [
                'desc_nama'            => $inputan['desc_nama'][$i],
                'unit_price'           => $inputan['unit_price'][$i],
                'freight_per_mt'       => $inputan['freight_per_mt'][$i],
                'barge_freight_hdr_id' => $header_id,
                'desc_list_id'         => $inputan['desc_list_id'][$i],
            ];
        }

        $this->barge_freight_model->insert_batch_dtl($inputan_dtl);

        $this->session->set_flashdata('message', pesan('Add data success', pesan_sukses()));
        redirect(site_url('Master_barge_freight'));
    }

    function _update($inputan, $id)
    {

        $updated_by =  $this->session->userdata('namalengkap_1');
        $updated_at =  $this->session->userdata('namalengkap_1');

        $inputan_hdr = [
            'destination_id'        => $inputan['destination_id'],
            'container_id'          => $inputan['container_id'],
            'con_type_id'           => $inputan['con_type_id'],
            'updated_at'            => $updated_at,
            'updated_by'            => $updated_by,
            'destination_type_id'   => $inputan['destination_type_id'],
            'destination_type_name' => $inputan['destination_type_name'],
        ];

        $this->barge_freight_model->update_hdr($inputan_hdr);

        $inputan_dtl_update = [];
        $inputan_dtl_insert = [];
        for ($i = 0; $i < count($inputan['desc_nama']); $i++) {
            if (isset($inputan['barge_freight_dtl_id'][$i])) {
                $inputan_dtl_update[] = [
                    'barge_freight_dtl_id' => $inputan['barge_freight_dtl_id'][$i],
                    'desc_nama'            => $inputan['desc_nama'][$i],
                    'unit_price'           => $inputan['unit_price'][$i],
                    'freight_per_mt'       => $inputan['freight_per_mt'][$i],
                    'desc_list_id'         => $inputan['desc_list_id'][$i],
                ];
            } else {
                $inputan_dtl_insert[] = [
                    'desc_nama'            => $inputan['desc_nama'][$i],
                    'unit_price'           => $inputan['unit_price'][$i],
                    'freight_per_mt'       => $inputan['freight_per_mt'][$i],
                    'barge_freight_hdr_id' => $id,
                    'desc_list_id'         => $inputan['desc_list_id'][$i],
                ];
            }
        }

        if ($inputan_dtl_update) {
            $this->barge_freight_model->update_batch_dtl($inputan_dtl_update);
        }

        if ($inputan_dtl_insert) {
            $this->barge_freight_model->insert_batch_dtl($inputan_dtl_insert);
        }

        $this->session->set_flashdata('message', pesan('Update data success', pesan_sukses()));
        redirect(site_url('Master_barge_freight'));
    }

    public function remove()
    {
        $id = $this->input->post('id');
        $this->barge_freight_model->remove_detail($id);
    }

    public function delete_dtl($id)
    {
        $this->barge_freight_model->remove_detail($id);
        $this->session->set_flashdata('message', pesan('Delete data success', pesan_sukses()));
        redirect(site_url('Master_barge_freight'));
    }

    function filter_barge_freight()
    {
        $dest = $this->input->get('dest');
        $cont = $this->input->get('cont');
        $type = $this->input->get('type');

        $data['data_hdr'] = $this->barge_freight_model->filter_freight($dest, $cont, $type);
        $this->load->view('shipping/master_freight/barge_freight/filter_freight', $data);
    }
}
