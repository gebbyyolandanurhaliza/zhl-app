<?php defined('BASEPATH') OR exit('No direct script access allowed');

/* 
 * Author : ITD15
 */

class DownPaymentAP extends CI_Controller{

    public function __construct() {
        parent::__construct();

        //is_maintenance(FALSE, $this->session->userdata('userid_1'));
        
        if(!$this->session->userdata('userid_1')){
            redirect('login');
        }
        
        date_default_timezone_set("Asia/Jakarta");
        $this->load->model(array('M_Fin_Dp', 'M_Payable_recognition', 'M_CashBank'));
    }

    public function index(){
    	$data 	= array(
    		'_selectCurrency'	=> $this->db->get('zhl_gen_tbl_mst_currency')->result(),
    		'_selectMasterCOA'	=> $this->M_Fin_Dp->selectCOAforDp()->result()
    	);
    	$this->template->display('finance/transaction/ap_dp/index', $data);
    }
    function cekNumReffDeposit(){
        $value  = $this->input->post('value');
        $result = $this->M_Fin_Dp->cekDepositInJournal($value);
        if($result == TRUE){
            echo 1;
        }else{
            echo 0;
        }
    }

    function selectSupplierForDP(){
        $data   = array(
            '_selectSupplier' => $this->M_Fin_Dp->selectSupplierforDP()->result()
        );
        $this->load->view('finance/transaction/ap_dp/selectSupplier',$data);
    }

