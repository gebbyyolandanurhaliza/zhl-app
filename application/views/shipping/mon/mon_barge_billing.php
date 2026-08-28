<?php
$period = $this->session->userdata('periode_1');
$tgl1 = $period . "/01";

if ($this->input->post('type') <> '') {
  $shipdate = $this->input->post('shipdate');
  $factory = $this->input->post('factory');
  $dari = $this->input->post("dari");
  $sampai = $this->input->post("sampai");
  $jenis = $this->input->post("jenis");
  $type = $this->input->post("type");
} else {
  $shipdate = date("d-m-Y");
  $tgl2 = date_create($tgl1);
  $dari = date_format($tgl2, '01-m-Y');
  $sampai = date('t-m-Y', strtotime($dari));
  $jenis = $this->input->post("jenis");
  $factory = $this->input->post('factory');
  $type = $this->input->post("type");
}



?>
<script>
  $(document).ready(function() {
    hidecoloumn()
  });
</script>


<!-- <script src="//code.jquery.com/jquery.min.js"></script> -->
<div class="modal fade" id="modal-select-billing" tabindex="-1" role="basic" data-backdrop="modal" data-keyboard="false" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4>
          <i class="fa fa-pencil-square-o"></i>
          Detail Stuffing
        </h4>
      </div>

      <div id="po_find" class="po_find">
        <div class="modal-body">
          <!-- <div class="spinner text-center"><i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>&nbsp;&nbsp;<span>Loading...</span></div> -->
        </div>
      </div>

      <div class="modal-footer">
        <div class="form-actions">
          <div class="row">
            <div class="col-md-12">
              <button type="reset" data-dismiss="modal" class="btn red">Close</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="page-head">
  <div class="container-fluid">
    <!-- BEGIN PAGE TITLE -->
    <div class="page-title">
      <h1>Shipping<small>Container</small></h1>
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
              <span class="caption-subject theme-font">Barge Billing</span>
            </div>
            <div class="tools">
              <a href="javascript:;" class="collapse"></a>
              <a href="javascript:;" class="reload"></a>
            </div>
          </div>

          <div class="portlet-body">

            <div class="portlet-body">
              <form action="<?php echo base_url(); ?>shipping_mon/search_billing_arr" method="post">
                <div class="form-body">
                  <!-- Header -->


                  <div class="row">
                    <div class="col-md-12">
                      <div class="col-md-5">
                        <label class="control-label col-md-3">Type</label>
                        <div class="col-md-9">
                          <select name="jenis" id="jenis" class="form-control col-md-4" onchange="hidecoloumn()" required>
                            <option value="0" <?= $jenis == "" ? 'selected' : '' ?>>Select</option>
                            <option value="1" <?= $jenis == "1" ? 'selected' : '' ?>>SHIPMENTDATE</option>
                            <option value="2" <?= $jenis == "2" ? 'selected' : '' ?>>MONTHLY</option>
                          </select>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-12">
                      <div class="col-md-5">
                        <label class="control-label col-md-3">Invoice Type</label>
                        <div class="col-md-9">
                          <select name="type" id="type" class="form-control col-md-4" required>
                            <option value="" <?= $type == "" ? 'selected' : '' ?>>Select</option>
                            <option value="1" <?= $type == "1" ? 'selected' : '' ?>>ROUNDTRIP EXPORT</option>
                            <option value="2" <?= $type == "2" ? 'selected' : '' ?>>LOCAL LADEN</option>
                            <option value="3" <?= $type == "3" ? 'selected' : '' ?>>TETRAPAK LADEN</option>
                          </select>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-12">
                      <div class="col-md-5">
                        <label class="control-label col-md-3">Factory</label>
                        <div class="col-md-9">
                          <select name="factory" id="factory" class="form-control col-md-4" required>
                            <option value="" <?= $factory == "" ? 'selected' : '' ?>>Select</option>
                            <option value="1" <?= $factory == "1" ? 'selected' : '' ?>>PSG - PT PULAU SAMBU</option>
                            <option value="3" <?= $factory == "3" ? 'selected' : '' ?>>RSUP - PT RIAU SAKTI UNITED PLANTATIONS</option>
                            <!-- <option value="2" <?= $factory == "2" ? 'selected' : '' ?>>PSKE - PT PULAU SAMBU KUALA ENOK</option> -->

                          </select>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-12">
                      <div class="col-md-5" id="shipdate">
                        <label class="control-label col-md-3">Shipment Date</label>
                        <div class="col-md-9">
                          <div class="input-group date-picker input-daterange" data-date-format="dd-mm-yyyy">
                            <input type="text" class="form-control input-sm date-picker" name="shipdate" id="shipdate" value="<?php echo $shipdate; ?>">
                          </div>
                        </div>
                      </div>

                      <div class="col-md-5" id="periode">
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
                        <button type="submit" class="btn purple col-md-3"><i class="fa fa-refresh"></i>Filter</button>
                        <a href="<?php echo base_url(); ?>shipping_mon/excel_stuffing?shipdate=<?php echo $shipdate; ?>&factory=<?php echo $factory; ?>&type=<?php echo $type; ?> " class="btn green col-md-3"><i class="fa fa-file-excel-o"></i>excel</a>

                      </div>
                    </div>
                  </div>

                  <hr>

                  <div class="row">
                    <div class="col-md-12">
                      <div id="mutermuter" style="text-align: center;"></div>
                      <div class="table-scrollable" style='overflow: auto; height:300px;'>
                        <hr>

                        <?php

                        if ($type == 3) {
                          if (!empty($tetra)) {

                        ?>
                            <section class="table-responsive">
                              <table cellpadding="0" cellspacing="0" width="100%" class="table table-bordered table-striped table-condensed flip-content" id="tabel">
                                <thead>
                                  <tr>
                                    <th rowspan="2" width="4%">Type Of Container</th>
                                    <th rowspan="2" width="6%">CT</th>
                                    <th rowspan="2" width="4%">Freight</th>
                                    <th colspan="2" width="4%">Trucking</th>
                                    <th colspan="2" width="6%">Qty</th>
                                    <th rowspan="2" width="4%">Total freight</th>
                                    <th rowspan="2" width="4%">Total Trucking</th>
                                  </tr>
                                  <tr>
                                    <th width="4%">20'</th>
                                    <th width="4%">40'</th>
                                    <th width="4%">20'</th>
                                    <th width="4%">40'</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <?php
                                  $totbargecost = 0;
                                  $tottruckingcost = 0;
                                  foreach ($tetra as $x) {
                                    if ($x->container_size == 20) {
                                      $totbargecost = $x->c20 * 1300;
                                      $tottruckingcost = $x->c20 * $x->trucking_cost_20;
                                    } else {
                                      $totbargecost = $x->c40 * 1700;
                                      $tottruckingcost = $x->c40 * $x->trucking_cost_40;
                                    }
                                  ?>
                                    <tr onclick="detail(this)" style="cursor: pointer;">
                                      <td hidden><?php echo $x->contid; ?></td>
                                      <td><?php echo $x->stuffing_name; ?></td>
                                      <td><?php echo $x->container_abbr; ?></td>
                                      <td><?php echo 1300; ?></td>
                                      <td><?php echo $x->trucking_cost_20; ?></td>
                                      <td><?php echo $x->trucking_cost_40; ?></td>
                                      <td><?php echo $x->c20; ?></td>
                                      <td><?php echo $x->c40; ?></td>
                                      <td><?php echo $totbargecost; ?></td>
                                      <td><?php echo $tottruckingcost; ?></td>
                                    </tr>


                                  <?php
                                  }
                                  ?>

                                </tbody>


                              </table>
                            </section>
                          <?php
                          }

                          ?>

                          <?php
                        } else if ($type == 2) {
                          if (!empty($local)) {

                          ?>
                            <section class="table-responsive">
                              <table cellpadding="0" cellspacing="0" width="100%" class="table table-bordered table-striped table-condensed flip-content" id="tabel">
                                <thead>

                                  <tr>
                                    <th rowspan="2" width="4%">Type Of Container</th>
                                    <th rowspan="2" width="6%">CT</th>
                                    <th rowspan="2" width="4%">Freight</th>
                                    <th colspan="2" width="4%">Trucking</th>
                                    <th colspan="2" width="6%">Qty</th>
                                    <th rowspan="2" width="4%">Total freight</th>
                                    <th rowspan="2" width="4%">Total Trucking</th>
                                  </tr>
                                  <tr>
                                    <th width="4%">20'</th>
                                    <th width="4%">40'</th>
                                    <th width="4%">20'</th>
                                    <th width="4%">40'</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <?php
                                  $totbargecost = 0;
                                  $tottruckingcost = 0;
                                  foreach ($local as $x) {
                                    if ($x->container_size == 20) {
                                      $totbargecost = $x->c20 * $x->barge_cost;
                                      $tottruckingcost = $x->c20 * $x->trucking_cost_20;
                                    } else {
                                      $totbargecost = $x->c40 * $x->barge_cost;
                                      $tottruckingcost = $x->c40 * $x->trucking_cost_40;
                                    }
                                  ?>
                                    <tr onclick="detail(this)" style="cursor: pointer;">
                                      <td hidden><?php echo $x->contid; ?></td>
                                      <td><?php echo $x->stuffing_name; ?></td>
                                      <td><?php echo $x->container_abbr; ?></td>
                                      <td><?php echo $x->barge_cost; ?></td>
                                      <td><?php echo $x->trucking_cost_20; ?></td>
                                      <td><?php echo $x->trucking_cost_40; ?></td>
                                      <td><?php echo $x->c20; ?></td>
                                      <td><?php echo $x->c40; ?></td>
                                      <td><?php echo $totbargecost; ?></td>
                                      <td><?php echo $tottruckingcost; ?></td>
                                    </tr>

                                <?php
                                  }
                                }

                                ?>

                                </tbody>
                              </table>
                            </section>
                            <?php
                          } else {
                            if (!empty($billing)) {
                            ?>
                              <section class="table-responsive">
                                <table cellpadding="0" cellspacing="0" width="100%" class="table table-bordered table-striped table-condensed flip-content" id="tabel">
                                  <thead>
                                    <tr>
                                      <th rowspan="2" width="4%">Type Of Service</th>
                                      <th rowspan="2" width="4%">20'</th>
                                      <th rowspan="2" width="4%">40'</th>
                                      <th rowspan="2" width="6%">CT</th>
                                      <th rowspan="2" width="4%">BARGE COST PER 20'/40'</th>
                                      <th colspan="2" width="4%">Trucking Cost</th>
                                      <th rowspan="2" width="4%">Total Barge Cost</th>
                                      <th rowspan="2" width="4%">Total Trucking Cost</th>

                                    </tr>
                                    <tr>
                                      <th width="4%">20'</th>
                                      <th width="4%">40'</th>
                                    </tr>
                                  </thead>

                                  <?php
                                  $totbargecost = 0;
                                  $tottruckingcost = 0;
                                  foreach ($billing as  $x) {
                                    if ($x->container_size == 20) {
                                      $totbargecost = $x->c20 * $x->barge_cost;
                                      $tottruckingcost = $x->c20 * $x->trucking_cost_20;
                                    } else {
                                      $totbargecost = $x->c40 * $x->barge_cost;
                                      $tottruckingcost = $x->c40 * $x->trucking_cost_40;
                                    }
                                  ?>

                                    <tr onclick="detail(this)" style="cursor: pointer;">
                                      <td hidden><?php echo $x->contid; ?></td>
                                      <td><?php echo $x->type; ?></td>
                                      <td><?php echo $x->c20; ?></td>
                                      <td><?php echo $x->c40; ?></td>
                                      <td><?php echo $x->container_abbr; ?></td>
                                      <td><?php echo $x->barge_cost; ?></td>
                                      <td><?php echo $x->trucking_cost_20; ?></td>
                                      <td><?php echo $x->trucking_cost_40; ?></td>
                                      <td><?php echo $totbargecost; ?></td>
                                      <td><?php echo $tottruckingcost; ?></td>
                                    </tr>

                                <?php
                                  }
                                }

                                ?>
                                </table>
                              </section>
                            <?php

                          }

                            ?>
                      </div>
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



