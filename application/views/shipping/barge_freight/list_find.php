<?php
if ($list) {
    foreach ($list as $l) { ?>
        <tr>
            <td class="text-center">
                <a class="btn-sm btn-warning" title="Edit" href="<?= site_url('barge_freight/edit/' . safe_b64encode($l->bargefreight_hdr_id)) ?>"><i class="fa fa-pencil"></i></a>
                <a title="Delete" href="<?= site_url('barge_freight/delete/' . safe_b64encode($l->bargefreight_hdr_id)) ?>" class="btn-sm btn-danger" onclick="return(confirm('Are you sure to delete this data ?'))"><i class="fa fa-trash"></i></a>
                <a class="btn-sm btn-info" title="Print" href="<?= site_url('barge_freight/print_pdf/' . safe_b64encode($l->bargefreight_hdr_id)) ?>" target="_blank"><i class="fa fa-print"></i></a>
            </td class="text-center">
            <td class="text-center"><?= tgl_dmy_strip($l->ship_board_date); ?></td>
            <?php
            $costumer = $this->m_barge_freight->get_cust_row($l->customer_id);
            ?>
            <td class="text-center"><?= $costumer->customer_name; ?></td>
            <?php
            $vessel_x = explode("/", $l->vesel);
            $voyage_x = explode("/", $l->voyage_no);

            $vessel_amount = count($vessel_x);

            if ($vessel_amount == 3) {
                $v = $vessel_x[0] . ' / ' . $voyage_x[0] . ' / ' . $vessel_x[1] . ' / ' . $voyage_x[1] . ' / ' . $vessel_x[2] . ' / ' . $voyage_x[2];
            } else if ($vessel_amount == 2) {
                $v = $vessel_x[0] . ' / ' . $voyage_x[0] . ' / ' . $vessel_x[1] . ' / ' . $voyage_x[1];
            } else {
                $v = $l->vesel . '/' . $l->voyage_no;
            }
            ?>
            <td class="text-center"><?= $v ?></td>
            <td class="text-center"><?= $l->port_of_load; ?></td>
        </tr>
<?php
    }
} else {
    echo '0';
}
?>