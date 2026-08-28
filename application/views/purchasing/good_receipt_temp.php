<?php
error_reporting(0)
?>
<script>
  $(document).ready(function() {
    $('#btnpo').attr('disabled', true);
  });
</script>

<div class="page-content">
  <div class="container-fluid">

    <div class="row">
      <div class="col-md-12">
        <?php
        if ($this->session->flashdata('message')) :
          echo $this->session->flashdata('message');
        endif;
        ?>

        <div class="portlet light">
          <div class="portlet-title">
            <div class="caption">
              <i class="fa fa-navicon theme-font"></i>
              <span class="caption-subject theme-font bold">Good Receipt</span>
            </div>
            <div class="tools">
              <a href="javascript:;" class="collapse"></a>
              <a href="javascript:;" class="fullscreen"></a>
            </div>
          </div>
          <div class="portlet-body">
            <form action="<?php echo site_url('purchasing_gr/good_receipt_save/add'); ?>" method="post" class="form-horizontal" role="form">
              <div class="row">
                <div class="col-md-9">
                  <div class="form-body">
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group" style="margin-bottom:1px;">
                          <label class="col-md-4 label-sm">Vendor</label>
                          <div class="col-md-4">
                            <div class="input-group">
                              <input type="text" class="form-control input-sm" id="vendor" name="vendor" readonly>
                              <input type="text" id="taxcode" hidden>
                              <input type="text" id="taxprice" hidden>
                              <span class="input-group-btn">
                                <button class="btn btn-sm btn-primary" type="button" style="height:30px;" onclick="fnDialogSupp()"><i class="fa fa-arrow-down"></i></button>
                              </span>
                            </div>
                          </div>
                        </div>
                        <div class="form-group" style="margin-bottom:1px;">
                          <label class="col-md-4 label-sm">Name</label>
                          <div class="col-md-5">
                            <input class="form-control input-sm" id="name" name="name" readonly>
                          </div>
                        </div>
                        <div class="form-group " style="margin-bottom:1px;">
                          <label class="col-md-4 label-sm">Contact Person</label>
                          <div class="col-md-4">
                            <input class="form-control input-sm" id="contact" name="contact" readonly>
                          </div>
                        </div>
                        <div class="form-group" style="margin-bottom:1px;">
                          <label class="col-md-4 label-sm">Vendor Ref</label>
                          <div class="col-md-4">
                            <input class="form-control input-sm" name="vendorref">
                          </div>
                        </div>
                        <div class="form-group" style="margin-bottom:1px;">
                          <div class="col-md-4 col-md-offset-4">
                            <select class="form-control select2me" data-placeholder="Currency" name="cur">
                              <option value=""></option>
                              <?php
                              foreach ($cur as $r) {
                                if ($r->currency_id != 'SGD') {
                                  echo '<option value="' . $r->currency_id . '">' . $r->currency_id . '</option>';
                                } else {
                                  echo '<option value="' . $r->currency_id . '" selected>' . $r->currency_id . '</option>';
                                }
                              }
                              ?>
                            </select>
                          </div>
                        </div>
                      </div>

                      <div class="col-md-6">
                        <div class="form-group" style="margin-bottom:1px;">
                          <label class="col-md-5 col-md-push-3 label-sm">Doc No</label>
                          <div class="col-md-4 col-md-push-3">
                            <input type="text" class="form-control input-sm" name="docno" readonly>
                          </div>
                        </div>
                        <div class="form-group" style="margin-bottom:1px;">
                          <label class="col-md-5 col-md-push-3 label-sm">Status</label>
                          <div class="col-md-4 col-md-push-3">
                            <select class="form-control select2me" data-placeholder="Status" id="companyid" name="status">
                              <option value="1">Open</option>
                              <option value="2">Closed</option>
                            </select>
                          </div>
                        </div>
                        <div class="form-group " style="margin-bottom:1px;">
                          <label class="col-md-5 col-md-push-3 label-sm">Posting Date</label>
                          <div class="col-md-4 col-md-push-3">
                            <input name="postdate" class="form-control input-sm date date-picker" data-date="12-02-2012" data-date-format="mm-dd-yyyy" value="<?php echo date("m-d-Y"); ?>" required>
                          </div>
                        </div>
                        <div class="form-group" style="margin-bottom:1px;">
                          <label class="col-md-5 col-md-push-3 label-sm">Due Date</label>
                          <div class="col-md-4 col-md-push-3">
                            <input name="duedate" class="form-control input-sm date date-picker" data-date="12-02-2012" data-date-format="mm-dd-yyyy" value="<?php echo date("m-d-Y"); ?>" required>
                          </div>
                        </div>
                        <div class="form-group" style="margin-bottom:1px;">
                          <label class="col-md-5 col-md-push-3 label-sm">Document Date</label>
                          <div class="col-md-4 col-md-push-3">
                            <input name="docdate" class="form-control input-sm date date-picker" data-date="12-02-2012" data-date-format="mm-dd-yyyy" value="<?php echo date("m-d-Y"); ?>" required>
                          </div>
                        </div>
                      </div>
                    </div>

                    <hr>

                    <div class="table-scrollable">
                      <table class="table table-bordered" id="tblList">
                        <thead>
                          <tr>
                            <th><button class="btn btn-sm btn-primary" type="button" onclick="fnDialogPO()" id="btnpo"><i class="fa fa-arrow-down"></i></button></th>
                            <th>Item ID</th>
                            <th>Item Name</th>
                            <th>Label PM Code</th>
                            <th>UOM</th>
                            <th>Qty</th>
                            <th>Quantity</th>
                            <th>Unit Price</th>
                            <th>Tax Code</th>
                            <th>Total</th>
                            <th>PO NO</th>
                            <th>NPBB NO</th>
                          </tr>
                        </thead>
                        <tbody>
                        </tbody>
                      </table>
                    </div>

                    <hr>

                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group" style="margin-bottom:1px;">
                          <label class="col-md-3 label-sm">Remark</label>
                          <div class="col-md-9">
                            <textarea rows="3" class="form-control autosizeme" name="remark"></textarea>
                          </div>
                        </div>
                      </div>

                      <div class="col-md-offset-1 col-md-5 well">
                        <div class="form-group" style="margin-bottom:1px;">
                          <label class="col-md-6 col-md-push-1 label-sm">Total Before Discount</label>
                          <div class="col-md-5 col-md-push-1">
                            <input type="text" class="form-control input-sm text-right" name="totalbefore" value="0.0000" id="totalbefore" readonly>
                          </div>
                        </div>
                        <div class="form-group" style="margin-bottom:1px;">
                          <label class="col-md-3 col-md-push-1 label-sm">Discount</label>
                          <div class="col-md-4 col-md-push-1">
                            <div class="input-group">
                              <input type="text" class="form-control input-sm text-right" name="discount" value="0" id="discount" onchange="discwith()">
                              <span class="input-group-addon">
                                %
                              </span>
                            </div>
                          </div>
                          <div class="col-md-5">
                            <input type="text" class="form-control input-sm text-right" name="totaldis" value="0.0000" id="totaldis" readonly>
                          </div>
                        </div>
                        <div class="form-group " style="margin-bottom:1px;">
                          <label class="col-md-6 col-md-push-1 label-sm">Freight</label>
                          <div class="col-md-5 col-md-push-1">
                            <input class="form-control input-sm text-right" name="freight" value="0.0000" id="freight">
                          </div>
                        </div>
                        <div class="form-group" style="margin-bottom:1px;">
                          <label class="col-md-6 col-md-push-1 label-sm">Tax</label>
                          <div class="col-md-5 col-md-push-1">
                            <input class="form-control input-sm text-right" name="tax" value="0.0000" id="tax">
                          </div>
                        </div>
                        <div class="form-group" style="margin-bottom:1px;">
                          <label class="col-md-6 col-md-push-1 label-sm">Total Payment Due</label>
                          <div class="col-md-5 col-md-push-1">
                            <input class="form-control input-sm text-right" name="totaldue" value="0.0000" id="totaldue" readonly>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="form-actions">
                    <div class="col-md-6">
                      <button type="submit" class="col-md-2 btn btn-primary">Save</button>
                      <button type="reset" class="col-md-2 btn btn-default">Cancel</button>
                    </div>
                    <div class="col-md-6">
                      <button type="button" class="col-md-3 col-md-offset-10 btn btn-warning" onclick="fnDialogGR()">Find</button>
                    </div>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="portlet light">
                    <div class="portlet body">
                      <div class="form-group" style="margin-bottom:1px;">
                        <label class="col-md-4 label-sm">Ship D.</label>
                        <div class="col-md-8">
                          <input name="shipdate" class="form-control input-sm date date-picker" data-date="12-02-2012" data-date-format="mm-dd-yyyy" value="<?php echo date("m-d-Y"); ?>" required>
                        </div>
                      </div>
                      <div class="form-group" style="margin-bottom:1px;">
                        <label class="col-md-4 label-sm">From</label>
                        <div class="col-md-8">
                          <textarea rows="3" class="form-control" name="from" style="resize: none;height: 200px;"></textarea>
                        </div>
                      </div>
                      <div class="form-group" style="margin-bottom:1px;">
                        <label class="col-md-4 label-sm">To</label>
                        <div class="col-md-8">
                          <textarea rows="3" class="form-control" name="to" style="resize: none;height: 200px;"></textarea>
                        </div>
                      </div>
                      <div class="form-group" style="margin-bottom:1px;">
                        <label class="col-md-4 label-sm">Arrived D.</label>
                        <div class="col-md-8">
                          <input name="arriveddate" class="form-control input-sm date date-picker" data-date="12-02-2012" data-date-format="mm-dd-yyyy" value="<?php echo date("m-d-Y"); ?>" required>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

              </div>
            </form>
          </div>
        </div>
        <div id="formdialogPO"></div>
        <div id="formdialogSupp"></div>
        <div id="formdialogGR"></div>
      </div>
    </div>
  </div>
