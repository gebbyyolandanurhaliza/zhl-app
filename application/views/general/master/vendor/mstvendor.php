<?php
error_reporting(0)
?>
<script type="text/javascript">
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
              <span class="caption-subject theme-font bold">Master Vendor</span>
            </div>
            <div class="tools">
              <a href="javascript:;" class="collapse"></a>
              <a href="javascript:;" class="reload"></a>
            </div>
          </div>
          <div class="portlet-body form">
            <form action="<?php echo site_url('purchasing/vendor_save/add'); ?>" method="post" class="form-horizontal" role="form">
              <div class="form-body">
                <div class="row">
                  <div class="col-md-12">
                    <div class="col-md-6">
                      <div class="form-group" style="margin-bottom:1px;">
                        <label class="col-md-4 label-sm">Vendor ID</label>
                        <div class="col-md-3">
                          <input type="text" class="form-control input-sm" name="vendorid" required>
                        </div>
                      </div>
                      <div class="form-group " style="margin-bottom:1px;">
                        <label class="col-md-4 label-sm">Vendor Company</label>
                        <div class="col-md-7">
                          <input class="form-control input-sm" name="vendorcompany" required>
                        </div>
                      </div>
                      <div class="form-group" style="margin-bottom:1px;">
                        <label class="col-md-4 label-sm">Address</label>
                        <div class="col-md-7">
                          <textarea class="form-control autosizeme" name="address"></textarea>
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
                        <label class="col-md-4 label-sm">DID</label>
                        <div class="col-md-5">
                          <input class="form-control input-sm" name="did">
                        </div>
                      </div>
                      <div class="form-group" style="margin-bottom:1px;">
                        <label class="col-md-4 label-sm">Fax</label>
                        <div class="col-md-5">
                          <input class="form-control input-sm" name="fax">
                        </div>
                      </div>
                      <div class="form-group" style="margin-bottom:1px;">
                        <label class="col-md-4 label-sm">Postal Code</label>
                        <div class="col-md-3">
                          <input class="form-control input-sm" name="postal">
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
                              echo '<option value=' . $r->id . '>' . $r->group . '</option>';
                            }

                            ?>
                          </select>
                        </div>
                      </div>
                      <div class="form-group" style="margin-bottom:1px;">
                        <label class="col-md-4 col-md-push-2 label-sm">Contact Person</label>
                        <div class="col-md-5 col-md-push-2">
                          <input class="form-control input-sm" name="contact">
                        </div>
                      </div>
                      <div class="form-group" style="margin-bottom:1px;">
                        <label class="col-md-4 col-md-push-2 label-sm">Email</label>
                        <div class="col-md-5 col-md-push-2">
                          <input class="form-control input-sm" name="email">
                        </div>
                      </div>
                      <div class="form-group" style="margin-bottom:1px;">
                        <label class="col-md-4 col-md-push-2 label-sm">Website</label>
                        <div class="col-md-5 col-md-push-2">
                          <input class="form-control input-sm" name="website">
                        </div>
                      </div>
                      <div class="form-group" style="margin-bottom:1px;">
                        <label class="col-md-4 col-md-push-2 label-sm">Payment Term</label>
                        <div class="col-md-5 col-md-push-2">
                          <input class="form-control input-sm" name="term">
                        </div>
                      </div>
                      <div class="form-group" style="margin-bottom:1px;">
                        <label class="col-md-4 col-md-push-2 label-sm">Tax</label>
                        <div class="col-md-5 col-md-push-2">
                          <div class="input-group">
                            <input class="form-control input-sm text-right" name="taxprice" value="0">
                            <span class="input-group-addon">
                              %
                            </span>
                            <input class="form-control input-sm" name="taxcode" placeholder="Tax Code">
                          </div>
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
              <span class="caption-subject theme-font bold">List Vendor</span>
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
                  <label class="col-md-1 label-sm">Vendor</label>
                  <div class="col-md-3">
                    <input class="form-control input-sm" id="search">
                  </div>
                  <div class="col-md-5">
                    <button class="btn btn-primary btn-sm" onclick="search()">Refresh</button>
                  </div>
                </div>
              </div>
            </div>

            <div class="table-scrollable" style="overflow: auto; height:400px;">
              <table id="table" class="table table-bordered table-condensed">
                <thead>
                  <tr>
                    <th class="text-center">Actions</th>
                    <th class="text-center">Vendor ID</th>
                    <th class="text-center">Vendor Company</th>
                    <th class="text-center">Address</th>
                    <th class="text-center">Telephone</th>
                    <th class="text-center">Mobile Phone</th>
                    <th class="text-center">DID</th>
                    <th class="text-center">Fax</th>
                    <th class="text-center">Postal</th>
                    <th class="text-center">Group Vendor</th>
                    <th class="text-center">Contact Person</th>
                    <th class="text-center">Email</th>
                    <th class="text-center">Website</th>
                    <th class="text-center">Payment Term</th>
                    <th class="text-center">Tax</th>
                    <th class="text-center">Tax Price</th>
                    <th class="text-center">Created By</th>
                    <th class="text-center">Created Date</th>
                    <th class="text-center">Updated By</th>
                    <th class="text-center">Updated Date</th>
                  </tr>

                </thead>
                <tbody id="tbl-mon">
                  <?php $start = 0;
                  foreach ($vendor_data as $r) { ?>
                    <tr style="cursor: pointer;">
                      <td nowrap>
                        <a class="btn-sm btn-warning" href="<?php echo site_url('purchasing/vendor_edit?vendor=' . $r->supplierid); ?>"><i class="fa fa-pencil"></i></a>
                        <a class="btn-sm btn-danger" href="<?php echo site_url('master/vendor_delete?vendor=' . $r->supplierid); ?>" onclick="javasciprt: return confirm('Are you sure delete Company <?php echo $r->suppliercompany; ?> ?')"><i class="fa fa-trash"></i></a>
                      </td>
                      <td nowrap><?php echo $r->supplierid; ?></td>
                      <td nowrap><?php echo $r->suppliercompany; ?></td>
                      <td nowrap><?php echo $r->address; ?></td>
                      <td nowrap><?php echo $r->telephone; ?></td>
                      <td nowrap><?php echo $r->mobilephone; ?></td>
                      <td nowrap><?php echo $r->did; ?></td>
                      <td nowrap><?php echo $r->fax; ?></td>
                      <td nowrap><?php echo $r->postalcode; ?></td>
                      <td nowrap><?php echo $r->group; ?></td>
                      <td nowrap><?php echo $r->contactperson; ?></td>
                      <td nowrap><?php echo $r->email; ?></td>
                      <td nowrap><?php echo $r->website; ?></td>
                      <td nowrap><?php echo $r->paymentterm; ?></td>
                      <td nowrap><?php echo $r->taxcode; ?></td>
                      <td nowrap><?php echo $r->taxprice; ?></td>
                      <td nowrap><?php echo $r->createdby; ?></td>
                      <td nowrap><?php echo $r->createddate; ?></td>
                      <td nowrap><?php echo $r->lastupdatedby; ?></td>
                      <td nowrap><?php echo $r->lastupdateddate; ?></td>
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
  function search() {
    $search = document.getElementById('search').value;

    $.ajax({
      url: "<?php echo base_url(); ?>purchasing/vendor_search?vendor=" + $search + "",
      success: function(response) {
        $("#tbl-mon").html(response);
      },
      dataType: "html"
    });

    return false;
  }
</script>