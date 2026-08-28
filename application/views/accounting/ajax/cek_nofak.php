<?php

if (!empty($nofak)) {
    foreach ($nofak as $v) {
        $no = $v->nofaktur;
        echo "$no";
    }
} else {
    echo "1";
}