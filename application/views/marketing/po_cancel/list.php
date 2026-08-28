
<div class="page-content">
	<div class="container-fluid">
		<div class="row ">
			<div class="col-md-12">
			
				<div class="portlet light">
					<div class="portlet-title">
						<div class="caption">
							<i class="fa fa-table theme-font"></i>
							<span class="caption-subject theme-font uppercase">Cancel Purchase Order</span>
						</div>						
					</div>
					
					<div class="portlet-body form">
						
						<?php echo $message ?>
						<?php echo form_open($action) ?>
						
						<div class="table-scrollable-borderless">
							<table class="table table-bordered table-condensed table-detail scrollable" id="tbl_po">
								<thead>
									<tr>
										<td>&nbsp;</td>
										<td>CANCEL</td>
										<td>CANCEL REMARK</td>
										<td>PO Number</td>
										<td>PO Date</td>
										<td>Factory</td>
										<td>Buyer</td>
										<td>Country</td>
										<td>SM In Charge</td>
										<td>Created By</td>
										<td>Created Date</td>
									</tr>
								</thead>
								
								<tbody>
									<?php
									if ($record){
										$i = 1;
										foreach($record as $r){
											echo "<tr>";
											
											echo "<td class='text-center'>$i</td>";
											
											echo "<td class='text-center bg-editable'>";
											echo form_checkbox('chk[]', $r->po_hdr_id, false);
											echo "</td>";
											
											echo "<td class='bg-editable'>";
											echo "<input name='cancel_po_remark[$r->po_hdr_id]' class='form-control input-xs input-table' >";
//											echo form_input('cancel_po_remark[]', '', 'class="form-control input-table"');
											echo "</td>";
											
											echo "<td>";
											echo form_input('po_number[]', $r->po_number, 'class="form-control input-table" readonly');
											echo "</td>";
											
											echo "<td>";
											echo form_input('po_date[]', tgl_ind($r->po_date), 'class="form-control input-table" readonly');
											echo "</td>";
											
											echo "<td>";
											echo form_input('supplierid[]', $r->supplierid, 'class="form-control input-table" readonly');
											echo "</td>";
											
											echo "<td>";
											echo form_input('customer_name[]', $r->customer_name, 'class="form-control input-table" readonly');
											echo "</td>";
											
											echo "<td>";
											echo form_input('customer_country_name[]', $r->customer_country_name, 'class="form-control input-table" readonly');
											echo "</td>";
											
											echo "<td>";
											echo form_input('firstname[]', $r->firstname.' '.$r->lastname, 'class="form-control input-table" readonly');
											echo "</td>";
											
											echo "<td>";
											echo form_input('created_by[]', $r->created_by, 'class="form-control input-table" readonly');
											echo "</td>";
											
											echo "<td>";
											echo form_input('created_date[]', $r->created_date, 'class="form-control input-table" readonly');
											echo "</td>";
											
											echo "</tr>";
											
											$i++;
										}
									}
									?>
								</tbody>
							</table>
							
						</div>
						
						<div class="form-action">
							<div class="row">
								<div class="col-md-12">
									<button type="submit" class="btn green">Cancel Selected PO(s)</button> 									
								</div>
							</div>
						</div>
						
						<?php echo form_close(); ?>
						
					</div>
				</div><!--/portlet-light -->
				
			</div>
		</div>
	</div>
</div>

<script>
	$('input:checkbox').uniform();
	$('#tbl_po').dataTable();
</script>