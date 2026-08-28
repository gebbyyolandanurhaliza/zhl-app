<?php
foreach ($item_price as $r) {
  $vendorid  = $r->vendorid;
  $name      = $r->vendorcompany;
  $contact   = $r->contactperson;
  $currency  = $r->currencyid;
  $itemid    = $r->itemid;
  $itemname  = $r->itemname;
  $pmcode    = $r->pmcode;
  $uom       = $r->uomname;
  $qty       = $r->qnty;
  $unitprice = $r->unitprice;
}
?>

<!-- <link href="<?php echo base_url(); ?>assets/admin/css/cloud-admin.css" rel="stylesheet" type="text/css"> -->

<div class="page-content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">

        <div class="portlet light">
          <div class="portlet-title">
            <div class="caption">
              <i class="fa fa-navicon theme-font"></i>
              <span class="caption-subject theme-font bold">Item Price</span>
            </div>
            <div class="tools">
              <a href="javascript:;" class="collapse"></a>
              <a href="javascript:;" class="fullscreen"></a>
            </div>
          </div>
          <div class="portlet-body form">
            <form action="<?php echo site_url('purchasing/item_price_save/update'); ?>" method="post" class="form-horizontal" role="form">
              <div class="form-body">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group" style="margin-bottom:1px;">
                      <label class="col-md-3 label-sm">Vendor</label>
                      <div class="col-md-4">
                        <input type="text" class="form-control input-sm" name="vendorid" value="<?php echo $vendorid; ?>" readonly>
                      </div>
                    </div>
                    <div class="form-group" style="margin-bottom:1px;">
                      <label class="col-md-3 label-sm">Name</label>
                      <div class="col-md-5">
                        <input class="form-control input-sm" name="name" value="<?php echo $name; ?>" readonly>
                      </div>
                    </div>
                    <div class="form-group " style="margin-bottom:1px;">
                      <label class="col-md-3 label-sm">Contact Person</label>
                      <div class="col-md-4">
                        <input class="form-control input-sm" name="contact" value="<?php echo $contact; ?>" readonly>
                      </div>
                    </div>
                    <div class="form-group" style="margin-bottom:1px;">
                      <div class="col-md-4 col-md-offset-3">
                        <select class="form-control select2me" data-placeholder="Currency" name="cur" required>
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
                  <table class="table table-bordered table-striped">
                    <thead>
                      <tr class="success">
                        <th width="20%">Item ID</th>
                        <th width="40%">Item Name</th>
                        <th width="10%">Label PM Code</th>
                        <th width="10%">UOM</th>
                        <th width="10%">Qty</th>
                        <th width="10%">Unit Price</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td nowrap><input type="text" class="form-control input-sm" name="ItemID[]" value="<?php echo $itemid; ?>" readonly></td>
                        <td nowrap><input type="text" class="form-control input-sm" name="ItemName[]" value='<?php echo htmlspecialchars($itemname, ENT_QUOTES); ?>' readonly></td>
                        <td nowrap><input type="text" class="form-control input-sm" name="PMCode[]" value="<?php echo $pmcode; ?>" readonly></td>
                        <td nowrap><input type="text" class="form-control input-sm" name="UOM[]" value="<?php echo $uom; ?>" readonly></td>
                        <td nowrap><input type="text" class="form-control input-sm text-right" name="Qty[]" value="<?php echo number_format($qty, 2, '.', ''); ?>"></td>
                        <td nowrap><input type="text" class="form-control input-sm text-right" name="UnitPrice[]" value="<?php echo number_format($unitprice, 4, '.', ''); ?>"></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>

              <hr>

              <div class="form-actions">
                <div class="col-md-6">
                  <button type="submit" class="col-md-2 btn btn-primary">Update</button>
                  <a type="button" class="col-md-2 btn btn-default" href="<?php echo site_url('purchasing/item_price'); ?>">Cancel</a>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>