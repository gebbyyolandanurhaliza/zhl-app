<?php foreach ($inv as $r){
    echo '<tr style="cursor: pointer;">';
        echo '<td>'.$r->invno.'</td>';
        echo '<td nowrap>'.$r->custid.'</td>';
        echo '<td nowrap>'.$r->custcompany.'</td>';
        echo '<td hidden><textarea>'.str_replace("<br />","",$r->paymentto).'</textarea></td>';
    echo '</tr>';
} 
?>
