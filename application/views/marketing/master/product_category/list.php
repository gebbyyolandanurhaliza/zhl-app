<style type="text/css">		
	.sembunyi{
		display: none;
	}
</style>

<div class="page-content">
	
	<div class="container-fluid">
		<div class="row ">
			<div class="col-md-12">
				
				<?php echo $message;?>
				
				<div class="portlet light">
					<div class="portlet-title">
						<div class="caption">
							<i class="fa fa-table theme-font"></i>
							<span class="caption-subject theme-font uppercase">Master Product Category</span>
						</div>
						<div class="actions">
							<?php echo anchor(site_url('marketing/create_master/product_category'), '<i class="fa fa-plus"></i> Create New Product Category', 'class="btn btn-primary"'); ?>
						</div>
					</div>

					<div class="portlet-body">
						<div class="table-scrollable">
							<table id="tblmst_product_category" class="table table-bordered table-striped table-condensed table-detail scrollable">
								<thead>
									<tr class="double-border-bottom">
										<th>#</th>
										<th class="sembunyi">ID</th>
										<th>Name</th>
										<th>Main Category</th>
										<th>PSG PO Format (P1)</th>
										<th>RSUP PO Format (P2)</th>
										<th>PSJ PO Format</th>
										<th>COA Inventory</th>
										<th>COA COGS</th>
										<th>Created By</th>
										<th>Created Date</th>
										<th>Updated By</th>
										<th>Updated Date</th>
									</tr>
								</thead>
								<tbody>
									<?php
									foreach ($master_data as $master)
									{
									?>
										<tr>
											<td class="bg-editable">
												<div class="input-group input-table-group" style="text-align:center; width: 70px !important;"> 
													<?php 
														echo anchor(site_url('marketing/delete_master/product_category/'.$master->product_category_id), '<i class="fa fa-trash-o"></i>','class="btn default btn-xs red-stripe" onclick="javasciprt: return confirm(\'Are You Sure Delete Data '.$master->product_category_name.'?\')"'); 
														echo anchor(site_url('marketing/edit_master/product_category/'.$master->product_category_id),'<i class="fa fa-edit"></i>', 'class="btn default btn-xs green-stripe"'); 
													?>
												</div>
											</td>
											<td class="bg-editable text-right sembunyi"><?php echo $master->product_category_id ?></td>
											<td class="bg-editable">
												<?php echo "<input class='input-table' style='width:250px;' value='$master->product_category_name' disabled>"; ?>
											</td>
											<td class="bg-editable">
												<?php echo "<input class='input-table' style='width:150px;' value='$master->main_category_name' disabled>"; ?>
											</td>										
											<td class="bg-editable">
												<?php echo "<input class='input-table text-center' style='width:150px;' value='$master->po_code_prefix_psg' disabled>"; ?>
											</td>
											<td class="bg-editable">
												<?php echo "<input class='input-table text-center' style='width:150px;' value='$master->po_code_prefix_rsup' disabled>"; ?>
											</td>
											<td class="bg-editable">
												<?php echo "<input class='input-table text-center' style='width:150px;' value='$master->po_code_prefix_psj' disabled>"; ?>
											</td>
											<td class="bg-editable">
												<?php echo "<input class='input-table' style='width:250px;' value='$master->coa_inventory_name' disabled>"; ?>												
											</td>
											<td class="bg-editable">
												<?php echo "<input class='input-table' style='width:250px;' value='$master->coa_cogs_name' disabled>"; ?>
											</td>
											<td class="bg-editable">
												<?php echo "<input class='input-table text-center' style='width:130px;' value='$master->created_by' disabled>"; ?>
											</td>
											<td class="bg-editable">
												<?php echo "<input class='input-table text-center' style='width:130px;' value='$master->created_date' disabled>"; ?>
											</td>
											<td class="bg-editable">
												<?php echo "<input class='input-table text-center' style='width:120px;' value='$master->updated_by' disabled>"; ?>
											</td>
											<td class="bg-editable">
												<?php echo "<input class='input-table text-center' style='width:130px;' value='$master->updated_date' disabled>"; ?>
											</td>
										</tr>
									<?php
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

<script type="text/javascript">
//	$(document).ready(function () {
//		$("#tblmst_product_category").dataTable();
//	});
</script>