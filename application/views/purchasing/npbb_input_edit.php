<?php
foreach ($npbb as $r) {
  $npbbno = $r->npbbno;
  $date = date("d-m-Y",  strtotime($r->transdate));
  $companyid = $r->companyid;
  $companyname = $r->companyfullname;
  $currency = $r->currencyid;
}
?>

<script>
  $(document).ready(function() {
    if (<?php echo $cek; ?> != '0') {
      $('#btn-npbb').attr('disabled', true);
      $('#btn-update').attr('disabled', true);
    }
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
              <span class="caption-subject theme-font bold">NPBB</span>
            </div>
            <!--                        <div class="tools">
                            <a href="javascript:;" class="collapse"></a>
                            <a href="javascript:;" class="fullscreen"></a>
                        </div>-->
          </div>
          <div class="portlet-body form">
            <form action="<?php echo site_url('purchasing_npbb/npbb_save/update'); ?>" method="post" class="form-horizontal" role="form">
              <div class="form-body">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group" style="margin-bottom:1px;">
                      <label class="col-md-3 label-sm">NPBB</label>
                      <div class="col-md-4">
                        <input type="text" class="form-control input-sm" name="npbb" id="npbb" value="<?php echo $npbbno; ?>" readonly>
                      </div>
                    </div>
                    <div class="form-group" style="margin-bottom:1px;">
                      <label class="col-md-3 label-sm">Date</label>
                      <div class="col-md-4">
                        <input class="form-control input-sm date date-picker" name="transdate" value="<?php echo $date; ?>" data-date="02-12-2012" data-date-format="dd-mm-yyyy" required>
                      </div>
                    </div>
                    <div class="form-group" style="margin-bottom:1px;">
                      <label class="col-md-3 label-sm">Factory</label>
                      <div class="col-md-6">
                        <select class="form-control select2me" data-placeholder="Company" name="company">
                          <option value="<?php echo $companyid; ?>"><?php echo $companyname; ?></option>
                          <?php
                          foreach ($customer as $r) {
                            if ($companyid != $r->customer_code) {
                              echo '<option value="' . $r->customer_code . '">' . $r->customer_company_name . '</option>';
                            }
                          }
                          ?>
                        </select>
                      </div>
                    </div>
                    <div class="form-group" style="margin-bottom:1px;">
                      <div class="col-md-4 col-md-offset-3">
                        <select class="form-control select2me" data-placeholder="Currency" name="cur">
                          <option value="<?php echo $currency; ?>"><?php echo $currency; ?></option>
                          <?php
                          foreach ($cur as $r) {
                            if ($currency != $r->currency_id) {
                              echo '<option value="' . $r->currency_id . '">' . $r->currency_id . '</option>';
                            }
                          }
                          ?>
                        </select>
                      </div>
                    </div>
                  </div>
                </div>

                <hr>

                <div class="table-responsive">
                  <table class="table table-bordered" id="tblList">
                    <thead>
                      <tr class="success">
                        <th width="10px"><button class="btn btn-sm btn-primary" type="button" onclick="fnDialogItem()" id="btn-npbb"><i class="fa fa-arrow-down"></i></button></th>
                        <th nowrap>Item ID</th>
                        <th nowrap>Item Name</th>
                        <th nowrap>Label PM Code</th>
                        <th nowrap>UOM</th>
                        <th nowrap>Qty</th>
                        <th nowrap>Price</th>
                        <th nowrap>New Price</th>
                      </tr>
                    </thead>
                    <tbody id="tblList_1">
                      <?php foreach ($npbb as $r) { ?>
                        <tr onclick="deleterow(this)">
                          <td><button class="btn btn-sm btn-danger" type="button"><i class="fa fa-trash"></i></button></td>
                          <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 200px;" name="ItemID[]" value="<?php echo $r->itemid; ?>" readonly></td>
                          <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 350px;" name="ItemName[]" value="<?php echo htmlspecialchars($r->itemname, ENT_QUOTES); ?>" readonly></td>
                          <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" name="PMCode[]" value="<?php echo $r->pmcode; ?>" readonly></td>
                          <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" name="UOM[]" value="<?php echo $r->uomname; ?>" readonly></td>
                          <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm text-right" name="Qty[]" value="<?php echo number_format($r->qnty, 2); ?>" onkeypress="return isNumber(event)"></td>
                          <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm text-right" name="UnitPrice[]" value="<?php echo number_format($r->unitprice, 2); ?>" readonly></td>
                          <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm text-right" name="NewUnitPrice[]" value="<?php echo number_format($r->newunitprice, 2); ?>" onkeypress="return isNumber(event)"></td>
                        </tr>
                      <?php } ?>
                    </tbody>
                  </table>
                </div>
              </div>

              <hr>

              <div class="form-actions">
                <div class="col-md-6">
                  <button type="submit" class="col-md-2 btn btn-primary" id="btn-update">Update</button>
                  <a type="button" class="col-md-2 btn btn-default" href="<?php echo site_url('purchasing_npbb/npbb'); ?>">Cancel</a>
                </div>
              </div>
            </form>
          </div>
        </div>
        <div id="formdialogItem"></div>
      </div>
    </div>
  </div>
</div>

<script>
  function fnDialogItem() {
    $("#formdialogItem").html(" <div class='portlet-body'>\n\
                        <div class='col-md-12'>\n\
                            <div class='form-group'>\n\
                                 <label class='col-md-1 label-sm'>Find</label>\n\
                                 <div class='col-md-7'>\n\
                                        <input class=form-control input-sm' id='finditem'>\n\
                                 </div>\n\
                                 <button type='button' class='col-md-1 btn blue' onclick='filteritem()'>Search</button>\n\
                            </div>\n\
                        </div>\n\
                        <br><hr>\n\
                        <div class='table-scrollable' style='overflow: auto; height:300px;'>\n\
                            <table id='tbl-item' class='table table-bordered'>\n\
                                <thead>\n\
                                    <tr class='success'>\n\
                                        <th>Item ID</th>\n\
                                        <th>Item Name</th>\n\
                                        <th>Label PM Code</th>\n\
                                        <th>UOM</th>\n\
                                        <th>Item Remark</th>\n\
                                    </tr>\n\
                                </thead>\n\
                                <tbody id='tblitem'>\n\
                                    <tr ondblclick='clickdbitem(this)'>\n\
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
    $("#formdialogItem").dialog({
      resizable: false,
      modal: true,
      title: "List Item",
      height: 650,
      width: 1200

    });
  }
</script>
<script>
  function clickdbitem(x) {
    function getText(el) {
      if (typeof el.textContent == 'string') return el.textContent;
      if (typeof el.innerText == 'string') return el.innerText;
    }

    $r = x.rowIndex;

    $('table[id="tblList"]').append('<tr onclick="deleterow(this)">\n\
                <td><button class="btn btn-sm btn-danger" type="button" ><i class="fa fa-trash" ></i></button></td>\n\
                    <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 200px;" name="ItemID[]" value="' + getText(document.getElementById('tbl-item').rows[$r].cells[0]) + '" readonly></td>\n\
                    <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 350px;" name="ItemName[]" value="' + getText(document.getElementById('tbl-item').rows[$r].cells[1]) + '" readonly></td>\n\
                    <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" name="PMCode[]" value="' + getText(document.getElementById('tbl-item').rows[$r].cells[2]) + '" readonly></td>\n\
                    <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" name="UOM[]" value="' + getText(document.getElementById('tbl-item').rows[$r].cells[3]) + '" readonly></td>\n\
                    <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm text-right" name="Qty[]" onkeypress="return isNumber(event)" required=""></td>\n\
                    <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm text-right" name="UnitPrice[]" onkeypress="return isNumber(event)" onkeyup="calculate()" required=""></td>\n\
                    <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm text-right" name="NewUnitPrice[]" onkeypress="return isNumber(event)" required=""></td>\n\
        </tr>');

    $("#formdialogItem").dialog("close");
    cekDtl();
  }

  function deleterow(x) {
    $r = x.rowIndex;

    if (confirm("Are you sure remove this row?") == true) {
      document.getElementById("tblList").deleteRow($r);
      cekDtl();
    }
  }

  function filteritem() {
    filteritemdtl();
    //            filtertbl();

  }

  function filteritemdtl() {

    $finditem = document.getElementById("finditem").value;

    $.ajax({
      url: "<?php echo base_url(); ?>purchasing_npbb/npbb_input_item/" + $finditem + "",
      success: function(response) {
        $("#tblitem").html(response);
      },
      dataType: "html"
    });

    return false;
  }

  function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode === 8 || charCode === 37 || charCode === 39 || charCode === 46 || (charCode > 47 && charCode < 58)) {
      return true;
    }
    return false;
  }

  function calculate() {
    $('#tblList tr').each(function() {
      var UnitPrice = $(this).find("input[name='UnitPrice[]']").val();
      $(this).find("input[name='NewUnitPrice[]']").val(UnitPrice);
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

      var rows = document.getElementById('tbl-item').rows;

      for (var row = 1; row < rows.length; row++) {
        $ItemIDTemp = getText(document.getElementById('tbl-item').rows[row].cells[0]);
        if ($ItemID == $ItemIDTemp) {
          document.getElementById("tbl-item").deleteRow(row);
        }

      }
    });
  }

  function cekDtl() {
    var ID_arr = document.getElementsByName("ItemID[]");
    var ID_length = ID_arr.length;

    $npbb = document.getElementById("npbb").value;

    if ((ID_length > 0) && ($npbb != "")) {
      $('#btn-update').attr('disabled', false);
    } else {
      $('#btn-update').attr('disabled', true);
    }
  }
</script>