<?php
$proses = '0';
$allow_update = '0';

foreach ($cont as $r) {
  $contid      = $r->contid;
  $tipe        = $r->tipe;
  $shipment    = date("d-m-Y",  strtotime($r->shipmentdate));
  $barge       = $r->barge;
  $voyage      = $r->voyage;
  $etd         = $r->etd;
  $eta         = $r->eta;
  $etddateTemp = $r->etddate;
  $etadateTemp = $r->etadate;
  $stuffing    = $r->stuffing;
  $to          = $r->to;
  $from        = $r->from;
  $remarks     = $r->remarks;
  $factory_id  = $r->factory_id;

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

// ================================= GGFS ========================
$proses_ggfs = '0';
$allow_update_ggfs = '0';

foreach ($cont_ggfs as $g) {
  $contid_ggfs      = $g->contid;
  $tipe_ggfs        = $g->tipe;
  $shipment_ggfs    = date("d-m-Y",  strtotime($g->shipmentdate));
  $barge_ggfs       = $g->barge;
  $voyage_ggfs      = $g->voyage;
  $etd_ggfs         = $g->etd;
  $eta_ggfs         = $g->eta;
  $etddateTemp_ggfs = $g->etddate;
  $etadateTemp_ggfs = $g->etadate;
  $stuffing_ggfs    = $g->stuffing;
  $to_ggfs          = $g->to;
  $from_ggfs        = $g->from;
  $remarks_ggfs     = $g->remarks;
  $factory_id_ggfs  = $g->factory_id;

  if ($g->allow_update == '1') {
    $allow_update_ggfs = $g->allow_update;
  }

  if ($g->proses == '1') {
    $proses_ggfs = $g->proses;
  }

  if ($etddateTemp_ggfs != '0000-00-00') {
    $etddate_ggfs =  date("d-m-Y",  strtotime($etddateTemp_ggfs));
  } else {
    $etddate_ggfs = '';
  }

  if ($etadateTemp_ggfs != '0000-00-00') {
    $etadate_ggfs =  date("d-m-Y",  strtotime($etadateTemp_ggfs));
  } else {
    $etadate_ggfs = '';
  }

  $amendmenttemp_ggfs = $g->amendment;
  if ($amendmenttemp_ggfs != '0000-00-00') {
    $amendment_ggfs =  date("d-m-Y",  strtotime($amendmenttemp_ggfs));
  } else {
    $amendment_ggfs = '';
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

<div class="page-content">
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
              <span class="caption-subject theme-font bold">Container Outward</span>
            </div>
          </div>
          <div class="portlet-body form">
            <form action="<?php echo site_url('shipping/container_save/update'); ?>" method="post" class="form-horizontal" role="form">
              <div class="form-body">
                <div class="row mb-2">
                  <div class="col-md-6">
                    <div class="form-group" style="margin-bottom:1px;">
                      <label class="col-md-3 label-sm">Tipes</label>
                      <div class="col-md-3">
                        <select class="form-control select2me" name="tipe">
                          <option value="1">Container Outward</option>
                        </select>
                      </div>
                    </div>
                    <div class="form-group" style="margin-bottom:1px;">
                      <label class="col-md-3 label-sm">Shipment Date</label>
                      <div class="col-md-3">
                        <input class="form-control input-sm date date-picker" name="shipdate" data-date="02-12-2012" data-date-format="dd-mm-yyyy" value="<?= date("d-m-Y", strtotime($cont_header->shipmentdate)) ?>" required>
                        <input class="form-control input-sm" name="contid" id="contid" value="<?php echo $cont_header->contid; ?>" type="hidden">
                      </div>
                    </div>
                    <div class="form-group" style="margin-bottom:1px;">
                      <label class="col-md-3 label-sm">Vessel ( Barge)</label>
                      <div class="col-md-5">
                        <input class="form-control input-sm" name="barge" value="<?php echo $cont_header->barge; ?>">
                      </div>
                    </div>
                    <div class="form-group" style="margin-bottom:1px;">
                      <label class="col-md-3 label-sm">Voyage</label>
                      <div class="col-md-5">
                        <input class="form-control input-sm" name="voyage" value="<?php echo $cont_header->voyage; ?>">
                      </div>
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group" style="margin-bottom:1px;">
                      <label class="col-md-2 label-sm">ETD</label>
                      <div class="col-md-7">
                        <div class="input-group">
                          <input class="form-control input-sm" name="etd" value="<?php echo $cont_header->etd; ?>" readonly>
                          <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                          <input class="form-control input-sm date date-picker" placeholder="ETD Date" name="etddate" data-date="02-12-2012" data-date-format="dd-mm-yyyy" value="<?= date("d-m-Y", strtotime($cont_header->etddate)) ?>">
                        </div>
                      </div>
                    </div>
                    <div class="form-group" style="margin-bottom:1px;">
                      <label class="col-md-2 label-sm">ETA</label>
                      <div class="col-md-7">
                        <div class="input-group">
                          <select name="eta" class="form-control input-sm">
                            <option id="RSUP" value="RSUP" <?php if ($cont_header->eta === "RSUP") {
                                                              echo 'selected';
                                                            } ?>>Riau Sakti United Plantation </option>
                            <option id="PSG" value="PSG" <?php if ($cont_header->eta === "PSG") {
                                                            echo 'selected';
                                                          } ?>>Pulau Sambu Guntung</option>
                            <option id="PSKE" value="PSKE" <?php if ($cont_header->eta === "PSKE") {
                                                              echo 'selected';
                                                            } ?>>Pulau Sambu Kuala Enok</option>
                          </select>
                          <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                          <input class="form-control input-sm date date-picker" placeholder="ETA Date" name="etadate" data-date="02-12-2012" data-date-format="dd-mm-yyyy" value="<?= date("d-m-Y", strtotime($cont_header->etadate)) ?>">
                        </div>
                      </div>
                    </div>
                    <div class="form-group" style="margin-bottom:1px;">
                      <label class="col-md-2 label-sm">To</label>
                      <div class="col-md-7">
                        <input class="form-control input-sm" name="to" value="<?php echo $cont_header->to; ?>">
                      </div>
                    </div>
                    <div class="form-group" style="margin-bottom:1px;">
                      <label class="col-md-2 label-sm">From</label>
                      <div class="col-md-7">
                        <input class="form-control input-sm" name="from" value="<?php echo $cont_header->from; ?>">
                      </div>
                    </div>
                    <div class="form-group" style="margin-bottom:1px;<?php if ($proses == '0') {
                                                                        echo 'display: none';
                                                                      } ?>">
                      <label class="col-md-2 label-sm">Amendment</label>
                      <div class="col-md-4">
                        <input class="form-control input-sm date date-picker" name="amendmentdate" id="amendmentdate" data-date="02-12-2012" data-date-format="dd-mm-yyyy" value="<?php echo date("d-m-Y", strtotime($cont_header->amendment)); ?>" onchange="amendment()">
                      </div>
                    </div>
                  </div>
                </div>

                <div class="table-scrollable" style="overflow: auto; height: 550px;">
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
                        <th nowrap>ETA</th>
                      </tr>
                    </thead>
                    <tbody id="tblList_1">
                      <?php foreach ($cont as $r) { ?>
                        <tr>
                          <td>
                            <?php
                            if ($r->proses != 1) { ?>
                              <button class="btn btn-sm btn-danger" type="button" id="btn-delete" onclick="deleterow(<?= $r->detail_id; ?>,<?= $r->shipid; ?>,<?= $r->contid; ?>)"><i class="fa fa-trash"></i></button>
                            <?php } else { ?>
                              <nowrap onclick="event.stopPropagation();return false;">
                              <?php }
                              ?>
                              <?php
                              if ($r->allow_update != 1) { ?>
                                <button class="btn green" type="button" id="btn-enable" onclick="enable_update(<?= $r->shipid; ?>)"><i class="fa fa-cog"></i></button>
                              <?php } else { ?>
                                <button class="btn red" type="button" id="btn-disable" onclick="disable_update(<?= $r->shipid; ?>)"><i class="fa fa-power-off"></i></button>
                              <?php }
                              ?>
                          </td>
                          <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 50px;" name="urut[]" value="<?php echo $r->urut; ?>"></td>
                          <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 110px;" name="po[]" value="<?php echo $r->po_number; ?>" disabled></td>
                          <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 210px;" name="carrier[]" value="<?php echo $r->shipping_liner; ?>"></td>
                          <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 230px;" name="fcl[]" value="<?php echo $r->container_name; ?>" disabled></td>
                          <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 150px;" name="final[]" value="<?php echo $r->destination; ?>"></td>
                          <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 300;" name="reff[]" value="<?php echo $r->reff; ?>"><textarea class="form-control" name="reff_remark[]"><?php echo $r->reff_remark; ?></textarea></td>
                          <td nowrap onclick="event.stopPropagation();return false;">
                            <select class="form-control input-sm select2me" name="supplier[]">
                              <option value="<?= $r->supplier; ?>"><?= $r->supplier_name; ?></option>
                              <?php foreach ($ven as $x) { ?>
                                <option value="<?php echo $x->id_supp; ?>"><?php echo $x->name_supp; ?></option>
                              <?php } ?>
                            </select>
                          </td>
                          <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 150px;" name="vessel[]" value="<?php echo $r->vessel; ?>"></td>
                          <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 150px;" name="convessel[]" value="<?php echo $r->convessel; ?>"></td>
                          <td nowrap onclick="event.stopPropagation();return false;">
                            <select name="stuffing[]" class="form-control input-sm select2me">
                              <option id="EECN" value="EECN" <?php if ($r->stuffing === "EECN") {
                                                            echo 'selected';
                                                          } ?>>Export Empty (CN)
                              <option id="ELCN" value="ELCN" <?php if ($r->stuffing === "ELCN") {
                                                            echo 'selected';
                                                          } ?>>Export Laden (CN)
                              <option id="IL" value="IL" <?php if ($r->stuffing === "IL") {
                                                            echo 'selected';
                                                          } ?>>Import Laden
                              <option id="ITCN" value="ITCN" <?php if ($r->stuffing === "ITCN") {
                                                            echo 'selected';
                                                          } ?>>Import Transhipment (CN)
                              <option id="LC" value="LC" <?php if ($r->stuffing === "LC") {
                                                            echo 'selected';
                                                          } ?>>Local Container
                              <option id="RE" value="RE" <?php if ($r->stuffing === "RE") {
                                                            echo 'selected';
                                                          } ?>>Recall Container
                              <option id="IT" value="IT" <?php if ($r->stuffing === "IT") {
                                                            echo 'selected';
                                                          } ?>>Import Transhipment
                              <option id="EL" value="EL" <?php if ($r->stuffing === "EL") {
                                                            echo 'selected';
                                                          } ?>>Export Laden
                              <option id="EE" value="EE" <?php if ($r->stuffing === "EE") {
                                                            echo 'selected';
                                                          } ?>>Export Empty
                                <option id="ITDP" value="ITDP" <?php if ($r->stuffing === "ITDP") {
                                                            echo 'selected';
                                                          } ?>>Import Transhipment Direct Purchase
                              <option id="ITCNDP" value="ITCNDP" <?php if ($r->stuffing === "ITCNDP") {
                                                            echo 'selected';
                                                          } ?>>Import Transhipment Direct Purchase (CN)

                            </select>
                          </td>
                          <td nowrap onclick="event.stopPropagation();return false;">
                            <select class="form-control input-sm select2me" name="depot[]">
                              <option value="<?= $r->depot; ?>"><?= $r->depot_name; ?></option>
                              <?php foreach ($depot as $x) { ?>
                                <option value="<?php echo $x->depot_id; ?>"><?php echo $x->depot_name; ?></option>
                              <?php } ?>
                            </select>
                            <textarea class="form-control" name="depot_remark[]"><?php echo $r->depot_remark; ?></textarea>
                          </td>
                          <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 80px;" name="pod[]" value="<?php echo $r->pod; ?>"></td>
                          <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 80px;" name="opcode[]" value="<?php echo $r->opcode; ?>"></td>
                          <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 100px;" name="etdsin[]" value="<?php echo $r->etdsin; ?>"></td>
                          <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 100px;" name="etasin[]" value="<?php echo $r->etasin; ?>"></td>
                          <td hidden><input type="text" class="form-control input-sm" style="width: 150px;" name="container[]" value="<?php echo $r->container; ?>"></td>
                          <td hidden><input type="text" class="form-control input-sm" style="width: 100px;" name="seal[]" value="<?php echo $r->seal; ?>"></td>
                          <td hidden><input type="text" class="form-control input-sm" style="width: 100px;" name="actual_seal[]" value="<?php echo $r->actual_seal; ?>"></td>
                          <td hidden><input type="text" class="form-control input-sm" style="width: 100px;" name="total_gross_weight[]" value="0"></td>
                          <td hidden><input type="text" class="form-control input-sm" style="width: 100px;" name="tare_weight[]" value="0"></td>
                          <td hidden><input type="text" class="form-control input-sm" style="width: 100px;" name="trucking_date[]" value="0"><textarea class="form-control" name="trucking_date_remark[]"></textarea></td>
                          <td hidden><input type="text" class="form-control input-sm text-right" style="width: 80px;" name="weight[]" value="<?php echo $r->weight; ?>" onkeypress="return isNumber(event)"></td>
                          <td hidden><input type="text" class="form-control input-sm" name="shipid[]" value="<?php echo $r->shipid; ?>"></td>
                          <td hidden><input type="text" class="form-control input-sm" name="outward[]" value="0"></td>
                          <td hidden><input type="text" class="form-control input-sm" name="id[]" value="<?php echo $r->id; ?>"></td>
                        </tr>
                      <?php } ?>
                    </tbody>
                  </table>
                </div>

              <div class="portlet-title mt-2">
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
                      <th nowrap>Booking Ref</th>
                      <th nowrap>Needs Repair</th>
                    </tr>
                  </thead>
                  <tbody id="tblList_1_lc">

                    <?php
                    $no = 1;
                    foreach ($cont_local as $s) { ?>
                      <tr>
                        <td align="center"><button class="btn btn-sm btn-danger" type="button" onclick="deleterow_lc_db(<?= $s->id; ?>)"><i class="fa fa-trash"></i></button></td>
                        <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" name="urut_lc[]" value="<?php echo $no; ?>"></td>
                        <td nowrap onclick="event.stopPropagation();return false;" style="width: 100px;"><select name="stuffing_lc[]" id="stuffing_lc" class="form-control input-sm select2me">
                            <option value="LL" id="LL" <?php if ($s->stuffing == 'LL') {
                                                          echo 'selected';
                                                        } ?>>Local Laden
                            <option value="LE" id="LE" <?php if ($s->stuffing == 'LE') {
                                                          echo 'selected';
                                                        } ?>>Local Empty
                            <option value="LLTP" id="LLTP" <?php if ($s->stuffing == 'LLTP') {
                                                              echo 'selected';
                                                            } ?>>Local Laden (TP)
                            <option id="LETP" value="LETP" <?php if ($s->stuffing == "LETP") {
                                                              echo 'selected';
                                                            } ?>>Local Empty(TP)
                          </select>
                        </td>
                        <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" name="container_name_lc[]" value="<?php echo $s->container_type; ?>" readonly><input type="hidden" class="form-control input-sm" name="container_id_lc[]" value="<?php echo $s->container_id; ?>"></td>
                        <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" name="container_number_lc[]" value="<?php echo $s->container_number; ?>" required></td>
                        <td nowrap onclick="event.stopPropagation();return false;">
                          <select name="supplier_lc[]" class="form-control input-sm select2me">
                            <option value="<?= $s->supplier; ?>"><?= $s->supplier_name; ?></option>
                            <?php foreach ($ven as $x) { ?>
                              <option value="<?php echo $x->id_supp; ?>"><?php echo $x->name_supp; ?></option>
                            <?php } ?>
                          </select>
                        </td>
                        <td nowrap onclick="event.stopPropagation();return false;" required>
                          <select class="form-control input-sm select2me" name="customer_lc[]">
                            <option value="<?= $s->customer; ?>"><?= $s->customer_name; ?></option>
                            <?php foreach ($supp as $r) { ?>
                              <option value="<?php echo $r->customer_code; ?>"><?php echo $r->customer_name; ?></option>
                            <?php } ?>
                          </select>
                        </td>
                        <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" name="reff_lc[]" value="<?php echo $s->reff_lc; ?>" required></td>
                        <td>
                          <select class="form-control" name="is_repair[]" data-placeholder="Please Select">
                            <option value="0" <?= $s->is_repair == 0 ? "selected" : "" ?>>Please Select</option>
                            <option value="1" <?= $s->is_repair == 1 ? "selected" : "" ?>>Need Repair</option>
                          </select>
                          <!-- <input type="checkbox" class="form-control" name="is_repair[]" value="1"></td> -->
                          <!-- <td><input type="checkbox" class="form-control" name="is_repair[]"></td> -->
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
              <!-- ==================================== GGFS ==================================== -->
              <div class="portlet-title mt-5">
                  <div class="caption">
                    <i class="fa fa-ship theme-font"></i>
                    <span class="caption-subject theme-font bold">GGFS Container</span>
                  </div>
                </div>
                <div class="table-scrollable" style="overflow: auto; height: 550px;">
                  <table class="table table-bordered" id="tblList_ggfs">
                    <thead>
                      <tr>
                        <th width="10px"><button class="btn btn-sm btn-primary" type="button" id="btn-po" onclick="fnDialogPO_ggfs()"><i class="fa fa-arrow-down"></i></button></th>
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
                        <th nowrap>ETA</th>
                      </tr>
                    </thead>
                    <tbody id="tblList_1_ggfs">
                      <?php foreach ($cont_ggfs as $ggfs) { ?>
                        <tr>
                          <td>
                            <?php
                            if ($ggfs->proses != 1) { ?>
                              <button class="btn btn-sm btn-danger" type="button" id="btn-delete" onclick="deleterow_ggfs(<?= $ggfs->detail_id; ?>,<?= $ggfs->shipid; ?>,<?= $ggfs->contid; ?>)"><i class="fa fa-trash"></i></button>
                            <?php } else { ?>
                              <nowrap onclick="event.stopPropagation();return false;">
                              <?php }
                              ?>
                              <?php
                              if ($ggfs->allow_update != 1) { ?>
                                <button class="btn green" type="button" id="btn-enable" onclick="enable_update_ggfs(<?= $ggfs->shipid; ?>)"><i class="fa fa-cog"></i></button>
                              <?php } else { ?>
                                <button class="btn red" type="button" id="btn-disable" onclick="disable_update_ggfs(<?= $ggfs->shipid; ?>)"><i class="fa fa-power-off"></i></button>
                              <?php }
                              ?>
                          </td>
                          <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 50px;" name="urut_ggfs[]" value="<?php echo $ggfs->urut; ?>"></td>
                          <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 110px;" name="po_ggfs[]" value="<?php echo $ggfs->po_number; ?>" disabled></td>
                          <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 210px;" name="carrier_ggfs[]" value="<?php echo $ggfs->shipping_liner; ?>"></td>
                          <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 230px;" name="fcl_ggfs[]" value="<?php echo $ggfs->container_name; ?>" disabled></td>
                          <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 150px;" name="final_ggfs[]" value="<?php echo $ggfs->destination; ?>"></td>
                          <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 300;" name="reff_ggfs[]" value="<?php echo $ggfs->reff; ?>"><textarea class="form-control" name="reff_remark_ggfs[]"><?php echo $ggfs->reff_remark; ?></textarea></td>
                          <td nowrap onclick="event.stopPropagation();return false;">
                            <select class="form-control input-sm select2me" name="supplier_ggfs[]">
                              <option value="<?= $ggfs->supplier; ?>"><?= $ggfs->supplier_name; ?></option>
                              <?php foreach ($ven as $x) { ?>
                                <option value="<?php echo $x->id_supp; ?>"><?php echo $x->name_supp; ?></option>
                              <?php } ?>
                            </select>
                          </td>
                          <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 150px;" name="vessel_ggfs[]" value="<?php echo $ggfs->vessel; ?>"></td>
                          <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 150px;" name="convessel_ggfs[]" value="<?php echo $ggfs->convessel; ?>"></td>
                          <td nowrap onclick="event.stopPropagation();return false;">
                            <select name="stuffing_ggfs[]" class="form-control input-sm select2me">
                              <option id="EECN" value="EECN" <?php if ($ggfs->stuffing === "EECN") {
                                                            echo 'selected';
                                                          } ?>>Export Empty (CN)
                              <option id="ELCN" value="ELCN" <?php if ($ggfs->stuffing === "ELCN") {
                                                            echo 'selected';
                                                          } ?>>Export Laden (CN)
                              <option id="IL" value="IL" <?php if ($ggfs->stuffing === "IL") {
                                                            echo 'selected';
                                                          } ?>>Import Laden
                              <option id="ITCN" value="ITCN" <?php if ($ggfs->stuffing === "ITCN") {
                                                            echo 'selected';
                                                          } ?>>Import Transhipment (CN)
                              <option id="LC" value="LC" <?php if ($ggfs->stuffing === "LC") {
                                                            echo 'selected';
                                                          } ?>>Local Container
                              <option id="RE" value="RE" <?php if ($ggfs->stuffing === "RE") {
                                                            echo 'selected';
                                                          } ?>>Recall Container
                              <option id="IT" value="IT" <?php if ($ggfs->stuffing === "IT") {
                                                            echo 'selected';
                                                          } ?>>Import Transhipment
                              <option id="EL" value="EL" <?php if ($ggfs->stuffing === "EL") {
                                                            echo 'selected';
                                                          } ?>>Export Laden
                              <option id="EE" value="EE" <?php if ($ggfs->stuffing === "EE") {
                                                            echo 'selected';
                                                          } ?>>Export Empty
                                <option id="ITDP" value="ITDP" <?php if ($ggfs->stuffing === "ITDP") {
                                                            echo 'selected';
                                                          } ?>>Import Transhipment Direct Purchase
                              <option id="ITCNDP" value="ITCNDP" <?php if ($ggfs->stuffing === "ITCNDP") {
                                                            echo 'selected';
                                                          } ?>>Import Transhipment Direct Purchase (CN)

                            </select>
                          </td>
                          <td nowrap onclick="event.stopPropagation();return false;">
                            <select class="form-control input-sm select2me" name="depot_ggfs[]">
                              <option value="<?= $ggfs->depot; ?>"><?= $ggfs->depot_name; ?></option>
                              <?php foreach ($depot as $x) { ?>
                                <option value="<?php echo $x->depot_id; ?>"><?php echo $x->depot_name; ?></option>
                              <?php } ?>
                            </select>
                            <textarea class="form-control" name="depot_remark_ggfs[]"><?php echo $ggfs->depot_remark; ?></textarea>
                          </td>
                          <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 80px;" name="pod_ggfs[]" value="<?php echo $ggfs->pod; ?>"></td>
                          <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 80px;" name="opcode_ggfs[]" value="<?php echo $ggfs->opcode; ?>"></td>
                          <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 100px;" name="etdsin_ggfs[]" value="<?php echo $ggfs->etdsin; ?>"></td>
                          <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 100px;" name="etasin_ggfs[]" value="<?php echo $ggfs->etasin; ?>"></td>
                          <td hidden><input type="text" class="form-control input-sm" style="width: 150px;" name="container_ggfs[]" value="<?php echo $ggfs->container; ?>"></td>
                          <td hidden><input type="text" class="form-control input-sm" style="width: 100px;" name="seal_ggfs[]" value="<?php echo $ggfs->seal; ?>"></td>
                          <td hidden><input type="text" class="form-control input-sm" style="width: 100px;" name="actual_seal_ggfs[]" value="<?php echo $ggfs->actual_seal; ?>"></td>
                          <td hidden><input type="text" class="form-control input-sm" style="width: 100px;" name="total_gross_weight_ggfs[]" value="0"></td>
                          <td hidden><input type="text" class="form-control input-sm" style="width: 100px;" name="tare_weight_ggfs[]" value="0"></td>
                          <td hidden><input type="text" class="form-control input-sm" style="width: 100px;" name="trucking_date_ggfs[]" value="0"><textarea class="form-control" name="trucking_date_remark_ggfs[]"></textarea></td>
                          <td hidden><input type="text" class="form-control input-sm text-right" style="width: 80px;" name="weight_ggfs[]" value="<?php echo $ggfs->weight; ?>" onkeypress="return isNumber(event)"></td>
                          <td hidden><input type="text" class="form-control input-sm" name="shipid_ggfs[]" value="<?php echo $ggfs->shipid; ?>"></td>
                          <td hidden><input type="text" class="form-control input-sm" name="outward_ggfs[]" value="0"></td>
                          <td hidden><input type="text" class="form-control input-sm" name="id_ggfs[]" value="<?php echo $ggfs->id; ?>"></td>
                        </tr>
                      <?php } ?>
                    </tbody>
                  </table>
                </div>
              </div>
          </div>

          <hr>

          <div class="row">
            <div class="col-md-12">
              <div class="row">
                <div class="form-group">
                  <label class="col-md-1 label-sm">Remark</label>
                  <div class="col-md-4">
                    <textarea rows="3" class="form-control autosizeme" name="remarks"><?php echo str_replace("<br />", "", $cont_header->remarks); ?></textarea>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-md-6 mt-5">
              <a type="button" class="col-md-2 btn btn-default" href="<?php echo site_url('shipping/container'); ?>">Add</a>
              <button type="submit" class="col-md-2 btn btn-primary" id="btn-update">Update</button>
            </div>
            <div class="col-md-6 mt-5">
              <div class="row">
                <div class="col-md-4">
                  <button type="button" class="btn btn-warning btn-block" onclick="fnDialogContainerAll()">Find</button>
                </div>
                <div class="col-md-4">
                  <a class="btn green btn-block" id="btn-excel" onclick="excel()">Excel</a>
                </div>
                <div class="col-md-4">
                  <a type="button" class="btn btn-info btn-block" href="<?php echo site_url('shipping/container_print?cont=' . $contid . '&tipe=' . $tipe); ?>" target="_blank">Print</a>
                </div>
              </div>
            </div>
          </div>
        </div>


      </div>
      </form>
    </div>
  </div>
  <div id="formdialogContainerAll" hidden>
    <div class='portlet-body'>
      <div class="col-md-12">
        <div class="form-group">
          <label class="col-md-2 label-sm">Shipment Date</label>
          <div class="col-md-4">
            <input class="form-control input-sm date date-picker" data-date="02-12-2012" data-date-format="dd-mm-yyyy" id="dt_shipment">
          </div>
        </div>
      </div>
      <div class='col-md-12 mb-2  '>
        <div class='form-group'>
          <label class='col-md-2 label-sm'>Find Order By</label>
          <div class='col-md-7'>
            <input class='form-control input-sm' id='dt_data'>
          </div>
          <button type='button' class='col-md-1 btn blue' onclick='filtercontainerall()'>Search</button>
        </div>
      </div>

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
  <div id="formdialogPO" hidden>
    <div class="portlet-body">
      <div class="col-md-12">
        <div class="form-group">
          <label class="col-md-2 label-sm">Factory</label>
          <div class="col-md-4">
            <select class="form-control select2me" data-placeholder="Factory" id="factory">
              <option value=""></option>
              <?php
              foreach ($factory as $r) {
                echo '<option value="' . $r->factory_id . '">' . $r->factory_name . '</option>';
              }
              ?>
            </select>
          </div>
          <button type="button" class="col-md-2 btn blue" onclick="filterpo()">Search</button>
        </div>
      </div>
      <div class="col-md-12">
        <div class="form-group">
          <label class="col-md-2 label-sm">Schedule Date</label>
          <div class="col-md-4">
            <input class="form-control input-sm date date-picker" data-date="02-12-2012" data-date-format="dd-mm-yyyy" id="schedule">
          </div>
        </div>
      </div>
      <div class="col-md-12">
        <div class="form-group">
          <label class="col-md-2 label-sm">PO / Carrier</label>
          <div class="col-md-7">
            <input class="form-control input-sm" id="po">
          </div>
        </div>
      </div>
      <br>
      <hr>
      <div class="table-scrollable" style="overflow: auto; height:300px;">
        <table id="tbl-po" class="table table-bordered">
          <thead>
            <tr>
              <th width="5px"><input type="checkbox" onchange="check(this)"></th>
              <th>Schedule Date</th>
              <th>PO Number</th>
              <th>Factory</th>
              <th>Shipper/Carrier</th>
              <th>FCL</th>
              <th>Final Destination</th>
            </tr>
          </thead>
          <tbody id="tblpo">
            <tr>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="col-md-6">
        <button type="button" class="col-md-3 btn blue" onclick="choose_PO()" id="choose">Choose</button>
        <button type="button" class="col-md-3 btn grey" onclick="close_PO()">Close</button>
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

  <!-- ggfs -->
  <div id="formdialogPO_ggfs" hidden>
    <div class="portlet-body">
      <div class="col-md-12">
        <div class="form-group">
          <label class="col-md-2 label-sm">Factory</label>
          <div class="col-md-4">
            <select class="form-control select2me" data-placeholder="Factory" id="factory_ggfs">
              <option value=""></option>
              <?php
              foreach ($factory as $r) {
                echo '<option value="' . $r->factory_id . '">' . $r->factory_name . '</option>';
              }
              ?>
            </select>
          </div>
          <button type="button" class="col-md-2 btn blue" onclick="filterpo_ggfs()">Search</button>
        </div>
      </div>
      <div class="col-md-12">
        <div class="form-group">
          <label class="col-md-2 label-sm">Schedule Date</label>
          <div class="col-md-4">
            <input class="form-control input-sm date date-picker" data-date="02-12-2012" data-date-format="dd-mm-yyyy" id="schedule_ggfs">
          </div>
        </div>
      </div>
      <div class="col-md-12">
        <div class="form-group">
          <label class="col-md-2 label-sm">PO / Carrier</label>
          <div class="col-md-7">
            <input class="form-control input-sm" id="po_ggfs">
          </div>
        </div>
      </div>
      <br>
      <hr>
      <div class="table-scrollable" style="overflow: auto; height:300px;">
        <table id="tbl-po_ggfs" class="table table-bordered">
          <thead>
            <tr>
              <th width="5px"><input type="checkbox" onchange="check(this)"></th>
              <th>Schedule Date</th>
              <th>PO Number</th>
              <th>Factory</th>
              <th>Shipper/Carrier</th>
              <th>FCL</th>
              <th>Final Destination</th>
            </tr>
          </thead>
          <tbody id="tblpo_ggfs">
            <tr>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="col-md-6">
        <button type="button" class="col-md-3 btn blue" onclick="choose_PO_ggfs()" id="choose">Choose</button>
        <button type="button" class="col-md-3 btn grey" onclick="close_PO_ggfs()">Close</button>
      </div>
    </div>
  </div>

  <div id="modal_delete" class="modal fade bs-modal-lg" role="dialog" tabindex="-1" data-backdrop="static" data-keyboard="false" aria-hidden="true"></div>
</div>
</div>
</div>
</div>

<script>
  function fnDialogPO() {

    // Define the Dialog and its properties.
    $("#formdialogPO").dialog({
      resizable: false,
      modal: true,
      title: "List PO",
      height: 570,
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
  function choose_PO_lc() {
    $ctr_name = $('#ctr_id option:selected').text();
    $ctr_id = $('#ctr_id option:selected').val();
    $rowcount = $('#rowcount').val();

    for ($i = 0; $i < $rowcount; $i++) {
      var $new_row = $('<tr onclick="deleterow_lc(this)">\n\
                                    <td align="center"><button class="btn btn-sm btn-danger" type="button" ><i class="fa fa-trash" ></i></button></td>\n\
                                        <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" name="urut_lc[]" value="0"></td>\n\
                                        <td nowrap onclick="event.stopPropagation();return false;" style="width: 100px;"><select name="stuffing_lc[]" id="stuffing_lc"><option value="LL" id="LL">Local Laden<option value="LE" id="LE">Local Empty<option value="LLTP" id="LLTP">Local Laden (TP)</select></td>\n\
                                        <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" name="container_name_lc[]" value="' + $ctr_name + '" readonly><input type="hidden" class="form-control input-sm" name="container_id_lc[]" value="' + $ctr_id + '"></td>\n\
                                        <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" name="container_number_lc[]" value="" required></td>\n\
                                        <td nowrap onclick="event.stopPropagation();return false;">\n\
                                        <select class="form-control input-sm" name="supplier_lc[]">\n\
                                            <option value=""></option>\n\
                                            <?php foreach ($ven as $r) { ?>\n\
                                            <option value="<?php echo $r->id_supp; ?>"><?php echo $r->name_supp; ?></option>\n\
                                        <?php } ?>\n\
                                        </select>\n\
                                        </td>\n\
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
                                        <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 110px;" name="po[]" value="' + getText(document.getElementById("tbl-po").rows[i].cells[2]) + '" disabled></td>\n\
                                        <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 200px;" name="carrier[]" value="' + getText(document.getElementById("tbl-po").rows[i].cells[4]) + '"></td>\n\
                                        <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 110px;" name="fcl[]" value="' + getText(document.getElementById("tbl-po").rows[i].cells[5]) + '" disabled></td>\n\
                                        <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 250px;" name="final[]" value="' + getText(document.getElementById("tbl-po").rows[i].cells[6]) + '"></td>\n\
                                        <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 150px;" name="reff[]" value=""><textarea class="form-control" name="reff_remark[]" value="" placeholder="Remarks..."></textarea></td>\n\
                                        <td nowrap onclick="event.stopPropagation();return false;">\n\
                                        <select class="form-control input-sm" name="supplier[]" style="width: 250px;">\n\
                                            <option value=""></option>\n\
                                            <?php foreach ($ven as $r) { ?>\n\
                                            <option value="<?php echo $r->id_supp; ?>"><?php echo $r->name_supp; ?></option>\n\
                                        <?php } ?>\n\
                                        </td>\n\
                                        <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 200px;" name="vessel[]" value=""></td>\n\
                                        <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 200px;" name="convessel[]" value=""></td>\n\
                                        <td nowrap onclick="event.stopPropagation();return false;"><select name="stuffing[]" id="stuffing"><option value="EECN" id="EECN" onclick="">Export Empty (CN) <option value="EE" id="EE" onclick="">Export Empty <option value="EL" id="EL">Export Laden<option value="IL" id="IL">Import Laden <option value="ITCN" id="ITCN">Import Transhipment (CN) <option value="IT" id="IT">Import Transhipment <option value="LC" id="LC">Local Container <option value="RE" id="RE">Recall Container <option value="ELCN" id="ELCN">Export Laden (CN)</select></td>\n\
                                        <td nowrap onclick="event.stopPropagation();return false;">\n\
                                        <select class="form-control input-sm" name="depot[]" style="width: 200px;">\n\
                                            <option value=""></option>\n\
                                            <?php foreach ($depot as $r) { ?>\n\
                                            <option value="<?php echo $r->depot_id; ?>"><?php echo $r->depot_name; ?></option>\n\
                                        <?php } ?>\n\
                                        <textarea class="form-control" name="depot_remark[]" value="" placeholder="Remarks..."></textarea></td>\n\
                                        <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 80px;" name="pod[]" value=""></td>\n\
                                        <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 80px;" name="opcode[]" value=""></td>\n\
                                        <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 100px;" name="etdsin[]" value=""></td>\n\
                                        <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 100px;" name="etasin[]" value=""></td>\n\
                                        <td hidden><input type="text" class="form-control input-sm" style="width: 150px;" name="container[]" value=""></td>\n\
                                        <td hidden><input type="text" class="form-control input-sm" style="width: 100px;" name="seal[]" value=""></td>\n\
                                        <td hidden><input type="text" class="form-control input-sm text-right" style="width: 80px;" name="weight[]" value="0" onkeypress="return isNumber(event)"></td>\n\
                                        <td hidden><input type="text" class="form-control input-sm" name="shipid[]" value="' + getText(document.getElementById("tbl-po").rows[i].cells[7]) + '"></td>\n\
                                        <td hidden><input type="text" class="form-control input-sm" name="outward[]" value="0"></td>\n\
                                        <td hidden><input type="text" class="form-control input-sm" name="id[]" value="0"></td>\n\
                                        <td hidden><input type="text" class="form-control input-sm" name="actual_seal[]" value=""></td>\n\
                                        <td hidden><input type="text" class="form-control input-sm" name="total_gross_weight[]" value="0"></td>\n\
                                        <td hidden><input type="text" class="form-control input-sm" name="tare_weight[]" value="0"></td>\n\
                                        <td hidden><input type="text" class="form-control input-sm" name="trucking_date[]" value="0"></td>\n\
                                </tr>');

        //                $new_row.find('.date').datepicker();

        $('table[id="tblList"]').append($new_row);
        chk_arr[k].disabled = true;
        chk_arr[k].checked = false;

      }
      i++;
    }

    $("#formdialogPO").dialog("close");
    cekDtl();
  }

  function close_PO() {
    $("#formdialogPO").dialog("close");
  }

  function deleterow(x, y, z) {

    if (confirm("Are you sure remove this row?") == true) {

      $.ajax({
        url: "<?php echo base_url(); ?>shipping/container_shippping_delete_outward?stock=" + x + "&shipid=" + y + "&contid=" + z,
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
    $factory = document.getElementById("factory").value;
    $schedule = document.getElementById("schedule").value;
    $po = document.getElementById("po").value;

    $.ajax({
      url: "<?php echo base_url(); ?>shipping/container_po?fac=" + $factory + "&schedule=" + $schedule + "&po=" + $po + "",
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

    javascript: location.href = "<?php echo base_url(); ?>shipping/container_outward_excel?cont=" + $contid + "";
  }

  function amendment() {
    $amendmentdate = document.getElementById('amendmentdate').value;

    if ($amendmentdate.trim() != '') {
      $('#btn-update').attr('disabled', false);
    } else {
      $('#btn-update').attr('disabled', true);
    }
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

<script>
  function fnDialogPO_ggfs() {

    // Define the Dialog and its properties.
    $("#formdialogPO_ggfs").dialog({
      resizable: false,
      modal: true,
      title: "List PO GGFS",
      height: 570,
      width: 800

    });
  }

  function choose_PO_ggfs() {
    function getText(el) {
      if (typeof el.textContent == 'string') return el.textContent;
      if (typeof el.innerText == 'string') return el.innerText;
    }

    var chk_arr = document.getElementsByName("chk_ggfs[]");

    var chk_length = chk_arr.length;
    i = 1;

    for (k = 0; k < chk_length; k++) {
      if (chk_arr[k].checked == true) {
        var $new_row = $('<tr onclick="deleterow1_ggfs(this)">\n\
                                    <td><button class="btn btn-sm btn-danger" type="button" ><i class="fa fa-trash" ></i></button></td>\n\
                                        <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 50px;" name="urut_ggfs[]" value="0"></td>\n\
                                        <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 110px;" name="po_ggfs[]" value="' + getText(document.getElementById("tbl-po_ggfs").rows[i].cells[2]) + '" disabled></td>\n\
                                        <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 200px;" name="carrier_ggfs[]" value="' + getText(document.getElementById("tbl-po_ggfs").rows[i].cells[4]) + '"></td>\n\
                                        <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 110px;" name="fcl_ggfs[]" value="' + getText(document.getElementById("tbl-po_ggfs").rows[i].cells[5]) + '" disabled></td>\n\
                                        <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 250px;" name="final_ggfs[]" value="' + getText(document.getElementById("tbl-po_ggfs").rows[i].cells[6]) + '"></td>\n\
                                        <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 150px;" name="reff_ggfs[]" value=""><textarea class="form-control" name="reff_remark_ggfs[]" value="" placeholder="Remarks..."></textarea></td>\n\
                                        <td nowrap onclick="event.stopPropagation();return false;">\n\
                                        <select class="form-control input-sm" name="supplier_ggfs[]" style="width: 250px;">\n\
                                            <option value=""></option>\n\
                                            <?php foreach ($ven as $r) { ?>\n\
                                            <option value="<?php echo $r->id_supp; ?>"><?php echo $r->name_supp; ?></option>\n\
                                        <?php } ?>\n\
                                        </td>\n\
                                        <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 200px;" name="vessel_ggfs[]" value=""></td>\n\
                                        <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 200px;" name="convessel_ggfs[]" value=""></td>\n\
                                        <td nowrap onclick="event.stopPropagation();return false;"><select name="stuffing_ggfs[]" id="stuffing"><option value="EECN" id="EECN" onclick="">Export Empty (CN) <option value="EE" id="EE" onclick="">Export Empty <option value="EL" id="EL">Export Laden<option value="IL" id="IL">Import Laden <option value="ITCN" id="ITCN">Import Transhipment (CN) <option value="IT" id="IT">Import Transhipment <option value="LC" id="LC">Local Container <option value="RE" id="RE">Recall Container <option value="ELCN" id="ELCN">Export Laden (CN)</select></td>\n\
                                        <td nowrap onclick="event.stopPropagation();return false;">\n\
                                        <select class="form-control input-sm" name="depot_ggfs[]" style="width: 200px;">\n\
                                            <option value=""></option>\n\
                                            <?php foreach ($depot as $r) { ?>\n\
                                            <option value="<?php echo $r->depot_id; ?>"><?php echo $r->depot_name; ?></option>\n\
                                        <?php } ?>\n\
                                        <textarea class="form-control" name="depot_remark_ggfs[]" value="" placeholder="Remarks..."></textarea></td>\n\
                                        <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 80px;" name="pod_ggfs[]" value=""></td>\n\
                                        <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 80px;" name="opcode_ggfs[]" value=""></td>\n\
                                        <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 100px;" name="etdsin_ggfs[]" value=""></td>\n\
                                        <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 100px;" name="etasin_ggfs[]" value=""></td>\n\
                                        <td hidden><input type="text" class="form-control input-sm" style="width: 150px;" name="container_ggfs[]" value=""></td>\n\
                                        <td hidden><input type="text" class="form-control input-sm" style="width: 100px;" name="seal_ggfs[]" value=""></td>\n\
                                        <td hidden><input type="text" class="form-control input-sm text-right" style="width: 80px;" name="weight_ggfs[]" value="0" onkeypress="return isNumber(event)"></td>\n\
                                        <td hidden><input type="text" class="form-control input-sm" name="shipid_ggfs[]" value="' + getText(document.getElementById("tbl-po_ggfs").rows[i].cells[7]) + '"></td>\n\
                                        <td hidden><input type="text" class="form-control input-sm" name="outward_ggfs[]" value="0"></td>\n\
                                        <td hidden><input type="text" class="form-control input-sm" name="id_ggfs[]" value="0"></td>\n\
                                        <td hidden><input type="text" class="form-control input-sm" name="actual_seal_ggfs[]" value=""></td>\n\
                                        <td hidden><input type="text" class="form-control input-sm" name="total_gross_weight_ggfs[]" value="0"></td>\n\
                                        <td hidden><input type="text" class="form-control input-sm" name="tare_weight_ggfs[]" value="0"></td>\n\
                                        <td hidden><input type="text" class="form-control input-sm" name="trucking_date_ggfs[]" value="0"></td>\n\
                                </tr>');

        //                $new_row.find('.date').datepicker();

        $('table[id="tblList_ggfs"]').append($new_row);
        chk_arr[k].disabled = true;
        chk_arr[k].checked = false;

      }
      i++;
    }

    $("#formdialogPO_ggfs").dialog("close");
    cekDtl_ggfs();
  }

  function close_PO_ggfs() {
    $("#formdialogPO_ggfs").dialog("close");
  }

  function deleterow_ggfs(x, y, z) {
    if (confirm("Are you sure remove this ggfs row?") == true) {

      $.ajax({
        url: "<?php echo base_url(); ?>shipping/container_shippping_delete_outward_ggfs?stock=" + x + "&shipid=" + y + "&contid=" + z,
        success: function(response) {
          location.reload();
        },
        dataType: "html"
      });

      cekDtl_ggfs();
    }
  }

  function deleterow_lc_db_ggfs(x) {

    if (confirm("Are you sure remove this row?") == true) {

      $.ajax({
        url: "<?php echo base_url(); ?>shipping/container_local_delete_ggfs?id=" + x,
        success: function(response) {
          location.reload();
        },
        dataType: "html"
      });

      cekDtl_ggfs();
    }
  }

  function deleterow1_ggfs(x) {
    $r = x.rowIndex;

    if (confirm("Are you sure remove this row?") == true) {
      document.getElementById("tblList_ggfs").deleteRow($r);
      cekDtl_ggfs();
    }
  }

  function filterpo_ggfs() {
    filterpodtl_ggfs();

  }

  function filterpodtl_ggfs() {
    $factory = document.getElementById("factory_ggfs").value;
    $schedule = document.getElementById("schedule_ggfs").value;
    $po = document.getElementById("po_ggfs").value;

    $.ajax({
      url: "<?php echo base_url(); ?>shipping/container_po_ggfs?fac=" + $factory + "&schedule=" + $schedule + "&po=" + $po + "",
      success: function(response) {
        $("#tblpo_ggfs").html(response);
      },
      dataType: "html"
    });

    return false;
  }

  function cekDtl_ggfs() {
    var ID_arr = document.getElementsByName("shipid_ggfs[]");
    var ID_length = ID_arr.length;

    if ((ID_length > 0)) {
      $('#btn-update').attr('disabled', false);
    } else {
      $('#btn-update').attr('disabled', true);
    }
  }

  function enable_update_ggfs(y) {
    
  console.log(y);
    if (confirm("Are you sure you give access to changing data to marketing?") == true) {

      $.ajax({
        url: "<?php echo base_url(); ?>shipping/enable_update_ggfs?shipid=" + y,
        success: function(response) {
          console.log(response);
          location.reload();
        },
        dataType: "html"
      });

      cekDtl_ggfs();
    }
  }


  function disable_update_ggfs(y) {
    
    if (confirm("Are you sure you closed access to change data to marketing?") == true) {

      $.ajax({
        url: "<?php echo base_url(); ?>shipping/disable_update_ggfs?shipid=" + y,
        success: function(response) {
          location.reload();
        },
        dataType: "html"
      });

      cekDtl_ggfs();
    }
  }
</script>