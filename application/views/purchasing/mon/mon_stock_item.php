<!-- <script src="//code.jquery.com/jquery.min.js"></script> -->
<script src="<?= base_url() ?>assets/jquery.rowspanizer.js-master/jquery.rowspanizer.js"></script>
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
              <span class="caption-subject theme-font bold">Monitoring Stock Item</span>
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
                            <input type="text" class="form-control input-sm" id="tanggal" value="<?php echo date("d-m-Y"); ?>" required>
                          </div>
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

              <div class="table-scrollable" style='overflow: auto; height:500px;'>
                <table class="table table-bordered" id="tblmon">
                  <thead>
                    <tr>
                      <th style="width: 100px;">Warehouse</th>
                      <th style="width: 100px;">Item ID</th>
                      <th style="width: 100px;">Item Name</th>
                      <th>UOM</th>
                      <th>Balance Stock</th>
                      <!-- <th>QTY OUT</th> -->

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
    // $from = document.getElementById("from").value;
    $tanggal = document.getElementById("tanggal").value;
    $item = document.getElementById("item").value;
    // alert($tanggal);
    if ($tanggal === "") {
      alert("Date cannot empty!");
      return;
    }

    $.ajax({
      url: "<?php echo base_url(); ?>Purchasing_mon/mon_stock_filter_item?tanggal=" + $tanggal + "&item=" + $item + "",
      success: function(response) {
        $("#tbl-mon").html(response);
        $("#tbl-mon").html(response);
        // $("#tbl-mon").rowspanizer({
        //     destroy: true,
        //     columns: [0]

        // });
      },
      dataType: "html"
    });

    return false;
  }

  function excel() {
    // $from = document.getElementById("from").value;
    // $to = document.getElementById("to").value;
    $tanggal = document.getElementById("tanggal").value;
    $item = document.getElementById("item").value;
    if ($tanggal === "") {
      alert("Date cannot empty!");
      return;
    }

    javascript: location.href = "<?php echo base_url(); ?>Purchasing_mon/mon_stock_item_excel?tanggal=" + $tanggal + "&item=" + $item + "";
  }
</script>