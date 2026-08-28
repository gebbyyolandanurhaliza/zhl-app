<script src="<?php echo base_url(); ?>assets/global/plugins/bootbox/bootbox.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/autoNumeric-min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/global/plugins/jquery.pulsate.min.js" type="text/javascript"></script>

<?php
if (!empty($get_data_header)) {
  foreach ($get_data_header as $s) {
    $nofaktur        = $s->nofaktur;
    $kode_sup        = $s->customer_id;
    $supname         = $s->namacustomer;
    $supplier_id     = $s->kode_sup . "|" . $s->coa;
    $jenis_in        = $s->jenis_inv;
    $NoCOA           = $s->coa;
    $prepared_by     = $s->prepared_by;
    $currency_id     = $s->currency;
    $Currency_symbol = $s->currency;
    $rate_sgd        = $s->rate_sgd;
    $remarks        = $s->remarks;
    $paymentto        = $s->paymentto;
    $rate            = $s->rate;
    $sdate           = new DateTime($s->tanggal);
    $date_of_journal = date_format($sdate, 'd/m/Y');
    $idate           = new DateTime($s->tanggal_invoice);
    $date_invoice    = date_format($idate, 'd/m/Y');
    $xdate           = new DateTime($s->tanggal_tempo);
    $tgl_tempo       = date_format($xdate, 'd/m/Y');
    $term            = $s->term;
    $nota_debet      = $s->nota_debet;
    $readonly        = 'readonly';
    $disable         = '';
    $submit_value    = 'Update';
    $voyage          = $s->voyage;
    $destbarge       = $s->destbarge;
    $date_shipment   = date_format((new DateTime($s->shipmentdate)), 'd/m/Y');
    $etadate         = date_format((new DateTime($s->etadate)), 'd/m/Y');
    $etddate         = date_format((new DateTime($s->etddate)), 'd/m/Y');

    $voyage_array     = explode("/", $voyage);
    $voyage_amount = count($voyage_array);

    if ($voyage_amount == 6) {
      $vessel_name = trim($voyage_array[0]) . ' / ' . trim($voyage_array[2]) . ' / ' . trim($voyage_array[4]);
    } else if ($voyage_amount == 4) {
      $vessel_name = trim($voyage_array[0]) . ' / ' . trim($voyage_array[2]);
    } else {
      $vessel_name = trim($voyage_array[0]);
    }

    // $buyer = $s->buyer;
    // $ports = $s->port_name;
    // if ($s->status_dp == 1) {
    //     $status_dp = "checked";
    // } else {
    //     $status_dp = "";
    // }
    $outwardinward   = '';
  }
} else {
  $jenis_in        = '';
  $nofaktur        = '';
  $kode_sup        = 'PSS';
  $currency_id     = 'USD';
  $supplier_id     = '';
  $prepared_by     = '';
  $NoCOA           = '';
  $Currency_symbol = '';
  $rate            = '0';
  $status_dp       = "";
  $date_of_journal = date('d/m/Y');
  $date_invoice    = date('d/m/Y');
  $tgl_tempo       = date('d/m/Y');
  $term            = '30';
  $rate_sgd        = '0';
  $nota_debet      = '0';
  $readonly        = '';
  $disable         = 'disable';
  $submit_value    = 'Save';
  $voyage          = '';
  $destbarge       = '';
  $data_shipment   = date('d/m/Y');
  $etadate         = "";
  $etddate         = "";
  // $buyer        = '';
  // $ports        = '';
  $vessel_name     = '';
  $outwardinward   = '';
  $remarks        = "";
  $paymentto        = "";
}
?>

