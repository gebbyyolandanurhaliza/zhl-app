<table id="tblmon_po" class="table table-condensed table-striped">
	<tbody>
		<?php
			if ($record_mon){
				foreach ($record_mon as $r) {
					
					switch ($r->status_id) {
						case 3:
							$bg_class = 'danger';
							// $badges	= $r->status_badges;
							break;
						case 8:
							$bg_class = 'success';
							// $badges	= $r->status_badges;
							break;

						default:
							$bg_class = '';
							$badges	= '';
							break;
					}
					
					echo "<tr class='$bg_class'>";
					echo "<td style='text-align: center; width:40px;'>";
						echo "<input type='checkbox' name='chk_si[]' class='chk_si' value='$r->ship_id'>";
					echo "</td>";
					echo "<td class='text-center w-200'><div>".tgl_ind($r->schedule_date)."</div></td>";
					echo "<td class='text center w-150'><div>$r->urut_container</div></td>";
					echo "<td class='text center w-150'><div>$r->reff</div></td>";
					echo "<td class='text center w-150'><div>$r->po_number</div></td>";
					echo "<td class='text center w-100'><div>$r->contract_no</div></td>";
					echo "<td class='text-center w-100'><div>$r->factory_abbr</div></td>";
					echo "<td class='text-left w-100'>";
						echo "<div>$r->customer_company_name<span class='pull-right'></span></div>";
					echo "</td>";
					echo "<td class='text-right w-100'><div>$r->prices_freight</div></td>";
					echo "<td class='text-center w-100'><div></div></td>";
					echo "<td class='text-center w-100'><div>$r->invno</div></td>";
					echo "<tr>";
				}
			}
		?>
	</tbody>
</table>

<script>
	$('input:checkbox').uniform();
</script>