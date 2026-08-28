<?php
if (isset($rate)) {
    echo '<input class="form-control" name="rate" value="' . $rate->rate_kurs . '" onkeypress="return isNumber(event)">';
    // echo '<input name="rate" value="'.$rate->rate_usd.'" hidden>* Rate : '.$rate->rate_usd; 
} else {
}
