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

<script src="<?php echo base_url(); ?>assets/global/jq/inputmask.js"></script>
<script>
  $(document).ready(function() {
    //$('#inputNoReff').inputmask("aa99/999999/999");
  });
</script>
<div class="page-content">
  <div class="container-fluid">
    <div class="row">
      <form id="form-transCashBank" role="form" method="post" action="<?php echo site_url('Transaction_CashBank/sendCashBank'); ?>" class="form-horizontal">
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
                          <input type="text" id="inputNoReff" name="txtNoReff" maxlength="20" class="form-control input-sm" required />
                          <span id="alert-errorReff" class="help-block" style="display: none;">Please use another num reff.! </span>
                        </div>
                      </div>
                      <script>
                        $('#inputNoReff').on('change', function() {
                          var val = $('#inputNoReff').val();
                          $.ajax({
                            type: "POST",
                            url: "<?php echo base_url(); ?>Transaction_CashBank/cekNumReff",
                            data: {
                              value: val
                            },
                            dataType: "json",
                            success: function(n) {
                              if (n === 1) {
                                $('#div-ReffNum').addClass('has-error');
                                document.getElementById('alert-errorReff').style.display = 'block';
                                $('#form-transCashBank').submit(function() {
                                  return false;
                                });
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
                        <label class="control-label col-sm-4">I/O Type</label>
                        <div class="col-sm-8">
                          <!-- <input type="text" id="txtInputIOtype" class="form-control input-sm"/> -->
                          <select class="form-control input-sm" name="txtIO" id="inputIOCest">
                            <option value="">Choose...</option>
                            <?php foreach ($_selectIOtype as $io) : ?>
                              <option value="<?php echo $io->io_code; ?>"><?php echo $io->io_description; ?></option>
                            <?php endforeach; ?>
                          </select>
                        </div>
                      </div>
                    </div>

                    <div class="col-sm-4">
                      <div class="form-group">
                        <label class="control-label col-sm-2">Date 1</label>
                        <div class="col-sm-10">
                          <input name="txtDate1" type="text" class="form-control input-sm" readonly value="<?php echo date('Y-m-d'); ?>">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-sm-2">Date 2</label>
                        <div class="col-sm-10">
                          <input name="txtDate2" type="text" class="form-control input-sm date-picker" data-date-format="yyyy-mm-dd">
                        </div>
                      </div>
                    </div>

                    <!--<div class="col-sm-4">
                                            <div class="form-group">
                                                <label class="control-label col-sm-4">Pending Cash Pref.</label>
                                                <div class="col-sm-8">
                                                    <input name="txtPendingCashPref" type="text" class="form-control input-sm date-picker" data-date-format="yyyy-mm-dd" >
                                                </div>
                                            </div>
                                        </div>-->
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

                          if (txtIO === '' || txtIO === null) {
                            bootbox.alert('First choose IO Type!');
                            return false;
                          } else {
                            //alert(nameCOA.substr(pemisah+2));
                            $('#txtInputRemark').val(nameCOA.substr(pemisah + 2));
                            //alert(noReff);
                            //alert("<?php // echo site_url('Transaction_CashBank/ajaxFirstRowDetail/');
                                      ?>/" +id);
                            $.ajax({
                              url: "<?php echo site_url('Transaction_CashBank/ajaxFirstRowDetail/'); ?>/" + id,
                              type: "POST",
                              data: "noReff=" + txtIO,
                              datatype: "json",
                              cache: false,
                              success: function(msg) {
                                $("#rowSetCOA").html(msg);
                              }
                            });

                            return true;
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
                  <br />

                  <div class="col-md-8">
                    <div class="panel panel-primary">
                      <div class="panel-body">
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
                            <input type="text" name="" class="form-control input-sm" required />
                          </div>
                        </div>
                        <script>
                          function changePrepaid(sel) {
                            //                                                        alert(sel.value);
                            if (sel.value === '1') {
                              document.getElementById('div-supplier').style.display = "block";
                              document.getElementById('div-costumer').style.display = "none";
                              $('#txtInputSupp').attr('required', true);
                              $('#txtInputCust').attr('required', false);
                            } else {
                              document.getElementById('div-supplier').style.display = "none";
                              document.getElementById('div-costumer').style.display = "block";
                              $('#txtInputSupp').attr('required', false);
                              $('#txtInputCust').attr('required', true);
                            }
                          };
                        </script>

                        <div id="div-supplier" class="col-sm-12" style="display: block;">
                          <div class="col-sm-4">
                            <div class="form-group">
                              <label class="control-label col-sm-4">Supplier</label>
                              <div class="col-sm-8">
                                <input type="text" id="txtInputSupp" name="txtSup" class="form-control input-sm" />
                                <ul class="dropdown-menu classInputSupp" style="margin-left:15px;margin-right:0px; max-height: 300px; overflow-y: scroll;" role="menu" aria-labelledby="dropdownMenu" id="ddInputSupp"></ul>
                              </div>
                            </div>
                          </div>
                          <div class="col-sm-4">
                            <input type="text" id="txtInputSupCOA" name="txtSupCOA" class="form-control input-sm" onclick="viewModalMCOAsup()" />
                          </div>
                          <div class="col-sm-4">
                            <input type="text" id="txtInputSupRemark" name="txtSupRemark" class="form-control input-sm" />
                          </div>
                        </div>

                        <div id="div-costumer" class="col-sm-12" style="display: none;">
                          <div class="col-sm-4">
                            <div class="form-group">
                              <label class="control-label col-sm-4">Customer</label>
                              <div class="col-sm-8">
                                <input type="text" id="txtInputCust" name="txtCos" class="form-control input-sm" />
                                <ul class="dropdown-menu classInputCust" style="margin-left:15px;margin-right:0px; max-height: 300px; overflow-y: scroll;" role="menu" aria-labelledby="dropdownMenu" id="ddInputCust"></ul>
                              </div>
                            </div>
                          </div>
                          <div class="col-sm-4">
                            <input type="text" id="txtInputCosCOA" name="txtCosCOA" class="form-control input-sm" />
                          </div>
                          <div class="col-sm-4">
                            <input type="text" id="txtInputCosRemark" name="txtCosRemark" class="form-control input-sm" />
                          </div>
                        </div>

                      </div>
                    </div>
                  </div>

                  <div class="col-md-4">
                    <div class="col-sm-12">
                      <div class="form-group">
                        <label class="control-label col-sm-2">Currency</label>
                        <div class="col-sm-10">
                          <select class="form-control input-sm select2me" data-placeholder="Choose Currency..." name="txtCurr" id="txtInputCurr">
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
                            //alert('asasa = '+val);
                            $.ajax({
                              type: "POST",
                              url: "<?php echo base_url(); ?>Transaction_CashBank/getRateByCurrency",
                              data: {
                                keyword: val
                              },
                              dataType: "json",
                              success: function(n) {
                                //alert(n);
                                $('#txtInputRate').val(n.toFixed(6));
                              }
                            });
                          });

                          $('.hanya-baca').on('keydown keypress keyup', false);
                        });
                      </script>
                    </div>
                    <div class="col-sm-12">
                      <div class="form-group">
                        <label class="control-label col-sm-2">Rate</label>
                        <div class="col-sm-10">
                          <input type="text" id="txtInputRate" name="txtRateCurr" class="form-control input-sm hanya-baca" required />
                        </div>
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
                    <th class="text-center">
                      <a class="btn btn-xs btn-link baik" data-toggle="modal" href="#basic" onclick="viewModalMCOA()">
                        <i class="fa fa-plus"></i></a>
                    </th>
                    <th>Account Number</th>
                    <th>Name</th>
                    <th>Debit</th>
                    <th>Credit</th>
                    <th>Remark</th>
                    <th>Cash Flow</th>
                  </tr>
                </thead>
                <tbody>
                  <tr id="rowSetCOA">
                    <td class="text-center" style="vertical-align: middle;">
                      <button class="btn btn-xs btn-link biasa" type="button"><i class="fa fa-arrow-down"></i></button>
                    </td>
                    <td nowrap><input type="text" name="txtNoCOA[]" class="txt" value="" readonly /></td>
                    <td nowrap><input type="text" name="txtNameCOA[]" class="txt" value="" readonly /></td>
                    <td nowrap><input type="number" name="txtDebit[]" onKeyup="calculateAmountDebit()" onchange="calculateAmountDebit()" class="col-debit col-debit1 txt" /></td>
                    <td nowrap><input type="number" name="txtCredit[]" onKeyup="calculateAmountCredit()" onchange="calculateAmountCredit()" class="col-credit col-credit1 txt" /></td>
                    <td nowrap><input type="text" name="txtRemark[]" class="txt" /></td>
                    <td nowrap>
                      <input id="cf-1" type="text" name="txtCashFlow[]" onClick="viewModalCashFlow(this.id)" class="txt cf-text" />
                      <input id="cf-1-key" type="hidden" name="txtCashFlowKey[]" class="txt" />
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
            <div class="portlet-body">
              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group">
                    <label class="col-sm-12" for="">Amount Debit</label>
                    <div class="col-sm-12">
                      <input class="form-control" name="txtAmountDebit" id="inputAmountDebit" type="text" readonly="" />
                    </div>
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="form-group">
                    <label class="col-sm-12" for="">Amount Credit</label>
                    <div class="col-sm-12">
                      <input class="form-control" name="txtAmountCredit" id="inputAmountCredit" type="text" readonly="" />
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
                <div class="col-md-12 text-right">

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

<div class="modal fade" id="modal-COA-suplier" tabindex="-1" role="basic" aria-hidden="true">
  <div class="modal-dialog" style="width: 75%;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title">Select Master COA Suplier</h4>
      </div>
      <div class="modal-body">
        <div id="modalMasterCOAsup"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn default" data-dismiss="modal">Close</button>
      </div>
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
        <input class="form-control input-sm" id="id-cf-this" type="hidden" value="">
        <div id="modalCashFlow" class="table-responsive"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  $(document).ready(function() {
    $("#txtInputSupp").on('keyup', function() {
      //alert('asdsadsa'+$("#txtInputSupp").val());
      $.ajax({
        type: "POST",
        url: "<?php echo site_url(); ?>Transaction_CashBank/getSupplier",
        data: {
          keyword: $("#txtInputSupp").val()
        },
        dataType: "json",
        success: function(n) {
          n.length > 0 ? ($("#ddInputSupp").empty(), $("#txtInputSupp").attr("data-toggle", "dropdown"), $("#ddInputSupp").dropdown("toggle")) : 0 == n.length && $("#txtInputSupp").attr("data-toggle", ""), $.each(n, function(e, d) {
            n.length >= 0 && $("#ddInputSupp").append('<li role="presentation" > <a role="menuitem dropdownnameli" class="dropdownlivalue">' + d.suppliercompany + ' ~ ' + d.supplierid + ' </li>');
          });
        }
      });
    });
    $("ul.classInputSupp").on("click", "li a", function() {
      var supp = $(this).text();
      var kode = supp.search("~");
      var idSupp = supp.substr(kode + 2);
      //bootbox.alert('You choose id: '+idJur);
      $("#txtInputSupp").val(idSupp.replace(" ", ''));
      $.ajax({
        type: 'POST',
        url: "<?php echo site_url(); ?>Transaction_CashBank/getSupplierAgain",
        data: {
          idSupp: idSupp.replace(" ", '')
        },
        dataType: 'json',
        success: function(respon) {
          $.each(respon, function(e, data) {
            $("#txtInputSupCOA").val(data.nocoa);
            $("#txtInputSupRemark").val(data.suppliercompany);
          });
        }
      });
    });
    //customer
    $("#txtInputCust").keyup(function() {
        $.ajax({
          type: "POST",
          url: "<?php echo base_url(); ?>Transaction_CashBank/getCustomer",
          data: {
            keyword: $("#txtInputCust").val()
          },
          dataType: "json",
          success: function(n) {
            n.length > 0 ? ($("#ddInputCust").empty(), $("#txtInputCust").attr("data-toggle", "dropdown"), $("#ddInputCust").dropdown("toggle")) : 0 == n.length && $("#txtInputCust").attr("data-toggle", ""), $.each(n, function(e, d) {
              n.length >= 0 && $("#ddInputCust").append('<li role="presentation" > <a role="menuitem dropdownnameli" class="dropdownlivalue">' + d.customer_company_name + ' ~ ' + d.customer_code + '</li>');
            });
          }
        });
      }),
      $("ul.classInputCust").on("click", "li a", function() {
        var cust = $(this).text();
        var kode = cust.search("~");
        var idCust = cust.substr(kode + 2);
        //alert(cust.substr(0,kode));
        //bootbox.alert('You choose id: '+idJur);
        $("#txtInputCust").val(idCust);
        $.ajax({
          type: 'POST',
          url: "<?php echo site_url(); ?>Transaction_CashBank/getCustomerAgain",
          data: {
            idCust: idCust
          },
          dataType: 'json',
          success: function(respon) {
            $.each(respon, function(e, data) {
              $("#txtInputCosCOA").val(data.coa);
              $("#txtInputCosRemark").val(data.customer_company_name);
            });
          }
        });
        //$("#txtInputCosRemark").val(cust.substr(0,kode-1));
        //$("#txtInputCosCOA").val('100031301');
      });
  });
</script>
<script type="text/javascript">
  function viewModalMCOAsup() {
    $("#modalMasterCOAsup").html("\n\
            <div class='col-md-12'>\n\
                <form role='form' class='form-horizontal'>\n\
                    <div class='form-group'>\n\
                        <div class='col-md-12'>\n\
                            <div class='input-group'>\n\
                                <input class='form-control input-sm' id='txtFilter' placeholder='You can find here...'>\n\
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
                <table id='tbl-MasterCOAsup' class='table table-bordered table-striped'>\n\
                    <thead>\n\
                        <tr>\n\
                            <th>COA Number</th>\n\
                            <th>Account Name</th>\n\
                            <th>COA Group</th>\n\
                            <th>Reg Number</th>\n\
                        </tr>\n\
                    </thead>\n\
                    <tbody>\n\
                        <tr onclick='selCOAsup(this)'>\n\
                            <td></td><td></td><td></td><td></td>\n\
                        </tr>\n\
                    </tbody>\n\
                </table>\n\
            </div>");
    $("#modal-COA-suplier").modal('show');
  }

  function viewModalMCOA() {
    $("#modalMasterCOA").html("\n\
            <div class='col-md-12'>\n\
                <form role='form' class='form-horizontal'>\n\
                    <div class='form-group'>\n\
                        <div class='col-md-12'>\n\
                            <div class='input-group'>\n\
                                <input class='form-control input-sm' id='txtFilter' placeholder='You can find here...'>\n\
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
                        <tr onclick='addRow(this)'>\n\
                            <td>&nbsp;</td><td></td><td></td><td></td>\n\
                        </tr>\n\
                    </tbody>\n\
                </table>\n\
            </div>");
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
</script>

<script>
  function ajaxMCOA() {
    var key = document.getElementById("txtFilter").value;
    var noReff = document.getElementById('inputIOCest').value;
    //var ress    = noReff.substr(0,2);
    //        alert("<?php // echo base_url(); 
                      ?>/Transaction_CashBank/AjaxGetMasterCOA/"+key+"/"+ress);
    //        var finditem = document.getElementById("txtFilter").value;
    if (noReff === '' || noReff === null) {
      bootbox.alert('First choose IO Type!');
      return false;
    }
    $.ajax({
      url: "<?php echo base_url(); ?>/Transaction_CashBank/AjaxGetMasterCOA/" + key + "/" + noReff,
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
<script src="<?php echo base_url(); ?>assets/global/plugins/bootbox/bootbox.min.js" type="text/javascript"></script>
<script language="javascript">
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

  function addRow(x) {
    function getText(el) {
      if (typeof el.textContent === 'string') return el.textContent;
      if (typeof el.innerText === 'string') return el.innerText;
    }

    $r = x.rowIndex;

    //var lengt   = document.getElementsByClassName('cf-text').length;
    var idCFbefore = $('#tbl-cashGeneral tr:last input.cf-text').attr("id");
    var getNumIdCFBefore = idCFbefore.substr(3, 1);
    var currentIDCF = parseInt(getNumIdCFBefore) + 1;
    //alert(currentIDCF);

    var test = getText(document.getElementById('tbl-MasterCOA').rows[$r].cells[4]);
    if (test === 'o' || test === 'O') {
      $('table[id="tbl-cashGeneral"]').append('<tr >\n\
                <td class="text-center" style="vertical-align: middle;">\n\
                    <button class="btn btn-xs btn-link buruk" type="button" onclick="deleteRow(this)"><i class="fa fa-trash-o"></i></button></td>\n\
                <td nowrap><input type="text" name="txtNoCOA[]"  class="txt" value="' + getText(document.getElementById('tbl-MasterCOA').rows[$r].cells[0]) + '" readonly/></td>\n\
                <td nowrap><input type="text" name="txtNameCOA[]" class="txt" value="' + getText(document.getElementById('tbl-MasterCOA').rows[$r].cells[1]) + '" readonly/></td>\n\
                <td nowrap><input type="number" name="txtDebit[]" onKeyup="calculateAmountDebit()" class="col-debit txt" /></td>\n\
                <td nowrap><input type="number" name="txtCredit[]" readonly onKeyup="calculateAmountCredit()" class="col-credit txt"/></td>\n\
                <td nowrap><input type="text" name="txtRemark[]" class="txt"/></td>\n\
                <td nowrap>\n\
                    <input id="cf-' + currentIDCF + '" type="text" name="txtCashFlow[]" onClick="viewModalCashFlow(this.id)" class="txt cf-text"/>\n\
                    <input id="cf-' + currentIDCF + '-key" type="hidden" name="txtCashFlowKey[]" class="txt"/>\n\
                </td>\n\
            </tr>');
    } else {
      $('table[id="tbl-cashGeneral"]').append('<tr >\n\
                <td class="text-center" style="vertical-align: middle;">\n\
                    <button class="btn btn-xs btn-link buruk" type="button" onclick="deleteRow(this)"><i class="fa fa-trash-o"></i></button></td>\n\
                <td nowrap><input type="text" name="txtNoCOA[]"  class="txt" value="' + getText(document.getElementById('tbl-MasterCOA').rows[$r].cells[0]) + '" readonly/></td>\n\
                <td nowrap><input type="text" name="txtNameCOA[]" class="txt" value="' + getText(document.getElementById('tbl-MasterCOA').rows[$r].cells[1]) + '" readonly/></td>\n\
                <td nowrap><input type="number" name="txtDebit[]" readonly onKeyup="calculateAmountDebit()" class="col-debit txt" /></td>\n\
                <td nowrap><input type="number" name="txtCredit[]" onKeyup="calculateAmountCredit()" class="col-credit txt"/></td>\n\
                <td nowrap><input type="text" name="txtRemark[]" class="txt"/></td>\n\
                <td nowrap>\n\
                    <input id="cf-' + currentIDCF + '" type="text" name="txtCashFlow[]" onClick="viewModalCashFlow(this.id)" class="txt cf-text"/>\n\
                    <input id="cf-' + currentIDCF + '-key" type="hidden" name="txtCashFlowKey[]" class="txt"/>\n\
                </td>\n\
            </tr>');
    }

    $("#basic").modal('hide');
  }

  function deleteRow(x) {
    var row = x.parentNode.parentNode;

    bootbox.confirm("Are you sure?", function(result) {
      if (result == true) {
        row.parentNode.removeChild(row);
      }
    });
  }

  function calculateAmountDebit() {
    var sum = 0;
    $(".col-debit").each(function() {
      if (!isNaN(this.value) && this.value.length !== 0) {
        sum += parseFloat(this.value);
      }
    });
    document.getElementById('inputAmountDebit').value = sum;

    var a = document.getElementById('inputAmountDebit').value;
    var b = document.getElementById('inputAmountCredit').value;
    if (a !== b) {
      document.getElementById('alert-balanceAmount').style.display = 'block';
      return false;
    } else {
      document.getElementById('alert-balanceAmount').style.display = 'none';
    }
  }

  function calculateAmountCredit() {
    var sum = 0;
    $(".col-credit").each(function() {
      if (!isNaN(this.value) && this.value.length !== 0) {
        sum += parseFloat(this.value);
      }
    });
    document.getElementById('inputAmountCredit').value = sum;

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