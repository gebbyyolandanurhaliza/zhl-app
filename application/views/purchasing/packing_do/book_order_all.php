<?php foreach ($book as $r){
    echo '<tr >';
        echo '<td nowrap>';
            echo '<a class="btn-sm btn-warning" title="Edit" href="'.site_url('Packing_do/book_order_show?bookref_no='.$r->bookref_no).'"><i class="fa fa-pencil"></i></a>'; ?>
            <a data-toggle="modal" title="Delete" data-target="#modal_delete" class="btn-sm btn-danger" onclick="modal_delete('<?php echo $r->bookref_no;?>')"><i class="fa fa-trash"></i></a>
        <?php 
             echo '<a type="button" title="Print" class="btn-sm btn-info" href="'.site_url('Packing_do/book_order_excel?bookref_no='.$r->bookref_no.'&cust='.$r->custid).'" target="_blank"><i class="fa fa-file-excel-o"></i></a>';
        echo '</td>';
        echo '<td nowrap>'.$r->bookref_no.'</td>';
        echo '<td nowrap>'.$r->custid.'</td>';
        echo '<td nowrap>'.date("d-m-Y",  strtotime($r->etd)).'</td>';
        echo '<td nowrap>'.$r->barge.'</td>';
        echo '<td nowrap>'.$r->voyage.'</td>';
        echo '<td nowrap>'. $r->createdby.'</td>';
        echo '<td nowrap>'. $r->createddate.'</td>';
        echo '<td nowrap>'. $r->lastupdatedby.'</td>';
        echo '<td nowrap>'. $r->lastupdateddate.'</td>';
    echo '</tr>';
} 
?>
