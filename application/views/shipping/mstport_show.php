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
                <span class="caption-subject theme-font bold">Master Port</span>
              </div>
              <div class="tools">
                <a href="javascript:;" class="collapse"></a>
                <a href="javascript:;" class="reload"></a>
              </div>
            </div>
            <div class="portlet-body form">
              <form action="<?php echo site_url('shipping/port_save'); ?>" method="post" class="form-horizontal" role="form">
                <div class="form-body">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group" style="margin-bottom:1px;">
                        <!--<label class="col-md-2 label-sm">Port ID</label>-->
                        <div class="col-md-3">
                          <input type="hidden" class="form-control input-sm" name="portid" value="<?php echo $port->port_id; ?>" readonly>
                        </div>
                      </div>
                      <div class="form-group " style="margin-bottom:1px;">
                        <label class="col-md-2 label-sm">Port Code</label>
                        <div class="col-md-3">
                          <input class="form-control input-sm" name="code" value="<?php echo $port->port_code; ?>">
                        </div>
                      </div>
                      <div class="form-group " style="margin-bottom:1px;">
                        <label class="col-md-2 label-sm">Port Name</label>
                        <div class="col-md-3">
                          <input class="form-control input-sm" name="name" value="<?php echo $port->port_name; ?>">
                        </div>
                      </div>
                      <div class="form-group " style="margin-bottom:1px;">
                        <label class="col-md-2 label-sm">Country</label>
                        <div class="col-md-5">
                          <select class="form-control select2me" data-placeholder="Country" name="country">
                            <option value="<?php echo $port->country_ids; ?>"><?php echo $port->country_name; ?></option>
                            <?php
                            foreach ($country as $r) {
                              if ($port->country_ids != $r->country_ids) {
                                echo '<option value="' . $r->country_ids . '">' . $r->country_name . '</option>';
                              }
                            }
                            ?>
                          </select>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="form-actions">
                  <div class="col-md-5 col-md-offset-2">
                    <button type="submit" class="col-md-3 btn btn-primary">Update</button>
                    <a type="button" class="col-md-3 btn btn-default" href="<?php echo site_url('shipping/port'); ?>">Cancel</a>
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