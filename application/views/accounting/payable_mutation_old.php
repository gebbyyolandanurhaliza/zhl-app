<?php
if ($this->input->get('periode') == '') {
  $supp = '';
  $cur = '';
  $period = date("Y/m");
} else {
  $supp = $this->input->get('supplier');
  $cur = $this->input->get('currency');
  $period = $this->input->get('periode');
}
?>
<!-- IMPORTANT! fullcalendar depends on jquery-ui.min.js for drag & drop support -->
<!-- BEGIN PAGE HEAD -->
<div class="page-head">
  <div class="container-fluid">
    <!-- BEGIN PAGE TITLE -->
    <div class="page-title">
      <h1>Accounting Report <small>Payable Mutation Report</small></h1>
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
              <span class="caption-subject theme-font">Payable Mutation Report</span>
            </div>
            <div class="tools">
              <a href="javascript:;" class="collapse"></a>
              <a href="javascript:;" class="reload"></a>
            </div>
          </div>
          <form action="<?php echo base_url(); ?>Payable_mutation/search" method="get">
            <div class="portlet-body">
              <div class="form-body">
                <div class="row">
                  <div class="col-md-2">
                    <div class="form-group">
                      <label class="control-label col-md-3">Period</label>
                      <div class="col-md-9">
                        <input type="text" id="tgl_tempo" name="periode" class="form-control date date-picker" value="<?php echo $period; ?>" data-date="2016-02" data-date-format="yyyy-mm" required />

                      </div>
                    </div>
                  </div>

                  <!--/span-->
                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="control-label col-md-2">Supplier</label>
                      <div class="col-md-10">
                        <?php
                        $style_kategori = 'class="select2me form-control" id="supplier" ';
                        echo form_dropdown('supplier', $SupplierID, $supp, $style_kategori);
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
                            <button type="submit" class="btn purple kiri"><i class="fa fa-refresh"></i> Refresh</button>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="row">
                          <div class="control-label col-md-9">
                            <!-- <button type="button" class="btn green"><i class="fa fa-file-excel-o"></i> Excel</button> -->
                            <!-- <a href="<?php echo base_url(); ?>Excel/toExcel3?supplier=<?php echo $supp; ?>&currency=<?php echo $cur; ?>&periode=<?php echo $period; ?>" class="btn green"><i class="fa fa-file-excel-o"></i> Excel</a>-->
                          </div>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="row">
                          <div class="control-label col-md-9">
                            <a href="<?php echo base_url(); ?>Payable_mutation/print_report?dari=<?php echo $this->input->get('periode'); ?>&supplier=<?php echo $this->input->get('supplier'); ?>&currency=<?php echo $this->input->get('currency'); ?>" class="btn btn-primary"><i class="fa fa-print"></i> Print</a>
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
          <?php
          if (!empty($get_mutation)) {
          ?>
            <hr />
            <table cellpadding="0" cellspacing="0" width="100%" class="table table-bordered table-striped table-condensed flip-content" id="table">
              <thead>
                <tr>
                  <th>
                    Supplier ID
                  </th>
                  <th>
                    Supplier Name
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
                    Debit Note
                  </th>
                  <th>
                    Credit Note
                  </th>
                  <th>
                    Balance
                  </th>
                  <th>
                    Ending Rate
                  </th>
                </tr>
              </thead>
              <tbody>
                <?php
                $begining = 0;
                $purchase = 0;
                $down_payment = 0;
                $payment = 0;
                $debet_note = 0;
                $kredit_note = 0;
                $sumbalance = 0;
                $grand_total = 0;
                foreach ($get_mutation as $v) {
                  /*$balance = $v->begining_balance + $v->purchase - $v->payment - $v->debet_note + $v->kredit_note;
                                    $begining += $v->begining_balance;
                                    $purchase += $v->purchase;
                                    $down_payment += $v->down_payment;
                                    $payment += $v->payment;
                                    $debet_note += $v->debet_note;
                                    $kredit_note += $v->kredit_note;
                                    $sumbalance += $begining + $purchase + $down_payment + $payment + $debet_note + $kredit_note;
                                    $grand_total += $v->balance_rateakhir;*/
                  $balance = $v->t_begining_balance + $v->t_purchase - $v->t_payment - $v->debet_note + $v->kredit_note;
                  $begining += $v->t_begining_balance;
                  $purchase += $v->t_purchase;
                  $down_payment += $v->t_down_payment;
                  $payment += $v->t_payment;
                  $debet_note += $v->debet_note;
                  $kredit_note += $v->kredit_note;
                  $sumbalance += $begining + $purchase + $down_payment + $payment + $debet_note + $kredit_note;
                  $grand_total += $v->t_balance_rateakhir;
                ?>
                  <tr>
                    <td><?php echo "$v->t_kode_sup"; ?></td>
                    <td><?php echo "$v->t_sup"; ?></td>
                    <td style="text-align: right;"><?php echo number_format($v->t_begining_balance, 2); ?></td>
                    <td style="text-align: right;"><?php echo number_format($v->t_purchase, 2); ?></td>
                    <td style="text-align: right;"><?php echo number_format($v->t_down_payment, 2); ?></td>
                    <td style="text-align: right;"><?php echo number_format($v->t_payment, 2); ?></td>
                    <td style="text-align: right;"><?php echo number_format($v->debet_note, 2); ?></td>
                    <td style="text-align: right;"><?php echo number_format($v->kredit_note, 2); ?></td>
                    <td style="text-align: right;"><?php echo number_format($balance, 2); ?></td>
                    <td style="text-align: right;"><?php echo number_format($v->t_balance_rateakhir, 2); ?></td>
                  </tr>
                <?php
                }
                echo " <tr style='background: #ffffcc'><td colspan='2' style='text-align:right;'><b>Grand Total</b></td>"
                  . "<td style='text-align:right;font-weight: bold;'>" . number_format($begining, 2, '.', ',') . "</td>"
                  . "<td style='text-align:right;font-weight: bold;'>" . number_format($purchase, 2, '.', ',') . "</td>"
                  . "<td style='text-align:right;font-weight: bold;'>" . number_format($down_payment, 2, '.', ',') . "</td>"
                  . "<td style='text-align:right;font-weight: bold;'>" . number_format($payment, 2, '.', ',') . "</td>"
                  . "<td style='text-align:right;font-weight: bold;'>" . number_format($debet_note, 2, '.', ',') . "</td>"
                  . "<td style='text-align:right;font-weight: bold;'>" . number_format($kredit_note, 2, '.', ',') . "</td>"
                  . "<td style='text-align:right;font-weight: bold;'>" . number_format($sumbalance, 2, '.', ',') . "</td>"
                  . "<td style='text-align:right;font-weight: bold;'>" . number_format($grand_total, 2, '.', ',') . "</td></tr>";
                ?>
              </tbody>
            </table>
          <?php
          }
          ?>

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
  </script>