<?php  
    if(isset($rate)){
        echo '<input name="rate" value="'.$rate->rate_usd.'" hidden>* Rate : '.$rate->rate_usd; 
    }
?>