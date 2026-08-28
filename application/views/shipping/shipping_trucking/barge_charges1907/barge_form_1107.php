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
                                                        <input type="text" class="form-control text-center" name="barge_charges_id" id="barge_charges_id" value="<?php echo $barge_charges_id; ?>" readonly/>
                                                    </div>
                								</div>

                                                <div class="form-group">
                                                    <label class="col-md-2 control-label" for="varchar">Container Size</label>
                                                    <div class="col-md-1">
                                                        <input type="text" class="form-control text-right" name="container_size" id="container_size" value="<?php echo $container_size; ?>" readonly/>
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
                                                    <label class="col-md-4 control-label" for="varchar">Export Empty </label>
                                                    <div class="col-md-4">
                                                        <input type="text" class="form-control autonum text-right" name="vendor_export_empty" id="vendor_export_empty" value="<?php echo $vendor_export_empty; ?>"/>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-md-4 control-label" for="varchar">Export Reefer </label>
                                                    <div class="col-md-4">
                                                        <input type="text" class="form-control autonum text-right" name="vendor_export_reefer" id="vendor_export_reefer" value="<?php echo $vendor_export_reefer; ?>"/>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-md-4 control-label" for="varchar">Export Laden </label>
                                                    <div class="col-md-4">
                                                        <input type="text" class="form-control autonum text-right" name="vendor_export_laden" id="vendor_export_laden" value="<?php echo $vendor_export_laden; ?>"/>
                                                    </div>
                                                </div>

                								<div class="form-group">
                                                    <label class="col-md-4 control-label" for="varchar">Import Transhipment </label>
                                                    <div class="col-md-4">
                                                        <input type="text" class="form-control autonum text-right" name="vendor_import_transhipment" id="vendor_import_transhipment" value="<?php echo $vendor_import_transhipment; ?>"/>
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
                                                    <label class="col-md-4 control-label" for="varchar">Export Empty </label>
                                                    <div class="col-md-4">
                                                        <input type="text" class="form-control autonum text-right" name="cust_export_empty" id="cust_export_empty" value="<?php echo $cust_export_empty; ?>"/>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-md-4 control-label" for="varchar">Export Reefer </label>
                                                    <div class="col-md-4">
                                                        <input type="text" class="form-control autonum text-right" name="cust_export_reefer" id="cust_export_reefer" value="<?php echo $cust_export_reefer; ?>"/>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-md-4 control-label" for="varchar">Export Laden </label>
                                                    <div class="col-md-4">
                                                        <input type="text" class="form-control autonum text-right" name="cust_export_laden" id="cust_export_laden" value="<?php echo $cust_export_laden; ?>"/>
                                                    </div>
                                                </div>

                								<div class="form-group">
                                                    <label class="col-md-4 control-label" for="varchar">Import Transhipment </label>
                                                    <div class="col-md-4">
                                                        <input type="text" class="form-control autonum text-right" name="cust_import_transhipment" id="cust_import_transhipment" value="<?php echo $cust_import_transhipment; ?>"/>
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
										<a href="<?php echo site_url('master-barge') ?>" class="btn red w-100"><i class="fa fa-close"></i> Cancel</a>
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
