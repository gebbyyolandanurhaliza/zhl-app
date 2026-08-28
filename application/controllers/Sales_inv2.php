<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Sales_inv2 extends CI_Controller
{
  function __construct()
  {
    parent::__construct();
    $this->load->model(array('M_Sales_inv2', 'm_purchasing', 'M_purchase_inv', 'M_vcdn', 'M_Mst_COA', 'M_mar_master'));
    define('FPDF_FONTPATH',  $this->config->item('fonts_path'));
    $this->load->library(array('Fpdf', 'PHPExcel'));

    if (!$this->session->userdata('userid_1')) {
      redirect('login');
    }
  }

  // ============================  Halaman Utama ==============================================
  function index()
  {
    $data['customer'] = $this->M_Sales_inv2->get_cust();
    $data['title'] = "List of Sales Invoice Jurnal";
    $data['List_receive'] = $this->M_Sales_inv2->get_piutang();
    $this->template->display('accounting/Sales_inv_factory_new/Sales_inv_factory_list', $data);
  }

  function search() {
        $data['customer'] = $this->M_Sales_inv2->get_cust();
        $invoice          = $this->input->get("invoice");

        $dari   = str_replace('/', '-', $this->input->get('dari'));
        $p_dari = date('Y-m-d', strtotime($dari));

        $sampai   = str_replace('/', '-', $this->input->get("sampai"));
        $p_sampai = date('Y-m-d', strtotime($sampai));


        $supplier    = $this->input->get("supplier");
        $data['tgl'] = $dari;
        if ($dari != '') {
            $data['List_receive'] = $this->M_Sales_inv2->advance_list_piutang($p_dari, $p_sampai, $invoice, $supplier);            
        } else {
            $data['List_receive'] = $this->M_Sales_inv2->advance_list_piutang1($invoice, $supplier);
        }

        $this->template->display('accounting/Sales_inv_factory_new/Sales_inv_factory_list', $data);
  }
  // =========================== END ============================================================

  // ================================== Halaman buat dan edit invoice ============================
  function add_new()
  {
    // $id = $_GET['supplier'];
    // var_dump($id);
    // die;
    $data['customer'] = $this->M_Sales_inv2->get_cust();
    $data['Currency'] = $this->M_purchase_inv->get_currency();
    $data['List_coa'] = $this->M_vcdn->get_coa_old();
    $data['vessel'] = $this->M_Sales_inv2->vessel_list();
    $data['message'] = '';
    $data['bank'] = $this->M_vcdn->tampil_bank();

    $this->template->display('accounting/Sales_inv_factory_new/Sales_inv_form', $data);
  }

  function getTerm(){
    $id = $_GET['supplier'];
    $data['term'] = $this->M_Sales_inv2->get_term($id);
    echo json_encode($data);
  }
  function edit()
  {
    $id = $_GET['id'];
    $data['Currency']        = $this->M_purchase_inv->get_currency();
    $data['get_data_header'] = $this->M_Sales_inv2->get_data_header($id);
    $data['customer']        = $this->M_Sales_inv2->get_cust();
    $data['nota']            = $this->M_Sales_inv2->nota($id);
    $data['dtlctr']          = $this->M_Sales_inv2->get_dtlctr($id);
    $data['dtlctr2']         = $this->M_Sales_inv2->get_dtlctr2($id);
    $data['dtlctrtruck']     = $this->M_Sales_inv2->get_dtlctrtruck($id);
    $data['dtlctr2truck']    = $this->M_Sales_inv2->get_dtlctr2truck($id);
    $data['get_data_detail'] = $this->M_Sales_inv2->get_data_detail($id);

    //gebby
    usort($data['get_data_detail'], function($a, $b) {
        return $a->DetailID - $b->DetailID;
    });

    // echo "<pre>";
    // print_r($data['get_data_header']);
    // echo "</pre>";
    // die;
    $data['vessel']          = $this->M_Sales_inv2->vessel_list();
    $data['bank'] = $this->M_vcdn->tampil_bank();
    $data['message']         = '';


    if (!$data['get_data_header']) {
      echo '<script>alert("data not found !")</script>';
      redirect('Sales_inv2', 'refresh');
      exit();
    }

    $this->template->display('accounting/Sales_inv_factory_new/Sales_inv_form', $data);
  }

  function delete_transaction()
  {
    $id = $_GET['id'];
    $this->M_Sales_inv2->delete_all($id);
    redirect("Sales_inv2/edit?id=" . $id);
  }
  // =================================         END ADD AN EDIT       ==============================



  // ================================== Halaman PRINT SALES INVOICE ============================

  function printerin()
  {
    $id  = $_GET['id'];
    $inv = $_GET['inv'];

    $data['get_data_header'] = $this->M_Sales_inv2->get_data_header($id);

    if ($inv == 'bargefreight') {
      $data['get_data_detail'] = $this->M_Sales_inv2->get_data_detail_bargefreight($id);
    } else {
      $data['get_data_detail'] = $this->M_Sales_inv2->get_data_detail($id);
    }

    $data['total'] = $this->M_Sales_inv2->get_total($id);
    // var_dump($data['total']);
    // die;
    $data['get_currency'] = $this->M_mar_master->bank_get_all();
    $gst_array = [];

    if ($data['get_data_detail']) {
      foreach ($data['get_data_detail'] as $dtl) {
        $gst_array[] = $dtl->gst_type;
      }
    }

    if (in_array('GST', $gst_array)) {
      $data['gst_type'] = 'GST';
    } else {
      $data['gst_type'] = "";
    }

    if ($inv == 'fre') {
      $this->printerin2();
    } elseif ($inv == 'lem') {
      $this->load->view('accounting/Sales_inv_factory_new/SI_print_eim', $data);
    } elseif ($inv == 'eim') {
      $this->load->view('accounting/Sales_inv_factory_new/SI_print_eim', $data);
    } else if ($inv == 'tet' || $inv == 'chinaShipment') {
      $this->load->view('accounting/Sales_inv_factory_new/SI_print_tet', $data);
    } else if ($inv == 'bargefreight') {
      $this->load->view('accounting/Sales_inv_factory_new/SI_print_bargefreight', $data);
    } else {
      $this->load->view('accounting/Sales_inv_factory_new/SI_print', $data);
    }
  }
  

  function printerin2()
  {
    ob_start();
    $id = $_GET['id'];
    $inv = $_GET['inv'];
    $data['_header'] = $this->M_Sales_inv2->get_data_header($id);
    $data['tampil_item'] = $this->M_Sales_inv2->get_data_detail2($id);
    $data['total']           = $this->M_Sales_inv2->get_total($id);
    $this->load->view('accounting/Sales_inv_factory_new/SI_print_freight2', $data);
    $html   = ob_get_contents();
    ob_end_clean();

    require_once('./assets/html2pdf/html2pdf.class.php');
    $pdf    = new HTML2PDF('P', 'A4', 'en');
    $pdf->writeHTML($html);
    $pdf->Output('Freigth Charge ' . $id . '.pdf');
  }

  function printerintet()
  {
    ob_start();
    $id  = $_GET['id'];
    $inv = $_GET['inv'];

    $data['_header']     = $this->M_Sales_inv2->get_data_header($id);
    $data['tampil_item'] = $this->M_Sales_inv2->get_data_detailtet($id);
    $data['total']       = $this->M_Sales_inv2->get_total($id);

    $this->load->view('accounting/Sales_inv_factory_new/SI_print_tet', $data);
    $html   = ob_get_contents();
    ob_end_clean();

    require_once('./assets/html2pdf/html2pdf.class.php');
    $pdf    = new HTML2PDF('P', 'A4', 'en');
    $pdf->writeHTML($html);
    // $pdf->Output('Tetrapak Shipment ' . $id . '.pdf');
    $pdf->Output('China Shipment ' . $id . '.pdf');
  }

  function print_cont()
  {
    $id = $_GET['id'];
    $data['dtlctr'] = $this->M_Sales_inv2->get_dtlctr_new($id);
    $data['get_data_header'] = $this->M_Sales_inv2->get_data_header($id);
    $this->load->view('accounting/Sales_inv_factory_new/print_cont', $data);
  }

  function printpreview_detail()
  {
    ob_start();
    $tgl = str_replace('/', '-', $this->input->get('tgl'));
    $tgl_awal = date('Y-m-d', strtotime($tgl));
    $tgl_akhir = date('Y-m-t', strtotime($tgl));
    $data['tampil_item'] = $this->M_Sales_inv2->get_detail_freigth2($tgl_awal, $tgl_akhir);
    $this->load->view('accounting/Sales_inv_factory_new/printpreview_fre', $data);
    $html   = ob_get_contents();
    ob_end_clean();

    require_once('./assets/html2pdf/html2pdf.class.php');
    $pdf    = new HTML2PDF('P', 'A4', 'en');
    $pdf->writeHTML($html);
    $pdf->Output('Freigth Charge review (' . $tgl . ').pdf');
  }
  // =================================         END PRINT      ==============================

  // ================================= CRUD DISINI YA ============================================
  function save_sales_inv()
  {
    $nofaktur          = $this->input->post('nofaktur'); //hedaerID
    $tgl_jurnal        = str_replace('/', '-', $this->input->post('tgl_jurnal'));
    $p_tanggal         = date('Y-m-d', strtotime($tgl_jurnal)); //tanggal jurnal
    $tgl_tempo         = str_replace('/', '-', $this->input->post('tgl_tempo'));
    $p_tanggal_tempo   = date('Y-m-d', strtotime($tgl_tempo)); // tanggal tempo
    $tgl_invoice       = str_replace('/', '-', $this->input->post('tgl_invoice'));
    $p_tanggal_invoice = date('Y-m-d', strtotime($tgl_invoice)); // tanggal shipment
    $supplier          = $this->input->post('supplier');
    $rate              = $this->input->post('rate_header');
    $rate_sgd          = $this->input->post('rate_sgd');
    $currency          = $this->input->post('Currency');
    $term              = $this->input->post('term');
    $totalinv          = $this->input->post('totalinv');
    $totalinvusd       = $this->input->post('totalinvusd');
    $total_gst         = $this->input->post('totalgst');
    $totalamount       = $this->input->post('stotalinv');
    $bargename         = $this->input->post('barge');
    $paymentto         = $this->input->post('paymentto');
    $typeinv           = $this->input->post('invtype');
    $buyer             = $this->input->post('buyername');
    $barge_dest        = $this->input->post('dest_barge');
    $ports             = $this->input->post('portes');

    $etddate      = str_replace('/', '-', $this->input->post('tgl_etd'));
    $etd_date     = date('Y-m-d', strtotime($etddate));
    $etadate      = str_replace('/', '-', $this->input->post('tgl_eta'));
    $eta_date     = date('Y-m-d', strtotime($etadate));
    $shipmentdate = str_replace('/', '-', $this->input->post('tgl_shipment'));
    $ship_date    = date('Y-m-d', strtotime($shipmentdate));

    $dtlcont      = $this->input->post('detailidcont');
    $accountid    = $this->input->post('accNum');
    $deptCode    = $this->input->post('dept_code');
    $itemname     = $this->input->post('det_items');
    $prepared_by    = $this->input->post('prepared_by');
    $desc         = $this->input->post('descr');
    $unit         = $this->input->post('unit');
    $jenis_barge  = $this->input->post('jenisbarge');
    $txtHarga     = $this->input->post('txtHarga');
    $txtHargaUsd  = $this->input->post('txtUSD');
    $txtgst       = $this->input->post('txtGST');
    $txtgstvalue  = $this->input->post('txtGSTValue');
    $submit_value = $this->input->post('sbt');
    $remarks = $this->input->post('remarks');

    $created_by = $this->session->userdata('userid_1');
    $ip_address = $_SERVER['REMOTE_ADDR'];

    if ($nofaktur == '') {
      $p_tahun    = date('Y', strtotime($tgl_jurnal));
      $p_bulan    = date('m', strtotime($tgl_jurnal));
      $sql_faktur = $this->M_Sales_inv2->get_nofaktur($p_tahun, $p_bulan);
      $nofaktur   = $sql_faktur;
    }

    if ($submit_value == 'Save') {
      $perintah = 'add';
    } else {
      $perintah = 'edit';
      $this->M_Sales_inv2->hapus($nofaktur);
    }

    //  tambahan 19-04-2018
    $id_cointaner = $this->input->post('idcontainer');
    //tambahan 27-04-2018
    $txtTotal = $this->input->post('txtTotal');

    //input detai_container
    // $container_name = $this->input->post('container_name');
    $container_id            = $this->input->post('container_id');
    $contid                  = $this->input->post('contid');
    $container_number        = $this->input->post('container_number');
    $seal_number             = $this->input->post('seal_number');

    $container_id2           = $this->input->post('container_id2');
    $contid2                 = $this->input->post('contid2');
    $container_number2       = $this->input->post('container_number2');
    $seal_number2            = $this->input->post('seal_number2');


    $container_id_truck      = $this->input->post('container_id_truck');
    $contid_truck            = $this->input->post('contid_truck');
    $container_number_truck  = $this->input->post('container_number_truck');
    $seal_number_truck       = $this->input->post('seal_number_truck');

    $container_id2_truck     = $this->input->post('container_id2_truck');
    $contid2_truck           = $this->input->post('contid2_truck');
    $container_number2_truck = $this->input->post('container_number2_truck');
    $seal_number2_truck      = $this->input->post('seal_number2_truck');
    // insert detail
    for ($i = 0; $i < count($dtlcont); $i++) {
      if ($txtTotal[$i] != 0) {
        $data_detail = array(
          'p_headerid'     => $nofaktur,
          'p_itemid'       => $id_cointaner[$i],
          'p_itemname'     => $itemname[$i],
          'p_qty'          => 1,
          'p_unit'         => $unit[$i],
          'p_price'        => round(str_replace(",", "", $txtHarga[$i]),  2),
          'p_amount'       => round(str_replace(",", "", $txtTotal[$i]),  2),
          'p_currency'     => $currency,
          'p_rate'         => $rate,
          'p_usdequivalen' => round(str_replace(",", "", $txtHargaUsd[$i]),  2),
          'p_npbb'         => $dtlcont[$i],
          'p_user'         => $created_by,
          'p_ip'           => $ip_address,
          'p_NoCOA'        => $accountid[$i],
          'P_deptcode'     => $deptCode[$i],
          'p_ratesgd'      => $rate_sgd,
          'p_gst'          => $txtgst[$i],
          'p_gst_value'    => round(str_replace(",", "", $txtgstvalue[$i]),  2),
          'p_detcont'      => $dtlcont[$i],
          'p_typebarge'    => $jenis_barge[$i],
          'p_decript'      => $desc[$i],
          'p_tanggal'      => $p_tanggal,
          'p_cust'         => $supplier,
          'p_jenin'        => $typeinv
        );

        $this->M_Sales_inv2->call_save_dtl($data_detail);
      }
    }


    if (count($container_id) > 0) {
      for ($ii = 0; $ii < count($container_id); $ii++) {
        $data_container_dtl = array(
          'p_jurnal'       => $nofaktur,
          'p_cont_type'    => $container_id[$ii],
          'p_cont_number'  => $container_number[$ii],
          'p_seal'         => $seal_number[$ii],
          'p_contid'       => $contid[$ii],
          'p_jenis_trans'  => 'SIJV',
          'p_jenis_jurnal' => $typeinv
        );
        $hasil = $this->M_Sales_inv2->call_save_container_dtl($data_container_dtl);
      }
    }

    if (count($container_id2) > 0) {
      for ($iii = 0; $iii < count($container_id2); $iii++) {
        $data_container_dtl2 = array(
          'p_jurnal'       => $nofaktur,
          'p_cont_type'    => $container_id2[$iii],
          'p_cont_number'  => $container_number2[$iii],
          'p_seal'         => $seal_number2[$iii],
          'p_contid'       => $contid2[$iii],
          'p_jenis_trans'  => 'SIJV',
          'p_jenis_jurnal' => $typeinv
        );
        // echo "<pre>";
        // print_r($data_container_dtl2);
        // echo "</pre>";
        $this->M_Sales_inv2->call_save_container_dtl2($data_container_dtl2);
      }
    }

    if (count($container_id_truck) > 0) {
      for ($ii = 0; $ii < count($container_id_truck); $ii++) {
        $data_container_dtl = array(
          'p_jurnal'       => $nofaktur,
          'p_cont_type'    => $container_id_truck[$ii],
          'p_cont_number'  => $container_number_truck[$ii],
          'p_seal'         => $seal_number_truck[$ii],
          'p_contid'       => $contid_truck[$ii],
          'p_jenis_trans'  => 'SIJV',
          'p_jenis_jurnal' => $typeinv
        );
        // echo "<pre>";
        // print_r($data_container_dtl);
        // echo "</pre>";

        $this->M_Sales_inv2->call_save_container_dtl_truck($data_container_dtl);
      }
    }

    if (count($container_id2_truck) > 0) {
      for ($iii = 0; $iii < count($container_id2_truck); $iii++) {
        $data_container_dtl2 = array(
          'p_jurnal'       => $nofaktur,
          'p_cont_type'    => $container_id2_truck[$iii],
          'p_cont_number'  => $container_number2_truck[$iii],
          'p_seal'         => $seal_number2_truck[$iii],
          'p_contid'       => $contid2_truck[$iii],
          'p_jenis_trans'  => 'SIJV',
          'p_jenis_jurnal' => $typeinv
        );
        // echo "<pre>";
        // print_r($data_container_dtl2);
        // echo "</pre>";
        $this->M_Sales_inv2->call_save_container_dtl2_truck($data_container_dtl2);
      }
    }

    //insert container detail
    // p_jurnal VARCHAR(50), p_cont_type int, p_cont_number VARCHAR(50), p_seal VARCHAR(50), p_contid BIGINT, p_jenis_trans VARCHAR(50), p_jenis_jurnal VARCHAR(50)

    // insert header
    $data_header = array(
      'p_perintah'        => $perintah,
      'p_nofaktur'        => $nofaktur,
      'p_company_id'      => 'ZHL',
      'p_tanggal'         => $p_tanggal,
      'p_tanggal_tempo'   => $p_tanggal_tempo,
      'p_tanggal_invoice' => $p_tanggal_invoice,
      'p_kode_sup'        => $supplier,
      'p_jenis_trans'     => 'SIJV',
      'p_currency_id'     => $this->input->post('Currency'),
      'p_term'            => $term,
      'p_rate'            => $rate,
      'p_rate_sgd'        => $rate_sgd,
      'p_pajak'           => round(str_replace(",", "", $total_gst), 2),
      'p_diskon'          => 0,
      'p_biaya_lain'      => 0,
      'p_uang_muka'       => 0,
      'p_hutang'          => round(str_replace(",", "", $totalamount), 2),
      'p_status'          => '0',
      'p_created_by'      => $created_by,
      'p_ip_address'      => $ip_address,
      'p_nocoa'           => 0,
      'p_status_dp'       => 0,
      'p_jenin'           => $typeinv,
      'p_voyage'          => $bargename,
      'p_buyer'           => $buyer,
      'p_bargedest'       => $barge_dest,
      'p_shipmentdate'    => $ship_date,
      'p_etadate'         => $eta_date,
      'p_etddate'         => $etd_date,
      'p_remarks'         => $remarks,
      'p_paymentto'       => $paymentto,
      'p_prepared_by' => $prepared_by

    );

    $this->M_Sales_inv2->call_sp_rec_piutang($data_header);
    redirect("Sales_inv2/edit?id=" . $nofaktur);
    // $this->template->display("'""");
  }
  //=================================    END CRUD     ============================================

  // ==================================== AJAX SEMUA DISINI ============================================
  function getAjaxTanggal()
  {
    $id = $this->input->get('jeninv');
    $barge = $this->input->get('bargedest');
    $io =  $this->input->get('outwardinward');
    //    print_r($io);
    //          die;
    // $data['_tgl'] = $this->M_Sales_inv2->getAjaxTanggal($id, $barge);
    if ($id == 'lem' || $id == 'eim') {
      $data['_tgl'] = $this->M_Sales_inv2->getAjaxTanggal2($id, $barge);
    } else if ($id == 'tet' || $id == 'chinaShipment') {
      $data['_tgl'] = $this->M_Sales_inv2->getAjaxTanggaltet($id, $barge);
    } else if ($id == 'bargefreight') {
      $data['_tgl'] = $this->M_Sales_inv2->get_shipmentdate_barge();
    } else if ($id == 'invexcel') {
      $data['_tgl'] = $this->M_Sales_inv2->get_shipmentdate_invexcel($io);
    } else {
      $data['_tgl'] = $this->M_Sales_inv2->getAjaxTanggal($id, $barge);
    }

    $this->load->view('accounting/Sales_inv_factory_new/Ajax/GetTanggal', $data);
  }

  function getAjaxVoyage()
  {
    $tgl_shipment = $this->input->get('tgl_shipment');
    $tgl = str_replace('/', '-', $tgl_shipment);
    $tgl_db = date('Y-m-d', strtotime($tgl));
    $vessel = $this->input->get('vessel');

    $data['voyages'] = $this->M_Sales_inv2->getVoyage($tgl_db, $vessel);
    $this->load->view('accounting/Sales_inv_factory_new/Ajax/get_voyage_no', $data);
  }


  function get_detail()
  {
    if (($_GET['date'] === 'undefined') or empty($_GET['date'])) {
      $tgl = '2015-01-01';
    } else {
      $tgl = date('Y-m-d', strtotime($this->convert($this->input->get('date'))));
    }
    $supp = $_GET['supp'];
    $inv = $_GET['invtype'];
    $port = $_GET['port'];
    $vesselname = $_GET['vesselname'];
    // echo $vesselname;

    $data['_detail'] = $this->M_Sales_inv2->get_isidetail($tgl, $supp, $inv, $port, $vesselname);
    $this->load->view('accounting/Purchase_inv_factory/Ajax/get_isidet', $data);
  }

  function get_detail_freigth()
  {
    $tgl = str_replace('/', '-', $this->input->get('tgl'));
    $tgl_awal = date('Y-m-d', strtotime($tgl));
    $tgl_akhir = date('Y-m-t', strtotime($tgl));

    $data['_detail'] = $this->M_Sales_inv2->get_detail_freigth($tgl_awal, $tgl_akhir);
    // var_dump($data['_detail']);
    // die;
    $this->load->view("accounting/Sales_inv_factory_new/Ajax/get_isidet_freigthinv", $data);
    // echo $tgl_awal;
    // echo $tgl_akhir;
  }

  function get_detail_freigthcont()
  {
    $tgl = str_replace('/', '-', $this->input->get('tgl'));
    $tgl_awal = date('Y-m-d', strtotime($tgl));
    $tgl_akhir = date('Y-m-t', strtotime($tgl));
    $data['_detail'] = $this->M_Sales_inv2->get_detail_freigthcont($tgl_awal, $tgl_akhir);
    $this->load->view("accounting/Sales_inv_factory_new/Ajax/get_isidet_freigthinvcont", $data);
  }

  function get_detailfre()
  {
    if (($_GET['date'] === 'undefined') or empty($_GET['date'])) {
      $tgl = '2015-01-01';
    } else {
      $tgl = date('Y-m-d', strtotime($this->convert($this->input->get('date'))));
    }
    $supp = $_GET['supp'];
    $inv = $_GET['invtype'];
    $port = $_GET['port'];
    $vesselname = $_GET['vesselname'];
    // echo $vesselname;

    $data['_detail'] = $this->M_Sales_inv2->get_isidetail_new($tgl, $supp, $inv, $port, $vesselname);
    $this->load->view('accounting/Sales_inv_factory_new/Ajax/get_isidet_dtlctr', $data);
  }

  function get_detail2()
  {
    // $duaft = 0;
    // $empatft = 0;
    // $duaft2 = 0;
    // $empatft2 = 0;
    // $data['_detail'] = $this->M_Sales_inv2->get_isidetail2($tgl, $bargedest);
    // $data['_detail2'] = $this->M_Sales_inv2->get_isilclcont($tgl, $bargedest);

    if (($_GET['date'] === 'undefined') or empty($_GET['date'])) {
      $tgl = '2015-01-01';
    } else {
      $tgl = date('Y-m-d', strtotime($this->convert($this->input->get('date'))));
    }

    $bargedest = $this->input->get('bargedest'); //destination
    $invtype   = $this->input->get('invtype'); // invoice type
    $sup       = $this->input->get('sup'); // supplier_id G00178
   
    $vessel    = $this->input->get('vessel');
    $oi        = $this->input->get('oi');
    $voyage_no = $this->input->get('voyage_no');
    $data['sup'] = $sup;
    if ($invtype == 'lem' || $invtype == 'eim') {
      $data['_detail2'] = $this->M_Sales_inv2->get_isilclcont2_1($tgl, $bargedest, $sup); //local ship_vw_container_local2
      $data['_ft2'] = $this->M_Sales_inv2->get_2ft3($tgl, $bargedest); //ship_vw_container_local2
    } else if ($invtype == 'tet' || $invtype == 'chinaShipment') {
      // $data['_detailet'] = $this->M_Sales_inv2->get_isidetailtet($tgl, $bargedest); // ELTP
      // $data ['_tetdetail'] = $this->M_Sales_inv2->get_isilclconttet($tgl, $bargedest,$sup); //CONTAINER LOCAL LLTP
      // $data ['_tetft'] = $this->M_Sales_inv2->get_2ft3tet($tgl, $bargedest); //GET CONTAINER LOCAL (LLTP)
      $data['_detailtet'] = $this->M_Sales_inv2->get_isidetailTET($tgl, $bargedest, $sup); // ship_vw_trn_cont
      $data['_fttet'] = $this->M_Sales_inv2->get_2ftTET($tgl, $bargedest); //ship_vw_trn_cont
      $data['_detail2tet'] = $this->M_Sales_inv2->get_isidetailTET2($tgl, $bargedest, $sup); //local ship_vw_container_local2
      $data['_fttet2'] = $this->M_Sales_inv2->get_2ftTET2($tgl, $bargedest);  //ship_vw_container_local2

    } else if ($invtype == 'bargefreight') {
      $data['_detail'] = $this->M_Sales_inv2->get_dtl_bargefreight($tgl, $sup, $vessel, $voyage_no);
    } else if ($invtype == 'invexcel') {
      $data['_detailinvexcel'] = $this->M_Sales_inv2->get_dtl_invexcel($tgl, $sup, $oi);
    } else {
      $data['_detail']  = $this->M_Sales_inv2->get_isidetail2($tgl, $bargedest, $sup); // ship_vw_trn_cont
      $data['_detail2'] = $this->M_Sales_inv2->get_isilclcont($tgl, $bargedest, $sup);  //ship_vw_container_local2
      // if ($invtype != 'bar') {
      $data['_detail3'] = $this->M_Sales_inv2->get_isilclcont2($tgl, $bargedest); //ship_vw_container_local2
      // }
      $data['_ft1']     = $this->M_Sales_inv2->get_2ft($tgl, $bargedest, $sup); //ship_vw_trn_cont
      // var_dump($data['_ft1']);
      $data['_ft2']     = $this->M_Sales_inv2->get_2ft2($tgl, $bargedest, $sup); //ship_vw_container_local2
      $data['_ft3']     = $this->M_Sales_inv2->get_2ft3($tgl, $bargedest); //ship_vw_container_local2
      // $duaft2  = $this->M_Sales_inv2->get_2ft2();
    }


    


    $this->load->view('accounting/Sales_inv_factory_new/Ajax/get_isidet', $data);
  }

  function get_detail3()
  {
    //detail container
    if (($_GET['date'] === 'undefined') or empty($_GET['date'])) {
      $tgl = '2015-01-01';
    } else {
      $tgl = date('Y-m-d', strtotime($this->convert($this->input->get('date'))));
    }
    $bargedest = $this->input->get('bargedest'); //destination
    $sup = $this->input->get('sup'); // supplier_id
    $invtype = $this->input->get('invtype');  //tipe invoice

    // $data['_detail'] = $this->M_Sales_inv2->get_isidetail3($tgl, $bargedest);
    // $data['_detail2'] = $this->M_Sales_inv2->get_isilclcontdtl($tgl, $bargedest);

    if ($invtype == 'lem' || $invtype == 'eim') {
      $data['_detail2'] = $this->M_Sales_inv2->get_isilclcontdtl2_1($tgl, $bargedest); //ship_vw_container_local2
    } else if ($invtype == 'tet' || $invtype == 'chinaShipment') {
      $data['_detailtet'] = $this->M_Sales_inv2->get_isilclcontdtltet($tgl, $bargedest); //ship_vw_container_local2 LLTP
      //PENTIG $data['_detailtet1'] = $this->M_Sales_inv2->get_isidetailtet($tgl, $bargedest); //ship_vw_trn_cont ELTP
    } else {
      $data['_detail'] = $this->M_Sales_inv2->get_isidetail3($tgl, $bargedest); //ship_vw_trn_cont
      $data['_detail2'] = $this->M_Sales_inv2->get_isilclcontdtl($tgl, $bargedest, $sup); //ship_vw_container_local2 LL/LO
      $data['_detail3'] = $this->M_Sales_inv2->get_isilclcontdtl2($tgl, $bargedest); //ship_vw_container_local2 LE/EI
    }

    $this->load->view('accounting/Sales_inv_factory_new/Ajax/get_isidet_dtlctr', $data);
  }

  function get_detail4()
  {
    if (($_GET['date'] === 'undefined') or empty($_GET['date'])) {
      $tgl = '2015-01-01';
    } else {
      $tgl = date('Y-m-d', strtotime($this->convert($this->input->get('date'))));
    }
    $bargedest = $this->input->get('bargedest');
    $sup = $this->input->get('sup');

    // $data['_detail'] = $this->M_Sales_inv2->get_isidetail3($tgl, $bargedest);
    // $data['_detail2'] = $this->M_Sales_inv2->get_isilclcontdtl($tgl, $bargedest);
    $invtype = $this->input->get('invtype');

    if ($invtype == 'lem' || $invtype == 'eim') {
      $data['_detail2'] = $this->M_Sales_inv2->get_2ft3detail($tgl, $bargedest); //ship_vw_container_local2
    } else if ($invtype == 'tet' || $invtype == 'chinaShipment') {
      $data['_detailtet'] = $this->M_Sales_inv2->get_2ft3detailtet($tgl, $bargedest); //ship_vw_container_local2
    } else {
      $data['_detail'] = $this->M_Sales_inv2->get_2ftdetail($tgl, $bargedest); //ship_vw_trn_cont
      $data['_detail2'] = $this->M_Sales_inv2->get_2ft2detail($tgl, $bargedest, $sup); //ship_vw_container_local2
      $data['_detail3'] = $this->M_Sales_inv2->get_2ft3detail($tgl, $bargedest); //ship_vw_container_local2
    }

    $this->load->view('accounting/Sales_inv_factory_new/Ajax/get_isidet_dtlctr_truck', $data);
  }


  function get_sup()
  {
    if (($_GET['date'] === 'undefined') or empty($_GET['date'])) {
      $date1 = '2015-01-01';
    } else {
      $date1 = date('Y-m-d', strtotime($this->convert($this->input->get('date'))));
    }
    $id = $_GET['type'];
    $data['buyer'] = $this->M_Sales_inv2->get_sup($date1, $id);
    $this->load->view('accounting/Sales_inv_factory_new/Ajax/get_sup_inv', $data);
  }

  function get_port()
  {
    if (($_GET['date'] === 'undefined') or empty($_GET['date'])) {
      $date1 = '2015-01-01';
    } else {
      $date1 = date('Y-m-d', strtotime($this->convert($this->input->get('date'))));
    }
    $id = $_GET['type'];
    $buyer = $_GET['buyer'];
    $port = $this->M_Sales_inv2->get_port($date1, $id, $buyer);



    if (!empty($port)) {
      $style_kategori = 'class="select2me form-control" id="portes" onKeydown="return validasi_enter(event)" onchange="get_vessel()" name="portes" required';
      echo form_dropdown('portes', $port, '', $style_kategori);
    } else {
      echo "	<select name='port' id='portes' class='form-control'>
        				<option></option>
        			</select>";
    }
  }

  function get_vessel()
  {
    if (($_GET['date'] === 'undefined') or empty($_GET['date'])) {
      $tgl = '2015-01-01';
    } else {
      $tgl = date('Y-m-d', strtotime($this->convert($this->input->get('date'))));
    }
    $supp = $_GET['supp'];
    $inv = $_GET['invtype'];
    $port = $_GET['port'];

    $vessel = $this->M_Sales_inv2->get_vessel($tgl, $supp, $inv, $port);

    if (!empty($vessel)) {
      $style_kategori = 'class="select2me form-control" id="vesselname" onKeydown="return validasi_enter(event)" onchange="isi_barge();get_isi();get_isi_det();" required';
      echo form_dropdown('vesselname', $vessel, '', $style_kategori);
    } else {
      echo "  <select id='vesselname' class='form-control'>
                        <option></option>
                    </select>";
    }
  }

  function getharga()
  {
    $idcon = $_GET['idcont'];

    $jenisinv = $_GET['jen'];
    // var_dump($idcon);
    $x = $_GET['x'];
    $idd = "txtHarga-" . $x;
    $sup = $_GET['sup'];



    $sql = $this->M_Sales_inv2->get_harga($idcon, $jenisinv, $sup);
    echo "<input type='text' name='txtHarga[]' class='txt number txtHarga dariAjax' id='$idd' onchange='hitung_total($x)' value='$sql'>";
    // echo "<input type='text' >"$sql;
    // return $sql;
  }

  function geteta()
  {
    $barge = $_GET['destbarge'];
    $shipdate = $_GET['shipdate'];

    $tgl = str_replace('/', '-', $shipdate);
    $p_tanggal = date('Y-m-d', strtotime($tgl)); //tanggal jurnal

    $data = $this->M_Sales_inv2->geteta($barge, $p_tanggal);

    $eta_tgl = '';
    if ($data) {
      $eta_tgl =  date('d/m/Y', strtotime($data->etadate));
    }
    echo "<input type='text' name='tgl_eta' value='$eta_tgl' id='tgl_eta' class='form-control' data-date-format='dd/mm/yyyy' readonly>";
  }

  function getetd()
  {
    $barge = $_GET['destbarge'];
    $shipdate = $_GET['shipdate'];

    $tgl = str_replace('/', '-', $shipdate);
    $p_tanggal = date('Y-m-d', strtotime($tgl)); //tanggal jurnal

    $data = $this->M_Sales_inv2->getetd($barge, $p_tanggal);
    $etd_date = '';
    if ($data) {
      $etd_date = date('d/m/Y', strtotime($data->etddate));
    }
    echo "<input type='text' name='tgl_etd' value='$etd_date' id='tgl_etd' class='form-control' data-date-format='dd/mm/yyyy' readonly>";
  }

  function getbarge()
  {
    $barge = $_GET['destbarge'];
    $shipdate = $_GET['shipdate'];

    $tgl = str_replace('/', '-', $shipdate);
    $p_tanggal = date('Y-m-d', strtotime($tgl)); //tanggal jurnal

    $data = $this->M_Sales_inv2->getbarge($barge, $p_tanggal);
    $barge = '';
    if ($data) {
      $barge = $data->barge;
    }
    echo "<input type='text' id='barge' name='barge' class='form-control' value='$barge' />";
  }

  function geteta2()
  {
    $barge = $_GET['destbarge'];
    $shipdate = $_GET['shipdate'];

    $tgl = str_replace('/', '-', $shipdate);
    $p_tanggal = date('Y-m-d', strtotime($tgl)); //tanggal jurnal

    $data = $this->M_Sales_inv2->geteta2($barge, $p_tanggal);
    $eta_tgl = '';
    if ($data) {
      $eta_tgl =  date('d/m/Y', strtotime($data->etadate));
    }
    echo "<input type='text' name='tgl_eta' value='$eta_tgl' id='tgl_eta' class='form-control' data-date-format='dd/mm/yyyy' readonly>";
  }

  function getetd2()
  {
    $barge = $_GET['destbarge'];
    $shipdate = $_GET['shipdate'];

    $tgl = str_replace('/', '-', $shipdate);
    $p_tanggal = date('Y-m-d', strtotime($tgl)); //tanggal jurnal

    $data = $this->M_Sales_inv2->getetd2($barge, $p_tanggal);

    $etd_date = '';
    if ($data) {
      $etd_date = date('d/m/Y', strtotime($data->etddate));
    }

    echo "<input type='text' name='tgl_etd' value='$etd_date' id='tgl_etd' class='form-control' data-date-format='dd/mm/yyyy' readonly>";
  }

  function getbarge2()
  {
    $barge = $_GET['destbarge'];
    $shipdate = $_GET['shipdate'];

    $tgl = str_replace('/', '-', $shipdate);
    $p_tanggal = date('Y-m-d', strtotime($tgl)); //tanggal jurnal

    $data = $this->M_Sales_inv2->getbarge2($barge, $p_tanggal);

    $barge = '';
    if ($data) {
      $barge = $data->barge;
    }

    echo "<input type='text' id='barge' name='barge' class='form-control' value='$barge'  />";
  }

  // ====================================      END AJAX     ============================================


  // ====================================== fungsi tambahan ============================================
  public function convert($date)
  {
    $explode = explode("/", $date);
    $time = $explode[2] . '/' . $explode[1] . '/' . $explode[0];
    return $time;
  }


  //====================================== Print Excel Freight =========================================
  public function freight_excel()
  {
    error_reporting(E_ALL);
    ini_set('display_errors', TRUE);
    ini_set('display_startup_errors', TRUE);
    date_default_timezone_set('Europe/London');


    $tgl = str_replace('/', '-', $this->input->get('tgl'));
    $tgl_awal = date('Y-m-d', strtotime($tgl));
    $tgl_akhir = date('Y-m-t', strtotime($tgl));
    $tampil_item = $this->M_Sales_inv2->get_detail_freigth2($tgl_awal, $tgl_akhir);

    // $data =  $this->m_shipping->tampil_container_loading_where($this->input->get('load'));

    if (PHP_SAPI == 'cli')
      die('This example should only be run from a Web Browser');
    // require_once dirname(__FILE__) . '/../libraries/PHPExcel.php';
    $objPHPExcel = new PHPExcel();
    $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
    $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
    $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
    $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(40);
    $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(40);
    $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(25);
    $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(25);
    $objPHPExcel->getActiveSheet()->mergeCells('F16:G16');

    $objDrawing = new PHPExcel_Worksheet_Drawing();
    $objDrawing->setName('Logo');
    $objDrawing->setDescription('Logo');
    $logo = 'assets/zhl-kop.PNG';
    $objDrawing->setPath($logo);
    $objDrawing->setCoordinates('A1');
    $objDrawing->setHeight(160);
    $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());

    $objPHPExcel->setActiveSheetIndex(0)
      ->setCellValue('C9', 'FREIGHT CHARGES PREVIEW');

    $objPHPExcel->setActiveSheetIndex(0)
      ->setCellValue('A11', 'NO')
      ->setCellValue('B11', 'INV. NO')
      ->setCellValue('C11', 'PO NO.')
      ->setCellValue('D11', 'PRODUCTS')
      ->setCellValue('E11', 'CUSTOMER')
      ->setCellValue('F11', 'DESTINATION')
      ->setCellValue('G11', 'AMOUNT');

    $total_freight = 0;
    $counter = 12;
    $no = 1;
    foreach ($tampil_item as $v) :

      $total_freight += $v->jumlah_container * $v->Harga;

      $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('A' . $counter, $no)
        ->setCellValue('B' . $counter, $v->invno)
        ->setCellValue('C' . $counter, $v->po_num)
        ->setCellValue('D' . $counter, $v->prod)
        ->setCellValue('E' . $counter, $v->custcompany)
        ->setCellValue('F' . $counter, $v->destination)
        ->setCellValue('G' . $counter, number_format($v->jumlah_container * $v->Harga, 2, '.', ','));
      $counter++;
      $no++;
    endforeach;

    $objPHPExcel->getActiveSheet()->getStyle('A11:G11')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
      ->getActiveSheet()->getStyle('A11:G11')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
      ->getActiveSheet()->getStyle('A11:A' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
      ->getActiveSheet()->getStyle('B11:B' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
      ->getActiveSheet()->getStyle('C11:C' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
      ->getActiveSheet()->getStyle('D11:D' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
      ->getActiveSheet()->getStyle('E11:E' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
      ->getActiveSheet()->getStyle('F11:F' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
      ->getActiveSheet()->getStyle('G11:G' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
      ->getActiveSheet()->getStyle('A' . $counter . ':G' . $counter)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

    $objPHPExcel->setActiveSheetIndex(0)
      ->setCellValue('F' . $counter, 'Amount Total')
      ->setCellValue('G' . $counter, number_format($total_freight, 2, '.', ','));

    $counter++;


    $objPHPExcel->getActiveSheet()->setTitle('Freight Charges Preview');
    $objPHPExcel->setActiveSheetIndex(0);
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="Freight Charges Preview ' . date("dmy") . '.xlsx"');
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
  // ===================================== END =========================================================
}
