<?php
class M_Moq extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get_list(){
        return $this->db->get('vw_fac_moq_ppic')->result();
    }

    function select_product(){
    	$this->db->where('have_moq', 0);
    	$sql_prov = $this->db->get('mar_tblmst_product');
    	if ($sql_prov->num_rows() > 0) {
            $result[''] = 'Select';
            foreach ($sql_prov->result_array() as $row) {
                $result[$row['product_code']] = ucwords(strtoupper($row['product_name']. " ( ".$row['product_code']." ) "));
            }
            return $result;
        } else {
            echo "";
        }
    }

    function save_moq($data){
    	$this->db->insert('fac_moq_ppic', $data);
    }

    function update_moq($data, $id){
        $this->db->where('product_id', $id);
        $this->db->update('fac_moq_ppic', $data);
    }

    function update_product($data, $id){
    	$this->db->where('product_code',$id);
    	$this->db->update('mar_tblmst_product', $data);
    }

    function get_detail($id){
        $this->db->where('product_id', $id);
        return $this->db->get('vw_fac_moq_ppic')->result();
    }
}