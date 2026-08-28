
<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Master_COA extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model(array('M_Mst_COA'));
        if (!$this->session->userdata('userid_1')) {
            redirect('login');
        }
    }

    public function index()
    {
        $data["user_id"] = $this->session->userdata('userid_1');
        $data["group_id"] = $this->session->userdata('groupid_1');
        $data["GroupCOA"] = $this->M_Mst_COA->select_group();
        $data["GroupJournal"] = $this->M_Mst_COA->select_group_journal();
        $data["tampil_coa"] = $this->M_Mst_COA->select_coa();
        // echo "<pre>";
        // print_r($data["tampil_coa"]);
        // echo "</pre>";
        // die;
        $data["list_group"] = $this->M_Mst_COA->list_coa();
        $data["list_dept"] = $this->M_Mst_COA->list_department();
        $data['message'] = $this->session->flashdata('message');
        $this->template->display('accounting/master_coa', $data);
    }

    public function old()
    {
        $data["tampil_coa"] = $this->M_Mst_COA->select_coa_old();
        $data['message'] = $this->session->flashdata('message');
        $this->template->display('accounting/master_coa_old', $data);
    }

    function input_group_COA()
    {
        $GroupCOA = addslashes($this->input->post('GroupCOA'));
        $data = array(
            'GroupName' => $GroupCOA
        );
        if (!empty($GroupCOA)) {
            $this->M_Mst_COA->input_group_COA($data);
        } else {
            redirect('Master_COA');
        }
    }
    function cek_coa()
    {
        $id = $this->input->get('id');
        $data["cekcoa"] = $this->M_Mst_COA->cek_account($id);
        $this->load->view("accounting/ajax/cek_coa", $data);
    }

    function input_COA()
    {
        $NoCOA = addslashes($this->input->post('NoCOA'));
        $AccountName = addslashes($this->input->post('AccountName'));
        $GroupCOA = addslashes($this->input->post('GroupCOA'));
        $id_journal = addslashes($this->input->post('id_journal'));
        $id_coa = addslashes($this->input->post('RegNo'));
        $id_new_coa = addslashes($this->input->post('NewCOA'));
        $CreatedBy = addslashes($this->input->post('CreatedBy'));
        $CreatedDate = addslashes($this->input->post('CreatedDate'));
        $IPAddress = addslashes($this->input->post('IPAddress'));
        $id_department = addslashes($this->input->post('DeptNo'));
        $dept = substr($id_department, -1);
        $company_id = addslashes($this->input->post('company_id'));
        $tombol = $this->input->post('sbt');
        $status = false;
        // $CreatedPeriod = date_create_from_format("d/m/Y", date('d') . '/' . $this->session->userdata('periode_1'));
        // $tglPeriod = date_format($CreatedPeriod, "Y-m-d");
        $periode = $this->session->userdata('periode_1');
        $createdPeriod = date_create_from_format("d/m/Y", date('d') . '/' . $periode);

        if ($createdPeriod !== false) {
            $tglPeriod = date_format($createdPeriod, "Y-m-d");
        } else {
            // Handle the error, e.g., log it or set $tglPeriod to a default value
            $tglPeriod = ''; // Or some default value, or error handling
            log_message('error', 'Invalid date format: ' . $periode);
        }

        if ($tombol == 'Save') {
            $status = true;

            $data = array(
                'NoCOA' => $NoCOA,
                'AccountName' => $AccountName,
                'GroupCOA' => $id_coa,
                'GroupJournal' => $id_journal,
                'created_periode' => $tglPeriod,
                'created_by' => $CreatedBy,
                'created_date' => $CreatedDate,
                'ip_address' => $IPAddress,
            );
            $this->M_Mst_COA->input_COA($data);

            $zhl_zht = array(
                'NoCOA' => $NoCOA,
                'id_department' => $dept,  
                'company_id' => $company_id,  
                'AccountName' => $AccountName        
            );
            $this->M_Mst_COA->input_data_zhl_zht($zhl_zht);  

            $data_saldo = array(
                'nocoa' => $NoCOA,
                'periode_bulan' => '1',
                'periode_tahun' => '2017',
                'periode_tanggal' => '2017-01-01',
                'periode_string' => '201701',
                'debet' => 0,
                'kredit' => 0,
                'debet_SGD' => 0,
                'kredit_SGD' => 0,
                'created_by' => $CreatedBy,
                'created_date' => $CreatedDate,
                'ip_address' => $IPAddress
            );
            $this->M_Mst_COA->input_saldo_awal($data_saldo);

            
        
        } else {
            $data1 = array(
                'AccountName' => $AccountName,
                'GroupCOA' => $id_coa,
                'GroupJournal' => $id_journal,
                'created_periode' => $tglPeriod,
                'updated_by' => $CreatedBy,
                'updated_date' => $CreatedDate,
                'ip_address' => $IPAddress,
            );

            $this->M_Mst_COA->update_COA($NoCOA, $data1);

            $zhl_zht = array(
                'id_department' => $dept,  
                'company_id' => $company_id,  
                'AccountName' => $AccountName        
            );
            $this->M_Mst_COA->update_data_zhl_zht($NoCOA, $dept,$company_id, $zhl_zht); 
        }
        $this->session->set_flashdata('message', pesan('Create Record Success', pesan_sukses()));
        redirect('Master_COA');
    }

    function delete_COA()
    {
        $NoCOA = addslashes($this->input->post('NoCOA'));
        $id_department = addslashes($this->input->post('DeptNo'));
        $dept = substr($id_department, -1);
        $company_id = addslashes($this->input->post('company_id'));
        $company = substr($company_id, -1);
        $data = array(
            'isDelete' => 1,      
        );
        
        $cekCoa = $this->M_Mst_COA->cek_jurnal_coa($NoCOA, $id_department);
        $cekCoa2 = $this->M_Mst_COA->cek_jurnal_coa_tims($NoCOA, $id_department);

        if ($cekCoa < 1 || $cekCoa2 < 1) {
            $this->M_Mst_COA->coa_deleted($NoCOA, $dept, $company, $data);
            $this->session->set_flashdata('message', pesan('Succes to deleted COA (soft delete).', pesan_sukses()));
        } else {
            $this->session->set_flashdata('message', pesan('Failed to removed data. COA have transaction Jurnal', pesan_error()));
        }
    }
}
