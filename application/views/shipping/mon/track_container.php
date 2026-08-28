<?php
$period = $this->session->userdata('periode_1');
$tgl1 = $period . "/01";

if ($this->input->post('eta') <> '') {
  $shipdate = $this->input->post('shipdate');
} else {
  $shipdate = date("d-m-Y");
}


?>
<div class="page-content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">

        <?php
        echo $message;
        echo form_open(site_url('Shipping/print_tracking_pdf'), 'target="_blank" method="post" class="form-horizontal"');
        ?>

        <div class="portlet light">

          <div class="portlet-title">
            <div class="caption">
              <i class="fa fa-map theme-font"></i>
              <span class="caption-subject theme-font uppercase">Track Local Container</span>
            </div>
            <div class="tools">
              <a href="javascript:;" class="collapse">
              </a>
              <a href="javascript:;" class="reload">
              </a>
              <a href="javascript:;" class="fullscreen"></a>
            </div>
          </div>

          <div class="portlet-body form">
            <div class="form-body row">
              <div class="col-md-12">
                <div class="panel panel-default">
                  <div class="panel-heading">
                    <h5 class="panel-title"><i class='fa fa-filter'></i> Filter Data</h5>
                  </div>
                  <div class="panel-body">

                    <div class="col-md-12 row">
                      <div class="form-group">
                        <label class="col-md-2 control-label" for="varchar">Location</label>
                        <div class="col-md-3">
                          <select class="form-control select2me" name="eta" data-placeholder="choose factory" id="location" data-placeholder="choose">
                            <option value=""></option>
                            <option value="PSG">PT. Pulau Sambu Guntung</option>
                            <option value="RSUP">PT. RIau Sakti United Plantations</option>
                            <option value="STI">PT. Sumtra Timur Indonesia</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-12 row">
                      <div class="form-group">
                        <label class="col-md-2 control-label" for="varchar">Tipe</label>
                        <div class="col-md-3">
                          <select class="form-control select2me" name="tipe" data-placeholder="choose factory" id="tipe" data-placeholder="choose" onclick="changeTipe()">
                            <option value="2">Container Inward</option>
                            <option value="1">Container Outward</option>
                          </select>
                        </div>
                      </div>
                    </div>

                    <div class="col-md-12 row">
                      <div class="form-group row">
                        <label class="col-md-2 label-sm">Shipment Date</label>
                        <div class="col-md-2">
                          <div class="input-group">
                            <span class="input-group-addon"><input type="checkbox" id="chk1" onclick="chk1_click()"></span>
                            <div class="input-group date-picker input-daterange" name="shipment_date" data-date-format="dd-mm-yyyy">
                              <input type="text" class="form-control date-picker" name="shipment_date" id="shipdate" value="<?php echo $shipdate; ?>">
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="col-md-12 row">
                      <div class="form-group">
                        <div class="col-md-12 col-md-offset-2">
                          <button type="button" class="btn blue fontawesome-font btn-f-refresh" onclick="refresh()"><span class="fa fa-refresh"></span> Refresh</button>
                          <button type="button" class="btn green fontawesome-font" data-toggle="modal" data-target="#containerLocation"><span class="fa fa-map-marker"></span> Container Location</button>
                        </div>
                      </div>
                    </div>


                  </div>
                </div>
              </div>



              <div class="flip-scroll">
                <div class="doc-scroll" style="height: 360px;">
                  <div class="loadReport"></div>
                </div>
              </div>
            </div>
          </div>
          <div class="form-actions">
            <div class="row">
              <div class="col-md-12">
                <button type="button" class="btn btn-primary" id="inward" onclick="shipToInwardList()"><span class=" fa fa-calendar"></span> ship to inward list</button>
                <button type="button" class="btn btn-success" id="outward" onclick="shipToOutwardList()"><span class=" fa fa-calendar"></span> ship to outward list</button>


              </div>
            </div>
          </div>

        </div>

        <?php echo form_close() ?>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="containerLocation" tabindex="-1" role="dialog" aria-labelledby="containerLocationLabel" aria-hidden="true">
  <div class="modal-dialog" role="document" style="width: 1000px;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="containerLocationLabel">Container Location</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="table-responsive" style="height: 400px;">
          <table class="table table-bordered datatables-search" id="table-container-local">
            <thead>
              <tr>
                <th width="10px"></th>
                <th style="vertical-align: middle;" nowrap>Container Number</th>
                <th style="vertical-align: middle;" nowrap>Last Shipment</th>
                <th style="vertical-align: middle;" nowrap>Last Eta</th>
                <th style="vertical-align: middle;" nowrap>Last Etd</th>
              </tr>
              <thead>
              <tbody>
                <?php
                $no = 1;
                foreach ($cont_location as $key => $s) { ?>
                  <tr data-index="<?= $key + 1 ?>">
                    <td><?= $key + 1; ?></td>
                    <td><?= $s->container_number; ?></td>
                    <td><?= setDateFormat($s->shipmentdate, "d F Y"); ?></td>
                    <td><?= $s->eta; ?></td>
                    <td><?= $s->etd; ?></td>
                  </tr>
                <?php
                  $no++;
                }
                ?>
              </tbody>
          </table>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
      </div>
    </div>
  </div>
