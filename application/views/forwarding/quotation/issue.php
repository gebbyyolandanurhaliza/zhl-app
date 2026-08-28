<style type="text/css">
    .sembunyi{
        display: none;
    }
</style>

<script>
	$('input:checkbox').uniform();
</script>

<div class="page-content">
    <div class="container-fluid">
        <div class="row ">

			<div id="global_msg"></div>

            <form action="<?php echo $action; ?>" method="post" class="form-horizontal" enctype="multipart/form-data" onsubmit="return validate(this);">
                <div class="col-md-12">

                    <?php echo $message ?>

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
                                <div class="col-md-8">

                                    <?php
                                    echo "<input type='hidden' id='act' name='act' value='$act'>";
                                    echo form_hidden('quotation_hdr_id', $quotation_hdr_id);
                                    ?>

                                    <div class="form-group">
                                        <label class="col-md-2 control-label">Quotation No</label>
                                        <div class="col-md-4">
                                            <input readonly="readonly" type="text" class="form-control" name="quotation_number" id="quotation_number" value="<?php echo $quotation_number ?>" placeholder="Auto Generate Once Saved" />
                                        </div>

                                        <label class="col-md-2 control-label">Quotation Status</label>
                                        <div class="col-md-4">
                                            <?php
                                            $extra_status = 'disabled="disabled" id="sales_status" class="form-control" data-placeholder="Status..."';
                                            $option_status[''] = '';
                                            foreach ($cbo_status as $r):
                                                $option_status[$r->status_id] = $r->status_name;
                                            endforeach;
                                            echo form_dropdown('sales_status', $option_status, $status_id, $extra_status);
                                            ?>
                                            <input type="hidden" name="status_id" id="status_id" value="<?php echo $status_id; ?>" />
                                        </div>
                                    </div>

                                    <div class="form-group required">
                                        <label class="col-md-2 control-label">Customer</label>
                                        <div class="col-md-10">
                                            <?php
                                            $extra_customer = 'required id="customer_id" class="form-control" ';
                                            $option_customer[''] = '';
                                            foreach ($cbo_customer as $r):
                                                $option_customer[$r->customer_id] = $r->customer_code . ' - ' . $r->customer_name;
                                            endforeach;
                                            echo form_dropdown('customer_id', $option_customer, $customer_id, $extra_customer);
                                            ?>
                                        </div>
                                    </div>

                                    <script type="text/javascript">
                                        $('#customer_id').change(function () {
                                            var customer_id = $("#customer_id").val();
                                            var factory_id = $("#fac_id").val();
                                            var aksi = $("#act").val();

                                            $.ajax({
                                                dataType: "json",
                                                type: "POST",
                                                url: "<?php echo site_url('for_sales_quotation/get_customer') ?>",
                                                data: {'customer_id': customer_id},
                                                success: function (response) {
                                                   $("#customer_name").val(response.customer_name);
                                                   $("#customer_contact_name").val(response.customer_contact_name);
                                                   $("#customer_reference").val(response.customer_reference);
                                                   $('#local_currency').val('USD').trigger('change'); 
                                                }
                                            });
                                            $("#payment_term_id").html("");
                                            $.ajax({
                                                dataType: "json",
                                                type: "POST",
												url: "<?php echo site_url('for_sales_quotation/get_payterm_by_customer') ?>",
                                                data: {'customer_id': customer_id},
                                                success: function (response) {
                                                    if (response.cbo_payterm.length > 0) {
                                                        var html = "";
                                                        response.cbo_payterm.forEach(function (item, index) {
                                                            html += `<option  value="${item.payment_term_id}">${item.payment_term}</option>`;
                                                        });
                                                        $("#payment_term_id").html(html);
                                                    }
                                                }
                                            });

                                        });
                                    </script>

                                    <div class="form-group">
                                        <label class="col-md-2 control-label">Customer Name</label>
                                        <div class="col-md-10">
                                            <input readonly="readonly" type="text" class="form-control" name="customer_name" id="customer_name" value="<?php echo $customer_name; ?>" />
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-2 control-label">Contact Person</label>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control" name="customer_contact_name" id="customer_contact_name" value="<?php echo $customer_contact_name; ?>" />
                                        </div>

                                        <label class="col-md-2 control-label">Customer Ref. No.</label>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control" name="customer_reference" id="customer_reference" value="<?php echo $customer_reference; ?>" />
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-2 control-label">Shipping Term</label>
                                        <div class="col-md-4" id="trading_term_container">
                                            <?php
                                            $extra_tradingterm = 'class="form-control" id="trading_term_id" ';
                                            $option_tradingterm[''] = '';
                                            foreach ($cbo_tradingterm as $r):
                                                $option_tradingterm[$r->trading_term_id] = $r->trading_term_name . ' (' . $r->trading_term_remark . ')';
                                            endforeach;
                                            echo form_dropdown('trading_term_id', $option_tradingterm, $trading_term_id, $extra_tradingterm);

                                            switch ($trading_term_id) {
                                                case 1 :
                                                case 2 :
                                                case 5 :
                                                case 13 :
                                                    $freight_disabled = 'disabled';
                                                    break;

                                                default:
                                                    $freight_disabled = '';
                                                    break;
                                            }
                                            ?>
                                        </div>

                                        <label class="col-md-2 control-label">Port Of Loading</label>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control" name="shipment_from" id="shipment_from" value="<?php echo $shipment_from; ?>" />
                                        </div>
                                    </div>

                                    <script type="text/javascript">
                                        $('#trading_term_id').change(function () {
                                            var tt_id = $('#trading_term_id').val();

                                            $('.freightnew').attr('disabled', true);
                                            $('.freightvalid').attr('disabled', true);

                                            if ((tt_id == 2) || (tt_id == 3) || (tt_id == 5) || (tt_id == 13)){
                                                $('.freightnew').attr('disabled', false);
                                                $('.freightvalid').attr('disabled', false);
                                            } else {
                                                $('.freightnew').val('');
                                                $('.freightvalid').val('');
                                            }
                                        });
                                    </script>


                                    <div class="form-group">
                                        <label class="col-md-2 control-label">Destination</label>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control" name="destination_id" id="destination_id" value="<?php echo $destination_id; ?>" />
                                        </div>

                                        <label class="col-md-2 control-label">Port of Discharge</label>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control" name="port_id" id="port_id" value="<?php echo $port_id; ?>" />
                                        </div>

                                        <script type="text/javascript">
                                            $('#destination_id').change(function () {
                                                var destination_id = {destination_id: $("#destination_id").val()};
                                                $('#port_id').select2('val', '');
                                                $.ajax({
                                                    dataType: "json",
                                                    type: "POST",
                                                    url: "<?php echo site_url('for_sales_quotation/get_port') ?>",
                                                    data: destination_id,
                                                    success: function (response) {
                                                        if (response.cbo_port.length > 0) {
                                                            var html = "";
                                                            response.cbo_port.forEach(function (item, index) {
                                                                html += `<option  value="${item.port_id}">${item.port_name}</option>`;
                                                            });
                                                            $("#port_id").html(html);
                                                        }
                                                    }
                                                });
                                            });
                                        </script>
                                    </div>


                                    <div class="form-group required" hidden>
                                        <label class="col-md-2 control-label">Local Currency</label>
                                        <div class="col-md-4">
                                            <?php
                                            $extra_currency = 'required id= "local_currency" class="form-control"';
                                            $option_currency[''] = '';
                                            foreach ($cbo_currency as $r):
                                                $option_currency[$r->currency_id] = $r->currency_symbol . ' - ' . $r->currency_name;
                                            endforeach;
                                            echo form_dropdown('local_currency', $option_currency, $local_currency, $extra_currency);
                                            ?>
                                        </div>
                                        <div class="col-md-3">
                                            <div id="div_rate_usd" class="input-group">
                                                <span class='input-group-addon'>US$</span>
                                                <input required type="text" rate-set='0' class="form-control text-right autofocus" name="rate_usd" id="rate_usd" placeholder="0.000000" value="<?php echo $rate_usd; ?>" title="6 digits decimal" />
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div id="div_rate_sgd" class="input-group">
                                                <span class='input-group-addon'>SIN$</span>
                                                <input required type="text" class="form-control text-right autofocus" name="rate_sgd" id="rate_sgd" placeholder="0.000000" value="<?php echo $rate_sgd; ?>" title="6 digits decimal" />
                                            </div>
                                        </div>
                                    </div>

                                    <script type="text/javascript">
                                        $('#local_currency').change(function () {
                                            var currency_id = {currency_id: $("#local_currency").val()};

                                            $.ajax({
                                                dataType: "json",
                                                type: "POST",
                                                url: "<?php echo site_url('for_sales_quotation/get_rate') ?>",
                                                data: currency_id,
                                                success: function (response){
                                                    $("#rate_usd").val(response.rate_usd).attr("rate-set", response.rate_is_set);
                                                    $("#rate_sgd").val(response.rate_sgd);
                                                }
                                            });
                                        });
                                    </script>

								</div>

								<div class="col-md-4">
									<div class="form-group required">
										<label class="col-md-4 control-label">Sales Person</label>
										<div class="col-md-8">
											<?php
											$extra_sales = 'required id= "sales_id" class="form-control"';
											$option_sales[''] = '';
											foreach ($cbo_sales as $r):
												$option_sales[$r->userid] = $r->firstname . ' ' . $r->lastname;
											endforeach;
											echo form_dropdown('sales_id', $option_sales, $sales_id, $extra_sales);
											?>
										</div>
									</div>

									<div class="form-group">
										<label class="col-md-4 control-label">Document Date</label>
										<div class="col-md-8">
											<div class="input-group date date-picker" data-date-format="dd/mm/yyyy" >
												<span class="input-group-btn">
													<button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
												</span>
												<input type="text" name="document_date" id="document_date" class="form-control" value="<?php echo $document_date; ?>" title="date format : dd/mm/yyyy">
											</div>
										</div>
									</div>

									<div class="form-group">
										<label class="col-md-4 control-label">Validity Date</label>
										<div class="col-md-8">
											<div class="input-group date date-picker" data-date-format="dd/mm/yyyy" >
												<span class="input-group-btn">
													<button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
												</span>
												<input type="text" name="validity_date" id="validity_date" class="form-control" value="<?php echo $validity_date; ?>" title="date format : dd/mm/yyyy">
											</div>
										</div>
									</div>

								</div>

								<br/>

							</div>

                            <div class="form-body row">
                                <div class="col-md-12">

                                    <div class="table-toolbar">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="btn-group">
                                                    <a class="btn btn-primary btn-large" onclick="add_service()">
                                                        <i class="fa fa-plus"></i>
                                                        Add Service ...
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="tbl_product_container">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-condensed" id="tbl_quotation">
                                                <thead>
                                                    <tr>
                                                        <th scope="col" style="width:50px !important">#</th>
                                                        <th scope="col">Service Type</th>
                                                        <th scope="col">Port</th>
                                                        <th scope="col">Charge Type</th>
                                                        <th scope="col">Description</th>
                                                        <th scope="col">Currency</th>
                                                        <th scope="col">Rate SGD</th>
                                                        <th scope="col">Rate USD</th>
                                                        <th scope="col">Price</th>
                                                        <th scope="col">Quantity</th>
                                                        <th scope="col">Remarks</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $last_count = 0;
                                                    if ($detail) {
                                                        foreach ($detail as $d) { ?>
                                                        <tr>
                                                                <td class="text-center w-50 bg-editable valign-middle">
                                                                    <div><input type="button" class="btn default btn-xs red-stripe" onclick="removeRow(this)" value="Remove"></div>
                                                                        <input type="hidden" name="quotation_dtl_id[]" value="<?= $d->quotation_dtl_id; ?>">
                                                                </td>
                                                                <td class="w-300">
                                                                    <input class="form-control input-xs input-table service_type" name="service_type[]" value="<?= $d->service_type; ?>">
                                                            </td>
                                                           <td class="w-180">
                                                                <select class="form-control input-xs input-table" name="port_service[]">
                                                                    <?php foreach ($cbo_port as $r) { ?>    
                                                                       <option <?php if ($d->port_service==$r->port_id){echo "selected";}?> value="<?= $r->port_id; ?>"><?= $r->port_name; ?></option>
                                                                       }
                                                                    <?php } ?>
                                                               </select>
                                                           </td>
                                                           <td class="w-300 bg-editable">
                                                                <input class="form-control input-xs input-table charge_name" name="charge_name[]" value="<?= $d->charge_id; ?>">
                                                           </td>
                                                           <td class="w-300"><input name="desc[]" value="<?= $d->desc; ?>" class="form-control input-xs input-table"></td>
                                                           <td class="w-300">
                                                               <select class="currency form-control input-xs input-table" name="currency[]">
                                                                    <option></option>
                                                                    <?php foreach ($cbo_currency as $r) { ?>    
                                                                       <option <?php if ($d->currency==$r->currency_id){echo "selected";}?> value="<?= $r->currency_id; ?>"><?php echo $r->currency_symbol . ' - ' . $r->currency_name; ?></option>
                                                                       }
                                                                    <?php } ?>
                                                               </select>
                                                           </td>
                                                           <td class="w-300"><input name="rate_sgd_dtl[]" value="<?= $d->rate_sgd; ?>" class="rate_sgd_dtl form-control input-xs input-table text-right" readonly="readonly"></td>
                                                            <td class="w-300"><input name="rate_usd_dtl[]" value="<?= $d->rate_usd; ?>" class="rate_usd_dtl form-control input-xs input-table text-right" readonly="readonly"></td>
                                                           <td class="w-300"><input name="price[]" value="<?= $d->price; ?>" class="price form-control input-xs input-table autonum_price text-right"  onkeyup="calculate()" readonly="readonly"></td>
                                                           <td class="w-300"><input name="quantity[]" value="<?= $d->quantity; ?>" class="quantity form-control input-xs input-table autonumber text-right"  onkeyup="calculate()" readonly="readonly"></td>
                                                           <td class="w-300"><input name="remark[]" value="<?= $d->remark; ?>" class="form-control input-xs input-table text-center" readonly="readonly"></td>
                                                        </tr>
                                                        <?php  }
                                                    }
                                                    ?>    
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-body row">
                                <div class="col-md-8">

                                    <div class="form-group">
                                        <label class="col-md-2 control-label padding-right-2">
                                            Payment Terms
                                        </label>
                                        <div class="col-md-10" id="payterm_container">
                                            <?php
                                            $extra_payterm = 'id="payment_term_id" class="form-control"';
                                            $option_payterm[''] = '';
                                            foreach ($cbo_payterm as $r):
												$option_payterm[$r->payment_term_id] = $r->payment_term;
                                            endforeach;
                                            echo form_dropdown('payment_term_id', $option_payterm, $payment_term_id, $extra_payterm);
                                            ?>
                                        </div>
                                    </div>

                                    <div class="form-group" id="fg-remark">
                                        <label class="col-md-2 control-label padding-right-2">
                                            Remark
                                            <a href="#modal_previous" id="previous_remark" data-toggle="modal" class="pull-right" title="Previous Remark">
                                                <i class="fa fa-commenting"></i>
                                            </a>
                                        </label>
                                        <div class="col-md-10">
                                            <textarea rows="5" class="form-control autosizeme" name="quotation_remark" id="quotation_remark"><?php echo $quotation_remark; ?></textarea>
                                        </div>
                                    </div>

                                </div>

                                <div class="col-md-4">


                                    <div class="form-group">
                                        <label class="col-md-6 control-label">Total</label>
                                        <div class="col-md-6" style="padding-left: 2px">
                                            <input readonly="readonly" type="text" class="form-control text-right" name="final_total" id="final_total" value="<?php echo $final_total; ?>" />
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="form-actions">
                                <div class="row">
                                    <div class="col-md-12">
                                        <input type="button" class="btn btn-default fontawesome-font" value="&#xf002 Search Quotation ..." data-target="#modal_find" data-toggle="modal">
                                        <?php echo $btn_print ?>
										<?php echo $btn_delete ?>
                                        <a href="<?php echo site_url('sales-quotation/issue') ?>" type="button" class="btn red pull-right"><i class="fa fa-close"></i> Cancel</a>
                                        <button type="submit" class="btn green pull-right"><i class="fa fa-save"></i> <?php echo $submit_caption ?></button>
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
                            <table id="table_find" class="table table-condensed table-hover table-fixed">
                                <thead>
                                    <tr>
                                        <th class="w-70 text-center">#</th>
                                        <th class="w-120 text-center">Quotation No</th>
                                        <th style="text-align: left;">Customer</th>
                                        <th class="w-120">Sales Person</th>
                                        <th class="w-120 text-center">Status</th>
                                        <th class="w-120">Document Date</th>
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
								<!--<input type="button" id="btn_use_remark" class="btn green" value="Replace Remark" onclick="change_remark();">-->
								<button type="reset" data-dismiss="modal" class="btn red">Close</button>
							</div>
						</div>
					</div>
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

