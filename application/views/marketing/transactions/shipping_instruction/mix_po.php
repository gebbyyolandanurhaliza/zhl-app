<div class="modal-body">
	
	<div class="table-scrollable-borderless">
		
		<table id="tbl_filter_po" class="table table-bordered">
			<thead>
				<tr>
					<th style="width: 50px;">#</th>
					<th class="sembunyi">PO hdr ID</th>
					<th>PO Number</th>	
					<th>Factory</th>
				</tr>
			</thead>
			<tbody>
				<?php
				foreach ($rec_po as $rec) {
					echo "<tr>";
					echo "<td style='text-align: center;'><input type='checkbox' name='chk[]' ></td>";
					echo "<td class='sembunyi'>$rec->po_hdr_id</td>";
					echo "<td class='text-center'>$rec->po_number</td>";
					echo "<td class='text-center'>$rec->factory_abbr</td>";
					echo "</tr>";
				}
				?>
			</tbody>
		</table>

	</div>
</div>

<script>
	$('input:checkbox').uniform();
</script>

<script type="text/javascript">
	$(document).ready(function(){
		$("#tbl_filter_po").dataTable({
//			"sScrollX": "99%", //This is what made my columns increase in size.
//			"bScrollCollapse": true,
//			"bLengthChange": false,
			"bFilter": true,
			"bPaginate"	: true,
			"bInfo": false,
			"aoColumns": [
				{sWidth: '50px'),
					{sWidth: '50px'),
						{sWidth: '100px'),
							{sWidth: '100px'}
			]
		});
	});
</script>