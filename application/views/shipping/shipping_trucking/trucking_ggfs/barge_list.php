<div class="page-content">

	<div class="container-fluid">
		<div class="row ">
			<div class="col-md-12">

				<?php echo $message;?>

				<div class="portlet light">
					<div class="portlet-title">
						<div class="caption">
							<i class="fa fa-table theme-font"></i>
							<span class="caption-subject theme-font uppercase">Master Trucking List</span>
						</div>
						<div class="actions">
							<?php echo anchor(site_url('shipping_trucking/add_ggfs'), '<i class="fa fa-plus"></i> Create New Trucking Prices', 'class="btn btn-primary"'); ?>
						</div>
					</div>

					<div class="portlet-body flip-scroll">
						<div class="table-scrollable-borderless">
							<table id="tblmst_barge" class="table table-bordered table-striped table-condensed" >
							    <thead>
                                    <tr>
                                        <th rowspan="2">ID</th>
                                        <th rowspan="2">Container Size</th>
										<th rowspan="2">Validity From</th>
										<th rowspan="2">Validity Till</th>
                                        <th colspan="1">Vendor's Price</th>
                                        <th colspan="1">Customer's Price</th>
										<th rowspan="2" width="100px">Action</th>
                                    </tr>
									<tr>
										<th>Trucking</th>
                                        <th>Trucking</th>
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
        var t = $("#tblmst_barge").dataTable({
            initComplete : function(){
                var api = this.api();
                $('#tblmst_barge_filter input')
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
                "url" : "<?php echo site_url('shipping_trucking/json_ggfs');?>",
				"type" : "POST"
            },
            columns :
            [
                {
                    "data" : "trucking_id",
					"className" : "text-center",
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
                    "data" : "validity_until",
					"className" : "text-center",
					"orderable" : true
                },
                {
                    "data" : "vendor_trucking_price",
					"className" : "text-right",
					"orderable" : false
                },
                {
                    "data" : "cust_trucking_price",
					"className" : "text-right",
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
