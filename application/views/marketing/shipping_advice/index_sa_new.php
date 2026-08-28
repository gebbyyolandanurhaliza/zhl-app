<style>
	.input-table[readonly] {
		cursor : default;
	}
</style>

<div class="page-content">
	<div class="container-fluid">
		<div class="row ">
			<div class="col-md-12">

				<div class="portlet light">

					<div class="portlet-title">
						<div class="caption">
							<i class="fa fa-table theme-font"></i>
							<span class="caption-subject theme-font uppercase">Shipping Advice</span>
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

						<?php echo form_open($action, 'class="form-horizontal" onsubmit="return SAValidate(this);"'); ?>

						<div class="form-body row">
							<div class="col-md-12">

								<div class="panel panel-default">
									<div class="panel-heading">
										<h5 class="panel-title"><i class='fa fa-filter'></i> Filter</h5>
									</div>

									<div class="panel-body">
										<div class="form-group">
											<label class="col-md-2 control-label" for="varchar">Customer </label>
											<div class="col-md-7">
												<?php
													$extra_customer = 'id="customer_list" class="form-control"';
													$option_customer[''] = '';
													foreach(json_decode($cbo_customer) as $c):
														$option_customer[$c->customer_id.'|'.$c->customer_name.'|'.$c->customer_contact_name] = $c->customer_name;
													endforeach;
													echo form_dropdown('customer_list', $option_customer, $customer_id.'|'.$customer_name.'|'.$contact_name, $extra_customer);
												?>
												<input type="hidden" name="customer_id" id="customer_id" value="<?php echo $customer_id;?>">
												<input type="hidden" name="contact_name" id="contact_name" value="<?php echo $contact_name;?>">
											</div>
										</div>

										<script type="text/javascript">
											$('#customer_list').on('change', function(){
												var arr_cust	= $('#customer_list').val().split('|');
												var customer_id	= arr_cust[0];
												var customer_name = arr_cust[1];
												var contact_name = arr_cust[2];
												var today = moment().format('DD/MM/YYYY');

												$('#customer_id').val(customer_id);
												$('#customer_name').val(customer_name);
												$('#attn').val(contact_name);
												$('#contact_name').val(contact_name);
												$('#c_date').val(today);
//												$('#ref_no').val('');
//												$('#cc1').val('');
//												$('#cc2').val('');
//												$('#from').val('');
//												$('#tel').val('');
//												$('#fax').val('');
											});
										</script>

										<div class="form-group">
											<label class="col-md-2 control-label" for="varchar">Shipment Date</label>
											<div class="col-md-4">
												<div class="input-group date-picker input-daterange" data-date="<?php echo $current_date ?>" data-date-format="dd/mm/yyyy">
													<input type="text" class="form-control" name="period_1" id="period_1" value="<?php echo $period_1 ?>" title="date format : dd/mm/yyyy">
													<span class="input-group-addon" style="background: transparent; border-color: transparent">to</span>
													<input type="text" class="form-control" name="period_2" id="period_2" value="<?php echo $period_2; ?>" title="date format : dd/mm/yyyy">
												</div>
											</div>
										</div>

										<div class="form-group">
											<label class="col-md-2 control-label" for="varchar">Product Category </label>
											<div class="col-md-7">
												<?php
													$extra_product_category = 'id="product_category_list" class="form-control"';
													$option_product_category[''] = '';
													foreach($cbo_product_category as $c):
														$option_product_category[$c->product_category_id.'|'.$c->product_category_name] = $c->product_category_name;
													endforeach;
													echo form_dropdown('product_category_list', $option_product_category, $product_category_id.'|'.$product_category_name, $extra_product_category);
												?>
												<input type="hidden" name="product_category_id" id="product_category_id" value="<?php echo $product_category_id;?>">
												<input type="hidden" name="product_category_name" id="product_category_name" value="<?php echo $product_category_name;?>">
											</div>
										</div>

										<script type="text/javascript">
											$('#product_category_list').on('change', function(){
												var arr_cust	= $('#product_category_list').val().split('|');
												var product_category_id	= arr_cust[0];
												var product_category_name = arr_cust[1];

												$('#product_category_id').val(product_category_id);
												$('#product_category_name').val(product_category_name);
											});
										</script>

										<div class="form-group">
											<label class="col-md-2 control-label" for="varchar">Product</label>
											<div class="col-md-7">
												<input type="text" class="form-control" name="product_name" id="product_name" value="<?php echo $product_name ?>"/>
											</div>
										</div>

										<div class="form-group">
											<label class="col-md-2 control-label" for="varchar">Factory</label>
											<div class="col-md-7">
												<?php
													$extra_factory = 'id="factory_id" class="form-control"';
													$option_factory[''] = '';
													foreach($cbo_factory as $f):
														$option_factory[$f->factory_id] = $f->factory_abbr;
													endforeach;
													echo form_dropdown('factory_id', $option_factory, $factory_id, $extra_factory);
												?>
											</div>
										</div>

										<div class="form-group">
											<label class="col-md-2 control-label" for="varchar">Container Number</label>
											<div class="col-md-7">
												<input type="text" class="form-control" name="container" id="container" value="<?php echo $container ?>"/>
											</div>
										</div>

										<div class="form-group">
											<label class="col-md-2 control-label" for="varchar">Buyer Ref</label>
											<div class="col-md-7">
												<input type="text" class="form-control" name="buyer_ref" id="buyer_ref" value="<?php echo $buyer_ref ?>"/>
											</div>
										</div>
									</div>
									<div class="panel-footer">
										<!--<input type="button" name="btn_search" id="btn_search" value="&#xf002 Search" class="btn blue fontawesome-font">-->
										<button type="submit" name="btn_submit" value="search" class="btn blue"><i class="fa fa-search"></i>  Search</button>
									</div>
								</div>

								<?php echo $message ?>

								<h4 class="form-section">
									<i class="fa fa-search"> </i>
									Search Result
								</h4>

								<div id="sa_identity">
									<input type="hidden" name="sa_id" id="sa_id">
								</div>

								<div class="form-group">
									<label class="control-label col-md-1">To</label>
									<div class="col-md-5">
										<input name="customer_name" id="customer_name" readonly="readonly" class="form-control" value="<?php echo $customer_name;?>">
									</div>

									<label class="control-label col-md-1">Date</label>
									<div class="col-md-5">
										<input name="c_date" id="c_date" class="form-control date date-picker" data-date-format="dd/mm/yyyy" value="<?php echo $c_date;?>">
									</div>
								</div>

								<div class="form-group">
									<label class="control-label col-md-1">Attn</label>
									<div class="col-md-5">
										<input type="text" name="attn" id="attn" class="form-control" value="<?php echo $attn;?>">
									</div>

