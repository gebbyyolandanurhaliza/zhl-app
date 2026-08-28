<script src="//code.jquery.com/jquery.min.js"></script>
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
              <span class="caption-subject theme-font bold">Monitoring Goods Receipt</span>
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
                        <label class="col-md-2 label-sm">Vendor</label>
                        <div class="col-md-9">
                          <select class="form-control select2me" data-placeholder="Vendor" id="vendor">
                            <option value=""></option>
                            <?php
                            foreach ($vendor as $r) {
                              echo '<option value="' . $r->vendorid . '">' . $r->vendorcompany . '</option>';
                            }
                            ?>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div hidden class="form-group">
                        <label class="col-md-2 label-sm">Purchaser</label>
                        <div class="col-md-9">
                          <select class="form-control select2me" data-placeholder="Purchaser" id="purchaser">
                            <option value=""></option>
                            <?php
                            foreach ($purchaser as $r) {
                              echo '<option value="' . $r->createdby . '">' . $r->createdby . '</option>';
                            }
                            ?>
                          </select>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label class="col-md-2 label-sm">Main GR</label>
                        <div class="col-md-7">
                          <input class="form-control input-sm" type="text" value="" id="docgr">
                        </div>
                      </div>
                    </div>

                    <div class="col-md-12">
                      <div class="form-group">
                        <label class="col-md-2 label-sm">Main PO</label>
                        <div class="col-md-7">
                          <input class="form-control input-sm" type="text" value="" id="mainpo">
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

              <div class="table-scrollable">
                <table class="table table-bordered" id="tblmon">
                  <thead>
                    <tr>
                      <th>No PO</th>
                      <th>Doc Date</th>
                      <th>Delivery Date</th>
                      <th>Main GR</th>
                      <th>Status</th>
                      <th>Item ID</th>
                      <th>Item Name</th>
                      <th>UOM</th>
                      <th>Qty Order</th>
                      <th>Qty Whs(Recv)</th>
                      <th>Qty Outstanding</th>
                      <th hidden>Unit Price</th>
                      <th hidden="">Vendor ID</th>
                      <th>Vendor Company</th>
                      <th>Warehouse</th>
                      <th hidden="">NPBB No</th>
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
  Swal.fire(
    'The Internet?',
    'That thing is still around?',
    'question'
  )

  function refresh() {
    $from = document.getElementById("from").value;
    $to = document.getElementById("to").value;
    $vendor = document.getElementById("vendor").value;
    $docgr = document.getElementById("docgr").value;
    $mainpo = document.getElementById("mainpo").value;
    $item = document.getElementById("item").value;

    if ($from === "" || $to === "") {
      alert("Date cannot empty!");
      return;
    }

    $(document).ajaxStart(function() {
      $('#tbl-mon').html('<tr><td colspan="14" style="text-align:center"><p style="text-align:center;"><img src="<?php echo base_url(); ?>assets/pages/img/loading.gif"></p></td></tr>');
    });

    $.ajax({
      url: "<?php echo base_url(); ?>purchasing_mon/mon_goods_receipt_filter_po?from=" + $from + "&to=" + $to + "&vendor=" + $vendor + "&docgr=" + $docgr + "&item=" + $item + "&mainpo=" + $mainpo + "",
      success: function(response) {
        $("#tbl-mon").html(response);
        $("#tbl-mon").rowspanizer({
          destroy: true,
          columns: [8, 11]
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
    $vendor = document.getElementById("vendor").value;
    $purchaser = document.getElementById("purchaser").value;
    $docgr = document.getElementById("docgr").value;
    $mainpo = document.getElementById("mainpo").value;
    $item = document.getElementById("item").value;

    if ($from === "" || $to === "") {
      alert("Date cannot empty!");
      return;
    }

    javascript: location.href = "<?php echo base_url(); ?>purchasing_mon/goods_receipt_excel?from=" + $from + "&to=" + $to + "&vendor=" + $vendor + "&docgr=" + $docgr + "&item=" + $item + "&mainpo=" + $mainpo + "";
  }
</script>