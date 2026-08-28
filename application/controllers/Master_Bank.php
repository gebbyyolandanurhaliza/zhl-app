<?php

/**
 * Created by PhpStorm.
 * User: rezai
 * Date: 4/13/2017
 * Time: 2:27 PM
 */
class Master_Bank extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model(array('M_Mst_Bank'));
        if (!$this->session->userdata('userid_1')) {
            redirect('login');
        }
    }

    public function index()
    {
        $data["tampil_bank"] = $this->M_Mst_Bank->select_bank();
        $this->template->display('kas_kecil/master/master_bank',$data);
    }

    function cek_kodebank(){
        $id = $this->input->get('id');
        $data["cekkodebank"] = $this->M_Mst_Bank->cek_bank($id);
        $this->load->view("kas_kecil/ajax/cek_kodebank", $data);
    }

    function input_KodeBank() {
        $CodeBank = addslashes($this->input->post('KodeBank'));
        $BankName = addslashes($this->input->post('NamaBank'));
        $BankAddress = addslashes($this->input->post('AlamatBank'));

        $CreatedBy = addslashes($this->input->post('CreatedBy'));
        $CreatedDate = addslashes($this->input->post('CreatedDate'));
        $IPAddress = addslashes($this->input->post('IPAddress'));
        $tombol = $this->input->post('sbt');
       /* $CreatedPeriod = date_create_from_format("d/m/Y", date('d') . '/' . $this->session->userdata('periode_1'));
        $tglPeriod = date_format($CreatedPeriod, "Y-m-d");
       */ if ($tombol == 'Save') {
            $data = array(
                'IDBank' => $CodeBank,
                'NamaBank' => $BankName,
                'AlamatBank'=>$BankAddress,
                /*'Created_period' => $tglPeriod,*/
                'CreatedBy' => $CreatedBy,
                'CreatedDate' => $CreatedDate,
                'IPAddress' => $IPAddress
            );
            $this->M_Mst_Bank->input_kodebank($data);


        } else {
            $data1 = array(
                'NamaBank' => $BankName,
                'AlamatBank'=>$BankAddress,
                /*'Updated_period' => $tglPeriod,*/
                'UpdatedBy' => $CreatedBy,
                'updatedDate' => $CreatedDate,
                'IPAddress' => $IPAddress
            );
            $this->M_Mst_Bank->update_kodebank($CodeBank, $data1);
        }
        $this->session->set_flashdata('message', pesan('Create Record Success', pesan_sukses()));
        redirect('Master_Bank');
    }


}