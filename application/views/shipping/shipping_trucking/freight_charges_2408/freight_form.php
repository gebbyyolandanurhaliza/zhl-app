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
                        <form action="<?php echo $action; ?>" method="post" class="form-horizontal" role="form">
							<div class="form-body">

								<div class="form-group">
									<div class="col-md-12">
                                        <div class="panel panel-default">
                                            <div class="panel-body">

				                                <div class="form-group">
													<label class="col-md-2 control-label" for="varchar">Container Type </label>
													<div class="col-md-3">
														<?php
														$extra_container = 'id="container_type" class="form-control select2me" onchange="change_container()"';
														$option_container[''] = '';
														foreach($cbo_container_type as $r):
															$option_container[$r->container_id.'|'.$r->container_size] = $r->container_name;
														endforeach;
														echo form_dropdown('container_type', $option_container, $container_id.'|'.$container_size, $extra_container);
														?>
				                                        <input type="hidden" id="container_id" name="container_id" value="<?php echo $container_id;?>">
													</div>
                                                    <div class="col-md-1 pull-right">
                                                        <input type="text" class="form-control text-center" name="freight_charges_id" id="freight_charges_id" value="<?php echo $freight_charges_id; ?>" readonly/>
                                                    </div>
												</div>

				                                <div class="form-group">
				                                    <label class="col-md-2 control-label" for="varchar">Container Size</label>
				                                    <div class="col-md-3">
				                                        <input type="text" class="form-control text-right" name="container_size" id="container_size" value="<?php echo $container_size; ?>" />
				                                    </div>
				                                </div>

				                                <div class="form-group">
													<label class="col-md-2 control-label" for="varchar">Port </label>
													<div class="col-md-3">
														<?php
														$extra_port      = 'id="port_id" class="form-control select2me" ';
														$option_port[''] = '';
														foreach($cbo_port as $r):
															$option_port[$r->port_id] = $r->port_name;
														endforeach;
														echo form_dropdown('port_id', $option_port, $port_id, $extra_port);
														?>
													</div>
												</div>

				                                <div class="form-group" id="country_container">
													<label class="col-md-2 control-label" for="varchar">Country </label>
													<div class="col-md-3">
														<?php
														$extra_country      = 'id="country_id" class="form-control select2me" ';
														$option_country[''] = '';
														foreach($cbo_country as $r):
															$option_country[$r->country_id] = $r->country_name;
														endforeach;
														echo form_dropdown('country_id', $option_country, $country_id, $extra_country);
														?>
													</div>
												</div>

												<div class="form-group">
													<!-- <label class="col-md-2 control-label" for="varchar">Validity</label>
				                                    <div class="col-md-3">
				                                        <input type="text" class="form-control date date-picker" name="validity" id="validity" value="<?php echo $validity; ?>" data-date="<?php echo $current_date ?>" data-date-format="dd/mm/yyyy" title="date format : dd/mm/yyyy" />
				                                    </div> -->

													<label class="col-md-2 control-label padding-right-2" for="varchar">Validity</label>
			                                        <div class="col-md-3">
			                                            <div class="input-group date date-picker" data-date-format="mm/yyyy" >
			                                                <div class="input-group date-picker input-daterange" data-date="<?php echo $current_date ?>" data-date-format="dd/mm/yyyy">
			                                                    <input type="text" class="form-control" name="validity_from" value="<?php echo $validity_from;?>" title="date format : dd/mm/yyyy">
			                                                    <span class="input-group-addon" style="background: transparent; border-color: transparent">to</span>
			                                                    <input type="text" class="form-control" name="validity_till" value="<?php echo $validity_till;?>" title="date format : dd/mm/yyyy">
			                                                </div>
			                                            </div>
			                                        </div>
												</div>

											</div>
										</div>
									</div>
								</div>

								<div class="form-group">
									<div class="col-md-6">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">Vendor's Price</h4>
                                            </div>

                                            <div class="panel-body">
												<div class="form-group">
				                                    <label class="col-md-4 control-label" for="varchar">Rates 1 </label>
				                                    <div class="col-md-4">
				                                        <input type="text" class="form-control autonum text-right" name="vendor_rates" id="vendor_rates" value="<?php echo $vendor_rates; ?>"/>
				                                    </div>
				                                </div>
												<div class="form-group">
				                                    <label class="col-md-4 control-label" for="varchar">Rates 2 </label>
				                                    <div class="col-md-4">
				                                        <input type="text" class="form-control autonum text-right" name="vendor_rates2" id="vendor_rates2" value="<?php echo $vendor_rates2; ?>"/>
				                                    </div>
				                                </div>
												<div class="form-group">
				                                    <label class="col-md-4 control-label" for="varchar">Rates 3 </label>
				                                    <div class="col-md-4">
				                                        <input type="text" class="form-control autonum text-right" name="vendor_rates3" id="vendor_rates3" value="<?php echo $vendor_rates3; ?>"/>
				                                    </div>
				                                </div>
												<div class="form-group">
				                                    <label class="col-md-4 control-label" for="varchar">Shipping Line 1 </label>
				                                    <div class="col-md-4">
				                                        <input type="text" class="form-control" name="shipping_line1" id="shipping_line1" value="<?php echo $shipping_line1; ?>"/>
				                                    </div>
				                                </div>				                         
												<div class="form-group">
				                                    <label class="col-md-4 control-label" for="varchar">Shipping Line 2 </label>
				                                    <div class="col-md-4">
				                                        <input type="text" class="form-control" name="shipping_line2" id="shipping_line2" value="<?php echo $shipping_line2; ?>"/>
				                                    </div>
				                                </div>
												<div class="form-group">
				                                    <label class="col-md-4 control-label" for="varchar">Shipping Line 3 </label>
				                                    <div class="col-md-4">
				                                        <input type="text" class="form-control" name="shipping_line3" id="shipping_line3" value="<?php echo $shipping_line3; ?>"/>
				                                    </div>
				                                </div>
												<div class="form-group">
													<label class="col-md-4 control-label" for="varchar">Misc</label>
				                                    <div class="col-md-4">
				                                        <input type="text" class="form-control" name="vendor_misc" id="vendor_misc" value="<?php echo $vendor_misc; ?>"/>
				                                    </div>
												</div>
                                            </div>

                                        </div>
                                    </div>

									<div class="col-md-6">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">Customer's Price</h4>
                                            </div>

                                            <div class="panel-body">
												<div class="form-group">
				                                    <label class="col-md-4 control-label" for="varchar">Rates 1</label>
				                                    <div class="col-md-4">
				                                        <input type="text" class="form-control autonum text-right" name="cust_rates" id="cust_rates" value="<?php echo $cust_rates; ?>"/>
				                                    </div>
				                                </div>
												<div class="form-group">
				                                    <label class="col-md-4 control-label" for="varchar">Rates 2</label>
				                                    <div class="col-md-4">
				                                        <input type="text" class="form-control autonum text-right" name="cust_rates2" id="cust_rates2" value="<?php echo $cust_rates2; ?>"/>
				                                    </div>
				                                </div>
												<div class="form-group">
				                                    <label class="col-md-4 control-label" for="varchar">Rates 3</label>
				                                    <div class="col-md-4">
				                                        <input type="text" class="form-control autonum text-right" name="cust_rates3" id="cust_rates3" value="<?php echo $cust_rates3; ?>"/>
				                                    </div>
				                                </div>
				                                <div class="form-group">
													<label class="col-md-4 control-label" for="varchar">Consignee 1</label>
				                                    <div class="col-md-4">
				                                        <input type="text" class="form-control" name="consignee1" id="consignee1" value="<?php echo $consignee1; ?>"/>
				                                    </div>
												</div>
				                                <div class="form-group">
													<label class="col-md-4 control-label" for="varchar">Consignee 2</label>
				                                    <div class="col-md-4">
				                                        <input type="text" class="form-control" name="consignee2" id="consignee2" value="<?php echo $consignee2; ?>"/>
				                                    </div>
												</div>
				                                <div class="form-group">
													<label class="col-md-4 control-label" for="varchar">Consignee 3</label>
				                                    <div class="col-md-4">
				                                        <input type="text" class="form-control" name="consignee3" id="consignee3" value="<?php echo $consignee3; ?>"/>
				                                    </div>
												</div>
				                                <div class="form-group">
													<label class="col-md-4 control-label" for="varchar">Misc</label>
				                                    <div class="col-md-4">
				                                        <input type="text" class="form-control" name="cust_misc" id="cust_misc" value="<?php echo $cust_misc; ?>"/>
				                                    </div>
												</div>
                                            </div>

                                        </div>
                                    </div>

								</div>


                            </div>

							<div class="form-actions">
								<div class="row">
									<div class="col-md-12">
										<button type="submit" class="btn green w-100"><?php echo $button ?></button>
										<a href="<?php echo site_url('master-freight') ?>" class="btn red w-100"><i class="fa fa-close"></i> Cancel</a>
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
	$('.autonum').autoNumeric('init', {
		mDec	: 0
	});

	$('#port_id').on('change', function(){
		var port_id = $('#port_id').val();

		$.ajax({
			type: "POST",
			url : "<?php echo site_url('master_freight/ajax_country_by_port')?>",
			data: {
				"port_id" : port_id
			},
			success: function(msg){
				$('#country_container').html(msg);
			}
		});
	});
</script>

<script>
    function change_container(){
        var arr_container_type = $('#container_type').val().split('|');

        $('#container_id').val(arr_container_type[0]);
        $('#container_size').val(arr_container_type[1]);

    }
</script>
