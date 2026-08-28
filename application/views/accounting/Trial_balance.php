<?php
error_reporting(0);
if ($this->input->get('dari') <> '') {
  $period = $this->input->get('tahun');
  $type = $this->input->get('currency');
  $dari = $this->input->get('dari');
  $sampai = $this->input->get('sampai');
  $txtSampai = "A/C for the period ended " . $period;
} else {
  $datestr = date("Y-m-d");
}
?>

<div class="page-content">
  <div class="container">
    <!-- BEGIN PAGE CONTENT INNER -->
    <div class="row">
      <div class="col-md-12">
        <div class="portlet light">
          <div class="portlet-title">
            <div class="caption">
              <i class="fa fa-credit-card theme-font"></i>
              <span class="caption-subject theme-font">Reporting Trial Balance </span>
            </div>
            <div class="tools">
              <a href="javascript:;" class="collapse"></a>
              <a href="javascript:;" class="reload"></a>
            </div>
          </div>
          <div class="portlet-body">
            <form action="<?php echo base_url(); ?>Trial_balance/search" method="get">
              <div class="form-body">
                <div class="row">
                  <!--                                    /span
                                                                        <div class="col-md-6">
                                                                            <div class="form-group">
                                                                                <label class="control-label col-md-3">First COA</label>
                                                                                <div class="col-md-9">
                                    <?php
                                    //                                                $style_kategori = 'class="select2me form-control" id="coa_number1" ';
                                    //                                                echo form_dropdown('coa1', $coa_number, $coa1, $style_kategori);
                                    ?>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <div class="form-group">
                                                                                <label class="control-label col-md-3">Ending COA</label>
                                                                                <div class="col-md-9">
                                    <?php
                                    //                                                $style_kategori2 = 'class="select2me form-control" id="coa_number2" ';
                                    //                                                echo form_dropdown('coa2', $coa_number, $coa2, $style_kategori2);
                                    ?>
                                                                                </div>
                                                                            </div>
                                                                        </div>-->
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label col-md-3">Period</label>
                      <div class="col-md-9">
                        <div class="input-group" data-date-format="yyyy-mm-dd">
                          <!--           <div class="input-group date-picker input-daterange" data-date-format="yyyy-mm-dd"> -->
                          <input type="date" class="form-control" id="from" name="dari" value="<?php echo $dari; ?>" required>
                          <span class="input-group-addon">
                            to </span>
                          <input type="date" class="form-control" id="to" name="sampai" value="<?php echo $sampai; ?>" required>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label col-md-3">Type of Currency</label>
                      <div class="col-md-9">
                        <select name="type" class="select2me form-control">
                          <option value="USD" <?php if ($type == 'USD') {
                                                echo 'Selected';
                                              } ?>>USD</option>
                          <option value="SGD" <?php if ($type == 'SGD') {
                                                echo 'Selected';
                                              } ?>>SGD</option>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label col-md-3">Show NoCOA</label>
                      <div class="col-md-9">
                        <select name="coa" class="select2me form-control">
                          <option value="0">No</option>
                          <option value="1">Yes</option>
                        </select>
                      </div>
                    </div>
                  </div>

                  <!--/span-->
                </div>
                <hr />
                <div class="row">
                  <div class="col-md-3">
                    <div class="form-group">

                      <div class="col-md-4">
                        <div class="row">
                          <div class="control-label col-md-9">
                            <button type="submit" class="btn purple kiri"><i class="fa fa-refresh"></i> Refresh</button>
                          </div>
                        </div>
                      </div>
                      <!-- <div class="col-md-4">
                                                <div class="row">
                                                    <div class="control-label col-md-9">
                                                        <button type="button" class="btn green"><i class="fa fa-file-excel-o"></i> Excel</button>
                                                    </div>
                                                </div>
                                            </div> -->
                      <div class="col-md-4">
                        <div class="row">
                          <div class="control-label col-md-9">
                            <a href="<?php echo base_url(); ?>Excel/toExcelTrialBalance?dari=<?php echo $this->input->get('dari'); ?>&sampai=<?php echo $this->input->get('sampai'); ?>&type=<?php echo $this->input->get('type'); ?>" class="btn green"><i class="fa fa-file-excel-o"></i> Excel</a>

                          </div>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="row">
                          <div class="control-label col-md-9">
                            <a href="<?php echo base_url(); ?>Trial_balance/print_trial_balance?dari=<?php echo $this->input->get('dari'); ?>&sampai=<?php echo $this->input->get('sampai'); ?>&type=<?php echo $this->input->get('type'); ?>" class="btn btn-primary"><i class="fa fa-print"></i> Print</a>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </form>
          </div>
          <?php
          if (!empty($get_invoice)) {
          ?>
            <hr />
            <?php if ($this->input->get('coa') == 1) { ?>
              <table cellpadding="0" cellspacing="0" width="100%" class="table table-bordered  table-hover table-striped table-condensed flip-content" id="tabel">
                <thead>
                  <tr>
                    <td style="text-align: center" rowspan="2" width="400">
                      NO COA
                    </td>
                    <td rowspan="2" width="400">

                    </td>

                    <td style="text-align: center" width="250">
                      Debet
                    </td>
                    <td style="text-align: center" width="250">
                      Credit
                    </td>
                    <td style="text-align: center" width="250">
                      YTD Debet
                    </td>
                    <td style="text-align: center" width="250">
                      YTD Credit
                    </td>


                  </tr>
                  <tr>
                    <?php
                    if ($this->input->get('type') == 'USD') {
                      $type = 'US$';
                    } else {
                      $type = 'SGD$';
                    }
                    ?>
                    <td style="text-align: center"><?php echo "$type"; ?></td>
                    <td style="text-align: center"><?php echo "$type"; ?></td>
                    <td style="text-align: center"><?php echo "$type"; ?></td>
                    <td style="text-align: center"><?php echo "$type"; ?></td>


                  </tr>
                </thead>
                <tbody>

                  <?php
                  $TDR = 0;
                  $TCR = 0;
                  $tt_totald = 0;
                  $tt_totalk = 0;
                  foreach ($get_invoice as $v) {
                    $t_total =  $v->MTDebet - $v->MTKredit;
                    $DR = $v->MTDebet;
                    $CR = $v->MTKredit;
                    //$SDR = $v->sad;
                    //$SCR = $v->sak;

                    $TDR += $v->EBDebet;
                    $TCR += $v->EBKredit;
                    $tt_totalsd += $v->EBDebet;
                    $tt_totalsk += $v->EBKredit;


                    if ($DR < 0) {
                      $b = str_replace("-", "", $DR);
                      $DR = "" . number_format($b, 2, '.', ',') . "";
                    } elseif ($DR == 0) {
                      $DR = '-';
                    } else {
                      $DR = number_format($DR, 2, '.', ',');
                    }

                    if ($CR < 0) {
                      $b = str_replace("-", "", $CR);
                      $CR = "" . number_format($b, 2, '.', ',') . "";
                    } elseif ($CR == 0) {
                      $CR = '-';
                    } else {
                      $CR = number_format($CR, 2, '.', ',');
                    }

                    $t_totald = 0;
                    $t_totalk = 0;

                    if ($t_total > 0) {
                      $t_totald = $t_total;
                      $t_totalk = 0;
                    } elseif ($t_total < 0) {
                      $t_totald = 0;
                      $t_totalk = $t_total;
                    } else {
                      $t_totald = 0;
                      $t_totalk = 0;
                    }
                    $tt_totald += $t_totald;
                    $tt_totalk += $t_totalk;


                  ?>
                    <tr>
                      <td><?php echo $v->no_coa; ?></td>
                      <td><?php echo strtoupper($v->nama_akun); ?></td>
                      <td style="text-align:right;"><?php echo  number_format(abs($t_totald), 2, '.', ','); ?></td>
                      <td style="text-align:right;"><?php echo  number_format(abs($t_totalk), 2, '.', ','); ?></td>
                      <td style="text-align:right;"><?php echo  number_format(abs($v->EBDebet), 2, '.', ','); ?></td>
                      <td style="text-align:right;"><?php echo  number_format(abs($v->EBKredit), 2, '.', ','); ?></td>

                    </tr>
                  <?php
                  }
                  ?>
                </tbody>
                <tfoot>
                  <tr>
                    <td style="text-align:center;"></td>
                    <td style="text-align:center;"><?php echo "TOTAL"; ?></td>
                    <td style="text-align:right;"><?php echo number_format(abs($tt_totald), 2, '.', ','); ?></td>
                    <td style="text-align:right;"><?php echo number_format(abs($tt_totalk), 2, '.', ','); ?></td>
                    <td style="text-align:right;"><?php echo number_format(abs($tt_totalsd), 2, '.', ','); ?></td>
                    <td style="text-align:right;"><?php echo number_format(abs($tt_totalsk), 2, '.', ','); ?></td>

                  </tr>
                </tfoot>
              </table>
            <?php } else { ?>
              <table cellpadding="0" cellspacing="0" width="100%" class="table table-bordered  table-hover table-striped table-condensed flip-content" id="tabel">
                <thead>
                  <tr>
                    <td rowspan="2">

                    </td>

                    <td style="text-align: center">
                      Debet
                    </td>
                    <td style="text-align: center">
                      Credit
                    </td>
                    <td style="text-align: center">
                      YTD Debet
                    </td>
                    <td style="text-align: center">
                      YTD Credit
                    </td>


                  </tr>
                  <tr>
                    <?php
                    if ($this->input->get('type') == 'USD') {
                      $type = 'US$';
                    } else {
                      $type = 'SGD$';
                    }
                    ?>
                    <td style="text-align: center"><?php echo "$type"; ?></td>
                    <td style="text-align: center"><?php echo "$type"; ?></td>
                    <td style="text-align: center"><?php echo "$type"; ?></td>
                    <td style="text-align: center"><?php echo "$type"; ?></td>



                  </tr>
                </thead>
                <tbody>

                  <?php
                  $TDR = 0;
                  $TCR = 0;
                  $tt_totald = 0;
                  $tt_totalk = 0;
                  foreach ($get_invoice as $v) {
                    //$t_total =  $v->MTDebet - $v->MTKredit;                                  
                    $DR = $v->MTDebet;
                    $CR = $v->MTKredit;
                    $SDR = $v->sad;
                    $SCR = $v->sak;

                    $TDR += $v->EBDebet;
                    $TCR += $v->EBKredit;

                    if ($DR < 0) {
                      $b = str_replace("-", "", $DR);
                      $DR = "" . number_format($b, 2, '.', ',') . "";
                    } elseif ($DR == 0) {
                      $DR = '-';
                    } else {
                      $DR = number_format($DR, 2, '.', ',');
                    }

                    if ($CR < 0) {
                      $b = str_replace("-", "", $CR);
                      $CR = "" . number_format($b, 2, '.', ',') . "";
                    } elseif ($CR == 0) {
                      $CR = '-';
                    } else {
                      $CR = number_format($CR, 2, '.', ',');
                    }

                    $t_totald = 0;
                    $t_totalk = 0;
                    $t_ydddebit = 0;
                    $t_yddkrebit = 0;


                    if ($t_total > 0) {
                      $t_totald = $v->MTDebet;
                      $t_totalk = 0;
                    } elseif ($t_total < 0) {
                      $t_totald = 0;
                      $t_totalk = $v->MTKebet;
                    } else {
                      $t_totald = 0;
                      $t_totalk = 0;
                    }
                    $tt_totald += $v->MTDebet;
                    $tt_totalk += $v->MTKredit;
                    $tt_totalsd += $v->EBDebet;
                    $tt_totalsk += $v->EBKredit;



                  ?>
                    <tr>
                      <td><?php echo strtoupper($v->nama_akun); ?></td>
                      <td style="text-align:right;"><?php echo  number_format(abs($v->MTDebet), 2, '.', ','); ?></td>
                      <td style="text-align:right;"><?php echo  number_format(abs($v->MTKredit), 2, '.', ','); ?></td>
                      <td style="text-align:right;"><?php echo  number_format(abs($v->EBDebet), 2, '.', ','); ?></td>
                      <td style="text-align:right;"><?php echo  number_format(abs($v->EBKredit), 2, '.', ','); ?></td>


                    </tr>
                  <?php
                  }
                  ?>
                </tbody>
                <tfoot>
                  <tr>
                    <td style="text-align:center;"><?php echo "TOTAL"; ?></td>
                    <td style="text-align:right;"><?php echo number_format(abs($tt_totald), 2, '.', ','); ?></td>
                    <td style="text-align:right;"><?php echo number_format(abs($tt_totalk), 2, '.', ','); ?></td>
                    <td style="text-align:right;"><?php echo number_format(abs($tt_totalsd), 2, '.', ','); ?></td>
                    <td style="text-align:right;"><?php echo number_format(abs($tt_totalsk), 2, '.', ','); ?></td>

                  </tr>
                </tfoot>
              </table>
          <?php }
          } ?>

        </div>
      </div>
    </div>