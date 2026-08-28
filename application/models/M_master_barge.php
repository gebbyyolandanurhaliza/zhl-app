<?php

class M_master_barge extends CI_Model {

    private $db2;

    private $tblbarge   = 'zhl_shp_tblmst_bargecharges';
    private $id         = 'barge_charges_id';
    private $tblbargeggfs   = 'zhl_shp_tblmst_bargecharges_ggfs';

    function __construct() {
        parent::__construct();
        $this->load->library('Datatables');

        // $this->db2 = $this->load->database('db2', true);
    }

    function get_container_type()
    {
        return $this->db->get('zhl_mar_tblmst_container')->result();
    }

    function json()
    {
        $this->datatables->select('a.barge_charges_id, a.container_id, b.container_name, a.container_size, a.validity_from, a.validity_till,
                                a.vendor_export_empty, a.vendor_export_laden, a.vendor_import_transhipment, a.vendor_misc,
                                a.cust_export_empty, a.cust_export_laden, a.cust_import_transhipment, a.vendor_export_empty_cn, a.vendor_import_transhipment_cn,a.vendor_import_transhipment_cndp,a.vendor_import_transhipment_dp, a.vendor_export_laden_cn, a.cust_misc,
                                createdby, createddate, updatedby, updateddate, a.vendor_local_empty, a.vendor_local_laden, a.cust_local_empty, a.cust_local_laden, a.cust_recall, a.vendor_recall, a.vendor_empty_import, a.cust_empty_import, a.cust_loose, a.vendor_loose, a.cust_export_empty_cn, a.cust_import_transhipment_cn,a.cust_import_transhipment_cndp,a.cust_import_transhipment_dp, a.cust_export_laden_cn');
        $this->datatables->from('zhl_shp_tblmst_bargecharges as a');
        //add this line for join
        $this->datatables->join('zhl_mar_tblmst_container as b', 'a.container_id = b.container_id','left');
        $this->datatables->add_column('action', tombol_edit('master-barge/edit/$1')." ".tombol_delete('master-barge/delete/$1'), 'barge_charges_id');
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
            'vendor_local_empty'            => remove_thousand_separator($this->input->post('vendor_local_empty')),
            'vendor_local_laden'            => remove_thousand_separator($this->input->post('vendor_local_laden')),
            'cust_local_empty'              => remove_thousand_separator($this->input->post('cust_local_empty')),
            'cust_local_laden'              => remove_thousand_separator($this->input->post('cust_local_laden')),
            'cust_recall'                   => remove_thousand_separator($this->input->post('cust_recall')),
            'vendor_recall'                 => remove_thousand_separator($this->input->post('vendor_recall')),
            'cust_empty_import'             => remove_thousand_separator($this->input->post('cust_empty_import')),
            'vendor_empty_import'           => remove_thousand_separator($this->input->post('vendor_empty_import')),
            'cust_loose'                    => remove_thousand_separator($this->input->post('cust_loose')),
            'vendor_loose'                  => remove_thousand_separator($this->input->post('vendor_loose')),
            'vendor_export_empty_cn'        => remove_thousand_separator($this->input->post('vendor_export_empty_cn')),
            'vendor_import_transhipment_cn' => remove_thousand_separator($this->input->post('vendor_import_transhipment_cn')),
            'vendor_import_transhipment_dp' => remove_thousand_separator($this->input->post('vendor_import_transhipment_dp')),
            'vendor_import_transhipment_cndp' => remove_thousand_separator($this->input->post('vendor_import_transhipment_cndp')),
            'vendor_export_laden_cn'        => remove_thousand_separator($this->input->post('vendor_export_laden_cn')),
            'cust_export_empty_cn'          => remove_thousand_separator($this->input->post('cust_export_empty_cn')),
            'cust_import_transhipment_cn'   => remove_thousand_separator($this->input->post('cust_import_transhipment_cn')),
            'cust_import_transhipment_dp'   => remove_thousand_separator($this->input->post('cust_import_transhipment_dp')),
            'cust_import_transhipment_cndp'   => remove_thousand_separator($this->input->post('cust_import_transhipment_cndp')),
            'cust_export_laden_cn'          => remove_thousand_separator($this->input->post('cust_export_laden_cn')),
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
            'vendor_local_empty'            => remove_thousand_separator($this->input->post('vendor_local_empty')),
            'vendor_local_laden'            => remove_thousand_separator($this->input->post('vendor_local_laden')),
            'cust_local_empty'              => remove_thousand_separator($this->input->post('cust_local_empty')),
            'cust_local_laden'              => remove_thousand_separator($this->input->post('cust_local_laden')),
            'cust_recall'                   => remove_thousand_separator($this->input->post('cust_recall')),
            'vendor_recall'                 => remove_thousand_separator($this->input->post('vendor_recall')),
            'cust_empty_import'             => remove_thousand_separator($this->input->post('cust_empty_import')),
            'vendor_empty_import'           => remove_thousand_separator($this->input->post('vendor_empty_import')),
            'cust_loose'                    => remove_thousand_separator($this->input->post('cust_loose')),
            'vendor_loose'                  => remove_thousand_separator($this->input->post('vendor_loose')),
            'vendor_export_empty_cn'        => remove_thousand_separator($this->input->post('vendor_export_empty_cn')),
            'vendor_import_transhipment_cn' => remove_thousand_separator($this->input->post('vendor_import_transhipment_cn')),
            'vendor_import_transhipment_dp' => remove_thousand_separator($this->input->post('vendor_import_transhipment_dp')),
            'vendor_import_transhipment_cndp' => remove_thousand_separator($this->input->post('vendor_import_transhipment_cndp')),
            'vendor_export_laden_cn'        => remove_thousand_separator($this->input->post('vendor_export_laden_cn')),
            'cust_export_empty_cn'          => remove_thousand_separator($this->input->post('cust_export_empty_cn')),
            'cust_import_transhipment_cn'   => remove_thousand_separator($this->input->post('cust_import_transhipment_cn')),
            'cust_import_transhipment_dp'   => remove_thousand_separator($this->input->post('cust_import_transhipment_dp')),
            'cust_import_transhipment_cndp'   => remove_thousand_separator($this->input->post('cust_import_transhipment_cndp')),
            'cust_export_laden_cn'          => remove_thousand_separator($this->input->post('cust_export_laden_cn')),
        );

        $this->db->where($this->id, $barge_charges_id);
		$this->db->update($this->tblbarge, $info);
    }

