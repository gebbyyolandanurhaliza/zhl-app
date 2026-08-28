<style>
	.modal-content {
		border-radius: 10px;
	}

	.modal {
		text-align: center;
		padding: 0 !important;
	}

	.modal-content {
		border-radius: 10px;
	}

	.modal:before {
		content: '';
		display: inline-block;
		height: 100%;
		vertical-align: middle;
		margin-right: -4px;
	}

	.modal-dialog {
		display: inline-block;
		text-align: left;
		vertical-align: middle;
	}
</style>
<div class="page-content">
	<div class="container-fluid">
		<div class="row ">
			<div class="col-md-12">

				<?php echo $message; ?>

				<h5 style="font-weight: Bold; font-size: 20px;">Master Container List</h5>

				<nav aria-label="breadcrumb">
					<ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="#">Master / </a></li>
						<li class="breadcrumb-item active" aria-current="page">Container Zhl</li>
					</ol>
				</nav>

				<div class="portlet light">

					<div class="portlet-title">
						<div class="caption">
							<i class="fa fa-table theme-font"></i>
							<span class="caption-subject theme-font uppercase">Container ZHL</span>
						</div>
						<div class="actions">
							<button class="btn btn-primary" onclick="openForm()"><i class="fa fa-plus"></i> Create New</button>
							<!-- <?php echo anchor(site_url('marketing/create_master/container'), '<i class="fa fa-plus"></i> Create New Container ZHL', 'class="btn btn-primary"'); ?> -->
						</div>
					</div>

					<div class="portlet-body flip-scroll">
						<div class="table-scrollable-borderless table-responsive" style="height: 610px;">
							<table id="tblmst_container" class="table table-bordered table-striped table-condensed">
								<thead>
									<tr>
										<th scope="col" hidden width="50px" class="text-center">Container Id</th>
										<th scope="col" width="30px" class="text-center">#</th>
										<!-- <th scope="col" width="50px" class="text-center">ID</th> -->
										<th scope="col" width="300px" class="text-center">Container Number</th>
										<th scope="col" width="50px" class="text-center">Container Type</th>
										<th scope="col" width="50px" class="text-center">Container Abbr</th>
										<th scope="col" width="50px" class="text-center">Grade</th>
										<th scope="col" width="50px" class="text-center">Tare Weight</th>
										<th scope="col" width="100px" class="text-center">Created By</th>
										<th scope="col" width="100px" class="text-center">Created Date</th>
										<th scope="col" width="100px" class="text-center">Updated By</th>
										<th scope="col" width="100px" class="text-center">Updated Date</th>
									</tr>
								</thead>
								<tbody>
									<?php
									foreach ($master_data as $master) { ?>
										<tr>
											<td class="text-center" hidden><?php echo $master->container_zhl_id ?></td>
											<td style="text-align:center" width="100px">
												<i class="btn btn-xs green edit-container"><span class="fa fa-edit"> Edit</span></i>
												<i class="btn btn-xs red" onclick="deleted(<?= $master->container_zhl_id ?>)"> <span class="fa fa-trash"> Delete</span></i>

											</td>
											<td class="text-center"><?php echo $master->container_number ?></td>
											<td><?php echo $master->container_name ?></td>
											<td><?php echo $master->container_abbr ?></td>
											<td><?php echo $master->grade ?></td>
											<td><?php echo $master->tare_weight ?></td>
											<td><?php echo $master->created_by ?></td>
											<td class="text-center"><?php echo $master->created_date ?></td>
											<td><?php echo $master->updated_by ?></td>
											<td class="text-center"><?php echo $master->updated_date ?></td>
										</tr> <?php } ?>
								</tbody>
							</table>
						</div>
					</div>

				</div>
			</div>
		</div>
	</div>
</div>
<!-- Modal -->
<div class="modal fade" id="modal-create" tabindex="-1" role="dialog" aria-labelledby="modal-createTitle" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="modal-createTitle"><b style="font-size: 18px;">Master Container</b></h5>

			</div>
			<div class="modal-body">
				<form>
					<div class="form-group row margin-bottom-10">
						<label for="staticEmail" class="col-sm-3 col-form-label">Container Number</label>
						<div class="col-sm-6">
							<input type="text" class="form-control" id="container_number" value="">
						</div>
					</div>
					<div class="form-group row">
						<label for="inputPassword" class="col-sm-3 col-form-label">Container Type</label>
						<div class="col-sm-9">
							<select class="form-control" id="container_id" data-placeholder="choose container type">
								<?php foreach ($listContainerType as $val) : ?>
									<option value="<?= $val->container_id ?>"><?= $val->container_name . " - " . $val->container_abbr ?></option>
								<?php endforeach; ?>
							</select>
						</div>
					</div>
					<div class="form-group row">
						<label for="inputPassword" class="col-sm-3 col-form-label">Grade</label>
						<div class="col-sm-9">
							<select class="form-control" id="grade" data-placeholder="" data-placeholder="test">
								<option value="Tetra Pak">Tetra Pak</option>
								<option value="New">New</option>
								<option value="Normal">Normal</option>
							</select>
						</div>
					</div>
					<div class="form-group row">
						<label for="inputPassword" class="col-sm-3 col-form-label">Tare Weight (Kg)</label>
						<div class="col-sm-4">
							<input type="" class="form-control" name="tare_weight" id="tare_weight" value="">
						</div>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<a class="btn btn-danger" id="btn-save" onclick="save()">Save</a>
				<button type="button" data-dismiss="modal" class="btn btn-default">Cancel</button>
			</div>
		</div>
	</div>
