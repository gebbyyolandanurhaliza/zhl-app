<?php
$dari = $this->input->get('dari');
$sampai = $this->input->get('sampai');
$supplier = $this->input->get('supplier');
$currency = $this->input->get('currency');
?>
<!-- BEGIN PAGE HEAD -->
<div class="page-head">
  <div class="container-fluid">
    <!-- BEGIN PAGE TITLE -->
    <div class="page-title">
      <h1>Accounting <small>Accounts of Receivable Aging</small></h1>
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
              <span class="caption-subject theme-font">Monitoring Accounts Receivable Aging</span>
            </div>
            <div class="tools">
              <a href="javascript:;" class="collapse"></a>
              <a href="javascript:;" class="reload"></a>
            </div>
          </div>
          <div class="portlet-body">
            <div class="form-body">
              <form action="<?php echo base_url(); ?>Receivable_aging/search" method="get">
                <div class="portlet-body">
                  <div class="form-body">
                    <div class="row">
                      <div class="col-md-4">
                        <div class="form-group">
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
                      </div>

                      <!--/span-->
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="control-label col-md-2">Supplier</label>
                          <div class="col-md-10">
                            <?php
                            $style_kategori = 'class="select2me form-control" id="supplier" required';
                            echo form_dropdown('supplier', $SupplierID, $supplier, $style_kategori);
                            ?>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="control-label col-md-3">Currency</label>
                          <div class="col-md-9">
                            <?php
                            $style_curreny = 'class="select2me form-control" id="currency" required';
                            echo form_dropdown('currency', $CurrencyID, $currency, $style_curreny);
                            ?>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-12">
                        <hr />
                        <button type="submit" class="btn purple kiri"><i class="fa fa-refresh"></i> Filter</button>
                        <button type="button" class="btn green"><i class="fa fa-file-excel-o"></i> Excel</button>
                        <a href="<?php echo base_url(); ?>Receivable_statement/print_report?periode=<?php echo $this->input->get('periode'); ?>&supplier=<?php echo $this->input->get('supplier'); ?>&currency=<?php echo $this->input->get('currency'); ?>" class="btn btn-primary"><i class="fa fa-print"></i> Print</a>
                        <hr />
                      </div>

                      <!--/span-->
                    </div>
                  </div>
                </div>
              </form>
              <?php
              if (!empty($Get_aging)) {
              ?>
                <table class="table table-bordered" id="tabel">
                  <thead>
                    <tr>
                      <th width="20%">
                        Supplier
                      </th>
                      <th width="8%">
                        Inv. Date
                      </th>
                      <th width="10%">
                        Invoice Number
                      </th>
                      <th width="8%">
                        Due Date
                      </th>
                      <th width="8%">
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
                        >90 Days
                      </th>
                      <th width="20%">
                        Total
                      </th>
                    </tr>
                  </thead>

                  <tbody>
                    <?php
                    foreach ($GroupSupplierID as $m) {

                      echo "<tr><td colspan='10' style='text-align:left;font-weight:bold;background-color:#ddd;'>$m->suppliercompany</td></tr>";
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
                          $grand_total += $v->tmp_91sd120 + $v->tmp_more120;
                    ?>
                          <tr>
                            <td><?php //echo $v->tmp_kodesup; 
                                ?></td>
                            <td><?php echo date("d-m-Y", strtotime($v->tmp_inv_date)); ?></td>
                            <td><?php echo $v->tmp_invno; ?></td>
                            <td><?php echo date("d-m-Y", strtotime($v->tmp_due_date)); ?></td>
                            <td style="text-align:right;"><?php echo number_format($v->tmp_not_due_date, 2, '.', ','); ?></td>
                            <td style="text-align:right;"><?php echo number_format($v->tmp_0sd30, 2, '.', ','); ?></td>
                            <td style="text-align:right;"><?php echo number_format($v->tmp_31sd60, 2, '.', ','); ?></td>
                            <td style="text-align:right;"><?php echo number_format($v->tmp_61sd90, 2, '.', ','); ?></td>
                            <td style="text-align:right;"><?php echo number_format($v->tmp_91sd120 + $v->tmp_more120, 2, '.', ','); ?></td>
                            <td style="text-align:right;"><?php echo number_format($total, 2, '.', ','); ?></td>
                          </tr>

                    <?php
                        }
                      }
                      echo " <tr style='background: #ffffcc'><td colspan='4' style='text-align:right;'><b>Grand Total</b></td>"
                        . "<td style='text-align:right;font-weight: bold;'>" . number_format($duedate, 2, '.', ',') . "</td>"
                        . "<td style='text-align:right;font-weight: bold;'>" . number_format($gt, 2, '.', ',') . "</td>"
                        . "<td style='text-align:right;font-weight: bold;'>" . number_format($sd60, 2, '.', ',') . "</td>"
                        . "<td style='text-align:right;font-weight: bold;'>" . number_format($sd30, 2, '.', ',') . "</td>"
                        . "<td style='text-align:right;font-weight: bold;'>" . number_format($sd90, 2, '.', ',') . "</td>"
                        . "<td style='text-align:right;font-weight: bold;'>" . number_format($gt, 2, '.', ',') . "</td></tr>";
                    }
                    ?>
                  </tbody>
                </table>

              <?php } ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>