<script type="text/javascript">
  function getText(el) {
    if (typeof el.textContent === 'string')
      return el.textContent;
    if (typeof el.innerText === 'string')
      return el.innerText;
  }

  function detail(x) {

    $r = x.rowIndex;
    var contid = getText(document.getElementById('tabel').rows[$r].cells[0]);

    // $tipe = document.getElementById('tipe').value;

    var type = $("#type").val();
    // console.log(type);
    //var type = document.getElementById("type").value;

    $.ajax({
      url: "<?php echo site_url('shipping_mon/selectbargebilling'); ?>",
      type: "GET",
      data: {
        "contid": contid,
        "type": type
      },
      success: function(respon) {
        $('#po_find').html(respon);
      }
    });
    $('#modal-select-billing').modal('show');
  }

  function hidecoloumn() {
    var $jenis = document.getElementById('jenis').value;

    if ($jenis == 1) {
      document.getElementById("shipdate").style.display = 'block';
      document.getElementById("periode").style.display = 'none';
    } else if ($jenis == 2) {
      document.getElementById("periode").style.display = 'block';
      document.getElementById("shipdate").style.display = 'none';
    } else {
      document.getElementById("periode").style.display = 'none';
      document.getElementById("shipdate").style.display = 'none';
    }
  }
</script>