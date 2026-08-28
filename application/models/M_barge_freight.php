<?php

defined('BASEPATH') or exit('No direct script access allowed');

class M_barge_freight extends CI_Model
{
    private $table_hdr = 'zhl_shp_bargefreight_hdr';
    private $table_dtl = 'zhl_shp_bargefreight_dtl';

    public function get_item($destination_id, $container_id, $con_type_id)
    {
        $this->db->select('*');
        $this->db->from('zhl_shp_vw_list_mst_barge_freight');
        $this->db->where('destination_id', $destination_id);
        $this->db->where('container_id', $container_id);
        $this->db->where('con_type_id', $con_type_id);
        return $this->db->get()->result();
    }

    public function get_all_dtl_id($id)
    {
        $this->db->select('bargefreight_dtl_id');
        $this->db->from($this->table_dtl);
        $this->db->where('bargefreight_hdr_id', $id);
        return $this->db->get()->result();
    }

    function get_cust()
    {
        return $this->db->get('zhl_mar_tblmst_customer')->result();
    }

    function get_cust_row($id)
    {
        $this->db->select('*');
        $this->db->from('zhl_mar_tblmst_customer');
        $this->db->where('customer_id', $id);
        return $this->db->get()->row();
    }

    public function insert_hdr($data)
    {
        $this->db->insert($this->table_hdr, $data);
        return $this->db->affected_rows();
    }

    public function insert_dtl($data)
    {
        $this->db->insert_batch($this->table_dtl, $data);
        return $this->db->affected_rows();
    }

    public function get_hdr_byid($id)
    {
        $this->db->select('*');
        $this->db->from($this->table_hdr);
        $this->db->where('deleted_by', null);
        $this->db->where('deleted_at', null);
        $this->db->where('bargefreight_hdr_id', $id);
        return $this->db->get()->row();
    }

    public function get_dtl_byhdrid($id)
    {
        $this->db->select('*');
        $this->db->from($this->table_dtl);
        $this->db->where('bargefreight_hdr_id', $id);
        $this->db->where('deleted_at', null);
        return $this->db->get()->result();
    }

    public function count_all_dtl_bykode($id, $kode)
    {
        $this->db->where('bargefreight_hdr_id', $id);
        $this->db->where('kode', $kode);
        $this->db->where('deleted_at', null);
        $this->db->from($this->table_dtl);
        return $this->db->count_all_results();
    }

    public function get_kode_akhir($id)
    {
        $this->db->select('bargefreight_dtl_id,kode');
        $this->db->from($this->table_dtl);
        $this->db->where('bargefreight_hdr_id', $id);
        $this->db->where('deleted_at', null);
        $this->db->order_by('bargefreight_dtl_id', 'desc');
        $kode = $this->db->get()->row();
        if ($kode) {
            return $kode->kode;
        } else {
            return '0';
        }
    }

    public function update_hdr($data, $id)
    {
        $this->db->where('bargefreight_hdr_id', $id);
        $this->db->update($this->table_hdr, $data);
        return $this->db->affected_rows();
    }

    public function update_batch_dtl($data)
    {
        $this->db->update_batch($this->table_dtl, $data, 'bargefreight_dtl_id');
        return $this->db->affected_rows();
    }

    public function delete_old_detail($id)
    {
        $this->db->where('bargefreight_hdr_id', $id);
        $this->db->delete($this->table_dtl);
        return $this->db->affected_rows();
    }

    public function delete_items($ids)
    {
        $this->db->where_in('bargefreight_dtl_id', $ids);
        $this->db->delete($this->table_dtl);
        return $this->db->affected_rows();
    }

    function find($search)
    {
        if ($search != '') {
            $this->db->like('ship_board_date', $search);
            $this->db->or_like('customer_name', $search);
            $this->db->or_like('customer_name', $search);
            $this->db->or_like('vesel', $search);
            $this->db->or_like('voyage_no', $search);
            $this->db->or_like('port_of_load', $search);
            $this->db->or_like('credit_term', $search);
        }

        $this->db->where('deleted_at', null);
        $this->db->where('deleted_by', null);
        $this->db->order_by('bargefreight_hdr_id', 'DESC');
        $result = $this->db->get('zhl_shp_vw_hdr_bargefreight');
        return $result->result();
    }
}

/* End of file M_tax_invoice.php */
