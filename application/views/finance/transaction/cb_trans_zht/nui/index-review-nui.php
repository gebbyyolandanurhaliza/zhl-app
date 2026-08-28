<style>
  input[readonly] {
    background-color: #DEDEDE
  }

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
  .row-selected {
    color: red;
  }

  .txtnum {
    text-align: right;
  }

  .ismo-hidden {
    display: none;
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
<script type="text/javascript">
  (function(b) {
    var c = {
      allowFloat: false,
      allowNegative: false
    };
    b.fn.numericInput = function(e) {
      var f = b.extend({}, c, e);
      var d = f.allowFloat;
      var g = f.allowNegative;
      this.keypress(function(j) {
        var i = j.which;
        var h = b(this).val();
        if (i > 0 && (i < 48 || i > 57)) {
          if (d == true && i == 46) {
            if (g == true && a(this) == 0 && h.charAt(0) == "-") {
              return false
            }
            if (h.match(/[.]/)) {
              return false
            }
          } else {
            if (g == true && i == 45) {
              if (h.charAt(0) == "-") {
                return false
              }
              if (a(this) != 0) {
                return false
              }
            } else {
              if (i == 8) {
                return true
              } else {
                return false
              }
            }
          }
        } else {
          if (i > 0 && (i >= 48 && i <= 57)) {
            if (g == true && h.charAt(0) == "-" && a(this) == 0) {
              return false
            }
          }
        }
      });
      return this
    };

    function a(d) {
      if (d.selectionStart) {
        return d.selectionStart
      } else {
        if (document.selection) {
          d.focus();
          var f = document.selection.createRange();
          if (f == null) {
            return 0
          }
          var e = d.createTextRange(),
            g = e.duplicate();
          e.moveToBookmark(f.getBookmark());
          g.setEndPoint("EndToStart", e);
          return g.text.length
        }
      }
      return 0
    }
  }(jQuery));
</script>

<div class="page-content">
  <div class="container-fluid">
    <div class="row">
      <form id="form-transCashBank" role="form" method="post" action="<?php echo site_url('CBtransNui/deleteCashBankTransaction'); ?>" class="form-horizontal">

        <div class="col-md-12">
          <!-- <div class="note note-success note-bordered">
                        <p>
                            Active Period : <?php //echo $this->session->userdata('periode_1');
                                            ?>  | <a href="<?php //echo base_url();
                                                                                                              ?>Period">Change</a>
                        </p>
                    </div> -->
          <div class="portlet light">
            <div class="portlet-title">
              <div class="caption theme-font">
                <i class="icon-calculator theme-font"></i>
                <span class="caption-subject bold uppercase"> TRANSACTION</span>
                <span class="caption-helper">Cash Bank</span>
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
            <div class="portlet-body form">
              <div class="form-body">
                <div class="row">
                  <div class="col-md-12">
                    <div class="col-sm-4">
                      <div id="div-ReffNum" class="form-group">
                        <label class="control-label col-sm-4">Reference Number
                          <input type="hidden" name="txtPrimaryCashBank" value="<?php echo encode_str($_selectHeader->header_id); ?>" />
                        </label>
                        <div class="col-sm-8">
                          <div class="input-icon input-icon-sm right">
                            <i id="btn-generate-noreff" class="fa fa-refresh"></i>
                            <input type="text" value="<?php echo $_selectHeader->no_reff; ?>" id="inputNoReff" name="txtNoReff" placeholder="Input or Generate Referance Number" maxlength="20" class="form-control input-sm" required />
                            <span id="alert-errorReff" class="help-block" style="display: none;">Please use another num reff.! </span>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="col-sm-4">
                      <div class="form-group">
                        <label class="control-label col-sm-2">I/O Type</label>
                        <div class="col-sm-10">
                          <!-- <input type="text" id="txtInputIOtype" class="form-control input-sm"/> -->
                          <select class="form-control input-sm" name="txtIO" id="inputIOCest">
                            <option value="">Choose...</option>
                            <?php foreach ($_selectIOtype as $io) : ?>
                              <?php if ($_selectHeader->io_code == $io->io_code) : ?>
                                <option value="<?php echo $io->io_code; ?>" selected><?php echo $io->io_description; ?></option>
                              <?php else : ?>
                                <option value="<?php echo $io->io_code; ?>"><?php echo $io->io_description; ?></option>
                              <?php endif; ?>
                            <?php endforeach; ?>
                          </select>
                          <input type="hidden" id="poTXTtypeIO" name="txtIOtypeForPO" />
                        </div>
                      </div>
                    </div>

                    <div class="col-sm-4">
                      <div class="form-group">
                        <label class="control-label col-sm-2">Date </label>
                        <div class="col-sm-10">
                          <input id="txtInputDateTrans" name="txtDate1" type="text" class="form-control input-sm date-picker" data-date-format="dd-mm-yyyy" value="<?php echo date('d-m-Y', strtotime($_selectHeader->date1)); ?>" readonly>
                        </div>
                      </div>
                      <div class="form-group ismo-hidden">
                        <label class="control-label col-sm-2">Date 2</label>
                        <div class="col-sm-10">
                          <input name="txtDate2" type="text" class="form-control input-sm date-picker" data-date-format="dd-mm-yyyy">
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="col-md-12">
                    <div class="col-sm-8">
                      <div class="form-group">
                        <label class="control-label col-sm-2">C/B Code</label>
                        <div class="col-sm-10">
                          <select class="form-control input-sm" data-placeholder="Choose..." name="selCBCode" id="selInputCBCode" onchange="changeCodeCB(this)">
                            <option value=""></option>
                            <?php foreach ($_selectMasterCOA as $row) : ?>
                              <?php if ($_selectHeader->cashbank_code == $row->NoCOA) : ?>
                                <option value="<?php echo $row->NoCOA; ?>" selected><?php echo $row->NoCOA; ?> ~ <?php echo $row->AccountName; ?></option>
                              <?php else : ?>
                                <option value="<?php echo $row->NoCOA; ?>"><?php echo $row->NoCOA; ?> ~ <?php echo $row->AccountName; ?></option>
                              <?php endif; ?>
                            <?php endforeach; ?>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <div class="form-group">
                        <div class="col-sm-12">
                          <input type="text" value="<?php echo $_selectHeader->AccountName; ?>" id="txtInputRemark" name="txtRemark" class="form-control input-sm hanya-baca" required />
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="col-md-12">
                    <div class="col-sm-8">
                      <div class="form-group">
                        <label class="control-label col-sm-2">Check Number</label>
                        <div class="col-sm-10">
                          <input type="text" id="txtInputCheckBank" value="<?php echo $_selectHeader->check_bank; ?>" name="txtCheckBank" class="form-control input-sm" required />
                        </div>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <input type="text" id="txtblankk" name="txtblankk" class="form-control input-sm txtnum display-none" readonly required />
                    </div>
                  </div>
                  <br />

                  <div class="col-md-8">
                    <div class="well well-sm" style="background-color: #DEDEDE">
                      <div class="row">
                        <label class="control-label col-sm-12">Employe</label>
                        <div class="col-sm-2">
                          <input type="text" id="txtInputKaryawanID" name="txtKaryawanID" value="<?php if ($_selectHeader->type_trans == 'O') {
                                                                                                    echo $_selectHeader->supp_id;
                                                                                                  } else {
                                                                                                    echo $_selectHeader->cust_id;
                                                                                                  } ?>" placeholder="Employe ID" class="form-control input-sm" />
                        </div>
                        <div class="col-sm-4">
                          <input type="text" id="txtInputKaryawanName" name="txtKaryawanName" placeholder="Employe Name" class="form-control input-sm" readonly />
                        </div>
                        <div class="col-sm-2">
                          <input type="text" id="txtInputKaryawanCOA" name="txtKaryawanCOA" value="<?php if ($_selectHeader->type_trans == 'O') {
                                                                                                      echo $_selectHeader->supp_coa;
                                                                                                    } else {
                                                                                                      echo $_selectHeader->cust_coa;
                                                                                                    } ?>" placeholder="Select COA" class="form-control input-sm" />
                        </div>
                        <div class="col-sm-4">
                          <input type="text" id="txtInputKaryawanCOAname" name="txtKaryawanCOAname" placeholder="COA Description" class="form-control input-sm" readonly />
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="col-md-4">
                    <div class="col-sm-12">
                      <div class="form-group">
                        <label class="control-label col-sm-3">Currency</label>
                        <div class="col-sm-9">
                          <select class="form-control input-sm" data-placeholder="Choose Currency..." name="txtCurr" id="txtInputCurr">
                            <option value=""></option>
                            <?php foreach ($_selectCurrency as $row) : ?>
                              <?php if ($_selectHeader->currency_id == $row->currency_symbol) : ?>
                                <option value="<?php echo $row->currency_symbol; ?>" selected><?php echo $row->currency_id; ?></option>
                              <?php else : ?>
                                <option value="<?php echo $row->currency_symbol; ?>"><?php echo $row->currency_id; ?></option>
                              <?php endif; ?>
                            <?php endforeach; ?>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-12">
                      <div class="form-group">
                        <label class="control-label col-sm-3">Rate</label>
                        <div class="col-sm-9">
                          <input type="text" id="txtInputRate" value="<?php echo $_selectHeader->currency_rate; ?>" name="txtRateCurr" class="form-control input-sm hanya-baca txtnum" data-m-dec="6" required />
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-12">
                      <div class="form-group">
                        <label class="control-label col-sm-3">Rate SGD</label>
                        <div class="col-sm-9">
                          <input type="text" id="txtInputRateSGD" value="<?php echo $_selectHeader->rate_sgd; ?>" name="txtRateCurrSGD" class="form-control input-sm hanya-baca txtnum" data-m-dec="6" required />
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="col-md-8">
                    <div class="form-group">
                      <label class="control-label col-sm-2">Transaction Remark </label>
                      <div class="col-sm-10">
                        <textarea name="txtTransRemark" class="form-control"><?php echo $_selectHeader->trans_description; ?></textarea>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

            </div>
          </div>
        </div>

        <div class="col-md-12">
          <!-- BEGIN PORTLET-->
          <div class="portlet light">
            <div class="portlet-title">
              <div class="caption theme-font">
                <i class="icon-speech theme-font"></i>
                <span class="caption-subject bold uppercase"> General Cash Bank</span>
                <span class="caption-helper">Transaction</span>
              </div>
              <div class="actions">
                <a class="btn btn-circle btn-icon-only btn-default fullscreen" href="javascript:;" data-original-title="" title="">
                </a>
              </div>
            </div>
            <div class="portlet-body table-responsive">
              <table class="table-ismo" id="tbl-cashGeneral">
                <thead>
                  <tr>
                    <th class="text-center" style="width: 42px;">
                      <a class="btn btn-xs btn-link baik" data-toggle="modal" id="btnSelectMCOA">
                        <i class="fa fa-plus"></i></a>
                    </th>
                    <th style="width: 10%;">Account Number</th>
                    <th style="width: 20%;">Name</th>
                    <th style="width: 10%;">Debit</th>
                    <th style="width: 10%;">Credit</th>
                    <th>Remark</th>
                    <th style="width: 10%;">GST Name</th>
                    <th style="width: 10%;">GST Value</th>
                  </tr>
                </thead>
                <tbody>
                  <?php $nn = 1;
                  foreach ($_selectDetail as $dtl) : ?>
                    <tr id="rowSetCOA">
                      <td class="text-center" style="vertical-align: middle;">
                        <?php if (is_int($nn++ / 2)) : ?>
                          <button class="btn btn-xs btn-link biasa" type="button"><i class="fa fa-arrow-up"></i></button>
                        <?php else : ?>
                          <button class="btn btn-xs btn-link biasa" type="button"><i class="fa fa-arrow-down"></i></button>
                        <?php endif; ?>
                      </td>
                      <td nowrap><input value="<?php echo $dtl->coa; ?>" type="text" name="txtNoCOA[]" id="txtInputCOAsuppRow-1" class="txt" readonly /></td>
                      <td nowrap><input value="<?php echo $dtl->coa_description; ?>" type="text" name="txtNameCOA[]" id="txtInputNameSuppRow-1" class="txt" readonly /></td>
                      <td nowrap><input value="<?php echo $dtl->debit; ?>" type="text" name="txtDebit[]" id="txtInputDebitCBdetailRow-1" class="col-debit txt txtnum" /></td>
                      <td nowrap><input value="<?php echo $dtl->credit; ?>" type="text" name="txtCredit[]" id="txtInputCreditCBdetailRow-1" class="col-credit txt txtnum" /></td>
                      <td nowrap><input value="<?php echo $dtl->remark; ?>" type="text" name="txtRemark[]" class="txt" /></td>
                      <td nowrap>
                        <select name="txtGST[]" class="txt gst-name">
                          <option value=""> -- Select --</option>
                          <?php foreach ($_selectGST as $gst) : ?>
                            <?php if ($gst->gst_id == $dtl->gst_type) : ?>
                              <option value="<?php echo $gst->gst_id; ?>" selected> <?php echo $gst->gst_name; ?></option>
                            <?php else : ?>
                              <option value="<?php echo $gst->gst_id; ?>"> <?php echo $gst->gst_name; ?></option>
                            <?php endif; ?>
                          <?php endforeach; ?>
                        </select>
                      </td>
                      <td nowrap><input type="text" value="<?php echo number_format($dtl->gst_value, 2); ?>" name="txtGSTvalue[]" class="txt txtnum gst-value" /></td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
            <div class="portlet-body">
              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group">
                    <label class="col-sm-12" for="">Amount Debit</label>
                    <div class="col-sm-12">
                      <input class="form-control txtnum" name="txtAmountDebit" id="inputAmountDebit" type="text" readonly="" />
                    </div>
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="form-group">
                    <label class="col-sm-12" for="">Amount Credit</label>
                    <div class="col-sm-12">
                      <input class="form-control txtnum" name="txtAmountCredit" id="inputAmountCredit" type="text" readonly="" />
                    </div>
                  </div>
                </div>

                <div id="alert-balanceAmount" class="col-sm-12" style="display: none;">
                  <div class="note note-danger note-bordered">
                    <p>
                      Amount of Debit and Credit be must balanced
                    </p>
                  </div>
                </div>
              </div>
            </div>
            <div class="portlet-body">
              <div class="row">
                <div class="col-md-6">
                  <button class="btn btn-sm btn-primary" id="btnFindRecord" type="button">
                    Find <i class="fa fa-sm fa-search fa-fw" aria-hidden="true"></i> </button>
                  <button class="btn btn-sm btn-default disabled display-none" id="btnPrint" type="button">
                    Print <i class="fa fa-sm fa-print fa-fw" aria-hidden="true"></i></button>
                </div>
                <div class="col-md-6 text-right">
                  <button class="simpan btn btn-sm btn-danger" type="submit">
                    <i class="fa fa-trash-o"></i> Delete
                  </button>
                  <button class="btn btn-sm btn-neutral" type="reset" onclick="javascript: window.location = '<?php echo site_url("CBtransNui"); ?>'">
                    <i class="fa fa-refresh"></i> Cancel
                  </button>
                </div>
              </div>
            </div>
          </div>

          <!-- END PORTLET-->
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Find Recorded Cash Bank Transaction Modal -->
<div class="modal fade" id="modal-findCB" tabindex="-1" role="basic" aria-hidden="true">
  <div class="modal-dialog" style="width: 75%;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title">Select Cash Bank Transaction</h4>
      </div>
      <div id="contentFindCB" class="modal-body">
        Loading...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script src="<?php echo base_url(); ?>assets/global/plugins/bootbox/bootbox.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/autoNumeric-min.js" type="text/javascript"></script>
