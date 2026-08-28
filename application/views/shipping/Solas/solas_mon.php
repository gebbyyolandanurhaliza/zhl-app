<script>
  $(document).ready(function() {
    $('#shipdate').attr('disabled', true);
    $('#factory').attr('disabled', true);
  });
</script>

<?php
error_reporting(0);
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
              <span class="caption-subject theme-font bold">Solas Document</span>
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
                  <div class="row">
                    <div class="col-md-6">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label class="col-md-2 label-sm">Factory</label>
                          <div class="col-md-6">
                            <select class="form-control select2me" id="factory_tipe">
                              <option></option>
                              <option value="RSUP">Riau Sakti United Plantation</option>
                              <option value="PSG">Pulau Sambu Guntung</option>
                            </select>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-12">
                        <label class="control-label col-md-2">Shipmentdate</label>
                        <div class="col-md-9">
                          <div class="input-group date-picker input-daterange date" data-date-format="dd-mm-yyyy">
                            <input type="text" class="form-control" id="from" name="dari" value="<?php echo date('d-m-Y'); ?>" required>
                            <span class="input-group-addon">
                              to </span>
                            <input type="text" class="form-control" id="to" name="sampai" value="<?php echo date('d-m-Y'); ?>" required>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="form-group">
                          <div class="col-md-9 col-md-offset-2">
                            <button type="button" class="btn btn-primary col-md-3" id="btn-refresh" onclick="refresh()"><i class="fa fa-refresh"></i> Refresh</button>
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
                  <table class="table table-bordered" id="tblmon">
                    <thead>
                      <tr>
                        <th nowrap>Action</th>
                        <th nowrap>No</th>
                        <th nowrap>Transaksi ID</th>
                        <th nowrap>DO Number</th>
                        <th nowrap>Vessel Name</th>
                        <th nowrap>Voyage Number</th>
                        <th nowrap>Signed By</th>
                        <th nowrap>Signed Date</th>
                      </tr>
                    </thead>
                    <tbody id="tbl-mon"></tbody>
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
    $factory_tipe = document.getElementById('factory_tipe').value;
    $dari = document.getElementById('from').value;
    $sampai = document.getElementById('to').value;

    console.log('<?php echo base_url(); ?>Solas/SearchDataSolas?factory_tipe=' + $factory_tipe + '&dari=' + $dari + '&sampai=' + $sampai);

    $.ajax({
      url: "<?php echo base_url(); ?>Solas/SearchDataSolas?factory_tipe=" + $factory_tipe + "&dari=" + $dari + "&sampai=" + $sampai,
      success: function(response) {
        $("#tbl-mon").html(response);
      },
      dataType: "html"
    });

    return false;

  }
</script>