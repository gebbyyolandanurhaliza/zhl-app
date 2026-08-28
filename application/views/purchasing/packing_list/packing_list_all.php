<?php foreach ($so as $r) {
    $sty = '';
    if ($r->status == 2) {
        $sty = 'success';
    }
    echo '<tr class="' . $sty . '">';
    echo '<td nowrap>';
    echo '<a class="btn-sm btn-warning" title="Edit" href="' . site_url('purchasing_pl/show_pl?pl=' . $r->sono) . '"><i class="fa fa-pencil"></i></a>'; ?>
    <a data-toggle="modal" title="Delete" data-target="#modal_delete" class="btn-sm btn-danger" onclick="modal_delete('<?php echo $r->sono; ?>')"><i class="fa fa-trash"></i></a>
<?php
    echo '<a type="button" title="Print" class="btn-sm btn-info" href="' . site_url('purchasing_pl/print_report_pl?pl=' . $r->sono) . '" target="_blank"><i class="fa fa-print"></i></a>';
    echo '<a type="button" title="Print" class="btn-sm btn-success" href="' . site_url('purchasing_pl/print_report_do?pl=' . $r->sono) . '" target="_blank"><i class="fa fa-print"></i></a>';
    echo '</td>';
    echo '<td nowrap>' . $r->sono . '</td>';
    echo '<td nowrap>' . date("d-m-Y",  strtotime($r->docdate)) . '</td>';
    echo '<td nowrap>' . date("d-m-Y",  strtotime($r->shipdate)) . '</td>';
    if ($r->status != 1) {
        echo '<td nowrap>Close</td>';
    } else {
        echo '<td nowrap>Open</td>';
    }
    echo '<td nowrap>' . $r->custcompany . '</td>';
    echo '<td nowrap>' . $r->custcontact . '</td>';
    echo '<td>' . $r->mainpo . '</td>';
    echo '<td nowrap>' . number_format($r->totaldue, 2) . '</td>';
    echo '<td nowrap>' . $r->currency . '</td>';
    echo '<td nowrap>' . $r->createdby . '</td>';
    echo '<td nowrap>' . $r->createddate . '</td>';
    echo '<td nowrap>' . $r->updatedby . '</td>';
    echo '<td nowrap>' . $r->updateddate . '</td>';
    echo '</tr>';
}
?>