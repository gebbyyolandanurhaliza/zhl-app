<?php
foreach ($loading as $r) {
    echo '<tr>';
    echo '<td nowrap>';
    echo '<a class="btn-sm btn-warning" title="Edit" href="' . site_url('shipping/receipt_container/' . $r->trans_id) . '"><i class="fa fa-pencil"></i></a>'; ?>
    <a data-toggle="modal" title="Delete" data-target="#modal_delete" class="btn-sm btn-danger" onclick="modal_delete('<?php echo $r->trans_id; ?>')"><i class="fa fa-trash"></i></a>
    <a class="btn-sm btn-success" title="Excel" href="<?php echo site_url('shipping/container_loading_excel?id=' . $r->trans_id); ?>"><i class="fa fa-file-excel-o"></i></a>
<?php
    echo '<a class="btn-sm btn-info" title="Print" href="' . site_url('shipping/container_loading_print?id=' . $r->trans_id) . '" target="_blank"><i class="fa fa-print"></i></a>';
    echo '</td>';
    echo '<td>' . date("d-m-Y",  strtotime($r->trans_date)) . '</td>';
    echo '<td>' . $r->vessel . '</td>';
    echo '<td>' . $r->voyage . '</td>';
    echo '<td>' . $r->etd . '</td>';
    echo '<td>' . $r->eta . '</td>';
    echo '<td>' . $r->trans_type . '</td>';
    echo '<td>' . $r->remarks . '</td>';
    echo '<td>' . $r->created_at . '</td>';
    echo '<td>' . $r->created_date . '</td>';
    echo '<td>' . $r->updated_at . '</td>';
    echo '<td>' . $r->updated_date . '</td>';
    echo '</tr>';
}
?>