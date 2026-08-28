<?php
	if(!defined('BASEPATH')) exit ('No direct scriot access allowed');

	class M_po_journal_mar extends CI_Model{
		function get_list(){
			$this->db->select('*');
			$this->db->where('jenis_trans','PIJF');
			$sql_product = $this->db->get('zhl_vw_acc_tbl_trn_hutang');

			if($sql_product->num_rows() > 0){
	            foreach ($sql_product->result() as $data){
	                $hasil[] =  $data;
	            }
	            return $hasil;
	        }

		}

		function get_factory(){
			$this->db->where('factory_id > ',0);
        	$sql = $this->db->get('zhl_pur_tbl_mst_supplier');
			if($sql->num_rows() > 0){
				$result[''] = 'select';
				foreach ($sql->result_array() as $row) {
					$result[$row['supplierid']] = ucwords(strtoupper($row['suppliercompany']));
				}
				return $result;
			}
			else
			{
				echo "Not data avaible";
			}
		}

		function get_item(){
			$sql = $this->db->get('zhl_mar_vw_trn_order_detail');
			if($sql->num_rows() > 0){
				$result[''] = 'select';
				foreach ($sql->result_array() as $row) {
					//$result[$row[]]
				}
				//return $result;
			}
		}

		public function tampil_item_jurnal($id, $cur){
			$this->db->select('*');
			$this->db->where('factory_id', $id);
			$this->db->where('currency', $cur);
			$sql = $this->db->get('zhl_acc_vw_purchase_order_mar');
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
        $sql = $this->db->get('zhl_acc_vw_trn_pi_dtl2');

        if($sql->num_rows() > 0){
            foreach($sql->result() as $data){
                $hasil[] = $data;
            }
            return $hasil;
        }

    }

		function simpan_item($data){
			$this->db->insert('zhl_acc_tbl_trn_pi2_dtl', $data);
		}

		function delete_item($noinvo){
			$this->db->where('HeaderID', $noinvo);
			$this->db->delete('zhl_acc_tbl_trn_pi2_dtl');
		}

		function update_po($poid, $prodi, $data){
			$this->db->where('po_hdr_id', $poid);
			$this->db->where('product_id', $prodi);
			$this->db->update('zhl_mar_tbltrn_purchase_order_detail', $data);
		}
		

	 //Penutup class model
	}


?>