<div class="page-content">
  <div class="container">
    <!-- BEGIN PAGE CONTENT INNER -->
    <div class="row">
      <form action="<?php echo base_url(); ?>Sales_inv2/save_sales_inv" onsubmit="return validate(this);" method="post">
        <div class="col-md-12">
          <input type="hidden" id="closing_date" name="closing_date" value="<?php echo $this->session->userdata('closing_date'); ?>" />
          <div id="error_id"> <?php echo $message; ?></div>
          <div class="portlet light">
            <div class="portlet-title">
              <div id="rate2" style="color: #5a7391"></div>
              <div class="caption">

                <i class="fa fa-credit-card theme-font"></i>
                <span class="caption-subject theme-font">Sales Invoice Journal</span>
              </div>
              <div class="form-group">
                <?php if ($this->input->get('id') <> '') { ?>
                  <a class="btn btn-primary kanan" href="<?php echo base_url(); ?>Sales_inv2/add_new"><i class="fa fa-plus"></i> Create New</a>
                <?php
                } else {
                  // echo "<label class='btn kanan' style='color:red'>Closing Date: " . $this->session->userdata('closing_date') . "</label>";
                }
                ?>
              </div>
            </div>
            <div class="portlet-body">
              <div class="form-body">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label col-md-3">Ref. Number</label>
                      <div class="col-md-9">
                        <input type="text" id="refno" name="nofaktur" value="<?php echo $nofaktur; ?>" class="form-control" onchange="cek_nofak()" readonly />
                        <label class="CurID"></label>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="control-label col-md-3">Invoice Type </label>
                      <div class="col-md-9">
                        <select name="invtype" id="invtype" class="form-control select2me" onchange="gettanggal()" required>
                          <option>Choose</option>
                          <option value="bar" <?php if ($jenis_in === 'bar') {
                                                echo 'SELECTED';
                                              } ?>>Barge Charges</option>
                          <option value="fre" <?php if ($jenis_in === 'fre') {
                                                echo 'SELECTED';
                                              } ?>>Freight Charges</option>
                          <option value="trn" <?php if ($jenis_in === 'trn') {
                                                echo 'SELECTED';
                                              } ?>>Transport Charges</option>
                          <option value="lem" <?php if ($jenis_in === 'lem') {
                                                echo 'SELECTED';
                                              } ?>>Local Empty</option>
                          <option value="eim" <?php if ($jenis_in === 'eim') {
                                                echo 'SELECTED';
                                              } ?>>Empty Import</option>
                          <!-- <option value="tet" <?php if ($jenis_in === 'tet') {
                                                echo 'SELECTED';
                                              } ?>>Tetrapak Shipment</option> -->
                          <option value="bargefreight" <?php if ($jenis_in === 'bargefreight') {
                                                          echo 'SELECTED';
                                                        } ?>>Barge Freight</option>
                          <option value="invexcel" <?php if ($jenis_in === 'invexcel') {
                                                      echo 'SELECTED';
                                                    } ?>>Invoice Excel</option>
                          <option value="chinaShipment" <?php if ($jenis_in === 'chinaShipment') {
                                                echo 'SELECTED';
                                              } ?>>China Shipment</option>
                        </select>
                      </div>
                    </div>

                    <?php
                    if ($jenis_in === 'bar' || $jenis_in === 'lem' || $jenis_in === 'eim' || $jenis_in === 'tet' || $jenis_in === 'chinaShipment') {
                      $style1 = 'style="display: none"';
                      $style2 = '';
                      $style3 = 'style="display: none"';
                      $style4 = '';
                      $button_dtl_con = '';
                    } else if ($jenis_in === 'bargefreight' || $jenis_in === 'invexcel') {
                      $style1 = 'style="display: none"';
                      $style2 = 'style="display: none"';
                      $style3 = '';
                      $style4 = '';
                      $button_dtl_con = 'style="display: none"';
                    } else {
                      $style1 = '';
                      $style2 = 'style="display: none"';
                      $style3 = 'style="display: none"';
                      $style4 = 'style="display: none"';
                      $button_dtl_con = '';
                    }
                    ?>

                    <!-- montly shipping -->
                    <div class="form-group" id="monthship" <?= $style1; ?>>
                      <label class="control-label col-md-3">Monthly Shipping</label>
                      <div class="col-md-4">
                        <select name="monthlyship" id="monthlyship" class="form-control select2me" onchange="get_detail_freigth();get_detail_freigthcont()" required>

                          <option value="01">Januari</option>
                          <option value="02">Februari</option>
                          <option value="03">Maret</option>
                          <option value="04">April</option>
                          <option value="05">Mei</option>
                          <option value="06">Juni</option>
                          <option value="07">Juli</option>
                          <option value="08">Agustus</option>
                          <option value="09">September</option>
                          <option value="10">Oktober</option>
                          <option value="11">November</option>
                          <option value="12">Desember</option>
                        </select>
                      </div>
                      <div class="col-md-5">
                        <select name="yearship" id="yearship" class="form-control select2me" onchange="get_detail_freigth()" required>
                          <?php
                          $year = date('Y');
                          $y2 = intval($year);
                          $y = intval($year) - 2;
                          for ($i = 0; $i < 5; $i++) {
                            if ($y2 == $y) {
                              echo "<option selected>$y</option>";
                            } else {
                              echo "<option>$y</option>";
                            }
                            $y++;
                          }
                          ?>
                        </select>
                      </div>
                      <!-- <div class="col-md-5">a</div> -->
                    </div>
                    <!-- !! montly shipping -->

                    <!-- form to -->
                    <div class="form-group" id="bargedest" <?= $style2; ?>>
                      <label class="control-label col-md-3">Form - To</label>
                      <div class="col-md-9">
                        <div id="toast-container" class="toast-top-right" aria-live="polite" role="alert" style="display : none; font-size: 20">
                          <div class="toast toast-error" style="display: block;">
                            <div class="toast-message">Are you the six fingered man?</div>
                          </div>
                        </div>
                        <select name="dest_barge" id="dest_barge" class="form-control" onchange="gettanggal()">
                          <option></option>
                          <option value="idn" <?php if ($destbarge === 'idn') {
                                                echo 'SELECTED';
                                              } ?>>Indonesia ( PSG ) - Singapore ---(INWARD)</option>
                          <option value="idn2" <?php if ($destbarge === 'idn2') {
                                                  echo 'SELECTED';
                                                } ?>>Indonesia ( RSUP ) - Singapore ---(INWARD)</option>
                          <option value="sin" <?php if ($destbarge === 'sin') {
                                                echo 'SELECTED';
                                              } ?>>Singapore - Indonesia ( PSG )--- (OUTWARD)</option>
                          <option value="sin2" <?php if ($destbarge === 'sin2') {
                                                  echo 'SELECTED';
                                                } ?>>Singapore - Indonesia ( RSUP )--- (OUTWARD)</option>
                        </select>
                      </div>
                    </div>
                    <!-- !! form to -->

                    <!-- inward/outward -->
                    <div class="form-group" id="outwardinwardfield" <?= $style3; ?>>
                      <label class="control-label col-md-3">Outward / Inward</label>
                      <div class="col-md-9">
                        <select id="outward_inward" name="outward_inward" class="form-control" onchange="gettanggal()">
                          <option></option>
                          <option value="1" <?php if ($outwardinward === '1') {
                                              echo 'SELECTED';
                                            } ?>>Outward</option>
                          <option value="2" <?php if ($outwardinward === '2') {
                                              echo 'SELECTED';
                                            } ?>>Inward</option>

                        </select>
                      </div>
                    </div>

                    <!-- Shipment date -->
                    <div class="form-group" id="divshipment" <?= $style4 ?>>
                      <label class="control-label col-md-3">Shipment Date</label>
                      <div class="col-md-9">
                        <?php if ($nofaktur === '') { ?>
                          <div id="tlga">
                            <select class="form-control">
                              <option></option>
                            </select>
                          </div>
                        <?php } else { ?>
                          <input type="text" name="tgl_shipment" id="tanggal_shipment" class="form-control date date-picker" value="<?php echo $date_shipment; ?>" data-date-format="dd/mm/yyyy" <?php echo $readonly; ?> />
                        <?php } ?>
                      </div>
                    </div>
                    <!-- !! Shipment date -->


                    <!-- Vessel -->
                    <div class="form-group" id="vesselfield" <?= $style3; ?>>
                      <label class="control-label col-md-3">Vessel</label>
                      <div class="col-md-9">
                        <select id="vesel_name" class="form-control select2me" onchange='getvoyage();' required>
                          <option>Choose</option>
                          <?php
                          foreach ($vessel as $v) { ?>
                            <option value="<?= $v->vessel_name ?>" <?= $vessel_name == $v->vessel_name ? 'selected' : '' ?>><?= $v->vessel_name; ?></option>
                          <?php
                          }
                          ?>
                        </select>
                      </div>
                    </div>
                    <!-- !! Vessel -->

                    <!-- Voyage -->
                    <div class="form-group" id="voyagefield" <?= $style3; ?>>
                      <label class="control-label col-md-3">Voyage No</label>
                      <div class="col-md-9">
                        <?php if ($nofaktur == '') { ?>
                          <div id="voyagediv">
                            <input type="text" class="form-control" value="" readonly />
                          </div>
                        <?php } else { ?>
                          <?php
                          if ($voyage != '') {
                            $barge_ex = explode('/', $voyage);
                            $barg = $barge_ex[1];
                          } else {
                            $barg = $voyage;
                          }

                          ?>
                          <input type="text" class="form-control" id="voyage_no" name="voyage_no" value="<?= $barg ?>" readonly />
                        <?php
                        }
                        ?>
                      </div>
                    </div>
                    <!-- !! Voyage -->

                    <!-- customer -->
                    <div class="form-group">
                      <label class="control-label col-md-3">Customer</label>
                      <div class="col-md-9">
                        <!-- supplier -->
                        <?php
                        $style_kategori = "class='select2me form-control' id='supplier' onchange='getsup()' required";
                        echo form_dropdown('supplier', $customer, $kode_sup, $style_kategori);
                        ?>
                      </div>
                    </div>
                    <!-- !! customer -->
                  </div>

                  <div class="col-md-6">
                    <div id="daftar_kurs"></div>

                    <div class="form-group">
                      <label class="control-label col-md-3">Invoice Date</label>
                      <div class="col-md-3">
                        <input type="text" name="tgl_invoice" id="tanggal_invoice" class="form-control date date-picker" onchange="get_cur_purchase();Rate_notfound();hitungSelisihHari2()" value="<?php echo $date_invoice; ?>" data-date-format="dd/mm/yyyy" required />
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-md-3">Currency</label>
                      <div class="col-md-3">
                        <div id="cur_id">
                          <?php
                          $style_currency = "class='form-control' required id='currency' onchange='get_cur_purchase();Rate_notfound();'";
                          echo form_dropdown('Currency', $Currency, $currency_id, $style_currency);
                          echo "<input type='hidden' name='xxx' id='cursyp'  class='form-control' value='$currency_id'/>";
                          ?>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-md-3">Term</label>
                      <div class="col-md-3">
                        <input type="text" id="term" name="term" value="<?php echo $term; ?>" class="form-control autonumber" onfocus="this.value = '';" onkeyup="hitungSelisihHari2()" onkeypress="return isNumber(event)" required />
                        <input type="hidden" id="symbol_currency" name="symbol_currency" value="<?php echo $Currency_symbol; ?>" class="form-control" />
                        <input type="hidden" id="currency_val" name="currency_val" value="<?php echo $rate; ?>" class="form-control currency_val" />

                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-md-3">Date of Journal</label>
                      <div class="col-md-3">
                        <input type="text" id="tgl_tempo" name="tgl_jurnal" class="form-control date date-picker" value="<?php echo $date_of_journal; ?>" data-date-format="dd/mm/yyyy" readonly />
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-md-3">Prepared By</label>
                      <div class="col-md-3">
                        <select name="prepared_by" id="prepared_by" class="form-control select2me" required>
                          <option value="" required>Please select</option>
                          <option value="nick" <?php if ($prepared_by === 'nick') {
                                                echo 'SELECTED';
                                              } ?>>Nick</option>
                          <option value="ranny" <?php if ($prepared_by === 'ranny') {
                                                echo 'SELECTED';
                                              } ?>>Ranny</option>
                           <option value="zanth" <?php if ($prepared_by === 'zanth') {
                                                echo 'SELECTED';
                                              } ?>>Zanth</option>
                        </select>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-md-3">Due Date</label>
                      <div class="col-md-3">
                        <input type="text" id="tgl_invoice" name="tgl_tempo" class="form-control" value="<?php echo $tgl_tempo; ?>" required />
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-md-3">Barge / Voy No.</label>
                      <div class="col-md-3">
                        <div id="divbar">
                          <!-- <input type="text" id="barge" name="barge" class="form-control" value="" /> -->
                          <textarea name="barge" id="barge" cols="30" class="form-control" rows="5" readonly><?php echo $voyage; ?></textarea>
                        </div>
                      </div>
                    </div>

                    <div class="form-group" <?= $style2; ?> id='divetd'>
                      <label class="control-label col-md-3">ETD Date</label>
                      <div class="col-md-3">
                        <div id='etdchange'>
                          <input type="text" name="tgl_etd" value="<?= $etadate; ?>" id="tgl_etd" class="form-control" data-date-format="dd/mm/yyyy" readonly>
                        </div>
                      </div>
                    </div>

                    <div class="form-group" <?= $style2; ?> id='diveta'>
                      <label class="control-label col-md-3">ETA Date</label>
                      <div class="col-md-3">
                        <div id="etachange">
                          <input type="text" name="tgl_eta" value="<?= $etddate; ?>" id="tgl_eta" class="form-control" data-date-format="dd/mm/yyyy" readonly>
                        </div>
                      </div>
                    </div>

                  </div>
                </div>
                <hr />

                <a class="btn btn-primary" data-toggle="modal" href="#deposit" id="tombol_dp" style="display: none" onclick="ambil_tabel()"><i class="fa fa-money"></i> Select Deposit</a>

                <div class="col-md-2 kanan">
                  <input type="hidden" id="nota_debet" name="nota_debet" value="<?php echo $nota_debet; ?>" class="form-control" onkeypress="return isNumber(event)" required />
                </div>
                <!-- <div id="demo" style="display: none"></div> -->
                <!-- <hr/> -->

              </div>
              <div class="portlet light" id="garis_dp" style="display: none">

                <div class="portlet-title">

                  <div class="caption">
                    <span class="caption-subject theme-font">List Of deposit</span>
                  </div>
                  <div class="tools">
                    <a href="javascript:;" onclick="hapus_semua_dp()"><i class="fa fa-close"></i> Cancel Deposit</a>
                  </div>
                </div>
                <div class="note note-danger note-bordered" style="display: none" id="info_deposit">
                  <p><b>Warning!</b></p>
                  <p>
                    The table below are deposits that have been previously. Table deposit only temporary table, when the transaction has been completed to automatically deposit table will disappear by itself. Thus the deposit data will not be updated back.
                  </p>
                </div>
                <table class="table table-bordered" id="destinationtable">
                  <tr>
                    <th width="5%"></th>
                    <th width="5%" style="text-align:center">ID Deposit</th>
                    <th width="30%" style="text-align:center">Vendor Name</th>
                    <th width="30%" style="text-align:center">PO Number</th>
                    <th width="15%" style="text-align:center">Total</th>
                    <th width="15%" style="text-align:center">Amount</th>
                  </tr>
                </table>
              </div>

              <!-- Div detail container -->
              <div class="modal fade" id="trndtlcnt" tabindex="-1" role="basic" aria-hidden="true">
                <div class="modal-dialog modal-full">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                      <h4 class="modal-title">Detail Container</h4>
                      <!-- <input class="form-control" type="text" id="search" placeholder="search"> -->
                    </div>
                    <div class="modal-body">
                      <section class="">
                        <div class="contain">
                          <div id='dtl_cont'>
                            <table class="table table-bordered" id="tabel">
                              <tr>
                                <th>#</th>
                                <th>Container Type</th>
                                <th>Container Number</th>
                                <th>Seal Number</th>
                                <th>Type Stuffing</th>
                              </tr>
                              <?php
                              if (!empty($dtlctr)) {
                                $i = 1;
                                foreach ($dtlctr as $r) {
                                  echo "<tr>";
                                  echo "<td>$i</td>";
                                  echo "<td>
                                  <input type='text' name='container_name[]' class='txt' value='$r->container_name' readonly>
                                  <input type='hidden' name='container_id[]' class='txt' value='$r->container_type'>
                                  <input type='hidden' name='contid[]' class='txt' value='$r->contid'>
                                  </td>";
                                  echo "<td><input type='text' name='container_number[]' class='txt' value='$r->container_number' readonly></td>";
                                  echo "<td><input type='text' name='seal_number[]' class='txt' value='$r->seal_number' readonly></td>";
                                  echo "</tr>";
                                  $i++;
                                }
                              }
                              if (!empty($dtlctr2)) {
                                foreach ($dtlctr2 as $r) {
                                  echo "<tr>";
                                  echo "<td>$i</td>";
                                  echo "<td>
                                  <input type='text' name='container_name2[]' class='txt' value='$r->container_name' readonly>
                                  <input type='hidden' name='container_id2[]' class='txt' value='$r->container_type'>
                                  <input type='hidden' name='contid2[]' class='txt' value='$r->contid'>
                                  </td>";
                                  echo "<td><input type='text' name='container_number2[]' class='txt' value='$r->container_number' readonly></td>";
                                  echo "<td><input type='text' name='seal_number2[]' class='txt' value='$r->seal_number' readonly></td>";
                                  echo "</tr>";
                                  $i++;
                                }
                              }
                              ?>
                            </table>
                          </div>
                        </div>
                      </section>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn red" data-dismiss="modal">Close</button>
                      <a id="cetak" href="<?php echo base_url(); ?>Sales_inv2/print_cont?id=<?= $nofaktur; ?>" class="btn btn-success" target="_blank"><i class="fa fa-print"></i> Print</a>
                    </div>
                  </div>
                  <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
              </div>
              <!-- End Div -->

              <!-- Div detail container Trucking -->
              <div class="modal fade" id="trndtlcnttrcuking" tabindex="-1" role="basic" aria-hidden="true">
                <div class="modal-dialog modal-full">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                      <h4 class="modal-title">Detail Container Trucking</h4>
                      <!-- <input class="form-control" type="text" id="search" placeholder="search"> -->
                    </div>
                    <div class="modal-body">
                      <section class="">
                        <div class="contain">
                          <div id='dtl_cont_truck'>
                            <table class="table table-bordered" id="tabel">
                              <tr>
                                <th>#</th>
                                <th>Container Type</th>
                                <th>Container Number</th>
                                <th>Seal Number</th>
                                <th>Type Stuffing</th>
                              </tr>
                              <?php
                              if (!empty($dtlctrtruck)) {
                                $i = 1;
                                foreach ($dtlctrtruck as $r) {
                                  echo "<tr>";
                                  echo "<td>$i</td>";
                                  echo "<td>
                                  <input type='text' name='container_name_truck[]' class='txt' value='$r->container_name' readonly>
                                  <input type='hidden' name='container_id_truck[]' class='txt' value='$r->container_type'>
                                  <input type='hidden' name='contid_truck[]' class='txt' value='$r->contid'>
                                  </td>";
                                  echo "<td><input type='text' name='container_number_truck[]' class='txt' value='$r->container_number' readonly></td>";
                                  echo "<td><input type='text' name='seal_number_truck[]' class='txt' value='$r->seal_number' readonly></td>";
                                  echo "</tr>";
                                  $i++;
                                }
                              }
                              if (!empty($dtlctr2truck)) {
                                foreach ($dtlctr2truck as $r) {
                                  echo "<tr>";
                                  echo "<td>$i</td>";
                                  echo "<td>
                                  <input type='text' name='container_name2_truck[]' class='txt' value='$r->container_name' readonly>
                                  <input type='hidden' name='container_id2_truck[]' class='txt' value='$r->container_type'>
                                  <input type='hidden' name='contid2_truck[]' class='txt' value='$r->contid'>
                                  </td>";
                                  echo "<td><input type='text' name='container_number2_truck[]' class='txt' value='$r->container_number' readonly></td>";
                                  echo "<td><input type='text' name='seal_number2_truck[]' class='txt' value='$r->seal_number' readonly></td>";
                                  echo "</tr>";
                                  $i++;
                                }
                              }
                              ?>
                            </table>
                          </div>
                        </div>
                      </section>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn red" data-dismiss="modal">Close</button>
                      <a id="cetak" href="<?php echo base_url(); ?>Sales_inv2/print_cont?id=<?= $nofaktur; ?>" class="btn btn-success" target="_blank"><i class="fa fa-print"></i> Print</a>
                    </div>
                  </div>
                  <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
              </div>
              <!-- End Div -->

              <!--<button class="btn btn-default" id="btndtlcnt" type="button">
                                  <i class="fa fa-sm fa-eye fa-fw" aria-hidden="true"></i> Look Detail Container</button>-->
              <div class="div" <?= $button_dtl_con ?>>
                <div style="margin-bottom: 20px;">
                  <a class="btn btn-primary" data-toggle="modal" href="#trndtlcnt" id="btnctldtl"><i class="fa fa-eye"></i> Look Detail Container</a>
                  <a class="btn btn-success" data-toggle="modal" href="#trndtlcnttrcuking" id="btnctldtltruck"><i class="fa fa-eye"></i> Look Detail Container Trucking</a>
                  <button type="button" class="btn btn-danger" onclick="printfre()" id="prf" style="display: none"><i class="fa fa-print"></i> Print freight Detail</button>
                  <button type="button" class="btn btn-primary yellow" onclick="printfreexcel()" id="exc" style="display: none"><i class="fa fa-excel"></i> Export Excel freight Detail</button>
                </div>
              </div>


              <div id="detail_inv">

                <table class="table table-bordered" id="tabel">

                  <thead>
                    <?php if ($jenis_in === 'bar') {
                      $hide = '';
                    } else {
                      $hide = 'hidden';
                    } ?>
                    <tr>
                      <th style="min-width: 10px; width: 10px;">&#10004;</th>
                      <th>Account Number</th>
                      <th>Department Code</th>
                      <th>Acoount Name</th>
                      <th>Items</th>
                      <th>Description</th>
                      <th <?= $hide; ?>>Type Barge</th>
                      <th>Unit</th>
                      <th>Price</th>
                      <th>Amount</th>
                      <th>USD Equivalent</th>
                      <th>Gst Type</th>
                      <th>Gst Value</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php

                    //gebby
                    usort($get_data_detail, function($a, $b) {
                        return $a->DetailID - $b->DetailID;
                    });
                    if (!empty($get_data_detail)) {
                      $i = 0;
                      foreach ($get_data_detail as $r) {
                    ?>
                        <tr>
                          <td>
                            <input type="checkbox" class="row-check">
                          </td>
                          <td>
                            <input type="hidden" name="detailidcont[]" value="<?= $r->detailCont ?>">
                            <!-- id container sama dengan Item ID yah -->
                            <input type="hidden" name="idcontainer[]" value="<?= $r->ItemID ?>">
                            <input type="text" name="accNum[]" class="txt accNum" id="accNum-<?= $i; ?>" value="<?= $r->NoCOA; ?>">
                          </td>
                          <td>
                            <input type="text" name="dept_code[]" class="txt dept_code" id="dept_code-<?= $i; ?>" value="<?= $r->dept_code; ?>">
                          </td>
                          <?php
                          if ($jenis_in == 'bargefreight') { ?>
                            <td>
                              <input type="text" name="accName[]" class="txt accName" id="accName-<?= $i; ?>" value="<?= $r->AccountName; ?>">
                            </td>
                          <?php
                          } else { ?>
                            <td>
                              <?php $sales = "Barge Income";
                              if ($r->NoCOA == '500103') {
                                $sales = "Trucking Income";
                              } ?>
                              <input type="text" name="accName[]" class="txt accName" id="accName-<?= $i; ?>" value="<?= $sales; ?>">
                            </td>
                          <?php
                          }
                          ?>
                          <td>
                            <textarea name="det_items[]" id="det_items-<?= $i; ?>" cols="17" rows="3"><?php echo $r->ItemName; ?></textarea>
                          </td>
                          <td>
                            <textarea name="descr[]" id="descr-<?= $i; ?>" cols="25" rows="3"><?php echo $r->description; ?></textarea>
                          </td>
                          <td <?= $hide; ?>>
                            <?php
                            $stuff = '';
                            if ($r->type_barge == 'EE') {
                              $stuff = 'Export Empty';
                            } else if ($r->type_barge == 'EL') {
                              $stuff = 'Export Laden';
                            } else if ($r->type_barge == 'IT') {
                              $stuff = 'Import Transhipment';
                            } else if ($r->type_barge == 'IL') {
                              $stuff = 'Import Laden';
                            } else if ($r->type_barge == 'LL') {
                              $stuff = 'Local Laden';
                            } else if ($r->type_barge == 'LLTP') {
                              $stuff = 'Local Laden (TP)';
                            } else if ($r->type_barge == 'LE') {
                              $stuff = 'Local Empty';
                            } else if ($r->type_barge == 'EI') {
                              $stuff = 'Empty Import';
                            } else if ($r->type_barge == 'trucking20ft') {
                              $stuff = 'Trucking 20ft';
                            } else if ($r->type_barge == 'trucking40ft') {
                              $stuff = 'Trucking 40ft';
                            } else if ($r->type_barge == 'trucking20ftreefer') {
                              $stuff = 'Trucking 20ft reefer';
                            }else if ($r->type_barge == 'trucking40ftreefer') {
                              $stuff = 'Trucking 40ft reefer';
                            }
                            echo $stuff;
                            ?>
                            <input type="hidden" name="jenisbarge[]" value='<?= $r->type_barge; ?>' id="jenisbarge-<?= $i; ?>" class='jenisbarge'>
                          </td>
                          <td>
                            <input type="text" name="unit[]" class="txt unit number" id="unit-<?= $i; ?>" value="<?= $r->unit; ?>" onkeyup='hitung_total(<?= $i; ?>)'>
                          </td>

                          <td>
                            <input type="text" name="txtHarga[]" class="txt number txtHarga" id="txtHarga-<?= $i; ?>" onchange="hitung_total(<?= $i; ?>)" value="<?= number_format($r->price, 0); ?>">
                          </td>
                          <td>
                            <input type="text" name="txtTotal[]" class="txt number txtTotal" id="txtTotal-<?= $i; ?>" value='<?php echo $r->unit * $r->price; ?>' readonly>
                          </td>
                          <td>
                            <input type="text" name="txtUSD[]" class="txt number txtUSD" id="txtUSD-<?= $i; ?>" value='<?= number_format($r->usdequivalent, 2); ?>' readonly>
                          </td>
                          <td>
                            <select name="txtGST[]" onchange="cek_gst(<?= $i; ?>)" id="txtGST-<?= $i; ?>" class="txt txtGST">
                              <option value="">Select</option>
                              <option value="GST" <?php if ($r->gst_type === 'GST') {
                                                    echo "SELECTED";
                                                  } ?>>GST</option>
                              <option value="ZER" <?php if ($r->gst_type === 'ZER') {
                                                    echo "SELECTED";
                                                  } ?>>Zero Rate</option>
                              <option value="EXP" <?php if ($r->gst_type === 'EXP') {
                                                    echo "SELECTED";
                                                  } ?>>Exampt</option>
                              <option value="OUT" <?php if ($r->gst_type === 'OUT') {
                                                    echo "SELECTED";
                                                  } ?>>Out of Scope</option>
                            </select>
                          </td>
                          <td>
                            <input type="text" class="txt number txtGSTValue" name="txtGSTValue[]" id="txtGSTValue-<?= $i; ?>" value="<?= number_format($r->gst_value, 2); ?>" />
                          </td>
                        </tr>
                      <?php
                        $i++;
                      } ?>
                      <?php if ($hide == 'hidden') {
                        $rw = 8;
                      } else {
                        $rw = 9;
                      } ?>

                      <!-- gebby -->
                     <tr id="row-action">
                        <td colspan="100%">
                          <button type="button" class="btn btn-primary" onclick="tambahRow()">+ Add Row</button>
                          <button type="button" class="btn btn-danger" onclick="deleteRow()">Delete Row</button>
                        </td>
                      </tr>
                      <tr id="row-total">
                        <td colspan="<?= $rw; ?>" align="right">TOTAL</td>
                        <td><input type="text" name="totalinv" id="totalinv" class="txt Number" value="0" readonly></td>
                        <td><input type="text" name="totalinvusd" id="totalinvusd" class="txt Number" value="0" readonly></td>
                        <td></td>
                        <td><input type="text" name="totalgst" id="totalgst" class="txt Number" value="0" readonly></td>
                      </tr>
                      <tr id="row-grandtotal">
                        <td colspan="<?= $rw; ?>" align="right">GRAND TOTAL</td>
                        <td colspan="4"><input type="text" name="stotalinv" id="stotalinv" class="txt Number" value="0" readonly></td>
                      </tr>
                    <?php
                    } else {
                    ?>
                      <tr id="row-total">
                        <td colspan="7" align="right">TOTAL</td>
                        <td><input type="text" name="totalinv" id="totalinv" class="txt Number" value="" required></td>
                        <td><input type="text" name="totalinvusd" id="totalinvusd" class="txt Number" value="" required></td>
                        <td></td>
                        <td><input type="text" name="totalgst" id="totalgst" class="txt Number" value="" required></td>
                      </tr>
                      <tr id="row-grandtotal">
                        <td colspan="7" align="right">GRAND TOTAL</td>
                        <td colspan="4"><input type="text" name="stotalinv" id="stotalinv" class="txt Number" value="0" readonly></td>
                      </tr>
                    <?php
                    }
                    ?>
                  </tbody>
                </table>
              </div>

              <div class="row">
                <div style="padding-bottom: 50px;" class="col-md-4">
                  <label>Remarks</label>
                  <textarea class="form-control" rows="3" name="remarks"><?= $remarks ?></textarea>
                </div>
                <div class="col-md-8">
                  <div class="form-group" style="margin-bottom:1px;">
                    <label class="col-md-6 label-sm" onclick="fnDialogMasterBank()" style="color: #0081c2;">Master Bank</label>
                  </div>
                  <div class="form-group" style="margin-bottom:1px;">
                    <div class="col-md-12">
                      <div id="pindahwaktu">
                        <textarea rows="3" class="form-control" name="paymentto" id="paymentto"><?= $paymentto ?></textarea>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- <button class="btn btn-default" id="btnFindRecord" type="button">Find <i class="fa fa-sm fa-search fa-fw" aria-hidden="true"></i> </button> -->

            <button type="submit" name="sbt" id="btn_update" class="btn btn-primary" value="<?php echo $submit_value; ?>"><i class="fa fa-save"></i> <?php echo $submit_value; ?></button>
            <a class="btn btn-warning" href="<?php echo base_url(); ?>Sales_inv2"><i class="fa fa-warning"></i> Cancel</a>
            <a id="cetaks" href="<?php echo base_url(); ?>Sales_inv2/printerin?id=<?= $nofaktur; ?>&inv=<?= $jenis_in; ?>&signature=Mr. Tahir Aziz" class="btn btn-success" target="_blank"><i class="fa fa-print"></i> Print</a>
            <?php if ($this->input->get('id') <> '') { ?>
              <!--<a class="btn btn-primary  kanan" href="<?php echo base_url(); ?>Sales_inv2/print_report?id=<?php //echo htmlspecialchars($this->input->get('id'), ENT_QUOTES);
                                                                                                              ?>" target="_blank"><i class="fa fa-print"></i> Print</a>-->
              <a class="btn btn-danger kanan" href="<?php echo base_url(); ?>Sales_inv2/delete_transaction?id=<?php echo htmlspecialchars($this->input->get('id'), ENT_QUOTES); ?>" onclick="return confirm('Are you sure to delete this transaction?')"><i class="fa fa-trash"></i> Delete</a>
              <div class="col-md-2 kanan">
                <select name="signiture" onchange="ganti_signature()" id="signature" class="form-control kanan">
                  <option value="Mr. Tahir Bin Abdul Aziz">Mr. Tahir Bin Abdul Aziz</option>
                  <option value="Ms. Cindy Lew">Ms. Cindy Lew </option>
                  <option value="Ms. Norjanah">Ms. Norjanah </option>
                  <option value="Mr. Nick Chung">Mr. Nick Chung </option>
                </select>
              </div>
              <script type="text/javascript">
                function ganti_signature() {
                  var cetak = document.getElementById('cetaks');
                  var locAppend = $('#signature').find('option:selected').val(),
                    locSnip = window.location.href.split('edit')[0];
                  $a = locSnip + "printerin?id=<?= $nofaktur; ?>&signature=" + locAppend;
                  cetak.href = locSnip + "printerin?id=<?= $nofaktur; ?>&inv=<?= $jenis_in; ?>&signature=" + locAppend;
                }
              </script>

            <?php } ?>
          </div>
        </div>

      </form>
    </div>
  </div>
  <div class="modal fade" id="deposit" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
          <h4 class="modal-title">List of Deposit Customer</h4>
        </div>
        <div class="err"></div>
      </div>
    </div>
  </div>

