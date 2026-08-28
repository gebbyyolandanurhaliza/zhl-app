<div class="page-content">
	<div class="container-fluid">
		<div class="row ">
			<form action="#" method="post" class="form-horizontal">
				<div class="col-md-12">

					<?php echo $message ?>
					
					<div class="portlet light">

						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-table theme-font"></i>
								<span class="caption-subject theme-font uppercase">SHIPPING ADVICE</span>
							</div>
							<div class="tools">
								<a href="javascript:;" class="collapse">
								</a>
								<a href="javascript:;" class="reload">
								</a>
								<a href="javascript:;" class="fullscreen"></a>
							</div>
						</div>

						<div class="portlet-body form">

							<div class="form-body row">
								<div class="col-md-12">
									
									<div class="panel panel-default">
										<div class="panel-heading">
											<h4 class="panel-title"><i class='fa fa-filter'></i> Filter From SI :</h4>
										</div>
										
										<div class="panel-body">
											<div class="form-group">
												<label class="col-sm-1 control-label" for="varchar">Search</label>
												<div class="col-sm-11">
													<input type="text" class="form-control" name="filter_by_search" id="filter_by_search" placeholder="Filter By product name, product code, brand, factory" />
												</div>											
											</div>
											
										</div>
										
										<div class="panel-footer">											
											<button class="btn blue" id="btn_filter"><i class="fa fa-filter"></i> Filter</button>
										</div>
									</div>

									<div class="panel panel-default">
										<div class="panel-heading">
											<h4 class="panel-title"><i class='fa fa-list'></i> Customer List :</h4>
										</div>
										
										<div class="panel-body">
											
											<div id="filtered_list" class="table-scrollable-borderless">
												
												<table id="sa_cust_list" class="table table-bordered table-condensed">
													<thead>
														<tr>
															<th>#</th>
															<th>Customer</th>
															<th>Total PO</th>
														</tr>
													</thead>
													<tbody>
														<?php
														if ($filtered){
															$i = 1;
															foreach ($filtered as $r) {
																echo "<tr>";
																echo "<td style='width: 150px;'>";
																echo "<input type='button' cust_id='".encode_str($r->customer_id, 'sa')."' value='Create Shipping Advice' class='btn btn-xs default green-stripe create_sa'>";
																echo "</td>";
																echo "<td>$r->customer_name</td>";
																echo "<td style='width: 50px;text-align: center;'>$r->total_po</td>";
																echo "</tr>";																
															}
														} else {
															echo "<tr><td colspan='3' style='text-align: center;'>No Data Available</td></tr>";
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
						
						<div class="form-actions">
							<div class="row">
								<div class="col-md-12">
									<input type="button" class="btn btn-default fontawesome-font" value="&#xf002 Search Shipping Advice ..." data-target="#modal_find" data-toggle="modal">
									<!--<a href="<?php // echo site_url('sales-contract/print-preview')?>" class="btn purple">Print Preview</a>-->
								</div>
							</div>
						</div>	

					</div>

				</div>
			</form>
		</div>
		
	</div>
</div>

<div id="find">
	<div id="modal_find" class="modal fade" role="dialog" tabindex="-1" data-backdrop="static" data-keyboard="false" aria-hidden="true" data-width="75%">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
					<div class="row">
						<div class="col-md-7">
							<div class="input-group">					
								<input id="input_find" name="input_find" class="form-control" type="text" placeholder="Filter (Customer,  Status)" >
								<span class="input-group-btn">
									<button type="button" id="search_find" class="btn blue" style="border-width: 1px;">
										<i class="fa fa-filter"></i>
									</button>
								</span>
							</div>
						</div>
					</div>
				</div>

				<div class="modal-body padding-5">
					<div id="table_find">
						<div class="v-scroll">

						</div>
					</div>
				</div>

				<div class="modal-footer">
					<button type="button" data-dismiss="modal" class="btn btn-default">Cancel</button>			
				</div>		
			</div>
		</div>
	</div>
</div>

<script>
	
	$('#btn_filter').click(function(){
		var filter_by_search = {filter_by_search:$("#filter_by_search").val()};
		$.ajax({
			type: "POST",
			url : "<?php echo site_url('shipping-advice/filter')?>",
			data: filter_by_search,
			success: function(msg){
				$('#filtered_list').html(msg);
			}
		});
	});
	
	$('.create_sa').click(function(){
		var cust_id = $(this).attr('cust_id');
		window.location = "<?php echo site_url('shipping-advice/create/?cust_id=')?>"+cust_id;
	});
	
	//fungsi ini untuk menghilangkan list data di modal
	$('.modal').on('hidden.bs.modal', function(){
		$('.v-scroll').html('');
	});
	
	$('#search_find').click(function(){
		var find = {find:$("#input_find").val()};
		$.ajax({
			type: "POST",
			url : "<?php echo site_url('shipping-advice/find')?>",
			data: find,
			success: function(msg){
				$('#table_find').html(msg);
			}
		});
	});
</script>