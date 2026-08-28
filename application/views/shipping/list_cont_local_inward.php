<table class="table table-bordered tb-data" style="margin-bottom: 1px;">
    <thead>
        <tr style="position: sticky; top: -8px; background-color: #808080;">
            <!-- <th style="width: 1px; text-align: center;"><input type="checkbox" id="togglecheck"></th> -->
            <th class="w-200" style="text-align: left;">Stuffing</th>
            <th class="w-200" style="text-align: left;">Container Type</th>
            <th class="w-200" style="text-align: left;">Container Number</th>
            <th class="w-200" style="text-align: left;">Supplier</th>
            <th class="w-200" style="text-align: left;">Booking Reff</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($localContInward as $receipt) :
        ?>
            <tr style="background-color : <?= $receipt['is_outward'] == 1 ? "#F0E68C" : "" ?>">

                <td><?= $receipt->stuufing ?></td>
                <td><?= $receipt->container_type ?></td>
                <td><?= $receipt->container_number ?></td>
                <td><?= $receipt->supplier ?></td>
                <td><?= $receipt->customer ?></td>
                <td><?= $receipt->reff ?></td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>