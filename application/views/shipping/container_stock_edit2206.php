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

    function fnDialogStock() {
        // Define the Dialog and its properties.
        $("#formdialogStock").dialog({
            resizable: false,
            modal: true,
            title: "List Stock Container",
            height: 570,
            width: 800

        });
        filterpodtl(); 
    }

    function close_Container(){
        $("#formdialogStock").dialog("close");
    }

    function filterContainer(){
            filterpodtl(); 
    }
    
    function filterpodtl(){
        $container_name = document.getElementById("container_name").value;
           
        $.ajax({
            url: "<?php echo base_url(); ?>shipping/container_stock_modal?container_name=" + $container_name + "",
            success: function (response) {
                $("#tblpo").html(response);
            },
            dataType: "html"
        });

        return false;
    }

    function cek_contid(ele){
        var checkboxes = document.getElementsByTagName('input');
        var container_id = ele.value;
        if (ele.checked) {
            for (var i = 0; i < checkboxes.length; i++) {
                if (checkboxes[i].type == 'checkbox') {
                    if(container_id == checkboxes[i].value ){
                        checkboxes[i].checked = true;
                    }
                }
            }
        } else {
            for (var i = 0; i < checkboxes.length; i++) {
                if (checkboxes[i].type == 'checkbox') {
                    if(container_id == checkboxes[i].value ){
                        checkboxes[i].checked = false;
                    }
                }
            }
        }
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
		               <div id="formdialogStock" hidden>
		                    <div class="portlet-body">
		                            <div class="col-md-12">
		                            </div>
		                            <div class="col-md-12">
		                                <div class="form-group">
		                                     <label class="col-md-2 label-sm">Container</label>
		                                     <div class="col-md-7">
		                                     <input class="form-control input-sm" id="container_name">
		                                     </div>
		                                  	 <button type="button" class="col-md-2 btn blue" onchange="filterContainer()" ="filterContainer()">Search</button>

		                                </div>
		                            </div>
		                            <br><hr>
		                            <div class="table-scrollable" style="overflow: auto; height:300px;">
		                                <table id="tbl-po" class="table table-bordered">
		                                    <thead>
		                                        <tr>
		                                            <th width="5px"><input type="checkbox" onchange="check(this)"></th>
		                                            <th>No</th>
		                                            <th>Container Name</th>
		                                            <th>Container Size</th>
		                                            <th>Container Abbr</th>
		                                        </tr>
		                                    </thead>
		                                    <tbody id="tblpo"></tbody>
		                                </table>
		                            </div>
		                            <div class="col-md-6">
		                                <button type="button" class="col-md-3 btn blue" onclick="choose_Container()" id="choose">Choose</button>
		                                <button type="button" class="col-md-3 btn grey" onclick="close_Container()">Close</button>
		                            </div>
		                    </div>
		                </div>
					<div class="portlet-body form">
						<form action="<?php echo site_url('shipping/container_stock_save'); ?>" method="post" class="form-horizontal" role="form">
							<?php foreach($tampildatahdr as $set):?>
							<div class="form-body">
									<div class="form-group">
									<label class="col-md-3 control-label" for="int">Loading Port</label>
									<div class="col-md-5">
										<input type="text" class="form-control" name="loading_port" id="loading_port" placeholder="Loading Port" value="<?php echo $set->loading_port?>" />
									</div>
									<span class="help-inline"></span>
								</div>								
								<div class="form-group">
									<label class="col-md-3 control-label" for="date">Arrival Date</label>
									<div class="col-md-5">
                                <?php 
                                    // set tanggal
                                    $tgl_arival = new DateTime($set->arrival_date);
                                    $tgl_arv = date_format($tgl_arival, 'd/m/Y');
                                ?>
                                <input type="text" name="arrival_date" class="form-control date date-picker" value="<?php echo $tgl_arv; ?>" id="arrival_date" data-date-format="dd/mm/yyyy" placeholder="Arrival Date" required/>
									</div>
									<span class="help-inline"></span>
								</div>								
								<div class="form-group">
									<label class="col-md-3 control-label" for="int">Free Time</label>
									<div class="col-md-5">
                                <input type="text" class="form-control" id="free_time" name="free_time" id="free_time" value="<?php echo $set->free_time?>" placeholder="Free Time" class="form-control autonumber" onfocus="this.value = '';" onkeyup="hitungSelisihHari2()" onkeypress="return isNumber(event)" required/>
									</div>
									<span class="help-inline"></span>
								</div>								
								<div class="form-group">
									<label class="col-md-3 control-label" for="int">Remark</label>
									<div class="col-md-5">
										<input type="text" class="form-control" name="Remark" id="Remark" placeholder="Remark" value="<?php echo $set->Remark?>" />
									</div>
									<span class="help-inline"></span>
								</div>								
								<div class="form-group">
									<label class="col-md-3 control-label" for="int">Factory</label>
									<div class="col-md-5">
										<SELECT name="factory" class="form-control" value="<?php echo $set->factory; ?>">
										<option><?php echo $set->factory; ?></option>
										<OPTION value="RSUP">Riau Sakti United Plantations</OPTION>
										<OPTION value="PSG">Pulau Sambu Guntung</OPTION>
										</SELECT>
									</div>
									<span class="help-inline"></span>
								</div>
								<div class="form-group">
									<label class="col-md-3 control-label" for="int">Supplier</label>
									<div class="col-md-5">
										<input type="text" class="form-control" name="supplier" id="supplier" placeholder="Supplier" value="<?php echo $set->supplier; ?>" />
									</div>
									<span class="help-inline"></span>
								</div>								
								<div class="form-group">
									<label class="col-md-3 control-label" for="int">Import BL No</label>
									<div class="col-md-5">
										<input type="text" class="form-control" name="import_bl_no" id="Remark" placeholder="BL NO" value="<?php echo $set->import_bl_no; ?>" />
									</div>
									<span class="help-inline"></span>
								</div>								
								<div class="form-group">
									<label class="col-md-3 control-label" for="date">Estimation Date Arrival</label>
									<div class="col-md-5">
                                    <?php 
                                        // set tanggal disini
                                        $eta = new DateTime($set->eta);
                                        $tgl_eta = date_format($eta, 'd/m/Y');
                                    ?>
	                                <input type="text" name="eta" class="form-control date date-picker" value="<?php echo $tgl_eta; ?>" data-date-format="dd/mm/yyyy" required/>
									</div>
									<span class="help-inline"></span>
								</div>								
								<div class="form-group">
									<label class="col-md-3 control-label" for="date">Free Time Expiry Date</label>
									<div class="col-md-5">
                                    <?php 
                                        $ftr = new DateTime($set->free_time_expiry);
                                        $tfr = date_format($ftr, 'd/m/Y');
                                    ?>
	                                <input type="text" name="free_time_expiry" class="form-control" value="<?php echo $tfr; ?>" id="free_time_expiry" readonly="" required/>
									</div>
									<span class="help-inline"></span>
								</div>
								  <div class="table-scrollable">
                                    <table class="table table-bordered" id ="tblList">
                                        <thead>
                                            <tr>
                                                <th width="10px">
						                            <a class="btn green" data-toggle="modal" onclick="fnDialogStock()">
						                            <i class="fa fa-plus"></i> <!-- Search Container --></a></th>
                                                <th nowrap>Container Type</th>
                                                <th nowrap class="hidden">Container ID</th>
                                                <th nowrap>Container Number</th>
                                            </tr>
                                        </thead>
                                        <div id="modal_delete" class="modal fade bs-modal-lg" role="dialog" tabindex="-1" data-backdrop="static" data-keyboard="false" aria-hidden="true"></div>
                                        <tbody id="tblList_1">
										<input type="hidden" class="form-control" name="stock_id_hdr" id="stock_id_hdr" value="<?php echo $set->stock_id_hdr?>" />
										   <?php foreach ($tampildatadtl as $r){?>
                                                <tr onclick="deleterow(this)">
                                                    <td align="center">
                                                    <button class="btn btn-sm btn-danger" type="button" ><i class="fa fa-trash" ></i></button>
                                                    </td>
                                                    <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="" name="container_name[]" value="<?php echo $r->container_name; ?>" readonly="">										
                                                    
                                                    <input type="hidden" class="form-control" name="stock_id_dtl[]" id="stock_id_dtl" value="<?php echo $r->stock_id_dtl; ?>" />
                                                    <input type="hidden" class="form-control" name="container_id[]" id="container_id" value="<?php echo $r->container_id; ?>" />
                                                    
                                                    </td>
                                                    <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="" name="container_number[]" value="<?php echo $r->container_number; ?>">
                                                    </td>
                                                </tr>
                                           <?php } ?>
                                        </tbody>
                                    </table>
                                </div>

							<div class="form-actions">
								<div class="row">
									<div class="col-md-offset-10 col-md-12">
										<button type="submit" class="btn btn-primary">Save</button> 
										<button type="reset" class="btn btn-primary">Cancel</button>
									</div>
								</div>
							</div>
							<?php endforeach;?>
						</form>
					</div>
					
				</div>
				
			</div>
		</div>
	</div>
	
</div>

<script>
    function choose_Container(){
        function getText(el){
            if (typeof el.textContent == 'string') return el.textContent;
            if (typeof el.innerText == 'string') return el.innerText;
        }

        var chk_arr = document.getElementsByName("chk[]");
        
        var chk_length = chk_arr.length;
        i = 1;

        for (k = 0; k < chk_length; k++)
        {
            if (chk_arr[k].checked == true){
                var $new_row = $('<tr onclick="deleterow(this)">\n\
                                    <td align="center"><button class="btn btn-sm btn-danger" type="button" ><i class="fa fa-trash" ></i></button></td>\n\
                                        <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" name="container_name[]" value="' + getText(document.getElementById("tbl-po").rows[i].cells[2]) + '" readonly><input type="hidden" class="form-control input-sm" name="container_id[]" value="' + getText(document.getElementById("tbl-po").rows[i].cells[1]) + '"></td>\n\
                                        <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" name="container_number[]" value=""></td>\n\
                                        <td hidden></td>\n\
                                        <td hidden></td>\n\
                                        <td hidden></td>\n\
                                </tr>');
                                            
//                $new_row.find('.date').datepicker();
                
                $('table[id="tblList"]').append($new_row);
                }
            i++;
        }

        $("#formdialogStock").dialog("close");
        cekDtl();
    }

    function cekDtl(){
        var ID_arr = document.getElementsByName("container_id[]");
        var ID_length = ID_arr.length;
        
        if ((ID_length > 0)){
            $('#btn-save').attr('disabled', false);
        } else {
            $('#btn-save').attr('disabled', true);
        }
    }

    function deleterow(x){
        $r=x.rowIndex;

        <?php foreach ($tampildatadtl as $key){
        $stock_id_dtl = $key->stock_id_dtl;
        } ?>

        
        if (confirm("Are you sure remove this row?") == true) {
             document.getElementById("tblList").deleteRow($r);
             cekDtl();
        }


        $.ajax({
            url: "<?php echo site_url('shipping/container_stock_delete_modal?stock='.$stock_id_dtl); ?>",
            success: function (response) {
                $("#modal_delete").html(response);
            },
            dataType: "html"
        });

    }


</script>