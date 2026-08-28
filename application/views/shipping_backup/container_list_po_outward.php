<?php
    foreach ($po as $r){
    echo '<tr>';
        echo '<td style="width: 5px;"><input type="checkbox" name="chk[]" ></td>';
        echo '<td>'.$r->po_number.'</td>';
        echo '<td>'.$r->shipping_liner.'</td>';
        echo '<td>'.$r->container_name.'</td>';
        echo '<td>'.$r->port_name.' - '.$r->destination.'</td>';
        echo '<td>'.$r->reff.'</td>';
        echo '<td>'.$r->vessel.'</td>';
        echo '<td>'.$r->convessel.'</td>';
        echo '<td>'.$r->depot.'</td>';
        echo '<td>'.$r->pod.'</td>';
        echo '<td>'.$r->opcode.'</td>';
        echo '<td>'.date("d-m-Y",  strtotime($r->etddate)).'</td>';
        echo '<td>'.date("d-m-Y",  strtotime($r->etadate)).'</td>';
        echo '<td hidden>'.$r->shipid.'</td>';
        echo '<td hidden>'.$r->id.'</td>';
    echo '</tr>';
    }
?>