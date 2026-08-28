<?php
$cont = json_decode(json_encode($cont));
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
  $to = $r->to;
  $from =  $r->from;
  $remarks =  $r->remarks;
  $factory_id = $r->factory_id;
  $flag =  $r->flag;
  $actual_seal = $r->actual_seal;
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

<?php
if (!empty($cont)) {
  foreach ($cont as $r) {
    $shipment =  date("d-m-Y",  strtotime($r->shipmentdate));
    $barge =  $r->barge;
    $remarks =  $r->remarks;
  }
} else {
  $shipment =  "";
  $barge =  "";
  $remarks =  "";
}

?>


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
              <span class="caption-subject theme-font bold">Container Inward (Actual Seal)</span>
            </div>
          </div>
          <div class="portlet-body form">
            <form action="<?php echo site_url('shipping/container_actual_seal_save'); ?>" method="post" class="form-horizontal">
              <div class="form-body">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group" style="margin-bottom:1px;">
                      <label class="col-md-3 label-sm" readonly>Tipe</label>
                      <div class="col-md-3">
                        <select class="form-control select2me" name="tipe" readonly>
                          <option value="2">Container Inward</option>
                        </select>
                      </div>
                    </div>
                    <div class="form-group" style="margin-bottom:1px;">
                      <label class="col-md-3 label-sm" readonly>Shipment Date</label>
                      <div class="col-md-3">
                        <input class="form-control input-sm date date-picker" name="shipdate" data-date="02-12-2012" data-date-format="dd-mm-yyyy" value="<?php echo $shipment; ?>" required readonly>
                        <input class="form-control input-sm" name="contid" id="contid" value="<?php echo $contid; ?>" type="hidden">
                        <input class="form-control input-sm" name="tipe1" id="tipe1" value="" type="hidden">
                      </div>
                    </div>
                    <div class="form-group" style="margin-bottom:1px;">
                      <label class="col-md-3 label-sm" readonly>Vessel (Barge)</label>
                      <div class="col-md-5">
                        <input class="form-control input-sm" name="barge" value="<?php echo $barge; ?>" readonly>
                      </div>
                    </div>
                    <div class="form-group" style="margin-bottom:1px;">
                      <label class="col-md-3 label-sm" readonly>Voyage</label>
                      <div class="col-md-5">
                        <input class="form-control input-sm" name="voyage" value="<?php echo $voyage; ?>" readonly>
                      </div>
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group" style="margin-bottom:1px;">
                      <label class="col-md-2 label-sm">ETD</label>
                      <div class="col-md-7">
                        <div class="input-group">
                          <select name="etd" class="form-control input-sm" id="etd">
                            <option id="RSUP" value="RSUP" <?php if ($r->etd === "RSUP") {
                                                              echo 'selected';
                                                            } ?>>Riau Sakti United Plantation
                            <option id="PSG" value="PSG" <?php if ($r->etd === "PSG") {
                                                            echo 'selected';
                                                          } ?>>Pulau Sambu Guntung
                          </select>
                          <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                          <input class="form-control input-sm date date-picker" placeholder="ETD Date" name="etddate" data-date="02-12-2012" data-date-format="dd-mm-yyyy" value="<?php echo $etddate; ?>" readonly>
                        </div>
                      </div>
                    </div>
                    <div class="form-group" style="margin-bottom:1px;">
                      <label class="col-md-2 label-sm">ETA</label>
                      <div class="col-md-7">
                        <div class="input-group">
                          <input class="form-control input-sm" placeholder="ETA" name="eta" value="SINGAPORE" readonly="">
                          <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                          <input class="form-control input-sm date date-picker" placeholder="ETA Date" name="etadate" data-date="02-12-2012" data-date-format="dd-mm-yyyy" value="<?php echo $etadate; ?>" readonly>
                        </div>
                      </div>
                    </div>
                    <div class="form-group" style="margin-bottom:1px;">
                      <label class="col-md-2 label-sm">To</label>
                      <div class="col-md-7">
                        <input class="form-control input-sm" name="to" value="<?php echo $to; ?>" readonly>
                      </div>
                    </div>
                    <div class="form-group" style="margin-bottom:1px;">
                      <label class="col-md-2 label-sm">From</label>
                      <div class="col-md-7">
                        <input class="form-control input-sm" name="from" value="<?php echo $from; ?>" readonly>
                      </div>
                    </div>
                    <div class="form-group" style="margin-bottom:1px;display: none;">
                      <label class="col-md-2 label-sm">Amendment</label>
                      <div class="col-md-4">
                        <input class="form-control input-sm date date-picker" name="amendmentdate" data-date="02-12-2012" data-date-format="dd-mm-yyyy" value="">
                      </div>
                    </div>
                  </div>
                </div>

                <hr>


                <div class=doc-scroll style="height: 600px;">
                  <table class="table table-bordered" id="tblList">
                    <thead>
                      <tr style="position: sticky; top: -5px; z-index:100;">
                        <th style="background-color: #779ebf;" nowrap>Seq No</th>
                        <th style="position: sticky; left: -8px;  background-color: #779ebf; z-index:0; " nowrap>PO Number</th>
                        <th hidden style="background-color: #bac9d6;" nowrap>Shipper/Carrier</th>
                        <th hidden style="background-color: #bac9d6;" nowrap>FCL</th>
                        <th hidden style="background-color: #bac9d6;" nowrap>Destination</th>
                        <th hidden style="background-color: #bac9d6;" nowrap>Booking Ref</th>
                        <th hidden style="background-color: #bac9d6;" nowrap>Vessel/Voyage</th>
                        <th hidden style="background-color: #bac9d6;" nowrap>Connecting Vessel</th>
                        <th hidden style="background-color: #bac9d6;" nowrap>Stuffing</th>
                        <th hidden style="background-color: #bac9d6;" nowrap>Depot</th>
                        <th hidden style="background-color: #bac9d6;" nowrap>POD</th>
                        <th hidden style="background-color: #bac9d6;" nowrap>OP Code</th>
                        <th hidden style="background-color: #bac9d6;" nowrap>ETD Sin</th>
                        <th style="background-color: #779ebf;" nowrap>Container </th>
                        <th style="background-color: #779ebf;" nowrap>Seal</th>
                        <th style="background-color: #779ebf;" nowrap>Actual Seal</th>
                        <th style="background-color: #779ebf;" nowrap>Actual Seal Factory</th>
                        <th style="background-color: #779ebf;" nowrap>Sample</th>
                        <th hidden style="background-color: #bac9d6;" nowrap>Weight</th>
                        <th hidden style="background-color: #bac9d6;" nowrap>ETA</th>
                        <th style="background-color: #779ebf;" nowrap>GrossWeight</th>
                        <th style="background-color: #779ebf;" nowrap>ContainerWeight</th>
                        <th style="background-color: #779ebf;" nowrap>OtherWeight</th>
                        <th style="background-color: #779ebf;" nowrap>TotalGross</th>
                        <th style="background-color: #779ebf;" nowrap>REMARK Factory</th>
                      </tr>
                    </thead>
                    <tbody id="tblList_1">
                      <?php
                      $i = 0;
                      foreach ($cont as $r) {
                        $act_seal = $r->act_seal->SealNumber;
                        $GrossWeight = $r->act_seal->GrossWeight;
                        $ContainerWeight = $r->act_seal->ContainerWeight;
                        $OtherWeight = $r->act_seal->OtherWeight;
                        $TotalGross = $r->act_seal->TotalGross;
                        $POREMARK = $r->act_seal->POREMARK;
                        $ContainerNumber = $r->act_seal->ContainerNumber;

                        $weight1 = $r->weight + $r->sample;
                      ?>

                        <tr>
                          <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 50px;" name="urut[]" value="<?php echo $r->urut; ?>" readonly></td>
                          <td style="position: sticky; left: -8px;   z-index:0;" nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 110px;" name="po[]" value="<?php echo $r->po_number; ?>" readonly></td>
                          <!-- <td hidden nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 110px;" name="carrier[]" value="<?php echo $r->shipping_liner; ?>" readonly></td>
                                                    <td  hidden nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 110px;" name="fcl[]" value="<?php echo $r->container_name; ?>" readonly></td>
                                                    <td hidden nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 150px;" name="final[]" value="<?php echo $r->destination; ?>" readonly></td>
                                                    <td hidden nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 150px;" name="reff[]" value="<?php echo $r->reff; ?>" readonly></td>
                                                    <td hidden nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 150px;" name="vessel[]" value="<?php echo $r->vessel; ?>" readonly></td>
                                                    <td hidden nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 200px;" name="convessel[]" value="<?php echo $r->convessel; ?>" readonly></td> -->
                          <!-- <td hidden nowrap onclick="event.stopPropagation();return false;">
                                                    <input type="text" class="form-control input-sm" style="width: 200px;" name="stuffing[]" value="<?php
                                                                                                                                                    if ($r->stuffing === "EE") {
                                                                                                                                                      echo "Export Empty";
                                                                                                                                                    } elseif ($r->stuffing === "EL") {
                                                                                                                                                      echo "Export Laden";
                                                                                                                                                    } elseif ($r->stuffing === "IL") {
                                                                                                                                                      echo "Import Laden";
                                                                                                                                                    } elseif ($r->stuffing === "IT") {
                                                                                                                                                      echo "Import Transhipment";
                                                                                                                                                    } else {
                                                                                                                                                      echo "Local Container";
                                                                                                                                                    }
                                                                                                                                                    ?>" readonly>
                                                    </td>
                                                    <td hidden nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 80px;" name="depot[]" value="<?php echo $r->depot; ?>" readonly></td>
                                                    <td hidden nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 80px;" name="pod[]" value="<?php echo $r->pod; ?>" readonly></td>
                                                    <td hidden nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 80px;" name="opcode[]" value="<?php echo $r->opcode; ?>" readonly></td>
                                                    <td hidden nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 100px;" name="etdsin[]" value="<?php echo $r->etdsin; ?>" readonly></td> -->
                          <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 150px;" name="container[]" value="<?php echo $ContainerNumber; ?>"></td>

                          <!-- <?php
                                if ($r->proses == 1) {
                                ?>
                                                            <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 150px;" name="container[]" id="ci" value="<?php echo $ContainerNumber; ?>" readonly=""></td>
                                                            <?php
                                                          } else {
                                                            ?>
                                                            <td nowrap onclick="event.stopPropagation();return false;"><input ondblclick="fnDialogContainerChange(<?= $r->detail_id; ?>, <?php echo "'" . $r->container . "'"; ?>)" type="text" class="form-control input-sm" style="width: 150px;" name="container[]" id="ci-<?= $r->detail_id; ?>" value="<?php echo $r->container; ?>" readonly=""></td>
                                                            <?php
                                                          }
                                                            ?> -->

                          <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 100px;" name="seal[]" value="<?php echo $r->seal; ?>" readonly></td>
                          <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 120px;" name="actual_sealin[]" value="<?php echo $r->actual_seal; ?>"></td>

                          <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 120px;" name="actual_seal[]" value="<?php echo $act_seal; ?>"></td>
                          <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm text-right" style="width: 80px;" name="sample[]" value="<?php echo $r->sample; ?>" onkeypress="return isNumber(event)"></td>
                          <td hidden nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm text-right" style="width: 80px;" name="weight[]" value="<?php echo number_format($weight1, 4, ",", "."); ?>" onkeypress="return isNumber(event)" readonly></td>
                          <td hidden nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 100px;" name="etasin[]" value="<?php echo $r->etasin; ?>" readonly></td>
                          <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 100px;" name="GrossWeight[]" value="<?php echo $GrossWeight; ?>"></td>
                          <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 100px;" name="ContainerWeight[]" value="<?php echo $ContainerWeight; ?>"></td>
                          <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 100px;" name="OtherWeight[]" value="<?php echo $OtherWeight; ?>"></td>
                          <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 100px;" name="TotalGross[]" value="<?php echo $TotalGross; ?>"></td>

                          <td nowrap onclick="event.stopPropagation();return false;"><textarea rows="2" cols="50" name="poremark[]"> <?php echo $POREMARK; ?></textarea></td>
                          <td hidden><input type="text" class="form-control input-sm" name="shipid[]" value="<?php echo $r->shipid; ?>"></td>
                          <td hidden><input type="text" class="form-control input-sm" name="outward[]" value="<?php echo $r->id;; ?>"></td>
                          <td hidden><input type="text" class="form-control input-sm" name="id[]" value="<?php echo $r->id;; ?>"></td>
                        </tr>
                      <?php $i++;
                      }  ?>
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
                      <textarea rows="3" class="form-control autosizeme" name="remarks" readonly><?php echo str_replace("<br />", "", $remarks); ?></textarea>
                    </div>
                  </div>
                </div>
              </div>

              <div class="form-actions">
                <div class="col-md-6">
                  <button type="submit" class="col-md-2 btn btn-primary" id="btn-update">Import to Inward</button>
                  <a type="button" class="col-md-2 btn btn-default" href="<?php echo site_url('shipping/container_actual_seal'); ?>">Cancel</a>
                </div>
                <div class="col-md-6">
                </div>
              </div>
          </div>
          </form>
        </div>
      </div>
      <div id="modal_delete" class="modal fade bs-modal-lg" role="dialog" tabindex="-1" data-backdrop="static" data-keyboard="false" aria-hidden="true"></div>
    </div>
  </div>
</div>
</div>
<div id="modal_delete" class="modal fade bs-modal-lg" role="dialog" tabindex="-1" data-backdrop="static" data-keyboard="false" aria-hidden="true"></div>
</div>
</div>
</div>
</div>