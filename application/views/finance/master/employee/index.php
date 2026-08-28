<div class="page-content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-5">
        <div class="portlet light">
          <div class="portlet-title">
            <div class="caption theme-font">
              <i class="icon-calculator theme-font"></i>
              <span class="caption-subject bold uppercase"> FORM</span>
              <span class="caption-helper" id="titleForm">Input Data Employee</span>
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
            <form id="form-inputDataEmploye" action="<?php echo site_url('MasterEmployee/insertDataEmployee'); ?>" role="form" class="form-horizontal" method="POST">
              <div class="form-group">
                <label class="control-label col-sm-12">Full Name</label>
                <div class="col-sm-12">
                  <input id="txtInputFullName" name="txtFullName" type="text" class="form-control input-sm" placeholder="Input Full Name Employee" />
                  <input id="txtInputHeaderID" name="txtHeaderID" type="hidden" />
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-sm-12">Position</label>
                <div class="col-sm-12">
                  <input id="txtInputDepartment" name="txtDepartment" class="form-control input-sm" placeholder="Input Position" />
                </div>
              </div>
              <div class="form-group">
                <div class="col-sm-12 text-right">
                  <input name="btnSubmit" type="submit" value="Submit" class="btn btn-sm btn-success" id="btnSubmit" />
                  <input name="btnCancel" type="reset" value="Cancel" class="btn btn-sm btn-warning" id="btnCancel" />
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>

      <div class="col-md-7">
        <div class="portlet light">
          <div class="portlet-title">
            <div class="caption theme-font">
              <i class="icon-list theme-font"></i>
              <span class="caption-subject bold uppercase"> LIST</span>
              <span class="caption-helper">Data Employee</span>
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
          <div class="portlet-body table-responsive">
            <table id="tbl-selectTableEmployee" class="table table-hover table-striped">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Name</th>
                  <th>Position</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($_selectEmployee as $row) : ?>
                  <tr data-id="<?php echo encode_str($row->header_id); ?>">
                    <td><?php echo str_pad($row->header_id, 5, 0, STR_PAD_LEFT); ?></td>
                    <td class="bold"><?php echo $row->full_name; ?></td>
                    <td><?php echo $row->department; ?></td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript" src="<?php echo base_url(); ?>assets/global/plugins/jquery-validation/js/jquery.validate.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/global/plugins/jquery-validation/js/additional-methods.min.js"></script>
<script type="text/javascript">
  jQuery(document).ready(function() {
    $("#tbl-selectTableEmployee").dataTable();

    $("#btnCancel").click(function() {
      $('#titleForm').html('Input Data Employee');
      $('#btnSubmit').val('Submit');
      $('#btnSubmit').removeClass('btn-primary').addClass('btn-success');
      $('#form-inputDataEmploye').attr('action', '<?php echo site_url('MasterEmployee/insertDataEmployee'); ?>');
    });

    $("#tbl-selectTableEmployee tbody tr").dblclick(function() {
      var hdrID = $(this).data('id');
      $.post("<?php echo base_url(); ?>MasterEmployee/getEmployeForEdit", {
        txtHeaderID: hdrID
      }, function(data, statuss) {
        var cb = $.parseJSON(data);
        $('#txtInputHeaderID').val(cb.headID);
        $('#txtInputFullName').val(cb.fullName);
        $('#txtInputDepartment').val(cb.deptEmp);

        $('#titleForm').html('Update Data Employee');
        $('#btnSubmit').val('Edit');
        $('#btnSubmit').removeClass('btn-success').addClass('btn-primary');
        $('#form-inputDataEmploye').attr('action', '<?php echo site_url('MasterEmployee/updateDataEmployee'); ?>');
      });
    });

    var form1 = $('#form-inputDataEmploye');
    var error1 = $('.alert-danger', form1);
    var success1 = $('.alert-success', form1);

    form1.validate({
      errorElement: 'em', //default input error message container
      errorClass: 'help-block help-block-error', // default input error message class
      focusInvalid: false, // do not focus the last invalid input
      ignore: "", // validate all fields including form hidden input
      messages: {
        txtFullName: {
          required: "Please insert this field!"
        },
        txtDepartment: {
          required: "Please insert this field!"
        }
      },
      rules: {
        txtFullName: {
          required: true
        },
        txtDepartment: {
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
      submitHandler: function(form1) {
        success1.show();
        error1.hide();
        return true;
      }
    });
  });
</script>