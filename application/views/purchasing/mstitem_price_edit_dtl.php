<?php  
        $supplier='';
        $i=0;
        $x=0;
        foreach ($item_price as $r){
           if ($supplier != $r->supplierid) {
               $i++;
               $x=$i;
            echo '<tr class="treegrid-'.$i.'" style="cursor: pointer;">';
                echo '<td colspan="15">  '.$r->suppliercompany.'  </td>';
            echo '</tr>';
        $i++;
        }
        
        echo '<tr class="treegrid-'.$i++.' treegrid-parent-'.$x.'" style="cursor: pointer;">';
            echo '<td nowrap>';
                echo '<a class="btn-sm btn-warning" href="'.site_url('purchasing/item_price_edit?vendor='.$r->supplierid.'&item='.$r->itemid).'"><i class="fa fa-pencil"></i></a>';?>
                <a class="btn-sm btn-danger" href="<?php echo site_url('purchasing/item_price_delete?vendor='.$r->supplierid.'&item='.$r->itemid);?>" onclick="javasciprt: return confirm('Are you sure delete Item <?php echo $r->itemname;?> ?')"><i class="fa fa-trash"></i></a>
            <?php echo '</td>';
            echo '<td nowrap>'.$r->itemid.'</td>';
            echo '<td nowrap>'.htmlspecialchars($r->itemname,ENT_QUOTES).'</td>';
            echo '<td nowrap>'.$r->pmcode.'</td>';
            echo '<td nowrap>'.$r->uomname.'</td>';
            echo '<td nowrap>'.number_format($r->qnty,2).'</td>';
            echo '<td nowrap>'.number_format($r->unitprice,4).'</td>';
            echo '<td nowrap>'.$r->currencyid.'</td>';
            echo '<td nowrap>'.$r->createdby.'</td>';
            echo '<td nowrap>'.$r->createddate.'</td>';
            echo '<td nowrap>'.$r->lastupdatedby.'</td>';
            echo '<td nowrap>'.$r->lastupdateddate.'</td>';
        echo '</tr>';
        
        $supplier=$r->supplierid;
    }
?>