<div class="table-scrollable">
	<table class="table table-bordered table-condensed table-detail" id="tbl_po_dtl">
		<thead>
			<tr>
				<th style="width:50px !important">No</th>
				<th width='100px'>P.O. No</th>
				<th width='50px'>20'</th>
				<th width='50px'>40'</th>
				<th width='50px'>CT</th>													
				<th width='150px'>Ctnr/Seal No</th>
				<th width='200px'>Destination</th>
				<th width='250px'>Description/Brand</th>
				<th width='100px'>REF:</th>
				<th width='350px'>Vessel Details</th>
			</tr>
		</thead>
		<tbody>
			<?php
			if ($list_rec){
				foreach ($list_rec as $s) {
					echo "<tr>";
					echo "<td>$s->ship_id</td>";
					echo "<td>$s->po_number</td>";
					echo "<td>$s->c20</td>";
					echo "<td>$s->c40</td>";
					echo "<td>$s->container_abbr</td>";
					echo "<td>$s->seal</td>";
					echo "<td>$s->port_name</td>";
					echo "<td>$s->product_name<span>$s->brand_name</span></td>";
					echo "<td>$s->buyer_si</td>";
					echo "<td>$s->vessel</td>";
					echo "</tr>";
				}
			} else {
				echo "<tr><td colspan='10'>No Data Available</td></tr>";
			}
			?>
		</tbody>
	</table>
</div>