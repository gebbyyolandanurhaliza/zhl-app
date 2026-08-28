<?php
foreach ($so as $r) {
  $cust        = $r->custid;
  $name        = $r->custcompany;
  $contact     = $r->custcontact;
  $custref     = $r->custref;
  $currency    = $r->currency;
  $rate        = $r->rate;
  $status      = $r->status;
  $docno       = substr($r->sono, 6);
  $postdate    = date("d-m-Y",  strtotime($r->postdate));
  $duedate     = date("d-m-Y",  strtotime($r->duedate));
  $docdate     = date("d-m-Y",  strtotime($r->docdate));
  $via         = $r->via;
  $remark      = $r->remarks;
  $totalbefore = $r->maintotal;
  $Totdiscount = $r->discount;
  $discount    = ($Totdiscount / $totalbefore) * 100;
  $freight     = $r->freight;
  $tax         = $r->taxcode;
  $taxprice    = $r->tax;
  $totaldue    = $r->totaldue;
  $sono        = $r->sono;
  $from        = $r->sofrom;
  $to          = $r->soto;
  $shipdate    = date("d-m-Y",  strtotime($r->shipdate));
  $term        = $r->term;
  $termdays    = $r->termdays;
  $country_id  = $r->country_id;
}
?>
<script>
  $(document).ready(function() {
    if (<?php echo $status; ?> != '1') {
      $('#btn-po').attr('disabled', false);
      $('#btn-update').attr('disabled', false);
    }
  });

  function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode === 8 || charCode === 9 || charCode === 37 || charCode === 39 || charCode === 46 || (charCode > 47 && charCode < 58)) {
      return true;
    }
    return false;
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
              <span class="caption-subject theme-font bold">Packing List</span>
            </div>
          </div>
          <div class="portlet-body">
            <form action="<?php echo site_url('purchasing_pl/simpan_pl/add'); ?>" method="post" class="form-horizontal" role="form">
              <div class="row">
                <div class="col-md-9">
                  <div class="form-body">
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group" style="margin-bottom:1px;">
                          <label class="col-md-4 label-sm">Customer</label>
                          <div class="col-md-4">
                            <input type="text" class="form-control input-sm" id="cust" name="cust" value="<?php echo $cust; ?>" readonly>
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
                      </div>

                      <div class="col-md-6">
                        <div class="form-group " style="margin-bottom:1px;">
                          <label class="col-md-5 col-md-push-3 label-sm">Posting Date</label>
                          <div class="col-md-4 col-md-push-3">
                            <input disabled="" text="text" name="postdate" class="form-control input-sm date date-picker" data-date="02-12-2012" data-date-format="dd-mm-yyyy" value="<?php echo $postdate; ?>" required>
                          </div>
                        </div>
                        <div class="form-group" style="margin-bottom:1px;">
                          <label class="col-md-5 col-md-push-3 label-sm">Due Date</label>
                          <div class="col-md-4 col-md-push-3">
                            <input disabled="" type="text" name="duedate" id="duedate" onchange="Rate()" class="form-control input-sm date date-picker" data-date="02-12-2012" data-date-format="dd-mm-yyyy" value="<?php echo $duedate; ?>" required>
                          </div>
                        </div>
                        <div class="form-group" style="margin-bottom:1px;">
                          <label class="col-md-5 col-md-push-3 label-sm">Document Date</label>
                          <div class="col-md-4 col-md-push-3">
                            <input readonly="" type="text" name="docdate" id="docdate" onchange="Rate();" class="form-control input-sm date date-picker" data-date="02-12-2012" data-date-format="dd-mm-yyyy" value="<?php echo $docdate; ?>" required>
                          </div>
                        </div>
                        <div class="form-group" style="margin-bottom:1px;">
                          <label class="col-md-5 col-md-push-3 label-sm">Status</label>
                          <div class="col-md-4 col-md-push-3">
                            <select disabled="" class="form-control" data-placeholder="Status" name="status">
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
                            <th></th>
                            <th>Seq No</th>
                            <th>Item ID</th>
                            <th>Item Name</th>
                            <th>UOM</th>
                            <th>Quantity</th>
                            <th hidden="">NPBB NO</th>
                            <th hidden>PO NO</th>
                            <th>Nett Weight</th>
                            <th>Gross Weight</th>
                          </tr>
                        </thead>
                        <tbody id="tblList_1">
                          <?php foreach ($so as $x) { ?>
                            <tr onclick="deleterow(this)">
                              <td><button class="btn btn-sm btn-danger" type="button"><i class="fa fa-trash"></i></button></td>
                              <td onclick="event.stopPropagation();return false;"><input readonly="" type="text" class="form-control input-sm text-right" style="width: 50px;" name="SeqNo[]" value="<?php echo $x->nourut; ?>">
                                <input type="hidden" class="txt" name="txtIdgr[]" value="<?php echo $x->sono; ?>">
                              </td>
                              <td onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 150px;" name="txtItemId[]" value="<?php echo $x->itemid; ?>" readonly></td>
                              <td onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 250px;" name="txtItemName[]" value="<?php echo htmlspecialchars($x->itemname, ENT_QUOTES); ?>" readonly></td>
                              <td onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 60px;" value="<?php echo $x->uomname; ?>" readonly></td>
                              <td onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm text-right" style="width: 80px;" name="txtItemQty[]" value="<?php echo number_format($x->qty, 2, '.', ''); ?>" readonly></td>
                              <td hidden="" onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 140px;" name="txtItemNPBB[]" value="<?php echo $x->npbbno; ?>" readonly></td>
                              <td hidden nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 140px;" name="txtmainpo[]" value="<?php echo $x->pono; ?>" readonly></td>
                              <td onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm text-right" style="width: 80px;" name="txtItemNW[]" value="<?php echo number_format($x->NettWeight, 2, '.', ''); ?>" onkeypress="return isNumber(event)" required=""></td>
                              <td onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm text-right" style="width: 80px;" name="txtItemGW[]" value="<?php echo number_format($x->GrossWeight, 2, '.', ''); ?>" onkeypress="return isNumber(event)" required=""></td>
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
                            <textarea readonly rows="3" class="form-control autosizeme" name="remark"><?php echo $remark; ?></textarea>
                          </div>
                        </div>
                        <div class="form-group" style="margin-bottom:1px;">
                          <label class="col-md-3 label-sm">Country Of Origin</label>
                          <div class="col-md-9">
                            <textarea readonly rows="1" class="form-control autosizeme" name="remark_country"><?php if ($country != '') {
                                                                                                                echo $country->country_name;
                                                                                                              } ?></textarea>
                          </div>
                        </div>
                        <div class="form-group" style="margin-bottom:1px;">
                          <label class="col-md-3 label-sm">Packing</label>
                          <div class="col-md-9">
                            <textarea rows="8" class="form-control autosizeme" name="packing"></textarea>
                          </div>
                        </div>
                        <div class="form-group" style="margin-bottom:1px;">
                          <label class="col-md-3 label-sm">Total Packing</label>
                          <div class="col-md-9">
                            <input type="text" class="form-control input-sm" name="ttlpack" value="" id="ttlpack">
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="form-actions">
                    <div class="col-md-6">
                      <button type="submit" class="col-md-2 btn btn-primary" id="btn-update">Save</button>
                    </div>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="portlet light">
                    <div class="portlet body">
                      <div class="form-group" style="margin-bottom:1px;">
                        <label class="col-md-4 label-sm">PI No</label>
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
                        <label class="col-md-4 label-sm">Ship Term</label>
                        <div class="col-md-8">
                          <textarea readonly rows="3" class="form-control" name="term" style="resize: none;height: 167px;"><?php echo $term; ?></textarea>
                        </div>
                      </div>
                      <div class="form-group" style="margin-bottom:1px;">
                        <label class="col-md-4 label-sm">Term Days</label>
                        <div class="col-md-8">
                          <input readonly class="form-control input-sm" name="day" id="days" value="<?php echo $termdays; ?>" onkeypress="return isNumber(event)" onkeyup="adddue()">
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
        <div id="formdialogINV"></div>
        <div id="modal_delete" class="modal fade bs-modal-lg" role="dialog" tabindex="-1" data-backdrop="static" data-keyboard="false" aria-hidden="true"></div>
      </div>
    </div>
  </div>
</div>

<script>
  function deleterow(x) {
    $r = x.rowIndex;

    if (confirm("Are you sure remove this row?") == true) {
      document.getElementById("tblList").deleteRow($r);
      calculate();
      cekDtl();
    }
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
      title: "List Sales Order",
      height: 650,
      width: 1200

    });
  }
</script>

<script type="text/javascript">
  function modal_delete(data) {
    $.ajax({
      url: "<?php echo base_url(); ?>purchasing_pl/remove_packing_list?delete=" + data + "",
      success: function(response) {
        $("#modal_delete").html(response);
      },
      dataType: "html"
    });
    return false;
  }
</script>