<?php if (!defined('BASEPATH'))  exit('No direct script access allowed');

class M_mar_misc extends CI_Model
{
	private $vw_contract_hdr = 'mar_vw_trn_sales_contract_header';
	private $vw_po_hdr = 'mar_vw_trn_purchase_order_header';
	private $vw_quotation_hdr = 'mar_vw_trn_sales_quotation_header';

	function __construct()
    {
        parent::__construct();
    }

	function get_idd($country_id)
	{
		$query = $this->db->get_where('gen_tbl_mst_country', array('country_id' => $country_id));
		if ($query->num_rows() > 0){
			$row = $query->row();
			$idd_code=$row->country_idn;
		}else{
			$idd_code='';
		}
		return $idd_code;
	}

	function get_ids($country_id)
	{
		$query = $this->db->get_where('gen_tbl_mst_country', array('country_id' => $country_id));
		if ($query->num_rows() > 0){
			$row = $query->row();
			$ids_code=$row->country_ids;
		}else{
			$ids_code='';
		}
		return $ids_code;
	}

	function get_rate()
	{
		$cur_id	= $this->input->post('currency_id');
		if ($cur_id){
			$this->db->where('currency_id', $cur_id);
			$this->db->where('periode <= ', date('Y-m-d'));
			$this->db->order_by('periode', 'desc');
			$this->db->limit(1);
			return $this->db->get('acc_tbl_trn_kurs')->row();
		}
	}

	function get_rate_by_currency($currency_id)
	{
		$cur_id	= $currency_id;
		if ($cur_id){
			$this->db->where('currency_id', $cur_id);
			$this->db->where('periode <=', date('Y-m-d'));
			$this->db->order_by('periode', 'desc');
			$this->db->limit(1);
			return $this->db->get('acc_tbl_trn_kurs')->row();
		}
	}

	function rate_is_set($tanggal = null)
	{
		$rate_set = 0;

		if (is_null($tanggal)){
			$tanggal = date('Y-m-d');
		}

		$tanggalakhir = date('Y-m-t',strtotime($tanggal));
		$tempdate   = date('Y-m-01', strtotime($tanggal));

		$cur_id	= $this->input->post('currency_id');

		if ($cur_id){
			$this->db->where('currency_id', $cur_id);
			$this->db->where('periode <= ', date('Y-m-d'));
			$this->db->order_by('periode', 'desc');
			$this->db->limit(1);
			$r = $this->db->get('acc_tbl_trn_kurs')->row();

			$last_rate_month = date("m", strtotime($r->periode));
			$current_month	 = date("m", strtotime("-1 month", strtotime($tempdate)));

			if ($tanggal == $tanggalakhir){
				if($tanggalakhir == $r->periode){
					$rate_set = 1;
				} else {
					$rate_set = -1;
				}
			} else {
				if ($last_rate_month >= $current_month){
					$rate_set = 1;
				} else {
					$rate_set = -1;
				}
			}
		}

		return $rate_set;
	}

	function get_rate_by_date()
	{
//		$tanggal	= dmy_to_ymd($tgl);
		$tanggal	= dmy_to_ymd($this->input->post('tanggal'));
		$tempdate   = date('Y-m-01', strtotime($tanggal));
		$cur_id		= $this->input->post('currency_id');

		// sebelumnya kurs pake tanggal akhir bulan
		// sekarang pake tanggal awal bulan (2017-10-02)
		$previous_month	= strtotime("-1 month", strtotime($tempdate));
		$use_month	= strtotime($tanggal);	// <-- ini sekarang yg dipakai

		if ($cur_id){
			$this->db->where('currency_id', $cur_id);
			$this->db->where('year(periode)', date("Y", $use_month));
			$this->db->where('month(periode)', date("n", $use_month));
//			$this->db->where('periode <= ', $tanggal);
			$this->db->order_by('periode', 'desc');
			$this->db->limit(1);
			return $this->db->get('acc_tbl_trn_kurs')->row();
		}
	}

	function rate_set()
	{
		$rate_set = 0;

		$tanggal		= dmy_to_ymd($this->input->post('tanggal'));
		$tanggalakhir   = date('Y-m-t', strtotime($tanggal));
		$tempdate   	= date('Y-m-01', strtotime($tanggal));
		$previous_month	= strtotime("-1 month", strtotime($tempdate));
		$cur_id			= $this->input->post('currency_id');

		if ($cur_id){
			$this->db->where('currency_id', $cur_id);
			$this->db->where('periode <= ', $tanggal);
			$this->db->order_by('periode', 'desc');
			$this->db->limit(1);
			$r = $this->db->get('acc_tbl_trn_kurs')->row();

			$last_rate_month = date("m", strtotime($r->periode));
			$current_month	 = date("m", $previous_month);

			if ($tanggal == $tanggalakhir){
				if($tanggalakhir == $r->periode){
					$rate_set = 1;
				} else {
					$rate_set = -1;
				}
			} else {
				if ($last_rate_month >= $current_month){
					$rate_set = 1;
				} else {
					$rate_set = -1;
				}
			}

		}

		return $rate_set;
	}

	function get_container_size($container_id)
	{
		$query = $this->db->get_where('mar_tblmst_container', array('container_id' => $container_id));
		if ($query->num_rows() > 0){
			$row = $query->row();
			$con_size = $row->container_size;
		} else {
			$con_size = 0;
		}
		return $con_size;
	}

	function get_factory_by_product($product_id)
	{
		$query = $this->db->get_where('mar_tblmst_product', array('product_id'=>$product_id));
		if ($query->num_rows() > 0){
			$row = $query->row();
			$factory_id=$row->factory_id;
		}else{
			$factory_id= 0;
		}
		return $factory_id;

	}

	function get_po_remark_default($customer_id)
	{
		$query = $this->db->get_where('mar_tblmst_customer', array('customer_id'=>$customer_id));
		if ($query->num_rows() > 0){
			$row = $query->row();
			$ret_value = $row->po_remark_default;
		}else{
			$ret_value = 0;
		}
		return $ret_value;
	}

	function find_contract()
	{
		$param = $this->input->post('find');
		$this->db->like('contract_no', $param);
		$this->db->or_like('customer_name', $param);
		$this->db->or_like('customer_code', $param);
		$this->db->or_like('destination', $param);
		return $this->db->get($this->vw_contract_hdr)->result();
	}

	function find_po()
	{
		$param = $this->input->post('find');
		$this->db->like('po_number', $param);
		$this->db->or_like('factory_name', $param);
		$this->db->or_like('customer_name', $param);
		$this->db->or_like('customer_company_name', $param);
		$this->db->or_like('customer_code', $param);
		$this->db->or_like('destination', $param);
		return $this->db->get($this->vw_po_hdr)->result();
	}

	function find_quotation()
	{
		$param = $this->input->post('find');
		$this->db->like('customer_code', $param);
		$this->db->or_like('customer_name', $param);
		$this->db->or_like('marketing_id', $param);
		$this->db->or_like('sales_status', $param);
		return $this->db->get($this->vw_quotation_hdr)->result();
	}

	// select Brand
    function getBrandForQuotation(){
        $select = $this->db->get('mar_tblmst_brand');
        return $select->result();
    }

}
