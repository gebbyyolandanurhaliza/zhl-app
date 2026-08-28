<div class="v-scroll">
	<table id="tbl_find" class="table table-condensed table-hover table-fixed">
		<thead>
			<tr>
				<th class="w-70">#</th>
				<th class="w-100">Contract No</th>
				<th class="w-100">Date</th>
				<th>Customer</th>
				<th class="w-200">Destination</th>
			</tr>
		</thead>
		<tbody>
			<?php
			$i = 0;
			foreach ($find_record as $r){
				$i++;
				$edit_url = site_url('marketing_transaction/sales_contract/edit/?id='.encode_str($r->contract_hdr_id));
				echo '<tr>';
				echo '<td class="text-center w-70">';
				echo '<a href="'.$edit_url.'" bariske = '.$i.' type="button" class="btn btn-xs blue btnedit">Select</a>';
//				echo '<button id='.$r->contract_hdr_id.' bariske = '.$i.' type="button" class="btn btn-xs blue btnedit">Edit</button>';
				echo '</td>';
				echo '<td class="contract_no w-100 text-center">'.$r->contract_no.'</td>';
				echo '<td class="contract_date w-100 text-center">'.$r->contract_date.'</td>';
				echo '<td class="customer_name">'.$r->customer_name.'</td>';
				echo '<td class="destination w-200">'.$r->destination.'</td>';
				echo '</tr>';
			}
			?>
		</tbody>
	</table>	
</div>