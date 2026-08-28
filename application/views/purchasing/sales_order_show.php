<?php
foreach ($so as $r) {
  $cust =  $r->custid;
  $name =  $r->custcompany;
  $contact =  $r->custcontact;
  $custref =  $r->custref;
  $currency =  $r->currency;
  $rate =  $r->rate;
  $status =  $r->status;
  $docno = substr($r->sono, 6);
  $postdate = date("d-m-Y",  strtotime($r->postdate));
  $duedate =  date("d-m-Y",  strtotime($r->duedate));
  $docdate =  date("d-m-Y",  strtotime($r->docdate));
  $via =  $r->via;
  $remark =  $r->remarks;
  $totalbefore = $r->maintotal;
  $Totdiscount = $r->discount;
  $discount = ($Totdiscount / $totalbefore) * 100;
  $freight =  $r->freight;
  $tax = $r->tax;
  $taxprice =  $r->taxprice;
  $totaldue =  $r->totaldue;
  $sono =  $r->sono;
  $from =  $r->sofrom;
  $to =  $r->soto;
  $shipdate = date("d-m-Y",  strtotime($r->shipdate));
  $term = $r->term;
  $termdays = $r->termdays;
  $inv_status = $r->inv_status;
  $include = $r->include;
}
?>
<script>
  $(document).ready(function() {
    if (<?php echo $inv_status; ?> == '1') {
      $('#btn-po').attr('disabled', true);
      $('#btn-update').attr('disabled', true);
    }
  });
</script>

<!-- <link href="<?php echo base_url(); ?>assets/admin/css/cloud-admin.css" rel="stylesheet" type="text/css"> -->

