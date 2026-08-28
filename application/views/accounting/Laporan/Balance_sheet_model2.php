<?php
//error_reporting(0);
if ($this->input->get("dari") <> '') {
  $dari = $this->input->get("dari");
  $sampai = $this->input->get("sampai");
  $cur = $this->input->get("currency");
  $coa = $this->input->get('jenis_coa');
} else {
  $tgl2 = '';
  $dari = date("d-m-Y");
  $sampai = date("d-m-Y");
  $cur = "USD";
  $coa = "";
}

setlocale(LC_MONETARY, 'en_US.UTF-8');
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
              <span class="caption-subject theme-font">Monitoring Balance Sheet (Detail)</span>
            </div>
            <div class="tools">
              <a href="javascript:;" class="collapse"></a>
              <a href="javascript:;" class="reload"></a>
            </div>
          </div>
          <div class="portlet-body">
            <form action="<?php echo base_url(); ?>Balance_sheet/search_detail" method="get">
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
                        <a href="<?php echo base_url(); ?>Excel3/toExcelBalanceSheetDetail?dari=<?php echo $dari; ?>&sampai=<?php echo $sampai; ?>" class="btn green col-md-3"><i class="fa <!-- fa-file-excel-o"></i> Excel</a>
                        <a href="<?php echo base_url(); ?>Balance_sheet/print_report_detail?dari=<?php echo $dari; ?>&sampai=<?php echo $sampai; ?>" class="btn btn-primary"><i class="fa fa-print"></i> Print</a>
                        <!-- <a href="<?php echo base_url(); ?>Balance_sheet/print_report?dari=<?php echo $dari; ?>&sampai=<?php echo $sampai; ?>" class="btn btn-primary"><i class="fa fa-print"></i> Print</a>  -->
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </form>
          </div>
          <hr />
          <?php
          if (isset($_GET['dari'])) {
            if (!empty($data_balance)) {
          ?>
              <table cellpadding="0" cellspacing="0" width="100%" class="table table-bordered table-striped table-condensed flip-content" id="tabel">
                <thead>
                  <tr>
                    <th>
                      No COA
                    </th>
                    <th>
                      Nama COA
                    </th>
                    <th>
                      COST
                    </th>
                    <th>
                      Accumulated Dep
                    </th>
                    <th>
                      Net Book Value
                    </th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td colspan="5" style="background-color: #ddd">ASSET</td>
                  </tr>
                  <?php
                  $ta = 0;
                  $tb = 0;
                  $tc = 0;
                  foreach ($data_balance as $r) {
                    if ($r->id_sub_group == 1) {
                      $ta +=  $r->COSTT;
                      $tb += $r->ACCM;
                      $tc += ($r->COSTT - $r->ACCM);
                      echo "
                                            <tr>
                                                <td>$r->no_coa</td>
                                                <td>$r->AccountName</td>
                                                <td style='text-align:right'>" . str_replace("$", "", money_format('%(#10n', $r->COSTT)) . "</td>
                                                <td style='text-align:right'>" . str_replace("$", "", money_format('%(#10n', $r->ACCM)) . "</td>
                                                <td style='text-align:right'>" . str_replace("$", "", money_format('%(#10n', ($r->COSTT - $r->ACCM))) . "</td>
                                            </tr>
                                        ";
                    }
                  }
                  ?>
                  <tr>
                    <td colspan="5" style="background-color: yellow"></td>
                  </tr>
                  <tr>
                    <td colspan="5" style="background-color: #ddd">Current ASSET</td>
                  </tr>
                  <?php
                  foreach ($data_balance as $r) {
                    if ($r->id_sub_group == 2) {
                      $ta +=  $r->COSTT;
                      $tb += $r->ACCM;
                      $tc += ($r->COSTT - $r->ACCM);
                      echo "
                                            <tr>
                                                <td>$r->no_coa</td>
                                                <td>$r->AccountName</td>
                                                <td style='text-align:right'>" . str_replace("$", "", money_format('%(#10n', ($r->COSTT))) . "</td>
                                                <td style='text-align:right'>" . str_replace("$", "", money_format('%(#10n', ($r->ACCM))) . "</td>
                                                <td style='text-align:right'>" . str_replace("$", "", money_format('%(#10n', (($r->COSTT - $r->ACCM)))) . "</td>
                                            </tr>
                                        ";
                    }
                  }
                  ?>
                  <tr>
                    <td colspan="5" style="background-color: yellow"></td>
                  </tr>
                  <tr style="background-color: #abcafc">
                    <td colspan="2">Total Asset</td>
                    <td style='text-align:right'><?= str_replace("$", "", money_format('%(#10n', ($ta))); ?></td>
                    <td style='text-align:right'><?= str_replace("$", "", money_format('%(#10n', ($tb))); ?></td>
                    <td style='text-align:right;'><?= str_replace("$", "", money_format('%(#10n', ($tc))); ?></td>
                  </tr>
                  <tr>
                    <td colspan="5" style="background-color: brown"></td>
                  </tr>
                  <tr>
                    <td colspan="5" style="background-color: #ddd">CURRENT LIABILITIES</td>
                  </tr>
                  <?php
                  $ta = 0;
                  $tb = 0;
                  $tc = 0;
                  foreach ($data_balance as $r) {
                    if ($r->id_sub_group == 3) {
                      $ta +=  $r->COSTT;
                      $tb += $r->ACCM;
                      $tc += ($r->COSTT - $r->ACCM);
                      echo "
                                            <tr>
                                                <td>$r->no_coa</td>
                                                <td>$r->AccountName</td>
                                                <td style='text-align:right'>" . str_replace("$", "", money_format('%(#10n', $r->COSTT)) . "</td>
                                                <td style='text-align:right'>" . str_replace("$", "", money_format('%(#10n', $r->ACCM)) . "</td>
                                                <td style='text-align:right'>" . str_replace("$", "", money_format('%(#10n', ($r->COSTT - $r->ACCM))) . "</td>
                                            </tr>
                                        ";
                    }
                  }
                  ?>
                  <tr style="background-color: #abcafc">
                    <td colspan="2">Working Kapital</td>
                    <td style='text-align:right'><?= str_replace("$", "", money_format('%(#10n', ($ta))); ?></td>
                    <td style='text-align:right'><?= str_replace("$", "", money_format('%(#10n', ($tb))); ?></td>
                    <td style='text-align:right;'><?= str_replace("$", "", money_format('%(#10n', ($tc))); ?></td>
                  </tr>
                  <tr>
                    <td colspan="5" style="background-color: yellow"></td>
                  </tr>
                  <tr>
                    <td colspan="5" style="background-color: #ddd">EQUITY & LIABILITIES</td>
                  </tr>
                  <?php
                  foreach ($data_balance as $r) {
                    if ($r->id_sub_group == 4) {
                      $ta +=  $r->COSTT;
                      $tb += $r->ACCM;
                      $tc += ($r->COSTT - $r->ACCM);
                      echo "
                                             <tr>
                                                <td>$r->no_coa</td>
                                                <td>$r->AccountName</td>
                                                <td style='text-align:right'>" . str_replace("$", "", money_format('%(#10n', $r->COSTT)) . "</td>
                                                <td style='text-align:right'>" . str_replace("$", "", money_format('%(#10n', $r->ACCM)) . "</td>
                                                <td style='text-align:right'>" . str_replace("$", "", money_format('%(#10n', ($r->COSTT - $r->ACCM))) . "</td>
                                            </tr>
                                        ";
                    }
                  }
                  ?>
                  <tr style="background-color: #abcafc">
                    <td colspan="2">Retained Profits/(Loss) brought forward</td>
                    <td></td>
                    <td></td>
                    <td></td>
                  </tr>
                  <tr style="background-color: #abcafc">
                    <td colspan="2">Retained Profits/(Loss) for the period</td>
                    <td></td>
                    <td></td>
                    <td></td>
                  </tr>
                  <tr style="background-color: #abcafc">
                    <td colspan="2">Total</td>
                    <td style='text-align:right'><?= str_replace("$", "", money_format('%(#10n', ($ta))); ?></td>
                    <td style='text-align:right'><?= str_replace("$", "", money_format('%(#10n', ($tb))); ?></td>
                    <td style='text-align:right;'><?= str_replace("$", "", money_format('%(#10n', ($tc))); ?></td>
                  </tr>
                  <tr>
                    <td colspan="5" style="background-color: yellow"></td>
                  </tr>
                </tbody>
              </table>
          <?php
            }
          }
          ?>
        </div>
      </div>
    </div>