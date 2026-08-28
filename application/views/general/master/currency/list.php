<div class="page-content">
	
	<div class="container-fluid">
		<div class="row ">
			<div class="col-md-12">
				
				<?php echo $message;?>
				
				<div class="portlet light">
					<div class="portlet-title">
						<div class="caption">
							<i class="fa fa-table theme-font"></i>
							<span class="caption-subject theme-font bold uppercase">Master Currency</span>
						</div>
						<div class="actions">
							<?php echo anchor(site_url('master/create_master/currency'), '<i class="fa fa-plus"></i> Create New Currency', 'class="btn btn-primary"'); ?>
						</div>
					</div>

					<div class="portlet-body flip-scroll">
						<table class="table table-bordered table-striped" id="table_currency">
							<thead>
								<tr>
									<th class="center" width="50px">No</th>
									<th>Currency ID</th>
									<th>Currency Name</th>
									<th>Currency Symbol</th>
									<th>Say In Words</th>
									<th>Say In Words 2</th>
									<th>Created By</th>
									<th>Created Date</th>
									<th>Updated By</th>
									<th>Updated Date</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
							<?php
								$start = 0;
								foreach ($currency_data as $currency)
								{
							?>
								<tr>
									<td class="center"><?php echo ++$start ?></td>
									<td class="text-center"><?php echo $currency->currency_id ?></td>
									<td class="text-left"><?php echo $currency->currency_name ?></td>
									<td class="text-center"><?php echo $currency->currency_symbol ?></td>
									<td class="text-left"><?php echo $currency->currency_say_in_words ?></td>
									<td class="text-left"><?php echo $currency->currency_say_in_words2 ?></td>
									<td class="text-left"><?php echo $currency->created_by ?></td>
									<td class="text-center"><?php echo $currency->created_date ?></td>
									<td class="text-left"><?php echo $currency->updated_by ?></td>
									<td class="text-center"><?php echo $currency->updated_date ?></td>
									<td style="text-align:center" width="100px">
									<?php 
									echo anchor(site_url('master/edit_master/currency/'.$currency->currency_id),'Edit'); 
									echo ' | '; 
									echo anchor(site_url('master/delete/currency/'.$currency->currency_id),'Delete','onclick="javasciprt: return confirm(\'Are You Sure Want To Delete Currency '.$currency->currency_id.' ?\')"'); 
									?>
									</td>
								</tr>
							<?php
								}
							?>
							</tbody>
						</table>
					</div>

				</div>
				
			</div>
		</div>
	</div>
	
</div>

<script type="text/javascript">
	$(document).ready(function () {
		$("#table_currency").dataTable();
	});
</script>