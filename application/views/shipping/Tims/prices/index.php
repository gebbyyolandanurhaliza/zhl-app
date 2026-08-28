<div class="page-content">

  <div class="container-fluid">
    <div class="row ">
      <div class="col-md-12">

        <?= $this->session->flashdata('message'); ?>

        <div class="portlet light">
          <div class="portlet-title">
            <div class="caption">
              <i class="fa fa-table theme-font"></i>
              <span class="caption-subject theme-font uppercase">Master Driver's Price</span>
            </div>
            <div class="actions">
              <?php echo anchor(site_url('Master_Tims/price_add'), '<i class="fa fa-plus"></i> Create New Driver Price', 'class="btn btn-primary"'); ?>
            </div>
          </div>

          <!-- <div class="portlet-body flip-scroll">
						<div class="table-scrollable-borderless"> -->
          <table id="tbl-price" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th width="1px">No</th>
                <th class="text-center">Breakdown Of Driver Wages</th>
                <th class="text-center">Local <br> Per trip</th>
                <th class="text-center">Foreign <br> Per trip</th>
                <th class="text-center">Extra</th>
                <th width="100px">Action</th>
              </tr>
            </thead>
            <tbody>
              <?php
              if ($prices) {
                $no = 1;
                foreach ($prices as $key => $value) : ?>
                  <tr>
                    <td class="text-center"><?= $no++ . '.' ?></td>
                    <td class="text-center"><?= $value->driver_wages ?></td>
                    <td class="text-center">$ <?= number_format($value->local_pertrip, 2) ?></td>
                    <td class="text-center">$ <?= number_format($value->prc_pertrip, 2) ?></td>
                    <?php 
                    $extra = $value->extra_trip;
                    if($extra > 0){?>
                      <td class="text-center" style="color: red;"><b>$ <?= number_format($value->extra_trip, 2) ?></b></td>
                    <?php }else{?>
                      <td class="text-center">$ <?= number_format($value->extra_trip, 2) ?></td>
                    <?php } ?>
                    <td>
                      <?php
                      echo anchor(site_url('Master_Tims/price-edit/' . $value->job_price_id), '<i class="fa fa-edit"></i>', 'class="btn default btn-sm green-stripe"');
                      echo anchor(site_url('Master_Tims/price-delete/' . $value->job_price_id), '<i class="fa fa-trash-o"></i>', 'class="btn default btn-sm red-stripe" onclick="javasciprt: return confirm(\'Are You Sure Delete price ' . $value->driver_wages . '?\')"');
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
    $("#tbl-price").dataTable({});
  });
</script>