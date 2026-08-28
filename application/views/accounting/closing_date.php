<?php error_reporting(0); ?>
<!-- BEGIN PAGE CONTENT -->
<div class="page-content">
  <div class="container">

    <!-- BEGIN PAGE CONTENT INNER -->
    <div class="row">

      <?php
      $group = $this->session->userdata('groupid_1');

      if ($group == 1 || $group == 6 || $group == 11) {
        // Display the closing date form for users with group ID 1, 6, or 7
      ?>

        <div class="col-md-6">
          <!-- BEGIN EXAMPLE TABLE PORTLET-->
          <div class="portlet light">
            <div class="portlet-title">
              <div class="caption">
                <span class="caption-subject theme-font bold uppercase">Closing Date</span>
              </div>
              <div class="tools">
                <a href="javascript:;" class="collapse">
                </a>
                <a href="#portlet-config" data-toggle="modal" class="config">
                </a>
                <a href="javascript:;" class="reload">
                </a>
                <a href="javascript:;" class="remove">
                </a>
              </div>
            </div>
            <div class="table-body">
              <!-- FORM MASTER GROUP -->
              <div class="note note-success note-bordered">
                <p>
                  Closing Date :
                  <?php
                  foreach ($tutup as $v) {
                    echo $v->tanggal;
                  }
                  ?>
                </p>
                <p>
                  Closing date serves as a limit on each transaction in the accounting system . Any transactions under the closing date can not be in the process.
                </p>
              </div>
              <form role="form" method="post" action="<?php echo base_url(); ?>index.php/Closing_date/input_closing">

                <div class="form-group">
                  <label class="control-label">Closing Date</label>
                  <input type="text" name="Periode" class="form-control date date-picker" data-date="01/31/2016" data-date-format="mm/dd/yyyy" required />
                </div>
                <div class="margiv-top-10">
                  <input type="submit" class="btn blue-dark" value="Save">
                </div>
              </form>
              <!-- FORM MASTER GROUP -->
            </div>
          </div>
          <!-- END EXAMPLE TABLE PORTLET-->
        </div>

      <?php } ?>
    </div>
    <!-- END PAGE CONTENT -->
  </div>
</div>
<!-- END PAGE CONTENT -->