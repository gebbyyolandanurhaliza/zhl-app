<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/global/plugins/bootstrap-toastr/toastr.min.css">
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
<!-- Index of AR Payment -->
<div class="page-content">
  <div class="container-fluid">
    <div class="row">

      <form role="form" method="post" id="form-ARtrans" action="<?php echo site_url('ARtrans') . $_actionFrom; ?>" class="form-horizontal">
        <div class="col-md-12">
          <div class="note note-success note-bordered">
            <p>
              Active Period : <?php echo $this->session->userdata('periode_1'); ?> | <a href="<?php echo base_url(); ?>Period">Change</a>
            </p>
          </div>
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
                <a class="btn btn-circle btn-primary" href="<?php echo site_url('ARList'); ?>">
                  <i class="fa fa-list"></i> Look List</a>
                <a class="btn btn-circle btn-icon-only btn-default fullscreen" href="javascript:;" data-original-title="" title="">
                </a>
              </div>
            </div>
            <div class="portlet-body">
              <!-- FORM MASTER COA -->
              <div class="row" id="ajax-formAP-header">
                <div class="col-md-12">
                  <div class="col-sm-4">
                    <div id="div-ReffNum" class="form-group">
                      <label class="control-label col-sm-4">Reff. Number</label>
                      <div class="col-sm-8">
                        <input type="text" id="inputNoReff" placeholder="Auto Generate" name="txtFacture" class="form-control input-sm" required="required" readonly />
                        <span id="alert-errorReff" class="help-block" style="display: none;">Please use another num reff.! </span>
                      </div>
                    </div>
                    <script>
                      $('#inputNoReff').on('blur', function() {
                        var val = $('#inputNoReff').val();
                        $.ajax({
                          type: "POST",
                          url: "<?php echo base_url(); ?>ARtrans/cekNumReffAR",
                          data: {
                            value: val
                          },
                          dataType: "json",
                          success: function(n) {
                            if (n === 1) {
                              $('#div-ReffNum').addClass('has-error');
                              document.getElementById('alert-errorReff').style.display = 'block';
                              var valAsli = $('#inputNoReff').val();
                              var valtoInt = parseInt(valAsli);
                              $('#inputNoReff').val(valtoInt + 1);
                              $('#inputNoReff').focus();
                              /*$('#form-ARtrans').submit(function (){
                                  return false;
                              });*/
                            } else {
                              $('#div-ReffNum').removeClass('has-error');
                              $('#div-ReffNum').addClass('has-success');
                              document.getElementById('alert-errorReff').style.display = 'none';
                            }
                          }
                        });
                      });
                    </script>
                    <div class="form-group ismo-hidden">
                      <label class="control-label col-sm-4">Voucher number</label>
                      <div class="col-sm-8">
                        <input type="text" style="background-color: #D2E0D1;" id="txtJurNum" name="txtVoucher" class="form-control input-sm" />
                      </div>
                    </div>
                  </div>

                  <div class="col-sm-4">
                    <div class="form-group">
                      <label class="control-label col-sm-4">Trans Date</label>
                      <div class="col-sm-8">
                        <input id="txtInputTransDate" name="txtTransDate" type="text" class="form-control input-sm date-picker" value="<?php //echo date('d-m-Y');
                                                                                                                                        ?>" data-yesterday="<?php echo date('d-m-Y',  mktime(0, 0, 0, date('m'), date('d') - 1, date('Y'))); ?>" data-now="<?php echo date('d-m-Y'); ?>" data-date-format="dd-mm-yyyy" style="background-color: #D2E0D1;" readonly />
                      </div>
                    </div>
                    <div class="form-group ismo-hidden">
                      <label class="control-label col-sm-4">Voucher Date</label>
                      <div class="col-sm-8">
                        <input id="txtInputVoucherDate" name="txtVoucherDate" type="text" class="form-control input-sm" readonly data-date-format="yyyy-mm-dd" />
                      </div>
                    </div>
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="col-sm-4">
                    <div class="form-group">
                      <label class="control-label col-sm-4">Customer</label>
                      <div class="col-sm-2">
                        <input type="text" id="txtInputSuplierID" name="txtSuplierID" class="form-control input-sm" style="background-color: #D2E0D1;" readonly />
                      </div>
                      <div class="col-sm-6">
                        <input type="text" id="txtInputSuplierName" name="txtSuplierName" class="form-control input-sm" style="background-color: #D2E0D1;" readonly />
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-8">
                    <div class="form-group">
                      <label class="control-label col-sm-2">Voucher Remark</label>
                      <div class="col-sm-10">
                        <input type="text" id="txtInputSuplierRemark" name="txtSuplierRemark" class="form-control input-sm" />
                      </div>
                    </div>
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="col-sm-4">
                    <div class="form-group">
                      <label class="control-label col-sm-4">Voucher Currency</label>
                      <div class="col-sm-8">
                        <select class="form-control input-sm read-only-curr txt-ismo-back-null" id="selInputCurrencyVoucher" name="selCurrencyVoucher" style="background-color: #D2E0D1;">
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
                      <label class="control-label col-sm-4">Voucher Rate</label>
                      <div class="col-sm-8">
                        <input id="txtInputRateVoucher" name="txtRateVoucher" type="text" class="form-control input-sm txt-ismo-back-null txtnumRate" data-date-format="yyyy-mm-dd" readonly />
                      </div>
                    </div>
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="col-sm-4">
                    <div class="form-group">
                      <label class="control-label col-sm-4">Amount</label>
                      <div class="col-sm-8">
                        <input type="text" name="txtTotalVoucher" id="inputTotalVoucher" class="form-control input-sm txt-ismo-back-null txtnum" readonly="" />
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-4">
                    <div class="form-group">
                      <label class="control-label col-sm-4">to USD</label>
                      <div class="col-sm-8">
                        <input type="text" id="txtInputRateSGD" name="txtRateSGD" class="form-control input-sm txt-ismo-back-null txtnum" readonly="" />
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
                        <input id="inputCOA" style="background-color: #D2E0D1;" type="text" name="txtCashBankCode" class="form-control input-sm" required />
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
                      <label class="control-label col-sm-4">Monthly Rate</label>
                      <div class="col-sm-8">
                        <input type="text" id="txtInputRateWeekly" name="txtRateBayar" class="form-control input-sm txtnumRate" required onkeydown="return false;" onkeyup="return false;" onkeypress="return false;" />
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-4">
                    <div class="form-group">
                      <label class="control-label col-sm-4">Amount Payment</label>
                      <div class="col-sm-8">
                        <input type="text" id="txtAmountPayment" name="txtAmountPayment" class="form-control input-sm txtnum" required readonly />
                      </div>
                    </div>
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="col-sm-4">
                    <div class="form-group">
                      <label class="control-label col-sm-4">Rate Negotiation</label>
                      <div class="col-sm-8">
                        <input type="text" id="txtInputRateNego" name="txtRateNego" class="form-control input-sm txtnumRate" onkeyup="javascript: HitungPayment();" onBlur="javascript :$('#tbl-payment tbody').addClass('display-none'); $(this).val(parseFloat($(this).val()).toFixed(6));" required />
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-4">
                    <div class="form-group">
                      <label class="control-label col-sm-4">Rate Equivalent</label>
                      <div class="col-sm-8">
                        <input type="text" id="txtInputRateEqui" name="txtRateEqui" class="form-control input-sm txtnumRate" required />
                      </div>
                    </div>
                  </div>

                  <div class="col-sm-4">
                    <div class="form-group">
                      <label class="control-label col-sm-4">Rate SGD</label>
                      <div class="col-sm-8">
                        <input type="text" id="txtInputRateWeeklySGD" name="txtRateWeeklySGD" class="form-control input-sm txtnumRate" required onkeydown="return false;" onkeyup="return false;" onkeypress="return false;" />
                      </div>
                    </div>
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="col-sm-8">
                    <div class="form-group">
                      <label class="control-label col-sm-2">Check Number</label>
                      <div class="col-sm-10">
                        <input type="text" id="txtInputCheckBank" name="txtCheckBank" class="form-control input-sm" required />
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
                <span class="caption-subject bold uppercase"> Detail</span>
                <span class="caption-helper">Select Invoice in Here</span>
              </div>
              <div class="actions">
                <a class="btn btn-circle btn-icon-only btn-default fullscreen" href="javascript:;" data-original-title="" title="">
                </a>
              </div>
            </div>
            <div class="portlet-body form">
              <div class="row">
                <div class="col-md-12 table-responsive" style="padding-bottom: 15px;">
                  <table class="table-ismo" id="tbl-detail-invoice">
                    <thead>
                      <tr>
                        <th class="text-center" style="width: 42px;">
                          <button id="btnSelectInvoice" class="btn btn-xs btn-link baik" type="button">
                            <i class="fa fa-search"></i></button></td>
                        </th>
                        <th>No. Invoice</th>
                        <th style="width: 7%;">Rate to <span class="txtHeadCurrency"></span></th>
                        <th style="width: 10%;">[<span class="txtHeadCurrency"></span>] Equivalent</th>
                        <th style="width: 7%;">Rate</th>
                        <th style="width: 10%;">Total Before</th>
                        <th style="width: 10%;">Remaining Debt</th>
                        <th style="width: 10%;">Payment</th>
                      </tr>
                    </thead>
                    <tbody>
                    </tbody>
                    <tfoot>
                      <tr>
                        <td colspan="2" class="txtnum bold" style="padding-right: 10px;">Grand Total</td>
                        <td class="txtnum">
                          <input name="txtAvgRateVaucher" id="rateToCurr" class="txt txtnum txt-ismo-back-null" readonly="true" />
                        </td>
                        <td class="txtnum">
                          <input name="" id="equiToCurr" class="txt txtnum txt-ismo-back-null" readonly="true" />
                        </td>
                        <td class="txtnum">
                          <input name="" id="rateTotalID" class="txt txtnum txt-ismo-back-null" readonly="true" />
                        </td>
                        <td class="txtnum">
                          <input name="" id="befTotalID" class="txt txtnum txt-ismo-back-null" readonly="true" />
                        </td>
                        <td class="txtnum">
                          <input name="" id="debTotalID" class="txt txtnum txt-ismo-back-null" readonly="true" />
                        </td>
                        <td class="txtnum">
                          <input name="txtTotalPaymentInvoice" id="payTotalID" class="txt txtnum txt-ismo-back-null" readonly="true" />
                        </td>
                      </tr>
                    </tfoot>
                  </table>
                </div>
              </div>
            </div>

            <hr style="border:0;height:1px;background-image:linear-gradient(to right,rgba(0,0,0,0),rgba(0,0,0,1),rgba(0,0,0,0));" />

            <div class="portlet-title">
              <div class="caption theme-font">
                <i class="icon-calendar theme-font"></i>
                <span class="caption-subject bold uppercase"> Detail</span>
                <span class="caption-helper">Additional Cost</span>
              </div>
              <div class="actions">
                <a class="btn btn-circle green" id="btnAddCost" href="javascript:;">
                  Additional Cost
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
                  <tr id="rowSetCOA">
                    <td class="text-center" style="vertical-align: middle;">
                      <button class="btn btn-xs btn-link biasa" type="button">
                        <i class="fa fa-arrow-down"></i></button>
                    </td>
                    <td nowrap><input type="text" name="txtNoCOA[]" id="txtInputCOAsuppRow-1" class="txt" value="" readonly /></td>
                    <td nowrap><input type="text" name="txtNameCOA[]" id="txtInputNameSuppRow-1" class="txt" value="" readonly /></td>
                    <td nowrap><input type="text" name="txtDebit[]" id="txtInputDebitCBdetailRow-1" onKeyup="checkGST();" class="col-debit txt txtnum" /></td>
                    <td nowrap><input type="text" name="txtCredit[]" id="txtInputCreditCBdetailRow-1" onKeyup="checkGST();" class="col-credit txt txtnum" readonly /></td>
                    <td nowrap><input type="text" name="txtRemark[]" class="txt" /></td>
                    <td nowrap>
                      <select name="txtGST[]" class="txt gst-name display-none" onchange="checkGST()">
                        <option value=""> -- Select --</option>
                        <?php foreach ($_selectGST as $gst) : ?>
                          <option value="<?php echo $gst->gst_id; ?>"> <?php echo $gst->gst_name; ?></option>
                        <?php endforeach; ?>
                      </select>
                    </td>
                    <td nowrap><input type="text" id="txtInputGSTvalue1st" name="txtGSTvalue[]" class="txt txtnum gst-value display-none" /></td>
                  </tr>
                  <tr id="secendRowCashGeneral">
                    <td id="rowSelectCOArow2" class="text-center" style="vertical-align: middle;">
                      <button id="btnSelectCOArow2" class="btn btn-xs btn-link biasa" type="button">
                        <i class="fa fa-arrow-down"></i></button>
                    </td>
                    <td nowrap><input id="txtInputCOAsuppRow-2" type="text" name="txtNoCOA[]" class="txt" value="" readonly required="" /></td>
                    <td nowrap><input id="txtInputNameSuppRow-2" type="text" name="txtNameCOA[]" class="txt" value="" readonly required="" /></td>
                    <td nowrap><input id="txtInputDebitRow-2" type="text" name="txtDebit[]" onKeyup=" checkGST();" class="col-debit txt txtnum" readonly /></td>
                    <td nowrap><input id="txtInputCreditRow-2" type="text" name="txtCredit[]" onKeyup=" checkGST();" class="col-credit txt txtnum" /></td>
                    <td nowrap><input type="text" name="txtRemark[]" class="txt" /></td>
                    <td nowrap>
                      <select name="txtGST[]" class="txt gst-name" onchange="checkGST()">
                        <option value=""> -- Select --</option>
                        <?php foreach ($_selectGST as $gst) : ?>
                          <option value="<?php echo $gst->gst_id; ?>"> <?php echo $gst->gst_name; ?></option>
                        <?php endforeach; ?>
                      </select>
                    </td>
                    <td nowrap><input type="text" id="txtInputGSTvalue2nd" name="txtGSTvalue[]" class="txt txtnum gst-value" /></td>
                  </tr>
                </tbody>

                <tfoot id="detailRowForAddCost">
                  <tr id="addCostRow1">
                    <td class="text-center" style="vertical-align: middle;">
                      <button class="btn btn-xs btn-link biasa" type="button">
                        <i class="fa fa-arrow-up"></i></button>
                    </td>
                    <td nowrap><input type="text" name="txtNoCOA[]" id="txtInputCOAsuppRow-addCostRow-1" class="txt" value="610001" readonly /></td>
                    <td nowrap><input type="text" name="txtNameCOA[]" id="txtInputNameSuppRow-addCostRow-1" class="txt" value="Bank Charges" readonly /></td>
                    <td nowrap><input type="text" name="txtDebit[]" id="txtInputDebitCBdetailRow-addCostRow-1" class="col-debit txt txtnum" /></td>
                    <td nowrap><input type="text" name="txtCredit[]" id="txtInputCreditCBdetailRow-addCostRow-1" class="col-credit txt txtnum" /></td>
                    <td nowrap><input type="text" name="txtRemark[]" class="txt" /></td>
                    <td nowrap></td>
                    <td nowrap></td>
                  </tr>
                </tfoot>

                <tfoot id="detailRowForGSTfoot">
                  <tr id="rowGSTlast-1">
                    <td class="text-center" style="vertical-align: middle;">
                      <button class="btn btn-xs btn-link biasa" type="button">
                        <i class="fa fa-arrow-up"></i></button>
                    </td>
                    <td nowrap><input type="text" name="txtNoCOA[]" id="txtInputCOAsuppRow-GSTlast-1" class="txt" value="" readonly /></td>
                    <td nowrap><input type="text" name="txtNameCOA[]" id="txtInputNameSuppRow-GSTlast-1" class="txt" value="" readonly /></td>
                    <td nowrap><input type="text" name="txtDebit[]" id="txtInputDebitCBdetailRow-GSTlast-1" readonly class="col-debit txt txtnum" /></td>
                    <td nowrap><input type="text" name="txtCredit[]" id="txtInputCreditCBdetailRow-GSTlast-1" readonly class="col-credit txt txtnum" /></td>
                    <td nowrap><input type="text" name="txtRemark[]" class="txt" /></td>
                    <td nowrap></td>
                    <td nowrap></td>
                  </tr>
                  <tr id="rowGSTlast-2">
                    <td class="text-center" style="vertical-align: middle;">
                      <button class="btn btn-xs btn-link biasa" type="button">
                        <i class="fa fa-arrow-up"></i></button>
                    </td>
                    <td nowrap><input type="text" name="txtNoCOA[]" id="txtInputCOAsuppRow-GSTlast-2" class="txt" value="" readonly /></td>
                    <td nowrap><input type="text" name="txtNameCOA[]" id="txtInputNameSuppRow-GSTlast-2" class="txt" value="" readonly /></td>
                    <td nowrap><input type="text" name="txtDebit[]" id="txtInputDebitCBdetailRow-GSTlast-2" readonly class="col-debit txt txtnum" /></td>
                    <td nowrap><input type="text" name="txtCredit[]" id="txtInputCreditCBdetailRow-GSTlast-2" readonly class="col-credit txt txtnum" /></td>
                    <td nowrap><input type="text" name="txtRemark[]" class="txt" /></td>
                    <td nowrap></td>
                    <td nowrap></td>
                  </tr>
                </tfoot>

              </table>
            </div>

            <div class="portlet-body">
              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group">
                    <label class="col-sm-12" for="">Amount Debit</label>
                    <div class="col-sm-12">
                      <input class="form-control" name="txtAmountDebit" id="inputAmountDebit" type="text" readonly="" />
                      <input id="sumGST-1" type="hidden" readonly="" />
                    </div>
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="form-group">
                    <label class="col-sm-12" for="">Amount Credit</label>
                    <div class="col-sm-12">
                      <input class="form-control" name="txtAmountCredit" id="inputAmountCredit" type="text" readonly="" />
                      <input id="sumGST-2" type="hidden" readonly="" />
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

          </div>
        </div>

        <div class="col-md-12">
          <!-- BEGIN PORTLET-->
          <div class="portlet light">
            <div class="portlet-title">
              <div class="caption theme-font">
                <i class="icon-speech theme-font"></i>
                <span class="caption-subject bold uppercase"> Period</span>
                <span class="caption-helper"><?php echo date('F Y', strtotime($_periode)); ?></span>
              </div>
              <div class="actions">
                <a class="btn btn-circle btn-danger" id="btnCalculateDetail" href="javascript:;">
                  <i class="fa fa-calculator"></i> Calculate for Journals</a>
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
                        <th>[<span class="txtHeadCurrency"></span>] Equivalent</th>
                        <th>[USD] Equivalent</th>
                        <th>Currency</th>
                        <th>Account COA</th>
                        <th class="ismo-hidden">Cash Flow</th>
                      </tr>
                    </thead>
                    <tbody id="ajax-tblAP" class="display-none">
                      <tr>
                        <td class="text-center" style="vertical-align: middle;">1</td>
                        <td nowrap><input value="Claim" name="txtRemarkDetail[]" id="txtInputRemarkDetail" class="txt" readonly /></td>
                        <td nowrap><input value="" name="txtTotalDetal[]" id="inputAmountRow1" class="txt txtnum txt-ismo-back-null" readonly /></td>
                        <td nowrap><input value="" name="txtToCurr[]" id="inputToCurr1" class="txt txtnum txt-ismo-back-null" readonly /></td>
                        <td nowrap><input value="" name="txtEquiDetail[]" id="inputUSDRow1" class="txt txtnum txt-ismo-back-null" readonly /></td>
                        <td nowrap><input value="USD" name="txtCurrDetail[]" id="inCurFirstRow" class="txt txt-ismo-back-null" readonly /></td>
                        <td nowrap><input value="" name="txtCOADetail[]" id="txtCOADetailRow1" class="txt txt-ismo-back-null" readonly /></td>
                        <td nowrap class="ismo-hidden">
                          <input name="txtCFDetail[]" class="txt" id="cf-row-1" onclick="viewModalCashFlow(this.id)" readonly />
                          <input name="txtCFKeyDetail[]" type="hidden" class="txt" id="cf-row-1-key" readonly />
                        </td>
                      </tr>
                      <tr>
                        <td class="text-center" style="vertical-align: middle;">2</td>
                        <td nowrap><input value="Exchange Rate" name="txtRemarkDetail[]" class="txt" readonly /></td>
                        <td nowrap><input value="" name="txtTotalDetal[]" id="inputAmountRow2" class="txt txtnum" readonly /></td>
                        <td nowrap><input value="" name="txtToCurr[]" id="inputToCurr2" class="txt txtnum" readonly /></td>
                        <td nowrap><input value="" name="txtEquiDetail[]" id="inputUSDRow2" class="txt txtnum" readonly /></td>
                        <td nowrap><input value="USD" name="txtCurrDetail[]" id="inCurSecondRow" class="txt" readonly /></td>
                        <td nowrap><input value="" name="txtCOADetail[]" id="txtCOADetailRow2" class="txt" readonly /></td>
                        <td nowrap class="ismo-hidden">
                          <input name="txtCFDetail[]" class="txt" id="cf-row-2" onclick="viewModalCashFlow(this.id)" readonly />
                          <input name="txtCFKeyDetail[]" type="hidden" class="txt" id="cf-row-2-key" readonly />
                        </td>
                      </tr>
                      <tr>
                        <td class="text-center" style="vertical-align: middle;">3</td>
                        <td nowrap><input value="Cash" name="txtRemarkDetail[]" id="txtInputRemarkDetail3th" class="txt" readonly /></td>
                        <td nowrap><input value="" name="txtTotalDetal[]" id="inputAmountRow3" class="txt txtnum" readonly /></td>
                        <td nowrap><input value="" name="txtToCurr[]" id="inputToCurr3" class="txt txtnum" readonly /></td>
                        <td nowrap><input value="" name="txtEquiDetail[]" id="inputUSDRow3" class="txt txtnum" readonly /></td>
                        <td nowrap><input value="USD" name="txtCurrDetail[]" id="inCurThreeRow" class="txt" readonly /></td>
                        <td nowrap><input value="" name="txtCOADetail[]" id="txtCOADetailRow3" class="txt" readonly /></td>
                        <td nowrap class="ismo-hidden">
                          <input name="txtCFDetail[]" class="txt" id="cf-row-3" onclick="viewModalCashFlow(this.id)" readonly />
                          <input name="txtCFKeyDetail[]" type="hidden" class="txt" id="cf-row-3-key" readonly />
                        </td>
                      </tr>
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
                  <div class="col-sm-2">
                    <div class="form-group">
                      <button class="btn btn-sm btn-primary" id="btnFindRecord" type="button">
                        Find <i class="fa fa-sm fa-search fa-fw" aria-hidden="true"></i> </button>
                      <button class="btn btn-sm btn-default disabled display-none" id="btnPrint" type="button">
                        Print <i class="fa fa-sm fa-print fa-fw" aria-hidden="true"></i></button>
                    </div>
                  </div>
                  <div class="col-sm-offset-8 col-sm-2 text-right">
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

