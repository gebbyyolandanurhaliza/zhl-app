<?php defined('BASEPATH') or exit('No direct script access allowed');

/* 
 * Author : ITD15
 */

class CBtrans extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();

    //is_maintenance(FALSE, $this->session->userdata('userid_1'));

    if (!$this->session->userdata('userid_1')) {
      redirect('login');
    }

    date_default_timezone_set("Asia/Jakarta");
    $this->load->model(array('M_Fin_CB', 'M_CashBank', 'M_General_Journal','M_vcdn','M_login'));
  }

  public function index()
  {
    $company   = strtoupper($this->session->userdata('company_id'));
    $data['_selectMasterCOA']   = $this->M_Fin_CB->selectCOAforCBtrans($company)->result();
    $data['_selectIOtype']      = $this->M_Fin_CB->selectIOtypeForCB();
    $data['_selectCurrency']    = $this->db->get('gen_tbl_mst_currency')->result();
    $data['_selectGST']         = $this->db->get('gen_tbl_mst_gst')->result();
    $data['_selectGroup']       = $this->db->get('acc_report_group')->result();
    $data['dept_code']          = $this->M_General_Journal->get_departmentcode();
    $data['dept_code_json']     = json_encode($data['dept_code']);
    $data['List_coa']           = $this->M_vcdn->get_coa($company);


    $this->template->display('finance/transaction/cb_trans/index', $data);
  }

  function newGenerateReffNumber()
  {
    $type       = $this->input->get('txtTypeForGen');
    $currency   = $this->input->get('txtCurrForGen');
    $tanggal    = date('Y-m-d', strtotime($this->input->get('txtDateForGen')));

    // if()

    // echo $tanggal;
    // echo date('ym', strtotime($this->input->get('txtDateForGen')));

    if ($type == 'O' || $type == 'OUT') {
      $num    = $this->M_Fin_CB->newCheckReffNumber('OUT', $tanggal, $currency);
      $get    = str_pad($num, 4, 0, STR_PAD_LEFT);
      if ($currency == 'USD') {
        $set    = 'BPU' . date('ym', strtotime($this->input->get('txtDateForGen'))) . $get;
      } elseif ($currency == 'SGD') {
        $set    = 'BP' . date('ym', strtotime($this->input->get('txtDateForGen'))) . $get;
      }elseif ($currency == 'IDR') {
        $set    = 'IDRP' . date('ym', strtotime($this->input->get('txtDateForGen'))) . $get;
      }
    } elseif ($type == 'I' || $type == 'IN') {
      $num    = $this->M_Fin_CB->newCheckReffNumber('IN', $tanggal, $currency);
      $get    = str_pad($num, 4, 0, STR_PAD_LEFT);
      if ($currency == 'USD') {
        $set    = 'BRU' . date('ym', strtotime($this->input->get('txtDateForGen'))) . $get;
      } elseif ($currency == 'SGD') {
        $set    = 'BR' . date('ym', strtotime($this->input->get('txtDateForGen'))) . $get;
      }elseif ($currency == 'IDR') {
        $set    = 'IDRR' . date('ym', strtotime($this->input->get('txtDateForGen'))) . $get;
      }
    }
    echo $set;

    // echo $type;
  }

  function newGenerateReffNumberForCash()
  {
    $type       = $this->input->get('txtTypeForGen');
    // $currency   = $this->input->get('txtCurrForGen');
    $tanggal    = date('Y-m-d', strtotime($this->input->get('txtDateForGen')));

    // if()

    // echo $tanggal;
    // echo date('ym', strtotime($this->input->get('txtDateForGen')));
    $set = '';
    if ($type == 'O' || $type == 'OUT') {
      // $num    = $this->M_Fin_CB->newCheckReffNumberCash('OUT', $tanggal, $currency);
      $num    = $this->M_Fin_CB->newCheckReffNumberCash('OUT', $tanggal);
      $get    = str_pad($num, 4, 0, STR_PAD_LEFT);
      // if ($currency == 'USD') {
      $set    = 'CP' . date('ym', strtotime($this->input->get('txtDateForGen'))) . $get;
      // }elseif ($currency == 'SGD') {
      //     $set    = 'BP'.date('ym',strtotime($this->input->get('txtDateForGen'))).$get;
      // }
    } elseif ($type == 'I' || $type == 'IN') {
      $num    = $this->M_Fin_CB->newCheckReffNumberCash('IN', $tanggal);
      $get    = str_pad($num, 4, 0, STR_PAD_LEFT);
      // if ($currency == 'USD') {
      $set    = 'CR' . date('ym', strtotime($this->input->get('txtDateForGen'))) . $get;
      // }elseif ($currency == 'SGD') {
      //     $set    = 'BR'.date('ym',strtotime($this->input->get('txtDateForGen'))).$get;
      // }
    }
    echo $set;
  }

  function generateReffNumCB()
  {
    $tgl    = date('Y-m-d', strtotime($this->input->post('txtTglTrans')));
    $type   = $this->input->post('txtTypeIO');

    $num    = $this->M_Fin_CB->countReffCB($tgl, $type);
    $get    = str_pad($num, 4, 0, STR_PAD_LEFT);
    $set    = date('ym', strtotime($tgl)) . $get;
    echo    $set;
  }
  function cekNumReff()
  {
    $value  = $this->input->post('value');
    $this->db->where('no_reff', $value);
    $get    = $this->db->get('fin_tbltrn_cashbank_journal_header');
    if ($get->num_rows() > 0) {
      echo 1;
    } else {
      echo 0;
    }
  }
  function getRateByCurrency()
  {
    $currID = $this->input->post('txtCurrID');
    $tgl    = $this->input->post('txtTglTrans');
    $get    = $this->M_Fin_CB->getKursByIDforCB($currID, $tgl)->row();
    $data   = array(
      'rateUSD'   => $get->rate_usd,
      'rateSGD'   => $get->rate_kurs
    );
    echo json_encode($data);
  }
  function getRateByBankAccount()
  {
    $bank   = $this->input->post('txtBankAccount');
    $tgl    = $this->input->post('txtTglTrans');
    $curr   = $this->M_Fin_CB->selectCurrByBankAccount($bank);

    $get    = $this->M_Fin_CB->getKursByIDforCB($curr, $tgl)->row();
    $data   = array(
      'rateUSD'   => $get->rate_usd,
      'rateSGD'   => $get->rate_kurs,
      'currency'  => $curr
    );
    echo json_encode($data);
  }
  function selectCOA()
  {
    $company   = strtoupper($this->session->userdata('company_id'));
    $data   = array(
      '_getMasterCOA' => $this->M_Fin_CB->selectMasterCOAforCB($company)->result()
    );
    
    $this->load->view('finance/transaction/cb_trans/selectMCOA', $data);
  }
  function selectCOAforAddCost()
  {
    $data   = array(
      '_getMasterCOA' => $this->M_Fin_CB->selectMasterCOAforAddCost()->result()
    );
    $this->load->view('finance/transaction/cb_trans/selectMCOAforAddCost', $data);
  }
  function selectCOArow2()
  {
    $company   = strtoupper($this->session->userdata('company_id'));
    $data   = array(
      '_getMasterCOA' => $this->M_Fin_CB->selectMasterCOAforCB($company)->result()
    );
    $this->load->view('finance/transaction/cb_trans/selectMCOA-row2', $data);
  }
  function getIOtypeTransByCode()
  {
    $codeIO = $this->input->post('selectIOtype');
    $get    = $this->M_Fin_CB->getTransTypeIObyCode($codeIO)->row();
    echo $get->type_trans;
  }
  function selectSupplierForCB()
  {
    $data   = array(
      '_selectSupplier' => $this->M_Fin_CB->selectSupplierforCBtrans()->result()
    );
    $this->load->view('finance/transaction/cb_trans/selectSupplier', $data);
  }
  function selectCustomerForCB()
  {
    $data   = array(
      '_selectCustomer' => $this->M_Fin_CB->selectCustomerforCBtrans()->result()
    );
    $this->load->view('finance/transaction/cb_trans/selectCustomer', $data);
  }
  function selectPObySupplierForCB()
  {
    $suppID = $this->input->post('txtSuppID');
    $data   = array(
      '_selectPO' => $this->M_Fin_CB->selectPObySupplierForCBtrans($suppID)->result()
    );
    $this->load->view('finance/transaction/cb_trans/selectPO', $data);
  }
  function selectPObyCustomerForCB()
  {
    $custID = $this->input->post('txtCustID');
    $data   = array(
      'test'      => $custID,
      '_selectPO' => $this->M_Fin_CB->selectPObyCustomerForCBtrans($custID)->result()
    );
    $this->load->view('finance/transaction/cb_trans/selectPOcust', $data);
  }
  function addGST()
  {
    $data['_selectGST']         = $this->db->get('gen_tbl_mst_gst')->result();
    $this->load->view('finance/transaction/cb_trans/addGST', $data);
  }
  function getCOAdp()
  {
    $codeIO = $this->input->post('txtIOtype');
    $get    = $this->M_Fin_CB->getCOAforDPcashBank($codeIO)->row();
    $data   = array(
      'no_coa'    => $get->no_coa,
      'nm_coa'    => $get->name_coa
    );
    echo json_encode($data);
  }

  // #################################################################################
  // #################################################################################
  // ========== ## Insert Cash Bank Transaction ## ==========
  function insertTransactionCB()
  {
    $prepaid    = $this->input->post('selPrepaid');
    $IOtype     = $this->input->post('txtIOtypeForPO');
    if ($prepaid == 1 && $IOtype == 'O') {
      $supp       = $this->input->post('txtSup');
      $suppCOA    = $this->input->post('txtSupCOA');
      $subType    = 'DPO';
    } elseif ($prepaid == 1 && $IOtype == 'I') {
      $supp       = $this->input->post('txtCos');
      $suppCOA    = $this->input->post('txtCosCOA');
      $subType    = 'DPI';
    } else {
      $supp       = '';
      $suppCOA    = '';
      $subType    = '';
    }
    $data   = array(
      'no_reff'           => $this->input->post('txtNoReff'),
      'trans_type'        => $this->input->post('txtIO'),
      'date1'             => date('Y-m-d', strtotime($this->input->post('txtDate1'))),
      'cashbank_code'     => $this->input->post('selCBCode'),
      'check_bank'        => $this->input->post('txtCheckBank'),
      'from_to'           => $this->input->post('txtFromTo'),
      'trans_description' => $this->input->post('txtDescription'),
      'prepaid'           => $prepaid,
      'suplier'           => $supp,
      'coa_suplier'       => $suppCOA,
      'currency_id'       => $this->input->post('txtCurr'),
      'currency_rate'     => str_replace(',', '', $this->input->post('txtRateCurr')),
      'rate_awal'         => str_replace(',', '', $this->input->post('txtRateCurr')),
      'rate_akhir'        => str_replace(',', '', $this->input->post('txtRateCurr')),
      'dp_rate_sgd'       => str_replace(',', '', $this->input->post('txtRateCurrSGD')),
      'created_by'        => $this->session->userdata('userid_1'),
      'created_date'      => date('Y-m-d H:i:s')
    );
    $headerID   = $this->M_CashBank->insertCashBankHeader($data);


    $txtNoCOA       = $this->input->post("txtNoCOA");
    $txtNameCOA     = $this->input->post('txtNameCOA');
    $txtDebit       = $this->input->post('txtDebit');
    $txtCredit      = $this->input->post('txtCredit');
    $txtDebitUSD    = $this->input->post('txtDebitUSD');
    $txtCreditUSD   = $this->input->post('txtCreditUSD');
    $txtRemark      = $this->input->post('txtRemark');
    $txtGSTname     = $this->input->post('txtGST');
    $txtGSTvalue    = $this->input->post('txtGSTvalue');
    $txtBlCode        = $this->input->post('txtBlCode');
    $txtDept        = $this->input->post('txtDeptCode');
    //$txtCashFlow	= $this->input->post('txtCashFlowKey');
    for ($x = 0; $x < count($txtNoCOA); $x++) :
      $detail = array(
        'header_id'         => $headerID,
        'no_reff'           => $this->input->post('txtNoReff'),
        'coa'               => $txtNoCOA[$x],
        'coa_description'   => $txtNameCOA[$x],
        'debit'             => str_replace(',', '', $txtDebit[$x]),
        'credit'            => str_replace(',', '', $txtCredit[$x]),
        'remark'            => $txtRemark[$x],
        'gst_type'          => $txtGSTname[$x],
        'gst_value'         => str_replace(',', '', $txtGSTvalue[$x]),
        'debit_USD'         => round(str_replace(',', '', $txtDebitUSD[$x]), 2),
        'credit_USD'        => round(str_replace(',', '', $txtCreditUSD[$x]), 2),
        'created_by'        => $this->session->userdata('userid_1'),
        'created_date'      => date('Y-m-d H:i:s'),
        'dept_code'         => $txtDept[$x],
        'blCode'         => $txtBlCode[$x]

      );
      $this->M_CashBank->insertCashBankDetail($detail);
    endfor;

    // ## INSERT TO HISTORY ================================================
    for ($i = 0; $i < count($txtNoCOA); $i++) :
      if ($txtCredit[$i] <> 0) {
        $dk     = 'C';
        $jml    = 0 - str_replace(',', '', $txtCredit[$i]);
      } else {
        $dk     = 'D';
        $jml    = str_replace(',', '', $txtDebit[$i]);
      }
      $history    = array(
        'header_id'         => $headerID,
        'no_facture'        => $this->input->post('txtNoReff'),
        'trans_type'        => $this->input->post('txtIO'),
        'date1'             => date('Y-m-d', strtotime($this->input->post('txtDate1'))),
        'cb_code'           => $this->input->post('selCBCode'),
        'from_to'           => $this->input->post('txtFromTo'),
        'trans_description' => $this->input->post('txtDescription'),
        'prepaid'           => $prepaid,
        'supplier'          => $supp,
        'coa_supplier'      => $suppCOA,
        'currency_id'       => $this->input->post('txtCurr'),
        'currency_rate'     => str_replace(',', '', $this->input->post('txtRateCurr')),
        'coa_code'          => $txtNoCOA[$i],
        'coa_description'   => $txtNameCOA[$i],
        'debit_credit'      => $dk,
        'jumlah'            => $jml,
        'debit'             => str_replace(',', '', $txtDebit[$i]),
        'credit'            => str_replace(',', '', $txtCredit[$i]),
        'remark'            => $txtRemark[$i],
        //'key_cf'            => $txtCashFlow[$i],
        'created_by'        => $this->session->userdata('userid_1'),
        'created_date'      => date('Y-m-d H:i:s')
      );
      $this->M_CashBank->insertCBhistory($history);
    endfor;

    $debet          = 0;
    $debet_sgd      = 0;
    $credit         = 0;
    $credit_sgd     = 0;
    $sum_debet      = 0;
    $sum_credit     = 0;
    $sum_debet_sgd  = 0;
    $sum_credit_sgd = 0;

    // ## INSERT TO JOURNAL ACCOUNTING =====================================
    // $getKursSGD = $this->M_Fin_CB->getKursByIDforCB($this->input->post('txtCurr'), $this->input->post('txtDate1'))->row();
    $rate_SGD = str_replace(',', '', $this->input->post('txtRateCurrSGD'));

    $period = $this->M_CashBank->getPeriod();
    for ($y = 0; $y < count($txtNoCOA); $y++) :
      if ($txtCredit[$y] <> 0) {
        $dk             = 'C';
        $jml            = str_replace(',', '', $txtCredit[$y]);
        $debet          = '0';
        $debet_sgd      = '0';
        $credit         = number_format(str_replace(",", "", $txtCreditUSD[$y]), 2, ".", "");
        $credit_sgd     = number_format(str_replace(",", "", $txtCredit[$y]) * $rate_SGD, 2, ".", "");
        $sum_credit     +=  $credit;
        $sum_credit_sgd += $credit_sgd;
      } else {
        $dk             = 'D';
        $jml            = str_replace(',', '', $txtDebit[$y]);
        $debet          = number_format(str_replace(",", "", $txtDebitUSD[$y]), 2, ".", "");
        $debet_sgd      = number_format(str_replace(",", "", $txtDebit[$y]) * $rate_SGD, 2, ".", "");
        $credit         = '0';
        $credit_sgd     = '0';
        $sum_debet      += $debet;
        $sum_debet_sgd  += $debet_sgd;
      }

      if ((count($txtNoCOA) - 1) == $y) {
        $selisih = $sum_debet - $sum_credit;

        if ($selisih != 0) {
          if ($dk == 'D') {
            $debet  = $debet - $selisih;
          } else {
            $credit = $credit + $selisih;
          }
        }

        $selisih_sgd = $sum_debet_sgd - $sum_credit_sgd;

        if ($selisih_sgd != 0) {
          if ($dk == 'D') {
            $debet_sgd = $debet_sgd - $selisih_sgd;
          } else {
            $credit_sgd = $credit_sgd + $selisih_sgd;
          }
        }
      }

      $dataJurnal = array(
        'JenisJurnalID'     => $txtRemark[$y],
        'jenis_trans'       => $this->input->post('txtIO'),
        'CompanyID'         => 'ZHL',
        'Tanggal'           => date('Y-m-d', strtotime($this->input->post('txtDate1'))),
        'NoJurnal'          => $this->input->post('txtNoReff'),
        'NoJurnalDtl'       => $this->input->post('txtCheckBank'),
        'Periode'           => date('mY', strtotime($period)),
        'NoCOA'             => $txtNoCOA[$y],
        'sub_account_type'  => $subType,
        'sub_account_id'    => $supp,
        'gst_type'          => $txtGSTname[$y],
        'gst_value'         => str_replace(',', '', $txtGSTvalue[$y]),
        'Uraian'            => $this->input->post('txtDescription'),
        'Debet'             => round($debet, 2),
        'Kredit'            => round($credit, 2),
        'Debet_SGD'         => round($debet_sgd, 2),
        'Kredit_SGD'        => round($credit_sgd, 2),
        'chk'               => $dk,
        'Total'             => round($jml, 2),
        'Currency'          => $this->input->post('txtCurr'),
        'Rate'              => str_replace(',', '', $this->input->post('txtRateCurr')),
        'rate_sgd'          => str_replace(',', '', $this->input->post('txtRateCurrSGD')),
        'Keterangan'        => $this->input->post('txtDescription'),
        'created_by'        => $this->session->userdata('userid_1'),
        'created_date'      => date('Y-m-d H:i:s'),
        'dept_code'         => $txtDept[$y],
        'blCode'            => $txtBlCode[$y]
      );

      if ($jml <> 0) {
        $this->M_CashBank->insertToJurnalAcc($dataJurnal);
      }

      $gst_item = array(
        'ref_nomor'         => $this->input->post('txtNoReff'),
        'jenis_trans'       => $this->input->post('txtIO'),
        'item'              => $this->input->post('txtDescription'),
        'po_no'             => '',
        'qty'               => 1,
        'gst_type'          => $txtGSTname[$y],
        'gst_value'         => round(str_replace(",", "", $txtGSTvalue[$y]), 2),
        'unit'              => '',
        'price'             => round($jml, 2),
        'currency'          => $this->input->post('txtCurr'),
        'rate'              => str_replace(',', '', $this->input->post('txtRateCurr')),
        'rate_sgd'          => str_replace(',', '', $this->input->post('txtRateCurrSGD')),
        'created_by'        => $this->session->userdata('userid_1'),
        'created_date'      => date('Y-m-d H:i:s')
      );

      if ($txtGSTname[$y] <> "") {
        $this->M_CashBank->simpan_gst_payable($gst_item);
      }
    endfor;

    // ## INSERT Detail PO DOWN PAYMENT ====================================
    $txtIOtype  = $this->input->post('txtIOtypeForPO');
    $txtPrepid  = $this->input->post('selPrepaid');
    $txtSuppID  = $this->input->post('txtSup');
    $txtCustID  = $this->input->post('txtCos');

    if ($txtIOtype == 'O' && $txtPrepid == 1) {
      $this->insertDetailPOinCashBank($headerID, $txtSuppID, 'PUR');
    } elseif ($txtIOtype == 'I' && $txtPrepid == 1) {
      $this->insertDetailPOinCashBank($headerID, $txtCustID, 'MAR');
    }

    redirect(site_url('CBtrans/reviewCashBank/' . encode_str($headerID)));
  }

  // ================== UPDATE Cash Bank Transaction ==========================
  function updateTransactionCB(){
    $action = $this->input->post('action');
    $txtNoReff = $this->input->post('txtNoReff');
    $txtDetailID = $this->input->post('txtDetailID');
    $primary    = decode_str($this->input->post('txtPrimaryCashBank'));

    if ($action === 'update') {
      // ini untuk variabel update header
      $prepaid    = $this->input->post('selPrepaid');
      $IOtype     = $this->input->post('txtIOtypeForPO');
      if ($prepaid == 1 && $IOtype == 'O') {
        $supp       = $this->input->post('txtSup');
        $suppCOA    = $this->input->post('txtSupCOA');
        $subType    = 'DPO';
      } elseif ($prepaid == 1 && $IOtype == 'I') {
        $supp       = $this->input->post('txtCos');
        $suppCOA    = $this->input->post('txtCosCOA');
        $subType    = 'DPI';
      } else {
        $supp       = '';
        $suppCOA    = '';
        $subType    = '';
      }

      $data   = array(
        'trans_type'        => $this->input->post('txtIO'),
        'date1'             => date('Y-m-d', strtotime($this->input->post('txtDate1'))),
        'cashbank_code'     => $this->input->post('selCBCode'),
        'check_bank'        => $this->input->post('txtCheckBank'),
        'from_to'           => $this->input->post('txtFromTo'),
        'trans_description' => $this->input->post('txtDescription'),
        'prepaid'           => $prepaid,
        'suplier'           => $supp,
        'coa_suplier'       => $suppCOA,
        'currency_id'       => $this->input->post('txtCurr'),
        'currency_rate'     => str_replace(',', '', $this->input->post('txtRateCurr')),
        'rate_awal'         => str_replace(',', '', $this->input->post('txtRateCurr')),
        'rate_akhir'        => str_replace(',', '', $this->input->post('txtRateCurr')),
        'dp_rate_sgd'       => str_replace(',', '', $this->input->post('txtRateCurrSGD')),
        'created_by'        => $this->session->userdata('userid_1'),
        'created_date'      => date('Y-m-d H:i:s')
      );
      

      $this->M_CashBank->updateCashBankHeader($primary, $data);
      
      // ini insert detail cashbank detail
      $txtNoCOA       = $this->input->post("txtNoCOA");
      $txtNameCOA     = $this->input->post('txtNameCOA');
      $txtDebit       = $this->input->post('txtDebit');
      $txtCredit      = $this->input->post('txtCredit');
      $txtDebitUSD    = $this->input->post('txtDebitUSD');
      $txtCreditUSD   = $this->input->post('txtCreditUSD');
      $txtRemark      = $this->input->post('txtRemark');
      $txtGSTname     = $this->input->post('txtGST');
      $txtGSTvalue    = $this->input->post('txtGSTvalue');
      $txtBlCode        = $this->input->post('txtBlCode');
      $txtDept        = $this->input->post('txtDeptCode');

      
      // Nick mau ada tombol delete di detail coa
      $idTersimpan    = array_filter($txtDetailID);
      $allId = $this->M_CashBank->getDetailIDsByHeader($primary);
      $deleteDetailId = array_diff($allId, $idTersimpan);

      foreach ($deleteDetailId as $id) {
          $this->M_CashBank->deleteCashBankDetail($id);
      }

      for ($x = 0; $x < count($txtNoCOA); $x++) :
        $detail = array(
          'header_id'         => $primary,
          'no_reff'           => $this->input->post('txtNoReff'),
          'coa'               => $txtNoCOA[$x],
          'coa_description'   => $txtNameCOA[$x],
          'debit'             => str_replace(',', '', $txtDebit[$x]),
          'credit'            => str_replace(',', '', $txtCredit[$x]),
          'remark'            => $txtRemark[$x],
          'gst_type'          => $txtGSTname[$x],
          'gst_value'         => str_replace(',', '', $txtGSTvalue[$x]),
          'debit_USD'         => round(str_replace(',', '', $txtDebitUSD[$x]), 2),
          'credit_USD'        => round(str_replace(',', '', $txtCreditUSD[$x]), 2),
          'created_by'        => $this->session->userdata('userid_1'),
          'created_date'      => date('Y-m-d H:i:s'),
          'dept_code'         => $txtDept[$x],
          'blCode'            => $txtBlCode[$x]

        );

        if (!empty($txtDetailID[$x])) {
          $this->M_CashBank->updateCashBankDetail($txtDetailID[$x], $detail);
        } else {
          $this->M_CashBank->insertCashBankDetail($detail);
        }
      endfor;

      $detailIDHistory = $this->input->post('detailIDHistory');

      $dtlHstry    = array_filter($detailIDHistory);
      $allHstry = $this->M_CashBank->getDetailIdHstry($txtNoReff);
      $deleteHstryId = array_diff($allHstry, $dtlHstry);

      foreach ($deleteHstryId as $jur) {
          $this->M_CashBank->deleteHstryDetail($jur);
      }
      // ini insert ke history cashbank
      for ($i = 0; $i < count($txtNoCOA); $i++) :
        if ($txtCredit[$i] <> 0) {
          $dk     = 'C';
          $jml    = 0 - str_replace(',', '', $txtCredit[$i]);
        } else {
          $dk     = 'D';
          $jml    = str_replace(',', '', $txtDebit[$i]);
        }
        $history    = array(
          'header_id'         => $primary,
          'no_facture'        => $this->input->post('txtNoReff'),
          'trans_type'        => $this->input->post('txtIO'),
          'date1'             => date('Y-m-d', strtotime($this->input->post('txtDate1'))),
          'cb_code'           => $this->input->post('selCBCode'),
          'from_to'           => $this->input->post('txtFromTo'),
          'trans_description' => $this->input->post('txtDescription'),
          'prepaid'           => $prepaid,
          'supplier'          => $supp,
          'coa_supplier'      => $suppCOA,
          'currency_id'       => $this->input->post('txtCurr'),
          'currency_rate'     => str_replace(',', '', $this->input->post('txtRateCurr')),
          'coa_code'          => $txtNoCOA[$i],
          'coa_description'   => $txtNameCOA[$i],
          'debit_credit'      => $dk,
          'jumlah'            => $jml,
          'debit'             => str_replace(',', '', $txtDebit[$i]),
          'credit'            => str_replace(',', '', $txtCredit[$i]),
          'remark'            => $txtRemark[$i],
          'created_by'        => $this->session->userdata('userid_1'),
          'created_date'      => date('Y-m-d H:i:s')
        );

        if (!empty($detailIDHistory[$i])) {
          $this->M_CashBank->updateCashBankHistory($detailIDHistory[$i], $history);
        } else {
          $this->M_CashBank->insertCBhistory($history);
        }
      endfor;

      // hapus data gst terlebih dahulu sebelum insert ulang lagi
      $this->M_CashBank->deleteGstPayable($txtNoReff);

      // ini insert ke jurnal cashbank
      $debet          = 0;
      $debet_sgd      = 0;
      $credit         = 0;
      $credit_sgd     = 0;
      $sum_debet      = 0;
      $sum_credit     = 0;
      $sum_debet_sgd  = 0;
      $sum_credit_sgd = 0;
      $detailIDJurnal = $this->input->post('detailIDJurnal');

      $rate_SGD = str_replace(',', '', $this->input->post('txtRateCurrSGD'));
      $period = $this->M_CashBank->getPeriod();
      
      $dtlJrnl    = array_filter($detailIDJurnal);
      $allJrnl = $this->M_CashBank->getDetailIdJur($txtNoReff);
      $deleteJrnlId = $allJrnl;

      foreach ($deleteJrnlId as $jur) {
          $this->M_CashBank->deleteJrnlDetail($jur);
      }
      
      for ($y = 0; $y < count($txtNoCOA); $y++) :
        if ($txtCredit[$y] <> 0) {
          $dk             = 'C';
          $jml            = str_replace(',', '', $txtCredit[$y]);
          $debet          = '0';
          $debet_sgd      = '0';
          $credit         = number_format(str_replace(",", "", $txtCreditUSD[$y]), 2, ".", "");
          $credit_sgd     = number_format(str_replace(",", "", $txtCredit[$y]) * $rate_SGD, 2, ".", "");
          $sum_credit     +=  $credit;
          $sum_credit_sgd += $credit_sgd;
        } else {
          $dk             = 'D';
          $jml            = str_replace(',', '', $txtDebit[$y]);
          $debet          = number_format(str_replace(",", "", $txtDebitUSD[$y]), 2, ".", "");
          $debet_sgd      = number_format(str_replace(",", "", $txtDebit[$y]) * $rate_SGD, 2, ".", "");
          $credit         = '0';
          $credit_sgd     = '0';
          $sum_debet      += $debet;
          $sum_debet_sgd  += $debet_sgd;
        }

        if ((count($txtNoCOA) - 1) == $y) {
          $selisih = $sum_debet - $sum_credit;

          if ($selisih != 0) {
            if ($dk == 'D') {
              $debet  = $debet - $selisih;
            } else {
              $credit = $credit + $selisih;
            }
          }

          $selisih_sgd = $sum_debet_sgd - $sum_credit_sgd;

          if ($selisih_sgd != 0) {
            if ($dk == 'D') {
              $debet_sgd = $debet_sgd - $selisih_sgd;
            } else {
              $credit_sgd = $credit_sgd + $selisih_sgd;
            }
          }
        }

        $dataJurnal = array(
          'JenisJurnalID'     => $txtRemark[$y],
          'jenis_trans'       => $this->input->post('txtIO'),
          'CompanyID'         => 'ZHL',
          'Tanggal'           => date('Y-m-d', strtotime($this->input->post('txtDate1'))),
          'NoJurnal'          => $this->input->post('txtNoReff'),
          'NoJurnalDtl'       => $this->input->post('txtCheckBank'),
          'Periode'           => date('mY', strtotime($period)),
          'NoCOA'             => $txtNoCOA[$y],
          'sub_account_type'  => $subType,
          'sub_account_id'    => $supp,
          'gst_type'          => $txtGSTname[$y],
          'gst_value'         => str_replace(',', '', $txtGSTvalue[$y]),
          'Uraian'            => $this->input->post('txtDescription'),
          'Debet'             => round($debet, 2),
          'Kredit'            => round($credit, 2),
          'Debet_SGD'         => round($debet_sgd, 2),
          'Kredit_SGD'        => round($credit_sgd, 2),
          'chk'               => $dk,
          'Total'             => round($jml, 2),
          'Currency'          => $this->input->post('txtCurr'),
          'Rate'              => str_replace(',', '', $this->input->post('txtRateCurr')),
          'rate_sgd'          => str_replace(',', '', $this->input->post('txtRateCurrSGD')),
          'Keterangan'        => $this->input->post('txtDescription'),
          'created_by'        => $this->session->userdata('userid_1'),
          'created_date'      => date('Y-m-d H:i:s'),
          'dept_code'         => $txtDept[$y],
          'blCode'            => $txtBlCode[$y]
        );

        if($jml <> 0){
          // if (!empty($detailIDJurnal[$y])) {
          //   $this->M_CashBank->updateToJurnalAcc($detailIDJurnal[$y], $dataJurnal);
          // } else{
            $this->M_CashBank->insertToJurnalAcc($dataJurnal);
          // }
        }
        
        // $all_item = [];
        $gst_item = array(
          'ref_nomor'         => $this->input->post('txtNoReff'),
          'jenis_trans'       => $this->input->post('txtIO'),
          'item'              => $this->input->post('txtDescription'),
          'po_no'             => '',
          'qty'               => 1,
          'gst_type'          => $txtGSTname[$y],
          'gst_value'         => round(str_replace(",", "", $txtGSTvalue[$y]), 2),
          'unit'              => '',
          'price'             => round($jml, 2),
          'currency'          => $this->input->post('txtCurr'),
          'rate'              => str_replace(',', '', $this->input->post('txtRateCurr')),
          'rate_sgd'          => str_replace(',', '', $this->input->post('txtRateCurrSGD')),
          'created_by'        => $this->session->userdata('userid_1'),
          'created_date'      => date('Y-m-d H:i:s')
        );

        if ($txtGSTname[$y] <> "") {
          $this->M_CashBank->simpan_gst_payable($gst_item);
        }
      endfor;

    } elseif ($action === 'delete') {
        // jalankan hapus
        $this->deleteCashBankTransaction();
    }
    redirect(site_url('CBtrans/reviewCashBank/' . encode_str($primary)));
  }

  // ==##============ Insert InterBank=================================
  function insertTransactionCBinterBank()
  {
    $prepaid    = $this->input->post('selPrepaid');
    $IOtype     = $this->input->post('txtIOtypeForPO');
    if ($prepaid == 1 && $IOtype == 'O') {
      $supp       = $this->input->post('txtSup');
      $suppCOA    = $this->input->post('txtSupCOA');
      $subType    = 'DPO';
    } elseif ($prepaid == 1 && $IOtype == 'I') {
      $supp       = $this->input->post('txtCos');
      $suppCOA    = $this->input->post('txtCosCOA');
      $subType    = 'DPI';
    } else {
      $supp       = '';
      $suppCOA    = '';
      $subType    = '';
    }
    $data   = array(
      'no_reff'           => $this->input->post('txtNoReff'),
      'trans_type'        => $this->input->post('txtIO'),
      'jenis'             => 1,
      'date1'             => date('Y-m-d', strtotime($this->input->post('txtDate1'))),
      'cashbank_code'     => $this->input->post('selCBCode'),
      'check_bank'        => $this->input->post('txtCheckBank'),
      'from_to'           => $this->input->post('txtFromTo'),
      'trans_description' => $this->input->post('txtDescription'),
      'prepaid'           => $prepaid,
      'suplier'           => $supp,
      'coa_suplier'       => $suppCOA,
      'currency_id'       => $this->input->post('txtCurr'),
      'currency_rate'     => str_replace(',', '', $this->input->post('txtRateCurr')),
      'rate_awal'         => str_replace(',', '', $this->input->post('txtRateCurr')),
      'rate_akhir'        => str_replace(',', '', $this->input->post('txtRateCurr')),
      'dp_rate_nego'      => str_replace(',', '', $this->input->post('txtRateCurrNego')),
      'dp_rate_sgd'       => str_replace(',', '', $this->input->post('txtRateCurrSGD')),
      'created_by'        => $this->session->userdata('userid_1'),
      'created_date'      => date('Y-m-d H:i:s')
    );
    $headerID   = $this->M_CashBank->insertCashBankHeader($data);


    $txtNoCOA       = $this->input->post("txtNoCOA");
    $txtNameCOA     = $this->input->post('txtNameCOA');
    $txtDebit       = $this->input->post('txtDebit');
    $txtCredit      = $this->input->post('txtCredit');
    $txtDebitUSD    = $this->input->post('txtDebitUSD');
    $txtCreditUSD   = $this->input->post('txtCreditUSD');
    $txtRemark      = $this->input->post('txtRemark');
    $txtGSTname     = $this->input->post('txtGST');
    $txtGSTvalue    = $this->input->post('txtGSTvalue');
    $cur             = $this->input->post('txtCurr');
    //$txtCashFlow	= $this->input->post('txtCashFlowKey');

    for ($x = 0; $x < count($txtNoCOA); $x++) :
      if ($cur == 'SGD') {
        if ($x == 1) {
          $cur_temp = 'USD';
          $rateUSD   = 1;
          $rateSGD   = 1 / $this->input->post('txtRateCurr');
        } else {
          $cur_temp = 'SGD';
          $rateUSD   = $this->input->post('txtRateCurr');
          $rateSGD   = 1;
        }
      } else {
        if ($x == 1) {
          $cur_temp = 'SGD';
          $rateUSD   = 1 / $this->input->post('txtRateCurrSGD');
          $rateSGD   = 1;
        } else {
          $cur_temp = 'USD';
          $rateUSD   = 1;
          $rateSGD   = $this->input->post('txtRateCurrSGD');
        }
      }

      if ($txtCreditUSD[$x] > 0) {
        $debet  = 0;
        $credit = round(str_replace(',', '', $txtCreditUSD[$x]) / $rateUSD, 2);
      } else {
        $debet  = round(str_replace(',', '', $txtDebitUSD[$x]) / $rateUSD, 2);
        $credit = 0;
      }

      $detail = array(
        'header_id'         => $headerID,
        'no_reff'           => $this->input->post('txtNoReff'),
        'coa'               => $txtNoCOA[$x],
        'coa_description'   => $txtNameCOA[$x],
        'debit'             => $debet,
        'credit'            => $credit,
        'remark'            => $txtRemark[$x],
        'gst_type'          => $txtGSTname[$x],
        'gst_value'         => str_replace(',', '', $txtGSTvalue[$x]),
        'debit_USD'         => round(str_replace(',', '', $txtDebitUSD[$x]), 2),
        'credit_USD'        => round(str_replace(',', '', $txtCreditUSD[$x]), 2),
        'created_by'        => $this->session->userdata('userid_1'),
        'created_date'      => date('Y-m-d H:i:s')
      );
      $this->M_CashBank->insertCashBankDetail($detail);
    endfor;

    // ## INSERT TO HISTORY ================================================
    for ($i = 0; $i < count($txtNoCOA); $i++) :

      if ($cur == 'SGD') {
        if ($i == 1) {
          $cur_temp = 'USD';
          $rateUSD   = 1;
          $rateSGD   = 1 / $this->input->post('txtRateCurr');
        } else {
          $cur_temp = 'SGD';
          $rateUSD   = $this->input->post('txtRateCurr');
          $rateSGD   = 1;
        }
      } else {
        if ($i == 1) {
          $cur_temp = 'SGD';
          $rateUSD   = 1 / $this->input->post('txtRateCurrSGD');
          $rateSGD   = 1;
        } else {
          $cur_temp = 'USD';
          $rateUSD   = 1;
          $rateSGD   = $this->input->post('txtRateCurrSGD');
        }
      }

      if ($txtCreditUSD[$i] > 0) {
        $dk     = 'C';
        $jml    = round(str_replace(',', '', $txtCreditUSD[$i]) / $rateUSD, 2);
      } else {
        $dk     = 'D';
        $jml    = round(str_replace(',', '', $txtDebitUSD[$i]) / $rateUSD, 2);
      }

      $history    = array(
        'header_id'         => $headerID,
        'no_facture'        => $this->input->post('txtNoReff'),
        'trans_type'        => $this->input->post('txtIO'),
        'date1'             => date('Y-m-d', strtotime($this->input->post('txtDate1'))),
        'cb_code'           => $this->input->post('selCBCode'),
        'from_to'           => $this->input->post('txtFromTo'),
        'trans_description' => $this->input->post('txtDescription'),
        'prepaid'           => $prepaid,
        'supplier'          => $supp,
        'coa_supplier'      => $suppCOA,
        'currency_id'       => $cur_temp,
        'currency_rate'     => $rateUSD,
        'coa_code'          => $txtNoCOA[$i],
        'coa_description'   => $txtNameCOA[$i],
        'debit_credit'      => $dk,
        'jumlah'            => $jml,
        'debit'             => round(str_replace(',', '', $txtDebitUSD[$i]), 2),
        'credit'            => round(str_replace(',', '', $txtCreditUSD[$i]), 2),
        'remark'            => $txtRemark[$i],
        'created_by'        => $this->session->userdata('userid_1'),
        'created_date'      => date('Y-m-d H:i:s')
      );
      $this->M_CashBank->insertCBhistory($history);
    endfor;

    $debet      = 0;
    $debet_sgd  = 0;
    $credit     = 0;
    $credit_sgd = 0;
    $sum_debet  = 0;
    $sum_credit = 0;
    $sum_debet_sgd = 0;
    $sum_credit_sgd = 0;

    // ## INSERT TO JOURNAL ACCOUNTING =====================================
    $period = $this->M_CashBank->getPeriod();

    for ($y = 0; $y < count($txtNoCOA); $y++) :

      if ($cur == 'SGD') {
        if ($y == 1) {
          $cur_temp = 'USD';
          $rateUSD   = 1;
          $rateSGD   = 1 / $this->input->post('txtRateCurr');
        } else {
          $cur_temp = 'SGD';
          $rateUSD   = $this->input->post('txtRateCurr');
          $rateSGD   = 1;
        }
      } else {
        if ($y == 1) {
          $cur_temp = 'SGD';
          $rateUSD   = 1 / $this->input->post('txtRateCurrSGD');
          $rateSGD   = 1;
        } else {
          $cur_temp = 'USD';
          $rateUSD   = 1;
          $rateSGD   = $this->input->post('txtRateCurrSGD');
        }
      }

      if ($txtCreditUSD[$y] <> 0) {
        $dk             = 'C';
        $jml            = str_replace(',', '', $txtCreditUSD[$y]) / $rateUSD;
        $debet          = '0';
        $debet_sgd      = '0';
        $credit         = number_format(str_replace(",", "", $txtCreditUSD[$y]), 2, ".", "");
        $credit_sgd     = number_format($jml  * $rateSGD, 2, ".", "");
        $sum_credit     += $credit;
        $sum_credit_sgd += $credit_sgd;
      } else {
        $dk            = 'D';
        $jml           = str_replace(',', '', $txtDebitUSD[$y]) / $rateUSD;
        $debet         = number_format(str_replace(",", "", $txtDebitUSD[$y]), 2, ".", "");
        $debet_sgd     = number_format($jml  * $rateSGD, 2, ".", "");
        $credit        = '0';
        $credit_sgd    = '0';
        $sum_debet     += $debet;
        $sum_debet_sgd += $debet_sgd;
      }

      if ((count($txtNoCOA) - 1) == $y) {
        $selisih = $sum_debet - $sum_credit;

        if ($selisih != 0) {
          if ($dk == 'D') {
            $debet = $debet - $selisih;
          } else {
            $credit = $credit - $selisih;
          }
        }

        $selisih_sgd = $sum_debet_sgd - $sum_credit_sgd;

        if ($selisih_sgd != 0) {
          if ($dk == 'D') {
            $debet_sgd = $debet_sgd - $selisih_sgd;
          } else {
            $credit_sgd = $credit_sgd - $selisih_sgd;
          }
        }
      }

      $dataJurnal = array(
        'JenisJurnalID'     => $txtRemark[$y],
        'jenis_trans'       => $this->input->post('txtIO'),
        'CompanyID'         => 'ZHL',
        'Tanggal'           => date('Y-m-d', strtotime($this->input->post('txtDate1'))),
        'NoJurnal'          => $this->input->post('txtNoReff'),
        'NoJurnalDtl'       => $this->input->post('txtCheckBank'),
        'Periode'           => date('mY', strtotime($period)),
        'NoCOA'             => $txtNoCOA[$y],
        'sub_account_type'  => $subType,
        'sub_account_id'    => $supp,
        'gst_type'          => $txtGSTname[$y],
        'gst_value'         => str_replace(',', '', $txtGSTvalue[$y]),
        'Uraian'            => $this->input->post('txtDescription'),
        'Debet'             => round($debet, 2),
        'Kredit'            => round($credit, 2),
        'Debet_SGD'         => round($debet_sgd, 2),
        'Kredit_SGD'        => round($credit_sgd, 2),
        'chk'               => $dk,
        'Total'             => round($jml, 2),
        'Currency'          => $cur_temp,
        'Rate'              => $rateUSD,
        'rate_sgd'          => $rateSGD,
        'Keterangan'        => $this->input->post('txtDescription'),
        'created_by'        => $this->session->userdata('userid_1'),
        'created_date'      => date('Y-m-d H:i:s')
      );

      if ($jml <> 0) {
        $this->M_CashBank->insertToJurnalAcc($dataJurnal);
      }
    endfor;

    // ## INSERT Detail PO DOWN PAYMENT ====================================
    $txtIOtype  = $this->input->post('txtIOtypeForPO');
    $txtPrepid  = $this->input->post('selPrepaid');
    $txtSuppID  = $this->input->post('txtSup');
    $txtCustID  = $this->input->post('txtCos');

    if ($txtIOtype == 'O' && $txtPrepid == 1) {
      $this->insertDetailPOinCashBank($headerID, $txtSuppID, 'PUR');
    } elseif ($txtIOtype == 'I' && $txtPrepid == 1) {
      $this->insertDetailPOinCashBank($headerID, $txtCustID, 'MAR');
    }

    redirect(site_url('CBtrans/reviewCashBank/' . encode_str($headerID)));
  }

  function insertDetailPOinCashBank($headerID, $suppID, $type = '')
  {
    $noPO   = $this->input->post('txtNoMainPO');
    $dpPO   = $this->input->post('txtTotalDP');
    $cnLoop = count($noPO);
    for ($x = 0; $x < $cnLoop; $x++) {
      $data   = array(
        'header_id'     => $headerID,
        'po_id'         => $noPO[$x],
        'sup_cust_id'   => $suppID,
        'type_detail'   => $type,
        'uang_muka'     => str_replace(',', '', $dpPO[$x]),
        'created_by'    => $this->session->userdata('userid_1'),
        'created_date'  => date('Y-m-d H:i:s')
      );

      $this->M_Fin_CB->insertDetailPOcbTransaction($data);
    }
  }
  // ========== ## Insert Cash Bank Transaction ## ==========
  // #################################################################################
  // #################################################################################

  // #################################################################################
  // #################################################################################
  // ========== ## Review Cash Bank Transaction ## ==========
  
  // select lama jangan dihapus *Notes fauzi
  // function selectCashBank()
  // {
  //   // $data   = array(
  //   //     '_selectHeaderCashBank' => $this->M_Fin_CB->selectHeaderCashBankForFind()->result()
  //   // );

  //   $data   = array(
  //     '_selectHeaderCashBank' => $this->M_Fin_CB->selectHeaderCashBankForFind_az()->result()
  //   );
  //   $this->load->view('finance/transaction/cb_trans/findCB/selectCB', $data);
  // }

  function selectCashBank()
  {
      $this->load->view('finance/transaction/cb_trans/findCB/selectCB');
  }

  function ajaxSelectCashBank()
  {
      $list = $this->M_Fin_CB->getCashBankServerSide();
      $data = [];

      foreach ($list as $row) {
          $data[] = [
              $row->no_reff,
              date('d-m-Y', strtotime($row->date1)),
              $row->cashbank_code,
              $row->from_to,
              $row->trans_description,
              $row->currency_id,
              number_format($row->amount, 2),
              encode_str($row->header_id)
          ];
      }

      $output = [
          "draw" => intval($this->input->post('draw')),
          "recordsTotal" => $this->M_Fin_CB->countAll(),
          "recordsFiltered" => $this->M_Fin_CB->countFiltered(),
          "data" => $data
      ];

      $this->output
          ->set_content_type('application/json')
          ->set_output(json_encode($output));
  }

  public function selectCBMonthly()
  {
    $from    = $this->input->get('from');
    $to      = $this->input->get('to');
    $trans   = $this->input->get('trans_type');
    $data['CBReport'] =  $this->M_Fin_CB->selectCBTransReport($from, $to, $trans);
    $this->load->view('finance/transaction/cb_trans/findCB/selectCBReport', $data);
  }
  
  function reviewCashBank($headerID)
  {
    $company   = strtoupper($this->session->userdata('company_id'));
    $primary    = decode_str($headerID);
    $masterCOA = $this->M_Fin_CB->selectCOAforCBtrans($company)->result();
    $masterCOAOld = $this->M_Fin_CB->selectCOAforCBtransOld()->result();
    $header = $this->M_Fin_CB->selectHeaderCashBankForReviewByID($primary);

    $selectedCOA = null;
    $useOldCOA   = false;
    $close_date         = $this->M_login->ambil_tgl()->row();

    foreach ($masterCOA as $row) {
        if ($row->NoCOA === $header->cashbank_code) {
            $selectedCOA = $row;
            break;
        }
    }

    if ($selectedCOA === null) {
        foreach ($masterCOAOld as $row) {
            if ($row->NoCOA === $header->cashbank_code) {
                $selectedCOA = $row;
                $useOldCOA   = true;
                break;
            }
        }
    }

  $selectMasterCOA = $useOldCOA ? $masterCOAOld : $masterCOA;

    // var_dump($selectedCOA);
    // die;
    
    $historyList = $this->M_CashBank->getDetailHistory($primary);
    $no_reff = isset($historyList[0]) ? $historyList[0]->no_facture : null;

    $data = array(
      '_selectIOtype'     => $this->M_Fin_CB->selectIOtypeForCB(),
      '_selectGST'        => $this->db->get('gen_tbl_mst_gst')->result(),
      '_selectCurrency' => $this->db->where('not_active', '0')->get('zhl_gen_tbl_mst_currency')->result(),
      '_selectMasterCOA'  => $selectMasterCOA,
      // '_selectMasterCOAOld'  => $masterCOAOld,
      '_selectHeader'     => $header,
      '_selectPO'         => $this->M_Fin_CB->selectPurchesForReviewByHeaderID($primary),
      '_checkPO'          => $this->M_Fin_CB->checkPurchesForReviewByHeaderID($primary),
      '_selectDetail'     => $this->M_Fin_CB->selectDetailCashBankForReviewByHeaderID($primary),
      '_selectHistory'    => $this->M_CashBank->getDetailHistory($primary),
      '_selectJurnal'     => $this->M_CashBank->getDetailJurnal($no_reff),
      '_selectedCOA'      => $selectedCOA,
      'closing'           => date_format(date_create($close_date->tanggal), "d/m/Y")
    );

    $this->template->display('finance/transaction/cb_trans/findCB/index-review', $data);
  }
  // ========== ## Delete Recorded Cash Bank Transaction ## ==========
  function deleteCashBankTransaction()
  {
    $primary    = decode_str($this->input->post('txtPrimaryCashBank'));
    $selectCB   = $this->M_Fin_CB->selectHeaderCashBankForReviewByID($primary);
    $numberReff = $selectCB->no_reff;
    $created    = $this->session->userdata('userid_1');
    $created_date = date('Y-m-d');

    $type = substr($numberReff, 0, 2);
    $tgl = date("Y", strtotime($selectCB->date1));
    $cur = $selectCB->currency_id;

    $cek_reff = $this->M_Fin_CB->cek_reff($type, $tgl, $cur);

    if ($numberReff != $cek_reff->GEN) {
      $data_hdr = array(
        'trans_description' => 'Cancelled',
        'updated_by'    => $created,
        'updated_date'  => $created_date

      );
      $this->M_Fin_CB->updateCashBankHeaderByHeaderID($primary, $data_hdr);

      $data_jur = array(
        'Debet' => 0,
        'Kredit'            => 0,
        'Debet_SGD'         => 0,
        'Kredit_SGD'        => 0,
        'Total'             => 0,
        'keterangan'        => 'Cancelled',
        'last_update_by'    => $created,
        'last_update_date'  => $created_date

      );
      $this->M_Fin_CB->updateCashBankFromJurnal($numberReff, $data_jur);
    } else {
      $this->M_Fin_CB->deleteCashBankHeaderByHeaderID($primary);
      $this->M_Fin_CB->deleteCashBankFromJurnal($numberReff);
    }

    // === ##Delete Detail PO
    $this->M_Fin_CB->deleteDetailPOcbTransaction($primary);
    // === ##Delete Cash Bank Detail
    $this->M_Fin_CB->deleteCashBankDetailByHeaderID($primary);

    // ==Delete GST
    $this->M_Fin_CB->deleteCashBankgst($primary);
    // === ##Delete Cash Bank In History
    $this->M_Fin_CB->deleteCashBankFromHistory($primary);
    redirect(site_url('CBtrans'));
  }

  // =============== CHECK SALDO AWAL ===============
  function checkSaldoAwal()
  {
    $txtPayment     = str_replace(',', '', $this->input->post('txtPayment'));
    $txtBankCode    = $this->input->post('txtBankCode');

    $awal   = $this->M_Fin_CB->chechSaldoAwal($txtBankCode);
    $saldo  = $this->M_Fin_CB->checkSaldoKini($txtBankCode);

    if (intval($awal) == 0) {
      echo "error01"; // Saldo Kosong
    } else if ($saldo < $txtPayment) {
      echo "error02"; // Saldo Kurang
    } else {
      echo "ready"; // Siap Transaksi
    }
  }
}
