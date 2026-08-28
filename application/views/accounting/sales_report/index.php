<?php
$period = $this->session->userdata('periode_1');
$tgl1 = $period . "/01";
$tgl2 = date_create($tgl1);
$dari = date_format($tgl2, '01-m-Y');
$sampai = date('t-m-Y', strtotime($dari));
?>

<script type="text/javascript">
  function panggildata() {
    var tanggal1 = document.getElementById('from').value;
    var tanggal2 = document.getElementById('to').value;

    // alert(tanggal1);

    $(document).ajaxStart(function() {
      $('#isidisini').html('<p style="text-align:center;"><img src="<?php echo base_url(); ?>assets/pages/img/loading.gif"></p>');
    });
    $.ajax({
      url: "<?php echo base_url(); ?>SalesKGMT/CallData?tanggal1=" + tanggal1 + "&tanggal2=" + tanggal2,
      success: function(response) {
        $('#isidisini').html(response);
      },
      dataType: "html"
    });

  }
</script>

<div class="page-head">
  <div class="container-fluid">
    <!-- BEGIN PAGE TITLE -->
    <div class="page-title">
      <h1>Accounting Report <small>Sales Report</small></h1>
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
              <span class="caption-subject theme-font">Sales Report </span>
            </div>
            <div class="tools">
              <a href="javascript:;" class="collapse"></a>
              <a href="javascript:;" class="reload"></a>
            </div>
          </div>

          <div class="portlet-body">
            <form action="<?php echo base_url(); ?>SalesKGMT/toExcel" method="get">
              <div class="portlet-body">
                <div class="form-body">
                  <!-- Header -->
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
                      <div class="col-md-4">
                        <a type="button" onclick="panggildata()" class="btn purple col-md-3"><i class="fa fa-refresh"></i> Filter</a>
                        <button type="submit" class="btn green"><i class="fa fa-file-excel-o"></i> Excel</button>
                      </div>
                    </div>
                  </div>

                  <hr>

                  <div class="row">
                    <div class="col-md-12">
                      <div id="mutermuter" style="text-align: center;"></div>
                      <div id="isidisini"></div>
                    </div>
                  </div>

                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>