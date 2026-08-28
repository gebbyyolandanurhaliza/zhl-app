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
                                                    <label class="col-md-2 control-label" for="varchar">Depot Id </label>
                                                    <div class="col-md-3">
                                                        <input type="text" class="form-control" name="depot_id" id="depot_id" value="<?php echo $depot_id; ?>" readonly/>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-md-2 control-label" for="varchar">Depot Name </label>
                                                    <div class="col-md-3">
                                                        <input type="text" class="form-control" name="depot_name" id="depot_name" value="<?php echo $depot_name; ?>"/>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-md-2 control-label" for="varchar">Depot Address </label>
                                                    <div class="col-md-3">
                                                        <textarea class="form-control" name="depot_address"><?php echo $depot_address; ?></textarea>
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
										<a href="<?php echo site_url('shipping_depot') ?>" class="btn red w-100"><i class="fa fa-close"></i> Cancel</a>
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
