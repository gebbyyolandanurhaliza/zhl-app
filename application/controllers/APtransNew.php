<?php defined('BASEPATH') OR exit('No direct script access allowed');

/* 
 * Author : ITD15
 */

class APtransNew extends CI_Controller{
    public function __construct() {
        parent::__construct();
        
        //is_maintenance(FALSE, $this->session->userdata('userid_1'));
        
        if(!$this->session->userdata('userid_1')){
            redirect('login');
        }
        
        date_default_timezone_set("Asia/Jakarta");
        $this->load->model(array('M_CashBank','M_Fin_APNew','M_Fin_CB','M_vcdn','M_General_Journal'));
    }
    
    // ################################################################################
    // ################################################################################
    function index(){
        $company   = strtoupper($this->session->userdata('company_id'));
        $data['_periode']           = $this->M_Fin_APNew->getPeriod_map();
        // $data['_selectCurrency']    = $this->db->get('zhl_gen_tbl_mst_currency')->result();
        $data['_selectCurrency'] = $this->db->where('not_active', 0)->get('zhl_gen_tbl_mst_currency')->result();

        $data['_selectGST']         = $this->db->get('zhl_gen_tbl_mst_gst')->result();
        $data['List_coa']           = $this->M_vcdn->get_coa($company);
        $data['dept_code']          = $this->M_General_Journal->get_departmentcode();
        $data['_titleForm']         = array('head' => 'Transaction', 'desc' => 'Payment A/P');
        $data['_actionFrom']        = '/insertAPpayment';
        $this->template->display('finance/transaction/ap_trans_new/index',$data);
    }


    function newGenerateReffNumber(){
        $type       = $this->input->get('txtTypeForGen');
        $currency   = $this->input->get('txtCurrForGen');
        $tanggal    = date('Y-m-d', strtotime($this->input->get('txtDateForGen')));

        // echo 1;
     
        if ($type == 'O' || $type == 'OUT') {
            $num    = $this->M_Fin_APNew->newCheckReffNumber('OUT', $tanggal, $currency);
            $get    = str_pad($num, 4, 0, STR_PAD_LEFT);
            if ($currency == 'USD') {
                $set    = 'BPU'.date('ym',strtotime($this->input->get('txtDateForGen'))).$get;
            }elseif ($currency == 'SGD') {
                $set    = 'BP'.date('ym',strtotime($this->input->get('txtDateForGen'))).$get;
            }
        }elseif ($type == 'I' || $type == 'IN') {
            $num    = $this->M_Fin_APNew->newCheckReffNumber('IN', $tanggal, $currency);
            $get    = str_pad($num, 4, 0, STR_PAD_LEFT);
            if ($currency == 'USD') {
                $set    = 'BRU'.date('ym',strtotime($this->input->get('txtDateForGen'))).$get;
            }elseif ($currency == 'SGD') {
                $set    = 'BR'.date('ym',strtotime($this->input->get('txtDateForGen'))).$get;
            }
        }
        echo $set;

        // echo $type;
    }

    function newGenerateReffNumber2(){
        $type       = $this->input->get('txtTypeForGen');
        $currency   = $this->input->get('txtCurrForGen');
        $tanggal    = date('Y-m-d', strtotime($this->input->get('txtDateForGen')));

        // echo 1;
     
        if ($type == 'O' || $type == 'OUT') {
            $num    = $this->M_Fin_APNew->newCheckReffNumber2('OUT', $tanggal, $currency);
            $get    = str_pad($num, 4, 0, STR_PAD_LEFT);
            if ($currency == 'USD') {
                $set    = 'BPU'.date('Ym',strtotime($this->input->get('txtDateForGen'))).$get;
            }elseif ($currency == 'SGD') {
                $set    = 'BP'.date('Ym',strtotime($this->input->get('txtDateForGen'))).$get;
            }
        }elseif ($type == 'I' || $type == 'IN') {
            $num    = $this->M_Fin_APNew->newCheckReffNumber2('IN', $tanggal, $currency);
            $get    = str_pad($num, 4, 0, STR_PAD_LEFT);
            if ($currency == 'USD') {
                $set    = 'BRU'.date('Ym',strtotime($this->input->get('txtDateForGen'))).$get;
            }elseif ($currency == 'SGD') {
                $set    = 'BR'.date('Ym',strtotime($this->input->get('txtDateForGen'))).$get;
            }
        }
        echo $set;

        // echo $type;
    }

