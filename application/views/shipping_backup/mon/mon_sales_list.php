<?php
$date = date("Y-m");
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
              <span class="caption-subject theme-font bold">Monitoring Sales List</span>
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
                        <label class="col-md-2 label-sm">Period</label>
                        <div class="col-md-7">
                          <input type="text" class="form-control input-sm date date-picker" data-date-format="mm-yyyy" id="tgl" value="<?php echo date("m-Y",  strtotime($date)); ?>" required>
                        </div>
                      </div>
                    </div>

                    <div class="col-md-12">
                      <div class="form-group">
                        <div class="col-md-9 col-md-offset-2">
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

              <div class="table-scrollable">
                <table class="table table-bordered" id="tblmon">
                  <thead>
                    <tr>
                      <th>Doc Date</th>
                      <th>Invoice no</th>
                      <th>PO</th>
                      <th>Customer</th>
                      <th>Shipment Date</th>
                      <th>Terms (Days)</th>
                      <th>GST</th>
                      <th>Amount (USD)</th>
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

<script>
  function refresh() {
    $tgl = document.getElementById("tgl").value;

    $.ajax({
      url: "<?php echo base_url(); ?>shipping_mon/mon_sales_list_filter_inv?tgl=" + $tgl + "",
      success: function(response) {
        $("#tbl-mon").html(response);
      },
      dataType: "html"
    });

    return false;
  }

  function excel() {
    $tgl = document.getElementById("tgl").value;

    javascript: location.href = "<?php echo base_url(); ?>shipping_mon/mon_sales_lish_excel?tgl=" + $tgl + "";
  }
</script>