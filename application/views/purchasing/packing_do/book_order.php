<!-- <link href="<?php echo base_url(); ?>assets/admin/css/cloud-admin.css" rel="stylesheet" type="text/css"> -->
<script>
  $(document).ready(function() {
    $('#btn-save').attr('disabled', true);
    $('#btn-click').attr('disabled', true);
    $('#btn-searching').attr('disabled', false);
    $('#btn-find').attr('disabled', false);
    $('#btn-dp').attr('disabled', true);
    $('#btn-cont').attr('disabled', true);
  });
</script>
<div class="page-content">
  <div class="container-fluid">

    <div class="row">
      <div class="col-md-12">
        <form action="<?php echo site_url('Packing_do/save_book_ref/add'); ?>" method="post" class="form-horizontal" role="form">
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
                <span class="caption-subject theme-font bold">Booking Order</span>
              </div>
            </div>
            <div class="portlet-body">
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
                    </div>
                    <hr>
                    <div class="table-scrollable" id="pcs_getpo">
                      <table class="table table-bordered" id="tblList">
                        <thead>
                          <tr>
                            <th rowspan="3"><button class="btn btn-sm btn-primary" type="button" onclick="fnDialogPO()" id="btn-click"><i class="fa fa-arrow-down"></i></button></button></th>
                            </th>
                            <th rowspan="3">Seq No</th>
                            <th rowspan="3">Supplier</th>
                            <th rowspan="3">Address</th>
                            <th rowspan="3">Date Required</th>
                            <th rowspan="3">Time Required</th>
                            <th colspan="5">Container Required Description</th>
                            <th rowspan="3">Remarks</th>
                          </tr>
                          <tr>
                            <th rowspan="2">Main PO</th>
                            <th colspan="3">Qty</th>
                            <th rowspan="2">Type of Cargoes</th>
                          </tr>
                          <tr>
                            <th>20'</th>
                            <th>40'</th>
                            <th>40 HC</th>
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
                          <label class="col-md-3 label-sm">Barge</label>
                          <div class="col-md-9">
                            <input type="text" class="form-control input-sm" name="barge">
                          </div>
                        </div>
                        <div class="form-group" style="margin-bottom:1px;">
                          <label class="col-md-3 label-sm">Voyage</label>
                          <div class="col-md-9">
                            <input type="text" class="form-control input-sm" name="voyage">
                          </div>
                        </div>
                        <div class="form-group" style="margin-bottom:1px;">
                          <label class="col-md-3 label-sm">Shipment Date</label>
                          <div class="col-md-9">
                            <input name="date" class="form-control input-sm date date-picker" data-date="02-12-2012" data-date-format="dd-mm-yyyy">
                          </div>
                        </div>
                      </div>
                      <div class="col-md-offset-1 col-md-5">
                        <div class="form-group" style="margin-bottom:1px;">
                          <label class="col-md-3 label-sm">ETD</label>
                          <div class="col-md-9">
                            <input name="etd" class="form-control input-sm date date-picker" data-date="02-12-2012" data-date-format="dd-mm-yyyy">
                          </div>
                        </div>
                        <div class="form-group" style="margin-bottom:1px;">
                          <label class="col-md-3 label-sm">Ammend Copy</label>
                          <div class="col-md-9">
                            <input type="text" class="form-control input-sm" name="ammend" value="">
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
                        <label class="col-md-4 label-sm">Book Reff No</label>
                        <div class="col-md-8">
                          <input class="form-control input-sm" name="bookref_no" readonly>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

              </div>
            </div>
          </div>
          <div id="formdialogPO"></div>
          <div id="formdialogCust"></div>
          <div id="formdialogINV"></div>
          <div id="modal_delete" class="modal fade bs-modal-lg" role="dialog" tabindex="-1" data-backdrop="static" data-keyboard="false" aria-hidden="true"></div>
        </form>
      </div>
    </div>
  </div>
