<?php
foreach ($item as $r) {
  $itemid = $r->itemid;
  $itemname = $r->itemname;
  $itemremark = $r->itemremark;
  $categoryid = $r->categoryid;
  $categoryname = $r->categoryname;
  $categorysubid = $r->categorysubid;
  $categorysubname = $r->categorysubname;
  $uomid = $r->uomid;
  $uomname = $r->uomname;
  $cwp1 = $r->idcwp1;
  $cwp2 = $r->idcwp2;
  $cwp3 = $r->idcwp3;
}
?>

<!-- <link href="<?php echo base_url(); ?>assets/admin/css/cloud-admin.css" rel="stylesheet" type="text/css"> -->

<div class="page-content">
  <div class="container-fluid">

    <div class="row">
      <div class="col-md-12">
        <div class="portlet light">
          <div class="portlet-title">
            <div class="caption">
              <i class="fa fa-cogs theme-font"></i>
              <span class="caption-subject theme-font bold">Master Item</span>
            </div>
            <div class="tools">
              <a href="javascript:;" class="collapse"></a>
              <a href="javascript:;" class="reload"></a>
            </div>
          </div>
          <div class="portlet-body form">
            <form action="<?php echo site_url('purchasing/item_factory_save'); ?>" method="post" class="form-horizontal" role="form">
              <div class="form-body">
                <div class="row">
                  <div class="col-md-12">
                    <div class="col-md-5">
                      <div class="form-group" style="margin-bottom:1px;">
                        <label class="col-md-4 label-sm">Item ID</label>
                        <div class="col-md-8">
                          <div class="input-group">
                            <input type="text" class="form-control input-sm col-md-5" name="itemid" id="itemid" value="<?php echo $itemid; ?>" readonly>
                          </div>
                        </div>
                      </div>
                      <div class="form-group " style="margin-bottom:1px;">
                        <label class="col-md-4 label-sm">Item Name</label>
                        <div class="col-md-8">
                          <input class="form-control input-sm" name="itemname" value="<?php echo htmlspecialchars($itemname, ENT_QUOTES); ?>" readonly>
                        </div>
                      </div>
                      <div class="form-group" style="margin-bottom:1px;">
                        <label class="col-md-4 label-sm">Description</label>
                        <div class="col-md-8">
                          <textarea rows="3" class="form-control autosizeme" name="itemremark" readonly><?php echo htmlspecialchars($itemremark, ENT_QUOTES); ?></textarea>
                        </div>
                      </div>
                      <div class="form-group" style="margin-bottom:1px;">
                        <label class="col-md-4 label-sm">Category</label>
                        <div class="col-md-6">
                          <select class="form-control select2me" data-placeholder="Category" name="itemgroup" id="itemgroup" onchange="category()" disabled>
                            <option value="<?php echo $categoryid; ?>"><?php echo $categoryname; ?></option>
                            <?php
                            foreach ($group as $r) {
                              if ($categoryid != $r->categoryid) {
                                echo '<option value="' . $r->categoryid . '">' . $r->categoryname . '</option>';
                              }
                            }
                            ?>
                          </select>
                        </div>
                      </div>
                      <div class="form-group" style="margin-bottom:1px;">
                        <label class="col-md-4 label-sm" readonly>Sub Category</label>
                        <div class="col-md-6">
                          <select class="form-control select2me" data-placeholder="Sub Category" name="itemgroupsub" id="categorysub" disabled>
                            <option value="<?php echo $categorysubid; ?>"><?php echo $categorysubname; ?></option>
                            <?php
                            foreach ($groupsub as $r) {
                              if ($categorysubid != $r->categorysubid) {
                                if ($categoryid == $r->categoryid) {
                                  echo '<option value="' . $r->categorysubid . '">' . $r->categorysubname . '</option>';
                                }
                              }
                            }
                            ?>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-7">
                      <div class="form-group" style="margin-bottom:1px;">
                        <label class="col-md-4 col-md-push-2 label-sm">UOM</label>
                        <div class="col-md-5 col-md-push-2">
                          <select class="form-control select2me" data-placeholder="UOM" name="uom" disabled>
                            <option value="<?php echo $uomid; ?>"><?php echo $uomname; ?></option>
                            <?php
                            foreach ($uom as $r) {
                              if ($uomid != $r->uomid) {
                                echo '<option value="' . $r->uomid . '">' . $r->uomname . '</option>';
                              }
                            }
                            ?>
                          </select>
                        </div>
                      </div>
                      <div class="form-group" style="margin-bottom:1px;">
                        <label class="col-md-4 col-md-push-2 label-sm">Other Item ID</label>
                        <div class="col-md-5 col-md-push-2">
                          <input class="form-control input-sm" placeholder="CWP 1" name="cwp1" value="<?php echo $cwp1; ?>">
                        </div>
                      </div>
                      <div class="form-group" style="margin-bottom:1px;">
                        <div class="col-md-5 col-md-push-6">
                          <input class="form-control input-sm" placeholder="CWP 2" name="cwp2" value="<?php echo $cwp2; ?>">
                        </div>
                      </div>
                      <div class="form-group" style="margin-bottom:1px;">
                        <div class="col-md-5 col-md-push-6">
                          <input class="form-control input-sm" placeholder="CWP 3" name="cwp3" value="<?php echo $cwp3; ?>">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="form-actions">
                <div class="col-md-3 col-md-push-9">
                  <button type="submit" class="col-md-5 btn btn-primary">Update</button>
                  <a type="button" class="col-md-5 btn btn-default" href="<?php echo site_url('purchasing/item_factory'); ?>">Cancel</a>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

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