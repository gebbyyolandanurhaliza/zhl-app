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
								<div class="col-md-7">
									
									<?php echo form_hidden('quotation_hdr_id', $quotation_hdr_id)?>
									<?php echo form_hidden('contract_hdr_id', $contract_hdr_id)?>
									
									<!--<br>-->
									
									<div class="form-group">
										<label class="col-md-3 control-label" for="varchar">Sales Quotation No</label>
										<div class="col-md-5">
											<input readonly="readonly" type="text" class="form-control" name="quotation_number" id="sales_contract_no" value="<?php echo $quotation_number?>"/>											
										</div>	
										<span class="help-inline"><?php echo form_error('quotation_number') ?></span>
									</div>
									
									<div class="form-group">
										<label class="col-md-3 control-label" for="varchar">Sales Contract No</label>
										<div class="col-md-5">
											<input readonly="readonly" type="text" class="form-control" name="sales_contract_no" id="sales_contract_no" value="<?php echo $sales_contract_no?>" placeholder="Auto Generate Once Saved"/>											
										</div>	
										<span class="help-inline"><?php echo form_error('sales_contract_no') ?></span>
									</div>
									
									<div class="form-group required">
										<label class="col-md-3 control-label" for="varchar">Contract Date</label>
										<div class="col-md-5">
											<input required type="text" class="form-control date date-picker" data-date="<?php echo $current_date ?>" data-date-format="mm-dd-yyyy" name="contract_date" id="contract_date" value="<?php echo $contract_date; ?>" title="date format : mm-dd-yyyy" />
										</div>
										<span class="help-inline"><?php echo form_error('contract_date') ?></span>
									</div>
									
									<div class="form-group required">
										<label class="col-md-3 control-label" for="varchar">Buyer / Customer</label>
										<div class="col-md-5">
											<?php 
												if ($quotation_hdr_id == 0) {
													$disabled_cust = 'required';
												} else {
													$disabled_cust = 'disabled="disabled"';
												}
												$extra_company = $disabled_cust.' id="list_customer" class="form-control select2me"';
												$option_company[''] = '';
												foreach($cbo_company as $r):
													$option_company[$r->customer_id] = $r->customer_company_name;
												endforeach;
												echo form_dropdown('list_customer', $option_company, $customer_id, $extra_company);
