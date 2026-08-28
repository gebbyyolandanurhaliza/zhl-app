<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Tims extends CI_Controller
{

  function __construct()
  {
    parent::__construct();

    $this->load->model(array('M_Tims', 'm_tims', 'M_Receivable_recognition', 'M_login', 'M_mar_master'));
    $this->load->library(array('template', 'user_agent'));

    if (!$this->session->userdata('userid_1')) {
      redirect('login');
    }
  }

  public function job_add()
  {
    $prices =  $this->m_tims->prices();
    $data = [
      'header_title'    => 'Form Job Driver',
      'button'          => '<i class="fa fa-save fa-3x fa-fw"></i> Save',
      'current_date'    => set_value('current_date', date('d/m/Y'), true),
      'date_picker'     => 'date-picker',
      'action'          => site_url('tims/job_save_new'),
      'prices'          => $prices,
      'customer'        => $this->m_tims->customer(),
      'vehicle'         => $this->m_tims->get_vehicle2(),
      'trigger'         => 'create'
    ];

    $this->template->display('shipping/Tims/job_list/input_job_new', $data);
  }

  public function job_save_new()
  {
    $data = $this->input->post(null, true);
    $createdby = strtoupper($this->session->userdata('userid_1'));
    $createddate = date('Y-m-d H:i:s');

    $cek = $this->m_tims->current_date_cek(convert_tgl_db_2($data['current_date']));

    if ($cek) {
      $this->session->set_flashdata('message', pesan('Current Date Your Choose Has Been Add !', pesan_error()));
      redirect(site_url('tims/job-add'));
    }

    $data_hdr = [
      'current_date' => convert_tgl_db_2($data['current_date']),
      'createdby' => $createdby,
      'createddate' => $createddate
    ];

    $id_job_hdr = $this->m_tims->save_job_hdr($data_hdr);

    
    for ($i = 0; $i < count($data['client_id']); $i++) {

      // get driver id from vehicle
      $id_driver = $this->m_tims->get_item_vehicle($data['id_vehicle'][$i])->id_driver;

      $data_dtl = [
        'job'         => $data['job'][$i],
        'id_vehicle'  => $data['id_vehicle'][$i],
        'id_driver'   => $id_driver,
        'id_job_hdr'  => $id_job_hdr,
        'time'        => $data['time'][$i],
        'status'      => 'Waiting',
        'send_to'     => $data['send_to'][$i],
        'client_id'   => $client_id,
        'status_cont' => $data['status_cont'][$i],
        'createdby'   => $createdby,
        'createddate' => $createddate,
      ];

      $id_job_dtl = $this->m_tims->save_job_dtl_single($data_dtl);

      // Simpan charges (jika ada)
      if (isset($data['charges'][$i])) {
          foreach ($data['charges'][$i] as $charge_code) {
              $charge_dtl = [
                  'id_job_dtl' => $id_job_dtl,
                  'id_job_hdr' => $id_job_hdr,
                  'job_price_id' => $charge_code
              ];
              $this->m_tims->save_job_charge($charge_dtl); // buat fungsi simpan per charge
          }
      }
    }

    redirect(site_url('tims/job-edit/' . $id_job_hdr));
  }

  public function job_update_new($id)
  {
    $data = $this->input->post(null, true);
    $createdby = strtoupper($this->session->userdata('userid_1'));
    $createddate = date('Y-m-d H:i:s');

    // update header
    $data_hdr = [
      'updatedby' => $createdby,
      'updateddate' => $createddate
    ];

    $this->m_tims->update_job_hdr($data_hdr, $id);

    

    for ($i = 0; $i < count($data['client_id']); $i++) {

      // get driver id from vehicle
      $id_driver = $this->m_tims->get_item_vehicle($data['id_vehicle'][$i])->id_driver;

      if (isset($data['id_job_dtl'][$i])) {

        // check dtl_id ada atau tidak
        $dtl = $this->m_tims->get_job_dtl_id($data['id_job_dtl'][$i]);
        if ($dtl) {
          $data_dtl_update = [
            'id_job_dtl'  => $data['id_job_dtl'][$i],
            'id_vehicle'  => $data['id_vehicle'][$i],
            'job'         => $data['job'][$i],
            'id_job_hdr'  => $id,
            'id_driver'   => $id_driver,
            'time'        => $data['time'][$i],
            'status_cont' => $data['status_cont'][$i],
            'send_to'     => $data['send_to'][$i],
            'client_id'   => $data['client_id'][$i],
            'updatedby'   => $createdby,
            'updateddate' => $createddate,
          ];

         $this->m_tims->update_job_dtl_nobatch($data['id_job_dtl'][$i],$data_dtl_update);

          // ✅ INSERT new charges if any
          if (isset($data['charges'][$i])) {
            // DELETE all old charges first
            $this->m_tims->delete_job_charges($data['id_job_dtl'][$i]);
              foreach ($data['charges'][$i] as $charge_code) {
                  $this->m_tims->save_job_charge([
                      'id_job_dtl'   => $data['id_job_dtl'][$i],
                      'id_job_hdr'   => $id,
                      'job_price_id' => $charge_code
                  ]);
              }
          }
        }
      } else {
        $data_dtl_insert = [
          'id_vehicle'  => $data['id_vehicle'][$i],
          'job'         => $data['job'][$i],
          'id_job_hdr'  => $id,
          'id_driver'   => $id_driver,
          'time'        => $data['time'][$i],
          'status'      => 'Waiting',
          'send_to'     => $data['send_to'][$i],
          'client_id'      => $data['client_id'][$i],
          'status_cont' => $data['status_cont'][$i],
          'createdby'   => $createdby,
          'createddate' => $createddate,
        ];
        $id_job_dtl = $this->m_tims->save_job_dtl_single($data_dtl_insert);

        if (isset($data['charges'][$i])) {
            foreach ($data['charges'][$i] as $charge_code) {
                $this->m_tims->save_job_charge([
                    'id_job_dtl'   => $id_job_dtl,
                    'id_job_hdr'   => $id,
                    'job_price_id' => $charge_code
                ]);
            }
        }
      }
    }

    redirect(site_url('tims/job-edit/' . $id));
  }

  public function select()
  {
    $data['vehicle'] = $this->m_tims->get_vehicle2();
    $data['customer'] = $this->m_tims->customer();
    echo json_encode($data);
  }

  public function job_save()
  {
    $data = $this->input->post(null, true);
    $createdby = strtoupper($this->session->userdata('userid_1'));
    $createddate = date('Y-m-d H:i:s');

    // validasi tanggal yang sama tidak bolehh
    $cek = $this->m_tims->current_date_cek(convert_tgl_db_2($data['current_date']));

    if ($cek) {
      $this->session->set_flashdata('message', pesan('Current Date Your Choose Has Been Add !', pesan_error()));
      redirect(site_url('tims/job-add'));
    }

    $data_hdr = [
      'current_date' => convert_tgl_db_2($data['current_date']),
      'createdby' => $createdby,
      'createddate' => $createddate
    ];

    $id_job_hdr = $this->m_tims->save_job_hdr($data_hdr);

    $data_dtl = [];
    for ($i = 0; $i < count($data['client_id']); $i++) {

      // get driver id from vehicle
      $id_driver = $this->m_tims->get_item_vehicle($data['id_vehicle'][$i])->id_driver;

      $data_dtl[] = [
        'job'         => $data['job'][$i],
        'id_vehicle'  => $data['id_vehicle'][$i],
        'id_driver'   => $id_driver,
        'id_job_hdr'  => $id_job_hdr,
        'time'        => $data['time'][$i],
        'status'      => 'Waiting',
        'send_to'     => $data['send_to'][$i],
        'client_id'  => $data['client_id'][$i],
        'status_cont' => $data['status_cont'][$i],
        'createdby'   => $createdby,
        'createddate' => $createddate,
      ];
    }

    $save_dtl = $this->m_tims->save_job_dtl($data_dtl);

    if (!$save_dtl) {
      $this->session->set_flashdata('message', pesan('Save Driver Job', pesan_error()));
    } else {
      $this->session->set_flashdata('message', pesan('Save Driver Job', pesan_sukses()));
    }
    redirect(site_url('tims/job-edit/' . $id_job_hdr));
  }

  public function job_edit($id)
  {
    // get data
    $header = $this->m_tims->get_job_hdr($id);
    $dtl = $this->m_tims->get_job_dtl($id);

    if (!$header) {
      redirect(site_url('tims/job-add'));
    }

    $vehicle = $this->m_tims->get_vehicle2();
    $customers = $this->m_tims->customer();
    $prices =  $this->m_tims->prices();
    $data = [
      'header_title'    => 'Form Job Driver',
      'current_date'    => set_value('current_date', convert_tgl_2($header->current_date), true),
      'date_picker'     => '',
      'button'          => '<i class="fa fa-save fa-3x fa-fw"></i> Update',
      'action'          => site_url('tims/job_update_new/' . $id),
      'dtl'             => $dtl,
      'vehicle'         => $vehicle,
      'customers'       => $customers,
      'prices'         => $prices,
      'trigger'         => 'edit',
    ];

    foreach ($data['dtl'] as $row) {
        $row->charges = $this->m_tims->get_job_charges_by_dtl($row->id_job_dtl);
    }

    $this->template->display('shipping/Tims/job_list/input_job_new', $data);
  }

  public function job_update($id)
  {
    $data = $this->input->post(null, true);
    $createdby = strtoupper($this->session->userdata('userid_1'));
    $createddate = date('Y-m-d H:i:s');

    // hapus data yang sudah ditekan tombol hapusnya
    // $dtl = $this->m_tims->get_job_dtl($id);

    // $id_dtl_old = [];

    // if ($dtl) {
    //   foreach ($dtl as $val) {
    //     $id_dtl_old[] = $val->id_job_dtl;
    //   }
    // }

    // if (isset($data['id_job_dtl'])) {
    //   $remove_id = array_diff($id_dtl_old, $data['id_job_dtl']);
    // } else {
    //   $remove_id = $id_dtl_old;
    // }

    // $data_log = [];
    // if ($remove_id) {

    //   foreach ($remove_id as $rmid) {
    //     $rmdata = $this->m_tims->get_job_dtl_id($rmid);
    //     $rmdata->deletedby =  strtoupper($this->session->userdata('userid_1'));
    //     $rmdata->deleteddate = date('Y-m-d H:i:s');
    //     $data_log[] = $rmdata;
    //   }
    //   // save_to_log
    //   if ($data_log) {
    //     $this->m_tims->insert_log_delete_dtl($data_log);
    //   }

    //   $delete_row = $this->m_tims->delete_multiple_job_dtl($remove_id);
    // }

    // update header
    $data_hdr = [
      'updatedby' => $createdby,
      'updateddate' => $createddate
    ];

    $this->m_tims->update_job_hdr($data_hdr, $id);

    $data_dtl_insert = [];
    $data_dtl_update = [];

    for ($i = 0; $i < count($data['client_id']); $i++) {

      // get driver id from vehicle
      $id_driver = $this->m_tims->get_item_vehicle($data['id_vehicle'][$i])->id_driver;

      if (isset($data['id_job_dtl'][$i])) {

        // check dtl_id ada atau tidak
        $dtl = $this->m_tims->get_job_dtl_id($data['id_job_dtl'][$i]);
        if ($dtl) {
          $data_dtl_update[] = [
            'id_job_dtl'  => $data['id_job_dtl'][$i],
            'id_vehicle'  => $data['id_vehicle'][$i],
            'job'         => $data['job'][$i],
            'id_job_hdr'  => $id,
            'id_driver'   => $id_driver,
            'time'        => $data['time'][$i],
            'status_cont' => $data['status_cont'][$i],
            // 'status'      => 'Waiting',
            'send_to'     => $data['send_to'][$i],
            'client_id'   => $data['client_id'][$i],
            'updatedby'   => $createdby,
            'updateddate' => $createddate,
          ];
        }
      } else {
        $data_dtl_insert[] = [
          'id_vehicle'  => $data['id_vehicle'][$i],
          'job'         => $data['job'][$i],
          'id_job_hdr'  => $id,
          'id_driver'   => $id_driver,
          'time'        => $data['time'][$i],
          'status'      => 'Waiting',
          'send_to'     => $data['send_to'][$i],
          'client_id'      => $data['client_id'][$i],
          'status_cont' => $data['status_cont'][$i],
          'createdby'   => $createdby,
          'createddate' => $createddate,
        ];
      }
    }

    if (!empty($data_dtl_insert)) {
      $save = $this->m_tims->save_job_dtl($data_dtl_insert);
    }

    if (!empty($data_dtl_update)) {
      $update = $this->m_tims->update_job_dtl($data_dtl_update);
    }

    if ($save || $update) {
      $this->session->set_flashdata('message', pesan('Update Driver Job', pesan_sukses()));
    }

    redirect(site_url('tims/job-edit/' . $id));
  }

  function findJob()
  {
    $current_date_start = $this->input->get('current_date_start');
    $current_date_end = $this->input->get('current_date_end');

    if ($current_date_start == "" || $current_date_end == "") {
      echo false;
      exit();
    }

    $search = $this->m_tims->find_job_filter(convert_tgl_db_2($current_date_start), convert_tgl_db_2($current_date_end));

    if (!$search) {
      echo false;
      exit();
    }

    $data['search'] = $search;
    $this->load->view('shipping/Tims/job_list/filter', $data);
  }

  function delete_job_dtl()
  {
    $id = $this->input->post('id');

    $dtls = $this->m_tims->get_job_dtl_id($id);
    $dtls->deletedby =  strtoupper($this->session->userdata('userid_1'));
    $dtls->deleteddate = date('Y-m-d H:i:s');

    $this->m_tims->insert_log_delete_dtl_no_batch($dtls);

    $delete = $this->m_tims->delete_job_dtl($id);

    if ($delete) {
      $msg = 'success';
    } else {
      $msg = 'error';
    }

    $row = [
      'msg' => $msg,
    ];

    echo json_encode($row);
  }

  function restore_job_dtl()
  {
    $id = $this->input->post('id');

    $data['restoreby'] =  strtoupper($this->session->userdata('userid_1'));
    $data['restoredate'] = date('Y-m-d H:i:s');
    $data['status'] = 'Progress';

    $update = $this->m_tims->update_job_dtl_nobatch($id,$data);

    if ($update) {
      $msg = 'success';
      $this->session->set_flashdata('message', pesan('Restore Job Driver', pesan_sukses()));
    } else {
      $msg = 'error';
    }

    $row = [
      'msg' => $msg,
    ];

    echo json_encode($row);
  }

  function job_delete($id)
  {
    // find header
    $hdr = $this->m_tims->get_job_hdr($id);
    // insert to log
    $hdr->deletedby =  strtoupper($this->session->userdata('userid_1'));
    $hdr->deleteddate = date('Y-m-d H:i:s');

    $this->m_tims->insert_log_delete_hdr($hdr);

    // find dtl
    $data_log = [];
    $dtls = $this->m_tims->get_job_dtl($id);

    if ($dtls) {
      foreach ($dtls as $key => $dtl) {
        $dtl->deletedby =  strtoupper($this->session->userdata('userid_1'));
        $dtl->deleteddate = date('Y-m-d H:i:s');
        $data_log[] = $dtl;
      }
    }

    if ($data_log) {
      $this->m_tims->insert_log_delete_dtl($data_log);
    }

    $delete = $this->m_tims->delete_job($id);

    if (!$delete) {
      $this->session->set_flashdata('message', pesan('Delete Driver Job', pesan_error()));
    } else {
      $this->session->set_flashdata('message', pesan('Delete Driver Job', pesan_sukses()));
    }

    redirect(site_url('tims/job-add'));
  }

  public function filter(){

    $date = $this->input->get('tgl');
     // Create a DateTime object from the original date string
    $dateTime = DateTime::createFromFormat('d/m/Y', $date);

    // Format the date to the desired format
    $tgl = $dateTime->format('Y-m-d');
    $vehicle = $this->input->get('vehicle');

    $header = $this->M_Tims->get_job_hdr_tgl($tgl);

    $data['dtl'] = $this->M_Tims->get_job_dtl_vehicle($header->id_job_hdr,$vehicle);

    $this->load->view('shipping/Tims/driver/filter', $data); 
  }
}
