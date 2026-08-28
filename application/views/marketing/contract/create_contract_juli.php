<style type="text/css">		
	.sembunyi{
		display: none;
	}
</style>

<div class="page-content">
	<div class="container-fluid">
		<div class="row ">
			
			<?php echo $message ?>
			
			<form action="<?php echo $action; ?>" method="post" class="form-horizontal">
				<div class="col-md-12">
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
							<div class="form-body row">							
								<div class="col-md-12">
									
									<?php echo form_hidden('act', $act)?>
									<?php echo form_hidden('quotation_hdr_id', $quotation_hdr_id)?>
									<?php echo form_hidden('contract_hdr_id', $contract_hdr_id)?>
									
									<div class="form-group">
										<label class="col-md-2 control-label" for="varchar">Sales Contract No</label>
										<div class="col-md-2">
											<input readonly="readonly" type="text" class="form-control" name="sales_contract_no" id="sales_contract_no" value="<?php echo $sales_contract_no?>" placeholder="Auto Generate Once Saved"/>											
										</div>
										
										<label class="col-md-1 control-label" for="varchar" style="padding-right:0;">Contract Date</label>
										<div class="col-md-2">
											<input required type="text" class="form-control date date-picker" style="width:150px;" data-date="<?php echo $current_date ?>" data-date-format="dd/mm/yyyy" name="contract_date" id="contract_date" value="<?php echo $contract_date; ?>" title="date format : dd/mm/yyyy" />
										</div>
										
										
										<div class="col-md-2 pull-right">
											<input readonly="readonly" type="text" class="form-control" name="quotation_number" id="sales_contract_no" value="<?php echo $quotation_number?>"/>											
										</div>
										<label class="col-md-2 control-label pull-right" style="text-align: right;" for="varchar">Sales Quotation No</label>
									</div>
									
									<div class="form-group required">
										<label class="col-md-2 control-label" for="varchar">Buyer / Customer</label>
										<div class="col-md-4">
											<?php 
												if ($quotation_number == '') {
													$disabled_cust = 'required';
												} else {
													$disabled_cust = 'disabled="disabled"';
												}
												$extra_company = $disabled_cust.' id="customer_list" class="form-control "';
												$option_company[''] = '';
												foreach($cbo_company as $r):
													$option_company[$r->customer_id] = $r->customer_company_name;
												endforeach;
												echo form_dropdown('customer_list', $option_company, $customer_id, $extra_company);
											?>		
											<input type="hidden" id="customer_id" name="customer_id" value="<?php echo $customer_id ?>">
										</div>
										<span class="help-inline"><?php echo form_error('customer_id') ?></span>
									</div>
									
									<script type="text/javascript">
										$('#customer_list').change(function(){	
											var customer_id = {customer_id:$("#customer_list").val()};
											$.ajax({
												type: "POST",
												url : "<?php echo site_url('marketing_misc/get_payterm_by_customer')?>",
												data: customer_id,
												success: function(msg){
													$('#payterm_container').html(msg);
													$('#customer_id').val($('#customer_list').val());
												}
											});
											
//											$.ajax({
//												type: "POST",
//												url : "<?php // echo site_url('sales_contract/get_previous_data')?>",
//												data: customer_id
//											});
										});
									</script>

									<div class="form-group ">
										<label class="col-md-2 control-label" for="varchar">Customer Reference No.</label>
										<div class="col-md-4">
											<input type="text" class="form-control" name="customer_reference" id="customer_reference" value="<?php echo $customer_reference?>" />
										</div>
										
										<label class="col-md-2 control-label" for="varchar">Partial Shipment</label>
										<div class="col-md-4">
											<?php 
												$extra_partial_shipment = 'id="partial_shipment" class="form-control "';
												$option_partial_shipment[''] = '';
												
												$option_partial_shipment['Allowed'] = 'Allowed';
												$option_partial_shipment['Not Allowed'] = 'Not Allowed';
												
												echo form_dropdown('partial_shipment', $option_partial_shipment, $partial_shipment, $extra_partial_shipment);
											?>											
										</div>
									</div>
									
									<div class="form-group required">
										<label class="col-md-2 control-label padding-right-2" for="varchar">
											Trading Term
											<a href="#modal_create" id="create_trading_term" data-toggle="modal" class="pull-right" title="Create New Trading Term">
												<i class="fa fa-plus-square"></i>
											</a>
										</label>
										<div class="col-md-4" id="trading_term_container">
											<?php 
												$extra_tradingterm = 'required class="form-control " ';
												$option_tradingterm[''] = '';
												foreach($cbo_tradingterm as $r):
													$option_tradingterm[$r->trading_term_id] = $r->trading_term_name . ' (' . $r->trading_term_remark .')';
												endforeach;
												echo form_dropdown('tradingterm_id', $option_tradingterm, $tradingterm_id, $extra_tradingterm);
											?>
										</div>
										
										<label class="col-md-2 control-label" for="varchar">Marine Insurance</label>
										<div class="col-md-4">
											<?php 
												$extra_marine_insurance = 'id="marine_insurance" class="form-control "';
												$option_marine_insurance[''] = '';
												
												$option_marine_insurance['Covered By Buyer'] = 'Covered By Buyer';
												$option_marine_insurance['Covered By Seller'] = 'Covered By Seller';
												
												echo form_dropdown('marine_insurance', $option_marine_insurance, $marine_insurance, $extra_marine_insurance);
											?>											
										</div>
									</div>
									
									<div class="form-group">
										<label class="col-md-2 control-label" for="varchar">Shipment From</label>
										<div class="col-md-4">
											<?php 
												$extra_ship_from = 'required class="form-control "';
												$option_ship_from[''] = '';
												$option_ship_from['Singapore'] = 'Singapore';
												$option_ship_from['Indonesia'] = 'Indonesia';
												
												echo form_dropdown('shipment_from', $option_ship_from, $shipment_from, $extra_ship_from);
											?>
										</div>
										
										<label class="col-md-2 control-label" for="varchar">Shipping Line</label>
										<div class="col-md-4">
											<?php 
												$extra_shipping_line = 'id="shipping_id" class="form-control"';
												$option_shipping_line[''] = '';
												foreach($cbo_shipping_line as $r):
													$option_shipping_line[$r->shipping_id] = $r->shipping_name;
												endforeach;
												echo form_dropdown('shipping_id', $option_shipping_line, $shipping_id, $extra_shipping_line);
											?>
										</div>
									</div>
									
									<div class="form-group required">
<!--										<label class="col-md-2 control-label" for="varchar">Final Destination </label>
										<div class="col-md-4">
											<?php 
//												$extra_destination = 'required id="destination_id" class="form-control "';
//												$option_destination[''] = '';
//												foreach($cbo_destination as $r):
//													$option_destination[$r->country_id] = $r->country_name;
//												endforeach;
//												echo form_dropdown('destination_id', $option_destination, $destination_id, $extra_destination);
											?>
										</div>-->
										
										<script type="text/javascript">
