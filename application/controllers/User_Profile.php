<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class User_Profile extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
        $this->load->model(array('M_Users'));
        if (!$this->session->userdata('userid_1')) {
            redirect('login');
        }
    }

    public function index() {
        $id = addslashes($this->input->get('id'));
        if($id <> '') {
            $userid = addslashes($this->input->get('id'));
        }else{
            $userid = $this->session->userdata('userid_1');
        }
        
        $data['profile'] = $this->M_Users->tampil_user($userid);
        $data['GroupID'] = $this->M_Users->get_group();
        $data['PositionID'] = $this->M_Users->get_position();
        $data['userid'] = $userid;
        
        $this->template->display('utility/users', $data);
    }
    function do_upload() {
        $idu = addslashes($this->input->post('username'));
        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size'] = '2048';
        $new_name = $idu;
        $config['file_name'] = $new_name;
        
        $this->load->library('upload', $config);
        $this->upload->overwrite = true;

        if (!$this->upload->do_upload()) {
            $error = array('error' => $this->upload->display_errors());

            redirect('User_Profile?id='.$idu);
        } else {
            $data = array('upload_data' => $this->upload->data());

            redirect('User_Profile?id='.$idu);
        }
    }
    function update_profile() {
        $idu = addslashes($this->input->post('userid'));
        $firstname = addslashes($this->input->post('firstname'));
        $lastname = addslashes($this->input->post('lastname'));
        $mobilenumber = addslashes($this->input->post('mobilenumber'));
        $interest = addslashes($this->input->post('interest'));
        $accupation = addslashes($this->input->post('accupation'));
        $about = addslashes($this->input->post('about'));
        $email = addslashes($this->input->post('email'));
        $data = array(
            'firstname' => $firstname,
            'lastname' => $lastname,
            'mobilenumber' => $mobilenumber,
            'interest' => $interest,
            'accupation' => $accupation,
            'about' => $about,
            'email' => $email
        );
        $this->M_Users->update_profile($idu, $data);
        redirect('User_Profile?id='.$idu);
    }

}
