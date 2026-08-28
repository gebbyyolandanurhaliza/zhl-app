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
  .txtnum {
    text-align: right;
  }

  input[readonly] {
    background-color: #DEDEDE;
  }

  .inWord {
    width: 100%;
    color: #8775a7;
    font-style: italic;
    padding-left: 10px;
    font-weight: bold;
    background-color: #DEDEDE;
    border-top: none;
    border-left: none;
    border-right: none;
    border-bottom: 1px solid #9C9C9C;
  }
</style>
<div class="page-content">
  <div class="container-fluid">
    <div class="row">

      <form role="form" method="post" action="<?php echo site_url('Transaction_CashBank') . $_actionFrom; ?>" class="form-horizontal">
        <div class="col-md-12">
          <div class="portlet light">
            <div class="portlet-title">
              <div class="caption theme-font">
                <i class="icon-calculator theme-font"></i>
                <span class="caption-subject bold uppercase"> <?php echo $_titleForm['head']; ?></span>
                <span class="caption-helper"> <?php echo $_titleForm['desc']; ?></span>
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
              <div class="row" id="ajax-formAP">
                <div class="col-md-12">
                  <div class="col-sm-4">
                    <div class="form-group">
                      <label class="control-label col-sm-4">Reff. Number</label>
                      <div class="col-sm-8">
                        <input type="text" name="txtFacture" class="form-control input-sm" readonly />
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-sm-4">Voucher number</label>
                      <div class="col-sm-8">
                        <input type="text" style="background-color: #D2E0D1;" id="txtJurNum" name="txtVoucher" class="form-control input-sm" required />
                        <ul class="dropdown-menu txtJurNum" style="margin-left:15px;margin-right:0px; max-height: 300px; overflow-y: scroll;" role="menu" aria-labelledby="dropdownMenu" id="ddJurNum"></ul>
                      </div>
                    </div>
                  </div>

                  <div class="col-sm-4">
                    <div class="form-group">
                      <label class="control-label col-sm-4">Trans Date</label>
                      <div class="col-sm-8">
                        <input name="txtTransDate" type="text" class="form-control input-sm" readonly />
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-sm-4">Voucher Date</label>
                      <div class="col-sm-8">
                        <input name="txtVoucherDate" type="text" class="form-control input-sm date-picker" readonly data-date-format="yyyy-mm-dd" />
                      </div>
                    </div>
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="col-sm-4">
                    <div class="form-group">
                      <label class="control-label col-sm-4">Supplier</label>
                      <div class="col-sm-8">
                        <input type="text" name="txtSuplierID" class="form-control input-sm" readonly />
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-8">
                    <div class="form-group">
                      <label class="control-label col-sm-2">Voucher Remark</label>
                      <div class="col-sm-10">
                        <input type="text" name="txtSuplierRemark" class="form-control input-sm" readonly />
                      </div>
                    </div>
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="col-sm-4">
                    <div class="form-group">
                      <label class="control-label col-sm-4">Voucher Currency</label>
                      <div class="col-sm-8">
                        <select class="form-control input-sm" name="selCurrencyVoucher" disabled>
                          <option value=""></option>
                          <?php foreach ($_selectCurrency as $row) : ?>
                            <option value="<?php echo $row->currency_id; ?>"><?php echo $row->currency_id; ?></option>
                          <?php endforeach; ?>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-4">
                    <div class="form-group">
                      <label class="control-label col-sm-4">Voucher Rate</label>
                      <div class="col-sm-8">
                        <input name="txtRateVoucher" type="text" class="form-control input-sm date-picker" data-date-format="yyyy-mm-dd" readonly />
                      </div>
                    </div>
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="col-sm-4">
                    <div class="form-group">
                      <label class="control-label col-sm-4">Amount</label>
                      <div class="col-sm-8">
                        <input type="text" name="txtTotalVoucher" id="inputTotalVoucher" class="form-control input-sm" readonly="" />
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-4">
                    <div class="form-group">
                      <label class="control-label col-sm-4">to USD</label>
                      <div class="col-sm-8">
                        <input type="text" name="txtRateSGD" class="form-control input-sm" readonly="" />
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="row" id="ajax-formCashBank">
                <div class="col-md-12">
                  <div class="col-sm-4">
                    <div class="form-group">
                      <label class="control-label col-sm-4">Cash Bank</label>
                      <div class="col-sm-8">
                        <input id="inputCOA" style="background-color: #D2E0D1;" onclick="javascript:$('#basic').modal('show'); viewModalMCOA();" type="text" name="txtCashBankCode" class="form-control input-sm" required />
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-8">
                    <div class="form-group">
                      <label class="control-label col-sm-2">Account Name</label>
                      <div class="col-sm-10">
                        <input id="inputCOAremark" type="text" name="txtRemarkCB" class="form-control input-sm" readonly />
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="row" id="ajax-formCurrency">
                <div class="col-md-12">
                  <div class="col-sm-4">
                    <div class="form-group">
                      <label class="control-label col-sm-4">Currency</label>
                      <div class="col-sm-8">
                        <select class="form-control input-sm" name="txtCurrBayar" id="txtCUR2" style="background-color: #D2E0D1;">
                          <option value=""></option>
                          <?php foreach ($_selectCurrency as $row) : ?>
                            <option value="<?php echo $row->currency_symbol; ?>"><?php echo $row->currency_id; ?></option>
                          <?php endforeach; ?>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-4">
                    <div class="form-group">
                      <label class="control-label col-sm-4">Weekly Rate</label>
                      <div class="col-sm-8">
                        <input type="text" name="txtRateBayar" class="form-control input-sm" required />
                      </div>
                    </div>
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="col-sm-4">
                    <div class="form-group">
                      <label class="control-label col-sm-4">Rate Negotiation</label>
                      <div class="col-sm-8">
                        <input type="text" name="txtRateNego" class="form-control input-sm" required />
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-4">
                    <div class="form-group">
                      <label class="control-label col-sm-4">Rate Equivalent</label>
                      <div class="col-sm-8">
                        <input type="text" name="txtRateEqui" class="form-control input-sm" required />
                      </div>
                    </div>
                  </div>

                </div>
              </div>
              <!-- FORM MASTER COA -->
            </div>
          </div>
        </div>

        <div class="col-md-12">
          <!-- BEGIN PORTLET-->
          <div class="portlet light">
            <div class="portlet-title">
              <div class="caption theme-font">
                <i class="icon-calendar theme-font"></i>
                <span class="caption-subject bold uppercase"> Period</span>
                <span class="caption-helper"><?php echo date('F Y', strtotime($_periode)); ?></span>
              </div>
              <div class="actions">
                <a class="btn btn-circle btn-icon-only btn-default fullscreen" href="javascript:;" data-original-title="" title="">
                </a>
              </div>
            </div>
            <div class="portlet-body form">
              <div class="row">
                <div class="col-md-12 table-responsive" style="padding-bottom: 15px;">
                  <table class="table-ismo" id="tbl-payment">
                    <thead>
                      <tr>
                        <th class="text-center" style="width: 42px;">#
                          <!-- <a class="btn btn-xs btn-link baik" data-toggle="modal" href="#basic" onclick="viewModalMCOA()">
                                                        <i class="fa fa-plus"></i></a>-->
                        </th>
                        <th><span class="header-txt">Description</span></th>
                        <th>Amount</th>
                        <th>[USD] Equivalent</th>
                        <th>Currency</th>
                        <th>Account COA</th>
                        <th>Cash Flow</th>
                      </tr>
                    </thead>
                    <tbody id="ajax-tblAP">
                    </tbody>
                  </table>
                </div>
                <br /> <br />
                <div class="col-md-12">
                  <div class="col-sm-12 text-center">
                    <div class="form-group">
                      <input id="amountTerbilang" value="In Word:" type="text" class="inWord" readonly />
                    </div>
                  </div>
                </div>

                <div class="col-md-12" style="padding-top: 10px;">
                  <div class="col-sm-offset-10 col-sm-2 text-center">
                    <div class="form-group">
                      <button class="btn btn-sm btn-success" name="btnSubmit" type="submit">Submit</button>
                      <button class="btn btn-sm btn-warning" id="btnCancel" name="btnCancel" type="button">Cancel</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- END PORTLET-->

          <!--<div id="modalMasterCOA"></div>-->
        </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="basic" tabindex="-1" role="basic" aria-hidden="true">
  <div class="modal-dialog" style="width: 75%;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title">Select Master COA</h4>
      </div>
      <div class="modal-body">
        <div id="modalMasterCOA"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modal-cf" tabindex="-1" role="basic" aria-hidden="true">
  <div class="modal-dialog" style="width: 75%;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title">Select Master Cash Flow</h4>
      </div>
      <div class="modal-body">
        <div id="modalCashFlow"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  $(document).ready(function() {
    $("#btnCancel").click(function() {
      location.reload();
    });

    $("#txtJurNum").keyup(function() {
        $.ajax({
          type: "POST",
          url: "<?php echo base_url(); ?>Transaction_CashBank/getJournalTransactionAP",
          data: {
            keyword: $("#txtJurNum").val()
          },
          dataType: "json",
          success: function(n) {
            n.length > 0 ? ($("#ddJurNum").empty(), $("#txtJurNum").attr("data-toggle", "dropdown"), $("#ddJurNum").dropdown("toggle")) : 0 == n.length && $("#txtJurNum").attr("data-toggle", ""), $.each(n, function(e, d) {
              n.length >= 0 && $("#ddJurNum").append('<li role="presentation" ><a role="menuitem dropdownnameli" class="dropdownlivalue">' + d.NomorAP + "</a></li>");
            });
          }
        });
      }),
      $("ul.txtJurNum").on("click", "li a", function() {
        var idJur = $(this).text();
        bootbox.alert('You choose id: ' + idJur);
        $("#txtJurNum").val(idJur);
        $.ajax({
          url: "<?php echo site_url('Transaction_CashBank/ajaxGetJournalTransactionAP'); ?>",
          type: "POST",
          data: "noAP=" + idJur,
          datatype: "json",
          cache: false,
          success: function(msg) {
            $("#ajax-formAP").html(msg);
          }
        });
        $.ajax({
          url: "<?php echo site_url('Transaction_CashBank/ajaxSetTableTransactionAP'); ?>",
          type: "POST",
          data: "noAP=" + idJur,
          datatype: "json",
          cache: false,
          success: function(msg) {
            $("#ajax-tblAP").html(msg);
          }
        });
      });

    $('#txtCUR2').change(function() {
      var val = $(this).val();
      bootbox.alert('You choose the currency, ' + val);
      $.ajax({
        url: "<?php echo site_url('Transaction_CashBank/ajaxSetAPFormCurrency'); ?>",
        type: "POST",
        data: "curID=" + val,
        datatype: "json",
        cache: false,
        success: function(msg) {
          $("#ajax-formCurrency").html(msg);
        }
      });

      document.getElementById('inCurLastRow').value = val;
    });
  });
