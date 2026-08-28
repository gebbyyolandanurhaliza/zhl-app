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

            <form action="<?php echo $action; ?>" method="post" class="form-horizontal">
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
                                    echo "<input type='hidden' id='fac_id' name='fac_id' value='$factory_id'>";
                                    ?>

                                    <div class="form-group">
                                        <label class="col-md-2 control-label" for="varchar">Quotation No</label>
                                        <div class="col-md-4">
                                            <input readonly="readonly" type="text" class="form-control" name="quotation_number" id="quotation_number" value="<?php echo $quotation_number ?>" placeholder="Auto Generate Once Saved" />
                                        </div>

                                        <label class="col-md-2 control-label" for="varchar">Quotation Status</label>
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
                                        <label class="col-md-2 control-label" for="varchar">Customer</label>
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
//											var customer_id = {customer_id:$("#customer_id").val()};
                                            var customer_id = $("#customer_id").val();
                                            var factory_id = $("#fac_id").val();
                                            var aksi = $("#act").val();

                                            $.ajax({
                                                type: "POST",
                                                url: "<?php echo site_url('sales_quotation/get_customer') ?>",
                                                data: {'customer_id': customer_id},
                                                success: function (msg) {
                                                    $('#div_customer').html(msg);
                                                }
                                            });

                                            $.ajax({
                                                type: "POST",
												url: "<?php echo site_url('sales_quotation/get_payterm_by_customer') ?>",
//                                                url: "<?php // echo site_url('marketing_misc/get_payterm_by_customer') ?>",
                                                data: {'customer_id': customer_id},
                                                success: function (msg) {
                                                    $('#payterm_container').html(msg);
                                                }
                                            });

                                            if (aksi == 'add') {
                                                $.ajax({
                                                    type: "POST",
                                                    url: "<?php echo site_url('sales_quotation/get_product_purchase') ?>",
                                                    data: {
                                                        'customer_id': customer_id,
                                                        'factory_id': factory_id
                                                    },
                                                    success: function (msg) {
                                                        $('#tbl_product_container').html(msg);
                                                    }
                                                });
                                            }
                                            ;
                                        });
                                    </script>

                                    <div id="div_customer">
                                        <div class="form-group">
                                            <label class="col-md-2 control-label" for="varchar">Customer Name</label>
                                            <div class="col-md-10">
                                                <input readonly="readonly" type="text" class="form-control" name="customer_name" id="customer_name" value="<?php echo $customer_name; ?>" />
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-2 control-label" for="varchar">Contact Person</label>
                                            <div class="col-md-4">
                                                <input readonly="readonly" type="text" class="form-control" name="customer_contact_name" id="customer_contact_name" value="<?php echo $customer_contact_name; ?>" />
                                            </div>

                                            <label class="col-md-2 control-label" for="varchar">Customer Ref. No.</label>
                                            <div class="col-md-4">
                                                <input readonly="readonly" type="text" class="form-control" name="customer_reference" id="customer_reference" value="<?php echo $customer_reference; ?>" />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-2 control-label padding-right-2" for="varchar">
                                            Shipping Term
                                            <a href="#modal_create" id="create_trading_term" data-toggle="modal" class="pull-right" title="Create New Shipping Term">
                                                <i class="fa fa-plus-square"></i>
                                            </a>
                                        </label>
                                        <div class="col-md-4" id="trading_term_container">
                                            <?php
                                            $extra_tradingterm = 'class="form-control" ';
                                            $option_tradingterm[''] = '';
                                            foreach ($cbo_tradingterm as $r):
                                                $option_tradingterm[$r->trading_term_id] = $r->trading_term_name . ' (' . $r->trading_term_remark . ')';
                                            endforeach;
                                            echo form_dropdown('trading_term_id', $option_tradingterm, $trading_term_id, $extra_tradingterm);
                                            ?>
                                        </div>

                                        <label class="col-md-2 control-label" for="varchar">Shipment From</label>
                                        <div class="col-md-4">
                                            <?php
                                            $extra_ship_from = 'class="form-control"';
                                            $option_ship_from[''] = '';
                                            $option_ship_from['Singapore'] = 'Singapore';
                                            $option_ship_from['Indonesia'] = 'Indonesia';

                                            echo form_dropdown('shipment_from', $option_ship_from, $shipment_from, $extra_ship_from);
                                            ?>
                                        </div>
                                    </div>

                                    <div class="form-group required">
                                        <label class="col-md-2 control-label" for="varchar">Shipping Period</label>
                                        <div class="col-md-4">
                                            <div class="input-group date date-picker" data-date-format="mm/yyyy" >
                                                <div class="input-group date-picker input-daterange" data-date="<?php echo $current_date ?>" data-date-format="mm/yyyy"
                                                     data-date-viewmode="years" data-date-minviewmode="months">
                                                    <input required type="text" class="form-control" name="shipping_period1" value="<?php echo $shipping_period1 ?>" title="date format : mm/yyyy">
                                                    <span class="input-group-addon" style="background: transparent; border-color: transparent">to</span>
                                                    <input required type="text" class="form-control" name="shipping_period2" value="<?php echo $shipping_period2; ?>" title="date format : mm/yyyy">
                                                </div>											
                                            </div>	

                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-2 control-label" for="varchar">Destination</label>
                                        <div class="col-md-4">
                                            <?php
                                            $extra_destination = 'id="destination_id" class="form-control"';
                                            $option_destination[''] = '';
                                            foreach ($cbo_destination as $r):
                                                $option_destination[$r->country_id] = $r->country_name;
                                            endforeach;
                                            echo form_dropdown('destination_id', $option_destination, $destination_id, $extra_destination);
                                            ?>
                                        </div>

                                        <label class="col-md-2 control-label" for="varchar">Port</label>
                                        <div class="col-md-4">
                                            <div id="div_port">
                                                <?php
                                                $extra_port = 'id="port_id" class="form-control"';
                                                $option_port[''] = '';
                                                foreach ($cbo_port as $r):
                                                    $option_port[$r->port_id] = $r->port_name;
                                                endforeach;
                                                echo form_dropdown('port_id', $option_port, $port_id, $extra_port);
                                                ?>
                                            </div>
                                        </div>

                                        <script type="text/javascript">
                                            $('#destination_id').change(function () {
                                                var destination_id = {destination_id: $("#destination_id").val()};
                                                $('#port_id').select2('val', '');
                                                $.ajax({
                                                    type: "POST",
                                                    url: "<?php echo site_url('sales_quotation/get_port') ?>",
                                                    data: destination_id,
                                                    success: function (msg) {
                                                        $('#div_port').html(msg);
                                                    }
                                                });
                                            });
                                        </script>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-2 control-label" for="varchar">Container Loading</label>
                                        <div class="col-md-4">
                                            <?php
                                            $extra_container = 'id="container_id" class="form-control"';
                                            $option_container[''] = '';
                                            foreach ($cbo_container as $r):
                                                $option_container[$r->container_id] = $r->container_name;
                                            endforeach;
                                            echo form_dropdown('container_id', $option_container, $container_id, $extra_container);
                                            ?>											
                                        </div>

                                        <label class="col-md-2 control-label" for="varchar">Shipping Mode</label>
                                        <div class="col-md-4">
                                            <?php
                                            $extra_shipping_mode = 'id="container_id" class="form-control"';
                                            $option_shipping_mode[''] = '';
                                            $option_shipping_mode['By Sea'] = 'By Sea';
                                            $option_shipping_mode['By Air'] = 'By Air';
                                            $option_shipping_mode['By Land'] = 'By Land';
                                            echo form_dropdown('shipping_mode', $option_shipping_mode, $shipping_mode, $extra_shipping_mode);
                                            ?>
                                                <!--<input type="text" class="form-control" name="shipping_mode" id="shipping_mode" value="<?php // echo $shipping_mode;  ?>" />-->									
                                        </div>
                                    </div>

                                    <div class="form-group required">
                                        <label class="col-md-2 control-label" for="varchar">Local Currency</label>
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

                                        <div id="div_rate">
                                            <div class="col-md-3">												
                                                <div id="div_rate_usd" class="input-group">		
                                                    <span class='input-group-addon'>US$</span>
                                                    <input required type="text" class="form-control text-right autofocus" name="rate_usd" id="rate_usd" placeholder="0.000000" value="<?php echo $rate_usd; ?>" title="6 digits decimal" />
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div id="div_rate_sgd" class="input-group">
                                                    <span class='input-group-addon'>SIN$</span>
                                                    <input required type="text" class="form-control text-right autofocus" name="rate_sgd" id="rate_sgd" placeholder="0.000000" value="<?php echo $rate_sgd; ?>" title="6 digits decimal" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <script type="text/javascript">
                                        $('#local_currency').change(function () {
                                            var currency_id = {currency_id: $("#local_currency").val()};
                                            $.ajax({
                                                type: "POST",
                                                url: "<?php echo site_url('sales_quotation/get_rate') ?>",
                                                data: currency_id,
                                                success: function (msg) {
                                                    $('#div_rate').html(msg);
                                                }
                                            });
                                        });
                                    </script>

                                    <br/>

                                    <div class="col-md-12">
                                        <div class="table-toolbar">
                                            <div class="row">
                                                <!--									<h5 class="form-section">-->
                                                <a class="btn btn-default btn-large" id="add_agent" name="add_agent">
                                                    <i class="fa fa-plus"></i>
                                                    Add Agent
                                                </a>
                                                <!--</h5>-->
                                            </div>
                                        </div>
                                    </div>									

                                    <script type="text/javascript">
                                        $("#add_agent").click(function () {
                                            $.ajax({
                                                type: "POST",
                                                url: "<?php echo site_url('sales_quotation/add_agent_row') ?>",
                                                success: function (msg) {
                                                    $('#tbl_agent > tbody:last-child').append(msg);
                                                }
                                            });
                                        });
                                    </script>

                                    <div class="agent-scroll">
                                        <table width="100%" id="tbl_agent" class="table table-detail">
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th width="60%" class="text-left">Agent Name</th>
                                                    <th width="13%" class="text-center">USD Com (%)</th>
                                                    <th width="13%" class="text-center">USD Com/Unit</th>
                                                    <th width="10%" class="text-center">Invoice</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                if ($agent_list) {
                                                    foreach ($agent_list as $ag) {
                                                        ?>

                                                        <tr>
                                                            <td class="bg-editable"><input type="button" class="btn default red-stripe" onclick="removeRow(this)" value="Remove"></td>
                                                            <td class="bg-editable">
                                                                <?php
                                                                $extra_agent = 'id= "agent_id" class="form-control"';
                                                                $option_agent[''] = '';
                                                                if ($cbo_agent) {
                                                                    foreach ($cbo_agent as $r):
                                                                        $option_agent[$r->agent_id] = $r->agent_name;
                                                                    endforeach;
                                                                }
                                                                echo form_dropdown('agent_id[]', $option_agent, $ag->agent_id, $extra_agent);
                                                                ?>
                                                            </td>
                                                            <td class="bg-editable">
                                                                <input type="text" value="<?php echo $ag->com_percent ?>" onkeyup="agent_percent()" class="form-control autonum_com_percent text-right" name="agent_com_percent[]" id="agent_com_percent" data-a-sign=" %" data-p-sign="s" data-v-max="100" placeholder="0.00 %" />
                                                            </td>
                                                            <td class="bg-editable">
                                                                <input type="text" value="<?php echo $ag->com_unit ?>" onkeyup="agent_unit()" class="form-control autonum_com_unit text-right" name="agent_com_unit[]" id="agent_com_unit" data-p-sign="s" placeholder="0.00"/>
                                                            </td>
                                                            <td class="bg-editable text-center">															
                                                                <?php
                                                                $checked = ($ag->invoice == 1 ? true : false);
                                                                echo form_checkbox('agent_invoice[]', '1', $checked);
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

                                <div class="col-md-4">
                                    <div class="form-group required">
                                        <label class="col-md-4 control-label" for="varchar">Sales Person</label>
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
                                        <label class="col-md-4 control-label" for="varchar">Document Date</label>
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
                                        <label class="col-md-4 control-label" for="varchar">Validity Date</label>
                                        <div class="col-md-8">
                                            <div class="input-group date date-picker" data-date-format="dd/mm/yyyy" >
                                                <span class="input-group-btn">
                                                    <button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
                                                </span>
                                                <input type="text" name="validity_date" id="validity_date" class="form-control" value="<?php echo $validity_date; ?>" title="date format : dd/mm/yyyy">												
                                            </div>	
                                            <!--<input type="text" class="form-control date date-picker" data-date="12-02-2012" data-date-format="mm-dd-yyyy" name="posting_date" id="posting_date" placeholder="First Posting Date" value="<?php echo $posting_date; ?>" title="date format : mm/dd/yyyy" />-->
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
                                                    <a class="btn btn-primary btn-large" data-target="#modal_product" data-toggle="modal">
                                                        <i class="fa fa-plus"></i>
                                                        Add Product ...
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="tbl_product_container">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-condensed table-detail" id="tbl_quotation">
                                                <thead>
                                                    <tr>
                                                        <th scope="col" style="width:50px !important">#</th>
                                                        <th scope="col">Product Description</th>
                                                        <th scope="col">Product Code</th>
                                                        <th scope="col">Product Brand</th>
                                                        <th scope="col">Factory</th>	
														<th scope="col">UOM</th>
                                                        <th scope="col">Price</th>
                                                        <th scope="col">Quantity</th>
                                                        <th scope="col">Total Amount</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $last_count = 0;
                                                    if ($detail) {
                                                        foreach ($detail as $d) {
                                                            $last_count++;
                                                            $sub_total = $d->price * $d->quantity;

                                                            echo '<tr>';
                                                            echo '<td class="text-center w-50 bg-editable valign-middle">';
                                                            echo '<div class="input-group input-table-group">';
                                                            echo '<input type="button" class="btn default btn-xs red-stripe" onclick="removeRow(this)" value="Remove">';
                                                            echo '<span class="input-group-addon input-table-group-addon bootstrap-touchspin-postfix num">' . $last_count . '</span>';
                                                            echo '</div>';
                                                            echo '<input type="hidden" name="product_id[]" class="p_id" value="' . $d->product_id . '">';
                                                            echo '<input type="hidden" name="factory_id[]" class="f_id" value="' . $factory_id . '">';
                                                            echo '<input type="hidden" name="quotation_dtl_id[]" value="' . $d->quotation_dtl_id . '">';
                                                            echo '</td>';
                                                            echo '<td class="w-300"><input name="product_name[]" class="form-control input-xs input-table" placeholder="Product Name" readonly="readonly" value="' . $d->product_name . '" title="' . $d->product_name . '"></td>';
                                                            echo '<td class="w-180"><input name="product_code[]" class="form-control input-xs input-table" placeholder="Product Code" readonly="readonly" value="' . $d->product_code . '" title="' . $d->product_code . '"></td>';
															echo '<td class="w-180 bg-editable">';
                                                            echo '<input name="detail_brand_id[]" id="br-'.$last_count.'" value="'.$d->detail_brand_id.'" type="hidden" class="form-control brand-text input-xs input-table">';
															echo '<input name="brand_name[]" id="brn-'. $last_count .'" value="'.$d->detail_brand_name.'" onClick="viewModalSelectBrand(this.id)" class="form-control input-xs input-table" placeholder="Select Brand" readonly="readonly" style="cursor:pointer;">';
//															echo '<input name="brand[]" value="'.$d->brand_name.'" class="form-control input-xs input-table" readonly="readonly">';
                                                            echo '</td>';
                                                            echo '<td class="w-100"><input name="factory[]" value="' . $d->factory_abbr . '" class="form-control input-xs input-table" readonly="readonly"></td>';
															echo '<td class="w-150"><input name="uom[]" value="' . $d->cma_uom_quantity_id . '" class="form-control input-xs input-table" readonly="readonly"></td>';
                                                            echo '<td class="w-100 bg-editable"><input required name="price[]" value="' . $d->price . '" type="text" class="form-control input-xs text-right input-table autonum_price autofocus" onkeyup="calculate()"></td>';
                                                            echo '<td class="w-100 bg-editable"><input required name="qty[]" value="' . $d->quantity . '" type="text" class="form-control input-xs text-right input-table autonum_qty autofocus" data-v-min="0" onkeyup="calculate()"></td>';
                                                            echo '<td class="w-130"><input name="total[]" value="' . number_format($sub_total, 2, '.', ',') . '" type="text" class="form-control input-xs text-right input-table" readonly="readonly">';
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
                                <div class="col-md-8">

                                    <div class="form-group">
                                        <label class="col-md-2 control-label padding-right-2" for="varchar">
                                            Payment Terms
<!--                                            <a href="#modal_create" id="create_payterm" data-toggle="modal" class="pull-right" title="Create New Payment Term">
                                                <i class="fa fa-plus-square"></i>
                                            </a>-->
                                        </label>
                                        <div class="col-md-10" id="payterm_container">											
                                            <?php
//											$extra_payterm = 'id="payment_term" class="form-control"';
//                                            $option_payterm[''] = '';
//											$option_payterm[''] = trim($payment_term);
//                                            foreach ($cbo_payterm as $r):
//												if (trim($payment_term) != trim($r->payment_term)){
//													$option_payterm[$r->payment_term] = $r->payment_term;
//												}
//                                            endforeach;
//                                            echo form_dropdown('payment_term', $option_payterm, $payment_term, $extra_payterm);
//											
                                            $extra_payterm = 'id="payment_term_id" class="form-control"';
                                            $option_payterm[''] = '';
                                            foreach ($cbo_payterm as $r):												
												$option_payterm[$r->payment_term_id] = $r->payment_term;
                                            endforeach;
                                            echo form_dropdown('payment_term_id', $option_payterm, $payment_term_id, $extra_payterm);
                                            ?>																				
                                        </div>
                                    </div>

                                    <div class="form-group">										
                                        <label class="col-md-2 control-label padding-right-2" for="varchar">
                                            Shelf Life
                                            <a href="#modal_create" id="create_shelf_life" data-toggle="modal" class="pull-right" title="Create New Shelf Life">
                                                <i class="fa fa-plus-square"></i>
                                            </a>
                                        </label>
                                        <div class="col-md-4" id="shelf_life_container">
                                            <?php
                                            $extra_shelf = 'id="product_shelf_life_id" class="form-control"';
                                            $option_shelf[''] = '';
                                            foreach ($cbo_shelf as $r):
                                                $option_shelf[$r->product_shelf_life_id] = $r->product_shelf_life;
                                            endforeach;
                                            echo form_dropdown('product_shelf_life_id', $option_shelf, $product_shelf_life_id, $extra_shelf);
                                            ?>												
                                        </div>
                                        <span class="help-inline">from date of production</span>
                                    </div>


                                    <!--<h4 class="form-section">Additional Information</h4>-->

                                    <div class="form-group">
                                        <label class="col-md-2 control-label" for="varchar">Partial Shipment</label>
                                        <div class="col-md-4">
                                            <?php
                                            $extra_partial_shipment = 'id="partial_shipment" class="form-control"';
                                            $option_partial_shipment[''] = '';

                                            $option_partial_shipment['Allowed'] = 'Allowed';
                                            $option_partial_shipment['Not Allowed'] = 'Not Allowed';

                                            echo form_dropdown('partial_shipment', $option_partial_shipment, $partial_shipment, $extra_partial_shipment);
                                            ?>											
                                        </div>

                                        <label class="col-md-2 control-label" for="varchar">Marine Insurance</label>
                                        <div class="col-md-4">
                                            <?php
                                            $extra_marine_insurance = 'id="marine_insurance" class="form-control"';
                                            $option_marine_insurance[''] = '';

                                            $option_marine_insurance['Covered By Buyer'] = 'Covered By Buyer';
                                            $option_marine_insurance['Covered By Seller'] = 'Covered By Seller';

                                            echo form_dropdown('marine_insurance', $option_marine_insurance, $marine_insurance, $extra_marine_insurance);
                                            ?>											
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-2 control-label" for="varchar">Shipping Line</label>
                                        <div class="col-md-10">
                                            <?php
                                            $extra_shipping_line = 'id="shipping_id" class="form-control"';
                                            $option_shipping_line[''] = '';
                                            foreach ($cbo_shipping_line as $r):
                                                $option_shipping_line[$r->shipping_id] = $r->shipping_name;
                                            endforeach;
                                            echo form_dropdown('shipping_id', $option_shipping_line, $shipping_id, $extra_shipping_line);
                                            ?>
                                                <!--<input type="text" class="form-control" name="shipping_line" id="shipping_line" value="<?php // echo $shipping_line;  ?>" />-->
                                        </div>										
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-2 control-label" for="varchar">Shipment Schedule</label>
                                        <div class="col-md-10">
                                            <textarea rows="3" class="form-control autosizeme" name="shipment_schedule" id="shipment_schedule"><?php echo $shipment_schedule; ?></textarea>
                                        </div>
                                    </div>

                                    <div class="form-group" id="fg-remark">
                                        <label class="col-md-2 control-label padding-right-2" for="varchar">
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
                                        <label class="col-md-6 control-label" for="varchar">Total before discount</label>
                                        <div class="col-md-6" style="padding-left: 2px">
                                            <input type="text" readonly="readonly" class="form-control text-right" name="total_before_disc" id="total_before_disc" value="<?php echo $total_before_disc; ?>" />
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-3 control-label label-sm" for="varchar">Discount</label>
                                        <div class="col-md-3" style="padding-right: 2px">
                                            <!--<div class="input-group input-icon input-icon-sm right">-->
                                                    <!--<i class="fa fa-percent"></i>-->
                                            <input type="text" class="form-control autonumber text-right" name="discount" id="discount" data-a-sign=" %" data-p-sign="s" data-v-max="100" placeholder="0.00 %" value="<?php echo $discount; ?>" onkeyup="re_calculate()"/>
                                            <!--</div>-->
                                        </div>
                                        <div class="col-md-6" style="padding-left: 2px">
                                            <input type="text" class="form-control text-right" name="total_disc" id="total_disc" value="<?php echo $total_disc; ?>" readonly="readonly"/>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-6 control-label" for="varchar">Freight</label>
                                        <div class="col-md-6" style="padding-left: 2px">
                                            <input type="text" class="form-control autonumber text-right" name="freight" id="freight" value="<?php echo $freight; ?>" onkeyup="re_calculate()"/>
                                        </div>										
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-6 control-label" for="varchar">Tax</label>
                                        <div class="col-md-6" style="padding-left: 2px">
                                            <input type="text" class="form-control autonumber text-right" name="tax" id="tax" value="<?php echo $tax; ?>" onkeyup="re_calculate()"/>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-6 control-label" for="varchar">Total</label>
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

<div id="add_product">
    <div id="modal_product" class="modal fade bs-modal-lg" role="dialog" tabindex="-1" data-backdrop="static" data-keyboard="false"  aria-hidden="true">
        <div class="modal-dialog modal-full">
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
    $('select').select2({
        allowClear: true
    });

    $('#rate_usd').autoNumeric('init', {
        mDec: 6
    });

    $('#rate_sgd').autoNumeric('init', {
        mDec: 6
    });

    $('.autonum_com_percent').autoNumeric('init', {
        aSign: ' %',
        pSign: 's'		//suffix to the right
    });

    $('.autonum_com_unit').autoNumeric('init', {
        pSign: 's'
    });

    $('.autonumber').autoNumeric('init');

    $('#search_product').on('click', function () {
        var param = $("#input_search").val();
        var p_id = $("input[name='product_id[]']").map(function () {
            return this.value;
        }).get();
        var f_id = $("input[name='factory_id[]']").map(function () {
            return this.value;
        }).get();

        $.ajax({
            type: "POST",
            url: "<?php echo site_url('marketing_misc/search_product/quotation') ?>",
            data: {
                "product_id[]": p_id,
                "factory_id[]": f_id,
                "param": param
            },
            success: function (msg) {
                $('#table_container').html(msg);
            }
        });
    });

//	$('#search_product').click(function(){
//		var search = {search:$("#input_search").val()};
//				
//		$.ajax({
//			type: "POST",
//			url : "<?php // echo site_url('marketing_misc/search_product/quotation') ?>",
//			data: search,
//			success: function(msg){
//				$('#table_container').html(msg);
//			}
//		});		
//	});

    $('#search_find').on('click', function () {
        var find = {find: $("#input_find").val()};
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('sales-quotation/find') ?>",
            data: find,
            success: function (msg) {
                $('#table_find').html(msg);
            }
        });
    });

    $('#previous_remark').on('click', function () {
        var cust_id = $('#customer_id').val();

        if (cust_id == '') {
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
        }
        ;
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('sales-quotation/previous-remark') ?>",
            data: "customer_id=" + cust_id,
            success: function (msg) {
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
		$('#quotation_remark').append('\n');
		$('#quotation_remark').append($('#selected_remark').val());		
		$('#modal_previous').modal('hide');
	});
	
	$('#btn_use_remark').click(function(){
		var sel_rem = $('#selected_remark').val();
		if (sel_rem == ''){
			bootbox.alert('Remark are empty!');
			return false;
		};
		$('#quotation_remark').text($('#selected_remark').val());
		$('#quotation_remark').append('\n');		
		$('#modal_previous').modal('hide');
	});

    $('#btn_delete').on('click', function () {
        var headerid = $(this).attr('headerid');
        var datanumber = $(this).attr('data-number');

//		bootbox.confirm('<i class="fa fa-question-circle"></i> Are you sure want to delete sales quotation data with number "-'+datanumber+'-" ?',function(result){			
        bootbox.confirm({
            size: 'large',
            title: '<div class="caption"><i class="fa fa-question-circle theme-font"></i><span class="caption-subject theme-font uppercase"> DELETE CONFIRMATION</span></div>',
            message: 'Are you sure want to delete sales quotation data with number "' + datanumber + '" ?',
            callback: function (result) {
                if (result) {
                    $.ajax({
                        url: "<?php echo site_url('sales_quotation/delete'); ?>",
                        type: "POST",
                        data: "headerid=" + headerid,
                        cache: false,
                        success: function () {
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
                            return location.href = "<?php echo site_url('sales_quotation/issue'); ?>";
                        },
                        error: function () {
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
                            return location.href = "<?php echo site_url('sales_quotation/issue'); ?>";
                        }
                    });
                } else {
                    console.log("Declined delete sales quotation data.");
                }
            }
        });
    });

    $('#create_trading_term').on('click', function () {
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('marketing_misc/modal/trading_term') ?>",
            success: function (msg) {
                $('#form_create').html(msg);
            }
        });
    });

    $('#create_payterm').on('click', function () {
        var cust_id = $('#customer_id').val();
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('marketing_misc/modal/payterm') ?>",
            data: {"cust_id": cust_id},
            success: function (msg) {
                $('#form_create').html(msg);
            }
        });
    });

    $('#create_shelf_life').on('click', function () {
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('marketing_misc/modal/shelf_life') ?>",
            success: function (msg) {
                $('#form_create').html(msg);
            }
        });
    });

    //fungsi ini untuk menghilangkan list data di modal
    $('.modal').on('hidden.bs.modal', function () {
        $('.v-scroll').html('');
    });

    //select all text on focused
