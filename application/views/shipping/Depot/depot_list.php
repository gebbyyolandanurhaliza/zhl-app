<div class="page-content">

	<div class="container-fluid">
		<div class="row ">
			<div class="col-md-12">

				<?php echo $message;?>

				<div class="portlet light">
					<div class="portlet-title">
						<div class="caption">
							<i class="fa fa-table theme-font"></i>
							<span class="caption-subject theme-font uppercase">Master Depot List</span>
						</div>
						<div class="actions">
							<?php echo anchor(site_url('shipping_depot/add'), '<i class="fa fa-plus"></i> Create New Depot', 'class="btn btn-primary"'); ?>
						</div>
					</div>

					<div class="portlet-body flip-scroll">
						<div class="table-scrollable-borderless">
							<table id="tblmst_barge" class="table table-bordered table-striped table-condensed" >
							    <thead>
                                    <tr>
                                        <th>No</th>
                                        <th width="550px">Depot Name</th>
										<th width="100px">Created By</th>
                                        <th width="100px">Created Dated</th>
                                        <th width="100px">Updated By</th>
                                        <th width="100px">Updated Dated</th>
										<th width="50px">Action</th>
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
                "url" : "<?php echo site_url('shipping_depot/json');?>",
				"type" : "POST"
            },
            columns :
            [
                {
                    "data" : "depot_id",
					"className" : "text-center",
                    "orderable" : true
                },
                {
                    "data" : "depot_name",
					"className" : "text-center",
					"orderable" : false
                },
				{
                    "data" : "createdby",
					"className" : "text-center",
					"orderable" : true
                },
                {
                    "data" : "createddate",
					"className" : "text-right",
					"orderable" : false
                },
                {
                    "data" : "updateby",
                    "className" : "text-right",
                    "orderable" : false
                },
                {
                    "data" : "updateddate",
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
