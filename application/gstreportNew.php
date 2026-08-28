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
  $dari = date_format($tgl2, 'Y-m-d');
  $ke = date('Y-m-d', strtotime($tgl1));
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
                          <option value="">-Select Client</option>
                          <option value="HUT">INPUT</option>
                          <option value="PIU">OUTPUT</option>
                        </select>
                      </div>
                    </div>
                    <div class="form-group col-md-12">
                      <button type="submit" class="btn purple kiri"><i class="fa fa-refresh"></i> Refresh</button>
                      <a href="<?php echo base_url(); ?>Excel\toExcelGSTLedger?dari=<?php echo $this->input->get('dari'); ?>&sampai=<?php echo $this->input->get('sampai'); ?>" class="btn green"><i class="fa fa-file-excel-o"></i> Excel</a>
                      <a href="<?php echo base_url(); ?>Gst_report/print_report?dari=<?php echo $this->input->get('dari'); ?>&sampai=<?php echo $this->input->get('sampai'); ?>&client=<?php echo $this->input->get('client'); ?>" class="btn btn-primary"><i class="fa fa-print"></i> Print</a>
                    </div>
                  </div>

                  <hr>
                  <?php
                  if (!empty($_tampil)) {
                  ?>
                    <section class="">
                      <div class="container1">


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
                              <th width="10%" rowspan="2">
                                PO No
                              </th>
                              <th width="20%" rowspan="2">
                                Account / Customer / Vendor Name
                              </th>
                              <th width="10%" rowspan="2">
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
                                  foreach ($gstt as $value) {

                                    if ($value->t_gst == 'EXP') {

                                  ?>
                                <tr>
                                  <td style="text-align:center;"><?php echo $no; ?></td>
                                  <td style="text-align:center;"><?php echo $value->t_tanggal; ?></td>
                                  <td style="text-align:center;"><?php echo $value->t_ref_nomor; ?></td>
                                  <td style="text-align:center;"><?php ?></td>
                                  <td><?php echo $value->t_customer_name; ?></td>
                                  <td><?php ?></td>
                                  <td style="text-align:right;"><?php echo $value->t_currency; ?></td>
                                  <td style="text-align:right;"><?php ?></td>
                                  <td style="text-align:right;"> <?php ?></td>
                                  <td style="text-align:right;"><?php ?></td>
                                  <td style="text-align:right;"><?php ?></td>
                                  <td style="text-align:right;"> <?php ?></td>
                                  <td style="text-align:right;"><?php ?></td>

                                </tr>
                              <?php
                                      $no++;
                                    }
                                  }

                                  echo "<tr>";
                                  echo "<td colspan='13' style='text-align:left;font-weight:bold;background-color:#fff;'>GST @ 7%</td>";
                                  echo "</tr>";

                                  foreach ($gstt as $value) {

                                    if ($value->t_gst == 'GST') {

                              ?>
                                <tr>
                                  <td style="text-align:center;"><?php echo $no2; ?></td>
                                  <td style="text-align:center;"><?php echo $value->t_tanggal; ?></td>
                                  <td style="text-align:center;"><?php echo $value->t_ref_nomor; ?></td>
                                  <td style="text-align:center;"><?php ?></td>
                                  <td><?php echo $value->t_customer_name; ?></td>
                                  <td><?php ?></td>
                                  <td style="text-align:right;"><?php echo $value->t_currency; ?></td>
                                  <td style="text-align:right;"><?php ?></td>
                                  <td style="text-align:right;"> <?php ?></td>
                                  <td style="text-align:right;"><?php ?></td>
                                  <td style="text-align:right;"><?php ?></td>
                                  <td style="text-align:right;"> <?php ?></td>
                                  <td style="text-align:right;"><?php ?></td>

                                </tr>
                              <?php
                                      $no2++;
                                    }
                                  }


                                  echo "<tr>";
                                  echo "<td colspan='13' style='text-align:left;font-weight:bold;background-color:#fff;'>Out Of Scope 0%</td>";
                                  echo "</tr>";

                                  foreach ($gstt as $value) {

                                    if ($value->t_gst == 'OUT') {

                              ?>
                                <tr>
                                  <td style="text-align:center;"><?php echo $no3; ?></td>
                                  <td style="text-align:center;"><?php echo $value->t_tanggal; ?></td>
                                  <td style="text-align:center;"><?php echo $value->t_ref_nomor; ?></td>
                                  <td style="text-align:center;"><?php ?></td>
                                  <td><?php echo $value->t_customer_name; ?></td>
                                  <td><?php ?></td>
                                  <td style="text-align:right;"><?php echo $value->t_currency; ?></td>
                                  <td style="text-align:right;"><?php ?></td>
                                  <td style="text-align:right;"> <?php ?></td>
                                  <td style="text-align:right;"><?php ?></td>
                                  <td style="text-align:right;"><?php ?></td>
                                  <td style="text-align:right;"> <?php ?></td>
                                  <td style="text-align:right;"><?php ?></td>

                                </tr>
                              <?php
                                      $no3++;
                                    }
                                  }

                                  echo "<tr>";
                                  echo "<td colspan='13' style='text-align:left;font-weight:bold;background-color:#fff;'>Zero Rated 0%</td>";
                                  echo "</tr>";

                                  foreach ($gstt as $value) {

                                    if ($value->t_gst == 'ZER') {

                              ?>
                                <tr>
                                  <td style="text-align:center;"><?php echo $no4; ?></td>
                                  <td style="text-align:center;"><?php echo $value->t_tanggal; ?></td>
                                  <td style="text-align:center;"><?php echo $value->t_ref_nomor; ?></td>
                                  <td style="text-align:center;"><?php ?></td>
                                  <td><?php echo $value->t_customer_name; ?></td>
                                  <td><?php ?></td>
                                  <td style="text-align:right;"><?php echo $value->t_currency; ?></td>
                                  <td style="text-align:right;"><?php ?></td>
                                  <td style="text-align:right;"> <?php ?></td>
                                  <td style="text-align:right;"><?php ?></td>
                                  <td style="text-align:right;"><?php ?></td>
                                  <td style="text-align:right;"> <?php ?></td>
                                  <td style="text-align:right;"><?php ?></td>

                                </tr>
                            <?php
                                      $no4++;
                                    }
                                  }


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
                    </section>
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