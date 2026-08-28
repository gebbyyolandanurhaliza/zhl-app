<?php
foreach ($po as $r) {
  $vendor       = $r->vendorid;
  $name         = $r->vendorcompany;
  $contact      = $r->vendorcontact;
  $vendorref    = $r->vendorref;
  $currency     = $r->currency;
  $remark       = $r->remark;
  $remarks      = $r->remarks;
  $totalbefore  = $r->maintotal;
  $Totdiscount  = $r->discount;
  $discount     = ($Totdiscount / $totalbefore) * 100;
  $freight      = $r->freight;
  $tax          = $r->taxcode;
  $taxprice     = $r->tax;
  $totaldue     = $r->totaldue;
  $custid       = $r->custid;
  $custname     = $r->custcompany;
  $from         = $r->custfrom;
  $to           = $r->custto;
  $tradeterm    = $r->tradeterm;
  $whsid        = $r->whsid;
  $more         = $r->more;
  $include      = $r->include;
  $taxfreight   = ($totalbefore - $Totdiscount) / 100;
  $taxPriceTemp = $taxprice;
  if ($include != 0) {
    if ($freight > 0) {
      $taxPriceTemp = 7;
    } else {
      $taxPriceTemp = 0;
    }
    $taxfreight = (($totalbefore - $Totdiscount) + $freight) / 100;
  }

  $taxtotal = $taxPriceTemp * $taxfreight;
}

