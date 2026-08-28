<style>
  .txt {
    border: 1px solid #fff;
    width: 100%
  }

  .biasa {
    color: #9C9C9C
  }

  .baik {
    color: #2AAD2E
  }

  .buruk {
    color: #CC2525
  }

  .table-ismo {
    white-space: normal;
    line-height: normal;
    font-weight: 400;
    font-size: medium;
    font-variant: normal;
    font-style: normal;
    color: -webkit-text;
    width: 100%
  }

  .table-ismo th {
    background-color: #DEDEDE;
    text-align: center;
    vertical-align: bottom;
    height: 30px;
    padding: 3px 0;
    border: 1px solid #ADADAD;
    white-space: nowrap;
    width: auto
  }

  .table-ismo td {
    padding: 1px 0;
    border: 1px solid #ADADAD
  }
</style>
<style>
  input[readonly] {
    background-color: #DEDEDE;
  }
</style>
<div class="page-content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="portlet light">
          <div class="portlet-title">
            <div class="caption theme-font">
              <i class="icon-calculator theme-font"></i>
              <span class="caption-subject bold uppercase"> Setting</span>
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
          <div class="portlet-body" id="ajaxForm">
            <div class="row">
              <div class="col-md-12">
                <div class="col-md-offset-2 col-md-8 text-right" style="padding-bottom: 10px;">
                  <button id="btn-select-coa" class="btn btn-sm btn-default">Add Account</button>
                </div>
                <div class="col-md-offset-2 col-md-8 table-responsive">
                  <table class="table table-striped table-hover" id="table-setting-balance">
                    <thead>
                      <tr>
                        <th>Chart of Account</th>
                        <th>Account Name</th>
                        <th>Currency</th>
                        <th>Balance</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach ($_selectSettingBalance as $row) : ?>
                        <tr>
                          <td>
                            <a data-saldo="<?php echo $row->saldo_awal; ?>" data-key="<?php echo $row->saldo_id; ?>" data-id="<?php echo $row->NoCOA; ?>" data-name="<?php echo $row->AccountName; ?>" data-currency="<?php echo $row->currency; ?>" href="javascript:;" class="act-setting">
                              <?php echo $row->NoCOA; ?> </a>
                          </td>
                          <td><?php echo $row->AccountName; ?></td>
                          <td class="text-center"><?php echo $row->currency; ?></td>
                          <td class="text-right"><?php echo number_format($row->saldo_awal, 2); ?></td>
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
    </div>
  </div>
</div>

<div class="modal fade" id="modal-setting" data-width="75%" tabindex="-1" role="basic" aria-hidden="true">
  <div class="modal-dialog" style="width: 50%;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title">Update Begining Balance</h4>
      </div>
      <div class="modal-body" id="ajaxSettingBalance">
        <form id="form-transCashBank" role="form" method="post" action="<?php echo site_url('Master_CashFlow/updateBalanceCOA'); ?>" class="form-horizontal">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label class="control-label col-sm-2">COA</label>
                <div class="col-sm-10">
                  <input name="txtCOAKey" id="txtInputCOAKey" type="hidden" class="form-control input-sm" readonly>
                  <input name="txtCOA" id="txtInputCOA" type="text" class="form-control input-sm" readonly>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-sm-2">Account Name</label>
                <div class="col-sm-10">
                  <input name="txtCOAname" id="txtInputCOAname" type="text" class="form-control input-sm" readonly>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-sm-2">Currency</label>
                <div class="col-sm-10">
                  <select name="txtCurrency" id="txtInputCurrency" class="form-control input-sm">
                    <option value=""> Choose...</option>
                    <?php foreach ($_selectMstCurrency as $mstCur) : ?>
                      <option value="<?php echo $mstCur->currency_symbol; ?>"><?php echo $mstCur->currency_id; ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-sm-2">Balance</label>
                <div class="col-sm-10">
                  <input name="txtSaldo" id="txtInputSaldoe" type="text" class="form-control input-sm">
                </div>
              </div>
              <div class="row">
                <div class="col-sm-12 text-right">
                  <button id="btnDeleteCOA" class="simpan btn btn-sm btn-danger" type="button">
                    <i class="fa fa-trash-o"></i> Delete
                  </button>
                  <button class="simpan btn btn-sm btn-success" type="submit">
                    <i class="fa fa-save"></i> Update
                  </button>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
      <!-- <div class="modal-footer">
                <button type="button" class="btn default" data-dismiss="modal">Close</button>
            </div> -->
    </div>
  </div>
</div>

<!-- Select No COA From Master COA (Modal)-->
<div class="modal fade" id="modal-selectCOA" data-backdrop="static" data-width="75%" tabindex="-1" role="basic" aria-hidden="true">
  <div class="modal-dialog" style="width: 50%;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title">Select Chart of Account</h4>
      </div>
      <div class="modal-body" id="ajaxSelectCOA">
        Loading...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  $(document).ready(function() {
    $("#table-setting-balance").dataTable();

    $("#modal-setting").draggable({
      handle: ".modal-header"
    });
  });
</script>

<script src="<?php echo base_url(); ?>assets/global/plugins/bootbox/bootbox.min.js" type="text/javascript"></script>
<script type="text/javascript">
  $('#table-setting-balance tbody tr td a.act-setting').click(function() {
    var key = $(this).data('key');
    var id = $(this).data('id');
    var name = $(this).data('name');
    var saldo = $(this).data('saldo');
    var curr = $(this).data('currency');

    $('#txtInputCOAKey').val(key);
    $('#txtInputCOA').val(id);
    $('#txtInputCOAname').val(name);
    $('#txtInputSaldoe').val(saldo);
    $('#txtInputCurrency').val(curr);
    //alert('djsgatd dskjhdk - '+id);

    $('#modal-setting').modal('show');
  });

  $('#btnDeleteCOA').click(function() {
    var id = $('#txtInputCOAKey').val();
    var coa = $('#txtInputCOA').val();

    bootbox.confirm('Are you sure to delete this COA :' + coa + ' ?', function(result) {
      if (result == true) {
        window.location = '<?php echo site_url('Master_CashFlow/deleteBalanceCOA'); ?>/' + id;
      }
    });
  });

  $('#btn-select-coa').on('click', function() {
    $.ajax({
      url: "<?php echo site_url('Master_CashFlow/ajaxSelectCOA'); ?>",
      type: "POST",
      datatype: "json",
      cache: false,
      success: function(msg) {
        $("#ajaxSelectCOA").html(msg);
      }
    });

    $('#modal-selectCOA').modal('show');
  });
</script>