<script type="text/javascript">
  function ambilearning() {
    $tahun = $('#period').val();
    $url = "<?php echo base_url(); ?>ClosingEarning/getearning?th=" + $tahun;

    $.ajax({
      url: $url,
      success: function(response) {
        $("#isiini").html(response);
      },
      dataType: "html"
    });
  }
</script>

<?php error_reporting(0); ?>
<!-- BEGIN PAGE CONTENT -->
<div class="page-content">
  <div class="container">

    <!-- BEGIN PAGE CONTENT INNER -->
    <div class="row">

      <?php
      $group = $this->session->userdata('groupid_1');

      if ($group == 1 || $group == 6) {
      ?>

        <div class="col-md-4">
          <!-- BEGIN EXAMPLE TABLE PORTLET-->
          <div class="portlet light">
            <div class="portlet-title">
              <div class="caption">
                <span class="caption-subject theme-font bold uppercase">Closing Earning</span>
              </div>
              <div class="tools">
                <a href="javascript:;" class="collapse">
                </a>
                <a href="#portlet-config" data-toggle="modal" class="config">
                </a>
                <a href="javascript:;" class="reload">
                </a>
                <a href="javascript:;" class="remove">
                </a>
              </div>
            </div>
            <div class="table-body">
              <!-- FORM MASTER GROUP -->
              <div class="form-group">
                <label class="control-label">Choose Period</label>
                <select class="select2me form-control" id="period" onchange="ambilearning()">
                  <?php
                  $tahun = date('Y');
                  $a1 = $tahun - 3;
                  for ($i = 0; $i < 10; $i++) {
                    if ($a1 == $tahun) {
                      echo "<option selected>$a1</option>";
                    } else {
                      echo "<option>$a1</option>";
                    }
                    $a1++;
                  }
                  ?>
                </select>
              </div>
              <!-- FORM MASTER GROUP -->
            </div>
          </div>
          <!-- END EXAMPLE TABLE PORTLET-->
        </div>

        <div class="col-md-8">
          <div class="portlet light">
            <div class="portlet-title">
              <div class="caption">
                <span class="caption-subject theme-font bold uppercase">Data Earning</span>
              </div>
              <div class="tools">
                <a href="javascript:;" class="collapse">
                </a>
                <a href="#portlet-config" data-toggle="modal" class="config">
                </a>
                <a href="javascript:;" class="reload">
                </a>
                <a href="javascript:;" class="remove">
                </a>
              </div>
            </div>
            <div class="table-body">
              <form method="post" action="<?= base_url(); ?>ClosingEarning/Save">
                <div id="isiini">
                </div>

              </form>
            </div>
          </div>
        </div>


        <div class="col-md-12">
          <div class="portlet light">
            <div class="portlet-title">
              <div class="caption">
                <span class="caption-subject theme-font bold uppercase">Data Earning - History</span>
              </div>
              <div class="tools">
                <a href="javascript:;" class="collapse">
                </a>
                <a href="#portlet-config" data-toggle="modal" class="config">
                </a>
                <a href="javascript:;" class="reload">
                </a>
                <a href="javascript:;" class="remove">
                </a>
              </div>
            </div>
            <div class="table-body">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Account Number</th>
                    <th>Debet</th>
                    <th>Kredit</th>
                    <th>Debet SGD</th>
                    <th>Kredit SGD</th>
                    <th>Create By</th>
                  </tr>
                </thead>
                <?php
                if (!empty($_datahistory)) {
                  $no = 1;
                  foreach ($_datahistory as $r) {
                ?>
                    <tr>
                      <td><?= $no; ?></td>
                      <td><?= $r->Coa; ?></td>
                      <td align="right"><?= number_format($r->Debet, 2); ?></td>
                      <td align="right"><?= number_format($r->Kredit, 2); ?></td>
                      <td align="right"><?= number_format($r->DebetSGD, 2); ?></td>
                      <td align="right"><?= number_format($r->KreditSGD, 2); ?></td>
                      <td><?= $r->CreatedBy; ?> , on <?= $r->CreatedDate; ?></td>
                    </tr>
                <?php
                    $no++;
                  }
                }
                ?>

              </table>
            </div>
          </div>
        </div>
      <?php } ?>
      <!-- END PAGE CONTENT -->
    </div>
  </div>
  <!-- END PAGE CONTENT -->