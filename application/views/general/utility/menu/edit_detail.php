
<div class="page-content">
	<div class="container-fluid">
		
		<div class="row ">
			<div class="col-md-12">				
				
				<div class="portlet light">
					
					<div class="portlet-title">
						<div class="caption">
							<i class="fa fa-cogs theme-font"></i>
							<span class="caption-subject theme-font bold uppercase">
								Menu Detail Edit								
							</span>
							<span class="caption-helper">  <?php echo $menuid;?>  </span>
						</div>
						
						<div class="tools">
							<a href="javascript:;" class="collapse"></a>								
						</div>
					</div>
					
					<div class="portlet-body form">
						<form action="<?php echo site_url('utility/menu_update/detail');?>" method="post" class="form-horizontal" role="form">
							<div class="form-body">
								
								<?php echo form_hidden('txt_menuid', $menudtl_id);?>

								<div class="form-group required">
									<label class="col-md-3 control-label">Header Menu</label>
									<div class="col-md-3">
										<?php
										$extra_hdr = 'class="form-control select2me" data-placeholder="Select Header Menu..."';
										$option_hdr[''] = '';
										foreach ($combo_menu_header as $cmh) :
											$option_hdr[$cmh->menuhdr_id] = $cmh->menuhdr_id. ' - '.$cmh->menuhdr_title;
										endforeach;
										echo form_dropdown('txt_menuhdrid', $option_hdr, $menuhdr_id, $extra_hdr);
										?>
									</div>
									<span class="help-inline"><?php echo form_error('txt_menuhdrid') ?></span>
								</div>
								
								<div class="form-group required">
									<label class="col-md-3 control-label">Menu ID</label>
									<div class="col-md-2">
										<input disabled="disabled" value="<?php echo $menudtl_id?>" name="txt_menuid_disabled" type="text" class="form-control" placeholder="4 digit number">
									</div>									
								</div>

								<div class="form-group required">
									<label class="col-md-3 control-label">Menu Title</label>
									<div class="col-md-3">
										<input value="<?php echo $menudtl_title;?>" name="txt_menutitle" type="text" class="form-control" placeholder="Menu Title">
									</div>
									<span class="help-inline"><?php echo form_error('txt_menutitle') ?></span>
								</div>
								
								<div class="form-group">
									<label class="col-md-3 control-label">Menu Link</label>
									<div class="col-md-3">
										<input value="<?php echo $menudtl_link;?>" name="txt_menulink" type="text" class="form-control" placeholder="Menu Link">
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-3 control-label">Menu Icon</label>
									<div class="col-md-3">
										<select class="form-control select2me" name="txt_menuicon" data-placeholder="Select Menu Icon..." style="font-family: 'FontAwesome', Open Sans;">
											<option value=""></option>
											<?php
												foreach ($falist as $key => $value) {
													if ($menudtl_icon === $key){
														echo "<option selected='selected' class='fontawesome-font' value='".$key."' > &#x".stripslashes($value).";    ".$key."</option>";
													} else {
														echo "<option class='fontawesome-font' value='".$key."' > &#x".stripslashes($value).";    ".$key."</option>";
													}
												}
											?>										
										</select>
									</div>
								</div>
								
								<div class="form-group">
									<label class="col-md-3 control-label">Column Group</label>
									<div class="col-md-3">
										<select class="form-control select2me" name="txt_columngroup" data-placeholder="Select Column Group...">
											<option value=""></option>
											<?php
												for ($c = 1; $c < 4; $c++) {
													if ($column_group == $c){
														echo '<option value="'.$c.'" selected="selected">column '.$c.'</option>';
													} else {
														echo '<option value="'.$c.'" >column '.$c.'</option>';
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
										<a href="<?php echo site_url('utility/menu/detail');?>" class="btn default">Cancel</a>
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