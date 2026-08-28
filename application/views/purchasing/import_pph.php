<?php
error_reporting(0)
?>
<style>
  input {
    border: 0px;
    margin: 0px;
  }
</style>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/global/jq/checkboxall.js"></script>

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
              <i class="fa fa-upload theme-font"></i>
              <span class="caption-subject theme-font bold">Import PPH</span>
            </div>
            <div class="tools">
              <a href="javascript:;" class="collapse"></a>
              <a href="javascript:;" class="fullscreen"></a>
            </div>
          </div>
          <div class="portlet-body form">
            <?php $att = array('class' => 'form-horizontal', 'role' => 'form');
            echo form_open_multipart('purchasing/pph_transfer_ex', $att); ?>
            <div class="form-group">
              <div class="col-md-3">
                <input type="file" id="file_upload" name="userfile" size="20" onchange="tempExcel()" style="display: none;" />
                <input id="txt_excel" name="txt_excel" type="text" class="form-control" placeholder="Put Your Excel in Here">
              </div>
              <div>
                <button type="button" class="col-md-1 btn green" onclick="findExcel()">Find</button>
                <button type="submit" class="col-md-1 btn yellow-lemon">Procces</button>
              </div>
            </div>
            <?php echo form_close(); ?>

            <hr>

            <form action="<?php echo site_url('purchasing/pph_transfer_save'); ?>" method="post" class="form-horizontal" role="form">
              <div class="form-body">
                <div class="table-scrollable" style="overflow: auto; height:400px;">
                  <table class="table table-bordered">
                    <thead>
                      <tr>
                        <th witdh="10px;">#</th>
                        <th>PPH No</th>
                        <th>PPH Date</th>
                        <th>Item ID</th>
                        <th>Item Name</th>
                        <th>Qnty</th>
                        <th>UOM</th>
                        <th>Remark</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php $i = 0;
                      if (isset($PPHNo)) {
                        while ($i < count($PPHNo)) : ?>
                          <tr>
                            <td style="width: 5px;"><input type="checkbox" name="chk[]" value="<?php echo $i; ?>"></td>
                            <td nowrap><input type="text" name='PPHNo[<?php echo $i; ?>]' value="<?php echo $PPHNo[$i]; ?>" readonly style="width: 90px;"></td>
                            <td nowrap><input type="text" name="TransDate[<?php echo $i; ?>]" value="<?php echo $TransDate[$i]; ?>" readonly style="width: 80px;"></td>
                            <td nowrap><input type="text" name="ItemID[<?php echo $i; ?>]" value="<?php echo $ItemID[$i]; ?> " readonly style="width: 80px;"></td>
                            <td nowrap><input type="text" name="ItemName[<?php echo $i; ?>]" value="<?php echo $ItemName[$i]; ?>" readonly style="width: 300px;"></td>
                            <td nowrap><input type="text" name="Qnty[<?php echo $i; ?>]" value="<?php echo $Qnty[$i]; ?>" readonly style="width: 80px;text-align: right;"></td>
                            <td nowrap><input type="text" name="PurchaseUOM[<?php echo $i; ?>]" value="<?php echo $PurchaseUOM[$i]; ?>" readonly style="width: 80px;"></td>
                            <td nowrap><input type="text" name="Remark[<?php echo $i; ?>]" value="<?php echo $Remark[$i]; ?>" readonly style="width: 300px;"></td>
                          </tr>
                      <?php $i++;
                        endwhile;
                      } ?>
                    </tbody>
                  </table>
                </div>
              </div>

              <div class="form-actions">
                <div class="col-md-offset-10">
                  <button type="submit" class="col-md-5 btn blue">Save</button>
                  <a class="col-md-5 btn default" href="<?php echo site_url('purchasing/import_pph'); ?>">Cancel</a>
                </div>
              </div>
            </form>
          </div>
        </div>

        <div class="portlet light">
          <div class="portlet-title">
            <div class="caption">
              <i class="fa fa-list theme-font"></i>
              <span class="caption-subject theme-font bold">List PPH</span>
            </div>
            <div class="tools">
              <a href="javascript:;" class="expand"></a>
              <a href="javascript:;" class="fullscreen"></a>
            </div>
          </div>
          <div class="portlet-body" style="display:none;">
            <div class="form-body">
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="control-label col-md-3">Date</label>
                    <div class="col-md-9">
                      <div class="input-group input-large date-picker input-daterange" data-date="2012-10-11" data-date-format="yyyy-mm-dd">
                        <input type="text" class="form-control input-sm" id="from" value="<?php echo date("Y-m-d"); ?>">
                        <span class="input-group-addon">
                          to </span>
                        <input type="text" class="form-control input-sm" id="to" value="<?php echo date("Y-m-d"); ?>">
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="control-label col-md-3">PPH</label>
                    <div class="col-md-4">
                      <input type="text" class="form-control input-sm" id="pph">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="control-label col-md-4 col-md-offset-2 col-md-pull-2">Item</label>
                    <div class="col-md-5 col-md-pull-3">
                      <input type="text" class="form-control input-sm" id="item">
                    </div>
                    <div style="margin-left:20px;">
                      <button class="btn btn-primary btn-sm col-md-2 col-md-offset-3" onclick="search()">Refresh</button>
                    </div>
                  </div>
                </div>
              </div>

              <br>
              <hr>

              <div class="table-scrollable" style="overflow: auto; height:400px;">
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th>PPH No</th>
                      <th>PPH Date</th>
                      <th>Item ID</th>
                      <th>Item Name</th>
                      <th>Qnty</th>
                      <th>UOM</th>
                      <th>Remark</th>
                    </tr>
                  </thead>
                  <tbody id="tblMon">
                    <?php foreach ($pph_temp as $r) { ?>
                      <tr>
                        <td nowrap><?php echo $r->pphno; ?></td>
                        <td nowrap><?php echo date("m-d-Y", strtotime($r->transdate)); ?></td>
                        <td nowrap><?php echo $r->itemid; ?></td>
                        <td nowrap><?php echo $r->itemname; ?></td>
                        <td nowrap class="text-right"><?php echo $r->qnty; ?></td>
                        <td nowrap><?php echo $r->uom; ?></td>
                        <td nowrap><?php echo $r->remark; ?></td>
                      </tr>
                    <?php } ?>
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

<script>
  function findExcel() {
    document.getElementById('file_upload').click();
  }

  function tempExcel() {
    var temp = document.getElementById('file_upload').value;
    document.getElementById('txt_excel').value = temp;
  }

  function search() {
    $from = document.getElementById("from").value;
    $to = document.getElementById("to").value;
    $pph = document.getElementById("pph").value;
    $item = document.getElementById("item").value;

    $.ajax({
      url: "<?php echo base_url(); ?>purchasing/import_pph_search/" + $from + "/" + $to + "/" + $pph + "/" + $item + "",
      success: function(response) {
        $("#tblMon").html(response);
      },
      dataType: "html"
    });

    return false;
  }

  //    checkAll
  function checkAll(ele) {
    var checkboxes = document.getElementsByTagName('input');
    if (ele.checked) {
      for (var i = 0; i < checkboxes.length; i++) {
        if (checkboxes[i].type == 'checkbox') {
          checkboxes[i].checked = true;
        }
      }
    } else {
      for (var i = 0; i < checkboxes.length; i++) {
        console.log(i)
        if (checkboxes[i].type == 'checkbox') {
          checkboxes[i].checked = false;
        }
      }
    }
  }
</script>