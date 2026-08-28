<script>
  $(document).ready(function() {
    $('#shipdate').attr('disabled', true);
    $('#factory').attr('disabled', true);
    // $('#btn-excel').attr('disabled', true);
    // $('#btn-print').attr('disabled', true);
  });
</script>

<?php
error_reporting(0);
if ($this->input->get('dari') <> '') {
  $period = $this->input->get('tahun');
  $type = $this->input->get('currency');
  $dari = $this->input->get('dari');
  $sampai = $this->input->get('sampai');
  $container_number = $this->input->get('container_number');
  $txtSampai = "A/C for the period ended " . $period;
} else {
  $datestr = date("Y-m-d");
}
?>

<!-- <link href="<?php echo base_url(); ?>assets/admin/css/cloud-admin.css" rel="stylesheet" type="text/css"> -->

<div class="page-content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="portlet light">
          <div class="portlet-title">
            <div class="caption">
              <i class="fa fa-list theme-font"></i>
              <span class="caption-subject theme-font bold">Monitoring License Expiry</span>
            </div>
            <div class="tools">
              <a href="javascript:;" class="collapse"></a>
              <a href="javascript:;" class="fullscreen"></a>
            </div>
          </div>
          <div class="portlet-body">
            <div class="form-body">
              <form action="<?php echo site_url('shipping_mon/container_print_summary'); ?>" method="post" role="form">
                <div class="col-md-12">
                    <div class="note note-success note-bordered">
                      <p>
                        Clear all dates to display all driver license data.
                      </p>
                    </div>
                  <div class="row">
                    <div class="col-md-7">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label class="col-md-2 label-sm">Coe Expiry Date</label>
                          <div class="col-md-4">
                            <div class="input-group date-picker input-daterange" data-date="02-12-2012" data-date-format="dd-mm-yyyy">
                              <input type="text" class="form-control input-sm" id="coe_expiry_date" required>
                            </div>
                          </div>
                        </div>
                      </div>
                      
                      <div class="col-md-12">
                        <div class="form-group">
                          <label class="col-md-2 label-sm">Lifespan Expiry Date</label>
                          <div class="col-md-4">
                            <div class="input-group date-picker input-daterange" data-date="02-12-2012" data-date-format="dd-mm-yyyy">
                              <input type="text" class="form-control input-sm" id="lifespan_expiry_date" required>
                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="col-md-12">
                        <div class="form-group">
                          <label class="col-md-2 label-sm">VPC End Date</label>
                          <div class="col-md-4">
                            <div class="input-group date-picker input-daterange" data-date="02-12-2012" data-date-format="dd-mm-yyyy">
                              <input type="text" class="form-control input-sm" id="vpc_end_date" required>
                            </div>
                          </div>
                        </div>
                      </div>
                      
                      <div class="col-md-12">
                        <div class="form-group">
                          <div class="col-md-9 col-md-offset-2">
                            <button type="button" class="btn btn-primary col-md-3" id="btn-refresh" onclick="refresh()"><i class="fa fa-refresh"></i> Refresh</button>

                            <!-- <a class="btn green col-md-3" id="btn-excel" name="action" value="excel" onclick="excel()"><i class="fa fa-file-excel-o"></i> Excel</a> -->
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <br>
                </div>
              </form>

              <div class="table-scrollable" style="overflow: auto; height: 550px;">
                <div class="table-scrollable">
                  <table class="table table-bordered" id="tbllicense">
                    <thead>
                      <tr>
                        <th nowrap>No</th>
                        <th nowrap>Vehicle No</th>
                        <th nowrap>Vehicle Type</th>
                        <th nowrap>Description</th>
                        <th nowrap>COE Expiry Date</th>
                        <th nowrap>Lifespan Expiry Date</th>
                        <th nowrap>Vehicle Inspection Due Date</th>
                        <th nowrap>Road Tax Expiry Date</th>
                        <th nowrap>VPC End Date</th>
                        <th nowrap>Period Insurence End</th>
                      </tr>
                    </thead>
                    <tbody id="tbl-license"></tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  function refresh() {
    // var dari = document.getElementById('from').value;
    // var sampai = document.getElementById('to').value;
    $coe_expiry = document.getElementById("coe_expiry_date").value;
    $lifespan_expiry = document.getElementById("lifespan_expiry_date").value;
    $vpc_expiry = document.getElementById("vpc_end_date").value;

    $.ajax({
        url: "<?php echo base_url(); ?>shipping_mon/expired_license_filter?coe_expiry_date=" + $coe_expiry + "&lifespan_expiry_date=" + $lifespan_expiry + "&vpc_end_date=" + $vpc_expiry + "",
        // url: "<?php echo base_url(); ?>shipping_mon/expired_license_filter?dari=" + $dari + "&sampai=" + $sampai,
        // data: { from: dari, to: sampai },
        success: function(response) {
            if ($.fn.DataTable.isDataTable("#tbllicense")) {
                $('#tbllicense').DataTable().clear().destroy();
            }
            $("#tbl-license").html(response);
            $("#tbllicense").DataTable({
                "autoWidth": false
            });
        },
        dataType: "html"
    });

    return false;
}


</script>