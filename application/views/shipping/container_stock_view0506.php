<script>
    function hitungSelisihHari2() {
        var tgl2 = document.getElementById('free_time').value;
        var tgl3 = document.getElementById('free_time_expiry');
        var str = document.getElementById('arrival_date').value;
        //ganti tanggal
        var tanggal = str.split("/");
        var tgl = tanggal[0];
        var bln = tanggal[1];
        var thn = tanggal[2];
        var tt = bln + "/" + tgl + "/" + thn;
        var date = new Date(tt);
        var newdate = new Date(date);
        newdate.setDate(newdate.getDate() + Number(tgl2));
        var dd = newdate.getDate();
        var mm = newdate.getMonth() + 1;
        var y = newdate.getFullYear();
        var someFormattedDate = dd + '/' + mm + '/' + y;
        tgl3.value = someFormattedDate;
    }	
</script>

<div class="page-content">
	
	<div class="container-fluid">
		<div class="row ">
			<div class="col-md-12">
				
				<div class="portlet light">
					
					<div class="portlet-title">
						<div class="caption">
							<i class="fa fa-cogs theme-font"></i>
							<span class="caption-subject theme-font bold uppercase"><?php //echo $header_title;?></span>
						</div>
						<div class="tools">
							<a href="javascript:;" class="collapse"></a>								
						</div>
					</div>
					
					<div class="portlet-body form">
						<form action="<?php echo site_url('shipping/container_stock_save'); ?>" method="post" class="form-horizontal" role="form">
							<div class="form-body">
								<div class="form-group">
									<label class="col-md-3 control-label" for="varchar">Container Number</label>
									<div class="col-md-5">
										<input type="text" class="form-control" name="container_number" id="container_number" placeholder="Container Number" value="" />
										<input type="hidden" class="form-control" name="stock_id" id="stock_id" placeholder="Container Number" value="" required />
									</div>
									<span class="help-inline"></span>
								</div>
								<div class="form-group">
									<label class="col-md-3 control-label" for="varchar">Container Type</label>
									<div class="col-md-5">
										<select class="form-control select2me" name="container_id" id="container_id">
											<?php foreach($gettype as $get):?>
											      <option value="<?php echo $get->container_id;?>"><?php echo $get->container_name;?></option>
											<?php endforeach;?>
										</select>
									</div>
									<span class="help-inline"><span class="help-inline"></span>
								</div>
								<div class="form-group">
									<label class="col-md-3 control-label" for="int">Loading Port</label>
									<div class="col-md-5">
										<input type="text" class="form-control" name="loading_port" id="loading_port" placeholder="Loading Port" value="" />
									</div>
									<span class="help-inline"></span>
								</div>								
								<div class="form-group">
									<label class="col-md-3 control-label" for="int">Arrival Date</label>
									<div class="col-md-5">
	                                <input type="text" name="arrival_date" class="form-control date date-picker" value="" data-date-format="dd/mm/yyyy" id="arrival_date"  placeholder="Arrival Date" required/>
									</div>
									<span class="help-inline"></span>
								</div>								
								<div class="form-group">
									<label class="col-md-3 control-label" for="int">Free Time</label>
									<div class="col-md-5">
                                <input type="text" name="free_time" id="free_time" value="" placeholder="Free Time" class="form-control autonumber" onfocus="this.value = '';" onkeyup="hitungSelisihHari2()" onkeypress="return isNumber(event)" required/>
									</div>
									<span class="help-inline"></span>
								</div>								
								<div class="form-group">
									<label class="col-md-3 control-label" for="int">Remark</label>
									<div class="col-md-5">
										<input type="text" class="form-control" name="Remark" id="Remark" placeholder="Remark" value="" />
									</div>
									<span class="help-inline"></span>
								</div>								
								<div class="form-group">
									<label class="col-md-3 control-label" for="int">Factory</label>
									<div class="col-md-5">
										<!-- <input type="text" class="form-control" name="factory" id="factory" placeholder="Factory" value="" /> -->
										<SELECT name="factory" class="form-control">
											<OPTION ></OPTION>
											<OPTION value="RSUP">Riau Sakti United Plantations</OPTION>
											<OPTION value="PSG">Pulau Sambu Guntung</OPTION>
										</SELECT>
									</div>
									<span class="help-inline"></span>
								</div>
								<div class="form-group">
									<label class="col-md-3 control-label" for="int">Supplier</label>
									<div class="col-md-5">
										<input type="text" class="form-control" name="supplier" id="supplier" placeholder="Supplier" value="" />
									</div>
									<span class="help-inline"></span>
								</div>								
								<div class="form-group">
									<label class="col-md-3 control-label" for="int">Import BL No</label>
									<div class="col-md-5">
										<input type="text" class="form-control" name="import_bl_no" id="Remark" placeholder="BL NO" value="" />
									</div>
									<span class="help-inline"></span>
								</div>								
								<div class="form-group">
									<label class="col-md-3 control-label" for="int">Estimation Date Arrival</label>
									<div class="col-md-5">
	                                <input type="text" name="eta" class="form-control date date-picker" value="" data-date-format="dd/mm/yyyy" placeholder="Estimation Date Arrival" required/>
									</div>
									<span class="help-inline"></span>
								</div>								
								<div class="form-group">
									<label class="col-md-3 control-label" for="int">Free Time Expiry Date</label>
									<div class="col-md-5">
	                                <input type="text" name="free_time_expiry" class="form-control" value="" id="free_time_expiry" placeholder="Free Time Expiry" readonly="" required />
									</div>
									<span class="help-inline"></span>
								</div>

							</div>
							


							<div class="form-actions">
								<div class="row">
									<div class="col-md-offset-3 col-md-9">
										<button type="submit" class="btn btn-primary">Save</button> 
										<button type="reset" class="btn btn-primary">Cancel</button>
									</div>
								</div>
							</div>
						</form>
					</div>
					
				</div>
				
			</div>
		</div>
	</div>
	
</div>