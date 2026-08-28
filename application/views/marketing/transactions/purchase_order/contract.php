
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
											<h5 class="panel-title"><i class='fa fa-filter'></i> Filter data</h5>
										</div>
										<div class="panel-body">
											<div class="form-group">
												<label class="col-md-2 control-label" for="varchar">Search Contract By</label>
												<div class="col-md-7">
													<input type="text" class="form-control" name="search_contract" id="search_contract" value="<?php echo $search_contract ?>" placeholder="Contract number / factory / customer" title="Leave blank to show all the data" />
												</div>											
											</div>

											<div class="form-group">
												<label class="col-md-2 control-label" for="varchar">Contract Date</label>
												<div class="col-md-4">
													<div class="input-group date-picker input-daterange" data-date="<?php echo $current_date ?>" data-date-format="dd/mm/yyyy">
														<input type="text" class="form-control" name="contract_date1" value="<?php echo $contract_date1 ?>" title="date format : dd/mm/yyyy">
														<span class="input-group-addon" style="background: transparent; border-color: transparent">to</span>
														<input type="text" class="form-control" name="contract_date2" value="<?php echo $contract_date2; ?>" title="date format : dd/mm/yyyy">
													</div>
												</div>
											</div>
										</div>
										<div class="panel-footer">
											<button type="submit" class="btn blue"><i class="fa fa-filter"></i> Filter Sales Contract</button>
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
									<div id="contract_container">
										<table id="tbl_contract" class="table table-condensed table-bordered table-hover">
											<thead>
												<tr >
													<th style="width: 100px;">#</th>
													<th style="width: 100px;">Contract No</th>
													<th style="width: 100px;">Contract Date</th>
													<th style="width: 100px;">Factory</th>
													<th>Customer</th>
													<th style="width: 100px;">Total Contract Qty</th>
													<th style="width: 100px;">Total PO Qty</th>
													<th style="width: 100px;">Balance Qty</th>
												</tr>
											</thead>
											<tbody>
												<?php 
												$i = 0;
												if ($search_result){									
													foreach($search_result as $r){
														$i++;
														$balance_qty = $r->total_qty_contract - $r->total_qty_po;
														echo "<tr>";
														echo "<td class='text-center'>";
														echo "<input type='button' id='".encode_str($r->contract_hdr_id)."' value='Create PO' class='btn btn-xs default green-stripe create_po'>";
														echo "</td>";
														echo "<td class='text-center'>$r->contract_no</td>";
														echo "<td class='text-center'>".tgl_ind($r->contract_date)."</td>";
														echo "<td class='text-center'>$r->supplier_id</td>";
														echo "<td>$r->customer_company_name</td>";
														echo "<td class='text-right'>".number_format($r->total_qty_contract,0,'.',',')."</td>";
														echo "<td class='text-right'>".number_format($r->total_qty_po,0,'.',',')."</td>";
														echo "<td class='text-right'>".number_format($balance_qty,0,'.',',')."</td>";
														echo "</tr>";
													}
//												} else {
//													echo "<tr>";
//													echo "<td colspan='8' class='text-center'>No data available</td>";
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
								<input type="button" class="btn btn-default fontawesome-font" value="&#xf002 Search PO ..." data-target="#modal_find" data-toggle="modal">
								<!--<a href="<?php // echo site_url('marketing-transaction/sales-contract/create_no_quote')?>" class="btn purple">Create Sales Contract With No Sales Quotation</a>-->
							</div>
						</div>
					</div>					
					
				</div>				
			</div>
		</div>
	</div>
</div>

<div id="find">	
	<div id="modal_find" class="modal fade bs-modal-lg" role="dialog" tabindex="-1" data-backdrop="static" data-keyboard="false" aria-hidden="true">
		<div class="modal-dialog modal-full">
			<div class="modal-content">
				
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
					<div class="row">
						<div class="col-md-7">
							<div class="input-group">					
								<input id="input_find" name="input_search" class="form-control" type="text" placeholder="Filter Data Purchase Order (PO No, Factory, Buyer)" >
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
						<div class="v-scroll h-400 loading_find">
							
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
	$('#tbl_contract').dataTable();
	
	$('#tbl_contract').on('click','.create_po', function (event) {
		var id = $(this).attr('id');
		window.location = "<?php echo site_url('marketing-transaction/purchase-order/create/?id=')?>"+id;
	});
	
//	$('.create_po').click(function(){
//		var id = $(this).attr('id');
//		window.location = "<?php // echo site_url('marketing-transaction/purchase-order/create/?id=')?>"+id;
//	});
	
	//fungsi ini untuk menghilangkan list data di modal
	$('.modal').on('hidden.bs.modal', function(){
		$('.v-scroll').html('');
	});
	
	$('#search_find').click(function(){
		var find = {find:$("#input_find").val()};
		$.ajax({
			type: "POST",
			url : "<?php echo site_url('marketing_transaction/purchase_order/find')?>",
			data: find,
			beforeSend : function(){
				$(".loading_find").html('');
				$(".loading_find").html(loading_anim);
			},
			success: function(msg){
				$('#table_find').html(msg);
			}
		});
	});
</script>