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

      <form role="form" method="post" id="form-downPaymentAP" action="<?php echo base_url(); ?>DownPaymentAP/insertDownPayment" class="form-horizontal">
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
                <span class="caption-subject bold uppercase"> AP Down Payment</span>
                <span class="caption-helper"> Payable Recognation</span>
              </div>
              <div class="tools">
                <a href="javascript:;" class="collapse">
                </a>
              </div>
              <div class="actions">
                <a class="btn btn-circle btn-primary" href="<?php echo site_url(); ?>">
                  <i class="fa fa-list"></i> Look List</a>
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
                      <input type="text" id="txtInputNoReff" name="txtNoReff" placeholder="Auto Generate" readonly class="form-control input-sm" />
                      <span id="alert-errorReff" class="help-block" style="display: none;">Please use another num reff.! </span>
                    </div>
                  </div>
                  <script>
                    $('#txtInputNoReff').on('blur', function() {
                      var val = $('#txtInputNoReff').val();
                      $.ajax({
                        type: "POST",
                        url: "<?php echo base_url(); ?>DownPaymentAP/cekNumReffDeposit",
                        data: {
                          value: val
                        },
                        dataType: "json",
                        success: function(n) {
                          if (n === 1) {
                            $('#div-ReffNum').addClass('has-error');
                            document.getElementById('alert-errorReff').style.display = 'block';
                          } else {
                            $('#div-ReffNum').removeClass('has-error');
                            $('#div-ReffNum').addClass('has-success');
                            document.getElementById('alert-errorReff').style.display = 'none';
                          }
                        }
                      });
                    });
                  </script>

                  <div class="form-group">
                    <label class="control-label col-sm-3">Vendor</label>
                    <div class="col-sm-3">
                      <input type="text" style="background-color: #D2E0D1;" id="txtInputIdVendor" name="txtIdVendor" class="form-control input-sm" />
                      <input type="hidden" id="txtInputVendorCOA" name="txtVendorCOA" />
                    </div>
                    <div class="col-sm-6">
                      <input type="text" style="background-color: #D2E0D1;" id="txtInputVendor" name="txtVendor" class="form-control input-sm" />
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="control-label col-sm-3">C/B Code</label>
                    <div class="col-sm-9">

                      <input id="selInputCBCode" style="background-color: #D2E0D1;" type="text" name="selCBCode" class="form-control input-sm back-null-inv" required />

                    </div>
                  </div>

                  <div class="form-group">
                    <label class="control-label col-sm-3">Currency</label>
                    <div class="col-sm-9">
                      <select class="form-control input-sm" id="selInputCurrency" name="selCurrency" style="background-color: #D2E0D1;">
                        <option value=""></option>
                        <?php foreach ($_selectCurrency as $row) : ?>
                          <option value="<?php echo $row->currency_symbol; ?>"><?php echo $row->currency_id; ?></option>
                        <?php endforeach; ?>
                      </select>
                    </div>
                    <script>
                      $(document).ready(function() {
                        $('#selInputCurrency,#txtInputTglTrans').on('change', function() {
                          var val = $('#selInputCurrency').val();
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
                              $('#txtInputRateSGD').val(addCommas(rSGD.toFixed(6)));

                              $('.jr_rate').val(addCommas(rUSD.toFixed(6)));
                            }
                          });
                          $('#txtInputRateUSD').focus();
                        });

                        $('.hanya-baca').on('keydown keypress keyup', false);
                      });
                    </script>
                  </div>

                  <div class="form-group">
                    <label class="control-label col-sm-3">Total</label>
                    <div class="col-sm-9">
                      <input type="text" id="txtInputTotal" name="txtTotal" class="form-control input-sm txtnum" required />
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="control-label col-sm-3">Cheque Number</label>
                    <div class="col-sm-9">
                      <input type="text" id="txtInputChequeNumber" name="txtChequeNumber" class="form-control input-sm" required />
                    </div>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label col-sm-4">Rate USD</label>
                      <div class="col-sm-8">
                        <input type="text" id="txtInputRateUSD" name="txtRateCurr" onblur="javascript: countSecend();" class="form-control input-sm hanya-baca txtnumRate" required />
                      </div>
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label col-sm-4">Rate SGD</label>
                      <div class="col-sm-8">
                        <input type="text" id="txtInputRateSGD" name="txtRateCurrSGD" class="form-control input-sm hanya-baca txtnumRate" required />
                      </div>
                    </div>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label col-sm-4">Date of Journal</label>
                      <div class="col-sm-8">
                        <input id="txtInputTglTrans" name="txtTransDate" value="<?php echo date('d-m-Y'); ?>" type="text" class="form-control input-sm date-picker" data-date-format="dd-mm-yyyy">
                      </div>
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label col-sm-4">Invoice Date</label>
                      <div class="col-sm-8">
                        <input id="txtInputTglTransInv" name="txtTransDateInv" value="<?php echo date('d-m-Y'); ?>" type="text" class="form-control input-sm date-picker" data-date-format="dd-mm-yyyy">
                      </div>
                    </div>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label class="control-label col-sm-2">Account Name</label>
                      <div class="col-sm-10">
                        <input id="nameCB" type="text" name="txtNameCB" class="form-control input-sm back-null-inv" readonly />
                      </div>
                    </div>
                  </div>


                </div>
                <div class="col-md-6">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label col-sm-4">Term (days)</label>
                      <div class="col-sm-8">
                        <input id="txtInputJangkaTempo" type="text" value="0" name="txtTermDay" class="form-control input-sm" required />
                      </div>
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label col-sm-4">Deu Date</label>
                      <div class="col-sm-8">
                        <input id="txtInputTglJatuhTempo" name="txtDeuDate" value="<?php echo date('d-m-Y'); ?>" type="text" class="form-control input-sm date-picker" data-date-format="dd-mm-yyyy">
                      </div>
                    </div>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label class="control-label col-sm-2">Remark</label>
                      <div class="col-sm-10">
                        <textarea id="txtInputRemark" name="txtRemark" class="form-control" onkeyup="$('#inputDesc1').val($(this).val());"></textarea>
                      </div>
                    </div>
                  </div>
                </div>

              </div>

            </div>
          </div>
        </div>

        <div class="col-md-12 display-none">
          <div class="portlet light">
            <div class="portlet-body">
              <div class="row">
                <div class="col-md-12">
                  <a class="btn green" id="btnSelectMCOA" href="javascript:;" title="Serch COA number">
                    <i class="fa fa-search"></i> Add Detail With COA
                  </a>
                  <a class="btn btn-success btn-add" onclick="tambah_baris()">
                    <i class="fa fa-plus-circle"></i> Add Detail
                  </a>
                </div>
                <hr>

                <div class="col-md-12 table-responsive" style="padding-bottom: 15px;">
                  <table class="table-ismo" id="tbl-detail-invoice">
                    <thead>
                      <tr>
                        <th class="text-center" style="width: 42px;">
                          <button id="btnSelectInvoice" class="btn btn-xs btn-link baik" type="button">
                            <i class="fa fa-search"></i></button></td>
                        </th>
                        <th>PO Number</th>
                        <th>ARGL Account</th>
                        <th>Items</th>
                        <th>Qty</th>
                        <th>Unit</th>
                        <th>Price</th>
                        <th>Amount</th>
                        <th>USD Equivalent</th>
                        <th>GST Type</th>
                        <th>PO GST Value (SDG)</th>
                      </tr>
                    </thead>
                    <tbody>

                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-md-12">
          <div class="portlet light">
            <div class="portlet-body">
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
                        <th>Total</th>
                        <th>Rate</th>
                        <th>Debt</th>
                        <th>Credit</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td></td>
                        <td><input type="text" id="inputNoCOA1" name="no_coa[]" class="no_coa txt" autocomplete="off"></td>
                        <td><input type="text" id="dk1" name="dk[]" class="dk txt40" value="C"></td>
                        <td><input type="text" id="inputTypeJurnal1" name="JenisJurnal[]" class="txt"></td>
                        <td><input type="text" id="inputDesc1" name="desc[]" class=" txt"></td>
                        <td class="total"><input type="text" id="inputTotal1" name="total_jr[]" class="txt txtnum number jur_total" onkeypress="return isNumber(event)"></td>
                        <td><input type="text" name="rate_jr[]" id="inputRate1" class="txt txtnum number jr_rate" onkeypress="return isNumber(event)"></td>
                        <td><input type="text" name="debt_jr[]" id="inputDebt1" class="txt txtnum number jur_deb" onkeypress="return isNumber(event)"></td>
                        <td><input type="text" name="credit_jr[]" id="inputCredit1" class="txt txtnum number jur_credit" onkeypress="return isNumber(event)"></td>
                      </tr>
                      <tr>
                        <td></td>
                        <td><input type="text" id="inputNoCOA2" name="no_coa[]" class="no_coa txt" autocomplete="off"></td>
                        <td><input type="text" id="dk2" name="dk[]" class="dk txt40" value="D"></td>
                        <td><input type="text" id="inputTypeJurnal2" name="JenisJurnal[]" class="txt"></td>
                        <td><input type="text" id="inputDesc2" name="desc[]" class=" txt"></td>
                        <td class="total"><input type="text" id="inputTotal2" name="total_jr[]" class="txt txtnum number no-ro jur_total" onkeypress="return isNumber(event)"></td>
                        <td><input type="text" name="rate_jr[]" id="inputRate2" class="txt txtnum number jr_rate" onkeypress="return isNumber(event)"></td>
                        <td><input type="text" name="debt_jr[]" id="inputDebt2" class="txt txtnum number jur_deb" onkeypress="return isNumber(event)"></td>
                        <td><input type="text" name="credit_jr[]" id="inputCredit2" class="txt txtnum number jur_credit" onkeypress="return isNumber(event)"></td>
                      </tr>
                      <tr>
                        <td></td>
                        <td><input type="text" id="inputNoCOA3" name="no_coa[]" class="no_coa txt" value="610001" autocomplete="off"></td>
                        <td><input type="text" id="dk3" name="dk[]" class="dk txt40" value="D"></td>
                        <td><input type="text" id="inputTypeJurnal3" name="JenisJurnal[]" value="Bank Charges" class="txt"></td>
                        <td><input type="text" id="inputDesc3" name="desc[]" class=" txt"></td>
                        <td class="total"><input type="text" id="inputTotal3" name="total_jr[]" class="txt txtnum number jur_total" onkeypress="return isNumber(event)"></td>
                        <td><input type="text" name="rate_jr[]" id="inputRate3" class="txt txtnum number jr_rate" onkeypress="return isNumber(event)"></td>
                        <td><input type="text" name="debt_jr[]" id="inputDebt3" class="txt txtnum number jur_deb" onkeypress="return isNumber(event)"></td>
                        <td><input type="text" name="credit_jr[]" id="inputCredit3" class="txt txtnum number jur_credit" onkeypress="return isNumber(event)"></td>
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
                  <button class="simpan btn btn-sm btn-success" type="submit">
                    <i class="fa fa-save"></i> Submit
                  </button>
                  <button class="btn btn-sm btn-neutral" type="reset" onclick="javascript: location.reload();">
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

