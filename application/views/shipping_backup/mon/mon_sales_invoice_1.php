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
              <span class="caption-subject theme-font bold">Monitoring Sales Invoice</span>
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
                          <select class="form-control select2me" data-placeholder="Customer" id="cust">
                            <option value=""></option>
                            <?php
                            foreach ($cust as $r) {
                              echo '<option value="' . $r->customer_code . '">' . $r->customer_company_name . '</option>';
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
                        <label class="col-md-2 label-sm">Invoice No</label>
                        <div class="col-md-7">
                          <input class="form-control input-sm" type="text" value="" id="invno">
                        </div>
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="form-group">
                        <label class="col-md-2 label-sm">PO Number</label>
                        <div class="col-md-7">
                          <input class="form-control input-sm" type="text" value="" id="po">
                        </div>
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="form-group">
                        <label class="col-md-2 label-sm">Product</label>
                        <div class="col-md-7">
                          <input class="form-control input-sm" type="text" value="" id="product">
                        </div>
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="form-group">
                        <div class="col-md-9 col-md-offset-2">
                          <button class="btn btn-sm btn-info col-md-3" id="btn-refresh" onclick="refresh()">Refresh</button>
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
                      <th>#</th>
                      <th>Invoice no</th>
                      <th>Doc Date</th>
                      <th>Due Date</th>
                      <th>Shipment Date</th>
                      <th>Customer</th>
                      <th>Status</th>
                      <th>Po Number</th>
                      <th>Product ID</th>
                      <th>Product Name</th>
                      <th>Currency</th>
                      <th>Qty</th>
                      <th>Unit Price</th>
                      <th>Total</th>
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
    $cust = document.getElementById("cust").value;
    $invno = document.getElementById("invno").value;
    $po = document.getElementById("po").value;
    $product = document.getElementById("product").value;

    if ($from === "" || $to === "") {
      alert("Date cannot empty!");
      return;
    }

    $.ajax({
      url: "<?php echo base_url(); ?>shipping_mon/mon_sales_invoice_filter_inv?from=" + $from + "&to=" + $to + "&cust=" + $cust + "&inv=" + $invno + "&po=" + $po + "&product=" + $product + "",
      success: function(response) {
        $("#tbl-mon").html(response);
      },
      dataType: "html"
    });

    return false;
  }
</script>