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
              <span class="caption-subject theme-font bold">Monitoring Total Sales</span>
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
                            <?php
                            $n = date('Y');
                            for ($i = $year->year; $i <= $n + 5; $i++) {
                              echo '<option value="' . $i . '">' . $i . '</option>';
                            }
                            ?>
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
                        <th rowspan="2">Group Product</th>
                        <th rowspan="2">UOM</th>
                        <th colspan="3">Total</th>
                        <th colspan="3">Jan</th>
                        <th colspan="3">Feb</th>
                        <th colspan="3">Mar</th>
                        <th colspan="3">Apr</th>
                        <th colspan="3">May</th>
                        <th colspan="3">Jun</th>
                        <th colspan="3">Jul</th>
                        <th colspan="3">Aug</th>
                        <th colspan="3">Sep</th>
                        <th colspan="3">Oct</th>
                        <th colspan="3">Nov</th>
                        <th colspan="3">Dec</th>
                      </tr>
                      <tr>
                        <th>Qty</th>
                        <th>US$</th>
                        <th>@</th>
                        <th>Qty</th>
                        <th>US$</th>
                        <th>@</th>
                        <th>Qty</th>
                        <th>US$</th>
                        <th>@</th>
                        <th>Qty</th>
                        <th>US$</th>
                        <th>@</th>
                        <th>Qty</th>
                        <th>US$</th>
                        <th>@</th>
                        <th>Qty</th>
                        <th>US$</th>
                        <th>@</th>
                        <th>Qty</th>
                        <th>US$</th>
                        <th>@</th>
                        <th>Qty</th>
                        <th>US$</th>
                        <th>@</th>
                        <th>Qty</th>
                        <th>US$</th>
                        <th>@</th>
                        <th>Qty</th>
                        <th>US$</th>
                        <th>@</th>
                        <th>Qty</th>
                        <th>US$</th>
                        <th>@</th>
                        <th>Qty</th>
                        <th>US$</th>
                        <th>@</th>
                        <th>Qty</th>
                        <th>US$</th>
                        <th>@</th>
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

    $.ajax({
      url: "<?php echo base_url(); ?>shipping_mon/mon_total_sales_filter?year=" + $year + "",
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