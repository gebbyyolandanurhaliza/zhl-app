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
                									<label class="col-md-2 control-label" for="varchar">Container Size </label>
                									<div class="col-md-3">
                                                     <select name="container_size" id="container_size" class="form-control select2me">
                                                            <option value="20" <?php if($container_size == '20'){echo 'selected';}?>>Container 20Ft</option>
                                                            <option value="40" <?php if($container_size == '40'){echo 'selected';}?>>Container 40Ft</option>
                                                            <option value="20 reefer" <?php if($container_size == '20 reefer'){echo 'selected';}?>>Container 20Ft Reefer</option>
                                                            <option value="40 reefer" <?php if($container_size == '40 reefer'){echo 'selected';}?>>Container 40Ft Reefer</option>
                                                     </select>
                									</div>
                                                    <div class="col-md-1 pull-right">
                                                        <input type="text" class="form-control text-center" name="trucking_id" id="trucking_id" value="<?php echo $trucking_id; ?>" readonly/>
                                                    </div>
                								</div>

                                                <div class="form-group">
													<label class="col-md-2 control-label padding-right-2" for="varchar">Validity</label>
			                                        <div class="col-md-3">
			                                            <div class="input-group date date-picker" data-date-format="mm/yyyy" >
			                                                <div class="input-group date-picker input-daterange" data-date="<?php echo $current_date ?>" data-date-format="dd/mm/yyyy">
			                                                    <input type="text" class="form-control" name="validity_from" value="<?php echo $validity_from;?>" title="date format : dd/mm/yyyy">
			                                                    <span class="input-group-addon" style="background: transparent; border-color: transparent">to</span>
			                                                    <input type="text" class="form-control" name="validity_until" value="<?php echo $validity_until;?>" title="date format : dd/mm/yyyy">
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
                                                    <label class="col-md-4 control-label" for="varchar">Trucking </label>
                                                    <div class="col-md-4">
                                                        <input type="text" class="form-control autonum text-right" name="vendor_trucking_price" id="vendor_trucking_price" value="<?php echo $vendor_trucking_price; ?>"/>
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
                                                    <label class="col-md-4 control-label" for="varchar">Trucking </label>
                                                    <div class="col-md-4">
                                                        <input type="text" class="form-control autonum text-right" name="cust_trucking_price" id="cust_trucking_price" value="<?php echo $cust_trucking_price; ?>"/>
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
										<button type="submit" class="btn green w-140"><?php echo $button ?></button>
										<a href="<?php echo site_url('shipping_trucking/index_ggfs') ?>" class="btn red w-100"><i class="fa fa-close"></i> Cancel</a>
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
