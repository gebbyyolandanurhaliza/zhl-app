<?php
$proses = '0';
$allow_update = '0';
$jurnal_barge_sales = '0';

foreach ($cont as $r) {
  $contid =  $r->contid;
  $tipe =  $r->tipe;
  $shipment =  date("d-m-Y",  strtotime($r->shipmentdate));
  $barge =  $r->barge;
  $voyage =  $r->voyage;
  $etd =  $r->etd;
  $eta = $r->eta;
  $etddateTemp = $r->etddate;
  $etadateTemp = $r->etadate;
  $stuffing = $r->stuffing;
  $to = $r->to;
  $from =  $r->from;
  $remarks =  $r->remarks;
  $factory_id = $r->factory_id;

  if ($r->allow_update == '1') {
    $allow_update = $r->allow_update;
  }

  if ($r->proses == '1') {
    $proses = $r->proses;
  }

  if ($etddateTemp != '0000-00-00') {
    $etddate =  date("d-m-Y",  strtotime($etddateTemp));
  } else {
    $etddate = '';
  }

  if ($etadateTemp != '0000-00-00') {
    $etadate =  date("d-m-Y",  strtotime($etadateTemp));
  } else {
    $etadate = '';
  }

  $amendmenttemp = $r->amendment;
  if ($amendmenttemp != '0000-00-00') {
    $amendment =  date("d-m-Y",  strtotime($amendmenttemp));
  } else {
    $amendment = '';
  }
}
?>

<script>
  $(document).ready(function() {
    if (<?php echo $proses; ?> == '1') {
      $('#btn-update').attr('disabled', true);
      var rows = document.getElementById('tblList').rows;
      for (var row = 0; row < rows.length; row++) {
        //                var cols = rows[row].cells;
        //                cols[0].style.display = 'none';
      }
    }
  });
</script>

<script>
  $(document).ready(function() {
    if (<?php echo $allow_update; ?> == '1') {
      $('#btn-update').attr('disabled', false);
      var rows = document.getElementById('tblList').rows;
      for (var row = 0; row < rows.length; row++) {
        //                var cols = rows[row].cells;
        //                cols[0].style.display = 'none';
      }
    }
  });
</script>

<!-- <link href="<?php echo base_url(); ?>assets/admin/css/cloud-admin.css" rel="stylesheet" type="text/css"> -->

