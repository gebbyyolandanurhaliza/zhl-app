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
									<label class="col-md-3 control-label" for="varchar">Packing Type Name</label>
									<div class="col-md-5">
										<input type="text" class="form-control" name="packing_type_name" id="packing_type_name" value="<?php echo $packing_type_name; ?>" />
									</div>
									<span class="help-inline"><?php echo form_error('packing_type_name') ?></span>
								</div>
								
							</div>
							<div class="form-actions">
								<div class="row">
									<div class="col-md-12">
										<input type="hidden" name="packing_type_id" value="<?php echo $packing_type_id; ?>" /> 
										<button type="submit" class="btn green"><?php echo $button ?></button> 
										<a href="<?php echo site_url('marketing/master/packing-type') ?>" class="btn red"><i class="fa fa-close"></i> Cancel</a>
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