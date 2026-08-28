<?php
$this->load->model(array('M_Profit_and_lost'));

error_reporting(0);
$period = $this->input->get('tahun');
$type = $this->input->get('currency');


if ($this->input->get('dari') <> '') {
  $period = $this->input->get('tahun');
  $type = $this->input->get('currency');
  $dari = $this->input->get('dari');
  $sampai = $this->input->get('sampai');
  $txtSampai = "A/C for the period ended " . $period;
} else {
  $datestr = date("d-m-Y");
  $period = date("Y");
  $type = 'USD';
  $txtSampai = '';
  $dari = date("01-m-Y");
  $sampai = date("d-m-Y");
}

setlocale(LC_MONETARY, 'en_US.UTF-8');
?>
<script>
  function validate(form) {
    var from = document.getElementById("from");
    var to = document.getElementById("to");
    var ageDifMs = to.getTime() - from.getTime();
    var ageDate = new Date(ageDifMs); // miliseconds from epoch
    return Math.abs(ageDate.getUTCFullYear() - 1970);

    if (ageDifMs > 1) {
      alert('Range date cannot 1 year !');
      return false;
    }
  }
</script>

<!-- BEGIN PAGE HEAD -->
<div class="page-head">
  <div class="container-fluid">
    <!-- BEGIN PAGE TITLE -->
    <div class="page-title">
      <h1>Reporting <small>Profit and Loss</small></h1>
    </div>
    <!-- END PAGE TITLE -->
  </div>
