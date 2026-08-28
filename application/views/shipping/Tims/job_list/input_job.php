<div class="page-content">
  <div class="container-fluid">
    <div class="row ">
      <div class="col-md-12">
        <div class="portlet light">
          <div class="portlet-title">
            <div class="caption">
              <i class="fa fa-car theme-font"></i>
              <span class="caption-subject theme-font uppercase"><?php echo $header_title; ?></span>
            </div>

            <div class="tools">
              <a href="javascript:;" class="collapse"></a>
            </div>

          </div>

          <?php echo $this->session->flashdata('message'); ?>

          <div class="portlet-body form" id="save_as_new">
            <form action="<?php echo $action; ?>" id="form-data" method="post" class="form-horizontal" irole="form">
              <div class="form-body">
                <div class="col-md-1 pull-right"></div>
                <div class="form-group">
                  <div class="col-md-12">
                    <div class="panel panel-default">
                      <div class="panel-body">

                        <div class="form-group required">

                          <label class="col-md-1 control-label" for="varchar">Current Date</label>
                          <div class="col-md-2">
                            <input type="text" class="form-control date <?= $date_picker ?>" name="current_date" placeholder="DD/MM/YYYY" value="<?= $current_date ?>" readonly required />
                          </div>

                          <div class="col-md-4"></div>

                          <?php 
                             if($trigger == 'edit'){
                          ?>

                          <label class="col-md-1 control-label" for="varchar">Filter By Driver</label>
                          <div class="col-md-3">
                              <select id="id_vehicle_filter" class="form-control select2">
                                    <option value="">Choose Vehicle</option>
                                    <?php
                                    foreach ($vehicle as $ve) { ?>
                                      <option value="<?= $ve->id_vehicle ?>"><?= $ve->vehicle_no . "(" . $ve->driver_name . ")" ?></option>
                                    <?php
                                    }
                                    ?>
                                  </select>
                          </div>
                          <div class="col-md-1">
                             <button class="btn btn-success" id="filterbutton"><i class="fa fa-search"></i></button>
                          </div>

                          <?php 
                             }
                          ?>
                        </div>
                      </div>

                    </div>
                  </div>
                </div>
              </div>

              <div>
                <div class="table-scrollable">
                  <table class="table-bordered table-striped table-condensed table-hover scrollable" id="tabel" width="100%">
                    <thead>
                      <tr>
                        <th colspan="8" class="schedule-info bg-info" nowrap style="text-align:center">SCHEDULE </th>
                      </tr>

                      <tr class="double-border-bottom">
                        <th>
                          <!-- <a class="btn green" onclick="tambah_job()"><i class="fa fa-plus fa-3x fa-fw"></i> </a> -->
                        </th>
                        <th class="text-center">CLIENTS</th>
                        <th class="text-center">STATUS</th>
                        <th class="text-center">JOB</th>
                        <th class="text-center">VEHICLE</th>
                        <th class="text-center">TIME</th>
                        <th class="text-center">SEND TO</th>
                      </tr>
                    </thead>
                    <tbody id="dtl_item">
                      <?php
                      if (isset($dtl)) {
                        foreach ($dtl as $val) { ?>
                          <tr>
                            <td>
                              <?php
                              $disable = "disabled";
                              if ($val->status != 'Complete') {
                                $disable = "";
                                echo '<button class="btn red" onclick="hapus_baris(this,event)" data-id="' . $val->id_job_dtl . '" ><i class="fa fa-trash"></i></button>';
                              }else{
                                echo '<button class="btn btn-warning" onclick="restore_baris(this,event)" data-id="' . $val->id_job_dtl . '" title="Restore Data" ><i class="fa fa-refresh"></i></button>';
                              }
                              ?>
                              <input type="hidden" name="id_job_dtl[]" value="<?= $val->id_job_dtl ?>" class="id_job_dtl txt" <?= $disable ?> required>
                            </td>
                            <td>
                              <select name="client_id[]" class="form-control clients select2" <?= $disable ?> required>
                                <option value="">Choose </option>
                                <?php
                                foreach ($customers as $cus) { ?>
                                  <option value="<?= $cus->customer_code ?>" <?= $cus->customer_code == $val->client_id ? 'selected' : '' ?>><?= $cus->customer_name ?></option>
                                <?php
                                }
                                ?>
                              </select>
                            </td>
                            <td>
                              <select name="status_cont[]" class="form-control select2">
                                <option value="">Choose Status</option>
                                <option value="Laden" <?= $val->status_cont == "Laden" ? 'selected' : '' ?>>Laden</option>
                                <option value="Empty" <?= $val->status_cont == "Empty" ? 'selected' : '' ?>>Empty</option>
                              </select>
                            </td>
                            <td>
                              <input type="text" name="job[]" value="<?= $val->job ?>" class="form-control job txt" <?= $disable ?> placeholder="Input Job Here" required>
                            </td>
                            <td>
                              <select name="id_vehicle[]" class="form-control select2" <?= $disable ?> required>
                                <option value="">Choose Vehicle</option>
                                <?php
                                foreach ($vehicle as $ve) { ?>
                                  <option value="<?= $ve->id_vehicle ?>" <?= $ve->id_vehicle == $val->id_vehicle ? 'selected' : '' ?>><?= $ve->vehicle_no . "(" . $ve->driver_name . ")" ?></option>
                                <?php
                                }
                                ?>
                              </select>
                            </td>
                            <td>
                              <input type="time" name="time[]" value="<?= $val->time ?>" class="form-control time txt" <?= $disable ?> required>
                            </td>
                            <td>
                              <input type="text" name="send_to[]" value="<?= $val->send_to ?>" class="form-control send_to txt" <?= $disable ?> placeholder="Input Send To" required>
                            </td>
                          </tr>
                      <?php
                        }
                      }
                      ?>
                    </tbody>
                  </table>
                </div>

              </div>

              <div class="form-actions">
                <div class="row">
                  <div class="col-md-12">
                    <div class="row">
                      <div class="col-md-10">
                      <a class="btn btn-primary" onclick="tambah_job()"><i class="fa fa-plus fa-3x fa-fw"></i> Add Row </a>
                        <button type="submit" class="btn green w-100" onclick="return confirm('Are you sure to save the data?')"><?php echo $button ?></button>
                        <a href="<?php echo site_url('tims/job-add') ?>" class="btn red"><i class="fa fa-close fa-3x fa-fw"></i> Cancel</a>
                      </div>
                      <div class="col-md-2">
                        <button type="button" class=" col-md-2 btn btn-block btn-warning" onclick="fnDialogModalFind()"><i class="fa fa-search fa-3x fa-fw"></i> Find</button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </form>
          </div>

        </div>
      </div>
    </div>
  </div>
