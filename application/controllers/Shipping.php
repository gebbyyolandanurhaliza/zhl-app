<?php
defined('BASEPATH') or exit('No direct script access allowed');

class shipping extends CI_Controller
{

  function __construct()
  {
    parent::__construct();
    $this->load->model(array('m_shipping', 'm_purchasing'));
    $this->load->model('M_mar_master', 'Marketting');
    $this->load->model('M_status_container', 'StatusContainer');
    define('FPDF_FONTPATH',  $this->config->item('fonts_path'));
    $this->load->library(array('Fpdf', 'PHPExcel'));

    if (!$this->session->userdata('userid_1')) {
      redirect('login');
    }
    error_reporting(1);
  }

  function test()
  {
    $param = [
      "shipment_date" => "2023-01-03",
      "eta" => "rsup",
    ];

    $data = $this->m_shipping->getTrackContainer($param);

    echo "<pre>";
    print_r($data);
    echo "</pre>";
  }

  //=============================About Comeback Epic
  public function comeback_container_stock()
  {
    $data['cont']     =  $this->m_shipping->tampil_cont_stock();
    $data['year']     =  $this->m_shipping->tampil_year();
    $data['port']     =  $this->m_shipping->tampil_port();
    $data['supplier']     =  $this->m_shipping->tampil_supplier();
    $data['container_number'] = $this->m_shipping->tampil_factory_stock_container_comeback();
    $this->template->display('shipping/container_stock_comeback_list', $data);
  }

  function mon_container_stock_filter()
  {
      $factory = $this->input->get('factory');
      $supplier = $this->input->get('supplier');
      $loading_port = $this->input->get('loading_port');
      $year = $this->input->get('year');
      $month = $this->input->get('month');
      $container = $this->input->get('container');
      
      $data['shipping_liner'] =  $this->m_shipping->tampil_container_stock_filter($factory, $supplier, $loading_port,$year,$month, $container);
      $this->load->view('shipping/container_stock_comeback_list_ajax', $data);
  }
  //    ------------------------------------------------------------------About Shipping Line--------------------------------------------------------
  public function shipping_liner()
  {
    $data['shipping_liner'] =  $this->m_shipping->tampil_shipping_liner();

    $this->template->display('shipping/mstshipping_line', $data);
  }

  public function shipping_liner_show()
  {
    $data['shipping_liner'] =  $this->m_shipping->tampil_shipping_liner_where($this->input->get('line'));

    $this->template->display('shipping/mstshipping_line_show', $data);
  }

  public function shipping_liner_save()
  {
    $shippingid     =  $this->input->post('shippingid');
    $shippingname   =  $this->input->post('shippingname');
    $shippingtipe   =  $this->input->post('shippingtipe');

    if ($shippingid == '') {
      $data = array('shipping_name' => $shippingname, 'shipping_tipe' => $shippingtipe, 'createdby' => strtoupper($this->session->userdata('userid_1')), 'createddate' => date('Y-m-d H:i:s'));
      $this->m_shipping->simpan_shipping_liner($data);
      $message = 'Save Data Success';
    } else {
      $data   = array('shipping_name' => $shippingname, 'shipping_tipe' => $shippingtipe, 'lastupdatedby' => strtoupper($this->session->userdata('userid_1')), 'lastupdateddate' => date('Y-m-d H:i:s'));
      $this->m_shipping->update_shipping_liner($shippingid, $data);
      $message = 'Update Data Success';
    }

    $this->session->set_flashdata("message", "<div class=\"alert alert-success\" id=\"alert\">$message</div>");
    redirect('shipping/shipping_liner');
  }

  public function shipping_liner_delete()
  {
    $this->m_shipping->delete_shipping_liner($this->input->get('line'));

    $this->session->set_flashdata("message", "<div class=\"alert alert-danger\" id=\"alert\">Delete Data Success</div>");
    redirect('shipping/shipping_liner');
  }

  //------------------------Modul Container Actual Seal----------------------------------------
  public function container_actual_seal()
  {
    $data['container_inward'] = $this->m_shipping->tampil_cont_actual_seal();
    $this->template->display('shipping/container_actual_seal', $data);
  }

  public function container_actual_seal_show()
  {

    $cont        = $this->input->get('cont');
    $factory     = $this->input->get('factory');
    $shipmentdate = date('Y-m-d', strtotime($this->input->get('shipmentdate')));

    if ($factory == 'RSUP') {
      $cont     = $this->m_shipping->tampil_cont_where_actual_seal($this->input->get('cont'));
      foreach ($cont as $d) {
        $data['cont'][] = array_merge((array)$d, ['act_seal' => $this->CurlGet('Solas/getDataActualSealByShipmentDate', json_encode(['poNumber' => '' . $d->po_number . '']), $factory)]);
      }

      $this->template->display('shipping/container_list_show_actual_seal', $data);
    } else if ($factory == 'PSG') {
      $cont            = $this->m_shipping->tampil_cont_where_actual_seal($this->input->get('cont'));
      foreach ($cont as $d) {
        $data['cont'][] = array_merge((array)$d, ['act_seal' => $this->CurlGet('Solas/getDataActualSealByShipmentDate', json_encode(['poNumber' => '' . $d->po_number . '']), $factory)]);
      }

      //  echo "<pre>";
      // print_r($data);
      // die;
      $this->template->display('shipping/container_list_show_actual_seal', $data);
    } else {
      $data['cont'] =  $this->m_shipping->tampil_cont_where_actual_seal($this->input->get('cont'));
      // $data['_dataparse'] = '';
      $this->template->display('shipping/container_list_show_actual_seal', $data);
    }
  }

  public function container_actual_seal_save()
  {
    $id             = $this->input->post('id');
    $contid         = $this->input->post('contid');
    $actual_seal    = $this->input->post('actual_seal');
    $seal           = $this->input->post('seal');
    $actual_seal1   = $this->input->post('actual_seal1');
    $sample         = $this->input->post('sample');
    $factory        = $this->input->post('etd');
    $container      = $this->input->post('container');
    $orang_terakhir = strtoupper($this->session->userdata('userid_1'));
    $tanggal        = date('Y-m-d H:i:s');
    $jumlah         = count($id);


    // print_r($factory);
    // die;
    $this->m_shipping->simpan_actual_seal($id, $contid, $actual_seal, $seal, $actual_seal1, $sample, $factory, $container, $orang_terakhir, $tanggal, $jumlah);

    // redirect('shipping/container_actual_seal_show');
    $this->session->set_flashdata("message", "<div class=\"alert alert-success\" id=\"alert\">Transaction Success</div>");
    redirect('shipping/container_actual_seal_show?cont=' . $contid . '&factory=' . $factory);
  }

  //    ------------------------------------------------------------------About Port--------------------------------------------------------
  public function port()
  {
    $data['port']     =  $this->m_shipping->tampil_port();
    $data['country']  =  $this->m_purchasing->tampil_country();

    $this->template->display('shipping/mstport', $data);
  }

  public function port_show()
  {
    $data['port']      =  $this->m_shipping->tampil_port_where($this->input->get('port'));
    $data['country']   =  $this->m_purchasing->tampil_country();

    $this->template->display('shipping/mstport_show', $data);
  }

  public function port_save()
  {
    $portid     =  $this->input->post('portid');
    $portcode   =  $this->input->post('code');
    $portname   =  $this->input->post('name');
    $country    =  $this->input->post('country');

    if ($portid == '') {
      $data = array('port_code' => $portcode, 'port_name' => $portname, 'country_ids' => $country, 'created_by' => strtoupper($this->session->userdata('userid_1')), 'created_date' => date('Y-m-d H:i:s'));
      $this->m_shipping->simpan_port($data);
      $message = 'Save Data Success';
    } else {
      $data = array('port_code' => $portcode, 'port_name' => $portname, 'country_ids' => $country, 'updated_by' => strtoupper($this->session->userdata('userid_1')), 'updated_date' => date('Y-m-d H:i:s'));
      $this->m_shipping->update_port($portid, $data);
      $message = 'Update Data Success';
    }

    $this->session->set_flashdata("message", "<div class=\"alert alert-success\" id=\"alert\">$message</div>");
    redirect('shipping/port');
  }

  public function port_delete()
  {
    $this->m_shipping->delete_port($this->input->get('port'));

    $this->session->set_flashdata("message", "<div class=\"alert alert-danger\" id=\"alert\">Delete Data Success</div>");
    redirect('shipping/port');
  }

  //---ABOUT Container Outward------------
  public function container()
  {
    $data['supp']           = $this->m_shipping->tampil_customer();
    $data['ven']            = $this->m_shipping->get_supplier();
    $data['depot']          = $this->m_shipping->get_depot();
    $data['container_name'] = $this->m_shipping->tampil_container_stock_modal($this->input->get('container_name'));
    $data['factory']        = $this->m_shipping->tampil_factory();

    $this->template->display('shipping/container_list', $data);
  }

  public function containerDev()
  {
    $data['supp']          = $this->m_shipping->tampil_customer();
    $data['ven']           = $this->m_shipping->get_supplier();
    $data['depot']         = $this->m_shipping->get_depot();
    $data['container_name'] = $this->m_shipping->tampil_container_stock_modal($this->input->get('container_name'));
    $data['factory']        = $this->m_shipping->tampil_factory();

    $this->template->display('shipping/container_list2', $data);
  }

  public function local_container()
  {
    $data['container_number'] = $this->m_shipping->tampil_factory_local_container_list();
    $this->template->display('shipping/local_container_list', $data);
  }

  public function container_po()
  {
    $data['po'] = $this->m_shipping->tampil_po($this->input->get('fac'), $this->input->get('schedule'), $this->input->get('po'));
    $this->load->view('shipping/container_list_po', $data);
  }


  public function container_po_outward()
  {
    $data['po'] = $this->m_shipping->tampil_po_outward($this->input->get('po_cout'));
    $this->load->view('shipping/container_list_po_outward', $data);
  }

  public function container_stock_choice()
  {
    $data['stock'] = $this->m_shipping->tampil_factory_stock_container_inward($this->input->get('stock'), $this->input->get('pete'));
    $this->load->view('shipping/container_stock_list_edit', $data);
  }

  public function container_modal_delete()
  {
    $data['cont'] =  $this->m_shipping->tampil_cont_where($this->input->get('delete'));
    $this->load->view('shipping/container_list_modal_delete', $data);
  }

  public function container_containeroutward()
  {
    $data['cont'] =  $this->m_shipping->tampil_cont_outward($this->input->get('cout'));
    $this->load->view('shipping/container_list_outward', $data);
  }

  public function container_containerall()
  {
    $data['cont'] =  $this->m_shipping->tampil_cont($date = $this->input->get('dt'), $this->input->get('call'));
    $this->load->view('shipping/container_list_all', $data);
  }

  public function container_show()
  {
    $getID = $this->input->get('cont');
    $tipe  = $this->input->get('tipe');


    $data['getship2']       = $this->m_shipping->getshipinward();
    $data['getship1']       = $this->m_shipping->getshipoutward();
    $data['factory']        = $this->m_shipping->tampil_factory();
    $data['cont_header']    = $this->m_shipping->tampil_cont_hdr($getID);
    $data['cont']           = $this->m_shipping->tampil_cont_where($getID);
    $data['cont_local']     = $this->m_shipping->tampil_cont_local_where($getID);

    $data['cont_ggfs']      = $this->m_shipping->tampil_cont_where_ggfs($getID);

    // echo json_encode($data['cont_local']);
    // die;
    // $data['cont_local_ready_in_zhl']     = $this->m_shipping->tampil_cont_local_read_zhl($getID);

    $data['supp']           = $this->m_shipping->tampil_customer();
    $data['ven']            = $this->m_shipping->get_supplier();
    $data['depot']          = $this->m_shipping->get_depot();
    $data['container_name'] = $this->m_shipping->tampil_container_stock_modal($this->input->get('container_name'));

    $data['contid']  = $getID;
    $data['tipe']  = $tipe;

    if ($tipe == 1) {
      $this->template->display('shipping/container_list_show', $data);
    } elseif ($tipe == 2) {
      $this->template->display('shipping/container_list_show1', $data);
    } else {
      $this->template->display('shipping/local_container_list_show', $data);
    }
  }

  // public function container_show_test()
  // {
  //     $getID = $this->input->get('cont');
  //     $tipe  = $this->input->get('tipe');

  //     $test  = $this->m_shipping->tampil_cont_hdr($getID);

  //     print_r($test);
  // }

  public function sendto_flowcharges()
  {
    $id = $this->input->get('id');

    $container = $this->m_shipping->container_inward_byid($id);

    $data =  ["formData" => [["containerNumber" => $container->container]], "uploadType" => "FORM_BY_CONTAINER_NUMBER"];

    try {
      $curl = curl_init();
      curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://connect.cargoes.com/flow/api/public_tracking/v1/createShipments',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => json_encode($data),
        CURLOPT_HTTPHEADER => array(
          'X-DPW-ApiKey: dL6SngaHRXZfvzGA716lioRD7ZsRC9hs',
          'X-DPW-Org-Token: YbsLUzbwhjq3IkfkfKaVLdOrrnosEd8F',
          'Content-Type: application/json'
        ),
      ));

      $response = curl_exec($curl);
      curl_close($curl);

      $res_dec = json_decode($response);

      if ($res_dec->result == 'SUCCESS') {
        $this->m_shipping->setflag_flowcharges($id);
      }

