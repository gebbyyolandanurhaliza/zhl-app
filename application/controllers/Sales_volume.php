<?php

/**
 * Created by PhpStorm.
 * User: Reza Irhami
 * Date: 1/16/2017
 * Time: 1:08 PM
 */

defined('BASEPATH') OR exit('No direct script access allowed');
class Sales_volume extends CI_Controller
{
    function __construct() {
        parent::__construct();

        $this->load->model(array('M_Fin_Master','M_Sales_Volume'));
        $this->load->library(array('template', 'user_agent'));

        if (!$this->session->userdata('userid_1')) {
            redirect('login');
        }
    }
    function index() {

        $data['sales_person'] = $this->M_Fin_Master->get_employee();
        $this->template->display('accounting/Laporan/Sales_volume',$data);
    }

    function search() {

        $dari = str_replace('/', '-', $this->input->get('dari'));
        $p_dari = date('Y-m-d', strtotime($dari));

        $sampai = str_replace('/', '-', $this->input->get("sampai"));
        $p_sampai = date('Y-m-d', strtotime($sampai));

        $sales_person = str_replace(' ', '-', $this->input->get('sales_person'));

		
        $data['sales_person']       = $this->M_Fin_Master->get_employee();
        $data['_tampil_sales']      = $this->M_Sales_Volume->call_sales_report($p_dari, $p_sampai, $sales_person);
		$data['customer_list']      = $this->M_Sales_Volume->get_datacustomer($p_dari, $p_sampai, $sales_person);


        $this->template->display('accounting/Laporan/Sales_volume', $data);
    }
	
	function print_report(){
		$dari = str_replace('/', '-', $this->input->get('from'));
        $p_dari = date('Y-m-d', strtotime($dari));

        $sampai = str_replace('/', '-', $this->input->get("to"));
        $p_sampai = date('Y-m-d', strtotime($sampai));

        $sales_person = str_replace(' ', '-', $this->input->get('sales_person'));
		
		$data['from']				= $p_dari;
		$data['to']					= $p_sampai;		
		$data['sales_person']       = $sales_person;
        $data['_tampil_sales']      = $this->M_Sales_Volume->call_sales_report($p_dari, $p_sampai, $sales_person);
		$data['customer_list']      = $this->M_Sales_Volume->get_datacustomer($p_dari, $p_sampai, $sales_person);
		
		$this->load->view('accounting/rpt/rpt_sales_volume', $data);
	}


}