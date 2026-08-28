<?php ('BASEPATH') or exit('No direct script access allowed');

/* 
 * Author : Ismo
 */

class M_Fin_CB extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    function newCheckReffNumber($type, $tanggal, $currency)
    {
        $tgl    = date("Y", strtotime($tanggal));
        $bulan    = date("m", strtotime($tanggal));
        // echo $tgl; 'AP', 'PDP', 'AR', 'RDP',
        // tambah AR dan AP
        if ($type == 'OUT' && $currency == 'USD') {
            $inJurnal   = $this->db->query("SELECT substring(reff_number,8,4) AS GEN FROM zhl_fin_vw_auto_reff_number WHERE "
                . "type IN ('BO', 'CO', 'O') AND tanggal = '$tgl' and bulan='$bulan' AND currency = 'USD' and reff_number not in('BP23121242',
'BR23120056') ORDER BY GEN DESC LIMIT 1");
        } else if ($type == 'OUT' && $currency == 'SGD') {
            $inJurnal   = $this->db->query("SELECT substring(reff_number,7,4) AS GEN FROM zhl_fin_vw_auto_reff_number WHERE "
                . "type IN ('BO', 'CO', 'O') AND tanggal = '$tgl' and bulan='$bulan' AND currency = 'SGD' and reff_number not in('BP23121242',
'BR23120056') ORDER BY GEN DESC LIMIT 1");
        }else if ($type == 'OUT' && $currency == 'IDR') {
            $inJurnal   = $this->db->query("SELECT substring(reff_number,7,4) AS GEN FROM zhl_fin_vw_auto_reff_number WHERE "
                . "type IN ('BO', 'CO', 'O') AND tanggal = '$tgl' and bulan='$bulan' AND currency = 'IDR' and reff_number not in('BP23121242',
'BR23120056') ORDER BY GEN DESC LIMIT 1");
        } else if ($type == 'IN' && $currency == 'USD') {
            $inJurnal   = $this->db->query("SELECT substring(reff_number,8,4) AS GEN FROM zhl_fin_vw_auto_reff_number WHERE "
                . "type IN ('BI', 'CI', 'I') AND tanggal = '$tgl' and bulan='$bulan' AND currency = 'USD' and reff_number not in('BP23121242',
'BR23120056') ORDER BY GEN DESC LIMIT 1");
        } else if ($type == 'IN' && $currency == 'SGD') {
            $inJurnal   = $this->db->query("SELECT substring(reff_number,7,4) AS GEN FROM zhl_fin_vw_auto_reff_number WHERE "
                . "type IN ('BI', 'CI','I') AND tanggal = '$tgl' and bulan='$bulan' AND currency = 'SGD' and reff_number not in('BP23121242',
'BR23120056') ORDER BY GEN DESC LIMIT 1");
        } else if ($type == 'IN' && $currency == 'IDR') {
            $inJurnal   = $this->db->query("SELECT substring(reff_number,8,4) AS GEN FROM zhl_fin_vw_auto_reff_number WHERE "
                . "type IN ('BI', 'CI', 'I') AND tanggal = '$tgl' and bulan='$bulan' AND currency = 'IDR' and reff_number not in('BP23121242',
'BR23120056') ORDER BY GEN DESC LIMIT 1");
        }

        if ($inJurnal->num_rows() > 0) {
            $get    = $inJurnal->row();
            $set    = $get->GEN;
        } else {
            $set    = 0;
        }

        $num    = intval($set);
        // echo $num;
        return $num + 1;
    }

    function newCheckReffNumberCash($type, $tanggal)
    {
        $tgl    = date("Y", strtotime($tanggal));
        $bulan    = date("m", strtotime($tanggal));
        // echo $tgl; 'AP', 'PDP', 'AR', 'RDP',
        if ($type == 'OUT') {
            // Ini bisa digunakan tetapi ini dapat membuat duplikat karena mengambil by currency
            // $inJurnal   = $this->db->query("SELECT substring(reff_number,8,4) AS GEN FROM zhl_fin_vw_auto_reff_number WHERE "
            //     . "type IN ('CO', 'O') AND tanggal = '$tgl' and bulan = '$bulan' AND currency = '$currency' ORDER BY GEN DESC LIMIT 1");

            $inJurnal   = $this->db->query("SELECT substring(reff_number,8,4) AS GEN FROM zhl_fin_vw_auto_reff_number WHERE "
                . "type IN ('CO', 'O') AND tanggal = '$tgl' and bulan = '$bulan' ORDER BY GEN DESC LIMIT 1");
        } else if ($type == 'IN') {
            $inJurnal   = $this->db->query("SELECT substring(reff_number,8,4) AS GEN FROM zhl_fin_vw_auto_reff_number WHERE "
                . "type IN ('CI', 'I') AND tanggal = '$tgl' and bulan = '$bulan' ORDER BY GEN DESC LIMIT 1");
        }

        if ($inJurnal->num_rows() > 0) {
            $get    = $inJurnal->row();
            $set    = $get->GEN;
        } else {
            $set    = 0;
        }

        $num    = intval($set);
        // echo $num;
        return $num + 1;
    }



    function cek_reff($type, $tgl, $currency)
    {
        if (($type == 'BP' || $type == 'AP' || $type = 'CP') && $currency == 'USD') {
            $sql   = $this->db->query("SELECT reff_number AS GEN FROM zhl_fin_vw_auto_reff_number WHERE "
                . "type IN ('BO', 'CO', 'AP', 'PDP','O', 'BP') AND tanggal = '" . $tgl . "' AND currency = 'USD' ORDER BY GEN DESC LIMIT 1");
        } else if (($type == 'BP' || $type == 'AP' || $type = 'CP') && $currency == 'SGD') {
            $sql   = $this->db->query("SELECT reff_number AS GEN FROM zhl_fin_vw_auto_reff_number WHERE "
                . "type IN ('BO', 'CO', 'AP', 'PDP','O', 'BP') AND tanggal = '" . $tgl . "' AND currency = 'SGD' ORDER BY GEN DESC LIMIT 1");
        } else if (($type == 'BP' || $type == 'AP' || $type = 'CP') && $currency == 'IDR') {
            $sql   = $this->db->query("SELECT reff_number AS GEN FROM zhl_fin_vw_auto_reff_number WHERE "
                . "type IN ('BO', 'CO', 'AP', 'PDP','O', 'BP') AND tanggal = '" . $tgl . "' AND currency = 'IDR' ORDER BY GEN DESC LIMIT 1");
        }else if (($type == 'BR' || $type == 'AR' || $type = 'CR') && $currency == 'USD') {
            $sql   = $this->db->query("SELECT reff_number AS GEN FROM zhl_fin_vw_auto_reff_number WHERE "
                . "type IN ('BI', 'CI', 'AR', 'RDP','I', 'BR') AND tanggal = '" . $tgl . "' AND currency = 'USD' ORDER BY GEN DESC LIMIT 1");
        } else if (($type == 'BR' || $type == 'AR' || $type = 'CR') && $currency == 'SGD') {
            $sql   = $this->db->query("SELECT reff_number AS GEN FROM zhl_fin_vw_auto_reff_number WHERE "
                . "type IN ('BI', 'CI', 'AR', 'RDP','I', 'BR') AND tanggal = '" . $tgl . "' AND currency = 'SGD' ORDER BY GEN DESC LIMIT 1");
        }else if (($type == 'BR' || $type == 'AR' || $type = 'CR') && $currency == 'IDR') {
            $sql   = $this->db->query("SELECT reff_number AS GEN FROM zhl_fin_vw_auto_reff_number WHERE "
                . "type IN ('BI', 'CI', 'AR', 'RDP','I', 'BR') AND tanggal = '" . $tgl . "' AND currency = 'IDR' ORDER BY GEN DESC LIMIT 1");
        }

        return $sql->row();
    }

    function selectCurrByBankAccount($nocoa)
    {
        $get    = $this->db->query("SELECT * FROM zhl_fin_tblmst_awal_saldo WHERE NewCOA = '" . $nocoa . "' ");
        $row    = $get->row();
        return $row->Currency;
    }
    function countReffCB($tgl, $type)
    {
        $get    = $this->db->query("SELECT header_id FROM zhl_fin_tbltrn_cashbank_journal_header WHERE "
            . "EXTRACT(YEAR FROM created_date) = YEAR('" . $tgl . "') AND "
            . "EXTRACT(MONTH FROM created_date) = MONTH('" . $tgl . "') AND "
            . "trans_type = '" . $type . "'");
        return $get->num_rows() + 1;
    }
    function selectTransGroup()
    {
        return $this->db->query("SELECT * FROM zhl_acc_report_group ORDER BY nama_group");
    }
    function selectCOAforCBtrans($company_id)
    {
        return $this->db->query("SELECT * FROM zhl_fin_vw_mst_coa_balance_tims WHERE company_id = '" . $company_id . "' ORDER BY AccountName");
    }
    function selectCOAforCBtransOld()
    {
        return $this->db->query("SELECT * FROM zhl_fin_vw_mst_coa_balance ORDER BY AccountName");
    }
    function selectMasterCOAforCB($company_id)
    {
        // return $this->db->query("SELECT * FROM zhl_acc_master_coa ORDER BY AccountName");
        return $this->db->query("SELECT * FROM zhl_vw_new_coa_dept_code WHERE company_id='$company_id'");
    }
    function selectMasterCOAforAddCost()
    {
        return $this->db->query("SELECT * FROM zhl_acc_master_coa ORDER BY AccountName");
        //return $this->db->query("SELECT * FROM zhl_fin_vw_mst_coa_add_cost ORDER BY AccountName");
    }
    function selectEmployeeForCashBank()
    {
        return $this->db->query("SELECT * FROM zhl_fin_tblmst_karyawan ORDER BY department");
    }
    function selectIOtypeForCB()
    {
        $select = $this->db->get('zhl_fin_tblmst_io_type');
        return $select->result();
    }
    function getKursByIDforCB($id, $tglInvoice)
    {
        $tgl    = date('Y-m-d', strtotime($tglInvoice));
        return $query = $this->db->query("SELECT * FROM zhl_acc_tbl_trn_kurs WHERE periode <= '" . $tgl . "' AND currency_id = '" . $id . "' ORDER BY periode DESC LIMIT 1");
    }
    function getTransTypeIObyCode($code)
    {
        return $this->db->query("SELECT * FROM zhl_fin_tblmst_io_type WHERE io_code = '" . $code . "'");
    }
    function selectSupplierforCBtrans()
    {
        return $this->db->query("SELECT * FROM zhl_fin_vw_mst_supplier WHERE supplierid IN (SELECT vendorid FROM zhl_pur_tbl_trn_po_hdr "
            . "WHERE status != 2 AND mainpo NOT IN (SELECT po_id FROM zhl_fin_tbltrn_cashbank_journal_detail_po))");
    }
    function selectCustomerforCBtrans()
    {
        return $this->db->query("SELECT * FROM zhl_fin_vw_mst_customer WHERE customer_id IN (SELECT factory_id FROM zhl_mar_tbltrn_purchase_order "
            . "WHERE status_id = 0 AND po_number NOT IN (SELECT po_id FROM zhl_fin_tbltrn_cashbank_journal_detail_po))");
    }
    function selectPObySupplierForCBtrans($idSupp)
    {
        return $this->db->query("SELECT * FROM zhl_pur_tbl_trn_po_hdr WHERE vendorid = '" . $idSupp . "' "
            . "AND status != 2 AND mainpo NOT IN (SELECT po_id FROM zhl_fin_tbltrn_cashbank_journal_detail_po)");
    }
    function selectPObyCustomerForCBtrans($idCust)
    {
        return $this->db->query("SELECT * FROM zhl_mar_tbltrn_purchase_order WHERE factory_id = '" . $idCust . "' "
            . "AND status_id = 0 AND po_number NOT IN (SELECT po_id FROM zhl_fin_tbltrn_cashbank_journal_detail_po)");
    }
    function getCOAforDPcashBank($type)
    {
        return $this->db->query("SELECT * FROM zhl_fin_tblmst_coa_dp WHERE type_dp = '" . $type . "'");
    }
    function getEmployeeByHeaderIDforNui($headerID)
    {
        $this->db->where('header_id', $headerID);
        $get = $this->db->get('zhl_fin_tblmst_karyawan');
        return $get->row();
    }
    function getMasterCOAbyNumberforNui($coa)
    {
        $this->db->where('NoCOA', $coa);
        $get = $this->db->get('zhl_acc_master_coa');
        return $get->row();
    }

    // ========== ## Insert Detail Down Payment PO in Cash Bank ## ==========
    function insertDetailPOcbTransaction($data)
    {
        $this->db->insert('zhl_fin_tbltrn_cashbank_journal_detail_po', $data);
    }

    // ################################################################################################
    function selectHeaderCashBankForFind()
    {

        $this->db->where("prepaid NOT IN (1,2)");
        return $this->db->get('zhl_fin_vw_trn_select_cb_for_find_new');
    }

    function selectCBTransReport($from, $to, $trans){

        if ($trans !== '') {
           $sql1 = 'AND trans_type = "' . $trans . '"';
        } else {
            $sql1 = '';
        }

        $sql =  $this->db->query("
            SELECT
                h.`header_id`,
                h.`no_reff`,
                h.`date1`,
                h.`trans_type`,
                h.`prepaid`,
                h.`cashbank_code`,
                h.`from_to`,
                h.`trans_description`,
                h.`currency_id`,
                h.`currency_rate`,
                CASE 
                    WHEN sum_d.debit_amount IS NOT NULL AND sum_d.debit_amount <> 0 THEN sum_d.debit_amount
                    ELSE sum_d.credit_amount
                END AS amount
            FROM `zhl_fin_tbltrn_cashbank_journal_header` AS h
            JOIN `zhl_fin_tblmst_io_type` AS t ON t.`io_code` = h.`trans_type`
            LEFT JOIN (
                SELECT
                    `header_id`,
                    SUM(`credit`) AS `credit_amount`,
                    SUM(`debit`) AS `debit_amount`
                FROM
                    `zhl_fin_tbltrn_cashbank_journal_detail`
                WHERE
                    `coa` IN (
                        SELECT `no_coa` FROM `zhl_fin_tblmst_awal_saldo`
                        UNION
                        SELECT `newcoa` FROM `zhl_fin_tblmst_awal_saldo`
                    )
                GROUP BY
                    `header_id`
            ) AS sum_d ON h.`header_id` = sum_d.`header_id`
            WHERE
                h.`prepaid` NOT IN (1,2) AND h.`date1` BETWEEN '" . $from . "' AND '" . $to . "' " . $sql1 . "
            ");

        return $sql->result();
    }

    // model lama, jangan dihapus dulu
    // function selectHeaderCashBankForFind_az()
    // {
    //     $sql =  $this->db->query("
    //     SELECT
    //         h.`header_id`,
    //         h.`no_reff`,
    //         h.`date1`,
    //         h.`trans_type`,
    //         h.`prepaid`,
    //         h.`cashbank_code`,
    //         h.`from_to`,
    //         h.`trans_description`,
    //         h.`currency_id`,
    //         h.`currency_rate`,
    //         CASE 
    //             WHEN sum_d.debit_amount IS NOT NULL AND sum_d.debit_amount <> 0 THEN sum_d.debit_amount
    //             ELSE sum_d.credit_amount
    //         END AS amount
    //     FROM `zhl_fin_tbltrn_cashbank_journal_header` AS h
    //     JOIN `zhl_fin_tblmst_io_type` AS t ON t.`io_code` = h.`trans_type`
    //     LEFT JOIN (
    //         SELECT
    //             `header_id`,
    //             SUM(`credit`) AS `credit_amount`,
    //             SUM(`debit`) AS `debit_amount`
    //         FROM
    //             `zhl_fin_tbltrn_cashbank_journal_detail`
    //         WHERE
    //             `coa` IN (SELECT `no_coa` FROM `zhl_fin_tblmst_awal_saldo`)
    //         GROUP BY
    //             `header_id`
    //     ) AS sum_d ON h.`header_id` = sum_d.`header_id`
    //     WHERE
    //         h.`prepaid` NOT IN (1,2) 

    //     ");

    //     return $sql;
    // }

    private function _baseQuery()
    {
        $this->db->select("
            h.`header_id`,
            h.`no_reff`,
            h.`date1`,
            h.`trans_type`,
            h.`prepaid`,
            h.`cashbank_code`,
            h.`from_to`,
            h.`trans_description`,
            h.`currency_id`,
            h.`currency_rate`,
            CASE 
                WHEN IFNULL(sum_d.credit_amount, 0) <> 0 
                    THEN sum_d.credit_amount
                ELSE IFNULL(sum_d.debit_amount, 0)
            END AS amount
        ", FALSE);

        $this->db->from('zhl_fin_tbltrn_cashbank_journal_header h');
        $this->db->join('zhl_fin_tblmst_io_type t', 't.io_code = h.trans_type');
        $this->db->join("
            (
                SELECT
                    `header_id`,
                    SUM(`credit`) AS `credit_amount`,
                    SUM(`debit`) AS `debit_amount`
                FROM
                    `zhl_fin_tbltrn_cashbank_journal_detail`
                WHERE
                    `coa` IN (SELECT `no_coa` FROM `zhl_fin_tblmst_awal_saldo`)
                GROUP BY
                    `header_id`
            ) sum_d
        ", 'h.header_id = sum_d.header_id', 'left');

        $this->db->where_not_in('h.prepaid', [1,2]);
    }

    function countFiltered()
    {
        $this->_baseQuery();
        $this->applySearch();
        return $this->db->count_all_results();
    }

    private function applySearch()
    {
        if (empty($_POST['search']['value'])) {
            return;
        }

        $search = trim($_POST['search']['value']);

        // Pisahkan apakah ada tahun
        $parts = preg_split('/\s+/', $search);

        $year = null;
        $text = [];

        foreach ($parts as $part) {
            if (preg_match('/^\d{4}$/', $part)) {
                $year = $part;
            } else {
                $text[] = $part;
            }
        }

        $text = implode(' ', $text);

        if ($text != '') {
            $this->db->group_start()
                ->like('h.no_reff', $text)
                ->or_like('h.cashbank_code', $text)
                ->or_like('h.from_to', $text)
                ->or_like('h.trans_description', $text)
                ->or_like('h.currency_id', $text)
            ->group_end();
        }

        if ($year) {
            $this->db->where('YEAR(h.date1)', $year, FALSE);
        }
    }

    function countAll()
    {
        $this->db->from('zhl_fin_tbltrn_cashbank_journal_header');
        $this->db->where_not_in('prepaid', [1,2]);
        return $this->db->count_all_results();
    }

    private $column_order = [
        'h.no_reff',
        'h.date1',
        'h.cashbank_code',
        'h.from_to',
        'h.trans_description',
        'h.currency_id',
        'amount'
    ];

    function getCashBankServerSide()
    {
        $this->_baseQuery();

        $this->applySearch();

        if (isset($_POST['order'][0]['column']) &&
            isset($this->column_order[$_POST['order'][0]['column']])) {

            $colIndex = $_POST['order'][0]['column'];
            $dir      = $_POST['order'][0]['dir'];

            $this->db->order_by($this->column_order[$colIndex], $dir);
        } else {
            $this->db->order_by('h.date1', 'DESC');
        }

        $length = isset($_POST['length']) ? $_POST['length'] : 10;
        $start  = isset($_POST['start']) ? $_POST['start'] : 0;
        $this->db->limit($length, $start);

        return $this->db->get()->result();
    }
    
    function selectHeaderCashBankForFindNui()
    {
        $this->db->where("prepaid = 2");
        return $this->db->get('zhl_fin_vw_trn_select_cb_for_find_new');
    }
    function selectHeaderCashBankForReviewByID($headerID)
    {
        $this->db->where('header_id', $headerID);
        $get = $this->db->get('zhl_fin_vw_trn_select_cb_header_review_tes');
        return $get->row();
    }
    function selectPurchesForReviewByHeaderID($headerID)
    {
        $this->db->where('header_id', $headerID);
        $select = $this->db->get('zhl_fin_vw_trn_select_cb_purch_review');
        return $select->result();
    }
    function checkPurchesForReviewByHeaderID($headerID)
    {
        $this->db->where('header_id', $headerID);
        $select = $this->db->get('zhl_fin_vw_trn_select_cb_purch_review');

        if ($select->num_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
    function selectDetailCashBankForReviewByHeaderID($headerID)
    {
        $this->db->where('header_id', $headerID);
        $select = $this->db->get('zhl_fin_tbltrn_cashbank_journal_detail');
        return $select->result();
    }
    // ============ ##Return Cash Bank Transaction## ============
    function deleteDetailPOcbTransaction($headerID)
    {
        $this->db->where('header_id', $headerID);
        $this->db->delete('zhl_fin_tbltrn_cashbank_journal_detail_po');
    }
    function deleteCashBankFromJurnal($hearedID)
    {
        $this->db->where("NoJurnal = '" . $hearedID . "' AND jenis_trans IN (SELECT io_code FROM zhl_fin_tblmst_io_type)");
        $this->db->delete('zhl_acc_tbl_trn_jurnal');
    }
    function deleteCashBankFromHistory($hearedID)
    {
        $this->db->where("header_id = '" . $hearedID . "' AND trans_type IN (SELECT io_code FROM zhl_fin_tblmst_io_type)");
        $this->db->delete('zhl_fin_tbltrn_cashbank_journal_history');
    }
    function deleteCashBankDetailByHeaderID($headerID)
    {
        $this->db->where('header_id', $headerID);
        $this->db->delete('zhl_fin_tbltrn_cashbank_journal_detail');
    }
    function deleteCashBankHeaderByHeaderID($headerID)
    {
        $this->db->where('header_id', $headerID);
        $this->db->delete('zhl_fin_tbltrn_cashbank_journal_header');
    }

    function deleteCashBankgst($headerID)
    {
        $this->db->where("ref_nomor = '" . $headerID . "' AND jenis_trans IN (SELECT io_code FROM zhl_fin_tblmst_io_type)");
        $this->db->delete('zhl_acc_tbl_trn_gst');
    }

    function updateCashBankFromJurnal($headerID, $data)
    {
        $this->db->where("NoJurnal = '" . $headerID . "' AND jenis_trans IN (SELECT io_code FROM zhl_fin_tblmst_io_type)");
        $this->db->update('zhl_acc_tbl_trn_jurnal', $data);
    }

    function updateCashBankHeaderByHeaderID($headerID, $data)
    {
        $this->db->where('header_id', $headerID);
        $this->db->update('zhl_fin_tbltrn_cashbank_journal_header', $data);
    }

    // =============== Check Saldo ===============
    function chechSaldoAwal($bankCode)
    {
        $get    = $this->db->query("SELECT saldo_awal FROM zhl_fin_tblmst_awal_saldo WHERE no_coa = '" . $bankCode . "' ");
        $ambil  = $get->row();
        return $ambil->saldo_awal;
    }

    function checkSaldoKini($bankCode)
    {
        $check  = $this->db->query("SELECT saldo_awal + (SELECT IF(SUM(debit) - SUM(credit) IS NULL, 0, SUM(debit) - SUM(credit)) FROM zhl_fin_tbltrn_cashbank_journal_history WHERE coa_code = '" . $bankCode . "') AS saldo_kini FROM zhl_fin_tblmst_awal_saldo WHERE no_coa = '" . $bankCode . "' ");
        $result = $check->row();
        return $result->saldo_kini;
    }
}