<div class="page-content">
  <div class="container-fluid">
    <div class="row">
      <div class="alert alert-info">
        <?php

        if ($inv_status == 1) {
          echo '<span"><strong><h3 ><b class="alert-heading">The Sales Order has been input in Invoice</b></h3></strong></span>';
          // echo '<span style="color:#AFA;text-align:center;">Request has been sent. Please wait for my reply!</span>';
        }
        ?>
      </div>
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
              <span class="caption-subject theme-font bold">Proforma Invoice</span>
            </div>
            <!--                        <div class="tools">
                            <a href="javascript:;" class="collapse"></a>
                            <a href="javascript:;" class="fullscreen"></a>
                        </div>-->
          </div>
          <div class="portlet-body">
            <form action="<?php echo site_url('purchasing_so/sales_order_save/update'); ?>" method="post" class="form-horizontal" role="form">
              <div class="row">
                <div class="col-md-9">
                  <div class="form-body">
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group" style="margin-bottom:1px;">
                          <label class="col-md-4 label-sm">Customer</label>
                          <div class="col-md-4">
                            <input type="text" class="form-control input-sm" id="cust" name="cust" value="<?php echo $cust; ?>" readonly>
                            <input type="text" id="taxcode" value="<?php echo $tax; ?>" hidden>
                            <input type="text" id="taxprice1" value="<?php echo $taxprice; ?>" hidden>
                          </div>
                        </div>
                        <div class="form-group" style="margin-bottom:1px;">
                          <label class="col-md-4 label-sm">Name</label>
                          <div class="col-md-7">
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
                          <label class="col-md-4 label-sm">Customer Ref</label>
                          <div class="col-md-4">
                            <input class="form-control input-sm" name="vendorref" value="<?php echo $custref; ?>" readonly>
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
                                                            <input type="text" class="form-control input-sm" name="docno" value="<?php // echo $docno; 
                                                                                                                                  ?>" readonly>
                                                        </div>
                                                    </div>-->

                        <div class="form-group " style="margin-bottom:1px;">
                          <label class="col-md-5 col-md-push-3 label-sm">Posting Date</label>
                          <div class="col-md-4 col-md-push-3">
                            <input text="text" name="postdate" class="form-control input-sm date date-picker" data-date="02-12-2012" data-date-format="dd-mm-yyyy" value="<?php echo $postdate; ?>" required>
                          </div>
                        </div>
                        <div class="form-group" style="margin-bottom:1px;">
                          <label class="col-md-5 col-md-push-3 label-sm">Due Date</label>
                          <div class="col-md-4 col-md-push-3">
                            <input type="text" name="duedate" id="duedate" onchange="Rate()" class="form-control input-sm date date-picker" data-date="02-12-2012" data-date-format="dd-mm-yyyy" value="<?php echo $duedate; ?>" required>
                          </div>
                        </div>
                        <div class="form-group" style="margin-bottom:1px;">
                          <label class="col-md-5 col-md-push-3 label-sm">Document Date</label>
                          <div class="col-md-4 col-md-push-3">
                            <input type="text" name="docdate" id="docdate" onchange="Rate();" class="form-control input-sm date date-picker" data-date="02-12-2012" data-date-format="dd-mm-yyyy" value="<?php echo $docdate; ?>" required>
                          </div>
                        </div>

                        <div class="form-group" style="margin-bottom:1px;">
                          <label class="col-md-5 col-md-push-3 label-sm">Status</label>
                          <div class="col-md-4 col-md-push-3">
                            <select class="form-control" data-placeholder="Status" name="status">
                              <option value="1" <?php if ($status == 1) {
                                                  echo "selected";
                                                } ?>>Open</option>
                              <option value="2" <?php if ($status == 2) {
                                                  echo "selected";
                                                } ?>>Closed</option>
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
                            <th><button class="btn btn-sm btn-primary" type="button" onclick="fnDialogPO()" id="btn-po"><i class="fa fa-arrow-down"></i></button></th>
                            <th>Seq No</th>
                            <th>Item ID</th>
                            <th>Item Name</th>
                            <th>UOM</th>
                            <th>Qty</th>
                            <th>Quantity</th>
                            <th>Unit Price</th>
                            <th>Nett Weight</th>
                            <th>Gross Weight</th>
                            <th>Invoice Price</th>
                            <th>Total</th>
                            <th>Main PO</th>
                            <th>Docno GR</th>

                          </tr>
                        </thead>
                        <tbody id="tblList_1">
                          <?php foreach ($so as $x) { ?>
                            <tr onclick="deleterow(this)">
                              <td><button class="btn btn-sm btn-danger" type="button"><i class="fa fa-trash"></i></button></td>
                              <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm text-right" style="width: 50px;" name="SeqNo[]" value="<?php echo $x->nourut; ?>"></td>
                              <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 100px;" name="ItemID[]" value="<?php echo $x->itemid; ?>" readonly></td>
                              <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" name="ItemName[]" value="<?php echo htmlspecialchars($x->itemname, ENT_QUOTES); ?>" readonly></td>
                              <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 80px;" name="UOM[]" value="<?php echo $x->uomname; ?>" readonly></td>
                              <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm text-right" style="width: 80px;" name="Qty[]" value="<?php echo number_format($x->qty, 2, '.', ''); ?>" onkeypress="return isNumber(event)" onkeyup="calculate()" required=""></td>
                              <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm text-right" style="width: 80px;" name="Quantity[]" value="<?php echo number_format($x->quantity, 2, '.', ''); ?>" readonly></td>
                              <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm text-right" style="width: 100px;" name="UnitPrice[]" value="<?php echo number_format($x->unitprice, 2, '.', ''); ?>" onkeyup="calculate()"></td>
                              <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm text-right" style="width: 70px;" name="NettWeight[]" value="<?php echo number_format($x->NettWeight, 2, '.', ''); ?>"></td>
                              <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm text-right" style="width: 100px;" name="GrossWeight[]" value="<?php echo number_format($x->GrossWeight, 2, '.', ''); ?>"></td>
                              <!-- <td hidden nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 140px;" name="Mainpo1[]" value="<?php echo $x->mainpo; ?>" readonly></td> -->

                              <td hidden nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm text-right" name="Comission[]" value="<?php echo number_format($x->comission, 2, '.', ''); ?>" onkeypress="return isNumber(event)" onkeyup="calculate()"></td>
                              <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm text-right" style="width: 100px;" name="Invoice[]" value="<?php echo number_format($x->invoiceprice, 2, '.', ''); ?>" readonly></td>
                              <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm text-right" style="width: 100px;" name="Total[]" value="<?php echo number_format($x->total, 2, '.', ''); ?>" readonly></td>
                              <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control" name="Mainpo[]" value="<?php echo $x->mainpo; ?>" readonly></td>
                              <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control" name="docno_gr[]" value="<?php echo $x->docno_gr; ?>" readonly></td>
                              <td hidden><input type="text" class="form-control input-sm" name="per1000[]" value="<?php echo $x->per1000; ?>"></td>
                            </tr>
                          <?php
                          }
                          ?>
                        </tbody>
                      </table>
                    </div>

                    <hr>

                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group" style="margin-bottom:1px;">
                          <label class="col-md-3 label-sm">Ship Via</label>
                          <div class="col-md-9">
                            <input type="text" class="form-control input-sm" name="via" value="<?php echo $via; ?>">
                          </div>
                        </div>
                        <div class="form-group" style="margin-bottom:1px;">
                          <label class="col-md-3 label-sm">Remark</label>
                          <div class="col-md-9">
                            <textarea rows="3" class="form-control autosizeme" name="remark"><?php echo $remark; ?></textarea>
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
                          <label class="col-md-6 col-md-push-1 label-sm">Freight</label>
                          <div class="col-md-5 col-md-push-1">
                            <input class="form-control input-sm text-right" name="freight" value="<?php echo number_format($freight, 2, '.', ''); ?>" id="freight" onkeyup="calculate()">
                          </div>
                        </div>
                        <div class="form-group" style="margin-bottom:1px;">
                          <label class="col-md-4 col-md-push-1 label-sm" id="ini">Include Tax

                            <input type="checkbox" name="include" id="cekgst" onclick="calculate()" <?php if ($include == '1') {
                                                                                                      echo 'checked';
                                                                                                    } ?>>
                          </label>
                          </label>
                          <div class="col-md-4 col-md-push-1">
                            <div class="input-group">
                              <input class="form-control input-sm text-right" readonly="" name="tax" value="<?php echo number_format($tax, 0, '.', ''); ?>" id="tax" onkeyup="calculate()">
                              <span class="input-group-addon">
                                %
                              </span>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <input class="form-control col-md- input-sm" type="text" id="taxprice" readonly="" name="taxprice" value="<?php echo number_format($taxprice, 4, '.', ''); ?>" onkeyup="calculate()">
                          </div>
                        </div>

                        <div class="form-group" style="margin-bottom:1px;">
                          <label class="col-md-6 col-md-push-1 label-sm">Total Payment Due</label>
                          <div class="col-md-5 col-md-push-1">
                            <input class="form-control input-sm text-right" name="totaldue" value="<?php echo number_format($totaldue, 4, '.', ''); ?>" id="totaldue" readonly>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="form-actions">
                    <div class="col-md-6">
                      <a type="button" class="col-md-2 btn btn-default" href="<?php echo site_url('purchasing_so'); ?>">Add</a>
                      <button type="submit" class="col-md-2 btn btn-primary" id="btn-update">Update</button>
                    </div>
                    <div class="col-md-6">
                      <button type="button" class="col-md-2  btn  btn-warning" onclick="fnDialogINV()">Find</button>
                      <a type="button" class="col-md-3  btn btn-info" href="<?php echo site_url('purchasing_so/proforma_invoice_print?sono=' . $sono); ?>" target="_blank">Profroma Invoice</a>
                      <a type="button" class="col-md-3  btn btn-success" href="<?php echo site_url('purchasing_so/sales_order_print?sono=' . $sono); ?>" target="_blank">Sales Order</a>
                      <a type="button" class="col-md-3  btn btn-primary" href="<?php echo site_url('purchasing_so/print_report_pl?sono=' . $sono); ?>" target="_blank">Packing List</a>
                      <!--<a type="button" class="col-md-3 col-md-offset-10 btn btn-info" href="<?php // echo site_url('purchasing_so/sales_order_print/'.str_replace("/", ".slash",$sono));
                                                                                                ?>" target="_blank">Print</a>-->
                    </div>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="portlet light">
                    <div class="portlet body">
                      <div class="form-group" style="margin-bottom:1px;">
                        <label class="col-md-4 label-sm">SO No</label>
                        <div class="col-md-8">
                          <input class="form-control input-sm" name="sono" value="<?php echo $sono; ?>" readonly>
                        </div>
                      </div>
                      <div class="form-group" style="margin-bottom:1px;">
                        <label class="col-md-4 label-sm">Ship Date</label>
                        <div class="col-md-8">
                          <input name="shipdate" class="form-control input-sm date date-picker" data-date="02-12-2012" data-date-format="dd-mm-yyyy" value="<?php echo $shipdate; ?>" required>
                        </div>
                      </div>
                      <div class="form-group" style="margin-bottom:1px;">
                        <label class="col-md-4 label-sm">Term</label>
                        <div class="col-md-8">
                          <textarea rows="3" class="form-control" name="term" style="resize: none;height: 167px;"><?php echo $term; ?></textarea>
                        </div>
                      </div>
                      <div class="form-group" style="margin-bottom:1px;">
                        <label class="col-md-4 label-sm">Term Days</label>
                        <div class="col-md-8">
                          <input class="form-control input-sm" name="day" id="days" value="<?php echo $termdays; ?>" onkeypress="return isNumber(event)" onkeyup="adddue()">
                        </div>
                      </div>
                      <!--                                            <div class="form-group" style="margin-bottom:1px;">
                                                <label class="col-md-4 label-sm">From</label>
                                                <div class="col-md-8">
                                                    <textarea rows="3" class="form-control" name="from" style="resize: none;height: 167px;"><?php // echo $from; 
                                                                                                                                            ?></textarea>
                                                </div>
                                            </div>
                                            <div class="form-group" style="margin-bottom:1px;">
                                                <label class="col-md-4 label-sm">To</label>
                                                <div class="col-md-8">
                                                    <textarea rows="3" class="form-control" name="to" style="resize: none;height: 167px;"><?php // echo $to; 
                                                                                                                                          ?></textarea>
                                                </div>
                                            </div>-->

                    </div>
                  </div>
                </div>

              </div>
            </form>
          </div>
        </div>
        <div id="formdialogPO"></div>
        <div id="formdialogINV"></div>
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
                                        <th>Main PO</th>\n\
                                        <th>Doc Date</th>\n\
                                        <th>Customer Company</th>\n\
                                        <th>Item ID</th>\n\
                                        <th>Item Name</th>\n\
                                        <th>UOM</th>\n\
                                        <th>Qnty</th>\n\
                                        <th>Unit Price</th>\n\
                                        <th>Currency</th>\n\
                                        <th>Tax Code</th>\n\
                                        <th>NPBB No</th>\n\
                                        <th>PO No</th>\n\
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
                                        <th nowrap>SO No</th>\n\
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
      title: "List Proforma Invoice",
      height: 650,
      width: 1200

    });
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
        var baris = $('#tblList tr').length;
        $('table[id="tblList"]').append('<tr onclick="deleterow(this)">\n\
                        <td><button class="btn btn-sm btn-danger" type="button" ><i class="fa fa-trash" ></i></button></td>\n\
                            <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm text-right" style="width: 50px;" name="SeqNo[]"  value="' + baris + '"></td>\n\
                            <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 150px;" name="ItemID[]" value="' + getText(document.getElementById('tbl-po').rows[i].cells[4]) + '" readonly></td>\n\
                            <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 250px;" name="ItemName[]" value="' + htmlSpecialChars(getText(document.getElementById('tbl-po').rows[i].cells[5])) + '" readonly></td>\n\
                            <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 60px;" name="UOM[]" value="' + getText(document.getElementById('tbl-po').rows[i].cells[7]) + '" readonly></td>\n\
                            <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm text-right" style="width: 80px;" name="Qty[]" value="' + getText(document.getElementById('tbl-po').rows[i].cells[9]) + '" data-max="' + getText(document.getElementById('tbl-po').rows[i].cells[9]) + '"   onkeypress="return isNumber(event)" onkeyup="calculate(); CheckMaxValue(this);"></td>\n\
                            <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm text-right" style="width: 80px;" name="Quantity[]" readonly></td>\n\
                            <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm text-right" style="width: 100px;" name="UnitPrice[]" value="' + getText(document.getElementById('tbl-po').rows[i].cells[10]) + '" onkeyup="calculate()"></td>\n\
                            <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm text-right" style="width: 100px;" name="NettWeight[]" value="0.0" ></td>\n\
                            <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm text-right" style="width: 100px;" name="GrossWeight[]" value="0.0" ></td>\n\
                            <td  hidden nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 70px;" name="TaxCode[]" value="' + getText(document.getElementById('tbl-po').rows[i].cells[12]) + '" readonly></td>\n\\n\
                            <td hidden nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm text-right"  name="Comission[]" value="' + getText(document.getElementById('tbl-po').rows[i].cells[17]) + '" onkeypress="return isNumber(event)" onkeyup="calculate()"></td>\n\
                            <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm text-right" style="width: 100px;" name="Invoice[]" value="0" readonly></td>\n\
                            <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm text-right" style="width: 100px;" name="Total[]" value="0" readonly></td>\n\
                            \n\
                           <td  nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 100px;" name="Mainpo[]" value="' + getText(document.getElementById('tbl-po').rows[i].cells[1]) + '" readonly></td>\n\
                            <td  nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 100px;" name="docno_gr[]" value="' + getText(document.getElementById('tbl-po').rows[i].cells[2]) + '" readonly></td>\n\
                            <td hidden><input type="text" class="form-control input-sm" name="per1000[]" value="' + getText(document.getElementById('tbl-po').rows[i].cells[16]) + '"></td>\n\
                    </tr>');
        var cur = getText(document.getElementById('tbl-po').rows[i].cells[11]);
      }
      i++;
    }

    $("#formdialogPO").dialog("close");

    document.getElementById("cur").value = cur;
    Rate();
    calculate();
    //        mainpo();
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

  function filterpo() {
    filterporeplace();
    //        filtertbl();
  }

  function filterporeplace() {
    $cust = document.getElementById("cust").value;
    $findpo = document.getElementById("findpo").value;

    $.ajax({
      // url: "<?php echo base_url(); ?>purchasing_so/sales_order_po?cust=" + $cust + "&po=" + $findpo + "",
      url: "<?php echo base_url(); ?>purchasing_so/sales_order_gr?",
      success: function(response) {
        $("#tblpo").html(response);
      },
      dataType: "html"
    });

    return false;
  }

  function CheckMaxValue(obj) {
    var value = obj.value.replace(/,/g, '');
    var maxVal = obj.getAttribute('data-max').replace(/,/g, '');
    //alert('value:'+value+' - - max:'+max);
    if (parseFloat(maxVal) > 0) {
      if (parseFloat(value) > parseFloat(maxVal)) {
        bootbox.alert("Value should not be more than " + maxVal);
        $(obj).val(addCommas(parseFloat(maxVal).toFixed(2)));

        calculate();
      } else if (parseFloat(value) < 0) {
        bootbox.alert("Value should not be more than 0");
        $(obj).val(addCommas(parseFloat(maxVal).toFixed(2)));

        calculate();
      }
    } else {
      if (parseFloat(value) < parseFloat(maxVal)) {
        bootbox.alert("Value should not be more than " + maxVal);
        $(obj).val(addCommas(parseFloat(maxVal).toFixed(2)));

        calculate();
      } else if (parseFloat(value) > 0) {
        bootbox.alert("Value should not be more than 0");
        $(obj).val(addCommas(parseFloat(maxVal).toFixed(2)));

        calculate();
      }
    }
  }
  // function filterporeplace() {
  //     $cust = document.getElementById("cust").value;
  //     $findpo = document.getElementById("findpo").value;

  //     $.ajax({
  //         url: "<?php echo base_url(); ?>purchasing_so/sales_order_po?cust=" + $cust + "&po=" + $findpo + "",
  //         success: function(response) {
  //             $("#tblpo").html(response);
  //         },
  //         dataType: "html"
  //     });

  //     return false;
  // }

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
        text = text + '   ' + getText(document.getElementById('tblList').rows[i].cells[12]);
      } else {
        text = getText(document.getElementById('tblList').rows[i].cells[12]);
      }
      i++;
    }

    document.getElementById("mainpo").value = text;
  }

  function filterinv() {
    var findinv = document.getElementById("findinv").value;

    findinv = findinv.split(" ").join("_");
    $findinv = findinv.split("/").join(".slash");

    $.ajax({
      url: "<?php echo base_url(); ?>purchasing_so/sales_order_inv?inv=" + $findinv + "",
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
    var dis = document.getElementById('discount').value / 100;
    var total = document.getElementById('totalbefore').value;
    var grantotal = total * dis;
    document.getElementById('totaldis').value = grantotal.toFixed(2);
  }

  function discwith() {
    var dis = document.getElementById('discount').value / 100;
    var total = document.getElementById('totalbefore').value;
    var grantotal = total * dis;
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
    var tax = document.getElementById('tax').value;
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
    if ($cek) {
      var tax = parseFloat(document.getElementById('tax').value);
      tax = 8;
      document.getElementById('tax').value = tax;
      freightTax = ((total - totaldis) + freight) / 100;
    } else {
      var tax = parseFloat(document.getElementById('tax').value);
      tax = 0;
      document.getElementById('tax').value = tax;
      freightTax = 0;
    }

    var tax7 = tax * freightTax;
    document.getElementById('taxprice').value = tax7.toFixed(4);
    var grandtotal = (total - totaldis) + freight + tax7;
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

  function cekDtl() {
    var ID_arr = document.getElementsByName("ItemID[]");
    var ID_length = ID_arr.length;


    if (ID_length > 0) {
      $('#btn-update').attr('disabled', false);
    } else {
      $('#btn-update').attr('disabled', true);
    }
  }

  function Rate() {
    $cur = document.getElementById("cur").value;
    $docdate = document.getElementById("docdate").value;

    $.ajax({
      url: "<?php echo base_url(); ?>purchasing_so/sales_order_rate?cur=" + $cur + "&date=" + $docdate + "",
      success: function(response) {
        $("#rate").html(response);
        Termdate()
      },
      dataType: "html"
    });

    Rate_notfound($cur, $docdate);

    return false;
  }

  function Rate_notfound(cur, docdate) {

    $.ajax({
      url: "<?php echo base_url(); ?>purchasing_so/sales_order_rate2?cur=" + cur + "&date=" + docdate + "",
      success: function(response) {
        $("#rate2").html(response);
        Termdate()
      },
      dataType: "html"
    });
  }

  function modal_delete(data) {
    $.ajax({
      url: "<?php echo base_url(); ?>purchasing_so/sales_order_modal_delete?delete=" + data + "",
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