<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Tims_mon extends CI_Controller
{
  function __construct()
  {
    parent::__construct();
    $this->load->model(array('m_shipping', 'm_shipping_mon', 'M_Tims', 'm_tims'));
    $this->load->library('PHPExcel');


    if (!$this->session->userdata('userid_1')) {
      redirect('login');
    }
  }

  function mon_summary_job()
  {
    $data = array(

      'message'               => '',
      'current_date'        => date('d/m/Y'),
      'ship_date1'          => date('01/m/Y'),
      'ship_date2'          => date('t/m/Y'),
    );
    $this->template->display('shipping/Tims/monitoring/summary_job', $data);
  }


  function mon_summary_job_filter()
  {
    $record = $this->m_tims->tampil_summary_job_filter();
    $data = array(
      'summary_job'    => $record,
    );

    $this->load->view('shipping/Tims/monitoring/summary_job_filter', $data);
  }

  function mon_driver_job()
  {
    $data = array(

      'current_date'          => date('d/m/Y'),
      'schedule_date1'        => date('01/m/Y'),
      'schedule_date2'        => date('t/m/Y'),
      'message'               => '',
      'cbo_driver'            => $this->m_tims->get_driver(),
      'id_driver'              => '',

    );
    $this->template->display('shipping/Tims/monitoring/mon_driver_job', $data);
  }

  function monitor_filtered()
  {
    $record = $this->m_tims->monitor_filter();
    $customer = $this->m_tims->customer();
    $data = array(
      'record_mon'    => $record,
      'customer'      => $customer,
    );
    $this->load->view('shipping/Tims/monitoring/driver_job_filter', $data);
  }

  function batch_print()
  {
    $si_count   = count($this->input->post('chk_si'));
    $detail_id    = $this->input->post('chk_si');


    $a = 0;
    $total_si = 0;
    $selected_si = array();
    if (!empty($detail_id)) {
      for ($i = 0; $i < $si_count; $i++) {
        if (isset($detail_id[$i])) {
          array_push($selected_si, $detail_id[$a]);
          $a++;
          $total_si++;
        }
      }
    }

    if ($total_si > 0) {
      $rec_hdr    = array();


      for ($i = 0; $i < $total_si; $i++) {
        $dtl_id          = $selected_si[$i];
        $rec_hdr[$i]     = $this->m_tims->get_job_driver($dtl_id);
        // $Drivername    = $rec_hdr[$i]->driver_name;
        // $vehicleNo    = $rec_hdr[$i]->vehicle_no;

      }
      $Drivername   = $rec_hdr[$total_si - 1]->driver_name;
      $vehicleNo    = $rec_hdr[$total_si - 1]->vehicle_no;


      $data = array(
        'driver_name'   => $Drivername,
        'vehicle_no'    => $vehicleNo,
        'data_job'      => $rec_hdr,
        'total_si'      => $total_si,
      );

      // var_dump($data['driver_name']);
      // die;
      $this->load->view('shipping/Tims/monitoring/print_job_driver', $data);
    } else {
      echo '<script>alert("Please select at least one checkbox.");</script>';
    }
  }
}
