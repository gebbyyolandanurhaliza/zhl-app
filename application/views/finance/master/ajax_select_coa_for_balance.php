<div class="row">
  <div class="col-md-12">
    <table class="table table-striped table-hover" id="table-select-coa">
      <thead>
        <tr>
          <th>Chart of Account</th>
          <th>Account Name</th>
          <th>COA Group</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($_selectSettingBalance as $row) : ?>
          <tr onclick="addRow(this)">
            <td><?php echo $row->NoCOA; ?></td>
            <td><?php echo $row->AccountName; ?></td>
            <td><?php echo $row->GroupCOA; ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>

  <div class="col-md-12">
  </div>
  <div class="col-md-12">
    <div class="portlet light">
      <div class="portlet-title">
        <div class="caption theme-font">
          <i class="icon-calculator theme-font"></i>
          <span class="caption-subject bold uppercase"> New Record</span>
          <span class="caption-helper"> Beginning Balance</span>
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
        <form id="form-as" role="form" method="post" action="<?php echo site_url('Master_CashFlow/submitBalanceCOA'); ?>" class="form-horizontal">
          <table class="table-ismo" id="tbl-form-tambah">
            <thead>
              <tr>
                <th class="text-center" style="width: 42px;">#
                </th>
                <th>No COA</th>
                <th>Account Name</th>
                <th class="display-none">Currency</th>
                <th>Balance</th>
              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>
          <div class="row">
            <div class="col-md-12 text-right" style="padding-top: 10px;">
              <button class="simpan btn btn-sm btn-success" type="submit">
                <i class="fa fa-save"></i> Submit
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>


<script type="text/javascript">
  $(document).ready(function() {
    $("#table-select-coa").dataTable();
  });
</script>
<script type="text/javascript">
  function addRow(x) {

    function getText(el) {
      if (typeof el.textContent === 'string') return el.textContent;
      if (typeof el.innerText === 'string') return el.innerText;
    }

    $r = x.rowIndex;

    var noCOA = getText(document.getElementById('table-select-coa').rows[$r].cells[0]);
    var nameCOA = getText(document.getElementById('table-select-coa').rows[$r].cells[1]);
    //alert('as'+noCOA);
    $('table[id="tbl-form-tambah"]').append('<tr >\n\
            <td class="text-center" style="vertical-align: middle;">\n\
                <button class="btn btn-xs btn-link buruk" type="button" onclick="deleteRow(this)"><i class="fa fa-trash-o"></i></button></td>\n\
            <td nowrap><input type="text" name="txtNoCOA[]"  class="txt" value="' + noCOA + '" readonly/></td>\n\
            <td nowrap><input type="text" name="txtNameCOA[]" class="txt" value="' + nameCOA + '" readonly/></td>\n\
            <td nowrap><input type="number" name="txtSaldoAwal[]" class="txt" /></td>\n\
        </tr>');
  }

  function deleteRow(x) {
    var row = x.parentNode.parentNode;

    bootbox.confirm("Are you sure?", function(result) {
      if (result == true) {
        row.parentNode.removeChild(row);
      }
    });
  }
</script>