//												echo form_hidden('customer_id', $customer_id);
											?>											
										</div>
										<span class="help-inline"><?php echo form_error('customer_id') ?></span>
									</div>
									
									<script type="text/javascript">
										$('#list_customer').change(function(){
//												var selectValues = $('#customer_id').val();												
											var customer_id = {customer_id:$("#list_customer").val()};
											$.ajax({
												type: "POST",
												url : "<?php echo site_url('marketing_misc/sales_contract_get_customer')?>",
												data: customer_id,
												success: function(msg){
													$('#header').html(msg);
												}
											});
											
											$.ajax({
												type: "POST",
												url : "<?php echo site_url('marketing_misc/sales_contract_get_agent')?>",
												data: customer_id,
												success: function(msg){
													$('#agent_container').html(msg);
												}
											});
										});
									</script>
									
									<div id="agent_container">
										<div class="form-group">
											<label class="col-md-3 control-label" for="varchar">Agent</label>
											<div class="col-md-5">
												<?php 
													$extra_agent = 'id= "agent_id" class="form-control select2me"';
													$option_agent[''] = '';
													if ($cbo_agent){
														foreach($cbo_agent as $r):
															$option_agent[$r->agent_id] = $r->agent_name;													
														endforeach;
													}
													echo form_dropdown('agent_id', $option_agent, $agent_id, $extra_agent);
												?>
											</div>
										</div>
									</div>
									
									<div class="form-group ">
										<label class="col-md-3 control-label" for="varchar">Customer Reference</label>
										<div class="col-md-5">
											<input type="text" class="form-control" name="customer_reference" id="customer_reference" value="<?php echo $customer_reference?>" />
										</div>
										<span class="help-inline"><?php echo form_error('customer_reference') ?></span>
									</div>
									
									<div class="form-group required">
										<label class="col-md-3 control-label" for="varchar">Trading Term</label>
										<div class="col-md-5">
											<?php 
												$extra_tradingterm = 'required class="form-control select2me" ';
												$option_tradingterm[''] = '';
												foreach($cbo_tradingterm as $r):
													$option_tradingterm[$r->trading_term_id] = $r->trading_term_name . ' (' . $r->trading_term_remark .')';
												endforeach;
												echo form_dropdown('tradingterm_id', $option_tradingterm, $tradingterm_id, $extra_tradingterm);
											?>
										</div>
										<span class="help-inline"><?php echo form_error('tradingterm_id') ?></span>
									</div>
									
									<div class="form-group required">
										<label class="col-md-3 control-label" for="varchar">Shipment From</label>
										<div class="col-md-5">
											<?php 
												$extra_ship_from = 'required class="form-control select2me"';
												$option_ship_from[''] = '';
												$option_ship_from['SGP'] = 'Singapore';
												$option_ship_from['INA'] = 'Indonesia';
												
												echo form_dropdown('shipment_from', $option_ship_from, $shipment_from, $extra_ship_from);
											?>
										</div>
										<span class="help-inline"><?php echo form_error('shipment_from') ?></span>
									</div>
									
									<div class="form-group required">
										<label class="col-md-3 control-label" for="varchar">Final Destination </label>
										<div class="col-md-5">
											<?php 
												$extra_destination = 'required id="destination_id" class="form-control select2me"';
												$option_destination[''] = '';
												foreach($cbo_destination as $r):
													$option_destination[$r->country_id] = $r->country_name;
												endforeach;
												echo form_dropdown('destination_id', $option_destination, $destination_id, $extra_destination);
											?>

										</div>
										<span class="help-inline"><?php echo form_error('destination_id') ?></span>
									</div>
									
									<script type="text/javascript">
										$('#destination_id').change(function(){											
											var destination_id = {destination_id:$("#destination_id").val()};
											$('#port_id').select2('val','');
											$.ajax({
												type: "POST",
												url : "<?php echo site_url('marketing_misc/get_port_discharge')?>",
												data: destination_id,
												success: function(msg){
													$('#div_port').html(msg);													
												}
											});	
										});
										
									</script>
									
									<div class="form-group required">
										<label class="col-md-3 control-label" for="varchar">Port of Discharge</label>
										<div class="col-md-5">
											<div id="div_port">
											<?php 
												$extra_port = 'required id="port_id" class="form-control select2me"';
												$option_port[''] = '';
												foreach($cbo_port as $r):
													$option_port[$r->port_id] = $r->port_name.' ('.$r->port_code.')';
												endforeach;
												echo form_dropdown('port_id', $option_port, $port_id, $extra_port);
											?>
											<!--<input type="text" class="form-control" name="port_discharge" id="port_discharge" value="<?php echo $port_discharge; ?>" />-->
											</div>
										</div>
										<span class="help-inline"><?php echo form_error('port_id') ?></span>
									</div>
									
									<div class="form-group">
										<label class="col-md-3 control-label" for="varchar">Container Loading</label>
										<div class="col-md-5">
											<?php 
												$extra_container = 'id="container_id" class="form-control select2me"';
												$option_container[''] = '';
												foreach($cbo_container as $r):
													$option_container[$r->container_id] = $r->container_name;
												endforeach;
												echo form_dropdown('container_id', $option_container, $container_id, $extra_container);
											?>											
										</div>
										<span class="help-inline"><?php echo form_error('container_id') ?></span>
									</div>
									
									<div class="form-group">
										<label class="col-md-3 control-label" for="varchar">Partial Shipment</label>
										<div class="col-md-5">
											<?php 
												$extra_partial_shipment = 'id="partial_shipment" class="form-control select2me"';
												$option_partial_shipment[''] = '';
												
												$option_partial_shipment['Allowed'] = 'Allowed';
												$option_partial_shipment['Not Allowed'] = 'Not Allowed';
												
												echo form_dropdown('partial_shipment', $option_partial_shipment, $partial_shipment, $extra_partial_shipment);
											?>											
										</div>
										<span class="help-inline"><?php echo form_error('partial_shipment') ?></span>
									</div>
									
									<div class="form-group">
										<label class="col-md-3 control-label" for="varchar">Marine Insurance</label>
										<div class="col-md-5">
											<?php 
												$extra_marine_insurance = 'id="marine_insurance" class="form-control select2me"';
												$option_marine_insurance[''] = '';
												
												$option_marine_insurance['Covered By Buyer'] = 'Covered By Buyer';
												$option_marine_insurance['Covered By Seller'] = 'Covered By Seller';
												
												echo form_dropdown('marine_insurance', $option_marine_insurance, $marine_insurance, $extra_marine_insurance);
											?>											
										</div>
										<span class="help-inline"><?php echo form_error('marine_insurance') ?></span>
									</div>
									
									<div class="form-group">
										<label class="col-md-3 control-label" for="varchar">Shipping Line</label>
										<div class="col-md-5">
											<input type="text" class="form-control" name="shipping_line" id="shipping_line" value="<?php echo $shipping_line; ?>" />
										</div>
										<span class="help-inline"><?php echo form_error('shipping_line') ?></span>
									</div>
									
									<div class="form-group">
										<label class="col-md-3 control-label" for="varchar">Shipment Schedule</label>
										<div class="col-md-5">
											<input type="text" class="form-control" name="shipment_schedule" id="shipment_schedule" value="<?php echo $shipment_schedule; ?>" />
										</div>
										<span class="help-inline"><?php echo form_error('shipment_schedule') ?></span>
									</div>
									
									<div class="form-group required">
										<label class="col-md-3 control-label" for="varchar">Local Currency</label>
										<div class="col-md-5">
											<?php 
												$extra_currency = 'required id="local_currency" class="form-control select2me"';
												$option_currency[''] = '';
												foreach($cbo_currency as $r):
													$option_currency[$r->currency_id] = $r->currency_id.' - '.$r->currency_name;													
												endforeach;
												echo form_dropdown('local_currency', $option_currency, $local_currency, $extra_currency);
											?>
										</div>
										<span class="help-inline"><?php echo form_error('local_currency') ?></span>
									</div>
									
									<script type="text/javascript">
										$('#local_currency').change(function(){
											var currency_id = {currency_id:$("#local_currency").val()};
											$.ajax({
												type: "POST",
												url : "<?php echo site_url('marketing_misc/get_rate')?>",
												data: currency_id,
												success: function(msg){
													$('#div_rate').html(msg);
												}
											});
										});
									</script>
									
									<div id="div_rate">
										<div class="form-group required">
											<label class="col-md-3 control-label" for="varchar">Rate to USD</label>
											<div class="col-md-3">
												
													<input required type="text" class="form-control text-right" name="rate_usd" id="rate_usd" placeholder="0.000000" value="<?php echo $rate_usd; ?>" title="6 digits decimal" />
													<!--<input type="number" step="0.01" min="0" class="form-control text-right" name="rate_usd" id="rate" placeholder="0" value="<?php echo $rate_usd; ?>"  onkeypress="return isNumber(event)" />-->
												
											</div>
											<span class="help-inline"><?php echo form_error('rate_usd') ?></span>
										</div>

										<div class="form-group required">
											<label class="col-md-3 control-label" for="varchar">Rate to SGD</label>
											<div class="col-md-3">
												
													<input required type="text" class="form-control text-right" name="rate_sgd" id="rate_sgd" placeholder="0.000000" value="<?php echo $rate_sgd; ?>" title="6 digits decimal" />
													<!--<input type="number" step="0.01" min="0" class="form-control text-right" name="rate_sgd" id="rate" placeholder="0" value="<?php echo $rate_sgd; ?>"  onkeypress="return isNumber(event)" />-->
												
											</div>
											<span class="help-inline"><?php echo form_error('rate_sgd') ?></span>
										</div>
									</div>
									
									<div class="form-group">
										<label class="col-md-3 control-label" for="varchar">Agent Commission</label>
										<div class="col-md-3">											
											<input type="text" class="form-control text-right" name="agen_commission" id="agen_commission" data-a-sign=" %" data-p-sign="s" data-v-max="100" placeholder="0.00 %" value="<?php echo $agen_commission; ?>"/>
										</div>
									</div>
									
								</div>

								<div class="col-md-5">

									<div class="panel panel-default">
										<div class="panel-heading">
											<h3 class="panel-title">
												Customer Contact Information
											</h3>
										</div>
										
										<div class="panel-body">
											<div id="header">
												<div class="form-group">
													<label class="col-md-4 control-label" for="varchar">Company's Name</label>
													<div class="col-md-7">
														<?php 
