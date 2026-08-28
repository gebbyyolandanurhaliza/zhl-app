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
                          <option value="2" selected>Container Inward </option>
                        </select>
                      </div>
                    </div>
                    <div class="form-group" style="margin-bottom:1px;">
                      <label class="col-md-3 label-sm">Shipment Date</label>
                      <div class="col-md-3">
                        <input class="form-control input-sm date date-picker" name="shipdate" data-date="02-12-2012" data-date-format="dd-mm-yyyy" value="<?php echo $shipment; ?>" required>
                        <input class="form-control input-sm" name="contid" id="contid" value="<?php echo $contid; ?>" type="text">
                        <input class="form-control input-sm" name="tipe1" id="tipe1" value="<?php echo $tipe; ?>" type="text">

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
                          <input class="form-control input-sm" name="etd" value="<?php echo $etd; ?>">
                          <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                          <input class="form-control input-sm date date-picker" placeholder="ETD Date" name="etddate" data-date="02-12-2012" data-date-format="dd-mm-yyyy" value="<?php echo $etddate; ?>">
                        </div>
                      </div>
                    </div>
                    <div class="form-group" style="margin-bottom:1px;">
                      <label class="col-md-2 label-sm">ETA</label>
                      <div class="col-md-7">
                        <div class="input-group">
                          <input class="form-control input-sm" name="eta" value="<?php echo $eta; ?>">
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
                        <!--<th nowrap><button class="btn btn-sm btn-primary" type="button" onclick="" >Add</button></th>-->
                        <th nowrap>POD</th>
                        <th nowrap>OP Code</th>
                        <th nowrap>ETD Sin</th>
                        <th nowrap>Container</th>
                        <th nowrap>Seal</th>
                        <th nowrap>Actual Seal</th>
                        <th nowrap>Weight</th>
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
                          <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 110px;" name="carrier[]" value="<?php echo $r->shipping_liner; ?>"></td>
                          <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 110px;" name="fcl[]" value="<?php echo $r->container_name; ?>" disabled></td>
                          <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 150px;" name="final[]" value="<?php echo $r->destination; ?>"></td>
                          <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 150px;" name="reff[]" value="<?php echo $r->reff; ?>"></td>
                          <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 150px;" name="vessel[]" value="<?php echo $r->vessel; ?>"></td>
                          <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 150px;" name="convessel[]" value="<?php echo $r->convessel; ?>"></td>
                          <td nowrap onclick="event.stopPropagation();return false;"><select name="stuffing[]" readonly="">
                              <option><?php echo $r->stuffing; ?></option>
                              <!--    <option value="Export Container">Export Container<option> <option value="Local Container">Local Container<option> -->
                            </select></td>
                          <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 80px;" name="depot[]" value="<?php echo $r->depot; ?>"></td>
                          <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 80px;" name="pod[]" value="<?php echo $r->pod; ?>"></td>
                          <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 80px;" name="opcode[]" value="<?php echo $r->opcode; ?>"></td>
                          <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 100px;" data-date="02-12-2012" name="etdsin[]" value="<?php echo $r->etdsin; ?>"></td>
                          <td nowrap onclick="event.stopPropagation();return false;"><input ondblclick="fnDialogContainerChange(<?= $r->detail_id; ?>, <?php echo "'" . $r->container . "'"; ?>)" type="text" class="form-control input-sm" style="width: 150px;" name="container[]" value="<?php echo $r->container; ?>" readonly=""></td>
                          <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 100px;" name="seal[]" value="<?php echo $r->seal; ?>"></td>
                          <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 100px;" name="actual_seal[]" value="<?php echo $r->actual_seal; ?>"></td>
                          <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm text-right" style="width: 80px;" name="weight[]" value="<?php echo $r->weight; ?>" onkeypress="return isNumber(event)"></td>
                          <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 100px;" name="etasin[]" value="<?php echo $r->etasin; ?>"></td>
                          <td hidden><input type="text" class="form-control input-sm" name="shipid[]" value="<?php echo $r->shipid; ?>"></td>
                          <td hidden><input type="text" class="form-control input-sm" name="outward[]" value="<?php echo $r->flag; ?>"></td>
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
      <div id="formdialogPO"></div>
      <div id="formdialogCont"></div>
      <div id="formdialogCont1"></div>
      <div id="formdialogContEdit" hidden>
        <div class='portlet-body'>
          <div class='col-md-12'>
            <div class='form-group'>
              <div class='form-group'>
                <label class='control-label col-md-2'>Date</label>
                <div class='col-md-10'>
                  <div class='input-group date-picker input-daterange' data-date='02-12-2012' data-date-format='dd-mm-yyyy'>
                    <input type='text' class='form-control' id='from' name='dari' value=''>
                    <span class='input-group-addon'>
                      to </span>
                    <input type='text' class='form-control' id='to' name='sampai' value=''>
                  </div>
                </div>
              </div>
              <label class='col-md-2 label-sm'>Load Time</label>
              <div class='col-md-10'>
                <input class='form-control input-sm' id='LoadCI'>
              </div>

              <label class='col-md-2 label-sm'>Load</label>
              <div class='col-md-7'>
                <input class='form-control input-sm' id='findCI'>
              </div>
              <button type='button' class='col-md-2 btn blue' onclick='filterContainerInward()'>Search</button>
            </div>
          </div>
          <br>
          <hr>
          <div class='table-scrollable' style='overflow: auto; height:300px;'>
            <table id='tbl-po' class='table table-bordered'>
              <thead>
                <tr>
                  <th width='10px'><input type='checkbox' onchange='check(this)'></th>
                  <th>No</th>
                  <th>Container Number</th>
                  <th>Container Type</th>
                  <th>Loading Port</th>
                  <th>Free Time</th>
                  <th>Arrival Date</th>
                  <th>Remark</th>
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
                </tr>
              </tbody>
            </table>
          </div>
          <div class='col-md-6'>
            <button type='button' class='col-md-3 btn blue' onclick='fnDialogContainerChange1()' id='choose'>Choose</button>
            <button type='button' class='col-md-3 btn grey' onclick='fnDialogContainerChange()'>Close</button>
          </div>
        </div>

        <!-- ini adalah form dialog date picker-->

        <div id="modal_delete" class="modal fade bs-modal-lg" role="dialog" tabindex="-1" data-backdrop="static" data-keyboard="false" aria-hidden="true"></div>
      </div>
    </div>
  </div>
