<?php

/**
 * Created by PhpStorm.
 * User: Reza Irhami
 * Date: 1/17/2017
 * Time: 1:37 PM
 */

$period = $this->session->userdata('periode_1');
$tgl1 = $period . "/01";
// echo $tgl;


if ($this->input->get("dari") <> '') {
  $dari = $this->input->get("dari");
  $sampai = $this->input->get("sampai");
  $person = $this->input->get("sales_person");
} else {
  $tgl2 = date_create($tgl1);
  $dari = date_format($tgl2, '01-m-Y');
  $sampai = date('t-m-Y', strtotime($dari));
  $person = "";
}

?>


<div class="page-head">
  <div class="container-fluid">
    <!-- BEGIN PAGE TITLE -->
    <div class="page-title">
      <h1>Accounting Report <small>Sales Value / Volume Report</small></h1>
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
              <span class="caption-subject theme-font">Sales Value / Volume Report</span>
            </div>
            <div class="tools">
              <a href="javascript:;" class="collapse"></a>
              <a href="javascript:;" class="reload"></a>
            </div>
          </div>

          <div class="portlet-body">
            <form action="<?php echo base_url(); ?>Sales_volume/search" method="get">
              <div class="portlet-body">
                <div class="form-body">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="col-md-4">
                        <label class="control-label col-md-3">Period</label>
                        <div class="col-md-9">
                          <div class="input-group date-picker input-daterange" data-date-format="dd-mm-yyyy">
                            <input type="text" class="form-control input-sm" id="from" name="dari" value="<?php echo $dari ?>" required>
                            <span class="input-group-addon">
                              to </span>
                            <input type="text" class="form-control input-sm" id="to" name="sampai" value="<?php echo $sampai ?>" required>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <label class="control-label col-md-3">Sales Person Name</label>
                        <div class="col-md-9">

                          <?php
                          $style_coa = 'class="select2me form-control" id="sales_person" ';
                          echo form_dropdown('sales_person', $sales_person, $person, $style_coa);
                          ?>

                        </div>
                      </div>

                      <div class="col-md-4">
                        <button type="submit" class="btn purple col-md-3"><i class="fa fa-refresh"></i> Filter</button>
                        <a href="<?php echo base_url(); ?>Excel/toExcelSalesVolume?from=<?php echo $this->input->get('dari'); ?>&to=<?php echo $this->input->get('sampai'); ?>" target='_blank' class="btn green"><i class="fa fa-file-excel-o"></i> Print Excel</a>
                        <a href="<?php echo base_url(); ?>Sales_volume/print_report?from=<?php echo $this->input->get('dari'); ?>&to=<?php echo $this->input->get('sampai'); ?>" target='_blank' class="btn btn-primary"><i class="fa fa-print"></i> Print PDF</a>
                      </div>
                    </div>
                  </div>
                  <hr>
                  <?php
                  if (!empty($_tampil_sales)) {
                  ?>
                    <section class="">
                      <div class="">

                        <table class="table table-bordered" id="tabel_sv">
                          <thead>
                            <tr class="header">
                              <th width="10%">
                                Customer Account
                      </div>
                      </th>
                      <th width="15%">
                        Invoice Number
                </div>
                </th>
                <th width="18%">
                  Item Name
              </div>
              </th>
              <th width="15%">
                Quantity (KG/MT)
          </div>
          </th>
          <th width="15%">
            Price per Unit
        </div>
        </th>
        <th width="15%">
          Sales Amount (USD)
      </div>
      </th>
      <th width="15%">
        Sales Person
    </div>
    </th>


    </tr>
    </thead>
    <tbody>
      <?php
                    foreach ($customer_list as $row_customer) {
                      echo "
															<tr>
																<td colspan='7' nowrap='' style='text-align:left;font-weight:bold;background-color:#ddd;'>
																	$row_customer->custcompany
																</td>
															</tr>";
                      $invno = 0;
                      $productname = 0;
                      $qty = 0;
                      $unitprice = 0;
                      $total = 0;
                      $sales_id = 0;
                      foreach ($_tampil_sales as $row_tampilsales) {
                        if ($row_customer->custid == $row_tampilsales->custid) {
                          $invno += $row_tampilsales->invno;
                          $productname += $row_tampilsales->productname;
                          $qty += $row_tampilsales->qty;
                          $unitprice += $row_tampilsales->unitprice;
                          $total += $row_tampilsales->total;
                          $sales_id += $row_tampilsales->sales_id;
      ?>
            <!-- <pre><?php print_r($row_customer); ?></pre> -->
            <tr>
              <td></td>
              <td style="text-align: center;"><?php echo $row_tampilsales->invno; ?></td>
              <td style="text-align: left;"><?php echo $row_tampilsales->productname; ?></td>
              <td style="text-align: center;"><?php echo $row_tampilsales->qty; ?></td>
              <td style="text-align: right;"><?php echo $row_tampilsales->unitprice; ?></td>
              <td style="text-align: right;"><?php echo $row_tampilsales->total; ?></td>
              <td style="text-align: center;"><?php echo $row_tampilsales->sales_id; ?></td>
            </tr>
      <?php
                        }
                      }
                      echo "<tr style='background: #ffffcc'><td colspan='4' style='text-align:right;'><b>Grand Total</b></td>"
                        . "<td style='text-align:right;font-weight: bold;'>" . number_format($unitprice, 2, '.', ',') . "</td>"
                        . "<td style='text-align:right;font-weight: bold;'>" . number_format($total, 2, '.', ',') . "</td>"
                        . "<td style='text-align:right;font-weight: bold;'>" . "</td></tr>";
                    } ?>
    </tbody>
    </table>
  </div>
  </section>
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