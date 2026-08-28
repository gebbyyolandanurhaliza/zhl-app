<?php error_reporting(0) ?>

<!-- <link href="<?php echo base_url(); ?>assets/admin/css/cloud-admin.css" rel="stylesheet" type="text/css"> -->

<div class="page-content">
  <div class="container-fluid">

    <div class="row">
      <div class="col-md-12">
        <div class="portlet light">
          <div class="portlet-title">
            <div class="caption">
              <i class="fa fa-list theme-font"></i>
              <span class="caption-subject theme-font bold">Master Item Factory</span>
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
                    <th class="text-center">ID Cwp 1</th>
                    <th class="text-center">ID Cwp 2</th>
                    <th class="text-center">ID Cwp 3</th>
                    <th class="text-center">Updated By</th>
                    <th class="text-center">Updated Date</th>
                  </tr>
                </thead>
                <tbody id="tbl-mon">
                  <?php $start = 0;
                  foreach ($item as $r) { ?>
                    <tr style="cursor: pointer;">
                      <td nowrap>
                        <a class="btn-sm btn-blue" href="<?php echo site_url('purchasing/item_factory_edit?item=' . $r->itemid); ?>"><i class="fa fa-eye"></i></a>
                      </td>
                      <td nowrap><?php echo $r->itemid; ?></td>
                      <td nowrap><?php echo $r->itemname; ?></td>
                      <td nowrap><?php echo $r->categoryname; ?></td>
                      <td nowrap><?php echo $r->categorysubname; ?></td>
                      <td nowrap><?php echo $r->uomname; ?></td>
                      <td nowrap><?php echo $r->idcwp1; ?></td>
                      <td nowrap><?php echo $r->idcwp2; ?></td>
                      <td nowrap><?php echo $r->idcwp3; ?></td>
                      <td nowrap><?php echo $r->updateditemby; ?></td>
                      <td nowrap><?php echo $r->updateditemdate; ?></td>

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
      url: "<?php echo base_url(); ?>purchasing/item_factory_search?item=" + $item + "&cat=" + $category + "&sub=" + $categorysub + "",
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