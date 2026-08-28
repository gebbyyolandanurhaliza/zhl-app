<?php defined('BASEPATH') OR exit('No direct script access allowed');

/* 
 * Author : ITD15
 */

class ARlist extends CI_Controller{
    public function __construct() {
        parent::__construct();
        
        //is_maintenance(FALSE, $this->session->userdata('userid_1'));
        
        if(!$this->session->userdata('userid_1')){
            redirect('login');
        }
        
        date_default_timezone_set("Asia/Jakarta");
        $this->load->model(array('M_Fin_ARList'));
    }
    
    function index(){
        $data   = array(
            '_selectAR' => $this->M_Fin_ARList->selectARforListAR()->result()
        );
        $this->template->display('finance/transaction/ar_trans/listAR/index-list',$data);
    }
    function getDetailARList(){
        $hdrID  = decode_str($this->input->post('txtHdrID'));
        $noAR   = decode_str($this->input->post('txtNoAR'));
        $getAP  = $this->M_Fin_ARList->selectARheaderforListARbyHeaderID($hdrID);
        $curPay = $getAP->currency_bayar;
        $data   = array(
            '_currBayar'        => $curPay,
            //'_selectARdetail'   => $this->M_Fin_ARList->selectDetailARbyHeaderID($hdrID)->result(),
            '_selectARdetailAc' => $this->M_Fin_ARList->selectDetailARinAccByHeaderID($noAR)->result(),
            '_selectARjurnal'   => $this->M_Fin_ARList->selectDetailJurnalARbyHeaderID($hdrID)->result()
        );
        $this->load->view('finance/transaction/ar_trans/listAR/setARdetail',$data);
    }
}