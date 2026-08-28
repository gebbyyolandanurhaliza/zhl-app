<div class="page-content">
<div class="container-fluid">
    <div class="row ">
        <div class="col-md-12">
            <div class="portlet light">
                <div class="portlet-title">
                    <div class="caption">
            <i class="fa fa-cogs theme-font"></i>
            <span class="caption-subject theme-font uppercase"><?php echo $header_title;?></span>
          </div>
          <div class="tools">
            <a href="javascript:;" class="collapse"></a>
          </div>
                  </div>

                  <?php
        if ($this->session->flashdata('message')) {
          echo $this->session->flashdata('message');
        }
        ?>

                  <div class="portlet-body form">
                      <form action="<?php echo $action; ?>" method="post" class="form-horizontal" role="form">

                          <div class="form-body">

                              <div div class="form-group">
                                <div class="col-md-12">
                                  <div class="panel panel-default">
                                      <div class="panel-body">
                                        <div class="form-group required">
                                            <label class="col-md-1 control-label" for="varchar">Public Holiday Date</label>
                                            <div class="col-md-4">
                                              <input type="text" name="date_holiday" class="form-control date date-picker" value="<?= $date_holiday ?>" data-date-format="dd/mm/yyyy" placeholder="Holiday Public Date" required readonly/>

                                            </div>
                                            <span class="help-inline"><?php echo form_error('date_holiday') ?></span>
                                        </div>
                                        <div class="form-group required">
                                            <label class="col-md-1 control-label" for="varchar">Description</label>
                                            <div class="col-md-4">
                                                <textarea name="description" class="form-control" id="description" cols="30" rows="5"><?php echo $description; ?></textarea>
                                            </div>
                                            <span class="help-inline"><?php echo form_error('description') ?></span>
                                        </div>
                                      </div>
                                  </div>
                                </div>
                              </div>
                          <div class="form-actions">
              <div class="row">
                <div class="col-md-12">
                  <button type="submit" class="btn green w-100"><?php echo $button ?></button>
                  <a href="<?php echo site_url('Master_Tims/public_holiday') ?>" class="btn red w-100"><i class="fa fa-close"></i> Cancel</a>
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

<script type="text/javascript">
$('.autonum').autoNumeric('init', {
  mDec	: 0
});
</script>

<script>
  function change_container(){
      var arr_container_type = $('#container_type').val().split('|');

      $('#container_id').val(arr_container_type[0]);
      $('#container_size').val(arr_container_type[1]);

  }
</script>
