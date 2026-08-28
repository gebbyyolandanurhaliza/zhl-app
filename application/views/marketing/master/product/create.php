<div class="page-content">
	<div class="container-fluid">
		<div class="row ">
			<form action="<?php echo $action; ?>" method="post" class="form-horizontal" role="form" enctype="multipart/form-data">
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
							<div class="form-body row">									
								<div class="col-md-6">
									<h4 class="form-section">Product Detail</h4>
									<div class="form-group required">
										<label class="col-md-3 control-label" for="varchar">Factory of Production</label>
										<div class="col-md-8">
											<?php														 
												$extra_factory = 'id="factory_id" class="form-control select2me" data-placeholder="Factory of production"';
												$option_factory[''] = '';
												foreach($cbo_factory as $r):
													$option_factory[$r->factory_id] = $r->factory_name;
												endforeach;
												echo form_dropdown('factory_id', $option_factory, $factory_id, $extra_factory);
											?>
										</div>
										<span class="help-inline"><?php echo form_error('factory_id') ?></span>
									</div>
									<div class="form-group required">
										<label class="col-md-3 control-label" for="varchar">Product Code</label>
										<div class="col-md-8">
											<input type="text" class="form-control" name="product_code" id="product_code" value="<?php echo $product_code; ?>" />
										</div>
										<span class="help-inline"><?php echo form_error('product_code') ?></span>
									</div>

									<div class="form-group required">
										<label class="col-md-3 control-label" for="varchar">Product Name</label>
										<div class="col-md-8">
											<input type="text" class="form-control" name="product_name" id="product_name" value="<?php echo $product_name; ?>" />
										</div>
										<span class="help-inline"><?php echo form_error('product_name') ?></span>
									</div>

									<div class="form-group required">
										<label class="col-md-3 control-label" for="varchar">Product Category</label>
										<div class="col-md-8">
											<?php														 
												$extra_pcategory = 'id="product_category_id" class="form-control select2me" data-placeholder="Product Category"';
												$option_pcategory[''] = '';
												foreach($cbo_product_category as $r):
													$option_pcategory[$r->product_category_id] = $r->product_category_name;
												endforeach;
												echo form_dropdown('product_category_id', $option_pcategory, $product_category_id, $extra_pcategory);
											?>
											<!--<input type="text" class="form-control" name="product_category" id="product_category" value="<?php echo $product_category; ?>" />-->
										</div>
										<span class="help-inline"><?php echo form_error('product_category') ?></span>
									</div>

									<div class="form-group">
										<label class="col-md-3 control-label" for="varchar">Brand</label>
										<div class="col-md-8">
											<?php														 
												$extra_brand = 'id="brand_id" class="form-control select2me" data-placeholder="Brand"';
												$option_brand[''] = '';
												foreach($cbo_brand as $r):
													$option_brand[$r->brand_id] = $r->brand_name;
												endforeach;
												echo form_dropdown('brand_id', $option_brand, $brand_id, $extra_brand);
											?>
										</div>
										<span class="help-inline"><?php echo form_error('brand_id') ?></span>
									</div>

									<div class="form-group required">
										<label class="col-md-3 control-label" for="varchar">UOM Volume</label>
										<div class="col-md-4">
											<input type="text" class="form-control text-right" name="uom_volume" id="uom_volume" value="<?php echo $uom_volume; ?>" />
										</div>

										<div class="col-md-4">
											<?php														 
												$extra_uom_volume = 'id="uom_volume_id" class="form-control select2me" data-placeholder="UOM Volume"';
												$option_uom_volume[''] = '';
												foreach($cbo_uom_volume as $r):
													$option_uom_volume[$r->uom_volume_id] = $r->uom_volume_name;
												endforeach;
												echo form_dropdown('uom_volume_id', $option_uom_volume, $uom_volume_id, $extra_uom_volume);
											?>
										</div>
										<span class="help-inline"><?php echo form_error('uom_volume') ?></span>
									</div>

									<div class="form-group required">
										<label class="col-md-3 control-label" for="varchar">Packing</label>
										<div class="col-md-2" style="padding-right: 10px">
											<input type="text" class="form-control text-right" name="packing_1" id="packing_1" value="<?php echo $packing_1; ?>" />
										</div>
										
										<label style="width: 1px; padding-left: 0; padding-right: 0; text-align: center" class="col-md-1 control-label inline-labels" for="varchar">x</label>
										<div class="col-md-2" style="padding-left: 15px">
											<input type="text" class="form-control text-right" name="packing_2" id="packing_2" value="<?php echo $packing_2; ?>" />
										</div>

										<div class="col-md-4">
											<?php														 
												$extra_uom_quantity = 'id="uom_volume_id" class="form-control select2me" data-placeholder="UOM Quantity"';
												$option_uom_quantity[''] = '';
												foreach($cbo_uom_quantity as $r):
													$option_uom_quantity[$r->uom_quantity_id] = $r->uom_quantity_name;
												endforeach;
												echo form_dropdown('uom_quantity_id', $option_uom_quantity, $uom_quantity_id, $extra_uom_quantity);
											?>
										</div>
										<span class="help-inline"><?php echo form_error('uom_quantity_id') ?></span>
									</div>

									<div class="form-group required">
										<label class="col-md-3 control-label" for="varchar">Estimated Quantity</label>
										<div class="col-md-4">
											<input type="text" class="form-control text-right" name="container_20ft" id="container_20ft" value="<?php echo $container_20ft; ?>" />
										</div>
										<span class="help-inline">in container 20'</span>
										<span class="help-inline"><?php echo form_error('container_20ft') ?></span>
									</div>

									<div class="form-group">
										<label class="col-md-3 control-label" for="varchar">&nbsp;</label>
										<div class="col-md-4">
											<input type="text" class="form-control text-right" name="container_40ft" id="container_40ft" value="<?php echo $container_40ft; ?>" />
										</div>
										<span class="help-inline">in container 40'</span>
										<span class="help-inline"><?php echo form_error('container_40ft') ?></span>
									</div>
									
									<div class="form-group required">
										<label class="col-md-3 control-label" for="varchar">Gross Weight</label>
										<div class="col-md-4">
											<input type="text" class="form-control text-right" name="gross_weight" id="gross_weight" value="<?php echo number_format($gross_weight, 3); ?>" />
										</div>
										<span class="help-inline"><?php echo form_error('gross_weight') ?></span>
									</div>
									
									<div class="form-group required">
										<label class="col-md-3 control-label" for="varchar">Net Weight</label>
										<div class="col-md-4">
											<input type="text" class="form-control text-right" name="net_weight" id="net_weight" value="<?php echo number_format($net_weight, 3); ?>" />
										</div>
										<span class="help-inline"><?php echo form_error('net_weight') ?></span>
									</div>

									<div class="form-group">
										<label class="col-md-3 control-label" for="varchar">Drained Weight</label>
										<div class="col-md-4">
											<input type="text" class="form-control text-right" name="drained_weight" id="drained_weight" value="<?php echo $drained_weight; ?>" />
										</div>
										<span class="help-inline"><?php echo form_error('drained_weight') ?></span>
									</div>

									<div class="form-group">
										<label class="col-md-3 control-label" for="varchar">Fat Content</label>
										<div class="col-md-4">
											<input type="text" class="form-control text-right" name="fat_content" id="fat_content" value="<?php echo $fat_content; ?>" />
										</div>
										<span class="help-inline"><?php echo form_error('fat_content') ?></span>
									</div>
									
									<div class="form-group required">
										<label class="col-md-3 control-label" for="varchar">Packing Size</label>
										<div class="col-md-4">
											<input type="text" class="form-control" name="packing_view" id="packing_view" value="<?php echo $packing_view; ?>" />
											<input type="hidden" class="form-control" name="packing_size" id="packing_size" value="<?php echo $packing_size; ?>" />
											<?php														 
