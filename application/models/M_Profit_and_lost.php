<?php

class M_Profit_and_lost extends CI_Model {

    var $mst_supplier = 'zhl_pur_tbl_mst_supplier';
    var $mst_currency = 'zhl_gen_tbl_mst_currency';
    var $tbl_coa = 'zhl_acc_master_coa';
    var $group_coa = 'zhl_acc_group_coa';

    function coa_number() {
        $this->db->select('NoCOA, AccountName');
        $this->db->from('zhl_acc_master_coa');
        $sql = $this->db->get();
        if ($sql->num_rows() > 0) {
            $result[''] = 'Select';
            foreach ($sql->result_array() as $row) {
                $result[$row['NoCOA']] = ucwords(strtolower($row['NoCOA']) . " | " . strtoupper($row['AccountName']));
            }
            return $result;
        } else {
            echo "Not data avaible";
        }
    }

    function input_group($data) {
        $this->db->insert('zhl_acc_report_group', $data);
    }

    function simpan_coa($data) {
        $this->db->insert('zhl_acc_report_coa', $data);
    }

    function category_list() {
        $this->db->select('*');
        $sql = $this->db->get('zhl_acc_report_category');
        if ($sql->num_rows() > 0) {
            $result[''] = 'Select';
            foreach ($sql->result_array() as $row) {
                $result[$row['id_kategori']] = ucwords(strtoupper($row['kategori_report']));
            }
            return $result;
        }
    }

    function select_group_report() {
        //select group first
        $this->db->select('*');
        $sql = $this->db->get('zhl_vw_acc_group_category');
        if ($sql->num_rows() > 0) {
            $result[''] = 'Select';
            foreach ($sql->result_array() as $row) {
                $result[$row['id'] . "|" . $row['id_kategori']] = $row['nama_group'] . " (" . $row['jenis'] . ")";
            }
            return $result;
        }
    }

    function select_group_coa() {
        //select group first
        $this->db->select('GroupName, id_group');
        $sql_group = $this->db->get($this->group_coa);
        if ($sql_group->num_rows() > 0) {
            foreach ($sql_group->result() as $value) {
                $result[] = $value;
            }
            return $result;
        }
    }

    function get_id_coa() {
        $this->db->select('*');
        $this->db->from('zhl_acc_master_coa');
        $sql = $this->db->get();
        if ($sql->num_rows() > 0) {
            foreach ($sql->result() as $value) {
                $result[] = $value;
            }
            return $result;
        }
    }

    function get_coa_list($id_group, $id_kategori) {
        $this->db->select('*');
        $this->db->where('id_kategori', $id_group);
        $this->db->where('id_group', $id_kategori);
        $this->db->from('zhl_vw_acc_report_coa_full');
       // $this->db->group_by('NoCOA');
        $sql = $this->db->get();
        if ($sql->num_rows() > 0) {
            foreach ($sql->result() as $value) {
                $result[] = $value;
            }
            return $result;
        }
    }

    function list_coa() {
        $this->db->select('GroupName, id_group');
        $sql_group = $this->db->get($this->group_coa);
        if ($sql_group->num_rows() > 0) {
            $result[""] = "Select";
            foreach ($sql_group->result_array() as $row) {
                $result[$row['id_group']] = ucwords(strtoupper($row['GroupName']));
            }
            return $result;
        }
    }

    function get_currency() {
        $sql_prov = $this->db->get($this->mst_currency);
        if ($sql_prov->num_rows() > 0) {
            $result[''] = 'Select';
            foreach ($sql_prov->result_array() as $row) {
                $result[$row['currency_id']] = ucwords(strtoupper($row['currency_id']));
            }
            return $result;
        } else {
            echo "Not data avaible";
        }
    }


    function call_data_profit_new($p_dari, $p_sampai) {
        $sql = $this->db->query("call zhl_sp_acc_rpt_profit_and_loss_statement('$p_dari', '$p_sampai')");
        $res = $sql->result();
        $sql->next_result();
        $sql->free_result();
        return $res;
    }
 // function call_data_profit($p_dari, $p_sampai, $nourut) {
  //       $sql = $this->db->query("call sp_acc_rpt_profit_and_loss('$p_dari', '$p_sampai', '$nourut')");
  //       $res = $sql->result();
  //       $sql->next_result();
  //       $sql->free_result();
  //       return $res;
  //   }

    
    function call_data_sales($p_dari, $nourut) {
        $sql = $this->db->query("call zhl_sp_acc_rpt_profit_and_lost('$p_dari', '$nourut')");
        $res = $sql->result();
        $sql->next_result();
        $sql->free_result();
        return $res;
    }
    
    function call_total($coa, $bln, $thn) {
        $data = $this->db->query("SELECT IFNULL(SUM(Debet-Kredit),0) FROM zhl_acc_tbl_trn_jurnal WHERE NoCOA = $coa AND MONTH(Tanggal) = $bln AND Year(Tanggal) = $thn");
        if ($data->num_rows() > 0) {
            foreach ($data->result() as $value) {
                $result[] = $value;
            }
            return $result;
        }
    }
    function call_perbulan1($awal, $akhir) {
        $data = $this->db->query("SELECT a.id_group, a.nama_group, a.id_kategori, a.kategori_report, a.NoCOA, SUM(c.Debet), SUM(c.Kredit), SUM(c.Debet-c.Kredit) as Total, 0,0,0,0,0,0,0,0,0,0,0,0 FROM `zhl_acc_tbl_trn_jurnal` c INNER JOIN zhl_vw_acc_report_coa a ON c.NoCOA = a.NoCOA WHERE MONTH(Tanggal) BETWEEN '$awal' AND '$akhir' AND YEAR(Tanggal) BETWEEN '2016' and '2016' AND c.Debet != 0 OR c.Kredit != '0' and c.NoCOA = '400264'  GROUP BY a.id_group");
        if ($data->num_rows() > 0) {
            foreach ($data->result() as $value) {
                $result[] = $value;
            }
            return $result;
        }
    }

}
