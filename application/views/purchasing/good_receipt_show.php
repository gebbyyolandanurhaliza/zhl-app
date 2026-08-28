<?php
if ($gr) {
  foreach ($gr as $r) {
    $docno =  $r->docno;
    $docdate = date("d-m-Y",  strtotime($r->docdate));
    $duedate =  date("d-m-Y",  strtotime($r->duedate));
    $status = $r->status;
    $status_gr = $r->status_gr;
  }
}
?>

<!-- <link href="<?php echo base_url(); ?>assets/admin/css/cloud-admin.css" rel="stylesheet" type="text/css"> -->

<div class="page-content">
  <div class="container-fluid">
    <div class="row">
      <div class="alert alert-info">
        <?php

        if ($status_gr == "OUT") {
          echo '<span"><strong><h3 ><b class="alert-heading">Item has been input in SO</b></h3></strong></span>';
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
          <div class="portlet-title">
            <div class="caption">
              <i class="fa fa-navicon theme-font"></i>
              <span class="caption-subject theme-font bold">Goods Receipt</span>
            </div>
            <!--                        <div class="tools">
                            <a href="javascript:;" class="collapse"></a>
                            <a href="javascript:;" class="fullscreen"></a>
                        </div>-->
          </div>
          <div class="portlet-body">
            <form action="<?php echo site_url('purchasing_gr/good_receipt_save/update'); ?>" method="post" class="form-horizontal" role="form">
              <div class="row">
                <div class="col-md-12">
                  <div class="form-body">
                    <div class="row">
                      <div class="col-md-6">
                        <!--<div class="form-group" style="margin-bottom:1px;">-->
                        <!--<label class="col-md-4 label-sm">Doc No</label>-->
                        <!--<div class="col-md-4">-->
                        <input type="hidden" class="form-control input-sm" name="docno" value="<?php echo $docno; ?>" readonly>
                        <!--</div>-->
                        <!--</div>-->
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
                      <div class="col-md-6">
                        <div class="form-group" style="margin-bottom:1px;">
                          <label class="col-md-4 label-sm">Doc No.</label>
                          <div class="col-md-4">
                            <input name="docno" class="form-control input-sm date" value="<?php echo $docno; ?>" readonly>
                          </div>
                        </div>

                      </div>
                      <div class="col-md-6">
                        <div class="form-group" style="margin-bottom:1px;">
                          <label class="col-md-4 label-sm">Status</label>
                          <div class="col-md-4">
                            <select class="form-control" data-placeholder="Status" name="status" readonly>
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
                            <th>#</th>
                            <th style="width: 150px;">Item ID</th>
                            <th style="width: 250px;">Item Name</th>
                            <th style="width: 150px;">Qty Order</th>
                            <th style="width: 150px;">Last Qty Recv</th>
                            <th style="width: 150px;">Qty Pending</th>
                            <th style="width: 150px;">UOM</th>
                            <th style="width: 150px;">Main PO</th>
                            <th>Shelf Life</th>
                            <th>Vendor</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php $i = 1;
                          foreach ($gr as $key => $x) { ?>
                            <tr>
                              <td><?php echo $i; ?></td>
                              <?php
                              if (($x->qtywhs + $x->tqtywhs) - $x->qtypo == 0) {
                                $disable = 'disabled';
                              } else {
                                $disable = '';
                              }
                              ?>

                              <!-- <td hidden><input type="text" name="invid[]" value="<?php if ($x->invid > 0) {
                                                                                          echo $x->invid;
                                                                                        } else {
                                                                                          echo '0';
                                                                                        } ?>"></td> -->

                              <td style="width: 150px;"><input type="text" class="form-control input-sm" name="ItemID[]" value="<?php echo $x->itemid; ?>" readonly></td>
                              <td style="width: 250px;"><input type="text" class="form-control input-sm" name="ItemName[]" value="<?php echo htmlspecialchars($x->itemname, ENT_QUOTES); ?>" readonly></td>
                              <td><input type="text" class="form-control input-sm text-right" style="width: 150px;" name="QtyPO[]" value="<?php echo number_format($x->qtypo, 2, '.', ''); ?>" readonly></td>



                              <td><input type="text" class="form-control input-sm text-right qty_whs" style="width: 150px;" name="QtyWhs[]" value="<?php echo number_format(((($x->tqtywhs + $x->qtywhs) > '0') ? $x->tqtywhs + $x->qtywhs : '0'), 3, '.', ''); ?>" readonly></td>

                              <td><input type="text" class="form-control input-sm text-right qty_pending" style="width: 150px;" name="Qty_pending[]" id="Qty_pending[]" value="<?php echo number_format(((($x->tqtywhs) > '0') ? ($x->qtywhs + $x->tqtywhs) - $x->qtypo : $x->qty_outstanding), 3, '.', ''); ?>" data-qtyorder="<?php echo number_format($x->qtypo, 2, '.', ''); ?>" data-qtyrec="<?php echo number_format($x->qtywhs, 2, '.', ''); ?>" data-baris="<?php echo $i; ?>" data-qtymax="<?php echo number_format($x->qty_outstanding, 2, '.', ''); ?>" onkeypress="return isNumber(event)" onkeyup="CheckMaxValueUpdate(this)" <?php echo $disable; ?>></td>
                              <!--                                                             
                                                            <td><input type="text" class="form-control input-sm text-right qty_whs" style="width: 80px;" name="QtyWhs[]" value="<?php echo number_format($x->qtywhs, 2, '.', ''); ?>" readonly></td>
                                                            <td><input type="text" class="form-control input-sm text-right qty_pending" style="width: 100px;" name="Qty_pending[]" id="Qty_pending[]" value="<?php echo number_format($x->qty_outstanding, 2, '.', ''); ?>" data-qtyorder="<?php echo number_format($x->qtypo, 2, '.', ''); ?>" data-qtyrec="<?php echo number_format($x->qtywhs, 2, '.', ''); ?>" data-baris="<?php echo $i; ?>" data-qtymax="<?php echo number_format($x->qty_outstanding, 2, '.', ''); ?>" onkeypress="return isNumber(event)" onkeyup="CheckMaxValueUpdate(this)"></td> -->


                              <td><input type="text" class="form-control input-sm" style="width: 150px;  text-align: center; vertical-align: middle;" name="UOM[]" value="<?php echo $x->uomname; ?>" readonly></td>
                              <td><input type="text" class="form-control input-sm" style="width: 150px;" name="MainPO[]" value="<?php echo $x->mainpo; ?>" readonly></td>
                              <td style="width: 150px;"><input type="text" class="form-control input-sm" style="width: 140px;" name="Shelf[]" value="<?php echo $x->shelf; ?>"></td>
                              <td><input type="text" class="form-control input-sm" value="<?php echo $x->vendorcompany; ?>" readonly></td>
                              <td hidden><input type="text" class="form-control input-sm" value="<?php echo $x->custcompanybyorder; ?>" readonly></td>
                              <td hidden><input type="text" class="form-control input-sm" name="custid[]" value="<?php echo $x->custidbyorder; ?>"></td>
                              <td hidden>
                                <input type="hidden" class="form-control input-sm qty_total" name="Qty[]" id=Qty-<?php echo $i; ?> value="">
                              </td>
                            </tr>
                          <?php $i++;
                          } ?>
                        </tbody>
                      </table>
                    </div>
                  </div>

                  <div class="form-actions">
                    <div class="col-md-6">
                      <a type="button" class="col-md-2 btn btn-default" href="<?php echo site_url('purchasing_gr'); ?>">Add</a>
                      <button type="submit" id='btn-update' class="col-md-2 btn btn-primary">Update</button>

                    </div>
                    <div class="col-md-6">
                      <button type="button" class="col-md-2 btn btn-warning" onclick="fnDialogGR()">Find</button>
                      <a type="button" class="col-md-2 btn btn-info" href="<?php echo site_url('purchasing_gr/print_report_gr?gr=' . $docno); ?>" target="_blank">Print</a>
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
<p id='status_gr' hidden><?php echo $status_gr; ?></p>
<script>
  $(document).ready(function() {

    $('#tblList tbody tr td .qty_pending').each(function(i, element) {

      var baris = $(this).attr('data-baris');
      var qtyRec = parseFloat($(this).attr('data-qtyrec'));
      var qtyPending = parseFloat($(this).val());
      var qty_id = '#Qty-' + baris;
      var total = addCommas(parseFloat(qtyRec + qtyPending).toFixed(2));

      $(qty_id).val(total);

      //$('.qty_total').val($(this).attr('data-qtyrec'));

    });

    if ($('#status_gr').html() == 'OUT') {
      $('#btn-update').prop('disabled', true);
    }
  });

  function fnDialogGR() {
    $("#formdialogGR").html(" <div class='portlet-body'>\n\
                        <div class='col-md-12'>\n\
                            <div class='form-group'>\n\
                                 <label class='col-md-1 label-sm'>Find</label>\n\
                                 <div class='col-md-7'>\n\
                                       <input class='form-control input-sm' id='findgr'>\n\
                                 </div>\n\
                                 <button type='button' class='col-md-1 btn blue' onclick='filtergr()'>Search</button>\n\
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
                                        <th nowrap>Status</th>\n\
                                        <th nowrap>Main GR</th>\n\
                                        <th nowrap>Main PO</th>\n\
                                        <th nowrap>Item ID</th>\n\
                                        <th nowrap>Item Name</th>\n\
                                        <th nowrap>Qty Order</th>\n\
                                        <th nowrap>Qty Recv</th>\n\
                                        <th nowrap>Vendor Company</th>\n\
                                        <th nowrap>Contact Person</th>\n\
                                        <th nowrap>Customer Company</th>\n\
                                        <th nowrap>Created By</th>\n\
                                        <th nowrap>Created Date</th>\n\
                                        <th nowrap>LastUpdated By</th>\n\
                                        <th nowrap>LastUpdated Date</th>\n\
                                    </tr>\n\
                                </thead>\n\
                                <tbody id='tblgr'>\n\
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
      title: "List Good Receipt",
      height: 650,
      width: 1200

    });
  }

  function filtergr() {
    $findgr = document.getElementById("findgr").value;

    $.ajax({
      url: "<?php echo base_url(); ?>purchasing_gr/good_receipt_gr?gr=" + $findgr + "",
      success: function(response) {
        $("#tblgr").html(response);
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


  function CheckMaxValueUpdate(obj) {
    var value = parseFloat(obj.value.replace(/,/g, ''));
    var qtyOrder = parseFloat(obj.getAttribute('data-qtyorder').replace(/,/g, ''));
    var qtyRec = parseFloat(obj.getAttribute('data-qtyrec').replace(/,/g, ''));
    var qtymax = parseFloat(obj.getAttribute('data-qtymax').replace(/,/g, ''));
    var baris = obj.getAttribute('data-baris');

    var maksimal = qtyOrder - qtyRec;
    var maksimal_comma = addCommas(parseFloat(maksimal).toFixed(2));

    if (value == 0) {
      calculateQty(baris, qtyRec, value);
      return false;
    }

    if (value > maksimal) {
      bootbox.alert("Value should not be more than " + maksimal_comma);
      $(obj).val(maksimal_comma);
      calculateQty(baris, qtyRec, qtymax);
      return false;
    }

    calculateQty(baris, qtyRec, value);

  }

  function calculateQty(baris, qtyRec, value) {

    var qty = addCommas(parseFloat(qtyRec + value).toFixed(2));
    var id = '#Qty-' + baris;
    console.log(id);
    $(id).val(qty);
  }


  // function CheckMaxValue(obj) {
  //     var value = obj.value.replace(/,/g, '');
  //     //  console.log(parseFloat(value));
  //     $("#tblList td ").keyup(function() {
  //         var row = $(this).closest('tr');
  //         var qtypending = $(row).find('td').eq(2).html();
  //         var index = $(row).find('td').eq(0).html();
  //         var qtywhs = $(row).find('td').eq(3).html();
  //         // console.log(qtypending)
  //         console.log(index)
  //         var qty = remove_thousand_separator($(this).find("input[name='Qty_pending[]']").val());
  //         console.log(qty)

  //         if (value > qtypending) {
  //             bootbox.alert("Value should not be more than " + qtypending);
  //         } else {
  //             var totalqty = parseInt(qty) + parseInt(qtywhs);
  //             // console.log(totalqty)
  //             var qtyid = "Qty-" + index;
  //             document.getElementById(qtyid).value = totalqty;
  //         }
  //     });
  // }

  function addCommas(nStr) {
    nStr += '';
    x = nStr.split('.');
    x1 = x[0];
    x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
      x1 = x1.replace(rgx, '$1' + ',' + '$2');
    }
    return x1 + x2;
  }

  function modal_delete(data) {
    $.ajax({
      url: "<?php echo base_url(); ?>purchasing_gr/good_receipt_modal_delete?delete=" + data + "",
      success: function(response) {
        $("#modal_delete").html(response);
      },
      dataType: "html"
    });

    return false;
  }
</script>