<?php defined('BASEPATH') OR exit('No direct script access allowed');

/* 
 * Author : ITD15
 */

class M_Fin_Report extends CI_Model{

    function __construct() {
        
    }
    
    // For CashBankJournal(function) - Finance_Report
    function selectHeaderCashBank(){
        return $this->db->get('zhl_fin_tbltrn_cashbank_journal_header');
    }
    function selectHeaderCashBankSearch($key){
        if ($key[1] == NULL && $key[3] == NULL) {
            return $this->db->query("SELECT * FROM zhl_fin_tbltrn_cashbank_journal_header WHERE no_reff LIKE '%".$key[0]."%' AND "
                    . "cashbank_code LIKE '%".$key[4]."%'");
        }elseif ($key[3] == NULL) {
            $startDate  = date('Y-m-d', strtotime($key[1]));
            $endDate    = date('Y-m', strtotime($key[1])).'-31';
            return $this->db->query("SELECT * FROM zhl_fin_tbltrn_cashbank_journal_header WHERE no_reff LIKE '%".$key[0]."%' AND "
                    . "(date1 BETWEEN '".$startDate."' AND '".$endDate."') AND cashbank_code LIKE '%".$key[4]."%'");
        }elseif ($key[1] == NULL) {
            $startDate  = date('Y-m', strtotime($key[3])).'-01';
            $endDate    = date('Y-m-d', strtotime($key[3]));
            return $this->db->query("SELECT * FROM zhl_fin_tbltrn_cashbank_journal_header WHERE no_reff LIKE '%".$key[0]."%' AND "
                    . "(date1 BETWEEN '".$startDate."' AND '".$endDate."') AND cashbank_code LIKE '%".$key[4]."%'");
        }else{
            $startDate  = date('Y-m-d', strtotime($key[1]));
            $endDate    = date('Y-m-d', strtotime($key[3]));
            return $this->db->query("SELECT * FROM zhl_fin_tbltrn_cashbank_journal_header WHERE no_reff LIKE '%".$key[0]."%' AND "
                    . "(date1 BETWEEN '".$startDate."' AND '".$endDate."') AND cashbank_code LIKE '%".$key[4]."%'");
        }
    }
    function selectDetailCBByHeaderID($hdrID){
        $this->db->where('header_id', $hdrID);
        return $this->db->get('zhl_fin_tbltrn_cashbank_journal_detail');
    }

    function selectHeadercashbanksearch2($reffno, $from, $to){

        
        $sql = $this->db->query("SELECT * FROM zhl_fin_tbltrn_cashbank_journal_header where no_reff like '$reffno' or date1 between '$from' and '$to'");


        // $this->db->select('*');        
        // $this->db->where("no_reff like '$reffno' or month (date1) like '$tgl' and year(date1) like '$tgl'");
        // $sql = $this->db->get("fin_tbltrn_cashbank_journal_header");
       if ($sql->num_rows() > 0) {
            foreach ($sql->result() as $data) {
                $hasil[] = $data;
            }
            return $hasil;
        }
    }

    
    function selectCOAforReport(){
        return $this->db->query("SELECT * FROM zhl_fin_vw_mst_coa_balance ORDER BY AccountName");
    }
    // function get_coacash(){
    //     $this->db->select('*');
    //     $sql = $this->db->get('fin_tblmst_awal_saldo');
    //     if($sql->num_rows() > 0){
    //         foreach ($sql->result_array() as $value) {
    //             $result[$value['no_coa']] = ucwords(strtoupper($value['no_coa']));
    //             // $result[$value['no_coa']] = ucwords(strtoupper($value['no_coa'].' - '. $value['AccountName']));
    //         }
    //         return $result;
    //     }
    // }

     function get_coacash(){
        $this->db->select('*');
        $sql = $this->db->get('zhl_fin_vw_mst_coa_balance');
        if($sql->num_rows() > 0){
            foreach ($sql->result_array() as $value) {
                $result[$value['no_coa']] = ucwords(strtoupper($value['no_coa'].' - '. $value['AccountName']));
            }
            return $result;
        }
    }


