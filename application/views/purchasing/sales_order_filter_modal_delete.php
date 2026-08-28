<?php
foreach ($so as $r) {
    $name =  $r->custcompany;
    $currency =  $r->currency;
    $status =  $r->status;

    if ($status != '1') {
        $status = 'Close';
    } else {
        $status = 'Open';
    }

    $docdate =  date("d-m-Y",  strtotime($r->docdate));
    $sono =  $r->sono;
}
?>

<div class="modal-dialog modal-lg">
    <form action="<?php echo site_url('purchasing_so/sales_order_delete'); ?>" method="post" class="form-horizontal" role="form">
        <div class="modal-content">
            <div class="modal-body">
                <input type="hidden" class="form-control input-sm" name="sono" value="<?php echo $sono; ?>" readonly>
                <table cellspacing="0" style="width: 100%;">
                    <tr>
                        <td style="width: 35%;">
                            <table cellspacing="0" style="width: 100%;">
                                <tr>
                                    <td style="width: 10%;">SO No</td>
                                    <td style="width: 50%;"> : <?php echo $sono; ?></td>
                                </tr>
                                <tr>
                                    <td style="width: 10%;">Date</td>
                                    <td style="width: 50%;"> : <?php echo $docdate; ?></td>
                                </tr>
                                <tr>
                                    <td style="width: 10%;">Status</td>
                                    <td style="width: 50%;"> : <?php echo $status; ?></td>
                                </tr>
                                <tr>
                                    <td style="width: 10%;">Customer</td>
                                    <td style="width: 50%;"> : <?php echo $name; ?></td>
                                </tr>
                                <tr>
                                    <td style="width: 10%;">Currency</td>
                                    <td style="width: 50%;"> : <?php echo $currency; ?></td>
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
                                <th>Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            foreach ($so as $r) { ?>

                                <tr>
                                    <td><input type="" name="MainPO[]" value="<?php echo $r->mainpo; ?>"><?php echo $i++; ?></td>
                                    <td><input type="" name="ItemID[]" value="<?php echo $r->itemid; ?>"><?php echo $r->itemid; ?></td>
                                    <td><?php echo htmlspecialchars($r->itemname, ENT_QUOTES); ?></td>
                                    <td><?php echo $r->uomname; ?></td>
                                    <td><input type="" name="Docno_Gr[]" value="<?php echo $r->docno_gr; ?>"><?php echo number_format($r->qty, 2); ?></td>
                                    <td><?php echo number_format($r->unitprice, 2); ?></td>

                                </tr>


                            <?php  } ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="col-md-2 btn btn-danger right">Delete</button>
                <!-- <a class="btn btn-danger" href="<?php echo site_url('purchasing_so/sales_order_delete?sono=' . $sono); ?>" onclick="javasciprt: return confirm('Are you sure delete SO <?php echo $sono; ?> ?')">Delete</a> -->
                <button type="button" data-dismiss="modal" class="btn btn-default">Cancel</button>
            </div>
        </div>
</div>