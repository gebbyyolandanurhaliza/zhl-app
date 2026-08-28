<div class="page-content">
	
	<div class="container-fluid">
		<div class="row ">
			<div class="col-md-12">
				
				<div class="portlet light">
					
					<div class="portlet-title">
						<div class="caption">
							<i class="fa fa-table theme-font"></i>
							<span class="caption-subject theme-font bold uppercase"><?php echo $header_title ?></span>
						</div>
						<div class="tools">							
							<a href="javascript:;" class="collapse"></a>
							<a href="javascript:;" class="reload"></a>
						</div>
					</div>
					
					<div class="portlet-body form">
						<form action="<?php echo site_url('user_group/access_save');?>" method="post" class="form-horizontal" role="form">
							<?php echo form_hidden('user_group_id', $user_group_id)?>
							<div class="form-body row">
								<div class="col-md-6">
									
									<div class="doc-scroll" style="height: 350px;">
										<table id = "tablemenu" class="table table-responsive">
											<thead>
												<tr>
													<th style="text-align: left;" colspan="3">Menu</th>
													<th style="width: 30%; text-align: left;">Access</th>
												</tr>
											</thead>
											<tbody>
												<?php
												$i = 0;
												$x = 0;
												foreach ($menu as $m)
												{
													echo '<tr>';

													$checked = false;
													foreach ($user_access as $ua) {
														if ($ua->menu_id == $m->menu_id) {
															$checked = true;
														}
													}

													switch ($m->menu_level) {
														case 1:
															echo '<td colspan="3" class="bolder font-blue-steel">'.$m->menu_title.'</td>';
															echo '<td class="center">';
															echo '<i class="icon-pin font-blue-steel"></i>';													
															echo form_hidden('menu['.++$x.']', $m->menu_title);
															echo '</td>';
															break;

														case 2:
															echo '<td class="w-50 text-center font-blue"><i class="fa fa-angle-double-right"></i></td>';
															echo '<td colspan="2" class="font-blue">'.$m->menu_title.'</td>';		
															echo '<td class="center">';
															if ($m->child == 0) {
																echo form_checkbox('chk['.++$i.']', $m->menu_id, $checked);
															} else {
																echo '<i class="icon-pin font-blue"></i>';
															}
															echo form_hidden('menu['.++$x.']', $m->menu_title);
															echo '</td>';
															break;

														case 3:
															echo '<td colspan="2" class="w-200 text-right"><i class="fa fa-angle-right"></i></td>';
															echo '<td>'.$m->menu_title.'</td>';
															echo '<td class="center">';
		//													echo '<input name="chk['.++$i.']" type="checkbox" value="'.$m->menu_id.'">';
															echo form_checkbox('chk['.++$i.']', $m->menu_id, $checked);
															echo form_hidden('menu['.++$x.']', $m->menu_title);
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
								
								<div class="col-md-6">
									<div class="doc-scroll" style="height: 350px;">
										<table id = "tablemenu" class="table table-responsive">
											<thead>
												<tr>
													<th style="text-align: left;" colspan="3">Factory</th>
													<th style="width: 30%; text-align: left;">Access</th>
												</tr>
											</thead>
											<tbody>
												<?php
												$j = 0;
												$y = 0;
												foreach ($factory as $f)
												{
													echo '<tr>';

													$checked = false;
													foreach ($factory_access as $sa) {
														if ($sa->company_id == $f->company_id) {
															$checked = true;
														}
													}
													
													echo '<td colspan="3" class="bolder font-blue-steel">'.$f->company_name.'</td>';
													echo '<td class="center">';
//													echo '<i class="icon-pin font-blue-steel"></i>';	
													echo form_checkbox('chkf['.++$j.']', $f->company_id, $checked);
													echo form_hidden('factory_id['.++$y.']', $f->company_id);
													echo '</td>';

													echo '</tr>';
												}
												?>

											</tbody>
										</table>	
									</div>
								</div>
								
							</div>
							
							<div class="form-actions">
								<div class="row">
									<div class="col-md-offset-5 col-md-6">
										<button type="submit" class="btn blue">Save</button>
										<a href="<?php echo site_url('user_group');?>" class="btn default">Cancel</a>
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

