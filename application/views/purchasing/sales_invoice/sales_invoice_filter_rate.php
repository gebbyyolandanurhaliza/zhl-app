<?php  
    if(isset($rate)){
        echo '<input name="rate" id="rate_usd" value="'.$rate->rate_usd.'" hidden>';
        echo '<input name="rateSGD" id="rateSGD" value="'.$rate->rate_kurs.'" hidden>';
        echo '* Rate : '.$rate->rate_usd;
    }
    else
    {
    	echo '<input name="rate" id="rate_usd" value="0" hidden>';
        echo '<input name="rateSGD" id="rateSGD" value="0" hidden>';
        echo '* Rate : 0';
    }
?>