
<?php echo show_title($header_title, 'Marketing Transaction') ?>

<div class="page-content">
	<div class="container-fluid">
		<div class="row ">
			<div class="col-md-12">
				
				<?php echo $message ?>
				
				<div class="portlet light">
					
					<div class="portlet-title">
						<div class="caption">
							<i class="fa fa-table theme-font"></i>
							<span class="caption-subject theme-font uppercase"><?php echo $header_title ?></span>
						</div>
						<div class="tools">
							<a href="javascript:;" class="collapse">
							</a>
							<a href="javascript:;" class="reload">
							</a>
							<a href="javascript:;" class="fullscreen"></a>
						</div>
					</div>
					
					<div class="portlet-body form">
						<?php 
						echo form_open($action, 'class="form-horizontal"');
						?>
							<div class="form-body row">
															
								<div class="col-md-12">
									
									<div class="panel panel-default">
										<div class="panel-heading">
											<h4 class="panel-title"><i class='fa fa-filter'></i> Filter By :</h4>
										</div>
										<div class="panel-body">
											<div class="form-group">
												<label class="col-md-2 control-label" for="varchar">Customer</label>
												<div class="col-md-5">
													<input type="text" class="form-control" name="customer" id="customer" value="<?php echo $customer ?>" placeholder="customer name / code / company" title="Leave blank to show all the data" />
												</div>											
											</div>

											<div class="form-group">
												<label class="col-md-2 control-label" for="varchar">Sales Person</label>
												<div class="col-md-5">
													<?php 
														$extra_sales = 'id= "sales_id" class="form-control select2me" data-placeholder=" " title="Leave blank to show all the data" ';
														$option_sales[''] = '';
														foreach($cbo_sales as $r):
															$option_sales[$r->userid] = $r->firstname.' '.$r->lastname;
														endforeach;
														echo form_dropdown('sales_id', $option_sales, $sales_id, $extra_sales);
													?>
												</div>										
											</div>

											<div class="form-group">
												<label class="col-md-2 control-label" for="varchar">Status</label>
												<div class="col-md-5">

													<?php
														$extra_status = 'id="status_id" class="form-control select2me" data-placeholder=" "';
//														$option_status[''] = '';
														foreach($cbo_status as $r):
															$option_status[$r->status_id] = $r->status_name;
														endforeach;
														echo form_dropdown('status_id', $option_status, $status_id, $extra_status);
													?>										
												</div>									
											</div>

											<div class="form-group">
												<label class="col-md-2 control-label" for="varchar">Document Date</label>
												<div class="col-md-5">
													<div class="input-group date-picker input-daterange" data-date="<?php echo $current_date ?>" data-date-format="dd/mm/yyyy">
														<input type="text" class="form-control" name="posting_date1" value="<?php echo $posting_date1 ?>" title="date format : dd/mm/yyyy">
														<span class="input-group-addon" style="background: transparent; border-color: transparent">to</span>
														<input type="text" class="form-control" name="posting_date2" value="<?php echo $posting_date2; ?>" title="date format : dd/mm/yyyy">
													</div>
												</div>
											</div>
										</div>
										<div class="panel-footer">											
											<button type="submit" class="btn blue"><i class="fa fa-refresh"></i> Refresh</button>
										</div>
									</div>
								</div>
							</div>

						<?php
						echo form_close();
						?>
						
						<?php 
						echo form_open('marketing-transaction/sales-confirmation/update', 'class="form-horizontal"');
						?>
						
						<div class="form-body row">
							<div class="col-md-12">
								<!--<h4 class="form-section"><i class="fa fa-pencil"></i> SALES QUOTATION LIST :</h4>-->

								<div class="table-scrollable-borderless">
									<div id="quotation_container">
										<table id = "tbl_confirm" class="table table-condensed table-bordered table-hover table-confirm">
											<thead>
												<tr >
													<th>#</th>
													<th>Customer</th>
													<th>Company</th>
													<th>Quotation No</th>
													<th>Sales Person</th>
													<th>Posting Date</th>
													<th>Status</th>
												</tr>
											</thead>
											<tbody>
												<?php 
												$i = 0;
												if ($search_result){									
													foreach($search_result as $r){
														$i++;
														echo "<tr>";
														echo "<td class='text-center'>";
														echo "<input type='checkbox' name='hdr_id[]' value='".encode_str($r->quotation_hdr_id)."'>";
														echo "</td>";
														echo "<td>$r->customer_name</td>";
														echo "<td>$r->customer_company_name</td>";
														echo "<td>$r->quotation_number</td>";
														echo "<td>$r->sales_firstname $r->sales_lastname</td>";
														echo "<td class='text-center w-100'>".tgl_ind($r->document_date)."</td>";
														echo "<td class='text-center w-70'>$r->status_badges</td>";
														echo "</tr>";
													}
												}
												?>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
						
						<div class="form-actions">
							<?php
							switch ($status_id) {
								case 0:
									echo '<input name="btn_update" type="submit" class="btn btn-success confirmed" value="Confirmed">';
									echo '<input name="btn_update" type="submit" class="btn btn-danger closed" value="Closed">';
									break;
								
								case 1:
									echo '<input  name="btn_update" type="submit" class="btn btn-danger closed" value="Closed">';
									break;
								
								case 2:
									echo '<input  name="btn_update" type="submit" class="btn btn-danger closed" value="Closed">';
									break;
								
								default:
									echo '<input  name="btn_update" type="submit" class="btn green reopen" value="Re-Open">';
									break;
							}
							
//							if ($status_id == 0){
//								echo '<input name="btn_update" type="submit" class="btn btn-success confirmed" value="Confirmed">';
//								echo '<input name="btn_update" type="submit" class="btn btn-danger closed" value="Closed">';
//							}
//							if ($status_id == 1 || $status_id == 2){
//								echo '<input  name="btn_update" type="submit" class="btn btn-danger closed" value="Closed">';
//							}
							?>
						</div>
						
						<?php
						echo form_close();
						?>
					</div>
				</div>
								
			</div>
		</div>
	</div>
</div>
