<?php
if (isset($rate)) {
  $rate = $rate->rate_kurs;
} else {
  $rate = '0';
}
?>

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
          <div class="portlet-title">
            <div id="rate2" style="color: #5a7391"></div>
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
                <div class="col-md-12">
                  <div class="form-body">
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group" style="margin-bottom:1px;">
                          <label class="col-md-4 label-sm">Main Po</label>
                          <div class="col-md-4">
                            <input class="form-control input-sm" name="mainpo" readonly>
                          </div>
                        </div>
                        <div class="form-group" style="margin-bottom:1px;">
                          <label class="col-md-4 label-sm">Vendor</label>
                          <div class="col-md-4">
                            <div class="input-group">
                              <input type="text" class="form-control input-sm" id="vendor" name="vendor" readonly>
                              <span class="input-group-btn">
                                <button id="btn-searching" class="btn btn-sm btn-primary" type="button" style="height:30px;" <?php if (is_null($rate)) { ?> disabled <?php   } ?> onclick="fnDialogSupp();"><i class="fa fa-arrow-down"></i></button>
                              </span>
                            </div>
                          </div>
                        </div>
                        <div class="form-group" style="margin-bottom:1px;">
                          <label class="col-md-4 label-sm">Name</label>
                          <div class="col-md-4">
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
                          <div class="col-md-3" id="rate" style="color: #5a7391"><input type="text" class="form-control" name="rate" value="<?php echo $rate; ?>" onkeypress="return isNumber(event)"></div>
                        </div>
                      </div>

                      <div class="col-md-6">
                        <!--                                                <div class="form-group" style="margin-bottom:1px;">
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
                      </div>
                    </div>

                    <hr>

                    <div class="table-scrollable">
                      <table class="table table-bordered" id="tblList">
                        <thead>
                          <tr>
                            <th style="vertical-align: middle;"><button class="btn btn-sm btn-primary" id="btn-npbb" type="button" onclick="fnDialogNPBB()"><i class="fa fa-arrow-down"></i></button></th>
                            <th style="width: 80px;">Item ID</th>
                            <th>Item Name</th>
                            <th style="width: 100px;">UOM</th>
                            <th style="width: 150px;">Qty</th>
                            <th style="width: 150px;">Quantity</th>
                            <th style="width: 150px;">Unit Price</th>
                            <th style="width: 150px;">Tax Code</th>
                            <th hidden="">NPBB NO</th>
                            <th hidden>PO NO</th>
                            <th style="width: 150px;">Total</th>
                            <th hidden="">Vendor PO Commission</th>
                            <th style="width: 150px;">Invoice Price</th>
                            <th hidden>Customer</th>
                            <th style="width: 150px;">HS Code</th>
                            <th style="width: 150px;">Country Of Origin</th>
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
                          <label class="col-md-3 label-sm">Ship Term</label>
                          <div class="col-md-9">
                            <select class="form-control select2me" data-placeholder="Shipping Term" name="term">
                              <option value=""></option>
                              <?php
                              foreach ($term as $r) {
                                echo '<option value="' . $r->trading_term_id . '">' . $r->trading_term_name . ' - ' . $r->trading_term_remark . '</option>';
                              }
                              ?>
                            </select>
                          </div>
                        </div>
                        <div class="form-group" style="margin-bottom:1px;">
                          <label class="col-md-3 label-sm">Warehouse</label>
                          <div class="col-md-9">
                            <select class="form-control select2me" data-placeholder="Warehouse" name="whs" required>
                              <?php
                              foreach ($whs as $r) {
                                echo '<option value="' . $r->id . '">' . $r->name . '</option>';
                              }
                              ?>
                            </select>
                          </div>
                        </div>
                        <div class="form-group" style="margin-bottom:1px;">
                          <label class="col-md-3 label-sm" onclick="fnDialogRemark()" style="color: #0081c2;">Remark</label>
                          <div class="col-md-9">
                            <textarea rows="3" class="form-control autosizeme" name="remark" style="display: none;"></textarea>
                            <textarea rows="3" class="form-control autosizeme" name="remarks" id="remarks"></textarea>
                          </div>
                        </div>
                        <div class="form-group" style="margin-bottom:1px;">
                          <label class="col-md-3 label-sm">Country Of Origin</label>
                          <div class="col-md-9">
                            <textarea rows="1" class="form-control autosizeme" name="remark_country"></textarea>
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
                              <span class="input-group-addon ">
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
                          <!-- <label hidden class="col-md-5" style="padding-left: 53px;"><input type="checkbox" name="include" id="include" onclick="calculate()">Include Tax</label> -->
                          <div class="col-md-5  col-md-push-1">
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
                              <input class="form-control input-sm text-right" id="taxprice" name="taxprice" readonly="">
                              <span class="input-group-addon">
                                %
                              </span>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <input class="form-control col-md- input-sm" type="text" id="taxcode" placeholder="Tax Code" readonly="">
                          </div>
                        </div>
                        <div class="form-group" style="margin-bottom:1px;">
                          <label class="col-md-6 col-md-push-1 label-sm">Tax</label>
                          <div class="col-md-5 col-md-push-1">
                            <input class="form-control input-sm text-right" name="tax" value="0.00" id="tax" onkeyup="calculate()" readonly>
                          </div>
                        </div>
                        <div class="form-group" style="margin-bottom:1px;">
                          <label class="col-md-6 col-md-push-1 label-sm">Total Payment Due</label>
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
                      <!--<a type="button" class="col-md-2 btn btn-default" href="<?php // echo site_url('purchasing_po');  
                                                                                  ?>">Cancel</a>-->
                      <button type="reset" class="col-md-2 btn btn-default" onclick="$('#tblList_1 tr').remove();">Cancel</button>
                    </div>
                    <div class="col-md-4">
                      <button id="btn-find" type="button" class="col-md-2 col-md-offset-7 btn btn-warning btn-block" onclick="fnDialogPO()"> Find</button>
                      <!-- <button id="btn-find" type="button" class="col-md-2 col-md-offset-6 btn btn-warning" onclick="fnDialogPONew()">Find New</button> -->
                    </div>
                  </div>
                </div>
                <div class="col-md-3" hidden>
                  <div class="portlet light">
                    <div class="portlet body">
                      <div class="form-group" style="margin-bottom:1px;">
                        <label class="col-md-4 label-sm" hidden>Main Po</label>
                        <div class="col-md-8" hidden>
                          <input class="form-control input-sm" name="mainpo" readonly H>
                        </div>
                      </div>
                      <div class="form-group" style="margin-bottom:1px;">
                        <label class="col-md-4 label-sm" hidden>Customer</label>
                        <div class="col-md-8">
                          <div class="input-group hidden">
                            <input type="text" class="form-control input-sm" id="cust" name="cust" readonly>
                            <span class="input-group-btn hidden">
                              <button id="btn-customer" class="btn btn-sm btn-primary" type="button" style="height:30px;" onclick="fnDialogCust()"><i class="fa fa-arrow-down"></i></button>
                            </span>
                          </div>
                        </div>
                      </div>
                      <div class="form-group" style="margin-bottom:1px;">
                        <label class="col-md-4 label-sm" hidden>Name</label>
                        <div class="col-md-8" hidden>
                          <textarea rows="3" class="form-control" id="custname" name="custname" style="resize: none;height: 100px;" readonly></textarea>
                        </div>
                      </div>
                      <div class="form-group" style="margin-bottom:1px;">
                        <div class="col-md-5 col-md-offset-4" style="padding-top: 5px; padding-left: 10px;">
                          <label class="label-sm" hidden><input type="checkbox" name="more" id="more" onclick="hidecoloumn2()">More Customer</label>
                        </div>
                      </div>
                      <div class="form-group" style="margin-bottom:1px;">
                        <label class="col-md-4 label-sm" hidden>Shipment Date</label>
                        <div class="col-md-8" hidden>
                          <input name="shipdate" class="form-control input-sm date date-picker" data-date="02-12-2012" data-date-format="dd-mm-yyyy" value="<?php echo date("d-m-Y"); ?>">
                        </div>
                      </div>
                      <div class="form-group" style="margin-bottom:1px;">
                        <label class="col-md-4 label-sm" hidden>From</label>
                        <div class="col-md-8" hidden>
                          <textarea rows="3" class="form-control" name="from" style="resize: none;height: 130px;"></textarea>
                        </div>
                      </div>
                      <div class="form-group" style="margin-bottom:1px;">
                        <label class="col-md-4 label-sm" hidden>To</label>
                        <div class="col-md-8" hidden>
                          <textarea rows="3" class="form-control" name="to" style="resize: none;height: 130px;"></textarea>
                        </div>
                      </div>
                      <!-- <div class="form-group" style="margin-bottom:1px;">
                                                <label class="col-md-4 label-sm">Arrived Date</label>
                                                <div class="col-md-8">
                                                    <input name="arriveddate" class="form-control input-sm date date-picker" data-date="02-12-2012" data-date-format="dd-mm-yyyy" value="<?php echo date("d-m-Y"); ?>">
                                                </div>
                                            </div>-->
                      <div class="form-group" style="margin-bottom:1px;">
                        <label class="col-md-4 label-sm" hidden>Amendment Date</label>
                        <div class="col-md-8" hidden>
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
        <div id="formdialogSupp"></div>
        <div id="formdialogCust"></div>
        <div id="formdialogPO"></div>
        <div id="formdialogRemark"></div>
        <div id="formdialogAlertWait"></div>
        <div id="modal_delete" class="modal fade bs-modal-lg" role="dialog" tabindex="-1" data-backdrop="static" data-keyboard="false" aria-hidden="true"></div>
      </div>
    </div>
  </div>
