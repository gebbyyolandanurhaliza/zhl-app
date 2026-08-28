<link href="<?php echo base_url(); ?>assets/admin/scripts/jquery.autocomplete.css" rel="stylesheet" type="text/css"/>
<script src="<?php echo base_url(); ?>assets/admin/scripts/jquery.autocomplete.js" type="text/javascript"></script>

<style type="text/css">		
	.sembunyi{
		display: none;
	}
</style>

<!-- Page Content -->
<div class="page-content">
	<div class="container-fluid">
		<div class="row">
			
			<?php 
			echo $message;
			echo "<div class='col-md-12'>$po_processed_msg</div>";
			?>
			
			<form action="<?php echo $action; ?>" method="post" class="form-horizontal" onsubmit="return POValidate(this);">
				
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
								<div class="col-md-12">
									
									<div class="panel panel-default">
										<div class="panel-heading">
											<h5 class="panel-title"><i class='fa fa-archive'></i> Sales Contract Information</h5>
										</div>
																														
										<input type="hidden" id="act" name="act" value="<?php echo $act ?>">
										<input type="hidden" id="po_hdr_id" name="po_hdr_id" value="<?php echo $po_hdr_id ?>">
										<input type="hidden" id="status_id" name="status_id" value="<?php echo $status_id ?>">
										<input type="hidden" id="contract_hdr_id" name="contract_hdr_id" value="<?php echo $contract_hdr_id ?>">
										<input type="hidden" id="customer_id" name="customer_id" value="<?php echo $customer_id ?>">
										<input type="hidden" id="used_si" name="used_si" value="<?php echo $used_si ?>">
										<input type="hidden" id="po_processed_shp" name="po_processed_shp" value="<?php echo $po_processed_shp ?>">
										
										<div class="panel-body">
											<div class="col-md-6">
												<div class="form-group">
													<label class="col-md-3 control-label" for="varchar">Contract No</label>
													<div class="col-md-3">
														<input readonly="readonly" type="text" class="form-control text-center" name="contract_no" id="contract_no" value="<?php echo $contract_no ?>" />
													</div>
													<label class="col-md-1 control-label" for="varchar">Date</label>
													<div class="col-md-3">
														<input readonly="readonly" type="text" class="form-control text-center" name="contract_date" id="contract_date" value="<?php echo $contract_date ?>" />
													</div>
												</div>
												
												<div class="form-group required">
													<label class="col-md-3 control-label" for="varchar">Factory</label>
													<div class="col-md-7">
														<!--<input readonly="readonly" type="text" class="form-control" name="factory" id="factory" value="<?php // echo $factory ?>" />-->
														<?php
															$factory_readonly = ($act == 'add')? '' : ' disabled="disabled"';
															$extra_factory = 'required id="factory_list" class="form-control"'.$factory_readonly;
															foreach($cbo_factory as $r):
																$option_factory[$r->factory_id] = $r->factory_name;
															endforeach;
															echo form_dropdown('factory_list', $option_factory, $factory_id, $extra_factory);
														?>
														<input type="hidden" name="factory_id" id="factory_id" value="<?php echo $factory_id ?>">
													</div>
													
												</div>
												
												<script>
													$('#factory_list').on('change', function(){
														var aksi		= $('#act').val();
														var hdr_id		= $('#contract_hdr_id').val();
														var factory_id	= $(this).val();
														
														if (aksi == 'add'){
															$('#factory_id').val(factory_id);
															
															sambu.startPageLoading({
															message : 'Load Product...'
															});

															window.setTimeout(function() {
																sambu.stopPageLoading();
															}, 2000);
															
															$.ajax({
																type	: 'POST',
																url		: '<?php echo site_url('marketing_transaction/purchase_order/on_select_factory');?>',
																data	: {
																	hdr_id		: hdr_id,
																	factory_id	: factory_id
																},
																success	: function(msg){
																	$('#table-container').html(msg);
																}
															});
														}
													});
												</script>

											</div>
											
											<div class="col-md-6">
												
												<div class="form-group">
													<label class="col-md-3 control-label" for="varchar">Customer</label>
													<div class="col-md-7">
														<input readonly="readonly" type="text" class="form-control" name="customer_name" id="customer_name" value="<?php echo $customer_name ?>" />
													</div>											
												</div>
												
												<div class="form-group">
													<label class="col-md-3 control-label" for="varchar">Customer Contact</label>
													<div class="col-md-7">
														<input readonly="readonly" type="text" class="form-control" name="customer_contact_name" id="customer_contact_name" value="<?php echo $customer_contact_name ?>" />
													</div>
												</div>
											</div>
											
										</div>
									</div>
									
									<h4 class="form-section"><i class="fa fa-edit"></i> Issue Purchase Order</h4>

									<div class="col-md-12">											

										<div class="form-group">
											<label class="col-md-2 control-label" for="varchar">PO Number</label>
											<div class="col-md-2">
												<?php
												$required = '';
												if ($act == 'edit'){
													$required = 'required';
												}
												?>
												<input type="text" class="form-control" name="po_number" id="po_number" hdrid="<?php echo decode_str($po_hdr_id); ?>" value="<?php echo $po_number ?>" <?php echo $required ?>/>
											</div>
											
											<span class="col-md-2"></span>
											
											<label class="col-md-1 control-label" style="padding-right:5px;" for="varchar">Issue Date</label>
											<div class="col-md-2">
												<input type="text" class="form-control date date-picker" data-date-format="dd/mm/yyyy" name="po_date" id="po_date" value="<?php echo $po_date; ?>" />												
											</div>	
											<div id="div_duplicated_po">
												<input type="hidden" id="duplicated_po">
												<input type="hidden" id="duplicated_po_msg">
											</div>
											
											<script type="text/javascript">
												$('#po_number').on('keyup', function(){
//													var hdr_id = <?php // echo decode_str($po_hdr_id) ?>;
													var hdr_id = $(this).attr('hdrid');
													var po_number = $('#po_number').val();

													$.ajax({
														type:'POST',
														url: "<?php echo site_url('marketing_transaction/duplicate_po');?>",
														cache: false,
														data:{
															po_hdr_id	: hdr_id,
															po_number	: po_number
														},
														success: function (msg) {
															$('#div_duplicated_po').html(msg);
														}
													});
												});
											</script>
										</div>
										
										<div class="form-group">
											<label class="col-md-2 control-label" for="varchar">Shipping Mark</label>
											<div class="col-md-4">
												<input type="text" class="form-control" name="ship_mark" id="ship_mark" value="<?php echo $ship_mark ?>" />												
											</div>
											
											<label class="col-md-1 control-label" style="padding-right:5px;" for="varchar">Shipping Date</label>
											<div class="col-md-2">
												<input type="text" required="required" class="form-control date date-picker" data-date="<?php echo $current_date?>" data-date-format="dd/mm/yyyy" name="ship_date" id="ship_date" value="<?php echo $ship_date; ?>" />												
											</div>											
										</div>
										
										<div class="form-group">
											<label class="col-md-2 control-label" for="varchar">Final Destination</label>
											<div class="col-md-4">
												<?php 
													$extra_destination = 'required id="destination_id" class="form-control "';
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
											
											<label class="col-md-1 control-label" style="padding-right:5px;" for="varchar">Container Size</label>
											<div class="col-md-3">
												<?php 
													$extra_container = 'id="container_list" class="form-control" onchange="change_container()"';
													$option_container[''] = '';
													foreach($cbo_container as $r):
														$option_container[$r->container_id.'|'.$r->container_size] = $r->container_name;
													endforeach;
													echo form_dropdown('container_list', $option_container, $container_id.'|'.$container_size, $extra_container);
												?>
												<input type="hidden" id="container_id" name="container_id" value="<?php echo $container_id?>">
											</div>
										</div>
										
										<div class="form-group">
											<label class="col-md-2 control-label" for="varchar">Buyer SI</label>
											<div class="col-md-4">
												<input type="text" class="form-control" name="buyer_si" id="buyer_si" value="<?php echo $buyer_si ?>" />												
											</div>
											
											<label class="col-md-1 control-label" style="padding-right:5px;" for="varchar">Ocean Freight</label>
											<div class="col-md-5">
												<input type="text" class="form-control" data-date="<?php echo $ocean_freight?>" name="ocean_freight" id="ocean_freight" value="<?php echo $ocean_freight; ?>" />
											</div>
										</div>
										
										<div class="form-group required">
										<label class="col-md-2 control-label" for="varchar">Local Currency</label>
										<div class="col-md-4">
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
											<div class="col-md-3">												
												<div id="div_rate_usd" class="input-group">		
													<span class='input-group-addon'>US$</span>
													<input required type="text" class="form-control text-right input-rate" name="rate_usd" id="rate_usd" placeholder="0.000000" value="<?php echo $rate_usd; ?>" title="6 digits decimal" />
												</div>
											</div>
											<div class="col-md-3">
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
							</div>	
							
							<hr/>
							
							<div class="form-body row">	
								<div class="col-md-12">
									<div class="table-toolbar">
										<div class="row">
											<div class="col-md-6">
												<div class="btn-group">
													<!--<a class="btn btn-primary btn-large" data-target="#modal_product" data-toggle="modal">-->
													<?php 													
														echo $btn_add_product;
													?>
												</div>
											</div>
										</div>
									</div>
									
									<div id="table-container" class="table-scrollable">
										
										<table class="table table-bordered table-condensed table-detail scrollable" id="tbl_po">
											<thead>
												<tr class="double-border-bottom">
													<th>&nbsp;</th>
													<th>Product Description</th>
													<th>Product Code</th>
													<th>Brand Name</th>
													<th>Factory</th>
													<th>Packing Size</th>
													<th>UOM</th>
													<th>Unit Price</th>
													<th>S.Contract Qty</th>
													<th>Balance Qty</th>
													<th>Quantity</th>
													<th>FOB Factory Price</th>
													<th>Total</th>
													<th>Palletized</th>
													<th>Pallet Qty</th>
													<th>Sodium Metabisulphite</th>
													<th>FCL</th>
													<th>PM Label Code</th>
													<th>PM Label Qty</th>
													<th>Carton Barcode</th>
													<th>Carton Remark</th>
													<th>Marking On Long Side</th>
													<th>Marking On Short Side</th>
												</tr>
											</thead>
											<tbody>
												<?php
												
												$s_prod_desc	= "style='width:300px;'";
												$s_prod_code	= "style='width:180px;text-align:center;'";
												$s_brand		= "style='width:100px;text-align:center;cursor:pointer;'";
												$s_factory		= "style=width:80px;text-align:center;";
												$s_packsize		= "style='width:150px;text-align:center;'";
												$s_uom			= "style='width:100px;text-align:center;'";
												$s_price		= "style='width:80px;'";
												$s_contract_qty	= "style='width:90px;'";
												$s_balance		= "style='width:110px;'";
												$s_qty			= "style='width:80px;'";
												$s_fobprice		= "style='width:110px;'";
												$s_total		= "style='width:100px;'";
												$s_sodium		= "style='width:180px;'";
												$s_fcl			= "style='width:50px;'";
												$s_pm_code		= "style='width:150px;text-align:center;cursor:pointer;'";
												$s_pm_qty		= "style='width:90px;'";
												$s_barcode		= "style='width:130px;'";
												$s_cart_remark	= "style='width:250px;'";	//"style='width:150px;'";
												$s_mark_longside	= "style='width:200px;'";
												$s_mark_long		= "style='width:250px;'";
												$s_mark_shortside	= "style='width:200px;'";
												$s_mark_short	= "style='width:250px;'";
												
												if ($contract_product){
													$last_count = 0;
													foreach($contract_product as $d){
														
//														$sub_total = $d->fob_price * $d->quantity;
														$sub_total = '';
														
														$qty_contract	= $this->M_mar_purchase_order->get_qty_contract($contract_hdr_id, $d->contract_dtl_id, $d->product_id);
														$qty_po			= $this->M_mar_purchase_order->get_qty_po($contract_hdr_id, $d->contract_dtl_id, $d->product_id);
														$outstanding_qty = $qty_contract-$qty_po;
																												
														switch ($factory_id){
															case 1:
																$detail_po_format = $d->po_code_prefix_psg;
																break;
															case 3:
																$detail_po_format = $d->po_code_prefix_rsup;
																break;
															default:
																$detail_po_format = '000/MM/YY PSS';
																break;
														}
														
														if ($d->product_view){
															$product_desc = $d->product_view;
														} else {
															$product_desc = $d->product_name;
														}
														
														if ($outstanding_qty > 0){
															echo "<tr>";
															//Kolom Tombol
															echo "<td class='text-center bg-editable' style='vertical-align: top;'>";
															echo "<input type='button' $disabled_btn style='width: 80px; margin-left: 5px; margin-top: 2px;' class='btn default btn-xs red-stripe' used_si='$used_si' onclick='removeRow(this)' value='Remove'>";
															echo "<input type='hidden' name='po_dtl_id[]' value='0'>";
	//														echo "<a data-target='#modal_product' data-toggle='modal' type='button' class='btn default btn-xs blue-stripe'>Detail Product</a>";
															echo "<input type='hidden' name='product_id[]' value='$d->product_id'>";
															echo "<input type='hidden' name='detail_contract_hdr_id[]' value='$d->contract_hdr_id'>";
															echo "<input type='hidden' name='contract_dtl_id[]' value='$d->contract_dtl_id'>";
															echo "<input type='hidden' name='detail_factory_id[]' class='f_id' value='$d->factory_id'>";
															echo form_hidden('detail_po_format[]', $detail_po_format);
//															echo form_hidden('po_format[]', $po_format);
															echo "</td>";
															//Kolom Product Description
															echo "<td  class='bg-editable'>";
															echo "<input name='product_name[]' value='$product_desc' $s_prod_desc class='form-control input-xs input-table' placeholder='Product Name' title='$d->product_name'>";
															echo "</td>";
															//Kolom Product Code
															echo "<td>";
															echo "<input name='product_code[]' value='$d->product_code' $s_prod_code class='form-control input-xs input-table' placeholder='Product Code' readonly='readonly' title='$d->product_code'>";
															echo "</td>";
															//Kolom Brand Name
															echo "<td class='bg-editable'>";
															echo "<input name='detail_brand_id[]' id='br-$last_count' value='$d->brand_id' type='hidden' class='form-control brand-text input-xs input-table'>";
															echo '<div class="input-group" style="margin-bottom: 0px;">';
																echo "<input name='brand[]' id='brn-$last_count' value='$d->brand_name' $s_brand class='form-control input-xs input-table' onClick='viewModalSelectBrand(this.id)' placeholder='Select Brand' readonly='readonly'>";
																echo '<div class="input-group-btn">';
																	echo "<input type='button' class='btn btn-xs fontawesome-font fa-grey fa-transparent remove_brand' title='Clear brand name' value='×' id='$last_count'>";
																echo '</div>';
															echo '</div>';
															echo "</td>";	
															//Kolom Factory
															echo "<td>";
															echo "<input name='factory[]' value='$d->factory_abbr' $s_factory class='form-control input-xs input-table' readonly='readonly'>";
															echo "<input name='detail_factory_id[]' value='$d->factory_id' type='hidden'>";
															echo "</td>";
															//Kolom Pack Size
															echo "<td class='bg-editable'>";
															echo "<input name='detail_pack_size[]' value='$d->detail_pack_size' $s_packsize class='form-control input-xs input-table'>";
															echo "</td>";															
															//Kolom UOM
															echo "<td>";
															echo "<input name='uom[]' value='$d->cma_uom_quantity_id' $s_uom class='form-control input-xs input-table' readonly='readonly'>";
															echo "</td>";
															//Kolom Unit Price
															echo "<td>";
															echo "<input name='unit_price[]' value='".number_format($d->price, 2, '.', ',')."' $s_price type='text' class='form-control input-xs text-right input-table' readonly='readonly' onkeypress='return isNumber(event)' onkeyup='calculate()'>";
															echo "</td>";
															//Kolom Sales Contract Qty														
															echo "<td>";
															echo "<input name='contract_qty[]' value='".number_format($qty_contract, 0, '.', ',')."' $s_contract_qty type='text' class='form-control input-xs text-right input-table readonly='readonly'>";
															echo "</td>";
															//Kolom Outstanding Qty														
															echo "<td>";
															echo "<input name='outstanding_qty[]' value='".number_format($outstanding_qty, 0, '.', ',')."' $s_balance type='text' class='form-control input-xs text-right input-table' readonly='readonly'>";
															echo "</td>";
															//Kolom Qty
															echo "<td class='bg-editable'>";
															echo "<input name='qty[]' $s_qty type='text' required class='form-control input-xs text-right input-table autonum_qty' data-v-min='0' data-v-max='$outstanding_qty' onkeyup='calculate()'>";
															echo "</td>";
															//Kolom FOB Price
															echo "<td class='bg-editable'>";
															echo "<input name='fob_price[]' $s_fobprice type='text' class='form-control input-xs text-right input-table autonum_fob' data-v-min='0' onkeyup='calculate()'>";
															
															//data-v-max dihilangkan
//															if ($qty_contract > 0 && $d->price == 0){
//																echo "<input name='fob_price[]' $s_fobprice type='text' class='form-control input-xs text-right input-table autonum_fob' data-v-min='0' onkeyup='calculate()'>";
//															} else {
//																echo "<input name='fob_price[]' $s_fobprice type='text' class='form-control input-xs text-right input-table autonum_fob' data-v-min='0' data-v-max='$d->price' onkeyup='calculate()'>";
//															}
															
															echo "</td>";															
															//Kolom Total
															echo "<td>";
															echo "<input name='total[]' value='0.00' $s_total type='text' class='form-control input-xs text-right input-table' readonly='readonly'>";
	//														echo "<input name='total[]' value='".number_format($sub_total, 2,'.',',')."' style='width:100px;' type='text' class='form-control input-xs text-right input-table' readonly='readonly'>";
															echo "</td>";
															
															//Kolom Palletized
															echo "<td class='bg-editable text-center' style='width: 5%; padding-top:5px;'>";
															echo form_checkbox("detail_palletized[$d->contract_dtl_id]", $d->contract_dtl_id, false);
															echo "</td>";
															
															$pallet_qty = isset($d->pallet_qty) ? $d->pallet_qty : 0;													
															echo "<td class='bg-editable'>";
															echo "<input type='text' value='".number_format($pallet_qty,0,'.',',')."' name='pallet_qty[]' class='form-control input-xs input-table text-right autonum autofocus' data-v-min='0'/>";
															echo "</td>";
															
															//Kolom Sodium Metabisulphite
															echo "<td class='bg-editable'>";
//															echo "<textarea name='sodium_metabisulphite[]' rows='2' style='width:200px;' class='form-control input-xs input-table'></textarea>";
															echo "<input name='sodium_metabisulphite[]' $s_sodium value='' type='text' class='form-control input-xs input-table'>";
															echo "</td>";
															//Kolom FCL
															echo "<td>";
//															echo form_hidden('estimated_qty[]', $d->estimated_qty);
															echo "<input name='fcl[]' readonly='readonly' type='text' $s_fcl class='form-control input-xs text-right input-table autonumber' data-v-min='0'>";
																echo "<input name='container_20ft[]' value='".number_format($d->container_20ft,0)."' type='hidden'>";
																echo "<input name='container_40ft[]' value='".number_format($d->container_40ft,0)."' type='hidden'>";
															echo "</td>";
															//Kolom PM Label Code
															echo "<td class='bg-editable'>";
																echo '<input name="pm_label_code[]" value="" id="pm-'.$last_count.'" '.$s_pm_code.' onClick="view_modal_label_code(this.id)" class="form-control input-xs input-table" placeholder="Select PM Label Code" readonly="readonly">';
															echo "</td>";
															//Kolom Label Quantity
															echo "<td class='bg-editable'>";
															echo form_hidden('per_packing[]', $d->per_packing);	// Label Qty = Qty x Per Packing
															echo "<input name='label_qty[]' $s_pm_qty type='text' class='form-control input-xs input-table text-right autonum_qty'>";
															echo "</td>";
															//Kolom Carton Barcode
															echo "<td class='bg-editable'>";
															echo "<input name='carton_barcode[]' $s_barcode type='text' class='form-control input-xs input-table text-right carton_barcode_class'>";
															echo "</td>";
															//Kolom Carton Barcode Remark
															echo "<td class='bg-editable'>";
//															echo form_dropdown('cbo_carton_remark[]', $option_carton_remark, '', $extra_carton_remark.' crid='.$last_count.' prev_value=""');
															echo "<input type='button' class='btn btn-block btn-xs purple-stripe fontawesome-font' value='&#xf002 show history' onClick='viewModalCartonRemark($last_count)'>";
															echo "<textarea name='carton_remark[]' rows=4 $s_cart_remark id='carton_remark_$last_count' class='form-control input-xs input-table autosizeme carton_remark_class'></textarea>";
//															echo "<input name='carton_remark[]' $s_cart_remark type='text' class='form-control input-xs input-table text-right carton_remark_class'>";
															echo "</td>";
															//Kolom Marking On Long Side
															echo "<td class='bg-editable'>";
															echo "<input type='button' class='btn btn-block btn-xs green-stripe fontawesome-font' value='&#xf002 show history' onClick='viewModalSelectMarking($last_count)'>";
															echo "<div class='input-group input-table-group'>";															
															echo "<input name='long_side[]' id='ls-$last_count' $s_mark_longside type='text' class='form-control input-xs text-right input-table autonumber' data-v-max='10' data-v-min='0'>";
															echo "<span class='input-group-addon input-table-group-addon bootstrap-touchspin-postfix' onClick='viewModalSelectMarking($last_count)'>side</span>";
															echo "</div>";
															echo "<textarea name='marking_long_side[]' id='lm-$last_count' rows=3 $s_mark_long class='form-control input-xs input-table autosizeme'></textarea>";
															echo "</td>";
															//Kolom Marking On Short Side
															echo "<td class='bg-editable'>";
															echo "<input type='button' class='btn btn-block btn-xs green-stripe fontawesome-font' value='&#xf002 show history' onClick='viewModalSelectMarking($last_count)'>";
															echo "<div class='input-group input-table-group'>";
															echo "<input name='short_side[]' id='ss-$last_count' $s_mark_shortside type='text' class='form-control input-xs text-right input-table autonumber' data-v-max='10' data-v-min='0'>";
															echo "<span class='input-group-addon input-table-group-addon bootstrap-touchspin-postfix'>side</span>";
															echo "</div>";
															echo "<textarea name='marking_short_side[]' id='sm-$last_count' rows=3 $s_mark_short class='form-control input-xs input-table autosizeme'></textarea>";
															echo "</td>";

															echo "</tr>";
														}
														$last_count++;
													}
												}
												
												if ($detail){
													$last_count = 0;
													foreach($detail as $d){
														
														$sub_total = $d->fob_price * $d->quantity;
														
														if ($d->product_view){
															$product_desc = $d->product_view;
														} else {
															$product_desc = $d->product_name;
														}
														
														$qty_contract	= $this->M_mar_purchase_order->get_qty_contract($contract_hdr_id, $d->contract_dtl_id, $d->product_id);
														$qty_po			= $this->M_mar_purchase_order->get_qty_po($contract_hdr_id, $d->contract_dtl_id, $d->product_id);
														
														if ($qty_contract > 0){															
															$outstanding_qty = $qty_contract-$qty_po;															
														} else {
															$outstanding_qty = 0;
														}
														echo "<tr>";
														//Kolom Tombol
														echo "<td class='text-center bg-editable' style='vertical-align: top; padding-top: 2px;'>";
//														echo "<input type='button' style='width: 80px; margin-left: 5px; margin-top: 2px;' class='btn default btn-xs red-stripe' onclick='removeRow(this)' value='Remove'>";
														echo "<input type='button' $disabled_btn style='width: 80px; margin-left: 5px; margin-top: 2px;' class='btn default btn-xs red-stripe remove_detail' value='Remove' used_si='$used_si' id='".encode_str($d->po_dtl_id,'po')."'>";
//														echo "<a data-target='#modal_product' data-toggle='modal' type='button' class='btn default btn-xs blue-stripe'>Detail Product</a>";
														echo "<input type='hidden' name='po_dtl_id[]' value='$d->po_dtl_id'>";
														echo "<input type='hidden' name='product_id[]' value='$d->product_id'>";
														echo "<input type='hidden' name='detail_contract_hdr_id[]' value='$d->contract_hdr_id'>";
														echo "<input type='hidden' name='contract_dtl_id[]' value='$d->contract_dtl_id'>";
														echo "<input type='hidden' name='detail_factory_id[]' class='f_id' value='$d->factory_id'>";
														echo form_hidden('detail_po_format[]', $d->po_format);
//														echo form_hidden('po_format[]', $po_format);
														echo "</td>";
														//Kolom Product Description
														echo "<td class='bg-editable'>";
														echo "<input name='product_name[]' value='$product_desc' $s_prod_desc class='form-control input-xs input-table' placeholder='Product Name' title='$d->product_name'>";
														echo "</td>";
														//Kolom Product Code
														echo "<td>";
														echo "<input name='product_code[]' value='$d->product_code' $s_prod_code class='form-control input-xs input-table' placeholder='Product Code' readonly='readonly' title='$d->product_code'>";
														echo "</td>";
														//Kolom Brand Name
														echo "<td class='bg-editable'>";
															echo "<input name='detail_brand_id[]' id='br-$last_count' value='$d->brand_id' type='hidden' class='form-control brand-text input-xs input-table'>";
															echo '<div class="input-group" style="margin-bottom: 0px;">';
																echo "<input name='brand[]' id='brn-$last_count' value='$d->brand_name' $s_brand class='form-control input-xs input-table' onClick='viewModalSelectBrand(this.id)' placeholder='Select Brand' readonly='readonly'>";
																echo '<div class="input-group-btn">';
																	echo "<input type='button' class='btn btn-xs fontawesome-font fa-grey fa-transparent remove_brand' title='Clear brand name' value='×' id='$last_count'>";
																echo '</div>';
															echo '</div>';
//														echo "<input name='brand[]' value='$d->brand_name' $s_brand class='form-control input-xs input-table' readonly='readonly'>";
														echo "</td>";
														//Kolom Factory
														echo "<td>";
														echo "<input name='factory[]' value='$d->factory_abbr' $s_factory class='form-control input-xs input-table' readonly='readonly'>";
														echo "<input name='detail_factory_id[]' value='$d->factory_id' type='hidden'>";
														echo "</td>";
														//Kolom Pack Size
														echo "<td class='bg-editable'>";
														echo "<input name='detail_pack_size[]' value='$d->detail_pack_size' $s_packsize class='form-control input-xs input-table'>";
														echo "</td>";
														//Kolom UOM
														echo "<td>";
														echo "<input name='uom[]' value='$d->cma_uom_quantity_id' $s_uom class='form-control input-xs input-table' readonly='readonly'>";
														echo "</td>";
														//Kolom Unit Price
														echo "<td>";
														echo "<input name='unit_price[]' value='".number_format($d->price, 2, '.', ',')."' $s_price type='text' class='form-control input-xs text-right input-table' readonly='readonly' onkeypress='return isNumber(event)' onkeyup='calculate()'>";
														echo "</td>";
														//Kolom Sales Contract Qty
														
														echo "<td>";
														echo "<input poqty='$qty_po' conqty='$qty_contract' outqty='$outstanding_qty' name='contract_qty[]' value='".number_format($qty_contract, 0, '.', ',')."' $s_contract_qty type='text' class='form-control input-xs text-right input-table' readonly='readonly'>";
														echo "</td>";
														//Kolom Outstanding Qty
														
														if ($qty_contract > 0){
//															$qty_max = "data-v-max='".strval($outstanding_qty+$d->quantity)."'";
															if ($act == 'add'){
																$qty_max = "data-v-max='".strval($qty_contract - $qty_po)."'";
																$quantity = strval($d->quantity) > strval($qty_contract - $qty_po) ? strval($qty_contract - $qty_po) : $d->quantity;
															} else {																
																$qty_max = "data-v-max='".strval($outstanding_qty + $d->quantity)."'";
																$quantity = $d->quantity;
																$outstanding_qty = strval($outstanding_qty + $d->quantity);
															}
														} else {
															$qty_max = '';
															$quantity = $d->quantity;
														}														
														
														echo "<td>";
														echo "<input name='outstanding_qty[]' value='".number_format($outstanding_qty, 0, '.', ',')."' $s_balance type='text' class='form-control input-xs text-right input-table' readonly='readonly'>";
														echo "</td>";
														//Kolom Qty
														echo "<td class='bg-editable'>";
														
														echo "<input name='qty[]' required value='$quantity' $s_qty $qty_max type='text' class='form-control input-xs text-right input-table autonum_qty autofocus' data-v-min='0' onkeyup='calculate()'>";
														echo "</td>";
														//Kolom FOB Price
//														$up =  $qty_contract > 0 ? 'true' : 'false';
														echo "<td class='bg-editable'>";
														echo "<input name='fob_price[]' value='$d->fob_price' $s_fobprice type='text' class='form-control input-xs text-right input-table autonum_fob autofocus' data-v-min='0' onkeyup='calculate()'>";
//														if ($qty_contract > 0 && $d->price == 0){
//															echo "<input name='fob_price[]' value='$d->fob_price' $s_fobprice type='text' class='form-control input-xs text-right input-table autonum_fob autofocus' data-v-min='0' onkeyup='calculate()'>";
//														} else {
//															echo "<input name='fob_price[]' value='$d->fob_price' $s_fobprice type='text' class='form-control input-xs text-right input-table autonum_fob autofocus' data-v-min='0' data-v-max='$d->price' onkeyup='calculate()'>";
//														}
														echo "</td>";
														
														//Kolom Total
														echo "<td>";
														echo "<input name='total[]' value='".number_format($sub_total, 2,'.',',')."' $s_total type='text' class='form-control input-xs text-right input-table' readonly='readonly'>";
														echo "</td>";
														
														//Kolom Palletized
														if (isset($d->detail_palletized)){
															$checked = ($d->detail_palletized == 1 ? true : false);
														} else {
															$checked = false;
														}

														echo "<td class='bg-editable text-center' style='width: 5%; padding-top:5px;'>";
														echo form_checkbox("detail_palletized[$d->contract_dtl_id]", $d->contract_dtl_id, $checked);
														echo "</td>";

														$pallet_qty = isset($d->pallet_qty) ? $d->pallet_qty : 0;													
														echo "<td class='bg-editable'>";
														echo "<input type='text' value='".number_format($pallet_qty,0,'.',',')."' name='pallet_qty[]' class='form-control input-xs input-table text-right autonum autofocus' data-v-min='0'/>";
														echo "</td>";
														
														//Kolom Sodium Metabisulphite
														echo "<td class='bg-editable'>";
//														echo "<textarea name='product_remark[]' rows='2' style='width:200px;' class='form-control input-xs input-table'>$d->product_remark</textarea>";
														echo "<input name='sodium_metabisulphite[]' value='$d->sodium_metabisulphite' $s_sodium type='text' class='form-control input-xs input-table'>";
														echo "</td>";
														//Kolom FCL
														echo "<td>";
//														echo form_hidden('estimated_qty[]', $d->estimated_qty);
														echo "<input name='fcl[]' value='$d->fcl' readonly='readonly' type='text' $s_fcl class='form-control input-xs text-right input-table autonumber autofocus' data-v-min='0'>";
															echo "<input name='container_20ft[]' value='".number_format($d->container_20ft,0)."' type='hidden'>";
															echo "<input name='container_40ft[]' value='".number_format($d->container_40ft,0)."' type='hidden'>";
														echo "</td>";
														//Kolom PM Label Code
														echo "<td class='bg-editable'>";																
															echo '<input name="pm_label_code[]" value="'.$d->pm_label_code.'" id="pm-'.$last_count.'" '.$s_pm_code.' onClick="view_modal_label_code(this.id)" class="form-control input-xs input-table" placeholder="Select PM Label Code" readonly="readonly">';
														echo "</td>";
//														//Kolom Label Remark
//														echo "<td class='bg-editable'>";
//														echo "<input name='label_remark[]' value='$d->label_remark' style='width:200px;' type='text' class='form-control input-xs input-table'>";
//														echo "</td>";
														//Kolom Label Quantity
														echo "<td class='bg-editable'>";
														echo form_hidden('per_packing[]', $d->per_packing);
														echo "<input name='label_qty[]' value='$d->label_qty' $s_pm_qty type='text' class='form-control input-xs input-table text-right autonum_qty autofocus'>";
														echo "</td>";
														//Kolom Carton Barcode
														echo "<td class='bg-editable'>";
														echo "<input name='carton_barcode[]' value='$d->carton_barcode' $s_barcode type='text' class='form-control input-xs input-table text-right carton_barcode_class'>";
														echo "</td>";
														//Kolom Carton Barcode Remark
														echo "<td class='bg-editable'>";
//														echo form_dropdown('cbo_carton_remark[]', $option_carton_remark, '', $extra_carton_remark.' crid='.$last_count.' prev_value="'.$d->carton_remark.'"');
														echo "<input type='button' class='btn btn-block btn-xs purple-stripe fontawesome-font' value='&#xf002 show history' onClick='viewModalCartonRemark($last_count)'>";
														echo "<textarea name='carton_remark[]' rows=4 $s_cart_remark id='carton_remark_$last_count' class='form-control input-xs input-table autosizeme carton_remark_class'>$d->carton_remark</textarea>";
//														echo "<input name='carton_remark[]' value='$d->carton_remark' $s_cart_remark type='text' class='form-control input-xs input-table text-right carton_remark_class'>";
														echo "</td>";
														//Kolom Marking On Long Side
														echo "<td class='bg-editable'>";
														echo "<input type='button' class='btn btn-block btn-xs green-stripe fontawesome-font' value='&#xf002 show history' onClick='viewModalSelectMarking($last_count)'>";
														echo "<div class='input-group input-table-group'>";
														echo "<input name='long_side[]' id='ls-$last_count' value='$d->long_side' $s_mark_longside type='text' class='form-control input-xs text-right input-table autonumber autofocus' data-v-max='10' data-v-min='0'>";
														echo "<span class='input-group-addon input-table-group-addon bootstrap-touchspin-postfix' >side</span>";
														echo "</div>";
														echo "<textarea name='marking_long_side[]' id='lm-$last_count' rows=3 $s_mark_long class='form-control input-xs input-table autosizeme'>$d->marking_long_side</textarea>";
//														echo "<input name='marking_long_side[]' value='$d->marking_long_side' style='width:200px;' type='text' class='form-control input-xs input-table'>";
														echo "</td>";
														//Kolom Marking On Short Side
														echo "<td class='bg-editable'>";
														echo "<input type='button' class='btn btn-block btn-xs green-stripe fontawesome-font' onClick='viewModalSelectMarking($last_count)' value='&#xf002 show history'>";
														echo "<div class='input-group input-table-group'>";
														echo "<input name='short_side[]' id='ss-$last_count' value='$d->short_side' $s_mark_shortside type='text' class='form-control input-xs text-right input-table autonumber autofocus' data-v-max='10' data-v-min='0'>";
														echo "<span class='input-group-addon input-table-group-addon bootstrap-touchspin-postfix'>side</span>";
														echo "</div>";
														echo "<textarea name='marking_short_side[]' id='sm-$last_count' rows=3 $s_mark_short class='form-control input-xs input-table autosizeme'>$d->marking_short_side</textarea>";
//														echo "<input name='marking_short_side[]' value='$d->marking_short_side' style='width:200px;' type='text' class='form-control input-xs input-table'>";
														echo "</td>";
														
														echo "</tr>";
														
														$last_count++;
													}
												}
												
												if ($detail_copy){
													$last_count = 0;
													foreach($detail_copy as $d){
																												
														$sub_total = $d->fob_price * $d->quantity;
														
														if ($d->product_view){
															$product_desc = $d->product_view;
														} else {
															$product_desc = $d->product_name;
														}
														
														$qty_contract	= $this->M_mar_purchase_order->get_qty_contract($contract_hdr_id, $d->contract_dtl_id, $d->product_id);
														$qty_po			= $this->M_mar_purchase_order->get_qty_po($contract_hdr_id, $d->contract_dtl_id, $d->product_id);
														
														if ($qty_contract > 0){															
															$outstanding_qty = $qty_contract-$qty_po;															
														} else {
															$outstanding_qty = 0;
														}
														
														echo "<tr>";
														//Kolom Tombol
														echo "<td class='text-center bg-editable' style='vertical-align: top; padding-top: 2px;'>";
//														echo "<input type='button' style='width: 80px; margin-left: 5px; margin-top: 2px;' class='btn default btn-xs red-stripe' onclick='removeRow(this)' value='Remove'>";
														echo "<input type='button' $disabled_btn style='width: 80px; margin-left: 5px; margin-top: 2px;' class='btn default btn-xs red-stripe remove_detail_add' value='Remove' used_si='$used_si' id='0'>";
//														echo "<a data-target='#modal_product' data-toggle='modal' type='button' class='btn default btn-xs blue-stripe'>Detail Product</a>";
														echo "<input type='hidden' name='po_dtl_id[]' value='0'>";
														echo "<input type='hidden' name='product_id[]' value='$d->product_id'>";
														echo "<input type='hidden' name='detail_contract_hdr_id[]' value='$d->contract_hdr_id'>";
														echo "<input type='hidden' name='contract_dtl_id[]' value='$d->contract_dtl_id'>";
														echo "<input type='hidden' name='detail_factory_id[]' class='f_id' value='$d->factory_id'>";
														echo form_hidden('detail_po_format[]', $d->po_format);
//														echo form_hidden('po_format[]', $po_format);
														echo "</td>";
														//Kolom Product Description
														echo "<td class='bg-editable'>";
														echo "<input name='product_name[]' value='$product_desc' $s_prod_desc class='form-control input-xs input-table' placeholder='Product Name' title='$d->product_name'>";
														echo "</td>";
														//Kolom Product Code
														echo "<td>";
														echo "<input name='product_code[]' value='$d->product_code' $s_prod_code class='form-control input-xs input-table' placeholder='Product Code' readonly='readonly' title='$d->product_code'>";
														echo "</td>";
														//Kolom Brand Name
														echo "<td class='bg-editable'>";
															echo "<input name='detail_brand_id[]' id='br-$last_count' value='$d->brand_id' type='hidden' class='form-control brand-text input-xs input-table'>";
															echo '<div class="input-group" style="margin-bottom: 0px;">';
																echo "<input name='brand[]' id='brn-$last_count' value='$d->brand_name' $s_brand class='form-control input-xs input-table' onClick='viewModalSelectBrand(this.id)' placeholder='Select Brand' readonly='readonly'>";
																echo '<div class="input-group-btn">';
																	echo "<input type='button' class='btn btn-xs fontawesome-font fa-grey fa-transparent remove_brand' title='Clear brand name' value='×' id='$last_count'>";
																echo '</div>';
															echo '</div>';
//														echo "<input name='brand[]' value='$d->brand_name' $s_brand class='form-control input-xs input-table' readonly='readonly'>";
														echo "</td>";
														//Kolom Factory
														echo "<td>";
														echo "<input name='factory[]' value='$d->factory_abbr' $s_factory class='form-control input-xs input-table' readonly='readonly'>";
														echo "<input name='detail_factory_id[]' value='$d->factory_id' type='hidden'>";
														echo "</td>";
														//Kolom Pack Size
														echo "<td class='bg-editable'>";
														echo "<input name='detail_pack_size[]' value='$d->detail_pack_size' $s_packsize class='form-control input-xs input-table'>";
														echo "</td>";
														//Kolom UOM
														echo "<td>";
														echo "<input name='uom[]' value='$d->cma_uom_quantity_id' $s_uom class='form-control input-xs input-table' readonly='readonly'>";
														echo "</td>";
														//Kolom Unit Price
														echo "<td>";
														echo "<input name='unit_price[]' value='".number_format($d->price, 2, '.', ',')."' $s_price type='text' class='form-control input-xs text-right input-table' readonly='readonly' onkeypress='return isNumber(event)' onkeyup='calculate()'>";
														echo "</td>";
														//Kolom Sales Contract Qty
														
														echo "<td>";
														echo "<input poqty='$qty_po' conqty='$qty_contract' outqty='$outstanding_qty' name='contract_qty[]' value='".number_format($qty_contract, 0, '.', ',')."' $s_contract_qty type='text' class='form-control input-xs text-right input-table' readonly='readonly'>";
														echo "</td>";
														//Kolom Outstanding Qty
														
														if ($qty_contract > 0){
//															$qty_max = "data-v-max='".strval($outstanding_qty+$d->quantity)."'";
															if ($act == 'add'){
																$qty_max = "data-v-max='".strval($qty_contract - $qty_po)."'";
																$quantity = strval($d->quantity) > strval($qty_contract - $qty_po) ? strval($qty_contract - $qty_po) : $d->quantity;
															} else {																
																$qty_max = "data-v-max='".strval($outstanding_qty + $d->quantity)."'";
																$quantity = $d->quantity;
																$outstanding_qty = strval($outstanding_qty + $d->quantity);
															}
														} else {
															$qty_max = '';
															$quantity = $d->quantity;
														}
														
														if ($outstanding_qty == 0){
															$s_balance		= "style='width:110px; font-weight: bold; color: red;'";
														}
														
														echo "<td>";
														echo "<input name='outstanding_qty[]' value='".number_format($outstanding_qty, 0, '.', ',')."' $s_balance type='text' class='form-control input-xs text-right input-table' readonly='readonly'>";
														echo "</td>";
														//Kolom Qty
														echo "<td class='bg-editable'>";
														
														echo "<input name='qty[]' required value='$quantity' $s_qty $qty_max type='text' class='form-control input-xs text-right input-table autonum_qty autofocus' data-v-min='0' onkeyup='calculate()'>";
														echo "</td>";
														//Kolom FOB Price
														echo "<td class='bg-editable'>";
														echo "<input name='fob_price[]' value='$d->fob_price' $s_fobprice type='text' class='form-control input-xs text-right input-table autonum_fob autofocus' data-v-min='0' onkeyup='calculate()'>";
														
//														if ($qty_contract > 0 && $d->price == 0){
//															echo "<input name='fob_price[]' value='$d->fob_price' $s_fobprice type='text' class='form-control input-xs text-right input-table autonum_fob autofocus' data-v-min='0' onkeyup='calculate()'>";
//														} else {
//															echo "<input name='fob_price[]' value='$d->fob_price' $s_fobprice type='text' class='form-control input-xs text-right input-table autonum_fob autofocus' data-v-min='0' data-v-max='$d->price' onkeyup='calculate()'>";
//														}
														echo "</td>";
														
														//Kolom Total
														echo "<td>";
														echo "<input name='total[]' value='".number_format($sub_total, 2,'.',',')."' $s_total type='text' class='form-control input-xs text-right input-table' readonly='readonly'>";
														echo "</td>";
														
														//Kolom Palletized
														if (isset($d->detail_palletized)){
															$checked = ($d->detail_palletized == 1 ? true : false);
														} else {
															$checked = false;
														}
														
														echo "<td class='bg-editable text-center' style='width: 5%; padding-top:5px;'>";
														echo form_checkbox("detail_palletized[$d->contract_dtl_id]", $d->contract_dtl_id, false);
														echo "</td>";

														$pallet_qty = isset($d->pallet_qty) ? $d->pallet_qty : 0;													
														echo "<td class='bg-editable'>";
														echo "<input type='text' value='".number_format($pallet_qty,0,'.',',')."' name='pallet_qty[]' class='form-control input-xs input-table text-right autonum autofocus' data-v-min='0'/>";
														echo "</td>";
																												
														//Kolom Sodium Metabisulphite
														echo "<td class='bg-editable'>";
//														echo "<textarea name='product_remark[]' rows='2' style='width:200px;' class='form-control input-xs input-table'>$d->product_remark</textarea>";
														echo "<input name='sodium_metabisulphite[]' value='$d->sodium_metabisulphite' $s_sodium type='text' class='form-control input-xs input-table'>";
														echo "</td>";
														//Kolom FCL
														echo "<td>";
														
														$fcl = ($quantity == 0) ? 0: $d->fcl;
														
//														echo form_hidden('estimated_qty[]', $d->estimated_qty);
														echo "<input name='fcl[]' value='$fcl' readonly='readonly' type='text' $s_fcl class='form-control input-xs text-right input-table autonumber autofocus' data-v-min='0'>";
															echo "<input name='container_20ft[]' value='".number_format($d->container_20ft,0)."' type='hidden'>";
															echo "<input name='container_40ft[]' value='".number_format($d->container_40ft,0)."' type='hidden'>";
														echo "</td>";
														//Kolom PM Label Code
														echo "<td class='bg-editable'>";																
															echo '<input name="pm_label_code[]" value="'.$d->pm_label_code.'" id="pm-'.$last_count.'" '.$s_pm_code.' onClick="view_modal_label_code(this.id)" class="form-control input-xs input-table" placeholder="Select PM Label Code" readonly="readonly">';
														echo "</td>";
//														//Kolom Label Remark
//														echo "<td class='bg-editable'>";
//														echo "<input name='label_remark[]' value='$d->label_remark' style='width:200px;' type='text' class='form-control input-xs input-table'>";
//														echo "</td>";
														//Kolom Label Quantity
														echo "<td class='bg-editable'>";
														echo form_hidden('per_packing[]', $d->per_packing);
														echo "<input name='label_qty[]' value='$d->label_qty' $s_pm_qty type='text' class='form-control input-xs input-table text-right autonum_qty autofocus'>";
														echo "</td>";
														//Kolom Carton Barcode
														echo "<td class='bg-editable'>";
														echo "<input name='carton_barcode[]' value='$d->carton_barcode' $s_barcode type='text' class='form-control input-xs input-table text-right carton_barcode_class'>";
														echo "</td>";
														//Kolom Carton Barcode Remark
														echo "<td class='bg-editable'>";
//														echo form_dropdown('cbo_carton_remark[]', $option_carton_remark, '', $extra_carton_remark.' crid='.$last_count.' prev_value="'.$d->carton_remark.'"');
														echo "<input type='button' class='btn btn-block btn-xs purple-stripe fontawesome-font' value='&#xf002 show history' onClick='viewModalCartonRemark($last_count)'>";
														echo "<textarea name='carton_remark[]' rows=4 $s_cart_remark id='carton_remark_$last_count' class='form-control input-xs input-table autosizeme carton_remark_class'>$d->carton_remark</textarea>";
//														echo "<input name='carton_remark[]' value='$d->carton_remark' $s_cart_remark type='text' class='form-control input-xs input-table text-right carton_remark_class'>";
														echo "</td>";
														//Kolom Marking On Long Side
														echo "<td class='bg-editable'>";
														echo "<input type='button' class='btn btn-block btn-xs green-stripe fontawesome-font' value='&#xf002 show history' onClick='viewModalSelectMarking($last_count)'>";
														echo "<div class='input-group input-table-group'>";
														echo "<input name='long_side[]' id='ls-$last_count' value='$d->long_side' $s_mark_longside type='text' class='form-control input-xs text-right input-table autonumber autofocus' data-v-max='10' data-v-min='0'>";
														echo "<span class='input-group-addon input-table-group-addon bootstrap-touchspin-postfix' >side</span>";
														echo "</div>";
														echo "<textarea name='marking_long_side[]' id='lm-$last_count' rows=3 $s_mark_long class='form-control input-xs input-table autosizeme'>$d->marking_long_side</textarea>";
//														echo "<input name='marking_long_side[]' value='$d->marking_long_side' style='width:200px;' type='text' class='form-control input-xs input-table'>";
														echo "</td>";
														//Kolom Marking On Short Side
														echo "<td class='bg-editable'>";
														echo "<input type='button' class='btn btn-block btn-xs green-stripe fontawesome-font' onClick='viewModalSelectMarking($last_count)' value='&#xf002 show history'>";
														echo "<div class='input-group input-table-group'>";
														echo "<input name='short_side[]' id='ss-$last_count' value='$d->short_side' $s_mark_shortside type='text' class='form-control input-xs text-right input-table autonumber autofocus' data-v-max='10' data-v-min='0'>";
														echo "<span class='input-group-addon input-table-group-addon bootstrap-touchspin-postfix'>side</span>";
														echo "</div>";
														echo "<textarea name='marking_short_side[]' id='sm-$last_count' rows=3 $s_mark_short class='form-control input-xs input-table autosizeme'>$d->marking_short_side</textarea>";
//														echo "<input name='marking_short_side[]' value='$d->marking_short_side' style='width:200px;' type='text' class='form-control input-xs input-table'>";
														echo "</td>";
														
														echo "</tr>";
														
														$last_count++;
													}
												}
												?>
											</tbody>
										</table>
										<?php 
											$po_format_final = ($po_format) ? $po_format : '000/MM/YY PSS';
											echo form_hidden('po_format', $po_format_final);
										?>
										
										<script type="text/javascript">
											$('#tbl_po .remove_detail').on('click', function(){
												var tr = $(this).closest('tr');
												var po_dtl_id	= $(this).attr('id');
	//											var usedsi = $(this).attr('used_si');
												var po_processed_shp = $('#po_processed_shp').val();

												if (po_processed_shp > 0){
	//											if (usedsi > 0){
	//												bootbox.alert('This product can not be removed, because already used in Shipping Instruction');
													$.bootstrapGrowl('<i class="fa fa-exclamation-circle"></i> This product can not be removed, because already used in Shipping Department.', {
	//													ele: 'body', // which element to append to
														type: 'danger', // (null, 'info', 'danger', 'success', 'warning')
														font_size: '13px', //tambahan untuk ukuran font, default ikut font size body
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
													return false;
												}

												bootbox.confirm('Are you sure want to remove this product?<br>This will remove the Shipping Instruction product',function(result){
													if (result){
														if (po_dtl_id !== '0'){
															$.ajax({
																type: "POST",
																url	: "<?php echo site_url('marketing-transaction/purchase-order/delete_detail')?>",
																data: {po_dtl_id : po_dtl_id},
																success : function(){
																	$.bootstrapGrowl('<i class="fa fa-info-circle"></i> Remove Product Success.', {
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
	//														updateRowOrder();
															re_calculate();
														});

													}
												});    
												return false;    
											});

											$('#tbl_po .remove_detail_add').on('click', function(){
												var tr = $(this).closest('tr');

												tr.fadeOut(400, function(){
													tr.remove();
	//												updateRowOrder();
													re_calculate();
												});
											});

											$('#tbl_po .remove_brand').on('click', function(){
												var urut	= $(this).attr('id');

												$('#br-'+urut).val('0');
												$('#brn-'+urut).val('');
											});

	//										$('.cbo_carton_remark_class').select2({
	//											allowClear	: true
	//										});
	//										
	//										$('.cbo_carton_remark_class').on('change', function(){
	//											var cboid	= $(this).attr('crid');
	//											var prev_val = $(this).attr('prev_value');
	//											var crem	= $(this).val();
	//											
	//											if (crem == ''){
	//												$('#carton_remark_'+cboid).val(prev_val);
	//											} else {
	//												$('#carton_remark_'+cboid).val(crem);
	//											}
	//										});
										</script>
										
									</div>
									
									
									
									<div class="form-body row">
										<div class="col-md-8">
<!--											<div class="form-group">											
												<label class="col-md-3 control-label" for="varchar">Palletized</label>
												<div class="col-md-1" style="padding-top: 10px;">													
													<?php 
//														$palletval = ($palletized == 1 ? true : false);
//														echo form_checkbox('palletized', 1, $palletval);
//														$extra_palletized = 'class="form-control" data-placeholder=""';
//														$option_palletized[0] = 'NO';
//														$option_palletized[1] = 'YES';													
//														echo form_dropdown('palletized', $option_palletized, $palletized, $extra_palletized);
													?>
												</div>
												<label class="col-md-2 control-label" for="varchar">Pallet Qty</label>
												<div class="col-md-2">
													<input type="text" name="pallet_qty" class="form-control text-right autonum_qty" value="<?php // echo $pallet_qty ?>">
												</div>
											</div>-->
											
											<div class="form-group">
												<label class="col-md-3 control-label padding-right-2" for="varchar">
													Certificate Required
													<a href="#modal_create" id="create_document" data-toggle="modal" class="pull-right" title="Create New Document">
														<i class="fa fa-plus-square"></i>
													</a>
												</label>
												<div class="col-md-9">
													<div class="doc-scroll" style="height: 200px;">
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
<!--												<span class="help-inline"><?php // echo form_error('total_before_disc') ?></span>-->
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
												<!--<span class="help-inline"><?php // echo form_error('total_disc') ?></span>-->
											</div>

											<div class="form-group">
												<label class="col-md-6 control-label" for="varchar">Freight</label>
												<div class="col-md-6" style="padding-left: 2px">
													<input type="text" class="form-control autonumber text-right" name="freight" id="freight" value="<?php echo $freight; ?>" onkeyup="re_calculate()"/>
												</div>
												<!--<span class="help-inline"><?php // echo form_error('freight') ?></span>-->
											</div>

											<div class="form-group">
												<label class="col-md-6 control-label" for="varchar">Tax</label>
												<div class="col-md-6" style="padding-left: 2px">
													<input type="text" class="form-control autonumber text-right" name="tax" id="tax" value="<?php echo $tax; ?>" onkeyup="re_calculate()"/>
												</div>
												<!--<span class="help-inline"><?php // echo form_error('tax') ?></span>-->
											</div>

											<div class="form-group">
												<label class="col-md-6 control-label" for="varchar">Total</label>
												<div class="col-md-6" style="padding-left: 2px">
													<input type="text" class="form-control text-right" name="grand_total" id="grand_total" value="<?php echo $grand_total; ?>" readonly="readonly" />
												</div>
												<!--<span class="help-inline"><?php // echo form_error('grand_total') ?></span>-->
											</div>

										</div>
										
									</div>
									
									<!--<div class="col-md-12">-->
										<div class="form-group">
											<label class="col-md-2 control-label padding-right-2" for="varchar">
												Remark
												<a href="#modal_previous" id="previous_remark" data-toggle="modal" class="pull-right" title="Previous Remark">
													<i class="fa fa-commenting"></i>
												</a>
											</label>
											<div class="col-md-10">
												<textarea rows="5" class="form-control autosizeme" name="po_remark" id="po_remark"><?php echo $po_remark; ?></textarea>
											</div>
										</div>
									<!--</div>-->
								</div>
								
							</div>
							
							<div class="form-actions">
								<div class="row">
									<div class="col-md-12">
										<input type="button" class="btn btn-default fontawesome-font" value="&#xf002 Search PO ..." data-target="#modal_find" data-toggle="modal">
										<?php 
										echo $btn_print;	// print po
										echo $btn_excel;	// export excel
										echo $btn_delete;	// delete po
										echo $btn_copy;		// duplicate po
										?>	
										<a href="<?php echo site_url('marketing-transaction/purchase-order')?>" type="button" class="btn red pull-right"><i class="fa fa-close"></i> Cancel</a>
										<!--<button type="submit" class="btn green pull-right" <?php // echo $disabled_btn ?>><i class="fa fa-save"></i> <?php echo $submit_caption?></button>-->	
										
										<button type="submit" class="btn green pull-right"><i class="fa fa-save"></i> <?php echo $submit_caption?></button>	
										
										<div class="col-md-2 pull-right">
											<?php 
												$extra_sm = 'id= "sales_marketing_id" class="form-control" ';
												$option_sm[''] = '';
												foreach($cbo_sales_marketing as $r):
													$option_sm[$r->userid] = $r->firstname.' '.$r->lastname;
												endforeach;
												echo form_dropdown('sales_marketing_id', $option_sm, $sales_marketing_id, $extra_sm);
											?>
										</div>
										<label class="col-md-1 control-label padding-right-2 pull-right" for="varchar">SM in charge</label>
										
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

<!-- Modal Detail Product -->
<div class="detail_product">
	<div id="modal_product" class="modal fade bs-modal-lg" role="dialog" tabindex="-1" data-backdrop="static" data-keyboard="false" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>					
					<h4 class="modal-title">Detail Product</h4>
				</div>

				<div class="modal-body padding-5">
					<div class="scroller" style="height:400px" data-always-visible="1" data-rail-visible1="1">
						<div class="row">
							<form class="form-horizontal">
								<div class="form-body">
									
									<div class="col-md-6">
										
										<div class="form-group">
											<label class="col-md-4 control-label label-sm">Product Description</label>
											<div class="col-md-5">
												<input type="text" class="form-control input-sm">
											</div>
										</div>
										
									</div>
								
								</div>
							</form>
						</div>
					</div>
				</div>

				<div class="modal-footer">
					<input type="button" class="btn btn-primary" value="OK">
					<button type="button" data-dismiss="modal" class="btn btn-default">Cancel</button>
					<!--<button type="button" data-dismiss="modal" class="btn blue">Select</button>-->
				</div>	
			</div>
		</div>
	</div>
</div>

<!-- Modal Add Product -->
<div id="add_product">
	
	<div id="modal_add_product" class="modal fade bs-modal-lg" role="dialog" tabindex="-1" data-backdrop="static" data-keyboard="false" aria-hidden="true">
	<!--<div id="modal_product" class="modal fade bs-modal-lg" role="dialog" tabindex="-1" aria-hidden="true">-->
		<div class="modal-dialog modal-full">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
					
					<div class="row">
<!--						<div class="col-md-5">
							<div class="input-group">					
								<input id="input_search" name="input_search" class="form-control" type="text" placeholder="Search Product" >
								<span class="input-group-btn">
									<button type="button" id="search_product" class="btn blue" style="border-width: 1px;">
										<i class="icon-magnifier"></i>
									</button>
								</span>
								
							</div>
							
						</div>-->
						<div class="col-md-3">
							<button type="button" id="search_product_contract" class="btn red-stripe" style="border-width: 1px;">
								<i class="icon-list"></i> Show Current Sales Contract's Product
							</button>
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
									<th class="sembunyi">Contract Detail ID</th>
									<th class="sembunyi">Contract Qty</th>
									<th class="sembunyi">PO Qty</th>
								</tr>
							</thead>
						</table>
						<div class="v-scroll">
							<div id="loading" class="loading" style="display: none; text-align: center;">
								LOADING...
							</div>
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

<!-- Script select_product -->
<script>
//	function get_product_info_in_contract(row){
//		var contract_hdr_id = <?php // echo $contract_hdr_id ?>;
//		
//		
//	}
	
	function select_product(){
		function getText(el){
            if (typeof el.textContent == 'string') return el.textContent;
            if (typeof el.innerText == 'string') return el.innerText;
        }
		
		var chk_arr =  document.getElementsByName("chk[]");
        var chk_length = chk_arr.length;
		
		var s_prod_desc		= 'style="width:300px;"';
		var s_prod_code		= 'style="width:180px;text-align:center;"';
		var s_brand			= 'style="width:100px;text-align:center;cursor:pointer;"';
		var s_factory		= '<?php echo $s_factory ?>';
		var s_packsize		= "style='width:150px;text-align:center;'";
		var s_uom			= "style='width:100px;text-align:center;'";
		var s_price			= "style='width:80px;'";
		var s_contract_qty	= "style='width:90px;'";
		var s_balance		= "style='width:110px;'";
		var s_qty			= "style='width:80px;'";
		var s_fobprice		= "style='width:110px;'";
		var s_total			= "style='width:100px;'";
		var s_sodium		= "style='width:180px;'";
		var s_fcl			= "style='width:50px;'";
		var s_pm_code		= "style='width:150px;text-align:center;cursor:pointer;'";
		var s_pm_qty		= "style='width:90px;'";
		var s_barcode		= "style='width:130px;'";
		var s_cart_remark	= "style='width:250px;'";
		var s_mark_longside	= "style='width:200px;'";
		var s_mark_long		= "style='width:250px;'";
		var s_mark_shortside	= "style='width:200px;'";
		var s_mark_short	= "style='width:250px;'";
		
		var roww = $('#tbl_po tr').length;
        if(roww == 1){
            var currentID = roww;
            var currentID2 = roww;
        }else{
            var idCFbefore			= $('#tbl_po tr:last input.brand-text').attr("id");
			var idCFbeforeLen		= idCFbefore.length;
            var getNumIdCFBefore    = idCFbefore.substr(3,(idCFbeforeLen-3));
            currentID		= parseInt(getNumIdCFBefore)+1;
            currentID2		= parseInt(getNumIdCFBefore)+1;
        }
		
		i = 0;
        n = 1;
		
		for(r=0;r < chk_length ;r++){
			if (chk_arr[r].checked == true){
				var nn = currentID++;
				var nnn = currentID2++;
				var unit_price = getText(document.getElementById('tbl_product').rows[i].cells[13]);
//				var unit_price_readonly = "";
				var unit_price_readonly =" readonly='readonly' ";
				var unit_price_editable = "";
				var fob_max = "";
				
//				if (unit_price > 0){
//					unit_price_readonly =" readonly='readonly' ";
//					unit_price_editable = "";
//					fob_max = "data-v-max='"+unit_price+"' "; //dihilangkan 18 okt 2016 (Pohlin dkk) - no restrict fob price
//				}
								
				var con_dtl_id			= getText(document.getElementById('tbl_product').rows[i].cells[12]);
				var con_brand_id		= getText(document.getElementById('tbl_product').rows[i].cells[17]);
				var con_brand_name		= getText(document.getElementById('tbl_product').rows[i].cells[18]);
				var con_brand_readonly	= " onClick='viewModalSelectBrand(this.id)' ";
				var con_brand_editable	= "bg-editable";
				var con_brand_remove	= "remove_brand";
				if (con_brand_id > 0){
					con_brand_readonly	=" ";
					con_brand_editable	= "";
					con_brand_remove	= "";
				}
				
				//Error
//				var cbo_carton_remark = <?php // echo form_dropdown('cbo_carton_remark[]', $option_carton_remark, '', $extra_carton_remark.' crid='+nn+' prev_value=""'); ?>
				
				$('#tbl_po > tbody:last-child').append(
					'<tr>'
						+'<td class="text-center bg-editable" style="vertical-align: top;">'
							+'<input type="button" style="width: 80px; margin-left: 5px; margin-top: 2px;" class="btn default btn-xs red-stripe remove_detail_add" used_si="0" value="Remove">'
							+'<input type="hidden" name="po_dtl_id[]" value="0">'
							+'<input type="hidden" name="product_id[]" value="'+getText(document.getElementById('tbl_product').rows[i].cells[1])+'">'
							+'<input type="hidden" name="detail_factory_id[]" class="f_id" value="'+getText(document.getElementById('tbl_product').rows[i].cells[7])+'">'
							+'<input type="hidden" name="detail_contract_hdr_id[]" value="<?php echo $contract_hdr_id ?>">'
							+'<input type="hidden" name="contract_dtl_id[]" value="'+con_dtl_id+'">'
							+'<input type="hidden" name="detail_po_format[]" value="'+getText(document.getElementById('tbl_product').rows[i].cells[20])+'">'
						+'</td>'
				
						+'<td class="bg-editable">'
						+'<input name="product_name[]" class="form-control input-xs input-table" '+s_prod_desc+' placeholder="Product Description"  value="'+getText(document.getElementById('tbl_product').rows[i].cells[2])+'" title="'+getText(document.getElementById('tbl_product').rows[i].cells[2])+'">'
						+'</td>'
				
						+'<td><input name="product_code[]" class="form-control input-xs input-table" '+s_prod_code+' placeholder="Product Code" readonly="readonly" value="'+getText(document.getElementById('tbl_product').rows[i].cells[3])+'" title="'+getText(document.getElementById('tbl_product').rows[i].cells[3])+'"></td>'
						
						+'<td class="'+con_brand_editable+'">'
							+'<input name="detail_brand_id[]" id="br-'+nn+'" value="'+con_brand_id+'" type="hidden" class="form-control brand-text input-xs input-table">'
							+'<div class="input-group" style="margin-bottom: 0px;">'
								+'<input name="brand[]" id="brn-'+nnn+'" '+s_brand+con_brand_readonly+' value="'+con_brand_name+'" class="form-control input-xs input-table" placeholder="Select Brand" readonly="readonly">'
								+'<div class="input-group-btn">'
									+'<input type="button" class="btn btn-xs fontawesome-font fa-grey fa-transparent '+con_brand_remove+'" title="Clear brand name" value="×" id="'+nn+'">'
								+'</div>'
							+'</div>'
						+'</td>'
				
						+'<td>'
						+'<input name="factory[]" value="'+getText(document.getElementById('tbl_product').rows[i].cells[4])+'" '+s_factory+' class="form-control input-xs input-table">'
						+'<input name="detail_factory_id[]" value="'+getText(document.getElementById('tbl_product').rows[i].cells[7])+'" type="hidden">'
						+'</td>'
				
						+'<td class="bg-editable">'
						+'<input name="detail_pack_size[]" value="'+getText(document.getElementById('tbl_product').rows[i].cells[8])+'" '+s_packsize+' class="form-control input-xs input-table">'
						+'</td>'
				
						+'<td><input name="uom_quantity_name[]" '+s_uom+' value="'+getText(document.getElementById('tbl_product').rows[i].cells[6])+'" class="form-control input-xs input-table" readonly="readonly"></td>'
						+'<td class="'+unit_price_editable+'"><input name="unit_price[]" value="'+unit_price+'" '+s_price+unit_price_readonly+'  type="text" class="form-control input-xs text-right input-table autonum_price autofocus" onkeypress="return isNumber(event)" onkeyup="calculate()"></td>'
						+'<td><input name="contract_qty[]" '+s_contract_qty+' value="'+getText(document.getElementById('tbl_product').rows[i].cells[14])+'" readonly="readonly" type="text" class="form-control input-xs text-right input-table"></td>'
						+'<td><input name="outstanding_qty[]" value="'+getText(document.getElementById('tbl_product').rows[i].cells[16])+'" '+s_balance+'  readonly="readonly" type="text" class="form-control input-xs text-right input-table"></td>'
						+'<td class="bg-editable">'
						+'<input name="qty[]" '+s_qty+' value="'+getText(document.getElementById('tbl_product').rows[i].cells[15])+'" \n\
								'+getText(document.getElementById('tbl_product').rows[i].cells[19])+' \n\
								type="text" class="form-control input-xs text-right input-table autofocus autonum_qty" data-v-min="0" onkeyup="calculate()">'
						+'</td>'
						+'<td class="bg-editable"><input name="fob_price[]" '+s_fobprice+fob_max+' type="text" class="form-control input-xs text-right input-table autonum_fob autofocus" data-v-min="0" onkeyup="calculate()"></td>'
						+'<td><input name="total[]" value="0.00" '+s_total+' type="text" class="form-control input-xs text-right input-table" readonly="readonly"></td>'
					
					//Kolom Pallet
						+'<td class="bg-editable text-center">'
						+'<input type="checkbox" name="detail_palletized['+con_dtl_id+']" value="'+con_dtl_id+'">'
						+'</td>'
				
						+'<td class="bg-editable">' 
						+'<input type="text" value="0" name="pallet_qty[]" class="form-control input-xs input-table text-right autonum autofocus" data-v-min="0"/>'
						+'</td>'
						
						+'<td class="bg-editable"><input name="sodium_metabisulphite[]" '+s_sodium+' value="" type="text" class="form-control input-xs input-table"></td>'
					//Kolom FCL
						+'<td>'
							+'<input name="fcl[]" readonly="readonly" type="text" '+s_fcl+' class="form-control input-xs text-right input-table autonumber" data-v-min="0">'
							+'<input name="container_20ft[]" type="hidden" value="'+getText(document.getElementById('tbl_product').rows[i].cells[9])+'">'
							+'<input name="container_40ft[]" type="hidden" value="'+getText(document.getElementById('tbl_product').rows[i].cells[10])+'">'
						+'</td>'
					//Kolom PM Label Code
						+'<td class="bg-editable">'
						+'<input name="pm_label_code[]" value="" id="pm-'+nn+'" '+s_pm_code+' onClick="view_modal_label_code(this.id)" class="form-control input-xs input-table" placeholder="Select PM Label Code" readonly="readonly">'
						+'</td>'
					//Kolom Label Quantity
						+'<td class="bg-editable">'
						+'<input type="hidden" name="per_packing[]" value="'+getText(document.getElementById('tbl_product').rows[i].cells[11])+'">'
						+'<input name="label_qty[]" '+s_pm_qty+' type="text" class="form-control input-xs input-table text-right autonum_qty">'
						+'</td>'
					//Kolom Carton Barcode
						+'<td class="bg-editable"><input name="carton_barcode[]" '+s_barcode+' type="text" class="form-control input-xs input-table text-right carton_barcode_class" autocomplete="off"></td>'
					//Kolom Carton Barcode Remark
						+'<td class="bg-editable">'
//						+cbo_carton_remark
						+"<input type='button' class='btn btn-block btn-xs purple-stripe fontawesome-font' value='&#xf002 show history' onClick='viewModalCartonRemark("+nn+")'>"
						+'<textarea name="carton_remark[]" id="carton_remark_'+nn+'" rows=4 '+s_cart_remark+' class="form-control input-xs input-table autosizeme carton_remark_class"></textarea>'
//						+'<input name="carton_remark[]" '+s_cart_remark+' type="text" class="form-control input-xs input-table text-right carton_remark_class">'				
						+'</td>'
					//Kolom Marking On Long Side
						+'<td class="bg-editable">'
						+'<input type="button" class="btn btn-block btn-xs green-stripe fontawesome-font" value="&#xf002 show history" onClick="viewModalSelectMarking('+nn+')">'
						+'<div class="input-group input-table-group">'
						+'<input name="long_side[]" '+s_mark_longside+' id="ls-'+nn+'" type="text" class="form-control input-xs text-right input-table autonumber" data-v-max="10" data-v-min="0">'
						+'<span class="input-group-addon input-table-group-addon bootstrap-touchspin-postfix">side</span>'
						+'</div>'
						+'<textarea name="marking_long_side[]" id="lm-'+nn+'" rows=3 '+s_mark_long+' class="form-control input-xs input-table autosizeme"></textarea>'
						+'</td>'
				
					//Kolom Marking On Short Side
						+'<td class="bg-editable">'
						+'<input type="button" class="btn btn-block btn-xs green-stripe fontawesome-font" value="&#xf002 show history" onClick="viewModalSelectMarking('+nn+')">'
						+'<div class="input-group input-table-group">'
						+'<input name="short_side[]" '+s_mark_shortside+' id="ss-'+nn+'" type="text" class="form-control input-xs text-right input-table autonumber" data-v-max="10" data-v-min="0">'
						+'<span class="input-group-addon input-table-group-addon bootstrap-touchspin-postfix">side</span>'
						+'</div>'
						+'<textarea name="marking_short_side[]" id="sm-'+nn+'" rows=3 '+s_mark_short+' class="form-control input-xs input-table autosizeme"></textarea>'
						+'</td>'
				
					+'</tr>'
				);
			}
			i++;
		}
		$('#modal_add_product').modal('hide');
		
		$('#tbl_po .remove_detail_add').on('click', function(){
			var tr = $(this).closest('tr');

			tr.fadeOut(400, function(){
				tr.remove();
				re_calculate();
			});
		});
		
		$('#tbl_po .remove_brand').on('click', function(){
			var urut	= $(this).attr('id');

			$('#br-'+urut).val('0');
			$('#brn-'+urut).val('');
		});
		
		po_mark.init();
						
//		$('.autonum_price').autoNumeric('init', {
//            mDec: 2
//        });

//        $('.autonum_qty').autoNumeric('init', {
//            mDec: 0
//        });
		
//		$('.autonum_fcl').autoNumeric('init',{
//			mDec	: 2
//		});

//		$('.autonumber').on('click', function(){
//			this.select();
//		});

//		$('.autonum_qty').autoNumeric('init',{
//			mDec	: 0
//		});

//		$('.autonum_fob').autoNumeric('init',{
//			mDec	: 2
//		});

//		$('.autonumber').autoNumeric('init');
		
//		$('.autofocus').on('click', function(){
//			this.select();
//		});
	}
</script>

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

<!-- Modal Previous -->
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

<!-- Modal Create -->
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

<!-- Script -->
<script>
	var cust_id = <?php echo $customer_id ?>;
	
	$('.carton_barcode_class').autocomplete({
		serviceUrl: "<?php echo site_url('marketing-transaction/autocomplete-po-barcode/'.$customer_id.'/') ?>"
	});
	
//	$('.carton_remark_class').Autocomplete({
//		serviceUrl: "<?php // echo site_url('marketing-transaction/autocomplete-po-carton-remark/'.$customer_id.'/') ?>"
//	});

//	$('select').select2({
//		allowClear	: true
//	});
	
//	$('#factory_list').select2();
//
//	$('#destination_id').select2({
//		allowClear	: true
//	});
//	
//	$('#local_currency').select2({
//		allowClear	: true
//	});
//	
//	$('#container_list').select2({
//		allowClear	: true
//	});
//	
//	$('#sales_marketing_id').select2({
//		allowClear	: true
//	});
//	
//	$('#rate_usd').autoNumeric('init',{
//		mDec	: 6
//	});
//	
//	$('#rate_sgd').autoNumeric('init',{
//		mDec	: 6
//	});
//	
//	//select all text on focused
//	$('.autofocus').on('click', function(){
//		this.select();
//	});
//	
//	$('.autonum_price').autoNumeric('init',{
//		mDec	: 3
//	});
//	
//	$('.autonum_fcl').autoNumeric('init',{
//		mDec	: 2
//	});
//	
//	$('.autonumber').on('click', function(){
//		this.select();
//	});
//	
//	$('.autonum_qty').autoNumeric('init',{
//		mDec	: 0
//	});
//	
//	$('.autonum_fob').autoNumeric('init',{
//		mDec	: 3
//	});
//	
//	$('.autonumber').autoNumeric('init');
//	
//	//	autosizeme => autosize textarea
//	$('.autosizeme').each(function(){
//		autosize(this);
//	});
//		
	$('.create_po').click(function(){
		var id = $(this).attr('id');
		window.location = "<?php echo site_url('marketing-transaction/purchase-order/create/?id=')?>"+id;
	});
//	
//	//fungsi ini untuk menghilangkan list data di modal
//	$('.modal').on('hidden.bs.modal', function(){
//		$('.v-scroll').html('');
//	});
	
	$('#search_product').on('click',function(){
		var param = $("#input_search").val();
		var p_id = $("input[name='product_id[]']").map(function(){ 
                    return this.value; 
                }).get();
		var f_id = $("input[name='detail_factory_id[]']").map(function(){ 
                    return this.value; 
                }).get();
		
				
		$.ajax({
			type: "POST",
			url : "<?php echo site_url('marketing_misc/search_product/po')?>",
			beforeSend : function(){
				$(".loading").show();
			},
			data: {
				"product_id[]"	: p_id,
				"factory_id[]"	: f_id,
				"param"			: param
			},
			success: function(msg){
				$('#table_container').html(msg);
			},
			complete:function(){
				$('.loading').hide();
			}
		});
		return false;
	});
	
	$('#search_product_contract').on('click', function(){
		var contract_hdr_id = <?php echo $contract_hdr_id ?>;
		var f_id = $("input[name='detail_factory_id[]']").map(function(){ 
                    return this.value; 
                }).get();
				
		$.ajax({
			type: "POST",
			url : "<?php echo site_url('marketing_transaction/purchase_order/search_contract_product')?>",
			beforeSend : function(){
				$(".loading").show();
			},
			data: {
				"factory_id[]"	: f_id,
				"contract_hdr_id" : contract_hdr_id
			},
			success: function(msg){
				$('#table_container').html(msg);
			},
			complete:function(){
				$('.loading').hide();
			}
		});
	});
	
	$('#search_find').click(function(){
		var find = {find:$("#input_find").val()};
		$.ajax({
			type: "POST",
			url : "<?php echo site_url('marketing_transaction/purchase_order/find')?>",
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
			url	: "<?php echo site_url('marketing_transaction/purchase_order/previous_remark')?>",
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
		$('#po_remark').append('\n');
		$('#po_remark').append($('#selected_remark').val());		
		$('#modal_previous').modal('hide');
	});
	
	$('#btn_use_remark').click(function(){
		var sel_rem = $('#selected_remark').val();
		if (sel_rem == ''){
			bootbox.alert('Remark are empty!');
			return false;
		};
		$('#po_remark').text($('#selected_remark').val());
		$('#po_remark').append('\n');		
		$('#modal_previous').modal('hide');
	});
	
	$('#btn_delete').click(function(){
		var headerid = $(this).attr("headerid");
		var po_no = $(this).attr("po_no");
		var used_si = $(this).attr("used_si");
		
		if (used_si > 0){
			$.bootstrapGrowl("<h5><i class='fa fa-warning'></i>  This PO can't be deleted because Shipping Instruction already created using this PO.</h5>", {
//				ele: 'body', // which element to append to
				type: 'danger', // (null, 'info', 'danger', 'success', 'warning')
				offset: {
					from: 'top',
					amount: 250
				}, // 'top', or 'bottom'
				align: 'center', // ('left', 'right', or 'center')
				width: 'auto', // (integer, or 'auto')
				font_size: '13px',
				delay: 5000, // Time while the message will be displayed. It's not equivalent to the *demo* timeOut!
				allow_dismiss: true, // If true then will display a cross to close the popup.
				stackup_spacing: 10 // spacing between consecutively stacked growls.
			});
			return false;
		}
		
		bootbox.confirm('Are you sure want to delete PO number <h3>'+po_no+' ?</h3>',function(result){
			if (result){
				$.ajax({
					url:"<?php echo site_url('marketing_transaction/purchase_order/delete');?>",
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
						return location.href = "<?php echo site_url('marketing_transaction/purchase_order');?>";
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
						return location.href="<?php echo site_url('marketing_transaction/purchase_order');?>";
					}
				});
			} else {
				console.log("Declined delete PO data.");
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
	
</script>

<!-- Modal Brand -->
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

<!-- Modal Carton Remark -->
<div id="carton_remark_container">
	<div id="modal_carton_remark" class="modal fade" role="dialog" tabindex="-1" data-toggle="modal" data-keyboard="false" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
					<h4 class="modal-title">Carton Remark History</h4>
				</div>
				<div class="modal-body">
					<input class="form-control input-sm" id="id-carton-remark-this" type="hidden" value="" readonly>
					<div id="pre_carton_remark"> Loading... </div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn default" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Modal Marking -->
<div id="marking_container">
	<div id="modal_marking" class="modal fade" role="dialog" tabindex="-1" data-toggle="modal" data-keyboard="false" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<input class="form-control input-sm" id="id-marking-this" type="hidden" value="" readonly>
				<div id="pre_marking" class="pre_marking">
					Please Wait...
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Brand -->
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
        
//        var thisID				= $('#id-brand-this').val();
//        var getNumIdCFBefore    = thisID.substr(4,1);
//        var currentID           = parseInt(getNumIdCFBefore);
		
		var thisID				= $('#id-brand-this').val();		// ex. 'brn-10'
		var IDlen				= thisID.length;					// IDlen dari brn-10 => 6 (6 karakter)
        var getNumIdCFBefore    = thisID.substr(4,(IDlen - 4));		// ambil angkanya saja dari brn-10 => thisID.substr(4, 2)
        var currentID           = parseInt(getNumIdCFBefore);
        $('#'+thisID).val(getText(document.getElementById('tbl-selectBrand').rows[$r].cells[1]));
        $('#br-'+currentID).val(getText(document.getElementById('tbl-selectBrand').rows[$r].cells[0]));
        
        $('#modal-select-brand').modal('hide');
    }
	
	function viewModalCartonRemark(id){
        $('#id-carton-remark-this').val(id);
        $.ajax({
            url: "<?php echo site_url('marketing_transaction/loadDataAjaxForCartonRemark/'.$customer_id) ;?>",
            dataType: 'html',
            success: function (data, textStatus, jqXHR) {
                $('#pre_carton_remark').html(data);
            }
        });
        $('#modal_carton_remark').modal('show');
    }
	
	function pilih_carton_remark(x){
        function getText(el) {
            if (typeof el.textContent == 'string')
                return el.textContent;
            if (typeof el.innerText == 'string')
                return el.innerText;
        }
        $r = x.rowIndex;
        
        var thisID				= $('#id-carton-remark-this').val();
//        var getNumIdCFBefore    = thisID.substr(3,1);
//        var currentID           = parseInt(getNumIdCFBefore);

        $('#carton_remark_'+thisID).text(getText(document.getElementById('tbl_carton_remark').rows[$r].cells[1]));

		$('#modal_carton_remark').modal('hide');		
    }
	
	function viewModalSelectMarking(id){
		$('#id-marking-this').val(id);
	
		$.ajax({
            url: "<?php echo site_url('marketing_transaction/loadDataAjaxForMarking/'.$customer_id);?>/"+id,
            dataType: 'html',
            success: function (data, textStatus, jqXHR) {
                $('#pre_marking').html(data);
            }
        });
        $('#modal_marking').modal('show');
    }
	
</script>

<!-- Select PM Label Code -->
<div class="modal fade" id="modal-label-code" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog" style="width: 50%;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Select PM Label Code</h4>
            </div>
            <div class="modal-body">
                <input class="form-control input-sm" id="id-label-code-this" type="hidden" value="" readonly>
                <div id="content_label_code" style="text-align: center;"> Loading ... Please Wait ... </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn default" data-dismiss="modal">Close</button>
            </div>
        </div>
		
    </div>
</div>

<script>
	function view_modal_label_code(id){
        $('#id-label-code-this').val(id);
        $.ajax({
            url: "<?php echo site_url('marketing_misc/loadDataAjaxForLabelCode');?>",
            dataType: 'html',
            success: function (data, textStatus, jqXHR) {
                $('#content_label_code').html(data);
            }
        });
        $('#modal-label-code').modal('show');
    }
	
    function pilih_label_code(x){
        function getText(el) {
            if (typeof el.textContent == 'string')
                return el.textContent;
            if (typeof el.innerText == 'string')
                return el.innerText;
        }
        $r = x.rowIndex;
        
        var thisID				= $('#id-label-code-this').val();
		var IDLen				= thisID.length;
        var getNumIdCFBefore    = thisID.substr(3,(IDLen-3));
        var currentID           = parseInt(getNumIdCFBefore);

        $('#pm-'+currentID).val(getText(document.getElementById('tbl-select-label-code').rows[$r].cells[0]));

		$('#modal-label-code').modal('hide');
		
		isi_label_code_qty();
    }
	
	function isi_label_code_qty(){
		$('#tbl_po tr').each(function() {
			var qty			= remove_thousand_separator($(this).find("input[name='qty[]']").val());
			var per_pack	= remove_thousand_separator($(this).find("input[name='per_packing[]']").val());
			var pm_label_code = $(this).find("input[name='pm_label_code[]']").val();
			var label_qty	= qty * per_pack;

			if (pm_label_code != ''){
				$(this).find("input[name='label_qty[]']").val(number_format(label_qty, 0));
			}
		});
	}
</script>

<script>
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
		var arr_container_list = $('#container_list').val().split('|');
		var container_size = arr_container_list[1];
        
        $('#tbl_po tr').each(function() {
            var qty			= remove_thousand_separator($(this).find("input[name='qty[]']").val());
//			var estimated	= $(this).find("input[name='estimated_qty[]']").val();
			var fob_price	= remove_thousand_separator($(this).find("input[name='fob_price[]']").val());
			var per_pack	= remove_thousand_separator($(this).find("input[name='per_packing[]']").val());
			var container_20 = remove_thousand_separator($(this).find("input[name='container_20ft[]']").val());
			var container_40 = remove_thousand_separator($(this).find("input[name='container_40ft[]']").val());
			var fcl =  $(this).find('input[name="fcl[]"]').val();
			
			var total_row	= qty * fob_price;
						
			var pm_label_code = $(this).find("input[name='pm_label_code[]']").val();
			var label_qty	= qty * per_pack;
			
			if (container_size == 20){
				if (container_20 > 0){
					fcl = qty/container_20;
				}
			}
			
			if (container_size == 40){
				if (container_40 > 0){
					fcl = qty/container_40;
				}
			}
			
            $(this).find("input[name='total[]']").val(number_format(total_row, 2));
            $(this).find("input[name='fcl[]']").val(number_format(fcl, 2));
			
			if (pm_label_code != ''){
				$(this).find("input[name='label_qty[]']").val(number_format(label_qty, 0));
			}
		
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
	
	function change_remark(){
        document.getElementById("po_remark").value = document.getElementById("pre_remark").value;    
		$('#modal_previous').modal('hide');
    }
	
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

	function POValidate()
	{
		var status_id = $('#status_id').val();
		
		if (status_id == 3){
			$.bootstrapGrowl('<i class="fa fa-exclamation-circle"></i>  Purchase Order Status Are <strong>CANCELED</strong>', {
				ele: 'body', // which element to append to
				type: 'danger', // (null, 'info', 'danger', 'success', 'warning')				
				offset: {
					from: 'top',
					amount: 250
				}, // 'top', or 'bottom'				
				align: 'center', // ('left', 'right', or 'center')
				width: 'auto', // (integer, or 'auto')
				font_size: '13px',
				delay: 7000, // Time while the message will be displayed. It's not equivalent to the *demo* timeOut!
				allow_dismiss: true, // If true then will display a cross to close the popup.
				stackup_spacing: 20 // spacing between consecutively stacked growls.
			});
			return false;
		}
		
		if (status_id == 8){
			$.bootstrapGrowl('<i class="fa fa-exclamation-circle"></i>  Purchase Order Status Are <strong>SHIPPED</strong>', {
				ele: 'body', // which element to append to
				type: 'danger', // (null, 'info', 'danger', 'success', 'warning')				
				offset: {
					from: 'top',
					amount: 250
				}, // 'top', or 'bottom'				
				align: 'center', // ('left', 'right', or 'center')
				width: 'auto', // (integer, or 'auto')
				font_size: '13px',
				delay: 7000, // Time while the message will be displayed. It's not equivalent to the *demo* timeOut!
				allow_dismiss: true, // If true then will display a cross to close the popup.
				stackup_spacing: 20 // spacing between consecutively stacked growls.
			});
			return false;
		}
		
		var duplicated_po = $('#duplicated_po').val();
		var duplicated_po_msg = $('#duplicated_po_msg').val();
				
		if (duplicated_po == 1){
			$.bootstrapGrowl('<i class="fa fa-exclamation-circle"></i>  '+duplicated_po_msg, {
				ele: 'body', // which element to append to
				type: 'danger', // (null, 'info', 'danger', 'success', 'warning')				
				offset: {
					from: 'top',
					amount: 250
				}, // 'top', or 'bottom'				
				align: 'center', // ('left', 'right', or 'center')
				width: 'auto', // (integer, or 'auto')
				font_size: '13px',
				delay: 7000, // Time while the message will be displayed. It's not equivalent to the *demo* timeOut!
				allow_dismiss: true, // If true then will display a cross to close the popup.
				stackup_spacing: 20 // spacing between consecutively stacked growls.
			});
			return false;
		}
		
//		var po_processed_shp = $('#po_processed_shp').val();
//		if (po_processed_shp > 0){
//			$.bootstrapGrowl("<h5><i class='fa fa-warning'></i>  This PO can't be changed because Shipping Department already used this PO.</h5>", {
////				ele: 'body', // which element to append to
//				type: 'danger', // (null, 'info', 'danger', 'success', 'warning')
//				offset: {
//					from: 'top',
//					amount: 250
//				}, // 'top', or 'bottom'
//				align: 'center', // ('left', 'right', or 'center')
//				width: 'auto', // (integer, or 'auto')
//				font_size: '13px',
//				delay: 5000, // Time while the message will be displayed. It's not equivalent to the *demo* timeOut!
//				allow_dismiss: true, // If true then will display a cross to close the popup.
//				stackup_spacing: 10 // spacing between consecutively stacked growls.
//			});
//			return false;
//		}
		
		var keluar = 0;
		var factory_sebelum = '';
		var factory_id = $('#factory_id').val();
		
		$('#tbl_po tr').each(function() {
			var qty			= remove_thousand_separator($(this).find("input[name='qty[]']").val());
			var fob_price	= remove_thousand_separator($(this).find("input[name='fob_price[]']").val());
			var unit_price	= remove_thousand_separator($(this).find("input[name='unit_price[]']").val());
			
			if (qty == 0 || qty == ''){
				$.bootstrapGrowl('<i class="fa fa-exclamation-circle"></i>  Quantity or FOB Factory Price can not be empty or 0.', {
					ele: 'body', // which element to append to
					type: 'danger', // (null, 'info', 'danger', 'success', 'warning')				
					offset: {
						from: 'top',
						amount: 250
					}, // 'top', or 'bottom'				
					align: 'center', // ('left', 'right', or 'center')
					width: 'auto', // (integer, or 'auto')
					font_size: '13px',
					delay: 3000, // Time while the message will be displayed. It's not equivalent to the *demo* timeOut!
					allow_dismiss: true, // If true then will display a cross to close the popup.
					stackup_spacing: 20 // spacing between consecutively stacked growls.
				});				
				keluar = 1;
			}
			
			if (fob_price > unit_price){
//				$.bootstrapGrowl('<i class="fa fa-exclamation-circle"></i> FOB Factory Price should not greater than Unit Price.', {
//					ele: 'body', // which element to append to
//					type: 'danger', // (null, 'info', 'danger', 'success', 'warning')				
//					offset: {
//						from: 'top',
//						amount: 250
//					}, // 'top', or 'bottom'				
//					align: 'center', // ('left', 'right', or 'center')
//					width: 'auto', // (integer, or 'auto')
//					font_size: '13px',
//					delay: 3000, // Time while the message will be displayed. It's not equivalent to the *demo* timeOut!
//					allow_dismiss: true, // If true then will display a cross to close the popup.
//					stackup_spacing: 20 // spacing between consecutively stacked growls.
//				});				
//				keluar = 1;
			}
						
			var factory_sekarang = $(this).find("input[name='factory[]']").val();
			var detail_factory_id = $(this).find("input[name='detail_factory_id[]']").val();
			
			if (factory_sebelum !== ''){
				if (factory_sekarang !== factory_sebelum){
					$.bootstrapGrowl('<i class="fa fa-exclamation-circle"></i> Oops, you create PO with different factory.', {
						ele: 'body', // which element to append to
						type: 'danger', // (null, 'info', 'danger', 'success', 'warning')				
						offset: {
							from: 'top',
							amount: 250
						}, // 'top', or 'bottom'				
						align: 'center', // ('left', 'right', or 'center')
						width: 'auto', // (integer, or 'auto')
						font_size: '13px',
						delay: 3000, // Time while the message will be displayed. It's not equivalent to the *demo* timeOut!
						allow_dismiss: true, // If true then will display a cross to close the popup.
						stackup_spacing: 20 // spacing between consecutively stacked growls.
					});				
					keluar = 1;
				}
				factory_sebelum = factory_sekarang;
			}
			
			if (detail_factory_id != undefined){
				if (factory_id !== detail_factory_id){				
					$.bootstrapGrowl('<i class="fa fa-exclamation-circle"></i> Factory and Product Factory are different, Please check again!', {
						ele: 'body', // which element to append to
						type: 'danger', // (null, 'info', 'danger', 'success', 'warning')				
						offset: {
							from: 'top',
							amount: 250
						}, // 'top', or 'bottom'				
						align: 'center', // ('left', 'right', or 'center')
						width: 'auto', // (integer, or 'auto')
						font_size: '13px',
						delay: 3000, // Time while the message will be displayed. It's not equivalent to the *demo* timeOut!
						allow_dismiss: true, // If true then will display a cross to close the popup.
						stackup_spacing: 20 // spacing between consecutively stacked growls.
					});				
					keluar = 1;
					return false;
				}
			}
		});
		
		
		if (keluar == 1){
			return false;
		}
		
//		var duplicated_po = $('#duplicated_po').val();
//				
//		if (duplicated_po){
//			$.bootstrapGrowl('<i class="fa fa-exclamation-circle"></i>  PO number <strong>'+duplicated_po+'</strong> already exists.', {
//				ele: 'body', // which element to append to
//				type: 'danger', // (null, 'info', 'danger', 'success', 'warning')				
//				offset: {
//					from: 'top',
//					amount: 250
//				}, // 'top', or 'bottom'				
//				align: 'center', // ('left', 'right', or 'center')
//				width: 'auto', // (integer, or 'auto')
//				font_size: '13px',
//				delay: 5000, // Time while the message will be displayed. It's not equivalent to the *demo* timeOut!
//				allow_dismiss: true, // If true then will display a cross to close the popup.
//				stackup_spacing: 20 // spacing between consecutively stacked growls.
//			});
//			return false;
//		}
		
		var product_count =  document.getElementById("tbl_po").getElementsByTagName("tbody")[0].getElementsByTagName("tr").length;
		
		if (product_count < 1){
			$.bootstrapGrowl('<i class="fa fa-exclamation-circle"></i>  You have not added product! Please select at least 1 product.', {
				ele: 'body', // which element to append to
				type: 'danger', // (null, 'info', 'danger', 'success', 'warning')				
				offset: {
					from: 'top',
					amount: 250
				}, // 'top', or 'bottom'				
				align: 'center', // ('left', 'right', or 'center')
				width: 'auto', // (integer, or 'auto')
				font_size: '13px',
				delay: 5000, // Time while the message will be displayed. It's not equivalent to the *demo* timeOut!
				allow_dismiss: true, // If true then will display a cross to close the popup.
				stackup_spacing: 20 // spacing between consecutively stacked growls.
			});
			return false;
		}
//		return false;
	}
</script>

<script src="<?php echo base_url();?>assets/marketing/po_mark.js"></script>
<script>
	jQuery(document).ready(function() { 
		po_mark.init();
	});		
</script>