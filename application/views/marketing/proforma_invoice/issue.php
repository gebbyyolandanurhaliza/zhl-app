<div class="page-content">
	<div class="container-fluid">
		<div class="row">
			
			<?php echo $message ?>
			
			<div class="col-md-12">
				<?php 
				echo form_open($action, 'class="form-horizontal"');
				?>
				
				<div class="portlet light">
					
					<div class="portlet-title">
						<div class="caption">
							<i class="fa fa-table theme-font"></i>
							<span class="caption-subject theme-font uppercase">PROFORMA INVOICE</span>
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
							
							<?php echo form_hidden('act', $act)?>
							<?php echo form_hidden('pi_hdr_id', $pi_hdr_id)?>
							
							<div class="col-sm-6 col-md-6">
								<div class="form-group">
									<label class="col-md-3 control-label" for="varchar">Invoice No</label>
									<div class="col-md-4">
										<input readonly="readonly" type="text" class="form-control" name="pi_number" id="pi_number" value="<?php echo $pi_number ?>" placeholder="Auto Generate Once Saved" />
									</div>
									
									<label class="col-md-1 control-label " for="varchar">Date</label>
									<div class="col-md-4">
										<div class="input-group date date-picker" data-date-format="dd/mm/yyyy" >
											<span class="input-group-btn">
												<button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
											</span>
											<input type="text" name="pi_date" id="pi_date" class="form-control" value="<?php echo $pi_date; ?>" title="Current Date <?php echo $current_date ?>">												
										</div>
									</div>
									
								</div>
								
								<div id="div_customer">
									<div class="form-group required">
										<label class="col-md-3 control-label" for="varchar">Customer</label>
										<div class="col-md-9">
											<?php											
											$disabled = ($act == 'edit') ? 'disabled="disabled" style="cursor: default;"': '';
											
											$extra_customer = 'required id="customer_list" class="form-control" '.$disabled;
											$option_customer['|'] = '';
											foreach ($cbo_customer as $r):
												$option_customer[$r->customer_id.'|'.$r->customer_contact_name] = $r->customer_name;
											endforeach;
											echo form_dropdown('customer_list', $option_customer, $customer_id.'|'.$customer_contact_name, $extra_customer);
											echo "<input type='hidden' name='customer_id' id='customer_id' value='$customer_id'>";
											?>
										</div>
									</div>
								
									<div class="form-group">
										<label class="col-md-3 control-label" for="varchar">Attn</label>
										<div class="col-md-9">
											<input type="text" class="form-control" name="attn" id="attn" value="<?php echo $attn ?>" <?php echo $disabled ?> />
										</div>
									</div>
									
									<script type="text/javascript">
										$('#customer_list').on('change', function(){
											var arr_cust_id	= $('#customer_list').val().split('|');
											var cust_id		= {customer_id : arr_cust_id[0]};
//											var cust_id = {customer_id : $('#customer_id').val()};

											$('#customer_id').val(arr_cust_id[0]);
											$('#attn').val(arr_cust_id[1]);

											$.ajax({
												type	: "POST",
												url		: "<?php echo site_url('proforma_invoice/load_contract') ?>",
												data	:cust_id,
												success	: function (msg) {
													$('#div_contract').html(msg);
												}
											});
										});
									</script>
								</div>
								
								<!--
								<div class="form-group">
									<label class="col-md-3 control-label" for="varchar">Address</label>
									<div class="col-md-9">
										<textarea name="customer_address" class="form-control"><?php // echo $customer_address ?></textarea>
									</div>
								</div>
								-->
								
								<div class="form-group required" id="div_contract">
									<label class="col-md-3 control-label" for="varchar">Sales Contract No.</label>
									<div class="col-md-9">
										<?php
										$extra_contract = 'required id="contract_list" class="form-control" '.$disabled;
										$option_contract[''] = '';
										foreach ($cbo_contract as $r):
											$option_contract[$r->contract_hdr_id] = $r->contract_no;
										endforeach;
										echo form_dropdown('contract_list', $option_contract, $contract_hdr_id, $extra_contract);
										echo "<input type='hidden' id='contract_hdr_id' name='contract_hdr_id' value='$contract_hdr_id'>"
										?>
									</div>
									
									<script>
										$('#contract_list').on('change', function(){
											var hdr_id = {contract_hdr_id : $('#contract_list').val()};
											
											proforma_invoice.startPageLoading({
												message : 'Please wait...'
											});
											
											window.setTimeout(function() {
												proforma_invoice.stopPageLoading();
											}, 3000);
											
											$('#contract_hdr_id').val($('#contract_list').val());

											$.ajax({
												type	: "POST",
												url		: "<?php echo site_url('proforma_invoice/load_customer') ?>",
												data	: hdr_id,
												success	: function (msg) {
													$('#div_customer').html(msg);
												}
											});
											
											$.ajax({
												type	: "POST",
												url		: "<?php echo site_url('proforma_invoice/load_right_top') ?>",
												data	: hdr_id,
												success	: function (msg) {
													$('#div_right_top').html(msg);
												}
											});
											
											$.ajax({
												type	: "POST",
												url		: "<?php echo site_url('proforma_invoice/load_detail') ?>",
												data	: hdr_id,
												success	: function (msg) {
													$('#div_detail').html(msg);
												}
											});
											
											$.ajax({
												type	: "POST",
												url		: "<?php echo site_url('proforma_invoice/load_invoice_amount') ?>",
												data	: hdr_id,
												success	: function (msg) {
													$('#div_invoice_amount').html(msg);
												}
											});
											
											proforma_invoice.calculating();
											
										});
									</script>
								</div>
							</div>
							
							<div class="col-sm-6 col-md-6" id="div_right_top">
								
								<div class="form-group">
									<label class="col-md-3 control-label" for="varchar">Shipment From</label>
									<div class="col-md-9">
										<?php
										$extra_ship_from = 'class="form-control"';
										$option_ship_from[''] = '';
										$option_ship_from['Singapore'] = 'Singapore';
										$option_ship_from['Indonesia'] = 'Indonesia';

										echo form_dropdown('shipment_from', $option_ship_from, $shipment_from, $extra_ship_from);
										?>
									</div>
								</div>
								
								<div class="form-group ">
									<label class="col-md-3 control-label" for="varchar">To</label>
									<div class="col-md-9">											
										<?php 
											$extra_port = 'id="shipment_to" class="form-control" onchange="change_destination()"';
											$option_port[''] = '';
											foreach($cbo_port as $r):
												$country_name = ($r->country_idn != 0) ? " - $r->country_name" : "";
												$option_port[$r->port_id.'|'.$r->country_id] = $r->port_name.$country_name;
											endforeach;
											echo form_dropdown('shipment_to', $option_port, $port_id.'|'.$destination_id, $extra_port);
										?>
											<input type="hidden" id="port_id" name="port_id" value="<?php echo $port_id ?>">
											<input type="hidden" id="destination_id" name="destination_id" value="<?php echo $destination_id ?>" >											
									</div>
									
									<script>
										function change_destination(){
											var arr_port_list = $('#shipment_to').val().split('|');

											$('#port_id').val(arr_port_list[0]);
											$('#destination_id').val(arr_port_list[1]);
										}
									</script>

								</div>
								
								<div class="form-group">
									<label class="col-md-3 control-label" for="varchar">
										Shipment Term
									</label>
									<div class="col-md-9" id="trading_term_container">
										<?php
										$extra_tradingterm = 'class="form-control" ';
										$option_tradingterm[''] = '';
										foreach ($cbo_tradingterm as $r):
											$option_tradingterm[$r->trading_term_id] = $r->trading_term_name . ' (' . $r->trading_term_remark . ')';
										endforeach;
										echo form_dropdown('trading_term_id', $option_tradingterm, $trading_term_id, $extra_tradingterm);
										?>
									</div>
								</div>
								
								<div class="form-group">
									<label class="col-md-3 control-label" for="varchar">ETD Singapore</label>
									<div class="col-md-9">
										<input type="text" class="form-control" name="etdsin" id="etdsin" value="<?php echo $etdsin ?>" />
									</div>
								</div>
								
							</div>							
						</div>
																		
						<div class="form-body row">
							<div class="col-sm-12 col-md-12">
								<div id="div_detail">
									
									<div class="form-group">
										<label class="col-md-12 control-label" for="varchar">Terms of Payment</label>
										<div class="col-md-12">
											<?php
											$extra_payterm = 'id="payment_term_id" class="form-control"';
											$option_payterm[''] = '';
											if ($cbo_payterm){
												foreach ($cbo_payterm as $r):
													$option_payterm[$r->payment_term_id] = $r->payment_term;
												endforeach;
											}
											echo form_dropdown('payment_term_id', $option_payterm, $payment_term_id, $extra_payterm);
											?>
										</div>
									</div>
									
									<div class="form-group">
										<div class="col-md-6">
											<label class="control-label">Sales Marketing</label>
											<div>
												<?php 
													$extra_sm = 'id="sales_marketing_id" class="form-control" ';
													$option_sm[''] = '';
													foreach($cbo_sales_marketing as $r):
														$option_sm[$r->userid] = $r->firstname.' '.$r->lastname;
													endforeach;
													echo form_dropdown('sales_marketing_id', $option_sm, $sales_marketing_id, $extra_sm);
												?>
											</div>
										</div>

										<div class="col-md-6">
											<label class="control-label">Bank Details</label>
											<div>
												<?php 
													$extra_bank = 'required id="bank_id" class="form-control "';
													$option_bank[''] = '';
													foreach($cbo_bank as $r):
														$option_bank[$r->bank_id] = $r->bank_name.', '.$r->bank_city;													
													endforeach;
													echo form_dropdown('bank_id', $option_bank, $bank_id, $extra_bank);
												?>
											</div>
										</div>
									</div>

									<br>
									
									<div class="table-scrollable">
										<table class="table table-bordered table-condensed table-detail scrollable" id="tbl_pi" style='table-layout: fixed;'>
											<thead>
												<tr class="double-border-bottom">
													<th style='width:40px; text-align: center;'>No</th>
													<th>Product Description</th>
													<th style='width:100px; text-align: center;'>Quantity</th>
													<th style='width:100px; text-align: center;'>UOM</th>
													<th style='width:100px; text-align: center;'>Unit Price US$</th>
													<th style='width:150px; text-align: right;'>Amount US$</th>
												</tr>
											</thead>
											
											<tbody>
												<?php 
												$grand_total	= '0.00';

												if ($rec_detail){
													$no = 1;
													foreach($rec_detail as $r){
														$product_desc	= ($r->detail_product_desc) ? $r->detail_product_desc : $r->product_view;
														$product_pack	= $r->detail_pack_size;

														echo "<tr>";

														echo "<td class='text-center'>$no</td>";

														echo "<td class='bg-editable'>";
									//					echo form_hidden('pi_dtl_id[]', 0);	// No detail_id krn cuma update di table sales contract
														echo form_hidden('product_id[]', $r->product_id);
														echo form_hidden('contract_dtl_id[]', $r->contract_dtl_id);
														echo "<input name='product_name[]' value='$product_desc' class='form-control input-xs input-table' placeholder='Product Name' title='$product_desc'>";
														echo "<input name='product_pack[]' value='$product_pack' class='form-control input-xs input-table' placeholder='Product Packing' title='$product_pack'>";
									//							echo $r->product_name;
														echo "</td>";

														echo "<td>";
														echo "<input name='quantity[]' value='".number_format($r->quantity, 0)."' readonly='readonly' class='form-control input-xs input-table text-center'>";
														echo "</td>";

														echo "<td>";
														echo form_hidden('uom_quantity_id[]', $r->uom_quantity_id);
														echo "<input name='uom_quantity_name[]' value='$r->uom_quantity_name' readonly='readonly' class='form-control input-xs input-table text-center'>";
														echo "</td>";

														echo "<td>";
														echo "<input name='unit_price[]' value='".number_format($r->price, 3)."' readonly='readonly' class='form-control input-xs input-table text-center'>";
														echo "</td>";

														echo "<td>";
														echo "<input name='amount[]' value='".number_format($r->total, 2)."' readonly='readonly' class='form-control input-xs input-table text-right'>";
														echo "</td>";

														echo "</tr>";

														$grand_total += $r->total;
														$no++;
													}
												}
												?>
											</tbody>
											
										</table>
									</div>
									
									<input type="hidden" name="contract_amount" id="contract_amount" value="<?php echo $contract_amount ?>">
								</div>
								
								<div class="table-scrollable">
									<table class="table table-bordered table-condensed table-detail scrollable" id="tbl_misc" style='table-layout: fixed;'>
										<thead>
											<tr class="double-border-bottom">
												<th style='width:40px; text-align: center; padding: 2px;'>
													<input type="button" class="btn btn-xs blue-dark fontawesome-font" id="btn_add_misc" value="&#xf067" style="width: 36px;">
												</th>
												<th>Miscellaneous Cost</th>
												<th style='width:150px; text-align: right;'>Amount US$</th>
											</tr>
										</thead>
										<tbody>
											<?php
											if (isset($rec_misc)){
												foreach($rec_misc as $m){
													echo '<tr>';
													echo '<td class="bg-editable text-center">';
														echo '<input type="button" misc_id="'.$m->pi_misc_id.'" class="btn btn-xs red-stripe fontawesome-font remove_detail" value="&#xf014" style="margin: 1px; width: 95%;" title="Remove miscellaneous cost">';
													echo '</td>';
													echo '<td class="bg-editable">';
													echo '<input type="hidden" name="pi_misc_id[]" value="'.$m->pi_misc_id.'">';
													echo '<input name="misc_cost[]" class="form-control input-xs input-table" value="'.$m->misc_cost.'">';
													echo '</td>';
													echo '<td class="bg-editable">';
													echo '<input name="misc_value[]" class="form-control input-xs input-table autonumber text-right misc_value_class" value="'.number_format($m->misc_amount, 2).'" >';
													echo '</td>';
													echo '</tr>';
//													onkeyup="proforma_invoice.calculating();"
												}
											}
											?>
										</tbody>
