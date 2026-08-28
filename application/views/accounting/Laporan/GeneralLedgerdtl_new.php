<?php
if ($this->input->get("dari") <> '') {
  $dari = $this->input->get("dari");
  $sampai = $this->input->get("sampai");
  // $cur = $this->input->get("currency");
  $coa = $this->input->get('jenis_coa');
  $coa2 = $this->input->get('jenis_coa_2');
  $coa_new = $this->input->get('new_coa');
  $coa_new2 = $this->input->get('new_coa_2');
} else {
  $period = $this->session->userdata('periode_1');
  $tgl1 = $period . "/01";
  $tgl2 = date_create($tgl1);
  $dari = date_format($tgl2, 't-m-Y');
  $sampai = date('t-m-Y', strtotime($dari));
  // $cur = "";
  $coa = "";
  $coa2 = "";
  $coa_new = "";
  $coa_new2 = "";
}

setlocale(LC_MONETARY, 'en_US.UTF-8');
?>


<div class="page-content">
  <div class="container">

    <div class="row">
      <div class="col-md-12">
        <div class="portlet light">
          <div class="portlet-title">
            <div class="caption">
              <i class="fa fa-credit-card theme-font"></i>
              <span class="caption-subject theme-font">Monitoring General Ledger (Detail) All STILL MAINTENANCE</span>
            </div>
            <div class="tools">
              <a href="javascript:;" class="collapse"></a>
              <a href="javascript:;" class="reload"></a>
            </div>
          </div>

          <div class="portlet-body" hidden>
            <form action="<?php echo base_url(); ?>General_ledger_dtl/search_new" method="get">
              <div class="portlet-body">
                <div class="form-body">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="row">
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
                       

                        <div class="col-md-8" id="coa_section">
                          <div class="row">
                            <label class="control-label col-md-2">Account 1</label>
                            <div class="col-md-5">
                              <?php
                              $style_coa = 'class="select2me form-control" id="coa"';
                              echo form_dropdown('jenis_coa', $jenis_coa, $coa, $style_coa);
                              ?>
                            </div>

                            <div class="col-md-5">
                              <?php
                              $style_coa = 'class="select2me form-control" id="coa2" ';
                              echo form_dropdown('jenis_coa_2', $jenis_coa, $coa2, $style_coa);
                              ?>
                            </div>
                          </div>
                        </div>

                        <div class="col-md-8" id="new_coa_section" style="display: none;">
                          <div class="row">
                            <label class="control-label col-md-2">New Account 1</label>
                            <div class="col-md-5">
                              <?php
                              $style_coa = 'class="select2me form-control" id="coa_new" ';
                              echo form_dropdown('new_coa', $new_coa, $coa_new, $style_coa);
                              ?>
                            </div>

                            <div class="col-md-5">
                              <?php
                              $style_coa = 'class="select2me form-control" id="coa_new2" ';
                              echo form_dropdown('new_coa_2', $new_coa, $coa_new2, $style_coa);
                              ?>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-1">
                            <label>
                                <input type="checkbox" id="toggle_coa" name="check_coa"> New Account
                            </label>
                        </div>
                        
                        <div class="col-md-4">
                          <button type="submit" class="btn purple kiri col-md-3"><i class="fa fa-refresh"></i> Filter</button>
                          <a href="<?php echo base_url(); ?>Excel/ExcelGlDetail?dari=<?php echo $dari; ?>&sampai=<?php echo $sampai; ?>&jenis_coa=<?php echo $coa; ?>&jenis_coa_2=<?php echo $coa2; ?>" class="btn green col-md-3" id="excel_link"><i class="fa fa-file-excel-o "></i> Excel</a>
                          <a href="<?php echo base_url(); ?>General_ledger_dtl/print_reportpdf?dari=<?php echo $dari; ?>&sampai=<?php echo $sampai; ?>&jenis_coa=<?php echo $coa; ?>&jenis_coa_2=<?php echo $coa2;  ?>" class="btn btn-primary" id="pdf_link"><i class="fa fa-print"></i> Print</a>
                          <!-- <button type="button" class="btn btn-primary"><i class="fa fa-print"></i> Print</button> -->
                        </div>
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
                        <th width="5%">No COA</th>
                        <th width="20%">Invoice Number</th>
                        <th width="10%">Date of Journal</th>
                        <th width="10%">Check Number</th>
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
                              <?php
                              if ($s->tmp_nojurnal != '') {
                              ?>
                                <td><?php echo $s->tmp_no_coa; ?> - <?php echo $s->tmp_namaakun; ?></td>
                                <td><?php echo $s->tmp_nojurnal; ?></td>

                              <?php
                              } else {
                              ?>
                                <td colspan="2"><?php echo $s->tmp_no_coa; ?> - <?php echo $s->tmp_namaakun; ?></td>
                                <!-- <td><?php echo $s->tmp_nojurnal; ?></td> -->
                              <?php
                              }
                              ?>

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
    var baseUrl = "<?php echo base_url(); ?>Excel/ExcelGlDetail";
    var pdfUrl = "<?php echo base_url(); ?>General_ledger_dtl/print_reportpdf";
    var dari = "<?php echo $dari; ?>";
    var sampai = "<?php echo $sampai; ?>";
    var new_coa = "<?php echo $coa_new; ?>";
    var new_coa_2 = "<?php echo $coa_new2; ?>";
    var jenis_coa = "<?php echo $coa; ?>"; 
    var jenis_coa_2 = "<?php echo $coa2; ?>"; 

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
          console.log("holaaaaaaaaaa");
            $("#coa_section").hide();
            $("#new_coa_section").show();
            $(this).val("1");
            localStorage.setItem("use_new_coa", "true");
            $("#excel_link").attr("href", baseUrl + "?dari=" + dari + "&sampai=" + sampai + "&new_coa=" + new_coa + "&new_coa_2=" + new_coa_2 + "&check_coa=" + 1);
            $("#pdf_link").attr("href", pdfUrl + "?dari=" + dari + "&sampai=" + sampai + "&new_coa=" + new_coa + "&new_coa_2=" + new_coa_2 + "&check_coa=" + 1);
        } else {
          console.log("haloooooooooooo");
            $("#coa_section").show();
            $("#new_coa_section").hide();
            $(this).val("0");
            localStorage.setItem("use_new_coa", "false");
            $("#excel_link").attr("href", baseUrl + "?dari=" + dari + "&sampai=" + sampai + "&jenis_coa=" + jenis_coa + "&jenis_coa_2=" + jenis_coa_2 + "&check_coa=" + 0);
            $("#pdf_link").attr("href", pdfUrl + "?dari=" + dari + "&sampai=" + sampai + "&jenis_coa=" + jenis_coa + "&jenis_coa_2=" + jenis_coa_2 + "&check_coa=" + 0);
        }
    });

    $("#toggle_coa").trigger("change");
  });
</script>