
<div class="page-content">
	<div class="container-fluid">
		
		<div class="row ">
			<div class="col-md-12">
				<?php echo $message;?>
				
				<div class="portlet light">
					<div class="portlet-title">
						<div class="caption">
							<i class="fa fa-cogs theme-font"></i>
							<span class="caption-subject theme-font bold uppercase">Sub Menu Detail</span>
						</div>
						<div class="tools">
							<a href="javascript:;" class="collapse"></a>
						</div>
					</div>
					
					<div class="portlet-body form">
						<form action="<?php echo site_url('utility/menu_save/detailsub');?>" method="post" class="form-horizontal" role="form">
							<div class="form-body">

								<div class="form-group required">
									<label class="col-md-3 control-label">Header Menu</label>
									<div class="col-md-3">
										<select class="form-control select2me" name="txt_menudtlid" data-placeholder="Select Header Menu...">
											<option value=""></option>
											<?php 
											foreach ($combo_menu_detail as $cmh) {
												echo '<option value="'.$cmh->menudtl_id.'">'.$cmh->menudtl_id.' - '.$cmh->menudtl_title.' ('.strtoupper($cmh->menuhdr_title).')</option>';
											}
											?>
										</select>
									</div>
									<span class="help-inline"><?php echo form_error('txt_menuhdrid') ?></span>
								</div>
								
								<div class="form-group required">
									<label class="col-md-3 control-label">Menu ID</label>
									<div class="col-md-2">
										<input name="txt_menuid" type="text" class="form-control" placeholder="4 digit number">
									</div>
									<span class="help-inline"><?php echo form_error('txt_menuid') ?></span>
								</div>

								<div class="form-group required">
									<label class="col-md-3 control-label">Menu Title</label>
									<div class="col-md-3">
										<input name="txt_menutitle" type="text" class="form-control" placeholder="Menu Title">
									</div>
									<span class="help-inline"><?php echo form_error('txt_menutitle') ?></span>
								</div>

								<div class="form-group required">
									<label class="col-md-3 control-label">Menu Link</label>
									<div class="col-md-3">
										<input name="txt_menulink" type="text" class="form-control" placeholder="Menu Link">
									</div>
									<span class="help-inline"><?php echo form_error('txt_menulink') ?></span>
								</div>

								<div class="form-group">
									<label class="col-md-3 control-label">Menu Icon</label>
									<div class="col-md-3">
										<select class="form-control select2me" name="txt_menuicon" data-placeholder="Select Menu Icon..." style="font-family: 'FontAwesome', Open Sans;">
											<option value=""></option>
											<?php
												foreach ($falist as $key => $value) {
													echo "<option class='fontawesome-font' value='".$key."' > &#x".stripslashes($value).";    ".$key."</option>";
												}
											?>										
										</select>
									</div>
									<span class="help-inline">Default Icon : <strong><i class="fa fa-angle-right bolder"></i> fa-angle-right </strong></span>
								</div>											

							</div>		

							<div class="form-actions">
								<div class="row">
									<div class="col-md-offset-3 col-md-9">
										<button type="submit" class="btn blue">Save</button>
										<a href="<?php echo site_url('utility/menu/detailsub');?>" class="btn default">Cancel</a>
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
								<span class="caption-subject theme-font bold uppercase">Sub Menu Detail List</span>
							</div>
							<div class="tools">
								<a href="javascript:;" class="collapse"></a>
								<a href="javascript:;" class="reload"></a>
							</div>
						</div>
						
						<div class="portlet-body flip-scroll">
							<table id = "tablemenu" class="table table-responsive">
								<thead>
									<tr>
										<th colspan="3">Menu</th>
										<th style="width: 70%">Action</th>
									</tr>
								</thead>
								<tbody>
									<?php
									$i = 0;
									$x = 0;
									foreach ($menu as $m)
									{
										echo '<tr>';
										switch ($m->menu_level) {
											case 1:
												echo '<td colspan="3" class="bolder font-blue-steel">'.$m->menu_id.'. '.$m->menu_title.'</td>';
												echo '<td class="center">';
												echo '<i class="icon-pin font-blue-steel"></i>';													
												echo '</td>';
												break;

											case 2:
												$iconable = ($m->menu_icon)? '<i class="fa '.$m->menu_icon.'"></i> ' : '';
												echo '<td class="w-50 text-center font-blue"><i class="fa fa-angle-double-right"></i></td>';
												echo '<td colspan="2">'.$m->menu_id.'. '.$m->menu_title.'</td>';		
												echo '<td class="center">'.$iconable;
												echo '</td>';
												break;

											case 3:
												echo '<td colspan="2" class="w-100 text-right"><i class="fa fa-angle-right"></i></td>';
												echo '<td><a href="'.site_url('utility/menu/detailsub/edit/'.$m->menu_id).'" title="click to edit">';
												echo $m->menu_id.'. '.$m->menu_title;
												echo '</a></td>';
												echo '<td class="center">';
												echo '<a href="'.site_url('utility/menu/detailsub/edit/'.$m->menu_id).'">Edit</a>';
												echo ' | ';
												echo anchor(site_url('utility/menu_delete/detailsub/'.$m->menu_id),'Delete','onclick="javasciprt: return confirm(\'Are You Sure Menu '.$m->menu_title.' ?\')"');
												echo '</td>';
												break;

											default:
												break;
										}

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