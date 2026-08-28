<?php
$period = $this->input->get("period");
?>
<div class="page-content">

  <div class="container-fluid">
    <div class="row ">
      <div class="col-md-12">

        <?= $this->session->flashdata('message'); ?>

        <div class="portlet light">
          <div class="portlet-title">
            <div class="caption">
              <i class="fa fa-table theme-font"></i>
              <span class="caption-subject theme-font uppercase">Master Public Holiday</span>
            </div>

            <div class="actions">
              <?php echo anchor(site_url('Master_Tims/public_holiday_add'), '<i class="fa fa-plus"></i> Create New Public Holiday', 'class="btn btn-primary"'); ?>
            </div>
          </div>

          <!-- <div class="col-md-12" style="margin: 0; padding: 0;">
              <label class="control-label">Public Holiday Year</label>
              <div class="form-group">
                <div class="col-md-3" style="margin: 0; padding: 0 0 0 0;">
                  <select class="select2me form-control" id="period">
                      <option value="">All Stock</option>
                      <option value="2024">2024</option>
                      <option value="2025">2025</option>
                  </select>
                </div>
                <button style="margin-left: 5px;" class="btn-primary btn blue right" onclick="filteryear()">Filter</button>
              </div>
          </div> -->

          <!-- ini untuk search -->
          <!-- <div class="portlet-body">
            <form action="<?php echo base_url(); ?>Master_Tims/search" method="get">
              <div class="row">
                <div class="col-md-5">
                  <div class="form-group">
                    <label class="control-label col-md-2" style="margin: 0; padding: 0;">Years</label>
                    <div style="display: flex; flex-wrap: wrap;" class="col-md-8">
                        <div class="col-md-8" style="margin: 0; padding: 0 0 0 0;">
                        <select name="period" id="period" class="form-control">
                          <?php
                          for ($i = 2020; $i <= 2030; $i++) { 
                              echo '<option value="' . $i . '"';
                              if ($period == $i) {
                                  echo ' selected';
                              }
                              echo '>' . $i . '</option>';
                          }
                          ?>
                        </select>
                        </div>
                        <div style="text-align: -webkit-right; margin: 0; padding: 0;" class="col-md-8">
                            <button class="btn btn-default"><i class="fa fa-search"></i> Filter</button>
                        </div>
                    </div>
                  </div>
                  <br>
                </div>
              </div>
            </form> 
          </div> -->
          <!-- ini tutup untuk search -->
          <div class="portlet-body">
            <form id="filterForm" action="<?php echo base_url(); ?>Master_Tims/search" method="get">
              <div class="row">
                <div class="col-md-5">
                  <div class="form-group">
                    <label class="control-label col-md-2" style="margin: 0; padding: 0;">Years Picker</label>
                    <div style="display: flex; flex-wrap: wrap;" class="col-md-8">
                      <div class="col-md-8" style="margin: 0; padding: 0;">
                      <!-- <input type="text" name="period" id="period" class="form-control date target" value="<?php echo date('Y'); ?>" data-date-format="yyyy" required /> -->
                      <input type="text" name="period" id="period" class="form-control date target" value="<?php echo $period; ?>" data-date-format="yyyy" required />
                      </div>
                    </div>
                  </div>
                  <br>
                </div>
              </div>
            </form>
          </div>
          <!-- ini filter by tanggal -->
          
                  <!-- ini tutup filter by tanggal -->
          <br>

          <!-- <div class="portlet-body flip-scroll">
						<div class="table-scrollable-borderless"> -->
          <table id="tbl-holiday" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th width="1px">No</th>
                <th class="text-center" width="200px">Date</th>
                <th class="text-center">Description</th>
                <th width="100px">Action</th>
              </tr>
            </thead>
            <tbody class="tbl-year" id="tbl-year">
              <?php
              if ($holiday) {
                $no = 1;
                foreach ($holiday as $key => $value) : ?>
                  <tr>
                    <td class="text-center"><?= $no++ . '.' ?></td>
                    <td class="text-center"><?= tgl_dmy($value->date_holiday) ?></td>
                    <td class="text-center"><?= $value->description ?></td>
                    <td>
                      <?php
                      echo anchor(site_url('Master_Tims/public-holiday-edit/' . $value->public_holiday_id), '<i class="fa fa-edit"></i>', 'class="btn default btn-sm green-stripe"');
                      echo anchor(site_url('Master_Tims/public-holiday-delete/' . $value->public_holiday_id), '<i class="fa fa-trash-o"></i>', 'class="btn default btn-sm red-stripe" onclick="javasciprt: return confirm(\'Are You Sure Delete public holiday ' . $value->description . '?\')"');
                      ?>
                    </td>
                  </tr>
              <?php
                endforeach;
              }
              ?>
            </tbody>
          </table>
          <!-- </div>
                    </div> -->

        </div>
      </div>
    </div>
  </div>
</div>

<script>
  $(document).ready(function() {
    $("#tbl-holiday").dataTable({});
  });
</script>

<script type="text/javascript">
 $(document).ready(function() {
    var currentYear = new Date().getFullYear()
    var tgl = $('#closing').val();
    
    $('.target').datepicker({
        'autoclose': true,
        'todayHighlight': true,
        'startDate': tgl,
        'orientation': "top right",
        'format': 'yyyy',
        'viewMode': 'years',
        'minViewMode': 'years',
        'defaultViewDate': { year: currentYear }
    });
});

// $(document).ready(function() {
//   $('#period').on('change', function() {
//     $('#filterForm').submit();
//   });
// });

$(document).ready(function() {
  if ($('#period').val() == '') {
    var currentDate = new Date();
    var currentYear = currentDate.getFullYear();
    $('#period').datepicker('setDate', new Date(currentYear, 0, 1));
  }
  
  $('#period').on('change', function() {
    $('#filterForm').submit();
  });
});

</script>

