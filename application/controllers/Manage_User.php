<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Manage_User extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model(array('M_Users'));
        // Load encrypt library
        $this->load->library('encrypt');
        // Load form validation library
        $this->load->library('form_validation');
        if (!$this->session->userdata('userid_1')) {
            redirect('login');
        }
    }

    public function index() {

        $data['GroupID'] = $this->M_Users->get_group();
        $data['PositionID'] = $this->M_Users->get_position();
        $data['daftar'] = $this->M_Users->get_all_user();
        $this->template->display('utility/manage_user', $data);
    }

    function inactive_user() 
    {
        $idu = addslashes($this->input->get('id'));
        $data = array(
            'notactive' =>  1,
            'updated_by'    => $this->session->userdata('userid_1'),
            'updated_date'  => date('Y-m-d H:i:s')
        );
            $this->M_Users->update_profile($idu,$data);
            $this->session->set_flashdata('message', pesan('Delete Record Success', pesan_sukses()));
            redirect(site_url('Manage_User'));
    }

    function insert_profile() {
        $data['daftar'] = $this->M_Users->get_all_user();
        //VALIDATION   
        $this->form_validation->set_rules('firstname', 'Firstname', 'required|min_length[3]|max_length[12]');
        $this->form_validation->set_rules('lastname', 'Lastname', '');
        $this->form_validation->set_rules('email', 'Email', 'required|min_length[3]');
        $this->form_validation->set_rules('mobilenumber', 'mobilenumber', '');
        $this->form_validation->set_rules('group', 'Group', 'required');
        $this->form_validation->set_rules('pass', 'Password', 'required');
        $this->form_validation->set_rules('userid', 'User ID', 'required');
        $this->form_validation->set_rules('pass', 'Password', 'required');

        //PARAMETER
        $firstname = addslashes($this->input->post('firstname'));
        $lastname = addslashes($this->input->post('lastname'));
        $email = addslashes($this->input->post('email'));
        $photo = addslashes($this->input->post('photo'));
        $position = addslashes($this->input->post('position'));
        $mobilenumber = addslashes($this->input->post('mobilenumber'));
        $group = addslashes($this->input->post('group'));
        $userid = addslashes($this->input->post('userid'));
        //$pass = addslashes($this->input->post('pass'));
		$pass = md5(sha1(strtolower($this->input->post('pass'))));
        $jabatan = addslashes($this->input->post('jabatan'));

        if ($this->form_validation->run() == FALSE) {
            $this->template->display('utility/manage_user', $data);
        } else {
            //Insert Argument
            $data = array(
                'groupid' => $group,
                'userid' => $userid,
                'userpassword' => $pass,
                'firstname' => $firstname,
                'lastname' => $lastname,
                'mobilenumber' => $mobilenumber,
                'position_id' => $position,
                'photo' => '-',
                'email' => $email,
                'jabatan' => $jabatan,
                'created_by'    => $this->session->userdata('userid_1'),
                'created_date'  => date('Y-m-d H:i:s')
            );
            $this->M_Users->insert_profile($data);
        }
    }

    function change_password() {
        $this->form_validation->set_rules('pass1', 'pass1', 'required');
        $this->form_validation->set_rules('pass2', 'pass2', 'required');
        $this->form_validation->set_rules('old_password', 'old_password', 'required');

        $username = $this->input->post('username');
        $pass2 = md5(sha1(strtolower($this->input->post('pass2'))));

        $data = array(
            'userpassword' => $pass2,
        );
        $this->M_Users->update_profile($username, $data);
        redirect('User_Profile?id=' . $username);
    }
    
    function update_profile() {
        $idu = addslashes($this->input->post('userid'));
        $firstname = addslashes($this->input->post('firstname'));
        $lastname = addslashes($this->input->post('lastname'));
        $mobilenumber = addslashes($this->input->post('mobilenumber'));
        $email = addslashes($this->input->post('email'));
        $jabatan = addslashes($this->input->post('jabatan'));
        $group = addslashes($this->input->post('group'));
        $data = array(
            'firstname' => $firstname,
            'lastname' => $lastname,
            'mobilenumber' => $mobilenumber,
            'email' => $email,
            'jabatan' => $jabatan,
            'groupid' =>  $group,
            'updated_by'    => $this->session->userdata('userid_1'),
            'updated_date'  => date('Y-m-d H:i:s')
        );
        $this->M_Users->update_profile($idu, $data);
        redirect('User_Profile?id='.$idu);
    }

}
