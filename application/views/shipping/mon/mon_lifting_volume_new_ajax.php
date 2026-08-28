<?php 
	$no = 1;
	foreach ($_total as $r) {
		if($r->t_position == 1){
			echo "<tr style='cursor: pointer;background:#e0e0e8;'>";
			echo "<td>$no</td>";
			$no++;
		}else{
			echo "<tr style='cursor: pointer;'>";
			echo "<td></td>";
		}
		echo "<td>$r->t_shiplineri</td>";
		echo "<td>$r->t_destinationi</td>";
		echo "<td>$r->tt_tahun</td>";
		echo "<td>$r->tt_1</td>";
		echo "<td>$r->tt_2</td>";
		echo "<td>$r->tt_3</td>";
		echo "<td>$r->tt_4</td>";
		echo "<td>$r->tt_5</td>";
		echo "<td>$r->tt_6</td>";
		echo "<td>$r->tt_7</td>";
		echo "<td>$r->tt_8</td>";
		echo "<td>$r->tt_9</td>";
		echo "<td>$r->tt_10</td>";
		echo "<td>$r->tt_11</td>";
		echo "<td>$r->tt_12</td>";
		echo "</tr>";
	}
?>