</div>
<!-- END PAGE HEAD -->
<div class="page-content">
  <div class="container">
    <!-- BEGIN PAGE CONTENT INNER -->
    <div class="row">
      <div class="col-md-12">
        <div class="portlet light">
          <div class="portlet-title">
            <div class="caption">
              <i class="fa fa-credit-card theme-font"></i>
              <span class="caption-subject theme-font">Trading, Profit and Loss</span>
            </div>
            <div class="tools">
              <a href="javascript:;" class="collapse"></a>
              <a href="javascript:;" class="reload"></a>
            </div>
          </div>
          <div class="portlet-body">
            <form action="<?php echo base_url(); ?>Profit_and_loss/search_period_new" method="get">
              <div class="form-body">
                <div class="row">
                  <!--/span-->

                  <div class="col-md-6">
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
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label col-md-4">Currency Convert</label>
                      <div class="col-md-8">
                        <select name="currency" class="form-control" onchange="cek_rate()">
                          <option value="USD">USD</option>
                          <option value="SGD">SGD</option>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <div class="col-md-2">
                        <div class="row">
                          <div class="control-label col-md-9">
                            <button type="submit" class="btn purple kiri"><i class="fa fa-refresh"></i> Refresh</button>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-2">
                        <div class="row">
                          <div class="control-label col-md-9">
                            <!-- <button type="button" class="btn green"><i class="fa fa-file-excel-o"></i> Excel</button> -->
                            <a href="<?php echo base_url(); ?>Excel/toExcelProfit_Loss_Statement?dari=<?php echo $dari; ?>&sampai=<?php echo $sampai; ?>&type=<?php echo $type; ?>" class="btn green"><i class="fa fa-file-excel-o"></i> Excel</a>

                          </div>
                        </div>
                      </div>
                      <div class="col-md-2">
                        <div class="row">
                          <div class="control-label col-md-9">
                            <a href="<?php echo base_url(); ?>Profit_and_loss/print_profit_loss_statement?dari=<?php echo $this->input->get('dari'); ?>&sampai=<?php echo $this->input->get('sampai'); ?>&type=<?php echo $type; ?>" class="btn btn-primary"><i class="fa fa-print"></i> Print</a>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!--/span-->
                </div>
              </div>
            </form>
          </div>
          <hr />
          <?php
          if (!empty($get_invoice)) {
            $hasilakhir = 0;
            $hasil = 0;
            $hasil2 = 0;
            $tt_totald = 0;
            $tt_totalk = 0;
            $hasilakhir_2 = 0;
            $hasil_2  = 0;
            $hasil2_2 = 0;
            $tt_totald_2  = 0;
            $tt_totalk_2  = 0;
            $hasilakhir_3 = 0;
            $hasil_3  = 0;
            $hasil2_3 = 0;
            $tt_totald_3  = 0;
            $tt_totalk_3  = 0;
            $hasilakhir_4 = 0;
            $hasil_4  = 0;
            $hasil2_4 = 0;
            $tt_totald_4  = 0;
            $tt_totalk_4  = 0;
            $hasil_5 = 0;
          ?>
            <hr />

            <table cellpadding="0" cellspacing="0" width="100%" class="table table-bordered  table-hover table-striped table-condensed flip-content" id="tabel">
              <thead>
                <tr>
                  <td rowspan="2">

                  </td>

                  <td style="text-align: center">

                  </td>

                </tr>
                <tr>
                  <?php
                  if ($this->input->get('currency') == 'USD') {
                    $type = 'US$';
                  } else {
                    $type = 'SGD$';
                  }
                  ?>
                  <td style="text-align: center"><?php echo "$type"; ?></td>
                </tr>
              </thead>
              <tbody>
                <?php
                $TDR = 0;
                $TCR = 0;

                //}
                foreach ($get_invoice as $v) {
                  //$t_total =  $v->MTDebet - $v->MTKredit;                                  
                  if ($v->id_group == '215' || $v->id_group == '217') {
                    $hasil = $v->MTKredit - $v->MTDebet;
                    $hasilakhir += $hasil;
                    if ($hasil < 0) {
                      $hasil2 = str_replace("$", "", money_format('%(#10n', $hasil));
                      // $b = str_replace("-", "", $hasil);
                      // $hasil2 = "" . number_format($b, 2, '.', ',') . "";
                    } elseif ($hasil == 0) {
                      $hasil2 = '-';
                      $hasil2 = number_format($hasil, 2, '.', ',');
                    } else {
                      $hasil2 = number_format($hasil, 2, '.', ',');
                    }

                ?>
                    <tr>
                      <td><?php echo strtoupper($v->nama_group); ?></td>
                      <td style="text-align:right;"><?php echo $hasil2; ?></td>
                    </tr>
                <?php
                  }
                }
                ?>
                <tr>
                  <td style="text-align:left;"><b><?php echo "GROSS PROFIT"; ?></b></td>
                  <td style="text-align:right;"><b><?php echo number_format(abs($hasilakhir), 2, '.', ','); ?></b></td>
                </tr>

                <?php

                foreach ($get_invoice as $g) {
                  if ($g->id_group == '216') {
                    $tt_totald_3 += $g->MTDebet;
                    $tt_totalk_3 += $g->MTKredit;
                    $hasil_3 = $g->MTKredit - $g->MTDebet;

                    $hasilakhir3 = $hasilakhir + $hasil_3;
                    //$hasilakhir3 = $hasilakhir1-$hasilakhir2;
                    if ($hasil_3 < 0) {
                      $hasil2_3 = str_replace("$", "", money_format('%(#10n', $hasil_3));

                      // $b = str_replace("-", "", $hasil);
                      // $hasil2 = "" . number_format($b, 2, '.', ',') . "";
                    } elseif ($hasil_3 == 0) {
                      $hasil2_3 = 0;
                    } else {
                      $hasil2_3 = number_format($hasil_3, 2, '.', ',');
                    }
                ?>
                    <tr>
                      <td><?php echo strtoupper($g->nama_group); ?></td>
                      <td style="text-align:right;"><?php echo $hasil2_3; ?></td>
                    </tr>
                    <tr>
                      <td style="text-align:center;"><?php echo ""; ?></td>
                      <td style="text-align:right;"><b><?php echo number_format($hasilakhir3, 2, '.', ','); ?></b></td>
                    </tr>
                  <?php

                  }
                }
                foreach ($get_invoice as $g) {
                  if ($g->id_group == '218' || $g->id_group == '219') {
                    $tt_totald_4 += $g->MTDebet;
                    $tt_totalk_4 += $g->MTKredit;
                    $hasil_4 = $g->MTKredit - $g->MTDebet;
                    $hasil_5 += $hasil_4;

                    //$hasilakhir3 = $hasilakhir1-$hasilakhir2;
                    if ($hasil_4 < 0) {
                      $hasil2_4 = str_replace("$", "", money_format('%(#10n', $hasil_4));

                      // $b = str_replace("-", "", $hasil);
                      // $hasil2 = "" . number_format($b, 2, '.', ',') . "";
                    } elseif ($hasil_4 == 0) {
                      $hasil2_4 = 0;
                    } else {
                      $hasil2_4 = number_format($hasil_4, 2, '.', ',');
                    }
                  ?>
                    <tr>
                      <td><?php echo strtoupper($g->nama_group); ?></td>
                      <td style="text-align:right;"><?php echo $hasil2_4; ?></td>
                    </tr>
                <?php
                  }
                }
                $hasilakhir4 = $hasilakhir3 + $hasil_5;
                ?><tr>
                  <td style="text-align:left;"><b><?php echo "PROFIT /( LOSS ) BEFORE TAXITON"; ?></b></td>
                  <td style="text-align:right;"><b><?php echo number_format($hasilakhir4, 2, '.', ','); ?></b></td>
                </tr>
              </tbody>
            </table>
          <?php
          }
          ?>

        </div>
      </div>
    </div>
  </div>
</div>