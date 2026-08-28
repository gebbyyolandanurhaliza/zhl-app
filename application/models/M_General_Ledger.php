<?php

//update date : 28 November
defined('BASEPATH') or exit('No direct script access allowed');

class M_General_Ledger extends CI_Model
{

    function get_jenis_trans()
    {
        $sql = $this->db->query("SELECT * FROM zhl_acc_tbl_jenistrans");
        if ($sql->num_rows() > 0) {
            $result[''] = 'Select';
            foreach ($sql->result_array() as $value) {
                $result[$value['TransID']] = ucwords(strtoupper($value['TransName']));
            }
            return $result;
        }
    }

    function get_coa()
    {
        $sql = $this->db->query("SELECT * FROM zhl_acc_master_coa");
        if ($sql->num_rows() > 0) {
            $result[''] = 'Select';
            foreach ($sql->result_array() as $value) {
                $result[$value['NoCOA']] = ucwords(strtoupper($value['NoCOA'] . " - " . $value['AccountName']));
            }
            return $result;
        }
    }

    function get_coa_new($company)
    {
        $sql = $this->db->query("SELECT * FROM zhl_vw_new_coa_dept_code where company_id = '$company'");
        if ($sql->num_rows() > 0) {
            $result[''] = 'Select';
            foreach ($sql->result_array() as $value) {
                $result[$value['NoCOA']. '-' .$value['kode_department']] = ucwords(strtoupper($value['Kombinasi_COA'] . " - " . $value['AccountName']));
            }
            return $result;
        }
    }

    function get_currency()
    {
        $sql_prov = $this->db->get('zhl_gen_tbl_mst_currency');
        if ($sql_prov->num_rows() > 0) {
            $result[''] = 'Select';
            foreach ($sql_prov->result_array() as $row) {
                $result[$row['currency_id']] = ucwords(strtoupper($row['currency_id']));
            }
            return $result;
        } else {
            echo "No data available";
        }
    }

    function call_gl_summary($dari, $sampai, $coa)
    {
        $sql = $this->db->query("call zhl_sp_acc_rpt_gl_summary('$dari', '$sampai', '$coa')");
        //$sql = $this->db->query("CALL `sp_acc_rpt_gl_summary`('2016-06-23')");
        $res = $sql->result();
        $sql->next_result();
        $sql->free_result();
        return $res;
    }

    
    function call_gl_summary_new($dari, $sampai, $noCOA, $dept)
    {
        $sql = $this->db->query("call zhl_sp_acc_rpt_gl_summary_new('$dari', '$sampai', '$noCOA', '$dept')");
        //$sql = $this->db->query("CALL `sp_acc_rpt_gl_summary`('2016-06-23')");
        $res = $sql->result();
        $sql->next_result();
        $sql->free_result();
        return $res;
    }

    function hasil($dari, $sampai, $coa, $reference, $jenis)
    {
        $this->db->select('*');
        $query = "(Debet != 0 OR Kredit != 0)";

        $this->db->where('Tanggal BETWEEN "' . date('Y-m-d', strtotime($dari)) . '" and "' . date('Y-m-d', strtotime($sampai)) . '"');
        $this->db->where($query);
        if ($coa != "") {
            $this->db->where('NoCOA', $coa);
        }
        if ($reference != "") {
            $this->db->where('NoJurnal', $reference);
        }
        if ($jenis != "") {
            $this->db->like('jenis_trans', $jenis);
        }
        // $sql = $this->db->get('acc_tbl_trn_jurnal');
        $sql = $this->db->get('zhl_vw_acc_tbl_trn_jurnal');

        if ($sql->num_rows() > 0) {
            foreach ($sql->result() as $data) {
                $hasil[] = $data;
            }
            return $hasil;
        }
    }

    function get_detail_gl($p_dari, $p_sampai, $coa)
    {
        $sql = $this->db->query("call zhl_sp_acc_rpt_gl_detail_new('$p_dari', '$p_sampai', '$coa')");
        $res = $sql->result();
        $sql->next_result();
        $sql->free_result();
        return $res;
    }

    function get_detail_gl_new($p_dari, $p_sampai, $coa_new, $dept_code)
    {
        $sql = $this->db->query("call zhl_sp_acc_rpt_gl_detail_new_coa_copy1('$p_dari', '$p_sampai', '$coa_new','$dept_code')");
        $res = $sql->result();
        $sql->next_result();
        $sql->free_result();
        return $res;
    }



