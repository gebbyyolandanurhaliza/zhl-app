<table class="table table-bordered datatables-search" id="table-container-local-factory">
    <thead>
        <tr>
            <th width="10px"></th>
            <!-- <th width="10px"><button class="btn btn-sm btn-primary" type="button" onclick="fnDialogContainerLocalInZHL()"><i class="fa fa-arrow-down"></i></button></th> -->
            <th style="vertical-align: middle;" nowrap>Stuffing</th>
            <th style="vertical-align: middle;" nowrap>Container Type</th>
            <th style="vertical-align: middle;" nowrap>Container Number</th>
            <th style="vertical-align: middle;" nowrap>Suppliser</th>
            <th style="vertical-align: middle;" nowrap>Customer</th>
            <th style="vertical-align: middle;" nowrap>Booking Reff</th>
        </tr>
        <thead>
        <tbody>
            <?php
            $no = 1;
            foreach ($cont_local_ready_in_factory as $key => $s) { ?>
                <tr data-index="<?= $key + 1 ?>">
                    <td align="center"><input type="checkbox" class="chkclassfactory" id="chooseContainer" name="dtl_id_factory[]" value="<?= $s->id ?>"></td>
                    <td><?= $s->stuffing_name; ?></td>
                    <td><?= $s->container_type; ?></td>
                    <td><?= $s->container_number; ?></td>
                    <td><?= $s->supplier_name; ?></td>
                    <td><?= $s->customer_name; ?></td>
                    <td><?= $s->reff_lc; ?></td>
                    <td hidden>
                        <input type="hidden" class="form-control input-sm" name="container_id[]" value="<?php echo $s->container_id; ?>">
                        <input type="hidden" class="form-control input-sm" name="id_local_container_inward[]" value="<?php echo $s->det_id; ?>">
                        <input type="hidden" class="form-control input-sm" name="det_receive[]" value="<?php echo $s->id; ?>">
                    </td>
                </tr>
            <?php
                $no++;
            }
            ?>
        </tbody>
</table>