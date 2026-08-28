<?php defined('BASEPATH') or exit('No direct script access allowed');

/* 
 * Author : ITD15
 */

class DownPaymentAR extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        //is_maintenance(FALSE, $this->session->userdata('userid_1'));

        if (!$this->session->userdata('userid_1')) {
            redirect('login');
        }

        date_default_timezone_set("Asia/Jakarta");
        $this->load->model(array('M_Fin_Dp', 'M_Receivable_recognition', 'M_CashBank'));
    }

    public function index()
    {
        $data     = array(
            '_selectCurrency'    => $this->db->get('zhl_gen_tbl_mst_currency')->result(),
            '_selectMasterCOA'    => $this->M_Fin_Dp->selectCOAforDp()->result()
        );
        $this->template->display('finance/transaction/ar_dp/index', $data);
    }

    function selectCustomerForDP()
    {
        $data   = array(
            '_selectSupplier' => $this->M_Fin_Dp->selectCustomerforDP()->result()
        );
        $this->load->view('finance/transaction/ar_dp/selectCustomer', $data);
    }

    // ++++++++++++++++ INSERT tes ++++++++++++++++
    function insertDownPayment()
    {
        $data   = array(
            'no_reff'           => $this->input->post('txtNoReff'),
            'trans_type'        => 'RDP',
            'date1'             => date('Y-m-d', strtotime($this->input->post('txtTransDateInv'))),
            'cashbank_code'     => $this->input->post('selCBCode'),
            'check_bank'        => $this->input->post('txtChequeNumber'),
            'from_to'           => $this->input->post('txtIdVendor'),
            'trans_description' => $this->input->post('txtRemark'),
            'PO'                => $this->input->post('txtPO'),
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

        for ($i = 0; $i < count($jenisJurnal); $i++) :
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

            if ($txtcredit[$i] <> 0) {
                $jml    = 0 - $txtcredit[$i];
            } else {
                $jml    = $txtdebit[$i];
            }

            $history    = array(
                'header_id'         => $headerID,
                'no_facture'        => $this->input->post('txtNoReff'),
                'trans_type'        => 'RDP',
                'date1'             => date('Y-m-d', strtotime($this->input->post('txtTransDateInv'))),
                'cb_code'           => $this->input->post('selCBCode'),
                'from_to'           => $this->input->post('txtIdVendor'),
                'trans_description' => $this->input->post('txtRemark'),
                'PO'                => $this->input->post('txtPO'),
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

        $debet = 0;
        $debet_sgd = 0;
        $credit = 0;
        $credit_sgd = 0;
        $sum_debet = 0;
        $sum_credit = 0;
        $sum_debet_sgd = 0;
        $sum_credit_sgd = 0;

        $coaHutPiu  = array('130401', '130402', '130403', '130404', '200101', '200102', '200103', '200105');
        for ($x = 0; $x < count($jenisJurnal); $x++) {
            if ($txtcredit[$x] <> 0) {
                $dk     = 'C';
                $jml_tot    = str_replace(',', '', $total[$x]);
                $debet = '0';
                $debet_sgd = '0';
                $credit = number_format(str_replace(",", "", $txtcredit[$x]), 2, ".", "");
                $credit_sgd = number_format(str_replace(",", "", $total[$x]) * $this->input->post('txtRateCurrSGD'), 2, ".", "");
                $sum_credit +=  $credit;
                $sum_credit_sgd += $credit_sgd;
            } else {
                $dk     = 'D';
                $jml_tot    = str_replace(',', '', $total[$x]);
                $debet = number_format(str_replace(",", "", $txtdebit[$x]), 2, ".", "");
                $debet_sgd = number_format(str_replace(",", "", $total[$x]) * $this->input->post('txtRateCurrSGD'), 2, ".", "");
                $credit = '0';
                $credit_sgd = '0';
                $sum_debet += $debet;
                $sum_debet_sgd += $debet_sgd;
            }

            if ((count($jenisJurnal) - 1) == $x) {
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

            $dataJur    = array(
                'JenisJurnalID'     => $jenisJurnal[$x],
                'NoUrut'            => $x,
                'CompanyID'         => 'PSS',
                'jenis_trans'       => 'RDP',
                'Tanggal'           => date('Y-m-d', strtotime($this->input->post('txtTransDateInv'))),
                'Periode'           => date('mY', strtotime($period)),
                'NoJurnal'          => $this->input->post('txtNoReff'),
                'chk'               => $dc[$x],
                'NoCOA'             => $no_coa[$x],
                'sub_account_id'    => $this->input->post('txtIdVendor'),
                'sub_account_type'  => (in_array($no_coa[$x], $coaHutPiu) ? 'PIU' : ' '),
                'Uraian'            => $this->input->post('txtRemark'),
                'Debet'             => round($debet, 2),
                'Kredit'            => round($credit, 2),
                'Debet_SGD'         => round($debet_sgd, 2),
                'Kredit_SGD'        => round($credit_sgd, 2),
                'Total'             => round($jml_tot, 2),
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

        $dataPiutang    = array(
            'p_perintah'        => 'add',
            'p_nofaktur'        => $this->input->post('txtNoReff'),
            'p_tanggal'         => date('Y-m-d', strtotime($this->input->post('txtTransDate'))),
            'p_tanggal_tempo'   => date('Y-m-d', strtotime($this->input->post('txtDeuDate'))),
            'p_tanggal_invoice' => date('Y-m-d', strtotime($this->input->post('txtTransDateInv'))),
            'p_term'            => $this->input->post('txtTermDay'),
            'p_kode_sup'        => $this->input->post('txtIdVendor'),
            'p_jenis_trans'     => 'RDP',
            'p_currency_id'     => $this->input->post('selCurrency'),
            'p_rate'            => $this->input->post('txtRateCurr'),
            'p_pajak'           => '0',
            'p_diskon'          => '0',
            'p_biaya_lain'      => '0',
            'p_uang_muka'       => '0',
            'p_piutang'         =>  0 - floatval(str_replace(',', '', $this->input->post('total_jr')[1])),
            'p_created_by'      => $this->session->userdata('userid_1'),
            'p_ip_address'      => $_SERVER['REMOTE_ADDR'],
            'p_rate_sgd'        => $this->input->post('txtRateCurrSGD'),
            'p_nocoa'           => $this->input->post('txtVendorCOA'),
            'p_status_dp'       => '1',
            'p_jenin'           => 'DP',
            'p_etadate'         => '0',
            'p_etddate'         => '0'
        );

        $this->M_Receivable_recognition->call_sp_rec_piutang($dataPiutang);

        redirect(site_url('DownPaymentAR/reviewDepositAR/' . encode_str($headerID)));
    }

    // ++++++++++++++++ REVIEW ++++++++++++++++
    function selectDepositAR()
    {
        $data   = array(
            '_selectHeader' => $this->M_Fin_Dp->selectDepositARforFind()
        );
        $this->load->view('finance/transaction/ar_dp/find_dp/selectDeposit', $data);
    }

    function reviewDepositAR($headerID)
    {
        $headID = decode_str($headerID);
        $jumDtl = $this->M_Fin_Dp->selectDetailDepositAP($headID)->num_rows();
        $data   = array(
            '_selectCurrency'   => $this->db->get('zhl_gen_tbl_mst_currency')->result(),
            '_selectMasterCOA'  => $this->M_Fin_Dp->selectCOAforDp()->result(),

            '_selectHeader'     => $this->M_Fin_Dp->selectHeaderDepositAP($headID),
            '_selectDetail'     => $this->M_Fin_Dp->selectDetailDepositAP($headID)->result(),
            '_jumDetail'        => $jumDtl
        );
        $this->template->display('finance/transaction/ar_dp/find_dp/index-review', $data);
    }

    //========== Update ==========//
    function updateDepositAR()
    {
        $headerID   = decode_str($this->input->post('txtHeaderID'));
        $noInv      = $this->input->post('txtNoReff');

        $this->M_Fin_Dp->deletePiutang($noInv);
        $this->M_Fin_Dp->deletePiutangBulanan($noInv);
        $this->M_Fin_Dp->deleteJurnalAR($noInv);
        $this->M_Fin_Dp->deleteHistory($headerID, $noInv);
        $this->M_Fin_Dp->deleteBankDetail($headerID);
        /* ================================================================== */

        $data   = array(
            'no_reff'           => $this->input->post('txtNoReff'),
            'trans_type'        => 'RDP',
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
            'created_by'        => $this->session->userdata('userid_1'),
            'created_date'      => date('Y-m-d H:i:s')
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

        for ($i = 0; $i < count($jenisJurnal); $i++) :
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

            if ($txtcredit[$i] <> 0) {
                $jml    = 0 - $txtcredit[$i];
            } else {
                $jml    = $txtdebit[$i];
            }
            $history    = array(
                'header_id'         => $headerID,
                'no_facture'        => $this->input->post('txtNoReff'),
                'trans_type'        => 'RDP',
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

        $debet = 0;
        $credit = 0;
        $debet_sgd = 0;
        $credit_sgd = 0;
        $sum_debet = 0;
        $sum_credit = 0;
        $sum_debet_sgd = 0;
        $sum_credit_sgd = 0;

        $coaHutPiu  = array('130401', '130402', '130403', '130404', '200101', '200102', '200103', '200105');
        for ($x = 0; $x < count($jenisJurnal); $x++) {
            if ($txtcredit[$x] <> 0) {
                $dk     = 'C';
                $jml_tot    = str_replace(',', '', $txtcredit[$x]);
                $debet = '0';
                $debet_sgd = '0';
                $credit = number_format(str_replace(",", "", $txtcredit[$x]), 2, ".", "");
                $credit_sgd = number_format(str_replace(",", "", $total[$x]) * $this->input->post('txtRateCurrSGD'), 2, ".", "");
                $sum_credit +=  $credit;
                $sum_credit_sgd += $credit_sgd;
            } else {
                $dk     = 'D';
                $jml_tot    = str_replace(',', '', $txtdebit[$x]);
                $debet = number_format(str_replace(",", "", $txtdebit[$x]), 2, ".", "");
                $debet_sgd = number_format(str_replace(",", "", $total[$x]) * $this->input->post('txtRateCurrSGD'), 2, ".", "");
                $credit = '0';
                $credit_sgd = '0';
                $sum_debet += $debet;
                $sum_debet_sgd += $debet_sgd;
            }

            if ((count($jenisJurnal) - 1) == $x) {
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


            $dataJur    = array(
                'JenisJurnalID'     => $jenisJurnal[$x],
                'NoUrut'            => $x,
                'CompanyID'         => 'PSS',
                'jenis_trans'       => 'RDP',
                'Tanggal'           => date('Y-m-d', strtotime($this->input->post('txtTransDateInv'))),
                'Periode'           => date('mY', strtotime($period)),
                'NoJurnal'          => $this->input->post('txtNoReff'),
                'chk'               => $dc[$x],
                'NoCOA'             => $no_coa[$x],
                'sub_account_id'    => $this->input->post('txtIdVendor'),
                'sub_account_type'  => (in_array($no_coa[$x], $coaHutPiu) ? 'PIU' : ' '),
                'Uraian'            => $description[$x],
                'Debet'             => round($debet, 2),
                'Kredit'            => round($credit, 2),
                'Debet_SGD'         => round($debet_sgd, 2),
                'Kredit_SGD'        => round($credit_sgd, 2),
                'Total'             => round($jml_tot, 2),
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

        $dataPiutang    = array(
            'p_perintah'        => 'add',
            'p_nofaktur'        => $this->input->post('txtNoReff'),
            'p_tanggal'         => date('Y-m-d', strtotime($this->input->post('txtTransDate'))),
            'p_tanggal_tempo'   => date('Y-m-d', strtotime($this->input->post('txtDeuDate'))),
            'p_tanggal_invoice' => date('Y-m-d', strtotime($this->input->post('txtTransDateInv'))),
            'p_term'            => $this->input->post('txtTermDay'),
            'p_kode_sup'        => $this->input->post('txtIdVendor'),
            'p_jenis_trans'     => 'RDP',
            'p_currency_id'     => $this->input->post('selCurrency'),
            'p_rate'            => $this->input->post('txtRateCurr'),
            'p_pajak'           => '0',
            'p_diskon'          => '0',
            'p_biaya_lain'      => '0',
            'p_uang_muka'       => '0',
            'p_piutang'         => 0 - floatval(str_replace(',', '', $this->input->post('total_jr')[1])),
            'p_created_by'      => $this->session->userdata('userid_1'),
            'p_ip_address'      => $_SERVER['REMOTE_ADDR'],
            'p_rate_sgd'        => $this->input->post('txtRateCurrSGD'),
            'p_nocoa'           => $this->input->post('txtVendorCOA'),
            'p_status_dp'       => '1'
        );

        $this->M_Receivable_recognition->call_sp_rec_piutang($dataPiutang);

        redirect(site_url('DownPaymentAR/reviewDepositAR/' . encode_str($headerID)));
    }

    //========== Delete ==========//
    function deleteDepositAR()
    {
        $primary    = decode_str($this->input->post('txtHeaderID'));
        $noInv      = $this->input->post('txtNoReff');
        $created = $this->session->userdata('userid_1');
        $created_date = date('Y-m-d');

        $this->M_Fin_Dp->deletePiutang($noInv);
        $this->M_Fin_Dp->deletePiutangBulanan($noInv);
        $this->M_Fin_Dp->deleteHistory($primary, $noInv);
        $this->M_Fin_Dp->deleteBankDetail($primary);

        $data_hdr = array(
            'trans_description' => 'Cancelled',
            'dp_total' => 0,
            'updated_by' => $created,
            'updated_date' => $created_date

        );

        $this->M_Fin_Dp->updateBank($primary, $data_hdr);

        $data_jur = array(
            'Debet' => 0,
            'Kredit' => 0,
            'Debet_SGD' => 0,
            'Kredit_SGD' => 0,
            'Total' => 0,
            'keterangan' => 'Cancelled',
            'last_update_by' => $created,
            'last_update_date' => $created_date

        );

        $this->M_Fin_Dp->updateJurnalAR($noInv, $data_jur);

        redirect(site_url('DownPaymentAR/index'));
    }

    //========== Print AP Deposit ===========
    function printViaPDF($niInv)
    {

        $data   = array(
            '_selectHeader' => $this->M_Fin_Dp->selectHeaderARforPrintPDF(decode_str($niInv))->row()
        );
        $this->load->view('finance/report/rpt_rdp/receive_inv', $data);
    }

    //#######################################################################################################################//

    function insertJustInvoiceARdeposit()
    {
        $data   = array(
            'no_reff'           => $this->input->post('txtNoReff'),
            'trans_type'        => 'I',
            'date1'             => date('Y-m-d', strtotime($this->input->post('txtTransDateInv'))),
            'from_to'           => $this->input->post('txtIdVendor'),
            'trans_description' => $this->input->post('txtRemark'),
            'prepaid'           => '5',
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
            'created_by'        => $this->session->userdata('userid_1'),
            'created_date'      => date('Y-m-d H:i:s')
        );
        $headerID   = $this->M_CashBank->insertCashBankHeader($data);

        $jenisJurnal    = $this->input->post('dp_JenisJurnal');
        $description    = $this->input->post('dp_desc');
        $dc             = $this->input->post('dp_dk');
        $no_coa         = $this->input->post('dp_no_coa');
        $total          = str_replace(',', '', $this->input->post('dp_total_jr'));
        $txtdebit          = str_replace(',', '', $this->input->post('dp_debt_jr'));
        $txtcredit         = str_replace(',', '', $this->input->post('dp_credit_jr'));
        $period         = $this->M_Fin_Dp->getPeriodInDP();

        for ($i = 0; $i < count($jenisJurnal); $i++) :
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

            if ($txtcredit[$i] <> 0) {
                $jml    = 0 - $txtcredit[$i];
            } else {
                $jml    = $txtdebit[$i];
            }
            $history    = array(
                'header_id'         => $headerID,
                'no_facture'        => $this->input->post('txtNoReff'),
                'trans_type'        => 'I',
                'date1'             => date('Y-m-d', strtotime($this->input->post('txtTransDateInv'))),
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

        $debet = 0;
        $credit = 0;
        $debet_sgd = 0;
        $credit_sgd = 0;
        $sum_debet = 0;
        $sum_credit = 0;
        $sum_debet_sgd = 0;
        $sum_credit_sgd = 0;

        $coaHutPiu  = array('130401', '130402', '130403', '130404', '200101', '200102', '200103', '200105');
        for ($x = 0; $x < count($jenisJurnal); $x++) {
            if ($txtcredit[$x] <> 0) {
                $dk     = 'C';
                $jml_tot    = str_replace(',', '', $total[$x]);
                $debet = '0';
                $debet_sgd = '0';
                $credit = number_format(str_replace(",", "", $txtcredit[$x]), 2, ".", "");
                $credit_sgd = number_format(str_replace(",", "", $total[$x]) * $this->input->post('txtRateCurrSGD'), 2, ".", "");
                $sum_credit +=  $credit;
                $sum_credit_sgd += $credit_sgd;
            } else {
                $dk     = 'D';
                $jml_tot    = str_replace(',', '', $total[$x]);
                $debet = number_format(str_replace(",", "", $txtdebit[$x]), 2, ".", "");
                $debet_sgd = number_format(str_replace(",", "", $total[$x]) * $this->input->post('txtRateCurrSGD'), 2, ".", "");
                $credit = '0';
                $credit_sgd = '0';
                $sum_debet += $debet;
                $sum_debet_sgd += $debet_sgd;
            }

            if ((count($jenisJurnal) - 1) == $x) {
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

            $dataJur    = array(
                'JenisJurnalID'     => $jenisJurnal[$x],
                'NoUrut'            => $x,
                'CompanyID'         => 'PSS',
                'jenis_trans'       => 'I',
                'Tanggal'           => date('Y-m-d', strtotime($this->input->post('txtTransDateInv'))),
                'Periode'           => date('mY', strtotime($period)),
                'NoJurnal'          => $this->input->post('txtNoReff'),
                'chk'               => $dc[$x],
                'NoCOA'             => $no_coa[$x],
                'sub_account_id'    => $this->input->post('txtIdVendor'),
                'sub_account_type'  => (in_array($no_coa[$x], $coaHutPiu) ? 'PIU' : ' '),
                'Uraian'            => $this->input->post('txtRemark'),
                'Debet'             => round($debet, 2),
                'Kredit'            => round($credit, 2),
                'Debet_SGD'         => round($debet_sgd, 2),
                'Kredit_SGD'        => round($credit_sgd, 2),
                'Total'             => round($jml_tot, 2),
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

        $dataPiutang    = array(
            'p_perintah'        => 'add',
            'p_nofaktur'        => $this->input->post('txtNoReff'),
            'p_tanggal'         => date('Y-m-d', strtotime($this->input->post('txtTransDate'))),
            'p_tanggal_tempo'   => date('Y-m-d', strtotime($this->input->post('txtDeuDate'))),
            'p_tanggal_invoice' => date('Y-m-d', strtotime($this->input->post('txtTransDateInv'))),
            'p_term'            => $this->input->post('txtTermDay'),
            'p_kode_sup'        => $this->input->post('txtIdVendor'),
            'p_jenis_trans'     => 'I',
            'p_currency_id'     => $this->input->post('selCurrency'),
            'p_rate'            => $this->input->post('txtRateCurr'),
            'p_pajak'           => '0',
            'p_diskon'          => '0',
            'p_biaya_lain'      => '0',
            'p_uang_muka'       => '0',
            'p_piutang'         => floatval(str_replace(',', '', $this->input->post('dp_total_jr')[1])),
            'p_created_by'      => $this->session->userdata('userid_1'),
            'p_ip_address'      => $_SERVER['REMOTE_ADDR'],
            'p_rate_sgd'        => $this->input->post('txtRateCurrSGD'),
            'p_nocoa'           => $this->input->post('txtVendorCOA'),
            'p_status_dp'       => '1'
        );

        $this->M_Receivable_recognition->call_sp_rec_piutang($dataPiutang);

        redirect(site_url('DownPaymentAR/reviewDepositARjustInvoice/' . encode_str($headerID)));
    }

    function reviewDepositARjustInvoice($headerID)
    {
        $headID = decode_str($headerID);
        $jumDtl = $this->M_Fin_Dp->selectDetailDepositAP($headID)->num_rows();

        $data   = array(
            '_selectCurrency'   => $this->db->get('zhl_gen_tbl_mst_currency')->result(),
            '_selectMasterCOA'  => $this->M_Fin_Dp->selectCOAforDp()->result(),

            '_selectHeader'     => $this->M_Fin_Dp->selectHeaderDepositInvoice($headID),
            '_selectDetail'     => $this->M_Fin_Dp->selectDetailDepositAP($headID)->result(),
            '_jumDetail'        => $jumDtl
        );
        $this->template->display('finance/transaction/ar_dp/review_dp_invoice/index_review_invoice', $data);
    }

    function updateDepositARjustInvoice()
    {
        $headerID   = decode_str($this->input->post('txtHeaderID'));
        $noInv      = $this->input->post('txtNoReff');

        $this->M_Fin_Dp->deletePiutang($noInv);
        $this->M_Fin_Dp->deletePiutangBulanan($noInv);
        $this->M_Fin_Dp->deleteJurnalARin($noInv);
        $this->M_Fin_Dp->deleteHistory($headerID, $noInv);
        $this->M_Fin_Dp->deleteBankDetail($headerID);
        /* ================================================================== */

        $data   = array(
            'no_reff'           => $this->input->post('txtNoReff'),
            'trans_type'        => 'I',
            'date1'             => date('Y-m-d', strtotime($this->input->post('txtTransDateInv'))),
            'from_to'           => $this->input->post('txtIdVendor'),
            'trans_description' => $this->input->post('txtRemark'),
            'prepaid'           => '5',
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
        $txtdebit       = str_replace(',', '', $this->input->post('debt_jr'));
        $txtcredit      = str_replace(',', '', $this->input->post('credit_jr'));
        $period         = $this->M_Fin_Dp->getPeriodInDP();

        for ($i = 0; $i < count($jenisJurnal); $i++) :
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

            if ($txtcredit[$i] <> 0) {
                $jml    = 0 - $txtcredit[$i];
            } else {
                $jml    = $txtdebit[$i];
            }

            $history    = array(
                'header_id'         => $headerID,
                'no_facture'        => $this->input->post('txtNoReff'),
                'trans_type'        => 'I',
                'date1'             => date('Y-m-d', strtotime($this->input->post('txtTransDateInv'))),
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

        $debet = 0;
        $credit = 0;
        $debet_sgd = 0;
        $credit_sgd = 0;
        $sum_debet = 0;
        $sum_credit = 0;
        $sum_debet_sgd = 0;
        $sum_credit_sgd = 0;

        $coaHutPiu  = array('130401', '130402', '130403', '130404', '200101', '200102', '200103', '200105');
        for ($x = 0; $x < count($jenisJurnal); $x++) {
            if ($txtcredit[$x] <> 0) {
                $dk     = 'C';
                $jml_tot    = str_replace(',', '', $txtcredit[$x]);
                $debet = '0';
                $debet_sgd = '0';
                $credit = number_format(str_replace(",", "", $txtcredit[$x]), 2, ".", "");
                $credit_sgd = number_format(str_replace(",", "", $total[$x]) * $this->input->post('txtRateCurrSGD'), 2, ".", "");
                $sum_credit +=  $credit;
                $sum_credit_sgd += $credit_sgd;
            } else {
                $dk     = 'D';
                $jml_tot    = str_replace(',', '', $txtdebit[$x]);
                $debet = number_format(str_replace(",", "", $txtdebit[$x]), 2, ".", "");
                $debet_sgd = number_format(str_replace(",", "", $total[$x]) * $this->input->post('txtRateCurrSGD'), 2, ".", "");
                $credit = '0';
                $credit_sgd = '0';
                $sum_debet += $debet;
                $sum_debet_sgd += $debet_sgd;
            }

            if ((count($jenisJurnal) - 1) == $x) {
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

            $dataJur    = array(
                'JenisJurnalID'     => $jenisJurnal[$x],
                'NoUrut'            => $x,
                'CompanyID'         => 'PSS',
                'jenis_trans'       => 'I',
                'Tanggal'           => date('Y-m-d', strtotime($this->input->post('txtTransDateInv'))),
                'Periode'           => date('mY', strtotime($period)),
                'NoJurnal'          => $this->input->post('txtNoReff'),
                'chk'               => $dc[$x],
                'NoCOA'             => $no_coa[$x],
                'sub_account_id'    => $this->input->post('txtIdVendor'),
                'sub_account_type'  => (in_array($no_coa[$x], $coaHutPiu) ? 'PIU' : ' '),
                'Uraian'            => $this->input->post('txtRemark'),
                'Debet'             => round($debet, 2),
                'Kredit'            => round($credit, 2),
                'Debet_SGD'         => round($debet_sgd, 2),
                'Kredit_SGD'        => round($credit_sgd, 2),
                'Total'             => round($jml_tot, 2),
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

        $dataPiutang    = array(
            'p_perintah'        => 'add',
            'p_nofaktur'        => $this->input->post('txtNoReff'),
            'p_tanggal'         => date('Y-m-d', strtotime($this->input->post('txtTransDate'))),
            'p_tanggal_tempo'   => date('Y-m-d', strtotime($this->input->post('txtDeuDate'))),
            'p_tanggal_invoice' => date('Y-m-d', strtotime($this->input->post('txtTransDateInv'))),
            'p_term'            => $this->input->post('txtTermDay'),
            'p_kode_sup'        => $this->input->post('txtIdVendor'),
            'p_jenis_trans'     => 'I',
            'p_currency_id'     => $this->input->post('selCurrency'),
            'p_rate'            => $this->input->post('txtRateCurr'),
            'p_pajak'           => '0',
            'p_diskon'          => '0',
            'p_biaya_lain'      => '0',
            'p_uang_muka'       => '0',
            'p_piutang'         => floatval(str_replace(',', '', $this->input->post('total_jr')[1])),
            'p_created_by'      => $this->session->userdata('userid_1'),
            'p_ip_address'      => $_SERVER['REMOTE_ADDR'],
            'p_rate_sgd'        => $this->input->post('txtRateCurrSGD'),
            'p_nocoa'           => $this->input->post('txtVendorCOA'),
            'p_status_dp'       => '1'
        );

        $this->M_Receivable_recognition->call_sp_rec_piutang($dataPiutang);

        redirect(site_url('DownPaymentAR/reviewDepositARjustInvoice/' . encode_str($headerID)));
    }

    function printInvoiceDeposit($headerID)
    {
        $headID = decode_str($headerID);

        $data   = array(
            '_selectCurrency'   => $this->db->get('zhl_gen_tbl_mst_currency')->result(),
            '_selectMasterCOA'  => $this->M_Fin_Dp->selectCOAforDp()->result(),
            '_selectHeader'     => $this->M_Fin_Dp->selectHeaderDepositInvoice($headID)
        );
        $this->load->view('finance/transaction/ar_dp/review_dp_invoice/print_invoice', $data);
    }

    function indexPayDepositInvoiceAR($headerID)
    {
        $headID = decode_str($headerID);

        $data   = array(
            '_selectCurrency'   => $this->db->get('zhl_gen_tbl_mst_currency')->result(),
            '_selectMasterCOA'  => $this->M_Fin_Dp->selectCOAforDp()->result(),

            '_selectHeader'     => $this->M_Fin_Dp->selectHeaderDepositInvoice($headID),
            '_selectDetail'     => $this->M_Fin_Dp->selectDetailDepositAP($headID)->result(),
            '_jumDetail'        => $this->M_Fin_Dp->selectDetailDepositAP($headID)->num_rows()
        );
        $this->template->display('finance/transaction/ar_dp/review_dp_invoice/index_pay_invoice', $data);
    }

    function payDepositInvoiceAR()
    {
        $headerPI   = $this->input->post('txtNoReff_ip');

        $data   = array(
            'no_reff'           => $this->input->post('txtNoReff'),
            'no_reff_pi'        => $this->input->post('txtNoReff_ip'),
            'trans_type'        => 'I',
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
            'created_by'        => $this->session->userdata('userid_1'),
            'created_date'      => date('Y-m-d H:i:s')
        );
        $headerID   = $this->M_CashBank->insertCashBankHeader($data);

        $dataUpdateHeaderPI     = array(
            'prepaid'   => '6'
        );
        $this->M_Fin_Dp->updateCashBankHeaderFromDeposit($this->input->post('txtNoReff_ip'), $dataUpdateHeaderPI);

        $jenisJurnal    = $this->input->post('JenisJurnal');
        $description    = $this->input->post('desc');
        $dc             = $this->input->post('dk');
        $no_coa         = $this->input->post('no_coa');
        $total          = str_replace(',', '', $this->input->post('total_jr'));
        $txtdebit          = str_replace(',', '', $this->input->post('debt_jr'));
        $txtcredit         = str_replace(',', '', $this->input->post('credit_jr'));
        $period         = $this->M_Fin_Dp->getPeriodInDP();

        for ($i = 0; $i < count($jenisJurnal); $i++) :
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

            if ($txtcredit[$i] <> 0) {
                $jml    = 0 - $txtcredit[$i];
            } else {
                $jml    = $txtdebit[$i];
            }
            $history    = array(
                'header_id'         => $headerID,
                'no_facture'        => $this->input->post('txtNoReff'),
                'trans_type'        => 'I',
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

        $debet = 0;
        $credit = 0;
        $debet_sgd = 0;
        $credit_sgd = 0;
        $sum_debet = 0;
        $sum_credit = 0;
        $sum_debet_sgd = 0;
        $sum_credit_sgd = 0;

        $coaHutPiu  = array('130401', '130402', '130403', '130404', '200101', '200102', '200103', '200105');
        for ($x = 0; $x < count($jenisJurnal); $x++) {
            if ($txtcredit[$x] <> 0) {
                $dk     = 'C';
                $jml_tot    = str_replace(',', '', $txtcredit[$x]);
                $debet = '0';
                $debet_sgd = '0';
                $credit = number_format(str_replace(",", "", $txtcredit[$x]), 2, ".", "");
                $credit_sgd = number_format(str_replace(",", "", $total[$x]) * $this->input->post('txtRateCurrSGD'), 2, ".", "");
                $sum_credit +=  $credit;
                $sum_credit_sgd += $credit_sgd;
            } else {
                $dk     = 'D';
                $jml_tot    = str_replace(',', '', $txtdebit[$x]);
                $debet = number_format(str_replace(",", "", $txtdebit[$x]), 2, ".", "");
                $debet_sgd = number_format(str_replace(",", "", $total[$x]) * $this->input->post('txtRateCurrSGD'), 2, ".", "");
                $credit = '0';
                $credit_sgd = '0';
                $sum_debet += $debet;
                $sum_debet_sgd += $debet_sgd;
            }

            if ((count($jenisJurnal) - 1) == $x) {
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

            $dataJur    = array(
                'JenisJurnalID'     => $jenisJurnal[$x],
                'NoUrut'            => $x,
                'CompanyID'         => 'PSS',
                'jenis_trans'       => 'RDP',
                'Tanggal'           => date('Y-m-d', strtotime($this->input->post('txtTransDateInv'))),
                'Periode'           => date('mY', strtotime($period)),
                'NoJurnal'          => $this->input->post('txtNoReff'),
                'chk'               => $dc[$x],
                'NoCOA'             => $no_coa[$x],
                'sub_account_id'    => $this->input->post('txtIdVendor'),
                'sub_account_type'  => (in_array($no_coa[$x], $coaHutPiu) ? 'PIU' : ' '),
                'Uraian'            => $this->input->post('txtRemark'),
                'Debet'             => round($debet, 2),
                'Kredit'            => round($credit, 2),
                'Debet_SGD'         => round($debet_sgd, 2),
                'Kredit_SGD'        => round($credit_sgd, 2),
                'Total'             => round($jml_tot, 2),
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

        //========================== Piutang Update ================
        $this->updatePiutangPerInvoiceNew();
        $this->updatePiutangBulananPerInvoiceNew();

        redirect(site_url('DownPaymentAR/reviewDepositAR/' . encode_str($headerID)));
    }

    // ########## = New Update Table Piutang + Piutang Bulanan = ##########
    function updatePiutangPerInvoiceNew()
    {
        $this->load->model('M_CashBank');

        $recieve    = str_replace(',', '', $this->input->post('total_jr'));
        $headerPI   = $this->input->post('txtNoReff_ip');
        $header     = $this->input->post('txtNoReff');

        $getBayar       = $this->M_CashBank->getBayarFromPiutang($headerPI);
        $data   = array(
            'nofaktur'  => $header,
            'bayar'     => $getBayar - floatval($recieve[1])
        );
        $this->M_Fin_Dp->updatePiutangByNoInvoiceInOneARnumberRecieveDeposit($headerPI, $data); // Update table Piutang (ACC)
    }
    function updatePiutangBulananPerInvoiceNew()
    {
        $this->load->model('M_CashBank');

        $recieve    = str_replace(',', '', $this->input->post('total_jr'));
        $headerPI   = $this->input->post('txtNoReff_ip');
        $header     = $this->input->post('txtNoReff');

        $periode    = $this->M_CashBank->getPeriod();
        $thn        = date('Y', strtotime($periode));
        $bln        = date('m', strtotime($periode));

        $this->M_Fin_Dp->updatepiutangBulananByNoInvoiceInOneARnumberQueryReceiveDeposit($headerPI, $bln, $thn, $recieve[1], $header);
    }

    function selectCOA()
    {
        $data   = array(
            '_getMasterCOA' => $this->M_Fin_Dp->selectCOAforARDP()->result()
        );
        $this->load->view('finance/transaction/ar_dp/selectMCOA', $data);
    }
}
