
<?php // echo show_title($header_title, 'Factory Monitor') ?>

<div class="page-content">
	<div class="container-fluid">
		<div class="row ">
			<div class="col-md-12">
				
				<?php 
				// echo $message ?>
				
				<div class="portlet light">
					
					<div class="portlet-title">
						<div class="caption">
							<i class="fa fa-table theme-font"></i>
							<span class="caption-subject theme-font uppercase">Sales Product Record</span>
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
						<!-- <?php 
						//echo form_open('#', 'class="form-horizontal"');
						?> -->
						<form method="get" action="">
							<div class="form-body row">
															
								<div class="col-md-12">
									
									<div class="panel panel-default">
										<div class="panel-heading">
											<h4 class="panel-title"><i class='fa fa-filter'></i> Filter By :</h4>
										</div>
										<div class="panel-body">
											<!-- <div class="form-group">
												<label class="col-md-2 control-label" for="varchar">Customer</label>
												<div class="col-md-5">
													<input type="text" class="form-control" name="customer" id="customer" value="<?php echo $customer ?>" placeholder="customer name / code / company" title="Leave blank to show all the data" />
												</div>											
											</div> -->

											<div class="form-group">
												<label class="col-md-2 control-label" for="varchar">Product</label>
												<div class="col-md-10">
													<?php 
													// echo $prod;
														$extra_sales = 'id= "idp" class="form-control select2me" data-placeholder=" " title="Leave blank to show all the data" ';
														$option_sales[''] = '';
														foreach($cbo_product as $r):
															$option_sales[$r->product_id] = $r->product_code.' '.$r->product_name;
														endforeach;
														echo form_dropdown('idp', $option_sales, $prod, $extra_sales);
													?>
												</div>										
											</div>

											<div class="form-group hidden">
												<label class="col-md-2 control-label" for="varchar">Status</label>
												<div class="col-md-10">

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
											<?php 
												$id = $this->input->get('idp');
												$tgl1 = $this->input->get('posting_date1');
												$tgl2 = $this->input->get('posting_date2');
												$re = "../Excel/toExcelProduct_9?idp=".$id."&posting_date1=".$tgl1."&posting_date2=".$tgl2;

												if($this->input->get('idp') != '')
													{
											?>
											<a href="<?= $re; ?>" class="btn green" id="btn_print"><i class="fa fa-file-excel-o"></i> Export to Excel...</a>
											<?php } ?>
										</div>
									</div>
								</div>
							</div>
						</form>
						<?php
						// echo form_close();
						?>
						<?php 
							if($this->input->get('idp') != '')
							{
								// echo "habis";
						?>
							<div class="form-body row">
							<div class="col-md-12">
								<!--<h4 class="form-section"><i class="fa fa-pencil"></i> SALES QUOTATION LIST :</h4>-->

								<div class="table-scrollable-borderless">
									<div id="quotation_container">
										<table id = "tbl_confirm" class="table table-condensed table-bordered table-hover table-confirm">
											<thead>
												<tr >
													<!--<th>#</th>-->
                                                    <th>Product Name</th>
													<th>Brand</th>
													<th>Pack Size</th>
													<th>Quantity</th>
													<th>UOM</th>
													<th>Price</th>
													<th>Total</th>
												</tr>
											</thead>
											<tbody>
												<?php
													foreach ($tampilprod as $r) {
														$total = $r->price * $r->quantity;
														echo "<tr>"	;
														echo "<td>$r->product_name</td>";
														echo "<td>$r->brand_name</td>";
														echo "<td>$r->packing_view</td>";
														echo "<td style='text-align:right'>".number_format($r->quantity,2,',','.')."</td>";
														echo "<td>$r->uom_quantity_name</td>";
														echo "<td style='text-align:right'>$r->currency_id ".number_format($r->price,2,',','.')."</td>";
														echo "<td style='text-align:right'>$r->currency_id ".number_format($total,2,',','.')."</td>";
														echo "</tr>";
													}
												?>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>

						<?php
							}
						?>
						
					</div>
				</div>
								
			</div>
		</div>
	</div>
</div>
