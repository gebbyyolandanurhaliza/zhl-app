<?php
$period = $this->session->userdata('periode_1');

if (isset($_GET['dari'])) {
  $tgl1 = $_GET['dari'];
} else {
  $tgl1 = $period . "/01";
}

if (isset($_GET['sampai'])) {
  $tgl2 = $_GET['sampai'];
} else {
  $tgl2 = date('t-m-Y', strtotime($period . "/01"));
}

$sup = $this->input->get('sup');
?>
<div class="page-head">
  <div class="container-fluid">
    <!-- BEGIN PAGE TITLE -->
    <div class="page-title">
      <h1>Finance Report <small>Account Payable</small></h1>
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
              <span class="caption-subject theme-font">Monitoring Account Payable </span>
            </div>
            <div class="tools">
              <a href="javascript:;" class="collapse"></a>
              <a href="javascript:;" class="reload"></a>
            </div>
          </div>

          <div class="portlet-body">
            <form action="<?php echo base_url(); ?>Monitoring_finace/ap_payment_search" method="get">
              <div class="portlet-body">
                <div class="form-body">
                  <div class="row">
                    <div class="form-group col-md-4">
                      <label class="control-label col-md-3">Date</label>
                      <div class="col-md-9">
                        <div class="input-group date-picker input-daterange" data-date="02-12-2012" data-date-format="dd-mm-yyyy">
                          <input type="text" class="form-control input-sm" id="from" name="dari" value="<?php echo date('d-m-Y', strtotime($tgl1)); ?>" required>
                          <span class="input-group-addon">
                            to </span>
                          <input type="text" class="form-control input-sm" id="to" name="sampai" value="<?php echo date('d-m-Y', strtotime($tgl2)); ?>" required>
                        </div>
                      </div>
                    </div>
                    <div class="form-group col-md-5">
                      <label class="control-label col-md-3">Vendor</label>
                      <div class="col-md-9">
                        <?php
                        $style_kategori = 'class="select2me form-control" id="supplier"';
                        echo form_dropdown('sup', $SupplierID, $sup, $style_kategori);
                        ?>
                      </div>
                    </div>
                    <div class="form-group col-md-4 display-none">
                      <label class="control-label col-md-3">Currency</label>
                      <div class="col-md-9">
                        <?php
                        // $style_kategori = 'class="select2me form-control" id="cur"';
                        // echo form_dropdown('cur', $_CurrencyID, $cur, $style_kategori);
                        ?>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <button type="submit" class="btn purple kiri"><i class="fa fa-refresh"></i> Filter</button>
                      <!-- <a href="<?php echo base_url(); ?>Excel/toExcelMonRegBook?coa=<?php echo $coa; ?>&dari=<?php echo $tgl1; ?>&sampai=<?php echo $tgl2; ?>" class="btn green enabled"><i class="fa fa-file-excel-o"></i> Excel</a>
                                            <a href="<?php echo base_url(); ?>Monitoring_finace/toPrintRegisterBook?coa=<?php echo $coa; ?>&dari=<?php echo $tgl1; ?>&sampai=<?php echo $tgl2; ?>" class="btn btn-primary"><i class="fa fa-print"></i> Print</a> -->
                    </div>
                  </div>

                  <hr>
                  <?php if (!empty($TampilData)) { ?>
                    <table class="table table-bordered" id="tabel">
                      <thead>
                        <tr>
                          <th>Trans Date</th>
                          <th>Reff Number</th>
                          <th>Vendor</th>
                          <th>No. Invoice</th>
                          <th>Total AP</th>
                          <th>Total Payment</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php $supplier = '';
                        foreach ($TampilData as $r) {
                          echo '<tr>';
                          if ($supplier != $r->suppliercompany) {
                            echo '<td>' . date('d-m-Y', strtotime($r->trans_date)) . '</td>';
                            echo '<td>' . $r->no_facture . '</td>';
                            echo '<td>' . $r->suppliercompany . '</td>';
                          } else {
                            echo '<td colspan="3"></td>';
                          }
                          echo '<td>' . $r->NoInvoice . '</td>';
                          echo '<td align="right">' . number_format($r->hutang, 2, ".", ",") . '</td>';
                          echo '<td align="right">' . number_format($r->total_pay, 2, ".", ",") . '</td>';
                          echo '</tr>';
                          $supplier = $r->suppliercompany;
                        } ?>
                      </tbody>
                    </table>
                  <?php } ?>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>