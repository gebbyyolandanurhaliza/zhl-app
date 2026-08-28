<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Closing_rate extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('M_Closing_rate');
        $this->load->library('form_validation');
    }

    function index() {
        $get_all = $this->M_Closing_rate->get_all_acc();
        $get_kurs = $this->M_Closing_rate->get_kurs();
        $periode = $this->session->userdata('periode_1');

        $cur = $this->M_Closing_rate->get_curid();
        $period = $this->M_Closing_rate->get_closing_period();
        $count = $this->M_Closing_rate->count_curid();

        $str = explode("/", $periode);
        $get_currency = $this->M_Closing_rate->get_currency('2016', '06');

        $data = array(
            'currency_data' => $get_all,
            'kurs' => $get_kurs,
            'get_currency' => $get_currency,
            '_cur' => $cur,
            '_period' => $period,
            '_count' => $count,
        );
        $data['message'] = $this->session->flashdata('message');
        $this->template->display('accounting/Closing_rate', $data);
    }

    function currency() {
        $this->index('currency');
    }

    function delete($id) {
        $row = $this->M_Closing_rate->get_by_id($id);

        if ($row) {
            $this->M_Closing_rate->delete($id);
            $this->session->set_flashdata('message', pesan('Delete Record Success', pesan_sukses()));
            redirect(site_url('Closing_rate'));
        } else {
            $this->session->set_flashdata('message', pesan('Record Not Found', pesan_peringatan()));
            redirect(site_url('Closing_rate'));
        }
    }

    function save_rate() {
        $periode = $this->input->post('periode');
        $currency_name = $this->input->post('currency_name');
        $txtKurs = $this->input->post('txtKurs');
        $txtKursDate = $this->input->post('date_posting');
        $txtKursUSD = $this->input->post('txtKursUSD');
        $currency_symbol = $this->input->post('currency_simbol');
        if ($txtKurs == 0) {
            $this->session->set_flashdata('message', pesan('Create Record Failed. Rate cannot Zero.', pesan_error()));
            redirect(site_url('Closing_rate'));
        } else {
            for ($i = 0; $i < count($currency_name); $i++) {
                $data = array(
                    'p_perintah' => 'add',
                    'p_tanggal' => $periode,
                    'p_currency_id' => $currency_symbol[$i],
                    'p_currency_rate' => $txtKurs[$i],
                    'p_currency_date' => $periode,
                    'p_created_by' => strtolower($this->session->userdata('userid_1')),
                    'p_ip_address' => $_SERVER['REMOTE_ADDR']
                );
                $this->M_Closing_rate->sp_closing_rate($data);
            }
            
               
            $data_posting = array(
                'p_tanggal' => $periode,
                'p_created_by' => strtolower($this->session->userdata('userid_1')),
                'p_ip_address' => $_SERVER['REMOTE_ADDR']
            );
            $this->M_Closing_rate->sp_posting($data_posting);
            $this->M_Closing_rate->sp_selisih($data_posting);

            $this->session->set_flashdata('message', pesan('Create Record Success', pesan_sukses()));
            redirect(site_url('Closing_rate'));
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
            $this->M_Closing_rate->update_kurs($this->input->post('currency_symbol', TRUE), $update_kurs);

            $this->M_Closing_rate->update($this->input->post('currency_id', TRUE), $data);
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

    function search_rate() {
        $sekarang = $this->input->get('tgl');
        $data['get_currency'] = $this->M_Closing_rate->get_cur_date($sekarang);
        $this->load->view('accounting/list_rate', $data);
    }

}
