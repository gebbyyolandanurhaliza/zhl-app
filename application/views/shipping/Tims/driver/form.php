<link href="<?php echo base_url(); ?>assets/admin/scripts/jquery.autocomplete.css" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url(); ?>assets/admin/scripts/jquery.autocomplete.js" type="text/javascript"></script>

<div class="page-content">

	<div class="container-fluid">
		<div class="row ">
			<div class="col-md-12">

				<div class="portlet light">
					<div class="portlet-title">
						<div class="caption">
							<i class="fa fa-user theme-font"></i>
							<span class="caption-subject theme-font uppercase"><?php echo $header_title; ?></span>
						</div>
						<div class="tools">
							<a href="javascript:;" class="collapse"></a>
						</div>
					</div>


					<?php
					if ($this->session->flashdata('message')) {
						echo $this->session->flashdata('message');
					}
					?>

					<div class="portlet-body form">
						<form action="<?php echo $action; ?>" method="post" class="form-horizontal" role="form" id="form_customer">

							<div class="form-body row">
								<div class="col-md-7">
									<div class="form-group required">
										<label class="col-md-3 control-label" for="varchar">Driver Name</label>
										<div class="col-md-8">
											<input required type="text" class="form-control" name="driver_name" id="driver_name" value="<?= $driver_name ?>" />
										</div>
										<span class="help-inline"><?php echo form_error('driver_name') ?></span>
									</div>

									<div class="form-group required">
										<label class="col-md-3 control-label" for="varchar">Driver Login ID</label>
										<div class="col-md-8">
											<input required type="text" class="form-control" name="driver_loginid" id="driver_loginid" value="<?= $driver_loginid ?>" readonly />
										</div>
										<span class="help-inline"><?php echo form_error('driver_loginid') ?></span>
									</div>

									<div class="form-group required">
										<label class="col-md-3 control-label" for="varchar">Driver Password</label>
										<div class="col-md-8">
											<?= $info ?>
											<input type="text" class="form-control" name="driver_loginpass" id="driver_loginpass" value="<?= $driver_loginpass ?>" />
										</div>
										<span class="help-inline"><?php echo form_error('driver_loginpass') ?></span>
									</div>

									<div class="form-group required">
										<label class="col-md-3 control-label" for="varchar">Driver Type</label>
										<div class="col-md-4">
											<select name="driver_type" id="driver_type" class="form-control" required>
												<option value="local" <?= $driver_type == 'local' ? 'selected' : '' ?>>LOCAL</option>
												<option value="prc" <?= $driver_type == 'prc' ? 'selected' : '' ?>>foreign</option>
											</select>
										</div>
										<span class="help-inline"><?php echo form_error('driver_type') ?></span>
									</div>

									<div class="form-group required">
										<label class="col-md-3 control-label" for="varchar">PSA Pass Number</label>
										<div class="col-md-8">
											<input required type="number" class="form-control" name="psa_pass_number" id="psa_pass_number" value="<?= $psa_pass_number ?>" />
										</div>
										<span class="help-inline"><?php echo form_error('psa_pass_number') ?></span>
									</div>

									<div class="form-group required">
										<label class="col-md-3 control-label" for="varchar">PSA Pass Expired</label>
										<div class="col-md-3">
											<input required type="text" class="form-control date date-picker" name="psa_pass_exp" id="psa_pass_exp" value="<?= $psa_pass_exp ?>" readonly autocomplete="off" />
										</div>
										<span class="help-inline"><?php echo form_error('psa_pass_exp') ?></span>
									</div>

									<div class="form-group required">
										<label class="col-md-3 control-label" for="varchar">PSA PIN</label>
										<div class="col-md-8">
											<input required type="number" class="form-control" name="psa_pin" id="psa_pin" value="<?= $psa_pin ?>" />
										</div>
										<span class="help-inline"><?php echo form_error('psa_pin') ?></span>
									</div>

									<div class="form-group required">
										<label class="col-md-3 control-label" for="varchar">Diesel PIN</label>
										<div class="col-md-8">
											<input required type="number" class="form-control" name="diesel_pin" id="diesel_pin" value="<?= $diesel_pin ?>" />
										</div>
										<span class="help-inline"><?php echo form_error('diesel_pin') ?></span>
									</div>

									<div class="form-group required">
										<label class="col-md-3 control-label" for="varchar">Handest No</label>
										<div class="col-md-8">
											<input required type="number" class="form-control" name="handset_no" id="handset_no" value="<?= $handset_no ?>" />
										</div>
										<span class="help-inline"><?php echo form_error('handset_no') ?></span>
									</div>

									<div class="form-group required">
										<label class="col-md-3 control-label" for="varchar">License Expried Date</label>
										<div class="col-md-3">
											<input required type="text" class="form-control date date-picker" name="license_exp" id="license_exp" value="<?= $license_exp ?>" readonly autocomplete="off" />
										</div>
										<span class="help-inline"><?php echo form_error('license_exp') ?></span>
									</div>
								</div>
							</div>


							<div class="form-actions">
								<div class="row">
									<div class="col-md-12">
										<button type="submit" class="btn green"><i class="fa fa-save"></i> <?php echo $button ?></button>
										<a href="<?php echo site_url('Master_Tims/driver') ?>" class="btn red"><i class="fa fa-close"></i> Cancel</a>
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


