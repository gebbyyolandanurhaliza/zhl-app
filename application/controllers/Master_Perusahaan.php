<?php

/**
 * Created by PhpStorm.
 * User: rezai
 * Date: 4/15/2017
 * Time: 9:54 AM
 */
class Master_Perusahaan extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model(array('M_Mst_Perusahaan'));
        if (!$this->session->userdata('userid_1')) {
            redirect('login');
        }
    }

    public function index()
    {
        $data["tampil_perusahaan"] = $this->M_Mst_Perusahaan->select_perusahaan();
        $this->template->display('kas_kecil/master/master_perusahaan',$data);
    }

    function cek_kodeperusahaan(){
        $id = $this->input->get('id');
        $data["cekkodeperusahaan"] = $this->M_Mst_Perusahaan->cek_perusahaan($id);
        $this->load->view("kas_kecil/ajax/cek_kodeperusahaan", $data);
    }

    function input_KodePerusahaan() {
        $CodeCompany = addslashes($this->input->post('KodePerusahaan'));
        $CompanyName = addslashes($this->input->post('NamaPerusahaan'));
        $CompanyAddress = addslashes($this->input->post('AlamatPerusahaan'));

        $CreatedBy = addslashes($this->input->post('CreatedBy'));
        $CreatedDate = addslashes($this->input->post('CreatedDate'));
        $IPAddress = addslashes($this->input->post('IPAddress'));
        $tombol = $this->input->post('sbt');
        /* $CreatedPeriod = date_create_from_format("d/m/Y", date('d') . '/' . $this->session->userdata('periode_1'));
         $tglPeriod = date_format($CreatedPeriod, "Y-m-d");
        */ if ($tombol == 'Save') {
            $data = array(
                'IDPerusahaan' => $CodeCompany,
                'NamaPerusahaan' => $CompanyName,
                'AlamatPerusahaan'=>$CompanyAddress,
                /*'Created_period' => $tglPeriod,*/
                'CreatedBy' => $CreatedBy,
                'CreatedDate' => $CreatedDate,
                'IPAddress' => $IPAddress
            );
            $this->M_Mst_Perusahaan->input_kodeperusahaan($data);


        } else {
            $data1 = array(
                'NamaPerusahaan' => $CompanyName,
                'AlamatPerusahaan'=>$CompanyAddress,
                /*'Updated_period' => $tglPeriod,*/
                'UpdatedBy' => $CreatedBy,
                'updatedDate' => $CreatedDate,
                'IPAddress' => $IPAddress
            );
            $this->M_Mst_Perusahaan->update_kodeperusahaan($CodeCompany, $data1);
        }
        $this->session->set_flashdata('message', pesan('Create Record Success', pesan_sukses()));
        redirect('Master_Perusahaan');
    }

}