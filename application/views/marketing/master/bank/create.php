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
									<label class="col-md-3 control-label" for="varchar">Account Number</label>
									<div class="col-md-3">
										<input type="text" class="form-control" name="bank_account_number" id="bank_account_number" value="<?php echo $bank_account_number; ?>" maxlength="20" onkeypress="return isNumber(event)"/>
									</div>
									<span class="help-inline"><?php echo form_error('bank_account_number') ?></span>
								</div>
								
								<div class="form-group required">
									<label class="col-md-3 control-label" for="varchar">Name</label>
									<div class="col-md-3">
										<input type="text" class="form-control" name="bank_name" id="bank_name" value="<?php echo $bank_name; ?>" />
									</div>
									<span class="help-inline"><?php echo form_error('bank_name') ?></span>
								</div>
                                
                                <div class="form-group">
									<label class="col-md-3 control-label" for="varchar">Abbreviation</label>
									<div class="col-md-3">
										<input type="text" class="form-control" name="bank_abbreviation" id="bank_abbreviation" value="<?php echo $bank_abbreviation; ?>" />
									</div>
									<span class="help-inline"><?php echo form_error('bank_abbreviation') ?></span>
								</div>
                                
                                <div class="form-group">
									<label class="col-md-3 control-label" for="varchar">City</label>
									<div class="col-md-3">
										<input type="text" class="form-control" name="bank_city" id="bank_city" value="<?php echo $bank_city; ?>" />
									</div>
									<span class="help-inline"><?php echo form_error('bank_city') ?></span>
								</div>
								
								<div class="form-group">
									<label class="col-md-3 control-label" for="varchar">Address</label>
									<div class="col-md-3">
										<textarea type="text" class="form-control autosizeme" name="bank_address" id="bank_address" ><?php echo $bank_address; ?></textarea>
									</div>
									<span class="help-inline"><?php echo form_error('bank_address') ?></span>
								</div>
								
								<div class="form-group">
									<label class="col-md-3 control-label" for="varchar">Bank Country </label>
									<div class="col-md-3">
										<?php
										$extra_country = 'class="form-control select2me" data-placeholder="Select Country..."';
										$option_country[''] = '';
										foreach($cbo_country as $r):
											$option_country[$r->country_id] = $r->country_name;
										endforeach;
										echo form_dropdown('bank_country_id', $option_country, $bank_country_id, $extra_country);
										?>
									</div>
									<span class="help-inline"><?php echo form_error('bank_country_id') ?></span>
								</div>
								
								<div class="form-group">
									<label class="col-md-3 control-label" for="varchar">Swift Code</label>
									<div class="col-md-3">
										<input type="text" class="form-control" name="bank_swift" id="bank_swift" value="<?php echo $bank_swift; ?>" />
									</div>
									<span class="help-inline"><?php echo form_error('bank_swift') ?></span>
								</div>
								
								<div class="form-group">
									<label class="col-md-3 control-label" for="varchar">Currency</label>
									<div class="col-md-3">
										<?php 
											$extra_currency = 'id= "bank_currency_id" class="form-control select2me" data-placeholder="Select Currency..."';
											$option_currency[''] = '';
											foreach($cbo_currency as $r):
												$option_currency[$r->currency_id] = $r->currency_symbol.' - '.$r->currency_name;													
											endforeach;
											echo form_dropdown('bank_currency_id', $option_currency, $bank_currency_id, $extra_currency);
										?>
									</div>
									<span class="help-inline"><?php echo form_error('bank_currency_id') ?></span>
								</div>
								
								<div class="form-group">
									<label class="col-md-3 control-label" for="varchar">Bank Description</label>
									<div class="col-md-3">
										<input type="text" class="form-control" name="bank_description" id="bank_description" value="<?php echo $bank_description; ?>" />
									</div>
									<span class="help-inline"><?php echo form_error('bank_description') ?></span>
								</div>

								<!-- Other Account -->
								<div class="form-group">
									<label class="col-md-3 control-label" for="varchar"><b><u>Other Account</u></b></label>
								</div>
								<div class="form-group required">
									<label class="col-md-3 control-label" for="varchar">Account Number</label>
									<div class="col-md-3">
										<input type="text" class="form-control" name="bank_account_number_2" id="bank_account_number_2" value="<?php echo $bank_account_number_2; ?>" maxlength="20" onkeypress="return isNumber(event)"/>
									</div>
									<span class="help-inline"><?php echo form_error('bank_account_number_2') ?></span>
								</div>
								
								<div class="form-group">
									<label class="col-md-3 control-label" for="varchar">Currency</label>
									<div class="col-md-3">
										<?php 
											$extra_currency = 'id= "bank_currency_id_2" class="form-control select2me" data-placeholder="Select Currency 2..."';
											$option_currency[''] = '';
											foreach($cbo_currency as $r):
												$option_currency[$r->currency_id] = $r->currency_symbol.' - '.$r->currency_name;													
											endforeach;
											echo form_dropdown('bank_currency_id_2', $option_currency, $bank_currency_id_2, $extra_currency);
										?>
									</div>
									<span class="help-inline"><?php echo form_error('bank_currency_id_2') ?></span>
								</div>

							</div>
							<div class="form-actions">
								<div class="row">
									<div class="col-md-12">
										<input type="hidden" name="bank_id" value="<?php echo $bank_id; ?>" /> 
										<button type="submit" class="btn green"><?php echo $button ?></button> 
										<a href="<?php echo site_url('marketing/master/bank') ?>" class="btn red"><i class="fa fa-close"></i> Cancel</a>
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