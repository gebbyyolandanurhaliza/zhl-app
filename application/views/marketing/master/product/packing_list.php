<div class="page-content">
	<div class="container-fluid">
		
		<form action="<?php echo site_url('marketing/update_packing_list'); ?>" method="post" class="form-horizontal" id="form_packing_list">
		<div class="row ">
			<div class="col-md-12">
				
				<?php echo $message ?>
				
				<div class="portlet light">
					<div class="portlet-title">
						<div class="caption">
							<i class="fa fa-table theme-font"></i>
							<span class="caption-subject theme-font uppercase">Product Packing List</span>
						</div>
					</div>
					
					<div class="portlet-body form">
						<div class="doc-scroll" style="height: 400px;">
							<div class="table-scrollable">
								<table id="tblmst_product" class="table table-bordered table-condensed table-detail scrollable" >
									<thead>
										<tr class="double-border-bottom">
											<th>No</th>
											<th>Product Code</th>
											<th>Product Name</th>											
											<th>Sales Contract Product</th>											
											<th>Packing Size</th>
											<th>Gross Weight</th>
											<th>Net Weight</th>
											<th>Factory</th>
										</tr>
									</thead>
									<tbody>
										<?php
										if ($master_data){
											$no = 1;
											foreach ($master_data as $r) {
												
												switch ($r->factory_abbr) {
													case 'PSG':
														$cwp = 'P1';
														break;
													case 'RSUP':
														$cwp = 'P2';
														break;

													default:
														$cwp = '';
														break;
												}
												
												echo "<tr>";

												echo "<td class='text-center'>";
													echo "<input type='text' name='p_count[]' value='$no' class='form-control input-xs input-table text-center' style='width: 40px;' readonly>";
													echo "<input type='hidden' name='product_id[]' value='$r->product_id' id='product_id' class='form-control input-xs input-table text-center' style='width: 40px;' readonly>";
												echo "</td>";
												echo "<td>";
													echo "<input type='text' name='product_code[]' value='$r->product_code' title = '$r->product_code' class='form-control input-xs input-table' style='width: 170px;' readonly>";
												echo "</td>";
												echo "<td>";
													echo "<input type='text' name='product_name[]' value='$r->product_name' title = '$cwp - $r->product_name' class='form-control input-xs input-table' style='width: 400px;' readonly>";
												echo "</td>";
												echo "<td class='bg-editable'>";
													echo "<input type='text' name='product_view[]' value='$r->product_view' title = '$r->product_view' class='form-control input-xs input-table' style='width: 350px;'>";
												echo "</td>";
												echo "<td class='bg-editable'>";
													echo "<input type='text' name='packing_view[]' value='$r->packing_view' title = '$r->product_code' class='form-control input-xs input-table' style='width: 170px;'>";
												echo "</td>";
												echo "<td class='bg-editable'>";
													echo "<input type='text' name='gross_weight[]' value='$r->gross_weight' title = '$r->product_code' class='form-control input-xs input-table text-right autonumber autofocus' style='width: 100px;'>";
												echo "</td>";
												echo "<td class='bg-editable'>";
													echo "<input type='text' name='net_weight[]' value='$r->net_weight' title = '$r->product_code' class='form-control input-xs input-table text-right autonumber autofocus' style='width: 100px;'>";
												echo "</td>";
												echo "<td>";												
													echo "<input type='text' name='factory_abbr[]' value='".$cwp." (".$r->factory_abbr.")' class='form-control input-xs input-table text-center' style='width: 100px;' readonly>";
												echo "</td>";

												echo "</tr>";
												$no++;
											}								
										}
										?>
									</tbody>
								</table>
							</div>
						</div>
						
						<div class="form-actions">
							<div class="row">
								<div class="col-md-12">									
									<button type="submit" class="btn green pull-right"><i class="fa fa-save"></i>  Update Master Product</button>										
								</div>									
							</div>
						</div>
					</div>
					
				</div>
				
			</div>				
		</div>
		</form>
	</div>
</div>

<script>
	$('.autonumber').autoNumeric('init');
	
	$('.autofocus').on('click', function(){
		this.select();
	});
</script>