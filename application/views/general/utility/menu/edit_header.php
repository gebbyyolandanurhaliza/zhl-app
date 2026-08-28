
<div class="page-content">
	
	<div class="container-fluid">
		
		<div class="row ">
			<div class="col-md-12">

				<div class="portlet light">

					<div class="portlet-title">
						<div class="caption">
							<i class="fa fa-cogs theme-font"></i>
							<span class="caption-subject theme-font bold uppercase">Menu Header Edit</span>
						</div>
						<div class="tools">
							<a href="javascript:;" class="collapse"></a>								
						</div>
					</div>

					<div class="portlet-body form">
						<form action="<?php echo site_url('utility/menu_update/header');?>" method="post" class="form-horizontal" role="form">
							<div class="form-body">

								<?php echo form_hidden('txt_menuid', $menuhdr_id);?>
								
								<div class="form-group required">
									<label class="col-md-3 control-label">Menu ID</label>
									<div class="col-md-2">
										<input value="<?php echo set_value('txt_menuid_disabled', $menuhdr_id);?>" name="txt_menuid" type="text" class="form-control" placeholder="4 digits number" disabled="disabled">											
									</div>
								</div>

								<div class="form-group required">
									<label class="col-md-3 control-label">Menu Title</label>
									<div class="col-md-4">
										<input value="<?php echo set_value('txt_menutitle', $menuhdr_title);?>" name="txt_menutitle" type="text" class="form-control" placeholder="menu title">											
									</div>
									<span class="help-inline"><?php echo form_error('txt_menutitle') ?></span>
								</div>

								<div class="form-group required">
									<label class="col-md-3 control-label">Application Group</label>
									<div class="col-md-4">
										<?php
										$extra_grup = 'class="form-control select2me" data-placeholder="Application Group"';
										$option_grup[''] = '';
										foreach ($combo_app_list as $cal) :
											$option_grup[$cal->app_id] = $cal->app_name;
										endforeach;
										echo form_dropdown('txt_appid', $option_grup, $app_id, $extra_grup);
										?>
									</div>
									<span class="help-inline"><?php echo form_error('txt_appid') ?></span>
								</div>

							</div>		

							<div class="form-actions">
								<div class="row">
									<div class="col-md-offset-3 col-md-9">
										<button type="submit" class="btn blue">Update</button>
										<a href="<?php echo site_url('utility/menu/header');?>" class="btn default">Cancel</a>
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
									echo '<a href="#">Edit</a>';
									echo '</td>';
									echo '<td style="width: 50px" class="text-center">';
									echo '<a href="#" class="hapus" id="btnHapus" menuid="'.$r->menuhdr_id.'" menucap="'.$r->menuhdr_title.'">Delete</a>';
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