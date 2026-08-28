<?php
foreach ($item as $r) {
  $itemid = $r->itemid;
  $itemname = $r->itemname;
  $itemremark = $r->itemremark;
  $categoryid = $r->categoryid;
  $categoryname = $r->categoryname;
  $categorysubid = $r->categorysubid;
  $categorysubname = $r->categorysubname;
  $pmcode = $r->pmcode;
  $hscode = $r->hscode;
  $uomid = $r->uomid;
  $uomname = $r->uomname;
  $countryid = $r->country_id;
  $countryname = $r->country_name;
  $per1000 = $r->per1000;
  $unitprice = $r->unitprice;
  $nettweight = $r->nettweight;
  $grossweight = $r->grossweight;
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
            <form action="<?php echo site_url('purchasing/item_save/update'); ?>" method="post" class="form-horizontal" role="form">
              <div class="form-body">
                <div class="row">
                  <div class="col-md-12">
                    <div class="col-md-5">
                      <div class="form-group" style="margin-bottom:1px;">
                        <label class="col-md-4 label-sm">Item ID</label>
                        <div class="col-md-8">
                          <div class="input-group">
                            <input type="text" class="form-control input-sm col-md-5" name="itemid" id="itemid" value="<?php echo $itemid; ?>">
                            <span class="input-group-addon">
                              <input type="checkbox" class="form-control input-sm" id="chk" onclick="copyitem()" <?php if ($pmcode != '') {
                                                                                                                    echo 'checked';
                                                                                                                  } ?>>
                              PM Code
                            </span>
                          </div>
                        </div>
                      </div>
                      <div class="form-group " style="margin-bottom:1px;">
                        <label class="col-md-4 label-sm">Item Name</label>
                        <div class="col-md-8">
                          <input class="form-control input-sm" name="itemname" value="<?php echo htmlspecialchars($itemname, ENT_QUOTES); ?>">
                        </div>
                      </div>
                      <div class="form-group" style="margin-bottom:1px;">
                        <label class="col-md-4 label-sm">Description</label>
                        <div class="col-md-8">
                          <textarea rows="3" class="form-control autosizeme" name="itemremark"><?php echo htmlspecialchars($itemremark, ENT_QUOTES); ?></textarea>
                        </div>
                      </div>
                      <div class="form-group" style="margin-bottom:1px;">
                        <label class="col-md-4 label-sm">Category</label>
                        <div class="col-md-6">
                          <select class="form-control select2me" data-placeholder="Category" name="itemgroup" id="itemgroup" onchange="category()" required>
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
                        <label class="col-md-4 label-sm">Sub Category</label>
                        <div class="col-md-6">
                          <select class="form-control select2me" data-placeholder="Sub Category" name="itemgroupsub" id="categorysub" required>
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
                      <div class="form-group" style="margin-bottom:1px;">
                        <label class="col-md-4 label-sm"></label>
                        <div class="col-md-6">
                          <input type="checkbox" class="form-control" name="per" <?php if ($per1000 == '1') {
                                                                                    echo 'checked';
                                                                                  } ?>> Price Per 1000
                        </div>
                      </div>
                    </div>
                    <div class="col-md-7">
                      <div class="form-group" style="margin-bottom:1px;">
                        <label class="col-md-4 col-md-push-2 label-sm">UOM</label>
                        <div class="col-md-5 col-md-push-2">
                          <select class="form-control select2me" data-placeholder="UOM" name="uom">
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
                        <label class="col-md-4 col-md-push-2 label-sm">Country of Origins</label>
                        <div class="col-md-5 col-md-push-2">
                          <select class="form-control select2me" data-placeholder="Country of origins" name="country">
                            <option value="<?php echo $countryid; ?>"><?php echo $countryname; ?></option>
                            <?php
                            foreach ($country as $r) {
                              echo '<option value="' . $r->country_id . '">' . $r->country_name . '</option>';
                            }
                            ?>
                          </select>
                        </div>
                      </div>
                      <div class="form-group " style="margin-bottom:1px;">
                        <label class="col-md-4 col-md-push-2 label-sm">Label PM Code</label>
                        <div class="col-md-5 col-md-push-2">
                          <input class="form-control input-sm" name="pmcode" id="pmcode" value="<?php echo $pmcode; ?>">
                        </div>
                      </div>
                      <div class="form-group " style="margin-bottom:1px;">
                        <label class="col-md-4 col-md-push-2 label-sm">HS Code</label>
                        <div class="col-md-5 col-md-push-2">
                          <input class="form-control input-sm" name="hscode" value="<?php echo $hscode; ?>">
                        </div>
                      </div>
                      <div class="form-group" style="margin-bottom:1px;">
                        <label class="col-md-4 col-md-push-2 label-sm">Unit Price</label>
                        <div class="col-md-5 col-md-push-2">
                          <input class="form-control input-sm" name="unitprice" value="<?php echo $unitprice; ?>">
                        </div>
                      </div>
                      <div class="form-group" style="margin-bottom:1px;">
                        <label class="col-md-4 col-md-push-2 label-sm">Nett Weight</label>
                        <div class="col-md-5 col-md-push-2">
                          <input class="form-control input-sm" name="nettweight" value="<?php echo $nettweight; ?>">
                        </div>
                      </div>
                      <div class="form-group" style="margin-bottom:1px;">
                        <label class="col-md-4 col-md-push-2 label-sm">Gross Weight</label>
                        <div class="col-md-5 col-md-push-2">
                          <input class="form-control input-sm" name="grossweight" value="<?php echo $grossweight; ?>">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="form-actions">
                <div class="col-md-3 col-md-push-9">
                  <button type="submit" class="col-md-5 btn btn-primary">Update</button>
                  <a type="button" class="col-md-5 btn btn-default" href="<?php echo site_url('purchasing/item'); ?>">Cancel</a>
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