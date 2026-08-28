<!-- <link href="<?php echo base_url(); ?>assets/admin/css/cloud-admin.css" rel="stylesheet" type="text/css"> -->

<div class="page-content">
  <div class="container-fluid">

    <div class="row">
      <div class="col-md-12">
        <div class="portlet light">
          <div class="portlet-title">
            <div class="caption">
              <i class="fa fa-cogs theme-font"></i>
              <span class="caption-subject theme-font bold">Master Vendor ZHT</span>
            </div>
            <div class="tools">
              <a href="javascript:;" class="collapse"></a>
              <a href="javascript:;" class="reload"></a>
            </div>
          </div>
          <div class="portlet-body form">
            <form action="<?php echo site_url('purchasing_zht/vendor_save/update'); ?>" method="post" class="form-horizontal" role="form">
              <div class="form-body">
                <div class="row">
                  <div class="col-md-12">
                    <div class="col-md-6">
                      <div class="form-group" style="margin-bottom:1px;">
                        <label class="col-md-4 label-sm">Vendor ID</label>
                        <div class="col-md-3">
                          <input class="form-control input-sm" name="vendorid" value="<?php echo $supp->supplierid; ?>" readonly required>
                        </div>
                      </div>
                      <div class="form-group " style="margin-bottom:1px;">
                        <label class="col-md-4 label-sm">Vendor Company</label>
                        <div class="col-md-7">
                          <input class="form-control input-sm" name="vendorcompany" value="<?php echo $supp->suppliercompany; ?>" required>
                        </div>
                      </div>
                      <div class="form-group" style="margin-bottom:1px;">
                        <label class="col-md-4 label-sm">Address</label>
                        <div class="col-md-7">
                          <textarea class="form-control" name="address"><?php echo str_replace("<br />", "", $supp->address); ?></textarea>
                        </div>
                      </div>
                      <div class="form-group" style="margin-bottom:1px;">
                        <label class="col-md-4 label-sm">Telephone</label>
                        <div class="col-md-5">
                          <input class="form-control input-sm" name="telephone" value="<?php echo $supp->telephone; ?>">
                        </div>
                      </div>
                      <div class="form-group" style="margin-bottom:1px;">
                        <label class="col-md-4 label-sm">Mobile Phone</label>
                        <div class="col-md-5">
                          <input class="form-control input-sm" name="mobile" value="<?php echo $supp->mobilephone; ?>">
                        </div>
                      </div>
                      <div class="form-group" style="margin-bottom:1px;">
                        <label class="col-md-4 label-sm">DID</label>
                        <div class="col-md-5">
                          <input class="form-control input-sm" name="did" value="<?php echo $supp->did; ?>">
                        </div>
                      </div>
                      <div class="form-group" style="margin-bottom:1px;">
                        <label class="col-md-4 label-sm">Fax</label>
                        <div class="col-md-5">
                          <input class="form-control input-sm" name="fax" value="<?php echo $supp->fax; ?>">
                        </div>
                      </div>
                      <div class="form-group" style="margin-bottom:1px;">
                        <label class="col-md-4 label-sm">Postal Code</label>
                        <div class="col-md-3">
                          <input class="form-control input-sm" name="postal" value="<?php echo $supp->postalcode; ?>">
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group" style="margin-bottom:1px;">
                        <label class="col-md-4 col-md-push-2 label-sm">Group Vendor</label>
                        <div class="col-md-5 col-md-push-2">
                          <select class="form-control" data-placeholder="Group Vendor" name="group" required>
                            <option value=''>Select Vendor Group</option>
                            <?php
                            foreach ($group as $r) {
                              if ($supp->groupid == $r->id) {
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
                          <input class="form-control input-sm" name="contact" value="<?php echo $supp->contactperson; ?>">
                        </div>
                      </div>
                      <div class="form-group" style="margin-bottom:1px;">
                        <label class="col-md-4 col-md-push-2 label-sm">Email</label>
                        <div class="col-md-5 col-md-push-2">
                          <input class="form-control input-sm" name="email" value="<?php echo $supp->email; ?>">
                        </div>
                      </div>
                      <div class="form-group" style="margin-bottom:1px;">
                        <label class="col-md-4 col-md-push-2 label-sm">Website</label>
                        <div class="col-md-5 col-md-push-2">
                          <input class="form-control input-sm" name="website" value="<?php echo $supp->website; ?>">
                        </div>
                      </div>
                      <div class="form-group" style="margin-bottom:1px;">
                        <label class="col-md-4 col-md-push-2 label-sm">Payment Term</label>
                        <div class="col-md-5 col-md-push-2">
                          <input class="form-control input-sm" name="term" value="<?php echo $supp->paymentterm; ?>">
                        </div>
                      </div>
                      <div class="form-group" style="margin-bottom:1px;">
                        <label class="col-md-4 col-md-push-2 label-sm">Tax</label>
                        <div class="col-md-5 col-md-push-2">
                          <div class="input-group">
                            <input class="form-control col-md-2 input-sm text-right" name="taxprice" value="<?php echo $supp->taxprice; ?>">
                            <span class="input-group-addon">
                              %
                            </span>
                            <input class="form-control input-sm" name="taxcode" value="<?php echo $supp->taxcode; ?>" placeholder="Tax Code">
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
                  <a type="button" class="col-md-5 btn btn-default" href="<?php echo site_url('purchasing_zht/vendor_zht'); ?>">Cancel</a>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>