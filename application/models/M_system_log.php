<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class M_System_Log extends CI_Model {


    function get_log_history() {
    	$this->db->order_by('tgl','DESC');
        $result=$this->db->get('zhl_sistem_log');
        return $result->result();
    }

    function simpan_log($data){
        $this->db->insert('zhl_sistem_log',$data);
        return true;
    }

     function get_log($id){
       $this->db->where('id',$id);
       return $this->db->get('zhl_sistem_log')->result();
    }

}

?>