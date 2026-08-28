<link href="<?php echo base_url(); ?>assets/admin/scripts/jquery.autocomplete.css" rel="stylesheet" type="text/css"/>
<script src="<?php echo base_url(); ?>assets/admin/scripts/jquery.autocomplete.js" type="text/javascript"></script>

<div class="page-content">
	
	<div class="container-fluid">
		<div class="row ">
			<div class="col-md-12">
				
				<div class="portlet light">
					<div class="portlet-title">
						<div class="caption">
							<i class="fa fa-cogs theme-font"></i>
							<span class="caption-subject theme-font uppercase"><?php echo $header_title;?></span>
						</div>
						<div class="tools">
							<a href="javascript:;" class="collapse"></a>								
						</div>
					</div>
					
					<div class="portlet-body form">
						<form action="<?php echo $action; ?>" method="post" class="form-horizontal" role="form" id="form_customer">
							
							<div class="form-body row">
								<div class="col-md-7">
									<h4 class="form-section"><i class="fa fa-home"></i> Customer Details</h4>
																		
									<div class="form-group required">
										<label class="col-md-3 control-label" for="varchar">Company Name</label>
										<div class="col-md-8">
											<input required type="text" class="form-control" name="customer_company_name" id="customer_company_name" value="<?php echo $customer_company_name; ?>" />
										</div>
										<span class="help-inline"><?php echo form_error('customer_company_name') ?></span>
									</div>
									
									<div class="form-group required">
										<label class="col-md-3 control-label" for="varchar">Customer Group </label>
										<div class="col-md-8">
											<?php 

												$extra_group = 'required class="form-control select2me"';
												$option_group[''] = '';
												foreach($cbo_group as $r):
													$option_group[$r->customer_group_id] = $r->customer_group_name;
												endforeach;
												echo form_dropdown('customer_group_id', $option_group, $customer_group_id, $extra_group);
											?>

										</div>
									</div>

									<div class="form-group required">
										<label class="col-md-3 control-label" for="varchar">Country </label>
										<div class="col-md-8">
											<?php 

												$extra_country = 'class="form-control select2me" data-placeholder="Select Country..."';
												$option_country[''] = '';
												foreach($cbo_country as $r):
													$option_country[$r->country_id] = $r->country_name;
												endforeach;
												echo form_dropdown('country_id', $option_country, $country_id, $extra_country);
											?>

										</div>
										<span class="help-inline"><?php echo form_error('country_id') ?></span>
									</div>

									<div class="form-group">
										<label class="col-md-3 control-label" for="longtext">Customer Reference</label>
										<div class="col-md-8">
											<input rows="3" class="form-control" name="customer_reference" id="customer_reference" value="<?php echo $customer_reference; ?>" />
										</div>
										<span class="help-inline"><?php echo form_error('customer_reference') ?></span>
									</div>

									<div class="form-group">
										<label class="col-md-3 control-label" for="longtext">Customer Contract Number</label>
										<div class="col-md-8">
											<input rows="3" class="form-control" name="customer_contract_no" id="customer_contract_no" value="<?php echo $customer_contract_no; ?>" />
										</div>
										<span class="help-inline"><?php echo form_error('customer_contract_no') ?></span>
									</div>

									<div class="form-group">
										<label class="col-md-3 control-label" for="longtext">Address</label>
										<div class="col-md-8">
											<textarea rows="3" class="form-control autosizeme" name="customer_address" id="customer_address"><?php echo $customer_address; ?></textarea>
										</div>
										<span class="help-inline"><?php echo form_error('customer_address') ?></span>
									</div>

									<div class="form-group">
										<label class="col-md-3 control-label" for="varchar">Phone</label>
										<div class="col-md-8">
											<input type="text" class="form-control" name="customer_phone" id="customer_phone" value="<?php echo $customer_phone; ?>" />
										</div>
										<span class="help-inline"><?php echo form_error('customer_phone') ?></span>
									</div>

									<div class="form-group">
										<label class="col-md-3 control-label" for="varchar">Fax</label>
										<div class="col-md-8">
											<input type="text" class="form-control" name="customer_fax" id="customer_fax" value="<?php echo $customer_fax; ?>" />
										</div>
										<span class="help-inline"><?php echo form_error('customer_fax') ?></span>
									</div>
									
									<div class="form-group">
										<label class="col-md-3 control-label" for="varchar">Email</label>
										<div class="col-md-8">
											<input type="text" class="form-control" name="customer_email" id="customer_email" value="<?php echo $customer_email; ?>" />										
										</div>
										<span class="help-inline"><?php echo form_error('customer_email') ?></span>
									</div>
									
								</div>
								
								<div class="col-md-5">
									
									<h4 class="form-section"><i class="fa fa-male"></i> Contact Person</h4>

									<div class="form-group">
										<label class="col-md-3 control-label" for="varchar">Name</label>
										<div class="col-md-8">
											<input type="text" class="form-control" name="customer_contact_name" id="customer_contact_name" value="<?php echo $customer_contact_name; ?>" />
											<span class="help-inline"><?php echo form_error('customer_contact_name') ?></span>
										</div>										
									</div>

									<div class="form-group">
										<label class="col-md-3 control-label" for="varchar">Phone</label>
										<div class="col-md-8">
											<input type="text" class="form-control" name="customer_contact_phone" id="customer_contact_phone" value="<?php echo $customer_contact_phone; ?>" />
											<span class="help-inline"><?php echo form_error('customer_contact_phone') ?></span>
										</div>										
									</div>

									<div class="form-group">
										<label class="col-md-3 control-label" for="varchar">Email</label>
										<div class="col-md-8">
											<input type="text" class="form-control" name="customer_contact_email" id="customer_contact_email" value="<?php echo $customer_contact_email; ?>" />
											<span class="help-inline"><?php echo form_error('customer_contact_email') ?></span>
										</div>										
									</div>
									
									
									<h4 class="form-section"><i class="fa fa-briefcase"></i> Customer's Documents</h4>									
									
									<div class="doc-scroll" style="height: 180px;">
										<table id="list-document" class="doc-table table-hover">
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
							
							<div class="form-body row">
								<div class="col-md-12">
									<h4 class="form-section">
										<!--<i class="fa fa-money"></i> Payment Term-->
										
										<!--<div>-->
											<label class="control-label">
												<a class="btn btn-default" id="add_payment"><i class="fa fa-plus-circle"></i> Add Payment Term</a>
											</label>
										<!--</div>-->
									</h4>
									
									<div id="payment">
										<?php 
										$last_count = 0;
										if ($detail_payterm){
											foreach ($detail_payterm as $pt){
												$last_count++;
												echo "<div class='form-group records'>";
												echo "<label class='col-md-2 control-label' for='varchar'>Payment Term $last_count</label>";
												echo "<div class='col-md-8'>";
													echo "<div class='input-group' style='text-align:left'>";
														echo "<input type='text' class='form-control' name='payment_term[]' id='payment_term' value='".$pt->payment_term."' />";
														echo "<span class='input-group-btn'>";
														echo "<a href='javascript:;' class='btn btn-danger remove_item' title='Remove Payment Term'>";
														echo "<i class='fa fa-minus'></i>";
														echo "</a></span>";
//														echo "</div>";
//														echo "<label class='control-label'><a class='remove_item' ><i class='fa fa-minus-circle'></i></a></label>";
													echo "</div>";
												echo "</div>";
												echo "</div>";
												
											}
										} else {
											$last_count++;
										?>
										<div class="form-group records">
											<label class="col-md-2 control-label" for="varchar">Payment Term 1</label>
											<div class="col-md-8">
												<!--<input type="text" class="form-control" name="payment_term[]" id="payment_term" value="" />-->
												<div class="input-group" style="text-align:left">
													<input type="text" class="form-control payterm" name="payment_term[]" id="payment_term">
													<span class="input-group-btn">
														<a href="javascript:;" class="btn btn-danger remove_item" title="Remove Payment Term">
															<i class="fa fa-minus"></i>
														</a>
													</span>
												</div>
											</div>
											<!--<label class="control-label red"><a class="remove_item" ><i class="fa fa-minus-circle"></i></a></label>-->
										</div>
										<?php
										}
										?>
									</div>
									
									
								</div>
							</div>
							
							<div class="form-body row">
								<div class="col-md-12">
									<div class="form-group">
										<label class="col-md-2 control-label" for="varchar">Default Remark for PO</label>
										<div class="col-md-10">
											<textarea name="po_remark_default" rows="5" class="form-control autosizeme"><?php echo $po_remark_default ?></textarea>
										</div>
									</div>									
								</div>
							</div>
							
							<div class="form-actions">
								<div class="row">
									<div class="col-md-12">
										<input type="hidden" name="customer_id" value="<?php echo $customer_id; ?>" /> 
										<button type="submit" class="btn green"><?php echo $button ?></button> 
										<a href="<?php echo site_url('marketing/master/customer') ?>" class="btn red"><i class="fa fa-close"></i> Cancel</a>
									</div>
								</div>
							</div>
							
						</form>
						
					</div>
					
				</div>

			

			</div>
		</div>
	</div>
	
