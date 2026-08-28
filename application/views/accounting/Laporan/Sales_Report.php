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
            <form action="<?php echo base_url(); ?>Sales_Report/search" method="get">
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
                        <a href="<?php echo base_url(); ?>Sales_Report/toExcelSalesReport?dari=<?php echo $this->input->get('dari'); ?>&sampai=<?php echo $this->input->get('sampai'); ?>&customer_name=<?php echo $this->input->get('customer_name'); ?>" class="btn green"><i class="fa fa-file-excel-o"></i> Excel</a>

                      </div>

                      <hr>
                      <?php
                      if (!empty($_tampil_item)) {
                      ?>
                        <section class="table-responsive">
                          <table cellpadding="0" cellspacing="0" width="100%" class="table table-bordered table-striped table-condensed flip-content" id="tabel">
                            <thead>
                              <tr class="success">
                                <th rowspan="2" width="30%">
                                  CUSTOMER
                                </th>
                                <th rowspan="2" width="30%">
                                  Sales Person
                                </th>

                                <?php foreach ($product as $r) {
                                ?>
                                  <th colspan="3" width="30%">
                                    <?php echo $r->product_category_name; ?>
                                  </th>
                                <?php } ?>

                                <th colspan="4">
                                  TOTAL
                                </th>

                              </tr>
                              <tr class="success">
                                <?php for ($i = 0; $i < count($product); $i++) {
                                ?>
                                  <th style="width:50px;">QTY</th>
                                  <th style="width:50px;">USD</th>
                                  <th style="width:50px;">USD/QTY</th>
                                <?php } ?>
                                <th style="width:50px;">QTY</th>
                                <th style="width:50px;">USD</th>
                                <th style="width:50px;">USD/QTY</th>
                                <!-- <th style="width:50px;">%</th> -->
                              </tr>
                            </thead>
                            <tbody>

                              <?php
                              $tgl_dari   = $this->input->get("dari");
                              $tgl_sampai = $this->input->get("sampai");


                              foreach ($_tampil_item as $key) {
                              ?>
                                <tr onclick="detail(this)" style="cursor: pointer;">
                                  <td style="display: none"><?php echo $key->custid; ?></td>
                                  <td><?php echo $key->custcompany; ?></td>
                                  <td><?php echo $key->sales_id; ?></td>
                                  <?php
                                  $totqty = 0;
                                  $totusd = 0;
                                  $totunit = 0;

                                  foreach ($product as $p) {
                                    $prod = $this->M_Sales_Report->call_by_product_id($p->product_category_id, $key->custid);

                                    if (!empty($prod->tot_qty)) {
                                      $qty = $prod->tot_qty;
                                      $usd = $prod->tot_usd;
                                      $price = $prod->tot_unitprice;
                                    } else {
                                      $qty = 0;
                                      $usd = 0;
                                      $price = 0;
                                    }


                                    $totqty += $qty;
                                    $totusd += $usd;
                                    $totunit += $price;
                                  ?>

                                    <td style="text-align:right;">
                                      <div style="width:80px; text-align:right;"></div><?php if (!empty($prod->product_category_id)) {
                                                                                          echo number_format($prod->tot_qty, 2, '.', ',');
                                                                                        } ?>
                                    </td>
                                    <td style="text-align:right;">
                                      <div style="width:80px; text-align:right;"></div><?php if (!empty($prod->product_category_id)) {
                                                                                          echo number_format($prod->tot_usd, 2, '.', ',');
                                                                                        } ?>
                                    </td>
                                    <td style="text-align:right;">
                                      <div style="width:80px; text-align:right;"></div><?php if (!empty($prod->product_category_id)) {
                                                                                          echo number_format($prod->tot_unitprice, 4, '.', ',');
                                                                                        } ?>
                                    </td>

                                  <?php
                                  }

                                  ?>
                                  <td>
                                    <div style="width:80px; text-align:right;"></div><?php echo number_format($totqty, 2, '.', ',');  ?>
                                  </td>
                                  <td>
                                    <div style="width:80px; text-align:right;"></div><?php echo number_format($totusd, 2, '.', ',');  ?>
                                  </td>
                                  <td>
                                    <div style="width:80px; text-align:right;"></div><?php echo number_format($totunit, 4, '.', ',');  ?>
                                  </td>
                                  <!-- <td ><div style="width:80px;"></div></td> -->

                                </tr>
                              <?php } ?>
                              <!--  <tr class="success">
                                                                <td>TOTAL</td> -->
                              <?php
                              // foreach ($product as $pg) { 
                              //     $grand = $this->M_Sales_Report->call_by_product_grand_total($pg->product_category_id);
                              ?>
                              <!-- <th ></th>
                                                                    <th ></th>
                                                                    <th ></th>  -->

                              <?php
                              // } 
                              ?>
                              <!-- <td></td>
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>
                                                            </tr>    -->
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

<script type="text/javascript">
  function detail(x) {
    function getText(el) {
      if (typeof el.textContent === 'string')
        return el.textContent;
      if (typeof el.innerText === 'string')
        return el.innerText;
    }
    $r = x.rowIndex;
    var id = getText(document.getElementById('tabel').rows[$r].cells[0]);
    var dari = document.getElementById("from").value;
    var sampai = document.getElementById("to").value;

    window.open("<?php echo base_url(); ?>Sales_Report/detail_transaction?dari=" + dari + "&sampai=" + sampai + "&customer_name=" + id);
  }
</script>