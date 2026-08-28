<link href="<?php echo base_url(); ?>assets/admin/scripts/jquery.autocomplete.css" rel="stylesheet" type="text/css" />


<?php

?>
<div class="page-content">
  <div class="container">
    <!-- BEGIN PAGE CONTENT INNER -->
    <div class="row">

      <div class="col-md-12">
        <div id="error_id"></div>

        <?php echo $message; ?>
        <div class="portlet light">
          <div class="portlet-title">
            <div id="rate2" style="color: #5a7391"></div>
            <div class="caption">
              <i class="fa fa-truck theme-font"></i>
              <span class="caption-subject theme-font">Input Form DKSH Trucking</span>
            </div>
            <div class="form-group">
              <?php if ($this->input->get('id') <> '') { ?>
                <a class="btn btn-primary kanan" href="<?php echo base_url(); ?>Shipping_mon/add_dksh_trucking"><i class="fa fa-plus"></i> Create New</a>
              <?php
              } else {
                // echo "<label class='btn kanan' style='color:red'>Closing Date: " . $tgl . "</label>";
              }
              ?>
            </div>
          </div>
          <div class="portlet-body">
            <form action="<?php echo $action; ?>" id="form1" method="post" irole="form">
              <div class="form-body">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label col-md-3">SHIPPER</label>
                      <div class="col-md-9">
                        <input type="text" id="shipper" name="shipper" value="<?= $shipper ?>" class="form-control" />
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="control-label col-md-3">CNEE</label>
                      <div class="col-md-9">
                        <input type="text" id="cnee" name="cnee" value="<?= $cnee ?>" class="form-control" />
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="control-label col-md-3">PO NUMBER</label>
                      <div class="col-md-9">
                        <input type="text" id="po_number" name="po_number" value="<?= $po_number ?>" class="form-control" />
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="control-label col-md-3">POL</label>
                      <div class="col-md-9">
                        <input type="text" id="pol" name="pol" value="<?= $pol ?>" class="form-control" />
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="control-label col-md-3">CONT</label>
                      <div class="col-md-9">
                        <input type="text" id="cont" name="cont" value="<?= $cont ?>" class="form-control" />
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="control-label col-md-3">HOUSE B/L</label>
                      <div class="col-md-9">
                        <input type="text" id="house_bl" name="house_bl" value="<?= $house_bl ?>" class="form-control" />
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="control-label col-md-3">CONT TYPE</label>
                      <div class="col-md-9">
                        <input type="text" id="cont_type" name="cont_type" value="<?= $cont_type ?>" class="form-control" />
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="control-label col-md-3">ESTD TIME ARR</label>
                      <div class="col-md-9">
                        <input type="text" name="estd_time_arr" id="estd_time_arr" class="form-control date target" value="<?php echo $estd_time_arr; ?>" data-date-format="dd/mm/yyyy" required />
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="control-label col-md-3">ACTUAL TIME ARR</label>
                      <div class="col-md-9">
                        <input type="text" name="actual_time_Arr" id="actual_time_Arr" class="form-control date target" value="<?php echo $actual_time_Arr; ?>" data-date-format="dd/mm/yyyy" required />
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="control-label col-md-3">VESSEL DISCHARGE TIMING</label>
                      <div class="col-md-9">
                        <input type="text" id="vessel_discharge_timing" name="vessel_discharge_timing" value="<?= $vessel_discharge_timing ?>" class="form-control" />
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="control-label col-md-3">TRUCK IN TO YARDS DATE</label>
                      <div class="col-md-9">
                        <input type="text" name="truck_in_to_yards_date" id="truck_in_to_yards_date" class="form-control date target" value="<?php echo $truck_in_to_yards_date; ?>" data-date-format="dd/mm/yyyy" required />
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="control-label col-md-3">TRUCK OUT FM YARDS DATE</label>
                      <div class="col-md-9">
                        <input type="text" name="truck_out_fm_yards_date" id="truck_out_fm_yards_date" class="form-control date target" value="<?php echo $truck_out_fm_yards_date; ?>" data-date-format="dd/mm/yyyy" required />
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="control-label col-md-3">ESTD DETENTION CHARGES</label>
                      <div class="col-md-9">
                        <input type="text" id="estd_detention_charges" name="estd_detention_charges" value="<?= $estd_detention_charges ?>" class="form-control" />
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="control-label col-md-3">ESTD DETENTION DAYS</label>
                      <div class="col-md-9">
                        <input type="text" id="estd_detention_days" name="estd_detention_days" value="<?= $estd_detention_days ?>" class="form-control" />
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="control-label col-md-3">REMARK</label>
                      <div class="col-md-9">
                        <input type="text" id="remarks" name="remarks" value="<?= $remarks ?>" class="form-control" />
                      </div>
                    </div>
                  </div>
                </div>
                <hr />
                <button type="submit" name="sbt" id="btn_update" class="btn btn-primary" value="<?php echo $submit_value; ?>"><i class="fa fa-save"></i> <?php echo $submit_value; ?></button>

                <a class="btn btn-warning" href="<?php echo base_url(); ?>Shipping_mon/dksh_trucking"><i class="fa fa-warning"></i> Cancel</a>

                <div id="demo" style="display: none"></div>
                <hr />

              </div>
          </div>
        </div>
      </div>
      </form>
    </div>
  </div>

</div>

<script src="<?php echo base_url(); ?>assets/admin/scripts/jquery.autocomplete.js" type="text/javascript"></script>
<script type="text/javascript">
  $(document).ready(function() {
    $("#tabel_dpi").dataTable({
      "scrollY": 400,
      "scrollX": true
    });
  });
</script>

<script type="text/javascript">
  $(document).ready(function() {
    var tgl = $('#closing').val();
    $('.target').datepicker({
      'autoclose': true,
      'todayHighlight': !0,
      'startDate': tgl,
      'orientation': "top right",
      'format': ('dd/mm/yyyy')
      // var today = picker.startDate.format('DD/MM/YYYY');
    });
  })
</script>