
<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Supplier_card_zht extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model(array('M_Supplier_card_zht', 'M_Fin_AP_zht', 'M_Fin_Dp'));
        $this->load->library(array('user_agent'));
        $this->load->helper('mysqli');
        if (!$this->session->userdata('userid_1')) {
            redirect('login');
        }
    }

    public function index() {

        $data['SupplierID'] = $this->M_Supplier_card_zht->get_supplier();
        $data['CurrencyID'] = $this->M_Supplier_card_zht->get_currency();

        $this->template->display('accounting/supplier_card_zht', $data);
    }

    function search() {
        $sup = $this->input->get('supplier');
        $from = date('Y-m-d', strtotime($this->input->get('from')));
        $to = date('Y-m-d', strtotime($this->input->get('to')));
        $coa = $this->input->get('coa');
        $cur = $this->input->get('currency');
        
        $data['SupplierID'] = $this->M_Supplier_card_zht->get_supplier();
        $data['CurrencyID'] = $this->M_Supplier_card_zht->get_currency();
        $data['Get_aging']  = $this->M_Supplier_card_zht->call_data($sup, $cur,$from,$to, $coa);

        $this->template->display('accounting/supplier_card_zht', $data);
    }


    function reviewAPpayment(){
        $headID = $this->input->get('id');
        $get    = $this->M_Fin_AP_zht->selectHeaderAPforReviewByNoReff($headID);
        $noReff = $get->header_id;
        $thnPeriod  = $get->thn_periode;
        $blnPeriod  = $get->bln_periode;
        $data   = array(
            '_periode'          => date('Y-m-d', strtotime($thnPeriod.'-'.$blnPeriod.'-01')),
            '_selectCurrency'   => $this->db->get('gen_tbl_mst_currency')->result(),
            '_titleForm'        => array('head' => 'Transaction', 'desc' => 'Payment A/P'),
            
            '_currBayar'        => $get->currency_bayar,
            '_selectHeaderAP'   => $this->M_Fin_AP_zht->selectHeaderAPforReview($noReff),
            '_selectInvoiceAP'  => $this->M_Fin_AP_zht->selectInvoiceAPforReview($headID),
            '_selectDetailAP'   => $this->M_Fin_AP_zht->selectDetailAPforReview($noReff)->result(),
            '_selectDtlJrnal'   => $this->M_Fin_AP_zht->selectDetailJurnalAPforReview($noReff)->result()
        );
        $this->template->display('finance/transaction/ap_trans/findAP/index-review',$data);
    }

    function reviewAPdownpayment(){
        $headerID = $this->input->get('id');
        $get    = $this->M_Fin_Dp->selectDetailDepositByNoReff($headerID)->row();
        $headID = $get->header_id;
        $jumDtl = $this->M_Fin_Dp->selectDetailDepositAP($headID)->num_rows();
        $data   = array(
            '_selectCurrency'   => $this->db->get('gen_tbl_mst_currency')->result(),
            '_selectMasterCOA'  => $this->M_Fin_Dp->selectCOAforDp()->result(),

            '_selectHeader'     => $this->M_Fin_Dp->selectHeaderDepositAP($headID),
            '_selectDetail'     => $this->M_Fin_Dp->selectDetailDepositAP($headID)->result(),
            '_jumDetail'        => $jumDtl
        );
        $this->template->display('finance/transaction/ap_dp/find_dp/index-review', $data);
    }

    function print_report() {


        $sup = $this->input->get('supplier');
        $from = date('Y-m-d', strtotime($this->input->get('dari')));
        $to = date('Y-m-d', strtotime($this->input->get('sampai')));
        $coa = $this->input->get('coa');
        $cur = $this->input->get('currency');

        $data['from'] = $from;
        $data['to'] = $to;
        $su = $this->M_Supplier_card_zht->get_supp($sup);
        $data['supplier'] = $su->suppliercompany;
        $data['get_data']  = $this->M_Supplier_card_zht->call_data($sup, $cur,$from,$to, $coa);

        $this->load->view('accounting/rpt/rpt_supplier_card_zht', $data);
    }

}
