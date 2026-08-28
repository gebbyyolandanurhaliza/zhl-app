<?php foreach ($dp as $r){
    echo '<input class="form-control input-sm text-right" name="dp" id="txtdp" value="'.number_format($r->uang_muka,2,'.','').'" onkeyup="calculate()">';
}?>