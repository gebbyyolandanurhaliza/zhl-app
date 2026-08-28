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
        <div class="col-md-5">
          <div class="portlet light">
            <div class="portlet-title">
              <div class="caption">
                <i class="fa fa-cogs theme-font"></i>
                <span class="caption-subject theme-font bold">Master Warehouse</span>
              </div>
              <div class="tools">
                <a href="javascript:;" class="collapse"></a>
                <a href="javascript:;" class="reload"></a>
              </div>
            </div>
            <div class="portlet-body form">
              <form action="<?php echo site_url('purchasing/whs_save'); ?>" method="post" class="form-horizontal" role="form">
                <div class="form-body">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group" style="margin-bottom:1px;">
                        <label class="col-md-4 label-sm">Name</label>
                        <div class="col-md-7">
                          <input type="text" class="form-control input-sm" name="name" id="name">
                          <input type="hidden" name="id" id="id">
                        </div>
                      </div>
                      <div class="form-group" style="margin-bottom:1px;">
                        <label class="col-md-4 label-sm">Contact</label>
                        <div class="col-md-7">
                          <input type="text" class="form-control input-sm" name="contact" id="contact">
                        </div>
                      </div>
                      <div class="form-group " style="margin-bottom:1px;">
                        <label class="col-md-4 label-sm">Address</label>
                        <div class="col-md-7">
                          <textarea class="form-control autosizeme" name="address" id="address"></textarea>
                        </div>
                      </div>
                      <div class="form-group" style="margin-bottom:1px;">
                        <label class="col-md-4 label-sm">Telephone</label>
                        <div class="col-md-7">
                          <input type="text" class="form-control input-sm" name="telephone" id="telephone">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="form-actions">
                  <div class="col-md-5 col-md-push-7">
                    <button type="submit" class="col-md-5 btn btn-primary" id="savebtn">Save</button>
                    <a type="button" class="col-md-5 btn btn-default" onclick="reset()">Cancel</a>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
        <div class="col-md-7">
          <div class="portlet light">
            <div class="portlet-title">
              <div class="caption">
                <i class="fa fa-list theme-font"></i>
                <span class="caption-subject theme-font bold">List Warehouse</span>
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
                        <th class="text-center">Name</th>
                        <th class="text-center">Contact</th>
                        <th class="text-center">Address</th>
                        <th class="text-center">Telephone</th>
                        <th class="text-center">Created By</th>
                        <th class="text-center">Created Date</th>
                        <th class="text-center">Updated By</th>
                        <th class="text-center">Updated Date</th>
                      </tr>
                    </thead>
                    <tbody id="tbl-mon">
                      <?php foreach ($whs as $r) { ?>
                        <tr onclick="clickdb(this)" style="cursor: pointer;">
                          <td nowrap>
                            <a class="btn-sm btn-warning"><i class="fa fa-pencil"></i></a>
                            <a class="btn-sm btn-danger" href="<?php echo site_url('purchasing/whs_delete/' . $r->id); ?>" onclick="javasciprt: return confirm('Are you sure delete Warehouse <?php echo $r->name; ?> ?')"><i class="fa fa-trash"></i></a>
                          </td>
                          <td nowrap onclick="event.stopPropagation();return false;"><?php echo $r->name; ?></td>
                          <td nowrap onclick="event.stopPropagation();return false;"><?php echo $r->contact; ?></td>
                          <td nowrap onclick="event.stopPropagation();return false;"><?php echo $r->address; ?></td>
                          <td nowrap onclick="event.stopPropagation();return false;"><?php echo $r->telephone; ?></td>
                          <td hidden><?php echo $r->id; ?></td>
                          <td nowrap onclick="event.stopPropagation();return false;"><?php echo $r->createdby; ?></td>
                          <td nowrap onclick="event.stopPropagation();return false;"><?php echo $r->createddate; ?></td>
                          <td nowrap onclick="event.stopPropagation();return false;"><?php echo $r->lastupdatedby; ?></td>
                          <td nowrap onclick="event.stopPropagation();return false;"><?php echo $r->lastupdateddate; ?></td>
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
    document.getElementById('id').value = '';
    document.getElementById('name').value = '';
    document.getElementById('contact').value = '';
    document.getElementById('address').value = '';
    document.getElementById('telephone').value = '';
    document.getElementById('savebtn').innerHTML = 'Save';
  }

  function clickdb(x) {
    function getText(el) {
      if (typeof el.textContent == 'string') return el.textContent;
      if (typeof el.innerText == 'string') return el.innerText;
    }

    $r = x.rowIndex;
    document.getElementById('id').value = getText(document.getElementById('table').rows[$r].cells[5]);
    document.getElementById('name').value = getText(document.getElementById('table').rows[$r].cells[1]);
    document.getElementById('contact').value = getText(document.getElementById('table').rows[$r].cells[2]);
    document.getElementById('address').value = getText(document.getElementById('table').rows[$r].cells[3]);
    document.getElementById('telephone').value = getText(document.getElementById('table').rows[$r].cells[4]);
    document.getElementById('savebtn').innerHTML = 'Update';
  }
</script>