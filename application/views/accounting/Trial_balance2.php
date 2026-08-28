<?php
error_reporting(0);
if ($this->input->get('period') <> '') {
  $tgal = $this->input->get('period');
  $tgl = explode('-', $tgal);
  $tanggal = $tgl[0];
  $bulan = $tgl[1];
  $tahun = $tgl[2];
  $datestr = $tanggal . "-" . $bulan . "-" . $tahun;
  $coa1 = $this->input->get('coa1');
  $coa2 = $this->input->get('coa2');
} else {
  $datestr = date("d-m-Y");
  $coa1 = '';
  $coa2 = '';
}
?>
<!-- BEGIN PAGE HEAD -->
<div class="page-head">
  <div class="container-fluid">
    <!-- BEGIN PAGE TITLE -->
    <div class="page-title">
      <h1>Reporting <small>Trial Balance</small></h1>
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
              <span class="caption-subject theme-font">Trial Balance </span>
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
                        <input type="text" id="tgl_tempo" name="period" class="form-control date date-picker" value="<?php echo $datestr; ?>" data-date-format="dd-mm-yyyy" required />

                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label col-md-3">Type of Currency</label>
                      <div class="col-md-9">
                        <select name="type" class="select2me form-control">
                          <option value="USD">USD</option>
                          <option value="SGD">SGD</option>
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
                            <a href="<?php echo base_url(); ?>Trial_balance/print_trial_balance?coa1=<?php echo $this->input->get('coa1'); ?>&coa2=<?php echo $this->input->get('coa2'); ?>&period=<?php echo $this->input->get('period'); ?>&type=<?php echo $this->input->get('type'); ?>" class="btn btn-primary"><i class="fa fa-print"></i> Print</a>
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
            <table cellpadding="0" cellspacing="0" width="100%" class="table table-bordered  table-hover table-striped table-condensed flip-content" id="tabel">
              <thead>
                <tr>
                  <td rowspan="2">

                  </td>
                  <td style="text-align: center">
                    DR
                  </td>
                  <td style="text-align: center">
                    CR
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
                </tr>
              </thead>
              <tbody>
                <?php
                $TDR = 0;
                $TCR = 0;
                foreach ($get_invoice as $v) {
                  $begining = $v->saldo_awal_debet - $v->saldo_awal_kredit;
                  $DR = $v->mutasi_debet;
                  $CR = $v->mutasi_kredit;

                  $TDR += $v->mutasi_debet;
                  $TCR += $v->mutasi_kredit;

                  $mutasi = $v->mutasi_debet - $v->mutasi_kredit;
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

                  if ($mutasi <> 0) {
                ?>
                    <tr>
                      <td><?php echo strtoupper($v->AccountName); ?></td>
                      <td style="text-align:right;"><?php echo $DR; ?></td>
                      <td style="text-align:right;"><?php echo $CR; ?></td>
                    </tr>
                <?php
                  }
                }
                ?>
              </tbody>
              <tfoot>
                <tr>
                  <td style="text-align:center;"><?php echo "TOTAL"; ?></td>
                  <td style="text-align:right;"><?php echo number_format($TDR, 2, '.', ','); ?></td>
                  <td style="text-align:right;"><?php echo number_format($TCR, 2, '.', ','); ?></td>
                </tr>
              </tfoot>
            </table>
          <?php } ?>
        </div>
      </div>
    </div>