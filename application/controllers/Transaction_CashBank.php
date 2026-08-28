<?php defined('BASEPATH') OR exit('No direct script access allowed');

/* 
 * Author : ITD15
 */

class Transaction_CashBank extends CI_Controller{
    public function __construct() {
        parent::__construct();
        
        if(!$this->session->userdata('userid_1')){
            redirect('login');
        }
        
        date_default_timezone_set("Asia/Jakarta");
        $this->load->model(array('M_CashBank'));
    }
    
    // ###################### ===== Start Transaction Cash Bank Controller ===== ######################
    function index(){
        $data['_selectMasterCOA']   = $this->M_CashBank->selectMasterCOA()->result();
        $data['_selectIOtype']      = $this->M_CashBank->selectIOtype();
        $data['_selectCurrency']    = $this->db->get('gen_tbl_mst_currency')->result();
        $this->template->display('finance/transaction/cash_bank',$data);
    }
    function getSupplier(){
        $keyword    = $this->input->post('keyword');
        $data       = $this->M_CashBank->selectSupplier($keyword);        
        echo json_encode($data);
    }
    function getSupplierAgain(){
        $idSupp = $this->input->post('idSupp');
        $data   = $this->M_CashBank->getSupplier($idSupp);
        echo json_encode($data);
    }
    function getCustomer(){
        $keyword    = $this->input->post('keyword');
        //$keyword    = '';
        $data       = $this->M_CashBank->selectCustomer($keyword);        
        echo json_encode($data);
    }
    function getCustomerAgain(){
        $idCust = $this->input->post('idCust');
        $data   = $this->M_CashBank->getCustomer($idCust);
        echo json_encode($data);
    }
    function getRateByCurrency(){
        $keyword    = $this->input->post('keyword');
        $get    = $this->M_CashBank->getRateByCurrecry($keyword);
        echo $get;
    }
    function cekNumReff(){
        $value  = $this->input->post('value');
        $this->db->where('no_reff', $value);
        $get    = $this->db->get('fin_tbltrn_cashbank_journal_header');
        if($get->num_rows() > 0){
            echo 1;
        }else{
            echo 0;
        }
    }
    // do action ===============================================================
    function sendCashBank(){
        $prepaid    = $this->input->post('selPrepaid');
        if($prepaid == 1){
            $supp   = $this->input->post('txtSup');
            $suppCOA= $this->input->post('txtSupCOA');
        }else{
            $supp   = NULL;
            $suppCOA= NULL;
        }
        $data   = array(
            'no_reff'           => $this->input->post('txtNoReff'),
            'trans_type'        => substr($this->input->post('txtIO'), 5, 1),
            'date1'             => $this->input->post('txtDate1'),
            'date2'             => $this->input->post('txtDate2'),
            'cashbank_code'     => $this->input->post('selCBCode'),
            'from_to'           => $this->input->post('txtFromTo'),
            'trans_description' => $this->input->post('txtDescription'),
            'prepaid'           => $prepaid,
            'suplier'           => $supp,
            'coa_suplier'       => $suppCOA,
            'currency_id'       => $this->input->post('txtCurr'),
            'currency_rate'     => $this->input->post('txtRateCurr'),
            'rate_awal'         => NULL,
            'rate_akhir'        => NULL,
            'created_by'        => $this->session->userdata('userid_1'),
            'created_date'      => date('Y-m-d H:i:s')
        );
        $headerID   = $this->M_CashBank->insertCashBankHeader($data);
        
        
        $txtNoCOA       = $this->input->post("txtNoCOA");
        $txtNameCOA     = $this->input->post('txtNameCOA');
        $txtDebit       = $this->input->post('txtDebit');
        $txtCredit      = $this->input->post('txtCredit');
        $txtRemark      = $this->input->post('txtRemark');
        $txtCashFlow	= $this->input->post('txtCashFlowKey');
        for($x = 0; $x < count($txtNoCOA); $x++):
            $detail = array(
                'header_id'         => $headerID,
                'no_reff'           => $this->input->post('txtNoReff'),
                'coa'               => $txtNoCOA[$x],
                'coa_description'   => $txtNameCOA[$x],
                'debit'             => $txtDebit[$x],
                'credit'            => $txtCredit[$x],
                'remark'            => $txtRemark[$x],
                'cf_key'            => $txtCashFlow[$x],
                'created_by'        => $this->session->userdata('userid_1'),
                'created_date'      => date('Y-m-d H:i:s')
            );
            $this->M_CashBank->insertCashBankDetail($detail);
        endfor;
        
        // insert to history ==================================================
        for($i = 0; $i < count($txtNoCOA); $i++):
            if($txtCredit[$i] > 0){
                $dk     = 'C';
                $jml    = 0-$txtCredit[$i];
            }else{
                $dk     = 'D';
                $jml    = $txtDebit[$i];
            }
            $history    = array(
                'header_id'         => $headerID,
                'no_facture'        => $this->input->post('txtNoReff'),
                'trans_type'        => substr($this->input->post('txtIO'), 5, 1),
                'date1'             => $this->input->post('txtDate1'),
                'date2'             => $this->input->post('txtDate2'),
                'cb_code'           => $this->input->post('selCBCode'),
                'from_to'           => $this->input->post('txtFromTo'),
                'trans_description' => $this->input->post('txtDescription'),
                'prepaid'           => $prepaid,
                'supplier'          => $supp,
                'coa_supplier'      => $suppCOA,
                'currency_id'       => $this->input->post('txtCurr'),
                'currency_rate'     => $this->input->post('txtRateCurr'),
                'coa_code'          => $txtNoCOA[$i],
                'coa_description'   => $txtNameCOA[$i],
                'debit_credit'      => $dk,
                'jumlah'            => $jml,
                'debit'             => $txtDebit[$i],
                'credit'            => $txtCredit[$i],
                'remark'            => $txtRemark[$i],
                'key_cf'            => $txtCashFlow[$i],
                'created_by'        => $this->session->userdata('userid_1'),
                'created_date'      => date('Y-m-d H:i:s')
            );
            $this->M_CashBank->insertCBhistory($history);
        endfor;
        
        // insert jurnal accounting ============================================
        $period = $this->M_CashBank->getPeriod();
        for($y = 0; $y < count($txtNoCOA); $y++):
            if($txtCredit[$y] > 0){
                $dk     = 'C';
                $jml    = 0-$txtCredit[$y];
            }else{
                $dk     = 'D';
                $jml    = $txtDebit[$y];
            }
            $dataJurnal = array(
                'JenisJurnalID'     => $txtRemark[$y],
                'jenis_trans'       => $this->input->post('txtIO'),
                'CompanyID'         => 'PSS',
                'Tanggal'           => $this->input->post('txtDate1'),
                'NoJurnal'          => $this->input->post('txtNoReff'),
                'Periode'           => date('Y/m', strtotime($period)),
                'NoCOA'             => $txtNoCOA[$y],
                'sub_account_type'  => 'CB',
                'sub_account_id'    => $supp,
                'Uraian'            => $txtRemark[$y],
                'Debet'             => $txtDebit[$y],
                'Kredit'            => $txtCredit[$y],
                'chk'               => $dk,
                'Total'             => $jml,
                'Currency'          => $this->input->post('txtCurr'),
                'Rate'              => $this->input->post('txtRateCurr'),
                'Keterangan'        => $this->input->post('txtDescription'),
                'created_by'        => $this->session->userdata('userid_1'),
                'created_date'      => date('Y-m-d H:i:s')
            );

            $this->M_CashBank->insertToJurnalAcc($dataJurnal);
        endfor;
        
        redirect(site_url('Transaction_CashBank'));
    }
    
