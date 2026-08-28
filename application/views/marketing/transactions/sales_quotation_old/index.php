<style type="text/css">		
	.sembunyi{
		display: none;
	}
</style>

<div class="page-content">
	<div class="container-fluid">
		<div class="row ">
			
			<form action="<?php echo $action; ?>" method="post" class="form-horizontal">
				<div class="col-md-12">
					<div class="portlet light">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-table theme-font"></i>
								<span class="caption-subject theme-font bold uppercase">Sales Quotation</span>
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

									<div class="form-group">
										<label class="col-md-4 control-label" for="varchar">Customer</label>
										<div class="col-md-5">
											<?php 
												$extra_customer = 'class="form-control select2me" data-placeholder="Select Customer..."';
												$option_customer[''] = '';
//												foreach($cbo_country as $r):
													$option_customer['PSG'] = 'Pulau Sambu Guntung';
													$option_customer['PSKE'] = 'Pulau Sambu Kuala Enok';
													$option_customer['RSUP'] = 'Riau Sakti United Plantations - Industry';
//												endforeach;
												echo form_dropdown('customer_id', $option_customer, '', $extra_customer);
											?>
											<!--<input type="text" class="form-control" name="customer_company" id="customer_company" placeholder="Customer" value="<?php echo $customer_company; ?>" />-->
										</div>
										<span class="help-inline"><?php echo form_error('customer_company') ?></span>
									</div>

									<div class="form-group">
										<label class="col-md-4 control-label" for="varchar">Name</label>
										<div class="col-md-5">
											<input type="text" class="form-control" name="customer_name" id="customer_name" value="<?php echo $customer_name; ?>" />
										</div>
										<span class="help-inline"><?php echo form_error('customer_name') ?></span>
									</div>

									<div class="form-group">
										<label class="col-md-4 control-label" for="varchar">Contact Person</label>
										<div class="col-md-5">
											<input type="text" class="form-control" name="customer_contact" id="customer_contact" value="<?php echo $customer_contact; ?>" />
										</div>
										<span class="help-inline"><?php echo form_error('customer_contact') ?></span>
									</div>
									
									<div class="form-group">
										<label class="col-md-4 control-label" for="varchar">Customer Ref. No.</label>
										<div class="col-md-5">
											<input type="text" class="form-control" name="customer_ref_no" id="customer_ref_no" value="<?php echo $customer_ref_no; ?>" />
										</div>
										<span class="help-inline"><?php echo form_error('customer_ref_no') ?></span>
									</div>
									
									<div class="form-group">
										<label class="col-md-4 control-label" for="varchar">&nbsp;</label>
										<div class="col-md-5">
											<?php 
												$extra_currency = 'class="form-control select2me" data-placeholder="Local Currency"';
												$option_currency[''] = '';
//												foreach($cbo_country as $r):
													$option_currency['USD'] = 'USD';
													$option_currency['SGD'] = 'SGD';
													$option_currency['IDR'] = 'IDR';
