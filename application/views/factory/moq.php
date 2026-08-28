<?php
if (empty($_detail)) {
  $sbt = 'SAVE';
  $isi = '';
} else {
  $sbt = 'UPDATE';
  foreach ($_detail as $r) {
    $pid = $r->product_id;
    $pnm = $r->product_name;
    $isi = $r->Description;
  }
}
?>

<div class="page-content">
  <div class="container">
    <!-- BEGIN PAGE CONTENT INNER -->
    <div class="row">
      <form action="<?php echo base_url(); ?>Moq/save_moq" method="post">
        <div class="md-col-12">

          <div class="portlet light">

            <div class="portlet-title">
              <div class="caption">
                <i class="fa fa-credit-card theme-font"></i>
                <span class="caption-subject theme-font">PPIC MOQ INPUT</span>
              </div>
            </div>

            <div class="portlet-body">

              <div class="form-body">
                <div class="row">
                  <div class="col-md-12">

                    <?php
                    if (empty($_detail)) {
                    ?>
                      <div class="form-group">
                        <label class="control-label col-md-1"><b>Product Name</b></label>
                        <div class="col-md-5">
                          <div id="cur_id">
                            <?php
                            $style_product = "class='select2me form-control' id='product' '";
                            echo form_dropdown('product', $_product, '', $style_product);

                            ?>
                          </div>
                        </div>
                      </div>
                    <?php
                    } else {
                    ?>
                      <div class="form-group">
                        <label class="control-label col-md-1"><b>Product Name</b></label>
                        <div class="col-md-5">
                          <input type="text" value="<?php echo $pnm . ' (' . $pid . ')' ?>" class='txt form-control' readonly>
                          <input type="hidden" name="product" value="<?= $pid; ?>">
                        </div>
                      </div>
                    <?php
                    }
                    ?>
                    <div class="form-group">
                      <div class="col-md-12">
                        <textarea class="ckeditor form-control" name="editor1" rows="12"><?= $isi; ?></textarea>
                      </div>
                    </div>
                  </div>
                </div>
                <br>
                <hr>
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <div class="col-md-12">
                        <button type="submit" name="sbt" id="btn_update" class="btn btn-primary" value="<?= $sbt; ?>"><i class="fa fa-save"></i> <?= $sbt; ?></button>
                        <a class="btn btn-warning" href="<?php echo base_url(); ?>Moq"><i class="fa fa-warning"></i> Cancel</a>
                      </div>
                    </div>
                  </div>
                </div>

              </div>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

<script src="<?= base_url(); ?>assets/global/plugins/ckeditor/ckeditor.js" type="text/javascript"></script>