<div class="page-content">
	<div class="container-fluid">
		<div class="row ">
			
			<form action="<?php echo $action; ?>" method="post" class="form-horizontal">
				<div class="col-md-12">
					<?php echo $message ?>

					<div class="col-md-12">
						<div class="portlet light">

							<div class="portlet-title">
								<div class="caption">
									<i class="fa fa-table theme-font"></i>
									<span class="caption-subject theme-font uppercase">Shipping Advice</span>
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

										<div class="form-group">
											<label class="col-md-1 control-label" for="varchar">Customer</label>
											<div class="col-md-7">
												<?php
												$extra_customer = 'disabled id="customer_list" class="form-control" ';
												$option_customer[''] = '';
												foreach($cbo_customer as $r):
													$option_customer[$r->customer_id] = $r->customer_code.' - '.$r->customer_name;
												endforeach;
												echo form_dropdown('customer_list', $option_customer, $customer_id, $extra_customer);
												echo form_hidden('customer_id', $customer_id);
												?>
											</div>
										</div>
										
										<div class="form-group">
											<label class="col-md-1 control-label" for="varchar">Att.</label>
											<div class="col-md-4">
												<input name="att" type="text" class="form-control" value="<?php echo $att ?>">
											</div>
											
											<label class="col-md-1 control-label" for="varchar">Period</label>
											<div class="col-md-2">
												<input required type="text" class="form-control date date-picker" data-date="<?php echo $current_date ?>" 
													   data-date-format="dd/mm/yyyy" name="sa_period" id="sa_period" value="<?php echo $sa_period; ?>" 
													   title="date format : dd/mm/yyyy" />
											</div>
										</div>
										
									</div>
								</div>
								
								<hr>
								
								<div class="form-body row">

									<div class="col-md-12">
										
										<div id="sa_content">
											<div class="table-scrollable">
												<table class="table table-bordered table-condensed table-detail scrollable" id="tbl_sa_dtl">
													<thead>
														<tr>
															<th style="width:40px !important">#</th>
															<th width='100px'>P.O. No</th>
															<th width='40px'>20'</th>
															<th width='40px'>40'</th>
															<th width='40px'>CT</th>													
															<th width='150px'>Ctnr/Seal No</th>
															<th width='200px'>Destination</th>
															<th width='350px'>Description/Brand</th>
															<th width='100px'>REF:</th>															
															<th width='350px'>Vessel Details</th>
														</tr>
													</thead>
													<tbody>
														<?php
														if ($list_po){
															$i = 1;
															foreach ($list_po as $s) {
																echo "<tr>";
																echo "<td style='text-align: center;' class='bg-editable'>";
																echo "<input type='button' style='width: 80px; margin-left: 5px; margin-top: 2px;' class='btn default btn-xs red-stripe' onclick='removeRow(this)' value='Remove'>";
																echo "<input type='hidden' name='po_hdr_id[]' value='$s->po_hdr_id'>";
																echo "</td>";
																
																echo "<td style='text-align: center;'>";
																echo "<input name='sa_po_number[]' value='$s->po_number' readonly class='form-control input-xs input-table text-center' style='width: 120px;'>";
																echo "</td>";
																
																echo "<td style='text-align: center;'>";
																echo "<input name='sa_c20[]' value='$s->c20' readonly class='form-control input-xs input-table text-center' style='width: 50px;'>";
																echo "</td>";
																
																echo "<td style='text-align: center;'>";
																echo "<input name='sa_c40[]' value='$s->c40' readonly class='form-control input-xs input-table text-center' style='width: 50px;'>";
																echo "</td>";
																
																echo "<td style='text-align: center;'>";
																echo form_hidden('sa_container_id[]', $s->container_id);
																echo "<input name='sa_ct[]' value='$s->container_abbr' readonly class='form-control input-xs input-table text-center' style='width: 50px;'>";
																echo "</td>";
																
																echo "<td style='text-align: center;' class='bg-editable'>";
																echo "<textarea name='sa_seal[]' rows=4 class='form-control input-xs input-table' style='width:200px;'>$s->seal</textarea>";
																echo "</td>";
																																
																echo "<td style='text-align: center;' class='bg-editable'>";
																echo form_hidden('sa_destination_id[]', $s->destination_id);
																echo "<textarea name='sa_destination[]' rows=4 class='form-control input-xs input-table' style='width:200px;'>$s->port_name</textarea>";
																echo "</td>";
																
																echo "<td style='text-align: center;' class='bg-editable'>";
//																echo form_hidden('sa_product_id[]', $s->product_id);
//																echo form_hidden('sa_brand_id[]', $s->brand_id);
//																echo "<textarea name='sa_product[]' rows=4 class='form-control input-xs input-table' style='width:350px;'>";
//																echo $s->product_name;
//																echo "\n$s->brand_name";
//																echo "</textarea>";
//																echo "<div style='width:350px;'>";
																	if ($list_product){
																		echo "<textarea name='sa_product[]' style='width:350px;' class='form-control input-xs input-table autosizeme'>";
																		foreach ($list_product as $p){
																			if ($p->po_hdr_id == $s->po_hdr_id){
																				echo "$p->product_name\n";
																				echo "$p->brand_name\n";
																			}
																		}
																		echo "</textarea>";
																	}
//																echo "</div>";
																echo "</td>";
																
																echo "<td style='text-align: center;' class='bg-editable'>";
																echo "<textarea name='sa_reff[]' rows=4 class='form-control input-xs input-table' style='width:100px;'>";
																echo $s->reff;
																echo "</textarea>";
																echo "</td>";
																
																echo "<td class='bg-editable'>";
																	echo "<div class='input-group' style='margin-bottom: 2px;'>";
																	echo "<label class='input-group-addon input-table-group-addon'>ETD</label>";
																	echo "<input name='sa_etd[]' value='".tgl_ind($s->etddate)."' class='form-control input-xs input-table' style='width: 150px;'>";
																	echo "<label class='input-group-addon input-table-group-addon'>ETA</label>";
																	echo "<input name='sa_eta[]' value='".tgl_ind($s->etadate)."' class='form-control input-xs input-table' style='width: 150px;'>";
																	echo "</div>";
																	
																	echo "<textarea name='sa_vessel[]' rows=1 class='form-control input-xs input-table' style='width:400px;'>";
																	echo "VESL / VOY : $s->vessel\n";
																	echo "</textarea>";
																	echo "<textarea name='sa_bkgref[]' rows=1 class='form-control input-xs input-table' style='width:400px;'>";
																	echo "BKG REF : $s->buyer_si";
																	echo "</textarea>";
																echo "</td>";
																echo "</tr>";
																$i++;
															}
														}
														
														if ($detail_sa){
															foreach ($detail_sa as $d){
																echo "<tr>";
																echo "<td style='text-align: center;' class='bg-editable'>";
																echo "<input type='button' style='width: 80px; margin-left: 5px; margin-top: 2px;' class='btn default btn-xs red-stripe' onclick='removeRow(this)' value='Remove'>";
																echo "<input type='hidden' name='po_hdr_id[]' value='$d->po_hdr_id'>";
																echo "</td>";
																
																echo "<td style='text-align: center;'>";
																echo "<input name='sa_po_number[]' value='$d->po_number' readonly class='form-control input-xs input-table text-center' style='width: 120px;'>";
																echo "</td>";
																
																echo "<td style='text-align: center;'>";
																echo "<input name='sa_c20[]' value='$d->c20' readonly class='form-control input-xs input-table text-center' style='width: 50px;'>";
																echo "</td>";
																
																echo "<td style='text-align: center;'>";
																echo "<input name='sa_c40[]' value='$d->c40' readonly class='form-control input-xs input-table text-center' style='width: 50px;'>";
																echo "</td>";
																
																echo "<td style='text-align: center;'>";
																echo form_hidden('sa_container_id[]', $d->container_id);
																echo "<input name='sa_ct[]' value='$d->ct' readonly class='form-control input-xs input-table text-center' style='width: 50px;'>";
																echo "</td>";
																
																echo "<td style='text-align: center;' class='bg-editable'>";
																echo "<textarea name='sa_seal[]' class='form-control input-xs input-table' style='width:200px;'>$d->seal</textarea>";
																echo "</td>";
																																
																echo "<td style='text-align: center;' class='bg-editable'>";
																echo form_hidden('sa_destination_id[]', $d->destination_id);
																echo "<textarea name='sa_destination[]' class='form-control input-xs input-table' style='width:200px;'>$d->destination</textarea>";
																echo "</td>";
																
																echo "<td style='text-align: center;' class='bg-editable'>";
																	echo "<textarea name='sa_product[]' style='width:350px;' class='form-control input-xs input-table autosizeme'>";
																	echo rtrim($d->product_description);
																	echo "</textarea>";
																echo "</td>";
																
																echo "<td style='text-align: center;' class='bg-editable'>";
																echo "<textarea name='sa_reff[]' class='form-control input-xs input-table' style='width:100px;'>";
																echo rtrim($d->reff);
																echo "</textarea>";
																echo "</td>";
																
																echo "<td class='bg-editable'>";
																	echo "<div class='input-group' style='margin-bottom: 2px;'>";
																	echo "<label class='input-group-addon input-table-group-addon'>ETD</label>";
																	echo "<input name='sa_etd[]' value='".rtrim($d->etd)."' class='form-control input-xs input-table' style='width: 150px;'>";
																	echo "<label class='input-group-addon input-table-group-addon'>ETA</label>";
																	echo "<input name='sa_eta[]' value='".rtrim($d->eta)."' class='form-control input-xs input-table' style='width: 150px;'>";
																	echo "</div>";
																	
																	echo "<textarea name='sa_vessel[]' rows=1 class='form-control input-xs input-table' style='width:400px;'>";
																	echo rtrim($d->vessel);
																	echo "</textarea>";
																	echo "<textarea name='sa_bkgref[]' rows=1 class='form-control input-xs input-table' style='width:400px;'>";
																	echo rtrim($d->bkgref);
																	echo "</textarea>";
																echo "</td>";
																echo "</tr>";
															}
														}
														?>
													</tbody>
												</table>
											</div>
										</div><!--/sa_content-->

									</div>
								</div>

								<div class="form-actions">
									<div class="row">
										<div class="col-md-12">
											<?php echo form_hidden('act', $act)?>
											<?php echo form_hidden('sa_id', $sa_id)?>
											<input type="button" class="btn btn-default fontawesome-font" value="&#xf002 Search Sales Advice ..." data-target="#modal_find" data-toggle="modal">
											<?php echo $btn_print ?>
											<?php echo $btn_delete ?>
											<a href="<?php echo site_url('shipping_advice')?>" type="button" class="btn red pull-right"><i class="fa fa-close"></i> Cancel</a>
											<button type="submit" class="btn green pull-right"><i class="fa fa-save"></i> <?php echo $submit_caption?></button>										
										</div>
									</div>
								</div>
	
							</div><!-- /portlet-body -->
							
						</div><!-- portlet-light -->
					</div><!-- col-md-12 -->
				
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

