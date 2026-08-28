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

      <form role="form" method="post" id="form-APtrans" action="<?php echo site_url('APtransNew/deleteAPpayment'); ?>" class="form-horizontal">
        <div class="col-md-12">
          <!-- <div class="note note-success note-bordered">
                        <p>
                            ### Active Period : <?php echo $this->session->userdata('periode_1'); ?>  | <a href="<?php echo base_url(); ?>Period">Change</a>
                        </p>
                    </div> -->
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
              <div class="row" id="ajax-formAP-header">
                <div class="col-md-12">
                  <div class="col-sm-4">
                    <div id="div-ReffNum" class="form-group">
                      <label class="control-label col-sm-4">Reff. Number</label>
                      <div class="col-sm-8">
                        <input type="hidden" id="inputAPprimary" name="txtInputAPprimary" class="form-control input-sm" value="<?php echo $this->uri->segment(3); ?>" required="required" />
                        <div class="input-icon input-icon-sm right">
                          <i id="btn-generate-noreff" class="fa fa-refresh"></i>
                          <input type="text" id="inputNoReff" name="txtFacture" class="form-control input-sm" value="<?php echo $_selectHeaderAP->no_facture; ?>" required="required" />
                          <span id="alert-errorReff" class="help-block" style="display: none;">Please use another num reff.! </span>
                        </div>
                      </div>
                    </div>

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
                        <input id="txtInputTransDate" name="txtTransDate" type="text" class="form-control input-sm date-picker" value="<?php echo date('Y-m-d', strtotime($_selectHeaderAP->trans_date)); ?>" data-date-format="yyyy-mm-dd" readonly />
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
                      <label class="control-label col-sm-4">Supplier</label>
                      <div class="col-md-2">
                        <input type="text" id="txtInputSuplierID" name="txtSuplierID" value="<?php echo $_selectHeaderAP->supplier_id; ?>" class="form-control input-sm" style="background-color: #D2E0D1;" readonly />
                      </div>
                      <div class="col-md-6">
                        <input type="text" id="txtInputSuplierName" name="txtSuplierName" value="<?php echo $_selectHeaderAP->suppliercompany; ?>" class="form-control input-sm" style="background-color: #D2E0D1;" readonly />
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-8">
                    <div class="form-group">
                      <label class="control-label col-sm-2">Voucher Remark</label>
                      <div class="col-sm-10">
                        <input type="text" id="txtInputSuplierRemark" value="<?php echo $_selectHeaderAP->remark; ?>" name="txtSuplierRemark" class="form-control input-sm" />
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
                            <?php if ($row->currency_symbol == $_selectHeaderAP->currency_id) : ?>
                              <option value="<?php echo $row->currency_symbol; ?>" selected=""><?php echo $row->currency_id; ?></option>
                            <?php else : ?>
                              <option value="<?php echo $row->currency_symbol; ?>"><?php echo $row->currency_id; ?></option>
                            <?php endif; ?>
                          <?php endforeach; ?>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-4">
                    <div class="form-group">
                      <label class="control-label col-sm-4">Voucher Rate</label>
                      <div class="col-sm-8">
                        <input id="txtInputRateVoucher" value="<?php echo $_selectHeaderAP->currency_rate; ?>" name="txtRateVoucher" type="text" class="form-control input-sm txt-ismo-back-null txtnum" readonly />
                      </div>
                    </div>
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="col-sm-4">
                    <div class="form-group">
                      <label class="control-label col-sm-4">Amount</label>
                      <div class="col-sm-8">
                        <input type="text" name="txtTotalVoucher" value="<?php if (!empty($_selectDtlJrnal[0]->credit)) {
                                                                            echo number_format($_selectDtlJrnal[0]->credit, 2);
                                                                          } ?>" id="inputTotalVoucher" class="form-control input-sm txt-ismo-back-null txtnum" readonly="" />
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-4">
                    <div class="form-group">
                      <label class="control-label col-sm-4">to USD</label>
                      <div class="col-sm-8">
                        <input type="text" id="txtInputRateSGD" value="<?php if (!empty($_selectHeaderAP->currency_rate) && !empty($_selectDtlJrnal[0]->credit)) {
                                                                          echo number_format($_selectHeaderAP->currency_rate * $_selectDtlJrnal[0]->credit, 2);
                                                                        } ?>" name="txtRateSGD" class="form-control input-sm txt-ismo-back-null txtnum" readonly="" />
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
                        <input id="inputCOA" style="background-color: #D2E0D1;" value="<?php echo $_selectHeaderAP->code_cashbank; ?>" type="text" name="txtCashBankCode" class="form-control input-sm" required />
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-8">
                    <div class="form-group">
                      <label class="control-label col-sm-2">Account Name</label>
                      <div class="col-sm-10">
                        <input id="inputCOAremark" value="<?php echo $_selectHeaderAP->AccountName; ?>" type="text" name="txtRemarkCB" class="form-control input-sm" readonly />
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
                            <?php if ($row->currency_symbol == $_selectHeaderAP->currency_bayar) : ?>
                              <option value="<?php echo $row->currency_symbol; ?>" selected><?php echo $row->currency_id; ?></option>
                            <?php else : ?>
                              <option value="<?php echo $row->currency_symbol; ?>"><?php echo $row->currency_id; ?></option>
                            <?php endif; ?>
                          <?php endforeach; ?>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-4">
                    <div class="form-group">
                      <label class="control-label col-sm-4">Monthly Rate</label>
                      <div class="col-sm-8">
                        <input type="text" id="txtInputRateWeekly" value="<?php echo number_format($_selectHeaderAP->rate_nego, 6); ?>" name="txtRateBayar" class="form-control input-sm txtnum" required />
                      </div>
                    </div>
                  </div>

                  <div class="col-sm-4">
                    <div class="form-group">
                      <label class="control-label col-sm-4">Amount Payment</label>
                      <div class="col-sm-8">
                        <input type="text" value="<?php echo number_format(($_selectHeaderAP->currency_rate * $_selectHeaderAP->amount) / $_selectHeaderAP->rate_nego, 2); ?>" id="txtAmountPayment" name="txtAmountPayment" class="form-control input-sm txtnum" required readonly />
                      </div>
                    </div>
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="col-sm-4">
                    <div class="form-group">
                      <label class="control-label col-sm-4">Rate Negotiation</label>
                      <div class="col-sm-8">
                        <input type="text" id="txtInputRateNego" value="<?php echo number_format($_selectHeaderAP->rate_nego, 6); ?>" name="txtRateNego" class="form-control input-sm txtnum" required />
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-4">
                    <div class="form-group">
                      <label class="control-label col-sm-4">Rate Equivalent</label>
                      <div class="col-sm-8">
                        <input type="text" id="txtInputRateEqui" value="0" name="txtRateEqui" class="form-control input-sm txtnum" required />
                      </div>
                    </div>
                  </div>

                </div>

                <div class="col-md-12">
                  <div class="col-sm-8">
                    <div class="form-group">
                      <label class="control-label col-sm-2">Check Number</label>
                      <div class="col-sm-10">
                        <input type="text" value="<?php echo $_selectHeaderAP->check_number; ?>" id="txtInputCheckBank" name="txtCheckBank" class="form-control input-sm" required />
                      </div>
                    </div>
                  </div>

                  <div class="col-sm-4 display-none">
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
                        <th class="text-center" style="width: 42px;">
                          <button id="btnSelectInvoice" class="btn btn-xs btn-link baik" type="button">
                            <i class="fa fa-search"></i></button></td>
                        </th>
                        <th>No. Invoice</th>
                        <th style="width: 10%;">Rate</th>
                        <th style="width: 15%;">Total Before</th>
                        <th style="width: 15%;">[USD]Equivalent</th>
                        <th style="width: 15%;">Payment</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach ($_selectInvoiceAP as $inv) : ?>
                        <tr class="added-row-ismo">
                          <td></td>
                          <td><input value="<?php echo $inv->NoInvoice; ?>" name="txtNoInvoiceDtl[]" class="txt" readonly /></td>
                          <td><input value="<?php echo number_format($inv->rate_akhir, 6); ?>" name="txtRateInvoiceDtl[]" class="txt col-rate txtnum" readonly /></td>
                          <td><input value="<?php echo number_format($inv->hutang, 2); ?>" name="txtTotalBeforeInvoiceDtl[]" class="txt col-btot txtnum" readonly /></td>
                          <td><input value="<?php echo number_format($inv->rate_akhir * $inv->hutang, 2); ?>" name="txtToUSDInvoiceDtl[]" class="txt col-dtot txtnum" readonly /></td>
                          <td><input data-max="<?php echo number_format($inv->hutang - $inv->Total, 2); ?>" value="<?php echo number_format($inv->Total, 2); ?>" name="txtPeymentInvoiceDtl[]" class="txt col-ptot txtnum" onkeyup="CountPayTotal(); isNumber();" /></td>
                          <td hidden><input value="<?php echo $inv->jenis_trans; ?>" name="txtjenis[]" /></td>
                        </tr>
                      <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                      <tr>
                        <td colspan="2" class="txtnum bold" style="padding-right: 10px;">Grand Total</td>
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
                <span class="caption-helper">For Journal</span>
              </div>
              <div class="actions display-none">
                <a class="btn btn-circle green display-none" id="btnAddCost" href="javascript:;">
                  Additional Cost
                </a>
              </div>
            </div>
            <div class="portlet-body table-responsive">
              <table class="table-ismo" id="tbl-cashGeneral">
                <thead>
                  <tr>
                    <th class="text-center" style="width: 42px;">
                      <!-- <a class="btn btn-xs btn-link baik" data-toggle="modal" id="btnSelectMCOA">
                                                <i class="fa fa-plus"></i></a> -->
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
                  <?php $cre = 0;
                  $deb = 0;
                  foreach ($_selectDtlJrnal as $jrnl) : ?>
                    <tr id="rowSetCOA">
                      <td class="text-center" style="vertical-align: middle;">
                        <button class="btn btn-xs btn-link biasa" type="button"><i class="fa fa-arrow-down"></i></button>
                      </td>
                      <td nowrap><input type="text" name="txtNoCOA[]" class="txt" value="<?php echo $jrnl->coa; ?>" readonly /></td>
                      <td nowrap><input type="text" name="txtNameCOA[]" class="txt" value="<?php echo $jrnl->coa_description; ?>" readonly /></td>
                      <td nowrap><input type="text" name="txtDebit[]" class="col-debit txt txtnum" value="<?php echo to2dec($jrnl->debit); ?>" /></td>
                      <td nowrap><input type="text" name="txtCredit[]" class="col-credit txt txtnum" value="<?php echo to2dec($jrnl->credit); ?>" /></td>
                      <td nowrap><input type="text" name="txtRemark[]" class="txt" value="<?php echo $jrnl->remark; ?>" /></td>
                      <td nowrap><input type="text" name="txtGST[]" class="txt gst-name" value="<?php echo $jrnl->gst_type; ?>" /></td>
                      <td nowrap><input type="text" name="txtGSTvalue[]" class="txt txtnum gst-value" value="<?php echo to2dec($jrnl->gst_value); ?>" /></td>
                    </tr>
                  <?php
                    $cre += $jrnl->credit;
                    $deb += $jrnl->debit;
                  endforeach;
                  function to2dec($num)
                  {
                    return number_format($num, 2);
                  }
                  ?>
                </tbody>
              </table>
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
                        <th>[<?php echo $_currBayar; ?>] Equivalent</th>
                        <th>[USD] Equivalent</th>
                        <th>Currency</th>
                        <th>Account COA</th>
                        <th class="ismo-hidden">Cash Flow</th>
                      </tr>
                    </thead>
                    <tbody id="ajax-tblAP">
                      <?php $nn = 1;
                      foreach ($_selectDetailAP as $dtl) : ?>
                        <tr>
                          <td class="text-center" style="vertical-align: middle;"><?php echo $nn++; ?></td>
                          <td nowrap><input value="<?php echo $dtl->remark; ?>" name="txtRemarkDetail[]" id="txtInputRemarkDetail" class="txt txt-ismo-back-null" readonly /></td>
                          <td nowrap><input value="<?php echo number_format($dtl->amount, 2); ?>" name="txtTotalDetal[]" id="inputAmountRow1" class="txt txtnum txt-ismo-back-null" readonly /></td>
                          <td nowrap><input value="<?php echo number_format($dtl->cur_equi, 2); ?>" name="txtToCurr[]" id="inputToCurr1" class="txt txtnum txt-ismo-back-null" readonly /></td>
                          <td nowrap><input value="<?php echo number_format($dtl->usd_equi, 2); ?>" name="txtEquiDetail[]" id="inputUSDRow1" class="txt txtnum txt-ismo-back-null" readonly /></td>
                          <td nowrap><input value="USD" name="txtCurrDetail[]" id="inCurFirstRow" class="txt txt-ismo-back-null" readonly /></td>
                          <td nowrap><input value="<?php echo $dtl->no_coa; ?>" name="txtCOADetail[]" id="txtCOADetailRow1" class="txt txt-ismo-back-null" readonly /></td>
                          <td nowrap class="ismo-hidden">
                            <input name="txtCFDetail[]" class="txt" id="cf-row-1" onclick="viewModalCashFlow(this.id)" readonly />
                            <input name="txtCFKeyDetail[]" type="hidden" class="txt" id="cf-row-1-key" readonly />
                          </td>
                        </tr>
                      <?php endforeach; ?>
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
                  <div class="col-sm-4">
                    <div class="form-group">
                      <button class="btn btn-sm btn-primary" id="btnFindRecord" type="button">
                        Find <i class="fa fa-sm fa-search fa-fw" aria-hidden="true"></i> </button>
                      <button class="btn btn-sm btn-default" id="btnPrint" type="button">
                        Print <i class="fa fa-sm fa-print fa-fw" aria-hidden="true"></i></button>
                      <button class="btn btn-sm btn-Primary" id="btnCancel" name="btnCancel" type="button"> New Transaction </button>
                    </div>
                  </div>
                  <div class="col-sm-offset-6 col-sm-2 text-right">
                    <div class="form-group">

                      <button class="btn btn-sm btn-danger" id="btnDeleteAP" name="btnSubmit" type="submit">Delete</button>
                      <button class="btn btn-sm btn-default" id="btnCancel" name="btnCancel" type="button">Cancel</button>
                    </div>
                  </div>
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
        <div id="contentSelectSupplier"><i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i> Loading...</div>
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
        <div id="contentInvoiceSelect"><i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i> Loading...</div>
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
        <div id="contentAPlist"><i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i> Loading...</div>
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
        <div id="contentMasterCOA"><i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i> Loading...</div>
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
        <div id="contentFindAP"><i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i> Loading...</div>
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
        <div id="modalCashFlow"><i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i> Loading...</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script src="<?php echo base_url(); ?>assets/global/jq/numToWord.js"></script>
