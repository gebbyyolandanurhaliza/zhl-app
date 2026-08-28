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
            <form action="<?php echo site_url('#'); ?>" method="post" class="form-horizontal" role="form">
              <div class="row">
                <div class="col-md-9">
                  <div class="form-body">
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group" style="margin-bottom:1px;">
                          <label class="col-md-4 label-sm">Customer</label>
                          <div class="col-md-4">
                            <input type="text" class="form-control input-sm" id="cust" name="cust" value="" readonly>
                          </div>
                        </div>
                        <div class="form-group" style="margin-bottom:1px;">
                          <label class="col-md-4 label-sm">Name</label>
                          <div class="col-md-5">
                            <input class="form-control input-sm" name="name" value="" readonly>
                          </div>
                        </div>
                        <div class="form-group " style="margin-bottom:1px;">
                          <label class="col-md-4 label-sm">Contact Person</label>
                          <div class="col-md-4">
                            <input class="form-control input-sm" name="contact" value="" readonly>
                          </div>
                        </div>
                      </div>

                      <div class="col-md-6">
                        <div class="form-group " style="margin-bottom:1px;">
                          <label class="col-md-5 col-md-push-3 label-sm">Posting Date</label>
                          <div class="col-md-4 col-md-push-3">
                            <input disabled="" text="text" name="postdate" class="form-control input-sm date date-picker" data-date="02-12-2012" data-date-format="dd-mm-yyyy" value="" required>
                          </div>
                        </div>
                        <div class="form-group" style="margin-bottom:1px;">
                          <label class="col-md-5 col-md-push-3 label-sm">Due Date</label>
                          <div class="col-md-4 col-md-push-3">
                            <input disabled="" type="text" name="duedate" id="duedate" onchange="Rate()" class="form-control input-sm date date-picker" data-date="02-12-2012" data-date-format="dd-mm-yyyy" value="" required>
                          </div>
                        </div>
                        <div class="form-group" style="margin-bottom:1px;">
                          <label class="col-md-5 col-md-push-3 label-sm">Document Date</label>
                          <div class="col-md-4 col-md-push-3">
                            <input readonly="" type="text" name="docdate" id="docdate" onchange="Rate();" class="form-control input-sm date date-picker" data-date="02-12-2012" data-date-format="dd-mm-yyyy" value="" required>
                          </div>
                        </div>
                        <div class="form-group" style="margin-bottom:1px;">
                          <label class="col-md-5 col-md-push-3 label-sm">Status</label>
                          <div class="col-md-4 col-md-push-3">
                            <select disabled="" class="form-control" data-placeholder="Status" name="status">
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
                            <th>
                              <button class="btn btn-sm btn-primary" id="find_pi" type="button" onclick="fnDialogINV()" id="btn-click"><i class="fa fa-arrow-down"></i></button>
                            </th>
                            <th>Seq No</th>
                            <th>Item ID</th>
                            <th>Item Name</th>
                            <th>UOM</th>
                            <th>UOM Alias</th>
                            <th>Qty</th>
                            <th>Qty Alias</th>
                            <th hidden>NPBB NO</th>
                            <th>Gross Weight</th>
                            <th>Nett Weight</th>
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
                            <input readonly type="text" class="form-control input-sm" name="via" value="">
                          </div>
                        </div>
                        <div class="form-group" style="margin-bottom:1px;">
                          <label class="col-md-3 label-sm">Remark</label>
                          <div class="col-md-9">
                            <textarea readonly rows="3" class="form-control autosizeme" name="remark"></textarea>
                          </div>
                        </div>
                        <div class="form-group" style="margin-bottom:1px;">
                          <label class="col-md-3 label-sm">Country Of Origin</label>
                          <div class="col-md-9">
                            <textarea readonly rows="1" class="form-control autosizeme" name="remark_country"></textarea>
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
                    <div class="col-md-6">
                      <div class="col-md-8"></div>
                      <div>
                        <button type="button" class="col-md-2 col-md-push-2  btn btn-warning" onclick="fnDialogPL()">Find</button>
                      </div>

                    </div>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="portlet light">
                    <div class="portlet body">
                      <div class="form-group" style="margin-bottom:1px;">
                        <label class="col-md-4 label-sm">PI No</label>
                        <div class="col-md-8">
                          <input class="form-control input-sm" name="sono" value="" readonly>
                        </div>
                      </div>
                      <div class="form-group" style="margin-bottom:1px;">
                        <label class="col-md-4 label-sm">Ship Date</label>
                        <div class="col-md-8">
                          <input readonly name="shipdate" class="form-control input-sm date date-picker" data-date="02-12-2012" data-date-format="dd-mm-yyyy" value="" required>
                        </div>
                      </div>
                      <div class="form-group" style="margin-bottom:1px;">
                        <label class="col-md-4 label-sm">Ship Term</label>
                        <div class="col-md-8">
                          <textarea readonly rows="3" class="form-control" name="term" style="resize: none;height: 167px;"></textarea>
                        </div>
                      </div>
                      <div class="form-group" style="margin-bottom:1px;">
                        <label class="col-md-4 label-sm">Term Days</label>
                        <div class="col-md-8">
                          <input readonly class="form-control input-sm" name="day" id="days" value="" onkeypress="return isNumber(event)" onkeyup="adddue()">
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
        <div id="formdialogPL"></div>
        <div id="modal_delete" class="modal fade bs-modal-lg" role="dialog" tabindex="-1" data-backdrop="static" data-keyboard="false" aria-hidden="true"></div>
      </div>
    </div>
  </div>
