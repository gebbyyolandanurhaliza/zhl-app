<style type="text/css">		
	.sembunyi{
		display: none;
	}	
</style>

<div class="page-content">
	<div class="container-fluid">
		<div class="row ">
			
			<?php echo (isset($status_msg)) ? $status_msg : ''; ?>
			<?php echo $message ?>
			
			<div class="col-md-12">
				<div class="portlet light">
					
					<div class="portlet-title">
						<div class="caption">
							<!--<i class="fa fa-table theme-font"></i>-->
							<span class="caption-subject label label-primary">#<?php echo decode_str($ship_id)?></span>
							<span class="caption-subject theme-font uppercase">Shipping Instruction</span>							
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
					echo form_open($action, 'class="form-horizontal"');
					echo form_hidden('ship_id', $ship_id);
					?>
					
					<input type="hidden" id="act" name="act" value="<?php echo $act?>">
					<input type="hidden" id="on_create" name="on_create" value="<?php echo $on_create?>">
					
					<div class="portlet-body form">
						
						<div class="form-body row">
							<div class="col-md-6">
								<div class="form-group">
									<label class="col-md-5 control-label" for="varchar" style="font-size: 20px;">										
										<strong>Schedule Shipment Date</strong>										
									</label>
									<div class="col-md-5">
										<input required type="text" class="form-control date date-picker" style="width:150px;" data-date="<?php echo $schedule_date ?>" data-date-format="dd/mm/yyyy" name="schedule_date" id="schedule_date" value="<?php echo $schedule_date; ?>" title="date format : dd/mm/yyyy" />
									</div>
								</div>								
							</div>
							
							<div class="col-md-6">
								<div class="form-group">
									<label class="col-md-3 control-label" for="varchar">Issue By</label>
									<div class="col-md-7">
										<input type="text" class="form-control" name="issue_by" id="issue_by" value="<?php echo $issue_by ?>">
									</div>									
								</div>
							</div>
						</div>
						
						<div class="form-body row">
							<div class="col-md-12">
								<h4 class="form-section">Purchase Order</h4>
							</div>
							
							<div class="col-md-12">
								<div class="table-scrollable-borderless">
									<table id="tbl_po" class="table table-condensed table-bordered table-hover table-detail">
										<thead>
											<tr>
												<th style="width: 70px; text-align: center;">
													<a href="#modal-select-po" id="mix_po" data-toggle="modal" class="btn btn-xs btn-primary <?php echo $disabled_btn?>" title="Add More PO">
														<i class="fa fa-plus-square"></i> Mix PO
													</a>													
												</th>
												<th colspan="2">PO Number</th>
												<th>Factory</th>
												<th>Via</th>
											</tr>
										</thead>
										<tbody>
											<?php
											if ($po_det){
												foreach ($po_det as $r) {
											?>
												<tr>
													<td class="text-center bg-editable">									
														<div class="input-group input-table-group">
															<input disabled="disabled" type="button" class="btn default btn-xs red-stripe" sid="<?php echo $r->po_hdr_id?>"  style="width: 70px; margin-left: 5px; margin-top: 2px;" onclick="removePO(this)" value="Remove">
														</div>
													</td>
													<td>														
														<input type="hidden" name="sipo_id[]" id="sipo_id" value="<?php echo $r->sipo_id ?>">
														<input type="hidden" name="detail_po_hdr_id[]" id="detail_po_hdr_id" value="<?php echo $r->po_hdr_id ?>">
														<input type="text" value="<?php echo $r->po_number ?>" class="form-control input-xs input-table" readonly="readonly" />
													</td>
													<td class="center" style="width: 144px">
														<div class="btn-group btn-group-xs btn-group-solid" style="margin-left: 2px; margin-top: 2px;">
															<!--<a class="btn btn-xs red-haze" target="_blank" href="<?php // echo site_url('marketing-transaction/shipping_instruction/print_separate/?pid='.encode_str($r->po_hdr_id)).'&sid='.encode_str($r->ship_id) ?>">PDF</a>-->
															<a class="btn btn-xs purple-studio" target="_blank" href="<?php echo site_url('marketing_transaction/purchase_order/edit/?id='.encode_str($r->po_hdr_id)) ?>">
																<i class="fa fa-share-square-o"></i> PO
															</a>
															<a class="btn btn-xs green <?php echo $disabled_btn?>" target="_blank" href="<?php echo site_url('marketing_transaction/shipping_instruction/si_part/?sid='.encode_str($r->ship_id).'&pid='.encode_str($r->po_hdr_id)) ?>">
																<i class="fa fa-share"></i> SI
															</a>
															<a class="btn btn-xs red" target="_blank" href="<?php echo site_url('marketing-transaction/shipping_instruction/print_separate/?sid='.encode_str($r->ship_id)).'&pid='.encode_str($r->po_hdr_id) ?>">
																<i class="fa fa-file-pdf-o"></i> PDF
															</a>
														</div>
													</td>
													<td class="w-100">
														<input type="text" value="<?php echo $r->factory_abbr ?>" class="form-control input-xs input-table text-center" readonly="readonly" />
													</td>
													<td class="bg-editable">
														<input type="text" name="detail_po_via[]" value="<?php echo $r->via ?>" class="form-control input-xs input-table"/>
													</td>
												</tr>
											<?php
												}
											} else {
											?>
											
												<tr>
													<td class="text-center bg-editable">		
														<div class="input-group input-table-group">
															<input disabled="disabled" type="button" class="btn default btn-xs red-stripe" sid="<?php echo decode_str($po_hdr_id)?>" style="width: 70px; margin-left: 5px; margin-top: 2px;" onclick="removePO(this)" value="Remove">
														</div>
													</td>
													<td>
														<?php // echo form_hidden('detail_po_hdr_id[]', decode_str($po_hdr_id))?>
														<input type="hidden" name="sipo_id[]" id="sipo_id" value="0">
														<input type="hidden" name="detail_po_hdr_id[]" id="detail_po_hdr_id" value="<?php echo decode_str($po_hdr_id)?>">
														<input type="text" value="<?php echo $po_number ?>" class="form-control input-xs input-table" readonly="readonly" />
													</td>
													<td class="center" style="width: 144px">
														<div class="btn-group btn-group-xs btn-group-solid" style="margin-left: 2px; margin-top: 2px;">
															<a class="btn btn-xs purple-studio" target="_blank" href="<?php echo site_url('marketing_transaction/purchase_order/edit/?id='.$po_hdr_id) ?>">
																<i class="fa fa-share-square-o"></i> PO
															</a>
															<a class="btn btn-xs green disabled" href="#">
																<i class="fa fa-share"></i> SI
															</a>
															<a class="btn btn-xs red disabled" href="#">
																<i class="fa fa-file-pdf-o"></i> PDF
															</a>
														</div>
													</td>
													<td class="w-100">
														<input type="text" value="<?php echo $factory_abbr ?>" class="form-control input-xs input-table text-center" readonly="readonly" />
													</td>
													<td class="bg-editable">
														<input type="text" name="detail_po_via[]" value="<?php echo $po_via ?>" class="form-control input-xs input-table"/>
													</td>
												</tr>
											<?php 
											}
											?>
										</tbody>
									</table>
								</div>
							</div>
							
						</div>
						
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
									<label class="col-md-4 control-label padding-right-2" for="varchar">
										Invoice To Buyer										
									</label>
									<div class="col-md-7">
										<?php 
											$extra_invoicebuyer = 'id="invoice2buyer_id" class="form-control select2me "';
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
										<input type="text" class="form-control" name="client_ref_no" id="client_ref_no" value="<?php echo $client_ref_no ?>" />
									</div>
									
								</div>
								<div class="form-group">
									<label class="col-md-3 control-label" for="varchar">Client Contract No</label>
									<div class="col-md-7">
										<input type="text" class="form-control" name="client_contract_no" id="client_contract_no" value="<?php echo $client_contract_no ?>" />
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
//													echo form_radio('agent_invoice[]', '1', $checked, 'onclick="si_mark.get_invoice_price();"');
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
						</div>
						
						<div class="form-body row">
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
												<th>PO#</th>
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
													
													if ($act == 'add'){
														$ship_product_id = 0;
													} else {
														$ship_product_id = $pd->ship_product_id;
													}
													
													echo "<td style='width: 15px;' class='sembunyi'>";
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
													
													echo "<td class='bg-editable' style='mn-width: 250px;'>";
													echo "<input type='text' name='product_name[]' value='$product_name' title='$pd->product_name' class='form-control input-xs input-table' />";
													echo "</td>";
													
													echo "<td style='width:120px;'>";
													echo "<input type='text' value='$pd->brand_name' title='$pd->brand_name' class='form-control input-xs input-table text-center' readonly='readonly' />";
													echo "</td>";
													
													echo "<td style='width:130px;'>";
													echo "<input type='text' value='$pd->po_number' title='$pd->po_number' class='form-control input-xs input-table text-center' readonly='readonly'>";													
													echo "</td>";
													
													if ($pd->detail_pack_size){
														$pack_size = $pd->detail_pack_size;
													} else {
														$pack_size = $pd->packing_view;
													}
													
													echo "<td class='bg-editable' style='width: 200px;'>";
													echo "<input name='detail_pack_size[]' value='$pack_size' title='$pack_size' type='text' class='form-control input-xs input-table text-right' />";
													echo "</td>";
													
													if (isset($pd->detail_palletized)){
														$checked = ($pd->detail_palletized == 1 ? true : false);
													} else {
														$checked = false;
													}
													
