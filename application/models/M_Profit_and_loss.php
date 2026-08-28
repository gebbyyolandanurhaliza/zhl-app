<?php

class M_Profit_and_loss extends CI_Model {

   function get_data($p_dari, $p_sampai){
        //$sql = $this->db->query("call zhl_profitnloss3_1212('$p_dari','$p_sampai')"); 
        //$sql = $this->db->query("call zhl_profitnloss4_0321('$p_dari','$p_sampai')");
      //   $sql = $this->db->query("call zhl_profitnloss_2023_copy1('$p_dari','$p_sampai')"); 
        $sql = $this->db->query("call zhl_profitlnloss_2023_new_test('$p_dari','$p_sampai')"); 
        $res = $sql->result();
        $sql->next_result();
        $sql->free_result();
        return $res;
   }
   function get_data_2025($p_dari, $p_sampai,$p_dept ,$p_comp, $p_cur){
        $sql = $this->db->query("call zhl_profitnloss_combine_2025('$p_dari','$p_sampai','$p_dept','$p_comp','$p_cur')"); 
        $res = $sql->result();
        $sql->next_result();
        $sql->free_result();
        return $res;
   }
   function get_departmentcode(){
        $sql = $this->db->get('zhl_mar_tblmst_department_code');
        if($sql->num_rows() > 0){
            foreach ($sql->result() as $data) {
                $hasil[] = $data;
            }
            return $hasil;
        }
   }
   function list_coa_gen() {
      $data = $this->db->query("select a.no_coa,b.AccountName from acc_report_coa a inner join acc_master_coa b on b.NoCOA=a.no_coa where a.id_group=224 order by a.no_coa");
      if ($data->num_rows() > 0) {
          foreach ($data->result() as $value) {
              $result[] = $value;
          }
          return $result;
      }
  }
  function call_data_t1($dari, $sampai) {
   $sql = $this->db->query("SELECT IFNULL(SUM(Debet - Kredit),0)  as t_1 FROM acc_tbl_trn_jurnal where Tanggal between '$dari' and '$sampai' and NoCOA in (select no_coa from acc_report_coa where id_group = 1)");

                                        $res = $sql->result();
                                        //$sql->next_result();
                                        //$sql->free_result();
return $res;

}
   function call_data_tpurchase($dari, $sampai) {
      $sql = $this->db->query("SELECT IFNULL(SUM(Debet - Kredit),0) as t_purchase FROM acc_tbl_trn_jurnal where Tanggal between '$dari' and '$sampai' and NoCOA in (select no_coa from acc_report_coa where id_group = 72)");
   $res = $sql->result();
      //$sql->next_result();
      //$sql->free_result();
      return $res;
   }
   function call_data_zopening($dari, $sampai) {
      $sql = $this->db->query("SELECT IFNULL(SUM(Debet - Kredit),0) as z_opening FROM acc_tbl_trn_jurnal where Tanggal between '$dari' and '$sampai' and NoCOA in (select no_coa from acc_report_coa where id_group in (1,72))");
   $res = $sql->result();
      //$sql->next_result();
      //$sql->free_result();
      return $res;
   }
   function call_data_zclosing($dari, $sampai) {
      $sql = $this->db->query("SELECT IFNULL(SUM(Debet - Kredit),0) as z_closing FROM acc_tbl_trn_jurnal where Tanggal between '$dari' and '$sampai' and NoCOA in (select no_coa from acc_report_coa where id_group = 226 )");
   $res = $sql->result();
      //$sql->next_result();
      //$sql->free_result();
      return $res;
   }
   function call_data_gprofit($dari, $sampai) {
      $sql = $this->db->query("SELECT IFNULL(SUM(Debet - Kredit),0)  as sub_gross_profit FROM acc_tbl_trn_jurnal where Tanggal between '$dari' and '$sampai'  and NoCOA in (select no_coa from acc_report_coa where id_group in (1,72))");
   $res = $sql->result();
      //$sql->next_result();
      //$sql->free_result();
      return $res;
   }
   function call_data_general($p_dari, $nourut) {
      $sql = $this->db->query("call sp_acc_rpt_profit_and_loss_pdf('$p_dari', '$nourut')");
      $res = $sql->result();
      $sql->next_result();
      $sql->free_result();
      return $res;
   }

   function call_data_all($p_dari, $nourut) {
      $sql = $this->db->query("call sp_acc_rpt_profit_and_loss_pdf2('$p_dari', '$nourut')");
      $res = $sql->result();
      $sql->next_result();
      $sql->free_result();
      return $res;
   }

}
