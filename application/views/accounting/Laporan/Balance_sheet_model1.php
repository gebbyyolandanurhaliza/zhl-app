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
                        <a href="<?php echo base_url(); ?>Excel3/toExcelBalanceSheet2?dari=<?php echo $dari; ?>&sampai=<?php echo $sampai; ?>" class="btn green col-md-3"><i class="fa <!-- fa-file-excel-o"></i> Excel</a>
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
          if (!empty($get_profit)) {
          ?>
            <hr />
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
                $ttl_asset = 0;
                $ttl_other = 0;
                $ttl_equity = 0;

                foreach ($GroupCOA as $value) {
                  echo "<tr><td colspan='8' style='text-align:left;font-weight:bold;background-color:#ddd;'> $value->sub_group</td></tr>";
                  foreach ($get_profit as $x) {
                    if ($value->id_sub_group == $x->id_sub_group) {
                      $id_group = $x->id_sub_group;

                      if ($x->id_sub_group == '1' || $x->id_sub_group == '2') {
                        $ammount = $x->BLDebet - $x->BLKredit;
                      } else {
                        $ammount = $x->BLKredit - $x->BLDebet;
                      }

                      if ($x->id_group !== '214') {
                ?>
                        <tr>
                          <td><?php echo $x->nama_group; ?></td>
                          <td style="text-align:right;"><?php echo str_replace("$", "", money_format('%(#10n', $ammount)); ?></td>
                        </tr>
                        <?php
                        //accum total
                        if ($x->id_sub_group == '1' || $x->id_sub_group == '2') {
                          $ttl_asset += $x->BLDebet - $x->BLKredit;
                        } else if ($x->id_sub_group == '4') {
                          $ttl_equity += $x->BLKredit - $x->BLDebet;
                        } else {
                          $ttl_other += $x->BLKredit - $x->BLDebet;
                        }
                      } elseif ($x->id_group == '214') {
                        $sql = $this->db->query("SELECT IFNULL(SUM(Debet - Kredit),0) as current FROM acc_tbl_trn_jurnal where Tanggal between '2017/01/01' and  '$p_sampai' and NoCOA in (select no_coa from acc_report_coa where id_group in (1,72,73,224,225)) ");

                        if ($sql->num_rows() > 0) {
                          foreach ($sql->result() as $r) {
                            $CY = abs($r->current);
                          }
                        }

                        ?>
                        <tr>
                          <td><?php echo $x->nama_group; ?></td>
                          <td style="text-align:right;"><?php echo str_replace("$", "", money_format('%(#10n', $CY)); ?></td>
                        </tr>
                    <?php
                      }
                    }
                  }
                  if ($id_group == '2') {
                    ?>
                    <tr>
                      <td style="text-align:right; background: #abcafc; font-weight: bold;">TOTAL ASSETS</td>
                      <td style="text-align:right; background: #abcafc; font-weight: bold;"><?php echo str_replace("$", "", money_format('%(#10n', $ttl_asset)); ?></td>
                    </tr>
                  <?php
                  } else if ($id_group == '3') {
                  ?>
                    <tr>
                      <td style="text-align:right; background: #abcafc; font-weight: bold;">TOTAL CURRENT LIABILITIES</td>
                      <td style="text-align:right; background: #abcafc; font-weight: bold;"><?php echo str_replace("$", "", money_format('%(#10n', $ttl_other)); ?></td>
                    </tr>
                  <?php
                  } else if ($id_group == '4') {
                  ?>
                    <tr>
                      <td style="text-align:right; background: #abcafc; font-weight: bold;">TOTAL EQUITY</td>
                      <td style="text-align:right; background: #abcafc; font-weight: bold;"><?php echo str_replace("$", "", money_format('%(#10n', $ttl_equity + $CY)); ?></td>
                    </tr>
                    <tr>
                      <td style="text-align:right; background: #abcafc; font-weight: bold;">TOTAL CURRENT LIABILITIES AND EQUITY</td>
                      <td style="text-align:right; background: #abcafc; font-weight: bold;"><?php echo str_replace("$", "", money_format('%(#10n', $ttl_other + $ttl_equity + $CY)); ?></td>
                    </tr>
                <?php
                  }
                }
                ?>
              </tbody>
            </table>
          <?php
          }
          ?>
        </div>
      </div>
    </div>