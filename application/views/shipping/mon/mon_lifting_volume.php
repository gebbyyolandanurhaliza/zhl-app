<?php
$date = date("Y-m-d");
?>
<!-- <link href="<?php echo base_url(); ?>assets/admin/css/cloud-admin.css" rel="stylesheet" type="text/css"> -->

<div class="page-content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="portlet light">
          <div class="portlet-title">
            <div class="caption">
              <i class="fa fa-list theme-font"></i>
              <span class="caption-subject theme-font bold">Monitoring Lifting Volume</span>
            </div>
            <div class="tools">
              <a href="javascript:;" class="collapse"></a>
              <a href="javascript:;" class="fullscreen"></a>
            </div>
          </div>
          <div class="portlet-body">
            <div class="form-body">
              <div class="col-md-12">
                <div class="row">
                  <div class="col-md-6">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label class="col-md-3 label-sm">Year</label>
                        <div class="col-md-6">
                          <select class="form-control select2me" id="year">
                            <?php foreach ($tahun as $thn) { ?>
                              <option value="<?php echo $thn->tahun; ?>"><?php echo $thn->tahun ?></option>
                            <?php } ?>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="form-group">
                        <label class="col-md-3 label-sm">Year</label>
                        <div class="col-md-6">
                          <select class="form-control select2me" id="year">
                            <?php foreach ($tahun as $thn) { ?>
                              <option value="<?php echo $thn->tahun; ?>"><?php echo $thn->tahun ?></option>
                            <?php } ?>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="form-group">
                        <label class="col-md-3 label-sm">Container</label>
                        <div class="col-md-6">
                          <select class="form-control select2me" id="cont">
                            <option value="20ft">Container 20ft Standard</option>
                            <option value="20ftrf">Container 20ft Reefer</option>
                            <option value="40ft">Container 40ft Standard</option>
                            <option value="40ftrf">Container 40ft Reefer</option>
                            <option value="40fthq">Container 40ft High Cube</option>
                            <option value="40fthqrf">Container 40ft High Cube Reefer</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="form-group">
                        <div class="col-md-9 col-md-offset-3">
                          <button class="btn btn-sm btn-info col-md-3" id="btn-refresh" onclick="refresh()">Refresh</button>
                          <a class="btn btn-sm green col-md-3" id="btn-excel" onclick="excel()">Excel</a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <br>
                <hr>
              </div>

              <div id="tbl-design">
                <div class="table-scrollable">
                  <table class="table table-bordered" id="tblmon">
                    <thead>
                      <tr>
                        <th rowspan="1">No.</th>
                        <th rowspan="1">Shipping Line</th>
                        <th rowspan="1">Destination</th>
                        <th colspan="1" width="100px">Total Amount (Year)</th>
                        <th colspan="1" width="100px">January</th>
                        <th colspan="1" width="100px">February</th>
                        <th colspan="1" width="100px">March</th>
                        <th colspan="1" width="100px">April</th>
                        <th colspan="1" width="100px">May</th>
                        <th colspan="1" width="100px">June</th>
                        <th colspan="1" width="100px">July</th>
                        <th colspan="1" width="100px">August</th>
                        <th colspan="1" width="100px">September</th>
                        <th colspan="1" width="100px">October</th>
                        <th colspan="1" width="100px">November</th>
                        <th colspan="1" width="100px">December</th>
                      </tr>
                    </thead>
                    <tbody id="tbl-mon"></tbody>
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
    $year = document.getElementById("year").value;
    $cont = document.getElementById("cont").value;

    console.log("<?php echo base_url(); ?>shipping_mon/mon_lifting_volume_filter?year=" + $year + "&cont=" + $cont + "");


    $(document).ajaxStart(function() {
      $('#tbl-mon').html('<p style="text-align:center;"><img src="<?php echo base_url(); ?>assets/pages/img/loading.gif"></p>');
    });


    $.ajax({
      url: "<?php echo base_url(); ?>shipping_mon/mon_lifting_volume_filter?year=" + $year + "&cont=" + $cont + "",
      success: function(response) {
        $("#tbl-mon").html(response);
      },
      dataType: "html"
    });

    return false;
  }

  function excel() {
    $year = document.getElementById("year").value;
    $cont = document.getElementById("cont").value;

    javascript: location.href = "<?php echo base_url(); ?>shipping_mon/to_excel_lifting?year=" + $year + "&cont=" + $cont + "";
  }
</script>