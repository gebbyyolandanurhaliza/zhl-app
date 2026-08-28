
<div class="page-content">
	<div class="container-fluid">
		<div class="row">

			<div class="col-md-12">

				<?php
				echo $message;
				echo form_open(site_url('marketing_transaction/purchase_order/batch_print'), 'target="_blank" method="post" class="form-horizontal"');
				?>

				<div class="portlet light">

					<div class="portlet-title">
						<div class="caption">
							<i class="fa fa-table theme-font"></i>
							<span class="caption-subject theme-font uppercase">Purchase Order Monitor</span>
						</div>
						<div class="tools">
							<a href="javascript:;" class="collapse">
							</a>
							<a href="javascript:;" class="reload">
							</a>
							<a href="javascript:;" class="fullscreen"></a>
						</div>
					</div>

					<div class="portlet-body form">

						<div class="form-body row">
							<div class="col-md-12">

								<div class="panel panel-default">
									<div class="panel-heading">
										<h5 class="panel-title"><i class='fa fa-filter'></i> Filter PO</h5>
									</div>
									<div class="panel-body">
										<div class="form-group">
											<label class="col-md-2 control-label" for="varchar">SM In Charge</label>
											<div class="col-md-7">
												<input type="text" class="form-control" name="param_sm" id="param_sm" value="" placeholder="SM In Charge" title="Leave blank to show all the data" />
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-2 control-label" for="varchar">Search PO By</label>
											<div class="col-md-7">
												<input type="text" class="form-control" name="param_po" id="param_po" value="" placeholder="PO Number, Sales Contract No, Factory, Customer" title="Leave blank to show all the data" />
											</div>
										</div>

										<div class="form-group">
											<label class="col-md-2 control-label" for="varchar">Shipping Date</label>
											<div class="col-md-4">
												<div class="input-group date-picker input-daterange" data-date="<?php echo $current_date ?>" data-date-format="dd/mm/yyyy">
													<input type="text" class="form-control" id="ship_date1" name="ship_date1" value="<?php echo $ship_date1 ?>" title="date format : dd/mm/yyyy">
													<span class="input-group-addon" style="background: transparent; border-color: transparent">to</span>
													<input type="text" class="form-control" id="ship_date2" name="ship_date2" value="<?php echo $ship_date2; ?>" title="date format : dd/mm/yyyy">
												</div>
											</div>
										</div>
									</div>
									<div class="panel-footer">
										<div class="pull-right">
											<div class="skin skin-line">
												<div class="input-group">
													<div class="icheck-inline">
														<!-- <label>
															<input type="checkbox" name="chk_status" value="8" class="unichk">Shipped
														</label>
														<label>
															<input type="checkbox" name="chk_status" value="0">Pending
														</label>
														<label>
															<input type="checkbox" name="chk_status" value="3">Canceled
														</label> -->

														<label>
															<input type="checkbox" name="chk_status" class="icheck" data-checkbox="icheckbox_square-green" data-label="Shipped" value="8">Shipped
														</label>
														<label>
															<input type="checkbox" name="chk_status" class="icheck" data-checkbox="icheckbox_square-orange" data-label="Pending" value="0">Pending
														</label>
														<label>
															<input type="checkbox" name="chk_status" class="icheck" data-checkbox="icheckbox_square-red" data-label="Canceled" value="3">Canceled
														</label>
													</div>
												</div>
											</div>
										</div>
										<input type="button" id="btn_filter" class="btn blue fontawesome-font" value="&#xf0b0 Filter Purchase Order">

									</div>
								</div>

							</div>
						</div>

						<div class="flip-scroll">
							<!--<div class="col-md-12">-->
							<table class="table" style="margin-bottom: 1px;">
								<thead>
									<tr>
										<th style="width: 43px; text-align: center;"><input type="checkbox" id="togglecheck"></th>
										<th style="width: 150px; text-align: center;">Shipping Date</th>
										<th style="width: 150px; text-align: left;" >PO Number</th>
										<th style="width: 100px; text-align: left;">S.Contract No</th>
										<th style="width: 100px; text-align: center;">Factory</th>
										<th style="width: 150px; text-align: left;">SM In Charge</th>
										<th style="text-align: left;">Customer</th>
									</tr>
								</thead>
							</table>
							<div class="doc-scroll" style="height: 350px;">
								<div id="filtered_table" class="table-scrollable-borderless">
									<table id="tblmon_po" class="table table-condensed table-striped">

										<tbody>
											<?php
												if ($record_mon){
													foreach ($record_mon as $r) {
														echo "<tr>";
														echo "<td style='text-align: center; width:40px;'>";
															echo "<input type='checkbox' name='chk_po[]' class='chk_po unichk' value='$r->po_hdr_id'>";
														echo "</td>";
														echo "<td class='text-center w-150'><div>".tgl_ind($r->ship_date)."</div></td>";
														echo "<td class='text center w-150'><div>$r->po_number</div></td>";
														echo "<td class='text center w-100'><div>$r->contract_no</div></td>";
														echo "<td class='text-center w-100'><div>$r->factory_abbr</div></td>";
														echo "<td class='text-leftr w-150'><div>".$r->firstname." ".$r->lastname."</div></td>";
														echo "<td class=''><div>$r->customer_company_name</div></td>";
														echo "<tr>";
													}
												}
											?>
										</tbody>
									</table>
								</div>
							</div>
							<!--</div>-->
						</div>

					</div><!--/.portlet_body -->

					<div class="form-actions">
						<div class="row">
							<div class="col-md-12">
								<button class="btn btn-warning" id="btn_print" type="submit"><i class="fa fa-print"></i> Print Selected...</button>
								<!-- <a href="#" class="btn green-jungle" id="btn_excel" target="_blank" ><i class="fa fa-file-excel-o"></i> Excel ...</a> -->
							</div>
						</div>
					</div>

				</div>

				<?php echo form_close() ?>
			</div>
		</div>
	</div>
