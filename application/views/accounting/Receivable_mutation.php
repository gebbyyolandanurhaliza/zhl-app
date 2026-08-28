<?php
error_reporting(0)
?>
<?php

if ($this->input->get('periode') == '') {
  $cust = '';
  $cur = '';
  $periode = date("Y-m-d");
} else {
  $cust = $this->input->get('customer');
  $cur = $this->input->get('currency');
  $periode = $this->input->get('periode');

  $curTemp = $cur;

  if ($curTemp == '') {
    $curTemp = 'USD';
  }
}

?>
<!-- BEGIN PAGE HEAD -->
<div class="page-head">
  <div class="container-fluid">
    <!-- BEGIN PAGE TITLE -->
    <div class="page-title">
      <h1>Accounting <small>Account Receivable Outstanding Report</small></h1>
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
              <span class="caption-subject theme-font">Account Receivable Outstanding Report</span>
            </div>
            <div class="tools">
              <a href="javascript:;" class="collapse"></a>
              <a href="javascript:;" class="reload"></a>
            </div>
          </div>
          <form action="<?php echo base_url(); ?>Receivable_mutation/search" method="get">
            <div class="portlet-body">
              <div class="form-body">
                <div class="row">
                  <div class="col-md-2">
                    <div class="form-group">
                      <label class="control-label col-md-3">Periode</label>
                      <div class="col-md-9">
                        <input type="text" id="tgl_tempo" name="periode" value="<?php echo $periode; ?>" class="form-control date date-picker" data-date="2016/02/01" data-date-format="yyyy-mm-dd" required />

                      </div>
                    </div>
                  </div>

                  <!--/span-->
                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="control-label col-md-2">Customer</label>
                      <div class="col-md-10">
                        <?php
                        $style_kategori = 'class="select2me form-control" id="customer" ';
                        echo form_dropdown('customer', $CustomerID, $cust, $style_kategori);
                        ?>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label class="control-label col-md-3">Currency</label>
                      <div class="col-md-9">
                        <?php
                        $style_curreny = 'class="select2me form-control" id="currency" ';
                        echo form_dropdown('currency', $CurrencyID, $cur, $style_curreny);
                        ?>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">

                      <div class="col-md-4">
                        <div class="row">
                          <div class="control-label col-md-9">
                            <button type="submit" class="btn purple kiri"><i class="fa fa-refresh"></i> Filter</button>
                          </div>
                        </div>
                      </div>
                      <!-- <div class="col-md-4">
                                                <div class="row">
                                                    <div class="control-label col-md-9">
                                                        <button type="button" class="btn green"><i class="fa fa-file-excel-o"></i> Excel</button>
                                                        <a href="<?php echo base_url(); ?>Excel/toExcel4?supplier=<?php echo $supp; ?>&currency=<?php echo $cur; ?>&periode=<?php echo $period; ?>" class="btn green"><i class="fa fa-file-excel-o"></i> Excel</a>
                                                    </div>
                                                </div>
                                            </div> -->
                      <div class="col-md-4">
                        <div class="row">
                          <div class="control-label col-md-9">
                            <a href="<?php echo base_url(); ?>Receivable_mutation/print_report?periode=<?php echo $this->input->get('periode'); ?>&supplier=<?php echo $this->input->get('supplier'); ?>&currency=<?php echo $this->input->get('currency'); ?>" class="btn btn-primary"><i class="fa fa-print"></i> Print</a>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!--/span-->
                </div>
              </div>
            </div>
          </form>
          <!--  <?php
                if (!empty($get_mutation)) {
                ?>
                    <hr/>
                    <table cellpadding="0" cellspacing="0" width="100%" class="table table-bordered table-striped table-condensed flip-content" id="table">
                        <thead>
                            <tr>
                                <th>
                                    Customer ID
                                </th>
                                <th>
                                    Customer Name
                                </th>
                                <th>
                                    Beginning Balance
                                </th>
                                <th>
                                    Purchase
                                </th>
                                <th>
                                    Down Payment
                                </th>
                                <th>
                                    Payment
                                </th>
                                <th>
                                    Debt Note
                                </th>
                                <th>
                                    Credit Note
                                </th>
                                <th>
                                    Balance
                                </th>
                                <th>
                                    Balance Rate
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php

                            foreach ($get_mutation as $v) {
                              //$balance = $v->begining_balance + $v->purchase  - $v->payment - $v->debet_note + $v->kredit_note;
                            ?>
                                    <tr>
                                        <td><?php echo "$v->customer_code"; ?></td>
                                        <td><?php echo "$v->customer_name"; ?></td>
                                        <td style="text-align: right;"><?php echo number_format($v->begining_balance, 2); ?></td>
                                        <td style="text-align: right;"><?php echo number_format($v->purchase, 2); ?></td>
                                        <td style="text-align: right;"><?php echo number_format($v->down_payment, 2); ?></td>
                                        <td style="text-align: right;"><?php echo number_format($v->payment, 2); ?></td>
                                        <td style="text-align: right;"><?php echo number_format($v->debet_note, 2); ?></td>
                                        <td style="text-align: right;"><?php echo number_format($v->kredit_note, 2); ?></td>
                                        <td style="text-align: right;"><?php echo number_format($v->balance, 2); ?></td>
                                        <td style="text-align: right;"><?php echo number_format($v->balance_rateakhir, 2); ?></td>
                                    </tr>
                                    <?php
                                  }
                                    ?>
                        </tbody>
                    </table>
                                    <?php
                                  }
                                    ?> -->


          <?php
          if (!empty($Get_aging)) {
            setlocale(LC_MONETARY, 'en_US.UTF-8');
          ?>
            <table>
              <tr>
                <th>
                  <h3>Currency :</h3>
                </th>
                <th style="font-size:36px;"><?php echo $curr; ?></th>
              </tr>
            </table>
            <table class="table table-bordered" id="tabel">
              <thead>
                <tr>

                  <th width="50%">
                    Customer
                  </th>
                  <th width="10%">
                    Customer ID
                  </th>
                  <th width="10%">
                    nocoa
                  </th>
                  <!--  <th width="8%">
                                                Inv. Date
                                            </th>
                                            <th width="10%">
                                                Invoice Number
                                            </th>
                                            <th width="8%">
                                                Due Date
                                            </th> -->
                  <!-- <th width="15%">
                                                Outstanding Amount
                                            </th>
                                            <th width="10%">
                                                Current
                                            </th>
                                            <th width="10%">
                                                0-30 Days
                                            </th>
                                            <th width="10%">
                                                31-60 Days
                                            </th>
                                            <th width="10%">
                                                61-90 Days
                                            </th>
                                            <th width="10%">
                                                >91 Days
                                            </th> -->
                  <th width="30%">
                    Total (<?php echo $curTemp; ?>)
                  </th>
                </tr>
              </thead>

              <tbody>
                <?php
                $totgt = 0;
                $totduedate = 0;
                $totsd30 = 0;
                $totsd60 = 0;
                $totsd90 = 0;
                $totsd120 = 0;


                foreach ($GroupSupplierID as $m) {

                  // echo "<tr><td colspan='10' style='text-align:left;font-weight:bold;background-color:#ddd;'>$m->suppliercompany</td></tr>";
                  $duedate = 0;
                  $sd30 = 0;
                  $sd60 = 0;
                  $sd90 = 0;
                  $sd120 = 0;
                  $grand_total = 0;
                  $gt = 0;
                  foreach ($Get_aging as $v) {
                    if ($v->tmp_kodesup == $m->kode_sup) {
                      $total = $v->tmp_not_due_date + $v->tmp_0sd30 + $v->tmp_31sd60 + $v->tmp_61sd90 + $v->tmp_91sd120 + $v->tmp_more120;
                      $gt += $v->tmp_not_due_date + $v->tmp_0sd30 + $v->tmp_31sd60 + $v->tmp_61sd90 + $v->tmp_91sd120 + $v->tmp_more120;
                      $duedate += $v->tmp_not_due_date;
                      $sd30 += $v->tmp_0sd30;
                      $sd60 += $v->tmp_31sd60;
                      $sd90 += $v->tmp_61sd90;
                      $sd120 += $v->tmp_91sd120;
                      $nocoa = $v->tmp_nocoa;
                      $cusID = $v->tmp_kodesup;

                      $grand_total += $v->tmp_91sd120 + $v->tmp_more120;
                ?>
                      <!-- <tr>
                                                    <td><?php //echo $v->tmp_kodesup; 
                                                        ?></td> -->
                      <!-- <td><?php echo date("d-m-Y", strtotime($v->tmp_inv_date)); ?></td>
                                                    <td><?php echo $v->tmp_invno; ?></td>
                                                    <td><?php echo date("d-m-Y", strtotime($v->tmp_due_date)); ?></td>
                                                -->
                      <!--     <td style="text-align:right;"><?php echo number_format($total, 2, '.', ','); ?></td> 
                                                    <td style="text-align:right;"><?php echo number_format($v->tmp_not_due_date, 2, '.', ','); ?></td> 

                                                    <td style="text-align:right;"><?php echo number_format($v->tmp_0sd30, 2, '.', ','); ?></td>                                    
                                                    <td style="text-align:right;"><?php echo number_format($v->tmp_31sd60, 2, '.', ','); ?></td>
                                                    <td style="text-align:right;"><?php echo number_format($v->tmp_61sd90, 2, '.', ','); ?></td>
                                                    <td style="text-align:right;"><?php echo number_format($v->tmp_91sd120 + $v->tmp_more120, 2, '.', ','); ?></td>
                                                    <td style="text-align:right;"><?php echo number_format($total, 2, '.', ','); ?></td> 
                                                </tr> -->

                <?php
                    }
                  }
                  echo " <tr><td  style='text-align:left;'><b>" . $m->suppliercompany . "</b></td>"
                    . "<td style='text-align:left;font-weight: bold;'>" . $cusID . "</td>"
                    . "<td style='text-align:right;font-weight: bold;'>" . $nocoa . "</td>"
                    // . "<td style='text-align:right;font-weight: bold;'>".$m->suppliercompany."</td>"
                    // . "<td style='text-align:right;font-weight: bold;'>".number_format($duedate, 2, '.', ',')."</td>"
                    // . "<td style='text-align:right;font-weight: bold;'>".number_format($sd30, 2, '.', ',')."</td>"
                    // . "<td style='text-align:right;font-weight: bold;'>".number_format($sd60, 2, '.', ',')."</td>"
                    // . "<td style='text-align:right;font-weight: bold;'>".number_format($sd90, 2, '.', ',')."</td>"
                    // . "<td style='text-align:right;font-weight: bold;'>".number_format($sd120, 2, '.', ',')."</td>"
                    . "<td style='text-align:right;font-weight: bold;'>" . str_replace("$", "", money_format('%(#10n', $gt)) . "</td></tr>";
                  $totgt += $gt;
                  $totduedate += $duedate;
                  $totsd30 += $sd30;
                  $totsd60 += $sd60;
                  $totsd90 += $sd90;
                  $totsd120 += $sd120;
                }

                echo " <tr style='background: #ffffcc'><td colspan='3' style='text-align:right;'><b>Grand Total</b></td>"
                  // . "<td style='text-align:right;font-weight: bold;'>".number_format($totgt, 2, '.', ',')."</td>"
                  // . "<td style='text-align:right;font-weight: bold;'>".number_format($totduedate, 2, '.', ',')."</td>"
                  // . "<td style='text-align:right;font-weight: bold;'>".number_format($totsd30, 2, '.', ',')."</td>"
                  // . "<td style='text-align:right;font-weight: bold;'>".number_format($totsd60, 2, '.', ',')."</td>"
                  // . "<td style='text-align:right;font-weight: bold;'>".number_format($totsd90, 2, '.', ',')."</td>"
                  // . "<td style='text-align:right;font-weight: bold;'>".number_format($totsd120, 2, '.', ',')."</td>"
                  . "<td style='text-align:right;font-weight: bold;'>" . str_replace("$", "", money_format('%(#10n', $totgt)) . "</td></tr>";

                ?>
              </tbody>
            </table>

          <?php } ?>
        </div>
      </div>
    </div>
  </div>

  <script type="text/javascript">
    $(document).ready(function() {
      // $("#tabel").dataTable({
      //         "scrollY" : 400,
      //         "scrollX": true});
    });
  </script>