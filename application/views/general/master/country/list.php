<div class="page-content">
	
	<div class="container-fluid">
		<div class="row ">
			<div class="col-md-12">
				
				<?php echo $message;?>
				
				<div class="portlet light">
					<div class="portlet-title">
						<div class="caption">
							<i class="fa fa-table theme-font"></i>
							<span class="caption-subject theme-font bold uppercase">Master Country</span>
						</div>
						<div class="actions">
							<?php echo anchor(site_url('master/create_master/country'), '<i class="fa fa-plus"></i> Create New Country', 'class="btn btn-primary"'); ?>
						</div>
<!--						<div class="tools">							
							<a href="javascript:;" class="collapse"></a>
							<a href="javascript:;" class="reload"></a>
						</div>-->
					</div>

					<div class="portlet-body flip-scroll">
						<table class="table table-bordered table-striped" id="mytable">
							<thead>
								<tr>
									<th class="center" width="80px">No</th>
									<th>Country Name</th>
									<th>Country Code</th>
									<th>Dialing Code</th>
									<th>COO Form Type</th>
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
								foreach ($country_data as $country)
								{
							?>
								<tr>
									<td class="center"><?php echo ++$start ?></td>
									<td><?php echo $country->country_name ?></td>
									<td><?php echo $country->country_ids ?></td>
									<td><?php echo $country->country_idn ?></td>
									<td><?php echo $country->form_id ?></td>
									<td><?php echo $country->created_by ?></td>
									<td><?php echo $country->created_date ?></td>
									<td><?php echo $country->updated_by ?></td>
									<td><?php echo $country->updated_date ?></td>
									<td style="text-align:center" width="100px">
									<?php 
									echo anchor(site_url('master/edit_master/country/'.$country->country_id),'Edit'); 
									echo ' | '; 
									echo anchor(site_url('master/delete/country/'.$country->country_id),'Delete','onclick="javasciprt: return confirm(\'Are You Sure ?\')"'); 
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
		$("#mytable").dataTable();
	});
</script>