<?php
error_reporting(0)
?>
<?php
$supp = $this->input->get('supplier');
$cur = $this->input->get('currency');
$period = $this->input->get('periode');
?>
<!-- BEGIN PAGE HEAD -->
<div class="page-head">
  <div class="container-fluid">
    <!-- BEGIN PAGE TITLE -->
    <div class="page-title">
      <h1>Accounting <small>Receivable Mutation Report</small></h1>
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
              <span class="caption-subject theme-font">Receivable Mutation Report</span>
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
                        <input type="text" id="tgl_tempo" name="periode" value="<?php echo $this->session->userdata('periode_1'); ?>" class="form-control date date-picker" data-date="2016/02" data-date-format="yyyy/mm" required />

                      </div>
                    </div>
                  </div>

                  <!--/span-->
                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="control-label col-md-2">Customer</label>
                      <div class="col-md-10">
                        <?php
                        $style_kategori = 'class="select2me form-control" id="supplier" ';
                        echo form_dropdown('supplier', $SupplierID, '', $style_kategori);
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
                        echo form_dropdown('currency', $CurrencyID, '', $style_curreny);
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
                      <div class="col-md-4">
                        <div class="row">
                          <div class="control-label col-md-9">
                            <!-- <button type="button" class="btn green"><i class="fa fa-file-excel-o"></i> Excel</button> -->
                            <a href="<?php echo base_url(); ?>Excel/toExcel4?supplier=<?php echo $supp; ?>&currency=<?php echo $cur; ?>&periode=<?php echo $period; ?>" class="btn green"><i class="fa fa-file-excel-o"></i> Excel</a>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="row">
                          <div class="control-label col-md-9">
                            <button type="button" class="btn btn-primary"><i class="fa fa-print"></i> Print</button>
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