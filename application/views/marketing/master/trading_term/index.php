<div class="page-content">
	<div class="container-fluid">
		<div class="row ">
			<div class="col-md-12">
				
				
				<div class="portlet light">
					<div class="portlet-title">
                    	<div class="caption">
                        	<i class="fa fa-table theme-font"></i>
                            <span class="caption-subject theme-font uppercase">Trading Term</span>
                        </div>                        
                    </div>
					
					<div class="portlet-body form">
						<div class="form-body row">							
							<div class="col-md-5">
								
								<?php echo form_open($action, 'class="form-horizontal"');?>
								<div class="panel panel-default">
									<div class="panel-heading">
										<h4 class="panel-title"><i class='fa fa-edit'></i> Create New</h4>
									</div>

									<div class="panel-body">
										<div class="form-group required">
											<label class="col-md-2 control-label" for="varchar">Name</label>
											<div class="col-md-5">
												<input type="text" class="form-control" name="trading_term_name" id="trading_term_name" value="<?php echo $trading_term_name ?>" />
											</div>
											<span class="help-inline"><?php echo form_error('trading_term_name') ?></span>
										</div>
										
										<div class="form-group required">
											<label class="col-md-2 control-label" for="varchar">Remark</label>
											<div class="col-md-9">
												<input type="text" class="form-control" name="trading_term_remark" id="trading_term_remark" value="<?php echo $trading_term_remark ?>" />
												<span class="help-inline"><?php echo form_error('trading_term_remark') ?></span>
											</div>											
										</div>
									</div>

									<div class="panel-footer">
										<div class="row">
											<div class="col-md-12">
												<input type="hidden" name="trading_term_id" value="<?php echo $trading_term_id; ?>">
												<a href="<?php echo site_url('marketing/master/trading_term'); ?>" class="btn red pull-right"><i class="fa fa-close"></i> Cancel</a>
												<button type="submit" class="btn green pull-right"><i class="fa fa-save"></i> <?php echo $button ?></button> 
											</div>
										</div>
									</div>
								</div>	
								<?php echo form_close(); ?>
								<?php echo $message;?>
								
							</div>
														
							<div class="col-md-7">
								<div class="panel panel-default">
									<div class="panel-heading">
										<h4 class="panel-title"><i class='fa fa-list'></i> Trading Term List</h4>
									</div>

									<div class="panel-body">
										<div class="table-scrollable-borderless">
											<table id="tblmst_brand" class="table table-bordered table-striped table-condensed">
												<thead>
													<tr>
														<th scope="col" width="100px">#</th>
														<th scope="col" width="100px">Name</th>									
														<th scope="col">Remark</th>														
													</tr>
												</thead>
												<tbody>
													<?php
													
													foreach ($master_data as $master) {
														echo "<tr>";
														echo "<td class='text-center w-100'>";
														echo anchor(site_url('marketing/delete_master/trading_term/'.encode_str($master->trading_term_id)),'<i class="fa fa-trash-o"></i>','class="btn default btn-sm red-stripe" onclick="javasciprt: return confirm(\'Are You Sure Delete Data '.$master->trading_term_name.'?\')"'); 
														echo anchor(site_url('marketing/edit_master/trading_term/'.encode_str($master->trading_term_id)),'<i class="fa fa-edit"></i>', 'class="btn default btn-sm green-stripe"'); 
														echo "</td>";
														echo "<td class='w-100'>$master->trading_term_name</td>";
														echo "<td>$master->trading_term_remark</td>";
														echo "</tr>";
													}
													?>
												</tbody>
											</table>
										</div>
									</div>

<!--									<div class="panel-footer">

									</div>-->
								</div>
							</div>
						</div>
					</div>
					
				</div>
				
			</div>
		</div>
	</div>
</div>