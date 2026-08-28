<script>
  $(document).ready(function() {
    $('#shipdate').attr('disabled', true);
    $('#shipmonth').attr('disabled', true);
    $('#factory').attr('disabled', true);
    $('#btn-excel').attr('disabled', true);
    $('#btn-excel-inward').attr('disabled', true);
    $('#btn-excel-vessel').attr('disabled', true);
    $('#btn-print').attr('disabled', true);
  });
</script>

<!-- <link href="<?php echo base_url(); ?>assets/admin/css/cloud-admin.css" rel="stylesheet" type="text/css"> -->

<div class="page-content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="portlet light">
          <div class="portlet-title">
            <div class="caption">
              <i class="fa fa-list theme-font"></i>
              <span class="caption-subject theme-font bold">Monitoring Container</span>
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
                          <label class="col-md-2 label-sm">Tipe</label>
                          <div class="col-md-4">
                            <select class="form-control select2me" id="tipe" onchange="hidecoloumn()">
                              <option value="1">Container Outward</option>
                              <option value="2">Container Inward</option>
                              <option value="3">Summary Report</option>
                            </select>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="form-group">
                          <label class="col-md-2 label-sm">Shipment Date</label>
                          <div class="col-md-4">
                            <div class="input-group">
                              <span class="input-group-addon"><input type="checkbox" id="chk1" onclick="chk1_click()"></span>
                              <input type="text" class="form-control input-sm date-picker" data-date="02-12-2012" data-date-format="dd-mm-yyyy" name="shipdate" id="shipdate" value="<?php echo date("d-m-Y"); ?>">
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="form-group">
                          <label class="col-md-2 label-sm">Month Shipment Date</label>
                          <div class="col-md-4">
                            <div class="input-group">
                              <span class="input-group-addon"><input type="checkbox" id="chm" onclick="chk_month()"></span>
                              <input type="text" class="form-control input-sm date-picker" data-date="02-12-2012" data-date-format="dd-mm-yyyy" name="shipmonth" id="shipmonth" value="<?php echo date("d-m-Y"); ?>">
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="form-group">
                          <label class="col-md-2 label-sm">Factory</label>
                          <div class="col-md-6">
                            <div class="input-group">
                              <span class="input-group-addon"><input type="checkbox" id="chk2" onclick="chk2_click()"></span>
                              <select class="form-control select2me" data-placeholder="Factory" name="factory" id="factory">
                                <option value=""></option>
                                <?php
                                foreach ($factory as $r) {
                                  echo '<option value="' . $r->factory_id . '">' . $r->factory_name . '</option>';
                                }
                                ?>
                              </select>
                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="col-md-12" id="ref">
                        <div class="form-group">
                          <label class="col-md-2 label-sm" id="lbl1">Booking Ref</label>
                          <div class="col-md-6">
                            <input class="form-control input-sm" type="text" value="" id="bookingref">
                          </div>
                        </div>
                      </div>

                      <div class="col-md-12" id="ves">
                        <div class="form-group">
                          <label class="col-md-2 label-sm" id="lbl1">Vessel</label>
                          <div class="col-md-6">
                            <input class="form-control input-sm" type="text" value="" id="vessel">
                          </div>
                        </div>
                      </div>

                      <div class="col-md-12" id="con" style="display: none">
                        <div class="form-group">
                          <label class="col-md-2 label-sm" id="lbl1">Container</label>
                          <div class="col-md-6">
                            <input class="form-control input-sm" type="text" value="" id="container">
                          </div>
                        </div>
                      </div>

                      <div class="col-md-12" id="seal" style="display: none">
                        <div class="form-group">
                          <label class="col-md-2 label-sm" id="lbl1">Seal</label>
                          <div class="col-md-6">
                            <input class="form-control input-sm" type="text" value="" id="sealtxt">
                          </div>
                        </div>
                      </div>

                      <div class="col-md-12">
                        <div class="form-group">
                          <div class="col-md-12 col-md-offset-2">
                            <button type="button" class="btn btn-primary col-md-2" id="btn-refresh" onclick="refresh()"><i class="fa fa-refresh"></i> Refresh</button>

                            <a class="btn green col-md-2" id="btn-excel-vessel" name="action" value="excel" onclick="excel_vessel()" target="_blank"><i class="fa fa-file-excel-o"></i> Vessel Voyage</a>

                            <a class="btn green col-md-2" id="btn-excel-inward" name="action" value="excel" onclick="excel_inward()" style="display: none" target="_blank"><i class="fa fa-file-excel-o"></i>Excel Inward</a>

                            <a class="btn green col-md-2" id="btn-excel" name="action" value="excel" onclick="excel()" style="display: none" target="_blank"><i class="fa fa-file-excel-o"></i> Excel Summary</a>

                            <a class="btn btn-default col-md-2" id="btn-print" style="display: none" onclick="print()" target="_blank"><i class="fa fa-print" hidden=""></i> Print</a>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <br>
                </div>
              </form>
              <div id="tbl-mon">
                <div class="table-scrollable" style="overflow: auto; height: 550px;" >
                  <div class="table-scrollable">
                    <table class="table table-bordered" id="tblmon">
                      <thead>
                        <tr>
                          <th nowrap>Shipment Date</th>
                          <th nowrap>Factory</th>
                          <th nowrap>Vessel (Barge)</th>
                          <th nowrap>To</th>
                          <th nowrap>From</th>
                          <th nowrap>PO Number</th>
                          <th nowrap>Buyer</th>
                          <th nowrap>Shipper/Carrier</th>
                          <th nowrap>FCL</th>
                          <th nowrap>Destination</th>
                          <th nowrap>Booking Ref</th>
                          <th nowrap>Vessel/Voyage</th>
                          <th nowrap>Depot</th>
                          <th nowrap>POD</th>
                          <th nowrap>OP Code</th>
                          <th nowrap>ETD Sin</th>
                          <th nowrap>ETA</th>
                          <th style='display:none;'>Container</th>
                          <th style='display:none;'>(Actual) Seal</th>
                          <th style='display:none;'>Weight</th>
                          <th nowrap>Stuffing</th>
                          <th nowrap>Bill Status</th>
                        </tr>
                      </thead>
                      <tbody ></tbody>
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
</div>