//													echo "<td class='bg-editable text-center' style='width: 5%; padding-top:5px;'>";
													echo "<td class='text-center' style='width: 80px; padding-top:5px;'>";
													echo form_checkbox("detail_palletized[$pd->po_dtl_id]", $pd->po_dtl_id, $checked, 'disabled');
													echo "</td>";
													
													$pallet_qty = isset($pd->pallet_qty) ? $pd->pallet_qty : 0;
													
//													echo "<td class='bg-editable' style='width: 9%;'>";
													echo "<td style='width: 100px;'>";
													echo "<input readonly='readonly' type='text' value='".number_format($pallet_qty,0,'.',',')."' name='pallet_qty[]' class='form-control input-xs input-table text-right autonum' data-v-min='0'/>";
													echo "</td>";
													
//													echo "<td style='width: 10%;'>";
													echo "<td style='width: 100px;'>";
													echo "<input type='text' value='".number_format($pd->quantity,0,'.',',')." $pd->uom_quantity_name' class='form-control input-xs input-table text-right' readonly='readonly' />";
													echo "</td>";
													
//													echo "<td style='width: 10%;'>";
													echo "<td style='width: 130px;'>";
													echo "<input type='text' value='".number_format($pd->price,2,'.',',')." per $pd->cma_uom_quantity_id' class='form-control input-xs input-table text-right' readonly='readonly' />";
													echo "<input type='hidden' value='".number_format($pd->price,3,'.',',')."' name='unit_price[]'>";
													echo "</td>";
													
													$decoded_ship_id = decode_str($ship_id);
																										
													if ($decoded_ship_id > 0){
														$inv_price = $pd->invoice_price;
													} else {
														$inv_price = $pd->price;
													}
													
