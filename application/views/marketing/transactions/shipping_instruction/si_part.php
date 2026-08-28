<style type="text/css">		
	.sembunyi{
		display: none;
	}
</style>

<div class="page-content">
	<div class="container-fluid">
		<div class="row ">
			<?php echo $message ?>
			
			<?php echo form_open($action, 'class="form-horizontal"');?>
			
			<div class="col-md-12">
				<div class="portlet light">
					
					<div class="portlet-title">
						<div class="caption">
							<i class="fa fa-table theme-font"></i>
							<span class="caption-subject theme-font uppercase">Shipping Instruction </span>
							<span class="caption-subject label label-success"><strong>PO#<?php echo $po_number?></strong></span>
						</div>
						<div class="tools">
							<a href="javascript:;" class="collapse">
							</a>
							<a href="javascript:;" class="reload">
							</a>
							<a href="javascript:;" class="fullscreen"></a>
						</div>
					</div>
					
					<?php 
					
					echo form_hidden('ship_id', $ship_id);
					echo form_hidden('po_hdr_id', $po_hdr_id);
					?>
					
					<div class="portlet-body form">
						
						<div class="form-body row">
							<div class="col-md-6">
								<div class="form-group">
									<label class="col-md-5 control-label" for="varchar" style="font-size: 20px;">										
										<strong>Schedule Shipment Date</strong>										
									</label>
									<div class="col-md-5">
										<input readonly="readonly" type="text" class="form-control date date-picker" style="width:150px;" data-date="<?php echo $schedule_date ?>" data-date-format="dd/mm/yyyy" name="schedule_date" id="schedule_date" value="<?php echo $schedule_date; ?>" title="date format : dd/mm/yyyy" />
									</div>
								</div>								
							</div>
							
							<div class="col-md-6">
								<div class="form-group">
									<label class="col-md-3 control-label" for="varchar">Issue By</label>
									<div class="col-md-7">
										<input readonly="readonly" type="text" class="form-control" name="issue_by" id="issue_by" value="<?php echo $issue_by ?>">
									</div>									
								</div>
							</div>
						</div>
						
						<div class="form-body row">
							<div class="col-md-12">
								<h4 class="form-section">Purchase Order</h4>
							</div>
							
							<div class="col-md-6">
								<div class="form-group row">
									<label class="col-md-2 control-label" for="varchar">PO Number</label>
									<div class="col-md-4">
										<input readonly="readonly" type="text" class="form-control" name="po_number" id="po_number" value="<?php echo $po_number ?>">
									</div>	
									
									<label class="col-md-2 control-label" for="varchar" style="text-align: right">Factoy</label>
									<div class="col-md-4">
										<input readonly="readonly" type="text" class="form-control" name="factory_abbr" id="factory_abbr" value="<?php echo $factory_abbr ?>">
									</div>
								</div>
								
							</div>
							
							<div class="col-md-6">
								<div class="form-group">
									<label class="col-md-2 control-label" for="varchar" style="text-align: right">Via</label>
									<div class="col-md-10">
										<input type="text" class="form-control" name="via" id="via" value="<?php echo $via ?>">
									</div>									
								</div>
							</div>
						</div>
							
						<div class="form-body row">
							<div class="col-md-12">
								<h4 class="form-section">Agent Info</h4>
							</div>
							
							<div class="col-md-12">
								<div class="table-scrollable-borderless">
									<table id="tbl_agent" class="table table-condensed table-bordered table-hover table-detail">
										<thead>
											<tr>
												<th width="50px">#</th>
												<th>Agent Name</th>
												<th width="25%">Agent Reference</th>
												<th width="15%">USD Com (%)</th>
												<th width="15%">USD Com/Unit</th>
												<th width="10%">Invoice</th>
											</tr>
										</thead>
										<tbody>
											<?php
											if ($agent_list){
												$a = 0;
												foreach($agent_list as $ag){
													$a++;
													echo "<tr>";	
													
													echo "<td class='text-center' style='vertical-align: middle;'>$a";
													echo form_hidden('agent_id[]', $ag->agent_id);
													echo "</td>";													
													echo "<td>$ag->agent_name</td>";
													echo "<td>$ag->agent_reference</td>";
													echo "<td class='text-right'>".number_format($ag->com_percent,2)."</td>";
													echo "<td class='text-right'>".number_format($ag->com_unit,2)."</td>";
													
													$checked = ($ag->invoice == 1 ? true : false);
													echo "<td  class='text-center'>";
													echo form_checkbox('agent_invoice[]', '1', $checked, 'onclick="si_mark.get_invoice_price();"');
													echo "</td>";
													
//													$checked = ($ag->invoice == 1 ? 'YES' : 'NO');
//													echo "<td  class='text-center'>$checked</td>";
													
													echo "</tr>";
												}
											}
											?>
										</tbody>
									</table>
								</div>
							</div>
							
							<div class="col-md-12">
								<h4 class="form-section">Product Info</h4>
							</div>
							
							<div class="col-md-12">
								<div class="table-scrollable-borderless">
									<table id="tbl_shp" class="table table-condensed table-bordered table-hover table-detail">
										<thead>
											<tr>
												<th>#</th>
												<th class="sembunyi">Product Name</th>
												<th>Product Description</th>
												<th>Brand</th>
												<th>Packing</th>
												<th>Palletized</th>
												<th>Pallet Qty</th>
												<th>Quantity</th>
												<th>Unit Price</th>
												<th>Invoice Price</th>
											</tr>
										</thead>
										<tbody>
											<?php
											if ($product_dtl){
												$i = 0;
												foreach($product_dtl as $pd){
													$i++;
													echo "<tr id='$pd->po_hdr_id'>";
													
													echo "<td class='text-center' style='width:50px;vertical-align: middle;'><span class='num'>$i</span></td>";
													
													$ship_product_id = $pd->ship_product_id;
													
													echo "<td style='width: 18%;' class='sembunyi'>";
													echo form_hidden('ship_product_id[]',$ship_product_id);
													echo form_hidden('po_hdr_id_prod[]', $pd->po_hdr_id);
													echo form_hidden('po_dtl_id[]',encode_str($pd->po_dtl_id));
													echo form_hidden('product_id[]', encode_str($pd->product_id));
													echo "<input type='text' value='$pd->product_view' title='$pd->product_view' class='form-control input-xs input-table' readonly='readonly' />";
													echo "</td>";
													
													if (isset($pd->product_view)){
														$product_view = $pd->product_view;
													} else {
														$product_view = $pd->product_name;
													}
													
													if (isset($pd->product_name)){
														$product_name = $pd->product_name;
													} else {
														$product_name = $product_view;
													}
													
													if (isset($pd->detail_product_name)){
														$product_name = $pd->detail_product_name;
													} else {
														$product_name = $product_view;
													}
													
													echo "<td class='bg-editable'>";
													echo "<input type='text' name='product_name[]' value='$product_name' title='$pd->product_name' class='form-control input-xs input-table' />";
													echo "</td>";
													
													echo "<td style='width:12%;'>";
													echo "<input type='text' value='$pd->brand_name' title='$pd->brand_name' class='form-control input-xs input-table text-center' readonly='readonly' />";
													echo "</td>";
													
													if ($pd->detail_pack_size){
														$pack_size = $pd->detail_pack_size;
													} else {
														$pack_size = $pd->packing_view;
//														$pack_size = number_format($pd->uom_volume,0,'.',',')." ". $pd->uom_volume_name." per ".$pd->cma_uom_quantity_id;
													}
													
													echo "<td class='bg-editable' style='width: 14%;'>";
													echo "<input name='detail_pack_size[]' value='$pack_size' title='$pack_size' type='text' class='form-control input-xs input-table text-right' />";
													echo "</td>";
													
													if (isset($pd->detail_palletized)){
														$checked = ($pd->detail_palletized == 1 ? true : false);
													} else {
														$checked = false;
													}
													
													echo "<td class='text-center' style='width: 5%; padding-top:5px;'>";
													echo form_checkbox("detail_palletized[$pd->po_dtl_id]", $pd->po_dtl_id, $checked, 'disabled');
													echo "</td>";
													
													$pallet_qty = isset($pd->pallet_qty) ? $pd->pallet_qty : 0;
													
													echo "<td style='width: 9%;'>";
													echo "<input readonly='readonly' type='text' value='".number_format($pallet_qty,0,'.',',')."' name='pallet_qty[]' class='form-control input-xs input-table text-right autonum' data-v-min='0'/>";
													echo "</td>";
													
													echo "<td style='width: 10%;'>";
													echo "<input type='text' value='".number_format($pd->quantity,0,'.',',')." $pd->uom_quantity_name' class='form-control input-xs input-table text-right' readonly='readonly' />";
													echo "</td>";
													
													echo "<td style='width: 10%;'>";
													echo "<input type='text' value='".number_format($pd->price,2,'.',',')." per $pd->cma_uom_quantity_id' class='form-control input-xs input-table text-right' readonly='readonly' />";
													echo "<input type='hidden' value='".number_format($pd->price,3,'.',',')."' name='unit_price[]'>";
													echo "</td>";
													
													$decoded_ship_id = decode_str($ship_id);
																										
													if ($decoded_ship_id > 0){
														$inv_price = $pd->invoice_price;
													} else {
														$inv_price = $pd->price;
													}
													
													echo "<td class='bg-editable' style='width: 10%;'>";
													echo form_hidden('on_add_product[]', 0);
													echo "<input name='invoice_price[]' value='".number_format($inv_price, 2)."' type='text' class='form-control input-xs input-table text-right autonum_inv' data-v-min='0'/>";
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
							<div class="col-md-12">
								<h4 class="form-section" style="margin-bottom: 10px;">
									Remarks
								</h4>
							</div>
							
							<div class="col-md-12">
								<div class="form-group">
									<div class="col-md-12">
										<textarea rows="5" class="form-control autosizeme" name="sipo_remark" id="remark"><?php echo $sipo_remark ?></textarea>
									</div>
								</div>
							</div>
							
						</div>
												
						<div class="form-actions">
							<div class="row">
								<div class="col-md-12">									
									<button type="submit" class="btn green"><i class="fa fa-save"></i> <?php echo $submit_caption?></button>
									<a href="<?php echo site_url('marketing-transaction/shipping-instruction/edit/?id='.encode_str($ship_id))?>" type="button" class="btn red"><i class="fa fa-close"></i> Cancel And Back to SI</a>
									<a href="<?php echo site_url('marketing-transaction/shipping_instruction/print_separate/?sid='.encode_str($ship_id)).'&pid='.encode_str($po_hdr_id)?>" class="btn btn-warning" id="btn_print" target="_blank"><i class="fa fa-print"></i> Print ...</a>
										<?php // echo $btn_print ?>
								</div>
							</div>
						</div>
						
					</div>
					
				</div>
				
				<?php $noteditable = 'readonly="readonly"';?>
				
				<div class="portlet light">
					<div class="portlet-title">
						<div class="caption">
							<i class="fa fa-table theme-font"></i>
							<span class="caption-subject theme-font uppercase">Shipping Instruction - General Information</span>
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
								<h4 class="form-section">Customer & Order Info</h4>
							</div>
							
							<div class="col-md-6">
								<div class="form-group">
									<label class="col-md-4 control-label" for="varchar">No of FCL</label>
									<div class="col-md-7">
										<input type="text" class="form-control" readonly="readonly" name="no_fcl" id="no_fcl" value="<?php echo $no_fcl ?>" />
									</div>
								</div>
																
								<div class="form-group">
									<label class="col-md-4 control-label" for="varchar">Purchase Order</label>
									<div class="col-md-7">
										<?php echo form_hidden('po_hdr_id', $po_hdr_id)?>
										<input type="text" class="form-control" readonly="readonly" name="po_number" id="po_number" value="<?php echo $po_number ?>" />
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-4 control-label" for="varchar">Client</label>
									<div class="col-md-7">
										<input type="text" class="form-control" readonly="readonly" name="customer_company_name" id="customer_company_name" value="<?php echo $customer_company_name ?>" />
									</div>
								</div>
								
								<div class="form-group">
									<label class="col-md-4 control-label padding-right-2" for="varchar">Invoice To Buyer</label>
									<div class="col-md-7">
										<?php 
											$extra_invoicebuyer = 'id="invoice2buyer_id" class="form-control select2me" disabled="disabled"';
											$option_invoicebuyer[''] = '';
											foreach ($cbo_invoicebuyer as $ib) {
												$option_invoicebuyer[$ib->customer_id] = $ib->customer_company_name;
											}
											
											echo form_dropdown('invoice2buyer_id', $option_invoicebuyer, $invoice2buyer_id, $extra_invoicebuyer);
										?>	
									</div>
								</div>
							</div>
							
							<div class="col-md-6">
								
								<div class="form-group">
									
									<label class="col-md-3 control-label" for="varchar">Client Ref No</label>
									<div class="col-md-7">
										<input type="text" <?php echo $noteditable?> class="form-control" name="client_ref_no" id="client_ref_no" value="<?php echo $client_ref_no ?>" />
									</div>
									
								</div>
								<div class="form-group">
									<label class="col-md-3 control-label" for="varchar">Client Contract No</label>
									<div class="col-md-7">
										<input type="text" <?php echo $noteditable?> class="form-control" name="client_contract_no" id="client_contract_no" value="<?php echo $client_contract_no ?>" />
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-3 control-label" for="varchar">Customer Code</label>
									<div class="col-md-7">
										<?php echo form_hidden('customer_id', $customer_id) ?>
										<input type="text" class="form-control" readonly="readonly" name="customer_code" id="customer_code" value="<?php echo $customer_code ?>" />
									</div>
								</div>
																
								<div class="form-group">
									<label class="col-md-3 control-label" for="varchar" style="padding-right: 7px;">Our Sales Contract No</label>
									<div class="col-md-7">
										<?php echo form_hidden('contract_hdr_id', $contract_hdr_id) ?>
										<input type="text" class="form-control" readonly="readonly" name="contract_no" id="contract_no" value="<?php echo $contract_no ?>" />
									</div>
								</div>
								
							</div>								
						</div>
						
						<div class="form-body row">
							<div class="col-md-12">
								<h4 class="form-section">Shipping Info</h4>
							</div>
							
							<div class="col-md-12">
								
								<div class="form-group required">
									<label class="col-md-2 control-label" for="varchar">Payment Term</label>
									<div class="col-md-9">
										<?php 											
											$extra_payterm = 'id="payment_term_id" class="form-control select2me" disabled="disabled" ';
											$option_payterm[''] = '';
											foreach($cbo_payterm as $r):
												$option_payterm[$r->payment_term_id] = $r->payment_term;													
											endforeach;
											echo form_dropdown('payment_term_id', $option_payterm, $payment_term_id, $extra_payterm);
										?>

									</div>
								</div>
								
								<div class="form-group required">
									<label class="col-md-2 control-label" for="varchar">Trading Term</label>
									<div class="col-md-6">
										<?php 
											$extra_tradingterm = 'class="form-control select2me" disabled="disabled"';
											$option_tradingterm[''] = '';
											foreach($cbo_tradingterm as $r):
												$option_tradingterm[$r->trading_term_id] = $r->trading_term_name . ' (' . $r->trading_term_remark .')';
											endforeach;
											echo form_dropdown('trading_term_id', $option_tradingterm, $trading_term_id, $extra_tradingterm);
										?>
									</div>
									
									<div class="col-md-3">
										<?php 
											echo form_hidden('shipment_from', $shipment_from)
										?>
									</div>
								</div>
								
								<div class="form-group">
									<label class="col-md-2 control-label" for="varchar">Ocean Freight Charges</label>
									<div class="col-md-6">
										<input type="text" <?php echo $noteditable?> class="form-control" name="ocean_freight" id="ocean_freight" value="<?php echo $ocean_freight ?>" />
									</div>
									
									<label class="col-md-1 control-label" for="varchar">LC Number</label>
									<div class="col-md-2">
										<input type="text" <?php echo $noteditable?> class="form-control" name="lc_number" id="lc_number" value="<?php echo $lc_number ?>" />
									</div>

								</div>
								
								<div class="form-group">
									<label class="col-md-2 control-label" for="varchar">Shipping Liner</label>
									<div class="col-md-9">
										<?php 
											$extra_shipping_line = 'id="shipping_id" class="form-control select2me" disabled="disabled"';
											$option_shipping_line[''] = '';
											foreach($cbo_shipping_line as $r):
												$option_shipping_line[$r->shipping_id] = $r->shipping_name;
											endforeach;
											echo form_dropdown('shipping_id', $option_shipping_line, $shipping_id, $extra_shipping_line);
										?>
										<!--<input type="text" class="form-control" name="shipping_liner" id="shipping_liner" value="<?php // echo $shipping_liner ?>" />-->
									</div>
								</div>
								
								<div class="form-group">
									<label class="col-md-2 control-label" for="varchar">Service Number</label>
									<div class="col-md-9">
										<input type="text" <?php echo $noteditable?> class="form-control" name="service_number" id="service_number" value="<?php echo $service_number ?>" />
									</div>
								</div>
								
								<div class="form-group">
									<label class="col-md-2 control-label" for="varchar">Final Destination</label>
									<div class="col-md-9">
										<?php 
											$extra_destination = 'id="destination_id" class="form-control select2me" disabled="disabled"';
											$option_destination[''] = '';
											foreach($cbo_destination as $r):
												if (strtolower($r->country_name) == 'unknown'){
													$option_destination[$r->port_id] = $r->port_name;
												} else {
													$option_destination[$r->port_id] = $r->port_name.', '.$r->country_name;
												}
											endforeach;
											echo form_dropdown('destination_id', $option_destination, $destination_id, $extra_destination);
										?>
									</div>
								</div>
								
								<input type="hidden" class="form-control" name="shipping_date" id="shipping_date" value="<?php echo $shipping_date ?>" />
								
								<div class="form-group">
									<label class="col-md-2 control-label padding-right-2" for="varchar">
										Consignee									
									</label>
									<div class="col-md-9">
										<textarea rows="5" <?php echo $noteditable?> class="form-control autosizeme" name="consignee" id="consignee"><?php echo $consignee ?></textarea>										
									</div>
								</div>
								
							</div>							
						</div>
						
						<div class="form-body row">
							<div class="col-md-12">
								<h4 class="form-section" style="margin-bottom: 10px;">
									Notify Party  									
								</h4>
							</div>
							
							<div class="col-md-12">
								<div class="form-group">
									<label class="col-md-1 col-sm-1 control-label" for="varchar">1st </label>
									<div class="col-md-5 col-sm-5">
										<textarea <?php echo $noteditable?> rows="3" class="form-control autosizeme" name="notify_party1" id="notify_party1"><?php echo $notify_party1 ?></textarea>
									</div>
									
									<label class="col-md-1 col-sm-1 control-label" for="varchar">2nd </label>
									<div class="col-md-5 col-sm-5">
										<textarea rows="3" <?php echo $noteditable?> class="form-control autosizeme" name="notify_party2" id="notify_party2"><?php echo $notify_party2 ?></textarea>										
									</div>
								</div>								
							</div>							
						</div>
						
						<div class="form-body row">
							
							<div class="col-md-6 col-sm-6">
								<h4 class="form-section" style="margin-bottom: 10px;">
									Document Required
								</h4>

								<div class="doc-scroll" style="height: 200px;">
									<table id="list-document" class="doc-table table-striped table-hover">
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
													echo "<td width='30px'>";
													echo form_checkbox('doc[]', $doc->document_id, $checked, 'disabled');
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
							
							<div class="col-md-6 col-sm-6">
								<h4 class="form-section" style="margin-bottom: 10px;">
									Special Document
								</h4>
							
								<div class="doc-scroll" style="height: 200px;">
									<table id="list-document-special" class="doc-table table-striped table-hover">
										<tbody>
											<?php														
											if ($list_special_doc){
												$i = 0;
												foreach($list_special_doc as $spec_doc){
													$checked = false;
													if ($selected_special_doc){
														foreach ($selected_special_doc as $ssd){
															if ($ssd->document_id == $spec_doc->document_id){
																$checked = true;
															}
														}
													}

													$i++;
													echo "<tr>";
													echo "<td width='30px'>";
													echo form_checkbox('special_doc[]', $spec_doc->document_id, $checked, 'disabled');
													echo "</td>";
													echo "<td>$spec_doc->document_name</td>";
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
							<div class="col-md-12">
								<h4 class="form-section" style="margin-bottom: 10px;">
									Remarks
								</h4>
							</div>
							
							<div class="col-md-12">
								<div class="form-group">
									<div class="col-md-12">
										<textarea rows="5" <?php echo $noteditable?> class="form-control autosizeme" name="remark" id="remark"><?php echo $remark ?></textarea>
									</div>
								</div>
							</div>
							
						</div>
						
						
					</div>					
				</div>
				
			</div>
		
			<?php echo form_close() ?>
			
		</div>
	</div>
</div>

<script src="<?php echo base_url();?>assets/marketing/si_mark.js"></script>
<script>
	jQuery(document).ready(function() { 
		si_mark.init();
	});		
	
</script>