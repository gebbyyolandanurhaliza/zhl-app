<?php
foreach ($book as $r) {
  $cust =  $r->custid;
  $name =  $r->customercompany;
  $contact =  $r->contactperson;
  $bookref_no =  $r->bookref_no;
  $etd =  date("d-m-Y",  strtotime($r->etd));
  $date =  date("d-m-Y",  strtotime($r->date));
  $barge =  $r->barge;
  $voyage =  $r->voyage;
  $ammend =  $r->ammend;
  $tgl =  date("Y-m-d",  strtotime($r->date));
}
?>
<!-- <link href="<?php echo base_url(); ?>assets/admin/css/cloud-admin.css" rel="stylesheet" type="text/css"> -->
<script>
  $(document).ready(function() {
    $('#btn-save').attr('disabled', false);
    $('#btn-click').attr('disabled', false);
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
        <form action="<?php echo site_url('Packing_do/save_book_ref_ship'); ?>" method="post" class="form-horizontal" role="form">
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
                    </div>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="portlet light">
                    <div class="portlet body">
                      <div class="form-group" style="margin-bottom:1px;">
                        <label class="col-md-4 label-sm">Book Reff No</label>
                        <div class="col-md-8">
                          <input class="form-control input-sm" name="bookref_no" value="<?php echo $bookref_no; ?>" readonly>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

              </div>
              <div class="row">
                <div class="col-md-12">
                  <div class="form-body">
                    <hr>
                    <div class="table-scrollable" id="pcs_getpo">
                      <table class="table table-bordered" id="tblList">
                        <thead>
                          <tr>
                            <th rowspan="3">Seq No</th>
                            <th rowspan="6">Supplier</th>
                            <th rowspan="6">Address</th>
                            <th rowspan="6">Date Required</th>
                            <th rowspan="6">Time Required</th>
                            <th colspan="6">Container Required Description</th>
                            <th rowspan="2">Remarks</th>
                          </tr>
                          <tr>
                            <th rowspan="2">Main PO</th>
                            <th colspan="3">Qty</th>
                            <th rowspan="2">Booking Reff</th>
                            <th rowspan="2">Type of Cargoes</th>
                          </tr>
                          <tr>
                            <th>20'</th>
                            <th>40'</th>
                            <th>40 HC</th>
                          </tr>

                        </thead>
                        <tbody id="tblList_1">
                          <?php foreach ($book as $x) { ?>
                            <tr>
                              <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm text-right" name="SeqNo[]" value="<?php echo $x->nourut; ?>" style="width: 50px;"></td>
                              <td nowrap onclick="event.stopPropagation();return false;"><textarea rows="3" class="form-control autosizeme" style="width: 250px;" readonly><?php echo $x->vendorcompany; ?></textarea></td>
                              <td nowrap onclick="event.stopPropagation();return false;"><textarea rows="3" class="form-control autosizeme" style="width: 300px;" readonly><?php echo $x->vendoraddress; ?></textarea></td>
                              <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm date date-picker" data-date="02-12-2012" data-date-format="dd-mm-yyyy" name="date_rqd[]" value="<?php echo $x->date_reqd; ?>"></td>
                              <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm text-right" name="time_rqd[]" value="<?php echo $x->time_reqd; ?>"></td>
                              <td nowrap onclick="event.stopPropagation();return false;"><input type="text" id="txtmainpo" class="form-control" readonly value="<?php echo $x->mainpo; ?>" style="width: 150px;"></td>
                              <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control" name="txtsum_20[]" onkeypress="return isNumber(event)" value="<?php echo $x->sum_20_reqd; ?>" style="width: 100px;"></td>
                              <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control" name="txtsum_40[]" onkeypress="return isNumber(event)" value="<?php echo $x->sum_40_reqd; ?>" style="width: 100px;"></td>
                              <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control" name="txtsum_40hc[]" onkeypress="return isNumber(event)" value="<?php echo $x->sum_40hc_reqd; ?>" style="width: 100px;"></td>
                              <td nowrap onclick="event.stopPropagation();return false;">
                                <select class="form-control select2me" style="width: 170px;" name="cont[]" multiple>

                                  <?php

                                  $_hsl = $this->M_packing_do->get_bookref_shp3($cust, $tgl, $x->mainpo);

                                  if (!empty($_hsl)) {
                                    foreach ($_hsl as $r) {
                                      if ($r->selected == 1) {
                                        echo "<option value='$r->booking_reff/$r->stuffing/$r->Mainpo' selected> $r->booking_reff </option>";
                                      } else {
                                        echo "<option value='$r->booking_reff/$r->stuffing/$r->Mainpo'> $r->booking_reff </option>";
                                      }
                                    }
                                  } ?>

                                  <!-- // foreach($cont as $r){
                                                            //     if($r->selected == 1 && $r->Mainpo == $x->mainpo){
                                                            //         echo "<option value='$r->booking_reff/$r->stuffing/$r->Mainpo' selected> $r->booking_reff </option>";
                                                            //     }else{
                                                            //         echo "<option value=''></option>";
                                                            //         echo "<option value='$r->booking_reff/$r->stuffing/$x->mainpo'> $r->booking_reff </option>";
                                                            //     }
                                                            // } -->

                                </select>
                              </td>
                              <td nowrap onclick="event.stopPropagation();return false;"><textarea name="txtdesc[]" rows="3" class="form-control autosizeme" style="width:150px;"><?php echo $x->description; ?></textarea></td>
                              <td nowrap onclick="event.stopPropagation();return false;"><textarea name="txtremark[]" rows="3" class="form-control autosizeme" style="width:200px;"><?php echo $x->remarks; ?></textarea></td>
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
                          <label class="col-md-3 label-sm">Barge</label>
                          <div class="col-md-9">
                            <input type="text" class="form-control input-sm" name="barge" value="<?php echo $barge; ?>">
                          </div>
                        </div>
                        <div class="form-group" style="margin-bottom:1px;">
                          <label class="col-md-3 label-sm">Voyage</label>
                          <div class="col-md-9">
                            <input type="text" class="form-control input-sm" name="voyage" value="<?php echo $voyage; ?>">
                          </div>
                        </div>
                        <div class="form-group" style="margin-bottom:1px;">
                          <label class="col-md-3 label-sm">Shipment Date</label>
                          <div class="col-md-9">
                            <input name="date" class="form-control input-sm date date-picker" data-date="02-12-2012" data-date-format="dd-mm-yyyy" value="<?php echo $date; ?>">
                          </div>
                        </div>
                      </div>
                      <div class="col-md-offset-1 col-md-5">
                        <div class="form-group" style="margin-bottom:1px;">
                          <label class="col-md-3 label-sm">ETD</label>
                          <div class="col-md-9">
                            <input name="etd" class="form-control input-sm date date-picker" data-date="02-12-2012" data-date-format="dd-mm-yyyy" value="<?php echo $etd; ?>">
                          </div>
                        </div>
                        <div class="form-group" style="margin-bottom:1px;">
                          <label class="col-md-3 label-sm">Ammend Copy</label>
                          <div class="col-md-9">
                            <input type="text" class="form-control input-sm" name="ammend" value="<?php echo $ammend; ?>">
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
                      <div class="col-md-6"></div>
                      <div>
                        <button type="button" class="col-md-2 col-md-push-2  btn btn-warning" onclick="fnDialogINV()">Find</button>
                        <a type="button" class="col-md-2 col-md-push-2 btn btn-info" href="<?php echo site_url('Packing_do/book_order_shipping_excel?bookref_no=' . $bookref_no . '&cust=' . $cust); ?>" target="_blank">Print</a>
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
                            <td nowrap onclick="event.stopPropagation();return false;"><textarea rows="3" class="form-control autosizeme" style="width: 300px;">' + getText(document.getElementById('tbl-po_dtl').rows[i].cells[2]) + '</textarea></td>\n\
                            <td nowrap onclick="event.stopPropagation();return false;"><textarea rows="3" class="form-control autosizeme" style="width: 300px;">' + getText(document.getElementById('tbl-po_dtl').rows[i].cells[4]) + '</textarea></td>\n\
                            <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm date date-picker" data-date="02-12-2012" data-date-format="dd-mm-yyyy" name="date_rqd[]" value=""></td>\n\
                            <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm text-right"  name="time_rqd[]" value=""></td>\n\
                            <td nowrap onclick="event.stopPropagation();return false;"><input type="text" id="txtmainpo" class="form-control" name="txtmainpo[]" value="' + getText(document.getElementById('tbl-po_dtl').rows[i].cells[1]) + '" style="width: 150px;"></td>\n\
                            <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control" name="txtsum" onkeypress="return isNumber(event)" value="" style="width: 100px;"></td>\n\
                            <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control" name="txtdesc" value="" style="width: 100px;"></td>\n\
                            <td nowrap onclick="event.stopPropagation();return false;"><textarea name="txtremark" rows="3" class="form-control autosizeme" style="width:200px;"></textarea></td>\n\
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