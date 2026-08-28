<?php
    foreach ($stock as $r){
    echo '<tr>';
        echo '<td style="width: 5px;"><input type="Radio" name="chkk[]" value="'.$r->stock_id_dtl.'"></td>';
        echo '<td>'.$r->stock_id_dtl.'</td>';
        echo '<td>'.$r->container_number.'</td>';
        echo '<td>'.$r->container_name.'</td>';
        echo '<td>'.$r->factory.'</td>';
        echo '<td>'.$r->loading_port.'</td>';
        echo '<td>'.$r->free_time.'</td>';
        echo '<td>'.date("d-m-Y",  strtotime($r->arrival_date)).'</td>';        
        echo '<td>'.$r->Remark.'</td>';
//        echo '<td>'.date("d-m-Y",  strtotime($r->exit_date)).'</td>';
//        echo '<td hidden>'.$r->shipid.'</td>';
//        echo '<td hidden>'.$r->id.'</td>';
    echo '</tr>';
    }
?>