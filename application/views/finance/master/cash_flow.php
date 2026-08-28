<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/global/plugins/bootstrap-gtreetable/bootstrap-gtreetable.min.css" />
<style>
  #gtreetable {
    white-space: nowrap;
  }
</style>

<div class="page-content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">

        <div class="col-md-5">
          <div class="portlet light">
            <div class="portlet-title">
              <div class="caption theme-font">
                <i class="icon-calculator theme-font"></i>
                <span class="caption-subject bold uppercase"> FORM</span>
                <span class="caption-helper"><?php echo $_formTitle; ?></span>
              </div>
              <div class="tools">
                <a href="javascript:;" class="collapse">
                </a>
              </div>
              <div class="actions">
                <a class="btn btn-circle btn-icon-only btn-default fullscreen" href="javascript:;" data-original-title="" title="">
                </a>
              </div>
            </div>
            <div class="portlet-body" id="ajaxForm">
              <!-- FORM MASTER Cash Flow -->
              <form id="form-MstCashFlow" role="form" method="POST" action="<?php echo site_url('Master_CashFlow/' . $_action['sumbit']); ?>" class="form-horizontal">
                <div class="form-group">
                  <label class="control-label col-sm-12">Code <span class="required"> * </span></label>
                  <div class="col-sm-12">
                    <input type="text" name="txtCode" class="form-control input-sm" value="<?php if ($is_edit == TRUE) {
                                                                                              echo $_getCashFlow->cf_code;
                                                                                            } ?>" />
                    <?php if ($is_edit == TRUE) : ?>
                      <input type="hidden" name="txtKey" class="form-control input-sm" value="<?php if ($is_edit == TRUE) {
                                                                                                echo $_getCashFlow->cf_key;
                                                                                              } ?>" />
                    <?php endif; ?>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-12">Description <span class="required"> * </span></label>
                  <div class="col-sm-12">
                    <input type="text" name="txtName" class="form-control input-sm" value="<?php if ($is_edit == TRUE) {
                                                                                              echo $_getCashFlow->cf_name;
                                                                                            } ?>" />
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-12">In/ Out <span class="required"> * </span></label>
                  <div class="col-sm-12">
                    <select class="form-control input-sm select2me" name="selInOut" data-placeholder="Choose...">
                      <option value=""> </option>
                      <option value="I" <?php if ($is_edit == TRUE) {
                                          if ($_getCashFlow->io == 'I') {
                                            echo 'selected';
                                          }
                                        } ?>>In</option>
                      <option value="O" <?php if ($is_edit == TRUE) {
                                          if ($_getCashFlow->io == 'O') {
                                            echo 'selected';
                                          }
                                        } ?>>Out</option>
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-12">Header Code <span class="required"> * </span></label>
                  <div class="col-sm-12">
                    <select class="form-control input-sm select2me" name="selHeaderCode" data-placeholder="Choose...">
                      <option value=""></option>
                      <option value="0" <?php if ($is_edit == TRUE && $_getCashFlow->cf_header == 0) {
                                          echo 'selected';
                                        } ?>>On Top</option>
                      <?php foreach ($_selectCashFlow as $rCF) : ?>
                        <?php if ($is_edit == TRUE && $_getCashFlow->cf_header == $rCF->cf_key) : ?>
                          <option value="<?php echo $rCF->cf_key; ?>" selected><?php echo $rCF->cf_code . '. ' . $rCF->cf_name; ?></option>
                        <?php else : ?>
                          <option value="<?php echo $rCF->cf_key; ?>"><?php echo $rCF->cf_code . '. ' . $rCF->cf_name; ?></option>
                        <?php endif; ?>
                      <?php endforeach; ?>
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-12">Not Active?</label>
                  <div class="radio-list col-sm-12">
                    <label class="">
                      <input type="radio" name="txtNotActive" class="radio form-control" value="0" <?php if ($is_edit == TRUE && $_getCashFlow->not_active == 1) {
                                                                                                      echo '';
                                                                                                    } else {
                                                                                                      echo 'checked';
                                                                                                    } ?> /> No</label>
                    <label class="">
                      <input type="radio" name="txtNotActive" class="radio form-control" value="1" <?php if ($is_edit == TRUE && $_getCashFlow->not_active == 1) {
                                                                                                      echo 'checked';
                                                                                                    } ?> /> Yes</label>
                  </div>
                </div>
                <div class="form-group">
                  <div class="col-sm-12 text-right">
                    <input name="btnSubmit" type="submit" value="<?php echo $_action['button']; ?>" class="btn btn-sm btn-success" />
                    <input name="btnCancel" type="button" value="Cancel" class="btn btn-sm btn-warning" id="btnCancel" />
                  </div>
                </div>
              </form>
              <!-- FORM MASTER Cash Flow -->
            </div>

          </div>
        </div>

        <div class="col-md-7">
          <!-- BEGIN PORTLET-->
          <div class="portlet light">
            <div class="portlet-title">
              <div class="caption theme-font">
                <i class="icon-speech theme-font"></i>
                <span class="caption-subject bold uppercase"> Cash Flow</span>
                <span class="caption-helper">Master</span>
              </div>
              <div class="actions">
                <a class="btn btn-circle btn-icon-only btn-default fullscreen" href="javascript:;" data-original-title="" title="">
                </a>
              </div>
            </div>
            <div class="portlet-body" style="overflow: auto; height: 388px;">
              <div class="table-scrollable">
                <table class="table table-striped table-hover gtreetable" id="gtreetable">
                  <thead>
                    <tr>
                      <th colspan="3" style="width: 20%;">Code</th>
                      <th>Description</th>
                      <th style="width: 15%;" class="text-center">I/O</th>
                      <th style="width: 20%;">Code Header</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($_selectCashFlow1 as $row1) : ?>
                      <tr data-id="<?php echo $row1->cf_key; ?>" style="font-weight: bold;" class="tooltips" data-container="body" data-placement="bottom" data-html="true" data-original-title="Double Click for Edit">
                        <td colspan="3"><?php echo $row1->cf_code; ?></td>
                        <td><?php echo $row1->cf_name; ?> <?php if ($_Controller->lastLevelCF($row1->cf_key) == TRUE) {
                                                            echo '*';
                                                          } ?></td>
                        <td class="text-center"><?php echo $row1->io; ?></td>
                        <td><?php echo $row1->cf_code_header; ?></td>
                      </tr>
                      <?php foreach ($_selectCashFlow2 as $row2) : ?>
                        <?php if ($row2->cf_header == $row1->cf_key) : ?>
                          <tr class="text-primary" data-id="<?php echo $row2->cf_key; ?>">
                            <td colspan="3"><i class="fa fa-angle-double-right"></i> <?php echo $row2->cf_code; ?></td>
                            <td><?php echo $row2->cf_name; ?> <?php if ($_Controller->lastLevelCF($row2->cf_key) == TRUE) {
                                                                echo '*';
                                                              } ?></td>
                            <td class="text-center"><?php echo $row2->io; ?></td>
                            <td><?php echo $row2->cf_code_header; ?></td>
                          </tr>
                        <?php endif; ?>
                        <?php foreach ($_selectCashFlow3 as $row3) : ?>
                          <?php if ($row3->cf_header == $row2->cf_key && $row2->cf_header == $row1->cf_key) : ?>
                            <tr class="text-success" data-id="<?php echo $row3->cf_key; ?>">
                              <td></td>
                              <td colspan="2"><i class="fa fa-angle-right"></i> <?php echo $row3->cf_code; ?></td>
                              <td><?php echo $row3->cf_name; ?> <?php if ($_Controller->lastLevelCF($row3->cf_key) == TRUE) {
                                                                  echo '*';
                                                                } ?></td>
                              <td class="text-center"><?php echo $row3->io; ?></td>
                              <td><?php echo $row3->cf_code_header; ?></td>
                            </tr>
                          <?php endif; ?>
                          <?php foreach ($_selectCashFlow4 as $row4) : ?>
                            <?php if ($row4->cf_header == $row3->cf_key && $row3->cf_header == $row2->cf_key && $row2->cf_header == $row1->cf_key) : ?>
                              <tr class="text-muted" data-id="<?php echo $row4->cf_key; ?>">
                                <td></td>
                                <td></td>
                                <td><i class="fa fa-caret-right"></i> <?php echo $row4->cf_code; ?></td>
                                <td><?php echo $row4->cf_name; ?> <?php if ($_Controller->lastLevelCF($row4->cf_key) == TRUE) {
                                                                    echo '*';
                                                                  } ?></td>
                                <td class="text-center"><?php echo $row4->io; ?></td>
                                <td><?php echo $row4->cf_code_header; ?></td>
                              </tr>
                            <?php endif; ?>
                          <?php endforeach; ?>
                        <?php endforeach; ?>
                      <?php endforeach; ?>
                    <?php endforeach; ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <!-- END PORTLET-->
        </div>

      </div>
    </div>
  </div>
