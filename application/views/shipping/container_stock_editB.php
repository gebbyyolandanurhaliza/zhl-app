<div class="page-content">
	
	<div class="container-fluid">
		<div class="row ">
			<div class="col-md-12">
				
				<div class="portlet light">
					
					<div class="portlet-title">
						<div class="caption">
							<i class="fa fa-cogs theme-font"></i>
							<span class="caption-subject theme-font bold uppercase"><?php //echo $header_title;?></span>
						</div>
						<div class="tools">
							<a href="javascript:;" class="collapse"></a>								
						</div>
					</div>
					
					<div class="portlet-body form">
						<form action="<?php echo site_url('shipping/container_stock_save'); ?>" method="post" class="form-horizontal" role="form">
							<?php foreach($tampildata as $set):?>
							<div class="form-body">
								<div class="form-group">
									<label class="col-md-3 control-label" for="varchar">Container Number</label>
									<div class="col-md-5">
										<input type="text" class="form-control" name="container_number" id="container_number" placeholder="Container Number" value="<?php echo $set->container_number?>" />
										<input type="hidden" class="form-control" name="stock_id" id="stock_id" placeholder="Container Number" value="<?php echo $set->stock_id?>" />
									</div>
									<span class="help-inline"></span>
								</div>
								<div class="form-group">
									<label class="col-md-3 control-label" for="varchar">Container Type</label>
									<div class="col-md-5">
										<select class="form-control select2me" name="container_id" id="container_id">
											<?php foreach($gettype as $get){
												if($get->container_id==$set->container_id){?>
											      <option value="<?php echo $get->container_id;?>" selected>
											      	<?php echo $get->container_name;?></option>
											<?php }else{?>
												 <option value="<?php echo $get->container_id;?>"><?php echo $get->container_name;?></option>
											<?php } };?>
										</select>
									</div>
									<span class="help-inline"><span class="help-inline"></span>
								</div>
								<div class="form-group">
									<label class="col-md-3 control-label" for="int">Loading Port</label>
									<div class="col-md-5">
										<input type="text" class="form-control" name="loading_port" id="loading_port" placeholder="Free Time" value="<?php echo $set->loading_port?>" />
									</div>
									<span class="help-inline"></span>
								</div>								
								<div class="form-group">
									<label class="col-md-3 control-label" for="int">Arrival Date</label>
									<div class="col-md-5">
                                <input type="text" name="arrival_date" class="form-control date date-picker" value="<?php echo $set->arrival_date?>" data-date="2016/01/01" data-date-format="yyyy/mm/dd" required/>
									</div>
									<span class="help-inline"></span>
								</div>								
								<div class="form-group">
									<label class="col-md-3 control-label" for="int">Free Time</label>
									<div class="col-md-5">
                                <input type="text" name="free_time" class="form-control date date-picker" value="<?php echo $set->free_time?>" data-date="2016/01/01" data-date-format="yyyy/mm/dd" required/>
									</div>
									<span class="help-inline"></span>
								</div>								
								<div class="form-group">
									<label class="col-md-3 control-label" for="int">Remark</label>
									<div class="col-md-5">
										<input type="text" class="form-control" name="Remark" id="Remark" placeholder="Remark" value="<?php echo $set->Remark?>" />
									</div>
									<span class="help-inline"></span>
								</div>								


								</div>
							<?php endforeach;?>
							<div class="form-actions">
								<div class="row">
									<div class="col-md-offset-3 col-md-9">
										<button type="submit" class="btn btn-primary">Save</button> 
										<button type="reset" class="btn btn-primary">Cancel</button>
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