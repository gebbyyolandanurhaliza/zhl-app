<?php error_reporting(0) ?>


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
              <i class="fa fa-cogs theme-font"></i>
              <span class="caption-subject theme-font bold">Master Customer</span>
            </div>
            <div class="tools">
              <a href="javascript:;" class="collapse"></a>
              <a href="javascript:;" class="reload"></a>
            </div>
          </div>
          <div class="portlet-body form">
            <form action="<?php echo site_url('purchasing/customer_save/add'); ?>" method="post" class="form-horizontal" role="form">
              <div class="form-body">
                <div class="row">
                  <div class="col-md-12">
                    <div class="col-md-6">
                      <div class="form-group" style="margin-bottom:1px;">
                        <label class="col-md-4 label-sm">Customer ID</label>
                        <div class="col-md-5">
                          <input class="form-control input-sm" name="customerid" required>
                        </div>
                      </div>
                      <div class="form-group " style="margin-bottom:1px;">
                        <label class="col-md-4 label-sm">Customer Name</label>
                        <div class="col-md-7">
                          <input class="form-control input-sm" name="customername" required>
                        </div>
                      </div>
                      <div class="form-group " style="margin-bottom:1px;">
                        <label class="col-md-4 label-sm">Customer Company</label>
                        <div class="col-md-7">
                          <input class="form-control input-sm" name="customercompany" required>
                        </div>
                      </div>
                      <div class="form-group" style="margin-bottom:1px;">
                        <label class="col-md-4 label-sm">Contact Person</label>
                        <div class="col-md-5">
                          <input class="form-control input-sm" name="contact">
                        </div>
                      </div>
                      <div class="form-group" style="margin-bottom:1px;">
                        <label class="col-md-4 label-sm">Address</label>
                        <div class="col-md-7">
                          <textarea class="form-control" name="address"></textarea>
                        </div>
                      </div>
                      <div class="form-group" style="margin-bottom:1px;">
                        <label class="col-md-4 label-sm">Telephone</label>
                        <div class="col-md-5">
                          <input class="form-control input-sm" name="telephone">
                        </div>
                      </div>
                      <div class="form-group" style="margin-bottom:1px;">
                        <label class="col-md-4 label-sm">Mobile Phone</label>
                        <div class="col-md-5">
                          <input class="form-control input-sm" name="mobile">
                        </div>
                      </div>
                      <div class="form-group" style="margin-bottom:1px;">
                        <label class="col-md-4 label-sm">Fax</label>
                        <div class="col-md-5">
                          <input class="form-control input-sm" name="fax">
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group" style="margin-bottom:1px;">
                        <label class="col-md-4 col-md-push-2 label-sm">Email</label>
                        <div class="col-md-5 col-md-push-2">
                          <input class="form-control input-sm" name="email">
                        </div>
                      </div>
                      <div class="form-group" style="margin-bottom:1px;">
                        <label class="col-md-4 col-md-push-2 label-sm">Term</label>
                        <div class="col-md-5 col-md-push-2">
                          <input class="form-control input-sm" name="term">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="form-actions">
                <div class="col-md-3 col-md-push-9">
                  <button type="submit" class="col-md-5 btn btn-primary">Save</button>
                  <button type="reset" class="col-md-5 btn btn-default">Cancel</button>
                </div>
              </div>
            </form>
          </div>
        </div>

        <div class="portlet light">
          <div class="portlet-title">
            <div class="caption">
              <i class="fa fa-list theme-font"></i>
              <span class="caption-subject theme-font bold">List Customer</span>
            </div>
            <div class="tools">
              <a href="javascript:;" class="collapse"></a>
              <a href="javascript:;" class="reload"></a>
            </div>
          </div>
          <div class="portlet-body">
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label class="col-md-1 label-sm">Customer</label>
                  <div class="col-md-3">
                    <input class="form-control input-sm" id="search">
                  </div>
                  <div class="col-md-5">
                    <button class="btn btn-primary btn-sm" onclick="search()">Refresh</button>
                  </div>
                </div>
              </div>
            </div>

            <div class="table-scrollable" style="overflow: auto;">
              <table class="table table-bordered table-condensed" id="table">
                <thead>
                  <tr>
                    <th class="text-center">Actions</th>
                    <th class="text-center">Customer ID</th>
                    <th class="text-center">Customer Name</th>
                    <th class="text-center">Customer Company</th>
                    <th class="text-center">Contact Person</th>
                    <th class="text-center">Address</th>
                    <th class="text-center">Telephone</th>
                    <th class="text-center">Mobile Phone</th>
                    <th class="text-center">Fax</th>
                    <th class="text-center">Email</th>
                    <th class="text-center">Term</th>
                    <th class="text-center">Created By</th>
                    <th class="text-center">Created Date</th>
                    <th class="text-center">Updated By</th>
                    <th class="text-center">Updated Date</th>
                  </tr>
                </thead>
                <tbody id="tbl-mon">
                  <?php $start = 0;
                  foreach ($cust as $r) { ?>
                    <tr style="cursor: pointer;">
                      <td nowrap>
                        <a class="btn-sm btn-warning" href="<?php echo site_url('purchasing/customer_edit?cust=' . $r->customer_id); ?>"><i class="fa fa-pencil"></i></a>
                        <a class="btn-sm btn-danger" href="<?php echo site_url('purchasing/customer_delete?cust=' . $r->customer_id); ?>" onclick="javasciprt: return confirm('Are you sure delete customer <?php echo $r->customer_name; ?> ?')"><i class="fa fa-trash"></i></a>
                      </td>
                      <td nowrap><?php echo $r->customer_code; ?></td>
                      <td nowrap><?php echo $r->customer_name; ?></td>
                      <td nowrap><?php echo $r->customer_company_name; ?></td>
                      <td nowrap><?php echo $r->customer_contact_name; ?></td>
                      <td nowrap><?php echo $r->customer_address; ?></td>
                      <td nowrap><?php echo $r->customer_phone; ?></td>
                      <td nowrap><?php echo $r->customer_mobilephone; ?></td>
                      <td nowrap><?php echo $r->customer_fax; ?></td>
                      <td nowrap><?php echo $r->customer_email; ?></td>
                      <td nowrap><?php echo $r->customer_term; ?></td>
                      <td nowrap><?php echo $r->created_by; ?></td>
                      <td nowrap><?php echo $r->created_date; ?></td>
                      <td nowrap><?php echo $r->updated_by; ?></td>
                      <td nowrap><?php echo $r->updated_date; ?></td>
                    </tr>
                  <?php
                  }
                  ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>

<script>
  $(document).ready(function() {
    //     $("#search").keyup(function(){
    //         _this = this;
    //        $.each($("#table tbody tr"), function() {
    //            if($(this).text().toLowerCase().indexOf($(_this).val().toLowerCase()) === -1)
    //               $(this).hide();
    //            else
    //               $(this).show();                
    //        });
    //    });

    $('#tbl-mon tr').each(function(a, b) {
      $(b).click(function() {
        $('#tbl-mon tr').css('color', '#000000');
        $(this).css('color', '#0000FF');
      });
    });
  });
</script>

<script>
  function search() {
    $search = document.getElementById('search').value;

    $.ajax({
      url: "<?php echo base_url(); ?>purchasing/customer_search?cust=" + $search + "",
      success: function(response) {
        $("#tbl-mon").html(response);
      },
      dataType: "html"
    });

    return false;
  }
</script>