<?php

class M_Tims extends CI_Model
{

  var $tbl_vehicle = 'zhl_tims_mst_vehicle';
  var $vw_vehicle = 'zhl_vw_mst_vehicle';
  var $tbl_driver = 'zhl_tims_mst_driver';
  var $tbl_price  = 'zhl_tims_mst_driver_price';
  var $tbl_job_hdr = 'zhl_tims_tbl_trn_job_hdr';
  var $tbl_job_dtl = 'zhl_tims_tbl_trn_job_dtl';
  var $tbl_inv_hdr = 'zhl_tbl_trn_tims_inv_hdr';
  var $tbl_inv_dtl = 'zhl_tbl_trn_tims_inv_dtl';
  var $tbl_mst_customer = 'zhl_tims_mst_customer';
  var $tbl_mst_customer_dtl = 'zhl_tims_mst_customer_dtl_item';
  var $cust_table   = 'zhl_mar_tblmst_customer';
  var $tbl_item     = 'zhl_tims_mst_item';
  var $tbl_public_hdr = 'zhl_tims_tbl_trn_public_hdr';
  var $tbl_public_dtl = 'zhl_tims_tbl_trn_public_dtl';
  var $tbl_public_holiday  = 'zhl_tims_mst_public_holiday';


  /* -------------------------------------------------------------------------- */
  /*                                   Vehicle                                  */
  /* -------------------------------------------------------------------------- */

  function get_vehicle()
  {

    $this->db->select('*');
    $sql = $this->db->get($this->tbl_vehicle);
    if ($sql->num_rows() > 0) {
      foreach ($sql->result() as $data) {
        $hasil[] = $data;
      }
      return $hasil;
    }
  }


  function get_vehicle2()
  {
    $this->db->select('*');
    $this->db->from($this->vw_vehicle);
    $this->db->where('vehicle_type !=', 'Trailers');
    // $this->db->where('inactive', 0);
    return $this->db->get()->result();
  }

  function get_item_vehicle($id)
  {
    $this->db->select('*');
    $this->db->where('id_vehicle', $id);
    $this->db->from($this->vw_vehicle);
    $query = $this->db->get()->row();
    return $query;
  }

  function get_item_vehicle_detail($id)
  {
    $this->db->where('id_vehicle', $id);
    return $this->db->get($this->tbl_vehicle)->row();
  }

  function insert_vehicle($data)
  {
    $this->db->insert($this->tbl_vehicle, $data);
    return $this->db->affected_rows();
  }

  public function update_vehicle($data, $id)
  {
    $this->db->where('id_vehicle', $id);
    $this->db->update($this->tbl_vehicle, $data);
    return $this->db->affected_rows();
  }

  public function delete_vehicle($id)
  {
    $this->db->where('id_vehicle', $id);
    $this->db->delete($this->tbl_vehicle);
    return $this->db->affected_rows();
  }

  /* -------------------------------------------------------------------------- */
  /*                                 End Vehicle                                */
  /* -------------------------------------------------------------------------- */


  /* -------------------------------------------------------------------------- */
  /*                                Model Driver                                */
  /* -------------------------------------------------------------------------- */

  public function save_driver($data)
  {
    $this->db->insert($this->tbl_driver, $data);
    return $this->db->affected_rows();
  }

  public function drivers()
  {
    $this->db->select('*');
    $this->db->from($this->tbl_driver);
    $this->db->where('inactive', 0);
    $this->db->order_by('driver_name', 'desc');
    return $this->db->get()->result();
  }

  public function driver_by_id($id)
  {
    $this->db->select('*');
    $this->db->from($this->tbl_driver);
    $this->db->where('id_driver', $id);
    return $this->db->get()->row();
  }

  public function update_driver($data, $id)
  {
    $this->db->where('id_driver', $id);
    $this->db->update($this->tbl_driver, $data);
    return $this->db->affected_rows();
  }

  public function driver_delete($id)
  {
    $this->db->where('id_driver', $id);
    $this->db->delete($this->tbl_driver);
    return $this->db->affected_rows();
  }