if (isset($rate)) {
  $rate = $rate->rate_usd;
} else {
  $rate = '0';
}
?>
<script>
  $(document).ready(function() {
    hidecoloumn2();
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
              <span class="caption-subject theme-font bold">Purchase Order</span>
            </div>
            <!--                        <div class="tools">
                            <a href="javascript:;" class="collapse"></a>
                            <a href="javascript:;" class="fullscreen"></a>
                        </div>-->
          </div>
          <div class="portlet-body">
            <form action="<?php echo site_url('purchasing_po/purchase_order_save/add'); ?>" method="post" class="form-horizontal" role="form">
              <div class="row">
                <div class="col-md-9">
                  <div class="form-body">
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group" style="margin-bottom:1px;">
                          <label class="col-md-4 label-sm">Vendor</label>
                          <div class="col-md-4">
                            <input type="text" class="form-control input-sm" name="vendor" id="vendor" value="<?php echo $vendor; ?>" readonly>
                            <input type="text" id="taxcode" value="<?php echo $tax; ?>" hidden>
                            <input type="text" id="taxprice" value="<?php echo $taxprice; ?>" name="taxprice" hidden>
                          </div>
                        </div>
                        <div class="form-group" style="margin-bottom:1px;">
                          <label class="col-md-4 label-sm">Name</label>
                          <div class="col-md-5">
                            <input class="form-control input-sm" name="name" value="<?php echo $name; ?>" readonly>
                          </div>
                        </div>
                        <div class="form-group " style="margin-bottom:1px;">
                          <label class="col-md-4 label-sm">Contact Person</label>
                          <div class="col-md-4">
                            <input class="form-control input-sm" name="contact" value="<?php echo $contact; ?>" readonly>
                          </div>
                        </div>
                        <div class="form-group" style="margin-bottom:1px;">
                          <label class="col-md-4 label-sm">Vendor Ref</label>
                          <div class="col-md-4">
                            <input class="form-control input-sm" name="vendorref" value="<?php echo $vendorref; ?>" readonly>
                          </div>
                        </div>
                        <div class="form-group" style="margin-bottom:1px;">
                          <div class="col-md-4 col-md-offset-4">
                            <select class="form-control" data-placeholder="Currency" name="cur" id="cur" onchange="Rate()">
                              <?php
                              foreach ($cur as $r) {
                                if ($r->currency_id != $currency) {
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
                          <label class="col-md-5 col-md-push-3 label-sm">Deliver Date</label>
                          <div class="col-md-4 col-md-push-3">
                            <input type="text" name="deliverdate" class="form-control input-sm date date-picker" data-date="02-12-2012" data-date-format="dd-mm-yyyy" value="<?php echo date("d-m-Y"); ?>" required>
                          </div>
                        </div>
                        <div class="form-group" style="margin-bottom:1px;">
                          <label class="col-md-5 col-md-push-3 label-sm">Document Date</label>
                          <div class="col-md-4 col-md-push-3">
                            <input type="text" name="docdate" id="docdate" onchange="Rate()" class="form-control input-sm date date-picker" data-date="02-12-2012" data-date-format="dd-mm-yyyy" value="<?php echo date("d-m-Y"); ?>" required>
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
                      </div>
                    </div>

                    <hr>

                    <div class="table-scrollable" style='overflow: auto; height:300px;'>
                      <table class="table table-bordered" id="tblList">
                        <thead>
                          <tr>
                            <th><button class="btn btn-sm btn-primary" type="button" onclick="fnDialogNPBB()" id="btn-npbb"><i class="fa fa-arrow-down"></i></button></th>
                            <th>Item ID</th>
                            <th>Item Name</th>
                            <th>UOM</th>
                            <th>Qty</th>
                            <th>Quantity</th>
                            <th>Unit Price</th>
                            <th>Tax Code</th>
                            <th>NPBB NO</th>
                            <th>PO NO</th>
                            <th>Total</th>
                            <th>Vendor PO Commission</th>
                            <th>Invoice Price</th>
                            <th>Customer</th>
                          </tr>
                        </thead>
                        <tbody id="tblList_1">
                          <?php foreach ($po as $x) { ?>
                            <tr onclick="deleterow(this)">
                              <td><button class="btn btn-sm btn-danger" type="button"><i class="fa fa-trash"></i></button></td>
                              <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 150px;" name="ItemID[]" value="<?php echo $x->itemid; ?>" readonly></td>
                              <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 250px;" name="ItemName[]" value="<?php echo htmlspecialchars($x->itemname, ENT_QUOTES); ?>" readonly></td>
                              <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 60px;" name="UOM[]" value="<?php echo $x->uomname; ?>" readonly></td>
                              <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm text-right" style="width: 80px;" name="Qty[]" value="<?php echo number_format($x->qty, 2, '.', ''); ?>" onkeypress="return isNumber(event)" onkeyup="calculate()" required=""></td>
                              <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm text-right" style="width: 80px;" name="Quantity[]" value="<?php echo number_format($x->quantity, 2, '.', ''); ?>" readonly></td>
                              <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm text-right" style="width: 100px;" name="UnitPrice[]" value="<?php echo number_format($x->unitprice, 4, '.', ''); ?>" onkeypress="return isNumber(event)" onkeyup="calculate()" required=""></td>
                              <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 70px;" name="TaxCode[]" value="<?php echo $x->taxcode; ?>"></td>
                              <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 140px;" name="NPBB[]" value="<?php echo $x->npbbno; ?>"></td>
                              <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 140px;" name="PONO[]" value="<?php echo $x->pono; ?>"></td>
                              <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm text-right" style="width: 100px;" name="Total[]" value="<?php echo number_format($x->total, 2, '.', ''); ?>" readonly></td>
                              <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm text-right" name="VendorPO[]" value="<?php echo number_format($x->vendorpo, 2); ?>" onkeypress="return isNumber(event)" onkeyup="calculate()"></td>
                              <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm text-right" style="width: 100px;" name="Invoice[]" value="<?php echo number_format($x->invoiceprice, 4); ?>" onkeypress="return isNumber(event)"></td>
                              <td nowrap onclick="event.stopPropagation();return false;" style="display:none;">
                                <select class="form-control" data-placeholder="Customer" name="Companyid[]" style="width: 100px;">
                                  <?php
                                  if ($custid != '') {
                                    foreach ($cust as $r) {
                                      if ($custid != $r->customer_code) {
                                        if ($x->companyid != $r->customer_code) {
                                          echo '<option value="' . $r->customer_code . '">' . $r->customer_code . '</option>';
                                        } else {
                                          echo '<option value="' . $r->customer_code . '" selected>' . $r->customer_code . '</option>';
                                        }
                                      } else {
                                        echo '<option value="" selected></option>';
                                      }
                                    }
                                  } else {
                                    echo '<option value="" selected></option>';
                                  }
                                  ?>
                                </select>
                              </td>
                              <td hidden><input type="text" class="form-control input-sm" name="per1000[]" value="<?php echo $x->per1000; ?>"></td>
                            </tr>
                          <?php } ?>
                        </tbody>
                      </table>
                    </div>

                    <hr>

                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group" style="margin-bottom:1px;">
                          <label class="col-md-3 label-sm">Ship Term</label>
                          <div class="col-md-9">
                            <select class="form-control select2me" data-placeholder="Shipping Term" name="term">
                              <option value=""></option>
                              <?php
                              foreach ($term as $r) {
                                if ($tradeterm != $r->trading_term_id) {
                                  echo '<option value="' . $r->trading_term_id . '">' . $r->trading_term_name . ' - ' . $r->trading_term_remark . '</option>';
                                } else {
                                  echo '<option value="' . $r->trading_term_id . '" selected>' . $r->trading_term_name . ' - ' . $r->trading_term_remark . '</option>';
                                }
                              }
                              ?>
                            </select>
                          </div>
                        </div>
                        <div class="form-group" style="margin-bottom:1px;">
                          <label class="col-md-3 label-sm">Warehouse</label>
                          <div class="col-md-9">
                            <select class="form-control select2me" data-placeholder="Warehouse" name="whs">
                              <?php
                              foreach ($whs as $r) {
                                if ($whsid != $r->id) {
                                  echo '<option value="' . $r->id . '">' . $r->name . '</option>';
                                } else {
                                  echo '<option value="' . $r->id . '" selected>' . $r->name . '</option>';
                                }
                              }
                              ?>
                            </select>
                          </div>
                        </div>
                        <div class="form-group" style="margin-bottom:1px;">
                          <label class="col-md-3 label-sm" onclick="fnDialogRemark()" style="color: #0081c2;">Remark</label>
                          <div class="col-md-9">
                            <textarea rows="3" class="form-control autosizeme" name="remark" style="display: none;"><?php echo $remark; ?></textarea>
                            <textarea rows="3" class="form-control autosizeme" name="remarks" id="remarks"><?php echo str_replace("<br />", "", $remarks); ?></textarea>
                          </div>
                        </div>
                      </div>

                      <div class="col-md-offset-1 col-md-5 well">
                        <div class="form-group" style="margin-bottom:1px;">
                          <label class="col-md-6 col-md-push-1 label-sm">Total Before Discount</label>
                          <div class="col-md-5 col-md-push-1">
                            <input type="text" class="form-control input-sm text-right" name="totalbefore" value="<?php echo number_format($totalbefore, 2, '.', ''); ?>" id="totalbefore" readonly>
                          </div>
                        </div>
                        <div class="form-group" style="margin-bottom:1px;">
                          <label class="col-md-3 col-md-push-1 label-sm">Discount</label>
                          <div class="col-md-4 col-md-push-1">
                            <div class="input-group">
                              <input type="text" class="form-control input-sm text-right" name="discount" value="<?php echo $discount; ?>" id="discount" onkeyup="discwith()">
                              <span class="input-group-addon">
                                %
                              </span>
                            </div>
                          </div>
                          <div class="col-md-5">
                            <input type="text" class="form-control input-sm text-right" name="totaldis" value="<?php echo number_format($Totdiscount, 2, '.', ''); ?>" id="totaldis" onkeyup="cekdisc()" onchange="calculate()">
                          </div>
                        </div>
                        <div class="form-group " style="margin-bottom:1px;">
                          <label class="col-md-2 col-md-push-1 label-sm">Freight</label>
                          <label class="col-md-5" style="padding-left: 53px;"><input type="checkbox" name="include" id="include" onclick="calculate()" <?php if ($include == '1') {
                                                                                                                                                          echo 'checked';
                                                                                                                                                        } ?>>Include Tax</label>
                          <div class="col-md-5">
                            <input class="form-control input-sm text-right" name="freight" value="<?php echo number_format($freight, 2, '.', ''); ?>" id="freight" onkeyup="calculate()">
                          </div>
                        </div>
                        <div class="form-group" style="margin-bottom:1px;">
                          <label class="col-md-6 col-md-push-1 label-sm">Tax</label>
                          <div class="col-md-5 col-md-push-1">
                            <input class="form-control input-sm text-right" name="tax" value="<?php echo number_format($taxtotal, 2, '.', ''); ?>" id="tax" onkeyup="calculate()">
                          </div>
                        </div>
                        <div class="form-group" style="margin-bottom:1px;">
                          <label class="col-md-6 col-md-push-1 label-sm">Total Payment Due</label>
                          <div class="col-md-5 col-md-push-1">
                            <input class="form-control input-sm text-right" name="totaldue" value="<?php echo number_format($totaldue, 2, '.', ''); ?>" id="totaldue" readonly>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="form-actions">
                    <div class="col-md-6">
                      <button type="submit" class="col-md-2 btn btn-primary" id="btn-save">Save</button>
                      <a type="button" class="col-md-2 btn btn-default" href="<?php echo site_url('purchasing_po'); ?>">Cancel</a>
                    </div>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="portlet light">
                    <div class="portlet body">
                      <div class="form-group" style="margin-bottom:1px;">
                        <label class="col-md-4 label-sm">Main Po</label>
                        <div class="col-md-8">
                          <input class="form-control input-sm" name="mainpo" readonly>
                        </div>
                      </div>
                      <div class="form-group" style="margin-bottom:1px;">
                        <label class="col-md-4 label-sm">Customer</label>
                        <div class="col-md-8">
                          <input type="text" class="form-control input-sm" name="cust" id="cust" value="<?php echo $custid; ?>" readonly>
                        </div>
                      </div>
                      <div class="form-group" style="margin-bottom:1px;">
                        <label class="col-md-4 label-sm">Name</label>
                        <div class="col-md-8">
                          <textarea rows="3" class="form-control" name="custname" style="resize: none;height: 100px;" readonly><?php echo $custname; ?></textarea>
                        </div>
                      </div>
                      <div class="form-group" style="margin-bottom:1px;">
                        <div class="col-md-5 col-md-offset-4" style="padding-top: 5px; padding-left: 10px;">
                          <label class="label-sm"><input type="checkbox" name="more" id="more" onclick="hidecoloumn2()" <?php if ($more == '1') {
                                                                                                                          echo 'checked';
                                                                                                                        } ?>>More Customer</label>
                        </div>

                      </div>
                      <div class="form-group" style="margin-bottom:1px;">
                        <label class="col-md-4 label-sm">Ship D.</label>
                        <div class="col-md-8">
                          <input name="shipdate" class="form-control input-sm date date-picker" data-date="02-12-2012" data-date-format="dd-mm-yyyy" value="<?php echo date("d-m-Y"); ?>">
                        </div>
                      </div>
                      <div class="form-group" style="margin-bottom:1px;">
                        <label class="col-md-4 label-sm">From</label>
                        <div class="col-md-8">
                          <textarea rows="3" class="form-control" name="from" style="resize: none;height: 167px;"><?php echo $from; ?></textarea>
                        </div>
                      </div>
                      <div class="form-group" style="margin-bottom:1px;">
                        <label class="col-md-4 label-sm">To</label>
                        <div class="col-md-8">
                          <textarea rows="3" class="form-control" name="to" style="resize: none;height: 167px;"><?php echo $to; ?></textarea>
                        </div>
                      </div>
                      <!--                                            <div class="form-group" style="margin-bottom:1px;">
                                                <label class="col-md-4 label-sm">Arrived D.</label>
                                                <div class="col-md-8">
                                                    <input name="arriveddate" class="form-control input-sm date date-picker" data-date="02-12-2012" data-date-format="dd-mm-yyyy" value="<?php // echo date("d-m-Y"); 
                                                                                                                                                                                          ?>">
                                                </div>
                                            </div>-->
                      <div class="form-group" style="margin-bottom:1px;">
                        <label class="col-md-4 label-sm">Amendment Date</label>
                        <div class="col-md-8">
                          <input name="amendmentdate" class="form-control input-sm date date-picker" data-date="02-12-2012" data-date-format="dd-mm-yyyy" value="">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

              </div>
            </form>
          </div>
        </div>
        <div id="formdialogNPBB"></div>
        <div id="formdialogRemark"></div>
        <div id="modal_delete" class="modal fade bs-modal-lg" role="dialog" tabindex="-1" data-backdrop="static" data-keyboard="false" aria-hidden="true"></div>
      </div>
    </div>
  </div>
</div>

<script>
  function fnDialogNPBB() {
    $("#formdialogNPBB").html(" <div class='portlet-body'>\n\
                        <div class='col-md-12'>\n\
                            <div class='form-group'>\n\
                                 <label class='col-md-1 label-sm'>Find</label>\n\
                                 <div class='col-md-7'>\n\
                                    <input class='form-control input-sm' id='findnpbb'>\n\
                                 </div>\n\
                                 <button type='button' class='col-md-1 btn blue' onclick='filternpbb()'>Search</button>\n\
                                 <div class='col-md-offset-1 col-md-2' style='text-align: right;'>\n\
                                    <input type='checkbox' onclick='hidecoloumn()' id='findcek' checked><label class='label-sm'>Show Item</label>\n\
                                 </div>\n\
                            </div>\n\
                        </div>\n\
                        <br><hr>\n\
                        <div class='table-scrollable' style='overflow: auto; height:400px;'>\n\
                            <table id='tbl-npbb' class='table table-bordered'>\n\
                                <thead>\n\
                                    <tr>\n\
                                        <th><input type='checkbox' onchange='check(this)'></th>\n\
                                        <th style='display:none;'>NPBB No</th>\n\
                                        <th style='display:none;'>NPBB Date</th>\n\
                                        <th>Item ID</th>\n\
                                        <th>Item Name</th>\n\
                                        <th>Label PM Code</th>\n\
                                        <th style='display:none;'>Qnty</th>\n\
                                        <th style='display:none;'>Quantity</th>\n\
                                        <th>UOM</th>\n\
                                        <th>Unit Price</th>\n\
                                        <th style='display:none;'>Factory</th>\n\
                                    </tr>\n\
                                </thead>\n\
                                <tbody id='tblnpbb'>\n\
                                    <tr>\n\
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
                                <button type='button' class='col-md-2 btn blue' onclick='choose_NPBB()' id='choose'>Choose</button>\n\
                                <button type='button' class='col-md-2 btn grey' onclick='close_NPBB()'>Close</button>\n\
                            </div>\n\
                </div>");

    // Define the Dialog and its properties.
    $("#formdialogNPBB").dialog({
      resizable: false,
      modal: true,
      title: "List NPBB",
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
                                        <th>PO Number</th>\n\
                                        <th>Vendor</th>\n\
                                        <th>Customer</th>\n\
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
                            <textarea class=form-control' id='txtremarks' style='width: 770px; height: 131px;'></textarea>\n\
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
</script>
<script>
  function deleterow(x) {
    $r = x.rowIndex;

    if (confirm("Are you sure remove this row?") == true) {
      document.getElementById("tblList").deleteRow($r);
      calculate();
      cekDtl();
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

  function choose_NPBB() {
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
                        <td><button class="btn btn-sm btn-danger" type="button" ><i class="fa fa-trash" ></i></button></td>\n\
                            <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 150px;" name="ItemID[]" value="' + getText(document.getElementById('tbl-npbb').rows[i].cells[3]) + '" readonly></td>\n\
                            <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 250px;" name="ItemName[]" value="' + htmlSpecialChars(getText(document.getElementById('tbl-npbb').rows[i].cells[4])) + '" readonly></td>\n\
                            <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 60px;" name="UOM[]" value="' + getText(document.getElementById('tbl-npbb').rows[i].cells[8]) + '" readonly></td>\n\
                            <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm text-right" style="width: 80px;" name="Qty[]" value="' + getText(document.getElementById('tbl-npbb').rows[i].cells[6]) + '" onkeypress="return isNumber(event)" onkeyup="calculate()" required=""></td>\n\
                            <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm text-right" style="width: 80px;" name="Quantity[]" value="' + getText(document.getElementById('tbl-npbb').rows[i].cells[7]) + '" onkeypress="return isNumber(event)" readonly></td>\n\
                            <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm text-right" style="width: 100px;" name="UnitPrice[]" value="' + getText(document.getElementById('tbl-npbb').rows[i].cells[9]) + '" onkeypress="return isNumber(event)" onkeyup="calculate()" required=""></td>\n\
                            <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 70px;" name="TaxCode[]" value="' + document.getElementById('taxcode').value + '"></td>\n\
                            <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 140px;" name="NPBB[]" value="' + getText(document.getElementById('tbl-npbb').rows[i].cells[1]) + '" ></td>\n\\n\
                            <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 140px;" name="PONO[]"></td>\n\
                            <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm text-right" style="width: 100px;" name="Total[]" readonly></td>\n\
                            <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm text-right"  name="VendorPO[]" value="5.00" onkeypress="return isNumber(event)" onkeyup="calculate()"></td>\n\
                            <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm text-right" style="width: 100px;" name="Invoice[]" value="0" onkeypress="return isNumber(event)"></td>\n\
                            <td nowrap onclick="event.stopPropagation();return false;" style="display:none;">\n\
                                <select class="form-control" data-placeholder="Customer" name="Companyid[]" style="width: 100px;">\n\
                                    <?php echo '<option value=""></option>'; ?>\n\
                                    <?php foreach ($cust as $r) { ?>\n\
                                    <?php echo '<option value="' . $r->customer_code . '">' . $r->customer_code . '</option>'; ?>\n\
                                    <?php } ?></select>\n\
                           </td>\n\
                           <td hidden><input type="text" class="form-control input-sm" name="per1000[]" value="' + getText(document.getElementById('tbl-npbb').rows[i].cells[12]) + '"></td>\n\
                    </tr>');
      }
      i++;
    }

    $("#formdialogNPBB").dialog("close");

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

  function close_NPBB() {
    $("#formdialogNPBB").dialog("close");
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

  function filternpbb() {
    filternpbbreplace();
    //        filtertbl();
  }

  function filternpbbreplace() {
    $cek = document.getElementById("findcek").checked;
    $findnpbb = document.getElementById("findnpbb").value;
    $vendor = document.getElementById("vendor").value;
    $cust = document.getElementById("cust").value;
    $cur = document.getElementById("cur").value;

    $(document).ajaxStart(function() {
      _loader("#tblnpbb");
    });

    $.ajax({
      url: "<?php echo base_url(); ?>purchasing_po/purchase_order_npbb?cek=" + $cek + "&vendor=" + $vendor + "&cust=" + $cust + "&cur=" + $cur + "&item=" + $findnpbb + "",
      success: function(response) {
        $("#tblnpbb").html(response);
      },
      dataType: "html"
    });
    return false;
  }

  function filterremark() {
    $findremark = document.getElementById("findremark").value;

    $(document).ajaxStart(function() {
      _loader("#tblremark");
    });

    $.ajax({
      url: "<?php echo base_url(); ?>purchasing_po/purchase_order_remark?remark=" + $findremark + "",
      success: function(response) {
        $("#tblremark").html(response);
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
    document.getElementById('totaldis').value = grantotal.toFixed(2);

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
    var taxprice = document.getElementById('taxprice').value;
    $cek = document.getElementById("include").checked;

    $('#tblList tr').each(function() {
      var Qnty = $(this).find("input[name='Qty[]']").val();
      var per1000 = $(this).find("input[name='per1000[]']").val();

      if (per1000 == '1') {
        $(this).find("input[name='Quantity[]']").val(Qnty / 1000);
      } else {
        $(this).find("input[name='Quantity[]']").val(Qnty);
      }

      var Quantity = $(this).find("input[name='Quantity[]']").val();
      var UnitPrice = $(this).find("input[name='UnitPrice[]']").val();
      var Total = Quantity * UnitPrice;
      $(this).find("input[name='Total[]']").val(Total.toFixed(2));

      var Comission = $(this).find("input[name='VendorPO[]']").val();
      var newUnitPrice = ((UnitPrice / 100) * Comission) + parseFloat(UnitPrice);
      var newTotal = Quantity * newUnitPrice;

      $(this).find("input[name='Invoice[]']").val(newTotal.toFixed(2));

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
    var freightTax = (total - totaldis) / 100;
    if ($cek) {
      if (freight > 0) {
        taxprice = 7;
      } else {
        taxprice = 0;
      }
      freightTax = ((total - totaldis) + freight) / 100;
    }
    var tax = taxprice * freightTax;

    document.getElementById('tax').value = tax.toFixed(2);
    var grandtotal = (total - totaldis) + freight + tax;
    document.getElementById('totaldue').value = grandtotal.toFixed(2);
  }

  function hidecoloumn() {
    $("#tblnpbb tr").remove();
    $cek = document.getElementById("findcek").checked;
    var rows = document.getElementById('tbl-npbb').rows;

    for (var row = 0; row < rows.length; row++) {
      var cols = rows[row].cells;
      cols[1].style.display = $cek ? 'none' : '';
      cols[2].style.display = $cek ? 'none' : '';
      cols[5].style.display = $cek ? 'none' : '';
      cols[6].style.display = $cek ? 'none' : '';
      cols[9].style.display = $cek ? 'none' : '';
    }
  }

  function hidecoloumn2() {
    $cek = document.getElementById("more").checked;
    var rows = document.getElementById('tblList').rows;
    for (var row = 0; row < rows.length; row++) {
      var cols = rows[row].cells;
      cols[13].style.display = $cek ? '' : 'none';
    }
  }

  function filtertbl() {
    function getText(el) {
      if (typeof el.textContent == 'string') return el.textContent;
      if (typeof el.innerText == 'string') return el.innerText;
    }

    alert("Please click OK for REFRESH DATA !");

    $('#tblList_1 tr').each(function() {

      $ItemID = $(this).find("input[name='ItemID[]']").val();
      $NPBB = $(this).find("input[name='NPBB[]']").val();
      $Companyid = $(this).find("input[name='Companyid[]']").val();

      $cek = document.getElementById("findcek").checked;

      var rows = document.getElementById('tbl-npbb').rows;

      for (var row = 1; row < rows.length; row++) {
        $NPBBTemp = getText(document.getElementById('tbl-npbb').rows[row].cells[1]);
        $ItemIDTemp = getText(document.getElementById('tbl-npbb').rows[row].cells[3]);
        $CompanyidTemp = getText(document.getElementById('tbl-npbb').rows[row].cells[11]);

        if ($cek = 'true') {
          if ($NPBB == $NPBBTemp && $ItemID == $ItemIDTemp && $Companyid == $CompanyidTemp) {
            document.getElementById("tbl-npbb").deleteRow(row);
          }
        } else {
          if ($ItemID == $ItemIDTemp) {
            document.getElementById("tbl-npbb").deleteRow(row);
          }
        }
      }
    });
  }

  function remarkEnter(evt) {
    $remark = document.getElementById("txtremarks").value;

    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode === 13) {
      document.getElementById("txtremarks").value = $remark + '<br>';
    }
  }

  function cekDtl() {
    var ID_arr = document.getElementsByName("ItemID[]");
    var ID_length = ID_arr.length;

    if (ID_length > 0) {
      $('#btn-save').attr('disabled', false);
    } else {
      $('#btn-save').attr('disabled', true);
    }
  }

  function Rate() {
    $cur = document.getElementById("cur").value;
    $docdate = document.getElementById("docdate").value;

    $.ajax({
      url: "<?php echo base_url(); ?>purchasing_po/purchase_order_rate?cur=" + $cur + "&date=" + $docdate + "",
      success: function(response) {
        $("#rate").html(response);
      },
      dataType: "html"
    });

    Rate_notfound($cur, $docdate)

    return false;
  }

  function Rate_notfound(cur, docdate) {

    $.ajax({
      url: "<?php echo base_url(); ?>purchasing_po/purchase_order_rate2?cur=" + cur + "&date=" + docdate + "",
      success: function(response) {
        $("#rate2").html(response);
      },
      dataType: "html"
    });
  }

  function modal_delete(data) {
    $.ajax({
      url: "<?php echo base_url(); ?>purchasing_po/purchase_order_modal_delete?delete=" + data + "",
      success: function(response) {
        $("#modal_delete").html(response);
      },
      dataType: "html"
    });
    return false;
  }
</script>