<?php

class M_Mst_COA extends CI_Model
{

    var $tbl_coa = 'zhl_acc_master_new_coa';
    var $group_coa = 'zht_acc_group_coa_tims';
    var $dept_coa = 'zhl_account_department';

    function input_group_COA($data)
    {
        $this->db->insert($this->group_coa, $data);
        redirect('Master_COA');
    }

    function input_coa($data)
    {
        $this->db->insert($this->tbl_coa, $data);
    }

    function input_saldo_awal($data)
    {
        $this->db->insert('zhl_acc_tbl_trn_saldoawal', $data);
        redirect('Master_COA');
    }

    function input_data_zhl_zht($data)
    {
        $this->db->insert('zhl_zht_coa_transaction', $data);
        redirect('Master_COA');
    }
    function update_data_zhl_zht($NoCOA, $dept, $company_id, $data)
    {
        $this->db->where('NoCOA', $NoCOA);
        $this->db->where('id_department', $dept);
        $this->db->where('company_id', $company_id);
        $this->db->update('zhl_zht_coa_transaction', $data);
    }

    function update_coa($id, $data)
    {
        $this->db->where('NoCOA', $id);
        $this->db->update($this->tbl_coa, $data);
    }

    function list_coa_turnover()
    {
        $this->db->select('*');
        $this->db->from($this->tbl_coa);
        $this->db->where('GroupCOA', '4');
        $this->db->order_by('NoCOA', 'asc');
        return $this->db->get()->result();
    }

    function cek_account($id)
    {
        $this->db->select('*');
        $this->db->where('NoCOA', $id);
        $sql_group = $this->db->get($this->tbl_coa);
        if ($sql_group->num_rows() > 0) {
            foreach ($sql_group->result() as $value) {
                $result[] = $value;
            }
            return $result;
        }
    }

    function select_group()
    {
        //select group first
        $this->db->select('GroupName, id_group');
        $sql_group = $this->db->get($this->group_coa);
        if ($sql_group->num_rows() > 0) {
            foreach ($sql_group->result() as $value) {
                $result[] = $value;
            }
            return $result;
        }
    }

    function select_group_journal()
    {
        //select group first
        $this->db->select('group, id');
        $sql_group = $this->db->get('zhl_gen_tbl_mst_vendor_group');
        if ($sql_group->num_rows() > 0) {
            $result[""] = "Select";
            foreach ($sql_group->result_array() as $row) {
                $result[$row['id']] = ucwords(strtoupper($row['group']));
            }
            return $result;
        }
    }

    function select_coa()
    {
        $this->db->select('*');
        $this->db->order_by('GroupCOA');
        $sql_product = $this->db->get('zhl_vw_new_coa_dept_code');
        if ($sql_product->num_rows() > 0) {
            foreach ($sql_product->result() as $row) {
                $result[] = $row;
            }
        }
        return $result;
    }

    function select_coa_old()
    {
        $this->db->select('*');
        $this->db->order_by('id_coa');
        $sql_product = $this->db->get('zhl_vw_acc_mst_coa');
        if ($sql_product->num_rows() > 0) {
            foreach ($sql_product->result() as $row) {
                $result[] = $row;
            }
        }
        return $result;
    }

    function list_coa()
    {
        $this->db->select('GroupName, id_group');
        $sql_group = $this->db->get($this->group_coa);
        if ($sql_group->num_rows() > 0) {
            $result[""] = "Select";
            foreach ($sql_group->result_array() as $row) {
                $result[$row['id_group']] = ucwords(strtoupper($row['GroupName']));
            }
            return $result;
        }
    }

    function list_department()
    {
        $this->db->select('department_name, kode_department');
        $sql_group = $this->db->get($this->dept_coa);
        if ($sql_group->num_rows() > 0) {
            $result[""] = "Select";
            foreach ($sql_group->result_array() as $row) {
                $result[$row['kode_department']] = ucwords(strtoupper($row['department_name']));
            }
            return $result;
        }
    }

    function coa_deleted($id,$dept, $company, $data) {
        $this->db->where('NoCOA', $id);
        $this->db->where('id_department', $dept);
        $this->db->where('company_id', $company);
        return $this->db->update('zhl_zht_coa_transaction', $data);
    }

    function cek_jurnal_coa($NoCOA, $dept){
        $this->db->select('NoJurnal');
        $this->db->where('dept_code', $dept);
        $this->db->where('NoCOA', $NoCOA);
        $jurnal = $this->db->get('zhl_acc_tbl_trn_jurnal');
        if ($jurnal->num_rows() > 0) {
            foreach ($jurnal->result() as $row) {
                $result[] = $row;
            }
        }
        return $result;
    }

    function cek_jurnal_coa_tims($NoCOA, $dept){
        $this->db->select('NoJurnal');
        $this->db->where('dept_code', $dept);
        $this->db->where('NoCOA', $NoCOA);
        $jurnal = $this->db->get('zht_acc_tbl_trn_jurnal_tims');
        if ($jurnal->num_rows() > 0) {
            foreach ($jurnal->result() as $row) {
                $result[] = $row;
            }
        }
        return $result;
    }
}
