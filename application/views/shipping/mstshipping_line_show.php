<?php
error_reporting(0)
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
        <div class="col-md-12">
          <div class="portlet light">
            <div class="portlet-title">
              <div class="caption">
                <i class="fa fa-cogs theme-font"></i>
                <span class="caption-subject theme-font bold">Master Shipping Liner and Forwarder</span>
              </div>
              <div class="tools">
                <a href="javascript:;" class="collapse"></a>
                <a href="javascript:;" class="reload"></a>
              </div>
            </div>
            <div class="portlet-body form">
              <form action="<?php echo site_url('shipping/shipping_liner_save'); ?>" method="post" class="form-horizontal" role="form">
                <div class="form-body">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group" style="margin-bottom:1px;">
                        <div class="col-md-3">
                          <input type="hidden" class="form-control input-sm" name="shippingid" value="<?php echo $shipping_liner->shipping_id; ?>" readonly>
                        </div>
                      </div>
                      <div class="form-group " style="margin-bottom:1px;">
                        <label class="col-md-2 label-sm">Shipping Name</label>
                        <div class="col-md-3">
                          <input class="form-control input-sm" name="shippingname" value="<?php echo $shipping_liner->shipping_name; ?>">
                        </div>
                      </div>
                      <div class="form-group " style="margin-bottom:1px;">
                        <label class="col-md-2 label-sm">Shipping Tipe</label>
                        <div class="col-md-5">
                          <select class="form-control" name="shippingtipe">
                            <option value="1" <?php if ($shipping_liner->shipping_tipe == 1) {
                                                echo "selected";
                                              } ?>>Shipping Liner</option>
                            <option value="2" <?php if ($shipping_liner->shipping_tipe == 2) {
                                                echo "selected";
                                              } ?>>Forwarder</option>
                          </select>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="form-actions">
                  <div class="col-md-5 col-md-offset-2">
                    <button type="submit" class="col-md-3 btn btn-primary">Update</button>
                    <a type="button" class="col-md-3 btn btn-default" href="<?php echo site_url('shipping/shipping_liner'); ?>">Cancel</a>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>