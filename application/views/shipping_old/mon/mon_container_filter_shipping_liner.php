<?php foreach ($shipping_liner as $r){
    echo '<tr  onclick="clickdb(this);" style="cursor: pointer;">';
        echo '<td nowrap name="ship[]">'.date("d/m/Y",  strtotime($r->shipmentdate)).'</td>';
        echo '<td nowrap>'.$r->factory_name.'</td>';
        echo '<td nowrap>'.$r->barge.'</td>';
        echo '<td nowrap>'.$r->to.'</td>';
        echo '<td nowrap>'.$r->from.'</td>';
        echo '<td nowrap>'.$r->po_number.'</td>';
        echo '<td nowrap>'.$r->customer_name.'</td>';
        echo '<td nowrap>'.$r->shipping_liner.'</td>';
        echo '<td nowrap>'.$r->container_name.'</td>';
        echo '<td nowrap>'.$r->port_name.' - '.$r->destination.'</td>';
        echo '<td nowrap>'.$r->reff.'</td>';
        echo '<td nowrap>'.$r->vessel.'</td>';
        echo '<td nowrap>'.$r->depot.'</td>';
        echo '<td nowrap>'.$r->pod.'</td>';
        echo '<td nowrap>'.$r->opcode.'</td>';
        echo '<td nowrap>'.$r->etdsin.'</td>';
        echo '<td nowrap>'.$r->etasin.'</td>';
        echo '<td nowrap>'.$r->container.'</td>';
        echo '<td nowrap>'.$r->seal.'</td>';
        echo '<td nowrap class="text-right">'.number_format($r->weight,2).'</td>';
    echo '</tr>';
}?>