//													echo "<td class='bg-editable' style='width: 10%;'>";
													echo "<td class='bg-editable' style='width: 100px;'>";
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
								<h4 class="form-section">Shipping Info</h4>
							</div>
							
							<div class="col-md-12">
								
								<div class="form-group required">
									<label class="col-md-2 control-label" for="varchar">Payment Term</label>
									<div class="col-md-9">
										<?php 											
											$extra_payterm = 'id="payment_term_id" class="form-control select2me" required="required" ';
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
										<?php // echo form_hidden('trading_term_id', $trading_term_id) ?>
										<!--<input type="text" class="form-control" readonly="readonly" name="trading_term" id="trading_term" value="<?php // echo $trading_term ?>" />-->
										<?php 
											$extra_tradingterm = 'required class="form-control select2me"';
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
										<input type="text" class="form-control" name="ocean_freight" id="ocean_freight" value="<?php echo $ocean_freight ?>" />
									</div>
									
									<label class="col-md-1 control-label" for="varchar">LC Number</label>
									<div class="col-md-2">
										<input type="text" class="form-control" name="lc_number" id="lc_number" value="<?php echo $lc_number ?>" />
									</div>

								</div>
								
								<div class="form-group">
									<label class="col-md-2 control-label" for="varchar">Shipping Liner</label>
									<div class="col-md-9">
										<?php 
											$extra_shipping_line = 'id="shipping_id" class="form-control select2me"';
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
										<input type="text" class="form-control" name="service_number" id="service_number" value="<?php echo $service_number ?>" />
									</div>
								</div>
								
								<div class="form-group">
									<label class="col-md-2 control-label" for="varchar">Final Destination</label>
									<div class="col-md-9">
										<?php // echo form_hidden('destination_id', $destination_id) ?>
										<!--<input type="text" class="form-control" readonly="readonly" name="final_destination" id="final_destination" value="<?php // echo $final_destination ?>" />-->
										<?php 
											$extra_destination = 'id="destination_id" class="form-control select2me"';
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
								
