<style type="text/css">		
	.sembunyi{
		display: none;
	}
/*	.modal-backdrop {
		z-index: 0;
	}
	.modal-scrollable{
		z-index: 0;
	}*/
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
								<span class="caption-subject theme-font uppercase">Purchase Order</span>
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
								<div class="col-md-6">
									
									<?php echo form_hidden('po_hdr_id', $po_hdr_id)?>
									
									<div class="form-group required">
										<label class="col-md-4 control-label" for="varchar">Factory of Production</label>
										<div class="col-md-5">
											<?php 
												$extra_factory = 'class="form-control select2me"';
												$option_factory[''] = '';
												foreach($cbo_factory as $r):
													$option_factory[$r->factory_id] = $r->factory_name;													
												endforeach;
												echo form_dropdown('factory_id', $option_factory, $factory_id, $extra_factory);
											?>
										</div>
										<span class="help-inline"><?php echo form_error('factory_id') ?></span>
									</div>
									
									<div class="form-group">
										<label class="col-md-4 control-label" for="varchar">PO Reff</label>
										<div class="col-md-5">
											<input readonly="readonly" type="text" class="form-control" name="po_reff" id="po_reff" value="<?php echo $po_reff; ?>" />											
										</div>
										<span class="help-inline"><?php echo form_error('po_reff') ?></span>
									</div>
									