</div>



<!-- Modal Ship To Outward List -->
<form class="form-inward">
  <div class="modal fade modalInward" id="modalInward" tabindex="-1" role="dialog" aria-labelledby="modalInwardTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalInwardTitle"><b style="font-size: 18px;" id="modalTitle">Ship To Inward List</b></h5>

        </div>
        <div class="modal-body">
          <div class="row m-0 p-0">
            <div class="col-md-8 p-0 m-0">
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <input type="hidden" name="is_inward" id="is_inward">
                    <label for="exampleInputEmail1">Shipment Date</label>
                    <select class="form-control select2me col-md-12" id="contid">
                      <?php foreach ($list_shipment_date as $item) : ?>
                        <option value="<?= $item->contid ?>"><?= setDateFormat($item->shipmentdate, 'd/m/Y') . " From " . $item->etd . " To " . $item->eta ?></option>
                      <?php endforeach; ?>

                    </select>
                    <!-- <input type=" date" class="form-control" id="shipmentDate" aria-describedby="emailHelp" name="shipment_date" value="<?= $cont_header->shipmentdate ?>"> -->
                  </div>
                </div>
              </div>
            </div>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" id="btn-save-iolist" onclick="saveInwardList()">Save</button>
            <button type="button" data-dismiss="modal" class="btn btn-default">Cancel</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</form>

<!-- Modal Ship To Inward List -->
<form class="form-outward">
  <div class="modal fade modalOutward" id="modalOutward" tabindex="-1" role="dialog" aria-labelledby="modalOutwardTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalOutwardTitle2"><b style="font-size: 18px;" id="modalTitle2">Ship To Outward List</b></h5>

        </div>
        <div class="modal-body">
          <div class="row m-0 p-0">
            <div class="col-md-8 p-0 m-0">
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <input type="hidden" name="is_inward" id="is_inward">
                    <label for="exampleInputEmail1">Shipment Date</label>
                    <select class="form-control select2me col-md-12" id="contid2">
                      <?php foreach ($list_shipment_date2 as $item) : ?>
                        <option value="<?= $item->contid ?>"><?= setDateFormat($item->shipmentdate, 'd/m/Y') . " From " . $item->etd . " To " . $item->eta ?></option>
                      <?php endforeach; ?>

                    </select>
                    <!-- <input type=" date" class="form-control" id="shipmentDate" aria-describedby="emailHelp" name="shipment_date" value="<?= $cont_header->shipmentdate ?>"> -->
                  </div>
                </div>
              </div>
            </div>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" id="btn-save-iolist" onclick="saveOutwardList()">Save</button>
            <button type="button" data-dismiss="modal" class="btn btn-default">Cancel</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</form>

