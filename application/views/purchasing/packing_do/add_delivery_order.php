<script>
  $(document).ready(function() {
    $('#btn-save').attr('disabled', true);
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
          <div class="portlet-title">
            <div class="caption">
              <i class="fa fa-navicon theme-font"></i>
              <span class="caption-subject theme-font bold">Delivery Order</span>
            </div>
            <!--                        <div class="tools">
                            <a href="javascript:;" class="collapse"></a>
                            <a href="javascript:;" class="fullscreen"></a>
                        </div>-->
          </div>
          <div class="portlet-body">
            <form action="<?php echo site_url('Packing_do/delivery_oder_save/add'); ?>" method="post" class="form-horizontal" role="form">
              <div class="row">
                <div class="col-md-12">
                  <div class="form-body">
                    <div class="row">
                      <div class="col-md-6">
                        <!--<div class="form-group" style="margin-bottom:1px;">-->
                        <!--<label class="col-md-4 label-sm">Doc No</label>-->
                        <!--<div class="col-md-4">-->
                        <input type="hidden" class="form-control input-sm" name="docno">
                        <!--                                                        </div>
                                                    </div>-->
                        <div class="form-group" style="margin-bottom:1px;">
                          <label class="col-md-4 label-sm">Document Date</label>
                          <div class="col-md-4">
                            <input name="docdate" class="form-control input-sm date date-picker" data-date="02-12-2012" data-date-format="dd-mm-yyyy" value="<?php echo date("d-m-Y"); ?>" required>
                          </div>
                        </div>
                        <div class="form-group" style="margin-bottom:1px;">
                          <label class="col-md-4 label-sm">Delivery Date</label>
                          <div class="col-md-4">
                            <input name="duedate" class="form-control input-sm date date-picker" data-date="02-12-2012" data-date-format="dd-mm-yyyy" value="<?php echo date("d-m-Y"); ?>" required>
                          </div>
                        </div>
                      </div>
                    </div>

                    <hr>

                    <div class="table-scrollable">
                      <table class="table table-bordered" id="tblList">
                        <thead>
                          <tr>
                            <th><button class="btn btn-sm btn-primary" type="button" onclick="fnDialogPO()" id="btnpo"><i class="fa fa-arrow-down"></i></button></th>
                            <th>Item ID</th>
                            <th>Item Name</th>
                            <th>Qty Order</th>
                            <th>Qty Whs</th>
                            <th>Qty</th>
                            <th>UOM</th>
                            <th>Main PO</th>
                            <th>NPBB NO</th>
                            <th>Vendor</th>
                            <th>Customer</th>
                          </tr>
                        </thead>
                        <tbody id="tblList_1">
                        </tbody>
                      </table>
                    </div>
                  </div>

                  <div class="form-actions">
                    <div class="col-md-6">
                      <button type="submit" class="col-md-2 btn btn-primary" id="btn-save">Save</button>
                      <a type="button" class="col-md-2 btn btn-default" href="<?php echo site_url('purchasing_gr'); ?>">Cancel</a>
                    </div>
                    <div class="col-md-6">
                      <button type="button" class="col-md-2 col-md-offset-10 btn btn-warning" onclick="fnDialogGR()">Find</button>
                    </div>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
        <div id="formdialogPO"></div>
        <div id="formdialogSupp"></div>
        <div id="formdialogGR"></div>
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
                                        <th>Ship Date</th>\n\
                                        <th>Item ID</th>\n\
                                        <th>Item Name</th>\n\
                                        <th>Qty Order</th>\n\
                                        <th>Qty Whs</th>\n\
                                        <th>UOM</th>\n\
                                        <th>Price</th>\n\
                                        <th>NPBB No</th>\n\
                                        <th>Vendor</th>\n\
                                        <th>Customer</th>\n\
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

  function fnDialogGR() {
    $("#formdialogGR").html(" <div class='portlet-body'>\n\
                        <div class='col-md-12'>\n\
                            <div class='form-group'>\n\
                                 <label class='col-md-1 label-sm'>Find</label>\n\
                                 <div class='col-md-7'>\n\
                                       <input class='form-control input-sm' id='finddo'>\n\
                                 </div>\n\
                                 <button type='button' class='col-md-1 btn blue' onclick='filterdo()'>Search</button>\n\
                            </div>\n\
                        </div>\n\
                        <br><hr>\n\
                        <div class='table-scrollable' style='overflow: auto; height:490px;'>\n\
                            <table id='tbl-gr' class='table table-bordered'>\n\
                                <thead>\n\
                                    <tr>\n\
                                        <th>Action</th>\n\
                                        <th nowrap>Doc Date</th>\n\
                                        <th nowrap>Delivery Date</th>\n\
                                        <th nowrap>Main PO</th>\n\
                                        <th nowrap>Item ID</th>\n\
                                        <th nowrap>Item Name</th>\n\
                                        <th nowrap>Qty Whs</th>\n\
                                        <th nowrap>Qty Out</th>\n\
                                        <th nowrap>Vendor Company</th>\n\
                                        <th nowrap>Contact Person</th>\n\
                                        <th nowrap>Customer Company</th>\n\
                                        <th nowrap>Created By</th>\n\
                                        <th nowrap>Created Date</th>\n\
                                        <th nowrap>LastUpdated By</th>\n\
                                        <th nowrap>LastUpdated Date</th>\n\
                                    </tr>\n\
                                </thead>\n\
                                <tbody id='tbldo'>\n\
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
                                        <td></td>\n\
                                    </tr>\n\
                                </tbody>\n\
                            </table>\n\
                        </div>\n\
                </div>");

    // Define the Dialog and its properties.
    $("#formdialogGR").dialog({
      resizable: false,
      modal: true,
      title: "List Delivery Order",
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
      //             calculate();
      cekDtl();
    }
  }

  function close_status(mainpo) {
    if (confirm("Are you sure Close PO number " + mainpo + "?") == true) {
      filterpoclose(mainpo);
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
    //        var x = document.getElementById("tbl-npbb").rows.length;
    var chk_arr = document.getElementsByName("chk[]");
    var chk_length = chk_arr.length;

    i = 1;
    for (k = 0; k < chk_length; k++) {
      if (chk_arr[k].checked == true) {
        $('table[id="tblList"]').append('<tr onclick="deleterow(this)">\n\
                        <td><button class="btn btn-sm btn-danger" type="button" ><i class="fa fa-trash" ></i></button></td>\n\
                            <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 150px;" name="ItemID[]" value="' + getText(document.getElementById('tbl-po').rows[i].cells[4]) + '" readonly></td>\n\
                            <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 250px;" name="ItemName[]" value="' + htmlSpecialChars(getText(document.getElementById('tbl-po').rows[i].cells[5])) + '" readonly></td>\n\
                            <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm text-right" style="width: 80px;" name="QtyPO[]" value="' + getText(document.getElementById('tbl-po').rows[i].cells[6]) + '" readonly><input type="hidden" class="form-control input-sm" style="width: 150px;" name="docno_gr[]" value="' + getText(document.getElementById('tbl-po').rows[i].cells[7]) + '" readonly></td>\n\
                           <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm text-right" style="width: 80px;" name="QtyWhs[]" value="' + getText(document.getElementById('tbl-po').rows[i].cells[8]) + '" readonly></td>\n\
                            <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm text-right" style="width: 100px;" name="Qty[]" value="' + getText(document.getElementById('tbl-po').rows[i].cells[9]) + '" onkeypress="return isNumber(event)"></td>\n\
                            <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 60px;" name="UOM[]" value="' + getText(document.getElementById('tbl-po').rows[i].cells[10]) + '" readonly></td>\n\
                            <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 120px;" name="MainPO[]" value="' + getText(document.getElementById('tbl-po').rows[i].cells[1]) + '" readonly></td>\n\
                            <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 140px;" name="NPBB[]" value="' + getText(document.getElementById('tbl-po').rows[i].cells[12]) + '" readonly></td>\n\
                            <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 250px;" value="' + getText(document.getElementById('tbl-po').rows[i].cells[13]) + '" readonly></td>\n\
                            <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 250px;" value="' + getText(document.getElementById('tbl-po').rows[i].cells[14]) + '" readonly></td>\n\
                            <td hidden><input type="text" class="form-control input-sm" style="width: 250px;" name="custid[]" value="' + getText(document.getElementById('tbl-po').rows[i].cells[15]) + '"></td>\n\
                            <td hidden><input type="text" class="form-control input-sm" style="width: 250px;" name="sono[]" value="' + getText(document.getElementById('tbl-po').rows[i].cells[16]) + '"></td>\n\
                            <td hidden><input type="text" class="form-control input-sm" style="width: 250px;" name="ppbid[]" value="' + getText(document.getElementById('tbl-po').rows[i].cells[17]) + '"></td>\n\
                    </tr>');
      }
      i++;
    }

    $("#formdialogPO").dialog("close");

    //        calculate();
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
    // filtertbl();
  }

  function filterporeplace() {
    $findpo = document.getElementById("findpo").value;

    $.ajax({
      url: "<?php echo base_url(); ?>Packing_do/delivery_oder_gr?po=" + $findpo + "",
      success: function(response) {
        $("#tblpo").html(response);
      },
      dataType: "html"
    });

    return false;
  }

  function filterpoclose(mainpo) {
    $findpo = document.getElementById("findpo").value;

    $.ajax({
      url: "<?php echo base_url(); ?>purchasing_gr/good_receipt_po_close?po=" + mainpo + "&search=" + $findpo + "",
      success: function(response) {
        $("#tblpo").html(response);
      },
      dataType: "html"
    });

    return false;
  }

  function filterdo() {
    $finddo = document.getElementById("finddo").value;

    $.ajax({
      url: "<?php echo base_url(); ?>Packing_do/delivery_oder_do?do=" + $finddo + "",
      success: function(response) {
        $("#tbldo").html(response);
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

  function calculate() {
    $('#tblList tr').each(function() {
      var Nol = 0;
      var QtyPO = $(this).find("input[name='QtyPO[]']").val();
      var QtyWHS = $(this).find("input[name='QtyWhs[]']").val();
      var Qty = $(this).find("input[name='Qty[]']").val();
      var Total = QtyPO - QtyWHS;

      if (Qty > Total) {
        //                alert('Qty is bigger than Qty PO Order !');
        //                $(this).find("input[name='Qty[]']").val(Nol);
      } else {
        if (Qty > 0) {} else {
          //                    $(this).find("input[name='Qty[]']").val(Total.toFixed(2));
        }
      }
    });
  }

  function filtertbl() {
    function getText(el) {
      if (typeof el.textContent == 'string') return el.textContent;
      if (typeof el.innerText == 'string') return el.innerText;
    }

    alert("Please click OK for REFRESH DATA !");

    $('#tblList_1 tr').each(function() {

      $ItemID = $(this).find("input[name='ItemID[]']").val();
      $PO = $(this).find("input[name='MainPO[]']").val();

      var rows = document.getElementById('tbl-po').rows;

      for (var row = 1; row < rows.length; row++) {
        $POTemp = getText(document.getElementById('tbl-po').rows[row].cells[1]);
        $ItemIDTemp = getText(document.getElementById('tbl-po').rows[row].cells[3]);

        if ($PO == $POTemp && $ItemID == $ItemIDTemp) {
          document.getElementById("tbl-po").deleteRow(row);
        }
      }
    });
  }

  function cekDtl() {
    var ID_arr = document.getElementsByName("ItemID[]");
    var ID_length = ID_arr.length;

    if ((ID_length > 0)) {
      $('#btn-save').attr('disabled', false);
    } else {
      $('#btn-save').attr('disabled', true);
    }
  }

  function modal_delete(data) {
    $.ajax({
      url: "<?php echo base_url(); ?>Packing_do/delivery_order_modal_delete?delete=" + data + "",
      success: function(response) {
        $("#modal_delete").html(response);
      },
      dataType: "html"
    });

    return false;
  }
</script>

<script type="text/javascript">
  //    $(function(){
  //      $('#tbl-po').tablesorter(); 
  //    });
</script>