
<div class="page-content">
	<div class="container-fluid">		
		<div class="row ">
			<div class="col-md-12">
				
				<?php 
				echo $message;
				echo form_open(site_url('marketing_report/transaction'), 'method="post" class="form-horizontal"');
				?>
				
				<div class="portlet light">
					
					<div class="portlet-title">
						<div class="caption">
							<i class="fa fa-table theme-font"></i>
							<span class="caption-subject theme-font uppercase">Transactions</span>
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
						<div class="form-body row">
							<div class="col-md-12">
								
								<div class="panel panel-default">
									<div class="panel-heading">
										<h5 class="panel-title"><i class='fa fa-filter'></i> Filter Transaction</h5>
									</div>
									
									<div class="panel-body">
										<div class="form-group">
											<label class="col-md-2 control-label" for="varchar">Search By</label>
											<div class="col-md-7">
												<input type="text" class="form-control" name="param" id="param" value="<?php echo $param;?>" placeholder="PO Number, Sales Contract Number, Sales Quotation Number, Factory, Customer" title="Leave blank to show all the data" />
											</div>											
										</div>
									</div>
									
									<div class="panel-footer">
										<!--<input type="button" id="btn_filter" class="btn blue fontawesome-font" value="&#xf0b0 Filter">-->
										<button type="submit" class="btn blue"><i class="fa fa-filter"></i> Filter</button>
									</div>
								</div>
								
							</div>
						</div>
						
						<div class="flip-scroll">
							
							<table class="table" style="margin-bottom: 1px;">
								<thead>
									<tr>
										<th style="width: 35px; text-align: center; vertical-align: middle;">#</th>
										<th style="width: 140px; text-align: center; vertical-align: middle;">Sales Contract No</th>
										<th style="width: 150px; text-align: center; vertical-align: middle;">Sales Quotation No</th>
										<th style="width: 185px; text-align: center; vertical-align: middle;">Purchase Order No</th>
										<th style="width: 5px; text-align: center; padding: 0px; vertical-align: middle;">&nbsp;</th>
										<th style="width: 100px; text-align: center; vertical-align: middle;">Shipping Instruction</th>
										<th style="width: 80px; text-align: center; vertical-align: middle;">Ship Date</th>
										<th style="width: 60px; text-align: center; vertical-align: middle;">Factory</th>
										<th style="text-align: left; vertical-align: middle;">Customer</th>
										<th style="width: 100px; text-align: center; vertical-align: middle;">&nbsp;</th>
									</tr>
								</thead>
							</table>
							
							<div class="doc-scroll" style="height: 350px;">
								<div id="filtered_table" class="table-scrollable-borderless">
									<table id="tblmon_po" class="table table-striped table-condensed table-hover">
										<tbody>
											
											<?php
												if ($record_mon){
													$no = 1;
													foreach ($record_mon as $r) {
														$con_link	= site_url('sales-contract/show-find/?id='.encode_str($r->contract_hdr_id, 'contract'));
														$quot_link	= $r->quotation_hdr_id > 0 ? site_url('sales-quotation/show-find/?id='.encode_str($r->quotation_hdr_id)) : '#';
														$po_link	= $r->po_hdr_id > 0 ? site_url('marketing-transaction/purchase-order/edit/?id='.encode_str($r->po_hdr_id)) : '#';
														$si_link	= $r->ship_id > 0 ? site_url('marketing-transaction/shipping-instruction/edit/?id='.encode_str($r->ship_id)) : '#';
														
														$con_pdf	= site_url('sales-contract/generate-pdf/?id='.encode_str($r->contract_hdr_id).'&no='.encode_str($r->contract_no).'&dt='.encode_str(date('d-M-Y', strtotime($r->contract_date))));
														$quot_pdf	= site_url('sales-quotation/generate-pdf/?id=' . encode_str($r->quotation_hdr_id)) . '&no=' . encode_str($r->quotation_number) . '&dt=' . encode_str(date('d-M-Y', strtotime($r->document_date))) ;
														$po_pdf		= site_url('marketing_transaction/purchase_order/print/?id='.encode_str($r->po_hdr_id)).'&dt='.encode_str(date('d/m/Y', strtotime($r->po_date)));
														$si_pdf		= site_url('marketing_transaction/shipping_instruction/print/?id='.encode_str($r->ship_id));
														
														$con_no		= $r->contract_no;
														$quot_no	= $r->quotation_number;
														$po_no		= $r->po_number;
														$ship_date	= (is_null($r->schedule_date)) ? tgl_ind($r->ship_date) : tgl_ind($r->schedule_date);
														$factory	= $r->factory_abbr;
														$customer	= $r->customer_name;
														
														switch ($r->po_status_id) {
															case 3:
																$bg_class = 'danger';
																$badges	= $r->po_status_badges;
																break;
															case 8:
																$bg_class = 'success';
																$badges	= $r->po_status_badges;
																break;

															default:
																$bg_class = '';
																$badges	= '';
																break;
														}
														
														echo "<tr class='$bg_class'>";
														
														echo "<td style='text-align: center; width:30px;'>$no</td>";
														//CONTRACT
														echo "<td style='text-align: center; width:140px;'>";
															echo "<div class='btn-group btn-group-xs btn-group-solid'>";
															echo "<a target='_blank' href='$con_link'><span class='font-blue-steel'><strong>$con_no</strong></span></a>";
															echo "<a class='btn btn-sm pull-right' target='_blank' href='$con_pdf' style='margin-right: 0px; padding-left:10px; padding-right: 0px;' title='View PDF'><i class='fa fa-file-pdf-o font-blue-steel'></i></a>";
															echo "</div>";
														echo "</td>";
														//QUOTATION
														echo "<td style='text-align: center; width:150px;'>";
															echo "<div class='btn-group btn-group-xs btn-group-solid'>";
															echo "<a target='_blank' href='$quot_link'><span class='font-grey-gallery margin-right-10'><strong>$quot_no</strong></span></a>";
//															echo ($r->quotation_hdr_id > 0) ? "<a class='btn btn-xs grey-gallery pull-right' target='_blank' href='$quot_pdf' title='View PDF'><i class='fa fa-file-pdf-o'></i></a>" : "";
															echo ($r->quotation_hdr_id > 0) ? "<a class='btn btn-xs pull-right' target='_blank' href='$quot_pdf' style='padding-right:0px;' title='View PDF'><i class='fa fa-file-pdf-o font-grey-gallery'></i></a>" : "";
															echo "</div>";
														echo "</td>";
														
														//PO
														echo "<td style='text-align: center; width:150px;'>";
															echo "<div class='btn-group btn-group-xs btn-group-solid'>";
															echo "<a target='_blank' href='$po_link'><span class='font-green-seagreen margin-right-10'><strong>$po_no</strong></span></a>";
															echo "</div>";
														echo "</td>";
														echo "<td style='text-align: center; width:40px;'>";
															echo "<div class='btn-group btn-group-xs btn-group-solid'>";
															echo ($r->po_hdr_id > 0) ? "<a class='btn btn-xs green-seagreen pull-right' target='_blank' href='$po_pdf' title='View PDF'><i class='fa fa-file-pdf-o'></i></a>" : '';
															echo "</div>";
														echo "</td>";
														
														//SI
														echo "<td style='text-align: center; width:100px;'>";
															echo "<div class='btn-group btn-group-xs btn-group-solid'>";
															echo ($r->ship_id > 0) ? "<a class='btn btn-xs purple-studio' target='_blank' href='$si_link' title='Open SI'><i class='fa fa-share'></i></a>" : "";	
															echo ($r->ship_id > 0) ? "<a class='btn btn-xs purple-studio pull-right' target='_blank' href='$si_pdf' title='View PDF'><i class='fa fa-file-pdf-o'></i> </a>" : "";
															echo "</div>";
														echo "</td>";
														
														echo "<td style='text-align: center; width:80px;'>";
														echo $ship_date;
														echo "</td>";
														echo "<td style='text-align: center; width:60px;'>$factory</td>";
														echo "<td style='text-align: left; '>$customer</td>";
														echo "<td style='text-align: right; width:80px;'>$badges</td>";
														
														echo "<tr>";
														$no++;
													}
												}
											?>
											
										</tbody>
									</table>
								</div>
							</div>
							
						</div>
						
					</div>
					
				</div>
				
				<?php echo form_close() ?>
			</div>
		</div>
	</div>
</div>