//												endforeach;
												echo form_dropdown('local_currency', $option_currency, '', $extra_currency);
											?>
											<!--<input type="text" class="form-control" name="customer_company" id="customer_company" placeholder="Customer" value="<?php echo $customer_company; ?>" />-->
										</div>
										<span class="help-inline"><?php echo form_error('local_currency') ?></span>
									</div>
								</div>

								<div class="col-md-6 col-md-push-2">
									<div class="form-group">
										<label class="col-md-3 control-label" for="varchar">Marketing Staff Code</label>
										<div class="col-md-5">
											<input type="text" class="form-control" name="marketing_staff_code" id="marketing_staff_code" placeholder="Marketing Staff Code" value="<?php echo $marketing_staff_code; ?>" />												
										</div>
										<span class="help-inline"><?php echo form_error('marketing_staff_code') ?></span>
									</div>

									<div class="form-group">
										<label class="col-md-3 control-label" for="varchar">Status</label>
										<div class="col-md-5">
											<?php
											$extra_status = 'class="form-control select2me" data-placeholder="Contract Status"';
											$option_status[''] = '';												
											$option_status['open'] = 'OPEN';
											$option_status['closed'] = 'CLOSED';

											echo form_dropdown('sales_status', $option_status, $sales_status, $extra_status);
											?>
											<!--<input type="text" class="form-control" name="sales_status" id="sales_status" placeholder="Status" value="<?php echo $sales_status; ?>" />-->
										</div>
										<span class="help-inline"><?php echo form_error('sales_status') ?></span>

									</div>

									<div class="form-group">
										<label class="col-md-3 control-label" for="varchar">First Posting Date</label>
										<div class="col-md-5">
											<input type="text" class="form-control date date-picker" data-date="12-02-2012" data-date-format="mm-dd-yyyy" name="posting_date" id="posting_date" placeholder="Posting Date" value="<?php echo $posting_date; ?>" />
										</div>
										<span class="help-inline"><?php echo form_error('posting_date') ?></span>
									</div>

									<div class="form-group">
										<label class="col-md-3 control-label" for="varchar">Validity</label>
										<div class="col-md-5">
											<input type="text" class="form-control" name="validity" id="validity" placeholder="Validity" value="<?php echo $validity; ?>" />
										</div>
										<span class="help-inline"><?php echo form_error('validity') ?></span>
									</div>

									<div class="form-group">
										<label class="col-md-3 control-label" for="varchar">Document Date</label>
										<div class="col-md-5">
											<input type="text" class="form-control date date-picker" data-date="12-02-2012" data-date-format="mm-dd-yyyy" name="document_date" id="document_date" placeholder="Document Date" value="<?php echo $document_date; ?>" />
										</div>
										<span class="help-inline"><?php echo form_error('document_date') ?></span>
									</div>

								</div>

							</div>

							<hr/>							
							<!--	<a class="btn btn-success btn-add" onclick="tambah_baris()"><i class="fa fa-plus-circle"></i> Add Detail</a>
								<a type="reset" class="btn btn-danger" onclick="hapus_baris()"><i class="fa fa-close"></i> Remove Detail</a>
								<button type="submit" class="btn btn-primary btn-save"><i class="fa fa-save"></i> Save All</button>
							<hr/>-->
							
							<div class="form-body row">
								<div class="col-md-12">
									<div class="table-toolbar">
										<div class="row">
											<div class="col-md-6">
												<div class="btn-group">
													<a class="btn btn-primary btn-large" data-target="#modal_product" data-toggle="modal">
														<i class="fa fa-plus"></i>
														Add Product
													</a>
												</div>
											</div>
										</div>										
									</div>

									<div class="table-scrollable">
										<table class="table table-bordered table-condensed table-detail" id="tbl_quotation">
											<thead>
												<tr>
													<th scope="col" style="width:50px !important">#</th>
													<th scope="col">Product Description</th>
													<th scope="col">Product Code</th>										
													<th scope="col">Product Brand</th>
													<th scope="col">UOM</th>
													<th scope="col">Packaging Size</th>												
													<th scope="col">Price</th>
													<th scope="col">Quantity</th>
													<th scope="col">Total Amount</th>
												</tr>
											</thead>
											<tbody>
											</tbody>
										</table>
									</div>
								</div>
							</div>

							<div class="form-body row">
								<div class="col-md-6">
									<div class="form-group">
										<label class="col-md-4 control-label" for="varchar">Sales Employee</label>
										<div class="col-md-5">
											<input type="text" class="form-control" name="sales_employee" id="marketing_staff" value="<?php echo $sales_employee; ?>" />
										</div>
										<span class="help-inline"><?php echo form_error('sales_employee') ?></span>
									</div>
									
									<div class="form-group">
										<label class="col-md-4 control-label" for="varchar">Owner</label>
										<div class="col-md-5">
											<input type="text" class="form-control" name="owner" id="owner" value="<?php echo $owner; ?>" />
										</div>
										<span class="help-inline"><?php echo form_error('owner') ?></span>
									</div>

									<div class="form-group">
										<label class="col-md-4 control-label" for="varchar">Remark</label>
										<div class="col-md-5">
											<textarea class="form-control autosizeme" name="sales_remark" id="sales_remark" value="<?php echo $sales_remark; ?>" ></textarea>
										</div>
										<span class="help-inline"><?php echo form_error('sales_remark') ?></span>
									</div>
								</div>
								
								<div class="col-md-6 col-md-push-2">
									
									<div class="form-group">
										<label class="col-md-4 control-label" for="varchar">Total before discount</label>
										<div class="col-md-4" style="padding-left: 2px">
											<input type="text" readonly="readonly" class="form-control" name="total_before_disc" id="owner" value="<?php echo $total_before_disc; ?>" />
										</div>
										<span class="help-inline"><?php echo form_error('total_before_disc') ?></span>
									</div>
									
									<div class="form-group">
										<label class="col-md-2 control-label label-sm" for="varchar">Discount</label>
										<div class="col-md-2" style="padding-right: 2px">
											<div class="input-group">
												<input type="text" class="form-control text-right" name="discount" id="discount" placeholder="%" value="<?php echo $discount; ?>" />
											</div>
										</div>
										<div class="col-md-4" style="padding-left: 2px">
											<input type="text" class="form-control" name="total_disc" id="total_disc" value="<?php echo $total_disc; ?>" />
										</div>
										<span class="help-inline"><?php echo form_error('total_before_disc') ?></span>
									</div>
									
									<div class="form-group">
										<label class="col-md-4 control-label" for="varchar">Freight</label>
										<div class="col-md-4" style="padding-left: 2px">
											<input type="text" readonly="readonly" class="form-control" name="freight" id="freight" value="<?php echo $freight; ?>" />
										</div>
										<span class="help-inline"><?php echo form_error('freight') ?></span>
									</div>
									
									<div class="form-group">
										<label class="col-md-4 control-label" for="varchar">Tax</label>
										<div class="col-md-4" style="padding-left: 2px">
											<input type="text" readonly="readonly" class="form-control" name="tax" id="tax" value="<?php echo $tax; ?>" />
										</div>
										<span class="help-inline"><?php echo form_error('tax') ?></span>
									</div>
									
									<div class="form-group">
										<label class="col-md-4 control-label" for="varchar">Total</label>
										<div class="col-md-4" style="padding-left: 2px">
											<input type="text" class="form-control" name="total" id="total" value="<?php echo $total; ?>" />
										</div>
										<span class="help-inline"><?php echo form_error('total') ?></span>
									</div>
									
								</div>
							</div>

							<div class="form-actions">
								<!--<div class="row">-->
									<!--<div class="col-md-offset-3 col-md-6">-->
										<button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save</button>
									<!--</div>-->
								<!--</div>-->
							</div>
								
						</div>
					</div>
				
				</div>
			</form>
		</div>
	</div>
</div>

<div id="add_product">
	<div id="modal_product" class="modal fade" role="dialog" tabindex="-1" data-backdrop="static" data-keyboard="false" data-width="75%">
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
			<button type="button" data-dismiss="modal" class="btn btn-default">Cancel</button>
			<!--<button type="button" data-dismiss="modal" class="btn blue">Select</button>-->
		</div>			
	</div>
</div>

<script type="text/javascript">
	$('#search_product').click(function(){
		var search = {search:$("#input_search").val()};
		$.ajax({
			type: "POST",
			url : "<?php echo site_url('marketing_misc/search_product/quotation')?>",
			data: search,
			success: function(msg){
				$('#table_container').html(msg);
			}
		});		
	});

</script>

<script>
	function removeRow(btn) {
		var row = btn.parentNode.parentNode;
		row.parentNode.removeChild(row);
	}
</script>