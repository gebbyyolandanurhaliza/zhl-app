<?php
//error_reporting(0)
$period = $this->input->get('period');
// $sampai = $this->input->get('sampai');
$supplier = $this->input->get('supplier');
$currency = $this->input->get('currency');
?>
<!-- IMPORTANT! fullcalendar depends on jquery-ui.min.js for drag & drop support -->
<!-- BEGIN PAGE HEAD -->
<div class="page-head">
  <div class="container-fluid">
    <!-- BEGIN PAGE TITLE -->
    <div class="page-title">
      <h1>Accounting Report <small>Payable Statement</small></h1>
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
              <span class="caption-subject theme-font">Payable Statement Report</span>
            </div>
            <div class="tools">
              <a href="javascript:;" class="collapse"></a>
              <a href="javascript:;" class="reload"></a>
            </div>
          </div>
          <form action="<?php echo base_url(); ?>Payable_statement/search" method="get">
            <div class="portlet-body">
              <div class="form-body">
                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="control-label col-md-3">Period</label>
                      <div class="col-md-9">
                        <div class="input-group date-picker input-daterange" data-date-format="dd-mm-yyyy">
                          <!-- <input type="text" class="form-control input-sm" id="from" name="dari" value="<?php echo $dari; ?>" required>
                                                    <span class="input-group-addon">
                                                        to </span>
                                                    <input type="text" class="form-control input-sm" id="to" name="sampai" value="<?php echo $sampai; ?>" required> -->

                          <input type="text" class="form-control input-sm" id="period" name="period" value="<?php echo $period; ?>" required>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!--/span-->
                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="control-label col-md-2">Supplier</label>
                      <div class="col-md-10">
                        <?php
                        $style_kategori = 'class="select2me form-control" id="supplier"';
                        echo form_dropdown('supplier', $SupplierID, $supplier, $style_kategori);
                        ?>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="control-label col-md-3">Currency</label>
                      <div class="col-md-9">
                        <?php
                        $style_curreny = 'class="select2me form-control" id="currency" required';
                        echo form_dropdown('currency', $CurrencyID, $currency, $style_curreny);
                        ?>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">

                      <div class="col-md-4">
                        <div class="row">
                          <div class="control-label col-md-9">
                            <button type="submit" class="btn purple kiri"><i class="fa fa-refresh"></i> Filter</button>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="row">
                          <div class="control-label col-md-9">
                            <a href="<?php echo base_url(); ?>Payable_statement/toExcel?period=<?php echo $this->input->get('period'); ?>&supplier=<?php echo $this->input->get('supplier'); ?>&currency=<?php echo $this->input->get('currency'); ?>" class="btn green"><i class="fa fa-file-excel-o"></i> Excel</a>

                          </div>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="row">
                          <div class="control-label col-md-9">
                            <a href="<?php echo base_url(); ?>Payable_statement/print_report?period=<?php echo $this->input->get('period'); ?>&supplier=<?php echo $this->input->get('supplier'); ?>&currency=<?php echo $this->input->get('currency'); ?>" class="btn btn-primary"><i class="fa fa-print"></i> Print</a>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!--/span-->
                </div>
              </div>
            </div>
          </form>
          <?php
          if (!empty($get_agings)) {
          ?>
            <table cellpadding="0" cellspacing="0" width="100%" class="table table-bordered table-striped table-condensed flip-content" id="tabel">
              <thead>
                <tr>
                  <th width="6%">
                    Invoice Date
                  </th>
                  <th width="10%">
                    Invoice No.
                  </th>
                  <th width="6%">
                    Due Date
                  </th>
                  <th width="20%">
                    Ref No
                  </th>
                  <th width="6%">
                    Amount (<?php echo $currency; ?>)
                  </th>
                  <th width="6%">
                    Payment (<?php echo $currency; ?>)
                  </th>
                  <th width="6%">
                    Payment Date
                  </th>
                  <th width="6%">
                    Balance (<?php echo $currency; ?>)
                  </th>
                  <th width="6%">
                    Current
                  </th>
                  <th width="6%">
                    1-30 Days
                  </th>
                  <th width="6%">
                    31-60 Days
                  </th>
                  <th width="6%">
                    61-90 Days
                  </th>
                  <th width="6%">
                    >90 Days
                  </th>
                </tr>
              </thead>
              <tbody>
                <?php
                $balance;
                foreach ($get_agings as $row_agings) {
                  if ($row_agings->tmp_payment == 0) {
                    $balance = $row_agings->tmp_hutang;
                    $tanggal = "-";
                  } else {
                    if (!empty($row_agings->tmp_hutang)) {
                      $balance = $row_agings->tmp_hutang - $row_agings->tmp_payment;
                    } else {
                      $balance = 0;
                    }
                    $tanggal = date('d-m-Y', strtotime($row_agings->tmp_realisasi_date));
                  } ?>
                  <tr>
                    <td style="text-align: left;"><?php if (!empty($row_agings->tmp_inv_date)) {
                                                    echo date('d-M', strtotime($row_agings->tmp_inv_date));
                                                  } ?></td>
                    <td><?php echo $row_agings->tmp_invno; ?></td>
                    <td style="text-align: left;"><?php if (!empty($row_agings->tmp_due_date)) {
                                                    echo date('d-M', strtotime($row_agings->tmp_due_date));
                                                  } ?></td>
                    <td style="text-align: center;"><?php echo ""; ?></td>
                    <td style="text-align: right;"><?php echo number_format($row_agings->tmp_hutang, 2); ?></td>
                    <td style="text-align: right; color: red;"><?php echo number_format($row_agings->tmp_payment); ?></td>
                    <td style="text-align: right;"><?php if (!empty($row_agings->tmp_realisasi_date)) {
                                                      echo $tanggal;
                                                    } ?></td>
                    <td style="text-align: right;"><?php echo number_format($balance, 2); ?></td>
                    <td style="text-align: right;"><?php echo number_format($row_agings->tmp_not_due_date, 2); ?></td>
                    <td style="text-align: right;"><?php echo number_format($row_agings->tmp_0sd30, 2); ?></td>
                    <td style="text-align: right;"><?php echo number_format($row_agings->tmp_31sd60, 2); ?></td>
                    <td style="text-align: right;"><?php echo number_format($row_agings->tmp_61sd90); ?></td>
                    <td style="text-align: right;"><?php echo number_format($row_agings->tmp_91sd120 + $row_agings->tmp_more120, 2); ?></td>
                  </tr>
                <?php
                } ?>
              </tbody>
              <?php
              $hutang = 0;
              $payment = 0;
              $not_due_date = 0;
              $tiga = 0;
              $enam = 0;
              $sembilan = 0;
              $lebih = 0;
              foreach ($get_agings as $footer_agings) {
                $hutang += $footer_agings->tmp_hutang;
                if (!empty($footer_agings->tmp_hutang)) {
                  $payment += $footer_agings->tmp_payment;
                }
                $not_due_date += $footer_agings->tmp_not_due_date;
                $tiga += $footer_agings->tmp_0sd30;
                $enam += $footer_agings->tmp_31sd60;
                $sembilan += $footer_agings->tmp_61sd90;
                $lebih += $footer_agings->tmp_91sd120 + $footer_agings->tmp_more120;
              }
              ?>
              <tfoot>
                <tr>
                  <td colspan="4" style="text-align: right;">Total</td>
                  <td style="text-align: right;"><?php echo number_format($hutang, 2, '.', ','); ?></td>
                  <td style="text-align: right; color: red;"><?php echo number_format($payment, 2, '.', ','); ?></td>
                  <td style="text-align: right;"><?php echo ""; ?></td>
                  <td style="text-align: right;"><?php echo number_format($hutang - $payment, 2, '.', ','); ?></td>
                  <td style="text-align: right;"><?php echo number_format($not_due_date, 2, '.', ','); ?></td>
                  <td style="text-align: right;"><?php echo number_format($tiga, 2, '.', ','); ?></td>
                  <td style="text-align: right;"><?php echo number_format($enam, 2, '.', ','); ?></td>
                  <td style="text-align: right;"><?php echo number_format($sembilan, 2, '.', ','); ?></td>
                  <td style="text-align: right;"><?php echo number_format($lebih, 2, '.', ','); ?></td>
                </tr>
              </tfoot>
            <?php
          }
            ?>
            </table>
        </div>
      </div>
    </div>
  </div>