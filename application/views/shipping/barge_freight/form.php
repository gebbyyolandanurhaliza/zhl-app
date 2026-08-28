<?php
if (isset($data_hdr)) {
  $bargefreight_hdr_id = $data_hdr->bargefreight_hdr_id;
  $credit_term         = $data_hdr->credit_term;
  $vesel               = $data_hdr->vesel;
  $voyage_no           = $data_hdr->voyage_no;
  $port_of_load        = $data_hdr->port_of_load;
  $ship_board_date     = tgl_dmy2($data_hdr->ship_board_date);
  $ship_location       = $data_hdr->ship_location;
  $total_amount        = $data_hdr->total_amount;
  $gst_value           = $data_hdr->gst_value;
  $amount_due          = $data_hdr->amount_due;
  $gst_check           = $data_hdr->gst_check;
  $customer_id         = $data_hdr->customer_id;
} else {
  $customer_id         = '';
  $bargefreight_hdr_id = '';
  $credit_term         = '';
  $vesel               = '';
  $voyage_no           = '';
  $port_of_load        = '';
  $ship_board_date     = '';
  $ship_location       = '';
  $created_by          = '';
  $created_at          = '';
  $updated_by          = '';
  $updated_at          = '';
  $deleted_at          = '';
  $deleted_by          = '';
  $total_amount        = '';
  $gst_value           = 0;
  $amount_due          = '';
  $gst_check           = '';
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
              <span class="caption-subject theme-font bold uppercase"><?= $header_title ?></span>
            </div>
          </div>
          <div class="portlet-body form">
            <form action="<?= $form_url ?>" method="post" class="form-horizontal" role="form" id="form_tax">
              <div class="form-body">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group" style="margin-bottom:1px;">
                      <label class="col-md-3">Shipped on Board Date <small class="text-danger">*</small></label>
                      <div class="col-md-3">
                        <div class="input-group date date-picker" data-date="<?= date('d-m-Y') ?>" data-date-format="dd-mm-yyyy">
                          <span class="input-group-btn">
                            <!-- <button class="btn default" type="button" <?= $ship_board_date != '' ? 'disabled' : '' ?>><i class="fa fa-calendar"></i></button> -->
                            <button class="btn default" type="button" ><i class="fa fa-calendar"></i></button>
                          </span>
                          <!-- <input type="text" name="ship_board_date" id="ship_board_date" class="form-control" placeholder="dd-mm-yyyy" autocomplete="off" value="<?= $ship_board_date ?>" <?= $ship_board_date != '' ? 'disabled' : '' ?> readonly required> -->
                          <input type="text" name="ship_board_date" id="ship_board_date" class="form-control" placeholder="dd-mm-yyyy" autocomplete="off" value="<?= $ship_board_date ?>"  required>
                        </div>
                      </div>
                    </div>

                    <div class="form-group" style="margin-bottom:1px;">
                      <label class="col-md-3">Customer <small class="text-danger">*</small></label>
                      <div class="col-md-6">
                        <select name="customer_id" id="customer_id" class="form-control select2me" required>
                          <option value="">Choose</option>
                          <?php
                          foreach ($customer as $cs) { ?>
                            <option value="<?= $cs->customer_id ?>" <?= $customer_id == $cs->customer_id ? 'selected' : '' ?>> <?= strtoupper($cs->customer_name) ?></option>
                          <?php
                          }
                          ?>
                        </select>
                      </div>
                    </div>

                    <div class="form-group" style="margin-bottom:1px;">
                      <label class="col-md-3">Credit Term </label>
                      <div class="col-md-6">
                        <select name="credit_term" id="credit_term" class="form-control select2me" required>
                          <option value="">Choose</option>
                          <option value="30 days" <?= $credit_term == '30 days' ? 'selected' : '' ?>>30 days</option>
                          <option value="45 days" <?= $credit_term == '45 days' ? 'selected' : '' ?>>45 days</option>
                        </select>
                      </div>
                    </div>

                  </div>

                  <div class="col-md-6">
                    <div class="form-group" style="margin-bottom:1px;">
                      <label class="col-md-3">Vessel </label>
                      <div class="col-md-6">
                        <select name="vesel" id="vesel" class="form-control select2me" required>
                          <option value="">Choose</option>
                          <?php
                          foreach ($vessel as $v) { ?>
                            <option value="<?= $v->vessel_name ?>" <?= $vesel == $v->vessel_name ? 'selected' : '' ?>><?= $v->vessel_name; ?></option>
                          <?php
                          }
                          ?>
                        </select>
                      </div>
                    </div>

                    <!-- <div class="form-group" style="margin-bottom:1px;">
                                            <label class="col-md-3">Vessel <small class="text-danger">*</small></label>
                                            <div class="col-md-8">
                                                <input class="form-control" name="vesel" value="<?= $vesel ?>" autocomplete="off" required>
                                            </div>
                                        </div> -->

                    <div class="form-group" style="margin-bottom:1px;">
                      <label class="col-md-3"> Voyage NO <small class="text-danger">*</small></label>
                      <div class="col-md-5">
                        <input class="form-control" name="voyage_no" value="<?= $voyage_no ?>" autocomplete="off" required>
                      </div>
                    </div>

                    <div class="form-group" style="margin-bottom:1px;">
                      <label class="col-md-3">Port Of Loading <small class="text-danger">*</small></label>
                      <div class="col-md-8">
                        <input class="form-control" name="port_of_load" value="<?= $port_of_load ?>" required>
                      </div>
                    </div>

                  </div>
                </div>
                <hr>
                <div class="col-md-12">
                  <div class="table-scrollable">
                    <table class="table table-hover" id="tblList">
                      <thead>
                        <tr>
                          <th width="10px"><button class="btn btn-sm btn-primary" type="button" onclick="modal_dialog_item()"><i class="fa fa-arrow-down"></i></button></th>
                          <th>JO REF</th>
                          <th>Type</th>
                          <th>POD</th>
                          <th>UOM</th>
                          <th>Description</th>
                          <th>Freight PER M.T</th>
                          <th>Unit Price</th>
                          <th>QTY</th>
                          <th>Amount</th>
                        </tr>
                      </thead>
                      <tbody id="tbl_list_item">
                        <?php
                        if (isset($data_dtl)) {
                          foreach ($data_dtl as  $dtl) { ?>
                            <tr>
                              <?php
                              if ($dtl->head == '1') { ?>

                                <!-- hidden item -->
                                <input type="hidden" class="form-control" name="head[]" value="<?= $dtl->head ?>" readonly>
                                <input type="hidden" class="form-control" name="row[]" value="<?= $dtl->row ?>" readonly>
                                <input type="hidden" class="form-control" name="bargefreight_dtl_id[]" value="<?= $dtl->bargefreight_dtl_id ?>" readonly>
                                <!-- hidden item -->

                                <td class="remove" data-row="<?= $dtl->row ?>">
                                  <button class="btn btn-sm btn-danger" type="button"><i class="fa fa-trash"></i></button>
                                </td>
                                <td>
                                  <input type="text" class="form-control" name="jo_ref[]" value="<?= $dtl->jo_ref ?>">
                                </td>
                                <td>
                                  <input type="text" class="form-control" name="con_type_name[]" value="<?= $dtl->con_type_name ?>" readonly>
                                </td>
                                <td width="250">
                                  <input type="text" class="form-control" name="pod[]" value="<?= $dtl->pod ?> " readonly>
                                </td>
                                <td>
                                  <input type="text" class="form-control" name="uom[]" value="<?= $dtl->uom ?>" readonly>
                                </td>
                                <td>
                                  <input type="text" class="form-control" name="description[]" value="<?= $dtl->description ?>" readonly>
                                  <input type="hidden" class="form-control" name="freight_desc_list[]" value="<?= $dtl->freight_desc_list ?>" readonly>
                                </td>
                                <td>
                                  <input type="text" class="form-control" name="freight_per_mt[]" value="<?= $dtl->freight_per_mt  ?>" readonly>
                                </td>
                                <td>
                                  <input type="text" class="form-control text-right" name="unit_price[]" value="<?= number_format($dtl->unit_price, 2) ?>" readonly>
                                </td>
                                <td>
                                  <input type="text" class="form-control text-right autonum_qty" name="qty[]" value="<?= $dtl->qty ?>" data-v-min="0" value="" onkeyup="calculate()" autocomplete="off" required>
                                </td>
                                <td>
                                  <input type="text" class="form-control text-right" name="amount[]" value="<?= number_format($dtl->amount, 2) ?>" readonly>
                                </td>
                              <?php
                              } else { ?>

                                <!-- hidden item -->

                                <input type="hidden" class="form-control" name="head[]" value="<?= $dtl->head ?>" readonly>
                                <input type="hidden" class="form-control" name="row[]" value="<?= $dtl->row ?>" readonly>
                                <input type="hidden" class="form-control" name="bargefreight_dtl_id[]" value="<?= $dtl->bargefreight_dtl_id ?>" readonly>
                                <!-- hidden item -->
                                <td class="remove" data-row="<?= $dtl->row ?>">
                                  <button class="btn btn-sm btn-danger" type="button"><i class="fa fa-trash"></i></button>
                                </td>
                                <td>
                                  <input type="hidden" class="form-control" name="jo_ref[]" value="<?= $dtl->jo_ref ?>" readonly>
                                </td>
                                <td>
                                  <input type="hidden" class="form-control" name="con_type_name[]" value="<?= $dtl->con_type_name ?>" readonly>
                                </td>
                                <td width="250">
                                  <input type="hidden" class="form-control" name="pod[]" value="<?= $dtl->pod ?> " readonly>
                                </td>
                                <td>
                                  <input type="text" class="form-control" name="uom[]" value="<?= $dtl->uom ?>" readonly>
                                </td>
                                <td>
                                  <input type="text" class="form-control" name="description[]" value="<?= $dtl->description ?>" readonly>
                                  <input type="hidden" class="form-control" name="freight_desc_list[]" value="<?= $dtl->freight_desc_list ?>" readonly>
                                </td>
                                <td>
                                  <input type="text" class="form-control" name="freight_per_mt[]" value="<?= $dtl->freight_per_mt  ?>" readonly>
                                </td>
                                <td>
                                  <input type="text" class="form-control text-right" name="unit_price[]" value="<?= number_format($dtl->unit_price, 2) ?>" readonly>
                                </td>
                                <td>
                                  <input type="text" class="form-control text-right autonum_qty" name="qty[]" data-v-min="0" value="<?= $dtl->qty ?>" onkeyup="calculate()">
                                </td>
                                <td>
                                  <input type="text" class="form-control text-right" name="amount[]" value="<?= number_format($dtl->amount, 2) ?>" readonly>
                                </td>

                              <?php

                              }

                              ?>

                            </tr>
                        <?php
                          }
                        }
                        ?>
                      </tbody>
                    </table>
                  </div>
                </div>
                <div class="col-md-9"></div>
                <div class="col-md-3" style="margin-top:10px;">
                  <div class="form-group" style="margin-bottom:1px;">
                    <div class="col-sm-4">
                      <label>Total</label>
                    </div>
                    <div class="col-sm-8">
                      <input class="form-control text-right" name="total_amount" id="total_amount" value="<?= $total_amount ?>" required readonly>
                    </div>
                  </div>
                  <div class="form-group" style="margin-bottom:1px;">
                    <div class="col-sm-4">
                      <label>Add: GST AT 8 %</label>
                    </div>
                    <div class="col-sm-2">
                      <input type="checkbox" name="gst_check" id="gst_check" value="1" <?= $gst_check == 1 ? 'checked' : '' ?>>
                    </div>
                    <div class="col-sm-6">
                      <input class="form-control text-right autonum_gst" data-v-min="0" name="gst_value" id="gst_value" value="<?= $gst_value ?>" readonly required>
                    </div>
                  </div>
                  <div class="form-group" style="margin-bottom:1px;">
                    <div class="col-sm-4">
                      <label>Amount Due</label>
                    </div>
                    <div class="col-sm-8">
                      <input class="form-control text-right" name="amount_due" id="amount_due" value="<?= $amount_due ?>" required readonly>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-6 mt-2">
                    <button type="submit" class="col-md-2 btn btn-primary" id="btn-save"><i class="fa fa-paper-plane"></i> <?= $btn_name ?></button>
                    <?php
                    if (isset($data_hdr)) { ?>
                      <button type="reset" class="col-md-2 btn btn-default" onclick="redirectForm('<?= safe_b64encode($bargefreight_hdr_id) ?>')"><i class="fa fa-times-circle"></i> Cancel</button>
                      <a href="#delteModal" role="button" class="col-md-2 btn btn-danger" data-toggle="modal"> <i class="fa fa-trash"></i> Delete </a>
                      <a class="btn btn-info" title="Print" href="<?= site_url('barge_freight/print_pdf/' . safe_b64encode($bargefreight_hdr_id)) ?>" target="_blank"> <i class="fa fa-print"></i> Print</a>
                      <a class="btn btn-primary" title="Print" href="<?= site_url('barge_freight/add') ?>"> <i class="fa fa-plus"></i> Add New</a>
                    <?php
                    } else { ?>
                      <button type="reset" class="col-md-2 btn btn-default" onclick="resetForm()"><i class="fa fa-times-circle"></i> Cancel</button>
                    <?php
                    }
                    ?>

                  </div>
                  <div class="col-md-3 mt-2"></div>
                  <div class="col-md-3 mt-2">
                    <button type="button" class="col-md-push-7 btn btn-warning btn-block" onclick="fnDialogListTaxAll()"><i class="fa fa-search"></i> Find</button>
                  </div>
                </div>

              </div>
          </div>
          </form>
        </div>
      </div>

      <!-- modal delete -->
      <div id="delteModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel3" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
              <h4 class="modal-title">Confirm</h4>
            </div>
            <div class="modal-body">
              <h4>Are you sure to delete this data ? </h4>
            </div>
            <div class="modal-footer">
              <button class="btn default" data-dismiss="modal" aria-hidden="true">Close</button>
              <a href="<?= site_url('barge_freight/delete/' . safe_b64encode($bargefreight_hdr_id)) ?>" class="btn blue">Confirm</a>
            </div>
          </div>
        </div>
      </div>

      <!-- Modal Form Dialog -->
      <div id="modal_dialog" hidden>
        <div class="portlet-body">
          <div class="col-md-12">
            <div class="form-group">
              <label class="col-md-3 control-label" for="varchar">Form-To</label>
              <div class="col-md-9">
                <select name="destination_id" id="destination_id" class="form-control select2me" required>
                  <option value="">Choose</option>
                  <?php
                  foreach ($destination as $dest) { ?>
                    <option value="<?= $dest->destination_id ?>"><?= $dest->destination_name ?> | (<?= $dest->destination_abbr ?>)</option>
                  <?php
                  }
                  ?>
                </select>
              </div>
            </div>
          </div>
          <div class="col-md-12">
            <div class="form-group">
              <label class="col-md-3 control-label" for="varchar">Container Name </label>
              <div class="col-md-9">
                <select name="container_id" id="container_id" class="form-control select2me" required>
                  <option value="">Choose</option>
                  <?php
                  foreach ($container as $con) { ?>
                    <option value="<?= $con->container_id ?>"><?= $con->container_name ?></option>
                  <?php
                  }
                  ?>
                </select>
              </div>
            </div>
          </div>
          <div class="col-md-12">
            <div class="form-group">
              <label class="col-md-3 control-label" for="varchar">Container Type </label>
              <div class="col-md-9">
                <select name="con_type_id" id="con_type_id" class="form-control select2me">
                  <option value="">Choose</option>
                  <?php
                  foreach ($con_type as $type) { ?>
                    <option value="<?= $type->con_type_id ?>"><?= $type->con_type_name ?></option>
                  <?php
                  }
                  ?>
                </select>
              </div>
            </div>
          </div>
          <div class="col-md-12">
            <hr>
          </div>
          <div class="col-md-6" style="margin-top: 20px;">
            <button type="button" class="col-md-3 btn blue" onclick="choose_item()" id="choose">Choose</button>
            <button type="button" class="col-md-3 btn grey" onclick="close_dialog()">Close</button>
          </div>
        </div>
      </div>

      <!-- find -->
      <div id="formdialogFind" hidden>
        <div class='portlet-body'>
          <div class='col-md-12'>
            <div class='form-group'>
              <label class='col-md-2 label-sm'>Find Order By</label>
              <div class='col-md-7'>
                <input class='form-control input-sm' id='input-search' placeholder="Filter by Shipped on Board/Credit Terms/Customer/Vesel/Voyage No">
              </div>
              <button type='button' class='col-md-1 btn blue' onclick='filterTaxAll()'><i class="fa fa-search"></i> Search</button>
            </div>
          </div>
          <br>
          <hr>
          <div class='table-scrollable' style='overflow: auto; height:490px;'>
            <table id='tbl-list' class='table table-bordered table-striped'>
              <thead>
                <tr>
                  <th>Action</th>
                  <th>Shipped On Board Date</th>
                  <th>Costumer</th>
                  <th>Vessel/Voyage no</th>
                  <th>Port Of Load/Discharge *</th>
                </tr>
              </thead>
              <tbody id='tbl-list-tax'></tbody>
            </table>
            <div class="text-center" style="display:none" id="loader">
              <h2><i class="fa fa-spinner fa fa-spin"></i></h2>
              <p>Loading...</p>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>
</div>

<script>
  'use strict';

  var action = '<?= $action ?>';

  $(document).ready(function() {
    $('.autonum_qty').autoNumeric('init', {
      mDec: 0
    });

    $('#total_amount,#amount_due,#gst_value').autoNumeric('init', {
      mDec: 2
    });

    // calculate();

  });

  $('#tblList tr .remove').click(function(e) {

    var rowspan = $(this).attr('rowspan');
    var row = rowspan - 1;
    var tr = $(this).closest('tr');
    bootbox.confirm('Are you sure want to remove this item ?', function(result) {
      if (result) {
        for (let index = 0; index < row; index++) {
          $(tr).next().remove();
        }
        $(tr).remove();

        calculate();

        $.bootstrapGrowl('<i class="fa fa-info-circle"></i> Remove item Success.', {
          type: 'success', // (null, 'info', 'danger', 'success', 'warning')
          offset: {
            from: 'top',
            amount: 250
          }, // 'top', or 'bottom'
          align: 'center', // ('left', 'right', or 'center')
          width: 'auto', // (integer, or 'auto')
          delay: 3000, // Time while the message will be displayed. It's not equivalent to the *demo* timeOut!
          allow_dismiss: true, // If true then will display a cross to close the popup.
          stackup_spacing: 5 // spacing between consecutively stacked growls.
        });
      }
    });
  });


  function modal_dialog_item() {
    // Define the Dialog and its properties.
    $("#modal_dialog").dialog({
      resizable: false,
      modal: true,
      title: "Select Item To Add",
      height: 300,
      width: 800,
      close: function() {
        reset_form_dialog();
      }
    });
  }

  function delete_row(start, end) {
    var awal = start.rowIndex;
    var length = parseInt(awal) + parseInt(end);
    if (confirm("Are you sure remove this row?") == true) {
      var x = length;
      for (let index = 0; index <= end; index++) {
        document.getElementById("tblList").deleteRow(x);
        x--;
      }

    }
  }

  function choose_item() {
    var destination_id = $('#destination_id option:selected').val();
    var container_id = $('#container_id option:selected').val();
    var con_type_id = $('#con_type_id option:selected').val();
    var kode_awal = $('#kode').val();
    var kode_baru = parseInt(kode_awal) + 1;

    if (destination_id == "") {
      alert("Destination not Choose");
      return false;
    }

    if (container_id == "") {
      alert("Container not Choose");
      return false;
    }

    if (con_type_id == "") {
      alert("Type not Choose");
      return false;
    }

    $.ajax({
      type: "post",
      url: "<?= site_url('barge_freight/get_item') ?>",
      data: {
        'destination_id': destination_id,
        'container_id': container_id,
        'con_type_id': con_type_id,
        'kode': kode_baru,
      },
      dataType: "html",
      success: function(response) {
        if (response.trim() == "not found") {
          alert("Item Not Found");
        } else {
          $('#tbl_list_item').append(response);
          $('#kode').val(kode_baru);
          $("#modal_dialog").dialog("close");
          reset_form_dialog();
        }
      }
    });

    return false;
  }

  function close_dialog() {
    reset_form_dialog();
    $("#modal_dialog").dialog("close");
  }

  function reset_form_dialog() {
    $('#destination_id').select2("val", "");
    $('#container_id').select2("val", "");
    $('#con_type_id').select2("val", "");
  }


  function fnamount_due() {
    var total_amount = remove_thousand_separator($('#total_amount').val());
    var gst_value = remove_thousand_separator($('#gst_value').val());
    var total = total_amount + gst_value;
    $('#amount_due').val(number_format(total, 2));
  }

  function resetForm() {
    $('#form_tax').trigger("reset");
    $('#kode').val('0');
    $('#tbl_list_item tr').remove();
  }

  function redirectForm(id) {
    window.location.href = "<?= site_url('barge_freight/edit/') ?>" + '/' + id;
  }

  function calculate() {
    'use strict';
    var int = 0;
    var total = 0;

    var total_amount = 0;

    $('#tbl_list_item tr').each(function() {
      var qty = remove_thousand_separator($(this).find("input[name='qty[]']").val());
      var price = remove_thousand_separator($(this).find("input[name='unit_price[]']").val());

      var total_row = qty * price;

      if (action == 'add') {
        $(this).find("input[name='amount[]']").autoNumeric('init', {
          mDec: 2
        });
        $(this).find("input[name='amount[]']").autoNumeric('set', total_row);
      }else{
        var $amountInput = $(this).find("input[name='amount[]']");
        $amountInput.val('');

        $amountInput.autoNumeric('destroy');
        $amountInput.autoNumeric('init', { mDec: 2 });

        var qty = parseFloat(remove_thousand_separator($(this).find("input[name='qty[]']").val()) || 0);
        var price = parseFloat(remove_thousand_separator($(this).find("input[name='unit_price[]']").val()) || 0);
        var total_row = qty * price;

        if (!isNaN(total_row)) {
          $amountInput.autoNumeric('set', total_row);
        }
      }

      total_amount += total_row;
    });

    $('#total_amount').autoNumeric('set', total_amount);

    var total_amount = remove_thousand_separator($('#total_amount').val());
    var gst_value = remove_thousand_separator($('#gst_value').val());

    var total = total_amount + gst_value;
    $('#amount_due').autoNumeric('set', total);
  }



  function fnDialogListTaxAll() {
    // Define the Dialog and its properties.
    $("#formdialogFind").dialog({
      resizable: false,
      modal: true,
      title: "List Barge Freight",
      height: 650,
      width: 1200

    });
  }

  $('#formdialogFind').on('dialogclose', function(event) {
    $('#tbl-list-tax').html("");
  });


  function filterTaxAll() {
    var search = document.getElementById("input-search").value;

    $("#tbl-list-tax").html("");

    $.ajax({
      method: 'post',
      url: "<?php echo site_url(); ?>barge_freight/find",
      data: {
        'search': search
      },
      dataType: "html",
      beforeSend: function() {
        $("#loader").show();
      },
      success: function(response) {
        if (response.trim() == "0") {
          $("#tbl-list-tax").html("<tr><td class='text-center' colspan='8'>List Empty</td></tr>");
        } else {
          $("#tbl-list-tax").html(response);
        }

      },
      complete: function() {
        $("#loader").hide();
      }
    });
  }


  $("#gst_check").change(function() {
    var total = $('#total_amount').val();
    if (total == '' || total == 0) {
      total = 0;
    } else {
      total = remove_thousand_separator(total);
    }

    if (total == 0) {
      return false;
    }

    var persen = (total * 8) / 100;
    var value = $(this).is(':checked');
    var total_amount = remove_thousand_separator($('#total_amount').val());
    var amount_due = remove_thousand_separator($('#amount_due').val());

    if (value) {
      $('#gst_value').autoNumeric('set', persen);
      var total = total_amount + persen;
      $('#amount_due').autoNumeric('set', total);
    } else {
      $('#gst_value').autoNumeric('set', 0);
      var total = amount_due - persen;
      $('#amount_due').autoNumeric('set', total);
    }
  });

  // $('.btn_delete_list').click(function(e) {
  //     console.log("masuk");
  //     return false;
  //     var id = $(this).data('id');
  //     console.log(id);
  // });
</script>