    function insertDownPayment(){
        $totalAP    = str_replace(',', '', $this->input->post('total_jr'));
        $data   = array(
            'no_reff'           => $this->input->post('txtNoReff'),
            'trans_type'        => 'PDP',
            'date1'             => date('Y-m-d', strtotime($this->input->post('txtTransDateInv'))),
            'cashbank_code'     => $this->input->post('selCBCode'),
            'check_bank'        => $this->input->post('txtChequeNumber'),
            'from_to'           => $this->input->post('txtIdVendor'),
            'trans_description' => $this->input->post('txtRemark'),
            'prepaid'           => '1',
            'suplier'           => $this->input->post('txtIdVendor'),
            'coa_suplier'       => $this->input->post('txtVendorCOA'),
            'currency_id'       => $this->input->post('selCurrency'),
            'currency_rate'     => str_replace(',', '', $this->input->post('txtRateCurr')),
            'rate_awal'         => str_replace(',', '', $this->input->post('txtRateCurr')),
            'rate_akhir'        => str_replace(',', '', $this->input->post('txtRateCurr')),
            'dp_total'          => str_replace(',', '', $this->input->post('txtTotal')),
            'dp_rate_sgd'       => str_replace(',', '', $this->input->post('txtRateCurrSGD')),
            'dp_date'           => date('Y-m-d', strtotime($this->input->post('txtTransDate'))),
            'dp_date_inv'       => date('Y-m-d', strtotime($this->input->post('txtTransDateInv'))),
            'dp_term'           => $this->input->post('txtTermDay'),
            'dp_due_date'       => date('Y-m-d', strtotime($this->input->post('txtDeuDate'))),
            'bayar_inv'         => $totalAP[1],
            'created_by'        => $this->session->userdata('userid_1'),
            'created_date'      => date('Y-m-d H:i:s')
        );
        $headerID   = $this->M_CashBank->insertCashBankHeader($data);

        $jenisJurnal    = $this->input->post('JenisJurnal');
        $description    = $this->input->post('desc');
        $dc             = $this->input->post('dk');
        $no_coa         = $this->input->post('no_coa');
        $total          = str_replace(',', '', $this->input->post('total_jr'));
        $txtdebit          = str_replace(',', '', $this->input->post('debt_jr'));
        $txtcredit         = str_replace(',', '', $this->input->post('credit_jr'));
        $period         = $this->M_Fin_Dp->getPeriodInDP();

        for($i = 0; $i < count($jenisJurnal); $i++):
            $detail = array(
                'header_id'         => $headerID,
                'no_reff'           => $this->input->post('txtNoReff'),
                'coa'               => $no_coa[$i],
                'coa_description'   => $jenisJurnal[$i],
                'total_awal'        => $total[$i],
                'debit'             => $txtdebit[$i],
                'credit'            => $txtcredit[$i],
                'remark'            => $description[$i],
                //'gst_type'          => $txtGSTname[$i],
                //'gst_value'         => str_replace(',', '', $txtGSTvalue[$i]),
                //'cf_key'            => $txtCashFlow[$x],
                'created_by'        => $this->session->userdata('userid_1'),
                'created_date'      => date('Y-m-d H:i:s')
            );
            $this->M_CashBank->insertCashBankDetail($detail);

            if($txtcredit[$i] > 0){
                $jml    = 0-$txtcredit[$i];
            }else{
                $jml    = $txtdebit[$i];
            }
            $history    = array(
                'header_id'         => $headerID,
                'no_facture'        => $this->input->post('txtNoReff'),
                'trans_type'        => 'PDP',
                'date1'             => date('Y-m-d', strtotime($this->input->post('txtTransDateInv'))),
                'cb_code'           => $this->input->post('selCBCode'),
                'from_to'           => $this->input->post('txtIdVendor'),
                'trans_description' => $this->input->post('txtRemark'),
                'prepaid'           => '1',
                'supplier'          => $this->input->post('txtIdVendor'),
                'coa_supplier'      => $this->input->post('txtVendorCOA'),
                'currency_id'       => $this->input->post('selCurrency'),
                'currency_rate'     => str_replace(',', '', $this->input->post('txtRateCurr')),
                'coa_code'          => $no_coa[$i],
                'coa_description'   => $jenisJurnal[$i],
                'debit_credit'      => $dc[$i],
                'jumlah'            => $jml,
                'debit'             => $txtdebit[$i],
                'credit'            => $txtcredit[$i],
                'remark'            => $description[$i],
                //'key_cf'            => $txtCashFlow[$i],
                'created_by'        => $this->session->userdata('userid_1'),
                'created_date'      => date('Y-m-d H:i:s')
            );
            $this->M_CashBank->insertCBhistory($history);
        endfor;

        $coaHutPiu  = array('130401','130402','130403','130404','200101','200102','200103','200105');
        
        $debet=0;
        $debet_sgd=0;
        $credit=0;
        $credit_sgd=0;
        $sum_debet=0;
        $sum_credit=0;
        $sum_debet_sgd=0;
        $sum_credit_sgd=0;

        for ($x=0; $x < count($jenisJurnal); $x++) { 
            if($txtcredit[$x] <> 0){
                $dk     = 'C';
                $jml_tot    = str_replace(',', '', $total[$x]);
                $debet = '0';
                $debet_sgd = '0';
                $credit = number_format(str_replace(",", "", $txtcredit[$x]), 2, ".", "");
                $credit_sgd = number_format(str_replace(",", "", $total[$x]) * $this->input->post('txtRateCurrSGD'), 2, ".", "");
                $sum_credit +=  $credit;
                $sum_credit_sgd += $credit_sgd;
            }else{
                $dk     = 'D';
                $jml_tot    = str_replace(',', '', $total[$x]);
                $debet = number_format(str_replace(",", "", $txtdebit[$x]), 2, ".", "");
                $debet_sgd = number_format(str_replace(",", "", $total[$x]) * $this->input->post('txtRateCurrSGD'), 2, ".", "");
                $credit = '0';
                $credit_sgd = '0';
                $sum_debet += $debet;
                $sum_debet_sgd += $debet_sgd;
            }

            if ((count($jenisJurnal) - 1) == $x){
                $selisih = $sum_debet - $sum_credit;

                if ($selisih != 0) {
                    if ($dk == 'D') {
                        $debet = $debet - $selisih; 
                    } else {
                        $credit = $credit - $selisih; 
                    }
                }

                $selisih_sgd = $sum_debet_sgd - $sum_credit_sgd;

                if ($selisih_sgd != 0){
                    if ($dk == 'D') {
                        $debet_sgd = $debet_sgd - $selisih_sgd; 
                    } else {
                        $credit_sgd = $credit_sgd - $selisih_sgd; 
                    }
                }
            }

            $dataJur    = array(
                'JenisJurnalID'     => $jenisJurnal[$x],
                'NoUrut'            => $x,
                'CompanyID'         => 'PSS',
                'jenis_trans'       => 'PDP',
                'Tanggal'           => date('Y-m-d', strtotime($this->input->post('txtTransDateInv'))),
                'Periode'           => date('mY', strtotime($period)),
                'NoJurnal'          => $this->input->post('txtNoReff'),
                'chk'               => $dc[$x],
                'NoCOA'             => $no_coa[$x],
                'sub_account_id'    => $this->input->post('txtIdVendor'),
                'sub_account_type'  => (in_array($no_coa[$x], $coaHutPiu) ? 'HUT' : ' '),
                'Uraian'            => $this->input->post('txtRemark'),
                'Debet'             => round($txtdebit[$x], 2),
                'Kredit'            => round($txtcredit[$x], 2),
                'Debet_SGD'         => round($debet_sgd, 2),
                'Kredit_SGD'        => round($credit_sgd, 2),
                'Total'             => round($total[$x], 2),
                'Currency'          => $this->input->post('selCurrency'),
                'Rate'              => $this->input->post('txtRateCurr'),
                'rate_sgd'          => $this->input->post('txtRateCurrSGD'),
                'TotalAsal'         => $total[$x],
                'CurrencyAsal'      => $this->input->post('selCurrency'),
                'RateAsal'          => $this->input->post('txtRateCurr'),
                'Keterangan'        => '-',
                'created_by'        => $this->session->userdata('userid_1'),
                'created_date'      => date('Y-m-d H:i:s'),
                'ip_address'        => $_SERVER['REMOTE_ADDR']
            );

            if ($jml_tot <> 0) {
                $this->M_Fin_Dp->insertToJurnalAccFromDP($dataJur);
            }
        }

        $dataHutang    = array(
            'p_perintah'        => 'add',
            'p_nofaktur'        => $this->input->post('txtNoReff'),
            'p_company_id'      => 'PSS',
            'p_tanggal'         => date('Y-m-d', strtotime($this->input->post('txtTransDate'))),
            'p_tanggal_tempo'   => date('Y-m-d', strtotime($this->input->post('txtDeuDate'))),
            'p_tanggal_invoice' => date('Y-m-d', strtotime($this->input->post('txtTransDateInv'))),
            'p_kode_sup'        => $this->input->post('txtIdVendor'),
            'p_jenis_trans'     => 'PDP',
            'p_currency_id'     => $this->input->post('selCurrency'),
            'p_term'            => $this->input->post('txtTermDay'),
            'p_rate'            => $this->input->post('txtRateCurr'),
            'p_rate_sgd'        => $this->input->post('txtRateCurrSGD'),
            'p_pajak'           => '0',
            'p_diskon'          => '0',
            'p_biaya_lain'      => '0',
            'p_uang_muka'       => '0',
            'p_hutang'          => -floatval(str_replace(',', '', $this->input->post('total_jr')[1])),
            'p_status'          => '1',
            'p_created_by'      => $this->session->userdata('userid_1'),
            'p_ip_address'      => $_SERVER['REMOTE_ADDR'],
            'p_nocoa'           => $this->input->post('txtVendorCOA'),
            'p_status_dp'       => '1',
        );
        $this->M_Payable_recognition->call_sp_rec_hutang($dataHutang);
        
        redirect(site_url('DownPaymentAP/reviewDepositAP/' . encode_str($headerID)));
    }