    function generateReffNumAP(){
        $num    = $this->M_Fin_APNew->generateReffAP();
        $get    = str_pad($num, 4, 0, STR_PAD_LEFT);
        $set    = date('ym').$get;
        echo    $set;
    }
    function cekNumReffAP(){
        $value  = $this->input->post('value');
        $this->db->where('no_facture', $value);
        $get    = $this->db->get('fin_tbltrn_payment_hdr');
        if($get->num_rows() > 0){
            echo 1;
        }else{
            echo 0;
        }
    }
    function selectSupplierForAP(){
        $tgl    = $this->input->post('txtTglInvoice');
        $data   = array(
            '_selectSupplier' => $this->M_Fin_APNew->selectSupplierforAPtrans($tgl)->result()
        );
        $this->load->view('finance/transaction/ap_trans_new/selectSupplier',$data);
    }
    function selectInvoiceForAP(){
        $idSupp = $this->input->get('incSupplierID');
        $idDate = date('Y-m-d', strtotime($this->input->get('incTransDate')));
        $data   = array(
            'idSupp'    => $idSupp,
            '_arrDraf'  => $this->M_Fin_APNew->selectInvoiceInDrafArray(),
            '_selectInvoice' => $this->M_Fin_APNew->selectInvoiceWhereForAPtrans($idSupp, $idDate)->result()
        );
        // echo "<pre>";
        // print_r($data);
        // echo "</pre>";
        // die;
        $this->load->view('finance/transaction/ap_trans_new/selectInvoice',$data);
    }
    function selectModalAP(){
        $data   = array(
            '_selectAP' => $this->M_Fin_APNew->selectAPfromAccounting()->result()
        );
        $this->load->view('finance/transaction/ap_trans_new/selectAP',$data);
    }
    function selectCOA(){
        $company   = strtoupper($this->session->userdata('company_id'));
        $data   = array(
            '_getMasterCOA' => $this->M_Fin_APNew->selectCOAforAPtrans($company)->result()
        );
        $this->load->view('finance/transaction/ap_trans_new/selectMCOA',$data);
    }
    function selectCurrencyAP(){
        $idCurr = $this->input->post('txtCurrAjax');
        $selectKurs = $this->M_Fin_APNew->getKursByID($idCurr)->row();
        $data   = array(
            'rate_usd'  => number_format($selectKurs->rate_usd,2),
            'totoal'    => 100202
            );
        echo json_encode($data);
    }
    function getCurrOnDateInvoice(){
        $noCurrency = $this->input->post('txtCurrency');
        $noInvoice  = $this->input->post('txtNoInvoice');
        $tglInvoice = $this->input->post('txtTglInvoice');
        $selectKurs = $this->M_Fin_APNew->getKursByID($noCurrency, $tglInvoice)->row();
        
        $expld      = explode('|', $noInvoice);
        $count      = count($expld);
        for($x = 0; $x <$count; $x++){
            $get[] = $this->M_Fin_APNew->getCurrOnDateInvoiceByCurrencyID($expld[$x], $noCurrency);
        }
        
        $data   = array(
            'rate_usd'  => number_format($selectKurs->rate_usd,6),
            'rate_sgd'  => number_format($selectKurs->rate_kurs,6),
            'inv'       => $get
        );
        
        echo json_encode($data);
    }
    function getCurrBank(){
        $idCurr     = $this->input->post('txtCurrency');
        $txDate     = $this->input->post('txtTglInvoice');
        $selectKurs = $this->M_Fin_APNew->getKursByID($idCurr,$txDate)->row();
        $data       = array(
            'rate_usd'  => number_format($selectKurs->rate_usd,6),
            'rate_sgd'  => number_format($selectKurs->rate_kurs,6)
            );
        echo json_encode($data);
    }
    // ########## Do action Insert & Update IN AP transaction ##########
    // ########## Do action Insert & Update IN AP transaction ##########
    function insertAPpayment(){
        $this->db->trans_begin();
        try{
            $suppID     = $this->input->post('txtSuplierID');
            $suppCOA    = $this->M_CashBank->getSupplierCOA($suppID);
            $period     = $this->M_CashBank->getPeriod();
            
            $dataHdr    = array(
                'no_facture'    => $this->input->post('txtFacture'),
                'trans_date'    => date('Y-m-d', strtotime($this->input->post('txtTransDate'))),
                'thn_periode'   => date('Y', strtotime($period)),
                'bln_periode'   => date('m', strtotime($period)),
                'trans_type'    => 'AP',
                'no_voucher'    => $this->input->post('txtFacture'),
                'code_cashbank' => $this->input->post('txtCashBankCode'),
                'check_number'  => $this->input->post('txtCheckBank'),
                'supplier_id'   => $suppID,
                'supplier_coa'  => $suppCOA,
                'currency_id'   => $this->input->post('txtCurrBayar'),
                'currency_rate' => str_replace(',', '', $this->input->post('txtRateBank')),
                'rate_nego'     => str_replace(',', '', $this->input->post('txtRateBank')),
                'rate_equi'     => 0,
                'currency_bayar'=> $this->input->post('txtCurrBayar'),
                'remark'        => $this->input->post('txtSuplierRemark'),
                'created_by'    => $this->session->userdata('userid_1'),
                'created_date'  => date('Y-m-d H:i:s')
            );
            $headerID   = $this->M_CashBank->insertHeaderAPpayment($dataHdr);
            
            // == insert into ap accounting ==
            $noReffAP   = $this->input->post('txtFacture');
            $this->insertDetailAPaccounting($noReffAP);
            
            // == update hutang == 
            $this->updateHutangPerInvoiceNew();
            $this->updateHutangBulananPerInvoiceNew();
            
            // == update Deposit In Header CashBank ==
            $this->updateDepositAPinHeader();
            
            //## == Insert Detail FinanceJournal
            $txtNoCOA       = $this->input->post("txtNoCOA");
            $txtNameCOA     = $this->input->post('txtNameCOA');
            $txtDebit       = $this->input->post('txtDebit');
            $txtCredit      = $this->input->post('txtCredit');
            $txtDebitUSD    = $this->input->post('txtDebitUSD');
            $txtCreditUSD   = $this->input->post('txtCreditUSD');
            $txtRemark      = $this->input->post('txtRemark');
            $txtGSTname     = $this->input->post('txtGST');
            $txtGSTvalue    = $this->input->post('txtGSTvalue');
            $txtDept    = $this->input->post('txtDeptCode');
            //$txtCashFlow  = $this->input->post('txtCashFlowKey');
            for($x = 0; $x < count($txtNoCOA); $x++):
                $detail = array(
                    'header_id'         => $headerID,
                    'no_reff'           => $this->input->post('txtFacture'),
                    'coa'               => $txtNoCOA[$x],
                    'coa_description'   => $txtNameCOA[$x],
                    'debit'             => str_replace(',', '', $txtDebit[$x]),
                    'credit'            => str_replace(',', '', $txtCredit[$x]),
                    'debit_usd'         => str_replace(',', '', $txtDebitUSD[$x]),
                    'credit_usd'        => str_replace(',', '', $txtCreditUSD[$x]),
                    'remark'            => $txtRemark[$x],
                    'gst_type'          => $txtGSTname[$x],
                    'gst_value'         => str_replace(',', '', $txtGSTvalue[$x]),
                    'created_by'        => $this->session->userdata('userid_1'),
                    'created_date'      => date('Y-m-d H:i:s'),
                    'dept_code'         => $txtDept[$x]
                );
                $this->M_Fin_APNew->insertDetailAPjurnal($detail);
            endfor;
            
            // ## INSERT TO HISTORY ================================================
            for($i = 0; $i < count($txtNoCOA); $i++):
                if($txtCredit[$i] <> 0){
                    $dk     = 'C';
                    $jml    = 0-str_replace(',', '', $txtCredit[$i]);
                }else{
                    $dk     = 'D';
                    $jml    = str_replace(',', '', $txtDebit[$i]);
                }
                $history    = array(
                    'header_id'         => $headerID,
                    'no_facture'        => $this->input->post('txtFacture'),
                    'trans_type'        => 'AP',
                    'date1'             => date('Y-m-d', strtotime($this->input->post('txtTransDate'))),
                    'cb_code'           => $this->input->post('txtCashBankCode'),
                    'trans_description' => $this->input->post('txtSuplierRemark'),
                    'supplier'          => $suppID,
                    'coa_supplier'      => $suppCOA,
                    'currency_id'       => $this->input->post('txtCurrBayar'),
                    'currency_rate'     => str_replace(',', '', $this->input->post('txtRateBank')),
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
            
            // ## INSERT TO JOURNAL ACCOUNTING =====================================
            $debet=0;
            $debet_sgd=0;
            $credit=0;
            $credit_sgd=0;
            $sum_debet=0;
            $sum_credit=0;
            $sum_debet_sgd=0;
            $sum_credit_sgd=0;

            $period = $this->M_CashBank->getPeriod();
            $getKursSGD = $this->M_Fin_APNew->getKursByID($this->input->post('txtCurrBayar'),$this->input->post('txtTransDate'))->row();
            $coaHutPiu  = array('130401','130402','130403','130404','200101','200102','200103','200105');

            $apes = 0;
            for($y = 0; $y < count($txtNoCOA); $y++):
                if($txtCredit[$y] <> 0 || $txtCreditUSD[$y] <> 0){
                    $apes       = 1;
                    $dk         = 'C';
                    $jml        = str_replace(',', '', $txtCredit[$y]);
                    $debet      = '0';
                    $debet_sgd  = '0';
                    $credit     = number_format(str_replace(",", "", $txtCreditUSD[$y]), 2, ".", "");
                    $credit_sgd = number_format(str_replace(",", "", $txtCredit[$y]) * $getKursSGD->rate_kurs, 2, ".", "");
                    $sum_credit +=  $credit;
                    $sum_credit_sgd += $credit_sgd;
                }else if($txtDebit[$y] <> 0 || $txtDebitUSD[$y] <> 0){
                    $apes       = 2;
                    $dk         = 'D';
                    $jml        = str_replace(',', '', $txtDebit[$y]);
                    $debet      = number_format(str_replace(",", "", $txtDebitUSD[$y]), 2, ".", "");
                    $debet_sgd  = number_format(str_replace(",", "", $txtDebit[$y]) * $getKursSGD->rate_kurs, 2, ".", "");
                    $credit     = '0';
                    $credit_sgd = '0';
                    $sum_debet  += $debet;
                    $sum_debet_sgd += $debet_sgd;
                }
                else
                {
                    $jml = 0;
                }

                $jml2 = str_replace(',', '', $txtCreditUSD[$y]) +   str_replace(',', '', $txtDebitUSD[$y]);

                if ((count($txtNoCOA) - 1) == $y){
                    $selisih = $sum_debet - $sum_credit;

                    if ($selisih != 0) {
                        if ($dk == 'D') {
                            $debet = $debet - $selisih; 
                        } else {
                            $credit = $credit + $selisih; 
                        }
                    }

                    $selisih_sgd = $sum_debet_sgd - $sum_credit_sgd;

                    if ($selisih_sgd != 0){
                        if ($dk == 'D') {
                            $debet_sgd = $debet_sgd - $selisih_sgd; 
                        } else {
                            $credit_sgd = $credit_sgd + $selisih_sgd; 
                        }
                    }
                }

                if($txtNoCOA[$y] == '610009'){
                    $a = round(str_replace(',', '',$this->input->post('txtTotalPayment')), 2);
                    $cur = $this->input->post('txtCurrBayar');
                    if($a == 0){
                        $a = $jml;
                    }
                    if($a == 0){$a = 1;}
                    $dataJurnal = array(
                        'JenisJurnalID'     => $txtRemark[$y],
                        'jenis_trans'       => 'AP',
                        'CompanyID'         => 'PSS',
                        'Tanggal'           => date('Y-m-d', strtotime($this->input->post('txtTransDate'))),
                        'NoJurnal'          => $this->input->post('txtFacture'),
                        'NoJurnalDtl'       => $this->input->post('txtCheckBank'),
                        'Periode'           => date('mY', strtotime($period)),
                        'NoCOA'             => $txtNoCOA[$y],
                        'sub_account_type'  => (in_array($txtNoCOA[$y], $coaHutPiu) ? 'HUT' : ' '),
                        'sub_account_id'    => $this->input->post('txtSuplierID'),
                        'gst_type'          => $txtGSTname[$y],
                        'gst_value'         => str_replace(',', '', $txtGSTvalue[$y]),
                        'Uraian'            => $this->input->post('txtSuplierRemark'),
                        'Debet'             => round($debet,2),
                        'Kredit'            => round($credit,2),
                        'Debet_SGD'         => round($debet_sgd, 2),
                        'Kredit_SGD'        => round($credit_sgd, 2),
                        'chk'               => $dk,
                        'Total'             => round($a,2),
                        'Currency'          => $this->input->post('txtCurrBayar'),
                        'Rate'              => str_replace(',', '', $this->input->post('txtTotalExcRateUSD')),
                        'rate_sgd'          => str_replace(',', '', $this->input->post('txtTotalExcRateSGD')),
                        'Keterangan'        => $this->input->post('txtSuplierRemark'),
                        'created_by'        => $this->session->userdata('userid_1'),
                        'created_date'      => date('Y-m-d H:i:s'),
                        'dept_code'         => $txtDept[$y]
                    );
                }
                else
                {
                    $dataJurnal = array(
                        'JenisJurnalID'     => $txtRemark[$y],
                        'jenis_trans'       => 'AP',
                        'CompanyID'         => 'PSS',
                        'Tanggal'           => date('Y-m-d', strtotime($this->input->post('txtTransDate'))),
                        'NoJurnal'          => $this->input->post('txtFacture'),
                        'NoJurnalDtl'       => $this->input->post('txtCheckBank'),
                        'Periode'           => date('mY', strtotime($period)),
                        'NoCOA'             => $txtNoCOA[$y],
                        'sub_account_type'  => (in_array($txtNoCOA[$y], $coaHutPiu) ? 'HUT' : ' '),
                        'sub_account_id'    => $this->input->post('txtSuplierID'),
                        'gst_type'          => $txtGSTname[$y],
                        'gst_value'         => str_replace(',', '', $txtGSTvalue[$y]),
                        'Uraian'            => $this->input->post('txtSuplierRemark'),
                        'Debet'             => round($debet,2),
                        'Kredit'            => round($credit,2),
                        'Debet_SGD'         => round($debet_sgd, 2),
                        'Kredit_SGD'        => round($credit_sgd, 2),
                        'chk'               => $dk,
                        'Total'             => round($jml, 2),
                        'Currency'          => $this->input->post('txtCurrBayar'),
                        'Rate'              => str_replace(',', '', $this->input->post('txtRateBank')),
                        'rate_sgd'          => $getKursSGD->rate_kurs,
                        'Keterangan'        => $this->input->post('txtSuplierRemark'),
                        'created_by'        => $this->session->userdata('userid_1'),
                        'created_date'      => date('Y-m-d H:i:s'),
                        'dept_code'         => $txtDept[$y]
                    );  
                }
                

                // echo $y.' - '.$jml2.'-'.$apes.'<br>';

                if ($jml <> 0 OR $jml2 <> 0) {
                    // echo $y.' - '.$jml2."<br><br>";
                    $this->M_CashBank->insertToJurnalAcc($dataJurnal);
                }

                // $gst_item = array(
                //     'ref_nomor' => $this->input->post('txtFacture'),
                //     'jenis_trans' => 'AP',
                //     'item' => $this->input->post('txtCheckBank'),
                //     'po_no' => '',
                //     'qty' => 1,
                //     'gst_type' => $txtGSTname[$y],
                //     'gst_value' => round(str_replace(",", "", $txtGSTvalue[$y]), 2),
                //     'unit' => '',
                //     'price' => round($jml, 2),
                //     'currency' => $this->input->post('txtCurrBayar'),
                //     'rate' => str_replace(',', '', $this->input->post('txtRateBank')),
                //     'rate_sgd' => $getKursSGD->rate_kurs,
                //     'created_by' => $this->session->userdata('userid_1'),
                //     'created_date' => date('Y-m-d H:i:s')
                // );

                // if ($gst_type[$i] <> "") {
                //     $this->M_CashBank->simpan_gst_payable($gst_item);
                // }
            endfor;
            $nocoa = $txtNoCOA[1];
            //========================= 03/01/2018 09:19:19 ( F.Chan ) ======================================
            $this->InsertExcRtJurnal($headerID, $noReffAP, $nocoa);
            $this->db->trans_commit();
            //========================= END =======================================
            redirect('APtransNew/reviewAPpayment/'.encode_str($headerID));
        } catch (Exception $e){
            $this->db->trans_rollback();
            log_message('error', 'AP PAYMENT FAILED: ' . $e->getMessage());
        }
        
    }

    function InsertExcRtJurnal($headerID, $noReffAP, $nocoa){
        $period             = $this->M_CashBank->getPeriod();
        $noinv              = $this->input->post('txtNewNoInvoiceDtl');
        $totalAsal          = str_replace(',', '', $this->input->post('txtNewPayDtl'));
        $excRtUSD           = $this->input->post('totexcRtUSD');
        $excTtUSD           = str_replace(',', '', $this->input->post('totexcUSD'));
        $excRtSGD           = $this->input->post('totexcRtSGD');
        $excTtSGD           = str_replace(',', '', $this->input->post('totexcSGD'));
        $total = 0;

        for($i = 0; $i < count($noinv); $i++){
            $detailexc = array(
                'HeaderID'      => $headerID,
                'noApAr'        => $noReffAP,
                'jenis_trans'   => 'AP',
                'noInvoice'     => $noinv[$i],
                'totalAsal'     => $totalAsal[$i],
                'excRtUsd'      => $excRtUSD[$i] ,
                'excTtUsd'      => $excTtUSD[$i],
                'excRtSgd'      => $excRtSGD[$i],
                'ecxTtSgd'      => $excTtSGD[$i]
            );
            $total += $totalAsal[$i];
            $this->M_Fin_APNew->insertdtlexcRt($detailexc);
        }
        
        // $totalRtexcUSD = $this->input->post('txtTotalExcRateUSD');
        // $totalUSD = str_replace(',', '',$this->input->post('txtTotalExcUSD'));
        // $totalRtexcSGD = $this->input->post('txtTotalExcRateSGD');
        // $totalSGD = str_replace(',', '',$this->input->post('txtTotalExcSGD'));

        // //Jurnal Hutang
        // $debit = 0;
        // $credit = 0;
        // $debit_sgd = 0;
        // $credit_sgd = 0;
        // $chk = "";


        // if($totalUSD < 0){
        //     $debit = abs($totalUSD);
        //     $credit = 0;
        //     $chk = "D";
        // }
        // else
        // {
        //     $credit = abs($totalUSD);
        //     $debit = 0;
        //      $chk = "C";
        // }

        // if($totalSGD < 0){
        //     $debit_sgd = abs($totalSGD);
        //     $credit_sgd =  0;
        //     $chk = "D";
        // }
        // else
        // {
        //     $credit_sgd = abs($totalSGD);
        //     $debit_sgd =  0;
        //     $chk = "C";
        // }

        // // echo "debit : ".$debit." - credit : ".$credit." - debit_sgd : ".$debit_sgd." - credit_sgd : ".$credit_sgd." - total asal :".$totalAsal;

        // $jurnal1 = array (
        //     'JenisJurnalID'     => 'Exchange Rate AP',
        //     'jenis_trans'       => 'SR',
        //     'NoUrut'            => 0,
        //     'CompanyID'         => 'PSS',
        //     'Tanggal'           => date('Y-m-d', strtotime($this->input->post('txtTransDate'))),
        //     'NoJurnal'          => $this->input->post('txtFacture'),
        //     'NoJurnalDtl'       => $this->input->post('txtCheckBank'),
        //     'Periode'           => date('mY', strtotime($period)),
        //     'NoCOA'             => $nocoa,
        //     'sub_account_type'  => 'HUT',
        //     'sub_account_id'    => $this->input->post('txtSuplierID'),
        //     'Uraian'            => 'Exchange Rate for AP payment',
        //     'Debet'             => round($debit,2),
        //     'Kredit'            => round($credit,2),
        //     'Debet_SGD'         => round($debit_sgd, 2),
        //     'Kredit_SGD'        => round($credit_sgd, 2),
        //     'chk'               => $chk,
        //     'Total'             => round($total, 2),
        //     'Currency'          => $this->input->post('txtCurrBayar'),
        //     'Rate'              => $totalRtexcUSD,
        //     'rate_sgd'          => $totalRtexcSGD,
        //     'Keterangan'        => 'Exchange Rate for AP payment',
        //     'created_by'        => $this->session->userdata('userid_1'),
        //     'created_date'      => date('Y-m-d H:i:s')
        // );

        // $this->M_Fin_APNew->insertjurnalnya($jurnal1);


        // //Jurnal excrate
        // $debit = 0;
        // $credit = 0;
        // $debit_sgd = 0;
        // $credit_sgd = 0;
        // $chk = "";


        // if($totalUSD > 0){
        //     $debit = abs($totalUSD);
        //     $credit = 0;
        //     $chk = "D";
        // }
        // else
        // {
        //     $credit = abs($totalUSD);
        //     $debit = 0;
        //      $chk = "C";
        // }

        // if($totalSGD > 0){
        //     $debit_sgd = abs($totalSGD);
        //     $credit_sgd =  0;
        //     $chk = "D";
        // }
        // else
        // {
        //     $credit_sgd = abs($totalSGD);
        //     $debit_sgd =  0;
        //     $chk = "C";
        // }

        // $jurnal2 = array (
        //     'JenisJurnalID'     => 'Exchange Rate AP',
        //     'jenis_trans'       => 'SR',
        //     'NoUrut'            => 1,
        //     'CompanyID'         => 'PSS',
        //     'Tanggal'           => date('Y-m-d', strtotime($this->input->post('txtTransDate'))),
        //     'NoJurnal'          => $this->input->post('txtFacture'),
        //     'NoJurnalDtl'       => $this->input->post('txtCheckBank'),
        //     'Periode'           => date('mY', strtotime($period)),
        //     'NoCOA'             => '610009',
        //     'Uraian'            => 'Exchange Rate for AP payment',
        //     'Debet'             => round($debit,2),
        //     'Kredit'            => round($credit,2),
        //     'Debet_SGD'         => round($debit_sgd, 2),
        //     'Kredit_SGD'        => round($credit_sgd, 2),
        //     'chk'               => $chk,
        //     'Total'             => round($total, 2),
        //     'Currency'          => $this->input->post('txtCurrBayar'),
        //     'Rate'              => $totalRtexcUSD,
        //     'rate_sgd'          => $totalRtexcSGD,
        //     'Keterangan'        => 'Exchange Rate for AP payment',
        //     'created_by'        => $this->session->userdata('userid_1'),
        //     'created_date'      => date('Y-m-d H:i:s')
        // );

        // $this->M_Fin_APNew->insertjurnalnya($jurnal2);
    }


    function insertAPpaymentToDraf(){
        $suppID     = $this->input->post('txtSuplierID');
        $suppCOA    = $this->M_CashBank->getSupplierCOA($suppID);
        $period     = $this->M_CashBank->getPeriod();
        
        $dataHdr    = array(
            'no_facture'    => $this->input->post('txtFacture'),
            'trans_date'    => date('Y-m-d', strtotime($this->input->post('txtTransDate'))),
            'thn_periode'   => date('Y', strtotime($period)),
            'bln_periode'   => date('m', strtotime($period)),
            'trans_type'    => 'AP',
            'no_voucher'    => $this->input->post('txtFacture'),
            'code_cashbank' => $this->input->post('txtCashBankCode'),
            'check_number'  => $this->input->post('txtCheckBank'),
            'supplier_id'   => $suppID,
            'supplier_coa'  => $suppCOA,
            'currency_id'   => $this->input->post('selCurrencyVoucher'),
            'currency_rate' => $this->input->post('txtRateVoucher'),
            'rate_nego'     => $this->input->post('txtRateNego'),
            'rate_equi'     => 0,
            'rate_sgd'      => $this->input->post('txtRateSGD'),
            'currency_bayar'=> $this->input->post('txtCurrBayar'),
            'remark'        => $this->input->post('txtSuplierRemark'),
            'created_by'    => $this->session->userdata('userid_1'),
            'created_date'  => date('Y-m-d H:i:s'),
            'is_draf'       => 1
        );
        
        $headerID   = $this->M_CashBank->insertHeaderAPpayment($dataHdr);

        $remarkDtl  = $this->input->post('txtRemarkDetail');
        $currIDDtl  = $this->input->post('txtCurrDetail');
        $amountDtl  = str_replace(',', '', $this->input->post('txtTotalDetal'));
        $eCurDtl    = str_replace(',', '', $this->input->post('txtToCurr'));
        $equiDtl    = str_replace(',', '', $this->input->post('txtEquiDetail'));
        $coaDtl     = $this->input->post('txtCOADetail');
        //$cfDtl      = $this->input->post('txtCFKeyDetail');
        $dtlRow     = count($remarkDtl);
        
        for($x =0 ; $x < $dtlRow; $x++):
            if($x == 0){
                $rate   = $this->input->post('txtAvgRateVaucher');
            }elseif($x == 1){
                $rate   = (float)$this->input->post('txtRateNego') - (float)$this->input->post('txtAvgRateVaucher');
            }elseif($x == 2){
                $rate   = $this->input->post('txtRateNego');
            }
            $dataDtl    = array(
                'header_id'     => $headerID,
                'no_facture'    => $this->input->post('txtFacture'),
                'remark'        => $remarkDtl[$x],
                'currency_id'   => $this->input->post('txtCurrBayar'),
                'rate_currency' => $rate,
                'amount'        => $amountDtl[$x],
                'cur_equi'      => $eCurDtl[$x],
                'usd_equi'      => $equiDtl[$x],
                'no_coa'        => $coaDtl[$x],
                //'key_cf'        => $cfDtl[$x],
                'created_by'    => $this->session->userdata('userid_1'),
                'created_date'  => date('Y-m-d H:i:s')
            );
            
            $this->M_CashBank->insertDetailAPpayment($dataDtl);
        endfor;

        // == insert into ap accounting ==
        $noReffAP   = $this->input->post('txtFacture');
        $this->insertDetailAPaccounting($noReffAP);

        redirect('APtransNew');
    }
    // ########## Do action Insert & Update IN AP transaction ##########
    // ########## Do action Insert & Update IN AP transaction ##########
    
    // function updateHutangPerInvoice($idVoucher){
    //     $getInvoice = $this->M_CashBank->getInvoiceByAPnumber($idVoucher);
    //     $countGet   = count($getInvoice);
        
    //     for($x = 0; $x < $countGet; $x++):
    //         $decode     = json_decode(json_encode($getInvoice[$x],TRUE));
    //         $noInvoice  = $decode->NoInvoice;
            
    //         $getTotalInAP   = $this->M_CashBank->getTotalFromAPAcc($noInvoice,$idVoucher);
            
    //         $getBayar       = $this->M_CashBank->getBayarFromUtang($noInvoice);
    //         $getSaldoHutang = $this->M_CashBank->getHutangFromUtang($noInvoice);
    //         $data   = array(
    //             'bayar'         => $getBayar+$getTotalInAP,
    //             'saldo_hutang'  => $getSaldoHutang-$getTotalInAP
    //         );
                
    //         $this->M_CashBank->updateUtangByNoInvoiceInOneAPnumber($noInvoice, $data); // Update table Hutang (ACC)
    //         $this->M_CashBank->updateRealisasiInAPdetail($idVoucher,$noInvoice); // Update table AP Detail (ACC)
    //     endfor;
    // }

    // function updateHutangBulananPerInvoice($idVoucher){
    //     $getInvoice = $this->M_CashBank->getInvoiceByAPnumber($idVoucher);
    //     $countGet   = count($getInvoice);
        
    //     $periode    = $this->M_CashBank->getPeriod();
    //     $thnPeriod  = date('Y', strtotime($periode));
    //     $blnPeriod  = date('m', strtotime($periode));
        
    //     for($x = 0; $x < $countGet; $x++):
    //         $decode     = json_decode(json_encode($getInvoice[$x],TRUE));
    //         $noInvoice  = $decode->NoInvoice;
            
    //         $getTotalInAP   = $this->M_CashBank->getTotalFromAPAcc($noInvoice,$idVoucher);
            
    //         $getBayar       = $this->M_CashBank->getBayarFromUtangBulanan($noInvoice,$blnPeriod,$thnPeriod);
    //         $getSaldoHutang = $this->M_CashBank->getHutangFromUtangBulanan($noInvoice,$blnPeriod,$thnPeriod);
    //         $data   = array(
    //             'bayar'         => $getBayar+$getTotalInAP,
    //             'saldo_hutang'  => $getSaldoHutang-$getTotalInAP
    //         );
                
    //         $this->M_CashBank->updateUtangBulananByNoInvoiceInOneAPnumber($noInvoice,$blnPeriod,$thnPeriod,$data); // Update table Hutang (ACC)
    //     endfor;
    // }

    // ########## = New Update Table Hutang + Hutang Bulanan = ##########
    function updateHutangPerInvoiceNew(){
        $paymentPerInvoice  = str_replace(',', '', $this->input->post('txtNewPayDtl'));
        $idIncPerInvoice    = $this->input->post('txtNewNoInvoiceDtl');
        $jenis 				= $this->input->post('txtjenis');

        $rowsPPI            = count($paymentPerInvoice);
        
        for($x = 0; $x < $rowsPPI; $x++):
            $getBayar       = $this->M_CashBank->getBayarFromUtang($idIncPerInvoice[$x],$jenis[$x]);
            $getSaldoHutang = $this->M_CashBank->getHutangFromUtang($idIncPerInvoice[$x],$jenis[$x]);
            $data   = array(
                'bayar'         => $getBayar + $paymentPerInvoice[$x],
                'saldo_hutang'  => $getSaldoHutang - $paymentPerInvoice[$x]
            );
            $this->M_CashBank->updateUtangByNoInvoiceInOneAPnumber($idIncPerInvoice[$x],$jenis[$x],$data); // Update table Hutang (ACC)
        endfor;
    }
    function updateHutangBulananPerInvoiceNew(){
        $paymentPerInvoice  = str_replace(',', '', $this->input->post('txtNewPayDtl'));
        $idIncPerInvoice    = $this->input->post('txtNewNoInvoiceDtl');
        $jenis 		= $this->input->post('txtjenis');

        $rowsPPI            = count($paymentPerInvoice);
        
        $periode    = $this->M_Fin_APNew->getPeriod_map();
        $thnPeriod  = date('Y', strtotime($periode));
        $blnPeriod  = date('m', strtotime($periode));
        
        for($x = 0; $x < $rowsPPI; $x++):
            //$getBayar       = $this->M_CashBank->getBayarFromUtangBulanan($idIncPerInvoice[$x],$blnPeriod,$thnPeriod);
            //$getSaldoHutang = $this->M_CashBank->getHutangFromUtangBulanan($idIncPerInvoice[$x],$blnPeriod,$thnPeriod);
            /*$data   = array(
                'bayar'         => $getBayar+$paymentPerInvoice[$x],
                'saldo_hutang'  => $getSaldoHutang-$paymentPerInvoice[$x]
            );*/
            //$this->M_CashBank->updateUtangBulananByNoInvoiceInOneAPnumber($idIncPerInvoice[$x],$blnPeriod,$thnPeriod,$data); // Update table Hutang (ACC)
            $this->M_CashBank->updateUtangBulananByNoInvoiceInOneAPnumberQuery($idIncPerInvoice[$x],$jenis[$x],$blnPeriod,$thnPeriod,$paymentPerInvoice[$x]); // Update table Hutang (ACC)
        endfor;
    }
    
    // ########## = Upadate Deposit Ap In Cash Bank = ##########
    function updateDepositAPinHeader(){
        $paymentPerInvoice  = $this->input->post('txtNewPayDtl');
        $idIncPerInvoice    = $this->input->post('txtNewNoInvoiceDtl');
        $rowsPPI            = count($paymentPerInvoice);
        
        for($x = 0; $x < $rowsPPI; $x++):
            $this->M_Fin_APNew->updateDepositAPinHeaderByInv($idIncPerInvoice[$x], abs(str_replace(',', '',$paymentPerInvoice[$x]))); // Update Deposit
        endfor;
    }
    // ########## = Insert to Detail AP Accounting = ##########
    function insertDetailAPaccounting($noReffAP){
        $noInvoice      = $this->input->post('txtNewNoInvoiceDtl');
        $jenis_trans    = $this->input->post('txtjenis');
        $currency       = $this->input->post('txtNewCurrDtl');
        $rateInvoice    = str_replace(',', '', $this->input->post('txtNewRateInvDtl'));
        $totalPayInv    = str_replace(',', '', $this->input->post('txtNewPayDtl'));
        $ratePay        = str_replace(',', '', $this->input->post('txtNewRateToPayDtl'));
        $rateNego       = str_replace(',', '', $this->input->post('txtNewRateNegoToPayDtl'));
        $totalPay       = str_replace(',', '', $this->input->post('txtNewPayDtl'));
        $rateUSD        = str_replace(',', '', $this->input->post('txtRateUSDdtl')); 
        
        $rowsPPI            = count($noInvoice);
        
        for($x = 0; $x < $rowsPPI; $x++){
            $data   = array(
                'NomorAP'           => $noReffAP,
                'NoInvoice'         => $noInvoice[$x],
                'jenis_trans'		=> $jenis_trans[$x],
                'Rate'              => $rateInvoice[$x],
                'Total'             => $totalPayInv[$x],
                'currency'          => $currency[$x],
                'rate_pay'          => $ratePay[$x],
                'rate_nego'         => $rateNego[$x],
                'total_pay'         => $totalPay[$x],
                'rate_usd'          => $rateUSD[$x],
                'realisasi_by'      => $this->session->userdata('userid_1'),
                'realisasi_date'    => date('Y-m-d', strtotime($this->input->post('txtTransDate'))),
                'created_by'        => $this->session->userdata('userid_1'),
                'created_date'      => date('Y-m-d H:i:s')
            );
            
            $this->M_Fin_APNew->insertDetailAPaccountingFromPayment($data);
        }
    }
    // ################################################################################
    // ################################################################################
    // 
    // ########## Select Back Recorded AP Payment ##########
    function selectAPpayment(){
        $data   = array(
            '_selectHeader' => $this->M_Fin_APNew->selectAPforFindAP()->result()
        );
        $this->load->view('finance/transaction/ap_trans_new/findAP/selectAP',$data);
    }
    function selectSuppliertForAPbySuppCode(){
        $idSupp = $this->input->post('txtCodeSupp');
        $get    = $this->M_Fin_APNew->selectSupplierForAPbyCode($idSupp);
        $data   = array(
            'suppName'  => $get->suppliercompany,
            'suppCOA'   => $get->nocoa
        );
        echo json_encode($data);
    }
    function reviewAPpayment($headerID){
        $headID = decode_str($headerID);
        $get    = $this->M_Fin_APNew->selectHeaderAPforReview($headID);
        $noReff = $get->no_facture;
        $thnPeriod  = $get->thn_periode;
        $blnPeriod  = $get->bln_periode;
        $data   = array(
            '_periode'          => date('Y-m-d', strtotime($thnPeriod.'-'.$blnPeriod.'-01')),
            '_selectCurrency'   => $this->db->get('zhl_gen_tbl_mst_currency')->result(),
            '_titleForm'        => array('head' => 'Transaction', 'desc' => 'Payment A/P'),
            
            '_currBayar'        => $get->currency_bayar,
            '_selectHeaderAP'   => $this->M_Fin_APNew->selectHeaderAPforReview($headID),
            '_selectInvoiceAP'  => $this->M_Fin_APNew->selectInvoiceAPforReview($noReff),
            '_selectDetailAP'   => $this->M_Fin_APNew->selectDetailAPforReview($headID)->result(),
            '_selectDtlJrnal'   => $this->M_Fin_APNew->selectDetailJurnalAPforReview($headID)->result()
        );

        // echo "<pre>";
        // print_r($data['_selectDtlJrnal']);
        // echo "</pre>";
        // die;
        $this->template->display('finance/transaction/ap_trans_new/findAP/index-review',$data);
    }
    // ============== ALL About Draft ==================
    function reviewAPforDraft($headerID){
        $headID = ($headerID);
        $get    = $this->M_Fin_APNew->selectHeaderAPforReview($headID);
        $noReff = $get->no_facture;
        $thnPeriod  = $get->thn_periode;
        $blnPeriod  = $get->bln_periode;
        $data   = array(
            '_periode'          => date('Y-m-d', strtotime($thnPeriod.'-'.$blnPeriod.'-01')),
            '_selectCurrency'   => $this->db->get('zhl_gen_tbl_mst_currency')->result(),
            '_titleForm'        => array('head' => 'Transaction', 'desc' => 'Payment A/P'),
            
            '_currBayar'        => $get->currency_bayar,
            '_selectHeaderAP'   => $this->M_Fin_APNew->selectHeaderAPforReview($headID),
            '_selectInvoiceAP'  => $this->M_Fin_APNew->selectInvoiceAPforReview($noReff),
            '_selectDetailAP'   => $this->M_Fin_APNew->selectDetailAPforReview($headID)->result()
        );
        $this->template->display('finance/transaction/ap_trans_new/saveDraft/index-draft',$data);
    }

    function payAPfromDraft(){
        $headerID   = decode_str($this->input->post('txtInputAPprimary'));
        $noReff     = $this->input->post('txtFacture');

        $suppID     = $this->input->post('txtSuplierID');
        $suppCOA    = $this->M_CashBank->getSupplierCOA($suppID);
        $period     = $this->input->post('txtAPtransPeriod');
        
        $dataHdr    = array(
            'no_facture'    => $this->input->post('txtFacture'),
            'trans_date'    => date('Y-m-d', strtotime($this->input->post('txtTransDate'))),
            //'thn_periode'   => date('Y', strtotime($period)),
            //'bln_periode'   => date('m', strtotime($period)),
            //'trans_type'    => 'AP',
            //'no_voucher'    => $this->input->post('txtFacture'),
            //'code_cashbank' => $this->input->post('txtCashBankCode'),
            'check_number'  => $this->input->post('txtCheckBank'),
            //'supplier_id'   => $suppID,
            //'supplier_coa'  => $suppCOA,
            //'currency_id'   => $this->input->post('selCurrencyVoucher'),
            'currency_rate' => $this->input->post('txtRateVoucher'),
            //'rate_nego'     => $this->input->post('txtRateNego'),
            //'rate_equi'     => 0,
            //'currency_bayar'=> $this->input->post('txtCurrBayar'),
            //'remark'        => $this->input->post('txtSuplierRemark'),
            'is_draf'       => 0,
            'updated_by'    => $this->session->userdata('userid_1'),
            'updated_date'  => date('Y-m-d H:i:s')
        );
        
        $this->M_Fin_APNew->updateHeaderAPpayment($dataHdr,$headerID);

        // ############ Delete dulu detail Draft ======================================================
        // Delete AP Detail In Accounting ######
        $this->M_Fin_APNew->deleteDetailAPaccountingFromPayment($noReff);
        $this->M_Fin_APNew->deleteDetailAPpayment($noReff,$headerID);
        // ############ Delete dulu detail Draft ======================================================

        $remarkDtl  = $this->input->post('txtRemarkDetail');
        $currIDDtl  = $this->input->post('txtCurrDetail');
        $amountDtl  = str_replace(',', '', $this->input->post('txtTotalDetal'));
        $eCurDtl    = str_replace(',', '', $this->input->post('txtToCurr'));
        $equiDtl    = str_replace(',', '', $this->input->post('txtEquiDetail'));
        $coaDtl     = $this->input->post('txtCOADetail');
        //$cfDtl      = $this->input->post('txtCFKeyDetail');
        $dtlRow     = count($remarkDtl);
        
        for($x =0 ; $x < $dtlRow; $x++):
            if($x == 0){
                $rate   = $this->input->post('txtAvgRateVaucher');
            }elseif($x == 1){
                $rate   = (float)$this->input->post('txtRateNego') - (float)$this->input->post('txtAvgRateVaucher');
            }elseif($x == 2){
                $rate   = $this->input->post('txtRateNego');
            }
            $dataDtl    = array(
                'header_id'     => $headerID,
                'no_facture'    => $this->input->post('txtFacture'),
                'remark'        => $remarkDtl[$x],
                'currency_id'   => $this->input->post('txtCurrBayar'),
                'rate_currency' => $rate,
                'amount'        => $amountDtl[$x],
                'cur_equi'      => $eCurDtl[$x],
                'usd_equi'      => $equiDtl[$x],
                'no_coa'        => $coaDtl[$x],
                //'key_cf'        => $cfDtl[$x],
                'created_by'    => $this->session->userdata('userid_1'),
                'created_date'  => date('Y-m-d H:i:s')
            );
            
            $this->M_CashBank->insertDetailAPpayment($dataDtl);
            
            if($x == 0){
                $debit  = $eCurDtl[0];
                $kredit = 0;
                $jumlah = $debit;
                $dk     = 'D';
            }elseif($x == 1){
                if($eCurDtl[1] > 0){
                    $debit  = $eCurDtl[1];
                    $kredit = 0;
                    $jumlah = $debit;
                    $dk     = 'D';
                }else{
                    $debit  = 0;
                    $kredit = $eCurDtl[1];
                    $jumlah = $kredit;
                    $dk     = 'C';
                }
            }elseif($x == 2){
                $debit  = 0;
                $kredit = $eCurDtl[2];
                $jumlah = 0-$kredit;
                $dk     = 'C';
            }
            $dataHistory    = array(
                'header_id'         => $headerID,
                'no_facture'        => $this->input->post('txtFacture'),
                'trans_type'        => 'AP',
                'date1'             => date('Y-m-d', strtotime($this->input->post('txtTransDate'))),
                'cb_code'           => $coaDtl[$x],
                'no_voucher'        => $this->input->post('txtFacture'),
                'from_to'           => 0,
                'trans_description' => $this->input->post('txtSuplierRemark'),
                'supplier'          => $this->input->post('txtSuplierID'),
                'coa_supplier'      => $suppCOA,
                'currency_id'       => $this->input->post('txtCurrBayar'),
                'currency_rate'     => $rate,
                'coa_code'          => $coaDtl[$x],
                'coa_description'   => 0,
                'debit_credit'      => $dk,
                'jumlah'            => $jumlah,
                'debit'             => $debit,
                'credit'            => $kredit,
                'remark'            => $this->input->post('txtSuplierRemark'),
                //'key_cf'            => $cfDtl[$x],
                'created_by'        => $this->session->userdata('userid_1'),
                'created_date'      => date('Y-m-d H:i:s')
            );
            
            $this->M_CashBank->insertCBhistory($dataHistory);
        endfor;

        // == update hutang == 
        $this->updateHutangPerInvoiceNew();
        $this->updateHutangBulananPerInvoiceNew();
        
        // == insert into ap accounting ==
        $noReffAP   = $this->input->post('txtFacture');
        $this->insertDetailAPaccounting($noReffAP);
        
        // == insert to jurnal ==
        $coaHutPiu  = array('130401','130402','130403','130404','200101','200102','200103','200105');
        for($y = 0; $y < $dtlRow; $y++):
            if($y == 0){
                $debit  = $equiDtl[0];
                $kredit = 0;
                $jumlah = $debit;
                $dk     = 'D';
                $rate   = $this->input->post('txtAvgRateVaucher');
            }elseif($y == 2){
                $debit  = 0;
                $kredit = $equiDtl[2];
                $jumlah = 0-$kredit;
                $dk     = 'C';
                $rate   = $this->input->post('txtRateNego');
            }else{
                $debit  = 0;
                $kredit = 0;
                $jumlah = 0;
                $dk     = NULL;
                $rate   = (float)$this->input->post('txtRateNego') - (float)$this->input->post('txtAvgRateVaucher');
            }
            
            $dataJurnal = array(
                'JenisJurnalID'     => $remarkDtl[$y],
                'jenis_trans'       => 'AP',
                'CompanyID'         => 'PSS',
                'Tanggal'           => date('Y-m-d', strtotime($this->input->post('txtTransDate'))),
                'NoJurnal'          => $this->input->post('txtFacture'),
                'NoJurnalDtl'       => $this->input->post('txtCheckBank'),
                'Periode'           => date('mY', strtotime($period)),
                'NoCOA'             => $coaDtl[$y],
                'sub_account_type'  => (in_array($txtNoCOA[$y], $coaHutPiu) ? 'HUT' : ' '),
                'sub_account_id'    => $this->input->post('txtSuplierID'),
                'Uraian'            => $this->input->post('txtCheckBank'),
                'Debet'             => $debit,
                'Kredit'            => $kredit,
                'chk'               => $dk,
                'Total'             => $jumlah,
                'Currency'          => 'USD',
                'Rate'              => $rate,
                'Keterangan'        => $this->input->post('txtSuplierRemark'),
                'created_by'        => $this->session->userdata('userid_1'),
                'created_date'      => date('Y-m-d H:i:s')
            );
            if($y == 0 || $y == 2){
                $this->M_CashBank->insertToJurnalAcc($dataJurnal);
            }
        endfor;
        
        redirect('APtransNew/reviewAPpayment/'.encode_str($headerID));
    }

    // ################################################################################
    // ################################################################################
    // 
    // ########## Delete Record AP Payment ##########
    function deleteAPpayment(){
        $primary    = decode_str($this->input->post('txtInputAPprimary'));
        $get        = $this->M_Fin_APNew->selectHeaderAPforReview($primary);
        $noReff     = $get->no_facture;
        $thnPeriod  = $get->thn_periode;
        $blnPeriod  = $get->bln_periode;
        $cur        = $get->currency_id;
        $created = $this->session->userdata('userid_1');
        $created_date = date('Y-m-d');

        $cek_reff = $this->M_Fin_CB->cek_reff('P',$thnPeriod,$cur);

        // Delete AP Detail In Accounting ######
        $this->M_Fin_APNew->deleteDetailAPaccountingFromPayment($noReff);
        // Return Hutang dan Hutang Bulanan ######
        $this->returnBackHutangPerInvoiceByPass();
        $this->returnBackHutangBulananPerInvoice($thnPeriod, $blnPeriod);
        
        // #### ========== ####
        $this->M_Fin_APNew->deleteAPfronCBhistory($noReff,$primary);
        $this->M_Fin_APNew->deleteDetailAPjurnal($noReff,$primary);
        $this->M_Fin_APNew->deleteDetailAPpayment($noReff,$primary);
        
        if($noReff != $cek_reff->GEN){
            $data_hdr = array('remark' => 'Cancelled',
                'updated_by'    => $created,
                'updated_date'  => $created_date

            );

            $this->M_Fin_APNew->updateHeaderAPpayment($primary,$data_hdr);

            $data_jur = array('Debet' => 0,
                'Kredit'            => 0,
                'Debet_SGD'         =>0,
                'Kredit_SGD'        =>0,
                'Total'             =>0,
                'keterangan'        => 'Cancelled',
                'last_update_by'    => $created,
                'last_update_date'  => $created_date

            );

            // Delete Journal ######
            $this->M_Fin_APNew->updateAPfromJurnalAcc($noReff,$data_jur);
        } else {
            $this->M_Fin_APNew->deleteHeaderAPpayment($primary);
            $this->M_Fin_APNew->deleteAPfromJurnalAcc($noReff);
        }
        
        redirect(site_url('APtransNew'));
    }
    function returnBackHutangPerInvoiceByPass(){
        $idIncPerInvoice    = $this->input->post('txtNoInvoiceDtl');
        $jenis   			= $this->input->post('txtjenis');
        $rowsPPI            = count($idIncPerInvoice);
        
        for($x = 0; $x < $rowsPPI; $x++):
            $this->M_Fin_APNew->resetPaymentHutang($idIncPerInvoice[$x],$jenis[$x]);
            $this->M_Fin_APNew->resetPaymentHutangSaldo($idIncPerInvoice[$x],$jenis[$x]);
        endfor;        
    }

    function returnBackHutangPerInvoice(){
        $paymentPerInvoice  = str_replace(',', '', $this->input->post('txtPeymentInvoiceDtl'));
        $idIncPerInvoice    = $this->input->post('txtNoInvoiceDtl');
        $jenis   			= $this->input->post('txtjenis');
        $rowsPPI            = count($paymentPerInvoice);
        
        for($x = 0; $x < $rowsPPI; $x++):
        	//belum tambah jenis
            $getBayar       = $this->M_CashBank->getBayarFromUtang($idIncPerInvoice[$x],$jenis[$x]);
            $getSaldoHutang = $this->M_CashBank->getHutangFromUtang($idIncPerInvoice[$x],$jenis[$x]);
            $data   = array(
                'bayar'         => $getBayar - $paymentPerInvoice[$x],
                'saldo_hutang'  => $getSaldoHutang + $paymentPerInvoice[$x]
            );
            $this->M_CashBank->updateUtangByNoInvoiceInOneAPnumber($idIncPerInvoice[$x],$jenis[$x], $data); // Update table Hutang (ACC)
        endfor;
    }

    function returnBackHutangBulananPerInvoice($thnPeriod,$blnPeriod){
        $paymentPerInvoice  = str_replace(',', '', $this->input->post('txtPeymentInvoiceDtl'));
        $idIncPerInvoice    = $this->input->post('txtNoInvoiceDtl');
        $jenis   			= $this->input->post('txtjenis');
        $rowsPPI            = count($paymentPerInvoice);
        
        for($x = 0; $x < $rowsPPI; $x++):
            //$getBayar       = $this->M_CashBank->getBayarFromUtangBulanan($idIncPerInvoice[$x],$blnPeriod,$thnPeriod);
            //$getSaldoHutang = $this->M_CashBank->getHutangFromUtangBulanan($idIncPerInvoice[$x],$blnPeriod,$thnPeriod);
            /*$data   = array(
                'bayar'         => $getBayar-$paymentPerInvoice[$x],
                'saldo_hutang'  => $getSaldoHutang+$paymentPerInvoice[$x]
            );*/
            $this->M_CashBank->updateUtangBulananByNoInvoiceInOneAPnumberQueryReturn($idIncPerInvoice[$x],$jenis[$x],$blnPeriod,$thnPeriod,$paymentPerInvoice[$x]); // Update table Hutang (ACC)
        endfor;
    }

    // =========================== Print Report ===========================
    function paymentAdvice($noAP){
        $get    = $this->M_Fin_APNew->selectHeaderAPforPrint($noAP);
        $noChk  = $get->check_number;
        $trans_date= date("d-m-Y",  strtotime($get->trans_date));
        if($noChk == NULL){
            $noChk  = '______________________';
        }
        $data   = array(
            '_numberCheck'      => $noChk,
             'trans_date'       => $trans_date,
            '_selectInvoice'    => $this->M_Fin_APNew->selectInvoiceForPaymentAdvice($noAP)
        );
        $this->load->view('finance/report/rpt_ap/payment_advice',$data);
    }


    // test ============
    function testLinked(){
        //$this->updateHutangPerInvoiceNew();
        //$this->updateHutangBulananPerInvoiceNew();
        
        //$noReffAP   = $this->input->post('txtFacture');
        //$this->insertDetailAPaccounting($noReffAP);
        
        $test   = ' 2';
        echo (int)$test;
    }
    
}