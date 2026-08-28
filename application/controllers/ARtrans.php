<?php defined('BASEPATH') OR exit('No direct script access allowed');

/* 
 * Author : ITD15
 */

class ARtrans extends CI_Controller{
    public function __construct() {
        parent::__construct();

        //is_maintenance(FALSE, $this->session->userdata('userid_1'));
        
        if(!$this->session->userdata('userid_1')){
            redirect('login');
        }
        
        date_default_timezone_set("Asia/Jakarta");
        $this->load->model(array('M_CashBank','M_Fin_AR','M_Fin_CB','M_vcdn','M_General_Journal'));
    }
    
    function index(){
        $data['_periode']           = $this->M_Fin_AR->getPeriod_mar();
        $data['_selectCurrency'] = $this->db->where('not_active', 0)->get('zhl_gen_tbl_mst_currency')->result();

        // $data['_selectCurrency']    = $this->db->get('zhl_gen_tbl_mst_currency')->result();
        $data['_selectGST']         = $this->db->get('zhl_gen_tbl_mst_gst')->result();
        $data['dept_code']          = $this->M_General_Journal->get_departmentcode();
        $data['_titleForm']         = array('head' => 'Transaction', 'desc' => 'Receivable A/R');
        $data['_actionFrom']        = '/insertARpayment';
        $company   = strtoupper($this->session->userdata('company_id'));
        $data['List_coa']           = $this->M_vcdn->get_coa($company);
        $this->template->display('finance/transaction/ar_trans/index',$data);
    }
    function cekNumReffAR(){
        $value  = $this->input->post('value');
        $this->db->where('no_facture', $value);
        $get    = $this->db->get('fin_tbltrn_payment_hdr');
        if($get->num_rows() > 0){
            echo 1;
        }else{
            echo 0;
        }
    }
    function selectCustomerForAR(){
        $tgl    = $this->input->post('txtTglInvoice');
        $data   = array(
            '_selectSupplier' => $this->M_Fin_AR->selectCustomerforARtrans($tgl)->result()
        );
        $this->load->view('finance/transaction/ar_trans/selectSupplier',$data);
    }

    function selectInvoiceForAR(){
        $idSupp = $this->input->post('incSupplierID');
        $idDate = date('Y-m-d', strtotime($this->input->post('incTransDate')));
        $data   = array(
            '_selectInvoice' => $this->M_Fin_AR->selectInvoiceWhereForARtrans($idSupp, $idDate)->result()
        );
        
        $this->load->view('finance/transaction/ar_trans/selectInvoice',$data);
    }

    function selectModalAR(){
        $data   = array(
            '_selectAP' => $this->M_Fin_AR->selectARfromAccounting()->result()
        );
        $this->load->view('finance/transaction/ar_trans/selectAR',$data);
    }
    function selectCOA(){
        $company   = strtoupper($this->session->userdata('company_id'));
        $data   = array(
            '_getMasterCOA' => $this->M_Fin_AR->selectCOAforARtrans($company)->result()
        );
        $this->load->view('finance/transaction/ar_trans/selectMCOA',$data);
    }
    function selectCurrencyAR(){
        $idCurr = $this->input->post('txtCurrAjax');
        $selectKurs = $this->M_Fin_AR->getKursByIDonAR($idCurr)->row();
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
        $selectKurs = $this->M_Fin_AR->getKursByIDonAR($noCurrency,$tglInvoice)->row();
        
        $expld      = explode('|', $noInvoice);
        $count      = count($expld);
        for($x = 0; $x <$count; $x++){
            $get[] = $this->M_Fin_AR->getCurrOnDateInvoiceByCurrencyIDonAR($expld[$x], $noCurrency);
        }
        
        $data   = array(
            'rate_usd'  => number_format($selectKurs->rate_usd,6),
            'rate_sgd'  => number_format($selectKurs->rate_kurs,6),
            'inv'       => $get
        );
        echo json_encode($data);
    }

    function getCurrBank(){
        $idCurr = $this->input->post('txtCurrency');
        $txDate = $this->input->post('txtTglInvoice');
        $selectKurs = $this->M_Fin_AR->getKursByID($idCurr,$txDate)->row();
        
        $data   = array(
            'rate_usd'  => number_format($selectKurs->rate_usd,6),
            'rate_sgd'  => number_format($selectKurs->rate_kurs,6)
            );
        echo json_encode($data);
    }


