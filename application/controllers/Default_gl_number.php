
<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Default_gl_number extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model(array('M_gl_number'));
        if (!$this->session->userdata('userid_1')) {
            redirect('login');
        }
    }

    public function index() {
        $data['title'] = 'Master COA';
        $data["GroupCOA"] = $this->M_gl_number->select_group();
        $data["tampil_coa"] = $this->M_gl_number->select_gl();
        $data["list_group"] = $this->M_gl_number->list_gl();
        $data["list_COA"] = $this->M_gl_number->list_COA();
        $this->template->display('accounting/default_gl', $data);
    }

    function input_group_COA() {
        $GroupCOA = addslashes($this->input->post('GroupCOA'));
        $data = array(
            'GroupName' => $GroupCOA
        );
        if (!empty($GroupCOA)) {
            $this->M_gl_number->input_group_COA($data);
        } else {
            redirect('default_gl_number');
        }
    }

    function input_COA() {
        $id_gl = addslashes($this->input->post('id_gl'));
        $NoCOA = addslashes($this->input->post('NoCOA'));
        $AccountName = addslashes($this->input->post('AccountName'));
        $GroupCOA = addslashes($this->input->post('GroupCOA'));
        $RegNo = addslashes($this->input->post('RegNo'));
        $CreatedBy = addslashes($this->input->post('CreatedBy'));
        $CreatedDate = addslashes($this->input->post('CreatedDate'));
        $IPAddress = addslashes($this->input->post('IPAddress'));
        $btn = $this->input->post('btn');

        if ($btn == 'Save') {
            $data = array(
                'NoCOA' => $NoCOA,
                'AccountName' => $AccountName,
                'RegNo' => $RegNo,
                'GroupCOA' => $GroupCOA,
                'Balance' => 0,
                'created_by' => $CreatedBy,
                'created_date' => $CreatedDate,
                'ip_address' => $IPAddress
            );
            $this->M_gl_number->input_COA($data);
        } else if ($btn == 'Update') {
            $data_update = array(
                'NoCOA' => $NoCOA,
                'AccountName' => $AccountName,
                'RegNo' => $RegNo,
                'GroupCOA' => $GroupCOA,
                'Balance' => 0,
                'updated_by' => $CreatedBy,
                'updated_date' => $CreatedDate,
                'ip_address' => $IPAddress
            );
            $this->M_gl_number->update_coa($id_gl, $data_update);
        }
        redirect('default_gl_number');
    }

}
