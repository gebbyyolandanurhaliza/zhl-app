<?php defined('BASEPATH') or exit('No direct script access allowed');

/* 
 * Author : ITD15
 */

class M_CashBank_zht extends CI_Model
{

  private $tblMst     = array(
    'COA'               => 'zhl_acc_master_coa',
    'CashFlow'          => 'zhl_fin_tblmst_cash_flow',
    'CashRealization'   => 'zhl_fin_tblmst_cash_realization'
  );
  private $vwMst      = array(
    'CashFlow'          => 'zhl_fin_vw_mst_cashflow',
    'CashRealization'   => 'zhl_fin_tblmst_cash_realization',

    'SettingFlowReal'   => 'zhl_fin_vw_mst_cashflow_setting'
  );
  private $primary    = array(
    'CashFlow'          => 'cf_key',
    'CashRealization'   => 'rlz_key'
  );
  private $orderBy    = array(
    'byLevelCF'         => 'cf_level',
    'byLevelRLZ'        => 'rlz_level',

    'PrimaryCF'         => 'cf_key'
  );

  private $tblTran    = array(
    'CashBankHeader'    => 'zht_fin_tbltrn_cashbank_journal_header',
    'CashBankDetail'    => 'zht_fin_tbltrn_cashbank_journal_detail',

    'PaymentAPheader'   => 'zht_fin_tbltrn_payment_hdr',
    'PaymentAPdetail'   => 'zht_fin_tbltrn_payment_dtl'
  );


  public function __construct()
  {
    parent::__construct();
  }

  function getPeriod()
  {
    return $this->session->userdata('periode_1') . '/01';
  }
  function getRateByCurrecry($cur)
  {
    $this->db->limit(1);
    $this->db->order_by('periode', 'DESC');
    $this->db->where('currency_id', $cur);
    $get = $this->db->get('zhl_acc_tbl_trn_kurs')->row();
    //return $get->result_array();
    return $get->rate_usd;
  }

  function selectMasterCOAForBalance()
  {
    return $this->db->query("SELECT * FROM " . $this->tblMst['COA'] . " WHERE NoCOA NOT IN (SELECT no_coa FROM zhl_fin_tblmst_awal_saldo) ORDER BY AccountName");
  }
  function selectMasterCOA()
  {
    return $this->db->query("SELECT * FROM zhl_fin_vw_mst_coa_balance ORDER BY AccountName");
  }
  function getMasterCOAWhere($key)
  {
    return $this->db->query("SELECT * FROM zhl_fin_vw_mst_coa_balance WHERE NoCOA = '" . $key . "'");
  }
  function getMasterCOA($key)
  {
    return $this->db->query("SELECT * FROM zhl_fin_vw_mst_coa_balance WHERE NoCOA LIKE '%" . $key . "%' OR AccountName LIKE '%" . $key . "%'");
  }
  function getMasterCFRLZ($key)
  {
    return $this->db->query("SELECT * FROM " . $this->vwMst['SettingFlowReal'] . " WHERE cf_name LIKE '%" . $key . "%' OR rlz_name LIKE '%" . $key . "%' "
      . "ORDER BY cf_key ASC");
  }

  // ===== Master Cash Flow =====
  function selectMstCashFlow()
  {
    $this->db->order_by($this->orderBy['byLevelCF'], 'ASC');
    $get    = $this->db->get($this->tblMst['CashFlow']);
    return $get->result();
  }
  function selectViewMstCashFlow($level)
  {
    $this->db->order_by($this->primary['CashFlow'], 'ASC');
    $this->db->where('cf_level', $level);
    $get    = $this->db->get($this->vwMst['CashFlow']);
    return $get->result();
  }
  function getMasterCashFlow($id)
  {
    $this->db->where($this->primary['CashFlow'], $id);
    $get    = $this->db->get($this->tblMst['CashFlow']);
    return $get->row();
  }

  function insertMstCashFlow($data)
  {
    $this->db->insert($this->tblMst['CashFlow'], $data);
  }
  function updateMstCashFlow($id, $data)
  {
    $this->db->where($this->primary['CashFlow'], $id);
    $this->db->update($this->tblMst['CashFlow'], $data);
  }

