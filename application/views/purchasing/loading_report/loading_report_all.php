<?php foreach ($lr as $r) {
    echo '<tr >';
    echo '<td nowrap>';
    echo '<a class="btn-sm btn-warning" title="Edit" href="' . site_url('purchasing_lr/loading_report_show?lr=' . $r->lrno) . '"><i class="fa fa-pencil"></i></a>'; ?>
    <a data-toggle="modal" title="Delete" data-target="#modal_delete" class="btn-sm btn-danger" onclick="modal_delete('<?php echo $r->lrno; ?>')"><i class="fa fa-trash"></i></a>
<?php
    echo '<a type="button" title="Print" class="btn-sm btn-info" href="' . site_url('purchasing_lr/print_report_lr?lr=' . $r->lrno) . '" target="_blank"><i class="fa fa-print"></i></a>';
    echo '</td>';
    echo '<td nowrap>' . $r->lrno . '</td>';
    echo '<td nowrap>' . date("d-m-Y",  strtotime($r->docdate)) . '</td>';
    echo '<td nowrap>' . date("d-m-Y",  strtotime($r->shipdate)) . '</td>';
    echo '<td nowrap>' . $r->customercompany . '</td>';
    echo '<td nowrap>' . $r->contactperson . '</td>';
    echo '<td nowrap>' . $r->createdby . '</td>';
    echo '<td nowrap>' . $r->createddate . '</td>';
    echo '<td nowrap>' . $r->lastupdatedby . '</td>';
    echo '<td nowrap>' . $r->lastupdateddate . '</td>';
    echo '</tr>';
}
?>