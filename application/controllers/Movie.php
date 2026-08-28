<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Movie extends CI_Controller {

    function __construct() {
        parent::__construct();
        if (!$this->session->userdata('userid_1')) {
            redirect('login');
        }
        $this->load->library('form_validation');
    }

    function index() {
        $data['url'] = $this->uri->segment(3);
        $this->template->display('tutorial/movie', $data);
    }

    

}
