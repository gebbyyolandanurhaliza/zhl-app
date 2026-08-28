<style type="text/css">		
	.sembunyi{
		display: none;
	}
</style>

<div  class="page-content">
	<div class="container-fluid">
		<div class="row ">			
			<div class="col-md-12">
				
				<?php 
				echo $message;
				echo form_open(site_url('generate_excel/marketing_po'), 'target="_blank" method="post" class="form-horizontal"');
				?>
				
				<div class="portlet light">
					<div class="portlet-title">
						<div class="caption">
							<i class="fa fa-table theme-font"></i>
							<span class="caption-subject theme-font uppercase">Purchase Order List</span>
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
										<h5 class="panel-title"><i class='fa fa-filter'></i> Filter PO</h5>
									</div>
									<div class="panel-body">
										<div class="form-group">
											<label class="col-md-2 control-label" for="varchar">Search PO By</label>
											<div class="col-md-7">
												<input type="text" class="form-control" name="param_po" id="param_po" value="" placeholder="PO Number, Sales Contract No, Factory, Customer" title="Leave blank to show all the data" />
											</div>											
										</div>

										<div class="form-group">
											<label class="col-md-2 control-label" for="varchar">PO Date</label>
											<div class="col-md-4">
												<div class="input-group date-picker input-daterange" data-date="<?php echo $current_date ?>" data-date-format="dd/mm/yyyy">
													<input type="text" class="form-control" id="ship_date1" name="ship_date1" value="<?php echo $ship_date1 ?>" title="date format : dd/mm/yyyy">
													<span class="input-group-addon" style="background: transparent; border-color: transparent">to</span>
													<input type="text" class="form-control" id="ship_date2" name="ship_date2" value="<?php echo $ship_date2; ?>" title="date format : dd/mm/yyyy">
												</div>
											</div>
										</div>
									</div>
									<div class="panel-footer">
										<input type="button" id="btn_filter" class="btn blue fontawesome-font" value="&#xf0b0 Filter Purchase Order">
									</div>
								</div>
								
							</div>
						</div>
						
						
						<div id="filtered_table" class="flip-scroll">
<!--							<label class="label label-info pull-right font-blue-dark">Total Record : <?php // echo $rec_count;?></label>
							<table id="tblpo" class="table" style="margin-bottom: 1px;">
								<thead>
									<tr>
										<th style="width: 43px; text-align: center;"><input type="checkbox" id="togglecheck"></th>
										<th style="width: 100px; text-align: center;">Shipping Date</th>										
										<th style="width: 150px; text-align: left;">PO Number</th>
										<th style="width: 100px; text-align: center;">PO Date</th>
										<th style="width: 60px; text-align: center;">Factory</th>
										<th style="text-align: left;">Customer</th>
									</tr>
								</thead>
							</table>
							<div class="doc-scroll" style="height: 350px;">
								<div  class="table-scrollable-borderless">
									<table id="tblmon_po" class="table table-condensed table-striped">										
										<tbody>
											<?php
//												if ($record_mon){
//													foreach ($record_mon as $r) {
//														echo "<tr>";
//														echo "<td style='text-align: center; width: 40px'>";
//															echo "<input type='checkbox' name='chk_po[]' class='chk_po' value='$r->po_hdr_id'>";
//														echo "</td>";
//														echo "<td class='text-center w-100'><div>".tgl_ind($r->ship_date)."</div></td>";
//														echo "<td class='text center w-150'><div>$r->po_number</div></td>";
//														echo "<td class='text-center w-100'><div>".tgl_ind($r->po_date)."</div></td>";
//														echo "<td class='text-center w-60'><div>$r->factory_abbr</div></td>";
//														echo "<td class='text-left'><div>$r->customer_company_name</div></td>";
//														echo "<tr>";
//													}
//												}
											?>
										</tbody>
									</table>
								</div>
							</div>-->
							
							<script>
//								$('input:checkbox').uniform();
//								
//								$('#togglecheck').on('click', function(){
//									if (this.checked == true){
//										$("input[type=checkbox]").prop('checked', true).uniform();
//									} else {
//										$("input[type=checkbox]").prop('checked', false).uniform();
//									}
//								});
							</script>
							
						</div>
						
					</div>
					
					<div class="form-actions">
						<div class="row">
							<div class="col-md-12">
								<button class="btn green" id="btn_print" type="submit"><i class="fa fa-file-excel-o"></i> Export to Excel...</button>
							</div>
						</div>
					</div>
					
				</div>
				
				<?php
				echo form_close();
				?>
			</div>
		</div>
	</div>
</div>

<script>
	$('#btn_filter').on('click', function(){
		var param		= $('#param_po').val();
		var shipdate1	= $('#ship_date1').val();
		var shipdate2	= $('#ship_date2').val();
		
		$('#filtered_table').html('<div id="filtered_table" class="flip-scroll well">'+loading_anim+'</div');
		
		$.ajax({
			type: "POST",
			url : "<?php echo site_url('factory/marketing_po_filter')?>",
			data: {
				param_search	: param,
				ship_date1		: shipdate1,
				ship_date2		: shipdate2,
			},
			success: function(msg){
				$('#filtered_table').html(msg);
			}
		})
	});
</script>