      echo $response;
    } catch (\Throwable $th) {
      echo json_encode($th);
    }
  }

  public function sendto_flowcargoes_all()
  {
    $contid = $this->input->get('contid');
    $cont = $this->m_shipping->get_container($contid);

    if ($cont) {
      $count = 0;

      foreach ($cont as $value) {

        if ($value->container != '') {
          if ($count  >= 10) {
            break;
          }
          $data =  ["formData" => [["containerNumber" => $value->container]], "uploadType" => "FORM_BY_CONTAINER_NUMBER"];
          $res = $this->insert_flowcargoes($data);
          $res_array = json_decode($res);
          if ($res_array->result == 'SUCCESS') {
            $this->m_shipping->setflag_flowcharges($value->detail_id);
            $count++;
          }
        }
      }

      if ($count > 0) {
        echo json_encode(['result' => 'SUCCESS']);
      } else {
        echo json_encode(['result' => 'ERROR']);
      }
    } else {
      echo json_encode(['result' => 'NO DATA TO SYNC']);
    }
  }

  public function sendto_flowcargoes_bycheck()
  {

    $detailid = $this->input->get('detailid');
    $remove_ = substr($detailid, 0, -1);
    $ex_id = explode('-', $remove_);
    $count = 0;

    foreach ($ex_id as $value) {
      $cont = $this->m_shipping->get_containerdetailid($value);
      if ($cont->container != '') {
        $data =  ["formData" => [["containerNumber" => $cont->container]], "uploadType" => "FORM_BY_CONTAINER_NUMBER"];
        $res = $this->insert_flowcargoes($data);
        $res_array = json_decode($res);
        if ($res_array->result == 'SUCCESS') {
          $this->m_shipping->setflag_flowcharges($cont->detail_id);
          $count++;
        }
      }
    }

    if ($count > 0) {
      echo json_encode(['result' => 'SUCCESS']);
    } else {
      echo json_encode(['result' => 'ERROR']);
    }
  }


  private function insert_flowcargoes($data)
  {

    try {
      $curl = curl_init();
      curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://connect.cargoes.com/flow/api/public_tracking/v1/createShipments',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => json_encode($data),
        CURLOPT_HTTPHEADER => array(
          'X-DPW-ApiKey: dL6SngaHRXZfvzGA716lioRD7ZsRC9hs',
          'X-DPW-Org-Token: YbsLUzbwhjq3IkfkfKaVLdOrrnosEd8F',
          'Content-Type: application/json'
        ),
      ));

      $response = curl_exec($curl);
      curl_close($curl);

      return $response;
    } catch (\Throwable $th) {
      return json_encode($th);
    }
  }

  public function container_show_copy()
  {
    $data['supp']           = $this->m_shipping->tampil_customer();
    $data['ven']            = $this->m_shipping->get_supplier();
    $data['depot']          = $this->m_shipping->get_depot();
    $data['container_name'] = $this->m_shipping->tampil_container_stock_modal($this->input->get('container_name'));
    $data['cont']           =  $this->m_shipping->tampil_cont_where_outward($this->input->get('cont'));
    $data['cont_ggfs']       =  $this->m_shipping->tampil_cont_where_outward_ggfs($this->input->get('cont'));
    $this->template->display('shipping/container_list_show_copy', $data);
  }

  public function container_save($trans)
  {
    // echo json_encode($this->input->post());
    // die;
    $contid            = $this->input->post('contid');
    $tipe              = $this->input->post('tipe');
    $shipment          = $this->convert($this->input->post('shipdate'));
    $barge             = $this->input->post('barge');
    $voyage            = $this->input->post('voyage');
    $etd               = $this->input->post('etd');
    $eta               = $this->input->post('eta');
    $etddateTemp       = $this->input->post('etddate');
    $etadateTemp       = $this->input->post('etadate');
    $amendmentdateTemp = $this->input->post('amendmentdate');
    $to                = $this->input->post('to');
    $from              = $this->input->post('from');
    $remarks           = nl2br($this->input->post('remarks'));
    $is_repair         = $this->input->post('is_repair');

    //----------Inisiasi Field pada Container Stock
    $stock_id_dtl     = $this->input->post('stock_id_dtl');
    $container_number = $this->input->post('container_number');
    $container_id     = $this->input->post('container_id');
    $container_name   = $this->input->post('container_name');
    $status           = $this->input->post('status');
    //--------------------------------------------

    // echo json_encode($this->input->post());
    // die;

    if ($etddateTemp != '') {
      $etddate = $this->convert($etddateTemp);
    } else {
      $etddate = '';
    }

    if ($etadateTemp != '') {
      $etadate = $this->convert($etadateTemp);
    } else {
      $etadate = '';
    }

    if ($amendmentdateTemp != '') {
      $amendmentdate = $this->convert($amendmentdateTemp);
    } else {
      $amendmentdate = '';
    }

    $datahdr = array(
      'trans'         => $trans,
      'contid'        => $contid,
      'tipe'          => $tipe,
      'barge'         => $barge,
      'voyage'        => $voyage,
      'etd'           => $etd,
      'etddate'       => $etddate,
      'eta'           => $eta,
      'etadate'       => $etadate,
      'shipmentdate'  => $shipment,
      'from'          => $from,
      'to'            => $to,
      'amendmentdate' => $amendmentdate,
      'remarks'       => $remarks,
      'createdby'     => strtoupper($this->session->userdata('userid_1'))
    );
    $query = $this->m_shipping->simpan_cont_sp($datahdr);

    if ($query['flag'] == 1) {
      $this->session->set_flashdata("message", "<div class=\"alert alert-success\" id=\"alert\">Transaction Success</div>");
      redirect('shipping/container_show?cont=' . $query['contid'] . '&tipe=' . $tipe);
    } else {
      $this->session->set_flashdata("message", "<div class=\"alert alert-danger\" id=\"alert\">Save Transaction Broken.</div>");
      redirect('shipping/container');
    }
  }

  public function local_container_save()
  {
    $contid            = $this->input->post('contid');
    $tipe              = $this->input->post('tipe');
    $shipment          = $this->convert($this->input->post('shipdate'));
    $barge             = $this->input->post('barge');
    $voyage            = $this->input->post('voyage');
    $etd               = $this->input->post('etd');
    $eta               = $this->input->post('eta');
    $etddate           = $this->convert($this->input->post('etddate'));
    $etadate           = $this->convert($this->input->post('etadate'));
    $amendmentdateTemp = $this->input->post('amendmentdate');
    $to                = $this->input->post('to');
    $from              = $this->input->post('from');
    $remarks           = nl2br($this->input->post('remarks'));
    $id                = $this->input->post('id');
    $container_number  = $this->input->post('container_number');
    $container_id      = $this->input->post('container_id');
    $container_name    = $this->input->post('container_name');
    $loading_port      = $this->input->post('loading_port');
    $supplier          = $this->input->post('supplier');
    $customer          = $this->input->post('customer');
    $proses            = "0";
    $stuffing = $this->input->post('stuffing');


    if ($contid == '' && $id == '') {
      $data_hdr = array(
        'tipe'              => $tipe,
        'shipmentdate'      => $shipment,
        'barge'             => $barge,
        'voyage'            => $voyage,
        'etd'               => $etd,
        'etddate'           => $etddate,
        'eta'               => $eta,
        'etadate'           => $etadate,
        'from'              => $from,
        'to'                => $to
      );
      $headerid = $this->m_shipping->simpan_container_local_hdr($data_hdr);

      for ($i = 0; $i < count($container_id); $i++) {
        $data_dtl = array(
          'contid' => $headerid,
          'container_type' => $container_name[$i],
          'container_number' => $container_number[$i],
          'supplier' => $supplier[$i],
          'customer' => $customer[$i],
          'stuffing' => $stuffing[$i],
          'container_id' => $container_id[$i],
          'proses' => $proses
        );
        $this->m_shipping->simpan_container_local_dtl($data_dtl);
      }
      $message = 'Save Data Success';
    } else {
      $data_hdr = array(
        'tipe'              => $tipe,
        'shipmentdate'      => $shipment,
        'barge'             => $barge,
        'voyage'            => $voyage,
        'etd'               => $etd,
        'etddate'           => $etddate,
        'eta'               => $eta,
        'etadate'           => $etadate,
        'from'              => $from,
        'to'                => $to
      );
      $this->m_shipping->update_container_local_hdr($data_hdr, $contid);

      // echo $stock_id_hdr;
      for ($i = 0; $i < count($container_id); $i++) {
        if ($id[$i] == null) {
          $data_dtl = array(
            'contid' => $contid,
            'container_type' => $container_name[$i],
            'container_number' => $container_number[$i],
            'supplier' => $supplier[$i],
            'customer' => $customer[$i],
            'stuffing' => $stuffing[$i],
            'container_id' => $container_id[$i],
            'proses' => $proses
          );
          $this->m_shipping->simpan_container_local_dtl($data_dtl);
          // }
          $message = 'Update Data Success';
        } else {
          $data_dtl = array(
            'contid' => $contid,
            'container_type' => $container_name[$i],
            'container_number' => $container_number[$i],
            'supplier' => $supplier[$i],
            'customer' => $customer[$i],
            'stuffing' => $stuffing[$i],
            'container_id' => $container_id[$i],
            'proses' => $proses
          );
          // echo $stock_id_dtl[$i];
          $this->m_shipping->update_container_local_dtl($data_dtl, $id[$i]);
        }
        $message = 'Update Data Success';
      }
    }
    $this->session->set_flashdata("message", "<div class=\"alert alert-success\" id=\"alert\">$message</div>");
    redirect('shipping/local_container');
    //$this->session->set_flashdata("message", "<div class=\"alert alert-success\" id=\"alert\">$message</div>");
    //redirect('shipping/container_stock_edit?stock='.$stock_id_hdr);
  }


  public function container_delete()
  {
    $result = $this->m_shipping->delete_cont_sp($this->input->get('cont'));

    if ($result['flag'] == 1) {
      $this->session->set_flashdata("message", "<div class=\"alert alert-danger\" id=\"alert\">Delete Data Success</div>");
      redirect('shipping/container');
    } else {
      $this->session->set_flashdata("message", "<div class=\"alert alert-warning\" id=\"alert\">Sorry, This Data used in Another Transaction</div>");
      redirect('shipping/container');
    }
  }


  public function container_inward_edit()
  {
    $cont       = $this->input->get('container');
    $id         = $this->input->get('id');
    $tipe       = $this->input->get('tipe');
    $contid     = $this->input->get('contid');
    $idold      = $this->input->get('id');
    $idnew      = $this->input->get('idnew');
    $contstock  = $this->input->get('container');

    // // //===========Membuat Note status==================
    // // $this->m_shipping->container_stock_noted($contstock);


    // //==========Change Container pada Invoice=========
    // $data = array(
    //     'p_contid_old' => $idold,
    //     'p_contid_new' => $idnew
    // );
    // $hasil = $this->m_shipping->container_inward_changestock($id, $data);


    //==========change Container pada Container========
    $dataedit = array(
      'container' => $cont
    );
    $returndata = $this->m_shipping->inwardcontainerinward_update2($id, $dataedit);

    echo "<input type='hidden' id='hasilchange' value='$returndata->container' >";
    echo "<script>get_change($id);</script>";
  }

  function container_inward_changestock()
  {
    $cont       = $this->input->get('container');
    $id         = $this->input->get('id');
    $tipe       = $this->input->get('tipe');
    $contid     = $this->input->get('contid');
    $idold      = $this->input->get('id');
    $idnew      = $this->input->get('idnew');
    $contstock  = $this->input->get('container');
    // $container  = $_GET['container'];
    // $idold      = $_GET['idold'];
    // $idnew      = $_GET['idnew'];
    $container  = $this->input->get('container');
    $idold      = $this->input->get('idold');
    $idnew      = $this->input->get('idnew');

    $data = array(
      'p_contid_old' => $idold,
      'p_contid_new' => $idnew
    );

    $hasil = $this->m_shipping->container_inward_changestock($data);
    //echo $hasil->v_hasil;

    echo "<input type='hidden' id='hasilchange' value='$hasil->v_hasil' >";
    echo "<script>alert('$hasil->v_pesan'); get_change($idold);</script>";
    //    echo "<script>get_change($id);</script>";
  }

  function container_inward_changestock2()
  {
    $cont         = $this->input->get('container');
    $id           = $this->input->get('id');
    $tipe         = $this->input->get('tipe');
    $contid       = $this->input->get('contid');
    $idold        = $this->input->get('id');
    $idnew        = $this->input->get('idnew');
    $contstock    = $this->input->get('container');
    $container    = $this->input->get('container');
    $idold        = $this->input->get('idold');
    $idnew        = $this->input->get('idnew');
    // $container = $_GET['container'];
    // $idold     = $_GET['idold'];
    // $idnew     = $_GET['idnew'];

    $data = array(
      'p_contid_old' => $idold,
      'p_contid_new' => $idnew
    );

    $hasil = $this->m_shipping->container_inward_changestock2($data);
    echo $hasil->v_hasil;

    echo "<input type='hidden' id='hasilchange' value='$hasil->v_hasil' >";
    echo "<script>get_change($id);</script>";
    //    echo "<script>alert('$hasil->v_pesan'); get_change($idold);</script>";
  }

  /*  function container_inward_move_gagagaggagaga()
    {
        $contid = $this->input->get('shipdate');
        $outward = $this->input->get('outward');
        $inward = $this->input->get('inward');

        // $data = array(
        //     'flag' => $outward,
        //     'id' => $inward
        // );

        $this->m_shipping->containerinward_move($contid, $inward, $outward);
        //    echo $hasil->v_hasil;
        //     echo "<input type='hidden' id='hasilchange' value='$hasil->v_hasil' >";
        // //    echo "<script>alert('$hasil->v_pesan'); get_change($idold);</script>";
        //     echo "<script>get_change($id);</script>";
    }
 */

  function container_outward_move()
  {
    $contid  = $this->input->get('shipdate');
    $outward = $this->input->get('outward');
    $inward  = $this->input->get('inward');

    // $data = array(
    //     'flag' => $outward,
    //     'id' => $inward
    // );

    $this->m_shipping->containeroutward_move($contid, $inward, $outward);
    //    echo $hasil->v_hasil;
    //     echo "<input type='hidden' id='hasilchange' value='$hasil->v_hasil' >";
    // //    echo "<script>alert('$hasil->v_pesan'); get_change($idold);</script>";
    //     echo "<script>get_change($id);</script>";
  }

  function getContainerLocalInward()
  {
    $param = $this->input->post();

    $data['localContInward'] = $this->m_shipping->getContLocalInward($param);

    // echo "<pre>";
    // print_r($data);
    // echo "</pre>";
    // die;

    $this->load->view("shipping/list_cont_local_inward", $data);
  }


  //-------------------------------Modul Container Stock-------------------------------//
  public function container_stock_modal()
  {
    $data['container_name'] = $this->m_shipping->tampil_container_stock_modal($this->input->get('container_name'));
    $this->load->view('shipping/container_list_stock_modal', $data);
  }

  public function container_local_modal()
  {
    //$data['container_name']= $this->m_shipping->tampil_container_stock_modal($this->input->get('container_name'));
    //$this->load->view('shipping/local_container_list_modal',$data);
  }

  public function cek_tabel()
  {
    $id = $this->input->get("id");
    $data['select_container'] = $this->m_shipping->select_container($id);
    $this->load->view('shipping/validasi_reff', $data);
  }

  function get_refnumber1()
  {
    $tgl = $this->input->get('tgl');
    $data['_reff'] = $this->get_refnumber($tgl);

    $this->load->view('shipping/stock_reff', $data);
  }


  function get_refnumber($tgli)
  {
    $date = $tgli;
    $tahun = substr($tgli, 0, 6);
    // echo $date;
    $ini = $this->m_shipping->get_refnum(substr($tgli, 2, 6));

    if (empty($ini)) {
      $ref = '0001' . '/' . $tahun;
      // echo $ref;
    } else {
      $no1 = $ini->no_reff;
      // echo $no1;
      $no2 = substr($no1, 8, 6);
      // echo $no2;
      $no3 = intval($no2) + 1;
      $no4 = str_pad($no3, 4, 0, STR_PAD_LEFT);
      $ref = $no4 . '/' . $tahun;
    }
    return $ref;
    // echo $ref;
  }


  public function container_stock()
  {
    $data['container_number'] = $this->m_shipping->tampil_factory_stock_container_list();
    $data['container_hdr']    = $this->m_shipping->get_customer_name(); 
  
    // print_r($data);
    // die;
    $this->template->display('shipping/container_stock_list', $data);
  }

  public function container_stock_filter()
  {
    $pete = $this->input->get('pete');
    $data['container_number'] = $this->m_shipping->tampil_factory_stock_container_list_filter($pete);
    $this->load->view('shipping/container_stock_list_filter', $data);
  }

  public function container_stock_create()
  {
    // $data['gettype'] = $this->m_shipping->gettype();
    $data['container_name'] = $this->m_shipping->tampil_container_stock_modal($this->input->get('container_name'));
    $this->template->display('shipping/container_stock_view', $data);
  }

  public function container_local_create()
  {
    $data['supp']           = $this->m_shipping->tampil_customer();
    $data['container_name'] = $this->m_shipping->tampil_container_stock_modal($this->input->get('container_name'));
    $this->template->display('shipping/local_container_create', $data);
  }

  public function container_ship_date()
  {
    $data['getship'] = $this->m_shipping->getship();
    $this->template->display('shipping/container_list_show1', $data);
  }

  public function container_stock_edit()
  {
    $id                     = $this->input->get('stock');
    $data['gettype']        = $this->m_shipping->gettype();
    $data['tampildatahdr']  = $this->m_shipping->get_container_stock_hdr($id);
    $data['tampildatadtl']  = $this->m_shipping->get_container_stock_dtl($id);
    $data['container_name'] = $this->m_shipping->tampil_container_stock_modal($this->input->get('container_name'));
    $datareturn = array();
    // print_r($data);
    // die;
    $this->template->display('shipping/container_stock_edit', $data);
  }

  public function container_stock_edit_block()
  {
    $id                    = $this->input->get('stock');
    $data['gettype']       = $this->m_shipping->gettype();
    $data['tampildatahdr'] = $this->m_shipping->get_container_stock_hdr($id);
    $data['tampildatadtl'] = $this->m_shipping->get_container_stock_dtl($id);

    $datareturn = array();

    $this->template->display('shipping/container_stock_edit_block', $data);
  }

  public function container_local_edit()
  {
    $data['supp']             = $this->m_shipping->tampil_customer();
    $id                       = $this->input->get('stock');
    $data['container_name']   = $this->m_shipping->tampil_container_stock_modal($this->input->get('container_name'));
    $data['gettype']          = $this->m_shipping->gettype();
    $data['tampildatahdr']    = $this->m_shipping->get_container_local_hdr($id);
    $data['tampildatadtl']    = $this->m_shipping->get_container_local_dtl($id);

    $datareturn = array();

    $this->template->display('shipping/local_container_edit', $data);
  }

  public function container_stock_return()
  {
    $id = $this->input->get('stock');

    // $datareturn = array(
    //     'stock_id_dtl' => $id
    // );

    //$this->m_shipping->container_stock_return_status($datareturn);
    $this->m_shipping->container_stock_return_status($id);
    redirect('shipping/container_stock');
  }

  public function container_stock_reuse()
  {
    $id = $this->input->get('stock');

    // $datareturn = array(
    //     'stock_id_dtl' => $id
    // );

    //$this->m_shipping->container_stock_return_status($datareturn);
    $this->m_shipping->container_stock_reuse($id);
    redirect('shipping/container_stock');
  }

  public function container_stock_transfer()
  {
    $id = $this->input->get('stock');

    // $datareturn = array(
    //     'stock_id_dtl' => $id
    // );

    //$this->m_shipping->container_stock_return_status($datareturn);
    $this->m_shipping->container_stock_transfer($id);
    redirect('shipping/comeback_container_stock');
  }

  public function container_stock_edit2()
  {
    $id                 = $this->input->get('stock');
    $data['gettype2']   = $this->m_shipping->gettype2();
    $data['tampildata'] = $this->m_shipping->get_container_stock($id);
    $this->template->display('shipping/container_stock_edit', $data);
  }



  public function excel_stock_container()
  {
    error_reporting(E_ALL);
    ini_set('display_errors', TRUE);
    ini_set('display_startup_errors', TRUE);
    date_default_timezone_set('Europe/London');

    $pete = $this->input->get('pete');
    $data = $this->m_shipping->tampil_factory_stock_container_list_filter($pete);

    // print_r($data);
    // die;

    if (PHP_SAPI == 'cli')
      die('This example should only be run from a Web Browser');
    // require_once dirname(__FILE__) . '/../libraries/PHPExcel.php';
    $objPHPExcel = new PHPExcel();


    $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
    $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
    $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(10);
    $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
    $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(10);
    $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(10);
    $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(10);
    $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
    $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(17);
    $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(15);
    $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(15);
    $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(18);
    $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(18);
    $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(18);
    $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(18);
    $objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(18);
    $objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(18);
    $objPHPExcel->getActiveSheet()->getColumnDimension('R')->setWidth(18);


    $objPHPExcel->getActiveSheet()->getStyle(2)->getFont()->setBold(true)
      ->getActiveSheet()->getStyle('G2')->getFont()->setSize(18)
      ->getActiveSheet()->getStyle(3)->getFont()->setBold(true)
      ->getActiveSheet()->getStyle(4)->getFont()->setBold(true)
      ->getActiveSheet()->getStyle(5)->getFont()->setBold(true)
      ->getActiveSheet()->getStyle(7)->getFont()->setBold(true)
      ->getActiveSheet()->getStyle(7)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

    // $objDrawing = new PHPExcel_Worksheet_Drawing();
    // $objDrawing->setName('Logo');
    // $objDrawing->setDescription('Logo');
    // $logo = 'assets/ZHL-Report.png';
    // $objDrawing->setPath($logo);
    // $objDrawing->setCoordinates('F2');
    // $objDrawing->setHeight(80);
    // $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());



    $objPHPExcel->setActiveSheetIndex(0)
      // ->setCellValue('G2', 'ZHENGHE LOGISTIC PTE LTD')
      // ->setCellValue('G4', 'Monitoring Container Stock List')
      // ->setCellValue('J4', 'To : ' . $dari)
      // ->setCellValue('J5', 'From : ' . $sampai)
      ->setCellValue('A7', 'S/NO')
      ->setCellValue('B7', 'CONTAINER NO')
      ->setCellValue('C7', 'SIZE')
      ->setCellValue('D7', 'CARRIER/FWDR ')
      ->setCellValue('E7', 'DT RATE')
      ->setCellValue('F7', 'FTY')
      ->setCellValue('G7', 'FT, if RTN')
      ->setCellValue('H7', 'ETA BARGE')
      ->setCellValue('I7', 'END DATE, IF RTN')
      ->setCellValue('J7', 'FT,if REUSE')
      ->setCellValue('K7', 'ETA 1st CARRIER')
      ->setCellValue('L7', 'END DATE,IF REUSE')
      ->setCellValue('M7', 'REASONS, IF RETURN')
      ->setCellValue('N7', 'ACTUAL DATE RTN')
      ->setCellValue('O7', 'SOB DATE REUSE')
      ->setCellValue('P7', 'DT,if RTN')
      ->setCellValue('Q7', 'DT,if REUSE')
      ->setCellValue('R7', 'Remark,if DT incurred');

    $no = 1;
    $counter = 8;
    $return = null;
    $factory = null;
    // //$C20=0;$C40=0;
    foreach ($data as $v) {
      if ($v->factory == 'PSG' ||  $v->factory == 'RSUP') {
        $factory = $v->factory;
      } else {
        $factory = null;
      }

      if ($v->Remark2 == 'IFT') {
        $return = 'Insufficient FT';
      } else if ($v->Remark2 == 'QCf') {
        $return = 'QC fail';
      } else if ($v->Remark2 == 'RNC') {
        $return = 'Reuse not approved by carrier';
      } elseif ($v->Remark2 == 'CC') {
        $return = 'Customs Checks';
      } elseif ($v->Remark2 == 'ULS') {
        $return = 'Used for local stuffings';
      }

      //========Countdown from Expiry Date============
      // $awal  = strtotime($v->free_time_expiry);
      // $tempo = time();
      // $count_down = floor(($awal - $tempo) / (86400));
      //==============================================

      $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('A' . $counter, $no++)
        ->setCellValue('B' . $counter, $v->container_number)
        ->setCellValue('C' . $counter, $v->container_size . "'" . $v->container_abbr)
        ->setCellValue('D' . $counter, '')
        ->setCellValue('E' . $counter, $v->free_time)
        ->setCellValue('F' . $counter, $factory)
        ->setCellValue('G' . $counter, '')
        // ->setCellValue('G' . $counter, $v->factory)
        ->setCellValue('H' . $counter, $v->arrival_date)
        ->setCellValue('I' . $counter, $v->arrival_date)
        // ->setCellValue('J' . $counter, $v->free_time . ' Days')
        // ->setCellValue('K' . $counter, $v->free_time_expiry)
        // ->setCellValue('L' . $counter, $v->supplier)
        ->setCellValue('M' . $counter, $return);

      // if ($v->status_note == '0') {
      //     $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M' . $counter, 'Ready');
      // } elseif ($v->status_note == '1') {
      //     $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M' . $counter, 'Has Been Used');
      // } elseif ($v->status_note == '2') {
      //     $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M' . $counter, 'Return to Singapore');
      // } elseif ($v->status_note == '3') {
      //     $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M' . $counter, 'Transfer From Stock Container');
      // }

      // if ($v->status_note == '0') {
      //     $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N' . $counter, $count_down . ' Days');
      // } else {
      //     $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N' . $counter, '  ');
      // }


      $counter++;
    }



    $objPHPExcel->getActiveSheet()->getStyle('A7:R7')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
      ->getActiveSheet()->getStyle('A7:R7')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
      ->getActiveSheet()->getStyle('A7:A' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
      ->getActiveSheet()->getStyle('B7:B' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
      ->getActiveSheet()->getStyle('C7:C' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
      ->getActiveSheet()->getStyle('D7:D' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
      ->getActiveSheet()->getStyle('E7:E' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
      ->getActiveSheet()->getStyle('F7:F' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
      ->getActiveSheet()->getStyle('G7:G' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
      ->getActiveSheet()->getStyle('H7:H' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
      ->getActiveSheet()->getStyle('I7:I' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
      ->getActiveSheet()->getStyle('J7:J' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
      ->getActiveSheet()->getStyle('K7:K' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
      ->getActiveSheet()->getStyle('L7:L' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
      ->getActiveSheet()->getStyle('M7:M' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
      ->getActiveSheet()->getStyle('N7:N' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
      ->getActiveSheet()->getStyle('O7:O' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
      ->getActiveSheet()->getStyle('P7:P' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
      ->getActiveSheet()->getStyle('Q7:Q' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
      ->getActiveSheet()->getStyle('R7:R' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
      ->getActiveSheet()->getStyle('A' . $counter . ':R' . $counter)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
      ->getActiveSheet()->getStyle('A' . $counter . ':R' . $counter)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);



    $objPHPExcel->getActiveSheet()->setTitle('stock container');
    $objPHPExcel->setActiveSheetIndex(0);
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="stock container.xlsx"');
    header('Cache-Control: max-age=0');
    header('Cache-Control: max-age=1');
    header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
    header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
    header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
    header('Pragma: public'); // HTTP/1.0
    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
    $objWriter->save('php://output');
    exit;
  }

  //--------------------Fungsi Save Modifikasi -------------------

  public function container_stock_save()
  {
    // print_r ($this->input->post());
    // die;
    $stock_id_hdr     = $this->input->post('stock_id_hdr');
    $stock_id_dtl     = $this->input->post('stock_id_dtl');
    $container_number = $this->input->post('container_number');
    $container_id     = $this->input->post('container_id');
    $container_name   = $this->input->post('container_name');
    $loading_port     = $this->input->post('loading_port');
    $arrival_date     = str_replace('/', '-', $this->input->post('arrival_date'));
    $p_tanggal        = date('Y-m-d', strtotime($arrival_date)); //tanggal jurnal
    $free_time        = $this->input->post('free_time');
    $Remark           = $this->input->post('Remark');
    $Remark2          = $this->input->post('Remark2');
    $factory          = $this->input->post('factory');
    $supplier         = $this->input->post('supplier');
    $carrier           = $this->input->post('carrier');
    // $vgm              = $this->input->post('vgm');
    $import_bl_no     = $this->input->post('import_bl_no');
    $eta              = str_replace('/', '-', $this->input->post('eta'));
    // $q_tanggal        = date('Y-m-d', strtotime($eta)); //tanggal jurnal
    $free_time_expiry = str_replace('/', '-', $this->input->post('free_time_expiry'));
    $r_tanggal        = date('Y-m-d', strtotime($free_time_expiry)); //tanggal jurnal
    $status_note      = '0';


    if ($stock_id_hdr == '' && $stock_id_dtl == '') {
      $data_hdr = array(
        'loading_port'      => $loading_port,
        'free_time'         => $free_time,
        'arrival_date'      => $p_tanggal,
        'carrier'            =>$carrier,
        // 'vgm'               =>$vgm,
        'factory'           => $factory,
        'supplier'          => $supplier,
        'import_bl_no'      => $import_bl_no,
        // 'eta'               => $q_tanggal,
        'free_time_expiry'  => $r_tanggal
      );
      $headerid = $this->m_shipping->simpan_container_stock_hdr($data_hdr);

      for ($i = 0; $i < count($container_id); $i++) {
        $data_dtl = array(
          'stock_id_hdr'      => $headerid,
          'container_name'    => $container_name[$i],
          'container_number'  => $container_number[$i],
          'container_id'      => $container_id[$i],
          'Remark'            => $Remark[$i],
          'Remark2'           => $Remark2[$i],
          'status_note'       => $status_note,
          'CreatedBy'         => strtoupper($this->session->userdata('userid_1'))
        );
        $this->m_shipping->simpan_container_stock_dtl($data_dtl);
      }
      $message = 'Save Data Success';
    }

    // elseif ($stock_id_hdr != '' && $stock_id_dtl != '') {
    //     $data_hdr=array(
    //         'loading_port'      =>$loading_port,
    //         'free_time'         =>$free_time,
    //         'arrival_date'      =>$p_tanggal,
    //         'Remark'            =>$Remark,
    //         'factory'           =>$factory,
    //         'supplier'          =>$supplier,
    //         'import_bl_no'      =>$import_bl_no,
    //         'eta'               =>$q_tanggal,
    //         'free_time_expiry'  =>$r_tanggal);
    //         $headerid=$this->m_shipping->update_container_stock_hdr($data_hdr, $stock_id_hdr);

    //     for($i=0;$i<count($container_id);$i++){
    //     $data_dtl=array(
    //         'stock_id_hdr'      => $stock_id_hdr,
    //         'container_name'    => $container_name[$i],
    //         'container_number'  => $container_number[$i],
    //         'container_id'      => $container_id[$i]
    //     );
    //      $this->m_shipping->simpan_container_stock_dtl($data_dtl, $stock_id_dtl[$i]);
    // }
    //     $message='Update Data Success';

    // }

    else {
      $data_hdr = array(
        'loading_port'      => $loading_port,
        'free_time'         => $free_time,
        'arrival_date'      => $p_tanggal,
        'carrier'            =>$carrier,
        // 'vgm'               =>$vgm,
        'factory'           => $factory,
        'supplier'          => $supplier,
        'import_bl_no'      => $import_bl_no,
        // 'eta'               => $q_tanggal,
        'free_time_expiry'  => $r_tanggal
      );
      $headerid = $this->m_shipping->update_container_stock_hdr($data_hdr, $stock_id_hdr);

      // echo $stock_id_hdr;
      for ($i = 0; $i < count($container_id); $i++) {
        if ($stock_id_dtl[$i] == null) {
          $data_dtl = array(
            'stock_id_hdr'      => $stock_id_hdr,
            'container_name'    => $container_name[$i],
            'container_number'  => $container_number[$i],
            'container_id'      => $container_id[$i],
            'Remark'            => $Remark[$i],
            'Remark2'           => $Remark2[$i],
            'status_note'       => $status_note,
            'UpdatedBy'         => strtoupper($this->session->userdata('userid_1'))
          );
          
          $this->m_shipping->simpan_container_stock_dtl($data_dtl);
          // }
          $message = 'Update Data Success';
        } else {
          // for($i=0;$i<count($container_id);$i++){
          // check to database
          $data_dtl = array(
            'stock_id_hdr'      => $stock_id_hdr,
            'container_name'    => $container_name[$i],
            'container_number'  => $container_number[$i],
            'container_id'      => $container_id[$i],
            'Remark'            => $Remark[$i],
            'Remark2'           => $Remark2[$i],
            'UpdatedBy'         => strtoupper($this->session->userdata('userid_1'))
          );
          // echo $stock_id_dtl[$i];
          $this->m_shipping->update_container_stock_dtl($data_dtl, $stock_id_dtl[$i]);
        }
        $message = 'Update Data Success';
      }
    }
    $this->session->set_flashdata("message", "<div class=\"alert alert-success\" id=\"alert\">$message</div>");
    redirect('shipping/container_stock');
    //$this->session->set_flashdata("message", "<div class=\"alert alert-success\" id=\"alert\">$message</div>");
    //redirect('shipping/container_stock_edit?stock='.$stock_id_hdr);


  }

  public function container_stock_save_comeback()
  {
    $stock_id_hdr     = $this->input->post('stock_id_hdr');
    $stock_id_dtl     = $this->input->post('stock_id_dtl');
    $container_number = $this->input->post('container_number');
    $container_id     = $this->input->post('container_id');
    $container_name   = $this->input->post('container_name');
    $loading_port     = $this->input->post('loading_port');
    $arrival_date     = str_replace('/', '-', $this->input->post('arrival_date'));
    $p_tanggal        = date('Y-m-d', strtotime($arrival_date)); //tanggal jurnal
    $free_time        = $this->input->post('free_time');
    $Remark           = $this->input->post('Remark');
    $factory          = $this->input->post('factory');
    $supplier         = $this->input->post('supplier');
    $import_bl_no     = $this->input->post('import_bl_no');
    $eta              = str_replace('/', '-', $this->input->post('eta'));
    $q_tanggal        = date('Y-m-d', strtotime($eta)); //tanggal jurnal
    $free_time_expiry = str_replace('/', '-', $this->input->post('free_time_expiry'));
    $r_tanggal        = date('Y-m-d', strtotime($free_time_expiry)); //tanggal jurnal
    $status_note      = '0';


    if ($stock_id_hdr == '' && $stock_id_dtl == '') {
      $data_hdr = array(
        'loading_port'      => $loading_port,
        'free_time'         => $free_time,
        'arrival_date'      => $p_tanggal,
        //                'Remark'            =>$Remark,
        'factory'           => $factory,
        'supplier'          => $supplier,
        'import_bl_no'      => $import_bl_no,
        'eta'               => $q_tanggal,
        'free_time_expiry'  => $r_tanggal
      );
      $headerid = $this->m_shipping->simpan_container_stock_hdr($data_hdr);

      for ($i = 0; $i < count($container_id); $i++) {
        $data_dtl = array(
          'stock_id_hdr'      => $headerid,
          'container_name'    => $container_name[$i],
          'container_number'  => $container_number[$i],
          'container_id'      => $container_id[$i],
          'Remark'            => $Remark[$i],
          'status_note'       => $status_note[$i]
        );
        $this->m_shipping->simpan_container_stock_dtl($data_dtl);
      }
      $message = 'Save Data Success';
    }

    // elseif ($stock_id_hdr != '' && $stock_id_dtl != '') {
    //     $data_hdr=array(
    //         'loading_port'      =>$loading_port,
    //         'free_time'         =>$free_time,
    //         'arrival_date'      =>$p_tanggal,
    //         'Remark'            =>$Remark,
    //         'factory'           =>$factory,
    //         'supplier'          =>$supplier,
    //         'import_bl_no'      =>$import_bl_no,
    //         'eta'               =>$q_tanggal,
    //         'free_time_expiry'  =>$r_tanggal);
    //         $headerid=$this->m_shipping->update_container_stock_hdr($data_hdr, $stock_id_hdr);

    //     for($i=0;$i<count($container_id);$i++){
    //     $data_dtl=array(
    //         'stock_id_hdr'      => $stock_id_hdr,
    //         'container_name'    => $container_name[$i],
    //         'container_number'  => $container_number[$i],
    //         'container_id'      => $container_id[$i]
    //     );
    //      $this->m_shipping->simpan_container_stock_dtl($data_dtl, $stock_id_dtl[$i]);
    // }
    //     $message='Update Data Success';

    // }

    else {
      $data_hdr = array(
        'loading_port'      => $loading_port,
        'free_time'         => $free_time,
        'arrival_date'      => $p_tanggal,
        //                'Remark'            =>$Remark,
        'factory'           => $factory,
        'supplier'          => $supplier,
        'import_bl_no'      => $import_bl_no,
        'eta'               => $q_tanggal,
        'free_time_expiry'  => $r_tanggal
      );
      $headerid = $this->m_shipping->update_container_stock_hdr($data_hdr, $stock_id_hdr);

      // echo $stock_id_hdr;
      for ($i = 0; $i < count($container_id); $i++) {
        if ($stock_id_dtl[$i] == null) {
          $data_dtl = array(
            'stock_id_hdr'      => $stock_id_hdr,
            'container_name'    => $container_name[$i],
            'container_number'  => $container_number[$i],
            'container_id'      => $container_id[$i],
            'Remark'            => $Remark[$i],
            'status_note'       => $status_note[$i]
          );
          $this->m_shipping->simpan_container_stock_dtl($data_dtl);
          // }
          $message = 'Update Data Success';
        } else {
          // for($i=0;$i<count($container_id);$i++){
          // check to database
          $data_dtl = array(
            'stock_id_hdr'      => $stock_id_hdr,
            'container_name'    => $container_name[$i],
            'container_number'  => $container_number[$i],
            'container_id'      => $container_id[$i],
            'Remark'            => $Remark[$i]
          );
          // echo $stock_id_dtl[$i];
          $this->m_shipping->update_container_stock_dtl($data_dtl, $stock_id_dtl[$i]);
        }
        $message = 'Update Data Success';
      }
    }
    $this->session->set_flashdata("message", "<div class=\"alert alert-success\" id=\"alert\">$message</div>");
    redirect('shipping/comeback_container_stock');
    //$this->session->set_flashdata("message", "<div class=\"alert alert-success\" id=\"alert\">$message</div>");
    //redirect('shipping/container_stock_edit?stock='.$stock_id_hdr);


  }

  //---------------------Fungsi Save---------------


  public function container_stock_delete()
  {
    $id = $this->input->get('stock');
    // echo $id;
    $this->m_shipping->delete_container_stock($id);
    
    $message = 'Delete Data Success';
    $this->session->set_flashdata("message", "<div class=\"alert alert-success\" id=\"alert\">$message</div>");

    redirect('shipping/container_stock');
  }

  public function container_local_delete()
  {
    $id = $this->input->get('id');
    $this->m_shipping->delete_container_local_hdr($id);
  }

  public function container_stock_delete_modal()
  {
    $id = $this->input->get('stock');
    // echo $id;
    $this->m_shipping->delete_container_stock($id);
    redirect('shipping/container_stock');
  }

  public function container_local_delete_modal()
  {
    $id = $this->input->get('stock');
    //$hdr=$this->input->get('contid');
    // echo $id;
    $this->m_shipping->delete_container_local($id);
    redirect('shipping/container_local');
  }

  public function container_shippping_delete()
  {
    $id1 = $this->input->get('stock');
    $id2 = $this->input->get('tos');
    $hdr = $this->input->get('contid');
    // echo $id;

    $data = array(
      'id_inward'  => $id1,
      'id_outward' => $id2
    );

    $this->m_shipping->delete_container_shipping($data);
  }

  public function container_shippping_delete_multiple()
  {

    $id_inward  = $this->input->post('id');
    $id_outward = $this->input->post('flag');

    $update = $this->m_shipping->delete_container_shipping($id_inward, $id_outward);
    if ($update) {
      return true;
    } else {
      return false;
    }
  }

  public function container_shippping_delete_outward()
  {
    $id     = $this->input->get('stock');
    $shipid = $this->input->get('shipid');
    $contid = $this->input->get('contid');

    $this->m_shipping->delete_container_shipping_outward($id, $shipid, $contid);
  }
  //------------------------------------------------PRINT-----------------------------------------------------------------------------------
  public function container_print()
  {
    $contid = $this->input->get('cont');
    $tipe = $this->input->get('tipe');

    if ($tipe == 1) {
      $this->container_print_outward($contid);
    } else {
      $this->container_print_inward($contid);
    }
  }

  public function container_print_outward()
  {
    $data['_getcont'] =  $this->m_shipping->tampil_cont_where($this->input->get('cont'));
    $data['_getcont_ggfs'] =  $this->m_shipping->tampil_cont_where_ggfs($this->input->get('cont'));

    $this->load->view('shipping/printout/container_print_outward_fpdf', $data);
  }

  public function container_print_inward()
  {
    $data['_getcont'] =  $this->m_shipping->tampil_cont_where($this->input->get('cont'));
    $data['_getcont_ggfs'] =  $this->m_shipping->tampil_cont_where_ggfs($this->input->get('cont'));

    $this->load->view('shipping/printout/container_print_inward_fpdf', $data);
  }

  public function container_print_stock()
  {
    $data['getstock'] =  $this->m_shipping->tampil_stock_where($this->input->get('stock'));

    //$this->load->view('shipping/printout/container_print_stock_fpdf',$data);
    $this->load->view('shipping/printout/container_print_stock_fpdf', $data);
  }

  public function container_outward_excel()
  {
      error_reporting(E_ALL);
      ini_set('display_errors', TRUE);
      ini_set('display_startup_errors', TRUE);
      date_default_timezone_set('Europe/London');

      $data  = $this->m_shipping->tampil_cont_where($this->input->get('cont'));
      $data2 = $this->m_shipping->tampil_cont_where_ggfs($this->input->get('cont')); // << sheet 2

      if (PHP_SAPI == 'cli')
          die('This example should only be run from a Web Browser');

      $objPHPExcel = new PHPExcel();

      // ============================================================
      // HELPER: fungsi set kolom & style biar ga duplikat
      // ============================================================
      $setupSheet = function($sheet) {
          $sheet->getColumnDimension('A')->setWidth(5);
          $sheet->getColumnDimension('B')->setWidth(25);
          $sheet->getColumnDimension('C')->setWidth(25);
          $sheet->getColumnDimension('D')->setWidth(5);
          $sheet->getColumnDimension('E')->setWidth(5);
          $sheet->getColumnDimension('F')->setWidth(5);
          $sheet->getColumnDimension('G')->setWidth(25);
          $sheet->getColumnDimension('H')->setWidth(25);
          $sheet->getColumnDimension('I')->setWidth(15);
          $sheet->getColumnDimension('J')->setWidth(20);
          $sheet->getColumnDimension('K')->setWidth(10);
          $sheet->getColumnDimension('L')->setWidth(15);
          $sheet->getColumnDimension('M')->setWidth(10);

          foreach ([2, 3, 4, 5, 7] as $row) {
              $sheet->getStyle($row)->getFont()->setBold(true);
          }
          $sheet->getStyle('G2')->getFont()->setSize(18);
          $sheet->getStyle(7)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      };

      $fillSheet = function($sheet, $data, $logo_path) {
         if (empty($data)) {
              $sheet->setCellValue('A1', 'No data available');
              return null; // early return
          }
          // Logo
          $objDrawing = new PHPExcel_Worksheet_Drawing();
          $objDrawing->setName('Logo');
          $objDrawing->setDescription('Logo');
          $objDrawing->setPath($logo_path);
          $objDrawing->setCoordinates('D2');
          $objDrawing->setHeight(80);
          $objDrawing->setWorksheet($sheet);

          // Ambil header info dari data pertama
          foreach ($data as $r) {
              $shipmentdate = date("dmy",   strtotime($r->shipmentdate));
              $barge        = $r->barge;
              $voyage       = $r->voyage;
              $etd          = $r->etd;
              $etddate      = date("d/m/Y", strtotime($r->etddate));
              $eta          = $r->eta;
              $etadate      = date("d/m/Y", strtotime($r->etadate));
              $shipment     = date("d M Y", strtotime($r->shipmentdate));
              $to           = $r->to;
              $remark       = str_replace("<br />", "", $r->remarks);
              $createdby    = $r->createdby;
          }

          // Header info
          $sheet->setCellValue('A2', 'Vessel (Barge) :')->setCellValue('C2', $barge)
                ->setCellValue('A3', 'Voyage :')        ->setCellValue('C3', $voyage . ' ')
                ->setCellValue('A4', 'ETD ' . $etd . ' :')->setCellValue('C4', $etddate)
                ->setCellValue('A5', 'ETA ' . $eta . ' :')->setCellValue('C5', $etadate)
                ->setCellValue('G2', 'ZHENGHE LOGISTICS PTE LTD')
                ->setCellValue('G4', 'Outward List')
                ->setCellValue('G5', 'Shipment Date : ' . $shipment)
                ->setCellValue('J4', 'To : ' . $to)
                ->setCellValue('J5', 'From : ' . $createdby)
                // Header kolom
                ->setCellValue('A7', 'No')
                ->setCellValue('B7', 'Shipper/Carrier')
                ->setCellValue('C7', 'Vessel/Voyage')
                ->setCellValue('D7', "20'")
                ->setCellValue('E7', "40'")
                ->setCellValue('F7', 'CT')
                ->setCellValue('G7', 'Booking Ref')
                ->setCellValue('H7', 'Depot')
                ->setCellValue('I7', 'POD')
                ->setCellValue('J7', 'Final Dest')
                ->setCellValue('K7', 'OP Code')
                ->setCellValue('L7', 'ETA Sin')
                ->setCellValue('M7', 'Stuffing');

          $no       = 1;
          $counter  = 8;
          $C20      = 0;
          $C40      = 0;
          $po_temp  = '';

          foreach ($data as $v) {
              $sheet->setCellValue('A' . $counter, $no++)
                    ->setCellValue('B' . $counter, $v->shipping_liner)
                    ->setCellValue('C' . $counter, $v->vessel)
                    ->setCellValue('D' . $counter, $v->c20)
                    ->setCellValue('E' . $counter, $v->c40)
                    ->setCellValue('F' . $counter, $v->container_abbr)
                    ->setCellValue('I' . $counter, $v->pod)
                    ->setCellValue('J' . $counter, $v->destination)
                    ->setCellValue('K' . $counter, $v->opcode)
                    ->setCellValue('L' . $counter, $v->etdsin)
                    ->setCellValue('M' . $counter, $v->stuffing);

              if ($po_temp != $v->shipid) {
                  $sheet->setCellValue('G' . $counter, $v->reff);
                  $sheet->setCellValue('H' . $counter, $v->depot_name . ' - ' . $v->depot_address);
              }
              $counter++;

              if ($po_temp != $v->shipid) {
                  $sheet->setCellValue('G' . $counter, '');
                  $sheet->setCellValue('H' . $counter, '');
              }
              $counter++;

              if ($po_temp != $v->shipid) {
                  $sheet->setCellValue('G' . $counter, $v->reff_remark);
                  $sheet->setCellValue('H' . $counter, $v->depot_remark);
              }
              $counter++;
              $counter++;

              $C20 += $v->c20;
              $C40 += $v->c40;
              $po_temp = $v->shipid;
          }

          // Total row
          $sheet->setCellValue('D' . $counter, $C20)
                ->setCellValue('E' . $counter, $C40);

          // Border
          $sheet->getStyle('A7:M7')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
          $sheet->getStyle('A7:M7')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
          foreach (range('A', 'M') as $col) {
              $sheet->getStyle($col . '7:' . $col . $counter)
                    ->getBorders()->getRight()
                    ->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
          }
          $sheet->getStyle('A' . $counter . ':M' . $counter)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
          $sheet->getStyle('A' . $counter . ':M' . $counter)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

          $counter++;
          $sheet->setCellValue('A' . $counter, 'REMARKS')
                ->setCellValue('A' . $counter, $remark);

          return $shipmentdate; // buat nama file
      };

      // ============================================================
      // SHEET 1 — tampil_cont_where
      // ============================================================
      $sheet1 = $objPHPExcel->getActiveSheet();
      $sheet1->setTitle('Container Outward');
      $setupSheet($sheet1);
      $shipmentdate = $fillSheet($sheet1, $data, 'assets/ZHL-Report.png');

      // ============================================================
      // SHEET 2 — tampil_cont_where_ggfs
      // ============================================================
      $objPHPExcel->createSheet();
      $objPHPExcel->setActiveSheetIndex(1);
      $sheet2 = $objPHPExcel->getActiveSheet();
      $sheet2->setTitle('Container Outward GGFS');
      $setupSheet($sheet2);
      $fillSheet($sheet2, $data2, 'assets/ZHL-Report.png');

      // ============================================================
      // OUTPUT
      // ============================================================
      $objPHPExcel->setActiveSheetIndex(0);
      header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
      header('Content-Disposition: attachment;filename="Container Outward ' . $shipmentdate . '.xlsx"');
      header('Cache-Control: max-age=0');
      header('Cache-Control: max-age=1');
      header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
      header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
      header('Cache-Control: cache, must-revalidate');
      header('Pragma: public');
      $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
      $objWriter->save('php://output');
      exit;
  }

  public function container_inward_excel()
  {
      error_reporting(E_ALL);
      ini_set('display_errors', TRUE);
      ini_set('display_startup_errors', TRUE);
      date_default_timezone_set('Europe/London');

      $data  = $this->m_shipping->tampil_cont_where_excel($this->input->get('cont'));
      $data2 = $this->m_shipping->tampil_cont_where_excel_ggfs($this->input->get('cont')); // << sheet 2

      if (PHP_SAPI == 'cli')
          die('This example should only be run from a Web Browser');

      $objPHPExcel = new PHPExcel();

      // ============================================================
      // HELPER: setup lebar kolom & style
      // ============================================================
      $setupSheet = function($sheet) {
          $sheet->getColumnDimension('A')->setWidth(5);
          $sheet->getColumnDimension('B')->setWidth(20);
          $sheet->getColumnDimension('C')->setWidth(15);
          $sheet->getColumnDimension('D')->setWidth(15);
          $sheet->getColumnDimension('E')->setWidth(5);
          $sheet->getColumnDimension('F')->setWidth(5);
          $sheet->getColumnDimension('G')->setWidth(25);
          $sheet->getColumnDimension('H')->setWidth(25);
          $sheet->getColumnDimension('I')->setWidth(20);
          $sheet->getColumnDimension('J')->setWidth(20);
          $sheet->getColumnDimension('K')->setWidth(25);
          $sheet->getColumnDimension('L')->setWidth(15);
          $sheet->getColumnDimension('M')->setWidth(20);
          $sheet->getColumnDimension('N')->setWidth(10);
          $sheet->getColumnDimension('O')->setWidth(20);
          $sheet->getColumnDimension('P')->setWidth(10);
          $sheet->getColumnDimension('Q')->setWidth(20);

          foreach ([2, 3, 4, 5, 7] as $row) {
              $sheet->getStyle($row)->getFont()->setBold(true);
          }
          $sheet->getStyle('G2')->getFont()->setSize(18);
          $sheet->getStyle(7)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      };

      // ============================================================
      // HELPER: isi konten sheet
      // ============================================================
      $fillSheet = function($sheet, $data, $logo_path) {
         if (empty($data)) {
              $sheet->setCellValue('A1', 'No data available');
              return null; // early return
          }
          // Logo
          $objDrawing = new PHPExcel_Worksheet_Drawing();
          $objDrawing->setName('Logo');
          $objDrawing->setDescription('Logo');
          $objDrawing->setPath($logo_path);
          $objDrawing->setCoordinates('E2');
          $objDrawing->setHeight(60);
          $objDrawing->setWorksheet($sheet);

          // Ambil info header dari data
          foreach ($data as $r) {
              $shipmentdate = date("dmy",   strtotime($r->shipmentdate));
              $barge        = $r->barge;
              $voyage       = $r->voyage;
              $etd          = $r->etd;
              $etddate      = date("d/m/Y", strtotime($r->etddate));
              $eta          = $r->eta;
              $etadate      = date("d/m/Y", strtotime($r->etadate));
              $shipment     = date("d M Y", strtotime($r->shipmentdate));
              $to           = $r->to;
              $from         = $r->from;
              $remarks      = str_replace("<br />", "", $r->remarks);
          }

          // Header info & kolom
          $sheet->setCellValue('A2', 'Vessel (Barge) :')->setCellValue('C2', $barge)
                ->setCellValue('A3', 'Voyage :')         ->setCellValue('C3', $voyage . ' ')
                ->setCellValue('A4', 'ETD ' . $etd . ' :')->setCellValue('C4', $etddate)
                ->setCellValue('A5', 'ETA ' . $eta . ' :')->setCellValue('C5', $etadate)
                ->setCellValue('G2', 'ZHENGHE LOGISTICS PTE LTD')
                ->setCellValue('G4', 'Inward List')
                ->setCellValue('G5', 'Shipment Date : ' . $shipment)
                ->setCellValue('J4', 'Shipment From : ' . $from)
                ->setCellValue('J5', 'To : ' . $to)
                ->setCellValue('A7', 'No')
                ->setCellValue('B7', 'Booking Ref.')
                ->setCellValue('C7', 'Container No')
                ->setCellValue('D7', 'Seal No')
                ->setCellValue('E7', "20'")
                ->setCellValue('F7', "40'")
                ->setCellValue('G7', 'CT')
                ->setCellValue('H7', 'Buyer')
                ->setCellValue('I7', 'Po Number')
                ->setCellValue('J7', 'Brand')
                ->setCellValue('K7', 'Vessel Voyage')
                ->setCellValue('L7', 'Eta Sin')
                ->setCellValue('M7', 'POD')
                ->setCellValue('N7', 'Destination')
                ->setCellValue('O7', 'OP/SO')
                ->setCellValue('P7', 'Carrier')
                ->setCellValue('Q7', 'Weight');

          $no      = 1;
          $counter = 8;
          $C20     = 0;
          $C40     = 0;

          foreach ($data as $v) {
              $weightpallet = $v->pallet_qty * 19;
              $weight1      = $weightpallet + $v->total_gross_weight + $v->tare_weight + $v->sample;

              $sheet->setCellValue('A' . $counter, $no++)
                    ->setCellValue('B' . $counter, $v->reff)
                    ->setCellValue('C' . $counter, $v->container)
                    ->setCellValue('D' . $counter, $v->actual_seal)
                    ->setCellValue('E' . $counter, $v->c20)
                    ->setCellValue('F' . $counter, $v->c40)
                    ->setCellValue('G' . $counter, $v->container_abbr)
                    ->setCellValue('H' . $counter, $v->customer_name)
                    ->setCellValue('I' . $counter, $v->po_number_mix)
                    ->setCellValue('J' . $counter, $v->brand)
                    ->setCellValue('K' . $counter, $v->vessel)
                    ->setCellValue('L' . $counter, $v->etdsin)
                    ->setCellValue('M' . $counter, $v->pod)
                    ->setCellValue('N' . $counter, $v->destination)
                    ->setCellValue('O' . $counter, $v->opcode)
                    ->setCellValue('P' . $counter, $v->shipping_liner)
                    ->setCellValue('Q' . $counter, number_format($weight1, 4));

              $counter++;
              $C20 += $v->c20;
              $C40 += $v->c40;
          }

          // Total row
          $sheet->setCellValue('E' . $counter, $C20)
                ->setCellValue('F' . $counter, $C40);

          // Border
          $sheet->getStyle('A7:Q7')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
          $sheet->getStyle('A7:Q7')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
          foreach (range('A', 'Q') as $col) {
              $sheet->getStyle($col . '7:' . $col . $counter)
                    ->getBorders()->getRight()
                    ->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
          }
          $sheet->getStyle('A' . $counter . ':Q' . $counter)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
          $sheet->getStyle('A' . $counter . ':Q' . $counter)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

          $counter++;
          $sheet->setCellValue('B' . $counter, $remarks);

          return $shipmentdate;
      };

      // ============================================================
      // SHEET 1 — tampil_cont_where_excel
      // ============================================================
      $sheet1 = $objPHPExcel->getActiveSheet();
      $sheet1->setTitle('Container Inward');
      $setupSheet($sheet1);
      $shipmentdate = $fillSheet($sheet1, $data, 'assets/ZHL-Report.png');

      // ============================================================
      // SHEET 2 — tampil_cont_where_excel_ggfs
      // ============================================================
      $objPHPExcel->createSheet();
      $objPHPExcel->setActiveSheetIndex(1);
      $sheet2 = $objPHPExcel->getActiveSheet();
      $sheet2->setTitle('Container Inward GGFS');
      $setupSheet($sheet2);
      $fillSheet($sheet2, $data2, 'assets/ZHL-Report.png');

      // ============================================================
      // OUTPUT
      // ============================================================
      $objPHPExcel->setActiveSheetIndex(0);
      header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
      header('Content-Disposition: attachment;filename="Container Inward ' . $shipmentdate . '.xlsx"');
      header('Cache-Control: max-age=0');
      header('Cache-Control: max-age=1');
      header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
      header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
      header('Cache-Control: cache, must-revalidate');
      header('Pragma: public');
      $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
      $objWriter->save('php://output');
      exit;
  }

  public function container_template_excel()
  {
    error_reporting(E_ALL);
    ini_set('display_errors', TRUE);
    ini_set('display_startup_errors', TRUE);
    date_default_timezone_set('Europe/London');

    $stat = $this->input->get('stat');
    
    if($stat == "ggfs"){
      $data =  $this->m_shipping->tampil_cont_where_ggfs($this->input->get('cont'));
    } else{
      $data =  $this->m_shipping->tampil_cont_where($this->input->get('cont'));
    }

    if (PHP_SAPI == 'cli')
      die('This example should only be run from a Web Browser');
    // require_once dirname(__FILE__) . '/../libraries/PHPExcel.php';
    $objPHPExcel = new PHPExcel();
    $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
    $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(25);
    $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
    $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(5);
    $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(5);
    $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(5);
    $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(25);
    $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(25);
    $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
    $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(20);
    $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(20);
    $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(20);
    $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(20);
    $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(30);



    $objPHPExcel->getActiveSheet()->getStyle(2)->getFont()->setBold(true)
      ->getActiveSheet()->getStyle('G2')->getFont()->setSize(18)
      ->getActiveSheet()->getStyle(3)->getFont()->setBold(true)
      ->getActiveSheet()->getStyle(4)->getFont()->setBold(true)
      ->getActiveSheet()->getStyle(5)->getFont()->setBold(true)
      ->getActiveSheet()->getStyle(7)->getFont()->setBold(true)
      ->getActiveSheet()->getStyle(7)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

    $objDrawing = new PHPExcel_Worksheet_Drawing();
    $objDrawing->setName('Logo');
    $objDrawing->setDescription('Logo');
    $logo = 'assets/ZHL-Report.png';
    $objDrawing->setPath($logo);
    $objDrawing->setCoordinates('E2');
    $objDrawing->setHeight(60);
    $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());

    foreach ($data as $r) {
      $shipmentdate = date("dmy",  strtotime($r->shipmentdate));
      $barge = $r->barge;
      $voyage = $r->voyage;
      $etd = $r->etd;
      $etddate = date("d/m/Y",  strtotime($r->etddate));
      $eta = $r->eta;
      $etadate = date("d/m/Y",  strtotime($r->etadate));
      $shipment = date("d M Y",  strtotime($r->shipmentdate));
      $to = $r->to;
      $from = $r->from;
      $remarks = str_replace("<br />", "", $r->remarks);
      //            $stuffing=$r->stuffing;
    }

    $objPHPExcel->setActiveSheetIndex(0)
      ->setCellValue('A2', 'Vessel (Barge) :')
      ->setCellValue('C2', $barge)
      ->setCellValue('A3', 'Voyage :')
      ->setCellValue('C3', $voyage . ' ')
      ->setCellValue('A4', 'ETD ' . $etd . ' :')
      ->setCellValue('C4', $etddate)
      ->setCellValue('A5', 'ETA ' . $eta . ' :')
      ->setCellValue('C5', $etadate)
      ->setCellValue('G2', 'ZHENGHE LOGISTIC PTE LTD')
      ->setCellValue('G4', '')
      ->setCellValue('G5', 'Shipment Date : ' . $shipment)
      ->setCellValue('J4', 'From : ' . $from)
      ->setCellValue('J5', 'To : ' . $to)
      ->setCellValue('A7', 'No')
      ->setCellValue('B7', 'Container No')
      ->setCellValue('C7', 'Seal No')
      ->setCellValue('D7', "20'")
      ->setCellValue('E7', "40'")
      ->setCellValue('F7', 'CT')
      ->setCellValue('G7', 'Booking Reference')
      ->setCellValue('H7', 'Shipper/Carrier')
      ->setCellValue('I7', 'Eta Sin')
      ->setCellValue('J7', 'POD')
      ->setCellValue('K7', 'Destination')
      ->setCellValue('L7', 'Tare Weight (Kgs)')
      ->setCellValue('M7', 'Tracking Date')
      ->setCellValue('N7', 'ID Key (Do Not Remove/Change)');

    $no = 1;
    $counter = 8;
    $C20 = 0;
    $C40 = 0;
    foreach ($data as $v) :
      $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('A' . $counter, $no++)
        ->setCellValue('B' . $counter, $v->container)
        ->setCellValue('C' . $counter, $v->actual_seal)
        ->setCellValue('D' . $counter, $v->c20)
        ->setCellValue('E' . $counter, $v->c40)
        ->setCellValue('F' . $counter, $v->container_abbr)
        ->setCellValue('G' . $counter, $v->reff)
        ->setCellValue('H' . $counter, $v->shipping_liner)
        ->setCellValue('I' . $counter, $v->etdsin)
        ->setCellValue('J' . $counter, $v->pod)
        ->setCellValue('K' . $counter, $v->destination)
        ->setCellValue('L' . $counter, number_format($v->tare_weight, 4, '.', ','))
        ->setCellValue('M' . $counter, $v->trucking_date)
        ->setCellValue('N' . $counter, $v->id);

      $counter++;
      $C20 += $v->c20;
      $C40 += $v->c40;
    endforeach;

    $objPHPExcel->setActiveSheetIndex(0)
      ->setCellValue('D' . $counter, $C20)
      ->setCellValue('E' . $counter, $C40);

    $objPHPExcel->getActiveSheet()->getStyle('A7:N7')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
      ->getActiveSheet()->getStyle('A7:N7')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
      ->getActiveSheet()->getStyle('A7:A' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
      ->getActiveSheet()->getStyle('B7:B' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
      ->getActiveSheet()->getStyle('C7:C' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
      ->getActiveSheet()->getStyle('D7:D' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
      ->getActiveSheet()->getStyle('E7:E' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
      ->getActiveSheet()->getStyle('F7:F' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
      ->getActiveSheet()->getStyle('G7:G' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
      ->getActiveSheet()->getStyle('H7:H' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
      ->getActiveSheet()->getStyle('I7:I' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
      ->getActiveSheet()->getStyle('J7:J' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
      ->getActiveSheet()->getStyle('K7:K' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
      ->getActiveSheet()->getStyle('L7:L' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
      ->getActiveSheet()->getStyle('M7:M' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
      ->getActiveSheet()->getStyle('N7:N' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
      ->getActiveSheet()->getStyle('A' . $counter . ':N' . $counter)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
      ->getActiveSheet()->getStyle('A' . $counter . ':N' . $counter)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

    $counter++;
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B' . $counter, $remarks);

    $objPHPExcel->getActiveSheet()->setTitle('Template_Container_Seal');
    $objPHPExcel->setActiveSheetIndex(0);
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    if($stat == "ggfs"){
      header('Content-Disposition: attachment;filename="Template_Container_Seal_ggfs ' . $shipmentdate . '.xlsx"');
    } else{
      header('Content-Disposition: attachment;filename="Template_Container_Seal ' . $shipmentdate . '.xlsx"');
    }
    header('Cache-Control: max-age=0');
    header('Cache-Control: max-age=1');
    header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
    header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
    header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
    header('Pragma: public'); // HTTP/1.0
    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
    $objWriter->save('php://output');
    exit;
  }

  public function container_stock_excel()
  {
    error_reporting(E_ALL);
    ini_set('display_errors', TRUE);
    ini_set('display_startup_errors', TRUE);
    date_default_timezone_set('Europe/London');

    $data =  $this->m_shipping->tampil_stock_where($this->input->get('stock'));
    //$data['tampildatasemua'] = $this->m_shipping->get_container_stock_semua($id);

    if (PHP_SAPI == 'cli')
      die('This example should only be run from a Web Browser');
    // require_once dirname(__FILE__) . '/../libraries/PHPExcel.php';
    $objPHPExcel = new PHPExcel();
    $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
    $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(25);
    $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
    $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(25);
    $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(25);
    $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(25);
    $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(25);
    $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(25);
    $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
    $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(20);
    $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(25);
    $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(30);

    $objPHPExcel->getActiveSheet()->getStyle(2)->getFont()->setBold(true)
      ->getActiveSheet()->getStyle('G2')->getFont()->setSize(18)
      ->getActiveSheet()->getStyle(3)->getFont()->setBold(true)
      ->getActiveSheet()->getStyle(4)->getFont()->setBold(true)
      ->getActiveSheet()->getStyle(5)->getFont()->setBold(true)
      ->getActiveSheet()->getStyle(7)->getFont()->setBold(true)
      ->getActiveSheet()->getStyle(7)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

    $objDrawing = new PHPExcel_Worksheet_Drawing();
    $objDrawing->setName('Logo');
    $objDrawing->setDescription('Logo');
    $logo = 'assets/ZHL-Report.png';
    $objDrawing->setPath($logo);
    $objDrawing->setCoordinates('F2');
    $objDrawing->setHeight(80);
    $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());

    foreach ($data as $r) {
      // $shipmentdate=date("dmy",  strtotime($r->shipmentdate));
      // $barge=$r->barge;
      // $voyage=$r->voyage;
      // $etd=$r->etd;
      // $etddate=date("d/m/Y",  strtotime($r->etddate));
      // $eta=$r->eta;
      // $etadate=date("d/m/Y",  strtotime($r->etadate));
      // $shipment=date("d M Y",  strtotime($r->shipmentdate));
      // $to=$r->to;
      // $remark=str_replace("<br />", "",$r->remarks);
      // $createdby=$r->createdby;
      $stock_id_hdr      = $r->stock_id_hdr;
      $stock_id_dtl      = $r->stock_id_dtl;
      $container_number  = $r->container_number;
      $container_id      = $r->container_id;
      $container_name    = $r->container_name;
      $loading_port      = $r->loading_port;
      // $arrival_date = str_replace('/', '-', $this->input->post('arrival_date'));
      //         $p_tanggal = date('Y-m-d', strtotime($arrival_date)); //tanggal jurnal
      $arrival_date      = date('Y-m-d', strtotime($r->arrival_date)); //tanggal jurnal
      $free_time         = $r->free_time;
      $Remark            = $r->Remark;
      $factory           = $r->factory;
      $supplier          = $r->supplier;
      $import_bl_no      = $r->import_bl_no;
      $eta               = date('Y-m-d', strtotime($r->eta)); //tanggal jurnal
      $free_time_expiry  = date('Y-m-d', strtotime($r->free_time_expiry)); //tanggal jurnal
    }

    $objPHPExcel->setActiveSheetIndex(0)
      // ->setCellValue('A2', 'Vessel (Barge) :')
      // ->setCellValue('C2', ' ')
      // ->setCellValue('A3', 'Voyage :')
      // ->setCellValue('C3', ' ')
      // ->setCellValue('A4', 'ETD :')
      // ->setCellValue('C4', ' ')
      // ->setCellValue('A5', 'ETA :')
      // ->setCellValue('C5', ' ')
      ->setCellValue('G2', 'ZHENGHE LOGISTIC PTE LTD')
      ->setCellValue('G4', 'Container Stock List')
      //->setCellValue('G5', 'Shipment Date : ')
      ->setCellValue('J4', 'To : ')
      ->setCellValue('J5', 'From : ')
      ->setCellValue('A7', 'No')
      ->setCellValue('B7', 'Container Type')
      ->setCellValue('C7', 'Container Number')
      ->setCellValue('D7', 'Import BL No')
      ->setCellValue('E7', 'Loading Port')
      ->setCellValue('F7', 'Remark')
      ->setCellValue('G7', 'Factory')
      ->setCellValue('H7', 'Arrival Date')
      ->setCellValue('I7', 'Free Time')
      ->setCellValue('J7', 'Estimation Time Arrival')
      ->setCellValue('K7', 'Expiry Date')
      ->setCellValue('L7', 'Supplier');

    $no = 1;
    $counter = 8;
    // //$C20=0;$C40=0;
    foreach ($data as $v) :
      $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('A' . $counter, $no++)
        ->setCellValue('B' . $counter, $v->container_name)
        ->setCellValue('C' . $counter, $v->container_number)
        ->setCellValue('D' . $counter, $v->import_bl_no)
        ->setCellValue('E' . $counter, $v->loading_port)
        ->setCellValue('F' . $counter, $v->Remark)
        ->setCellValue('G' . $counter, $v->factory)
        ->setCellValue('H' . $counter, $v->arrival_date)
        ->setCellValue('I' . $counter, $v->free_time)
        ->setCellValue('J' . $counter, $v->eta)
        ->setCellValue('K' . $counter, $v->free_time_expiry)
        ->setCellValue('L' . $counter, $v->supplier);
      $counter++;
    //$C20 += $v->c20;$C40 += $v->c40;
    endforeach;

    // $objPHPExcel->setActiveSheetIndex(0)
    //        ->setCellValue('D'.$counter, $C20)
    //        ->setCellValue('E'.$counter, $C40);

    $objPHPExcel->getActiveSheet()->getStyle('A7:L7')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
      ->getActiveSheet()->getStyle('A7:l7')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
      ->getActiveSheet()->getStyle('A7:A' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
      ->getActiveSheet()->getStyle('B7:B' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
      ->getActiveSheet()->getStyle('C7:C' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
      ->getActiveSheet()->getStyle('D7:D' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
      ->getActiveSheet()->getStyle('E7:E' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
      ->getActiveSheet()->getStyle('F7:F' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
      ->getActiveSheet()->getStyle('G7:G' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
      ->getActiveSheet()->getStyle('H7:H' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
      ->getActiveSheet()->getStyle('I7:I' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
      ->getActiveSheet()->getStyle('J7:J' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
      ->getActiveSheet()->getStyle('K7:K' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
      ->getActiveSheet()->getStyle('L7:L' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
      ->getActiveSheet()->getStyle('A' . $counter . ':L' . $counter)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
      ->getActiveSheet()->getStyle('A' . $counter . ':L' . $counter)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

    // $counter++;
    // $objPHPExcel->setActiveSheetIndex(0)
    //         ->setCellValue('A'.$counter, 'REMARKS')
    //         ->setCellValue('A'.$counter++, $remark);

    $objPHPExcel->getActiveSheet()->setTitle('Container Stock');
    $objPHPExcel->setActiveSheetIndex(0);
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="Container Stock.xlsx"');
    header('Cache-Control: max-age=0');
    header('Cache-Control: max-age=1');
    header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
    header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
    header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
    header('Pragma: public'); // HTTP/1.0
    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
    $objWriter->save('php://output');
    exit;
  }

  public function container_stock_all_excel()
  {
    error_reporting(E_ALL);
    ini_set('display_errors', TRUE);
    ini_set('display_startup_errors', TRUE);
    date_default_timezone_set('Europe/London');

    //$data =  $this->m_shipping->get_container_stock_semua($this->input->get('stock'));
    $data =  $this->m_shipping->tampil_factory_stock_container();

    if (PHP_SAPI == 'cli')
      die('This example should only be run from a Web Browser');
    // require_once dirname(__FILE__) . '/../libraries/PHPExcel.php';
    $objPHPExcel = new PHPExcel();

    // // Set Color
    // $objPHPExcel = new PHPExcel_Style_Color();
    // $objPHPExcel->setRGB("FFF443");
    // $objPHPExcel->getStyle('B5:Z5')->getFont()->setColor($objPHPExcel);
    // $objPHPExcel->getStyle('D4')->getFont()->setColor($objPHPExcel);
    // $objPHPExcel->getStyle('B6:C6')->getFont()->setBold(true);
    // $objPHPExcel->getStyle('B2:B3')->getFont()->setBold(true);
    // //=========

    $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
    $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(25);
    $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
    $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(25);
    $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(25);
    $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(25);
    $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(25);
    $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(25);
    $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
    $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(20);
    $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(25);
    $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(30);

    $objPHPExcel->getActiveSheet()->getStyle(2)->getFont()->setBold(true)
      ->getActiveSheet()->getStyle('G2')->getFont()->setSize(18)
      ->getActiveSheet()->getStyle(3)->getFont()->setBold(true)
      ->getActiveSheet()->getStyle(4)->getFont()->setBold(true)
      ->getActiveSheet()->getStyle(5)->getFont()->setBold(true)
      ->getActiveSheet()->getStyle(7)->getFont()->setBold(true)
      ->getActiveSheet()->getStyle(7)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

    $objDrawing = new PHPExcel_Worksheet_Drawing();
    $objDrawing->setName('Logo');
    $objDrawing->setDescription('Logo');
    $logo = 'assets/ZHL-Report.png';
    $objDrawing->setPath($logo);
    $objDrawing->setCoordinates('F2');
    $objDrawing->setHeight(80);
    $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());

    foreach ($data as $r) {
      // $shipmentdate=date("dmy",  strtotime($r->shipmentdate));
      // $barge=$r->barge;
      // $voyage=$r->voyage;
      // $etd=$r->etd;
      // $etddate=date("d/m/Y",  strtotime($r->etddate));
      // $eta=$r->eta;
      // $etadate=date("d/m/Y",  strtotime($r->etadate));
      // $shipment=date("d M Y",  strtotime($r->shipmentdate));
      // $to=$r->to;
      // $remark=str_replace("<br />", "",$r->remarks);
      // $createdby=$r->createdby;
      $stock_id_hdr      = $r->stock_id_hdr;
      $stock_id_dtl      = $r->stock_id_dtl;
      $container_number  = $r->container_number;
      $container_id      = $r->container_id;
      $container_name    = $r->container_name;
      $loading_port      = $r->loading_port;
      // $arrival_date = str_replace('/', '-', $this->input->post('arrival_date'));
      //         $p_tanggal = date('Y-m-d', strtotime($arrival_date)); //tanggal jurnal
      $arrival_date      = date('Y-m-d', strtotime($r->arrival_date)); //tanggal jurnal
      $free_time         = $r->free_time;
      $Remark            = $r->Remark;
      $factory           = $r->factory;
      $supplier          = $r->supplier;
      $import_bl_no      = $r->import_bl_no;
      $eta               = date('Y-m-d', strtotime($r->eta)); //tanggal jurnal
      $free_time_expiry  = date('Y-m-d', strtotime($r->free_time_expiry)); //tanggal jurnal
    }

    $objPHPExcel->setActiveSheetIndex(0)
      // ->setCellValue('A2', 'Vessel (Barge) :')
      // ->setCellValue('C2', ' ')
      // ->setCellValue('A3', 'Voyage :')
      // ->setCellValue('C3', ' ')
      // ->setCellValue('A4', 'ETD :')
      // ->setCellValue('C4', ' ')
      // ->setCellValue('A5', 'ETA :')
      // ->setCellValue('C5', ' ')
      ->setCellValue('G2', 'ZHENGHE LOGISTIC PTE LTD')
      ->setCellValue('G4', 'Container Stock List :')
      //->setCellValue('G5', 'Shipment Date : ')
      ->setCellValue('J4', 'To : ')
      ->setCellValue('J5', 'From : ')
      ->setCellValue('A7', 'No')
      ->setCellValue('B7', 'Container Type')
      ->setCellValue('C7', 'Container Number')
      ->setCellValue('D7', 'Import BL No')
      ->setCellValue('E7', 'Loading Port')
      ->setCellValue('F7', 'Remark')
      ->setCellValue('G7', 'Factory')
      ->setCellValue('H7', 'Arrival Date')
      ->setCellValue('I7', 'Free Time')
      ->setCellValue('J7', 'Estimation Time Arrival')
      ->setCellValue('K7', 'Expiry Date')
      ->setCellValue('L7', 'Supplier');

    $no = 1;
    $counter = 8;
    // //$C20=0;$C40=0;
    foreach ($data as $v) :
      $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('A' . $counter, $no++)
        ->setCellValue('B' . $counter, $v->container_name)
        ->setCellValue('C' . $counter, $v->container_number)
        ->setCellValue('D' . $counter, $v->import_bl_no)
        ->setCellValue('E' . $counter, $v->loading_port)
        ->setCellValue('F' . $counter, $v->Remark)
        ->setCellValue('G' . $counter, $v->factory)
        ->setCellValue('H' . $counter, $v->arrival_date)
        ->setCellValue('I' . $counter, $v->free_time)
        ->setCellValue('J' . $counter, $v->eta)
        ->setCellValue('K' . $counter, $v->free_time_expiry)
        ->setCellValue('L' . $counter, $v->supplier);
      $counter++;
    //$C20 += $v->c20;$C40 += $v->c40;
    endforeach;

    // $objPHPExcel->setActiveSheetIndex(0)
    //        ->setCellValue('D'.$counter, $C20)
    //        ->setCellValue('E'.$counter, $C40);

    $objPHPExcel->getActiveSheet()->getStyle('A7:L7')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
      ->getActiveSheet()->getStyle('A7:l7')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
      ->getActiveSheet()->getStyle('A7:A' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
      ->getActiveSheet()->getStyle('B7:B' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
      ->getActiveSheet()->getStyle('C7:C' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
      ->getActiveSheet()->getStyle('D7:D' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
      ->getActiveSheet()->getStyle('E7:E' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
      ->getActiveSheet()->getStyle('F7:F' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
      ->getActiveSheet()->getStyle('G7:G' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
      ->getActiveSheet()->getStyle('H7:H' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
      ->getActiveSheet()->getStyle('I7:I' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
      ->getActiveSheet()->getStyle('J7:J' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
      ->getActiveSheet()->getStyle('K7:K' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
      ->getActiveSheet()->getStyle('L7:L' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
      ->getActiveSheet()->getStyle('A' . $counter . ':L' . $counter)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
      ->getActiveSheet()->getStyle('A' . $counter . ':L' . $counter)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

    // $counter++;
    // $objPHPExcel->setActiveSheetIndex(0)
    //         ->setCellValue('A'.$counter, 'REMARKS')
    //         ->setCellValue('A'.$counter++, $remark);

    $objPHPExcel->getActiveSheet()->setTitle('Container Stock All');
    $objPHPExcel->setActiveSheetIndex(0);
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="Container Stock All.xlsx"');
    header('Cache-Control: max-age=0');
    header('Cache-Control: max-age=1');
    header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
    header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
    header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
    header('Pragma: public'); // HTTP/1.0
    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
    $objWriter->save('php://output');
    exit;
  }

  public function container_loading()
  {
    //$data['sl']= $this->m_shipping->tampil_sl();
    $data['sl']     = $this->m_shipping->tampil_sl_new(); //Pakai Jika Input Container Outward Terbarukan===========
    $data['ship']   = $this->m_shipping->tampil_shipmentdate();
    $this->template->display('shipping/container_loading', $data);
  }

  public function container_loading_filter_cont()
  {
    $data['inward']  = $this->m_shipping->tampil_po_inward_loading($this->input->get('sl'), $this->input->get('ship'));
    $this->load->view('shipping/container_loading_cont', $data);
  }

  public function container_loadingall()
  {
    $data['loading'] =  $this->m_shipping->tampil_container_loading($this->input->get('loadall'));
    $this->load->view('shipping/container_loading_all', $data);
  }

  public function container_loading_modal_delete()
  {
    $data['loading'] =  $this->m_shipping->tampil_container_loading_where($this->input->get('delete'));
    $this->load->view('shipping/container_loading_modal_delete', $data);
  }

  public function container_loading_show()
  {
    $data['sl']      = $this->m_shipping->tampil_sl_new(); //Pakai Jika Input Container Outward Terbarukan===========
    $data['ship']    = $this->m_shipping->tampil_shipmentdate();
    $data['loading'] = $this->m_shipping->tampil_container_loading_where($this->input->get('load'));
    $this->template->display('shipping/container_loading_show', $data);
  }

  public function container_loading_show_redirect()
  {
    $data['sl']      = $this->m_shipping->tampil_sl_new();
    $data['ship']    = $this->m_shipping->tampil_shipmentdate();
    $data['loading'] = $this->m_shipping->tampil_container_loading_where($this->input->get('load'));
    $this->template->display('shipping/container_loading_redirect_save', $data);
  }

  public function container_loading_save($trans)
  {
    $id         =  $this->input->post('id');
    $docdate    =  $this->convert($this->input->post('docdate'));
    $barge      =  $this->input->post('barge');
    $voyage     =  $this->input->post('voyage');
    $etasin     =  $this->convert($this->input->post('etasin'));
    $to         =  $this->input->post('to');
    $attn       =  $this->input->post('attn');
    $from       =  $this->input->post('from');
    $remarks    =  $this->input->post('remarks');

    $dataHdr = array(
      'trans' => $trans, 'id' => $id, 'docdate' => $docdate, 'barge' => $barge, 'voyage' => $voyage, 'etasin' => $etasin,
      'to' => $to, 'attn' => $attn, 'from' => $from, 'remarks' => $remarks, 'createdby' =>  strtoupper($this->session->userdata('userid_1'))
    );

    $query =  $this->m_shipping->simpan_cont_l_sp($dataHdr);

    if ($query['flag'] == 1) {
      $this->session->set_flashdata("message", "<div class=\"alert alert-success\" id=\"alert\">Transaction Success</div>");
      // redirect('shipping/container_loading_show?load='.$query['headerid']);
      redirect('shipping/container_loading_show_redirect?load=' . $query['headerid']);
    } else {
      $this->session->set_flashdata("message", "<div class=\"alert alert-danger\" id=\"alert\">Save Transaction Broken</div>");
      redirect('shipping/container_loading');
    }
  }

  public function container_loading_delete()
  {
    $query = $this->m_shipping->delete_cont_l_sp($this->input->get('load'));

    if ($query['flag'] == 1) {
      $this->session->set_flashdata("message", "<div class=\"alert alert-danger\" id=\"alert\">Delete Data Success</div>");
      redirect('shipping/container_loading');
    } else {
      $this->session->set_flashdata("message", "<div class=\"alert alert-warning\" id=\"alert\">Delete Data Broken</div>");
      redirect('shipping/container_loading');
    }
  }

  public function container_loading_print()
  {
    $data['_getcont'] =  $this->m_shipping->tampil_container_loading_where($this->input->get('load'));

    $this->load->view('shipping/printout/container_print_loading_fpdf.php', $data);
  }

  public function container_loading_excel()
  {
    error_reporting(E_ALL);
    ini_set('display_errors', TRUE);
    ini_set('display_startup_errors', TRUE);
    date_default_timezone_set('Europe/London');

    $data =  $this->m_shipping->tampil_container_loading_where($this->input->get('load'));

    if (PHP_SAPI == 'cli')
      die('This example should only be run from a Web Browser');
    // require_once dirname(__FILE__) . '/../libraries/PHPExcel.php';
    $objPHPExcel = new PHPExcel();

    $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(25);
    $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
    $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
    $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(40);
    $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
    $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(25);
    $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(25);
    $objPHPExcel->getActiveSheet()->mergeCells('F16:G16');
    $objPHPExcel->getActiveSheet()->getStyle(2)->getFont()->setBold(true)
      ->getActiveSheet()->getStyle('B2')->getFont()->setSize(18)
      ->getActiveSheet()->getStyle(15)->getFont()->setBold(true)
      ->getActiveSheet()->getStyle(16)->getFont()->setBold(true)
      ->getActiveSheet()->getStyle(16)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
      ->getActiveSheet()->getStyle(17)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

    $objDrawing = new PHPExcel_Worksheet_Drawing();
    $objDrawing->setName('Logo');
    $objDrawing->setDescription('Logo');
    $logo = 'assets/zhl-kop.PNG';
    $objDrawing->setPath($logo);
    $objDrawing->setCoordinates('A1');
    $objDrawing->setHeight(160);
    $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());

    foreach ($data as $r) {
      $date = date("d/m/Y",  strtotime($r->docdate));
      $to = $r->to;
      $attn = $r->attn;
      $from = $r->from;
      $carrier = $r->carrier;
      $voyage = $r->voyage;
      $eta = date("d/m/Y",  strtotime($r->etasin));
    }

    $objPHPExcel->setActiveSheetIndex(0)
      ->setCellValue('A10', 'DATE')
      ->setCellValue('B10', ': ' . $date)
      ->setCellValue('A11', 'TO')
      ->setCellValue('B11', ': ' . $to)
      ->setCellValue('A12', 'ATTN')
      ->setCellValue('B12', ': ' . $attn)
      ->setCellValue('A13', 'FROM')
      ->setCellValue('B13', ': ' . $from)
      ->setcellvalue('A15', 'RE :')
      ->setcellvalue('B15', 'LOADING CONFIRMATION')
      ->setCellValue('F16', 'PORTNET DECLARATION')
      ->setCellValue('A17', 'CONTAINER NO')
      ->setCellValue('C17', 'BOOKING REFF')
      ->setCellValue('D17', 'VESSEL / VOYAGE')
      ->setCellValue('B17', 'SEAL')
      ->setCellValue('E17', 'OP CODE')
      ->setCellValue('F17', 'PORT OF DISCH')
      ->setCellValue('G17', 'DESTINATION');

    $counter = 18;
    foreach ($data as $v) :
      $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('A' . $counter, $v->container)
        ->setCellValue('C' . $counter, $v->reff)
        ->setCellValue('D' . $counter, $v->vessel)
        ->setCellValue('B' . $counter, $v->seal)
        ->setCellValue('E' . $counter, $v->opcode)
        ->setCellValue('F' . $counter, $v->port)
        ->setCellValue('G' . $counter, $v->destination);
      $counter++;
    endforeach;

    $objPHPExcel->getActiveSheet()->getStyle('F16:G16')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
      ->getActiveSheet()->getStyle('A17:G17')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
      ->getActiveSheet()->getStyle('A17:G17')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
      ->getActiveSheet()->getStyle('A17:A' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
      ->getActiveSheet()->getStyle('B17:B' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
      ->getActiveSheet()->getStyle('C17:C' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
      ->getActiveSheet()->getStyle('D17:D' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
      ->getActiveSheet()->getStyle('E16:E' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
      ->getActiveSheet()->getStyle('F16:F' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
      ->getActiveSheet()->getStyle('G16:G' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
      ->getActiveSheet()->getStyle('A' . $counter . ':G' . $counter)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

    $counter++;

    $objPHPExcel->setActiveSheetIndex(0)
      ->setCellValue('A' . $counter, '1st Carrier')
      ->setCellValue('C' . $counter, ': ' . $carrier);
    $counter++;
    $objPHPExcel->setActiveSheetIndex(0)
      ->setCellValue('A' . $counter, 'Voyage')
      ->setCellValue('C' . $counter, $voyage);
    $counter++;
    $objPHPExcel->setActiveSheetIndex(0)
      ->setCellValue('A' . $counter, 'ETA Sin')
      ->setCellValue('C' . $counter, $eta);
    $counter++;
    $objPHPExcel->setActiveSheetIndex(0)
      ->setCellValue('A' . $counter, strtolower('PLS CONFIRM ALL DETAILS ARE CORRECT BEFORE 1ST CARRIER ARRIVAL'));
       $objPHPExcel->getActiveSheet()->getStyle('A' . $counter)->getFont()->setBold(true);  
    $counter++;
    $objPHPExcel->setActiveSheetIndex(0)
      ->setCellValue('A' . $counter, strtolower('CONTAINER MUST BE STOWE "UNDER DECK AWAY BOILER"'));
       $objPHPExcel->getActiveSheet()->getStyle('A' . $counter)->getFont()->setBold(true);  
    $counter++;
    $objPHPExcel->setActiveSheetIndex(0)
      ->setCellValue('A' . $counter, strtolower('REEFER CONTAINERS DO NOT REQUIRE THE "UNDER DECK AWAY BOILER" STOWAGE '));
       $objPHPExcel->getActiveSheet()->getStyle('A' . $counter)->getFont()
    ->setBold(true)  // Membuat font bold
    ->setColor(new PHPExcel_Style_Color(PHPExcel_Style_Color::COLOR_RED));
    $counter++;
    $objPHPExcel->setActiveSheetIndex(0)
      ->setCellValue('A' . $counter, strtolower('CONTAINER ARE DECLARED UNDER TRANSSHIPMENT'));
       $objPHPExcel->getActiveSheet()->getStyle('A' . $counter)->getFont()->setBold(true);  
    $counter++;
    $objPHPExcel->setActiveSheetIndex(0)
      ->setcellvalue('A' . $counter, strtolower('PLS INFORM US IMMEDIATELY OF ANY DISCREPANCY BEFORE 1st CARRIER ARRIVAL'));
       $objPHPExcel->getActiveSheet()->getStyle('A' . $counter)->getFont()->setBold(true);  
    $counter++;
    $objPHPExcel->setActiveSheetIndex(0)
      ->setcellvalue('A' . $counter, strtolower('OTHERWISE, ANY CHARGES INCURRED(E.G RENOMINATION, SHUT OUT ETC) WILL NOT BE BORNE BY ZHL'));
    $objPHPExcel->getActiveSheet()->getStyle('A' . $counter)->getFont()
    ->setBold(true)  // Membuat font bold
    ->setColor(new PHPExcel_Style_Color(PHPExcel_Style_Color::COLOR_RED));

    $objPHPExcel->getActiveSheet()->setTitle('Loading Confirmation');
    $objPHPExcel->setActiveSheetIndex(0);
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="Loading Confirmation ' . date("dmy") . '.xlsx"');
    header('Cache-Control: max-age=0');
    header('Cache-Control: max-age=1');
    header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
    header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
    header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
    header('Pragma: public'); // HTTP/1.0
    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
    $objWriter->save('php://output');
    exit;
  }

  //---------------------------------------------------------------------EXTRA-----------------------------------------------------
  public function convert($date)
  {
    $explode = explode("-", $date);

    $time = $explode[2] . '/' . $explode[1] . '/' . $explode[0];

    return $time;
  }
  //--------------------------------------------------------------------END----------------------------------------------------------------

  public function get_shipmentdate2()
  {
    $etd    = $this->input->get('etd');
    $id     = $this->input->get('id');
    $flag   = $this->input->get('flag');
    $shipid = $this->input->get('shipid');

    $data['ship']   = $this->m_shipping->get_shipmentdate($etd);
    $data['id']     = $id;
    $data['flag']   = $flag;
    $data['shipid'] = $shipid;
    $data['etd']    = $etd;
    $this->load->view('shipping/get_shipmentdate', $data);
  }

  public function get_shipmentdate()
  {
    $etd    = $_GET['etd'];
    $id     = $_GET['id'];
    $flag   = $_GET['flag'];
    $shipid = $_GET['shipid'];
    $count  = $_GET['count'];

    $data['ship'] = $this->m_shipping->get_shipmentdate($etd);
    $data['x'] = $id;
    $data['y'] = $flag;
    $data['z'] = $shipid;
    $data['w'] = $count;
    $this->load->view('shipping/get_shipmentdate', $data);
  }

  function container_inward_move_19032022()
  {
    $shipdate = $_GET['shipdate'];
    $id       = $_GET['id'];
    $flag     = $_GET['flag'];
    $et       = $_GET['et'];
    $shipid   = $_GET['shipid'];

    $this->m_shipping->containerinward_move($shipdate, $id, $flag, $et, $shipid);
  }

  function container_inward_move_multiple()
  {
    $shipdate = $this->input->get('shipdate');
    $id       = $this->input->get('id');
    $flag     = $this->input->get('flag');
    $shipid   = $this->input->get('shipid');
    $etd      = $this->input->get('etd');

    $this->m_shipping->containerinward_move_multiple($shipdate, $id, $flag, $shipid, $etd);
  }

  //------------------------------------------------------------Kelonggaran Marketing-----------------------------------------
  public function enable_update()
  {
    $shipid = $this->input->get('shipid');
    $this->m_shipping->enable_update($shipid);
  }

  public function enable_update_multiple()
  {
    $shipid = $this->input->get('shipid');
    $this->m_shipping->enable_update_multiple($shipid);
  }

  public function disable_update()
  {
    $shipid = $this->input->get('shipid');
    $this->m_shipping->disable_update($shipid);
  }

  public function disable_update_multiple()
  {
    $shipid = $this->input->get('shipid');
    $this->m_shipping->disable_update_multiple($shipid);
  }

  //-----------------------------------------------------------Container Barge------------------------------------------------

  public function container_shipper()
  {
    $group                   = strtoupper($this->session->userdata('groupid_1'));
    $data['container_inward'] = $this->m_shipping->tampil_cont_berdasarkan_barge($group);
    $this->template->display('shipping/container_barge_access', $data);
  }

  public function container_shipper_show()
  {
    $data['cont'] =  $this->m_shipping->tampil_cont_where_actual_seal($this->input->get('cont'));
    $this->template->display('shipping/container_list_shipper_show', $data);
  }

  public function container_shipper_save()
  {
    $id             = $this->input->post('id');
    $contid         = $this->input->post('contid');
    $container      = $this->input->post('container');
    $seal           = $this->input->post('seal');
    $orang_terakhir = strtoupper($this->session->userdata('userid_1'));
    $tanggal        = date('Y-m-d H:i:s');
    $jumlah         = count($id);

    $this->m_shipping->simpan_container_barge_operator($id, $contid, $container, $seal, $orang_terakhir, $tanggal, $jumlah);

    $this->session->set_flashdata('message', pesan('Containers and Seals Succesfully Save.', pesan_sukses()));
    redirect('shipping/container_shipper_show?cont=' . $contid);
  }

  function import_container_seal()
  {

    $contid = $this->input->post('contid');
    $tipe   = $this->input->post('tipe');
    $code   = $this->input->post('code');

    if (isset($_FILES["file"]["name"])) {
      $path           = $_FILES["file"]["tmp_name"];
      $object         = PHPExcel_IOFactory::load($path);
      foreach ($object->getWorksheetIterator() as $worksheet) {
        $highestRow     = $worksheet->getHighestRow();
        $highestColumn  = $worksheet->getHighestColumn();

        for ($row = 8; $row <= $highestRow; $row++) {

          $id                = $worksheet->getCellByColumnAndRow(13, $row)->getValue();
          $container         = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
          $seal              = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
          $tare_weight       = $worksheet->getCellByColumnAndRow(11, $row)->getValue();
          $trucking_date     = $worksheet->getCellByColumnAndRow(12, $row)->getValue();


          
          if($code == "pss"){
            $data = array(
              'container'      =>  $container,
              'actual_seal'    =>  $seal,
              'tare_weight'    =>  $tare_weight,
              'trucking_date'  =>  $trucking_date,
              'import_by'      =>  strtoupper($this->session->userdata('userid_1')),
              'import_date'    =>  date('Y-m-d H:i:s')
            );

            $this->m_shipping->update_container_and_seal($id, $data);
          }else{
            $data = array(
              'container_ggfs'      =>  $container,
              'actual_seal_ggfs'    =>  $seal,
              'tare_weight_ggfs'    =>  $tare_weight,
              'trucking_date_ggfs'  =>  $trucking_date,
              'import_by_ggfs'      =>  strtoupper($this->session->userdata('userid_1')),
              'import_date_ggfs'    =>  date('Y-m-d H:i:s')
            );
            
            $this->m_shipping->update_container_and_seal_ggfs($id, $data);
          }
        }
      }
    }

    $this->session->set_flashdata("message", "<div class=\"alert alert-success\" id=\"alert\">Upload Containers and Seals Success</div>");
    redirect('shipping/container_show?cont=' . $contid . '&tipe=' . $tipe);
  }

  public function container_import_excel()
  {
    $contid = $this->input->get('cont');
    $tipe   = $this->input->get('tipe');
    $code = $this->input->get('statimport');

    if($code == "ggfs"){
      $data['_getcont'] =  $this->m_shipping->tampil_cont_where_ggfs($this->input->get('cont'));
      $data['code'] = "ggfs";
    } else{
      $data['_getcont'] =  $this->m_shipping->tampil_cont_where($this->input->get('cont'));
      $data['code'] = "pss";
    }
    $this->template->display('shipping/excel_import', $data);
  }

  //--------------------------------------------------Import OUTWARD EXCEL----------------------------------------------------//

  public function outward_excel()
  {
    // $data['list_import']   = $this->m_shipping->get_list_import_excel();
    $data['list_customer'] = $this->m_shipping->get_customer_import();
    $data['list_shipment_date'] = $this->m_shipping->get_shipment_date_import();

    $this->template->display('develop/import-excel', $data);
  }

  public function import()
  {
    $this->load->library('PHPExcel');


    $file = $_FILES['excel_file']['tmp_name'];
    $inputFileType = PHPExcel_IOFactory::identify($file);
    $objReader = PHPExcel_IOFactory::createReader($inputFileType);
    $objPHPExcel = $objReader->load($file);

    $worksheet = $objPHPExcel->getActiveSheet();
    $highestRow = $worksheet->getHighestRow();
    $highestColumn = $worksheet->getHighestColumn();

    $file_ext = pathinfo($_FILES['excel_file']['name'], PATHINFO_EXTENSION);



    if (!in_array($file_ext, array('xlsx', 'xls'))) {
      echo json_encode(['code' => 400, 'message' => 'File Not Support']);
      die;
    }



    $dataHeader = [
      'vessel' => '',
      'voyage' => '',
      'etd' => '',
      'etdDate' => '',
      'eta' => '',
      'etaDate' => '',
      'shipmentDate' => '',
      'from' => '',
      'to' => '',
    ];

    $dataRows = $worksheet->toArray(null, true, true, true);


    if ($dataRows[2]['G'] === 'ZHENGHE LOGISTICS PTE LTD') {
      echo json_encode(['code' => 400, 'message' => 'Inv zhl is not supported in this module']);
      die;
    } else if ($dataRows[3]['J'] === 'Fairteck Holdings Pte Ltd' || $dataRows[3]['H'] === 'Fairteck Holdings Pte Ltd') {
      $customer = 'Fairteck Holdings Pte Ltd';
    } else if ($dataRows[4]['H'] === 'KARA MARKETING (M) SDN BHD' || $dataRows[4]['J'] === 'KARA MARKETING (M) SDN BHD' || stripos($dataRows[2]['H'], 'KARA MARKETING (M) SDN BHD') !== false) {
      $customer = 'KARA MARKETING (M) SDN BHD';
    } else if ($dataRows[3]['K'] === 'BEST BONANZA SDN BHD' || $dataRows[4]['L'] === 'BEST BONANZA SDN BHD') {
      $customer = 'BEST BONANZA SDN BHD';
    } else if ($dataRows[3]['J'] === 'First Grade Agency Pte Ltd' || $dataRows[3]['H'] === 'First Grade Agency Pte Ltd') {
      $customer = 'First Grade Agency Pte Ltd';
    } else {
      $customer = '';
    }


    if ($customer === 'ZHENGHE LOGISTICS PTE LTD') {
      $etd = $dataRows[4]['A'];
      $eta = $dataRows[5]['A'];
      $vessel = $dataRows[2]['C'];
      $voyage = $dataRows[3]['C'];
      $etdDate = $dataRows[4]['C'];
      $etaDate = $dataRows[5]['C'];
      $shipmentDate = str_replace("Shipment Date :", "", $dataRows[5]['G']);
      $from =  str_replace("From :", "", $dataRows[5]['J']);
      $to =  str_replace("To :", "", $dataRows[4]['J']);
      $starLine = 7;
      $tipe = $dataRows[4]['G'] == 'Outward List' ? 1 : 2;
    } else if ($customer === 'Fairteck Holdings Pte Ltd') {
      $tipe = $dataRows[5]['J'] == 'CONTAINER OUTWARD LIST' || $dataRows[4]['H'] == 'Container Outward List' ? 1 : 2;
      $etd = $tipe == 1  ? $dataRows[9]['B'] : $dataRows[12]['E'];
      $eta = $tipe == 1 ? $dataRows[9]['U'] : $dataRows[12]['L'];
      $vessel = $tipe == 1 ? $dataRows[7]['E'] : $dataRows[8]['E'];
      $voyage = $tipe == 1 ? $dataRows[8]['E'] : $dataRows[10]['E'];
      $etdDate = $tipe == 1 ? $dataRows[8]['L'] : $dataRows[10]['O'];
      $etaDate = $tipe == 1 ? $dataRows[9]['L'] : $dataRows[12]['O'];
      $shipmentDate = str_replace("Shipment", "", $tipe == 1 ? $dataRows[7]['H'] : $dataRows[8]['J']);
      $from = null;
      $to =  $tipe == 1 ? $dataRows[7]['U'] : $dataRows[9]['V'];
      $starLine = 18;
    } else if ($customer === 'KARA MARKETING (M) SDN BHD') {
      $tipe = $dataRows[7]['G'] == 'CONTAINER OUTWARD LIST' ? 1 : 2;
      $etd = $tipe == 1 ? $dataRows[6]['A'] : $dataRows[7]['A'];
      $eta = $tipe == 1 ? $dataRows[7]['A'] : $dataRows[8]['A'];
      $vessel = $tipe == 1 ? $dataRows[4]['C'] : $dataRows[5]['D'];
      $voyage = $tipe == 1 ? $dataRows[5]['C'] : $dataRows[6]['D'];
      $etdDate = $tipe == 1 ? $dataRows[6]['C'] : $dataRows[7]['D'];
      $etaDate = $tipe == 1 ? $dataRows[7]['C'] : $dataRows[8]['D'];
      $shipmentDate = str_replace("SHIPMENT DATE: ", "", $tipe == 1 ?  $dataRows[8]['G'] : $dataRows[7]['H']);
      // $from =  str_replace("FROM :", "", $tipe == 1 ?  $dataRows[8]['L'] : null);

      $from = substr($tipe == 1 ? $dataRows[8]['L'] : $dataRows[5]['J'], strpos($tipe == 1 ? $dataRows[8]['L'] : $dataRows[5]['J'], ':') + 2);

      $to = substr($tipe == 1 ? $dataRows[7]['L'] : $dataRows[6]['J'], strpos($tipe == 1 ? $dataRows[7]['L'] : $dataRows[6]['J'], ':') + 2);

      $starLine = 18;
    } else if ($customer === 'BEST BONANZA SDN BHD') {
      if (stripos($dataRows[3]['F'], 'ETD SINGAPORE') !== false) {
        $etd = 'ETD SINGAPORE';
      } else if (stripos($dataRows[3]['F'], 'ETD GTN') !== false) {
        $etd = 'PT Pulau Sambu Guntung';
      } else if (stripos($dataRows[3]['F'], 'ETD BURUNG') !== false) {
        $etd = 'PT Riau Sakti United Plantations';
      } else {
        $etd = 'Not Found';
      }

      if (stripos($dataRows[4]['F'], 'ETA SIN') !== false) {
        $eta = 'ETA SINGAPORE';
      } else if (stripos($dataRows[4]['F'], 'ETA GTN') !== false) {
        $eta = 'ETA PSG :';
      } else if (stripos($dataRows[4]['F'], 'ETA BURUNG') !== false) {
        $eta = 'ETA RSUP :';
      } else {
        $eta = 'Not Found';
      }

      $tipe = $dataRows[1]['A'] == 'OUTWARD LIST' ? 1 : 2;
      $etdDate =  trim(substr($dataRows[3]['F'], strpos($dataRows[3]['F'], ':') + 1));
      $etaDate = substr($dataRows[4]['F'], (strpos($dataRows[4]['F'], ':') + 2), 10);
      $vessel = $dataRows[2]['A'];
      $voyage = str_replace("VOY : ", "", $dataRows[3]['A']);
      $shipmentDate = str_replace("SHIPMENT", "", $dataRows[2]['F']);
      $from = substr($tipe == 2  ? $dataRows[2]['K'] : $dataRows[3]['L'], strpos($tipe == 2  ? $dataRows[2]['K'] : $dataRows[3]['L'], ": ") + 2);
      $to =  substr($tipe == 2  ? $dataRows[1]['K'] : $dataRows[2]['L'], strpos($tipe == 2  ? $dataRows[1]['K'] : $dataRows[2]['L'], ": ") + 2);
      $starLine = 18;
    } else if ($customer === 'First Grade Agency Pte Ltd') {
      $tipe = $dataRows[4]['H'] == 'Container Outward List' ? 1 : 2;
      $etd = $tipe == 1 ? $dataRows[9]['B'] : $dataRows[12]['E'];
      $eta = $tipe == 1 ? $dataRows[9]['U'] : $dataRows[12]['L'];
      $vessel = $tipe == 1 ? $dataRows[7]['E'] : $dataRows[8]['E'];
      $voyage = $tipe == 1 ? $dataRows[8]['E'] : $dataRows[10]['E'];
      $etdDate = $tipe == 1 ? $dataRows[8]['L'] : $dataRows[10]['O'];
      $etaDate = $tipe == 1 ? $dataRows[9]['L'] : $dataRows[12]['O'];
      $shipmentDate = str_replace("Shipment", "", $tipe == 1 ?  $dataRows[7]['H'] : $dataRows[8]['J']);
      // $from =  str_replace("FROM :", "", $tipe == 1 ?  $dataRows[8]['L'] : null);

      $from =  NULL;

      $to = $tipe == 1 ? $dataRows[9]['U'] : $dataRows[9]['V'];

      $starLine = 18;
    } else {
      echo json_encode(['code' => 400, 'message' => 'Customer Not Found']);
      die;
    }



    if (stripos($etd, 'ETD SINGAPORE') !== false || stripos($etd, 'ETD SIN') !== false) {
      $dataHeader['etd'] = 'SINGAPORE';
    } else if (stripos($etd, 'PT Pulau Sambu Guntung') !== false || stripos($etd, 'ETD PSG :') !== false || stripos($etd, 'ETD PSG') !== false) {
      $dataHeader['etd'] = 'PSG';
    } else if (stripos($etd, 'PT Riau Sakti United Plantations') !== false || stripos($etd, 'ETD RSUP :') !== false || stripos($etd, 'ETD RSUP') !== false || stripos($etd, 'ETD RUSP') !== false) {
      $dataHeader['etd'] = 'RSUP';
    }


    if (stripos($eta, 'ETA RSUP :') !== false || stripos($eta, 'ETA RUSP') !== false || stripos($eta, 'PT Riau Sakti United Plantations') !== false) {
      $dataHeader['eta'] = 'RSUP';
    } else if (stripos($eta, 'ETA PSG :') !== false || stripos($eta, 'PT Pulau Sambu Guntung') !== false) {
      $dataHeader['eta'] = 'PSG';
    } else if (stripos($eta, 'ETA SIN') !== false || stripos($eta, 'ETA SINGAPORE') !== false) {
      $dataHeader['eta'] = 'SINGAPORE';
    } else {
      $dataHeader['eta'] = 'Not Found';
    }

    $dataHeader['vessel'] = $vessel;
    $dataHeader['voyage'] = $voyage;
    $dataHeader['etdDate'] = setDateFormat2($etdDate, 'Y-m-d') == '' ? setDateFormat($etdDate, 'Y-m-d') : setDateFormat2($etdDate, 'Y-m-d');
    $dataHeader['etaDate'] = setDateFormat2($etaDate, 'Y-m-d') == '' ? setDateFormat($etaDate, 'Y-m-d') : setDateFormat2($etaDate, 'Y-m-d');
    $dataHeader['shipmentDate'] = setDateFormat($shipmentDate, 'Y-m-d');
    $dataHeader['from'] = str_replace("From :", "", $from);
    $dataHeader['to'] = str_replace("To : ", "", $to);
    $dataHeader['customer'] = $customer;
    $dataHeader['tipe'] = $tipe;

    $listData = [
      'dataHeader' => $dataHeader,
      'detail' => $dataRows, // Exclude header rows
    ];


    $data['excel_data'] = $listData;
    $data['disabled_button'] = 'disabled';



    $this->load->view('develop/preview-import', $data);
  }

  function export_excel_import($id)
  {

    $contid = $this->encryption->decrypt($id);
    error_reporting(E_ALL);
    ini_set('display_errors', TRUE);
    ini_set('display_startup_errors', TRUE);
    date_default_timezone_set('Europe/London');

    $data = $this->m_shipping->show_import($contid);

    if (PHP_SAPI == 'cli')
      die('This example should only be run from a Web Browser');
    // require_once dirname(__FILE__) . '/../libraries/PHPExcel.php';
    $objPHPExcel = new PHPExcel();
    $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
    $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(25);
    $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
    $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(5);
    $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(5);
    $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(5);
    $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(25);
    $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(25);
    $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
    $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(20);
    $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(10);
    $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(15);
    $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(10);

    $objPHPExcel->getActiveSheet()->getStyle(2)->getFont()->setBold(true)
      ->getActiveSheet()->getStyle('G2')->getFont()->setSize(18)
      ->getActiveSheet()->getStyle(3)->getFont()->setBold(true)
      ->getActiveSheet()->getStyle(4)->getFont()->setBold(true)
      ->getActiveSheet()->getStyle(5)->getFont()->setBold(true)
      ->getActiveSheet()->getStyle(7)->getFont()->setBold(true)
      ->getActiveSheet()->getStyle(7)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    foreach ($data as $r) {
      $shipmentdate = date("dmy",  strtotime($r->shipmentdate));
      $barge = $r->barge;
      $voyage = $r->voyage;
      $etd = $r->etd;
      $etddate = date("d/m/Y",  strtotime($r->etddate));
      $eta = $r->eta;
      $etadate = date("d/m/Y",  strtotime($r->etadate));
      $shipment = date("d M Y",  strtotime($r->shipmentdate));
      $remark = str_replace("<br />", "", $r->remarks);
      $from = $r->from;
      $to = $r->to;
      $customer = $r->customer;
      $tipe = $r->tipe;
    }



    $objPHPExcel->setActiveSheetIndex(0)
      ->setCellValue('A2', 'Vessel (Barge) :')
      ->setCellValue('C2', $barge)
      ->setCellValue('A3', 'Voyage :')
      ->setCellValue('C3', $voyage . ' ')
      ->setCellValue('A4', 'ETD ' . $etd . ' :')
      ->setCellValue('C4', $etddate)
      ->setCellValue('A5', 'ETA ' . $eta . ' :')
      ->setCellValue('C5', $etadate)
      ->setCellValue('G2', $customer)
      ->setCellValue('G4', $tipe == 1 ? 'Container Outward List' : 'Container Inward List')
      ->setCellValue('G5', 'Shipment Date : ' . $shipment)
      ->setCellValue('J4', 'To: ' . $to)
      ->setCellValue('J5', 'From : ' . $from)
      ->setCellValue('A7', 'No')
      ->setCellValue('B7', 'Shipper/Carrier')
      ->setCellValue('C7', 'Vessel/Voyage')
      ->setCellValue('D7', "20'")
      ->setCellValue('E7', "40'")
      ->setCellValue('F7', 'CT')
      ->setCellValue('G7', 'Booking Ref')
      ->setCellValue('H7', 'Depot')
      ->setCellValue('I7', 'POD')
      ->setCellValue('J7', 'Final Dest')
      ->setCellValue('K7', 'OP Code')
      ->setCellValue('L7', 'ETA Sin');

    $no = 1;
    $counter = 8;
    $C20 = 0;
    $C40 = 0;
    $po_temp = '';
    foreach ($data as $v) :
      $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('A' . $counter, $no++)
        ->setCellValue('B' . $counter, $v->shipping)
        ->setCellValue('C' . $counter, $v->vessel)
        ->setCellValue('D' . $counter, $v->container_size_20)
        ->setCellValue('E' . $counter, $v->container_size_40)
        ->setCellValue('F' . $counter, $v->container_type)
        ->setCellValue('G' . $counter, $v->reff)
        ->setCellValue('H' . $counter, $v->depot)
        ->setCellValue('I' . $counter, $v->pod)
        ->setCellValue('J' . $counter, $v->destination)
        ->setCellValue('K' . $counter, $v->opcode)
        ->setCellValue('L' . $counter, $v->eta_sin);



      $counter++;
      $C20 += $v->container_size_20;
      $C40 += $v->container_size_40;

    endforeach;

    $objPHPExcel->setActiveSheetIndex(0)
      ->setCellValue('D' . $counter, $C20)
      ->setCellValue('E' . $counter, $C40);

    $objPHPExcel->getActiveSheet()->getStyle('A7:L7')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
      ->getActiveSheet()->getStyle('A7:L7')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
      ->getActiveSheet()->getStyle('A7:A' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
      ->getActiveSheet()->getStyle('B7:B' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
      ->getActiveSheet()->getStyle('C7:C' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
      ->getActiveSheet()->getStyle('D7:D' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
      ->getActiveSheet()->getStyle('E7:E' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
      ->getActiveSheet()->getStyle('F7:F' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
      ->getActiveSheet()->getStyle('G7:G' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
      ->getActiveSheet()->getStyle('H7:H' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
      ->getActiveSheet()->getStyle('I7:I' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
      ->getActiveSheet()->getStyle('J7:J' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
      ->getActiveSheet()->getStyle('K7:K' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
      ->getActiveSheet()->getStyle('L7:L' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
      ->getActiveSheet()->getStyle('A' . $counter . ':L' . $counter)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
      ->getActiveSheet()->getStyle('A' . $counter . ':L' . $counter)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

    $counter++;
    $objPHPExcel->setActiveSheetIndex(0)
      ->setCellValue('A' . $counter, 'REMARKS')
      ->setCellValue('A' . $counter++, $remark);

    $objPHPExcel->getActiveSheet()->setTitle(getInOutward($tipe));
    $objPHPExcel->setActiveSheetIndex(0);
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header("Content-Disposition: attachment;filename=$customer " . getInOutward($tipe) . " " . setDateFormat($shipment, 'dmy') . ".xlsx");
    header('Cache-Control: max-age=0');
    header('Cache-Control: max-age=1');
    header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
    header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
    header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
    header('Pragma: public'); // HTTP/1.0
    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
    $objWriter->save('php://output');
    exit;
  }

  function show_import($contid)
  {
    if ($this->input->is_ajax_request()) {


      $list = $this->m_shipping->show_import($contid);

      $row = $list[0];

      $dataHeader['vessel'] = $row->barge;
      $dataHeader['voyage'] =  $row->voyage;
      $dataHeader['etd'] =  $row->etd;
      $dataHeader['etdDate'] =  $row->etddate;
      $dataHeader['eta'] =  $row->eta;
      $dataHeader['etaDate'] =  $row->etadate;
      $dataHeader['shipmentDate'] =  $row->shipmentdate;
      $dataHeader['from'] =  $row->from;
      $dataHeader['to'] =  $row->to;
      $dataHeader['customer'] =  $row->customer;
      $dataHeader['tipe'] =  $row->tipe;
      $dataHeader['contid'] =  $row->contid;

      $listData = [
        'dataHeader' => $dataHeader,
        'detail' => $list, // Exclude header rows
      ];


      $data['excel_data'] = $listData;
      $data['disabled_button'] = 'disabled';
      $data['show'] = "true";
      $this->load->view('develop/preview-import', $data);
    }
  }


  function importAction()
  {
    if ($this->input->is_ajax_request()) {

      try {
        $param = $this->input->post();


        if ($this->m_shipping->validateImport($param)) {
          echo json_encode(['code' => 400, 'message' => 'Data Already Exists']);
          die;
        }

        if (is_null($this->m_shipping->getCustomerCode($param['customer']))) {
          echo json_encode(['code' => 400, 'message' => 'Customer Not Found']);
          die;
        }


        $exec = $this->m_shipping->strore_import($param);
        if ($exec == true) {
          echo json_encode(['code' => 200, 'message' => 'Save Data Success']);
        } else {
          echo json_encode(['code' => 400, 'message' => 'Wrong Queries']);
        }
      } catch (\Throwable $th) {
        echo json_encode(['code' => 400, 'message' => $th->getMessage()]);
      }
    }
  }

  function getDataImport()
  {
    $data = [
      "nama" => "Aziz",
      "pekerjaan" => "Programmer"
    ];
    echo json_encode($data);
  }

  function refreshMonImportInOutward()
  {
    if ($this->input->is_ajax_request()) {

      $param = $this->input->get();

      $data['list_import'] = $this->m_shipping->get_list_import_excel($param);

      $this->load->view('develop/last_import', $data);
    }
  }

  function deleteImport($contid)
  {
    if ($this->input->is_ajax_request()) {

      if ($this->validateJurnalImport($contid) === true) {
        echo json_encode(['code' => 400, 'message' => 'Data Already Journal']);
        die;
      }



      $exec = $this->m_shipping->deleteImport($contid);

      if ($exec) {
        echo json_encode(['code' => 200, 'message' => 'Deleted Data Success']);
      } else {
        echo json_encode(['code' => 400, 'message' => 'Wrong Queries']);
      }
    }
  }


  function import_outwardexcel()
  {

    $contid = $this->input->post('contid');
    $tipe   = $this->input->post('tipe');

    if (isset($_FILES["file"]["name"])) {
      $path           = $_FILES["file"]["tmp_name"];
      $object         = PHPExcel_IOFactory::load($path);
      foreach ($object->getWorksheetIterator() as $worksheet) {
        $highestRow     = $worksheet->getHighestRow();
        $highestColumn  = $worksheet->getHighestColumn();

        for ($row = 8; $row <= $highestRow; $row++) {

          $id                = $worksheet->getCellByColumnAndRow(13, $row)->getValue();
          $container         = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
          $seal              = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
          $tare_weight       = $worksheet->getCellByColumnAndRow(11, $row)->getValue();
          $trucking_date     = $worksheet->getCellByColumnAndRow(12, $row)->getValue();


          $data = array(
            'container'      =>  $container,
            'seal'           =>  $seal,
            'tare_weight'    =>  $tare_weight,
            'trucking_date'  =>  $trucking_date,
            'import_by'      =>  strtoupper($this->session->userdata('userid_1')),
            'import_date'    =>  date('Y-m-d H:i:s')
          );

          // $this->m_shipping->update_container_and_seal($id, $data);
        }
      }
    }

    $this->session->set_flashdata("message", "<div class=\"alert alert-success\" id=\"alert\">Upload Containers and Seals Success</div>");
    redirect('shipping/container_show?cont=' . $contid . '&tipe=' . $tipe);
  }

  function validateJurnalImport($contid)
  {
    $sql = $this->db->get_where("zhl_ship_tbl_trn_cont_hdr_import", ['contid' => $contid, 'jurnal_impor_excel' => 1])->row();

    if (count($sql) > 0) return true;

    return false;
  }


  //----------------------------------------------------------- Track Container ------------------------------------------------


  public function receipt_container($id = null)
  {

    // New Data
    $data['factory']            = $this->m_shipping->tampil_factory();
    $data['gettype']            = $this->m_shipping->gettype();
    $data['listContainerZhl']   = $this->Marketting->container_zhl_get_all();
    $data['listStatus']         = $this->StatusContainer->get_all();
    $data['id'] = $id;


    // For Update Data
    if ($id != null) {
      $data['listTrxContainer']   = $this->m_shipping->get_penerimaan_container_by_id($id);
      $data['trans_id']           = set_value('trans_id', $data['listTrxContainer']['header']->trans_id);
      $data['doc_no']             = set_value('doc_no', $data['listTrxContainer']['header']->trans_date);
      $data['shipment_date']      = set_value('shipment_date', $data['listTrxContainer']['header']->shipment_date);
      $data['arrival_date']       = set_value('arrival_date', $data['listTrxContainer']['header']->arrival_date);
      $data['type']               = set_value('type', $data['listTrxContainer']['header']->trans_type);
      $data['vessel']             = set_value('vessel', $data['listTrxContainer']['header']->vessel);
      $data['voyage']             = set_value('voyage', $data['listTrxContainer']['header']->voyage);
      $data['etd']                = set_value('etd', $data['listTrxContainer']['header']->etd);
      $data['eta']                = set_value('eta', $data['listTrxContainer']['header']->eta);
      $data['remarks_hdr']        = set_value('remarks_hdr', $data['listTrxContainer']['header']->remarks);
      // echo "<pre>";
      // print_r($data);
      // die;
    }


    // echo "<pre>";
    // print_r($data['listStatus']);
    // die;
    $this->template->display('shipping/receipt_container', $data);
  }

  public function track_container()
  {
    $data['title']   = 'test';
    $data['factory'] = $this->m_shipping->tampil_factory_for_track();
    $data['message'] = '';

    $data['cont_local_ready_in_zhl']     = $this->m_shipping->tampil_cont_local_read_zhl();
    $data['list_shipment_date']          = $this->m_shipping->get_all_shipment(2);
    $data['list_shipment_date2']         = $this->m_shipping->get_all_shipment(1);
    $data['cont_location']               = $this->m_shipping->get_all_cont_location();


    // echo "<pre>";
    // print_r($data['cont_location']);
    // echo "</pre>";
    // die;



    $this->template->display('shipping/mon/track_container', $data);
  }

  function get_container_local_ready_factory()
  {
    $param = $this->input->get();
    $data['cont_local_ready_in_factory'] = $this->m_shipping->tampil_cont_local_read_factory($param);
    $this->load->view('shipping/list_container_factory', $data);
  }

  function get_filter_by_ajax()
  {


    $param = [
      "shipment_date"     => date("Y-m-d", strtotime($this->input->get("shipment_date"))),
      "eta"               => $this->input->get("location"),
      "tipe"              => $this->input->get("tipe"),
      "container_number"  => $this->input->get("container_number"),
    ];
    $data['listContainer'] = $this->m_shipping->getTrackContainer($param);

    // echo json_encode($data);
    // die;



    if ($param['tipe'] == 1) {
      $this->load->view('shipping/mon/mon_track_container_filter', $data);
    } elseif ($param['tipe'] == 2) {
      $this->load->view('shipping/mon/mon_track_container_filter_2', $data);
    }
  }

  function save_penerimaan_container()
  {
    $param = $this->input->post();

    if ($param['trans_id'] > 0) {
      $exec = $this->m_shipping->update_penerimaan_container($param);
    } else {
      $exec = $this->m_shipping->save_penerimaan_container($param);
    }


    echo json_encode($exec);
  }

  function save_ship_to_inward()
  {
    $param = $this->input->post();

    $exec = $this->m_shipping->save_ship_to_inward($param);
    // echo json_encode(["code" => 400, "message" => $param]);
    // die;
    if ($exec) {
      echo json_encode(["code" => 200, "message" => $exec]);
    } else {
      echo json_encode(["code" => 400, "message" => "Ship To Inward Failed"]);
    }
  }

  function save_ship_to_outward()
  {
    $param = $this->input->post();

    $exec = $this->m_shipping->save_ship_to_outward($param);
    if ($exec) {
      echo json_encode(["code" => 200, "message" => $exec]);
    } else {
      echo json_encode(["code" => 400, "message" => "Ship To Outward Failed"]);
    }
  }

  // function save_ship_to_outward()
  // {
  //     $param = $this->input->post();



  //     // Validation

  //     if (strlen($param['shipment_date']) == 0) {
  //         echo json_encode(['code' => 400, 'message' => 'shipement date is required']);
  //         die;
  //     }

  //     if (strlen($param['vessel']) == 0) {
  //         echo json_encode(['code' => 400, 'message' => 'vessel (barge) is required']);
  //         die;
  //     }

  //     if (strlen($param['voyage']) == 0) {
  //         echo json_encode(['code' => 400, 'message' => 'voyage is required']);
  //         die;
  //     }

  //     if (strlen($param['eta_date']) == 0) {
  //         echo json_encode(['code' => 400, 'message' => 'eta date is required']);
  //         die;
  //     }

  //     if (strlen($param['from']) == 0) {
  //         echo json_encode(['code' => 400, 'message' => 'from is required']);
  //         die;
  //     }

  //     if (strlen($param['to']) == 0) {
  //         echo json_encode(['code' => 400, 'message' => 'to is required']);
  //         die;
  //     }

  //     // End Validation

  //     if (!$this->validationContainer($param, 1)) {
  //         echo json_encode(['code' => 400, 'message' => 'Shipment Already Exists']);
  //         die;
  //     }


  //     if ($param['is_inward'] == 1) {
  //         $exec = $this->m_shipping->save_ship_to_inward($param);
  //         if ($exec) {
  //             echo json_encode(['code' => 200, 'message' => 'Save Inward List Success', 'id' => $exec, 'tipe' => 2]);
  //         } else {
  //             echo json_encode(['code' => 400, 'message' => 'Wrong Queries']);
  //         }
  //     } else if ($param['is_inward'] == 0) {
  //         $exec = $this->m_shipping->save_ship_to_outward($param);
  //         if ($exec) {
  //             echo json_encode(['code' => 200, 'message' => 'Save Ourward List Success', 'id' => $exec, 'tipe' => 1]);
  //         } else {
  //             echo json_encode(['code' => 400, 'message' => 'Wrong Queries']);
  //         }
  //     } else {
  //         echo json_encode(['code' => 400, 'message' => 'Not Found']);
  //     }





  //     // $exec = $this->m_shipping->save_ship_to_inward($param);
  //     // echo json_encode(["code" => 200, "message" => $exec]);
  //     // if ($exec) {
  //     // } else {
  //     //     echo json_encode(["code" => 200, "message" => "Ship To Inward Failed"]);
  //     // }
  // }

  public function receipt_containerall()
  {
    $data['loading'] =  $this->m_shipping->tampil_receiptcontainer($this->input->get('loadall'));

    $this->load->view('shipping/receipt_containerall', $data);
  }


  function validationContainer($param, $tipe)
  {
    if ($param['shipment_date']) {
      $sql = $this->db->get_where("ship_tbl_trn_cont_hdr", ['shipmentdate' => setDateFormat($param['shipment_date'], "Y-m-d"), 'tipe' => $tipe, 'eta' => $param['eta']])->row();
      if (count($sql) > 0) return false;
    }

    return true;
  }

  function print_tracking_pdf()
  {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {


      $param = $this->input->post();

      $data['listData'] = json_decode(json_encode($this->m_shipping->getTrackContainer($param)));


      // echo "<pre>";
      // print_r($data);
      // echo "</pre>";
      // die;

      // echo json_encode($data);
      // die;
      $this->load->library('pdfgenerator');
      $html = $this->load->view('shipping/container_tracking_pdf', $data, true);
      $this->pdfgenerator->createPDF($html, 'mypdf', false);

      // $this->load->view('shipping/container_tracking_pdf', $data);
    }
  }

  function check_status_container()
  {
    $param = $this->input->post();

    foreach ($param['receivedId'] as $val) {
      $row = $this->db->get_where("ship_tbl_trn_cont_acceptance_dtl", ["is_outward" => 0, "id" => $val, "status" => 2])->row();
      if ($row) {
        echo json_encode(true);
        die;
      }
    }

    echo json_encode(false);
    die;
  }
  function get_count_shipment_by_container_type()
  {

    $this->db->select('COUNT(*) as value, container_type as label');
    $this->db->from('ship_tbl_trn_cont_local_dtl a');
    $this->db->join('ship_tbl_trn_cont_hdr b', 'a.contid = b.contid');
    $this->db->where('b.shipmentdate', $this->input->get('shipmentDate'));
    $this->db->group_by('container_type');

    $query = $this->db->get();

    $result = $query->result_array();
    echo json_encode($result);
  }

  // function get_license_expired(){
    
  //   zhl_tims_mst_vehicle
  // }


  public function container_stock_report()
  {
      error_reporting(E_ALL);
      ini_set('display_errors', TRUE);
      ini_set('display_startup_errors', TRUE);
      date_default_timezone_set('Europe/London');

      $factory = $this->input->get('factory');
      $supplier = $this->input->get('supplier');
      $loading_port = $this->input->get('loading_port');
      $year = $this->input->get('year');
      $month = $this->input->get('month');
      $container = $this->input->get('container');
      $data =  $this->m_shipping->tampil_container_stock_filter($factory, $supplier, $loading_port,$year,$month,$container);

      if (PHP_SAPI == 'cli')
          die('This example should only be run from a Web Browser');

      $objPHPExcel = new PHPExcel();

      $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
      $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(25);
      $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
      $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(25);
      $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(60);
      $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(25);
      $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
      $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
      $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(30);
      $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(35);
      $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(25);
      $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(15);
      $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(25);

      $objPHPExcel->getActiveSheet()->getStyle(2)->getFont()->setBold(true)
          ->getActiveSheet()->getStyle('G2')->getFont()->setSize(18)
          ->getActiveSheet()->getStyle(3)->getFont()->setBold(true)
          ->getActiveSheet()->getStyle(4)->getFont()->setBold(true)
          ->getActiveSheet()->getStyle(5)->getFont()->setBold(true)
          ->getActiveSheet()->getStyle(7)->getFont()->setBold(true)
          ->getActiveSheet()->getStyle(7)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

      $objDrawing = new PHPExcel_Worksheet_Drawing();
      $objDrawing->setName('Logo');
      $objDrawing->setDescription('Logo');
      $logo = 'assets/ZHL-Report.png';
      $objDrawing->setPath($logo);
      $objDrawing->setCoordinates('F2');
      $objDrawing->setHeight(80);
      $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());

      $objPHPExcel->setActiveSheetIndex(0)
          
          ->setCellValue('G2', 'ZHENGHE LOGISTIC PTE LTD')
          ->setCellValue('G4', 'Return, Transfer And Used Containers')
          ->setCellValue('J4', 'Supplier : ' . $supplier)
          ->setCellValue('J5', 'Factory : ' . $factory)
          ->setCellValue('J6', 'Loading Port : ' . $loading_port)
          ->setCellValue('A7', 'No')
          ->setCellValue('B7', 'Stock Status')
          ->setCellValue('C7', 'Container Number')
          ->setCellValue('D7', 'Container Type')
          ->setCellValue('E7', 'Remark')
          ->setCellValue('F7', 'Loading Port')
          ->setCellValue('G7', 'Arrival Date')
          ->setCellValue('H7', 'Free Time')
          ->setCellValue('I7', 'Factory')
          ->setCellValue('J7', 'Supplier')
          ->setCellValue('K7', 'Import BL NO')
          ->setCellValue('L7', 'ETA PSG/RSUP')
          ->setCellValue('M7', 'Free Time Expiry Date');

      $no = 1;
      $counter = 8;
      foreach ($data as $v) :

          //========Countdown from Expiry Date============
          $awal  = strtotime($v->free_time_expiry);
          $tempo = time();
          $count_down = floor(($awal - $tempo) / (86400));
          //==============================================

           if ($v->status_note == '0') {
              $status_note ="Stock Ready";
          } elseif ($v->status_note == '1') {
              $status_note ="Stock Has Been Used";
          } elseif ($v->status_note == '2') {
              $status_note ="Return to Singapore";
          } elseif ($v->status_note == '3') {
              $status_note ="Transfer From Stock Container";
          }

          if($v->factory=='RSUP'){
                      $factory = "Riau Sakti Unites Plantations";
                  }elseif($v->factory=='PSG'){
                      $factory = "Pulau Sambu Guntung";
                  }else{
                      $factory = "Insert Factory...!!!";
                  }

      
          $objPHPExcel->setActiveSheetIndex(0)
              ->setCellValue('A' . $counter, $no++)
              ->setCellValue('B' . $counter, $status_note)
              ->setCellValue('C' . $counter, $v->container_number)
              ->setCellValue('D' . $counter, $v->container_name)
              ->setCellValue('E' . $counter, $v->Remark)
              ->setCellValue('F' . $counter, $v->loading_port)
              ->setCellValue('G' . $counter, $v->arrival_date)
              ->setCellValue('H' . $counter, $v->free_time)
              ->setCellValue('I' . $counter, $factory)
              ->setCellValue('J' . $counter, $v->supplier)
              ->setCellValue('K' . $counter, $v->import_bl_no)
              ->setCellValue('L' . $counter, $v->eta)
              ->setCellValue('M' . $counter, $v->free_time_expiry);

         


          $counter++;
      
      endforeach;

     

      $objPHPExcel->getActiveSheet()->getStyle('A7:M7')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
          ->getActiveSheet()->getStyle('A7:M7')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
          ->getActiveSheet()->getStyle('A7:A' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
          ->getActiveSheet()->getStyle('B7:B' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
          ->getActiveSheet()->getStyle('C7:C' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
          ->getActiveSheet()->getStyle('D7:D' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
          ->getActiveSheet()->getStyle('E7:E' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
          ->getActiveSheet()->getStyle('F7:F' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
          ->getActiveSheet()->getStyle('G7:G' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
          ->getActiveSheet()->getStyle('H7:H' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
          ->getActiveSheet()->getStyle('I7:I' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
          ->getActiveSheet()->getStyle('J7:J' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
          ->getActiveSheet()->getStyle('K7:K' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
          ->getActiveSheet()->getStyle('L7:L' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
          ->getActiveSheet()->getStyle('M7:M' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
          ->getActiveSheet()->getStyle('A' . $counter . ':M' . $counter)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
          ->getActiveSheet()->getStyle('A' . $counter . ':M' . $counter)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

      $objPHPExcel->getActiveSheet()->setTitle('Container Stock');
      $objPHPExcel->setActiveSheetIndex(0);
      header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
      header('Content-Disposition: attachment;filename="Container Stock.xlsx"');
      header('Cache-Control: max-age=0');
      header('Cache-Control: max-age=1');
      header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
      header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
      header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
      header('Pragma: public'); // HTTP/1.0
      $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
      $objWriter->save('php://output');
      exit;
  }


  ////////////////////////////////////////////////////////////////////////////////////////////////
  public function import_outward_preview()
  {
      $this->load->library('PHPExcel');
      $filePath = $_FILES['excel_file']['tmp_name'];

      if (!file_exists($filePath)) {
          echo "File tidak ditemukan.";
          return;
      }

      try {
          $objPHPExcel = PHPExcel_IOFactory::load($filePath);
      } catch (Exception $e) {
          die('Error loading file "' . pathinfo($filePath, PATHINFO_BASENAME) . '": ' . $e->getMessage());
      }

      // ====== Sheet 1 (index 0) -> tabel pertama ======
      $sheet1 = $objPHPExcel->getSheet(0);

      $headerData = [
          'vessel_barge'  => $sheet1->getCell('B2')->getValue(),
          'voyage'        => $sheet1->getCell('B3')->getValue(),
          'etd_singapore' => date('d-m-Y', PHPExcel_Shared_Date::ExcelToPHP($sheet1->getCell('B4')->getValue())),
          'eta_psg'       => date('d-m-Y', PHPExcel_Shared_Date::ExcelToPHP($sheet1->getCell('B5')->getValue())),
          'to'            => $sheet1->getCell('M4')->getValue(),
          'from'          => $sheet1->getCell('M5')->getValue(),
      ];

      $dataArray = $this->_parseOutwardSheet($sheet1);

      // ====== Sheet 2 (index 1) -> tabel ketiga (GGFS) ======
      $dataArrayGgfs = [];
      if ($objPHPExcel->getSheetCount() > 1) {
          $sheet2        = $objPHPExcel->getSheet(1);
          $dataArrayGgfs = $this->_parseOutwardSheet($sheet2);
      }

      $this->session->set_flashdata('import_result', [
          'status'    => 'success',
          'header'    => $headerData,
          'data'      => $dataArray,
          'data_ggfs' => $dataArrayGgfs,
      ]);

      redirect('shipping/container');
  }

  /**
   * Parse satu sheet outward menjadi array baris (sudah ter-ekspansi per qty 20'/40').
   * Dipakai untuk Sheet 1 (tabel pertama) maupun Sheet 2 (GGFS).
   */
  private function _parseOutwardSheet($sheet)
  {
      $fields = [
          'B' => 'shipper',
          'C' => 'vessel',
          'D' => 'c20',
          'E' => 'c40',
          'F' => 'ct',
          'G' => 'reff',
          'H' => 'depot',
          'I' => 'pod',
          'J' => 'dest',
          'K' => 'opcode',
          'L' => 'etasin',
          'M' => 'eta',
      ];

      $dataArray  = [];
      $highestRow = $sheet->getHighestRow();

      for ($row = 8; $row <= $highestRow; $row++) {
          $rowData    = [];
          $rowHasData = false;

          foreach ($fields as $col => $fieldName) {
              $cellValue = $sheet->getCell($col . $row)->getValue();

              if ($fieldName == 'date') {
                  if (PHPExcel_Shared_Date::isDateTime($sheet->getCell($col . $row))) {
                      $cellValue = date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($cellValue));
                  }
              }

              if ($cellValue !== null && $cellValue !== '') {
                  $rowHasData = true;
              }
              $rowData[$fieldName] = $cellValue;
          }

          if ($rowHasData) {
              $qty20 = (int) $rowData['c20'];
              $qty40 = (int) $rowData['c40'];

              if ($qty20 > 0) {
                  for ($i = 0; $i < $qty20; $i++) {
                      $newRow         = $rowData;
                      $newRow['size'] = "20'";
                      $dataArray[]    = $newRow;
                  }
              } elseif ($qty40 > 0) {
                  for ($i = 0; $i < $qty40; $i++) {
                      $newRow         = $rowData;
                      $newRow['size'] = "40'";
                      $dataArray[]    = $newRow;
                  }
              }
          }
      }

      return $dataArray;
  }

  public function container_po_ex()
  {
    $data = $this->m_shipping->tampil_po($this->input->get('fac'), $this->input->get('schedule'), $this->input->get('po'));
    echo json_encode( $data);
  }

      
  // ggfs =========================================================================================================================
  public function container_po_ggfs()
  {
    $data['po_ggfs'] = $this->m_shipping->tampil_po_ggfs($this->input->get('fac'), $this->input->get('schedule'), $this->input->get('po'));
    $this->load->view('shipping/container_list_po_ggfs', $data);
  }

  public function container_po_outward_ggfs()
  {
    $data['po'] = $this->m_shipping->tampil_po_outward_ggfs($this->input->get('po_cout'));
    $this->load->view('shipping/container_list_po_outward_ggfs', $data);
  }

  public function sendto_flowcargoes_all_ggfs()
  {
    $contid = $this->input->get('contid');
    $cont = $this->m_shipping->get_container($contid);

    if ($cont) {
      $count = 0;

      foreach ($cont as $value) {

        if ($value->container != '') {
          if ($count  >= 10) {
            break;
          }
          $data =  ["formData" => [["containerNumber" => $value->container]], "uploadType" => "FORM_BY_CONTAINER_NUMBER"];
          $res = $this->insert_flowcargoes($data);
          $res_array = json_decode($res);
          if ($res_array->result == 'SUCCESS') {
            $this->m_shipping->setflag_flowcharges_ggfs($value->detail_id);
            $count++;
          }
        }
      }

      if ($count > 0) {
        echo json_encode(['result' => 'SUCCESS']);
      } else {
        echo json_encode(['result' => 'ERROR']);
      }
    } else {
      echo json_encode(['result' => 'NO DATA TO SYNC']);
    }
  }

  public function sendto_flowcargoes_bycheck_ggfs()
  {

    $detailid = $this->input->get('detailid');
    $remove_ = substr($detailid, 0, -1);
    $ex_id = explode('-', $remove_);
    $count = 0;

    foreach ($ex_id as $value) {
      $cont = $this->m_shipping->get_containerdetailid_ggfs($value);
      if ($cont->container != '') {
        $data =  ["formData" => [["containerNumber" => $cont->container]], "uploadType" => "FORM_BY_CONTAINER_NUMBER"];
        $res = $this->insert_flowcargoes($data);
        $res_array = json_decode($res);
        if ($res_array->result == 'SUCCESS') {
          $this->m_shipping->setflag_flowcharges_ggfs($cont->detail_id);
          $count++;
        }
      }
    }

    if ($count > 0) {
      echo json_encode(['result' => 'SUCCESS']);
    } else {
      echo json_encode(['result' => 'ERROR']);
    }
  }

  public function container_local_delete_ggfs()
  {
    $id = $this->input->get('id');
    $this->m_shipping->delete_container_local_hdr_ggfs($id);
  }

  public function container_shippping_delete_multiple_ggfs()
  {

    $id_inward  = $this->input->post('id');
    $id_outward = $this->input->post('flag');

    $update = $this->m_shipping->delete_container_shipping_ggfs($id_inward, $id_outward);
    if ($update) {
      return true;
    } else {
      return false;
    }
  }

  public function container_shippping_delete_outward_ggfs()
  {
    $id     = $this->input->get('stock');
    $shipid = $this->input->get('shipid');
    $contid = $this->input->get('contid');

    $this->m_shipping->delete_container_shipping_outward_ggfs($id, $shipid, $contid);
  }

  public function enable_update_ggfs()
  {
    $shipid = $this->input->get('shipid');
    $this->m_shipping->enable_update_ggfs($shipid);
  }

   public function enable_update_multiple_ggfs()
  {
    $shipid = $this->input->get('shipid');
    $this->m_shipping->enable_update_multiple_ggfs($shipid);
  }

  public function disable_update_ggfs()
  {
    $shipid = $this->input->get('shipid');
    $this->m_shipping->disable_update_ggfs($shipid);
  }

  public function disable_update_multiple_ggfs()
  {
    $shipid = $this->input->get('shipid');
    $this->m_shipping->disable_update_multiple_ggfs($shipid);
  }

  public function container_po_ex_ggfs()
  {
    $data = $this->m_shipping->tampil_po_ggfs($this->input->get('fac'), $this->input->get('schedule'), $this->input->get('po'));
    echo json_encode( $data);
  }
}