<script src="<?php echo base_url(); ?>assets/global/plugins/bootbox/bootbox.min.js" type="text/javascript"></script>
<script type="text/javascript">
  $(document).ready(function() {
    CountGrandTotal();

    $("#btnCancel").click(function() {
      window.location = "<?php echo site_url('APtransNew'); ?>";
    });
    $("#form-APtrans").submit(function(e) {
      var currentForm = this;
      e.preventDefault();
      bootbox.confirm("Are you realy want to delete this transaction?", function(result) {
        if (result) {
          currentForm.submit();
        }
      });
    });

    $('input').attr('readonly', true);
    $("select :selected").each(function() {
      $(this).parent().data("default", this);
    });
    $("select").change(function(e) {
      $($(this).data("default")).prop("selected", true);
    });
    // ===== ## Find AP Payment ## =====
    $("#btnFindRecord").click(function() {
      $.post("<?php echo site_url(); ?>APtransNew/selectAPpayment", function(data) {
        $('#contentFindAP').html(data);
      });
      $('#modal-findAP').modal('show');
    });

    $('#inCurFirstRow').val($('#selInputCurrencyVoucher').val());
    $('#inputAmountRow3').val($('#inputAmountRow1').val());

    $.post("<?php echo site_url('APtransNew/selectSuppliertForAPbySuppCode'); ?>", {
      txtCodeSupp: $('#txtInputSuplierID').val()
    }, function(data, status) {
      var jess = $.parseJSON(data);
      $('#txtInputRemarkDetail').val(jess.suppName);
      $('#txtCOADetailRow1').val(jess.suppCOA);
    });

    $.post("<?php echo site_url('APtransNew/selectCurrencyAP'); ?>", {
      txtCurrAjax: $('#txtCUR2').val()
    }, function(ress, status) {
      var data = $.parseJSON(ress);
      //alert(data.rate_usd);
      //            $('#txtInputRateWeekly').val(data.rate_usd.toFixed(2));
      //            $('#txtInputRateNego').val(data.rate_usd);
      //            $('#txtInputRateEqui').val(0);

      // set value 3th detail
      var amount0 = $('#inputTotalVoucher').val();
      var amount = parseFloat(amount0.replace(/,/g, ""));
      var equiAmount = (data.rate_usd * amount).toFixed(2);
      var equiR10 = $('#inputUSDRow1').val();
      var equiR1 = parseFloat(equiR10.replace(/,/g, ""));
      var selisih = (equiAmount - equiR1).toFixed(2);

      //alert(addCommas(equiAmount) +' --- '+selisih);
      $('#inputUSDRow3').val(addCommas(equiAmount));
      $('#inputUSDRow2').val(addCommas(selisih));
      $('#inCurThreeRow').val($('#txtCUR2').val());
      $('#txtCOADetailRow3').val($('#inputCOA').val());
    });

    $('#btnPrint').click(function() {
      var noAP = '<?php echo $_selectHeaderAP->no_facture; ?>';
      var suppNm = '<?php echo encode_str($_selectHeaderAP->suppliercompany); ?>';
      var suppAd = '<?php
                    if (strchr($_selectHeaderAP->address, '<br />', true)) {
                      echo encode_str(strchr($_selectHeaderAP->address, '<br />', true));
                    } else {
                      echo encode_str($_selectHeaderAP->address);
                    }
                    ?>';
      var suppDr = '<?php echo encode_str(strchr($_selectHeaderAP->address, '<br />')); ?>';
      //alert(noAP);
      window.open('<?php echo site_url(); ?>APtransNew/paymentAdvice/' + noAP + '?sup=' + suppNm + '&adr=' + suppAd + '&adr2=' + suppDr, '_blank');
    });
  });
</script>

<script>
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
    //$('#inputTotalVoucher').val(addCommas(sumPay.toFixed(2)));
    //$('#txtInputRateSGD').val(addCommas(final.toFixed(2)));

    $('#inputAmountRow1').val(addCommas(sumPay.toFixed(2)));
    $('#inputUSDRow1').val(addCommas(final.toFixed(2)));
    $('#amountTerbilang').val('In Word: United States Dollar, ' + capitalize(toWords(final.toFixed(2))));
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
</script>