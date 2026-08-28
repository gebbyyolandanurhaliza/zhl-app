<table class="table table-bordered tb-data" style="margin-bottom: 1px;">
    <thead>
        <tr style="position: sticky; top: -8px; background-color: #808080;">
            <!-- <th style="width: 1px; text-align: center;"><input type="checkbox" id="togglecheck"></th> -->
            <th class="w-200" style="text-align: left;">Stuffing</th>
            <th class="w-200" style="text-align: left;">Container Type</th>
            <th class="w-200" style="text-align: left;">Container Number</th>
            <!-- <th class="w-150" style="text-align: center;">Received</th> -->
            <!-- <th class="w-150" style="text-align: center;">Status Stuffing</th> -->
            <th class="w-150" style="text-align: center;">Remarks</th>
            <!-- <th class="w-150" style="text-align: center;">Received By</th> -->
            <!-- <th class="w-150" style="text-align: center;">Received Date</th> -->
        </tr>
    </thead>
    <tbody id='filtered_table'>
        <?php foreach ($listContainer as $item) :
            $location = "";
            if ($item['eta'] == "PSG") {
                $location = 'PT. Pulau Sambu Guntung';
            } elseif ($item['eta'] == "RSUP") {
                $location = "PT. Riau Sakti United Plantations";
            } elseif ($item['eta' == "STI"]) {
                $location = "Sumatra Timur Indonesia";
            } elseif ($item['eta']  == "SINGAPORE") {
                $location = "ZHL Singapore";
            }

            if ($item['etd'] == "PSG") {
                $location2 = 'PT. Pulau Sambu Guntung';
            } elseif ($item['etd'] == "RSUP") {
                $location2 = "PT. Riau Sakti United Plantations";
            } elseif ($item['etd' == "STI"]) {
                $location2 = "Sumatra Timur Indonesia";
            } elseif ($item['etd']  == "SINGAPORE") {
                $location2 = "ZHL Singapore";
            }
        ?>
            <?php if (count($item['det_local']) > 0) { ?>
                <tr style="position: sticky; top: 20px; background-color: #808080;">
                    <td colspan="8" style="background-color: #2F4F4F; color: white; font-weight:bold;">
                        <input type="checkbox" id="togglecheck" name="factory_id[]" value="<?= $item['eta'] ?>" style="margin-left: 40px; margin-right: 10px;"> <?= $location2 . " - " . $location . " ( " . date('d/m/Y', strtotime($item['shipmentdate'])) . " ) " ?>
                    </td>
                </tr>
                <?php foreach ($item['det_local'] as $receipt) :
                    $badge = $receipt['is_received'] == true ? "success" : "danger";
                ?>
                    <tr style="background-color : <?= $receipt['is_ready_in_zhl'] == 0 ? "#F0E68C" : "" ?>">
                        <td>
                            <span style="margin-left: 30px;">
                                <input type="checkbox" id="containerNumber" name="container_number[]" value="<?= $receipt['container_number'] ?>" style="margin-left: 40px; margin-right: 10px;" data-received="<?= $receipt['id_received'] ?>" data-local="<?= $receipt['id_cont_local'] ?>" <?= $receipt['is_ready_in_zhl'] == 0 ? "disabled" : "" ?>>
                                <?= $receipt['stuffing_name'] ?>

                        </td>
                        <td><?= $receipt['container_type'] ?></td>
                        <td colspan=" 1"><?= $receipt['container_number'] ?></span></td>
                        <td align="center">
                            <!-- <span class="badge badge-<?= $badge ?>"><?= $receipt['status_received'] ?></span> -->
                        </td>
                        <td align="center">
                            <!-- <span style="font-weight: bold;"><?= $receipt['status_stuffing_name'] ?></span> -->
                        </td>
                        <!-- <td style="color: red;"><?= $receipt['is_outward_name'] ?></td> -->
                        <!-- <td><?= $receipt['receive_by'] ?></td> -->
                        <!-- <td><?= $receipt['receive_date'] != "" ? date("d F Y H:i:s", strtotime($receipt['receive_date'])) : ""  ?></td> -->
                    </tr>
                <?php endforeach ?>
            <?php } ?>
        <?php endforeach ?>
    </tbody>
</table>