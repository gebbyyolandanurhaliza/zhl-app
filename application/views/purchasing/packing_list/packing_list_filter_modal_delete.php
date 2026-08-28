<?php
foreach ($pl as $r) {
    $docdate =  date("d-m-Y",  strtotime($r->docdate));
    $custname =  $r->custcompany;
    $mainpo =  $r->mainpo;
    $sono =  $r->sono;
}
?>

<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-body">
            <table cellspacing="0" style="width: 100%;">
                <tr>
                    <td style="width: 35%;">
                        <table cellspacing="0" style="width: 100%;">
                            <tr>
                                <td style="width: 10%;">Main PO</td>
                                <td style="width: 50%;"> : <?php echo $mainpo; ?></td>
                            </tr>
                            <tr>
                                <td style="width: 10%;">Date</td>
                                <td style="width: 50%;"> : <?php echo $docdate; ?></td>
                            </tr>
                            <tr>
                                <td style="width: 10%;">Customer</td>
                                <td style="width: 50%;"> : <?php echo $custname; ?></td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            <hr>

            <div class="v-scroll">
                <table class="table table-condensed table-hover table-fixed">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>ItemID</th>
                            <th>ItemName</th>
                            <th>UOM</th>
                            <th>Qty</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        foreach ($pl as $r) {
                            echo '<tr>';
                            echo '<td>' . $i . '</td>';
                            echo '<td>' . $r->itemid . '</td>';
                            echo '<td>' . htmlspecialchars($r->descriptions, ENT_QUOTES) . '</td>';
                            echo '<td>' . $r->uomname . '</td>';
                            echo '<td>' . number_format($r->qty, 2) . '</td>';
                            echo '</tr>';
                            $i++;
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="modal-footer">
            <a class="btn btn-danger" href="<?php echo site_url('purchasing_pl/packing_list_delete?pl=' . $sono); ?>" onclick="javasciprt: return confirm('Are you sure delete PL <?php echo $sono; ?> ?')">Delete</a>
            <button type="button" data-dismiss="modal" class="btn btn-default">Cancel</button>
        </div>
    </div>
</div>