<div class="page-content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="col-md-7">
          <!-- BEGIN PORTLET-->
          <div class="portlet light" style="height: 550px;">
            <div class="portlet-title">
              <div class="caption theme-font">
                <i class="icon-speech theme-font"></i>
                <span class="caption-subject bold uppercase"> Cash Flow Realization</span>
                <span class="caption-helper">Master</span>
              </div>
              <div class="actions">
                <a class="btn btn-circle btn-icon-only btn-default fullscreen" href="javascript:;" data-original-title="" title="">
                </a>
              </div>
            </div>
            <div class="portlet-body">
              <table class="datatable table table-bordered table-hover" id="table-realization">
                <thead>
                  <tr>
                    <th>Remark</th>
                    <th>Code</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($_selectCashRealization1 as $row1) : ?>
                    <tr style="font-weight: bold;" data-id="<?php echo $row1->rlz_key ?>">
                      <td><?php echo $row1->rlz_num . '. ' . strtoupper($row1->rlz_name); ?></td>
                      <td><?php echo $row1->rlz_code; ?> <?php if ($_Controller->lastLevelRlz($row1->rlz_key) == TRUE) {
                                                          echo '*';
                                                        } ?></td>
                    </tr>
                    <?php foreach ($_selectCashRealization2 as $row2) : ?>
                      <?php if ($row2->rlz_header == $row1->rlz_key) : ?>
                        <tr class="text-primary" data-id="<?php echo $row2->rlz_key ?>">
                          <td><?php echo $row2->rlz_num . '. ' . ucwords(strtolower($row2->rlz_name)); ?></td>
                          <td><?php echo $row2->rlz_code; ?> <?php if ($_Controller->lastLevelRlz($row2->rlz_key) == TRUE) {
                                                              echo '*';
                                                            } ?></td>
                        </tr>
                      <?php endif; ?>
                      <?php foreach ($_selectCashRealization3 as $row3) : ?>
                        <?php if ($row3->rlz_header == $row2->rlz_key && $row2->rlz_header == $row1->rlz_key) : ?>
                          <tr class="text-success" data-id="<?php echo $row3->rlz_key ?>">
                            <td><?php echo $row3->rlz_num . '. ' . ucfirst($row3->rlz_name); ?></td>
                            <td><?php echo $row3->rlz_code; ?> <?php if ($_Controller->lastLevelRlz($row3->rlz_key) == TRUE) {
                                                                echo '*';
                                                              } ?></td>
                          </tr>
                        <?php endif; ?>
                        <?php foreach ($_selectCashRealization4 as $row4) : ?>
                          <?php if ($row4->rlz_header == $row3->rlz_key && $row3->rlz_header == $row2->rlz_key && $row2->rlz_header == $row1->rlz_key) : ?>
                            <tr class="text-muted" data-id="<?php echo $row4->rlz_key ?>">
                              <td><?php echo $row4->rlz_num . '. ' . $row4->rlz_name; ?></td>
                              <td><?php echo $row4->rlz_code; ?> <?php if ($_Controller->lastLevelRlz($row4->rlz_key) == TRUE) {
                                                                  echo '*';
                                                                } ?></td>
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
          <!-- END PORTLET-->
        </div>
        <div class="col-md-5">
          <div class="portlet light" style="height: 550px;">
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
            <div class="portlet-body">
              <!-- FORM MASTER COA -->
              <?php $rlz  = $_getCashRealization; ?>
              <form id="form-MstCashRealization" role="form" method="post" action="<?php echo site_url('Master_CashFlow/' . $_action['sumbit']); ?>" class="form-horizontal">
                <div class="form-group">
                  <label class="control-label col-sm-12">Code <span class="required"> * </span></label>
                  <div class="col-sm-12">
                    <input type="hidden" id="r-key" name="txtkey" class="form-control input-sm" value="<?php if ($is_edit == TRUE) {
                                                                                                          echo $rlz->rlz_key;
                                                                                                        } ?>" />
                    <input type="text" id="r-code" name="txtCode" class="form-control input-sm" required value="<?php if ($is_edit == TRUE) {
                                                                                                                  echo $rlz->rlz_code;
                                                                                                                } ?>" />
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-12">Number <span class="required"> * </span></label>
                  <div class="col-sm-12">
                    <input type="text" id="r-num" name="txtNumber" class="form-control input-sm" required value="<?php if ($is_edit == TRUE) {
                                                                                                                    echo $rlz->rlz_num;
                                                                                                                  } ?>" />
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-12">Description <span class="required"> * </span></label>
                  <div class="col-sm-12">
                    <input type="text" id="r-name" name="txtDescription" class="form-control input-sm" required value="<?php if ($is_edit == TRUE) {
                                                                                                                          echo $rlz->rlz_name;
                                                                                                                        } ?>" />
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-12">In/ Out <span class="required"> * </span></label>
                  <div class="col-sm-12">
                    <select class="form-control input-sm select2me" name="selInOut" id="r-io" data-placeholder="Choose...">
                      <option value=""> </option>
                      <option value="I" <?php if ($is_edit == TRUE && $rlz->io == 'I') {
                                          echo 'selected';
                                        } ?>>In</option>
                      <option value="O" <?php if ($is_edit == TRUE && $rlz->io == 'O') {
                                          echo 'selected';
                                        } ?>>Out</option>
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-12">Header Code <span class="required"> * </span></label>
                  <div class="col-sm-12">
                    <select class="form-control input-sm select2me" name="selHeaderCode" id="r-head" data-placeholder="Choose...">
                      <option value=""> </option>
                      <option value="0" <?php if ($is_edit == TRUE && $rlz->rlz_header == 0) {
                                          echo 'selected';
                                        } ?>>On Top</option>
                      <?php foreach ($_selectCashRealization as $rlzzz) : ?>
                        <?php if ($is_edit == TRUE && $rlz->rlz_header == $rlzzz->rlz_key) : ?>
                          <option value="<?php echo $rlzzz->rlz_key; ?>" selected><?php echo $rlzzz->rlz_code . '. ' . $rlzzz->rlz_name; ?></option>
                        <?php else : ?>
                          <option value="<?php echo $rlzzz->rlz_key; ?>"><?php echo $rlzzz->rlz_code . '. ' . $rlzzz->rlz_name; ?></option>
                        <?php endif; ?>
                      <?php endforeach; ?>
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-12">Not Active?</label>
                  <div class="radio-list col-sm-12">
                    <label>
                      <input type="radio" name="txtNotActive" id="noooo" class="radio" value="0" <?php if ($is_edit == TRUE && $rlz->not_active == 1) {
                                                                                                    echo '';
                                                                                                  } else {
                                                                                                    echo 'checked';
                                                                                                  } ?> /> No</label>
                    <label>
                      <input type="radio" name="txtNotActive" id="yesss" class="radio" value="1" <?php if ($is_edit == TRUE && $rlz->not_active == 1) {
                                                                                                    echo 'checked';
                                                                                                  } ?> /> Yes</label>
                  </div>
                </div>
                <div class="form-group">
                  <div class="col-sm-12 text-right">
                    <input class="btn btn-sm btn-success" name="btnSave" id="btnSave" type="submit" value="<?php echo $_action['button']; ?>" />
                    <input class="btn btn-sm btn-warning" name="btnCancel" id="btnCancel" type="button" value="Cancel" />
                  </div>
                </div>
              </form>
              <!-- FORM MASTER COA -->
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  $('#table-realization tbody tr').dblclick(function() {
    var row = $(this).closest('tr');
    var id = row.data('id');

    //        alert(id);
    window.location = '<?php echo site_url(); ?>Master_CashFlow/MasterRealization/' + id;
  });

  $('#btnCancel').click(function() {
    window.location = '<?php echo site_url(); ?>Master_CashFlow/MasterRealization/';
  });
</script>

<script type="text/javascript" src="<?php echo base_url(); ?>assets/global/plugins/jquery-validation/js/jquery.validate.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/global/plugins/jquery-validation/js/additional-methods.min.js"></script>
<script>
  jQuery(document).ready(function() {
    var form1 = $('#form-MstCashRealization');
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
        txtNumber: {
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
        txtNumber: {
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