<!--									<div class="form-group">
										<label class="col-md-4 control-label" for="varchar">CMA PO Reff</label>
										<div class="col-md-5">
											<input type="text" class="form-control" name="cma_po_reff" id="cma_po_reff" value="<?php echo $cma_po_reff; ?>" />											
										</div>
										<span class="help-inline"><?php echo form_error('cma_po_reff') ?></span>
									</div>-->
									
									<div class="form-group required">
										<label class="col-md-4 control-label" for="varchar">PO Number</label>
										<div class="col-md-5">
											<input type="text" class="form-control" name="po_number" id="po_number" value="<?php echo $po_number; ?>" />											
										</div>
										<span class="help-inline"><?php echo form_error('po_number') ?></span>
									</div>
									
									<div class="form-group format-tgl">
										<label class="col-md-4 control-label" for="varchar">PO Date</label>
										<div class="col-md-5">
											<input type="text" class="form-control date date-picker" data-date="<?php echo $current_date?>" data-date-format="mm-dd-yyyy" name="po_date" id="po_date" value="<?php echo $po_date; ?>" />
										</div>
										<span class="help-inline"><?php echo form_error('po_date') ?></span>
									</div>
									
									<div class="form-group">
										<label class="col-md-4 control-label" for="varchar">Status</label>
										<div class="col-md-5">
											<?php
											$extra_status = 'class="form-control select2me"';
											$option_status[''] = '';												
											$option_status['open'] = 'OPEN';
											$option_status['closed'] = 'CLOSED';

											echo form_dropdown('po_status', $option_status, $po_status, $extra_status);
											?>											
										</div>
										<span class="help-inline"><?php echo form_error('po_status') ?></span>

									</div>
									
									<div class="form-group">
										<label class="col-md-4 control-label" for="varchar">Update Status Remark</label>
										<div class="col-md-5">
											<input type="text" class="form-control" name="status_remark" id="status_remark" value="<?php echo $status_remark; ?>" />	
										</div>
										<span class="help-inline"><?php echo form_error('status_remark') ?></span>
									</div>

									<div class="form-group">
										<input type="hidden" id="contract_hdr_id" name="contract_hdr_id" value="<?php echo $contract_hdr_id?>">
										<label class="col-md-4 control-label" for="varchar">Contract Number</label>
										<div class="col-md-5">
											<div class="input-group">
												<input readonly="readonly" type="text" class="form-control" name="contract_number" id="contract_number" value="<?php echo $contract_number; ?>" />											
												<span class="input-group-btn">
													<input type="button" class="btn blue fontawesome-font" value="&#xf002" data-target="#modal_contract" data-toggle="modal">
												</span>
											</div>
										</div>
										<span class="help-inline"><?php echo form_error('contract_number') ?></span>
									</div>
									
									<div class="form-group">
										<label class="col-md-4 control-label" for="varchar">Contract Date</label>
										<div class="col-md-5">
											<input readonly="readonly" type="text" class="form-control" name="contract_date" id="contract_date" value="<?php echo $contract_date; ?>" />
											<!--<input readonly="readonly" type="text" class="form-control date date-picker" data-date="<?php echo $current_date; ?>" data-date-format="mm-dd-yyyy" name="contract_date" id="contract_date" value="<?php echo $contract_date; ?>" />-->
										</div>
										<span class="help-inline"><?php echo form_error('contract_date') ?></span>
									</div>
									
								</div>
								
								<div class="col-md-6 col-md-push-1">
									<div class="form-group">
										<label class="col-md-4 control-label" for="varchar">Marketing</label>
										<div class="col-md-5">
											<?php
											$extra_mark = 'class="form-control select2me"';
											$option_mark[''] = '';				
											foreach($cbo_marketing as $row):
												$option_mark[$row->marketing_id] = $row->marketing_name;											
											endforeach;

											echo form_dropdown('marketing_id', $option_mark, $marketing_id, $extra_mark);
											?>
											<span class="help-inline"><?php echo form_error('marketing_id') ?></span>
										</div>										
									</div>
									
									<div class="form-group">
										<label class="col-md-4 control-label" for="varchar">Buyer</label>
										<div class="col-md-5">
											<input readonly="readonly" type="text" class="form-control" name="buyer" id="buyer" value="<?php echo $buyer; ?>" />											
										</div>
										<span class="help-inline"><?php echo form_error('buyer') ?></span>
									</div>
									
									<div class="form-group">
										<label class="col-md-4 control-label" for="varchar">Ocean Freight Cost</label>
										<div class="col-md-5">
											<input type="text" class="form-control" name="freight_cost" id="freight_cost" value="<?php echo $freight_cost; ?>" />											
										</div>
										<span class="help-inline"><?php echo form_error('freight_cost') ?></span>
									</div>
									
									<div class="form-group format-tgl">
										<label class="col-md-4 control-label" for="varchar">PO Ship Date</label>
										<div class="col-md-5">
											<input type="text" class="form-control date date-picker" data-date="<?php echo $current_date; ?>" data-date-format="mm-dd-yyyy" name="po_ship_date" id="po_ship_date" value="<?php echo $po_ship_date; ?>" />
										</div>
										<span class="help-inline"><?php echo form_error('po_ship_date') ?></span>
									</div>
									
									<div class="form-group format-tgl">
										<label class="col-md-4 control-label" for="varchar">Shipment Date</label>
										<div class="col-md-5">
											<input type="text" class="form-control date date-picker" data-date="<?php echo $current_date; ?>" data-date-format="mm-dd-yyyy" name="shipment_date" id="shipment_date" value="<?php echo $shipment_date; ?>" />
										</div>
										<span class="help-inline"><?php echo form_error('shipment_date') ?></span>
									</div>
									
									<div class="form-group">
										<label class="col-md-4 control-label" for="varchar">Port of Discharge</label>
										<div class="col-md-5">
											<input type="text" readonly="readonly" class="form-control" name="port_name" id="port_name" value="<?php echo $port_name; ?>" />
											<?php
//												$extra_port = 'class="form-control select2me" data-placeholder = "Select Port..."';
//												$option_port[''] = '';				
//												foreach($record_port as $row):
//													$option_port[$row->port_id] = $row->port_name;											
//												endforeach;
//
//												echo form_dropdown('port_name', $option_port, $port_name, $extra_port);
											?>											
										</div>
										<span class="help-inline"><?php echo form_error('port_name') ?></span>
									</div>
									
									<div class="form-group">
										<label class="col-md-4 control-label" for="varchar">Final Destination</label>
										<div class="col-md-5">
											<input type="text" readonly="readonly" class="form-control" name="final_destination" id="final_destination" value="<?php echo $final_destination; ?>" />											
										</div>
										<span class="help-inline"><?php echo form_error('final_destination') ?></span>
									</div>
									
									<div class="form-group">
										<label class="col-md-4 control-label" for="varchar">Currency</label>
										<div class="col-md-5">
											<input type="text" readonly="readonly" class="form-control" name="local_currency" id="local_currency" value="<?php echo $local_currency; ?>" />
											<?php 
