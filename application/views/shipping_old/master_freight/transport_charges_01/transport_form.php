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
                                                        <input type="text" class="form-control text-center" name="transport_charges_id" id="transport_charges_id" value="<?php echo $transport_charges_id; ?>" readonly/>
                                                    </div>
                								</div>

                                                <div class="form-group">
                                                    <label class="col-md-2 control-label" for="varchar">Container Size</label>
                                                    <div class="col-md-1">
                                                        <input type="text" class="form-control text-right" name="container_size" id="container_size" value="<?php echo $container_size; ?>" readonly/>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                									<label class="col-md-2 control-label" for="varchar">Validity</label>
                                                    <div class="col-md-3">
                                                        <input type="text" class="form-control date date-picker" name="validity" id="validity" value="<?php echo $validity; ?>" data-date="<?php echo $current_date ?>" data-date-format="dd/mm/yyyy" title="date format : dd/mm/yyyy" />
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
                                                    <label class="col-md-4 control-label" for="varchar">Empty </label>
                                                    <div class="col-md-4">
                                                        <input type="text" class="form-control autonum text-right" name="vendor_empty" id="vendor_empty" value="<?php echo $vendor_empty; ?>"/>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-md-4 control-label" for="varchar">Laden </label>
                                                    <div class="col-md-4">
                                                        <input type="text" class="form-control autonum text-right" name="vendor_laden" id="vendor_laden" value="<?php echo $vendor_laden; ?>"/>
                                                    </div>
                                                </div>

                								<div class="form-group">
                                                    <label class="col-md-4 control-label" for="varchar">Loose Cargo </label>
                                                    <div class="col-md-4">
                                                        <input type="text" class="form-control autonum text-right" name="vendor_loose_cargo" id="vendor_loose_cargo" value="<?php echo $vendor_loose_cargo; ?>"/>
                                                    </div>
                                                </div>

                								<div class="form-group">
                									<label class="col-md-4 control-label" for="varchar">Miscellaneous</label>
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
                                                    <label class="col-md-4 control-label" for="varchar">Empty </label>
                                                    <div class="col-md-4">
                                                        <input type="text" class="form-control autonum text-right" name="cust_empty" id="cust_empty" value="<?php echo $cust_empty; ?>"/>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-md-4 control-label" for="varchar">Laden </label>
                                                    <div class="col-md-4">
                                                        <input type="text" class="form-control autonum text-right" name="cust_laden" id="cust_laden" value="<?php echo $cust_laden; ?>"/>
                                                    </div>
                                                </div>

                								<div class="form-group">
                                                    <label class="col-md-4 control-label" for="varchar">Loose Cargo </label>
                                                    <div class="col-md-4">
                                                        <input type="text" class="form-control autonum text-right" name="cust_loose_cargo" id="cust_loose_cargo" value="<?php echo $cust_loose_cargo; ?>"/>
                                                    </div>
                                                </div>

                								<div class="form-group">
                									<label class="col-md-4 control-label" for="varchar">Miscellaneous</label>
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
										<a href="<?php echo site_url('master-transport') ?>" class="btn red w-100"><i class="fa fa-close"></i> Cancel</a>
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
</script>

<script>
    function change_container(){
        var arr_container_type = $('#container_type').val().split('|');

        $('#container_id').val(arr_container_type[0]);
        $('#container_size').val(arr_container_type[1]);

    }
</script>
