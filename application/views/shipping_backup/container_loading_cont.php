<?php
    foreach ($inward as $r){
    echo '<tr>';echo '<td style="width: 5px;"><input type="checkbox" name="chk[]" ></td>';
        echo '<td>'.date("d-m-Y",  strtotime($r->shipmentdate)).'</td>';
        echo '<td>'.$r->po_number.'</td>';
        echo '<td>'.$r->container.'</td>';
        echo '<td>'.$r->reff.'</td>';
        echo '<td>'.$r->vessel.'</td>';
        echo '<td>'.$r->port_name.'</td>';
        echo '<td>'.$r->destination.'</td>';
        echo '<td hidden>'.$r->contid.'</td>';
    echo '</tr>';
    }
?>