  // ===== Master Cash Realization =====
  function selectMstCashRealization()
  {
    $this->db->order_by($this->orderBy['byLevelRLZ'], 'ASC');
    $get    = $this->db->get($this->tblMst['CashRealization']);
    return $get->result();
  }
  function selectViewMstCashRealization($level)
  {
    $this->db->order_by($this->primary['CashRealization'], 'ASC');
    $this->db->where('rlz_level', $level);
    $get    = $this->db->get($this->vwMst['CashRealization']);

    return $get->result();
  }
  function getMasterCashRealization($id)
  {
    $this->db->where($this->primary['CashRealization'], $id);
    $get    = $this->db->get($this->tblMst['CashRealization']);
    return $get->row();
  }

  function insertMstCashRealization($data)
  {
    $this->db->insert($this->tblMst['CashRealization'], $data);
  }
  function updateMstCashRealization($id, $data)
  {
    $this->db->where($this->primary['CashRealization'], $id);
    $this->db->update($this->tblMst['CashRealization'], $data);
  }

  // ===== Setting Master Cash Flow and Realization =====
  function selectSettingFlowRealization($level)
  {
    $this->db->order_by($this->orderBy['PrimaryCF'], 'ASC');
    $this->db->where('cf_level', $level);
    $get    = $this->db->get($this->vwMst['SettingFlowReal']);
    return $get->result();
  }
  // ====== Setting Balance ======
  function selectSettingBalance()
  {
    $get    = $this->db->query("SELECT * FROM zhl_fin_vw_mst_coa_balance");
    return $get->result();
  }
  function updateSettingBalance($id, $data)
  {
    $this->db->where('saldo_id', $id);
    $this->db->update('zhl_fin_tblmst_awal_saldo', $data);
  }
  function insertSettingBalance($data)
  {
    $this->db->insert('zhl_fin_tblmst_awal_saldo', $data);
  }
  function deleteSettingBalance($id)
  {
    $this->db->where('saldo_id', $id);
    $this->db->delete('zhl_fin_tblmst_awal_saldo');
  }

  // #################### ===== Start Transaction Cash Bank ===== ####################
  function selectIOtype()
  {
    $select = $this->db->get('zhl_fin_tblmst_io_type');
    return $select->result();
  }
  function cekIOtype($io)
  {
    $this->db->where('io_code', $io);
    $select = $this->db->get('zhl_fin_tblmst_io_type');
    $tampil = $select->row();
    return $tampil->type_trans;
  }

  function selectSupplier($keyword)
  {
    $this->db->order_by('supplierid', 'ASC');
    $this->db->like("suppliercompany", $keyword);
    $this->db->select('supplierid, contactperson, suppliercompany');
    return $this->db->get('zhl_fin_vw_mst_supplier')->result_array();
  }
  function getSupplier($idSupp)
  {
    $this->db->limit(1);
    $this->db->where("supplierid", $idSupp);
    return $this->db->get('zhl_fin_vw_mst_supplier')->result_array();
  }
  function getSupplierCOA($idSupp)
  {
    $this->db->limit(1);
    $this->db->where("supplierid", $idSupp);
    $get =  $this->db->get('zhl_fin_vw_mst_supplier');
    if ($get->num_rows() > 0) {
      return $get->row()->nocoa;
    } else {
      return NULL;
    }
  }
  function selectCustomer($keyword)
  {
    $this->db->order_by('customer_id', 'ASC');
    $this->db->like("customer_name", $keyword);
    $this->db->select('customer_id, customer_code, customer_name, customer_company_name');
    return $this->db->get('zhl_fin_vw_mst_customer_on_mar')->result_array();
  }
  function getCustomer($idCust)
  {
    $this->db->limit(1);
    $this->db->where("customer_code", $idCust);
    return $this->db->get('zhl_fin_vw_mst_customer')->result_array();
  }
  function getCustomerCOA($idCust)
  {
    $this->db->limit(1);
    $this->db->where("customer_code", $idCust);
    $get =  $this->db->get('zhl_fin_vw_mst_customer');
    if ($get->num_rows() > 0) {
      return $get->row()->coa;
    } else {
      return NULL;
    }
  }

  function insertCashBankHeader($data)
  {
    $this->db->trans_start();
    $this->db->insert($this->tblTran['CashBankHeader'], $data);
    $headerID   = $this->db->insert_id();
    $this->db->trans_complete();

    return $headerID;
  }
  function insertCashBankDetail($data)
  {
    $this->db->insert($this->tblTran['CashBankDetail'], $data);
  }

