<div class="page-content">
	<div class="container-fluid">
    	<div class="row ">
        	<div class="col-md-12">
            	
				<?php echo $message;?>
                
                <div class="portlet light">
                	<div class="portlet-title">
                    	<div class="caption">
                        	<i class="fa fa-table theme-font"></i>
                            <span class="caption-subject theme-font uppercase">Packing Size</span>
                        </div>
                        <div class="actions">
                        	<?php echo anchor(site_url('marketing/create_master/packing-size'), '<i class="fa fa-plus"></i> Create New Packing Size', 'class="btn btn-primary"'); ?>
                        </div>
                    </div>
                    
                    <div class="portlet-body flip-scroll">
                    	<div class="table-scrollable-borderless">
                        	<table id="tblmst_packing_size" class="table table-bordered table-striped table-condensed">
                            	<thead>
                                	<tr>
                                    	<th scope="col" width="30px" class="text-center">#</th>
                                        <th scope="col" width="50px" class="text-center">ID</th>
                                        <th scope="col" width="450px" class="text-center">Name</th>
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
										<td style="text-align:center" width="100px">
											<?php
											echo anchor(site_url('marketing/delete_master/packing-size/'.$master->packing_size_id),'<i class="fa fa-trash-o"></i>','class="btn default btn-sm red-stripe" onclick="javasciprt: return confirm(\'Are You Sure Delete Data '.$master->packing_size_name.'?\')"'); 
											echo anchor(site_url('marketing/edit_master/packing-size/'.$master->packing_size_id),'<i class="fa fa-edit"></i>', 'class="btn default btn-sm green-stripe"');
											?>
										</td>
										<td class="text-center"><?php echo $master->packing_size_id ?></td>
										<td><?php echo $master->packing_size_name ?></td>
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

<script type="text/javascript">
	$(document).ready(function () {
		$("#tblmst_packing_size").dataTable({
			"sScrollX": "100%", //This is what made my columns increase in size.
			"bScrollCollapse": true,
//			"sScrollY": "500px",
			"autoWidth"	: false
		});
	});
</script>