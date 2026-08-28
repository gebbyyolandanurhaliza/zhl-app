<div class="page-content">

	<div class="container-fluid">
		<div class="row ">
			<div class="col-md-12">

				<?php echo $message;?>

				<div class="portlet light">
					<div class="portlet-title">
						<div class="caption">
							<i class="fa fa-table theme-font"></i>
							<span class="caption-subject theme-font uppercase">Master Freight Charges</span>
						</div>
						<div class="actions">
							<?php echo anchor(site_url('master-freight/add'), '<i class="fa fa-plus"></i> Create New Freight Charges', 'class="btn btn-primary"'); ?>
						</div>
<!--						<div class="tools">
							<a href="javascript:;" class="collapse"></a>
							<a href="javascript:;" class="reload"></a>
						</div>-->
					</div>

					<div class="portlet-body flip-scroll">
						<div class="table-scrollable-borderless">
							<table id="tblmst_freight" class="table table-bordered table-striped table-condensed" >
							    <thead>
                                    <tr>
                                        <th rowspan="2">ID</th>
										<th rowspan="2">Container Type</th>
                                        <th rowspan="2">Container Size</th>
                                        <th rowspan="2">Port</th>
                                        <th rowspan="2">Country</th>
										<th rowspan="2">Validity From</th>
										<th rowspan="2">Validity Till</th>
                                        <th colspan="7">Vendor</th>
										<th colspan="2">Customer</th>
										<th rowspan="2" width="100px">Action</th>
                                    </tr>
									<tr>
										<th>Rates 1</th>
                                        <th>Rates 2</th>
                                        <th>Rates 3</th>
                                        <th>Shipping Line 1</th>
                                        <th>Shipping Line 2</th>
                                        <th>Shipping Line 3</th>
										<th>Misc</th>
										<th>Rates</th>
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
        var t = $("#tblmst_freight").dataTable({
            initComplete : function(){
                var api = this.api();
                $('#tblmst_freight_filter input')
                    .off('.DT')
                    .on('keyup.DT', function(e){
                    if (e.keyCode == 13){
                        api.search(this.value).draw();
                    }
                });
            },
            oLanguage:{
                sProcessing: "loading..."
            },
            processing : true,
            serverside : true,
            ajax : {
                "url" : "<?php echo site_url('master_freight/json');?>", "type" : "POST"
            },
            columns :
            [
                {
                    "data" : "freight_charges_id",
                    "orderable" : true
                },
                {
                    "data" : "container_name"
                },
				{
                    "data" : "container_size",
					"className" : "text-right"
                },
                {
                    "data" : "port_name"
                },
                {
                    "data" : "country_name"
                },
				{
                    "data" : "validity_from",
					"className" : "text-center"
                },
				{
                    "data" : "validity_till",
					"className" : "text-center"
                },
                {
                    "data" : "vendor_rates",
					"className" : "text-right"
                },
                {
                    "data" : "vendor_rates2",
                    "className" : "text-right"
                },
                {
                    "data" : "vendor_rates3",
                    "className" : "text-right"
                },
                {
                    "data" : "shipping_line1",
                    "className" : "text-right"
                },
                {
                    "data" : "shipping_line2",
                    "className" : "text-right"
                },
                {
                    "data" : "shipping_line3",
                    "className" : "text-right"
                },

				{
                    "data" : "vendor_misc"
                },
				{
                    "data" : "cust_rates",
					"className" : "text-right"
                },
				{
                    "data" : "cust_misc"
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