<script type="text/javascript">
	$('select').select2({
		allowClear	: true
	});
	
	//	autosizeme => autosize textarea
	$('textarea').each(function(){
		autosize(this);
	});
	
	//fungsi ini untuk menghilangkan list data di modal
	$('.modal').on('hidden.bs.modal', function(){
		$('.v-scroll').html('');
	});
	
	$('#search_sa').on('click',function(){
		var custid = $("#customer_id").val();
		var find = $("#input_search").val();
		
		$.ajax({
			type: "POST",
			url : "<?php echo site_url('shipping_advice/add_po')?>",
			data: {
				"find":find,
				"custid":custid
			},
			success: function(msg){
				$('#table_po').html(msg);
			}
		});
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
	
	$('#btn_delete').click(function(){
		var sa_id = $(this).attr("sa_id");
		bootbox.confirm('Are you sure want to delete shipping advice?',function(result){
			if (result){
				$.ajax({
					url:"<?php echo site_url('shipping-advice/delete');?>",
					type:"POST",
					data:"sa_id="+sa_id,
					cache:false,
					success:function(){						
						$.bootstrapGrowl('<i class="fa fa-info-circle"></i> Delete Success.', {
//							ele: 'body', // which element to append to
							type: 'success', // (null, 'info', 'danger', 'success', 'warning')
							offset: {
								from: 'top',
								amount: 250
							}, // 'top', or 'bottom'
							align: 'center', // ('left', 'right', or 'center')
							width: 'auto', // (integer, or 'auto')
							delay: 5000, // Time while the message will be displayed. It's not equivalent to the *demo* timeOut!
							allow_dismiss: true, // If true then will display a cross to close the popup.
							stackup_spacing: 10 // spacing between consecutively stacked growls.
						});
						return location.href = "<?php echo site_url('shipping-advice');?>";
					},
					error:function(){
						$.bootstrapGrowl('<i class="fa fa-info-circle"></i> Delete Failed.', {
//							ele: 'body', // which element to append to
							type: 'danger', // (null, 'info', 'danger', 'success', 'warning')
							offset: {
								from: 'top',
								amount: 250
							}, // 'top', or 'bottom'
							align: 'center', // ('left', 'right', or 'center')
							width: 'auto', // (integer, or 'auto')
							delay: 5000, // Time while the message will be displayed. It's not equivalent to the *demo* timeOut!
							allow_dismiss: true, // If true then will display a cross to close the popup.
							stackup_spacing: 10 // spacing between consecutively stacked growls.
						});
						return location.href="<?php echo site_url('shipping-advice');?>";
					}
				});
			} else {
				console.log("Declined delete shipping advice.");
			}
		});
	});
</script>