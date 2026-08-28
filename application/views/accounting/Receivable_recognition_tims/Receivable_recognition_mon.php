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
              <span class="caption-subject theme-font bold"><?=$title?></span>
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
                        <input type="hidden" id="output_cust">
                        <div class="col-md-9">
                        <?php
                            $style_kategori = "class='select2me form-control' multiple id='customer'";
                            echo form_dropdown('supplier', $SupplierID, $supplier_id, $style_kategori);
                        ?>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label class="col-md-2 label-sm">Invoice Type</label>
                        <div class="col-md-7">
                          <select name="invtype" id="invtype" class="form-control select2me">
                          <option></option>
                          <option value="bar">Barge Charges</option>
                          <option value="fre">Freight Charges</option>
                          <option value="trn">Transport Charges</option>
                          <option value="imp">Import Shipment</option>
                          <option value="det">Detention</option>
                          <option value="oth">Other</option>
                          <option value="casa">Cash Sales</option>
                          <option value="truck">Trucking</option>
                        </select>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="form-group">
                        <label class="col-md-2 label-sm">Item</label>
                        <div class="col-md-7">
                          <input type="hidden" id="output_item">
                          <select name="item[]" id="item_cust" multiple class="form-control select2me">
                            <option></option>
                            <?php
                              foreach ($ItemId as $r) {
                                echo '<option value="'.$r->Item_number.'">'.$r->Item_number.'</option>';
                              }

                            ?>
                          </select>
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
                      <th>Reff Number</th>
                      <th>Invoice Date</th>
                      <th>Journal Date</th>
                      <th>Delivery Date</th>
                      <th>Customer</th>
                      <th>Item ID</th>
                      <th>Item Name</th>
                      <th>Sales Account</th>
                      <th>Qty</th>
                      <th>Price</th>
                      <th>Amount</th>
                      <th>USD Equivalent</th>
                      <th>GST Type</th>
                      <th>GST Value</th>
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
    $("#tbl-whs tr").remove();
    $("#tbl-vendor tr").remove();

    $from = document.getElementById("from").value;
    $to = document.getElementById("to").value;
    $customer = document.getElementById("customer");
    $invtype = document.getElementById("invtype").value;
    $item = document.getElementById("item_cust");

    $selectedValues = Array.from($customer.selectedOptions).map(option => option.value);
    document.getElementById('output_cust').value = $selectedValues.join(',');

    $selectedValuesItem = Array.from($item.selectedOptions).map(option => option.value);
    document.getElementById('output_item').value = $selectedValuesItem.join(',');

    if ($from === "" || $to === "") {
      alert("Date cannot empty!");
      return;
    }

    $cust_out = document.getElementById("output_cust").value;
    $item_out = document.getElementById("output_item").value;

    $.ajax({
      url: "<?php echo base_url(); ?>Receivable_recognition_tims/filter_receivable_recognition_zht?from=" + $from + "&to=" + $to + "&customer=" + $cust_out + "&invtype=" + $invtype + "&item=" + $item_out + "",
      success: function(response) {
        $("#tbl-mon").html(response);
      },
      dataType: "html"
    });

    return false;
  }

  function get_customer_item() {
    var customer = document.getElementById("customer").value;
    $.ajax({
      url: "<?php echo base_url(); ?>Receivable_recognition_tims/tampil_item_cust?cust=" + customer + "",
      dataType: "json",
      success: function(data) {
        console.log(data);
        let selectHTML = '<option value="">-- Select Item --</option>';

        data.forEach(function(data) {
          selectHTML += `<option value="${data.Item_number}">${data.Item_number}</option>`;
        });

        $("#item_cust").html(selectHTML);
      },
    });
  }

  function excel() {
    $from = document.getElementById("from").value;
    $to = document.getElementById("to").value;
    $customer = document.getElementById("customer");
    $invtype = document.getElementById("invtype").value;
    $item = document.getElementById("item_cust");

    $selectedValues = Array.from($customer.selectedOptions).map(option => option.value);
    document.getElementById('output_cust').value = $selectedValues.join(',');

    $selectedValuesItem = Array.from($item.selectedOptions).map(option => option.value);
    document.getElementById('output_item').value = $selectedValuesItem.join(',');

    if ($from === "" || $to === "") {
      alert("Date cannot empty!");
      return;
    }

    $cust_out = document.getElementById("output_cust").value;
    $item_out = document.getElementById("output_item").value;

    javascript: location.href = "<?php echo base_url(); ?>Excel/ExcelReceivableMon?from=" + $from + "&to=" + $to + "&customer=" + $cust_out + "&invtype=" + $invtype + "&item=" + $item_out + "";
  }
</script>