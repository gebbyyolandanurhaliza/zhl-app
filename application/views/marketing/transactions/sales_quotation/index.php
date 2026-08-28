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
								<div class="col-md-6">	
									
									<?php echo form_hidden('quotation_hdr_id', $quotation_hdr_id)?>
									
									<div class="form-group">
										<label class="col-md-3 control-label" for="varchar">Sales Quotation No</label>
										<div class="col-md-5">
											<input readonly="readonly" type="text" class="form-control" name="quotation_number" id="quotation_number" value="<?php echo $quotation_number ?>" placeholder="Auto Generate Once Saved" />
										</div>	
										<span class="help-inline"><?php echo form_error('quotation_number') ?></span>
									</div>
									
									<div class="form-group required">
										<label class="col-md-3 control-label" for="varchar">Customer</label>
										<div class="col-md-5">
											<?php
											$extra_customer = 'required id="customer_id" class="form-control select2me" data-placeholder="Select Customer..."';
											$option_customer[''] = '';
											foreach($cbo_customer as $r):
												$option_customer[$r->customer_id] = $r->customer_code.' - '.$r->customer_name;
											endforeach;
											echo form_dropdown('customer_id', $option_customer, $customer_id, $extra_customer);
											?>											
										</div>
										<span class="help-inline"><?php echo form_error('customer_id') ?></span>
									</div>

									<script type="text/javascript">
										$('#customer_id').change(function(){
											var customer_id = {customer_id:$("#customer_id").val()};
											$.ajax({
												type: "POST",
												url : "<?php echo site_url('marketing_misc/sales_quotation_get_customer')?>",
												data: customer_id,
												success: function(msg){
													$('#div_customer').html(msg);
												}
											});
											
											$.ajax({
												type: "POST",
												url : "<?php echo site_url('marketing_misc/get_payterm_by_customer')?>",
												data: customer_id,
												success: function(msg){
													$('#payterm-container').html(msg);
												}
											});
										});
									</script>

									<div id="div_customer">
										<div class="form-group">
											<label class="col-md-3 control-label" for="varchar">Customer Name</label>
											<div class="col-md-5">
												<input readonly="readonly" type="text" class="form-control" name="customer_name" id="customer_name" value="<?php echo $customer_name; ?>" />
											</div>
											<span class="help-inline"><?php echo form_error('customer_name') ?></span>
										</div>

										<div class="form-group">
											<label class="col-md-3 control-label" for="varchar">Contact Person</label>
											<div class="col-md-5">
												<input readonly="readonly" type="text" class="form-control" name="customer_contact_name" id="customer_contact_name" value="<?php echo $customer_contact_name; ?>" />
											</div>
											<span class="help-inline"><?php echo form_error('customer_contact_name') ?></span>
										</div>

										<div class="form-group">
											<label class="col-md-3 control-label" for="varchar">Customer Ref. No.</label>
											<div class="col-md-5">
												<input readonly="readonly" type="text" class="form-control" name="customer_reference" id="customer_reference" value="<?php echo $customer_reference; ?>" />
											</div>
											<span class="help-inline"><?php echo form_error('customer_reference') ?></span>
										</div>
										
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
									
									<div class="form-group required">
										<label class="col-md-3 control-label" for="varchar">Local Currency</label>
										<div class="col-md-5">
											<?php 
												$extra_currency = 'required id= "local_currency" class="form-control select2me" data-placeholder="Local Currency..."';
												$option_currency[''] = '';
												foreach($cbo_currency as $r):
													$option_currency[$r->currency_id] = $r->currency_symbol.' - '.$r->currency_name;													
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
												<div id="div_rate_usd">
													<input required type="text" class="form-control text-right" name="rate_usd" id="rate_usd" placeholder="0.000000" value="<?php echo $rate_usd; ?>" title="6 digits decimal" />
												</div>
											</div>
										</div>

										<div class="form-group required">
											<label class="col-md-3 control-label" for="varchar">Rate to SGD</label>
											<div class="col-md-3">
												<div id="div_rate_sgd">
													<input required type="text" class="form-control text-right" name="rate_sgd" id="rate_sgd" placeholder="0.000000" value="<?php echo $rate_sgd; ?>" title="6 digits decimal" />
												</div>
											</div>
										</div>
									</div>
									
									<div class="form-group">
										<label class="col-md-3 control-label" for="varchar">Agent Commission</label>
										<div class="col-md-3">											
											<input type="text" class="form-control text-right" name="agen_commission" id="agen_commission" data-a-sign=" %" data-p-sign="s" data-v-max="100" placeholder="0.00 %" value="<?php echo $agen_commission; ?>"/>
										</div>
										<span class="help-inline">
											<!--step 0.01-->
											<?php // echo form_error('agen_commission') ?>
										</span>
									</div>
								</div>

								<div class="col-md-6 col-md-push-2">
									<div class="form-group required">
										<label class="col-md-3 control-label" for="varchar">Sales Person</label>
										<div class="col-md-5">
											<?php 
												$extra_sales = 'required id= "sales_id" class="form-control select2me" data-placeholder="Sales Person..."';
												$option_sales[''] = '';
												foreach($cbo_sales as $r):
													$option_sales[$r->userid] = $r->firstname.' '.$r->lastname;
												endforeach;
												echo form_dropdown('sales_id', $option_sales, $sales_id, $extra_sales);
												
