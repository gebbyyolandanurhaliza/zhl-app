<?php  
    if(isset($rate)){
       // echo '<input name="rate" value="'.$rate->rate_usd.'" hidden>* Rate : '.$rate->rate_usd; 
    }else{
    	?>
    	<div class="note note-danger note-bordered">
                                <p>
                                <h4>Rate Not Found !!!</h4>
                                <h5>Please, Call Accountants for Entering Rates for <b><?php echo $newdate; ?></b> to <b><?php echo $date; ?></b> </h5>
                                </p>
        </div>
    	<?php 
    }
?>