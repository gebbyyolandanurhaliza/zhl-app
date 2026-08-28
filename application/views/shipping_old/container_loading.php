<script>
  $(document).ready(function() {
    $('#btn-save').attr('disabled', true);
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
              <span class="caption-subject theme-font bold">Loading Confirmation</span>
            </div>
          </div>
          <div class="portlet-body form">
            <form action="<?php echo site_url('shipping/container_loading_save/add'); ?>" method="post" class="form-horizontal" role="form">
              <div class="form-body">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group" style="margin-bottom:1px;">
                      <label class="col-md-3 label-sm">Doc Date</label>
                      <div class="col-md-3">
                        <input class="form-control input-sm date date-picker" placeholder="Doc Date" name="docdate" data-date="02-12-2012" data-date-format="dd-mm-yyyy" required>
                        <input class="form-control input-sm" name="id" value="" type="hidden">
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
                      <label class="col-md-2 label-sm">ETA Sin</label>
                      <div class="col-md-3">
                        <input class="form-control input-sm date date-picker" placeholder="ETA Sin" name="etasin" data-date="02-12-2012" data-date-format="dd-mm-yyyy" required>
                      </div>
                    </div>
                    <div class="form-group" style="margin-bottom:1px;">
                      <label class="col-md-2 label-sm">To</label>
                      <div class="col-md-6">
                        <input class="form-control input-sm" name="to">
                      </div>
                    </div>
                    <div class="form-group" style="margin-bottom:1px;">
                      <label class="col-md-2 label-sm">ATTN</label>
                      <div class="col-md-6">
                        <input class="form-control input-sm" name="attn">
                      </div>
                    </div>
                    <div class="form-group" style="margin-bottom:1px;">
                      <label class="col-md-2 label-sm">From</label>
                      <div class="col-md-6">
                        <input class="form-control input-sm" name="from">
                      </div>
                    </div>
                  </div>
                </div>

                <hr>

                <div class="table-scrollable">
                  <table class="table table-bordered" id="tblList">
                    <thead>
                      <tr>
                        <th width="10px"><button class="btn btn-sm btn-primary" type="button" onclick="fnDialogCont()"><i class="fa fa-arrow-down"></i></button></th>
                        <th nowrap>Container No</th>
                        <th nowrap>Booking Ref</th>
                        <th nowrap>Vessel / Voyage</th>
                        <th nowrap>Port Of Disch</th>
                        <th nowrap>Destination</th>
                      </tr>
                    </thead>
                    <tbody id="tblList_1">
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
                  <button type="button" class="col-md-2 col-md-push-10 btn btn-warning" onclick="fnDialogloadingAll()">Find</button>
                </div>
              </div>
            </form>
          </div>
        </div>
        <div id="formdialogloadingAll"></div>
        <div id="formdialogContainer"></div>
        <div id="modal_delete" class="modal fade bs-modal-lg" role="dialog" tabindex="-1" data-backdrop="static" data-keyboard="false" aria-hidden="true"></div>

      </div>
    </div>
  </div>
</div>

<script>
  function fnDialogCont() {
    $("#formdialogContainer").html(" <div class='portlet-body'>\n\
                        <div class='col-md-12'>\n\
                            <div class='form-group'>\n\
                                 <label class='col-md-1 label-sm'>Find</label>\n\
                                 <div class='col-md-7'>\n\
                                        <input class='form-control input-sm' id='findcont'>\n\
                                 </div>\n\
                                 <button type='button' class='col-md-2 btn blue' onclick='filtercont()'>Search</button>\n\
                            </div>\n\
                        </div>\n\
                        <br><hr>\n\
                        <div class='table-scrollable' style='overflow: auto; height:300px;'>\n\
                            <table id='tbl-cont' class='table table-bordered'>\n\
                                <thead>\n\
                                    <tr>\n\
                                        <th width='10px'><input type='checkbox' onchange='check(this)'></th>\n\
                                        <th>Shipment Date</th>\n\
                                        <th>Po Number</th>\n\
                                        <th>Container</th>\n\
                                        <th>Booking</th>\n\
                                        <th>Vessel / Voyage</th>\n\
                                        <th>Port of Disch</th>\n\
                                        <th>Destination</th>\n\
                                    </tr>\n\
                                </thead>\n\
                                <tbody id='tblcont'>\n\
                                    <tr>\n\
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
                            <button type='button' class='col-md-3 btn blue' onclick='choose_cont()' id='choose'>Choose</button>\n\
                            <button type='button' class='col-md-3 btn grey' onclick='close_cont()'>Close</button>\n\
                        </div>\n\
                </div>");

    // Define the Dialog and its properties.
    $("#formdialogContainer").dialog({
      resizable: false,
      modal: true,
      title: "List Container",
      height: 500,
      width: 800

    });
  }

  function fnDialogloadingAll() {
    $("#formdialogloadingAll").html("<div class='portlet-body'>\n\
                        <div class='col-md-12'>\n\
                            <div class='form-group'>\n\
                                 <label class='col-md-1 label-sm'>Find</label>\n\
                                 <div class='col-md-7'>\n\
                                        <input class='form-control input-sm' id='findloadingall'>\n\
                                 </div>\n\
                                 <button type='button' class='col-md-1 btn blue' onclick='filterloadingall()'>Search</button>\n\
                            </div>\n\
                        </div>\n\
                        <br><hr>\n\
                        <div class='table-scrollable' style='overflow: auto; height:490px;'>\n\
                            <table id='tbl-containerall' class='table table-bordered'>\n\
                                <thead>\n\
                                    <tr>\n\
                                        <th>Action</th>\n\
                                        <th>Date</th>\n\
                                        <th>Carrier</th>\n\
                                        <th>Voyage</th>\n\
                                        <th>To</th>\n\
                                        <th>ATTN</th>\n\
                                        <th>From</th>\n\
                                        <th>ETA Sin</th>\n\
                                        <th>Created By</th>\n\
                                        <th>Created Date</th>\n\
                                        <th>LastUpdated By</th>\n\
                                        <th>LastUpdated Date</th>\n\
                                    </tr>\n\
                                </thead>\n\
                                <tbody id='tblloadingall'>\n\
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
                                    </tr>\n\
                                </tbody>\n\
                            </table>\n\
                        </div>\n\
                    </div>");

    // Define the Dialog and its properties.
    $("#formdialogloadingAll").dialog({
      resizable: false,
      modal: true,
      title: "List Loading Confirmation",
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

  function choose_cont() {
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
                                        <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" name="cont[]" value="' + getText(document.getElementById("tbl-cont").rows[i].cells[3]) + '" readonly></td>\n\
                                        <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" name="reff[]" value="' + getText(document.getElementById("tbl-cont").rows[i].cells[4]) + '" readonly></td>\n\
                                        <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" name="vessel[]" value="' + getText(document.getElementById("tbl-cont").rows[i].cells[5]) + '" readonly></td>\n\
                                        <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" name="port[]" value="' + getText(document.getElementById("tbl-cont").rows[i].cells[6]) + '"></td>\n\
                                        <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" name="destination[]" value="' + getText(document.getElementById("tbl-cont").rows[i].cells[7]) + '"></td>\n\
                                        <td hidden><input type="text" class="form-control input-sm" name="contid[]" value="' + getText(document.getElementById("tbl-cont").rows[i].cells[8]) + '"></td>\n\
                                </tr>');

        $('table[id="tblList"]').append($new_row);
      }
      i++;
    }

    $("#formdialogContainer").dialog("close");
    cekDtl();
  }

  function close_cont() {
    $("#formdialogContainer").dialog("close");
  }

  function deleterow(x) {
    $r = x.rowIndex;

    if (confirm("Are you sure remove this row?") == true) {
      document.getElementById("tblList").deleteRow($r);
      cekDtl();
    }
  }

  function filterloadingall() {
    $findloadingall = document.getElementById("findloadingall").value;

    $.ajax({
      url: "<?php echo base_url(); ?>shipping/container_loadingall?loadall=" + $findloadingall + "",
      success: function(response) {
        $("#tblloadingall").html(response);
      },
      dataType: "html"
    });

    return false;
  }

  function filtercont() {
    $findcont = document.getElementById("findcont").value;

    $.ajax({
      url: "<?php echo base_url(); ?>shipping/container_loading_filter_cont?filter=" + $findcont + "",
      success: function(response) {
        $("#tblcont").html(response);
      },
      dataType: "html"
    });

    return false;
  }

  function cekDtl() {
    var ID_arr = document.getElementsByName("contid[]");
    var ID_length = ID_arr.length;

    if ((ID_length > 0)) {
      $('#btn-save').attr('disabled', false);
    } else {
      $('#btn-save').attr('disabled', true);
    }
  }

  function modal_delete(data) {

    $.ajax({
      url: "<?php echo base_url(); ?>shipping/container_loading_modal_delete?delete=" + data + "",
      success: function(response) {
        $("#modal_delete").html(response);
      },
      dataType: "html"
    });

    return false;
  }
</script>