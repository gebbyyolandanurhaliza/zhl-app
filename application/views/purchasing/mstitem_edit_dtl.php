<?php foreach ($item as $r){
    echo '<tr style="cursor: pointer;">';
        echo '<td nowrap>';
            echo '<a class="btn-sm btn-warning" href="'.site_url('purchasing/item_edit?item='.$r->itemid).'"><i class="fa fa-pencil"></i></a>';?>
            <a class="btn-sm btn-danger" href="<?php echo site_url('purchasing/item_delete?item='.$r->itemid);?>" onclick="javasciprt: return confirm('Are you sure delete Item <?php echo $r->itemname;?> ?')"><i class="fa fa-trash"></i></a>
        <?php echo '</td>';
        echo '<td nowrap>'.$r->itemid.'</td>';
        echo '<td nowrap>'.htmlspecialchars($r->itemname,ENT_QUOTES).'</td>';
        echo '<td nowrap>'.$r->categoryname.'</td>';
        echo '<td nowrap>'.$r->categorysubname.'</td>';
        echo '<td nowrap>'.$r->uomname.'</td>';
        echo '<td nowrap>'.$r->country_name.'</td>';
        echo '<td nowrap>'.$r->pmcode.'</td>';
        echo '<td nowrap>'.$r->hscode.'</td>';
        echo '<td nowrap>'.$r->itemremark.'</td>';
        echo '<td nowrap>'.$r->idcwp1.'</td>';
        echo '<td nowrap>'.$r->idcwp2.'</td>';
        echo '<td nowrap>'.$r->idcwp3.'</td>';
        echo '<td nowrap>'.$r->createdby.'</td>';
        echo '<td nowrap>'.$r->createddate.'</td>';
        echo '<td nowrap>'.$r->lastupdatedby.'</td>';
        echo '<td nowrap>'.$r->lastupdateddate.'</td>';
    echo '</tr>';
}
?>