<?php
if ($this->input->get("dari") <> '') {
  $dari = $this->input->get("dari");
  $sampai = $this->input->get("sampai");
  $cur = $this->input->get("currency");
  $coa = $this->input->get('jenis_coa');
  $coa_new = $this->input->get('new_coa');
  $parts = explode('-', $coa_new);
  $coa_new = isset($parts[0], $parts[1]) ? $parts[0] . '-' . $parts[1] : '';
  
  $check_coa = $this->input->get('check_coa');
  $dept_code = $this->input->get('dept_code');
  if ($check_coa==1) {
    $coa_number = $coa_new;
  }else{
    $coa_number = $coa;
  }
} else {
  $tgl2 = date_create($tgl1);
  $dari = date_format($tgl2, 't-m-Y');
  $sampai = date('t-m-Y', strtotime($dari));
  $cur = "";
  $coa = "";
  $coa_new = "";
  $check_coa = "";
}

setlocale(LC_MONETARY, 'en_US.UTF-8');
?>
<div class="page-head">
  <div class="container-fluid">
    <!-- BEGIN PAGE TITLE -->
    <div class="page-title">
      <h1>Accounting Report <small>General Ledger</small></h1>
    </div>
    <!-- END PAGE TITLE -->
  </div>
</div>

<div class="page-contenet">
  <div class="container">

    <div class="row">
      <div class="col-md-12">
        <div class="portlet light">
          <div class="portlet-title">
            <div class="caption">
              <i class="fa fa-credit-card theme-font"></i>
              <span class="caption-subject theme-font">Monitoring General Ledger (Detail) For A/N <?php isset($coa) && $coa != '' ? $coa : (isset($coa_new) ? $coa_new : ''); ?></span>
            </div>
            <div class="tools">
              <a href="javascript:;" class="collapse"></a>
              <a href="javascript:;" class="reload"></a>
            </div>
          </div>

          <div class="portlet-body">
            <form action="<?php echo base_url(); ?>General_ledger/detail_transaction" method="get">
              <div class="portlet-body">
                <div class="form-body">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="col-md-4">
                        <label class="control-label col-md-3">Period</label>
                        <div class="col-md-9">
                          <div class="input-group date-picker input-daterange" data-date-format="dd-mm-yyyy">
                            <input type="text" class="form-control input-sm" id="from" name="dari" value="<?php echo $dari; ?>" required>
                            <span class="input-group-addon">
                              to </span>
                            <input type="text" class="form-control input-sm" id="to" name="sampai" value="<?php echo $sampai; ?>" required>
                          </div>
                        </div>
                      </div>

                      <div class="col-md-4" id="coa_section">
                        <label class="control-label col-md-3">Account</label>
                        <div class="col-md-9">
                          <?php
                          $style_coa = 'class="select2me form-control" id="coa" ';
                          echo form_dropdown('jenis_coa', $jenis_coa, $coa, $style_coa);
                          ?>
                        </div>
                      </div>
                      
                      <div class="col-md-4" id="new_coa_section" style="display: none;">
                        <label class="control-label col-md-3">New Account</label>
                        <div class="col-md-9">
                          <?php
                          $style_coa = 'class="select2me form-control" id="coa_new" ';
                          echo form_dropdown('new_coa', $new_coa, $coa_new, $style_coa);
                          ?>
                        </div>
                      </div>

                      <div class="col-md-4">
                        <button type="submit" class="btn purple kiri col-md-3"><i class="fa fa-refresh"></i> Filter</button>
                        <a href="<?php echo base_url(); ?>Excel/toExcelGlDetail?dari=<?php echo $dari; ?>&sampai=<?php echo $sampai; ?>&jenis_coa=<?php echo $coa; ?>" class="btn green col-md-3" id="excel_link"><i class="fa fa-file-excel-o "></i> Excel</a>
                        <a href="<?php echo base_url(); ?>General_ledger/print_report?dari=<?php echo $dari; ?>&sampai=<?php echo $sampai; ?>&check_coa=<?php echo $check_coa; ?>&no_coa=<?php echo $coa_number; ?>&dept_code=<?php echo $dept_code; ?>" class="btn btn-primary"><i class="fa fa-print"></i> Print</a>
                        <!-- <button type="button" class="btn btn-primary"><i class="fa fa-print"></i> Print</button> -->
                      </div>

                      <div class="col-md-1">
                          <label>
                              <input type="checkbox" id="toggle_coa" value="1" name="check_coa"> New Account
                          </label>
                      </div>
                    </div>
                  </div>
                  <hr>

                  <?php
                  $bD = 0;
                  if (!empty($detail_trans)) {
                    $begining = str_replace(",", "", $this->input->get("beginning"));

                  ?>
                    <table class="table table-bordered" id="tabelin">
                      <thead>
                        <th width="10%">Invoice Number</th>
                        <th width="10%">Date of Journal</th>
                        <th width="20%">Vendor / Customer</th>
                        <th width="10%">Check Number</th>
                        <th width="10%">B/L Code</th>
                        <th width="20%">Description</th>
                        <th width="10%">Debit(LC) </th>
                        <th width="10%">Credit(LC) </th>
                        <th width="10%">Balance(LC) </th>
                        <th width="10%">Debit(FC) </th>
                        <th width="10%">Credit(FC) </th>
                        <th width="10%">Balance(FC)</th>
                      </thead>

                      <tbody>
                        <?php
                        $tDebet = 0;
                        $tKredit = 0;
                        $tBalance = 0;
                        $tDebetSGD = 0;
                        $tKreditSGD = 0;
                        $tBalanceSGD = 0;
                        $saldo = 0;
                        foreach ($detail_trans as $s) {
                          if ($s->tmp_debet < 0) {
                              $s->tmp_kredit += abs($s->tmp_debet);
                              $s->tmp_debet = 0;
                          }

                          if ($s->tmp_debet_sgd < 0) {
                              $s->tmp_kredit_sgd += abs($s->tmp_debet_sgd);
                              $s->tmp_debet_sgd = 0;
                          }
                          
                          $tDebet += $s->tmp_debet;
                          $tKredit += $s->tmp_kredit;
                          $tBalance = $s->tmp_balance;
                          $tDebetSGD += $s->tmp_debet_sgd;
                          $tKreditSGD += $s->tmp_kredit_sgd;
                          $tBalanceSGD = $s->tmp_balance_sgd;
                          $tgl_jurnal = date_format(date_create($s->tmp_tanggal), "d F Y");
                          $saldo += $s->tmp_debet - $s->tmp_kredit;

                        ?>
                          <tr>
                            <td><?php echo $s->tmp_nojurnal; ?></td>
                            <td style="text-align:"><?php echo $tgl_jurnal; ?> </td>
                            <td><textarea rows="1" cols="80" class="txt"><?php echo $s->tmp_sup_cust; ?></textarea></td>
                            <td><textarea rows="1" cols="80" class="txt"> <?php echo $s->tmp_check_bank; ?></textarea></td>
                            <td><textarea rows="1" cols="80" class="txt"><?php echo $s->tmp_blCode; ?></textarea></td>
                            <td><textarea rows="1" cols="80" class="txt"><?php echo $s->tmp_uraian; ?></textarea></td>
                            <td style="text-align: right"><?php echo str_replace("-", "", number_format($s->tmp_debet, 2, ",", ".")); ?></td>
                            <td style="text-align: right"><?php echo str_replace("-", "", number_format($s->tmp_kredit, 2, ",", ".")); ?></td>
                            <td style="text-align: right"><?php echo str_replace("$", "", money_format('%(#10n', $s->tmp_balance)); ?></td>
                            <td style="text-align: right"><?php echo str_replace("-", "", number_format($s->tmp_debet_sgd, 2, ",", ".")); ?></td>
                            <td style="text-align: right"><?php echo str_replace("-", "", number_format($s->tmp_kredit_sgd, 2, ",", ".")); ?></td>
                            <td style="text-align: right"><?php echo str_replace("$", "", money_format('%(#10n', $s->tmp_balance_sgd)); ?></td>
                          </tr>
                        <?php
                        }
                        ?>
                      </tbody>
                      <tfoot>
                        <tr>
                          <td colspan="6" style="text-align: right">Total</td>
                          <td style="text-align: right"><?php echo str_replace("-", "", number_format($tDebet, 2, ",", ".")); ?></td>
                          <td style="text-align: right"><?php echo str_replace("-", "", number_format($tKredit, 2, ",", ".")); ?></td>
                          <td style="text-align: right"><?php echo str_replace("$", "", money_format('%(#10n', $tBalance)); ?></td>
                          <td style="text-align: right"><?php echo str_replace("-", "", number_format($tDebetSGD, 2, ",", ".")); ?></td>
                          <td style="text-align: right"><?php echo str_replace("-", "", number_format($tKreditSGD, 2, ",", ".")); ?></td>
                          <td style="text-align: right"><?php echo str_replace("$", "", money_format('%(#10n', $tBalanceSGD)); ?></td>
                        </tr>
                      </tfoot>
                    </table>
                  <?php } ?>
                </div>

              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>

