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
									<label class="col-md-3 control-label" for="varchar">Container Number</label>
									<div class="col-md-5">
										<input type="text" class="form-control" name="container_number" id="container_number" value="<?php echo $container_number; ?>" />
									</div>
									<span class="help-inline"><?php echo form_error('container_number') ?></span>
								</div>
                                
                                <div class="form-group">
									<label class="col-md-3 control-label" for="varchar">Container Type</label>
									<div class="col-md-3">
										<input type="text" class="form-control" name="container_size" id="container_id" value="<?php echo $container_id; ?>" />
									</div>
									<span class="help-inline"><?php echo form_error('container_id') ?></span>
								</div>
								
							</div>
							<div class="form-actions">
								<div class="row">
									<div class="col-md-12">
										<input type="hidden" name="container_id" value="<?php echo $container_id; ?>" /> 
										<button type="submit" class="btn green"><?php echo $button ?></button> 
										<a href="<?php echo site_url('marketing/master/container') ?>" class="btn red"><i class="fa fa-close"></i> Cancel</a>
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