</div>

<script type="text/javascript">
	$(document).ready(function(){
		var count = <?php echo $last_count?>;
		$("#add_payment").click(function(){
			count += 1;
			$('#payment').append(
				'<div class="form-group records">'
				+ '<label class="col-md-2 control-label" for="varchar">Payment Term '+count+'</label>'
				+ '<div class="col-md-8">'
				+ '<div class="input-group" style="text-align:left">'
				+ '<input type="text" class="form-control payterm" name="payment_term[]" id="payment_term" >'
				+ '<span class="input-group-btn">'
				+ '<a href="javascript:;" class="btn btn-danger remove_item" title="Remove Payment Term">'
				+ '<i class="fa fa-minus"></i>'
				+ '</a></span>'
				+ '</div>'
				+ '</div>'
				+ '</div>'
				);
		
			$('.payterm').autocomplete({
				serviceUrl: "<?php echo site_url('Marketing_misc/autocomplete_payterm'); ?>"
			});
		});
		
		$('.payterm').autocomplete({
			serviceUrl: "<?php echo site_url('Marketing_misc/autocomplete_payterm'); ?>"
		});
		

		$(".remove_item").live('click', function (ev) {
			if (ev.type == 'click') {
				$(this).parents(".records").fadeOut();
				$(this).parents(".records").remove();
			}
		});
	});
	
	 
	
//	$('#customer_phone').inputmask("mask", {
//		"mask": "9999 9999"
//	});
//	
//	$('#customer_fax').inputmask("mask", {
//		"mask": "9999 9999"
//	});

	
</script>