    //========== Review ==========
    function selectDepositAP(){
        $data   = array(
            '_selectHeader' => $this->M_Fin_Dp->selectDepositAPforFind()
        );
        $this->load->view('finance/transaction/ap_dp/find_dp/selectDeposit',$data);
    }

    function reviewDepositAP($headerID){
        $headID = decode_str($headerID);
        $jumDtl = $this->M_Fin_Dp->selectDetailDepositAP($headID)->num_rows();
        $data   = array(
            '_selectCurrency'   => $this->db->get('zhl_gen_tbl_mst_currency')->result(),
            '_selectMasterCOA'  => $this->M_Fin_Dp->selectCOAforDp()->result(),

            '_selectHeader'     => $this->M_Fin_Dp->selectHeaderDepositAP($headID),
            '_selectDetail'     => $this->M_Fin_Dp->selectDetailDepositAP($headID)->result(),
            '_jumDetail'        => $jumDtl
        );
        $this->template->display('finance/transaction/ap_dp/find_dp/index-review', $data);
    }

    //========== Update ==========
    function updateDepositAP(){
        $headerID   = decode_str($this->input->post('txtHeaderID'));
        $noInv      = $this->input->post('txtNoReff');

        $this->M_Fin_Dp->deleteHutang($noInv);
        $this->M_Fin_Dp->deleteHutangBulanan($noInv);
        $this->M_Fin_Dp->deleteJurnal($noInv);
        $this->M_Fin_Dp->deleteHistory($headerID,$noInv);
        $this->M_Fin_Dp->deleteBankDetail($headerID);
        /* ================================================================== */
        $data   = array(
            'no_reff'           => $this->input->post('txtNoReff'),
            'trans_type'        => 'PDP',
            'date1'             => date('Y-m-d', strtotime($this->input->post('txtTransDateInv'))),
            'cashbank_code'     => $this->input->post('selCBCode'),
            'check_bank'        => $this->input->post('txtChequeNumber'),
            'from_to'           => $this->input->post('txtIdVendor'),
            'trans_description' => $this->input->post('txtRemark'),
            'prepaid'           => '1',
            'suplier'           => $this->input->post('txtIdVendor'),
            'coa_suplier'       => $this->input->post('txtVendorCOA'),
            'currency_id'       => $this->input->post('selCurrency'),
            'currency_rate'     => str_replace(',', '', $this->input->post('txtRateCurr')),
            'rate_awal'         => str_replace(',', '', $this->input->post('txtRateCurr')),
            'rate_akhir'        => str_replace(',', '', $this->input->post('txtRateCurr')),
            'dp_total'          => str_replace(',', '', $this->input->post('txtTotal')),
            'dp_rate_sgd'       => str_replace(',', '', $this->input->post('txtRateCurrSGD')),
            'dp_date'           => date('Y-m-d', strtotime($this->input->post('txtTransDate'))),
            'dp_date_inv'       => date('Y-m-d', strtotime($this->input->post('txtTransDateInv'))),
            'dp_term'           => $this->input->post('txtTermDay'),
            'dp_due_date'       => date('Y-m-d', strtotime($this->input->post('txtDeuDate'))),
            'updated_by'        => $this->session->userdata('userid_1'),
            'updated_date'      => date('Y-m-d H:i:s')
        );
        $this->M_Fin_Dp->updateCashBankHeaderFromDeposit($headerID, $data);

        $jenisJurnal    = $this->input->post('JenisJurnal');
        $description    = $this->input->post('desc');
        $dc             = $this->input->post('dk');
        $no_coa         = $this->input->post('no_coa');
        $total          = str_replace(',', '', $this->input->post('total_jr'));
        $txtdebit          = str_replace(',', '', $this->input->post('debt_jr'));
        $txtcredit         = str_replace(',', '', $this->input->post('credit_jr'));
        $period         = $this->M_Fin_Dp->getPeriodInDP();

        for($i = 0; $i < count($jenisJurnal); $i++):
            $detail = array(
                'header_id'         => $headerID,
                'no_reff'           => $this->input->post('txtNoReff'),
                'coa'               => $no_coa[$i],
                'coa_description'   => $jenisJurnal[$i],
                'total_awal'        => $total[$i],
                'debit'             => $txtdebit[$i],
                'credit'            => $txtcredit[$i],
                'remark'            => $description[$i],
                //'gst_type'          => $txtGSTname[$i],
                //'gst_value'         => str_replace(',', '', $txtGSTvalue[$i]),
                //'cf_key'            => $txtCashFlow[$x],
                'created_by'        => $this->session->userdata('userid_1'),
                'created_date'      => date('Y-m-d H:i:s')
            );
            $this->M_CashBank->insertCashBankDetail($detail);

            if($txtcredit[$i] > 0){
                $jml    = 0 - $txtcredit[$i];
            }else{
                $jml    = $txtdebit[$i];
            }
            $history    = array(
                'header_id'         => $headerID,
                'no_facture'        => $this->input->post('txtNoReff'),
                'trans_type'        => 'PDP',
                'date1'             => date('Y-m-d', strtotime($this->input->post('txtTransDateInv'))),
                'cb_code'           => $this->input->post('selCBCode'),
                'from_to'           => $this->input->post('txtIdVendor'),
                'trans_description' => $this->input->post('txtRemark'),
                'prepaid'           => '1',
                'supplier'          => $this->input->post('txtIdVendor'),
                'coa_supplier'      => $this->input->post('txtVendorCOA'),
                'currency_id'       => $this->input->post('selCurrency'),
                'currency_rate'     => str_replace(',', '', $this->input->post('txtRateCurr')),
                'coa_code'          => $no_coa[$i],
                'coa_description'   => $jenisJurnal[$i],
                'debit_credit'      => $dc[$i],
                'jumlah'            => $jml,
                'debit'             => $txtdebit[$i],
                'credit'            => $txtcredit[$i],
                'remark'            => $description[$i],
                //'key_cf'            => $txtCashFlow[$i],
                'created_by'        => $this->session->userdata('userid_1'),
                'created_date'      => date('Y-m-d H:i:s')
            );
            $this->M_CashBank->insertCBhistory($history);
        endfor;

        $coaHutPiu  = array('130401','130402','130403','130404','200101','200102','200103','200105');

        $debet = 0;
        $credit =0;
        $debet_sgd =0;
        $credit_sgd =0;
        $sum_debet = 0;
        $sum_credit =0;
        $sum_debet_sgd =0;
        $sum_credit_sgd =0;

        for ($x=0; $x < count($jenisJurnal); $x++) { 
            if($txtcredit[$x] <> 0){
                $dk     = 'C';
                $jml_tot    = str_replace(',', '', $txtcredit[$x]);
                $debet = '0';
                $debet_sgd = '0';
                $credit = number_format(str_replace(",", "", $txtcredit[$x]), 2, ".", "");
                $credit_sgd = number_format(str_replace(",", "", $total[$x]) * $this->input->post('txtRateCurrSGD'), 2, ".", "");
                $sum_credit +=  $credit;
                $sum_credit_sgd += $credit_sgd;
            }else{
                $dk     = 'D';
                $jml_tot    = str_replace(',', '', $txtdebit[$x]);
                $debet = number_format(str_replace(",", "", $txtdebit[$x]), 2, ".", "");
                $debet_sgd = number_format(str_replace(",", "", $total[$x]) * $this->input->post('txtRateCurrSGD'), 2, ".", "");
                $credit = '0';
                $credit_sgd = '0';
                $sum_debet += $debet;
                $sum_debet_sgd += $debet_sgd;
            }

            if ((count($jenisJurnal) - 1) == $x){
                $selisih = $sum_debet - $sum_credit;

                if ($selisih != 0) {
                    if ($dk == 'D') {
                        $debet = $debet - $selisih; 
                    } else {
                        $credit = $credit - $selisih; 
                    }
                }

                $selisih_sgd = $sum_debet_sgd - $sum_credit_sgd;

                if ($selisih_sgd != 0){
                    if ($dk == 'D') {
                        $debet_sgd = $debet_sgd - $selisih_sgd; 
                    } else {
                        $credit_sgd = $credit_sgd - $selisih_sgd; 
                    }
                }
            }

            $dataJur    = array(
                'JenisJurnalID'     => $jenisJurnal[$x],
                'NoUrut'            => $x,
                'CompanyID'         => 'PSS',
                'jenis_trans'       => 'PDP',
                'Tanggal'           => date('Y-m-d', strtotime($this->input->post('txtTransDateInv'))),
                'Periode'           => date('mY', strtotime($period)),
                'NoJurnal'          => $this->input->post('txtNoReff'),
                'chk'               => $dc[$x],
                'NoCOA'             => $no_coa[$x],
                'sub_account_id'    => $this->input->post('txtIdVendor'),
                'sub_account_type'  => (in_array($no_coa[$x], $coaHutPiu) ? 'HUT' : ' '),
                'Uraian'            => $this->input->post('txtRemark'),
                'Debet'             => round($txtdebit[$x],2),
                'Kredit'            => round($txtcredit[$x],2),
                'Debet_SGD'         => round($debet_sgd, 2),
                'Kredit_SGD'        => round($credit_sgd, 2),
                'Total'             => round($total[$x],2),
                'Currency'          => $this->input->post('selCurrency'),
                'Rate'              => $this->input->post('txtRateCurr'),
                'rate_sgd'          => $this->input->post('txtRateCurrSGD'),
                'TotalAsal'         => $total[$x],
                'CurrencyAsal'      => $this->input->post('selCurrency'),
                'RateAsal'          => $this->input->post('txtRateCurr'),
                'Keterangan'        => '-',
                'created_by'        => $this->session->userdata('userid_1'),
                'created_date'      => date('Y-m-d H:i:s'),
                'ip_address'        => $_SERVER['REMOTE_ADDR']
            );

            if ($jml_tot <> 0) {
                $this->M_Fin_Dp->insertToJurnalAccFromDP($dataJur);
            }
        }

        $dataHutang    = array(
            'p_perintah'        => 'add',
            'p_nofaktur'        => $this->input->post('txtNoReff'),
            'p_company_id'      => 'PSS',
            'p_tanggal'         => date('Y-m-d', strtotime($this->input->post('txtTransDate'))),
            'p_tanggal_tempo'   => date('Y-m-d', strtotime($this->input->post('txtDeuDate'))),
            'p_tanggal_invoice' => date('Y-m-d', strtotime($this->input->post('txtTransDateInv'))),
            'p_kode_sup'        => $this->input->post('txtIdVendor'),
            'p_jenis_trans'     => 'PDP',
            'p_currency_id'     => $this->input->post('selCurrency'),
            'p_term'            => $this->input->post('txtTermDay'),
            'p_rate'            => $this->input->post('txtRateCurr'),
            'p_rate_sgd'        => $this->input->post('txtRateCurrSGD'),
            'p_pajak'           => '0',
            'p_diskon'          => '0',
            'p_biaya_lain'      => '0',
            'p_uang_muka'       => '0',
            'p_hutang'          => -floatval(str_replace(',', '', $this->input->post('total_jr')[1])),
            'p_status'          => '1',
            'p_created_by'      => $this->session->userdata('userid_1'),
            'p_ip_address'      => $_SERVER['REMOTE_ADDR'],
            'p_nocoa'           => $this->input->post('txtVendorCOA'),
            'p_status_dp'       => '1',
        );
        $this->M_Payable_recognition->call_sp_rec_hutang($dataHutang);
        
        redirect(site_url('DownPaymentAP/reviewDepositAP/' . encode_str($headerID)));
    }