<div class="page-content" id="oke">
  <div class="container-fluid">

    <div class="row">
      <div class="col-md-12">
        <?php
        if ($this->session->flashdata('message')) :
          echo $this->session->flashdata('message');
        endif;
        ?>
        <div class="portlet light">
          <div class="portlet-title">
            <div class="caption">
              <i class="fa fa-navicon theme-font"></i>
              <span class="caption-subject theme-font bold">Container Inward</span>
            </div>
          </div>
          <div class="portlet-body form">
            <form action="<?php echo site_url('shipping/container_save/update'); ?>" method="post" class="form-horizontal" role="form">
              <div class="form-body">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group" style="margin-bottom:1px;">
                      <label class="col-md-3 label-sm">Tipe</label>
                      <div class="col-md-3">
                        <select class="form-control select2me" name="tipe">
                          <option value="2">Container Inward</option>
                        </select>
                      </div>
                    </div>
                    <div class="form-group" style="margin-bottom:1px;">
                      <label class="col-md-3 label-sm">Shipment Date</label>
                      <div class="col-md-3">
                        <input class="form-control input-sm date date-picker" name="shipdate" data-date="02-12-2012" data-date-format="dd-mm-yyyy" value="<?php echo $shipment; ?>" required>
                        <input class="form-control input-sm" name="contid" id="contid" value="<?php echo $contid; ?>" type="hidden">
                        <input class="form-control input-sm" name="tipe1" id="tipe1" value="<?php echo $tipe; ?>" type="hidden">
                      </div>
                    </div>
                    <div class="form-group" style="margin-bottom:1px;">
                      <label class="col-md-3 label-sm">Vessel ( Barge)</label>
                      <div class="col-md-5">
                        <input class="form-control input-sm" name="barge" value="<?php echo $barge; ?>">
                      </div>
                    </div>
                    <div class="form-group" style="margin-bottom:1px;">
                      <label class="col-md-3 label-sm">Voyage</label>
                      <div class="col-md-5">
                        <input class="form-control input-sm" name="voyage" value="<?php echo $voyage; ?>">
                      </div>
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group" style="margin-bottom:1px;">
                      <label class="col-md-2 label-sm">ETD</label>
                      <div class="col-md-7">
                        <div class="input-group">
                          <!-- <input class="form-control input-sm" name="etd" value="<?php echo $etd; ?>"> -->
                          <select name="etd" class="form-control input-sm" id="etd">
                            <option id="RSUP" value="RSUP" <?php if ($r->etd === "RSUP") {
                                                              echo 'selected';
                                                            } ?>>Riau Sakti United Plantation
                            <option id="PSG" value="PSG" <?php if ($r->etd === "PSG") {
                                                            echo 'selected';
                                                          } ?>>Pulau Sambu Guntung
                          </select>
                          <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                          <input class="form-control input-sm date date-picker" placeholder="ETD Date" name="etddate" data-date="02-12-2012" data-date-format="dd-mm-yyyy" value="<?php echo $etddate; ?>">
                        </div>
                      </div>
                    </div>
                    <div class="form-group" style="margin-bottom:1px;">
                      <label class="col-md-2 label-sm">ETA</label>
                      <div class="col-md-7">
                        <div class="input-group">
                          <input class="form-control input-sm" name="eta" value="<?php echo $eta; ?>" readonly>
                          <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                          <input class="form-control input-sm date date-picker" placeholder="ETA Date" name="etadate" data-date="02-12-2012" data-date-format="dd-mm-yyyy" value="<?php echo $etadate; ?>">
                        </div>
                      </div>
                    </div>
                    <div class="form-group" style="margin-bottom:1px;">
                      <label class="col-md-2 label-sm">To</label>
                      <div class="col-md-7">
                        <input class="form-control input-sm" name="to" value="<?php echo $to; ?>">
                      </div>
                    </div>
                    <div class="form-group" style="margin-bottom:1px;">
                      <label class="col-md-2 label-sm">From</label>
                      <div class="col-md-7">
                        <input class="form-control input-sm" name="from" value="<?php echo $from; ?>">
                      </div>
                    </div>
                    <div class="form-group" style="margin-bottom:1px;<?php if ($proses == '0') {
                                                                        echo 'display: none';
                                                                      } ?>">
                      <label class="col-md-2 label-sm">Amendment</label>
                      <div class="col-md-4">
                        <input class="form-control input-sm date date-picker" name="amendmentdate" id="amendmentdate" data-date="02-12-2012" data-date-format="dd-mm-yyyy" value="<?php echo $amendment; ?>" onchange="amendment()">
                      </div>
                    </div>
                  </div>
                </div>

                <hr>

                <div class="table-scrollable">
                  <table class="table table-bordered" id="tblList">
                    <thead>
                      <tr>
                        <th width="10px"><button class="btn btn-sm btn-primary" type="button" id="btn-po" onclick="fnDialogPO()"><i class="fa fa-arrow-down"></i></button></th>
                        <th nowrap>Seq No</th>
                        <th nowrap>PO Number</th>
                        <th nowrap>Shipper/Carrier</th>
                        <th nowrap>FCL</th>
                        <th nowrap>Destination</th>
                        <th nowrap>Booking Ref</th>
                        <th nowrap>Supplier</th>
                        <th nowrap>Vessel/Voyage</th>
                        <th nowrap>Connecting Vessel</th>
                        <th nowrap>Stuffing</th>
                        <th nowrap>Depot</th>
                        <th nowrap>POD</th>
                        <th nowrap>OP Code</th>
                        <th nowrap>ETA Sin</th>
                        <th nowrap>Container</th>
                        <th nowrap>Seal</th>
                        <th nowrap>Actual Seal</th>
                        <th nowrap>Weight</th>
                        <th nowrap>ETA</th>
                        <th nowrap>Bill Status</th>
                      </tr>
                    </thead>
                    <tbody id="tblList_1">
                      <?php
                      $i = 0;
                      foreach ($cont as $r) { ?>
                        <!-- <tr onclick="deleterow(this)"> -->
                        <tr>
                          <?php if ($r->jurnal_barge_sales != '') { ?>

                            <td></td>

                          <?php } else { ?>

                            <td align="center">
                              <button class="btn btn-sm btn-danger" type="button" id="btn-delete" onclick="deleterow(<?= $r->detail_id; ?>, <?= $r->flag; ?>)"><i class="fa fa-trash"></i></button>

                              <?php if ($r->proses != '') { ?>

                                <button class="btn btn-sm green" type="button" id="btn-change-ship" onclick="changerow(<?= $r->id; ?>, <?= $r->flag; ?>, <?= $r->shipid; ?>)"><i class="fa fa-refresh"></i></button>

                                <?php if ($r->allow_update != 1) { ?>

                                  <button class="btn yellow" type="button" id="btn-enable" onclick="enable_update(<?= $r->shipid; ?>)"><i class="fa fa-cog"></i></button>

                                <?php } else { ?>

                                  <button class="btn red" type="button" id="btn-disable" onclick="disable_update(<?= $r->shipid; ?>)"><i class="fa fa-power-off"></i></button>

                                <?php } ?>

                              <?php } else { ?>


                                <button class="btn btn-sm green" type="button" id="btn-change-ship" onclick="changerow(<?= $r->id; ?>, <?= $r->flag; ?>, <?= $r->shipid; ?>)"><i class="fa fa-refresh"></i></button>

                                <?php if ($r->allow_update != 1) { ?>

                                  <button class="btn yellow" type="button" id="btn-enable" onclick="enable_update(<?= $r->shipid; ?>)"><i class="fa fa-cog"></i></button>

                                <?php } else { ?>

                                  <button class="btn red" type="button" id="btn-disable" onclick="disable_update(<?= $r->shipid; ?>)"><i class="fa fa-power-off"></i></button>

                                <?php } ?>

                              <?php } ?>

                            </td>

                          <?php } ?>

                          <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 50px;" name="urut[]" value="<?php echo $r->urut; ?>"></td>
                          <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 110px;" name="po[]" value="<?php echo $r->po_number; ?>" disabled>
                            <input type="hidden" name="po_number" id="po_number-<?= $i; ?>">
                          </td>
                          <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 230px;" name="carrier[]" value="<?php echo $r->shipping_liner; ?>"></td>
                          <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 230px;" name="fcl[]" value="<?php echo $r->container_name; ?>" disabled></td>
                          <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 150px;" name="final[]" value="<?php echo $r->destination; ?>"></td>
                          <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 150px;" name="reff[]" value="<?php echo $r->reff; ?>"></td>
                          <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 150px;" name="supplier[]" value="<?php echo $r->supplier; ?>"></td>
                          <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 150px;" name="vessel[]" value="<?php echo $r->vessel; ?>"></td>
                          <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 150px;" name="convessel[]" value="<?php echo $r->convessel; ?>"></td>
                          <td nowrap onclick="event.stopPropagation();return false;"><select name="stuffing[]">
                              <option id="EE" value="EE" <?php if ($r->stuffing === "EE") {
                                                            echo 'selected';
                                                          } ?>>Export Empty
                              <option id="EL" value="EL" <?php if ($r->stuffing === "EL") {
                                                            echo 'selected';
                                                          } ?>>Export Laden
                              <option id="IL" value="IL" <?php if ($r->stuffing === "IL") {
                                                            echo 'selected';
                                                          } ?>>Import Laden
                              <option id="IT" value="IT" <?php if ($r->stuffing === "IT") {
                                                            echo 'selected';
                                                          } ?>>Import Transhipment
                              <option id="LC" value="LC" <?php if ($r->stuffing === "LC") {
                                                            echo 'selected';
                                                          } ?>>Local Container
                              <option id="RE" value="RE" <?php if ($r->stuffing === "RE") {
                                                            echo 'selected';
                                                          } ?>>Recall Container
                              <option id="EE_TP" value="EE_TP" <?php if ($r->stuffing === "EE_TP") {
                                                                  echo 'selected';
                                                                } ?>>Export Empty (TP)
                            </select></td>
                          <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 80px;" name="depot[]" value="<?php echo $r->depot; ?>"></td>
                          <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 80px;" name="pod[]" value="<?php echo $r->pod; ?>"></td>
                          <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 80px;" name="opcode[]" value="<?php echo $r->opcode; ?>"></td>
                          <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 100px;" data-date="02-12-2012" name="etdsin[]" value="<?php echo $r->etdsin; ?>"></td>

                          <?php
                          if ($r->proses == 1) {
                          ?>
                            <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 150px;" name="container[]" id="ci" value="<?php echo $r->container; ?>" readonly=""></td>
                          <?php
                          } else {
                          ?>
                            <td nowrap onclick="event.stopPropagation();return false;"><input ondblclick="fnDialogContainerChange(<?= $r->detail_id; ?>, <?php echo "'" . $r->container . "'"; ?>)" type="text" class="form-control input-sm" style="width: 150px;" name="container[]" id="ci-<?= $r->detail_id; ?>" value="<?php echo $r->container; ?>" readonly=""></td>
                          <?php
                          }
                          ?>

                          <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 100px;" name="seal[]" value="<?php echo $r->seal; ?>"></td>
                          <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 100px;" name="actual_seal[]" value="<?php echo $r->actual_seal; ?>"></td>
                          <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm text-right" style="width: 80px;" name="weight[]" value="<?php echo $r->weight; ?>" onkeypress="return isNumber(event)"></td>
                          <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 100px;" name="etasin[]" value="<?php echo $r->etasin; ?>"></td>
                          <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 130px;" name="bill[]" value="<?php echo $r->jurnal_barge_sales; ?>" readonly></td>
                          <td hidden><input type="text" class="form-control input-sm" name="shipid[]" value="<?php echo $r->shipid; ?>"></td>
                          <td hidden><input type="text" class="form-control input-sm" name="outward[]" value="<?php echo $r->flag; ?>"></td>
                          <td hidden><input type="text" class="form-control input-sm" name="id[]" value="<?php echo $r->id; ?>"></td>
                        </tr>
                      <?php
                        $i++;
                      } ?>
                    </tbody>
                  </table>
                </div>
                <a class="btn btn-primary" onclick="excel_template()"><i class="fa fa-download"> Download Template Container and Seal Number</i></a>
                <a class="btn btn-primary green" href="<?php echo site_url('shipping/container_import_excel?cont=' . $contid . '&tipe=' . $tipe); ?>"><i class="fa fa-upload"> Upload Container and Seal Number</i></a>
                <br>
                <hr>
                <div class="portlet-title">
                  <div class="caption">
                    <i class="fa fa-navicon theme-font"></i>
                    <span class="caption-subject theme-font bold">Local Container</span>
                  </div>
                </div>
                <div class="table-scrollable">
                  <table class="table table-bordered" id="tblList_lc">
                    <thead>
                      <tr>
                        <th width="10px"><button class="btn btn-sm btn-primary" type="button" onclick="fnDialogPO_lc()"><i class="fa fa-arrow-down"></i></button></th>
                        <th nowrap width="20">Seq No</th>
                        <th nowrap>Stuffing</th>
                        <th nowrap>Container Type</th>
                        <th nowrap>Container Number</th>
                        <th nowrap>Supplier</th>
                        <th nowrap>Customer</th>
                        <th nowrap>Booking Reff</th>
                      </tr>
                    </thead>
                    <tbody id="tblList_1_lc">
                      <?php
                      $no = 1;
                      foreach ($cont_local as $s) { ?>
                        <tr>
                          <td align="center"><button class="btn btn-sm btn-danger" type="button" onclick="deleterow_lc_db(<?= $s->id; ?>)"><i class="fa fa-trash"></i></button></td>
                          <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" name="urut[]" value="<?php echo $no; ?>"></td>
                          <td nowrap onclick="event.stopPropagation();return false;" style="width: 100px;"><select name="stuffing_lc[]" id="stuffing_lc">
                              <option value="LE" id="LE" <?php if ($s->stuffing == 'LE') {
                                                            echo 'selected';
                                                          } ?>>Local Empty
                              <option value="LL" id="LL" <?php if ($s->stuffing == 'LL') {
                                                            echo 'selected';
                                                          } ?>>Local Laden
                              <option value="EI" id="EI" <?php if ($s->stuffing == 'EI') {
                                                            echo 'selected';
                                                          } ?>>Empty Import
                              <option value="LO" id="LO" <?php if ($s->stuffing == 'LO') {
                                                            echo 'selected';
                                                          } ?>>Loose Cargo
                            </select></td>
                          <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" name="container_name_lc[]" value="<?php echo $s->container_type; ?>" readonly><input type="hidden" class="form-control input-sm" name="container_id_lc[]" value="<?php echo $s->container_id; ?>"></td>
                          <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" name="container_number_lc[]" value="<?php echo $s->container_number; ?>" required></td>
                          <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" name="supplier_lc[]" value="<?php echo $s->supplier; ?>" required></td>
                          <td nowrap onclick="event.stopPropagation();return false;" required>
                            <select class="form-control input-sm" name="customer_lc[]">
                              <option value="PSS" <?php if ($s->customer == 'PSS') {
                                                    echo 'selected';
                                                  } ?>>Pulau Sambu Singapore Pte Ltd</option>
                              <?php foreach ($supp as $r) { ?>
                                <option value="<?php echo $r->customer_code; ?>"><?php echo $r->customer_name; ?></option>
                              <?php } ?>
                            </select>
                          </td>
                          <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" name="reff_lc[]" value="<?php echo $s->reff_lc; ?>" required></td>
                          <td hidden><input type="text" class="form-control input-sm" name="id_lc[]" value="<?php echo $s->id; ?>" required></td>
                          <td hidden></td>
                          <td hidden></td>
                        </tr>
                      <?php
                        $no++;
                      }
                      ?>
                    </tbody>
                  </table>
                </div>
              </div>

              <hr>

              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="col-md-3 label-sm">Remark</label>
                    <div class="col-md-9">
                      <textarea rows="3" class="form-control autosizeme" name="remarks"><?php echo str_replace("<br />", "", $remarks); ?></textarea>
                    </div>
                  </div>
                </div>
              </div>

              <div class="form-actions">
                <div class="col-md-6">
                  <a type="button" class="col-md-2 btn btn-default" href="<?php echo site_url('shipping/container'); ?>">Add</a>
                  <button type="submit" class="col-md-2 btn btn-primary" id="btn-update">Update</button>
                </div>
                <div class="col-md-6">
                  <div class="col-md-5"></div>
                  <div>
                    <button type="button" class="col-md-2 col-md-push-1  btn btn-warning" onclick="fnDialogContainerAll()">Find</button>
                    <a class="col-md-2 col-md-push-1 btn green " id="btn-excel" onclick="excel()">Excel</a>
                    <a type="button" class="col-md-2 col-md-push-1 btn btn-info" href="<?php echo site_url('shipping/container_print?cont=' . $contid . '&tipe=' . $tipe); ?>" target="_blank">Print</a>
                  </div>
                </div>
              </div>
          </div>
          </form>
        </div>
      </div>


      <!-- Tambahan 19-07-2018 -->
      <div id="formdialogContMove" hidden>
        <div class='portlet-body'>
          <div class='col-md-12'>
            <div class='form-group'>
              <div id="isidisini">

              </div>
              <!-- <input type='hidden' id='id1' value='"+x+"'>
                                <input type='hidden' id='id2' value='"+y+"'>
                                 <div class='col-md-10' id='tesss'>
                                        <select class='form-control select2me' name='shipdate' id='shipdate'>
                                            <?php foreach ($getship2 as $get) : ?>
                                                  <option value='<?php echo $get->contid; ?>'><?php echo $get->shipmentdate; ?>
                                                   <?php echo $get->voyage; ?> 
                                                    <?php echo $get->barge; ?> / <?php echo $get->etd; ?> To <?php echo $get->eta; ?> </option>
                                            <?php endforeach; ?>
                                        </select>
                                 </div>
                                 <button type='button' class='col-md-2 btn blue' onclick='save_move(" + x + " , "+ y + ")'>Move</button> -->
            </div>
          </div>
          <div class='col-md-7'>
            <br>
            <button type='button' class='col-md-4 btn red' onclick='close_formdialogContMove()'>Close</button>
          </div>
        </div>
      </div>

      <div id="formdialogContainerAll" hidden>
        <div id="formdialogContEdit" hidden>
          <div class='portlet-body'>
            <div class='col-md-12'>
              <div class='form-group'>
                <div class='form-group'>
                  <label class='control-label col-md-2'>Factory</label>
                  <div class='col-md-10'>
                    <select class="form-control select2me" id='pete'>
                      <option value="">All Stock</option>
                      <option value="PSG">Pulau Sambu Guntung</option>
                      <option value="RSUP">Riau Sakti United Plantation</option>
                    </select>
                  </div>
                </div>
                <label class='col-md-2 label-sm'>Container</label>
                <div class='col-md-7'>
                  <input class='form-control input-sm' id='findCI'>
                </div>
                <button type='button' class='col-md-2 btn blue' onclick='filterContainerInward()'>Search</button>
              </div>
            </div>
            <br>
            <hr>
            <div class='table-scrollable' style='overflow: auto; height:300px;'>
              <table id='tbl-CI' class='table table-bordered'>
                <thead>
                  <tr>
                    <th width='10px'><input type='Radio' onchange='check(this)'></th>
                    <th>No</th>
                    <th>Container Number</th>
                    <th>Container Type</th>
                    <th>Factory</th>
                    <th>Loading Port</th>
                    <th>Free Time</th>
                    <th>Arrival Date</th>
                    <th>Remark</th>
                    <th hidden="">ID yang ditarik</th>
                    <!--<th>Exit Date</th>-->
                  </tr>
                </thead>
                <tbody id='tblCI'>
                  <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td hidden=""></td>
                  </tr>
                </tbody>
              </table>
            </div>
            <div class='col-md-6'>
              <button type='button' class='col-md-3 btn blue' onclick='choose_CI()' id='choose_CI'>Choose</button>
              <button type='button' class='col-md-3 btn grey' onclick='close_CI()'>Close</button>
            </div>
          </div>
        </div>

        <div id="formdialogCont" hidden=""></div>
        <div class='portlet-body'>
          <div class="col-md-12">
            <div class="form-group">
              <label class="col-md-2 label-sm">Shipment Date</label>
              <div class="col-md-4">
                <input class="form-control input-sm date date-picker" data-date="02-12-2012" data-date-format="dd-mm-yyyy" id="dt_shipment">
              </div>
            </div>
          </div>
          <div class='col-md-12'>
            <div class='form-group'>
              <label class='col-md-2 label-sm'>Find Order By</label>
              <div class='col-md-7'>
                <input class='form-control input-sm' id='dt_data'>
              </div>
              <button type='button' class='col-md-1 btn blue' onclick='filtercontainerall()'>Search</button>
            </div>
          </div>
          <br>
          <hr>
          <div class='table-scrollable' style='overflow: auto; height:490px;'>
            <table id='tbl-containerall' class='table table-bordered'>
              <thead>
                <tr>
                  <th>Action</th>
                  <th>Tipe</th>
                  <th>Shipment Date</th>
                  <th>Vessel (Barge)</th>
                  <th>Voyage</th>
                  <th>ETD</th>
                  <th>ETD Date</th>
                  <th>ETA</th>
                  <th>ETA Date</th>
                  <th>From</th>
                  <th>To</th>
                  <th>Created By</th>
                  <th>Created Date</th>
                  <th>LastUpdated By</th>
                  <th>LastUpdated Date</th>
                </tr>
              </thead>
              <tbody id='tblcontainerall'></tbody>
            </table>
          </div>
        </div>
      </div>
      <div id="formdialogPO"></div>
      <div id="modal_delete" class="modal fade bs-modal-lg" role="dialog" tabindex="-1" data-backdrop="static" data-keyboard="false" aria-hidden="true"></div>
    </div>
  </div>
