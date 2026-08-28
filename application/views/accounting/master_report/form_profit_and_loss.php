<div class="page-content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="col-md-7">

          <!-- BEGIN PORTLET-->
          <div class="portlet light">
            <div class="portlet-title">
              <div class="caption theme-font col-md-12">
                <i class="icon-speech theme-font"></i>
                <div class="form-group">
                  <label class="control-label">Group Report</label>
                  <?php
                  $style_currency = "class='select2me form-control' id='category_name' onchange='ubah_tabel()'";
                  echo form_dropdown('category_name', $list_group, '', $style_currency);
                  ?>
                </div>
              </div>
            </div>

            <div class="portlet-body">
              <div id="list_data_coa">
                <?php echo $message; ?>
                <table class="datatable table table-bordered table-hover" id="datatable2">
                  <thead>
                    <tr>
                      <th></th>
                      <th>Number of COA</th>
                      <th>Category Report</th>
                      <th>Account Name</th>
                    </tr>
                  </thead>
                  <tbody>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <!-- END PORTLET-->
        </div>
        <div class="col-md-5">
          <div class="note note-success note-bordered">
            <p>
              This is Chart of Accounts (COA) for Pulau Sambu Singapore. It is used to organize the finances of the entity and
              to segregate expenditures, revenue, assets and liabilities in order to give interested parties a better understanding
              of the financial health of the entity.
            </p>
          </div>

          <div class="portlet light">
            <div class="portlet-title">
              <div class="caption theme-font">
                <i class="icon-bag theme-font"></i>
                <span class="caption-subject bold uppercase"> GROUP</span>
                <span class="caption-helper">Accounting Report</span>
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
              <!-- FORM MASTER GROUP -->
              <form role="form" method="post" action="<?php echo base_url(); ?>Profit_and_lost/input_group">
                <div class="form-group">
                  <label class="control-label">Category</label>
                  <?php
                  $style_cat = "class='form-control' id='category_name'";
                  echo form_dropdown('category_name', $list_cat, '', $style_cat);
                  ?>
                </div>
                <div class="form-group">
                  <label class="control-label">Number</label>
                  <input type="text" name="NoUrut" class="form-control" value="0" data-required="1" />
                </div>
                <div class="form-group">
                  <label class="control-label">Group Name</label>
                  <input type="text" name="GroupCOA" class="form-control" data-required="1" />
                </div>
                <div class="margiv-top-10">
                  <input type="submit" name="sbt" class="btn blue-dark" value="Save">
                </div>
              </form>
              <!-- FORM MASTER GROUP -->
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

    var NumberCOA = getText(document.getElementById('datatable2').rows[$r].cells[0]);
    var AccountCOA = getText(document.getElementById('datatable2').rows[$r].cells[1]);
    var str = getText(document.getElementById('datatable2').rows[$r].cells[2]);
    var Group = str.split("/");

    document.getElementById('no_coa').value = NumberCOA;
    document.getElementById('AccountName').value = AccountCOA;
    document.getElementById('RegNo').selectedIndex = Group[1];
    document.getElementById('tombol').value = 'Update';
    $('body').scrollTop(0);
  }

  function ubah_coa() {
    var no_coa = document.getElementById('no_coa');
    var selectedText = no_coa.options[no_coa.selectedIndex].text;
    var t = selectedText.split("|");
    document.getElementById('AccountName').value = t[1];

  }

  function ubah_tabel() {
    var w = document.getElementById("category_name").value;
    var y = w.split("|");
    var id = y[0];
    var id_group = y[1];
    $.ajax({
      url: "<?php echo base_url(); ?>Profit_and_lost/filter_table?id_kategori=" + id + "&id_group=" + id_group,
      success: function(response) {
        $("#list_data_coa").html(response);
      },
      dataType: "html"
    });
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