</div>

<div class="modal fade" id="po_v" tabindex="-1" role="basic" aria-hidden="true">
  <div class="modal-dialog modal-full">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title">List of PO Factory</h4>
        <input class="form-control" type="text" id="search" placeholder="search">
      </div>
      <div class="modal-body">
        <section class="">
          <div class="contain">
            <div id="detail_po_id"></div>
          </div>
        </section>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn red" data-dismiss="modal">Close</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<!-- Find Recorded Purchase Inventory Factory Modal -->
<div class="modal fade" id="modal-findAP" tabindex="-1" role="basic" aria-hidden="true">
  <div class="modal-dialog" style="width: 75%;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title">Select Invoice</h4>
      </div>
      <div class="modal-body">
        <div id="contentFindAP"><i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i> Loading...</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<div id="formdialogMasterBank"></div>
<script type="text/javascript">
  "use strict";

  $(document).ready(function() {
    get_cur_purchase();
    Rate_notfound();
    hitungSelisihHari2();
    hitung_semua();
    $("#tabel_dpi").dataTable({
      "scrollY": 400,
      "scrollX": true
    });
  });

  $("#btnFindRecord").click(function() {
    $.post("<?php echo site_url(); ?>Sales_inv2/selectInvoiceFactory", function(data) {
      $('#contentFindAP').html(data);
    });
    $('#modal-findAP').modal('show');
  });

  function validate(form) {
    return confirm('Do you really want to submit the form?');
  }

  function hitungSelisihHari2() {
    var tgl2 = document.getElementById('term').value;
    var tgl3 = document.getElementById('tgl_invoice');
    var str = document.getElementById('tgl_tempo').value;
    //ganti tanggal
    var tanggal = str.split("/");
    var tgl = tanggal[0];
    var bln = tanggal[1];
    var thn = tanggal[2];
    var tt = bln + "/" + tgl + "/" + thn;
    var date = new Date(tt);
    var newdate = new Date(date);
    newdate.setDate(newdate.getDate() + Number(tgl2));
    var dd = newdate.getDate();
    var mm = newdate.getMonth() + 1;
    var y = newdate.getFullYear();
    var someFormattedDate = dd + '/' + mm + '/' + y;
    tgl3.value = someFormattedDate;
  }

  function get_cur_purchase() {

    var cur = document.getElementById("currency").value;
    var docdate = document.getElementById("tanggal_invoice").value;
    document.getElementById("tgl_tempo").value = docdate;
    var currency_id = document.getElementById('currency').value;
    var supp = document.getElementById('supplier').value;
    var belah = supp.split("|");
    var vendor = belah[0];

    var tgl1 = document.getElementById('tanggal_invoice').value;
    var tgl = tgl1.split("/");
    var tahun = tgl[2];
    var bulan = tgl[1];

    var a1 = 1;
    if ($('#invtype').val() === 'bar') {
      if ($('#dest_barge').val()) {
        a1 = 1;
      } else {
        // alert("please Choose the destination !");
        a1 = 0;
      }
    }

    // if ($('#invtype').val() === 'bargefreight') {
    //     hitung_total_usd_bf();
    // }

    if (a1 == 1) {
      $.ajax({
        url: "<?php echo base_url(); ?>Purchase_inv/ambil_currency?cur=" + cur + "&date=" + docdate + "",
        success: function(response) {
          $("#daftar_kurs").html(response);
          var cur = document.getElementById('rate_currency').value;
        },
        dataType: "html"
      });
    }
    // get_po();
  }

  function Rate_notfound() {
    var cur = document.getElementById("currency").value;
    var docdate = document.getElementById("tanggal_invoice").value;

    var a1 = 1;
    if ($('#invtype').val() === 'bar') {
      if ($('#dest_barge').val()) {
        a1 = 1;
      } else {
        a1 = 0;
      }
    }

    if (a1 == 1) {
      $.ajax({
        url: "<?php echo base_url(); ?>Purchase_inv/accounting_rate?cur=" + cur + "&date=" + docdate + "",
        success: function(response) {
          $("#rate2").html(response);
        },
        dataType: "html"
      });
    }

    return false;
  }

  function gettanggal() {
    "use strict";
    var base_url = "<?php echo base_url(); ?>";
    var inv = $("#invtype").val();
    var ft = $('#dest_barge').val();
    var io = $('#outward_inward').val();

    $('#detail_inv').html("");
    $('#tgl_etd').val("");
    $('#tgl_eta').val("");
    $('#barge').val("");
    $('#io').val("");


    switch (inv) {
      case 'bar':
        opt_bar();
        break;
      case 'tet':
        opt_tet();
        break;
      case 'chinaShipment':
        opt_chinaShipment();
        break;
      case 'lem':
        opt_lem();
        break;
      case 'eim':
        opt_tet();
        break;
      case 'bargefreight':
        opt_bargefreight();
        break;
      case 'invexcel':
        opt_invexcel();
        break;
      default:
        break;
    }

    function opt_bar() {

      var url = base_url + "Sales_inv2/getAjaxTanggal?jeninv=" + inv + "&bargedest=" + ft;
      $.ajax({
        url: url,
        success: function(response) {
          $("#tlga").html(response);
        },
        dataType: "html"
      });
      // get_port();
    }

    function opt_tet() {
      var url = base_url + "Sales_inv2/getAjaxTanggal?jeninv=" + inv + "&bargedest=" + ft;
      $.ajax({
        url: url,
        success: function(response) {
          $("#tlga").html(response);
        },
        dataType: "html"
      });
    }

    function opt_chinaShipment() {
      var url = base_url + "Sales_inv2/getAjaxTanggal?jeninv=" + inv + "&bargedest=" + ft;
      $.ajax({
        url: url,
        success: function(response) {
          $("#tlga").html(response);
        },
        dataType: "html"
      });
    }

    function opt_lem() {
      var url = base_url + "Sales_inv2/getAjaxTanggal?jeninv=" + inv + "&bargedest=" + ft;
      $.ajax({
        url: url,
        success: function(response) {
          $("#tlga").html(response);
        },
        dataType: "html"
      });
    }

    function opt_eim() {
      var url = base_url + "Sales_inv2/getAjaxTanggal?jeninv=" + inv + "&bargedest=" + ft;
      $.ajax({
        url: url,
        success: function(response) {
          $("#tlga").html(response);
        },
        dataType: "html"
      });
    }

    function opt_bargefreight() {
      var url = base_url + "Sales_inv2/getAjaxTanggal?jeninv=" + inv + "&bargedest=" + ft;
      $.ajax({
        url: url,
        success: function(response) {
          $("#tlga").html(response);
        },
        dataType: "html"
      });
    }

    function opt_invexcel() {
      var url = base_url + "Sales_inv2/getAjaxTanggal?jeninv=" + inv + "&bargedest=" + ft + "&outwardinward=" + io;
      $.ajax({
        url: url,
        success: function(response) {
          $("#tlga").html(response);
        },
        dataType: "html"
      });
    }
    cekbarge();
  }

  function getvoyage() {
    "use strict";
    var base_url = "<?php echo base_url(); ?>";
    var inv = $("#invtype").val();
    var ft = $('#dest_barge').val();
    var tgl_shipment = $('#tanggal_shipment').val();
    var vessel = $('#vesel_name').val();

    if (tgl_shipment == '') {
      alert("Shipment date is empty");
      return false;
    }

    var url = base_url + "Sales_inv2/getAjaxVoyage?tgl_shipment=" + tgl_shipment + "&vessel=" + vessel;
    $.ajax({
      url: url,
      success: function(response) {
        $("#voyagediv").html(response);
      },
      dataType: "html"
    });

    // cekbarge();
  }


  function gettanggal_old() {
    //hidden_vessel();
    var inv = $("#invtype").val();

    if (inv === 'bar') {
      var ft = $('#dest_barge').val();
      var ur = "<?php echo base_url(); ?>Sales_inv2/getAjaxTanggal?jeninv=" + inv + "&bargedest=" + ft;
      $.ajax({
        url: ur,
        success: function(response) {
          $("#tlga").html(response);
        },
        dataType: "html"
      });
      // get_port();
    } else if (inv === 'tet') {
      var ft = $('#dest_barge').val();
      var ur = "<?php echo base_url(); ?>Sales_inv2/getAjaxTanggal?jeninv=" + inv + "&bargedest=" + ft;
      $.ajax({
        url: ur,
        success: function(response) {
          $("#tlga").html(response);
        },
        dataType: "html"
      });

    } else if (inv === 'lem' || inv === 'eim') {
      var ft = $('#dest_barge').val();
      var ur = "<?php echo base_url(); ?>Sales_inv2/getAjaxTanggal?jeninv=" + inv + "&bargedest=" + ft;
      $.ajax({
        url: ur,
        success: function(response) {
          $("#tlga").html(response);
        },
        dataType: "html"
      });
    } else {
      ft = 0;
    }
    cekbarge();
    return false;
    //
  }


  function getDetailContainer() {
    var tgl = $("#tanggal_shipment").val();
    var invtype = $("#invtype").val();
    var sup = $("#supplier").val();
    if (!$('#dest_barge').val()) {
      var bargedest = '0';
    } else {
      var bargedest = $('#dest_barge').val();
    }

    var url3 = "<?php echo base_url(); ?>Sales_inv2/get_detail3?date=" + tgl + "&invtype=" + invtype + "&bargedest=" + bargedest + "&sup=" + sup;

    $.ajax({
      url: url3,
      success: function(response) {
        $("#dtl_cont").html(response);
      },
      dataType: "html"
    });

  }

  function getDetailContainertrucking() {
    var tgl = $("#tanggal_shipment").val();
    var invtype = $("#invtype").val();
    var sup = $("#supplier").val();
    if (!$('#dest_barge').val()) {
      var bargedest = '0';
    } else {
      var bargedest = $('#dest_barge').val();
    }

    var url3 = "<?php echo base_url(); ?>Sales_inv2/get_detail4?date=" + tgl + "&invtype=" + invtype + "&bargedest=" + bargedest + "&sup=" + sup;

    $.ajax({
      url: url3,
      success: function(response) {
        $("#dtl_cont_truck").html(response);
      },
      dataType: "html"
    });

  }

  function block() {
    $.blockUI({
      message: '<h4> Just a moment...</h4>'
    });
  }