//												$extra_marketing_id = 'id= "marketing_id" class="form-control select2me" data-placeholder="Marketing Staff Code..."';
//												$option_marketing_id[''] = '';
//												foreach($cbo_marketing as $r):
//													$option_marketing_id[$r->marketing_id] = $r->marketing_code.' - '.$r->marketing_name;
//												endforeach;
//												echo form_dropdown('marketing_id', $option_marketing_id, $marketing_id, $extra_marketing_id);
											?>
										</div>
										<span class="help-inline"><?php echo form_error('marketing_staff_code') ?></span>
									</div>

									<div class="form-group">
										<label class="col-md-3 control-label" for="varchar">Status</label>
										<div class="col-md-5">
											
											<?php
												$extra_status = 'disabled="disabled" id="sales_status" class="form-control select2me" data-placeholder="Status..."';
												$option_status[''] = '';
												foreach($cbo_status as $r):
													$option_status[$r->status_id] = $r->status_name;
												endforeach;
												echo form_dropdown('sales_status', $option_status, $status_id, $extra_status);
											?>
											<input type="hidden" name="status_id" id="status_id" value="<?php echo $status_id; ?>" />
										</div>
										<span class="help-inline"><?php echo form_error('status_id') ?></span>
									</div>

									<div class="form-group">
										<label class="col-md-3 control-label" for="varchar">First Posting Date</label>
										<div class="col-md-5">
											<div class="input-group date date-picker" data-date-format="mm-dd-yyyy" >
												<span class="input-group-btn">
													<button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
												</span>
												<input type="text" name="posting_date" id="posting_date" class="form-control" readonly="" value="<?php echo $posting_date; ?>" title="date format : mm/dd/yyyy">												
											</div>	
											<!--<input type="text" class="form-control date date-picker" data-date="12-02-2012" data-date-format="mm-dd-yyyy" name="posting_date" id="posting_date" placeholder="First Posting Date" value="<?php echo $posting_date; ?>" title="date format : mm/dd/yyyy" />-->
										</div>
										<span class="help-inline"><?php echo form_error('posting_date') ?></span>
									</div>
									
									<div class="form-group">
										<label class="col-md-3 control-label" for="varchar">Validity Date</label>
										<div class="col-md-5">
											<div class="input-group date date-picker" data-date-format="mm-dd-yyyy" >
												<span class="input-group-btn">
													<button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
												</span>
												<input type="text" name="validity_date" id="validity_date" class="form-control" readonly="" value="<?php echo $validity_date; ?>" title="date format : mm/dd/yyyy">												
											</div>	
											<!--<input type="text" class="form-control date date-picker" data-date="12-02-2012" data-date-format="mm-dd-yyyy" name="posting_date" id="posting_date" placeholder="First Posting Date" value="<?php echo $posting_date; ?>" title="date format : mm/dd/yyyy" />-->
										</div>
										<span class="help-inline"><?php echo form_error('validity_date') ?></span>
									</div>

									<div class="form-group">
										<label class="col-md-3 control-label" for="varchar">Document Date</label>
										<div class="col-md-5">
											<div class="input-group date date-picker" data-date-format="mm-dd-yyyy" >
												<span class="input-group-btn">
													<button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
												</span>
												<input type="text" name="document_date" id="document_date" class="form-control" readonly="" value="<?php echo $document_date; ?>" title="date format : mm-dd-yyyy">												
											</div>	
											<!--<input type="text" class="form-control date date-picker" data-date="12-02-2012" data-date-format="mm-dd-yyyy" name="document_date" id="document_date" placeholder="Document Date" value="<?php echo $document_date; ?>" title="date format : mm/dd/yyyy" />-->
										</div>
										<span class="help-inline"><?php echo form_error('document_date') ?></span>
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
													<a class="btn btn-primary btn-large" data-target="#modal_product" data-toggle="modal">
														<i class="fa fa-plus"></i>
														Add Product ...
													</a>
												</div>
											</div>
										</div>
									</div>

									<div class="table-responsive">
										<table class="table table-bordered table-condensed table-detail" id="tbl_quotation">
											<thead>
												<tr>
													<th scope="col" style="width:50px !important">#</th>
													<th scope="col">Product Description</th>
													<th scope="col">Product Code</th>
													<th scope="col">Product Brand</th>
													<th scope="col">UOM</th>													
													<th scope="col">Price</th>
													<th scope="col">Quantity</th>
													<th scope="col">Total Amount</th>
												</tr>
											</thead>
											<tbody>
												<?php
												if ($detail){
													foreach ($detail as $d){
														$sub_total = $d->price * $d->quantity;
														
														echo '<tr>';
														echo '<td class="text-center w-50 bg-editable valign-middle">';
														echo '<input type="button" class="btn default btn-xs red-stripe" onclick="removeRow(this)" value="Remove">';
														echo '<input type="hidden" name="product_id[]" class="p_id" value="'.$d->product_id.'">';
														echo '<input type="hidden" name="factory_id[]" class="f_id" value="'.$factory_id.'">';
														echo '<input type="hidden" name="quotation_dtl_id[]" value="'.$d->quotation_dtl_id.'">';
														echo '</td>';
														echo '<td class="w-300"><input name="product_name[]" class="form-control input-xs input-table" placeholder="Product Name" readonly="readonly" value="'.$d->product_name.'" title="'.$d->product_name.'"></td>';
														echo '<td class="w-180"><input name="product_code[]" class="form-control input-xs input-table" placeholder="Product Code" readonly="readonly" value="'.$d->product_code.'" title="'.$d->product_code.'"></td>';
														echo '<td class="w-180"><input name="brand[]" value="'.$d->brand_name.'" class="form-control input-xs input-table" readonly="readonly"></td>';
														echo '<td class="w-150"><input name="uom[]" value="'.$d->uom_quantity_name.'" class="form-control input-xs input-table" readonly="readonly"></td>';
														echo '<td class="w-100 bg-editable"><input required name="price[]" value="'.$d->price.'" type="text" class="form-control input-xs text-right input-table autonum_price" onkeyup="calculate()"></td>';
														echo '<td class="w-100 bg-editable"><input required name="qty[]" value="'.$d->quantity.'" type="text" class="form-control input-xs text-right input-table autonum_qty" data-v-min="0" onkeyup="calculate()"></td>';
														echo '<td class="w-130"><input name="total[]" value="'.number_format($sub_total, 2,'.',',').'" type="text" class="form-control input-xs text-right input-table" readonly="readonly">';
														echo '</tr>';
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
										<div class="col-md-9">
											<div id="payterm-container">
											<?php 
												$extra_payterm = 'id="payment_term" class="form-control select2me"';
												$option_payterm[''] = '';
												foreach($cbo_payterm as $r):
													$option_payterm[$r->payment_term] = $r->payment_term;													
												endforeach;
												echo form_dropdown('payment_term', $option_payterm, $payment_term, $extra_payterm);
											?>
											</div>											
										</div>
									</div>
									
									<div class="form-group">
										<label class="col-md-3 control-label" for="varchar">Remark</label>
										<div class="col-md-9">
											<textarea rows="5" class="form-control autosizeme" name="sales_remark" id="sales_remark"><?php echo $sales_remark; ?></textarea>
										</div>
										<span class="help-inline"><?php echo form_error('sales_remark') ?></span>
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
											<!--<div class="input-group input-icon input-icon-sm right">-->
												<!--<i class="fa fa-percent"></i>-->
												<input type="text" class="form-control autonumber text-right" name="discount" id="discount" data-a-sign=" %" data-p-sign="s" data-v-max="100" placeholder="0.00 %" value="<?php echo $discount; ?>" onkeyup="re_calculate()"/>
											<!--</div>-->
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
											<input readonly="readonly" type="text" class="form-control text-right" name="final_total" id="final_total" value="<?php echo $final_total; ?>" />
										</div>
										<span class="help-inline"><?php echo form_error('final_total') ?></span>
									</div>
									
								</div>
							</div>

							<div class="form-actions">
								<div class="row">
									<div class="col-md-12">
										<input type="button" class="btn btn-default fontawesome-font" value="&#xf002 Find ..." data-target="#modal_find" data-toggle="modal">
										<?php // echo $btn_print ?>
										<?php echo $btn_delete ?>
										<a href="<?php echo site_url('marketing_transaction/sales_quotation')?>" type="button" class="btn red pull-right"><i class="fa fa-close"></i> Cancel</a>
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
	<div id="modal_find" class="modal fade" role="dialog" tabindex="-1" data-backdrop="static" data-keyboard="false" aria-hidden="true" data-width="75%">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
					<div class="row">
						<div class="col-md-7">
							<div class="input-group">					
								<input id="input_find" name="input_find" class="form-control" type="text" placeholder="Filter (Customer, Sales Person, Status)" >
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
	$('#rate_usd').autoNumeric('init',{
		mDec	: 6
	});
	
	$('#rate_sgd').autoNumeric('init',{
		mDec	: 6
	});
	
	$('#agen_commission').autoNumeric('init',{
		aSign	: ' %',
		pSign	: 's'
	});
	
	$('.autonumber').autoNumeric('init');
	
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
			url : "<?php echo site_url('marketing_misc/search_product/quotation')?>",
			data: {
				"product_id[]"	: p_id,
				"factory_id[]"	: f_id,
				"param"			: param
			},
			success: function(msg){
				$('#table_container').html(msg);
			}
		});		
	});
	