//											$('#destination_id').change(function(){											
//												var destination_id = {destination_id:$("#destination_id").val()};
//												$('#port_id').select2('val','');
//												$.ajax({
//													type: "POST",
//													url : "<?php // echo site_url('marketing_misc/get_port_discharge')?>",
//													data: destination_id,
//													success: function(msg){
//														$('#div_port').html(msg);
//													}
//												});	
//											});

										</script>
										
<!--										<label class="col-md-2 control-label" for="varchar">Port</label>
										<div class="col-md-4">
											<div id="div_port">
											<?php 
//												$extra_port = 'id="port_id" class="form-control "';
//												$option_port[''] = '';
//												foreach($cbo_port as $r):
//													$option_port[$r->port_id] = $r->port_name;
//												endforeach;
//												echo form_dropdown('port_id', $option_port, $port_id, $extra_port);
											?>
											<input type="text" class="form-control" name="port_discharge" id="port_discharge" value="<?php // echo $port_discharge; ?>" />
											</div>
										</div>-->
									</div>
									
									<div class="form-group required">
										<label class="col-md-2 control-label" for="varchar">Final Destination </label>
										<div class="col-md-4">											
											<?php 
												$extra_port = 'id="port_list" class="form-control " onchange="change_destination()"';
												$option_port[''] = '';
												foreach($cbo_port as $r):
													$country_name = ($r->country_idn != 0) ? " - $r->country_name" : "";
													$option_port[$r->port_id.'|'.$r->country_id] = $r->port_name.$country_name;
												endforeach;
												echo form_dropdown('port_list', $option_port, $port_id.'|'.$destination_id, $extra_port);
											?>
												<input type="hidden" id="port_id" name="port_id" value="<?php echo $port_id ?>">
												<input type="hidden" id="destination_id" name="destination_id" value="<?php echo $destination_id ?>" >											
										</div>
									
									</div>
									
									<div class="form-group">
										<label class="col-md-2 control-label" for="varchar">Container Loading</label>
										<div class="col-md-4">
											<?php 
												$extra_container = 'id="container_list" class="form-control" onchange="change_container()"';
//												$extra_container = 'id="container_list" class="form-control"';
												$option_container[''] = '';
												foreach($cbo_container as $r):
													$option_container[$r->container_id.'|'.$r->container_size] = $r->container_name;
												endforeach;
												echo form_dropdown('container_list', $option_container, $container_id.'|'.$container_size, $extra_container);												
											?>
											<input type="hidden" id="container_id" name="container_id" value="<?php echo $container_id?>">
										</div>
										
										<label class="col-md-2 control-label" for="varchar">Shipment Schedule</label>
										<div class="col-md-4">
											<textarea rows="1" class="form-control" name="shipment_schedule" id="shipment_schedule"><?php echo $shipment_schedule; ?></textarea>
										</div>
									</div>
																	
									<div class="form-group required">
										<label class="col-sm-2 control-label" for="varchar">Local Currency</label>
										<div class="col-sm-4">
											<?php 
												$extra_currency = 'required id= "local_currency" class="form-control"';
												$option_currency[''] = '';
												foreach($cbo_currency as $r):
													$option_currency[$r->currency_id] = $r->currency_symbol.' - '.$r->currency_name;													
												endforeach;
												echo form_dropdown('local_currency', $option_currency, $local_currency, $extra_currency);
											?>
										</div>
										
										<div id="div_rate">
											<div class="col-sm-3">												
												<div id="div_rate_usd" class="input-group">		
													<span class='input-group-addon'>US$</span>
													<input required type="text" class="form-control text-right input-rate" name="rate_usd" id="rate_usd" placeholder="0.000000" value="<?php echo $rate_usd; ?>" title="6 digits decimal" />
												</div>
											</div>
											<div class="col-sm-3">
												<div id="div_rate_sgd" class="input-group">
													<span class='input-group-addon'>SIN$</span>
													<input required type="text" class="form-control text-right input-rate" name="rate_sgd" id="rate_sgd" placeholder="0.000000" value="<?php echo $rate_sgd; ?>" title="6 digits decimal" />
												</div>
											</div>
										</div>
										
										<script type="text/javascript">
											$('#local_currency').change(function(){
												var currency_id = {currency_id:$("#local_currency").val()};
												$.ajax({
													type: "POST",
													url : "<?php echo site_url('sales_quotation/get_rate')?>",
													data: currency_id,
													success: function(msg){
														$('#div_rate').html(msg);
													}
												});
											});
										</script>
									</div>
									
								</div>
								
							</div>	
							
							<div class="form-body row">
								<div class="col-md-12">
									<div class="table-toolbar">
										<div class="row">
											<div class="col-md-12">
												<a class="btn btn-default btn-large" id="add_agent" name="add_agent">
													<i class="fa fa-plus"></i>
													Add Agent
												</a>
											</div>
										</div>
									</div>
								
									<script type="text/javascript">
										$("#add_agent").click(function(){
											$.ajax({
												type: "POST",
												url : "<?php echo site_url('sales_contract/add_agent_row')?>",												
												success: function(msg){
													$('#tbl_agent > tbody:last-child').append(msg);
												}
											});
										});
									</script>

									<div class="agent-scroll">
										<table width="100%" id="tbl_agent" class="table table-detail">
											<thead>
												<tr>
													<th></th>
													<th width="60%" class="text-left">Agent Name</th>
													<th width="13%" class="text-center">USD Com (%)</th>
													<th width="13%" class="text-center">USD Com/Unit</th>
													<th width="10%" class="text-center">Invoice</th>
												</tr>
											</thead>
											<tbody>
												<?php 
												if ($agent_list){
													foreach ($agent_list as $ag){
														?>

													<tr>
														<td class="bg-editable"><input type="button" class="btn default red-stripe" onclick="removeRow(this)" value="Remove"></td>
														<td class="bg-editable">
															<?php 
																$extra_agent = 'id= "agent_id" class="form-control"';
																$option_agent[''] = '';
																if ($cbo_agent){
																	foreach($cbo_agent as $r):
																		$option_agent[$r->agent_id] = $r->agent_name;													
																	endforeach;
																}
																echo form_dropdown('agent_id[]', $option_agent, $ag->agent_id, $extra_agent);
															?>
														</td>
														<td class="bg-editable">
															<input type="text" value="<?php echo $ag->com_percent ?>" onkeyup="agent_percent()" class="form-control autonum_com_percent text-right autofocus" name="agent_com_percent[]" id="agent_com_percent" data-a-sign=" %" data-p-sign="s" data-v-max="100" placeholder="0.00 %" />
														</td>
														<td class="bg-editable">
															<input type="text" value="<?php echo $ag->com_unit ?>" onkeyup="agent_unit()" class="form-control autonum_com_unit text-right autofocus" name="agent_com_unit[]" id="agent_com_unit" data-p-sign="s" placeholder="0.00"/>
														</td>
														<td class="bg-editable text-center">
															<?php
															$checked = ($ag->invoice == 1 ? true : false);
															echo form_checkbox('agent_invoice[]', '1', $checked);
															?>
														</td>

													</tr>

												<?php
													}
												}
												?>
											</tbody>
										</table>
									</div>	
								</div>
							</div>
							
							<div class="form-body row">
								<!-- contract detail -->
								<div class="col-md-12">
