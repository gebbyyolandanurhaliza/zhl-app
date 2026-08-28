<?php
error_reporting(0)
?>
<script>
  $(document).ready(function() {
    $("#search").keyup(function() {
      _this = this;
      $.each($("#table tbody tr"), function() {
        if ($(this).text().toLowerCase().indexOf($(_this).val().toLowerCase()) === -1)
          $(this).hide();
        else
          $(this).show();
      });
    });

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
                          <input type="hidden" class="form-control input-sm" name="shippingid" readonly>
                        </div>
                      </div>
                      <div class="form-group " style="margin-bottom:1px;">
                        <label class="col-md-2 label-sm">Shipping Name</label>
                        <div class="col-md-3">
                          <input class="form-control input-sm" name="shippingname" required>
                        </div>
                      </div>
                      <div class="form-group " style="margin-bottom:1px;">
                        <label class="col-md-2 label-sm">Shipping Tipe</label>
                        <div class="col-md-3">
                          <select class="form-control" name="shippingtipe">
                            <option value="1">Shipping Liner</option>
                            <option value="2">Forwarder</option>
                          </select>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="form-actions">
                  <div class="col-md-5 col-md-offset-2">
                    <button type="submit" class="col-md-3 btn btn-primary" id="savebtn">Save</button>
                    <a type="button" class="col-md-3 btn btn-default" href="<?php echo site_url('shipping/shipping_liner'); ?>">Cancel</a>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
        <div class="col-md-12">
          <div class="portlet light">
            <div class="portlet-title">
              <div class="caption">
                <i class="fa fa-list theme-font"></i>
                <span class="caption-subject theme-font bold">List Shipping Liner and Forwarder</span>
              </div>
              <div class="tools">
                <a href="javascript:;" class="collapse"></a>
                <a href="javascript:;" class="reload"></a>
              </div>
            </div>
            <div class="portlet-body form">
              <div class="portlet-body">
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label class="col-md-2 col-md-push-6 label-sm">Search</label>
                      <div class="col-md-4 col-md-push-6">
                        <input class="form-control input-sm" id="search">
                      </div>
                    </div>
                  </div>
                </div>

                <div class="table-scrollable" style="overflow: auto; height:400px;">
                  <table class="table table-bordered" id="table">
                    <thead>
                      <tr>
                        <th class="text-center">Actions</th>
                        <th class="text-center">Shipping Name</th>
                        <th class="text-center">Shipping Tipe</th>
                        <th class="text-center">Created By</th>
                        <th class="text-center">Created Date</th>
                        <th class="text-center">Updated By</th>
                        <th class="text-center">Updated Date</th>
                      </tr>
                    </thead>
                    <tbody id="tbl-mon">
                      <?php foreach ($shipping_liner as $r) { ?>
                        <tr style="cursor: pointer;">
                          <td width="10px">
                            <a class="btn-sm btn-warning" href="<?php echo site_url('shipping/shipping_liner_show?line=' . $r->shipping_id); ?>"><i class="fa fa-pencil"></i></a>
                            <a class="btn-sm btn-danger" href="<?php echo site_url('shipping/shipping_liner_delete?line=' . $r->shipping_id); ?>" onclick="javasciprt: return confirm('Are you sure delete  <?php echo $r->shipping_name; ?> ?')"><i class="fa fa-trash"></i></a>
                          </td>
                          <td nowrap><?php echo $r->shipping_name; ?></td>
                          <td nowrap><?php echo ($r->shipping_tipe == 2 ? 'Forwarder' : 'Shipping Liner') ?></td>
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
  </div>
</div>

<script type="text/javascript">
  function reset() {
    document.getElementById('groupid').value = '';
    document.getElementById('groupname').value = '';
    document.getElementById('savebtn').innerHTML = 'Save';
  }

  function clickdb(x) {
    function getText(el) {
      if (typeof el.textContent == 'string') return el.textContent;
      if (typeof el.innerText == 'string') return el.innerText;
    }

    $r = x.rowIndex;
    document.getElementById('groupid').value = getText(document.getElementById('table').rows[$r].cells[1]);
    document.getElementById('groupname').value = getText(document.getElementById('table').rows[$r].cells[2]);
    document.getElementById('savebtn').innerHTML = 'Update';
  }
</script>