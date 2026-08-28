<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Saldo_awal_zht extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('M_saldo_awal_zht');
        $this->load->library(array('template', 'user_agent'));

        if (!$this->session->userdata('userid_1')) {
            redirect('login');
        }
    }


    public function saldo_awal()
    {
        $data['items'] = $this->M_saldo_awal_zht->getAllSaldo();
        $this->template->display('saldo_awal_zht/mstsaldo_awal_zht', $data);
    }
          
    public function saldo_save()
    {
        $nocoa            = trim($this->input->post('nocoa'));
        $periode_bulan    = $this->input->post('periode_bulan');
        $periode_tahun    = $this->input->post('periode_tahun');
        $periode_tanggal  = $this->input->post('periode_tanggal');
        $periode_string   = $this->input->post('periode_string');
        $debet            = $this->input->post('debet');
        $kredit           = $this->input->post('kredit');
        $debet_SGD        = $this->input->post('debet_SGD');
        $kredit_SGD       = $this->input->post('kredit_SGD');
        $dept_code        = $this->input->post('dept_code');
        $company          = $this->input->post('company');
        
        $userid           = strtoupper($this->session->userdata('userid_1'));
        $ip_address       = $this->input->ip_address();
        $current_date     = date('Y-m-d H:i:s');
        
        $data = array(
            'nocoa'            => $nocoa,
            'periode_bulan'    => $periode_bulan,
            'periode_tahun'    => $periode_tahun,
            'periode_tanggal'  => $periode_tanggal,
            'periode_string'   => $periode_string,
            'debet'            => $debet,
            'kredit'           => $kredit,
            'debet_SGD'        => $debet_SGD,
            'kredit_SGD'       => $kredit_SGD,
            'dept_code'        => $dept_code,
            'company'          => $company,
            'created_by'       => $userid,
            'created_date'     => $current_date,
            'last_update_by'   => $userid,
            'last_update_date' => $current_date,
            'ip_address'       => $ip_address
        );
        
        $this->load->model('M_saldo_awal_zht');
        $query = $this->M_saldo_awal_zht->save_saldo($data);
        $message = $query ? 'Data berhasil disimpan atau diperbarui.' : 'Terjadi kesalahan, silakan coba lagi.';
        
        $this->session->set_flashdata("message", "<div class='alert " . ($query ? "alert-success" : "alert-danger") . "'>$message</div>");
        
        
    }
    public function saldo_search() {
        $searchTerm = $this->input->get('saldo'); 
        $this->load->model('M_saldo_awal_zht'); 
    
        $items = $this->M_saldo_awal_zht->search_saldo($searchTerm);
        $this->load->view('mstsaldo_awal', ['items' => $items]); 
    }
    
    public function saldo_delete() {
        $nocoa = $this->input->get('nocoa'); 
        $this->load->model('M_saldo_awal_zht');
    
        $this->M_saldo_awal_zht->delete_saldo($nocoa);
    
        $this->session->set_flashdata('message', 'Data deleted successfully');
        redirect('Saldo_awal_zht/saldo_awal');
    }

    public function saldo_edit() {
        $nocoa = $this->input->get('nocoa'); // Ambil parameter dari URL
    
        // Ambil data dari database berdasarkan nocoa
        $row = $this->db->get_where('zht_acc_tbl_trn_saldoawal', ['nocoa' => $nocoa])->row();
    
        if ($row) {
            $data = array(
                'button'            => 'Update',
                'action'            => site_url('saldo_awal_zht/saldo_update'),
                'header_title'      => 'Edit Saldo Awal ZHT',
                'nocoa'             => set_value('nocoa', $row->nocoa),
                'periode_bulan'     => set_value('periode_bulan', $row->periode_bulan),
                'periode_tahun'     => set_value('periode_tahun', $row->periode_tahun),
                'periode_tanggal'   => set_value('periode_tanggal', $row->periode_tanggal),
                'periode_string'    => set_value('periode_string', $row->periode_string),
                'debet'             => set_value('debet', $row->debet),
                'kredit'            => set_value('kredit', $row->kredit),
                'debet_SGD'         => set_value('debet_SGD', $row->debet_SGD),
                'kredit_SGD'        => set_value('kredit_SGD', $row->kredit_SGD),
                'dept_code'         => set_value('dept_code', $row->dept_code),
                'company'           => set_value('company', $row->company),
            );
    
            $this->template->display('saldo_awal_zht/mstsaldo_edit', $data);
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger">Data tidak ditemukan!</div>');
            redirect('Saldo_awal_zht/saldo_awal');
        }
    }
        public function saldo_save_update()
        {
            $nocoa            = trim($this->input->post('nocoa'));
            $periode_bulan    = $this->input->post('periode_bulan');
            $periode_tahun    = $this->input->post('periode_tahun');
            $periode_tanggal  = $this->input->post('periode_tanggal');
            $periode_string   = $this->input->post('periode_string');
            $debet            = $this->input->post('debet');
            $kredit           = $this->input->post('kredit');
            $debet_SGD        = $this->input->post('debet_SGD');
            $kredit_SGD       = $this->input->post('kredit_SGD');
            $dept_code        = $this->input->post('dept_code');
            $company          = $this->input->post('company');
            
            $userid           = strtoupper($this->session->userdata('userid_1'));
            $ip_address       = $this->input->ip_address();
            $current_date     = date('Y-m-d H:i:s');
            
            $data = array(
                'nocoa'            => $nocoa,
                'periode_bulan'    => $periode_bulan,
                'periode_tahun'    => $periode_tahun,
                'periode_tanggal'  => $periode_tanggal,
                'periode_string'   => $periode_string,
                'debet'            => $debet,
                'kredit'           => $kredit,
                'debet_SGD'        => $debet_SGD,
                'kredit_SGD'       => $kredit_SGD,
                'dept_code'        => $dept_code,
                'company'          => $company,
                'created_by'       => $userid,
                'created_date'     => $current_date,
                'last_update_by'   => $userid,
                'last_update_date' => $current_date,
                'ip_address'       => $ip_address
            );
            $query = $this->M_saldo_awal_zht->save_saldo($data);
            $message = $query ? 'Data berhasil disimpan atau diperbarui.' : 'Terjadi kesalahan, silakan coba lagi.';
            
            $this->session->set_flashdata("message", "<div class='alert " . ($query ? "alert-success" : "alert-danger") . "'>$message</div>");

        }
}