<!--								<div class="form-group">
									<label class="col-md-2 control-label" for="varchar">Shipping Date</label>
									<div class="col-md-9">-->
										<input type="hidden" class="form-control" name="shipping_date" id="shipping_date" value="<?php echo $shipping_date ?>" />
<!--									</div>
								</div>-->
								
								<div class="form-group">
									<label class="col-md-2 control-label padding-right-2" for="varchar">
										Consignee
										<a href="#modal_consignee" id="previous_consignee" data-toggle="modal" class="pull-right" title="Previous Consignee">
											<i class="fa fa-commenting"></i>
										</a>
									</label>
									<div class="col-md-9">
										<textarea rows="5" class="form-control autosizeme" name="consignee" id="consignee"><?php echo $consignee ?></textarea>										
									</div>
								</div>
							</div>
							
						</div>
						
						<div class="form-body row">
							<div class="col-md-12">
								<h4 class="form-section" style="margin-bottom: 10px;">
									Notify Party  
									<a href="#modal_notify_party" id="previous_notify_party" data-toggle="modal" title="Previous Notify Party">
										<i class="fa fa-commenting"> </i>      
									</a>
								</h4>
							</div>
							
							<div class="col-md-12">
								<div class="form-group">
									<label class="col-md-1 col-sm-1 control-label" for="varchar">1st </label>
									<div class="col-md-5 col-sm-5">
										<textarea rows="3" class="form-control autosizeme" name="notify_party1" id="notify_party1"><?php echo $notify_party1 ?></textarea>
										<!--<input type="text" class="form-control" name="notify_party1" id="notify_party1" value="<?php // echo $notify_party1 ?>" />-->
									</div>
									
									<label class="col-md-1 col-sm-1 control-label" for="varchar">2nd </label>
									<div class="col-md-5 col-sm-5">
										<textarea rows="3" class="form-control autosizeme" name="notify_party2" id="notify_party2"><?php echo $notify_party2 ?></textarea>										
									</div>
								</div>
								
							</div>
							
						</div>
						
						<div class="form-body row">
							
							<div class="col-md-6 col-sm-6">
								<h4 class="form-section" style="margin-bottom: 10px;">
									Document Required
									<a href="#modal_create" id="create_document" data-toggle="modal" class="pull-right" title="Create New Document">
										<i class="fa fa-plus-square"></i>
									</a>
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
							
							<div class="col-md-6 col-sm-6">
								<h4 class="form-section" style="margin-bottom: 10px;">
									Special Document
									<a href="#modal_create" id="create_document_special" data-toggle="modal" class="pull-right" title="Create New Special Document">
										<i class="fa fa-plus-square"></i>
									</a>
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
													echo form_checkbox('special_doc[]', $spec_doc->document_id, $checked);
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
									<a href="#modal_previous" id="previous_remark" data-toggle="modal" title="Previous Remark">
										<i class="fa fa-commenting"></i>
									</a>
								</h4>
							</div>
							
							<div class="col-md-12">
								<div class="form-group">
									<div class="col-md-12">
										<textarea rows="5" class="form-control autosizeme" name="remark" id="remark"><?php echo $remark ?></textarea>
									</div>
								</div>
							</div>
							
						</div>
						
						<div class="form-actions">
							<div class="row">
								<div class="col-md-12">
									<input type="button" class="btn btn-default fontawesome-font" value="&#xf002 Search SI ..." data-target="#modal_find" data-toggle="modal">
									<?php echo $btn_print ?>
									<?php echo $btn_delete ?>
									<a href="<?php echo site_url('marketing-transaction/shipping-instruction')?>" type="button" class="btn red pull-right"><i class="fa fa-close"></i> Cancel</a>
									<button type="submit" class="btn green pull-right" <?php echo $disabled_btn ?>><i class="fa fa-save"></i> <?php echo $submit_caption?></button>										
								</div>
							</div>
						</div>
						
					</div>
										
					<?php echo form_close() ?>
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
					<div id="table_find">
						<div class="v-scroll h-400">
							
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
								<button type="reset" data-dismiss="modal" class="btn red">Close</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div id="invoice_buyer_container">
	<div id="modal_invoice_buyer" class="modal fade" role="dialog" tabindex="-1" data-toggle="modal" data-keyboard="false" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div id="invoice_buyer" class="invoice_buyer">
					Please Wait...
				</div>
			</div>
		</div>
	</div>
