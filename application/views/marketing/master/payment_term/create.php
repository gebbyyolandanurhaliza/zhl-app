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
									<label class="col-md-2 control-label" for="varchar">Payment Term</label>
									<div class="col-md-7">
										<input required type="text" class="form-control" name="payment_term" id="payment_term" value="<?php echo $payment_term; ?>" />
									</div>									
								</div>								
							</div>
							
							<div class="form-actions">
								<div class="row">
									<div class="col-md-12">
										<input type="hidden" name="payment_term_id" value="<?php echo $payment_term_id; ?>" /> 
										<button type="submit" class="btn green"><?php echo $button ?></button> 
										<a href="<?php echo site_url('marketing/master/payment_term') ?>" class="btn red"><i class="fa fa-close"></i> Cancel</a>
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