// function getsup() { 
//     var supplier = document.getElementById('supplier').value; 
//     var submitValue = "<?php echo $submit_value; ?>";

//     if(submitValue === 'Save'){
//       var url2 = "<?php echo base_url(); ?>Sales_inv2/getTerm?supplier=" + supplier;
//       $.ajax({
//         url: "<?php echo base_url(); ?>Sales_inv2/getTerm?supplier=" + supplier,
//         type: "GET",
//         dataType: "json", 
//         success: function(response) {
//             console.log(response);
//             if (response.term && Array.isArray(response.term) && response.term.length > 0) {
//                 $("#term").val(response.term[0].payment_term);
//             } else {
//                 $("#term").val("");
//             }
//         },
//         error: function(xhr, status, error) {
//             console.log("AJAX Error:", error);
//             console.log("Response Text:", xhr.responseText);
//         }
//       });
//     }
//     var jenis = $("#invtype").val();
//     var tgl = $("#tanggal_shipment").val();
//     var invtype = $("#invtype").val();
//     var sup = $("#supplier").val();
//     var vessel_name = $('#vesel_name').val();
//     var outinward = $('#outward_inward').val();
//     var voyage_no = $('#voyage_no').val();

//     //  $('#pizza_kind').prop('disabled', false);
//     if (jenis === 'bar') {
//       $("#detail_inv").html('');
//       if (!$('#dest_barge').val() && $("#tanggal_invoice").val()) {
//         setPulsate('#dest_barge, #dest_barge');
//         setToast('Please Select Form - To First');
//         $('#tanggal_invoice').val('');
//       } else {
//         if (!$('#dest_barge').val()) {
//           var bargedest = '0';
//         } else {
//           var bargedest = $('#dest_barge').val();
//         }