</div>
</div>

<div id="formdialogPO_lc" hidden>
  <div class="portlet-body">
    <div class="col-md-12">
      <div class="form-group">
        <label class="col-md-3 label-sm">Container Type</label>
        <div class="col-md-9">
          <?php
          if (!empty($container_name)) {
          ?>
            <select id='ctr_id' class="form-control select2me">
              <?php
              foreach ($container_name as $r) {
              ?>
                <option value="<?= $r->container_id; ?>"><?= $r->container_name; ?></option>
              <?php
              }
              ?>
            </select>
          <?php
          }
          ?>
        </div>
      </div>
    </div>
    <div class="col-md-12">
      <div class="form-group">
        <label class="col-md-3 label-sm">Row Count</label>
        <div class="col-md-9">
          <input type="text" class="txt form-control" name="rowcount" id="rowcount" value="1">
        </div>
      </div>
    </div>
    <br><br><br><br>
    <hr>

    <div class="col-md-6">
      <button type="button" class="col-md-3 btn blue" onclick="choose_PO_lc()" id="choose">Choose</button>
      <button type="button" class="col-md-3 btn grey" onclick="close_PO_lc()">Close</button>
    </div>
  </div>
</div>

<div id="rename">
  <input type='hidden' id='hasilchange' value='0'>
