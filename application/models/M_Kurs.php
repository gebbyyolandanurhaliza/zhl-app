<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class M_Kurs extends CI_Model {

    var $tbl_mst_currency = 'zhl_gen_tbl_mst_currency';
    var $tbl_kurs = 'zhl_acc_tbl_trn_kurs';
    private $currency_id = 'detail_id';
    private $order = 'DESC';

    function __construct() {
        parent::__construct();
    }

    // get all
    function get_all_acc() {
        $this->db->order_by('periode', 'DESC');
        $this->db->order_by('currency_name', 'ASC');
        $result = $this->db->get($this->tbl_kurs);
        return $result->result();
    }

// get all
    function get_kurs() {
        $this->db->order_by('periode', 'ASC');
        $result = $this->db->get('zhl_gen_tbl_mst_currency');
        return $result->result();
    }

    // get data by id
    function get_by_id($id) {
        $table = $this->tbl_kurs;
        $this->db->where($this->currency_id, $id);
        return $this->db->get($table)->row();
    }

    // insert data
    function insert($data) {
        $this->db->insert($this->tbl_kurs, $data);
    }

    // update data
    function update($id, $data) {
        $this->db->where($this->currency_id, $id);
        $this->db->update($this->tbl_kurs, $data);
    }
    function update_kurs($id, $data){
        $this->db->where('currency_id', $id);
        $this->db->update($this->tbl_mst_currency, $data);
        
    }
    // delete data
    function delete($id) {
        $this->db->where($this->currency_id, $id);
        $this->db->delete($this->tbl_kurs);
    }

     //New Kurs
    function get_curid(){
        $this->db->select('currency_id');
        $this->db->order_by('currency_id','ASC');
        $this->db->group_by('currency_id');
        
        $sql = $this->db->get('zhl_gen_tbl_mst_currency');

        return $sql->result();

    }

    function get_period(){
        $this->db->select('periode');
        $this->db->group_by('periode');
        $this->db->order_by('periode, currency_id','Asc');
        $sql = $this->db->get('zhl_acc_tbl_trn_kurs');
        return $sql->result();
    }

    function get_rateusd($currency, $period){
        $this->db->select('rate_usd','detail_id');
        $this->db->where('currency_id',$currency);
        $this->db->where('periode', $period);
        $sql = $this->db->get('zhl_acc_tbl_trn_kurs');

        return $sql->row();

    }

    function get_ratesgd($currency, $period){
        $this->db->select('rate_kurs');
        $this->db->where('currency_id',$currency);
        $this->db->where('periode', $period);
        $sql = $this->db->get('zhl_acc_tbl_trn_kurs');
        return $sql->row();
    }

    function count_curid(){
        $this->db->select('currency_id');
        $this->db->order_by('currency_id','ASC');
        $this->db->group_by('currency_id');
        
        $sql = $this->db->get('zhl_acc_tbl_trn_kurs');

        return $sql->num_rows();

    }

    function cek_period($periode){
        $tgl = date('Y-m-d',strtotime($periode));
        $this->db->where('periode',$tgl);
        $sql = $this->db->get('zhl_acc_tbl_trn_kurs');
        if($sql->num_rows() > 0){
            return 1;
        }
        else{
            return 0;
        }
    }

    function update_period($period, $cur, $data){
        $tgl = date('Y-m-d',strtotime($period));
        $this->db->where('periode',$tgl);
        $this->db->where('currency_id', $cur);
        $this->db->update('zhl_acc_tbl_trn_kurs', $data);
    }

    function insert_period($data){
        $this->db->insert('zhl_acc_tbl_trn_kurs', $data);
    }

    function insert_period_history($data){
        $this->db->insert('zhl_acc_tbl_trn_kurs_history', $data);
    }


}
