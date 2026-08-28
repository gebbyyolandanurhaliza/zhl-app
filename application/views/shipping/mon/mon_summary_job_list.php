<?php foreach ($summary_job as $r){
    echo '<tr  onclick="clickdb(this);" style="cursor: pointer;">';
        echo '<td nowrap name="current_date[]">'.date("d/m/Y",  strtotime($r->curr_date)).'</td>';
        echo '<td nowrap>'.$r->vehicle_no.'</td>';
        echo '<td nowrap>'.$r->driver_name.'</td>';
        echo '<td nowrap>'.$r->job.'</td>';
        echo '<td nowrap>'.$r->customer_name.'</td>';
        echo '<td nowrap>'.$r->time.'</td>';
        echo '<td nowrap>'.$r->status.'</td>';
        echo '<td nowrap>'.$r->send_to.'</td>';
        echo '<td nowrap>'.$r->chasis.'</td>';   
        echo '<td nowrap>'.$r->amount.'</td>';     
    echo '</tr>';
}?>