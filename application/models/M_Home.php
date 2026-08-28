<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class M_Home extends CI_Model {

    private $table  = array(
        'MasterCurrecy' => 'zhl_gen_tbl_mst_currency',
        'TableUser'     => 'zhl_gen_tbl_user',
        'ChatRoom'      => 'zhl_gen_tbl_utl_chatroom'
    );
    private $view   = array(
        'ChatRoom'      => 'zhl_gen_vw_utl_chatroom'
    );
    private $primary= array(
        'ChatRoom'      => 'id_record'
    );
    
    function __construct() {
        parent::__construct();
    }

// get all
    function get_kurs() {
        $this->db->order_by('periode', 'ASC');
        $result = $this->db->get('zhl_gen_tbl_mst_currency');
        return $result->result();
    }

    function get_kurs_new() {
        $this->db->order_by('periode', 'DESC');
        $this->db->limit(1);
        $get = $this->db->get('zhl_acc_tbl_trn_kurs');

        $this->db->where('periode',$get->row()->periode);
        $result = $this->db->get('zhl_acc_tbl_trn_kurs');

        return array(
                'result' => $result->result(),
                'get'  => $get->row()->periode,
            );
    }

    function get_user() {
        $this->db->order_by('firstname', 'ASC');
        $result = $this->db->get('zhl_gen_tbl_user');
        return $result->result();
    }
    
    // Chat room model function
    function selectChat(){
        $this->db->order_by($this->primary['ChatRoom'], 'ASC');
//        $this->db->where('CONVERT(date,Date) = CONVERT(date,GETDATE())');
        $get    = $this->db->get($this->view['ChatRoom']);
        return $get;
    }
    
    function insertChat($data){
        $this->db->insert($this->table['ChatRoom'], $data);
    }
}
