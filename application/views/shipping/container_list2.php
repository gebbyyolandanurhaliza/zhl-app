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
            <form action="<?php echo site_url('shipping/container_save/add'); ?>" method="post" class="form-horizontal" role="form">
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
                        <input class="form-control input-sm date date-picker" name="shipdate" data-date="02-12-2012" data-date-format="dd-mm-yyyy" required>
                        <input class="form-control input-sm" name="contid" value="" type="hidden">
                      </div>
                    </div>
                    <div class="form-group" style="margin-bottom:1px;">
                      <label class="col-md-3 label-sm">Vessel ( Barge)</label>
                      <div class="col-md-5">
                        <input class="form-control input-sm" name="barge">
                      </div>
                    </div>
                    <div class="form-group" style="margin-bottom:1px;">
                      <label class="col-md-3 label-sm">Voyage</label>
                      <div class="col-md-5">
                        <input class="form-control input-sm" name="voyage">
                      </div>
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group" style="margin-bottom:1px;">
                      <label class="col-md-2 label-sm">ETD</label>
                      <div class="col-md-7">
                        <div class="input-group">
                          <input class="form-control input-sm" placeholder="ETD" name="etd" value="SINGAPORE" readonly="">
                          <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                          <input class="form-control input-sm date date-picker" placeholder="ETD Date" name="etddate" data-date="02-12-2012" data-date-format="dd-mm-yyyy">
                        </div>
                      </div>
                    </div>
                    <div class="form-group" style="margin-bottom:1px;">
                      <label class="col-md-2 label-sm">ETA</label>
                      <div class="col-md-7">
                        <div class="input-group">
                          <select class="form-control input-sm" name="eta">
                            <option>Select Factory</option>
                            <option value="RSUP" id="RSUP">Riau Sakti United Plantation</option>
                            <option value="PSG" id="PSG">Pulau Sambu Guntung</option>
                            <option value="PSKE" id="PSKE">Pulau Sambu Kuala Enok</option>
                          </select>
                          <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                          <input class="form-control input-sm date date-picker" placeholder="ETA Date" name="etadate" data-date="02-12-2012" data-date-format="dd-mm-yyyy">
                        </div>
                      </div>
                    </div>
                    <div class="form-group" style="margin-bottom:1px;">
                      <label class="col-md-2 label-sm">To</label>
                      <div class="col-md-7">
                        <input class="form-control input-sm" name="to">
                      </div>
                    </div>
                    <div class="form-group" style="margin-bottom:1px;">
                      <label class="col-md-2 label-sm">From</label>
                      <div class="col-md-7">
                        <input class="form-control input-sm" name="from">
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

                <div class="table-scrollable">
                  <table class="table table-bordered" id="tblList">
                    <thead>
                      <tr>
                        <th width="10px"><button class="btn btn-sm btn-primary" type="button" onclick="fnDialogPO()"><i class="fa fa-arrow-down"></i></button></th>
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
                    </tbody>
                  </table>
                </div>
              </div>

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
                      <th nowrap>Booking Ref</th>
                    </tr>
                  </thead>
                  <tbody id="tblList_1_lc">
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
                  <textarea class="form-control" name="remarks" id="remarks"></textarea>
                </div>
              </div>
            </div>
          </div>

          <div class="form-actions">
            <div class="col-md-6">
              <button type="submit" class="col-md-2 btn btn-primary" id="btn-save">Save</button>
              <button type="reset" class="col-md-2 btn btn-default" onclick="$('#tblList_1 tr').remove();">Cancel</button>
            </div>
            <div class="col-md-6">
              <button type="button" class="col-md-3 col-md-push-7 btn btn-default" onclick="fnDialogContainerOutward()">Copy Outward</button>
              <button type="button" class="col-md-2 col-md-push-7 btn btn-warning" onclick="fnDialogContainerAll()">Find</button>
            </div>
          </div>
          </form>
        </div>
      </div>
      <div id="formdialogContainerOutward"></div>
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
            <table id='tbl-containerall' class='table table-bordered table-striped'>
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
            <div class="text-center" style="display:none" id="loader">
              <h2><i class="fa fa-spinner fa fa-spin"></i></h2>
              <p>Loading...</p>
            </div>
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
              <tbody id="tblpo"></tbody>
            </table>
            <div class="text-center" style="display:none" id="loader2">
              <h2><i class="fa fa-spinner fa fa-spin"></i></h2>
              <p>Loading...</p>
            </div>
          </div>
          <div class="col-md-6">
            <button type="button" class="col-md-3 btn blue" onclick="choose_PO()" id="choose">Choose</button>
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

      <div id="modal_delete" class="modal fade bs-modal-lg" role="dialog" tabindex="-1" data-backdrop="static" data-keyboard="false" aria-hidden="true"></div>

    </div>
  </div>
