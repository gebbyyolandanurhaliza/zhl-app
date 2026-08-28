<?php foreach ($gr as $r) {
    // $doStatus = (int)number_format($r->qty_outstanding, 0) > 0 ? "Open" : "Closed";
    $sty = '';
    $disable = '';
    if ($r->status == 2) {
        $sty = 'success';
        $disable = 'disabled';
    } else if ($r->status == 3) {
        $sty = 'danger';
        $disable = '';
    } else if ($r->status_gr == 'OUT') {
        $disable = 'disabled';
    }
    echo '<tr class="' . $sty . '">';
    echo '<td nowrap>';
    echo '<a class="btn-sm btn-warning" title="Edit" href="' . site_url('purchasing_gr/good_receipt_edit?gr=' . $r->docno) . '"><i class="fa fa-pencil"></i></a>'; ?>
    <button data-toggle="modal" title="Delete" data-target="#modal_delete" style="padding:7px;" class="btn-sm btn-danger" <?php echo  $disable; ?> onclick="modal_delete('<?php echo $r->docno; ?>')"><i class="fa fa-trash"></i></button>


<?php
    echo '<a type="button" title="Print" class="btn-sm btn-info" href="' . site_url('purchasing_gr/print_report_gr?gr=' . $r->docno) . '" target="_blank"><i class="fa fa-print"></i></a>';
    echo '</td>';
    echo '<td nowrap>' . date("d-m-Y",  strtotime($r->docdate)) . '</td>';
    echo '<td nowrap>' . date("d-m-Y",  strtotime($r->duedate)) . '</td>';
    if ($r->status == 2) {
        echo '<td nowrap>Closed</td>';
    } else if ($r->status == 3) {
        echo '<td nowrap>Cancel</td>';
    } else {
        echo '<td nowrap>Open</td>';
    }
    // echo '<td nowrap>' .  $doStatus . '</td>';
    echo '<td nowrap>' . $r->docno . '</td>';
    echo '<td nowrap>' . $r->mainpo . '</td>';
    echo '<td nowrap>' . $r->itemid . '</td>';
    echo '<td nowrap>' . htmlspecialchars($r->itemname, ENT_QUOTES) . '</td>';
    echo '<td nowrap>' . number_format($r->qtypo, 2) . '</td>';
    echo '<td nowrap>' . number_format($r->qtywhs, 2) . '</td>';
    echo '<td nowrap>' . $r->vendorcompany . '</td>';
    echo '<td nowrap>' . $r->vendorcontact . '</td>';
    echo '<td nowrap hidden>' . $r->custcompanybyorder . '</td>';
    echo '<td nowrap>' . $r->createdby . '</td>';
    echo '<td nowrap>' . $r->createddate . '</td>';
    echo '<td nowrap>' . $r->lastupdatedby . '</td>';
    echo '<td nowrap>' . $r->lastupdateddate . '</td>';
    echo '</tr>';
} ?>