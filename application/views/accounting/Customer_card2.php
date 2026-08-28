<?php
error_reporting(0);
if ($this->input->get('supp') <> '') {
  $supplier = $this->input->get('supplier');
  $supp = $this->input->get('supp');
  $cur = $this->input->get('currency');
  $period = $this->input->get('periode');
  $coa = $this->input->get('coa');
} else {
  $supplier = "";
  $supp = "";
  $cur = "";
  $period = "";
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
<!-- BEGIN PAGE HEAD -->
<div class="page-head">
  <div class="container-fluid">
    <!-- BEGIN PAGE TITLE -->
    <div class="page-title">
      <h1>Accounting Report <small>Customer Card</small></h1>
    </div>
    <!-- END PAGE TITLE -->
  </div>
</div>
<!-- END PAGE HEAD -->
<div class="page-content">
  <div class="container">
    <!-- BEGIN PAGE CONTENT INNER -->
    <div class="row">
      <form action="<?php echo base_url(); ?>Customers_card/search" method="get">
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
                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="control-label col-md-2">Date</label>
                      <div class="col-md-9">
                        <input type="text" id="tgl_tempo" name="periode" class="form-control date date-picker" value="<?php echo "$period"; ?>" data-date="2016-02-29" data-date-format="yyyy-mm-dd" />
                      </div>
                    </div>
                  </div>
                  <!--/span-->

                  <div class="col-md-12">
                    <div class="form-group">
                      <hr>
                      <div class="col-md-12">
                        <input type="hidden" id="sid" name="supplier" class="form-control" value="<?php echo $supplier; ?>" required />
                        <input type="hidden" id="coaid" name="coa" class="form-control" value="<?php echo $coa; ?>" required />
                        <button type="submit" class="btn purple"><i class="fa fa-refresh"></i> Refresh</button>
                        <!-- <button type="button" class="btn green"><i class="fa fa-file-excel-o"></i> Excell</button> -->
                        <a href="<?php echo base_url(); ?>Excel/toExcel8?supplier=<?php echo $supplier; ?>&coa=<?php echo $coa; ?>&currency=<?php echo $cur; ?>&periode=<?php echo $period; ?>" class="btn green"><i class="fa fa-file-excel-o"></i> Excel</a>
                        <a href="<?php echo base_url(); ?>Customers_card/toPrintCustomerCard?supplier=<?php echo $supplier; ?>&coa=<?php echo $coa; ?>&currency=<?php echo $cur; ?>&periode=<?php echo $period; ?>" class="btn btn-primary"><i class="fa fa-print"></i> Print</a>


                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <hr />
              <?php
              if (!empty($Get_aging)) {

              ?>
                <table cellpadding="0" cellspacing="0" width="100%" class="table table-bordered table-striped table-condensed flip-content" id="tabel">
                  <thead>
                    <tr>
                      <th>
                        Customer ID
                      </th>
                      <th>
                        Customer Name
                      </th>
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
                      <th>
                        Status
                      </th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <?php

                      foreach ($Get_aging as $v) {
                      ?>
                        <td><?php echo $v->tmp_kodecus; ?></td>
                        <td><?php echo $v->tmp_customer_name; ?></td>
                        <td><?php echo  date('d-m-Y', strtotime(($v->tmp_tanggal))); ?></td>
                        <td><?php echo $v->tmp_uraian; ?></td>
                        <td><?php echo $v->tmp_nojurnal; ?></td>
                        <td style="text-align:right;"><?php echo $v->tmp_debet; ?></td>
                        <td style="text-align:right;"><?php echo $v->tmp_kredit; ?></td>
                        <td style="text-align:right;"><?php echo $v->tmp_balance; ?></td>
                        <?php
                        $huruf = substr($v->tmp_nojurnal, 0, 1);
                        if ($huruf == 'R') {
                        ?>
                          <td style="text-align:center;"><a href="<?php echo base_url() . "Customers_card/reviewARpayment?id=" . $v->tmp_nojurnal; ?>" style="background-color:red;color:#fff;padding: 0 15px 0 15px;text-decoration: none;" target="_BLANK">Paid</a></td>
                        <?php
                        } else {
                          echo '<td style="text-align:center;"></td>';
                        }
                        ?>
                    </tr>
                  <?php
                      }
                  ?>
                  </tbody>
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

<script type="text/javascript">
  $(document).ready(function() {
    $("#tabel").dataTable({
      "scrollY": 400,
      "scrollX": true
    });
  });
</script>