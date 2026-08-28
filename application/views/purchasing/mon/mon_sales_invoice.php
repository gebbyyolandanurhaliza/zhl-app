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
                    <div class="col-md-12" hidden>
                      <div class="form-group">
                        <label class="col-md-2 label-sm" hidden>Purchaser</label>
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
                        <label class="col-md-2 label-sm">Invoice No</label>
                        <div class="col-md-7">
                          <input class="form-control input-sm" type="text" value="" id="invno">
                        </div>
                      </div>
                    </div>


                    <div class="col-md-12">
                      <div class="form-group">
                        <label class="col-md-2 label-sm">SO No</label>
                        <div class="col-md-7">
                          <input class="form-control input-sm" type="text" value="" id="sono">
                        </div>
                      </div>
                    </div>
                    <div hidden class="col-md-12">
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
                          <!-- <button class="btn btn-sm btn col-md-3" id="btn-print" onclick="printtopdf()" hidden>
                                                        Print PDF
                                                    </button> -->
                          <button class="btn btn-sm btn col-md-3" id="btn-print" onclick="printtoexcel()">
                            Print Excel
                          </button>
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
                      <th>SO No</th>
                      <th>Doc Date</th>
                      <th>Due Date</th>
                      <th>Shipment Date</th>
                      <th>Customer</th>
                      <th>Status</th>
                      <th>MainPO</th>
                      <th>Item ID</th>
                      <th>Item Name</th>
                      <th>Currency</th>
                      <th>Qty</th>
                      <!-- <th></th> -->
                      <th>Unit Price</th>
                      <th>Total</th>
                      <!-- <th>Commision</th> -->
                      <th>Invoice Price</th>
                      <!-- <th>Total Income</th> -->
                      <th>Grand Total</th>
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
    $purchaser = document.getElementById("purchaser").value;
    $invno = document.getElementById("invno").value;
    $mainpo = document.getElementById("mainpo").value;
    $sono = document.getElementById("sono").value;
    $item = document.getElementById("item").value;

    if ($from === "" || $to === "") {
      alert("Date cannot empty!");
      return;
    }

    $.ajax({
      url: "<?php echo base_url(); ?>purchasing_mon/mon_sales_invoice_filter_inv?from=" + $from + "&to=" + $to + "&cust=" + $cust + "&pur=" + $purchaser + "&inv=" + $invno + "&po=" + $mainpo + "&item=" + $item + "&sono=" + $sono + "",
      success: function(response) {
        $("#tbl-mon").html(response);
      },
      dataType: "html"
    });

    return false;
  }

  function printtopdf() {
    $from = document.getElementById("from").value;
    $to = document.getElementById("to").value;
    $cust = document.getElementById("cust").value;
    $purchaser = document.getElementById("purchaser").value;
    $invno = document.getElementById("invno").value;
    $mainpo = document.getElementById("mainpo").value;
    $item = document.getElementById("item").value;

    if ($from === "" || $to === "") {
      alert("Date cannot empty!");
      return;
    }

    $url = "<?php echo base_url(); ?>purchasing_mon/print_pdf?from=" + $from + "&to=" + $to + "&cust=" + $cust + "&pur=" + $purchaser + "&inv=" + $invno + "&po=" + $mainpo + "&item=" + $item + "";

    window.open($url);

  }

  function printtoexcel() {
    $from = document.getElementById("from").value;
    $to = document.getElementById("to").value;
    $cust = document.getElementById("cust").value;
    $purchaser = document.getElementById("purchaser").value;
    $invno = document.getElementById("invno").value;
    $mainpo = document.getElementById("mainpo").value;
    $item = document.getElementById("item").value;

    if ($from === "" || $to === "") {
      alert("Date cannot empty!");
      return;
    }

    $url = "<?php echo base_url(); ?>purchasing_mon/sales_invoice_excel?from=" + $from + "&to=" + $to + "&cust=" + $cust + "&pur=" + $purchaser + "&inv=" + $invno + "&po=" + $mainpo + "&item=" + $item + "";

    window.open($url);

  }
</script>