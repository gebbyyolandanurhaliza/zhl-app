<?php
$period = $this->session->userdata('periode_1');
$tgl1 = $period . "/01";
// echo $tgl;
$tgl2 = date_create($tgl1);
if ($this->input->get('dari') <> '') {
  $dari = $this->input->get('dari');
  $ke = $this->input->get('sampai');
  $gst = $this->input->get('client');
} else {
  $dari = date_format($tgl2, 't-m-Y');
  $ke = date('t-m-Y', strtotime($tgl1));
  $gst = '';
}
?>

<style>
  section {
    position: relative;
    border: 1px solid #000;
    padding-top: 37px;

  }

  section.positioned {
    position: absolute;
    top: 100px;
    left: 100px;
    width: 800px;
    box-shadow: 0 0 15px #333;
  }

  .container1 {
    overflow-y: auto;
    height: 200px;
  }

  table {
    border-spacing: 0;
    width: 100%;
  }

  td+td {
    border-left: 1px solid #eee;
  }

  td,
  th {
    border-bottom: 1px solid #eee;

    padding: 10px 25px;
  }

  th {
    height: 0;
    line-height: 0;
    padding-top: 0;
    padding-bottom: 0;

    border: none;
    white-space: nowrap;
  }

  th div {
    position: absolute;
    background: transparent;

    padding: 9px 25px;
    top: 0;
    margin-left: -25px;
    line-height: normal;
    border-left: 1px solid #800;
  }

  th:first-child div {
    border: none;
  }
