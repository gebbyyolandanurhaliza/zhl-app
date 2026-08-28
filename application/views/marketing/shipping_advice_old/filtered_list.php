<table id="sa_cust_list" class="table table-bordered table-condensed">
	<thead>
		<tr>
			<th>#</th>
			<th>Customer</th>
			<th>Total PO</th>
		</tr>
	</thead>
	<tbody>
		<?php
		if ($filtered){
			$i = 1;
			foreach ($filtered as $r) {
				echo "<tr>";
				echo "<td style='width: 150px;'>";
				echo "<input type='button' cust_id='".encode_str($r->customer_id, 'sa')."' value='Create Shipping Advice' class='btn btn-xs default green-stripe create_sa'>";
				echo "</td>";
				echo "<td>$r->customer_name</td>";
				echo "<td style='width: 50px;text-align: center;'>$r->total_po</td>";
				echo "</tr>";																
			}
		} else {
			echo "<tr><td colspan='3' style='text-align: center;'>No Data Available</td></tr>";
		}
		?>
	</tbody>
</table>