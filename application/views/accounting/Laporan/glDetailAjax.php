<?php
$bD = 0;
if (!empty($detail_trans)) {
    $begining = str_replace(",", "", $this->input->get("beginning"));

?>

    <table class="table table-bordered " id="tabelin">
        <thead>
            <tr style="position: sticky; top: 0px; background: white;">
                <th width="5%">No COA</th>
                <th width="20%">Invoice Number</th>
                <th width="20%">Supplier Name</th>
                <th width="10%">Date of Journal</th>
                <th width="10%">Check Number</th>
                <th width="20%">Description</th>
                <th width="10%">Debit(LC) </th>
                <th width="10%">Credit(LC) </th>
                <th width="10%">Balance(LC) </th>
                <th width="10%">Debit(FC) </th>
                <th width="10%">Credit(FC) </th>
                <th width="10%">Balance(FC)</th>
            </tr>
        </thead>

        <tbody>
            <?php
            $tDebet = 0;
            $tKredit = 0;
            $tBalance = 0;
            $tDebetSGD = 0;
            $tKreditSGD = 0;
            $tBalanceSGD = 0;
            $saldo = 0;
            foreach ($detail_trans as $s) {
                $tDebet += $s->tmp_debet;
                $tKredit += $s->tmp_kredit;
                $tBalance += $s->tmp_balance;
                $tDebetSGD += $s->tmp_debet_sgd;
                $tKreditSGD += $s->tmp_kredit_sgd;
                $tBalanceSGD += $s->tmp_balance_sgd;
                if ($s->tmp_tanggal == NULL) {
                    $tgl_jurnal = '';
                } else {
                    $tgl_jurnal = date_format(date_create($s->tmp_tanggal), "d F Y");
                }
                $saldo += $s->tmp_debet - $s->tmp_kredit;
                if ($s->tmp_uraian == 'BEGINING BALANCE') {
            ?>
                    <tr style="background-color:#ddd;">
                        <td><?php echo $s->tmp_no_coa . ' ' . $s->tmp_namaakun; ?></td>
                        <td></td>
                        <td><?php echo $s->tmp_nojurnal; ?></td>
                        <td style="text-align:"><?php echo $tgl_jurnal; ?> </td>
                        <td></td>
                        <td><?php echo $s->tmp_uraian; ?></td>
                        <td style="text-align: right"><?php echo str_replace("-", "", number_format($s->tmp_debet, 2, ",", ".")); ?></td>
                        <td style="text-align: right"><?php echo str_replace("-", "", number_format($s->tmp_kredit, 2, ",", ".")); ?></td>
                        <td style="text-align: right"><?php echo str_replace("$", "", money_format('%(#10n', $s->tmp_balance)); ?></td>
                        <td style="text-align: right"><?php echo str_replace("-", "", number_format($s->tmp_debet_sgd, 2, ",", ".")); ?></td>
                        <td style="text-align: right"><?php echo str_replace("-", "", number_format($s->tmp_kredit_sgd, 2, ",", ".")); ?></td>
                        <td style="text-align: right"><?php echo str_replace("$", "", money_format('%(#10n', $s->tmp_balance_sgd)); ?></td>
                    </tr>
                <?php
                } else if ($s->tmp_uraian == 'TOTAL') {
                ?>
                    <tr style="background-color:#ffffcc;">
                        <td></td>
                        <td><?php echo $s->tmp_nojurnal; ?></td>
                        <td></td>
                        <td style="text-align:"><?php echo $tgl_jurnal; ?> </td>
                        <td></td>
                        <td><?php echo $s->tmp_uraian; ?></td>
                        <td style="text-align: right"><?php echo str_replace("-", "", number_format($s->tmp_debet, 2, ",", ".")); ?></td>
                        <td style="text-align: right"><?php echo str_replace("-", "", number_format($s->tmp_kredit, 2, ",", ".")); ?></td>
                        <td style="text-align: right"><?php echo str_replace("$", "", money_format('%(#10n', $s->tmp_balance)); ?></td>
                        <td style="text-align: right"><?php echo str_replace("-", "", number_format($s->tmp_debet_sgd, 2, ",", ".")); ?></td>
                        <td style="text-align: right"><?php echo str_replace("-", "", number_format($s->tmp_kredit_sgd, 2, ",", ".")); ?></td>
                        <td style="text-align: right"><?php echo str_replace("$", "", money_format('%(#10n', $s->tmp_balance_sgd)); ?></td>
                    </tr>
                <?php

                } else if ($s->tmp_uraian != 'TOTAL' || $s->tmp_uraian != 'BEGINING BALANCE') {
                ?>
                    <tr>
                        <td></td>
                        <td><?php echo $s->tmp_nojurnal; ?></td>
                        <td><?php echo $s->tmp_supplier; ?></td>
                        <td style="text-align:"><?php echo $tgl_jurnal; ?> </td>
                        <td><textarea rows="1" cols="80" class="txt"><?php echo $s->tmp_check_bank; ?></textarea></td>
                        <td><textarea rows="1" cols="80" class="txt"><?php echo $s->tmp_uraian; ?></textarea>
                        </td>
                        <td style="text-align: right"><?php echo str_replace("-", "", number_format($s->tmp_debet, 2, ",", ".")); ?></td>
                        <td style="text-align: right"><?php echo str_replace("-", "", number_format($s->tmp_kredit, 2, ",", ".")); ?></td>
                        <td style="text-align: right"><?php echo str_replace("$", "", money_format('%(#10n', $s->tmp_balance)); ?></td>
                        <td style="text-align: right"><?php echo str_replace("-", "", number_format($s->tmp_debet_sgd, 2, ",", ".")); ?></td>
                        <td style="text-align: right"><?php echo str_replace("-", "", number_format($s->tmp_kredit_sgd, 2, ",", ".")); ?></td>
                        <td style="text-align: right"><?php echo str_replace("$", "", money_format('%(#10n', $s->tmp_balance_sgd)); ?></td>
                    </tr>
            <?php
                }
            }
            ?>
        </tbody>
        <tfoot>

        </tfoot>
    </table>
<?php } ?>