</div>

<!-- modal Find -->
<div id="modalDialogFind" hidden>
  <div class='portlet-body'>
    <div class="col-md-12">
      <div class="form-group">
        <label class="col-md-2 label-sm">Current Date Start</label>
        <div class="col-md-2">
          <input type="text" id="current_date_start" class="form-control input-sm date date-picker" value="<?= date('01/m/Y') ?>" tabindex="-1">
        </div>
      </div>
      <div class="form-group">
        <label class="col-md-2 label-sm">Current Date End</label>
        <div class="col-md-2">
          <input type="text" id="current_date_end" class="form-control input-sm date date-picker" value="<?= date('t/m/Y') ?>" tabindex="-1">
        </div>
      </div>
      <div class="col-md-2">
        <div class='form-group'>
          <button type='button' class='col-md-1 btn blue btn-block' onclick='filterJoball()'>Search</button>
        </div>
      </div>
    </div>
    <br><br>

    <div class='table-scrollable' style='overflow: auto; height:490px;'>
      <table id='tbl-find' class='table table-bordered table-striped'>
        <thead>
          <tr>
            <th class="text-center">Action</th>
            <th class="text-center">Current Date</th>
            <th class="text-center">Create By</th>
            <th class="text-center">Create Date</th>
          </tr>
        </thead>
        <tbody id='findBody'></tbody>
      </table>
      <div class="text-center" id="loader" style="display:none">
        <h2><i class="fa fa-spinner fa fa-spin"></i></h2>
        <p>Loading...</p>
      </div>
    </div>
  </div>
</div>


