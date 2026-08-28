<!-- <link href="<?php echo base_url(); ?>assets/admin/css/cloud-admin.css" rel="stylesheet" type="text/css"> -->

<?php
if (isset($rate)) {
  $rate = $rate->rate_usd;
} else {
  $rate = '0';
}
?>

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
            <!-- <div class="tools">
                            <a href="javascript:;" class="collapse"></a>
                            <a href="javascript:;" class="fullscreen"></a>
                        </div>-->
          </div>
          <div class="portlet-body">
            <form action="<?php echo site_url('purchasing_inv/sales_invoice_save/add'); ?>" method="post" class="form-horizontal" role="form">
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
                        <div class="form-group " style="margin-bottom:1px;">
                          <label class="col-md-5 col-md-push-3 label-sm">Posting Date</label>
                          <div class="col-md-4 col-md-push-3">
                            <input type="text" name="postdate" class="form-control input-sm date date-picker" data-date="02-12-2012" data-date-format="dd-mm-yyyy" value="<?php echo date("d-m-Y"); ?>" required>
                          </div>
                        </div>
                        <div class="form-group" style="margin-bottom:1px;">
                          <label class="col-md-5 col-md-push-3 label-sm">Due Date</label>
                          <div class="col-md-4 col-md-push-3">
                            <input type="text" name="duedate" id="duedate" class="form-control input-sm" data-date="02-12-2012" data-date-format="dd-mm-yyyy" value="<?php echo date("d-m-Y"); ?>" required readonly>
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
                              <option value="GST">GST</option>
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
                            <th><button class="btn btn-sm btn-primary" type="button" onclick="fnDialogPO()" id="btn-click"><i class="fa fa-arrow-down"></i></button></th>
                            <th>Item ID</th>
                            <th>Item Name</th>
                            <th>UOM</th>
                            <th>UOM Alias</th>
                            <th>Qty</th>
                            <th>Qty Alias</th>
                            <th>Quantity</th>
                            <th>Quantity Alias</th>
                            <th>Tax Code</th>
                            <th hidden>categori ID</th>
                            <th>Unit Price</th>
                            <th>Unit Price Alias</th>
                            <th hidden>Commission</th>
                            <th>Invoice Price</th>
                            <th>Total</th>
                            <th>PO NO</th>
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
                          <table class="table table-bordered" id="tblListdp">
                            <thead>
                              <tr>
                                <th width="10px"> # </th>
                                <th>Reff Number</th>
                                <th>Pay</th>
                              </tr>
                            </thead>
                            <tbody id="tblListdp_1"></tbody>
                          </table>
                        </div>
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
                          <label onclick="showpo()" style="color: #0081c2;" class="col-md-3 label-sm">Remark</label>
                          <div class="col-md-9">
                            <textarea rows="3" class="form-control autosizeme" name="remark" id="showremark"></textarea>
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
                          <label class="col-md-4 col-md-push-1 label-sm" id="ini">Include Tax
                            <!-- <input type="checkbox" name="cekgst" id="cekgst" onclick="cek_GST()"> -->
                            <input type="checkbox" name="include" id="cekgst" onclick="calculate()">
                          </label>
                          <div class="col-md-4 col-md-push-1">
                            <div class="input-group">
                              <input class="form-control input-sm text-right" id="taxprice" name="taxprice">
                              <span class="input-group-addon">
                                %
                              </span>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <input class="form-control col-md- input-sm" type="text" id="taxcode" name="taxcode" placeholder="Tax Code">
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
                        <button type="button" title="Copy from SO" class="col-md-2 col-md-push-2 btn btn-default" onclick="fnDialogSO()">Copy SO</button>
                        <button id="btn-find" type="button" class="col-md-2 col-md-push-2 btn btn-warning" onclick="fnDialogINV()">Find</button>
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
                      <div class="form-group" style="margin-bottom:1px;">
                        <label class="col-md-4 label-sm">SO No</label>
                        <div class="col-md-8">
                          <input class="form-control input-sm" name="sono" id="sono" onchange="hdr()" readonly>
                        </div>
                      </div>
                      <!--div class="form-group" style="margin-bottom:1px;">
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
                          <!-- onkeyup="adddue()" -->
                          <input class="form-control input-sm" name="day" id="days" value="120" onkeypress="return isNumber(event)" readonly>
                        </div>
                      </div>
                      <!-- <div class="form-group" style="margin-bottom:1px;">
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
        <div id="formdialogPO"></div>
        <div id="formdialogINV"></div>
        <div id="formdialogSO"></div>
        <div id="formdialogDP"></div>
        <div id="modal_delete" class="modal fade bs-modal-lg" role="dialog" tabindex="-1" data-backdrop="static" data-keyboard="false" aria-hidden="true"></div>
      </div>
    </div>
  </div>
