<?php

class M_master_freight extends CI_Model {

    private $db2;

    private $tblbarge   = 'zhl_shp_tblmst_bargecharges';
    private $tblfreight = 'zhl_shp_tblmst_freightcharges';
    private $tbltrans   = 'zhl_shp_tblmst_transportcharges';

    private $id         = 'freight_charges_id';

    function __construct() {
        parent::__construct();
        $this->load->library('Datatables');

        $this->db2 = $this->load->database('db2', true);
    }

    function get_container_type()
    {
        return $this->db->get('mar_tblmst_container')->result();
    }

    function get_port()
    {
        return $this->db->get('mar_tblmst_port')->result();
    }

    function get_country()
    {
        return $this->db->get('gen_tbl_mst_country')->result();
    }

    function get_port_by_id($port_id)
    {
        $this->db->where('port_id', $port_id);
        return $this->db->get('mar_tblmst_port')->row();
    }

    function json()
    {
        $this->datatables->select('a.freight_charges_id,a.container_id,a.container_size,d.container_name,a.port_id,b.port_name,b.country_id,c.country_name, a.vendor_rates,a.vendor_misc,a.cust_rates,a.cust_misc,a.validity_from, a.validity_till, a.createdby, a.createddate, a.updatedby, a.updateddate, a.vendor_rates2, a.vendor_rates3, a.shipping_line1, a.shipping_line2, a.shipping_line3');
        $this->datatables->from('zhl_shp_tblmst_freightcharges as a');
        //add this line for join
        $this->datatables->join('mar_tblmst_container as d', 'a.container_id = d.container_id', 'left');
        $this->datatables->join('mar_tblmst_port as b', 'a.port_id = b.port_id','left');
        $this->datatables->join('gen_tbl_mst_country as c', 'a.country_id = c.country_id', 'left');
        $this->datatables->add_column('action', tombol_edit('master-freight/edit/$1')." ".tombol_delete('master-freight/delete/$1'), 'freight_charges_id');
        return $this->datatables->generate();
    }

    function get_by_id($freight_charges_id)
    {
        $this->db->where($this->id, $freight_charges_id);
        return $this->db->get($this->tblfreight)->row();
    }

    function insert()
    {
        $info = array(
            'container_id'      => $this->input->post('container_id'),
            'container_size'    => $this->input->post('container_size'),
            'port_id'           => $this->input->post('port_id'),
            'country_id'        => $this->input->post('country_id'),
            'vendor_rates'      => remove_thousand_separator($this->input->post('vendor_rates')),
            'cust_rates'        => remove_thousand_separator($this->input->post('cust_rates')),
            'vendor_misc'       => $this->input->post('vendor_misc'),
            'cust_misc'         => $this->input->post('cust_misc'),
            'validity_from'     => dmy_to_ymd($this->input->post('validity_from')),
            'validity_till'     => dmy_to_ymd($this->input->post('validity_till')),
            'createdby'         => strtoupper($this->session->userdata('userid')),
			'createddate'		=> date('Y-m-d H:i:s'),
            'vendor_rates2'     => remove_thousand_separator($this->input->post('vendor_rates2')),
            'vendor_rates3'     => remove_thousand_separator($this->input->post('vendor_rates3')),
            'shipping_line1'    => $this->input->post('shipping_line1'),
            'shipping_line2'    => $this->input->post('shipping_line2'),
            'shipping_line3'    => $this->input->post('shipping_line3'),
        );

		$this->db->insert($this->tblfreight, $info);
        return $insertid = $this->db->insert_id();

    }

    function update()
    {
        $freight_charges_id = $this->input->post('freight_charges_id');
        $info = array(
            'container_id'      => $this->input->post('container_id'),
            'container_size'    => $this->input->post('container_size'),
            'port_id'           => $this->input->post('port_id'),
            'country_id'        => $this->input->post('country_id'),
            'vendor_rates'      => remove_thousand_separator($this->input->post('vendor_rates')),
            'cust_rates'        => remove_thousand_separator($this->input->post('cust_rates')),
            'vendor_misc'       => $this->input->post('vendor_misc'),
            'cust_misc'         => $this->input->post('cust_misc'),
            'validity_from'     => dmy_to_ymd($this->input->post('validity_from')),
            'validity_till'     => dmy_to_ymd($this->input->post('validity_till')),
            'updatedby'         => strtoupper($this->session->userdata('userid')),
			'updateddate'		=> date('Y-m-d H:i:s'),
            'vendor_rates2'     => remove_thousand_separator($this->input->post('vendor_rates2')),
            'vendor_rates3'     => remove_thousand_separator($this->input->post('vendor_rates3')),
            'shipping_line1'    => $this->input->post('shipping_line1'),
            'shipping_line2'    => $this->input->post('shipping_line2'),
            'shipping_line3'    => $this->input->post('shipping_line3'),
        );

        $this->db->where($this->id, $freight_charges_id);
		$this->db->update($this->tblfreight, $info);

    }

    function delete($freight_charges_id)
    {
        $this->db->where($this->id, $freight_charges_id);
        $this->db->delete($this->tblfreight);
    }

    function json_transport()
    {
        $this->datatables->select('transport_charges_id, empty_cargo, laden, loose_cargo, misc, createdby, createddate, updatedby, updateddate');
        $this->datatables->from('shp_tblmst_transportcharges');
        //add this line for join
        // $this->datatables->join('shp_tblmst_bargecharges', 'k.id_jenis_kas = j.id_jenis_kas');
        $this->datatables->add_column('action', tombol_edit('master-freight/transport-charges-edit/$1')." ".tombol_delete('master-freight/transport-charges-delete/$1'), 'transport_charges_id');
        return $this->datatables->generate();
    }

    function get_trasnport_by_id($transport_charges_id)
    {
        $this->db->where('transport_charges_id', $transport_charges_id);
        return $this->db->get($this->tbltransport)->row();
    }
}
