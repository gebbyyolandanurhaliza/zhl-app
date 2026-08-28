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
      <form id="form-transCashBank" role="form" method="post" action="<?php echo site_url('CBtrans_zht/deleteCashBankTransaction'); ?>" class="form-horizontal">

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
                <span class="caption-helper">Cash Bank ZHT</span>
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
                        <label class="control-label col-sm-4">Reference Number</label>
                        <div class="col-sm-8">
                          <div class="input-icon input-icon-sm right">
                            <i id="btn-generate-noreff" class="fa fa-refresh"></i>
                            <input type="text" value="<?php echo $_selectHeader->no_reff; ?>" id="inputNoReff" name="txtNoReff" placeholder="Input or Generate Referance Number" maxlength="20" class="form-control input-sm" required />
                            <span id="alert-errorReff" class="help-block" style="display: none;">Please use another num reff.! </span>
                          </div>
                          <input type="hidden" name="txtPrimaryCashBank" value="<?php echo encode_str($_selectHeader->header_id); ?>" />
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
                              <?php if ($io->io_code == $_selectHeader->io_code) : ?>
                                <option value="<?php echo $io->io_code; ?>" selected><?php echo $io->io_description; ?></option>
                              <?php else : ?>
                                <option value="<?php echo $io->io_code; ?>"><?php echo $io->io_description; ?></option>
                              <?php endif; ?>
                            <?php endforeach; ?>
                          </select>
                          <input type="hidden" id="poTXTtypeIO" value="<?php echo $_selectHeader->type_trans; ?>" name="txtIOtypeForPO" />
                        </div>
                      </div>
                    </div>

                    <div class="col-sm-4">
                      <div class="form-group">
                        <label class="control-label col-sm-2">Date</label>
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
                          <select class="form-control input-sm" name="selCBCode" id="selInputCBCode">
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
                    </div>
                    <div class="col-sm-4">
                      <div class="form-group">
                        <div class="col-sm-12">
                          <input type="text" id="txtInputRemark" value="<?php echo $_selectHeader->AccountName; ?>" name="txtRemark" class="form-control input-sm hanya-baca" required />
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="col-md-12">
                    <div class="col-sm-4">
                      <div class="form-group">
                        <label class="control-label col-sm-4">From / To</label>
                        <div class="col-sm-8">
                          <input type="text" value="<?php echo $_selectHeader->from_to; ?>" name="txtFromTo" class="form-control input-sm" required />
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-8">
                      <div class="form-group">
                        <label class="control-label col-sm-1">Description</label>
                        <div class="col-sm-11">
                          <input type="text" value="<?php echo $_selectHeader->trans_description; ?>" name="txtDescription" class="form-control input-sm" required />
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="col-md-12">
                    <div class="col-sm-8">
                      <div class="form-group">
                        <label class="control-label col-sm-2">Check Number</label>
                        <div class="col-sm-10">
                          <input type="text" value="<?php echo $_selectHeader->check_bank; ?>" id="txtInputCheckBank" name="txtCheckBank" class="form-control input-sm" required />
                        </div>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <input type="text" id="txtblankk" name="txtblankk" class="form-control input-sm display-none" readonly required />
                    </div>
                  </div>
                  <br />

                  <div class="col-md-8">
                    <div class="panel panel-primary">
                      <div class="panel-body display-none">
                        <div class="col-sm-12">
                          <div class="col-sm-4">
                            <div class="form-group">
                              <label class="control-label col-sm-4">Prepaid</label>
                              <div class="col-sm-8">
                                <select class="form-control input-sm" name="selPrepaid" id="selectPrepaid" onchange="changePrepaid(this)">
                                  <option value="0"> Choose..</option>
                                  <option value="1" <?php if ($_selectHeader->prepaid == 1) {
                                                      echo 'selected';
                                                    } ?>>Yes</option>
                                  <option value="0" <?php if ($_selectHeader->prepaid == 0) {
                                                      echo 'selected';
                                                    } ?>>No</option>
                                </select>
                              </div>
                            </div>
                          </div>
                          <div class="col-sm-4">
                            <select class="form-control input-sm select2me" data-placeholder="Choose..." name="" id="">
                              <option value=""></option>
                            </select>
                          </div>
                          <div class="col-sm-4">
                            <input type="text" name="" class="form-control input-sm" />
                          </div>
                        </div>

                        <div id="div-supplier" class="col-sm-12">
                          <div class="col-sm-4">
                            <div class="form-group">
                              <label class="control-label col-sm-4">Supplier</label>
                              <div class="col-sm-8">
                                <input type="text" id="txtInputSupp" value="<?php echo $_selectHeader->supp_id; ?>" name="txtSup" class="form-control input-sm ismo-supp-group" />
                              </div>
                            </div>
                          </div>
                          <div class="col-sm-4">
                            <input type="text" id="txtInputSupCOA" value="<?php echo $_selectHeader->supp_coa; ?>" name="txtSupCOA" class="form-control input-sm ismo-supp-group" />
                          </div>
                          <div class="col-sm-4">
                            <input type="text" id="txtInputSupRemark" value="<?php echo $_selectHeader->supp_name; ?>" name="txtSupRemark" class="form-control input-sm ismo-supp-group" />
                          </div>
                        </div>

                        <div id="div-costumer" class="col-sm-12">
                          <div class="col-sm-4">
                            <div class="form-group">
                              <label class="control-label col-sm-4">Customer</label>
                              <div class="col-sm-8">
                                <input type="text" id="txtInputCust" value="<?php echo $_selectHeader->cust_id; ?>" name="txtCos" class="form-control input-sm ismo-cust-group" />
                              </div>
                            </div>
                          </div>
                          <div class="col-sm-4">
                            <input type="text" id="txtInputCosCOA" value="<?php echo $_selectHeader->cust_coa; ?>" name="txtCosCOA" class="form-control input-sm ismo-cust-group" />
                          </div>
                          <div class="col-sm-4">
                            <input type="text" id="txtInputCosRemark" value="<?php echo $_selectHeader->cust_name; ?>" name="txtCosRemark" class="form-control input-sm ismo-cust-group" />
                          </div>
                        </div>

                      </div>
                    </div>
                  </div>

                  <div class="col-md-4">
                    <div class="col-sm-12">
                      <div class="form-group">
                        <label class="control-label col-sm-3">Currency</label>
                        <div class="col-sm-9">
                          <select class="form-control input-sm " data-placeholder="Choose Currency..." name="txtCurr" id="txtInputCurr">
                            <option value="">Choose...</option>
                            <?php foreach ($_selectCurrency as $row) : ?>
                              <?php if ($row->currency_symbol == $_selectHeader->currency_id) : ?>
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
                          <input type="text" id="txtInputRate" value="<?php echo number_format($_selectHeader->currency_rate, 6); ?>" name="txtRateCurr" class="form-control input-sm hanya-baca" required />
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-12">
                      <div class="form-group">
                        <label class="control-label col-sm-3">Rate SGD</label>
                        <div class="col-sm-9">
                          <input type="text" id="txtInputRateSGD" value="<?php echo number_format($_selectHeader->rate_sgd, 6); ?>" name="txtRateCurrSGD" class="form-control input-sm hanya-baca txtnumRate" required />
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-12 <?php if ($_selectHeader->rate_nego == 0) {
                                            echo 'display-none';
                                          } ?>" id="colRateNego">
                      <div class="form-group">
                        <label class="control-label col-sm-3" style="font-size: 95%;">Rate Negotiation</label>
                        <div class="col-sm-9">
                          <input type="text" id="txtInputRateNego" value="<?php echo number_format($_selectHeader->rate_nego, 6); ?>" name="txtRateCurrNego" class="form-control input-sm txtnumRate" required />
                        </div>
                      </div>
                    </div>
                  </div>

                </div>
              </div>

            </div>
          </div>
        </div>

        <div class="col-md-12 <?php if ($_checkPO == FALSE) {
                                echo 'display-none';
                              } ?>">
          <!-- BEGIN PORTLET-->
          <div class="portlet light">
            <div class="portlet-title">
              <div class="caption theme-font">
                <i class="icon-calendar theme-font"></i>
                <span class="caption-subject bold uppercase"> Detail</span>
                <span class="caption-helper">Selected PO in Here</span>
              </div>
              <div class="actions">
                <a class="btn btn-circle btn-icon-only btn-default fullscreen" href="javascript:;" data-original-title="" title="">
                </a>
              </div>
            </div>
            <div class="portlet-body form">
              <div class="row">
                <div class="col-md-12 table-responsive" style="padding-bottom: 15px;">
                  <table class="table-ismo" id="tbl-detail-po">
                    <thead>
                      <tr>
                        <th class="text-center" style="width: 42px;">
                          <button id="btnSelectPO" class="btn btn-xs btn-link baik" type="button">
                            <i class="fa fa-search"></i></button></td>
                        </th>
                        <th>No. Main PO</th>
                        <th style="width: 10%;">Date PO</th>
                        <th style="width: 10%;">Currency</th>
                        <th style="width: 15%;">Rate</th>
                        <th style="width: 15%;">Total Before</th>
                        <th style="width: 15%;">[USD] Equivalent</th>
                        <th style="width: 15%;">Total</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach ($_selectPO as $po) : ?>
                        <tr class="added-row-ismo">
                          <td></td>
                          <td><input value="<?php echo $po->po_id; ?>" name="txtNoMainPO[]" class="txt" readonly /></td>
                          <td><input value="<?php echo date('d-m-Y', strtotime($po->po_date)); ?>" name="txtDatePO[]" class="txt txtnum" readonly /></td>
                          <td><input value="<?php echo $po->po_currency; ?>" name="txtCurrencyPO[]" class="txt txtnum" readonly /></td>
                          <td><input value="<?php echo number_format($po->po_rate, 2); ?>" name="txtTotalPO[]" class="txt col-rate txtnum" readonly /></td>
                          <td><input value="<?php echo number_format($po->po_total, 2); ?>" name="txtRatePO[]" class="txt col-before txtnum" readonly /></td>
                          <td><input value="<?php echo number_format($po->po_rate * $po->po_total, 2); ?>" name="txtEquivalentPO[]" class="txt col-equi txtnum" readonly /></td>
                          <td><input value="<?php echo number_format($po->uang_muka, 2); ?>" name="txtTotalDP[]" class="txt col-total txtnum" readonly /></td>
                        </tr>
                      <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                      <tr>
                        <td colspan="4" class="txtnum bold" style="padding-right: 10px;">Grand Total</td>
                        <td class="txtnum">
                          <input name="" id="rateTotalID" class="txt txtnum txt-ismo-back-null" readonly="true" />
                        </td>
                        <td class="txtnum">
                          <input name="" id="befTotalID" class="txt txtnum txt-ismo-back-null" readonly="true" />
                        </td>
                        <td class="txtnum">
                          <input name="" id="equiTotalID" class="txt txtnum txt-ismo-back-null" readonly="true" />
                        </td>
                        <td class="txtnum">
                          <input name="txtTotalPaymentPO" id="totalTotalID" class="txt txtnum txt-ismo-back-null" readonly="true" />
                        </td>
                      </tr>
                    </tfoot>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
        
        <div class="col-md-12">
          <div class="portlet light">
            <div class="portlet-title">
              <div class="caption theme-font">
                <i class="fa fa-file-pdf-o"></i>
                <span class="caption-subject bold uppercase"> Attachment</span>
                <span class="caption-helper">Cash Bank ZHT</span>
              </div>
            </div>
            <div class="portlet-body table-responsive">
              <table class="table table-bordered" id="tabel-atch">
                <thead>
                  <tr>
                    <th width="1%">
                      <a class="btn btn-success" onclick="tambah_atch()"><i class="fa fa-plus"></i></a>
                    </th>
                    <th width="8%">
                      File
                    </th>
                    <th width="8%">
                      Remarks
                    </th>
                  </tr>
                </thead id="tbody-atch">

                <tbody>
                  <?php
                  if (!empty($attach)) {
                    foreach ($attach as $value) { ?>
                      <tr>
                        <td class="text-center">
                          <button class="tombol" onclick="hapus_atch_delete(this)" data-file_id="<?= $value->file_id ?>">Remove</button>
                        </td>
                        <td>
                          <a class="btn btn-block btn-sm btn-info btn-circle" href="<?= base_url('Cb_uploads/' . $value->file_name) ?>" target="_blank">Click View Document</a>
                        </td>
                        <td>
                          <input type="text" name="remarks[]" value="<?= $value->remarks ?>" class="form-control" placeholder="input your remark here...">
                        </td>
                      </tr>
                  <?php
                    }
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
                    <th style="width: 7%;">Account Number</th>
                    <th style="width: 7%;">Department Code</th>
                    <th style="width: 20%;">Name</th>
                    <th style="width: 10%;">Debit</th>
                    <th style="width: 10%;">Credit</th>
                    <th style="width: 10%;">Debit [USD]</th>
                    <th style="width: 10%;">Credit [USD]</th>
                    <th style="width: 10%;">Remark</th>
                    <th style="width: 10%;">GST Name</th>
                    <th style="width: 10%;">GST Value</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($_selectDetail as $dtl) : ?>
                    <tr id="rowSetCOA">
                      <td class="text-center" style="vertical-align: middle;">
                        <button class="btn btn-xs btn-link biasa" type="button">
                          <i class="fa fa-arrow-down"></i></button>
                      </td>
                      <td nowrap><input type="text" value="<?php echo $dtl->coa; ?>" name="txtNoCOA[]" id="txtInputCOAsuppRow-1" class="txt" readonly /></td>
                      <?php if($dtl->dept_code == '0' || $dtl->dept_code == ''){?>
                        <td><input type="text" name="txtDeptCode[]" class="txt" value="000" readonly /></td>
                      <?php }else {?>
                        <td><input type="text" name="txtDeptCode[]" class="txt" value="<?php echo $dtl->dept_code; ?>" readonly /></td>
                      <?php } ?>
                      <td nowrap><input type="text" value="<?php echo $dtl->coa_description; ?>" name="txtNameCOA[]" id="txtInputNameSuppRow-1" class="txt" readonly /></td>
                      <td nowrap><input type="text" value="<?php echo number_format($dtl->debit, 2); ?>" name="txtDebit[]" id="txtInputDebitCBdetailRow-1" onKeyup="calculateAmountDebit()" class="col-debit txt txtnum" /></td>
                      <td nowrap><input type="text" value="<?php echo number_format($dtl->credit, 2); ?>" name="txtCredit[]" id="txtInputCreditCBdetailRow-1" onKeyup="calculateAmountCredit()" class="col-credit txt txtnum" /></td>
                      <td nowrap><input type="text" value="<?php echo number_format($dtl->debit_usd, 2); ?>" name="txtDebitUSD[]" id="txtInputDebitCBdetailRow-1-addCostRowUSD" onKeyup="calculateAmountDebitUSD()" class="col-debit-usd txt txtnum" /></td>
                      <td nowrap><input type="text" value="<?php echo number_format($dtl->credit_usd, 2); ?>" name="txtCreditUSD[]" id="txtInputCreditCBdetailRow-1-addCostRowUSD" onKeyup="calculateAmountCreditUSD()" class="col-credit-usd txt txtnum" /></td>
                      <td nowrap><input type="text" value="<?php echo $dtl->remark; ?>" name="txtRemark[]" class="txt" /></td>
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
              <div class="portlet-body">
                <div class="row">
                  <div class="col-md-6">
                    <button class="btn btn-sm btn-primary" id="btnFindRecordzht" type="button">
                      Find <i class="fa fa-sm fa-search fa-fw" aria-hidden="true"></i> </button>
                    <button class="btn btn-sm btn-default disabled" id="btnPrint" type="button">
                      Print <i class="fa fa-sm fa-print fa-fw" aria-hidden="true"></i></button>
                    <button class="btn btn-sm btn-primary" type="reset" onclick="javascript: window.location = '<?php echo site_url("CBtrans_zht"); ?>';"> <i class="fa fa-plus"></i> New Transaction</button>
                  </div>
                  <div class="col-md-6 text-right">
                    <button class="simpan btn btn-sm btn-danger" onclick="return checkEqual()" type="submit">
                      <i class="fa fa-trash-o"></i> Delete
                    </button>
                    <script>
                      function checkEqual() {
                        var a = document.getElementById('inputAmountDebit').value;
                        var b = document.getElementById('inputAmountCredit').value;

                        // if( a !== b){
                        //     document.getElementById('alert-balanceAmount').style.display = 'block';
                        //     return false;
                        // }else{
                        //     document.getElementById('alert-balanceAmount').style.display = 'none';
                        // }
                      }
                    </script>
                    <button class="btn btn-sm btn-default" type="reset" onclick="javascript: window.location = '<?php echo site_url("CBtrans_zht"); ?>';">
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
        <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i> Loading...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script src="<?php echo base_url(); ?>assets/global/plugins/bootbox/bootbox.min.js" type="text/javascript"></script>
<script type="text/javascript">
  $(document).ready(function() {
    $('input').attr('readonly', true);
    $("select :selected").each(function() {
      $(this).parent().data("default", this);
    });
    $("select").change(function(e) {
      $($(this).data("default")).prop("selected", true);
    });

    CountGrandTotal();
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
    // ===== ## Find AP Payment ## =====
    $("#btnFindRecordzht").click(function() {
      $.post("<?php echo site_url(); ?>CBtrans_zht/selectCashBank", function(data) {
        $('#contentFindCB').html(data);
      });
      $('#modal-findCB').modal('show');
    });
  });
</script>
<script type="text/javascript">
  function CountGrandTotal() {
    var sumBefore = 0;
    var sumEquivaln = 0;
    var sumTotal = 0;
    $(".col-before").each(function() {
      var valBtot = this.value;
      var newBtot = parseFloat(valBtot.replace(/,/g, ''));
      if (!isNaN(newBtot) && this.value.length !== 0) {
        sumBefore += parseFloat(newBtot);
      }
    });

    $(".col-equi").each(function() {
      var valEtot = this.value;
      var newEtot = parseFloat(valEtot.replace(/,/g, ''));
      if (!isNaN(newEtot) && this.value.length !== 0) {
        sumEquivaln += parseFloat(newEtot);
      }
    });

    $(".col-total").each(function() {
      var valTtot = this.value;
      var newTtot = parseFloat(valTtot.replace(/,/g, ''));
      if (!isNaN(newTtot) && this.value.length !== 0) {
        sumTotal += parseFloat(newTtot);
      }
    });
    //alert(sum);
    var avgRate = sumEquivaln / sumBefore;
    $('#rateTotalID').val(addCommas(avgRate.toFixed(2)));
    $('#befTotalID').val(addCommas(sumBefore.toFixed(2)));
    $('#equiTotalID').val(addCommas(sumEquivaln.toFixed(2)));
    $('#totalTotalID').val(addCommas(sumTotal.toFixed(2)));
    //======================================================================
    /*var typeIO  = $('#poTXTtypeIO').val();
    if(typeIO == 'O'){
        $('#txtInputCreditCBdetailRow-1').val(addCommas(sumTotal.toFixed(2)));
        $('#inputAmountCredit').val(addCommas(sumTotal.toFixed(2)));
    }else{
        $('#txtInputDebitCBdetailRow-1').val(addCommas(sumTotal.toFixed(2)));
        $('#inputAmountDebit').val(addCommas(sumTotal.toFixed(2)));
    }*/
  }

  // ==## Calculate Balance Table ##==
  function CountBelance() {
    var sumDebit = 0;
    var sumCredit = 0;
    var sumDebitUSD = 0;
    var sumCreditUSD = 0;

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

    $(".col-debit-usd").each(function() {
      var valDebUSD = this.value;
      var newDebUSD = parseFloat(valDebUSD.replace(/,/g, ''));
      if (!isNaN(newDebUSD) && this.value.length !== 0) {
        sumDebitUSD += parseFloat(newDebUSD);
      }
    });

    $(".col-credit-usd").each(function() {
      var valCredUSD = this.value;
      var newCredUSD = parseFloat(valCredUSD.replace(/,/g, ''));
      if (!isNaN(newCredUSD) && this.value.length !== 0) {
        sumCreditUSD += parseFloat(newCredUSD);
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
    var amountDebtUSD = 0;
    var amountCredUSD = 0;

    amountDebt = parseFloat(sumDebit);
    amountCred = parseFloat(sumCredit);
    amountDebtUSD = parseFloat(sumDebitUSD);
    amountCredUSD = parseFloat(sumCreditUSD);

    // var ioVal      = '<?php echo $_selectHeader->type_trans; ?>';
    // if(ioVal == "O" || ioVal == "o"){
    //     amountDebt  = parseFloat(sumDebit);
    //     amountCred  = parseFloat(sumCredit);

    /*amountDebt  = parseFloat(sumDebit + get2);
    amountCred  = parseFloat(sumCredit + get1);*/
    // }else{
    //     amountDebt  = parseFloat(sumDebit);
    //     amountCred  = parseFloat(sumCredit);

    /*amountDebt  = parseFloat(sumDebit + get1);
    amountCred  = parseFloat(sumCredit + get2);*/
    // }

    $('#inputAmountDebit').val(addCommas(amountDebt.toFixed(2)));
    $('#inputAmountCredit').val(addCommas(amountCred.toFixed(2)));

    $('#inputAmountDebitUSD').val(addCommas(amountDebtUSD.toFixed(2)));
    $('#inputAmountCreditUSD').val(addCommas(amountCredUSD.toFixed(2)));
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

  // ini untuk upload file
  function tambah_atch() {
    var num = 1;
    for (var i = 0; i < num; i++) {
      $('table[id="tabel-atch"]').append(`<tr>
          <td class="text-center">
            <button class="tombol" onclick="hapus_atch(this)" >Remove</button>
          </td>
          <td>
              <input type="file" name="file_atch[]" class="form-control" accept="application/pdf">
              <small class="text-danger">* only receive PDF file</small>
          </td>
            <td>
              <input type="text" name="remarks[]" value="" class="form-control" placeholder="input your remark here...">
          </td>
      </tr>`);
    }
  }

  function hapus_atch(btn) {
    var row = btn.parentNode.parentNode;
    row.parentNode.removeChild(row);
  }

  function hapus_atch_delete(btn) {

    var id = btn.getAttribute('data-file_id');

    var row = btn.parentNode.parentNode;
    row.parentNode.removeChild(row);

    // Confirmation prompt (optional)
    if (!confirm('Are you sure you want to delete this item?')) {
      return;
    }

    $.ajax({
      type: "post",
      url: "<?= site_url('CBtrans_zht/delete_file/') ?>",
      data: {
        id: id,
      },
      dataType: "json"
    });
  }
</script>