<?php

class M_master_barge_freight extends CI_Model
{
    private $table_hdr = 'zhl_shp_tblmst_barge_freight_hdr';
    private $table_dtl = 'zhl_shp_tblmst_barge_freight_dtl';

    function __construct()
    {
        parent::__construct();
        $this->load->library('Datatables');
        $this->db2 = $this->load->database('db2', true);
    }

    public function list_desc()
    {
        $this->db->select('*');
        $this->db->from('zhl_shp_tblmstbarge_freight_desc_list');
        return $this->db->get()->result();
    }

    function destination()
    {
        $this->db->select('*');
        $this->db->from('zhl_shp_tblmst_destination');
        return $this->db->get()->result();
    }

    function insert($data)
    {
        $this->db->insert($this->table_hdr, $data);
        return $this->db->affected_rows();
    }

    function insert_batch_dtl($data)
    {
        $this->db->insert_batch($this->table_dtl, $data);
        return $this->db->affected_rows();
    }

    function get_hdr()
    {
        $this->db->select('*');
        $this->db->from('zhl_shp_vw_list_mst_barge_freight');
        $this->db->where('deleted_at', null);
        $this->db->where('deleted_by', null);
        $this->db->group_by('barge_freight_hdr_id');

        return $this->db->get()->result();
    }

    function get_dtl($hdr_id)
    {
        $this->db->select('*');
        $this->db->from($this->table_dtl);
        $this->db->where('barge_freight_hdr_id', $hdr_id);
        return $this->db->get()->result();
    }

    function container()
    {
        return $this->db->get('zhl_mar_tblmst_container')->result();
    }

    function container_type()
    {
        $this->db->select('*');
        $this->db->from('zhl_shp_tblmst_container_type');
        return $this->db->get()->result();
    }

    function find_hdr($id)
    {
        $this->db->select('*');
        $this->db->from($this->table_hdr);
        $this->db->where('barge_freight_hdr_id', $id);
        return $this->db->get()->row();
    }

    function update_batch_dtl($data)
    {
        $this->db->update_batch($this->table_dtl, $data, 'barge_freight_dtl_id');
        return $this->db->affected_rows();
    }

    public function remove_detail($id)
    {
        $this->db->where('barge_freight_dtl_id', $id);
        $this->db->delete($this->table_dtl);
        return $this->db->affected_rows();
    }

    public function update_hdr($data, $id)
    {
        $this->db->where('barge_freight_hdr_id', $id);
        $this->db->update($this->table_hdr, $data);
        return $this->db->affected_rows();
    }

    function filter_freight($dest, $cont, $type)
    {
        $this->db->select('*');

        if ($dest != '') {
            $this->db->where('destination_id', $dest);
        }

        if ($cont != '') {
            $this->db->where('container_id', $cont);
        }

        if ($type != '') {
            $this->db->where('con_type_id', $type);
        }

        $this->db->where('deleted_at', null);
        $this->db->where('deleted_by', null);
        $this->db->from('zhl_shp_vw_list_mst_barge_freight');
        $this->db->group_by('barge_freight_hdr_id');

        return $this->db->get()->result();
    }

    function vessel_list()
    {
        $this->db->select('*');
        $this->db->from('zhl_shp_tblmst_vessel');
        return $this->db->get()->result();
    }
}
