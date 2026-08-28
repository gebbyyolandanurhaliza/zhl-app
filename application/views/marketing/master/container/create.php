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
									<label class="col-md-3 control-label" for="varchar">Container Name</label>
									<div class="col-md-5">
										<input type="text" class="form-control" name="container_name" id="container_name" value="<?php echo $container_name; ?>" />
									</div>
									<span class="help-inline"><?php echo form_error('container_name') ?></span>
								</div>
                                
                                <div class="form-group">
									<label class="col-md-3 control-label" for="varchar">Container Size</label>
									<div class="col-md-3">
										<input type="text" class="form-control" name="container_size" id="container_size" value="<?php echo $container_size; ?>" />
									</div>
									<span class="help-inline"><?php echo form_error('container_size') ?></span>
								</div>
                                
                                <div class="form-group">
									<label class="col-md-3 control-label" for="varchar">Container ABBR</label>
									<div class="col-md-3">
										<input type="text" class="form-control" name="container_abbr" id="container_abbr" value="<?php echo $container_abbr; ?>" />
									</div>
									<span class="help-inline"><?php echo form_error('container_abbr') ?></span>
								</div>
								<div class="form-group">
									<label class="col-md-3 control-label" for="varchar">Measurement</label>
									<div class="col-md-3">
										<input type="text" class="form-control" name="measurement" id="measurement" value="<?php echo $measurement; ?>" />
									</div>
									<span class="help-inline"><?php echo form_error('measurement') ?></span>
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