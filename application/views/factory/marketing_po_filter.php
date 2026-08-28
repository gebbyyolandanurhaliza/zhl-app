<label class="label label-info pull-right font-blue-dark">Total Record : <?php echo $rec_count;?></label>
<table id="tblpo" class="table" style="margin-bottom: 1px;">
	<thead>
		<tr>
			<th style="width: 43px; text-align: center;"><input type="checkbox" id="togglecheck"></th>
			<th style="width: 100px; text-align: center;">Shipping Date</th>										
			<th style="width: 150px; text-align: left;">PO Number</th>
			<th style="width: 100px; text-align: center;">PO Date</th>
			<th style="width: 60px; text-align: center;">Factory</th>
			<th style="text-align: left;">Customer</th>
			<th style="width: 100px;">&nbsp;</th>
		</tr>
	</thead>
</table>
<div class="doc-scroll" style="height: 350px;">
	<div  class="table-scrollable-borderless">
		<table id="tblmon_po" class="table table-condensed table-striped">										
			<tbody>
				<?php
					if ($record_mon){
						foreach ($record_mon as $r) {
							
							switch ($r->export_by_factory) {
								case 1:
									$exported	= '<span class="label label-sm label-danger">EXPORTED</span>';
									$row_mark	= 'danger';
									break;
								
								case 2:
									$exported	= '<span class="label label-sm label-warning">REVISION</span>';
									$row_mark	= 'warning';
									break;

								default:
									$exported	= '';
									$row_mark	= '';
									break;
							}
							
							echo "<tr class='$row_mark'>";
							echo "<td style='text-align: center; width: 40px'>";
								echo "<input type='checkbox' name='chk_po[]' class='chk_po' value='$r->po_hdr_id'>";
							echo "</td>";
							echo "<td class='text-center w-100'><div>".tgl_ind($r->ship_date)."</div></td>";
							echo "<td class='text center w-150'><div>$r->po_number</div></td>";
							echo "<td class='text-center w-100'><div>".tgl_ind($r->po_date)."</div></td>";
							echo "<td class='text-center w-60'><div>$r->factory_abbr</div></td>";
							echo "<td class='text-left'><div>$r->customer_company_name</div></td>";
							
							
							
							echo "<td class='text-right w-100'>$exported</div>";
							echo "<tr>";
						}
					}
				?>
			</tbody>
		</table>
	</div>
</div>

<script>
	$('input:checkbox').uniform();
	
	$('#togglecheck').on('click', function(){
		if (this.checked == true){
			$("input[type=checkbox]").prop('checked', true).uniform();
		} else {
			$("input[type=checkbox]").prop('checked', false).uniform();
		}
	});
</script>