</div>

<script type="text/javascript" src="<?php echo base_url(); ?>assets/global/plugins/bootstrap-gtreetable/bootstrap-gtreetable.min.js"></script>
<script type="text/javascript">
  jQuery('#gtreetable').gtreetable();
</script>

<script type="text/javascript">
  $('#gtreetable tbody tr').dblclick(function() {
    var row = $(this).closest('tr');
    var id = row.data('id');

    //        alert(id);
    window.location = '<?php echo site_url(); ?>Master_CashFlow/index/' + id;
  });

  $('#btnCancel').click(function() {
    window.location = '<?php echo site_url(); ?>Master_CashFlow/index/';
  });
</script>

<script type="text/javascript" src="<?php echo base_url(); ?>assets/global/plugins/jquery-validation/js/jquery.validate.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/global/plugins/jquery-validation/js/additional-methods.min.js"></script>
<script>
  jQuery(document).ready(function() {
    var form1 = $('#form-MstCashFlow');
    var error1 = $('.alert-danger', form1);
    var success1 = $('.alert-success', form1);

    form1.validate({
      errorElement: 'em', //default input error message container
      errorClass: 'help-block help-block-error', // default input error message class
      focusInvalid: false, // do not focus the last invalid input
      ignore: "", // validate all fields including form hidden input
      messages: {
        txtCode: {
          required: "Please insert this field!"
        },
        txtName: {
          required: "Please insert this field!"
        },
        selInOut: {
          required: "Please chose once!"
        },
        selHeaderCode: {
          required: "Please chose once!"
        }
      },
      rules: {
        txtCode: {
          required: true
        },
        txtName: {
          required: true
        },
        selInOut: {
          required: true
        },
        selHeaderCode: {
          required: true
        }
      },

      invalidHandler: function(event, validator) { //display error alert on form submit              
        success1.hide();
        error1.show();
        Metronic.scrollTo(error1, -200);
      },
      highlight: function(element) { // hightlight error inputs
        $(element)
          .closest('.form-group').addClass('has-error'); // set error class to the control group
      },
      unhighlight: function(element) { // revert the change done by hightlight
        $(element)
          .closest('.form-group').removeClass('has-error'); // set error class to the control group
      },
      success: function(label) {
        label
          .closest('.form-group').removeClass('has-error'); // set success class to the control group
      },
      submitHandler: function(form) {
        success1.show();
        error1.hide();
        return true;
      }
    });

    $('.select2me', form1).change(function() {
      form1.validate().element($(this)); //revalidate the chosen dropdown value and show error or success message for the input
    });
  });
</script>