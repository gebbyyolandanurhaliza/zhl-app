<?php
//error_reporting(0);


if ($this->input->get("dari") <> '') {
  $dari = $this->input->get("dari");
  $sampai = $this->input->get("sampai");
} else {
  $dari = date("d-m-Y");
  $sampai = date("d-m-Y");
}

setlocale(LC_MONETARY, 'en_US.UTF-8');
?>
<!-- BEGIN PAGE HEAD -->
<div class="page-head">
  <div class="container-fluid">
    <!-- BEGIN PAGE TITLE -->
    <div class="page-title">
      <h1>Reporting <small>Balance Sheet</small></h1>
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
              <span class="caption-subject theme-font">Monitoring Balance Sheet</span>
            </div>
            <div class="tools">
              <a href="javascript:;" class="collapse"></a>
              <a href="javascript:;" class="reload"></a>
            </div>
          </div>
          <div class="portlet-body">
            <form action="<?php echo base_url(); ?>Balance_sheet/search" method="get">
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
                  <!--/span-->

                  <div class="col-md-4">
                    <div class="form-group">
                      <div class="col-md-12">
                        <button type="submit" class="btn purple kiri col-md-3"><i class="fa fa-refresh"></i> Refresh</button>
                        <a href="<?php echo base_url(); ?>Excel/toBalanceSheet1?dari=<?php echo $dari; ?>&sampai=<?php echo $sampai; ?>" class="btn green col-md-3"><i class="fa <!-- fa-file-excel-o"></i> Excel</a>
                        <a href="<?php echo base_url(); ?>Balance_sheet/print_report?dari=<?php echo $dari; ?>&sampai=<?php echo $sampai; ?>" class="btn btn-primary"><i class="fa fa-print"></i> Print</a>
                        <!-- <a href="<?php echo base_url(); ?>Balance_sheet/print_report?dari=<?php echo $dari; ?>&sampai=<?php echo $sampai; ?>" class="btn btn-primary"><i class="fa fa-print"></i> Print</a>  -->
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </form>
          </div>
          <?php
          if (!empty($_balance)) {
          ?>
            <hr>
            <table cellpadding="0" cellspacing="0" width="100%" class="table table-bordered table-striped table-condensed flip-content" id="tabel">
              <thead>
                <tr>
                  <th>
                    Group Name
                  </th>
                  <th>
                    Ammount
                  </th>
                </tr>
              </thead>
              <tbody>
                <?php
                  // ============================================================
                  if ($companyid == 1) {
                    if ($year >= 2025) {
                      $headerIds = [1, 25, 49, 61];
                      $boldIds = [24, 48, 60];
                    }else{
                      $headerIds = [1, 35];
                      $boldIds = [34, 46];
                    }
                      
                  } else {
                    $headerIds = [1, 13, 24, 32, 47];
                    $boldIds = [12, 23];
                  }

                  foreach ($_balance as $r) {
                    if ($companyid == 1 && $year >= 2025) {
                      $r->t_coaid = $r->t_number; 
                    }
                    if (in_array($r->t_coaid, $headerIds)) {
                      echo "<tr style='Background:aquamarine;font-weight:bold'>";
                      echo "<td>$r->t_coaname</td>";
                      echo "<td style='text-align:right'></td>";
                    } elseif (in_array($r->t_coaid, $boldIds)) {
                      echo "<tr style='Background:silver;font-weight:bold'>";
                      echo "<td>$r->t_coaname</td>";
                      echo "<td style='text-align:right'>" . number_format($r->t_balance, 2) . "</td>";
                    } else {
                      echo "<tr>";
                      echo "<td>$r->t_coaname</td>";
                      echo "<td style='text-align:right'>" . number_format($r->t_balance, 2) . "</td>";
                    }
                    echo "</tr>";
                  }
                  // ============================================================
                ?>
              </tbody>
            </table>
          <?php
          }
          ?>
        </div>
      </div>
    </div>