<!-- Select MasterCoa -->
<div class="modal fade" id="modal-MCOA2" tabindex="-1" role="basic" aria-hidden="true">
  <div class="modal-dialog" style="width: 75%;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title">Select Master COA</h4>
      </div>
      <div class="modal-body">
        <div id="content-contentMasterCOA"></div>
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
    $('#txtInputTglTrans, #selInputCurrency, #txtInputRateUSD').on('change blur', function() {
      if ($('#txtInputTglTrans').val() && $('#txtInputRateUSD').val()) {
        setInterval(function() {
          $.get("<?php echo base_url(); ?>APtransNew/newGenerateReffNumber", {
            txtTypeForGen: 'OUT',
            txtCurrForGen: $('#selInputCurrency').val(),
            txtDateForGen: $('#txtInputTglTrans').val()
          }, function(data, statuss) {
            $('#txtInputNoReff').val(data);
          });
        }, 2000);
      }
    });

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


    //Select COA
    $("#selInputCBCode").click(function() {
      $.ajax({
        url: "<?php echo site_url('DownPaymentAP/selectCOA'); ?>",
        type: "POST",
        datatype: "json",
        cache: false,
        success: function(respon) {
          $('#content-contentMasterCOA').html(respon);
        }
      });
      $('#modal-MCOA2').modal('show');

    });
    //Select Vendor
    $("#txtInputVendor, #txtInputIdVendor").click(function() {
      $.ajax({
        url: "<?php echo site_url('DownPaymentAP/selectSupplierForDP'); ?>",
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
    });

    $('#txtInputRateUSD').on('blur', function() {
      calculateTotal();
      countBankCharge();
    });

    //================ FInd
    $('#btnFindRecord').click(function() {
      $.post("<?php echo site_url(); ?>DownPaymentAP/selectDepositAP", function(data) {
        $('#contentFindDeposit').html(data);
      });

      $('#modal-findDeposit').modal('show');
    });

    $("#form-downPaymentAP").submit(function(e) {
      var currentForm = this;
      e.preventDefault();
      if ($('#div-ReffNum').hasClass('has-error')) {
        $('#txtInputNoReff').focus();
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

<script type="text/javascript">
  function changeCodeCB(val) {
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
      if (typeof el.textContent === 'string')
        return el.textContent;
      if (typeof el.innerText === 'string')
        return el.innerText;
    }

    $r = x.rowIndex;

    //== Set value header COA
    $('#selInputCBCode').val(getText(document.getElementById('tbl-MasterCOA').rows[$r].cells[0]));
    $('#inputNoCOA1').val(getText(document.getElementById('tbl-MasterCOA').rows[$r].cells[0]));
    $('#inputTypeJurnal1').val(getText(document.getElementById('tbl-MasterCOA').rows[$r].cells[1]));
    $('#nameCB').val(getText(document.getElementById('tbl-MasterCOA').rows[$r].cells[1]));
    $('#selInputCurrency').val(getText(document.getElementById('tbl-MasterCOA').rows[$r].cells[3]));


    //== Set cash detail
    /*var toUSD = $('#inputUSDRow1').val();
     $('#inputUSDRow3').val(toUSD);
     $('#txtCOADetailRow3').val(getText(document.getElementById('tbl-MasterCOA').rows[$r].cells[0]));
     $('#txtInputRemarkDetail3th').val(getText(document.getElementById('tbl-MasterCOA').rows[$r].cells[1]));*/

    //== +++++++++++++++++++++++++ ==
    var val = getText(document.getElementById('tbl-MasterCOA').rows[$r].cells[3]);

    var tgl = $('#txtInputTglTrans').val();
    if (val != 'ALL') {
      $.post("<?php echo site_url('CBtrans/getRateByCurrency'); ?>", {
        txtCurrID: val,
        txtTglTrans: tgl
      }, function(data, success) {
        var get = $.parseJSON(data);
        var rUSD = parseFloat(get.rateUSD);
        var rSGD = parseFloat(get.rateSGD);
        $('#txtInputRateUSD').val(addCommas(rUSD.toFixed(6)));
        $('#txtInputRateSGD').val(addCommas(rSGD.toFixed(6)));

        $('.jr_rate').val(addCommas(rUSD.toFixed(6)));
      });

      $('#txtInputRateUSD').focus();
    }




    $('#modal-MCOA2').modal('hide');

  }

  function Pilih_MCOA2(x) {
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
        // var total = (Number(sgd)*rateSGD*0.08);
        gst_value[i].value = addCommas(total.toFixed(2));
      } else {
        gst_value[i].value = 0.00;
      }
    }
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