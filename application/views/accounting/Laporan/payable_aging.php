<?php
if ($this->input->get('period') == '') {
  $supp = '';
  $cur = '';
  $period = date("Y-m-d");
  // $sampai = date('Y-m');
} else {
  $supp = $this->input->get('supplier');
  $cur = $this->input->get('currency');
  $period = $this->input->get('period');
  // $sampai = $this->input->get('dari');
}
?>
<!-- BEGIN PAGE HEAD -->
<div class="page-head">
  <div class="container-fluid">
    <!-- BEGIN PAGE TITLE -->
    <div class="page-title">
      <h1>Accounting Report <small>Monitoring Payable Aging</small></h1>
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
              <span class="caption-subject theme-font">Monitoring Payable Aging</span>
            </div>
            <div class="tools">
              <a href="javascript:;" class="collapse"></a>
              <a href="javascript:;" class="reload"></a>
            </div>
          </div>
          <div class="portlet-body">
            <form action="<?php echo base_url(); ?>Payable_aging/search" method="get">
              <div class="portlet-body">
                <div class="form-body">
                  <div class="row">

                    <!--/span-->
                    <div class="col-md-4">
                      <div class="form-group">
                        <label class="control-label col-md-3">Period</label>
                        <div class="col-md-7">
                          <div class="input-group date-picker input-daterange" data-date-format="yyyy-mm-dd">
                            <input type="text" class="form-control input-sm" id="from" name="period" value="<?php echo $period; ?>" required>
                            <!-- <span class="input-group-addon">
                                                            to </span>
                                                        <input type="text" class="form-control input-sm" id="to" name="sampai" value="<?php echo $sampai; ?>" required> -->
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label class="control-label col-md-2">Vendor</label>
                        <div class="col-md-10">
                          <?php
                          $style_kategori = 'class="select2me form-control" id="supplier" ';
                          echo form_dropdown('supplier', $SupplierID, $supp, $style_kategori);
                          ?>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-4">
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
                    <div class="col-md-12">
                      <hr />
                      <button type="submit" class="btn purple kiri"><i class="fa fa-refresh"></i> Filter</button>
                      <a href="<?php echo base_url(); ?>Excel/toExcelPayableAging?period=<?php echo $this->input->get('period'); ?>&supplier=<?php echo $this->input->get('supplier'); ?>&currency=<?php echo $this->input->get('currency'); ?>" class="btn green"><i class="fa fa-file-excel-o"></i> Excel</a>
                      <a href="<?php echo base_url(); ?>Payable_aging/print_report?period=<?php echo $this->input->get('period'); ?>&supplier=<?php echo $this->input->get('supplier'); ?>&currency=<?php echo $this->input->get('currency'); ?>" class="btn btn-primary"><i class="fa fa-print"></i> Print</a>
                      <a href="<?php echo base_url(); ?>Payable_aging/print_report2?period=<?php echo $this->input->get('period'); ?>&supplier=<?php echo $this->input->get('supplier'); ?>&currency=<?php echo $this->input->get('currency'); ?>" class="btn btn-primary" id="post"><i class="fa fa-print"></i> Print for Post</a>

                      <hr />
                    </div>

                    <!--/span-->
                  </div>
                </div>
              </div>
            </form>
            <hr />

            <?php
            if (!empty($Get_aging)) {

            ?>
              <table class="table table-bordered" id="tabel1">
                <thead>
                  <tr>
                    <th width="20%">
                      Vendor
                    </th>
                    <th width="5%">
                      Inv. Date
                    </th>
                    <th width="10%">
                      Invoice Number
                    </th>
                    <th width="8%">
                      Due Date
                    </th>
                    <th width="5%">
                      Currency
                    </th>
                    <th width="8%">
                      Amount
                    </th>
                    <th width="8%">
                      Current
                    </th>
                    <th width="8%">
                      0-30 Days
                    </th>
                    <th width="8%">
                      31-60 Days
                    </th>
                    <th width="8%">
                      61-90 Days
                    </th>
                    <th width="8%">
                      > 91 Days
                    </th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $ttl_gt = 0;
                  $ttl_duedate = 0;
                  $ttl_sd30 = 0;
                  $ttl_sd60 = 0;
                  $ttl_sd90 = 0;
                  $ttl_sd120 = 0;
                  $ttl_grand_total = 0;
                  foreach ($GroupSupplierID as $m) {

                    setlocale(LC_MONETARY, 'en_US.UTF-8');
                    echo "<tr><td colspan='11'  nowrap='' style='text-align:left;font-weight:bold;background-color:#ddd;'>$m->suppliercompany</td></tr>";
                    echo "<tr><td colspan='11'  nowrap='' style='text-align:left;font-weight:bold;background-color:#ddd;'>$m->address $m->postalcode</td></tr>";
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


                        // $ttl_gt += $v->tmp_not_due_date + $v->tmp_0sd30 + $v->tmp_31sd60 + $v->tmp_61sd90 + $v->tmp_91sd120 + $v->tmp_more120;
                        // $ttl_duedate += $v->tmp_not_due_date;
                        // $ttl_sd30 += $v->tmp_0sd30;
                        // $ttl_sd60 += $v->tmp_31sd60;
                        // $ttl_sd90 += $v->tmp_61sd90;
                        // $ttl_sd120 +=$v->tmp_91sd120;
                        // $ttl_grand_total += $v->tmp_91sd120 + $v->tmp_more120;  
                  ?>
                        <tr>
                          <td><?php //echo $v->tmp_kodesup;   
                              ?></td>
                          <td><?php echo $v->tmp_inv_date; ?></td>
                          <td><?php echo $v->tmp_invno; ?></td>
                          <td><?php echo $v->tmp_due_date; ?></td>
                          <td><?php echo $v->tmp_currency; ?></td>
                          <td style="text-align:right;"><?php echo str_replace("$", "", money_format('%(#6n', $total)); ?></td>
                          <td style="text-align:right;"><?php echo str_replace("$", "", money_format('%(#6n', $v->tmp_not_due_date)); ?></td>
                          <td style="text-align:right;"><?php echo str_replace("$", "", money_format('%(#6n', $v->tmp_0sd30)); ?></td>
                          <td style="text-align:right;"><?php echo str_replace("$", "", money_format('%(#6n', $v->tmp_31sd60)); ?></td>
                          <td style="text-align:right;"><?php echo str_replace("$", "", money_format('%(#6n', $v->tmp_61sd90)); ?></td>
                          <td style="text-align:right;"><?php echo str_replace("$", "", money_format('%(#6n', $v->tmp_91sd120 + $v->tmp_more120)); ?></td>
                        </tr>

                  <?php
                      }
                    }

                    $ttl_gt += $gt;
                    $ttl_duedate += $duedate;
                    $ttl_sd30 += $sd30;
                    $ttl_sd60 += $sd60;
                    $ttl_sd90 += $sd90;
                    $ttl_sd120 += $sd120;

                    echo " <tr style='background: #ffffcc'><td colspan='5' style='text-align:right;f'><b>Grand Total</b></td>"
                      . "<td style='text-align:right;font-weight: bold;'>" . str_replace("$", "", money_format('%(#6n', $gt)) . "</td>"
                      . "<td style='text-align:right;font-weight: bold;'>" . str_replace("$", "", money_format('%(#6n', $duedate)) . "</td>"
                      . "<td style='text-align:right;font-weight: bold;'>" . str_replace("$", "", money_format('%(#6n', $sd30)) . "</td>"
                      . "<td style='text-align:right;font-weight: bold;'>" . str_replace("$", "", money_format('%(#6n', $sd60)) . "</td>"
                      . "<td style='text-align:right;font-weight: bold;'>" . str_replace("$", "", money_format('%(#6n', $sd90)) . "</td>"
                      . "<td style='text-align:right;font-weight: bold;'>" . str_replace("$", "", money_format('%(#6n', $grand_total)) . "</td></tr>";
                  }
                  echo " <tr style='background: #71b93d'><td colspan='5' style='text-align:right;f'><b>Total</b></td>"
                    . "<td style='text-align:right;font-weight: bold;'>" . str_replace("$", "", money_format('%(#6n', $ttl_gt)) . "</td>"
                    . "<td style='text-align:right;font-weight: bold;'>" . str_replace("$", "", money_format('%(#6n', $ttl_duedate)) . "</td>"
                    . "<td style='text-align:right;font-weight: bold;'>" . str_replace("$", "", money_format('%(#6n', $ttl_sd30)) . "</td>"
                    . "<td style='text-align:right;font-weight: bold;'>" . str_replace("$", "", money_format('%(#6n', $ttl_sd60)) . "</td>"
                    . "<td style='text-align:right;font-weight: bold;'>" . str_replace("$", "", money_format('%(#6n', $ttl_sd90)) . "</td>"
                    . "<td style='text-align:right;font-weight: bold;'>" . str_replace("$", "", money_format('%(#6n', $ttl_grand_total)) . "</td>
                                     </tr>";
                  ?>
                </tbody>
              </table>
            <?php } ?>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script type="text/javascript">
    $(document).ready(function() {
      $("#tabel").dataTable({
        "scrollY": 400,
        "scrollX": true
      });
    });

    // $('#post').click(function(){
    //     var secure = document.getElementbyId('supplier').value;

    //     if (secure == ""){
    //         return;
    //     }
    // });
  </script>