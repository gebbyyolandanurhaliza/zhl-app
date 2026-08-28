<?php
error_reporting(0);
if ($this->input->get('supp') <> '') {
  $supplier = $this->input->get('supplier');
  $supp = $this->input->get('supp');
  $cur = $this->input->get('currency');
  $awal = $this->input->get('from');
  $akhir = $this->input->get('to');
  $coa = $this->input->get('coa');
} else {
  $supplier = "";
  $supp = "";
  $cur = "";
  $awal = "";
  $akhir = "";
  $coa = "";
}
?>
<script>
  function ambil_coa() {
    var supplier = document.getElementById('supplier').value;
    var str = supplier.split("|");
    document.getElementById('sid').value = str[0];
    document.getElementById('coaid').value = str[1];
  }
</script>

<div class="page-content">
  <div class="container">
    <!-- BEGIN PAGE CONTENT INNER -->
    <div class="row">
      <form action="<?php echo base_url(); ?>Customers_card2/search" method="get">
        <div class="col-md-12">
          <div class="portlet light">
            <div class="portlet-title">
              <div class="caption">
                <i class="fa fa-credit-card theme-font"></i>
                <span class="caption-subject theme-font">Customer Card</span>
              </div>
              <div class="tools">
                <a href="javascript:;" class="collapse"></a>
                <a href="javascript:;" class="reload"></a>
              </div>
            </div>
            <div class="portlet-body">
              <div class="form-body">
                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="control-label col-md-2">Customer</label>
                      <div class="col-md-10">
                        <?php
                        $style_kategori = 'class="select2me form-control" id="supplier" onchange="ambil_coa()"" required';
                        echo form_dropdown('supp', $SupplierID, $supp, $style_kategori);
                        ?>
                      </div>
                    </div>
                  </div>
                  <!--/span-->
                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="control-label col-md-3">Currency</label>
                      <div class="col-md-9">
                        <?php
                        $style_currency = 'class="select2me form-control" id="currency" ';
                        echo form_dropdown('currency', $CurrencyID, $cur, $style_currency);
                        ?>
                      </div>
                    </div>
                  </div>
                  <!--/span-->
                </div>
                <div class="row">
                  <!--/span-->
                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="control-label col-md-2">Period</label>
                      <div class="col-md-9">
                        <div class="input-group date-picker input-daterange" data-date-format="dd-mm-yyyy">
                          <input type="text" class="form-control input-sm" id="from" name="from" value="<?php echo $awal; ?>" required>
                          <span class="input-group-addon">
                            to </span>
                          <input type="text" class="form-control input-sm" id="to" name="to" value="<?php echo $akhir; ?>" required>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!--/span-->

                  <div class="col-md-3  col-md-push-5">
                    <div class="form-group">
                      <div class="col-md-12">
                        <input type="hidden" id="sid" name="supplier" class="form-control" value="<?php echo $supplier; ?>" required />
                        <input type="hidden" id="coaid" name="coa" class="form-control" value="<?php echo $coa; ?>" required />
                      </div>
                    </div>

                  </div>
                  <div class="col-md-12">
                    <hr />
                    <button type="submit" class="btn purple kiri"><i class="fa fa-refresh"></i> Refresh</button>
                    <!-- <button type="button" class="btn green"><i class="fa fa-file-excel-o"></i> Excell</button> -->
                    <a href="<?php echo base_url(); ?>Excel/toExcel8?supplier=<?php echo $supplier; ?>&coa=<?php echo $coa; ?>&currency=<?php echo $cur; ?>&from=<?php echo $awal; ?>&to=<?php echo $akhir; ?>" class="btn green"><i class="fa fa-file-excel-o"></i> Excel</a>
                    <a href="<?php echo base_url(); ?>Customers_card2/toPrintCustomerCard?supplier=<?php echo $supplier; ?>&coa=<?php echo $coa; ?>&currency=<?php echo $cur; ?>&dari=<?php echo $awal; ?>&sampai=<?php echo $akhir; ?>" class="btn btn-primary"><i class="fa fa-print"></i> Print</a>
                    <hr />
                  </div>
                </div>
              </div>
              <hr />
              <table cellpadding="0" cellspacing="0" width="100%" class="table table-bordered table-striped table-condensed flip-content" id="tabel">
                <thead>
                  <tr>
                    <!-- <th>
                                            Customer ID
                                        </th>
                                        <th>
                                            Customer Name
                                        </th> -->
                    <th>
                      Date
                    </th>
                    <th>
                      Description
                    </th>
                    <th>
                      Reference
                    </th>
                    <th>
                      Debet
                    </th>
                    <th>
                      Credit
                    </th>
                    <th>
                      Balance
                    </th>
                    <!-- <th>
                                            Status
                                        </th> -->
                  </tr>
                </thead>
                <tbody>
                  <?php
                  foreach ($Get_aging as $v) {
                    if ($v->tmp_balance < 0) {
                      $str = str_replace("-", '', $v->tmp_balance);
                      $Balance = "(" . number_format($str, 2, ".", ",") . ")";
                    } else {
                      $Balance = number_format($v->tmp_balance, 2, ".", ",");
                    }
                  ?>
                    <tr>
                      <!-- <td><?php echo $v->tmp_kodecus; ?></td>
                                    <td><?php echo $v->tmp_customer_name; ?></td> -->
                      <td><?php echo date('d-m-Y', strtotime(($v->tmp_tanggal))); ?></td>
                      <td><textarea style="width: 100%;border:0;height: 20px;background: transparent;resize: none;" readonly><?php echo $v->tmp_uraian; ?></textarea></td>
                      <td><?php echo $v->tmp_nojurnal; ?></td>
                      <td style="text-align:right;"><?php echo number_format($v->tmp_debet, 2, ".", ","); ?></td>
                      <td style="text-align:right;"><?php echo number_format($v->tmp_kredit, 2, ".", ","); ?></td>
                      <td style="text-align:right;"><?php echo $Balance; ?></td>
                      <?php
                      // $huruf = $v->tmp_jenis_trans;
                      // if( $huruf == 'AR'){
                      ?>
                      <!--   <td style="text-align:center;"><a href="<?php echo base_url() . "Customers_card/reviewARpayment?id=" . $v->tmp_nojurnal; ?>" style="background-color:red;color:#fff;padding: 0 15px 0 15px;text-decoration: none;" target="_BLANK">Paid</a></td> -->
                      <?php
                      // } else if($huruf == 'RDP'){
                      ?>
                      <!--  <td style="text-align:center;"><a href="<?php echo site_url('Customers_card/reviewARdeposit?id=' . $v->tmp_nojurnal); ?>" style="background-color:green;color:#fff;padding: 0 15px 0 15px;text-decoration: none;" target="_BLANK">Deposit</a></td> -->
                      <?php
                      // }else{
                      // echo '<td style="text-align:center;"></td>';
                      // }
                      ?>
                    </tr>
                  <?php
                  }
                  ?>
                </tbody>
              </table>

            </div>
          </div>
      </form>
    </div>
  </div>
</div>