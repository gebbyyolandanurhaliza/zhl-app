
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
										<h5 class="panel-title"><i class='fa fa-filter'></i> Filter PO data</h5>
									</div>
									<div class="panel-body">
										<div class="form-group">
											<label class="col-md-2 control-label" for="varchar">Search PO By</label>
											<div class="col-md-7">
												<input type="text" class="form-control" name="search_po" id="search_po" value="<?php echo $search_po ?>" placeholder="PO number / factory / customer" title="Leave blank to show all the data" />
											</div>
										</div>

										<div class="form-group">
											<label class="col-md-2 control-label" for="varchar">PO Date</label>
											<div class="col-md-4">
												<div class="input-group date-picker input-daterange" data-date="<?php echo $current_date ?>" data-date-format="dd/mm/yyyy">
													<input type="text" class="form-control" name="po_date1" value="<?php echo $po_date1 ?>" title="date format : dd/mm/yyyy">
													<span class="input-group-addon" style="background: transparent; border-color: transparent">to</span>
													<input type="text" class="form-control" name="po_date2" value="<?php echo $po_date2; ?>" title="date format : dd/mm/yyyy">
												</div>
											</div>
										</div>
									</div>
									<div class="panel-footer">
										<button type="submit" class="btn blue"><i class="fa fa-filter"></i> Filter PO</button>
									</div>
								</div>
							</div>
						</div>

						<?php
						echo form_close();
						?>

						<div class="form-body row">
							<div class="col-md-12">
								<!--<div class="table-scrollable-borderless">-->
									<div id="po_container">
										<table id = "tbl_po" class="table table-condensed table-bordered table-hover">
											<thead>
												<tr >
													<th>#</th>
													<th>PO Number</th>
													<th>PO Date</th>
													<th>Factory</th>
													<th>Customer</th>
													<th>Total Qty</th>
												</tr>
											</thead>
											<tbody>
												<?php
												$i = 0;
												if ($search_result){
													foreach($search_result as $r){
														$i++;
														echo "<tr>";
														echo "<td class='text-center w-200'>";
														echo "<input type='button' id='".encode_str($r->po_hdr_id)."' value='Create Shipping Instruction' class='btn btn-xs default green-stripe create_shp'>";
														echo "</td>";
														echo "<td class='text-center w-120'>$r->po_number</td>";
														echo "<td class='text-center w-120'>".tgl_ind($r->po_date)."</td>";
														echo "<td class='text-center w-120'>$r->supplierid</td>";
														echo "<td>$r->customer_company_name</td>";
														echo "<td class='text-right w-100'>".number_format($r->total_qty_po,0,'.',',')."</td>";
														echo "</tr>";
													}
//												} else {
//													echo "<tr>";
//													echo "<td colspan='6' class='text-center'>No data available</td>";
//													echo "</tr>";
												}
												?>
											</tbody>
										</table>
									</div>
								<!--</div>-->
							</div>
						</div>

					</div>

					<div class="form-actions">
						<div class="row">
							<div class="col-md-12">
								<input type="button" class="btn btn-default fontawesome-font" value="&#xf002 Search SI ..." data-target="#modal_find" data-toggle="modal">

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
		<div class="modal-dialog modal-full">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
					<div class="row">
						<div class="col-md-7">
							<div class="input-group">
								<input id="input_find" name="input_find" class="form-control" type="text" placeholder="Filter (PO Number, Sales Contract Number, Customer)" >
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
					<div id="table_find" class="table_find">
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
	$('#tbl_po').dataTable();

	$('#tbl_po').on('click','.create_shp', function (event) {
		var id = $(this).attr('id');
		window.location = "<?php echo site_url('marketing-transaction/shipping-instruction/create/?id=')?>"+id;
	});

//	$('.create_shp').click(function(){
//		var id = $(this).attr('id');
//		window.location = "<?php // echo site_url('marketing-transaction/shipping-instruction/create/?id=')?>"+id;
//	});

	//fungsi ini untuk menghilangkan list data di modal
	$('.modal').on('hidden.bs.modal', function(){
		$('.v-scroll').html('');
	});

	$('#search_find').click(function(){
		var find = {find:$("#input_find").val()};
		$.ajax({
			type: "POST",
			url : "<?php echo site_url('marketing_transaction/shipping_instruction/find')?>",
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
