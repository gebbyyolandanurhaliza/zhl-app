<?php
if ($this->input->get("dari") <> '') {
  $dari = $this->input->get("dari");
  $sampai = $this->input->get("sampai");
  $cur = $this->input->get("currency");
  $coa_new = $this->input->get('new_coa');
  $parts = explode('-', $coa_new);
  $coa_new = isset($parts[0], $parts[1]) ? $parts[0] . '-' . $parts[1] : '';
  $dept_code = $this->input->get('dept_code');
  $coa_number = $coa_new;
} else {
  $tgl2 = date_create($tgl1);
  $dari = date_format($tgl2, 't-m-Y');
  $sampai = date('t-m-Y', strtotime($dari));
  $cur = "";
  $coa_new = "";
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
              <span class="caption-subject theme-font">Monitoring General Ledger ZHT (Detail) For A/N <?php echo "$coa"; ?></span>
            </div>
            <div class="tools">
              <a href="javascript:;" class="collapse"></a>
              <a href="javascript:;" class="reload"></a>
            </div>
          </div>

          <div class="portlet-body">
            <form action="<?php echo base_url(); ?>General_ledger_zht/detail_transaction" method="get">
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
                      <!-- <div class="col-md-4">
                                                <label class="control-label col-md-3">Currency</label>
                                                <div class="col-md-9">
                                                    <?php
                                                    // $style_kategori = 'class="select2me form-control" id="currency" ';
                                                    // echo form_dropdown('currency', $CurrencyID, $cur, $style_kategori);
                                                    ?>
                                                </div>
                                            </div> -->

                      <div class="col-md-4">
                        <label class="control-label col-md-3">Account</label>
                        <div class="col-md-9">
                          <?php
                          $style_coa = 'class="select2me form-control" id="coa_new" ';
                          echo form_dropdown('new_coa', $new_coa, $coa_new, $style_coa);
                          ?>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <button type="submit" class="btn purple kiri col-md-3"><i class="fa fa-refresh"></i> Filter</button>
                        <a href="<?php echo base_url(); ?>Excel/toExcelGlDetail_zht?dari=<?php echo $dari; ?>&sampai=<?php echo $sampai; ?>&new_coa=<?php echo $coa_new; ?>" class="btn green col-md-3"><i class="fa fa-file-excel-o "></i> Excel</a>
                        <a href="<?php echo base_url(); ?>General_ledger_zht/print_report?dari=<?php echo $dari; ?>&sampai=<?php echo $sampai; ?>&no_coa=<?php echo $coa_number; ?>&dept_code=<?php echo $dept_code; ?>" class="btn btn-primary"><i class="fa fa-print"></i> Print</a>
                        <!-- <button type="button" class="btn btn-primary"><i class="fa fa-print"></i> Print</button> -->
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
                        <th width="20%">Description</th>
                        <th width="10%">B/L Code</th>
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
                          $t_sgd_SGD += $s->total_gst_value;

                        ?>
                          <tr>
                            <td><?php echo $s->tmp_nojurnal; ?></td>
                            <td style="text-align:"><?php echo $tgl_jurnal; ?> </td>
                            <td><textarea rows="1" cols="80" class="txt"><?php echo $s->tmp_sup_cust; ?></textarea></td>
                            <td><textarea rows="1" cols="80" class="txt"> <?php echo $s->tmp_check_bank; ?></textarea></td>
                            <td><textarea rows="1" cols="80" class="txt"><?php echo $s->tmp_uraian; ?></textarea></td>
                            <td><textarea rows="1" cols="80" class="txt"><?php echo $s->tmp_containerNo; ?></textarea></td>
                            <td style="text-align: right"><?php echo str_replace("-", "", number_format($s->tmp_debet, 2, ",", ".")); ?></td>
                            <td style="text-align: right"><?php echo str_replace("-", "", number_format($s->tmp_kredit, 2, ",", ".")); ?></td>
                            <td style="text-align: right"><?php echo str_replace("$", "", number_format($s->tmp_balance, 2, ",", ".")); ?></td>
                            <td style="text-align: right"><?php echo str_replace("-", "", number_format($s->tmp_debet_sgd, 2, ",", ".")); ?></td>
                            <td style="text-align: right"><?php echo str_replace("-", "", number_format($s->tmp_kredit_sgd, 2, ",", ".")); ?></td>
                            <td style="text-align: right"><?php echo str_replace("$", "", number_format($s->tmp_balance_sgd, 2, ",", ".")); ?></td>

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
                        <td style="text-align: right"><?php echo str_replace("$", "", number_format($tBalance, 2, ",", ".")); ?></td>
                        <td style="text-align: right"><?php echo str_replace("-", "", number_format($tDebetSGD, 2, ",", ".")); ?></td>
                        <td style="text-align: right"><?php echo str_replace("-", "", number_format($tKreditSGD, 2, ",", ".")); ?></td>
                        <td style="text-align: right"><?php echo str_replace("$", "", number_format($tBalanceSGD, 2, ",", ".")); ?></td>
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
</script>