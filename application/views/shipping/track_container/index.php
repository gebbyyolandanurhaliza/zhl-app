<div class="page-content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">

				<?php
				echo $message;
				echo form_open(site_url('Shipping/print_tracking_pdf'), 'target="_blank" method="post" class="form-horizontal"');
				?>

				<h5 style="font-weight: Bold; font-size: 20px;">Tracking Container</h5>

				<nav aria-label="breadcrumb">
					<ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="#">Transaction / </a></li>
						<li class="breadcrumb-item"><a href="#">Shipping / </a></li>
						<li class="breadcrumb-item active" aria-current="page">Track Container</li>
					</ol>
				</nav>

				<div class="portlet light">

					<div class="portlet-title">
						<div class="caption">
							<i class="fa fa-table theme-font"></i>
							<span class="caption-subject theme-font uppercase">Track Container</span>
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
										<h5 class="panel-title"><i class='fa fa-filter'></i> Filter Data</h5>
									</div>
									<div class="panel-body">

										<div class="col-md-12 row">
											<div class="form-group">
												<label class="col-md-2 control-label" for="varchar">Location</label>
												<div class="col-md-3">
													<select class="form-control select2me" name="eta" data-placeholder="choose factory" id="location" data-placeholder="choose">
														<option value=""></option>
														<option value="PSG">PT. Pulau Sambu Guntung</option>
														<option value="RSUP">PT. RIau Sakti United Plantations</option>
														<option value="STI">PT. Sumtra Timur Indonesia</option>
													</select>
												</div>
											</div>
										</div>
										<div class="col-md-12 row">
											<div class="form-group">
												<label class="col-md-2 control-label" for="varchar">Tipe</label>
												<div class="col-md-3">
													<select class="form-control select2me" name="tipe" data-placeholder="choose factory" id="tipe" data-placeholder="choose" onclick="changeTipe()">
														<option value="2">Container Inward</option>
														<option value="1">Container Outward</option>
													</select>
												</div>
											</div>
										</div>

										<div class="col-md-12 row">
											<div class="form-group row">
												<label class="col-md-2 label-sm">Shipment Date</label>
												<div class="col-md-2">
													<div class="input-group">
														<span class="input-group-addon"><input type="checkbox" id="chk1" onclick="chk1_click()"></span>
														<div class="input-group date-picker input-daterange" name="shipment_date" data-date-format="dd-mm-yyyy">
															<input type="text" class="form-control date-picker" name="shipment_date" id="shipdate" value="<?php echo $shipdate; ?>">
														</div>
													</div>
												</div>
											</div>
										</div>

										<div class="col-md-12 row">
											<div class="form-group">
												<div class="col-md-12 col-md-offset-2">
													<button type="button" class="btn blue fontawesome-font btn-f-refresh" onclick="refresh()"><span class="fa fa-refresh"></span> Refresh</button>
													<button type="button" class="btn green fontawesome-font" data-toggle="modal" data-target="#containerLocation"><span class="fa fa-map-marker"></span> Container Location</button>
												</div>
											</div>
										</div>


									</div>
								</div>
							</div>



							<div class="flip-scroll">
								<div class="doc-scroll" style="height: 360px;">
									<div class="loadReport"></div>
								</div>
							</div>
						</div>
					</div>
					<div class="form-actions">
						<div class="row">
							<div class="col-md-12">
								<button type="button" class="btn btn-primary" id="inward" onclick="shipToInwardList()"><span class=" fa fa-calendar"></span> ship to inward list</button>
								<button type="button" class="btn btn-success" id="outward" onclick="shipToOutwardList()"><span class=" fa fa-calendar"></span> ship to outward list</button>


							</div>
						</div>
					</div>

				</div>

				<?php echo form_close() ?>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="containerLocation" tabindex="-1" role="dialog" aria-labelledby="containerLocationLabel" aria-hidden="true">
	<div class="modal-dialog" role="document" style="width: 1000px;">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="containerLocationLabel">Container Location</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="table-responsive" style="height: 400px;">
					<table class="table table-bordered datatables-search" id="table-container-local">
						<thead>
							<tr>
								<th width="10px"></th>
								<th style="vertical-align: middle;" nowrap>Container Number</th>
								<th style="vertical-align: middle;" nowrap>Last Shipment</th>
								<th style="vertical-align: middle;" nowrap>Last Eta</th>
								<th style="vertical-align: middle;" nowrap>Last Etd</th>
							</tr>
							<thead>
							<tbody>
								
							</tbody>
					</table>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<!-- <button type="button" class="btn btn-primary">Save changes</button> -->
			</div>
		</div>
	</div>
</div>


