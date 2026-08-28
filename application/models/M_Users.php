<?php

class M_Users extends CI_Model {

    var $tblUser = 'zhl_gen_tbl_user';

    function __construct() {
        parent::__construct();
    }

    function insert_profile($data){
        $this->db->insert($this->tblUser, $data);
        redirect('Manage_User');
    }
           
    function get_all_user() {
        $this->db->select('*');
        $this->db->where('notactive=0');
        $sql_product = $this->db->get($this->tblUser);
        return $sql_product->result();
    }

    public function tampil_user($userid) {
        $this->db->select('*');
        $this->db->where('userid', $userid);
        $sql_product = $this->db->get('zhl_vw_gen_mst_user');
        return $sql_product->result();
    }

    function update_profile($id, $data) {
        $this->db->where('userid', $id);
        $this->db->update($this->tblUser, $data);
        return TRUE;
    }
    
 function get_group(){
        $this->db->select('user_group_id, user_group_name');
        $this->db->from('zhl_gen_tbl_utl_user_group');
       $sql = $this->db->get();
        if ($sql->num_rows() > 0) {
            foreach ($sql->result_array() as $row) {
                $result[$row['user_group_id']] = ucwords(strtolower($row['user_group_name']));
            }
            return $result;
        }
        else{
            echo "Not data avaible";
        }
    }
    
    function get_position(){
        $this->db->select('position_id, position_name');
        $this->db->from('zhl_gen_tbl_mst_position');
       $sql = $this->db->get();
        if ($sql->num_rows() > 0) {
            foreach ($sql->result_array() as $row) {
                $result[$row['position_id']] = ucwords(strtolower($row['position_name']));
            }
            return $result;
        }
        else{
            echo "Not data avaible";
        }
    }
}
