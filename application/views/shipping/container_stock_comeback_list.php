<div class="page-content">
	
	<div class="container-fluid">
		<div class="row ">
			<div class="col-md-12">
				
				<?php //echo $message;?>
				
				<div class="portlet light">
					<div class="portlet-title">
						<div class="caption">
							<i class="fa fa-table theme-font"></i>
							<span class="caption-subject theme-font bold uppercase">Return and Used Containers</span>
						</div>
					</div>

					<div class="portlet-body flip-scroll">
						<div class="row">
		          <div class="col-md-6">
								<div class="col-md-12">
									<div class="form-group">
									  <label class="col-md-2 label-sm">Supplier</label>
									  <div class="col-md-6">
								      <!-- <select class="form-control select2me" data-placeholder="supplier" name="supplier" id="supplier">
								        <option value=""></option>
							        	<?php
								        foreach ($supplier as $r) {
								          echo '<option value="' . $r->supplier_name . '">' . $r->supplier_name . '</option>';
								        }
								        ?>
								      </select> -->
								      <input type="text" class="form-control" data-placeholder="supplier" name="supplier" id="supplier">
									  </div>
									</div>
								</div>
								<div class="col-md-12">
									<div class="form-group">
									  <label class="col-md-2 label-sm">Factory</label>
									  <div class="col-md-6">
									    <select class="form-control select2me" data-placeholder="Factory" name="factory" id="factory">
									        <option value=""></option>
									        <option value="RSUP">RSUP</option>
                              				<option value="PSG">PSG</option>
									    </select>
									  </div>
									</div>
								</div>
								<div class="col-md-12">
									<div class="form-group">
									  <label class="col-md-2 label-sm">Loading Port</label>
									  <div class="col-md-6">
									    <select class="form-control select2me" data-placeholder="loading_port" name="loading_port" id="loading_port">
									        <option value=""></option>
									        <?php
									        foreach ($port as $r) {
									          echo '<option value="' . $r->port_name . '">' . $r->port_name . '</option>';
									        }
									        ?>
									    </select>
									  </div>
									</div>
								</div>
								<div class="col-md-12">
									<div class="form-group">
									  <label class="col-md-2 label-sm">Year</label>
									  <div class="col-md-6">
									    <select class="form-control select2me" data-placeholder="tahun" name="tahun" id="tahun">
									        <option value=""></option>
									        <?php
									        foreach ($year as $r) {
									          echo '<option value="' . $r->tahun . '">' . $r->tahun . '</option>';
									        }
									        ?>
									    </select>
									  </div>
									</div>
								</div>
								<div class="col-md-12">
									<div class="form-group">
									  <label class="col-md-2 label-sm">Month</label>
									  <div class="col-md-6">
									    <select class="form-control select2me" data-placeholder="bulan" name="bulan" id="bulan">
									        <option value=""></option>
									          <?php
												      // Array bulan dalam bahasa Indonesia
												      $bulan = [
												          "January", "February", "March", "April",
												          "May", "June", "July", "August",
												          "September", "October", "November", "December"
												      ];
												      
												      // Loop melalui array bulan dan buat opsi
												      foreach ($bulan as $index => $nama_bulan) {
												          echo '<option value="' . ($index + 1) . '">' . $nama_bulan . '</option>';
												      }
												      ?>
									    </select>
									  </div>
									</div>
								</div>
								<div class="col-md-12">
									<div class="form-group">
									  <label class="col-md-2 label-sm">Container Type</label>
									  <div class="col-md-6">
									    <select class="form-control select2me" data-placeholder="container" name="container" id="container">
									        <option value=""></option>
									        <?php
									        foreach ($cont as $r) {
									          echo '<option value="' . $r->container_name . '">' . $r->container_name . '</option>';
									        }
									        ?>  
									    </select>
									  </div>
									</div>
								</div>
								<div class="col-md-12">
								<div class="form-group">
								  <div class="col-md-12 col-md-offset-2">
								    <button type="button" class="btn btn-primary col-md-2" id="btn-refresh" onclick="refresh()"><i class="fa fa-refresh"></i> Refresh</button>
								    <a class="btn green col-md-2" id="btn-excel" name="action" value="excel" onclick="excel()"><i class="fa fa-file-excel-o"></i> Excel</a>
								  </div>
								</div>
								</div>
		          </div>
		        </div>
		        <br><hr>
		        <div class="table-scrollable" style="overflow: auto; height: 550px;">
              <div class="table-scrollable" id="tbl-mon">
								<table class="table table-bordered table-striped" id="mytable">
									<thead>
										<tr>
										<th>Action</th>
										<th class="center" width="80px">No</th>
										<th>Stock Status</th>
										<th class="center" width="80px">Container Number</th>
										<th>Container Type</th>
										<th>Remark</th>
										<th>Loading Port</th>
										<th>Arrival Date</th>
										<th>Free Time</th>
										<th>Factory</th>
										<th>Supplier</th>
										<th>Import BL NO</th>
										<th>ETA PSG/RSUP</th>
										<th>Free Time Expiry Date</th>
										</tr>
									</thead>
									<tbody>
									
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function () {
		$("#mytable").dataTable();
		refresh()
	});

	function refresh() {
    $supplier = document.getElementById('supplier').value;
    $factory = document.getElementById('factory').value;
    $loading_port = document.getElementById('loading_port').value;
    $year = document.getElementById('tahun').value;
    $month = document.getElementById('bulan').value;
    $container = document.getElementById('container').value;

    $.ajax({
      url: "<?php echo base_url(); ?>shipping/mon_container_stock_filter?supplier=" + $supplier + "&factory=" + $factory + "&loading_port=" + $loading_port+ "&year=" + $year + "&month=" + $month+ "&container=" + $container,
      success: function(response) {
        $("#tbl-mon").html(response);
      },
      dataType: "html"
    });

    return false;

  }

  function excel() {
    $supplier = document.getElementById('supplier').value;
    $factory = document.getElementById('factory').value;
    $loading_port = document.getElementById('loading_port').value;
    $year = document.getElementById('tahun').value;
    $month = document.getElementById('bulan').value;
    $container = document.getElementById('container').value;

    javascript: location.href = "<?php echo base_url(); ?>shipping/container_stock_report?supplier=" + $supplier + "&factory=" + $factory + "&loading_port=" + $loading_port+ "&year=" + $year + "&month=" + $month+ "&container=" + $container;

  }
</script>