<!-- <?php
      if ($this->input->get('periode') <> '') {
        $supp = $this->input->get('supplier');
        $cur = $this->input->get('currency');
        $period = $this->input->get('periode');
      } else {
        $supp = "";
        $cur = "";
        $period = $this->session->userdata('periode_1');
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
              <span class="caption-subject theme-font">Journal Cash Bank</span>
            </div>
            <div class="tools">
              <a href="javascript:;" class="collapse"></a>
              <a href="javascript:;" class="reload"></a>
            </div>
          </div>
          <div class="portlet-body">
            <form action="<?php echo base_url(); ?>Finance_Report/search" method="get">
              <div class="form-body">
                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="control-label col-md-2">Reff Number</label>
                      <div class="col-md-10">
                        <input type="text" name="reffnumber" id="reffnumber" value="" class="form-control">
                      </div>
                    </div>
                  </div>
                  <!--/span-->
                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="control-label col-md-3">Period</label>
                      <div class="col-md-9">
                        <div class="input-group date-picker input-daterange" data-date-format="dd-mm-yyyy">
                          <input type="text" class="form-control input-sm" id="from" name="from" value="">
                          <span class="input-group-addon">
                            to </span>
                          <input type="text" class="form-control input-sm" id="to" name="to" value="">
                        </div>
                      </div>
                    </div>
                  </div>
                  <!--/span-->
                  <div class="col-md-12">
                    <div class="form-group">
                      <hr>
                      <div class="col-md-9">
                        <button type="submit" class="btn purple"><i class="fa fa-refresh"></i> Refresh</button>
                        <!-- <button type="button" class="btn green"><i class="fa fa-file-excel-o"></i> Excell</button> -->
                        <!--   <a href="<?php echo base_url(); ?>Excel/toExcel5?supplier=<?php echo $supp; ?>&currency=<?php echo $cur; ?>&periode=<?php echo $period; ?>" class="btn green"><i class="fa fa-file-excel-o"></i> Excel</a>
                                                <a href="<?php echo base_url(); ?>Payable_invoice/print_report?dari=<?php echo $this->input->get('periode'); ?>&supplier=<?php echo $this->input->get('supplier'); ?>&currency=<?php echo $this->input->get('currency'); ?>" class="btn btn-primary"><i class="fa fa-print"></i> Print</a> -->
                      </div>
                    </div>
                  </div>
                  <hr />
                </div>
              </div>
            </form>
          </div>
          <?php
          if (!empty($_selectHeaderCashBank)) {
          ?>
            <hr />
            <table class="table table-bordered table-striped table-condensed flip-content" id="tabel">
              <thead>
                <tr>
                  <th style="width:70px;">Reff. Number</th>
                  <th style="width:100px;">Date</th>
                  <th style="width:50px;">Code</th>
                  <th style="width:200px;">From/To</th>
                  <th style="width:800px;">Description</th>
                  <th style="width:100px;">Currency</th>
                  <th style="width:100px;">Rate</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($_selectHeaderCashBank as $row) : ?>
                  <tr class="iniThis">
                    <!--<tr data-id="<?php //echo $row->header_id;
                                      ?>" onclick="selectViewDetailCB(this);" class="iniThis">-->
                    <td class="text-uppercase"><?php echo $row->no_reff; ?></td>
                    <td class="text-right"><?php echo date('F, d Y', strtotime($row->date1)); ?></td>
                    <td><?php echo $row->cashbank_code; ?></td>
                    <td><?php echo $row->from_to; ?></td>
                    <td><?php echo $row->trans_description; ?></td>
                    <td class="text-center"><?php echo $row->currency_id; ?></td>
                    <td class="text-right"><?php echo number_format($row->currency_rate, 6, ',', '.'); ?></td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          <?php } ?>
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