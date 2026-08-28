
<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Customers_card2 extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model(array('M_Customer_card','M_Fin_AR','M_Fin_Dp'));
        $this->load->library(array('user_agent'));

        if (!$this->session->userdata('userid_1')) {
            redirect('login');
        }
    }

    public function index() {

        $data['SupplierID'] = $this->M_Customer_card->get_customer();
        $data['CurrencyID'] = $this->M_Customer_card->get_currency();
        
        $this->template->display('accounting/Customer_card_new', $data);
    }
    function search() {
        $sup = $this->input->get('supplier');
        $from = date('Y-m-d', strtotime($this->input->get('from')));
        $to = date('Y-m-d', strtotime($this->input->get('to')));
        $coa = $this->input->get('coa');
        $cur = $this->input->get('currency');
        
        $data['SupplierID'] = $this->M_Customer_card->get_customer();
        $data['CurrencyID'] = $this->M_Customer_card->get_currency();
        $data['Get_aging']  = $this->M_Customer_card->call_data2($sup,$cur, $from,$to, $coa);

        $this->template->display('accounting/Customer_card_new', $data);
    }
    
    function reviewARpayment(){
        $headID = $this->input->get('id');
        $get    = $this->M_Fin_AR->selectHeaderARforReviewByNoReff($headID);
        $noReff = $get->header_id;
        $thnPeriod  = $get->thn_periode;
        $blnPeriod  = $get->bln_periode;
        $data   = array(
            '_periode'          => date('Y-m-d', strtotime($thnPeriod.'-'.$blnPeriod.'-01')),
            '_selectCurrency'   => $this->db->get('gen_tbl_mst_currency')->result(),
            '_titleForm'        => array('head' => 'Transaction', 'desc' => 'Receivable A/R'),
            
            '_currBayar'        => $get->currency_bayar,
            '_selectHeaderAP'   => $this->M_Fin_AR->selectHeaderARforReview($noReff),
            '_selectInvoiceAP'  => $this->M_Fin_AR->selectInvoiceARforReview($headID),
            '_selectDetailAP'   => $this->M_Fin_AR->selectDetailARforReview($noReff)->result(),
            '_selectDtlJrnal'   => $this->M_Fin_AR->selectDetailJurnalARforReview($noReff)->result()
                
        );
        $this->template->display('finance/transaction/ar_trans/findAR/index-review',$data);
    }

    function reviewARdeposit(){
        $headerID = $this->input->get('id');
        $get = $this->M_Fin_Dp->selectDetailDepositByNoReff($headerID)->row();
        $headID = $get->header_id;
        //echo $headID.' - '.$headerID;
        $jumDtl = $this->M_Fin_Dp->selectDetailDepositAP($headID)->num_rows();
        $data   = array(
            '_selectCurrency'   => $this->db->get('gen_tbl_mst_currency')->result(),
            '_selectMasterCOA'  => $this->M_Fin_Dp->selectCOAforDp()->result(),

            '_selectHeader'     => $this->M_Fin_Dp->selectHeaderDepositAP($headID),
            '_selectDetail'     => $this->M_Fin_Dp->selectDetailDepositAP($headID)->result(),
            '_jumDetail'        => $jumDtl
        );
        $this->template->display('finance/transaction/ar_dp/find_dp/index-review', $data);
    }

    // function toPrintCustomerCard()
    // {


    //     $sup = $this->input->get('supplier');
    //     $from = date('Y-m-d', strtotime($this->input->get('dari')));
    //     $to = date('Y-m-d', strtotime($this->input->get('sampai')));
    //     $coa = $this->input->get('coa');
    //     $cur = $this->input->get('currency');

    //     $data['from'] = $from;
    //     $data['to'] = $to;
    //     $data['Get_aging']  = $this->M_Customer_card->call_data($sup,$cur, $from,$to, $coa);


    //     $this->template->display('accounting/rpt/rpt_customer_card', $data);

    // }

    function toPrintCustomerCard()
    {
        $sup = $this->input->get('supplier');
        $from = date('Y-m-d', strtotime($this->input->get('dari')));
        $to = date('Y-m-d', strtotime($this->input->get('sampai')));
        $coa = $this->input->get('coa');
        $cur = $this->input->get('currency');


        $s1 = $this->M_Customer_card->get_cust($sup);
        // $s2 = $s1->customer_name;

        $data['from'] = $from;
        $data['to'] = $to;
        $data['supplier']  = $s1->customer_name;
        // $data['get_data']  = $this->M_Customer_card->call_data($sup,$cur, $from,$to, $coa);
        $data['get_data'] =  $this->M_Customer_card->call_data2($sup, $cur,$from, $to,$coa);

        // echo $s2." ".$from." ".$to."<br>";
        // foreach ($a as $r) {
        //     echo $r->tmp_kodecus."<br>";
        // }
        $this->load->view('accounting/rpt/rpt_customer_card', $data);

    }

}