//         $("#barge").val('MARCOPOLO 252');
//         //$("#buyer").prop('disabled', 'disabled');
//         var url2 = "<?php echo base_url(); ?>Sales_inv2/get_detail2?date=" + tgl + "&invtype=" + invtype + "&bargedest=" + bargedest + "&sup=" + sup;

//         $.ajax({
//           url: url2,
//           success: function(response) {
//             $("#detail_inv").html(response);
//           },
//           dataType: "html",
//           beforeSend: block(),
//           complete: function() {
//             $.unblockUI();
//           }
//         });

//         getDetailContainer();
//         getDetailContainertrucking();
//       }

//     } else if (jenis === 'tet' || jenis === 'chinaShipment') {
//       if (!$('#dest_barge').val()) {
//         var bargedest = '0';
//       } else {
//         var bargedest = $('#dest_barge').val();
//       }

//       var url2 = "<?php echo base_url(); ?>Sales_inv2/get_detail2?date=" + tgl + "&invtype=" + invtype + "&bargedest=" + bargedest + "&sup=" + sup;

//       $.ajax({
//         url: url2,
//         success: function(response) {
//           $("#detail_inv").html(response);
//         },
//         dataType: "html",
//         beforeSend: block(),
//         complete: function() {
//           $.unblockUI();
//         }
//       });

