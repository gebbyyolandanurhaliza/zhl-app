<script>
  $(document).ready(function() {
    cekDtl()
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
            <form action="<?php echo site_url('shipping/save_penerimaan_container'); ?>" method="post" class="form-horizontal" role="form" id="formPenerimaanContainer">
              <div class="form-body">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group" style="margin-bottom:1px;">
                      <label class="col-md-3 label-sm">Doc No</label>
                      <div class="col-md-5">
                        <input type="hidden" class="form-control input-sm" name="trans_id" value="<?= $trans_id ?>">
                        <input type="date" class="form-control input-sm" name="doc_no" value="<?= isset($doc_no) ? dateFormat('Y-m-d', $doc_no) : "" ?>">
                      </div>
                    </div>
                    <div class="form-group" style="margin-bottom:1px;">
                      <label class="col-md-3 label-sm">Type </label>
                      <div class="col-md-3">
                        <select class="form-control" onchange="changeType()" id="type" name="type">
                          <!-- indo to singapura -->
                          <option value="inward" <?= $type == 'inward' ? 'selected' : "" ?>>Container Inward</option>
                          <!-- singapura to indo -->
                          <option value="outward" <?= $type == 'outward' ? 'selected' : "" ?>>Container Outwared</option>
                        </select>
                      </div>
                    </div>
                    <div class="form-group" style="margin-bottom:1px;">
                      <label class="col-md-3 label-sm">Vessel ( Barge)</label>
                      <div class="col-md-5">
                        <input class="form-control input-sm" id="vessel" name="vessel" value="<?= $vessel ?>">
                      </div>
                    </div>
                    <div class="form-group" style="margin-bottom:1px;">
                      <label class="col-md-3 label-sm">Voyage</label>
                      <div class="col-md-5">
                        <input class="form-control input-sm" id="voyage" name="voyage" value="<?= $voyage ?>">
                      </div>
                    </div>
                    <div class="form-group" style="margin-bottom:1px;" id="shipmentDate">
                      <label class="col-md-3 label-sm">Shipment Date</label>
                      <div class="col-md-5">
                        <input type="date" class="form-control input-sm" name="shipment_date" value="<?= isset($shipment_date) ? dateFormat('Y-m-d', $shipment_date) : "" ?>">
                      </div>
                    </div>
                    <div class="form-group" style="margin-bottom:1px;" id="arrivalDate">
                      <label class="col-md-3 label-sm">Arrival Date</label>
                      <div class="col-md-5">
                        <input type="date" class="form-control input-sm" name="arrival_date" value="<?= isset($arrival_date) ? dateFormat('Y-m-d', $arrival_date) : "" ?>">
                      </div>
                    </div>
                  </div>


                  <div class="col-md-6">
                    <div class="form-group" style="margin-bottom:1px;">
                      <label class="col-md-2 label-sm">ETD</label>
                      <div class="col-md-6">

                        <div id="etd"></div>
                      </div>
                    </div>
                    <div class="form-group" style="margin-bottom:1px;">
                      <label class="col-md-2 label-sm">ETA</label>
                      <div class="col-md-6">
                        <div id="eta"></div>
                      </div>
                    </div>
                  </div>
                </div>

                <hr>

                <div class="table-scrollable">
                  <table class="table table-bordered" id="tblList">
                    <thead>
                      <tr>
                        <th style="width: 1px;"><button class="btn btn-sm btn-primary" type="button" onclick="fnDialogCont()"><i class="fa fa-arrow-down"></i></button></th>
                        <th>Container Number</th>
                        <th>Container Type</th>
                        <th>Status Container</th>
                        <th style="width: 400px;">Remark</th>
                      </tr>
                    </thead>
                    <tbody id="tblList_1">
                      <?php foreach ($listTrxContainer['detail'] as $item) : ?>
                        <tr onclick="deleterow(this)">
                          <td><button class="btn btn-sm btn-danger" type="button"><i class="fa fa-trash"></i></button></td>
                          <td hidden nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" id="containerId" name="containerId[]" value="<?= $item->container_zhl_id ?>" readonly></td>
                          <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" id="" name="[]" value="<?= $item->container_number ?>" readonly></td>
                          <td nowrap onclick="event.stopPropagation();return false;"><input type="text" readonly class="form-control input-sm" value="<?= $item->container_name ?>"></td>
                          <td nowrap onclick="event.stopPropagation();return false;"><select class=form-control select2me name=statusContainer[]>
                              <?php foreach ($listStatus as $val) {
                                echo "<option value=$val->id>$val->status</option>";
                              } ?>
                            </select></td>
                          <td nowrap onclick="event.stopPropagation();return false;"><textarea class="form-control" name="remarks[]"><?= $item->remarks ?></textarea></td>
                        </tr>
                      <?php endforeach ?>
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
                      <textarea class="form-control" name="remarksHdr" id="remarks"><?= $remarks_hdr ?></textarea>
                    </div>
                  </div>
                </div>
              </div>

              <div class="form-actions">
                <div class="col-md-6">
                  <button type="button" onclick="save()" class="col-md-2 btn btn-primary" id="btn-save">Save</button>
                  <?php if (isset($id)) { ?>
                    <a href="<?= base_url('shipping/receipt_container/') ?>" class="col-md-2 btn btn-default" onclick="$('#tblList_1 tr').remove();">Create New</a>
                  <?php } else { ?>
                    <button type="reset" class="col-md-2 btn btn-default" onclick="$('#tblList_1 tr').remove();">Cancel</button>
                  <?php } ?>

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
  $(document).ready(function() {
    cekDtl()
  });

  function fnDialogCont() {
    $("#formdialogContainer").html(" <div class='portlet-body'>\n\
        <div class='table-scrollable' style='overflow: auto; height:300px;'>\n\
            <table id='tbl-cont' class='table table-bordered'>\n\
                <thead>\n\
                    <tr>\n\
                        <th width=1px'><input type='checkbox' onclick='()'></th>\n\
                        <th>Container Number</th>\n\
                        <th>Container Type</th>\n\
                    </tr>\n\
                </thead>\n\
                <tbody id='tblcont'>\n\
                <?php foreach ($listContainerZhl as $val) : ?>\n\
                    <tr>\n\
                        <td><input type='checkbox' name='chk_si[]' class='chk_si unichk' value='$val->container_number'></td>\n\
                        <td><?= $val->container_number ?></td>\n\
                        <td><?= $val->container_name ?></td>\n\
                        <td hidden><?= $val->container_zhl_id ?></td>\n\
                    </tr>\n\
                <?php endforeach ?>\n\
                </tbody>\n\
            </table>\n\
        </div>\n\
        <div class='col-md-6'>\n\
            <button type='button' class='col-m-d3 btn blue' onclick='choose_cont()' id='choose'>Choose</button>\n\
            <button type='button' class='col-md-3 btn grey' onclick='close_cont()'>Close</button>\n\
        </div>\n\
</div>");


    // Define the Dialog and its properties.
    $("#formdialogContainer").dialog({
      resizable: false,
      modal: true,
      title: "List Container",
      height: 550,
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
                            <th>Vessel</th>\n\
                            <th>Voyage</th>\n\
                            <th>ETD</th>\n\
                            <th>ETA</th>\n\
                            <th>Status</th>\n\
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
  // change type transaction
  eta_etd($("#type").find(":selected").val())

  function changeType() {
    var type = $("#type").find(":selected").val();

    eta_etd(type)

  }

  function eta_etd(type) {
    if (type == 'outward') {
      $("#etd").html("<select class='form-control select2me' select2me name='etd'><option value=rsup>PT Pulau Sambu</option><option>PT Riau Sakti United Plantations</option><option>PT Sumatra TimurIndonesia</option>");
      $("#eta").html("<input class=form-control name='eta' value='Singapore' readonly>");
      $("#arrivalDate").hide()
      $("#shipmentDate").show()

    } else {
      $("#arrivalDate").show()
      $("#shipmentDate").hide()
      $("#eta").html("<select class='form-control select2me' name='eta'><option value=rsup>PT Pulau Sambu</option><option>PT Riau Sakti United Plantations</option><option>PT Sumatra TimurIndonesia</option>");
      $("#etd").html("<input class=form-control name='etd' value='Singapore' readonly>");
    }



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

  function save() {
    if ($('#vessel').val() == '') {
      return swal("Oops", "vessel cannot be emptySomething went wrong!", "warning")
    }
    if ($('#voyage').val() == '') {
      return swal("Oops", "voyage cannot be emptySomething went wrong!", "warning")
    }


    swal({
        title: "Save Container Receipt ?",
        type: "warning",
        showCancelButton: true,
        confirmButtonClass: "btn-success",
        confirmButtonText: "Yes, save it!",
        closeOnConfirm: false
      },
      function() {
        $.ajax({
          method: "post",
          url: $("#formPenerimaanContainer").attr("action"),
          data: new FormData(document.getElementById("formPenerimaanContainer")),
          dataType: "json",
          processData: false,
          contentType: false,
          success: function(response) {
            console.log(response)
            if (response) {
              if (response == false) {
                swal('Failed!', 'failed save data', 'warning');
              } else {
                swal('Suuccess!', 'success save data', 'success');
                setTimeout(function() {
                  window.location = "<?= base_url('Shipping/receipt_container') ?>/" + response;
                }, 1500);
              }
            }
          },
          error: function(jqXHR, textStatus, errorThrown) {

            swal(jqXHR.status.toString(), 'Database Error', 'warning');

          }
        });
      });
    // $.ajax({
    //     method: "post",
    //     url: $("#formPenerimaanContainer").attr("action"),
    //     data: new FormData(document.getElementById("formPenerimaanContainer")),
    //     dataType: "json",
    //     processData: false,
    //     contentType: false,
    //     success: function(response) {
    //         console.log(response)
    //         if (response) {
    //             if (response == false) {
    //                 swal('Failed!', 'failed save data', 'warning');
    //             } else {
    //                 swal('Suuccess!', 'success save data', 'success');
    //                 setTimeout(function() {
    //                     window.location = "<?= base_url('Shipping/receipt_container') ?>/" + response;
    //                 }, 1500);
    //             }
    //         }
    //     },
    //     error: function(jqXHR, textStatus, errorThrown) {

    //         swal(jqXHR.status.toString(), 'Database Error', 'warning');

    //     }
    // });
  }

  function choose_cont() {
    function getText(el) {
      if (typeof el.textContent == 'string') return el.textContent;
      if (typeof el.innerText == 'string') return el.innerText;
    }

    var chk_arr = document.getElementsByName("chk_si[]");

    // console.log(chk_arr.length);

    var chk_length = chk_arr.length;
    i = 1;

    for (k = 0; k < chk_length; k++) {
      if (chk_arr[k].checked == true) {
        var new_row = $('<tr onclick="deleterow(this)">\n\
                <td><button class="btn btn-sm btn-danger" type="button" ><i class="fa fa-trash" ></i></button></td>\n\
                <td hidden nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" id="containerId" name="containerId[]" value="' + getText(document.getElementById("tbl-cont").rows[i].cells[3]) + '" readonly></td>\n\
                <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" id="containerId" name="[]" value="' + getText(document.getElementById("tbl-cont").rows[i].cells[1]) + '" readonly></td>\n\
                <td nowrap onclick="event.stopPropagation();return false;"><input type="text" readonly class="form-control input-sm" value="' + getText(document.getElementById("tbl-cont").rows[i].cells[2]) + '"></td>\n\
                <td nowrap onclick="event.stopPropagation();return false;"><select class=form-control select2me name=statusContainer[]>\n\
                <?php foreach ($listStatus as $val) {
                  echo "<option value=$val->id>$val->status</option>";
                } ?>\n\
                </select></td>\n\
                <td nowrap onclick="event.stopPropagation();return false;"><textarea class="form-control" name="remarks[]"></textarea></td>\n\
                </tr>');
        $('#tblList_1').append(new_row);
        console.log(new_row);
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

    // alert($findloadingall);
    $.ajax({
      url: "<?php echo base_url(); ?>shipping/receipt_containerall?loadall=" + $findloadingall + "",
      success: function(response) {
        $("#tblloadingall").html(response);
      },
      dataType: "html"
    });

    return false;
  }

  // function filtercont() {
  //     var location = $('#location').find(":selected").val();
  //     alert(location);
  //     $.ajax({
  //         type: "GET",
  //         url: "<?php echo site_url('Shipping/get_filter_by_ajax') ?>",
  //         data: {
  //             location: location
  //         },
  //         success: function(msg) {
  //             // console.log(msg)
  //             $('#tblcont').html(msg);
  //         }
  //     })
  //     // $findcont = document.getElementById("findcont").value;

  //     // $.ajax({
  //     //     url: "<?php echo base_url(); ?>shipping/container_loading_filter_cont?filter=" + $findcont + "",
  //     //     success: function (response) {
  //     //         $("#tblcont").html(response);
  //     //     },
  //     //     dataType: "html"
  //     // });

  //     // return false;

  // }

  function cekDtl() {
    var ID_arr = document.getElementsByName("containerId[]");
    var ID_length = ID_arr.length;

    if ((ID_length > 0)) {
      $('#btn-save').attr('disabled', false);
    } else {
      $('#btn-save').attr('disabled', true);
    }
  }

  function modal_delete(data) {

    $.ajax({
      url: "<?php echo base_url(); ?>shipping/receipt?delete=" + data + "",
      success: function(response) {
        $("#modal_delete").html(response);
      },
      dataType: "html"
    });

    return false;
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

  // function choose_cont() {
  //     function getText(el) {
  //         if (typeof el.textContent == 'string') return el.textContent;
  //         if (typeof el.innerText == 'string') return el.innerText;
  //     }

  //     var chk_arr = document.getElementsByName("chk_si[]");

  //     // console.log(chk_arr.length);

  //     var chk_length = chk_arr.length;
  //     i = 1;

  //     for (k = 0; k < chk_length; k++) {
  //         if (chk_arr[k].checked == true) {
  //             alert(getText(document.getElementById("tbl-cont").rows[i].cells[2]))
  //             var new_row = $('<tr onclick="deleterow(this)">\n\
  //                                 <td><button class="btn btn-sm btn-danger" type="button" ><i class="fa fa-trash" ></i></button></td>\n\
  //                                     <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" name="cont[]" value="' + getText(document.getElementById("tbl-cont").rows[i].cells[1]) + '" readonly></td>\n\
  //                                     <td nowrap onclick="event.stopPropagation();return false;"><input type="text" readonly class="form-control input-sm" name="seal[]" value="' + getText(document.getElementById("tbl-cont").rows[i].cells[2]) + '"></td>\n\
  //                                     <td nowrap onclick="event.stopPropagation();return false;"><input type="text" readonly class="form-control input-sm" name="seal[]"></td>\n\
  //                                     <td nowrap onclick="event.stopPropagation();return false;"><select class=form-control select2me name=status_container[]><option></option></select></td>\n\
  //                                     <td nowrap onclick="event.stopPropagation();return false;"><textare class=form-control></textarea></td>\n\
  //                             </tr>');

  //             $('#tblList_1').append(new_row);
  //             console.log(new_row);
  //         }
  //         i++;
  //     }

  //     $("#formdialogContainer").dialog("close");
  //     cekDtl();
  // }

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

  // function filterloadingall() {
  //     $findloadingall = document.getElementById("findloadingall").value;

  //     $.ajax({
  //         url: "<?php echo base_url(); ?>shipping/container_loadingall?loadall=" + $findloadingall + "",
  //         success: function(response) {
  //             $("#tblloadingall").html(response);
  //         },
  //         dataType: "html"
  //     });

  //     return false;
  // }

  function filtercont() {
    var location = $('#location').find(":selected").val();
    alert(location);
    $.ajax({
      type: "GET",
      url: "<?php echo site_url('Shipping/get_filter_by_ajax') ?>",
      data: {
        location: location
      },
      success: function(msg) {
        // console.log(msg)
        $('#tblcont').html(msg);
      }
    })
    // $findcont = document.getElementById("findcont").value;

    // $.ajax({
    //     url: "<?php echo base_url(); ?>shipping/container_loading_filter_cont?filter=" + $findcont + "",
    //     success: function (response) {
    //         $("#tblcont").html(response);
    //     },
    //     dataType: "html"
    // });

    // return false;

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