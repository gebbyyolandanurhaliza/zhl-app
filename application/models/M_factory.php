<?php
class M_factory extends CI_Model
{
	private $vw_po_hdr		= 'zhl_mar_vw_trn_purchase_order_header';
	private $vw_po_dtl		= 'zhl_mar_vw_trn_purchase_order_detail';
	private $vw_po_doc		= 'zhl_mar_vw_trn_purchase_order_document';
	private $vw_quotation_factory	= 'zhl_mar_vw_trn_sales_quotation_factory';
	private $vw_quotation	= 'zhl_mar_vw_trn_sales_quotation';

	function __construct()
    {
        parent::__construct();
    }

	function usergroupid()
	{
		return $this->session->userdata('groupid_1');
	}

	function product_po()
	{
		$param_search	= $this->input->post('param_search');
		$shipdate1		= $this->input->post('ship_date1');
		$shipdate2		= $this->input->post('ship_date2');

		$ugi = $this->usergroupid();

//		$this->db->group_start();
		$this->db->where('status_id', 0);
//		$this->db->where('export_by_factory', 0);
		$this->db->where("factory_id in (select factory_id from zhl_gen_tbl_utl_factory_access where user_group_id=$ugi) ");

//		$this->db->where('ship_date >=' , dmy_to_ymd($shipdate1));
//		$this->db->where('ship_date <=' , dmy_to_ymd($shipdate2));

		$this->db->where('po_date >=' , dmy_to_ymd($shipdate1));
		$this->db->where('po_date <=' , dmy_to_ymd($shipdate2));

//		$this->db->group_end();



		$this->db->group_start();
		$this->db->like('po_number', $param_search);
		$this->db->or_like('contract_no', $param_search);
		$this->db->or_like('factory_name', $param_search);
		$this->db->or_like('factory_abbr', $param_search);
		$this->db->or_like('customer_company_name', $param_search);
		$this->db->or_like('status_name', $param_search);
		$this->db->group_end();

		$this->db->order_by('po_date', 'asc');
		$this->db->order_by('po_number', 'asc');

		$this->session->set_flashdata('no_po_msg', $ugi);

		return $this->db->get($this->vw_po_hdr);
	}

	function get_selected_po($arr)
	{
		$this->db->where_in('po_hdr_id', $arr);
		return $this->db->get($this->vw_po_dtl)->result();
	}

	function update_selected_po($arr)
	{
		$this->db->where_in('po_hdr_id', $arr);
		$this->db->update('zhl_mar_tbltrn_purchase_order', array('export_by_factory' => 1));
	}

	function document_by_po($po_hdr_id)
	{
		$this->db->where('po_hdr_id', $po_hdr_id);
		return $this->db->get($this->vw_po_doc)->result();
	}

	function sales_quotation_filter()
	{
		$param_customer = $this->input->post('customer');
		$param_sales = $this->input->post('sales_id');
		$param_status = $this->input->post('status_id');
		$param_postdate1 = $this->input->post('posting_date1');
		$param_postdate2 = $this->input->post('posting_date2');

		$ugi = $this->usergroupid();

		$this->db->select('quotation_hdr_id, quotation_number, factory_abbr, det_factory_id, customer_name, customer_company_name
			, sales_firstname, sales_lastname, document_date, status_badges, downloadedby, downloadeddate, downloadedbypsg, downloadeddatepsg');

		$this->db->where('1','1');

		$this->db->where("det_factory_id in (select factory_id from gen_tbl_utl_factory_access where user_group_id=$ugi) ");

		if ($param_sales){
			$this->db->where('sales_id', $param_sales);
		}

		if ($param_status !== ''){
			$this->db->where('status_id', $param_status);
		}

		$this->db->group_start();
		$this->db->where('document_date <=' , dmy_to_ymd($param_postdate2));
		$this->db->where('document_date >=' , dmy_to_ymd($param_postdate1));
		$this->db->group_end();

		$this->db->group_start();
		$this->db->like('customer_name',$param_customer);
		$this->db->or_like('customer_company_name', $param_customer);
		$this->db->or_like('customer_code', $param_customer);
		$this->db->group_end();

		$this->db->group_by('quotation_hdr_id, quotation_number, factory_abbr, det_factory_id, customer_name, customer_company_name
			, sales_firstname, sales_lastname, document_date, status_badges, downloadedby, downloadeddate, downloadedbypsg, downloadeddatepsg');

		return $this->db->get($this->vw_quotation_factory)->result();
	}

	function sales_quotation_detail($hdr_id, $factory_id) {
		$ugi = $this->usergroupid();
        $this->db->where('quotation_hdr_id', $hdr_id);
		$this->db->where('det_factory_id', $factory_id);
        return $this->db->get($this->vw_quotation)->result();

    }

    function updatestatussales($hdr, $data){
		// $this->db->set('factoryview', 1);
		$this->db->where('quotation_hdr_id', $hdr);
		return $this->db->update('zhl_mar_tbltrn_sales_quotation', $data);
	}

	function getProduct(){
		$ugi = $this->usergroupid();
		$this->db->where("factory_id in (select factory_id from gen_tbl_utl_factory_access where user_group_id=$ugi) ");
		return $this->db->get('zhl_mar_vw_mst_product')->result();
	}

	function getDataPro($id, $tgl1, $tgl2){
		$this->db->where('product_id', $id);
		$this->db->where('document_date >= ', $tgl1);
		$this->db->where('document_date <= ', $tgl2);
		return $this->db->get('zhl_vw_sales_quotation_product_1')->result();
	}

	function get_detail($hdr_id, $fid)
	{
		$this->db->where('quotation_hdr_id', $hdr_id);
		$this->db->where('factory_id', $fid);
		return $this->db->get($this->vw_quotation)->result();
	}

}