    function delete($barge_charges_id)
    {
        $this->db->where($this->id, $barge_charges_id);
        $this->db->delete($this->tblbarge);
    }

    // ========================= BARGE CHARGES FOR GGFS KIW KIW ==========================
    function json_ggfs()
    {
        $this->datatables->select('a.barge_charges_id, a.container_id, b.container_name, a.container_size, a.validity_from, a.validity_till,
                                a.vendor_export_empty, a.vendor_export_laden, a.vendor_import_transhipment, a.vendor_misc,
                                a.cust_export_empty, a.cust_export_laden, a.cust_import_transhipment, a.vendor_export_empty_cn, a.vendor_import_transhipment_cn,a.vendor_import_transhipment_cndp,a.vendor_import_transhipment_dp, a.vendor_export_laden_cn, a.cust_misc,
                                createdby, createddate, updatedby, updateddate, a.vendor_local_empty, a.vendor_local_laden, a.cust_local_empty, a.cust_local_laden, a.cust_recall, a.vendor_recall, a.vendor_empty_import, a.cust_empty_import, a.cust_loose, a.vendor_loose, a.cust_export_empty_cn, a.cust_import_transhipment_cn,a.cust_import_transhipment_cndp,a.cust_import_transhipment_dp, a.cust_export_laden_cn');
        $this->datatables->from('zhl_shp_tblmst_bargecharges_ggfs as a');
        //add this line for join
        $this->datatables->join('zhl_mar_tblmst_container as b', 'a.container_id = b.container_id','left');
        $this->datatables->add_column('action', tombol_edit('master-barge/edit_ggfs/$1')." ".tombol_delete('master-barge/delete_ggfs/$1'), 'barge_charges_id');
        return $this->datatables->generate();
    }

    function insert_ggfs()
    {
        $info = array(
            'container_id'                  => $this->input->post('container_id'),
            'container_size'                => $this->input->post('container_size'),
            'validity_from'                 => dmy_to_ymd($this->input->post('validity_from')),
            'validity_till'                 => dmy_to_ymd($this->input->post('validity_till')),
            'vendor_export_empty'           => remove_thousand_separator($this->input->post('vendor_export_empty')),
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
            'vendor_local_empty'            => remove_thousand_separator($this->input->post('vendor_local_empty')),
            'vendor_local_laden'            => remove_thousand_separator($this->input->post('vendor_local_laden')),
            'cust_local_empty'              => remove_thousand_separator($this->input->post('cust_local_empty')),
            'cust_local_laden'              => remove_thousand_separator($this->input->post('cust_local_laden')),
            'cust_recall'                   => remove_thousand_separator($this->input->post('cust_recall')),
            'vendor_recall'                 => remove_thousand_separator($this->input->post('vendor_recall')),
            'cust_empty_import'             => remove_thousand_separator($this->input->post('cust_empty_import')),
            'vendor_empty_import'           => remove_thousand_separator($this->input->post('vendor_empty_import')),
            'cust_loose'                    => remove_thousand_separator($this->input->post('cust_loose')),
            'vendor_loose'                  => remove_thousand_separator($this->input->post('vendor_loose')),
            'vendor_export_empty_cn'        => remove_thousand_separator($this->input->post('vendor_export_empty_cn')),
            'vendor_import_transhipment_cn' => remove_thousand_separator($this->input->post('vendor_import_transhipment_cn')),
            'vendor_import_transhipment_dp' => remove_thousand_separator($this->input->post('vendor_import_transhipment_dp')),
            'vendor_import_transhipment_cndp' => remove_thousand_separator($this->input->post('vendor_import_transhipment_cndp')),
            'vendor_export_laden_cn'        => remove_thousand_separator($this->input->post('vendor_export_laden_cn')),
            'cust_export_empty_cn'          => remove_thousand_separator($this->input->post('cust_export_empty_cn')),
            'cust_import_transhipment_cn'   => remove_thousand_separator($this->input->post('cust_import_transhipment_cn')),
            'cust_import_transhipment_dp'   => remove_thousand_separator($this->input->post('cust_import_transhipment_dp')),
            'cust_import_transhipment_cndp'   => remove_thousand_separator($this->input->post('cust_import_transhipment_cndp')),
            'cust_export_laden_cn'          => remove_thousand_separator($this->input->post('cust_export_laden_cn')),
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
        $barge_charges_id   = $this->input->post('barge_charges_id');
        $info = array(
            'container_id'                  => $this->input->post('container_id'),
            'container_size'                => $this->input->post('container_size'),
            'validity_from'                 => dmy_to_ymd($this->input->post('validity_from')),
            'validity_till'                 => dmy_to_ymd($this->input->post('validity_till')),
            'vendor_export_empty'           => remove_thousand_separator($this->input->post('vendor_export_empty')),
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
            'vendor_local_empty'            => remove_thousand_separator($this->input->post('vendor_local_empty')),
            'vendor_local_laden'            => remove_thousand_separator($this->input->post('vendor_local_laden')),
            'cust_local_empty'              => remove_thousand_separator($this->input->post('cust_local_empty')),
            'cust_local_laden'              => remove_thousand_separator($this->input->post('cust_local_laden')),
            'cust_recall'                   => remove_thousand_separator($this->input->post('cust_recall')),
            'vendor_recall'                 => remove_thousand_separator($this->input->post('vendor_recall')),
            'cust_empty_import'             => remove_thousand_separator($this->input->post('cust_empty_import')),
            'vendor_empty_import'           => remove_thousand_separator($this->input->post('vendor_empty_import')),
            'cust_loose'                    => remove_thousand_separator($this->input->post('cust_loose')),
            'vendor_loose'                  => remove_thousand_separator($this->input->post('vendor_loose')),
            'vendor_export_empty_cn'        => remove_thousand_separator($this->input->post('vendor_export_empty_cn')),
            'vendor_import_transhipment_cn' => remove_thousand_separator($this->input->post('vendor_import_transhipment_cn')),
            'vendor_import_transhipment_dp' => remove_thousand_separator($this->input->post('vendor_import_transhipment_dp')),
            'vendor_import_transhipment_cndp' => remove_thousand_separator($this->input->post('vendor_import_transhipment_cndp')),
            'vendor_export_laden_cn'        => remove_thousand_separator($this->input->post('vendor_export_laden_cn')),
            'cust_export_empty_cn'          => remove_thousand_separator($this->input->post('cust_export_empty_cn')),
            'cust_import_transhipment_cn'   => remove_thousand_separator($this->input->post('cust_import_transhipment_cn')),
            'cust_import_transhipment_dp'   => remove_thousand_separator($this->input->post('cust_import_transhipment_dp')),
            'cust_import_transhipment_cndp'   => remove_thousand_separator($this->input->post('cust_import_transhipment_cndp')),
            'cust_export_laden_cn'          => remove_thousand_separator($this->input->post('cust_export_laden_cn')),
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