<script>
  $("#shipdate").val(""); // checked
  $("#shipdate").prop("disabled", true);
  $("#inward").prop("disabled", true);
  $("#outward").prop("disabled", true);


  function chk1_click() {
    if ($("#chk1").is(':checked')) {
      $("#shipdate").val(""); // checked
      $("#shipdate").prop("disabled", false); // checked
    } else {
      $("#shipdate").prop("disabled", true); // checked

    }

  }

  function shipToInwardList() {
    $('#modalTitle').html('Ship To Inward List');
    $('#modalInward').modal('show');
  }

  function shipToOutwardList() {
    $('#modalTitle2').html('Ship To OutwardList');
    $('#modalOutward').modal('show');
  }

  function saveInwardList() {

    var checkedValues = [];
    var idReceived = [];
    var idLocal = [];
    $("input[name='container_number[]']:checked").each(function() {
      checkedValues.push($(this).val());
      idReceived.push($(this).data("received"));
      idLocal.push($(this).data("local"));
    });

    swal({
        title: "Are you sure?",
        text: "You will not be able to recover this data!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: '#DD6B55',
        confirmButtonText: 'Yes, I am sure!',
        cancelButtonText: "No, cancel it!",
        closeOnConfirm: false,
        closeOnCancel: true,
        showLoaderOnConfirm: true

      },
      function(isConfirm) {

        if (isConfirm) {
          $.ajax({
            type: "post",
            url: "<?php echo site_url('Shipping/save_ship_to_inward') ?>",
            data: {
              tipe: 2,
              contid: $("#contid").val(),
              det_cont: checkedValues,
              det_received_id: idReceived,
              det_local_id: idLocal

            },
            dataType: "JSON",
            beforeSend: function() {
              sambu.startPageLoading()
              $(".btn-f-refresh").prop("disabled", true)

            },
            success: function(response) {

              console.log(response);

              setTimeout(() => {
                sambu.stopPageLoading();


                if (response.code == 200) {
                  $('.loadReport').html(response);
                  $(".btn-f-refresh").prop("disabled", false)
                  swal("Success", "Container Inward Success Created", 'success')
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



  function saveOutwardList() {

    var checkedValues = [];
    var idReceived = [];
    var idLocal = [];
    $("input[name='container_number[]']:checked").each(function() {
      checkedValues.push($(this).val());
      idReceived.push($(this).data("received"));
      idLocal.push($(this).data("local"));
    });

    swal({
        title: "Are you sure?",
        text: "You will not be able to recover this data!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: '#DD6B55',
        confirmButtonText: 'Yes, I am sure!',
        cancelButtonText: "No, cancel it!",
        closeOnConfirm: false,
        closeOnCancel: true,
        showLoaderOnConfirm: true
      },
      function(isConfirm) {

        if (isConfirm) {
          $.ajax({
            type: "post",
            url: "<?php echo site_url('Shipping/save_ship_to_outward') ?>",
            data: {
              tipe: 1,
              contid: $("#contid2").val(),
              det_cont: checkedValues,
              det_received_id: idReceived,
              det_local_id: idLocal

            },
            dataType: "JSON",
            beforeSend: function() {
              sambu.startPageLoading()
              $(".btn-f-refresh").prop("disabled", true)

            },
            success: function(response) {

              console.log(response);

              setTimeout(() => {
                sambu.stopPageLoading();


                if (response.code == 200) {
                  $('.loadReport').html(response);
                  $(".btn-f-refresh").prop("disabled", false)
                  swal("Success", "Container Outward Success Created", 'success')
                  window.location.href = "<?= base_url() ?>shipping/container_show?cont=" + response.message + "&tipe=1";

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
          swal("Cancelled", "Wrong Queries", "error");
        }
      });
  }

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

  // contorlButton()
  $(function() {
    $('input[name="daterange"]').daterangepicker({
      opens: 'left'
    }, function(start, end, label) {
      console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
    });
  });

  $(document).on("click", "#btn_print", function() {
    // alert("test")
  });

  $(".ship-inward-list").click(function() {
    var location = $("#location").find(":selected").val();
    $("#modal-create").modal("show")
    $("select [value=" + location + "]").attr("selected", "selected")

  });

  function refresh() {

    var location = $('#location').find(":selected").val();
    var tipe = $('#tipe').find(":selected").val();

    var ship_date = $("#shipdate").val();
    var cnumber = $("#containerNumber").val();



    $.ajax({
      type: "GET",
      url: "<?php echo site_url('Shipping/get_filter_by_ajax') ?>",
      data: {
        tipe: tipe,
        location: location,
        shipment_date: ship_date,
        // container_number: cnumber

      },
      beforeSend: function() {
        $(".btn-f-refresh").prop("disabled", true)
        $(".btn-f-refresh").html("loading...")

      },
      success: function(msg) {

        setTimeout(() => {
          $(".btn-f-refresh").prop("disabled", false)
          $('.loadReport').html(msg);
          $(".btn-f-refresh").html("Refresh")

          contorlButton()
        }, 2000);
      }
    })
  }

  function save() {

    var data = $(".ship-to-inward").serialize()

    var checkedValues = [];
    var idReceived = [];
    $("input[name='container_number[]']:checked").each(function() {
      checkedValues.push($(this).val());
      idReceived.push($(this).data("received"));
    });

    swal({
        title: "Are you sure?",
        text: "You will not be able to recover this data!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: '#DD6B55',
        confirmButtonText: 'Yes, I am sure!',
        cancelButtonText: "No, cancel it!",
        closeOnConfirm: false,
        closeOnCancel: true
      },
      function(isConfirm) {

        if (isConfirm) {
          $.ajax({
            type: "post",
            url: "<?php echo site_url('Shipping/save_ship_to_inward') ?>",
            data: {
              shipment_date: $("#shipmentDate").val(),
              vessel: $("#vessel").val(),
              voyage: $("#voyage").val(),
              etd: $("#etd-shipment").find(":selected").val(),
              etd_date: $("#etdDate").val(),
              eta: $("#eta-shipment").val(),
              eta_date: $("#etaDate").val(),
              from: $("#from").val(),
              to: $("#to").val(),
              det_cont: checkedValues,
              det_received_id: idReceived,

            },
            dataType: "JSON",
            beforeSend: function() {
              sambu.startPageLoading()
              $(".btn-f-refresh").prop("disabled", true)

            },
            success: function(response) {


              setTimeout(() => {
                sambu.stopPageLoading();


                if (response.code == 200) {
                  $('.loadReport').html(response);
                  $(".btn-f-refresh").prop("disabled", false)
                  swal("Success", "Container Inward Success Created", 'success')
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

  function contorlButton() {

    var tipe = $("#tipe").find(":selected").val();

    if (tipe == 1) {

      $("#inward").prop("disabled", false);
      $("#outward").prop("disabled", true);

    } else if (tipe == 2) {
      $("#inward").prop("disabled", true);
      $("#outward").prop("disabled", false);
    }

  }
</script>