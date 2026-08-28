<?php 
    echo '<option value=""></option>';
    foreach ($groupsub as $r) {
        echo '<option value="'.$r->categorysubid.'">'.$r->categorysubname.'</option>';
    }

