<?php

class M_gl_number extends CI_Model {

    var $tbl_coa = 'zhl_acc_master_gl';
    var $group_coa = 'zhl_acc_group_gl';

    function input_group_COA($data) {
        $this->db->insert($this->group_coa, $data);
        redirect('default_gl_number');
    }

    function input_coa_sp($data) {
        $this->db->query("call zhl_sp_acc_master_gl(?,?,?,?,?,?,?,?,?)", $data);
        redirect('default_gl_number');
    }

    function input_coa($data) {
        $this->db->insert('zhl_acc_master_gl', $data);
    }

    function update_coa($id, $data) {
        //$this->db->query("call sp_acc_master_gl(?,?,?,?,?,?,?,?)", $data);
        $this->db->where('gl_id', $id);
        $this->db->update($this->tbl_coa, $data);
    }

    function select_group() {
        //select group first
        $this->db->select('GroupName, id_group');
        $this->db->order_by('id_group');
        $sql_group = $this->db->get($this->group_coa);
        if ($sql_group->num_rows() > 0) {
            foreach ($sql_group->result() as $value) {
                $result[] = $value;
            }
            return $result;
        }
    }

    function select_gl() {
        $this->db->select('*');
        $this->db->order_by('RegNo');
        $sql_group = $this->db->get($this->tbl_coa);
        if ($sql_group->num_rows() > 0) {
            foreach ($sql_group->result() as $value) {
                $result[] = $value;
            }
            return $result;
        }
    }

    function list_gl() {
        $this->db->select('GroupName, id_group');
        $sql_group = $this->db->get($this->group_coa);
        if ($sql_group->num_rows() > 0) {
            $result[""] = "select";
            foreach ($sql_group->result_array() as $row) {
                $result[$row['id_group']] = ucwords(strtoupper($row['GroupName']));
            }
            return $result;
        }
    }

    function list_coa() {
        $this->db->select('*');
        $sql_group = $this->db->get('zhl_acc_master_coa');
        if ($sql_group->num_rows() > 0) {
            $result[""] = "select";
            foreach ($sql_group->result_array() as $row) {
                $result[$row['NoCOA']] = ucwords(strtoupper($row['NoCOA']));
            }
            return $result;
        }
    }

    function auto_coa($NoCOA) {
        $q = $this->db->query("SELECT * FROM `zhl_acc_master_coa` where NoCOA like %$NoCOA%");
        return $q;
    }

    function auto_coa_limit($NoCOA) {
        $q = $this->db->query("SELECT * FROM `zhl_acc_master_coa` where NoCOA like %$NoCOA% limit 10");
        return $q;
    }

}
