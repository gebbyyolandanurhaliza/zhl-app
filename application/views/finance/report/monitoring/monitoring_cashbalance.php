<?php
$period = $this->session->userdata('periode_1');
$tgl1 = $period . "/01";
// echo $tgl;
$tgl2 = date_create($tgl1);
$tgl = date_format($tgl2, 'd-m-Y');
$dari = $this->input->get('dari');
$sampai = $this->input->get('sampai');
$coa = $this->input->get('coa');
$cur = $this->input->get('cur');
?>
<div class="page-head">
  <div class="container-fluid">
    <!-- BEGIN PAGE TITLE -->
    <div class="page-title">
      <h1>Finance Report <small>Cash Balance</small></h1>
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
              <span class="caption-subject theme-font">Monitoring Cash Balance</span>
            </div>
            <div class="tools">
              <a href="javascript:;" class="collapse"></a>
              <a href="javascript:;" class="reload"></a>
            </div>
          </div>

          <div class="portlet-body">
            <form action="<?php echo base_url(); ?>Monitoring_finace/search_cb" method="get">
              <div class="portlet-body">
                <div class="form-body">
                  <div class="row">
                    <div class="form-group col-md-6">
                      <label class="control-label col-md-3">Period</label>
                      <div class="col-md-9">
                        <div class="input-group date-picker input-daterange" data-date="02-12-2012" data-date-format="dd-mm-yyyy">
                          <input type="text" class="form-control input-sm" id="from" name="dari" value="<?php echo $tgl; ?>" required>
                          <span class="input-group-addon">
                            to </span>
                          <input type="text" class="form-control input-sm" id="to" name="sampai" value="<?php echo date('t-m-Y', strtotime($tgl)); ?>" required>
                        </div>
                      </div>
                    </div>

                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <button type="submit" class="btn purple kiri"><i class="fa fa-refresh"></i> Filter</button>
                      <a href="<?php echo base_url(); ?>Monitoring_finace/toExcelCashBalance?dari=<?php echo $dari; ?>&sampai=<?php echo $sampai; ?>" class="btn green"><i class="fa fa-file-excel-o"></i> Excel</a>
                      <a href="<?php echo base_url(); ?>Monitoring_finace/toPrintCashBalance?dari=<?php echo $dari; ?>&sampai=<?php echo $sampai; ?>" class="btn btn-primary"><i class="fa fa-print"></i> Print</a>
                    </div>
                  </div>

                  <hr>

                  <?php
                  if (!empty($_tampil)) {
                  ?>
                    <table class="table" border="1px;">
                      <thead>
                        <th>Name</th>
                        <th>Account</th>
                        <th>Amount (USD)</th>
                        <th>Pending Cash</th>
                        <th>NET</th>
                        <th>AMOUNT (OTHER CUR)</th>
                        <th>PENDING CAHS</th>
                        <th>NET (OTHER CUR)</th>
                        <th>TOTAL USD EQUIVALENT</th>
                        <th>AVERAGE RATE</th>
                      </thead>
                      <tbody>
                        <?php
                        $totalusd = 0;
                        $totalusdnet = 0;
                        $totalcur = 0;
                        $totalcurnet = 0;
                        $totalsel = 0;
                        foreach ($_tampil as $r) {
                          $totalusd += $r->jumlah_usd;
                          $totalusdnet += $r->jumlah_usd;
                          $totalcur += $r->jumlah_notusd;
                          $totalcurnet += $r->jumlah_notusd;
                          $total = 0;
                          $total = $r->jumlah_usd + $r->jumlah_notusd;
                          $totalsel += $total;
                        ?>
                          <tr>
                            <td><?php echo $r->AccountName; ?></td>
                            <td><?php echo $r->no_coa; ?></td>
                            <td align='right'><?php echo number_format($r->jumlah_usd, 2, '.', ','); ?></td>
                            <td><?php ?></td>
                            <td align='right'><?php echo number_format($r->jumlah_usd, 2, '.', ','); ?></td>
                            <td align='right'><?php echo number_format($r->jumlah_notusd, 2, '.', ','); ?></td>
                            <td><?php ?></td>
                            <td align='right'> <?php echo number_format($r->jumlah_notusd, 2, '.', ','); ?></td>
                            <td align='right'><?php echo number_format($total, 2, '.', ','); ?></td>
                            <td align='right'><?php echo number_format($r->average_rate, 2, '.', ','); ?></td>
                          </tr>
                        <?php
                        }

                        ?>

                        <tr>
                          <td>Grand Total</td>
                          <td></td>
                          <td align='right'><b><?php echo number_format($totalusd, 2, '.', ','); ?></b></td>
                          <td align='right'><b><?php ?></b></td>
                          <td align='right'><b><?php echo number_format($totalusdnet, 2, '.', ','); ?></b></td>
                          <td align='right'><b><?php echo number_format($totalcur, 2, '.', ','); ?></b></td>
                          <td align='right'><b><?php ?></b></td>
                          <td align='right'><b><?php echo number_format($totalcurnet, 2, '.', ','); ?></b></td>
                          <td align='right'><b><?php echo number_format($totalsel, 2, '.', ','); ?></b></td>
                          <td align='right'><b><?php ?></b></td>
                        </tr>
                      </tbody>

                    </table>
                  <?php
                  }
                  ?>


                </div>
              </div>


            </form>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>