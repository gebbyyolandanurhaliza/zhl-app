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
									<label class="col-md-3 control-label" for="varchar">Product Category</label>
									<div class="col-md-6">
										<input required="required" type="text" class="form-control uppercase" name="product_category_name" id="product_category_name" value="<?php echo $product_category_name; ?>" />
									</div>
									<span class="help-inline"><?php echo form_error('product_category_name') ?></span>
								</div>
								
								<div class="form-group">
									<label class="col-md-3 control-label" for="varchar">Main Category</label>
									<div class="col-md-6">
										<?php														 
											$extra_main_category = 'id="main_category_id" class="form-control select2me" data-placeholder="Main Category"';
											$option_main_category[''] = '';
											foreach($cbo_main_category as $r):
												$option_main_category[$r->main_category_id] = $r->main_category_name;
											endforeach;
											echo form_dropdown('main_category_id', $option_main_category, $main_category_id, $extra_main_category);
										?>
									</div>
									<span class="help-inline"><?php echo form_error('main_category_id') ?></span>
								</div>
								
								<div class="form-group">
									<label class="col-md-3 control-label" for="varchar">PSG PO Format (P1)</label>
									<div class="col-md-2">
										<input type="text" class="form-control" name="po_code_prefix_psg" id="po_code_prefix_psg" value="<?php echo $po_code_prefix_psg; ?>" />
									</div>
									
									<label class="col-md-2 control-label" for="varchar">RSUP PO Format (P2)</label>
									<div class="col-md-2">
										<input type="text" class="form-control" name="po_code_prefix_rsup" id="po_code_prefix_rsup" value="<?php echo $po_code_prefix_rsup; ?>" />
									</div>
															
									<span class="help-inline">000 : Auto number</span>
									<span class="help-inline">MM : Month</span>
									<span class="help-inline">YY : Year</span>
								</div>
								
								<div class="form-group">
									<label class="col-md-3 control-label" for="varchar">&nbsp;</label>
									<div class="col-md-2">
										<input type="hidden" class="form-control" name="po_code_prefix_none" id="po_code_prefix_rsup" value="" />
									</div>
									
									<label class="col-md-2 control-label" for="varchar">PSJ PO Format</label>
									<div class="col-md-2">
										<input type="text" class="form-control" name="po_code_prefix_psj" id="po_code_prefix_rsup" value="<?php echo $po_code_prefix_psj; ?>" />
									</div>
								</div>
								
								
								<div class="form-group">
									<label class="col-md-3 control-label" for="varchar">COA - Inventory</label>
									<div class="col-md-6">
										<?php														 
											$extra_coa_inv = 'id="coa_inv" class="form-control" data-placeholder="COA Inventory"';
											$option_coa_inv[''] = '';
											foreach($cbo_coa_inv as $r):
												$option_coa_inv[$r->NoCOA] = $r->AccountName;
											endforeach;
											echo form_dropdown('coa_inv', $option_coa_inv, $coa_inv, $extra_coa_inv);
										?>
									</div>
								</div>
								
								<div class="form-group">
									<label class="col-md-3 control-label" for="varchar">COA - COGS</label>
									<div class="col-md-6">
										<?php														 
											$extra_coa_cogs = 'id="coa_cogs" class="form-control" data-placeholder="COA COGS"';
											$option_coa_cogs[''] = '';
											foreach($cbo_coa_cogs as $r):
												$option_coa_cogs[$r->NoCOA] = $r->AccountName;
											endforeach;
											echo form_dropdown('coa_cogs', $option_coa_cogs, $coa_cogs, $extra_coa_cogs);
										?>
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-3 control-label" for="varchar">COA - Sales</label>
									<div class="col-md-6">
										<?php														 
											$extra_coa_sales = 'id="coa_sales" class="form-control" data-placeholder="COA SALES"';
											$option_coa_sales[''] = '';
											foreach($cbo_coa_sales as $r):
												$option_coa_sales[$r->NoCOA] = $r->AccountName;
											endforeach;
											echo form_dropdown('coa_sales', $option_coa_sales, $coa_sales, $extra_coa_sales);
										?>
									</div>
								</div>
								
							</div>
							<div class="form-actions">
								<div class="row">
									<div class="col-md-12">
										<input type="hidden" name="product_category_id" value="<?php echo $product_category_id; ?>" /> 
										<button type="submit" class="btn green"><?php echo $button ?></button> 
										<a href="<?php echo site_url('marketing/master/product_category') ?>" class="btn red"><i class="fa fa-close"></i> Cancel</a>
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

<script>
	$('select').select2({
		allowClear : true
	});
	
	$('#main_category_id').select2({
		allowClear : true
	});
</script>