  function updateCashBankHeader($txtHeaderID, $data)
  {
    $this->db->where('header_id', $txtHeaderID);
    $this->db->update($this->tblTran['CashBankHeader'], $data);
  }
  function deleteCashBankDetail($txtNoReff)
  {
    $this->db->where('detail_id', $txtNoReff);
    $this->db->delete($this->tblTran['CashBankDetail']);
  }
  function updateCashBankDetail($txtDetailID, $data)
  {
    $this->db->where('detail_id', $txtDetailID);
    $this->db->update($this->tblTran['CashBankDetail'], $data);
  }
  public function getDetailIdJur($NoJurnal) {
    $this->db->select('DetailID');
    $this->db->where('NoJurnal', $NoJurnal);
    $query = $this->db->get('zht_acc_tbl_trn_jurnal_tims');
    return array_column($query->result_array(), 'DetailID');
  }
  function updateToJurnalAcc($noJurnal, $data)
  {
    $this->db->where('DetailID', $noJurnal);
    $this->db->update('zht_acc_tbl_trn_jurnal_tims', $data);
  }

  function deleteJrnlDetail($detailJur)
  {
    $this->db->where('NoJurnal', $detailJur);
    $this->db->delete('zht_acc_tbl_trn_jurnal_tims');
  }

  public function getDetailIDsByHeader($headerID) {
    $this->db->select('detail_id');
    $this->db->where('header_id', $headerID);
    $query = $this->db->get($this->tblTran['CashBankDetail']);
    return array_column($query->result_array(), 'detail_id');
  }

  function deleteGstPayable($txtNoReff)
  {
      $this->db->where('ref_nomor', $txtNoReff);
      $this->db->delete('zht_acc_tbl_trn_gst');
  }
  function updateCashBankHistory($detailIDHistory, $data)
  {
    $this->db->where('detail_id', $detailIDHistory);
    $this->db->update('zht_fin_tbltrn_cashbank_journal_history', $data);
  }

  function deleteHstryDetail($detailHstry)
  {
    $this->db->where('detail_id', $detailHstry);
    $this->db->delete('zht_fin_tbltrn_cashbank_journal_history');
  }
  public function getDetailIdHstry($NoFacture) {
    $this->db->select('detail_id');
    $this->db->where('no_facture', $NoFacture);
    $query = $this->db->get('zht_fin_tbltrn_cashbank_journal_history');
    return array_column($query->result_array(), 'detail_id');
  }

  // cash bank edit update
  function getDetailHistory($headerID)
  {
    $this->db->where('header_id', $headerID);
    $get = $this->db->get('zht_fin_tbltrn_cashbank_journal_history');
    return $get->result();
  }

  function getDetailJurnal($NoJurnal)
  {
    $this->db->where('NoJurnal', $NoJurnal);
    $get = $this->db->get('zht_acc_tbl_trn_jurnal_tims');
    return $get->result();
  }
  // #################### ===== End Transaction Cash Bank ===== ####################
  // 
  // #################### ===== Start Transaction Panding Cash ===== ####################
  function insertPendingCash($data)
  {
    $this->db->trans_start();
    $this->db->insert('zhl_fin_tbltrn_pending_cash', $data);
    $id = $this->db->insert_id();
    $this->db->trans_complete();
    return $id;
  }
  function selectPendingCash()
  {
    return $this->db->get('zhl_fin_vw_trn_pending_cash');
  }
  // #################### ===== End Transaction Panding Cash ===== ####################
  // 
  // #################### ====== START Transaction PaymentAP ====== ####################
  function getNoFactureInFin($type)
  {
    $thisMonth  = date('m');
    $this->db->order_by('header_id', 'DESC');
    $this->db->limit(1);
    $this->db->select('no_facture');
    $this->db->where("no_facture LIKE '%" . $type . "%' AND MONTH(trans_date) ='" . $thisMonth . "'");
    $get = $this->db->get($this->tblTran['PaymentAPheader']);
    $row = $get->row();
    if ($get->num_rows() > 0) {
      return substr($row->no_facture, 0, 4);
    } else {
      return 0000;
    }
  }

  function simpan_gst_payable($gst_item)
  {
    $this->db->insert('zht_acc_tbl_trn_gst', $gst_item);
  }

