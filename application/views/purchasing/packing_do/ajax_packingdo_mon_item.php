<?php $reff = '';
foreach ($_list as $r) {
    echo '<tr style="cursor: pointer;">';
    echo '<td nowrap>' . $r->whsname . '</td>';
    echo '<td nowrap>' . $r->itemid . '</td>';
    echo '<td nowrap>' . $r->itemname . '</td>';
    echo '<td nowrap>' . $r->uom . '</td>';
    //  echo '<td nowrap  class="text-center">' . number_format($r->qtywhs, 0, '.', '')  . '</i></td>';
    echo '<td nowrap  class="text-center">' . number_format($r->qty, 0, '.', '') . '</td>';


    echo '</tr>';
    // $reff = $r->mainpo;
}
