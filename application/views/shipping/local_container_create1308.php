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
              <span class="caption-subject theme-font bold">Local Container</span>
            </div>
          </div>
          <div class="portlet-body form">
            <form action="<?php echo site_url('shipping/local_container_save'); ?>" method="post" class="form-horizontal" role="form">
              <div class="form-body">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group" style="margin-bottom:1px;">
                      <label class="col-md-3 label-sm">Tipe</label>
                      <div class="col-md-3">
                        <select class="form-control select2me" name="tipe">
                          <option value="3">Local Container</option>
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
                        <th nowrap width="20">Seq No</th>
                        <th nowrap>Stuffing</th>
                        <th nowrap>Container Type</th>
                        <th nowrap>Container Number</th>
                        <th nowrap>Supplier</th>
                      </tr>
                    </thead>
                    <tbody id="tblList_1">
                    </tbody>
                  </table>
                </div>
              </div>

              <div class="form-actions">
                <div class="col-md-6">
                  <button type="submit" class="col-md-2 btn btn-primary" id="btn-save">Save</button>
                  <button type="reset" class="col-md-2 btn btn-default" onclick="$('#tblList_1 tr').remove();">Cancel</button>
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
            </div>
          </div>
        </div>
        <div id="formdialogPO" hidden>
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
      height: 250,
      width: 800

    });
    // filterContainerLocal();
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
    $ctr_name = $('#ctr_id option:selected').text();
    $ctr_id = $('#ctr_id option:selected').val();
    $rowcount = $('#rowcount').val();

    console.log($ctr_name);
    console.log($ctr_id);
    console.log($rowcount);

    for ($i = 0; $i < $rowcount; $i++) {
      var $new_row = $('<tr onclick="deleterow(this)">\n\
                                    <td align="center"><button class="btn btn-sm btn-danger" type="button" ><i class="fa fa-trash" ></i></button></td>\n\
                                        <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" name="urut[]" value="0"></td>\n\
                                        <td nowrap onclick="event.stopPropagation();return false;" style="width: 100px;"><select name="stuffing[]" id="stuffing"><option value="LE" id="LE" onclick="">Local Empty <option value="LL" id="LL">Local Laden </select></td>\n\
                                        <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" name="container_name[]" value="' + $ctr_name + '" readonly><input type="hidden" class="form-control input-sm" name="container_id[]" value="' + $ctr_id + '"></td>\n\
                                        <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" name="container_number[]" value="" required></td>\n\
                                        <td nowrap onclick="event.stopPropagation();return false;" required><input type="text" class="form-control input-sm" name="supplier[]" value=""></td>\n\
                                        <td hidden></td>\n\
                                        <td hidden></td>\n\
                                        <td hidden></td>\n\
                                </tr>');

      $('table[id="tblList"]').append($new_row);
    }

    $("#formdialogPO").dialog("close");
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

    $.ajax({
      url: "<?php echo base_url(); ?>shipping/container_po?fac=" + $factory + "&schedule=" + $schedule + "&po=" + $po + "",
      success: function(response) {
        $("#tblpo").html(response);
      },
      dataType: "html"
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


  function filterContainerLocal() {
    filterpodtl();
  }

  function filterpodtl() {
    $container_name = document.getElementById("container").value;

    $.ajax({
      url: "<?php echo base_url(); ?>shipping/container_local_modal?container_name=" + $container_name + "",
      success: function(response) {
        $("#tblpo").html(response);
      },
      dataType: "html"
    });

    return false;
  }

  function cek_contid(ele) {
    var checkboxes = document.getElementsByTagName('input');
    var container_id = ele.value;
    if (ele.checked) {
      for (var i = 0; i < checkboxes.length; i++) {
        if (checkboxes[i].type == 'checkbox') {
          if (container_id == checkboxes[i].value) {
            checkboxes[i].checked = true;
          }
        }
      }
    } else {
      for (var i = 0; i < checkboxes.length; i++) {
        if (checkboxes[i].type == 'checkbox') {
          if (container_id == checkboxes[i].value) {
            checkboxes[i].checked = false;
          }
        }
      }
    }
  }
</script>