</div>

<script>
  function fnDialogPO() {
    $("#formdialogPO").html(" <div class='portlet-body'>\n\
                        <div class='col-md-12'>\n\
                            <div class='form-group'>\n\
                                 <label class='col-md-1 label-sm'>Find</label>\n\
                                 <div class='col-md-7'>\n\
                                        <input class=form-control input-sm' id='findpo'>\n\
                                 </div>\n\
                                 <button type='button' class='col-md-2 btn blue' onclick='filterpo()'>Search</button>\n\
                            </div>\n\
                        </div>\n\
                        <br><hr>\n\
                        <div class='table-scrollable' style='overflow: auto; height:400px;'>\n\
                            <table id='tbl-po' class='table table-bordered table-striped'>\n\
                                <thead>\n\
                                    <tr>\n\
                                        <th><input type='checkbox' onchange='check(this)'></th>\n\
                                        <th>PO No</th>\n\
                                        <th>PO Date</th>\n\
                                        <th>Item ID</th>\n\
                                        <th>Item Name</th>\n\
                                        <th>Label PM Code</th>\n\
                                        <th>Qnty</th>\n\
                                        <th>Quantity</th>\n\
                                        <th>UOM</th>\n\
                                        <th>Price</th>\n\
                                        <th>NPBB No</th>\n\
                                    </tr>\n\
                                </thead>\n\
                                <tbody id='tblpo'>\n\
                                    <tr>\n\
                                        <td></td>\n\
                                        <td></td>\n\
                                        <td></td>\n\
                                        <td></td>\n\
                                        <td></td>\n\
                                        <td></td>\n\
                                        <td></td>\n\
                                        <td></td>\n\
                                        <td></td>\n\
                                        <td></td>\n\
                                        <td></td>\n\
                                    </tr>\n\
                                </tbody>\n\
                            </table>\n\
                        </div>\n\
                            <div class='col-md-6'>\n\
                                <button type='button' class='col-md-4 btn blue' onclick='choose_PO()'>Choose</button>\n\
                                <button type='button' class='col-md-4 btn grey' onclick='close_PO()'>Close</button>\n\
                            </div>\n\
                </div>");

    // Define the Dialog and its properties.
    $("#formdialogPO").dialog({
      resizable: false,
      modal: true,
      title: "List PO",
      height: 650,
      width: 1300

    });
  }

  function fnDialogSupp() {
    $("#formdialogSupp").html("<div class='portlet-body'>\n\
                        <div class='col-md-12'>\n\
                            <div class='form-group'>\n\
                                 <label class='col-md-1 label-sm'>Find</label>\n\
                                 <div class='col-md-7'>\n\
                                        <input class=form-control input-sm' id='findsupp'>\n\
                                 </div>\n\
                                 <button type='button' class='col-md-2 btn blue' onclick='filtersupp()'>Search</button>\n\
                            </div>\n\
                        </div>\n\
                        <br><hr>\n\
                        <div class='table-scrollable' style='overflow: auto; height:300px;'>\n\
                            <table id='tbl-supp' class='table table-bordered table-striped'>\n\
                                <thead>\n\
                                    <tr>\n\
                                        <th>Vendor ID</th>\n\
                                        <th>Name</th>\n\
                                        <th>Contact Person</th>\n\
                                    </tr>\n\
                                </thead>\n\
                                <tbody id='tblsupp'>\n\
                                    <tr ondblclick='clickdbsupp(this)'>\n\
                                        <td></td>\n\
                                        <td></td>\n\
                                        <td></td>\n\
                                        <td hidden></td>\n\
                                        <td hidden></td>\n\
                                    </tr>\n\
                                </tbody>\n\
                            </table>\n\
                        </div>\n\
                    </div>");

    // Define the Dialog and its properties.
    $("#formdialogSupp").dialog({
      resizable: false,
      modal: true,
      title: "List Vendor",
      top: 5,
      height: 500,
      width: 880

    });
  }

  function fnDialogGR() {
    $("#formdialogGR").html(" <div class='portlet-body'>\n\
                        <div class='col-md-12'>\n\
                            <div class='form-group'>\n\
                                 <label class='col-md-1 label-sm'>Find</label>\n\
                                 <div class='col-md-7'>\n\
                                       <input class=form-control input-sm' id='findgr'>\n\
                                 </div>\n\
                                 <button type='button' class='col-md-2 btn blue' onclick='filtergr()'>Search</button>\n\
                            </div>\n\
                        </div>\n\
                        <br><hr>\n\
                        <div class='table-scrollable' style='overflow: auto; height:490px;'>\n\
                            <table id='tbl-gr' class='table table-bordered table-striped'>\n\
                                <thead>\n\
                                    <tr>\n\
                                        <th>Action</th>\n\
                                        <th nowrap>Doc No</th>\n\
                                        <th nowrap>Doc Date</th>\n\
                                        <th nowrap>Main PO</th>\n\
                                        <th nowrap>Status</th>\n\
                                        <th nowrap>Vendor Company</th>\n\
                                        <th nowrap>Contact Person</th>\n\
                                        <th nowrap>Item ID</th>\n\
                                        <th nowrap>Item Name</th>\n\
                                        <th nowrap>Qnty</th>\n\
                                        <th nowrap>Price</th>\n\
                                        <th nowrap>currency</th>\n\
                                        <th nowrap>Created By</th>\n\
                                        <th nowrap>Created Date</th>\n\
                                        <th nowrap>LastUpdated By</th>\n\
                                        <th nowrap>LastUpdated Date</th>\n\
                                    </tr>\n\
                                </thead>\n\
                                <tbody id='tblgr'>\n\
                                    <tr>\n\
                                        <td></td>\n\
                                        <td></td>\n\
                                        <td></td>\n\
                                        <td></td>\n\
                                        <td></td>\n\
                                        <td></td>\n\
                                        <td></td>\n\
                                        <td></td>\n\
                                        <td></td>\n\
                                        <td></td>\n\
                                        <td></td>\n\
                                        <td></td>\n\
                                        <td></td>\n\
                                        <td></td>\n\
                                        <td></td>\n\
                                        <td></td>\n\
                                    </tr>\n\
                                </tbody>\n\
                            </table>\n\
                        </div>\n\
                </div>");

    // Define the Dialog and its properties.
    $("#formdialogGR").dialog({
      resizable: false,
      modal: true,
      title: "List Good Receipt",
      height: 650,
      width: 1300

    });
  }
