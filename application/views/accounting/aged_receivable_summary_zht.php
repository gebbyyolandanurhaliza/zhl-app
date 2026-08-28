<!-- <?php
      if ($this->input->get('period') == '') {
        $supplier = '';
        $currency = '';
        $period   = date("Y-m-d");
        // $sampai = date('Y-m');
      } else {
        $supplier = $this->input->get('supplier');
        $currency = $this->input->get('currency');
        $period   = $this->input->get('period');
        // $sampai = $this->input->get('dari');

        $curTemp = $currency;

        if ($curTemp == '') {
          $curTemp = 'USD';
        }
      }
      ?> -->

<div class="page-content">
  <div class="container">
    <!-- BEGIN PAGE CONTENT INNER -->
    <div class="row">
      <div class="col-md-12">
        <div class="portlet light">
          <div class="portlet-title">
            <div class="caption">
              <i class="fa fa-credit-card theme-font"></i>
              <span class="caption-subject theme-font">Aged Receivable Summary ZHT</span>
            </div>
            <div class="tools">
              <a href="javascript:;" class="collapse"></a>
              <a href="javascript:;" class="reload"></a>
            </div>
          </div>
          <div class="portlet-body">
            <div class="form-body">
              <form action="<?php echo base_url(); ?>Aged_Receivable_Summary_zht/search" method="get">
                <div class="portlet-body">
                  <div class="form-body">
                    <div class="row">
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="control-label col-md-3">Period</label>
                          <div class="col-md-7">
                            <div class="input-group date-picker input-daterange" data-date-format="yyyy-mm-dd">
                              <input type="text" class="form-control input-sm" id="period" name="period" value="<?php echo $period; ?>" required><!-- 
                                                    <span class="input-group-addon">
                                                        to </span>
                                                    <input type="text" class="form-control input-sm" id="to" name="sampai" value="<?php echo $sampai; ?>" required> -->
                            </div>
                          </div>
                        </div>
                      </div>

                      <!--/span-->
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="control-label col-md-2">Customer</label>
                          <div class="col-md-10">
                            <?php
                            $style_kategori = 'class="select2me form-control" id="supplier"';
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
                            $style_curreny = 'class="select2me form-control" id="currency"';
                            echo form_dropdown('currency', $CurrencyID, $currency, $style_curreny);
                            ?>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-12">
                        <hr />
                        <button type="submit" class="btn purple kiri"><i class="fa fa-refresh"></i> Filter</button>
                        <a href="<?php echo base_url(); ?>Excel/toExcelAgedReceivableSummary_zht?period=<?php echo $this->input->get('period'); ?>&supplier=<?php echo $this->input->get('supplier'); ?>&currency=<?php echo $this->input->get('currency'); ?>" class="btn green"><i class="fa fa-file-excel-o"></i> Excel</a>
                        <a href="<?php echo base_url(); ?>Aged_Receivable_Summary_zht/print_report?period=<?php echo $this->input->get('period'); ?>&supplier=<?php echo $this->input->get('supplier'); ?>&currency=<?php echo $this->input->get('currency'); ?>" class="btn btn-primary" target="_blank"><i class="fa fa-print"></i> Print</a>
                        <hr />
                      </div>

                      <!--/span-->
                    </div>
                  </div>
                </div>
              </form>
              <?php
              if (!empty($Get_aging)) {
                setlocale(LC_MONETARY, 'en_US.UTF-8');
              ?>
                <table class="table table-bordered" id="tabel">
                  <thead>
                    <tr>
                      <th width="20%">
                        Customer
                      </th>
                      <th width="15%">
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
                      </th>
                      <th width="15%">
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
                          $sd120 += $v->tmp_91sd120 + $v->tmp_more120;
                          $grand_total += $v->tmp_91sd120 + $v->tmp_more120;
                        }
                      }
                      echo " <tr><td  style='text-align:left;'><b>" . $m->suppliercompany . "</b></td>"
                        . "<td style='text-align:right;font-weight: bold;'>" . number_format($gt, 2, '.', ',') . "</td>"
                        . "<td style='text-align:right;font-weight: bold;'>" . number_format($duedate, 2, '.', ',') . "</td>"
                        . "<td style='text-align:right;font-weight: bold;'>" . number_format($sd30, 2, '.', ',') . "</td>"
                        . "<td style='text-align:right;font-weight: bold;'>" . number_format($sd60, 2, '.', ',') . "</td>"
                        . "<td style='text-align:right;font-weight: bold;'>" . number_format($sd90, 2, '.', ',') . "</td>"
                        . "<td style='text-align:right;font-weight: bold;'>" . number_format($sd120, 2, '.', ',') . "</td>"
                        . "<td style='text-align:right;font-weight: bold;'>" . number_format($gt, 2, '.', ',') . "</td></tr>";
                      $totgt += $gt;
                      $totduedate += $duedate;
                      $totsd30 += $sd30;
                      $totsd60 += $sd60;
                      $totsd90 += $sd90;
                      $totsd120 += $sd120;
                    }

                    echo " <tr style='background: #ffffcc'><td style='text-align:right;'><b>Grand Total</b></td>"
                      . "<td style='text-align:right;font-weight: bold;'>" . number_format($totgt, 2, '.', ',') . "</td>"
                      . "<td style='text-align:right;font-weight: bold;'>" . number_format($totduedate, 2, '.', ',') . "</td>"
                      . "<td style='text-align:right;font-weight: bold;'>" . number_format($totsd30, 2, '.', ',') . "</td>"
                      . "<td style='text-align:right;font-weight: bold;'>" . number_format($totsd60, 2, '.', ',') . "</td>"
                      . "<td style='text-align:right;font-weight: bold;'>" . number_format($totsd90, 2, '.', ',') . "</td>"
                      . "<td style='text-align:right;font-weight: bold;'>" . number_format($totsd120, 2, '.', ',') . "</td>"
                      . "<td style='text-align:right;font-weight: bold;'>" . number_format($totgt, 2, '.', ',') . "</td></tr>";

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