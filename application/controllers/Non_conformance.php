<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Non_conformance extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model(array('m_shipping'));
        $this->load->library('PHPExcel');

        if (!$this->session->userdata('userid_1')) {
            redirect('login');
        }
    }
    function index()
    {
        $data['nonconformance'] = $this->m_shipping->mon_noncormance();

        // echo json_encode($data);
        // die;
        $this->template->display('shipping/mon/nonconformance', $data);
    }
}
