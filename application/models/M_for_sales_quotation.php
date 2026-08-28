<?php

if (!defined('BASEPATH'))
  exit('No direct script access allowed');

class M_for_sales_quotation extends CI_Model
{

  private $tbl_quotation_hdr         = 'zhl_for_tbltrn_sales_quotation';
  private $tbl_quotation_dtl         = 'zhl_for_tbltrn_sales_quotation_detail';
  private $cust_payterm_view     = 'zhl_mar_vw_mst_customer_payterm';
  private $tblmst_country = 'zhl_gen_tbl_mst_country';
  private $sql_cust = 'SELECT a.customer_id,  a.customer_code, a.customer_name, a.customer_company_name,
        a.country_id, b.country_name, b.country_ids, b.country_idn, a.customer_reference,
        a.customer_contract_no, a.customer_address, a.customer_email, a.customer_contact_name,
        a.customer_contact_phone, a.customer_contact_email, a.customer_group_id,  c.customer_group_name,
        c.coa, a.status_customer, a.created_by, a.created_date, a.updated_by, a.updated_date,
        a.customer_phone, a.customer_fax, a.customer_mobilephone, a.customer_term, a.group_customer,
        a.po_remark_default, a.si_consignee_default
      FROM
        zhl_mar_tblmst_customer a LEFT JOIN
        zhl_gen_tbl_mst_country b ON b.country_id = a.country_id LEFT JOIN
        zhl_mar_tblmst_customer_group c ON c.customer_group_id = a.customer_group_id
      WHERE 1=1 ';
  private $order = 'ASC';
  private $port_view            = 'zhl_mar_vw_mst_port';
  private $tradingterm_table    = 'zhl_mar_tblmst_trading_term';
  private $tblmst_currency      = 'zhl_gen_tbl_mst_currency';
  private $vw_quotation_hdr = 'zhl_for_vw_trn_sales_quotation_header';
  private $vw_quotation_dtl = 'zhl_for_tbltrn_sales_quotation_detail';


  function __construct()
  {
    parent::__construct();
  }

  function get_cust()
  {
    $sql = $this->db->get('zhl_mar_tblmst_customer');
    return $sql->result() ; 
  }

  function get_cust_payterm()
  {
    $sql = $this->db->get('zhl_mar_tblmst_payment_term');
    return $sql->result() ; 
  }

  function get_country()
  {
    $this->db->where('not_active', 0);
    $this->db->order_by('country_name', 'ASC');
    $sql = $this->db->get($this->tblmst_country); 
    return $sql->result() ; 
  }

  function get_port()
  {
    $this->db->order_by('port_name', $this->order);
    return $this->db->get($this->port_view)->result();
  }

  function get_cust_by_id($id)
  {
    $sql = $this->sql_cust . " and a.customer_id = " . $id . ";";
    return $this->db->query($sql)->row();
  }

  function get_cust_payterm_by_id($id)
  {
    $this->db->where('customer_id', $id);
    return $this->db->get($this->cust_payterm_view)->result();
  }

  function get_for_charge($id)
  {
    $this->db->where('service_type', $id);
    return $this->db->get('zhl_for_tblmst_charge')->result();
  }

  function get_for_charge_all()
  {
    return $this->db->get('zhl_for_tblmst_charge')->result();
  }

  function get_tradingterm()
  {
      $this->db->where('not_active', 0);
      $this->db->order_by('trading_term_name', $this->order);
      return $this->db->get($this->tradingterm_table)->result();
  }

  function get_currency()
  {
      $this->db->where('not_active', 0);
      $this->db->order_by('currency_name', 'ASC');
      $sql = $this->db->get($this->tblmst_currency);
      return $sql->result() ;
  }

