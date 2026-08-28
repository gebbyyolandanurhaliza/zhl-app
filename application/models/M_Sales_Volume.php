<?php

/**
 * Created by PhpStorm.
 * User: Reza Irhami
 * Date: 1/17/2017
 * Time: 3:10 PM
 */
class M_Sales_Volume extends CI_Model
{

    public function __construct() {
        parent::__construct();
    }

    function call_sales_report($tgl,$sampai,$sales_person){

        if($sales_person==''||$sales_person==NULL){
            $sql = $this->db->query("SELECT * FROM zhl_ship_vw_trn_inv where createddate BETWEEN '$tgl' AND '$sampai' ORDER BY custcompany ASC ");
        }
        else
            $sql = $this->db->query("SELECT * FROM zhl_ship_vw_trn_inv where sales_id='$sales_person' and createddate BETWEEN '$tgl' AND '$sampai' ORDER BY custcompany ASC ");
        //$sql = $this->db->query("CALL sp_acc_rpt_gl_summary('2016-06-23')");
        $res = $sql->result();

        return $res;
    }
	
	function get_datacustomer($tgl,$sampai,$sales_person){

        if($sales_person==''||$sales_person==NULL){
            $sql = $this->db->query("SELECT DISTINCT custid, custcompany FROM zhl_ship_vw_trn_inv where createddate BETWEEN '$tgl' AND '$sampai' ORDER BY custcompany ASC ");
        }
        else
            $sql = $this->db->query("SELECT DISTINCT custid, custcompany FROM zhl_ship_vw_trn_inv where sales_id='$sales_person' and createddate BETWEEN '$tgl' AND '$sampai' ORDER BY custcompany ASC ");
        //$sql = $this->db->query("CALL sp_acc_rpt_gl_summary('2016-06-23')");
        $res = $sql->result();

        return $res;
    }

    function call_data($tgl,$sampai,$sales_person) {
        if($sales_person==''||$sales_person==NULL){
            $sql = $this->db->query("call zhl_sp_acc_rpt_gl_summary('$tgl', '$sampai')");
        }
        else
            $sql = $this->db->query("call zhl_sp_acc_rpt_gl_summary('$tgl', '$sampai', '$sales_person')");        

        $res = $sql->result();
        $sql->next_result();
        $sql->free_result();
        return $res;
    }
}