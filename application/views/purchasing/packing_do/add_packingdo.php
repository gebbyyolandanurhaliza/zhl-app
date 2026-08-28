<script type="text/javascript">
  function get_gr() {
    $("#loading-spiner").show();
    $tipe = $('#tipe').val();

    if ($tipe == 'pl') {
      document.getElementById('find_pi').style.display = 'block';
      document.getElementById('find_po').style.display = 'none';
    } else {
      document.getElementById('find_pi').style.display = 'none';
      document.getElementById('find_po').style.display = 'block';
    }



  }
</script>
<?php
$tgl = date("d-m-Y");
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
          <div class="portlet-title">
            <div class="caption">
              <i class="fa fa-navicon theme-font"></i>
              <span class="caption-subject theme-font bold">Packing List / DO </span>
            </div>
          </div>
          <div class="portlet-body form">
            <form action="<?php echo site_url('Packing_do/simpan_do/add'); ?>" method="post" class="form-horizontal" role="form">
              <div class="row">
                <div class="col-md-12">
                  <div class="form-body">
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group" style="margin-bottom:1px;">
                          <label class="col-md-4 label-sm">Type</label>
                          <div class="col-md-4">
                            <select class="form-control tipe select2me" id="tipe" name="tipe" onchange="get_gr()">
                              <option value="">Select</option>
                              <option value="pl">Packing List</option>
                              <option value="do">D/O</option>
                              <option value="lr">Loading Report</option>
                            </select>
                          </div>
                        </div>

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
                          <label class="col-md-5 col-md-push-3 label-sm"">Shipment Date</label>
                                                    <div class=" col-md-4 col-md-push-3">
                            <input class="form-control input-sm date date-picker" name="shipdate" data-date="02-12-2012" data-date-format="dd-mm-yyyy" value="<?php echo $tgl; ?>" required onkeypress="return isNumber(event);" onkeydown="return validasi_enter(event)">
                        </div>
                      </div>
                      <div class="form-group" style="margin-bottom:1px;">
                        <label class="col-md-5 col-md-push-3 label-sm"">Document Date</label>
                                                    <div class=" col-md-4 col-md-push-3">
                          <input class="form-control input-sm date date-picker" name="docdate" data-date="02-12-2012" data-date-format="dd-mm-yyyy" value="<?php echo $tgl; ?>" required onkeypress="return isNumber(event);" onkeydown="return validasi_enter(event)">
                      </div>
                    </div>
                  </div>
                </div>
                <hr>
                <div class="table-scrollable">
                  <table class="table table-bordered" id="tblList">
                    <thead>
                      <tr>
                        <th>
                          <button style="display: none;" class="btn btn-sm btn-primary" id="find_po" type="button" onclick="fnDialogGR()" id="btn-click"><i class="fa fa-arrow-down"></i></button>
                          <button style="display: none;" class="btn btn-sm btn-primary" id="find_pi" type="button" onclick="fnDialogINV()" id="btn-click"><i class="fa fa-arrow-down"></i></button>
                        </th>
                        <th>Seq No</th>
                        <th>Item ID</th>
                        <th>Item Name</th>
                        <th>UOM</th>
                        <th>Qty</th>
                        <th>NPBB NO</th>
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
                      <label class="col-md-3 label-sm">Remark</label>
                      <div class="col-md-9">
                        <textarea readonly rows="3" class="form-control autosizeme" name="remarks" id="remarks"></textarea>
                      </div>
                    </div>
                    <div class="form-group" style="margin-bottom:1px;">
                      <label class="col-md-3 label-sm">Country Of Origin</label>
                      <div class="col-md-9">
                        <textarea readonly rows="1" class="form-control autosizeme" name="remark_country"></textarea>
                      </div>
                    </div>
                    <div class="form-group" style="margin-bottom:1px;">
                      <label class="col-md-3 label-sm">Ship Via</label>
                      <div class="col-md-9">
                        <input readonly="" type="text" class="form-control input-sm" name="via">
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
                  <button type="reset" class="col-md-2 btn btn-default" onclick="">Cancel</button>
                </div>
                <div class="col-md-6">
                  <button id="btn-find" type="button" class="col-md-2 col-md-offset-10 btn btn-warning" onclick="fnDialogPO()">Find</button>
                </div>
              </div>
          </div>
        </div>
        </form>
      </div>
    </div>
    <div id="formdialogPO"></div>
    <div id="formdialogGR"></div>
    <div id="formdialogCust"></div>
    <div id="formdialogINV"></div>
  </div>
