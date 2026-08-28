<div class="page-content">

  <div class="container-fluid">
    <div class="row ">
      <div class="col-md-12">

        <div class="portlet light">
          <div class="portlet-title">
            <div class="caption">
              <i class="fa fa-table theme-font"></i>
              <span class="caption-subject theme-font uppercase">Master Driver</span>
            </div>
            <div class="actions">
              <?php echo anchor(site_url('Master_Tims/driver-add'), '<i class="fa fa-plus"></i> Add New Driver', 'class="btn btn-primary"'); ?>
            </div>
          </div>


          <?php
          if ($this->session->flashdata('message')) {
            echo $this->session->flashdata('message');
          }
          ?>

          <div class="table">
            <table id="tblmst_customer" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th width="1px">No</th>
                  <th class="text-center">Driver Name</th>
                  <th class="text-center">Driver LoginID</th>
                  <th class="text-center">Driver Type</th>
                  <th class="text-center">PSA PASS Number</th>
                  <th class="text-center">PSA PASS EXpired</th>
                  <th class="text-center">PSA PIN</th>
                  <th class="text-center">Diesel PIN</th>
                  <th class="text-center">Handset No</th>
                  <th class="text-center">License Exp</th>
                  <th class="text-center">Created By</th>
                  <th width="30px">Action</th>
                </tr>
              </thead>
              <tbody>
                <?php
                if ($drivers) {
                  $no = 1;
                  foreach ($drivers as $key => $value) : ?>
                    <tr>
                      <td class="text-center"><?= $no++ . '.' ?></td>
                      <td class="text-center"><?= $value->driver_name ?></td>
                      <td class="text-center"><?= $value->driver_loginid ?></td>
                      <td class="text-center"><?php if ($value->driver_type=='prc') {
                        echo 'foreign';
                      }else { echo $value->driver_type; } ?></td>
                      <td class="text-center"><?= $value->psa_pass_number ?></td>
                      <td class="text-center"><?= tgl_dmy($value->psa_pass_exp) ?></td>
                      <td class="text-center"><?= $value->psa_pin ?></td>
                      <td class="text-center"><?= $value->diesel_pin ?></td>
                      <td class="text-center"><?= $value->handset_no ?></td>
                      <td class="text-center"><?= tgl_dmy($value->license_exp) ?></td>
                      <td class="text-center"><?= $value->created_by ?></td>
                      <td>
                        <?php
                        echo anchor(site_url('Master_Tims/driver-edit/' . $value->id_driver), '<i class="fa fa-edit"></i>', 'class="btn default btn-sm green-stripe"');
                        echo anchor(site_url('Master_Tims/driver-delete/' . $value->id_driver), '<i class="fa fa-trash-o"></i>', 'class="btn default btn-sm red-stripe" onclick="javasciprt: return confirm(\'Are You Sure Delete Driver ' . $value->driver_name . '?\')"');
                        ?>
                      </td>
                    </tr>
                <?php
                  endforeach;
                }
                ?>
              </tbody>
            </table>
          </div>

        </div>
      </div>
    </div>
  </div>

</div>

<script type="text/javascript">
  $(document).ready(function() {
    $("#tblmst_customer").dataTable({
      // "sScrollX": "100%", //This is what made my columns increase in size.
      // "bScrollCollapse": true,
      //			"sScrollY": "500px",
      "autoWidth": false
    });
  });
</script>