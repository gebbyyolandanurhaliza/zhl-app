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
                <span class="caption-subject theme-font bold">Master Item Category</span>
              </div>
              <div class="tools">
                <a href="javascript:;" class="collapse"></a>
                <a href="javascript:;" class="reload"></a>
              </div>
            </div>
            <div class="portlet-body form">
              <form action="<?php echo site_url('purchasing/item_group_save'); ?>" method="post" class="form-horizontal" role="form">
                <div class="form-body">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group" style="margin-bottom:1px;">
                        <!--<label class="col-md-2 label-sm">Category ID</label>-->
                        <div class="col-md-3">
                          <input type="hidden" class="form-control input-sm" name="groupid" value="<?php echo $group->categoryid; ?>" readonly>
                        </div>
                      </div>
                      <div class="form-group " style="margin-bottom:1px;">
                        <label class="col-md-2 label-sm">Category Name</label>
                        <div class="col-md-3">
                          <input class="form-control input-sm" name="groupname" value="<?php echo $group->categoryname; ?>">
                        </div>
                      </div>
                      <div class="form-group " style="margin-bottom:1px;">
                        <label class="col-md-2 label-sm">G/L Account Inventory</label>
                        <div class="col-md-5">
                          <select class="form-control select2me" data-placeholder="G/L Account" name="coainv">
                            <option value="<?php echo $group->nocoainv; ?>"><?php echo $group->nocoainv . ' - ' . $group->AccountNameinv; ?></option>
                            <?php
                            foreach ($coainv as $r) {
                              if ($group->nocoainv != $r->NoCOA) {
                                echo '<option value="' . $r->NoCOA . '">' . $r->NoCOA . ' - ' . $r->AccountName . '</option>';
                              }
                            }
                            ?>
                          </select>
                        </div>
                      </div>
                      <div class="form-group " style="margin-bottom:1px;">
                        <label class="col-md-2 label-sm">G/L Account COGS</label>
                        <div class="col-md-5">
                          <select class="form-control select2me" data-placeholder="G/L Account" name="coags">
                            <option value="<?php echo $group->nocoags; ?>"><?php echo $group->nocoags . ' - ' . $group->AccountNamegs; ?></option>
                            <?php
                            foreach ($coags as $r) {
                              if ($group->nocoags != $r->NoCOA) {
                                echo '<option value="' . $r->NoCOA . '">' . $r->NoCOA . ' - ' . $r->AccountName . '</option>';
                              }
                            }
                            ?>
                          </select>
                        </div>
                      </div>

                      <div class="form-group " style="margin-bottom:1px;">
                        <label class="col-md-2 label-sm">G/L Account Sales</label>
                        <div class="col-md-5">
                          <select class="form-control select2me" data-placeholder="G/L Account" name="coasales">
                            <option value="<?php echo $group->nocoasales; ?>"><?php echo $group->nocoasales . ' - ' . $group->AccountNameSales; ?></option>
                            <?php
                            foreach ($coasales as $r) {
                              if ($group->nocoasales != $r->NoCOA) {
                                echo '<option value="' . $r->NoCOA . '">' . $r->NoCOA . ' - ' . $r->AccountName . '</option>';
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
                    <a type="button" class="col-md-3 btn btn-default" href="<?php echo site_url('purchasing/item_group'); ?>">Cancel</a>
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