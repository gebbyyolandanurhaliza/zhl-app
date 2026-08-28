

	<div class="page-content">
		<div class="container-fluid">
<!--			<ul class="page-breadcrumb breadcrumb">
				<li>
					<a href="#">Utility</a><i class="fa fa-circle"></i>
				</li>
				
				<li>
					<a href="#">Menu</a><i class="fa fa-circle"></i>
				</li>
				
				<li class="active">
					<a href="#">Header</a>
				</li>
			</ul>-->
			
			<div class="row ">
				<div class="col-md-12">
					
					<?php echo $message;?>
					
					<div class="portlet light">
						
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-cogs theme-font"></i>
								<span class="caption-subject theme-font bold uppercase">Menu Header</span>
							</div>
							<div class="tools">
								<a href="javascript:;" class="collapse"></a>								
							</div>
						</div>
						
						<div class="portlet-body form">
							<form action="<?php echo site_url('utility/menu_save/header');?>" method="post" class="form-horizontal" role="form">
								<div class="form-body">
									
									<div class="form-group required">
										<label class="col-md-3 control-label">Menu ID</label>
										<div class="col-md-2">
											<input name="txt_menuid" type="text" class="form-control" placeholder="4 digits number">
										</div>
										<span class="help-inline"><?php echo form_error('txt_menuid') ?></span>
									</div>
									
									<div class="form-group required">
										<label class="col-md-3 control-label">Menu Title</label>
										<div class="col-md-4">
											<input name="txt_menutitle" type="text" class="form-control" placeholder="menu title">											
										</div>
										<span class="help-inline"><?php echo form_error('txt_menutitle') ?></span>
									</div>
									
									<div class="form-group required">
										<label class="col-md-3 control-label">Application Group</label>
										<div class="col-md-4">
											<select class="form-control select2me" name="txt_appid" data-placeholder="application group...">
												<option value=""></option>
												<?php 
												foreach ($combo_app_list as $cal) {
													echo '<option value="'.$cal->app_id.'">'.$cal->app_id.' - '.$cal->app_name.'</option>';
												}
												?>
											</select>											
										</div>
										<span class="help-inline"><?php echo form_error('txt_appid') ?></span>
									</div>
									
								</div>		
								
								<div class="form-actions">
									<div class="row">
										<div class="col-md-offset-3 col-md-9">
											<button type="submit" class="btn blue">Save</button>
											<button type="reset" class="btn default">Cancel</button>
										</div>
									</div>
								</div>
								
							</form>
						</div>
						
					</div>
					
					<div class="portlet light">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-table theme-font"></i>
								<span class="caption-subject theme-font bold uppercase">Menu Header List</span>
							</div>
							<div class="tools">
								<a href="javascript:;" class="collapse"></a>
								<a href="javascript:;" class="reload"></a>
							</div>
						</div>
						
						<div class="portlet-body flip-scroll">
							<table class="table table-bordered table-striped table-condensed flip-content">
								<thead class="flip-content">
									<tr>
										<th class="text-center">Menu ID</th>
										<th class="text-center">Menu Title</th>
										<th class="text-center">Menu Group</th>
										<th colspan="2" class="text-center" style="width: 100px">Actions</th>
									</tr>
								</thead>
								<tbody>
									<?php
									foreach ($record as $r){
										echo '<tr>';
										echo '<td class="text-center">'.$r->menuhdr_id.'</td>';
										echo '<td class="text-left">'.$r->menuhdr_title.'</td>';
										echo '<td class="text-left">'.$r->app_name.'</td>';
										echo '<td style="width: 50px" class="text-center">';
										echo '<a href="'.site_url('utility/menu/header/edit/'.$r->menuhdr_id).'">Edit</a>';
										echo '</td>';
										echo '<td style="width: 50px" class="text-center">';
										echo anchor(site_url('utility/menu_delete/header/'.$r->menuhdr_id),'Delete','onclick="javasciprt: return confirm(\'Are You Sure Menu '.$r->menuhdr_title.' ?\')"');
										echo '</td>';
										echo '</tr>';
									}
									?>
								</tbody>
							</table>
						</div>
						
					</div>
					
				</div>
			</div>
			
		</div>
	</div>