</div>

<div id="consignee_container">
	<div id="modal_consignee" class="modal fade" role="dialog" tabindex="-1" data-toggle="modal" data-keyboard="false" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div id="pre_consignee" class="pre_consignee">
					Please Wait...
				</div>
			</div>
		</div>
	</div>
</div>

<div id="notify_party_container">
	<div id="modal_notify_party" class="modal fade" role="dialog" tabindex="-1" data-toggle="modal" data-keyboard="false" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div id="pre_notify_party" class="pre_notify_party">
					Please Wait...
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

<script>
	
	$('#btn_delete').click(function(){
		var headerid = $(this).attr("header_id");
		bootbox.confirm('Are you sure want to delete shipping instruction data?',function(result){
			if (result){
				$.ajax({
					url:"<?php echo site_url('marketing_transaction/shipping_instruction/delete');?>",
					type:"POST",
					data:"headerid="+headerid,
					cache:false,
					success:function(){		
						console.log(headerid);
						
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
						return location.href = "<?php echo site_url('marketing_transaction/shipping_instruction');?>";
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
						return location.href="<?php echo site_url('marketing_transaction/shipping_instruction');?>";
					}
				});
			} else {
				console.log("Declined delete shipping instruction data.");
			}
		});
	});
	
	$('#search_find').click(function(){
		var find = {find:$("#input_find").val()};
		$.ajax({
			type: "POST",
			url : "<?php echo site_url('marketing_transaction/shipping_instruction/find')?>",
			data: find,
			success: function(msg){
				$('#table_find').html(msg);
			}
		});
	});
	
	$('#previous_remark').on('click',function(){
		var cust_id = <?php echo $customer_id ?>;
		
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
			url	: "<?php echo site_url('marketing_transaction/shipping_instruction/previous_remark')?>",
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
//		$('#remark').append('\n');		
		$('#modal_previous').modal('hide');
	});
	
	function select_remark(ind){
		 function getText(el){
            if (typeof el.textContent == 'string') return el.textContent;
            if (typeof el.innerText == 'string') return el.innerText;
        }

        $r = ind.rowIndex;
        document.getElementById('selected_remark').value = getText(document.getElementById('tbl_previous').rows[$r].cells[1]);
	}
	
