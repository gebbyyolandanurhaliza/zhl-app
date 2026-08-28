<?php foreach ($item as $r){
    echo '<tr style="cursor: pointer;">';
        echo '<td nowrap>';
            echo '<a class="btn-sm btn-blue" href="'.site_url('purchasing/item_factory_edit?item='.$r->itemid).'"><i class="fa fa-eye"></i></a>';?>
        <?php echo '</td>';
        echo '<td nowrap>'.$r->itemid.'</td>';
        echo '<td nowrap>'.htmlspecialchars($r->itemname,ENT_QUOTES).'</td>';
        echo '<td nowrap>'.$r->categoryname.'</td>';
        echo '<td nowrap>'.$r->categorysubname.'</td>';
        echo '<td nowrap>'.$r->uomname.'</td>';
        echo '<td nowrap>'.$r->idcwp1.'</td>';
        echo '<td nowrap>'.$r->idcwp2.'</td>';
        echo '<td nowrap>'.$r->idcwp3.'</td>';
        echo '<td nowrap>'.$r->updateditemby.'</td>';
        echo '<td nowrap>'.$r->updateditemdate.'</td>';
    echo '</tr>';
}
?>