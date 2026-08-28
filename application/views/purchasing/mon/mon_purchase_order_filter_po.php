<?php $mainpo = '';
foreach ($po as $r) {
    echo '<tr  onclick="clickdb(this);" style="cursor: pointer;">';
    if ($mainpo != $r->mainpo) {
        echo '<td nowrap><a class="btn-sm btn-default" target="_blank" href="' . site_url('purchasing_po/purchase_order_print?po=' . $r->mainpo) . '"><i class="fa fa-eye"></i></a></td>';
        echo '<td nowrap>' . $r->mainpo . '</td>';
        echo '<td nowrap>' . date("d-m-Y", strtotime($r->docdate)) . '</td>';
        echo '<td nowrap>' . date("d-m-Y", strtotime($r->deliverdate)) . '</td>';
        echo '<td nowrap>' . date("d-m-Y", strtotime($r->shipdate)) . '</td>';
        if ($r->status != 1) {
            echo '<td nowrap>Close</td>';
        } else {
            echo '<td nowrap>Open</td>';
        }
        echo '<td nowrap>' . $r->vendorid . '</td>';
    } else {
        echo '<td></td>';
        echo '<td></td>';
        echo '<td></td>';
        echo '<td></td>';
        echo '<td></td>';
        echo '<td></td>';
        echo '<td></td>';
    }
    echo '<td nowrap>' . $r->itemid . '</td>';
    echo '<td nowrap>' . htmlspecialchars($r->itemname, ENT_QUOTES) . '</td>';
    echo '<td nowrap>' . $r->uomname . '</td>';
    echo '<td nowrap class="text-right">' . number_format($r->qtypo, 2) . '</td>';
    echo '<td nowrap class="text-right">' . number_format($r->qtywhs, 2) . '</td>';
    echo '<td nowrap class="text-right">' . number_format($r->qty_outstanding, 2) . '</td>';
    echo '<td nowrap class="text-right">' . number_format($r->unitprice, 2) . '</td>';
    echo '<td nowrap>' . $r->currency . '</td>';
    echo '<td nowrap>' . $r->rate . '</td>';
    echo '<td>' . number_format($r->qty_outstanding * $r->unitprice). '</td>';
    echo '<td>' . number_format($r->total * $r->rate). '</td>';
    echo '<td hidden>' . $r->mainpo . '</td>';
    echo '<td hidden>' . $r->vendorid . '</td>';
    echo '<td hidden>' . $r->custid . '</td>';
    echo '<td hidden nowrap>' . $r->custcompany . '</td>';
    echo '</tr>';
    $mainpo = $r->mainpo;
}
