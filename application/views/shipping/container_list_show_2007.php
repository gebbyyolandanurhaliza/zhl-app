<?php
$proses = '0';
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
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group" style="margin-bottom:1px;">
                      <label class="col-md-3 label-sm">Tipe</label>
                      <div class="col-md-3">
                        <select class="form-control select2me" name="tipe">
                          <option value="1">Container Outward</option>
                        </select>
                      </div>
                    </div>
                    <div class="form-group" style="margin-bottom:1px;">
                      <label class="col-md-3 label-sm">Shipment Date</label>
                      <div class="col-md-3">
                        <input class="form-control input-sm date date-picker" name="shipdate" data-date="02-12-2012" data-date-format="dd-mm-yyyy" value="<?php echo $shipment; ?>" required>
                        <input class="form-control input-sm" name="contid" id="contid" value="<?php echo $contid; ?>" type="hidden">
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
                          <input class="form-control input-sm" name="etd" value="<?php echo $etd; ?>" readonly>
                          <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                          <input class="form-control input-sm date date-picker" placeholder="ETD Date" name="etddate" data-date="02-12-2012" data-date-format="dd-mm-yyyy" value="<?php echo $etddate; ?>">
                        </div>
                      </div>
                    </div>
                    <div class="form-group" style="margin-bottom:1px;">
                      <label class="col-md-2 label-sm">ETA</label>
                      <div class="col-md-7">
                        <div class="input-group">
                          <!-- <input class="form-control input-sm" name="eta" value="<?php echo $eta; ?>"> -->
                          <select name="eta" class="form-control input-sm">
                            <option id="RSUP" value="RSUP" <?php if ($r->eta === "RSUP") {
                                                              echo 'selected';
                                                            } ?>>Riau Sakti United Plantation
                            <option id="PSG" value="PSG" <?php if ($r->eta === "PSG") {
                                                            echo 'selected';
                                                          } ?>>Pulau Sambu Guntung
                          </select>
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
                        <tr onclick="deleterow(this)">
                          <td <?php
                              if ($r->proses != 1) {
                                echo '><button class="btn btn-sm btn-danger" type="button" id="btn-delete"><i class="fa fa-trash" ></i></button>';
                              } else {
                                echo 'nowrap onclick="event.stopPropagation();return false;">';
                              }
                              ?> </td>
                          <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 50px;" name="urut[]" value="<?php echo $r->urut; ?>"></td>
                          <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 110px;" name="po[]" value="<?php echo $r->po_number; ?>" disabled></td>
                          <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 210px;" name="carrier[]" value="<?php echo $r->shipping_liner; ?>"></td>
                          <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 110px;" name="fcl[]" value="<?php echo $r->container_name; ?>" disabled></td>
                          <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 150px;" name="final[]" value="<?php echo $r->destination; ?>"></td>
                          <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 150px;" name="reff[]" value="<?php echo $r->reff; ?>"></td>
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
                            </select></td>
                          <td nowrap onclick="event.stopPropagation();return false;">
                            <input type="text" class="form-control input-sm" style="width: 80px;" name="depot[]" value="<?php echo $r->depot; ?>">
                          </td>
                          <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 80px;" name="pod[]" value="<?php echo $r->pod; ?>"></td>
                          <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 80px;" name="opcode[]" value="<?php echo $r->opcode; ?>"></td>
                          <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 100px;" name="etdsin[]" value="<?php echo $r->etdsin; ?>"></td>
                          <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 100px;" name="etasin[]" value="<?php echo $r->etasin; ?>"></td>
                          <td hidden><input type="text" class="form-control input-sm" style="width: 150px;" name="container[]" value="<?php echo $r->container; ?>"></td>
                          <td hidden><input type="text" class="form-control input-sm" style="width: 100px;" name="seal[]" value="<?php echo $r->seal; ?>"></td>
                          <td hidden><input type="text" class="form-control input-sm text-right" style="width: 80px;" name="weight[]" value="<?php echo $r->weight; ?>" onkeypress="return isNumber(event)"></td>
                          <td hidden><input type="text" class="form-control input-sm" name="shipid[]" value="<?php echo $r->shipid; ?>"></td>
                          <td hidden><input type="text" class="form-control input-sm" name="outward[]" value="0"></td>
                          <td hidden><input type="text" class="form-control input-sm" name="id[]" value="<?php echo $r->id; ?>"></td>
                        </tr>
                      <?php } ?>
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
                    <button type="button" class="col-md-2 col-md-push-1 btn btn-warning" onclick="fnDialogContainerAll()">Find</button>
                    <a class="col-md-2 col-md-push-1 btn green " id="btn-excel" onclick="excel()">Excel</a>
                    <a type="button" class="col-md-2 col-md-push-1 btn btn-info" href="<?php echo site_url('shipping/container_print?cont=' . $contid . '&tipe=' . $tipe); ?>" target="_blank">Print</a>
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
        var $new_row = $('<tr onclick="deleterow(this)">\n\
                                    <td><button class="btn btn-sm btn-danger" type="button" ><i class="fa fa-trash" ></i></button></td>\n\
                                        <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 50px;" name="urut[]" value="0"></td>\n\
                                        <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 110px;" name="po[]" value="' + getText(document.getElementById("tbl-po").rows[i].cells[2]) + '" disabled></td>\n\
                                        <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 210px;" name="carrier[]" value="' + getText(document.getElementById("tbl-po").rows[i].cells[4]) + '"></td>\n\
                                        <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 110px;" name="fcl[]" value="' + getText(document.getElementById("tbl-po").rows[i].cells[5]) + '" disabled></td>\n\
                                        <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 150px;" name="final[]" value="' + getText(document.getElementById("tbl-po").rows[i].cells[6]) + '" ></td>\n\
                                        <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 150px;" name="reff[]" value=""></td>\n\
                                        <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 150px;" name="vessel[]" value=""></td>\n\
                                        <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 150px;" name="convessel[]" value=""></td>\n\
                                        <td nowrap onclick="event.stopPropagation();return false;"><select name="stuffing[]" id="stuffing"><option value="EE" id="EE" onclick="">Export Empty <option value="EL" id="EL">Export Laden <option value="IL" id="IL">Import Laden <option value="IT" id="IT">Import Transhipment <option value="LC" id="LC">Local Container</select></select></td>\n\
                                        <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 80px;" name="depot[]" value=""></td>\n\
                                        <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 80px;" name="pod[]" value=""></td>\n\
                                        <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 80px;" name="opcode[]" value=""></td>\n\
                                        <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 100px;" name="etdsin[]" value="" ></td>\n\
                                        <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 100px;" name="etasin[]" value="" ></td>\n\
                                        <td hidden><input type="text" class="form-control input-sm" style="width: 150px;" name="container[]" value=""></td>\n\
                                        <td hidden><input type="text" class="form-control input-sm" style="width: 100px;" name="seal[]" value=""></td>\n\
                                        <td hidden><input type="text" class="form-control input-sm text-right" style="width: 80px;" name="weight[]" value="0" onkeypress="return isNumber(event)"></td>\n\
                                        <td hidden><input type="text" class="form-control input-sm" name="shipid[]" value="' + getText(document.getElementById("tbl-po").rows[i].cells[7]) + '"></td>\n\
                                        <td hidden><input type="text" class="form-control input-sm" name="outward[]" value="0">\n\
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

  function deleterow(x) {
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
</script>