  /* -------------------------------------------------------------------------- */
  /*                              Model Driver End                              */
  /* -------------------------------------------------------------------------- */

  /* -------------------------------------------------------------------------- */
  /*                                Model Price                                 */
  /* -------------------------------------------------------------------------- */

  public function save_price($data)
  {
    $this->db->insert($this->tbl_price, $data);
    return $this->db->affected_rows();
  }

  public function prices()
  {
    $this->db->select('*');
    $this->db->from($this->tbl_price);
    $this->db->order_by('driver_wages', 'asc');
    return $this->db->get()->result();
  }

  public function price_by_id($id)
  {
    $this->db->select('*');
    $this->db->from($this->tbl_price);
    $this->db->where('job_price_id', $id);
    return $this->db->get()->row();
  }

  public function update_price($data, $id)
  {
    $this->db->where('job_price_id', $id);
    $this->db->update($this->tbl_price, $data);
    return $this->db->affected_rows();
  }

  public function price_delete($id)
  {
    $this->db->where('job_price_id', $id);
    $this->db->delete($this->tbl_price);
    return $this->db->affected_rows();
  }

  /* -------------------------------------------------------------------------- */
  /*                              Model Price  End                              */
  /* -------------------------------------------------------------------------- */

  /* -------------------------------------------------------------------------- */
  /*                                 Driver Job                                 */
  /* -------------------------------------------------------------------------- */


  function current_date_cek($current_date)
  {
    $this->db->select('current_date');
    $this->db->from($this->tbl_job_hdr);
    $this->db->where('current_date', $current_date);
    return $this->db->get()->num_rows();
  }

  function save_job_hdr($data)
  {
    $this->db->insert($this->tbl_job_hdr, $data);
    return $this->db->insert_id();
  }

  function save_job_dtl($data)
  {
    $this->db->insert_batch($this->tbl_job_dtl, $data);
    return $this->db->affected_rows();
  }

  function update_job_dtl($data)
  {
    $this->db->update_batch($this->tbl_job_dtl, $data, 'id_job_dtl');
    return $this->db->affected_rows();
  }

  function update_job_dtl_nobatch($id, $data)
  {
    $this->db->where('id_job_dtl', $id);
    $this->db->update($this->tbl_job_dtl, $data);
    return $this->db->affected_rows();
  }

  public function update_job_hdr($data, $id)
  {
    $this->db->where('id_job_hdr', $id);
    $this->db->update($this->tbl_job_hdr, $data);
    return $this->db->affected_rows();
  }

  function get_customer()
  {

    return $this->db->get('zhl_tims_mst_customer')->result();
  }

  function get_sup()
  {
    // $this->db->where('status_customer', 1);
    $this->db->order_by('customer_name', 'ASC');
    $sql_prov = $this->db->get('zhl_tims_mst_customer');
    if ($sql_prov->num_rows() > 0) {
      $result[''] = 'Select';
      foreach ($sql_prov->result_array() as $row) {
        $result[$row['customer_code']] = ucwords(strtoupper($row['customer_name']));
      }
      return $result;
    } else {
      echo "";
    }
  }

  function get_item()
  {
    return $this->db->get('zhl_tims_mst_item')->result();
  }

  function get_driver()
  {
    return $this->db->get('zhl_tims_mst_driver')->result();
  }

  function get_currency()
  {
    return $this->db->get('zhl_gen_tbl_mst_currency')->result();
  }

  function get_customerId($customerId)
  {
    // Assuming you have a table named 'vendors'
    $query = $this->db->get_where('zhl_tims_mst_customer', array('customer_code' => $customerId));

    if ($query->num_rows() > 0) {
      return $query->row_array(); // Return the vendor information as an associative array
    } else {
      return array(); // Return an empty array if no vendor is found
    }
  }

  function get_job_hdr($id)
  {
    $this->db->select('*');
    $this->db->from($this->tbl_job_hdr);
    $this->db->where('id_job_hdr', $id);
    return $this->db->get()->row();
  }