<!-- Select Customer -->
<div class="modal fade" id="modal-select-supplier" tabindex="-1" role="basic" aria-hidden="true">
  <div class="modal-dialog" style="width: 50%;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title">Select Customer</h4>
      </div>
      <div class="modal-body">
        <div id="contentSelectSupplier"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- Select Invoice -->
<div class="modal fade" id="modal-invoice" tabindex="-1" role="basic" aria-hidden="true">
  <div class="modal-dialog" style="width: 50%;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title">Select Invoice</h4>
      </div>
      <div class="modal-body">
        <div id="contentInvoiceSelect"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- Select AR -->
<div class="modal fade" id="modal-ar" tabindex="-1" role="basic" aria-hidden="true">
  <div class="modal-dialog" style="width: 75%;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title">Select A/R From Accounting</h4>
      </div>
      <div class="modal-body">
        <div id="contentARlist"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- Select MCOA -->
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
<!-- Select Cash Flow -->
<div class="modal fade" id="modal-cf" tabindex="-1" role="basic" aria-hidden="true">
  <div class="modal-dialog" style="width: 75%;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title">Select Master Cash Flow</h4>
      </div>
      <div class="modal-body">
        <input class="form-control input-sm" id="id-cf-this" type="hidden" value="">
        <div id="modalCashFlow"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- Select COA for Additional Cost -->
