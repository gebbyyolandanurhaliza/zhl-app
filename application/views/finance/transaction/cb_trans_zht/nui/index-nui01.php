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

<div class="page-content">
  <div class="container-fluid">
    <div class="row">
      <form id="form-transCashBank" role="form" method="post" action="<?php echo site_url('CBtransNui/insertTransactionCB'); ?>" class="form-horizontal">

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
                        <label class="control-label col-sm-4">Reference Number</label>
                        <div class="col-sm-8">
                          <input type="text" id="inputNoReff" name="txtNoReff" placeholder="Auto Generate" maxlength="20" class="form-control input-sm" required readonly />
                          <span id="alert-errorReff" class="help-block" style="display: none;">Please use another num reff.! </span>
                        </div>
                      </div>
                      <script>
                        $('#inputNoReff').on('blur', function() {
                          var val = $('#inputNoReff').val();
                          $.ajax({
                            type: "POST",
                            url: "<?php echo base_url(); ?>CBtrans/cekNumReff",
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
                                /*$('#form-transCashBank').submit(function (){
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

                    </div>

                    <div class="col-sm-4">
                      <div class="form-group">
                        <label class="control-label col-sm-2">I/O Type</label>
                        <div class="col-sm-10">
                          <!-- <input type="text" id="txtInputIOtype" class="form-control input-sm"/> -->
                          <select class="form-control input-sm" name="txtIO" id="inputIOCest">
                            <option value="">Choose...</option>
                            <?php foreach ($_selectIOtype as $io) : ?>
                              <option value="<?php echo $io->io_code; ?>"><?php echo $io->io_description; ?></option>
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
                          <input id="txtInputDateTrans" name="txtDate1" type="text" class="form-control input-sm date-picker" data-date-format="dd-mm-yyyy" value="<?php //echo date('d-m-Y');
                                                                                                                                                                    ?>" data-yesterday="<?php echo date('d-m-Y',  mktime(0, 0, 0, date('m'), date('d') - 1, date('Y'))); ?>" data-now="<?php echo date('d-m-Y'); ?>" readonly>
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
                          <select class="form-control input-sm select2me" data-placeholder="Choose..." name="selCBCode" id="selInputCBCode" onchange="changeCodeCB(this)">
                            <option value=""></option>
                            <?php foreach ($_selectMasterCOA as $row) : ?>
                              <option value="<?php echo $row->NoCOA; ?>"><?php echo $row->NoCOA; ?> ~ <?php echo $row->AccountName; ?></option>
                            <?php endforeach; ?>
                          </select>
                        </div>
                      </div>
                      <script>
                        function changeCodeCB(val) {
                          var id = val.value;
                          //var noReff  = document.getElementById('inputNoReff').value;
                          var nameCOA = $('#selInputCBCode option:selected').text();
                          var pemisah = nameCOA.search("~");
                          var txtIO = $('#inputIOCest').val();
                          var txtCOA = nameCOA.substr(pemisah + 2);
                          var noCOA = nameCOA.substr(0, pemisah - 1);

                          if (txtIO === '' || txtIO === null) {
                            bootbox.alert('First choose IO Type!');
                            $('#selInputCBCode').val('');
                          } else {
                            $('#txtInputCOAsuppRow-1').val(noCOA);
                            $('#txtInputNameSuppRow-1').val(txtCOA);
                            $('#txtInputRemark').val(txtCOA);

                            //==============GST=========
                            $('#txtInputCOAsuppRow-GSTlast-2').val(noCOA);
                            $('#txtInputNameSuppRow-GSTlast-2').val(txtCOA);
                          }
                        }
                      </script>
                    </div>
                    <div class="col-sm-4">
                      <div class="form-group">
                        <div class="col-sm-12">
                          <input type="text" id="txtInputRemark" name="txtRemark" class="form-control input-sm hanya-baca" required />
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
                          <input type="text" id="txtInputKaryawanID" name="txtKaryawanID" placeholder="Employe ID" class="form-control input-sm" />
                        </div>
                        <div class="col-sm-4">
                          <input type="text" id="txtInputKaryawanName" name="txtKaryawanName" placeholder="Employe Name" class="form-control input-sm" readonly />
                        </div>
                        <div class="col-sm-2 display-none">
                          <input type="text" id="txtInputKaryawanCOA" name="txtKaryawanCOA" placeholder="Select COA" class="form-control input-sm" />
                        </div>
                        <div class="col-sm-4 display-none">
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
                            <option value="">Choose...</option>
                            <?php foreach ($_selectCurrency as $row) : ?>
                              <option value="<?php echo $row->currency_symbol; ?>"><?php echo $row->currency_id; ?></option>
                            <?php endforeach; ?>
                          </select>
                        </div>
                      </div>
                      <script>
                        $(document).ready(function() {
                          $('#txtInputCurr').on('change', function() {
                            var val = $(this).val();
                            var tgl = $('#txtInputDateTrans').val();
                            //alert('asasa = '+val);
                            if (!$('#txtInputDateTrans').val()) {
                              bootbox.alert('Input First Date Transaction!');
                              $(this).val('');
                            } else {
                              $.ajax({
                                type: "POST",
                                url: "<?php echo base_url(); ?>CBtrans/getRateByCurrency",
                                data: {
                                  txtCurrID: val,
                                  txtTglTrans: tgl
                                },
                                dataType: "json",
                                success: function(n) {
                                  var rUSD = parseFloat(n.rateUSD);
                                  var rSGD = parseFloat(n.rateSGD);
                                  $('#txtInputRate').val(addCommas(rUSD.toFixed(6)));
                                  $('#txtInputRateSGD').val(addCommas(rSGD.toFixed(6)));
                                }
                              });
                              $('#txtInputRate').focus();
                            }
                          });

                          $('.hanya-baca').on('keydown keypress keyup', false);
                        });
                      </script>
                    </div>
                    <div class="col-sm-12">
                      <div class="form-group">
                        <label class="control-label col-sm-3">Rate</label>
                        <div class="col-sm-9">
                          <input type="text" id="txtInputRate" name="txtRateCurr" onblur="javascript: checkGST();" class="form-control input-sm hanya-baca txtnumRate" data-m-dec="6" required />
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-12">
                      <div class="form-group">
                        <label class="control-label col-sm-3">Rate SGD</label>
                        <div class="col-sm-9">
                          <input type="text" id="txtInputRateSGD" name="txtRateCurrSGD" class="form-control input-sm hanya-baca txtnumRate" data-m-dec="6" required />
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="col-md-8">
                    <div class="form-group">
                      <label class="control-label col-sm-2">Transaction Remark </label>
                      <div class="col-sm-10">
                        <textarea name="txtTransRemark" class="form-control"></textarea>
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
                <a class="btn btn-circle green" id="btnAddCost" href="javascript:;">
                  Additional Cost
                </a>

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
                  <tr id="rowSetCOA">
                    <td class="text-center" style="vertical-align: middle;">
                      <button class="btn btn-xs btn-link biasa" type="button">
                        <i class="fa fa-arrow-down"></i></button>
                    </td>
                    <td nowrap><input type="text" name="txtNoCOA[]" id="txtInputCOAsuppRow-1" class="txt" value="" readonly /></td>
                    <td nowrap><input type="text" name="txtNameCOA[]" id="txtInputNameSuppRow-1" class="txt" value="" readonly /></td>
                    <td nowrap><input type="text" name="txtDebit[]" id="txtInputDebitCBdetailRow-1" onKeyup="calculateAmountDebit(); checkGST();" class="col-debit txt txtnum" /></td>
                    <td nowrap><input type="text" name="txtCredit[]" id="txtInputCreditCBdetailRow-1" onKeyup="calculateAmountCredit(); checkGST();" class="col-credit txt txtnum" /></td>
                    <td nowrap><input type="text" name="txtRemark[]" class="txt" /></td>
                    <td nowrap>
                      <select name="txtGST[]" class="txt gst-name display-none" onchange="checkGST()">
                        <option value=""> -- Select --</option>
                        <?php foreach ($_selectGST as $gst) : ?>
                          <option value="<?php echo $gst->gst_id; ?>"> <?php echo $gst->gst_name; ?></option>
                        <?php endforeach; ?>
                      </select>
                    </td>
                    <td nowrap><input id="txtInputGSTvalue1st" type="text" name="txtGSTvalue[]" class="txt txtnum gst-value display-none" /></td>
                  </tr>
                  <tr id="secendRowCashGeneral">
                    <td id="rowSelectCOArow2" class="text-center" style="vertical-align: middle;">
                      <button class="btn btn-xs btn-link baik" type="button" onclick="selectModalCOArow2();">
                        <i class="fa fa-arrow-right"></i></button>
                    </td>
                    <td nowrap><input id="txtInputCOAsuppRow-2" type="text" name="txtNoCOA[]" class="txt" value="" readonly required="" /></td>
                    <td nowrap><input id="txtInputNameSuppRow-2" type="text" name="txtNameCOA[]" class="txt" value="" readonly required="" /></td>
                    <td nowrap><input id="txtInputDebitRow-2" type="text" name="txtDebit[]" onKeyup="calculateAmountDebit(); checkGST();" class="col-debit txt txtnum" /></td>
                    <td nowrap><input id="txtInputCreditRow-2" type="text" name="txtCredit[]" onKeyup="calculateAmountCredit(); checkGST();" class="col-credit txt txtnum" /></td>
                    <td nowrap><input type="text" name="txtRemark[]" class="txt" /></td>
                    <td nowrap>
                      <select name="txtGST[]" class="txt gst-name" onchange="checkGST()">
                        <option value=""> -- Select --</option>
                        <?php foreach ($_selectGST as $gst) : ?>
                          <option value="<?php echo $gst->gst_id; ?>"> <?php echo $gst->gst_name; ?></option>
                        <?php endforeach; ?>
                      </select>
                    </td>
                    <td nowrap><input id="txtInputGSTvalue2nd" type="text" name="txtGSTvalue[]" class="txt txtnum gst-value" /></td>
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
                    <td nowrap>
                      <select name="txtGST[]" class="txt gst-name display-none" onchange="checkGST()">
                        <option value=""> -- Select --</option>
                        <?php foreach ($_selectGST as $gst) : ?>
                          <option value="<?php echo $gst->gst_id; ?>"> <?php echo $gst->gst_name; ?></option>
                        <?php endforeach; ?>
                      </select>
                    </td>
                    <td nowrap><input id="txtInputGSTvalue1st" type="text" name="txtGSTvalue[]" class="txt txtnum gst-value display-none" /></td>
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
                    <td nowrap>
                      <select name="txtGST[]" class="txt gst-name display-none" onchange="checkGST()">
                        <option value=""> -- Select --</option>
                        <?php foreach ($_selectGST as $gst) : ?>
                          <option value="<?php echo $gst->gst_id; ?>"> <?php echo $gst->gst_name; ?></option>
                        <?php endforeach; ?>
                      </select>
                    </td>
                    <td nowrap><input id="txtInputGSTvalue1st" type="text" name="txtGSTvalue[]" class="txt txtnum gst-value display-none" /></td>
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
                    <td nowrap>
                      <select name="txtGST[]" class="txt gst-name display-none" onchange="checkGST()">
                        <option value=""> -- Select --</option>
                        <?php foreach ($_selectGST as $gst) : ?>
                          <option value="<?php echo $gst->gst_id; ?>"> <?php echo $gst->gst_name; ?></option>
                        <?php endforeach; ?>
                      </select>
                    </td>
                    <td nowrap><input id="txtInputGSTvalue1st" type="text" name="txtGSTvalue[]" class="txt txtnum gst-value display-none" /></td>
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
                      <input class="form-control txtnum" name="txtAmountDebit" id="inputAmountDebit" type="text" readonly="" />
                      <input id="sumGST-1" type="hidden" readonly="" />
                    </div>
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="form-group">
                    <label class="col-sm-12" for="">Amount Credit</label>
                    <div class="col-sm-12">
                      <input class="form-control txtnum" name="txtAmountCredit" id="inputAmountCredit" type="text" readonly="" />
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
            <div class="portlet-body">
              <div class="row">
                <div class="col-md-6">
                  <button class="btn btn-sm btn-primary" id="btnFindRecord" type="button">
                    Find <i class="fa fa-sm fa-search fa-fw" aria-hidden="true"></i> </button>
                  <button class="btn btn-sm btn-default disabled display-none" id="btnPrint" type="button">
                    Print <i class="fa fa-sm fa-print fa-fw" aria-hidden="true"></i></button>
                </div>
                <div class="col-md-6 text-right">
                  <button class="simpan btn btn-sm btn-success" onclick="return checkEqual()" type="submit">
                    <i class="fa fa-save"></i> Submit
                  </button>
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
                  <button class="btn btn-sm btn-neutral" type="reset" onclick="javascript: location.reload();">
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

<!-- Select COA in Detail -->
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

<!-- Select COA in Detail ROW #2 -->
<div class="modal fade" id="modal-MCOA-row2" tabindex="-1" role="basic" aria-hidden="true">
  <div class="modal-dialog" style="width: 75%;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title">Select Master COA</h4>
      </div>
      <div class="modal-body">
        <div id="contentMasterCOA-row2"></div>
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

<!-- Select Employee -->
<div class="modal fade" id="modal-employee" tabindex="-1" role="basic" aria-hidden="true">
  <div class="modal-dialog" style="width: 50%;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title">Select Employee</h4>
      </div>
      <div class="modal-body">
        <div id="contentEmployee"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn default" data-dismiss="modal">Close</button>
      </div>
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
    $('.ismo-supp-group').attr('readonly', true);
    $('.ismo-cust-group').attr('readonly', true);
    $('.hanya-baca').on('keydown keypress keyup', false);
    // $('.txtnum').autoNumeric('init');
    $('.txtnum').blur(function() {
      var val = parseFloat($(this).val().replace(/,/g, ''));
      if (!val) {
        var vall = 0;
      } else {
        vall = val;
      }
      $(this).val(addCommas(vall.toFixed(2)));
      calculateAmountCredit();
      calculateAmountDebit();
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
      calculateAmountCredit();
      calculateAmountDebit();
      checkGST();
    });

    //============= Auto Num Reff===============
    $('#txtInputDateTrans, #txtInputCurr, #txtInputRate, #inputIOCest').on('change blur', function() {
      if ($('#txtInputDateTrans').val() && $('#txtInputRate').val() && $('#poTXTtypeIO').val()) {
        setInterval(function() {
          $.post("<?php echo base_url(); ?>CBtrans/newGenerateReffNumber", {
            txtTypeForGen: $('#poTXTtypeIO').val(),
            txtCurrForGen: $('#txtInputCurr').val(),
            txtDateForGen: $('#txtInputDateTrans').val()
          }, function(data, statuss) {
            $('#inputNoReff').val(data);
          });
        }, 2000);
      }
    });

    $('#txtInputDateTrans').on('change', function() {
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
          $(this).val('<?php //echo date('d-m-Y'); 
                        ?>');
      }*/
    });

    $("#btn-generate-noreff").click(function() {
      $.ajax({
        url: "<?php echo site_url('CBtrans/generateReffNumCB'); ?>",
        dataType: 'json',
        success: function(gen) {
          $('#inputNoReff').val(gen);
          $('#inputNoReff').focus();
          //$('#inputNoReff').attr('readonly', true);
        }
      });
    });

    $('#inputIOCest').on('change', function() {
      var ioType = $(this).val();
      $.post("<?php echo base_url(); ?>CBtrans/getIOtypeTransByCode", {
        selectIOtype: ioType
      }, function(data, statuss) {
        if (data == 'O') {
          $('#txtInputDebitRow-2').attr('readonly', false);
          $('#txtInputCreditRow-2').attr('readonly', true);

          $('#txtInputDebitCBdetailRow-1').attr('readonly', true);
          $('#txtInputCreditCBdetailRow-1').attr('readonly', false);
          $('#poTXTtypeIO').val('O');

          $('#txtInputDebitCBdetailRow-addCostRow-1').attr('readonly', true);
          $('#txtInputCreditCBdetailRow-addCostRow-1').attr('readonly', false);

          $('#txtInputGSTvalue2nd').removeClass('gst-value-credit');
          $('#txtInputGSTvalue2nd').addClass('gst-value-debit');

          $('#txtInputGSTvalue1st').removeClass('gst-value-debit');
          $('#txtInputGSTvalue1st').addClass('gst-value-credit');

          //==============GST=========
          $('#txtInputCOAsuppRow-GSTlast-1').val('140601');
          $('#txtInputNameSuppRow-GSTlast-1').val('GST Input Tax');

          $('#txtInputDebitCBdetailRow-addCostRow-1').removeClass('col-debit');
        } else if (data == 'I') {
          $('#txtInputDebitRow-2').attr('readonly', true);
          $('#txtInputCreditRow-2').attr('readonly', false);

          $('#txtInputDebitCBdetailRow-1').attr('readonly', false);
          $('#txtInputCreditCBdetailRow-1').attr('readonly', true);
          $('#poTXTtypeIO').val('I');

          $('#txtInputDebitCBdetailRow-addCostRow-1').attr('readonly', false);
          $('#txtInputCreditCBdetailRow-addCostRow-1').attr('readonly', true);

          $('#txtInputGSTvalue2nd').addClass('gst-value-credit');
          $('#txtInputGSTvalue2nd').removeClass('gst-value-debit');

          $('#txtInputGSTvalue1st').addClass('gst-value-debit');
          $('#txtInputGSTvalue1st').removeClass('gst-value-credit');

          //==============GST=========
          $('#txtInputCOAsuppRow-GSTlast-1').val('200801');
          $('#txtInputNameSuppRow-GSTlast-1').val('GST Output Tax');

          $('#txtInputDebitCBdetailRow-addCostRow-1').addClass('col-debit');
        }
      });
    });

    // == Select Master COA
    $("#btnSelectMCOA").click(function() {
      if ($('#modal-MCOA').hasClass('ismo-has-modal')) {
        $('#modal-MCOA').modal('show');
      } else {
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
        $('#modal-MCOA').addClass('ismo-has-modal');
      }
    });

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

    // == Select Master COA Karyawan txtInputKaryawanCOA
    $("#txtInputKaryawanCOA").click(function() {
      if ($('#modal-MCOA').hasClass('ismo-has-modal')) {
        $('#modal-MCOA').modal('show');
      } else {
        $.ajax({
          url: "<?php echo site_url('CBtransNui/selectCOA'); ?>",
          type: "POST",
          datatype: "json",
          cache: false,
          success: function(respon) {
            $('#contentMasterCOA').html(respon);
          }
        });
        $('#modal-MCOA').modal('show');
        $('#modal-MCOA').addClass('ismo-has-modal');
      }
    });
    // == Select Master COA Karyawan txtInputKaryawanCOA
    $("#txtInputKaryawanID").on('click', function() {
      $.ajax({
        url: "<?php echo site_url('CBtransNui/selectEmployee'); ?>",
        type: "POST",
        datatype: "json",
        cache: false,
        success: function(respon) {
          $('#contentEmployee').html(respon);
        }
      });
      $('#modal-employee').modal('show');
    });

    // ===== ## Find AP Payment ## =====
    $("#btnFindRecord").click(function() {
      $.post("<?php echo site_url(); ?>CBtransNui/selectCashBank", function(data) {
        $('#contentFindCB').html(data);
      });
      $('#modal-findCB').modal('show');
    });

    $("#form-transCashBank").submit(function(e) {
      var currentForm = this;
      e.preventDefault();

      /*var amountPayment   = $('#inputAmountDebit').val();
      var numberBank      = $('#txtInputCOAsuppRow-1').val();
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

    });
  });
</script>
<script type="text/javascript">
  function selectModalCOArow2() {
    $.ajax({
      url: "<?php echo site_url('CBtrans/selectCOArow2'); ?>",
      type: "POST",
      datatype: "json",
      cache: false,
      success: function(respon) {
        $('#contentMasterCOA-row2').html(respon);
      }
    });
    $('#modal-MCOA-row2').modal('show');
  }

  function Pilih_MCOArow2(x) {
    function getText(el) {
      if (typeof el.textContent === 'string') return el.textContent;
      if (typeof el.innerText === 'string') return el.innerText;
    }

    var $r = x.rowIndex;
    var noCoa = getText(document.getElementById('tbl-MasterCOA-row2').rows[$r].cells[0]);
    var nameCOA = getText(document.getElementById('tbl-MasterCOA-row2').rows[$r].cells[1]);

    $('#txtInputCOAsuppRow-2').val(noCoa);
    $('#txtInputNameSuppRow-2').val(nameCOA);

    $('#modal-MCOA-row2').modal('hide');
  }

  /*function Pilih_MCOA(x){
      function getText(el){
          if (typeof el.textContent === 'string') return el.textContent;
          if (typeof el.innerText === 'string') return el.innerText;
      }
      var $r      = x.rowIndex;
      var coaNum  = getText(document.getElementById('tbl-MasterCOA').rows[$r].cells[0]);
      var coaName = getText(document.getElementById('tbl-MasterCOA').rows[$r].cells[1]);
      
      $('#txtInputKaryawanCOA').val(coaNum);
      $('#txtInputKaryawanCOAname').val(coaName);
      $('#txtInputCOAsuppRow-2').val(coaNum);
      $('#txtInputNameSuppRow-2').val(coaName);
      
      $('#modal-MCOA').modal('hide');
  }*/
  function Pilih_MCOAforAddCost(x) {
    function getText(el) {
      if (typeof el.textContent === 'string') return el.textContent;
      if (typeof el.innerText === 'string') return el.innerText;
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
                            <td nowrap><input type="text" name="txtDebit[]" onKeyup="calculateAmountDebit(); checkGST();" class="ac-col-debit txt txtnum ' + cls + 'xx" /></td>\n\
                            <td nowrap><input type="text" name="txtCredit[]" readonly onKeyup="calculateAmountDebit(); checkGST();" class="ac-col-credit txt txtnum ' + cls + 'xx"/></td>\n\
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
                calculateAmountCredit();
                calculateAmountDebit();
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
                            <td nowrap><input type="text" name="txtDebit[]" readonly onKeyup="calculateAmountDebit(); checkGST();" class="ac-col-debit txt txtnum ' + cls + 'xx" /></td>\n\
                            <td nowrap><input type="text" name="txtCredit[]" onKeyup="calculateAmountDebit(); checkGST();" class="ac-col-credit txt txtnum ' + cls + 'xx"/></td>\n\
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
                calculateAmountCredit();
                calculateAmountDebit();
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
      if (typeof el.textContent === 'string') return el.textContent;
      if (typeof el.innerText === 'string') return el.innerText;
    }

    bootbox.dialog({
      message: "What would you do?",
      buttons: {
        pay: {
          label: "Debit",
          className: "green btn-sm",
          callback: function() {
            var $r = x.rowIndex;
            var cls = getText(document.getElementById('tbl-MasterCOA').rows[$r].cells[4]);
            var typeIO = $('#poTXTtypeIO').val();

            $('table[id="tbl-cashGeneral"]').append('<tr class="' + cls + ' added-row-ismo">\n\
                            <td class="text-center" style="vertical-align: middle;">\n\
                                <button class="btn btn-xs btn-link buruk" type="button" onclick="delete_MCOA(this)"><i class="fa fa-trash-o"></i></button></td>\n\
                            <td nowrap><input type="text" name="txtNoCOA[]"  class="txt" value="' + getText(document.getElementById('tbl-MasterCOA').rows[$r].cells[0]) + '" readonly/></td>\n\
                            <td nowrap><input type="text" name="txtNameCOA[]" class="txt" value="' + getText(document.getElementById('tbl-MasterCOA').rows[$r].cells[1]) + '" readonly/></td>\n\
                            <td nowrap><input type="text" name="txtDebit[]" onKeyup="calculateAmountDebit(); checkGST();" class="col-debit txt txtnum ' + cls + 'qq" /></td>\n\
                            <td nowrap><input type="text" name="txtCredit[]" readonly onKeyup="calculateAmountCredit(); checkGST();" class="col-credit txt txtnum ' + cls + 'qq"/></td>\n\
                            <td nowrap><input type="text" name="txtRemark[]" class="txt"/></td>\n\
                            <td nowrap class="cls-gst"><input type="text" name="txtGST[]" class="txt"/></td>\n\
                            <td nowrap><input type="text" name="txtGSTvalue[]" class="txt txtnum gst-value gst-value-debit"/></td>\n\
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
                calculateAmountCredit();
                calculateAmountDebit();
                checkGST();
              });

              $.ajax({
                url: "<?php echo base_url(); ?>CBtrans/addGST",
                dataType: 'html',
                success: function(data) {
                  $('.cls-gst').html(data);
                }
              });
            });
          }
        },
        review: {
          label: "Credit",
          className: "blue btn-sm",
          callback: function() {
            var $r = x.rowIndex;
            var cls = getText(document.getElementById('tbl-MasterCOA').rows[$r].cells[4]);
            var typeIO = $('#poTXTtypeIO').val();

            $('table[id="tbl-cashGeneral"]').append('<tr class="' + cls + ' added-row-ismo">\n\
                            <td class="text-center" style="vertical-align: middle;">\n\
                                <button class="btn btn-xs btn-link buruk" type="button" onclick="delete_MCOA(this)"><i class="fa fa-trash-o"></i></button></td>\n\
                            <td nowrap><input type="text" name="txtNoCOA[]"  class="txt" value="' + getText(document.getElementById('tbl-MasterCOA').rows[$r].cells[0]) + '" readonly/></td>\n\
                            <td nowrap><input type="text" name="txtNameCOA[]" class="txt" value="' + getText(document.getElementById('tbl-MasterCOA').rows[$r].cells[1]) + '" readonly/></td>\n\
                            <td nowrap><input type="text" name="txtDebit[]" readonly onKeyup="calculateAmountDebit(); checkGST();" class="col-debit txt txtnum ' + cls + 'qq" /></td>\n\
                            <td nowrap><input type="text" name="txtCredit[]" onKeyup="calculateAmountCredit(); checkGST();" class="col-credit txt txtnum ' + cls + 'qq"/></td>\n\
                            <td nowrap><input type="text" name="txtRemark[]" class="txt"/></td>\n\
                            <td nowrap class="cls-gst"><input type="text" name="txtGST[]" class="txt"/></td>\n\
                            <td nowrap><input type="text" name="txtGSTvalue[]" class="txt txtnum gst-value gst-value-credit"/></td>\n\
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
                calculateAmountCredit();
                calculateAmountDebit();
                checkGST();
              });

              $.ajax({
                url: "<?php echo base_url(); ?>CBtrans/addGST",
                dataType: 'html',
                success: function(data) {
                  $('.cls-gst').html(data);
                }
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

  function delete_MCOA(x) {
    var row = x.parentNode.parentNode;
    bootbox.confirm("Are you sure?", function(result) {
      if (result == true) {
        row.parentNode.removeChild(row);

        checkGST();

        $('#txtInputRateUSD').focus();
      }
    });
  }

  function Pilih_Employee(x) {
    function getText(el) {
      if (typeof el.textContent === 'string') return el.textContent;
      if (typeof el.innerText === 'string') return el.innerText;
    }
    var $r = x.rowIndex;
    var emNum = getText(document.getElementById('tbl-selectEmployee').rows[$r].cells[0]);
    var emName = getText(document.getElementById('tbl-selectEmployee').rows[$r].cells[1]);

    $("#txtInputKaryawanID").val(emNum);
    $("#txtInputKaryawanName").val(emName);

    $('#modal-employee').modal('hide');
  }

  // ==## Calculate Balance Table ##==
  function calculateAmountDebit() {
    var sumAmount = 0;
    $(".col-debit").each(function() {
      var valBtot = this.value;
      var newBtot = parseFloat(valBtot.replace(/,/g, ''));
      if (!isNaN(newBtot) && this.value.length !== 0) {
        sumAmount += parseFloat(newBtot);
      }
    });
    $('#inputAmountDebit').val(addCommas(sumAmount.toFixed(2)));

    /*var a   = document.getElementById('inputAmountDebit').value;
    var b   = document.getElementById('inputAmountCredit').value;
    if( a !== b){
        $('#alert-balanceAmount').css('display', 'block');
        return false;
    }else{
        $('#alert-balanceAmount').css('display', 'none');
    }*/
  }

  function calculateAmountCredit() {
    var sumAmount = 0;
    $(".col-credit").each(function() {
      var valBtot = this.value;
      var newBtot = parseFloat(valBtot.replace(/,/g, ''));
      if (!isNaN(newBtot) && this.value.length !== 0) {
        sumAmount += parseFloat(newBtot);
      }
    });
    $('#inputAmountCredit').val(addCommas(sumAmount.toFixed(2)));

    /*var a   = document.getElementById('inputAmountDebit').value;
    var b   = document.getElementById('inputAmountCredit').value;
    if( a !== b){
        $('#alert-balanceAmount').css('display', 'block');
        return false;
    }else{
        $('#alert-balanceAmount').css('display', 'none');
    }*/
  }

  function checkGST() {
    var gst_type = document.getElementsByClassName('gst-name');
    var debit_txt = document.getElementsByClassName('col-debit');
    var credit_txt = document.getElementsByClassName('col-credit');
    var gst_value = document.getElementsByClassName('gst-value');
    var rateSGD = parseFloat($('#txtInputRateSGD').val().replace(/,/g, ''));

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
    var forGSTusd = parseFloat($('#txtInputRate').val().replace(/,/g, ''));
    var forGSTsgd = parseFloat($('#txtInputRateSGD').val().replace(/,/g, ''));

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
    /*if($('#poTXTtypeIO').val() == "O" || $('#poTXTtypeIO').val() == "o"){
        amountDebt  = sumAmountD + parseFloat($('#sumGST-2').val());
        amountCred  = sumAmountC + parseFloat($('#sumGST-1').val());
        $('#inputAmountDebit').val(addCommas(amountDebt.toFixed(2)));
        $('#inputAmountCredit').val(addCommas(amountCred.toFixed(2)));
    }else{
        amountDebt  = sumAmountD + parseFloat($('#sumGST-1').val());
        amountCred  = sumAmountC + parseFloat($('#sumGST-2').val());
        $('#inputAmountDebit').val(addCommas(amountDebt.toFixed(2)));
        $('#inputAmountCredit').val(addCommas(amountCred.toFixed(2)));
    }*/

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
      /*var xxxCredit   = sumAmountD-(creGST+sumACcredit+creBank);
      $('#txtInputCreditCBdetailRow-addCostRow-1').val(addCommas(xxxCredit.toFixed(2)));*/
      var xxxCredit = (sumAmountC + sumACcredit) - sumAmountD;
      $('#txtInputDebitCBdetailRow-addCostRow-1').val(addCommas(xxxCredit.toFixed(2)));

      amountDebt = sumAmountD + xxxCredit;
      amountCred = sumAmountC + sumACcredit;
    } else {
      //alert(parseFloat($('#txtInputDebitCBdetailRow-GSTlast-2').val()));
      var debGST = parseFloat($('#txtInputDebitCBdetailRow-GSTlast-2').val().replace(/,/g, ''));
      var debBank = parseFloat($('#txtInputDebitCBdetailRow-1').val().replace(/,/g, ''));
      var xxxDebit = sumAmountC - (debGST + sumACdebit + debBank);
      $('#txtInputDebitCBdetailRow-addCostRow-1').val(addCommas(xxxDebit.toFixed(2)));

      amountDebt = sumAmountD + sumACdebit;
      amountCred = sumAmountC;
    }

    /*amountDebt  = sumAmountD + parseFloat($('#sumGST-1').val());
    amountCred  = sumAmountC + parseFloat($('#sumGST-2').val());*/
    $('#inputAmountDebit').val(addCommas(amountDebt.toFixed(2)));
    $('#inputAmountCredit').val(addCommas(amountCred.toFixed(2)));


    if (amountDebt !== amountCred) {
      $('#alert-balanceAmount').css('display', 'block');
      return false;
    } else {
      $('#alert-balanceAmount').css('display', 'none');
    }
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