  function get_job_hdr_tgl($tgl)
  {
    $this->db->select('*');
    $this->db->from($this->tbl_job_hdr);
    $this->db->where('current_date', $tgl);
    return $this->db->get()->row();
  }

  function get_job_dtl($id)
  {
    $this->db->select('*');
    $this->db->from($this->tbl_job_dtl);
    $this->db->where('id_job_hdr', $id);
    return $this->db->get()->result();
  }

  function get_job_dtl_vehicle($id_job_header, $vehicle)
  {
    $this->db->select('*');
    $this->db->from($this->tbl_job_dtl);
    $this->db->where('id_job_hdr', $id_job_header);
    if ($vehicle != "") {
      $this->db->where('id_vehicle', $vehicle);
    }
    return $this->db->get()->result();
  }

  function get_job_dtl_id($id)
  {
    $this->db->select('*');
    $this->db->from($this->tbl_job_dtl);
    $this->db->where('id_job_dtl', $id);
    return $this->db->get()->row();
  }

  function delete_multiple_job_dtl($data)
  {
    $this->db->where_in('id_job_dtl', $data);
    $this->db->delete($this->tbl_job_dtl);
    return $this->db->affected_rows();
  }

  function delete_job_dtl($id)
  {
    $this->db->where('id_job_dtl', $id);
    $this->db->delete($this->tbl_job_dtl);
    return $this->db->affected_rows();
  }

  function find_job_filter($current_date_start, $current_date_end)
  {
    $this->db->select('*');
    $this->db->from($this->tbl_job_hdr);
    $this->db->where('current_date >=', $current_date_start);
    $this->db->where('current_date <=', $current_date_end);
    return $this->db->get()->result();
  }

  function delete_job($id)
  {
    $this->db->where('id_job_hdr', $id);
    $this->db->delete($this->tbl_job_hdr);
    return $this->db->affected_rows();
  }

  function customer()
  {
    $this->db->select('*');
    $this->db->from('zhl_tims_mst_customer');
    return $this->db->get()->result();
  }

  function insert_log_delete_dtl($data)
  {
    $this->db->insert_batch('zhl_tims_tbl_trn_job_dtl_delete_log', $data);
    return $this->db->affected_rows();
  }

  function insert_log_delete_dtl_no_batch($data)
  {
    $this->db->insert('zhl_tims_tbl_trn_job_dtl_delete_log', $data);
    return $this->db->affected_rows();
  }

  function insert_log_delete_hdr($data)
  {
    $this->db->insert('zhl_tims_tbl_trn_job_hdr_delete_log', $data);
    return $this->db->affected_rows();
  }

  /* -------------------------------------------------------------------------- */
  /*                                 Driver Job  End                            */
  /* -------------------------------------------------------------------------- */

  /* -------------------------------------------------------------------------- */
  /*                              Start Of Invoice                              */
  /* -------------------------------------------------------------------------- */

  function save_inv_hdr($data)
  {
    $this->db->insert($this->tbl_inv_hdr, $data);
    return $this->db->insert_id();
  }
  function save_inv_dtl($data)
  {
    $this->db->insert_batch($this->tbl_inv_dtl, $data);
    return $this->db->affected_rows();
  }

  public function update_inv_hdr($data, $id)
  {
    $this->db->where('Header_id', $id);
    $this->db->update($this->tbl_inv_hdr, $data);
    return $this->db->affected_rows();
  }

  function update_inv_dtl($data)
  {
    $this->db->update_batch($this->tbl_inv_dtl, $data, 'Detail_id');
    return $this->db->affected_rows();
  }

  public function get_inv()
  {
    $this->db->select('inv_hdr.*, customer.customer_name');
    $this->db->from('zhl_tbl_trn_tims_inv_hdr as inv_hdr');
    $this->db->join('zhl_mar_vw_mst_customer as customer', 'customer.customer_code = inv_hdr.Customer_code', 'left');
    return $this->db->get()->result();
  }