</div>

<script>
  function choose_PO_lc() {
    $ctr_name = $('#ctr_id option:selected').text();
    $ctr_id = $('#ctr_id option:selected').val();
    $rowcount = $('#rowcount').val();

    console.log($ctr_name);
    console.log($ctr_id);
    console.log($rowcount);

    for ($i = 0; $i < $rowcount; $i++) {
      var $new_row = $('<tr onclick="deleterow_lc(this)">\n\
                                    <td align="center"><button class="btn btn-sm btn-danger" type="button" ><i class="fa fa-trash" ></i></button></td>\n\
                                        <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" name="urut[]" value="0"></td>\n\
                                        <td nowrap onclick="event.stopPropagation();return false;" style="width: 100px;"><select name="stuffing_lc[]" id="stuffing_lc"><option value="LE" id="LE" onclick="">Local Empty <option value="LL" id="LL">Local Laden <option value="EI" id="EI">Empty Import<option value="LO" id="LO">Loose Cargo</select></td>\n\
                                        <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" name="container_name_lc[]" value="' + $ctr_name + '" readonly><input type="hidden" class="form-control input-sm" name="container_id_lc[]" value="' + $ctr_id + '"></td>\n\
                                        <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" name="container_number_lc[]" value="" required></td>\n\
                                        <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" name="supplier_lc[]" value="" required></td>\n\
                                        <td nowrap onclick="event.stopPropagation();return false;" required>\n\
                                        <select class="form-control input-sm" name="customer_lc[]">\n\
                                            <option value="PSS">Pulau Sambu Singapore Pte Ltd</option>\n\
                                            <?php foreach ($supp as $r) { ?>\n\
                                            <option value="<?php echo $r->customer_code; ?>"><?php echo $r->customer_name; ?></option>\n\
                                        <?php } ?>\n\
                                        </select>\n\
                                        </td>\n\
                                        <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" name="reff_lc[]" value="" required></td>\n\
                                        <td hidden><input type="text" class="form-control input-sm" name="id_lc[]" value="0" required></td>\n\
                                        <td hidden></td>\n\
                                        <td hidden></td>\n\
                                </tr>');

      $('table[id="tblList_lc"]').append($new_row);
    }

    $("#formdialogPO_lc").dialog("close");
  }

  function close_PO_lc() {
    $("#formdialogPO_lc").dialog("close");
  }

  function deleterow_lc(x) {
    $r = x.rowIndex;

    if (confirm("Are you sure remove this row?") == true) {
      document.getElementById("tblList_lc").deleteRow($r);
      cekDtl();
    }
  }

  function fnDialogPO_lc() {
    // Define the Dialog and its properties.
    $("#formdialogPO_lc").dialog({
      resizable: false,
      modal: true,
      title: "List Container",
      height: 250,
      width: 800

    });
    // filterContainerLocal();
  }

  function fnDialogPO() {
    $("#formdialogPO").html(" <div class='portlet-body'>\n\
                        <div class='col-md-12'>\n\
                            <div class='form-group'>\n\
                                 <label class='col-md-1 label-sm'>Find</label>\n\
                                 <div class='col-md-7'>\n\
                                        <input class='form-control input-sm' id='findpo'>\n\
                                 </div>\n\
                                 <button type='button' class='col-md-2 btn blue' onclick='filterpo()'>Search</button>\n\
                            </div>\n\
                        </div>\n\
                        <br><hr>\n\
                        <div class='table-scrollable' style='overflow: auto; height:300px;'>\n\
                            <table id='tbl-po' class='table table-bordered'>\n\
                                <thead>\n\
                                    <tr>\n\
                                        <th width='10px'><input type='checkbox' onchange='check(this)'></th>\n\
                                        <th>PO Number</th>\n\
                                        <th>Shipper/Carrier</th>\n\
                                        <th>FCL</th>\n\
                                        <th>Final Destination</th>\n\
                                        <th>Booking</th>\n\
                                        <th>Vessel</th>\n\
                                        <th>Connecting Vessel</th>\n\
                                        <th>Depot</th>\n\
                                        <th>POD</th>\n\
                                        <th>OP Code</th>\n\
                                        <th>ETD Sin</th>\n\
                                        <th>ETA Sin</th>\n\
                                    </tr>\n\
                                </thead>\n\
                                <tbody id='tblpo'>\n\
                                    <tr>\n\
                                        <td></td>\n\
                                        <td></td>\n\
                                        <td></td>\n\
                                        <td></td>\n\
                                        <td></td>\n\
                                        <td></td>\n\
                                        <td></td>\n\
                                        <td></td>\n\
                                        <td></td>\n\
                                        <td></td>\n\
                                        <td></td>\n\
                                        <td></td>\n\
                                        <td></td>\n\
                                    </tr>\n\
                                </tbody>\n\
                            </table>\n\
                        </div>\n\
                        <div class='col-md-6'>\n\
                            <button type='button' class='col-md-3 btn blue' onclick='choose_PO()' id='choose'>Choose</button>\n\
                            <button type='button' class='col-md-3 btn grey' onclick='close_PO()'>Close</button>\n\
                        </div>\n\
                </div>");

    // Define the Dialog and its properties.
    $("#formdialogPO").dialog({
      resizable: false,
      modal: true,
      title: "List PO",
      height: 500,
      width: 800

    });
  }

  function fnDialogContainerAll() {

    // Define the Dialog and its properties.
    $("#formdialogContainerAll").dialog({
      resizable: false,
      modal: true,
      title: "List Container",
      height: 650,
      width: 1200

    });
  }
