<!--<div class="v-scroll">-->
	<table id="tblmst_brand" class="table table-bordered table-striped table-condensed" width="100%">
		<thead>
			<tr>			
				<th scope="col" class="text-center">Brand</th>
			</tr>
		</thead>
		<tbody>
			<?php
			foreach ($master_data as $master)
			{
			?>
				<tr>				
					<td>
						<?php
						echo form_hidden('brand_id', $master->brand_id);
						echo $master->brand_name;
						?>
					</td>
				</tr>
			<?php
			}
			?>
		</tbody>
	</table>
<!--</div>-->

<script type="text/javascript">
	$(document).ready(function(){
		$("#tblmst_brand").dataTable({
			"sScrollX": "99%", //This is what made my columns increase in size.
			"bScrollCollapse": true,
			"bLengthChange": false,
			"bFilter": true,
			"bPaginate"	: true,
			"bInfo": false,
		});
	});
</script>