  public function get_inv_hdr_id($id)
  {
    $this->db->select('inv_hdr.*, customer.customer_name, customer.contact_name as contact, customer.phone as phone');
    $this->db->from('zhl_tbl_trn_tims_inv_hdr as inv_hdr');
    $this->db->join('zhl_tims_mst_customer as customer', 'customer.customer_code = inv_hdr.Customer_code', 'left');
    $this->db->where('inv_hdr.Header_id', $id);
    return $this->db->get()->row();
  }

  function get_inv_hdr($id)
  {
    $this->db->select('*');
    $this->db->from($this->tbl_inv_hdr);
    $this->db->where('Header_id', $id);
    return $this->db->get()->row();
  }
  function get_inv_dtl($id)
  {
    $this->db->select('*');
    $this->db->from($this->tbl_inv_dtl);
    $this->db->where('Header_id', $id);
    return $this->db->get()->result();
  }

  function get_nofaktur($tahun, $bulan)
  {

    $sql = "SELECT CAST(SUBSTR(Noinv, 5, 4) AS UNSIGNED) as urut
                FROM zhl_tbl_trn_tims_inv_hdr
                where YEAR(Invoice_date) = '$tahun' ORDER BY CAST(SUBSTR(Noinv, 5, 4) as UNSIGNED) DESC LIMIT 1";
    echo $sql;
    $query = $this->db->query($sql)->row();
    if (empty($query)) {
      $no = "ZHT 0001/" . $bulan . "/" . $tahun;
    } else {
      $n = $query->urut;
      $n = $n + 1;
      $n = str_pad($n, 4, '0', STR_PAD_LEFT);
      $no = "ZHT " . $n . "/" . $bulan . "/" . $tahun;
    }

    return $no;
  }


  function delete_invoice($id)
  {
    $this->db->where('Header_id', $id);
    $this->db->delete('zhl_tbl_trn_tims_inv_hdr');

    // Delete records from the details table
    $this->db->where('Header_id', $id);
    $this->db->delete('zhl_tbl_trn_tims_inv_dtl');
  }


  function advance_list_invoice($invoice, $supplier)
  {
    $sql_product = $this->db->query("select * from zhl_tbl_trn_tims_inv_dtl WHERE  kode_sup like '%$supplier%' and nofaktur like '%$invoice%'");

    if ($sql_product->num_rows() > 0) {
      foreach ($sql_product->result() as $data) {
        $hasil[] = $data;
      }
      return $hasil;
    }
  }


  /* -------------------------------------------------------------------------- */
  /*                               End Of Invoice                               */
  /* -------------------------------------------------------------------------- */


  /* -------------------------------------------------------------------------- */
  /*                             Start of Monitoring                            */
  /* -------------------------------------------------------------------------- */

  function tampil_job_list($customer)
  {

    $sql = $this->db->query("select * from zhl_vw_tims_job_driver where client_id = '$customer' ");

    if ($sql->num_rows() > 0) {
      foreach ($sql->result() as $data) {
        $hasil[] = $data;
      }
      return $hasil;
    }
  }

  function tampil_summary_job_filter()
  {

    $schedule_date1 = $this->input->post('schedule_date1');
    $schedule_date2 = $this->input->post('schedule_date2');


    $this->db->where('curr_date >=', dmy_to_ymd($schedule_date1));
    $this->db->where('curr_date <=', dmy_to_ymd($schedule_date2));


    $this->db->order_by('curr_date', 'asc');
    return $this->db->get('zhl_vw_tims_job_driver')->result();
  }


