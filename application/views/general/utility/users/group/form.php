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
							<?php echo form_hidden('user_group_id') ?>
							
							<div class="form-body">
								<div class="form-group">
									<label class="col-md-3 control-label" for="varchar">Group Name</label>
									<div class="col-md-5">
										<input type="text" class="form-control" name="user_group_name" id="user_group_name" placeholder="Group Name" value="<?php echo $user_group_name; ?>" />
									</div>
									<span class="help-inline"><?php echo form_error('user_group_name') ?></span>
								</div>	
								<div class="form-group">
									<label class="col-md-3 control-label" for="varchar">Group Remark</label>
									<div class="col-md-5">
										<input type="text" class="form-control" name="user_group_remark" id="user_group_remark" placeholder="Group Remark" value="<?php echo $user_group_remark; ?>" />
									</div>
									<span class="help-inline"><?php echo form_error('user_group_remark') ?></span>
								</div>
							</div>
							
							<div class="form-actions">
								<div class="row">
									<div class="col-md-offset-3 col-md-9">
										<input type="hidden" name="user_group_id" value="<?php echo $user_group_id; ?>" /> 
										<button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
										<a href="<?php echo site_url('user_group') ?>" class="btn btn-default">Cancel</a>
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