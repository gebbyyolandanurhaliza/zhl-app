<?php
//error_reporting(0)


$dari = $this->input->get('dari');
$sampai = $this->input->get('sampai');
$supplier = $this->input->get('supplier');
$currency = $this->input->get('currency');
?>
<!-- IMPORTANT! fullcalendar depends on jquery-ui.min.js for drag & drop support -->
<!-- BEGIN PAGE HEAD -->
<div class="page-head">
  <div class="container-fluid">
    <!-- BEGIN PAGE TITLE -->
    <div class="page-title">
      <h1>Accounting Report <small>Receivable Statement</small></h1>
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
              <span class="caption-subject theme-font">Receivable Statement Report</span>
            </div>
          </div>
          <form action="<?php echo base_url(); ?>Receivable_statement/search" method="get">
            <div class="portlet-body">
              <div class="form-body">
                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group">
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
                  </div>

                  <!--/span-->
                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="control-label col-md-2">Supplier</label>
                      <div class="col-md-10">
                        <?php
                        $style_kategori = 'class="select2me form-control" id="supplier" required';
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
                  <div class="col-md-12">
                    <hr />
                    <button type="submit" class="btn purple kiri"><i class="fa fa-refresh"></i> Filter</button>
                    <a href="<?php echo base_url(); ?>Receivable_statement/print_excel?periode=<?php echo $this->input->get('periode'); ?>&supplier=<?php echo $this->input->get('supplier'); ?>&currency=<?php echo $this->input->get('currency'); ?>" class="btn green"><i class="fa fa-file-excel-o"></i> Excel</a>
                    <a href="<?php echo base_url(); ?>Receivable_statement/print_report?periode=<?php echo $this->input->get('periode'); ?>&supplier=<?php echo $this->input->get('supplier'); ?>&currency=<?php echo $this->input->get('currency'); ?>" class="btn btn-primary"><i class="fa fa-print"></i> Print</a>
                    <hr />
                  </div>

                  <!--/span-->
                </div>
              </div>
            </div>
          </form>
          <?php
          if (!empty($get_agings)) {
          ?>
            <hr />
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
                $balance = 0;
                foreach ($get_agings as $v) {
                  if ($v->tmp_payment == 0) {
                    $balance = $v->tmp_piutang;
                    $tanggal = "-";
                  } else {
                    $balance = 0;
                    $tanggal = date('d-M-Y', strtotime($v->tmp_realisasi_date));
                  }
                ?>
                  <tr>
                    <td style="text-align: left;"><?php echo date('d-M', strtotime($v->tmp_inv_date)); ?></td>
                    <td><?php echo $v->tmp_invno; ?></td>
                    <td style="text-align: left;"><?php echo date('d-M', strtotime($v->tmp_due_date)); ?></td>
                    <td style="text-align: center;"><?php echo ""; ?></td>
                    <td style="text-align: right;"><?php echo number_format($v->tmp_piutang, 2); ?></td>
                    <td style="text-align: right; color: red"><?php echo number_format($v->tmp_payment, 2); ?></td>
                    <td style="text-align: right;"><?php echo  $tanggal; ?></td>
                    <td style="text-align: right;"><?php echo number_format($balance, 2); ?></td>
                    <td style="text-align: right;"><?php echo number_format($v->tmp_not_due_date, 2); ?></td>
                    <td style="text-align: right;"><?php echo number_format($v->tmp_0sd30, 2); ?></td>
                    <td style="text-align: right;"><?php echo number_format($v->tmp_31sd60, 2); ?></td>
                    <td style="text-align: right;"><?php echo number_format($v->tmp_61sd90, 2); ?></td>
                    <td style="text-align: right;"><?php echo number_format($v->tmp_91sd120 + $v->tmp_more120, 2); ?></td>
                  </tr>
                <?php
                }
                ?>
              </tbody>
              <?php
              $current = 0;
              $tiga = 0;
              $enam = 0;
              $sembilan = 0;
              $lebih = 0;
              $piutang = 0;
              $bayar = 0;
              foreach ($get_agings as $x) {
                $currency = $x->tmp_currency;
                $current += $x->tmp_not_due_date;
                $piutang += $x->tmp_piutang;
                $bayar += $x->tmp_payment;
                $tiga += $x->tmp_0sd30;
                $enam += $x->tmp_31sd60;
                $sembilan += $x->tmp_61sd90;
                $lebih += $x->tmp_91sd120;
              }
              ?>
              <tfoot>
                <tr>
                  <td colspan="4" style="text-align: right">Total</td>
                  <td style="text-align: right"><?php echo number_format($piutang, 2, '.', ','); ?></td>
                  <td style="text-align: right; color:red"><?php echo number_format($bayar, 2, '.', ','); ?></td>
                  <td style="text-align: right"><?php echo ""; ?></td>
                  <td style="text-align: right;"><?php echo number_format($piutang - $bayar, 2, '.', ','); ?></td>
                  <td style="text-align: right"><?php echo number_format($current, 2, '.', ','); ?></td>
                  <td style="text-align: right"><?php echo number_format($tiga, 2, '.', ','); ?></td>
                  <td style="text-align: right"><?php echo number_format($enam, 2, '.', ','); ?></td>
                  <td style="text-align: right"><?php echo number_format($sembilan, 2, '.', ','); ?></td>
                  <td style="text-align: right"><?php echo number_format($lebih, 2, '.', ','); ?></td>
                </tr>
              </tfoot>

            <?php
          }
            ?>
            </table>
            <?php
            ?>

        </div>
      </div>
    </div>
  </div>

  <script type="text/javascript">
    $(document).ready(function() {
      $("#tabel").dataTable({
        "scrollY": 400,
        "scrollX": true
      });
    });
  </script>