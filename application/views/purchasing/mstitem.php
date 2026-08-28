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
              <span class="caption-subject theme-font bold">Master Item Purchasing</span>
            </div>
            <div class="tools">
              <a href="javascript:;" class="collapse"></a>
              <a href="javascript:;" class="reload"></a>
            </div>
          </div>
          <div class="portlet-body form">
            <form action="<?php echo site_url('purchasing/item_save/add'); ?>" method="post" class="form-horizontal" role="form">
              <div class="form-body">
                <div class="row">
                  <div class="col-md-12">
                    <div class="col-md-5">
                      <div class="form-group" style="margin-bottom:1px;">
                        <label class="col-md-3 label-sm">Item ID</label>
                        <div class="col-md-8">
                          <div class="input-group">
                            <input type="text" class="form-control input-sm col-md-5" name="itemid" id="itemid" required>
                            <span class="input-group-addon">
                              <input type="checkbox" class="form-control input-sm" id="chk" onclick="copyitem()">
                              PM Code
                            </span>
                          </div>
                        </div>
                      </div>
                      <div class="form-group " style="margin-bottom:1px;">
                        <label class="col-md-3 label-sm">Item Name</label>
                        <div class="col-md-8">
                          <input class="form-control input-sm" name="itemname">
                        </div>
                      </div>
                      <div class="form-group" style="margin-bottom:1px;">
                        <label class="col-md-3 label-sm">Description</label>
                        <div class="col-md-8">
                          <textarea rows="3" class="form-control autosizeme" name="itemremark"></textarea>
                        </div>
                      </div>
                      <div class="form-group" style="margin-bottom:1px;">
                        <label class="col-md-3 label-sm">Category</label>
                        <div class="col-md-6">
                          <select class="form-control select2me" data-placeholder="Category" name="itemgroup" id="itemgroup" onchange="category()" required>
                            <option value=""></option>
                            <?php
                            foreach ($group as $r) {
                              echo '<option value="' . $r->categoryid . '">' . $r->categoryname . '</option>';
                            }
                            ?>
                          </select>
                        </div>
                      </div>
                      <div class="form-group" style="margin-bottom:1px;">
                        <label class="col-md-3 label-sm">Sub Category</label>
                        <div class="col-md-6">
                          <select class="form-control select2me" data-placeholder="Sub Category" name="itemgroupsub" id="categorysub" required>
                            <option value=""></option>
                          </select>
                        </div>
                      </div>
                      <div class="form-group" style="margin-bottom:1px;">
                        <label class="col-md-3 label-sm"></label>
                        <div class="col-md-6">
                          <input type="checkbox" class="form-control" name="per">
                          Price Per 1000
                        </div>
                      </div>
                    </div>
                    <div class="col-md-7">
                      <div class="form-group" style="margin-bottom:1px;">
                        <label class="col-md-3 col-md-push-3 label-sm">UOM</label>
                        <div class="col-md-5 col-md-push-3">
                          <select class="form-control select2me" data-placeholder="UOM" name="uom">
                            <option value=""></option>
                            <?php
                            foreach ($uom as $r) {
                              echo '<option value="' . $r->uomid . '">' . $r->uomname . '</option>';
                            }
                            ?>
                          </select>
                        </div>
                      </div>
                      <div class="form-group" style="margin-bottom:1px;">
                        <label class="col-md-3 col-md-push-3 label-sm">Country of Origins</label>
                        <div class="col-md-5 col-md-push-3">
                          <select class="form-control select2me" data-placeholder="Country of origins" name="country">
                            <option value=""></option>
                            <?php
                            foreach ($country as $r) {
                              echo '<option value="' . $r->country_id . '">' . $r->country_name . '</option>';
                            }
                            ?>
                          </select>
                        </div>
                      </div>
                      <div class="form-group " style="margin-bottom:1px;">
                        <label class="col-md-3 col-md-push-3 label-sm">Label PM Code</label>
                        <div class="col-md-5 col-md-push-3">
                          <input class="form-control input-sm" name="pmcode" id="pmcode">
                        </div>
                      </div>
                      <div class="form-group " style="margin-bottom:1px;">
                        <label class="col-md-3 col-md-push-3 label-sm">HS Code</label>
                        <div class="col-md-5 col-md-push-3">
                          <input class="form-control input-sm" name="hscode">
                        </div>
                      </div>

                      <div class="form-group" style="margin-bottom:1px;">
                        <label class="col-md-3 col-md-push-3 label-sm">Unit Price</label>
                        <div class="col-md-5 col-md-push-3">
                          <input class="form-control input-sm" name="unitprice">
                        </div>
                      </div>
                      <div class="form-group" style="margin-bottom:1px;">
                        <label class="col-md-3 col-md-push-3 label-sm">Nett Weight</label>
                        <div class="col-md-5 col-md-push-3">
                          <input class="form-control input-sm" name="nettweight">
                        </div>
                      </div>
                      <div class="form-group" style="margin-bottom:1px;">
                        <label class="col-md-3 col-md-push-3 label-sm">Gross Weight</label>
                        <div class="col-md-5 col-md-push-3">
                          <input class="form-control input-sm" name="grossweight">
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
              <span class="caption-subject theme-font bold">List Item</span>
            </div>
            <div class="tools">
              <a href="javascript:;" class="collapse"></a>
              <a href="javascript:;" class="reload"></a>
            </div>
          </div>
          <div class="portlet-body">
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label class="col-md-4 label-sm">Item</label>
                  <div class="col-md-8">
                    <input type="text" class="form-control input-sm" id="item">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-md-4 label-sm">Category</label>
                  <div class="col-md-8">
                    <select class="form-control select2me" data-placeholder="Category" id="filtercategory" onchange="filtercategory()">
                      <option value=""></option>
                      <?php
                      foreach ($group as $r) {
                        echo '<option value="' . $r->categoryid . '">' . $r->categoryname . '</option>';
                      }
                      ?>
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-md-4 label-sm">Sub Category</label>
                  <div class="col-md-8">
                    <select class="form-control select2me" data-placeholder="Sub Category" id="filtercategorysub">
                      <option value=""></option>
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <div class="col-md-4 col-md-offset-4">
                    <button class="btn btn-primary btn-sm" onclick="search()">Refresh</button>
                  </div>
                </div>
              </div>
            </div>
            <div class="table-scrollable" style="overflow: auto; height:400px;">
              <table class="table table-bordered" id="table">
                <thead>
                  <tr>
                    <th class="text-center"> Actions</th>
                    <th class="text-center" data-sortable="true">Item ID</th>
                    <th class="text-center">Item Name</th>
                    <th class="text-center">Category</th>
                    <th class="text-center">Sub Category</th>
                    <th class="text-center">UOM</th>
                    <th class="text-center">Country of Origins</th>
                    <th class="text-center">Label PM Code</th>
                    <th class="text-center">HS Code</th>
                    <th class="text-center">Item Remark</th>
                    <th class="text-center">Unit Price</th>
                    <th class="text-center">Nett Weight</th>
                    <th class="text-center">Gross Weight</th>
                    <th class="text-center">Created By</th>
                    <th class="text-center">Created Date</th>
                    <th class="text-center">Updated By</th>
                    <th class="text-center">Updated Date</th>
                  </tr>
                </thead>
                <tbody id="tbl-mon">
                  <?php $start = 0;
                  foreach ($item as $r) { ?>
                    <tr style="cursor: pointer;">
                      <td nowrap>
                        <a class="btn-sm btn-warning" href="<?php echo site_url('purchasing/item_edit?item=' . $r->itemid); ?>"><i class="fa fa-pencil"></i></a>
                        <a class="btn-sm btn-danger" href="<?php echo site_url('purchasing/item_delete?item=' . $r->itemid); ?>" onclick="javasciprt: return confirm('Are you sure delete Item <?php echo $r->itemname; ?> ?')"><i class="fa fa-trash"></i></a>
                      </td>
                      <td nowrap><?php echo $r->itemid; ?></td>
                      <td nowrap><?php echo $r->itemname; ?></td>
                      <td nowrap><?php echo $r->categoryname; ?></td>
                      <td nowrap><?php echo $r->categorysubname; ?></td>
                      <td nowrap><?php echo $r->uomname; ?></td>
                      <td nowrap><?php echo $r->country_name; ?></td>
                      <td nowrap><?php echo $r->pmcode; ?></td>
                      <td nowrap><?php echo $r->hscode; ?></td>
                      <td nowrap><?php echo $r->itemremark; ?></td>
                      <td nowrap><?php echo $r->unitprice; ?></td>
                      <td nowrap><?php echo $r->nettweight; ?></td>
                      <td nowrap><?php echo $r->grossweight; ?></td>
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

<script>
  function category() {
    $category = document.getElementById('itemgroup').value;

    $.ajax({
      url: "<?php echo base_url(); ?>purchasing/item_category_sub/" + $category + "",
      success: function(response) {
        $("#categorysub").html(response);
      },
      dataType: "html"
    });

    return false;
  }

  function filtercategory() {
    $category = document.getElementById('filtercategory').value;

    $.ajax({
      url: "<?php echo base_url(); ?>purchasing/item_category_sub/" + $category + "",
      success: function(response) {
        $("#filtercategorysub").html(response);
      },
      dataType: "html"
    });

    return false;
  }

  function search() {
    $item = document.getElementById('item').value;
    $category = document.getElementById('filtercategory').value;
    $categorysub = document.getElementById('filtercategorysub').value;

    $.ajax({
      url: "<?php echo base_url(); ?>purchasing/item_search?item=" + $item + "&cat=" + $category + "&sub=" + $categorysub + "",
      success: function(response) {
        $("#tbl-mon").html(response);
      },
      dataType: "html"
    });

    return false;
  }

  function copyitem() {
    $chk = document.getElementById('chk').checked;
    $item = document.getElementById('itemid').value;

    if ($chk != 1) {
      document.getElementById('pmcode').value = '';
    } else {
      document.getElementById('pmcode').value = $item;
    }
  }
</script>