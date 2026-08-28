<table class="table table-bordered" id="tabel">
	<tr>
		<th>#</th>
		<th>Container Type</th>
		<th>Container Number</th>
		<th>Seal Number</th>
		<th>Stuffing Type</th>
	</tr>
	<th>
		<?php 
			$i = 1;
			if(!empty($_detail)){
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
					$el = array('EL'=>'Export Laden', 'EE' => 'Export Empty', 'LE' => 'Local Empty', 'LL'=>'Local Laden', 'IT'=>'Import Transhipment', 'RE'=>'Recall Container', 'LO'=>'Loose Cargo');
					echo "<td><input type='hidden' name='jenis_stuffing[]' class='txt' value='$r->stuffing' readonly>".$el[$r->stuffing]."</td>";
					echo "</tr>";
					$i++;
				}
			}

			if(!empty($_detail2)){
				foreach ($_detail2 as $r) {
					echo "<tr>";
					echo "<td>$i</td>";
					echo "<td>
								<input type='text' name='container_name2[]' class='txt' value='$r->container_name' readonly>
								<input type='hidden' name='container_id2[]' class='txt' value='$r->container_id'>
								<input type='hidden' name='contid2[]' class='txt' value='$r->contid'>
						</td>";
					echo "<td><input type='text' name='container_number2[]' class='txt' value='$r->container' readonly></td>";
					echo "<td><input type='text' name='seal_number2[]' class='txt' value='$r->seal' readonly></td>";
					$el = array('EL'=>'Export Laden', 'EE' => 'Export Empty', 'LE' => 'Local Empty', 'LL'=>'Local Laden', 'IT'=>'Import Transhipment', 'LE' => 'Local Empty', 'EI' => 'Empty Import', 'RE'=>'Recall Container', 'LO'=>'Loose Cargo');
					echo "<td><input type='hidden' name='jenis_stuffing[]' class='txt' value='$r->stuffing' readonly>".$el[$r->stuffing]."</td>";
					echo "</tr>";
					$i++;
				}
			}
		?>
	</th>	
</table>