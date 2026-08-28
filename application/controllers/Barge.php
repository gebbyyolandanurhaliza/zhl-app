<?php defined('BASEPATH') OR exit('No direct script access allowed');

/* 
 * Author : ITD16
 */

class Barge extends CI_Controller{
    public function __construct() {
        parent::__construct();
        
        if(!$this->session->userdata('userid_1')){
            redirect('login');
        }
        
        date_default_timezone_set("Asia/Jakarta");
        $this->load->model(array('M_jenis_invoice'));
    }

    function index(){
        $data['list_cont'] = $this->M_jenis_invoice->list_cont();
        $data['_listbarge1'] = $this->M_jenis_invoice->listbarge(1);
        $data['_listbarge2'] = $this->M_jenis_invoice->listbarge(2);
        $this->template->display('accounting/jenis_invoice/barge', $data);
    }

    function save_1(){
        $contid = $this->input->post('id_cont');
        $contname = $this->input->post('cont_name');
        $expired = $this->input->post('exp');
        $harga = $this->input->post('price');
        $user = $this->session->userdata('userid_1');
        $waktu = date('Y-m-d H:i:s');
        echo "ada";
        echo count($contid);
        for($i=0; $i < count($contid); $i++){
            $date = str_replace('/', '-', $expired[$i]);
            $exp = date('Y-m-d', strtotime($date));
            
            $cek = $this->M_jenis_invoice->cek_data($contid[$i], 1);
            if(empty($cek)){
                echo "ada";
                $data = array(
                    'container_type' => $contid[$i],
                    'dest_type' => '1',
                    'container_name' => $contname[$i],
                    'Harga' => $harga[$i],
                    'CreatedBy' => $user,
                    'CreatedDate' => $waktu,
                    'expiredate' => $exp
                );
                $sql = $this->M_jenis_invoice->save_barge($data);
            }
            else
            {
                $data = array(
                    'Harga' => $harga[$i],
                    'container_name' => $contname[$i],
                    'UpdatedBy' => $user,
                    'UpdatedDate' => $waktu,
                    'expiredate' => $exp
                );
                $sql = $this->M_jenis_invoice->update_barge($data, $contid[$i], 1);
            }
            
        }

        redirect('Barge');
    }

    function save_2(){
        $contid = $this->input->post('id_cont');
        $contname = $this->input->post('cont_name');
        $expired = $this->input->post('exp');
        $harga = $this->input->post('price');
        $user = $this->session->userdata('userid_1');
        $waktu = date('Y-m-d H:i:s');
        echo "ada";
        echo count($contid);
        for($i=0; $i < count($contid); $i++){
            $date = str_replace('/', '-', $expired[$i]);
            $exp = date('Y-m-d', strtotime($date));
            
            $cek = $this->M_jenis_invoice->cek_data($contid[$i], 2);
            if(empty($cek)){
                echo "ada";
                $data = array(
                    'container_type' => $contid[$i],
                    'dest_type' => '2',
                    'container_name' => $contname[$i],
                    'Harga' => $harga[$i],
                    'CreatedBy' => $user,
                    'CreatedDate' => $waktu,
                    'expiredate' => $exp
                );
                $sql = $this->M_jenis_invoice->save_barge($data);
            }
            else
            {
                $data = array(
                    'Harga' => $harga[$i],
                    'container_name' => $contname[$i],
                    'UpdatedBy' => $user,
                    'UpdatedDate' => $waktu,
                    'expiredate' => $exp
                );
                $sql = $this->M_jenis_invoice->update_barge($data, $contid[$i], 2);
            }
            
        }

        redirect('Barge');
    }

    // function save_barge(){
    //     $cont = $this->input->post('cont');
    //     $dest = $this->input->post('dest');
    //     $harga = $this->input->post('price');
    //     $nama = $this->input->post('ct_name');
    //     $user = $this->session->userdata('userid_1');
    //     $waktu = date('Y-m-d H:i:s');
        
    //     $var = $this->input->post('exp');
    //     $date = str_replace('/', '-', $var);
    //     $exp = date('Y-m-d', strtotime($date));

    //     $submit = $this->input->post('sbt');
    //     // echo $submit;
    //     if($submit === 'Save'){
    //         $data = array(
    //             'container_type' => $cont,
    //             'dest_type' => $dest,
    //             'container_name' => $nama,
    //             'Harga' => $harga,
    //             'CreatedBy' => $user,
    //             'CreatedDate' => $waktu,
    //             'expiredate' => $exp
    //         );
    //         $cek = $this->M_jenis_invoice->cek_data($cont, $dest);
    //         if(empty($cek)){
    //             $sql = $this->M_jenis_invoice->save_barge($data);
    //         }  
    //     }else
    //     {
    //         $data = array(
    //             'Harga' => $harga,
    //             'container_name' => $nama,
    //             'UpdatedBy' => $user,
    //             'UpdatedDate' => $waktu,
    //             'expiredate' => $exp
    //         );
    //         $sql = $this->M_jenis_invoice->update_barge($data, $cont, $dest);
    //     }

    //     redirect('Barge');
    // }
    

}