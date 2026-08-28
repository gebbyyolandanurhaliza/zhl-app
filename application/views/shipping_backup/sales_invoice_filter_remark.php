<?php foreach ($inv as $r){
    echo '<tr ondblclick="clickdbremark(this)" style="cursor: pointer;">';
        echo '<td nowrap>'.$r->invno.'</td>';
        echo '<td nowrap>'.$r->custid.'</td>';
        echo '<td nowrap>'.$r->custcompany.'</td>';
        echo '<td hidden><textarea>'.str_replace("<br />","",$r->remark).'</textarea></td>';
    echo '</tr>';
} 
?>