<div class="modal fade" id="modal-MCOAforAddCost" tabindex="-1" role="basic" aria-hidden="true">
  <div class="modal-dialog" style="width: 75%;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title">Select Master COA for Additional Cost</h4>
      </div>
      <div class="modal-body">
        <div id="contentMasterCOAforAddCost"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- Find Recorded AP Payment Transaction Modal -->
<div class="modal fade" id="modal-findAR" tabindex="-1" role="basic" aria-hidden="true">
  <div class="modal-dialog" style="width: 75%;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title">Select AR Payment</h4>
      </div>
      <div class="modal-body">
        <div id="contentFindAR"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<div id="toast-container" class="toast-top-right" aria-live="polite" role="alert" style="display : none">
  <div class="toast toast-error" style="display: block;">
    <div class="toast-message">Are you the six fingered man?</div>
  </div>
</div>

<script src="<?php echo base_url(); ?>assets/global/jq/numToWord.js"></script>
<script src="<?php echo base_url(); ?>assets/global/plugins/bootbox/bootbox.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/global/plugins/jquery.pulsate.min.js" type="text/javascript"></script>
<script type="text/javascript">
  $(document).ready(function() {
    $("#btnCancel").click(function() {
      location.reload();
    });

    $('.txtnum').blur(function() {
      var val = parseFloat($(this).val().replace(/,/g, ''));
      if (!val) {
        var vall = 0;
      } else {
        vall = val;
      }
      $(this).val(addCommas(vall.toFixed(2)));
      checkGST();
    });
    $('.txtnumRate').blur(function() {
      var val = parseFloat($(this).val().replace(/,/g, ''));
      if (!val) {
        var vall = 0;
      } else {
        vall = val;
      }
      $(this).val(addCommas(vall.toFixed(6)));
      checkGST();
    });

    $('#txtInputTransDate, #txtCUR2, #txtInputRateWeeklySGD').on('change blur', function() {
      if ($('#txtInputTransDate').val() && $('#txtInputRateWeeklySGD').val()) {
        setInterval(function() {
          $.post("<?php echo base_url(); ?>CBtrans/newGenerateReffNumber", {
            txtTypeForGen: 'IN',
            txtCurrForGen: $('#txtCUR2').val(),
            txtDateForGen: $('#txtInputTransDate').val()
          }, function(data, statuss) {
            $('#inputNoReff').val(data);
          });
        }, 2000);
      }
    });

    //=========================================================================================
    $('#txtInputGSTvalue2nd').addClass('gst-value-credit');
    $('#txtInputGSTvalue2nd').removeClass('gst-value-debit');
    $('#txtInputGSTvalue1st').addClass('gst-value-debit');
    $('#txtInputGSTvalue1st').removeClass('gst-value-credit');
    //==============GST=========
    $('#txtInputCOAsuppRow-GSTlast-1').val('200801');
    $('#txtInputNameSuppRow-GSTlast-1').val('GST Output Tax');

    // == Additional Cost
    $("#btnAddCost").click(function() {
      $.ajax({
        url: "<?php echo site_url('CBtrans/selectCOAforAddCost'); ?>",
        type: "POST",
        datatype: "json",
        cache: false,
        success: function(respon) {
          $('#contentMasterCOAforAddCost').html(respon);
        }
      });
      $('#modal-MCOAforAddCost').modal('show');
    });
    //=========================================================================================

    $('#txtInputTransDate').on('change', function() {
      var now = $(this).data('now');
      var nowD = now.substr(0, 2);
      var nowM = now.substr(3, 2);
      var nowY = now.substr(6, 4);
      var yes = $(this).data('yesterday');
      var yesD = yes.substr(0, 2);
      var yesM = yes.substr(3, 2);
      var yesY = yes.substr(6, 4);
      var val = $(this).val();
      var valD = val.substr(0, 2);
      var valM = val.substr(3, 2);
      var valY = val.substr(6, 4);
      var nowDate = new Date(nowY, nowM, nowD);
      var yesDate = new Date(yesY, yesM, yesD);
      var valDate = new Date(valY, valM, valD);
      if (valDate > nowDate) {
        bootbox.alert('Date of the transaction can not be longer than the current date!');
        $(this).val('<?php echo date('d-m-Y'); ?>');
      }
      /*else if(valDate < yesDate){
          bootbox.alert('Date of the transaction can only be less one day from the date now!');
          $(this).val('<?php echo date('d-m-Y'); ?>');
      }*/
    });

    $("#btn-generate-noreff").click(function() {
      $.ajax({
        url: "<?php echo site_url('APtrans/generateReffNumAP'); ?>",
        dataType: 'json',
        success: function(gen) {
          $('#inputNoReff').val(gen);
          $('#inputNoReff').focus();
          //$('#inputNoReff').attr('readonly', true);
        }
      });
    });

    /*$("#txtJurNum").click(function() {
        $.ajax({
            url:"<?php //echo site_url('ARtrans/selectModalAR');
                  ?>",
            type:"POST",
            datatype:"json",
            cache:false,
            success:function(respon){
                $('#contentARlist').html(respon);
            }
        });
        $('#modal-ar').modal('show');
    });*/

    $("#inputCOA").click(function() {
      if ($('#inputTotalVoucher').val() === '') {
        bootbox.alert('the First Choice Invoice in below!');
      } else {
        $.ajax({
          url: "<?php echo site_url('ARtrans/selectCOA'); ?>",
          type: "POST",
          datatype: "json",
          cache: false,
          success: function(respon) {
            $('#contentMasterCOA').html(respon);
          }
        });
        $('#modal-MCOA').modal('show');
      }
      $('#tbl-payment tbody').addClass('display-none');
    });

    /*
    $("#txtCUR2").change(function (){
        var valCUR  = $(this).val();
        var totUSD  = parseFloat($('#debTotalID').val().replace(/,/g, ''));
        
        if($('#inputCOA').val() === ''){
            bootbox.alert('the First Choode Cash Bank Code!');
            $(this).val('');
        }else{
            var noInvoice   = $('input.col-no-invoice').map(function () {
                return this.value;
            }).get().join('|');
            //alert(noInvoice);
            $.post("<?php //echo site_url('ARtrans/getCurrOnDateInvoice');
                    ?>",{
                txtCurrency : valCUR,
                txtNoInvoice : noInvoice
            }, function(data, success){
                var get = $.parseJSON(data);
                var no  = 0;
                $('input.col-rate-curr').each(function() {
                    $(this).val(parseFloat(get[no++]).toFixed(2));
                });
                //alert(get[0]);
                var col_tota    = document.getElementsByClassName('col-dtot');
                var col_equi    = document.getElementsByClassName('col-equi-curr');
                var jum = 0;
                var jum2 = 0;
                for (var i = 0; i < col_equi.length; i++) {
                    var dd = parseFloat(get[i]).toFixed(2);
                    var cc = col_tota[i].value.replace(/,/g, '');
                    var total = parseFloat(cc)/dd;
                    col_equi[i].value = addCommas(total.toFixed(2));
                    jum += parseFloat(cc)*dd;
                    jum2 += parseFloat(cc)/dd;
                }
                //alert(jum/btot);
                $('#rateToCurr').val(parseFloat(jum/totUSD).toFixed(2));
                $('#equiToCurr').val(addCommas(parseFloat(jum2).toFixed(2)));
                 $('#txtAmountPayment').val(addCommas(parseFloat(jum2).toFixed(2)));
            });
            $('.txtHeadCurrency').html(valCUR);
            
            $.ajax({
                url:"<?php //echo site_url('ARtrans/selectCurrencyAR');
                      ?>",
                data: {
                    txtCurrAjax : valCUR
                },
                type:"POST",
                datatype:"json",
                success: function(ress){
                    var data = $.parseJSON(ress);
                    //alert(data.rate_usd);
                    $('#txtInputRateWeekly').val(data.rate_usd);
                    $('#txtInputRateNego').val(data.rate_usd);
                    $('#txtInputRateEqui').val(0);

                    // set value 3th detail
                    /*var amount0 = $('#inputTotalVoucher').val();
                    var amount  = parseFloat(amount0.replace(/,/g, ""));
                    var equiAmount  = (data.rate_usd * amount).toFixed(6);
                    var equiR10     = $('#inputUSDRow1').val();
                    var equiR1      = parseFloat(equiR10.replace(/,/g, ""));
                    var selisih     = (equiAmount-equiR1).toFixed(6);

                    //alert(addCommas(equiAmount) +' --- '+selisih);
                    $('#inputUSDRow3').val(addCommas(equiAmount));
                    $('#inputUSDRow2').val(addCommas(selisih));
                    $('#inCurThreeRow').val(valCUR);
                }
            });
        }
        
        $('#tbl-payment tbody').addClass('display-none');
    });*/

    //Calculate Detail AP
    $("#btnCalculateDetail").click(function() {
      var inUSD = parseFloat($('#inputUSDRow1').val().replace(/,/g, ''));
      var rate1st = parseFloat($('#rateToCurr').val().replace(/,/g, ''));
      var rate2nd = parseFloat($('#txtInputRateNego').val().replace(/,/g, ''));

      var inByCurr1st = inUSD / rate1st;
      var inByCurr2nd = inUSD / rate2nd;
      var selisih = inByCurr2nd - inByCurr1st;

      $('#inputToCurr1').val(addCommas(inByCurr1st.toFixed(2)));
      $('#inputToCurr2').val(addCommas(selisih.toFixed(2)));
      $('#inputToCurr3').val(addCommas(inByCurr2nd.toFixed(2)));

      $('#inputUSDRow3').val($('#inputUSDRow1').val());
      $('#inputAmountRow3').val($('#inputAmountRow1').val());

      $('#tbl-payment tbody').removeClass('display-none');
    });

    //select CURRENCY
    $("#selInputCurrencyVoucher").change(function() {
      var valCUR = $(this).val();

      $('#inCurFirstRow').val(valCUR);

      if ($('#modal-invoice').hasClass('has-ismo-modal')) {
        $('#modal-invoice').removeClass('has-ismo-modal');
      }
    });
    // SELECT CUSTOMER ============
    $("#txtInputSuplierID, #txtInputSuplierName").click(function() {
      var txtTglTrn = $('#txtInputTransDate').val();
      if (!txtTglTrn) {
        bootbox.alert('Input First Date Transaction!');
      } else {
        $.ajax({
          url: "<?php echo site_url('ARtrans/selectCustomerForAR'); ?>",
          data: {
            txtTglInvoice: $('#txtInputTransDate').val()
          },
          type: "POST",
          datatype: "json",
          cache: false,
          success: function(respon) {
            $('#contentSelectSupplier').html(respon);
          }
        });
        $('#modal-select-supplier').modal('show');
        $('#modal-invoice').removeClass('has-ismo-modal');
        $('.added-row-ismo').remove();
        $('.txt-ismo-back-null').val('');
      }
    });
    //select INVOICE
    $("#btnSelectInvoice").click(function() {
      if (inSuppID === '' && inCurrID === '') {
        bootbox.alert('First input Field Customer and Voucher Currency!');
      } else if (inSuppID === '') {
        bootbox.alert('First input Field Customer!');
      } else if (inCurrID === '') {
        bootbox.alert('First choose Voucher Currency!');
      } else {
        if ($('#modal-invoice').hasClass('has-ismo-modal')) {
          $('#modal-invoice').modal('show');
        } else {
          var inSuppID = $('#txtInputSuplierID').val();
          var inCurrID = $('#selInputCurrencyVoucher').val();
          var inTransD = $('#txtInputTransDate').val();
          $.ajax({
            url: "<?php echo site_url('ARtrans/selectInvoiceForAR'); ?>",
            type: "POST",
            data: {
              incSupplierID: inSuppID,
              incCurrencyID: inCurrID,
              incTransDate: inTransD
            },
            datatype: "json",
            cache: false,
            success: function(respon) {
              $('#contentInvoiceSelect').html(respon);
            }
          });
          $('#modal-invoice').modal('show');
          $('#modal-invoice').addClass('has-ismo-modal');
        }
      }
    });

    // ===== ## Find AP Payment ## =====
    $("#btnFindRecord").click(function() {
      $.post("<?php echo site_url(); ?>ARtrans/selectARpayment", function(data) {
        $('#contentFindAR').html(data);
      });
      $('#modal-findAR').modal('show');
    });

    $("#form-ARtrans").submit(function(e) {
      var currentForm = this;
      e.preventDefault();
      if ($('#ajax-tblAP').hasClass('display-none')) {
        setPulsate('#btnCalculateDetail');
        setToast('Calculate Detail Payment!');
      } else {
        /*var amountPayment   = $('#inputAmountRow3').val();
        var numberBank      = $('#txtCOADetailRow3').val();
        //alert(amountPayment + ' - ' + numberBank);

        $.post("<?php //echo site_url();
                ?>CBtrans/checkSaldoAwal", {
            txtPayment : amountPayment,
            txtBankCode : numberBank
        }, function (respon) {
            if(respon == 'error01'){
                bootbox.alert('Beginning balance is empty !');
            }else if(respon == 'error02'){
                bootbox.alert('Oops, balances less !');
            }else{*/
        bootbox.confirm("Are you realy want to submit this transaction?", function(result) {
          if (result) {
            currentForm.submit();
          }
        });
        /*    }
        });*/
      }
    });
  });