<!--									<label class="control-label col-md-1">Our Ref No</label>
									<div class="col-md-5">
										<input type="text" name="ref_no" class="form-control" id="ref_no" value="<?php // echo $ref_no;?>">
									</div>-->
								</div>
<!--
								<div class="form-group">
									<label class="control-label col-md-1">c.c.</label>
									<div class="col-md-5">
										<input type="text" name="cc1" id="cc1" class="form-control" value="<?php // echo $cc1;?>">
									</div>

									<label class="control-label col-md-1">Tel</label>
									<div class="col-md-5">
										<input type="text" name="tel" class="form-control" id="tel" value="<?php // echo $tel;?>">
									</div>
								</div>

								<div class="form-group">
									<label class="control-label col-md-1">From</label>
									<div class="col-md-5">
										<input type="text" name="from" id="from" class="form-control" value="<?php // echo $from;?>">
									</div>

									<label class="control-label col-md-1">Fax</label>
									<div class="col-md-5">
										<input type="text" name="fax" class="form-control" id="fax" value="<?php // echo $cc2;?>">
									</div>
								</div>

								<div class="form-group">
									<label class="control-label col-md-1">c.c.</label>
									<div class="col-md-5">
										<input type="text" name="cc2" id="cc2" class="form-control" value="<?php // echo $cc2;?>">
									</div>
								</div>
								-->
								<br>

								<div id="sa_container">
									<div class="widget-toolbar">
			                            <input class="form-control " style="width:200px;" type="text" id="search" placeholder="Search By PO" >
			                        </div>
									<div class="table-scrollable">
										<table class="table table-bordered table-condensed table-detail scrollable" id="tbl_sa">
											<thead>
												<tr class="double-border-bottom">
													<th>#</th>
													<th>PO No.</th>
													<th>Buyer Ref</th>
													<th>Vessel / Voyage</th>
													<th>ETD</th>
													<th>ETA</th>
													<th>Port</th>
													<th>Product</th>
													<th>20'</th>
													<th>40'</th>
													<th>CT</th>
													<th>Container No.</th>
													<th>Seal No.</th>
													<th>Booking Ref No.</th>
												</tr>
											</thead>
											<tbody>
												<?php
													if ($record){
														foreach ($record as $r) {
															$r_shipid		= $r->shipid;
															$r_pohdrid		= $r->po_hdr_id;
															$r_ponumber		= $r->po_number;

															$etdsin	= str_replace('-', '/', $r->etdsin);
															$etasin = str_replace('-', '/', $r->etasin);

															$r_contid		= $r->cont_dtl_id;
															$r_buyersi		= $r->buyer_si;
															$r_vessel		= $r->vessel;
															$r_etd			= str_replace('/20', '/', $etdsin);
															$r_eta			= str_replace('/20', '/', $etasin);
															$r_port			= $r->portdestination;
															$r_product		= $r->product;
															$r_fcl20		= $r->fcl20;
															$r_fcl40		= $r->fcl40;
															$r_ct			= $r->container_abbr;
															$r_container	= $r->container;
															$r_seal			= $r->seal;
															$r_booking_ref	= $r->reff;

															echo "<tr>";
															echo "<td class='bg-editable'>";
																echo "<input readonly='readonly' type='button' style='width: 80px; margin-left: 5px; margin-top: 2px;' class='btn default btn-xs red-stripe remove_detail' value='Remove'>";
															echo "</td>";

															echo "<td class='bg-editable'>";
																echo "<input type='hidden' readonly='readonly' name='po_number[]' value='$r_ponumber' title='$r_ponumber' class='form-control input-xs input-table text-center' style='width:120px;'>";
																echo "<input type='hidden' name='cont_dtl_id[]' id='cont_dtl_id' value='$r_contid'>";
																echo "<input type='hidden' name='po_dtl_id[]' id='po_dtl_id' value='$r_pohdrid'>";
																echo "<textarea readonly='readonly' rows='2' name='po_number_show[]' class='form-control input-xs input-table product_desc autosizeme' style='width:120px;'>$r_ponumber</textarea>";
															echo "</td>";

															echo "<td class='bg-editable'>";
																echo "<input readonly='readonly' name='buyer_si[]' value='$r_buyersi' class='form-control input-xs input-table text-center' style='width:120px;'>";
															echo "</td>";

															echo "<td class='bg-editable'>";
																echo "<input readonly='readonly' name='vessel[]' value='$r_vessel' class='form-control input-xs input-table text-center' style='width:120px;'>";
															echo "</td>";

															echo "<td class='bg-editable'>";
																echo "<input readonly='readonly' name='etd[]' value='$r_etd' class='form-control input-xs input-table text-center' style='width:100px;'>";
															echo "</td>";

															echo "<td class='bg-editable'>";;
																echo "<input readonly='readonly' name='eta[]' value='$r_eta' class='form-control input-xs input-table text-center' style='width:100px;'>";
															echo "</td>";

															echo "<td class='bg-editable'>";
																echo "<input readonly='readonly' name='port[]' value='$r_port' class='form-control input-xs input-table text-center' style='width:150px;'>";
															echo "</td>";

															echo "<td class='bg-editable'>";
																echo "<textarea readonly='readonly' name='product_desc[]' class='form-control input-xs input-table product_desc autosizeme' style='width:400px;'>$r_product</textarea>";
															echo "</td>";

															echo "<td class='bg-editable'>";
																echo "<input readonly='readonly' name='fcl20[]' value='$r_fcl20' class='form-control input-xs input-table text-center' style='width:40px;'>";
															echo "</td>";

															echo "<td class='bg-editable'>";
																echo "<input readonly='readonly' name='fcl40[]' value='$r_fcl40' class='form-control input-xs input-table text-center' style='width:40px;'>";
															echo "</td>";

															echo "<td class='bg-editable'>";
																echo "<input readonly='readonly' name='ct[]' value='$r_ct' class='form-control input-xs input-table text-center' style='width:40px;'>";
															echo "</td>";

															echo "<td class='bg-editable'>";
																echo "<input readonly='readonly' name='container_no[]' value='$r_container' class='form-control input-xs input-table text-center' style='width:150px;'>";
															echo "</td>";

															echo "<td class='bg-editable'>";
																echo "<input readonly='readonly' name='seal[]' value='$r_seal' class='form-control input-xs input-table text-center' style='width:130px;'>";
															echo "</td>";

															echo "<td class='bg-editable'>";
																echo "<input readonly='readonly' name='booking_ref[]' value='$r_booking_ref' class='form-control input-xs input-table text-center' style='width:130px;'>";
															echo "</td>";

															echo "</tr>";

														}
//													} else {
//														echo "<tr>";
//														echo "<td colspan='14' class='text-center'>No Data Available</td>";
//														echo "</tr>";
													}
												?>

											</tbody>
										</table>

									</div>
								</div>


							</div>
						</div>

						<div class="form-actions">
							<div class="row">
								<div class="col-md-12">
									<!--<button type="submit" name="btn_submit" value="pdf" class="btn btn-warning"><i class="fa fa-file-pdf-o"></i>  View PDF</button>-->
									<input type="button" id="btn_pdf_sa" name="btn_pdf_sa" class="btn btn-default fontawesome-font" value="&#xf002 View PDF ..." >
								</div>
							</div>
						</div>

						<?php echo form_close(); ?>
					</div>

				</div>

			</div>
		</div>
	</div>
