<?php

class M_master_vessel_shipping extends CI_Model {

    private $_tblVessel   = 'zhl_shp_tblmst_vessel';
    private $id         = 'vessel_id';

    function __construct() {
        parent::__construct();
        $this->load->library('Datatables');
    }

    function get_data_vessel()
    {
        return $this->db->get('zhl_shp_tblmst_vessel')->result();
    }

    function get_data_user()
    {
        return strtoupper($this->session->userdata('userid'));
    }

    function get_by_id($vessel_id)
    {
        $this->db->where('vessel_id', $vessel_id);
        return $this->db->get($this->_tblVessel)->row();
    }

    function insert()
    {
        $info = array(
            'vessel_name'                   => $this->input->post('vessel_name'),
			'created_at'                    => date('Y-m-d H:i:s'),
            'created_by'                    => strtoupper($this->session->userdata('userid')),
        );

		$this->db->insert($this->_tblVessel, $info);
        return $insertid = $this->db->insert_id();

    }

    function update()
    {
        $vessel_id   = $this->input->post('vessel_id');
        
        $info = array(
            'vessel_name'                   => $this->input->post('vessel_name'),
            'updated_by'                    => strtoupper($this->session->userdata('userid')),
			'updated_at'                   => date('Y-m-d H:i:s'),
        );

        $this->db->where($this->id, $vessel_id);
		$this->db->update($this->_tblVessel, $info);
    }

    function delete($vessel_id)
    {
        $this->db->where($this->id, $vessel_id);
        $this->db->delete($this->_tblVessel);
    }

}