//       getDetailContainer();
//       getDetailContainertrucking();

//     } else if (jenis === 'lem' || jenis === 'eim') {
//       if (!$('#dest_barge').val()) {
//         var bargedest = '0';
//       } else {
//         var bargedest = $('#dest_barge').val();
//       }

//       var url2 = "<?php echo base_url(); ?>Sales_inv2/get_detail2?date=" + tgl + "&invtype=" + invtype + "&bargedest=" + bargedest + "&sup=" + sup;

//       $.ajax({
//         url: url2,
//         success: function(response) {
//           $("#detail_inv").html(response);
//         },
//         dataType: "html",
//         beforeSend: block(),
//         complete: function() {
//           $.unblockUI();
//         }
//       });

//       getDetailContainer();
//       getDetailContainertrucking();
//     } else if (jenis == 'bargefreight') {
//       $("#detail_inv").html('');
//       if (tgl == "" || invtype == "" || sup == "" || vessel_name == "" || voyage_no == "") {
//         console.log("kosong");
//         return false;
//       }
//       var url = "<?php echo base_url(); ?>Sales_inv2/get_detail2?date=" + tgl + "&invtype=" + invtype + "&sup=" + sup + "&vessel=" + vessel_name + "&voyage_no=" + voyage_no;

//       $.ajax({
//         url: url,
//         success: function(response) {
//           $("#detail_inv").html(response);
//         },
//         dataType: "html",
//         beforeSend: block(),
//         complete: function() {
//           $.unblockUI();
//         }
//       });

//     } else if (jenis == 'invexcel') {
//       $("#detail_inv").html('');
//       var url = "<?php echo base_url(); ?>Sales_inv2/get_detail2?date=" + tgl + "&invtype=" + invtype + "&sup=" + sup + "&oi=" + outinward;

//       $.ajax({
//         url: url,
//         success: function(response) {
//           $("#detail_inv").html(response);
//         },
//         dataType: "html",
//         beforeSend: block(),
//         complete: function() {
//           $.unblockUI();
//         }
//       });

//       getDetailContainer();
//       getDetailContainertrucking();

//     } else {
//       $("#buyer").prop('disabled', false);
//       var urll = "<?php echo base_url(); ?>Sales_inv2/get_sup?date=" + tgl + "&type=" + invtype;
//       $.ajax({
//         url: urll,
//         success: function(response) {
//           $("#gantiincust").html(response);
//         },
//         dataType: "html",
//         beforeSend: block(),
//         complete: function() {
//           $.unblockUI();
//         }
//       });
//       // get_port();
//     }
//     return false;
// }

let isLoading = false;

function getsup() { 
    var supplier = document.getElementById('supplier').value; 
    var submitValue = "<?php echo $submit_value; ?>";

    if(submitValue === 'Save'){
      $.ajax({
        url: "<?php echo base_url(); ?>Sales_inv2/getTerm?supplier=" + supplier,
        type: "GET",
        dataType: "json", 
        success: function(response) {
            if (response.term && Array.isArray(response.term) && response.term.length > 0) {
                $("#term").val(response.term[0].payment_term);
            } else {
                $("#term").val("");
            }
        },
        error: function(xhr, status, error) {
            console.log("AJAX Error:", error);
        }
      });
    }

    if (supplier =='G00178') {
      $('#currency').val('SGD').trigger('change');
    }

    var jenis = $("#invtype").val();
    var tgl = $("#tanggal_shipment").val();
    var invtype = $("#invtype").val();
    var sup = $("#supplier").val();
    var vessel_name = $('#vesel_name').val();
    var outinward = $('#outward_inward').val();
    var voyage_no = $('#voyage_no').val();

    if (jenis === 'bar') {
      $("#detail_inv").html('');
      if (!$('#dest_barge').val() && $("#tanggal_invoice").val()) {
        setPulsate('#dest_barge, #dest_barge');
        setToast('Please Select Form - To First');
        $('#tanggal_invoice').val('');
      } else {
        var bargedest = $('#dest_barge').val() || '0';

        $("#barge").val('MARCOPOLO 252');

        var url2 = "<?php echo base_url(); ?>Sales_inv2/get_detail2?date=" + tgl + "&invtype=" + invtype + "&bargedest=" + bargedest + "&sup=" + sup;

        $.ajax({
          url: url2,
          success: function(response) {
            $("#detail_inv").html(response);
          },
          dataType: "html",
          beforeSend: function() { block(); },
          complete: function() {
            $.unblockUI();
          }
        });

        getDetailContainer();
        getDetailContainertrucking();
      }

    } else if (jenis === 'tet' || jenis === 'chinaShipment') {

      var bargedest = $('#dest_barge').val() || '0';

      var url2 = "<?php echo base_url(); ?>Sales_inv2/get_detail2?date=" + tgl + "&invtype=" + invtype + "&bargedest=" + bargedest + "&sup=" + sup;

      $.ajax({
        url: url2,
        success: function(response) {
          $("#detail_inv").html(response);
        },
        dataType: "html",
        beforeSend: function() { block(); },
        complete: function() {
          $.unblockUI();
        }
      });

      getDetailContainer();
      getDetailContainertrucking();

    } else if (jenis === 'lem' || jenis === 'eim') {

      var bargedest = $('#dest_barge').val() || '0';

      var url2 = "<?php echo base_url(); ?>Sales_inv2/get_detail2?date=" + tgl + "&invtype=" + invtype + "&bargedest=" + bargedest + "&sup=" + sup;

      $.ajax({
        url: url2,
        success: function(response) {
          $("#detail_inv").html(response);
        },
        dataType: "html",
        beforeSend: function() { block(); },
        complete: function() {
          $.unblockUI();
        }
      });

      getDetailContainer();
      getDetailContainertrucking();

    } else if (jenis == 'bargefreight') {

      if (isLoading) return; // ⬅️ anti double request

      $("#detail_inv").html('');

      if (tgl == "" || invtype == "" || sup == "" || vessel_name == "" || voyage_no == "") {
        console.log("kosong");
        return false;
      }

      var url = "<?php echo base_url(); ?>Sales_inv2/get_detail2?date=" + tgl + "&invtype=" + invtype + "&sup=" + sup + "&vessel=" + vessel_name + "&voyage_no=" + voyage_no;

      isLoading = true;

      $.ajax({
        url: url,
        success: function(response) {
          $("#detail_inv").html(response);
        },
        dataType: "html",
        beforeSend: function() { block(); },
        complete: function() {
          $.unblockUI();
          isLoading = false;
        }
      });

    } else if (jenis == 'invexcel') {

      $("#detail_inv").html('');

      var url = "<?php echo base_url(); ?>Sales_inv2/get_detail2?date=" + tgl + "&invtype=" + invtype + "&sup=" + sup + "&oi=" + outinward;

      $.ajax({
        url: url,
        success: function(response) {
          $("#detail_inv").html(response);
        },
        dataType: "html",
        beforeSend: function() { block(); },
        complete: function() {
          $.unblockUI();
        }
      });

      getDetailContainer();
      getDetailContainertrucking();

    } else {

      $("#buyer").prop('disabled', false);

      var urll = "<?php echo base_url(); ?>Sales_inv2/get_sup?date=" + tgl + "&type=" + invtype;

      $.ajax({
        url: urll,
        success: function(response) {
          $("#gantiincust").html(response);
        },
        dataType: "html",
        beforeSend: function() { block(); },
        complete: function() {
          $.unblockUI();
        }
      });
    }

    return false;
}


  function isi_barge() {
    var barge = $('#vesselname').val();
    $('#barge').val(barge);
  }

  // function hidden_vessel() {
  //     $invtype = $("#invtype").val();

  //     if ($invtype === 'fre') {
  //         $('#divvessel').show();
  //     } else {
  //         $('#divvessel').hide();
  //     }
  // }


  // function cekbarge(){
  //     $inv = $("#invtype").val();
  //     if($inv === 'bar'){
  //         $("#bargedest").show();
  //         $("#diveta").show();
  //         $("#divetd").show();
  //         // $("#divbuyer").hide();
  //         $("#divport").hide();
  //         $("#divshipment").show();
  //         $("#monthship").hide();
  //     }else{
  //         $("#bargedest").hide();
  //         $("#diveta").hide();
  //         $("#divetd").hide();
  //         // $("#divbuyer").show();
  //         $("#divport").show();
  //         $("#divshipment").hide();
  //         $("#monthship").show();
  //     }
  // }

  function cekbarge() {
    var inv = $("#invtype").val();
    var inv_array = ['bar', 'lem', 'eim', 'tet', 'chinaShipment'];
    if (inv_array.includes(inv)) {
      $("#bargedest").show();
      $("#diveta").show();
      $("#divetd").show();
      $("#divport").hide();
      $("#divshipment").show();
      $("#monthship").hide();
      $("#prf").hide();
      $("#exc").hide();
      $("#vesselfield").hide();
      $("#voyagefield").hide();
    } else if (inv == 'bargefreight') {
      $("#bargedest").hide();
      $("#diveta").hide();
      $("#divetd").hide();
      $("#divport").hide();
      $("#divshipment").show();
      $("#vesselfield").show();
      $("#voyagefield").show();
      $("#monthship").hide();
      $("#prf").hide();
      $("#exc").hide();
      $("#btnctldtl").hide();
      $("#btnctldtltruck").hide();
    } else if (inv == 'invexcel') {
      $("#bargedest").hide();
      $("#diveta").hide();
      $("#divetd").hide();
      $("#divport").hide();
      $("#divshipment").show();
      $("#outwardinwardfield").show();
      $("#vesselfield").hide();
      $("#monthship").hide();
      $("#prf").hide();
      $("#exc").hide();
      $("#btnctldtl").hide();
      $("#btnctldtltruck").hide();
      $("#voyagefield").hide();
    } else {
      $("#bargedest").hide();
      $("#diveta").hide();
      $("#divetd").hide();
      $("#divport").show();
      $("#divshipment").hide();
      $("#monthship").show();
      $("#prf").show();
      $("#exc").show();
      $("#vesselfield").hide();
      $("#voyagefield").hide();

      get_detail_freigth();
      get_detail_freigthcont();
    }
  }

  // function hitung_total_usd_bf() {
  //   var barge = document.getElementsByClassName('jenisbarge');
  //   for (var i = 1; i <= barge.length; i++) {
  //     hitung_total(i);
  //   }
  // }


