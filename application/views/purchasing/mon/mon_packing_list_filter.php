<?php $sono = '';
foreach ($pl as $r) {
    echo '<tr  onclick="clickdb(this);" style="cursor: pointer;">';
    if ($sono != $r->sono) {
        echo '<td nowrap><a class="btn-sm btn-default" target="_blank" href="' . site_url('purchasing_so/print_report_pl?sono=' . $r->sono) . '"><i class="fa fa-eye"></i></a></td>';
        echo '<td nowrap>' . $r->sono . '</td>';
        echo '<td nowrap>' . date("d-m-Y", strtotime($r->docdate)) . '</td>';
        echo '<td nowrap>' . date("d-m-Y", strtotime($r->duedate)) . '</td>';
        echo '<td nowrap>' . date("d-m-Y", strtotime($r->shipdate)) . '</td>';
        if ($r->status != 1) {
            echo '<td nowrap>Closed</td>';
        } else {
            echo '<td nowrap>Open</td>';
        }
        echo '<td hidden nowrap>' . $r->vendorid . '</td>';
    } else {
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
    echo '<td nowrap class="text-right">' . number_format($r->qty, 2) . '</td>';
    echo '<td nowrap class="text-right">' . number_format($r->neetweight, 2) . '</td>';
    echo '<td nowrap class="text-right">' . number_format($r->grossweight, 2) . '</td>';
    echo '<td hidden nowrap class="text-right">' . number_format($r->unitprice, 2) . '</td>';
    echo '<td hidden nowrap>' . $r->currency . '</td>';
    echo '<td hidden nowrap>' . $r->npbbno . '</td>';
    echo '<td hidden>' . $r->mainpo . '</td>';
    echo '<td hidden>' . $r->vendorid . '</td>';
    echo '<td hidden>' . $r->custid . '</td>';
    echo '<td nowrap>' . $r->custcompany . '</td>';
    echo '</tr>';
    $sono = $r->sono;
}