  function getJurnalNumCode($keyword)
  {
    $this->db->order_by('NomorAP', 'DESC');
    $this->db->like("NomorAP", $keyword);
    $this->db->where("NomorAP NOT IN (SELECT no_voucher FROM fin_tbltrn_payment_hdr)");
    return $this->db->get('zht_acc_tbl_trn_appaymenthdr')->result_array();
  }
  function getUtangByCode($id)
  {
    $this->db->where('NomorAP', $id);
    $query = $this->db->get('zhl_fin_vw_trn_appayment');
    return $query->row();
  }
  function countTotalAP($idAP)
  {
    $get = $this->db->query("SELECT SUM(Total) AS TotalAmount FROM zhl_fin_vw_trn_appayment WHERE NomorAP = '" . $idAP . "'");
    $val = $get->row();
    return $val->TotalAmount;
  }
  function getKursAccById($id)
  {
    return $query = $this->db->query("SELECT * FROM zhl_acc_tbl_trn_kurs WHERE currency_id = '" . $id . "' ORDER BY periode DESC LIMIT 1");
  }
  function getRateSGD($cur)
  {
    $get = $this->db->query("SELECT * FROM zhl_acc_tbl_trn_kurs WHERE currency_id = '" . $cur . "' ORDER BY periode DESC LIMIT 1");
    $row = $get->row();
    return $row->rate_usd;
  }
  function getInvoiceByAPnumber($apNumber)
  {
    $get = $this->db->query("SELECT NoInvoice FROM zht_acc_tbl_trn_appaymentdtl WHERE NomorAP = '" . $apNumber . "'");
    return $get->result_array();
  }
  function getTotalFromAPAcc($noInvoice, $idVoucher)
  {
    $get = $this->db->query("SELECT Total FROM zht_acc_tbl_trn_appaymentdtl WHERE NoInvoice = '" . $noInvoice . "' AND NomorAP = '" . $idVoucher . "'");
    $row = $get->row();
    return $row->Total;
  }
  function getHutangFromUtang($noInvoice, $jenis)
  {
    $get = $this->db->query("SELECT nofaktur, saldo_hutang FROM zht_acc_tbl_trn_hutang WHERE nofaktur = '" . $noInvoice . "' AND jenis_trans ='" . $jenis . "' ");
    $row = $get->row();
    return $row->saldo_hutang;
  }
  function getBayarFromUtang($noInvoice, $jenis)
  {
    $get = $this->db->query("SELECT nofaktur, bayar FROM zht_acc_tbl_trn_hutang WHERE nofaktur = '" . $noInvoice . "' AND jenis_trans ='" . $jenis . "'");
    $row = $get->row();
    return $row->bayar;
  }
  function getHutangFromUtangBulanan($noInvoice, $jenis, $blnPeriod, $thnPeriod)
  {
    $get = $this->db->query("SELECT nofaktur, saldo_hutang FROM zht_acc_tbl_trn_hutang_bulanan WHERE nofaktur = '" . $noInvoice . "' AND jenis_trans ='" . $jenis . "' AND "
      . "periode_bulan = '" . $blnPeriod . "' AND periode_tahun = '" . $thnPeriod . "'");
    $row = $get->row();
    return $row->saldo_hutang;
  }
  function getBayarFromUtangBulanan($noInvoice, $jenis, $blnPeriod, $thnPeriod)
  {
    $get = $this->db->query("SELECT nofaktur, bayar FROM zht_acc_tbl_trn_hutang_bulanan WHERE nofaktur = '" . $noInvoice . "' AND jenis_trans ='" . $jenis . "' AND "
      . "periode_bulan = '" . $blnPeriod . "' AND periode_tahun = '" . $thnPeriod . "'");
    $row = $get->row();
    return $row->bayar;
  }
  // ==== get Review
  function getAPheaderByHeaderID($hdrID)
  {
    $this->db->where('header_id', $hdrID);
    $get = $this->db->get('zht_fin_tbltrn_payment_hdr');
    return $get->row();
  }
  function getAPdetailByHeaderID($hdrID)
  {
    $this->db->where('header_id', $hdrID);
    $get = $this->db->get('zht_fin_tbltrn_payment_dtl');
    return $get->result();
  }
  // ==== Insert (Do Action)
  function insertHeaderAPpayment($data)
  {
    $this->db->trans_start();
    $this->db->insert($this->tblTran['PaymentAPheader'], $data);
    $hdrID  = $this->db->insert_id();
    $this->db->trans_complete();

    return $hdrID;
  }
  