</div>

<script>
  $(document).ready(function() {
    $('#btn-save').attr('disabled', true);
    $('#btn-npbb').attr('disabled', true);
    $('#btn-searching').attr('disabled', false);
    $('#btn-customer').attr('disabled', false);
    $('#btn-find').attr('disabled', false);
  });

  function cek_GST() {
    var cek = document.getElementById('cekgst');
    if (cek.checked) {

    } else {
      document.getElementById('taxprice').value = '0.0000';
      document.getElementById('taxcode').value = '';
    }
  }

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
      title: "List Product",
      height: 650,
      width: 1200

    });
  }

  function fnDialogSupp() {
    $("#formdialogSupp").html("<div class='portlet-body'>\n\
                        <div class='col-md-12'>\n\
                            <div class='form-group'>\n\
                                 <label class='col-md-1 label-sm'>Find</label>\n\
                                 <div class='col-md-7'>\n\
                                        <input class='form-control input-sm' id='findsupp'>\n\
                                 </div>\n\
                                 <button type='button' class='col-md-2 btn blue' onclick='filtersupp()'>Search</button>\n\
                            </div>\n\
                        </div>\n\
                        <br><hr>\n\
                        <div class='table-scrollable' style='overflow: auto; height:300px;'>\n\
                            <table id='tbl-supp' class='table table-bordered'>\n\
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
                        <div class='table-scrollable' style='overflow: auto; height:490px;'>\n\
                            <table id='tbl-po' class='table table-bordered'>\n\
                                <thead>\n\
                                    <tr>\n\
                                        <th>Action</th>\n\
                                        <th nowrap>Main PO</th>\n\
                                        <th nowrap>Doc Date</th>\n\
                                        <th nowrap>Ship Date</th>\n\
                                        <th nowrap>Status</th>\n\
                                        <th nowrap>Vendor Company</th>\n\
                                        <th nowrap>Contact Person</th>\n\
                                        <th nowrap>Customer Company</th>\n\
                                        <th nowrap>Total</th>\n\
                                        <th nowrap>currency</th>\n\
                                        <th nowrap>Created By</th>\n\
                                        <th nowrap>Created Date</th>\n\
                                        <th nowrap>LastUpdated By</th>\n\
                                        <th nowrap>LastUpdated Date</th>\n\
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

  function fnDialogPONew() {
    $("#formdialogPO").html(" <div class='portlet-body'>\n\
                        <div class='col-md-12'>\n\
                            <div class='form-group'>\n\
                                 <label class='col-md-1 label-sm'>Find</label>\n\
                                 <div class='col-md-7'>\n\
                                       <input class='form-control input-sm' id='findpo'>\n\
                                 </div>\n\
                                 <button type='button' class='col-md-1 btn blue' onclick='filterpoNew()'>Search</button>\n\
                            </div>\n\
                        </div>\n\
                        <br><hr>\n\
                        <div class='table-scrollable' style='overflow: auto; height:490px;'>\n\
                            <table id='tbl-po' class='table table-bordered'>\n\
                                <thead>\n\
                                    <tr>\n\
                                        <th>Action</th>\n\
                                        <th nowrap>Main PO</th>\n\
                                        <th nowrap>Doc Date</th>\n\
                                        <th nowrap>Ship Date</th>\n\
                                        <th nowrap>Status</th>\n\
                                        <th nowrap>Vendor Company</th>\n\
                                        <th nowrap>Contact Person</th>\n\
                                        <th nowrap>Customer Company</th>\n\
                                        <th nowrap>Total</th>\n\
                                        <th nowrap>currency</th>\n\
                                        <th nowrap>Created By</th>\n\
                                        <th nowrap>Created Date</th>\n\
                                        <th nowrap>LastUpdated By</th>\n\
                                        <th nowrap>LastUpdated Date</th>\n\
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

  function fnDialogAlertWait() {
    $("#formdialogAlertWait").html("<div>\n\
                        <p>Please Wait.!</p>\n\
                    </div>");
    $("#formdialogAlertWait").dialog({
      modal: true,
      height: 100,
      open: function() {
        setTimeout("$('#formdialogAlertWait').dialog('close')", 500);
      }

    });
  }

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

    $taxc = getText(document.getElementById('tbl-supp').rows[$r].cells[3]);
    // alert($taxc);
    if ($taxc == 'GST') {
      document.getElementById("ini").innerHTML = "Tax Code <input type='checkbox' name='cekgst' id='cekgst' onclick='cek_GST()' checked>";
      // $('#cekgst').attr('checked', true);
      // alert($('#cekgst').val());
    }
    $("#formdialogSupp").dialog("close");
    cekDtl();
  }

  function clickdbcust(x) {
    function getText(el) {
      if (typeof el.textContent == 'string') return el.textContent;
      if (typeof el.innerText == 'string') return el.innerText;
    }

    $r = x.rowIndex;
    document.getElementById('cust').value = getText(document.getElementById('tbl-cust').rows[$r].cells[0]);
    document.getElementById('custname').value = getText(document.getElementById('tbl-cust').rows[$r].cells[1]);
    $("#formdialogCust").dialog("close");
    $('#tblList_1 tr').remove();
    cekDtl();
    hidecoloumn2();
  }

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

    var chk_arr = document.getElementsByName("chk[]");

    var chk_length = chk_arr.length;
    i = 1;

    for (k = 0; k < chk_length; k++) {
      if (chk_arr[k].checked == true) {
        $('table[id="tblList"]').append('<tr onclick="deleterow(this)">\n\
                                    <td  style="width: 50px;"><button class="btn btn-sm btn-danger" type="button" ><i class="fa fa-trash" ></i></button></td>\n\
                                        <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 80px;" name="ItemID[]" value="' + getText(document.getElementById('tbl-npbb').rows[i].cells[3]) + '" readonly></td>\n\
                                        <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm"  name="ItemName[]" value="' + htmlSpecialChars(getText(document.getElementById('tbl-npbb').rows[i].cells[4])) + '" readonly></td>\n\
                                        <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 100px;" name="UOM[]" value="' + getText(document.getElementById('tbl-npbb').rows[i].cells[8]) + '" readonly></td>\n\
                                        <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm text-right" style="width: 150px;" name="Qty[]" value="' + getText(document.getElementById('tbl-npbb').rows[i].cells[6]) + '" onkeypress="return isNumber(event)" onkeyup="calculate()" required=""></td>\n\
                                        <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm text-right" style="width: 150px;" name="Quantity[]" value="' + getText(document.getElementById('tbl-npbb').rows[i].cells[7]) + '" readonly></td>\n\
                                        <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm text-right" style="width: 150px;" name="UnitPrice[]" value="" onkeypress="return isNumber(event)" onkeyup="calculate()" required></td>\n\
                                        <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm codetax" style="width: 150px;" name="TaxCode[]" id="codetax" value=""></td>\n\
                                        <td hidden nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 140px;" name="NPBB[]" value="' + getText(document.getElementById('tbl-npbb').rows[i].cells[1]) + '"></td>\n\
                                        <td hidden nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 140px;" name="PONO[]"></td>\n\
                                        <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm text-right" style="width: 150px;" name="Total[]" readonly></td>\n\
                                        <td hidden nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm text-right"  name="VendorPO[]" value="5.0000" onkeypress="return isNumber(event)" onkeyup="calculate()"></td>\n\
                                        <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm text-right" style="width: 150px;" name="Invoice[]" value="0" onkeypress="return isNumber(event)"></td>\n\
                                        <td nowrap onclick="event.stopPropagation();return false;" style="display:none;">\n\
                                            <select class="form-control" data-placeholder="Customer" name="Companyid[]" style="width: 100px;">\n\
                                                <?php echo '<option value=""></option>'; ?>\n\
                                                <?php foreach ($cust as $r) { ?>\n\
                                                <?php echo '<option value="' . $r->customer_code . '">' . $r->customer_code . '</option>'; ?>\n\
                                                <?php } ?></select>\n\
                                       </td>\n\
                                       <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 150px;" name="hscode[]" value="' + getText(document.getElementById('tbl-npbb').rows[i].cells[13]) + '"></td>\n\
                                       <td nowrap onclick="event.stopPropagation();return false;">\n\
                                       <select class="form-control" data-placeholder="Customer" name="country_id[]" style="width: 150px;">\n\
                                            <option value="' + getText(document.getElementById('tbl-npbb').rows[i].cells[14]) + '">' + getText(document.getElementById('tbl-npbb').rows[i].cells[15]) + '</option>\n\
                                            <?php foreach ($country as $cr) { ?>\n\
                                            <?php echo '<option  value="' . $cr->country_id . '">' . $cr->country_name . '</option>'; ?>\n\
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
    hidecoloumn2();
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

  function filtersupp() {
    $findsupp = document.getElementById("findsupp").value;

    $(document).ajaxStart(function() {
      _loader("#tblsupp");
    });

    $.ajax({
      url: "<?php echo base_url(); ?>purchasing_po/purchase_order_vendor?vendor=" + $findsupp + "",
      success: function(response) {
        $("#tblsupp").html(response);
      },
      dataType: "html"
    });
    return false;
  }

  function filtercust() {
    $findcust = document.getElementById("findcust").value;

    $(document).ajaxStart(function() {
      _loader("#tblcust");
    });

    $.ajax({
      url: "<?php echo base_url(); ?>purchasing_po/purchase_order_cust?cust=" + $findcust + "",
      success: function(response) {
        $("#tblcust").html(response);
      },
      dataType: "html"
    });
    return false;
  }

  function filternpbb() {
    filternpbbreplace();
    //filtertbl();
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

  function filterpo() {
    $findpo = document.getElementById("findpo").value;

    $(document).ajaxStart(function() {
      _loader("#tblpo");
    });

    $.ajax({
      url: "<?php echo base_url(); ?>purchasing_po/purchase_order_po?po=" + $findpo + "",
      success: function(response) {
        $("#tblpo").html(response);
      },
      dataType: "html"
    });
    return false;
    exit;
  }

  function filterpoNew() {
    $findpo = document.getElementById("findpo").value;

    $(document).ajaxStart(function() {
      _loader("#tblpo");
    });

    $.ajax({
      url: "<?php echo base_url(); ?>purchasing_po_new/purchase_order_po?po=" + $findpo + "",
      success: function(response) {
        $("#tblpo").html(response);
      },
      dataType: "html"
    });
    return false;
    exit;
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
    //  Svar taxcode = document.getElementById('taxcode').value;
    $cek = document.getElementById("cekgst").checked;
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
      $(this).find("input[name='Total[]']").val(Total.toFixed(4));

      // var Comission = $(this).find("input[name='VendorPO[]']").val();
      // var newUnitPrice = ((UnitPrice / 100) * Comission) + parseFloat(UnitPrice);

      $(this).find("input[name='Invoice[]']").val(UnitPrice);

      var getTotal = parseFloat($(this).find("input[name='Total[]']").val());

      if (int > 0) {
        total += getTotal;
      }
      int += 1;
    });
    document.getElementById('totalbefore').value = total.toFixed(4);
    disc();
    var totaldis = document.getElementById('totaldis').value;
    var freight = parseFloat(document.getElementById('freight').value);
    var freightTax = (total - totaldis) / 100;

    if ($cek) {
      var taxprice = parseFloat(document.getElementById('taxprice').value);
      taxprice = 9;
      gst = 'GST';
      document.getElementById('taxprice').value = taxprice;
      document.getElementById('taxcode').value = gst;
      $('.codetax').val(gst)
      //document.getElementById('codetax').value = gst;

      freightTax = ((total - totaldis)) / 100;
    } else {
      taxprice = 0;
      gst = '';
      document.getElementById('taxprice').value = taxprice;
      document.getElementById('taxcode').value = gst;
      $('.codetax').val(gst)


      freightTax = 0;
      var taxprice = 0;

    }
    // var tax = taxprice * freightTax;
    var tax = taxprice * freightTax;

    document.getElementById('tax').value = tax.toFixed(4);
    //var grandtotal = (total - totaldis) + taxprice + tax;
    var grandtotal = (total - totaldis) + tax + freight;
    document.getElementById('totaldue').value = grandtotal.toFixed(4);
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

  function filtertbl2() {
    function getText(el) {
      if (typeof el.textContent == 'string') return el.textContent;
      if (typeof el.innerText == 'string') return el.innerText;
    }

    $('#tblList tr').each(function() {
      $ItemID = $(this).find("input[name='ItemID[]']").val();
      $NPBB = $(this).find("input[name='NPBB[]']").val();
      alert($ItemID);
      $cek = document.getElementById("findcek").checked;
      alert($ItemID + "/" + $NPBB + "/" + $cek);
      var rows = document.getElementById('tbl-npbbTemp').rows;
      for (var row = 0; row < rows.length; row++) {
        $NPBBTemp = getText(document.getElementById('tbl-npbb').rows[row].cells[1]);
        $ItemIDTemp = getText(document.getElementById('tbl-npbb').rows[row].cells[3]);
        if ($cek = 'true') {
          if ($NPBB != $NPBBTemp && $ItemID != $ItemIDTemp) {
            $('table[id="tbl-npbb"]').append('<tr">\n\
                                                    <td style="width: 5px;"><input type="checkbox" name="chk[]" ></td>\n\
                                                    <td nowrap>' + getText(document.getElementById('tbl-npbbTemp').rows[row].cells[1]) + '</td>\n\
                                                    <td nowrap>' + getText(document.getElementById('tbl-npbbTemp').rows[row].cells[2]) + '</td>\n\
                                                    <td nowrap>' + getText(document.getElementById('tbl-npbbTemp').rows[row].cells[3]) + '</td>\n\
                                                    <td nowrap>' + getText(document.getElementById('tbl-npbbTemp').rows[row].cells[4]) + '</td>\n\
                                                    <td nowrap>' + getText(document.getElementById('tbl-npbbTemp').rows[row].cells[5]) + '</td>\n\
                                                    <td nowrap class="text-right">' + getText(document.getElementById('tbl-npbbTemp').rows[row].cells[6]) + '</td>\n\
                                                    <td nowrap class="text-right">' + getText(document.getElementById('tbl-npbbTemp').rows[row].cells[7]) + '</td>\n\
                                                    <td nowrap>' + getText(document.getElementById('tbl-npbbTemp').rows[row].cells[8]) + '</td>\n\
                                                    <td nowrap class="text-right">' + getText(document.getElementById('tbl-npbbTemp').rows[row].cells[9]) + '</td>\n\
                                                </tr>');
          }
        } else {
          if ($ItemID != $ItemIDTemp) {
            $('table[id="tbl-npbb"]').append('<tr">\n\
                                                <td style="width: 5px;"><input type="checkbox" name="chk[]" ></td>\n\
                                                <td nowrap>' + getText(document.getElementById('tbl-npbbTemp').rows[row].cells[1]) + '</td>\n\
                                                <td nowrap>' + getText(document.getElementById('tbl-npbbTemp').rows[row].cells[2]) + '</td>\n\
                                                <td nowrap>' + getText(document.getElementById('tbl-npbbTemp').rows[row].cells[3]) + '</td>\n\
                                                <td nowrap>' + getText(document.getElementById('tbl-npbbTemp').rows[row].cells[4]) + '</td>\n\
                                                <td nowrap>' + getText(document.getElementById('tbl-npbbTemp').rows[row].cells[5]) + '</td>\n\
                                                <td nowrap class="text-right">' + getText(document.getElementById('tbl-npbbTemp').rows[row].cells[6]) + '</td>\n\
                                                <td nowrap class="text-right">' + getText(document.getElementById('tbl-npbbTemp').rows[row].cells[7]) + '</td>\n\
                                                <td nowrap>' + getText(document.getElementById('tbl-npbbTemp').rows[row].cells[8]) + '</td>\n\
                                                <td nowrap class="text-right">' + getText(document.getElementById('tbl-npbbTemp').rows[row].cells[9]) + '</td>\n\
                                            </tr>');
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
    $vendor = document.getElementById("vendor").value;
    $rate = document.getElementById("rate").value;

    if (($vendor != "")) {
      $('#btn-npbb').attr('disabled', false);
    } else {
      $('#btn-npbb').attr('disabled', true);
    }

    if ((ID_length > 0) && ($vendor != "")) {
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

    Rate_notfound($cur, $docdate);
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