</div>


<script type="text/javascript">
	$(document).ready(function() {
		// swal("Good job!", "You clicked the button!", "success");





		$("#tblmst_container").dataTable({
			"sScrollX": "100%", //This is what made my columns increase in size.
			// "bScrollCollapse": true,
			// "sScrollY": "500px",
			"paging": false,
			"autoWidth": false
		});
	});

	function openForm() {
		// $("#modal-create").modal('show');
		$('#modal-create').modal({
			keyboard: true
		})
		$('#btn-save').attr('oncilck', 'save()');


	}

	function save() {
		$.ajax({
			type: "post",
			url: "<?= site_url("marketing/save_master_container_zhl") ?>",
			data: {
				container_number: $("#container_number").val(),
				container_id: $('#container_id').find(":selected").val(),
				grade: $('#grade').find(":selected").val(),
				tare_weight: $('#tare_weight').val(),
			},
			dataType: "json",
			success: function(response) {
				// console.log(response)

				if (response == true) {
					$("#modal-create").modal('hide');
					swal("Create Success!", "You clicked the button!", "success");
					setInterval(function() {
						location.reload();
					}, 3000);
				} else {

				}
			}
		});
	}

	function update(id) {
		swal({
				title: "Are you sure?",
				text: "You will not be able to recover this data!",
				type: "warning",
				showCancelButton: true,
				confirmButtonColor: '#DD6B55',
				confirmButtonText: 'Yes, Update it!',
				cancelButtonText: "No, cancel it!",
				closeOnConfirm: false,
				closeOnCancel: true
			},
			function(isConfirm) {

				if (isConfirm) {
					$.ajax({
						type: "post",
						url: "<?= site_url("marketing/update_master_container_zhl") ?>",
						data: {
							container_zhl_id: id,
							container_number: $("#container_number").val(),
							container_id: $('#container_id').find(":selected").val(),
							grade: $('#grade').find(":selected").val(),
							tare_weight: $('#tare_weight').val(),
						},
						dataType: "json",
						success: function(response) {
							console.log(response);

							if (response == true) {
								$("#modal-create").modal('hide');
								swal("Update Success!", "You clicked the button!", "success");
								setInterval(function() {
									location.reload();
								}, 2000);
							}
						},
						error: function(err, errs) {
							swal("Failed!", "Database Error Occurred!", "error");
						}
					});
					// swal("Shortlisted!", "Candidates are successfully shortlisted!", "success");

				}
			});
	}

	function deleted(id) {
		swal({
				title: "Are you sure?",
				text: "You will not be able to recover this data!",
				type: "warning",
				showCancelButton: true,
				confirmButtonColor: '#DD6B55',
				confirmButtonText: 'Yes, Deleted it!',
				cancelButtonText: "No, cancel it!",
				closeOnConfirm: false,
				closeOnCancel: true
			},
			function(isConfirm) {

				if (isConfirm) {
					$.ajax({
						type: "post",
						url: "<?= site_url("marketing/delete_master_container_zhl") ?>",
						data: {
							container_zhl_id: id,
						},
						dataType: "json",
						success: function(response) {
							console.log(response);

							if (response == true) {
								$("#modal-create").modal('hide');
								swal("Deleted Success!", "You clicked the button!", "success");
								setInterval(function() {
									location.reload();
								}, 2000);
							}
						},
						error: function(err, errs) {
							swal("Failed!", "Database Error Occurred!", "error");
						}
					});
					// swal("Shortlisted!", "Candidates are successfully shortlisted!", "success");

				}
			});
	}

	$(".edit-container").click(function() {
		var currentRow = $(this).closest("tr");
		var contid = currentRow.find("td:eq(0)").text(); // get current row 1st TD value
		var grade = currentRow.find("td:eq(4)").text(); // get current row 1st TD value

		if (grade == 'Tetra Pak') {
			$("#grade option[value='Tetra Pak']").attr('selected', 'selected');
		} else if (grade == 'New') {
			$("#grade option[value='New']").attr('selected', 'selected');
		} else {
			$("#grade option[value='Normal']").attr('selected', 'selected');
		}

		$("#tare_weight").val(currentRow.find("td:eq(6)").text())
		$("#container_number").val(currentRow.find("td:eq(2)").text())
		// $("#grade option[value=" + grade + "]").attr('selected', 'selected');
		$("#container_id option[value=" + contid + "]").attr('selected', 'selected');
		// alert(grade)

		$("#modal-create").modal('show');

		$('#btn-save').attr('onclick', 'update(' + contid + ')');
	});
</script>