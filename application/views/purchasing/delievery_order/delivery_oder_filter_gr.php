<?php foreach ($po as $r) {
    echo '<tr>';
    echo '<td style="width: 5px;"><input type="checkbox" name="chk[]" ></td>';
    echo '<td nowrap>' . $r->mainpo . '</td>';
    echo '<td nowrap>' . date("d-m-Y",  strtotime($r->docdate)) . '</td>';
    echo '<td nowrap>' . date("d-m-Y",  strtotime($r->shipdate)) . '</td>';
    echo '<td nowrap>' . $r->itemid . '</td>';
    echo '<td nowrap>' . htmlspecialchars($r->itemname, ENT_QUOTES) . '</td>';
    echo '<td nowrap class="text-right">' . number_format($r->qtypo, 3, '.', '') . '</td>';
    echo '<td hidden>' . $r->docno . '</td>';
    echo '<td nowrap class="text-right">' . number_format($r->qtywhs, 3, '.', '') . '</td>';
    echo '<td hidden>' . number_format(($r->qtywhs - $r->qty_pd), 3, '.', '') . '</td>';
    echo '<td nowrap>' . $r->uomname . '</td>';
    echo '<td nowrap class="text-right">' . number_format($r->unitprice, 4, '.', '') . '</td>';
    echo '<td hidden nowrap>' . $r->npbbno . '</td>';
    echo '<td nowrap>' . $r->vendorcompany . '</td>';
    echo '<td nowrap>' . $r->custcompany . '</td>';
    echo '<td hidden>' . $r->custid . '</td>';
    echo '<td hidden>' . $r->sono . '</td>';
    echo '<td hidden>' . $r->ppbid . '</td>';
    echo '</tr>';
}