</div>

<script>
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
                                 <div class='col-md-10'>\n\
                                        <input class='form-control input-sm' name='cb' id='cb' ondblclick='fnDialogContainerStock()' placeholder='Double Click For Choice Container' disabled readonly=''>\n\
                                 </div>\n\
                                 <button type='button' class='col-md-2 btn blue' onclick='#' id='cd' name='cd' disabled>Save</button>\n\
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
      height: 300,
      width: 600

    });
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

  function fnDialogContainerStock() {
    // Define the Dialog and its properties.
    $("#formdialogContEdit").dialog({
      resizable: false,
      modal: true,
      title: "List Container Stock",
      height: 600,
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
                                        <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 200px;" name="carrier[]" value="' + getText(document.getElementById("tbl-po").rows[i].cells[4]) + '"></td>\n\
                                        <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 110px;" name="fcl[]" value="' + getText(document.getElementById("tbl-po").rows[i].cells[5]) + '" disabled></td>\n\
                                        <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 250px;" name="final[]" value="' + getText(document.getElementById("tbl-po").rows[i].cells[6]) + '"></td>\n\
                                        <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 150px;" name="reff[]" value=""></td>\n\
                                        <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 200px;" name="vessel[]" value=""></td>\n\
                                        <td nowrap onclick="event.stopPropagation();return false;"><select name="stuffing[]"><option value="Export Container">Export Container <option value="Local Container">Local Container</select></td>\n\
                                        <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 200px;" name="convessel[]" value=""></td>\n\
                                        <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 80px;" name="depot[]" value=""></td>\n\
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

  function close_formdialogCont() {
    $("#formdialogCont").dialog("close");
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

  function filterContainerInward() {
    filterCI();

  }

  function filterCI() {
    $findCI = document.getElementById("findCI").value;

    $.ajax({
      url: "<?php echo base_url(); ?>shipping/container_stock_choice?po_cout=" + $findCI + "",
      success: function(response) {
        $("#tblCI").html(response);
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

  function amendment() {
    $amendmentdate = document.getElementById('amendmentdate').value;

    if ($amendmentdate.trim() != '') {
      $('#btn-update').attr('disabled', false);
    } else {
      $('#btn-update').attr('disabled', true);
    }
  }

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

  function save_change(x) {
    var ca = $("#ca").val();
    var tipe = $("#tipe1").val();
    var countid = $("#contid").val();

    // alert(tipe);
    // alert(countid);

    $.ajax({
      url: "<?php echo base_url(); ?>shipping/container_inward_edit?container=" + ca + "&id=" + x + "&contid=" + countid + "&tipe=" + tipe,
      success: function(response) {
        $("#tblList_1").html(response);
      },
      dataType: "html"
    });
    close_formdialogCont()
    return false;

  }

  function fnDialogContainerChange1(x, y) {
    $("#formdialogCont1").html(" <div class='portlet-body'>\n\
                        <div class='col-md-12'>\n\
                            <div class='form-group'>\n\
                                <input class='col-md-1 label-sm' type='Radio' name='axx' id='cekboxy' onclick='run_disable_buttom1()'/>\n\
                                 <label class='col-md-4 label-sm'>Edit Container</label>\n\
                                 <div class='col-md-10'>\n\
                                        <input class='form-control input-sm' name='caa' id='caa' value='<?php echo "'" . $r->container . "'"; ?>' disabled>\n\
                                 </div>\n\
                                 <button type='button' class='col-md-2 btn blue' onclick='save_change(x)' id='cca' name='cca' disabled>Save</button>\n\
                            </div>\n\
                        </div>\n\
                        <div class='col-md-12'>\n\
                            <div class='form-group'>\n\
                                <input class='col-md-1 label-sm' type='Radio' name='axx' id='cekboxxy' onclick='run_disable_buttom1()' checked/>\n\
                                 <label class='col-md-4 label-sm'>Change Container</label>\n\
                                 <div class='col-md-10'>\n\
                                        <input class='form-control input-sm' name='cba' id='cba' ondblclick='fnDialogContainerStock()' placeholder='Double Click For Choice Container' readonly=''>\n\
                                 </div>\n\
                                 <button type='button' class='col-md-2 btn blue' onclick='#' id='cda' name='cda'>Save</button>\n\
                            </div>\n\
                        </div>\n\
                        <div class='col-md-7'>\n\
                            <button type='button' class='col-md-6 btn grey' onclick='close_formdialogCont()'>Close</button>\n\
                        </div>\n\
                </div>");

    // Define the Dialog and its properties.
    $("#formdialogCont1").dialog({
      resizable: false,
      modal: true,
      title: "Container Change and Edit",
      height: 300,
      width: 600

    });
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
</script>