<?php $reff = '';
foreach ($_list as $r) {
    echo '<tr style="cursor: pointer;">';
    if ($reff != $r->mainpo) {
        echo '<td nowrap>' . $r->mainpo . '</td>';
    } else {
        echo '<td></td>';
    }

    echo '<td nowrap>' . $r->id_gr . '</td>';
    echo '<td nowrap>' . $r->docdate . '</td>';
    echo '<td nowrap>' . $r->sono . '</td>';
    echo '<td nowrap>' . $r->invno . '</td>';
    echo '<td nowrap>' . $r->outdate . '</td>';
    echo '<td nowrap hidden>' . $r->vendorcompany . '</td>';
    echo '<td nowrap>' . $r->itemid . '</td>';
    echo '<td nowrap>' . $r->itemname . '</td>';
    echo '<td nowrap>' . $r->uomname . '</td>';
    echo '<td nowrap  class="text-right">' . number_format($r->qtypo, 0, '.', '') . ' <i style="color:white">' .  $r->itemid  .  $r->mainpo . '</i></td>';
    echo '<td nowrap  class="text-right">' . number_format($r->qtywhs, 0, '.', '') . ' <i style="color:white">' .  $r->itemid . $r->id_gr . '</i></td>';

    echo '<td nowrap class="text-right">' . number_format(((($r->tqtywhs - $r->qty_pending_po) == '0') ? ($r->tqtywhs - $r->qty_pending_po) : $r->qty_pending_po), 0, '.', '') . '</td>';
    // echo '<td nowrap class="text-right">' . number_format(((($r->tqtywhs) == '0') ? ($r->qtywhs + $r->tqtywhs) - $r->qtypo : $r->qty_outstanding), 0, '.', '') .  '</td>';
    echo '<td nowrap  class="text-right">' . number_format($r->qty_out, 0, '.', '') . '</td>';
    echo '<td nowrap  class="text-right">' . number_format($r->qty_outstanding_so, 0, '.', '') .  ' <i style="color:white">' .  $r->itemid . $r->id_gr . '</i></td>';
    '</td>';
    echo '<td nowrap>' . $r->custcompany . '</td>';
    echo '<td nowrap>' . $r->whsname . '</td>';
    echo '</tr>';
    $reff = $r->mainpo;
}
