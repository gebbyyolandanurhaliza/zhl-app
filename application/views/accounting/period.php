<?php error_reporting(0); ?>
<!-- BEGIN PAGE CONTENT -->
<div class="page-content">
  <div class="container">

    <!-- BEGIN PAGE CONTENT INNER -->
    <div class="row">
      <div class="col-md-6">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet light">
          <div class="portlet-title">
            <div class="caption">
              <i class="fa fa-cogs theme-font"></i>
              <span class="caption-subject theme-font bold uppercase">Master of Period</span>
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
                Active Period : <?php echo $this->session->userdata('periode_1'); ?> <br />
                This is form for used input Master Period. Master Period serves to standardize the accounting period monthly report . Please enter your desired period .
              </p>
            </div>
            <form role="form" method="post" action="<?php echo base_url(); ?>index.php/Period/input_period">

              <div class="form-group">
                <label class="control-label">Period</label>
                <input type="text" name="Period" class="form-control date date-picker" data-date="2016/01" data-date-format="yyyy/mm" required />
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

    </div>
    <!-- END PAGE CONTENT -->
  </div>
</div>
<!-- END PAGE CONTENT -->