  public function save_file($data)
  {
      $this->db->insert('zht_tbl_trn_file_cashbank_detail', $data);
      return $this->db->affected_rows();
  }

  public function list_attach($nota)
  {
      $this->db->select('*');
      $this->db->from('zht_tbl_trn_file_cashbank_detail');
      $this->db->where('NoJurnal', $nota);
      return $this->db->get()->result();
  }

  public function get_file_by_id($file_id)
  {
      $this->db->select('*');
      $this->db->from('zht_tbl_trn_file_cashbank_detail');
      $this->db->where('file_id', $file_id);
      return $this->db->get()->result();
  }

  public function update_file($file_id, $data) {
    $this->db->where('file_id', $file_id);
    return $this->db->update('zht_tbl_trn_file_cashbank_detail', $data);
}

  public function delete_file($id)
  {
      $this->db->where('file_id', $id);
      $this->db->delete('zht_tbl_trn_file_cashbank_detail');
  }
  function insertDetailAPpayment($data)
  {
    $this->db->insert($this->tblTran['PaymentAPdetail'], $data);
  }
  function insertCBhistory($data)
  {
    $this->db->insert('zht_fin_tbltrn_cashbank_journal_history', $data);
  }
  function updateUtangByNoInvoiceInOneAPnumber($noInvoice, $jenis, $data)
  {
    $this->db->where('nofaktur', $noInvoice);
    $this->db->where('jenis_trans', $jenis);
    $this->db->update('zht_acc_tbl_trn_hutang', $data);
  }
  function updateUtangBulananByNoInvoiceInOneAPnumber($noInvoice, $jenis, $blnPeriod, $thnPeriod, $data)
  {
    $this->db->where(array('nofaktur' => $noInvoice, 'jenis_trans' => $jenis, 'periode_bulan' => $blnPeriod, 'periode_tahun' => $thnPeriod));
    $this->db->update('zht_acc_tbl_trn_hutang_bulanan', $data);
  }
  function updateUtangBulananByNoInvoiceInOneAPnumberQuery($noInvoice, $jenis, $blnPeriod, $thnPeriod, $payment)
  {
    $this->db->query("UPDATE zht_acc_tbl_trn_hutang_bulanan SET `bayar` = `bayar` + '" . $payment . "', `saldo_hutang` = `saldo_hutang` - '" . $payment . "' "
      . "WHERE nofaktur = '" . $noInvoice . "' AND jenis_trans ='" . $jenis . "' AND periode_bulan = '" . $blnPeriod . "' AND periode_tahun = '" . $thnPeriod . "' ");
  }
  function updateUtangBulananByNoInvoiceInOneAPnumberQueryReturn($noInvoice, $jenis, $blnPeriod, $thnPeriod, $payment)
  {
    $this->db->query("UPDATE zht_acc_tbl_trn_hutang_bulanan SET `bayar` = `bayar` - '" . $payment . "', `saldo_hutang` = `saldo_hutang` + '" . $payment . "' "
      . "WHERE nofaktur = '" . $noInvoice . "' AND jenis_trans ='" . $jenis . "' AND periode_bulan = '" . $blnPeriod . "' AND periode_tahun = '" . $thnPeriod . "' ");
  }
  function updateRealisasiInAPdetail($idVoucher, $noInvoice)
  {
    $this->db->where('NomorAP', $idVoucher);
    $this->db->where('NoInvoice', $noInvoice);
    $this->db->update('zht_acc_tbl_trn_appaymentdtl', array('realisasi_by' => $this->session->userdata('userid_1'), 'realisasi_date' => date('Y-m-d H:i:s')));
  }
  // == Insert Into Jurnal
  function insertToJurnalAcc($data)
  {
    $this->db->insert('zht_acc_tbl_trn_jurnal_tims', $data);
  }
  // #################### ====== END Transaction PaymentAP ====== ####################
  // 
  // #################### ====== START Transaction PaymentAR ====== ####################
  function getJurnalNumCodeAR($key)
  {
    $this->db->order_by('NomorAR', 'ASC');
    $this->db->like("NomorAR", $key);
    $this->db->where("NomorAR NOT IN (SELECT no_voucher FROM fin_tbltrn_payment_hdr)");
    return $this->db->get('zhl_acc_tbl_trn_arpaymenthdr')->result_array();
  }
  function getUtangByCodeAR($id)
  {
    $this->db->where('NomorAR', $id);
    $query = $this->db->get('zhl_fin_vw_trn_arpayment');
    return $query->row();
  }
  function countTotalAR($idAR)
  {
    $get = $this->db->query("SELECT SUM(Total) AS TotalAmount FROM zhl_fin_vw_trn_arpayment WHERE NomorAR = '" . $idAR . "'");
    $val = $get->row();
    return $val->TotalAmount;
  }
  function getInvoiceByARnumber($arNumber)
  {
    $get = $this->db->query("SELECT NoInvoice FROM zhl_acc_tbl_trn_arpaymentdtl_tims WHERE NomorAR = '" . $arNumber . "'");
    return $get->result_array();
  }
  function getTotalFromARAcc($noInvoice, $idVoucher)
  {
    $get = $this->db->query("SELECT Total FROM zhl_acc_tbl_trn_arpaymentdtl_tims WHERE NoInvoice = '" . $noInvoice . "' AND NomorAR = '" . $idVoucher . "'");
    $row = $get->row();
    return $row->Total;
  }
  function getBayarFromPiutang($noInvoice, $jenis)
  {
    $get = $this->db->query("SELECT nofaktur, bayar FROM zhl_acc_tbl_trn_piutang_tims WHERE nofaktur = '" . $noInvoice . "' AND jenis_trans = '" . $jenis . "'");
    $row = $get->row();
    return $row->bayar;
  }
  function getBayarFromPiutangBulanan($noInvoice, $jenis, $blnPeriod, $thnPeriod)
  {
    $get = $this->db->query("SELECT nofaktur, bayar FROM zhl_acc_tbl_trn_piutang_tims_bulanan WHERE nofaktur = '" . $noInvoice . "' AND "
      . "jenis_trans = '" . $jenis . "' AND periode_bulan = '" . $blnPeriod . "' AND periode_tahun = '" . $thnPeriod . "'");
    $row = $get->row();
    return $row->bayar;
  }
  // ==== Insert (Do Action)
  function updatePiutangByNoInvoiceInOneARnumber($noInvoice, $jenis, $data)
  {
    $this->db->where('nofaktur', $noInvoice);
    $this->db->where('jenis_trans', $jenis);
    $this->db->update('zhl_acc_tbl_trn_piutang_tims', $data);
  }
  function updatepiutangBulananByNoInvoiceInOneARnumber($noInvoice, $jenis, $blnPeriod, $thnPeriod, $data)
  {
    $this->db->where(array('nofaktur' => $noInvoice, 'jenis_trans' => $jenis, 'periode_bulan' => $blnPeriod, 'periode_tahun' => $thnPeriod));
    $this->db->update('zhl_acc_tbl_trn_piutang_tims_bulanan', $data);
  }
  function updatepiutangBulananByNoInvoiceInOneARnumberQuery($noInvoice, $jenis, $blnPeriod, $thnPeriod, $payment)
  {
    $this->db->query("UPDATE zhl_acc_tbl_trn_piutang_tims_bulanan SET bayar = bayar + '" . $payment . "' WHERE nofaktur = '" . $noInvoice . "' AND "
      . "periode_bulan = '" . $blnPeriod . "' AND jenis_trans = '" . $jenis . "' AND periode_tahun = '" . $thnPeriod . "'");
  }
  function updatepiutangBulananByNoInvoiceInOneARnumberQueryReturn($noInvoice, $jenis, $blnPeriod, $thnPeriod, $payment)
  {
    $this->db->query("UPDATE zhl_acc_tbl_trn_piutang_tims_bulanan SET bayar = bayar - '" . $payment . "' WHERE nofaktur = '" . $noInvoice . "' AND "
      . "periode_bulan = '" . $blnPeriod . "' AND jenis_trans = '" . $jenis . "' AND periode_tahun = '" . $thnPeriod . "'");
  }
  function updateRealisasiInARdetail($idVoucher, $noInvoice)
  {
    $this->db->where('NomorAP', $idVoucher);
    $this->db->where('NoInvoice', $noInvoice);
    $this->db->update('zhl_acc_tbl_trn_arpaymentdtl_tims', array('realisasi_by' => $this->session->userdata('userid_1'), 'realisasi_date' => date('Y-m-d H:i:s')));
  }
  // #################### ====== END Transaction PaymentAR ====== ####################
}