</div>

<script>
$(document).ready(function(){
	$('#btn_filter').on('click', function(){
		var param_sm	= $('#param_sm').val();
		var param		= $('#param_po').val();
		var shipdate1	= $('#ship_date1').val();
		var shipdate2	= $('#ship_date2').val();

		sambu.startPageLoading();

		// window.setTimeout(function() {
		// 	sambu.stopPageLoading();
		// }, 2000);

		$.ajax({
			type: "POST",
			url : "<?php echo site_url('marketing_transaction/purchase_order/monitor_filtered')?>",
			data: {
				param_sm		: param_sm,
				param_search	: param,
				ship_date1		: shipdate1,
				ship_date2		: shipdate2,
			},
			success: function(msg){
				$('#filtered_table').html(msg);
				$(':input[name=chk_status]').iCheck('check');
				sambu.stopPageLoading();
			}
		})
	});

	$('#togglecheck').on('click', function(){
		if (this.checked == true){
            $(".unichk").prop('checked', true).uniform();
			// $("input[type=checkbox]").prop('checked', true).uniform();
		} else {
            $(".unichk").prop('checked', false).uniform();
			// $("input[type=checkbox]").prop('checked', false).uniform();
		}
	});

	$("#btn_excel").on('click', function(){
		var param_sm	= $('#param_sm').val();
		var param		= $('#param_po').val();
		var shipdate1	= $('#ship_date1').val();
		var shipdate2	= $('#ship_date2').val();

		sambu.startPageLoading();

		$.ajax({
			type: "POST",
			url : "<?php echo site_url('generate-excel/monitor-po')?>",
			data: {
				param_sm		: param_sm,
				param_search	: param,
				ship_date1		: shipdate1,
				ship_date2		: shipdate2,
			},
			success: function(msg){
				// $('#filtered_table').html(msg);
				// $(':input[name=chk_status]').iCheck('check');
				sambu.stopPageLoading();
			}
		})
	});

	// $("input[name='chk_status']").on('change',function(){
	$(".icheck").on('ifChanged',function(){
	    var classes = [];

	    // $("input[name='chk_status']").each(function () {
		$(".icheck").each(function () {
	        if ($(this).is(":checked")) {
				classes.push('.' + $(this).val());
			}
	    });

	    if (classes == "") { // if no filters selected, show all items
	        $("#tblmon_po tbody tr").show();
	    } else { // otherwise, hide everything...
	        $("#tblmon_po tbody tr").hide();

	        $("#tblmon_po tr").each(function () {
	            var show = false;
	            var row = $(this);

	            classes.forEach(function (className) {
					// console.log(row.find('td' + className).html());
	                // if (row.find('td' + className).html() == '') {
					if (row.find(className).length) {
						show = true;
					}
	            });
	            if (show) {
					row.show();
				}
	        });
	    }
	});

});
</script>
