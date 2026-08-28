<?php
    foreach ($container_name as $r){
    echo '<tr>';echo '<td style="width: 5px;"><input type="checkbox" name="chk[]" onclick="cek_contid(this)" value="'.$r->container_id.'"></td>';
        echo '<td>'.$r->container_id.'</td>';
        echo '<td>'.$r->container_name.'</td>';
        echo '<td>'.$r->container_size.'</td>';
        echo '<td>'.$r->container_abbr.'</td>';
    echo '</tr>';
    }
?>