<?php defined('BASEPATH') OR exit('No direct script access allowed');

/* 
 * Author : ITD15
 */

class APlist extends CI_Controller{
    public function __construct() {
        parent::__construct();
        
        //is_maintenance(FALSE, $this->session->userdata('userid_1'));
        
        if(!$this->session->userdata('userid_1')){
            redirect('login');
        }
        
        date_default_timezone_set("Asia/Jakarta");
        $this->load->model(array('M_Fin_APList'));
    }
    
    function index(){
        $data   = array(
            '_selectAP' => $this->M_Fin_APList->selectAPforListAP()->result()
        );
        $this->template->display('finance/transaction/ap_trans/listAP/index-list',$data);
    }
    function getDetailAPList(){
        $hdrID  = decode_str($this->input->post('txtHdrID'));
        $noAP   = decode_str($this->input->post('txtNoAP'));
        $getAP  = $this->M_Fin_APList->selectAPheaderforListAPbyHeaderID($hdrID);
        $curPay = $getAP->currency_bayar;
        $data   = array(
            '_currBayar'        => $curPay,
            //'_selectAPdetail'   => $this->M_Fin_APList->selectDetailAPbyHeaderID($hdrID)->result(),
            '_selectAPdetailAc' => $this->M_Fin_APList->selectDetailAPinAccByHeaderID($noAP)->result(),
            '_selectAPjurnal'   => $this->M_Fin_APList->selectDetailJurnalAPbyHeaderID($hdrID)->result()
        );
        $this->load->view('finance/transaction/ap_trans/listAP/setAPdetail',$data);
    }
}