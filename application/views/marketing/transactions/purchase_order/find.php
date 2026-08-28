<div class="v-scroll h-400 loading_find">
	<table id="tbl_find" class="table table-condensed table-hover table-fixed">
		<thead>
			<tr>
				<th class="w-70">#</th>
				<th class="w-150">PO No</th>
				<th class="w-100">PO Date</th>
				<th class="w-100">Factory</th>
				<th style="text-align: left">Buyer / Customer</th>
				<th class="w-100" style="text-align: center">Contract No</th>
				<th colspan="2" class="w-200" style="text-align: left">Destination</th>
			</tr>
		</thead>
		<tbody>
			<?php
			$i = 0;
			foreach ($find_record as $r){
				$i++;
				
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
				
				$edit_url = site_url('marketing_transaction/purchase_order/edit/?id='.encode_str($r->po_hdr_id));
				echo '<tr class='.$bg_class.'>';
				echo '<td class="text-center w-70">';
				echo '<a href="'.$edit_url.'" bariske = '.$i.' type="button" class="btn btn-xs blue btnedit" idori="'.$r->po_hdr_id.'">Select</a>';
//				echo '<button id='.$r->contract_hdr_id.' bariske = '.$i.' type="button" class="btn btn-xs blue btnedit">Edit</button>';
				echo '</td>';
				echo '<td class="po_number w-150 text-center">'.$r->po_number.'</td>';
				echo '<td class="po_date w-100 text-center">'.tgl_ind($r->po_date).'</td>';
				echo '<td class="factory_abbr text-center w-100">'.$r->factory_abbr.'</td>';
				echo '<td class="buyer">'.$r->customer_company_name.'</td>';
				echo '<td class="contract_no text-center w-100">'.$r->contract_no.'</td>';
				echo '<td class="destination w-200">'.$r->destination_country.'</td>';
				echo "<td style='text-align: right; width:100px;'>$badges</td>";
				echo '</tr>';
			}
			?>
		</tbody>
	</table>	
</div>