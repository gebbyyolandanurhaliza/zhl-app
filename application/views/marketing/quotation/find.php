<div class="v-scroll">
	<table id="table_find" class="table table-condensed table-hover table-fixed">
		<thead>
			<tr>
				<th class="w-70 text-center">#</th>
				<th class="w-120 text-center">Quotation No</th>
				<th style="text-align: left;">Customer</th>
				<th class="w-120">Sales Person</th>
				<th class="w-120 text-center">Status</th>
				<th class="w-120">Document Date</th>
			</tr>
		</thead>
		<tbody>
			<?php
			if ($find_record){
				$i = 0;
				foreach ($find_record as $r){
					$i++;
					$edit_url = site_url('sales-quotation/show-find/?id='.encode_str($r->quotation_hdr_id));
					echo '<tr>';
					echo '<td class="text-center w-70">';
					echo '<a href="'.$edit_url.'" bariske = '.$i.' type="button" class="btn btn-xs blue btnedit">Select</a>';
					echo '</td>';
					echo '<td class="customer_name w-120 text-center">'.$r->quotation_number.'</td>';
					echo '<td class="customer_name">'.$r->customer_name.'</td>';
					echo '<td class="marketing_name w-120">'.$r->sales_firstname.' '.$r->sales_lastname.'</td>';
					echo '<td class="sales_status w-120 text-center">'.$r->status_name.'</td>';
					echo '<td class="document_date w-120 text-center">'.tgl_ind($r->document_date).'</td>';
					echo '</tr>';
				}		
			} else {
				echo "<tr><td colspan='6' style='text-align: center;'>No Data Available</td></tr>";
			}
			?>
		</tbody>
	</table>	
</div>