<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class M_jenis_invoice extends CI_Model {
    public function __construct(){
        parent::__construct();
            $this->db2 = $this->load->database('db2', TRUE);
    }

    function port(){
        $sql = $this->db2->get('mar_vw_mst_port');
        if ($sql->num_rows() > 0) {
            $result[''] = "Select";
            foreach ($sql->result_array() as $row) {
                $result[$row['port_id']] = ucwords(strtolower($row['port_name']." - ".$row['country_name']));
            }
            return $result;
        }
        else{
            echo "";
        }
    }

    function container(){
        $sql = $this->db2->get('mar_tblmst_container');
        if ($sql->num_rows() > 0) {
            $result[''] = "Select";
            foreach ($sql->result_array() as $row) {
                $result[$row['container_id']] = ucwords(strtolower($row['container_name']));
            }
            return $result;
        }
        else{
            echo "";
        }
    }

    function list_cont(){
        return $this->db2->get('mar_tblmst_container')->result();
    }

    function cek_data($ct, $dest){
        $this->db->where('container_type', $ct);
        $this->db->where('dest_type', $dest);
        return $this->db->get('zhl_acc_master_barge')->result();
    }

    function listbarge($id){
        $this->db->where('dest_type',$id);
        return $this->db->get('zhl_acc_master_barge')->result();
    }

  

    function save_barge($data){
        $this->db->insert('zhl_acc_master_barge', $data);
    }

    function update_barge($data, $ct, $dest){
        $this->db->where('container_type', $ct);
        $this->db->where('dest_type', $dest);
        $this->db->update('zhl_acc_master_barge', $data);
    }

    function listcarrier(){
        return $this->db->get('zhl_acc_master_carrier')->result();
    }

    function save_carrier($data){
        $this->db->insert('zhl_acc_master_carrier', $data);
    }

    function update_carrier($data, $ct, $dest){
        $this->db->where('container_type', $ct);
        $this->db->where('port', $dest);
        $this->db->update('zhl_acc_master_carrier', $data);
    }

    function cekcarrier($ct, $dest){
        $this->db->where('container_type', $ct);
        $this->db->where('port', $dest);
        return $this->db->get('zhl_acc_master_carrier')->result();
    }


}