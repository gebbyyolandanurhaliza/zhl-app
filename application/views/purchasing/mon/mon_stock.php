<?php
$date = date("Y-m-d");
?>
<!-- <link href="<?php echo base_url(); ?>assets/admin/css/cloud-admin.css" rel="stylesheet" type="text/css"> -->
<!-- <script src="//code.jquery.com/jquery.min.js"></script> -->
<script src="<?= base_url() ?>assets/jquery.rowspanizer.js-master/jquery.rowspanizer.js"></script>
<div class="page-content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="portlet light">
          <div class="portlet-title">
            <div class="caption">
              <i class="fa fa-list theme-font"></i>
              <span class="caption-subject theme-font bold">Monitoring Stock</span>
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
                        <label class="col-md-2 label-sm">Date</label>
                        <div class="col-md-7">
                          <div class="input-group date-picker input-daterange" data-date="02-12-2012" data-date-format="dd-mm-yyyy">
                            <input type="text" class="form-control input-sm" id="from" value="<?php echo date("d-m-Y",  strtotime($date . ' - 1 months')); ?>" required>
                            <span class="input-group-addon">
                              to </span>
                            <input type="text" class="form-control input-sm" id="to" value="<?php echo date("d-m-Y"); ?>" required>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="form-group">
                        <label class="col-md-2 label-sm">Main GR</label>
                        <div class="col-md-7">
                          <input class="form-control input-sm" type="text" value="" id="mainpo">
                        </div>
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="form-group">
                        <label class="col-md-2 label-sm">Status</label>
                        <div class="col-md-4">
                          <select class="form-control select2me" data-placeholder="status" id="status">
                            <option value=""></option>
                            <option value="1">Full Fill</option>
                            <option value="2">Out Standing</option>
                          </select>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div hidden class="col-md-12">
                      <div class="form-group">
                        <label class="col-md-2 label-sm">NPBB</label>
                        <div class="col-md-7">
                          <input class="form-control input-sm" type="text" value="" id="npbb">
                        </div>
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="form-group">
                        <label class="col-md-2 label-sm">Item</label>
                        <div class="col-md-7">
                          <input class="form-control input-sm" type="text" value="" id="item">
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

              <div class="table-scrollable" style='overflow: auto; height:700px;'>
                <table class="table table-bordered" id="tblmon">
                  <thead>
                    <tr>
                      <th>No PO</th>
                      <th>No GR</th>
                      <th>GR Date</th>
                      <th>No SO</th>
                      <th>Inv No</th>
                      <th>SO Delivery Date</th>

                      <th>Item ID</th>
                      <th>Item Name</th>
                      <th>UOM</th>
                      <th>Qty PO</th>
                      <th>Qty WHS</th>
                      <th>QTY Pending GR</th>
                      <th>Qty Out (SO)</th>
                      <th>Balance Stock</th>
                      <th>Customer</th>
                      <th>Whs</th>
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
    $from = document.getElementById("from").value;
    $to = document.getElementById("to").value;
    $status = document.getElementById("status").value;
    $mainpo = document.getElementById("mainpo").value;
    $item = document.getElementById("item").value;

    if ($from === "" || $to === "") {
      alert("Date cannot empty!");
      return;
    }

    $.ajax({
      url: "<?php echo base_url(); ?>Purchasing_mon/mon_stock_filter?from=" + $from + "&to=" + $to + "&po=" + $mainpo + "&item=" + $item + "&status=" + $status + "",
      success: function(response) {
        $("#tbl-mon").html(response);
        $("#tbl-mon").rowspanizer({
          destroy: true,
          columns: [9, 10, 11, 14]
          // vertical_align: 'middel',
          // conditionColumns: [0]
        });
      },
      dataType: "html"
    });

    return false;
  }

  function excel() {
    $from = document.getElementById("from").value;
    $to = document.getElementById("to").value;
    $status = document.getElementById("status").value;
    $mainpo = document.getElementById("mainpo").value;
    $item = document.getElementById("item").value;

    if ($from === "" || $to === "") {
      alert("Date cannot empty!");
      return;
    }

    javascript: location.href = "<?php echo base_url(); ?>Purchasing_mon/mon_stock_excel?from=" + $from + "&to=" + $to + "&po=" + $mainpo + "&item=" + $item + "&status=" + $status + "";
  }
</script>