<script type="text/javascript">
    $('input:checkbox').uniform();

    $('select').select2({
        allowClear: true
    });

    $('#rate_usd').autoNumeric('init', {
        mDec: 6
    });

    $('#rate_sgd').autoNumeric('init', {
        mDec: 6
    });

    $('.autonum_com_unit').autoNumeric('init', {
        pSign: 's'
    });

    $('.autonumber').autoNumeric('init');

    $('.autonum_price').autoNumeric('init', {
        mDec: 3,
        aDec: '.',
        aSep: ','
    });

    function removeRow(btn) {
        var row = btn.parentNode.parentNode.parentNode;
        row.parentNode.removeChild(row);
    }

    $('table#tbl_quotation').on('change', '.currency', function () {
      const currency_id = {currency_id: $(this).val()};
      const $row = $(this).closest('tr');
      const $rateset = $row.find('.rate_sgd_dtl');
      const $rateset_usd = $row.find('.rate_usd_dtl');
      const $quantity = $row.find('.quantity');
      const $price = $row.find('.price');

     

        $.ajax({
            dataType: "json",
            type: "POST",
            url: "<?php echo site_url('for_sales_quotation/get_rate') ?>",
            data: currency_id,
            success: function (response){
                $rateset.val(response.rate_sgd);
                $rateset_usd.val(response.rate_usd).attr("rate-set", response.rate_is_set);
                const quantity = $quantity.val();
                const price = $price.val();
                if (price > 0 && quantity > 0) {
                    calculate();
                }
            }
        });
    });

    function add_service() {
        let no = $('table#tbl_quotation tbody tr').length + 1;

        var new_row = $(`<tr>\
            <td class="text-center w-50 bg-editable valign-middle">\
                <div><input type="button" class="btn default btn-xs red-stripe" onclick="removeRow(this)" value="Remove">\</div>
            </td>\
            <td class="w-300">\
               <input class="form-control input-xs input-table service_type" name="service_type[]">\
            </td>\
            <td class="w-300">\
                <select class="form-control input-xs input-table" name="port_service[]">\
                        <?php foreach ($cbo_port as $r) { ?>\
                            <option value="<?php echo $r->port_id; ?>"><?php echo $r->port_name; ?></option>\
                        <?php } ?>\
                </select>\
            </td>\
            <td class="w-300">\
               <input class="form-control input-xs input-table charge_name" name="charge_name[]">\
            </td>\
            <td class="w-300">\
              <input type="text" placeholder="Input" name="desc[]" class="form-control input-xs input-table" >\
            </td>\
            <td class="w-300">\
                <select class="form-control input-xs input-table currency" name="currency[]">\
                        <?php foreach ($cbo_currency as $r) { ?>\
                            <option value="<?php echo $r->currency_id; ?>"><?php echo $r->currency_symbol . ' - ' . $r->currency_name; ?></option>\
                        <?php } ?>\
                </select>\
            </td>\
            <td class="w-300">\
              <input type="text" readonly placeholder="Input" name="rate_sgd_dtl[]" class="rate_sgd_dtl form-control input-xs input-table" >\
            </td>\
            <td class="w-300">\
              <input type="text" readonly placeholder="Input" name="rate_usd_dtl[]" class="rate_usd_dtl form-control input-xs input-table" >\
            </td>\
            <td class="w-300">\
                <input type="text" onkeyup="calculate()" placeholder="Input" name="price[]" class="price autonum_price form-control input-xs input-table" >\
            </td>\
            <td class="w-300">\
                <input type="text" onkeyup="calculate()" placeholder="Input" name="quantity[]" class="quantity autonumber form-control input-xs input-table" >\
            </td>\
            <td class="w-300">\
              <input type="text" name="remark[]" class="form-control input-xs input-table">\
            </td>\
          </tr>`);
        $('table#tbl_quotation').append(new_row);
        $('.autonum_price').autoNumeric('init', {
            mDec: 3,
            aDec: '.',
            aSep: ','
        });
        $('select').select2({
            allowClear: true
        });
    }

    $('#search_find').on('click', function() {
        var find = {
            find: $("#input_find").val()
        };
        $.ajax({
            dataType: "json",
            type: "POST",
            url: "<?php echo site_url('for_sales_quotation/find') ?>",
            data: find,
            success: function(msg) {
               // Pastikan ada data find_record
            if (msg.find_record && msg.find_record.length > 0) {
                var tbody = $('#table_find tbody');
                tbody.empty(); // Kosongkan isi sebelumnya

                var i = 0;
                msg.find_record.forEach(function(r) {
                    i++;
                    var edit_url = "<?php echo site_url('for_sales_quotation/show-find/?id=') ?>" +(r.quotation_hdr_id);
                    var sales_name = (r.sales_firstname || '') + ' ' + (r.sales_lastname || '');
                    var document_date = formatTanggalIndo(r.document_date);

                    var row = '<tr>' +
                        '<td class="text-center w-70">' +
                        '<a href="' + edit_url + '" bariske="' + i + '" type="button" class="btn btn-xs blue btnedit">Select</a>' +
                        '</td>' +
                        '<td class="customer_name w-120 text-center">' + r.quotation_number + '</td>' +
                        '<td class="customer_name">' + r.customer_name + '</td>' +
                        '<td class="marketing_name w-120">' + sales_name + '</td>' +
                        '<td class="sales_status w-120 text-center">' + r.status_name + '</td>' +
                        '<td class="document_date w-120 text-center">' + document_date + '</td>' +
                        '</tr>';
                    
                    tbody.append(row);
                });
            } else {
                // Jika tidak ada data
                $('#your-table-id tbody').html('<tr><td colspan="6" class="text-center">No record found</td></tr>');
            }
            }
        });
    });
    function formatTanggalIndo(dateStr) {
        if (!dateStr) return '';
        var date = new Date(dateStr);
        return date.toLocaleDateString('id-ID'); // Format tanggal lokal
    }
    function calculate() {
        var int = 0;
        var total = 0;

        $('#tbl_quotation tr').each(function() {
            var price = remove_thousand_separator($(this).find("input[name='price[]']").val());
            var quantity = remove_thousand_separator($(this).find("input[name='quantity[]']").val());
            var rate = remove_thousand_separator($(this).find("input[name='rate_usd_dtl[]']").val());


            if (int > 0) {
                total += price*quantity*rate;
            }
            int += 1;
        });

        document.getElementById('final_total').value = number_format(total, 2);
    }
</script>


