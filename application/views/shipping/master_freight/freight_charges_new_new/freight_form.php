
<script>	    
    $(document).ready(function () {
        
        $("#search").keyup(function () {
            _this = this;
            $.each($("#tbl_coa tbody tr"), function () {
                if ($(this).text().toLowerCase().indexOf($(_this).val().toLowerCase()) === -1)
                    $(this).hide();
                else
                    $(this).show();
            });

        });

    });

</script>


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
						 <div class="actions">
                            <?php echo anchor(site_url('master-freight-new-new/add'), '<i class="fa fa-plus"></i> Create Freight Charges', 'class="btn btn-primary"'); ?>
                        </div>
                    </div>

                    <?php echo $this->session->flashdata('message');?>

                    <div class="portlet-body form" id="save_as_new">
                        <form action="<?php echo $action; ?>" method="post" class="form-horizontal" role="form">
							<div class="form-body">
								<?php
                                    echo "<input type='hidden' id='act' name='act' value='$act'>";
                                    ?>
							</div>
								<div class="form-group">
									<div class="col-md-12">
                                        <div class="panel panel-default">
                                            <div class="panel-body">
                                            	 <div class="form-group">
													<label class="col-md-2 control-label" for="varchar">Consignee (Link Marketing)</label>
													<div class="col-md-3">
														<?php
														$extra_consignee      = 'id="consignee" class="form-control select2me" required';
														$option_consignee[''] = '';
														foreach($cbo_consignee as $r):
															$option_consignee[$r->customer_id] = $r->customer_name;
														endforeach;
														echo form_dropdown('consignee', $option_consignee, $consignee, $extra_consignee);
														?>
													</div>
												</div>

				                                <div class="form-group">
													<label class="col-md-2 control-label" for="varchar">Container Type </label>
													<div class="col-md-3">
														<?php
														$extra_container = 'id="container_type" class="form-control select2me" onchange="change_container()" required';
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
                                                    <div class="col-md-1 pull-right">
                                                        <input type="text" class="form-control text-center" name="freight_charges_id2" id="freight_charges_id2" value="<?php echo $freight_charges_id2; ?>" readonly/>
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
														$extra_port      = 'id="port_id" class="form-control select2me" required';
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
				                                <div class="form-group" id="fob_container">
													<label class="col-md-2 control-label" for="varchar">Shipping Term </label>
													<div class="col-md-3">
														<?php
														$extra_fob      = 'id="fob_id" class="form-control select2me" ';
														$option_fob[''] = '';
														foreach($cbo_fob as $r):
															$option_fob[$r->trading_term_id] = $r->trading_term_name .' ('. $r->trading_term_remark.')';
														endforeach;
														echo form_dropdown('fob_id', $option_fob, $fob_id, $extra_fob);
														?>
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-2 control-label padding-right-2" for="varchar">Validity</label>
			                                        <div class="col-md-3">
			                                            <div class="input-group date date-picker" data-date-format="mm/yyyy" >
			                                                <div class="input-group date-picker input-daterange" data-date="<?php echo $current_date ?>" data-date-format="dd/mm/yyyy">
			                                                    <input type="text" class="form-control" name="validity_from" id="validity_from" value="<?php echo $validity_from;?>" title="date format : dd/mm/yyyy" required>
			                                                    <span class="input-group-addon" style="background: transparent; border-color: transparent">to</span>
			                                                    <input type="text" class="form-control" name="validity_till" id="validity_till" value="<?php echo $validity_till;?>" title="date format : dd/mm/yyyy" required>
			                                                </div>
			                                            </div>
			                                        </div>
												</div>


				                                <div class="form-group">
				                                    <label class="col-md-2 control-label" for="varchar">Comfirm Freight Rate</label>
				                                    <div class="col-md-3">
			                                            <input type="checkbox" name="comfirm" id="comfirm_yes" value="1" <?php if ($comfirm == '1'){ echo 'checked';}?>><i style="color: green;"> Yes </i>
			                                           	<input type="checkbox" name="comfirm" id="comfirm_no" value="0" <?php if ($comfirm == '0'){ echo 'checked';}?>><i style="color: red;"> No </i>		 
				                                    </div>
				                                </div>
											</div>
										</div>
									</div>
								</div>
							
							<table class="table-bordered table-striped table-condensed table-hover" id="tbl_shp" >
                                <thead>
                                    <tr>
                                      <th rowspan="2" width='2%' style="text-align:center">
                                        <a class="btn green" data-toggle="modal" id="co" href="#coa" title="Search Shipping Liner"><i class="fa fa-plus"></i></a>
                                       </th>
                                        <th rowspan="2" nowrap width='10%' style="text-align:center" >Shipping Liner </th>
                                        <th colspan="4" nowrap width='8%' style="text-align:center">Vendor's Price </th>
                                        <th colspan="2" nowrap width='8%' style="text-align:center">Customer's Price </th>
                                     </tr>
                                    <tr>
                                        <th nowrap width='4%' style="text-align:center">Rate 1</th> 
                                        <th nowrap width='4%' style="text-align:center">Rate 2</th>
                                        <th nowrap width='4%' style="text-align:center">Rate 3</th>
                                        <th nowrap width='10%' style="text-align:center">Misc</th>
                                        <th nowrap width='4%'style="text-align:center">Rate - (Link Marketing)</th>                     
                                        <th width='8%' style="text-align:center">Misc</th>
                                        <th width='8%' style="text-align:center" hidden>Freight detail id</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php
                                    if (!empty($freight_detail)) {
                                        foreach ($freight_detail as $m) {                     
                                            echo '<tr>';
                                            echo '<td class="bg-editable text-center">';
											echo '<input type="button" class="btn default btn-xs red-stripe fontawesome-font remove_detail_add"  value="Remove" style="margin: 1px; width: 95%;"  id="'.$m->freight_charges_dtl_id.'">';
											echo '</td>';
											echo '<td class="bg-editable" hidden>';
											echo '<input type="hidden" name="shipping_id[]" value="'.$m->shipping_id.'">';
											echo '</td>';
											echo '<td class="bg-editable">';
											echo '<input name="shipping_line[]" class="form-control input-xs input-table" style="text-align:center" value="'.$m->shipping_line.'" readonly>';
											echo '</td>';
											echo '<td class="bg-editable">';
											echo '<input name="vendor_rates[]" class="form-control input-xs input-table" style="text-align:center" value="'.$m->vendor_rates.'">';
											echo '</td>';
											echo '<td class="bg-editable">';
											echo '<input name="vendor_rates2[]" class="form-control input-xs input-table" style="text-align:center" value="'.$m->vendor_rates2.'">';
											echo '</td>';
											echo '<td class="bg-editable">';
											echo '<input name="vendor_rates3[]" class="form-control input-xs input-table" style="text-align:center" value="'.$m->vendor_rates3.'">';
											echo '</td>';
											echo '<td class="bg-editable">';
											echo '<input name="vendor_misc[]" class="form-control input-xs input-table" style="text-align:center" value="'.$m->vendor_misc.'">';
											echo '</td>';
											echo '<td class="bg-editable">';
											echo '<input name="cust_rates[]" class="form-control input-xs input-table" style="text-align:center" value="'.$m->cust_rates.'">';
											echo '</td>';
											echo '<td class="bg-editable">';
											echo '<input name="cust_misc[]" class="form-control input-xs input-table" style="text-align:center" value="'.$m->cust_misc.'">';
											echo '</td>';
										
											echo '<td class="bg-editable" hidden>';
											echo '<input name="freight_charges_dtl_id[]" class="form-control input-xs input-table" value="'.$m->freight_charges_dtl_id.'">';
											echo '</td>';                                                   
                                            echo '</tr>';
                                            
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                           </div>

							<div class="form-actions">
								<div class="row">
									<div class="col-md-12">
										<button type="submit" class="btn green w-100"><?php echo $button ?></button>
						
										<a href="<?php echo site_url('master-freight-new-new') ?>" class="btn red w-100"><i class="fa fa-close"></i> Cancel</a>
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

<script>
	$('#tbl_shp .remove_detail_add').on('click', function(){
					var tr = $(this).closest('tr');
					var liner_id	= $(this).attr('id');
					// alert(liner_id)

					bootbox.confirm('Are you sure want to remove this shipping liner?',function(result){
						if (result){ 
							if (liner_id !== '0'){
								$.ajax({
									type: "POST",
									url	: "<?php echo site_url('Master_freight_new_new/remove')?>",
									data: {id : liner_id},
									success : function(){
										$.bootstrapGrowl('<i class="fa fa-info-circle"></i> Remove shipping liner Success.', {
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
								 updateRowOrder();
								// calculate();
							});
						} 
							
					});
				});	
</script>


<script type="text/javascript">
	$('.autonum').autoNumeric('init', {
		mDec	: 2
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

     function ambilnew(x) {
        function getText(el) {
            if (typeof el.textContent === 'string')
                return el.textContent;
            if (typeof el.innerText === 'string')
                return el.innerText;
        }
        $r = x.rowIndex;
        var num = 1;
        var shipping_id = getText(document.getElementById('tbl_coa').rows[$r].cells[0]);
        var shipping_line = getText(document.getElementById('tbl_coa').rows[$r].cells[1]);
        var shipping_editable	= "bg-editable";
        for (var i = 0; i < num; i++) {
            $('table[id="tbl_shp"]').append(
            	'<tr><td style="text-align: center; "><button class="btn default btn-xs red-stripe fontawesome-font remove_detail_add" id="0" style="margin: 1px; width: 95%;" >Remove</button></td>'
            	+'<td class="'+shipping_editable+'">'
							+'<input name="shipping_id[]"  value="'+shipping_id+'" type="hidden" class="form-control brand-text input-xs input-table">'
							+'<div class="input-group" style="margin-bottom: 0px;">'
								+'<input name="shipping_line[]" value="'+shipping_line+'" class="form-control input-xs input-table" style="width: 150%; text-align: center;"  readonly="readonly">'
							+'</div>'
						+'</td>'
				+'<td class="bg-editable"><input name="vendor_rates[]"  value="" type="text" class="form-control autonum text-right"  required></td>'
				+'<td class="bg-editable"><input name="vendor_rates2[]"  value="" type="text" class="form-control autonum text-right"  ></td>'
				+'<td class="bg-editable"><input name="vendor_rates3[]"  value="" type="text" class="form-control autonum text-right"  ></td>'
                +'<td class="bg-editable"><input name="vendor_misc[]"  value="" type="text" class="form-control autonum text-right"  ></td>'
                +'<td class="bg-editable"><input name="cust_rates[]"  value="" type="text" class="form-control autonum text-right"  required></td>'
                +'<td class="bg-editable"><input name="cust_misc[]"  value="" type="text" class="form-control autonum text-right"  </td>'
                +'<td class="bg-editable" hidden><input name="freight_charges_dtl_id[]"  value="" type="hidden" class="form-control input-sm"></td>'
        		+'</tr>'
         );

        }

        $('#tbl_shp .remove_detail_add').on('click', function(){
			var tr = $(this).closest('tr');
			var liner_id	= $(this).attr('id');

			bootbox.confirm('Are you sure want to remove this shipping liner?',function(result){
				if (result){ 
					if (liner_id !== '0'){
						$.ajax({
							type: "POST",
							url	: "<?php echo site_url('Master_freight_new_new/remove')?>",
							data: {id : liner_id},
							success : function(){
								$.bootstrapGrowl('<i class="fa fa-info-circle"></i> Remove shipping liner Success.', {
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
						updateRowOrder();
						//calculate();
					});
				} 
					
			});
		});		

        $('#coa').modal('hide');
       // cekdetail();

        // console.log(url);
        console.log(shipping_line);
    }
    //  function hapus_dp(btn) {
    //     var row = btn.parentNode.parentNode;
    //     row.parentNode.removeChild(row);
    //     // hitung_amount();
    //     // cekdetail();
    // }

    	
  
	function updateRowOrder() {
        $('span.num').each(function (i) {
            $(this).text(i + 1);
        });
    }
</script>

<script type="text/javascript">
    function save_as_new(){
        var container_type = $("#container_type").val();
        var container_id = $("#container_id").val();
        // var freight_charges_id = $("#freight_charges_id").val();
        var container_size = $("#container_size").val();
        var port_id = $("#port_id").val();
        var country_id = $("#country_id").val();
        var fob_id = $("#fob_id").val();
        var validity_from = $("#validity_from").val();
        var validity_till = $("#validity_till").val();
        var shipping_line = $("#shipping_line").val();
        var vendor_rates = $("#vendor_rates").val();
        var vendor_rates2 = $("#vendor_rates2").val();
        var vendor_rates3 = $("#vendor_rates3").val();
        var shipping_line1 = $("#shipping_line1").val();
        var shipping_line2 = $("#shipping_line2").val();
        var shipping_line3 = $("#shipping_line3").val();
        var vendor_misc = $("#vendor_misc").val();
        var consignee = $("#consignee").val();
        var cust_rates = $("#cust_rates").val();
        var cust_misc = $("#cust_misc").val();
        var comfirm_yes = $("#comfirm_yes").val();
        var comfirm_no = $("#comfirm_no").val();

        $.ajax({
            type: "POST",
            url : "<?php echo site_url('master_freight_new/get_new_save')?>",
            data: {
                'container_type' : container_type,
                'container_id' : container_id,
                'container_size' : container_size,
                // 'freight_charges_id' : freight_charges_id,
                'port_id' : port_id,
                'country_id' : country_id,
                'fob_id' : fob_id,
                'validity_from' : validity_from,
                'validity_till' : validity_till,
                'shipping_line' : shipping_line,
                'vendor_rates' : vendor_rates,
                'vendor_rates2' : vendor_rates2,
                'vendor_rates3' : vendor_rates3,
                'shipping_line1' : shipping_line1,
                'shipping_line2' : shipping_line2,
                'shipping_line3' : shipping_line3,
                'vendor_misc' : vendor_misc,
                'consignee' : consignee,
                'cust_rates' : cust_rates,
                'cust_misc' : cust_misc,
                'comfirm_yes' : comfirm_yes,
                'comfirm_no' : comfirm_no,
            },
            success: function(msg){
                $('#save_as_new').html(msg);
            }
        });
    }
</script>
<div class="modal fade" id="coa" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">List of Master Shipping Line</h4>
                <input class="form-control" type="text" id="search" placeholder="search">
            </div>
            <div class="modal-body">
                <section class="">
                    <div class="contain">
                        <table cellspacing="0" cellpadding="0" border="0" id="tbl_coa" width="100%">
                            <thead>
                                <tr class="header">
                                    <th>ID shipping Liner<div>ID shipping Liner</div></th>
                                    <th>Shipping Name<div>Shipping Name</div></th>
                                   
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                if (!empty($cbo_shipping_line)) {
                                    foreach ($cbo_shipping_line as $s) {
                                        ?>
                                        <tr onclick="ambilnew(this)" style="cursor: pointer;">
                                            <td><?php echo $s->shipping_id; ?></td>
                                            <td><?php echo $s->shipping_name; ?></td>
                                        </tr>
                                        <?php
                                    }
                                }
                                ?>

                            </tbody>
                        </table>
                    </div>
                </section>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn red" data-dismiss="modal">Close</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>



