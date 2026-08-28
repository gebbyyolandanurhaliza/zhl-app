<?php

foreach ($_getcont as $key) {
  $contid = $key->contid;
  $tipe   = $key->tipe;
}

?>

<!-- <link href="<?php echo base_url(); ?>assets/admin/css/cloud-admin.css" rel="stylesheet" type="text/css"> -->

<div class="page-content" id="oke">
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
              <i class="fa fa-navicon theme-font"></i>
              <span class="caption-subject theme-font bold">Upload Container and Seal</span>
            </div>
          </div>
          <div class="portlet-body form">

            <h3 align="center">Please select File Excel Format (xls, xlsx) for Upload</h3>
            <form method="post" id="import_form" enctype="multipart/form-data" action="import_container_seal">
              <input type="hidden" name="contid" id="contid" value="<?= $contid; ?>">
              <input type="hidden" name="tipe" id="tipe" value="<?= $tipe; ?>">
              <input type="hidden" name="code" id="code" value="<?= $code; ?>">
              <div class="form-body">
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <div class="col-md-8"><input class="form-control input-sm" type="file" name="file" id="file" required accept=".xls, .xlsx" /></div>
                      <div class="col-md-2"><input class="form-control input-sm btn-primary" type="submit" name="import" value="Upload Containers and Seals" /></div>
                      <div class="col-md-2"><a href="<?php echo site_url('shipping/container_show?cont=' . $contid . '&tipe=' . $tipe); ?>"><input class="form-control input-sm btn-danger" type="submit" name="import" value="Back" /></a></div>
                    </div>
                  </div>
                </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>