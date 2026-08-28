<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
* 
*/
class M_closing_earning extends CI_Model
{
	function get_earning($th){
		// $query = "SELECT SUM(Debet-Kredit) as usd, SUM(Debet_SGD-Kredit_SGD) as sgd FROM zhl_acc_tbl_trn_jurnal where NoCOA in (SELECT coa FROM zhl_acc_mst_report_profitandloss_coa_1212) AND Year(tanggal) = $th ";
		// return $this->db->query($query)->row();
		$query = "SELECT SUM(Debet-Kredit) as usd, SUM(Debet_SGD-Kredit_SGD) as sgd FROM zhl_acc_tbl_trn_jurnal where NoCOA in (SELECT coa FROM zhl_acc_mst_report_profitandloss_coa_june) AND Year(tanggal) = $th ";
		return $this->db->query($query)->row();
	}

	function cekcoa($coa, $tahun){
		$query = "SELECT nocoa FROM zhl_acc_tbl_trn_saldoawal where nocoa = $coa AND periode_tahun = $tahun LIMIT 1 ";

		$sql = $this->db->query($query)->row();
		if(!empty($sql)){
			$coa = $sql->nocoa;
		}else{
			$coa = '';
		}
		return $coa;
	}

	function save($tahun, $user){
		$sql = $this->db->query("call zhl_closeretairned('$tahun','$user')");

		$res = $sql->result();
		$sql->next_result();
		$sql->free_result();
		return $res;
	}

	function update($data, $nocoa, $periode_tahun){
		$this->db->where('nocoa', $nocoa);
		$this->db->where('periode_tahun', $periode_tahun);
		$this->db->update('zhl_acc_tbl_trn_saldoawal', $data);
	}

	function save_history($data){
		$this->db->insert('zhl_acc_tbl_trn_saldoawal_history', $data);
	}

	function get_history(){
		$this->db->order_by('id', 'desc');
		return $this->db->get('zhl_acc_tbl_trn_saldoawal_history')->result();
	}
}

?>