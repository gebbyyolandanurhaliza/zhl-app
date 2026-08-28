<?php foreach ($so as $r) {
    $sty = '';
    if ($r->status == 2) {
        $sty = 'success';
    }
    echo '<tr class="' . $sty . '">';
    echo '<td nowrap>';
    echo '<a class="btn-sm btn-warning" title="Edit" href="' . site_url('purchasing_pl/pi_show?sono=' . $r->sono) . '"><i class="fa fa-pencil"></i> choose</a>'; ?>
         <?php
            echo '</td>';
            echo '<td nowrap>' . $r->sono . '</td>';
            echo '<td nowrap>' . date("d-m-Y",  strtotime($r->docdate)) . '</td>';
            echo '<td nowrap>' . date("d-m-Y",  strtotime($r->shipdate)) . '</td>';
            if ($r->status != 1) {
                echo '<td nowrap>Close</td>';
            } else {
                echo '<td nowrap>Open</td>';
            }
            echo '<td nowrap>' . $r->custcompany . '</td>';
            echo '<td nowrap>' . $r->custcontact . '</td>';
           // echo '<td>' . $r->mainpo . '</td>';
            echo '<td nowrap>' . number_format($r->totaldue, 2) . '</td>';
            echo '<td nowrap>' . $r->currency . '</td>';
            echo '<td nowrap>' . $r->createdby . '</td>';
            echo '<td nowrap>' . $r->createddate . '</td>';
            echo '<td nowrap>' . $r->lastupdatedby . '</td>';
            echo '<td nowrap>' . $r->lastupdateddate . '</td>';
            echo '</tr>';
        }
            ?>
