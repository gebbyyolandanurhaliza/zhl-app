<?php
if ($this->input->get('periode') <> '') {
  $supp = $this->input->get('supplier');
  $cur = $this->input->get('currency');
  $period = $this->input->get('periode');
} else {
  $supp = "";
  $cur = "";
  $period = $this->session->userdata('periode_1');
}

?>
<!-- BEGIN PAGE HEAD -->
<div class="page-head">
  <div class="container-fluid">
    <!-- BEGIN PAGE TITLE -->
    <div class="page-title">
      <h1>Accounting <small>Payable Invoice</small></h1>
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
              <span class="caption-subject theme-font">Monitoring Accounts Payable Invoice</span>
            </div>
            <div class="tools">
              <a href="javascript:;" class="collapse"></a>
              <a href="javascript:;" class="reload"></a>
            </div>
          </div>
          <div class="portlet-body">
            <form action="<?php echo base_url(); ?>Payable_invoice/search" method="get">
              <div class="form-body">
                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="control-label col-md-2">Supplier</label>
                      <div class="col-md-10">
                        <?php
                        $style_kategori = 'class="select2me form-control" id="supplier" ';
                        echo form_dropdown('supplier', $SupplierID, $supp, $style_kategori);
                        ?>
                      </div>
                    </div>
                  </div>
                  <!--/span-->
                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="control-label col-md-3">Currency</label>
                      <div class="col-md-9">
                        <?php
                        $style_currency = 'class="select2me form-control" id="currency" ';
                        echo form_dropdown('currency', $CurrencyID, $cur, $style_currency);
                        ?>
                      </div>
                    </div>
                  </div>
                  <!--/span-->
                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="control-label col-md-2">Date</label>
                      <div class="col-md-9">
                        <input type="text" id="tgl_tempo" name="periode" class="form-control date date-picker" value="<?php echo $period; ?>" data-date-format="yyyy/mm" required />
                      </div>
                    </div>
                  </div>
                  <!--/span-->
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
                  <hr />
                </div>
              </div>
            </form>
          </div>
          <?php
          if (!empty($get_invoice)) {
          ?>
            <hr />
            <table class="table table-bordered table-striped table-condensed flip-content" id="tabel">
              <thead>
                <tr>
                  <th>
                    Supplier ID
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
                    Date of Journal
                  </th>
                  <th>
                    Due Date
                  </th>
                  <th>
                    Prepaid
                  </th>
                  <th>
                    Total
                  </th>
                  <th>
                    Currency
                  </th>
                  <th>
                    Rate
                  </th>
                  <th>
                    Total USD
                  </th>
                  <th>
                    Ending Rate
                  </th>
                  <th>
                    Ending Total
                  </th>
                </tr>
              </thead>
              <tbody>
                <?php
                $Total_usd_rateakhir = 0;
                $Total_usd = 0;
                $uang_muka = 0;
                $sisa = 0;
                $Total_usd = 0;
                $Total_usd_rateakhir = 0;
                foreach ($get_invoice as $v) {
                  $Total_usd += $v->Total_usd;
                  $Total_usd_rateakhir += $v->Total_usd_rateakhir;
                  $uang_muka += $v->uang_muka;
                  $sisa += $v->sisa_hutang;
                  $Total_usd += $v->Total_usd;
                  $Total_usd_rateakhir += $v->Total_usd_rateakhir;
                  $n1 = number_format($Total_usd, 2, '.', ',');
                  $n2 = number_format($Total_usd_rateakhir, 2, '.', ',');
                ?>
                  <tr>
                    <td><?php echo $v->kode_sup; ?></td>
                    <td><?php echo $v->suppliercompany; ?></td>
                    <td><?php echo $v->nofaktur; ?></td>
                    <td><?php echo $v->tanggal_invoice; ?></td>
                    <td><?php echo $v->tanggal; ?></td>
                    <td><?php echo $v->tanggal_tempo; ?></td>
                    <td style="text-align:right;"><?php echo number_format($v->uang_muka, 2, ',', '.'); ?></td>
                    <td style="text-align:right;"><?php echo number_format($v->sisa_hutang, 2, ',', '.'); ?></td>
                    <td style="text-align:center;"><?php echo $v->currency_id; ?></td>
                    <td style="text-align:right;"><?php echo number_format($v->rate_awal, 6, ',', '.'); ?></td>
                    <td style="text-align:right;"><?php echo number_format($v->Total_usd, 2, ',', '.'); ?></td>
                    <td style="text-align:right;"><?php echo number_format($v->rate_akhir, 6, ',', '.'); ?></td>
                    <td style="text-align:right;"><?php echo number_format($v->Total_usd_rateakhir, 2, ',', '.'); ?></td>
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
                  <td align='right'><?php echo number_format($Total_usd_rateakhir, 2, ".", ","); ?></td>
                </tr>

              </tfoot>
            </table>
          <?php } ?>
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