//												$extra_currency = 'class="form-control select2me" data-placeholder="Local Currency"';
//												$option_currency[''] = '';
////												
//												$option_currency['USD'] = 'USD';
//												$option_currency['SGD'] = 'SGD';
//												$option_currency['IDR'] = 'IDR';
////												
//												echo form_dropdown('local_currency', $option_currency, '', $extra_currency);
											?>											
										</div>
										<span class="help-inline"><?php echo form_error('local_currency') ?></span>
									</div>
									
									<div class="form-group">
										<label class="col-md-4 control-label" for="varchar">Amount</label>
										<div class="col-md-5">
											<input type="text" class="form-control" name="amount" id="amount" value="<?php echo $amount; ?>" onkeypress="return isNumber(event)"/>											
										</div>
										<span class="help-inline"><?php echo form_error('amount') ?></span>
									</div>
									
								</div>
							</div>
							
							<hr/>
							
<!--							<div class="table-toolbar">
								<div class="row">
									<div class="col-md-6">
										<div class="btn-group">
											<a id="sample_editable_1_new" class="btn green">
											Add New Detail <i class="fa fa-plus"></i>
											</a>
										</div>
									</div>
								</div>
							</div>-->
							<div class="table-toolbar">
								<div class="row">
									<div class="col-md-6">
										<div class="btn-group">
											<a id="btn_add_product" class="btn btn-primary btn-large" href="#modal_product" data-toggle="modal">
												<i class="fa fa-plus"></i>
												Add Product ...
											</a>
										</div>
									</div>
								</div>										
							</div>

							<div class="table-responsive">
								<div id="product_detail">
									<table class="table table-bordered table-condensed table-detail" id="tbl_po">
										<thead>
											<tr>
												<th scope="col" style="width:50px !important">#</th>
												<th scope="col" class="w-300">Product Description</th>
												<th scope="col" class="w-150">Product Code</th>
												<th scope="col" class="w-180">Brand</th>
												<th scope="col" class="w-60">UOM</th>
												<th scope="col" class="w-60">Palletized</th>
												<th scope="col" class="w-60">Container Size</th>											
												<th scope="col" class="w-60">Cartons PM Code</th>
												<th scope="col" class="w-60">Stickers PM Code</th>
												<th scope="col" class="w-60">Label Quantity</th>
												<th scope="col" class="w-60">FOB Price</th>
												<th scope="col" class="w-60">Price</th>
												<th scope="col" class="w-60">Quantity</th>
												<th scope="col" class="w-130">Total</th>
											</tr>
										</thead>
										<tbody>
											<?php
											if ($detail){
												foreach ($detail as $d){
													$sub_total = $d->price * $d->quantity;
													
													echo "<tr>";
													//Kolom Tombol
													echo "<td class='text-center w-50'>";
													echo "<input type='button' class='btn default btn-sm red-stripe' onclick='removeRow(this)' value='Remove'>";
													echo "<input type='hidden' name='product_id[]' value='$d->product_id'>";
													echo "<input type='hidden' name='contract_dtl_id[]' value='$d->po_dtl_id'>";
													echo "</td>";													
													
													//Kolom Product Description
													echo "<td class='w-300'>";
													echo "<input name='product_name[]' value='$d->product_name' class='form-control input-sm input-table' placeholder='Product Name' readonly='readonly' title='$d->product_name'>";
													echo "</td>";
													//Kolom Product Code
													echo "<td class='w-150'>";
													echo "<input name='product_code[]' value='$d->product_code' class='form-control input-sm input-table' placeholder='Product Code' readonly='readonly' title='$d->product_code'>";
													echo "</td>";
													//Kolom Brand Name
													echo "<td class='w-180'>";
													echo "<input name='brand[]' value='$d->brand_name' class='form-control input-sm input-table' readonly='readonly'>";
													echo "</td>";
													//Kolom UOM
													echo "<td class='w-60'>";
													echo "<input name='uom[]' value='$d->uom_quantity_name' class='form-control input-sm input-table' readonly='readonly'>";
													echo "</td>";
													//Kolom Palletized
													echo "<td class='w-60'>";
													$extra_yn = 'class="form-control input-sm input-table" data-placeholder="Y / N"';
													$option_yn[''] = '';	
													$option_yn['Y'] = 'YES';
													$option_yn['N'] = 'NO';	
													echo form_dropdown('palletized[]', $option_yn, $d->palletized, $extra_yn);
													echo "</td>";
													//Kolom Container Size
													echo "<td class='w-60'>";
													$extra_container = 'id="container_id" class="form-control input-sm input-table container-size" data-placeholder="Container Size"';
													$option_container[''] = '';
													foreach($cbo_container as $r):
														$option_container[$r->container_id] = $r->container_name;
													endforeach;
													echo form_dropdown('container_id[]', $option_container, $d->container_id, $extra_container);
													echo "</td>";
													//Kolom Cartons PM Code
													echo "<td class='w-60'>";
													echo "<input value='$d->cartons_pm_code' name='cartons_pm_code[]' type='text' class='form-control input-sm text-right input-table'>";
													echo "</td>";
													//Kolom Stickers PM Code
													echo "<td class='w-60'>";
													echo "<input value='$d->stickers_pm_code' name='stickers_pm_code[]' type='text' class='form-control input-sm text-right input-table'>";
													echo "</td>";
													//Kolom Label Quantity
													echo "<td class='w-60'>";
													echo "<input value='$d->label_quantity' name='label_qty[]' type='text' class='form-control input-sm text-right input-table'>";
													echo "</td>";
													//Kolom FOB Price
													echo "<td class='w-60'>";
													echo "<input value='$d->fob_price' name='fob_price[]' type='text' class='form-control input-sm text-right input-table' onkeypress='return isNumber(event)' onkeyup='calculate()'>";
													echo "</td>";
													//Kolom Price
													echo "<td class='w-60'>";
													echo "<input value='$d->price' name='unit_price[]' type='text' class='form-control input-sm text-right input-table' onkeypress='return isNumber(event)' onkeyup='calculate()'>";
													echo "</td>";
													//Kolom Quantity
													echo "<td class='w-60'>";
													echo "<input value='$d->quantity' name='qty[]' type='text' class='form-control input-sm text-right input-table' onkeypress='return isNumber(event)' onkeyup='calculate()'>";
													echo "</td>";
													//Kolom Total
													echo "<td class='w-60'>";
													echo "<input name='total[]' value='$sub_total' type='text' class='form-control input-sm text-right input-table' readonly='readonly'>";
													echo "</td>";
													echo "</tr>";
												}
											}
											?>
										</tbody>
									</table>
								</div>
							</div>
							
							
							<div class="form-body row">
								<div class="col-md-6">
									<div class="form-group">
										<label class="col-md-2 control-label" for="varchar">Remarks</label>
										<div class="col-md-10">
											<textarea rows="5" class="form-control autosizeme" name="remark" id="remark" value="<?php echo $remark; ?>" ></textarea>
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
											<div class="input-group input-icon input-icon-sm right">
												<i class="fa fa-percent"></i>
												<input type="text" class="form-control text-right" name="discount" id="discount" placeholder="0" value="<?php echo $discount; ?>" onkeyup="re_calculate()"/>
											</div>
										</div>
										<div class="col-md-4" style="padding-left: 2px">
											<input type="text" class="form-control text-right" name="total_disc" id="total_disc" value="<?php echo $total_disc; ?>" readonly="readonly"/>
										</div>
										<span class="help-inline"><?php echo form_error('total_disc') ?></span>
									</div>

									<div class="form-group">
										<label class="col-md-4 control-label" for="varchar">Freight</label>
										<div class="col-md-4" style="padding-left: 2px">
											<input type="text" class="form-control text-right" name="freight" id="freight" value="<?php echo $freight; ?>" onkeyup="re_calculate()"/>
										</div>
										<span class="help-inline"><?php echo form_error('freight') ?></span>
									</div>

									<div class="form-group">
										<label class="col-md-4 control-label" for="varchar">Tax</label>
										<div class="col-md-4" style="padding-left: 2px">
											<input type="text" class="form-control text-right" name="tax" id="tax" value="<?php echo $tax; ?>" onkeyup="re_calculate()"/>
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
								
								<!--
								<div class="col-md-6">
									<div class="form-group">
										<label class="col-md-4 control-label" for="varchar">Marking Instruction Remarks</label>
										<div class="col-md-8">
											<textarea class="form-control autosizeme" name="marking_remark" id="marking_remark" value="<?php echo $marking_remark; ?>" ></textarea>
										</div>
										<span class="help-inline"><?php echo form_error('marking_remark') ?></span>
									</div>
								</div>
								
								<div class="col-md-6">
									<div class="form-group">
										<label class="col-md-4 control-label" for="varchar">Carton Marking Instruction Remarks</label>
										<div class="col-md-8">
											<textarea class="form-control autosizeme" name="carton_marking_remark" id="carton_marking_remark" value="<?php echo $carton_marking_remark; ?>" ></textarea>
										</div>
										<span class="help-inline"><?php echo form_error('carton_marking_remark') ?></span>
									</div>
								</div>
								-->
							</div>

							
						</div><!-- end portlet-body -->
						<hr/>
						<div class="form-actions">
							<div class="row">
								<div class="col-md-12">
									<input type="button" class="btn btn-default fontawesome-font" value="&#xf002 Find ..." data-target="#modal_find" data-toggle="modal">
									<?php echo $btn_print ?>
									<?php echo $btn_delete ?>
									<a href="<?php echo site_url('marketing_transaction/purchase_order')?>" type="button" class="btn red pull-right"><i class="fa fa-close"></i> Cancel</a>
									<button type="submit" class="btn green pull-right"><i class="fa fa-save"></i> <?php echo $submit_caption?></button>									
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
	<div id="modal_product" class="modal fade bs-modal-lg" role="dialog" tabindex="-1" data-backdrop="static" data-keyboard="false"  aria-hidden="true">
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
										<th class="w-50">#</th>
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