</div>

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

  function filtercust() {
    $findcust = document.getElementById("findcust").value;

    $.ajax({
      url: "<?php echo base_url(); ?>purchasing_so/sales_order_cust?cust=" + $findcust + "",
      success: function(response) {
        $("#tblcust").html(response);
      },
      dataType: "html"
    });

    return false;
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
                                        <input class='form-control input-sm' id='findpo_dtl'>\n\
                                 </div>\n\
                                 <button type='button' class='col-md-1 btn blue' onclick='filterpo_dtl()'>Search</button>\n\
                            </div>\n\
                        </div>\n\
                        <br><hr>\n\
                        <div class='table-scrollable' style='overflow: auto; height:400px;'>\n\
                            <table id='tbl-po_dtl' class='table table-bordered'>\n\
                                <thead>\n\
                                    <tr>\n\
                                        <th>Action</th>\n\
                                        <th nowrap>Main PO</th>\n\
                                        <th nowrap>Vendor Company</th>\n\
                                        <th nowrap>Contact Person</th>\n\
                                        <th nowrap>Vendor Address</th>\n\
                                        <th nowrap>Customer Company</th>\n\
                                        <th nowrap>Created By</th>\n\
                                        <th nowrap>Created Date</th>\n\
                                        <th nowrap>LastUpdated By</th>\n\
                                        <th nowrap>LastUpdated Date</th>\n\
                                    </tr>\n\
                                </thead>\n\
                                <tbody id='tblpo_dtl'>\n\
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
                                        <th nowrap>Book Ref No</th>\n\
                                        <th nowrap>Cust</th>\n\
                                        <th nowrap>ETD</th>\n\
                                        <th nowrap>Barge</th>\n\
                                        <th nowrap>Voyage</th>\n\
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
    } else {
      $('#btn-click').attr('disabled', true);
    }
  }

  function cekDtl() {
    var ID_arr = document.getElementsByName("txtmainpo[]");
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
                            <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm text-right"  name="SeqNo[]" value="0" style="width: 60px;"></td>\n\
                            <td nowrap onclick="event.stopPropagation();return false;"><textarea readonly rows="3" class="form-control autosizeme" style="width: 300px;">' + getText(document.getElementById('tbl-po_dtl').rows[i].cells[2]) + '</textarea></td>\n\
                            <td nowrap onclick="event.stopPropagation();return false;"><textarea rows="3" name="vendor_address[]" class="form-control autosizeme" style="width: 300px;">' + getText(document.getElementById('tbl-po_dtl').rows[i].cells[4]) + '</textarea></td>\n\
                            <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm date date-picker" data-date="02-12-2012" data-date-format="dd-mm-yyyy" name="date_rqd[]" value=""></td>\n\
                            <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm text-right"  name="time_rqd[]" value=""></td>\n\
                            <td nowrap onclick="event.stopPropagation();return false;"><input type="text" id="txtmainpo" class="form-control" name="txtmainpo[]" value="' + getText(document.getElementById('tbl-po_dtl').rows[i].cells[1]) + '" style="width: 150px;"></td>\n\
                            <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control" name="txtsum_20[]" onkeypress="return isNumber(event)" value="" style="width: 100px;"></td>\n\
                            <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control" name="txtsum_40[]" onkeypress="return isNumber(event)" value="" style="width: 100px;"></td>\n\
                            <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control" name="txtsum_40hc[]" onkeypress="return isNumber(event)" value="" style="width: 100px;"></td>\n\
                            <td nowrap onclick="event.stopPropagation();return false;"><textarea name="txtdesc[]" rows="2" class="form-control autosizeme" style="width:150px;"></textarea></td>\n\
                            <td nowrap onclick="event.stopPropagation();return false;"><textarea name="txtremark[]" rows="2" class="form-control autosizeme" style="width:200px;">' + getText(document.getElementById('tbl-po_dtl').rows[i].cells[3]) + '\r\n' + getText(document.getElementById('tbl-po_dtl').rows[i].cells[10]) + '</textarea></td>\n\
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

  function filterpo_dtl() {
    filterpodtlreplace();

  }

  function filterpodtlreplace() {
    $cust = document.getElementById("cust").value;
    $findpo = document.getElementById("findpo_dtl").value;

    $.ajax({
      url: "<?php echo base_url(); ?>Packing_do/add_container_po_dtl?cust=" + $cust + "&po=" + $findpo + "",
      success: function(response) {
        $("#tblpo_dtl").html(response);
      },
      dataType: "html"
    });

    return false;

  }


  function filterinv() {
    $findinv = document.getElementById("findinv").value;

    $.ajax({
      url: "<?php echo base_url(); ?>Packing_do/book_order_all?inv=" + $findinv + "",
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

<!-- <script type="text/javascript">
    function modal_delete(data){
        $.ajax({
        url: "<?php echo base_url(); ?>Packing_do/remove_loading_report?delete=" + data + "",
                success: function (response) {
                    $("#modal_delete").html(response);
                },
                dataType: "html"
        });
        return false;
    }
</script> -->