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
						<?php echo form_open($action, array('class'=>'form-horizontal'))?>
						<div class="form-body row">
							<div class="col-md-7">
								<h4 class="form-section"><i class="fa fa-home"></i> Agent</h4>
								
								<div class="form-group required">
									<label class="col-md-3 control-label" for="varchar">Name</label>
									<div class="col-md-5">
										<input required type="text" class="form-control" name="agent_name" id="agent_name" value="<?php echo $agent_name; ?>" />
									</div>
									<span class="help-inline"><?php echo form_error('agent_name') ?></span>
								</div>
								
								<div class="form-group required">
									<label class="col-md-3 control-label" for="varchar">Customer</label>
									<div class="col-md-5">
										<?php 

											$extra_customer = 'required class="form-control select2me" ';
											$option_customer[''] = '';
											foreach($cbo_customer as $r):
												$option_customer[$r->customer_id] = $r->customer_name;
											endforeach;
											echo form_dropdown('customer_id', $option_customer, $customer_id, $extra_customer);
										?>

									</div>
									<span class="help-inline"><?php echo form_error('customer_id') ?></span>
								</div>
								
								<div class="form-group">
									<label class="col-md-3 control-label" for="longtext">Address</label>
									<div class="col-md-5">
										<textarea rows="3" class="form-control autosizeme" name="agent_address" id="agent_address"><?php echo $agent_address; ?></textarea>
									</div>
									<span class="help-inline"><?php echo form_error('agent_address') ?></span>
								</div>
								
								<div class="form-group">
									<label class="col-md-3 control-label" for="varchar">Country </label>
									<div class="col-md-5">
										<?php 

											$extra_country = 'class="form-control select2me" ';
											$option_country[''] = '';
											foreach($cbo_country as $r):
												$option_country[$r->country_id] = $r->country_name;
											endforeach;
											echo form_dropdown('agent_country_id', $option_country, $agent_country_id, $extra_country);
										?>

									</div>
									<span class="help-inline"><?php echo form_error('agent_country_id') ?></span>
								</div>
								
								<div class="form-group">
									<label class="col-md-3 control-label" for="varchar">Phone</label>
									<div class="col-md-5">
										<input type="text" class="form-control" name="agent_phone" id="agent_phone" value="<?php echo $agent_phone; ?>" />
									</div>
									<span class="help-inline"><?php echo form_error('agent_phone') ?></span>
								</div>
								
								<div class="form-group">
									<label class="col-md-3 control-label" for="varchar">Fax</label>
									<div class="col-md-5">
										<input type="text" class="form-control" name="agent_fax" id="agent_fax" value="<?php echo $agent_fax; ?>" />
									</div>
									<span class="help-inline"><?php echo form_error('agent_fax') ?></span>
								</div>
								
								<div class="form-group">
									<label class="col-md-3 control-label" for="varchar">Email</label>
									<div class="col-md-5">
										<input type="text" class="form-control" name="agent_email" id="agent_email" value="<?php echo $agent_email; ?>" />										
									</div>
									<span class="help-inline"><?php echo form_error('agent_email') ?></span>
								</div>
								
							</div>
							
							<div class="col-md-5">
								<h4 class="form-section"><i class="fa fa-male"></i> Contact Person</h4>

								<div class="form-group required">
									<label class="col-md-3 control-label" for="varchar">Name</label>
									<div class="col-md-8">
										<input required type="text" class="form-control" name="agent_contact_name" id="agent_contact_name" value="<?php echo $agent_contact_name; ?>" />
										<span class="help-inline"><?php echo form_error('agent_contact_name') ?></span>
									</div>										
								</div>

								<div class="form-group">
									<label class="col-md-3 control-label" for="varchar">Phone</label>
									<div class="col-md-8">
										<input type="text" class="form-control" name="agent_contact_phone" id="agent_contact_phone" value="<?php echo $agent_contact_phone; ?>" />
										<span class="help-inline"><?php echo form_error('agent_contact_phone') ?></span>
									</div>										
								</div>

								<div class="form-group">
									<label class="col-md-3 control-label" for="varchar">Email</label>
									<div class="col-md-8">
										<input type="text" class="form-control" name="agent_contact_email" id="agent_contact_email" value="<?php echo $agent_contact_email; ?>" />
										<span class="help-inline"><?php echo form_error('agent_contact_email') ?></span>
									</div>										
								</div>
							</div>
							
						</div>
						
						<div class="form-actions">
							<div class="row">
								<div class="col-md-12">
									<input type="hidden" name="agent_id" value="<?php echo $agent_id; ?>" /> 
									<button type="submit" class="btn green"><?php echo $button ?></button> 
									<a href="<?php echo site_url('marketing/master/agent') ?>" class="btn red"><i class="fa fa-close"></i> Cancel</a>
								</div>
							</div>
						</div>
						
						<?php echo form_close() ?>
					</div>
					
				</div>
				
			</div>
		</div>		
	</div>
</div>


<script>
	//	autosizeme => autosize textarea
	$('textarea').each(function(){
		autosize(this);
	});
</script>