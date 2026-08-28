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
									<label class="col-md-2 control-label" for="varchar">Document Name</label>
									<div class="col-md-5">
										<input required type="text" class="form-control" name="document_name" id="document_name" value="<?php echo $document_name; ?>" />
									</div>
									
									<div class="col-md-3">
										<label class="checkbox-inline">
											<?php 									
											echo form_checkbox('special', 1, $checked, 'class="form-control" title="Mark as Special Document"');
											?>
											Mark as Special Document
										</label>
									</div>
									<span class="help-inline"><?php echo form_error('document_name') ?></span>
								</div>
								
								<div class="form-group">
									<label class="col-md-2 control-label" for="varchar">Document Remark</label>
									<div class="col-md-5">
										<input type="text" class="form-control" name="document_remark" id="document_remark" value="<?php echo $document_remark; ?>" />
									</div>
									<span class="help-inline"><?php echo form_error('document_remark') ?></span>
								</div>
							</div>
							<div class="form-actions">
								<div class="row">
									<div class="col-md-12">
										<input type="hidden" name="document_id" value="<?php echo $document_id; ?>" /> 
										<button type="submit" class="btn green"><?php echo $button ?></button> 
										<a href="<?php echo site_url('marketing/master/document') ?>" class="btn red"><i class="fa fa-close"></i> Cancel</a>
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