////															$disabled_cust = ($with_quotation == 1 ? 'disabled="disabled"' : '');
//															if ($quotation_hdr_id == 0) {
//																$disabled_cust = 'required';
//															} else {
//																$disabled_cust = 'disabled="disabled"';
//															}
//															$extra_company = $disabled_cust.' id="list_customer" class="form-control select2me"';
															$extra_company = 'disabled id="list_customer" class="form-control select2me"';
															$option_company[''] = '';
															foreach($cbo_company as $r):
																$option_company[$r->customer_id] = $r->customer_company_name;
															endforeach;
															echo form_dropdown('list_customer', $option_company, $customer_id, $extra_company);
															echo form_hidden('customer_id', $customer_id);
														?>
														<!--<span class="help-inline"><?php // echo form_error('customer_id') ?></span>-->
													</div>
													
												</div>

<!--												<script type="text/javascript">
													$('#list_customer').change(function(){
		//												var selectValues = $('#customer_id').val();												
														var customer_id = {customer_id:$("#list_customer").val()};
														$.ajax({
															type: "POST",
															url : "<?php // echo site_url('marketing_misc/sales_contract_get_customer')?>",
															data: customer_id,
															success: function(msg){
																$('#header').html(msg);
															}
														});												
													});
												</script>-->

												<div class="form-group">
													<label class="col-md-4 control-label" for="varchar">Customer Name</label>
													<div class="col-md-7">
														<input readonly="readonly" type="text" class="form-control" name="customer_name" id="customer_name" value="<?php echo $customer_name; ?>" />
													</div>
													<span class="help-inline"><?php echo form_error('customer_name') ?></span>
												</div>

												<div class="form-group">
													<label class="col-md-4 control-label" for="varchar">Customer Country</label>
													<div class="col-md-4" style="padding-right: 3px">
														<?php 
															$extra_country = 'disabled="disabled" id="country_id" class="form-control select2me"';
															$option_country[''] = '';
															foreach($cbo_country as $r):
																$option_country[$r->country_id] = $r->country_name;
															endforeach;
															echo form_dropdown('country_id', $option_country, $country_id, $extra_country);
														?>
														<span class="help-inline"><?php echo form_error('country_id') ?></span>
													</div>
													<!--<label class="col-md-1 control-label" for="varchar" style="padding-left: 0; padding-right: 5px;">IDD</label>-->
													<div class="col-md-3" style="padding-left: 3px">
														<div class="input-icon" id="div_idd">
															<i class="fa fa-phone" style="font-size: 18px; margin-top: 6px;"></i>
															<input type="text" class="form-control text-center" name="country_idd" value="<?php echo $country_idd?>" placeholder="IDD" readonly="readonly" title="IDD Code">
														</div>
													</div>

													<script type="text/javascript">
														$('#country_id').change(function(){
															var selectValues = $('#country_id').val();
															if (selectValues === 0){
																var msg = '<i class="fa fa-phone" style="font-size: 18px; margin-top: 6px;"></i><input type="text" class="form-control text-center" name="country_idd" value="" placeholder="IDD" readonly="readonly" title="IDD Code">';
																$('#div_idd').html(msg);
															} else {
																var country_id = {country_id:$("#country_id").val()};
																$.ajax({
																	type: "POST",
																	url : "<?php echo site_url('marketing_misc/get_idd')?>",
																	data: country_id,
																	success: function(msg){
																		$('#div_idd').html(msg);
																	}
																});
															}
														});
													</script>
												</div>

												<div class="form-group">
													<label class="col-md-4 control-label" for="varchar">Address</label>
													<div class="col-md-7">
														<textarea readonly="readonly" rows="3" class="form-control autosizeme" name="customer_address" id="customer_address" value="<?php echo $customer_address; ?>"></textarea>
													</div>
													<span class="help-inline"><?php echo form_error('customer_address') ?></span>
												</div>

												<div class="form-group">
													<label class="col-md-4 control-label" for="varchar">Customer Phone</label>
													<div class="col-md-7">
														<input readonly="readonly" type="text" class="form-control" name="customer_phone" id="customer_phone" value="<?php echo $customer_phone; ?>" />
													</div>
													<span class="help-inline"><?php echo form_error('customer_phone') ?></span>
												</div>

												<div class="form-group">
													<label class="col-md-4 control-label" for="varchar">Customer Fax</label>
													<div class="col-md-7">
														<input readonly="readonly" type="text" class="form-control" name="customer_fax" id="customer_fax" value="<?php echo $customer_fax; ?>" />
													</div>
													<span class="help-inline"><?php echo form_error('customer_fax') ?></span>
												</div>

												<div class="form-group">
													<label class="col-md-4 control-label" for="varchar">Customer Email</label>
													<div class="col-md-7">
														<input readonly="readonly" type="text" class="form-control" name="customer_email" id="customer_email" value="<?php echo $customer_email; ?>" />													
													</div>
													<span class="help-inline"><?php echo form_error('customer_email') ?></span>
												</div>
											</div>

										</div>
									</div>
									
									<div class="panel panel-default">
										<div class="panel-heading">
											<h3 class="panel-title">
												Bank Details
											</h3>
										</div>
										
										<div class="panel-body">
											<div id="bank_info">
												<div class="form-group required">
													<label class="col-md-4 control-label" for="varchar">Name</label>
													<div class="col-md-7">
														<?php 
															$extra_bank = 'required id="bank_id" class="form-control select2me"';
															$option_bank[''] = '';
															foreach($cbo_bank as $r):
																$option_bank[$r->bank_id] = $r->bank_name.', '.$r->bank_city;													
															endforeach;
															echo form_dropdown('bank_id', $option_bank, $bank_id, $extra_bank);
														?>
														<span class="help-inline"><?php echo form_error('bank_id') ?></span>
													</div>													
												</div>
												
												<script type="text/javascript">
													$('#bank_id').change(function(){
														var bank_id = {bank_id:$("#bank_id").val()};
														$.ajax({
															type: "POST",
															url : "<?php echo site_url('marketing_misc/sales_contract_get_bank')?>",
															data: bank_id,
															success: function(msg){
																$('#bank_info').html(msg);
															}
														});
													});
												</script>
												
												<div class="form-group">
													<label class="col-md-4 control-label" for="varchar">Account Number</label>
													<div class="col-md-7">
														<input readonly="readonly" type="text" class="form-control" name="bank_account_number" id="bank_account_number" value="<?php echo $bank_account_number; ?>" />
													</div>													
												</div>
												
												<div class="form-group">
													<label class="col-md-4 control-label" for="varchar">Address</label>
													<div class="col-md-7">
														<input readonly="readonly" type="text" class="form-control" name="bank_address" id="bank_address" value="<?php echo $bank_address; ?>" />
													</div>													
												</div>
												
												<div class="form-group">
													<label class="col-md-4 control-label" for="varchar">City</label>
													<div class="col-md-7">
														<input readonly="readonly" type="text" class="form-control" name="bank_city" id="bank_city" value="<?php echo $bank_city; ?>" />
													</div>
													
												</div>
												
												<div class="form-group">
													<label class="col-md-4 control-label" for="varchar">Country</label>
													<div class="col-md-7">
														<input readonly="readonly" type="text" class="form-control" name="bank_country_name" id="bank_country_name" value="<?php echo $bank_country_name; ?>" />
													</div>
												</div>

											</div>
										</div>
									</div>
									
								</div>
							</div>	
							
							<div class="form-body row">
								<!-- contract detail -->
								<div class="col-md-12">
									<hr>
									
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
									
									<div class="table-responsive">
										<table class="table table-bordered table-condensed table-detail" id="tblsales_contract">
											<thead>
												<tr>
													<th class="w-50">&nbsp;</th>
													<th class="w-300">Product Description</th>
													<th class="w-180">Product Code</th>
													<th class="w-180">Brand Name</th>
													<th class="w-150">UOM</th>
													<th class="w-100">Unit Price</th>
													<th class="w-100">Qty</th>
													<th class="w-130">Total</th>
													
