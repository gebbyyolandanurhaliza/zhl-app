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
    $('#btn-click2').attr('disabled', true);
    $('#btn-searching').attr('disabled', false);
    $('#btn-find').attr('disabled', false);
  });

  function validate(form) {
    var rate = document.getElementById("rate_usd").value;
    if (rate == 0) {
      alert('Rate Cannot 0, Please, Call Accounting Department for Entering Rates !');
      return false;
    } else {
      return confirm('Do you really want to submit the form?');
    }
  }
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
              <span class="caption-subject theme-font bold">Sales Invoice</span>
            </div>
          </div>
          <div class="portlet-body">
            <form action="<?php echo site_url('shipping_inv/sales_invoice_save/add'); ?>" method="post" class="form-horizontal" role="form" onsubmit="return validate(this);">
              <div class="row">
                <div class="col-md-9">
                  <div class="form-body">
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group" style="margin-bottom:1px;">
                          <label class="col-md-4 label-sm">Buyer</label>
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
                          <!--<label class="col-md-4 label-sm">Buy Ref</label>-->
                          <div class="col-md-4">
                            <input class="form-control input-sm" name="custref" id="custref" type="hidden">
                          </div>
                        </div>
                        <div class="form-group" style="margin-bottom:1px;">
                          <div class="col-md-4 col-md-offset-4">
                            <select class="form-control" data-placeholder="Currency" name="cur" id="cur" onchange="Rate()">
                              <?php
                              foreach ($cur as $r) {
                                if ($r->currency_id != 'USD') {
                                  echo '<option value="' . $r->currency_id . '">' . $r->currency_id . '</option>';
                                } else {
                                  echo '<option value="' . $r->currency_id . '" selected>' . $r->currency_id . '</option>';
                                }
                              }
                              ?>
                            </select>
                          </div>
                          <div id="rate" style="color: #5a7391"><input name="rate" id="rate_usd" value="<?php echo $rate; ?>" hidden>* Rate : <?php echo $rate; ?></div>
                        </div>
                      </div>

                      <div class="col-md-6">
                        <div class="form-group" style="margin-bottom:1px;">
                          <!--<label class="col-md-5 col-md-push-3 label-sm">Doc No</label>-->
                          <div class="col-md-4 col-md-push-3">
                            <input type="hidden" class="form-control input-sm" name="docno" readonly>
                          </div>
                        </div>

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
                              <option value="OUT" selected>Out of Scope</option>
                              <option value="GST">GST</option>
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
                            <th width="10px"><button class="btn btn-sm btn-primary" type="button" onclick="fnDialogPO()" id="btn-click"><i class="fa fa-arrow-down"></i></button></th>
                            <th>Po Number</th>
                            <th>Product ID</th>
                            <th>Product Name</th>
                            <th>UOM</th>
                            <th>Qty</th>
                            <th>Unit Price</th>
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
                        <div class="table-scrollable">
                          <table class="table table-bordered" id="tblList2">
                            <thead>
                              <tr>
                                <th width="10px"><button class="btn btn-sm btn-primary" onclick="add_row()" type="button" id="btn-click2"><i class="fa fa-plus"></i></button></th>
                                <th>Additional Cost</th>
                                <th>Price</th>
                                <th>Freight</th>
                              </tr>
                            </thead>
                            <tbody id="tblList_2">
                            </tbody>
                          </table>
                        </div>
                        <div class="table-scrollable">
                          <table class="table table-bordered" id="tblListdp">
                            <thead>
                              <tr>
                                <th width="10px"> # </th>
                                <th>Reff Number</th>
                                <th>Pay</th>
                                <th>Remark</th>
                              </tr>
                            </thead>
                            <tbody id="tblListdp_1"></tbody>
                          </table>
                        </div>

                        <div class="form-group" style="margin-bottom:1px;">
                          <label class="col-md-12 label-sm" onclick="fnDialogRemark()" style="color: #0081c2;">Remark</label>
                        </div>
                        <div class="form-group" style="margin-bottom:1px;">
                          <div class="col-md-12">
                            <textarea rows="3" class="form-control" name="remark" id="remarks"></textarea>
                          </div>
                        </div>

                        <div class="form-group" style="margin-bottom:1px;">
                          <label class="col-md-12 label-sm" onclick="fnDialogPayment()" style="color: #0081c2;">Bank Detail</label>
                        </div>
                        <div class="form-group" style="margin-bottom:1px;">
                          <div class="col-md-12">
                            <div id="pindahwaktu">
                              <textarea rows="3" class="form-control" name="paymentto" id="paymentto"></textarea>
                            </div>
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
                          <label class="col-md-3 col-md-push-1 label-sm">Tax</label>
                          <div class="col-md-4 col-md-push-1">
                            <div class="input-group">
                              <input type="text" class="form-control input-sm text-right" name="fortax" value="0" id="fortax" onkeyup="discwith2()">
                              <span class="input-group-addon">
                                %
                              </span>
                            </div>
                          </div>
                          <div class="col-md-5">
                            <input class="form-control input-sm text-right" name="tax" value="0.00" id="tax" onkeyup="cekdisc2();calculate()">
                          </div>
                        </div>
                        <div class="form-group" style="margin-bottom:1px;">
                          <label class="col-md-6 col-md-push-1 label-sm">Total</label>
                          <div class="col-md-5 col-md-push-1">
                            <input class="form-control input-sm text-right" name="totaldue" value="0.00" id="totaldue" readonly>
                          </div>
                        </div>
                        <div class="form-group" style="margin-bottom:1px;">
                          <label class="col-md-6 col-md-push-1 label-sm" onclick="fnDialogDP()" style="color: #0081c2;">Advance Payment</label>
                          <div class="col-md-5 col-md-push-1" id="dp">
                            <input class="form-control input-sm text-right" name="dp" id="txtdp" value="0.00" onkeyup="calculate()" readonly>
                          </div>
                        </div>
                        <div class="form-group" style="margin-bottom:1px;">
                          <label class="col-md-6 col-md-push-1 label-sm">Total Balance</label>
                          <div class="col-md-5 col-md-push-1">
                            <input class="form-control input-sm text-right" name="balance" id="balance" value="0.00" readonly>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="form-actions">
                    <div class="col-md-6">
                      <button type="submit" class="col-md-2 btn btn-primary" id="btn-save">Save</button>
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
                          <input type="hidden" name="sono" value="">
                        </div>
                      </div>
                      <div class="form-group" style="margin-bottom:1px;">
                        <label class="col-md-4 label-sm">Shipment Date</label>
                        <div class="col-md-8">
                          <input name="shipdate" id="shipdate" onchange="Termship()" class="form-control input-sm date date-picker" data-date="02-12-2012" data-date-format="dd-mm-yyyy" value="<?php echo date("d-m-Y"); ?>" required>
                        </div>
                      </div>
                      <div class="form-group" style="margin-bottom:1px;">
                        <label class="col-md-4 label-sm">Payment Term</label>
                        <div class="col-md-8">
                          <textarea rows="3" class="form-control" name="term" style="resize: none;height: 167px;" id="term"></textarea>
                        </div>
                      </div>
                      <div class="form-group" style="margin-bottom:1px;">
                        <label class="col-md-4 label-sm">Payment Term Days</label>
                        <div class="col-md-8">
                          <input class="form-control input-sm" name="day" id="days" value="0" onkeypress="return isNumber(event)" onkeyup="adddue()">
                        </div>
                      </div>
                      <div class="form-group" style="margin-bottom:1px;">
                        <label class="col-md-4 label-sm">Approval By</label>
                        <div class="col-md-8">
                          <select class="form-control select2me" name="userid" id="userid">
                            <?php
                            foreach ($user as $r) {
                              if ($r->userid != 'henry-fok') {
                                echo '<option value="' . $r->userid . '">' . $r->firstname . ' ' . $r->lastname . '</option>';
                              } else {
                                echo '<option value="' . $r->userid . '" selected>' . $r->firstname . ' ' . $r->lastname . '</option>';
                              }
                            }
                            ?>
                          </select>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

              </div>
            </form>
          </div>
        </div>
        <div id="formdialogCust"></div>
        <div id="formdialogPO"></div>
        <div id="formdialogINV"></div>
        <div id="formdialogRemark"></div>
        <div id="formdialogPayment"></div>
        <div id="formdialogDP"></div>
        <div id="modal_delete" class="modal fade bs-modal-lg" role="dialog" tabindex="-1" data-backdrop="static" data-keyboard="false" aria-hidden="true"></div>
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
                                        <input class='form-control input-sm' id='findpo'>\n\
                                 </div>\n\
                                 <button type='button' class='col-md-1 btn blue' onclick='filterpo()'>Search</button>\n\
                            </div>\n\
                        </div>\n\
                        <br><hr>\n\
                        <div class='table-scrollable' style='overflow: auto; height:400px;'>\n\
                            <table id='tbl-po' class='table table-bordered'>\n\
                                <thead>\n\
                                    <tr>\n\
                                        <th><input type='checkbox' onchange='check(this)'></th>\n\
                                        <th>PO Number</th>\n\
                                        <th>PO Date</th>\n\
                                        <th>Factory</th>\n\
                                        <th>Product ID</th>\n\
                                        <th>Product Name</th>\n\
                                        <th>UOM</th>\n\
                                        <th>Qty</th>\n\
                                        <th>Unit Price</th>\n\
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
                                    </tr>\n\
                                </tbody>\n\
                            </table>\n\
                        </div>\n\
                            <div class='col-md-6'>\n\
                                <button type='button' class='col-md-2 btn blue' onclick='choose_PO()'>Choose</button>\n\
                                <button type='button' class='col-md-2 btn grey' onclick='close_PO()'>Close</button>\n\
                            </div>\n\
                </div>");

    // Define the Dialog and its properties.
    $("#formdialogPO").dialog({
      resizable: false,
      modal: true,
      title: "List PO",
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
                                        <th nowrap>Status</th>\n\
                                        <th nowrap>Buyer</th>\n\
                                        <th nowrap>Contact Person</th>\n\
                                        <th nowrap>PO Number</th>\n\
                                        <th nowrap>Customer Ref</th>\n\
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

  function fnDialogRemark() {
    $("#formdialogRemark").html("<div class='portlet-body'>\n\
                            <div class='col-md-12'>\n\
                                <div class='form-group'>\n\
                                     <label class='col-md-1 label-sm'>Find</label>\n\
                                     <div class='col-md-7'>\n\
                                            <input class='form-control input-sm' id='findremark'>\n\
                                     </div>\n\
                                     <button type='button' class='col-md-2 btn blue' onclick='filterremark()'>Search</button>\n\
                                </div>\n\
                            </div>\n\
                            <br><hr>\n\
                            <div class='table-scrollable' style='overflow: auto; height:150px;'>\n\
                                <table id='tbl-remark' class='table table-bordered'>\n\
                                    <thead>\n\
                                        <tr>\n\
                                            <th>Inv Number</th>\n\
                                            <th>Buyer</th>\n\
                                            <th>Buyer Name</th>\n\
                                        </tr>\n\
                                    </thead>\n\
                                    <tbody id='tblremark'>\n\
                                        <tr ondblclick='clickdbremark(this)'>\n\
                                            <td></td>\n\
                                            <td></td>\n\
                                            <td></td>\n\
                                        </tr>\n\
                                    </tbody>\n\
                                </table>\n\
                            </div>\n\
                            <div class='col-md-12' style='margin-left:-15px;margin-bottom:20px;'>\n\
                                <textarea class='form-control ckeditor' id='txtremarks' style='width: 770px; height: 131px;'></textarea>\n\
                            </div>\n\
                            <div class='col-md-6'>\n\
                                <button type='button' class='col-md-4 btn blue' onclick='choose_Remark()'>Sent</button>\n\
                                <button type='button' class='col-md-4 btn grey' onclick='close_Remark()'>Close</button>\n\
                            </div>\n\
                        </div>");
    // Define the Dialog and its properties.
    $("#formdialogRemark").dialog({
      resizable: false,
      modal: true,
      title: "Remarks",
      top: 5,
      height: 500,
      width: 800

    });
    document.getElementById("txtremarks").value = document.getElementById("remarks").value;
  }

  function fnDialogPayment() {
    $("#formdialogPayment").html("<div class='portlet-body'>\n\
                            <div class='col-md-12'>\n\
                                <div class='form-group'>\n\
                                     <label class='col-md-1 label-sm'>Find</label>\n\
                                     <div class='col-md-7'>\n\
                                            <input class='form-control input-sm' id='findpayment'>\n\
                                     </div>\n\
                                     <button type='button' class='col-md-2 btn blue' onclick='filterpayment()'>Search</button>\n\
                                </div>\n\
                            </div>\n\
                            <br><hr>\n\
                            <div class='table-scrollable' style='overflow: auto; height:150px;'>\n\
                                <table id='tbl-payment' class='table table-bordered'>\n\
                                    <thead>\n\
                                        <tr>\n\
                                            <th>Inv Number</th>\n\
                                            <th>Buyer</th>\n\
                                            <th>Buyer Name</th>\n\
                                        </tr>\n\
                                    </thead>\n\
                                    <tbody id='tblpayment'>\n\
                                        <tr ondblclick='clickdbpayment(this)'>\n\
                                            <td></td>\n\
                                            <td></td>\n\
                                            <td></td>\n\
                                        </tr>\n\
                                    </tbody>\n\
                                </table>\n\
                            </div>\n\
                            <div class='col-md-12' style='margin-left:-15px;margin-bottom:20px;'>\n\
                                <textarea class='form-control ckeditor' id='txtpayment' style='width: 770px; height: 131px;'></textarea>\n\
                            </div>\n\
                            <div class='col-md-6'>\n\
                                <button type='button' class='col-md-4 btn blue' onclick='choose_Payment()'>Sent</button>\n\
                                <button type='button' class='col-md-4 btn grey' onclick='close_Payment()'>Close</button>\n\
                            </div>\n\
                        </div>");
    // Define the Dialog and its properties.
    $("#formdialogPayment").dialog({
      resizable: false,
      modal: true,
      title: "Remit Payment",
      top: 5,
      height: 500,
      width: 800

    });
    document.getElementById("txtpayment").value = document.getElementById("paymentto").value;
  }

  function fnDialogDP() {
    $("#formdialogDP").html("<div class='portlet-body'>\n\
                                <div class='col-md-12'>\n\
                                    <div class='form-group'>\n\
                                         <label class='col-md-1 label-sm'>Find</label>\n\
                                         <div class='col-md-7'>\n\
                                                <input class='form-control input-sm' id='finddp'>\n\
                                         </div>\n\
                                         <button type='button' class='col-md-2 btn blue' onclick='filterdp()'>Search</button>\n\
                                    </div>\n\
                                </div>\n\
                                <br><hr>\n\
                                <div class='table-scrollable' style='overflow: auto; height:300px;'>\n\
                                    <table id='tbl-dp' class='table table-bordered'>\n\
                                        <thead>\n\
                                            <tr>\n\
                                                <th>#</th>\n\
                                                <th>Customer</th>\n\
                                                <th>Reff Number</th>\n\
                                                <th>Currency</th>\n\
                                                <th>Total</th>\n\
                                            </tr>\n\
                                        </thead>\n\
                                        <tbody id='tbldp'>\n\
                                            <tr ondblclick='clickdbdp(this)'></tr>\n\
                                        </tbody>\n\
                                    </table>\n\
                                </div>\n\
                                <div class='col-md-12'>\n\
                                    <button type='button' class='col-md-2 btn blue' onclick='choose_DP()'>Choose</button>\n\
                                    <button type='button' class='col-md-2 btn grey' onclick='close_DP()'>Close</button>\n\
                                </div>\n\
                            </div>");
    // Define the Dialog and its properties.
    $("#formdialogDP").dialog({
      resizable: false,
      modal: true,
      title: "Advance Payment",
      top: 5,
      height: 500,
      width: 800

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


    $("#formdialogCust").dialog("close");
    cekhdr();
    cekDtl();
  }

  function deleterow(x) {
    $r = x.rowIndex;

    if (confirm("Are you sure remove this row?") == true) {
      document.getElementById("tblList").deleteRow($r);
      calculate();
      mainpo();
      cekDtl();
    }
  }

  function deleterow2(x) {
    var chk_arr = document.getElementsByName("addcost[]");
    var i = chk_arr.length;

    $r = x.rowIndex;

    if (i != $r) {
      return false;
    }

    if (confirm("Are you sure remove this row?") == true) {
      document.getElementById("tblList2").deleteRow($r);
    }
  }

  function deleterow3(x) {
    $r = x.rowIndex;

    if (confirm("Are you sure remove this row?") == true) {
      document.getElementById("tblListdp").deleteRow($r);
    }
    calculatedp();
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

    var chk_arr = document.getElementsByName("chk[]");
    var chk_length = chk_arr.length;

    i = 1;
    for (k = 0; k < chk_length; k++) {
      if (chk_arr[k].checked == true) {
        $('table[id="tblList"]').append('<tr onclick="deleterow(this)">\n\
                            <td><button class="btn btn-sm btn-danger" type="button" ><i class="fa fa-trash" ></i></button></td>\n\
                            <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" name="PoNumber[]" style="width: 150px;" value="' + getText(document.getElementById('tbl-po').rows[i].cells[1]) + '" readonly></td>\n\
                            <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 150px;" value="' + getText(document.getElementById('tbl-po').rows[i].cells[4]) + '" readonly></td>\n\
                            <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" name="ProductName[]" style="width: 350px;" value="' + getText(document.getElementById('tbl-po').rows[i].cells[5]) + '"></td>\n\
                            <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 70px;" value="' + getText(document.getElementById('tbl-po').rows[i].cells[6]) + '" readonly></td>\n\
                            <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm text-right" style="width: 70px;" name="Qty[]" value="' + getText(document.getElementById('tbl-po').rows[i].cells[7]) + '" readonly></td>\n\
                            <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm text-right" style="width: 100px;" name="UnitPrice[]" value="' + getText(document.getElementById('tbl-po').rows[i].cells[8]) + '" onkeypress="return isNumber(event)" onkeyup="calculate()" readonly></td>\n\
                            <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm text-right" style="width: 100px;" name="Total[]" readonly></td>\n\
                            <td hidden><input type="text" class="form-control input-sm" name="contid_dtl[]" value="' + getText(document.getElementById('tbl-po').rows[i].cells[9]) + '"></td>\n\
                            <td hidden><input type="text" class="form-control input-sm" name="PoID[]" value="' + getText(document.getElementById('tbl-po').rows[i].cells[10]) + '"></td>\n\
                            <td hidden><input type="text" class="form-control input-sm" name="ProductID[]" value="' + getText(document.getElementById('tbl-po').rows[i].cells[11]) + '"></td>\n\
                    </tr>');
        var payment = getText(document.getElementById('tbl-po').rows[i].cells[12]);
        var reff = getText(document.getElementById('tbl-po').rows[i].cells[13]);
        var pof = getText(document.getElementById('tbl-po').rows[i].cells[1]);;
      }


      i++;
    }
    $("#formdialogPO").dialog("close");


    document.getElementById("custref").value = reff;
    document.getElementById("term").value = payment;

    calculate();
    mainpo();
    cekDtl();
    isidetail(pof);
  }

  //tambahan 08-12-2017
  function isidetail(pof) {

    // alert(pof);
    var a = "<?php echo base_url(); ?>shipping_inv/cek_bank?po=" + pof + "";
    // alert(a);
    var urli = "<?php echo base_url(); ?>shipping_inv/cek_bank?po=" + pof + "";
    // alert(urli);
    $.ajax({
      url: urli,
      success: function(response) {
        $('#pindahwaktu').html(response);
      },
      dataType: "html"
    });

  }

  function add_row() {
    var chk_arr = document.getElementsByName("addcost[]");
    var i = chk_arr.length;

    $('table[id="tblList2"]').append('<tr onclick="deleterow2(this)">\n\
                    <td><button class="btn btn-sm btn-danger" type="button" ><i class="fa fa-trash" ></i></button></td>\n\
                        <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" name="addcost[]" ></td>\n\
                        <td nowrap onclick="event.stopPropagation();return false;" style="width: 90px;"><input type="text" class="form-control input-sm text-right"  name="price[]" value="0" onkeypress="return isNumbermin(event)" onkeyup="calculate()"></td>\n\
                        <td nowrap onclick="event.stopPropagation();" style="width: 20px;"><input type="checkbox" name="coa_freight[' + i + ']"></td>\n\
                </tr>');
  }

  function close_PO() {
    $("#formdialogPO").dialog("close");
  }

  function choose_DP() {

    function getText(el) {
      if (typeof el.textContent == 'string') return el.textContent;
      if (typeof el.innerText == 'string') return el.innerText;
    }

    var chk_dp_arr = document.getElementsByName("chk_dp[]");
    var chk_dp_length = chk_dp_arr.length;

    i = 1;
    for (k = 0; k < chk_dp_length; k++) {
      if (chk_dp_arr[k].checked == true) {
        $('table[id="tblListdp"]').append('<tr onclick="deleterow3(this)">\n\
                                <td><button class="btn btn-sm btn-danger" type="button" ><i class="fa fa-trash" ></i></button></td>\n\
                                <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" name="no_reff[]" value="' + getText(document.getElementById('tbl-dp').rows[i].cells[2]) + '" readonly></td>\n\
                                <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm text-right" name="bayar[]" style="width: 100px;" value="0" onkeyup="calculatedp()"></td>\n\
                                <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" name="dpremark[]" value=""></td>\n\
                                <td hidden><input type="text" class="form-control input-sm" name="detail_id[]" value="' + getText(document.getElementById('tbl-dp').rows[i].cells[5]) + '"></td>\n\
                            </tr>');
      }
      i++;
    }
    $("#formdialogDP").dialog("close");
  }

  function close_DP() {
    $("#formdialogDP").dialog("close");
  }

  function adddue() {
    $day = document.getElementById("days").value;
    var docdate = document.getElementById("shipdate").value;
    $docdate = docdate.split("-");
    var date = $docdate[2] + '-' + $docdate[1] + '-' + $docdate[0];
    var newdate = new Date(date);
    newdate.setTime(newdate.getTime() + ($day * 24 * 60 * 60 * 1000));
    var datecustom = ("0" + newdate.getDate()).slice(-2) + "-" + ("0" + (newdate.getMonth() + 1)).slice(-2) + "-" + newdate.getFullYear();
    document.getElementById("duedate").value = datecustom;
  }

  function filtercust() {
    $findcust = document.getElementById("findcust").value;

    $.ajax({
      url: "<?php echo base_url(); ?>shipping_inv/sales_invoice_cust?cust=" + $findcust + "",
      success: function(response) {
        $("#tblcust").html(response);
      },
      dataType: "html"
    });

    return false;
  }

  function filterpo() {
    filterporeplace();
    //        filtertbl();
  }

  function filterporeplace() {
    $cust = document.getElementById("cust").value;
    $findpo = document.getElementById("findpo").value;

    $.ajax({
      url: "<?php echo base_url(); ?>shipping_inv/sales_invoice_po?cust=" + $cust + "&po=" + $findpo + "",
      success: function(response) {
        $("#tblpo").html(response);
      },
      dataType: "html"
    });

    return false;
  }

  function filterdp() {
    $cust = document.getElementById("cust").value;
    $finddp = document.getElementById("finddp").value;

    $.ajax({
      url: "<?php echo base_url(); ?>purchasing_inv/sales_invoice_get_dp_new?cust=" + $cust + "&filter=" + $finddp + "",
      success: function(response) {
        $("#tbldp").html(response);
      },
      dataType: "html"
    });

    return false;
  }

  function filterinv() {
    $findinv = document.getElementById("findinv").value;

    $(document).ajaxStart(function() {
      $('#tblinv').html('<p style="text-align:center;"><img src="<?php echo base_url(); ?>assets/pages/img/loading.gif"></p>');
    });

    $.ajax({
      url: "<?php echo base_url(); ?>shipping_inv/sales_invoice_inv?inv=" + $findinv + "",
      success: function(response) {
        $("#tblinv").html(response);
      },
      dataType: "html"
    });

    return false;
  }

  function filterremark() {
    $findremark = document.getElementById("findremark").value;


    $.ajax({
      url: "<?php echo base_url(); ?>shipping_inv/sales_invoice_remark?remark=" + $findremark + "",
      success: function(response) {
        $("#tblremark").html(response);
      },
      dataType: "html"
    });
    return false;
  }

  function clickdbremark(x) {
    function getText(el) {
      if (typeof el.textContent == 'string') return el.textContent;
      if (typeof el.innerText == 'string') return el.innerText;
    }

    $r = x.rowIndex;
    document.getElementById('txtremarks').value = getText(document.getElementById('tbl-remark').rows[$r].cells[3]);
  }

  function choose_Remark() {
    document.getElementById("remarks").value = document.getElementById("txtremarks").value;
    $("#formdialogRemark").dialog("close");
  }

  function close_Remark() {
    $("#formdialogRemark").dialog("close");
  }

  function filterpayment() {
    $findpayment = document.getElementById("findpayment").value;

    $.ajax({
      url: "<?php echo base_url(); ?>shipping_inv/sales_invoice_payment?pay=" + $findpayment + "",
      success: function(response) {
        $("#tblpayment").html(response);
      },
      dataType: "html"
    });

    return false;
  }

  function clickdbpayment(x) {
    function getText(el) {
      if (typeof el.textContent == 'string') return el.textContent;
      if (typeof el.innerText == 'string') return el.innerText;
    }

    $r = x.rowIndex;
    document.getElementById('txtpayment').value = getText(document.getElementById('tbl-payment').rows[$r].cells[3]);
  }

  function choose_Payment() {
    document.getElementById('paymentto').value = document.getElementById('txtpayment').value;
    $("#formdialogPayment").dialog("close");
  }

  function close_Payment() {
    $("#formdialogPayment").dialog("close");
  }

  function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode === 8 || charCode === 37 || charCode === 39 || charCode === 46 || (charCode > 47 && charCode < 58)) {
      return true;
    }
    return false;
  }

  function isNumbermin(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;

    if (charCode === 8 || charCode === 37 || charCode === 39 || charCode === 46 || charCode === 45 || (charCode > 47 && charCode < 58)) {
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

  // =========================== TAMBAHAN 12-01-2018 =================================
  function discwith2() {
    var dis = document.getElementById('fortax').value;
    var total = document.getElementById('totalbefore').value / 100;
    var grantotal = dis * total;
    document.getElementById('tax').value = grantotal.toFixed(2);
    calculate();
  }

  function cekdisc2() {
    var dis = document.getElementById('tax').value;
    var total = document.getElementById('totalbefore').value;
    if (total > 0) {
      var grantotal = (dis / total) * 100;
      document.getElementById('fortax').value = grantotal;
    }
  }
  // =========================== ------ END  ------ ====================================

  function mainpo() {
    function getText(el) {
      if (typeof el.textContent == 'string') return el.textContent;
      if (typeof el.innerText == 'string') return el.innerText;
    }

    var text = '';
    var chk_arr = document.getElementsByName("PoNumber[]");
    var chk_length = chk_arr.length;

    i = 1;
    for (k = 0; k < chk_length; k++) {
      if (text != '') {
        text = text + ".k.p" + getText(document.getElementById('tblList').rows[i].cells[1]).split("/").join(".slash") + ".p";
      } else {
        text = ".p" + getText(document.getElementById('tblList').rows[i].cells[1]).split("/").join(".slash") + ".p";
      }
      i++;
    }

    //        if (text != ''){
    //            $.ajax({
    //                url: "<?php // echo base_url(); 
                            ?>purchasing_inv/sales_invoice_get_dp/" + text + "",
    //                success: function (response) {
    //                    $("#dp").html(response);
    //                    calculate();
    //                },
    //                dataType: "html"
    //            });
    //
    //            return false; 
    //        } else {
    //            document.getElementById("txtdp").value="0.00";
    //        }

    //        document.getElementById("mainpo").value=text;
  }

  function calculate() {
    var int = 0;
    var int2 = 0;
    var total = 0;
    var totprice = 0;

    $('#tblList tr').each(function() {
      var Qnty = $(this).find("input[name='Qty[]']").val();
      var UnitPrice = parseFloat($(this).find("input[name='UnitPrice[]']").val());
      var Total = Qnty * UnitPrice;

      $(this).find("input[name='Total[]']").val(Total.toFixed(2));

      var getTotal = parseFloat($(this).find("input[name='Total[]']").val());

      if (int > 0) {
        total += getTotal;
      }
      int += 1;
    });

    $('#tblList2 tr').each(function() {
      var Price = parseFloat($(this).find("input[name='price[]']").val());

      if (int2 > 0) {
        totprice += Price;
      }
      int2 += 1;
    });

    document.getElementById('totalbefore').value = total.toFixed(2);
    disc();

    var totaldis = document.getElementById('totaldis').value;
    var freight = parseFloat(document.getElementById('freight').value);
    var tax = parseFloat(document.getElementById('tax').value);
    var grandtotal = (total - totaldis) + freight + tax + totprice;
    document.getElementById('totaldue').value = grandtotal.toFixed(2);

    var dp = document.getElementById('txtdp').value;
    var grandtotalbalance = grandtotal - dp;
    document.getElementById('balance').value = grandtotalbalance.toFixed(2);
  }

  function cekhdr() {
    $('#tblList_1 tr').remove();

    $cust = document.getElementById("cust").value;

    if ($cust != "") {
      $('#btn-click').attr('disabled', false);
    } else {
      $('#btn-click').attr('disabled', true);
    }
  }

  function cekDtl() {
    var ID_arr = document.getElementsByName("ProductID[]");
    var ID_length = ID_arr.length;

    $cust = document.getElementById("cust").value;

    if ((ID_length > 0) && $cust != "") {
      $('#btn-save').attr('disabled', false);
      $('#btn-click2').attr('disabled', false);
    } else {
      $('#btn-save').attr('disabled', true);
      $('#btn-click2').attr('disabled', true);
    }
  }

  function Rate() {
    $cur = document.getElementById("cur").value;
    $docdate = document.getElementById("docdate").value;

    $.ajax({
      url: "<?php echo base_url(); ?>shipping_inv/sales_invoice_rate?cur=" + $cur + "&date=" + $docdate + "",
      success: function(response) {
        $("#rate").html(response);
        Termdate();
      },
      dataType: "html"
    });

    Rate_nofound($cur, $docdate);

    return false;
  }

  function Rate_nofound(cur, docdate) {

    $.ajax({
      url: "<?php echo base_url(); ?>shipping_inv/sales_invoice_rate2?cur=" + cur + "&date=" + docdate + "",
      success: function(response) {
        $("#rate2").html(response);
        Termdate();
      },
      dataType: "html"
    });

    return false;
  }

  function modal_delete(data) {
    $.ajax({
      url: "<?php echo base_url(); ?>shipping_inv/sales_invoice_modal_delete?delete=" + data + "",
      success: function(response) {
        $("#modal_delete").html(response);
      },
      dataType: "html"
    });

    return false;
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

  function Termship() {
    $shipdate = document.getElementById("shipdate").value;
    document.getElementById('duedate').value = $shipdate;
    document.getElementById('days').value = '0';
  }

  function cekdp(row) {
    $chk = document.getElementById('chkdp' + row).checked;

    if ($chk == true) {
      document.getElementById('bayar' + row).disabled = false;
    } else {
      document.getElementById('bayar' + row).disabled = true;
      document.getElementById('bayar' + row).value = '0.00';
    }
  }

  function calculatedp() {
    var total = 0;

    $('#tblListdp_1 tr').each(function() {
      var bayar = parseFloat($(this).find("input[name='bayar[]']").val());

      total += bayar;
    });

    document.getElementById('txtdp').value = total.toFixed(2);
    calculate();
  }

  function cek_cont(ele) {
    var checkboxes = document.getElementsByTagName('input');
    var cont_id = ele.value;
    if (ele.checked) {
      for (var i = 0; i < checkboxes.length; i++) {
        if (checkboxes[i].type == 'checkbox') {
          if (cont_id == checkboxes[i].value) {
            checkboxes[i].checked = true;
          }
        }
      }
    } else {
      for (var i = 0; i < checkboxes.length; i++) {
        if (checkboxes[i].type == 'checkbox') {
          if (cont_id == checkboxes[i].value) {
            checkboxes[i].checked = false;
          }
        }
      }
    }
  }
</script>