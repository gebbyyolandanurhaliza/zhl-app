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
              <span class="caption-subject theme-font bold">Monitoring Packing List</span>
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
                        <label class="col-md-2 label-sm">Customer</label>
                        <div class="col-md-9">
                          <select class="form-control select2me" data-placeholder="Customer" id="vendor">
                            <option value=""></option>
                            <?php
                            foreach ($customer as $r) {
                              echo '<option value="' . $r->customer_id . '">' . $r->customer_name . '</option>';
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
                    <div class="col-md-12">
                      <div hidden class="form-group">
                        <label class="col-md-2 label-sm">Status</label>
                        <div class="col-md-4">
                          <select class="form-control select2me" data-placeholder="status" id="status">
                            <option value=""></option>
                            <option value="1">Open</option>
                            <option value="2">Closed</option>
                          </select>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label class="col-md-2 label-sm">Main PL</label>
                        <div class="col-md-7">
                          <input class="form-control input-sm" type="text" value="" id="sono">
                        </div>
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div hidden class="form-group">
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

              <div class="table-scrollable" style='overflow: auto; height:300px;'>
                <table class="table table-bordered" id="tblmon">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Main PL</th>
                      <th>Doc Date</th>
                      <th>Delivery Date</th>
                      <th>Shipment Date</th>
                      <th>Status</th>
                      <th hidden>Vendor ID</th>
                      <th>Item ID</th>
                      <th>Item Name</th>
                      <th>UOM</th>
                      <th>Qty</th>
                      <th hidden>Qty Recv</th>
                      <th>Net Weight</th>
                      <th>Gross Weight</th>
                      <th hidden>Currency</th>
                      <th hidden>NPBB</th>
                      <th>Customer</th>
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
                  <div class="table-scrollable">
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
    $status = document.getElementById("status").value;
    $sono = document.getElementById("sono").value;
    $item = document.getElementById("item").value;

    if ($from === "" || $to === "") {
      alert("Date cannot empty!");
      return;
    }

    $.ajax({
      url: "<?php echo base_url(); ?>purchasing_mon/mon_packing_list_filter?from=" + $from + "&to=" + $to + "&vendor=" + $vendor + "&stat=" + $status + "&sono=" + $sono + "&item=" + $item + "",
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
    $sono = document.getElementById("sono").value
    $item = document.getElementById("item").value;


    if ($from === "" || $to === "") {
      alert("Date cannot empty!");
      return;
    }


    javascript: location.href = "<?php echo base_url(); ?>purchasing_mon/packing_list_excel?from=" + $from + "&to=" + $to + "&vendor=" + $vendor + "&stat=" + $status + "&sono=" + $sono + "&item=" + $item + "";

  }
</script>