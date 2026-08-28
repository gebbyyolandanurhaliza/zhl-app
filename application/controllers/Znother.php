<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/* 
 * Author : Ismo Broto
 */

class Znother extends CI_Controller{
    
    public function __construct() {
        parent::__construct();
    }
    
    public function index(){
        $seg3   = $this->uri->segment(3);
        if($seg3 === FALSE){
            redirect(site_url('home'));
        }elseif ($seg3 == 503) {
            $this->load->view('utility/other/page_503');
        }else{
            redirect(site_url('home'));
        }
    }
}