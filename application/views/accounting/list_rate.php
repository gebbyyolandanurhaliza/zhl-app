<table class="table table-bordered" id="table_create">
    <thead>
        <tr>
            <th>Currency Symbol</th>
            <th>Rate USD</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if (!empty($get_currency)) {
            foreach ($get_currency as $c) {
                ?>
                <tr>
                    <td>
                        <input type="hidden" name="date_posting" value="<?php echo $this->session->userdata('periode_1'); ?>" class="txt" />
                        <input type="hidden" name="currency_name[]" value="<?php echo $c->currency_name ?>" class="txt" />
                        <input type="text" name="currency_simbol[]" value="<?php echo strtoupper($c->currency_id) ?>" class="txt" readonly />
                    </td>
                    <td class="text-right">
                        <input type="text" name="txtKurs[]" class="txt number" value="<?php echo number_format($c->rate_usd, 6, '.', ''); ?>" required />
                    </td>
                </tr>
                <?php
            }
        }
        ?>


    </tbody>
</table> 