</div>
</div>
</div>


<script type="text/javascript">
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
    $("#formdialogCust").dialog({
      resizable: false,
      modal: true,
      title: "List Customer",
      top: 5,
      height: 500,
      width: 880

    });
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

  function clickdbcust(x) {
    function getText(el) {
      if (typeof el.textContent == 'string') return el.textContent;
      if (typeof el.innerText == 'string') return el.innerText;
    }

    $r = x.rowIndex;
    document.getElementById('cust').value = getText(document.getElementById('tbl-cust').rows[$r].cells[0]);
    document.getElementById('name').value = getText(document.getElementById('tbl-cust').rows[$r].cells[1]);
    document.getElementById('contact').value = getText(document.getElementById('tbl-cust').rows[$r].cells[2]);
    document.getElementById('contact').value = getText(document.getElementById('tbl-cust').rows[$r].cells[2]);

    $("#formdialogCust").dialog("close");
    cekhdr();

  }

  function fnDialogGR() {
    $("#formdialogGR").html(" <div class='portlet-body'>\n\
                        <div class='col-md-12'>\n\
                            <div class='form-group'>\n\
                                 <label class='col-md-1 label-sm'>Find</label>\n\
                                 <div class='col-md-7'>\n\
                                        <input class='form-control input-sm' id='findgr'>\n\
                                 </div>\n\
                                 <button type='button' class='col-md-1 btn blue' onclick='filterso()'>Search</button>\n\
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
                                        <th>NPBB No</th>\n\
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
    $("#formdialogGR").dialog({
      resizable: false,
      modal: true,
      title: "List PO",
      height: 650,
      width: 1200

    });
  }

  function filterso() {
    filterporeplace();
    //        filtertbl();
  }

  function filterporeplace() {
    $cust = document.getElementById("cust").value;
    $findpo = document.getElementById("findgr").value;

    $.ajax({
      url: "<?php echo base_url(); ?>Packing_do/tampil_gr?cust=" + $cust + "&po=" + $findpo + "",
      success: function(response) {
        $("#tblpo").html(response);
      },
      dataType: "html"
    });

    return false;
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
                            <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm text-right" readonly style="width: 80px;" name="txtItemQty[]" value="' + getText(document.getElementById('tbl-po').rows[i].cells[7]) + '" onkeypress="return isNumber(event)" onkeyup="calculate()"></td>\n\
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
                        <div class='table-scrollable' style='overflow: auto; height:490px;'>\n\
                            <table id='tbl-do' class='table table-bordered'>\n\
                                <thead>\n\
                                    <tr>\n\
                                        <th>Action</th>\n\
                                        <th nowrap>Type</th>\n\
                                        <th nowrap>Factory</th>\n\
                                        <th nowrap>Reff No</th>\n\
                                        <th nowrap>Ship Via</th>\n\
                                        <th nowrap>Shipment Date</th>\n\
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
                                    </tr>\n\
                                </tbody>\n\
                            </table>\n\
                        </div>\n\
                </div>");
    // Define the Dialog and its properties.
    $("#formdialogPO").dialog({
      resizable: false,
      modal: true,
      title: "List Packing List/ DO",
      height: 650,
      width: 1200

    });
  }

  function filterpo() {
    $findpo = document.getElementById("findpo").value;

    $.ajax({
      url: "<?php echo base_url(); ?>Packing_do/filter_do?po=" + $findpo + "",
      success: function(response) {
        $("#tbldo").html(response);
      },
      dataType: "html"
    });
    return false;
    exit;
  }

  function filterinv() {
    $findinv = document.getElementById("findinv").value;

    $.ajax({
      url: "<?php echo base_url(); ?>purchasing_so/sales_order_inv?inv=" + $findinv + "",
      success: function(response) {
        $("#tblinv").html(response);
      },
      dataType: "html"
    });

    return false;
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
                                        <th nowrap>Main PO</th>\n\
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
                                    </tr>\n\
                                </tbody>\n\
                            </table>\n\
                        </div>\n\
                </div>");

    // Define the Dialog and its properties.
    $("#formdialogINV").dialog({
      resizable: false,
      modal: true,
      title: "List Provorma Invoice",
      height: 650,
      width: 1200

    });
  }

  function filterinv() {
    $findinv = document.getElementById("findinv").value;

    $.ajax({
      url: "<?php echo base_url(); ?>Packing_do/sales_order_inv?inv=" + $findinv + "",
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