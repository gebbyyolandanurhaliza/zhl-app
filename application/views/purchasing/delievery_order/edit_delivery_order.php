<?php
foreach ($gr as $r) {
  $docno =  $r->docno;
  $docdate = date("d-m-Y",  strtotime($r->docdate));
  $duedate =  date("d-m-Y",  strtotime($r->duedate));
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
            <div class="caption">
              <i class="fa fa-navicon theme-font"></i>
              <span class="caption-subject theme-font bold">Delivery Order</span>
            </div>
          </div>
          <div class="portlet-body">
            <form action="<?php echo site_url('Purchasing_do/delivery_oder_save/update'); ?>" method="post" class="form-horizontal" role="form">
              <div class="row">
                <div class="col-md-12">
                  <div class="form-body">
                    <div class="row">
                      <div class="col-md-6">
                        <input type="hidden" class="form-control input-sm" name="docno" value="<?php echo $docno; ?>" readonly>
                        <div class="form-group" style="margin-bottom:1px;">
                          <label class="col-md-4 label-sm">Document Date</label>
                          <div class="col-md-4">
                            <input name="docdate" class="form-control input-sm date date-picker" data-date="02-12-2012" data-date-format="dd-mm-yyyy" value="<?php echo $docdate; ?>" required>
                          </div>
                        </div>
                        <div class="form-group" style="margin-bottom:1px;">
                          <label class="col-md-4 label-sm">Delivery Date</label>
                          <div class="col-md-4">
                            <input name="duedate" class="form-control input-sm date date-picker" data-date="02-12-2012" data-date-format="dd-mm-yyyy" value="<?php echo $duedate; ?>" required>
                          </div>
                        </div>
                      </div>
                    </div>

                    <hr>

                    <div class="table-scrollable" style='overflow: auto; height:300px;'>
                      <table class="table table-bordered" id="tblList">
                        <thead>
                          <tr>
                            <th>#</th>
                            <th>Item ID</th>
                            <th>Item Name</th>
                            <th>Qty Order</th>
                            <th>Qty Whs</th>
                            <th>Last Qty Out</th>
                            <th>UOM</th>
                            <th>Main PO</th>
                            <th hidden="">NPBB NO</th>
                            <th>Vendor</th>
                            <th>Customer</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php $i = 1;
                          foreach ($gr as $x) { ?>
                            <tr onclick="deleterow(this)">
                              <td><?php echo $i; ?></td>
                              <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 150px;" name="ItemID[]" value="<?php echo $x->itemid; ?>" readonly></td>
                              <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 250px;" name="ItemName[]" value="<?php echo htmlspecialchars($x->itemname, ENT_QUOTES); ?>" readonly></td>
                              <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm text-right" style="width: 80px;" name="QtyPO[]" value="<?php echo number_format($x->qtypo, 3, '.', ''); ?>" readonly></td>
                              <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm text-right" style="width: 80px;" name="QtyWhs[]" value="<?php echo number_format($x->qtywhs, 3, '.', ''); ?>" readonly></td>
                              <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm text-right" style="width: 100px;" name="Qty[]" value="<?php echo number_format($x->qtyout, 3, '.', ''); ?>" onkeypress="return isNumber(event)" onkeyup="calculate()"></td>
                              <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 60px;" name="UOM[]" value="<?php echo $x->uomname; ?>" readonly></td>
                              <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 120px;" name="MainPO[]" value="<?php echo $x->mainpo; ?>" readonly></td>
                              <td hidden="" nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 140px;" name="NPBB[]" value="<?php echo $x->npbbno; ?>" readonly></td>
                              <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 250px;" value="<?php echo $x->vendorcompany; ?>" readonly></td>
                              <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 250px;" value="<?php echo $x->custcompanybyorder; ?>" readonly></td>
                              <td hidden><input type="text" name="invid[]" value="<?php if ($x->invid > 0) {
                                                                                    echo $x->invid;
                                                                                  } else {
                                                                                    echo '0';
                                                                                  } ?>"></td>
                              <td hidden><input type="text" class="form-control input-sm" name="custid[]" value="<?php echo $x->custidbyorder; ?>"></td>
                              <td hidden><input type="text" class="form-control input-sm" name="sono[]" value="<?php echo $x->sono; ?>"><input type="hidden" class="form-control input-sm" style="width: 150px;" name="docno_gr[]" value="<?php echo $x->docno_gr; ?>" readonly><input type="hidden" class="form-control input-sm" name="ppbid[]" value="<?php echo $x->ppbid; ?>"></td>
                            </tr>
                          <?php $i++;
                          } ?>
                        </tbody>
                      </table>
                    </div>
                  </div>

                  <div class="form-actions">
                    <div class="col-md-6">
                      <a type="button" class="col-md-2 btn btn-default" href="<?php echo site_url('Purchasing_do/add_delivery_oder'); ?>">Add</a>
                      <button type="submit" class="col-md-2 btn btn-primary">Update</button>
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
        <div id="formdialogGR"></div>
        <div id="modal_delete" class="modal fade bs-modal-lg" role="dialog" tabindex="-1" data-backdrop="static" data-keyboard="false" aria-hidden="true"></div>
      </div>
    </div>
  </div>
</div>
<script>
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
                                        <th nowrap>Qty out</th>\n\
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

  function filterdo() {
    $finddo = document.getElementById("finddo").value;

    $.ajax({
      url: "<?php echo base_url(); ?>Purchasing_do/delivery_oder_do?do=" + $finddo + "",
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
      //            var Nol=0;
      var QtyPO = $(this).find("input[name='QtyPO[]']").val();
      var QtyWHS = $(this).find("input[name='QtyWhs[]']").val();
      var Qty = $(this).find("input[name='Qty[]']").val();
      var Total = QtyPO - QtyWHS;

      if (Qty > Total) {
        //                alert('Qty is bigger than Qty PO Order !');
        //                $(this).find("input[name='Qty[]']").val(Nol);
      }
    });
  }

  function modal_delete(data) {
    $.ajax({
      url: "<?php echo base_url(); ?>Purchasing_do/delivery_order_modal_delete?delete=" + data + "",
      success: function(response) {
        $("#modal_delete").html(response);
      },
      dataType: "html"
    });

    return false;
  }
</script>