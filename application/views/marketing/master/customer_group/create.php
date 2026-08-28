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
								
								<?php echo form_hidden('customer_group_id', $customer_group_id) ?>
								
								<div class="form-group required">
									<label class="col-md-3 control-label" for="varchar">Group Name</label>
									<div class="col-md-5">
										<input required type="text" class="form-control" name="customer_group_name" id="customer_group_name" value="<?php echo $customer_group_name; ?>" />
									</div>
									<span class="help-inline"><?php echo form_error('customer_group_name') ?></span>
								</div>
								
								<div class="form-group required">
									<label class="col-md-3 control-label" for="varchar">COA</label>
									<div class="col-md-5">
										<input required type="text" class="form-control" name="coa" id="coa" value="<?php echo $coa; ?>" />
									</div>
									<span class="help-inline"><?php echo form_error('coa') ?></span>
								</div>
							</div>
							<div class="form-actions">
								<div class="row">
									<div class="col-md-12">
										<input type="hidden" name="customer_group_id" value="<?php echo $customer_group_id; ?>" /> 
										<button type="submit" class="btn green"><?php echo $button ?></button> 
										<a href="<?php echo site_url('marketing/master/group_customer') ?>" class="btn red"><i class="fa fa-close"></i> Cancel</a>
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