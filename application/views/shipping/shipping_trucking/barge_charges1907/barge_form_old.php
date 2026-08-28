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
									<label class="col-md-2 control-label" for="varchar">Container Type </label>
									<div class="col-md-3">
										<?php
										$extra_container = 'id="container_type" class="form-control select2me" onchange="change_container()"';
										$option_container[''] = '';
										foreach($cbo_container_type as $r):
											$option_container[$r->container_id.'|'.$r->container_size.'|'.$r->container_name] = $r->container_name;
										endforeach;
										echo form_dropdown('container_type', $option_container, $container_id.'|'.$container_size.'|'.$r->container_name, $extra_container);
										?>
                                        <input type="hidden" id="container_id" name="container_id" value="<?php echo $container_id;?>">
									</div>
								</div>

                                <div class="form-group">
                                    <label class="col-md-2 control-label" for="varchar">Container Name</label>
                                    <div class="col-md-3">
                                        <input type="text" class="form-control" name="container_name" id="container_name" value="<?php echo $container_name; ?>" reaadonly/>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-2 control-label" for="varchar">Container Size</label>
                                    <div class="col-md-3">
                                        <input type="text" class="form-control text-right" name="container_size" id="container_size" value="<?php echo $container_size; ?>" reaadonly/>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-2 control-label" for="varchar">Export Empty </label>
                                    <div class="col-md-3">
                                        <input type="text" class="form-control autonum text-right" name="export_empty" id="export_empty" value="<?php echo $export_empty; ?>"/>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-2 control-label" for="varchar">Export Reefer </label>
                                    <div class="col-md-3">
                                        <input type="text" class="form-control autonum text-right" name="export_reefer" id="export_reefer" value="<?php echo $export_reefer; ?>"/>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-2 control-label" for="varchar">Export Laden </label>
                                    <div class="col-md-3">
                                        <input type="text" class="form-control autonum text-right" name="export_laden" id="export_laden" value="<?php echo $export_laden; ?>"/>
                                    </div>
                                </div>

								<div class="form-group">
                                    <label class="col-md-2 control-label" for="varchar">Import Transhipment </label>
                                    <div class="col-md-3">
                                        <input type="text" class="form-control autonum text-right" name="import_transhipment" id="import_transhipment" value="<?php echo $import_transhipment; ?>"/>
                                    </div>
                                </div>

								<div class="form-group">
									<label class="col-md-2 control-label" for="varchar">Misc</label>
                                    <div class="col-md-3">
                                        <input type="text" class="form-control" name="misc" id="misc" value="<?php echo $misc; ?>"/>
                                    </div>
								</div>

                            </div>

							<div class="form-actions">
								<div class="row">
									<div class="col-md-12">
										<input type="hidden" name="container_id" value="<?php echo $container_id; ?>" />
										<button type="submit" class="btn green"><?php echo $button ?></button>
										<a href="<?php echo site_url('master-freight/barge-charges') ?>" class="btn red"><i class="fa fa-close"></i> Cancel</a>
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
        $('#container_name').val(arr_container_type[2]);

    }
</script>
