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
if (empty($cur)) {
  $cur = 'USD';
}
?>
<div class="page-head">
  <div class="container-fluid">
    <!-- BEGIN PAGE TITLE -->
    <div class="page-title">
      <h1>Finance Report <small>Down Payment</small></h1>
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
              <span class="caption-subject theme-font">Down Payment</span>
            </div>
            <div class="tools">
              <a href="javascript:;" class="collapse"></a>
              <a href="javascript:;" class="reload"></a>
            </div>
          </div>

          <div class="portlet-body">
            <form action="<?php echo base_url(); ?>Monitoring_finace/downpayment_search" method="get">
              <div class="portlet-body">
                <div class="form-body">
                  <div class="row">
                    <div class="form-group col-md-4">
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
                    <div class="col-md-8">
                      <button type="submit" class="btn purple kiri"><i class="fa fa-refresh"></i> Filter</button>
                      <a href="<?php echo base_url(); ?>Monitoring_finace/toExcelDownPayment?dari=<?php echo $dari; ?>&sampai=<?php echo $sampai; ?>" class="btn green"><i class="fa fa-file-excel-o"></i> Excel</a>
                      <a href="<?php echo base_url(); ?>Monitoring_finace/toPrintDownPayment?dari=<?php echo $dari; ?>&sampai=<?php echo $sampai; ?>" class="btn btn-primary"><i class="fa fa-print"></i> Print</a>

                    </div>
                  </div>

                  <hr>
                  <?php
                  if (!empty($_hasil)) {
                    $no = 1;
                  ?>
                    <table class="table" border="1px">
                      <tr>
                        <thead>
                          <th>No</th>
                          <th>ID</th>
                          <th>Supplier / Customer</th>
                          <th>Reff. No</th>
                          <th>Date</th>
                          <th>Amount</th>
                          <th>Cur</th>
                          <th>Rate</th>
                          <th>Usd Equivalent</th>
                        </thead>
                      </tr>
                      <?php
                      foreach ($_hasil as $r) {
                      ?>

                        <tbody>
                          <td><?php echo $no++; ?></td>
                          <td><?php echo $r->supp_code; ?></td>
                          <td><?php echo $r->cust_supp_name; ?></td>
                          <td><?php echo $r->no_reff; ?></td>
                          <td><?php echo $r->date; ?></td>
                          <td><?php echo number_format($r->uang_muka, 2, '.', ','); ?></td>
                          <td><?php echo $r->currency_id; ?></td>
                          <td><?php echo number_format($r->currency_rate, 2, '.', ','); ?></td>
                          <td><?php echo number_format($r->uang_muka * $r->currency_rate, 2, '.', ','); ?></td>
                        </tbody>
                      <?php   } ?>
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