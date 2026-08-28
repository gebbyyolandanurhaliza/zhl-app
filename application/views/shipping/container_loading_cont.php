<?php
    foreach ($inward as $r){
    echo '<tr>';echo '<td style="width: 5px;"><input type="checkbox" name="chk[]" ></td>';
        echo '<td>'.date("d-m-Y",  strtotime($r->shipmentdate)).'</td>';
        echo '<td>'.$r->shipping_liner.'</td>';
        echo '<td>'.$r->po_number.'</td>';
        echo '<td>'.$r->container.'</td>';
        echo '<td>'.$r->seal.'</td>';
        echo '<td>'.$r->actual_seal.'</td>';
        echo '<td>'.$r->reff.'</td>';
        echo '<td>'.$r->vessel.'</td>';
        echo '<td>'.$r->pod.'</td>';
        echo '<td>'.$r->destination.'</td>';
        echo '<td hidden>'.$r->contid.'</td>';
        echo '<td>'.$r->opcode.'</td>';
    echo '</tr>';
    }
?>