<div id="add_contract">
	<div id="modal_contract" class="modal fade bs-modal-lg" role="dialog" tabindex="-1" data-backdrop="static" data-keyboard="false" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
					<div class="row">
						<div class="col-md-5">
							<div class="input-group">					
								<input id="input_search_contract" name="input_search_contract" class="form-control" type="text" placeholder="Search Sales Contract" >
								<span class="input-group-btn">
									<button type="button" id="search_contract" class="btn blue" style="border-width: 1px;">
										<i class="icon-magnifier"></i>
									</button>
								</span>
							</div>
						</div>
					</div>
				</div>

				<div class="modal-body padding-5">
					<div id="table_contract">
						<div class="v-scroll">
							<table id="tbl_contract" class="table table-condensed table-hover table-fixed">
								<thead>
									<tr>
										<th class="w-50">#</th>
										<th class="w-100">Contract No</th>
										<th class="w-100">Contract Date</th>
										<th>Customer</th>								
									</tr>
								</thead>
								<tbody>

								</tbody>
							</table>
						</div>
					</div>
				</div>

				<div class="modal-footer">
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
						<div class="v-scroll">
							<table id="tbl_find" class="table table-condensed table-hover table-fixed">
								<thead>
									<tr>
										<th class="w-70">#</th>
										<th class="w-100">PO No</th>
										<th class="w-100">PO Date</th>
										<th class="w-200">Factory</th>
										<th>Buyer</th>										
									</tr>
								</thead>
								<tbody>

								</tbody>
							</table>
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
	
	$('#search_product').click(function(){
		var search = {search:$("#input_search").val()};
		$.ajax({
			type: "POST",
			url : "<?php echo site_url('marketing_misc/search_product/po')?>",
			data: search,
			success: function(msg){
				$('#table_container').html(msg);
			}
		});		
	});
	
	$('#search_contract').click(function(){
		var search = {search:$("#input_search_contract").val()};
		$.ajax({
			type: "POST",
			url : "<?php echo site_url('marketing_misc/search_contract/purchase_order')?>",
			data: search,
			success: function(msg){
				$('#table_contract').html(msg);
			}
		});		
	});	
	
	$('#search_find').click(function(){
		var find = {find:$("#input_find").val()};
		$.ajax({
			type: "POST",
			url : "<?php echo site_url('marketing_misc/find/po')?>",
			data: find,
			success: function(msg){
				$('#table_find').html(msg);
			}
		});
	});
	
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
		
		$.ajax({
			type: "POST",
			url : "<?php echo site_url('marketing_misc/list_container')?>",
			success : function(msg){
				$('.container-size').html(msg);				
			},
			dataType: 'html'
		});
		
		$.ajax({
			type: "POST",
			url : "<?php echo site_url('marketing_misc/list_yes_no/palletized')?>",
			success : function(msg){
				$('.palletized').html(msg);				
			},
			dataType: 'html'
		});
		
		i = 1;
		for(r=0;r < chk_length ;r++){
			if (chk_arr[r].checked == true){
				$('#tbl_po > tbody:last-child').append(
					'<tr>\n\
						<td class="text-center w-50">\n\
							<input type="button" class="btn default btn-sm red-stripe" onclick="removeRow(this)" value="Remove">\n\
							<input type="hidden" name="product_id[]" value="'+getText(document.getElementById('tbl_product').rows[i].cells[1])+'">\n\
						</td> \n\
						<td class=""><input name="product_name[]" class="form-control input-sm input-table" placeholder="Product Name" readonly="readonly" value="'+getText(document.getElementById('tbl_product').rows[i].cells[2])+'" title="'+getText(document.getElementById('tbl_product').rows[i].cells[2])+'"></td>\n\
						<td class="w-150"><input name="product_code[]" class="form-control input-sm input-table" placeholder="Product Code" readonly="readonly" value="'+getText(document.getElementById('tbl_product').rows[i].cells[3])+'" title="'+getText(document.getElementById('tbl_product').rows[i].cells[3])+'"></td>\n\
						<td class="w-180"><input value="'+getText(document.getElementById('tbl_product').rows[i].cells[5])+'" name="brand[]" class="form-control input-sm input-table" readonly="readonly"></td>\n\
						<td class="w-60"><input value="'+getText(document.getElementById('tbl_product').rows[i].cells[4])+'" name="uom[]" class="form-control input-sm input-table" readonly="readonly"></td>\n\
						<td class="w-60"><div class="palletized"></div></td>\n\
						<td class="w-150"><div class="container-size"></div></td>\n\
						<td class="w-60"><input name="cartons_pm_code[]" type="text" class="form-control input-sm text-right input-table"></td>\n\
						<td class="w-60"><input name="stickers_pm_code[]" type="text" class="form-control input-sm text-right input-table"></td>\n\
						<td class="w-60"><input name="label_qty[]" type="text" class="form-control input-sm text-right input-table"></td>\n\
						<td class="w-60"><input name="fob_price[]" type="text" class="form-control input-sm text-right input-table" onkeypress="return isNumber(event)" onkeyup="calculate()"></td>\n\
						<td class="w-100"><input name="unit_price[]" type="text" class="form-control input-sm text-right input-table" onkeypress="return isNumber(event)" onkeyup="calculate()"></td>\n\
						<td class="w-60"><input name="qty[]" type="text" class="form-control input-sm text-right input-table" onkeypress="return isNumber(event)" onkeyup="calculate()"></td>\n\
						<td class="w-130"><input name="total[]" type="text" class="form-control input-sm text-right input-table" readonly="readonly"></td>\n\
					</tr>'
				);
			};
			i++;
		}
		$('#modal_product').modal('hide');
		
		re_calculate;
	}
	
