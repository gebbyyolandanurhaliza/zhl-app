<?php

class M_shipping_trucking extends CI_Model {

    private $db2;

    private $tblbarge   = 'zhl_tbl_mst_trucking';
    private $tblbargeggfs   = 'zhl_tbl_mst_trucking_ggfs';
    private $id         = 'trucking_id';

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
        $this->datatables->select('a.trucking_id, a.container_size, a.validity_from, a.validity_until, a.vendor_trucking_price, a.cust_trucking_price');
        $this->datatables->from('zhl_tbl_mst_trucking as a');
        //add this line for join
        //$this->datatables->join('mar_tblmst_container as b', 'a.container_id = b.container_id','left');
        $this->datatables->add_column('action', tombol_edit('shipping_trucking/edit/$1')." ".tombol_delete('shipping_trucking/delete/$1'), 'trucking_id');
        return $this->datatables->generate();
    }

    function get_by_id($barge_charges_id)
    {
        $this->db->where($this->id, $barge_charges_id);
        return $this->db->get($this->tblbarge)->row();
    }

    function insert()
    {
        $info = array(
            'container_size'                => $this->input->post('container_size'),
            'validity_from'                 => dmy_to_ymd($this->input->post('validity_from')),
            'validity_until'                => dmy_to_ymd($this->input->post('validity_until')),
            'vendor_trucking_price'         => remove_thousand_separator($this->input->post('vendor_trucking_price')),
            'cust_trucking_price'           => remove_thousand_separator($this->input->post('cust_trucking_price')),
            'createdby'                     => strtoupper($this->session->userdata('userid')),
			'create_dated'                   => date('Y-m-d H:i:s'),
        );

		$this->db->insert($this->tblbarge, $info);
        return $insertid = $this->db->insert_id();

    }

    function update()
    {
        $barge_charges_id   = $this->input->post('trucking_id');
        $info = array(
            'container_size'                => $this->input->post('container_size'),
            'validity_from'                 => dmy_to_ymd($this->input->post('validity_from')),
            'validity_until'                => dmy_to_ymd($this->input->post('validity_until')),
            'vendor_trucking_price'         => remove_thousand_separator($this->input->post('vendor_trucking_price')),
            'cust_trucking_price'           => remove_thousand_separator($this->input->post('cust_trucking_price')),
            'updateby'                      => strtoupper($this->session->userdata('userid')),
            'update_dated'                  => date('Y-m-d H:i:s'),
        );

        $this->db->where($this->id, $barge_charges_id);
		$this->db->update($this->tblbarge, $info);
    }

    function delete($barge_charges_id)
    {
        $this->db->where($this->id, $barge_charges_id);
        $this->db->delete($this->tblbarge);
    }

    // ================================================ GGFS =========================================
    function json_ggfs()
    {
        $this->datatables->select('a.trucking_id, a.container_size, a.validity_from, a.validity_until, a.vendor_trucking_price, a.cust_trucking_price');
        $this->datatables->from('zhl_tbl_mst_trucking_ggfs as a');
        $this->datatables->add_column('action', tombol_edit('shipping_trucking/edit_ggfs/$1')." ".tombol_delete('shipping_trucking/delete_ggfs/$1'), 'trucking_id');
        return $this->datatables->generate();
    }

    function insert_ggfs()
    {
        $info = array(
            'container_size'                => $this->input->post('container_size'),
            'validity_from'                 => dmy_to_ymd($this->input->post('validity_from')),
            'validity_until'                => dmy_to_ymd($this->input->post('validity_until')),
            'vendor_trucking_price'         => remove_thousand_separator($this->input->post('vendor_trucking_price')),
            'cust_trucking_price'           => remove_thousand_separator($this->input->post('cust_trucking_price')),
            'createdby'                     => strtoupper($this->session->userdata('userid')),
			'create_dated'                   => date('Y-m-d H:i:s'),
        );

		$this->db->insert($this->tblbargeggfs, $info);
        return $insertid = $this->db->insert_id();

    }

    function get_by_id_ggfs($barge_charges_id)
    {
        $this->db->where($this->id, $barge_charges_id);
        return $this->db->get($this->tblbargeggfs)->row();
    }
    function update_ggfs()
    {
        $barge_charges_id   = $this->input->post('trucking_id');
        $info = array(
            'container_size'                => $this->input->post('container_size'),
            'validity_from'                 => dmy_to_ymd($this->input->post('validity_from')),
            'validity_until'                => dmy_to_ymd($this->input->post('validity_until')),
            'vendor_trucking_price'         => remove_thousand_separator($this->input->post('vendor_trucking_price')),
            'cust_trucking_price'           => remove_thousand_separator($this->input->post('cust_trucking_price')),
            'updateby'                      => strtoupper($this->session->userdata('userid')),
            'update_dated'                  => date('Y-m-d H:i:s'),
        );

        $this->db->where($this->id, $barge_charges_id);
		$this->db->update($this->tblbargeggfs, $info);
    }

    function delete_ggfs($barge_charges_id)
    {
        $this->db->where($this->id, $barge_charges_id);
        $this->db->delete($this->tblbargeggfs);
    }
}
