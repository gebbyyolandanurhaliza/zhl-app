<?php defined('BASEPATH') OR exit('No direct script access allowed');

/* 
 * Author : Ismo Broto
 */
class MasterEmployee extends CI_Controller{
    public function __construct() {
        parent::__construct();

        //is_maintenance(FALSE, $this->session->userdata('userid_1'));
        
        if(!$this->session->userdata('userid_1')){
            redirect('login');
        }
        
        date_default_timezone_set("Asia/Jakarta");
        $this->load->model(array('M_Fin_Master'));
    }
    
    function index(){
        $data   = array(
            '_selectEmployee'   => $this->M_Fin_Master->selectAllEmployee()->result()
        );
        $this->template->display('finance/master/employee/index',$data);
    }
    function getEmployeForEdit(){
        $headerID   = decode_str($this->input->post('txtHeaderID'));
        $getEmp     = $this->M_Fin_Master->getEmployeeByID($headerID);
        $data       = array(
            'headID'    => encode_str($getEmp->header_id),
            'fullName'  => $getEmp->full_name,
            'deptEmp'   => $getEmp->department
        );
        echo json_encode($data);
    }
    function insertDataEmployee(){
        $data   = array(
            'full_name'     => $this->input->post('txtFullName'),
            'department'    => $this->input->post('txtDepartment'),
            'created_by'    => $this->session->userdata('userid_1'),
            'created_date'  => date('Y-m-d H:i:s')
        );
        $this->M_Fin_Master->insertDataEmployee($data);
        redirect('MasterEmployee');
    }
    function updateDataEmployee(){
        $header = decode_str($this->input->post('txtHeaderID'));
        $data   = array(
            'full_name'     => $this->input->post('txtFullName'),
            'department'    => $this->input->post('txtDepartment'),
            'updated_by'    => $this->session->userdata('userid_1'),
            'updated_date'  => date('Y-m-d H:i:s')
        );
        $this->M_Fin_Master->updateDataEmployee($header,$data);
        redirect('MasterEmployee');
    }
}