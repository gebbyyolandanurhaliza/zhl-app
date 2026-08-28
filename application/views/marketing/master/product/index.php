<?php // echo show_title('PRODUCT DETAIL', 'Marketing') ?>

<div class="page-content">
	<div class="container-fluid">
		<div class="row ">
			<div class="col-md-12">
				<div class="portlet light">
					
					<div class="portlet-title">
						<div class="caption">
							<i class="fa fa-table theme-font"></i>
							<span class="caption-subject theme-font uppercase">Master Product</span>
						</div>
						<div class="actions">
							<?php echo anchor(site_url('marketing/create_master/product'), '<i class="fa fa-plus"></i> Create New Product', 'class="btn btn-primary"'); ?>							
						</div>						
					</div>
					
					<div class="portlet-body form">
						<?php echo form_open($action, 'class="form-horizontal"') ?>
						<div class="form-body row">
							<div class="col-md-12">
								
								<div class="input-group">					
									<input id="input_filter" name="input_filter" class="form-control" type="text" 
										   value ="<?php echo $input_filter ?>"
										   placeholder="Filter Product By Code / Description / Brand / Factory" >
									<span class="input-group-btn">
										<button type="submit" id="btn_filter" class="btn blue" style="border-width: 1px;">
											<i class="icon-magnifier"></i>
										</button>
									</span>
								</div>
							</div>
						</div>
						<?php echo form_close() ?>
						
						<div class="table-scrollable-borderless">
							<table id = "tbl_list_product" class="table table-condensed table-bordered table-hover">
								<thead>
									<tr>
										<th>Actions</th>
										<th>Product Code</th>
										<th>Description</th>
										<th>Brand</th>
										<th>Factory</th>
										<th>Category</th>
									</tr>
								</thead>
								<tbody>
									<?php
									if ($master_data){
										foreach ($master_data as $r) {
											$status = ($r->inactive == 1) ? '<span class="label label-sm label-danger">Not Active</span>' : '';
											$disable_inactive = ($r->inactive == 1) ? 'disabled' : '';
												
											echo "<tr>";
											echo "<td class='w-100'>";
											echo anchor(site_url('marketing/delete_master/product/'.$r->product_id),'<i class="fa fa-trash-o"></i>','class="btn default btn-sm red-stripe" '.$disable_inactive.' onclick="javasciprt: return confirm(\'Are You Sure Delete Product '.$r->product_name.'?\')"'); 
											echo anchor(site_url("marketing/edit_master/product/$r->product_id"), "<i class='fa fa-edit'>", "class='btn default btn-sm green-stripe' $disable_inactive");
											echo "</td>";
											echo "<td class='w-150'>$r->product_code</td>";
											echo "<td>$status $r->product_name</td>";
											echo "<td class='w-120'>$r->brand_name</td>";
											echo "<td class='w-70'>$r->factory_abbr</td>";
											echo "<td class='w-230'>$r->product_category_name</td>";
											echo "</tr>";
										}
									}
									?>
								</tbody>
							</table>
						</div>
						
					</div>
					
				</div>
			</div>
		</div>
	</div>
</div>

<script>
	$('#tbl_list_product').DataTable({
		bFilter: false,
		bLengthChange: false,
		autoWidth	: false
	});
</script>