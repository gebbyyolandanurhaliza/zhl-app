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
              <span class="caption-subject theme-font bold">Monitoring Purchase Order</span>
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
                        <label class="col-md-2 label-sm">Main PO</label>
                        <div class="col-md-7">
                          <input class="form-control input-sm" type="text" value="" id="mainpo">
                        </div>
                      </div>
                    </div>
                    <div class="col-md-12" hidden="">
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
                        <label class="col-md-2 label-sm">Status</label>
                        <div class="col-md-7">
                          <select class="form-control select2me" data-placeholder="status" id="status">
                            <option value=""></option>
                            <option value="1">Open</option>
                            <option value="2">Closed</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="form-group">
                        <div class="col-md-10 col-md-offset-2">
                          <button class="btn btn-sm btn-info col-md-4" id="btn-refresh" onclick="refresh()">Refresh</button>
                          <a class="btn btn-sm green col-md-4" id="btn-excel" onclick="excel()">Excel</a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <br>
                <hr>
              </div>

              <div class="table-scrollable" style='overflow: auto; height:300px;'>
                <table class="table table-bordered" id="tblmon">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Main PO</th>
                      <th>Doc Date</th>
                      <th>Delivery Date</th>
                      <th>Shipment Date</th>
                      <th>Status</th>
                      <th>Vendor ID</th>
                      <th>Item ID</th>
                      <th>Item Name</th>
                      <th>UOM</th>
                      <th>Qty Order</th>
                      <th>Qty Recv (GR)</th>
                      <th>Qty Pending</th>
                      <th>Price</th>
                      <th>Currency</th>
                      <th>Rate</th>
                      <th>Total</th>
                      <th>Total (USD)</th>
                    </tr>
                  </thead>
                  <tbody id="tbl-mon"></tbody>
                </table>
              </div>

              <div hidden class="row">
                <div class="col-md-5">
                  <div class="table-scrollable">
                    <table class="table table-bordered">
                      <thead>
                        <tr>
                          <th>Vendor ID</th>
                          <th>Vendor Company</th>
                          <th>Contact Person</th>
                        </tr>
                      </thead>
                      <tbody id="tbl-vendor">
                        <tr>
                          <td></td>
                          <td></td>
                          <td></td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
                <div class="col-md-7">
                  <div class="table-scrollable" style='overflow: auto; height:500px;'>
                    <table class="table table-bordered">
                      <thead>
                        <tr>
                          <th>Main PO</th>
                          <th>Doc Date</th>
                          <th>Delivery Date</th>
                          <th>Item ID</th>
                          <th>Item Name</th>
                          <th>Qty Recv</th>
                        </tr>
                      </thead>
                      <tbody id="tbl-whs">
                        <tr>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                        </tr>
                      </tbody>
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
</div>

<script>
  function refresh() {
    $("#tbl-whs tr").remove();
    $("#tbl-vendor tr").remove();

    $from = document.getElementById("from").value;
    $to = document.getElementById("to").value;
    $vendor = document.getElementById("vendor").value;
    $purchaser = document.getElementById("purchaser").value;
    $status = document.getElementById("status").value;
    $mainpo = document.getElementById("mainpo").value;
    $npbb = document.getElementById("npbb").value;
    $item = document.getElementById("item").value;

    if ($from === "" || $to === "") {
      alert("Date cannot empty!");
      return;
    }

    $.ajax({
      url: "<?php echo base_url(); ?>purchasing_mon/mon_purchase_order_filter_po?from=" + $from + "&to=" + $to + "&vendor=" + $vendor + "&pur=" + $purchaser + "&stat=" + $status + "&po=" + $mainpo + "&npbb=" + $npbb + "&item=" + $item + "",
      success: function(response) {
        $("#tbl-mon").html(response);
      },
      dataType: "html"
    });

    return false;
  }

  function clickdb(x) {
    $('#tbl-mon tr').each(function(a, b) {
      $(b).click(function() {
        $('#tbl-mon tr').css('color', '#000000');
        $(this).css('color', '#0000FF');
      });
    });

    function getText(el) {
      if (typeof el.textContent == 'string') return el.textContent;
      if (typeof el.innerText == 'string') return el.innerText;
    }

    $r = x.rowIndex;

    $mainpo = getText(document.getElementById('tblmon').rows[$r].cells[16]);
    $vendor = getText(document.getElementById('tblmon').rows[$r].cells[17]);
    $cust = getText(document.getElementById('tblmon').rows[$r].cells[18]);
    $item = getText(document.getElementById('tblmon').rows[$r].cells[7]);

    WHSQty($mainpo, $item, $cust);
    vendor($vendor);
  }

  function WHSQty(mainpo, item, cust) {
    $.ajax({
      url: "<?php echo base_url(); ?>purchasing_mon/mon_purchase_order_filter_whs?po=" + mainpo + "&item=" + item + "&cust=" + cust + "",
      success: function(response) {
        $("#tbl-whs").html(response);
      },
      dataType: "html"
    });

    return false;
  }

  function vendor(vendor) {
    $.ajax({
      url: "<?php echo base_url(); ?>purchasing_mon/mon_purchase_order_filter_vendor?vendor=" + vendor + "",
      success: function(response) {
        $("#tbl-vendor").html(response);
      },
      dataType: "html"
    });

    return false;
  }

  function excel() {
    $from = document.getElementById("from").value;
    $to = document.getElementById("to").value;
    $vendor = document.getElementById("vendor").value;
    $status = document.getElementById("status").value;
    $mainpo = document.getElementById("mainpo").value;
    $item = document.getElementById("item").value;

    if ($from === "" || $to === "") {
      alert("Date cannot empty!");
      return;
    }

    javascript: location.href = "<?php echo base_url(); ?>purchasing_mon/purchase_order_excel?from=" + $from + "&to=" + $to + "&vendor=" + $vendor + "&pur=" + $purchaser + "&stat=" + $status + "&po=" + $mainpo + "&item=" + $item + "";
  }
</script>