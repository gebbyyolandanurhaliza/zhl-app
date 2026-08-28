<?php
if ($data_hdr) {
    $no = 1;
    foreach ($data_hdr as $hdr) {    ?>
        <tr>
            <td colspan="4" style='text-align:left;font-weight:bold;background-color:#ddd;'>
                <p>Destination : <?= $hdr->destination_name ?> </p>
                <p>Destination Type : <?= $hdr->destination_type_name ?> </p>
                <p>Container Name : <?= $hdr->container_name ?> </p>
                <p>Container Type: <?= $hdr->con_type_name ?> </p>
            </td>
        </tr>
        <?php
        $data_dtl = $this->barge_freight_model->get_dtl($hdr->barge_freight_hdr_id);
        if ($data_dtl) {
            foreach ($data_dtl as $dtl) { ?>
                <tr>
                    <td width="80">
                        <a class="btn-sm btn-warning" href="<?= site_url('Master_barge_freight/edit/' . $hdr->barge_freight_hdr_id) ?>"><i class="fa fa-pencil"></i></a>
                        <a class="btn-sm btn-danger" href="<?= site_url('Master_barge_freight/delete_dtl/' . $dtl->barge_freight_dtl_id) ?>" onclick="return confirm('Are you sure to delete this ?')"><i class="fa fa-trash"></i></a>
                    </td>
                    <td><?= $dtl->desc_nama ?></td>
                    <td><?= $dtl->unit_price ?></td>
                    <td><?= $dtl->freight_per_mt ?></td>
                </tr>
<?php
            }
        }
    }
}

?>