<script type="text/javascript">
  $(document).ready(function() {
    $("#tabel").dataTable({
      "scrollY": 400,
      "scrollX": true,
      "iDisplayLength": 100
    });

  });

  $(document).ready(function () {
    var useNewCoa = localStorage.getItem("use_new_coa");
    var baseUrl = "<?php echo base_url(); ?>Excel/toExcelGlDetail";
    var dari = "<?php echo $dari; ?>";
    var sampai = "<?php echo $sampai; ?>";
    var new_coa = "<?php echo $coa_new; ?>";
    var jenis_coa = "<?php echo $coa; ?>"; 

    if (useNewCoa === "true") {
        $("#toggle_coa").prop("checked", true).val("1");
        $("#coa_section").hide();
        $("#new_coa_section").show();
    } else {
        $("#toggle_coa").prop("checked", false).val("0");
        $("#coa_section").show();
        $("#new_coa_section").hide();
    }

    $("#toggle_coa").change(function () {
        if ($(this).is(":checked")) {
            $("#coa_section").hide();
            $("#new_coa_section").show();
            $(this).val("1");
            localStorage.setItem("use_new_coa", "true");
            $("#excel_link").attr("href", baseUrl + "?dari=" + dari + "&sampai=" + sampai + "&new_coa=" + new_coa + "&check_coa=" + 1);
        } else {
            $("#coa_section").show();
            $("#new_coa_section").hide();
            $(this).val("0");
            localStorage.setItem("use_new_coa", "false");
            $("#excel_link").attr("href", baseUrl + "?dari=" + dari + "&sampai=" + sampai + "&jenis_coa=" + jenis_coa + "&check_coa=" + 0);
        }
    });

    $("#toggle_coa").trigger("change");
  });
  
</script>