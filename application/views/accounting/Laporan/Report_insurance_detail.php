<?php

/**
 * Created by PhpStorm.
 * User: Reza Irhami
 * Date: 11/11/2016
 * Time: 10:48 AM
 */
$period = $this->session->userdata('periode_1');
$tgl1 = $period . "/01";
// echo $tgl;


if ($this->input->get("dari") <> '') {
  $dari = $this->input->get("dari");
  $sampai = $this->input->get("sampai");
  $id = $this->input->get("id");
} else {
  $tgl2 = date_create($tgl1);
  $dari = date_format($tgl2, 't-m-Y');
  $sampai = date('t-m-Y', strtotime($dari));
  $id = "";
}

?>

<div class="page-head">
  <div class="container-fluid">
    <!-- BEGIN PAGE TITLE -->
    <div class="page-title">
      <h1>Accounting Report <small>Insurance</small></h1>
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
              <span class="caption-subject theme-font">Sales Report Of Insurance Detail</span>
            </div>
            <div class="tools">
              <a href="javascript:;" class="collapse"></a>
              <a href="javascript:;" class="reload"></a>
            </div>
          </div>

          <div class="portlet-body">
            <form action="<?php echo base_url(); ?>Report_insurance/detail_transaction" method="get">
              <div class="portlet-body">
                <div class="form-body">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="col-md-6">
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
                      <div class="col-md-6">
                        <label class="control-label col-md-4">Product Category</label>
                        <div class="col-md-7">
                          <?php
                          $style_category = 'class="select2me form-control" id="id" ';
                          echo form_dropdown('id', $category, $id, $style_category);
                          ?>
                        </div>
                      </div>
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-md-12 kanan">
                      <button type="submit" class="btn purple kiri"><i class="fa fa-refresh"></i> Filter</button>
                      <a href="<?php echo base_url(); ?>Report_insurance/toExcelSalesReportOFInsurance_detail?id=<?php echo $this->input->get('id'); ?>&dari=<?php echo $this->input->get('dari'); ?>&sampai=<?php echo $this->input->get('sampai'); ?>" class="btn green"><i class="fa fa-file-excel-o"></i> Excel</a>

                      <a href="<?php echo base_url(); ?>Report_insurance/toPrintSalesReportOFInsurance_detail?id=<?php echo $this->input->get('id'); ?>&dari=<?php echo $this->input->get('dari'); ?>&sampai=<?php echo $this->input->get('sampai'); ?>" class="btn btn-primary"><i class="fa fa-print"></i> Print</a>


                    </div>
                  </div>
                  <hr>
                  <?php
                  if (!empty($_tampil_item)) {
                  ?>
                    <table class="table table-bordered">
                      <thead>
                        <tr>
                          <th width="10%">No. INVOICE</th>
                          <th width="20%">PRODUCT</th>
                          <th>USA AND AUSTRALIA CWP 1</th>
                          <th>USA AND AUSTRALIA CWP 2</th>
                          <th>REST OF THE WORLD CWP 1</th>
                          <th>REST OF THE WORLD CWP 2</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        $amountcwp1 = 0;
                        $amountcwp2 = 0;
                        $amountothercwp1 = 0;
                        $amountothercwp2 = 0;

                        foreach ($_tampil_item as $value) {
                          $amountcwp1 += $value->tmp_total_cwp1_USA_AUS;
                          $amountcwp2 += $value->tmp_total_cwp2_USA_AUS;
                          $amountothercwp1 += $value->tmp_total_cwp1_OTHER;
                          $amountothercwp2 += $value->tmp_total_cwp2_OTHER;
                        ?>
                          <tr>
                            <td><?php echo $value->tmp_invoice; ?></td>
                            <td><?php echo $value->tmp_product_category; ?></td>
                            <td align='right'><?php echo number_format(($value->tmp_total_cwp1_USA_AUS), 2, ".", ","); ?></td>
                            <td align='right'><?php echo number_format(($value->tmp_total_cwp2_USA_AUS), 2, ".", ","); ?></td>
                            <td align='right'><?php echo number_format(($value->tmp_total_cwp1_OTHER), 2, ".", ","); ?></td>
                            <td align='right'><?php echo number_format(($value->tmp_total_cwp2_OTHER), 2, ".", ","); ?></td>
                            <td style="display: none"><?php echo $value->tmp_product_category_id; ?></td>
                          </tr>
                        <?php
                        }
                        ?>

                      </tbody>

                      <tfoot>
                        <tr style="font-weight: bold;">
                          <td colspan="2" style="text-align: right;">Total</td>
                          <td style="text-align: right"><?php echo number_format($amountcwp1, 2, ",", "."); ?></td>
                          <td style="text-align: right"><?php echo number_format($amountcwp2, 2, ",", "."); ?></td>
                          <td style="text-align: right"><?php echo number_format($amountothercwp1, 2, ",", "."); ?></td>
                          <td style="text-align: right"><?php echo number_format($amountothercwp2, 2, ",", "."); ?></td>
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