    //========== Delete ==========//
    function deleteDepositAP(){
        $primary    = decode_str($this->input->post('txtHeaderID'));
        $noInv      = $this->input->post('txtNoReff');

        $this->M_Fin_Dp->deleteHutang($noInv);
        $this->M_Fin_Dp->deleteHutangBulanan($noInv);
        $this->M_Fin_Dp->deleteHistory($primary,$noInv);
        $this->M_Fin_Dp->deleteBankDetail($primary);

        $data_hdr = array('trans_description' => 'Cancelled',
            'dp_total'=>0,
            'updated_by' => $created,
            'updated_date' => $created_date

        );

        $this->M_Fin_Dp->updateBank($primary,$data_hdr);

        $data_jur = array('Debet' => 0,
            'Kredit' => 0,
            'Debet_SGD'=>0,
            'Kredit_SGD'=>0,
            'Total'=>0,
            'keterangan' => 'Cancelled',
            'last_update_by' => $created,
            'last_update_date' => $created_date

        );

        $this->M_Fin_Dp->updateJurnalAP($noInv,$data_jur);

        redirect(site_url('DownPaymentAP/index'));
    }

    function selectCOA(){
        $data   = array(
            '_getMasterCOA' => $this->M_Fin_Dp->selectCOAforARDP()->result()
        );
        $this->load->view('finance/transaction/ap_dp/selectMCOA',$data);
    }
}