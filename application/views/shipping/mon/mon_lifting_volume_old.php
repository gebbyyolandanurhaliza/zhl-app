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
                        <th rowspan="2">No.</th>
                        <th rowspan="2">Shipping Line</th>
                        <th rowspan="2">Destination</th>
                        <th colspan="6">Total Amount</th>
                        <th colspan="6">Jan</th>
                        <th colspan="6">Feb</th>
                        <th colspan="6">Mar</th>
                        <th colspan="6">Apr</th>
                        <th colspan="6">May</th>
                        <th colspan="6">Jun</th>
                        <th colspan="6">Jul</th>
                        <th colspan="6">Aug</th>
                        <th colspan="6">Sep</th>
                        <th colspan="6">Oct</th>
                        <th colspan="6">Nov</th>
                        <th colspan="6">Dec</th>
                      </tr>
                      <tr>
                        <th>20ft</th>
                        <th>20ft rf</th>
                        <th>40ft</th>
                        <th>40ft rf</th>
                        <th>40ft HQ</th>
                        <th>40ft HQ rf</th>
                        <th>20ft</th>
                        <th>20ft rf</th>
                        <th>40ft</th>
                        <th>40ft rf</th>
                        <th>40ft HQ</th>
                        <th>40ft HQ rf</th>
                        <th>20ft</th>
                        <th>20ft rf</th>
                        <th>40ft</th>
                        <th>40ft rf</th>
                        <th>40ft HQ</th>
                        <th>40ft HQ rf</th>
                        <th>20ft</th>
                        <th>20ft rf</th>
                        <th>40ft</th>
                        <th>40ft rf</th>
                        <th>40ft HQ</th>
                        <th>40ft HQ rf</th>
                        <th>20ft</th>
                        <th>20ft rf</th>
                        <th>40ft</th>
                        <th>40ft rf</th>
                        <th>40ft HQ</th>
                        <th>40ft HQ rf</th>
                        <th>20ft</th>
                        <th>20ft rf</th>
                        <th>40ft</th>
                        <th>40ft rf</th>
                        <th>40ft HQ</th>
                        <th>40ft HQ rf</th>
                        <th>20ft</th>
                        <th>20ft rf</th>
                        <th>40ft</th>
                        <th>40ft rf</th>
                        <th>40ft HQ</th>
                        <th>40ft HQ rf</th>
                        <th>20ft</th>
                        <th>20ft rf</th>
                        <th>40ft</th>
                        <th>40ft rf</th>
                        <th>40ft HQ</th>
                        <th>40ft HQ rf</th>
                        <th>20ft</th>
                        <th>20ft rf</th>
                        <th>40ft</th>
                        <th>40ft rf</th>
                        <th>40ft HQ</th>
                        <th>40ft HQ rf</th>
                        <th>20ft</th>
                        <th>20ft rf</th>
                        <th>40ft</th>
                        <th>40ft rf</th>
                        <th>40ft HQ</th>
                        <th>40ft HQ rf</th>
                        <th>20ft</th>
                        <th>20ft rf</th>
                        <th>40ft</th>
                        <th>40ft rf</th>
                        <th>40ft HQ</th>
                        <th>40ft HQ rf</th>
                        <th>20ft</th>
                        <th>20ft rf</th>
                        <th>40ft</th>
                        <th>40ft rf</th>
                        <th>40ft HQ</th>
                        <th>40ft HQ rf</th>
                        <th>20ft</th>
                        <th>20ft rf</th>
                        <th>40ft</th>
                        <th>40ft rf</th>
                        <th>40ft HQ</th>
                        <th>40ft HQ rf</th>
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

    console.log("<?php echo base_url(); ?>shipping_mon/mon_lifting_volume_filter?year=" + $year + "");


    $(document).ajaxStart(function() {
      $('#tbl-mon').html('<p style="text-align:center;"><img src="<?php echo base_url(); ?>assets/pages/img/loading.gif"></p>');
    });


    $.ajax({
      url: "<?php echo base_url(); ?>shipping_mon/mon_lifting_volume_filter?year=" + $year + "",
      success: function(response) {
        $("#tbl-mon").html(response);
      },
      dataType: "html"
    });

    return false;
  }

  function excel() {
    $year = document.getElementById("year").value;

    javascript: location.href = "<?php echo base_url(); ?>shipping_mon/mon_total_sales_excel?year=" + $year + "";
  }
</script>