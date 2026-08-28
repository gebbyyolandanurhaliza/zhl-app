<?php
error_reporting(0);
$supp = $this->input->get('supplier');
$cur = $this->input->get('currency');
if ($this->input->get('periode')) {
  $period = $this->input->get('periode');
} else {
  $period = date("Y-m");
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
            <form action="<?php echo base_url(); ?>Receivable_invoice/search" method="get">
              <div class="portlet-body">
                <div class="form-body">
                  <div class="row">

                    <!--/span-->
                    <div class="col-md-4">
                      <div class="form-group">
                        <label class="control-label col-md-2">Customer</label>
                        <div class="col-md-10">
                          <?php
                          $style_kategori = 'class="select2me form-control" id="idate" ';
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
                          $style_curreny = 'class="selecidatet2me form-control" id="currency" ';
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
                          <button type="submit" class="btn purple"><i class="fa fa-refresh"></i> Refresh</button>
                          <!-- <button type="button" class="btn green"><i class="fa fa-file-excel-o"></i> Excell</button> -->
                          <a href="<?php echo base_url(); ?>Excel/toExcel5?supplier=<?php echo $supp; ?>&currency=<?php echo $cur; ?>&periode=<?php echo $period; ?>" class="btn green"><i class="fa fa-file-excel-o"></i> Excel</a>
                          <a href="<?php echo base_url(); ?>Payable_invoice/print_report?dari=<?php echo $this->input->get('periode'); ?>&supplier=<?php echo $this->input->get('supplier'); ?>&currency=<?php echo $this->input->get('currency'); ?>" class="btn btn-primary"><i class="fa fa-print"></i> Print</a>
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
                              <!-- <button type="button" class="btn green"><i class="fa fa-file-excel-o"></i> Excel</button> -->
                              <a href="<?php echo base_url(); ?>Excel/toExcel6?supplier=<?php echo $supp; ?>&currency=<?php echo $cur; ?>&periode=<?php echo $period; ?>" class="btn green"><i class="fa fa-file-excel-o"></i> Excel</a>
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
                    <!--/span-->
                  </div>
                </div>
              </div>
            </form>
          </div>
          <?php
          if (!empty($get_invoice)) {
          ?>
            <table cellpadding="0" cellspacing="0" width="100%" class="table table-bordered table-striped table-condensed flip-content" id="tabel">
              <thead>
                <tr>
                  <th>
                    No
                  </th>
                  <th>
                    Supplier Name
                  </th>
                  <th>
                    Invoice Number
                  </th>
                  <th>
                    Invoice Date
                  </th>
                  <th>
                    Due Date
                  </th>
                  <th>
                    Currency
                  </th>
                  <th>
                    Total
                  </th>
                  <th>
                    Rate
                  </th>
                  <th>
                    Total USD
                  </th>

                </tr>
              </thead>
              <tbody>
                <?php
                $No = 1;
                foreach ($get_invoice as $v) {
                  $uang_muka += $v->uang_muka;
                  $sisa += $v->piutang;
                  $Total_usd += $v->Total_usd;
                  $Total_usd_rateakhir += $v->Total_usd_rateakhir;
                ?>
                  <tr>
                    <td><?php echo $No ?></td>
                    <td><?php echo $v->customer_name; ?></td>
                    <td><?php echo $v->nofaktur; ?></td>
                    <td><?php echo $v->tanggal_invoice; ?></td>
                    <td><?php echo $v->tanggal_tempo; ?></td>
                    <td style="text-align:center;"><?php echo $v->currency_id; ?></td>
                    <td style="text-align:right;"><?php echo $v->piutang ?></td>
                    <td style="text-align:right;"><?php echo number_format($v->rate_awal, 6, ',', '.'); ?></td>
                    <td style="text-align:right;"><?php echo number_format($v->Total_usd, 2, ',', '.'); ?></td>

                  </tr>
                <?php
                }
                ?>
              </tbody>
              <tfoot>
                <tr>
                  <td colspan='6' align='right'><b>Grand Total</b></td>
                  <td align='right'><?php echo number_format($uang_muka, 2, ".", ","); ?></td>
                  <td align='right'><?php echo number_format($sisa, 2, ".", ","); ?></td>
                  <td align='center'>-</td>
                  <td align='right'>-</td>
                  <td align='right'><?php echo number_format($Total_usd, 2, ".", ","); ?></td>
                  <td align='right'>-</td>
                  <td align='right'>-</td>
                </tr>

              </tfoot> ̰
            </table>
          <?php } ?>
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