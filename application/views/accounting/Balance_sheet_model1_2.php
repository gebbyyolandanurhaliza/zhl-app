<?php
error_reporting(0);
?>
<?php
//periode=2016%2F04&type=tahun
$periode = $this->input->get('periode');
$type = $this->input->get('type');
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
                    <div class="form-group">
                      <label class="control-label col-md-3">Period</label>
                      <div class="col-md-9">
                        <input type="text" id="tgl_tempo" name="periode" class="form-control date date-picker" value="<?php echo $this->session->userdata('periode_1'); ?>" data-date="2016-02" data-date-format="yyyy-mm" required />

                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label col-md-3">Type of Period</label>
                      <div class="col-md-9">
                        <select name="type" class="select2me form-control">
                          <option value="bulan">Monthly Report</option>
                          <option value="tahun">Annual Report</option>
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
                      <div class="col-md-4">
                        <div class="row">
                          <div class="control-label col-md-9">
                            <!-- <button type="button" class="btn green"><i class="fa fa-file-excel-o"></i> Excel</button> -->
                            <a href="<?php echo base_url(); ?>Excel/toExcel14?periode=<?php echo $periode; ?>&type=<?php echo $type; ?>" class="btn green"><i class="fa fa-file-excel-o"></i> Excel</a>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="row">
                          <div class="control-label col-md-9">
                            <button type="button" class="btn btn-primary"><i class="fa fa-print"></i> Print</button>
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
          //if (!empty($get_invoice)) {
          ?>
          <hr />
          <table cellpadding="0" cellspacing="0" width="100%" class="table table-bordered table-striped table-condensed flip-content" id="tabel">
            <thead>
              <tr>
                <th>
                  COA Number
                </th>
                <th>
                  Account Name
                </th>
                <th>
                  Balance Current Period
                </th>
                <th>
                  Balance Last Period
                </th>
              </tr>
            </thead>
            <tbody>
              <?php
              foreach ($GroupCOA as $value) {
                echo "<tr><td colspan='8' style='text-align:center;font-weight:bold;background-color:#ddd;'> $value->GroupName</td></tr>";
                foreach ($get_profit as $v) {
                  if ($value->id_group == $v->tmp_coa_groupid) {
                    $begining = $v->tmp_balance_current_periode;
                    $mutasi = $v->tmp_balance_begining_of_year;

                    if ($begining < 0) {
                      $a = str_replace("-", "", $begining);
                      $begining = "(" . number_format($a, 2, '.', ',') . ")";
                    } else {
                      $begining = number_format($begining, 2, '.', ',');
                    }

                    if ($mutasi < 0) {
                      $b = str_replace("-", "", $mutasi);
                      $mutasi = "(" . number_format($b, 2, '.', ',') . ")";
                    } else {
                      $mutasi = number_format($mutasi, 2, '.', ',');
                    }

              ?>
                    <tr>
                      <td><?php echo $v->tmp_nocoa; ?></td>
                      <td><?php echo $v->tmp_coa_name; ?></td>
                      <td style="text-align:right;"><?php echo $begining; ?></td>
                      <td style="text-align:right;"><?php echo $mutasi; ?></td>
                    </tr>
              <?php
                  }
                }
              }
              ?>
            </tbody>
          </table>
          <?php //} 
          ?>
        </div>
      </div>
    </div>