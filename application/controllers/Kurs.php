<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Kurs extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('M_Kurs');
        $this->load->library('form_validation');
    }

    function index() {
        $get_all = $this->M_Kurs->get_all_acc();
        $get_kurs = $this->M_Kurs->get_kurs();

        $data = array(
            'currency_data' => $get_all,
            'kurs' => $get_kurs
        );
        $data['message'] = $this->session->flashdata('message');
        $this->template->display('accounting/kurs/list', $data);
    }

    function currency() {
        $this->index('currency');
    }

    function create_master($nama_master) {
        switch ($nama_master) {
            case 'kurs':
                $this->do_create_kurs();
                break;

            default:
                break;
        }
    }

    function edit_kurs() {
        $id = $this->input->get('id');
        $row = $this->M_Kurs->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('Kurs/update_kurs'),
                'header_title' => 'Kurs of the week - Edit',
                'detail_id' => set_value('currency_id', $row->detail_id),
                'currency_name' => set_value('currency_name', $row->currency_name),
                'currency_id' => set_value('currency_symbol', $row->currency_id),
                'rate_kurs' => set_value('rate_kurs', $row->rate_kurs),
                'rate_usd' => set_value('rate_kurs', $row->rate_usd),
                'periode' => set_value('periode', $row->periode)
            );
            $this->template->display('accounting/kurs/form', $data);
        } else {
            $this->session->set_flashdata('message', pesan('Record Not Found', pesan_peringatan()));
            redirect(site_url('Kurs'));
        }
    }

    function delete($id) {
        $row = $this->M_Kurs->get_by_id($id);

        if ($row) {
            $this->M_Kurs->delete($id);
            $this->session->set_flashdata('message', pesan('Delete Record Success', pesan_sukses()));
            redirect(site_url('Kurs'));
        } else {
            $this->session->set_flashdata('message', pesan('Record Not Found', pesan_peringatan()));
            redirect(site_url('Kurs'));
        }
    }

    function do_create_kurs() {
        $data = array(
            'button' => 'Save',
            'action' => site_url('Kurs/save_kurs'),
            'header_title' => 'Kurs Of the Week - Create New',
            'detail_id' => set_value('currency_id'),
            'currency_name' => set_value('currency_name'),
            'currency_id' => set_value('currency_symbol'),
            'rate_kurs' => set_value('rate_kurs'),
            'rate_usd' => set_value('rate_usd'),
            'periode' => set_value('periode'),
        );
        $this->template->display('accounting/kurs/form', $data);
    }

    function save_kurs() {
        $tgl_jurnal = str_replace('/', '-', $this->input->post('periode'));
        $periode = date('Y-m-d', strtotime($tgl_jurnal));
        $currency_name = $this->input->post('currency_name');
        $txtKurs = $this->input->post('txtKurs');
        $txtKursUSD = $this->input->post('txtKursUSD');
        $currency_symbol = $this->input->post('currency_simbol');

        if ($txtKurs == 0) {
            $this->session->set_flashdata('message', pesan('Create Record Failed. Rate cannot Zero.', pesan_error()));
            redirect(site_url('kurs'));
        } else {
            for ($i = 0; $i < count($this->input->post('currency_name')); $i++) {
                $data = array(
                    'currency_name' => $currency_name[$i],
                    'rate_kurs' => $txtKurs[$i],
                    'rate_usd' => $txtKursUSD[$i],
                    'periode' => $periode,
                    'currency_id' => $currency_symbol[$i],
                    'created_by' => strtoupper($this->session->userdata('userid_1')),
                    'created_date' => date('Y-m-d H:i:s')
                );
                $this->M_Kurs->insert($data);

                $update_kurs = array(
                    'rate' => $txtKurs[$i],
                    'rate_usd' => $txtKursUSD[$i],
                    'periode' => $periode);
                $this->M_Kurs->update_kurs($currency_symbol[$i], $update_kurs);
            }
            $this->session->set_flashdata('message', pesan('Create Record Success', pesan_sukses()));
            redirect(site_url('kurs'));
        }
    }

    function update_kurs() {
        $this->_rules_currency();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('currency_id', TRUE));
        } else {
            $data = array(
                'currency_name' => $this->input->post('currency_name', TRUE),
                'currency_id' => $this->input->post('currency_symbol', TRUE),
                'rate_kurs' => $this->input->post('rate', TRUE),
                'rate_usd' => $this->input->post('rate_usd', TRUE),
                'periode' => $this->input->post('periode', TRUE),
                'updated_by' => strtoupper($this->session->userdata('userid_1')),
                'updated_date' => date('Y-m-d H:i:s')
            );

            $update_kurs = array(
                'rate' => $this->input->post('rate', TRUE),
                'rate_usd' => $this->input->post('rate_usd', TRUE),
                'periode' => $this->input->post('periode', TRUE));
            $this->M_Kurs->update_kurs($this->input->post('currency_symbol', TRUE), $update_kurs);

            $this->M_Kurs->update($this->input->post('currency_id', TRUE), $data);
            $this->session->set_flashdata('message', pesan('Update Record Success', pesan_sukses()));
            redirect(site_url('kurs'));
        }
    }

    function _rules_currency() {
        $this->form_validation->set_rules('currency_id', 'currency id', 'trim|required');
        $this->form_validation->set_rules('currency_name', 'currency name', 'trim|required');
        $this->form_validation->set_rules('currency_symbol', 'currency symbol', 'trim|required');
        $this->form_validation->set_rules('rate', 'currency rate', 'trim|required');

        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}
