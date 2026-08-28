<?php

class M_master_import_local extends CI_Model {

    private $db2;

    private $tblbarge   = 'zhl_shp_tblmst_import_local_charges';
    private $id         = 'barge_charges_id';

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
        $this->datatables->select('a.barge_charges_id, a.container_id, b.container_name, a.container_size, a.validity_from, a.validity_till,
                                a.vendor_export_empty, a.vendor_export_reefer, a.vendor_export_laden, a.vendor_import_transhipment, a.vendor_misc,
                                a.cust_export_empty, a.cust_export_reefer, a.cust_export_laden, a.cust_import_transhipment, a.cust_misc,
                                createdby, createddate, updatedby, updateddate');
        $this->datatables->from('zhl_shp_tblmst_import_local_charges as a');
        //add this line for join
        $this->datatables->join('mar_tblmst_container as b', 'a.container_id = b.container_id','left');
        $this->datatables->add_column('action', tombol_edit('master_import_local/edit/$1')." ".tombol_delete('master_import_local/delete/$1'), 'barge_charges_id');
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
            'container_id'                  => $this->input->post('container_id'),
            'container_size'                => $this->input->post('container_size'),
            'validity_from'                 => dmy_to_ymd($this->input->post('validity_from')),
            'validity_till'                 => dmy_to_ymd($this->input->post('validity_till')),
            'vendor_export_empty'           => remove_thousand_separator($this->input->post('vendor_export_empty')),
            'vendor_export_reefer'          => remove_thousand_separator($this->input->post('vendor_export_reefer')),
            'vendor_export_laden'           => remove_thousand_separator($this->input->post('vendor_export_laden')),
            'vendor_import_transhipment'    => remove_thousand_separator($this->input->post('vendor_import_transhipment')),
            'vendor_misc'                   => $this->input->post('vendor_misc'),
            'cust_export_empty'             => remove_thousand_separator($this->input->post('cust_export_empty')),
            'cust_export_reefer'            => remove_thousand_separator($this->input->post('cust_export_reefer')),
            'cust_export_laden'             => remove_thousand_separator($this->input->post('cust_export_laden')),
            'cust_import_transhipment'      => remove_thousand_separator($this->input->post('cust_import_transhipment')),
            'cust_misc'                     => $this->input->post('cust_misc'),
            'createdby'                     => strtoupper($this->session->userdata('userid')),
			'createddate'                   => date('Y-m-d H:i:s'),
        );

		$this->db->insert($this->tblbarge, $info);
        return $insertid = $this->db->insert_id();

    }

    function update()
    {
        $barge_charges_id   = $this->input->post('barge_charges_id');
        $info = array(
            'container_id'                  => $this->input->post('container_id'),
            'container_size'                => $this->input->post('container_size'),
            'validity_from'                 => dmy_to_ymd($this->input->post('validity_from')),
            'validity_till'                 => dmy_to_ymd($this->input->post('validity_till')),
            'vendor_export_empty'           => remove_thousand_separator($this->input->post('vendor_export_empty')),
            'vendor_export_reefer'          => remove_thousand_separator($this->input->post('vendor_export_reefer')),
            'vendor_export_laden'           => remove_thousand_separator($this->input->post('vendor_export_laden')),
            'vendor_import_transhipment'    => remove_thousand_separator($this->input->post('vendor_import_transhipment')),
            'vendor_misc'                   => $this->input->post('vendor_misc'),
            'cust_export_empty'             => remove_thousand_separator($this->input->post('cust_export_empty')),
            'cust_export_reefer'            => remove_thousand_separator($this->input->post('cust_export_reefer')),
            'cust_export_laden'             => remove_thousand_separator($this->input->post('cust_export_laden')),
            'cust_import_transhipment'      => remove_thousand_separator($this->input->post('cust_import_transhipment')),
            'cust_misc'                     => $this->input->post('cust_misc'),
            'updatedby'                     => strtoupper($this->session->userdata('userid')),
			'updateddate'                   => date('Y-m-d H:i:s'),
        );

        $this->db->where($this->id, $barge_charges_id);
		$this->db->update($this->tblbarge, $info);
    }

    function delete($barge_charges_id)
    {
        $this->db->where($this->id, $barge_charges_id);
        $this->db->delete($this->tblbarge);
    }

}