</style>
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
                <div class="form-body ">
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
                      <label class="control-label col-md-3">TAX TYPE</label>
                      <div class="col-md-9">
                        <select name="client" class="form-control" required>
                          <option value=""> Select Client </option>
                          <option value="HUT" <?php if ($gst == "HUT") {
                                                echo 'selected';
                                              } ?>>INPUT</option>
                          <option value="PIU" <?php if ($gst == "PIU") {
                                                echo 'selected';
                                              } ?>>OUTPUT</option>
                        </select>
                      </div>
                    </div>
                    <div class="form-group col-md-12">
                      <button type="submit" class="btn purple kiri"><i class="fa fa-refresh"></i> Refresh</button>
                      <a href="<?php echo base_url(); ?>Gst_report\toExcelGst_report?dari=<?php echo $this->input->get('dari'); ?>&sampai=<?php echo $this->input->get('sampai'); ?>&client=<?php echo $this->input->get('client'); ?>" class="btn green"><i class="fa fa-file-excel-o"></i> Excel</a>
                      <a href="<?php echo base_url(); ?>Gst_report/print_report?dari=<?php echo $this->input->get('dari'); ?>&sampai=<?php echo $this->input->get('sampai'); ?>&client=<?php echo $this->input->get('client'); ?>" class="btn btn-primary"><i class="fa fa-print"></i> Print</a>
                    </div>
                  </div>

                  <hr>
                  <?php
                  if (!empty($_tampil)) {
                  ?>
                    <table class="table table-bordered">
                      <thead>
                        <tr class="header">
                          <th width="2%" rowspan="2">
                            No
                          </th>
                          <th width="5%" rowspan="2">
                            Date
                          </th>
                          <th width="10%" rowspan="2">
                            Invoice No
                          </th>
                          <th width="20%" rowspan="2">
                            Account / Customer / Vendor Name
                          </th>
                          <th width="20%" rowspan="2">
                            Description
                          </th>
                          <th width="3%" rowspan="2">
                            Doc Cur
                          </th>
                          <th width="20%" colspan="3">
                            Foreign Currency
                          </th>
                          <th width="20%" colspan="3">
                            Local Currency (USD)
                          </th>

                        </tr>
                        <tr class="header">
                          <th width="5%">
                            Sub Total
                          </th>
                          <th width="5%">
                            GST
                          </th>
                          <th width="3%">
                            Total Amount
                          </th>
                          <th width="5%">
                            Sub Total
                          </th>
                          <th width="5%">
                            GST
                          </th>
                          <th width="3%">
                            Total Amount
                          </th>



                        </tr>
                      </thead>
                      <tbody><?php
                              echo "<tr>";
                              echo "<td colspan='13' style='text-align:left;font-weight:bold;background-color:#fff;'>Exempted 0%</td>";
                              echo "</tr>";

                              $no = 1;
                              $no2 = 1;
                              $no3 = 1;
                              $no4 = 1;

                              $subtotalexpusd = 0;
                              $subtotalgstexpusd = 0;
                              $subtotalusd = 0;
                              $subtotalexpsgd = 0;
                              $subtotalgstexpsgd = 0;
                              $subtotalsgd = 0;

                              $subtotalgstusd = 0;
                              $subtotalgstgstusd = 0;
                              $subtotal2usd = 0;
                              $subtotalgstsgd = 0;
                              $subtotalgstgstsgd = 0;
                              $subtotal2sgd = 0;

                              $subtotaloutusd = 0;
                              $subtotalgstoutusd = 0;
                              $subtotal3usd = 0;
                              $subtotaloutsgd = 0;
                              $subtotalgstoutsgd = 0;
                              $subtotal3sgd = 0;

                              $subtotalzerusd = 0;
                              $subtotalgstzerusd = 0;
                              $subtotal4usd = 0;
                              $subtotalzersgd = 0;
                              $subtotalgstzersgd = 0;
                              $subtotal4sgd = 0;

                              $rate_sgd = 0;

                              foreach ($gstt as $value) {
                                if ($value->t_gst == 'EXP') {
                                  if ($value->t_currency == 'USD') {

                                    $subtotalexp = ($value->t_qty * $value->t_price) * $value->t_rate;
                                    $gstexp = $value->t_gst_value;
                                    $total1 = $subtotalexp + $gstexp;
                                    $subtotalexpusd += $subtotalexp;
                                    $subtotalgstexpusd += $gstexp;
                                    $subtotalusd += $total1;

                                    $rate_sgd = $value->t_rate_sgd;
                                    $subtotalgstexpsgd += round($gstexp * $value->t_rate_sgd, 2);
                                  } else {
                                    if ($value->t_jenis_trans == 'BO' || $value->t_jenis_trans == 'BI' || $value->t_jenis_trans == 'CO' || $value->t_jenis_trans == 'CI' || $value->t_jenis_trans == 'PIJF' || $value->t_jenis_trans == 'AP') {
                                      $subtotalexp = ($value->t_qty * $value->t_price) * $value->t_rate_sgd;
                                    } else {
                                      $subtotalexp = ($value->t_qty * $value->t_price) * $value->t_rate_sgd;
                                    }
                                    $gstexp = $value->t_gst_value;
                                    $total1 = $subtotalexp + $gstexp;
                                    $subtotalexpsgd += $subtotalexp;
                                    $subtotalgstexpsgd += $gstexp;
                                    $subtotalsgd += $total1;
                                  }


                              ?>
                            <tr>
                              <td style="text-align:center;"><?php echo $no; ?></td>
                              <td style="text-align:center;"><?php echo date('d-m-Y', strtotime($value->t_tanggal)); ?></td>
                              <td style="text-align:center;"><?php echo $value->t_ref_nomor; ?></td>
                              <td><?php echo $value->t_customer_name; ?></td>
                              <td><?php echo $value->t_desc; ?></td>
                              <td style="text-align:right;"><?php echo $value->t_currency; ?></td>
                              <?php
                                  if ($value->t_currency == 'USD') { ?>

                                <td style="text-align:right;"><?php ?></td>
                                <td style="text-align:right;"> <?php echo number_format($gstexp * $rate_sgd, 2, ',', '.'); ?></td>
                                <td style="text-align:right;"><?php ?></td>
                                <td style="text-align:right;"><?php echo number_format($subtotalexp, 2, ',', '.');  ?></td>
                                <td style="text-align:right;"> <?php echo number_format($gstexp, 2, ',', '.'); ?></td>
                                <td style="text-align:right;"><?php echo number_format($total1, 2, ',', '.'); ?></td>

                              <?php } else { ?>
                                <td style="text-align:right;"><?php echo number_format($subtotalexp, 2, ',', '.'); ?></td>
                                <td style="text-align:right;"> <?php echo number_format($gstexp, 2, ',', '.'); ?></td>
                                <td style="text-align:right;"><?php echo number_format($total1, 2, ',', '.'); ?></td>
                                <td style="text-align:right;"><?php ?></td>
                                <td style="text-align:right;"> <?php ?></td>
                                <td style="text-align:right;"><?php ?></td>


                              <?php } ?>

                            </tr>
                          <?php
                                  $no++;
                                }
                              }
                              $nsubtotalexpsgd = number_format($subtotalexpsgd, 2, ',', '.');
                              $nsubtotalgstexpsgd = number_format($subtotalgstexpsgd, 2, ',', '.');
                              $nsubtotalsgd = number_format($subtotalsgd, 2, ',', '.');
                              $nsubtotalexpusd = number_format($subtotalexpusd, 2, ',', '.');
                              $nsubtotalgstexpusd = number_format($subtotalgstexpusd, 2, ',', '.');
                              $nsubtotalusd = number_format($subtotalusd, 2, ',', '.');
                              echo "<tr>";
                              echo "<td colspan='6' style='text-align:center;font-weight:bold;background-color:#fff;'>Sub Total for Exemted 0%</td>";
                              echo "<td colspan='1' style='text-align:left;font-weight:bold;background-color:#fff;'>$nsubtotalexpsgd </td>";
                              echo "<td colspan='1' style='text-align:left;font-weight:bold;background-color:#fff;'>$nsubtotalgstexpsgd</td>";
                              echo "<td colspan='1' style='text-align:left;font-weight:bold;background-color:#fff;'>$nsubtotalsgd</td>";
                              echo "<td colspan='1' style='text-align:left;font-weight:bold;background-color:#fff;'>$nsubtotalexpusd</td>";
                              echo "<td colspan='1' style='text-align:left;font-weight:bold;background-color:#fff;'>$nsubtotalgstexpusd</td>";
                              echo "<td colspan='1' style='text-align:left;font-weight:bold;background-color:#fff;'>$nsubtotalusd</td>";

                              echo "</tr>";

                              echo "<tr>";
                              echo "<td colspan='13' style='text-align:left;font-weight:bold;background-color:#fff;'>GST @ 7%</td>";
                              echo "</tr>";

                              foreach ($gstt as $value) {

                                if ($value->t_gst == 'GST') {
                                  if ($value->t_currency == 'USD') {
                                    $subtotalgst = ($value->t_qty * $value->t_price) * $value->t_rate;
                                    $gstgst = $value->t_gst_value;
                                    $total2 = $subtotalgst + $gstgst;
                                    $subtotalgstusd += $subtotalgst;
                                    $subtotalgstgstusd += $gstgst;
                                    $subtotal2usd += $total2;

                                    $rate_sgd = $value->t_rate_sgd;
                                    $subtotalgstgstsgd += round($gstgst * $value->t_rate_sgd, 2);
                                  } else {
                                    if ($value->t_jenis_trans == 'BO' || $value->t_jenis_trans == 'BI' || $value->t_jenis_trans == 'CO' || $value->t_jenis_trans == 'CI' || $value->t_jenis_trans == 'PIJF' || $value->t_jenis_trans == 'AP') {
                                      $subtotalgst = ($value->t_qty * $value->t_price) * $value->t_rate_sgd;
                                    } else {
                                      $subtotalgst = ($value->t_qty * $value->t_price) * $value->t_rate_sgd;
                                    }
                                    $gstgst = $value->t_gst_value;
                                    $total2 = $subtotalgst + $gstgst;
                                    $subtotalgstsgd += $subtotalgst;
                                    $subtotalgstgstsgd += $gstgst;
                                    $subtotal2sgd += $total2;
                                  }
                          ?>
                            <tr>
                              <td style="text-align:center;"><?php echo $no2; ?></td>
                              <td style="text-align:center;"><?php echo date('d-m-Y', strtotime($value->t_tanggal)); ?></td>
                              <td style="text-align:center;"><?php echo $value->t_ref_nomor; ?></td>
                              <td><?php echo $value->t_customer_name; ?></td>
                              <td><?php echo $value->t_desc; ?></td>
                              <td style="text-align:right;"><?php echo $value->t_currency; ?></td>
                              <?php
                                  if ($value->t_currency == 'USD') { ?>

                                <td style="text-align:right;"><?php ?></td>
                                <td style="text-align:right;"> <?php echo number_format($gstgst * $rate_sgd, 2, ',', '.'); ?></td>
                                <td style="text-align:right;"><?php ?></td>
                                <td style="text-align:right;"><?php echo number_format($subtotalgst, 2, ',', '.'); ?></td>
                                <td style="text-align:right;"> <?php echo number_format($gstgst, 2, ',', '.'); ?></td>
                                <td style="text-align:right;"><?php echo number_format($total2, 2, ',', '.'); ?></td>

                              <?php } else { ?>


                                <td style="text-align:right;"><?php echo number_format($subtotalgst, 2, ',', '.'); ?></td>
                                <td style="text-align:right;"> <?php echo number_format($gstgst, 2, ',', '.'); ?></td>
                                <td style="text-align:right;"><?php echo number_format($total2, 2, ',', '.'); ?></td>
                                <td style="text-align:right;"><?php ?></td>
                                <td style="text-align:right;"> <?php ?></td>
                                <td style="text-align:right;"><?php ?></td>


                              <?php } ?>

                            </tr>
                          <?php
                                  $no2++;
                                }
                              }
                              $nsubtotalgstsgd = number_format($subtotalgstsgd, 2, ',', '.');
                              $nsubtotalgstgstsgd = number_format($subtotalgstgstsgd, 2, ',', '.');
                              $nsubtotal2sgd = number_format($subtotal2sgd, 2, ',', '.');
                              $nsubtotalgstusd = number_format($subtotalgstusd, 2, ',', '.');
                              $nsubtotalgstgstusd = number_format($subtotalgstgstusd, 2, ',', '.');
                              $nsubtotal2usd = number_format($subtotal2usd, 2, ',', '.');
                              echo "<tr>";
                              echo "<td colspan='6' style='text-align:center;font-weight:bold;background-color:#fff;'>Sub Total for GST 7%</td>";
                              echo "<td colspan='1' style='text-align:left;font-weight:bold;background-color:#fff;'>$nsubtotalgstsgd </td>";
                              echo "<td colspan='1' style='text-align:left;font-weight:bold;background-color:#fff;'>$nsubtotalgstgstsgd</td>";
                              echo "<td colspan='1' style='text-align:left;font-weight:bold;background-color:#fff;'>$nsubtotal2sgd</td>";
                              echo "<td colspan='1' style='text-align:left;font-weight:bold;background-color:#fff;'>$nsubtotalgstusd</td>";
                              echo "<td colspan='1' style='text-align:left;font-weight:bold;background-color:#fff;'>$nsubtotalgstgstusd</td>";
                              echo "<td colspan='1' style='text-align:left;font-weight:bold;background-color:#fff;'>$nsubtotal2usd</td>";

                              echo "</tr>";


                              echo "<tr>";
                              echo "<td colspan='13' style='text-align:left;font-weight:bold;background-color:#fff;'>Out Of Scope 0%</td>";
                              echo "</tr>";

                              foreach ($gstt as $value) {

                                if ($value->t_gst == 'OUT') {
                                  if ($value->t_currency == 'USD') {
                                    $subtotalout = ($value->t_qty * $value->t_price) * $value->t_rate;
                                    $gstout = $value->t_gst_value;
                                    $total3 = $subtotalout + $gstout;
                                    $subtotaloutusd += $subtotalout;
                                    $subtotalgstoutusd += $gstout;
                                    $subtotal3usd += $total3;

                                    $rate_sgd = $value->t_rate_sgd;
                                    $subtotalgstoutsgd += round($gstout * $value->t_rate_sgd, 2);
                                  } else {
                                    if ($value->t_jenis_trans == 'BO' || $value->t_jenis_trans == 'BI' || $value->t_jenis_trans == 'CO' || $value->t_jenis_trans == 'CI' || $value->t_jenis_trans == 'PIJF' || $value->t_jenis_trans == 'AP') {
                                      $subtotalout = ($value->t_qty * $value->t_price) * $value->t_rate_sgd;
                                    } else {
                                      $subtotalout = ($value->t_qty * $value->t_price) * $value->t_rate_sgd;
                                    }

                                    $gstout = $value->t_gst_value;
                                    $total3 = $subtotalout + $gstout;
                                    $subtotaloutsgd += $subtotalout;
                                    $subtotalgstoutsgd += $gstout;
                                    $subtotal3sgd += $total3;
                                  }
                          ?>
                            <tr>
                              <td style="text-align:center;"><?php echo $no3; ?></td>
                              <td style="text-align:center;"><?php echo date('d-m-Y', strtotime($value->t_tanggal)); ?></td>
                              <td style="text-align:center;"><?php echo $value->t_ref_nomor; ?></td>
                              <td><?php echo $value->t_customer_name; ?></td>
                              <td><?php echo $value->t_desc; ?></td>
                              <td style="text-align:right;"><?php echo $value->t_currency; ?></td>
                              <?php
                                  if ($value->t_currency == 'USD') { ?>

                                <td style="text-align:right;"><?php ?></td>
                                <td style="text-align:right;"> <?php echo number_format($gstout * $rate_sgd, 2, ',', '.'); ?></td>
                                <td style="text-align:right;"><?php ?></td>
                                <td style="text-align:right;"><?php echo number_format($subtotalout, 2, ',', '.'); ?></td>
                                <td style="text-align:right;"> <?php echo number_format($gstout, 2, ',', '.'); ?></td>
                                <td style="text-align:right;"><?php echo number_format($total3, 2, ',', '.'); ?></td>


                              <?php } else { ?>


                                <td style="text-align:right;"><?php echo number_format($subtotalout, 2, ',', '.'); ?></td>
                                <td style="text-align:right;"> <?php echo number_format($gstout, 2, ',', '.'); ?></td>
                                <td style="text-align:right;"><?php echo number_format($total3, 2, ',', '.'); ?></td>

                                <td style="text-align:right;"><?php ?></td>
                                <td style="text-align:right;"> <?php ?></td>
                                <td style="text-align:right;"><?php ?></td>


                              <?php } ?>


                            </tr>
                          <?php
                                  $no3++;
                                }
                              }
                              $nsubtotaloutsgd = number_format($subtotaloutsgd, 2, ',', '.');
                              $nsubtotalgstoutsgd = number_format($subtotalgstoutsgd, 2, ',', '.');
                              $nsubtotal3sgd = number_format($subtotal3sgd, 2, ',', '.');
                              $nsubtotaloutusd = number_format($subtotaloutusd, 2, ',', '.');
                              $nsubtotalgstoutusd = number_format($subtotalgstoutusd, 2, ',', '.');
                              $nsubtotal3usd = number_format($subtotal3usd, 2, ',', '.');
                              echo "<tr>";
                              echo "<td colspan='6' style='text-align:center;font-weight:bold;background-color:#fff;'>Sub Total for Out 0%</td>";
                              echo "<td colspan='1' style='text-align:left;font-weight:bold;background-color:#fff;'>$nsubtotaloutsgd </td>";
                              echo "<td colspan='1' style='text-align:left;font-weight:bold;background-color:#fff;'>$nsubtotalgstoutsgd</td>";
                              echo "<td colspan='1' style='text-align:left;font-weight:bold;background-color:#fff;'>$nsubtotal3sgd</td>";
                              echo "<td colspan='1' style='text-align:left;font-weight:bold;background-color:#fff;'>$nsubtotaloutusd</td>";
                              echo "<td colspan='1' style='text-align:left;font-weight:bold;background-color:#fff;'>$nsubtotalgstoutusd</td>";
                              echo "<td colspan='1' style='text-align:left;font-weight:bold;background-color:#fff;'>$nsubtotal3usd</td>";

                              echo "</tr>";


                              echo "<tr>";
                              echo "<td colspan='13' style='text-align:left;font-weight:bold;background-color:#fff;'>Zero Rated 0%</td>";
                              echo "</tr>";

                              foreach ($gstt as $value) {

                                if ($value->t_gst == 'ZER') {
                                  if ($value->t_currency == 'USD') {
                                    $subtotalzer = ($value->t_qty * $value->t_price) * $value->t_rate;
                                    $gstzer = $value->t_gst_value;
                                    $total4 = $subtotalzer + $gstzer;
                                    $subtotalzerusd += $subtotalzer;
                                    $subtotalgstzerusd += $gstzer;
                                    $subtotal4usd += $total4;

                                    $rate_sgd = $value->t_rate_sgd;
                                    $subtotalgstzersgd += round($gstzer * $value->t_rate_sgd, 2);
                                  } else {
                                    if ($value->t_jenis_trans == 'BO' || $value->t_jenis_trans == 'BI' || $value->t_jenis_trans == 'CO' || $value->t_jenis_trans == 'CI' ||  $value->t_jenis_trans == 'PIJF' || $value->t_jenis_trans == 'AP') {
                                      $subtotalzer = ($value->t_qty * $value->t_price) * $value->t_rate_sgd;
                                    } else {
                                      $subtotalzer = ($value->t_qty * $value->t_price) * $value->t_rate_sgd;
                                    }

                                    $gstzer = $value->t_gst_value;
                                    $total4 = $subtotalzer + $gstzer;
                                    $subtotalzersgd += $subtotalzer;
                                    $subtotalgstzersgd += $gstzer;
                                    $subtotal4sgd += $total4;
                                  }
                          ?>
                            <tr>
                              <td style="text-align:center;"><?php echo $no4; ?></td>
                              <td style="text-align:center;"><?php echo date('d-m-Y', strtotime($value->t_tanggal)); ?></td>
                              <td style="text-align:center;"><?php echo $value->t_ref_nomor; ?></td>
                              <td><?php echo $value->t_customer_name; ?></td>
                              <td><?php echo $value->t_desc; ?></td>
                              <td style="text-align:right;"><?php echo $value->t_currency; ?></td>
                              <?php
                                  if ($value->t_currency == 'USD') { ?>

                                <td style="text-align:right;"><?php ?></td>
                                <td style="text-align:right;"> <?php echo number_format($gstzer * $rate_sgd, 2, ',', '.'); ?></td>
                                <td style="text-align:right;"><?php ?></td>
                                <td style="text-align:right;"><?php echo number_format($subtotalzer, 2, ',', '.'); ?></td>
                                <td style="text-align:right;"> <?php echo number_format($gstzer, 2, ',', '.'); ?></td>
                                <td style="text-align:right;"><?php echo number_format($total4, 2, ',', '.'); ?></td>


                              <?php } else { ?>


                                <td style="text-align:right;"><?php echo number_format($subtotalzer, 2, ',', '.'); ?></td>
                                <td style="text-align:right;"> <?php echo number_format($gstzer, 2, ',', '.'); ?></td>
                                <td style="text-align:right;"><?php echo number_format($total4, 2, ',', '.'); ?></td>
                                <td style="text-align:right;"><?php ?></td>
                                <td style="text-align:right;"> <?php ?></td>
                                <td style="text-align:right;"><?php ?></td>


                              <?php } ?>


                            </tr>
                        <?php
                                  $no4++;
                                }
                              }
                              $nsubtotalzersgd = number_format($subtotalzersgd, 2, ',', '.');
                              $nsubtotalgstzersgd = number_format($subtotalgstzersgd, 2, ',', '.');
                              $nsubtotal4sgd = number_format($subtotal4sgd, 2, ',', '.');
                              $nsubtotalzerusd = number_format($subtotalzerusd, 2, ',', '.');
                              $nsubtotalgstzerusd = number_format($subtotalgstzerusd, 2, ',', '.');
                              $nsubtotal4usd = number_format($subtotal4usd, 2, ',', '.');
                              echo "<tr>";
                              echo "<td colspan='6' style='text-align:center;font-weight:bold;background-color:#fff;'>Sub Total for Zero 0%</td>";
                              echo "<td colspan='1' style='text-align:left;font-weight:bold;background-color:#fff;'>$nsubtotalzersgd </td>";
                              echo "<td colspan='1' style='text-align:left;font-weight:bold;background-color:#fff;'>$nsubtotalgstzersgd</td>";
                              echo "<td colspan='1' style='text-align:left;font-weight:bold;background-color:#fff;'>$nsubtotal4sgd</td>";
                              echo "<td colspan='1' style='text-align:left;font-weight:bold;background-color:#fff;'>$nsubtotalzerusd</td>";
                              echo "<td colspan='1' style='text-align:left;font-weight:bold;background-color:#fff;'>$nsubtotalgstzerusd</td>";
                              echo "<td colspan='1' style='text-align:left;font-weight:bold;background-color:#fff;'>$nsubtotal4usd</td>";

                              echo "</tr>";

                              //total tax
                              $alltotalsubtotalsgd = number_format(($subtotalexpsgd + $subtotalgstsgd + $subtotaloutsgd + $subtotalzersgd), 2, ',', '.');
                              $alltotalgstsgd = number_format(($subtotalgstexpsgd + $subtotalgstgstsgd + $subtotalgstoutsgd + $subtotalgstzersgd), 2, ',', '.');
                              $alltotalsgd = number_format(($subtotalsgd + $subtotal2sgd + $subtotal3sgd + $subtotal4sgd), 2, ',', '.');

                              $alltotalsubtotalusd = number_format(($subtotalexpusd + $subtotalgstusd + $subtotaloutusd + $subtotalzerusd), 2, ',', '.');
                              $alltotalgstusd = number_format(($subtotalgstexpusd + $subtotalgstgstusd + $subtotalgstoutusd + $subtotalgstzerusd), 2, ',', '.');
                              $alltotalusd = number_format(($subtotalusd + $subtotal2usd + $subtotal3usd + $subtotal4usd), 2, ',', '.');

                              if ($this->input->get('client') == 'HUT') {
                                echo "<tr>";
                                echo "<td colspan='6' style='text-align:center;font-weight:bold;background-color:#fff;'>Total for input tax</td>";
                                echo "<td colspan='1' style='text-align:left;font-weight:bold;background-color:#fff;'> $alltotalsubtotalsgd </td>";
                                echo "<td colspan='1' style='text-align:left;font-weight:bold;background-color:#fff;'>$alltotalgstsgd</td>";
                                echo "<td colspan='1' style='text-align:left;font-weight:bold;background-color:#fff;'>$alltotalsgd</td>";
                                echo "<td colspan='1' style='text-align:left;font-weight:bold;background-color:#fff;'>$alltotalsubtotalusd</td>";
                                echo "<td colspan='1' style='text-align:left;font-weight:bold;background-color:#fff;'>$alltotalgstusd</td>";
                                echo "<td colspan='1' style='text-align:left;font-weight:bold;background-color:#fff;'>$alltotalusd</td>";
                                echo "</tr>";
                              } else {
                                echo "<tr>";
                                echo "<td colspan='6' style='text-align:center;font-weight:bold;background-color:#fff;'>Total for output tax</td>";
                                echo "<td colspan='1' style='text-align:left;font-weight:bold;background-color:#fff;'> $alltotalsubtotalsgd </td>";
                                echo "<td colspan='1' style='text-align:left;font-weight:bold;background-color:#fff;'>$alltotalgstsgd</td>";
                                echo "<td colspan='1' style='text-align:left;font-weight:bold;background-color:#fff;'>$alltotalsgd</td>";
                                echo "<td colspan='1' style='text-align:left;font-weight:bold;background-color:#fff;'>$alltotalsubtotalusd</td>";
                                echo "<td colspan='1' style='text-align:left;font-weight:bold;background-color:#fff;'>$alltotalgstusd</td>";
                                echo "<td colspan='1' style='text-align:left;font-weight:bold;background-color:#fff;'>$alltotalusd</td>";
                                echo "</tr>";
                              }




                              echo "</tr>";


                        ?>


                      </tbody>
                      <tfoot>
                        <!-- <tr>
                                                    <td colspan="7" style="text-align:right;">Subtotal </td>
                                                    <td style="text-align:right;"><b><?php /*echo number_format($subtotlfc, 2, '.', ','); */ ?></b></td>
                                                    <td style="text-align:right;"><b><?php /*echo number_format($subtotllc, 2, '.', ','); */ ?></b></td>
                                                    <td style="text-align:right;"></td>
                                                </tr>-->
                      </tfoot>

                    </table>
                  <?php
                  }
                  ?>
                </div>
              </div>
          </div>


          </form>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
<script>
  var oTable = $('#tbl-monitoring-regis-book').dataTable({
    "pageLength": 20,
    "lengthMenu": [10, 20, 50, 100],
    "sScrollY": "300px",
    "sScrollX": "100%",
    "sScrollXInner": "150%",
    "bScrollCollapse": true,
    "bPaginate": true,
    "bFilter": true
  });

  new FixedColumns(oTable, {
    "sHeightMatch": "none"
  });
</script>