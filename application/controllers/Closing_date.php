
<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Closing_date extends CI_Controller {

    function __construct() {
        parent::__construct();
       $this->load->model(array('M_period'));
        if (!$this->session->userdata('userid_1')) {
            redirect('login');
        }
    }

    public function index() {
        $data['title'] = 'Master Closing Date';
        $data['tutup']  = $this->M_period->get_closing();
        $this->template->display('accounting/closing_date', $data);
    }

    function input_period() {
        $tgl = addslashes($this->input->post('Period'));
        $this->session->set_userdata('Closing_date', $tgl);
        redirect('Closing_date');
    }

    function input_closing() {
        $tgl = New DateTime($this->input->post('Periode'));
        $periode = date_format($tgl, "Y-m-d");
        $data = array('tanggal' =>  ($periode));
        $this->M_period->simpan($data);
        $this->session->set_userdata('closing_date_1', date_format($tgl, 'd/m/Y'));
        redirect('Closing_date');
    }

}