</div>

<script>
  $(document).ready(function() {
    adddue();
    Rate();


    $('#btn-save').attr('disabled', true);
    $('#btn-click').attr('disabled', true);
    $('#btn-searching').attr('disabled', false);
    $('#btn-find').attr('disabled', false);
    $searchcust = 0;

  });

  $("form").submit(function(e) {

    var duedate = $('#duedate').val();
    var docdate = $('#docdate').val();

    if (duedate == docdate) {
      alert("Opss, due date and document date cannot be same !");
      return false;
      e.preventDefault();
    } else {

      var duedate2 = duedate.split("-");
      var duedate = new Date(duedate2[2] + '-' + duedate2[1] + '-' + duedate2[0]);

      var docdate2 = docdate.split("-");
      var docdate = new Date(docdate2[2] + '-' + docdate2[1] + '-' + docdate2[0]);

      var oneday = 24 * 60 * 60 * 1000;
      var diffdays = Math.round(Math.round((duedate.getTime() - docdate.getTime()) / (oneday)));

      if (diffdays != 120) {
        alert("Opss, the gap between the due date and the doc date is not 120 days !");
        return false;
        e.preventDefault();
      } else {
        return true;
      }
    }


  });

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
                        <br>\n\
                        <div id='listPoLoader' class='modal-body text-center' style='display:none'>\n\
                          <i class='fa fa-spinner fa-pulse fa-3x fa-fw'></i> Loading...\n\
                        </div>\n\
                        <br>\n\
                        <br>\n\
                        <div class='table-scrollable' style='overflow: auto; height:400px;'>\n\
                            <table id='tbl-po' class='table table-bordered'>\n\
                                <thead>\n\
                                    <tr>\n\
                                        <th><input type='checkbox' onchange='check(this)'></th>\n\
                                        <th>Proforma Invoice</th>\n\
                                        <th>Doc Date</th>\n\
                                        <th>Customer Company</th>\n\
                                        <th>Item ID</th>\n\
                                        <th>Item Name</th>\n\
                                        <th>UOM</th>\n\
                                        <th hidden>Qty whs</th>\n\
                                        <th>Qty Order</th>\n\
                                        <th>Unit Price</th>\n\
                                        <th>Currency</th>\n\
                                        <th>Tax Code</th>\n\
                                        <th hidden>NPBB No</th>\n\
                                        <th hidden>PO No</th>\n\
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
      title: "List Proforma Invoice",
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
                        <br>\n\
                        <div id='listCustLoader' class='modal-body text-center' style='display:none'>\n\
                          <i class='fa fa-spinner fa-pulse fa-3x fa-fw'></i> Loading...\n\
                        </div>\n\
                        <br>\n\
                        <br>\n\
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
                        <br>\n\
                        <br>\n\
                        <div id='listInvLoader' class='modal-body text-center' style='display:none'>\n\
                          <i class='fa fa-spinner fa-pulse fa-3x fa-fw'></i> Loading...\n\
                        </div>\n\
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
                                        <th nowrap>Main PO</th>\n\
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

  function fnDialogSO() {
    $("#formdialogSO").html(" <div class='portlet-body'>\n\
                        <div class='col-md-12'>\n\
                            <div class='form-group'>\n\
                                 <label class='col-md-1 label-sm'>Find</label>\n\
                                 <div class='col-md-7'>\n\
                                       <input class='form-control input-sm' id='findso'>\n\
                                 </div>\n\
                                 <button type='button' class='col-md-1 btn blue' onclick='filterso()'>Search</button>\n\
                            </div>\n\
                        </div>\n\
                        <br><hr>\n\
                        <div class='table-scrollable' style='overflow: auto; height:490px;'>\n\
                            <table id='tbl-inv' class='table table-bordered'>\n\
                                <thead>\n\
                                    <tr>\n\
                                        <th>Action</th>\n\
                                        <th nowrap>SO No</th>\n\
                                        <th nowrap>Doc Date</th>\n\
                                        <th nowrap>Customer Company</th>\n\
                                        <th nowrap>Contact Person</th>\n\
                                        <th nowrap>Main PO</th>\n\
                                        <th nowrap>Total</th>\n\
                                        <th nowrap>currency</th>\n\
                                        <th nowrap>Created By</th>\n\
                                        <th nowrap>Created Date</th>\n\
                                        <th nowrap>LastUpdated By</th>\n\
                                        <th nowrap>LastUpdated Date</th>\n\
                                    </tr>\n\
                                </thead>\n\
                                <tbody id='tblso'>\n\
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
                                    </tr>\n\
                                </tbody>\n\
                            </table>\n\
                        </div>\n\
                </div>");

    // Define the Dialog and its properties.
    $("#formdialogSO").dialog({
      resizable: false,
      modal: true,
      title: "List Sales Order",
      height: 650,
      width: 1200

    });
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
    $searchcust = 0;
  }

  function deleterow(x) {
    $r = x.rowIndex;

    if (confirm("Are you sure remove this row?") == true) {
      document.getElementById("tblList").deleteRow($r);
      mainpo();
      calculate();
      cekDtl();
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
    1

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
                            <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 150px;" name="ItemID[]" value="' + getText(document.getElementById('tbl-po').rows[i].cells[4]) + '" readonly></td>\n\
                            <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 250px;" name="ItemName[]" value="' + htmlSpecialChars(getText(document.getElementById('tbl-po').rows[i].cells[5])) + '" readonly></td>\n\
                            <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 60px;" name="UOM[]" value="' + getText(document.getElementById('tbl-po').rows[i].cells[7]) + '" readonly></td>\n\
                            <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 60px;" name="UOM_Alias[]" value="' + getText(document.getElementById('tbl-po').rows[i].cells[7]) + '"></td>\n\
                            <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm text-right" style="width: 80px;" name="Qty[]" value="' + getText(document.getElementById('tbl-po').rows[i].cells[9]) + '" readonly></td>\n\
                            <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm text-right" style="width: 80px;" name="Qty_Alias[]" value="' + getText(document.getElementById('tbl-po').rows[i].cells[9]) + '"></td>\n\
                            <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm text-right" style="width: 80px;" name="Quantity[]" readonly></td>\n\
                            <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm text-right" style="width: 80px;" name="Quantity_Alias[]"></td>\n\
                            <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 70px;" name="TaxCode[]" value="' + getText(document.getElementById('tbl-po').rows[i].cells[12]) + '" ></td>\n\
                            <td hidden nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 140px;" name="NPBB[]" value="' + getText(document.getElementById('tbl-po').rows[i].cells[13]) + '" readonly></td>\n\
                            <td hidden><input type="text" class="form-control Mainpo" name="Mainpo[]" value="' + getText(document.getElementById('tbl-po').rows[i].cells[18]) + '">' + getText(document.getElementById('tbl-po').rows[i].cells[18]) + '</td>\n\
                            <td hidden><input type="text" class="form-control" name="docno_gr[]" value="' + getText(document.getElementById('tbl-po').rows[i].cells[15]) + '"></td>\n\
                            <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm text-right" style="width: 100px;" name="UnitPrice[]" value="' + getText(document.getElementById('tbl-po').rows[i].cells[10]) + '" onkeyup="calculate()"></td>\n\
                            <td hidden nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm text-right" style="width: 100px;" name="UnitPrice_Alias[]" value="' + getText(document.getElementById('tbl-po').rows[i].cells[10]) + '"></td>\n\
                            <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm text-right"  name="Comission[]" value="' + getText(document.getElementById('tbl-po').rows[i].cells[17]) + '" onkeypress="return isNumber(event)" onkeyup="calculate()"></td>\n\
                            <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm text-right" style="width: 100px;" name="Invoice[]" value="0" readonly></td>\n\
                            <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm text-right" style="width: 100px;" name="Total[]" value="0" readonly></td>\n\
                            <td  nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 140px;" name="pono[]" value="' + getText(document.getElementById('tbl-po').rows[i].cells[1]) + '" readonly></td>\n\
                            <td hidden><input type="text" class="form-control input-sm" name="per1000[]" value="' + getText(document.getElementById('tbl-po').rows[i].cells[16]) + '"></td>\n\
                    </tr>');
        var cur = getText(document.getElementById('tbl-po').rows[i].cells[11]);
        var sono = getText(document.getElementById('tbl-po').rows[i].cells[1]);
      }
      i++;
    }
    $("#formdialogPO").dialog("close");

    document.getElementById("cur").value = cur;
    document.getElementById("sono").value = sono;
    Rate();
    mainpo();
    calculate();
    cekDtl();


  }

  function htmlSpecialChars(text) {
    return text
      .replace(/&/g, "&amp;")
      .replace(/"/g, "&quot;")
      .replace(/'/g, "&#039;")
      .replace(/</g, "&lt")
      .replace(/>/g, "&gt");

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
                                <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm text-right" name="bayar[]" value="0" onkeyup="calculatedp()"></td>\n\
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
    let day = document.getElementById("days").value;
    let docdate = document.getElementById("docdate").value;
    let docdates = docdate.split("-");
    let date = docdates[2] + '-' + docdates[1] + '-' + docdates[0];
    let newdate = new Date(date);
    newdate.setTime(newdate.getTime() + (day * 24 * 60 * 60 * 1000));
    let datecustom = ("0" + newdate.getDate()).slice(-2) + "-" + ("0" + (newdate.getMonth() + 1)).slice(-2) + "-" + newdate.getFullYear();
    document.getElementById("duedate").value = datecustom;
  }

  function filtercust() {
    $findcust = document.getElementById("findcust").value;
    $("#tblcust").html('');

    $.ajax({
      dataType: "html",
      url: "<?php echo base_url(); ?>purchasing_inv/sales_invoice_cust?cust=" + $findcust + "",
      beforeSend: function() {
        $('#listCustLoader').show();
      },
      success: function(response) {
        $("#tblcust").html(response);
      },
      complete: function() {
        $('#listCustLoader').hide();
      },
    });

    return false;
  }

  function filterpo() {
    filterporeplace();
    // filtertbl();
  }

  function filterporeplace() {
    $cust = document.getElementById("cust").value;
    $findpo = document.getElementById("findpo").value;
    $("#tblpo").html('');

    $.ajax({
      dataType: "html",
      url: "<?php echo base_url(); ?>purchasing_inv/sales_invoice_po?cust=" + $cust + "&po=" + $findpo + "",
      beforeSend: function() {
        $('#listPoLoader').show();
      },
      success: function(response) {
        $("#tblpo").html(response);
      },
      complete: function() {
        $('#listPoLoader').hide();
      },
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
    $("#tblinv").html('');

    $.ajax({
      dataType: "html",
      url: "<?php echo base_url(); ?>purchasing_inv/sales_invoice_inv?inv=" + $findinv + "",
      beforeSend: function() {
        $('#listInvLoader').show();
      },
      success: function(response) {
        $("#tblinv").html(response);
      },
      complete: function() {
        $('#listInvLoader').hide();

      }

    });

    return false;
  }

  function filterso() {
    $findso = document.getElementById("findso").value;
    // alert($findso);
    $.ajax({
      url: "<?php echo base_url(); ?>purchasing_inv/sales_invoice_all?sono=" + $findso + "",
      success: function(response) {
        $("#tblso").html(response);
      },
      dataType: "html"
    });

    return false;
  }

  function mainpo() {
    function getText(el) {
      if (typeof el.textContent == 'string') return el.textContent;
      if (typeof el.innerText == 'string') return el.innerText;
    }

    var text = '';
    var chk_arr = document.getElementsByName("ItemID[]");
    var chk_length = chk_arr.length;

    i = 1;
    for (k = 0; k < chk_length; k++) {
      if (text != '') {
        text = text + ".k.p" + getText(document.getElementById('tblList').rows[i].cells[9]) + ".p";
      } else {
        text = ".p" + getText(document.getElementById('tblList').rows[i].cells[9]) + ".p";
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
    $cek = document.getElementById("cekgst").checked;
    $('#tblList tr').each(function() {
      var Qnty = $(this).find("input[name='Qty[]']").val();
      $(this).find("input[name='Quantity[]']").val(Qnty);

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
    var freightTax = ((total - totaldis) + freight) / 100;
    if ($cek) {
      var tax = parseFloat(document.getElementById('taxprice').value);
      tax = 9;
      document.getElementById('taxprice').value = tax;
      freightTax = ((total - totaldis) + freight) / 100;
    } else {
      tax = 0;
      document.getElementById('taxprice').value = tax;
      freightTax = 0;
    }
    var tax7 = tax * freightTax;

    document.getElementById('taxcode').value = tax7.toFixed(4);
    var tax = parseFloat(document.getElementById('taxprice').value);
    var totaldis = document.getElementById('totaldis').value;
    var freight = parseFloat(document.getElementById('freight').value);
    var grandtotal = (total - totaldis) + freight + tax7;
    document.getElementById('totaldue').value = grandtotal.toFixed(2);

    var dp = document.getElementById('txtdp').value;
    var grandtotalbalance = grandtotal - dp;
    document.getElementById('balance').value = grandtotalbalance.toFixed(2);

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
    //document.getElementById("mainpo").value='';

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
        adddue();
        //Termdate();
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
        adddue();
        //Termdate();
      },
      dataType: "html"
    });
  }

  function modal_delete(data) {
    $.ajax({
      url: "<?php echo base_url(); ?>purchasing_inv/sales_invoice_modal_delete?delete=" + data + "",
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

  function showpo() {
    var totalfre = "";
    $mainpo = document.getElementsByClassName("Mainpo");
    for (var i = 0; i < $mainpo.length; i++) {
      if (i == 0) {
        totalfre += 'PSS PO#' + $mainpo[i].value + '\r\n';
      } else {
        if ($mainpo[i].value != $mainpo[i - 1].value) {
          totalfre += 'PSS PO#' + $mainpo[i].value + '\r\n';
        }
      }
    }
    document.getElementById('showremark').value = totalfre;
  }
</script>