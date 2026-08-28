<div class="page-content">
	<div class="container-fluid">
    	<div class="row ">
        	<div class="col-md-12">
            	
				<?php echo $message;?>
                
                <div class="portlet light">
                	
                    <div class="portlet-title">
                    	<div class="caption">
                        	<i class="fa fa-table theme-font"></i>
                            <span class="caption-subject theme-font uppercase">Bank Detail</span>
                        </div>
                        <div class="actions">
                        	<?php echo anchor(site_url('marketing/create_master/bank'), '<i class="fa fa-plus"></i> Create New Bank Detail', 'class="btn btn-primary"'); ?>
                        </div>
                    </div>
                    
                    <div class="portlet-body flip-scroll">
                    	<div class="table-scrollable-borderless">
                        	<table id="tblmst_bank" class="table table-bordered table-striped table-condensed">
                            	<thead>
                                	<tr>
                                    	<th scope="col" width="30px" class="text-center">#</th>
                                        <th scope="col" width="50px" class="text-center">Account No</th>
                                        <th scope="col" width="300px" class="text-center">Name</th>
                                        <th scope="col" width="50px" class="text-center">Abbr</th>
                                        <th scope="col" width="50px" class="text-center">City</th>
										<th scope="col" width="100px" class="text-center">Address</th>
										<th scope="col" width="100px" class="text-center">Country</th>
										<th scope="col" width="100px" class="text-center">Swift Code</th>
										<th scope="col" width="100px" class="text-center">Currency</th>
										<th scope="col" class="text-center">Description</th>
										<th scope="col" width="100px" class="text-center">Other Account</th>
										<th scope="col" width="100px" class="text-center">Other Currency</th>
                                        <th scope="col" width="100px" class="text-center">Created By</th>
                                        <th scope="col" width="100px" class="text-center">Created Date</th>
                                        <th scope="col" width="100px" class="text-center">Updated By</th>
                                        <th scope="col" width="100px" class="text-center">Updated Date</th>                                        
                                    </tr>
								</thead>
                                <tbody>
                                	<?php $start = 0;
										  foreach ($master_data as $master) { ?>
									<tr>
										<td style="text-align:center" width="100px">
											<?php
											echo anchor(site_url('marketing/delete_master/bank/'.$master->bank_id),'<i class="fa fa-trash-o"></i>','class="btn default btn-sm red-stripe" onclick="javasciprt: return confirm(\'Are You Sure Delete Data '.$master->bank_name.'?\')"'); 
											echo anchor(site_url('marketing/edit_master/bank/'.$master->bank_id),'<i class="fa fa-edit"></i>', 'class="btn default btn-sm green-stripe"');
											?>
										</td>
										<td class="text-center"><?php echo $master->bank_account_number ?></td>
										<td><?php echo $master->bank_name ?></td>
                                        <td><?php echo $master->bank_abbreviation ?></td>
                                        <td><?php echo $master->bank_city ?></td>
										<td><?php echo $master->bank_address ?></td>
										<td><?php echo $master->bank_country_name ?></td>
										<td><?php echo $master->bank_swift ?></td>
										<td><?php echo $master->bank_currency_name ?></td>
										<td><?php echo $master->bank_description ?></td>
										<td><?php echo $master->bank_account_number_2 ?></td>
										<td><?php echo $master->currency_name_2 ?></td>
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
		$("#tblmst_bank").dataTable({
			"sScrollX": "150%", //This is what made my columns increase in size.
			"bScrollCollapse": true,
//			"sScrollY": "500px",
			"autoWidth"	: false
		});
	});
</script>