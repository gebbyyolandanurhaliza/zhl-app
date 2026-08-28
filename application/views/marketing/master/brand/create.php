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
									<label class="col-md-3 control-label" for="varchar">Brand Name</label>
									<div class="col-md-5">
										<input type="text" class="form-control" name="brand_name" id="brand_name" value="<?php echo $brand_name; ?>" />
									</div>
									<span class="help-inline"><?php echo form_error('brand_name') ?></span>
								</div>
								
								<div class="form-group required">
									<label class="col-md-3 control-label" for="varchar">Brand CMA</label>
									<div class="col-md-5">
										<input type="text" class="form-control" name="brand_cma" id="brand_name" value="<?php echo $brand_cma; ?>" />
									</div>
									<span class="help-inline"><?php echo form_error('brand_cma') ?></span>
								</div>
							</div>
							<div class="form-actions">
								<div class="row">
									<div class="col-md-12">
										<input type="hidden" name="brand_id" value="<?php echo $brand_id; ?>" /> 
										<button type="submit" class="btn green"><?php echo $button ?></button> 
										<a href="<?php echo site_url('marketing/master/brand') ?>" class="btn red"><i class="fa fa-close"></i> Cancel</a>
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