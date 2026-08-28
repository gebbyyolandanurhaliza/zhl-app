
<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Profit_and_lost extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model(array('M_Profit_and_lost'));
        $this->load->library(array('user_agent', 'Template'));
        $this->load->helper('mysqli');
        if (!$this->session->userdata('userid_1')) {
            redirect('login');
        }
    }

    public function index() {

        $data['coa_number'] = $this->M_Profit_and_lost->coa_number();
        $data['CurrencyID'] = $this->M_Profit_and_lost->get_currency();

        $this->template->display('accounting/Laporan/Profit_and_loss', $data);
    }

    public function form() {
        $data["GroupCOA"] = $this->M_Profit_and_lost->select_group_coa();
        $data["list_group"] = $this->M_Profit_and_lost->select_group_report();
        $data["list_coa"] = $this->M_Profit_and_lost->coa_number();
        $data["list_cat"] = $this->M_Profit_and_lost->category_list();
        $data['message'] = $this->session->flashdata('message');
        $this->template->display('accounting/master_report/form_profit_and_loss', $data);
    }

    public function filter_table() {
        $data["id_group"] = $this->input->get("id_group");
        $data["id_kategori"] = $this->input->get("id_kategori");
        $id_group = $this->input->get("id_group");
        $id_kategori = $this->input->get("id_kategori");
        $data["get_coa_list"] = $this->M_Profit_and_lost->get_id_coa();
        $data["get_id_coa"] = $this->M_Profit_and_lost->get_coa_list($id_group, $id_kategori);
        $this->load->view('accounting/ajax/table_coa', $data);
    }

    public function simpan_coa() {
        $chk = $this->input->post('chk');
        for ($i = 0; $i < count($chk); $i++) {
            $data = array(
                'id_kategori' => $this->input->post('id_group'),
                'id_group' => $this->input->post('id_kategori'),
                'no_coa' => $chk[$i],
                'active' => 1
            );
            $this->M_Profit_and_lost->simpan_coa($data);
        }
        $this->session->set_flashdata('message', pesan('Create record success for ' . count($chk) . " data.", pesan_sukses()));
        redirect('Profit_and_lost/form');
    }

    public function input_group() {
       $data = array(
            'id_kategori' => $this->input->post('category_name'),
            'no_urut' => $this->input->post('NoUrut'),
            'nama_group' => $this->input->post('GroupCOA'), 
            'Active' => 1
        );
        $this->M_Profit_and_lost->input_group($data);

        $this->session->set_flashdata('message', pesan('Create Record Success', pesan_sukses()));
        redirect('Profit_and_lost/form');
    }

    public function input_coa() {
        $str = explode("|", $this->input->post('category_name'));
        $data = array(
            'id_kategori' => $str[1],
            'id_group' => $str[0],
            'no_coa' => $this->input->post('no_coa'),
            'Active' => 1
        );
        $this->M_Profit_and_lost->input_coa($data);

        $this->session->set_flashdata('message', pesan('Create Record Success', pesan_sukses()));
        redirect('Profit_and_lost/form');
    }

    public function diffInMonths(\DateTime $date1, \DateTime $date2) {
        $diff = $date1->diff($date2);

        $months = $diff->y * 12 + $diff->m + $diff->d / 30;

        return (int) round($months);
    }

    function search() {
        $tahun = $this->input->get('tahun');
        $data['coa_number'] = $this->M_Profit_and_lost->coa_number();

        $data['get_invoice'] = $this->M_Profit_and_lost->call_data_profit($tahun, '0');
        $data['get_sales'] = $this->M_Profit_and_lost->call_data_profit($tahun, '8');
        $data['get_opening'] = $this->M_Profit_and_lost->call_data_profit($tahun, '4'); // 7
        $data['get_purchase'] = $this->M_Profit_and_lost->call_data_profit($tahun, '6');
        $data['get_freight'] = $this->M_Profit_and_lost->call_data_profit($tahun, '5');
        $data['get_closing'] = $this->M_Profit_and_lost->call_data_profit($tahun, '4');
        $data['get_gross'] = $this->M_Profit_and_lost->call_data_profit($tahun, '3');
        $data['get_bank'] = $this->M_Profit_and_lost->call_data_profit($tahun, '2');
        $data['get_other'] = $this->M_Profit_and_lost->call_data_profit($tahun, '1');

        $this->template->display('accounting/Laporan/Profit_and_loss', $data);
    }

    // function search_period() {
    //     $data['dari'] = $this->input->get('dari');
    //     $data['sampai'] = $this->input->get('sampai');

    //     $p_dari = date('Y-m-d', strtotime($this->input->get('dari')));
    //     $p_sampai = date('Y-m-d', strtotime($this->input->get("sampai")));

    //     $data['bulan_awal'] = date('m', strtotime($this->input->get('dari')));
    //     $data['awal'] = date('Y-m-d', strtotime($this->input->get('dari')));

    //     $data['bulan_akhir'] = date('m', strtotime($this->input->get('sampai')));

    //     $data['tahun_awal'] = date('Y', strtotime($this->input->get('dari')));
    //     $data['tahun_akhir'] = date('Y', strtotime($this->input->get('sampai')));

    //     $data['jumlah_bulan'] = (int) (strtotime($p_sampai) - strtotime($p_dari)) / (60 * 60 * 24 * 30);
      
    //     $data['get_invoice'] = $this->M_Profit_and_lost->call_data_profit($p_dari, $p_sampai, '0');

    //     $this->template->display('accounting/Laporan/Profit_and_loss', $data);
    // }
    function search_period_new() {
        $data['dari'] = $this->input->get('dari');
        $data['sampai'] = $this->input->get('sampai');

        $p_dari = date('Y-m-d', strtotime($this->input->get('dari')));
        $p_sampai = date('Y-m-d', strtotime($this->input->get("sampai")));

        $data['bulan_awal'] = date('m', strtotime($this->input->get('dari')));
        $data['awal'] = date('Y-m-d', strtotime($this->input->get('dari')));

        $data['bulan_akhir'] = date('m', strtotime($this->input->get('sampai')));

        $data['tahun_awal'] = date('Y', strtotime($this->input->get('dari')));
        $data['tahun_akhir'] = date('Y', strtotime($this->input->get('sampai')));

        $data['jumlah_bulan'] = (int) (strtotime($p_sampai) - strtotime($p_dari)) / (60 * 60 * 24 * 30);
      
        $data['get_invoice'] = $this->M_Profit_and_lost->call_data_profit_new($p_dari, $p_sampai);

        $this->template->display('accounting/Laporan/Profit_and_lost', $data);
    }

    function print_profit_and_loss(){
        $data['dari'] = $this->input->get('dari');
        $data['sampai'] = $this->input->get('sampai');

        $p_dari = date('Y-m-d', strtotime($this->input->get('dari')));
        $p_sampai = date('Y-m-d', strtotime($this->input->get("sampai")));

        $data['bulan_awal'] = date('m', strtotime($this->input->get('dari')));
        $data['awal'] = date('Y-m-d', strtotime($this->input->get('dari')));

        $data['bulan_akhir'] = date('m', strtotime($this->input->get('sampai')));

        $data['tahun_awal'] = date('Y', strtotime($this->input->get('dari')));
        $data['tahun_akhir'] = date('Y', strtotime($this->input->get('sampai')));

        $data['jumlah_bulan'] = (int) (strtotime($p_sampai) - strtotime($p_dari)) / (60 * 60 * 24 * 30);
      
        $data['get_invoice'] = $this->M_Profit_and_lost->call_data_profit($p_dari, $p_sampai, '0');

        $this->load->view('accounting/rpt/rpt_profit_and_loss', $data);
    }

}