</div>

<script>

	// $(document).ready(function() {
 //        $('#dataTables-listTK').dataTable();
 //    }

	$("#search").keyup(function(){
         _this = this;
        $.each($("#tbl_sa tbody tr"), function() {
            if($(this).text().toLowerCase().indexOf($(_this).val().toLowerCase()) === -1)
               $(this).hide();
            else
               $(this).show();
        });
    });

	$('select').select2({
		allowClear	: true
	});

	$('.autosizeme').each(function(){
		autosize(this);
	});

//	$('.product_desc').AutosizeMe();

	$('#tbl_sa .remove_detail').on('click', function(){
		var tr = $(this).closest('tr');

		tr.fadeOut(400, function(){
			tr.remove();
		});
	});

	$('#btn_pdf_sa').on('click', function(){
//		var dataString = $("form").serializeArray();
		var sa_id	= $('#sa_id').val();
		var cust_id	= $('#customer_id').val();
		var to		= $('#customer_name').val();
		var cdate	= $('#c_date').val();
		var attn	= $('#attn').val();
//		var ref_no	= $('#ref_no').val();
//		var cc1		= $('#cc1').val();
//		var tel		= $('#tel').val();
//		var from	= $('#from').val();
//		var fax		= $('#fax').val();
//		var cc2		= $('#cc2').val();
		var cont_id = $("input[name='cont_dtl_id[]']").map(function(){
                    return this.value;
                }).get();
		var po_number = $("input[name='po_number[]']").map(function(){
                    return this.value;
                }).get();
		var product = $("textarea[name='product_desc[]']").map(function(){
                    return this.value;
                }).get();

		$.ajax({
			type: 'POST',
			url: '<?php echo site_url('Shipping-advice/generate_pdf')?>',
			data: {
				'sa_id'			: sa_id,
				'customer_id'	: cust_id,
				'to'			: to,
				'cdate'			: cdate,
				'attn'			: attn,
//				'ref_no'		: ref_no,
//				'cc1'			: cc1,
//				'cc2'			: cc2,
//				'tel'			: tel,
//				'from'			: from,
//				'fax'			: fax,
				'cont_dtl_id[]'	: cont_id,
				'po_number[]'	: po_number,
				'product[]'		: product
			},
			success:function(msg){
				$('#sa_identity').html(msg);
				var sa_id = $('#sa_id').val();
				var pdf_url = "<?php echo site_url('shipping_advice/view_pdf')?>/?id="+sa_id;
				window.open(pdf_url, '_blank');
			}
		});

//		window.open('<?php // echo site_url('shipping-advice/generate-pdf');?>', '_blank');
	});

	function SAValidate()
	{
		var custid = $('#customer_id').val();

		if (!custid){
			$.bootstrapGrowl('<i class="fa fa-exclamation-circle"></i>  Please select customer!', {
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

		sambu.startPageLoading({
			message : 'Searching... Please Wait!'
		});

//		window.setTimeout(function() {
//			sambu.stopPageLoading();
//		}, 5000);
	}
</script>
