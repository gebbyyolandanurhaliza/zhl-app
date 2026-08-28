<?php
$period = $this->session->userdata('periode_1');
$tgl1 = $period . "/01";
// echo $tgl;


if ($this->input->get("dari") <> '') {
  $dari = $this->input->get("dari");
  $sampai = $this->input->get("sampai");
} else {
  $tgl2 = date_create($tgl1);
  $dari = date_format($tgl2, 'd-m-Y');
  $sampai = date('t-m-Y', strtotime($dari));
}

$jenis_trans1 = $this->input->get("jenis_trans");
$noreference1 = $this->input->get("noreference");
$jenis_coa1 = $this->input->get("jenis_coa");
?>
<div class="page-head">
  <div class="container-fluid">
    <!-- BEGIN PAGE TITLE -->
    <div class="page-title">
      <h1>Accounting Report <small>Payable Invoice Transaction</small></h1>
    </div>
    <!-- END PAGE TITLE -->
  </div>
</div>

<div class="page-contenet">
  <div class="container">

    <div class="row">
      <div class="col-md-12">
        <div class="portlet light">
          <div class="portlet-title">
            <div class="caption">
              <i class="fa fa-credit-card theme-font"></i>
              <span class="caption-subject theme-font">Payable Invoice Transaction</span>
            </div>
            <div class="tools">
              <a href="javascript:;" class="collapse"></a>
              <a href="javascript:;" class="reload"></a>
            </div>
          </div>

          <div class="portlet-body">
            <form action="<?php echo base_url(); ?>All_Transaction/search" method="get">
              <div class="portlet-body">
                <div class="form-body">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group col-md-6">
                        <label class="control-label col-md-3">Date</label>
                        <div class="col-md-9">
                          <div class="input-group date-picker input-daterange" data-date="02-12-2012" data-date-format="dd-mm-yyyy">
                            <input type="text" class="form-control input-sm" id="from" name="dari" value="<?php echo $dari; ?>" required>
                            <span class="input-group-addon">
                              to </span>
                            <input type="text" class="form-control input-sm" id="to" name="sampai" value="<?php echo $sampai; ?>" required>
                          </div>
                        </div>
                      </div>
                      <div class="form-group col-md-6">
                        <label class="control-label col-md-3">Type of Journal</label>
                        <div class="col-md-6">
                          <?php
                          $style_kategori = 'class="select2me form-control" id="jenis_trans"';
                          echo form_dropdown('jenis_trans', $jenis_trans, $jenis_trans1, $style_kategori);
                          ?>
                        </div>
                      </div>
                      <div class="form-group col-md-12">
                        <button type="submit" class="btn purple kiri"><i class="fa fa-refresh"></i> Filter</button>
                        <a href="<?php echo base_url(); ?>Excel/toExcelPayableInvoice?dari=<?php echo $this->input->get('dari'); ?>&sampai=<?php echo $this->input->get('sampai'); ?>&jenis_trans=<?php echo $this->input->get('jenis_trans'); ?>" class="btn green"><i class="fa fa-file-excel-o"></i> Excel</a>
                        <a href="<?php echo base_url(); ?>All_Transaction/print_report?dari=<?php echo $this->input->get('dari'); ?>&sampai=<?php echo $this->input->get('sampai'); ?>&jenis_trans=<?php echo $this->input->get('jenis_trans'); ?>" class="btn btn-primary"><i class="fa fa-print"></i> Print</a>
                      </div>
                    </div>
                  </div>
                  <hr>
                  <?php
                  if (!empty($_tampil_item)) {
                  ?>
                    <table class="table table-bordered" id="tabel">
                      <thead>
                        <tr>
                          <th width="2%">
                            NO
                          </th>
                          <th width="8%">
                            Date
                          </th>
                          <th width="5%">
                            No. Reff
                          </th>
                          <th width="15%">
                            Vendor
                          </th>
                          <th width="5%">
                            Currency
                          </th>
                          <th width="5%">
                            Rate
                          </th>
                          <th width="5%">
                            Tax
                          </th>
                          <th width="5%">
                            Discount
                          </th>
                          <th width="5%">
                            Additional Cost
                          </th>
                          <th width="5%">
                            Deposit
                          </th>
                          <th width="5%">
                            Debit Note
                          </th>
                          <th width="5%">
                            Credit Note
                          </th>
                          <th width="5%">
                            Total
                          </th>
                          <th width="5%">
                            Payment
                          </th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        $no = 1;
                        $totalpajak = 0;
                        $totaldiskon = 0;
                        $totalbiayalain = 0;
                        $totaluang_muka = 0;
                        $totalnota_debet = 0;
                        $totalnota_kredit = 0;
                        $total_hutang = 0;
                        $total_bayar = 0;
                        foreach ($_tampil_item as $value) {
                          $totalpajak += $value->pajak;
                          $totaldiskon += $value->diskon;
                          $totalbiayalain += $value->biaya_lain;
                          $totaluang_muka += $value->uang_muka;
                          $totalnota_debet += $value->nota_debet;
                          $totalnota_kredit += $value->nota_kredit;
                          $total_hutang += $value->hutang;
                          $total_bayar += $value->bayar;
                        ?>
                          <tr>
                            <td><?php echo $no++; ?></td>
                            <td><?php echo $value->tanggal; ?></td>
                            <td><?php echo $value->nofaktur; ?></td>
                            <td><?php echo $value->namavendor; ?></td>
                            <td><?php echo $value->currency_id; ?></td>
                            <td align='right'><?php echo $value->rate; ?></td>
                            <td align='right'><?php echo number_format($value->pajak, 2, ".", ","); ?></td>
                            <td align='right'><?php echo number_format($value->diskon, 2, ".", ","); ?></td>
                            <td align='right'><?php echo number_format($value->biaya_lain, 2, ".", ","); ?></td>
                            <td align='right'><?php echo number_format($value->uang_muka, 2, ".", ","); ?></td>
                            <td align='right'><?php echo number_format($value->nota_debet, 2, ".", ","); ?></td>
                            <td align='right'><?php echo number_format($value->nota_kredit, 2, ".", ","); ?></td>
                            <td align='right'><?php echo number_format($value->hutang, 2, ".", ","); ?></td>
                            <td align='right'><?php echo number_format($value->bayar, 2, ".", ","); ?></td>
                          </tr>
                        <?php
                        }
                        ?>
                      </tbody>
                      <tfoot>
                        <tr>
                          <td colspan='6' align='right'><b>TOTAL</b></td>
                          <td align='right'><?php echo number_format($totalpajak, 2, ".", ","); ?></td>
                          <td align='right'><?php echo number_format($totaldiskon, 2, ".", ","); ?></td>
                          <td align='right'><?php echo number_format($totalbiayalain, 2, ".", ","); ?></td>
                          <td align='right'><?php echo number_format($totaluang_muka, 2, ".", ","); ?></td>
                          <td align='right'><?php echo number_format($totalnota_debet, 2, ".", ","); ?></td>
                          <td align='right'><?php echo number_format($totalnota_kredit, 2, ".", ","); ?></td>
                          <td align='right'><?php echo number_format($total_hutang, 2, ".", ","); ?></td>
                          <td align='right'><?php echo number_format($total_bayar, 2, ".", ","); ?></td>
                        </tr>

                      </tfoot>
                    </table>

                  <?php
                  }
                  ?>

                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>

<script type="text/javascript">
  $(document).ready(function() {
    $("#tabel").dataTable({
      "scrollY": 300,
      "scrollX": true
    });
  });
</script>