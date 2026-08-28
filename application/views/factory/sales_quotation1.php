
<?php // echo show_title($header_title, 'Factory Monitor') ?>

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

											<div class="form-group hidden">
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
													<!--<th>#</th>-->
                                                    <th>Quotation No</th>
													<th>Factory</th>
													<th>Customer</th>
													<th>Company</th>
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

                                                        $quot_link	= site_url('factory/sales-quotation-view/?id='.encode_str($r->quotation_hdr_id).'&fid=' . $r->det_factory_id);
                                                        $quot_pdf	= site_url('sales-quotation/generate-pdf/?id=' . encode_str($r->quotation_hdr_id)) . '&no=' . encode_str($r->quotation_number) . '&dt=' . encode_str(date('d-M-Y', strtotime($r->document_date))) ;

                                                        echo "<tr>";
//														echo "<td class='text-center'>";
//														echo "<input type='checkbox' name='hdr_id[]' value='".encode_str($r->quotation_hdr_id)."'>";
//														echo "</td>";
                                                        echo "<td><a href='".$quot_link."' target='_blank'>$r->quotation_number</a>";
                                                            // echo ($r->quotation_hdr_id > 0) ? "<a class='btn btn-xs pull-right' target='_blank' href='$quot_pdf' style='padding-right:0px;' title='View PDF'><i class='fa fa-file-pdf-o font-grey-gallery'></i></a>" : "";
                                                        echo "</td>";
														echo "<td>$r->factory_abbr</td>";
														echo "<td>$r->customer_name</td>";
														echo "<td>$r->customer_company_name</td>";
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
<!--
						<div class="form-actions">
                            <div class="row">
                                <div class="col-md-12">
                                    <button class="btn green" id="btn_print" type="submit"><i class="fa fa-file-excel-o"></i> Export to Excel...</button>
                                </div>
                            </div>
                        </div>
						-->
						<?php
						echo form_close();
						?>
					</div>
				</div>

			</div>
		</div>
	</div>
</div>