    function hasil($dari, $sampai, $coa){
        //$this->db->select('date1, no_facture, currency_id, (select remark from fin_tbltrn_cashbank_journal_history where header_id = header_id Limit 1) AS remark1, SUM(credit) AS credit1, SUM(debit) AS debit1, currency_rate');
        /*$this->db->select('*');
        $this->db->where('date1 BETWEEN "'. date('Y-m-d', strtotime($dari)). '" and "'. date('Y-m-d', strtotime($sampai)).'"');
        $this->db->where('cb_code', $coa);
        $this->db->where('coa_code != ', $coa);
        if(!empty($coa)){
            $this->db->where('cb_code', $coa);
        }
        if(!empty($cur)){
            $this->db->where('currency_id', $cur);
        }
        //$this->db->group_by('no_facture');
        $sql = $this->db->get('fin_tbltrn_cashbank_journal_history');

        if($sql->num_rows() > 0){
            foreach ($sql->result() as $data) {
                $hasil[] = $data;
            }
            return $hasil;
        }*/

        //return $this->db->query("SELECT * FROM fin_tbltrn_cashbank_journal_history WHERE date1 BETWEEN '".$dari."' AND '".$sampai."' AND coa_code = '".$coa."'");

        /*return $this->db->query("SELECT fin_tbltrn_cashbank_journal_history.*, (CASE WHEN (fin_tbltrn_cashbank_journal_history.trans_type = 'AP') "
            . "THEN fin_tbltrn_payment_hdr.check_number WHEN (fin_tbltrn_cashbank_journal_history.trans_type = 'AR') THEN fin_tbltrn_payment_hdr.check_number "
            . "ELSE fin_tbltrn_cashbank_journal_header.check_bank END) AS check_bank FROM fin_tbltrn_cashbank_journal_history "
            . "LEFT JOIN fin_tbltrn_cashbank_journal_header ON fin_tbltrn_cashbank_journal_history.header_id = fin_tbltrn_cashbank_journal_header.header_id "
            . "LEFT JOIN fin_tbltrn_payment_hdr ON fin_tbltrn_cashbank_journal_history.header_id = fin_tbltrn_payment_hdr.header_id "
            . "WHERE fin_tbltrn_cashbank_journal_history.date1 BETWEEN '".$dari."' AND '".$sampai."' AND fin_tbltrn_cashbank_journal_history.coa_code = '".$coa."'");*/
	return $this->db->query("SELECT * FROM zhl_fin_vw_mon_regbook_new WHERE date1 BETWEEN '".$dari."' AND '".$sampai."' AND coa_code = '".$coa."'")->result();
    }

    //cash balance
    function get_cashbalance($dari , $sampai){
       $this->db->select('no_coa, AccountName, sum(jumlah_usd) as jumlah_usd, sum(jumlah_notusd*rate) as jumlah_notusd, (sum(jumlah_notusd*rate)+sum(jumlah_usd)) / (sum(jumlah_usd)+sum(jumlah_notusd)) as average_rate');
       $this->db->group_by('no_coa, AccountName');

       $this->db->where('date BETWEEN "'. date('Y-m-d', strtotime($dari)). '" and "'. date('Y-m-d', strtotime($sampai)).'"');
       $sql = $this->db->get('zhl_fin_vw_balancecash_union');
        if($sql->num_rows() > 0){
            foreach ($sql->result() as $data) {
                $hasil[] = $data;
            }
            return $hasil;
        }

    }

    function get_coaca($coa){
        $this->db->where('no_coa', $coa);
        $sql = $this->db->get('zhl_fin_tblmst_awal_saldo');
        return $sql->row();
    }

    function hitung_dailybegin($cb, $coa){
        // $this->db->select('cb_code, SUM(jumlah) AS jumlah1');
        // $this->db->where('cb_code', $coa);
        // $this->db->where('coa_code != ',$coa);
        // $this->db->where('date1 < ' ,$dari);
        // $this->db->group_by('cb_code');
        // $sql = $this->db->get('fin_tbltrn_cashbank_journal_history');
        $sql = $this->db->query("SELECT cb_code, SUM(jumlah) AS jumlah1 FROM zhl_fin_vw_daily where cb_code = '".$cb."' AND coa_code != '".$coa."' Group by cb_code");
        return $sql->row();

    }

    function get_daily($dari, $sampai, $coa){
        $this->db->select('*');
        $this->db->where('date1 BETWEEN "'. date('Y-m-d', strtotime($dari)). '" and "'. date('Y-m-d', strtotime($sampai)).'"');
        $this->db->where('cb_code', $coa);
        $this->db->where('coa_code != ', $coa);
        $sql = $this->db->get('zhl_fin_tbltrn_cashbank_journal_history');
        if($sql->num_rows() > 0){
            foreach ($sql->result() as $data) {
                $hasil[] = $data;
            }
            return $hasil;
        }
    }

    function get_dp($dari, $sampai){
        $this->db->select('*');
        $this->db->where('date BETWEEN "'. date('Y-m-d', strtotime($dari)). '" and "'. date('Y-m-d', strtotime($sampai)).'"');
        $sql = $this->db->get('zhl_fin_vw_dp');
        if($sql->num_rows() > 0){
            foreach ($sql->result() as $data) {
                $hasil[] = $data;
            }
            return $hasil;
        }
    }

    function get_appayment($dari,$sampai,$sup){
        $this->db->where('trans_date Between "'.$dari.'" and "'.$sampai.'"');
        $this->db->where('supplier_id like "%'.$sup.'"');
        $sql = $this->db->get('zhl_fin_vw_mon_appayment');
        return $sql->result();
    }

    function get_arpayment($dari,$sampai,$sup){
        $this->db->where('trans_date Between "'.$dari.'" and "'.$sampai.'"');
        $this->db->where('supplier_id like "%'.$sup.'"');
        $sql = $this->db->get('zhl_fin_vw_mon_arpayment');
        return $sql->result();
    }

    function get_supplier() {
        $this->db->select('supplierid, suppliercompany');
        $this->db->from('zhl_pur_vw_mst_supplier');
        $this->db->where('notactive', '0');
        $sql = $this->db->get();
        if ($sql->num_rows() > 0) {
            $result[''] = 'Select';
            foreach ($sql->result_array() as $row) {
                $result[$row['supplierid']] = ucwords(strtoupper($row['suppliercompany']));
            }
            return $result;
        } else {
            echo "Not data avaible";
        }
    }

}