<script type="text/javascript">
  $(document).ready(function() {
    $('input, textarea').attr('readonly', true);
    $("select :selected").each(function() {
      $(this).parent().data("default", this);
    });
    $("select").change(function(e) {
      $($(this).data("default")).prop("selected", true);
    });
    $('.txtnum').autoNumeric('init');

    CountBelance();
    $("#form-transCashBank").submit(function(e) {
      var currentForm = this;
      e.preventDefault();
      bootbox.confirm("Are you realy want to delete this transaction?", function(result) {
        if (result) {
          currentForm.submit();
        }
      });
    });

    $.post("<?php echo base_url(); ?>CBtransNui/getHeadDetailMore", {
      txtHeaderEmp: $('#txtInputKaryawanID').val(),
      txtCOAemp: $('#txtInputKaryawanCOA').val()
    }, function(data, statuss) {
      var get = $.parseJSON(data);
      $('#txtInputKaryawanName').val(get.empFullName);
      $('#txtInputKaryawanCOAname').val(get.coaName);
    });

    // ===== ## Find AP Payment ## =====
    $("#btnFindRecord").click(function() {
      $.post("<?php echo site_url(); ?>CBtransNui/selectCashBank", function(data) {
        $('#contentFindCB').html(data);
      });
      $('#modal-findCB').modal('show');
    });
  });