<!--										<tfoot>
											<tr>
												<td style="text-align: center;" colspan="2"><strong>INVOICE AMOUNT</strong></td>
												<td style="text-align: right;" id='total_amount'><strong>USD <?php // echo number_format($grand_total, 2)?></strong></td>
											</tr>
										</tfoot>-->
									</table>
								</div>
																
								<div id="div_invoice_amount">

									<div class="form-group">
										
										<div class="col-md-10">
											<label class="control-label">TOTAL AMOUNT TO READ IN WORDS</label>
											<div id="div_in_word">
												<input readonly="readonly" name="total_in_word" id="total_in_word" class="form-control" value="<?php echo $total_in_word ?>">
											</div>
										</div>
										
										<div class="col-md-2">
											<label class="control-label"><strong>INVOICE AMOUNT</strong></label>
											<div class="input-group">	
												<span class='input-group-addon'>US$</span>
												<input readonly="readonly" name="invoice_amount" id="invoice_amount" class="form-control text-right" value="<?php echo $invoice_amount ?>">
											</div>
										</div>
									</div>
									
								</div>

							</div>

						</div>

						<div class="form-body row">
							
							<div class="col-md-12">
								<div class="form-group">
									<label class="col-md-12 control-label">Remarks</label>
									<div class="col-md-12">
										<textarea rows="8" class="form-control autosizeme" name="remark" id="remark"><?php echo $remark; ?></textarea>
									</div>
								</div>
							</div>
							
						</div>
						
						<div class="form-actions">
							<div class="row">
								<div class="col-md-12">
									<input type="button" class="btn btn-default fontawesome-font" value="&#xf002 Search Proforma Invoice ..." data-target="#modal_find" data-toggle="modal">
									<?php echo $btn_print ?>
									<?php echo $btn_delete ?>
									<a href="<?php echo site_url('proforma-invoice')?>" type="button" class="btn red pull-right"><i class="fa fa-close"></i> Cancel</a>
									<button type="submit" class="btn green pull-right"><i class="fa fa-save"></i> <?php echo $submit_caption?></button>										
								</div>									
							</div>
						</div>
						
					</div>
					
				</div>
				
				<?php
				echo form_close();
				?>
			</div>
		</div>
	</div>
