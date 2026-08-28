
<div class="page-content">
	
	<div class="container-fluid">
		<div class="row ">
			<div class="col-md-12">
				
				<?php echo $message;?>
				
				<div class="portlet light">
					<div class="portlet-title">
						<div class="caption">
							<i class="fa fa-table theme-font"></i>
							<span class="caption-subject theme-font uppercase">Master Product</span>
						</div>
						<div class="actions">
							<?php echo anchor(site_url('marketing/create_master/product'), '<i class="fa fa-plus"></i> Create New Product', 'class="btn btn-primary"'); ?>
						</div>
<!--						<div class="tools">							
							<a href="javascript:;" class="collapse"></a>
							<a href="javascript:;" class="reload"></a>
						</div>-->
					</div>

					<div class="portlet-body flip-scroll">
						<div class="table-scrollable-borderless">
							<table id="tblmst_product" class="table table-bordered table-striped table-condensed" >
							<thead>
								<tr>
									<th class="text-center">#</th>
									<th scope="col" width="30px">No</th>
									<th scope="col" width="150px">Code</th>
									<th scope="col" width="350px">Product Description</th>									
									<th class="text-center">Brand</th>
									<th class="text-center">Factory</th>
									<th class="text-center">Category</th>									
									<th class="text-center">Volume</th>
									<th class="text-center">UOM Volume</th>
									<th class="text-center">Packing</th>
									<th class="text-center">UOM Qty</th>									
									<th class="text-center">Container 20ft</th>
									<th class="text-center">Container 40ft</th>
									<th class="text-center">Drained Weight</th>
									<th class="text-center">Fat Content</th>
									<th class="text-center">Packing Size</th>
									<th class="text-center">Created By</th>
									<th class="text-center">Created Date</th>
									<th class="text-center">Updated By</th>
									<th class="text-center">Updated Date</th>
									
								</tr>
							</thead>
							<tbody>
								<?php 
								$no = 1;
								foreach ($master_data as $r){
									echo "<tr>";
									echo "<td style='text-align:center' width='100px'>";
									echo anchor(site_url('marketing/delete_master/product/'.$r->product_id),'<i class="fa fa-trash-o"></i>','class="btn default btn-sm red-stripe" onclick="javasciprt: return confirm(\'Are You Sure Delete Product '.$r->product_name.'?\')"'); 
									echo anchor(site_url("marketing/edit_master/product/$r->product_id"), "<i class='fa fa-edit'>", "class='btn default btn-sm green-stripe'");
//									echo "<a href='".site_url("marketing/edit_master/product/$r->product_id")."' class='btn default btn-sm green-stripe'><i class='fa fa-edit'></i></a>";
									echo "</td>";
									echo "<td class='text-center'>".$no++."</td>";
									echo "<td>$r->product_code</td>";
									echo "<td>$r->product_name</td>";
									echo "<td>$r->brand_name</td>";
									echo "<td>$r->factory_abbr</td>";
									echo "<td>$r->product_category_name</td>";
									echo "<td>$r->uom_volume</td>";
									echo "<td>$r->uom_volume_name</td>";
									echo "<td>$r->per_packing_imm x $r->per_packing</td>";
									echo "<td>$r->uom_quantity_name</td>";
									echo "<td>$r->container_20ft</td>";
									echo "<td>$r->container_40ft</td>";
									echo "<td>$r->drained_weight</td>";
									echo "<td>$r->fat_content</td>";
									echo "<td>$r->packing_size</td>";
									echo "<td>$r->created_by</td>";
									echo "<td>$r->created_date</td>";
									echo "<td>$r->updated_by</td>";
									echo "<td>$r->updated_date</td>";
									echo "</tr>";									
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
//	$(document).ready(function(){
//		$("#tblmst_product").dataTable({
//			"sScrollX": "100%", //This is what made my columns increase in size.
//			"bScrollCollapse": true,
////			"sScrollY": "320px",
//			"autoWidth"	: false
//		});	
//	});
</script>
	