</script>
<script type="text/javascript">
  // ==## Calculate Balance Table ##==
  function CountBelance() {
    var sumDebit = 0;
    var sumCredit = 0;
    $(".col-debit").each(function() {
      var valDeb = this.value;
      var newDeb = parseFloat(valDeb.replace(/,/g, ''));
      if (!isNaN(newDeb) && this.value.length !== 0) {
        sumDebit += parseFloat(newDeb);
      }
    });

    $(".col-credit").each(function() {
      var valCred = this.value;
      var newCred = parseFloat(valCred.replace(/,/g, ''));
      if (!isNaN(newCred) && this.value.length !== 0) {
        sumCredit += parseFloat(newCred);
      }
    });

    var get1 = 0;
    var get2 = 0;
    $('.gst-value').each(function(index, item) {
      if (index == 0) {
        if ($(item).val()) {
          get1 = parseFloat($(item).val().replace(/,/g, ''));
          //$('#sumGST-1').val(get1);
        }
      } else if (index > 0) {
        if ($(item).val()) {
          get2 += parseFloat($(item).val().replace(/,/g, ''));
          //$('#sumGST-2').val(get2);
        }
      }
    });

    var amountDebt = 0;
    var amountCred = 0;
    var ioVal = '<?php echo $_selectHeader->type_trans; ?>';
    if (ioVal == "O" || ioVal == "o") {
      amountDebt = parseFloat(sumDebit + get2);
      amountCred = parseFloat(sumCredit + get1);
    } else {
      amountDebt = parseFloat(sumDebit + get1);
      amountCred = parseFloat(sumCredit + get2);
    }

    $('#inputAmountDebit').val(addCommas(amountDebt.toFixed(2)));
    $('#inputAmountCredit').val(addCommas(amountCred.toFixed(2)));
  }

  function addCommas(nStr) {
    nStr += '';
    x = nStr.split('.');
    x1 = x[0];
    x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
      x1 = x1.replace(rgx, '$1' + ',' + '$2');
    }
    return x1 + x2;
  }
</script>