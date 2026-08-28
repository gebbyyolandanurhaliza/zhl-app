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
    }
    (jQuery));
</script>
<!-- Index of AP Payment -->
<div class="page-content">
  <div class="container-fluid">
    <div class="row">

      <form role="form" method="post" id="form-APtrans" action="<?php echo site_url('APtrans_zht') . $_actionFrom; ?>" class="form-horizontal">
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
                <a class="btn btn-circle btn-primary" href="<?php echo site_url('APList'); ?>">
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
                          url: "<?php echo base_url(); ?>APtrans_zht/cekNumReffAP",
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
                              /*$('#form-APtrans').submit(function (){
                               return false;
                               });*/
                            } else {
                              $('#div-ReffNum').removeClass('has-error');
                              $('#div-ReffNum').addClass('has-success');
                              document.getElementById('alert-errorReff').style.display = 'none';
                              /*$('#form-APtrans').submit(function (){
                               return true;
                               });*/
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
                  <input type="hidden" id="closing" name="closing" value="<?php echo $this->session->userdata('closing_date_1'); ?>" />
                  <div class="col-sm-4">
                    <div class="form-group">
                      <label class="control-label col-sm-4">Trans Date</label>
                      <div class="col-sm-8">
                        <input id="txtInputTransDate" name="txtTransDate" type="text" class="form-control input-sm target" value="<?php //echo date('d-m-Y');   
                                                                                                                                        ?>" data-yesterday="<?php echo date('d-m-Y', mktime(0, 0, 0, date('m'), date('d') - 1, date('Y'))); ?>" data-now="<?php echo date('d-m-Y'); ?>" data-date-format="dd-mm-yyyy" style="background-color: #D2E0D1;" readonly />
                      </div>
                    </div>
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="col-sm-4">
                    <div class="form-group">
                      <label class="control-label col-sm-4">Supplier</label>
                      <div class="col-md-2">
                        <input type="text" id="txtInputSuplierID" name="txtSuplierID" class="form-control input-sm" style="background-color: #D2E0D1;" readonly />
                      </div>
                      <div class="col-md-6">
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

              </div>

              <div class="row" id="ajax-formCashBank">
                <div class="col-md-12">
                  <div class="col-sm-4">
                    <div class="form-group">
                      <label class="control-label col-sm-4">Cash Bank</label>
                      <div class="col-sm-8">
                        <input id="inputCOA" style="background-color: #D2E0D1;" type="text" name="txtCashBankCode" class="form-control input-sm back-null-inv" required />
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-8">
                    <div class="form-group">
                      <label class="control-label col-sm-2">Account Name</label>
                      <div class="col-sm-10">
                        <input id="inputCOAremark" type="text" name="txtRemarkCB" class="form-control input-sm back-null-inv" readonly />
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
                        <select class="form-control input-sm back-null-inv" name="txtCurrBayar" id="txtCUR2" style="background-color: #D2E0D1;">
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
                      <label class="control-label col-sm-4">Rate</label>
                      <div class="col-sm-8">
                        <input type="text" id="txtInputRateBank" name="txtRateBank" class="form-control input-sm txtnumRate back-null-inv" required onkeydown="return false;" onkeyup="return false;" onkeypress="return false;" />
                      </div>
                    </div>
                  </div>

                  <div class="col-sm-4">
                    <div class="form-group">
                      <label class="control-label col-sm-4">Rate SGD</label>
                      <div class="col-sm-8">
                        <input type="text" id="txtInputRateSGD" name="txtRateSGD" class="form-control input-sm txtnumRate" onblur="calculateInvoiceDetail();" required onkeydown="return false;" onkeyup="return false;" onkeypress="return false;" />
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

                  <div class="col-sm-4">
                    <div class="form-group">
                      <label class="control-label col-sm-4"></label>
                      <label class="col-sm-8">
                        <input id="chkSaveDraf" name="chkInputSaveDraf" type="checkbox">
                        <strong>Save as Draft</strong>
                      </label>
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
                        <th colspan="6">Voucher</th>
                        <th colspan="4">[<span class="txtHeadCurrency"></span>] Payment</th>
                        <th colspan="3">USD Equivalent</th>
                        <th colspan="4">Different Rate</th>
                      </tr>
                      <tr>
                        <th class="text-center" style="width: 42px;">
                          <button id="btnSelectInvoice" class="btn btn-xs btn-link baik" type="button">
                            <i class="fa fa-search"></i></button></td>
                        </th>
                        <th>No. Invoice</th>
                        <th style="width: 6%">Currency</th>
                        <th style="width: 8%">Rate</th>
                        <th style="width: 8%">Total Before</th>
                        <th style="width: 8%">Payment</th>
                        <th style="width: 8%">Rate To [<span class="txtHeadCurrency"></span>]</th>
                        <th style="width: 8%">Rate Nego</th>
                        <th style="width: 8%">[<span class="txtHeadCurrency"></span>] Total</th>
                        <th style="width: 8%">[<span class="txtHeadCurrency"></span>] Total AP</th>
                        <th style="width: 8%">Rate</th>
                        <th style="width: 8%">Total Bank</th>
                        <th style="width: 8%">Total AP</th>
                        <!-- <th style="width: 8%; display: none;">USD</th>
                                                <th style="width: 8%; display: none;">Total</th>
                                                <th style="width: 8%; display: none;">SGD</th>
                                                <th style="width: 8%; display: none;">Total</th> -->
                        <th style="width: 8%;">USD</th>
                        <th style="width: 8%;">Total</th>
                        <th style="width: 8%;">SGD</th>
                        <th style="width: 8%;">Total</th>
                      </tr>
                    </thead>
                    <tbody>
                    </tbody>
                    <tfoot>
                      <tr>
                        <td colspan="8" class="txtnum bold" style="padding-right: 10px;">Grand Total</td>
                        <td class="txtnum">
                          <input name="txtTotalPayment" id="txtInputTotalPayment" class="txt txtnumRate txt-ismo-back-null back-null-inv" readonly="true" />
                        </td>
                        <td class="txtnum">
                          <input name="txtTotalPaymentAP" id="txtInputTotalPaymentAP" class="txt txtnumRate txt-ismo-back-null back-null-inv" readonly="true" />
                        </td>
                        <td class="txtnum">
                          <input name="txtRateUSD" id="txtInputRateUSD" class="txt txtnum txt-ismo-back-null back-null-inv" readonly="true" />
                        </td>
                        <td class="txtnum">
                          <input name="txtTotalBank" id="txtInputTotalBank" class="txt txtnum txt-ismo-back-null" readonly="true" />
                        </td>
                        <td class="txtnum">
                          <input name="txtTotalAP" id="txtInputTotalAP" class="txt txtnum txt-ismo-back-null" readonly="true" />
                        </td>

                        <!-- tambahan 02-01-2018 -->

                        <!-- <td class="txtnum" style="display: none;">
                                                    <input name="txtTotalExcRateUSD" id="txtTotalExcRateUSD" class="txt txtnumRate txt-ismo-back-null back-null-inv" readonly="true"/>
                                                </td>
                                                <td class="txtnum" style="display: none;">
                                                    <input name="txtTotalExcUSD" id="txtTotalExcUSD" class="txt txtnum txt-ismo-back-null back-null-inv" readonly="true"/>
                                                </td>
                                                <td class="txtnum" style="display: none;">
                                                    <input name="txtTotalExcRateSGD" id="txtTotalExcRateSGD" class="txt txtnum txt-ismo-back-null" readonly="true"/>
                                                </td>
                                                <td class="txtnum" style="display: none;">
                                                    <input name="txtTotalExcSGD" id="txtTotalExcSGD" class="txt txtnum txt-ismo-back-null" readonly="true"/>
                                                </td> -->
                        <td class="txtnum">
                          <input name="txtTotalExcRateUSD" id="txtTotalExcRateUSD" class="txt txtnumRate txt-ismo-back-null back-null-inv" readonly="true" />
                        </td>
                        <td class="txtnum">
                          <input name="txtTotalExcUSD" id="txtTotalExcUSD" class="txt txtnum txt-ismo-back-null back-null-inv" readonly="true" />
                        </td>
                        <td class="txtnum">
                          <input name="txtTotalExcRateSGD" id="txtTotalExcRateSGD" class="txt txtnum txt-ismo-back-null" readonly="true" />
                        </td>
                        <td class="txtnum">
                          <input name="txtTotalExcSGD" id="txtTotalExcSGD" class="txt txtnum txt-ismo-back-null" readonly="true" />
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
                <span class="caption-helper">For Journal</span>
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
                    <th class="text-center" style="width: 42px;"> </th>
                    <th style="width: 10%;">Account Number</th>
                    <th style="width: 10%;">Department Code</th>
                    <th style="width: 20%;">Name</th>
                    <th style="width: 10%;">Debit</th>
                    <th style="width: 10%;">Credit</th>
                    <th style="width: 10%;">Debit[USD]</th>
                    <th style="width: 10%;">Credit[USD]</th>
                    <th>Remark</th>
                    <th style="width: 7%;">GST Name</th>
                    <th style="width: 7%;">GST Value</th>
                  </tr>
                </thead>

                <tbody>
                  <tr id="rowSetCOA">
                    <td class="text-center" style="vertical-align: middle;">
                      <button class="btn btn-xs btn-link biasa" type="button">
                        <i class="fa fa-arrow-down"></i></button>
                    </td>
                    <td nowrap><input type="text" name="txtNoCOA[]" id="txtInputCOAsuppRow-1" class="txt" value="" readonly /></td>
                    <td nowrap><input type="text" name="txtDeptCode[]" id="txtDeptCodeRow-1" class="txt" value="" readonly /></td>
                    <td nowrap><input type="text" name="txtNameCOA[]" id="txtInputNameSuppRow-1" class="txt" value="" readonly /></td>
                    <td nowrap><input type="text" name="txtDebit[]" id="txtInputDebitCBdetailRow-1" onKeyup="checkGST(); convertToUSD();" onblur="checkGST(); convertToUSD();" class="col-debit col-deb txt txtnum" value="0.00" /></td>
                    <td nowrap><input type="text" name="txtCredit[]" id="txtInputCreditCBdetailRow-1" onKeyup="checkGST(); convertToUSD();" onblur="checkGST(); convertToUSD();" class="col-credit col-cre txt txtnum" value="0.00" /></td>

                    <td nowrap><input type="text" name="txtDebitUSD[]" id="txtInputDebitCBdetailRow-1-USD" class="col-debit-usd txt txtnum" /></td>
                    <td nowrap><input type="text" name="txtCreditUSD[]" id="txtInputCreditCBdetailRow-1-USD" class="col-credit-usd txt txtnum" /></td>
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
                    <td nowrap id="txtDeptCodeRow-2"><input type="text" class="txt" value="" readonly /></td>
                    <td nowrap><input id="txtInputNameSuppRow-2" type="text" name="txtNameCOA[]" class="txt" value="" readonly required="" /></td>
                    <td nowrap><input id="txtInputDebitRow-2" type="text" name="txtDebit[]" onKeyup=" checkGST(); convertToUSD();" onblur="checkGST(); convertToUSD();" class="col-debit col-deb txt txtnum" value="0.00" /></td>
                    <td nowrap><input id="txtInputCreditRow-2" type="text" name="txtCredit[]" onKeyup=" checkGST(); convertToUSD();" onblur="checkGST(); convertToUSD();" class="col-credit col-cre txt txtnum" value="0.00" /></td>
                    <td nowrap><input type="text" name="txtDebitUSD[]" id="txtInputDebitCBdetailRow-2-USD" class="col-debit-usd txt txtnum" /></td>
                    <td nowrap><input type="text" name="txtCreditUSD[]" id="txtInputCreditCBdetailRow-2-USD" class="col-credit-usd txt txtnum" /></td>
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
                  <tr id="thridhRowCashGeneral">
                    <td id="rowSelectCOArow2" class="text-center" style="vertical-align: middle;">
                      <button id="btnSelectCOArow3" class="btn btn-xs btn-link biasa" type="button">
                        <i class="fa fa-arrow-right"></i></button>
                    </td>
                    <td nowrap><input id="txtInputCOAsuppRow-3" type="text" name="txtNoCOA[]" class="txt" value="700043" readonly required="" /></td>
                    <td nowrap><input type="text" name="txtDeptCode[]" id="txtInputDeptCodeRow-3" readonly class="col-dept col-dept txt txtdept" value="005" /></td>
                    <td nowrap><input id="txtInputNameSuppRow-3" type="text" name="txtNameCOA[]" class="txt" value="Exchange Rate" readonly required="" /></td>
                    <td nowrap><input id="txtInputDebitRow-3" type="text" name="txtDebit[]" onKeyup=" checkGST();" class="col-debit col-deb txt txtnum" readonly value="0.00" /></td>
                    <td nowrap><input id="txtInputCreditRow-3" type="text" name="txtCredit[]" onKeyup=" checkGST();" class="col-credit col-cre txt txtnum" readonly value="0.00" /></td>

                    <td nowrap><input type="text" name="txtDebitUSD[]" id="txtInputDebitCBdetailRow-3-USD" class="col-debit-usd txt txtnum" /></td>
                    <td nowrap><input type="text" name="txtCreditUSD[]" id="txtInputCreditCBdetailRow-3-USD" class="col-credit-usd txt txtnum" /></td>
                    <td nowrap><input type="text" name="txtRemark[]" class="txt" /></td>
                    <td nowrap>
                      <select name="txtGST[]" class="txt gst-name display-none" onchange="checkGST()">
                        <option value=""> -- Select --</option>
                        <?php foreach ($_selectGST as $gst) : ?>
                          <option value="<?php echo $gst->gst_id; ?>"> <?php echo $gst->gst_name; ?></option>
                        <?php endforeach; ?>
                      </select>
                    </td>
                    <td nowrap><input type="text" id="txtInputGSTvalue3th" name="txtGSTvalue[]" class="txt txtnum gst-value  display-none" /></td>
                  </tr>
                </tbody>

                <!--<tfoot id="detailRowForAddCost"> </tfoot>-->

                <tfoot id="detailRowForAddCost">
                  <tr id="rowGSTlast-1">
                    <td class="text-center" style="vertical-align: middle;">
                      <button class="btn btn-xs btn-link biasa" type="button">
                        <i class="fa fa-arrow-up"></i></button>
                    </td>
                    <td nowrap><input type="text" name="txtNoCOA[]" id="txtInputCOAsuppRow-GSTlast-1" class="txt" value="" readonly /></td>
                    <td nowrap><input type="text" name="txtDeptCode[]" id="txtInputDeptCodeRow-GSTlast-1" readonly class="col-dept col-dept txt txtdept" value="000" /></td>
                    <td nowrap><input type="text" name="txtNameCOA[]" id="txtInputNameSuppRow-GSTlast-1" class="txt" value="" readonly /></td>
                    <td nowrap><input type="text" name="txtDebit[]" id="txtInputDebitCBdetailRow-GSTlast-1" readonly class="col-debit col-deb txt txtnum" value="0.00" /></td>
                    <td nowrap><input type="text" name="txtCredit[]" id="txtInputCreditCBdetailRow-GSTlast-1" readonly class="col-credit col-cre txt txtnum" value="0.00" /></td>

                    <td nowrap><input type="text" name="txtDebitUSD[]" id="txtInputDebitCBdetailRow-1-GSTlastUSD" class="col-debit-usd txt txtnum" /></td>
                    <td nowrap><input type="text" name="txtCreditUSD[]" id="txtInputCreditCBdetailRow-1-GSTlastUSD" class="col-credit-usd txt txtnum" /></td>
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

                  <tr id="addCostRow1">
                    <td class="text-center" style="vertical-align: middle;">
                      <button class="btn btn-xs btn-link biasa" type="button">
                        <i class="fa fa-arrow-up"></i></button>
                    </td>
                    <td nowrap><input type="text" name="txtNoCOA[]" id="txtInputCOAsuppRow-addCostRow-1" class="txt" value="700011" readonly /></td>
                    <td nowrap>
                    <input type="text" name="txtDeptCode[]" id="txtInputDeptCodeRow-addCostRow-1" class="txt" value="005" readonly />
                    </td>
                    <td nowrap><input type="text" name="txtNameCOA[]" id="txtInputNameSuppRow-addCostRow-1" class="txt" value="Bank Charges" readonly /></td>
                    <td nowrap><input type="text" name="txtDebit[]" id="txtInputDebitCBdetailRow-addCostRow-1" class="col-deb txt txtnum" value="0.00" /></td>
                    <td nowrap><input type="text" name="txtCredit[]" id="txtInputCreditCBdetailRow-addCostRow-1" class="col-credit col-cre txt txtnum" value="0.00" /></td>

                    <td nowrap><input type="text" name="txtDebitUSD[]" id="txtInputDebitCBdetailRow-1-addCostRowUSD" class="col-debit-usd txt txtnum" /></td>
                    <td nowrap><input type="text" name="txtCreditUSD[]" id="txtInputCreditCBdetailRow-1-addCostRowUSD" class="col-credit-usd txt txtnum" /></td>
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
                </tfoot>

              </table>
            </div>

            <!-- tambahan 02/01/2018 -->
            <div class="portlet-body table-responsive">

            </div>

            <div class="portlet-body">
              <div class="row">
                <div class="col-sm-6">
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
                </div>

                <div class="col-sm-6">
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label class="col-sm-12 text-right" for="">Amount Debit [USD]</label>
                      <div class="col-sm-12">
                        <input class="form-control" name="txtAmountDebitUSD" id="inputAmountDebitUSD" type="text" readonly="" />
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label class="col-sm-12 text-right" for="">Amount Credit [USD]</label>
                      <div class="col-sm-12">
                        <input class="form-control" name="txtAmountCreditUSD" id="inputAmountCreditUSD" type="text" readonly="" />
                      </div>
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
            <div class="portlet-body form">
              <div class="row">

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
                      <button class="btn btn-sm btn-success" name="btnSubmit" onclick="checkEqual();" type="submit">Submit</button>
                      <button class="btn btn-sm btn-warning" id="btnCancel" name="btnCancel" type="button">Cancel</button>
                    </div>
                  </div>
                  <script>
                    function checkEqual() {
                      var a = document.getElementById('inputAmountDebit').value;
                      var b = document.getElementById('inputAmountCredit').value;

                      if (a !== b) {
                        document.getElementById('alert-balanceAmount').style.display = 'block';
                        return false;
                      } else {
                        document.getElementById('alert-balanceAmount').style.display = 'none';
                      }
                    }
                  </script>
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
<!-- Select Supplier -->
<div class="modal fade" id="modal-select-supplier" tabindex="-1" role="basic" aria-hidden="true">
  <div class="modal-dialog" style="width: 50%;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title">Select Supplier</h4>
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
<!-- Select AP -->
<div class="modal fade" id="modal-ap" tabindex="-1" role="basic" aria-hidden="true">
  <div class="modal-dialog" style="width: 75%;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title">Select A/P From Accounting</h4>
      </div>
      <div class="modal-body">
        <div id="contentAPlist"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- Select COA -->
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
<!-- Find Recorded AP Payment Transaction Modal -->
<div class="modal fade" id="modal-findAP" tabindex="-1" role="basic" aria-hidden="true">
  <div class="modal-dialog" style="width: 75%;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title">Select AP Payment</h4>
      </div>
      <div class="modal-body">
        <div id="contentFindAP"></div>
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
<!-- Select CF -->
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


    var tgl = $('#closing').val();

    $('.target').datepicker({
      'autoclose': true,
      'todayHighlight': !0,
      'startDate': tgl,
      'orientation': "top right",
      'format': ('dd-mm-yyyy')
      // var today = picker.startDate.format('DD/MM/YYYY');
    });
  })
