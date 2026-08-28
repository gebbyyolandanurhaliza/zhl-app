<!-- <link href="<?php echo base_url(); ?>assets/admin/css/cloud-admin.css" rel="stylesheet" type="text/css"> -->

<div class="page-content">
  <div class="container-fluid">

    <div class="row">
      <div class="col-md-12">
        <div class="portlet light">
          <div class="portlet-title">
            <div class="caption">
              <i class="fa fa-cogs theme-font"></i>
              <span class="caption-subject theme-font bold">Master Vendor</span>
            </div>
            <div class="tools">
              <a href="javascript:;" class="collapse"></a>
              <a href="javascript:;" class="reload"></a>
            </div>
          </div>
          <div class="portlet-body form">
            <form action="<?php echo site_url('purchasing/pur_vendor_save/update'); ?>" method="post" class="form-horizontal" role="form">
              <div class="form-body">
                <div class="row">
                  <div class="col-md-12">
                    <div class="col-md-6">
                      <div class="form-group" style="margin-bottom:1px;">
                        <label class="col-md-4 label-sm">Vendor ID</label>
                        <div class="col-md-3">
                          <input class="form-control input-sm" name="vendorid" value="<?php echo $vendor->vendorid; ?>" readonly>
                        </div>
                      </div>
                      <div class="form-group " style="margin-bottom:1px;">
                        <label class="col-md-4 label-sm">Vendor Company</label>
                        <div class="col-md-7">
                          <input class="form-control input-sm" name="vendorcompany" value="<?php echo $vendor->vendorcompany; ?>" required>
                        </div>
                      </div>
                      <div class="form-group" style="margin-bottom:1px;">
                        <label class="col-md-4 label-sm">Address</label>
                        <div class="col-md-7">
                          <textarea class="form-control" name="address"><?php echo str_replace("<br />", "", $vendor->address); ?></textarea>
                        </div>
                      </div>
                      <div class="form-group" style="margin-bottom:1px;">
                        <label class="col-md-4 label-sm">Telephone</label>
                        <div class="col-md-5">
                          <input class="form-control input-sm" name="telephone" value="<?php echo $vendor->telephone; ?>">
                        </div>
                      </div>
                      <div class="form-group" style="margin-bottom:1px;">
                        <label class="col-md-4 label-sm">Mobile Phone</label>
                        <div class="col-md-5">
                          <input class="form-control input-sm" name="mobile" value="<?php echo $vendor->mobilephone; ?>">
                        </div>
                      </div>
                      <div class="form-group" style="margin-bottom:1px;">
                        <label class="col-md-4 label-sm">DID</label>
                        <div class="col-md-5">
                          <input class="form-control input-sm" name="did" value="<?php echo $vendor->did; ?>">
                        </div>
                      </div>
                      <div class="form-group" style="margin-bottom:1px;">
                        <label class="col-md-4 label-sm">Fax</label>
                        <div class="col-md-5">
                          <input class="form-control input-sm" name="fax" value="<?php echo $vendor->fax; ?>">
                        </div>
                      </div>
                      <div class="form-group" style="margin-bottom:1px;">
                        <label class="col-md-4 label-sm">Postal Code</label>
                        <div class="col-md-3">
                          <input class="form-control input-sm" name="postal" value="<?php echo $vendor->postalcode; ?>">
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group" style="margin-bottom:1px;">
                        <label class="col-md-4 col-md-push-2 label-sm">Group Vendor</label>
                        <div class="col-md-5 col-md-push-2">
                          <select class="form-control" data-placeholder="Group Vendor" name="group" required>
                            <option value=''></option>
                            <?php
                            foreach ($group as $r) {
                              if ($vendor->groupid == $r->id) {
                                echo '<option value=' . $r->id . ' selected>' . $r->group . '</option>';
                              } else {
                                echo '<option value=' . $r->id . '>' . $r->group . '</option>';
                              }
                            }

                            ?>
                          </select>
                        </div>
                      </div>
                      <div class="form-group" style="margin-bottom:1px;">
                        <label class="col-md-4 col-md-push-2 label-sm">Contact Person</label>
                        <div class="col-md-5 col-md-push-2">
                          <input class="form-control input-sm" name="contact" value="<?php echo $vendor->contactperson; ?>">
                        </div>
                      </div>
                      <div class="form-group" style="margin-bottom:1px;">
                        <label class="col-md-4 col-md-push-2 label-sm">Email</label>
                        <div class="col-md-5 col-md-push-2">
                          <input class="form-control input-sm" name="email" value="<?php echo $vendor->email; ?>">
                        </div>
                      </div>
                      <div class="form-group" style="margin-bottom:1px;">
                        <label class="col-md-4 col-md-push-2 label-sm">Website</label>
                        <div class="col-md-5 col-md-push-2">
                          <input class="form-control input-sm" name="website" value="<?php echo $vendor->website; ?>">
                        </div>
                      </div>
                      <div class="form-group" style="margin-bottom:1px;">
                        <label class="col-md-4 col-md-push-2 label-sm">Payment Term</label>
                        <div class="col-md-5 col-md-push-2">
                          <input class="form-control input-sm" name="term" value="<?php echo $vendor->paymentterm; ?>">
                        </div>
                      </div>
                      <div class="form-group" style="margin-bottom:1px;">
                        <label class="col-md-4 col-md-push-2 label-sm">Tax</label>
                        <div class="col-md-5 col-md-push-2">
                          <div class="input-group">
                            <input class="form-control col-md-2 input-sm text-right" name="taxprice" value="<?php echo $vendor->taxprice; ?>">
                            <span class="input-group-addon">
                              %
                            </span>
                            <input class="form-control input-sm" name="taxcode" value="<?php echo $vendor->taxcode; ?>" placeholder="Tax Code">
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="form-actions">
                <div class="col-md-3 col-md-push-9">
                  <button type="submit" class="col-md-5 btn btn-primary">Update</button>
                  <a type="button" class="col-md-5 btn btn-default" href="<?php echo site_url('purchasing/vendor_pur'); ?>">Cancel</a>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>