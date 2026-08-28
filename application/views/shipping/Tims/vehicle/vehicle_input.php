<style>
  .driver-info {
    background-color: #a1d2ff;
    /* Set the desired background color for driver info */
    color: #000;
    /* Set the desired text color */
  }

  .vpc-info {
    background-color: #edbbc1;
    /* Set the desired background color for VPC info */
    color: #000;
    /* Set the desired text color */
  }

  .insurance-cover {
    background-color: #edd7bb;
    /* Set the desired background color for insurance cover */
    color: #000;
    /* Set the desired text color */
  }

  .txt-vehicle {
    /* Add your custom styles here */
    border: 1px solid #ccc;
    padding: 5px;
    border-radius: 5px;
    /* Add any other styles as needed */
  }
</style>


<div class="page-content">
  <div class="container-fluid">
    <div class="row ">
      <div class="col-md-12">
        <div class="portlet light">
          <div class="portlet-title">
            <div class="caption">
              <i class="fa fa-car theme-font"></i>
              <span class="caption-subject theme-font uppercase"><?php echo $header_title; ?></span>
            </div>

            <div class="tools">
              <a href="javascript:;" class="collapse"></a>
            </div>

          </div>

          <?php echo $this->session->flashdata('message'); ?>

          <div class="portlet-body form" id="save_as_new">
            <form action="<?php echo $action; ?>" method="post" class="form-horizontal" role="form">
              <div class="form-body">
                <div class="col-md-1 pull-right"></div>
                <div class="form-group">
                  <div class="col-md-12">
                    <div class="panel panel-default">
                      <div class="panel-body">

                        <div class="form-group">
                          <label class="col-md-2 control-label" for="varchar">Vehicle No</label>
                          <div class="col-md-3">
                            <input type="text" class="form-control" name="vehicle_no" value="<?php echo $vehicle_no; ?> " required />
                          </div>
                          <label class="col-md-2 control-label" for="varchar">Vehicle Type</label>
                          <div class="col-md-3">
                            <select name="vehicle_type" id="vehicle_type" class="form-control">
                              <option value="">-Select Type-</option>
                              <?php
                              foreach ($vehicle_types as $vh) { ?>
                                <option value="<?= $vh ?>" <?= $vehicle_type == $vh ? 'selected' : '' ?>><?= $vh ?></option>
                              <?php
                              }
                              ?>
                            </select>
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="col-md-2 control-label" for="varchar">Item description</label>
                          <div class="col-md-3">
                            <input type="text" class="form-control" name="description" id="description" value="<?php echo $description; ?>" required />
                          </div>
                          <label class="col-md-2 control-label" for="varchar">Year of Manufacture</label>
                          <div class="col-md-3">
                            <select name="year_manufacture" id="year_manufacture" class="form-control">
                              <option value="">-Select Year-</option>
                              <?php
                              for ($i = 2012; $i <= 2030; $i++) { ?>
                                <option value="<?= $i ?>" <?= $year_manufacture == $i ? 'selected' : '' ?>><?= $i ?></option>
                              <?php
                              }
                              ?>
                            </select>
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="col-md-2 control-label" for="varchar">Engine No</label>
                          <div class="col-md-3">
                            <input type="text" class="form-control" name="engine" value="<?php echo $engine; ?>" required />
                          </div>
                          <label class="col-md-2 control-label" for="varchar">Chassis No</label>
                          <div class="col-md-3">
                            <input type="text" class="form-control" name="chasis" value="<?php echo $chasis; ?>" required />
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="col-md-2 control-label" for="varchar">IU Label No</label>
                          <div class="col-md-3">
                            <input type="text" class="form-control" name="iu_label" value="<?php echo $iu_label; ?>" required />
                          </div>
                          <label class="col-md-2 control-label" for="varchar">Registration Date</label>
                          <div class="col-md-3">
                            <input type="text" class="form-control date date-picker" name="registration_date" value="<?php echo $registration_date; ?>" readonly required />
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="col-md-2 control-label" for="varchar">COE No</label>
                          <div class="col-md-3">
                            <input type="text" class="form-control" name="coe_no" value="<?php echo $coe_no; ?>" required />
                          </div>

                          <label class="col-md-2 control-label" for="varchar">COE Category

                          </label>
                          <div class="col-md-3">

                            <select name="coe_category" id="coe_category" class="form-control" required>
                              <option value="">-Select Type-</option>
                              <?php
                              foreach ($coe_cats as $ceo) { ?>
                                <option value="<?= $ceo ?>" <?= $ceo === $coe_category ? "selected" : '' ?>><?= $ceo ?></option>
                              <?php
                              }
                              ?>
                            </select>
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="col-md-2 control-label" for="varchar">COE Expiry Date</label>
                          <div class="col-md-3">
                            <input type="text" class="form-control date date-picker" name="coe_expiry_date" value="<?php echo $coe_expiry_date; ?>" readonly required />
                          </div>

                          <label class="col-md-2 control-label" for="varchar">Lifespan Expiry Date</label>
                          <div class="col-md-3">
                            <input type="text" class="form-control date date-picker" name="lifespan_expiry_date" value="<?php echo $lifespan_expiry_date; ?>" readonly required />
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="col-md-2 control-label" for="varchar">Vehicle Inspection Due Date</label>
                          <div class="col-md-3">
                            <input type="text" class="form-control  date date-picker" name="vehicle_inspection_due_date" value="<?php echo $vehicle_inspection_due_date; ?>" readonly required />
                          </div>
                          <label class="col-md-2 control-label" for="varchar">Road Tax Expiry Date</label>
                          <div class="col-md-3">
                            <input type="text" class="form-control  date date-picker" name="road_tax_expiry_date" value="<?php echo $road_tax_expiry_date; ?>" readonly required />
                          </div>
                        </div>

                        <div class="form-group">
                          <label class="col-md-2 control-label" for="varchar">Driver</label>
                          <div class="col-md-3">
                            <select name="id_driver" id="id_driver" class="form-control">
                              <option value="">-Select Driver-</option>
                              <?php
                              foreach ($drivers as $dv) { ?>
                                <option value="<?= $dv->id_driver ?>" <?= $dv->id_driver == $id_driver ? 'selected' : '' ?>><?= $dv->driver_name ?></option>
                              <?php
                              }
                              ?>
                            </select>
                          </div>
                        </div>

                      </div>
                    </div>
                  </div>
                </div>

                <div id="vpc">
                  <div class="table-scrollable">
                    <table class="table-bordered table-striped table-condensed table-hover scrollable" id="tbl_vpc" width="100%">
                      <thead>
                        <tr>
                          <th colspan="7" class="vpc-info" nowrap style="text-align:center">VPC INFORMATION </th>
                        </tr>

                        <tr class="double-border-bottom">
                          <th class="text-center">VPC No.</th>
                          <th class="text-center">VPC Type</th>
                          <th class="text-center">VPC Start Date</th>
                          <th class="text-center">VPC End Date</th>
                          <th class="text-center">HV Park No.</th>
                          <th class="text-center">HV Park Address</th>
                          <th class="text-center">HV Park Operator</th>
                        </tr>
                      </thead>
                      <tbody>
                        <td>
                          <input type="text" name="vpc_no" id="vpc_no" class="form-control" value="<?php echo $vpc_no; ?>" required>
                        </td>
                        <td>
                          <select name="vpc_type" id="vpc_type" class="form-control" required>
                            <option value="">-Select Type-</option>
                            <?php
                            foreach ($vpc_types as $vpc) { ?>
                              <option value="<?= $vpc ?>" <?= $vpc_type == $vpc ? 'selected' : '' ?>><?= $vpc ?></option>
                            <?php
                            }
                            ?>
                          </select>
                        </td>
                        <td>
                          <input type="text" name="vpc_start_date" class="form-control  date date-picker" value="<?php echo $vpc_start_date ?>" readonly required></input>
                        </td>
                        <td>
                          <input type="text" name="vpc_end_date" class="form-control  date date-picker" value="<?php echo $vpc_end_date ?>" readonly required></input>
                        </td>
                        <td>
                          <input type="text" name="hv_park_no" id="hv_park_no" class="form-control" value="<?php echo $hv_park_no; ?>" required>
                        </td>
                        <td>
                          <textarea name="hv_park_address" class="form-control" required><?php echo $hv_park_address; ?></textarea>
                        </td>
                        <td>
                          <input type="text" name="hv_park_operator" id="hv_park_operator" class="form-control" value="<?php echo $hv_park_operator; ?>" required>
                        </td>
                      </tbody>
                    </table>
                  </div>

                </div>

                <div id="insurance">
                  <div class="table-scrollable">
                    <table class="table-bordered table-striped table-condensed table-hover scrollable" id="tbl_insurance" width="100%">
                      <thead>
                        <tr>
                          <th colspan="5" class="insurance-cover" style="text-align:center">INSURANCE COVER </th>
                        </tr>

                        <tr class="double-border-bottom">
                          <th class="text-center">Insurance Covered INSURER</th>
                          <th class="text-center">Cover Note Number</th>
                          <th class="text-center">Period of Insurance Start Date</th>
                          <th class="text-center">Period of Insurance End Date</th>
                          <th class="text-center">Insurer Annual Premium Cost</th>
                        </tr>
                      </thead>
                      <tbody>
                        <td>
                          <textarea name="insurance_covered" class="form-control" required><?php echo $insurance_covered; ?></textarea>
                        </td>
                        <td>
                          <input type="text" name="cover_note" id="cover_note" class="form-control" value="<?php echo $cover_note; ?>" required>
                        </td>
                        <td>
                          <input type="text" name="period_insurance_start" class="form-control date date-picker" value="<?php echo $period_insurance_start ?>" readonly required></input>
                        </td>
                        <td>
                          <input type="text" name="period_insurance_end" class="form-control date date-picker" value="<?php echo $period_insurance_end ?>" readonly required></input>
                        </td>
                        <td>
                          <input type="text" name="insurance_cost" class="form-control text-right" value="<?php echo $insurance_cost ?>" onkeypress="return isNumber(event)">
                        </td>
                      </tbody>
                    </table>
                  </div>

                </div>

                <div class="form-actions">
                  <div class="row">
                    <div class="col-md-12">
                      <button type="submit" class="btn green w-100"><?php echo $button ?></button>
                      <a href="<?php echo site_url('Master_Tims/vehicle_information') ?>" class="btn red"><i class="fa fa-close"></i> Cancel</a>
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

<script>
  $('.date-picker').datepicker({
    format: 'dd/mm/yyyy',
    autoclose: true
  });
  // $(document).ready(function() {

  // 	$("#search").keyup(function() {
  // 		_this = this;
  // 		$.each($("#tbl_coa tbody tr"), function() {
  // 			if ($(this).text().toLowerCase().indexOf($(_this).val().toLowerCase()) === -1)
  // 				$(this).hide();
  // 			else
  // 				$(this).show();
  // 		});

  // 	});

  // });
</script>