//gebby
  // function hitung_total_usd_bf() {
  //   var barge = document.getElementsByClassName('jenisbarge');
  //   for (var i = 0; i <= barge.length; i++) {
  //     hitung_total(i);
  //   }
  // }

  function hitung_total_usd_bf() {
  var barge = document.getElementsByClassName('jenisbarge');

  for (var i = 0; i < barge.length; i++) { // ❗ FIX: <= jadi <
    try {
      hitung_total(i);
    } catch (e) {
      console.log("skip index", i, e);
    }
  }
}
  ///



  // function hitung_total(x) {
  //   var txt = "txtHarga-" + x;
  //   var total = "#txtTotal-" + x;
  //   var unit = "#unit-" + x;
  //   var usd = "txtUSD-" + x;
  //   var rate = $("#rate_currency").val();
  //   var t = $(unit).val();

  //   var harga = document.getElementById(txt).value;

  //   var amount = t * harga;
  //   var totusd = t * harga * rate;
  //   $(total).val(amount);

  //   document.getElementById(usd).value = totusd.toFixed(2);
  //   hitung_semua();
  // }



  //gebby
//   function hitung_total(x) {
//     var txt = "txtHarga-" + x;
//     var total = "#txtTotal-" + x;
//     var unit = "#unit-" + x;
//     var usd = "txtUSD-" + x;
//     var rate = parseFloat($("#rate_currency").val()) || 0;

//     var t = parseFloat($(unit).val()) || 0;
//     var harga = document.getElementById(txt).value.replace(/,/g, '');
//     harga = parseFloat(harga) || 0;

//     var amount = t * harga;
//     var totusd = amount * rate;

//     $(total).val(amount);
//     document.getElementById(usd).value = totusd.toFixed(2);

//     // 🔥 TAMBAH INI
//     cek_gst(x);

//     hitung_semua();
// }

function hitung_total(x) {
  var txt = "txtHarga-" + x;
  var total = "#txtTotal-" + x;
  var unit = "#unit-" + x;
  var usd = "txtUSD-" + x;

  var rate = parseFloat($("#rate_currency").val()) || 0;

  var unitEl = $(unit);
  var hargaEl = document.getElementById(txt);
  var usdEl = document.getElementById(usd);

  // ❗ STOP kalau element tidak ada (ini yang bikin error sebelumnya)
  if (!unitEl.length || !hargaEl || !usdEl) return;

  var t = parseFloat(unitEl.val()) || 0;

  var harga = hargaEl.value ? hargaEl.value.replace(/,/g, '') : 0;
  harga = parseFloat(harga) || 0;

  var amount = t * harga;
  var totusd = amount * rate;

  $(total).val(amount);
  usdEl.value = totusd.toFixed(2);

  cek_gst(x);
  hitung_semua();
}

///

  function hitung_total_freigth() {
    var unit = document.getElementsByClassName('unit');
    var txtHarga = document.getElementsByClassName('txtHarga');
    var txtTotal = document.getElementsByClassName('txtTotal');
    var txtUSD = document.getElementsByClassName('txtUSD');
    var rate = document.getElementById('rate_currency').value;

    for (var i = 0; i < unit.length; i++) {
      txtTotal[i].value = unit[i].value * txtHarga[i].value;
      txtUSD[i].value = unit[i].value * txtHarga[i].value * rate;
    }

    hitung_semua();
  }

  function cek_gst(x) {
    var gst = "txtGST-" + x;
    var usd = "txtTotal-" + x;
    var gstvalue = "txtGSTValue-" + x;

    var gst_t = document.getElementById(gst).value;
    var usd = document.getElementById(usd).value;

    var year = '<?= date("Y") ?>';

    var gst = 0;

    if (year < "2023") {
      gst = 8;

    } else {
      gst = 9;
    }

    if (gst_t === "GST") {
      var v = usd * gst / 100;
    } else {
      var v = 0;
    }

    document.getElementById(gstvalue).value = v;

    hitung_semua();
  }

  // function hitung_semua() {

  //   var txt = document.getElementsByClassName("txtTotal");
  //   var usd = document.getElementsByClassName("txtUSD");
  //   var gst = document.getElementsByClassName("txtGSTValue");
  //   var th = 0;
  //   var tu = 0;
  //   var tg = 0;
  //   for (var i = 0; i < txt.length; i++) {
  //     th += parseFloat(txt[i].value.replace(/,/g, ""));
  //     tu += parseFloat(usd[i].value.replace(/,/g, ""));
  //     tg += parseFloat(gst[i].value.replace(/,/g, ""));
  //     // alert('adaerror');
  //   }

  //   var tsm = parseFloat(tg) + parseFloat(th);

  //   document.getElementById("totalinv").value = number_format(th, 2);
  //   document.getElementById("totalinvusd").value = number_format(tu, 2);
  //   document.getElementById("totalgst").value = number_format(tg, 2);
  //   document.getElementById("stotalinv").value = number_format(tsm, 2);
  // }

  //gebby

  function hitung_semua() {

  var txt = document.getElementsByClassName("txtTotal");
  var usd = document.getElementsByClassName("txtUSD");
  var gst = document.getElementsByClassName("txtGSTValue");

  var th = 0, tu = 0, tg = 0;

  for (var i = 0; i < txt.length; i++) {
    th += parseFloat((txt[i].value || "0").replace(/,/g, "")) || 0;
    tu += parseFloat((usd[i].value || "0").replace(/,/g, "")) || 0;
    tg += parseFloat((gst[i].value || "0").replace(/,/g, "")) || 0;
  }

  var tsm = tg + th;

  if (document.getElementById("totalinv"))
    document.getElementById("totalinv").value = number_format(th, 2);

  if (document.getElementById("totalinvusd"))
    document.getElementById("totalinvusd").value = number_format(tu, 2);

  if (document.getElementById("totalgst"))
    document.getElementById("totalgst").value = number_format(tg, 2);

  if (document.getElementById("stotalinv"))
    document.getElementById("stotalinv").value = number_format(tsm, 2);
}

