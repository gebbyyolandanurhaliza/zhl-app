
<div class="page-content">
	
	<div class="container-fluid">
		
		<div class="row ">
			<div class="col-md-12">
				<div class="portlet light">
					<div class="portlet-title">
						<div class="caption">
							<i class="fa fa-cogs theme-font"></i>
							<span class="caption-subject theme-font bold uppercase">Sub Menu Detail Edit</span>
						</div>
						<div class="tools">
							<a href="javascript:;" class="collapse"></a>
						</div>
					</div>
					
					<div class="portlet-body form">
						<form action="<?php echo site_url('Utility/menu_update/detailsub');?>" method="post" class="form-horizontal" role="form">
							<div class="form-body">
								
								<?php echo form_hidden('txt_menuid', $menudtlsub_id);?>

								<div class="form-group required">
									<label class="col-md-3 control-label">Header Menu</label>
									<div class="col-md-3">
										<?php
										$extra_hdr = 'class="form-control select2me" data-placeholder="Select Header Menu..."';
										$option_hdr[''] = '';
										foreach ($combo_menu_detail as $cmh) :
											$option_hdr[$cmh->menudtl_id] = $cmh->menudtl_id. ' - '.$cmh->menudtl_title. ' ('.strtoupper($cmh->menuhdr_title).')';
										endforeach;
										echo form_dropdown('txt_menudtlid', $option_hdr, $menudtl_id, $extra_hdr);
										?>
									</div>
									<span class="help-inline"><?php echo form_error('txt_menudtlid') ?></span>
								</div>
								
								<div class="form-group required">
									<label class="col-md-3 control-label">Menu ID</label>
									<div class="col-md-2">
										<input disabled="disabled" value="<?php echo $menuid;?>" name="txt_menuid_disabled" type="text" class="form-control" placeholder="4 digit number">
									</div>
								</div>

								<div class="form-group required">
									<label class="col-md-3 control-label">Menu Title</label>
									<div class="col-md-3">
										<input value="<?php echo $menudtlsub_title;?>" name="txt_menutitle" type="text" class="form-control" placeholder="Menu Title">
									</div>
									<span class="help-inline"><?php echo form_error('txt_menutitle') ?></span>
								</div>

								<div class="form-group required">
									<label class="col-md-3 control-label">Menu Link</label>
									<div class="col-md-3">
										<input value="<?php echo $menudtlsub_link;?>" name="txt_menulink" type="text" class="form-control" placeholder="Menu Link">
									</div>
									<span class="help-inline"><?php echo form_error('txt_menulink') ?></span>
								</div>

								<div class="form-group">
									<label class="col-md-3 control-label">Menu Icon</label>
									<div class="col-md-3">
										<select class="form-control select2me" name="txt_menuicon" data-placeholder="Select Menu Icon..." style="font-family: 'FontAwesome', Open Sans;">
											<option value=""></option>
											<?php
												foreach ($falist as $key => $value) {
													if ($menudtlsub_icon === $key){
														echo "<option selected='selected' class='fontawesome-font' value='".$key."' > &#x".stripslashes($value).";    ".$key."</option>";
													} else {
														echo "<option class='fontawesome-font' value='".$key."' > &#x".stripslashes($value).";    ".$key."</option>";
													}
												}
											?>										
										</select>
									</div>
								</div>											

							</div>		

							<div class="form-actions">
								<div class="row">
									<div class="col-md-offset-3 col-md-9">
										<button type="submit" class="btn blue">Update</button>
										<a href="<?php echo site_url('utility/menu/detailsub');?>" class="btn default">Cancel</a>
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