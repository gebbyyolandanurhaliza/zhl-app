<div class="v-scroll">
	<table id="tbl_find" class="table table-condensed table-hover table-fixed">
		<thead>
			<tr>
				<th class="w-70">#</th>
				<th style="text-align: left;">Customer</th>
				<th style="text-align: left;" class="w-200">Att.</th>
				<th style="text-align: center;" class="w-120">Period</th>				
			</tr>
		</thead>
		<tbody>
			<?php
			
			if ($find_record){
				$i = 0;
				foreach ($find_record as $r){
					$i++;
					$edit_url = site_url('shipping-advice/show-find/?id='.encode_str($r->sa_id, 'sa'));
					echo '<tr>';
					echo '<td class="text-center w-70">';
					echo '<a href="'.$edit_url.'" bariske = '.$i.' type="button" class="btn btn-xs blue btnedit">Select</a>';
					echo '</td>';
					echo '<td class="customer_name">'.$r->customer_name.'</td>';
					echo '<td class="att w-200">'.$r->att.'</td>';
					$tgl_periode = (tgl_ind($r->period)=='00/00/0000') ? '' : tgl_ind($r->period);
					echo '<td class="w-120 text-center">'.$tgl_periode.'</td>';
					echo '</tr>';
				}
			} else {
				echo '<tr><td colspan="4" style="text-align:center;">No Data Available</td></tr>';
			}
			?>
		</tbody>
	</table>	
</div>