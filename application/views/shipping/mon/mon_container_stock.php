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
              <span class="caption-subject theme-font bold">Monitoring Container Stock</span>
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
                            <!-- <select class="form-control select2me" id="tipe" onchange="hidecoloumn()"> -->
                            <select class="form-control select2me" id="factory_tipe">
                              <!-- <option value=" ">RSUP and PSG</option> -->
                              <option value="RSUP">RSUP</option>
                              <option value="PSG">PSG</option>
                            </select>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-12">
                        <label class="control-label col-md-2">Period</label>
                        <div class="col-md-9">
                          <div class="input-group date-picker input-daterange date" data-date-format="dd-mm-yyyy">
                            <input type="text" class="form-control" id="from" name="dari" value="<?php echo $dari; ?>" required>
                            <span class="input-group-addon">
                              to </span>
                            <input type="text" class="form-control" id="to" name="sampai" value="<?php echo $sampai; ?>" required>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="form-group">
                          <label class="col-md-2 label-sm">Order By</label>
                          <div class="col-md-6">
                            <div class="input-group">
                              <span class="input-group-addon"><input type="checkbox" id="chk2" onclick="chk2_click()"></span>
                              <select class="form-control select2me" data-placeholder="Factory" name="factory" id="factory">
                                <option value="status_note">Status Container Stock</option>
                                <option value="arrival_date">Arrival Date</option>
                                <option value="container_number">Container Number</option>
                                <option value="container_name">Container Type</option>
                                <option value="free_time_expiry">Free Time Expiry Date</option>
                                <option value="loading_port">Loading Port</option>
                              </select>
                            </div>
                          </div>
                        </div>
                      </div>
                      <!--                                             <div class="col-md-12" id="ref" >
                                                <div class="form-group">
                                                    <label class="col-md-2 label-sm" id="lbl1">Container Number</label>
                                                    <div class="col-md-6">
                                                        <input class="form-control input-sm" type="text" value="" id="container_number">
                                                     </div>
                                                </div>
                                            </div> -->
                      <div class="col-md-12">
                        <div class="form-group">
                          <div class="col-md-9 col-md-offset-2">
                            <button type="button" class="btn btn-primary col-md-3" id="btn-refresh" onclick="refresh()"><i class="fa fa-refresh"></i> Refresh</button>
                            <!-- <a class="btn green col-md-3" id="btn-excel" name="action" value="excel" onclick="excel()" style="display: none"><i class="fa fa-file-excel-o"></i> Excel</a> -->
                            <a class="btn green col-md-3" id="btn-excel" name="action" value="excel" onclick="excel()"><i class="fa fa-file-excel-o"></i> Excel</a>
                            <!-- <a class="btn btn-default col-md-3" id="btn-print" style="display: none" onclick="print()"><i class="fa fa-print" hidden=""></i> Print</a> -->
                            <!--                                                        <a class="btn btn-default col-md-3" id="btn-print" style="" onclick="print()"><i class="fa fa-print" hidden=""></i> Print</a> -->
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
                        <th nowrap>No</th>
                        <th nowrap>Status</th>
                        <th nowrap>Expiry Time Countdown</th>
                        <th nowrap>Container Number</th>
                        <th nowrap>Container Type</th>
                        <th nowrap>Carrier</th>
                        <th nowrap>Loading Port</th>
                        <th nowrap>ETA</th>
                        <th nowrap>Arrival Date</th>
                        <th nowrap>Free Time</th>
                        <th nowrap>Factory</th>
                        <th nowrap>Supplier</th>
                        <th nowrap>Import BL No</th>
                        <th nowrap>Free Time Expiry Date</th>
                        <th nowrap>Remark</th>
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
    $order_by = document.getElementById('factory').value;
    $dari = document.getElementById('from').value;
    $sampai = document.getElementById('to').value;


    // $container_number=document.getElementById('container_number').value;
    // alert($factory_tipe);
    // $shipdate="";
    // $factory="";
    // $chk1=document.getElementById('chk1').checked;
    // $chk2=document.getElementById('chk2').checked;
    // $ref=document.getElementById('bookingref').value;
    // $cont=document.getElementById('container').value;
    // $seal=document.getElementById('sealtxt').value;

    // if($chk1){$shipdate=document.getElementById('shipdate').value;}
    // if($chk2){$factory=document.getElementById('factory').value;}

    // //if ($tipe == 3){$tipe = 2;}

    $.ajax({
      url: "<?php echo base_url(); ?>shipping_mon/mon_container_stock_filter?factory_tipe=" + $factory_tipe + "&order_by=" + $order_by + "&dari=" + $dari + "&sampai=" + $sampai,
      success: function(response) {
        $("#tbl-mon").html(response);
        //cekDtl();
        //hidecoloumn();
      },
      dataType: "html"
    });

    return false;

  }

  function excel() {
    $factory_tipe = document.getElementById('factory_tipe').value;
    $order_by = document.getElementById('factory').value;
    $dari = document.getElementById('from').value;
    $sampai = document.getElementById('to').value;
    //$container_number=document.getElementById('container_number').value;

    // $chk1=document.getElementById('chk1').checked;
    // $chk2=document.getElementById('chk2').checked;

    // if($chk1){$shipdate=document.getElementById('shipdate').value;}
    // if($chk2){$factory=document.getElementById('factory').value;}

    javascript: location.href = "<?php echo base_url(); ?>shipping_mon/container_stock_report?factory_tipe=" + $factory_tipe + "&order_by=" + $order_by + "&dari=" + $dari + "&sampai=" + $sampai;

  }

  function print() {
    $shipdate = "";
    $factory = "";

    $dari = document.getElementById('from').value;
    $sampai = document.getElementById('to').value;

    $chk1 = document.getElementById('chk1').checked;
    $chk2 = document.getElementById('chk2').checked;

    if ($chk1) {
      $shipdate = document.getElementById('shipdate').value;
    }
    if ($chk2) {
      $factory = document.getElementById('factory').value;
    }

    javascript: location.target = "_blank";
    javascript: location.href = "<?php echo base_url(); ?>shipping_mon/container_stock_print_summary?ship=" + $shipdate + "&fac=" + $factory + "";


  }

  function chk1_click() {
    $chk1 = document.getElementById('chk1').checked;

    if ($chk1) {
      $('#shipdate').attr('disabled', false);
    } else {
      $('#shipdate').attr('disabled', true);
    }

    cekDtl();

  }

  function chk2_click() {
    $chk2 = document.getElementById('chk2').checked;

    if ($chk2) {
      $('#factory').attr('disabled', false);
    } else {
      $('#factory').attr('disabled', true);
    }

    cekDtl();

  }

  function btn_print_enable(factory_tipe, chk1, chk2) {
    if (tipe = '3' && (chk1 && chk2)) {
      $('#btn-excel').attr('disabled', false);
      $('#btn-print').attr('disabled', false);
    } else {
      $('#btn-excel').attr('disabled', true);
      $('#btn-print').attr('disabled', true);
    }
  }

  function cekDtl() {
    $tipe = document.getElementById('factory_tipe').value;
    $chk1 = document.getElementById('chk1').checked;
    $chk2 = document.getElementById('chk2').checked;

    var ID_arr = document.getElementsByName("ship[]");
    var ID_length = ID_arr.length;

    if ((ID_length > 0)) {
      btn_print_enable($tipe, $chk1, $chk2);
    } else {
      $('#btn-excel').attr('disabled', true);
      $('#btn-print').attr('disabled', true);
    }
  }

  // function hidecoloumn(){
  //     $tipe=document.getElementById('factory_tipe').value;
  //     var rows = document.getElementById('tblmon').rows;

  //     for (var row = 0; row < rows.length; row++) {
  //         var cols = rows[row].cells;
  //         cols[17].style.display = (($tipe > 1) ? '' : 'none');
  //         cols[18].style.display = (($tipe > 1) ? '' : 'none');
  //         cols[19].style.display = (($tipe > 1) ? '' : 'none');
  //     }

  //     document.getElementById('btn-excel').style.display = (($tipe == 3) ? '' : 'none');
  //     document.getElementById('btn-print').style.display = (($tipe == 3) ? '' : 'none');

  //     if($tipe == 1){
  //         document.getElementById("ref").style.display='';
  //         document.getElementById("con").style.display='none';
  //         document.getElementById("seal").style.display='none';
  //     }else if($tipe ==2){
  //         document.getElementById("ref").style.display='';
  //         document.getElementById("con").style.display='';
  //         document.getElementById("seal").style.display='';
  //     } else{
  //         document.getElementById("ref").style.display='none';
  //         document.getElementById("con").style.display='none';
  //         document.getElementById("seal").style.display='none';
  //     }

  // }
</script>