    function ajaxFirstRowDetail($key){
        $reff                   = $this->M_CashBank->cekIOtype(strtoupper($this->input->post('noReff')));
        $data['_getNoReff']     = $reff;
        $data['_getMasterCOA']  = $this->M_CashBank->getMasterCOAWhere($key)->result();
        $this->load->view('finance/transaction/loadFirstRowDetail',$data);
    }
    function AjaxGetMasterCOA(){
        $reff   = $this->uri->segment(4);
        $reff3  = $this->uri->segment(3);
        if($reff == ''){
            $key    = '';
            $rr     = $reff3;
        }else{
            $key    = $this->uri->segment(3);
            $rr     = $reff;
        }
        $data['_getNoReff']     = $this->M_CashBank->cekIOtype($rr);
        $data['_getMasterCOA']  = $this->M_CashBank->getMasterCOA($key)->result();
        $this->load->view('finance/transaction/ajax_masterCOA',$data);
    }
    function AjaxGetMasterCF(){
        $key    = str_replace('%20', ' ', $this->uri->segment(3));
        $data   = array(
            '_Controller'       => $this,
            '_key'              => $key,
            '_getMasterCFRLZ'   => $this->M_CashBank->getMasterCFRLZ($key)->result()
        );
        $this->load->view('finance/transaction/ajax_masterCFRLZ',$data);
    }
    function lastLevelCF($id){
        $this->db->where('cf_header', $id);
        $get    = $this->db->get('fin_tblmst_cash_flow');
        if($get->num_rows() > 0 ){
            return FALSE;
        }
        return TRUE;
    }
    // ###################### ===== End Transaction Cash Bank Controller ===== ######################
    // 
    // ###################### ===== Start Transaction Cash Pending Controller ===== ######################
    function PendingCash(){
        //is_maintenance(TRUE, $this->session->userdata('userid_1'));

        $data['_selectPendCash']    = $this->M_CashBank->selectPendingCash()->result();
        $data['_selectMasterCOA']   = $this->M_CashBank->selectMasterCOA()->result();
        $data['_selectCurrency']    = $this->db->get('gen_tbl_mst_currency')->result();
        $data['_selectOffTravel']   = $this->db->get('fin_tblmst_official_travel')->result();
        $data['_selectUsedFor']     = $this->db->get('fin_tblmst_used_for')->result();
        $this->template->display('finance/transaction/pc/pending_cash',$data);
    }
    function getPendingCash(){
        $get    = $this->M_CashBank->selectPendingCash()->result_array();
        echo '{"data":'.json_encode($get).', "data2": '.json_encode($get).'}';
    }
    function cekNumReffPC(){
        $value  = $this->input->post('value');
        $this->db->where('no_reff', $value);
        $get    = $this->db->get('fin_tbltrn_pending_cash');
        if($get->num_rows() > 0){
            echo 1;
        }else{
            echo 0;
        }
    }
    function insertPendingCash(){
        $data   = array(
            'no_reff'           => $this->input->post('txtNumReff'),
            'trans_date'        => $this->input->post('txtTransDate'),
            'cb_code'           => $this->input->post('selCashBank'),
            'term'              => $this->input->post('txtTermDay'),
            'received_name'     => $this->input->post('txtReceiver'),
            'due_date'          => $this->input->post('txtDeuDate'),
            'currency_id'       => $this->input->post('txtCurr'),
            'currency_rate'     => $this->input->post('txtRate'),
            'departemen'        => $this->input->post('txtDept'),
            'amount'            => $this->input->post('txtAmount'),
            'used_for'          => $this->input->post('selUsedFor'),
            'official_travel'   => $this->input->post('selOffTravel'),
            'approval'          => $this->session->userdata('userid_1'),
            'description'       => $this->input->post('txtDescription'),
            'journal_reff_no'   => $this->input->post('txtJournalReff'),
            'journal_date'      => $this->input->post('txtJournalDate'),
            'created_by'        => $this->session->userdata('userid_1'),
            'created_date'      => date('Y-m-d H:i:s')
        );
        $this->M_CashBank->insertPendingCash($data);
        
        redirect(site_url('Transaction_CashBank/PendingCash/'));
    }
    // ###################### ===== End Transaction Cash Pending Controller ===== ######################
    // 
    // ###################### ===== Start Transaction AP Controller ===== ######################
    function PaymentAP(){
        $data['_periode']           = $this->M_CashBank->getPeriod();
        $data['_selectCurrency']    = $this->db->get('gen_tbl_mst_currency')->result();
        $data['_titleForm']     = array('head' => 'Transaction', 'desc' => 'Payment A/P');
        $data['_actionFrom']    = '/insertAPpayment';
        $this->template->display('finance/transaction/ap/paymentAP',$data);
    }
    function getJournalTransactionAP(){
        //$keyword    = '';
        $keyword    = $this->input->post('keyword');
        $data       = $this->M_CashBank->getJurnalNumCode($keyword);        
        echo json_encode($data);
    }
    function ajaxGetJournalTransactionAP(){
        $noUrut     = $this->M_CashBank->getNoFactureInFin('S-AP');
        $idFactur   = $this->input->post('noAP');
        $noAP       = str_pad( $noUrut+1, 4, "0", STR_PAD_LEFT ).'/S-AP/'.date('mY');
        $getCur     = $this->M_CashBank->getUtangByCode($idFactur);
        $cur        = $getCur->CurrencyID;
        $rateSGD    = $this->M_CashBank->getRateSGD($cur);
        $data   = array(
            '_setNoAP'          => $noAP,
            '_getFaktur'        => $this->M_CashBank->getUtangByCode($idFactur),
            '_getTotal'         => $this->M_CashBank->countTotalAP($idFactur),
            '_getRateSGD'       => $rateSGD,
            '_selectCurrency'   => $this->db->get('gen_tbl_mst_currency')->result()
        );
        $this->load->view('finance/transaction/ap/paymentAP-ajaxAP',$data);
    }
    function ajaxSetTableTransactionAP(){
        $idFactur   = $this->input->post('noAP');
        $getCur     = $this->M_CashBank->getUtangByCode($idFactur);
        $cur        = $getCur->CurrencyID;
        $supp       = $getCur->SupplierID;
        $rateSGD    = $this->M_CashBank->getRateSGD($cur);
        $getCOAsupp = $this->M_CashBank->getSupplierCOA($supp);
        $data   = array(
            '_getTotal'         => $this->M_CashBank->countTotalAP($idFactur),
            '_getRateSGD'       => $rateSGD,
            '_getFaktur'        => $this->M_CashBank->getUtangByCode($idFactur),
            '_selectCurrency'   => $this->db->get('gen_tbl_mst_currency')->result(),
            '_getCOAsupp'       => $getCOAsupp
        );
        $this->load->view('finance/transaction/ap/paymentAP-ajaxAPtable',$data);
    }
    function ajaxSetTableTransactionAProw(){
        $idCOA  = $this->input->post('noCOA');
        $data   = array(
            '_totalAmount'  => $this->input->post('total'),
            '_selectCurrency'   => $this->db->get('gen_tbl_mst_currency')->result(),
            '_getMasterCOA' => $this->M_CashBank->getMasterCOAWhere($idCOA)->row()
        );
        $this->load->view('finance/transaction/ap/paymentAP-ajaxAPtableRowCB',$data);
    }
    function ajaxSetAPFormCurrency(){
        $idCUR  = $this->input->post('curID');
        $data   = array(
            '_selected'         => $idCUR,
            '_selectCurrency'   => $this->db->get('gen_tbl_mst_currency')->result(),
            '_getKurs'          => $this->M_CashBank->getKursAccById($idCUR)->row()
        );
        $this->load->view('finance/transaction/ap/paymentAP-ajaxCur',$data);
    }
    // == review
    function reviewPaymentAP($headerid){
        $data   = array(
            '_periode'          => $this->M_CashBank->getPeriod(),
            '_selectCurrency'   => $this->db->get('gen_tbl_mst_currency')->result(),
            '_titleForm'        => array('head' => 'Review', 'desc' => 'Payment A/P'),
            '_getHeader'        => $this->M_CashBank->getAPheaderByHeaderID($headerid),
            '_getDetail'        => $this->M_CashBank->getAPdetailByHeaderID($headerid)
        );
        $this->template->display('finance/transaction/ap/review/index',$data);
    }
    // == do action
    function insertAPpayment(){
        $dataHdr    = array(
            'no_facture'    => $this->input->post('txtFacture'),
            'trans_date'    => $this->input->post('txtTransDate'),
            'trans_type'    => 'AP',
            'no_voucher'    => $this->input->post('txtVoucher'),
            'code_cashbank' => $this->input->post('txtCashBankCode'),
            'currency_id'   => $this->input->post('selCurrencyVoucher'),
            'currency_rate' => $this->input->post('txtRateVoucher'),
            'rate_nego'     => $this->input->post('txtRateNego'),
            'rate_equi'     => 0,
            'currency_bayar'=> $this->input->post('txtCurrBayar'),
            'remark'        => $this->input->post('txtSuplierRemark'),
            'created_by'    => $this->session->userdata('userid_1'),
            'created_date'  => date('Y-m-d H:i:s')
        );
        
        $headerID   = $this->M_CashBank->insertHeaderAPpayment($dataHdr);
        
        $remarkDtl  = $this->input->post('txtRemarkDetail');
        $currIDDtl  = $this->input->post('txtCurrDetail');
        $amountDtl  = str_replace(',', '', $this->input->post('txtTotalDetal'));
        $equiDtl    = str_replace(',', '', $this->input->post('txtEquiDetail'));
        $coaDtl     = $this->input->post('txtCOADetail');
        $cfDtl      = $this->input->post('txtCFKeyDetail');
        $dtlRow     = count($remarkDtl);
        $suppID     = $this->input->post('txtSuplierID');
        $suppCOA    = $this->M_CashBank->getSupplierCOA($suppID);
        
        for($x =0 ; $x < $dtlRow; $x++):
            $idCurrDtl  = $currIDDtl[$x];
            $rowRate    = $this->M_CashBank->getKursAccById($idCurrDtl)->row();
            $rate       = $rowRate->rate_usd;
            $dataDtl    = array(
                'header_id'     => $headerID,
                'no_facture'    => $this->input->post('txtFacture'),
                'remark'        => $remarkDtl[$x],
                'currency_id'   => $idCurrDtl,
                'rate_currency' => number_format($rate, 2),
                'amount'        => $amountDtl[$x],
                'usd_equi'      => $equiDtl[$x],
                'no_coa'        => $coaDtl[$x],
                'key_cf'        => $cfDtl[$x],
                'created_by'    => $this->session->userdata('userid_1'),
                'created_date'  => date('Y-m-d H:i:s')
            );
            
            $this->M_CashBank->insertDetailAPpayment($dataDtl);
            
            if($x == 0){
                $debit  = $amountDtl[0];
                $kredit = 0;
                $jumlah = $debit;
                $dk     = 'D';
            }elseif($x == 1){
                if($equiDtl[1] > 0){
                    $debit  = $equiDtl[1];
                    $kredit = 0;
                    $jumlah = $debit;
                    $dk     = 'D';
                }else{
                    $debit  = 0;
                    $kredit = $equiDtl[1];
                    $jumlah = $kredit;
                    $dk     = 'C';
                }
            }elseif($x == 2){
                $debit  = 0;
                $kredit = $amountDtl[2];
                $jumlah = 0-$kredit;
                $dk     = 'C';
            }
            $dataHistory    = array(
                'header_id'         => $headerID,
                'no_facture'        => $this->input->post('txtFacture'),
                'trans_type'        => 'AP',
                'date2'             => $this->input->post('txtTransDate'),
                'cb_code'           => $coaDtl[$x],
                'no_voucher'        => $this->input->post('txtVoucher'),
                'from_to'           => 0,
                'trans_description' => $this->input->post('txtSuplierRemark'),
                'supplier'          => $this->input->post('txtSuplierID'),
                'coa_supplier'      => $suppCOA,
                'currency_id'       => $idCurrDtl,
                'currency_rate'     => number_format($rate, 2),
                'coa_code'          => $coaDtl[$x],
                'coa_description'   => 0,
                'debit_credit'      => $dk,
                'jumlah'            => $jumlah,
                'debit'             => $debit,
                'credit'            => $kredit,
                'remark'            => $this->input->post('txtSuplierRemark'),
                'key_cf'            => $cfDtl[$x],
                'created_by'        => $this->session->userdata('userid_1'),
                'created_date'      => date('Y-m-d H:i:s')
            );
            
            $this->M_CashBank->insertCBhistory($dataHistory);
        endfor;
        // == update hutang == 
        $this->updateHutangPerInvoice($this->input->post('txtVoucher'));
        $this->updateHutangBulananPerInvoice($this->input->post('txtVoucher'));
        
        // == insert to jurnal ==
        $period = $this->M_CashBank->getPeriod();
        for($y = 0; $y < $dtlRow; $y++):
            $idCurrDtl  = $currIDDtl[$y];
            $rowRate    = $this->M_CashBank->getKursAccById($idCurrDtl)->row();
            $rate       = $rowRate->rate_usd;
            
            if($y == 0){
                $debit  = $amountDtl[0];
                $kredit = 0;
                $jumlah = $debit;
                $dk     = 'D';
            }elseif($y == 1){
                if($equiDtl[1] > 0){
                    $debit  = $equiDtl[1];
                    $kredit = 0;
                    $jumlah = $debit;
                    $dk     = 'D';
                }else{
                    $debit  = 0;
                    $kredit = $equiDtl[1];
                    $jumlah = $kredit;
                    $dk     = 'C';
                }
            }elseif($y == 2){
                $debit  = 0;
                $kredit = $amountDtl[2];
                $jumlah = 0-$kredit;
                $dk     = 'C';
            }
            
            $dataJurnal = array(
                'JenisJurnalID'     => $remarkDtl[$y],
                'jenis_trans'       => 'AP',
                'CompanyID'         => 'PSS',
                'Tanggal'           => $this->input->post('txtTransDate'),
                'NoJurnal'          => $this->input->post('txtFacture'),
                'NoJurnalDtl'       => $this->input->post('txtVoucher'),
                'Periode'           => date('m/Y', strtotime($period)),
                'NoCOA'             => $coaDtl[$y],
                'sub_account_type'  => 'utang',
                'sub_account_id'    => $this->input->post('txtSuplierID'),
                'Uraian'            => $remarkDtl[$y],
                'Debet'             => $debit,
                'Kredit'            => $kredit,
                'chk'               => $dk,
                'Total'             => $jumlah,
                'Currency'          => $currIDDtl[$y],
                'Rate'              => number_format($rate, 2),
                'Keterangan'        => $this->input->post('txtSuplierRemark'),
                'created_by'        => $this->session->userdata('userid_1'),
                'created_date'      => date('Y-m-d H:i:s')
            );
            
            $this->M_CashBank->insertToJurnalAcc($dataJurnal);
        endfor;
        
        redirect('Transaction_CashBank/PaymentAP');
    }
    function updateHutangPerInvoice($idVoucher){
        $getInvoice = $this->M_CashBank->getInvoiceByAPnumber($idVoucher);
        $countGet   = count($getInvoice);
        
        for($x = 0; $x < $countGet; $x++):
            $decode     = json_decode(json_encode($getInvoice[$x],TRUE));
            $noInvoice  = $decode->NoInvoice;
            
            $getTotalInAP   = $this->M_CashBank->getTotalFromAPAcc($noInvoice,$idVoucher);
            
            $getBayar       = $this->M_CashBank->getBayarFromUtang($noInvoice);
            $getSaldoHutang = $this->M_CashBank->getHutangFromUtang($noInvoice);
            $data   = array(
                'bayar'         => $getBayar+$getTotalInAP,
                'saldo_hutang'  => $getSaldoHutang-$getTotalInAP
            );
                
            $this->M_CashBank->updateUtangByNoInvoiceInOneAPnumber($noInvoice, $data); // Update table Hutang (ACC)
            $this->M_CashBank->updateRealisasiInAPdetail($idVoucher,$noInvoice); // Update table AP Detail (ACC)
        endfor;
    }
    function updateHutangBulananPerInvoice($idVoucher){
        $getInvoice = $this->M_CashBank->getInvoiceByAPnumber($idVoucher);
        $countGet   = count($getInvoice);
        
        $periode    = $this->M_CashBank->getPeriod();
        $thnPeriod  = date('Y', strtotime($periode));
        $blnPeriod  = date('m', strtotime($periode));
        
        for($x = 0; $x < $countGet; $x++):
            $decode     = json_decode(json_encode($getInvoice[$x],TRUE));
            $noInvoice  = $decode->NoInvoice;
            
            $getTotalInAP   = $this->M_CashBank->getTotalFromAPAcc($noInvoice,$idVoucher);
            
            $getBayar       = $this->M_CashBank->getBayarFromUtangBulanan($noInvoice,$blnPeriod,$thnPeriod);
            $getSaldoHutang = $this->M_CashBank->getHutangFromUtangBulanan($noInvoice,$blnPeriod,$thnPeriod);
            $data   = array(
                'bayar'         => $getBayar+$getTotalInAP,
                'saldo_hutang'  => $getSaldoHutang-$getTotalInAP
            );
                
            $this->M_CashBank->updateUtangBulananByNoInvoiceInOneAPnumber($noInvoice,$blnPeriod,$thnPeriod,$data); // Update table Hutang (ACC)
        endfor;
    }
    // ###################### ===== End Transaction AP Controller ===== ######################
    //
    // ###################### ===== Start Transaction AR Controller ===== ######################
    function PaymentAR(){
        $data['_selectCurrency']    = $this->db->get('gen_tbl_mst_currency')->result();
        $data['_titleForm']     = array('head' => 'Transaction', 'desc' => 'Payment A/R');
        $data['_actionFrom']    = '/insertARpayment';
        $this->template->display('finance/transaction/ar/paymentAR',$data);
    }
    function getJournalTransactionAR(){
        //$keyword    = '';
        $keyword    = (int)$this->input->post('keyword');
        $data       = $this->M_CashBank->getJurnalNumCodeAR($keyword);        
        echo json_encode($data);
    }
    function ajaxGetJournalTransactionAR(){
        $noUrut     = $this->M_CashBank->getNoFactureInFin('I-AR');
        $idFactur   = $this->input->post('noAP');
        $noAP       = str_pad( $noUrut+1, 4, "0", STR_PAD_LEFT ).'/I-AR/'.date('mY');
        $getCur     = $this->M_CashBank->getUtangByCodeAR($idFactur);
        $cur        = $getCur->CurrencyID;
        $rateSGD    = $this->M_CashBank->getRateSGD($cur);
        $data   = array(
            '_setNoAP'          => $noAP,
            '_getFaktur'        => $this->M_CashBank->getUtangByCodeAR($idFactur),
            '_getTotal'         => $this->M_CashBank->countTotalAR($idFactur),
            '_getRateSGD'       => $rateSGD,
            '_selectCurrency'   => $this->db->get('gen_tbl_mst_currency')->result()
        );
        $this->load->view('finance/transaction/ar/paymentAR-ajaxAR',$data);
    }
    function ajaxSetTableTransactionAR(){
        $idFactur   = $this->input->post('noAP');
        $getCur     = $this->M_CashBank->getUtangByCodeAR($idFactur);
        $cur        = $getCur->CurrencyID;
        $rateSGD    = $this->M_CashBank->getRateSGD($cur);
        $data   = array(
            '_getTotal'         => $this->M_CashBank->countTotalAR($idFactur),
            '_getRateSGD'       => $rateSGD,
            '_getFaktur'        => $this->M_CashBank->getUtangByCodeAR($idFactur),
            '_selectCurrency'   => $this->db->get('gen_tbl_mst_currency')->result()
        );
        $this->load->view('finance/transaction/ar/paymentAR-ajaxARtable',$data);
    }
    // == do action
    function insertARpayment(){
        $dataHdr    = array(
            'no_facture'    => $this->input->post('txtFacture'),
            'trans_date'    => $this->input->post('txtTransDate'),
            'trans_type'    => 'AR',
            'no_voucher'    => $this->input->post('txtVoucher'),
            'code_cashbank' => $this->input->post('txtCashBankCode'),
            'currency_id'   => $this->input->post('selCurrencyVoucher'),
            'currency_rate' => $this->input->post('txtRateVoucher'),
            'rate_nego'     => $this->input->post('txtRateNego'),
            'rate_equi'     => 0,
            'currency_bayar'=> $this->input->post('txtCurrBayar'),
            'remark'        => $this->input->post('txtSuplierRemark'),
            'created_by'    => $this->session->userdata('userid_1'),
            'created_date'  => date('Y-m-d H:i:s')
        );
        
        $headerID   = $this->M_CashBank->insertHeaderAPpayment($dataHdr);
        
        $remarkDtl  = $this->input->post('txtRemarkDetail');
        $currIDDtl  = $this->input->post('txtCurrDetail');
        $amountDtl  = str_replace(',', '', $this->input->post('txtTotalDetal'));
        $equiDtl    = str_replace(',', '', $this->input->post('txtEquiDetail'));
        $coaDtl     = $this->input->post('txtCOADetail');
        $cfDtl      = $this->input->post('txtCFKeyDetail');
        $dtlRow     = count($remarkDtl);
        for($x=0; $x<$dtlRow; $x++):
            $idCurrDtl  = $currIDDtl[$x];
            $rowRate    = $this->M_CashBank->getKursAccById($idCurrDtl)->row();
            $rate       = $rowRate->rate_usd;
            $dataDtl    = array(
                'header_id'     => $headerID,
                'no_facture'    => $this->input->post('txtFacture'),
                'remark'        => $remarkDtl[$x],
                'currency_id'   => $idCurrDtl,
                'rate_currency' => $rate,
                'amount'        => $amountDtl[$x],
                'usd_equi'      => $equiDtl[$x],
                'no_coa'        => $coaDtl[$x],
                'key_cf'        => $cfDtl[$x],
                'created_by'    => $this->session->userdata('userid_1'),
                'created_date'  => date('Y-m-d H:i:s')
            );
            
            $this->M_CashBank->insertDetailAPpayment($dataDtl);
            
            if($x == 0){
                $debit  = 0;
                $kredit = $amountDtl[0];
                $jumlah = 0-$kredit;
                $dk     = 'D';
            }elseif($x == 2){
                $debit  = $amountDtl[2];
                $kredit = 0;
                $jumlah = $debit;
                $dk     = 'C';
            }
            $dataHistory    = array(
                'header_id'         => $headerID,
                'no_facture'        => $this->input->post('txtFacture'),
                'trans_type'        => 'AR',
                'date2'             => $this->input->post('txtTransDate'),
                'cb_code'           => $coaDtl[$x],
                'no_voucher'        => $this->input->post('txtVoucher'),
                'from_to'           => 0,
                'trans_description' => $this->input->post('txtSuplierRemark'),
                'supplier'          => $this->input->post('txtSuplierID'),
                'coa_supplier'      => '010000.00002029',
                'currency_id'       => $idCurrDtl,
                'currency_rate'     => $rate,
                'coa_code'          => $coaDtl[$x],
                'coa_description'   => 0,
                'debit_credit'      => $dk,
                'jumlah'            => $jumlah,
                'debit'             => $debit,
                'credit'            => $kredit,
                'remark'            => $this->input->post('txtSuplierRemark'),
                'key_cf'            => $cfDtl[$x],
                'created_by'        => $this->session->userdata('userid_1'),
                'created_date'      => date('Y-m-d H:i:s')
            );
            
            if($x == 0 || $x == 2){
                $this->M_CashBank->insertCBhistory($dataHistory);
            }
        endfor;
        // == update piutang == 
        $this->updatePiutangPerInvoice($this->input->post('txtVoucher'));
        $this->updatePiutangBulananPerInvoice($this->input->post('txtVoucher'));
        
        // == insert to jurnal ==
        $period = $this->M_CashBank->getPeriod();
        for($y = 0; $y < $dtlRow; $y++):
            $idCurrDtl  = $currIDDtl[$y];
            $rowRate    = $this->M_CashBank->getKursAccById($idCurrDtl)->row();
            $rate       = $rowRate->rate_usd;
            
            if($y == 0){
                $debit  = 0;
                $kredit = $amountDtl[0];
                $jumlah = 0-$kredit;
                $dk     = 'D';
            }elseif($y == 2){
                $debit  = $amountDtl[2];
                $kredit = 0;
                $jumlah = $debit;
                $dk     = 'C';
            }
            
            $dataJurnal = array(
                'JenisJurnalID'     => $remarkDtl[$y],
                'jenis_trans'       => 'AR',
                'CompanyID'         => 'PSS',
                'Tanggal'           => $this->input->post('txtTransDate'),
                'NoJurnal'          => $this->input->post('txtFacture'),
                'NoJurnalDtl'       => $this->input->post('txtVoucher'),
                'Periode'           => date('m/Y', strtotime($period)),
                'NoCOA'             => $coaDtl[$y],
                'sub_account_type'  => 'piutang',
                'sub_account_id'    => $this->input->post('txtSuplierID'),
                'Uraian'            => $remarkDtl[$y],
                'Debet'             => $debit,
                'Kredit'            => $kredit,
                'chk'               => $dk,
                'Total'             => $jumlah,
                'Currency'          => $currIDDtl[$y],
                'Rate'              => $rate,
                'Keterangan'        => $this->input->post('txtSuplierRemark'),
                'created_by'        => $this->session->userdata('userid_1'),
                'created_date'      => date('Y-m-d H:i:s')
            );
            
            if($y == 0 || $y == 2){
                $this->M_CashBank->insertToJurnalAcc($dataJurnal);
            }
        endfor;
        redirect('Transaction_CashBank/PaymentAR');
    }
    function updatePiutangPerInvoice($idVoucher){
        $getInvoice = $this->M_CashBank->getInvoiceByARnumber($idVoucher);
        $countGet   = count($getInvoice);
        
        for($x = 0; $x < $countGet; $x++):
            $decode     = json_decode(json_encode($getInvoice[$x],TRUE));
            $noInvoice  = $decode->NoInvoice;
            
            $getTotalInAR   = $this->M_CashBank->getTotalFromARAcc($noInvoice,$idVoucher);
            
            $getBayar       = $this->M_CashBank->getBayarFromPiutang($noInvoice);
            $data   = array(
                'bayar'         => $getBayar+$getTotalInAR
            );
                
            $this->M_CashBank->updatePiutangByNoInvoiceInOneARnumber($noInvoice, $data); // Update table Piutang (ACC)
            $this->M_CashBank->updateRealisasiInAPdetail($idVoucher,$noInvoice); // Update table AP Detail (ACC)
        endfor;
    }
    function updatePiutangBulananPerInvoice($idVoucher){
        $getInvoice = $this->M_CashBank->getInvoiceByARnumber($idVoucher);
        $countGet   = count($getInvoice);
        
        $periode    = $this->M_CashBank->getPeriod();
        $thnPeriod  = date('Y', strtotime($periode));
        $blnPeriod  = date('m', strtotime($periode));
        
        for($x = 0; $x < $countGet; $x++):
            $decode     = json_decode(json_encode($getInvoice[$x],TRUE));
            $noInvoice  = $decode->NoInvoice;
            
            $getTotalInAP   = $this->M_CashBank->getTotalFromARAcc($noInvoice,$idVoucher);
            
            $getBayar       = $this->M_CashBank->getBayarFromPiutangBulanan($noInvoice,$blnPeriod,$thnPeriod);
            $data   = array(
                'bayar'         => $getBayar+$getTotalInAP
            );
            
            $this->M_CashBank->updatepiutangBulananByNoInvoiceInOneAPnumber($noInvoice,$blnPeriod,$thnPeriod,$data); // Update table Hutang (ACC)
        endfor;
    }
    // ###################### ===== END Transaction AR Controller ===== ######################
    
    //=====================================================
    function test(){
        $test   = $this->M_CashBank->getRateByCurrecry($cur='USD');
        $get    = json_encode($test);
        $dec    = json_decode(str_replace('[', '', str_replace(']', '', $get)));
        echo $dec->rate_kurs;
    }
    
    function FPDFtest(){
        $this->load->view('finance/report/test_1');
    }
    
    function testtttttt(){
        echo $this->M_CashBank->getSupplierCOA('');
    }
}