// INVOICE TO BUYER MODAL
	$('#invoice_buyer_link').on('click', function(){
		$.ajax({
			type: "POST",
			url	: "<?php echo site_url('marketing_transaction/shipping_instruction/invoice_buyer')?>",
			success : function(msg){
				$('#invoice_buyer').html(msg);
			}
		});
	});
	
	function select_buyer(ind){
		function getText(el){
            if (typeof el.textContent == 'string') return el.textContent;
            if (typeof el.innerText == 'string') return el.innerText;
        }

        $r = ind.rowIndex;
        document.getElementById('invoice2buyer').value = getText(document.getElementById('tbl_buyer').rows[$r].cells[0]);
		document.getElementById('invoice2buyer_id').value = getText(document.getElementById('tbl_buyer').rows[$r].cells[1]);
		
		$('#modal_invoice_buyer').modal('hide');
	}
	
// CONSIGNEE	
	$('#previous_consignee').on('click',function(){
		var cust_id = <?php echo $customer_id ?>;
		
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
			url	: "<?php echo site_url('marketing_transaction/shipping_instruction/previous_consignee')?>",
			data: "customer_id="+cust_id,
			success : function(msg){
				$('#pre_consignee').html(msg);
			}
		});
	});
	
// NOTIFY PARTY	
	$('#previous_notify_party').on('click',function(){
		var cust_id = <?php echo $customer_id ?>;
		
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
			url	: "<?php echo site_url('marketing_transaction/shipping_instruction/previous_notify_party')?>",
			data: "customer_id="+cust_id,
			success : function(msg){
				$('#pre_notify_party').html(msg);
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
	
	$('#create_document_special').on('click',function(){
		$.ajax({
			type: "POST",
			url	: "<?php echo site_url('marketing_misc/modal/document_special')?>",
			success : function(msg){
				$('#form_create').html(msg);
			}
		});
	});
	
</script>

<!-- Select PO -->
<div class="modal fade" id="modal-select-po" tabindex="-1" role="basic" data-backdrop="modal" data-keyboard="false" aria-hidden="true">
    <div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
				<h4>
					<i class="fa fa-pencil-square-o"></i>
					Combine PO
				</h4>
			</div>

			<div id="po_find" class="po_find">
				<div class="modal-body"><div class="spinner text-center"><i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>&nbsp;&nbsp;<span>Loading...</span></div></div>
			</div>

			<div class="modal-footer">
				<div class="form-actions">
					<div class="row">
						<div class="col-md-12">
							<input type="button" id="btn_select_po" class="btn green" value="Select" onclick="select_po()">
							<button type="reset" data-dismiss="modal" class="btn red">Close</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
	$('#mix_po').on('click',function(){
		var cust_id = <?php echo $customer_id ?>;
		var po_id = $("input[name='detail_po_hdr_id[]']").map(function(){ 
                    return this.value; 
                }).get();
		
		$('.po_find').html(loading_anim);
		
		if (cust_id == ''){
			$.bootstrapGrowl('<strong><i class="fa fa-warning"></i> No Customer Available!</strong>', {
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
			url	: "<?php echo site_url('marketing_transaction/shipping_instruction/mix_po')?>",
			data: {
				"customer_id" : cust_id,
				"detail_po_hdr_id[]" : po_id
			},
			success : function(msg){				
				$('#po_find').html(msg);
			}
		});
	});
	
	function updateRowOrder() {
        $('span.num').each(function (i) {
            $(this).text(i + 1);
        });
    }
	
	function select_po()
    {
        function getText(el) {
            if (typeof el.textContent == 'string')
                return el.textContent;
            if (typeof el.innerText == 'string')
                return el.innerText;
        }

        var chk_arr = document.getElementsByName("chk[]");
        var chk_length = chk_arr.length;
		
		i = 1;
		
		for (r = 0; r < chk_length; r++) {
			if (chk_arr[r].checked == true) {
				var sid = getText(document.getElementById('tbl_filter_po').rows[i].cells[1]);
				$('#tbl_po > tbody:last-child').append(
					'<tr>'
					+'<td class="text-center w-70 bg-editable valign-middle">'
						+'<div class="input-group input-table-group">'
						+'<input type="button" class="btn default btn-xs red-stripe" sid='+sid+' style="width: 70px; margin-left: 5px; margin-top: 2px;" onclick="removePO(this)" value="Remove">'
						+'</div>'
					+'</td>'
					+'<td>'
						+'<input type="hidden" name="sipo_id[]" id="sipo_id" value="0">'
						+'<input type="hidden" name="detail_po_hdr_id[]" id="detail_po_hdr_id" value="'+ getText(document.getElementById('tbl_filter_po').rows[i].cells[1]) +'">'
						+'<input type="text" value="'+ getText(document.getElementById('tbl_filter_po').rows[i].cells[2]) +'" class="form-control input-xs input-table" readonly="readonly" />'
					+'</td>'
					+'<td class="center" style="width: 144px">'
						+'<div class="btn-group btn-group-xs btn-group-solid" style="margin-left: 2px; margin-top: 2px;">'
						+'<a class="btn btn-xs purple-studio disabled" href="#">'
							+'<i class="fa fa-share-square-o"></i> PO'
						+'</a>'
						+'<a class="btn btn-xs green disabled" href="#">'
							+'<i class="fa fa-share"></i> SI'
						+'</a>'
						+'<a class="btn btn-xs red disabled" href="#">'
							+'<i class="fa fa-file-pdf-o"></i> PDF'
						+'</a>'
						+'</div>'
					+'</td>'
					+'<td class="w-100">'
						+'<input type="text" value="'+ getText(document.getElementById('tbl_filter_po').rows[i].cells[3]) +'" class="form-control input-xs input-table text-center" readonly="readonly" />'
					+'</td>'
					+'<td class="bg-editable">'
						+'<input type="text" name="detail_po_via[]" value="" class="form-control input-xs input-table"/>'
					+'</td>'
					+'</tr>'
				);
				
				var pohdrid = getText(document.getElementById('tbl_filter_po').rows[i].cells[1]);
				var idx = $('#tbl_shp tr:last').index();
		
				$.ajax({
					type: "POST",
					url : "<?php echo site_url('marketing_transaction/shipping_instruction/load_product')?>",
					data: {'po_hdr_id' : pohdrid, 'no' : idx+1},
					success: function(msg){
						$('#tbl_shp > tbody:last-child').append(msg);
						si_mark.get_invoice_price_on_add();
					}
				});
			}
			i++;
		}
		
		$('#modal-select-po').modal('hide');
	}
	
	function removePO(btn) {
        var row = btn.parentNode.parentNode.parentNode;
		row.parentNode.removeChild(row);
				
		var sid = $(btn).attr('sid');
		
		$('#tbl_shp').closest('table').find('tbody > tr')
			.each(function(){
				var idr = this.id;
				if(idr == sid){
					$(this).fadeOut(400, function(){
						$(this).remove();
					});		
				}			
			});			
    }
	
</script>

<script src="<?php echo base_url();?>assets/marketing/si_mark.js"></script>
<script>
	jQuery(document).ready(function() { 
		si_mark.init();
	});		
	
	function load_invoice_price()
	{
		var on_create = $('#on_create').val();
		
		if (on_create == 1){
			si_mark.get_invoice_price();
			$('#on_create').val('0');
		}
	}
	
	window.onload = load_invoice_price();
</script>