////////////////////////////////////////////////////////////////////////////

  function ambil_harga(x) {

    var z = "#idcont-" + x;
    var idcont = $(z).val();
    var j = "#jenisbarge-" + x;
    var idjenis = $(j).val();
    var harga = "#txtHarga-" + x;

    var sup = $("#supplier").val();
    var url = "<?php echo base_url(); ?>Sales_inv2/getharga?idcont=" + idcont + "&jen=" + idjenis + "&x=" + x + "&sup=" + sup;
    $.ajax({
      url: url,
      success: function(results) {
        var isi = "#isi-" + x;
        $(isi).html(results);
        hitung_total(x);
      },
      dataType: "html"
    });
  }

  function setPulsate(elm) {
    $(elm).pulsate({
      color: "#D9000B",
      reach: 30,
      repeat: 5,
      speed: 500,
      glow: true
    });
  }

  function setToast(txtMsg) {
    $('#toast-container').stop().fadeIn(300).delay(1000).fadeOut(600);
    $('.toast-message').html(txtMsg);
  }

  function gethargabarge() {
    var barge = document.getElementsByClassName('jenisbarge');

    for (var i = 0; i < barge.length; i++) {
      ambil_harga(i);
    }
  }

  function geteta() {
    var destbarge = $("#dest_barge").val();
    var tglshipment = $("#tanggal_shipment").val();
    var url = "<?php echo base_url(); ?>Sales_inv2/geteta?destbarge=" + destbarge + "&shipdate=" + tglshipment;

    $.ajax({
      url: url,
      success: function(response) {
        $("#etachange").html(response);
      },
      dataType: "html"
    });
  }

  function getetd() {
    var destbarge = $("#dest_barge").val();
    var tglshipment = $("#tanggal_shipment").val();
    var url = "<?php echo base_url(); ?>Sales_inv2/getetd?destbarge=" + destbarge + "&shipdate=" + tglshipment;

    $.ajax({
      url: url,
      success: function(response) {
        $("#etdchange").html(response);
      },
      dataType: "html"
    });
  }

  function getbarge() {
    var destbarge = $("#dest_barge").val();
    var tglshipment = $("#tanggal_shipment").val();
    var url = "<?php echo base_url(); ?>Sales_inv2/getbarge?destbarge=" + destbarge + "&shipdate=" + tglshipment;

    $.ajax({
      url: url,
      success: function(response) {
        $("#divbar").html(response);
      },
      dataType: "html"
    });
  }


  function geteta2() {
    var destbarge = $("#dest_barge").val();
    var tglshipment = $("#tanggal_shipment").val();
    var url = "<?php echo base_url(); ?>Sales_inv2/geteta2?destbarge=" + destbarge + "&shipdate=" + tglshipment;

    $.ajax({
      url: url,
      success: function(response) {
        $("#etachange").html(response);
      },
      dataType: "html"
    });
  }

  function getetd2() {
    var destbarge = $("#dest_barge").val();
    var tglshipment = $("#tanggal_shipment").val();
    var url = "<?php echo base_url(); ?>Sales_inv2/getetd2?destbarge=" + destbarge + "&shipdate=" + tglshipment;

    $.ajax({
      url: url,
      success: function(response) {
        $("#etdchange").html(response);
      },
      dataType: "html"
    });
  }

  function getbarge2() {
    var destbarge = $("#dest_barge").val();
    var tglshipment = $("#tanggal_shipment").val();
    var url = "<?php echo base_url(); ?>Sales_inv2/getbarge2?destbarge=" + destbarge + "&shipdate=" + tglshipment;

    $.ajax({
      url: url,
      success: function(response) {
        $("#divbar").html(response);
      },
      dataType: "html"
    });
  }

  function get_detail_freigth() {
    var bulan = $("#monthlyship").val();
    var tahun = $("#yearship").val();
    var tgl = "01/" + bulan + "/" + tahun;

    var url = "<?php echo base_url(); ?>Sales_inv2/get_detail_freigth?tgl=" + tgl;

    $.ajax({
      url: url,
      success: function(response) {
        $("#detail_inv").html(response);
      },
      dataType: "html",
      beforeSend: block(),
      complete: function() {
        $.unblockUI();
      }
    });
  }

  function get_detail_freigthcont() {
    var bulan = $("#monthlyship").val();
    var tahun = $("#yearship").val();

    var tgl = "01/" + bulan + "/" + tahun;
    var url = "<?php echo base_url(); ?>Sales_inv2/get_detail_freigthcont?tgl=" + tgl;

    $.ajax({
      url: url,
      success: function(response) {
        $("#dtl_cont").html(response);
      },
      dataType: "html"
    });
  }

  function printfre() {
    var bulan = $("#monthlyship").val();
    var tahun = $("#yearship").val();

    var tgl = "01/" + bulan + "/" + tahun;
    var url = "<?= base_url(); ?>Sales_inv2/printpreview_detail?tgl=" + tgl;
    window.open(url, '_blank');
  }

  function printfreexcel() {
    var bulan = $("#monthlyship").val();
    var tahun = $("#yearship").val();

    var tgl = "01/" + bulan + "/" + tahun;

    var url = "<?= base_url(); ?>Sales_inv2/freight_excel?tgl=" + tgl;
    window.open(url, '_blank');
  }

  function fnDialogMasterBank() {
    // HTML content with proper formatting
    var dialogContent = `
                <div class='portlet-body'>
                    <div class='table-scrollable' style='overflow: auto; height:150px;'>
                        <table id='tbl-masterbank' class='table table-bordered'>
                            <thead>
                                <tr>
                                    <th>Account No</th>
                                    <th>Name</th>
                                    <th>Currency</th>
                                    <th>Account 2</th>
                                    <th>Currency 2</th>
                                </tr>
                            </thead>
                            <tbody id='tblmasterbank'>
                                <?php foreach ($bank as $r) : ?>
                                    <tr ondblclick="clickmasterBank(this)" style="cursor: pointer;">
                                        <td nowrap><?= $r->bank_account_number ?></td>
                                        <td nowrap><?= $r->bank_name ?></td>
                                        <td nowrap><?= $r->bank_currency_id ?></td>
                                        <td nowrap><?= $r->bank_account_number_2 ?></td>
                                        <td nowrap><?= $r->bank_currency_id_2 ?></td>
                                 <td hidden><textarea><?= ltrim($r->bank_name) . '&#10;' . 'SWIFT: ' . $r->bank_swift . '&#10;' . $r->bank_currency_id . ' Account No: ' . $r->bank_account_number . '&#10;' . $r->bank_currency_id_2 . ' Account No: ' . $r->bank_account_number_2 . '&#10;' . 'for Account of Zhenghe Logistic Pte Ltd' . (($r->swift_intermediary != '') ? '&#10;' . 'Intermediary Bank ' . $r->intermediary  . '&#10;' . 'SWIFT: ' . $r->swift_intermediary : '') ?>
                                </textarea>
                                 </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <div class='col-md-12' style='margin-left: -15px; margin-bottom: 20px;'>
                        <textarea class='form-control ckeditor' id='txtmasterbank' style='width: 770px; height: 131px;'></textarea>
                    </div>
                    <div class='col-md-6'>
                        <button type='button' class='col-md-4 btn blue' onclick='choose_bankmaster()'>Sent</button>
                        <button type='button' class='col-md-4 btn grey' onclick='close_bankmaster()'>Close</button>
                    </div>
                </div>
            `;

    // Set HTML content to the dialog
    $("#formdialogMasterBank").html(dialogContent);

    // Define the Dialog and its properties.
    $("#formdialogMasterBank").dialog({
      resizable: false,
      modal: true,
      title: "Remit Master Bank",
      top: 5,
      height: 500,
      width: 800
    });

    // Set the value of txtpayment
    $("#txtmasterbank").val($("#paymentto").val());
  }
  function close_bankmaster() {
    $("#formdialogMasterBank").dialog("close");
  }
  function choose_bankmaster() {
    document.getElementById('paymentto').value = document.getElementById('txtmasterbank').value;
    $("#formdialogMasterBank").dialog("close");
  }

  function clickmasterBank(x) {

    function getText(el) {
      if (typeof el.textContent == 'string') return el.textContent;
      if (typeof el.innerText == 'string') return el.innerText;
    }

    let $r = x.rowIndex;
    document.getElementById('txtmasterbank').value = getText(document.getElementById('tbl-masterbank').rows[$r].cells[5]);
  }
</script>

<!-- gebby -->
<script>
let index = <?= isset($i) ? $i : 0 ?>;
let hideTypeBarge = "<?= $hide ?>";

function tambahRow() {
    let actionRow = document.getElementById("row-action");
    if (!actionRow) {
        console.error("row-action tidak ditemukan!");
        return;
    }

    let newRow = document.createElement("tr");

    let typeBargeCol = '';
    if (hideTypeBarge !== 'hidden') {
        typeBargeCol = `
        <td>
            <input type="text" name="jenisbarge[]" id="jenisbarge-${index}" class="txt jenisbarge">
        </td>`;
    } else {
        typeBargeCol = `<td hidden></td>`;
    }

    newRow.innerHTML = `
    <td><input type="checkbox" class="row-check"></td>

    <td>
        <input type="hidden" name="detailidcont[]" value="0">
        <input type="hidden" name="idcontainer[]" value="0">
        <input type="text" name="accNum[]" class="txt accNum" id="accNum-${index}">
    </td>

    <td><input type="text" name="dept_code[]" class="txt dept_code" id="dept_code-${index}"></td>

    <td><input type="text" name="accName[]" class="txt accName" id="accName-${index}"></td>

    <td><textarea name="det_items[]" id="det_items-${index}"></textarea></td>

    <td><textarea name="descr[]" id="descr-${index}"></textarea></td>

    ${typeBargeCol}

    <td><input type="text" name="unit[]" class="txt unit number" id="unit-${index}" onkeyup="hitung_total(${index})"></td>

    <td><input type="text" name="txtHarga[]" class="txt number txtHarga" id="txtHarga-${index}" onchange="hitung_total(${index})"></td>

    <td><input type="text" name="txtTotal[]" class="txt number txtTotal" id="txtTotal-${index}" readonly></td>

    <td><input type="text" name="txtUSD[]" class="txt number txtUSD" id="txtUSD-${index}" readonly></td>

    <td>
        <select name="txtGST[]" onchange="cek_gst(${index})" id="txtGST-${index}" class="txt txtGST">
            <option value="">Select</option>
            <option value="GST">GST</option>
            <option value="ZER">Zero Rate</option>
            <option value="EXP">Exempt</option>
            <option value="OUT">Out of Scope</option>
        </select>
    </td>

    <td><input type="text" class="txt number txtGSTValue" name="txtGSTValue[]" id="txtGSTValue-${index}"></td>
    `;

    // Masukkan row baru sebelum tombol action, tetap di bawah semua data
    actionRow.parentNode.insertBefore(newRow, actionRow);

    index++;
}

function deleteRow() {
  let checkboxes = document.querySelectorAll('.row-check:checked');

  checkboxes.forEach(function(cb) {
    cb.closest('tr').remove();
  });

  hitung_total_semua(); // kalau ada fungsi total
}

// checklist semua
document.getElementById('checkAll').addEventListener('change', function() {
  let checked = this.checked;
  document.querySelectorAll('.row-check').forEach(function(cb) {
    cb.checked = checked;
  });
});
</script>