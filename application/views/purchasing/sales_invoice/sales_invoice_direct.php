<?php
if (isset($rate)) {
  $rate = $rate->rate_usd;
} else {
  $rate = '0';
}
?>

<script>
  $(document).ready(function() {
    $('#btn-save').attr('disabled', true);
    $('#btn-click').attr('disabled', true);
  });
</script>

<!-- <link href="<?php echo base_url(); ?>assets/admin/css/cloud-admin.css" rel="stylesheet" type="text/css"> -->

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
          <div id="rate2" style="color: #5a7391"></div>
          <div class="portlet-title">
            <div class="caption">
              <i class="fa fa-navicon theme-font"></i>
              <span class="caption-subject theme-font bold">Sales Invoice (Directly)</span>
            </div>
            <!--                        <div class="tools">
                            <a href="javascript:;" class="collapse"></a>
                            <a href="javascript:;" class="fullscreen"></a>
                        </div>-->
          </div>
          <div class="portlet-body">
            <form action="<?php echo site_url('purchasing_inv/sales_invoice_direct_save/add'); ?>" method="post" class="form-horizontal" role="form">
              <div class="row">
                <div class="col-md-9">
                  <div class="form-body">
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group" style="margin-bottom:1px;">
                          <label class="col-md-4 label-sm">Customer</label>
                          <div class="col-md-4">
                            <div class="input-group">
                              <input type="text" class="form-control input-sm" id="cust" name="cust" required readonly>
                              <span class="input-group-btn">
                                <button id="btn-searching" class="btn btn-sm btn-primary" type="button" style="height:30px;" onclick="fnDialogCust()"><i class="fa fa-arrow-down"></i></button>
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
                          <label class="col-md-4 label-sm">Customer Ref</label>
                          <div class="col-md-4">
                            <input class="form-control input-sm" name="custref">
                          </div>
                        </div>
                        <div class="form-group" style="margin-bottom:1px;">
                          <div class="col-md-4 col-md-offset-4">
                            <select class="form-control" data-placeholder="Currency" name="cur" id="cur" onchange="Rate()">
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
                          <div id="rate" style="color: #5a7391"><input name="rate" value="<?php echo $rate; ?>" hidden>* Rate : <?php echo $rate; ?></div>
                        </div>
                      </div>

                      <div class="col-md-6">
                        <!--                                                    <div class="form-group" style="margin-bottom:1px;">
                                                        <label class="col-md-5 col-md-push-3 label-sm">Doc No</label>
                                                        <div class="col-md-4 col-md-push-3">
                                                            <input type="text" class="form-control input-sm" name="docno" readonly>
                                                        </div>
                                                    </div>-->

                        <div class="form-group " style="margin-bottom:1px;">
                          <label class="col-md-5 col-md-push-3 label-sm">Posting Date</label>
                          <div class="col-md-4 col-md-push-3">
                            <input type="text" name="postdate" class="form-control input-sm date date-picker" data-date="02-12-2012" data-date-format="dd-mm-yyyy" value="<?php echo date("d-m-Y"); ?>" required>
                          </div>
                        </div>
                        <div class="form-group" style="margin-bottom:1px;">
                          <label class="col-md-5 col-md-push-3 label-sm">Due Date</label>
                          <div class="col-md-4 col-md-push-3">
                            <input type="text" name="duedate" id="duedate" onchange="Rate();" class="form-control input-sm date date-picker" data-date="02-12-2012" data-date-format="dd-mm-yyyy" value="<?php echo date("d-m-Y"); ?>" required>
                          </div>
                        </div>
                        <div class="form-group" style="margin-bottom:1px;">
                          <label class="col-md-5 col-md-push-3 label-sm">Document Date</label>
                          <div class="col-md-4 col-md-push-3">
                            <input type="text" name="docdate" id="docdate" onchange="Rate();" class="form-control input-sm date date-picker" data-date="02-12-2012" data-date-format="dd-mm-yyyy" value="<?php echo date("d-m-Y"); ?>" required>
                          </div>
                        </div>

                        <div class="form-group" style="margin-bottom:1px;">
                          <label class="col-md-5 col-md-push-3 label-sm">Status</label>
                          <div class="col-md-4 col-md-push-3">
                            <select class="form-control" data-placeholder="Status" id="companyid" name="status">
                              <option value="1">Open</option>
                              <option value="2">Closed</option>
                            </select>
                          </div>
                        </div>

                        <div class="form-group" style="margin-bottom:1px;">
                          <label class="col-md-5 col-md-push-3 label-sm">Tax Code</label>
                          <div class="col-md-4 col-md-push-3">
                            <select class="form-control" name="gst">
                              <option value="">Select</option>
                              <option value="ZER">Zero Rate</option>
                              <option value="OUT">Out of Scope</option>
                            </select>
                          </div>
                        </div>
                      </div>
                    </div>

                    <hr>

                    <div class="table-scrollable">
                      <table class="table table-bordered" id="tblList">
                        <thead>
                          <tr>
                            <th><button class="btn btn-sm btn-primary" type="button" onclick="fnDialogItem()" id="btn-click"><i class="fa fa-arrow-down"></i></button></th>
                            <th>Item ID</th>
                            <th>Item Name</th>
                            <th>UOM</th>
                            <th>Qty</th>
                            <th>Quantity</th>
                            <th>Tax Code</th>
                            <th>NPBB NO</th>
                            <th>PO NO</th>
                            <th>Unit Price</th>
                            <th>Commission</th>
                            <th>Invoice Price</th>
                            <th>Total</th>
                          </tr>
                        </thead>
                        <tbody id="tblList_1">
                        </tbody>
                      </table>
                    </div>

                    <hr>

                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group" style="margin-bottom:1px;">
                          <label class="col-md-3 label-sm">Ship Via</label>
                          <div class="col-md-9">
                            <input type="text" class="form-control input-sm" name="via">
                          </div>
                        </div>
                        <div class="form-group" style="margin-bottom:1px;">
                          <label class="col-md-3 label-sm">Warehouse/Deliver</label>
                          <div class="col-md-9">
                            <select class="form-control select2me" data-placeholder="Warehouse / Deliver" name="whs">
                              <?php
                              echo '<option value=""></option>';
                              foreach ($whs as $r) {
                                echo '<option value="' . $r->id . '">' . $r->name . '</option>';
                              }
                              ?>
                            </select>
                          </div>
                        </div>
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
                            <input type="text" class="form-control input-sm text-right" name="totalbefore" value="0.00" id="totalbefore" readonly>
                          </div>
                        </div>
                        <div class="form-group" style="margin-bottom:1px;">
                          <label class="col-md-3 col-md-push-1 label-sm">Discount</label>
                          <div class="col-md-4 col-md-push-1">
                            <div class="input-group">
                              <input type="text" class="form-control input-sm text-right" name="discount" value="0" id="discount" onkeyup="discwith()">
                              <span class="input-group-addon">
                                %
                              </span>
                            </div>
                          </div>
                          <div class="col-md-5">
                            <input type="text" class="form-control input-sm text-right" name="totaldis" value="0.00" id="totaldis" onkeyup="cekdisc()" onchange="calculate()">
                          </div>
                        </div>
                        <div class="form-group " style="margin-bottom:1px;">
                          <label class="col-md-6 col-md-push-1 label-sm">Freight</label>
                          <div class="col-md-5 col-md-push-1">
                            <input class="form-control input-sm text-right" name="freight" value="0.00" id="freight" onkeyup="calculate()">
                          </div>
                        </div>
                        <div class="form-group" style="margin-bottom:1px;">
                          <label class="col-md-6 col-md-push-1 label-sm">Tax</label>
                          <div class="col-md-5 col-md-push-1">
                            <input class="form-control input-sm text-right" name="tax" value="0.00" id="tax" onkeyup="calculate()">
                          </div>
                        </div>
                        <div class="form-group" style="margin-bottom:1px;">
                          <label class="col-md-6 col-md-push-1 label-sm">Total</label>
                          <div class="col-md-5 col-md-push-1">
                            <input class="form-control input-sm text-right" name="totaldue" value="0.00" id="totaldue" readonly>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="form-actions">
                    <div class="col-md-6">
                      <button type="submit" class="col-md-2 btn btn-primary" id="btn-save">Save</button>
                      <!--<a type="button" class="col-md-2 btn btn-default" href="<?php // echo site_url('purchasing_inv'); 
                                                                                  ?>">Cancel</a>-->
                      <button type="reset" class="col-md-2 btn btn-default" onclick="$('#tblList_1 tr').remove();">Cancel</button>
                    </div>
                    <div class="col-md-6">
                      <div class="col-md-7"></div>
                      <div>
                        <button id="btn-find" type="button" class="col-md-2 col-md-push-4 btn btn-warning" onclick="fnDialogINV()">Find</button>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="portlet light">
                    <div class="portlet body">
                      <div class="form-group" style="margin-bottom:1px;">
                        <label class="col-md-4 label-sm">Inv No</label>
                        <div class="col-md-8">
                          <input class="form-control input-sm" name="invno" readonly>
                        </div>
                      </div>
                      <!--                                            <div class="form-group" style="margin-bottom:1px;">
                                                <label class="col-md-4 label-sm">Main PO</label>
                                                <div class="col-md-8">
                                                    <textarea rows="3" class="form-control" id="mainpo" style="resize: none;height: 100px;" readonly></textarea>
                                                </div>
                                            </div>-->
                      <div class="form-group" style="margin-bottom:1px;">
                        <label class="col-md-4 label-sm">Ship Date</label>
                        <div class="col-md-8">
                          <input name="shipdate" class="form-control input-sm date date-picker" data-date="02-12-2012" data-date-format="dd-mm-yyyy" value="<?php echo date("d-m-Y"); ?>" required>
                        </div>
                      </div>
                      <div class="form-group" style="margin-bottom:1px;">
                        <label class="col-md-4 label-sm">Term</label>
                        <div class="col-md-8">
                          <textarea rows="3" class="form-control" name="term" style="resize: none;height: 167px;" id="term"></textarea>
                        </div>
                      </div>
                      <div class="form-group" style="margin-bottom:1px;">
                        <label class="col-md-4 label-sm">Term Days</label>
                        <div class="col-md-8">
                          <input class="form-control input-sm" name="day" id="days" value="0" onkeypress="return isNumber(event)" onkeyup="adddue()">
                        </div>
                      </div>
                      <!--                                            <div class="form-group" style="margin-bottom:1px;">
                                                <label class="col-md-4 label-sm">From</label>
                                                <div class="col-md-8">
                                                    <textarea rows="3" class="form-control" name="from" style="resize: none;height: 167px;"></textarea>
                                                </div>
                                            </div>
                                            <div class="form-group" style="margin-bottom:1px;">
                                                <label class="col-md-4 label-sm">To</label>
                                                <div class="col-md-8">
                                                    <textarea rows="3" class="form-control" name="to" style="resize: none;height: 167px;"></textarea>
                                                </div>
                                            </div>-->
                    </div>
                  </div>
                </div>

              </div>
            </form>
          </div>
        </div>
        <div id="formdialogCust"></div>
        <div id="formdialogItem"></div>
        <div id="formdialogINV"></div>
        <div id="modal_delete" class="modal fade bs-modal-lg" role="dialog" tabindex="-1" data-backdrop="static" data-keyboard="false" aria-hidden="true"></div>
      </div>
    </div>
  </div>