<!--									<hr>-->
									
									<div class="table-toolbar">
										<div class="row">
											<div class="col-md-6">
												<div class="btn-group">
													<!--<a class="btn btn-primary btn-large" data-target="#modal_product" data-toggle="modal">-->
													<?php echo $btn_add_product ?>
												</div>
											</div>
										</div>										
									</div>

									<?php
									$w_prod_desc	= "style=width:300px;";
									$w_prod_code	= "style=width:150px;text-align:center;";
									$w_factory		= "style=width:80px;text-align:center;";
									$w_brand		= "style=width:150px;cursor:pointer;";
									$w_pack_size	= "style=width:150px;";
									$w_uom			= "style=width:100px;text-align:center;";
									$w_quot_qty		= "style=width:100px;";
									$w_bal_qty		= "style=width:100px;";
									$w_qty			= "style=width:100px;";
									$w_price		= "style=width:100px;";
									$w_fcl			= "style=width:100px;";
									$w_total		= "style=width:130px;";
									?>	
									
									<!--<div class="table-responsive">-->
									<div class="table-scrollable">
										<table class="table table-bordered table-condensed table-detail scrollable" id="tblsales_contract">
											<thead>
												<tr>
													<th class="w-50">&nbsp;</th>
													<th>Product Description</th>
													<th>Product Code</th>
													<th>Factory</th>
													<th class="w-180">Brand Name</th>
													<th class="w-150">Pack Size</th>
													<th class="w-100">UOM</th>
													<th class="w-100">Quotation Qty</th>
													<th class="w-100">Balance Qty</th>
													<th class="w-100">Qty</th>
													<th class="w-100">Unit Price</th>													
													<th class="w-100">FCL</th>
													<th class="w-130">Total</th>

												</tr>
											</thead>
											<tbody>
												<?php
												if ($detail){
													$last_count = 0;
													foreach ($detail as $d){
														$sub_total = $d->price * $d->quantity;
														
														$qty_quotation = $this->M_mar_sales_contract->get_qty_quotation(decode_str($quotation_hdr_id,'contract'), $d->product_id);
														$qty_contract = $this->M_mar_sales_contract->get_qty_contract(decode_str($quotation_hdr_id, 'contract'), $d->product_id);
														$balance_qty = $qty_quotation-$qty_contract;
//														$container_size = $d->container_size;
														
														echo "<tr>";
														//Kolom Tombol
														echo "<td class='text-center w-50 bg-editable valign-middle'>";
															echo "<input type='button' class='btn default btn-xs red-stripe' onclick='removeRow(this)' value='Remove'>";
															echo "<input type='hidden' name='product_id[]' value='$d->product_id'>";
															echo "<input type='hidden' name='factory_id[]' value='$factory_id'>";
//															echo "<input type='hidden' name='quotation_dtl_id[]' value='$d->quotation_dtl_id'>";
														echo "</td>";
														//Kolom Product Description
														echo "<td class='bg-editable'>";
															echo "<input name='product_name[]' $w_prod_desc value='$d->product_name' class='form-control input-xs input-table w-300' placeholder='Product Name' title='$d->product_name'>";
														echo "</td>";
														//Kolom Product Code
														echo "<td>";
															echo "<input name='product_code[]' $w_prod_code value='$d->product_code' class='form-control input-xs input-table' placeholder='Product Code' readonly='readonly' title='$d->product_code'>";
														echo "</td>";
														//Kolom Factory
														echo "<td>";
															echo "<input name='factory_abbr[]' $w_factory value='$d->factory_abbr' class='form-control input-xs input-table' readonly='readonly' >";
														echo "</td>";
														//Kolom Brand Name
														echo '<td class="bg-editable">';
															echo '<input name="detail_brand_id[]" value="'.$d->detail_brand_id.'" id="br-'.$last_count.'" type="hidden" class="form-control brand-text input-xs input-table">';
															echo '<input name="brand_name[]" value="'.$d->detail_brand_name.'" id="brn-'.$last_count.'" '.$w_brand.' onClick="viewModalSelectBrand(this.id)" class="form-control input-xs input-table" placeholder="Select Brand" readonly="readonly">';
														echo '</td>';														
														//Kolom Pack Size
														if ($d->packing_view){
															$pack_size = $d->packing_view;
														} else {
															$pack_size = floatval($d->uom_volume).' '.$d->uom_volume_name.' x '.floatval($d->per_packing).' '.$d->packing_size.' per '.$d->cma_uom_quantity_id;
														}
														echo "<td class='bg-editable'>";
															echo "<input name='pack_size[]' $w_pack_size value='$pack_size' class='form-control input-xs input-table' title='$pack_size'>";
														echo "</td>";
														//Kolom UOM
														echo "<td>";
															echo "<input name='uom_quantity_name[]' $w_uom value='$d->uom_quantity_name' class='form-control input-xs input-table' readonly='readonly'>";
														echo "</td>";
														//Kolom Qty Quotation
														echo "<td>";
															echo "<input name='qty_quotation[]' $w_quot_qty value='".number_format($qty_quotation, 0, '.', ',')."' class='form-control input-xs text-right input-table' readonly='readonly'>";
														echo "</td>";
														//Kolom Balance Qty
														echo "<td>";
															echo "<input name='qty_balance[]' $w_bal_qty value='".number_format($balance_qty, 0, '.', ',')."' class='form-control input-xs text-right input-table' readonly='readonly'>";
														echo "</td>";
														//Kolom Qty
														echo "<td class='bg-editable'>";
															echo "<input name='qty[]' required $w_qty value='$d->quantity' type='text' class='form-control input-xs text-right input-table autonum_qty autofocus' data-v-min='0' data-v-max='$balance_qty' onkeyup='calculate()'>";
														echo "</td>";
														//Kolom Unit Price
														echo "<td class='bg-editable'>";
															echo "<input name='unit_price[]' required $w_price value='$d->price' type='text' class='form-control input-xs text-right input-table autonum_price autofocus' onkeyup='calculate()'>";
														echo "</td>";
														//Kolom FCL
														echo "<td class='bg-editable'>";
															switch ($container_size){
																case 20:
//																	echo form_hidden('estimated[]', $d->container_20ft);
																	if ($d->container_20ft > 0){
																		$fcl = $d->quantity / $d->container_20ft;
																	} else {
																		$fcl = 0;
																	}
																	break;
																case 40:
//																	echo form_hidden('estimated[]', $d->container_40ft);
																	if ($d->container_40ft > 0){
																		$fcl = $d->quantity / $d->container_40ft;
																	} else {
																		$fcl = 0;
																	}
																	break;
																default:
//																	echo form_hidden('estimated[]', 0);
																	$fcl = 0;
																	break;
															}
															
															echo "<input name='fcl[]' $w_fcl required value='$fcl' type='text' class='form-control input-xs text-right input-table autonum_fcl autofocus'>";
															echo "<input name='container_20ft[]' value='".number_format($d->container_20ft,0)."' type='hidden'>";
															echo "<input name='container_40ft[]' value='".number_format($d->container_40ft,0)."' type='hidden'>";
														echo "</td>";
														//Kolom Total
														echo "<td class='w-130'>";
															echo "<input name='total[]' $w_total value='".number_format($sub_total, 2,'.',',')."' type='text' class='form-control input-xs text-right input-table' readonly='readonly'>";
														echo "</td>";
														
														echo "</tr>";
														$last_count++;
													}
												}
												
												if ($contract_detail){
													$last_count = 1;
													foreach ($contract_detail as $cd){
														$sub_total = $cd->price * $cd->quantity;
														
														$qty_quotation = $cd->qty_quotation;
														$qty_contract = $cd->quantity;
														$balance_qty = $qty_quotation-$qty_contract;														
														
														echo "<tr>";
														//Kolom Tombol
														echo "<td class='text-center w-50 bg-editable valign-middle'>";
															echo "<input type='button' class='btn default btn-xs red-stripe' onclick='removeRow(this)' value='Remove'>";
															echo "<input type='hidden' name='product_id[]' value='$cd->product_id'>";
															echo "<input type='hidden' name='factory_id[]' value='$factory_id'>";
//															echo "<input type='hidden' name='quotation_dtl_id[]' value='$d->quotation_dtl_id'>";
														echo "</td>";
														//Kolom Product Description
														echo "<td class='bg-editable'>";
															echo "<input name='product_name[]' $w_prod_desc value='$cd->product_name' class='form-control input-xs input-table' placeholder='Product Name' title='$cd->product_name'>";
														echo "</td>";
														//Kolom Product Code
														echo "<td>";
															echo "<input name='product_code[]' $w_prod_code value='$cd->product_code' class='form-control input-xs input-table' placeholder='Product Code' readonly='readonly' title='$cd->product_code'>";
														echo "</td>";
														//Kolom Factory
														echo "<td>";
															echo "<input name='factory_abbr[]' $w_factory value='$cd->factory_abbr' class='form-control input-xs input-table' readonly='readonly' >";
														echo "</td>";
														//Kolom Brand Name
														echo '<td class="bg-editable">';
															echo '<input name="detail_brand_id[]" value="'.$cd->brand_id.'" id="br-'.$last_count.'" type="hidden" class="form-control brand-text input-xs input-table">';
															echo '<input name="brand_name[]" value="'.$cd->brand_name.'" id="brn-'.$last_count.'" '.$w_brand.' onClick="viewModalSelectBrand(this.id)" class="form-control input-xs input-table" placeholder="Select Brand" readonly="readonly">';
														echo '</td>';
														//Kolom Pack Size
														if ($cd->detail_pack_size){
															$pack_size = $cd->detail_pack_size;
														} else {
															$pack_size = floatval($cd->uom_volume).' '.$cd->uom_volume_name.' x '.$cd->per_packing.' '.$cd->packing_size.' per '.$cd->cma_uom_quantity_id;
														}
														echo "<td class='bg-editable'>";
															echo "<input name='pack_size[]' $w_pack_size value='$pack_size' class='form-control input-xs input-table' title='$pack_size'>";
														echo "</td>";
														//Kolom UOM
														echo "<td>";
															echo "<input name='uom_quantity_name[]' $w_uom value='$cd->uom_quantity_name' class='form-control input-xs input-table' readonly='readonly'>";
														echo "</td>";
														//Kolom Qty Quotation
														echo "<td>";
															echo "<input name='qty_quotation[]' $w_quot_qty value='".number_format($qty_quotation, 0, '.', ',')."' class='form-control input-xs text-right input-table' readonly='readonly'>";
														echo "</td>";
														//Kolom Balance Qty
														echo "<td>";
															echo "<input name='qty_balance[]' $w_bal_qty value='".number_format($balance_qty, 0, '.', ',')."' class='form-control input-xs text-right input-table' readonly='readonly'>";
														echo "</td>";
														//Kolom Qty
														echo "<td class='bg-editable'>";
															echo "<input name='qty[]' $w_qty required value='$cd->quantity' type='text' class='form-control input-xs text-right input-table autonum_qty autofocus' data-v-min='0' onkeyup='calculate()'>";
														echo "</td>";
														//Kolom Unit Price
														echo "<td class='bg-editable'>";
															echo "<input name='unit_price[]' $w_price required value='$cd->price' type='text' class='form-control input-xs text-right input-table autonum_price autofocus' onkeyup='calculate()'>";
														echo "</td>";														
														//Kolom FCL																													
														echo "<td class='bg-editable'>";															
//															echo form_hidden('estimated[]', $cd->estimated_qty);
															echo "<input name='fcl[]' $w_fcl required value='$cd->fcl' type='text' class='form-control input-xs text-right input-table autonum_fcl autofocus'>";
															echo "<input name='container_20ft[]' value='".number_format($cd->container_20ft,0)."' type='hidden'>";
															echo "<input name='container_40ft[]' value='".number_format($cd->container_40ft,0)."' type='hidden'>";
														echo "</td>";
														//Kolom Total
														echo "<td>";
															echo "<input name='total[]' $w_total value='".number_format($sub_total, 2,'.',',')."' type='text' class='form-control input-xs text-right input-table' readonly='readonly'>";
														echo "</td>";
														
														echo "</tr>";
														$last_count++;
													}
												}
												?>
											</tbody>
										</table>
									</div>									
									
								</div>
							</div>	
							
							<div class="form-body row">																
								<div class="col-md-8">
									
									<div class="form-group required">
										<label class="col-md-3 control-label padding-right-2" for="varchar">
											Payment Terms
											<a href="#modal_create" id="create_payterm" data-toggle="modal" class="pull-right" title="Create New Payment Term">
												<i class="fa fa-plus-square"></i>
											</a>
										</label>
										<div class="col-md-9" id="payterm_container">											
											<?php 
												$extra_payterm = 'id="payment_term" class="form-control" required="required" ';
												$option_payterm[''] = '';
												foreach($cbo_payterm as $r):
													$option_payterm[$r->payment_term] = $r->payment_term;													
												endforeach;
												echo form_dropdown('payment_term', $option_payterm, $payment_term, $extra_payterm);
											?>											
										</div>
									</div>
									
									<div class="form-group required">
										<label class="col-md-3 control-label" for="varchar">Bank</label>
										<div class="col-md-9">
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
									
									<div class="form-group">										
										<label class="col-md-3 control-label padding-right-2" for="varchar">
											Shelf Life
											<a href="#modal_create" id="create_shelf_life" data-toggle="modal" class="pull-right" title="Create New Shelf Life">
												<i class="fa fa-plus-square"></i>
											</a>
										</label>
										<div class="col-md-5" id="shelf_life_container">
											<?php 
												$extra_shelf = 'id="product_shelf_life_id" class="form-control "';
												$option_shelf[''] = '';
												foreach($cbo_shelf as $r):
													$option_shelf[$r->product_shelf_life_id] = $r->product_shelf_life;													
												endforeach;
												echo form_dropdown('product_shelf_life_id', $option_shelf, $product_shelf_life_id, $extra_shelf);
											?>												
										</div>
										<span class="help-inline">from date of production</span>
									</div>
									
									<div class="form-group">
										<label class="col-md-3 control-label padding-right-2" for="varchar">
											Document Provided by Seller
											<a href="#modal_create" id="create_document" data-toggle="modal" class="pull-right" title="Create New Document">
												<i class="fa fa-plus-square"></i>
											</a>
										</label>
										<div class="col-md-9">
											<div class="doc-scroll">
												<table id="list-document" class="doc-table">
													<tbody>
														<?php														
														if ($list_document){
															$i = 0;
															foreach($list_document as $doc){
																$checked = false;
																if ($selected_document){
																	foreach ($selected_document as $sd){
																		if ($sd->document_id == $doc->document_id){
																			$checked = true;
																		}
																	}
																}
																
																$i++;
																echo "<tr>";
																echo "<td>";
																echo form_checkbox('doc[]', $doc->document_id, $checked);
																echo "</td>";
																echo "<td>$doc->document_name</td>";																
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
								
								<div class="col-md-4">
									
									<div class="form-group">
										<label class="col-md-6 control-label" for="varchar">Total before discount</label>
										<div class="col-md-6" style="padding-left: 2px">
											<input type="text" readonly="readonly" class="form-control text-right" name="total_before_disc" id="total_before_disc" value="<?php echo $total_before_disc; ?>" />
										</div>										
									</div>
									
									<div class="form-group">
										<label class="col-md-3 control-label label-sm" for="varchar">Discount</label>
										<div class="col-md-3" style="padding-right: 2px">
											<input type="text" class="form-control autonumber text-right" name="discount" id="discount" data-a-sign=" %" data-p-sign="s" data-v-max="100" placeholder="0.00 %" value="<?php echo $discount; ?>" onkeyup="re_calculate()"/>
<!--											<div class="input-group input-icon input-icon-sm right">
												<i class="fa fa-percent"></i>
												<input type="text" class="form-control text-right" name="discount" id="discount" placeholder="0" value="<?php // echo $discount; ?>" onkeyup="re_calculate()"/>
											</div>-->
										</div>
										<div class="col-md-6" style="padding-left: 2px">
											<input type="text" class="form-control text-right" name="total_disc" id="total_disc" value="<?php echo $total_disc; ?>" readonly="readonly"/>
										</div>										
									</div>
									
									<div class="form-group">
										<label class="col-md-6 control-label" for="varchar">Freight</label>
										<div class="col-md-6" style="padding-left: 2px">
											<input type="text" class="form-control autonumber text-right" name="freight" id="freight" value="<?php echo $freight; ?>" onkeyup="re_calculate()"/>
										</div>
									</div>
									
									<div class="form-group">
										<label class="col-md-6 control-label" for="varchar">Tax</label>
										<div class="col-md-6" style="padding-left: 2px">
											<input type="text" class="form-control autonumber text-right" name="tax" id="tax" value="<?php echo $tax; ?>" onkeyup="re_calculate()"/>
										</div>
									</div>
									
									<div class="form-group">
										<label class="col-md-6 control-label" for="varchar">Total FCL</label>
										<div class="col-md-6" style="padding-left: 2px">
											<input type="text" class="form-control autonumber text-right" name="total_fcl" id="total_fcl" value="<?php echo $total_fcl; ?>" onkeyup="re_calculate()" readonly="readonly"/>
										</div>
									</div>
									
									<div class="form-group">
										<label class="col-md-6 control-label" for="varchar">Total</label>
										<div class="col-md-6" style="padding-left: 2px">
											<input type="text" class="form-control text-right" name="grand_total" id="grand_total" value="<?php echo $grand_total; ?>" readonly="readonly" />
										</div>
									</div>
									
								</div>

							</div>
							
							<div class="form-body row">
								<div class="col-md-8">
									<div class="form-group">
										<label class="col-md-3 control-label padding-right-2" for="varchar">
											Remark											
											<a href="#modal_previous" id="previous_remark" data-toggle="modal" class="pull-right" title="Previous Remark">
												<i class="fa fa-commenting"></i>
											</a>
											
										</label>
										<div class="col-md-9">
											<textarea rows="8" class="form-control autosizeme" name="remark" id="remark"><?php echo $remark; ?></textarea>
										</div>
										<span class="help-inline"><?php echo form_error('remark') ?></span>
									</div>	
								</div>
								
								<div class="col-md-4">
									<div class="panel panel-danger">

										<div class="panel-body">
											<div class="form-group">
												<label class="col-md-4 control-label padding-right-2" for="varchar">SM in charge</label>
												<div class="col-md-8">
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
												
											<div class="form-group">
												<label class="col-md-4 control-label padding-right-2" for="varchar">Sales Person</label>
												<div class="col-md-8">
													<?php 
														$extra_sp = 'id= "sales_person_id" class="form-control"';
														$option_sp[''] = '';
														foreach($cbo_sales_person as $sp):
															$option_sp[$sp->userid] = $sp->firstname.' '.$sp->lastname;
														endforeach;
														echo form_dropdown('sales_person_id', $option_sp, $sales_person_id, $extra_sp);
													?>
												</div>
											</div>
											
											<div class="form-group">
												<label class="col-md-4 control-label padding-right-2" for="varchar">Product Manager</label>
												<div class="col-md-8">
													<?php 
														$extra_mgr = 'id= "product_manager" class="form-control" data-placeholder=" "';
														$option_mgr[''] = '';
														foreach($cbo_sales_person as $mgr):
															$option_mgr[$mgr->userid] = $mgr->firstname.' '.$mgr->lastname;
														endforeach;
														echo form_dropdown('product_manager', $option_mgr, $product_manager, $extra_mgr);
													?>
												</div>
											</div>
										</div>

									</div>
								</div>
							</div>
														
							<div class="form-actions">
								<div class="row">
									<div class="col-md-12">
										<input type="button" class="btn btn-default fontawesome-font" value="&#xf002 Search Contract ..." data-target="#modal_find" data-toggle="modal">
										<?php echo $btn_print ?>
										<?php echo $btn_delete ?>
										<a href="<?php echo site_url('sales-contract')?>" type="button" class="btn red pull-right"><i class="fa fa-close"></i> Cancel</a>
										<button type="submit" class="btn green pull-right"><i class="fa fa-save"></i> <?php echo $submit_caption?></button>										
									</div>									
								</div>
							</div>
														
						</div>
					</div>
				</div>
			</form>
			
		</div>
	</div>
	
</div>

<div id="add_product">
	
	<div id="modal_product" class="modal fade bs-modal-lg" role="dialog" tabindex="-1" data-backdrop="static" data-keyboard="false" aria-hidden="true">
	<!--<div id="modal_product" class="modal fade bs-modal-lg" role="dialog" tabindex="-1" aria-hidden="true">-->
		<div class="modal-dialog modal-full">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
					
					<div class="row">
						<div class="col-md-5">
							<div class="input-group">					
								<input id="input_search" name="input_search" class="form-control" type="text" placeholder="Search Product" >
								<span class="input-group-btn">
									<button type="button" id="search_product" class="btn blue" style="border-width: 1px;">
										<i class="icon-magnifier"></i>
									</button>
								</span>
							</div>
						</div>
					</div>
				</div>

				<div class="modal-body padding-5">
					<div id="table_container">
						<table id="tbl_product_head" class="table table-condensed table-hover table-fixed" style="margin-bottom: 2px;">
							<thead>
								<tr>
									<th class="w-70">#</th>
									<th class="sembunyi">Product ID</th>
									<th style="text-align: left;">Product Description</th>
									<th class="w-150" style="text-align: left;">Product Code</th>
									<th class="w-70">Factory</th>				
									<th class="sembunyi">Brand ID</th>
									<th class="sembunyi">UOM ID</th>
									<th class="sembunyi">Factory ID</th>
									<th class="w-100" style="text-align: left;">Packing</th>
									<th class="sembunyi">Estimated</th>
								</tr>
							</thead>
						</table>
						<div class="v-scroll">
							
						</div>
					</div>
				</div>

				<div class="modal-footer">
					<input type="button" class="btn btn-primary" value="Select" onclick="select_product()">
					<button type="button" data-dismiss="modal" class="btn btn-default">Cancel</button>
					<!--<button type="button" data-dismiss="modal" class="btn blue">Select</button>-->
				</div>	
			</div>
		</div>
	</div>
</div>

<div id="find">	
	<div id="modal_find" class="modal fade bs-modal-lg" role="dialog" tabindex="-1" data-backdrop="static" data-keyboard="false" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
					<div class="row">
						<div class="col-md-7">
							<div class="input-group">					
								<input id="input_find" name="input_search" class="form-control" type="text" placeholder="Filter Data Contract (Contract No, Customer, Destination)" >
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

<div id="previous">
	<div id="modal_previous" class="modal fade" role="dialog" tabindex="-1" data-toggle="modal" data-keyboard="false" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
					<h4>
						<i class="fa fa-pencil-square-o"></i>
						Previous Remark
					</h4>
				</div>
				
				<div id="pre_find" class="pre_find">
					
				</div>
				
				<div class="modal-footer">
					<div class="form-actions">
						<div class="row">
							<div class="col-md-12">
								<input type="button" id="btn_append_remark" class="btn green" value="Append Remark"> 
								<input type="button" id="btn_use_remark" class="btn yellow" value="Replace Remark" > 
								<!--<input type="button" id="btn_use_remark" class="btn green" value="Replace Remark" onclick="change_remark();">--> 
								<button type="reset" data-dismiss="modal" class="btn red">Close</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div id="create">	
	<div id="modal_create" class="modal fade" role="dialog" tabindex="-1" data-backdrop="static" data-keyboard="false" aria-hidden="true">
		<div class="modal-dialog modal-md">
			<div class="modal-content">
				<div id="form_create" class="form_create">
					
				</div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	$('select').select2({
		allowClear	: true
	});
	
	$('#rate_usd').autoNumeric('init',{
		mDec	: 6
	});
	
	$('#rate_sgd').autoNumeric('init',{
		mDec	: 6
	});
	
	$('#agen_commission').autoNumeric('init',{
		aSign	: ' %',		
		pSign	: 's'		//suffix to the right
	});
	
	$('.autonum_qty').autoNumeric('init',{
		mDec	: 0
	});
	
	$('.autonum_price').autoNumeric('init',{
		mDec	: 3
	});
	
	$('.autonum_fcl').autoNumeric('init',{
		mDec	: 2
	});
	
	$('.autonum_com_percent').autoNumeric('init',{
		aSign	: ' %',		
		pSign	: 's'		//suffix to the right
	});
	
	$('.autonum_com_unit').autoNumeric('init',{
		mDec	: 2
	});
		
	$('.autonumber').autoNumeric('init');
	
	//fungsi ini untuk menghilangkan list data di modal
	$('.modal').on('hidden.bs.modal', function(){
		$('.v-scroll').html('');
		$('.form_create').html('');
	});
	
	//select all text on focused
	$('.autofocus').on('click', function(){
		this.select();
	});
	
	//select all text on focused
	$('.input-rate').on('click', function(){
		this.select();
	});

	$('.autonumber').on('click', function(){
		this.select();
	});
	
	$('#search_product').on('click',function(){
		var param = $("#input_search").val();
		var p_id = $("input[name='product_id[]']").map(function(){ 
                    return this.value; 
                }).get();
		var f_id = $("input[name='factory_id[]']").map(function(){ 
                    return this.value; 
                }).get();
		
		
		$.ajax({
			type: "POST",
			url : "<?php echo site_url('marketing_misc/search_product/contract')?>",
			data: {
				"product_id[]" : p_id,
				"factory_id[]"	: f_id,
				"param" : param
			},
			success: function(msg){
				$('#table_container').html(msg);
			}
		});
	});
	
	$('#search_find').on('click',function(){
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
	
	$('#previous_remark').on('click',function(){
		var cust_id = $('#customer_id').val();
		
		if (cust_id == ''){
			$.bootstrapGrowl('<strong><i class="fa fa-warning"></i> Please select customer first!</strong>', {
					ele: 'body', // which element to append to
					type: 'danger', // (null, 'info', 'danger', 'success', 'warning')
					offset: {
						from: 'top',
						amount: 250
					}, // 'top', or 'bottom'
					align: 'center', // ('left', 'right', or 'center')
					width: 'auto', // (integer, or 'auto')
					delay: 5000, // Time while the message will be displayed. It's not equivalent to the *demo* timeOut!
					allow_dismiss: true, // If true then will display a cross to close the popup.
					stackup_spacing: 15 // spacing between consecutively stacked growls.
				});
			return false;
		};
		$.ajax({
			type: "POST",
			url	: "<?php echo site_url('sales-contract/previous-remark')?>",
			data: "customer_id="+cust_id,
			success : function(msg){
				$('#pre_find').html(msg);
			}
		});
	});
	
	$('#btn_append_remark').click(function(){
		var sel_rem = $('#selected_remark').val();
		if (sel_rem == ''){
			bootbox.alert('Remark are empty!');
			return false;
		};
		$('#remark').append('\n');
		$('#remark').append($('#selected_remark').val());		
		$('#modal_previous').modal('hide');
	});
	
	$('#btn_use_remark').click(function(){
		var sel_rem = $('#selected_remark').val();
		if (sel_rem == ''){
			bootbox.alert('Remark are empty!');
			return false;
		};
		$('#remark').text($('#selected_remark').val());
		$('#remark').append('\n');		
		$('#modal_previous').modal('hide');
	});
	
	$('#btn_delete').click(function(){
		var headerid = $(this).attr("headerid");
		bootbox.confirm('Are you sure want to delete sales contract data?',function(result){
			if (result){
				$.ajax({
					url:"<?php echo site_url('sales-contract/delete');?>",
					type:"POST",
					data:"headerid="+headerid,
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
						return location.href = "<?php echo site_url('sales-contract');?>";
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
						return location.href="<?php echo site_url('sales-contract');?>";
					}
				});
			} else {
				console.log("Declined delete sales contract data.");
			}
		});
	});
	
	$('#create_trading_term').on('click',function(){
		$.ajax({
			type: "POST",
			url	: "<?php echo site_url('marketing_misc/modal/trading_term')?>",
			success : function(msg){
				$('#form_create').html(msg);
			}
		});
	});
	
	$('#create_payterm').on('click',function(){
		var cust_id = $('#customer_id').val();
		$.ajax({
			type: "POST",
			url	: "<?php echo site_url('marketing_misc/modal/payterm')?>",
			data: {"cust_id" : cust_id},
			success : function(msg){
				$('#form_create').html(msg);
			}
		});
	});
	
	$('#create_shelf_life').on('click',function(){
		$.ajax({
			type: "POST",
			url	: "<?php echo site_url('marketing_misc/modal/shelf_life')?>",
			success : function(msg){
				$('#form_create').html(msg);
			}
		});
	});
	
	$('#create_document').on('click',function(){
		$.ajax({
			type: "POST",
			url	: "<?php echo site_url('marketing_misc/modal/document')?>",
			success : function(msg){
				$('#form_create').html(msg);
			}
		});
	});
	
	$('#btn_append_doc').on('click', function(){
		var doc_name = $('#document_name').val();
		var doc_remark = $('#document_remark').val();
		
		$.ajax({
			type: "POST",
			url : "<?php echo site_url('marketing/save_master_document_modal')?>",
			data: {
				"document_name"		: doc_name,
				"document_remark"	: doc_remark
			},
			success: function(msg){
				$('#list-document > tbody:last-child').append(
					'<tr>\n\
					<td><div class="checker"><span class="checked"><input type="checkbox" name="doc[]" value="'+msg+'"></span></div></td>\n\
					<td>'+doc_name+'</td>\n\
					</tr>'
				);
				console.log(msg);
			},
			error:function(){
				console.log(msg);
			}
		});
		$('#modal_create').modal('hide');
	});
	
//	$('#modal_create').on('hidden.bs.modal',function(){
//		$.ajax({
//			type: "POST",
//			url	: "<?php // echo site_url('marketing_misc/reload/shelf_life')?>",
//			success : function(msg){
//				$('#shelf_life_container').html(msg);
//			}
//		});
//	});
	
//	$(document).ready(function(){
//		$("#tblsales_contract").dataTable({
//			"sScrollX"		: "125%", //This is what made my columns increase in size.
//			"bScrollCollapse": true,
////			"sScrollY": "500px",
//			"autoWidth"		: false,
//			"bLengthChange" : true,
//			"bFilter"		: false
//		});
//	});
</script>

<!-- Select Brand -->
<div class="modal fade" id="modal-select-brand" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog" style="width: 50%;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Select Brand</h4>
            </div>
            <div class="modal-body">
                <input class="form-control input-sm" id="id-brand-this" type="hidden" value="" readonly>
                <div id="contentSelectBrand"> Loading... </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
	
	function viewModalSelectBrand(id){
        $('#id-brand-this').val(id);
        $.ajax({
            url: "<?php echo site_url('marketing_misc/loadDataAjaxForSelectBrand');?>",
            dataType: 'html',
            success: function (data, textStatus, jqXHR) {
                $('#contentSelectBrand').html(data);
            }
        });
        $('#modal-select-brand').modal('show');
    }
	
    function Pilih_Brand(x){
        function getText(el) {
            if (typeof el.textContent == 'string')
                return el.textContent;
            if (typeof el.innerText == 'string')
                return el.innerText;
        }
        $r = x.rowIndex;
        
        var thisID  = $('#id-brand-this').val();
        var getNumIdCFBefore    = thisID.substr(4,1);
        var currentID           = parseInt(getNumIdCFBefore);
        $('#'+thisID).val(getText(document.getElementById('tbl-selectBrand').rows[$r].cells[1]));
        $('#br-'+currentID).val(getText(document.getElementById('tbl-selectBrand').rows[$r].cells[0]));
        
        $('#modal-select-brand').modal('hide');
    }
	
	function select_product()
	{
		function getText(el){
            if (typeof el.textContent == 'string') return el.textContent;
            if (typeof el.innerText == 'string') return el.innerText;
        }
		
		var chk_arr =  document.getElementsByName("chk[]");
        var chk_length = chk_arr.length;
//		var f_id_pre = '';
		
		i = 0;
        n = 1;
        var roww = $('#tblsales_contract tr').length;
        if(roww == 1){
            var currentID = roww;
            var currentID2 = roww;
        }else{
            var idCFbefore  = $('#tblsales_contract tr:last input.brand-text').attr("id");
            var getNumIdCFBefore    = idCFbefore.substr(3,1);
            currentID   = parseInt(getNumIdCFBefore)+1;
            currentID2   = parseInt(getNumIdCFBefore)+1;
        }
		
		for(r=0;r < chk_length ;r++){
			if (chk_arr[r].checked == true){
//				if (f_id_pre != '' && f_id_pre != getText(document.getElementById('tbl_product').rows[i].cells[7])){
//					bootbox.alert('Please select product from the same factory');
//				} else {
					var nn = currentID++;
					var nnn = currentID2++;
					$('#tblsales_contract > tbody:last-child').append(
						'<tr>\n\
							<td class="text-center w-50 bg-editable valign-middle">\n\
								<input type="button" class="btn default btn-xs red-stripe" onclick="removeRow(this)" value="Remove">\n\
								<input type="hidden" name="product_id[]" class="p_id" value="'+getText(document.getElementById('tbl_product').rows[i].cells[1])+'">\n\
								<input type="hidden" name="factory_id[]" class="f_id" value="'+getText(document.getElementById('tbl_product').rows[i].cells[7])+'">\n\
								<input type="hidden" name="contract_dtl_id[]" value="0">\n\
							</td> \n\
							<td><input name="product_name[]" <?php echo $w_prod_desc?> class="form-control input-xs input-table" placeholder="Product Description" readonly="readonly" value="'+getText(document.getElementById('tbl_product').rows[i].cells[2])+'" title="'+getText(document.getElementById('tbl_product').rows[i].cells[2])+'"></td>\n\
							<td><input name="product_code[]" <?php echo $w_prod_code?> class="form-control input-xs input-table" placeholder="Product Code" readonly="readonly" value="'+getText(document.getElementById('tbl_product').rows[i].cells[3])+'" title="'+getText(document.getElementById('tbl_product').rows[i].cells[3])+'"></td>\n\
							<td><input name="factory_abbr[]" <?php echo $w_factory?> class="form-control input-xs input-table" placeholder="Factory" readonly="readonly" value="'+getText(document.getElementById('tbl_product').rows[i].cells[4])+'"></td>\n\
							<td class="bg-editable">\n\
                                    <input name="detail_brand_id[]" id="br-'+nn+'" type="hidden" class="form-control brand-text input-xs input-table">\n\
                                    <input name="brand_name[]" id="brn-'+nnn+'" <?php echo $w_brand?> onClick="viewModalSelectBrand(this.id)" class="form-control input-xs input-table" placeholder="Select Brand" readonly="readonly">\n\
                            </td>\n\
							<td class="bg-editable"><input name="pack_size[]" <?php echo $w_pack_size?> value="'+getText(document.getElementById('tbl_product').rows[i].cells[8])+'" class="form-control input-xs input-table" title="'+getText(document.getElementById('tbl_product').rows[i].cells[8])+'">\n\
							<td><input name="uom_quantity_name[]" <?php echo $w_uom?> value="'+getText(document.getElementById('tbl_product').rows[i].cells[6])+'" class="form-control input-xs input-table" readonly="readonly"></td>\n\
							<td><input name="qty_quotation[]" <?php echo $w_quot_qty?> value="0" class="form-control input-xs text-right input-table" readonly="readonly"></td>\n\
							<td><input name="qty_balance[]" <?php echo $w_bal_qty?> value="0" class="form-control input-xs text-right input-table" readonly="readonly"></td>\n\
							<td class="bg-editable"><input name="qty[]" <?php echo $w_qty?> required type="text" class="form-control input-xs text-right input-table autonum_qty" data-v-min="0" onkeyup="calculate()" value=""></td>\n\
							<td class="bg-editable"><input name="unit_price[]" <?php echo $w_price?> required type="text" class="form-control input-xs text-right input-table autonum_price" data-v-min="0" onkeyup="calculate()"></td>\n\
							<td class="bg-editable">\n\
									<input name="fcl[]" <?php echo $w_fcl?> required value="" type="text" class="form-control input-xs text-right input-table autonum_fcl">\n\
									<input name="container_20ft[]" type="hidden" value="'+getText(document.getElementById('tbl_product').rows[i].cells[9])+'">\n\
									<input name="container_40ft[]" type="hidden" value="'+getText(document.getElementById('tbl_product').rows[i].cells[10])+'">\n\
							</td>\n\
							<td><input name="total[]" <?php echo $w_total?> type="text" class="form-control input-xs text-right input-table" readonly="readonly" value=""></td>\n\
						</tr>'
					);
//					f_id_pre = getText(document.getElementById('tbl_product').rows[i].cells[7]);
//				}
			}
			i++;
		}
		$('#modal_product').modal('hide');
		
		$('.autonum_price').autoNumeric('init',{
			mDec	: 3,
			aDec	: '.',
			aSep	: ','
		});
		
		$('.autonum_qty').autoNumeric('init',{
			mDec	: 0
		});
		
		re_calculate;
	}
	
	$('.autonum_price').autoNumeric('init',{
		mDec	: 3,
		aDec	: '.',
		aSep	: ','
	});
	$('.autonum_qty').autoNumeric('init',{
		mDec	: 0
	});
		
	function removeRow(btn) {
		var row = btn.parentNode.parentNode;
		row.parentNode.removeChild(row);
		re_calculate();
	}
	
	function disc(){
        var disc = remove_percent(document.getElementById('discount').value) / 100;
        var total = remove_thousand_separator(document.getElementById('total_before_disc').value);
        var grantotal = total * disc;
        document.getElementById('total_disc').value = number_format(grantotal, 2);
    }
	
	function calculate(){
        var int=0;
        var total=0;
		var total_fcl = 0;
		var arr_container_list = $('#container_list').val().split('|');
		var container_size = arr_container_list[1];
        		
        $('#tblsales_contract tr').each(function() {
//			var quo_qty = remove_thousand_separator($(this).find("input[name='qty_quotation[]']").val());
			var qty = remove_thousand_separator($(this).find("input[name='qty[]']").val());
            var unit_price = remove_thousand_separator($(this).find("input[name='unit_price[]']").val());
//			var estimated = $(this).find("input[name='estimated[]']").val();
			var container_20 = remove_thousand_separator($(this).find("input[name='container_20ft[]']").val());
			var container_40 = remove_thousand_separator($(this).find("input[name='container_40ft[]']").val());
            var total_row = qty * unit_price;
			var fcl =  $(this).find('input[name="fcl[]"]').val();
						
			if (container_size == 20){
				if (container_20 > 0){
					fcl = qty/container_20;
				} else {
					fcl = 0;
				}
			}
			
			if (container_size == 40){
				if (container_40 > 0){
					fcl = qty/container_40;
				} else {
					fcl = 0;
				}
			}
						
//			$(this).find("input[name='qty_balance[]']").val(number_format(bal_qty, 0));
            $(this).find("input[name='total[]']").val(number_format(total_row, 2));
			$(this).find("input[name='fcl[]']").val(number_format(fcl, 2));
			
            if(int > 0){
                total += total_row;
				total_fcl += fcl;
            }
            int +=1;
        });
          
        document.getElementById('total_before_disc').value=number_format(total, 2);
		document.getElementById('total_fcl').value=number_format(total_fcl, 2);
        disc();
        
        var total_disc = remove_thousand_separator(document.getElementById('total_disc').value);
        var freight = remove_thousand_separator(document.getElementById('freight').value);
        var tax = remove_thousand_separator(document.getElementById('tax').value);
        var grand_total = total - total_disc - freight - tax;
        document.getElementById('grand_total').value= number_format(grand_total, 2);
    }
	
	function re_calculate(){
		var dis = remove_thousand_separator(document.getElementById('discount').value) / 100;
        var total = remove_thousand_separator(document.getElementById('total_before_disc').value);
        var grand_total = total * dis;
        document.getElementById('total_disc').value = number_format(grand_total, 2);
        
        calculate();
	}
	
	
	function agent_percent(){		
		var com_percent = remove_percent(document.getElementById('agent_com_percent').value);
		
		if (com_percent > 0){
			document.getElementById('agent_com_unit').value = '';
		}
	}
	
	function agent_unit(){
		var com_unit = remove_thousand_separator(document.getElementById('agent_com_unit').value);
		
		if (com_unit > 0){
			document.getElementById('agent_com_percent').value = '';
		}
	}
	
//	function change_remark(){
//        document.getElementById("remark").value = document.getElementById("selected_remark").value;
//		$('#modal_previous').modal('hide');
//    }
	
	function select_remark(ind){
		 function getText(el){
            if (typeof el.textContent == 'string') return el.textContent;
            if (typeof el.innerText == 'string') return el.innerText;
        }

        $r = ind.rowIndex;
        document.getElementById('selected_remark').value = getText(document.getElementById('tbl_previous').rows[$r].cells[1]);
	}
	
	function change_container(){
		var arr_container_list = $('#container_list').val().split('|');
//		var container_size = arr_container_list[1];
		
		$('#container_id').val(arr_container_list[0]);
		
		re_calculate();
	}
	
	function change_destination(){
		var arr_port_list = $('#port_list').val().split('|');
		
		$('#port_id').val(arr_port_list[0]);
		$('#destination_id').val(arr_port_list[1]);
	}
</script>