//	$('#search_product').click(function(){
//		var search = {search:$("#input_search").val()};
//				
//		$.ajax({
//			type: "POST",
//			url : "<?php // echo site_url('marketing_misc/search_product/quotation')?>",
//			data: search,
//			success: function(msg){
//				$('#table_container').html(msg);
//			}
//		});		
//	});

	$('#search_find').on('click',function(){
		var find = {find:$("#input_find").val()};
		$.ajax({
			type: "POST",
			url : "<?php echo site_url('marketing_transaction/sales_quotation/find')?>",
			data: find,
			success: function(msg){
				$('#table_find').html(msg);
			}
		});
	});
	
	$('#btn_delete').on('click',function(){
		var headerid = $(this).attr('headerid');		
		var datanumber = $(this).attr('data-number');
		
//		bootbox.confirm('<i class="fa fa-question-circle"></i> Are you sure want to delete sales quotation data with number "-'+datanumber+'-" ?',function(result){			
		bootbox.confirm({
			size	: 'large',
			title	: '<div class="caption"><i class="fa fa-question-circle theme-font"></i><span class="caption-subject theme-font uppercase"> DELETE CONFIRMATION</span></div>',
			message	: 'Are you sure want to delete sales quotation data with number "'+datanumber+'" ?',
			callback:	function(result){
				if (result){
					$.ajax({
						url:"<?php echo site_url('marketing_transaction/sales_quotation/delete');?>",
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
							return location.href = "<?php echo site_url('marketing_transaction/sales_quotation');?>";
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
							return location.href="<?php echo site_url('marketing_transaction/sales_quotation');?>";
						}
					});
				} else {
					console.log("Declined delete sales quotation data.");
				}
			}
		});
	});
	
	//fungsi ini untuk menghilangkan list data di modal
	$('.modal').on('hidden.bs.modal', function(){
		$('.v-scroll').html('');
	});
	
	//select all text on focused
	$('.input-table').on('click', function(){
		this.select();
	});
	
	$('#agen_commission').on('click', function(){
		this.select();
	});

	$('.autonumber').on('click', function(){
		this.select();
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
		var f_id_pre = '';
		
		i = 1;		
		for(r=0;r < chk_length ;r++){
			
			if (chk_arr[r].checked == true){
				if (f_id_pre != '' && f_id_pre != getText(document.getElementById('tbl_product').rows[i].cells[7])){
					bootbox.alert('Please select product from the same factory');
				} else {
					$('#tbl_quotation > tbody:last-child').append(
						'<tr>\n\
							<td class="text-center w-50 bg-editable valign-middle">\n\
								<input type="button" class="btn default btn-xs red-stripe" onclick="removeRow(this)" value="Remove">\n\
								<input type="hidden" name="product_id[]" class="p_id" value="'+getText(document.getElementById('tbl_product').rows[i].cells[1])+'">\n\
								<input type="hidden" name="factory_id[]" class="f_id" value="'+getText(document.getElementById('tbl_product').rows[i].cells[7])+'">\n\
								<input type="hidden" name="quotation_dtl_id[]" value="0">\n\
							</td> \n\
							<td class="w-300"><input name="product_name[]" class="form-control input-xs input-table" placeholder="Product Name" readonly="readonly" value="'+getText(document.getElementById('tbl_product').rows[i].cells[2])+'" title="'+getText(document.getElementById('tbl_product').rows[i].cells[2])+'"></td>\n\
							<td class="w-180"><input name="product_code[]" class="form-control input-xs input-table" placeholder="Product Code" readonly="readonly" value="'+getText(document.getElementById('tbl_product').rows[i].cells[3])+'" title="'+getText(document.getElementById('tbl_product').rows[i].cells[3])+'"></td>\n\
							<td class="w-180"><input name="brand[]" value="'+getText(document.getElementById('tbl_product').rows[i].cells[5])+'" class="form-control input-xs input-table" readonly="readonly"></td>\n\
							<td class="w-150"><input name="uom[]" value="'+getText(document.getElementById('tbl_product').rows[i].cells[6])+'" class="form-control input-xs input-table" readonly="readonly"></td>\n\
							<td class="w-100 bg-editable"><input required name="price[]" type="text" class="form-control input-xs text-right input-table autonum_price" data-v-min="0" onkeyup="calculate()" value=""></td>\n\
							<td class="w-100 bg-editable"><input required name="qty[]" type="text" class="form-control input-xs text-right input-table autonum_qty" data-v-min="0" onkeyup="calculate()" value=""></td>\n\
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
	}

	function disc(){
        var dis = remove_percent(document.getElementById('discount').value);
        var total = remove_thousand_separator(document.getElementById('total_before_disc').value);
        var grand_total = total * (dis/100);
        document.getElementById('total_disc').value = number_format(grand_total, 2);
		
    }

	function calculate(){
        var int=0;
        var total=0;
        
        $('#tbl_quotation tr').each(function() {
            var qty = remove_thousand_separator($(this).find("input[name='qty[]']").val());
            var price = remove_thousand_separator($(this).find("input[name='price[]']").val());
            var total_row = qty * price;	
			
            $(this).find("input[name='total[]']").val(number_format(total_row, 2));
			
//			$(this).find("input[name='total[]']").val(total_row.toFixed(2));
            
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
        var final_total = total - total_disc - freight - tax;
        document.getElementById('final_total').value= number_format(final_total, 2);
    }
	
	function re_calculate(){
		var dis = remove_thousand_separator(document.getElementById('discount').value) / 100;
        var total = remove_thousand_separator(document.getElementById('total_before_disc').value);
        var grand_total = total * dis;
        document.getElementById('total_disc').value = number_format(grand_total, 2, '.', ',');
        
        calculate();
	}
</script>
