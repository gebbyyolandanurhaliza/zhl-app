
<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Profit_and_loss extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model(array('M_Profit_and_loss'));
        $this->load->library(array('user_agent', 'Template', 'PHPExcel'));
        $this->load->helper('mysqli');
        if (!$this->session->userdata('userid_1')) {
            redirect('login');
        }
    }

    public function index() {
        $data['dept_code'] = $this->M_Profit_and_loss->get_departmentcode();
        $this->template->display('accounting/Laporan/Profit_and_loss_new',$data);
    }

    function search_period() {
         $data['dari']   = $this->input->get('dari');
         $data['sampai'] = $this->input->get('sampai');
         $data['hide']   = $this->input->get('hide');
         $data['dept']   = $this->input->get('txtdept');
         $data['comp']   = $this->input->get('txtcomp');
         $data['currency']   = $this->input->get('txtcurrency');
         $data['dept_code'] = $this->M_Profit_and_loss->get_departmentcode();

         $p_dari        = date('Y-m-d', strtotime($this->input->get('dari')));
         $p_sampai      = date('Y-m-d', strtotime($this->input->get("sampai")));
         if ($p_dari > '2024-12-31' and $p_sampai > '2024-12-31') {
            $dept   = $this->input->get('txtdept');
            $comp   = $this->input->get('txtcomp');
            $cur   = $this->input->get('txtcurrency');
            $data['_result'] = $this->M_Profit_and_loss->get_data_2025($p_dari, $p_sampai,$dept,$comp,$cur);
         }else if ($p_dari <= '2024-12-31' and $p_sampai <= '2024-12-31') {
            $data['_result'] = $this->M_Profit_and_loss->get_data($p_dari, $p_sampai);
         }else{
            $data['_result']='';
            $data['info']= 'cannot combine all data new 2025 with under 2025';
         }
         
         $data['tahun']= date('Y', strtotime($this->input->get('dari')));
         $this->template->display('accounting/Laporan/Profit_and_loss_new', $data);
    }

    function getNameFromNumber($num) {
        $numeric = $num % 26;
        $letter = chr(65 + $numeric);
        $num2 = intval($num / 26);
        if ($num2 > 0) {
            return $this->getNameFromNumber($num2 - 1) . $letter;
        } else {
            return $letter;
        }
    }

    function check(){
        $a = $this->getNameFromNumber(1);
        echo $a;
    }

    function print_report(){
        echo "STILL MAINTENANCE";
        // $data['dari']   = $this->input->get('dari');
        // $data['sampai'] = $this->input->get('sampai');
        // $data['hide']   = $this->input->get('hide');
        // $p_dari              = date('Y-m-d', strtotime($this->input->get('dari')));
        // $p_sampai            = date('Y-m-d', strtotime($this->input->get("sampai")));
	    // $p_dari2['dari']     = date('Y-m-d', strtotime($this->input->get('dari')));
        // $p_sampai2['sampai'] = date('Y-m-d', strtotime($this->input->get("sampai")));


        // $data['awal']   = $p_dari;
        // $data['akhir']  = $p_sampai;
	    // $awal           = $p_dari;
        // $akhir          = $p_sampai;

        // $data['bulan_awal'] = date('m', strtotime($this->input->get('dari')));
        // $data['bulan_akhir']= date('m', strtotime($this->input->get('sampai')));

        // $data['tahun_awal'] = date('Y', strtotime($this->input->get('dari')));
        // $data['tahun_akhir']= date('Y', strtotime($this->input->get('sampai')));

        //  // $data['jumlah_bulan'] = (int) (strtotime($p_sampai) - strtotime($p_dari)) / (60 * 60 * 24 * 30);

		// $timeStart  = strtotime($this->input->get('dari'));
		// $timeEnd    = strtotime($this->input->get("sampai"));
		// $numBulan   = 1 + (date("Y",$timeEnd)-date("Y",$timeStart))*12;
		// $numBulan   += date("m",$timeEnd)-date("m",$timeStart);
		// $data['jumlah_bulan']=$numBulan;
		// $jumlah_bulan=$numBulan;


      
        // $data['get_coa']        = $this->M_Profit_and_loss->list_coa_gen();
     	// $data['get_t1']         = $this->M_Profit_and_loss->call_data_t1($p_dari, $p_sampai, $jumlah_bulan, $awal, $akhir);
    	// $data['get_purchase']   = $this->M_Profit_and_loss->call_data_tpurchase($p_dari, $p_sampai);
    	// $data['get_zopening']   = $this->M_Profit_and_loss->call_data_zopening($p_dari, $p_sampai);
    	// $data['get_zclosing']   = $this->M_Profit_and_loss->call_data_zclosing($p_dari, $p_sampai);
    	// $data['get_gprofit']    = $this->M_Profit_and_loss->call_data_gprofit($p_dari, $p_sampai);
    	// $data['get_general']    = $this->M_Profit_and_loss->call_data_general($p_dari, $p_sampai);
    	// $data['get_all']        = $this->M_Profit_and_loss->call_data_all($p_dari, $p_sampai);

        // // $awal1 = New DateTime($awal);
        // // $akhir1 = New DateTime($akhir);
        // // $selisih = $awal1->diff($akhir1);
        // // $sel = ($selisih->y * 12 ) + $selisih->m;


        // $bulaw = intval(date('m', strtotime($this->input->get('dari'))));
        // $bulak = intval(date('m', strtotime($this->input->get('sampai'))));
        // $tahaw = intval(date('Y', strtotime($this->input->get('dari'))));
        // $tahak = intval(date('Y', strtotime($this->input->get('sampai'))));

        // $sel = (($tahak - $tahaw) * 12) + ($bulak - $bulaw);

        // // echo $sel;
        // if($sel <= 5)
        // {
        //     $this->load->view('accounting/rpt/rpt_profit_and_loss', $data);
        // }
        // else if( $sel < 10 && $sel > 5)
        // {
        //     $this->load->view('accounting/rpt/rpt_profit_and_loss_2', $data);    
        // }
        // else
        // {
        //     $this->load->view('accounting/rpt/rpt_profit_and_loss_3', $data);     
        // }
  	    



    }   

}




