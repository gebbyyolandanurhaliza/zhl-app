<?php
	if(empty($_tmp)){
		?>
			<div class="form-group">
                <label class="control-label col-md-3">Reff. Number</label>
                <div class="col-md-9">
                    <input type="text" id="refno" name="refno" onchange="ambil_tabel()" value="CN0001/05/16" onkeypress="return valid_enter(event)" class="form-control" required/>
                    <label class="CurID"></label>
                </div>
            </div>
		<?php
	}else
	{
		
		?>
			<div class="form-group">
	            <label class="control-label col-md-3">Reff. Number</label>
	            <div class="col-md-9">
	                <input type="text" id="refno" name="refno" onchange="ambil_tabel()" value="" onkeypress="return valid_enter(event)" class="form-control" required/>
	                <label class="CurID"></label>
	            </div>
	        </div>
		<?php
	}

?>