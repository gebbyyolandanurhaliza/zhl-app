<?php

class M_shipping_depot extends CI_Model {

    private $db2;

    private $tbldepot   = 'ship_tbl_mst_depot';
    private $id         = 'depot_id';

    function __construct() {
        parent::__construct();
        $this->load->library('Datatables');

        // $this->db2 = $this->load->database('db2', true);
    }

    function get_container_type()
    {
        return $this->db->get('mar_tblmst_container')->result();
    }

    function json()
    {
        $this->datatables->select('a.depot_id, a.depot_name, a.depot_address, a.createdby, a.createddate, a.updateby, a.updateddate');
        $this->datatables->from('ship_tbl_mst_depot as a');
        //add this line for join
        //$this->datatables->join('mar_tblmst_container as b', 'a.container_id = b.container_id','left');
        $this->datatables->add_column('action', tombol_edit('shipping_depot/edit/$1')." ".tombol_delete('shipping_depot/delete/$1'), 'depot_id');
        return $this->datatables->generate();
    }

    function get_by_id($barge_charges_id)
    {
        $this->db->where($this->id, $barge_charges_id);
        return $this->db->get($this->tbldepot)->row();
    }

    function insert()
    {
        $info = array(
            'depot_name'                    => $this->input->post('depot_name'),
            'depot_address'                 => $this->input->post('depot_address'),
            'createdby'                     => strtoupper($this->session->userdata('userid_1')),
			'createddate'                   => date('Y-m-d H:i:s'),
        );

		$this->db->insert($this->tbldepot, $info);
        return $insertid = $this->db->insert_id();

    }

    function update()
    {
        $barge_charges_id   = $this->input->post('depot_id');
        $info = array(
            'depot_name'                    => $this->input->post('depot_name'),
            'depot_address'                 => $this->input->post('depot_address'),
            'updateby'                      => strtoupper($this->session->userdata('userid_1')),
            'updateddate'                   => date('Y-m-d H:i:s'),
        );

        $this->db->where($this->id, $barge_charges_id);
		$this->db->update($this->tbldepot, $info);
    }

    function delete($barge_charges_id)
    {
        $this->db->where($this->id, $barge_charges_id);
        $this->db->delete($this->tbldepot);
    }

}
