<link href="<?php echo base_url(); ?>assets/admin/scripts/jquery.autocomplete.css" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url(); ?>assets/admin/scripts/jquery.autocomplete.js" type="text/javascript"></script>

<style type="text/css">
  .sembunyi {
    display: none;
  }
</style>
<div class="page-content">
  <div class="container-fluid">
    <div class="row ">
      <div class="col-md-12">
        <?php echo $message; ?>
        <div class="portlet light">
          <div class="portlet-title">
            <div class="caption">
              <i class="fa fa-user theme-font"></i>
              <span class="caption-subject theme-font uppercase"><?php echo $header_title; ?></span>
            </div>
            <div class="tools">
              <a href="javascript:;" class="collapse"></a>
            </div>
          </div>
          <div class="portlet-body form">
            <form action="<?php echo $action; ?>" method="post" class="form-horizontal" role="form" id="form_customer">
              <div class="form-body row">
                <div class="col-md-7">
                  <h4 class="form-section"><i class="fa fa-users"></i>Customer Details</h4>
                  <div class="form-group required">
                    <label class="col-md-3 control-label" for="varchar">Customer Name</label>
                    <div class="col-md-8">
                      <input required type="text" class="form-control" name="customer_name" id="customer_name" value="<?php echo $customer_name; ?>" />
                    </div>
                    <span class="help-inline"><?php echo form_error('customer_name') ?></span>
                  </div>

                  <div class="form-group required">
                    <label class="col-md-3 control-label" for="varchar">Customer Code</label>
                    <div class="col-md-8">
                      <input required type="text" class="form-control" name="customer_code" id="customer_code" value="<?php echo $customer_code; ?>" />
                    </div>
                    <span class="help-inline"><?php echo form_error('customer_code') ?></span>
                  </div>

                  <div class="form-group required">
                    <label class="col-md-3 control-label" for="varchar">Currency </label>
                    <div class="col-md-8">
                      <?php

                      $extra_currency = 'class="form-control select2me" data-placeholder="Select Currency..."';
                      $option_currency[''] = '';
                      foreach ($mst_currency as $r) :
                        $option_currency[$r->currency_id] = $r->currency_name;
                      endforeach;
                      echo form_dropdown('curency_code', $option_currency, $curency_code, $extra_currency);
                      ?>

                    </div>
                    <span class="help-inline"><?php echo form_error('curency_code') ?></span>
                  </div>

                  <div class="form-group">
                    <label class="col-md-3 control-label" for="longtext">Address</label>
                    <div class="col-md-8">
                      <textarea rows="3" class="form-control autosizeme" name="address" id="address"><?php echo $address; ?></textarea>
                    </div>
                    <span class="help-inline"><?php echo form_error('address') ?></span>
                  </div>

                  <div class="form-group">
                    <label class="col-md-3 control-label" for="varchar">Terms - Payment is Due</label>
                    <div class="col-md-8">
                      <input type="text" class="form-control" name="term_payment_due" id="term_payment_due" value="<?php echo $term_payment_due; ?>" />
                    </div>
                    <span class="help-inline"><?php echo form_error('term_payment_due') ?></span>
                  </div>

                  <div class="form-group">
                    <label class="col-md-3 control-label" for="varchar">Balance Due Date</label>
                    <div class="col-md-8">
                      <input type="text" class="form-control" name="balance_due_date" id="balance_due_date" value="<?php echo $balance_due_date; ?>" />
                    </div>
                    <span class="help-inline"><?php echo form_error('balance_due_date') ?></span>
                  </div>

                  <div class="form-group">
                    <label class="col-md-3 control-label" for="varchar">Account</label>
                    <div class="col-md-8">
                      <input type="text" class="form-control" name="account" id="account" value="<?php echo $account; ?>" />
                    </div>
                    <span class="help-inline"><?php echo form_error('account') ?></span>
                  </div>

                  <div class="form-group">
                    <label class="col-md-3 control-label" for="varchar">Payment Method</label>
                    <div class="col-md-8">
                      <input type="text" class="form-control" name="payment_method" id="payment_method" value="<?php echo $payment_method; ?>" />
                    </div>
                    <span class="help-inline"><?php echo form_error('payment_method') ?></span>
                  </div>

                  <div class="form-group required">
                    <label class="col-md-3 control-label" for="varchar">Country </label>
                    <div class="col-md-8">
                      <?php

                      $extra_country = 'class="form-control select2me" data-placeholder="Select Country..."';
                      $option_country[''] = '';
                      foreach ($mst_country as $r) :
                        $option_country[$r->country_name] = $r->country_name;
                      endforeach;
                      echo form_dropdown('country', $option_country, $country, $extra_country);
                      ?>

                    </div>
                    <span class="help-inline"><?php echo form_error('country') ?></span>
                  </div>

                  <div class="form-group">
                    <label class="col-md-3 control-label" for="varchar">As Supllier/Vendor</label>
                    <div class="col-md-8">
                      <input type="checkbox" name="is_supplier" id="is_supplier" class="form-control" <?= $is_supplier == 1 ? 'checked' : '' ?>>
                    </div>
                  </div>

                </div>

                <div class="col-md-5">

                  <h4 class="form-section"><i class="fa fa-male"></i> Contact Person</h4>

                  <div class="form-group">
                    <label class="col-md-3 control-label" for="varchar">Contact Name</label>
                    <div class="col-md-8">
                      <input type="text" class="form-control" name="contact_name" id="contact_name" value="<?php echo $contact_name; ?>" />
                      <span class="help-inline"><?php echo form_error('contact_name') ?></span>
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-md-3 control-label" for="varchar">Fax</label>
                    <div class="col-md-8">
                      <input type="text" class="form-control" name="fax" id="fax" value="<?php echo $fax; ?>" />
                    </div>
                    <span class="help-inline"><?php echo form_error('fax') ?></span>
                  </div>

                  <div class="form-group">
                    <label class="col-md-3 control-label" for="varchar">Email</label>
                    <div class="col-md-8">
                      <input type="text" class="form-control" name="email" id="email" value="<?php echo $email; ?>" />
                    </div>
                    <span class="help-inline"><?php echo form_error('email') ?></span>
                  </div>

                  <div class="form-group">
                    <label class="col-md-3 control-label" for="varchar">Phone</label>
                    <div class="col-md-8">
                      <input type="text" class="form-control" name="phone" id="phone" value="<?php echo $phone; ?>" />
                      <span class="help-inline"><?php echo form_error('phone') ?></span>
                    </div>
                  </div>
                  <div class="form-group row">
                    <h4 class="form-section"><i class="fa fa-money"></i>Item of Invoice</h4>
                    <table class="table table-striped table-bordered" id="tabel">
                      <thead>
                        <tr>
                          <th width="5%"><button class="btn btn-primary" id="btn1" type="button" onclick="openmodal()"><i class="fa fa-plus"></i></button></th>
                          <th width="2%">Sort Number</th>
                          <th width="10%">Item Number</th>
                          <th width="20%">Item Name</th>
                          <th width="10%">Income Coa</th>
                          <th width="10%">Expenses Coa</th>
                          <th width="10%">Price</th>
                        </tr>
                      </thead>
                      <tbody id="tbody2">
                        <?php
                        if (!empty($mst_item)) {
                          foreach ($mst_item as $r) {
                            echo "
                                <tr>
                                    <td>
                                      <button class='tombol' onclick='hapus_list(this)' type='button'>Remove</button>
                                    </td>
                                    <td><input type='number' name='sort_num[]' class='txt' value='$r->sort_num' /></td>
                                    <td><input type='hidden' name='item_id[]' value='$r->item_id' />
                                        <input type='text' class='txt' value='$r->Item_number' readonly /></td>
                                    <td><input type='text' class='txt' value='$r->Item_name'></td>
                                    <td ><input type='text' class='txt'value='$r->Income_coa' /></td>
                                    <td><input type='text' class='txt'value='$r->expenses_coa' /></td>
                                    <td><input type='text' name='price[]' class='txt'value='$r->price_item' /></td>
                                </tr> ";
                          }
                        }

                        ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>

              <div class="form-actions">
                <div class="row">
                  <div class="col-md-12">
                    <input type="hidden" id="customer_id" name="customer_id" value="<?php echo $customer_id; ?>" />
                    <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> <?php echo $button ?></button>
                    <a href="<?php echo site_url('Master_Tims/customer_transport') ?>" class="btn btn-danger"><i class="fa fa-close"></i> Cancel</a>
                  </div>
                </div>
              </div>
            </form>

          </div>

        </div>



      </div>
    </div>
  </div>

</div>
<div class="modal fade" id="item_modal" tabindex="-1" role="basic" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content" id="item_list">

    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<script type="text/javascript">
  function openmodal() {
    $('#item_modal').modal('show');
    get_item()
  }

  function get_item() {
    $id = $("#customer_id").val();
    $url = "<?php echo base_url(); ?>Master_Tims/get_list_item_master?id=" + $id;
    $.ajax({
      url: $url,
      success: function(response) {
        $("#item_list").html(response);
      },
      dataType: "html"
    });
    // $('#tbody2').html('');
  }

  function hapus_list(btn) {
    var row = btn.parentNode.parentNode;
    row.parentNode.removeChild(row);
  }

  // // Tombol Up
  // $('.tombol_up').click(function() {
  //   var row = $(this).parents('tr');
  //   if (row.index() > 0) { // Memastikan bukan baris pertama
  //     row.prev().before(row);
  //   }
  // });

  // // Tombol Down
  // $('.tombol_down').click(function() {
  //   var row = $(this).parents('tr');
  //   row.next().after(row);
  // });
</script>