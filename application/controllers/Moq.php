<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Moq extends CI_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model(array('M_Moq'));
        $this->load->library(array('template', 'user_agent'));

        if (!$this->session->userdata('userid')) {
            redirect('login');
        }
    }

    function index() {
        $data['_list'] = $this->M_Moq->get_list();
        $this->template->display('factory/list_moq', $data);
    }

    function add_new(){
    	$data['_product'] = $this->M_Moq->select_product();
    	$this->template->display('factory/moq', $data);
    }

    function edit(){
        $product_id = $_GET['product_id'];
        $data['_detail'] = $this->M_Moq->get_detail($product_id);
        $this->template->display('factory/moq', $data);
    }

    function save_moq(){
    	$sbt = $this->input->post('sbt');
    	$product = $this->input->post('product');
    	$desc = $this->input->post('editor1');
    	$user = $this->session->userdata('userid');
    	$tgl = date('Y-m-d H:i:s');

        // echo $desc;

    	if($sbt == 'SAVE'){
    		$data = array(
    				'product_id' => $product,
    				'description' => $desc,
    				'Created_by' => $user,
    				'Created_date' => $tgl
    		);

    		$this->M_Moq->save_moq($data);

            $data_prod = array('have_moq' => 1);
            $sql = $this->M_Moq->update_product($data_prod, $product);
            if(!$sql){
                redirect('Moq/edit?product_id='.$product);
            }else{
                redirect('Moq');
            }
    	}else{
            $data = array(
                    'description' => $desc,
                    'Updated_by' => $user,
                    'Updated_date' => $tgl
            );

            $sql = $this->M_Moq->update_moq($data, $product);
            if(!$sql){
                redirect('Moq/edit?product_id='.$product);
            }else{
                redirect('Moq');
            }
        }

        
        // else{
        //    
        // }
    }

    function detail(){
        $product_id = $_GET['product_id'];

        $data['_detail'] = $this->M_Moq->get_detail($product_id);
        $this->load->view('factory/detail_moq',$data);
    }


}