//												$extra_packing_size = 'id="packing_size" class="form-control select2me" data-placeholder="Packing Size"';
//												$option_packing_size[''] = '';
//												foreach($cbo_packing_size as $r):
//													$option_packing_size[$r->packing_size_id] = $r->packing_size_name;
//												endforeach;
//												echo form_dropdown('packing_size_id', $option_packing_size, $packing_size_id, $extra_packing_size);
											?>
										</div>
										<span class="help-inline"><?php echo form_error('packing_view') ?></span>
										<!--<span class="help-inline"><?php // echo form_error('packing_size_id') ?></span>-->
									</div>
								</div>
								
								<div class="col-md-6">
									<h4 class="form-section">Product Image</h4>
									
									<?php									
										$class_fileinput = ($image_filename) ? 'fileinput-exists' : 'fileinput-new';									
									?>
									
									<div class="fileinput <?php echo $class_fileinput?>" data-provides="fileinput">
										<div class="fileinput-new thumbnail" style="width: 600px; height: 400px;">
											<?php echo $product_no_image ?>
										</div>
										<div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 600px; max-height: 400px;">
											<?php
											if ($image_filename){
												echo '<img src="'.base_url().'images/product/'.$image_filename.'" style="max-height:390px;" alt=""/>';
											}
											?>
										</div>
										<div>
											<span class="btn default btn-file">
												<span class="fileinput-new">
													Select image 
												</span>
												<span class="fileinput-exists">
													Change 
												</span>
												<input type="hidden" id="removed" name="removed" value="0">
												<input type="hidden" name="image_filename" value="<?php echo $image_filename?>">
												<input type="file" name="upload_product">
											</span>
											<a id="btnremove" href="javascript:;" class="btn red fileinput-exists btnremove" data-dismiss="fileinput">
											Remove </a>
										</div>
									</div>
								</div>
								
							</div>
							
							<div class="form-actions">
								<div class="row">
									<div class="col-md-12">
										<input type="hidden" name="product_id" value="<?php echo $product_id; ?>" /> 
										<button type="submit" class="btn btn-success"><?php echo $button ?></button> 
										<a href="<?php echo site_url('marketing/master/product') ?>" class="btn btn-danger"><i class="fa fa-close"></i> Cancel</a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>

<script>
	$('.btnremove').click(function(){
		$('#removed').val('1');
	});
</script>