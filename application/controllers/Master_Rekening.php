<?php

/**
 * Created by PhpStorm.
 * User: rezai
 * Date: 4/15/2017
 * Time: 11:44 AM
 */
class Master_Rekening extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model(array('M_KursNew','M_Mst_Bank','M_Mst_Perusahaan','M_Mst_Rekening'));
        if (!$this->session->userdata('userid_1')) {
            redirect('login');
        }
    }
    public function index() {
        $data["currency"] = $this->M_KursNew->select_currency();
        $data["list_group_cur"] = $this->M_KursNew->list_currency();
        $data["list_group_bank"] = $this->M_Mst_Bank->list_bank();
        $data["list_group_company"] = $this->M_Mst_Perusahaan->list_perusahaan();
        $data["tampil_rekeningbank"] = $this->M_Mst_Rekening->select_rekening();
        $this->template->display('kas_kecil/master/master_rekening',$data);
    }

    function input_NoRek() {
        $NoBankAcc = addslashes($this->input->post('NoRekBank'));
        $AccountName = addslashes($this->input->post('NamaRekBank'));
        /*$GroupCOA = addslashes($this->input->post('GroupCOA'));
        $id_journal = addslashes($this->input->post('id_journal'));*/
        $currency_id = addslashes($this->input->post('RegNo1'));
        $bank_id = addslashes($this->input->post('RegNo2'));
        $company_id = addslashes($this->input->post('RegNo3'));
        $CreatedBy = addslashes($this->input->post('CreatedBy'));
        $CreatedDate = addslashes($this->input->post('CreatedDate'));
        $IPAddress = addslashes($this->input->post('IPAddress'));
        $tombol = $this->input->post('sbt');
        /* $CreatedPeriod = date_create_from_format("d/m/Y", date('d') . '/' . $this->session->userdata('periode_1'));
        $tglPeriod = date_format($CreatedPeriod, "Y-m-d");
       */  if ($tombol == 'Save') {
            $data = array(
                'NoRek' => $NoBankAcc,
                'NamaRekening' => $AccountName,
                'IDMataUang' => $currency_id,
                'IDBank' => $bank_id,
                'IDPerusahaan' => $company_id,
               /* 'created_periode' => $tglPeriod,*/
                'CreatedBy' => $CreatedBy,
                'CreatedDate' => $CreatedDate,
                'IPAddress' => $IPAddress
            );
            $this->M_Mst_Rekening->input_rekening($data);


        } else {
            $data1 = array(

                'NamaRekening' => $AccountName,
                'IDMataUang' => $currency_id,
                'IDMataUang' => $currency_id,
                'IDBank' => $bank_id,
                'IDPerusahaan' => $company_id,
                /* 'created_periode' => $tglPeriod,*/
                'UpdatedBy' => $CreatedBy,
                'updatedDate' => $CreatedDate,
                'IPAddress' => $IPAddress
            );
            $this->M_Mst_Rekening->update_rekening($NoBankAcc, $data1);
        }
        $this->session->set_flashdata('message', pesan('Create Record Success', pesan_sukses()));
        redirect('Master_Rekening');
    }

    function cek_rekbank(){
        $id = $this->input->get('id');
        $data["cekkoderek"] = $this->M_Mst_Rekening->cek_rek($id);
        $this->load->view("kas_kecil/ajax/cek_nomorrek", $data);
    }

}