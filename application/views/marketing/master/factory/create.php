<div class="page-content">
	<div class="container-fluid">
		<div class="row ">
			<div class="col-md-12">
				<div class="portlet light">
					<div class="portlet-title">
						<div class="caption">
							<i class="fa fa-cogs theme-font"></i>
							<span class="caption-subject theme-font uppercase"><?php echo $header_title;?></span>
						</div>
						<div class="tools">
							<a href="javascript:;" class="collapse"></a>								
						</div>
						
					</div>
					
					<div class="portlet-body form">
						<form action="<?php echo $action; ?>" method="post" class="form-horizontal" role="form">
							<div class="form-body">
								
								<div class="form-group required">
									<label class="col-md-3 control-label" for="varchar">Factory Name</label>
									<div class="col-md-5">
										<input type="text" class="form-control" name="factory_name" id="factory_name" value="<?php echo $factory_name; ?>" />
									</div>
									<span class="help-inline"><?php echo form_error('factory_name') ?></span>
								</div>
								
								<div class="form-group required">
									<label class="col-md-3 control-label" for="varchar">Factory Abbreviation</label>
									<div class="col-md-5">
										<input type="text" class="form-control" name="factory_abbr" id="factory_abbr" value="<?php echo $factory_abbr; ?>" />
									</div>
									<span class="help-inline"><?php echo form_error('factory_abbr') ?></span>
								</div>
								
								<div class="form-group">
									<label class="col-md-3 control-label" for="varchar">Factory Location</label>
									<div class="col-md-5">
										<input type="text" class="form-control" name="factory_location" id="factory_location" value="<?php echo $factory_location; ?>" />
									</div>
									<span class="help-inline"><?php echo form_error('factory_location') ?></span>
								</div>
								
								<div class="form-group">
									<label class="col-md-3 control-label" for="varchar">Factory Address</label>
									<div class="col-md-5">
										<input type="text" class="form-control" name="factory_address" id="factory_address" value="<?php echo $factory_address; ?>" />
									</div>
									<span class="help-inline"><?php echo form_error('factory_address') ?></span>
								</div>
								
								<div class="form-group ">
									<label class="col-md-3 control-label" for="varchar">Factory Phone</label>
									<div class="col-md-5">
										<input type="text" class="form-control" name="factory_phone" id="factory_phone" value="<?php echo $factory_phone; ?>" />
									</div>
									<span class="help-inline"><?php echo form_error('factory_phone') ?></span>
								</div>
								
								<div class="form-group ">
									<label class="col-md-3 control-label" for="varchar">Factory Fax</label>
									<div class="col-md-5">
										<input type="text" class="form-control" name="factory_fax" id="factory_fax" value="<?php echo $factory_fax; ?>" />
									</div>
									<span class="help-inline"><?php echo form_error('factory_fax') ?></span>
								</div>
							</div>
							<div class="form-actions">
								<div class="row">
									<div class="col-md-12">
										<input type="hidden" name="factory_id" value="<?php echo $factory_id; ?>" /> 
										<button type="submit" class="btn green"><?php echo $button ?></button> 
										<a href="<?php echo site_url('marketing/master/factory') ?>" class="btn red"><i class="fa fa-close"></i> Cancel</a>
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