  function get_rate()
  {
    $cur_id = $this->input->post('currency_id');
    if ($cur_id){
      $this->db->where('currency_id', $cur_id);
      $this->db->where('periode <= ', date('Y-m-d'));
      $this->db->order_by('periode', 'desc');
      $this->db->limit(1);
      return $this->db->get('zhl_acc_tbl_trn_kurs')->row();
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

    $cur_id = $this->input->post('currency_id');

    if ($cur_id){
      $this->db->where('currency_id', $cur_id);
      $this->db->where('periode <= ', date('Y-m-d'));
      $this->db->order_by('periode', 'desc');
      $this->db->limit(1);
      $r = $this->db->get('zhl_acc_tbl_trn_kurs')->row();

      $last_rate_month = date("m", strtotime($r->periode));
      $current_month   = date("m", strtotime("-1 month", strtotime($tempdate)));

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

  // INSERT// INSERT// INSERT// INSERT// INSERT// INSERT// INSERT// INSERT// INSERT// INSERT
  function insert()
  {
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

  private function insert_header()
  {
    $quotation_number = $this->last_number($this->input->post('document_date'));


    $info_header = array(
      'quotation_number'      => $quotation_number,
      'customer_id'           => $this->input->post('customer_id'),
      'currency_id'           => $this->input->post('local_currency'),
      'rate_usd'              => remove_thousand_separator($this->input->post('rate_usd')),
      'rate_sgd'              => remove_thousand_separator($this->input->post('rate_sgd')),
      'sales_id'              => $this->input->post('sales_id'),
      'status_id'             => $this->input->post('status_id'),
      'document_date'         => dmy_to_ymd($this->input->post('document_date')),
      'validity_date'         => dmy_to_ymd($this->input->post('validity_date')),
      'payment_term_id'       => $this->input->post('payment_term_id'),
      'customer_reference'    => $this->input->post('customer_reference'),
      'customer_cp'           => $this->input->post('customer_contact_name'),
      'quotation_remark'      => $this->input->post('quotation_remark'),
      'trading_term_id'       => $this->input->post('trading_term_id'),
      'shipment_from'         => $this->input->post('shipment_from'),
      'destination_id'        => $this->input->post('destination_id'),
      'port_id'               => $this->input->post('port_id'),
      'container_id'          => $this->input->post('container_id'),
      'shipping_mode'         => $this->input->post('shipping_mode'),
      'final_total'           => remove_thousand_separator($this->input->post('final_total')),
      'created_by'            => strtoupper($this->session->userdata('userid_1')),
      'created_date'          => date('Y-m-d H:i:s'),
    );

    $this->db->insert($this->tbl_quotation_hdr, $info_header);
    $quotation_header = $this->db->insert_id();


    return $quotation_header;
  }

  private function insert_detail($header_id)
  {
    $detail_count    = count($this->input->post('service_type'));
    $service_type      = $this->input->post('service_type');
    $port_service = $this->input->post('port_service');
    $charge_name      = $this->input->post('charge_name');
    $currency      = $this->input->post('currency');
    $desc           = $this->input->post('desc');
    $price       = $this->input->post('price');
    $quantity       = $this->input->post('quantity');
    $rate_sgd       = $this->input->post('rate_sgd_dtl');
    $rate_usd       = $this->input->post('rate_usd_dtl');
    $remark        = $this->input->post('remark');

    for ($i = 0; $i < $detail_count; $i++) {
      $info_detail = array(
        'quotation_hdr_id' => $header_id,
        'service_type'       => $service_type[$i],
        'port_service'  => $port_service[$i],
        'charge_id'  => $charge_name[$i],
        'currency'  => $currency[$i],
        'desc'  => $desc[$i],
        'price'  => remove_thousand_separator($price[$i]),
        'quantity'  => remove_thousand_separator($quantity[$i]),
        'rate_sgd'  => remove_thousand_separator($rate_sgd[$i]),
        'rate_usd'  => remove_thousand_separator($rate_usd[$i]),
        'remark'  => $remark[$i],
        'created_by'       => strtoupper($this->session->userdata('userid_1')),
        'created_date'     => date('Y-m-d H:i:s'),
      );

      $this->db->insert($this->tbl_quotation_dtl, $info_detail);
    }
  }
  // UPDATE// UPDATE// UPDATE// UPDATE// UPDATE// UPDATE// UPDATE// UPDATE// UPDATE// UPDATE
  // UPDATE
  function update()
  {
    $header_id = decode_str($this->input->post('quotation_hdr_id'));

    $this->db->trans_off();

    $this->db->trans_start();
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

  function update_header($header_id)
  {
    $quotation_number = $this->input->post('quotation_number');
    $info_header = array(
      'quotation_number'      => $quotation_number,
      'customer_id'           => $this->input->post('customer_id'),
      'currency_id'           => $this->input->post('local_currency'),
      'rate_usd'              => remove_thousand_separator($this->input->post('rate_usd')),
      'rate_sgd'              => remove_thousand_separator($this->input->post('rate_sgd')),
      'sales_id'              => $this->input->post('sales_id'),
      'status_id'             => $this->input->post('status_id'),
      'document_date'         => dmy_to_ymd($this->input->post('document_date')),
      'validity_date'         => dmy_to_ymd($this->input->post('validity_date')),
      'payment_term_id'       => $this->input->post('payment_term_id'),
      'customer_reference'    => $this->input->post('customer_reference'),
      'customer_cp'           => $this->input->post('customer_contact_name'),
      'quotation_remark'      => $this->input->post('quotation_remark'),
      'trading_term_id'       => $this->input->post('trading_term_id'),
      'shipment_from'         => $this->input->post('shipment_from'),
      'destination_id'        => $this->input->post('destination_id'),
      'port_id'               => $this->input->post('port_id'),
      'container_id'          => $this->input->post('container_id'),
      'shipping_mode'         => $this->input->post('shipping_mode'),
      'final_total'           => remove_thousand_separator($this->input->post('final_total')),
      'updated_by'            => strtoupper($this->session->userdata('userid_1')),
      'updated_date'          => date('Y-m-d H:i:s'),
    );

    $this->db->update($this->tbl_quotation_hdr, $info_header, array('quotation_hdr_id' => $header_id));
  }

  // END

  private function delete_detail($header_id)
  {
    $this->db->delete($this->tbl_quotation_dtl, array('quotation_hdr_id' => $header_id));
  }

  function sales_person_get_all()
  {
      $this->db->where('position_id', 6);
      return $this->db->get('zhl_for_vw_person_in_charge')->result();
  }

  function get_ids($country_id)
  {
    $query = $this->db->get_where('zhl_gen_tbl_mst_country', array('country_id' => $country_id));
    if ($query->num_rows() > 0){
      $row = $query->row();
      $ids_code=$row->country_ids;
    }else{
      $ids_code='';
    }
    return $ids_code;
  }

  function port_get_by_ids($ids)
  {
      $this->db->where('country_ids', 'ZZ');
      $this->db->or_where_in('country_ids', $ids);
      return $this->db->get($this->port_view)->result();
  }

  function last_number($document_date)
  {
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
    return 'ZHL/SQ/' . $q_tahun . str_pad($q_affix, 4, '0', STR_PAD_LEFT);
  }

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

  function sp_get_by_id($hdr_id)
  {
    $sql = $this->db->query("call zhl_sp_for_trn_quotation_getbyid($hdr_id)");
        $res = $sql->row();
        $sql->next_result();
        $sql->free_result();
        return $res;
  }

   function get_detail($hdr_id) {
        $this->db->where('quotation_hdr_id', $hdr_id);
        return $this->db->get($this->vw_quotation_dtl)->result();

    }
}