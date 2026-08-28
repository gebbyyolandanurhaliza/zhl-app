<?php defined('BASEPATH') OR exit('No direct script access allowed');

/* 
 * Author : Ismo Broto
 */

class M_Fin_Master extends CI_Model{
    
    public function __construct() {
        parent::__construct();
    }
    
    
    function selectAllEmployee(){
        return $this->db->get('zhl_fin_tblmst_karyawan');
    }
    function getEmployeeByID($headerID){
        $this->db->where('header_id', $headerID);
        $get    = $this->db->get('zhl_fin_tblmst_karyawan');
        return $get->row();
    }
    function insertDataEmployee($data){
        $this->db->insert('zhl_fin_tblmst_karyawan', $data);
    }
    function updateDataEmployee($headerID,$data){
        $this->db->where('header_id', $headerID);
        $this->db->update('zhl_fin_tblmst_karyawan', $data);
    }

    function get_employee(){
        $sql = $this->db->query("SELECT * FROM zhl_fin_tblmst_karyawan");
        if ($sql->num_rows() > 0) {
            $result[''] = 'Select';
            foreach ($sql->result_array() as $value) {
                $result[$value['full_name']] = ucwords(strtoupper($value['full_name']));
            }
            return $result;
        }
    }
}