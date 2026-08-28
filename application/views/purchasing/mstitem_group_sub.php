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
                <span class="caption-subject theme-font bold">Master Item Sub Category</span>
              </div>
              <div class="tools">
                <a href="javascript:;" class="collapse"></a>
                <a href="javascript:;" class="reload"></a>
              </div>
            </div>
            <div class="portlet-body form">
              <form action="<?php echo site_url('purchasing/item_group_sub_save'); ?>" method="post" class="form-horizontal" role="form">
                <div class="form-body">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group" style="margin-bottom:1px;">
                        <!--<label class="col-md-5 label-sm">Category Sub ID </label>-->
                        <div class="col-md-7">
                          <input type="hidden" class="form-control input-sm" name="groupsubid" id="groupid" readonly>
                        </div>
                      </div>
                      <div class="form-group " style="margin-bottom:1px;">
                        <label class="col-md-5 label-sm">Sub Category Name</label>
                        <div class="col-md-7">
                          <input class="form-control input-sm" name="groupsubname" id="groupname">
                        </div>
                      </div>
                      <div class="form-group " style="margin-bottom:1px;">
                        <label class="col-md-5 label-sm">Category Name</label>
                        <div class="col-md-7">
                          <select class="form-control" data-placeholder="Category" name="group" id="group">
                            <option value=""></option>
                            <?php
                            foreach ($group as $r) {
                              echo '<option value="' . $r->categoryid . '">' . $r->categoryname . '</option>';
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
                    <a type="button" class="col-md-5 btn btn-default" href="<?php echo site_url('purchasing/item_group_sub'); ?>">Cancel</a>
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
                <span class="caption-subject theme-font bold">List Item Sub Category</span>
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
                    <label class="col-md-2 col-md-push-7 label-sm text-right">Search</label>
                    <div class="col-md-3 col-md-push-7">
                      <input class="form-control input-sm" id="search">
                    </div>
                  </div>
                </div>
              </div>

              <div class="table-scrollable" style="overflow: auto; height:400px;">
                <table id="table" class="table table-bordered">
                  <thead>
                    <tr>
                      <th class="text-center">Actions</th>
                      <th class="text-center">Name</th>
                      <th class="text-center" hidden>GroupID</th>
                      <th class="text-center">Group</th>
                      <th class="text-center">Created By</th>
                      <th class="text-center">Created Date</th>
                      <th class="text-center">Updated By</th>
                      <th class="text-center">Updated Date</th>
                    </tr>
                  </thead>
                  <tbody id="tbl-mon">
                    <?php foreach ($groupsub as $r) { ?>
                      <tr onclick="clickdb(this)" style="cursor: pointer;">
                        <td nowrap>
                          <a class="btn-sm btn-warning"><i class="fa fa-pencil"></i></a>
                          <a class="btn-sm btn-danger" href="<?php echo site_url('purchasing/item_group_sub_delete/' . $r->categorysubid); ?>" onclick="javasciprt: return confirm('Are you sure delete Group Sub <?php echo $r->categorysubname; ?> ?')"><i class="fa fa-trash"></i></a>
                        </td>
                        <td hidden><?php echo $r->categorysubid; ?></td>
                        <td nowrap onclick="event.stopPropagation();return false;"><?php echo $r->categorysubname; ?></td>
                        <td nowrap onclick="event.stopPropagation();return false;" hidden><?php echo $r->categoryid; ?></td>
                        <td nowrap onclick="event.stopPropagation();return false;"><?php echo $r->categoryname; ?></td>
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

  //    function reset(){
  //        document.getElementById('groupid').value = '';
  //        document.getElementById('groupname').value ='';
  //        document.getElementById('group').value ='';
  //        document.getElementById('savebtn').innerHTML  = 'Save';
  //    }

  function clickdb(x) {
    function getText(el) {
      if (typeof el.textContent == 'string') return el.textContent;
      if (typeof el.innerText == 'string') return el.innerText;
    }

    $r = x.rowIndex;
    document.getElementById('groupid').value = getText(document.getElementById('table').rows[$r].cells[1]);
    document.getElementById('groupname').value = getText(document.getElementById('table').rows[$r].cells[2]);
    document.getElementById('group').value = getText(document.getElementById('table').rows[$r].cells[3]);
    document.getElementById('savebtn').innerHTML = 'Update';
  }
</script>