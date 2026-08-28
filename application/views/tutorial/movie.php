<?php error_reporting(0); ?>
<!-- BEGIN PAGE CONTENT -->

<link href="<?php echo base_url(); ?>assets/admin/pages/css/todo.css" rel="stylesheet" type="text/css" />
<div class="page-content">
  <div class="container">

    <div class="col-md-12">
      <!-- BEGIN EXAMPLE TABLE PORTLET-->
      <div class="portlet light">
        <div class="portlet-title">
          <div class="caption">
            <span class="caption-subject theme-font bold">Tutorial</span>
          </div>
          <div class="tools">
            <a href="javascript:;" class="collapse">
            </a>
          </div>
        </div>
        <div class="table-body">
          <?php if ($this->input->get('id') == 'jurnal') { ?>
            <video width="620" height="440" controls>
              <source src="<?php echo base_url(); ?>trial/jurnal.mp4" type="video/mp4">
            </video>
          <?php }
          if ($this->input->get('id') == 'master') { ?>
            <video width="620" height="440" controls>
              <source src="<?php echo base_url(); ?>trial/master.mp4" type="video/mp4">
            </video>
          <?php }
          if ($this->input->get('id') == 'sales_invoice') { ?>
            <video width="620" height="440" controls>
              <source src="<?php echo base_url(); ?>trial/barge.mp4" type="video/mp4">
            </video>
          <?php } ?>


        </div>
      </div>
      <!-- END EXAMPLE TABLE PORTLET-->
    </div>

  </div>
  <!-- END PAGE CONTENT -->
</div>
</div>
<!-- END PAGE CONTENT -->