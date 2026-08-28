<?php foreach ($so as $r) {
    $sty = '';
    $disable = '';
    if ($r->status == 2) {
        $sty = 'success';
        $disable = 'disabled';
    } else {
        $disable = '';
    }
    echo '<tr class="' . $sty . '">';
    echo '<td nowrap>';
    echo '<a class="btn-sm btn-warning" title="Edit" href="' . site_url('purchasing_so/sales_order_edit?sono=' . $r->sono) . '"><i class="fa fa-pencil"></i></a>'; ?>
    <span class="btn btn-danger btn-xs" type="button" data-toggle="modal" title="Delete" data-target="#modal_delete" <?php echo  $disable; ?> onclick="modal_delete('<?php echo $r->sono; ?>')"><span class="fa fa-trash"></span></span>

    <!-- <button data-toggle="modal" title="Delete" style="padding:5px;" data-target="#modal_delete" <?php echo  $disable; ?> class=" btn-danger btn-xs" onclick="modal_delete('<?php echo $r->sono; ?>')"><i class="fa fa-trash fa-xs"></i></button> -->
<?php
    echo '<a type="button" title="Print" class="btn-sm btn-info" href="' . site_url('purchasing_so/sales_order_print?sono=' . $r->sono) . '" target="_blank"><i class="fa fa-print"></i></a>';
    echo '<a type="button" title="Print" class="btn-sm btn-success" href="' . site_url('purchasing_so/proforma_invoice_print?sono=' . $r->sono) . '" target="_blank"><i class="fa fa-print"></i></a>';

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
    echo '<td nowrap>' . $r->lastupdatedby . '</td>';
    echo '<td nowrap>' . $r->lastupdateddate . '</td>';
    echo '</tr>';
}
?>