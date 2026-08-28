<div class="page-content">

	<div class="container-fluid">
		<div class="row ">
			<div class="col-md-12">

				<?php echo $message;?>

				<div class="portlet light">
					<div class="portlet-title">
						<div class="caption">
							<i class="fa fa-table theme-font"></i>
							<span class="caption-subject theme-font uppercase">Master Transport Charges</span>
						</div>
						<div class="actions">
							<?php echo anchor(site_url('master-transport/add'), '<i class="fa fa-plus"></i> Create New Transport Charges', 'class="btn btn-primary"'); ?>
						</div>
					</div>

					<div class="portlet-body flip-scroll">
						<div class="table-scrollable-borderless">
							<table id="tbllist" class="table table-bordered table-striped table-condensed" >
							    <thead>
                                    <tr>
                                        <th rowspan="2">ID</th>
                                        <th rowspan="2">container Name</th>
                                        <th rowspan="2">Container Size</th>
										<th rowspan="2">Validity From</th>
										<th rowspan="2">Validity Till</th>
                                        <th colspan="4">Vendor's Price</th>
                                        <th colspan="4">Customer's Price</th>
										<th rowspan="2" width="100px">Action</th>
                                    </tr>
									<tr>
										<th>Empty</th>
                                        <th>Laden</th>
                                        <th>Loose Cargo</th>
                                        <th>Misc</th>
										<th>Empty</th>
                                        <th>Laden</th>
                                        <th>Loose Cargo</th>
                                        <th>Misc</th>
									</tr>
                                </thead>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        var t = $("#tbllist").dataTable({
            initComplete : function(){
                var api = this.api();
                $('#tbllist_filter input')
                    .off('.DT')
                    .on('keyup.DT', function(e){
                    // if (e.keyCode == 13){
                        api.search(this.value).draw();
                    // }
                });
            },
            oLanguage:{
                sProcessing: "loading..."
            },
            processing : true,
            serverside : true,
            ajax : {
                "url" : "<?php echo site_url('master_transport/json');?>",
				"type" : "POST"
            },
            columns :
            [
                {
                    "data" : "transport_charges_id",
					"className" : "text-center",
                    "orderable" : true
                },
                {
                    "data" : "container_name",
                    "orderable" : true
                },
                {
                    "data" : "container_size",
					"className" : "text-center",
					"orderable" : false
                },
				{
                    "data" : "validity_from",
					"className" : "text-center",
					"orderable" : true
                },
				{
                    "data" : "validity_till",
					"className" : "text-center",
					"orderable" : true
                },
                {
                    "data" : "vendor_empty",
					"className" : "text-right",
					"orderable" : false
                },
                {
                    "data" : "vendor_laden",
					"className" : "text-right",
					"orderable" : false
                },
                {
                    "data" : "vendor_loose_cargo",
					"className" : "text-right",
					"orderable" : false
                },
                {
                    "data" : "vendor_misc",
					"orderable" : false
                },
				{
                    "data" : "cust_empty",
					"className" : "text-right",
					"orderable" : false
                },
                {
                    "data" : "cust_laden",
					"className" : "text-right",
					"orderable" : false
                },
                {
                    "data" : "cust_loose_cargo",
					"className" : "text-right",
					"orderable" : false
                },
                {
                    "data" : "cust_misc",
					"orderable" : false
                },
                {
                    "data" : "action",
                    "orderable" : false,
                    "className" : "text-center"
                }
            ],
        });
    });
</script>
