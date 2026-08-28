<?php
if ($this->input->get("dari") <> '') {
  $dari = $this->input->get("dari");
  $sampai = $this->input->get("sampai");
  // $cur = $this->input->get("currency");
  $coa = $this->input->get('jenis_coa');
  $end_coa = $this->input->get('jenis_coa2');
} else {
  $period = $this->session->userdata('periode_1');
  $tgl1 = $period . "/01";
  $tgl2 = date_create($tgl1);
  $dari = date_format($tgl2, 't-m-Y');
  $sampai = date('t-m-Y', strtotime($dari));
  // $cur = "";
  $coa = "";
  $end_coa = "";
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
              <span class="caption-subject theme-font">Monitoring General Ledger (Detail) All </span>
            </div>
            <div class="tools">
              <a href="javascript:;" class="collapse"></a>
              <a href="javascript:;" class="reload"></a>
            </div>
          </div>

          <div class="portlet-body">
            <form action="<?php echo base_url(); ?>General_ledger_detail/search" method="get">
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

                      <div class="col-md-3">
                        <label class="control-label col-md-3">From Account</label>
                        <div class="col-md-9">
                          <?php
                          $style_coa = 'class="select2me form-control start-coa" id="coa" ';
                          echo form_dropdown('jenis_coa', $jenis_coa, $coa, $style_coa);
                          ?>
                        </div>
                      </div>
                      <div class="col-md-3">
                        <label class="control-label col-md-3">To Account</label>
                        <div class="col-md-9">
                          <?php
                          $style_coa = 'class=" form-control end-coa" id="coa" ';
                          echo form_dropdown('jenis_coa2', $jenis_coa, $coa, $style_coa);
                          ?>
                        </div>
                      </div>
                      <div class="col-md-2">
                        <button type="submit" class="btn purple kiri col-md-3"><i class="fa fa-refresh"></i> Filter</button>
                        <a href="<?php echo base_url(); ?>Excel/toExcelGlDetailALL?dari=<?php echo $dari; ?>&sampai=<?php echo $sampai; ?>&jenis_coa=<?php echo $coa; ?>&jenis_coa2=<?php echo $end_coa; ?>" class="btn green col-md-3"><i class="fa fa-file-excel-o "></i> Excel</a>
                        <a href="<?php echo base_url(); ?>General_ledger_dtl/print_report?dari=<?php echo $dari; ?>&sampai=<?php echo $sampai; ?>&jenis_coa=<?php echo $coa; ?>&jenis_coa2=<?php echo $end_coa; ?>" class="btn btn-primary"><i class="fa fa-print"></i> Print</a>
                        <!-- <button type="button" class="btn btn-primary"><i class="fa fa-print"></i> Print</button> -->
                      </div>
                    </div>
                  </div>
                  <hr>
                  <div class="table-responsive" style="height: 700px; position: sticky;">
                    <?php
                    $bD = 0;
                    if (!empty($detail_trans)) {
                      $begining = str_replace(",", "", $this->input->get("beginning"));

                    ?>

                      <table class="table table-bordered " id="tabelin">
                        <thead>
                          <tr style="position: sticky; top: 0px; background: white;">
                            <th width="5%">No COA</th>
                            <th width="20%">Invoice Number</th>
                            <th width="20%">Supplier Name</th>
                            <th width="10%">Date of Journal</th>
                            <th width="10%">Check Number</th>
                            <th width="20%">Description</th>
                            <th width="10%">Debit(LC) </th>
                            <th width="10%">Credit(LC) </th>
                            <th width="10%">Balance(LC) </th>
                            <th width="10%">Debit(FC) </th>
                            <th width="10%">Credit(FC) </th>
                            <th width="10%">Balance(FC)</th>
                          </tr>
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
                            $tDebet += $s->tmp_debet;
                            $tKredit += $s->tmp_kredit;
                            $tBalance += $s->tmp_balance;
                            $tDebetSGD += $s->tmp_debet_sgd;
                            $tKreditSGD += $s->tmp_kredit_sgd;
                            $tBalanceSGD += $s->tmp_balance_sgd;
                            if ($s->tmp_tanggal == NULL) {
                              $tgl_jurnal = '';
                            } else {
                              $tgl_jurnal = date_format(date_create($s->tmp_tanggal), "d F Y");
                            }
                            $saldo += $s->tmp_debet - $s->tmp_kredit;
                            if ($s->tmp_uraian == 'BEGINING BALANCE') {
                          ?>
                              <tr style="background-color:#ddd;">
                                <td><?php echo $s->tmp_no_coa . ' ' . $s->tmp_namaakun; ?></td>
                                <td></td>
                                <td><?php echo $s->tmp_nojurnal; ?></td>
                                <td style="text-align:"><?php echo $tgl_jurnal; ?> </td>
                                <td></td>
                                <td><?php echo $s->tmp_uraian; ?></td>
                                <td style="text-align: right"><?php echo str_replace("-", "", number_format($s->tmp_debet, 2, ",", ".")); ?></td>
                                <td style="text-align: right"><?php echo str_replace("-", "", number_format($s->tmp_kredit, 2, ",", ".")); ?></td>
                                <td style="text-align: right"><?php echo str_replace("$", "", money_format('%(#10n', $s->tmp_balance)); ?></td>
                                <td style="text-align: right"><?php echo str_replace("-", "", number_format($s->tmp_debet_sgd, 2, ",", ".")); ?></td>
                                <td style="text-align: right"><?php echo str_replace("-", "", number_format($s->tmp_kredit_sgd, 2, ",", ".")); ?></td>
                                <td style="text-align: right"><?php echo str_replace("$", "", money_format('%(#10n', $s->tmp_balance_sgd)); ?></td>
                              </tr>
                            <?php
                            } else if ($s->tmp_uraian == 'TOTAL') {
                            ?>
                              <tr style="background-color:#ffffcc;">
                                <td></td>
                                <td><?php echo $s->tmp_nojurnal; ?></td>
                                <td></td>
                                <td style="text-align:"><?php echo $tgl_jurnal; ?> </td>
                                <td></td>
                                <td><?php echo $s->tmp_uraian; ?></td>
                                <td style="text-align: right"><?php echo str_replace("-", "", number_format($s->tmp_debet, 2, ",", ".")); ?></td>
                                <td style="text-align: right"><?php echo str_replace("-", "", number_format($s->tmp_kredit, 2, ",", ".")); ?></td>
                                <td style="text-align: right"><?php echo str_replace("$", "", money_format('%(#10n', $s->tmp_balance)); ?></td>
                                <td style="text-align: right"><?php echo str_replace("-", "", number_format($s->tmp_debet_sgd, 2, ",", ".")); ?></td>
                                <td style="text-align: right"><?php echo str_replace("-", "", number_format($s->tmp_kredit_sgd, 2, ",", ".")); ?></td>
                                <td style="text-align: right"><?php echo str_replace("$", "", money_format('%(#10n', $s->tmp_balance_sgd)); ?></td>
                              </tr>
                            <?php

                            } else if ($s->tmp_uraian != 'TOTAL' || $s->tmp_uraian != 'BEGINING BALANCE') {
                            ?>
                              <tr>
                                <td></td>
                                <td><?php echo $s->tmp_nojurnal; ?></td>
                                <td><?php echo $s->tmp_supplier; ?></td>
                                <td style="text-align:"><?php echo $tgl_jurnal; ?> </td>
                                <td><textarea rows="1" cols="80" class="txt"><?php echo $s->tmp_check_bank; ?></textarea></td>
                                <td><textarea rows="1" cols="80" class="txt"><?php echo $s->tmp_uraian; ?></textarea>
                                </td>
                                <td style="text-align: right"><?php echo str_replace("-", "", number_format($s->tmp_debet, 2, ",", ".")); ?></td>
                                <td style="text-align: right"><?php echo str_replace("-", "", number_format($s->tmp_kredit, 2, ",", ".")); ?></td>
                                <td style="text-align: right"><?php echo str_replace("$", "", money_format('%(#10n', $s->tmp_balance)); ?></td>
                                <td style="text-align: right"><?php echo str_replace("-", "", number_format($s->tmp_debet_sgd, 2, ",", ".")); ?></td>
                                <td style="text-align: right"><?php echo str_replace("-", "", number_format($s->tmp_kredit_sgd, 2, ",", ".")); ?></td>
                                <td style="text-align: right"><?php echo str_replace("$", "", money_format('%(#10n', $s->tmp_balance_sgd)); ?></td>
                              </tr>
                          <?php
                            }
                          }
                          ?>
                        </tbody>
                        <tfoot>

                        </tfoot>
                      </table>
                    <?php } ?>
                  </div>
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
    // $(".end-coa").prop("disabled", false)
    var star = '<?= $start_coa ?>';
    var end = '<?= $end_coa ?>';

    $(".star-coa [value=" + star + "]").attr('selected', 'selected');
    $(".end-coa [value=" + end + "]").attr('selected', 'selected');

    // alert(star)
    // alert(end)
    $("#tabel").dataTable({
      "scrollY": 400,
      "scrollX": true,
      "iDisplayLength": 100
    });

  });

  $(".start-coa").change(function() {
    var coa = $(".start-coa").find(":selected").val();

    // $(".end-coa").prop("disabled", false)


    $(".end-coa [value=" + coa + "]").attr('selected', 'selected');
  })
</script>