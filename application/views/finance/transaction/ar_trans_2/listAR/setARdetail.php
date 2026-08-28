<table class="success" style="width: 100%; background-color: transparent; border: none;">
    <thead>
        <tr>
            <th>No. Invoice</th>
            <th>Rate</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody >
        <?php foreach ($_selectARdetailAc as $r): ?>
        <tr>
            <td><?php echo $r->NoInvoice;?></td>
            <td class="text-right" style="width: 15%;"><?php echo $r->Rate;?></td>
            <td class="text-right" style="width: 15%;"><?php echo $r->Total;?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<table style="width: 100%; background-color: transparent; border: none;">
    <thead>
        <tr>
            <th style="width: 10%;">Account Number</th>
            <th style="width: 20%;">Name</th>
            <th style="width: 10%;">Debit</th>
            <th style="width: 10%;">Credit</th>
            <th>Remark</th>
            <th style="width: 10%;">GST Name</th>
            <th style="width: 10%;">GST Value</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($_selectARjurnal as $j): ?>
        <tr>
            <td><?php echo $j->coa;?></td>
            <td><?php echo $j->coa_description;?></td>
            <td class="text-right"><?php echo number_format($j->debit,2);?></td>
            <td class="text-right"><?php echo number_format($j->credit,2);?></td>
            <td><?php echo $j->remark;?></td>
            <td><?php echo $j->gst_type;?></td>
            <td class="text-right"><?php echo number_format($j->gst_value,2);?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<!-- <table style="width: 100%; background-color: transparent; border: none;">
    <thead>
        <tr>
            <th>Remark</th>
            <th>COA Number</th>
            <th>Currency</th>
            <th>Rate</th>
            <th>[<?php //echo $_currBayar;?>]Equivalent</th>
            <th>[USD]Equivalent</th>
            <th>Amount</th>
        </tr>
    </thead>
    <tbody>
        <?php //foreach ($_selectARdetail as $row): ?>
        <tr>
            <td><?php //echo $row->remark;?></td>
            <td><?php //echo $row->no_coa;?></td>
            <td class="text-center"><?php //echo $row->currency_id;?></td>
            <td class="text-right"><?php //echo number_format($row->rate_currency, 2);?></td>
            <td class="text-right"><?php //echo number_format($row->cur_equi, 2);?></td>
            <td class="text-right"><?php //echo number_format($row->usd_equi, 2);?></td>
            <td class="text-right"><?php //echo number_format($row->amount, 2);?></td>
        </tr>
        <?php //endforeach; ?>
    </tbody>
</table> -->