</div>

<!-- Modal Find -->
<div id="find">	
	<div id="modal_find" class="modal fade bs-modal-lg" role="dialog" tabindex="-1" data-backdrop="static" data-keyboard="false" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
					<div class="row">
						<div class="col-md-7">
							<div class="input-group">					
								<input id="input_find" name="input_search" class="form-control" type="text" placeholder="Filter Data Contract (Proforma Invoice No, Contract No, Customer)" >
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
	
	
	$('#search_find').on('click',function(){
		var find = {find:$("#input_find").val()};
		$.ajax({
			type: "POST",
			url : "<?php echo site_url('proforma-invoice/search-find')?>",
			data: find,
			success: function(msg){
				$('#table_find').html(msg);
			}
		});
	});
	
	$('#tbl_misc .remove_detail').on('click', function(){
		var tr = $(this).closest('tr');
		var misc_id	= $(this).attr('misc_id');

		bootbox.confirm('Are you sure want to remove this miscellaneous cost?',function(result){
			if (result){
				if (misc_id !== '0'){
					$.ajax({
						type: "POST",
						url	: "<?php echo site_url('proforma-invoice/delete_misc')?>",
						data: {misc_id : misc_id},
						success : function(){
							$.bootstrapGrowl('<i class="fa fa-info-circle"></i> Remove Miscellaneous Success.', {
	//							ele: 'body', // which element to append to
								type: 'success', // (null, 'info', 'danger', 'success', 'warning')
								offset: {
									from: 'top',
									amount: 250
								}, // 'top', or 'bottom'
								align: 'center', // ('left', 'right', or 'center')
								width: 'auto', // (integer, or 'auto')
								delay: 3000, // Time while the message will be displayed. It's not equivalent to the *demo* timeOut!
								allow_dismiss: true, // If true then will display a cross to close the popup.
								stackup_spacing: 10 // spacing between consecutively stacked growls.
							});
						}
					});
				}
				
				tr.fadeOut(400, function(){
					tr.remove();
				});
			}
		});
	});
	
	$('#btn_add_misc').on('click', function(){							
		$('#tbl_misc').find('tbody').append($(
			'<tr>'
			+'<td class="bg-editable text-center">'
				+'<input type="button" class="btn btn-xs red-stripe fontawesome-font remove_detail_add" value="&#xf014" style="margin: 1px; width: 95%;" title="Remove miscellaneous cost">'
			+'</td>'
			+'<td class="bg-editable">'
				+'<input type="hidden" name="pi_misc_id[]" value="0">'
				+'<input name="misc_cost[]" class="form-control input-xs input-table">'
			+'</td>'
			+'<td class="bg-editable">'
				+'<input name="misc_value[]" class="form-control input-xs input-table autonumber text-right misc_value_class" >'
			+'</td>'
			+'</tr>'
		));

		$('.autonumber').autoNumeric('init');

		$('.autonumber').on('click', function(){
			this.select();
		});

		$('#tbl_misc .remove_detail_add').on('click', function(){
			var tr = $(this).closest('tr');

			tr.fadeOut(400, function(){
				tr.remove();
				proforma_invoice.calculating();
			});

			return false;    
		});
		
		$('.misc_value_class').on('keyup',function(){
			proforma_invoice.calculating();

			var inv_amount = remove_thousand_separator(document.getElementById('invoice_amount').value);

			$.ajax({
				type: "POST",
				url: "<?php echo site_url('proforma-invoice/run_number_to_word/')?>",
				data:{number:inv_amount},
				success: function (data, textStatus, jqXHR) {
					$('#div_in_word').html(data);
				}
			});
		});
	});
	
	$('.misc_value_class').on('keyup',function(){
		proforma_invoice.calculating();
		
		var inv_amount = remove_thousand_separator(document.getElementById('invoice_amount').value);
		
		$.ajax({
			type: "POST",
			url: "<?php echo site_url('proforma-invoice/run_number_to_word/')?>",
			data:{number:inv_amount},
			success: function (data, textStatus, jqXHR) {
                $('#div_in_word').html(data);
            }
		});
	});
</script>

<script src="<?php echo base_url();?>assets/marketing/proforma_invoice.js"></script>

<script>
	jQuery(document).ready(function() { 
		proforma_invoice.init();
	});	
	
</script>