</script>
<script type="text/javascript">
  function viewModalMCOA() {
    $("#modalMasterCOA").html("\n\
            <div class='col-md-12'>\n\
                <form role='form' class='form-horizontal'>\n\
                    <div class='form-group'>\n\
                        <label class='col-md-2 control-label text-right'>Find</label>\n\
                        <div class='col-md-10'>\n\
                            <div class='input-group'>\n\
                                <div class='input-icon'>\n\
                                    <input class='form-control input-sm' id='txtFilter' placeholder='You must input key word be search..'>\n\
                                </div>\n\
                                <span class='input-group-btn'>\n\
                                    <button type='button' class='btn btn-sm btn-success' onclick='ajaxMCOA()'>\n\
                                        <i class='fa fa-search'></i> Search</button>\n\
                                </span>\n\
                            </div>\n\
                        </div>\n\
                    </div>\n\
                </form>\n\
            </div>\n\
            <div id='tblMasterCOA-forAjax' class='col-md-12 table-responsive table-scrollable' style='overflow: auto; height:300px;'>\n\
                <table id='tbl-MasterCOA' class='table table-bordered table-striped'>\n\
                    <thead>\n\
                        <tr>\n\
                            <th>COA Number</th>\n\
                            <th>Account Name</th>\n\
                            <th>COA Group</th>\n\
                            <th>Reg Number</th>\n\
                        </tr>\n\
                    </thead>\n\
                    <tbody>\n\
                        <tr ondblclick='addRow(this)'>\n\
                            <td></td><td></td><td></td><td></td>\n\
                        </tr>\n\
                    </tbody>\n\
                </table>\n\
            </div>");
  }

  function viewModalCashFlow(id) {
    //alert(id);
    $("#modalCashFlow").html("\n\
                    <div class='col-md-12'>\n\
                        <form role='form' class='form-horizontal'>\n\
                            <div class='form-group'>\n\
                                <div class='col-md-12'>\n\
                                    <div class='input-group'>\n\
                                        <input class='form-control input-sm' id='id-cf-this' type='hidden' value='" + id + "' readonly>\n\
                                        <input class='form-control input-sm' id='txtFilterCF' placeholder='You can find here...'>\n\
                                        <span class='input-group-btn'>\n\
                                            <button type='button' class='btn btn-sm btn-success' onclick='ajaxMFC()'>\n\
                                                <i class='fa fa-search'></i> Search</button>\n\
                                        </span>\n\
                                    </div>\n\
                                </div>\n\
                            </div>\n\
                        </form>\n\
                    </div>\n\
                    <div id='tblMasterCF-forAjax' class='col-md-12 table-responsive table-scrollable' style='overflow: auto; height:300px;'>\n\
                        <table id='tbl-MasterCF' class='table table-bordered table-striped'>\n\
                            <thead>\n\
                                <tr>\n\
                                    <th>Code</th>\n\
                                    <th>Description</th>\n\
                                    <th>I/O</th>\n\
                                    <th>Realization</th>\n\
                                </tr>\n\
                            </thead>\n\
                            <tbody>\n\
                                <tr onclick='getCF(this)'>\n\
                                    <td></td> <td></td> <td></td> <td></td>\n\
                                </tr>\n\
                            </tbody>\n\
                        </table>\n\
                    </div>");
    $("#modal-cf").modal('show');
  }
