<div class="page-content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="col-md-7">
          <div class="note note-success note-bordered">
            <p>
              This is Chart of Accounts (COA) for Pulau Sambu Singapore. It is used to organize the finances of the entity and
              to segregate expenditures, revenue, assets and liabilities in order to give interested parties a better understanding
              of the financial health of the entity.
            </p>
          </div>
          <!-- BEGIN PORTLET-->
          <div class="portlet light">
            <div class="portlet-title">
              <div class="caption theme-font">
                <i class="icon-speech theme-font"></i>
                <span class="caption-subject bold uppercase"> Number Of COA</span>
                <span class="caption-helper">Master Number of COA</span>
              </div>
              <div class="kanan">
                <a class="btn green" href="<?php echo base_url(); ?>Excel/toExcelCoa"><i class="fa fa-file-excel-o"></i> Export to excel</a>
              </div>
            </div>
            <div class="portlet-body">
              <table class="datatable table table-bordered table-hover" id="datatable2">
                <thead>
                  <tr>
                    <th>Number of COA</th>
                    <th>Account Name</th>
                    <th>Group COA</th>
                    <th hidden>New COA Number</th>
                    <th hidden>Kode Department</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  if (!empty($tampil_coa)) {
                    foreach ($tampil_coa as $v) {
                  ?>
                      <tr onclick="pilih(this)" style="cursor: pointer;">
                        <?php
                        echo "<td>$v->Kombinasi_COA</td>"
                          . "<td>$v->AccountName</td>"
                          . "<td>$v->GroupName<label style='display:none'>/$v->GroupCOA</label></td>"
                          . "<td hidden>$v->NoCOA</td>"
                          . "<td hidden>$v->kode_department</td>";
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

          <?php echo $message; ?>
          <div class="portlet light">
            <div class="portlet-title">
              <div class="caption theme-font">
                <i class="icon-bag theme-font"></i>
                <span class="caption-subject bold uppercase"> GROUP</span>
                <span class="caption-helper">Chart of Accounts</span>
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
              <form role="form" method="post" action="<?php echo base_url(); ?>Master_COA/input_group_COA">

                <div class="form-group">
                  <label class="control-label">Group COA</label>
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
                <span class="caption-helper">Chart of Accounts</span>
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
              <form role="form" method="post" action="<?php echo base_url(); ?>index.php/Master_COA/input_COA">
                <div class="form-group">
                  <label class="control-label">Number COA</label>
                  <input type="text" id="NoCOA" name="NoCOA" class="form-control" onkeyup="cek_coa()" required />
                  <div id="err"></div>
                </div>
                <div class="form-group">
                  <label class="control-label">Account Name</label>
                  <input type="text" id="AccountName" name="AccountName" class="form-control" required />
                </div>
                <div class="form-group">
                  <label class="control-label">Group COA</label>
                  <?php
                  $style_currency = "class='form-control' id='RegNo' onchange='ubah()'";
                  echo form_dropdown('RegNo', $list_group, '', $style_currency);
                  ?>
                  <input type="hidden" id="GroupCOA" name="GroupCOA" class="form-control" />
                </div>
                <div class="form-group">
                  <label class="control_label">Department Account</label>
                  <?php
                  $style_dept = "class='form-control' id='DeptNo'";
                  echo form_dropdown('DeptNo', $list_dept, '', $style_dept);
                  ?>
                  <input type="hidden" id="DeptCOA" name="DeptCOA" class="form-control" />
                </div>
                <!-- <div class="form-group">
                  <label class="control-label">New COA Number</label>
                  <input type="text" id="NewCOA" name="NewCOA" class="form-control" required />
                  <div id="err"></div>
                </div> -->
                <input type="hidden" name="company_id" id="company_id" value="<?php echo $this->session->userdata('company_id'); ?>" />
                <input type="hidden" name="CreatedBy" value="<?php echo $this->session->userdata('userid_1'); ?>" />
                <input type="hidden" name="CreatedDate" value="<?php echo date("Y-m-d"); ?>" />
                <input type="hidden" name="IPAddress" value="<?php echo $_SERVER['REMOTE_ADDR']; ?>" />
                <div class="margiv-top-10">
                  <input type="submit" name="sbt" id="tombol" class="btn blue-dark" value="Save">
                  <?php 
                    if (in_array($user_id, ["fauzi", "nick", "gebby", "anisa"])) {
                  ?>
                    <button type="button" id="deleteBtn" class="btn btn-danger" style="float:right; display: none;">Delete</button>
                  <?php } ?>
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

    var NumberCOA = getText(document.getElementById('datatable2').rows[$r].cells[3]);
    var AccountCOA = getText(document.getElementById('datatable2').rows[$r].cells[1]);
    var str = getText(document.getElementById('datatable2').rows[$r].cells[2]);
    var newCoaNumb = getText(document.getElementById('datatable2').rows[$r].cells[3]);
    var Group = str.split("/");
    var dept_code = getText(document.getElementById('datatable2').rows[$r].cells[4]);

    var table = document.getElementById('datatable2');

    for (var rowIndex = 1; rowIndex < table.rows.length; rowIndex++) { 
        var row = table.rows[rowIndex]; 
        var rowData = [];

        for (var cellIndex = 0; cellIndex < row.cells.length; cellIndex++) {
            var cellText = row.cells[cellIndex].innerText;
            rowData.push(cellText);
        }
        console.log('Baris ' + rowIndex + ':', rowData);
    }

    document.getElementById('NoCOA').value = NumberCOA;
    document.getElementById('AccountName').value = AccountCOA;
    document.getElementById('GroupCOA').value = Group[0];
    document.getElementById('RegNo').selectedIndex = Group[1];
    document.getElementById('DeptNo').value = dept_code;
    
    document.getElementById('tombol').value = 'Update';
    document.getElementById('deleteBtn').style.display = 'inline-block';
    $('body').scrollTop(0);
  }

  $('#deleteBtn').on('click', function () {
    var NoCOA = $('#NoCOA').val(); 
    var DeptNo = $('#DeptNo').val();
    var company_id = $('#company_id').val(); 
    if (confirm('Are you sure you want delete this data?')) {
      $.ajax({
          url: "<?php echo base_url('Master_COA/delete_COA'); ?>",
          type: "POST",
          data: { NoCOA: NoCOA,
                  DeptNo: DeptNo,
                  company_id: company_id
                },
          success: function (response) {
            console.log(response);
            location.reload();
          },
          error: function () {
              alert("Gagal menghapus data");
          }
      });
    }
  });

  function cek_coa() {
    var NoCOA = document.getElementById('NoCOA').value;
    $.ajax({
      url: "<?php echo base_url(); ?>Master_COA/cek_coa?id=" + NoCOA,
      success: function(response) {
        $("#err").html(response);
      },
      dataType: "html"
    });
  }

  function ubah() {
    var t = document.getElementById("RegNo");
    var selectedText = t.options[t.selectedIndex].text;
    document.getElementById('GroupCOA').value = selectedText;
  }

  // function ubahDept() {
  //   var t = document.getElementById("DeptNo");
  //   var selectedText = t.options[t.selectedIndex].text;
  //   document.getElementById('DeptCOA').value = selectedText;
  // }

  function ubah_group() {
    var t = document.getElementById("id_journal");
    var selectedText = t.options[t.selectedIndex].text;
    document.getElementById('GroupJournal').value = selectedText;
  }
  $(document).ready(function() {
    $("#datatable2").dataTable({
      "scrollY": 350,
      "scrollX": true
    });
  });
</script>