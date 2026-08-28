<!-- <link href="<?php echo base_url(); ?>assets/admin/css/cloud-admin.css" rel="stylesheet" type="text/css"> -->
<script>
  $(document).ready(function() {
    $('#btn-save').attr('disabled', true);
    $('#btn-click').attr('disabled', true);
    $('#btn-searching').attr('disabled', false);
    $('#btn-find').attr('disabled', false);
    $('#btn-dp').attr('disabled', true);
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
          <div id="rate2" style="color: #5a7391"></div>
          <div class="portlet-title">
            <div class="caption">
              <i class="fa fa-navicon theme-font"></i>
              <span class="caption-subject theme-font bold">Loading Report</span>
            </div>
          </div>
          <div class="portlet-body">
            <form action="<?php echo site_url('Packing_do/save_lr/add'); ?>" method="post" class="form-horizontal" role="form">
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
                      </div>

                      <div class="col-md-6">
                        <div class="form-group" style="margin-bottom:1px;">
                          <label class="col-md-5 col-md-push-3 label-sm">Document Date</label>
                          <div class="col-md-4 col-md-push-3">
                            <input type="text" name="docdate" id="docdate" class="form-control input-sm date date-picker" data-date="02-12-2012" data-date-format="dd-mm-yyyy" value="<?php echo date("d-m-Y"); ?>" required>
                          </div>
                        </div>
                      </div>
                    </div>

                    <hr>

                    <div class="table-scrollable">
                      <table class="table table-bordered" id="tblList">
                        <thead>
                          <tr>
                            <th><button class="btn btn-sm btn-primary" type="button" onclick="fnDialogPO()" id="btn-click"><i class="fa fa-arrow-down"></i></button></button><button class="btn btn-sm btn-primary" type="button" onclick="addrow()" id="btn-dp">DP</button></th>
                            </th>
                            <th>Seq No</th>
                            <th>Item ID</th>
                            <th>Item Name</th>
                            <th>UOM</th>
                            <th>Qty</th>
                            <th>NPBB NO</th>
                            <th>Nett Weight</th>
                            <th>Gross Weight</th>
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
                            <input type="text" class="form-control input-sm" readonly="" name="via">
                          </div>
                        </div>
                        <div class="form-group" style="margin-bottom:1px;">
                          <label onclick="filterremark()" style="color: #0081c2;" class="col-md-3 label-sm">Remark</label>
                          <div class="col-md-9">
                            <textarea rows="3" class="form-control autosizeme" name="remark"></textarea>
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
                      <button type="submit" class="col-md-2 btn btn-primary" id="btn-save">Save</button>
                      <button type="reset" class="col-md-2 btn btn-default" onclick="$('#tblList_1 tr').remove();">Cancel</button>
                    </div>
                    <div class="col-md-6">
                      <button id="btn-find" type="button" class="col-md-2 col-md-offset-11 btn btn-warning" onclick="fnDialogINV()">Find</button>
                    </div>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="portlet light">
                    <div class="portlet body">
                      <div class="form-group" style="margin-bottom:1px;">
                        <label class="col-md-4 label-sm">LR No</label>
                        <div class="col-md-8">
                          <input class="form-control input-sm" name="lrno" readonly>
                        </div>
                      </div>
                      <div class="form-group" style="margin-bottom:1px;">
                        <label class="col-md-4 label-sm">Ship Date</label>
                        <div class="col-md-8">
                          <input name="shipdate" class="form-control input-sm date date-picker" data-date="02-12-2012" data-date-format="dd-mm-yyyy" readonly="">
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
                                        <th>Customer Company</th>\n\
                                        <th>Item ID</th>\n\
                                        <th>Item Name</th>\n\
                                        <th>UOM</th>\n\
                                        <th>Qnty</th>\n\
                                        <th>NPBB No</th>\n\
                                         <th>Nett Weight</th>\n\
                                        <th>Gross Weight</th>\n\
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
                                        <th nowrap>LR No</th>\n\
                                        <th nowrap>Doc Date</th>\n\
                                        <th nowrap>Ship Date</th>\n\
                                        <th nowrap>Customer Company</th>\n\
                                        <th nowrap>Contact Person</th>\n\
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
                                    </tr>\n\
                                </tbody>\n\
                            </table>\n\
                        </div>\n\
                </div>");

    // Define the Dialog and its properties.
    $("#formdialogINV").dialog({
      resizable: false,
      modal: true,
      title: "List Loading Report",
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

    $("#formdialogCust").dialog("close");
    cekhdr();
    cekDtl();
  }

  function deleterow(x) {
    $r = x.rowIndex;

    if (confirm("Are you sure remove this row?") == true) {
      document.getElementById("tblList").deleteRow($r);
    }
  }

  function cekhdr() {
    $('#tblList_1 tr').remove();

    $cust = document.getElementById("cust").value;

    if ($cust != "") {
      $('#btn-click').attr('disabled', false);
      $('#btn-dp').attr('disabled', false);
    } else {
      $('#btn-click').attr('disabled', true);
      $('#btn-dp').attr('disabled', true);
    }
  }

  function cekDtl() {
    var ID_arr = document.getElementsByName("txtItemId[]");
    var ID_length = ID_arr.length;

    $cust = document.getElementById("cust").value;

    if ((ID_length > 0) && ($cust != "")) {
      $('#btn-save').attr('disabled', false);
    } else {
      $('#btn-save').attr('disabled', true);
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
                            <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 150px;" name="txtItemId[]" value="' + getText(document.getElementById('tbl-po').rows[i].cells[3]) + '"><input hidden name="id_lr[]" value="-"></td>\n\
                            <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 250px;" name="txtItemName[]" value="' + htmlSpecialChars(getText(document.getElementById('tbl-po').rows[i].cells[4])) + '" readonly></td>\n\
                            <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 60px;" name="txtItemUom[]" value="' + getText(document.getElementById('tbl-po').rows[i].cells[5]) + '" readonly></td>\n\
                            <td nowrap onclick="event.stopPropagation();return false;"><input readonly type="text" class="form-control input-sm text-right" style="width: 80px;" name="txtItemQty[]" value="' + getText(document.getElementById('tbl-po').rows[i].cells[6]) + '" onkeypress="return isNumber(event)" onkeyup="calculate()"></td>\n\
                            <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 140px;" name="txtItemNPBB[]" value="' + getText(document.getElementById('tbl-po').rows[i].cells[7]) + '" readonly></td>\n\\n\
                            <td hidden><input type="text" class="form-control" name="txtmainpo[]" value="' + getText(document.getElementById('tbl-po').rows[i].cells[1]) + '">' + getText(document.getElementById('tbl-po').rows[i].cells[1]) + '</td>\n\
                            <td hidden><input type="text" class="form-control" name="txtdocno[]" value=""><input type="text" class="form-control" name="pl_no" value="' + getText(document.getElementById('tbl-po').rows[i].cells[10]) + '"></td>\n\
                            <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm text-right" style="width: 100px;" name="txtItemNW[]" value="' + getText(document.getElementById('tbl-po').rows[i].cells[9]) + '"></td>\n\<input type="hidden" class="form-control input-sm text-right" style="width: 100px;" name="txttype" value="LR"></td>\n\
                            <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm text-right" style="width: 100px;" name="txtItemGW[]" value="' + getText(document.getElementById('tbl-po').rows[i].cells[8]) + '"></td>\n\</td>\n\
                            <td hidden><input type="text" class="form-control input-sm" style="width: 250px;" name="ppbid[]" value="' + getText(document.getElementById('tbl-po').rows[i].cells[11]) + '"></td>\n\
                    </tr>');
      }
      i++;
    }

    $("#formdialogPO").dialog("close");
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

  function filtercust() {
    $findcust = document.getElementById("findcust").value;

    $.ajax({
      url: "<?php echo base_url(); ?>Packing_do/sales_order_cust?cust=" + $findcust + "",
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
      url: "<?php echo base_url(); ?>Packing_do/loading_report_po?cust=" + $cust + "&po=" + $findpo + "",
      success: function(response) {
        $("#tblpo").html(response);
      },
      dataType: "html"
    });

    return false;
  }

  function filterinv() {
    $findinv = document.getElementById("findinv").value;

    $.ajax({
      url: "<?php echo base_url(); ?>Packing_do/loading_report_inv?inv=" + $findinv + "",
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
</script>

<script type="text/javascript">
  function modal_delete(data) {
    $.ajax({
      url: "<?php echo base_url(); ?>Packing_do/remove_loading_report?delete=" + data + "",
      success: function(response) {
        $("#modal_delete").html(response);
      },
      dataType: "html"
    });
    return false;
  }
</script>
<script type="text/javascript">
  function addrow() {
    var table = document.getElementById('tblList_1');
    var rowCount = table.rows.length;
    var row = table.insertRow(rowCount);
    row.innerHTML = '<tr>' +
      '<td><button class="btn btn-sm btn-danger" type="button" onclick="deleterow_1(this)"><i class="fa fa-trash" ></i></button></td>' +
      '<td nowrap><input type="text" class="form-control input-sm text-right" style="width: 50px;" name="SeqNo[]" value="0"></td></td>' +
      '<td nowrap><input type="text" class="form-control input-sm" readonly style="width: 150px;" name="txtItemId[]" value="" ><input hidden name="id_lr[]" value="-"></td>' +
      '<td><textarea rows="3" class="form-control autosizeme" name="txtItemName[]" style="width: 300px;"></textarea></td>' +
      '<td nowrap><input type="text" class="form-control input-sm" style="width: 60px;" name="txtItemUom[]" value="" ></td>' +
      '<td nowrap><input type="text" class="form-control input-sm" style="width: 80px;" name="txtItemQty[]" value="" ></td>' +
      '<td nowrap><input type="text" class="form-control input-sm" style="width: 140px;" name="txtItemNPBB[]" value="" ><input type="hidden" class="form-control input-sm" name="txtmainpo[]" value="" ><input type="hidden" class="form-control input-sm" name="txtdocno[]" value="" ></td>' +
      '<td nowrap><input type="text" class="form-control input-sm" style="width: 100px;" name="txtItemNW[]" value="0.00" ><input type="hidden" class="form-control input-sm text-right" style="width: 100px;" name="txttype" value="DP"></td>' +
      '<td nowrap><input type="text" class="form-control input-sm" style="width: 100px;" name="txtItemGW[]" value="0.00" ></td>'

      +
      '</tr>';
    cekDtl();
  }
</script>
<script type="text/javascript">
  function filterremark() {
    function getText(el) {
      if (typeof el.textContent == 'string') return el.textContent;
      if (typeof el.innerText == 'string') return el.innerText;
    }
    $taxc = getText(document.getElementById('tbl-po').rows[1].cells[1]);

    $.ajax({
      url: "<?php echo base_url(); ?>Packing_do/loading_report_remark?remark=" + $taxc + "",
      success: function(response) {
        $("#remarks").html(response);
      },
      dataType: "html"
    });
    return false;
  }
</script>