<?php foreach ($do as $r){
    echo '<tr>';
        echo '<td nowrap>';
            echo '<a class="btn-sm btn-warning" title="Edit" href="'.site_url('Packing_do/delivery_oder_show?do='.$r->docno).'"><i class="fa fa-pencil"></i></a>'; ?>
            <a data-toggle="modal" title="Delete" data-target="#modal_delete" class="btn-sm btn-danger" onclick="modal_delete('<?php echo $r->docno;?>')"><i class="fa fa-trash"></i></a>
        <?php echo '</td>';
        echo '<td nowrap>'.date("d-m-Y",  strtotime($r->docdate)).'</td>';
        echo '<td nowrap>'.date("d-m-Y",  strtotime($r->duedate)).'</td>';
        echo '<td nowrap>'.$r->mainpo.'</td>';
        echo '<td nowrap>'.$r->itemid.'</td>';
        echo '<td nowrap>'.htmlspecialchars($r->itemname,ENT_QUOTES).'</td>';
        echo '<td nowrap>'.number_format($r->qtywhs,3).'</td>';
        echo '<td nowrap>'.number_format($r->qtyout,3).'</td>';
        echo '<td nowrap>'.$r->vendorcompany.'</td>';
        echo '<td nowrap>'.$r->vendorcontact.'</td>';
        echo '<td nowrap>'.$r->custcompanybyorder.'</td>';
        echo '<td nowrap>'.$r->createdby.'</td>';
        echo '<td nowrap>'.$r->createddate.'</td>';
        echo '<td nowrap>'.$r->lastupdatedby.'</td>';
        echo '<td nowrap>'.$r->lastupdateddate.'</td>';
    echo '</tr>';
} ?>