</div>

<script>
  function fnDialogItem() {
    $("#formdialogItem").html(" <div class='portlet-body'>\n\
                        <div class='col-md-12'>\n\
                            <div class='form-group'>\n\
                                 <label class='col-md-1 label-sm'>Find</label>\n\
                                 <div class='col-md-7'>\n\
                                        <input class='form-control input-sm' id='finditem'>\n\
                                 </div>\n\
                                 <button type='button' class='col-md-1 btn blue' onclick='filteritem()'>Search</button>\n\
                            </div>\n\
                        </div>\n\
                        <br><hr>\n\
                        <div class='table-scrollable' style='overflow: auto; height:400px;'>\n\
                            <table id='tbl-po' class='table table-bordered'>\n\
                                <thead>\n\
                                    <tr>\n\
                                        <th><input type='checkbox' onchange='check(this)'></th>\n\
                                        <th>Item ID</th>\n\
                                        <th>Item Name</th>\n\
                                        <th>UOM</th>\n\
                                    </tr>\n\
                                </thead>\n\
                                <tbody id='tblitem'>\n\
                                    <tr>\n\
                                        <td></td>\n\
                                        <td></td>\n\
                                        <td></td>\n\
                                        <td></td>\n\
                                    </tr>\n\
                                </tbody>\n\
                            </table>\n\
                        </div>\n\
                            <div class='col-md-6'>\n\
                                <button type='button' class='col-md-2 btn blue' onclick='choose_item()'>Choose</button>\n\
                                <button type='button' class='col-md-2 btn yellow' onclick='add_item()'>New Item</button>\n\
                                <button type='button' class='col-md-2 btn grey' onclick='close_item()'>Close</button>\n\
                            </div>\n\
                </div>");

    // Define the Dialog and its properties.
    $("#formdialogItem").dialog({
      resizable: false,
      modal: true,
      title: "List Item",
      height: 650,
      width: 1200

    });
  }

  function fnDialogCust() {
    $("#formdialogCust").html("<div class='portlet-body'>\n\
                        <div class='col-md-12'>\n\
                            <div class='form-group'>\n\
                                 <label class='col-md-1 label-sm'>Find</label>\n\
                                 <div class='col-md-7'>\n\
                                        <input class='form-control input-sm' id='findcust'>\n\
                                 </div>\n\
                                 <button type='button' class='col-md-2 btn blue' onclick='filtercust()'>Search</button>\n\
                            </div>\n\
                        </div>\n\
                        <br><hr>\n\
                        <div class='table-scrollable' style='overflow: auto; height:300px;'>\n\
                            <table id='tbl-cust' class='table table-bordered'>\n\
                                <thead>\n\
                                    <tr>\n\
                                        <th>Customer ID</th>\n\
                                        <th>Name</th>\n\
                                        <th>Contact Person</th>\n\
                                    </tr>\n\
                                </thead>\n\
                                <tbody id='tblcust'>\n\
                                    <tr ondblclick='clickdbcust(this)'>\n\
                                        <td></td>\n\
                                        <td></td>\n\
                                        <td></td>\n\
                                    </tr>\n\
                                </tbody>\n\
                            </table>\n\
                        </div>\n\
                    </div>");

    // Define the Dialog and its properties.
    $("#formdialogCust").dialog({
      resizable: false,
      modal: true,
      title: "List Customer",
      top: 5,
      height: 500,
      width: 880

    });
  }

  function fnDialogINV() {
    $("#formdialogINV").html(" <div class='portlet-body'>\n\
                        <div class='col-md-12'>\n\
                            <div class='form-group'>\n\
                                 <label class='col-md-1 label-sm'>Find</label>\n\
                                 <div class='col-md-7'>\n\
                                       <input class='form-control input-sm' id='findinv'>\n\
                                 </div>\n\
                                 <button type='button' class='col-md-1 btn blue' onclick='filterinv()'>Search</button>\n\
                            </div>\n\
                        </div>\n\
                        <br><hr>\n\
                        <div class='table-scrollable' style='overflow: auto; height:490px;'>\n\
                            <table id='tbl-inv' class='table table-bordered'>\n\
                                <thead>\n\
                                    <tr>\n\
                                        <th>Action</th>\n\
                                        <th nowrap>Inv No</th>\n\
                                        <th nowrap>Doc Date</th>\n\
                                        <th nowrap>Ship Date</th>\n\
                                        <th nowrap>Status</th>\n\
                                        <th nowrap>Customer Company</th>\n\
                                        <th nowrap>Contact Person</th>\n\
                                        <th nowrap>Total</th>\n\
                                        <th nowrap>currency</th>\n\
                                        <th nowrap>Created By</th>\n\
                                        <th nowrap>Created Date</th>\n\
                                        <th nowrap>LastUpdated By</th>\n\
                                        <th nowrap>LastUpdated Date</th>\n\
                                    </tr>\n\
                                </thead>\n\
                                <tbody id='tblinv'>\n\
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
                                    </tr>\n\
                                </tbody>\n\
                            </table>\n\
                        </div>\n\
                </div>");

    // Define the Dialog and its properties.
    $("#formdialogINV").dialog({
      resizable: false,
      modal: true,
      title: "List Invoice",
      height: 650,
      width: 1200

    });
  }
</script>
<script>
  function clickdbcust(x) {
    function getText(el) {
      if (typeof el.textContent == 'string') return el.textContent;
      if (typeof el.innerText == 'string') return el.innerText;
    }

    $r = x.rowIndex;
    document.getElementById('cust').value = getText(document.getElementById('tbl-cust').rows[$r].cells[0]);
    document.getElementById('name').value = getText(document.getElementById('tbl-cust').rows[$r].cells[1]);
    document.getElementById('contact').value = getText(document.getElementById('tbl-cust').rows[$r].cells[2]);
    document.getElementById('term').value = getText(document.getElementById('tbl-cust').rows[$r].cells[3]);

    $("#formdialogCust").dialog("close");
    cekhdr();
    cekDtl();
  }

  function deleterow(x) {
    $r = x.rowIndex;

    if (confirm("Are you sure remove this row?") == true) {
      document.getElementById("tblList").deleteRow($r);
      cekDtl();
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

  function add_item() {

    $('table[id="tblList"]').append('<tr onclick="deleterow(this)">\n\
                <td><button class="btn btn-sm btn-danger" type="button" ><i class="fa fa-trash" ></i></button></td>\n\
                    <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 150px;" name="ItemID[]" value=""></td>\n\
                    <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 250px;" name="ItemName[]" value=""></td>\n\
                    <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 60px;" name="UOM[]" value=""></td>\n\
                    <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm text-right" style="width: 80px;" name="Qty[]" value="0" onkeyup="calculate()"></td>\n\
                    <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm text-right" style="width: 80px;" name="Quantity[]" readonly></td>\n\
                    <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 70px;" name="TaxCode[]" value="" readonly></td>\n\
                    <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 140px;" name="NPBB[]" value="" ></td>\n\\n\
                    <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 140px;" name="PONO[]" value="" readonly></td>\n\
                    <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm text-right" style="width: 100px;" name="UnitPrice[]" value="0" onkeyup="calculate()"></td>\n\
                    <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm text-right"  name="Comission[]" value="0" onkeypress="return isNumber(event)" onkeyup="calculate()"></td>\n\
                    <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm text-right" style="width: 100px;" name="Invoice[]" value="0" readonly></td>\n\
                    <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm text-right" style="width: 100px;" name="Total[]" value="0" onkeyup="caltot()"></td>\n\
            </tr>');

    $("#formdialogItem").dialog("close");

    cekDtl();
    calculate();
  }

  function choose_item() {
    function getText(el) {
      if (typeof el.textContent == 'string') return el.textContent;
      if (typeof el.innerText == 'string') return el.innerText;
    }

    var chk_arr = document.getElementsByName("chk[]");
    var chk_length = chk_arr.length;

    i = 1;
    for (k = 0; k < chk_length; k++) {
      if (chk_arr[k].checked == true) {
        $('table[id="tblList"]').append('<tr onclick="deleterow(this)">\n\
                        <td><button class="btn btn-sm btn-danger" type="button" ><i class="fa fa-trash" ></i></button></td>\n\
                            <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 150px;" name="ItemID[]" value="' + getText(document.getElementById('tbl-po').rows[i].cells[1]) + '" readonly></td>\n\
                            <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 250px;" name="ItemName[]" value="' + htmlSpecialChars(getText(document.getElementById('tbl-po').rows[i].cells[2])) + '" ></td>\n\
                            <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 60px;" name="UOM[]" value="' + getText(document.getElementById('tbl-po').rows[i].cells[3]) + '" readonly></td>\n\
                            <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm text-right" style="width: 80px;" name="Qty[]" value="0" onkeyup="calculate()"></td>\n\
                            <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm text-right" style="width: 80px;" name="Quantity[]" readonly></td>\n\
                            <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 70px;" name="TaxCode[]" value="" readonly></td>\n\
                            <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 140px;" name="NPBB[]" value="" ></td>\n\\n\
                            <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 140px;" name="PONO[]" value="" readonly></td>\n\
                            <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm text-right" style="width: 100px;" name="UnitPrice[]" value="0" onkeyup="calculate()"></td>\n\
                            <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm text-right"  name="Comission[]" value="0.00" onkeypress="return isNumber(event)" onkeyup="calculate()"></td>\n\
                            <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm text-right" style="width: 100px;" name="Invoice[]" value="0.00" readonly></td>\n\
                            <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm text-right" style="width: 100px;" name="Total[]" value="0" onkeyup="caltot()"></td>\n\
                            <td hidden><input type="text" class="form-control input-sm" name="per1000[]" value="' + getText(document.getElementById('tbl-po').rows[i].cells[4]) + '"></td>\n\
                    </tr>');
      }
      i++;
    }
    $("#formdialogItem").dialog("close");

    cekDtl();
    calculate();
  }

  function htmlSpecialChars(text) {
    return text
      .replace(/&/g, "&amp;")
      .replace(/"/g, "&quot;")
      .replace(/'/g, "&#039;")
      .replace(/</g, "&lt")
      .replace(/>/g, "&gt");

  }

  function close_item() {
    $("#formdialogItem").dialog("close");
  }

  function filtercust() {
    $findcust = document.getElementById("findcust").value;

    $.ajax({
      url: "<?php echo base_url(); ?>purchasing_inv/sales_invoice_cust?cust=" + $findcust + "",
      success: function(response) {
        $("#tblcust").html(response);
      },
      dataType: "html"
    });

    return false;
  }

  function filteritem() {
    filteritemreplace();
    //        filtertbl();
  }

  function filteritemreplace() {
    $finditem = document.getElementById("finditem").value;

    $.ajax({
      url: "<?php echo base_url(); ?>purchasing_inv/sales_invoice_direct_item?item=" + $finditem + "",
      success: function(response) {
        $("#tblitem").html(response);
      },
      dataType: "html"
    });

    return false;
  }

  function filterinv() {
    $findinv = document.getElementById("findinv").value;

    $.ajax({
      url: "<?php echo base_url(); ?>purchasing_inv/sales_invoice_direct_inv?inv=" + $findinv + "",
      success: function(response) {
        $("#tblinv").html(response);
      },
      dataType: "html"
    });

    return false;
  }

  function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode === 8 || charCode === 9 || charCode === 37 || charCode === 39 || charCode === 46 || (charCode > 47 && charCode < 58)) {
      return true;
    }
    return false;
  }

  function disc() {
    var dis = document.getElementById('discount').value;
    var total = document.getElementById('totalbefore').value / 100;
    var grantotal = dis * total;
    document.getElementById('totaldis').value = grantotal.toFixed(2);
  }

  function discwith() {
    var dis = document.getElementById('discount').value;
    var total = document.getElementById('totalbefore').value / 100;
    var grantotal = dis * total;
    document.getElementById('totaldis').value = grantotal;
    calculate();
  }

  function cekdisc() {
    var dis = document.getElementById('totaldis').value;
    var total = document.getElementById('totalbefore').value;
    if (total > 0) {
      var grantotal = (dis / total) * 100;
      document.getElementById('discount').value = grantotal;
    }
  }

  function calculate() {
    var int = 0;
    var total = 0;

    $('#tblList tr').each(function() {
      var Qnty = $(this).find("input[name='Qty[]']").val();
      $(this).find("input[name='Quantity[]']").val(Qnty);

      if (Qnty == 0) {
        caltot();
        exit;
      }

      var per1000 = $(this).find("input[name='per1000[]']").val();

      if (per1000 == '1') {
        $(this).find("input[name='Quantity[]']").val(Qnty / 1000);
      } else {
        $(this).find("input[name='Quantity[]']").val(Qnty);
      }

      var Quantity = $(this).find("input[name='Quantity[]']").val();
      var UnitPrice = parseFloat($(this).find("input[name='UnitPrice[]']").val());
      var Comission = $(this).find("input[name='Comission[]']").val();

      var newUnitPrice = ((UnitPrice / 100) * Comission) + parseFloat(UnitPrice);

      $(this).find("input[name='Invoice[]']").val(newUnitPrice.toFixed(4));

      var getUnitPrice = parseFloat($(this).find("input[name='Invoice[]']").val());

      var newTotal = Quantity * getUnitPrice;
      $(this).find("input[name='Total[]']").val(newTotal.toFixed(2));

      var getTotal = parseFloat($(this).find("input[name='Total[]']").val());

      if (int > 0) {
        total += getTotal;
      }
      int += 1;
    });

    document.getElementById('totalbefore').value = total.toFixed(2);
    disc();

    var totaldis = document.getElementById('totaldis').value;
    var freight = parseFloat(document.getElementById('freight').value);
    var tax = parseFloat(document.getElementById('tax').value);
    var grandtotal = (total - totaldis) + freight + tax;
    document.getElementById('totaldue').value = grandtotal.toFixed(2);
  }

  function caltot() {
    var int = 0;
    var total = 0;

    $('#tblList tr').each(function() {
      var Qnty = $(this).find("input[name='Qty[]']").val();

      if (Qnty > 0) {
        exit;
      }

      var TOT = parseFloat($(this).find("input[name='Total[]']").val());

      if (int > 0) {
        total += TOT;
      }
      int += 1;
    });

    document.getElementById('totalbefore').value = total.toFixed(2);
    disc();

    var totaldis = document.getElementById('totaldis').value;
    var freight = parseFloat(document.getElementById('freight').value);
    var tax = parseFloat(document.getElementById('tax').value);
    var grandtotal = (total - totaldis) + freight + tax;
    document.getElementById('totaldue').value = grandtotal.toFixed(2);
  }

  function filtertbl() {
    function getText(el) {
      if (typeof el.textContent == 'string') return el.textContent;
      if (typeof el.innerText == 'string') return el.innerText;
    }

    alert("Please click OK for REFRESH DATA !");

    $('#tblList_1 tr').each(function() {
      $ItemID = $(this).find("input[name='ItemID[]']").val();
      $MainPO = $(this).find("input[name='Mainpo[]']").val();
      $Docno_gr = $(this).find("input[name='docno_gr[]']").val();

      var rows = document.getElementById('tbl-po').rows;

      for (var row = 1; row < rows.length; row++) {
        $MainPOTemp = getText(document.getElementById('tbl-po').rows[row].cells[1]);
        $ItemIDTemp = getText(document.getElementById('tbl-po').rows[row].cells[4]);
        $Docno_grTemp = getText(document.getElementById('tbl-po').rows[row].cells[14]);

        if ($MainPO == $MainPOTemp && $ItemID == $ItemIDTemp && $Docno_gr == $Docno_grTemp) {
          document.getElementById("tbl-po").deleteRow(row);
        }

      }
    });
  }

  function cekhdr() {
    $('#tblList_1 tr').remove();
    //        document.getElementById("mainpo").value='';

    $cust = document.getElementById("cust").value;

    if ($cust != "") {
      $('#btn-click').attr('disabled', false);
    } else {
      $('#btn-click').attr('disabled', true);
    }
  }

  function cekDtl() {
    var ID_arr = document.getElementsByName("ItemID[]");
    var ID_length = ID_arr.length;

    $cust = document.getElementById("cust").value;

    if ((ID_length > 0) && $cust != "") {
      $('#btn-save').attr('disabled', false);
    } else {
      $('#btn-save').attr('disabled', true);
    }
  }

  function Rate() {
    $cur = document.getElementById("cur").value;
    $docdate = document.getElementById("docdate").value;

    $.ajax({
      url: "<?php echo base_url(); ?>purchasing_inv/sales_invoice_rate?cur=" + $cur + "&date=" + $docdate + "",
      success: function(response) {
        $("#rate").html(response);
        Termdate();
      },
      dataType: "html"
    });

    Rate_notfound($cur, $docdate);

    return false;
  }

  function Rate_notfound(cur, docdate) {
    $.ajax({
      url: "<?php echo base_url(); ?>purchasing_inv/sales_invoice_rate2?cur=" + cur + "&date=" + docdate + "",
      success: function(response) {
        $("#rate2").html(response);
        Termdate();
      },
      dataType: "html"
    });
  }

  function Termdate() {
    $duedate = document.getElementById('duedate').value;
    $docdate = document.getElementById('docdate').value;

    $duedate2 = $duedate.split("-");
    var duedate = new Date($duedate2[2] + '-' + $duedate2[1] + '-' + $duedate2[0]);

    $docdate2 = $docdate.split("-");
    var docdate = new Date($docdate2[2] + '-' + $docdate2[1] + '-' + $docdate2[0]);

    var oneday = 24 * 60 * 60 * 1000;
    var diffdays = Math.round(Math.round((duedate.getTime() - docdate.getTime()) / (oneday)));

    if (diffdays < 0) {
      diffdays = 0;
      document.getElementById("duedate").value = $docdate;
    }
    document.getElementById('days').value = diffdays;
  }


  function modal_delete(data) {
    $.ajax({
      url: "<?php echo base_url(); ?>purchasing_inv/sales_invoice_direct_modal_delete?delete=" + data + "",
      success: function(response) {
        $("#modal_delete").html(response);
      },
      dataType: "html"
    });

    return false;
  }

  function adddue() {
    $day = document.getElementById("days").value;
    var docdate = document.getElementById("docdate").value;
    $docdate = docdate.split("-");
    var date = $docdate[2] + '-' + $docdate[1] + '-' + $docdate[0];
    var newdate = new Date(date);
    newdate.setTime(newdate.getTime() + ($day * 24 * 60 * 60 * 1000));
    var datecustom = ("0" + newdate.getDate()).slice(-2) + "-" + ("0" + (newdate.getMonth() + 1)).slice(-2) + "-" + newdate.getFullYear();
    document.getElementById("duedate").value = datecustom;
  }
</script>