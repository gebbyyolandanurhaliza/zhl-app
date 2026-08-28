<?php defined('BASEPATH') OR exit('No direct script access allowed');

/* 
 * Author : ITD15
 */

class Finance_Report extends CI_Controller{
    public function __construct() {
        parent::__construct();

        //is_maintenance(FALSE, $this->session->userdata('userid_1'));
        
        if(!$this->session->userdata('userid_1')){
            redirect('login');
        }
        
        date_default_timezone_set("Asia/Jakarta");
        $this->load->model(array('M_Fin_Report'));
    }
    
    function index(){
        $this->template->display('finance/report/journal_cb/journal_cash_bank2');
    }

    function search(){
        $reffnumber = $this->input->get('reffnumber');
        $from = date('Y-m-d', strtotime($this->input->get('from')));
        $to   = date('Y-m-d', strtotime($this->input->get('to')));
        

        $data['_selectHeaderCashBank'] = $this->M_Fin_Report->selectHeadercashbanksearch2($reffnumber, $from, $to);
        
        $this->template->display('finance/report/journal_cb/journal_cash_bank2',$data);
    }

    function CashBankJournal(){
        $segm   = $this->uri->segment(3);
        $key    = $this->input->post('txtKeyword');
        if($segm == TRUE){
            //$selectedData   = $this->M_Fin_Report->selectHeaderCashBank()->result();
            $selectedData   = $this->M_Fin_Report->selectHeaderCashBankSearch($key)->result();
        }else{
            $selectedData   = $this->M_Fin_Report->selectHeaderCashBank()->result();
        }
        $data   = array(
            '_selectHeaderCashBank' => $selectedData
        );
        $this->template->display('finance/report/journal_cb/journal_cash_bank',$data);
    }

    function getCashBankJournalByHeaderID(){
        $hdrID  = $this->input->post('txtHdrID');
        $data   = array(
            '_selectDetailByHeaderID'   => $this->M_Fin_Report->selectDetailCBByHeaderID($hdrID)->result()
        );
        $this->load->view('finance/report/journal_cb/setDetailCashBank',$data);
    }


    function selectCOA(){
        $data   = array(
            '_getMasterCOA' => $this->M_Fin_Report->selectCOAforReport()->result()
        );
        $this->load->view('finance/report/journal_cb/selectMCOA',$data);
    }
}