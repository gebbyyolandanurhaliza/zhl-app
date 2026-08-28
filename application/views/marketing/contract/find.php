<div class="v-scroll">
	<table id="tbl_find" class="table table-condensed table-hover table-fixed">
		<thead>
			<tr>
				<th class="w-70">#</th>
				<th class="w-100">Contract No</th>
				<th class="w-100">Date</th>
				<th style="text-align: left;">Customer</th>
				<th class="w-300" style="text-align: left;">Destination</th>
				<th style="text-align: center;" colspan="2">Total Amount</th>
				<th style="text-align: right;">Total Qty</th>
			</tr>
		</thead>
		<tbody>
			<?php

			if ($find_record){
				$i = 0;
				foreach ($find_record as $r){
					$i++;
					$edit_url = site_url('sales-contract/show-find/?id='.encode_str($r->contract_hdr_id, 'contract'));

					if ($r->currency_id == 'USD'){
						$total_usd_amount = $r->grand_total;
					} else {
						$total_usd_amount = $r->grand_total * $r->rate_usd;
					}
					echo '<tr>';
					echo '<td class="text-center w-70">';
					echo '<a href="'.$edit_url.'" bariske = '.$i.' type="button" class="btn btn-xs blue btnedit">Select</a>';
	//				echo '<button id='.$r->contract_hdr_id.' bariske = '.$i.' type="button" class="btn btn-xs blue btnedit">Edit</button>';
					echo '</td>';
					echo '<td class="contract_no w-100 text-center">'.$r->contract_no.'</td>';
					echo '<td class="contract_date w-120 text-center">'.tgl_ind($r->contract_date).'</td>';
					echo '<td class="customer_name">'.$r->customer_name.'</td>';
					echo '<td class="destination w-300">'.$r->destination.'</td>';
					echo '<td class="destination w-50 text-right">USD</td>';
					echo '<td class="w-120 text-right">'.number_format($total_usd_amount,2,'.',',').'</td>';
					echo '<td class="w-120 text-right">'.number_format($r->total_qty_contract,0).'</td>';
					echo '</tr>';
				}
			} else {
				echo '<tr><td colspan="8" style="text-align:center;">No Data Available</td></tr>';
			}
			?>
		</tbody>
	</table>
</div>