//	$('.input-table').on('click', function(){
//		this.select();
//	});

    //select all text on focused
    $('.autofocus').on('click', function () {
        this.select();
    });

    $('#agen_commission').on('click', function () {
        this.select();
    });

    $('.autonumber').on('click', function () {
        this.select();
    });
</script>

<!-- Select Brand -->
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
<script>
    function viewModalSelectBrand(id){
        $('#id-brand-this').val(id);
        $.ajax({
            url: "<?php echo site_url('Sales_quotation/loadDataAjaxForSelectBrand');?>",
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
        
        var thisID  = $('#id-brand-this').val();
        var getNumIdCFBefore    = thisID.substr(4,1);
        var currentID           = parseInt(getNumIdCFBefore);
        $('#'+thisID).val(getText(document.getElementById('tbl-selectBrand').rows[$r].cells[1]));
        $('#br-'+currentID).val(getText(document.getElementById('tbl-selectBrand').rows[$r].cells[0]));
        
        $('#modal-select-brand').modal('hide');
    }
    
    function select_product()
    {
        function getText(el) {
            if (typeof el.textContent == 'string')
                return el.textContent;
            if (typeof el.innerText == 'string')
                return el.innerText;
        }

        var chk_arr = document.getElementsByName("chk[]");
        var chk_length = chk_arr.length;
//		var f_id_pre = '';
//		
        i = 1;
        n = 1;
        var roww = $('#tbl_quotation tr').length;
        if(roww == 1){
            var currentID = roww;
            var currentID2 = roww;
        }else{
            var idCFbefore  = $('#tbl_quotation tr:last input.brand-text').attr("id");
            var getNumIdCFBefore    = idCFbefore.substr(3,1);
            currentID   = parseInt(getNumIdCFBefore)+1;
            currentID2   = parseInt(getNumIdCFBefore)+1;
        }
        for (r = 0; r < chk_length; r++) {
            if (chk_arr[r].checked == true) {
//				if (f_id_pre != '' && f_id_pre != getText(document.getElementById('tbl_product').rows[i].cells[7])){
//					bootbox.alert('Please select product from the same factory');
//				} else {
//					count += 1;
                var baris = $('#tbl_quotation tr').length;
                var nn = currentID++;
                var nnn = currentID2++;
                $('#tbl_quotation > tbody:last-child').append(
                        '<tr>\n\
                                <td class="text-center w-50 bg-editable valign-middle">\n\
                                        <div class="input-group input-table-group">\n\
                                        <input type="button" class="btn default btn-xs red-stripe" onclick="removeRow(this)" value="Remove">\n\
                                        <span class="input-group-addon input-table-group-addon bootstrap-touchspin-postfix num">' + baris + '</span>\n\
                                        </div>\n\
                                        <input type="hidden" name="product_id[]" class="p_id" value="' + getText(document.getElementById('tbl_product').rows[i].cells[1]) + '">\n\
                                        <input type="hidden" name="factory_id[]" class="f_id" value="' + getText(document.getElementById('tbl_product').rows[i].cells[7]) + '">\n\
                                        <input type="hidden" name="quotation_dtl_id[]" value="0">\n\
                                </td> \n\
                                <td class="w-300"><input name="product_name[]" class="form-control input-xs input-table" placeholder="Product Name" readonly="readonly" value="' + getText(document.getElementById('tbl_product').rows[i].cells[2]) + '" title="' + getText(document.getElementById('tbl_product').rows[i].cells[2]) + '"></td>\n\
                                <td class="w-180"><input name="product_code[]" class="form-control input-xs input-table" placeholder="Product Code" readonly="readonly" value="' + getText(document.getElementById('tbl_product').rows[i].cells[3]) + '" title="' + getText(document.getElementById('tbl_product').rows[i].cells[3]) + '"></td>\n\
								<td class="w-180 bg-editable">\n\
                                    <input name="detail_brand_id[]" id="br-'+nn+'" type="hidden" class="form-control brand-text input-xs input-table" placeholder="Select Brand" readonly="readonly">\n\
                                    <input name="brand_name[]" id="brn-'+nnn+'" onClick="viewModalSelectBrand(this.id)" class="form-control input-xs input-table" placeholder="Select Brand" readonly="readonly" style="cursor:pointer;">\n\
                                </td>\n\
                                <td class="w-100"><input name="factory[]" value="' + getText(document.getElementById('tbl_product').rows[i].cells[4]) + '" class="form-control input-xs input-table" readonly="readonly"></td>\n\
								<td class="w-150"><input name="uom[]" value="' + getText(document.getElementById('tbl_product').rows[i].cells[6]) + '" class="form-control input-xs input-table" readonly="readonly"></td>\n\
                                <td class="w-100 bg-editable"><input required name="price[]" type="text" class="form-control input-xs text-right input-table autonum_price autofocus" data-v-min="0" onkeyup="calculate()" value=""></td>\n\
                                <td class="w-100 bg-editable"><input required name="qty[]" type="text" class="form-control input-xs text-right input-table autonum_qty autofocus" data-v-min="0" onkeyup="calculate()" value=""></td>\n\
                                <td class="w-130"><input name="total[]" type="text" class="form-control input-xs text-right input-table" readonly="readonly" value=""></td>\n\
                        </tr>'
                        );

//					f_id_pre = getText(document.getElementById('tbl_product').rows[i].cells[7]);
//				}
            }
            i++;
        }
        $('#modal_product').modal('hide');

        $('.autonum_price').autoNumeric('init', {
            mDec: 3,
            aDec: '.',
            aSep: ','
        });

        $('.autonum_qty').autoNumeric('init', {
            mDec: 0
        });

        //select all text on focused
        $('.autofocus').on('click', function () {
            this.select();
        });

        re_calculate;
    }

    $('.autonum_price').autoNumeric('init', {
        mDec: 3,
        aDec: '.',
        aSep: ','
    });
    $('.autonum_qty').autoNumeric('init', {
        mDec: 0
    });
	
	function updateRowOrder() {
        $('span.num').each(function (i) {
            $(this).text(i + 1);
        });
    }

    function removeRow(btn) {
        var row = btn.parentNode.parentNode.parentNode;
		row.parentNode.removeChild(row);
		updateRowOrder();
    }

    function removeAgent(btn) {
        var row = btn.parentNode.parentNode;
        row.parentNode.removeChild(row);
    }

    function disc() {
        var dis = remove_percent(document.getElementById('discount').value);
        var total = remove_thousand_separator(document.getElementById('total_before_disc').value);
        var grand_total = total * (dis / 100);
        document.getElementById('total_disc').value = number_format(grand_total, 2);

    }

    function calculate() {
        var int = 0;
        var total = 0;

        $('#tbl_quotation tr').each(function () {
            var qty = remove_thousand_separator($(this).find("input[name='qty[]']").val());
            var price = remove_thousand_separator($(this).find("input[name='price[]']").val());
            var total_row = qty * price;

            $(this).find("input[name='total[]']").val(number_format(total_row, 2));

            if (int > 0) {
                total += total_row;
            }
            int += 1;
        });

        document.getElementById('total_before_disc').value = number_format(total, 2);
        disc();

        var total_disc = remove_thousand_separator(document.getElementById('total_disc').value);
        var freight = remove_thousand_separator(document.getElementById('freight').value);
        var tax = remove_thousand_separator(document.getElementById('tax').value);
        var final_total = total - total_disc - freight - tax;
        document.getElementById('final_total').value = number_format(final_total, 2);
    }

    function re_calculate() {
        var dis = remove_thousand_separator(document.getElementById('discount').value) / 100;
        var total = remove_thousand_separator(document.getElementById('total_before_disc').value);
        var grand_total = total * dis;
        document.getElementById('total_disc').value = number_format(grand_total, 2, '.', ',');

        calculate();
    }

    function agent_com() {
        var com_percent = remove_percent(document.getElementById('agent_com_percent').value);
        var com_unit = remove_thousand_separator(document.getElementById('agent_com_unit').value);

        if (com_percent > 0) {
            document.getElementById('agent_com_unit').value = 0;
            document.getElementById('agent_com_percent').value = com_percent;
        }

        if (com_unit > 0) {
            document.getElementById('agent_com_unit').value = com_unit;
            document.getElementById('agent_com_percent').value = 0;
        }
    }

    function agent_percent() {
        var com_percent = remove_percent(document.getElementById('agent_com_percent').value);

        if (com_percent > 0) {
            document.getElementById('agent_com_unit').value = '';
        }
    }

    function agent_unit() {
        var com_unit = remove_thousand_separator(document.getElementById('agent_com_unit').value);

        if (com_unit > 0) {
            document.getElementById('agent_com_percent').value = '';
        }
    }

    function select_remark(ind){
		 function getText(el){
            if (typeof el.textContent == 'string') return el.textContent;
            if (typeof el.innerText == 'string') return el.innerText;
        }

        $r = ind.rowIndex;
        document.getElementById('selected_remark').value = getText(document.getElementById('tbl_previous').rows[$r].cells[1]);
	}

</script>
