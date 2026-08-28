
<div class="page-content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				
				<?php echo $message ?>
				
				<div class="portlet light">
					
					<div class="portlet-title">
						<div class="caption">
							<i class="fa fa-table theme-font"></i>
							<span class="caption-subject theme-font uppercase">PROFORMA INVOICE</span>
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
						<?php 
						echo form_open($action, 'class="form-horizontal" method="post"');
						?>
						
						<div class="form-body row">
							<div class="col-md-12">
								
								<div class="form-group">
									<label class="col-md-2 control-label" for="varchar">Sales Contract Number</label>
									<div class="col-md-6">
										<!--<input type="text" class="form-control" name="contract_no" id="contract_no" value="<?php echo $contract_no ?>" placeholder="Search Sales Contract" title="Leave blank to show all the data" />-->
										
										<?php 
											$extra_sc = 'id= "contract_hdr_id" class="form-control select2me" data-placeholder=" " ';
											$option_sc[''] = '';
											foreach($cbo_sc as $r):
												$option_sc[$r->contract_hdr_id] = $r->contract_no.' - '.$r->customer_name;
											endforeach;
											echo form_dropdown('contract_hdr_id', $option_sc, $contract_hdr_id, $extra_sc);
										?>
									</div>
									
									<button class="btn btn-primary" type="submit">Create New Proforma Invoice</button>
									
								</div>
								
							</div>
						</div>
						
						<?php
						echo form_close();
						?>
					</div>
					
					<div class="form-actions">
						
					</div>
					
				</div>
				
			</div>
		</div>
	</div>
</div>