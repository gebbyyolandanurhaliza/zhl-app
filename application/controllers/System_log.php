
<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class system_log extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model(array('M_system_log'));

    }

    function index() {
    	$data['ind'] = $this->M_system_log->get_log_history();
        $this->template->display('log/log_list', $data);
    }

    function log_create() {
        $this->template->display('log/log_create');
    }

    function log_view() {
    	$data['log'] = $this->M_system_log->get_log($this->input->get('id'));
        $this->template->display('log/log_view', $data);
    }

    function log_save(){
        $skrg		= $this->input->post('date');
        $p_tanggal 	= date('Y-m-d H:i:s', strtotime($skrg)); //tanggal jurnal
        $prog		= $this->input->post('prog');
        $sub		= $this->input->post('sub');
        $isi		= $this->input->post('isi');

        $data = array(
        	'creator'   => $prog,
        	'tgl'       => $p_tanggal,
        	'isi'       => $isi,  	
        	'subjek'    => $sub
        );

        $this->M_system_log->simpan_log($data);

        redirect('System_log/index');
    }
}
