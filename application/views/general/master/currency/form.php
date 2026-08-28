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
								<div class="form-group required">
									<label class="col-md-3 control-label" for="varchar">Currency ID</label>
									<div class="col-md-5">
										<input type="text" class="form-control" name="currency_id" id="currency_id" placeholder="Currency ID" value="<?php echo $currency_id; ?>" />
									</div>
									<span class="help-inline"><?php echo form_error('currency_id') ?></span>
								</div>
								<div class="form-group required">
									<label class="col-md-3 control-label" for="varchar">Currency Name</label>
									<div class="col-md-5">
										<input type="text" class="form-control" name="currency_name" id="currency_name" placeholder="Currency Name" value="<?php echo $currency_name; ?>" />
									</div>
									<span class="help-inline"><?php echo form_error('currency_name') ?></span>
								</div>
								<div class="form-group required">
									<label class="col-md-3 control-label" for="varchar">Currency Symbol</label>
									<div class="col-md-5">
										<input type="text" class="form-control" name="currency_symbol" id="currency_symbol" placeholder="Currency Symbol" value="<?php echo $currency_symbol; ?>" />
									</div>
									<span class="help-inline"><?php echo form_error('currency_symbol') ?><span class="help-inline"></span>
								</div>
								<div class="form-group">
									<label class="col-md-3 control-label" for="int">Say In Words</label>
									<div class="col-md-5">
										<input type="text" class="form-control" name="currency_say_in_words" id="currency_say_in_words" placeholder="Say In Words" value="<?php echo $currency_say_in_words; ?>" />
									</div>
									<span class="help-inline"><?php echo form_error('currency_say_in_words') ?></span>
								</div>	
								<div class="form-group">
									<label class="col-md-3 control-label" for="int">Say In Words 2</label>
									<div class="col-md-5">
										<input type="text" class="form-control" name="currency_say_in_words2" id="currency_say_in_words2" placeholder="Say In Words 2" value="<?php echo $currency_say_in_words2; ?>" />
									</div>
									<span class="help-inline"><?php echo form_error('currency_say_in_words2') ?></span>
								</div>	
							</div>
							
							<div class="form-actions">
								<div class="row">
									<div class="col-md-offset-3 col-md-9">
										<button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
										<a href="<?php echo site_url('master/currency') ?>" class="btn btn-default">Cancel</a>
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