//	$('.container-size').select2({
//		allowClear : true
//	});
	
	function removeRow(btn) {
		var row = btn.parentNode.parentNode;
		row.parentNode.removeChild(row);
	}
	
	function disc(){
        var dis=document.getElementById('discount').value / 100;
        var total = document.getElementById('total_before_disc').value;
        var grantotal=total * dis;
        document.getElementById('total_disc').value=grantotal.toFixed(2);
    }
	
	function calculate(){
        var int=0;
        var total=0;
        
        $('#tbl_po tr').each(function() {
            var qty = $(this).find("input[name='qty[]']").val();
            var unit_price = $(this).find("input[name='unit_price[]']").val();
            var total_row = qty * unit_price;
            $(this).find("input[name='total[]']").val(total_row.toFixed(2));
            
            if(int > 0){
                total += total_row;
            }
            int +=1;
        });
          
        document.getElementById('total_before_disc').value=total.toFixed(2);
        disc();
        
        var total_disc = document.getElementById('total_disc').value;
        var freight = document.getElementById('freight').value;
        var tax = document.getElementById('tax').value;
        var grand_total = total - total_disc - freight - tax;
        document.getElementById('grand_total').value= grand_total.toFixed(2);
    }
	
	function re_calculate(){
		var disc = document.getElementById('discount').value / 100;
        var total = document.getElementById('total_before_disc').value;
        var grand_total = total * disc;
        document.getElementById('total_disc').value = grand_total.toFixed(2);
        
        calculate();
	}
</script>