</div>

<script>
  $('form').submit(function(e) {
    var cust = $('#cust').val();
    if (cust == '') {
      alert("Field Still Empty !");
      e.preventDefault();
      return false;
    } else {
      return true;
    }

  });
</script>

<script type="text/javascript">
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
        $('table[id="tblList"]').append('<tr onclick="deleterow(this)">\n\
                        <td><button class="btn btn-sm btn-danger" type="button" ><i class="fa fa-trash" ></i></button></td>\n\
                        <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm text-right" style="width: 50px;" name="SeqNo[]" value="0"></td>\n\
                            <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 150px;" name="txtItemId[]" value="' + getText(document.getElementById('tbl-po').rows[i].cells[4]) + '" readonly></td>\n\
                            <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 250px;" name="txtItemName[]" value="' + htmlSpecialChars(getText(document.getElementById('tbl-po').rows[i].cells[5])) + '" readonly></td>\n\
                            <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 60px;" value="' + getText(document.getElementById('tbl-po').rows[i].cells[6]) + '" readonly></td>\n\
                            <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 60px;" name="UOM_Alias[]" value="' + getText(document.getElementById('tbl-po').rows[i].cells[6]) + '" readonly></td>\n\
                            <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm text-right" readonly style="width: 80px;" name="txtItemQty[]" value="' + getText(document.getElementById('tbl-po').rows[i].cells[7]) + '" onkeypress="return isNumber(event)" onkeyup="calculate()"></td>\n\
                            <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm text-right" readonly style="width: 80px;" name="txtItemQty_Alias[]" value="' + getText(document.getElementById('tbl-po').rows[i].cells[7]) + '" onkeypress="return isNumber(event)" onkeyup="calculate()"></td>\n\
                            <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 140px;" name="txtItemNPBB[]" value="' + getText(document.getElementById('tbl-po').rows[i].cells[8]) + '" readonly></td>\n\\n\
                            <td hidden><input type="text" class="form-control" name="txtmainpo[]" value="' + getText(document.getElementById('tbl-po').rows[i].cells[1]) + '">' + getText(document.getElementById('tbl-po').rows[i].cells[1]) + '</td>\n\
                            <td hidden><input type="text" class="form-control" name="txtIdgr[]" value="' + getText(document.getElementById('tbl-po').rows[i].cells[9]) + '"></td>\n\
                            <td hidden><input type="text" class="form-control" name="txtdocno[]" value="' + getText(document.getElementById('tbl-po').rows[i].cells[10]) + '"></td>\n\
                            <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm text-right" style="width: 100px;" name="txtItemGW[]" value="0"></td>\n\
                            <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm text-right" style="width: 100px;" name="txtItemNW[]" value="0"></td>\n\
                    </tr>');
      }
      i++;
    }

    $("#formdialogGR").dialog("close");
  }
</script>
<script type="text/javascript">
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
                                        <th hidden nowrap>Main PO</th>\n\
                                        <th nowrap>Total Due</th>\n\
                                        <th nowrap>Currency</th>\n\
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
      title: "Packing List",
      height: 650,
      width: 1200

    });
  }

  function filterinv() {
    $findinv = document.getElementById("findinv").value;

    $.ajax({
      url: "<?php echo base_url(); ?>Purchasing_pl/sales_order_inv?inv=" + $findinv + "",
      success: function(response) {
        $("#tblinv").html(response);
      },
      dataType: "html"
    });

    return false;
  }

  function htmlSpecialChars(text) {
    return text
      .replace(/&/g, "&amp;")
      .replace(/"/g, "&quot;")
      .replace(/'/g, "&#039;")
      .replace(/</g, "&lt")
      .replace(/>/g, "&gt");

  }
</script>
<script>
  function fnDialogPL() {
    $("#formdialogPL").html(" <div class='portlet-body'>\n\
                        <div class='col-md-12'>\n\
                            <div class='form-group'>\n\
                                 <label class='col-md-1 label-sm'>Find</label>\n\
                                 <div class='col-md-7'>\n\
                                       <input class='form-control input-sm' id='findinv'>\n\
                                 </div>\n\
                                 <button type='button' class='col-md-1 btn blue' onclick='filterpl()'>Search</button>\n\
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
                                <tbody id='tblpl'>\n\
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
    $("#formdialogPL").dialog({
      resizable: false,
      modal: true,
      title: "List Packing List",
      height: 650,
      width: 1200

    });
  }

  function filterpl() {
    $findinv = document.getElementById("findinv").value;

    $.ajax({
      url: "<?php echo base_url(); ?>Purchasing_pl/filter_pl?inv=" + $findinv + "",
      success: function(response) {
        $("#tblpl").html(response);
      },
      dataType: "html"
    });

    return false;
  }
</script>

<script type="text/javascript">
  function modal_delete(data) {
    $.ajax({
      url: "<?php echo base_url(); ?>Purchasing_pl/remove_packing_list?delete=" + data + "",
      success: function(response) {
        $("#modal_delete").html(response);
      },
      dataType: "html"
    });
    return false;
  }
</script>