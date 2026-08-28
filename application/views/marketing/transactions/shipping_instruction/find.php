<div class="v-scroll h-400 loading_find">
	<table id="tbl_find" class="table table-condensed table-hover table-fixed">
		<thead>
			<tr>
				<th class="w-70">#</th>
				<th class="w-100">PO Date</th>
				<th class="w-120">PO No</th>
				<th class="w-120">Sales Contract No</th>
				<th colspan="2">Customer</th>

				<!--<th class="w-200">Destination</th>-->
			</tr>
		</thead>
		<tbody>
			<?php
			$i = 0;
			foreach ($find_record as $r){
				$mixed = ($r->mix_po > 1) ? '<span class="label label-sm label-info">MIXED</span>' : '';

				$i++;
				$edit_url = site_url('marketing_transaction/shipping_instruction/edit/?id='.encode_str($r->ship_id));
				echo '<tr>';
				echo '<td class="text-center">';
				echo '<a href="'.$edit_url.'" bariske = '.$i.' type="button" class="btn btn-xs blue btnedit">Select</a>';
//				echo '<button id='.$r->contract_hdr_id.' bariske = '.$i.' type="button" class="btn btn-xs blue btnedit">Edit</button>';
				echo '</td>';
				echo '<td class="ship_date text-center">'.tgl_ind($r->po_date).'</td>';
				echo '<td class="contract_no text-center">'.$r->po_number.'</td>';
				echo '<td class="contract_date text-center">'.$r->contract_no.'</td>';
				echo '<td class="customer_name">'.$r->customer_name.'</td>';
//				echo '<td class="destination w-200">'.$r->destination.'</td>';
				echo '<td class="mix_po right w-50">'.$mixed.'</td>';
				echo '</tr>';
			}
			?>
		</tbody>
	</table>
</div>
