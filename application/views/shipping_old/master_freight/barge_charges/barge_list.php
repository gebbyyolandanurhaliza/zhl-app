<div class="page-content">

	<div class="container-fluid">
		<div class="row ">
			<div class="col-md-12">

				<?php echo $message;?>

				<div class="portlet light">
					<div class="portlet-title">
						<div class="caption">
							<i class="fa fa-table theme-font"></i>
							<span class="caption-subject theme-font uppercase">Master Barge Charges</span>
						</div>
						<div class="actions">
							<?php echo anchor(site_url('master-barge/add'), '<i class="fa fa-plus"></i> Create New Barge Charges', 'class="btn btn-primary"'); ?>
						</div>
					</div>

					<div class="portlet-body flip-scroll">
						<div class="table-scrollable-borderless">
							<table id="tblmst_barge" class="table table-bordered table-striped table-condensed" >
							    <thead>
                                    <tr>
                                        <th rowspan="2">ID</th>
                                        <th rowspan="2">container Name</th>
                                        <th rowspan="2">Container Size</th>
										<th rowspan="2">Validity From</th>
										<th rowspan="2">Validity Till</th>
                                        <th colspan="5">Vendor's Price</th>
                                        <th colspan="5">Customer's Price</th>
										<th rowspan="2" width="100px">Action</th>
                                    </tr>
									<tr>
										<th>Export Empty</th>
                                        <th>Export Reefer</th>
                                        <th>Export Laden</th>
                                        <th>Import Transhipment</th>
                                        <th>Misc</th>
										<th>Export Empty</th>
                                        <th>Export Reefer</th>
                                        <th>Export Laden</th>
                                        <th>Import Transhipment</th>
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
                "url" : "<?php echo site_url('master_barge/json');?>",
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
                    "data" : "vendor_export_reefer",
					"className" : "text-right",
					"orderable" : false
                },
                {
                    "data" : "vendor_export_laden",
					"className" : "text-right",
					"orderable" : false
                },
                {
                    "data" : "vendor_import_transhipment",
					"className" : "text-right",
					"orderable" : false
                },
                {
                    "data" : "vendor_misc",
					"orderable" : false
                },
				{
                    "data" : "cust_export_empty",
					"className" : "text-right",
					"orderable" : false
                },
                {
                    "data" : "cust_export_reefer",
					"className" : "text-right",
					"orderable" : false
                },
                {
                    "data" : "cust_export_laden",
					"className" : "text-right",
					"orderable" : false
                },
                {
                    "data" : "cust_import_transhipment",
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
