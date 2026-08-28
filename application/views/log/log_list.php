<div class="page-content">
	
	<div class="container-fluid">
		<div class="row ">
			<div class="col-md-12">
								
				<div class="portlet light">
					<div class="portlet-title">
						<div class="caption">
							<i class="fa fa-table theme-font"></i>
							<span class="caption-subject theme-font bold uppercase">System Log</span>
						</div>
						<div class="actions">
							<?php echo anchor(site_url('System_log/log_create'), '<i class="fa fa-plus"></i> Create New Log', 'class="btn btn-primary"'); ?>
						</div>
					</div>

					<div class="portlet-body flip-scroll">
						<input type="hidden" name="id" id="id" value="">
						<table class="table table-bordered table-striped" id="mytable">
							<thead>
								<tr>
								<th class="center" width="5%">Action</th>
								<th class="center" width="20%">Created By</th>
								<th class="center" width="20%">Created Dated</th>
								<th>Subject</th>
								</tr>
							</thead>
							<tbody class="tbl-pete" id="tbl-pete">
								<?php foreach ($ind as $key) { ?>
								<tr>
								<td align="center"><a class="btn btn yellow" href="<?php echo site_url('System_log/log_view?id='.$key->id); ?>"><i class="fa fa-eye"></i></a></td>
								<td align="center"><?php echo $key->creator; ?></td>
								<td align="center"><?php echo $key->tgl; ?></td>
								<td><?php echo $key->subjek; ?></td>
							    </tr>
								<?php } ?>
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


function filterfactory(){
	$pete = document.getElementById('pete').value;

	console.log("<?php echo base_url(); ?>shipping/container_stock_filter?pete=" + $pete);


	        $.ajax({
            url: "<?php echo base_url(); ?>shipping/container_stock_filter?pete=" + $pete,
            success: function(response){
            //location.reload()
            $("#tbl-pete").html(response);
            },
            dataType: "html"
            });
}

</script>