  function monitor_filter()
  {
    $param_search   = $this->input->post('param_search');
    $drivers         = $this->input->post('drivers');

    $schedule_date1 = $this->input->post('schedule_date1');
    $schedule_date2 = $this->input->post('schedule_date2');

    $this->db->where('curr_date >=', dmy_to_ymd($schedule_date1));
    $this->db->where('curr_date <=', dmy_to_ymd($schedule_date2));

    if ($drivers != '') {
      $this->db->where('id_driver', $drivers);
    }

    // $this->db->group_start();

    // $this->db->like('vehicle_no', $param_search);

    // $this->db->group_end();

    $this->db->order_by('curr_date', 'asc');
    return $this->db->get('zhl_vw_tims_job_driver')->result();
  }

  function get_job_driver($dtl_id)
  {
    $sql = $this->db->query("select * from zhl_vw_tims_job_driver WHERE id_job_dtl IN ($dtl_id)");
    return $sql->row();
  }

  /* -------------------------------------------------------------------------- */
  /*                              END OF MONITORING                             */
  /* -------------------------------------------------------------------------- */

  /* -------------------------------------------------------------------------- */
  /*                              Start Of Costumer                             */
  /* -------------------------------------------------------------------------- */
  public function get_customer_transport()
  {
    $this->db->select('*');
    $this->db->from('zhl_tims_mst_customer');
    $this->db->order_by('customer_id', 'desc');
    return $this->db->get()->result();
  }

  function save_customer_transport($datahdr)
  {
    $hdr = $this->save_customer_transport_hdr($datahdr);

    $item_id = $this->input->post('item_id');
    $price = $this->input->post('price');
    $sort_num = $this->input->post('sort_num');

    $data_dtl = array();
    for ($i = 0; $i < count($item_id); $i++) {
      $data_dtl2 = array('customer_id' => $hdr, 'item_id' => $item_id[$i], 'price_item' => $price[$i], 'sort_num' => $sort_num[$i]);
      array_push($data_dtl, $data_dtl2);
    }

    if (count($data_dtl) > 0) {
      $this->save_customer_transport_dtl($data_dtl);
    }
  }

  function save_customer_transport_hdr($data)
  {
    $this->db->insert($this->tbl_mst_customer, $data);
    return $this->db->insert_id();
  }

  function save_customer_transport_dtl($data_dtl)
  {
    $this->db->insert_batch($this->tbl_mst_customer_dtl, $data_dtl);
  }

  function get_id_customer_transport($id)
  {
    $this->db->select('*');
    $this->db->from($this->tbl_mst_customer);
    $this->db->where('customer_id', $id);
    return $this->db->get()->row();
  }

  public function get_id_customer_transport_dtl($id)
  {
    $this->db->select('dtl.price_item,dtl.item_id,dtl.sort_num, item.*');
    $this->db->from('zhl_tims_mst_customer_dtl_item as dtl');
    $this->db->join('zhl_tims_mst_item as item', 'dtl.item_id = item.Id', 'left');
    $this->db->where('dtl.customer_id', $id);
    $this->db->order_by('dtl.sort_num', 'asc');

    return $this->db->get()->result();
  }

  // public function get_id_customer_transport_dtl_code($id)
  // {
  //   $this->db->select('dtl.price_item,dtl.item_id,dtl.sort_num,item.*');
  //   $this->db->from('zhl_tims_mst_customer_dtl_item as dtl');
  //   $this->db->join('zhl_tims_mst_item as item', 'dtl.item_id = item.Id', 'left');
  //   $this->db->join('zhl_tims_mst_customer as cust', 'dtl.customer_id = cust.customer_id', 'left');
  //   $this->db->where('cust.customer_code', $id);
  //   $this->db->order_by('dtl.sort_num', 'asc');
  //   return $this->db->get()->result();
  // }

  public function get_id_customer_transport_dtl_code($id)
  {
    $this->db->select('dtl.price_item,dtl.item_id,dtl.sort_num,item.*');
    $this->db->from('zhl_tims_mst_customer_dtl_item as dtl');
    $this->db->join('zhl_tims_mst_item as item', 'dtl.item_id = item.Id', 'left');
    $this->db->join('zhl_tims_mst_customer as cust', 'dtl.customer_id = cust.customer_id', 'left');
    $this->db->join('zhl_acc_master_new_coa as coa', 'item.Income_coa = coa.NoCOA');
    $this->db->where('cust.customer_code', $id);
    $this->db->order_by('dtl.sort_num', 'asc');
    return $this->db->get()->result();
  }