    // ########## Do action Insert & Update IN AR transaction ##########
    function insertARpayment(){

      
        $suppID     = $this->input->post('txtSuplierID');
        $suppCOA    = $this->M_CashBank->getCustomerCOA($suppID);
        $period     = $this->M_CashBank->getPeriod();
        
        $dataHdr    = array(
            'no_facture'    => $this->input->post('txtFacture'),
            'trans_date'    => date('Y-m-d', strtotime($this->input->post('txtTransDate'))),
            'thn_periode'   => date('Y', strtotime($period)),
            'bln_periode'   => date('m', strtotime($period)),
            'trans_type'    => 'AR',
            'no_voucher'    => $this->input->post('txtFacture'),
            'code_cashbank' => $this->input->post('txtCashBankCode'),
            'check_number'  => $this->input->post('txtCheckBank'),
            'supplier_id'   => $suppID,
            'supplier_coa'  => $suppCOA,
            'currency_id'   => $this->input->post('txtCurrBayar'),
            'currency_rate' => str_replace(',', '', $this->input->post('txtRateBayar')),
            'rate_nego'     => str_replace(',', '', $this->input->post('txtRateBayar')),
            'rate_equi'     => 0,
            'rate_sgd'      => $this->input->post('txtRateSGD'),
            'currency_bayar'=> $this->input->post('txtCurrBayar'),
            'remark'        => $this->input->post('txtSuplierRemark'),
            'created_by'    => $this->session->userdata('userid_1'),
            'created_date'  => date('Y-m-d H:i:s')
        );
        
        $headerID   = $this->M_CashBank->insertHeaderAPpayment($dataHdr);
        
        // $remarkDtl  = $this->input->post('txtRemarkDetail');
        // $currIDDtl  = $this->input->post('txtCurrDetail');
        // $amountDtl  = str_replace(',', '', $this->input->post('txtTotalDetal'));
        // $eCurDtl    = str_replace(',', '', $this->input->post('txtToCurr'));
        // $equiDtl    = str_replace(',', '', $this->input->post('txtEquiDetail'));
        // $coaDtl     = $this->input->post('txtCOADetail');
        // $cfDtl      = $this->input->post('txtCFKeyDetail');
        // $dtlRow     = count($remarkDtl);
        
        // for($x=0; $x<$dtlRow; $x++):
        //     if($x == 0){
        //         $rate   = $this->input->post('txtAvgRateVaucher');
        //     }elseif($x == 1){
        //         $rate   = (float)$this->input->post('txtRateNego') - (float)$this->input->post('txtAvgRateVaucher');
        //     }elseif($x == 2){
        //         $rate   = $this->input->post('txtRateNego');
        //     }
        //     $dataDtl    = array(
        //         'header_id'     => $headerID,
        //         'no_facture'    => $this->input->post('txtFacture'),
        //         'remark'        => $remarkDtl[$x],
        //         'currency_id'   => $this->input->post('txtCurrBayar'),
        //         'rate_currency' => $rate,
        //         'amount'        => $amountDtl[$x],
        //         'cur_equi'      => $eCurDtl[$x],
        //         'usd_equi'      => $equiDtl[$x],
        //         'no_coa'        => $coaDtl[$x],
        //         //'key_cf'        => $cfDtl[$x],
        //         'created_by'    => $this->session->userdata('userid_1'),
        //         'created_date'  => date('Y-m-d H:i:s')
        //     );
            
        //     $this->M_CashBank->insertDetailAPpayment($dataDtl);

        // endfor;

        // == update piutang == 
        $this->updatePiutangPerInvoiceNew();
        $this->updatePiutangBulananPerInvoiceNew();
        
        // == insert into ap accounting ==
        $noReffAR   = $this->input->post('txtFacture');
        $this->insertDetailAPaccounting($noReffAR);

        $txtNoCOA       = $this->input->post("txtNoCOA");
        $txtNameCOA     = $this->input->post('txtNameCOA');
        $txtDebit       = $this->input->post('txtDebit');
        $txtCredit      = $this->input->post('txtCredit');
        $txtDebitUSD    = $this->input->post('txtDebitUSD');
        $txtCreditUSD   = $this->input->post('txtCreditUSD');
        $txtRemark      = $this->input->post('txtRemark');
        $txtGSTname     = $this->input->post('txtGST');
        $txtGSTvalue    = $this->input->post('txtGSTvalue');
        $txtDept        = $this->input->post('txtDeptCode');
        //$txtCashFlow  = $this->input->post('txtCashFlowKey');
        for($x = 0; $x < count($txtNoCOA); $x++):
            $detail = array(
                'header_id'         => $headerID,
                'no_reff'           => $this->input->post('txtFacture'),
                'coa'               => $txtNoCOA[$x],
                'coa_description'   => $txtNameCOA[$x],
                'debit'             => str_replace(',', '', $txtDebit[$x]),
                'credit'            => str_replace(',', '', $txtCredit[$x]),
                'remark'            => $txtRemark[$x],
                'gst_type'          => $txtGSTname[$x],
                'gst_value'         => str_replace(',', '', $txtGSTvalue[$x]),
                //'cf_key'            => $txtCashFlow[$x],
                'created_by'        => $this->session->userdata('userid_1'),
                'created_date'      => date('Y-m-d H:i:s'),
                'dept_code'         => $txtDept[$x]
            );
            $this->M_Fin_AR->insertDetailARjurnal($detail);
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
                'trans_type'        => 'AR',
                'date1'             => date('Y-m-d', strtotime($this->input->post('txtTransDate'))),
                'cb_code'           => $this->input->post('txtCashBankCode'),
                'trans_description' => $this->input->post('txtSuplierRemark'),
                'supplier'          => $suppID,
                'coa_supplier'      => $suppCOA,
                'currency_id'       => $this->input->post('txtCurrBayar'),
                'currency_rate'     => str_replace(',', '', $this->input->post('txtRateBayar')),
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

        $getKursSGD = $this->M_Fin_AR->getKursByIDonAR($this->input->post('txtCurrBayar'),$this->input->post('txtTransDate'))->row();
        $period = $this->M_CashBank->getPeriod();
        $coaHutPiu  = array('300001','300002','300003','130404','400001','400002','400003','200105');
        for($y = 0; $y < count($txtNoCOA); $y++):
            if($txtCredit[$y] <> 0 || $txtCreditUSD[$y] <> 0){
                $dk     = 'C';
                $jml    = str_replace(',', '', $txtCredit[$y]);
                $debet = '0';
                $debet_sgd = '0';
                $credit = number_format(str_replace(",", "", $txtCreditUSD[$y]), 2, ".", "");
                $credit_sgd = number_format(str_replace(",", "", $txtCredit[$y]) * $getKursSGD->rate_kurs, 2, ".", "");
                $sum_credit +=  $credit;
                $sum_credit_sgd += $credit_sgd;
            }else if($txtDebit[$y] <> 0 || $txtDebitUSD[$y] <> 0){
                $dk     = 'D';
                $jml    = str_replace(',', '', $txtDebit[$y]);
                $debet = number_format(str_replace(",", "", $txtDebitUSD[$y]), 2, ".", "");
                $debet_sgd = number_format(str_replace(",", "", $txtDebit[$y]) * $getKursSGD->rate_kurs, 2, ".", "");
                $credit = '0';
                $credit_sgd = '0';
                $sum_debet += $debet;
                $sum_debet_sgd += $debet_sgd;
            }
            else
            {
                $jml = 0;
            }

            $jml2    = str_replace(',', '', $txtCreditUSD[$y]) + str_replace(',', '', $txtDebitUSD[$y]);

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
                $dataJurnal = array(
                    'JenisJurnalID'     => $txtRemark[$y],
                    'jenis_trans'       => 'AR',
                    'CompanyID'         => 'PSS',
                    'Tanggal'           => date('Y-m-d', strtotime($this->input->post('txtTransDate'))),
                    'NoJurnal'          => $this->input->post('txtFacture'),
                    'NoJurnalDtl'       => $this->input->post('txtCheckBank'),
                    'Periode'           => date('mY', strtotime($period)),
                    'NoCOA'             => $txtNoCOA[$y],
                    'sub_account_type'  => (in_array($txtNoCOA[$y], $coaHutPiu) ? 'PIU' : ' '),
                    'sub_account_id'    => $this->input->post('txtSuplierID'),
                    'gst_type'          => $txtGSTname[$y],
                    'gst_value'         => str_replace(',', '', $txtGSTvalue[$y]),
                    'Uraian'            => $this->input->post('txtSuplierRemark'),
                    'Debet'             => round($debet,2),
                    'Kredit'            => round($credit,2),
                    'Debet_SGD'         => round($debet_sgd, 2),
                    'Kredit_SGD'        => round($credit_sgd, 2),
                    'chk'               => $dk,
                    'Total'             => round(str_replace(',', '',$this->input->post('txtTotalPayment')), 2),
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
                    'jenis_trans'       => 'AR',
                    'CompanyID'         => 'PSS',
                    'Tanggal'           => date('Y-m-d', strtotime($this->input->post('txtTransDate'))),
                    'NoJurnal'          => $this->input->post('txtFacture'),
                    'NoJurnalDtl'       => $this->input->post('txtCheckBank'),
                    'Periode'           => date('mY', strtotime($period)),
                    'NoCOA'             => $txtNoCOA[$y],
                    'sub_account_type'  => (in_array($txtNoCOA[$y], $coaHutPiu) ? 'PIU' : ' '),
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
                    'Rate'              => str_replace(',', '', $this->input->post('txtRateBayar')),
                    'rate_sgd'          => $getKursSGD->rate_kurs,
                    'Keterangan'        => $this->input->post('txtSuplierRemark'),
                    'created_by'        => $this->session->userdata('userid_1'),
                    'created_date'      => date('Y-m-d H:i:s'),
                    'dept_code'         => $txtDept[$y]
                );  
            }
            

