<style>
  #table-pend-cash {
    white-space: nowrap;
  }
</style>
<div class="page-content">
  <div class="container-fluid">
    <div class="row">

      <div class="col-md-12">
        <div class="portlet light">
          <div class="portlet-title">
            <div class="caption theme-font">
              <i class="icon-calculator theme-font"></i>
              <span class="caption-subject bold uppercase"> TRANSACTION</span>
              <span class="caption-helper">Pending Cash</span>
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
            <form role="form" method="post" action="<?php echo site_url('Transaction_CashBank/insertPendingCash'); ?>" class="form-horizontal">
              <div class="row">
                <div class="col-sm-12">
                  <div class="col-sm-4">
                    <div id="div-ReffNum" class="form-group">
                      <label class="control-label col-sm-4">Reference Number</label>
                      <div class="col-sm-8">
                        <input id="inputNoReff" type="text" name="txtNumReff" maxlength="20" class="form-control input-sm" required />
                        <span id="alert-errorReff" class="help-block" style="display: none;">Please use another num reff.! </span>
                      </div>
                    </div>
                  </div>
                  <script>
                    $('#inputNoReff').on('change', function() {
                      var val = $('#inputNoReff').val();
                      $.ajax({
                        type: "POST",
                        url: "<?php echo base_url(); ?>Transaction_CashBank/cekNumReffPC",
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
                  <div class="col-sm-4">
                    <div class="form-group">
                      <label class="control-label col-sm-4">Trans Date</label>
                      <div class="col-sm-8">
                        <input id="txtInputTglTrans" name="txtTransDate" value="<?php echo date('Y-m-d'); ?>" type="text" class="form-control input-sm date-picker" data-date-format="yyyy-mm-dd">
                      </div>
                    </div>
                  </div>
                </div>

                <div class="col-sm-12">
                  <div class="col-sm-4">
                    <div class="form-group">
                      <label class="control-label col-sm-4">Cash Bank Code</label>
                      <div class="col-sm-8">
                        <select class="form-control input-sm select2me" data-placeholder="Choose Code..." name="selCashBank" id="selInputCashBank">
                          <option value=""></option>
                          <?php foreach ($_selectMasterCOA as $row) : ?>
                            <option value="<?php echo $row->NoCOA; ?>"><?php echo $row->NoCOA; ?> ~ <?php echo $row->AccountName; ?></option>
                          <?php endforeach; ?>
                        </select>
                      </div>
                    </div>
                    <script>
                      $('#selInputCashBank').on('change', function() {
                        var nameCOA = $('#selInputCashBank option:selected').text();
                        var pemisah = nameCOA.search("~");
                        $('#txtInputRemark').val(nameCOA.substr(pemisah + 2));
                      });
                    </script>
                  </div>
                  <div class="col-sm-4">
                    <div class="form-group">
                      <label class="control-label col-sm-4">Account Name</label>
                      <div class="col-sm-8">
                        <input type="text" id="txtInputRemark" name="txtRemark" class="form-control input-sm hanya-baca" required />
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-4">
                    <div class="form-group">
                      <label class="control-label col-sm-4">Term</label>
                      <div class="col-sm-8">
                        <input id="txtInputJangkaTempo" type="text" value="0" name="txtTermDay" class="form-control input-sm input-inline" required />
                        <span class="help-inline"> Days</span>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-sm-12">
                  <div class="col-sm-4">
                    <div class="form-group">
                      <label class="control-label col-sm-4">Receiver</label>
                      <div class="col-sm-8">
                        <input type="text" name="txtReceiver" class="form-control input-sm" required />
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-4">
                    <div class="form-group">
                      <label class="control-label col-sm-4">Dept</label>
                      <div class="col-sm-8">
                        <input type="text" name="txtDept" class="form-control input-sm" required />
                        <!-- <select class="form-control input-sm select2me" data-placeholder="Choose Department..." name="txtDept" id="txtInputDept">
                                                    <option value=""></option>
                                                </select> -->
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-4">
                    <div class="form-group">
                      <label class="control-label col-sm-4">Deu Date</label>
                      <div class="col-sm-8">
                        <input id="txtInputTglJatuhTempo" name="txtDeuDate" value="<?php echo date('Y-m-d'); ?>" type="text" class="form-control input-sm date-picker" data-date-format="yyyy-mm-dd">
                      </div>
                    </div>
                  </div>
                </div>

                <div class="col-sm-12">
                  <div class="col-sm-4">
                    <div class="form-group">
                      <label class="control-label col-sm-4">Currency</label>
                      <div class="col-sm-8">
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
                      });
                    </script>
                  </div>
                  <div class="col-sm-4">
                    <div class="form-group">
                      <label class="control-label col-sm-4">Rate</label>
                      <div class="col-sm-8">
                        <input id="txtInputRate" type="text" name="txtRate" class="form-control input-sm hanya-baca" required />
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-4">
                    <div class="form-group">
                      <label class="control-label col-sm-4">Amount</label>
                      <div class="col-sm-8">
                        <input type="text" name="txtAmount" class="form-control input-sm" required />
                      </div>
                    </div>
                  </div>
                </div>

                <div class="col-sm-12">
                  <div class="col-sm-8">
                    <div class="panel panel-primary">
                      <div class="panel-body">
                        <div class="col-sm-6">
                          <div class="form-group">
                            <label class="control-label col-sm-4">Use for</label>
                            <div class="col-sm-8">
                              <select class="form-control input-sm select2me" data-placeholder="Choose Used for..." name="selUsedFor" id="selInputUsedFor">
                                <option value=""></option>
                                <?php foreach ($_selectUsedFor as $uf) : ?>
                                  <option value="<?php echo $uf->uf_name; ?>"><?php echo $uf->uf_name; ?></option>
                                <?php endforeach; ?>
                              </select>
                            </div>
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <div class="form-group">
                            <label class="control-label col-sm-4">Official travel</label>
                            <div class="col-sm-8">
                              <select class="form-control input-sm select2me" data-placeholder="Choose Department..." name="selOffTravel" id="selInputOffTravel">
                                <option value=""></option>
                                <?php foreach ($_selectOffTravel as $ot) : ?>
                                  <option value="<?php echo $ot->ot_name; ?>"><?php echo $ot->ot_name; ?></option>
                                <?php endforeach; ?>
                              </select>
                            </div>
                          </div>
                        </div>

                        <div class="col-sm-12">
                          <div class="form-group">
                            <label class="control-label col-sm-2">Description</label>
                            <div class="col-sm-10">
                              <input type="text" name="txtDescription" class="form-control input-sm" required />
                            </div>
                          </div>
                        </div>

                        <div class="col-sm-6">
                          <div class="form-group">
                            <label class="control-label col-sm-4">Journal Reff</label>
                            <div class="col-sm-8">
                              <input type="text" name="txtJournalReff" class="form-control input-sm" required />
                            </div>
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <div class="form-group">
                            <label class="control-label col-sm-4">Journal Date</label>
                            <div class="col-sm-8">
                              <input name="txtJournalDate" type="text" class="form-control input-sm date-picker" data-date-format="yyyy-mm-dd">
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="col-sm-4">
                    <div class="form-group">
                      <label class="control-label col-sm-4">Finished?</label>
                      <div class="radio-list col-sm-8">
                        <label class="">
                          <input type="radio" name="radFinished" class="radio" value="0" checked="" /> No</label>
                        <label class="">
                          <input type="radio" name="radFinished" class="radio" value="1" /> Yes</label>
                      </div>
                    </div>

                    <div class="form-group">
                      <div class="col-sm-2">
                        <button class="btn btn-sm btn-success" type="submit">
                          <i class="fa fa-save"></i> Submit
                        </button>
                      </div>
                    </div>
                  </div>
                </div>

              </div>

            </form>
            <!-- FORM MASTER COA -->
          </div>
        </div>
      </div>

      <div class="col-md-12">
        <!-- BEGIN PORTLET-->
        <div class="portlet light">
          <div class="portlet-title">
            <div class="caption theme-font">
              <i class="icon-speech theme-font"></i>
              <span class="caption-subject bold uppercase"> Pending Cash</span>
              <span class="caption-helper">Transaction</span>
            </div>
            <div class="actions">
              <a class="btn btn-circle btn-icon-only btn-default fullscreen" href="javascript:;" data-original-title="" title="">
              </a>
            </div>
          </div>
          <div class="portlet-body table-responsive">
            <table class="datatable table table-bordered table-hover" id="table-pend-cash">
              <thead>
                <tr>
                  <th>Ref Number</th>
                  <th>Trans Date</th>
                  <th>Cash Bank Code</th>
                  <th>Cash Bank Name</th>
                  <th>Receiver</th>
                  <th>Department</th>
                  <th>Term</th>
                  <th>Due Date</th>
                  <th>Currency</th>
                  <th>Currency Rate</th>
                  <th>Amount</th>
                  <th>Used for</th>
                  <th>Official Travel</th>
                  <th>Journal Reff</th>
                  <th>Journal Date</th>
                  <th>Description</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody>
                <?php $align    = array('l', 'r', 'l', 'l', 'l', 'l', 'r', 'r', 'l', 'r', 'r', 'l', 'l', 'l', 'r', 'l', 'c');
                foreach ($_selectPendCash as $pc) : ?>
                  <tr>
                    <td class="<?php echo align_text($align[0]); ?>"><?php echo $pc->no_reff; ?></td>
                    <td class="<?php echo align_text($align[1]); ?>"><?php echo date('F, d Y', strtotime($pc->trans_date)); ?></td>
                    <td class="<?php echo align_text($align[2]); ?>"><?php echo $pc->cb_code; ?></td>
                    <td class="<?php echo align_text($align[3]); ?>"><?php echo $pc->AccountName; ?></td>
                    <td class="<?php echo align_text($align[4]); ?>"><?php echo $pc->received_name; ?></td>
                    <td class="<?php echo align_text($align[5]); ?>"><?php echo $pc->departemen; ?></td>
                    <td class="<?php echo align_text($align[6]); ?>"><?php echo $pc->term; ?></td>
                    <td class="<?php echo align_text($align[7]); ?>"><?php echo $pc->due_date; ?></td>
                    <td class="<?php echo align_text($align[8]); ?>"><?php echo $pc->currency_id . ' - ' . $pc->currency_say_in_words; ?></td>
                    <td class="<?php echo align_text($align[9]); ?>"><?php echo $pc->currency_rate; ?></td>
                    <td class="<?php echo align_text($align[10]); ?>"><?php echo number_format($pc->amount, 2); ?></td>
                    <td class="<?php echo align_text($align[11]); ?>"><?php echo $pc->used_for; ?></td>
                    <td class="<?php echo align_text($align[12]); ?>"><?php echo $pc->official_travel; ?></td>
                    <td class="<?php echo align_text($align[13]); ?>"><?php echo $pc->journal_reff_no; ?></td>
                    <td class="<?php echo align_text($align[14]); ?>"><?php echo $pc->journal_date; ?></td>
                    <td class="<?php echo align_text($align[15]); ?>"><?php echo $pc->description; ?></td>
                    <td class="<?php echo align_text($align[16]); ?>">
                      <?php if ($pc->finished == 1) echo 'Finish';
                      else echo 'Not Yet'; ?>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>
        <!-- END PORTLET-->
      </div>
    </div>
  </div>
</div>
<script>
  $(document).ready(function() {
    $('#table-pend-cash').dataTable();

    $('.hanya-baca').on('keydown keypress keyup', false);

    $('#txtInputTglTrans').on('change keyup', function() {
      // varibel miliday sebagai pembagi untuk menghasilkan hari
      var miliday = 60 * 24 * 60 * 1000;
      //buat object Date
      var tglTerm = new Date($('#txtInputTglJatuhTempo').val());
      var tglTrans = new Date($('#txtInputTglTrans').val());
      // Date.parse akan menghasilkan nilai bernilai integer dalam bentuk milisecond
      var date1 = Date.parse(tglTrans);
      var date2 = Date.parse(tglTerm);
      var term = (date2 - date1) / miliday;
      $('#txtInputJangkaTempo').val(term);
    });

    $('#txtInputJangkaTempo').on('keyup', function() {
      var tglTrans = $('#txtInputTglTrans').val();
      var term = $(this).val();
      //alert(tglTrans);
      var date = new Date(tglTrans);
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
      var tglTerm = new Date($('#txtInputTglJatuhTempo').val());
      var tglTrans = new Date($('#txtInputTglTrans').val());
      // Date.parse akan menghasilkan nilai bernilai integer dalam bentuk milisecond
      var date1 = Date.parse(tglTrans);
      var date2 = Date.parse(tglTerm);
      var term = (date2 - date1) / miliday;
      $('#txtInputJangkaTempo').val(term);
    });
  });

  function formatDate(date) {
    var d = new Date(date),
      month = '' + (d.getMonth() + 1),
      day = '' + d.getDate(),
      year = d.getFullYear();
    if (month.length < 2)
      month = '0' + month;
    if (day.length < 2)
      day = '0' + day;
    return [year, month, day].join('-');
  }
</script>