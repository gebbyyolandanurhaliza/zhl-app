<?php error_reporting(E_ALL & ~E_NOTICE); ?>


<!-- BEGIN PAGE CONTENT -->
<div class="page-content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="col-md-7">
          <!-- BEGIN PORTLET-->
          <div class="portlet light">
            <div class="portlet-title">
              <div class="caption theme-font">
                <i class="icon-speech theme-font"></i>
                <span class="caption-subject bold uppercase"> G/L Account</span>
                <span class="caption-helper">Default G/L Account Number</span>
              </div>
              <div class="actions">
                <a class="btn btn-circle btn-icon-only btn-default fullscreen" href="javascript:;" data-original-title="" title="">
                </a>
              </div>
            </div>
            <div class="portlet-body">
              <table class="datatable table table-bordered table-hover" id="datatable2">
                <thead>
                  <tr>
                    <th style="display: none;"></th>
                    <th>G/L Account</th>
                    <th>Description</th>
                    <th>Group Transaction</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  if (!empty($tampil_coa)) {
                    foreach ($tampil_coa as $v) {
                  ?>
                      <tr onclick="pilih(this)" style="cursor: pointer;">
                        <?php
                        echo "<td style='display:none'>$v->gl_id</td>
                                                        <td>$v->NoCOA</td>
                                                        <td>$v->AccountName</td>
                                                        <td>$v->GroupCOA<label style='display:none'>/$v->RegNo</label></td>
                                                       ";
                        ?>
                      </tr>
                  <?php
                    }
                  }
                  ?>
                </tbody>
              </table>
            </div>
          </div>
          <!-- END PORTLET-->
        </div>
        <div class="col-md-5">
          <div class="note note-success note-bordered">
            <p>
              This page is used to enter a default account number at the time of the transaction journal.
            </p>
          </div>
          <div class="portlet light">
            <div class="portlet-title">
              <div class="caption theme-font">
                <i class="icon-bag theme-font"></i>
                <span class="caption-subject bold uppercase"> GROUP</span>
                <span class="caption-helper">Transaction</span>
              </div>
              <div class="tools">
                <a href="javascript:;" class="expand">
                </a>
              </div>
              <div class="actions">
                <a class="btn btn-circle btn-icon-only btn-default fullscreen" href="javascript:;" data-original-title="" title="">
                </a>
              </div>
            </div>
            <div class="portlet-body" style="display: none;">
              <!-- FORM MASTER GROUP -->
              <form role="form" method="post" action="<?php echo base_url(); ?>default_gl_number/input_group_COA">

                <div class="form-group">
                  <label class="control-label">Group Transaction</label>
                  <input type="text" name="GroupCOA" class="form-control" data-required="1" />
                </div>
                <div class="margiv-top-10">
                  <input type="submit" class="btn blue-dark" value="Save">
                </div>
              </form>
              <!-- FORM MASTER GROUP -->
            </div>
          </div>
          <div class="portlet light">
            <div class="portlet-title">
              <div class="caption theme-font">
                <i class="icon-calculator theme-font"></i>
                <span class="caption-subject bold uppercase"> FORM</span>
                <span class="caption-helper">G/L Account</span>
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
              <form role="form" method="post" action="<?php echo base_url(); ?>index.php/default_gl_number/input_COA">
                <div class="form-group">
                  <label class="control-label">G/L Account</label>
                  <input type="hidden" class="form-control" id="gl_id" name="id_gl" value="0" />
                  <?php
                  $style_COA = "class='select2me form-control' id='NoCOA' required";
                  echo form_dropdown('NoCOA', $list_COA, '', $style_COA);
                  ?>
                  <div class="kotakHasil" id="hasilPencarian" style="display: none;">
                    <div class="daftarPencarian" id="dataPencarian">

                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label">Description</label>
                  <input type="text" id="AccountName" name="AccountName" class="form-control" required />
                </div>
                <div class="form-group">
                  <label class="control-label">Transaction</label>
                  <?php
                  $style_currency = "class='form-control' id='RegNo' required onchange='ubah()'";
                  echo form_dropdown('RegNo', $list_group, '', $style_currency);
                  ?>
                  <input type="hidden" id="GroupCOA" name="GroupCOA" class="form-control" />
                </div>
                <input type="hidden" name="CreatedBy" value="<?php echo $this->session->userdata('userid_1'); ?>" />
                <input type="hidden" name="CreatedDate" value="<?php echo date("Y-m-d"); ?>" />
                <input type="hidden" name="IPAddress" value="<?php echo $_SERVER['REMOTE_ADDR']; ?>" />
                <div class="margiv-top-20">
                  <input type="submit" name="btn" id="btn" class="btn blue-dark" value="Save">
                  <input type="reset" name="reset" id="reset" onclick="reset_tombol()" class="btn red" value="Cancel">
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
<!-- END PROFILE CONTENT -->
</div>
</div>
<!-- END PAGE CONTENT INNER -->
</div>
<!-- END PAGE CONTENT -->

<script>
  function pilih(x) {

    function getText(el) {
      if (typeof el.textContent === 'string')
        return el.textContent;
      if (typeof el.innerText === 'string')
        return el.innerText;
    }

    $r = x.rowIndex;
    var url = "<?php echo base_url(); ?>";

    var gl_id = getText(document.getElementById('datatable2').rows[$r].cells[0]);
    var NumberCOA = getText(document.getElementById('datatable2').rows[$r].cells[1]);
    var AccountCOA = getText(document.getElementById('datatable2').rows[$r].cells[2]);
    var str = getText(document.getElementById('datatable2').rows[$r].cells[3]);
    var Group = str.split("/");

    document.getElementById('gl_id').value = gl_id;
    document.getElementById('NoCOA').selectedIndex = NumberCOA;
    document.getElementById('AccountName').value = AccountCOA;
    document.getElementById('GroupCOA').value = Group[0];
    document.getElementById('RegNo').selectedIndex = Group[1];
    document.getElementById('btn').value = 'Update';

    $('body').scrollTop(0);
  }

  function ubah() {
    var t = document.getElementById("RegNo");
    var selectedText = t.options[t.selectedIndex].text;
    document.getElementById('GroupCOA').value = selectedText;

  }

  function reset_tombol() {
    document.getElementById('btn').value = 'Save';
  }
  $(document).ready(function() {
    $("#datatable2").dataTable({
      "scrollY": 300,
      "scrollX": true
    });
  });
</script>