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

                    <?php
					if ($this->session->flashdata('message')) {
						echo $this->session->flashdata('message');
					}
					?>

                    <div class="portlet-body form">
                        <form action="<?php echo $action; ?>" method="post" class="form-horizontal" role="form">

                            <div class="form-body">

                                <div class="form-group">
									<div class="col-md-12">
                                        <div class="panel panel-default">
                                            <div class="panel-body">
                                                <div class="form-group required">
                                                    <label class="col-md-1 control-label" for="varchar">Driver's wages</label>
                                                    <div class="col-md-8">
                                                        <input required type="text" class="form-control" name="driver_wages" id="driver_wages" value="<?php echo $driver_wages; ?>" />
                                                    </div>
                                                    <span class="help-inline"><?php echo form_error('driver_wages') ?></span>
                                                </div>
                                              
                                            </div>
                                        </div>
                                    </div>
								</div>

                                <div class="form-group">
									<div class="col-md-4">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">Local</h4>
                                            </div>

                                            <div class="panel-body">
                                                <div class="form-group required">
                                                    <label class="col-md-4 control-label" for="varchar">Per Trip </label>
                                                    <div class="col-md-8">
                                                        <input required type="text" class="form-control autonum text-right" name="local_pertrip" id="local_pertrip" value="<?php echo $local_pertrip; ?>"/>
                                                    </div>
                                                    <span class="help-inline"><?php echo form_error('local_pertrip') ?></span>
                                                </div>

                                            </div>

                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">FOREIGN</h4>
                                            </div>
                                            <div class="panel-body">
                                                <div class="form-group required">
                                                    <label class="col-md-4 control-label" for="varchar">Per Trip</label>
                                                    <div class="col-md-8">
                                                        <input required type="text" class="form-control autonum text-right" name="prc_pertrip" id="prc_pertrip" value="<?php echo $prc_pertrip; ?>"/>
                                                    </div>
                                                    <span class="help-inline"><?php echo form_error('prc_pertrip') ?></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                     <div class="col-md-4">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">Extra</h4>
                                            </div>
                                            <div class="panel-body">
                                                <div class="form-group required">
                                                    <div class="col-md-8">
                                                        <input required type="text" class="form-control autonum text-right" name="extra_trip" id="extra_trip" value="<?php echo $extra_trip; ?>"/>
                                                    </div>
                                                    <span class="help-inline"><?php echo form_error('extra_trip') ?></span>
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
										<a href="<?php echo site_url('Master_Tims/price') ?>" class="btn red w-100"><i class="fa fa-close"></i> Cancel</a>
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
