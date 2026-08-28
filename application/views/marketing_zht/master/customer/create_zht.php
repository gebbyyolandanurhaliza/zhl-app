<link href="<?php echo base_url(); ?>assets/admin/scripts/jquery.autocomplete.css" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url(); ?>assets/admin/scripts/jquery.autocomplete.js" type="text/javascript"></script>

<style type="text/css">
	.sembunyi {
		display: none;
	}
</style>

<div class="page-content">

	<div class="container-fluid">
		<div class="row ">
			<div class="col-md-12">

				<div class="portlet light">
					<div class="portlet-title">
						<div class="caption">
							<i class="fa fa-cogs theme-font"></i>
							<span class="caption-subject theme-font uppercase"><?php echo $header_title; ?></span>
						</div>
						<div class="tools">
							<a href="javascript:;" class="collapse"></a>
						</div>
					</div>

					<div class="portlet-body form">
						<form action="<?php echo $action; ?>" method="post" class="form-horizontal" role="form" id="form_customer">

							<div class="form-body row">
								<div class="col-md-7">
									<h4 class="form-section"><i class="fa fa-home"></i>Customer Details</h4>

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
											foreach ($cbo_group as $r) :
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
											foreach ($cbo_country as $r) :
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
												if ($list_document) {
													$i = 0;
													foreach ($list_document as $doc) {
														$checked = false;
														if ($selected_document) {
															foreach ($selected_document as $sd) {
																if ($sd->document_id == $doc->document_id) {
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

							<!-- Add Default Bank - Requested By Pohlin (24-01-2018) -->
							<div class="form-body row">
								<div class="col-md-12">

									<div class="col-md-12">
										<div class="table-toolbar">
											<div class="row">
												<a class="btn btn-default btn-large" id="add_bank" name="add_bank">
													<i class="fa fa-plus"></i>
													Add Bank
												</a>
											</div>
										</div>
									</div>

									<script type="text/javascript">
										$("#add_bank").click(function() {
											$.ajax({
												type: "POST",
												url: "<?php echo site_url('marketing_zht/add_bank_row') ?>",
												success: function(msg) {
													$('#tbl_bank > tbody:last-child').append(msg);
												}
											});
										});
									</script>

									<div class="bank-scroll">
										<table width="100%" id="tbl_bank" class="table table-detail">
											<thead>
												<tr>
													<th>#</th>
													<th width="83%">Bank</th>
												</tr>
											</thead>
											<tbody>
												<?php
												if ($detail_bank) {
													foreach ($detail_bank as $bnk) {
												?>
														<tr>
															<td class="bg-editable"><input type="button" class="btn default red-stripe" onclick="removeBank(this)" value="Remove Bank"></td>
															<td class="bg-editable">
																<?php
																$extra_bank = 'id= "bank_id" class="form-control"';
																$option_bank[''] = '';
																if ($cbo_bank) {
																	foreach ($cbo_bank as $r) :
																		$option_bank[$r->bank_id] = $r->bank_name;
																	endforeach;
																}
																echo form_dropdown('bank_id[]', $option_bank, $bnk->bank_id, $extra_bank);
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
								<div class="col-md-12">

									<div class="col-md-12">
										<div class="table-toolbar">
											<div class="row">
												<a class="btn btn-default btn-large" id="add_payment" name="add_payment">
													<i class="fa fa-plus"></i>
													Add Payment Term
												</a>
											</div>
										</div>
									</div>

									<script type="text/javascript">
										$("#add_payment").click(function() {
											$.ajax({
												type: "POST",
												url: "<?php echo site_url('marketing_zht/add_payterm_row') ?>",
												success: function(msg) {
													$('#tbl_payterm > tbody:last-child').append(msg);
												}
											});
										});
									</script>

									<div class="payterm-scroll">
										<table width="100%" id="tbl_payterm" class="table table-detail">
											<thead>
												<tr>
													<th>#</th>
													<th width="83%">Payment Term</th>
												</tr>
											</thead>
											<tbody>
												<?php
												if ($detail_payterm) {
													foreach ($detail_payterm as $pt) {
												?>
														<tr>
															<td class="bg-editable"><input type="button" class="btn default red-stripe" onclick="removePayterm(this)" value="Remove Payment Term"></td>
															<td class="bg-editable">
																<?php
																$extra_payterm = 'id= "payment_term_id" class="form-control"';
																$option_payterm[''] = '';
																if ($cbo_payterm) {
																	foreach ($cbo_payterm as $r) :
																		$option_payterm[$r->payment_term_id] = $r->payment_term;
																	endforeach;
																}
																echo form_dropdown('payment_term_id[]', $option_payterm, $pt->payment_term_id, $extra_payterm);
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
								<div class="col-md-12">

									<div class="table-toolbar">
										<div class="row">
											<div class="col-md-6">
												<div class="btn-group">
													<a class="btn btn-default btn-large" data-target="#modal_product" data-toggle="modal">
														<i class="fa fa-plus"></i>
														Add Product Purchased ...
													</a>
												</div>
											</div>
										</div>
									</div>

									<div id="tbl_product_container">
										<div class="table-responsive">
											<table class="table table-bordered table-condensed table-detail" id="tbl_product_purchased">
												<thead>
													<tr class="double-border-bottom">
														<th scope="col" style="width:50px !important">#</th>
														<th scope="col">Product Description</th>
														<th scope="col">Product Code</th>
														<th scope="col">Product Brand</th>
														<th scope="col">Factory</th>
														<th scope="col">Packing Size</th>
														<th scope="col">UOM</th>
													</tr>
												</thead>
												<tbody>
													<?php
													$last_count = 0;
													if ($product) {
														foreach ($product as $d) {
															$last_count++;

															echo '<tr>';
															echo '<td class="text-center w-50 bg-editable valign-middle">';
															echo '<div class="input-group input-table-group">';
															echo '<input type="button" class="btn default btn-xs red-stripe" onclick="removeRow(this)" value="Remove">';
															echo '<span class="input-group-addon input-table-group-addon bootstrap-touchspin-postfix num">' . $last_count . '</span>';
															echo '</div>';
															echo '<input type="hidden" name="product_id[]" class="p_id" value="' . $d->product_id . '">';
															echo '</td>';
															echo '<td class="bg-editable"><input name="product_name[]" class="form-control input-xs input-table" placeholder="Product Name" readonly="readonly" value="' . $d->product_name . '" title="' . $d->product_name . '"></td>';
															echo '<td class="bg-editable w-180"><input name="product_code[]" class="form-control input-xs input-table" placeholder="Product Code" readonly="readonly" value="' . $d->product_code . '" title="' . $d->product_code . '"></td>';
															echo '<td class="bg-editable w-180">';
															echo '<input name="brand_name[]" id="brn" value="' . $d->brand_name . '" class="form-control input-xs input-table" readonly="readonly">';
															echo '</td>';
															echo '<td class="bg-editable w-70"><input name="factory[]" value="' . $d->factory_abbr . '" class="form-control input-xs input-table text-center" readonly="readonly"></td>';
															echo '<td class="bg-editable w-150"><input name="packing_size[]" value="' . $d->packing_view . '" class="form-control input-xs input-table" readonly="readonly"></td>';
															echo '<td class="bg-editable w-100"><input name="uom[]" value="' . $d->cma_uom_quantity_id . '" class="form-control input-xs input-table text-center" readonly="readonly"></td>';
															echo '</tr>';
														}
													}
													?>
												</tbody>
											</table>
										</div>
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

							<div class="form-body row">
								<div class="col-md-12">
									<div class="form-group">
										<label class="col-md-2 control-label" for="varchar">Default Consignee for SI</label>
										<div class="col-md-10">
											<textarea name="si_consignee_default" rows="5" class="form-control autosizeme"><?php echo $si_consignee_default ?></textarea>
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

<div id="add_product">
	<div id="modal_product" class="modal fade bs-modal-lg" role="dialog" tabindex="-1" data-backdrop="static" data-keyboard="false" aria-hidden="true">
		<div class="modal-dialog modal-full">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
					<div class="row">
						<div class="col-md-5">
							<div class="input-group">
								<input id="input_search" name="input_search" class="form-control" type="text" placeholder="Search Product">
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
						<table id="tbl_product_head" class="table table-condensed table-hover table-fixed" style="margin-bottom: 2px; width:99%;">
							<thead>
								<tr>
									<th class="w-70" style="width:70px;">#</th>
									<th class="sembunyi">Product ID</th>
									<th style="text-align: left;">Product Description</th>
									<th style="width:220px; text-align: left;">Product Code</th>
									<th style="width:70px;">uomname</th>
									<th class="sembunyi">Brand ID</th>
									<th class="sembunyi">UOM ID</th>
									<th class="sembunyi">Factory ID</th>
									<th style="width:200px; text-align: left;">Packing</th>
									<th class="sembunyi">Estimated 20ft</th>
									<th class="sembunyi">Estimated 40ft</th>
									<!--<th>Available Container</th>-->
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

<script type="text/javascript">
	$('select').select2({
		allowClear: true
	});

	$('.modal').on('hidden.bs.modal', function() {
		$('.v-scroll').html('');
	});

	$('#search_product').on('click', function() {
		var param = $("#input_search").val();
		var p_id = $("input[name='product_id[]']").map(function() {
			return this.value;
		}).get();
		var f_id = $("input[name='factory_id[]']").map(function() {
			return this.value;
		}).get();


		$.ajax({
			type: "POST",
			url: "<?php echo site_url('marketing/search_product/customer') ?>",
			data: {
				"product_id[]": p_id,
				"factory_id[]": f_id,
				"param": param
			},
			success: function(msg) {
				$('#table_container').html(msg);
			}
		});
	});

	function removeBank(btn) {
		var row = btn.parentNode.parentNode;
		row.parentNode.removeChild(row);
	}

	function removePayterm(btn) {
		var row = btn.parentNode.parentNode;
		row.parentNode.removeChild(row);
	}

	function updateRowOrder() {
		$('span.num').each(function(i) {
			$(this).text(i + 1);
		});
	}

	function removeRow(btn) {
		var row = btn.parentNode.parentNode.parentNode;
		row.parentNode.removeChild(row);
		updateRowOrder();
	}

	function select_product() {
		function getText(el) {
			if (typeof el.textContent == 'string')
				return el.textContent;
			if (typeof el.innerText == 'string')
				return el.innerText;
		}

		// alert("test")

		var chk_arr = document.getElementsByName("chk[]");
		var chk_length = chk_arr.length;
		console.log(chk_length)
		//
		i = 0;


		for (r = 0; r < 5; r++) {
			if (chk_arr[r].checked == true) {
				var baris = $('#tbl_product_purchased tr').length;

				$('#tbl_product_purchased > tbody:last-child').append(
					'<tr>\n\
		                        <td class="text-center w-50 bg-editable valign-middle">\n\
		                                <div class="input-group input-table-group">\n\
		                                <input type="button" class="btn default btn-xs red-stripe" onclick="removeRow(this)" value="Remove">\n\
		                                <span class="input-group-addon input-table-group-addon bootstrap-touchspin-postfix num">' + baris + '</span>\n\
		                                </div>\n\
		                                <input type="hidden" name="product_id[]" class="p_id" value="' + getText(document.getElementById('tbl_product').rows[i].cells[1]) + '">\n\
		                        </td> \n\
		                        <td class="bg-editable w-300"><input name="product_name[]" class="form-control input-xs input-table" placeholder="Product Name" readonly="readonly" value="' + getText(document.getElementById('tbl_product').rows[i].cells[2]) + '" title="' + getText(document.getElementById('tbl_product').rows[i].cells[2]) + '"></td>\n\
		                        <td class="bg-editable w-180"><input name="product_code[]" class="form-control input-xs input-table" placeholder="Product Code" readonly="readonly" value="' + getText(document.getElementById('tbl_product').rows[i].cells[3]) + '" title="' + getText(document.getElementById('tbl_product').rows[i].cells[3]) + '"></td>\n\
								<td class="bg-editable w-180">\n\
		                            <input name="brand_name[]" id="brn" class="form-control input-xs input-table" readonly="readonly">\n\
		                        </td>\n\
		                        <td class="bg-editable w-70"><input name="factory[]" value="' + getText(document.getElementById('tbl_product').rows[i].cells[4]) + '" class="form-control input-xs input-table text-center" readonly="readonly"></td>\n\\n\
								<td class="bg-editable w-150"><input name="packing_size[]" value="' + getText(document.getElementById('tbl_product').rows[i].cells[8]) + '" class="form-control input-xs input-table" readonly="readonly"></td>\n\
								<td class="bg-editable w-100"><input name="uom[]" value="' + getText(document.getElementById('tbl_product').rows[i].cells[6]) + '" class="form-control input-xs input-table text-center" readonly="readonly"></td></tr>'
				);

			}
			i++;
		}
		$('#modal_product').modal('hide');

		//select all text on focused
		$('.autofocus').on('click', function() {
			this.select();
		});

	};
</script>