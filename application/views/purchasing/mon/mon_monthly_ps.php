<?php
$date = date("Y-m-d");
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
              <span class="caption-subject theme-font bold">Monitoring Loading Report</span>
            </div>
            <div class="tools">
              <a href="javascript:;" class="collapse"></a>
              <a href="javascript:;" class="fullscreen"></a>
            </div>
          </div>
          <div class="portlet-body">
            <div class="form-body">
              <div class="col-md-12">
                <div class="row">
                  <div class="col-md-6">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label class="col-md-3 label-sm">Year</label>
                        <div class="col-md-6">
                          <select class="form-control select2me" id="year">
                            <option>SELECT</option>
                            <?php
                            foreach ($year as $r) {
                              echo '<option value="' . $r->year . '">' . $r->year . '</option>';
                            }
                            ?>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="form-group">
                        <div class="col-md-9 col-md-offset-3">
                          <button class="btn btn-sm btn-info col-md-3" id="btn-refresh" onclick="refresh()">Refresh</button>
                          <!-- <a class="btn btn-sm green col-md-3" id="btn-excel" onclick="excel()">Excel</a> -->
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <br>
                <hr>
              </div>

              <div id="tbl-design">
                <div class="table-scrollable">
                  <table class="table table-bordered" id="tblmon">
                    <thead>
                      <tr>
                        <th>LR NO.</th>
                        <th>DOCUMENT DATE</th>
                        <th>SHIPMENT DATE</th>
                        <th>CUSTOMER COMPANY</th>
                        <th>ITEM DESCRIPTION</th>
                        <th>ITEM GROSSWEIGHT</th>
                        <th>ITEM NETWEIGHT</th>
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
    $year = document.getElementById("year").value;

    $.ajax({
      url: "<?php echo base_url(); ?>Packing_do/mon_lr_filter?year=" + $year + "",
      success: function(response) {
        $("#tbl-mon").html(response);
      },
      dataType: "html"
    });

    return false;
  }



  function excel() {
    $year = document.getElementById("year").value;
    $tipe = document.getElementById("tipe").value;
    $cur = document.getElementById("cur").value;
    $cat = document.getElementById("cat").value;
    $catsub = document.getElementById("catsub").value;
    $created = document.getElementById("created").value;
    $filter = document.getElementById("filter").value;

    javascript: location.href = "<?php echo base_url(); ?>Packing_do/mon_monthly_excel?year=" + $year + "&tipe=" + $tipe + "&cur=" + $cur + "&cat=" + $cat + "&sub=" + $catsub + "&filter=" + $filter + "&created=" + $created + "";
  }
</script>