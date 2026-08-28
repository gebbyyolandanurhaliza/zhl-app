<?php

/**
 * Created by PhpStorm.
 * User: rezai
 * Date: 4/17/2017
 * Time: 11:50 AM
 */
class Master_TipeTransaksi extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model(array('M_Mst_TypeTrn'));
        if (!$this->session->userdata('userid_1')) {
            redirect('login');
        }
    }

    public function index()
    {
        $data["tampil_typetrn"] = $this->M_Mst_TypeTrn->select_typetrn();
        $this->template->display('kas_kecil/master/master_tipe_transaksi',$data);
    }

    /*function cek_kodebank(){
        $id = $this->input->get('id');
        $data["cekkodebank"] = $this->M_Mst_Bank->cek_bank($id);
        $this->load->view("kas_kecil/ajax/cek_kodebank", $data);
    }*/

    function input_KodeTipeTrn() {
        $CodeTypeTrn = addslashes($this->input->post('KodeTipeTrn'));
        $TypeTrn = addslashes($this->input->post('TipeTrn'));

        $CreatedBy = addslashes($this->input->post('CreatedBy'));
        $CreatedDate = addslashes($this->input->post('CreatedDate'));
        $IPAddress = addslashes($this->input->post('IPAddress'));
        $tombol = $this->input->post('sbt');
         if ($tombol == 'Save') {
            $data = array(
                'IDType' => $CodeTypeTrn,
                'TipeTransaksi' => $TypeTrn,

                'CreatedBy' => $CreatedBy,
                'CreatedDate' => $CreatedDate,
                'IPAddress' => $IPAddress
            );
            $this->M_Mst_TypeTrn->input_kodetipetrn($data);


        } else {
            $data1 = array(
                'TipeTransaksi' => $TypeTrn,
                'UpdatedBy' => $CreatedBy,
                'updatedDate' => $CreatedDate,
                'IPAddress' => $IPAddress
            );
            $this->M_Mst_TypeTrn->update_kodetipetrn($CodeTypeTrn, $data1);
        }
        $this->session->set_flashdata('message', pesan('Create Record Success', pesan_sukses()));
        redirect('Master_TipeTransaksi');
    }


}