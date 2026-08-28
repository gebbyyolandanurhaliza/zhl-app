<script>
  $(document).ready(function() {

    $('#btn-excel').attr('disabled', true);
    $('#btn-excel-inward').attr('disabled', true);
    $('#btn-excel-vessel').attr('disabled', true);
    $('#btn-print').attr('disabled', true);
  });
</script>

<!-- <link href="<?php echo base_url(); ?>assets/admin/css/cloud-admin.css" rel="stylesheet" type="text/css"> -->

<div class="page-content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="portlet light">
          <div class="portlet-title">
            <div class="caption">
              <i class="fa fa-list theme-font"></i>
              <span class="caption-subject theme-font bold">Monitoring Summary Job</span>
            </div>
            <div class="tools">
              <a href="javascript:;" class="collapse"></a>
              <a href="javascript:;" class="fullscreen"></a>
            </div>
          </div>
          <div class="portlet-body">
            <div class="form-body">
              <form action="<?php echo site_url('shipping_mon/container_print_summary_driver_job'); ?>" method="post" role="form">
                <div class="col-md-12">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label class="col-md-2 label-sm">Shipment Date</label>
                          <div class="col-md-4">
                            <div class="input-group">
                              <input type="text" class="form-control input-sm date-picker" data-date="02-12-2012" data-date-format="dd-mm-yyyy" name="current_date" id="current_date" value="<?php echo date("d-m-Y"); ?>">
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="form-group">
                          <div class="col-md-12 col-md-offset-2">
                            <button type="button" class="btn btn-primary col-md-2" id="btn-refresh" onclick="refresh()"><i class="fa fa-refresh"></i> Refresh</button>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <br>
                </div>
              </form>

              <div class="table-scrollable" style="overflow: auto; height: 550px;">
                <div class="table-scrollable">
                  <table class="table table-bordered" id="tblmondriver">
                    <thead>
                      <tr>
                        <th nowrap>Current Date</th>
                        <th nowrap>Vehicle No</th>
                        <th nowrap>Driver Name</th>
                        <th nowrap>Job</th>
                        <th nowrap>Client</th>
                        <th nowrap>Time</th>
                        <th nowrap>Status</th>
                        <th nowrap>Send To</th>
                        <th nowrap>Chasis</th>
                        <th nowrap>Amount</th>
                        <!-- <th style='display:none;'>Weight</th> -->
                      </tr>
                    </thead>
                    <tbody id="tbl-mondriver"></tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  function refresh() {

    $currentdate = document.getElementById('current_date').value;
    console.log($currentdate);
    // alert($currentdate);

    $.ajax({
      url: "<?php echo base_url(); ?>shipping_mon/mon_driver_job_filter?current_date=" + $currentdate,
      success: function(response) {
        console.log(response);
        $("#tbl-mondriver").html(response);

      },
      dataType: "html"
    });

    return false;

  }

  // function excel() {
  //     $shipdate = "";
  //     $factory = "";
  //     $shipmonth = "";
  //     $chk1 = document.getElementById('chk1').checked;
  //     $chk2 = document.getElementById('chk2').checked;
  //     $chm = document.getElementById('chm').checked;
  //     $ves = document.getElementById('vessel').value;


  //     if ($chk1) {
  //         $shipdate = document.getElementById('shipdate').value;
  //     }
  //     if ($chk2) {
  //         $factory = document.getElementById('factory').value;
  //     }
  //     if ($chm) {
  //         $shipmonth = document.getElementById('shipmonth').value;
  //     }

  //     javascript: location.href = "<?php echo base_url(); ?>shipping_mon/summary_report?ship=" + $shipdate + "&fac=" + $factory + "&ves=" + $ves + "&shipmonth=" + $shipmonth;

  // }

  // function print() {
  //     $shipdate = "";
  //     $factory = "";
  //     $chk1 = document.getElementById('chk1').checked;
  //     $chk2 = document.getElementById('chk2').checked;
  //     $ves = document.getElementById('vessel').value;


  //     if ($chk1) {
  //         $shipdate = document.getElementById('shipdate').value;
  //     }
  //     if ($chk2) {
  //         $factory = document.getElementById('factory').value;
  //     }

  //     javascript: location.target = "_blank";
  //     javascript: location.href = "<?php echo base_url(); ?>shipping_mon/container_print_summary_driver_job?ship=" + $shipdate + "&fac=" + $factory + "&ves=" + $ves;


  // }
</script>