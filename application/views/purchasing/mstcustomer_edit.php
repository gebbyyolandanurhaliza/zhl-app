<!-- <link href="<?php echo base_url(); ?>assets/admin/css/cloud-admin.css" rel="stylesheet" type="text/css"> -->

<div class="page-content">
  <div class="container-fluid">

    <div class="row">
      <div class="col-md-12">
        <div class="portlet light">
          <div class="portlet-title">
            <div class="caption">
              <i class="fa fa-cogs theme-font"></i>
              <span class="caption-subject theme-font bold">Master Customer</span>
            </div>
            <div class="tools">
              <a href="javascript:;" class="collapse"></a>
              <a href="javascript:;" class="reload"></a>
            </div>
          </div>
          <div class="portlet-body form">
            <form action="<?php echo site_url('purchasing/customer_save/update'); ?>" method="post" class="form-horizontal" role="form">
              <div class="form-body">
                <div class="row">
                  <div class="col-md-12">
                    <div class="col-md-6">
                      <div class="form-group" style="margin-bottom:1px;">
                        <label class="col-md-4 label-sm">Customer ID</label>
                        <div class="col-md-5">
                          <input class="form-control input-sm" name="customerid" readonly value="<?php echo $cust->customer_code; ?>">
                        </div>
                      </div>
                      <div class="form-group" style="margin-bottom:1px;">
                        <label class="col-md-4 label-sm">Customer Name</label>
                        <div class="col-md-5">
                          <input class="form-control input-sm" name="customername" value="<?php echo $cust->customer_name; ?>">
                        </div>
                      </div>
                      <div class="form-group " style="margin-bottom:1px;">
                        <label class="col-md-4 label-sm">Customer Company</label>
                        <div class="col-md-7">
                          <input class="form-control input-sm" name="customercompany" value="<?php echo $cust->customer_company_name; ?>">
                        </div>
                      </div>
                      <div class="form-group" style="margin-bottom:1px;">
                        <label class="col-md-4 label-sm">Contact Person</label>
                        <div class="col-md-5">
                          <input class="form-control input-sm" name="contact" value="<?php echo $cust->customer_contact_name; ?>">
                        </div>
                      </div>
                      <div class="form-group" style="margin-bottom:1px;">
                        <label class="col-md-4 label-sm">Address</label>
                        <div class="col-md-7">
                          <textarea class="form-control" name="address"><?php echo str_replace("<br />", "", $cust->customer_address); ?></textarea>
                        </div>
                      </div>
                      <div class="form-group" style="margin-bottom:1px;">
                        <label class="col-md-4 label-sm">Telephone</label>
                        <div class="col-md-5">
                          <input class="form-control input-sm" name="telephone" value="<?php echo $cust->customer_phone; ?>">
                        </div>
                      </div>
                      <div class="form-group" style="margin-bottom:1px;">
                        <label class="col-md-4 label-sm">Mobile Phone</label>
                        <div class="col-md-5">
                          <input class="form-control input-sm" name="mobile" value="<?php echo $cust->customer_mobilephone; ?>">
                        </div>
                      </div>
                      <div class="form-group" style="margin-bottom:1px;">
                        <label class="col-md-4 label-sm">Fax</label>
                        <div class="col-md-5">
                          <input class="form-control input-sm" name="fax" value="<?php echo $cust->customer_fax; ?>">
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group" style="margin-bottom:1px;">
                        <label class="col-md-4 col-md-push-2 label-sm">Email</label>
                        <div class="col-md-5 col-md-push-2">
                          <input class="form-control input-sm" name="email" value="<?php echo  $cust->customer_email; ?>">
                        </div>
                      </div>
                      <div class="form-group" style="margin-bottom:1px;">
                        <label class="col-md-4 col-md-push-2 label-sm">Term</label>
                        <div class="col-md-5 col-md-push-2">
                          <input class="form-control input-sm" name="term" value="<?php echo  $cust->customer_term; ?>">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="form-actions">
                <div class="col-md-3 col-md-push-9">
                  <button type="submit" class="col-md-5 btn btn-primary">Update</button>
                  <a type="button" class="col-md-5 btn btn-default" href="<?php echo site_url('purchasing/customer'); ?>">Cancel</a>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>