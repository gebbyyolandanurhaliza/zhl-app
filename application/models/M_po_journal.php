<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_po_journal extends CI_Model{

//--------------------------------------------------------ABOUT SUPPLIER--------------------------------------------------------------
    function get_supplier(){
        $this->db->where('factory_id',0);
        $sql = $this->db->get('zhl_pur_vw_mst_supplier');
        if($sql->num_rows() > 0){
           
            foreach ($sql->result_array() as $row) {
                // $result[$row['supplierid']] = ucwords(strtoupper($row['suppliercompany']));
                $result[$row['supplierid']."|".$row['nocoa']] = ucwords(strtoupper($row['suppliercompany']));
            }
            return $result;
        }
        else{
            echo "Not data avaible";
        }
    }
    

//--------------------------------------------------------ABOUT COA-----------------------------------------------------------------
        function tampil_coa(){
            $sql = $this->db->get('zhl_acc_master_coa');
                if($sql->num_rows() > 0){
                    $result[''] = 'Select';
                    foreach ($sql->result_array() as $row) {
                        $result[$row['NoCOA']] = ucwords(strtoupper($row['NoCOA'].' - '.$row['AccountName']));
                        # code...
                    }
                    return $result;
                }

            
        }
//--------------------------------------------------------ABOUT CURRENCY-----------------------------------------------------------------
    function tampil_cur(){
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

    //tambahan 02-05-2016
    function get_coaTax(){
        $this->db->where('RegNO', 1);
        $this->db->where('gl_id', 1);
        $sql = $this->db->get('zhl_acc_master_gl');
         if($sql->num_rows() > 0){
            foreach ($sql->result() as $data){
                $hasil[] =  $data;
            }
            return $hasil;
        }
    }

    // function get_gst(){
    //     $this->db->select('*');
    //     $sql_prov = $this->db->get('gen_tbl_mst_gst');
    //     if ($sql_prov->num_rows() > 0) {
    //         $result[''] = 'Select';
    //         foreach ($sql_prov->result_array() as $row) {
    //             $result[$row['gst_id'] . "|" . $row['gst_value']] = ucwords(strtoupper($row['gst_name']));
    //         }
    //         return $result;
    //     }

    // }

    function get_coaDiscount(){
        $this->db->where('RegNo', 1);
        $this->db->where('gl_id', 2);
        $sql = $this->db->get('zhl_acc_master_gl');
         if($sql->num_rows() > 0){
            foreach ($sql->result() as $data){
                $hasil[] =  $data;
            }
            return $hasil;
        }

    }

    function get_currency($idem){
        $this->db->select('*');
        $this->db->where('currency_id',$idem);
        $sql = $this->db->get('zhl_gen_tbl_mst_currency');

        if($sql->num_rows() > 0){
            foreach ($$sql as $l) {
                $hasil[] = $data;
            }
            return $hasil;
        }
    }
    
//-------------------------------------------------------About Hutang--------------------------------------------------------------
    
    public function tampil_item_jurnal($id, $cur){
        $sql = $this->db->query("SELECT * FROM `zhl_acc_vw_trn_gr` WHERE qty_pi - qtypo <= 0 AND `vendorid` = '$id' and `currency` = '$cur'");
        if($sql->num_rows() > 0){
            foreach ($sql->result() as $data) {
                $hasil[] = $data;
            }
            return $hasil;
        }

    }

    function get_cur(){
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
    //this is function not matter used
    function get_cur_old() {
        $sql_prov = $this->db->query("SELECT * FROM zhl_acc_tbl_trn_kurs WHERE periode=(SELECT DISTINCT periode FROM zhl_acc_tbl_trn_kurs ORDER BY periode DESC LIMIT 1)");
        if ($sql_prov->num_rows() > 0) {
            $result[''] = 'Select';
            foreach ($sql_prov->result_array() as $row) {
                $result[$row['rate_usd'] . "|" . $row['rate_kurs'] . "|" . $row['currency_id']] = ucwords(strtoupper($row['currency_id']));
            }
            return $result;
        } else {
            echo "Not data avaible";
        }
    }

    function tampil_rate(){
        
    }


//-------------------------------------------------------ABOUT PO------------------------------------------------------------------
    function ambil_PO(){
        $sql_prov = $this->db->get('zhl_pur_tbl_trn_po_hdr');
        if ($sql_prov->num_rows() > 0) {
            $result[''] = 'Select';
            foreach ($sql_prov->result_array() as $row) {
                $result[$row['mainpo']] = ucwords(strtoupper($row['mainpo']));
            }
            return $result;
        } else {
            //echo "Not data avaible";
        }
    }

//---------------------------------------------------------ABOUT SAVE INVOICE JURNAL-------------------------------------------------------
    function simpan_header($data){
        $this->db->insert('zhl_acc_tbl_trn_hutang', $data);
    }

    function update_header($noinvoice, $data){
        $this->db->where('nofaktur', $noinvoice);
        $this->db->update('zhl_acc_tbl_trn_hutang', $data);
    }

    function simpan_bulanan($bulan){
        $this->db->insert('zhl_acc_tbl_trn_hutang_bulanan', $bulan);
    }

    function update_bulanan($noinvoice, $data){
        $this->db->where('nofaktur', $noinvoice);
        $this->db->update('zhl_acc_tbl_trn_hutang_bulanan', $data);
    }

    function simpan_detail($data){
        $this->db->insert('zhl_acc_tbl_trn_jurnal', $data);
    }
    

    function update_detail($detailid, $data){
        $this->db->where('DetailID', $detailid);
        $this->db->update('zhl_acc_tbl_trn_jurnal', $data);  
    }

    function delete_detail($noinvoice){
        $this->db->where('NoJurnal', $noinvoice);
        $this->db->delete('zhl_acc_tbl_trn_jurnal');
    }
    
    function simpan_item($data){
        $this->db->insert('zhl_acc_tbl_trn_pi_dtl', $data);
    }
    
    function delete_item($noinvo){
        $this->db->where('HeaderID',$noinvo);
        $this->db->delete('zhl_acc_tbl_trn_pi_dtl');
    }

    function update_item($noinvoice, $itemid, $data){
        $this->db->where('HeaderID', $noinvoice);
        $this->db->where('ItemID', $itemid);
        $this->db->update('zhl_acc_tbl_trn_pi_dtl', $data);
    }

    function update_gr($po, $itemid, $data){
        $this->db->where('mainpo',$po);
        $this->db->where('itemid',$itemid);
        $this->db->update('zhl_pur_tbl_trn_gr_dtl',$data);
    }
//----------------------------------------------------------ABOUT EDIT----------------------------------------------------------
    function hapus_coa_kosong_pi() {
        $coa = array('0', '');
        $this->db->where_in('NoCOA', $coa);
        $this->db->or_where('Total', '0');
        $this->db->delete('zhl_acc_tbl_trn_jurnal');
    }
    
    function get_data_header($id){
        $this->db->select('*');
        $this->db->where('nofaktur', $id);
        $sql = $this->db->get('zhl_vw_acc_tbl_trn_hutang');

        if($sql->num_rows() > 0){
            foreach ($sql->result() as $data) {
                $hasil[] = $data;
            }
            return $hasil;
        }

    }

    function get_data_footer($id){
        $this->db->select('*');
        $this->db->where('NoJurnal', $id);
        $this->db->where_not_in('NoUrut', '0');
        $sql = $this->db->get('zhl_acc_tbl_trn_jurnal');

        if($sql->num_rows() > 0){
                foreach ($sql->result() as $data) {
                    $hasil[] = $data;
                }
                return $hasil;
        }

    }

    function get_data_item($id){
        $this->db->select('*');
        $this->db->where('HeaderID', $id);
        $sql = $this->db->get('zhl_acc_vw_trn_pi_dtl');

        if($sql->num_rows() > 0){
            foreach($sql->result() as $data){
                $hasil[] = $data;
            }
            return $hasil;
        }

    }

    function get_list(){
       $this->db->select('*');
        $this->db->where('jenis_trans','PIJV');
        $sql_product = $this->db->get('zhl_vw_acc_tbl_trn_hutang');

        if($sql_product->num_rows() > 0){
            foreach ($sql_product->result() as $data){
                $hasil[] =  $data;
            }
            return $hasil;
        }
    }

//----------------------------------------------------------ABOUT SAVE----------------------------------------------------------

     function cek($table,$field,$key){
        $this->db->where($field,$key);
        
        $sql=  $this->db->get($table);
        if($sql->num_rows() > 0){$result=1;}
        else{$result=0;}
        return $result;     
    }

    function cek_item($headerID, $itemid){
        $this->db->where('HeaderID', $headerID);
        $this->db->where('ItemID', $itemid);
        $sql = $this->db->get('zhl_acc_tbl_trn_pi_dtl');
        if($sql->num_rows() > 0){$result = 1;}
        else{$result = 0;}
        return $result;
    }
    
    function simpan_hdr($table,$data){
        $this->db->trans_start();
        $this->db->insert($table,$data);
        $this->db->trans_complete();
        
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        }else {
            $this->db->trans_commit();
            return TRUE;
        }
    }
    
    function simpan_dtl($table,$field,$key,$data){
        $this->db->trans_start();
        $this->db->insert($table,$data);
        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            $this->delete_hdr($table,$field,$key);
            $this->db->trans_rollback();
            return FALSE;
        }else {
            $this->db->trans_commit();
            return TRUE;
        }
    }
    
    function simpan_dtl_ver2($table,$field,$key,$data){
        $this->db->trans_start();
        $this->db->insert($table,$data);
        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        }else {
            $this->db->trans_commit();
            return TRUE;
        }
    }
    
    function delete_hdr($table,$field,$key){
        $this->db->where($field, $key);
        $this->db->delete($table);
    }
    

  
}