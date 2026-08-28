<?php
error_reporting(0);
$supp = $this->input->get('supplier');
$cur = $this->input->get('currency');
if ($this->input->get('periode')) {
  $period = $this->input->get('periode');
} else {
  $period = date("Y-m");
}
$curTemp = $cur;

if ($curTemp == '') {
  $curTemp = 'USD';
}

?>
<!-- BEGIN PAGE HEAD -->
<div class="page-head">
  <div class="container-fluid">
    <!-- BEGIN PAGE TITLE -->
    <div class="page-title">
      <h1>Accounting Report <small>Accounts of Receivable Invoice</small></h1>
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
              <span class="caption-subject theme-font">Monitoring Accounts Receivable Invoice</span>
            </div>
            <div class="tools">
              <a href="javascript:;" class="collapse"></a>
              <a href="javascript:;" class="reload"></a>
            </div>
          </div>
          <div class="portlet-body">
            <form action="<?php echo base_url(); ?>Payable_invoice/search" method="get">
              <div class="portlet-body">
                <div class="form-body">
                  <div class="row">

                    <!--/span-->
                    <div class="col-md-4">
                      <div class="form-group">
                        <label class="control-label col-md-2">Customer</label>
                        <div class="col-md-10">
                          <?php
                          $style_kategori = 'class="select2me form-control" id="supplier" ';
                          echo form_dropdown('supplier', $SupplierID, $supp, $style_kategori);
                          ?>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label class="control-label col-md-3">Currency</label>
                        <div class="col-md-9">
                          <?php
                          $style_curreny = 'class="select2me form-control" id="currency" ';
                          echo form_dropdown('currency', $CurrencyID, $cur, $style_curreny);
                          ?>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="form-group">
                        <label class="control-label col-md-3">Date</label>
                        <div class="col-md-9">
                          <input type="text" id="tgl_tempo" name="periode" class="form-control date date-picker" value="<?php echo $period; ?>" data-date="2016-02" data-date-format="yyyy-mm" required />

                        </div>
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="form-group">
                        <hr>
                        <div class="col-md-9">
                          <button type="submit" class="btn purple"><i class="fa fa-refresh"></i> Filter</button>
                          <!-- <button type="button" class="btn green"><i class="fa fa-file-excel-o"></i> Excell</button> -->
                          <a href="<?php echo base_url(); ?>Excel/toExcel6?supplier=<?php echo $supp; ?>&currency=<?php echo $cur; ?>&periode=<?php echo $period; ?>" class="btn green"><i class="fa fa-file-excel-o"></i> Excel</a>
                          <a href="<?php echo base_url(); ?>Payable_invoice/print_report?dari=<?php echo $this->input->get('periode'); ?>&supplier=<?php echo $this->input->get('supplier'); ?>&currency=<?php echo $this->input->get('currency'); ?>" class="btn btn-primary"><i class="fa fa-print"></i> Print</a>
                        </div>
                      </div>
                    </div>

                    <!--/span-->
                  </div>
                </div>
              </div>
            </form>
          </div>
          <?php
          if (!empty($get_invoice)) {
          ?>
            <table class="table table-bordered" id="tabel">
              <thead>
                <tr>
                  <th width="20%">
                    Customer Name
                  </th>
                  <th width="10%">
                    Invoice Number
                  </th>
                  <th width="8%">
                    Invoice Date
                  </th>
                  <th width="8%">
                    Due Date
                  </th>
                  <th width="8%">
                    Currency
                  </th>
                  <th width="20%">
                    Total
                  </th>
                  <th width="20%">
                    Rate
                  </th>
                  <th width="10%">
                    Total <?php echo $curTemp; ?>
                  </th>
                  <th width="20%">
                    PO
                  </th>

                </tr>
              </thead>
              <tbody>
                <?php
                foreach ($GroupSupplierID as $row_suplier) {
                  echo "<tr><td colspan='10' nowrap='' style='text-align:left;font-weight:bold;background-color:#ddd;'>$row_suplier->customer_name</td></tr>";
                  echo "<tr><td colspan='10' nowrap='' style='text-align:left;font-weight:bold;background-color:#ddd;'>$row_suplier->customer_address</td></tr>";

                  $uang_muka = 0;
                  $total = 0;
                  $totalusd = 0;
                  $Total_usd_rateakhir = 0;
                  foreach ($get_invoice as $row_invoice) {
                    if ($row_invoice->kode_sup == $row_suplier->kode_sup) {
                      $total += $row_invoice->piutang;
                      $totalusd += $row_invoice->Total_usd;
                      $totalusd_akhir += $row_invoice->Total_usd_rateakhir;
                      $uang_muka += $row_invoice->uang_muka;
                ?>
                      <!-- <pre><?php print_r($row_suplier); ?></pre> -->
                      <tr>
                        <td><?php  ?></td>
                        <td><?php echo $row_invoice->nofaktur; ?></td>
                        <td><?php echo date("d-m-y", strtotime($row_invoice->tanggal)); ?></td>
                        <td><?php echo date("d-m-y", strtotime($row_invoice->tanggal_tempo)); ?></td>
                        <td style="text-align: center;"><?php echo $row_invoice->currency_id; ?></td>
                        <td style="text-align: right;"><?php echo number_format($row_invoice->piutang); ?></td>
                        <td style="text-align: right;"><?php echo number_format($row_invoice->rate); ?></td>
                        <td style="text-align: right;"><?php echo number_format($row_invoice->Total_usd); ?></td>
                        <td><?php echo $row_invoice->PO; ?></td>
                      </tr>
                <?php
                    }
                  }
                  echo "<tr style='background: #ffffcc'><td colspan='5' style='text-align:right;'><b>Grand Total</b></td>"
                    . "<td style='text-align:right;font-weight: bold;'>" . number_format($total, 2, '.', ',') . "</td>"
                    . "<td style='text-align:right;font-weight: bold;'>" . "</td>"
                    . "<td style='text-align:right;font-weight: bold;'>" . number_format($totalusd, 2, '.', ',') . "</td>"
                    . "<td style='text-align:right;font-weight: bold;'>" . "</td></tr>";
                } ?>
              </tbody>
            </table>
          <?php } ?>
        </div>
      </div>
    </div>
  </div>

  <!-- <script type="text/javascript">
        $(document).ready(function () {
            $("#tabel").dataTable({
                "scrollY": 400,
                "scrollX": true});
        });
    </script>  -->