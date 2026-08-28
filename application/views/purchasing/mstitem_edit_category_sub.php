<?php
    echo '<option value="">Select</option>';
    foreach ($groupsub as $r) {
            echo '<option value="'.$r->categorysubid.'">'.$r->categorysubname.'</option>';
    }
           
?>