<!--													<th class="w-150">Payment Term</th>
													<th class="w-100">Product Shelf Life</th>-->
												</tr>
											</thead>
											<tbody>
												<?php
												if ($detail){
													foreach ($detail as $d){
														$sub_total = $d->price * $d->quantity;
														
														echo "<tr>";
														//Kolom Tombol
														echo "<td class='text-center w-50 bg-editable valign-middle'>";
														echo "<input type='button' class='btn default btn-xs red-stripe' onclick='removeRow(this)' value='Remove'>";
														echo "<input type='hidden' name='product_id[]' value='$d->product_id'>";
														echo "<input type='hidden' name='factory_id[]' value='$factory_id'>";
//														echo "<input type='hidden' name='quotation_dtl_id[]' value='$d->quotation_dtl_id'>";
														echo "</td>";
														//Kolom Product Description
														echo "<td class='w-300'>";
														echo "<input name='product_name[]' value='$d->product_name' class='form-control input-xs input-table' placeholder='Product Name' readonly='readonly' title='$d->product_name'>";
														echo "</td>";
														//Kolom Product Code
														echo "<td class='w-180'>";
														echo "<input name='product_code[]' value='$d->product_code' class='form-control input-xs input-table' placeholder='Product Code' readonly='readonly' title='$d->product_code'>";
														echo "</td>";
														//Kolom Brand Name
														echo "<td class='w-180'>";
														echo "<input name='brand[]' value='$d->brand_name' class='form-control input-xs input-table' readonly='readonly'>";
														echo "</td>";
														//Kolom UOM
														echo "<td class='w-150'>";
														echo "<input name='uom[]' value='$d->uom_quantity_name' class='form-control input-xs input-table' readonly='readonly'>";
														echo "</td>";
														//Kolom Unit Price
														echo "<td class='w-100 bg-editable'>";
														echo "<input name='unit_price[]' required value='".number_format($d->price, 3, '.', ',')."' type='text' class='form-control input-xs text-right input-table' onkeypress='return isNumber(event)' onkeyup='calculate()'>";
														echo "</td>";
														//Kolom Qty
														echo "<td class='w-100 bg-editable'>";
														echo "<input name='qty[]' required value='".number_format($d->quantity, 0, '.', ',')."' type='text' class='form-control input-xs text-right input-table' onkeypress='return isNumber(event)' onkeyup='calculate()'>";
														echo "</td>";
														//Kolom Total
														echo "<td class='w-130'>";
														echo "<input name='total[]' value='".number_format($sub_total, 2,'.',',')."' type='text' class='form-control input-xs text-right input-table' readonly='readonly'>";
														echo "</td>";
														
														echo "</tr>";
													}
												}
												?>
											</tbody>
										</table>
									</div>									
									
								</div>
							</div>	
							
							<div class="form-body row">																
								<div class="col-md-6">
									
									
									<div class="form-group">
										<label class="col-md-3 control-label" for="varchar">Payment Terms</label>
										<div class="col-md-8">
											<div id="payterm-container">
											<?php 
												$extra_payterm = 'id="payment_term" class="form-control select2me"';
												$option_payterm[''] = '';
												foreach($cbo_payterm as $r):
													$option_payterm[$r->payment_term] = $r->payment_term;													
												endforeach;
												echo form_dropdown('payment_term', $option_payterm, $payment_term, $extra_payterm);
											?>
											<!--<input type="text" class="form-control" name="payment_terms" id="payment_terms" value="<?php echo $payment_terms ?>"/>-->											
											</div>
										</div>
									</div>
									
									<div class="form-group">
										<label class="col-md-3 control-label" for="varchar">Shelf Life</label>
										<div class="col-md-4">
											<?php 
												$extra_shelf = 'id="product_shelf_life_id" class="form-control select2me"';
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
										<label class="col-md-3 control-label" for="varchar">Document Provided by Seller</label>
										<div class="col-md-8">
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
									
									<div class="form-group">
										<label class="col-md-3 control-label" for="varchar">Remark</label>
										<div class="col-md-8">
											<textarea rows="3" class="form-control autosizeme" name="remark" id="remark"><?php echo $remark; ?></textarea>
										</div>
										<span class="help-inline"><?php echo form_error('remark') ?></span>
									</div>									
									
								</div>
								
								<div class="col-md-6 col-md-push-2">
									
									<div class="form-group">
										<label class="col-md-4 control-label" for="varchar">Total before discount</label>
										<div class="col-md-4" style="padding-left: 2px">
											<input type="text" readonly="readonly" class="form-control text-right" name="total_before_disc" id="total_before_disc" value="<?php echo $total_before_disc; ?>" />
										</div>
										<span class="help-inline"><?php echo form_error('total_before_disc') ?></span>
									</div>
									
									<div class="form-group">
										<label class="col-md-2 control-label label-sm" for="varchar">Discount</label>
										<div class="col-md-2" style="padding-right: 2px">
											<input type="text" class="form-control autonumber text-right" name="discount" id="discount" data-a-sign=" %" data-p-sign="s" data-v-max="100" placeholder="0.00 %" value="<?php echo $discount; ?>" onkeyup="re_calculate()"/>
