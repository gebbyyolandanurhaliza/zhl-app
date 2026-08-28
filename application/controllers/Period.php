
<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class period extends CI_Controller {

    function __construct() {
        parent::__construct();
       $this->load->model(array('M_period'));
        if (!$this->session->userdata('userid_1')) {
            redirect('login');
        }
    }

    public function index() {
        $data['title'] = 'Master Period';
        $this->template->display('accounting/period', $data);
    }

    function input_period() {
        $tgl = addslashes($this->input->post('Period'));
        $this->session->set_userdata('periode', $tgl);
        redirect('Period');
    }
    
    function Posting(){
        $data['message']=$this->session->flashdata('message');
        $this->template->display('accounting/Posting', $data);
    }
    
    function exe_post(){
        $Period = $this->input->post('Period')."/".date("d");
        $created_by = $this->session->userdata('userid_1');
        $ip_address = $_SERVER['REMOTE_ADDR'];
        $data = array(
            'p_periode' => $Period,
            'p_created_by' => $created_by,
            'p_ipddress' => $ip_address
        );
        $this->M_period->exe_post($data);
        $this->session->set_flashdata('message', pesan("The transaction has been successfully saved with the Period : $Period", pesan_info()));
        redirect('Period/Posting');
    }

}
