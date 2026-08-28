<table class="table table-bordered" id="tabel">
	<tr>
		<th>#</th>
		<th>Container Type</th>
		<th>Container Number</th>
		<th>Seal Number</th>
	</tr>
	<th>
		<?php 
			if(!empty($_detail)){
				$i = 1;
				foreach ($_detail as $r) {
					echo "<tr>";
					echo "<td>$i</td>";
					echo "<td>
								<input type='text' name='container_name[]' class='txt' value='$r->container_name' readonly>
								<input type='hidden' name='container_id[]' class='txt' value='$r->container_id'>
								<input type='hidden' name='contid[]' class='txt' value='$r->contid'>
						</td>";
					echo "<td><input type='text' name='container_number[]' class='txt' value='$r->container' readonly></td>";
					echo "<td><input type='text' name='seal_number[]' class='txt' value='$r->seal' readonly></td>";
					echo "</tr>";
					$i++;
				}
			}
		?>
	</th>	
</table>