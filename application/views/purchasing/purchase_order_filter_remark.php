<?php foreach ($po as $r){
    echo '<tr ondblclick="clickdbremark(this)" style="cursor: pointer;">';
        echo '<td nowrap>'.$r->mainpo.'</td>';
        echo '<td nowrap>'.$r->vendorcompany.'</td>';
        echo '<td nowrap>'.$r->custcompany.'</td>';
        echo '<td hidden><textarea>'.str_replace("<br />","",$r->remarks).'</textarea></td>';
    echo '</tr>';
} 
?>