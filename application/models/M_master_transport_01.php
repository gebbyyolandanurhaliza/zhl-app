<?php

class M_master_transport extends CI_Model {

    private $tbltransport   = 'zhl_shp_tblmst_transportcharges';
    private $id             = 'zhl_transport_charges_id';

    function __construct() {
        parent::__construct();
        $this->load->library('Datatables');

    }

    function json()
    {
        $this->datatables->select('a.transport_charges_id, a.container_id, b.container_name, a.container_size, a.validity,
                                a.vendor_empty, a.vendor_laden, a.vendor_loose_cargo, a.vendor_misc,
                                a.cust_empty, a.cust_laden, a.cust_loose_cargo, a.cust_misc,
                                a.createdby, a.createddate, a.updatedby, a.updateddate');
        $this->datatables->from('zhl_shp_tblmst_transportcharges as a');
        //add this line for join
        $this->datatables->join('zhl_mar_tblmst_container as b', 'a.container_id = b.container_id','left');
        $this->datatables->add_column('action', tombol_edit('master-transport/edit/$1')." ".tombol_delete('master-transport/delete/$1'), 'transport_charges_id');
        return $this->datatables->generate();
    }

    function get_by_id($transport_charges_id)
    {
        $this->db->where($this->id, $transport_charges_id);
        return $this->db->get($this->tbltransport)->row();
    }

    function get_container_type()
    {
        return $this->db->get('zhl_mar_tblmst_container')->result();
    }

    function insert()
    {
        $info = array(
            'container_id'          => $this->input->post('container_id'),
            'container_size'        => $this->input->post('container_size'),
            'validity'              => dmy_to_ymd($this->input->post('validity')),
            'vendor_empty'          => remove_thousand_separator($this->input->post('vendor_empty')),
            'vendor_laden'          => remove_thousand_separator($this->input->post('vendor_laden')),
            'vendor_loose_cargo'    => remove_thousand_separator($this->input->post('vendor_loose_cargo')),
            'vendor_misc'           => $this->input->post('vendor_misc'),
            'cust_empty'            => remove_thousand_separator($this->input->post('cust_empty')),
            'cust_laden'            => remove_thousand_separator($this->input->post('cust_laden')),
            'cust_loose_cargo'      => remove_thousand_separator($this->input->post('cust_loose_cargo')),
            'cust_misc'             => $this->input->post('cust_misc'),
            'createdby'             => strtoupper($this->session->userdata('userid')),
			'createddate'           => date('Y-m-d H:i:s'),
        );

		$this->db->insert($this->tbltransport, $info);
        return $insertid = $this->db->insert_id();

    }

    function update()
    {
        $transport_charges_id   = $this->input->post('transport_charges_id');
        $info = array(
            'container_id'          => $this->input->post('container_id'),
            'container_size'        => $this->input->post('container_size'),
            'validity'              => dmy_to_ymd($this->input->post('validity')),
            'vendor_empty'          => remove_thousand_separator($this->input->post('vendor_empty')),
            'vendor_laden'          => remove_thousand_separator($this->input->post('vendor_laden')),
            'vendor_loose_cargo'    => remove_thousand_separator($this->input->post('vendor_loose_cargo')),
            'vendor_misc'           => $this->input->post('vendor_misc'),
            'cust_empty'            => remove_thousand_separator($this->input->post('cust_empty')),
            'cust_laden'            => remove_thousand_separator($this->input->post('cust_laden')),
            'cust_loose_cargo'      => remove_thousand_separator($this->input->post('cust_loose_cargo')),
            'cust_misc'             => $this->input->post('cust_misc'),
            'updatedby'             => strtoupper($this->session->userdata('userid')),
			'updateddate'           => date('Y-m-d H:i:s'),
        );

        $this->db->where($this->id, $transport_charges_id);
		$this->db->update($this->tbltransport, $info);
    }

    function delete($transport_charges_id)
    {
        $this->db->where($this->id, $transport_charges_id);
        $this->db->delete($this->tbltransport);
    }

}