</div>
</div>

<script>
  $(document).ready(function() {
    $('#btn-save').attr('disabled', true);
  });

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

  $('#formdialogPO').on('dialogclose', function(event) {
    $('#tblpo').html("");
  });


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

  $('#formdialogContainerAll').on('dialogclose', function(event) {
    $('#tblcontainerall').html("");
  });


  function fnDialogContainerOutward() {
    $("#formdialogContainerOutward").html("<div class='portlet-body'>\n\
                        <div class='col-md-12'>\n\
                            <div class='form-group'>\n\
                                 <label class='col-md-1 label-sm'>Find</label>\n\
                                 <div class='col-md-7'>\n\
                                        <input class='form-control input-sm' id='findcontaineroutward'>\n\
                                 </div>\n\
                                 <button type='button' class='col-md-1 btn blue' onclick='filtercontaineroutward()'>Search</button>\n\
                            </div>\n\
                        </div>\n\
                        <br><hr>\n\
                        <div class='table-scrollable' style='overflow: auto; height:490px;'>\n\
                            <table id='tbl-containerall' class='table table-bordered'>\n\
                                <thead>\n\
                                    <tr>\n\
                                        <th>Action</th>\n\
                                        <th>Tipe</th>\n\
                                        <th>Shipment Date</th>\n\
                                        <th>Vessel (Barge)</th>\n\
                                        <th>Voyage</th>\n\
                                        <th>ETD</th>\n\
                                        <th>ETD Date</th>\n\
                                        <th>ETA</th>\n\
                                        <th>ETA Date</th>\n\
                                        <th>From</th>\n\
                                        <th>To</th>\n\
                                        <th>Created By</th>\n\
                                        <th>Created Date</th>\n\
                                        <th>LastUpdated By</th>\n\
                                        <th>LastUpdated Date</th>\n\
                                    </tr>\n\
                                </thead>\n\
                                <tbody id='tblcontaineroutward'>\n\
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
                                        <td></td>\n\
                                        <td></td>\n\
                                    </tr>\n\
                                </tbody>\n\
                            </table>\n\
                        </div>\n\
                    </div>");

    // Define the Dialog and its properties.
    $("#formdialogContainerOutward").dialog({
      resizable: false,
      modal: true,
      title: "List Container Outward",
      height: 650,
      width: 1200

    });
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
        var $new_row = $('<tr onclick="deleterow(this)">\n\
                                    <td><button class="btn btn-sm btn-danger" type="button" ><i class="fa fa-trash" ></i></button></td>\n\
                                        <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 50px;" name="urut[]" value="0"></td>\n\
                                        <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 110px;" name="po[]" value="' + getText(document.getElementById("tbl-po").rows[i].cells[2]) + '" disabled></td>\n\
                                        <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 200px;" name="carrier[]" value="' + getText(document.getElementById("tbl-po").rows[i].cells[4]) + '"></td>\n\
                                        <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 110px;" name="fcl[]" value="' + getText(document.getElementById("tbl-po").rows[i].cells[5]) + '" disabled></td>\n\
                                        <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 250px;" name="final[]" value="' + getText(document.getElementById("tbl-po").rows[i].cells[6]) + '"></td>\n\
                                        <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 300px;" name="reff[]" value=""><textarea class="form-control" name="reff_remark[]" value="" placeholder="Remarks..."></textarea></td>\n\
                                        <td nowrap onclick="event.stopPropagation();return false;">\n\
                                        <select class="form-control input-sm" name="supplier[]" style="width: 250px;">\n\
                                            <option value=""></option>\n\
                                            <?php foreach ($ven as $r) { ?>\n\
                                            <option value="<?php echo $r->id_supp; ?>"><?php echo $r->name_supp; ?></option>\n\
                                        <?php } ?>\n\
                                        </td>\n\
                                        <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 200px;" name="vessel[]" value=""></td>\n\
                                        <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 200px;" name="convessel[]" value=""></td>\n\
                                        <td nowrap onclick="event.stopPropagation();return false;"><select name="stuffing[]" id="stuffing"><option value="EE" id="EE" onclick="">Export Empty <option value="EL" id="EL">Export Laden <option value="IL" id="IL">Import Laden <option value="IT" id="IT">Import Transhipment <option value="LC" id="LC">Local Container <option value="RE" id="RE">Recall Container <option value="ELTP" id="ELTP">Export Laden (TP)</select></td>\n\
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

    $("#tblcontainerall").html("");

    $.ajax({
      url: "<?php echo base_url(); ?>shipping/container_containerall?dt=" + $dt_shipment + "&call=" + $dt_data + "",
      dataType: "html",
      beforeSend: function() {
        $("#loader").show();
      },
      success: function(response) {
        if (response == '') {
          $("#tblcontainerall").html("<tr><td class='text-center' colspan='15'>List Empty</td></tr>");
        } else {
          $("#tblcontainerall").html(response);
        }

      },
      complete: function() {
        $("#loader").hide();
      }
    });
  }

  function filtercontaineroutward() {
    $findcontaineroutward = document.getElementById("findcontaineroutward").value;

    $.ajax({
      url: "<?php echo base_url(); ?>shipping/container_containeroutward?cout=" + $findcontaineroutward + "",
      success: function(response) {
        $("#tblcontaineroutward").html(response);
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

    $("#tblpo").html("");

    $.ajax({
      dataType: "html",
      url: "<?php echo base_url(); ?>shipping/container_po?fac=" + $factory + "&schedule=" + $schedule + "&po=" + $po + "",
      beforeSend: function() {
        $("#loader2").show();
      },
      success: function(response) {
        $("#tblpo").html(response);
      },
      complete: function() {
        $("#loader2").hide();
      }
    });

    return false;
  }

  function cekDtl() {
    var ID_arr = document.getElementsByName("shipid[]");
    var ID_length = ID_arr.length;

    if ((ID_length > 0)) {
      $('#btn-save').attr('disabled', false);
    } else {
      $('#btn-save').attr('disabled', true);
    }
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

  function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode === 8 || charCode === 9 || charCode === 37 || charCode === 39 || charCode === 46 || (charCode > 47 && charCode < 58)) {
      return true;
    }
    return false;
  }

  function cek_shipid(ele) {
    var checkboxes = document.getElementsByTagName('input');
    var ship_id = ele.value;
    if (ele.checked) {
      for (var i = 0; i < checkboxes.length; i++) {
        if (checkboxes[i].type == 'checkbox') {
          if (ship_id == checkboxes[i].value) {
            checkboxes[i].checked = true;
          }
        }
      }
    } else {
      for (var i = 0; i < checkboxes.length; i++) {
        if (checkboxes[i].type == 'checkbox') {
          if (ship_id == checkboxes[i].value) {
            checkboxes[i].checked = false;
          }
        }
      }
    }
  }

  function run_disable_depot() {
    $ck1 = document.getElementById('EE').checked;
    $ck2 = document.getElementById('EL').checked;
    $ck3 = document.getElementById('IL').checked;
    $ck4 = document.getElementById('IT').checked;

    var depot = document.getElementById("depot");

    if ($ck1 == true) {
      depot.disabled = false;
    } else if ($ck2 == true) {
      depot.disabled = true;
    } else if ($ck3 == true) {
      depot.disabled = true;
    } else {
      depot.disabled = true;
    }
  }
</script>