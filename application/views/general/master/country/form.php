<div class="page-content">
	
	<div class="container-fluid">
		<div class="row ">
			<div class="col-md-12">
				
				<div class="portlet light">
					
					<div class="portlet-title">
						<div class="caption">
							<i class="fa fa-cogs theme-font"></i>
							<span class="caption-subject theme-font bold uppercase"><?php echo $header_title;?></span>
						</div>
						<div class="tools">
							<a href="javascript:;" class="collapse"></a>								
						</div>
					</div>
					
					<div class="portlet-body form">
						<form action="<?php echo $action; ?>" method="post" class="form-horizontal" role="form">
							<div class="form-body">
								<div class="form-group">
									<label class="col-md-3 control-label" for="varchar">Country Name</label>
									<div class="col-md-5">
										<input type="text" class="form-control" name="country_name" id="country_name" placeholder="Country Name" value="<?php echo $country_name; ?>" />
									</div>
									<span class="help-inline"><?php echo form_error('country_name') ?></span>
								</div>
								<div class="form-group">
									<label class="col-md-3 control-label" for="varchar">Country Code</label>
									<div class="col-md-5">
										<input type="text" class="form-control" name="country_ids" id="country_ids" placeholder="Country Code" value="<?php echo $country_ids; ?>" />
									</div>
									<span class="help-inline"><?php echo form_error('country_ids') ?><span class="help-inline"></span>
								</div>
								<div class="form-group">
									<label class="col-md-3 control-label" for="int">Dialing Code</label>
									<div class="col-md-5">
										<input type="text" class="form-control" name="country_idn" id="country_idn" placeholder="Dialling Code" value="<?php echo $country_idn; ?>" />
									</div>
									<span class="help-inline"><?php echo form_error('country_idn') ?></span>
								</div>								
								<div class="form-group">
									<label class="col-md-3 control-label" for="int">COO Form Type</label>
									<div class="col-md-5">
										<input type="text" class="form-control" name="form_id" id="form_id" placeholder="COO Type" value="<?php echo $form_id; ?>" />
									</div>
									<span class="help-inline"><?php echo form_error('form_id') ?></span>
								</div>								
							</div>
							
							<div class="form-actions">
								<div class="row">
									<div class="col-md-offset-3 col-md-9">
										<input type="hidden" name="country_id" value="<?php echo $country_id; ?>" /> 
										<button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
										<a href="<?php echo site_url('master/country') ?>" class="btn btn-default">Cancel</a>
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