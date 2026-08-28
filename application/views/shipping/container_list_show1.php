<?php
$proses = '0';
$allow_update = '0';
$jurnal_barge_sales = '0';
$proses_ggfs = '0';
$allow_update_ggfs = '0';
$jurnal_barge_sales_ggfs = '0';

if ($cont) {
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
}
?>

<?php
  if ($cont_ggfs) {
  foreach ($cont_ggfs as $ggfs) {
    $contid      = $ggfs->contid;
    $tipe        = $ggfs->tipe;
    $shipment    = date("d-m-Y",  strtotime($ggfs->shipmentdate));
    $barge       = $ggfs->barge;
    $voyage      = $ggfs->voyage;
    $etd         = $ggfs->etd;
    $eta         = $ggfs->eta;
    $etddateTemp = $ggfs->etddate;
    $etadateTemp = $ggfs->etadate;
    $stuffing    = $ggfs->stuffing;
    $to          = $ggfs->to;
    $from        = $ggfs->from;
    $remarks     = $ggfs->remarks;
    $factory_id  = $ggfs->factory_id;

    if ($ggfs->allow_update == '1') {
      $allow_update = $ggfs->allow_update;
    }

    if ($ggfs->proses == '1') {
      $proses = $ggfs->proses;
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

    $amendmenttemp = $ggfs->amendment;
    if ($amendmenttemp != '0000-00-00') {
      $amendment =  date("d-m-Y",  strtotime($amendmenttemp));
    } else {
      $amendment = '';
    }
  }
}
?>

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
                <div class="row mb-5">
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
                        <input class="form-control input-sm date date-picker" name="shipdate" data-date="02-12-2012" data-date-format="dd-mm-yyyy" value="<?= date('d-m-Y', strtotime($cont_header->shipmentdate)); ?>" required>
                        <input class="form-control input-sm" name="contid" id="contid" value="<?php echo $cont_header->contid; ?>" type="">
                        <input class="form-control input-sm" name="tipe1" id="tipe1" value="<?php echo $cont_header->tipe; ?>" type="hidden">
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
                          <!-- <input class="form-control input-sm" name="etd" value="<?php echo $cont_header->etd; ?>"> -->
                          <select name="etd" class="form-control input-sm" id="etd">
                            <option id="RSUP" value="RSUP" <?php if ($cont_header->etd === "RSUP") {
                                                              echo 'selected';
                                                            } ?>>Riau Sakti United Plantation </option>
                            <option id="PSG" value="PSG" <?php if ($cont_header->etd === "PSG") {
                                                            echo 'selected';
                                                          } ?>>Pulau Sambu Guntung</option>
                            <option id="PSKE" value="PSKE" <?php if ($cont_header->etd === "PSKE") {
                                                              echo 'selected';
                                                            } ?>>Pulau Sambu Kuala Enok</option>
                          </select>
                          <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                          <input class="form-control input-sm date date-picker" placeholder="ETD Date" name="etddate" data-date="02-12-2012" data-date-format="dd-mm-yyyy" value="<?= date("d-m-Y", strtotime($cont_header->etddate)); ?>">
                        </div>
                      </div>
                    </div>
                    <div class="form-group" style="margin-bottom:1px;">
                      <label class="col-md-2 label-sm">ETA</label>
                      <div class="col-md-7">
                        <div class="input-group">
                          <input class="form-control input-sm" name="eta" value="<?php echo $cont_header->eta; ?>" readonly>
                          <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                          <input class="form-control input-sm date date-picker" placeholder="ETA Date" name="etadate" data-date="02-12-2012" data-date-format="dd-mm-yyyy" value="<?= date("d-m-Y", strtotime($cont_header->etadate)); ?>">
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
                        <input class="form-control input-sm date date-picker" name="amendmentdate" id="amendmentdate" data-date="02-12-2012" data-date-format="dd-mm-yyyy" value="<?php echo $amendment; ?>" onchange="amendment()">
                      </div>
                    </div>
                  </div>
                </div>

                <div class="alert alert-success text-center processing" role="alert" style="display:none"> <i class='fa fa-spinner fa fa-spin'></i> Processing...</div>

                <div class="table-scrollable" style="overflow: auto; height: 550px;">
                  <table class="table table-bordered" id="tblList">
                    <thead>
                      <tr>
                        <th width="200">
                          <button class="btn btn-sm btn-primary" type="button" id="btn-po" onclick="fnDialogPO()"><i class="fa fa-arrow-down"></i></button>
                          <button class="btn btn-sm green" type="button" id="btn-change-ship" onclick="changemultiplerow()"><i class="fa fa-refresh"></i></button>
                          <button class="btn btn-sm red" type="button" id="btn-delete-po" onclick="deletemultiplerow()"><i class="fa fa-trash"></i></button>
                          <button class="btn btn-sm yellow" type="button" id="btn-getakses-po" onclick="getaksesmultiplerow()"><i class="fa fa-cog"></i></button>
                          <button class="btn btn-sm red" type="button" id="btn-closeakses-po" onclick="closeaksesmultiplerow()"><i class="fa fa-power-off"></i></button>
                          <button class="btn btn-sm btn-info" type="button" id="btn-sync-flowcargoes" onclick="flowCargoesmultiplerow()"><i class="fa fa fa-external-link"></i></button>
                        </th>
                        <th id="togglecheck" nowrap>Seq No</th>
                        <th nowrap>PO Number</th>
                        <th nowrap>Shipper/Carrier</th>
                        <th nowrap>FCL</th>
                        <th nowrap>Destination</th>
                        <th nowrap>Booking Ref</th>
                        <th nowrap>Supplier</th>
                        <th nowrap>Vessel/Voyage</th>
                        <th nowrap>Connecting Vessel</th>
                        <th nowrap>Stuffing</th>
                        <th nowrap hidden="">Depot</th>
                        <th nowrap>POD</th>
                        <th nowrap>OP Code</th>
                        <th nowrap>ETA Sin</th>
                        <th nowrap>Container</th>
                        <th nowrap hidden>Seal</th>
                        <th nowrap>Actual Seal</th>
                        <th nowrap>ETA</th>
                        <th nowrap>Weight Product (Kgs)</th>
                        <th nowrap>Tare Weight (Kgs)</th>
                        <th nowrap>Sample</th>
                        <th nowrap>Weight (VGM)</th>
                        <th nowrap>Tracking Date</th>
                        <th nowrap>Bill Status</th>
                      </tr>
                    </thead>
                    <tbody id="tblList_1">
                      <?php
                      $i = 1;
                      foreach ($cont as $r) {
                        $weightpallet = $r->pallet_qty * 19;
                        $weight1 = $weightpallet +  $r->total_gross_weight + $r->tare_weight +  $r->sample;

                      ?>
                        <tr>
                          <td align="center">

                            <?php if ($r->jurnal_barge_sales == '') { ?>
                              <div class="btn btn-sm green">
                                <i class="fa fa-refresh"></i>
                                <input type="checkbox" name='chk_move' class='chk_move' data-id="<?= $r->id ?>" data-flag="<?= $r->flag ?>" data-shipid="<?= $r->shipid ?>" data-desc="pss">
                              </div>
                              <?php
                              if ($r->proses == '' || $r->proses == '0') {
                                $disabled = '';
                              } else {
                                $disabled = 'disabled';
                              }
                              ?>
                              <div class="btn btn-sm btn-danger">
                                <i class="fa fa-trash"></i>
                                <input type="checkbox" name='chk_delete' class='chk_delete' data-id="<?= $r->id ?>" data-flag="<?= $r->flag ?>">
                              </div>
                              <?php

                              if ($r->proses != '') { ?>

                                <?php if ($r->allow_update != 1) { ?>

                                  <div class="btn btn-sm yellow">
                                    <i class="fa fa-cog"></i>
                                    <input type="checkbox" name='chk_akses' class='chk_akses' data-shipid="<?= $r->shipid ?>">
                                  </div>

                                  <!-- <button class="btn yellow" type="button" id="btn-enable" onclick="enable_update(<?= $r->shipid; ?>)"><i class="fa fa-cog"></i></button> -->

                                <?php } else { ?>

                                  <div class="btn btn-sm btn-danger">
                                    <i class="fa fa-power-off"></i>
                                    <input type="checkbox" name='chk_close_akses' class='chk_close_akses' data-shipid="<?= $r->shipid ?>">
                                  </div>

                                  <!-- <button class="btn red" type="button" id="btn-disable" onclick="disable_update(<?= $r->shipid; ?>)"><i class="fa fa-power-off"></i></button> -->

                                <?php
                                }
                                ?>

                              <?php } else { ?>

                                <!-- <button class="btn btn-sm btn-danger" type="button" id="btn-delete" onclick="deleterow(<?= $r->detail_id; ?>, <?= $r->flag; ?>)"><i class="fa fa-trash"></i></button> -->

                                <!-- <button class="btn btn-sm green" type="button" id="btn-change-ship" onclick="changerow(<?= $r->id; ?>, <?= $r->flag; ?>, <?= $r->shipid; ?>)"><i class="fa fa-refresh"></i></button> -->

                                <?php if ($r->allow_update != 1) { ?>

                                  <button class="btn yellow" type="button" id="btn-enable" onclick="enable_update(<?= $r->shipid; ?>)"><i class="fa fa-cog"></i></button>

                                <?php } else { ?>

                                  <button class="btn red" type="button" id="btn-disable" onclick="disable_update(<?= $r->shipid; ?>)"><i class="fa fa-power-off"></i></button>

                            <?php
                                }
                              }
                            }
                            ?>

                            <!-- // btn sync flowcargoes -->
                            <?php
                            if ($r->flowcargoes_flag !== '1') { ?>

                              <div class="btn btn-sm btn-info">
                                <i class="fa fa fa-external-link"></i>
                                <input type="checkbox" name='chk_flowcargoes_akses' class='chk_flowcargoes_akses' data-detailid="<?= $r->detail_id ?>">
                              </div>
                            <?php
                            } else { ?>
                              <span class="badge badge-primary">Has Sync to Flowcargoes</span>
                            <?php
                            }
                            ?>

                            <!-- <div class="mt-1" id="flow-status-<?= $r->detail_id ?>">
                              <?php
                              if ($r->flowcharges_flag != 1) { ?>
                                <button type="button" class="btn btn-info green btn-block btn-circle btn-sm" onclick="dialogflowcharges('<?= $flow_id ?>')"><i class="fa fa fa-external-link btn-flowcharges"></i> Sync to Flowcargoes</button>
                              <?php
                              } else { ?>
                                <span class="badge badge-primary">Has Sync to Flowcargoes</span>
                              <?php
                              }
                              ?>
                            </div> -->

                          </td>

                          <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 50px;" name="urut[]" value="<?php echo $r->urut; ?>"></td>
                          <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 150px;" name="po[]" value="<?php echo $r->po_number; ?>" disabled>
                            <input type="hidden" name="po_number" id="po_number-<?= $i; ?>">
                          </td>
                          <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 230px;" name="carrier[]" value="<?php echo $r->shipping_liner; ?>"></td>
                          <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 230px;" name="fcl[]" value="<?php echo $r->container_name; ?>" disabled></td>
                          <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 150px;" name="final[]" value="<?php echo $r->destination; ?>"></td>
                          <td nowrap onclick="event.stopPropagation();return false;">
                            <input type="text" class="form-control input-sm" style="width: 300px;" name="reff[]" value="<?php echo $r->reff; ?>"><textarea class="form-control" name="reff_remark[]"><?php echo $r->reff_remark; ?></textarea>
                          </td>
                          <td nowrap onclick="event.stopPropagation();return false;" style="width: 200px;">
                            <select class="form-control input-sm select2me" name="supplier[]">
                              <option value="<?= $r->supplier; ?>"><?= $r->supplier_name; ?></option>
                              <?php foreach ($ven as $x) { ?>
                                <option value="<?php echo $x->id_supp; ?>"><?php echo $x->name_supp; ?></option>
                              <?php } ?>
                            </select>
                          </td>
                          <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 200px;" name="vessel[]" value="<?php echo $r->vessel; ?>"></td>
                          <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 150px;" name="convessel[]" value="<?php echo $r->convessel; ?>"></td>
                          <td nowrap onclick="event.stopPropagation();return false;"><select name="stuffing[]" class="form-control input-sm select2me">
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
                              <!-- <option id="ELTP" value="ELTP" <?php if ($r->stuffing === "ELTP") {
                                                                echo 'selected';
                                                              } ?>>Export Laden (TP) -->
                              <option id="EECN" value="EECN" <?php if ($r->stuffing === "EECN") {
                                                            echo 'selected';
                                                          } ?>>Export Empty (CN)
                              <option id="ELCN" value="ELCN" <?php if ($r->stuffing === "ELCN") {
                                                            echo 'selected';
                                                          } ?>>Export Laden (CN)
                              <option id="ITCN" value="ITCN" <?php if ($r->stuffing === "ITCN") {
                                                            echo 'selected';
                                                          } ?>>Import Transhipment (CN)  
                                <option id="ITDP" value="ITDP" <?php if ($r->stuffing === "ITDP") {
                                                            echo 'selected';
                                                          } ?>>Import Transhipment Direct Purchase
                              <option id="ITCNDP" value="ITCNDP" <?php if ($r->stuffing === "ITCNDP") {
                                                            echo 'selected';
                                                          } ?>>Import Transhipment Direct Purchase (CN)                                                          

                            </select></td>
                          <td nowrap onclick="event.stopPropagation();return false;" hidden="">
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

                          <td hidden nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 100px;" name="seal[]" value="<?php echo $r->seal; ?>"></td>
                          <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 100px;" name="actual_seal[]" value="<?php echo $r->actual_seal; ?>"></td>
                          <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 100px;" name="etasin[]" value="<?php echo $r->etasin; ?>"></td>
                          <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm txt number gross" style="width: 120px;" name="total_gross_weight[]" value="<?php echo number_format($r->total_gross_weight, 4, '.', ','); ?>" onkeypress="return isNumber(event)" readonly></td>
                          <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm txt number tare" style="width: 100px;" name="tare_weight[]" value="<?php echo number_format($r->tare_weight, 4, '.', ','); ?>" onkeypress="return isNumber(event)" onKeyup="hitung_amount()"></td>
                          <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm txt number weight" style="width: 100px;" name="sample[]" value="<?php echo number_format($r->sample, 4, '.', ','); ?>" readonly></td>
                          <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm txt number weight" style="width: 100px;" name="weight[]" value="<?php echo number_format($weight1, 4, '.', ','); ?>" readonly></td>
                          <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm text-right" style="width: 300px;" name="trucking_date[]" value="<?php echo $r->trucking_date; ?>"><textarea class="form-control" name="trucking_date_remark[]"><?php echo $r->trucking_date_remark; ?></textarea></td>
                          <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 130px;" name="bill[]" value="<?php echo $r->jurnal_barge_sales; ?>" readonly></td>
                          <td hidden><input type="text" class="form-control input-sm" name="shipid[]" value="<?php echo $r->shipid; ?>"></td>
                          <td hidden><input type="text" class="form-control input-sm" name="outward[]" value="<?php echo $r->flag; ?>"></td>
                          <td hidden><input type="text" class="form-control input-sm" name="id[]" value="<?php echo $r->id; ?>"></td>
                          <input type="hidden" name="desc" value="pss"/>
                        </tr>
                      <?php
                        $i++;
                      } ?>
                    </tbody>
                  </table>
                </div>
                <script>
                  $('#togglecheck').on('click', function() {
                    if (this.checked == true) {
                      $("input[type=checkbox]").prop('checked', true).uniform();
                    } else {
                      $("input[type=checkbox]").prop('checked', false).uniform();
                    }
                  });
                </script>
                <a class="btn btn-primary" data-stat="pss" onclick="excel_template(this)"><i class="fa fa-download"></i> Download Template Container and Seal Number</a>
                <a class="btn btn-primary green" href="<?php echo site_url('shipping/container_import_excel?cont=' . $contid . '&tipe=' . $tipe. '&statimport=' . 'pss'); ?>"><i class="fa fa-upload"></i> Upload Container and Seal Number</a>
                <a class="btn btn-info" href="javascript::()" onclick="syncAllFlowCargoes(<?= $contid ?>)"><i class="fa fa fa-external-link"></i> Sync Container to FlowCargoes per 10 Data Automatic</a>

                <div class="portlet-title mt-5">
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
                          <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" name="urut_lc[]" value="<?php echo $no; ?>"></td>
                          <td nowrap onclick="event.stopPropagation();return false;" style="width: 100px;"><select name="stuffing_lc[]" id="stuffing_lc" class="form-control input-sm select2me">
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
                              <option value="LLTP" id="LLTP" <?php if ($s->stuffing == 'LLTP') {
                                                                echo 'selected';
                                                              } ?>>Local Laden (TP)
                              <option id="LOTP" value="LOTP" <?php if ($s->stuffing == "LOTP") {
                                                                echo 'selected';
                                                              } ?>>Local Empty(TP)
                            </select></td>
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
                
                <!-- ggfs -->
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
                        <th width="200">
                          <button class="btn btn-sm btn-primary" type="button" id="btn-po_ggfs" onclick="fnDialogPO_ggfs()"><i class="fa fa-arrow-down"></i></button>
                          <button class="btn btn-sm green" type="button" id="btn-change-ship" onclick="changemultiplerow_ggfs()"><i class="fa fa-refresh"></i></button>
                          <button class="btn btn-sm red" type="button" id="btn-delete-po" onclick="deletemultiplerow_ggfs()"><i class="fa fa-trash"></i></button>
                          <button class="btn btn-sm yellow" type="button" id="btn-getakses-po" onclick="getaksesmultiplerow_ggfs()"><i class="fa fa-cog"></i></button>
                          <button class="btn btn-sm red" type="button" id="btn-closeakses-po" onclick="closeaksesmultiplerow_ggfs()"><i class="fa fa-power-off"></i></button>
                          <button class="btn btn-sm btn-info" type="button" id="btn-sync-flowcargoes" onclick="flowCargoesmultiplerow_ggfs()"><i class="fa fa fa-external-link"></i></button>
                        </th>
                        <th id="togglecheck" nowrap>Seq No</th>
                        <th nowrap>PO Number</th>
                        <th nowrap>Shipper/Carrier</th>
                        <th nowrap>FCL</th>
                        <th nowrap>Destination</th>
                        <th nowrap>Booking Ref</th>
                        <th nowrap>Supplier</th>
                        <th nowrap>Vessel/Voyage</th>
                        <th nowrap>Connecting Vessel</th>
                        <th nowrap>Stuffing</th>
                        <th nowrap hidden="">Depot</th>
                        <th nowrap>POD</th>
                        <th nowrap>OP Code</th>
                        <th nowrap>ETA Sin</th>
                        <th nowrap>Container</th>
                        <th nowrap hidden>Seal</th>
                        <th nowrap>Actual Seal</th>
                        <th nowrap>ETA</th>
                        <th nowrap>Weight Product (Kgs)</th>
                        <th nowrap>Tare Weight (Kgs)</th>
                        <th nowrap>Sample</th>
                        <th nowrap>Weight (VGM)</th>
                        <th nowrap>Tracking Date</th>
                        <th nowrap>Bill Status</th>
                      </tr>
                    </thead>
                    <tbody id="tblList_1_ggfs">
                      <?php
                      $i = 1;
                      foreach ($cont_ggfs as $r) {
                        $weightpallet = $r->pallet_qty * 19;
                        $weight1 = $weightpallet +  $r->total_gross_weight + $r->tare_weight +  $r->sample;

                      ?>
                        <tr>
                          <td align="center">

                            <?php if ($r->jurnal_barge_sales == '') { ?>
                              <div class="btn btn-sm green">
                                <i class="fa fa-refresh"></i>
                                <input type="checkbox" name='chk_move_ggfs' class='chk_move_ggfs' data-id="<?= $r->id ?>" data-flag="<?= $r->flag ?>" data-shipid="<?= $r->shipid ?>" data-desc="ggfs">
                              </div>
                              <?php
                              if ($r->proses == '' || $r->proses == '0') {
                                $disabled = '';
                              } else {
                                $disabled = 'disabled';
                              }
                              ?>
                              <div class="btn btn-sm btn-danger">
                                <i class="fa fa-trash"></i>
                                <input type="checkbox" name='chk_delete_ggfs' class='chk_delete_ggfs' data-id="<?= $r->id ?>" data-flag="<?= $r->flag ?>">
                              </div>
                              <?php

                              if ($r->proses != '') { ?>

                                <?php if ($r->allow_update != 1) { ?>

                                  <div class="btn btn-sm yellow">
                                    <i class="fa fa-cog"></i>
                                    <input type="checkbox" name='chk_akses_ggfs' class='chk_akses_ggfs' data-shipid="<?= $r->shipid ?>">
                                  </div>
                                <?php } else { ?>

                                  <div class="btn btn-sm btn-danger">
                                    <i class="fa fa-power-off"></i>
                                    <input type="checkbox" name='chk_close_akses_ggfs' class='chk_close_akses_ggfs' data-shipid="<?= $r->shipid ?>">
                                  </div>
                                <?php
                                }
                                ?>
                              <?php } else { ?>
                                <?php if ($r->allow_update != 1) { ?>
                                  <button class="btn yellow" type="button" id="btn-enable" onclick="enable_update_ggfs(<?= $r->shipid; ?>)"><i class="fa fa-cog"></i></button>
                                <?php } else { ?>
                                  <button class="btn red" type="button" id="btn-disable" onclick="disable_update_ggfs(<?= $r->shipid; ?>)"><i class="fa fa-power-off"></i></button>
                            <?php
                                }
                              }
                            }
                            ?>

                            <?php
                            if ($r->flowcargoes_flag !== '1') { ?>

                              <div class="btn btn-sm btn-info">
                                <i class="fa fa fa-external-link"></i>
                                <input type="checkbox" name='chk_flowcargoes_akses_ggfs' class='chk_flowcargoes_akses_ggfs' data-detailid="<?= $r->detail_id ?>">
                              </div>
                            <?php
                            } else { ?>
                              <span class="badge badge-primary">Has Sync to Flowcargoes</span>
                            <?php
                            }
                            ?>

                          </td>

                          <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 50px;" name="urut_ggfs[]" value="<?php echo $r->urut; ?>"></td>
                          <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 150px;" name="po_ggfs[]" value="<?php echo $r->po_number; ?>" disabled>
                            <input type="hidden" name="po_number" id="po_number-<?= $i; ?>">
                          </td>
                          <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 230px;" name="carrier_ggfs[]" value="<?php echo $r->shipping_liner; ?>"></td>
                          <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 230px;" name="fcl_ggfs[]" value="<?php echo $r->container_name; ?>" disabled></td>
                          <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 150px;" name="final_ggfs[]" value="<?php echo $r->destination; ?>"></td>
                          <td nowrap onclick="event.stopPropagation();return false;">
                            <input type="text" class="form-control input-sm" style="width: 300px;" name="reff_ggfs[]" value="<?php echo $r->reff; ?>"><textarea class="form-control" name="reff_remark_ggfs[]"><?php echo $r->reff_remark; ?></textarea>
                          </td>
                          <td nowrap onclick="event.stopPropagation();return false;" style="width: 200px;">
                            <select class="form-control input-sm select2me" name="supplier_ggfs[]">
                              <option value="<?= $r->supplier; ?>"><?= $r->supplier_name; ?></option>
                              <?php foreach ($ven as $x) { ?>
                                <option value="<?php echo $x->id_supp; ?>"><?php echo $x->name_supp; ?></option>
                              <?php } ?>
                            </select>
                          </td>
                          <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 200px;" name="vessel_ggfs[]" value="<?php echo $r->vessel; ?>"></td>
                          <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 150px;" name="convessel_ggfs[]" value="<?php echo $r->convessel; ?>"></td>
                          <td nowrap onclick="event.stopPropagation();return false;"><select name="stuffing_ggfs[]" class="form-control input-sm select2me">
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
                              <!-- <option id="ELTP" value="ELTP" <?php if ($r->stuffing === "ELTP") {
                                                                echo 'selected';
                                                              } ?>>Export Laden (TP) -->
                              <option id="EECN" value="EECN" <?php if ($r->stuffing === "EECN") {
                                                            echo 'selected';
                                                          } ?>>Export Empty (CN)
                              <option id="ELCN" value="ELCN" <?php if ($r->stuffing === "ELCN") {
                                                            echo 'selected';
                                                          } ?>>Export Laden (CN)
                              <option id="ITCN" value="ITCN" <?php if ($r->stuffing === "ITCN") {
                                                            echo 'selected';
                                                          } ?>>Import Transhipment (CN)  
                                <option id="ITDP" value="ITDP" <?php if ($r->stuffing === "ITDP") {
                                                            echo 'selected';
                                                          } ?>>Import Transhipment Direct Purchase
                              <option id="ITCNDP" value="ITCNDP" <?php if ($r->stuffing === "ITCNDP") {
                                                            echo 'selected';
                                                          } ?>>Import Transhipment Direct Purchase (CN)                                                          

                            </select></td>
                          <td nowrap onclick="event.stopPropagation();return false;" hidden="">
                            <select class="form-control input-sm select2me" name="depot_ggfs[]">
                              <option value="<?= $r->depot; ?>"><?= $r->depot_name; ?></option>
                              <?php foreach ($depot as $x) { ?>
                                <option value="<?php echo $x->depot_id; ?>"><?php echo $x->depot_name; ?></option>
                              <?php } ?>
                            </select>
                            <textarea class="form-control" name="depot_remark_ggfs[]"><?php echo $r->depot_remark; ?></textarea>
                          </td>
                          <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 80px;" name="pod_ggfs[]" value="<?php echo $r->pod; ?>"></td>
                          <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 80px;" name="opcode_ggfs[]" value="<?php echo $r->opcode; ?>"></td>
                          <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 100px;" data-date="02-12-2012" name="etdsin_ggfs[]" value="<?php echo $r->etdsin; ?>"></td>

                          <?php
                          if ($r->proses == 1) {
                          ?>
                            <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 150px;" name="container_ggfs[]" id="ci" value="<?php echo $r->container; ?>"></td>
                          <?php
                          } else {
                          ?>
                            <td nowrap onclick="event.stopPropagation();return false;"><input ondblclick="fnDialogContainerChange(<?= $r->detail_id; ?>, <?php echo "'" . $r->container . "'"; ?>)" type="text" class="form-control input-sm" style="width: 150px;" name="container_ggfs[]" id="ci-<?= $r->detail_id; ?>" value="<?php echo $r->container; ?>"></td>
                          <?php
                          }
                          ?>

                          <td hidden nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 100px;" name="seal_ggfs[]" value="<?php echo $r->seal; ?>"></td>
                          <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 100px;" name="actual_seal_ggfs[]" value="<?php echo $r->actual_seal; ?>"></td>
                          <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 100px;" name="etasin_ggfs[]" value="<?php echo $r->etasin; ?>"></td>
                          <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm txt number gross" style="width: 120px;" name="total_gross_weight_ggfs[]" value="<?php echo number_format($r->total_gross_weight, 4, '.', ','); ?>" onkeypress="return isNumber(event)" readonly></td>
                          <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm txt number tare" style="width: 100px;" name="tare_weight_ggfs[]" value="<?php echo number_format($r->tare_weight, 4, '.', ','); ?>" onkeypress="return isNumber(event)" onKeyup="hitung_amount()"></td>
                          <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm txt number weight" style="width: 100px;" name="sample_ggfs[]" value="<?php echo number_format($r->sample, 4, '.', ','); ?>" readonly></td>
                          <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm txt number weight" style="width: 100px;" name="weight_ggfs[]" value="<?php echo number_format($weight1, 4, '.', ','); ?>" readonly></td>
                          <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm text-right" style="width: 300px;" name="trucking_date_ggfs[]" value="<?php echo $r->trucking_date; ?>"><textarea class="form-control" name="trucking_date_remark_ggfs[]"><?php echo $r->trucking_date_remark; ?></textarea></td>
                          <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 130px;" name="bill_ggfs[]" value="<?php echo $r->jurnal_barge_sales; ?>" readonly></td>
                          <td hidden><input type="text" class="form-control input-sm" name="shipid_ggfs[]" value="<?php echo $r->shipid; ?>"></td>
                          <td hidden><input type="text" class="form-control input-sm" name="outward_ggfs[]" value="<?php echo $r->flag; ?>"></td>
                          <td hidden><input type="text" class="form-control input-sm" name="id_ggfs[]" value="<?php echo $r->id; ?>"></td>
                          <input type="hidden" name="desc" value="ggfs"/>
                        </tr>
                      <?php
                        $i++;
                      } ?>
                    </tbody>
                  </table>
                </div>
                <script>
                  $('#togglecheck').on('click', function() {
                    if (this.checked == true) {
                      $("input[type=checkbox]").prop('checked', true).uniform();
                    } else {
                      $("input[type=checkbox]").prop('checked', false).uniform();
                    }
                  });
                </script>
                <a class="btn btn-primary" data-stat="ggfs" onclick="excel_template(this)"><i class="fa fa-download"></i> Download Template Container and Seal Number</a>
                <a class="btn btn-primary green" href="<?php echo site_url('shipping/container_import_excel?cont=' . $contid . '&tipe=' . $tipe . '&statimport=' . 'ggfs'); ?>"><i class="fa fa-upload"></i> Upload Container and Seal Number</a>
                <a class="btn btn-info" href="javascript::()" onclick="syncAllFlowCargoes_ggfs(<?= $contid ?>)"><i class="fa fa fa-external-link"></i> Sync Container to FlowCargoes per 10 Data Automatic</a>
              </div>

              <div class="row mt-2">
                <div class="col-md-12">
                  <div class="form-group">
                    <label class="col-md-1 label-sm">Remark</label>
                    <div class="col-md-4">
                      <textarea rows="3" class="form-control autosizeme" name="remarks"><?php echo str_replace("<br />", "", $cont_header->remarks); ?></textarea>
                    </div>
                  </div>
                </div>

                <div class="col-md-6 mt-2">
                  <a type="button" class="col-md-2 btn btn-default" href="<?php echo site_url('shipping/container'); ?>">Add</a>
                  <button type="submit" class="col-md-2 btn btn-primary" id="btn-update">Update</button>
                </div>
                <div class="col-md-6 mt-2">
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
              <div id="isidisini"></div>
            </div>
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
                      <option value="PSKE">Pulau Sambu Kuala Enok</option>
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
          <div class='col-md-12 mb-2'>
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
      <div id="formdialogPO"></div>
      <div id="formdialogPO_ggfs"></div>
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
  $(document).ready(function() {
    if (<?php echo $proses; ?> == '1') {
      $('#btn-update').attr('disabled', true);
      var rows = document.getElementById('tblList').rows;
      for (var row = 0; row < rows.length; row++) {}
    }

    if (<?php echo $allow_update; ?> == '1') {
      $('#btn-update').attr('disabled', false);
      var rows = document.getElementById('tblList').rows;
      for (var row = 0; row < rows.length; row++) {}
    }

  });

  $('input:checkbox').uniform();

  $("#table-container-local input:checkbox.chkclass").change(function() {
    if (this.checked) {
      //Cache cloned object in a variable
      var clone = $(this).closest("tr").clone();

      //Remove checkbox
      clone.find(':checkbox').remove()
      //Append it
      clone.appendTo("#tabel-load-local");
    } else {
      var index = $(this).closest("tr").attr("data-index");
      var findRow = $("#tabel-load-local tr[data-index='" + index + "']");
      findRow.remove();
    }
  }).change();



  function choose_PO_lc() {
    $ctr_name = $('#ctr_id option:selected').text();
    $ctr_id = $('#ctr_id option:selected').val();
    $rowcount = $('#rowcount').val();

    for ($i = 0; $i < $rowcount; $i++) {
      var $new_row = $('<tr onclick="deleterow_lc(this)">\n\
                                    <td align="center"><button class="btn btn-sm btn-danger" type="button" ><i class="fa fa-trash" ></i></button></td>\n\
                                        <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" name="urut_lc[]" value="0"></td>\n\
                                        <td nowrap onclick="event.stopPropagation();return false;" style="width: 100px;"><select name="stuffing_lc[]" id="stuffing_lc"><option value="LL" id="LL">Local Laden<option value="LE" id="LE">Local Empty<option value="LOTP" id="LOTP">LOCAL EMPTY (TP)</select></td>\n\
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

  function fnDialogContainerLocalInZHL() {
    $("#modal-outward-ready").modal('show')
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
                        <div class='col-md-12 mb-2'>\n\
                            <div class='form-group'>\n\
                                 <label class='col-md-1 label-sm'>Find</label>\n\
                                 <div class='col-md-7'>\n\
                                        <input class='form-control input-sm' id='findpo'>\n\
                                 </div>\n\
                                 <button type='button' class='col-md-2 btn blue' onclick='filterpo()'>Search</button>\n\
                            </div>\n\
                        </div>\n\
                        \n\
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
                                </tbody>\n\
                            </table>\n\
                            <div class='text-center' style='display:none' id='loader'>\n\
                                  <h2><i class='fa fa-spinner fa fa-spin'></i></h2>\n\
                                 <p>Loading...</p>\n\
                                </div>\n\
                        </div>\n\
                        <div class='col-md-6'>\n\
                            <button type='button' class='col-md-3 btn blue' onclick='choose_PO()' id='choose'>Choose</button>\n\
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

  $('#togglecheck').on('click', function() {
    if (this.checked == true) {
      $("input[type=checkbox]").prop('checked', true).uniform();
    } else {
      $("input[type=checkbox]").prop('checked', false).uniform();
    }
  });

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
        // console.log(i)
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
                                        <td nowrap onclick="event.stopPropagation();return false;"><select name="stuffing[]" id="stuffing"><option value="EE" id="EE" onclick="">Export Empty <option value="EL" id="EL">Export Laden <option value="IL" id="IL">Import Laden <option value="IT" id="IT">Import Transhipment <option value="LC" id="LC">Local container <option value="RE" id="RE">Recall container <option value="ELCN" id="ELCN">Export Laden (CN)</select></td>\n\
                                        <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 80px;" name="depot[]" value="' + getText(document.getElementById("tbl-po").rows[i].cells[8]) + '"></td>\n\
                                        <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 80px;" name="pod[]" value="' + getText(document.getElementById("tbl-po").rows[i].cells[9]) + '"></td>\n\
                                        <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 80px;" name="opcode[]" value="' + getText(document.getElementById("tbl-po").rows[i].cells[10]) + '"></td>\n\
                                        <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 100px;" name="etdsin[]" value="' + getText(document.getElementById("tbl-po").rows[i].cells[11]) + '" ></td>\n\
                                        <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 100px;" name="etasin[]" value="' + getText(document.getElementById("tbl-po").rows[i].cells[12]) + '" ></td>\n\
                                        <td hidden><input type="text" class="form-control input-sm" style="width: 150px;" name="container[]" value=""></td>\n\
                                        <td hidden><input type="text" class="form-control input-sm" style="width: 100px;" name="seal[]" value=""></td>\n\
                                        <td hidden><input type="text" class="form-control input-sm" style="width: 100px;" name="actual_seal[]" value=""></td>\n\
                                        <td hidden><input type="text" class="form-control input-sm" style="width: 100px;" name="total_gross_weight[]" value="0"></td>\n\
                                        <td hidden><input type="text" class="form-control input-sm" style="width: 100px;" name="tare_weight[]" value="0"></td>\n\
                                        <td hidden><input type="text" class="form-control input-sm" style="width: 100px;" name="trucking_date[]" value="0"></td>\n\
                                        <td hidden><input type="text" class="form-control input-sm" style="width: 100px;" name="trucking_date_remark[]" value=""></td>\n\
                                        <td hidden><input type="text" class="form-control input-sm text-right" style="width: 80px;" name="weight[]" value="0" onkeypress="return isNumber(event)"></td>\n\
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


  function deletemultiplerow() {

    var checked = $('input[name="chk_delete"]').is(":checked");

    if (checked) {
      if (confirm("Are you sure remove all cheklist row?") == true) {

        var id = "";
        var flag = "";

        $("input[name='chk_delete']:checked").each(function() {
          id += $(this).data('id') + ",";
          flag += $(this).data('flag') + ",";
        });

        id = id.slice(0, -1);
        flag = flag.slice(0, -1);


        $.ajax({
          type: "post",
          url: "<?php echo base_url(); ?>shipping/container_shippping_delete_multiple",
          dataType: "html",
          data: {
            id: id,
            flag: flag,
          },
          beforeSend: function() {
            $(".processing").show();
          },
          success: function(response) {
            location.reload();
          },
          complete: function() {
            $('.processing').hide();
          }
        });
      }
    } else {
      swal("Error", "No Data Selected", 'error');
      return false;
    }

  }

  function changemultiplerow() {

    var checked = $('input[name="chk_move"]').is(":checked");
    var etd = $("#etd").val();

    if (checked) {

      var id = "";
      var flag = "";
      var shipid = "";

      $("input[name='chk_move']:checked").each(function() {
        id += $(this).data('id') + ",";
        flag += $(this).data('flag') + ",";
        shipid += $(this).data('shipid') + ",";
      });

      id = id.slice(0, -1);
      flag = flag.slice(0, -1);
      shipid = shipid.slice(0, -1);


      $url = "<?php echo base_url(); ?>Shipping/get_shipmentdate2";
      $.ajax({
        dataType: "html",
        url: $url,
        data: {
          etd: etd,
          id: id,
          flag: flag,
          shipid: shipid,
        },
        success: function(results) {
          $("#isidisini").html(results);
        },

      });

      $("#formdialogContMove").dialog({
        resizable: false,
        modal: true,
        title: "Change and Move Shipment :",
        height: 180,
        width: 500

      });

    } else {
      swal("Error", "No Data Selected", 'error');
      return false;
    }


    return false;

  }

  function getaksesmultiplerow() {

    var checked = $('input[name="chk_akses"]').is(":checked");
    var etd = $("#etd").val();

    if (checked) {

      if (confirm("Are you sure you give access to changing data to marketing?") == true) {

        var shipid = "";

        $("input[name='chk_akses']:checked").each(function() {
          shipid += $(this).data('shipid') + ",";
        });

        shipid = shipid.slice(0, -1);

        $url = "<?php echo base_url(); ?>Shipping/enable_update_multiple";
        $.ajax({
          dataType: "html",
          url: $url,
          data: {
            shipid: shipid,
          },
          beforeSend: function() {
            $(".processing").show();
          },
          success: function(results) {
            location.reload();
          },
          complete: function() {
            $('.processing').hide();
          }

        });

        cekDtl();
      }

    } else {
      swal("Error", "No Data Selected", 'error');
      return false;
    }

  }

  function flowCargoesmultiplerow() {


    var checked = 0;
    var values = ""
    $("input[name='chk_flowcargoes_akses']:checked").each(function() {
      checked++;
      values += $(this).data('detailid') + "-";
    });

    if (checked == 0) {
      swal("Error", "No Data Selected", 'error');
      return false;
    }

    if (checked > 10) {
      swal("Error", "You can only select 10 data or less than 10 data.", 'error');
      return false;
    }

    swal({
        title: "Are you want to Sync Data Container?",
        text: "It takes a bit of time to synchronize data to flowcargoes, please wait..",
        type: "info",
        showCancelButton: true,
        confirmButtonColor: '#5E87B0',
        confirmButtonText: 'Yes, Sync it!',
        cancelButtonText: "No, cancel it!",
        closeOnConfirm: true,
        closeOnCancel: true,
        // showLoaderOnConfirm: true
      },

      function(isConfirm) {

        if (isConfirm) {
          $.ajax({
            type: "get",
            url: "<?php echo site_url('Shipping/sendto_flowcargoes_bycheck') ?>",
            data: {
              detailid: values,
            },
            dataType: "json",
            beforeSend: function() {
              $.blockUI({
                message: '<img src="../../../zhl/assets/admin/img/container.gif" width="100" ><div><h2>Please wait....<br>Sync in Progress</h2></div>'
              });
            },
            success: function(response, textStatus, xhr) {
              console.log(response);
              if (response.result == 'NO DATA') {
                setTimeout(() => {
                  swal("info", 'No Data to Sync', 'info');
                }, 500);

              } else if (response.result == 'ERROR') {
                setTimeout(() => {
                  swal("info", 'Problem When Sync Data !', 'info');
                }, 500);

              } else {
                setTimeout(() => {
                  swal("success", "Success Sync Data", 'success');
                  location.reload();
                }, 500);

              }
            },
            complete: function() {
              setTimeout(() => {
                $.unblockUI();
              }, 700);

            },
            error: function(err, errors) {
              console.log(err);
              console.log(errors);
            }
          })

        }
      });


    // if (checked) {

    //   if (confirm("Are you sure you closed access to change data to marketing?") == true) {

    //     var shipid = "";

    //     $("input[name='chk_close_akses']:checked").each(function() {
    //       shipid += $(this).data('shipid') + ",";
    //     });

    //     shipid = shipid.slice(0, -1);

    //     $url = "<?php echo base_url(); ?>Shipping/disable_update_multiple";
    //     $.ajax({
    //       dataType: "html",
    //       url: $url,
    //       data: {
    //         shipid: shipid,
    //       },
    //       beforeSend: function() {
    //         $(".processing").show();
    //       },
    //       success: function(results) {
    //         location.reload();
    //       },
    //       complete: function() {
    //         $('.processing').hide();
    //       }

    //     });

    //     cekDtl();
    //   }

    // } else {
    //   alert("No data Selected");
    //   return false;
    // }

  }

  function closeaksesmultiplerow() {

    var checked = $('input[name="chk_close_akses"]').is(":checked");

    if (checked) {

      if (confirm("Are you sure you closed access to change data to marketing?") == true) {

        var shipid = "";

        $("input[name='chk_close_akses']:checked").each(function() {
          shipid += $(this).data('shipid') + ",";
        });

        shipid = shipid.slice(0, -1);

        $url = "<?php echo base_url(); ?>Shipping/disable_update_multiple";
        $.ajax({
          dataType: "html",
          url: $url,
          data: {
            shipid: shipid,
          },
          beforeSend: function() {
            $(".processing").show();
          },
          success: function(results) {
            location.reload();
          },
          complete: function() {
            $('.processing').hide();
          }

        });

        cekDtl();
      }

    } else {
      swal("Error", "No Data Selected", 'error');
      return false;
    }

  }


  function changerow() {

    var val = Array();
    $("input:checkbox[type=checkbox]:checked").each(function() {
      val.push($(this).data('id'));
    });

    console.log(val);

    return false;

    $etd = $("#etd").val();
    var chk_arr = document.getElementsByName("chk_ci[]");
    var vals = "";
    var id = "";
    var flag = "";
    var shipid = "";
    var explode_vals = "";
    var n = chk_arr.length;

    for (var i = 0; i < n; i++) {
      if (chk_arr[i].checked) {

        // EXPLODE VALS
        var explode = chk_arr[i].value.split(":");
      }
    }

    console.log(explode);

    // Count Selected Checkboxes
    var chk_checked = document.querySelectorAll('input[type="checkbox"]:checked');
    var count_checked = chk_checked.length;


    // CHECK WHETHER USER CLICK THE CHECKBOX(s)
    if (count_checked == 0) {
      swal("Error", "No Data Selected", 'error');
    } else {
      var explode_count = explode.length;
      for (var a = 1; a < explode_count; a += 3) {
        id += " " + explode[a];
        var ids = id.split(" ");
      }
      for (var b = 2; b < explode_count; b += 3) {
        flag += " " + explode[b];
        var flags = flag.split(" ");
      }
      for (var c = 3; c < explode_count; c += 3) {
        shipid += " " + explode[c];
        var shipids = shipid.split(" ");
      }
      if (id) id = id.substring(1)
      if (flag) flag = flag.substring(1)
      if (shipid) shipid = shipid.substring(1)


      $url = "<?php echo base_url(); ?>Shipping/get_shipmentdate?etd=" + $etd + "&count=" + count_checked + "&id=" + id + "&flag=" + flag + "&shipid=" + shipid;
      $.ajax({
        dataType: "html",
        url: $url,
        success: function(results) {
          $("#isidisini").html(results);
        },

      });

      $("#formdialogContMove").dialog({
        resizable: false,
        modal: true,
        title: "Change and Move Shipment :",
        height: 180,
        width: 500

      });
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

    $("#tblpo").html('');

    $.ajax({
      url: "<?php echo base_url(); ?>shipping/container_po_outward?po_cout=" + $findpo + "",
      dataType: "html",
      beforeSend: function() {
        $('#loader').show();
      },
      success: function(response) {
        if (response == '') {
          $("#tblpo").html("<tr><td class='text-center' colspan='13'>List Empty</td></tr>");
        } else {
          $("#tblpo").html(response);
        }

      },
      complete: function() {
        $('#loader').hide();
      }
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

  function excel_template(el) {
    $contid = document.getElementById("contid").value;
    $stat = $(el).data('stat');

    javascript: location.href = "<?php echo base_url(); ?>shipping/container_template_excel?cont=" + $contid + "&stat=" + $stat + "";
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
    // console.log($url2);

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
    // console.log($url2);
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
    // console.log($url2);

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

  function changerow_ori(x, y, z) {

    $etd = $("#etd").val();
    var chk_arr = document.getElementsByName("chk_ci[]");

    // var chk_length = 1;

    // alert($chk_arr);

    $url = "<?php echo base_url(); ?>Shipping/get_shipmentdate?etd=" + $etd + "&id=" + x + "&flag=" + y + "&shipid=" + z;
    // console.log($url);
    $.ajax({
      url: $url,
      success: function(results) {
        console.log(results);
        // $isi = "#isi-" + x;
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


  function save_move_multiple() {
    var shipdate = $("#shipdate").val();
    var id = $("#id").val();
    var flag = $("#flag").val();
    var shipid = $("#shipid").val();
    var etd = $("#etd").val();

    if (confirm("Are you sure move this Shipment?") == true) {
      var url = "<?php echo base_url(); ?>shipping/container_inward_move_multiple";

      $.ajax({
        url: url,
        data: {
          id: id,
          flag: flag,
          shipid: shipid,
          shipdate: shipdate,
          etd: etd,
        },
        success: function(response) {
          location.reload();
        },
        dataType: "html"
      });
    }
    close_formdialogContMove()
    return false;
  }

  function save_move_ori() {
    $shipdate = $("#shipdate").val();
    $id = $("#id1").val();
    $flag = $("#id2").val();
    $etd = $("#etd").val();
    $shipid = $("#shipid").val();


    if (confirm("Are you sure move this Shipment?") == true) {
      $url2 = "<?php echo base_url(); ?>shipping/container_inward_move?shipdate=" + $shipdate + "&id=" + $id + "&flag=" + $flag + "&et=" + $etd + "&shipid=" + $shipid;
      // $url2 = "<?php echo base_url(); ?>shipping/container_inward_move?shipdate=" + shipdate + "&outward=" + y + "&inward=" + x;
      // console.log($url2);

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

  function hitung_amount() {
    var gross = document.getElementsByClassName('gross');
    var tare = document.getElementsByClassName('tare');
    var weight = document.getElementsByClassName('weight');

    for (var i = 0; i < gross.length; i++) {
      gross[i].value = gross[i].value.replace(",", "");
      tare[i].value = tare[i].value.replace(",", "");
      var utkAmount = parseFloat(gross[i].value) + parseFloat(tare[i].value);
    }
  } // weight[i].value=utkAmount.toFixed(4); weight[i].value=utkAmount; console.log(weight[i].value); } }


  // Container Outward

  function saveOutwardList() {

    swal({
        title: "Are you sure?",
        text: "You will not be able to recover this data !",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: '#DD6B55',
        confirmButtonText: 'Yes, save it!',
        cancelButtonText: "No, cancel it!",
        closeOnConfirm: false,
        closeOnCancel: true,
        // showLoaderOnConfirm: true
      },
      function(isConfirm) {

        if (isConfirm) {
          $.ajax({
            type: "post",
            url: "<?php echo site_url('Shipping/save_ship_to_outward') ?>",
            data: $('.ship-to-outward').serialize(),
            dataType: "JSON",
            beforeSend: function() {
              sambu.startPageLoading()
              $(".btn-f-refresh").prop("disabled", true)
            },
            success: function(response) {
              console.log(response)
              setTimeout(() => {
                sambu.stopPageLoading();
                $('.loadReport').html(response);
                $(".btn-f-refresh").prop("disabled", false)
                if (response.code == 200) {
                  swal("success", "" + response.message + "", 'success')
                  window.location.href = "<?= base_url() ?>shipping/container_show?cont=" + response.message + "&tipe=2";

                } else {
                  swal("Error", "" + response.message + "", 'error')
                }
              }, 2000);
            },
            error: function(err, errors) {
              console.log(err);
              console.log(errors);
            }
          })

        } else {
          swal("Cancelled", "Ship To Inward List", "error");
        }
      });
  }

  function shipToOutward(contid) {
    $('.modal-outward').modal('show')
    $.ajax({
      type: "post",
      url: "<?= base_url("shipping/getContainerLocalInward") ?>",
      data: {
        contid: contid
      },
      dataType: "html",
      success: function(response) {
        // console.log(response);
      }
    });
  }


  $(document).ready(function() {
    $(".datatables-search").dataTable({
      "sScrollX": "200%", //This is what made my columns increase in size.
      "bScrollCollapse": true,
      //			"sScrollY": "500px",
      "autoWidth": false
    });
  });

  function dialogflowcharges(id) {

    var exp = id.split("//");

    swal({
        title: "Are you want to Sync Data?",
        text: "This Container No " + exp[0] + " Will be sync to Flowcharges",
        type: "info",
        showCancelButton: true,
        confirmButtonColor: '#5E87B0 ',
        confirmButtonText: 'Yes, Sync it!',
        cancelButtonText: "No, cancel it!",
        closeOnConfirm: true,
        closeOnCancel: true,
        // showLoaderOnConfirm: true
      },

      function(isConfirm) {

        if (isConfirm) {
          $.ajax({
            type: "get",
            url: "<?php echo site_url('Shipping/sendto_flowcharges') ?>",
            data: {
              id: exp[1],
            },
            dataType: "json",
            beforeSend: function() {
              sambu.startPageLoading()
            },
            success: function(response, textStatus, xhr) {
              setTimeout(() => {
                sambu.stopPageLoading();
                if (xhr.status == 200 && response.result == 'SUCCESS') {
                  swal("success", "" + response.message + "", 'success');
                  var html = '  <span class="badge badge-primary">Has Sync to Flowcargoes</span>';
                  $('#flow-status-' + exp[1]).html(html);
                  // window.location.href = "<?= base_url() ?>shipping/container_show?cont=1827&tipe=2";
                } else {
                  swal("Error", "Failed sync to Flowcargoes" + response.message, 'error')
                }
              }, 100);
            },
            error: function(err, errors) {
              console.log(err);
              console.log(errors);
            }
          })

        }
      });


    // $.ajax({
    //     url: "<?= site_url('shipping/container_inward_data') ?>",
    //     method: "get",
    //     data: {
    //         id: id,
    //     },
    //     dataType: "html",
    //     success: function(response) {
    //         $('#isi_flowcharges').html(response);
    //         $("#formdialogFlowCharges").dialog({
    //             resizable: false,
    //             modal: true,
    //             title: "Container Data Sync to Flow Charges",
    //             height: 250,
    //             width: 800
    //         });
    //     }
    // });
    // filterContainerLocal();
  }

  // $("#btnShipToOutward").click(function() {
  //     $('.modal-outward').modal('show')

  //     $.ajax({
  //         type: "post",
  //         url: "<?= base_url() ?>",
  //         data: {
  //             contid: contid
  //         },
  //         dataType: "dataType",
  //         success: function(response) {

  //         }
  //     });
  // });

  // End Container Outward

  function syncAllFlowCargoes(contid) {
    swal({
        title: "Are you want to Sync Data Container?",
        text: "It takes a bit of time to synchronize data to flowcargoes, please wait.",
        type: "info",
        showCancelButton: true,
        confirmButtonColor: '#5E87B0',
        confirmButtonText: 'Yes, Sync it!',
        cancelButtonText: "No, cancel it!",
        closeOnConfirm: true,
        closeOnCancel: true,
        // showLoaderOnConfirm: true
      },

      function(isConfirm) {

        if (isConfirm) {
          $.ajax({
            type: "get",
            url: "<?php echo site_url('Shipping/sendto_flowcargoes_all') ?>",
            data: {
              contid: contid,
            },
            dataType: "json",
            beforeSend: function() {
              $.blockUI({
                message: '<img src="../../../zhl/assets/admin/img/container.gif" width="100" ><div><h2>Please wait....<br>Sync in Progress</h2></div>'
              });
            },
            success: function(response, textStatus, xhr) {
              // console.log(response);
              if (response.result == 'NO DATA') {
                setTimeout(() => {
                  swal("info", 'No Data to Sync', 'info');
                }, 500);

              } else if (response.result == 'ERROR') {
                setTimeout(() => {
                  swal("info", 'Problem When Sync Data !', 'info');
                }, 500);

              } else {
                setTimeout(() => {
                  swal("success", "Success Sync Data", 'success');
                  location.reload();
                }, 500);

              }
              // setTimeout(() => {
              //   sambu.stopPageLoading();
              //   if (xhr.status == 200 && response.result == 'SUCCESS') {
              //     swal("success", "" + response.message + "", 'success');
              //     var html = '  <span class="badge badge-primary">Has Sync to Flowcargoes</span>';
              //     $('#flow-status-' + exp[1]).html(html);
              //     // window.location.href = "<?= base_url() ?>shipping/container_show?cont=1827&tipe=2";
              //   } else {
              //     swal("Error", "Failed sync to Flowcargoes" + response.message, 'error')
              //   }
              // }, 100);
            },
            complete: function() {
              setTimeout(() => {
                $.unblockUI();
              }, 700);

            },
            error: function(err, errors) {
              console.log(err);
              console.log(errors);
            }
          })

        }
      });
  }
</script>
<script>
  function fnDialogPO_ggfs() {
    $("#formdialogPO_ggfs").html(" <div class='portlet-body'>\n\
                        <div class='col-md-12 mb-2'>\n\
                            <div class='form-group'>\n\
                                 <label class='col-md-1 label-sm'>Find</label>\n\
                                 <div class='col-md-7'>\n\
                                        <input class='form-control input-sm' id='findpo_ggfs'>\n\
                                 </div>\n\
                                 <button type='button' class='col-md-2 btn blue' onclick='filterpo_ggfs()'>Search</button>\n\
                            </div>\n\
                        </div>\n\
                        \n\
                        <div class='table-scrollable' style='overflow: auto; height:300px;'>\n\
                            <table id='tbl-po_ggfs' class='table table-bordered'>\n\
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
                                <tbody id='tblpo_ggfs'>\n\
                                </tbody>\n\
                            </table>\n\
                            <div class='text-center' style='display:none' id='loader'>\n\
                                  <h2><i class='fa fa-spinner fa fa-spin'></i></h2>\n\
                                 <p>Loading...</p>\n\
                                </div>\n\
                        </div>\n\
                        <div class='col-md-6'>\n\
                            <button type='button' class='col-md-3 btn blue' onclick='choose_PO_ggfs()' id='choose'>Choose</button>\n\
                        </div>\n\
                </div>");

    // Define the Dialog and its properties.
    $("#formdialogPO_ggfs").dialog({
      resizable: false,
      modal: true,
      title: "GGFS List PO",
      height: 500,
      width: 800

    });
  }

  function close_PO_ggfs() {
    $("#formdialogPO_ggfs").dialog("close");
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
                                        <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 110px;" name="po_ggfs[]" value="' + getText(document.getElementById("tbl-po_ggfs").rows[i].cells[1]) + '" disabled></td>\n\
                                        <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 110px;" name="carrier_ggfs[]" value="' + getText(document.getElementById("tbl-po_ggfs").rows[i].cells[2]) + '"></td>\n\
                                        <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 110px;" name="fcl_ggfs[]" value="' + getText(document.getElementById("tbl-po_ggfs").rows[i].cells[3]) + '" disabled></td>\n\
                                        <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 150px;" name="final_ggfs[]" value="' + getText(document.getElementById("tbl-po_ggfs").rows[i].cells[4]) + '" ></td>\n\
                                        <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 150px;" name="reff_ggfs[]" value="' + getText(document.getElementById("tbl-po_ggfs").rows[i].cells[5]) + '"></td>\n\
                                        <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 150px;" name="vessel_ggfs[]" value="' + getText(document.getElementById("tbl-po_ggfs").rows[i].cells[6]) + '"></td>\n\
                                        <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 150px;" name="convessel_ggfs[]" value="' + getText(document.getElementById("tbl-po_ggfs").rows[i].cells[7]) + '"></td>\n\
                                        <td nowrap onclick="event.stopPropagation();return false;"><select name="stuffing_ggfs[]" id="stuffing"><option value="EE" id="EE" onclick="">Export Empty <option value="EL" id="EL">Export Laden <option value="IL" id="IL">Import Laden <option value="IT" id="IT">Import Transhipment <option value="LC" id="LC">Local container <option value="RE" id="RE">Recall container <option value="ELCN" id="ELCN">Export Laden (CN)</select></td>\n\
                                        <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 80px;" name="depot_ggfs[]" value="' + getText(document.getElementById("tbl-po_ggfs").rows[i].cells[8]) + '"></td>\n\
                                        <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 80px;" name="pod_ggfs[]" value="' + getText(document.getElementById("tbl-po_ggfs").rows[i].cells[9]) + '"></td>\n\
                                        <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 80px;" name="opcode_ggfs[]" value="' + getText(document.getElementById("tbl-po_ggfs").rows[i].cells[10]) + '"></td>\n\
                                        <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 100px;" name="etdsin_ggfs[]" value="' + getText(document.getElementById("tbl-po_ggfs").rows[i].cells[11]) + '" ></td>\n\
                                        <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 100px;" name="etasin_ggfs[]" value="' + getText(document.getElementById("tbl-po_ggfs").rows[i].cells[12]) + '" ></td>\n\
                                        <td hidden><input type="text" class="form-control input-sm" style="width: 150px;" name="container_ggfs[]" value=""></td>\n\
                                        <td hidden><input type="text" class="form-control input-sm" style="width: 100px;" name="seal_ggfs[]" value=""></td>\n\
                                        <td hidden><input type="text" class="form-control input-sm" style="width: 100px;" name="actual_seal_ggfs[]" value=""></td>\n\
                                        <td hidden><input type="text" class="form-control input-sm" style="width: 100px;" name="total_gross_weight_ggfs[]" value="0"></td>\n\
                                        <td hidden><input type="text" class="form-control input-sm" style="width: 100px;" name="tare_weight_ggfs[]" value="0"></td>\n\
                                        <td hidden><input type="text" class="form-control input-sm" style="width: 100px;" name="trucking_date_ggfs[]" value="0"></td>\n\
                                        <td hidden><input type="text" class="form-control input-sm" style="width: 100px;" name="trucking_date_remark_ggfs[]" value=""></td>\n\
                                        <td hidden><input type="text" class="form-control input-sm text-right" style="width: 80px;" name="weight_ggfs[]" value="0" onkeypress="return isNumber(event)"></td>\n\
                                        <td hidden><input type="text" class="form-control input-sm" name="shipid_ggfs[]" value="' + getText(document.getElementById("tbl-po_ggfs").rows[i].cells[13]) + '"></td>\n\
                                        <td hidden><input type="text" class="form-control input-sm" name="outward_ggfs[]" value="' + getText(document.getElementById("tbl-po_ggfs").rows[i].cells[14]) + '"></td>\n\
                                        <td hidden><input type="text" class="form-control input-sm" name="id_ggfs[]" value="0"></td>\n\
                                </tr>');

        //                $new_row.find('.date').datepicker();

        $('table[id="tblList_ggfs"]').append($new_row);
      }
      i++;
    }

    $("#formdialogPO_ggfs").dialog("close");
    cekDtl_ggfs();
  }

  function deletemultiplerow_ggfs() {

    var checked = $('input[name="chk_delete_ggfs"]').is(":checked");

    if (checked) {
      if (confirm("Are you sure remove all cheklist row?") == true) {

        var id = "";
        var flag = "";

        $("input[name='chk_delete_ggfs']:checked").each(function() {
          id += $(this).data('id') + ",";
          flag += $(this).data('flag') + ",";
        });

        id = id.slice(0, -1);
        flag = flag.slice(0, -1);


        $.ajax({
          type: "post",
          url: "<?php echo base_url(); ?>shipping/container_shippping_delete_multiple_ggfs",
          dataType: "html",
          data: {
            id: id,
            flag: flag,
          },
          beforeSend: function() {
            $(".processing").show();
          },
          success: function(response) {
            location.reload();
          },
          complete: function() {
            $('.processing').hide();
          }
        });
      }
    } else {
      swal("Error", "No Data Selected", 'error');
      return false;
    }

  }

  function changemultiplerow_ggfs() {

    var checked = $('input[name="chk_move_ggfs"]').is(":checked");
    var etd = $("#etd").val();

    if (checked) {

      var id = "";
      var flag = "";
      var shipid = "";
      var desc = "";

      $("input[name='chk_move_ggfs']:checked").each(function() {
        id += $(this).data('id') + ",";
        flag += $(this).data('flag') + ",";
        shipid += $(this).data('shipid') + ",";
        desc += $(this).data('desc') + ",";
      });

      id = id.slice(0, -1);
      flag = flag.slice(0, -1);
      shipid = shipid.slice(0, -1);
      desc = desc.slice(0, -1);
      console.log(id, flag, shipid, etd, desc);

      $url = "<?php echo base_url(); ?>Shipping/get_shipmentdate2";
      $.ajax({
        dataType: "html",
        url: $url,
        data: {
          etd: etd,
          id: id,
          flag: flag,
          shipid: shipid,
          desc: desc
        },
        success: function(results) {
          $("#isidisini").html(results);
        },

      });

      $("#formdialogContMove").dialog({
        resizable: false,
        modal: true,
        title: "Change and Move Shipment :",
        height: 180,
        width: 500

      });

    } else {
      swal("Error", "No Data Selected", 'error');
      return false;
    }


    return false;

  }

  function getaksesmultiplerow_ggfs() {

    var checked = $('input[name="chk_akses_ggfs"]').is(":checked");
    var etd = $("#etd").val();

    if (checked) {

      if (confirm("Are you sure you give access to changing data to marketing?") == true) {

        var shipid = "";

        $("input[name='chk_akses_ggfs']:checked").each(function() {
          shipid += $(this).data('shipid') + ",";
        });

        shipid = shipid.slice(0, -1);

        $url = "<?php echo base_url(); ?>Shipping/enable_update_multiple_ggfs";
        $.ajax({
          dataType: "html",
          url: $url,
          data: {
            shipid: shipid,
          },
          beforeSend: function() {
            $(".processing").show();
          },
          success: function(results) {
            location.reload();
          },
          complete: function() {
            $('.processing').hide();
          }

        });

        cekDtl_ggfs();
      }

    } else {
      swal("Error", "No Data Selected", 'error');
      return false;
    }

  }

  function flowCargoesmultiplerow_ggfs() {
    var checked = 0;
    var values = ""
    $("input[name='chk_flowcargoes_akses_ggfs']:checked").each(function() {
      checked++;
      values += $(this).data('detailid') + "-";
    });

    if (checked == 0) {
      swal("Error", "No Data Selected", 'error');
      return false;
    }

    if (checked > 10) {
      swal("Error", "You can only select 10 data or less than 10 data.", 'error');
      return false;
    }

    swal({
        title: "Are you want to Sync Data Container?",
        text: "It takes a bit of time to synchronize data to flowcargoes, please wait..",
        type: "info",
        showCancelButton: true,
        confirmButtonColor: '#5E87B0',
        confirmButtonText: 'Yes, Sync it!',
        cancelButtonText: "No, cancel it!",
        closeOnConfirm: true,
        closeOnCancel: true,
        // showLoaderOnConfirm: true
      },

      function(isConfirm) {

        if (isConfirm) {
          $.ajax({
            type: "get",
            url: "<?php echo site_url('Shipping/sendto_flowcargoes_bycheck_ggfs') ?>",
            data: {
              detailid: values,
            },
            dataType: "json",
            beforeSend: function() {
              $.blockUI({
                message: '<img src="../../../zhl/assets/admin/img/container.gif" width="100" ><div><h2>Please wait....<br>Sync in Progress</h2></div>'
              });
            },
            success: function(response, textStatus, xhr) {
              console.log(response);
              if (response.result == 'NO DATA') {
                setTimeout(() => {
                  swal("info", 'No Data to Sync', 'info');
                }, 500);

              } else if (response.result == 'ERROR') {
                setTimeout(() => {
                  swal("info", 'Problem When Sync Data !', 'info');
                }, 500);

              } else {
                setTimeout(() => {
                  swal("success", "Success Sync Data", 'success');
                  location.reload();
                }, 500);

              }
            },
            complete: function() {
              setTimeout(() => {
                $.unblockUI();
              }, 700);

            },
            error: function(err, errors) {
              console.log(err);
              console.log(errors);
            }
          })

        }
      });
  }

  function closeaksesmultiplerow_ggfs() {

    var checked = $('input[name="chk_close_akses_ggfs"]').is(":checked");

    if (checked) {

      if (confirm("Are you sure you closed access to change data to marketing?") == true) {

        var shipid = "";

        $("input[name='chk_close_akses_ggfs']:checked").each(function() {
          shipid += $(this).data('shipid') + ",";
        });

        shipid = shipid.slice(0, -1);

        $url = "<?php echo base_url(); ?>Shipping/disable_update_multiple_ggfs";
        $.ajax({
          dataType: "html",
          url: $url,
          data: {
            shipid: shipid,
          },
          beforeSend: function() {
            $(".processing").show();
          },
          success: function(results) {
            location.reload();
          },
          complete: function() {
            $('.processing').hide();
          }

        });

        cekDtl();
      }

    } else {
      swal("Error", "No Data Selected", 'error');
      return false;
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
    $findpo = document.getElementById("findpo_ggfs").value;

    $("#tblpo_ggfs").html('');

    $.ajax({
      url: "<?php echo base_url(); ?>shipping/container_po_outward_ggfs?po_cout=" + $findpo + "",
      dataType: "html",
      beforeSend: function() {
        $('#loader').show();
      },
      success: function(response) {
        if (response == '') {
          $("#tblpo_ggfs").html("<tr><td class='text-center' colspan='13'>List Empty</td></tr>");
        } else {
          $("#tblpo_ggfs").html(response);
        }

      },
      complete: function() {
        $('#loader').hide();
      }
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

    if (confirm("Are you sure you give access to changing data to marketing?") == true) {

      $.ajax({
        url: "<?php echo base_url(); ?>shipping/enable_update_ggfs?shipid=" + y,
        success: function(response) {
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

  function syncAllFlowCargoes_ggfs(contid) {
    swal({
        title: "Are you want to Sync Data Container?",
        text: "It takes a bit of time to synchronize data to flowcargoes, please wait.",
        type: "info",
        showCancelButton: true,
        confirmButtonColor: '#5E87B0',
        confirmButtonText: 'Yes, Sync it!',
        cancelButtonText: "No, cancel it!",
        closeOnConfirm: true,
        closeOnCancel: true,
        // showLoaderOnConfirm: true
      },

      function(isConfirm) {

        if (isConfirm) {
          $.ajax({
            type: "get",
            url: "<?php echo site_url('Shipping/sendto_flowcargoes_all_ggfs') ?>",
            data: {
              contid: contid,
            },
            dataType: "json",
            beforeSend: function() {
              $.blockUI({
                message: '<img src="../../../zhl/assets/admin/img/container.gif" width="100" ><div><h2>Please wait....<br>Sync in Progress</h2></div>'
              });
            },
            success: function(response, textStatus, xhr) {
              if (response.result == 'NO DATA') {
                setTimeout(() => {
                  swal("info", 'No Data to Sync', 'info');
                }, 500);

              } else if (response.result == 'ERROR') {
                setTimeout(() => {
                  swal("info", 'Problem When Sync Data !', 'info');
                }, 500);

              } else {
                setTimeout(() => {
                  swal("success", "Success Sync Data", 'success');
                  location.reload();
                }, 500);

              }
            },
            complete: function() {
              setTimeout(() => {
                $.unblockUI();
              }, 700);

            },
            error: function(err, errors) {
              console.log(err);
              console.log(errors);
            }
          })

        }
      });
  }
</script>