    function call_gl_detail($dari, $sampai)
    {

        $sql_product = $this->db->query("SELECT  a.NoCOA, b.JenisJurnalID,b.uraian, a.AccountName, b.Tanggal, b.NoJurnal, b.Debet, b.Kredit FROM zhl_acc_master_coa a INNER JOIN zhl_acc_group_coa d ON a.GroupCOA=d.id_group INNER JOIN zhl_acc_tbl_trn_jurnal b ON a.NoCOA=b.NoCOA WHERE b.Tanggal BETWEEN '$dari' AND '$sampai' order by b.Kredit, b.NoJurnal");

        if ($sql_product->num_rows() > 0) {
            foreach ($sql_product->result() as $data) {
                $hasil[] = $data;
            }
            return $hasil;
        }
    }

    function pilih_jurnal($dari, $sampai)
    {
        $sql_product = $this->db->query("SELECT  b.NoJurnal FROM zhl_acc_tbl_trn_jurnal b WHERE b.Tanggal BETWEEN '$dari' AND '$sampai' group by b.NoJurnal");

        if ($sql_product->num_rows() > 0) {
            foreach ($sql_product->result() as $data) {
                $hasil[] = $data;
            }
            return $hasil;
        }
    }
    function call_account_gl()
    {
        $data = $this->db->query("SELECT a.id_kategori, b.nama_group,  a.id_group, a.no_coa as NoCOA, d.kategori_report, c.Currency, c.Rate, c.rate_sgd FROM zhl_acc_report_coa a INNER JOIN zhl_acc_report_group AS b ON a.id_kategori = b.id INNER JOIN zhl_acc_report_category as d on a.id_group = d.id_kategori  INNER JOIN `zhl_acc_tbl_trn_jurnal` c on c.NoCOA = a.no_coa WHERE a.id_group = '4' GROUP BY a.id_kategori ORDER BY a.id_group DESC, b.nama_group ASC");
        if ($data->num_rows() > 0) {
            foreach ($data->result() as $value) {
                $result[] = $value;
            }
            return $result;
        }
    }

    function get_coa2($coa)
    {
        $sql = $this->db->query("SELECT * FROM zhl_acc_master_coa WHERE NoCOA='$coa'");
        if ($sql->num_rows() > 0) {

            foreach ($sql->result_array() as $value) {
                $value['NoCOA'] = ucwords(strtoupper($value['NoCOA'] . " - " . $value['AccountName']));
            }
            return $value['NoCOA'];
        }
    }

    function call_gl_all_detail($dari, $sampai, $start_coa, $end_coa)
    {
        $sql = $this->db->query("call zhl_sp_acc_rpt_gl_detail_all_new('$dari', '$sampai', '$start_coa', '$end_coa')");

        //$sql = $this->db->query("CALL `sp_acc_rpt_gl_summary`('2016-06-23')");
        $res = $sql->result();
        $sql->next_result();
        $sql->free_result();
        return $res;
    }

    function call_gl_all_detail_new($dari, $sampai, $start_coa, $end_coa)
    {
        $sql = $this->db->query("call zhl_sp_acc_rpt_gl_detail_all_new_coa('$dari', '$sampai', '$start_coa', '$end_coa')");

        //$sql = $this->db->query("CALL `sp_acc_rpt_gl_summary`('2016-06-23')");
        $res = $sql->result();
        $sql->next_result();
        $sql->free_result();
        return $res;
    }

    function call_gl_all_detail_dev($dari, $sampai, $start_coa, $end_coa)
    {
        $sql = $this->db->query("call zhl_sp_acc_rpt_gl_detail_all('$dari', '$sampai', '$start_coa', '$end_coa')");
        //$sql = $this->db->query("CALL `sp_acc_rpt_gl_summary`('2016-06-23')");
        $res = $sql->result();
        $sql->next_result();
        $sql->free_result();
        return $res;
    }

    function call_gl_all_detail_2($dari, $sampai, $coa, $coa2)
    {
        $sql = $this->db->query("call zhl_sp_acc_rpt_gl_detail_all_2024('$dari', '$sampai', '$coa', '$coa2')");
        //$sql = $this->db->query("CALL `sp_acc_rpt_gl_summary`('2016-06-23')");
        $res = $sql->result();
        $sql->next_result();
        $sql->free_result();
        return $res;
    }

    function call_gl_all_detail_2_new($dari, $sampai, $coa_new, $coa_new2)
    {
        $sql = $this->db->query("call zhl_sp_acc_rpt_gl_detail_all_2024_new('$dari', '$sampai', '$coa_new', '$coa_new2')");
        //$sql = $this->db->query("CALL `sp_acc_rpt_gl_summary`('2016-06-23')");
        $res = $sql->result();
        $sql->next_result();
        $sql->free_result();
        return $res;
    }
}
