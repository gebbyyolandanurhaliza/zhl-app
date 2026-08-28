<?php

class M_General_Journal_zht extends CI_Model {

    var $mst_supplier = 'zhl_pur_tbl_mst_supplier';
    var $mst_currency = 'zhl_acc_tbl_trn_kurs';
    var $acc_tbl_trn_hutang = 'zht_acc_tbl_trn_hutang';
    var $acc_tbl_trn_jurnal = 'zht_acc_tbl_trn_jurnal_tims';
    var $acc_tbl_trn_hutang_bulanan = 'zht_acc_tbl_trn_hutang_bulanan';

    function __construct() {
        parent::__construct();
    }

    function simpan_header($data){
        $this->db->insert('zht_acc_tbl_trn_general_detail_tims', $data);
    }


    function simpan_jurnal($data){
        $this->db->insert('zht_acc_tbl_trn_jurnal_tims', $data);
    }

    function delete_jurnal($header){
        $this->db->where('NoJurnal', $header);
        $this->db->where('jenis_trans','GJ');
        $this->db->delete('zht_acc_tbl_trn_jurnal_tims');
    }

    function delete_header($header){
        $this->db->where('no_reff', $header);
        $this->db->delete('zht_acc_tbl_trn_general_detail_tims');
    }

    function update_jurnal($header,$data){
        $this->db->where('NoJurnal', $header);
        $this->db->where('jenis_trans','GJ');
        $this->db->update('zht_acc_tbl_trn_jurnal_tims',$data);
    }

    function update_header($header,$data){
        $this->db->where('no_reff', $header);
        $this->db->update('zht_acc_tbl_trn_general_detail_tims',$data);
    }

    function get_header($id){
        $this->db->where('no_reff', $id);
        $sql = $this->db->get('zht_acc_tbl_trn_general_detail_tims');
        if($sql->num_rows() > 0){
            foreach ($sql->result() as $data) {
                $hasil[] = $data;
            }
            return $hasil;
        }
    }

    function get_list(){
        $this->db->select('*');
        $sql = $this->db->get('zht_vw_acc_trb_general_tims');
        if($sql->num_rows() > 0){
            foreach ($sql->result() as $data) {
                $hasil[] = $data;
            }
            return $hasil;
        }
    }

    function get_jurnal($id){
        $this->db->where('no_reff', $id);
        $sql = $this->db->get('zht_acc_tbl_trn_general_detail_tims');
        if($sql->num_rows() > 0){
            foreach($sql->result() as $data){
                $hasil[] = $data;
            }
            return $hasil;
        }
    }

    function get_list_hutang() {
        $this->db->select('*');
        $this->db->where('jenis_trans', 'GJ');
        $sql_product = $this->db->get('zht_acc_tbl_trn_hutang');

        if ($sql_product->num_rows() > 0) {
            foreach ($sql_product->result() as $data) {
                $hasil[] = $data;
            }
            return $hasil;
        }
    }