</script>
<script>
  function Pilih_Supllier(x) {
    function getText(el) {
      if (typeof el.textContent === 'string')
        return el.textContent;
      if (typeof el.innerText === 'string')
        return el.innerText;
    }

    $r = x.rowIndex;

    //== set Value Header
    $('#txtInputSuplierID').val(getText(document.getElementById('tbl-selectSupplier').rows[$r].cells[0]));
    $('#txtInputSuplierName').val(getText(document.getElementById('tbl-selectSupplier').rows[$r].cells[1]));
    $('#txtInputSuplierRemark').val('Payment of Receivables to ' + getText(document.getElementById('tbl-selectSupplier').rows[$r].cells[1]));

    //== set Value Detail
    $('#txtInputRemarkDetail').val(getText(document.getElementById('tbl-selectSupplier').rows[$r].cells[1]));
    $('#txtCOADetailRow1').val(getText(document.getElementById('tbl-selectSupplier').rows[$r].cells[3]));

    //================== Bank
    $('#txtInputCOAsuppRow-2').val(getText(document.getElementById('tbl-selectSupplier').rows[$r].cells[3]));
    $('#txtInputNameSuppRow-2').val(getText(document.getElementById('tbl-selectSupplier').rows[$r].cells[1]));

    $('#modal-select-supplier').modal('hide');
  }

  function Pilih_Invoice(x) {
    function getText(el) {
      if (typeof el.textContent === 'string')
        return el.textContent;
      if (typeof el.innerText === 'string')
        return el.innerText;
    }
    var rr = x.rowIndex;
    var cls = getText(document.getElementById('tbl-selectInvoice').rows[rr].cells[4]);
    var rate = getText(document.getElementById('tbl-selectInvoice').rows[rr].cells[1]).replace(/,/g, '');
    var total = getText(document.getElementById('tbl-selectInvoice').rows[rr].cells[2]).replace(/,/g, '');
    var toUsd = Number(rate) * Number(total);

    $('#tbl-detail-invoice tbody').append('<tr class="' + cls + ' added-row-ismo">\n\
            <td></td>\n\
            <td><input value="' + getText(document.getElementById('tbl-selectInvoice').rows[rr].cells[0]) + '" name="txtNoInvoiceDtl[]" class="txt col-no-invoice" readonly/></td>\n\
            <td><input value="" name="txtRateToCurr[]" class="txt col-rate-curr txtnum" readonly/></td>\n\
            <td><input value="" name="txtEquiToCurr[]" class="txt col-equi-curr txtnum" readonly/></td>\n\
            <td><input value="' + getText(document.getElementById('tbl-selectInvoice').rows[rr].cells[1]) + '" name="txtRateInvoiceDtl[]" class="txt col-rate txtnum" readonly/></td>\n\
            <td><input value="' + getText(document.getElementById('tbl-selectInvoice').rows[rr].cells[2]) + '" name="txtTotalBeforeInvoiceDtl[]" class="txt col-btot txtnum" readonly/></td>\n\
            <td><input value="' + addCommas(toUsd.toFixed(2)) + '" name="txtToUSDInvoiceDtl[]" class="txt col-dtot txtnum" readonly/></td>\n\
            <td><input data-max="' + getText(document.getElementById('tbl-selectInvoice').rows[rr].cells[3]) + '" \n\
                value="' + getText(document.getElementById('tbl-selectInvoice').rows[rr].cells[3]) + '" name="txtPeymentInvoiceDtl[]" \n\
                class="txt col-ptot txtnum ' + cls + 'ar" onkeyup="CountPayTotal(); HitungPayment(); CheckMaxValue(this)"/></td>\n\
        </tr>');

    CountGrandTotal();
    $(function() {
      $('.txtnum').numericInput({
        allowFloat: true,
        allowNegative: true
      });
      $('.' + cls + 'ar').on('blur', function() {
        var val = parseFloat($(this).val().replace(/,/g, ''));
        if (!val) {
          var vall = 0;
        } else {
          vall = val;
        }
        $(this).val(addCommas(vall.toFixed(2)));

        CountPayTotal();
        $('#tbl-payment tbody').addClass('display-none');
      });

      /*$('.txtnum').keyup( function(){
          var maxVal  = $(this).data('max').replace(/,/g, '');
          var value   = $(this).val().replace(/,/g, '');
          if(parseFloat(value) > parseFloat(maxVal) || parseFloat(value) < 0){
              bootbox.alert("Value should not be more than "+maxVal+" and less than 0");
              $(this).val(addCommas(parseFloat(maxVal).toFixed(2)));
              
              CountPayTotal();
              HitungPayment();
          }
      });*/
    });
  }

  function CheckMaxValue(obj) {
    var value = obj.value.replace(/,/g, '');
    var maxVal = obj.getAttribute('data-max').replace(/,/g, '');
    //alert('value:'+value+' - - max:'+max);
    if (parseFloat(value) > parseFloat(maxVal) || parseFloat(value) < 0) {
      bootbox.alert("Value should not be more than " + maxVal + " and less than 0");
      $(obj).val(addCommas(parseFloat(maxVal).toFixed(2)));

      CountPayTotal();
      HitungPayment();
    }
  }

  function CountPayTotal() {
    var sumPay = 0;
    var ratAvg = $('#rateTotalID').val();
    $(".col-ptot").each(function() {
      var valPtot = this.value;
      var newPtot = parseFloat(valPtot.replace(/,/g, ''));
      if (!isNaN(newPtot) && this.value.length !== 0) {
        sumPay += parseFloat(newPtot);
      }
    });
    var final = sumPay * ratAvg;
    $('#payTotalID').val(addCommas(sumPay.toFixed(2)));
    $('#inputTotalVoucher').val(addCommas(sumPay.toFixed(2)));
    $('#txtInputRateSGD').val(addCommas(final.toFixed(2)));

    $('#inputAmountRow1').val(addCommas(sumPay.toFixed(2)));
    $('#inputUSDRow1').val(addCommas(final.toFixed(2)));
    $('#amountTerbilang').val('In Word: United States Dollar, ' + capitalize(toWords(final.toFixed(2))));

    //====== for Bank
    $('#txtInputCreditRow-2').val(addCommas(sumPay.toFixed(2)));
  }

  function HitungPayment() {
    var totVoucher = $('#inputTotalVoucher').val().replace(/,/g, '');
    var rateVouch = $('#txtInputRateVoucher').val();
    var rateNego = $('#txtInputRateNego').val();
    var result = parseFloat(totVoucher) * parseFloat(rateVouch) / parseFloat(rateNego);

    $('#txtAmountPayment').val(addCommas(result.toFixed(2)));
  }

  function CountGrandTotal() {
    var sumPay = 0;
    var sumDeb = 0;
    var sumBef = 0;
    $(".col-ptot").each(function() {
      var valPtot = this.value;
      var newPtot = parseFloat(valPtot.replace(/,/g, ''));
      if (!isNaN(newPtot) && this.value.length !== 0) {
        sumPay += parseFloat(newPtot);
      }
    });

    $(".col-dtot").each(function() {
      var valDtot = this.value;
      var newDtot = parseFloat(valDtot.replace(/,/g, ''));
      if (!isNaN(newDtot) && this.value.length !== 0) {
        sumDeb += parseFloat(newDtot);
      }
    });

    $(".col-btot").each(function() {
      var valBtot = this.value;
      var newBtot = parseFloat(valBtot.replace(/,/g, ''));
      if (!isNaN(newBtot) && this.value.length !== 0) {
        sumBef += parseFloat(newBtot);
      }
    });
    //alert(sum);
    var avgRate = sumDeb / sumBef;
    $('#payTotalID').val(addCommas(sumPay.toFixed(2)));
    $('#debTotalID').val(addCommas(sumDeb.toFixed(2)));
    $('#befTotalID').val(addCommas(sumBef.toFixed(2)));
    $('#rateTotalID').val(addCommas(avgRate.toFixed(6)));

    var final = sumPay * avgRate;
    $('#txtInputRateVoucher').val(addCommas(avgRate.toFixed(6)));
    $('#inputTotalVoucher').val(addCommas(sumPay.toFixed(2)));
    $('#txtInputRateSGD').val(addCommas(final.toFixed(2)));

    $('#inputAmountRow1').val(addCommas(sumPay.toFixed(2)));
    $('#inputUSDRow1').val(addCommas(final.toFixed(2)));
    $('#amountTerbilang').val('In Word: United States Dollar, ' + capitalize(toWords(final.toFixed(2))));

    //====== for Bank
    $('#txtInputCreditRow-2').val(addCommas(sumPay.toFixed(2)));
  }

  function Pilih_AR(x) {
    function getText(el) {
      if (typeof el.textContent === 'string')
        return el.textContent;
      if (typeof el.innerText === 'string')
        return el.innerText;
    }

    $r = x.rowIndex;

    //== Set value header
    $('#txtJurNum').val(getText(document.getElementById('tbl-selectAR').rows[$r].cells[0]));
    $('#txtInputVoucherDate').val(getText(document.getElementById('tbl-selectAR').rows[$r].cells[1]));
    $('#txtInputSuplierID').val(getText(document.getElementById('tbl-selectAR').rows[$r].cells[2]));
    $('#txtInputSuplierRemark').val(getText(document.getElementById('tbl-selectAR').rows[$r].cells[8]));
    $('#selInputCurrencyVoucher').val(getText(document.getElementById('tbl-selectAR').rows[$r].cells[4]));
    $('#txtInputRateVoucher').val(getText(document.getElementById('tbl-selectAR').rows[$r].cells[6]));
    $('#inputTotalVoucher').val(getText(document.getElementById('tbl-selectAR').rows[$r].cells[5]));
    $('#txtInputRateSGD').val(getText(document.getElementById('tbl-selectAR').rows[$r].cells[7]));

    //== Set Detail value from AP
    $('#txtInputRemarkDetail').val(getText(document.getElementById('tbl-selectAR').rows[$r].cells[3]));
    $('#inputAmountRow1').val(getText(document.getElementById('tbl-selectAR').rows[$r].cells[5]));
    $('#inputUSDRow1').val(getText(document.getElementById('tbl-selectAR').rows[$r].cells[7]));
    $('#inCurFirstRow').val(getText(document.getElementById('tbl-selectAR').rows[$r].cells[4]));
    $('#inCurSecondRow').val('USD');
    $('#txtCOADetailRow1').val(getText(document.getElementById('tbl-selectAR').rows[$r].cells[9]));

    //== Amount Terbilang
    var toWord = toWords(getText(document.getElementById('tbl-selectAR').rows[$r].cells[7]));
    $('#amountTerbilang').val('In Word: United States Dollar, ' + capitalize(toWord));

    //== Hide Modal Select AP
    $('#modal-ar').modal('hide');

    $(".read-only-curr :selected").each(function() {
      $(this).parent().data("default", this);
    });
    $(".read-only-curr").change(function(e) {
      $($(this).data("default")).prop("selected", true);
    });
  }

  function Pilih_MCOAforAddCost(x) {
    function getText(el) {
      if (typeof el.textContent === 'string') return el.textContent;
      if (typeof el.innerText === 'string') return el.innerText;
    }

    bootbox.dialog({
      message: "What would you do?",
      buttons: {
        pay: {
          label: "Additional Cost",
          className: "green btn-sm",
          callback: function() {
            var $r = x.rowIndex;
            var cls = getText(document.getElementById('tbl-MasterCOAforAddCost').rows[$r].cells[4]);
            var typeIO = $('#poTXTtypeIO').val();

            $('table[id="tbl-cashGeneral"] tfoot[id="detailRowForAddCost"]').append('<tr class="' + cls + ' added-row-ismo">\n\
                            <td class="text-center" style="vertical-align: middle;">\n\
                                <button class="btn btn-xs btn-link buruk" type="button" onclick="delete_MCOA(this)"><i class="fa fa-trash-o"></i></button></td>\n\
                            <td nowrap><input type="text" name="txtNoCOA[]"  class="txt" value="' + getText(document.getElementById('tbl-MasterCOAforAddCost').rows[$r].cells[0]) + '" readonly/></td>\n\
                            <td nowrap><input type="text" name="txtNameCOA[]" class="txt" value="' + getText(document.getElementById('tbl-MasterCOAforAddCost').rows[$r].cells[1]) + '" readonly/></td>\n\
                            <td nowrap><input type="text" name="txtDebit[]" onKeyup="checkGST();" class="ac-col-debit txt txtnum ' + cls + 'xx" /></td>\n\
                            <td nowrap><input type="text" name="txtCredit[]" readonly onKeyup="checkGST();" class="ac-col-credit txt txtnum ' + cls + 'xx"/></td>\n\
                            <td nowrap><input type="text" name="txtRemark[]" class="txt"/></td>\n\
                            <td nowrap><input type="text" name="txtGST[]" class="txt"/></td>\n\
                            <td nowrap><input type="text" name="txtGSTvalue[]" class="txt txtnum gst-value gst-value-debit"/></td>\n\
                        </tr>');

            $(function() {
              $('.txtnum').numericInput({
                allowFloat: true,
                allowNegative: true
              });
              $('.' + cls + 'xx').blur(function() {
                var val = parseFloat($(this).val().replace(/,/g, ''));
                if (!val) {
                  var vall = 0;
                } else {
                  vall = val;
                }
                $(this).val(addCommas(vall.toFixed(2)));
                checkGST();
              });
            });
          }
        },
        cancel: {
          label: "Cancel",
          className: "default btn-sm",
          callback: function() {
            bootbox.hideAll()
          }
        }
      }
    });
  }

  function Pilih_MCOA(x) {
    function getText(el) {
      if (typeof el.textContent === 'string')
        return el.textContent;
      if (typeof el.innerText === 'string')
        return el.innerText;
    }

    $r = x.rowIndex;

    //== Set value header COA
    $('#inputCOA').val(getText(document.getElementById('tbl-MasterCOA').rows[$r].cells[0]));
    $('#inputCOAremark').val(getText(document.getElementById('tbl-MasterCOA').rows[$r].cells[1]));

    //============== Bank 
    $('#txtInputCOAsuppRow-1').val(getText(document.getElementById('tbl-MasterCOA').rows[$r].cells[0]));
    $('#txtInputNameSuppRow-1').val(getText(document.getElementById('tbl-MasterCOA').rows[$r].cells[1]));

    $('#txtInputCOAsuppRow-GSTlast-2').val(getText(document.getElementById('tbl-MasterCOA').rows[$r].cells[0]));
    $('#txtInputNameSuppRow-GSTlast-2').val(getText(document.getElementById('tbl-MasterCOA').rows[$r].cells[1]));

    //== Set cash detail
    var toUSD = $('#inputUSDRow1').val();
    $('#inputUSDRow3').val(toUSD);
    $('#txtCOADetailRow3').val(getText(document.getElementById('tbl-MasterCOA').rows[$r].cells[0]));
    $('#txtInputRemarkDetail3th').val(getText(document.getElementById('tbl-MasterCOA').rows[$r].cells[1]));

    //== +++++++++++++++++++++++++ ==
    var valCUR = getText(document.getElementById('tbl-MasterCOA').rows[$r].cells[3]);
    var totUSD = parseFloat($('#debTotalID').val().replace(/,/g, ''));
    var tglInv = $('#txtInputTransDate').val();
    //alert(curr);
    if (valCUR != 'ALL') {
      var noInvoice = $('input.col-no-invoice').map(function() {
        return this.value;
      }).get().join('|');
      //alert(noInvoice);
      $.post("<?php echo site_url('ARtrans/getCurrOnDateInvoice'); ?>", {
        txtCurrency: valCUR,
        txtNoInvoice: noInvoice,
        txtTglInvoice: tglInv
      }, function(data, success) {
        var get = $.parseJSON(data);
        var no = 0;
        $('input.col-rate-curr').each(function() {
          $(this).val(parseFloat(get.inv[no++]).toFixed(6));
        });
        //alert(get[0]);
        var col_tota = document.getElementsByClassName('col-dtot');
        var col_equi = document.getElementsByClassName('col-equi-curr');
        var jum = 0;
        var jum2 = 0;
        for (var i = 0; i < col_equi.length; i++) {
          var dd = parseFloat(get.inv[i]).toFixed(2);
          var cc = col_tota[i].value.replace(/,/g, '');
          var total = parseFloat(cc) / dd;
          col_equi[i].value = addCommas(total.toFixed(2));
          jum += parseFloat(cc) * dd;
          jum2 += parseFloat(cc) / dd;
        }
        /*
        var totalvoucher = document.getElementById('inputTotalVoucher').value;
        var totalvoucher1 = totalvoucher.replace(/,/g, '');
        var rate_v = document.getElementById('txtInputRateVoucher').value;
        var rate_n = document.getElementById('txtInputRateNego').value;
        // var amount_payment = document.getElementById('txtAmountPayment');
        var total = totalvoucher1 * rate_v / rate_n;*/
        $('#txtInputRateWeekly').val(get.rate_usd);
        $('#txtInputRateNego').val(get.rate_usd);
        $('#txtInputRateWeeklySGD').val(get.rate_sgd);
        $('#txtInputRateEqui').val(0.000000);

        //alert(jum/btot);
        $('#rateToCurr').val(parseFloat(jum / totUSD).toFixed(6));
        $('#equiToCurr').val(addCommas(parseFloat(jum2).toFixed(2)));
        //$('#txtAmountPayment').val(addCommas(parseFloat(jum2).toFixed(2)));
        var totVoucher = $('#inputTotalVoucher').val().replace(/,/g, '');
        var rateVouch = $('#txtInputRateVoucher').val();
        var rateNego = get.rate_usd;
        var result = parseFloat(totVoucher) * parseFloat(rateVouch) / parseFloat(rateNego);

        $('#txtAmountPayment').val(addCommas(result.toFixed(2)));
      });
      $('.txtHeadCurrency').html(valCUR);

      /*$.ajax({
          url:"<?php //echo site_url('ARtrans/selectCurrencyAR');
                ?>",
          data: {
              txtCurrAjax : valCUR
          },
          type:"POST",
          datatype:"json",
          success: function(ress){
              var data = $.parseJSON(ress);
              //alert(data.rate_usd);
              $('#txtInputRateWeekly').val(data.rate_usd);
              $('#txtInputRateNego').val(data.rate_usd);
              $('#txtInputRateEqui').val(0);
          }
      });*/

      $('#txtCUR2').val(valCUR);
      $("#txtCUR2 :selected").each(function() {
        $(this).parent().data("default", this);
      });
      $("#txtCUR2").change(function(e) {
        $($(this).data("default")).prop("selected", true);
      });
    }

    $('#modal-MCOA').modal('hide');
    $('#txtInputRateWeeklySGD').focus();
  }

  function delete_MCOA(x) {
    var row = x.parentNode.parentNode;
    bootbox.confirm("Are you sure?", function(result) {
      if (result == true) {
        row.parentNode.removeChild(row);

        checkGST();

        $('#txtInputDebitCBdetailRow-1').focus();
      }
    });
  }

  // ==## Check GST ##==
  function checkGST() {
    var gst_type = document.getElementsByClassName('gst-name');
    var debit_txt = document.getElementsByClassName('col-debit');
    var credit_txt = document.getElementsByClassName('col-credit');
    var gst_value = document.getElementsByClassName('gst-value');
    var rateSGD = parseFloat($('#txtInputRateWeeklySGD').val().replace(/,/g, ''));

    for (var i = 0; i < gst_type.length; i++) {
      if (gst_type[i].value === 'GST') {
        var dd = debit_txt[i].value.replace(/,/g, '');
        var cc = credit_txt[i].value.replace(/,/g, '');
        var total = ((Number(dd) + Number(cc)) * rateSGD * 0.07);
        gst_value[i].value = addCommas(total.toFixed(2));
      } else {
        gst_value[i].value = 0.00;
      }
    }

    var get1 = 0;
    var get2 = 0;
    var forGSTusd = parseFloat($('#txtInputRateNego').val().replace(/,/g, ''));
    var forGSTsgd = parseFloat($('#txtInputRateWeeklySGD').val().replace(/,/g, ''));

    $('.gst-value-debit').each(function(index, item) {
      if ($(item).val()) {
        get1 += parseFloat($(item).val().replace(/,/g, ''));
        var set1 = get1 / (forGSTsgd / forGSTusd);
        $('#sumGST-1').val(set1);
        $('#txtInputDebitCBdetailRow-GSTlast-1').val(addCommas(set1.toFixed(2)));
        $('#txtInputCreditCBdetailRow-GSTlast-2').val(addCommas(set1.toFixed(2)));
      }
    });
    $('.gst-value-credit').each(function(index, item) {
      if ($(item).val()) {
        get2 += parseFloat($(item).val().replace(/,/g, ''));
        var set2 = get2 / (forGSTsgd / forGSTusd);
        $('#sumGST-2').val(set2);
        $('#txtInputCreditCBdetailRow-GSTlast-1').val(addCommas(set2.toFixed(2)));
        $('#txtInputDebitCBdetailRow-GSTlast-2').val(addCommas(set2.toFixed(2)));
      }
    });

    /*$('.gst-value').each(function(index,item){
        if(index == 0){
            if($(item).val()){
                get1 = parseFloat($(item).val().replace(/,/g, ''));
                $('#sumGST-1').val(get1);
            }
        }
        else if (index > 0) {
            if($(item).val()){
                get2 += parseFloat($(item).val().replace(/,/g, ''));
                $('#sumGST-2').val(get2);
            }
        }
    });*/

    finalCalculate();
  }

  function finalCalculate() {
    var sumAmountD = 0;
    $(".col-debit").each(function() {
      var valDtot = this.value;
      var newDtot = parseFloat(valDtot.replace(/,/g, ''));
      if (!isNaN(newDtot) && this.value.length !== 0) {
        sumAmountD += parseFloat(newDtot);
      }
    });
    var sumAmountC = 0;
    $(".col-credit").each(function() {
      var valCtot = this.value;
      var newCtot = parseFloat(valCtot.replace(/,/g, ''));
      if (!isNaN(newCtot) && this.value.length !== 0) {
        sumAmountC += parseFloat(newCtot);
      }
    });

    var amountDebt = 0;
    var amountCred = 0;

    var sumACdebit = 0;
    $(".ac-col-debit").each(function() {
      var valDtotAC = this.value;
      var newDtotAC = parseFloat(valDtotAC.replace(/,/g, ''));
      if (!isNaN(newDtotAC) && this.value.length !== 0) {
        sumACdebit += parseFloat(newDtotAC);
      }
    });

    var sumACcredit = 0;
    $(".ac-col-credit").each(function() {
      var valCtotAC = this.value;
      var newCtotAC = parseFloat(valCtotAC.replace(/,/g, ''));
      if (!isNaN(newCtotAC) && this.value.length !== 0) {
        sumACcredit += parseFloat(newCtotAC);
      }
    });
    if ($('#poTXTtypeIO').val() == "O" || $('#poTXTtypeIO').val() == "o") {
      var creGST = parseFloat($('#txtInputCreditCBdetailRow-GSTlast-2').val().replace(/,/g, ''));
      var creBank = parseFloat($('#txtInputCreditCBdetailRow-1').val().replace(/,/g, ''));
      var xxxCredit = sumAmountD - (creGST + sumACcredit + creBank);
      $('#txtInputCreditCBdetailRow-addCostRow-1').val(addCommas(xxxCredit.toFixed(2)));

      amountDebt = sumAmountD;
      amountCred = sumAmountC + sumACcredit;
    } else {
      //alert()
      var debGST = parseFloat($('#txtInputDebitCBdetailRow-GSTlast-2').val().replace(/,/g, ''));
      var debBank = parseFloat($('#txtInputDebitCBdetailRow-1').val().replace(/,/g, ''));
      var xxxDebit = sumAmountC - (debGST + sumACdebit + debBank);
      $('#txtInputDebitCBdetailRow-addCostRow-1').val(addCommas(xxxDebit.toFixed(2)));

      amountDebt = sumAmountD + sumACdebit;
      amountCred = sumAmountC;
    }

    /*amountDebt  = sumAmountD;
    amountCred  = sumAmountC;*/

    /*amountDebt  = sumAmountD + parseFloat($('#sumGST-1').val());
    amountCred  = sumAmountC + parseFloat($('#sumGST-2').val());*/
    $('#inputAmountDebit').val(addCommas(amountDebt.toFixed(2)));
    $('#inputAmountCredit').val(addCommas(amountCred.toFixed(2)));

    if (amountDebt.toFixed(2) !== amountCred.toFixed(2)) {
      $('#alert-balanceAmount').css('display', 'block');
      return false;
    } else {
      $('#alert-balanceAmount').css('display', 'none');
    }
  }

  function capitalize(s) {
    return s[0].toUpperCase() + s.substr(1);
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

  function setPulsate(elm) {
    $(elm).pulsate({
      color: "#0033FF",
      reach: 80,
      repeat: 15,
      speed: 500,
      glow: true
    });
  }

  function setToast(txtMsg) {
    $('#toast-container').stop().fadeIn(300).delay(4000).fadeOut(600);
    $('.toast-message').html(txtMsg);
  }

  function viewModalCashFlow(id) {
    $('#id-cf-this').val(id);

    $.ajax({
      url: "<?php echo base_url(); ?>/Transaction_CashBank/AjaxGetMasterCF/",
      success: function(response) {
        $("#modalCashFlow").html(response);
      },
      dataType: "html"
    });

    $("#modal-cf").modal('show');
  }

  function getCF(x) {
    function getText(el) {
      if (typeof el.textContent === 'string') return el.textContent;
      if (typeof el.innerText === 'string') return el.innerText;
    }

    $r = x.rowIndex;

    var idThisInput = document.getElementById('id-cf-this').value;
    var cfCode = getText(document.getElementById('tbl-MasterCF').rows[$r].cells[1]);
    var cfKey = getText(document.getElementById('tbl-MasterCF').rows[$r].cells[4]);

    var isLast = parseInt(getText(document.getElementById('tbl-MasterCF').rows[$r].cells[5]));
    //alert(isLast);
    if (isLast === 1) {
      document.getElementById(idThisInput).value = cfCode;
      document.getElementById(idThisInput + '-key').value = cfKey;

      $("#modal-cf").modal('hide');
    } else {
      bootbox.alert("This CF can't use!");
      return false;
    }
  }
</script>