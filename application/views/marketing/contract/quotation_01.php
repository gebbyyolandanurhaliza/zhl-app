
<div class="page-content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				
				<?php echo $message ?>
				
				<div class="portlet light">
					
					<div class="portlet-title">
						<div class="caption">
							<i class="fa fa-table theme-font"></i>
							<span class="caption-subject theme-font uppercase"><?php echo $header_title ?></span>
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
						<?php 
						echo form_open($action, 'class="form-horizontal"');
						?>
							<div class="form-body row">
															
								<div class="col-md-12">
									
									<div class="panel panel-default">
										<div class="panel-heading">
											<h4 class="panel-title"><i class='fa fa-filter'></i> Confirmed Quotation :</h4>
										</div>
										<div class="panel-body">
											<div class="form-group">
												<label class="col-md-2 control-label" for="varchar">Customer</label>
												<div class="col-md-5">
													<input type="text" class="form-control" name="customer" id="customer" value="<?php echo $customer ?>" placeholder="customer name / code / company" title="Leave blank to show all the data" />
												</div>											
											</div>

											<div class="form-group">
												<label class="col-md-2 control-label" for="varchar">Sales Person</label>
												<div class="col-md-5">
													<?php 
														$extra_sales = 'id= "sales_id" class="form-control select2me" data-placeholder=" " title="Leave blank to show all the data" ';
														$option_sales[''] = '';
														foreach($cbo_sales as $r):
															$option_sales[$r->userid] = $r->firstname.' '.$r->lastname;
														endforeach;
														echo form_dropdown('sales_id', $option_sales, $sales_id, $extra_sales);
													?>
												</div>										
											</div>

											<div class="form-group">
												<label class="col-md-2 control-label" for="varchar">Document Date</label>
												<div class="col-md-5">
													<div class="input-group date-picker input-daterange" data-date="<?php echo $current_date ?>" data-date-format="dd/mm/yyyy">
														<input type="text" class="form-control" name="document_date1" value="<?php echo $document_date1 ?>" title="date format : dd/mm/yyyy">
														<span class="input-group-addon" style="background: transparent; border-color: transparent">to</span>
														<input type="text" class="form-control" name="document_date2" value="<?php echo $document_date2; ?>" title="date format : dd/mm/yyyy">
													</div>
												</div>
											</div>
										</div>
										<div class="panel-footer">											
											<button type="submit" class="btn blue"><i class="fa fa-filter"></i> Filter Quotation</button>
										</div>
									</div>
								</div>
							</div>

						<?php
						echo form_close();
						?>
						
						<?php 
						echo form_open('#', 'class="form-horizontal"');
						?>
						
						<div class="form-body row">
							<div class="col-md-12">
								<!--<h4 class="form-section"><i class="fa fa-pencil"></i> SALES QUOTATION LIST :</h4>-->

								<div class="table-scrollable-borderless">
									<div id="quotation_container">
										<table id = "tbl_confirm" class="table table-condensed table-bordered table-hover table-confirm">
											<thead>
												<tr >
													<th>#</th>
<!--													<th>Customer</th>-->
													<th>Company</th>
													<th>Quotation No</th>
													<th>Sales Person</th>
													<th>Document Date</th>													
													<th>Quotation Qty</th>
													<th>Contract Qty</th>
													<th>Balance Qty</th>
													<th>Status</th>
												</tr>
											</thead>
											<tbody>
												<?php 
												$i = 0;
												if ($search_result){									
													foreach($search_result as $r){
														$i++;
														echo "<tr>";
														echo "<td class='text-center w-100'>";
														echo "<div class='input-group input-table-group'>";
														echo '<span class="input-group-addon input-table-group-addon bootstrap-touchspin-postfix num" style="background: #FFFFFF;">' .$i . '</span>';
														echo "<input type='button' id='".encode_str($r->quotation_hdr_id,'contract')."' value='Create Contract' class='btn btn-xs default green-stripe create_contract'>";
														echo "</div>";
														echo "</td>";
//														echo "<td>$r->customer_name</td>";
														echo "<td>$r->customer_company_name</td>";
														echo "<td class='text-center w-120'>$r->quotation_number</td>";
														echo "<td>$r->sales_firstname $r->sales_lastname</td>";
														echo "<td class='text-center w-100'>".tgl_ind($r->document_date)."</td>";														
														echo "<td class='text-right w-40'>".number_format($r->total_qty_quotation)."</td>";
														echo "<td class='text-right w-40'>".number_format($r->total_qty_contract)."</td>";
														echo "<td class='text-right w-40'>".number_format($r->total_qty_quotation - $r->total_qty_contract)."</td>";
														echo "<td class='text-center w-70'>$r->status_badges</td>";
														echo "</tr>";
													}
												} else {
//													echo "<tr>";
//													echo "<td colspan='9' class='text-center'>No data available</td>";
//													echo "</tr>";
												}
												?>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
						
						<?php
						echo form_close();
						?>
						
					</div>	
					
					<div class="form-actions">
						<div class="row">
							<div class="col-md-12">
								<input type="button" class="btn btn-default fontawesome-font" value="&#xf002 Search Contract ..." data-target="#modal_find" data-toggle="modal">
								<a href="<?php echo site_url('sales-contract/create_no_quote')?>" class="btn purple">Create Sales Contract With No Quotation</a>
								<!--<a href="<?php // echo site_url('sales-contract/print-preview')?>" class="btn purple">Print Preview</a>-->
							</div>
						</div>
					</div>					
					
				</div>				
			</div>
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
								<input id="input_find" name="input_find" class="form-control" type="text" placeholder="Filter (Customer, Sales Person, Status)" >
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
	$('#tbl_confirm').dataTable();
	
	$('#tbl_confirm').on('click','.create_contract', function (event) {
		var id = $(this).attr('id');
		window.location = "<?php echo site_url('sales-contract/create/?id=')?>"+id;
	});
	
//	$('.create_contract').click(function(){
//		var id = $(this).attr('id');
//		window.location = "<?php // echo site_url('sales-contract/create/?id=')?>"+id;
//	});
	
	//fungsi ini untuk menghilangkan list data di modal
	$('.modal').on('hidden.bs.modal', function(){
		$('.v-scroll').html('');
	});
	
	$('#search_find').click(function(){
		var find = {find:$("#input_find").val()};
		$.ajax({
			type: "POST",
			url : "<?php echo site_url('sales-contract/find')?>",
			data: find,
			success: function(msg){
				$('#table_find').html(msg);
			}
		});
	});
</script>