            if ($jml <> 0 OR $jml2 <> 0) {
                $this->M_CashBank->insertToJurnalAcc($dataJurnal);
            }
        endfor;

        // ## UPDATE PURCHASE AND SHIPPING =====================================
        $this->updatePurShipInvoice();
        
        redirect('ARtrans/reviewARpayment/'.encode_str($headerID));
    }

    // function updatePiutangPerInvoice($idVoucher){
    //     $getInvoice = $this->M_CashBank->getInvoiceByARnumber($idVoucher);
    //     $countGet   = count($getInvoice);
        
    //     for($x = 0; $x < $countGet; $x++):
    //         $decode     = json_decode(json_encode($getInvoice[$x],TRUE));
    //         $noInvoice  = $decode->NoInvoice;
            
    //         $getTotalInAR   = $this->M_CashBank->getTotalFromARAcc($noInvoice,$idVoucher);
            
    //         $getBayar       = $this->M_CashBank->getBayarFromPiutang($noInvoice);
    //         $data   = array(
    //             'bayar'         => $getBayar+$getTotalInAR
    //         );
                
    //         $this->M_CashBank->updatePiutangByNoInvoiceInOneARnumber($noInvoice, $data); // Update table Piutang (ACC)
    //         $this->M_CashBank->updateRealisasiInAPdetail($idVoucher,$noInvoice); // Update table AP Detail (ACC)
    //     endfor;
    // }

    // function updatePiutangBulananPerInvoice($idVoucher){
    //     $getInvoice = $this->M_CashBank->getInvoiceByARnumber($idVoucher);
    //     $countGet   = count($getInvoice);
        
    //     $periode    = $this->M_CashBank->getPeriod();
    //     $thnPeriod  = date('Y', strtotime($periode));
    //     $blnPeriod  = date('m', strtotime($periode));
        
    //     for($x = 0; $x < $countGet; $x++):
    //         $decode     = json_decode(json_encode($getInvoice[$x],TRUE));
    //         $noInvoice  = $decode->NoInvoice;
            
    //         $getTotalInAP   = $this->M_CashBank->getTotalFromARAcc($noInvoice,$idVoucher);
            
    //         $getBayar       = $this->M_CashBank->getBayarFromPiutangBulanan($noInvoice,$blnPeriod,$thnPeriod);
    //         $data   = array(
    //             'bayar'         => $getBayar+$getTotalInAP
    //         );
            
    //         $this->M_CashBank->updatepiutangBulananByNoInvoiceInOneAPnumber($noInvoice,$blnPeriod,$thnPeriod,$data); // Update table Hutang (ACC)
    //     endfor;
    // }
    
    // ########## = New Update Table Piutang + Piutang Bulanan = ##########
    function updatePiutangPerInvoiceNew(){
        $paymentPerInvoice  = str_replace(',', '', $this->input->post('txtNewPayDtl'));
        $idIncPerInvoice    = $this->input->post('txtNewNoInvoiceDtl');
        $jenis    = $this->input->post('txtjenis');
        $rowsPPI            = count($paymentPerInvoice);
        
        for($x = 0; $x < $rowsPPI; $x++):
            $getBayar       = $this->M_CashBank->getBayarFromPiutang($idIncPerInvoice[$x],$jenis[$x]);
            $data   = array(
                'bayar'         => $getBayar + $paymentPerInvoice[$x]
            );
            $this->M_CashBank->updatePiutangByNoInvoiceInOneARnumber($idIncPerInvoice[$x],$jenis[$x], $data); // Update table Piutang (ACC)
        endfor;
    }
    function updatePiutangBulananPerInvoiceNew(){
        $paymentPerInvoice  = str_replace(',', '', $this->input->post('txtNewPayDtl'));
        $idIncPerInvoice    = $this->input->post('txtNewNoInvoiceDtl');
        $jenis    = $this->input->post('txtjenis');
        $rowsPPI            = count($paymentPerInvoice);
        
        $periode    = $this->M_CashBank->getPeriod();
        $thnPeriod  = date('Y', strtotime($periode));
        $blnPeriod  = date('m', strtotime($periode));
        
        for($x = 0; $x < $rowsPPI; $x++):
            /*$getBayar       = $this->M_CashBank->getBayarFromPiutangBulanan($idIncPerInvoice[$x],$blnPeriod,$thnPeriod);
            $data   = array(
                'bayar'         => $getBayar+$paymentPerInvoice[$x]
            );*/
            
            //$this->M_CashBank->updatepiutangBulananByNoInvoiceInOneARnumber($idIncPerInvoice[$x],$blnPeriod,$thnPeriod,$data); // Update table Hutang (ACC)
            $this->M_CashBank->updatepiutangBulananByNoInvoiceInOneARnumberQuery($idIncPerInvoice[$x],$jenis[$x],$blnPeriod,$thnPeriod,$paymentPerInvoice[$x]); // Update table Hutang (ACC)
        endfor;
    }
    // ####### = Insert to Detail AP Accounting = ##########
    function insertDetailAPaccounting($noReffAR){
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
                'NomorAR'           => $noReffAR,
                'NoInvoice'         => $noInvoice[$x],
                'jenis_trans'       => $jenis_trans[$x],
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
            
            $this->M_Fin_AR->insertDetailARaccountingFromPayment($data);
        }
    }
    // ######## = Update Invoice Purchase and Shipping if Received = ########
    function updatePurShipInvoice(){
        $idIncPerInvoice = $this->input->post('txtNewNoInvoiceDtl');
        $rows = count($idIncPerInvoice);
        
        for($x = 0; $x < $rows; $x++){
            $cek    = $this->M_Fin_AR->checkInvoiceInPurShip($idIncPerInvoice[$x]);
            if ($cek['status'] == TRUE){
                $this->M_Fin_AR->updatePurchase($cek['noInvoice']);
                $this->M_Fin_AR->updateShipping($cek['noInvoice']);
            }
        }
    }
    
    // ################################################################################
    // ################################################################################
    // 
    // ########## Select Back Recorded AR Payment ##########
    function selectARpayment(){
        $data   = array(
            '_selectHeader' => $this->M_Fin_AR->selectARforFindAR()->result()
        );
        $this->load->view('finance/transaction/ar_trans/findAR/selectAR',$data);
    }
    function selectCustomerForARbyCustCode(){
        $idSupp = $this->input->post('txtCodeSupp');
        $get    = $this->M_Fin_AR->selectCustomerForARbyCode($idSupp);
        $data   = array(
            'suppName'  => $get->customer_company_name,
            'suppCOA'   => $get->coa
        );
        echo json_encode($data);
    }
    function reviewARpayment($headerID){
        $headID = decode_str($headerID);
        $get    = $this->M_Fin_AR->selectHeaderARforReview($headID);
        $noReff = $get->no_facture;
        $thnPeriod  = $get->thn_periode;
        $blnPeriod  = $get->bln_periode;
        $data   = array(
            '_periode'          => date('Y-m-d', strtotime($thnPeriod.'-'.$blnPeriod.'-01')),
            '_selectCurrency'   => $this->db->get('zhl_gen_tbl_mst_currency')->result(),
            '_titleForm'        => array('head' => 'Transaction', 'desc' => 'Receivable A/R'),
            
            '_currBayar'        => $get->currency_bayar,
            '_selectHeaderAP'   => $this->M_Fin_AR->selectHeaderARforReview($headID),
            '_selectInvoiceAP'  => $this->M_Fin_AR->selectInvoiceARforReview($noReff),
            '_selectDetailAP'   => $this->M_Fin_AR->selectDetailARforReview($headID)->result(),
            '_selectDtlJrnal'   => $this->M_Fin_AR->selectDetailJurnalARforReview($headID)->result()
        );
        $this->template->display('finance/transaction/ar_trans/findAR/index-review',$data);
    }

     function print_report($noAR) {
    
        $get    = $this->M_Fin_AR->selectHeaderARforReview($noAR);
        $data   = array(
                    'HeaderAR'   => $this->M_Fin_AR->selectHeaderARforReview($noAR),
                    'DetailAP'   => $this->M_Fin_AR->selectInvoiceARforReview($noAR),
                    'DtlJrnal'   => $this->M_Fin_AR->selectDetailJurnalARforReview($noAR)         

        );
        var_dump($noAR);
         // $this->load->view('finance/report/rpt_ar/report_ar',$data);
     }
    
    // ################################################################################
    // ################################################################################
    // 
    // ########## Delete Record AR Payment ##########
    function deleteARpayment(){
        $primary    = decode_str($this->input->post('txtInputAPprimary'));
        $get        = $this->M_Fin_AR->selectHeaderARforReview($primary);
        $noReff     = $get->no_facture;
        $thnPeriod  = $get->thn_periode;
        $blnPeriod  = $get->bln_periode;
        $cur        = $get->currency_id;
        $created = $this->session->userdata('userid_1');
        $created_date = date('Y-m-d');

        $cek_reff = $this->M_Fin_CB->cek_reff('R',$thnPeriod,$cur);

        $this->M_Fin_AR->deleteDetailARaccountingFromPayment($noReff);
        $this->returnBackPiutangPerInvoiceByPass();
        $this->returnBackPiutangBulananPerInvoice($thnPeriod, $blnPeriod);
        
        // #### ========== ####
        $this->M_Fin_AR->deleteARfromCBhistory($noReff,$primary);
        $this->M_Fin_AR->deleteDetailARpayment($noReff,$primary);
        $this->M_Fin_AR->deleteDetailARjurnal($noReff,$primary);
        
        if($noReff != $cek_reff->GEN){
            $data_hdr = array('remark' => 'Cancelled',
                'updated_by' => $created,
                'updated_date' => $created_date

            );
            
            $this->M_Fin_AR->updateHeaderARpayment($primary,$data_hdr);

            $data_jur = array('Debet' => 0,
                'Kredit' => 0,
                'Debet_SGD'=>0,
                'Kredit_SGD'=>0,
                'Total'=>0,
                'keterangan' => 'Cancelled',
                'last_update_by' => $created,
                'last_update_date' => $created_date

            );

            // Delete Journal ######
            $this->M_Fin_AR->updateARfromJurnalAcc($noReff,$data_jur);
        } else {
            $this->M_Fin_AR->deleteHeaderARpayment($primary);
            $this->M_Fin_AR->deleteARfromJurnalAcc($noReff);
        }

        
        redirect('ARtrans');
    }
    function returnBackPiutangPerInvoiceByPass(){
        $idIncPerInvoice    = $this->input->post('txtNoInvoiceDtl');
        $jenis               = $this->input->post('txtjenis');
        $rowsPPI            = count($idIncPerInvoice);
        
        for($x = 0; $x < $rowsPPI; $x++):
            $this->M_Fin_AR->resetPaymentPiutang($idIncPerInvoice[$x],$jenis[$x]);
        endfor;        
    }
    function returnBackPiutangBulananPerInvoice($thnPeriod, $blnPeriod){
        $paymentPerInvoice  = str_replace(',', '', $this->input->post('txtPeymentInvoiceDtl'));
        $idIncPerInvoice    = $this->input->post('txtNoInvoiceDtl');
        $jenis              = $this->input->post('txtjenis');
        $rowsPPI            = count($paymentPerInvoice);
        
        for($x = 0; $x < $rowsPPI; $x++):
            /*$getBayar       = $this->M_CashBank->getBayarFromPiutangBulanan($idIncPerInvoice[$x],$blnPeriod,$thnPeriod);
            $data   = array(
                'bayar'         => $getBayar-$paymentPerInvoice[$x]
            );*/
            
            //$this->M_CashBank->updatepiutangBulananByNoInvoiceInOneARnumber($idIncPerInvoice[$x],$blnPeriod,$thnPeriod,$data); // Update table Hutang (ACC)
            $this->M_CashBank->updatepiutangBulananByNoInvoiceInOneARnumberQueryReturn($idIncPerInvoice[$x],$jenis[$x],$blnPeriod,$thnPeriod,$paymentPerInvoice[$x]); // Update table Hutang (ACC)
        endfor;
    }
}