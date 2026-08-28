<div class="page-content">

	<div class="container-fluid">
		<div class="row ">
			<div class="col-md-12">

				<?php echo $message;?>

				<div class="portlet light">
					<div class="portlet-title">
						<div class="caption">
							<i class="fa fa-table theme-font"></i>
							<span class="caption-subject theme-font uppercase">Master Barge Charges (GGFS)</span>
						</div>
						<div class="actions">
							<?php echo anchor(site_url('master-barge/add_ggfs'), '<i class="fa fa-plus"></i> Create New Barge Charges', 'class="btn btn-primary"'); ?>
						</div>
					</div>

					<div class="portlet-body flip-scroll">
						<div class="table-scrollable-borderless">
							<table id="tblmst_barge_ggfs" class="table table-bordered table-striped table-condensed" >
							    <thead>
                                    <tr>
                                        <th rowspan="2">ID</th>
                                        <th rowspan="2">container Name</th>
                                        <th rowspan="2">Container Size</th>
										<th rowspan="2">Validity From</th>
										<th rowspan="2">Validity Till</th>
                                        <th colspan="14">Vendor's Price</th>
                                        <th colspan="14">Customer's Price</th>
										<th rowspan="2" width="100px">Action</th>
                                    </tr>
									<tr>
                                    <th>Export Empty</th>
                                        <th>Export Laden</th>
                                        <th>Local Empty</th>
                                        <th>Local Laden</th>
                                        <th>Import Transhipment</th>
                                        <th>Recall</th>
                                        <th>Import Empty</th>
                                        <th>Loose Cargo</th>
                                        <th>Export Empty (CN)</th>
                                        <th>Import Transhipment (CN)</th>
                                        <th>Export Laden (CN)</th>
                                        <th>Misc</th>
                                        <th>Import Transhipment (DP)</th>
                                        <th>Import Transhipment (CN-DP)</th> 
										<th>Export Empty</th>
                                        <th>Export Laden</th>
                                        <th>Local Empty</th>
                                        <th>Local Laden</th>
                                        <th>Import Transhipment</th>
                                        <th>Recall</th>
                                        <th>Import Empty</th>
                                        <th>Loose Cargo</th>
                                        <th>Export Empty (CN)</th>
                                        <th>Import Transhipment (CN)</th>
                                        <th>Export Laden (CN)</th>
                                        <th>Misc</th>
                                        <th>Import Transhipment (DP)</th>
                                        <th>Import Transhipment (CN-DP)</th>
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
        var t = $("#tblmst_barge_ggfs").dataTable({
            initComplete : function(){
                var api = this.api();
                $('#tblmst_barge_ggfs_filter input')
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
                "url" : "<?php echo site_url('master_barge/json_ggfs');?>",
				"type" : "POST"
            },
            columns :
            [
                {
                    "data" : "barge_charges_id",
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
                    "data" : "vendor_export_empty",
					"className" : "text-right",
					"orderable" : false
                },
                {
                    "data" : "vendor_export_laden",
					"className" : "text-right",
					"orderable" : false
                },
                {
                    "data" : "vendor_local_empty",
                    "className" : "text-right",
                    "orderable" : false
                },
                {
                    "data" : "vendor_local_laden",
                    "className" : "text-right",
                    "orderable" : false
                },
                {
                    "data" : "vendor_import_transhipment",
					"className" : "text-right",
					"orderable" : false
                },
                {
                    "data" : "vendor_recall",
                    "className" : "text-right",
                    "orderable" : false
                },
                {
                    "data" : "vendor_empty_import",
                    "className" : "text-right",
                    "orderable" : false
                },
                {
                    "data" : "vendor_loose",
                    "className" : "text-right",
                    "orderable" : false
                },
                {
                    "data" : "vendor_export_empty_cn",
                    "className" : "text-right",
                    "orderable" : false
                },
                {
                    "data" : "vendor_import_transhipment_cn",
                    "className" : "text-right",
                    "orderable" : false
                },
                {
                    "data" : "vendor_export_laden_cn",
                    "className" : "text-right",
                    "orderable" : false
                },
                {
                    "data" : "vendor_misc",
					"orderable" : false
                },
                {
                    "data" : "vendor_import_transhipment_dp",
                    "className" : "text-right",
                    "orderable" : false
                },
                {
                    "data" : "vendor_import_transhipment_cndp",
                    "className" : "text-right",
                    "orderable" : false
                },
				{
                    "data" : "cust_export_empty",
					"className" : "text-right",
					"orderable" : false
                },
                {
                    "data" : "cust_export_laden",
					"className" : "text-right",
					"orderable" : false
                },
                {
                    "data" : "cust_local_empty",
                    "className" : "text-right",
                    "orderable" : false
                },
                {
                    "data" : "cust_local_laden",
                    "className" : "text-right",
                    "orderable" : false
                },
                {
                    "data" : "cust_import_transhipment",
					"className" : "text-right",
					"orderable" : false
                },
                {
                    "data" : "cust_recall",
                    "className" : "text-right",
                    "orderable" : false
                },
                {
                    "data" : "cust_empty_import",
                    "className" : "text-right",
                    "orderable" : false
                }, 
                {
                    "data" : "cust_loose",
                    "className" : "text-right",
                    "orderable" : false
                }, 
                {
                    "data" : "cust_export_empty_cn",
                    "className" : "text-right",
                    "orderable" : false
                },
                {
                    "data" : "cust_import_transhipment_cn",
                    "className" : "text-right",
                    "orderable" : false
                },
                {
                    "data" : "cust_export_laden_cn",
                    "className" : "text-right",
                    "orderable" : false
                }, 
                {
                    "data" : "cust_misc",
					"orderable" : false
                },
                {
                    "data" : "cust_import_transhipment_dp",
                    "className" : "text-right",
                    "orderable" : false
                },{
                    "data" : "cust_import_transhipment_cndp",
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
