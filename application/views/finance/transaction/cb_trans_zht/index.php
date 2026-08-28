<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/global/plugins/bootstrap-toastr/toastr.min.css">
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
  .txtnum2,
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
      <form id="form-transCashBank" role="form" enctype="multipart/form-data" method="post" action="<?php echo site_url('CBtrans_zht/insertTransactionCB'); ?>" class="form-horizontal">

        <div class="col-md-12">
          <input type="hidden" id="closing_date" name="closing_date" value="<?php echo $this->session->userdata('closing_date_1'); ?>" />
          <input type="hidden" id="closing" name="closing" value="<?php echo $closing; ?>" />
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
                <span class="caption-helper">Cash Bank ZHT</span>
              </div>

              <div class="actions">
                <a class="btn btn-circle btn-icon-only btn-default fullscreen" href="javascript:;" data-original-title="" title="">
                </a>
              </div>

              <div class="tools">
                <div class="form-inline" role="form">
                  <div class="checkbox">
                    <label>
                      <input id="chkInterBank" name="chkInputInterBank" type="checkbox"><strong>Transfer InterBank</strong> &nbsp;&nbsp;&nbsp;&nbsp;
                    </label>
                  </div>
                </div>
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
                        /*$('#inputNoReff').on('blur', function (){
                                                    var val = $('#inputNoReff').val();
                                                    $.ajax({
                                                        type: "POST",
                                                        url: "<?php //echo base_url(); 
                                                              ?>CBtrans_zht/cekNumReff",
                                                        data: {
                                                            value: val
                                                        },
                                                        dataType: "json",
                                                        success: function(n) {
                                                            if(n === 1){
                                                                $('#div-ReffNum').addClass('has-error');
                                                                document.getElementById('alert-errorReff').style.display = 'block';
                                                                var valAsli     = $('#inputNoReff').val();
                                                                var valtoInt	= parseInt(valAsli);
                                                                $('#inputNoReff').val(valtoInt+1);
                                                                $('#inputNoReff').focus();
                                                                /*$('#form-transCashBank').submit(function (){
                                                                    return false;
                                                                });
                                                            }else{
                                                                $('#div-ReffNum').removeClass('has-error');
                                                                $('#div-ReffNum').addClass('has-success');
                                                                document.getElementById('alert-errorReff').style.display = 'none';
                                                            }
                                                        }
                                                    });
                                                });*/
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
                          <input id="txtInputDateTrans" name="txtDate1" type="text" class="form-control input-sm target" data-date-format="dd-mm-yyyy" value="<?php //echo date('d-m-Y');?>" data-yesterday="<?php echo date('d-m-Y',  mktime(0, 0, 0, date('m'), date('d') - 1, date('Y'))); ?>" data-now="<?php echo date('d-m-Y'); ?>" readonly>
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
                          <select class="form-control input-sm" name="selCBCode" id="selInputCBCode" onchange="changeCodeCB(this)">
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
                          var selectedOption = $('#selInputCBCode option:selected');
                          var nameCOA = selectedOption.text();
                          var pemisah = nameCOA.search("~");
                          var txtIO = $('#inputIOCest').val();

                          var subAccountType = selectedOption.data('sub-account-type');

                          var txtCOA = nameCOA.substr(pemisah + 2);
                          var noCOA = nameCOA.substr(0, pemisah - 1);

                          if (txtIO === '' || txtIO === null) {
                            bootbox.alert('First choose IO Type!');
                            $('#selInputCBCode').val('');
                          } else if (!$('#txtInputDateTrans').val()) {
                            bootbox.alert('Input First Date Transaction!');
                            $('#selInputCBCode').val('');
                          } else {
                            $('#txtInputCOAsuppRow-1').val(noCOA);
                            var coaDetail1 = $('#txtInputCOAsuppRow-1').val();
                          
                            $('#txtDeptCodesuppRow-1').html(`<input name="txtDeptCode[]" type="text" class="txt" value="000" readonly required />`);
                            $('#txtInputNameSuppRow-1').val(txtCOA);
                            $('#txtInputRemark').val(txtCOA);

                            $.ajax({
                              type: "POST",
                              url: "<?php echo base_url(); ?>CBtrans_zht/getRateByBankAccount",
                              data: {
                                txtBankAccount: id,
                                txtTglTrans: $('#txtInputDateTrans').val()
                              },
                              dataType: "json",
                              success: function(e) {
                                var rUSD = parseFloat(e.rateUSD);
                                var rSGD = parseFloat(e.rateSGD);
                                $('#txtInputRateUSD').val(addCommas(rUSD.toFixed(6)));
                                $('#txtInputRateSGD').val(addCommas(rSGD.toFixed(6)));
                                $('#txtInputCurr').val(e.currency);

                                if (e.currency == 'SGD') {
                                  $('#txtInputRateNego').val(addCommas(rUSD.toFixed(6)));
                                } else {
                                  $('#txtInputRateNego').val(addCommas(rSGD.toFixed(6)));
                                }
                              }
                            });
                            $('#txtInputRateUSD').focus();
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
                    <div class="col-sm-4">
                      <div class="form-group">
                        <label class="control-label col-sm-4">From / To</label>
                        <div class="col-sm-8">
                          <input type="text" name="txtFromTo" class="form-control input-sm" required />
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-8">
                      <div class="form-group">
                        <label class="control-label col-sm-1">Description</label>
                        <div class="col-sm-11">
                          <input type="text" name="txtDescription" class="form-control input-sm" required />
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
                      <?php //if($this->session->userdata('userid_1') == 'maintenence' || $this->session->userdata('userid_1') == 'ozzy'): 
                      ?>
                      <div class="form-group">
                        <label class="control-label col-sm-3">Trans Group</label>
                        <div class="col-sm-9">
                          <select class="form-control input-sm select2me">
                            <?php foreach ($_selectGroup as $grp) : ?>
                              <option value="<?php echo $grp->id; ?>"> <?php echo $grp->nama_group; ?></option>
                            <?php endforeach; ?>
                          </select>
                        </div>
                      </div>
                      <?php //endif; 
                      ?>
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
                                  <option value=""> Choose..</option>
                                  <option value="1">Yes</option>
                                  <option value="0">No</option>
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
                                <input type="text" id="txtInputSupp" name="txtSup" class="form-control input-sm ismo-supp-group" />
                              </div>
                            </div>
                          </div>
                          <div class="col-sm-4">
                            <input type="text" id="txtInputSupCOA" name="txtSupCOA" class="form-control input-sm ismo-supp-group" />
                          </div>
                          <div class="col-sm-4">
                            <input type="text" id="txtInputSupRemark" name="txtSupRemark" class="form-control input-sm ismo-supp-group" />
                          </div>
                        </div>

                        <div id="div-costumer" class="col-sm-12">
                          <div class="col-sm-4">
                            <div class="form-group">
                              <label class="control-label col-sm-4">Customer</label>
                              <div class="col-sm-8">
                                <input type="text" id="txtInputCust" name="txtCos" class="form-control input-sm ismo-cust-group" />
                              </div>
                            </div>
                          </div>
                          <div class="col-sm-4">
                            <input type="text" id="txtInputCosCOA" name="txtCosCOA" class="form-control input-sm ismo-cust-group" />
                          </div>
                          <div class="col-sm-4">
                            <input type="text" id="txtInputCosRemark" name="txtCosRemark" class="form-control input-sm ismo-cust-group" />
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
                          <select class="form-control input-sm" data-placeholder="Choose Currency..." name="txtCurr" id="txtInputCurr">
                            <option value=""></option>
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
                            //alert('asasa = '+tgl);
                            if (!$('#txtInputDateTrans').val()) {
                              bootbox.alert('Input First Date Transaction!');
                              $(this).val('');
                            } else {
                              $.ajax({
                                type: "POST",
                                url: "<?php echo base_url(); ?>CBtrans_zht/getRateByCurrency",
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

                                  if (val == 'SGD') {
                                    $('#txtInputRateNego').val(addCommas(rUSD.toFixed(6)));
                                  } else {
                                    $('#txtInputRateNego').val(addCommas(rSGD.toFixed(6)));
                                  }
                                }
                              });
                              $('#txtInputRateUSD').focus();
                            }

                          });

                          $('.hanya-baca').on('keydown keypress keyup', false);
                          $('.txtnumRate').blur(function() {
                            var val = parseFloat($(this).val().replace(/,/g, ''));
                            if (!val) {
                              var vall = 0;
                            } else {
                              vall = val;
                            }
                            $(this).val(addCommas(vall.toFixed(6)));
                          });
                        });
                      </script>
                    </div>
                    <div class="col-sm-12">
                      <div class="form-group">
                        <label class="control-label col-sm-3">Rate USD</label>
                        <div class="col-sm-9">
                          <input type="text" id="txtInputRateUSD" name="txtRateCurr" onblur="javascript: checkGST();" class="form-control input-sm txtnumRate" required />
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-12">
                      <div class="form-group">
                        <label class="control-label col-sm-3">Rate SGD</label>
                        <div class="col-sm-9">
                          <input type="text" id="txtInputRateSGD" name="txtRateCurrSGD" class="form-control input-sm txtnumRate" required />
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-12 display-none" id="colRateNego">
                      <div class="form-group">
                        <label class="control-label col-sm-3" style="font-size: 95%;">Rate Negotiation</label>
                        <div class="col-sm-9">
                          <input type="text" id="txtInputRateNego" name="txtRateCurrNego" onblur="javascript: checkGST();" class="form-control input-sm txtnumRate" required />
                        </div>
                      </div>
                    </div>
                  </div>

                </div>
              </div>

            </div>
          </div>
        </div>

        <div class="col-md-12 display-none">
          <!-- BEGIN PORTLET-->
          <div class="portlet light">
            <div class="portlet-title">
              <div class="caption theme-font">
                <i class="icon-calendar theme-font"></i>
                <span class="caption-subject bold uppercase"> Detail</span>
                <span class="caption-helper">Select PO in Here</span>
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

         <!-- multiple dokument mulai -->
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
        <!-- multiple document akhir -->

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
                    <th style="width: 7%;">Department Code</th>
                    <th style="width: 7%;">B/L Code</th>
                    <th style="width: 20%;">Name</th>
                    <th style="width: 10%;">Debit</th>
                    <th style="width: 10%;">Credit</th>
                    <th style="width: 10%;">Debit[USD]</th>
                    <th style="width: 10%;">Credit[USD]</th>
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
                    <td nowrap id="txtDeptCodesuppRow-1"><input type="text" class="txt" value="" readonly /></td>
                    <td nowrap style="width: 25%;"><textarea type="text" name="txtBlCode[]" id="txtInputBlCodeSuppRow-1" class="txt" rows="1" cols="30"></textarea></td>
                    <td nowrap><input type="text" name="txtNameCOA[]" id="txtInputNameSuppRow-1" class="txt" value="" readonly /></td>
                    <td nowrap><input type="text" name="txtDebit[]" id="txtInputDebitCBdetailRow-1" onKeyup="calculateAmountDebit(); checkGST(); convertToUSD();" onblur="convertToUSD();" class="col-debit col-deb txt txtnum" /></td>
                    <td nowrap><input type="text" name="txtCredit[]" id="txtInputCreditCBdetailRow-1" onKeyup="calculateAmountCredit(); checkGST(); convertToUSD();" onblur="convertToUSD();" class="col-credit col-cre txt txtnum" /></td>

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
                      <button id="btnSelectCOArow2" class="btn btn-xs btn-link baik" type="button">
                        <i class="fa fa-arrow-right"></i></button>
                    </td>
                    <td nowrap><input id="txtInputCOAsuppRow-2" type="text" name="txtNoCOA[]" class="txt" value="" readonly required="" /></td>
                    <td nowrap><input id="txtDeptCodesuppRow-2" type="text" name="txtDeptCode[]" class="txt" value="" readonly required="" /></td>
                    <td nowrap><input id="txtBlCodesuppRow-2" type="text" name="txtBlCode[]" class="txt" value="" /></td>
                    <td nowrap><input id="txtInputNameSuppRow-2" type="text" name="txtNameCOA[]" class="txt" value="" readonly required="" /></td>
                    <td nowrap><input id="txtInputDebitRow-2" type="text" name="txtDebit[]" onKeyup="calculateAmountDebit(); checkGST(); convertToUSD();" onblur="convertToUSD();" class="col-debit col-deb txt txtnum" /></td>
                    <td nowrap><input id="txtInputCreditRow-2" type="text" name="txtCredit[]" onKeyup="calculateAmountCredit(); checkGST(); convertToUSD();" onblur="convertToUSD();" class="col-credit col-cre txt txtnum" /></td>

                    <td nowrap><input type="text" name="txtDebitUSD[]" id="txtInputDebitCBdetailRow-2-USD" class="col-debit-usd txt txtnum" /></td>
                    <td nowrap><input type="text" name="txtCreditUSD[]" id="txtInputCreditCBdetailRow-2-USD" class="col-credit-usd txt txtnum" /></td>
                    <td nowrap><input type="text" name="txtRemark[]" class="txt" /></td>
                    <td nowrap>
                      <select name="txtGST[]" class="txt gst-name" onchange="checkGST();" onblur="checkGST();">
                        <option value=""> -- Select --</option>
                        <?php foreach ($_selectGST as $gst) : ?>
                          <option value="<?php echo $gst->gst_id; ?>"> <?php echo $gst->gst_name; ?></option>
                        <?php endforeach; ?>
                      </select>
                    </td>
                    <td nowrap><input type="text" id="txtInputGSTvalue2nd" name="txtGSTvalue[]" class="txt txtnum gst-value" /></td>
                  </tr>
                </tbody>

                <!-- <tfoot id="detailRowForAddCost">
                                    
                                </tfoot> -->

                <tfoot id="detailRowForAddCost">

                  <tr id="rowGSTlast-1">
                    <td class="text-center" style="vertical-align: middle;">
                      <button class="btn btn-xs btn-link biasa" type="button">
                        <i class="fa fa-arrow-up"></i></button>
                    </td>
                    <td nowrap><input type="text" name="txtNoCOA[]" id="txtInputCOAsuppRow-GSTlast-1" class="txt" value="" readonly /></td>
                    <td nowrap><input type="text" name="txtDeptCode[]" id="txtDeptCodesuppRow-GSTlast-1" class="txt" value="" readonly /></td>
                    <td nowrap><input type="text" name="txtBlCode[]" id="txtInputBlCodeRow-GSTlast-1" class="txt" value=""/></td>
                    <td nowrap><input type="text" name="txtNameCOA[]" id="txtInputNameSuppRow-GSTlast-1" class="txt" value="" readonly /></td>
                    <td nowrap><input type="text" name="txtDebit[]" id="txtInputDebitCBdetailRow-GSTlast-1" readonly class="col-debit col-deb txt txtnum" /></td>
                    <td nowrap><input type="text" name="txtCredit[]" id="txtInputCreditCBdetailRow-GSTlast-1" readonly class="col-credit col-cre txt txtnum" /></td>

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
                  <!-- <tr id="rowGSTlast-2">
                                        <td class="text-center" style="vertical-align: middle;">
                                            <button class="btn btn-xs btn-link biasa" type="button">
                                                <i class="fa fa-arrow-up"></i></button>
                                        </td>
                                        <td nowrap><input type="text" name="txtNoCOA[]" id="txtInputCOAsuppRow-GSTlast-2" class="txt" value="" readonly/></td>
                                        <td nowrap><input type="text" name="txtNameCOA[]" id="txtInputNameSuppRow-GSTlast-2" class="txt" value="" readonly/></td>
                                        <td nowrap><input type="text" name="txtDebit[]" id="txtInputDebitCBdetailRow-GSTlast-2" readonly class="col-debit txt txtnum" /></td>
                                        <td nowrap><input type="text" name="txtCredit[]" id="txtInputCreditCBdetailRow-GSTlast-2" readonly class="col-credit txt txtnum"/></td>
                                        <td nowrap><input type="text" name="txtRemark[]" class="txt"/></td>
                                        <td nowrap>
                                            <select name="txtGST[]" class="txt gst-name display-none" onchange="checkGST()">
                                                <option value=""> -- Select --</option>
                                                <?php //foreach ($_selectGST as $gst): 
                                                ?>
                                                <option value="<?php //echo $gst->gst_id;
                                                                ?>"> <?php //echo $gst->gst_name;
                                                                      ?></option>
                                                <?php //endforeach; 
                                                ?>
                                            </select>
                                        </td>
                                        <td nowrap><input type="text" id="txtInputGSTvalue1st" name="txtGSTvalue[]" class="txt txtnum gst-value display-none"/></td>
                                    </tr> -->
                  <tr id="addCostRow1">
                    <td class="text-center" style="vertical-align: middle;">
                      <button class="btn btn-xs btn-link biasa" type="button">
                        <i class="fa fa-arrow-up"></i></button>
                    </td>
                    <td nowrap><input type="text" name="txtNoCOA[]" id="txtInputCOAsuppRow-addCostRow-1" class="txt" value="700011" readonly /></td>
                    <td nowrap><input type="text" name="txtDeptCode[]" class="txt" value="005" readonly /></td>
                    <td nowrap><input type="text" name="txtBlCode[]" id="txtInputBlCodeRow-addCostRow-1" class="txt" value=""/></td>
                    <td nowrap><input type="text" name="txtNameCOA[]" id="txtInputNameSuppRow-addCostRow-1" class="txt" value="Bank Charges" readonly /></td>
                    <td nowrap><input type="text" name="txtDebit[]" id="txtInputDebitCBdetailRow-addCostRow-1" class="col-deb txt txtnum" /></td>
                    <td nowrap><input type="text" name="txtCredit[]" id="txtInputCreditCBdetailRow-addCostRow-1" class="col-credit col-cre txt txtnum" /></td>

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
            <div class="portlet-body">
              <div class="row">
                <div class="col-md-6">
                  <button class="btn btn-sm btn-primary" id="btnFindRecordzht" type="button">
                    Find <i class="fa fa-sm fa-search fa-fw" aria-hidden="true"></i> </button>
                  <button class="btn btn-sm btn-default disabled display-none" id="btnPrint" type="button">
                    Print <i class="fa fa-sm fa-print fa-fw" aria-hidden="true"></i></button>
                </div>
                <div class="col-md-6 text-right">
                  <button class="simpan btn btn-sm btn-success" id="btnSubmit" onclick="return checkEqual()" type="submit">
                    <i class="fa fa-save"></i> Submit
                  </button>
                  <script>
                    function checkEqual() {
                      var a = document.getElementById('inputAmountDebitUSD').value;
                      var b = document.getElementById('inputAmountCreditUSD').value;

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

<!-- Select Supplier in Detail -->
<div class="modal fade" id="modal-selectSUPP" tabindex="-1" role="basic" aria-hidden="true">
  <div class="modal-dialog" style="width: 75%;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title">Select Supplier</h4>
      </div>
      <div class="modal-body">
        <div id="content-modalSUPP"><i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i> Loading...</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- Select Customer in Detail -->
<div class="modal fade" id="modal-selectCUST" tabindex="-1" role="basic" aria-hidden="true">
  <div class="modal-dialog" style="width: 75%;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title">Select Customer</h4>
      </div>
      <div class="modal-body">
        <div id="content-modalCUST"><i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i> Loading...</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn default" data-dismiss="modal">Close</button>
      </div>
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
        <div id="contentMasterCOA"><i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i> Loading...</div>
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
        <div id="contentMasterCOAforAddCost"><i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i> Loading...</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- Select PO in Detail -->
<div class="modal fade" id="modal-selectPO" tabindex="-1" role="basic" aria-hidden="true">
  <div class="modal-dialog" style="width: 75%;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title">Select PO by S</h4>
      </div>
      <div class="modal-body">
        <div id="content-modalPO"><i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i> Loading...</div>
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
        <div id="modalCashFlow" class="table-responsive"><i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i> Loading...</div>
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
        <div id="contentMasterCOA-row2"><i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i> Loading...</div>
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
        <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i> Loading...
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

<script src="<?php echo base_url(); ?>assets/global/plugins/bootbox/bootbox.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/autoNumeric-min.js" type="text/javascript"></script>
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
    
    $('.ismo-supp-group').attr('readonly', true);
    $('.ismo-cust-group').attr('readonly', true);
    $('.hanya-baca').on('keydown keypress keyup', false);

    // ## InterBank ====
    $('#chkInterBank').on('click', function() {
      if ($(this).prop('checked')) {
        $('#btnSelectMCOA').removeClass('baik').addClass('biasa').find('i').removeClass('fa-plus').addClass('fa-dot-circle-o');
        $('#colRateNego').removeClass('display-none');
        $('#form-transCashBank').attr('action', '<?php echo site_url('CBtrans_zht/insertTransactionCBinterBank'); ?>');
        bootbox.alert('You have chosen a Transfer Interbank transaction!');
      } else {
        $('#btnSelectMCOA').removeClass('biasa').addClass('baik').find('i').removeClass('fa-dot-circle-o').addClass('fa-plus');
        $('#colRateNego').addClass('display-none');
        $('#form-transCashBank').attr('action', '<?php echo site_url('CBtrans_zht/insertTransactionCB'); ?>');
      }
      checkGST();
    });

    //============= Auto Num Reff===============
    $('#txtInputDateTrans, #txtInputCurr, #txtInputRateUSD, #inputIOCest').on('change blur', function() {
      if ($('#txtInputDateTrans').val() && $('#txtInputRateUSD').val() && $('#poTXTtypeIO').val()) {
        var goRefreshNum = setInterval(function() {
          if ($('#txtInputCurr').val() == 'USD' || $('#txtInputCurr').val() == 'SGD' || $('#txtInputCurr').val() == 'IDR') {
            $('#inputNoReff').attr('readonly', true);
            $('#inputNoReff').attr('placeholder', 'Auto Generate');
            // console.log($('#txtInputDateTrans').val());

            // $.get("<?php echo base_url(); ?>CBtrans_zht/newGenerateReffNumber", {
            //     txtTypeForGen : $('#poTXTtypeIO').val(),
            //     txtCurrForGen : $('#txtInputCurr').val(),
            //     txtDateForGen : $('#txtInputDateTrans').val()
            // }, function(data, statuss){
            //     console.log('daata');
            //     $('#inputNoReff').val(data);
            // });
            $jen = $('#inputIOCest').val();

            if ($jen === 'CI' || $jen === 'CO') {
              $.get("<?php echo base_url(); ?>CBtrans_zht/newGenerateReffNumberForCash", {
                txtTypeForGen: $('#poTXTtypeIO').val(),
                txtCurrForGen: $('#txtInputCurr').val(),
                txtDateForGen: $('#txtInputDateTrans').val()
              }, function(data, statuss) {
                // console.log('daata');
                $('#inputNoReff').val(data);
              });
            } else {
              $.get("<?php echo base_url(); ?>CBtrans_zht/newGenerateReffNumber", {
                txtTypeForGen: $('#poTXTtypeIO').val(),
                txtCurrForGen: $('#txtInputCurr').val(),
                txtDateForGen: $('#txtInputDateTrans').val()
              }, function(data, statuss) {
                // console.log('daata');
                $('#inputNoReff').val(data);
              });
            }
          } else {
            clearInterval(goRefreshNum);
            $('#inputNoReff').val('');
            $('#inputNoReff').attr('readonly', false);
            $('#inputNoReff').attr('placeholder', 'Please Insert Reff Number!!');
          }
        }, 2000);
      }
    });

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
      calculateAmountCredit();
      calculateAmountDebit();
      checkGST();
    });
    /*$('.txtnum').on('keydown', function (e){
        if($.inArray(e.keyCode,[8,46]) !== -1){
            $(this).val('');
            return;
        }
    });*/

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
          $(this).val('<?php //echo date('d-m-Y'); 
                        ?>');
      }*/
    });

    $("#btn-generate-noreff").click(function() {
      var dTrans = $('#txtInputDateTrans').val();
      var typeIO = $('#inputIOCest').val();

      $.ajax({
        url: "<?php echo site_url('CBtrans_zht/generateReffNumCB'); ?>",
        data: {
          'txtTglTrans': dTrans,
          'txtTypeIO': typeIO
        },
        type: "POST",
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
      var valPrep = $('#selectPrepaid').val();
      // var interbank = $('#chkInterBank:checked').val;
      var interbank = document.getElementById("chkInterBank").checked;

      $.post("<?php echo base_url(); ?>CBtrans_zht/getIOtypeTransByCode", {
        selectIOtype: ioType
      }, function(data, statuss) {
        if (data == 'O' && valPrep == '1') {
          $('.ismo-supp-group').attr('readonly', false);
          $('.ismo-cust-group').attr('readonly', true);
          $('#txtInputDebitRow-2').attr('readonly', false);
          $('#txtInputCreditRow-2').attr('readonly', true);

          $('#txtInputDebitCBdetailRow-1').attr('readonly', true);
          $('#txtInputCreditCBdetailRow-1').attr('readonly', false);

          $('#txtInputDebitCBdetailRow-addCostRow-1').attr('readonly', true);
          $('#txtInputCreditCBdetailRow-addCostRow-1').attr('readonly', false);

          $('#txtInputGSTvalue2nd').removeClass('gst-value-credit');
          $('#txtInputGSTvalue2nd').addClass('gst-value-debit');

          $('#txtInputGSTvalue1st').removeClass('gst-value-debit');
          $('#txtInputGSTvalue1st').addClass('gst-value-credit');

          //==============GST=========
          $('#txtInputCOAsuppRow-GSTlast-1').val('300106');
          $('#txtDeptCodesuppRow-GSTlast-1').val('000');
          $('#txtInputNameSuppRow-GSTlast-1').val('GST Input Tax');

          //$('#txtInputDebitCBdetailRow-addCostRow-1').removeClass('col-debit');
        } else if (data == 'I' && valPrep == '1') {
          $('.ismo-supp-group').attr('readonly', true);
          $('.ismo-cust-group').attr('readonly', false);
          $('#txtInputDebitRow-2').attr('readonly', true);
          $('#txtInputCreditRow-2').attr('readonly', false);

          $('#txtInputDebitCBdetailRow-1').attr('readonly', false);
          $('#txtInputCreditCBdetailRow-1').attr('readonly', true);

          $('#txtInputDebitCBdetailRow-addCostRow-1').attr('readonly', false);
          $('#txtInputCreditCBdetailRow-addCostRow-1').attr('readonly', true);

          $('#txtInputGSTvalue2nd').addClass('gst-value-credit');
          $('#txtInputGSTvalue2nd').removeClass('gst-value-debit');

          $('#txtInputGSTvalue1st').addClass('gst-value-debit');
          $('#txtInputGSTvalue1st').removeClass('gst-value-credit');

          //==============GST=========
          $('#txtInputCOAsuppRow-GSTlast-1').val('200801');
          $('#txtDeptCodesuppRow-GSTlast-1').val('0');
          $('#txtInputNameSuppRow-GSTlast-1').val('GST Output Tax');

          //$('#txtInputDebitCBdetailRow-addCostRow-1').addClass('col-debit')
        } else if (data == 'O') {
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
          $('#txtInputCOAsuppRow-GSTlast-1').val('300106');
          $('#txtDeptCodesuppRow-GSTlast-1').val('000');
          $('#txtInputNameSuppRow-GSTlast-1').val('GST Input Tax');

          //$('#txtInputDebitCBdetailRow-addCostRow-1').removeClass('col-debit')
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
          $('#txtDeptCodesuppRow-GSTlast-1').val('0');
          $('#txtInputNameSuppRow-GSTlast-1').val('GST Output Tax');

          //$('#txtInputDebitCBdetailRow-addCostRow-1').addClass('col-debit')
        }

        if (interbank == true) {
          //==============Exchange Rate=========
          $('#txtInputCOAsuppRow-GSTlast-1').val('610009');
          $('#txtInputNameSuppRow-GSTlast-1').val('Exchange Rate');
        }
      });
    });

    $('#selectPrepaid').on('change', function() {
      var valPrep = $(this).val();
      var ioType = $('#poTXTtypeIO').val();

      if (valPrep == '1') {
        if (ioType == 'O' && valPrep == '1') {
          $('.ismo-supp-group').attr('readonly', false);
          $('.ismo-cust-group').attr('readonly', true);
          $('#txtInputDebitRow-2').attr('readonly', false);
          $('#txtInputCreditRow-2').attr('readonly', true);
          $.post("<?php echo base_url(); ?>CBtrans_zht/getCOAdp", {
            txtIOtype: ioType
          }, function(data, statuss) {
            var cb = $.parseJSON(data);
            $('#txtInputCOAsuppRow-2').val(cb.no_coa);
            $('#txtInputNameSuppRow-2').val(cb.nm_coa);
          });
          $('#rowSelectCOArow2').html('<button class="btn btn-xs btn-link biasa" type="button">\n\
                        <i class="fa fa-arrow-down"></i></button>');
        } else if (ioType == 'I' && valPrep == '1') {
          $('.ismo-supp-group').attr('readonly', true);
          $('.ismo-cust-group').attr('readonly', false);
          $('#txtInputDebitRow-2').attr('readonly', true);
          $('#txtInputCreditRow-2').attr('readonly', false);
          $.post("<?php echo base_url(); ?>CBtrans_zht/getCOAdp", {
            txtIOtype: ioType
          }, function(data, statuss) {
            var cb = $.parseJSON(data);
            $('#txtInputCOAsuppRow-2').val(cb.no_coa);
            $('#txtInputNameSuppRow-2').val(cb.nm_coa);
          });
          $('#rowSelectCOArow2').html('<button class="btn btn-xs btn-link biasa" type="button">\n\
                        <i class="fa fa-arrow-down"></i></button>');
        }
      } else {
        $('.ismo-supp-group').attr('readonly', true);
        $('.ismo-cust-group').attr('readonly', true);
        $('#rowSelectCOArow2').html('<button onClick="selectModalCOArow2()" class="btn btn-xs btn-link baik" type="button">\n\
                        <i class="fa fa-arrow-right"></i></button>');
        $('#txtInputCOAsuppRow-2').val('');
        $('#txtInputNameSuppRow-2').val('');
      }
    });

    // == Select Supplier
    $('#txtInputSupp').on('click', function() {
      var ioType = $('#poTXTtypeIO').val();
      var prep = $('#selectPrepaid').val();
      if ($('#txtInputSupp').hasClass('ismo-has-selected')) {
        bootbox.confirm("If you want change Supplier, You have reload this page?", function(result) {
          if (result == true) {
            location.reload();
          }
        });
      } else if (ioType == 'I' && prep != '1' || prep != '1' || ioType == 'I' || ioType == '') {
        return null;
      } else {
        $.ajax({
          url: "<?php echo site_url('CBtrans_zht/selectSupplierForCB'); ?>",
          type: "POST",
          datatype: "json",
          cache: false,
          success: function(respon) {
            $('#content-modalSUPP').html(respon);
          }
        });
        $('#modal-selectSUPP').modal('show');
      }
      /*$(function() {
          $('.txtnum').numericInput({ allowFloat: true, allowNegative: true });
      });*/
    });
    // == Select Customer
    $('#txtInputCust').on('click', function() {
      var ioType = $('#poTXTtypeIO').val();
      var prep = $('#selectPrepaid').val();
      if ($('#txtInputCust').hasClass('ismo-has-selected')) {
        bootbox.confirm("If you want change Customer, You have reload this page?", function(result) {
          if (result == true) {
            location.reload();
          }
        });
      } else if (ioType == 'O' && prep != '1' || prep != '1' || ioType == 'O' || ioType == '') {
        return null;
      } else {
        $.ajax({
          url: "<?php echo site_url('CBtrans_zht/selectCustomerForCB'); ?>",
          type: "POST",
          datatype: "json",
          cache: false,
          success: function(respon) {
            $('#content-modalCUST').html(respon);
          }
        });
        $('#modal-selectCUST').modal('show');
      }
      /*$(function() {
          $('.txtnum').numericInput({ allowFloat: true, allowNegative: true });
      });*/
    });
    // == Select PO
    $('#btnSelectPO').click(function() {
      var ioType = $('#poTXTtypeIO').val();
      var prep = $('#selectPrepaid').val();
      var txtSupp = $('#txtInputSupp').val();
      var txtCust = $('#txtInputCust').val();
      if (ioType == '' || prep == '' || ioType == '' && prep == '') {
        bootbox.alert('First Select I/O Type and Prepaid Option!');
      } else if (ioType == 'O' && prep == '1' && txtSupp == '' || ioType == 'I' && prep == '1' && txtCust == '') {
        bootbox.alert('First Select Supplier or Customer!');
      } else {
        if ($('#modal-selectPO').hasClass('ismo-has-modal')) {
          $('#modal-selectPO').modal('show');
        } else {
          var idSupp = $('#txtInputSupp').val();
          var idCust = $('#txtInputCust').data('id');
          var typeIO = $('#poTXTtypeIO').val();

          if (typeIO == 'O') {
            $.ajax({
              url: "<?php echo site_url('CBtrans_zht/selectPObySupplierForCB'); ?>",
              type: "POST",
              data: {
                txtSuppID: idSupp
              },
              datatype: "json",
              cache: false,
              success: function(respon) {
                $('#content-modalPO').html(respon);
              }
            });
          } else {
            //alert(idCust);
            $.ajax({
              url: "<?php echo site_url('CBtrans_zht/selectPObyCustomerForCB'); ?>",
              type: "POST",
              data: {
                txtCustID: idCust
              },
              datatype: "json",
              cache: false,
              success: function(respon) {
                $('#content-modalPO').html(respon);
              }
            });
          }

          $('#modal-selectPO').modal('show');
          $('#modal-selectPO').addClass('ismo-has-modal');
        }
      }
    });
    // == Select Master COA
    $("#btnSelectMCOA").click(function() {
      if ($(this).hasClass('baik')) {
        if ($('#modal-MCOA').hasClass('ismo-has-modal')) {
          $('#modal-MCOA').modal('show');
        } else {
          $.ajax({
            url: "<?php echo site_url('CBtrans_zht/selectCOA'); ?>",
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
      }
    });
    // == Select Master COA ROW #2
    $("#btnSelectCOArow2").click(function() {
      if ($(this).hasClass('baik')) {
        selectModalCOArow2();
      }
    });

    // == Additional Cost
    $("#btnAddCost").click(function() {
      $.ajax({
        url: "<?php echo site_url('CBtrans_zht/selectCOAforAddCost'); ?>",
        type: "POST",
        datatype: "json",
        cache: false,
        success: function(respon) {
          $('#contentMasterCOAforAddCost').html(respon);
        }
      });
      $('#modal-MCOAforAddCost').modal('show');
    });
    // ===== ## Find AP Payment ## =====
    $("#btnFindRecordzht").click(function() {
      $.post("<?php echo site_url(); ?>CBtrans_zht/selectCashBank", function(data) {
        $('#contentFindCB').html(data);
      });
      $('#modal-findCB').modal('show');
    });
    $("#form-transCashBank").submit(function(e) {
      var currentForm = this;
      e.preventDefault();

      if (!$('#txtInputCOAsuppRow-2').val()) {
        setPulsate('#btnSelectCOArow2, #txtInputCOAsuppRow-2');
        setToast('Select First COA for Detail Row Two!');
      } else {
        /*var amountPayment   = $('#inputAmountDebit').val();
        var numberBank      = $('#txtInputCOAsuppRow-1').val();
        //alert(amountPayment + ' - ' + numberBank);

        $.post("<?php //echo site_url();
                ?>CBtrans_zht/checkSaldoAwal", {
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
            $("#btnSubmit")
                    .prop("disabled", true)
                    .text("Processing...");
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

    $('#txtInputSupp').val(suppid);
    $('#txtInputSupCOA').val(suppcoa);
    $('#txtInputSupRemark').val(suppnm);
    //== Row Detail 2
    //$('#txtInputCOAsuppRow-2').val(suppcoa);
    //$('#txtInputNameSuppRow-2').val(suppnm);

    $('#txtInputSupp').addClass('ismo-has-selected');
    $('#modal-selectSUPP').modal('hide');
  }

  function Pilih_Customer(x) {
    function getText(el) {
      if (typeof el.textContent === 'string')
        return el.textContent;
      if (typeof el.innerText === 'string')
        return el.innerText;
    }

    $r = x.rowIndex;
    var custcode = getText(document.getElementById('tbl-selectCustomer').rows[$r].cells[0]);
    var custname = getText(document.getElementById('tbl-selectCustomer').rows[$r].cells[1]);
    var custcoa = getText(document.getElementById('tbl-selectCustomer').rows[$r].cells[3]);
    var custkeycode = getText(document.getElementById('tbl-selectCustomer').rows[$r].cells[4]);

    $('#txtInputCust').val(custcode);
    $('#txtInputCust').attr('data-id', custkeycode);
    $('#txtInputCosCOA').val(custcoa);
    $('#txtInputCosRemark').val(custname);
    //== Row Detail 2
    //$('#txtInputCOAsuppRow-2').val(custcoa);
    //$('#txtInputNameSuppRow-2').val(custname);

    $('#txtInputCust').addClass('ismo-has-selected');
    $('#modal-selectCUST').modal('hide');
  }

  function Pilih_POsupp(x) {
    function getText(el) {
      if (typeof el.textContent === 'string')
        return el.textContent;
      if (typeof el.innerText === 'string')
        return el.innerText;
    }
    var rr = x.rowIndex;
    var cls = getText(document.getElementById('tbl-selectPOsupplier').rows[rr].cells[5]);
    var rate = getText(document.getElementById('tbl-selectPOsupplier').rows[rr].cells[3]).replace(/,/g, '');
    var total = getText(document.getElementById('tbl-selectPOsupplier').rows[rr].cells[4]).replace(/,/g, '');
    var toUsd = Number(rate) * Number(total);
    var per10n = parseFloat(getText(document.getElementById('tbl-selectPOsupplier').rows[rr].cells[4]).replace(/,/g, '')) * 0.1;

    $('#tbl-detail-po tbody').append('<tr class="' + cls + ' added-row-ismo">\n\
            <td></td>\n\
            <td><input value="' + getText(document.getElementById('tbl-selectPOsupplier').rows[rr].cells[0]) + '" name="txtNoMainPO[]" class="txt" readonly/></td>\n\
            <td><input value="' + getText(document.getElementById('tbl-selectPOsupplier').rows[rr].cells[1]) + '" name="txtDatePO[]" class="txt txtnum" readonly/></td>\n\
            <td><input value="' + getText(document.getElementById('tbl-selectPOsupplier').rows[rr].cells[2]) + '" name="txtCurrencyPO[]" class="txt txtnum" readonly/></td>\n\
            <td><input value="' + getText(document.getElementById('tbl-selectPOsupplier').rows[rr].cells[3]) + '" name="txtTotalPO[]" class="txt col-rate txtnum" readonly/></td>\n\
            <td><input value="' + getText(document.getElementById('tbl-selectPOsupplier').rows[rr].cells[4]) + '" name="txtRatePO[]" class="txt col-before txtnum" readonly/></td>\n\
            <td><input value="' + addCommas(toUsd.toFixed(2)) + '" name="txtEquivalentPO[]" class="txt col-equi txtnum" readonly/></td>\n\
            <td><input data-max="' + getText(document.getElementById('tbl-selectPOsupplier').rows[rr].cells[4]) + '" \n\
                value="' + addCommas(per10n.toFixed(2)) + '" name="txtTotalDP[]" \n\
                class="txt col-total txtnum ' + cls + 'qq" onkeyup="CountPayTotal(); isNumber();"/></td>\n\
        </tr>');

    CountGrandTotal(); // Callback function
    calculateAmountCredit();
    calculateAmountDebit();
    $('#txtInputDebitCBdetailRow-1').addClass('hanya-baca');
    $('#txtInputCreditCBdetailRow-1').addClass('hanya-baca');
    $(function() {
      $('.hanya-baca').on('keydown keypress keyup', false);
      $('.txtnum').keyup(function() {
        var maxVal = $(this).data('max').replace(/,/g, '');
        var value = $(this).val().replace(/,/g, '');
        if (parseFloat(value) > parseFloat(maxVal) || parseFloat(value) < 0) {
          bootbox.alert("Value should not be more than " + maxVal + " and less than 0");
          $(this).val(parseFloat(maxVal).toFixed(6));
          CountPayTotal();
        }
      });
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
      /*$('.txtnum').on('keydown', function (e){
          if($.inArray(e.keyCode,[8,46]) !== -1){
              $(this).val('');
              return;
          }
      });*/
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
                            <td nowrap><input type="text" name="txtBlCode[]" class="txt" value="' + getText(document.getElementById('tbl-MasterCOAforAddCost').rows[$r].cells[2]) + '" readonly/></td>\n\
                            <td nowrap><input type="text" name="txtDebit[]" onKeyup="calculateAmountDebit(); checkGST();convertToUSD();" class="ac-col-debit col-deb txt txtnum ' + cls + 'xx" /></td>\n\
                            <td nowrap><input type="text" name="txtCredit[]" readonly onKeyup="calculateAmountDebit(); checkGST();convertToUSD(); class="ac-col-credit col-cre txt txtnum ' + cls + 'xx"/></td>\n\
                            <td nowrap><input type="text" name="txtDebitUSD[]" class="col-debit-usd txt txtnum ' + cls + 'xx" /></td>\n\
                            <td nowrap><input type="text" name="txtCreditUSD[]" class="col-credit-usd txt txtnum ' + cls + 'xx"/></td>\n\
                            <td nowrap><input type="text" name="txtRemark[]" class="txt"/></td>\n\
                            <td nowrap><input type="text" name="txtGST[]" class="txt"/></td>\n\
                            <td nowrap><input type="text" name="txtGSTvalue[]" class="txt txtnum gst-value gst-value-debit" onKeyup="calculateAmountDebit(); checkGST();convertToUSD();"/></td>\n\
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
                            <td nowrap><input type="text" name="txtBlCode[]" class="txt" value="' + getText(document.getElementById('tbl-MasterCOAforAddCost').rows[$r].cells[2]) + '" readonly/></td>\n\
                            <td nowrap><input type="text" name="txtDebit[]" readonly onKeyup="calculateAmountDebit(); checkGST(); convertToUSD();" class="ac-col-debit col-deb txt txtnum ' + cls + 'xx" /></td>\n\
                            <td nowrap><input type="text" name="txtCredit[]" onKeyup="calculateAmountDebit(); checkGST(); convertToUSD();" class="ac-col-credit col-cre txt txtnum ' + cls + 'xx"/></td>\n\
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
            bootbox.hideAll();
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

            var debetRow = '<tr class="' + cls + ' added-row-ismo">\n\
              <td class="text-center" style="vertical-align: middle;">\n\
                  <button class="btn btn-xs btn-link buruk" type="button" onclick="delete_MCOA(this)"><i class="fa fa-trash-o"></i></button></td>\n\
              <td nowrap><input type="text" name="txtNoCOA[]" class="txt" value="' + getText(document.getElementById('tbl-MasterCOA').rows[$r].cells[6]) + '" readonly/></td>\n\
              <td nowrap><input type="text" name="txtDeptCode[]" class="txt" value="' + getText(document.getElementById('tbl-MasterCOA').rows[$r].cells[7]) + '" readonly/></td>\n\
              <td nowrap><textarea type="text" name="txtBlCode[]"  class="txt" rows="1" cols="30"></textarea></td>\n\
              <td nowrap><input type="text" name="txtNameCOA[]" class="txt" value="' + getText(document.getElementById('tbl-MasterCOA').rows[$r].cells[1]) + '" readonly/></td>\n\
              <td nowrap><input type="text" name="txtDebit[]" onKeyup="calculateAmountDebit(); checkGST();" class="col-debit col-deb txt txtnum ' + cls + 'qq" /></td>\n\
              <td nowrap><input type="text" name="txtCredit[]" readonly onKeyup="calculateAmountCredit(); checkGST();" class="col-credit col-cre txt txtnum ' + cls + 'qq"/></td>\n\
              <td nowrap><input type="text" name="txtDebitUSD[]" class="col-debit-usd txt txtnum ' + cls + 'qq" /></td>\n\
              <td nowrap><input type="text" name="txtCreditUSD[]" class="col-credit-usd txt txtnum ' + cls + 'qq"/></td>\n\
              <td nowrap><input type="text" name="txtRemark[]" class="txt"/></td>\n\
              <td nowrap class="cls-gst"><input type="text" name="txtGST[]" class="txt"/></td>\n\
              <td nowrap><input type="text" name="txtGSTvalue[]" class="txt txtnum gst-value gst-value-debit"/></td>\n\
            </tr>';
            $('table[id="tbl-cashGeneral"]').append(debetRow);

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
              /*$('.txtnum').on('keydown', function (e){
                  if($.inArray(e.keyCode,[8,46]) !== -1){
                      $(this).val('');
                      return;
                  }
              });*/

              $.ajax({
                url: "<?php echo base_url(); ?>CBtrans_zht/addGST",
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

            var creditRow = '<tr class="' + cls + ' added-row-ismo">\n\
                                <td class="text-center" style="vertical-align: middle;">\n\
                                    <button class="btn btn-xs btn-link buruk" type="button" onclick="delete_MCOA(this)"><i class="fa fa-trash-o"></i></button></td>\n\
                                <td nowrap><input type="text" name="txtNoCOA[]"  class="txt" value="' + getText(document.getElementById('tbl-MasterCOA').rows[$r].cells[6]) + '" readonly/></td>\n\
                                <td nowrap><input type="text" name="txtDeptCode[]" class="txt" value="' + getText(document.getElementById('tbl-MasterCOA').rows[$r].cells[7]) + '" readonly/></td>\n\
                                <td nowrap><textarea type="text" name="txtBlCode[]"  class="txt" rows="1" cols="30"></textarea></td>\n\
                                <td nowrap><input type="text" name="txtNameCOA[]" class="txt" value="' + getText(document.getElementById('tbl-MasterCOA').rows[$r].cells[1]) + '" readonly/></td>\n\
                                <td nowrap><input type="text" name="txtDebit[]" readonly onKeyup="calculateAmountDebit(); checkGST();" class="col-debit col-deb txt txtnum ' + cls + 'qq" /></td>\n\
                                <td nowrap><input type="text" name="txtCredit[]" onKeyup="calculateAmountCredit(); checkGST();" class="col-credit col-cre txt txtnum ' + cls + 'qq"/></td>\n\
                                <td nowrap><input type="text" name="txtDebitUSD[]" class="col-debit-usd txt txtnum ' + cls + 'qq" /></td>\n\
                                <td nowrap><input type="text" name="txtCreditUSD[]" class="col-credit-usd txt txtnum ' + cls + 'qq"/></td>\n\
                                <td nowrap><input type="text" name="txtRemark[]" class="txt"/></td>\n\
                                <td nowrap class="cls-gst"><input type="text" name="txtGST[]" class="txt"/></td>\n\
                                <td nowrap><input type="text" name="txtGSTvalue[]" class="txt txtnum gst-value gst-value-credit"/></td>\n\
                              </tr>';
                            
            $('table[id="tbl-cashGeneral"]').append(creditRow);
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
              /*$('.txtnum').on('keydown', function (e){
                  if($.inArray(e.keyCode,[8,46]) !== -1){
                      $(this).val('');
                      return;
                  }
              });*/

              $.ajax({
                url: "<?php echo base_url(); ?>CBtrans_zht/addGST",
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

    /*var $r      = x.rowIndex;
    var cls     = getText(document.getElementById('tbl-MasterCOA').rows[$r].cells[4]);
    var typeIO  = $('#poTXTtypeIO').val();
    
    if (typeIO == 'O'){
        $('table[id="tbl-cashGeneral"]').append('<tr class="'+cls+' added-row-ismo">\n\
            <td class="text-center" style="vertical-align: middle;">\n\
                <button class="btn btn-xs btn-link buruk" type="button" onclick="delete_MCOA(this)"><i class="fa fa-trash-o"></i></button></td>\n\
            <td nowrap><input type="text" name="txtNoCOA[]"  class="txt" value="' + getText(document.getElementById('tbl-MasterCOA').rows[$r].cells[0]) +'" readonly/></td>\n\
            <td nowrap><input type="text" name="txtNameCOA[]" class="txt" value="' + getText(document.getElementById('tbl-MasterCOA').rows[$r].cells[1]) +'" readonly/></td>\n\
            <td nowrap><input type="text" name="txtDebit[]" onKeyup="calculateAmountDebit(); checkGST();" class="col-debit txt txtnum '+cls+'qq" /></td>\n\
            <td nowrap><input type="text" name="txtCredit[]" readonly onKeyup="calculateAmountCredit(); checkGST();" class="col-credit txt txtnum '+cls+'qq"/></td>\n\
            <td nowrap><input type="text" name="txtRemark[]" class="txt"/></td>\n\
            <td nowrap class="cls-gst"><input type="text" name="txtGST[]" class="txt"/></td>\n\
            <td nowrap><input type="text" name="txtGSTvalue[]" class="txt txtnum gst-value"/></td>\n\
        </tr>');
    }else if(typeIO == 'I'){
        $('table[id="tbl-cashGeneral"]').append('<tr class="'+cls+' added-row-ismo">\n\
            <td class="text-center" style="vertical-align: middle;">\n\
                <button class="btn btn-xs btn-link buruk" type="button" onclick="delete_MCOA(this)"><i class="fa fa-trash-o"></i></button></td>\n\
            <td nowrap><input type="text" name="txtNoCOA[]"  class="txt" value="' + getText(document.getElementById('tbl-MasterCOA').rows[$r].cells[0]) +'" readonly/></td>\n\
            <td nowrap><input type="text" name="txtNameCOA[]" class="txt" value="' + getText(document.getElementById('tbl-MasterCOA').rows[$r].cells[1]) +'" readonly/></td>\n\
            <td nowrap><input type="text" name="txtDebit[]" readonly onKeyup="calculateAmountDebit(); checkGST();" class="col-debit txt txtnum '+cls+'qq" /></td>\n\
            <td nowrap><input type="text" name="txtCredit[]" onKeyup="calculateAmountCredit(); checkGST();" class="col-credit txt txtnum '+cls+'qq"/></td>\n\
            <td nowrap><input type="text" name="txtRemark[]" class="txt"/></td>\n\
            <td nowrap class="cls-gst"><input type="text" name="txtGST[]" class="txt"/></td>\n\
            <td nowrap><input type="text" name="txtGSTvalue[]" class="txt txtnum gst-value"/></td>\n\
        </tr>');
    }else{
        bootbox.alert('First you must choose I/O Type!');
        return null;
    }
    $(function() {
        $('.txtnum').numericInput({ allowFloat: true, allowNegative: true });
        $('.'+cls+'qq').blur( function (){
            var val = parseFloat($(this).val().replace(/,/g, ''));
            if(!val){ var vall = 0;}
            else{vall = val;}
            $(this).val(addCommas(vall.toFixed(2)));
            calculateAmountCredit();
            calculateAmountDebit();
            checkGST();
        });
        /*$('.txtnum').on('keydown', function (e){
            if($.inArray(e.keyCode,[8,46]) !== -1){
                $(this).val('');
                return;
            }
        });
        
        $.ajax({
            url: "<?php //echo base_url();
                  ?>CBtrans_zht/addGST",
            dataType: 'html',
            success: function (data) {
                $('.cls-gst').html(data);
            }
        });
    });*/
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

  function selectModalCOArow2() {
    $.ajax({
      url: "<?php echo site_url('CBtrans_zht/selectCOArow2'); ?>",
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
    var nameCOA = getText(document.getElementById('tbl-MasterCOA-row2').rows[$r].cells[1]);
    var noCoa = getText(document.getElementById('tbl-MasterCOA-row2').rows[$r].cells[6]);
    var deptCode = getText(document.getElementById('tbl-MasterCOA-row2').rows[$r].cells[7]);

    $('#txtInputCOAsuppRow-2').val(noCoa);
    $('#txtInputNameSuppRow-2').val(nameCOA);
    $('#txtDeptCodesuppRow-2').val(deptCode);

    
    $('#modal-MCOA-row2').modal('hide');
  }

  // ==## Calculate Table PO Detail ##==
  function CountPayTotal() {
    var sumTotal = 0;
    $(".col-total").each(function() {
      var valTtot = this.value;
      var newTtot = parseFloat(valTtot.replace(/,/g, ''));
      if (!isNaN(newTtot) && this.value.length !== 0) {
        sumTotal += parseFloat(newTtot);
      }
    });

    $('#totalTotalID').val(addCommas(sumTotal.toFixed(2)));

    //======================================================================
    var typeIO = $('#poTXTtypeIO').val();
    if (typeIO == 'O') {
      $('#txtInputCreditCBdetailRow-1').val(addCommas(sumTotal.toFixed(2)));
      $('#inputAmountCredit').val(addCommas(sumTotal.toFixed(2)));
    } else {
      $('#txtInputDebitCBdetailRow-1').val(addCommas(sumTotal.toFixed(2)));
      $('#inputAmountDebit').val(addCommas(sumTotal.toFixed(2)));
    }
  }

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
    var typeIO = $('#poTXTtypeIO').val();
    if (typeIO == 'O') {
      $('#txtInputCreditCBdetailRow-1').val(addCommas(sumTotal.toFixed(2)));
      $('#inputAmountCredit').val(addCommas(sumTotal.toFixed(2)));
    } else {
      $('#txtInputDebitCBdetailRow-1').val(addCommas(sumTotal.toFixed(2)));
      $('#inputAmountDebit').val(addCommas(sumTotal.toFixed(2)));
    }
  }

  // ==## Convert to USD ##== //
  function convertToUSD() {
    var rateUSD = 0;
    var rateUSD = 0;
    var rateNego = 0;
    var interbank = document.getElementById("chkInterBank").checked;
    var c = 0;

    if ($('#chkInterBank').prop('checked')) {
      c = 1;
      rateUSD = parseFloat($('#txtInputRateUSD').val().replace(/,/g, ''));
      rateSGD = parseFloat($('#txtInputRateSGD').val().replace(/,/g, ''));
      // rateNego= parseFloat($('#txtInputRateNego').val().replace(/,/g, ''));


      var currNego = $('#txtInputCurr').val();
      if (currNego == 'SGD') {
        rateNego = 1;
      } else {
        rateNego = 1 / rateSGD;
      }

    } else {
      rateUSD = parseFloat($('#txtInputRateUSD').val().replace(/,/g, ''));
    }

    var r_debt = document.getElementsByClassName('col-deb');
    var i_debt = document.getElementsByClassName('col-debit-usd');
    var t_debt = 0;
    for (var i = 0; i < r_debt.length; i++) {
      var rr_deb = r_debt[i].value.replace(/,/g, '');
      if (i == 1 && c == 1) {
        var result = rr_deb * rateNego;
      } else {
        var result = rr_deb * rateUSD;
      }

      i_debt[i].value = addCommas(result.toFixed(2));

      t_debt += parseFloat(result.toFixed(2));
    }

    var r_cret = document.getElementsByClassName('col-cre');
    var i_cret = document.getElementsByClassName('col-credit-usd');
    var t_cret = 0;
    for (var x = 0; x < r_cret.length; x++) {
      var rr_cre = r_cret[x].value.replace(/,/g, '');
      var result = rr_cre * rateUSD;
      i_cret[x].value = addCommas(result.toFixed(2));

      t_cret += parseFloat(result.toFixed(2));
    }

    var selisih = t_debt - t_cret;

    if (selisih != 0) {
      if (selisih > 0) {
        i_cret[1].value = addCommas((i_cret[1].value + Math.abs(selisih)).toFixed(2));
        t_cret += parseFloat(Math.abs(selisih).toFixed(2));
      } else {
        i_debt[1].value = addCommas((i_debt[1].value + Math.abs(selisih)).toFixed(2));
        t_debt += parseFloat(Math.abs(selisih).toFixed(2));
      }
    }

    $('#inputAmountDebitUSD').val(addCommas(t_debt.toFixed(2)));
    $('#inputAmountCreditUSD').val(addCommas(t_cret.toFixed(2)));
  }

  // ==## Calculate Balance Table ##==
  function calculateAmountDebit() {
    var sumAmount = 0;
    var interbank = document.getElementById("chkInterBank").checked;
    var rateNego = document.getElementById("txtInputRateNego").value;

    $(".col-debit").each(function() {
      var valDtot = this.value;
      var newDtot = parseFloat(valDtot.replace(/,/g, ''));
      if (!isNaN(newDtot) && this.value.length !== 0) {
        sumAmount += parseFloat(newDtot);
      }
    });

    if (interbank == true) {
      $('#txtInputCreditRow-2').attr('readonly', true);
    }

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
    var interbank = document.getElementById("chkInterBank").checked;
    var rateNego = document.getElementById("txtInputRateNego").value;

    $(".col-credit").each(function() {
      var valCtot = this.value;
      var newCtot = parseFloat(valCtot.replace(/,/g, ''));
      if (!isNaN(newCtot) && this.value.length !== 0) {
        sumAmount += parseFloat(newCtot);
      }
    });

    if (interbank == true) {
      document.getElementById('txtInputDebitRow-2').value = (sumAmount * rateNego).toFixed(2);
      $('#txtInputDebitRow-2').attr('readonly', true);
    }

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

  // ==## Check GST ##==
  // $(".gst-value").on("change", function() {
  //     checkGST()
  // });

  function checkGST() {
    var gst_type = document.getElementsByClassName('gst-name');
    var debit_txt = document.getElementsByClassName('col-debit');
    var credit_txt = document.getElementsByClassName('col-credit');
    var gst_value = document.getElementsByClassName('gst-value');
    var rateSGD = parseFloat($('#txtInputRateSGD').val().replace(/,/g, ''));
    var interbank = document.getElementById("chkInterBank").checked;

    var tgl1 = $('#txtInputDateTrans').val();
    var tgl = tgl1.split("-");
    var tahun = tgl[2];

    if (interbank == true) {
      exit;
    }

    for (var i = 0; i < gst_type.length; i++) {
      if (gst_type[i].value === 'GST') {
        if (tahun > '2023') {
          var dd = debit_txt[i].value.replace(/,/g, '');
          var cc = credit_txt[i].value.replace(/,/g, '');
          var total = ((Number(dd) + Number(cc)) * 0.09);
          gst_value[i].value = addCommas(total.toFixed(2));
        } else {
          var dd = debit_txt[i].value.replace(/,/g, '');
          var cc = credit_txt[i].value.replace(/,/g, '');
          var total = ((Number(dd) + Number(cc)) * 0.08);
          gst_value[i].value = addCommas(total.toFixed(2));
        }
      } else {
        gst_value[i].value = 0.00;
      }
    }

    var get1 = 0;
    var get2 = 0;
    var forGSTusd = parseFloat($('#txtInputRateUSD').val().replace(/,/g, ''));
    var forGSTsgd = parseFloat($('#txtInputRateSGD').val().replace(/,/g, ''));
    var forGSTcur = $('#txtInputCurr').val();

    $('.gst-value-debit').each(function(index, item) {
      if ($(item).val()) {
        get1 += parseFloat($(item).val().replace(/,/g, ''));
        // if (forGSTcur == 'USD'){
        //     var set1 = get1/(forGSTsgd/forGSTusd);
        // }else{
        //     set1 = get1;
        // }

        set1 = get1;

        $('#sumGST-1').val(set1);
        $('#txtInputDebitCBdetailRow-GSTlast-1').val(addCommas(set1.toFixed(2)));
        $('#txtInputCreditCBdetailRow-GSTlast-2').val(addCommas(set1.toFixed(2)));
      }
    });
    $('.gst-value-credit').each(function(index, item) {
      if ($(item).val()) {
        get2 += parseFloat($(item).val().replace(/,/g, ''));
        // if(forGSTcur == 'USD'){
        //     var set2 = get2/(forGSTsgd/forGSTusd);
        // }else{
        //     set2 = get2;
        // }

        set2 = get2;

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
      //var creGST      = parseFloat($('#txtInputCreditCBdetailRow-GSTlast-2').val().replace(/,/g, ''));
      var creBank = parseFloat($('#txtInputCreditCBdetailRow-1').val().replace(/,/g, ''));
      //var xxxCredit   = sumAmountD-(creGST+sumACcredit+creBank);
      var xxxCredit = (sumAmountC + sumACcredit) - (sumAmountD + sumACdebit);
      $('#txtInputDebitCBdetailRow-addCostRow-1').val(addCommas(xxxCredit.toFixed(2)));

      amountDebt = sumAmountD + xxxCredit + sumACdebit;
      amountCred = sumAmountC + sumACcredit;
    } else {
      //alert(parseFloat($('#txtInputDebitCBdetailRow-GSTlast-2').val()));
      //var debGST      = parseFloat($('#txtInputDebitCBdetailRow-GSTlast-2').val().replace(/,/g, ''));
      var debBank = parseFloat($('#txtInputDebitCBdetailRow-1').val().replace(/,/g, ''));
      var xxxDebit = (sumAmountC + sumACcredit) - (sumAmountD + sumACdebit);
      $('#txtInputDebitCBdetailRow-addCostRow-1').val(addCommas(xxxDebit.toFixed(2)));

      amountDebt = sumAmountD + sumACdebit + xxxDebit;
      amountCred = sumAmountC + sumACcredit;
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

  /* #################################################################################################### */
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
      color: "#D9000B",
      reach: 30,
      repeat: 15,
      speed: 500,
      glow: true
    });
  }

  function setToast(txtMsg) {
    $('#toast-container').stop().fadeIn(200).delay(2000).fadeOut(100);
    $('.toast-message').html(txtMsg);
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
  /* 
  #################################################################################################### */
</script>