

<div class="page-content">
	
	<div class="container-fluid">
		<div class="row ">
			<div class="col-md-12">
				
				<?php //echo $message;?>
				
				<div class="portlet light">
					<div class="portlet-title">
						<div class="caption">
							<i class="fa fa-table theme-font"></i>
							<span class="caption-subject theme-font bold uppercase">List MOQ</span>
						</div>
						<div class="actions">
							<?php 
							if($this->session->userdata('groupid') == 1 || $this->session->userdata('groupid') == 13 || $this->session->userdata('groupid') == 14 ){
								echo anchor(site_url('Moq/add_new'), '<i class="fa fa-plus"></i> Create New MOQ', 'class="btn btn-primary"'); 
							}							
							?>
						</div>
					</div>

					<div class="portlet-body flip-scroll">
						<table class="table table-bordered table-striped" id="mytable">
							<thead>
								<tr>
								<th width="3%">view / edit</th>
								<th width="37%">Product</th>
								<th width="60%">Description</th>
								</tr>
							</thead>
							<tbody>
							<?php 
								if(!empty($_list)){
									foreach ($_list as $r) {

										echo "<tr>";
										?>
										<td><a onclick="window.open('<?=base_url() ?>Moq/detail?product_id=<?=$r->product_id; ?>', 'newwindow', 'width=1200, height=700, top=20, left=120')" class='btn btn-blue fa fa-eye'></a> / 
										<?php 
											if($r->Created_by === $this->session->userdata('userid')){
												?>
													<a href="<?=base_url() ?>Moq/edit?product_id=<?=$r->product_id; ?>" class='btn btn-blue fa fa-pencil'></a>
												<?php
											}
										 ?>
										</td>
										<?php
										echo "<td>$r->product_name ($r->product_id) </td>";
										echo "<td>$r->desc_short</td>";
										echo "</tr>";
									}
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

<div class="modal fade" id="po_v" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog modal-full">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Detail MOQ</h4>
            </div>
            <div class="modal-body">
                <section class="">
                    <div class="contain">
                        <div id="detail_po_id">
                        	
                        </div>
                    </div>
                </section>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn red" data-dismiss="modal">Close</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>


<script type="text/javascript">
	$(document).ready(function () {
		$("#mytable").dataTable();
	});
</script>