<div class="page-content">
  <div class="container-fluid">
    <div class="row">

      <div class="col-md-12">

        <?php
        echo $message;
        echo form_open(site_url('shipping_instruction_mon_for_zhl/batch_print'), 'target="_blank" method="post" class="form-horizontal"');
        ?>

        <div class="portlet light">

          <div class="portlet-title">
            <div class="caption">
              <i class="fa fa-table theme-font"></i>
              <span class="caption-subject theme-font uppercase">Shipping Instruction Monitor</span>
            </div>
            <div class="tools">
              <a href="javascript:;" class="collapse">
              </a>
              <a href="javascript:;" class="reload">
              </a>
              <a href="javascript:;" class="fullscreen"></a>
            </div>
          </div>

          <div class="portlet-body form">

            <div class="form-body row">
              <div class="col-md-12">

                <div class="panel panel-default">
                  <div class="panel-heading">
                    <h5 class="panel-title"><i class='fa fa-filter'></i> Filter SI</h5>
                  </div>
                  <div class="panel-body">
                    <div class="form-group">
                      <label class="col-md-2 control-label" for="varchar">Search SI By</label>
                      <div class="col-md-7">
                        <input type="text" class="form-control" name="param_si" id="param_si" value="" placeholder="PO Number, Sales Contract No, Factory, Customer" title="Leave blank to show all the data" />
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-md-2 control-label" for="varchar">Shipment Date</label>
                      <div class="col-md-4">
                        <div class="input-group date-picker input-daterange" data-date="<?php echo $current_date ?>" data-date-format="dd/mm/yyyy">
                          <input type="text" class="form-control" id="schedule_date1" name="schedule_date1" value="<?php echo $schedule_date1 ?>" title="date format : dd/mm/yyyy">
                          <span class="input-group-addon" style="background: transparent; border-color: transparent">to</span>
                          <input type="text" class="form-control" id="schedule_date2" name="schedule_date2" value="<?php echo $schedule_date2; ?>" title="date format : dd/mm/yyyy">
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="panel-footer">
                    <input type="button" id="btn_filter" class="btn blue fontawesome-font" value="&#xf0b0 Filter Shipping Instruction">

                  </div>
                </div>

              </div>
            </div>

            <div class="flip-scroll">
              <!--<div class="col-md-12">-->
              <table class="table" style="margin-bottom: 1px;">
                <thead>
                  <tr>
                    <th style="width: 43px; text-align: center;"><input type="checkbox" id="togglecheck"></th>
                    <th style="width: 200px; text-align: center;">Schedule Shipment Date</th>
                    <th style="width: 150px; text-align: left;">Sequence Num.</th>
                    <th style="width: 150px; text-align: left;">Booking Ref</th>
                    <th style="width: 150px; text-align: left;">PO Number</th>
                    <th style="width: 100px; text-align: left;">S.Contract No</th>
                    <th style="width: 100px; text-align: center;">Factory</th>
                    <th style="width: 100px; text-align: left;">Customer</th>
                    <th style="width: 100px; text-align: left;">Ocean Freight</th>
                    <th style="width: 100px; text-align: left;">SBL Fee</th>
                    <th style="width: 100px; text-align: left;">PSS`s Invoice No</th>
                  </tr>
                </thead>
              </table>
              <div class="doc-scroll" style="height: 350px;">
                <div id="filtered_table" class="table-scrollable-borderless">
                  <table id="tblmon_po" class="table table-condensed table-striped">

                    <tbody>
                      <?php
                      if ($record_mon) {
                        foreach ($record_mon as $r) {
                          echo "<tr>";
                          echo "<td style='text-align: center; width:40px;'>";
                          echo "<input type='checkbox' name='chk_si[]' class='chk_si' value='$r->ship_id'>";
                          echo "</td>";
                          echo "<td class='text-center w-200'><div>" . tgl_ind($r->schedule_date) . "</div></td>";
                          echo "<td class='text center w-150'><div>$r->urut_container</div></td>";
                          echo "<td class='text center w-150'><div>$r->reff</div></td>";
                          echo "<td class='text center w-150'><div>$r->po_number</div></td>";
                          echo "<td class='text center w-100'><div>$r->contract_no</div></td>";
                          echo "<td class='text-center w-100'><div>$r->factory_abbr</div></td>";
                          echo "<td class='text-left'><div>$r->customer_company_name</div></td>";
                          echo "<tr>";
                        }
                      }
                      ?>
                    </tbody>
                  </table>
                </div>
              </div>
              <!--</div>-->
            </div>

          </div><!--/.portlet_body -->

          <div class="form-actions">
            <div class="row">
              <div class="col-md-1">
                <button class="btn btn-warning" id="btn_print" type="submit"><i class="fa fa-print"></i> Print Selected...</button>
              </div>
              <div class="col-md-1">
                <a class="btn green" id="btn-excel-vessel" name="action" value="excel" onclick="excel()" target="_blank"><i class="fa fa-file-excel-o"></i> Excel</a>
              </div>


            </div>
          </div>

        </div>

        <?php echo form_close() ?>
      </div>
    </div>
  </div>
</div>

<script>
  //	$('#tblmon_po').dataTable();
  $('#btn_filter').on('click', function() {
    var param = $('#param_si').val();
    var schdate1 = $('#schedule_date1').val();
    var schdate2 = $('#schedule_date2').val();

    sambu.startPageLoading();

    window.setTimeout(function() {
      sambu.stopPageLoading();
    }, 2000);

    $.ajax({
      type: "POST",
      url: "<?php echo site_url('shipping_instruction_mon_for_zhl/monitor_filtered') ?>",
      data: {
        param_search: param,
        schedule_date1: schdate1,
        schedule_date2: schdate2,
      },
      success: function(msg) {
        $('#filtered_table').html(msg);
      }
    })
  });

  function excel() {
    $param = $('#param_si').val();
    $schdate1 = $('#schedule_date1').val();
    $schdate2 = $('#schedule_date2').val();

    javascript: location.href = "<?php echo base_url(); ?>shipping_instruction_mon_for_zhl/monsi_report?param_search=" + $param + "&schedule_date1=" + $schdate1 + "&schedule_date2=" + $schdate2;

  }

  $('#togglecheck').on('click', function() {
    if (this.checked == true) {
      $("input[type=checkbox]").prop('checked', true).uniform();
    } else {
      $("input[type=checkbox]").prop('checked', false).uniform();
    }
  });
</script>