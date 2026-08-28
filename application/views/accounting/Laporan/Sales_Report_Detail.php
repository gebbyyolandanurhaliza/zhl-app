<?php

$this->load->model(array('M_Sales_Report'));
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
  $customer_name = $this->input->get("customer_name");
} else {
  $tgl2 = date_create($tgl1);
  $dari = date_format($tgl2, '01-m-Y');
  $sampai = date('t-m-Y', strtotime($dari));
  $customer_name = "";
}

?>


<div class="page-head">
  <div class="container-fluid">
    <!-- BEGIN PAGE TITLE -->
    <div class="page-title">
      <h1>Accounting Report <small>Sales Report</small></h1>
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
              <span class="caption-subject theme-font">Sales Report </span>
            </div>
            <div class="tools">
              <a href="javascript:;" class="collapse"></a>
              <a href="javascript:;" class="reload"></a>
            </div>
          </div>

          <div class="portlet-body">
            <form action="<?php echo base_url(); ?>Sales_Report/detail_transaction" method="get">
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
                      <!--                                            <div class="col-md-4">
                                                <label class="control-label col-md-3">Currency</label>
                                                <div class="col-md-9">
                                                    <?php
                                                    //                                                    $style_kategori = 'class="select2me form-control" id="currency" ';
                                                    //                                                    echo form_dropdown('currency', $CurrencyID, $cur, $style_kategori);
                                                    ?>
                                                </div>
                                            </div>-->
                      <div class="col-md-4">
                        <label class="control-label col-md-3">Customer</label>
                        <div class="col-md-9">

                          <?php
                          $style_coa = 'class="select2me form-control" id="customer_name" ';
                          echo form_dropdown('customer_name', $customer, $customer_name, $style_coa);
                          ?>

                        </div>
                      </div>

                      <div class="col-md-4">
                        <button type="submit" class="btn purple col-md-3"><i class="fa fa-refresh"></i> Filter</button>
                        <!--<button type="button" class="btn btn-primary"><i class="fa fa-print"></i> Print</button>-->
                        <!-- <a href="<?php // echo base_url(); 
                                      ?>General_ledger/search_detail?dari=<?php // echo $dari; 
                                                                                                    ?>&sampai=<?php // echo $sampai; 
                                                                                                                                    ?>" class="btn btn-danger kanan"><i class="fa fa-calendar"></i> View in Detail</a>-->
                      </div>


                      <hr>
                      <?php
                      if (!empty($_tampil_item)) {
                      ?>
                        <section class="table-responsive">


                          <table cellpadding="0" cellspacing="0" width="100%" class="table table-bordered table-striped table-condensed flip-content" id="tabel">
                            <thead>
                              <tr class="success">
                                <th rowspan="2" width="20%">
                                  CUSTOMER
                                </th>

                                <th rowspan="2" width="10%">
                                  Invoice Number
                                </th>

                                <th rowspan="2" width="30%">
                                  Product Category
                                </th>
                              </tr>
                              <tr class="success">
                                <th style="width:50px;">QTY</th>
                                <th style="width:50px;">USD</th>
                                <th style="width:50px;">USD/QTY</th>
                              </tr>
                            </thead>
                            <tbody>

                              <?php
                              $totqty = 0;
                              $totusd = 0;
                              $totunit = 0;
                              foreach ($_tampil_item as $key) {
                                $totqty += $key->tot_qty;
                                $totusd += $key->tot_usd;
                                $totunit += $key->tot_unitprice;
                              ?>
                                <tr>
                                  <td><?php echo $key->custcompany; ?></td>
                                  <td><?php echo $key->invno; ?></td>
                                  <td><?php echo $key->product_category_name; ?></td>
                                  <td style="text-align:right;">
                                    <div style="width:80px; text-align:right;"></div><?php echo number_format($key->tot_qty, 2, '.', ','); ?>
                                  </td>
                                  <td style="text-align:right;">
                                    <div style="width:80px; text-align:right;"></div><?php echo number_format($key->tot_usd, 2, '.', ','); ?>
                                  </td>
                                  <td style="text-align:right;">
                                    <div style="width:80px; text-align:right;"></div><?php echo number_format($key->tot_unitprice, 4, '.', ','); ?>
                                  </td>
                                </tr>
                              <?php
                              }
                              ?>
                              </tr>
                              <tr class="success">
                                <td colspan="3">TOTAL</td>
                                <td style="text-align:right;">
                                  <div style="width:80px; text-align:right;"></div><?php echo number_format($totqty, 2, '.', ','); ?>
                                </td>
                                <td style="text-align:right;">
                                  <div style="width:80px; text-align:right;"></div><?php echo number_format($totusd, 2, '.', ','); ?>
                                </td>
                                <td style="text-align:right;">
                                  <div style="width:80px; text-align:right;"></div><?php echo number_format($totunit, 4, '.', ','); ?>
                                </td>
                              </tr>
                            </tbody>
                          </table>

                        </section>
                      <?php
                      }
                      ?>
                    </div>
                  </div>
                  <hr>


                </div>

              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>