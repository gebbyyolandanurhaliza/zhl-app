<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class M_mar_sales_quotation extends CI_Model {

    private $tbl_quotation_hdr = 'mar_tbltrn_sales_quotation';
    private $tbl_quotation_dtl = 'mar_tbltrn_sales_quotation_detail';
    private $tbl_quotation_agent = 'mar_tbltrn_sales_quotation_agent';
    private $tbl_quotation_stathistory = 'mar_tbltrn_sales_quotation_status_history';
    private $vw_quotation = 'mar_vw_trn_sales_quotation';
    private $vw_quotation_hdr = 'mar_vw_trn_sales_quotation_header';
    private $vw_quotation_dtl = 'mar_vw_trn_sales_quotation_detail';

    function __construct() {
        parent::__construct();
        $this->load->model(array('M_mar_master', 'M_mar_misc'));
    }

    function last_number($document_date) {
        $this->db->select('quotation_number')
                ->from($this->tbl_quotation_hdr)
                ->where("DATE_FORMAT(document_date, '%Y') = DATE_FORMAT('" . dmy_to_ymd($document_date) . "', '%Y')")
                ->order_by('quotation_number', 'desc')
                ->limit(1);
        $r = $this->db->get();

        if ($r->num_rows() > 0) {
            foreach ($r->result() as $row) {
                $q_no = $row->quotation_number;
            }
        } else {
            $q_no = 0;
        }

        $q_tahun = right($document_date, 2);
        $q_affix = intval(right($q_no, 4));
        $q_affix++;
        return 'PSS-SQ-' . $q_tahun . str_pad($q_affix, 4, '0', STR_PAD_LEFT);
    }

    function update_product_purchased($product_id) {
        $customer_id = $this->input->post('customer_id');
        $info = array(
            'customer_id' => $customer_id,
            'product_id' => $product_id,
        );
        $sql = $this->db->get_where('mar_tblmst_customer_product_purchase', $info);

        if ($sql->num_rows == 0) {
            $data = array(
                'customer_id' => $customer_id,
                'product_id' => $product_id,
                'ref_by' => 'quotation',
                'created_by' => strtoupper($this->session->userdata('userid')),
                'created_date' => date('Y-m-d H:i:s'),
            );
            $this->db->insert('mar_tblmst_customer_product_purchase', $data);
        }
    }

// INSERT
    function insert() {
        $this->db->trans_off();

        $this->db->trans_start();
        $header_id = $this->insert_header();
        $this->insert_detail($header_id);
        $this->db->trans_complete();

        //generate error
        if ($this->db->trans_status() === FALSE) {
            log_message('error', 'saving sales quotation');
            return 0;
        } else {
            return $header_id;
        }
    }

    private function insert_header() {
        $quotation_number = $this->last_number($this->input->post('document_date'));

		//tambahan sementara penambahan payment_term_id
		if ($this->input->post('payment_term_id')){
			$payterm_row = $this->M_mar_master->payterm_get_by_id($this->input->post('payment_term_id'));
			$payment_terms = $payterm_row->payment_term;
		} else {
			$payment_terms = '';
		}

        $info_header = array(
            'quotation_number'			=> $quotation_number,
            'customer_id'				=> $this->input->post('customer_id'),
            'currency_id'				=> $this->input->post('local_currency'),
            'rate_usd'					=> remove_thousand_separator($this->input->post('rate_usd')),
            'rate_sgd'					=> remove_thousand_separator($this->input->post('rate_sgd')),
            'sales_id'					=> $this->input->post('sales_id'),
            'status_id'					=> $this->input->post('status_id'),
            'document_date'				=> dmy_to_ymd($this->input->post('document_date')),
            'validity_date'				=> dmy_to_ymd($this->input->post('validity_date')),
            'shipping_period1'			=> $this->input->post('shipping_period1'),
            'shipping_period2'			=> $this->input->post('shipping_period2'),
			'payment_term_id'			=> $this->input->post('payment_term_id'),
			'customer_reference'		=> $this->input->post('customer_reference'),
			'customer_cp'				=> $this->input->post('customer_contact_name'),
//			'payment_terms'				=> $payment_terms,
//            'payment_terms'				=> htmlentities($this->input->post('payment_term'), ENT_QUOTES),
            'quotation_remark'			=> $this->input->post('quotation_remark'),
            'trading_term_id'			=> $this->input->post('trading_term_id'),
            'shipment_from'				=> $this->input->post('shipment_from'),
            'destination_id'			=> $this->input->post('destination_id'),
            'port_id'					=> $this->input->post('port_id'),
            'container_id'				=> $this->input->post('container_id'),
            'partial_shipment'			=> $this->input->post('partial_shipment'),
            'marine_insurance'			=> $this->input->post('marine_insurance'),
            'shipping_id'				=> $this->input->post('shipping_id'),
            'shipment_schedule'			=> $this->input->post('shipment_schedule'),
            'shipping_mode'				=> $this->input->post('shipping_mode'),
            'product_shelf_life_id'		=> $this->input->post('product_shelf_life_id'),
            'total_before_disc'			=> remove_thousand_separator($this->input->post('total_before_disc')),
            'discount'					=> remove_percent($this->input->post('discount')),
            'total_disc'				=> remove_thousand_separator($this->input->post('total_disc')),
            'freight'					=> remove_thousand_separator($this->input->post('freight')),
            'freight1'					=> remove_thousand_separator($this->input->post('freight1')),
            'freight2'					=> remove_thousand_separator($this->input->post('freight2')),
            'freight3'					=> remove_thousand_separator($this->input->post('freight3')),

            'freight11'                 => dmy_to_ymd($this->input->post('freight11')),
            'freight12'                 => dmy_to_ymd($this->input->post('freight12')),
            'freight21'                 => dmy_to_ymd($this->input->post('freight21')),
            'freight22'                 => dmy_to_ymd($this->input->post('freight22')),
            'freight31'                 => dmy_to_ymd($this->input->post('freight31')),
            'freight32'                 => dmy_to_ymd($this->input->post('freight32')),

            'tax'						=> remove_thousand_separator($this->input->post('tax')),
            'final_total'				=> remove_thousand_separator($this->input->post('final_total')),
            'created_by'				=> strtoupper($this->session->userdata('userid')),
            'created_date'				=> date('Y-m-d H:i:s'),
        );

        $this->db->insert($this->tbl_quotation_hdr, $info_header);
        $quotation_header = $this->db->insert_id();

        $this->insert_agent($quotation_header, $quotation_number);
        $this->insert_status_history($quotation_header, $this->input->post('status_id'), 'CREATED');

		$this->update_master_customer_reference($this->input->post('customer_id'), $this->input->post('customer_reference'));

        return $quotation_header;
    }

    private function insert_detail($header_id) {
        $detail_count = count($this->input->post('product_id'));
        $product_id = $this->input->post('product_id');
        $detail_brand_id = $this->input->post('detail_brand_id');
        $factory_id = $this->input->post('factory_id');
        $price = $this->input->post('price');
        $quantity = $this->input->post('qty');

        for ($i = 0; $i < $detail_count; $i++) {
            $info_detail = array(
                'quotation_hdr_id' => $header_id,
                'product_id' => $product_id[$i],
                'detail_brand_id' => $detail_brand_id[$i],
                'price' => remove_thousand_separator($price[$i]),
                'quantity' => remove_thousand_separator($quantity[$i]),
                'created_by' => strtoupper($this->session->userdata('userid')),
                'created_date' => date('Y-m-d H:i:s'),
            );

            $f_id = $factory_id[$i];

			if ($f_id == 0){
				$f_id = $this->M_mar_misc->get_factory_by_product($product_id[$i]);
			}

            $this->db->insert($this->tbl_quotation_dtl, $info_detail);
            $this->update_product_purchased($product_id[$i]);
        }

        $sup_id = $this->M_mar_master->get_sup_id($f_id);
        $info_factory = array(
            'factory_id' => $f_id,
            'supplier_id' => $sup_id->supplierid,
        );

        $this->db->update($this->tbl_quotation_hdr, $info_factory, array('quotation_hdr_id' => $header_id));
    }

    private function insert_agent($header_id, $quotation_number) {
        $this->delete_agent($header_id);

//        $agent_count	= count($this->input->post('agent_id'));
        $agent_id		= $this->input->post('agent_id');
        $com_percent	= $this->input->post('agent_com_percent');
        $com_unit		= $this->input->post('agent_com_unit');
		$show_contract	= $this->input->post('show_contract');
        $agent_invoice	= $this->input->post('agent_invoice');

        for ($a = 0; $a < 5; $a++) {
			if ($com_percent[$a] > 0 || $com_unit[$a] > 0){
				$info_agent = array(
					'quotation_hdr_id'	=> $header_id,
					'quotation_number'	=> $quotation_number,
					'agent_id'			=> $agent_id[$a],
					'com_percent'		=> remove_percent($com_percent[$a]),
					'com_unit'			=> remove_thousand_separator($com_unit[$a]),
					'show_contract'		=> $show_contract[$a],
					'invoice'			=> $agent_invoice[$a],
					'created_by'		=> strtoupper($this->session->userdata('userid')),
					'created_date'		=> date('Y-m-d H:i:s'),
				);
				$this->db->insert($this->tbl_quotation_agent, $info_agent);
			}
        }
    }

    private function insert_status_history($hdr_id, $status_id, $action) {
        $info = array(
            'quotation_hdr_id' => $hdr_id,
            'status_id' => $status_id,
            'action' => $action,
            'changed_by' => strtoupper($this->session->userdata('userid')),
            'changed_date' => date('Y-m-d H:i:s'),
        );
        $this->db->insert($this->tbl_quotation_stathistory, $info);
    }

// UPDATE
    function update() {
        $header_id = decode_str($this->input->post('quotation_hdr_id'));

        $this->db->trans_off();

        $this->db->trans_start();
        $this->delete_agent($header_id);
        $this->delete_detail($header_id);
        $this->update_header($header_id);
        $this->insert_detail($header_id);

        $this->db->trans_complete();

        //generate error
        if ($this->db->trans_status() === FALSE) {
            log_message('error', 'error updating sales quotation');
            return 0;
        } else {
            return $header_id;
        }
    }

    function update_header($header_id) {
        $quotation_number = $this->input->post('quotation_number');

		//tambahan sementara penambahan payment_term_id
		if ($this->input->post('payment_term_id')){
			$payterm_row = $this->M_mar_master->payterm_get_by_id($this->input->post('payment_term_id'));
			$payment_terms = $payterm_row->payment_term;
		} else {
			$payment_terms = '';
		}

        $info_header = array(
            'quotation_number'			=> $quotation_number,
            'customer_id'				=> $this->input->post('customer_id'),
            'currency_id'				=> $this->input->post('local_currency'),
            'rate_usd'					=> remove_thousand_separator($this->input->post('rate_usd')),
            'rate_sgd'					=> remove_thousand_separator($this->input->post('rate_sgd')),
            'sales_id'					=> $this->input->post('sales_id'),
            'status_id'					=> $this->input->post('status_id'),
            'document_date'				=> dmy_to_ymd($this->input->post('document_date')),
            'validity_date'				=> dmy_to_ymd($this->input->post('validity_date')),
            'shipping_period1'			=> $this->input->post('shipping_period1'),
            'shipping_period2'			=> $this->input->post('shipping_period2'),
			'payment_term_id'			=> $this->input->post('payment_term_id'),
			'customer_reference'		=> $this->input->post('customer_reference'),
			'customer_cp'				=> $this->input->post('customer_contact_name'),
//			'payment_terms'				=> $payment_terms,
//            'payment_terms'				=> htmlentities($this->input->post('payment_term'), ENT_QUOTES),
            'quotation_remark'			=> $this->input->post('quotation_remark'),
            'trading_term_id'			=> $this->input->post('trading_term_id'),
            'shipment_from'				=> $this->input->post('shipment_from'),
            'destination_id'			=> $this->input->post('destination_id'),
            'port_id'					=> $this->input->post('port_id'),
            'container_id'				=> $this->input->post('container_id'),
            'partial_shipment'			=> $this->input->post('partial_shipment'),
            'marine_insurance'			=> $this->input->post('marine_insurance'),
            'shipping_id'				=> $this->input->post('shipping_id'),
            'shipment_schedule'			=> $this->input->post('shipment_schedule'),
            'shipping_mode'				=> $this->input->post('shipping_mode'),
            'product_shelf_life_id'		=> $this->input->post('product_shelf_life_id'),
            'total_before_disc'			=> remove_thousand_separator($this->input->post('total_before_disc')),
            'discount'					=> remove_percent($this->input->post('discount')),
            'total_disc'				=> remove_thousand_separator($this->input->post('total_disc')),
            'freight'					=> remove_thousand_separator($this->input->post('freight')),
            'freight1'                  => remove_thousand_separator($this->input->post('freight1')),
            'freight2'					=> remove_thousand_separator($this->input->post('freight2')),
            'freight3'					=> remove_thousand_separator($this->input->post('freight3')),

            'freight11'                 => dmy_to_ymd($this->input->post('freight11')),
            'freight12'                 => dmy_to_ymd($this->input->post('freight12')),
            'freight21'                 => dmy_to_ymd($this->input->post('freight21')),
            'freight22'                 => dmy_to_ymd($this->input->post('freight22')),
            'freight31'                 => dmy_to_ymd($this->input->post('freight31')),
            'freight32'                 => dmy_to_ymd($this->input->post('freight32')),
            
            'tax'						=> remove_thousand_separator($this->input->post('tax')),
            'final_total'				=> remove_thousand_separator($this->input->post('final_total')),
            'updated_by'				=> strtoupper($this->session->userdata('userid')),
            'updated_date'				=> date('Y-m-d H:i:s'),
        );

        $this->db->update($this->tbl_quotation_hdr, $info_header, array('quotation_hdr_id' => $header_id));
        $this->insert_agent($header_id, $quotation_number);
        $this->insert_status_history($header_id, $this->input->post('status_id'), 'UPDATED');
    }

	function update_master_customer_reference($customer_id, $customer_reference)
	{
		$this->db->update('mar_tblmst_customer', array('customer_reference'=>$customer_reference), array('customer_id'=>$customer_id));
	}

// DELETE
    function delete() {
        $header_id = decode_str($this->input->post('headerid'));

        $this->db->trans_off();

        $this->db->trans_start();
        $this->delete_detail($header_id);
        $this->delete_agent($header_id);
        $this->delete_header($header_id);
        $this->db->trans_complete();

        //generate error
        if ($this->db->trans_status() === FALSE) {
            log_message('error', 'error deleting sales quotation');
            return false;
        } else {
            return true;
        }
    }

    private function delete_header($header_id) {
        $this->db->delete($this->tbl_quotation_hdr, array('quotation_hdr_id' => $header_id));
    }

    private function delete_detail($header_id) {
        $this->db->delete($this->tbl_quotation_dtl, array('quotation_hdr_id' => $header_id));
    }

    private function delete_agent($header_id) {
        $this->db->delete($this->tbl_quotation_agent, array('quotation_hdr_id' => $header_id));
    }

// FIND
    function find_quotation() {
        $param = $this->input->post('find');

        $this->db->where('status_id=0');
        $this->db->group_start();
        $this->db->like('customer_code', $param);
        $this->db->or_like('customer_name', $param);
        $this->db->or_like('status_name', $param);
        $this->db->group_end();
        return $this->db->get($this->vw_quotation_hdr)->result();
    }

    function get_all($jenis_tabel = null) {
        switch ($jenis_tabel) {
            case 'header':
                $result = $this->db->get($this->vw_quotation_hdr)->result();
                break;

            case 'detail':
                $result = $this->db->get($this->tbl_quotation_hdr)->result();
                break;

            default:
                $result = $this->db->get($this->vw_quotation)->result();
                break;
        }
        return $result;
    }

    function get_all_header_by_search($param) {
        $this->db->like('customer_code', $param);
        $this->db->or_like('customer_name', $param);
        $this->db->or_like('marketing_id', $param);
        $this->db->or_like('sales_status', $param);

        return $this->db->get($this->vw_quotation_hdr)->result();
    }

    function get_by_id($hdrid) {
        $this->db->where('quotation_hdr_id', $hdrid);
        return $this->db->get($this->vw_quotation_hdr)->row();
    }

    function sp_get_by_id($hdr_id)
	{
		$sql = $this->db->query("call sp_mar_trn_quotation_getbyid($hdr_id)");
        $res = $sql->row();
        $sql->next_result();
        $sql->free_result();
        return $res;
	}

    function get_by_customer_code($customer_code) {
        $this->db->where('customer_code', $customer_code);
        return $this->db->get($this->vw_quotation)->row();
    }

    function get_detail($hdr_id) {
        $this->db->where('quotation_hdr_id', $hdr_id);
		//$this->db->order_by('product_category_name');
		//$this->db->order_by('uom_volume', 'desc');
//		return $this->db->get($this->vw_quotation_dtl)->result();
        return $this->db->get($this->vw_quotation_dtl)->result();

    }

    function get_product_purchase($customer_id) {
        $this->db->distinct();
        $this->db->where('customer_id', $customer_id);
		//$this->db->order_by('product_category_name');
		//$this->db->order_by('uom_volume', 'DESC');
        return $this->db->get('mar_vw_trn_product_purchase')->result();
    }

    function get_agent($hdr_id) {
        $this->db->where('quotation_hdr_id', $hdr_id);
        return $this->db->get('mar_tbltrn_sales_quotation_agent')->result();
    }

	function get_agent_contract($hdr_id) {
        $this->db->where('quotation_hdr_id', $hdr_id);
		$this->db->where('show_contract', '1');
        return $this->db->get('mar_tbltrn_sales_quotation_agent')->result();
    }

    function get_data_sebelum($customer_id) {
        $this->db->where('customer_id', $customer_id);
        $this->db->order_by('quotation_number', 'desc');
        $this->db->limit(1);
        return $this->db->get('mar_vw_trn_sales_quotation_header');
    }

	function get_previous_remark($customer_id)
	{
		$this->db->where('customer_id', $customer_id);
		$this->db->order_by('quotation_number', 'desc');
		return $this->db->get('mar_tbltrn_sales_quotation')->result();
	}

    // select Brand
    function getBrandForQuotation(){
        $select = $this->db->get('mar_tblmst_brand');
        return $select->result();
    }

	function get_monitor($status = '')
	{
		switch ($status) {
			case 'open':
				$this->db->where('status_id', 0);
				break;
			case 'confirm':
				$this->db->where('status_id', 1);
				break;
			default:
				$this->db->where_in('status_id', array(0, 1));
				break;
		}

		$this->db->order_by('quotation_number', 'desc');
		return $this->db->get($this->vw_quotation_hdr)->result();
	}

	function get_count_status($status_id = 0)
	{
		$this->db->where('status_id', $status_id);
		return $this->db->count_all_results($this->vw_quotation_hdr);
	}

}
