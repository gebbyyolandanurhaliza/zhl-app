
<style type="text/css">
.rTable {
  	display: table;
  	width: 100%;
	
}
.rTableRow {
  	display: table-row;
}
.rTableHead {
  	display: table-cell;
  	padding: 3px 10px;
  	border: 1px solid #ddd;
	background-color: #ddd;
}
.rTableCell {
  	display: table-cell;
  	padding: 3px 10px;
  	border: 1px solid #ddd;
}
.rTableHeading {
  	display: table-header-group;
  	background-color: #ddd;
  	font-weight: bold;
}
.rTableFoot {
  	display: table-footer-group;
  	font-weight: bold;
  	background-color: #ddd;
}
.rTableBody {
  	display: table-row-group;
}
</style>



<table id="tblmon_po" class="table table-condensed table-striped" style="border-collapse: collapse">
	<tbody>
		<?php
			if ($summary_job){
				foreach ($summary_job as $r) {
					$amountDetails = json_decode($r->amount_details, true);
					  if (is_array($amountDetails)) {
						foreach ($amountDetails as $detail) {
								$driverWages = $detail['driver_wages'];
						}
	}
			
					$rstatus = $r->status;
					switch ($r->status) {
						case 'Waiting':
							$bg_class = '';
							$badges	= '<span class="label label-sm label-warning">WAITING</span>';
							break;
						case 'Complete':
							$bg_class = 'success';
							$badges	= '<span class="label label-sm label-success">COMPLETE</span>';
							break;

						default:
							$bg_class = '';
							$badges	= '<span class="label label-sm label-danger">PROGRESS</span>';
							break;
					}
					
					 echo "<tr class='$bg_class $rstatus parent' data-level='0'>";
                   
					echo "<td class='text-center w-200'><div>".tgl_ind($r->curr_date)."</div></td>";
					echo "<td class='text center w-150'><div>$r->vehicle_no</div></td>";
					echo "<td class='text center w-150'><div>$r->driver_name</div></td>";
					echo "<td class='text center w-150'><div>$r->job</div></td>";
					echo "<td class='text center w-100'><div>$r->customer_name</div></td>";
					echo "<td class='text-center w-150'><div>$r->time</div></td>";
                    echo "<td class='text-center w-100'><div>$r->send_to</div></td>";
                    echo "<td class='text-center w-100'><div>$r->chasis</div></td>";
                    echo "<td class='text-center w-70'><div>$badges</div></td>";
					echo "</tr>";
				
					
				}
			}
		?>
	</tbody>
</table>

<script>
	$('input:checkbox').uniform();
</script>