</script>
<script>
  function clickdbsupp(x) {
    function getText(el) {
      if (typeof el.textContent == 'string') return el.textContent;
      if (typeof el.innerText == 'string') return el.innerText;
    }

    $r = x.rowIndex;
    document.getElementById('vendor').value = getText(document.getElementById('tbl-supp').rows[$r].cells[0]);
    document.getElementById('name').value = getText(document.getElementById('tbl-supp').rows[$r].cells[1]);
    document.getElementById('contact').value = getText(document.getElementById('tbl-supp').rows[$r].cells[2]);
    document.getElementById('taxcode').value = getText(document.getElementById('tbl-supp').rows[$r].cells[3]);
    document.getElementById('taxprice').value = getText(document.getElementById('tbl-supp').rows[$r].cells[4]);

    $('#btnpo').attr('disabled', false);
    $("#formdialogSupp").dialog("close");
  }

  function deleterow(x) {
    $r = x.rowIndex;

    if (confirm("Are you sure remove this row?") == true) {
      document.getElementById("tblList").deleteRow($r);
      calculate();
    }
  }

  //    checkAll
  function check(ele) {
    var checkboxes = document.getElementsByTagName('input');
    if (ele.checked) {
      for (var i = 0; i < checkboxes.length; i++) {
        if (checkboxes[i].type == 'checkbox') {
          checkboxes[i].checked = true;
        }
      }
    } else {
      for (var i = 0; i < checkboxes.length; i++) {
        console.log(i)
        if (checkboxes[i].type == 'checkbox') {
          checkboxes[i].checked = false;
        }
      }
    }
  }

  function choose_PO() {
    function getText(el) {
      if (typeof el.textContent == 'string') return el.textContent;
      if (typeof el.innerText == 'string') return el.innerText;
    }
    //        var x = document.getElementById("tbl-npbb").rows.length;
    var chk_arr = document.getElementsByName("chk[]");
    var chk_length = chk_arr.length;

    i = 1;
    for (k = 0; k < chk_length; k++) {
      if (chk_arr[k].checked == true) {
        $('table[id="tblList"]').append('<tr onclick="deleterow(this)">\n\
                        <td><button class="btn btn-sm btn-light-grey" type="button" ><i class="fa fa-trash" ></i></button></td>\n\
                            <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 100px;" name="ItemID[]" value="' + getText(document.getElementById('tbl-po').rows[i].cells[3]) + '" readonly></td>\n\
                            <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 250px;" name="ItemName[]" value="' + getText(document.getElementById('tbl-po').rows[i].cells[4]) + '" readonly></td>\n\
                            <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 100px;" name="PMCode[]" value="' + getText(document.getElementById('tbl-po').rows[i].cells[5]) + '" readonly></td>\n\
                            <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 80px;" name="UOM[]" value="' + getText(document.getElementById('tbl-po').rows[i].cells[8]) + '" readonly></td>\n\
                            <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm text-right" style="width: 80px;" name="Qty[]" value="' + getText(document.getElementById('tbl-po').rows[i].cells[6]) + '" onkeypress="return isNumber(event)" onchange="calculate()"></td>\n\
                            <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm text-right" style="width: 80px;" name="Quantity[]" value="' + getText(document.getElementById('tbl-po').rows[i].cells[7]) + '" readonly></td>\n\
                            <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm text-right" style="width: 100px;" name="UnitPrice[]" value="' + getText(document.getElementById('tbl-po').rows[i].cells[9]) + '" readonly></td>\n\
                            <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 100px;" name="TaxCode[]" value="' + getText(document.getElementById('tbl-po').rows[i].cells[11]) + '" readonly></td>\n\
                            <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm text-right" style="width: 100px;" name="Total[]" readonly></td>\n\
                            <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 100px;" name="MainPO[]" value="' + getText(document.getElementById('tbl-po').rows[i].cells[1]) + '" readonly></td>\n\
                            <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 100px;" name="NPBB[]" value="' + getText(document.getElementById('tbl-po').rows[i].cells[10]) + '" readonly></td>\n\
                    </tr>');
      }
      i++;
    }

    $("#formdialogPO").dialog("close");

    calculate();
  }

  function close_PO() {
    $("#formdialogPO").dialog("close");
  }

  function filtersupp() {
    $findsupp = document.getElementById("findsupp").value;

    $.ajax({
      url: "<?php echo base_url(); ?>purchasing_po/purchase_order_supp/" + $findsupp + "",
      success: function(response) {
        $("#tblsupp").html(response);
      },
      dataType: "html"
    });

    return false;
  }

  function filterpo() {
    $vendor = document.getElementById("vendor").value;
    $findpo = document.getElementById("findpo").value;

    $.ajax({
      url: "<?php echo base_url(); ?>purchasing_gr/good_receipt_po/" + $vendor + "/" + $findpo + "",
      success: function(response) {
        $("#tblpo").html(response);
      },
      dataType: "html"
    });

    return false;
  }

  function filtergr() {
    $findgr = document.getElementById("findgr").value;

    $.ajax({
      url: "<?php echo base_url(); ?>purchasing_gr/good_receipt_gr/" + $findgr + "",
      success: function(response) {
        $("#tblgr").html(response);
      },
      dataType: "html"
    });

    return false;
  }

  function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode === 8 || charCode === 44 || charCode === 46 || (charCode > 47 && charCode < 58)) {
      return true;
    }
    return false;
  }

  function disc() {
    var dis = document.getElementById('discount').value / 100;
    var total = document.getElementById('totalbefore').value;
    var grantotal = total * dis;
    document.getElementById('totaldis').value = grantotal.toFixed(4);
  }

  function discwith() {
    var dis = document.getElementById('discount').value / 100;
    var total = document.getElementById('totalbefore').value;
    var grantotal = total * dis;
    document.getElementById('totaldis').value = grantotal.toFixed(4);

    calculate();
  }

  function calculate() {
    var int = 0;
    var total = 0;

    $('#tblList tr').each(function() {
      var Qnty = $(this).find("input[name='Qty[]']").val();
      $(this).find("input[name='Quantity[]']").val(Qnty);

      var Quantity = $(this).find("input[name='Quantity[]']").val();
      var UnitPrice = $(this).find("input[name='UnitPrice[]']").val();
      var Total = Quantity * UnitPrice;
      $(this).find("input[name='Total[]']").val(Total.toFixed(4));

      if (int > 0) {
        total += Total;
      }
      int += 1;
    });

    document.getElementById('totalbefore').value = total.toFixed(4);
    disc();

    var totaldis = document.getElementById('totaldis').value;
    var freight = document.getElementById('freight').value;
    var tax = document.getElementById('tax').value;
    var grandtotal = total - totaldis - freight - tax;
    document.getElementById('totaldue').value = grandtotal.toFixed(4);
  }
</script>