<?php
foreach ($npbb as $r) {
    if ($cek != 'true') {
        echo '<tr>';
        echo '<td style="width: 5px;"><input type="checkbox" name="chk[]" ></td>';
        echo '<td nowrap>' . $r->npbbno . '</td>';
        echo '<td nowrap>' . date("d-m-Y",  strtotime($r->transdate)) . '</td>';
        echo '<td nowrap>' . $r->itemid . '</td>';
        echo '<td nowrap>' . htmlspecialchars($r->itemname, ENT_QUOTES) . '</td>';
        echo '<td hidden>' . $r->pmcode . '</td>';
        echo '<td nowrap class="text-right">' . number_format($r->qnty, 2, '.', '') . '</td>';
        echo '<td nowrap class="text-right">' . number_format($r->qnty, 2, '.', '') . '</td>';
        echo '<td nowrap>' . $r->uomname . '</td>';
        echo '<td nowrap class="text-right">' . number_format($r->unitprice, 2, '.', '') . '</td>';
        echo '<td nowrap>' . $r->companyfullname . '</td>';
        echo '<td hidden>' . $r->companyid . '</td>';
        echo '<td hidden>' . $r->per1000 . '</td>';
        echo '<td hidden>' . $r->hscode . '</td>';
        echo '<td hidden>' . $r->country_id . '</td>';
        echo '<td hidden>' . $r->country_name . '</td>';
        echo '</tr>';
    } else {
        echo '<tr>';
        echo '<td style="width: 5px;"><input type="checkbox" name="chk[]" ></td>';
        echo '<td hidden></td>';
        echo '<td hidden></td>';
        echo '<td nowrap>' . $r->itemid . '</td>';
        echo '<td nowrap>' . htmlspecialchars($r->itemname, ENT_QUOTES) . '</td>';
        echo '<td hidden>' . $r->pmcode . '</td>';
        echo '<td hidden></td>';
        echo '<td hidden></td>';
        echo '<td nowrap>' . $r->uomname . '</td>';
        echo '<td nowrap class="text-right">' . number_format($r->unitprice, 2, '.', '') . '</td>';
        echo '<td hidden></td>';
        echo '<td hidden>0</td>';
        echo '<td hidden>' . $r->per1000 . '</td>';
        echo '<td hidden>' . $r->hscode . '</td>';
        echo '<td hidden>' . $r->country_id . '</td>';
        echo '<td hidden>' . $r->country_name . '</td>';
        echo '</tr>';
    }
}