    function get_refnum($thn, $bln){
        // $thn = date('Y',strtotime($tgl));
        // $thn = date('Y',strtotime($date));

        $sql = $this->db->query("SELECT no_reff FROM zht_acc_tbl_trn_general_detail_tims
            WHERE YEAR(tanggal) = '$thn' AND MONTH(tanggal) = '$bln' AND `no_reff` LIKE '%ZHTGV%' 
            ORDER BY RIGHT(no_reff,4)  DESC LIMIT 1");
        // //return $sql_p->row();

        // if ($sql_product->num_rows() > 0) {
        //     foreach ($sql_product->result() as $data) {
        //         $hasil[] = $data;
        //     }
        //     return $hasil;
        // }
        //$this->db->select('SUBSTRING(no_reff, -4)');
        // $this->db->select('no_reff');
        // $this->db->where('YEAR(tanggal)', date('Y',strtotime($date)));
        // $this->db->like('no_reff', 'GV');
        // $this->db->order_by("RIGHT(no_reff,4)",'desc');        
        // $this->db->limit(1);
        // $sql = $this->db->get('acc_tbl_trn_general_detail');
        return $sql->row();
    }

    function cek_gl($inv){
        $sql = $this->db->query("SELECT no_reff as no_reff FROM zht_acc_tbl_trn_general_detail_tims
            ORDER BY year(tanggal) DESC,RIGHT(no_reff,4)  DESC LIMIT 1");

        return $sql->row();
    }

    function get_supplier() {
        $sql_prov = $this->db->get($this->mst_supplier);
        if ($sql_prov->num_rows() > 0) {
            foreach ($sql_prov->result_array() as $row) {
                $result[$row['supplierid']] = ucwords(strtoupper($row['suppliercompany']));
            }
            return $result;
        } else {
            echo "Not data avaible";
        }
    }

    function get_departmentcode(){
        $sql = $this->db->get('zhl_mar_tblmst_department_code');
        if($sql->num_rows() > 0){
            foreach ($sql->result() as $data) {
                $hasil[] = $data;
            }
            return $hasil;
        }
    }

    function get_currency2() {
        $date = date('Y-m-d');

        $sql_product = $this->db->query("SELECT * FROM acc_tbl_trn_kurs WHERE periode=(SELECT DISTINCT periode FROM zhl_acc_tbl_trn_kurs WHERE periode<='$date' ORDER BY periode DESC LIMIT 1)");
        if ($sql_product->num_rows() > 0) {
            foreach ($sql_product->result_array() as $row) {
                 $result[$row['rate_usd'] . "|" . $row['currency_id'] . "|" . $row['rate_kurs']]   = ucwords(strtoupper($row['currency_id']));
            }
            return $result;
        }

        // $this->db->select('DISTINCT(currency_id), rate_usd');
        // //$this->db->where('periode >=', '2016-01-01');
        // $this->db->where('periode <=', $date);
        // $this->db->order_by('detail_id','DESC');
        // $sql_prov = $this->db->get($this->mst_currency);
        // if ($sql_prov->num_rows() > 0) {
        //     $result[''] = 'Select';
        //     foreach ($sql_prov->result_array() as $row) {
        //         $result[$row['rate_usd'] . "|" . $row['currency_id']] = ucwords(strtoupper($row['currency_id']));
        //     }
        //     return $result;
        // } else {
        //     echo "Not data avaible";
        // }
    }

    function get_currency() {
        $this->db->where('not_active', 0);
        $sql_prov = $this->db->get('zhl_gen_tbl_mst_currency');
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

    function get_currency_detail() {
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

    function get_data_header($id) {
        $this->db->select('*');
        $this->db->where('nofaktur', $id);
        $sql_product = $this->db->get('zht_acc_tbl_trn_hutang');

        if ($sql_product->num_rows() > 0) {
            foreach ($sql_product->result() as $data) {
                $hasil[] = $data;
            }
            return $hasil;
        }else{
            $hasil[] = '';
        }
    }

    function get_data_detail($id) {
        $this->db->select('*');
        $this->db->where('HeaderID', $id);
        $sql_product = $this->db->get('zhl_acc_tbl_trn_general_journal');

        if ($sql_product->num_rows() > 0) {
            foreach ($sql_product->result() as $data) {
                $hasil[] = $data;
            }
            return $hasil;
        }
    }

    function get_data_footer($id) {
        $this->db->select('*');
        $this->db->where('NoJurnal', $id);
        $this->db->where_not_in('NoUrut', '0');
        $sql_product = $this->db->get('zht_acc_tbl_trn_jurnal_tims');

        if ($sql_product->num_rows() > 0) {
            foreach ($sql_product->result() as $data) {
                $hasil[] = $data;
            }
            return $hasil;
        }
    }

    function ambil_currency_date($kurs, $bln, $thn, $hari) {
        $bulan = $thn . "-". $bln .'-'. $hari;
        //$bulan = '2016-10-01';
        $akhirdate = date('Y-m-t', strtotime($bulan));
        $newdate = date('Y-m-d', strtotime("-1 months", strtotime($bulan)));
        if ($bulan < $akhirdate) {
             $sql_product = $this->db->query("SELECT * FROM zhl_acc_tbl_trn_kurs WHERE periode=(SELECT DISTINCT periode FROM zhl_acc_tbl_trn_kurs WHERE periode BETWEEN '$newdate' AND '$bulan' ORDER BY periode DESC LIMIT 1) AND currency_id = '$kurs'");
        }else{
            $sql_product = $this->db->query("SELECT * FROM zhl_acc_tbl_trn_kurs WHERE periode=(SELECT DISTINCT periode FROM zhl_acc_tbl_trn_kurs WHERE periode >='$bulan' ORDER BY periode DESC LIMIT 1) AND currency_id = '$kurs'");
        }
        if ($sql_product->num_rows() > 0) {
            foreach ($sql_product->result() as $data) {
                $hasil[] = $data;
            }
            return $hasil;
        }
    }

    function tampil_po_rate($cur,$tgl){
        $date = date('Y-m-d', strtotime($tgl));
        $lastdate= date('Y-m-01',strtotime($tgl));
        $tempdate   = date('Y-m-01', strtotime($tgl));  
        $newdate = date('Y-m-t', strtotime("-1 months", strtotime($tempdate)));
        // $newdate = $lastdate;

        if($date==$lastdate)
        {

            $query="currency_id = '".$cur."' and periode = '".$date."'";
            $this->db->select('rate_usd');
            $this->db->select('rate_kurs');
            $this->db->select('currency_id');
            $this->db->where($query);
            $this->db->order_by('periode desc');
            $this->db->limit(1);


            $result=$this->db->get('zhl_acc_tbl_trn_kurs');
            if ($result->num_rows() > 0) {
                foreach ($result->result() as $data) {
                    $hasil[] = $data;
                }
                return $hasil;
            }
        }
        else{

            $query=" currency_id = '".$cur."' and periode BETWEEN '".$newdate."' AND '".$date."'";
            $this->db->select('rate_usd');
            $this->db->select('rate_kurs');
            $this->db->select('currency_id');
            $this->db->where($query);
            $this->db->order_by('periode desc');
            $this->db->limit(1);


            $result=$this->db->get('zhl_acc_tbl_trn_kurs');
            if ($result->num_rows() > 0) {
                foreach ($result->result() as $data) {
                    $hasil[] = $data;
                }
                return $hasil;
            }
        }
    }
    
    function selectInvoiceforFindGJ(){
        $this->db->select('*');
        $sql = $this->db->get('zht_vw_acc_trb_general_tims');


        return $sql;
    }

}
