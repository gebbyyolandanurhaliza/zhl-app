<?php
    foreach ($po_ggfs as $r){
    echo '<tr>';echo '<td style="width: 5px;"><input type="checkbox" name="chk_ggfs[]" onclick="cek_shipid(this)" value="'.$r->ship_id.'"></td>';
        echo '<td>'.date("d-m-Y",  strtotime($r->schedule_date)).'</td>';
        echo '<td>'.$r->po_number.'</td>';
        echo '<td>'.$r->factory_abbr.'</td>';
        echo '<td>'.$r->shipping_name.'</td>';
        echo '<td>'.$r->container_name.'</td>';
        echo '<td>'.$r->port_name.' - '.$r->destination.'</td>';
        echo '<td hidden>'.$r->ship_id.'</td>';
    echo '</tr>';
    }
?>