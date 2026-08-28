<?php
error_reporting(0)
?>
<script type="text/javascript">
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
        <div class="col-md-6">
          <div class="portlet light">
            <div class="portlet-title">
              <div class="caption">
                <i class="fa fa-cogs theme-font"></i>
                <span class="caption-subject theme-font bold">Master Group Vendor ZHT</span>
              </div>
              <div class="tools">
                <a href="javascript:;" class="collapse"></a>
                <a href="javascript:;" class="reload"></a>
              </div>
            </div>
            <div class="portlet-body form">
              <form action="<?php echo site_url('purchasing_zht/vendor_group_save'); ?>" method="post" class="form-horizontal" role="form">
                <div class="form-body">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group" style="margin-bottom:1px;">
                        <label class="col-md-3 label-sm">Group Vendor</label>
                        <div class="col-md-6">
                          <input type="hidden" name="id" id="id">
                          <input class="form-control input-sm" name="group" id="group" required>
                        </div>
                      </div>
                      <div class="form-group " style="margin-bottom:1px;">
                        <label class="col-md-3 label-sm">G/L Account</label>
                        <div class="col-md-7">
                          <select class="form-control" data-placeholder="G/L Account" name="coa" id="coa">
                            <option value=""></option>
                            <?php
                            foreach ($coa as $r) {
                              echo '<option value=' . $r->NoCOA . '>' . $r->NoCOA . ' - ' . $r->AccountName . '</option>';
                            }

                            ?>
                          </select>
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
        <div class="col-md-6">
          <div class="portlet light">
            <div class="portlet-title">
              <div class="caption">
                <i class="fa fa-list theme-font"></i>
                <span class="caption-subject theme-font bold">List Group Vendor</span>
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
                    <label class="col-md-2 col-md-push-8 label-sm">Search</label>
                    <div class="col-md-3 col-md-push-7">
                      <input class="form-control input-sm" id="search">
                    </div>
                  </div>
                </div>
              </div>

              <div class="table-scrollable" style="overflow: auto; height:400px;">
                <table id="table" class="table table-bordered table-condensed">
                  <thead>
                    <tr>
                      <th class="text-center">Actions</th>
                      <th class="text-center">Group</th>
                      <th class="text-center">G/L Account</th>
                      <th class="text-center">Created By</th>
                      <th class="text-center">Created Date</th>
                      <th class="text-center">Updated By</th>
                      <th class="text-center">Updated Date</th>
                    </tr>
                  </thead>
                  <tbody id="tbl-mon">
                    <?php $start = 0;
                    foreach ($group as $r) { ?>
                      <tr onclick="clickdb(this)" style="cursor: pointer;">
                        <td nowrap>
                          <a class="btn-sm btn-warning"><i class="fa fa-pencil"></i></a>
                          <a class="btn-sm btn-danger" href="<?php echo site_url('purchasing_zht/vendor_group_delete/' . $r->id); ?>" onclick="javasciprt: return confirm('Are you sure delete group vendor <?php echo $r->group; ?> ?')"><i class="fa fa-trash"></i></a>
                        </td>
                        <td hidden><?php echo $r->id; ?></td>
                        <td onclick="event.stopPropagation();return false;" nowrap><?php echo $r->group; ?></td>
                        <td hidden><?php echo $r->nocoa; ?></td>
                        <td onclick="event.stopPropagation();return false;" nowrap><?php echo $r->AccountName; ?></td>
                        <td onclick="event.stopPropagation();return false;" nowrap><?php echo $r->createdby; ?></td>
                        <td onclick="event.stopPropagation();return false;" nowrap><?php echo $r->createddate; ?></td>
                        <td onclick="event.stopPropagation();return false;" nowrap><?php echo $r->lastupdatedby; ?></td>
                        <td onclick="event.stopPropagation();return false;" nowrap><?php echo $r->lastupdateddate; ?></td>
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

<script type="text/javascript">
  function reset() {
    document.getElementById('id').value = '';
    document.getElementById('group').value = '';
    document.getElementById('coa').value = '';
    document.getElementById('savebtn').innerHTML = 'Save';
  }

  function clickdb(x) {
    function getText(el) {
      if (typeof el.textContent == 'string') return el.textContent;
      if (typeof el.innerText == 'string') return el.innerText;
    }

    $r = x.rowIndex;
    document.getElementById('id').value = getText(document.getElementById('table').rows[$r].cells[1]);
    document.getElementById('group').value = getText(document.getElementById('table').rows[$r].cells[2]);
    document.getElementById('coa').value = getText(document.getElementById('table').rows[$r].cells[3]);
    document.getElementById('savebtn').innerHTML = 'Update';
  }
</script>