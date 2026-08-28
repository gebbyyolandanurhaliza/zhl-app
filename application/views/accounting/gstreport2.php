<?php
$period = $this->session->userdata('periode_1');
$tgl1 = $period . "/01";
// echo $tgl;
$tgl2 = date_create($tgl1);
if ($this->input->get('dari') <> '') {
  $dari = $this->input->get('dari');
  $ke = $this->input->get('sampai');
  $gst = $this->input->get('gst');
} else {
  $dari = date_format($tgl2, 'd-m-Y');
  $ke = date('t-m-Y', strtotime($tgl1));
  $gst = '';
}
?>

<div class="page-head">
  <div class="container-fluid">
    <!-- BEGIN PAGE TITLE -->
    <div class="page-title">
      <h1>Accounting Report <small>GST Report</small></h1>
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
              <span class="caption-subject theme-font">Monitoring GST Report</span>
            </div>
            <div class="tools">
              <a href="javascript:;" class="collapse"></a>
              <a href="javascript:;" class="reload"></a>
            </div>
          </div>

          <div class="portlet-body">
            <form action="<?php echo base_url(); ?>Gst_report/search" method="get">
              <div class="portlet-body">
                <div class="form-body">
                  <div class="row">
                    <div class="form-group col-md-6">
                      <label class="control-label col-md-3">Date</label>
                      <div class="col-md-9">
                        <div class="input-group date-picker input-daterange" data-date="02-12-2012" data-date-format="dd-mm-yyyy">
                          <input type="text" class="form-control input-sm" id="from" name="dari" value="<?php echo $dari; ?>" required>
                          <span class="input-group-addon">
                            to </span>
                          <input type="text" class="form-control input-sm" id="to" name="sampai" value="<?php echo $ke; ?>" required>
                        </div>
                      </div>
                    </div>
                    <div class="form-group col-md-6">
                      <label class="control-label col-md-3">Client</label>
                      <div class="col-md-9">
                        <select name="client" class="form-control" required>
                          <option value="">-Select Client</option>
                          <option value="vendor">Vendor</option>
                          <option value="costumer">Costumers</option>
                        </select>
                      </div>
                    </div>
                    <div class="form-group col-md-12">
                      <button type="submit" class="btn purple kiri"><i class="fa fa-refresh"></i> Refresh</button>
                      <a href="<?php echo base_url(); ?>Excel\toExcelGSTLedger?dari=<?php echo $this->input->get('dari'); ?>&sampai=<?php echo $this->input->get('sampai'); ?>" class="btn green"><i class="fa fa-file-excel-o"></i> Excel</a>
                      <button type="button" class="btn btn-primary"><i class="fa fa-print"></i> Print</button>
                    </div>
                  </div>

                  <hr>
                  <?php
                  if (!empty($_tampil)) {
                  ?>

                    <table class="table table-bordered">
                      <thead>
                        <tr>
                          <th width="2%">
                            DOC. No.
                          </th>
                          <th width="10%">
                            Post. Date
                          </th>
                          <th width="10%">
                            Due Date
                          </th>
                          <th width="10%">
                            Details
                          </th>
                          <th width="30%">
                            Account / Customer / Vendor Name
                          </th>
                          <th width="10%">
                            Amount
                          </th>
                          <th width="10%">
                            LC
                          </th>
                          <th width="10%">
                            FC
                          </th>
                          <th width="10%">
                            Total (LC)
                          </th>
                          <th width="10%">
                            Total (FC)
                          </th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        $tgl = $this->input->get('dari');
                        $bln = explode('-', $tgl);
                        if ($bln[1] == 01) {
                          $tbln = 'January';
                        } elseif ($bln[1] == 02) {
                          $tbln = 'February';
                        } elseif ($bln[1] == 03) {
                          $tbln = 'March';
                        } elseif ($bln[1] == 04) {
                          $tbln = 'April';
                        } elseif ($bln[1] == 05) {
                          $tbln = 'May';
                        } elseif ($bln[1] == 06) {
                          $tbln = 'June';
                        } elseif ($bln[1] == 07) {
                          $tbln = 'July';
                        } elseif ($bln[1] == 08) {
                          $tbln = 'August';
                        } elseif ($bln[1] == 09) {
                          $tbln = 'September';
                        } elseif ($bln[1] == 10) {
                          $tbln = 'October';
                        } elseif ($bln[1] == 11) {
                          $tbln = 'November';
                        } elseif ($bln[1] == 12) {
                          $tbln = 'December';
                        }

                        echo "<tr>";
                        echo "<td colspan='10' style='text-align:left;font-weight:bold;background-color:#fff;'>Transaction Details</td>";
                        echo "</tr>";
                        $garis1 = 0;
                        $saldo = 0;
                        $debit2 = 0;
                        $subtotlfc = 0;
                        $subtotllc = 0;
                        foreach ($_tampil as $value) {
                          if ($value->gst_value == 0) {
                            $nlc = '';
                            $nfc = '';
                            $ntlc = '';
                            $ntfc = '';
                          } else {
                            $lc = $value->gst_value;
                            $fc = $value->gst_value * $value->Rate;
                            $saldo += $value->gst_value;
                            $debit2 += $value->gst_value * $value->Rate;

                            $nlc = number_format($lc, 2, ',', '.');
                            $nfc = 'SGD ' . number_format($fc, 2, ',', '.');
                            $ntlc = number_format($saldo, 2, ',', '.');
                            $ntfc = 'SGD ' . number_format($debit2, 2, ',', '.');

                            $subtotlfc += $saldo;
                            $subtotllc += $debit2;
                          }

                          if ($value->Kredit > 0) {
                            $total = $value->Kredit;
                          } else {
                            $total = $value->Debet;
                          }
                        ?>
                          <tr>
                            <td style="text-align:center;"><?php echo $value->DetailID; ?></td>
                            <td style="text-align:center;"><?php echo date_format(date_create($value->Tanggal), "d-m-Y"); ?></td>
                            <td style="text-align:center;"><?php echo date_format(date_create($value->Tanggal), "d-m-Y"); ?></td>
                            <td><?php echo $value->NoJurnal; ?></td>
                            <td><?php echo $value->nama_sup; ?></td>
                            <td style="text-align:right;"><?php echo number_format($total, 2, ',', '.'); ?></td>
                            <td style="text-align:right;"><?php echo $nlc; ?></td>
                            <td style="text-align:right;"> <?php echo $nfc; ?></td>
                            <td style="text-align:right;"><?php echo $ntlc; ?></td>
                            <td style="text-align:right;"><?php echo $ntfc; ?></td>

                          </tr>
                        <?php
                        }
                        ?>
                      </tbody>
                      <tfoot>
                        <tr>
                          <td colspan="7" style="text-align:right;">Subtotal </td>
                          <td style="text-align:right;"><b><?php echo number_format($subtotlfc, 2, '.', ','); ?></b></td>
                          <td style="text-align:right;"><b><?php echo number_format($subtotllc, 2, '.', ','); ?></b></td>
                          <td style="text-align:right;"></td>
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