</script>
<script src="<?php echo base_url(); ?>assets/global/plugins/bootbox/bootbox.min.js" type="text/javascript"></script>
<script>
  function ajaxMCOA() {
    var key = document.getElementById("txtFilter").value;
    //        alert('<?php // echo base_url(); 
                      ?>/Transaction_CashBank/AjaxGetMasterCOA/'+key);
    //        var finditem = document.getElementById("txtFilter").value;
    $.ajax({
      url: "<?php echo base_url(); ?>/Transaction_CashBank/AjaxGetMasterCOA/" + key,
      success: function(response) {
        $("#tblMasterCOA-forAjax").html(response);
      },
      dataType: "html"
    });
    return false;
  }

  function ajaxMFC() {
    var key = document.getElementById("txtFilterCF").value;
    var realKey = key.replace(' ', '%20');
    $.ajax({
      url: "<?php echo base_url(); ?>/Transaction_CashBank/AjaxGetMasterCF/" + realKey,
      success: function(response) {
        $("#tblMasterCF-forAjax").html(response);
      },
      dataType: "html"
    });
    return false;
  }
</script>

<script>
  function num4digits(num, padding) {
    var zeroes = new Array(padding + 1).join("0");
    return (zeroes + num).slice(-padding);
  }

  function getCF(x) {
    function getText(el) {
      if (typeof el.textContent === 'string') return el.textContent;
      if (typeof el.innerText === 'string') return el.innerText;
    }

    $r = x.rowIndex;

    var idThisInput = document.getElementById('id-cf-this').value;
    var cfCode = getText(document.getElementById('tbl-MasterCF').rows[$r].cells[0]);
    var cfKey = getText(document.getElementById('tbl-MasterCF').rows[$r].cells[4]);

    document.getElementById(idThisInput).value = cfCode;
    document.getElementById(idThisInput + '-key').value = cfKey;

    $("#modal-cf").modal('hide');
  }

  function addRow(x) {
    function getText(el) {
      if (typeof el.textContent === 'string') return el.textContent;
      if (typeof el.innerText === 'string') return el.innerText;
    }

    $r = x.rowIndex;
    var noCOA = getText(document.getElementById('tbl-MasterCOA').rows[$r].cells[0]);
    document.getElementById('inputCOA').value = getText(document.getElementById('tbl-MasterCOA').rows[$r].cells[0]);
    document.getElementById('inputCOAremark').value = getText(document.getElementById('tbl-MasterCOA').rows[$r].cells[1]);

    var total = $("#inputAmountRow1").val();
    $.ajax({
      url: "<?php echo site_url('Transaction_CashBank/ajaxSetTableTransactionAProw'); ?>",
      type: "POST",
      data: "noCOA=" + noCOA + "&total=" + total,
      datatype: "json",
      cache: false,
      success: function(msg) {
        $("#rowCashBank").html(msg);
      }
    });

    $("#basic").modal('hide');
  }
</script>