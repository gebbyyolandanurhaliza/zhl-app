<div class="table-responsive">
    <table id="tbl-selectAP" class="table table-striped table-hover">
        <thead>
            <tr>
                <th>AP Number</th>
                <th>AP Date</th>
                <th>Supplier Code</th>
                <th>Supplier Name</th>
                <th>Currency</th>
                <th>Amount</th>
                <th>Rate</th>
                <th>toUSD</th>
                <th>Remark</th>
                <th>SuppCOA</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($_selectAP as $row): ?>
            <tr onclick="Pilih_AP(this)">
                <td><?php echo $row->NomorAP;?></td>
                <td><?php echo $row->Tanggal;?></td>
                <td><?php echo $row->SupplierID;?></td>
                <td><?php echo $row->suppliercompany;?></td>
                <td><?php echo $row->CurrencyID;?></td>
                <td class="text-right"><?php echo number_format($row->AmountPerAP, 6);?></td>
                <td class="text-right"><?php echo number_format($row->rate_header, 6);?></td>
                <td class="text-right"><?php echo number_format($row->AmountPerAP*$row->rate_header, 6);?></td>
                <td><?php echo $row->Remarks;?></td>
                <td><?php echo $row->nocoa;?></td>
            </tr>
            <?php endforeach;?>
        </tbody>
    </table>
</div>

<script>
    $(document).ready(function() {
        $("#tbl-selectAP").dataTable();
    });
</script>