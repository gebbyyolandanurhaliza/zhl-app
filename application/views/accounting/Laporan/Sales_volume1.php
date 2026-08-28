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
                        <?php
                        // $g =$this->input->get('dari');
                        $a = $this->input->get('dari');
                        if ($a != '') {
                        ?>
                          <a href="<?php echo base_url(); ?>Sales_volume/toExcelSalesVolume?dari=<?php echo $this->input->get('dari'); ?>&sampai=<?php echo $this->input->get('sampai'); ?>" class="btn green"><i class="fa fa-file-excel-o"></i> Excel</a>
                        <?php
                        }
                        ?>
                        <!--<button type="button" class="btn btn-primary"><i class="fa fa-print"></i> Print</button>-->
                        <!-- >-->
                      </div>
                    </div>
                  </div>
                  <hr>
                  <?php
                  if (!empty($_tampil_sales)) {
                  ?>
                    <section class="">
                      <div class="contain">

                        <table class="table table-bordered" id="tabel_sv">
                          <thead>
                            <tr class="header">
                              <th width="10%">
                                Customer Account
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
          Shipment Period
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
                    $no = 1;

                    foreach ($_tampil_sales as $value) {
                      $tgl_ship = date_format(date_create($value->shipdate), "d F Y");

                      //if ($value->tmp_debit > 0 or $value->tmp_credit > 0) {
      ?>
        <tr onclick="detail(this)" style="cursor: pointer;">
          <td><?php echo $value->custcompany ?></td>
          <td><?php echo $value->productname  ?></td>
          <td align='right'><?php echo $value->qty ?></td>
          <td align='right'><?php echo $value->unitprice ?></td>
          <td align='right'><?php echo str_replace("$", "", money_format('%(#10n', $value->total)); ?></td>
          <td align='right'><?php echo $tgl_ship ?></td>

          <td align='right'><?php echo $value->sales_id ?></td>

        </tr>
      <?php
                      //}
                    }

      ?>
    </tbody>

    <tfoot>
      <!--  <tr class="tfooter">
                                                        <td colspan='2' align='right'><b>TOTAL</b></td>
                                                        <td align='right'><b><?php /*echo str_replace("$", "", money_format('%(#10n',$totalB)); */ ?></b></td>
                                                        <td align='right'><b><?php /*echo str_replace("$", "", money_format('%(#10n',$totaldebit)); */ ?></b></td>
                                                        <td align='right'><b><?php /*echo str_replace("$", "", money_format('%(#10n',$totalkredit)); */ ?></b></td>
                                                        <td align='right'><b><?php /*echo str_replace("$", "", money_format('%(#10n', $totalnet)); */ ?></b></td>
                                                        <td align='right'><b><?php /*echo str_replace("$", "", money_format('%(#10n', $totalng)); */ ?></b></td>
                                                    </tr>
-->
    </tfoot>
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