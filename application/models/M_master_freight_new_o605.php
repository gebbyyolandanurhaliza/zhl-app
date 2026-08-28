<?php

class M_master_freight_new extends CI_Model {

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
        $this->db->where('notactive = "0"');
        return $this->db->get('mar_tblmst_port')->result();
    }

    function get_country()
    {
        return $this->db->get('gen_tbl_mst_country')->result();
    }

    function get_consignee()
    {
        return $this->db->get('mar_tblmst_customer')->result();
    }

    function get_shipping_line()
    {
        return $this->db->get('ship_tbl_mst_shipping_line')->result();
    }

    function get_port_by_id($port_id)
    {
        $this->db->where('port_id', $port_id);
        return $this->db->get('mar_tblmst_port')->row();
    }

    function json()
    {
        $this->datatables->select('a.freight_charges_id,a.container_id,a.container_size,d.container_name,a.port_id,b.port_name,b.country_id,c.country_name, a.vendor_rates,a.vendor_misc,a.cust_rates,a.cust_misc,a.validity_from, a.validity_till, datediff(a.validity_till,now()) as kadaluarsa,a.createdby, a.createddate, a.updatedby, a.updateddate, a.vendor_rates2, a.vendor_rates3, a.shipping_line1, a.shipping_line2, a.shipping_line3, a.cust_rates2, a.cust_rates3, a.consignee1, a.consignee2, a.consignee3, a.shipping_term_id, e.trading_term_name, e.trading_term_remark, f.shipping_name, g.customer_name');
        $this->datatables->from('zhl_shp_tblmst_freightcharges as a');
        //add this line for join
        $this->datatables->join('mar_tblmst_container as d', 'a.container_id = d.container_id', 'left');
        $this->datatables->join('mar_tblmst_port as b', 'a.port_id = b.port_id','left');
        $this->datatables->join('gen_tbl_mst_country as c', 'a.country_id = c.country_id', 'left');
        $this->datatables->join('mar_tblmst_trading_term as e', 'a.shipping_term_id = e.trading_term_id', 'left');
        $this->datatables->join('ship_tbl_mst_shipping_line as f', 'a.shipping_line = f.shipping_id', 'left');
        $this->datatables->join('mar_tblmst_customer as g', 'a.consignee = g.customer_id', 'left');
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

        $cont = $this->input->post('container_id');
        $port = $this->input->post('port_id');
        $con  = $this->input->post('consignee');
        $ship = $this->input->post('fob_id');
        $from = dmy_to_ymd($this->input->post('validity_from'));
        $till = dmy_to_ymd($this->input->post('validity_till'));


        if($ship == '3'){ //============ Jika dia Pilih CIF/CFR (System baru)

        $query = $this->save_2_kali();
        $insertid = $query->id;
        return $insertid;

        }else{

        $info = array(
            'container_id'      => $this->input->post('container_id'),
            'container_size'    => $this->input->post('container_size'),
            'port_id'           => $this->input->post('port_id'),
            'country_id'        => $this->input->post('country_id'),
            'shipping_term_id'  => $this->input->post('fob_id'), //================== Tambahan untuk Marketing
            'vendor_rates'      => remove_thousand_separator($this->input->post('vendor_rates')),
            'cust_rates'        => remove_thousand_separator($this->input->post('cust_rates')),
            'vendor_misc'       => $this->input->post('vendor_misc'),
            'cust_misc'         => $this->input->post('cust_misc'),
            'validity_from'     => dmy_to_ymd($this->input->post('validity_from')),
            'validity_till'     => dmy_to_ymd($this->input->post('validity_till')),
            'createdby'         => strtoupper($this->session->userdata('userid')),
            'createddate'       => date('Y-m-d H:i:s'),
            'vendor_rates2'     => remove_thousand_separator($this->input->post('vendor_rates2')),
            'vendor_rates3'     => remove_thousand_separator($this->input->post('vendor_rates3')),
            'shipping_line1'    => $this->input->post('shipping_line1'),
            'shipping_line2'    => $this->input->post('shipping_line2'),
            'shipping_line3'    => $this->input->post('shipping_line3'),
            'cust_rates2'       => remove_thousand_separator($this->input->post('cust_rates2')),
            'cust_rates3'       => remove_thousand_separator($this->input->post('cust_rates3')),
            'consignee1'        => $this->input->post('consignee1'),
            'consignee2'        => $this->input->post('consignee2'),
            'consignee3'        => $this->input->post('consignee3'),
            'consignee'         => $this->input->post('consignee'),
            'shipping_line'     => $this->input->post('shipping_line'),
        );

        //====================Test Query Duplikasi======================//
        $query = $this->db->query('select * from zhl_shp_tblmst_freightcharges where container_id = "'.$cont.'" and port_id = "'.$port.'" and shipping_term_id = "'.$ship.'" and consignee = "'.$con.'" and validity_till between "'.$from.'" and "'.$till.'" order by freight_charges_id');
        $hitungdatafreight = $query->num_rows();


        if ($hitungdatafreight == '0'){
        $this->db->insert($this->tblfreight, $info);
        return $insertid = $this->db->insert_id();            
        }else{
        return $insertid = "";
        }
        //===========================================================//

        }
    }


    function save_2_kali(){
        $cont = $this->input->post('container_id');
        $port = $this->input->post('port_id');
        $con  = $this->input->post('consignee');
        $ship = $this->input->post('fob_id');
        $from = dmy_to_ymd($this->input->post('validity_from'));
        $till = dmy_to_ymd($this->input->post('validity_till'));


        $info = array(
            'freight_charges_id'    => $this->input->post('freight_charges_id'),
            'freight_charges_id2'   => $this->input->post('freight_charges_id2'),
            'container_id'          => $this->input->post('container_id'),
            'container_size'        => $this->input->post('container_size'),
            'port_id'               => $this->input->post('port_id'),
            'country_id'            => $this->input->post('country_id'),
            'shipping_term_id'      => '2', //================== Tambahan untuk Marketing
            'vendor_rates'          => remove_thousand_separator($this->input->post('vendor_rates')),
            'cust_rates'            => remove_thousand_separator($this->input->post('cust_rates')),
            'vendor_misc'           => $this->input->post('vendor_misc'),
            'cust_misc'             => $this->input->post('cust_misc'),
            'validity_from'         => dmy_to_ymd($this->input->post('validity_from')),
            'validity_till'         => dmy_to_ymd($this->input->post('validity_till')),
            'createdby'             => strtoupper($this->session->userdata('userid')),
            'createddate'           => date('Y-m-d H:i:s'),
            'vendor_rates2'         => remove_thousand_separator($this->input->post('vendor_rates2')),
            'vendor_rates3'         => remove_thousand_separator($this->input->post('vendor_rates3')),
            'shipping_line1'        => $this->input->post('shipping_line1'),
            'shipping_line2'        => $this->input->post('shipping_line2'),
            'shipping_line3'        => $this->input->post('shipping_line3'),
            'cust_rates2'           => remove_thousand_separator($this->input->post('cust_rates2')),
            'cust_rates3'           => remove_thousand_separator($this->input->post('cust_rates3')),
            'consignee1'            => $this->input->post('consignee1'),
            'consignee2'            => $this->input->post('consignee2'),
            'consignee3'            => $this->input->post('consignee3'),
            'consignee'             => $this->input->post('consignee'),
            'shipping_line'         => $this->input->post('shipping_line'),
        );

        //====================Test Query Duplikasi======================//
        $query = $this->db->query('select * from zhl_shp_tblmst_freightcharges where container_id = "'.$cont.'" and port_id = "'.$port.'" and shipping_term_id = "'.$ship.'" and consignee = "'.$con.'" and validity_till between "'.$from.'" and "'.$till.'" order by freight_charges_id');
        $hitungdatafreight = $query->num_rows();

        if ($hitungdatafreight == '0'){
        
        $this->db->query("SET @id = '".$info['freight_charges_id']."'");
        $this->db->query("SET @flag = '".$info['freight_charges_id2']."'");
        $this->db->query("call zhl_sp_save_freight_new(@id,'".$info['container_id']."','".$info['container_size']."','".$info['port_id']."','".$info['country_id']."','".$info['shipping_term_id']."','".$info['vendor_rates']."','".$info['cust_rates']."',"
        . "'".$info['vendor_misc']."','".$info['cust_misc']."','".$info['validity_from']."','".$info['validity_till']."','".$info['createdby']."','".$info['createddate']."','".$info['vendor_rates2']."','".$info['vendor_rates3']."','".$info['shipping_line1']."','".$info['shipping_line2']."','".$info['shipping_line3']."','".$info['consignee']."','".$info['shipping_line']."',@flag)");

        $insertid =  $this->db->query("Select @id as id")->row();
        return $insertid;        
        }
    }


    function update()
    {
        $freight_charges_id = $this->input->post('freight_charges_id');
        $freight_charges_id2 = $this->input->post('freight_charges_id2');

        if ($freight_charges_id2 === ''){
        $info = array(
            'container_id'      => $this->input->post('container_id'),
            'container_size'    => $this->input->post('container_size'),
            'port_id'           => $this->input->post('port_id'),
            'country_id'        => $this->input->post('country_id'),
            'shipping_term_id'  => $this->input->post('fob_id'), //================== Tambahan untuk Marketing
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
            'cust_rates2'       => remove_thousand_separator($this->input->post('cust_rates2')),
            'cust_rates3'       => remove_thousand_separator($this->input->post('cust_rates3')),
            'consignee1'        => $this->input->post('consignee1'),
            'consignee2'        => $this->input->post('consignee2'),
            'consignee3'        => $this->input->post('consignee3'),
            'consignee'         => $this->input->post('consignee'),
            'shipping_line'     => $this->input->post('shipping_line'),
        );

        $this->db->where($this->id, $freight_charges_id);
		$this->db->update($this->tblfreight, $info);

        }else{

            $this->update_2_kali();            

        }

    }


    function update_2_kali(){
        
        $freight_charges_id1 = $this->input->post('freight_charges_id');
        $freight_charges_id2 = $this->input->post('freight_charges_id2');

        //========================= Update 1
        $info1 = array(
            'container_id'      => $this->input->post('container_id'),
            'container_size'    => $this->input->post('container_size'),
            'port_id'           => $this->input->post('port_id'),
            'country_id'        => $this->input->post('country_id'),
            'shipping_term_id'  => '3', //================== Tambahan untuk Marketing
            'vendor_rates'      => remove_thousand_separator($this->input->post('vendor_rates')),
            'cust_rates'        => remove_thousand_separator($this->input->post('cust_rates')),
            'vendor_misc'       => $this->input->post('vendor_misc'),
            'cust_misc'         => $this->input->post('cust_misc'),
            'validity_from'     => dmy_to_ymd($this->input->post('validity_from')),
            'validity_till'     => dmy_to_ymd($this->input->post('validity_till')),
            'updatedby'         => strtoupper($this->session->userdata('userid')),
            'updateddate'       => date('Y-m-d H:i:s'),
            'vendor_rates2'     => remove_thousand_separator($this->input->post('vendor_rates2')),
            'vendor_rates3'     => remove_thousand_separator($this->input->post('vendor_rates3')),
            'shipping_line1'    => $this->input->post('shipping_line1'),
            'shipping_line2'    => $this->input->post('shipping_line2'),
            'shipping_line3'    => $this->input->post('shipping_line3'),
            'cust_rates2'       => remove_thousand_separator($this->input->post('cust_rates2')),
            'cust_rates3'       => remove_thousand_separator($this->input->post('cust_rates3')),
            'consignee1'        => $this->input->post('consignee1'),
            'consignee2'        => $this->input->post('consignee2'),
            'consignee3'        => $this->input->post('consignee3'),
            'consignee'         => $this->input->post('consignee'),
            'shipping_line'     => $this->input->post('shipping_line'),
        );

        $this->db->where($this->id, $freight_charges_id1);
        $this->db->update($this->tblfreight, $info1);

        //========================== Update 2
        $info2 = array(
            'container_id'      => $this->input->post('container_id'),
            'container_size'    => $this->input->post('container_size'),
            'port_id'           => $this->input->post('port_id'),
            'country_id'        => $this->input->post('country_id'),
            'shipping_term_id'  => '2', //================== Tambahan untuk Marketing
            'vendor_rates'      => remove_thousand_separator($this->input->post('vendor_rates')),
            'cust_rates'        => remove_thousand_separator($this->input->post('cust_rates')),
            'vendor_misc'       => $this->input->post('vendor_misc'),
            'cust_misc'         => $this->input->post('cust_misc'),
            'validity_from'     => dmy_to_ymd($this->input->post('validity_from')),
            'validity_till'     => dmy_to_ymd($this->input->post('validity_till')),
            'updatedby'         => strtoupper($this->session->userdata('userid')),
            'updateddate'       => date('Y-m-d H:i:s'),
            'vendor_rates2'     => remove_thousand_separator($this->input->post('vendor_rates2')),
            'vendor_rates3'     => remove_thousand_separator($this->input->post('vendor_rates3')),
            'shipping_line1'    => $this->input->post('shipping_line1'),
            'shipping_line2'    => $this->input->post('shipping_line2'),
            'shipping_line3'    => $this->input->post('shipping_line3'),
            'cust_rates2'       => remove_thousand_separator($this->input->post('cust_rates2')),
            'cust_rates3'       => remove_thousand_separator($this->input->post('cust_rates3')),
            'consignee1'        => $this->input->post('consignee1'),
            'consignee2'        => $this->input->post('consignee2'),
            'consignee3'        => $this->input->post('consignee3'),
            'consignee'         => $this->input->post('consignee'),
            'shipping_line'     => $this->input->post('shipping_line'),
        );

        $this->db->where($this->id, $freight_charges_id2);
        $this->db->update($this->tblfreight, $info2);

    }


    function delete($freight_charges_id)
    {        
        // $this->db->where($this->id, $freight_charges_id);
        // $this->db->delete($this->tblfreight);

        $query = 'call zhl_sp_ship_tbl_trn_freight_delete(?)';
        $sql = $this->db->query($query, $freight_charges_id);
        return true;
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

    function tradingterm_get_fob()
    {
        $this->db->order_by('trading_term_id', 'ASC');
        return $this->db->get('mar_tblmst_trading_term_new_version')->result();
    }

    function tampil_mst_freight(){
        $this->db->order_by('port_name', 'ASC');
        $result=$this->db->get('zhl_ship_vw_trn_freight_charges_for_master');
        return $result->result();
    }

    function get_port_destination()
    {
        $this->db->where('notactive = "0"');
        return $this->db->get('mar_vw_mst_port')->result();
    }

    function filter_freight($dest,$cont,$ship,$con){

        if ($dest !== '' && $cont !== '' && $ship !== '' && $con !== ''){
        
        $query = ('port_id = "'.$dest.'" and container_id = "'.$cont.'" and shipping_term_id = "'.$ship.'" and consignee = "'.$con.'"');
        $this->db->where($query);

        } else if($dest !== ''){
        
        $query = ('port_id = "'.$dest.'"');
        $this->db->where($query);

        } else if ($cont !== ''){
        
        $query = ('container_id = "'.$cont.'"');
        $this->db->where($query);

        } else if ($ship !== ''){
        
        $query = ('shipping_term_id = "'.$ship.'"');
        $this->db->where($query);

        } else if ($con !== ''){
        
        $query = ('consignee = "'.$con.'"');
        $this->db->where($query);

        }else if ($dest == '' && $cont == '' && $ship == '' && $con == ''){

        }

        $this->db->order_by('freight_charges_id', 'ASC');
        return $this->db->get('zhl_ship_vw_trn_freight_charges_for_master')->result();        
    }
}