  public function get_id_ap_dtl_code($id)
  {
    $this->db->select('Items, Qty, Harga, gst_type, NoCOA, HeaderID,Unit, dept_code');
    $this->db->from('zht_acc_tbl_trn_payable_recognition');
    $this->db->where('customerID', $id);
    $this->db->or_where('customerID', 'depo001');
    return $this->db->get()->result();
  }

  // public function get_id_ap_dtl_code($id)
  // {
  //   $this->db->select('payreg.Items, payreg.Qty, payreg.Harga, payreg.gst_type, payreg.NoCOA, payreg.HeaderID, payreg.Unit, coa.sub_account_type');
  //   $this->db->from('zht_acc_tbl_trn_payable_recognition as payreg');
  //   $this->db->join('zhl_vw_new_coa_dept_code as coa', 'payreg.NoCOA = coa.NoCOA');
  //   $this->db->where('customerID', $id);
  //   $this->db->or_where('customerID', 'depo001');
  //   return $this->db->get()->result();
  // }

  function delete_customer_transport_dtl($id)
  {
    $this->db->where('customer_id', $id);
    $this->db->delete($this->tbl_mst_customer_dtl);
  }

  function update_customer_transport($data, $id)
  {
    $this->db->where('customer_id', $id);
    $this->db->update($this->tbl_mst_customer, $data);

    $item_id = $this->input->post('item_id');
    $price = $this->input->post('price');
    $sort_num = $this->input->post('sort_num');

    $data_dtl = array();
    for ($i = 0; $i < count($item_id); $i++) {
      $data_dtl2 = array('customer_id' => $id, 'item_id' => $item_id[$i], 'price_item' => $price[$i], 'sort_num' => $sort_num[$i]);
      array_push($data_dtl, $data_dtl2);
    }

    if (count($data_dtl) > 0) {
      $this->delete_customer_transport_dtl($id);
      $this->save_customer_transport_dtl($data_dtl);
    }
  }

  function delete_customer($id)
  {
    $this->db->where('customer_id', $id);
    $this->db->delete('zhl_tims_mst_customer');
  }

  function cek_mst_table($id)
  {
    $this->db->where('customer_code', $id);
    $query = $this->db->get($this->tbl_mst_customer);

    return $query->num_rows() > 0;
  }

  function cek_cust_table($id)
  {
    $this->db->where('customer_code', $id);
    $query = $this->db->get($this->cust_table);

    return $query->num_rows() > 0;
  }

  function get_customer_code_by_id($id)
  {
    $this->db->where('customer_id', $id);
    $query = $this->db->get($this->tbl_mst_customer);
    $result = $query->row();

    if ($result) {
      return $result->customer_code;
    }

    $this->db->where('customer_id', $id);
    $query = $this->db->get($this->cust_table);
    $result = $query->row();

    if ($result) {
      return $result->customer_code;
    }
    return null;
  }


  /* -------------------------------------------------------------------------- */
  /*                               End Of Costumer                              */
  /* -------------------------------------------------------------------------- */


  /* -------------------------------------------------------------------------- */
  /*                                 Master Item                                */
  /* -------------------------------------------------------------------------- */

  function select_allitem()
  {
    $this->db->select('*');
    $this->db->order_by('id');
    $sql_product = $this->db->get('zhl_tims_mst_item');
    if ($sql_product->num_rows() > 0) {
      foreach ($sql_product->result() as $row) {
        $result[] = $row;
      }
    }
    return $result;
  }

  function save_item($data)
  {
    $this->db->insert($this->tbl_item, $data);
  }

  function update_item($id, $data)
  {
    $this->db->where('Id', $id);
    $this->db->update($this->tbl_item, $data);
  }

  /* -------------------------------------------------------------------------- */
  /*                                 End Of Item                                */
  /* -------------------------------------------------------------------------- */


