<table id="tblmon_po" class="table table-condensed table-striped">
	<tbody>
		<?php
			if ($record_mon){
				foreach ($record_mon as $r) {
					$rstatus = $r->status_id;
					switch ($r->status_id) {
						case 3:
							$bg_class = 'danger';
							$badges	= $r->status_badges;
							break;
						case 8:
							$bg_class = 'success';
							$badges	= $r->status_badges;
							break;

						default:
							$bg_class = '';
							$badges	= '';
							break;
					}

					echo "<tr class='$bg_class $rstatus'>";
					echo "<td style='text-align: center; width:40px;'>";
						echo "<input type='checkbox' name='chk_po[]' class='chk_po unichk' value='$r->po_hdr_id'>";
					echo "</td>";
					echo "<td class='text-center w-150'><div>".tgl_ind($r->ship_date)."</div></td>";
					echo "<td class='text center w-150'><div>$r->po_number</div></td>";
					echo "<td class='text center w-100'><div>$r->contract_no</div></td>";
					echo "<td class='text-center w-100'><div>$r->factory_abbr</div></td>";
					echo "<td class='text-left w-150'><div>".$r->firstname." ".$r->lastname."</div></td>";
					echo "<td class='text-left $rstatus'>";
						echo "<div>$r->customer_company_name<span class='pull-right'>$badges</span></div>";
					echo "</td>";
					echo "<tr>";
				}
			}
		?>
	</tbody>
</table>

<script>
	$('.unichk').uniform();
	// $('input:checkbox').uniform();

</script>
