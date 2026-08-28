<?php foreach ($po as $r) {
    $sty = '';
    $disable = '';
    if ($r->status == 2) {
        $sty = 'success';
        $disable = 'disabled';
    } else if ($r->status == 3) {
        $sty = 'danger';
        $disable = '';
    } else if ($r->pur_status == 'IN') {
        $disable = 'disabled';
    } else {
        $disable = '';
    }
    echo '<tr class="' . $sty . '">';
    echo '<td nowrap>';
    echo '<a class="btn-sm btn-primary" title="Edit" href="' . site_url('purchasing_po/purchase_order_edit?po=' . $r->mainpo) . '"><i class="fa fa-pencil"></i></a>'; ?>
    <span class="btn btn-danger btn-xs" type="button" data-toggle="modal" title="Delete" data-target="#modal_delete" <?php echo  $disable; ?> onclick="modal_delete('<?php echo $r->mainpo; ?>')"><span class="fa fa-trash"></span></span>
    <a class="btn-sm btn-warning" title="Cancel" <?php echo  $disable; ?> href="<?php echo site_url('purchasing_po/purchase_order_cancel?po=' . $r->mainpo); ?>"><i class="fa fa-history"></i></a>
    <!-- <a class="btn-sm btn-default" title="Copy" href="<?php echo site_url('purchasing_po/purchase_order_edit_copy?po=' . $r->mainpo); ?>"><i class="fa fa-copy"></i></a> -->
<?php
    echo '<a class="btn-sm btn-info" title="Print" href="' . site_url('purchasing_po/purchase_order_print?po=' . $r->mainpo) . '" target="_blank"><i class="fa fa-print"></i></a>';
    echo '</td>';
    echo '<td nowrap>' . $r->mainpo . '</td>';
    echo '<td nowrap>' . date("d-m-Y",  strtotime($r->docdate)) . '</td>';
    echo '<td nowrap>' . date("d-m-Y",  strtotime($r->shipdate)) . '</td>';
    if ($r->status == 2) {
        echo '<td nowrap>Close</td>';
    } else if ($r->status == 3) {
        echo '<td nowrap>Cancel</td>';
    } else {
        echo '<td nowrap>Open</td>';
    }
    echo '<td nowrap>' . $r->vendorcompany . '</td>';
    echo '<td nowrap>' . $r->vendorcontact . '</td>';
    echo '<td nowrap>' . $r->custcompany . '</td>';
    echo '<td nowrap right>' . number_format($r->totaldue, 2) . '</td>';
    echo '<td nowrap>' . $r->currency . '</td>';
    echo '<td nowrap>' . $r->createdby . '</td>';
    echo '<td nowrap>' . $r->createddate . '</td>';
    echo '<td nowrap>' . $r->lastupdatedby . '</td>';
    echo '<td nowrap>' . $r->lastupdateddate . '</td>';
    echo '</tr>';
}
?>