</script>
<script>
  //    checkAll
  function check(ele) {
    var checkboxes = document.getElementsByTagName('input');
    if (ele.checked) {
      for (var i = 0; i < checkboxes.length; i++) {
        if (checkboxes[i].type == 'checkbox') {
          checkboxes[i].checked = true;
        }
      }
    } else {
      for (var i = 0; i < checkboxes.length; i++) {
        console.log(i)
        if (checkboxes[i].type == 'checkbox') {
          checkboxes[i].checked = false;
        }
      }
    }
  }

  function choose_PO() {
    function getText(el) {
      if (typeof el.textContent == 'string') return el.textContent;
      if (typeof el.innerText == 'string') return el.innerText;
    }

    var chk_arr = document.getElementsByName("chk[]");

    var chk_length = chk_arr.length;
    i = 1;

    for (k = 0; k < chk_length; k++) {
      if (chk_arr[k].checked == true) {
        var $new_row = $('<tr onclick="deleterow1(this)">\n\
                                    <td><button class="btn btn-sm btn-danger" type="button" ><i class="fa fa-trash" ></i></button></td>\n\
                                        <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 50px;" name="urut[]" value="0"></td>\n\
                                        <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 110px;" name="po[]" value="' + getText(document.getElementById("tbl-po").rows[i].cells[1]) + '" disabled></td>\n\
                                        <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 110px;" name="carrier[]" value="' + getText(document.getElementById("tbl-po").rows[i].cells[2]) + '"></td>\n\
                                        <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 110px;" name="fcl[]" value="' + getText(document.getElementById("tbl-po").rows[i].cells[3]) + '" disabled></td>\n\
                                        <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 150px;" name="final[]" value="' + getText(document.getElementById("tbl-po").rows[i].cells[4]) + '" ></td>\n\
                                        <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 150px;" name="reff[]" value="' + getText(document.getElementById("tbl-po").rows[i].cells[5]) + '"></td>\n\
                                        <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 150px;" name="vessel[]" value="' + getText(document.getElementById("tbl-po").rows[i].cells[6]) + '"></td>\n\
                                        <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 150px;" name="convessel[]" value="' + getText(document.getElementById("tbl-po").rows[i].cells[7]) + '"></td>\n\
                                        <td nowrap onclick="event.stopPropagation();return false;"><select name="stuffing[]" id="stuffing"><option value="EE" id="EE" onclick="">Export Empty <option value="EL" id="EL">Export Laden <option value="IL" id="IL">Import Laden <option value="IT" id="IT">Import Transhipment <option value="LC" id="LC">Local container <option value="RE" id="RE">Recall container <option value="EE_TP" id="EE_TP">Export Empty</select></td>\n\
                                        <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 80px;" name="depot[]" value="' + getText(document.getElementById("tbl-po").rows[i].cells[8]) + '"></td>\n\
                                        <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 80px;" name="pod[]" value="' + getText(document.getElementById("tbl-po").rows[i].cells[9]) + '"></td>\n\
                                        <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 80px;" name="opcode[]" value="' + getText(document.getElementById("tbl-po").rows[i].cells[10]) + '"></td>\n\
                                        <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 100px;" name="etdsin[]" value="' + getText(document.getElementById("tbl-po").rows[i].cells[11]) + '" ></td>\n\
                                        <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 150px;" name="container[]" value=""></td>\n\
                                        <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 100px;" name="seal[]" value=""></td>\n\
                                        <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 100px;" name="actual_seal[]" value=""></td>\n\
                                        <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm text-right" style="width: 80px;" name="weight[]" value="0" onkeypress="return isNumber(event)"></td>\n\
                                        <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 100px;" name="etasin[]" value="' + getText(document.getElementById("tbl-po").rows[i].cells[12]) + '" ></td>\n\
                                        <td hidden><input type="text" class="form-control input-sm" name="shipid[]" value="' + getText(document.getElementById("tbl-po").rows[i].cells[13]) + '"></td>\n\
                                        <td hidden><input type="text" class="form-control input-sm" name="outward[]" value="' + getText(document.getElementById("tbl-po").rows[i].cells[14]) + '"></td>\n\
                                        <td hidden><input type="text" class="form-control input-sm" name="id[]" value="0"></td>\n\
                                </tr>');

        //                $new_row.find('.date').datepicker();

        $('table[id="tblList"]').append($new_row);
      }
      i++;
    }

    $("#formdialogPO").dialog("close");
    cekDtl();
  }

  function close_PO() {
    $("#formdialogPO").dialog("close");
  }

  function close_CI() {
    $("#formdialogContEdit").dialog("close");
  }

  function deleterow(x, y) {
    $r = x.rowIndex;

    if (confirm("Are you sure remove this row?") == true) {
      document.getElementById("tblList_1").deleteRow($r);

      $.ajax({
        url: "<?php echo base_url(); ?>shipping/container_shippping_delete?stock=" + x + "&tos=" + y,
        success: function(response) {
          location.reload();
        },
        dataType: "html"
      });
      cekDtl();
    }
  }

  function deleterow_lc_db(x) {

    if (confirm("Are you sure remove this row?") == true) {

      $.ajax({
        url: "<?php echo base_url(); ?>shipping/container_local_delete?id=" + x,
        success: function(response) {
          location.reload();
        },
        dataType: "html"
      });

      cekDtl();
    }
  }

  function deleterow1(x) {
    $r = x.rowIndex;

    if (confirm("Are you sure remove this row?") == true) {
      document.getElementById("tblList").deleteRow($r);
      cekDtl();
    }
  }

  function close_formdialogContMove() {
    $("#formdialogContMove").dialog("close");
  }

  function filtercontainerall() {
    $dt_shipment = document.getElementById("dt_shipment").value;
    $dt_data = document.getElementById("dt_data").value;

    $.ajax({
      url: "<?php echo base_url(); ?>shipping/container_containerall?dt=" + $dt_shipment + "&call=" + $dt_data + "",
      success: function(response) {
        $("#tblcontainerall").html(response);
      },
      dataType: "html"
    });

    return false;
  }

  function filterpo() {
    filterpodtl();

  }

  function filterpodtl() {
    $findpo = document.getElementById("findpo").value;

    $.ajax({
      url: "<?php echo base_url(); ?>shipping/container_po_outward?po_cout=" + $findpo + "",
      success: function(response) {
        $("#tblpo").html(response);
      },
      dataType: "html"
    });

    return false;
  }

  function modal_delete(data) {

    $.ajax({
      url: "<?php echo base_url(); ?>shipping/container_modal_delete?delete=" + data + "",
      success: function(response) {
        $("#modal_delete").html(response);
      },
      dataType: "html"
    });

    return false;
  }


  function cekDtl() {
    var ID_arr = document.getElementsByName("shipid[]");
    var ID_length = ID_arr.length;

    if ((ID_length > 0)) {
      $('#btn-update').attr('disabled', false);
    } else {
      $('#btn-update').attr('disabled', true);
    }
  }

  function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode === 8 || charCode === 9 || charCode === 37 || charCode === 39 || charCode === 46 || (charCode > 47 && charCode < 58)) {
      return true;
    }
    return false;
  }

  function hidecoloumn(tipe) {
    var rows = document.getElementById('tblList').rows;
    for (var row = 0; row < rows.length; row++) {
      var cols = rows[row].cells;
      cols[10].style.display = tipe ? 'none' : '';
      cols[11].style.display = tipe ? 'none' : '';
    }
  }

  function excel() {
    $contid = document.getElementById("contid").value;

    javascript: location.href = "<?php echo base_url(); ?>shipping/container_inward_excel?cont=" + $contid + "";
  }

  function excel_template() {
    $contid = document.getElementById("contid").value;

    javascript: location.href = "<?php echo base_url(); ?>shipping/container_template_excel?cont=" + $contid + "";
  }

  function amendment() {
    $amendmentdate = document.getElementById('amendmentdate').value;

    if ($amendmentdate.trim() != '') {
      $('#btn-update').attr('disabled', false);
    } else {
      $('#btn-update').attr('disabled', true);
    }
  }

  function close_formdialogCont() {
    $("#formdialogCont").dialog("close");
  }


  //-------------Fungsi Edit Container pada Container Inward

  function run_disable() {
    $ck1 = document.getElementById('cekbox').checked;
    $ck2 = document.getElementById('cekboxx').checked;
    var cb = document.getElementById("cb");
    var ca = document.getElementById("ca");

    if ($ck2 == true) {
      ca.disabled = true;
      cb.disabled = false;
    } else {
      ca.disabled = false;
      cb.disabled = true;
    }
  }


  function run_disable_buttom() {
    $ck1 = document.getElementById('cekbox').checked;
    $ck2 = document.getElementById('cekboxx').checked;
    var cb = document.getElementById("cb");
    var ca = document.getElementById("ca");
    var cc = document.getElementById("cc");
    var cd = document.getElementById("cd");

    if ($ck2 == true) {
      ca.disabled = true;
      cb.disabled = false;
      cd.disabled = false;
      cc.disabled = true;
    } else {
      ca.disabled = false;
      cb.disabled = true;
      cc.disabled = false;
      cd.disabled = true;

    }
  }

  function fnDialogContainerChange(x, y) {
    $("#formdialogCont").html(" <div class='portlet-body'>\n\
                        <div class='col-md-12'>\n\
                            <div class='form-group'>\n\
                                <input class='col-md-1 label-sm' type='Radio' name='axx' id='cekbox' onclick='run_disable_buttom()' checked/>\n\
                                 <label class='col-md-4 label-sm'>Edit Container</label>\n\
                                 <div class='col-md-10'>\n\
                                        <input class='form-control input-sm' name='ca' id='ca' value='" + y + "'>\n\
                                 </div>\n\
                                 <button type='button' class='col-md-2 btn blue' onclick='save_change(" + x + ")' id='cc' name='cc'>Save</button>\n\
                            </div>\n\
                        </div>\n\
                        <div class='col-md-12'>\n\
                            <div class='form-group'>\n\
                                <input class='col-md-1 label-sm' type='Radio' name='axx' id='cekboxx' onclick='run_disable_buttom()'/>\n\
                                 <label class='col-md-4 label-sm'>Change Container</label>\n\
                                 <div class='col-md-10' id='tes'>\n\
                                        <input class='form-control input-sm' name='cb' id='cb' onclick='fnDialogContainerStock()' placeholder='Double Click For Choice Container' disabled readonly=''>\n\
                                        <input type='hidden' class='form-control input-sm' name='idstock' id='idstock' value=''>\n\
                                 </div>\n\
                                 <button type='button' class='col-md-2 btn blue' onclick='savechangestock(" + x + ")' id='cd' name='cd' disabled>Save</button>\n\
                            </div>\n\
                        </div>\n\
                        <div class='col-md-7'>\n\
                            <button type='button' class='col-md-6 btn grey' onclick='close_formdialogCont()'>Close</button>\n\
                        </div>\n\
                </div>");

    // Define the Dialog and its properties.
    $("#formdialogCont").dialog({
      resizable: false,
      modal: true,
      title: "Container Change and Edit",
      height: 260,
      width: 600

    });
  }


  function save_change(x) {
    var ca = $("#ca").val();
    var tipe = $("#tipe1").val();
    var countid = $("#contid").val();

    $url2 = "<?php echo base_url(); ?>shipping/container_inward_edit?container=" + ca + "&id=" + x + "&contid=" + countid + "&tipe=" + tipe;
    console.log($url2);

    $.ajax({
      url: "<?php echo base_url(); ?>shipping/container_inward_edit?container=" + ca + "&id=" + x + "&contid=" + countid + "&tipe=" + tipe,
      success: function(response) {
        $("#rename").html(response);
      },
      dataType: "html"
    });
    close_formdialogCont()
    return false;

  }

  function savechangestock(x) {
    $idstock = $("#idstock").val();
    var cb = $("#cb").val();
    var ca = $("#ca").val();
    var tipe = $("#tipe1").val();
    var countid = $("#contid").val();

    $url2 = "<?php echo base_url(); ?>shipping/container_inward_changestock?container=" + cb + "&id=" + x + "&idold=" + x + "&idnew=" + $idstock + "&contid=" + countid + "&tipe=" + tipe;
    console.log($url2);
    $id = '#ci-' + x;
    // $a = '-';

    $.ajax({
      // url: $url,
      url: "<?php echo base_url(); ?>shipping/container_inward_changestock?container=" + cb + "&id=" + x + "&idold=" + x + "&idnew=" + $idstock + "&contid=" + countid + "&tipe=" + tipe,
      success: function(response) {
        $("#rename").html(response);
      },
      dataType: "html"
    });
    // alert($a);
    close_formdialogCont()
    return false;
  }



  function get_change(x) {
    // alert(x);
    $a = '#ci-' + x;
    $change = $("#hasilchange").val();

    $($a).val($change);
  }

  function run_disable_buttom1() {
    $ck1 = document.getElementById('cekboxy').checked;
    $ck2 = document.getElementById('cekboxxy').checked;
    var cba = document.getElementById("cba");
    var caa = document.getElementById("caa");
    var cca = document.getElementById("cca");
    var cda = document.getElementById("cda");


    if ($ck2 == true) {
      caa.disabled = true;
      cba.disabled = false;
      cda.disabled = false;
      cca.disabled = true;
    } else {
      caa.disabled = false;
      cba.disabled = true;
      cca.disabled = false;
      cda.disabled = true;

    }
  }

  function filterContainerInward() {
    filterCI();

  }

  function filterCI() {
    $findCI = document.getElementById("findCI").value;
    $pete = document.getElementById("pete").value;


    $url2 = "<?php echo base_url(); ?>shipping/container_stock_choice?stock=" + $findCI + "&pete=" + $pete;
    console.log($url2);

    $.ajax({
      url: "<?php echo base_url(); ?>shipping/container_stock_choice?stock=" + $findCI + "&pete=" + $pete,
      success: function(response) {
        $("#tblCI").html(response);
      },
      dataType: "html"
    });

    return false;
  }

  function fnDialogContainerStock() {
    // Define the Dialog and its properties.
    $("#formdialogContEdit").dialog({
      resizable: false,
      modal: true,
      title: "List Container Stock",
      height: 550,
      width: 800

    });
  }

  //--------------ini form Choose Container

  function choose_CI() {
    function getText(ell) {
      if (typeof ell.textContent == 'string') return ell.textContent;
      if (typeof ell.innerText == 'string') return ell.innerText;
    }

    $stockid = '';
    $contname = '';

    var chk_arr = document.getElementsByName("chkk[]");

    var chk_length = chk_arr.length;
    i = 1;

    for (k = 0; k < chk_length; k++) {
      if (chk_arr[k].checked == true) {
        $stockid = getText(document.getElementById("tbl-CI").rows[i].cells[1]);
        $contname = getText(document.getElementById("tbl-CI").rows[i].cells[2]);


      }
      i++;
    }

    // alert($stockid);
    $('#idstock').val($stockid);
    $('#cb').val($contname);

    $("#formdialogContEdit").dialog("close");
    cekDtl1();
  }


  function cekDtl1() {
    var ID_arr = document.getElementsByName("shipid[]");
    var ID_length = ID_arr.length;

    if ((ID_length > 0)) {
      $('#btn-update').attr('disabled', false);
    } else {
      $('#btn-update').attr('disabled', true);
    }
  }

  //--------------------------------------Choose Container
  // UJUNG KALI

  function changerow(x, y, z) {
    $etd = $("#etd").val();
    // alert($etaa);

    $url = "<?php echo base_url(); ?>Shipping/get_shipmentdate?etd=" + $etd + "&id=" + x + "&flag=" + y + "&shipid=" + z;
    console.log($url);
    $.ajax({
      url: $url,
      success: function(results) {
        console.log(results);
        // $isi = "#isi-"+x;
        $("#isidisini").html(results);
        // hitung_total(x);
      },
      dataType: "html"
    });
    // alert($url);

    $("#formdialogContMove").dialog({
      resizable: false,
      modal: true,
      title: "Change and Move Shipment :",
      height: 180,
      width: 500

    });
  }


  function save_move() {
    $shipdate = $("#shipdate").val();
    $id = $("#id1").val();
    $flag = $("#id2").val();
    $etd = $("#etd").val();
    $shipid = $("#shipid").val();

    console.log($shipdate);
    console.log($id);
    console.log($flag);
    console.log($shipid);

    if (confirm("Are you sure move this Shipment?") == true) {
      $url2 = "<?php echo base_url(); ?>shipping/container_inward_move?shipdate=" + $shipdate + "&id=" + $id + "&flag=" + $flag + "&et=" + $etd + "&shipid=" + $shipid;
      // $url2 = "<?php echo base_url(); ?>shipping/container_inward_move?shipdate=" + shipdate + "&outward=" + y + "&inward=" + x;
      console.log($url2);

      $.ajax({
        url: $url2,
        success: function(response) {
          location.reload();
        },
        dataType: "html"
      });
    }
    close_formdialogContMove()
    return false;
  }

  function enable_update(y) {

    if (confirm("Are you sure you give access to changing data to marketing?") == true) {

      $.ajax({
        url: "<?php echo base_url(); ?>shipping/enable_update?shipid=" + y,
        success: function(response) {
          location.reload();
        },
        dataType: "html"
      });

      cekDtl();
    }
  }


  function disable_update(y) {

    if (confirm("Are you sure you closed access to change data to marketing?") == true) {

      $.ajax({
        url: "<?php echo base_url(); ?>shipping/disable_update?shipid=" + y,
        success: function(response) {
          location.reload();
        },
        dataType: "html"
      });

      cekDtl();
    }
  }
</script>