<script>
  $(document).ready(function() {
    $('.select2').select2({
      width: '100%'
    });
  });

  $('.date-picker').datepicker({
    format: 'dd/mm/yyyy',
    autoclose: true
  });

  function tambah_job() {
    var num = 1;

    $.ajax({
      url: "<?php echo base_url('Tims/select'); ?>",
      type: 'GET',
      dataType: 'json',
      success: function(data) {
        var row = $(`<tr>
                        <td>
                          <button class="btn red" onclick="hapus_baris(this,event)" data-id=""><i class="fa fa-trash"></i></button>
                        </td>
                        <td>
                          <select name="client_id[]" class="form-control select2" required>${generateCustomer(data.customer)}</select>
                        </td>
                        <td>
                          <select name="status_cont[]" class="form-control select2">
                            <option value="">Choose Status</option>
                            <option value="Laden">Laden</option>
                            <option value="Empty">Empty</option>
                          </select>
                        </td>
                        <td>
                        <input type="text" name="job[]" class="job form-control txt" placeholder="Input Job Here">
                        </td>
                        <td>
                          <select name="id_vehicle[]" class="form-control select2" required>${generateVehicle(data.vehicle)}</select>
                        </td>
                        <td>
                        <input type="time" name="time[]" class="form-control time txt">
                        </td>
                        <td>
                            <input type="text" name="send_to[]" class="form-control send_to txt" placeholder="Input Send To">
                        </td>
                  </tr>`);

        $('#tabel').append(row);
        initSelect2(row);
      },
      error: function(data) {
        console.log('Error fetching vehicle data:', data);
      }
    });
  }

  function initSelect2(row) {
    row.find('.select2').select2({
      width: '100%'
    });
  }

  function generateVehicle(data) {
    var options = '<option value="">Choose Vehicle</option>';
    for (var i = 0; i < data.length; i++) {
      options += '<option value="' + data[i].id_vehicle + '">' + data[i].vehicle_no + '(' + data[i].driver_name + ')</option>';
    }
    return options;
  }

  function generateCustomer(data) {
    var options = '<option value="">Choose Clients</option>';
    for (var i = 0; i < data.length; i++) {
      options += '<option value="' + data[i].customer_code + '">' + data[i].customer_name + '</option>';
    }
    return options;
  }

  // function getCustomerData(selectElement) {

  //   var selectedOption = $(selectElement).find(':selected');
  //   var driverId = selectedOption.data('driver-id');
  //   var row = $(selectElement).closest('tr');

  //   // Update the driver_id input field in the same row
  //   row.find('.id_driver').val(driverId);
  // }

  // function getDriverData(selectElement) {

  //   var selectedOption = $(selectElement).find(':selected');
  //   var driverId = selectedOption.data('driver-id');
  //   var row = $(selectElement).closest('tr');

  //   // Update the driver_id input field in the same row
  //   row.find('.id_driver').val(driverId);
  // }

  function hapus_baris(button, event) {

    event.preventDefault();

    var userConfirmed = confirm("Do you want to delete this item ? the item cannot be restore !!");
    if (userConfirmed) {

      var id = $(button).data('id');
      var row = $(button).closest('tr');

          if (id != "") {
            $.ajax({
              type: "post",
              url: "<?= site_url('Tims/delete_job_dtl') ?>",
              data: {
                id: id
              },
              dataType: "json",
              success: function(response) {
                console.log(response);
                if (response.msg == "success") {
                  row.remove();
                }
              }
            });
          } else {
            row.remove();
          }
    }
   
  }

  function restore_baris(button, event) {

      event.preventDefault();

      var userConfirmed = confirm("Do you want to restore this item ?");
      if (userConfirmed) {

        var id = $(button).data('id');
        var row = $(button).closest('tr');

            if (id != "") {
              $.ajax({
                type: "post",
                url: "<?= site_url('tims/restore_job_dtl') ?>",
                data: {
                  id: id
                },
                dataType: "json",
                success: function(response) {
                
                  if (response.msg == "success") {
                    location.reload("<?=site_url('tims/job-edit/')?>/" + id)
                  }
                }
              });
            } 
      }

}

$('#filterbutton').click(function (e) { 
  e.preventDefault();

   $('#dtl_item').html("");

  // current Date
  var tgl = $("input[name='current_date']").val();
  var vehicle = $('#id_vehicle_filter').val();


   $.ajax({
    type: "get",
    url: "<?=site_url('tims/filter')?>",
    data: {
       tgl:tgl,
       vehicle:vehicle
    },
    dataType: "html",
    success: function (response) {
      $('#dtl_item').html(response);
    }
   });
});

  function fnDialogModalFind() {
    // Define the Dialog and its properties.
    $("#modalDialogFind").dialog({
      resizable: false,
      modal: true,
      title: "List Job Driver",
      height: 650,
      width: 1200

    });
  }

  function filterJoball() {
    var current_date_start = document.getElementById("current_date_start").value;
    var current_date_end = document.getElementById("current_date_end").value;

    $("#findBody").html("");

    $.ajax({
      url: "<?php echo base_url(); ?>tims/findJob",
      data: {
        current_date_start: current_date_start,
        current_date_end: current_date_end
      },
      method: 'GET',
      dataType: "html",
      beforeSend: function() {
        $("#loader").show();
      },
      success: function(response) {
        if (response == '') {
          $("#findBody").html("<tr><td class='text-center' colspan='4'>List Empty</td></tr>");
        } else {
          $("#findBody").html(response);
        }

      },
      complete: function() {
        $("#loader").hide();
      }
    });
  }
</script>