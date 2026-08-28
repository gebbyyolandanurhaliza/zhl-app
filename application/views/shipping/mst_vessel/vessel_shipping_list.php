<div class="page-content">

	<div class="container-fluid">
		<div class="row ">
			<div class="col-md-12">
    
                <?php echo $message;?>
				<div class="portlet light">
					<div class="portlet-title">
						<div class="caption">
							<i class="fa fa-table theme-font"></i>
							<span class="caption-subject theme-font uppercase">Master Vessel</span>
						</div>
						<div class="actions">
							<?php echo anchor(site_url('Master_vessel_shipping/add'), '<i class="fa fa-plus"></i> Create Vessel', 'class="btn btn-primary"'); ?>
						</div>
					</div>

					<div class="portlet-body flip-scroll">
						<div class="table-scrollable-borderless">
							<table id="tblmst_vessel" class="table table-bordered table-striped table-condensed" >
							    <thead>
                                    <tr>
                                        <th nowrap>No</th>
                                        <th nowrap>Vessel Name</th>
										<th nowrap>Created By</th>
                                        <th nowrap>Created Date</th>
                                        <th nowrap>Updated By</th>
										<th nowrap>Updated Date</th>
										<th nowrap width="100px">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                
                                <?php 
                                    $no = 1;
                                    foreach ($vessel as $dt_vessel){
                                ?>
                                    <tr>
                                        <td style="text-align: center;"><?= $no ?></td>
                                        <td><?= $dt_vessel->vessel_name ?></td>
                                        <td><?= $dt_vessel->created_at ?></td>
                                        <td><?= $dt_vessel->created_by ?></td>
                                        <td><?= $dt_vessel->updated_at ?></td>
                                        <td><?= $dt_vessel->updated_by ?></td>
                                        <td class=" text-center"><a href="Master_vessel_shipping/edit/<?= $dt_vessel->vessel_id ?>" class="btn btn-xs btn-warning"><span class="fa fa-fw fa-pencil-square-o"></span></a> <a href="Master_vessel_shipping/delete/<?= $dt_vessel->vessel_id ?>" onclick="javasciprt: return confirm('Are You Sure want to delete <?= $dt_vessel->vessel_name ?>?')" class="btn btn-xs btn-danger"><span class="fa fa-fw fa-trash-o"></span></a></td>
                                    </tr>
                                <?php 
                                    $no++;
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
</div>

<script type="text/javascript">
    $(document).ready(function(){
        var t = $("#tblmst_vessel").dataTable({
            initComplete : function(){
                var api = this.api();
                $('#tblmst_vessel input')
                    .off('.DT')
                    .on('keyup.DT', function(e){
                        api.search(this.value).draw();
                });
            },
            oLanguage:{
                sProcessing: "loading..."
            },
            processing : true,
            serverside : true,
        });
    });
</script>