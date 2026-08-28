<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/global/plugins/bootstrap-toastr/toastr.min.css">
<style>
  .txt40 {
    border: 1px solid #fff;
    width: 30px;
    vertical-align: center
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
  .txtnum,
  .txtnumRate {
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
<!-- Index of AP Payment -->
<div class="page-content">
  <div class="container-fluid">
    <div class="row">

      <form role="form" method="post" id="form-downPaymentAP" class="form-horizontal">
        <div class="col-md-12">

          <div class="portlet light">
            <div class="portlet-title">
              <div class="caption theme-font">
                <i class="icon-calculator theme-font"></i>
                <span class="caption-subject bold uppercase"> AP Down Payment</span>
                <span class="caption-helper"> Payable Recognation</span>
              </div>
              <div class="tools">
                <a href="javascript:;" class="collapse">
                </a>
              </div>
              <div class="actions">
                <a class="btn btn-circle btn-primary" href="<?php echo site_url(); ?>DownPaymentAPNew">
                  <i class="fa fa-paper-plane"></i> New Record</a>
                <a class="btn btn-circle btn-icon-only btn-default fullscreen" href="javascript:;" data-original-title="" title="">
                </a>
              </div>
            </div>
            <div class="portlet-body">
              <div class="row">
                <div class="col-md-6">
                  <div id="div-ReffNum" class="form-group">
                    <label class="control-label col-sm-3">Reff. Number</label>
                    <div class="col-sm-9">
                      <input type="hidden" name="txtHeaderID" value="<?php echo encode_str($_selectHeader->header_id); ?>" readonly>
                      <input type="text" id="txtInputNoReff" name="txtNoReff" value="<?php echo $_selectHeader->no_reff; ?>" readonly class="form-control input-sm" />
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="control-label col-sm-3">Vendor</label>
                    <div class="col-sm-3">
                      <input type="text" style="background-color: #D2E0D1;" value="<?php echo $_selectHeader->from_to; ?>" id="txtInputIdVendor" name="txtIdVendor" class="form-control input-sm" />
                      <input type="hidden" id="txtInputVendorCOA" name="txtVendorCOA" value="<?php echo $_selectHeader->coa_suplier; ?>" />
                    </div>
                    <div class="col-sm-6">
                      <input type="text" style="background-color: #D2E0D1;" value="<?php echo $_selectDetail[1]->remark; ?>" id="txtInputVendor" name="txtVendor" class="form-control input-sm" />
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="control-label col-sm-3">Currency Deposit</label>
                    <div class="col-sm-9">
                      <select class="form-control input-sm" id="selInputCurrency" name="selCurrency" style="background-color: #D2E0D1;">
                        <option value=""></option>
                        <?php foreach ($_selectCurrency as $row) : ?>
                          <?php if ($row->currency_symbol == $_selectHeader->dp_currency) : ?>
                            <option value="<?php echo $row->currency_symbol; ?>" selected><?php echo $row->currency_id; ?></option>
                          <?php else : ?>
                            <option value="<?php echo $row->currency_symbol; ?>"><?php echo $row->currency_id; ?></option>
                          <?php endif; ?>
                        <?php endforeach; ?>
                      </select>
                    </div>
                    <script>
                      $(document).ready(function() {
                        $('#selInputCurrency').on('change', function() {
                          if (!$('#txtInputTglTrans').val()) {
                            $(this).val('');
                            bootbox.alert('Input First Date!', function() {
                              $('#txtInputTglTrans').focus();
                            });
                          } else if (!$('#txtInputTglJatuhTempo').val()) {
                            $(this).val('');
                            bootbox.alert('Input First Date!', function() {
                              $('#txtInputTglJatuhTempo').focus();
                            });
                          } else {
                            var val = $(this).val();
                            var tgl = $('#txtInputTglTrans').val();
                            //alert('asasa = '+tgl);
                            $.ajax({
                              type: "POST",
                              url: "<?php echo base_url(); ?>CBtrans/getRateByCurrency",
                              data: {
                                txtCurrID: val,
                                txtTglTrans: tgl
                              },
                              dataType: "json",
                              success: function(e) {
                                var rUSD = parseFloat(e.rateUSD);
                                var rSGD = parseFloat(e.rateSGD);
                                $('#txtInputRateUSD').val(addCommas(rUSD.toFixed(6)));
                                //$('#txtInputRateNego').val(addCommas(rUSD.toFixed(6)));
                                $('#txtInputRateSGD').val(addCommas(rSGD.toFixed(6)));

                                $('.jr_rate').val(addCommas(rUSD.toFixed(6)));
                              }
                            });
                            $('#txtInputRateUSD').focus();
                          }
                        });

                        $('.hanya-baca').on('keydown keypress keyup', false);
                      });
                    </script>
                  </div>

                  <div class="form-group">
                    <label class="control-label col-sm-3">C/B Code</label>
                    <div class="col-sm-9">
                      <select class="form-control input-sm" name="selCBCode" id="selInputCBCode" onchange="changeCodeCB(this)">
                        <option value="">Choose...</option>
                        <?php foreach ($_selectMasterCOA as $row) : ?>
                          <?php if ($row->NoCOA == $_selectHeader->cashbank_code) : ?>
                            <option value="<?php echo $row->NoCOA; ?>" selected><?php echo $row->NoCOA; ?> ~ <?php echo $row->AccountName; ?></option>
                          <?php else : ?>
                            <option value="<?php echo $row->NoCOA; ?>"><?php echo $row->NoCOA; ?> ~ <?php echo $row->AccountName; ?></option>
                          <?php endif; ?>
                        <?php endforeach; ?>
                      </select>
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="control-label col-sm-3">Currency Bank</label>
                    <div class="col-sm-9">
                      <input type="text" id="txtInputCurrencyBank" name="txtCurrencyBank" value="<?php echo $_selectHeader->currency_id; ?>" class="form-control input-sm" readonly />
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="control-label col-sm-3">Total</label>
                    <div class="col-sm-9">
                      <input type="text" id="txtInputTotal" name="txtTotal" value="<?php echo number_format($_selectHeader->dp_total, 2); ?>" class="form-control input-sm txtnum" title="Double Click for Edit" />
                    </div>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label col-sm-4">Rate USD</label>
                      <div class="col-sm-8">
                        <input type="text" id="txtInputRateUSD" name="txtRateCurr" value="<?php echo number_format($_selectHeader->currency_rate, 6); ?>" onblur="javascript: countSecend();" class="form-control input-sm hanya-baca txtnumRate" required />
                      </div>
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label col-sm-4">Rate SGD</label>
                      <div class="col-sm-8">
                        <input type="text" id="txtInputRateSGD" name="txtRateCurrSGD" value="<?php echo number_format($_selectHeader->dp_rate_sgd, 6); ?>" class="form-control input-sm hanya-baca txtnumRate" required />
                      </div>
                    </div>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label col-sm-4">Rate Nego to [<span class="getHeaderCurr"><?php echo $_selectHeader->currency_id; ?></span>]</label>
                      <div class="col-sm-8">
                        <input type="text" id="txtInputRateNego" name="txtRateNego" value="<?php echo number_format($_selectHeader->dp_rate_nego, 6); ?>" onblur="javascript: countSecend(); calculateDetalTes();" class="form-control input-sm txtnumRate" required />
                      </div>
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label col-sm-4">Rate Bank</label>
                      <div class="col-sm-8">
                        <input type="text" id="txtInputBank" name="txtRateBank" value="<?php echo number_format($_selectHeader->dp_rate_to_bank, 6); ?>" class="form-control input-sm hanya-baca txtnumRate" required />
                      </div>
                    </div>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label col-sm-4">Date of Journal</label>
                      <div class="col-sm-8">
                        <input id="txtInputTglTrans" name="txtTransDate" value="<?php echo date('d-m-Y', strtotime($_selectHeader->dp_date)); ?>" type="text" class="form-control input-sm date-picker" data-date-format="dd-mm-yyyy">
                      </div>
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label col-sm-4">Invoice Date</label>
                      <div class="col-sm-8">
                        <input id="txtInputTglTransInv" name="txtTransDateInv" value="<?php echo date('d-m-Y', strtotime($_selectHeader->dp_date_inv)); ?>" type="text" class="form-control input-sm date-picker" data-date-format="dd-mm-yyyy">
                      </div>
                    </div>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label col-sm-4">Term (days)</label>
                      <div class="col-sm-8">
                        <input id="txtInputJangkaTempo" name="txtTermDay" value="<?php echo $_selectHeader->dp_term; ?>" type="text" class="form-control input-sm" required />
                      </div>
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label col-sm-4">Deu Date</label>
                      <div class="col-sm-8">
                        <input id="txtInputTglJatuhTempo" name="txtDeuDate" value="<?php echo date('d-m-Y', strtotime($_selectHeader->dp_due_date)); ?>" type="text" class="form-control input-sm date-picker" data-date-format="dd-mm-yyyy">
                      </div>
                    </div>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label class="control-label col-sm-2">Remark</label>
                      <div class="col-sm-10">
                        <textarea id="txtInputRemark" name="txtRemark" class="form-control" onkeyup="$('#inputDesc1').val($(this).val());"><?php echo $_selectHeader->trans_description; ?></textarea>
                      </div>
                    </div>
                  </div>
                </div>

              </div>

            </div>
          </div>
        </div>


        <div class="col-md-12">
          <div class="portlet light">
            <div class="portlet-body">
              <div class="row display-none">
                <div class="col-md-12 table-responsive" style="padding-bottom: 15px;">
                  <table class="table-ismo" id="tbl-detail-calculation">
                    <thead>
                      <tr>
                        <th>Rate</th>
                        <th>Total</th>
                        <th>Rate Conv</th>
                        <th>Rate Nego</th>
                        <th>Total to Bank</th>
                        <th>Total to DP</th>
                        <th>Rate USD</th>
                        <th>USD Bank</th>
                        <th>USD DP</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td><input type="text" id="txtTesRate" name="txtInputTesRate" class="txt" /></td>
                        <td><input type="text" id="txtTesTotal" name="txtInputTesTotal" value="<?php echo round($_selectHeader->dp_total, 2); ?>" class="txt" /></td>
                        <td><input type="text" id="txtTesRateConv" name="txtInputTesRateConv" value="<?php echo (isset($_selectHeader->dp_rate_to_bank) ? round($_selectHeader->currency_rate / $_selectHeader->dp_rate_to_bank, 6) : 0); ?>" class="txt" /></td>
                        <td><input type="text" id="txtTesRateNego" name="txtInputTesRateNego" value="<?php echo round($_selectHeader->dp_rate_nego, 6); ?>" class="txt" /></td>
                        <td><input type="text" id="txtTesTotalBank" name="txtInputTesTotalBank" class="txt" value="<?php echo (isset($_selectHeader->dp_total) ? round($_selectHeader->dp_total * $_selectHeader->dp_rate_nego, 2) : 0); ?>" /></td>
                        <td><input type="text" id="txtTesTotalDP" name="txtInputTesTotalDP" class="txt" value="<?php echo (isset($_selectHeader->dp_total) && isset($_selectHeader->dp_rate_to_bank) && isset($_selectHeader->currency_rate) ? round($_selectHeader->dp_total * ($_selectHeader->currency_rate / $_selectHeader->dp_rate_to_bank), 2) : 0); ?>" /></td>
                        <td><input type="text" id="txtTesRateUSD" name="txtInputTesRateUSD" class="txt" value="<?php echo round($_selectHeader->dp_rate_to_bank, 6); ?>" /></td>
                        <td><input type="text" id="txtTesBankUSD" name="txtInputTesBankUSD" class="txt" value="<?php echo round(($_selectHeader->dp_total * $_selectHeader->dp_rate_nego) * $_selectHeader->dp_rate_to_bank, 2); ?>" /></td>
                        <td><input type="text" id="txtTesDpUSD" name="txtInputTesDpUSD" class="txt" value="<?php echo (isset($_selectHeader->dp_total) && isset($_selectHeader->dp_rate_to_bank) && isset($_selectHeader->currency_rate) ? round(($_selectHeader->dp_total * ($_selectHeader->currency_rate / $_selectHeader->dp_rate_to_bank)) * $_selectHeader->dp_rate_to_bank, 2) : 0); ?>" /></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12 table-responsive" style="padding-bottom: 15px;">
                  <table class="table-ismo" id="tbl-detail-journal">
                    <thead>
                      <tr>
                        <th class="text-center" style="width: 30px;">
                          <button id="btnSelectInvoice" class="btn btn-xs btn-link baik display-none" type="button">
                            <i class="fa fa-search"></i></button></td>
                        </th>
                        <th>Account Number</th>
                        <th>D/C</th>
                        <th>Account Name</th>
                        <th>Description</th>
                        <th style="width: 8%">Total</th>
                        <th style="width: 8%">Rate</th>
                        <th style="width: 8%">Debt [USD]</th>
                        <th style="width: 8%">Credit [USD]</th>
                        <th style="width: 8%">Debt [<span class="getHeaderCurr"></span>]</th>
                        <th style="width: 8%">Credit [<span class="getHeaderCurr"></span>]</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td></td>
                        <td><input type="text" id="inputNoCOA1" name="no_coa[]" class="no_coa txt" value="<?php echo $_selectDetail[0]->coa; ?>" autocomplete="off"></td>
                        <td><input type="text" id="dk1" name="dk[]" class="dk txt40" value="C"></td>
                        <td><input type="text" id="inputTypeJurnal1" name="JenisJurnal[]" value="<?php echo $_selectDetail[0]->coa_description; ?>" class="txt"></td>
                        <td><input type="text" id="inputDesc1" name="desc[]" value="<?php echo $_selectDetail[0]->remark; ?>" class=" txt"></td>
                        <td class="total"><input type="text" id="inputTotal1" name="total_jr[]" value="<?php echo number_format($_selectDetail[0]->total_awal, 2); ?>" class="txt txtnum number jur_total" onkeypress="return isNumber(event)"></td>
                        <td><input type="text" name="rate_jr[]" id="inputRate1" value="<?php echo number_format($_selectHeader->currency_rate, 6); ?>" class="txt txtnumRate number jr_rate" onkeypress="return isNumber(event)"></td>
                        <td><input type="text" name="debt_jr[]" id="inputDebt1" value="<?php echo number_format($_selectDetail[0]->debit_usd, 2); ?>" class="txt txtnum number jur_deb" onkeypress="return isNumber(event)"></td>
                        <td><input type="text" name="credit_jr[]" id="inputCredit1" value="<?php echo number_format($_selectDetail[0]->credit_usd, 2); ?>" class="txt txtnum number jur_credit" onkeypress="return isNumber(event)"></td>
                        <td><input type="text" name="debt_dtl[]" id="inputDebtDtl1" value="<?php echo number_format($_selectDetail[0]->debit, 2); ?>" class="txt txtnum number jur_deb_dtl" onkeypress="return isNumber(event)"></td>
                        <td><input type="text" name="credit_dtl[]" id="inputCreditDtl1" value="<?php echo number_format($_selectDetail[0]->credit, 2); ?>" class="txt txtnum number jur_credit_dtl" onkeypress="return isNumber(event)"></td>
                      </tr>
                      <tr>
                        <td></td>
                        <td><input type="text" id="inputNoCOA2" name="no_coa[]" class="no_coa txt" value="<?php echo $_selectDetail[1]->coa; ?>" autocomplete="off"></td>
                        <td><input type="text" id="dk2" name="dk[]" class="dk txt40" value="D"></td>
                        <td><input type="text" id="inputTypeJurnal2" name="JenisJurnal[]" value="<?php echo $_selectDetail[1]->coa_description; ?>" class="txt"></td>
                        <td><input type="text" id="inputDesc2" name="desc[]" value="<?php echo $_selectDetail[1]->remark; ?>" class=" txt"></td>
                        <td class="total"><input type="text" id="inputTotal2" name="total_jr[]" value="<?php echo number_format($_selectDetail[1]->total_awal, 2); ?>" class="txt txtnum number no-ro jur_total" onkeypress="return isNumber(event)"></td>
                        <td><input type="text" name="rate_jr[]" id="inputRate2" value="<?php echo number_format($_selectHeader->currency_rate, 6); ?>" class="txt txtnumRate number jr_rate" onkeypress="return isNumber(event)"></td>
                        <td><input type="text" name="debt_jr[]" id="inputDebt2" value="<?php echo number_format($_selectDetail[1]->debit_usd, 2); ?>" class="txt txtnum number jur_deb" onkeypress="return isNumber(event)"></td>
                        <td><input type="text" name="credit_jr[]" id="inputCredit2" value="<?php echo number_format($_selectDetail[1]->credit_usd, 2); ?>" class="txt txtnum number jur_credit" onkeypress="return isNumber(event)"></td>
                        <td><input type="text" name="debt_dtl[]" id="inputDebtDtl2" value="<?php echo number_format($_selectDetail[1]->debit, 2); ?>" class="txt txtnum number jur_deb_dtl" onkeypress="return isNumber(event)"></td>
                        <td><input type="text" name="credit_dtl[]" id="inputCreditDtl2" value="<?php echo number_format($_selectDetail[1]->credit, 2); ?>" class="txt txtnum number jur_credit_dtl" onkeypress="return isNumber(event)"></td>
                      </tr>
                      <tr>
                        <td></td>
                        <td><input type="text" id="inputNoCOA3" name="no_coa[]" class="no_coa txt" value="610001" autocomplete="off"></td>
                        <td><input type="text" id="dk3" name="dk[]" class="dk txt40" value="D"></td>
                        <td><input type="text" id="inputTypeJurnal3" name="JenisJurnal[]" value="Bank Charges" class="txt"></td>
                        <td><input type="text" id="inputDesc3" name="desc[]" class=" txt"></td>
                        <td class="total"><input type="text" id="inputTotal3" name="total_jr[]" value="<?php echo number_format($_selectDetail[2]->total_awal, 2); ?>" class="txt txtnum number jur_total" onkeypress="return isNumber(event)"></td>
                        <td><input type="text" name="rate_jr[]" id="inputRate3" value="<?php echo number_format($_selectHeader->currency_rate, 6); ?>" class="txt txtnumRate number jr_rate" onkeypress="return isNumber(event)"></td>
                        <td><input type="text" name="debt_jr[]" id="inputDebt3" value="<?php echo number_format($_selectDetail[2]->debit_usd, 2); ?>" class="txt txtnum number jur_deb" onkeypress="return isNumber(event)"></td>
                        <td><input type="text" name="credit_jr[]" id="inputCredit3" value="<?php echo number_format($_selectDetail[2]->credit_usd, 2); ?>" class="txt txtnum number jur_credit" onkeypress="return isNumber(event)"></td>
                        <td><input type="text" name="debt_dtl[]" id="inputDebtDtl3" value="<?php echo number_format($_selectDetail[2]->debit, 2); ?>" class="txt txtnum number jur_deb_dtl" onkeypress="return isNumber(event)"></td>
                        <td><input type="text" name="credit_dtl[]" id="inputCreditDtl3" value="<?php echo number_format($_selectDetail[2]->credit, 2); ?>" class="txt txtnum number jur_credit_dtl" onkeypress="return isNumber(event)"></td>
                      </tr>
                      <tr>
                        <td></td>
                        <td><input type="text" id="inputNoCOA4" name="no_coa[]" class="no_coa txt" value="610009" autocomplete="off"></td>
                        <td><input type="text" id="dk4" name="dk[]" class="dk txt40" value="<?php echo (isset($_selectDetail[3]->debit) && $_selectDetail[3]->debit > 0 ? 'D' : 'C'); ?>"></td>
                        <td><input type="text" id="inputTypeJurnal4" name="JenisJurnal[]" value="Exchange Rate" class="txt"></td>
                        <td><input type="text" id="inputDesc4" name="desc[]" class=" txt"></td>
                        <td class="total"><input type="text" id="inputTotal4" name="total_jr[]" value="<?php echo (isset($_selectDetail[3]->total_awal) ? number_format($_selectDetail[3]->total_awal, 2) : '0.00'); ?>" class="txt txtnum number jur_total" onkeypress="return isNumber(event)"></td>
                        <td><input type="text" name="rate_jr[]" id="inputRate4" value="<?php echo number_format($_selectHeader->currency_rate, 6); ?>" class="txt txtnumRate number jr_rate" onkeypress="return isNumber(event)"></td>
                        <td><input type="text" name="debt_jr[]" id="inputDebt4" value="<?php echo (isset($_selectDetail[3]->debit_usd) ? number_format($_selectDetail[3]->debit_usd, 2) : '0.00'); ?>" class="txt txtnum number jur_deb" onkeypress="return isNumber(event)"></td>
                        <td><input type="text" name="credit_jr[]" id="inputCredit4" value="<?php echo (isset($_selectDetail[3]->credit_usd) ? number_format($_selectDetail[3]->credit_usd, 2) : '0.00'); ?>" class="txt txtnum number jur_credit" onkeypress="return isNumber(event)"></td>
                        <td><input type="text" name="debt_dtl[]" id="inputDebtDtl4" value="<?php echo (isset($_selectDetail[3]->debit) ? number_format($_selectDetail[3]->debit, 2) : '0.00'); ?>" class="txt txtnum number jur_deb_dtl" onkeypress="return isNumber(event)"></td>
                        <td><input type="text" name="credit_dtl[]" id="inputCreditDtl4" value="<?php echo (isset($_selectDetail[3]->credit) ? number_format($_selectDetail[3]->credit, 2) : '0.00'); ?>" class="txt txtnum number jur_credit_dtl" onkeypress="return isNumber(event)"></td>
                      </tr>
                    </tbody>
                  </table>
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
                  <button class="btn btn-sm btn-danger" type="button" id="btnSubmitDelete">
                    <i class="fa fa-trash-o"></i> Delete
                  </button>
                  <button class="btn btn-sm green" type="button" id="btnSubmitUpdate">
                    <i class="fa fa-edit"></i> Update
                  </button>
                  <button class="btn btn-sm btn-neutral" type="reset" onclick="javascript: window.location = '<?php echo site_url("DownPaymentAP"); ?>';">
                    <i class="fa fa-refresh"></i> Cancel
                  </button>
                </div>
              </div>
            </div>

          </div>
        </div>
      </form>

    </div>
  </div>
</div>

<!-- Add With COA -->
<div class="modal fade" id="modal-MCOA" tabindex="-1" role="basic" aria-hidden="true">
  <div class="modal-dialog" style="width: 75%;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title">Select Master COA</h4>
      </div>
      <div class="modal-body">
        <div id="contentMasterCOA"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- Select Supplier in Detail -->
<div class="modal fade" id="modal-selectSUPP" tabindex="-1" role="basic" aria-hidden="true">
  <div class="modal-dialog" style="width: 75%;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title">Select Supplier</h4>
      </div>
      <div class="modal-body">
        <div id="content-modalSUPP"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- Find Recorded AP Deposit Transaction Modal -->
<div class="modal fade" id="modal-findDeposit" tabindex="-1" role="basic" aria-hidden="true">
  <div class="modal-dialog" style="width: 75%;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title">Select AP Deposit</h4>
      </div>
      <div class="modal-body">
        <div id="contentFindDeposit"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  $(document).ready(function() {
    $('#txtInputTotal').attr('readonly', true).addClass('pop-reon');
    $('#txtInputTotal').blur(function() {
      $(this).attr('readonly', true).addClass('pop-reon');
    }).dblclick(function() {
      $(this).attr('readonly', false).removeClass('pop-reon');
    }).on('mousedown', function(e) {
      if ($(this).hasClass('pop-reon')) {
        return false;
        e.stopPropagation();
      }
    });
    /*$('#txtInputTotal').focus();
    setTimeout(function (){
        $('#txtInputRemark').focus();
    }, 2000);*/
    //###+==================================================================
    $('.txtnum').numericInput({
      allowFloat: true,
      allowNegative: true
    });
    $('.txtnum').blur(function() {
      var val = parseFloat($(this).val().replace(/,/g, ''));
      if (!val) {
        var vall = 0;
      } else {
        vall = val;
      }
      $(this).val(addCommas(vall.toFixed(2)));
    });
    $('.txtnumRate').blur(function() {
      var val = parseFloat($(this).val().replace(/,/g, ''));
      if (!val) {
        var vall = 0;
      } else {
        vall = val;
      }
      $(this).val(addCommas(vall.toFixed(6)));
    });
    $('#tbl-detail-journal').find('input').attr('readonly', true);
    $('#tbl-detail-journal').find('.no-ro').attr('readonly', false);

    $('.jur_total').on('keyup blur', function() {
      countBankCharge();
    });

    //============= Auto Num Reff===============
    /*$('#txtInputTglTrans, #txtInputBank, #txtInputRateUSD').on('change blur', function(){
        if($('#txtInputTglTrans').val() && $('#txtInputCurrencyBank').val()){
            setInterval( function(){
                $.post("<?php //echo base_url();
                        ?>CBtrans/newGenerateReffNumber", {
                    txtTypeForGen : 'OUT',
                    txtCurrForGen : $('#txtInputCurrencyBank').val(),
                    txtDateForGen : $('#txtInputTglTrans').val()
                }, function(data, statuss){
                    $('#txtInputNoReff').val(data);
                });
            }, 2000);
        }
    });*/

    $('#txtInputTglTrans').on('change keyup', function() {
      // varibel miliday sebagai pembagi untuk menghasilkan hari
      var miliday = 60 * 24 * 60 * 1000;
      //buat object Date
      var date = $('#txtInputTglJatuhTempo').val(),
        dateD = date.substr(0, 2),
        dateM = date.substr(3, 2),
        dateY = date.substr(6, 4),
        dateR = dateY + '/' + dateM + '/' + dateD;
      var date1 = $('#txtInputTglTrans').val(),
        dateD1 = date1.substr(0, 2),
        dateM1 = date1.substr(3, 2),
        dateY1 = date1.substr(6, 4),
        dateR1 = dateY1 + '/' + dateM1 + '/' + dateD1;
      var tglTerm = new Date(dateR);
      var tglTrans = new Date(dateR1);
      // Date.parse akan menghasilkan nilai bernilai integer dalam bentuk milisecond
      var date1 = Date.parse(tglTrans);
      var date2 = Date.parse(tglTerm);
      var term = (date2 - date1) / miliday;
      $('#txtInputJangkaTempo').val(term);

      $('#txtInputTglTransInv').val($('#txtInputTglTrans').val());
    });

    $('#txtInputJangkaTempo').on('keyup', function() {
      var date = $('#txtInputTglTrans').val(),
        dateD = date.substr(0, 2),
        dateM = date.substr(3, 2),
        dateY = date.substr(6, 4),
        dateR = dateY + '/' + dateM + '/' + dateD;
      var term = $(this).val();
      //alert(dateR);
      var date = new Date(dateR);
      var newdate = new Date(date);
      newdate.setDate(newdate.getDate() + Number(term));
      var dd = newdate.getDate();
      var mm = newdate.getMonth() + 1;
      var y = newdate.getFullYear();
      var someFormattedDate = y + '-' + mm + '-' + dd;
      $('#txtInputTglJatuhTempo').val(formatDate(someFormattedDate));
    });

    $('#txtInputTglJatuhTempo').on('change keyup', function() {
      // varibel miliday sebagai pembagi untuk menghasilkan hari
      var miliday = 60 * 24 * 60 * 1000;
      //buat object Date
      var date = $('#txtInputTglJatuhTempo').val(),
        dateD = date.substr(0, 2),
        dateM = date.substr(3, 2),
        dateY = date.substr(6, 4),
        dateR = dateY + '/' + dateM + '/' + dateD;
      var date1 = $('#txtInputTglTrans').val(),
        dateD1 = date1.substr(0, 2),
        dateM1 = date1.substr(3, 2),
        dateY1 = date1.substr(6, 4),
        dateR1 = dateY1 + '/' + dateM1 + '/' + dateD1;
      var tglTerm = new Date(dateR);
      var tglTrans = new Date(dateR1);
      // Date.parse akan menghasilkan nilai bernilai integer dalam bentuk milisecond
      var date1 = Date.parse(tglTrans);
      var date2 = Date.parse(tglTerm);
      var term = (date2 - date1) / miliday;
      $('#txtInputJangkaTempo').val(term);
    });

    // add With COA
    $("#btnSelectMCOA").click(function() {
      $.ajax({
        url: "<?php echo site_url('CBtrans/selectCOA'); ?>",
        type: "POST",
        datatype: "json",
        cache: false,
        success: function(respon) {
          $('#contentMasterCOA').html(respon);
        }
      });
      $('#modal-MCOA').modal('show');
    });

    //Select Vendor
    $("#txtInputVendor, #txtInputIdVendor").click(function() {
      $.ajax({
        url: "<?php echo site_url('DownPaymentAPNew/selectSupplierForDP'); ?>",
        type: "POST",
        datatype: "json",
        cache: false,
        success: function(respon) {
          $('#content-modalSUPP').html(respon);
        }
      });
      $('#modal-selectSUPP').modal('show');
    });

    //total
    $("#txtInputTotal").on('keyup blur', function() {
      calculateTotal();
      countBankCharge();
      calculateDetalTes();
    });

    $('#txtInputRateUSD').on('blur', function() {
      calculateTotal();
      countBankCharge();
    });

    //================ FInd
    $('#btnFindRecord').click(function() {
      $.post("<?php echo site_url(); ?>DownPaymentAPNew/selectDepositAP", function(data) {
        $('#contentFindDeposit').html(data);
      });

      $('#modal-findDeposit').modal('show');
    });

    // ########============== SUBMIT =================#########
    $("#btnSubmitUpdate").click(function() {
      $("#form-downPaymentAP").attr('action', "<?php echo base_url(); ?>DownPaymentAPNew/updateDepositAP");

      bootbox.confirm("Are you really want to update this transaction?", function(result) {
        if (result) {
          $("#form-downPaymentAP").submit();
        }
        $("#form-downPaymentAP").attr('action', "");
      });
    });
    $("#btnSubmitDelete").click(function() {
      $("#form-downPaymentAP").attr('action', "<?php echo base_url(); ?>DownPaymentAPNew/deleteDepositAP");

      bootbox.confirm("Are you really want to delete this transaction?", function(result) {
        if (result) {
          $("#form-downPaymentAP").submit();
        }
        $("#form-downPaymentAP").attr('action', "");
      });
    });
  });
</script>

<script type="text/javascript">
  function changeCodeCB(val) {
    if (!$('#txtInputTglTrans').val()) {
      $(val).val('');
      bootbox.alert('Input First Date!', function() {
        $('#txtInputTglTrans').focus();
      });
    } else if (!$('#txtInputTglJatuhTempo').val()) {
      $(val).val('');
      bootbox.alert('Input First Date!', function() {
        $('#txtInputTglJatuhTempo').focus();
      });
    } else {
      var id = val.value;
      //var noReff  = document.getElementById('inputNoReff').value;
      var nameCOA = $('#selInputCBCode option:selected').text();
      var pemisah = nameCOA.search("~");
      var txtIO = $('#inputIOCest').val();

      var txtCOA = nameCOA.substr(pemisah + 2);
      var noCOA = nameCOA.substr(0, pemisah - 1);

      $('#inputNoCOA1').val(noCOA);
      $('#inputTypeJurnal1').val(txtCOA);
      //$('#inputDesc1').val(txtCOA);

      $.post("<?php echo site_url(); ?>DownPaymentAPNew/getCurrencyBank", {
        txtCOA: id,
        txtTgl: $('#txtInputTglTrans').val()
      }, function(data) {
        var get = $.parseJSON(data);
        $('#txtInputBank').val(get.rate_usd);
        $('#txtInputCurrencyBank').val(get.currency);
        $('#txtInputBank').focus();

        $('.getHeaderCurr').html(get.currency);
      });
    }
  }

  function Pilih_Supllier(x) {
    function getText(el) {
      if (typeof el.textContent === 'string')
        return el.textContent;
      if (typeof el.innerText === 'string')
        return el.innerText;
    }

    $r = x.rowIndex;
    var suppid = getText(document.getElementById('tbl-selectSupplier').rows[$r].cells[0]);
    var suppnm = getText(document.getElementById('tbl-selectSupplier').rows[$r].cells[1]);
    var suppcoa = getText(document.getElementById('tbl-selectSupplier').rows[$r].cells[3]);
    var nmcoa = getText(document.getElementById('tbl-selectSupplier').rows[$r].cells[4]);

    $('#txtInputIdVendor').val(suppid);
    $('#txtInputVendor').val(suppnm);

    $('#inputNoCOA2').val(suppcoa);
    $('#txtInputVendorCOA').val(suppcoa);
    $('#inputTypeJurnal2').val(nmcoa);
    $('#inputDesc2').val(nmcoa);
    //== Row Detail 2
    //$('#txtInputCOAsuppRow-2').val(suppcoa);
    //$('#txtInputNameSuppRow-2').val(suppnm);
    $('#inputDesc2').val(suppnm);

    $('#modal-selectSUPP').modal('hide');
  }

  function Pilih_MCOA(x) {
    function getText(el) {
      if (typeof el.textContent === 'string') return el.textContent;
      if (typeof el.innerText === 'string') return el.innerText;
    }

    var $r = x.rowIndex;
    var cls = getText(document.getElementById('tbl-MasterCOA').rows[$r].cells[4]);
    var noCOA = getText(document.getElementById('tbl-MasterCOA').rows[$r].cells[0]);
    var nmCOA = getText(document.getElementById('tbl-MasterCOA').rows[$r].cells[1]);

    $('table[id="tbl-detail-invoice"]').append('<tr>\n\
            <td class="text-center" style="vertical-align: middle;">\n\
                <button class="btn btn-xs btn-link buruk" type="button" onclick="delete_MCOA(this)"><i class="fa fa-trash-o"></i></button>\n\
            </td>\n\
            <td><input type="hidden" name="Detail_item_id[]" value="0">\n\
                <input type="hidden" name="Detail_jurnal_id[]" value="0"><input type="text" name="Detail_po[]" class="txt" value=""></td>\n\
            <td><input type="text" name="txtCOA[]" class="txt txtCOA" onkeypress="return isNumber(event)" value="' + noCOA + '" required=""></td>\n\
            <td><textarea name="txtItem[]" rows="1" cols="30" class="txt txtNmCOA">' + nmCOA + '</textarea></td>\n\
            <td><input type="text" class="txt number quantity" name="txtQty[]" placeholder="0" onclick="make_blank()" onkeypress="return isNumber(event);" onkeyup="countALL()" onblur="countSecend()" required=""></td>\n\
            <td><input type="text" name="txtUnit[]" class="txt"></td>\n\
            <td><input type="text" name="txtPrice[]" class="txt number prices txtnum ' + cls + 'qq" onkeypress="return isNumber(event); " onkeyup="countALL()" placeholder="0" onblur="countSecend()" required=""></td>\n\
            <td><input type="text" name="txtAmount[]" class="txt number amount txtnum ' + cls + 'qq" data-a-sep="," data-a-dec="." value="0" onkeypress="return isNumber(event)" readonly></td>\n\
            <td><input type="text" name="txtSGD[]" class="txt number txtSGD txtnum ' + cls + 'qq" onkeypress="return isNumber(event)" value="0" readonly></td>\n\
            <td class="cls-gst"><input type="text" name="txtGST[]" class="txt"/></td>\n\
            <td><input type="text" name="txtGSTvalue[]" class="txt txtnum gst-value txtGSTValue"/></td>\n\
        </tr>');

    $(function() {
      $('.txtnum').numericInput({
        allowFloat: true,
        allowNegative: true
      });
      $('.' + cls + 'qq').blur(function() {
        var val = parseFloat($(this).val().replace(/,/g, ''));
        if (!val) {
          var vall = 0;
        } else {
          vall = val;
        }
        $(this).val(addCommas(vall.toFixed(2)));
      });


      $.ajax({
        url: "<?php echo base_url(); ?>CBtrans/addGST",
        dataType: 'html',
        success: function(data) {
          $('.cls-gst').html(data);
        }
      });
    });

    $('#modal-MCOA').modal('hide');
  }

  function delete_MCOA(x) {
    var row = x.parentNode.parentNode;
    bootbox.confirm("Are you sure?", function(result) {
      if (result == true) {
        row.parentNode.removeChild(row);
      }
    });
  }

  function countBankCharge() {
    var val1 = parseFloat($('#inputTotal1').val().replace(/,/g, ''));
    var val2 = parseFloat($('#inputTotal2').val().replace(/,/g, ''));
    var curr = parseFloat($('#txtInputRateUSD').val());

    var bCharg = val1 - val2;
    $('#inputTotal3').val(addCommas(bCharg.toFixed(2)));

    var deb2 = val2 * curr;
    var deb3 = parseFloat(bCharg.toFixed(2)) * curr;
    $('#inputDebt2').val(addCommas(deb2.toFixed(2)));
    $('#inputDebt3').val(addCommas(deb3.toFixed(2)));

    var rateBank = $('#txtInputBank').val();

    var debBank2 = Number(deb2) / Number(rateBank);
    var debBank3 = Number(deb3) / Number(rateBank);

    $('#inputDebtDtl2').val(addCommas(debBank2.toFixed(2)));
    $('#inputDebtDtl3').val(addCommas(debBank3.toFixed(2)));
  }

  function countALL() {
    var qty = $('.quantity').map(function() {
      return this.value.replace(/,/g, '');
    }).get().join('|');
    var xqty = qty.split('|');

    var prices = $('.prices').map(function() {
      return this.value.replace(/,/g, '');
    }).get().join('|');
    var xprices = prices.split('|');

    for (var i = 0; i < $('.quantity').length; i++) {
      $('.amount').each(function(index, item) {
        if (index == i) {
          var amount = parseFloat(xqty[i]) * parseFloat(xprices[i]);
          $(item).val(addCommas(amount.toFixed(2)));
        }
      });
    }
  }

  function countSecend() {
    var amnt = $('.amount').map(function() {
      return this.value.replace(/,/g, '');
    }).get().join('|');
    var xamnt = amnt.split('|');

    var curr = $('#txtInputRateUSD').val();

    for (var i = 0; i < $('.quantity').length; i++) {
      $('.txtSGD').each(function(index, item) {
        if (index == i) {
          var call = parseFloat(xamnt[i]) * parseFloat(curr);
          $(item).val(addCommas(call.toFixed(2)));
        }
      });
    }
  }

  function checkGST() {
    var gst_type = document.getElementsByClassName('gst-name');
    var txtSGD = document.getElementsByClassName('amount');
    var gst_value = document.getElementsByClassName('gst-value');
    var rateSGD = parseFloat($('#txtInputRateSGD').val().replace(/,/g, ''));

    for (var i = 0; i < gst_type.length; i++) {
      if (gst_type[i].value === 'GST') {
        var sgd = txtSGD[i].value.replace(/,/g, '');
        var total = (Number(sgd) * rateSGD * 0.07);
        gst_value[i].value = addCommas(total.toFixed(2));
      } else {
        gst_value[i].value = 0.00;
      }
    }
  }

  function calculateDetalTes() {
    var total = $('#txtInputTotal').val().replace(/,/g, ''),
      rateConv = Number($('#txtInputRateUSD').val()) / Number($('#txtInputBank').val()),
      rateNego = Number($('#txtInputRateNego').val()),
      totalBank = Number(total) * rateNego,
      totalDP = Number(total) * rateConv,
      rateUSD = $('#txtInputBank').val(),
      totBankUSD = totalBank * Number(rateUSD),
      totDpUSD = totalDP * Number(rateUSD);
    var excRate = Number(totalBank) - Number(totalDP),
      excMinBiasa = Number(totalDP) - Number(totalBank),
      excRateUSD = Number(totBankUSD) - Number(totDpUSD),
      excMinUSD = Number(totDpUSD) - Number(totBankUSD);

    $('#txtTesTotal').val(Number(total).toFixed(2));
    $('#txtTesRateConv').val(Number(rateConv).toFixed(6));
    $('#txtTesRateNego').val(Number(rateNego).toFixed(6));
    $('#txtTesTotalBank').val(Number(totalBank).toFixed(2));
    $('#txtTesTotalDP').val(Number(totalDP).toFixed(2));
    $('#txtTesRateUSD').val(Number(rateUSD).toFixed(6));
    $('#txtTesBankUSD').val(Number(totBankUSD).toFixed(2));
    $('#txtTesDpUSD').val(Number(totDpUSD).toFixed(2));

    //##== In Detail for Journal
    $('#inputCredit1').val(addCommas(Number(totBankUSD).toFixed(2)));
    $('#inputDebt2').val(Number(totDpUSD).toFixed(2));
    if (excRate > 0) {
      $('#dk4').val('D');
      $('#inputDebt4').val(Number(excRateUSD).toFixed(2));
      $('#inputDebtDtl4').val(Number(excRate).toFixed(2));
      $('#inputCredit4').val(Number(0).toFixed(2));
      $('#inputCreditDtl4').val(Number(0).toFixed(2));
    } else {
      $('#dk4').val('C');
      $('#inputDebt4').val(Number(0).toFixed(2));
      $('#inputDebtDtl4').val(Number(0).toFixed(2));
      $('#inputCredit4').val(Number(excMinUSD).toFixed(2));
      $('#inputCreditDtl4').val(Number(excMinBiasa).toFixed(2));
    }
    //$('#inputCredit1'). val(Number(totalBank).toFixed(2));
    $('#inputCreditDtl1').val(addCommas(Number(totalBank).toFixed(2)));
    $('#inputDebtDtl2').val(Number(totalDP).toFixed(2));
    //$('#inputCredit1'). val(Number(totalBank).toFixed(2));

    $('#inputTotal2').val(addCommas(Number(total).toFixed(2)));

    //========
    $('.jr_rate').val((parseFloat($('#txtInputRateUSD').val()).toFixed(6)));

    countBankCharge();
  }

  function calculateTotal() {
    var value = $('#txtInputTotal').val();
    var curr = parseFloat($('#txtInputRateUSD').val());

    var total = parseFloat(value.replace(/,/g, ''));
    var hasil = total * curr;

    $('#inputCredit1').val(addCommas(hasil.toFixed(2)));
    //$('#inputDebt2').val(addCommas(hasil.toFixed(2)));

    $('#inputTotal1').val(value);
    //$('#inputTotal2').val(value);
  }

  function formatDate(date) {
    var d = new Date(date),
      month = '' + (d.getMonth() + 1),
      day = '' + d.getDate(),
      year = d.getFullYear();
    if (month.length < 2)
      month = '0' + month;
    if (day.length < 2)
      day = '0' + day;
    return [day, month, year].join('-');
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