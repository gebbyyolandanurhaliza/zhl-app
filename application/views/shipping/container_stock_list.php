<!-- <?php print_r($container_number); ?> -->
<div class="page-content">
	
	<div class="container-fluid">
		<div class="row ">
			<div class="col-md-12">
			<?php
				if ($this->session->flashdata('message')) :
				echo $this->session->flashdata('message');
				endif;
			?>
				<div class="portlet light">
					<div class="portlet-title">
						<div class="caption">
							<i class="fa fa-table theme-font"></i>
							<span class="caption-subject theme-font bold uppercase">Stock Container</span>
						</div>
						<div class="actions">
							<?php echo anchor(site_url('Shipping/container_stock_create'), '<i class="fa fa-plus"></i> Create New Stock', 'class="btn btn-primary"'); ?>
						</div>
					</div>


						<div class="portlet-title">
							<div class="col-md-3">
									<select class="form-control" id="pete">
										<option value="">All Stock</option>
										<option value="RSUP">Riau Sakti United Plantation</option>
										<option value="PSG">Pulau Sambu Guntung</option>
									</select>
							</div>
									<button class="btn-primary btn green" onclick="filterfactory()">Search</button>
									<button class="btn-primary btn blue" onclick="filterexcel()">Excel</button>
							</div>



					<div class="portlet-body flip-scroll">
						<table class="table table-bordered table-striped" id="mytable">
							<thead>
								<tr>
								<th>Action</th>
								<th class="center" width="80px">No</th>
								<th>Stock Status</th>
								<th>Expiry Date Countdown</th>
								<th class="center" width="80px">Container Number</th>
								<th>Container Type</th>
								<th width="6%">Remark</th>							
								<th>Loading Port</th>
								<th>ETA PSG/RSUP</th>
								<th>Arrival Date</th>
								<th>Free Time</th>
								<th>Factory</th>
								<th>Supplier</th>
								<th>Import BL NO</th>
								<th>Free Time Expiry Date</th>
								</tr>
							</thead>
							<tbody class="tbl-pete" id="tbl-pete">
								<?php
								$start = 0;
								
								foreach ($container_number as $country)
								{

							    $awal  = strtotime($country->free_time_expiry);
							    $tempo = time();

							    $count_down = floor(($awal - $tempo) / (86400)) ;

								if ($country->Remark2=='IFT'){
									$return='Insufficient FT';
								}else if($country->Remark2=='QCf'){
									$return='QC fail';
								}else if($country->Remark2=='RNC'){
									$return='Reuse not approved by carrier';
								}elseif ($country->Remark2=='CC') {
									$return='Customs Checks';								
								}elseif ($country->Remark2=='ULS') {
									$return='Used for local stuffings';                                               
								}
								else{
									$return = '';
								}
								?>

								<tr>
									<td style="text-align:center" width="100px">
                                                    <a class="btn-sm btn-primary" href="<?php echo site_url('shipping/container_stock_transfer?stock='.$country->stock_id_dtl); ?>" onclick="javasciprt: return confirm('Are you sure Transfer Container <?php echo $country->container_number; ?> ?')"><i class="fa fa-arrows-h"></i></a>
                                                    <a class="btn-sm" href="<?php echo site_url('shipping/container_stock_return?stock='.$country->stock_id_dtl); ?>" onclick="javasciprt: return confirm('Are you sure Return Container <?php echo $country->container_number; ?> to Singapore?')"><i class="fa fa-refresh"></i></a>
                                                    <a class="btn-sm btn-warning" href="<?php echo site_url('shipping/container_stock_edit?stock='.$country->stock_id_hdr); ?>"><i class="fa fa-pencil"></i></a>
                                                    <a class="btn-sm btn-danger" href="<?php echo site_url('shipping/container_stock_delete?stock='.$country->stock_id_dtl); ?>" onclick="javasciprt: return confirm('Are you sure delete Container <?php echo $country->container_number; ?> ?')"><i class="fa fa-trash"></i></a>
									</td>
									<td class="center"><?php echo ++$start ?></td>
									<td align="center"><?php 
									if($country->status_note=='0'){
										echo "<b style='color : red;'>Stock Ready</b>";
									}else{
										echo "Stock Has Been Used";
									}
									?></td>
									<td align="center"><b><?php echo $count_down ?> Day </b></td>
									<td><?php echo $country->container_number ?></td>
									<td><?php  
									if ($country->container_id=='1'){
										echo "20ft Standard Container (s)";
									}elseif ($country->container_id=='2') {
										echo "20ft Reefer Container (s)";
									}elseif ($country->container_id=='3') {
										echo "40ft Standard Container (s)";
									}elseif ($country->container_id=='4') {
										echo "40ft High Cube Container (s)";
									}elseif ($country->container_id=='5') {
										echo "40ft Reefer Container (s)";
									}elseif ($country->container_id=='6') {
										echo "Loose Cargo";
									}elseif ($country->container_id=='7') {
										echo "40ft High Cube Reefer Container (s)";
									}elseif ($country->container_id=='8') {
										echo "See Remarks";
									}else{
										echo "Bulk shipment";
									}
									?></td>
									<td><?php echo $country->Remark?></td>
									<!-- <td><?php echo $return ?></td> -->
									<td><?php echo $country->loading_port ?></td>
									<td><?php echo date('d-m-Y', strtotime($country->eta)) ?></td>
									<td><?php echo date('d-m-Y', strtotime($country->arrival_date)) ?></td>
									<td><?php echo $country->free_time ?></td>
									<td><?php 
									if($country->factory=='RSUP'){
										echo "Riau Sakti United Plantations";
									}elseif($country->factory=='PSG'){
										echo "Pulau Sambu Guntung";
									}else{
										echo "Insert Factory...!!!";
									}
									?></td>
									<td><?php echo $country->supplier ?></td>
									<td><?php echo $country->import_bl_no ?></td>

									<td><?php echo date('d-m-Y', strtotime($country->free_time_expiry)) ?></td>
 								</tr>
							<?php
								}
							?>
							</tbody>
						</table>
					</div>

				</div>
				
			</div>
		</div>
	</div>
	
</div>

<script type="text/javascript">
	$(document).ready(function () {
		$("#mytable").dataTable();
	});


function filterfactory(){
	$pete = document.getElementById('pete').value;

	console.log("<?php echo base_url(); ?>shipping/container_stock_filter?pete=" + $pete);


	        $.ajax({
            url: "<?php echo base_url(); ?>shipping/container_stock_filter?pete=" + $pete,
            success: function(response){
            //location.reload()
            $("#tbl-pete").html(response);
            },
            dataType: "html"
            });
}

function filterexcel(){
	$pete = document.getElementById('pete').value;

	

	console.log("<?php echo base_url(); ?>shipping/container_stock_filter?pete=" + $pete);

	javascript:location.href="<?php echo base_url();?>shipping/excel_stock_container?pete=" + $pete;


	        // $.ajax({
            // url: "<?php echo base_url(); ?>shipping/excel_stock_container?pete=" + $pete,
            // success: function(response){
            // //location.reload()
            // $("#tbl-pete").html(response);
            // },
            // dataType: "html"
            // });
}




</script>