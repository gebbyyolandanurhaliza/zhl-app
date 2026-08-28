<div class="v-scroll">
	<table id="tbl_find" class="table table-condensed table-hover table-fixed">
		<thead>
			<tr>
				<th class="w-70">#</th>
				<th class="w-130">Proforma Inv. No</th>
				<th class="w-100">Date</th>
				<th class="w-130">Sales Contract No</th>
				<th style="text-align: left;">Customer</th>
				<th class="w-80" style="text-align: right;">Amount</th>
			</tr>
		</thead>
		<tbody>
			<?php
			
			if ($find_record){
				$i = 0;
				foreach ($find_record as $r){
					$i++;
					$edit_url = site_url('proforma-invoice/show-find/?id='.encode_str($r->pi_hdr_id, 'pi'));
					echo '<tr>';
					echo '<td class="text-center w-70">';
					echo '<a href="'.$edit_url.'" bariske = '.$i.' type="button" class="btn btn-xs blue btnedit">Select</a>';
	//				echo '<button id='.$r->contract_hdr_id.' bariske = '.$i.' type="button" class="btn btn-xs blue btnedit">Edit</button>';
					echo '</td>';
					echo '<td class="pi_number_no w-130 text-center">'.$r->pi_number.'</td>';
					echo '<td class="pi_date w-100 text-center">'.tgl_ind($r->pi_date).'</td>';
					echo '<td class="contract_no w-130 text-center">'.$r->contract_no.'</td>';
					echo '<td class="customer_name">'.$r->customer_name.'</td>';
					echo '<td class="inv_amount w-80 text-right">'.number_format($r->invoice_amount,0).'</td>';
					echo '</tr>';
				}
			} else {
				echo '<tr><td colspan="6" style="text-align:center;">No Data Available</td></tr>';
			}
			?>
		</tbody>
	</table>	
</div>