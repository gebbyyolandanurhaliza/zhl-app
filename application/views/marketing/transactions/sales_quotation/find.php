<div class="v-scroll">
	<table id="table_find" class="table table-condensed table-hover table-fixed">
		<thead>
			<tr>
				<th class="w-70 text-center">#</th>
				<th class="w-100 text-center">Quotation No</th>
				<th>Customer</th>
				<th class="w-120">Sales Person</th>
				<th class="w-120 text-center">Status</th>
				<th class="w-100">First Posting Date</th>
			</tr>
		</thead>
		<tbody>
			<?php
			$i = 0;
			foreach ($find_record as $r){
				$i++;
				$edit_url = site_url('marketing_transaction/sales_quotation/edit/?id='.encode_str($r->quotation_hdr_id));
				echo '<tr>';
				echo '<td class="text-center w-70">';
				echo '<a href="'.$edit_url.'" bariske = '.$i.' type="button" class="btn btn-xs blue btnedit">Select</a>';
				echo '</td>';
				echo '<td class="customer_name w-100 text-center">'.$r->quotation_number.'</td>';
				echo '<td class="customer_name text-center">'.$r->customer_name.'</td>';
				echo '<td class="marketing_name w-120">'.$r->sales_firstname.' '.$r->sales_lastname.'</td>';
				echo '<td class="sales_status w-120 text-center">'.$r->status_name.'</td>';
				echo '<td class="posting_date w-100 text-center">'.tgl_mdy($r->posting_date).'</td>';
				echo '</tr>';
			}			
			?>
		</tbody>
	</table>	
</div>