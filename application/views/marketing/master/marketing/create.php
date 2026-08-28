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
									<label class="col-md-3 control-label" for="varchar">Marketing Code</label>
									<div class="col-md-5">
										<input type="text" class="form-control" name="marketing_code" id="marketing_code" placeholder="Marketing Code" value="<?php echo $marketing_code; ?>" />
									</div>
									<span class="help-inline"><?php echo form_error('marketing_code') ?></span>
								</div>
								<div class="form-group">
									<label class="col-md-3 control-label" for="varchar">Marketing Name</label>
									<div class="col-md-5">
										<input type="text" class="form-control" name="marketing_name" id="marketing_name" placeholder="Marketing Name" value="<?php echo $marketing_name; ?>" />
									</div>
									<span class="help-inline"><?php echo form_error('marketing_name') ?></span>
								</div>								
								<div class="form-group">
									<label class="col-md-3 control-label" for="varchar">Marketing CMA</label>
									<div class="col-md-5">
										<input type="text" class="form-control" name="marketing_cma" id="marketing_cma" placeholder="Marketing Cma" value="<?php echo $marketing_cma; ?>" />
									</div>
									<span class="help-inline"><?php echo form_error('marketing_cma') ?></span>
								</div>
								
								<div class="form-group">
									<label class="col-md-3 control-label" for="varchar">Marketing Country </label>
									<div class="col-md-5">
										<?php 
										
											$extra_country = 'class="form-control select2me" data-placeholder="Marketing Country"';
											$option_country[''] = '';
											foreach($cbo_country as $r):
												$option_country[$r->country_id] = $r->country_name;
											endforeach;
											echo form_dropdown('country_id', $option_country, $country_id, $extra_country);
										?>
										
										<!--<input type="text" class="form-control" name="marketing_country" id="marketing_country" placeholder="Marketing Country" value="<?php echo $marketing_country; ?>" />-->
									</div>
									<span class="help-inline"><?php echo form_error('country_id') ?></span>
								</div>
								<div class="form-group">
									<label class="col-md-3 control-label" for="longtext">Marketing Address</label>
									<div class="col-md-5">
										<textarea rows="3" class="form-control" name="marketing_address" id="marketing_address" placeholder="Marketing Address" value="<?php echo $marketing_address; ?>"></textarea>
									</div>
									<span class="help-inline"><?php echo form_error('marketing_address') ?></span>
								</div>
								<div class="form-group">
									<label class="col-md-3 control-label" for="varchar">Marketing Phone</label>
									<div class="col-md-5">
										<input type="text" class="form-control" name="marketing_phone" id="marketing_phone" placeholder="Marketing Phone" value="<?php echo $marketing_phone; ?>" />
									</div>
									<span class="help-inline"><?php echo form_error('marketing_phone') ?></span>
								</div>
								<div class="form-group">
									<label class="col-md-3 control-label" for="varchar">Marketing Fax</label>
									<div class="col-md-5">
										<input type="text" class="form-control" name="marketing_fax" id="marketing_fax" placeholder="Marketing Fax" value="<?php echo $marketing_fax; ?>" />
									</div>
									<span class="help-inline"><?php echo form_error('marketing_fax') ?></span>
								</div>
								<div class="form-group">
									<label class="col-md-3 control-label" for="varchar">Marketing Email</label>
									<div class="col-md-5">
										<input type="text" class="form-control" name="marketing_email" id="marketing_email" placeholder="Marketing Email" value="<?php echo $marketing_email; ?>" />
										<span class="help-inline"><?php echo form_error('marketing_email') ?></span>
									</div>
								</div>
							</div>
							
							<div class="form-actions">
								<div class="row">
									<div class="col-md-offset-3 col-md-9">
										<input type="hidden" name="marketing_id" value="<?php echo $marketing_id; ?>" /> 
										<button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
										<a href="<?php echo site_url('marketing/master/marketing') ?>" class="btn btn-default">Cancel</a>
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
