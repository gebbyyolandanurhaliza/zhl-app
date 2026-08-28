<?php foreach ($CBReport as $cb) {
    $sty = '';
    echo '<tr class="' . $sty . '">';
        echo '<td nowrap>' . $cb->no_reff . '</td>';
        echo '<td nowrap>' . date("d-m-Y",  strtotime($cb->date1)) . '</td>';
        echo '<td nowrap>' . $cb->cashbank_code . '</td>';
        echo '<td nowrap>' . $cb->from_to . '</td>';
        echo '<td nowrap>' . $cb->trans_description . '</td>';
        echo '<td nowrap>' . $cb->currency_id . '</td>';
        echo '<td nowrap>' . $cb->amount . '</td>';
    echo '</tr>';
}
?>