<!--											<div class="input-group input-icon input-icon-sm right">
												<i class="fa fa-percent"></i>
												<input type="text" class="form-control text-right" name="discount" id="discount" placeholder="0" value="<?php // echo $discount; ?>" onkeyup="re_calculate()"/>
											</div>-->
										</div>
										<div class="col-md-4" style="padding-left: 2px">
											<input type="text" class="form-control text-right" name="total_disc" id="total_disc" value="<?php echo $total_disc; ?>" readonly="readonly"/>
										</div>
										<span class="help-inline"><?php echo form_error('total_disc') ?></span>
									</div>
									
									<div class="form-group">
										<label class="col-md-4 control-label" for="varchar">Freight</label>
										<div class="col-md-4" style="padding-left: 2px">
											<input type="text" class="form-control autonumber text-right" name="freight" id="freight" value="<?php echo $freight; ?>" onkeyup="re_calculate()"/>
										</div>
										<span class="help-inline"><?php echo form_error('freight') ?></span>
									</div>
									
									<div class="form-group">
										<label class="col-md-4 control-label" for="varchar">Tax</label>
										<div class="col-md-4" style="padding-left: 2px">
											<input type="text" class="form-control autonumber text-right" name="tax" id="tax" value="<?php echo $tax; ?>" onkeyup="re_calculate()"/>
										</div>
										<span class="help-inline"><?php echo form_error('tax') ?></span>
									</div>
									
									<div class="form-group">
										<label class="col-md-4 control-label" for="varchar">Total</label>
										<div class="col-md-4" style="padding-left: 2px">
											<input type="text" class="form-control text-right" name="grand_total" id="grand_total" value="<?php echo $grand_total; ?>" readonly="readonly" />
										</div>
										<span class="help-inline"><?php echo form_error('grand_total') ?></span>
									</div>
									
								</div>

							</div>
							
							<div class="form-actions">
								<div class="row">
									<div class="col-md-12">
										<input type="button" class="btn btn-default fontawesome-font" value="&#xf002 Search Contract ..." data-target="#modal_find" data-toggle="modal">
										<?php echo $btn_print ?>
										<?php echo $btn_delete ?>
										<a href="<?php echo site_url('marketing_transaction/sales_contract')?>" type="button" class="btn red pull-right"><i class="fa fa-close"></i> Cancel</a>
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
		<div class="modal-dialog modal-lg">
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
						<div class="v-scroll">
							<table id="tbl_product" class="table table-condensed table-hover table-fixed">
								<thead>
									<tr>
										<th class="w-70">#</th>
										<th class="sembunyi">Product ID</th>
										<th>Name</th>
										<th class="w-120">Code</th>
										<th class="sembunyi">UOM ID</th>
										<th class="sembunyi">Brand ID</th>
									</tr>
								</thead>
								<tbody>

								</tbody>
							</table>
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
<!--							<table id="tbl_find" class="table table-condensed table-hover table-fixed">
								<thead>
									<tr>
										<th class="w-70">#</th>
										<th class="w-100">Contract No</th>
										<th class="w-100">Date</th>
										<th>Customer</th>
										<th class="w-200">Destination</th>
									</tr>
								</thead>
								<tbody>

								</tbody>
							</table>-->
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