  /* -------------------------------------------------------------------------- */
  /*                            Master Public Holiday                           */
  /* -------------------------------------------------------------------------- */

  function save_public_hdr($data)
  {
    $this->db->insert($this->tbl_public_hdr, $data);
    return $this->db->insert_id();
  }

  function save_public_dtl($data)
  {
    $this->db->insert($this->tbl_public_dtl, $data);
    return $this->db->affected_rows();
  }

  function get_public_hdr($id)
  {
    $this->db->select('*');
    $this->db->from($this->tbl_public_hdr);
    $this->db->where('id_public_hdr', $id);
    return $this->db->get()->row();
  }

  function get_public_dtl($id)
  {
    $this->db->select('*');
    $this->db->from($this->tbl_public_dtl);
    $this->db->where('id_public_hdr', $id);
    return $this->db->get()->result();
  }

  function find_public_filter($current_year)
  {
    $this->db->select('*');
    $this->db->from($this->tbl_public_hdr);
    $this->db->where('current_date =', $current_year);
    return $this->db->get()->result();
  }

  function delete_public($id)
  {
    $this->db->where('id', $id);
    $this->db->delete($this->tbl_public_hdr);
    return $this->db->affected_rows();
  }

  function delete_multiple_public_dtl($data)
  {
    $this->db->where_in('id_public_dtl', $data);
    $this->db->delete($this->tbl_public_dtl);
    return $this->db->affected_rows();
  }

  public function save_public_holiday($data)
  {
    $this->db->insert($this->tbl_public_holiday, $data);
    return $this->db->affected_rows();
  }

  public function public_holiday()
  {
    $this->db->select('*');
    $this->db->from($this->tbl_public_holiday);
    $this->db->order_by('date_holiday', 'asc');
    return $this->db->get()->result();
  }

  public function public_holiday_by_id($id)
  {
    $this->db->select('*');
    $this->db->from($this->tbl_public_holiday);
    $this->db->where('public_holiday_id', $id);
    return $this->db->get()->row();
  }

  public function update_public_holiday($data, $id)
  {
    $this->db->where('public_holiday_id', $id);
    $this->db->update($this->tbl_public_holiday, $data);
    return $this->db->affected_rows();
  }

  public function public_holiday_delete($id)
  {
    $this->db->where('public_holiday_id', $id);
    $this->db->delete($this->tbl_public_holiday);
    return $this->db->affected_rows();
  }

  public function tampil_get_public($period)
  {
    $sql_product = $this->db->query("select * from zhl_tims_mst_public_holiday WHERE date_holiday like '%$period%'");

    if ($sql_product->num_rows() > 0) {
      foreach ($sql_product->result() as $data) {
        $hasil[] = $data;
      }
      return $hasil;
    }
  }

  /* -------------------------------------------------------------------------- */
  /*                             End Public Holiday                             */
  /* -------------------------------------------------------------------------- */


  // Menyimpan satu baris detail
  public function save_job_dtl_single($data) {
      $this->db->insert($this->tbl_job_dtl, $data);
      return $this->db->insert_id();
  }

  // Mendelete satu charge
  public function delete_job_charges($id_job_dtl)
  {
      return $this->db->delete('zhl_tims_tbl_trn_job_dtl_sub', ['id_job_dtl' => $id_job_dtl]);
  }

  // Menyimpan satu charge
  public function save_job_charge($data) {
      return $this->db->insert('zhl_tims_tbl_trn_job_dtl_sub', $data);
  }

  function get_job_charges_by_dtl($id)
  {
    $sql = $this->db->query("SELECT A.id_job_hdr,A.id_job_dtl,A.job_price_id,B.driver_wages 
      FROM zhl_tims_tbl_trn_job_dtl_sub AS A JOIN zhl_tims_mst_driver_price AS B 
      ON A.job_price_id=B.job_price_id WHERE A.id_job_dtl ='$id'");
    return $sql->result();
  }
}