<script>
  function refresh() {
    $tipe = document.getElementById('tipe').value;
    $shipdate = "";
    $factory = "";
    $shipmonth = "";
    $chk1 = document.getElementById('chk1').checked;
    $chk2 = document.getElementById('chk2').checked;
    $chm = document.getElementById('chm').checked;
    $ref = document.getElementById('bookingref').value;
    $cont = document.getElementById('container').value;
    $seal = document.getElementById('sealtxt').value;
    $ves = document.getElementById('vessel').value;


    if ($chk1) {
      $shipdate = document.getElementById('shipdate').value;
    }
    if ($chk2) {
      $factory = document.getElementById('factory').value;
    }
    if ($chm) {
      $shipmonth = document.getElementById('shipmonth').value;
    }

    if ($tipe == 3) {
      $tipe = 2;
    }

    $.ajax({
      url: "<?php echo base_url(); ?>shipping_mon/mon_shipping_liner_filter?tipe=" + $tipe + "&ship=" + $shipdate + "&fac=" + $factory + "&ref=" + $ref + "&cont=" + $cont + "&seal=" + $seal + "&ves=" + $ves + "&shipmonth=" + $shipmonth,
      success: function(response) {
        $("#tbl-mon").html(response);
        cekDtl();
        hidecoloumn();
      },
      dataType: "html"
    });

    return false;

  }

  function excel() {
    $shipdate = "";
    $factory = "";
    $shipmonth = "";
    $chk1 = document.getElementById('chk1').checked;
    $chk2 = document.getElementById('chk2').checked;
    $chm = document.getElementById('chm').checked;
    $ves = document.getElementById('vessel').value;


    if ($chk1) {
      $shipdate = document.getElementById('shipdate').value;
    }
    if ($chk2) {
      $factory = document.getElementById('factory').value;
    }
    if ($chm) {
      $shipmonth = document.getElementById('shipmonth').value;
    }

    javascript: location.href = "<?php echo base_url(); ?>shipping_mon/summary_report?ship=" + $shipdate + "&fac=" + $factory + "&ves=" + $ves + "&shipmonth=" + $shipmonth;

  }

  function excel_inward() {
    $tipe = document.getElementById('tipe').value;
    $shipdate = "";
    $shipmonth = "";
    $factory = "";
    $chk1 = document.getElementById('chk1').checked;
    $chk2 = document.getElementById('chk2').checked;
    $ref = document.getElementById('bookingref').value;
    $cont = document.getElementById('container').value;
    $seal = document.getElementById('sealtxt').value;
    $chm = document.getElementById('chm').checked;

    if ($chk1) {
      $shipdate = document.getElementById('shipdate').value;
    }
    if ($chk2) {
      $factory = document.getElementById('factory').value;
    }
    if ($chm) {
      $shipmonth = document.getElementById('shipmonth').value;
    }

    // javascript:location.href="<?php echo base_url(); ?>shipping_mon/inward_report?ship=" + $shipdate + "&fac=" + $factory + "";

    javascript: location.href = "<?php echo base_url(); ?>shipping_mon/inward_report?tipe=" + $tipe + "&ship=" + $shipdate + "&fac=" + $factory + "&ref=" + $ref + "&cont=" + $cont + "&seal=" + $seal + "&shipmonth=" + $shipmonth + "";
  }

  function excel_vessel() {
    $shipdate = "";
    $shipmonth = "";
    $factory = "";
    $chk1 = document.getElementById('chk1').checked;
    $chk2 = document.getElementById('chk2').checked;
    $ves = document.getElementById('vessel').value;
    $chm = document.getElementById('chm').checked;

    if ($chk1) {
      $shipdate = document.getElementById('shipdate').value;
    }
    if ($chk2) {
      $factory = document.getElementById('factory').value;
    }
    if ($chm) {
      $shipmonth = document.getElementById('shipmonth').value;
    }

    javascript: location.href = "<?php echo base_url(); ?>shipping_mon/summary_vessel_report?ship=" + $shipdate + "&fac=" + $factory + "&ves=" + $ves + "&shipmonth=" + $shipmonth;

  }

  function print() {
    $shipdate = "";
    $factory = "";
    $chk1 = document.getElementById('chk1').checked;
    $chk2 = document.getElementById('chk2').checked;
    $ves = document.getElementById('vessel').value;


    if ($chk1) {
      $shipdate = document.getElementById('shipdate').value;
    }
    if ($chk2) {
      $factory = document.getElementById('factory').value;
    }

    javascript: location.target = "_blank";
    javascript: location.href = "<?php echo base_url(); ?>shipping_mon/container_print_summary?ship=" + $shipdate + "&fac=" + $factory + "&ves=" + $ves;


  }

  function chk1_click() {
    $chk1 = document.getElementById('chk1').checked;

    if ($chk1) {
      $('#shipdate').attr('disabled', false);
      $('#chm').attr('disabled', true);
    } else {
      $('#shipdate').attr('disabled', true);
      $('#chm').attr('disabled', false);

    }

    cekDtl();

  }

  function chk_month() {
    $chk1 = document.getElementById('chm').checked;

    if ($chk1) {
      $('#shipmonth').attr('disabled', false);
      $('#chk1').attr('disabled', true);

    } else {
      $('#chk1').attr('disabled', false);
      $('#shipmonth').attr('disabled', true);
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

  function btn_print_enable(tipe, chk1, chk2, chm) {
    if (tipe = '3' && ((chk1 && chk2) || (chk2 && chm))) {
      $('#btn-excel').attr('disabled', false);
      $('#btn-print').attr('disabled', false);
      $('#btn-excel-inward').attr('disabled', false);
      $('#btn-excel-vessel').attr('disabled', false);
    } else {
      $('#btn-excel').attr('disabled', true);
      $('#btn-print').attr('disabled', true);
      $('#btn-excel-inward').attr('disabled', true);
      $('#btn-excel-vessel').attr('disabled', true);
    }
  }

  function cekDtl() {
    $tipe = document.getElementById('tipe').value;
    $chk1 = document.getElementById('chk1').checked;
    $chk2 = document.getElementById('chk2').checked;
    $chm = document.getElementById('chm').checked;

    var ID_arr = document.getElementsByName("ship[]");
    var ID_length = ID_arr.length;

    if ((ID_length > 0)) {
      btn_print_enable($tipe, $chk1, $chk2, $chm);
    } else {
      $('#btn-excel').attr('disabled', true);
      $('#btn-print').attr('disabled', true);
      $('#btn-excel-inward').attr('disabled', true);
      $('#btn-excel-vessel').attr('disabled', true);
    }
  }

  function hidecoloumn() {
    $tipe = document.getElementById('tipe').value;
    var rows = document.getElementById('tblmon').rows;

    for (var row = 0; row < rows.length; row++) {
      var cols = rows[row].cells;
      cols[17].style.display = (($tipe > 1) ? '' : 'none');
      cols[18].style.display = (($tipe > 1) ? '' : 'none');
      cols[19].style.display = (($tipe > 1) ? '' : 'none');
    }

    document.getElementById('btn-excel-inward').style.display = (($tipe == 2) ? '' : 'none');
    // document.getElementById('btn-excel-vessel').style.display = (($tipe == 2) ? '' : 'none');
    document.getElementById('btn-excel').style.display = (($tipe == 3) ? '' : 'none');
    document.getElementById('btn-print').style.display = (($tipe == 3) ? '' : 'none');

    if ($tipe == 1) {
      document.getElementById("ref").style.display = '';
      document.getElementById("con").style.display = 'none';
      document.getElementById("seal").style.display = 'none';
    } else if ($tipe == 2) {
      document.getElementById("ref").style.display = '';
      document.getElementById("con").style.display = '';
      document.getElementById("seal").style.display = '';
    } else {
      document.getElementById("ref").style.display = 'none';
      document.getElementById("con").style.display = 'none';
      document.getElementById("seal").style.display = 'none';
    }

  }
</script>