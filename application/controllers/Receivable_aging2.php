
<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Receivable_aging extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model(array('M_receivable_aging'));
        $this->load->library(array('user_agent'));

        if (!$this->session->userdata('userid_1')) {
            redirect('login');
        }
    }

    public function index() {

        $data['SupplierID'] = $this->M_receivable_aging->get_customer();
        $data['CurrencyID'] = $this->M_receivable_aging->get_currency();
        
        $this->template->display('accounting/Laporan/Receivable_aging', $data);
    }
    function search() {
        $sup = $this->input->get('supplier');
        $curreny = $this->input->get('currency');
        
        $dari = str_replace('-', '-', $this->input->get('dari'));
        $p_dari = date('Y-m-d', strtotime($dari));

        $sampai = str_replace('-', '-', $this->input->get("sampai"));
        $p_sampai = date('Y-m-d', strtotime($sampai));
        
        $data['SupplierID'] = $this->M_receivable_aging->get_customer();
        $data['GroupSupplierID'] = $this->M_receivable_aging->get_group_supp($p_dari, $p_sampai, $sup);
        $data['CurrencyID'] = $this->M_receivable_aging->get_currency();
        $data['Get_aging']  = $this->M_receivable_aging->call_data_aging($sup, $curreny, $p_dari, $p_sampai);

        $this->template->display('accounting/Laporan/Receivable_aging', $data);
    }
    

}
