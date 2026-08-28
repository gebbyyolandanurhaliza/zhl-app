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
								<input type='text' name='container_name_truck[]' class='txt' value='$r->container_name' readonly>
								<input type='hidden' name='container_id_truck[]' class='txt' value='$r->container_id'>
								<input type='hidden' name='contid_truck[]' class='txt' value='$r->contid'>
						</td>";
					echo "<td><input type='text' name='container_number_truck[]' class='txt' value='$r->container' readonly></td>";
					echo "<td><input type='text' name='seal_number_truck[]' class='txt' value='$r->seal' readonly></td>";
					$el = array('EL'=>'Export Laden', 'EE' => 'Export Empty', 'LE' => 'Local Empty', 'LL'=>'Local Laden', 'IT'=>'Import Transhipment', 'RE'=>'Recall Container', 'EE_TP' => 'Export Empty (TP)');
					echo "<td><input type='hidden' name='jenis_stuffing_truck[]' class='txt' value='$r->stuffing' readonly>".$el[$r->stuffing]."</td>";
					echo "</tr>";
					$i++;
				}
			}

			if(!empty($_detail2)){
				foreach ($_detail2 as $r) {
					echo "<tr>";
					echo "<td>$i</td>";
					echo "<td>
								<input type='text' name='container_name2_truck[]' class='txt' value='$r->container_name' readonly>
								<input type='hidden' name='container_id2_truck[]' class='txt' value='$r->container_id'>
								<input type='hidden' name='contid2_truck[]' class='txt' value='$r->contid'>
						</td>";
					echo "<td><input type='text' name='container_number2_truck[]' class='txt' value='$r->container' readonly></td>";
					echo "<td><input type='text' name='seal_number2_truck[]' class='txt' value='$r->seal' readonly></td>";
					$el = array('EL'=>'Export Laden', 'EE' => 'Export Empty', 'LE' => 'Local Empty', 'LL'=>'Local Laden', 'IT'=>'Import Transhipment', 'LE' => 'Local Empty', 'EI' => 'Empty Import', 'RE'=>'Recall Container', 'EE_TP' => 'Export Empty (TP)');
					echo "<td><input type='hidden' name='jenis_stuffing_truck[]' class='txt' value='$r->stuffing' readonly>".$el[$r->stuffing]."</td>";
					echo "</tr>";
					$i++;
				}
			}

			if(!empty($_detail3)){
				foreach ($_detail3 as $r) {
					echo "<tr>";
					echo "<td>$i</td>";
					echo "<td>
								<input type='text' name='container_name2_truck[]' class='txt' value='$r->container_name' readonly>
								<input type='hidden' name='container_id2_truck[]' class='txt' value='$r->container_id'>
								<input type='hidden' name='contid2_truck[]' class='txt' value='$r->contid'>
						</td>";
					echo "<td><input type='text' name='container_number2_truck[]' class='txt' value='$r->container' readonly></td>";
					echo "<td><input type='text' name='seal_number2_truck[]' class='txt' value='$r->seal' readonly></td>";
					$el = array('EL'=>'Export Laden', 'EE' => 'Export Empty', 'LE' => 'Local Empty', 'LL'=>'Local Laden', 'IT'=>'Import Transhipment', 'LE' => 'Local Empty', 'EI' => 'Empty Import', 'RE'=>'Recall Container', 'EE_TP' => 'Export Empty (TP)');
					echo "<td><input type='hidden' name='jenis_stuffing_truck[]' class='txt' value='$r->stuffing' readonly>".$el[$r->stuffing]."</td>";
					echo "</tr>";
					$i++;
				}
			}
		?>
	</th>	
</table>