<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class M_Closing_rate extends CI_Model {

    var $tbl_mst_currency = 'zhl_gen_tbl_mst_currency';
    var $tbl_kurs = 'zhl_acc_tbl_trn_kurs';
    private $currency_id = 'detail_id';
    private $order = 'DESC';

    function __construct() {
        parent::__construct();
    }

    // get all
    function get_all_acc() {
        $result = $this->db->get('zhl_acc_tbl_utl_closingrate');
        return $result->result();
    }

    function get_currency($tahun, $bulan) {
        $this->db->where('MONTH(periode)', $bulan);
        $this->db->where('YEAR(periode)', $tahun);
        $this->db->limit('8');
        $this->db->order_by('Periode', 'ASC');
        $result = $this->db->get('zhl_acc_tbl_trn_kurs');
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

    // insert data closing rate
    function sp_closing_rate($data) {
        $sql = $this->db->query('call zhl_sp_acc_trn_closing_rate(?,?,?,?,?,?,?)', $data);
        $res = $sql->result();
        $sql->next_result();
        $sql->free_result();
        return $res;
    }
    
    // insert data closing rate
    function sp_selisih($data) {
        $sql = $this->db->query('call zhl_sp_acc_trn_jurnal_selisihrate(?,?,?)', $data);
        $res = $sql->result();
        $sql->next_result();
        $sql->free_result();
        return $res;
    }

    // insert data posting
    function sp_posting($data) {
        $sql = $this->db->query('call zhl_sp_acc_trn_posting(?,?,?)', $data);
        $res = $sql->result();
        $sql->next_result();
        $sql->free_result();
        return $res;
    }

    // update data
    function update($id, $data) {
        $this->db->where($this->currency_id, $id);
        $this->db->update($this->tbl_kurs, $data);
    }

    function update_kurs($id, $data) {
        $this->db->where('currency_id', $id);
        $this->db->update($this->tbl_mst_currency, $data);
    }

    function get_curid() {
        $this->db->select('currency_id');
        $this->db->order_by('currency_id', 'ASC');
        $this->db->group_by('currency_id');

        $sql = $this->db->get('zhl_acc_tbl_trn_kurs');

        return $sql->result();
    }

    function get_closing_period() {
        $this->db->select('tanggal');
        $this->db->group_by('tanggal');
        $this->db->order_by('tanggal, currency_id', 'Asc');
        $sql = $this->db->get('zhl_acc_tbl_utl_closingrate');
        return $sql->result();
    }

    function count_curid() {
        $this->db->select('currency_id');
        $this->db->order_by('currency_id', 'ASC');
        $this->db->group_by('currency_id');

        $sql = $this->db->get('zhl_acc_tbl_trn_kurs');

        return $sql->num_rows();
    }

    // delete data
    function delete($id) {
        $this->db->where($this->currency_id, $id);
        $this->db->delete($this->tbl_kurs);
    }

    function get_closing_rate($currency, $period) {
        $this->db->select('currency_rate');
        $this->db->where('currency_id', $currency);
        $this->db->where('tanggal', $period);
        $sql = $this->db->get('zhl_acc_tbl_utl_closingrate');
        return $sql->row();
    }

    function get_cur_date($sekarang) {
        $sql_product = $this->db->query("SELECT * FROM zhl_acc_tbl_trn_kurs WHERE periode=(SELECT DISTINCT periode FROM acc_tbl_trn_kurs WHERE periode<='$sekarang' ORDER BY periode DESC LIMIT 1)");
        if ($sql_product->num_rows() > 0) {
            foreach ($sql_product->result() as $data) {
                $hasil[] = $data;
            }
            return $hasil;
        }
    }

}
