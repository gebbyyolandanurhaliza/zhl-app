<?php defined('BASEPATH') OR exit('No direct script access allowed');

/* 
 * Author : ITD16
 */

class Carrier extends CI_Controller{
    public function __construct() {
        parent::__construct();
        
        if(!$this->session->userdata('userid_1')){
            redirect('login');
        }
        
        date_default_timezone_set("Asia/Jakarta");
        $this->load->model(array('M_jenis_invoice'));
    }

    function index(){
        $data['_container'] = $this->M_jenis_invoice->container();
        $data['_port'] = $this->M_jenis_invoice->port();
        $data['_listcarrier'] = $this->M_jenis_invoice->listcarrier();
        $this->template->display('accounting/jenis_invoice/carrier', $data);
    }

    function save_carrier(){
        $cont = $this->input->post('cont');
        $contname = $this->input->post('ct_name');
        $port = $this->input->post('port');
        $pr_name = $this->input->post('pr_name');
        $user = $this->session->userdata('userid_1');
        $waktu = date('Y-m-d H:i:s');
        $harga = $this->input->post('price');
        $var = $this->input->post('exp');
        $date = str_replace('/', '-', $var);
        $exp = date('Y-m-d', strtotime($date));

        $submit = $this->input->post('sbt');

        $cek_carrier = $this->M_jenis_invoice->cekcarrier($cont, $port);

        if(empty($cek_carrier)){
            $data = array(
                'container_type' => $cont,
                'port' => $port,
                'Harga' => $harga,
                'container_name' => $contname,
                'port_name' => $pr_name,
                'expiredate' => $exp,
                'CreatedBy' => $user,
                'CreatedDate' => $waktu
            );
            $this->M_jenis_invoice->save_carrier($data);
        }
        else
        {
            $data = array(
                'Harga' => $harga,
                'container_name' => $contname,
                'port_name' => $pr_name,
                'expiredate' => $exp,
                'UpdatedBy' => $user,
                'UpdateDate' => $waktu
            );
            $this->M_jenis_invoice->update_carrier($data, $cont, $port);
        }
        redirect('Carrier');


    }

}