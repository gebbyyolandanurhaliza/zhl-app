<?php $reff = '';
foreach ($gr as $r) {
    // $doStatus = (int)number_format($r->qty_outstanding, 0) > 0 ? "Open" : "Closed";
    $doStatus = $r->status == 1   ? "Open" : "Closed";
    echo '<tr style="cursor: pointer;">';
    if ($reff != $r->mainpo) {
        echo '<td nowrap>' . $r->mainpo . '</td>';
    } else {
        echo '<td></td>';
    }
    echo '<td nowrap>' . date("d-m-Y", strtotime($r->docdate)) . '</td>';
    echo '<td nowrap>' . date("d-m-Y", strtotime($r->duedate)) . '</td>';
    echo '<td nowrap>' . $r->docno . '</td>';
    echo '<td nowrap>' .  $doStatus . '</td>';
    echo '<td nowrap>' . $r->itemid . '</td>';
    echo '<td nowrap>' . htmlspecialchars($r->itemname, ENT_QUOTES) . '</td>';
    echo '<td nowrap>' . $r->uomname . '</td>';
    echo '<td nowrap class="text-right">' . number_format($r->qtypo, 2) . ' <i style="color:white">' .  $r->itemid .  ' <i style="color:white">' .  $r->mainpo . '</i></td>';
    echo '<td nowrap class="text-right">' . number_format($r->qtywhs, 2) . '</td>';
    echo '<td nowrap class="text-right">' . number_format(((($r->tqtywhs - $r->qty_outstanding) == '0') ? ($r->tqtywhs - $r->qty_outstanding) : $r->qty_outstanding), 3, '.', '') . '</td>';
    // echo '<td nowrap class="text-right">' . number_format(((($r->tqtywhs) > '0') ? ($r->tqtywhs - $r->qtywhs) : $r->qty_outstanding), 0, '.', '') .  '</td>';
    echo '<td  nowrap >' . $r->vendorcompany . '</td>';
    echo '<td  nowrap >' . $r->whsname . '</td>';
    echo '</tr>';
    $reff = $r->mainpo;
}
