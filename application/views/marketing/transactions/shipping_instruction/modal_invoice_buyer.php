<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
	<h4>
		<i class="fa fa-search"></i>
		<strong>Invoice To Buyer Option</strong>
	</h4>
</div>

<div class="modal-body">
	<div class="table-scrollable-borderless">
		
		<table id="tbl_buyer" class="table table-bordered">
			<thead>
				<tr>
					<th>Buyer</th>
					<th>Code</th>
					<th>Country</th>
				</tr>
			</thead>
			<tbody>
				<?php
				foreach ($rec_buyer as $rec) {
					echo "<tr onclick='select_buyer(this)' style='cursor: pointer;' title='Click to Select'>";
					echo "<td>$rec->customer_company_name</td>";
					echo "<td>$rec->customer_code</td>";
					echo "<td>$rec->customer_country</td>";
					echo "</tr>";
				}
				?>
			</tbody>
		</table>
	</div>
	
</div>

<div class="modal-footer">
	<div class="form-actions">
		<div class="row">
			<div class="col-md-12">
				<button type="reset" data-dismiss="modal" class="btn red">Close</button>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	$('#tbl_buyer').dataTable({
		"bLengthChange": false,
	});
</script>