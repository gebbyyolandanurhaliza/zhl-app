<div class="page-content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="col-md-12">
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
                    <th>Department Account</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  if (!empty($tampil_coa)) {
                    foreach ($tampil_coa as $v) {
                  ?>
                      <tr>
                        <?php
                        echo "<td>$v->no_coa</td>"
                          . "<td>$v->nama_akun</td>"
                          . "<td>$v->group_coa<label style='display:none'>/$v->id_coa</label></td>"
                          . "<td>$v->dept_name<label style='display:none'>/$v->dept_coa</label></td></td>";
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

    var NumberCOA = getText(document.getElementById('datatable2').rows[$r].cells[0]);
    var AccountCOA = getText(document.getElementById('datatable2').rows[$r].cells[1]);
    var str = getText(document.getElementById('datatable2').rows[$r].cells[2]);
    var Group = str.split("/");
    var strDept = getText(document.getElementById('datatable2').rows[$r].cells[3]);
    var Dept = strDept.split("/");

    document.getElementById('NoCOA').value = NumberCOA;
    document.getElementById('AccountName').value = AccountCOA;
    document.getElementById('GroupCOA').value = Group[0];
    document.getElementById('RegNo').selectedIndex = Group[1];
    document.getElementById('DeptCOA').value = Dept[0];
    document.getElementById('DeptNo').selectedIndex = Dept[1];
    document.getElementById('tombol').value = 'Update';
    $('body').scrollTop(0);
  }

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

  function ubahDept() {
    var t = document.getElementById("DeptNo");
    var selectedText = t.options[t.selectedIndex].text;
    document.getElementById('DeptCOA').value = selectedText;
  }

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