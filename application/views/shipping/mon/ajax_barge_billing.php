
		<?php $stuffing = '';
		foreach ($_stuffing as $rr) {
			echo "<tr><td colspan='13' style='text-align:left;font-weight:bold;background-color:#ddd;'>$rr->type</td></tr>";
			foreach ($_list as $r) {
				if ($r->stuffing == $rr->stuffing_abbr) {
					// $totalfob = $r->qty * $r->fob_price;
					// $totalcomper = ($totalfob * $r->com_percent) / 100;
					// $totalcomunit = ($r->qty * $r->com_unit);
					echo "
						<tr>
							<td nowrap>$r->type</td>
							<td nowrap>$r->C20</td>
							<td nowrap>$r->C40</td>
							<td nowrap>$r->container_abbr</td>
						
						<tr>
					";
				}
			}
			$stuffing = $rr->stuffing_abbr;
		}

		?>
	