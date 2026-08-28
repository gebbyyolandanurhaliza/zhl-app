<table class="table table-bordered table-last-import" id="tabel table-last-import">
    <thead>
        <th width="1%"></th>
        <th width="20%">Shipment Date</th>
        <th width="10%">Barge</th>
        <th width="10%">Voyage</th>
        <th width="20%">ETD</th>
        <th width="5%">ETD DATE</th>
        <th width="10%">ETA</th>
        <th width="10%">ETA DATE</th>
        <th width="5%">FROM</th>
        <th width="5%">TO</th>
        <th width="5%">Created By</th>

    </thead>
    <tbody>
        <?php
        if (!empty($list_import)) {
            // Membuat array asosiatif kosong untuk menyimpan objek-objek unik berdasarkan customer
            $unique_customers = array();

            // Melakukan iterasi untuk setiap objek pada $list_import
            foreach ($list_import as $item) {
                // Jika customer belum pernah muncul sebelumnya, tambahkan objek ke dalam array $unique_customers
                if (!isset($unique_customers[$item->customer])) {
                    $unique_customers[$item->customer] = array();
                }
                array_push($unique_customers[$item->customer], $item);
            }

            // Melakukan iterasi untuk setiap customer yang muncul
            foreach ($unique_customers as $customer => $objects) {
        ?>
                <tr>
                    <td style="background-color: darkslategrey; color:white; padding-left: 30px" colspan="12"><?= strtoupper(strtolower($customer)) . ' ( ' . $objects[0]->customer_code . ' )' ?></td>
                </tr>
                <?php foreach ($objects as $item) : ?>
                    <tr onclick="pilih(this, <?= $item->contid; ?>)" style="cursor: pointer;">
                        <td hidden><?= $item->contid; ?></td>
                        <td style="padding-left: 50px;"><span class="badge badge-<?= $item->tipe == 1 ? "primary" : "danger" ?>"><?= getInOutward($item->tipe) ?></span> </td>
                        <td><?= setDateFormat($item->shipmentdate, "d/m/Y"); ?></td>
                        <td><?= $item->barge; ?></td>
                        <td style=" text-align: center"><?= $item->voyage; ?></td>
                        <td style="text-align: center"><?= $item->etd; ?></td>
                        <td style="text-align: center"><?= setDateFormat($item->etddate, 'd/m/Y'); ?></td>
                        <td><?= $item->eta; ?></td>
                        <td><?= setDateFormat($item->etadate, 'd/m/Y'); ?></td>
                        <td><?= $item->from; ?></td>
                        <td><?= $item->to; ?></td>
                        <td><?= $item->createdby . " : " . setDateFormat($item->createddate, 'd/m/Y H:i:s'); ?></td>
                    </tr>
                <?php endforeach ?>
        <?php
            }
        }
        ?>



</table>