</script>
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

    //============= Auto Num Reff===============
    // // APtrans_zht/newGenerateReffNumber
    $('#txtInputTransDate, #txtCUR2, #txtInputRateSGD').on('change blur', function() {
      if ($('#txtInputTransDate').val() && $('#txtInputRateSGD').val() && $('#txtCUR2').val()) {
        setInterval(function() {
          $.get("<?php echo base_url(); ?>APtrans_zht/newGenerateReffNumber2", {
            txtTypeForGen: 'OUT',
            txtCurrForGen: $('#txtCUR2').val(),
            txtDateForGen: $('#txtInputTransDate').val()
          }, function(data, statuss) {
            $('#inputNoReff').val(data);
          });
        }, 2000);
      }
    });

    //====================================================================================================
    $('#txtInputGSTvalue2nd').removeClass('gst-value-credit');
    $('#txtInputGSTvalue2nd').addClass('gst-value-debit');
    $('#txtInputGSTvalue1st').removeClass('gst-value-debit');
    $('#txtInputGSTvalue1st').addClass('gst-value-credit');
    //==============GST=========
    $('#txtInputCOAsuppRow-GSTlast-1').val('300106');
    $('#txtInputNameSuppRow-GSTlast-1').val('GST Input Tax');

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
    //====================================================================================================

    $('#chkSaveDraf').on('click', function() {
      if ($(this).prop('checked')) {
        bootbox.alert('You will save the data to the draft!');
        $('#txtInputCheckBank').prop("readonly", true);
        $('#txtInputCheckBank').prop("required", false);
        $("#form-APtrans").attr('action', '<?php echo site_url(); ?>APtrans_zht/insertAPpaymentToDraf');
      } else {
        //alert('Not Save Draf');
        $('#txtInputCheckBank').prop("readonly", false);
        $('#txtInputCheckBank').prop("required", true);
        $("#form-APtrans").attr('action', '<?php echo site_url(); ?>APtrans_zht/insertAPpayment');
      }
    });

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
      var val1 = new Date(val);
      var now2 = new Date(now);

      var parts = val.split('-');
      var val2 = new Date(parts[2], parts[1] - 1, parts[0]);

      var parts2 = now.split('-');
      var now21 = new Date(parts2[2], parts2[1] - 1, parts2[0]);

      // var datediff = val2.getTime() - now21.getTime();

      if (val2.getTime() > now21.getTime()) {
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
        url: "<?php echo site_url('APtrans_zht/generateReffNumAP'); ?>",
        dataType: 'json',
        success: function(gen) {
          $('#inputNoReff').val(gen);
          $('#inputNoReff').focus();
          //$('#inputNoReff').attr('readonly', true);
        }
      });
    });

    $("#inputCOA").click(function() {
      if ($('#inputTotalVoucher').val() === '') {
        bootbox.alert('the First Choice Invoice in below!');
      } else {
        $.ajax({
          url: "<?php echo site_url('APtrans_zht/selectCOA'); ?>",
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

    //Calculate Detail AP
    $("#btnCalculateDetail").click(function() {
      //CountPayTotal();
      var inUSD = parseFloat($('#inputUSDRow1').val().replace(/,/g, ''));
      var rate1st = parseFloat($('#rateToCurr').val().replace(/,/g, ''));
      var rate2nd = parseFloat($('#txtInputRateNego').val().replace(/,/g, ''));
      var d = parseFloat($('#txtInputDebitRow-2').val().replace(/,/g, ''));
      var hutang = 0;
      $('#txtInputDebitRow-3').val('0.00');
      $('#txtInputCreditRow-3').val('0.00');

      var inByCurr1st = inUSD / rate1st;
      var inByCurr2nd = inUSD / rate2nd;
      var selisih = inByCurr2nd.toFixed(2) - inByCurr1st.toFixed(2);

      if (selisih < 0) {
        exchRate = selisih * (-1);
        hutang = d + exchRate;
        $('#txtInputDebitRow-3').val(addCommas(exchRate.toFixed(2)));
        $('#txtInputCreditCBdetailRow-1').val(addCommas(hutang.toFixed(2)));
      } else {
        exchRate = selisih;
        hutang = d - exchRate;
        $('#txtInputCreditRow-3').val(addCommas(exchRate.toFixed(2)));
        $('#txtInputCreditCBdetailRow-1').val(addCommas(hutang.toFixed(2)));
      }
      checkGST();
      $('#txtInputCreditCBdetailRow-1').focus();

      $('#inputToCurr1').val(addCommas(inByCurr1st.toFixed(2)));
      $('#inputToCurr2').val(addCommas(selisih.toFixed(2)));
      $('#inputToCurr3').val(addCommas(inByCurr2nd.toFixed(2)));

      $('#inputUSDRow3').val($('#inputUSDRow1').val());
      $('#inputAmountRow3').val($('#inputAmountRow1').val());

      $('#tbl-payment tbody').removeClass('display-none');

      convertToUSD();
    });

    //select CURRENCY
    $("#selInputCurrencyVoucher").change(function() {
      var valCUR = $(this).val();

      $('#inCurFirstRow').val(valCUR);

      if ($('#modal-invoice').hasClass('has-ismo-modal')) {
        $('#modal-invoice').removeClass('has-ismo-modal');
      }
    });
    //select SUPPLIER
    $("#txtInputSuplierID, #txtInputSuplierName").click(function() {
      var txtTglTrn = $('#txtInputTransDate').val();
      if (!txtTglTrn) {
        bootbox.alert('Input First Date Transaction!');
      } else {
        $.ajax({
          url: "<?php echo site_url('APtrans_zht/selectSupplierForAP'); ?>",
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
      if (inSuppID === '') {
        bootbox.alert('First input Field Customer!');
      } else {
        if ($('#modal-invoice').hasClass('has-ismo-modal')) {
          $('#modal-invoice').modal('show');
          $('#tbl-payment tbody').addClass('display-none');
        } else {
          var inSuppID = $('#txtInputSuplierID').val();
          var inTransD = $('#txtInputTransDate').val();
          var a = "<?php echo site_url('APtrans_zht/selectInvoiceForAP'); ?>";

          console.log(inSuppID);
          console.log(inTransD);
          console.log(a);
          $.ajax({
            url: "<?php echo site_url('APtrans_zht/selectInvoiceForAP'); ?>",
            type: "GET",
            data: {
              incSupplierID: inSuppID,
              incTransDate: inTransD
            },
            datatype: "json",
            cache: true,
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
      $.post("<?php echo site_url(); ?>APtrans_zht/selectAPpayment", function(data) {
        $('#contentFindAP').html(data);
      });
      $('#modal-findAP').modal('show');
    });

    $("#form-APtrans").submit(function(e) {
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
         bootbox.alert('Saldo Kosong');
         }else if(respon == 'error02'){
         bootbox.alert('Saldo Kurang');
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
    $('#txtInputSuplierRemark').val('Debt Payment for ' + getText(document.getElementById('tbl-selectSupplier').rows[$r].cells[1]));

    //== set Value Detail
    $('#txtInputRemarkDetail').val(getText(document.getElementById('tbl-selectSupplier').rows[$r].cells[1]));
    $('#txtCOADetailRow1').val(getText(document.getElementById('tbl-selectSupplier').rows[$r].cells[3]));

    //================== Bank
    $('#txtInputCOAsuppRow-2').val(getText(document.getElementById('tbl-selectSupplier').rows[$r].cells[3]));
    $('#txtInputNameSuppRow-2').val(getText(document.getElementById('tbl-selectSupplier').rows[$r].cells[1]));

    
    var coaDetail2 = $('#txtInputCOAsuppRow-2').val();

    var listCoa = <?php echo json_encode($List_coa); ?>;
    if (coaDetail2) {
      const list = listCoa.find(element => element.NoCOA === coaDetail2);
      const DeptCode = $('#txtDeptCodeRow-2');

      if (list) {
        DeptCode.html(`
            <input name="txtDeptCode[]" type="text" class="txt" value="${list.kode_department}" readonly required />
        `);
      } else {
        DeptCode.html(`
            <input name="txtDeptCode[]" type="text" class="txt" value="000" readonly required />
        `);
      }
    } else {
        console.error("COA Detail tidak ditemukan. Pastikan input telah diisi.");
    }

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
    var rateUSD = $('#txtInputRateBank').val();
    var noInv = getText(document.getElementById('tbl-selectInvoice').rows[rr].cells[1]);
    var currInv = getText(document.getElementById('tbl-selectInvoice').rows[rr].cells[2]).replace(/,/g, '');
    var rateInv = getText(document.getElementById('tbl-selectInvoice').rows[rr].cells[3]).replace(/,/g, '');
    var totBef = getText(document.getElementById('tbl-selectInvoice').rows[rr].cells[5]).replace(/,/g, '');
    var cls = getText(document.getElementById('tbl-selectInvoice').rows[rr].cells[7]);
    var jenis = getText(document.getElementById('tbl-selectInvoice').rows[rr].cells[9]);
    var totexcRtUSD = getText(document.getElementById('tbl-selectInvoice').rows[rr].cells[11]).replace(/,/g, '');
    // var  totexcRtUSD = 1;
    // var totexcRtSGD = 0.1;
    var totexcRtSGD = getText(document.getElementById('tbl-selectInvoice').rows[rr].cells[12]).replace(/,/g, '');
    // alert(totexcRtUSD);
    var ratePay = Number(rateInv).toFixed(6) / Number(rateUSD).toFixed(6);
    var totPay = Number(ratePay).toFixed(6) * Number(totBef).toFixed(2);

    var totAP = Number(rateInv).toFixed(6) * Number(totBef).toFixed(2);
    var totBank = Number(rateUSD).toFixed(6) * Number(totPay).toFixed(2);
    var totexcUSD = Number(totexcRtUSD).toFixed(6) * Number(totBef).toFixed(2);
    var totexcSGD = Number(totexcRtSGD).toFixed(6) * Number(totBef).toFixed(2);
    // alert(totexcUSD);

    $('#tbl-detail-invoice tbody').append('<tr class="' + cls + ' added-row-ismo">\n\
            <td class="text-center"><button class="btn btn-xs btn-link buruk" onclick="deleteInvoice(this);" type="button">\n\
                <i class="fa fa-trash-o"></i></button></td>\n\
            <td><input value="' + noInv + '" name="txtNewNoInvoiceDtl[]" class="txt" readonly/></td>\n\
            <td><input value="' + currInv + '" name="txtNewCurrDtl[]" class="txt" readonly/></td>\n\
            <td><input value="' + Number(rateInv).toFixed(6) + '" name="txtNewRateInvDtl[]" class="txt txtnum" readonly/></td>\n\
            <td><input value="' + addCommas(Number(totBef).toFixed(2)) + '" name="txtNewTotBefDtl[]" class="txt txtnum" readonly/></td>\n\
            <td><input value="' + addCommas(Number(totBef).toFixed(2)) + '" data-max="' + Number(totBef).toFixed(2) + '" name="txtNewPayDtl[]" onkeyup="calculateInvoiceDetail(); CheckMaxValue(this);" onblur="calculateInvoiceDetail();" class="txt val-total-refore txtnum ' + cls + '-pay"/></td>\n\
            <td><input value="' + Number(ratePay).toFixed(6) + '" name="txtNewRateToPayDtl[]" class="txt val-rate txtnum" readonly/></td>\n\
            <td><input value="' + Number(ratePay).toFixed(6) + '" name="txtNewRateNegoToPayDtl[]" onkeyup="calculateInvoiceDetail();" onblur="calculateInvoiceDetail();" class="txt val-rate-nego txtnum ' + cls + '-nego"/></td>\n\
            <td><input value="' + addCommas(Number(totPay).toFixed(2)) + '" name="txtNewTotalPayDtl[]" class="txt val-total-pay txtnum" readonly/></td>\n\
            <td><input value="' + addCommas(Number(totPay).toFixed(2)) + '" name="txtNewTotalPayDtlAP[]" class="txt val-total-pay-ap txtnum" readonly/></td>\n\
            <td><input value="' + Number(rateUSD).toFixed(6) + '" name="txtRateUSDdtl[]" class="txt txtnum" readonly/></td>\n\
            <td><input value="' + addCommas(Number(totBank).toFixed(2)) + '" name="txtTotalBankDtl[]" class="txt val-total-bank txtnum" readonly/></td>\n\
            <td><input value="' + addCommas(Number(totAP).toFixed(2)) + '" name="txtTotalApDtl[]" class="txt val-total-ap txtnum" readonly/></td>\n\
            <td style="display: none;"><input value="' + jenis + '" name="txtjenis[]" class="txt"/></td>\n\
            <td><input value="' + addCommas(Number(totexcRtUSD).toFixed(6)) + '" name="totexcRtUSD[]" class="txt totexcRtUSD txtnum" readonly/></td>\n\
            <td><input value="' + addCommas(Number(totexcUSD).toFixed(2)) + '" name="totexcUSD[]" class="txt totexcUSD txtnum" readonly/></td>\n\
            <td><input value="' + addCommas(Number(totexcRtSGD).toFixed(6)) + '" name="totexcRtSGD[]" class="txt totexcRtSGD txtnum" readonly/></td>\n\
            <td><input value="' + addCommas(Number(totexcSGD).toFixed(2)) + '" name="totexcSGD[]" class="txt totexcSGD txtnum" readonly/></td>\n\
        </tr>');

    calculateInvoiceDetail();
    checkGST();

    $(function() {
      $('.txtnum').numericInput({
        allowFloat: true,
        allowNegative: true
      });
      $('.' + cls + '-pay').on('blur', function() {
        var val = parseFloat($(this).val().replace(/,/g, ''));
        if (!val) {
          var vall = 0;
        } else {
          vall = val;
        }
        checkGST();
        $(this).val(addCommas(vall.toFixed(2)));
        $('#tbl-payment tbody').addClass('display-none');
      });
      $('.' + cls + '-nego').on('blur', function() {
        var val = parseFloat($(this).val().replace(/,/g, ''));
        if (!val) {
          var vall = 0;
        } else {
          vall = val;
        }
        checkGST();
        $(this).val(addCommas(vall.toFixed(6)));
        $('#tbl-payment tbody').addClass('display-none');
      });
    });
  }

  function deleteInvoice(x) {
    //e.preventDefault();
    $(x).parents('tr').remove();

    calculateInvoiceDetail();
    $('#tbl-payment tbody').addClass('display-none');
    convertToUSD()
  }

  function calculateInvoiceDetail() {
    var valTotBef = document.getElementsByClassName('val-total-refore');
    var valRate = document.getElementsByClassName('val-rate');
    var valRateNego = document.getElementsByClassName('val-rate-nego');
    var valTotPay = document.getElementsByClassName('val-total-pay');
    var valTotBank = document.getElementsByClassName('val-total-bank');
    var valTotPayAP = document.getElementsByClassName('val-total-pay-ap');
    var valTotBankAP = document.getElementsByClassName('val-total-ap');
    var totexcSGD = document.getElementsByClassName('totexcSGD');
    var totexcUSD = document.getElementsByClassName('totexcUSD');
    var totexcRtUSD = document.getElementsByClassName('totexcRtUSD');
    var totexcRtSGD = document.getElementsByClassName('totexcRtSGD');
    var valRateUSD = parseFloat($('#txtInputRateBank').val().replace(/,/g, ''));

    for (var i = 0; i < valTotBef.length; i++) {
      var totPay = Number(valRateNego[i].value.replace(/,/g, '')).toFixed(6) * Number(valTotBef[i].value.replace(/,/g, '')).toFixed(2);
      var totUSD = Number(valRateUSD).toFixed(6) * Number(totPay).toFixed(2);

      valTotPay[i].value = addCommas(totPay.toFixed(2));
      valTotBank[i].value = addCommas(totUSD.toFixed(2));

      var totPayap = Number(valRate[i].value.replace(/,/g, '')).toFixed(6) * Number(valTotBef[i].value.replace(/,/g, '')).toFixed(2);
      var totUSDap = Number(valRateUSD).toFixed(6) * Number(totPayap).toFixed(2);

      valTotPayAP[i].value = addCommas(totPayap.toFixed(2));
      valTotBankAP[i].value = addCommas(totUSDap.toFixed(2));

      var totusdexc = Number(valTotBef[i].value.replace(/,/g, '')).toFixed(2) * Number(totexcRtUSD[i].value.replace(/,/g, '')).toFixed(6);
      var totsgdexc = Number(valTotBef[i].value.replace(/,/g, '')).toFixed(2) * Number(totexcRtSGD[i].value.replace(/,/g, '')).toFixed(6);
      totexcUSD[i].value = addCommas(totusdexc.toFixed(2));
      totexcSGD[i].value = addCommas(totsgdexc.toFixed(2));
    }


    var grandPay = 0;
    $(".val-total-pay").each(function() {
      var valPayTotal = this.value;
      var newPayTotal = parseFloat(valPayTotal.replace(/,/g, ''));
      if (!isNaN(newPayTotal) && this.value.length !== 0) {
        grandPay += parseFloat(newPayTotal);
      }
    });
    $('#txtInputTotalPayment').val(addCommas(grandPay.toFixed(2)));

    var totalAP = 0;
    $(".val-total-pay-ap").each(function() {
      var valApTotal = this.value;
      var newApTotal = parseFloat(valApTotal.replace(/,/g, ''));
      if (!isNaN(newApTotal) && this.value.length !== 0) {
        totalAP += parseFloat(newApTotal);
      }
    });
    $('#txtInputTotalPaymentAP').val(addCommas(totalAP.toFixed(2)));

    var grandBank = 0;
    $(".val-total-bank").each(function() {
      var valBankTotal = this.value;
      var newBankTotal = parseFloat(valBankTotal.replace(/,/g, ''));
      if (!isNaN(newBankTotal) && this.value.length !== 0) {
        grandBank += parseFloat(newBankTotal);
      }
    });
    $('#txtInputTotalBank').val(addCommas(grandBank.toFixed(2)));

    var grandAP = 0;
    $(".val-total-ap").each(function() {
      var valApTotal = this.value;
      var newApTotal = parseFloat(valApTotal.replace(/,/g, ''));
      if (!isNaN(newApTotal) && this.value.length !== 0) {
        grandAP += parseFloat(newApTotal);
      }
    });
    $('#txtInputTotalAP').val(addCommas(grandAP.toFixed(2)));

    // --- tambahan 02-01-2017 ---
    var grandExcRtUsd = 0;
    $(".totexcRtUSD").each(function() {
      var valExcRtUSD = this.value;
      var newGrandExcRtUSD = parseFloat(valExcRtUSD.replace(/,/g, ''));
      if (!isNaN(newGrandExcRtUSD) && this.value.length !== 0) {
        grandExcRtUsd += parseFloat(newGrandExcRtUSD);
      }
    });

    var grandPayusd = 0;
    var rtusd20 = 0;
    var rtsgd20 = 0;
    for (var i = 0; i < totexcRtUSD.length; i++) {
      var newpay = parseFloat(valTotPay[i].value.replace(/,/g, ''));
      if (totexcRtUSD[i].value != 0 || totexcSGD[i].value != 0) {
        rtusd20 += parseFloat(newpay * totexcRtUSD[i].value);
        rtsgd20 += parseFloat(newpay * totexcSGD[i].value);
        grandPayusd += parseFloat(newpay);
      }
    }

    var grandExcRtSGD = 0;
    $(".totexcRtSGD").each(function() {
      var valExcRtSGD = this.value;
      var newGrandExcRtSGD = parseFloat(valExcRtSGD.replace(/,/g, ''));
      if (!isNaN(newGrandExcRtSGD) && this.value.length !== 0) {
        grandExcRtSGD += parseFloat(newGrandExcRtSGD);
      }
    });



    var grandExcUsd = 0;
    $(".totexcUSD").each(function() {
      var valExcUSD = this.value;
      var newGrandExcUSD = parseFloat(valExcUSD.replace(/,/g, ''));
      if (!isNaN(newGrandExcUSD) && this.value.length !== 0) {
        grandExcUsd += parseFloat(newGrandExcUSD);
      }
    });

    $('#txtTotalExcUSD').val(addCommas(grandExcUsd.toFixed(2)));

    var grandExcSGD = 0;
    $(".totexcSGD").each(function() {
      var valExcSGD = this.value;
      var newGrandExcSGD = parseFloat(valExcSGD.replace(/,/g, ''));
      if (!isNaN(newGrandExcSGD) && this.value.length !== 0) {
        grandExcSGD += parseFloat(newGrandExcSGD);
      }
    });

    var rtusd = 0;
    // alert(grandExcUsd);
    // alert(grandExcRtUsd);
    // alert(grandPayusd);
    if (rtusd20 != 0) {
      rtusd = rtusd20 / grandPayusd;
    }
    var rtsgd = 0;
    if (rtsgd20 != 0) {
      rtsgd = rtsgd20 / grandPayusd;
    }

    $('#txtTotalExcSGD').val(addCommas(grandExcSGD.toFixed(2)));

    $('#txtTotalExcRateUSD').val(addCommas(rtusd.toFixed(6)));
    $('#txtTotalExcRateSGD').val(addCommas(rtsgd.toFixed(6)));
    //============== end ============



    //##== for Journal
    var exRate = Number(grandPay.toFixed(2)) - Number(totalAP.toFixed(2));

    if (totalAP < 0) {
      $('#txtInputDebitCBdetailRow-1').val(addCommas(Number(Math.abs(grandPay)).toFixed(2)));
      $('#txtInputCreditCBdetailRow-1').val("0.00");
      $('#txtInputDebitRow-2').val("0.00");
      $('#txtInputCreditRow-2').val(addCommas(Number(Math.abs(totalAP)).toFixed(2)));
    } else {
      $('#txtInputDebitCBdetailRow-1').val("0.00");
      $('#txtInputCreditCBdetailRow-1').val(addCommas(Number(grandPay).toFixed(2)));
      $('#txtInputDebitRow-2').val(addCommas(Number(totalAP).toFixed(2)));
      $('#txtInputCreditRow-2').val("0.00");
    }

    var valExR = Number(exRate).toFixed(2);
    if (exRate >= 0) {
      $('#txtInputDebitRow-3').val(addCommas(Number(exRate).toFixed(2)));
      $('#txtInputCreditRow-3').val(addCommas(Number('00').toFixed(2)));
    } else {
      $('#txtInputDebitRow-3').val(addCommas(Number('00').toFixed(2)));
      $('#txtInputCreditRow-3').val(addCommas(Number(valExR.replace(/-/g, ''))));
    }
  }

  function CheckMaxValue(obj) {
    var value = obj.value.replace(/,/g, '');
    var maxVal = obj.getAttribute('data-max').replace(/,/g, '');
    //alert('value:'+value+' - - max:'+max);
    if (parseFloat(maxVal) > 0) {
      if (parseFloat(value) > parseFloat(maxVal)) {
        bootbox.alert("Value should not be more than " + maxVal);
        $(obj).val(addCommas(parseFloat(maxVal).toFixed(2)));

        calculateInvoiceDetail();
      } else if (parseFloat(value) < 0) {
        bootbox.alert("Value should not be more than 0");
        $(obj).val(addCommas(parseFloat(maxVal).toFixed(2)));

        calculateInvoiceDetail();
      }
    } else {
      if (parseFloat(value) < parseFloat(maxVal)) {
        bootbox.alert("Value should not be more than " + maxVal);
        $(obj).val(addCommas(parseFloat(maxVal).toFixed(2)));

        calculateInvoiceDetail();
      } else if (parseFloat(value) > 0) {
        bootbox.alert("Value should not be more than 0");
        $(obj).val(addCommas(parseFloat(maxVal).toFixed(2)));

        calculateInvoiceDetail();
      }
    }
  }

  // ==## Convert to USD ##== //
  function convertToUSD() {
    var rateUSD = 0.00;
    if ($('#selInputCurrencyVoucher').val() == 'USD') {
      rateUSD = parseFloat($('#txtInputRateBank').val().replace(/,/g, ''));
    } else {
      rateUSD = parseFloat($('#txtInputRateBank').val().replace(/,/g, ''));
    }

    var r_debt = document.getElementsByClassName('col-deb');
    var i_debt = document.getElementsByClassName('col-debit-usd');
    var t_debt = 0;
    for (var i = 0; i < r_debt.length; i++) {
      var rr_deb = r_debt[i].value.replace(/,/g, '');
      var result = rr_deb * rateUSD;
      i_debt[i].value = addCommas(result.toFixed(2));

      t_debt += parseFloat(result.toFixed(2));
    }
    $('#inputAmountDebitUSD').val(addCommas(t_debt.toFixed(2)));

    var r_cret = document.getElementsByClassName('col-cre');
    var i_cret = document.getElementsByClassName('col-credit-usd');
    var t_cret = 0;
    for (var x = 0; x < r_cret.length; x++) {
      var rr_cre = r_cret[x].value.replace(/,/g, '');
      var result = rr_cre * rateUSD;
      i_cret[x].value = addCommas(result.toFixed(2));

      t_cret += parseFloat(result.toFixed(2));
    }
    $('#inputAmountCreditUSD').val(addCommas(t_cret.toFixed(2)));

    exRate();
  }

  // ==== function exRate ======
  function exRate() {
    var sgd_debt = document.getElementsByClassName('col-deb');
    var usd_debt = document.getElementsByClassName('col-debit-usd');
    var sgd_cret = document.getElementsByClassName('col-cre');
    var usd_cret = document.getElementsByClassName('col-credit-usd');
    var excUSD = document.getElementById('txtTotalExcUSD').value.replace(/,/g, '');
    var excSGD = document.getElementById('txtTotalExcSGD').value.replace(/,/g, '');

    var totalhutsgd = (sgd_debt[1].value.replace(/,/g, '')) - (sgd_cret[1].value.replace(/,/g, ''));
    var totalhutusd = (usd_debt[1].value.replace(/,/g, '')) - (usd_cret[1].value.replace(/,/g, ''));
    var excratesgd = (sgd_debt[2].value.replace(/,/g, '')) - (sgd_cret[2].value.replace(/,/g, ''));
    var excrateusd = (usd_debt[2].value.replace(/,/g, '')) - (usd_cret[2].value.replace(/,/g, ''));
    // alert(excratesgd);


    var mewtotalhutusd = parseFloat(totalhutusd) - parseFloat(excUSD);
    var newexcRateusd = parseFloat(excrateusd) + parseFloat(excUSD);

    var mewtotalhutsgd = parseFloat(totalhutsgd) - parseFloat(excSGD);
    var newexcRatesgd = parseFloat(excratesgd) + parseFloat(excSGD);

    if (mewtotalhutsgd > 0) {
      // sgd_debt[1].value = addCommas(Number(Math.abs(mewtotalhutsgd.toFixed(2))));
      sgd_debt[1].value = number_format(Math.abs(mewtotalhutsgd), 2);
      sgd_cret[1].value = "0.00";
    } else {
      sgd_cret[1].value = number_format(Math.abs(mewtotalhutsgd), 2); //addCommas(Number(Math.abs(mewtotalhutsgd.toFixed(2))));
      sgd_debt[1].value = "0.00";
    }

    if (mewtotalhutusd > 0) {
      usd_debt[1].value = number_format(Math.abs(mewtotalhutusd), 2); //addCommas(Number(Math.abs(mewtotalhutusd.toFixed(2))));
      usd_cret[1].value = "0.00";
    } else {

      usd_cret[1].value = number_format(Math.abs(mewtotalhutusd), 2); //addCommas(Number(Math.abs(mewtotalhutusd.toFixed(2))));
      usd_debt[1].value = "0.00";
    }

    if (newexcRatesgd > 0) {
      sgd_debt[2].value = number_format(Math.abs(newexcRatesgd), 2); //addCommas(Number(Math.abs(newexcRatesgd.toFixed(2))));
      sgd_cret[2].value = "0.00";
    } else {
      sgd_cret[2].value = number_format(Math.abs(newexcRatesgd), 2); //addCommas(Number(Math.abs(newexcRatesgd.toFixed(2))));
      sgd_debt[2].value = "0.00";
    }

    if (newexcRateusd > 0) {
      usd_debt[2].value = number_format(Math.abs(newexcRateusd), 2); //addCommas(Number(Math.abs(newexcRateusd.toFixed(2))));
      usd_cret[2].value = "0.00";
    } else {
      usd_cret[2].value = number_format(Math.abs(newexcRateusd), 2); //addCommas(Number(Math.abs(newexcRateusd.toFixed(2))));
      usd_debt[2].value = "0.00";
    }

    finalCalculate();
  }

  // ==## Check GST ##==
  function checkGST() {
    var gst_type = document.getElementsByClassName('gst-name');
    var debit_txt = document.getElementsByClassName('col-debit');
    var credit_txt = document.getElementsByClassName('col-credit');
    var gst_value = document.getElementsByClassName('gst-value');
    var rateSGD = parseFloat($('#txtInputRateSGD').val().replace(/,/g, ''));
    var tgl1 = $('#txtInputTransDate').val();
    var tgl = tgl1.split("-");
    var tahun = tgl[2];
    console.log(tahun);
    for (var i = 0; i < gst_type.length; i++) {
      if (gst_type[i].value === 'GST') {
        if (tahun > '2023') {
          var dd = debit_txt[i].value.replace(/,/g, '');
          var cc = credit_txt[i].value.replace(/,/g, '');
          var total = ((Number(dd) + Number(cc)) * rateSGD * 0.09);
          gst_value[i].value = addCommas(total.toFixed(2));
        } else {
          var dd = debit_txt[i].value.replace(/,/g, '');
          var cc = credit_txt[i].value.replace(/,/g, '');
          var total = ((Number(dd) + Number(cc)) * rateSGD * 0.08);
          gst_value[i].value = addCommas(total.toFixed(2));
        }
      } else {
        gst_value[i].value = 0.00;
      }
    }

    var get1 = 0;
    var get2 = 0;
    var forGSTusd = parseFloat($('#txtInputRateBank').val().replace(/,/g, ''));
    var forGSTsgd = parseFloat($('#txtInputRateSGD').val().replace(/,/g, ''));

    $('.gst-value-debit').each(function(index, item) {
      if ($(item).val()) {
        get1 += parseFloat($(item).val().replace(/,/g, ''));
        var set1 = get1 / (forGSTsgd);
        $('#sumGST-1').val(set1);
        $('#txtInputDebitCBdetailRow-GSTlast-1').val(addCommas(set1.toFixed(2)));
        $('#txtInputCreditCBdetailRow-GSTlast-2').val(addCommas(set1.toFixed(2)));
      }
    });
    $('.gst-value-credit').each(function(index, item) {
      if ($(item).val()) {
        get2 += parseFloat($(item).val().replace(/,/g, ''));
        var set2 = get2 / (forGSTsgd);
        $('#sumGST-2').val(set2);
        $('#txtInputCreditCBdetailRow-GSTlast-1').val(addCommas(set2.toFixed(2)));
        $('#txtInputDebitCBdetailRow-GSTlast-2').val(addCommas(set2.toFixed(2)));
      }
    });

    finalCalculate();
    convertToUSD();
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
    var creBank = parseFloat($('#txtInputCreditCBdetailRow-1').val().replace(/,/g, ''));

    var xxxCredit = (sumAmountC + sumACcredit) - (sumAmountD + sumACdebit);
    $('#txtInputDebitCBdetailRow-addCostRow-1').val(addCommas(xxxCredit.toFixed(2)));

    amountDebt = sumAmountD + xxxCredit + sumACdebit;
    amountCred = sumAmountC + sumACcredit;

    $('#inputAmountDebit').val(addCommas(amountDebt.toFixed(2)));
    $('#inputAmountCredit').val(addCommas(amountCred.toFixed(2)));

    if (amountDebt.toFixed(2) !== amountCred.toFixed(2)) {
      $('#alert-balanceAmount').css('display', 'block');
      return false;
    } else {
      $('#alert-balanceAmount').css('display', 'none');
    }
  }

  function Pilih_MCOAforAddCost(x) {
    function getText(el) {
      if (typeof el.textContent === 'string')
        return el.textContent;
      if (typeof el.innerText === 'string')
        return el.innerText;
    }

    bootbox.dialog({
      message: "What would you do?",
      buttons: {
        pay: {
          label: "Debit",
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
                            <td nowrap><input type="text" name="txtDebit[]" onKeyup="checkGST();" class="ac-col-debit col-deb txt txtnum ' + cls + 'xx" /></td>\n\
                            <td nowrap><input type="text" name="txtCredit[]" readonly onKeyup="checkGST();" class="ac-col-credit col-cre txt txtnum ' + cls + 'xx"/></td>\n\
                            <td nowrap><input type="text" name="txtDebitUSD[]" class="col-debit-usd txt txtnum ' + cls + 'xx" /></td>\n\
                            <td nowrap><input type="text" name="txtCreditUSD[]" class="col-credit-usd txt txtnum ' + cls + 'xx"/></td>\n\
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
        review: {
          label: "Credit",
          className: "blue btn-sm",
          callback: function() {
            var $r = x.rowIndex;
            var cls = getText(document.getElementById('tbl-MasterCOAforAddCost').rows[$r].cells[4]);
            var typeIO = $('#poTXTtypeIO').val();

            $('table[id="tbl-cashGeneral"] tfoot[id="detailRowForAddCost"]').append('<tr class="' + cls + ' added-row-ismo">\n\
                            <td class="text-center" style="vertical-align: middle;">\n\
                                <button class="btn btn-xs btn-link buruk" type="button" onclick="delete_MCOA(this)"><i class="fa fa-trash-o"></i></button></td>\n\
                            <td nowrap><input type="text" name="txtNoCOA[]" class="txt" value="' + getText(document.getElementById('tbl-MasterCOAforAddCost').rows[$r].cells[0]) + '" readonly/></td>\n\
                            <td nowrap><input type="text" name="txtNameCOA[]" class="txt" value="' + getText(document.getElementById('tbl-MasterCOAforAddCost').rows[$r].cells[1]) + '" readonly/></td>\n\
                            <td nowrap><input type="text" name="txtDebit[]" readonly onKeyup="checkGST();" class="ac-col-debit col-deb txt txtnum ' + cls + 'xx" /></td>\n\
                            <td nowrap><input type="text" name="txtCredit[]" onKeyup="checkGST();" class="ac-col-credit col-cre txt txtnum ' + cls + 'xx"/></td>\n\
                            <td nowrap><input type="text" name="txtDebitUSD[]" class="col-debit-usd txt txtnum ' + cls + 'xx" /></td>\n\
                            <td nowrap><input type="text" name="txtCreditUSD[]" class="col-credit-usd txt txtnum ' + cls + 'xx"/></td>\n\
                            <td nowrap><input type="text" name="txtRemark[]" class="txt"/></td>\n\
                            <td nowrap><input type="text" name="txtGST[]" class="txt"/></td>\n\
                            <td nowrap><input type="text" name="txtGSTvalue[]" class="txt txtnum gst-value gst-value-credit"/></td>\n\
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
            bootbox.hideAll();
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
    $('#txtDeptCodeRow-1').val(getText(document.getElementById('tbl-MasterCOA').rows[$r].cells[4]));

    var table = document.getElementById('tbl-MasterCOA');

    $('#txtInputCOAsuppRow-GSTlast-2').val(getText(document.getElementById('tbl-MasterCOA').rows[$r].cells[0]));
    $('#txtInputNameSuppRow-GSTlast-2').val(getText(document.getElementById('tbl-MasterCOA').rows[$r].cells[1]));

    //== Set cash detail
    /*var toUSD = $('#inputUSDRow1').val();
    $('#inputUSDRow3').val(toUSD);
    $('#txtCOADetailRow3').val(getText(document.getElementById('tbl-MasterCOA').rows[$r].cells[0]));
    $('#txtInputRemarkDetail3th').val(getText(document.getElementById('tbl-MasterCOA').rows[$r].cells[1]));*/

    //== +++++++++++++++++++++++++ ==
    var valCUR = getText(document.getElementById('tbl-MasterCOA').rows[$r].cells[3]);
    var tglInv = $('#txtInputTransDate').val();
    if (valCUR != 'ALL') {
      $.post("<?php echo site_url('APtrans_zht/getCurrBank'); ?>", {
        txtCurrency: valCUR,
        txtTglInvoice: tglInv
      }, function(data, success) {
        var get = $.parseJSON(data);

        $('#txtInputRateBank').val(get.rate_usd);
        $('#txtInputRateSGD').val(get.rate_sgd);
      });

      $('.txtHeadCurrency').html(valCUR);
      $('#txtCUR2').val(valCUR);
    }

    // ================
    $("#txtCUR2 :selected").each(function() {
      $(this).parent().data("default", this);
    });
    $("#txtCUR2").change(function(e) {
      $($(this).data("default")).prop("selected", true);
    });

    $('#modal-MCOA').modal('hide');
    $('#txtInputRateSGD').focus();
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

  function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 46 || charCode > 57)) {
      return false;
    }
    return true;
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
</script>