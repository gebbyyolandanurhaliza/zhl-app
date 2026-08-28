<div class="page-content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="portlet light">
          <div class="portlet-title">
            <div class="caption">
              <i class="fa fa-list theme-font"></i>
              <span class="caption-subject theme-font bold"><?= $title ?></span>
            </div>

            <div class="tools">
              <a href="javascript:;" class="collapse"></a>
              <a href="javascript:;" class="fullscreen"></a>
            </div>
          </div>

          <?php echo $this->session->flashdata('message'); ?>

          <a type="reset" class="btn btn-primary kanan" href="<?php echo base_url(); ?>Master_Tims/vehicle_input"><i class="fa fa-plus"></i> Create New</a>
          <div class="portlet-body">
            <div class="form-body">

              <div class="row">
                <div class="col-md-5">
                  <div class="table">
                    <table id="tbl-info" class="table table-bordered table-striped">
                      <thead>
                        <tr>
                          <th>No</th>
                          <th>Vehicle No</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        if (!empty($List_Vehicle)) {
                          $no = 1;
                          foreach ($List_Vehicle as $s) {
                        ?>
                            <tr class="vehicle-row" data-vehicle="<?php echo $s->id_vehicle; ?>" style="cursor: pointer;">
                              <td><?= $no++ . '.' ?></td>
                              <td><?php echo $s->vehicle_no; ?></td>
                            </tr>

                        <?php
                          }
                        }
                        ?>
                      </tbody>
                    </table>
                  </div>
                </div>
                <div class="col-md-7">
                  <div class="table-scrollable timeline-shipment" style="overflow: auto; height: 550px;">
                    <div class="loading" style="display: flex; align-items: center; justify-content: center;"></div>
                    <div class="load-timeline" style="padding: 20px ;">

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
</div>
</div>
<script>
  $(document).ready(function() {


    $("#tbl-info").dataTable({
      // "sScrollX": "100%", //This is what made my columns increase in size.
      // "bScrollCollapse": true,
      // //			"sScrollY": "500px",
      // "autoWidth": false
    });


    //$('.vehicle-row').on('click', function() {
    $(document).on('click', '.vehicle-row', function() {

      // Get the clicked vehicle number
      var id = $(this).data('vehicle');


      $(".timeline-shipment .loading").html("<h2>Loading ...</h2>").show();
      $(".timeline-shipment .load-timeline").empty();
      $.ajax({
        url: "<?php echo base_url('Master_Tims/vehicle_detail'); ?>",
        type: "GET",
        data: {
          'id': id
        },
        dataType: "JSON",
        beforeSend: function() {
          // $('.btn-refresh').html("Loading ...").prop('disabled', true);
          // $(".list-container tbody").empty();
          $(".timeline-shipment .load-timeline").empty();
        },
        success: function(val) {

          setTimeout(function() {
            // Hide loading indicator
            $(".timeline-shipment .loading").hide();

            var driver = "";

            if (val.id_driver != '') {
              driver = `<li>
                                   <table class="table table-bordered">
                                   <thead><tr><th>DRIVER INFORMATION</th></tr></thead>
                                   <tbody>
                                   <tr><td>Driver</td><td> ${val.driver_name}</td></tr>
                                   <tr><td>PSA Pass / Expired</td><td> ${val.psa_pass_number} / ${formatDate(val.psa_pass_exp)}</td></tr>
                                   <tr><td>PSA PIN</td><td> ${val.psa_pin}</td></tr>
                                   <tr><td>Diesel PIN</td><td> ${val.diesel_pin}</td></tr>
                                   <tr><td>Handset No.</td><td> ${val.handset_no}</td></tr>
                                   <tr><td>License Expired Date</td><td> ${formatDate(val.license_exp)}</td></tr>
                                </li>`;
            };

            var html = `
                            <br>
                            <div class="mb-5">
                              <a type="reset" class="btn btn-success kanan" href="<?php echo base_url(); ?>Master_Tims/vehicle_edit/${id}"><i class="fa fa-pencil"></i></a>
                              <a type="reset" class="btn btn-danger kanan" href="<?php echo base_url(); ?>Master_Tims/vehicle_delete/${id}" onclick="return confirm('Are you sure to delete this data ?')" ><i class="fa fa-trash"></i></a>
                            </div>
                            <ul class="vehicle-info">
                               <li>
                                   <table class="table table-bordered">
                                   <thead>
                                      <tr><th>VEHICLE INFORMATION</th></tr>
                                   </thead>
                                   <tbody>
                                   <tr><td>Vehicle No. </td><td> ${val.vehicle_no}</td></tr>
                                   <tr><td>Vehicle Type</td><td> ${val.vehicle_type}</td></tr>
                                   <tr><td>Item description(make and model)</td><td> ${val.description}</td></tr>
                                   <tr><td>Year of Manufacture</td><td>${val.year_manufacture}</td></tr>
                                   <tr><td>Engine No.</td><td>${val.engine}</td></tr>
                                   <tr><td>Chassis No.</td><td>${val.chasis}</td></tr>
                                   <tr><td>IU Label No.</td><td>${val.iu_label}</td></tr>
                                   <tr><td>Registration Date</td><td>${formatDate(val.registration_date)}</td></tr>
                                   <tr><td>COE No.</td><td>${val.coe_no}</td></tr>
                                   <tr><td>COE Category</td><td>${val.coe_category}</td></tr>
                                   <tr><td>COE Expiry Date</td><td>${formatDate(val.coe_expiry_date)}</td></tr>
                                   <tr><td>Lifespan Expiry Date</td><td>${formatDate(val.lifespan_expiry_date)}</td></tr>
                                   <tr><td>Vehicle Inspection Due Date</td><td>${formatDate(val.vehicle_inspection_due_date)}</td></tr>
                                   <tr><td>Road Tax Expiry Date</td><td>${formatDate(val.road_tax_expiry_date)}</td></tr>
                                </li>
                                ${driver}
                                  <li>
                                       <table class="table table-bordered">
                                       <thead class="text-center"><tr><th>VPC INFORMATION</th></tr></thead>
                                       <tbody>
                                       <tr><td>VPC No.</td><td>${ val.vpc_no }</td></tr>
                                       <tr><td>VPC Type</td><td>${ val.vpc_type }</td></tr>
                                       <tr><td>VPC Start Date</td><td>${ formatDate(val.vpc_start_date) }</td></tr>
                                       <tr><td>VPC End Date</td><td>${ formatDate(val.vpc_end_date) }</td></tr>
                                       <tr><td>HV Park No.</td><td>${ val.hv_park_no }</td></tr>
                                       <tr><td>HV Park Address</td><td>${ val.hv_park_address }</td></tr>
                                       <tr><td>HV Park Operator</td><td>${ val.hv_park_operator }</td></tr>
                                  </li>

                                    <li>
                                        <table class="table table-bordered">
                                        <thead class="text-center"><tr><th>INSURANCE COVER</th></tr></thead>
                                        <tbody>
                                        <tr><td>Insurance Covered INSURER</td><td> ${val.insurance_covered}</td></tr>
                                        <tr><td>Cover Note Number</td><td> ${val.cover_note}</td></tr>
                                        <tr><td>Period of Insurance Start Date</td><td> ${formatDate(val.period_insurance_start)}</td></tr>
                                        <tr><td>Period of Insurance End Date</td><td> ${formatDate(val.period_insurance_end)}</td></tr>
                                        <tr><td>Insurer Annual Premium Cost</td><td> $ ${val.insurance_cost}</td></tr>
                                    </li>
                            `;

            // Append the data to .load-timeline
            $(".timeline-shipment .load-timeline").html(html);

          }, 1000);
        },
        error: function(xhr, status, error) {
          console.error(xhr.responseText);

          // Hide loading indicator in case of an error
          $(".timeline-shipment .loading").hide();
        }
      });
    });
  });

  function formatDate(dateString) {
    if (!dateString) {
      return ''; // Handle empty date string if needed
    }

    // Create a Date object from the string
    var date = new Date(dateString);

    // Extract the components (year, month, day)
    var year = date.getFullYear();
    var month = date.toLocaleString('en-US', {
      month: 'long'
    });
    var day = ('0' + date.getDate()).slice(-2);

    // Format the date as "YYYY Month DD"
    var formattedDate = year + ' ' + month + ' ' + day;

    return formattedDate;
  }
</script>