<!--<script type="text/javascript">
	$('#tbl_product').DataTable({
		bLengthChange : false,
		bFilter : false
	});
</script>-->

<script type="text/javascript">
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
	
	$('.autonumber').autoNumeric('init');
	
	//fungsi ini untuk menghilangkan list data di modal
	$('.modal').on('hidden.bs.modal', function(){
		$('.v-scroll').html('');
	});
	
	//select all text on focused
	$('.input-table').on('click', function(){
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
			url : "<?php echo site_url('marketing_transaction/sales_contract/find')?>",
			data: find,
			success: function(msg){
				$('#table_find').html(msg);
			}
		});
	});
	
	$('#btn_delete').click(function(){
		var headerid = $(this).attr("headerid");
		bootbox.confirm('Are you sure want to delete sales contract data?',function(result){
			if (result){
				$.ajax({
					url:"<?php echo site_url('marketing_transaction/sales_contract/delete');?>",
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
						return location.href = "<?php echo site_url('marketing_transaction/sales_contract');?>";
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
						return location.href="<?php echo site_url('marketing_transaction/sales_contract');?>";
					}
				});
			} else {
				console.log("Declined delete sales contract data.");
			}
		});
	});
	
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

<script>
	function select_product()
	{
		function getText(el){
            if (typeof el.textContent == 'string') return el.textContent;
            if (typeof el.innerText == 'string') return el.innerText;
        }
		
		var chk_arr =  document.getElementsByName("chk[]");
        var chk_length = chk_arr.length;
		var f_id_pre = '';
		
		i = 1;
		for(r=0;r < chk_length ;r++){
			if (chk_arr[r].checked == true){
				if (f_id_pre != '' && f_id_pre != getText(document.getElementById('tbl_product').rows[i].cells[7])){
					bootbox.alert('Please select product from the same factory');
				} else {
					$('#tblsales_contract > tbody:last-child').append(
						'<tr>\n\
							<td class="text-center w-50 bg-editable valign-middle">\n\
								<input type="button" class="btn default btn-xs red-stripe" onclick="removeRow(this)" value="Remove">\n\
								<input type="hidden" name="product_id[]" class="p_id" value="'+getText(document.getElementById('tbl_product').rows[i].cells[1])+'">\n\
								<input type="hidden" name="factory_id[]" class="f_id" value="'+getText(document.getElementById('tbl_product').rows[i].cells[7])+'">\n\
								<input type="hidden" name="contract_dtl_id[]" value="0">\n\
							</td> \n\
							<td class="w-300"><input name="product_name[]" class="form-control input-xs input-table" placeholder="Product Name" readonly="readonly" value="'+getText(document.getElementById('tbl_product').rows[i].cells[2])+'" title="'+getText(document.getElementById('tbl_product').rows[i].cells[2])+'"></td>\n\
							<td class="w-180"><input name="product_code[]" class="form-control input-xs input-table" placeholder="Product Code" readonly="readonly" value="'+getText(document.getElementById('tbl_product').rows[i].cells[3])+'" title="'+getText(document.getElementById('tbl_product').rows[i].cells[3])+'"></td>\n\
							<td class="w-180"><input name="brand[]" value="'+getText(document.getElementById('tbl_product').rows[i].cells[5])+'" class="form-control input-xs input-table" readonly="readonly"></td>\n\
							<td class="w-150"><input name="uom[]" value="'+getText(document.getElementById('tbl_product').rows[i].cells[6])+'" class="form-control input-xs input-table" readonly="readonly"></td>\n\
							<td class="w-100 bg-editable"><input name="unit_price[]" required type="text" class="form-control input-xs text-right input-table autonum_price" data-v-min="0" onkeyup="calculate()"></td>\n\
							<td class="w-100 bg-editable"><input name="qty[]" required type="text" class="form-control input-xs text-right input-table autonum_qty" data-v-min="0" onkeyup="calculate()" value=""></td>\n\
							<td class="w-130"><input name="total[]" type="text" class="form-control input-xs text-right input-table" readonly="readonly" value=""></td>\n\
						</tr>'
					);
					f_id_pre = getText(document.getElementById('tbl_product').rows[i].cells[7]);
				}
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
        
        $('#tblsales_contract tr').each(function() {
            var qty = remove_thousand_separator($(this).find("input[name='qty[]']").val());
            var unit_price = remove_thousand_separator($(this).find("input[name='unit_price[]']").val());
            var total_row = qty * unit_price;
            $(this).find("input[name='total[]']").val(number_format(total_row, 2));
            
            if(int > 0){
                total += total_row;
            }
            int +=1;
        });
          
        document.getElementById('total_before_disc').value=number_format(total, 2);
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
</script>