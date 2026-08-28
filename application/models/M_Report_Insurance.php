<?php

/**
 * Created by PhpStorm.
 * User: Reza Irhami
 * Date: 11/11/2016
 * Time: 2:34 PM
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class M_Report_Insurance extends CI_Model
{
	function get_category(){
		$sql = $this->db->query("Select * from zhl_mar_tblmst_product_category");
		if($sql->num_rows() > 0){
			foreach ($sql->result_array() as $value){
				$result[$value['product_category_id']]=ucwords(strtoupper($value['product_category_name']));
			}
			return $result;
		}
	}

    function call_report_insurance($tgl,$sampai){

        $sql = $this->db->query("call zhl_sp_rpt_insurance_2('$tgl', '$sampai')");
        //$sql = $this->db->query("CALL `sp_acc_rpt_gl_summary`('2016-06-23')");
        $res = $sql->result();
        $sql->next_result();
        $sql->free_result();
        return $res;
    }

    function call_report_insurance_detail($tgl,$sampai,$id){

        $sql = $this->db->query("call zhl_sp_rpt_insurance_2_detail('$tgl', '$sampai','$id')");
        //$sql = $this->db->query("CALL `sp_acc_rpt_gl_summary`('2016-06-23')");
        $res = $sql->result();
        $sql->next_result();
        $sql->free_result();
        return $res;
    }


}